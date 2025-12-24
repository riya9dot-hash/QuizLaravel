<x-app-layout>
    <x-slot name="header">
        <h2>Edit Language</h2>
    </x-slot>

    <div style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <!-- Back Button -->
        <a href="{{ route('languages.index') }}" style="display: inline-flex; align-items: center; color: #848177; text-decoration: none; margin-bottom: 25px; font-size: 14px; font-weight: 500; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Languages
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
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 5px 0;">Edit Language</h1>
                        <p style="font-size: 14px; opacity: 0.9; margin: 0;">Update language details</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('languages.update', $language) }}" style="padding: 35px;">
                @csrf
                @method('PUT')

                <!-- Language Name Input -->
                <div style="margin-bottom: 30px;">
                    <label for="name" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            Language Name
                        </span>
                    </label>
                    <div style="position: relative;">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $language->name) }}" 
                               required 
                               placeholder="e.g., English, Spanish, French"
                               style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb;"
                               onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                        <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
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
                        Update Language
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
