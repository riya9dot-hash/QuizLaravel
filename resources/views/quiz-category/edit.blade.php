<x-app-layout>
    <x-slot name="header">
        <h2>Edit Quiz Category</h2>
    </x-slot>

    <div style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <!-- Back Button -->
        <a href="{{ route('quiz-category.index') }}" style="display: inline-flex; align-items: center; color: #848177; text-decoration: none; margin-bottom: 25px; font-size: 14px; font-weight: 500; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>

        <!-- Main Card -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
            <!-- Header Section with Gradient -->
            <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 30px; color: white;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 5px 0;">Edit Quiz Category</h1>
                        <p style="font-size: 14px; opacity: 0.9; margin: 0;">Update category details and brand assignments</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('quiz-category.update', $quizCategory) }}" style="padding: 35px;">
                @csrf
                @method('PUT')

                <!-- Brands Selection -->
                <div style="margin-bottom: 30px;">
                    <label for="brand_ids" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Brands (Select Multiple)
                        </span>
                    </label>
                    <div style="position: relative;">
                        @php
                            $selectedBrandIds = old('brand_ids', $quizCategory->brands->pluck('id')->toArray());
                        @endphp
                        <select id="brand_ids" 
                                name="brand_ids[]" 
                                multiple 
                                required 
                                style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb; min-height: 150px;"
                                onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ in_array($brand->id, $selectedBrandIds) ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; left: 16px; top: 20px; width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <small style="color: #6b7280; display: block; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Hold Ctrl (Windows) or Cmd (Mac) to select multiple brands
                    </small>
                    @error('brand_ids')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                    @error('brand_ids.*')
                        <div style="color: #ef4444; margin-top: 8px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Category Name Input -->
                <div style="margin-bottom: 30px;">
                    <label for="name" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Category Name
                        </span>
                    </label>
                    <div style="position: relative;">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $quizCategory->name) }}" 
                               required 
                               placeholder="e.g., Math, Science, History"
                               style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb;"
                               onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                        <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    @error('name')
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
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
