<x-app-layout>
    <x-slot name="header">
        <h2>Brand Details</h2>
    </x-slot>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <!-- Back Button -->
        <a href="{{ route('brands.index') }}" style="display: inline-flex; align-items: center; color: #848177; text-decoration: none; margin-bottom: 25px; font-size: 14px; font-weight: 500; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Brands
        </a>

        <!-- Main Card -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
            <!-- Header Section with Gradient -->
            <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 30px; color: white;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 5px 0;">{{ $brand->name }}</h1>
                            <p style="font-size: 14px; opacity: 0.9; margin: 0;">Created on {{ $brand->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('brands.edit', $brand) }}" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.2); color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; border: 1px solid rgba(255, 255, 255, 0.3);" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)';">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Brand
                        </a>
                        <form action="{{ route('brands.destroy', $brand) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this brand? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(239, 68, 68, 0.2); color: white; padding: 10px 20px; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(239, 68, 68, 0.3)';" onmouseout="this.style.background='rgba(239, 68, 68, 0.2)';">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Brand
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div style="padding: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); padding: 25px; border-radius: 12px; color: white;">
                    <div style="font-size: 36px; font-weight: 700; margin-bottom: 8px;">{{ $brand->users()->count() }}</div>
                    <div style="font-size: 14px; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Total Users
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 25px; border-radius: 12px; color: white;">
                    <div style="font-size: 36px; font-weight: 700; margin-bottom: 8px;">{{ $brand->quizzes()->count() }}</div>
                    <div style="font-size: 14px; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Total Quizzes
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 25px; border-radius: 12px; color: white;">
                    <div style="font-size: 36px; font-weight: 700; margin-bottom: 8px;">{{ $brand->quizCategories()->count() }}</div>
                    <div style="font-size: 14px; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Total Categories
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            @if($brand->users()->count() > 0)
                <div style="padding: 0 30px 30px 30px; border-top: 2px solid #f3f4f6; padding-top: 30px;">
                    <h3 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <svg style="width: 24px; height: 24px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Users in this Brand
                    </h3>
                    <div style="background: #f9fafb; border-radius: 12px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: linear-gradient(180deg, #848177 0%, #000000 100%);">
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">ID</th>
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Name</th>
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brand->users as $user)
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 16px 20px; color: #6b7280; font-size: 14px;">#{{ $user->id }}</td>
                                        <td style="padding: 16px 20px; color: #1f2937; font-size: 14px; font-weight: 500;">{{ $user->name }}</td>
                                        <td style="padding: 16px 20px; color: #6b7280; font-size: 14px;">{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Quiz Categories Section -->
            @if($brand->quizCategories()->count() > 0)
                <div style="padding: 0 30px 30px 30px; border-top: 2px solid #f3f4f6; padding-top: 30px;">
                    <h3 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <svg style="width: 24px; height: 24px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Quiz Categories in this Brand
                    </h3>
                    <div style="background: #f9fafb; border-radius: 12px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: linear-gradient(180deg, #848177 0%, #000000 100%);">
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">ID</th>
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Category Name</th>
                                    <th style="padding: 14px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Quizzes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brand->quizCategories as $category)
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 16px 20px; color: #6b7280; font-size: 14px;">#{{ $category->id }}</td>
                                        <td style="padding: 16px 20px; color: #1f2937; font-size: 14px; font-weight: 500;">{{ $category->name }}</td>
                                        <td style="padding: 16px 20px;">
                                            <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">{{ $category->quizzes()->count() }} quiz(es)</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
