<x-app-layout>
    <x-slot name="header">
        Dashboard - {{ $user->name }}
    </x-slot>

    <!-- User Info Card -->
    <div class="card">
        <h3>User Information</h3>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <!-- Roles Card -->
    <div class="card">
        <h3>Your Roles</h3>
        @if($roles->count() > 0)
            <div>
                @foreach($roles as $role)
                    <span class="badge badge-blue">{{ $role }}</span>
                @endforeach
            </div>
        @else
            <p>No roles assigned</p>
        @endif
    </div>

    <!-- Permissions Card -->
    {{-- <div class="card">
        <h3>Your Permissions</h3>
        @if($permissions->count() > 0)
            <div class="permissions-grid">
                @foreach($permissions as $permission)
                    <span class="badge badge-green">{{ $permission }}</span>
                @endforeach
            </div>
        @else
            <p>No permissions assigned</p>
        @endif
    </div> --}}

  

    <!-- Admin Panel -->
    @if($user->hasRole('Admin'))
        {{-- <div class="card">
            <h3>Admin Management Panel</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                <a href="{{ route('roles.index') }}" class="btn btn-success">
                    Manage Roles
                </a>
                <a href="{{ route('permissions.index') }}" class="btn btn-warning">
                    Manage Permissions
                </a>
            </div>
            <div class="alert-box alert-info" style="margin-top: 20px;">
                <h4 style="margin-bottom: 10px; font-weight: 600;">Admin Access</h4>
                <p>You can manage all roles and permissions in the system.</p>
            </div>
        </div> --}}

        <!-- Created Roles by Admin -->
        {{-- <div class="card">
            <h3>Roles Created by Admin</h3>
            @if($createdRoles->count() > 0)
                <div style="margin-top: 15px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                                <th style="padding: 12px; text-align: left;">Role Name</th>
                                <th style="padding: 12px; text-align: left;">Permissions</th>
                                <th style="padding: 12px; text-align: left;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($createdRoles as $role)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 12px;">
                                        <strong>{{ $role->name }}</strong>
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions as $permission)
                                                <span class="badge badge-green" style="font-size: 11px;">{{ $permission->name }}</span>
                                            @endforeach
                                        @else
                                            <span style="color: #999; font-size: 12px;">No permissions</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        <a href="{{ route('roles.edit', $role) }}" style="color: #848177; text-decoration: none; margin-right: 10px; font-size: 14px;">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: #666; margin-top: 15px;">No roles created yet. <a href="{{ route('roles.create') }}" style="color: #848177;">Create your first role</a></p>
            @endif
        </div> --}}
    @endif

    <!-- Role-Based Content -->
    {{-- <div class="card">
        <h3>Welcome</h3>
        
        @if($user->hasRole('SuperAdmin'))
            <div class="alert-box alert-danger">
                <h4 style="margin-bottom: 10px; font-weight: 600;">Super Admin</h4>
                <p>You can create admin users. Admin users will automatically receive the "Admin" role.</p>
            </div>
        @endif

        @if($user->hasRole('Admin'))
            <div class="alert-box alert-info">
                <h4 style="margin-bottom: 10px; font-weight: 600;">Admin</h4>
                <p>You can manage roles and permissions. Use the sidebar navigation to access management features.</p>
            </div>
        @endif

        @if(!$user->hasAnyRole(['SuperAdmin', 'Admin']))
            <div class="alert-box alert-warning">
                <p>No specific role assigned. Please contact administrator.</p>
            </div>
        @endif
    </div> --}}

    <!-- Quiz Section for Normal Users (User role) -->
    {{-- @if($user->hasRole('User') || !$user->hasAnyRole(['SuperAdmin', 'Admin']))
        <div class="card">
            <h3>Quiz Section</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                <a href="{{ route('user-quiz.index') }}" class="btn">
                    Take Quiz
                </a>
                <a href="{{ route('user-quiz.history') }}" class="btn btn-success">
                    My Quiz History
                </a>
            </div>
            <div class="alert-box alert-info" style="margin-top: 20px;">
                <h4 style="margin-bottom: 10px; font-weight: 600;">Welcome to Quiz App</h4>
                <p>You can take quizzes and view your results. Click "Take Quiz" to start answering questions.</p>
            </div>
        </div>
    @endif --}}
</x-app-layout>
