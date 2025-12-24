<x-app-layout>
    <x-slot name="header">
        <h2>Assign Quiz Category to Users</h2>
    </x-slot>

    <style>
        .assign-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #848177;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .back-link:hover {
            color: #764ba2;
            transform: translateX(-3px);
        }
        .category-header-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 25px;
        }
        .category-header-gradient {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            padding: 30px;
            color: white;
        }
        .category-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .category-icon-large {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        .category-title-large {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }
        .category-meta-large {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 35px;
            margin-bottom: 25px;
        }
        .form-section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .form-group-modern {
            margin-bottom: 25px;
        }
        .form-label-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .form-select-modern {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            background: white;
            min-height: 180px;
            transition: all 0.3s ease;
        }
        .form-select-modern:focus {
            outline: none;
            border-color: #848177;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-input-modern {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            background: white;
            transition: all 0.3s ease;
        }
        .form-input-modern:focus {
            outline: none;
            border-color: #848177;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .submit-btn-modern {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            color: white;
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .submit-btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
        }
        .assignments-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 35px;
            margin-top: 25px;
        }
        .assignments-title {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .assignment-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .assignment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px -4px rgba(102, 126, 234, 0.2);
            border-color: #848177;
        }
        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .assignment-user-info {
            flex: 1;
        }
        .assignment-user-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 5px 0;
        }
        .assignment-user-email {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }
        .assignment-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-in-progress {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .assignment-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #6b7280;
        }
        .assignment-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .assignment-actions {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        .remove-btn {
            background: #fee2e2;
            color: #991b1b;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .remove-btn:hover {
            background: #fecaca;
            transform: translateY(-2px);
        }
        .empty-assignments {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        .empty-assignments-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            opacity: 0.3;
        }
    </style>

    <div class="assign-container">
        <!-- Back Link -->
        <a href="{{ route('quiz.index') }}" class="back-link">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quiz List
        </a>

        <!-- Category Header Card -->
        <div class="category-header-card">
            <div class="category-header-gradient">
                <div class="category-header-content">
                    <div class="category-icon-large">
                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="category-title-large">{{ $category->name }}</h1>
                        <p class="category-meta-large">{{ $category->quizzes()->count() }} {{ Str::plural('question', $category->quizzes()->count()) }} in this category</p>
                    </div>
                </div>
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

        @if(session('info'))
            <div style="background: #dbeafe; color: #1e40af; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #3b82f6;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('info') }}
            </div>
        @endif

        <!-- Assignment Form Card -->
        <div class="form-card">
            <h2 class="form-section-title">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Assign Category to Users
            </h2>

            <form method="POST" action="{{ route('quiz.assign-category.store', $category->id) }}">
                @csrf

                <div class="form-group-modern">
                    <label for="user_ids" class="form-label-modern">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Select Users to Assign
                    </label>
                    <select id="user_ids" name="user_ids[]" multiple required class="form-select-modern">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <p style="font-size: 12px; color: #6b7280; margin-top: 8px; margin-bottom: 0;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple users</p>
                    @error('user_ids')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="due_date" class="form-label-modern">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Due Date (Optional)
                    </label>
                    <input type="datetime-local" id="due_date" name="due_date" value="{{ old('due_date') }}" class="form-input-modern">
                    @error('due_date')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn-modern">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Assign to Selected Users
                </button>
            </form>
        </div>

        <!-- Current Assignments Card -->
        @if($assignments->count() > 0)
            <div class="assignments-card">
                <h2 class="assignments-title">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Current Assignments ({{ $assignments->count() }})
                </h2>

                @foreach($assignments as $assignment)
                    <div class="assignment-card">
                        <div class="assignment-header">
                            <div class="assignment-user-info">
                                @if($assignment->user)
                                    <h3 class="assignment-user-name">{{ $assignment->user->name }}</h3>
                                    <p class="assignment-user-email">{{ $assignment->user->email }}</p>
                                @else
                                    <h3 class="assignment-user-name" style="color: #999;">User Deleted</h3>
                                @endif
                            </div>
                        </div>

                        <div class="assignment-badges">
                            @if($assignment->status == 'pending')
                                <span class="badge-status badge-pending">
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pending
                                </span>
                            @elseif($assignment->status == 'in_progress')
                                <span class="badge-status badge-in-progress">
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    In Progress
                                </span>
                            @else
                                <span class="badge-status badge-completed">
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Completed
                                </span>
                            @endif
                        </div>

                        <div class="assignment-meta">
                            <div class="assignment-meta-item">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <strong>Due Date:</strong> 
                                @if($assignment->due_date)
                                    {{ $assignment->due_date->format('M d, Y H:i') }}
                                @else
                                    <span style="color: #9ca3af;">No due date</span>
                                @endif
                            </div>
                            <div class="assignment-meta-item">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <strong>Assigned:</strong> {{ $assignment->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="assignment-actions">
                            <form action="{{ route('quiz.assignment.remove', $assignment) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to remove this assignment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove Assignment
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="assignments-card">
                <div class="empty-assignments">
                    <svg class="empty-assignments-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p style="font-size: 16px; margin: 0;">No assignments yet. Assign this category to users above.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
