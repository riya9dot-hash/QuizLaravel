<x-app-layout>
    <x-slot name="header">
        <h2>Quiz: {{ $session->category_name }}</h2>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 15px;">
        <!-- Back Links -->
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
            @if($currentQuestionNumber > 1)
                <a href="{{ route('user-quiz.take', ['session' => $session->id, 'question' => $currentQuestionNumber - 1]) }}" style="display: inline-flex; align-items: center; gap: 6px; color: #848177; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.3s ease; padding: 8px 14px; border-radius: 8px; background: rgba(102, 126, 234, 0.1);">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous Question
                </a>
            @endif
            <a href="{{ route('user-quiz.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #848177; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.3s ease; padding: 8px 14px; border-radius: 8px; background: rgba(102, 126, 234, 0.1);">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Quizzes
            </a>
        </div>

        <div class="quiz-container" style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <!-- Progress Section -->
            <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 18px 22px; position: relative; overflow: hidden;">
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <div>
                            <h3 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 700; color: white;">{{ $session->category_name }}</h3>
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 12px;">Question {{ $currentQuestionNumber }} of {{ $totalQuestions }}</p>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 10px; backdrop-filter: blur(10px);">
                            <span style="color: white; font-size: 16px; font-weight: 700;">{{ round(($currentQuestionNumber / $totalQuestions) * 100) }}%</span>
                        </div>
                    </div>
                    <div style="background: rgba(255, 255, 255, 0.2); border-radius: 10px; height: 10px; overflow: hidden; position: relative;">
                        <div style="background: white; height: 100%; width: {{ ($currentQuestionNumber / $totalQuestions) * 100 }}%; transition: width 0.5s ease; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);"></div>
                    </div>
                </div>
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite;"></div>
            </div>

            <!-- Question Section -->
            <div style="padding: 22px 24px;">
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border-left: 4px solid #848177; padding: 18px; border-radius: 12px; margin-bottom: 22px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                            {{ $currentQuestionNumber }}
                        </div>
                        <h4 style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 700;">Question</h4>
                    </div>
                    <p style="margin: 0; color: #374151; font-size: 15px; line-height: 1.6; font-weight: 500;">{{ $currentQuiz->question }}</p>
                </div>

                <!-- Answer Form -->
                <form method="POST" action="{{ route('user-quiz.submit-answer', ['session' => $session->id, 'question' => $currentQuestionNumber]) }}" id="quizForm">
                    @csrf

                    <div style="margin-bottom: 22px;">
                        <label style="display: block; color: #1f2937; font-size: 14px; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Select Your Answer
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 18px; background: white; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <input type="radio" name="answer" value="true" id="answer_true" {{ $existingAttempt && $existingAttempt->user_answer == 'true' ? 'checked' : '' }} required style="width: 20px; height: 20px; margin-right: 14px; cursor: pointer; accent-color: #848177; flex-shrink: 0;">
                                <div style="flex: 1;">
                                    <span style="font-size: 15px; font-weight: 600; color: #1f2937; display: block;">True</span>
                                </div>
                                <div class="check-icon" style="opacity: 0; transition: opacity 0.3s ease;">
                                    <svg style="width: 20px; height: 20px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 18px; background: white; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <input type="radio" name="answer" value="false" id="answer_false" {{ $existingAttempt && $existingAttempt->user_answer == 'false' ? 'checked' : '' }} required style="width: 20px; height: 20px; margin-right: 14px; cursor: pointer; accent-color: #848177; flex-shrink: 0;">
                                <div style="flex: 1;">
                                    <span style="font-size: 15px; font-weight: 600; color: #1f2937; display: block;">False</span>
                                </div>
                                <div class="check-icon" style="opacity: 0; transition: opacity 0.3s ease;">
                                    <svg style="width: 20px; height: 20px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 18px; background: white; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <input type="radio" name="answer" value="both" id="answer_both" {{ $existingAttempt && $existingAttempt->user_answer == 'both' ? 'checked' : '' }} required style="width: 20px; height: 20px; margin-right: 14px; cursor: pointer; accent-color: #848177; flex-shrink: 0;">
                                <div style="flex: 1;">
                                    <span style="font-size: 15px; font-weight: 600; color: #1f2937; display: block;">Both</span>
                                </div>
                                <div class="check-icon" style="opacity: 0; transition: opacity 0.3s ease;">
                                    <svg style="width: 20px; height: 20px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                        </div>
                        @error('answer')
                            <div style="color: #ef4444; margin-top: 12px; font-size: 13px; display: flex; align-items: center; gap: 6px; padding: 10px; background: #fef2f2; border-radius: 8px; border-left: 4px solid #ef4444;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div style="background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%); padding: 18px 0; border-top: 2px solid #f3f4f6; margin-top: 22px;">
                        <button type="submit" class="submit-btn" style="width: 100%; padding: 12px 20px; font-size: 15px; font-weight: 700; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; border: none; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); display: flex; align-items: center; justify-content: center; gap: 8px;">
                            @if($currentQuestionNumber == $totalQuestions)
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit Quiz
                            @else
                                Next Question
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        a:hover {
            background: rgba(102, 126, 234, 0.15) !important;
            transform: translateX(-3px);
        }

        .answer-option {
            position: relative;
        }

        .answer-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 12px;
        }

        .answer-option:hover {
            border-color: #848177 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .answer-option:hover::before {
            opacity: 1;
        }

        .answer-option:has(input:checked) {
            background: linear-gradient(135deg, #f0f4ff 0%, #f5f3ff 100%) !important;
            border-color: #848177 !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .answer-option:has(input:checked) .check-icon {
            opacity: 1 !important;
        }

        .answer-option:has(input:checked)::before {
            opacity: 1;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5) !important;
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .quiz-container {
                border-radius: 16px !important;
            }
            
            div[style*="padding: 35px 30px"] {
                padding: 25px 20px !important;
            }
            
            div[style*="padding: 25px 30px"] {
                padding: 20px !important;
            }
        }
    </style>
</x-app-layout>
