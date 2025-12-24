<x-app-layout>
    <x-slot name="header">
        <h2>Manage Modules</h2>
    </x-slot>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <!-- Header Section -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 25px; margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 5px 0;">Modules Management</h1>
                    <p style="font-size: 14px; color: #6b7280; margin: 0;">Manage and organize system modules</p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('modules.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Module
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-left: 4px solid #10b981;">
                <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-left: 4px solid #ef4444;">
                <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search Section -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 20px; margin-bottom: 25px;">
            <form method="GET" action="{{ route('modules.index') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px; position: relative;">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search modules by name..." 
                        style="width: 100%; padding: 12px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.3s ease; background: #f9fafb;"
                        onfocus="this.style.borderColor='#848177'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';"
                    >
                    <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button 
                    type="submit" 
                    style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 12px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(132, 129, 119, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(132, 129, 119, 0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(132, 129, 119, 0.3)';"
                >
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                @if(request('search'))
                    <a 
                        href="{{ route('modules.index') }}" 
                        style="display: inline-flex; align-items: center; gap: 8px; background: #f3f4f6; color: #6b7280; padding: 12px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#e5e7eb';"
                        onmouseout="this.style.background='#f3f4f6';"
                    >
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Card -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(180deg, #848177 0%, #000000 100%);">
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">ID</th>
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Module Name</th>
                            <th style="padding: 16px 20px; text-align: center; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                            <tr class="table-row" style="border-bottom: 1px solid #f3f4f6; transition: all 0.2s ease;">
                                <td style="padding: 18px 20px; color: #6b7280; font-size: 14px; font-weight: 500;">#{{ $module->id }}</td>
                                <td style="padding: 18px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(180deg, #848177 0%, #000000 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div style="color: #1f2937; font-size: 15px; font-weight: 600; margin-bottom: 2px;">{{ $module->name }}</div>
                                            <div style="color: #9ca3af; font-size: 12px;">Module</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 18px 20px;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <a href="{{ route('modules.edit', $module) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #f0f4ff; color: #848177; border-radius: 8px; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#e0e7ff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f0f4ff'; this.style.transform='scale(1)';" title="Edit Module">
                                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('modules.destroy', $module) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this module? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #fee2e2; color: #ef4444; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#fecaca'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#fee2e2'; this.style.transform='scale(1)';" title="Delete Module">
                                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 60px 20px; text-align: center;">
                                    <div style="max-width: 400px; margin: 0 auto;">
                                        <svg style="width: 80px; height: 80px; margin: 0 auto 20px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 8px;">No modules found</h3>                                       
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($modules->hasPages())
                <div style="padding: 20px; border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="color: #6b7280; font-size: 14px;">
                        Showing {{ $modules->firstItem() }} to {{ $modules->lastItem() }} of {{ $modules->total() }} modules
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        {{ $modules->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Table Row Hover Effect */
        .table-row:hover {
            background: #f9fafb !important;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            table {
                font-size: 13px;
            }
            
            th, td {
                padding: 12px 15px !important;
            }
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            background: white;
        }

        .pagination .page-link:hover:not(.disabled) {
            background: linear-gradient(180deg, #848177 0%, #000000 100%);
            color: white;
            border-color: #848177;
            transform: translateY(-2px);
        }

        .pagination .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none;
        }
    </style>
</x-app-layout>

