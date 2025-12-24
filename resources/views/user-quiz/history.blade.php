<x-app-layout>
    <x-slot name="header">
        <h2>My Quiz History</h2>
    </x-slot>

    <div style="max-width: 1100px; margin: 0 auto; padding: 15px;">
        <!-- Header Section -->
        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); border-radius: 16px; padding: 20px; color: white; margin-bottom: 22px; box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 6px 0; font-size: 22px; font-weight: 700;">My Quiz History</h1>
                    <p style="margin: 0; font-size: 13px; opacity: 0.9;">View all your completed quiz attempts and track your progress</p>
                </div>
                <a href="{{ route('user-quiz.index') }}" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.2); color: white; padding: 10px 18px; text-decoration: none; border-radius: 10px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; border: 1px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px);">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Quizzes
                </a>
            </div>
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite;"></div>
        </div>

        @if($totalQuizzes > 0)
            <!-- Overall Statistics -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 20px;">
                <div class="stat-card" style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 8px; backdrop-filter: blur(10px);">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="font-size: 11px; opacity: 0.9; margin-bottom: 5px; font-weight: 500;">Total Quizzes</div>
                        <div style="font-size: 26px; font-weight: 700; line-height: 1;">{{ $totalQuizzes }}</div>
                    </div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 8px; backdrop-filter: blur(10px);">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="font-size: 11px; opacity: 0.9; margin-bottom: 5px; font-weight: 500;">Total Questions</div>
                        <div style="font-size: 26px; font-weight: 700; line-height: 1;">{{ $totalQuestions }}</div>
                    </div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 8px; backdrop-filter: blur(10px);">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="font-size: 11px; opacity: 0.9; margin-bottom: 5px; font-weight: 500;">Correct Answers</div>
                        <div style="font-size: 26px; font-weight: 700; line-height: 1;">{{ $totalCorrect }}</div>
                    </div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); position: relative; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 8px; backdrop-filter: blur(10px);">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="font-size: 11px; opacity: 0.9; margin-bottom: 5px; font-weight: 500;">Wrong Answers</div>
                        <div style="font-size: 26px; font-weight: 700; line-height: 1;">{{ $totalWrong }}</div>
                    </div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); position: relative; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px; border-radius: 8px; backdrop-filter: blur(10px);">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="font-size: 11px; opacity: 0.9; margin-bottom: 5px; font-weight: 500;">Overall Score</div>
                        <div style="font-size: 26px; font-weight: 700; line-height: 1;">{{ $overallScore }}%</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quiz Sessions List -->
        <div style="margin-bottom: 15px;">
            <h3 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 8px;">
                <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Completed Quizzes
            </h3>
        </div>

        <div style="display: grid; gap: 16px;">
            @forelse($sessions as $session)
                <div class="session-card" style="background: white; border-radius: 14px; padding: 0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; cursor: pointer; border: 1px solid #f3f4f6;"
                     onclick="window.location.href='{{ route('user-quiz.session-details', $session) }}'">
                    <!-- Card Header -->
                    <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 16px 20px; color: white; position: relative; overflow: hidden;">
                        <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                    <div style="background: rgba(255, 255, 255, 0.2); padding: 5px 12px; border-radius: 18px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px);">
                                        {{ $session->category_name }}
                                    </div>
                                </div>
                                <div style="font-size: 11px; opacity: 0.9; display: flex; align-items: center; gap: 5px;">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $session->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                            <div style="background: rgba(255, 255, 255, 0.2); padding: 8px 14px; border-radius: 10px; backdrop-filter: blur(10px);">
                                <div style="font-size: 18px; font-weight: 700;">{{ $session->score }}%</div>
                            </div>
                        </div>
                        <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite;"></div>
                    </div>

                    <!-- Card Body -->
                    <div style="padding: 16px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 10px;">
                            <div style="text-align: center; padding: 12px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border-radius: 10px; border: 2px solid #f3f4f6;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 6px;">
                                    <svg style="width: 16px; height: 16px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div style="font-size: 10px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Questions</div>
                                </div>
                                <div style="font-size: 20px; font-weight: 700; color: #848177;">{{ $session->total_questions }}</div>
                            </div>
                            
                            <div style="text-align: center; padding: 12px; background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border-radius: 10px; border: 2px solid #d1fae5;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 6px;">
                                    <svg style="width: 16px; height: 16px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div style="font-size: 10px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Correct</div>
                                </div>
                                <div style="font-size: 20px; font-weight: 700; color: #10b981;">{{ $session->correct_answers }}</div>
                            </div>
                            
                            <div style="text-align: center; padding: 12px; background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%); border-radius: 10px; border: 2px solid #fee2e2;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 6px;">
                                    <svg style="width: 16px; height: 16px; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <div style="font-size: 10px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Wrong</div>
                                </div>
                                <div style="font-size: 20px; font-weight: 700; color: #ef4444;">{{ $session->wrong_answers }}</div>
                            </div>
                            
                            <div style="text-align: center; padding: 12px; background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border-radius: 10px; border: 2px solid #fef3c7;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 6px;">
                                    <svg style="width: 16px; height: 16px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <div style="font-size: 10px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Score</div>
                                </div>
                                <div style="font-size: 20px; font-weight: 700; color: #f59e0b;">{{ $session->score }}%</div>
                            </div>
                        </div>
                        
                        <!-- View Details Link -->
                        <div style="margin-top: 16px; padding-top: 16px; border-top: 2px solid #f3f4f6; display: flex; align-items: center; justify-content: center; gap: 6px; color: #848177; font-size: 13px; font-weight: 600;">
                            <span>View Details</span>
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="text-align: center; padding: 45px 20px; background: white; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                    <div style="width: 60px; height: 60px; margin: 0 auto 16px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 30px; height: 30px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0;">No Quiz History</h3>
                    <p style="font-size: 14px; color: #6b7280; margin: 0 0 18px 0;">You haven't completed any quizzes yet. Start taking quizzes to see your results here.</p>
                    <a href="{{ route('user-quiz.index') }}" style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Start Taking Quizzes
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .session-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3), 0 10px 10px -5px rgba(102, 126, 234, 0.2) !important;
            border-color: #848177 !important;
        }

        a:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            div[style*="grid-template-columns: repeat(auto-fit, minmax(200px"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            div[style*="grid-template-columns: repeat(auto-fit, minmax(140px"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
    </style>
</x-app-layout>
