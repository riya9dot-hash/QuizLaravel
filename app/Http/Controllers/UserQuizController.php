<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use App\Models\QuizAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    /**
     * Display a listing of available quiz categories for normal users.
     * Now shows only assigned quizzes.
     */
    public function index()
    {
        // Get user's brand IDs
        $userBrandIds = Auth::user()->brands->pluck('id')->toArray();

        // Get all assignments for the current user, filtered by brand
        $assignments = QuizAssignment::where('user_id', Auth::id())
            ->with(['category.brands', 'quiz'])
            ->where(function($query) use ($userBrandIds) {
                if (!empty($userBrandIds)) {
                    // Check if category has any of the user's brands (using pivot table)
                    $query->whereHas('category.brands', function($q) use ($userBrandIds) {
                        $q->whereIn('brands.id', $userBrandIds);
                    })
                    ->orWhereHas('quiz', function($q) use ($userBrandIds) {
                        $q->whereIn('brand_id', $userBrandIds);
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Separate category assignments and individual quiz assignments
        $categoryAssignments = $assignments->whereNotNull('category_id');
        $quizAssignments = $assignments->whereNotNull('quiz_id');

        // Get unique categories from assignments
        $assignedCategories = $categoryAssignments->pluck('category')->filter()->unique('id');

        // Get categories with assignment info
        $categories = $assignedCategories->map(function($category) use ($categoryAssignments) {
            $assignment = $categoryAssignments->where('category_id', $category->id)->first();
            
            // Get completed session for this category
            $completedSession = QuizSession::where('user_id', Auth::id())
                ->where('category_id', $category->id)
                ->where('completed', true)
                ->latest()
                ->first();
            
            return [
                'id' => $category->id,
                'name' => $category->name,
                'quizzes_count' => $category->quizzes()->count(),
                'assignment' => $assignment,
                'status' => $assignment->status ?? 'pending',
                'due_date' => $assignment->due_date ?? null,
                'completed_session_id' => $completedSession ? $completedSession->id : null,
            ];
        });

        // Get individual quiz assignments grouped by category name (for backward compatibility)
        $individualQuizzes = $quizAssignments->map(function($assignment) {
            $quiz = $assignment->quiz;
            $categoryName = $quiz->category ? $quiz->category->name : 'Uncategorized';
            
            // Get completed session for this category name
            $completedSession = QuizSession::where('user_id', Auth::id())
                ->where('category_name', $categoryName)
                ->where('completed', true)
                ->latest()
                ->first();
            
            return [
                'name' => $categoryName,
                'quizzes_count' => 1,
                'assignment' => $assignment,
                'status' => $assignment->status ?? 'pending',
                'due_date' => $assignment->due_date ?? null,
                'completed_session_id' => $completedSession ? $completedSession->id : null,
            ];
        })->groupBy('name');

        return view('user-quiz.index', compact('categories', 'individualQuizzes', 'assignments'));
    }

    /**
     * Show all quizzes for a specific category name.
     * Now redirects directly to take quiz route.
     */
    public function showByQuizName($quizName)
    {
        // Decode the category name from URL
        $categoryName = urldecode($quizName);
        
        // Try to find category by name
        $category = QuizCategory::where('name', $categoryName)->first();
        
        // Check if user has assignment for this category
        if ($category) {
            $assignment = QuizAssignment::where('user_id', Auth::id())
                ->where('category_id', $category->id)
                ->first();

            if (!$assignment) {
                abort(403, 'You do not have access to this quiz category.');
            }

            // Get all quizzes with the specified category
            $quizzes = Quiz::where('quizzes.category_id', $category->id)
                ->with(['category', 'priority'])
                ->leftJoin('priorities', 'quizzes.priority_id', '=', 'priorities.id')
                ->select('quizzes.*')
                ->orderBy('priorities.point', 'asc')
                ->orderBy('quizzes.created_at', 'desc')
                ->get();
        } else {
            // If category not found, find quizzes through assignments
            $assignments = QuizAssignment::where('user_id', Auth::id())
                ->whereNotNull('quiz_id')
                ->with('quiz')
                ->get();
            
            $quizzes = $assignments->map(function($assignment) {
                return $assignment->quiz;
            })->filter()->unique('id')->values();

            if ($quizzes->isEmpty()) {
                abort(403, 'You do not have access to this quiz.');
            }
        }

        if ($quizzes->isEmpty()) {
            abort(404, 'No quizzes available for this category.');
        }

        // Check if there's an active (non-completed) session for this category
        $activeSession = QuizSession::where('user_id', Auth::id())
            ->where('category_name', $categoryName)
            ->where('completed', false)
            ->latest()
            ->first();

        // If no active session exists, create a new one
        if (!$activeSession) {
            $activeSession = QuizSession::create([
                'user_id' => Auth::id(),
                'category_id' => $category ? $category->id : null,
                'category_name' => $categoryName,
                'total_questions' => $quizzes->count(),
                'completed' => false,
            ]);

            // Update assignment status if user is starting
            if ($category && isset($assignment) && $assignment->status === 'pending') {
                $assignment->update([
                    'status' => 'in_progress',
                    'started_at' => now(),
                ]);
            }
        }

        // Redirect directly to take quiz route
        return redirect()->route('user-quiz.take', ['session' => $activeSession->id, 'question' => 1]);
    }

    /**
     * Start a new quiz session for a category.
     */
    public function startQuiz($quizName)
    {
        $categoryName = urldecode($quizName);
        
        // Find category
        $category = QuizCategory::where('name', $categoryName)->first();
        
        // Verify assignment exists
        if ($category) {
            $assignment = QuizAssignment::where('user_id', Auth::id())
                ->where('category_id', $category->id)
                ->first();

            if (!$assignment) {
                abort(403, 'You do not have access to this quiz category.');
            }

            $quizzes = Quiz::where('category_id', $category->id)->get();
        } else {
            // If category not found, find quizzes through assignments
            $assignments = QuizAssignment::where('user_id', Auth::id())
                ->whereNotNull('quiz_id')
                ->with('quiz')
                ->get();
            
            $quizzes = $assignments->map(function($assignment) {
                return $assignment->quiz;
            })->filter()->unique('id')->values();
            
            $hasAssignment = $quizzes->isNotEmpty();

            if (!$hasAssignment && $quizzes->isNotEmpty()) {
                abort(403, 'You do not have access to this quiz.');
            }
        }

        if ($quizzes->isEmpty()) {
            return redirect()->route('user-quiz.quiz-name', ['quizName' => $quizName])
                ->with('error', 'No quizzes available for this category.');
        }

        // Create quiz session
        $session = QuizSession::create([
            'user_id' => Auth::id(),
            'category_id' => $category ? $category->id : null,
            'category_name' => $categoryName,
            'total_questions' => $quizzes->count(),
            'completed' => false,
        ]);

        // Update assignment status
        if (isset($assignment) && $assignment->status === 'pending') {
            $assignment->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        // Redirect to first question
        return redirect()->route('user-quiz.take', ['session' => $session->id, 'question' => 1]);
    }

    /**
     * Show quiz question for taking.
     */
    public function takeQuiz(QuizSession $session, $question)
    {
        // Verify session belongs to user
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if ($session->completed) {
            return redirect()->route('user-quiz.session-result', $session);
        }

        // Get all quizzes for this category
        if ($session->category_id) {
            $quizzes = Quiz::where('quizzes.category_id', $session->category_id)
                ->with('priority')
                ->leftJoin('priorities', 'quizzes.priority_id', '=', 'priorities.id')
                ->select('quizzes.*')
                ->orderBy('priorities.point', 'asc')
                ->orderBy('quizzes.created_at', 'desc')
                ->get();
        } else {
            // If no category_id, get quizzes from assignments
            $assignments = QuizAssignment::where('user_id', Auth::id())
                ->whereNotNull('quiz_id')
                ->with('quiz.priority')
                ->get();
            
            $quizzes = $assignments->map(function($assignment) {
                return $assignment->quiz;
            })->filter()->unique('id')->values()->sortBy(function($quiz) {
                return $quiz->priority ? $quiz->priority->point : 999;
            })->sortByDesc('created_at');
        }

        $questionIndex = (int)$question - 1;
        
        if ($questionIndex < 0 || $questionIndex >= $quizzes->count()) {
            return redirect()->route('user-quiz.session-result', $session);
        }

        $currentQuiz = $quizzes[$questionIndex];
        $totalQuestions = $quizzes->count();
        $currentQuestionNumber = $questionIndex + 1;

        // Check if already answered
        $existingAttempt = QuizAttempt::where('session_id', $session->id)
            ->where('quiz_id', $currentQuiz->id)
            ->first();

        return view('user-quiz.take', compact('session', 'currentQuiz', 'totalQuestions', 'currentQuestionNumber', 'existingAttempt'));
    }

    /**
     * Submit answer for current question.
     */
    public function submitAnswer(Request $request, QuizSession $session, $question)
    {
        $request->validate([
            'answer' => 'required|in:true,false,both',
        ]);

        // Verify session belongs to user
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if ($session->completed) {
            return redirect()->route('user-quiz.session-result', $session);
        }

        // Get all quizzes for this category
        if ($session->category_id) {
            $quizzes = Quiz::where('quizzes.category_id', $session->category_id)
                ->with('priority')
                ->leftJoin('priorities', 'quizzes.priority_id', '=', 'priorities.id')
                ->select('quizzes.*')
                ->orderBy('priorities.point', 'asc')
                ->orderBy('quizzes.created_at', 'desc')
                ->get();
        } else {
            // If no category_id, get quizzes from assignments
            $assignments = QuizAssignment::where('user_id', Auth::id())
                ->whereNotNull('quiz_id')
                ->with('quiz.priority')
                ->get();
            
            $quizzes = $assignments->map(function($assignment) {
                return $assignment->quiz;
            })->filter()->unique('id')->values()->sortBy(function($quiz) {
                return $quiz->priority ? $quiz->priority->point : 999;
            })->sortByDesc('created_at');
        }

        $questionIndex = (int)$question - 1;
        
        if ($questionIndex < 0 || $questionIndex >= $quizzes->count()) {
            return redirect()->route('user-quiz.session-result', $session);
        }

        $currentQuiz = $quizzes[$questionIndex];

        // Check if answer is correct
        $isCorrect = false;
        if ($currentQuiz->answer == 'both') {
            $isCorrect = true;
        } else {
            $isCorrect = ($request->answer == $currentQuiz->answer);
        }

        // Save or update attempt
        QuizAttempt::updateOrCreate(
            [
                'session_id' => $session->id,
                'quiz_id' => $currentQuiz->id,
            ],
            [
                'user_id' => Auth::id(),
                'user_answer' => $request->answer,
                'is_correct' => $isCorrect,
            ]
        );

        // Check if this is the last question
        if ($questionIndex + 1 >= $quizzes->count()) {
            // Calculate final score based on priority points
            $attempts = QuizAttempt::where('session_id', $session->id)
                ->with('quiz.priority')
                ->get();
            
            // Calculate total possible points (sum of all quiz priority points)
            $totalPossiblePoints = 0;
            foreach ($quizzes as $quiz) {
                // Priority is already loaded in the queries above
                $totalPossiblePoints += $quiz->priority ? $quiz->priority->point : 0;
            }
            
            // Calculate earned points (sum of priority points for correct answers only)
            $earnedPoints = 0;
            $correctAnswers = 0;
            $wrongAnswers = 0;
            
            foreach ($attempts as $attempt) {
                $quiz = $attempt->quiz;
                if ($quiz && $quiz->priority) {
                    if ($attempt->is_correct) {
                        $earnedPoints += $quiz->priority->point;
                        $correctAnswers++;
                    } else {
                        $wrongAnswers++;
                    }
                } else {
                    // Fallback: if priority not found, count as before
                    if ($attempt->is_correct) {
                        $correctAnswers++;
                    } else {
                        $wrongAnswers++;
                    }
                }
            }
            
            // Calculate score: (Earned Points / Total Possible Points) * 100
            $score = $totalPossiblePoints > 0 ? round(($earnedPoints / $totalPossiblePoints) * 100, 2) : 0;

            // Update session
            $session->update([
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'score' => $score,
                'completed' => true,
            ]);

            // Update assignment status to completed
            if ($session->category_id) {
                $assignment = QuizAssignment::where('user_id', Auth::id())
                    ->where('category_id', $session->category_id)
                    ->where('status', '!=', 'completed')
                    ->first();
            } else {
                // For individual quiz assignments, find by quiz_id from assignments
                $assignment = QuizAssignment::where('user_id', Auth::id())
                    ->whereNotNull('quiz_id')
                    ->where('status', '!=', 'completed')
                    ->first();
            }

            if ($assignment) {
                $assignment->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            return redirect()->route('user-quiz.session-result', $session);
        }

        // Redirect to next question
        return redirect()->route('user-quiz.take', ['session' => $session->id, 'question' => $questionIndex + 2]);
    }

    /**
     * Show quiz session result.
     */
    public function sessionResult(QuizSession $session)
    {
        // Verify session belongs to user
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $attempts = QuizAttempt::where('session_id', $session->id)
            ->with('quiz.priority')
            ->get();

        // Calculate total points (sum of all quiz priority points)
        $totalPoints = 0;
        foreach ($attempts as $attempt) {
            if ($attempt->quiz && $attempt->quiz->priority) {
                $totalPoints += $attempt->quiz->priority->point;
            }
        }

        // Calculate received points (sum of priority points for correct answers only)
        $receivedPoints = 0;
        foreach ($attempts as $attempt) {
            if ($attempt->is_correct && $attempt->quiz && $attempt->quiz->priority) {
                $receivedPoints += $attempt->quiz->priority->point;
            }
        }

        return view('user-quiz.session-result', compact('session', 'attempts', 'totalPoints', 'receivedPoints'));
    }

    /**
     * Show the quiz questions for taking (old single quiz method).
     */
    public function show(Quiz $quiz)
    {
        // Check if user already attempted this quiz
        $previousAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($previousAttempt) {
            return redirect()->route('user-quiz.result', $quiz)->with('info', 'You have already taken this quiz. Here is your result.');
        }

        return view('user-quiz.show', compact('quiz'));
    }

    /**
     * Submit quiz answer (old single quiz method).
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answer' => 'required|in:true,false,both',
        ]);

        // Check if user already attempted this quiz
        $previousAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($previousAttempt) {
            return redirect()->route('user-quiz.result', $quiz)->with('info', 'You have already taken this quiz.');
        }

        // Check if answer is correct
        $isCorrect = false;
        if ($quiz->answer == 'both') {
            $isCorrect = true;
        } else {
            $isCorrect = ($request->answer == $quiz->answer);
        }

        // Save quiz attempt
        QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'user_answer' => $request->answer,
            'is_correct' => $isCorrect,
        ]);

        return redirect()->route('user-quiz.result', $quiz)->with('success', 'Quiz submitted successfully!');
    }

    /**
     * Show quiz result (old single quiz method).
     */
    public function result(Quiz $quiz)
    {
        $attempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if (!$attempt) {
            return redirect()->route('user-quiz.show', $quiz);
        }

        return view('user-quiz.result', compact('quiz', 'attempt'));
    }

    /**
     * Show user's quiz history.
     */
    public function history()
    {
        // Get all completed quiz sessions
        $sessions = QuizSession::where('user_id', Auth::id())
            ->where('completed', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall statistics
        $totalQuizzes = $sessions->count();
        $totalQuestions = $sessions->sum('total_questions');
        $totalCorrect = $sessions->sum('correct_answers');
        $totalWrong = $sessions->sum('wrong_answers');
        $overallScore = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 2) : 0;

        return view('user-quiz.history', compact('sessions', 'totalQuizzes', 'totalQuestions', 'totalCorrect', 'totalWrong', 'overallScore'));
    }

    /**
     * Show detailed results for a specific quiz session.
     */
    public function showSessionDetails(QuizSession $session)
    {
        // Verify session belongs to user
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $attempts = QuizAttempt::where('session_id', $session->id)
            ->with('quiz.priority')
            ->orderBy('id', 'asc')
            ->get();

        return view('user-quiz.session-details', compact('session', 'attempts'));
    }
}
