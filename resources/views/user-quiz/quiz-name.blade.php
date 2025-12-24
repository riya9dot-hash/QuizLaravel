<x-app-layout>
    <x-slot name="header">
        <h2>{{ $quizName }} - Quiz Questions</h2>
    </x-slot>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('user-quiz.index') }}" style="color: #848177; text-decoration: none; font-size: 14px;">← Back to Categories</a>
            <a href="{{ route('user-quiz.history') }}" style="background: #10b981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">My Quiz History</a>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
            <h3 style="margin: 0 0 8px 0; font-size: 22px; font-weight: 600;">{{ $quizName }}</h3>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">{{ $quizzes->count() }} question(s) available</p>
        </div>

        @if($completedSession)
            <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <p style="margin: 0; color: #065f46; font-size: 14px;">
                    <strong>✓ You have completed this quiz!</strong> 
                    <a href="{{ route('user-quiz.session-details', $completedSession) }}" style="color: #059669; text-decoration: underline; margin-left: 10px;">View Results</a>
                </p>
            </div>
        @endif

        @if($quizzes->count() > 0)
            <div style="text-align: center; padding: 40px 20px;">
                @if(!$completedSession)
                    <a href="{{ route('user-quiz.start', ['quizName' => urlencode($quizName)]) }}" 
                       style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 18px 50px; text-decoration: none; border-radius: 10px; font-size: 20px; font-weight: 600; display: inline-block; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;"
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(16, 185, 129, 0.4)';"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(16, 185, 129, 0.3)';">
                        🚀 Start Quiz
                    </a>
                    <p style="margin-top: 20px; color: #666; font-size: 14px;">Click to start answering {{ $quizzes->count() }} questions</p>
                @else
                    <div style="background: #f0fdf4; border: 2px solid #10b981; border-radius: 10px; padding: 30px; margin-bottom: 25px; display: inline-block;">
                        <div style="font-size: 48px; margin-bottom: 15px;">✓</div>
                        <h4 style="margin: 0 0 10px 0; color: #065f46; font-size: 18px;">Quiz Completed!</h4>
                        <p style="margin: 0 0 20px 0; color: #666; font-size: 14px;">Score: <strong style="color: #10b981;">{{ $completedSession->score }}%</strong></p>
                        <a href="{{ route('user-quiz.session-details', $completedSession) }}" 
                           style="background: #10b981; color: white; padding: 10px 25px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500; display: inline-block; margin-right: 10px;">
                            View Details
                        </a>
                        <a href="{{ route('user-quiz.start', ['quizName' => urlencode($quizName)]) }}" 
                           style="background: #848177; color: white; padding: 10px 25px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500; display: inline-block;">
                            🔄 Retake Quiz
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #999;">
                <p>No questions available for this quiz.</p>
            </div>
        @endif
    </div>
</x-app-layout>

