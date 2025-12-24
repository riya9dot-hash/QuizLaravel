<x-app-layout>
    <x-slot name="header">
        <h2>Available Quiz Categories</h2>
    </x-slot>

    <style>
        .quiz-dashboard {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-header {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            border-radius: 16px;
            padding: 25px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3);
        }
        .dashboard-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }
        .dashboard-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        .history-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 15px;
        }
        .history-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .quiz-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            display: flex;
        }
        .quiz-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #848177 0%, #000000100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .quiz-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(102, 126, 234, 0.3), 0 10px 10px -5px rgba(102, 126, 234, 0.2);
        }
        .quiz-card:hover::before {
            transform: scaleX(1);
        }
        .quiz-card-header {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            padding: 20px 18px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .quiz-card-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .quiz-icon-wrapper {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }
        .quiz-icon {
            width: 24px;
            height: 24px;
            color: white;
        }
        .quiz-card-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            color: white;
        }
        .quiz-card-body {
            padding: 18px;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        }
        .quiz-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 12px;
            padding: 12px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .quiz-stat-item {
            text-align: center;
        }
        .quiz-stat-number {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 3px;
        }
        .quiz-stat-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }
        .quiz-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
            margin-bottom: 12px;
        }
        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }
        .status-in-progress {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }
        .status-completed {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }
        .quiz-due-date {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 12px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 8px;
        }
        .quiz-action-btn {
            width: 100%;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .action-start {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);
        }
        .action-start:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
        }
        .action-view {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
        }
        .action-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
        }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 25px;
            opacity: 0.2;
        }
        .empty-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .empty-text {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
        }
        .alert-modern {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid;
        }
        .alert-success-modern {
            background: #d1fae5;
            color: #065f46;
            border-color: #10b981;
        }
        @media (max-width: 768px) {
            .quiz-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .dashboard-header {
                padding: 30px 20px;
            }
            .dashboard-title {
                font-size: 24px;
            }
        }
    </style>

    <div class="quiz-dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">📚 My Quiz Dashboard</h1>
            <p class="dashboard-subtitle">Explore and complete your assigned quizzes. Track your progress and improve your knowledge!</p>
            <a href="{{ route('user-quiz.history') }}" class="history-btn">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                My Quiz History
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert-modern alert-success-modern">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Quiz Cards Grid -->
        <div class="quiz-grid">
            @foreach($categories as $categoryData)
                @php
                    $category = \App\Models\QuizCategory::find($categoryData['id']);
                    $assignment = $categoryData['assignment'];
                @endphp
                <div class="quiz-card" onclick="window.location.href='{{ route('user-quiz.quiz-name', ['quizName' => urlencode($categoryData['name'])]) }}'">
                    <div class="quiz-card-header">
                        <div class="quiz-icon-wrapper">
                            <svg class="quiz-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="quiz-card-title">{{ $categoryData['name'] }}</h3>
                    </div>
                    <div class="quiz-card-body">
                        <div class="quiz-stats">
                            <div class="quiz-stat-item">
                                <div class="quiz-stat-number">{{ $categoryData['quizzes_count'] }}</div>
                                <div class="quiz-stat-label">Questions</div>
                            </div>
                            <div class="quiz-stat-item">
                                <div class="quiz-stat-number" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    @if($categoryData['status'] == 'completed')
                                        ✓
                                    @elseif($categoryData['status'] == 'in_progress')
                                        ⏳
                                    @else
                                        📋
                                    @endif
                                </div>
                                <div class="quiz-stat-label">Status</div>
                            </div>
                        </div>

                        <div style="text-align: center; margin-bottom: 12px;">
                            @if($categoryData['status'] == 'pending')
                                <span class="quiz-status-badge status-pending">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pending
                                </span>
                            @elseif($categoryData['status'] == 'in_progress')
                                <span class="quiz-status-badge status-in-progress">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    In Progress
                                </span>
                            @else
                                <span class="quiz-status-badge status-completed">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Completed
                                </span>
                            @endif
                        </div>

                        @if($categoryData['due_date'])
                            <div class="quiz-due-date">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span><strong>Due:</strong> {{ \Carbon\Carbon::parse($categoryData['due_date'])->format('M d, Y') }}</span>
                            </div>
                        @endif

                        <button class="quiz-action-btn {{ $categoryData['status'] == 'completed' ? 'action-view' : 'action-start' }}" type="button" onclick="event.stopPropagation(); @if($categoryData['status'] == 'completed' && isset($categoryData['completed_session_id'])) window.location.href='{{ route('user-quiz.session-result', ['session' => $categoryData['completed_session_id']]) }}'; @else window.location.href='{{ route('user-quiz.quiz-name', ['quizName' => urlencode($categoryData['name'])]) }}'; @endif">
                            @if($categoryData['status'] == 'completed')
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Results
                            @else
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Start Quiz
                            @endif
                        </button>
                    </div>
                </div>
            @endforeach

            @if(isset($individualQuizzes))
                @foreach($individualQuizzes as $quizGroupName => $quizGroup)
                    @foreach($quizGroup as $quizData)
                        <div class="quiz-card" onclick="window.location.href='{{ route('user-quiz.quiz-name', ['quizName' => urlencode($quizGroupName)]) }}'">
                            <div class="quiz-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <div class="quiz-icon-wrapper">
                                    <svg class="quiz-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="quiz-card-title">{{ $quizGroupName }}</h3>
                            </div>
                            <div class="quiz-card-body">
                                <div class="quiz-stats">
                                    <div class="quiz-stat-item">
                                        <div class="quiz-stat-number" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $quizData['quizzes_count'] }}</div>
                                        <div class="quiz-stat-label">Questions</div>
                                    </div>
                                    <div class="quiz-stat-item">
                                        <div class="quiz-stat-number" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                            @if($quizData['status'] == 'completed')
                                                ✓
                                            @elseif($quizData['status'] == 'in_progress')
                                                ⏳
                                            @else
                                                📋
                                            @endif
                                        </div>
                                        <div class="quiz-stat-label">Status</div>
                                    </div>
                                </div>

                                <div style="text-align: center; margin-bottom: 12px;">
                                    @if($quizData['status'] == 'pending')
                                        <span class="quiz-status-badge status-pending">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @elseif($quizData['status'] == 'in_progress')
                                        <span class="quiz-status-badge status-in-progress">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            In Progress
                                        </span>
                                    @else
                                        <span class="quiz-status-badge status-completed">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Completed
                                        </span>
                                    @endif
                                </div>

                                @if($quizData['due_date'])
                                    <div class="quiz-due-date">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span><strong>Due:</strong> {{ \Carbon\Carbon::parse($quizData['due_date'])->format('M d, Y') }}</span>
                                    </div>
                                @endif

                                <button class="quiz-action-btn {{ $quizData['status'] == 'completed' ? 'action-view' : 'action-start' }}" type="button" style="{{ $quizData['status'] == 'completed' ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);' : '' }}" onclick="event.stopPropagation(); @if($quizData['status'] == 'completed' && isset($quizData['completed_session_id'])) window.location.href='{{ route('user-quiz.session-result', ['session' => $quizData['completed_session_id']]) }}'; @else window.location.href='{{ route('user-quiz.quiz-name', ['quizName' => urlencode($quizGroupName)]) }}'; @endif">
                                    @if($quizData['status'] == 'completed')
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Results
                                    @else
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Start Quiz
                                    @endif
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>

        <!-- Empty State -->
        @if($categories->count() == 0 && (!isset($individualQuizzes) || $individualQuizzes->count() == 0))
            <div class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="empty-title">No Quiz Assignments Available</h3>
                <p class="empty-text">You don't have any quiz assignments at the moment. Please wait for an admin to assign quizzes to you.</p>
            </div>
        @endif
    </div>
</x-app-layout>
