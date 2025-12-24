<x-app-layout>
    <x-slot name="header">
        <h2>Manage Quiz</h2>
    </x-slot>

    <style>
        .quiz-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .category-section {
            margin-bottom: 35px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .category-section:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .category-header {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            padding: 25px 30px;
            color: white;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        .category-header:hover {
            background: linear-gradient(135deg, #0000000%, #848177 100%);
        }
        .category-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .category-icon {
            width: 55px;
            height: 55px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        .category-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }
        .category-meta {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        .category-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .toggle-icon {
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }
        .category-section.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }
        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            padding: 30px;
            transition: all 0.3s ease;
        }
        .category-section.collapsed .quiz-grid {
            display: none;
        }
        .quiz-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 22px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .quiz-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #848177 0%, #000000100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3);
            border-color: #848177;
        }
        .quiz-card:hover::before {
            transform: scaleX(1);
        }
        .quiz-id {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(102, 126, 234, 0.1);
            color: #848177;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .quiz-question {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 18px 0;
            line-height: 1.6;
            padding-right: 50px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .quiz-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-answer-true {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-answer-false {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-answer-both {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-priority-high {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-priority-medium {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-priority-low {
            background: #d1fae5;
            color: #065f46;
        }
        .quiz-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        .action-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .action-btn-edit {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            color: white;
        }
        .action-btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .action-btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }
        .action-btn-delete:hover {
            background: #fecaca;
            transform: translateY(-2px);
        }
        .assign-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .assign-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
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
            opacity: 0.3;
        }
        .empty-text {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .quiz-grid {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            .category-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .category-actions {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>

    <div class="quiz-container">
        <!-- Header Section -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 25px; margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 5px 0;">Quiz Management</h1>
                    <p style="font-size: 14px; color: #6b7280; margin: 0;">Organize and manage your quiz questions by category</p>
                </div>
                <a href="{{ route('quiz.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Quiz
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #10b981;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #ef4444;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Quiz Categories -->
        @forelse($quizzes as $quizName => $quizGroup)
            @php
                $category = $quizGroup->first()->category;
                $categoryId = $category ? $category->id : null;
            @endphp
            <div class="category-section" id="category-{{ $categoryId ?? 'uncategorized' }}">
                <div class="category-header" onclick="toggleCategory('category-{{ $categoryId ?? 'uncategorized' }}')">
                    <div class="category-info">
                        <div class="category-icon">
                            <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="category-title">{{ $quizName }}</h3>
                            <p class="category-meta">{{ $quizGroup->count() }} {{ Str::plural('question', $quizGroup->count()) }} in this category</p>
                        </div>
                    </div>
                    <div class="category-actions">
                        @if($categoryId)
                            <a href="{{ route('quiz.assign-category', $categoryId) }}" class="assign-btn" onclick="event.stopPropagation();">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Assign to Users
                            </a>
                        @endif
                        <svg class="toggle-icon" style="width: 24px; height: 24px; margin-left: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="quiz-grid">
                    @foreach($quizGroup as $quiz)
                        <div class="quiz-card">
                            <div class="quiz-id">#{{ $quiz->id }}</div>
                            <p class="quiz-question">{{ $quiz->question }}</p>
                            <div class="quiz-badges">
                                <span class="badge badge-answer-{{ $quiz->answer }}">
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ ucfirst($quiz->answer) }}
                                </span>
                                @if($quiz->priority)
                                    <span class="badge badge-priority-{{ strtolower($quiz->priority->name) }}">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        {{ $quiz->priority->name }} ({{ $quiz->priority->point }} pts)
                                    </span>
                                @endif
                            </div>
                            <div class="quiz-actions">
                                <a href="{{ route('quiz.edit', $quiz) }}" class="action-btn action-btn-edit">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('quiz.destroy', $quiz) }}" method="POST" style="flex: 1; margin: 0;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                {{-- <p class="empty-text">No quizzes found. Create your first quiz to get started!</p>
                <a href="{{ route('quiz.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Quiz
                </a> --}}
            </div>
        @endforelse
    </div>

    <script>
        function toggleCategory(categoryId) {
            const category = document.getElementById(categoryId);
            if (category) {
                category.classList.toggle('collapsed');
            }
        }
    </script>
</x-app-layout>
