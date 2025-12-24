<x-app-layout>
    <x-slot name="header">
        <h2>Create New Quiz</h2>
    </x-slot>

    <div style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <!-- Back Button -->
        <a href="{{ route('quiz.index') }}" style="display: inline-flex; align-items: center; color: #848177; text-decoration: none; margin-bottom: 25px; font-size: 14px; font-weight: 500; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quiz
        </a>

        <!-- Main Card -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
            <!-- Header Section with Gradient -->
            <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 30px; color: white;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 5px 0;">Create New Quiz</h1>
                        <p style="font-size: 14px; opacity: 0.9; margin: 0;">Define a new quiz question and answer</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('quiz.store') }}" style="padding: 35px;">
                @csrf

                <!-- Quiz Category Selection -->
                <div style="margin-bottom: 30px;">
                    <label for="category_id" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Quiz Category
                        </span>
                    </label>
                    <div style="position: relative;">
                        <select id="category_id" 
                                name="category_id" 
                                required 
                                style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb;"
                                onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                            <option value="">Select Quiz Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    @error('category_id')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Question Input -->
                <div style="margin-bottom: 30px;">
                    <label for="question" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Question
                        </span>
                    </label>
                    <div style="position: relative;">
                        <textarea id="question" 
                                  name="question" 
                                  rows="4" 
                                  required 
                                  placeholder="Enter your question here..."
                                  style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb; resize: vertical; font-family: inherit;"
                                  onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                  onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">{{ old('question') }}</textarea>
                        <svg style="position: absolute; left: 16px; top: 18px; width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @error('question')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Answer Selection -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Answer
                        </span>
                    </label>
                    <div style="display: flex; gap: 12px;">
                        <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 20px; background: white; border: 2px solid #e5e7eb; border-radius: 10px; transition: all 0.2s ease; flex: 1;" onmouseover="if(!this.querySelector('input').checked) this.style.borderColor='#d1d5db'; this.style.background='#f9fafb';" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='#e5e7eb'; this.style.background='white';">
                            <input type="radio" name="answer" value="true" id="answer_true" {{ old('answer') == 'true' ? 'checked' : '' }} required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177; flex-shrink: 0;" onchange="updateAnswerStyles()">
                            <span style="font-size: 15px; font-weight: 500; color: #1f2937; user-select: none;">True</span>
                        </label>
                        <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 20px; background: white; border: 2px solid #e5e7eb; border-radius: 10px; transition: all 0.2s ease; flex: 1;" onmouseover="if(!this.querySelector('input').checked) this.style.borderColor='#d1d5db'; this.style.background='#f9fafb';" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='#e5e7eb'; this.style.background='white';">
                            <input type="radio" name="answer" value="false" id="answer_false" {{ old('answer') == 'false' ? 'checked' : '' }} required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177; flex-shrink: 0;" onchange="updateAnswerStyles()">
                            <span style="font-size: 15px; font-weight: 500; color: #1f2937; user-select: none;">False</span>
                        </label>
                        <label class="answer-option" style="display: flex; align-items: center; cursor: pointer; padding: 14px 20px; background: white; border: 2px solid #e5e7eb; border-radius: 10px; transition: all 0.2s ease; flex: 1;" onmouseover="if(!this.querySelector('input').checked) this.style.borderColor='#d1d5db'; this.style.background='#f9fafb';" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='#e5e7eb'; this.style.background='white';">
                            <input type="radio" name="answer" value="both" id="answer_both" {{ old('answer') == 'both' ? 'checked' : '' }} required style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177; flex-shrink: 0;" onchange="updateAnswerStyles()">
                            <span style="font-size: 15px; font-weight: 500; color: #1f2937; user-select: none;">Both</span>
                        </label>
                    </div>
                    @error('answer')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Priority Selection -->
                <div style="margin-bottom: 30px;">
                    <label for="priority_id" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Priority
                        </span>
                    </label>
                    <div style="position: relative;">
                        <select id="priority_id" 
                                name="priority_id" 
                                required 
                                style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb;"
                                onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                            <option value="">Select Priority</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>{{ $priority->name }} ({{ $priority->point }} points)</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    @error('priority_id')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="padding-top: 20px; border-top: 2px solid #f3f4f6;">
                    <button type="submit" style="width: 100%; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 16px 24px; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Answer Option Checked State */
        .answer-option:has(input:checked) {
            background: #f0f4ff !important;
            border-color: #848177 !important;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.1);
        }

        /* Responsive Answer Options */
        @media (max-width: 768px) {
            .answer-option {
                flex-direction: column;
                text-align: center;
                padding: 12px !important;
            }
        }
    </style>

    <script>
        function updateAnswerStyles() {
            const options = document.querySelectorAll('.answer-option');
            options.forEach(option => {
                const input = option.querySelector('input[type="radio"]');
                if (input.checked) {
                    option.style.background = '#f0f4ff';
                    option.style.borderColor = '#848177';
                    option.style.boxShadow = '0 2px 4px rgba(102, 126, 234, 0.1)';
                } else {
                    option.style.background = 'white';
                    option.style.borderColor = '#e5e7eb';
                    option.style.boxShadow = 'none';
                }
            });
        }

        // Initialize styles on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateAnswerStyles();
        });
    </script>
</x-app-layout>
