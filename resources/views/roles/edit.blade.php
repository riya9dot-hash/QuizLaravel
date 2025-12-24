<x-app-layout>
    <x-slot name="header">
        <h2>Edit Role</h2>
    </x-slot>

    <div style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <!-- Back Button -->
        <a href="{{ route('roles.index') }}" style="display: inline-flex; align-items: center; color: #848177; text-decoration: none; margin-bottom: 25px; font-size: 14px; font-weight: 500; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Roles
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
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 5px 0;">Edit Role</h1>
                        <p style="font-size: 14px; opacity: 0.9; margin: 0;">Update role details and permissions</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('roles.update', $role) }}" style="padding: 35px;">
                @csrf
                @method('PUT')

                <!-- Role Name Input -->
                <div style="margin-bottom: 30px;">
                    <label for="name" style="display: block; color: #1f2937; font-size: 14px; font-weight: 600; margin-bottom: 10px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Role Name
                        </span>
                    </label>
                    <div style="position: relative;">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $role->name) }}" 
                               required 
                               placeholder="e.g., Manager, Editor, Viewer"
                               style="width: 100%; padding: 14px 16px; padding-left: 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: #f9fafb;"
                               onfocus="this.style.borderColor='#848177'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                        <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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

                <!-- Permissions Section -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <label style="display: block; color: #1f2937; font-size: 14px; font-weight: 600;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <svg style="width: 18px; height: 18px; color: #848177;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Permissions
                                <span id="permission-count" style="color: #6b7280; font-weight: 400; font-size: 13px; margin-left: 5px;">({{ count($permissions) }})</span>
                            </span>
                        </label>
                        @if(count($permissions) > 0)
                            <div style="display: flex; gap: 8px;">
                                <button type="button" onclick="selectAllPermissions()" style="padding: 6px 14px; background: white; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db';" onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
                                    Select All
                                </button>
                                <button type="button" onclick="deselectAllPermissions()" style="padding: 6px 14px; background: white; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db';" onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
                                    Deselect All
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Permissions Container with Grid Layout -->
                    <div class="permissions-container" style="max-height: 500px; overflow-y: auto; border: 2px solid #e5e7eb; padding: 20px; border-radius: 12px; background: #fafafa;">
                        @if(count($permissions) > 0)
                            <div class="permissions-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 10px;">
                                @foreach($permissions as $permission)
                                    <label class="permission-item" 
                                           style="display: flex; align-items: center; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="permission_{{ $permission->id }}"
                                               class="permission-checkbox"
                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                               style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; accent-color: #848177; flex-shrink: 0;">
                                        <span style="flex: 1; color: #1f2937; font-size: 14px; font-weight: 400; user-select: none; word-break: break-word;">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 50px 20px; color: #6b7280;">
                                <svg style="width: 64px; height: 64px; margin: 0 auto 20px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p style="font-size: 16px; font-weight: 500; margin-bottom: 10px; color: #374151;">No permissions available</p>
                                <p style="font-size: 14px; margin-bottom: 20px; color: #6b7280;">Create permissions first to assign them to roles</p>
                                <a href="{{ route('permissions.create') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #848177; text-decoration: none; font-weight: 600; padding: 10px 20px; background: #f0f4ff; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#e0e7ff';" onmouseout="this.style.background='#f0f4ff';">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create Permissions
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="padding-top: 20px; border-top: 2px solid #f3f4f6;">
                    <button type="submit" style="width: 100%; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 16px 24px; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Permission Item Hover Effects */
        .permission-item:hover {
            background: #f8f9ff !important;
            border-color: #848177 !important;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.1);
        }

        /* Checked State */
        .permission-item:has(.permission-checkbox:checked) {
            background: #f0f4ff !important;
            border-color: #848177 !important;
        }

        /* Custom Scrollbar */
        .permissions-container::-webkit-scrollbar {
            width: 8px;
        }

        .permissions-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .permissions-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .permissions-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive Grid Layout */
        @media (max-width: 768px) {
            .permissions-grid {
                grid-template-columns: 1fr !important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .permissions-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        @media (min-width: 1025px) {
            .permissions-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
    </style>

    <script>
        // Select All Permissions
        function selectAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        // Deselect All Permissions
        function deselectAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    </script>
</x-app-layout>
