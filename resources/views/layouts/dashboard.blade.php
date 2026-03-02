<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIGMA Portal') - Guidance & Monitoring Assistance</title>
    
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: #f8fafc;
            color: #334155;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: #ffffff;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #1e293b;
            text-decoration: none;
        }
        
        .sidebar-logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }
        
        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-logo-name {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .sidebar-logo-subtitle {
            font-size: 0.65rem;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-section-title {
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #475569;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover {
            background: #f8fafc;
            color: #1e293b;
            border-left-color: #20B2AA;
        }
        
        .nav-link.active {
            background: rgba(32, 178, 170, 0.15);
            color: #20B2AA;
            border-left-color: #20B2AA;
            font-weight: 600;
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .nav-link-text {
            flex: 1;
        }
        
        .nav-link-badge {
            background: #20B2AA;
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Top Header */
        .top-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f8fafc;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-dropdown:hover {
            background: #f1f5f9;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 200px;
            margin-top: 0.75rem !important;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(32, 178, 170, 0.1);
            color: #20B2AA;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e2e8f0;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #20B2AA 0%, #008B8B 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #64748b;
        }
        
        /* Content Area */
        .content-area {
            flex: 1;
            padding: 2rem;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        
        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #20B2AA 0%, #008B8B 100%);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #20B2AA 0%, #008B8B 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .stat-change.positive {
            background: #ecfdf5;
            color: #059669;
        }
        
        .stat-change.negative {
            background: #fef2f2;
            color: #dc2626;
        }
        
        /* Buttons */
        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #20B2AA 0%, #008B8B 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(32,178,170,0.3);
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
        }
        
        /* Badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #ecfdf5;
            color: #059669;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-danger {
            background: #fef2f2;
            color: #dc2626;
        }
        
        .badge-info {
            background: #eff6ff;
            color: #2563eb;
        }
        
        /* Sidebar overlay backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }
        .sidebar-backdrop.active {
            display: block;
        }

        /* Hamburger button - hidden on desktop */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #475569;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            line-height: 1;
        }
        .sidebar-toggle:hover { background: #f1f5f9; }

        /* Responsive tables */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* ── Tablet (≤992px) ── */
        @media (max-width: 992px) {
            .sidebar {
                width: 260px;
                transform: translateX(-100%);
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: inline-flex;
                align-items: center;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            .top-header {
                padding: 0.875rem 1.25rem;
            }
            .content-area {
                padding: 1.25rem;
            }
        }

        /* ── Mobile (≤576px) ── */
        @media (max-width: 576px) {
            .sidebar {
                width: 280px;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
                margin-bottom: 1rem;
            }
            .stat-card {
                padding: 1rem;
            }
            .stat-value {
                font-size: 1.5rem;
            }
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }
            .content-area {
                padding: 0.875rem;
            }
            .top-header {
                padding: 0.75rem 1rem;
            }
            .page-title {
                font-size: 1.1rem;
            }
            /* Hide user name/role text on very small screens */
            .user-info {
                display: none;
            }
            .user-dropdown {
                padding: 0.375rem;
                gap: 0.375rem;
            }
            /* Card adjustments */
            .card-header {
                padding: 1rem;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .card-body {
                padding: 1rem;
            }
            /* Stack card-header flex items */
            .card-header.d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .card-header.d-flex .btn {
                width: 100%;
                justify-content: center;
            }
            /* Table font size */
            .table th, .table td {
                padding: 0.625rem 0.75rem;
                font-size: 0.8rem;
            }
            /* Buttons */
            .btn {
                padding: 0.5rem 0.875rem;
                font-size: 0.8rem;
            }
            /* Row cols on mobile */
            .row > [class*="col-md-"] {
                margin-bottom: 1rem;
            }
            /* Modal full-width on mobile */
            .modal-dialog {
                margin: 0.5rem;
            }
            .modal-content {
                border-radius: 12px;
            }
        }

        /* ── Extra small (≤400px) ── */
        @media (max-width: 400px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .stat-card {
                padding: 0.875rem;
            }
        }

        /* ── Action buttons: wrap on mobile ── */
        @media (max-width: 768px) {
            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            .btn-group .btn {
                border-radius: 6px !important;
                flex: 1 1 auto;
                min-width: 0;
                white-space: nowrap;
                font-size: 0.75rem;
                padding: 0.35rem 0.5rem;
            }
            /* Hide icon-only labels on very small screens to save space */
            .btn-sm .btn-label { display: none; }
        }

        /* ── Bootstrap col-md-6 stacks on mobile ── */
        @media (max-width: 767px) {
            .col-md-6, .col-md-4, .col-md-3, .col-md-8 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
            }
            .col-md-6 + .col-md-6 { margin-top: 1rem; }
        }

        /* ── Forms responsive ── */
        @media (max-width: 576px) {
            .form-control, .form-select {
                font-size: 0.9rem;
            }
            /* Alert messages */
            .alert { font-size: 0.875rem; padding: 0.75rem 1rem; }
            /* Modal dialog full width */
            .modal-dialog { margin: 0.375rem; max-width: calc(100vw - 0.75rem); }
            .modal-lg { max-width: calc(100vw - 0.75rem); }
            .modal-body { padding: 1rem; }
            .modal-header { padding: 0.875rem 1rem; }
            .modal-footer {
                padding: 0.75rem 1rem;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .modal-footer .btn { flex: 1; justify-content: center; }
            /* Table: hide less important columns on mobile */
            .table-hide-mobile { display: none; }
            /* Stat change text truncate */
            .stat-change { font-size: 0.7rem; }
            /* Nav badge */
            .nav-link-badge { font-size: 0.65rem; padding: 0.1rem 0.4rem; }
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        .sidebar-dev-credit {
            font-size: 0.7rem;
            color: #94a3b8;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-dev-credit span {
            font-weight: 600;
            color: #64748b;
        }

        /* ── Sidebar close button ── */
        .sidebar-close {
            display: none;
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #64748b;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            line-height: 1;
        }
        .sidebar-close:hover { background: #f1f5f9; }
        @media (max-width: 992px) {
            .sidebar-header { position: relative; padding-right: 3rem; }
            .sidebar-close { display: block; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-logo">
                <img src="{{ asset('logo.png') }}" alt="SIGMA">
                <div class="sidebar-logo-text">
                    <span class="sidebar-logo-name">SIGMA</span>
                    <span class="sidebar-logo-subtitle">Guidance & Monitoring Assistance</span>
                </div>
            </a>
            <button class="sidebar-close" onclick="closeSidebar()" aria-label="Close menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav" style="display:flex; flex-direction:column; height:calc(100vh - 81px);">
            @auth
                @if(Auth::user()->role_id == 1) <!-- Student -->
                    <div class="nav-section">
                        <div class="nav-section-title">Main</div>
                        <a href="{{ route('student.dashboard') }}" class="nav-link @if(request()->is('student/dashboard')) active @endif">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                        <a href="{{ route('student.concerns.create') }}" class="nav-link @if(request()->is('student/concerns/create')) active @endif">
                            <i class="bi bi-plus-circle"></i>
                            <span class="nav-link-text">Submit Concern</span>
                        </a>
                        <a href="{{ route('student.concerns.index') }}" class="nav-link @if(request()->is('student/concerns') && !request()->is('student/concerns/create')) active @endif">
                            <i class="bi bi-chat-dots"></i>
                            <span class="nav-link-text">My Concerns</span>
                        </a>
                        <a href="{{ route('student.appointments.index') }}" class="nav-link @if(request()->is('student/appointments*')) active @endif">
                            <i class="bi bi-calendar3"></i>
                            <span class="nav-link-text">Appointments</span>
                        </a>
                        <a href="{{ route('student.resources') }}" class="nav-link @if(request()->is('student/resources')) active @endif">
                            <i class="bi bi-journal-bookmark"></i>
                            <span class="nav-link-text">Resources</span>
                        </a>
                    </div>
                    
                @elseif(Auth::user()->role_id == 2) <!-- Counselor -->
                    <div class="nav-section">
                        <div class="nav-section-title">Main</div>
                        <a href="{{ route('counselor.dashboard') }}" class="nav-link @if(request()->is('counselor/dashboard')) active @endif">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                        <a href="{{ route('counselor.concerns.index') }}" class="nav-link @if(request()->is('counselor/concerns*')) active @endif">
                            <i class="bi bi-chat-dots"></i>
                            <span class="nav-link-text">Student Concerns</span>
                            <span class="nav-link-badge">{{ App\Models\Concern::where('status', 'submitted')->count() }}</span>
                        </a>
                        <a href="{{ route('counselor.appointments.index') }}" class="nav-link @if(request()->is('counselor/appointments*')) active @endif">
                            <i class="bi bi-calendar3"></i>
                            <span class="nav-link-text">Appointments</span>
                        </a>
                    </div>
                    
                @elseif(Auth::user()->role_id == 3) <!-- Admin -->
                    <div class="nav-section">
                        <div class="nav-section-title">Main</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->is('admin/dashboard')) active @endif">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link @if(request()->is('admin/users*')) active @endif">
                            <i class="bi bi-people"></i>
                            <span class="nav-link-text">User Management</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nav-link @if(request()->is('admin/categories*')) active @endif">
                            <i class="bi bi-tags"></i>
                            <span class="nav-link-text">Categories</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="nav-link @if(request()->is('admin/reports*')) active @endif">
                            <i class="bi bi-graph-up"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                    </div>
                @endif
                
                <div class="nav-section">
                    <div class="nav-section-title">Account</div>
                    <a href="{{ route('settings') }}" class="nav-link @if(request()->is('settings')) active @endif">
                        <i class="bi bi-gear"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                </div>
            @endauth

            <div style="flex:1;"></div>
            <div class="sidebar-footer">
                <div class="sidebar-dev-credit">
                    Developed by <span>Crisvin Habitsuela</span>
                </div>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            
            <div class="header-right">
                @auth
                    <div class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="user-avatar"
                                 style="object-fit:cover;padding:0;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">
                                @if(Auth::user()->role_id == 1) Student
                                @elseif(Auth::user()->role_id == 2) Counselor
                                @elseif(Auth::user()->role_id == 3) Administrator
                                @endif
                            </span>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end" style="margin-top: 0.5rem;">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>
    
    <!-- Sidebar backdrop -->  
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarBackdrop').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) closeSidebar();
            });
        });

        // Close sidebar on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) closeSidebar();
        });
    </script>
</body>
</html>
