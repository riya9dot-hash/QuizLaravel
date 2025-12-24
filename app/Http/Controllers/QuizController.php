<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\QuizAssignment;
use App\Models\User;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only quizzes created by the logged-in admin, grouped by category
        $quizzes = Quiz::where('quizzes.created_by', Auth::id())
            ->with(['category', 'priority'])
            ->leftJoin('priorities', 'quizzes.priority_id', '=', 'priorities.id')
            ->select('quizzes.*')
            ->orderBy('quizzes.category_id', 'asc')
            ->orderBy('priorities.point', 'asc')
            ->orderBy('quizzes.created_at', 'desc')
            ->get()
            ->groupBy(function($quiz) {
                return $quiz->category ? $quiz->category->name : 'Uncategorized';
            });

        return view('quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Get categories created by this admin for dropdown
        $categories = QuizCategory::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Get priorities created by this admin for dropdown
        $priorities = Priority::where('created_by', Auth::id())
            ->orderBy('point', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('quiz.create', compact('categories', 'priorities'));
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'category_id' => 'required|exists:quiz_categories,id',
            'question' => 'required|string|max:1000',
            'answer' => 'required|in:true,false,both',
            'priority_id' => 'required|exists:priorities,id',
        ]);

        // Verify category belongs to this admin
        $category = QuizCategory::where('id', $request->category_id)
            ->where('created_by', Auth::id())
            ->with('brands')
            ->firstOrFail();

        $categoryName = $category->name;

        // Verify priority belongs to this admin
        $priority = Priority::where('id', $request->priority_id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        // Get first brand from category's brands (categories can have multiple brands now)
        $firstBrand = $category->brands->first();
        if (!$firstBrand) {
            return back()->withErrors(['category_id' => 'Category must have at least one brand assigned.'])->withInput();
        }

        Quiz::create([
            'category_id' => $request->category_id,
            'brand_id' => $firstBrand->id, // Use first brand from category's brands
            'question' => $request->question,
            'answer' => $request->answer,
            'priority_id' => $request->priority_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('quiz.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only view quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only view quizzes created by you.');
        }

        return view('quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only edit quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only edit quizzes created by you.');
        }

        // Get categories created by this admin for dropdown
        $categories = QuizCategory::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Get priorities created by this admin for dropdown
        $priorities = Priority::where('created_by', Auth::id())
            ->orderBy('point', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('quiz.edit', compact('quiz', 'categories', 'priorities'));
    }

    /**
     * Update the specified quiz.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only update quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only update quizzes created by you.');
        }

        $request->validate([
            'category_id' => 'required|exists:quiz_categories,id',
            'question' => 'required|string|max:1000',
            'answer' => 'required|in:true,false,both',
            'priority_id' => 'required|exists:priorities,id',
        ]);

        // Verify category belongs to this admin
        $category = QuizCategory::where('id', $request->category_id)
            ->where('created_by', Auth::id())
            ->with('brands')
            ->firstOrFail();

        $categoryName = $category->name;

        // Verify priority belongs to this admin
        $priority = Priority::where('id', $request->priority_id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        // Get first brand from category's brands (categories can have multiple brands now)
        $firstBrand = $category->brands->first();
        if (!$firstBrand) {
            return back()->withErrors(['category_id' => 'Category must have at least one brand assigned.'])->withInput();
        }

        $quiz->update([
            'category_id' => $request->category_id,
            'brand_id' => $firstBrand->id, // Use first brand from category's brands
            'question' => $request->question,
            'answer' => $request->answer,
            'priority_id' => $request->priority_id,
        ]);

        return redirect()->route('quiz.index')->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz.
     */
    public function destroy(Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only delete quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only delete quizzes created by you.');
        }

        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Show the form for assigning a category to users.
     */
    public function assignCategoryForm($categoryId)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify category belongs to this admin
        $category = QuizCategory::where('id', $categoryId)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        // Get all users who are not admins
        // Include: 1) Users from the same brand as the category, 2) Users with no brands (default users)
        // $users = User::whereDoesntHave('roles', function($query) {
        //     $query->whereIn('name', ['Admin', 'SuperAdmin']);
        // })
        // ->where(function($query) use ($category) {
        //     $query->whereHas('brands', function($q) use ($category) {
        //         $q->where('brands.id', $category->brand_id);
        //     })
        //     ->orDoesntHave('brands'); // Include default users who registered themselves
        // })
        // ->with('brands') // Load brands relationship for display
        // ->orderBy('name', 'asc')
        // ->get();

        $users=User::where('created_by', Auth::id())->orderBy('name', 'asc')->get();

        // Get existing assignments for this category
        $assignments = QuizAssignment::where('category_id', $categoryId)
            ->with('user')
            ->get();

        return view('quiz.assign-category', compact('category', 'users', 'assignments'));
    }

    /**
     * Show the form for assigning a quiz to users.
     */
    public function assignQuizForm(Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only assign quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only assign quizzes created by you.');
        }

        // Get all users who are not admins
        // Include: 1) Users from the same brand as the quiz, 2) Users with no brands (default users)
        $users = User::whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['Admin', 'SuperAdmin']);
        })
        ->where(function($query) use ($quiz) {
            $query->whereHas('brands', function($q) use ($quiz) {
                $q->where('brands.id', $quiz->brand_id);
            })
            ->orDoesntHave('brands'); // Include default users who registered themselves
        })
        ->with('brands') // Load brands relationship for display
        ->orderBy('name', 'asc')
        ->get();

        // Get existing assignments for this quiz
        $assignments = QuizAssignment::where('quiz_id', $quiz->id)
            ->with('user')
            ->get();

        return view('quiz.assign-quiz', compact('quiz', 'users', 'assignments'));
    }

    /**
     * Store assignment for a category.
     */
    public function assignCategory(Request $request, $categoryId)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify category belongs to this admin
        $category = QuizCategory::where('id', $categoryId)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'due_date' => 'nullable|date|after:today',
        ]);

        $assignedCount = 0;
        foreach ($request->user_ids as $userId) {
            // Check if user is not an admin
            $user = User::findOrFail($userId);
            if ($user->hasAnyRole(['Admin', 'SuperAdmin'])) {
                continue; // Skip admins
            }

            // Check if assignment already exists
            $existing = QuizAssignment::where('category_id', $categoryId)
                ->where('user_id', $userId)
                ->first();

            if (!$existing) {
                QuizAssignment::create([
                    'category_id' => $categoryId,
                    'user_id' => $userId,
                    'assigned_by' => Auth::id(),
                    'due_date' => $request->due_date,
                    'status' => 'pending',
                ]);
                $assignedCount++;
            }
        }

        if ($assignedCount > 0) {
            return redirect()->route('quiz.assign-category', $categoryId)
                ->with('success', "Quiz category assigned to {$assignedCount} user(s) successfully.");
        }

        return redirect()->route('quiz.assign-category', $categoryId)
            ->with('info', 'Selected users already have this assignment or are admins.');
    }

    /**
     * Store assignment for an individual quiz.
     */
    public function assignQuiz(Request $request, Quiz $quiz)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only assign quizzes they created
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only assign quizzes created by you.');
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'due_date' => 'nullable|date|after:today',
        ]);

        $assignedCount = 0;
        foreach ($request->user_ids as $userId) {
            // Check if user is not an admin
            $user = User::findOrFail($userId);
            if ($user->hasAnyRole(['Admin', 'SuperAdmin'])) {
                continue; // Skip admins
            }

            // Check if assignment already exists
            $existing = QuizAssignment::where('quiz_id', $quiz->id)
                ->where('user_id', $userId)
                ->first();

            if (!$existing) {
                QuizAssignment::create([
                    'quiz_id' => $quiz->id,
                    'user_id' => $userId,
                    'assigned_by' => Auth::id(),
                    'due_date' => $request->due_date,
                    'status' => 'pending',
                ]);
                $assignedCount++;
            }
        }

        if ($assignedCount > 0) {
            return redirect()->route('quiz.assign-quiz', $quiz)
                ->with('success', "Quiz assigned to {$assignedCount} user(s) successfully.");
        }

        return redirect()->route('quiz.assign-quiz', $quiz)
            ->with('info', 'Selected users already have this assignment or are admins.');
    }

    /**
     * View all assignments for a category.
     */
    public function viewCategoryAssignments($categoryId)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify category belongs to this admin
        $category = QuizCategory::where('id', $categoryId)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        $assignments = QuizAssignment::where('category_id', $categoryId)
            ->with(['user', 'assigner'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quiz.category-assignments', compact('category', 'assignments'));
    }

    /**
     * Remove an assignment.
     */
    public function removeAssignment(QuizAssignment $assignment)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only remove assignments they created
        if ($assignment->assigned_by !== Auth::id()) {
            abort(403, 'You can only remove assignments created by you.');
        }

        $categoryId = $assignment->category_id;
        $quizId = $assignment->quiz_id;

        $assignment->delete();

        if ($categoryId) {
            return redirect()->route('quiz.assign-category', $categoryId)
                ->with('success', 'Assignment removed successfully.');
        } else {
            return redirect()->route('quiz.assign-quiz', $quizId)
                ->with('success', 'Assignment removed successfully.');
        }
    }
}
