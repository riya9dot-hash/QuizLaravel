<x-app-layout>
    <x-slot name="header">
        <h2>Quiz Details: {{ $session->category_name }}</h2>
    </x-slot>

    <div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <!-- Back Link -->
        <a href="{{ route('user-quiz.history') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #848177; text-decoration: none; margin-bottom: 20px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; padding: 8px 14px; border-radius: 8px; background: rgba(102, 126, 234, 0.1);">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quiz History
        </a>

        <!-- Header Card -->
        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); border-radius: 16px; padding: 25px; color: white; margin-bottom: 25px; box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h1 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 700;">{{ $session->category_name }}</h1>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; opacity: 0.9;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Completed on {{ $session->created_at->format('M d, Y h:i A') }}
                        </div>
                    </div>
                    <div style="background: rgba(255, 255, 255, 0.2); padding: 12px 20px; border-radius: 12px; backdrop-filter: blur(10px);">
                        <div style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">Final Score</div>
                        <div style="font-size: 28px; font-weight: 700;">{{ $session->score }}%</div>
                    </div>
                </div>
            </div>
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite;"></div>
        </div>

        <!-- Statistics Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 15px; margin-bottom: 30px;">
            <div style="background: white; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                    <svg style="width: 20px; height: 20px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 600;">Total Questions</div>
                </div>
                <div style="font-size: 32px; font-weight: 700; color: #848177;">{{ $session->total_questions }}</div>
            </div>
            
            <div style="background: white; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #d1fae5; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                    <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 600;">Correct</div>
                </div>
                <div style="font-size: 32px; font-weight: 700; color: #10b981;">{{ $session->correct_answers }}</div>
            </div>
            
            <div style="background: white; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #fee2e2; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                    <svg style="width: 20px; height: 20px; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 600;">Wrong</div>
                </div>
                <div style="font-size: 32px; font-weight: 700; color: #ef4444;">{{ $session->wrong_answers }}</div>
            </div>
            
            <div style="background: white; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #fef3c7; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                    <svg style="width: 20px; height: 20px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 600;">Score</div>
                </div>
                <div style="font-size: 32px; font-weight: 700; color: #f59e0b;">{{ $session->score }}%</div>
            </div>
        </div>

        <!-- Questions Section -->
        <div style="background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
                <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 10px; border-radius: 12px;">
                    <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">All Questions & Answers</h3>
            </div>
            
            <div style="display: grid; gap: 18px;">
                @foreach($attempts as $index => $attempt)
                    <div class="question-card" style="border-radius: 14px; padding: 20px; transition: all 0.3s ease; {{ $attempt->is_correct ? 'background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border: 2px solid #d1fae5;' : 'background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%); border: 2px solid #fee2e2;' }}">
                        <div style="display: flex; align-items: start; gap: 15px;">
                            <div style="flex-shrink: 0;">
                                <div style="background: {{ $attempt->is_correct ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' }}; color: white; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px {{ $attempt->is_correct ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)' }};">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                                    <p style="margin: 0; color: #1f2937; font-size: 16px; line-height: 1.7; font-weight: 600; flex: 1;">{{ $attempt->quiz->question }}</p>
                                    @if($attempt->quiz->priority)
                                        <div style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%); padding: 6px 12px; border-radius: 8px; border: 1px solid #c7d2fe;">
                                            <svg style="width: 16px; height: 16px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <span style="font-size: 12px; font-weight: 600; color: #848177;">{{ $attempt->quiz->priority->name }}</span>
                                            <span style="font-size: 12px; font-weight: 700; color: #848177;">({{ $attempt->quiz->priority->point }} pts)</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                                    <div style="background: white; padding: 14px; border-radius: 10px; border: 2px solid #e5e7eb;">
                                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Your Answer</div>
                                        <div style="color: #848177; font-weight: 700; font-size: 15px;">{{ ucfirst($attempt->user_answer) }}</div>
                                    </div>
                                    <div style="background: white; padding: 14px; border-radius: 10px; border: 2px solid #d1fae5;">
                                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Correct Answer</div>
                                        <div style="color: #10b981; font-weight: 700; font-size: 15px;">{{ ucfirst($attempt->quiz->answer) }}</div>
                                    </div>
                                    <div style="background: white; padding: 14px; border-radius: 10px; border: 2px solid {{ $attempt->is_correct ? '#d1fae5' : '#fee2e2' }};">
                                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Result</div>
                                        @if($attempt->is_correct)
                                            <div style="display: flex; align-items: center; gap: 6px; color: #10b981; font-weight: 700; font-size: 15px;">
                                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Correct
                                            </div>
                                        @else
                                            <div style="display: flex; align-items: center; gap: 6px; color: #ef4444; font-weight: 700; font-size: 15px;">
                                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Wrong
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }

        a:hover {
            background: rgba(102, 126, 234, 0.15) !important;
            transform: translateX(-3px);
        }
    </style>
</x-app-layout>
