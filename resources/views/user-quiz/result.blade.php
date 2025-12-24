<x-app-layout>
    <x-slot name="header">
        <h2>Quiz Result</h2>
    </x-slot>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <a href="{{ route('user-quiz.index') }}" style="color: #848177; text-decoration: none; margin-bottom: 15px; display: inline-block; font-size: 13px;">← Back to Quizzes</a>

        @if(session('success'))
            <div class="alert-box alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert-box alert-info" style="margin-bottom: 20px;">
                {{ session('info') }}
            </div>
        @endif

        <div style="background: {{ $attempt->is_correct ? '#d1fae5' : '#fee2e2' }}; border-left: 4px solid {{ $attempt->is_correct ? '#10b981' : '#ef4444' }}; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                @if($attempt->is_correct)
                    <div style="width: 50px; height: 50px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold;">✓</div>
                @else
                    <div style="width: 50px; height: 50px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold;">✗</div>
                @endif
                <div>
                    <h3 style="margin: 0; color: #333; font-size: 20px;">
                        {{ $attempt->is_correct ? 'Correct Answer!' : 'Incorrect Answer' }}
                    </h3>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Your answer was {{ ucfirst($attempt->user_answer) }}</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 15px 20px; border-radius: 5px; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 500;">Quiz ID: {{ $quiz->id }}</h3>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h4 style="margin: 0 0 15px 0; color: #333; font-size: 16px;">Question:</h4>
            <p style="margin: 0 0 15px 0; color: #555; font-size: 15px; line-height: 1.6;">{{ $quiz->question }}</p>
            
            <div style="margin-top: 15px;">
                <p style="margin: 0 0 8px 0; color: #666; font-size: 13px;"><strong>Your Answer:</strong> <span style="color: #333;">{{ ucfirst($attempt->user_answer) }}</span></p>
                <p style="margin: 0; color: #666; font-size: 13px;"><strong>Correct Answer:</strong> <span style="color: #10b981; font-weight: 600;">{{ ucfirst($quiz->answer) }}</span></p>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('user-quiz.index') }}" class="btn" style="text-decoration: none; display: inline-block;">Back to Quiz List</a>
            <a href="{{ route('user-quiz.history') }}" class="btn" style="text-decoration: none; display: inline-block; margin-left: 10px; background: #10b981;">View All Results</a>
        </div>
    </div>
</x-app-layout>

