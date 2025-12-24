<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: #f5f5f5;
                color: #333;
                overflow-x: hidden;
            }

            .layout-container {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar Styles */
            .sidebar {
                width: 250px;
                /* background: linear-gradient(180deg, #848177 0%, #000000100%); */
                background: linear-gradient(180deg, #848177 0%, #000000 100%);
                color: white;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                z-index: 1000;
            }

            .sidebar-header {
                padding: 20px;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }

            .sidebar-header h2 {
                font-size: 20px;
                font-weight: 600;
            }

            .sidebar-menu {
                padding: 20px 0;
            }

            .menu-item {
                display: block;
                padding: 12px 20px;
                color: rgba(255,255,255,0.9);
                text-decoration: none;
                transition: all 0.3s;
                border-left: 3px solid transparent;
            }

            .menu-item:hover {
                background: rgba(255,255,255,0.1);
                border-left-color: white;
                color: white;
            }

            .menu-item.active {
                background: rgba(255,255,255,0.15);
                border-left-color: white;
                color: white;
                font-weight: 600;
            }

            .menu-section {
                padding: 15px 20px 5px;
                font-size: 11px;
                text-transform: uppercase;
                color: rgba(255,255,255,0.6);
                font-weight: 600;
                letter-spacing: 1px;
            }

            .sidebar-footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                padding: 20px;
                border-top: 1px solid rgba(255,255,255,0.1);
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 15px;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
            }

            .user-details {
                flex: 1;
            }

            .user-name {
                font-size: 14px;
                font-weight: 600;
            }

            .user-role {
                font-size: 12px;
                color: rgba(255,255,255,0.7);
            }

            .logout-btn {
                width: 100%;
                padding: 10px;
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.2);
                color: white;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.3s;
            }

            .logout-btn:hover {
                background: rgba(255,255,255,0.2);
            }

            /* Main Content Area */
            .main-wrapper {
                flex: 1;
                margin-left: 250px;
                display: flex;
                flex-direction: column;
            }

            .top-header {
                background: white;
                padding: 15px 30px;
                border-bottom: 1px solid #e5e5e5;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .top-header h1 {
                font-size: 24px;
                font-weight: 600;
                color: #333;
            }

            .content-area {
                flex: 1;
                padding: 30px;
            }

            /* Card Styles */
            .card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                padding: 20px;
            }

            .card h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 15px;
                color: #333;
            }

            .card p {
                color: #666;
                margin-bottom: 10px;
            }

            .badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                margin: 5px 5px 5px 0;
            }

            .badge-blue {
                background-color: #dbeafe;
                color: #1e40af;
            }

            .badge-green {
                background-color: #d1fae5;
                color: #065f46;
            }

            .alert-box {
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                border-left: 4px solid;
            }

            .alert-success {
                background-color: #d1fae5;
                border-color: #10b981;
                color: #065f46;
            }

            .alert-info {
                background-color: #dbeafe;
                border-color: #3b82f6;
                color: #1e40af;
            }

            .alert-warning {
                background-color: #fef3c7;
                border-color: #f59e0b;
                color: #92400e;
            }

            .alert-danger {
                background-color: #fee2e2;
                border-color: #ef4444;
                color: #991b1b;
            }

            .permissions-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 10px;
            }

            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: linear-gradient(180deg, #848177 0%, #000000 100%);
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 500;
                transition: transform 0.2s, box-shadow 0.2s;
                border: none;
                cursor: pointer;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-success {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            }

            .btn-warning {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                color: #333;
                font-size: 14px;
                font-weight: 500;
                margin-bottom: 8px;
            }

            .form-group input {
                width: 100%;
                padding: 12px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                transition: border-color 0.3s;
            }

            .form-group input:focus {
                outline: none;
                border-color: #848177;
            }

            .btn-login {
                width: 100%;
                padding: 12px;
                background: linear-gradient(180deg, #848177 0%, #000000 100%);
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    width: 200px;
                }

                .main-wrapper {
                    margin-left: 200px;
                }

                .content-area {
                    padding: 20px;
                }
            }

            @media (max-width: 640px) {
                .sidebar {
                    transform: translateX(-100%);
                    transition: transform 0.3s;
                }

                .sidebar.open {
                    transform: translateX(0);
                }

                .main-wrapper {
                    margin-left: 0;
                }

                .mobile-menu-btn {
                    display: block;
                    position: fixed;
                    top: 15px;
                    left: 15px;
                    z-index: 1001;
                    background: #848177;
                    color: white;
                    border: none;
                    padding: 10px;
                    border-radius: 5px;
                    cursor: pointer;
                }
            }
        </style>
    </head>
    <body>
        <div class="layout-container">
            <!-- Left Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h2>{{ config('app.name', 'Laravel') }}</h2>
                </div>

                <nav class="sidebar-menu">
                    <div class="menu-section">Main</div>
                    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    @if(Auth::user()->hasRole('SuperAdmin'))
                        <div class="menu-section super-admin">Super Admin</div>
                        <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            Create Admin
                        </a>
                        <a href="{{ route('modules.index') }}" class="menu-item {{ request()->routeIs('modules.*') ? 'active' : '' }}">
                            Key Module
                        </a>
                       
                    @elseif(Auth::user()->hasRole('Admin'))
                        <div class="menu-section">Management</div>
                        <a href="{{ route('roles.index') }}" class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            Roles
                        </a>
                        <a href="{{ route('permissions.index') }}" class="menu-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                            Permissions
                        </a>
                        <a href="{{ route('brands.index') }}" class="menu-item {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                            Brands
                        </a>
                        <a href="{{ route('languages.index') }}" class="menu-item {{ request()->routeIs('languages.*') ? 'active' : '' }}">
                            Languages
                        </a>
                        <a href="{{ route('priority.index') }}" class="menu-item {{ request()->routeIs('priority.*') ? 'active' : '' }}">
                            Priority
                        </a>
                        <a href="{{ route('brand-users.index') }}" class="menu-item {{ request()->routeIs('brand-users.*') ? 'active' : '' }}">
                            Users
                        </a>
                        <a href="{{ route('quiz-category.index') }}" class="menu-item {{ request()->routeIs('quiz-category.*') ? 'active' : '' }}">
                            Quiz Category
                        </a>
                        <a href="{{ route('quiz.index') }}" class="menu-item {{ request()->routeIs('quiz.*') ? 'active' : '' }}">
                            Quiz
                        </a>
                    @else
                        <div class="menu-section">Quiz</div>
                        @if(Auth::user()->hasModulePermissionByName('User Create'))
                        <a href="{{ route('user-quiz.index') }}" class="menu-item {{ request()->routeIs('user-quiz.*') ? 'active' : '' }}">
                            Take Quiz
                        </a>
                        @endif
                        <a href="{{ route('user-quiz.history') }}" class="menu-item {{ request()->routeIs('user-quiz.history') ? 'active' : '' }}">
                            My Quiz History
                        </a>
                    @endif
                </nav>

                <div class="sidebar-footer">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">
                                @if(Auth::user()->hasRole('SuperAdmin'))
                                    SuperAdmin
                                @elseif(Auth::user()->hasRole('Admin'))
                                    Admin
                                @elseif(Auth::user()->hasRole('User'))
                                    User
                                @else
                                    User
                                @endif
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="main-wrapper">
                <header class="top-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h1>
                            @isset($header)
                                {{ $header }}
                            @else
                                Dashboard
                            @endisset
                        </h1>                       
                    </div>
                </header>

                <main class="content-area">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            // Mobile menu toggle
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('open');
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const isClickInside = sidebar.contains(event.target);
                const isMenuButton = event.target.classList.contains('mobile-menu-btn');
                
                if (!isClickInside && !isMenuButton && window.innerWidth <= 640) {
                    sidebar.classList.remove('open');
                }
            });
        </script>
    </body>
</html>
