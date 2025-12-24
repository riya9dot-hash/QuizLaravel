<x-app-layout>
    <x-slot name="header">
        <h2>Take Quiz</h2>
    </x-slot>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <a href="{{ route('user-quiz.index') }}" style="color: #848177; text-decoration: none; margin-bottom: 15px; display: inline-block; font-size: 13px;">← Back to Quizzes</a>

        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 15px 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500; opacity: 0.9;">Quiz ID: {{ $quiz->id }}</h3>
        </div>

        <div style="background: #f0f4ff; border-left: 4px solid #848177; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #333; font-size: 18px;">Question</h3>
            <p style="margin: 0; color: #555; font-size: 15px; line-height: 1.6;">{{ $quiz->question }}</p>
        </div>

        <form method="POST" action="{{ route('user-quiz.submit', $quiz) }}">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="answer" style="display: block; color: #333; font-size: 14px; font-weight: 600; margin-bottom: 12px;">Select Your Answer:</label>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <label style="display: flex; align-items: center; cursor: pointer; padding: 12px 15px; background: white; border: 2px solid #e5e5e5; border-radius: 6px; transition: all 0.2s ease;">
                        <input type="radio" name="answer" value="true" id="answer_true" required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177;">
                        <span style="font-size: 15px; font-weight: 500; color: #333;">True</span>
                    </label>
                    <label style="display: flex; align-items: center; cursor: pointer; padding: 12px 15px; background: white; border: 2px solid #e5e5e5; border-radius: 6px; transition: all 0.2s ease;">
                        <input type="radio" name="answer" value="false" id="answer_false" required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177;">
                        <span style="font-size: 15px; font-weight: 500; color: #333;">False</span>
                    </label>
                    <label style="display: flex; align-items: center; cursor: pointer; padding: 12px 15px; background: white; border: 2px solid #e5e5e5; border-radius: 6px; transition: all 0.2s ease;">
                        <input type="radio" name="answer" value="both" id="answer_both" required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177;">
                        <span style="font-size: 15px; font-weight: 500; color: #333;">Both</span>
                    </label>
                </div>
                @error('answer')
                    <div style="color: #ef4444; margin-top: 8px; font-size: 13px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login" style="width: 100%; padding: 12px; font-size: 16px;">Submit Answer</button>
        </form>
    </div>

    <style>
        label:has(input:checked) {
            background-color: #f0f4ff !important;
            border-color: #848177 !important;
        }
    </style>
</x-app-layout>

