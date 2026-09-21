<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BNHS Care Konek') - Referral & Case Management System</title>
    
    @vite(['resources/css/app.css'])
    @stack('styles')
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --navy: #0d2d52;
            --green: #1e7a4a;
            --green-dark: #145e38;
            --gold: #f5c518;
            --accent: #1a3a3a;
            --text-dark: #0d2d52;
            --text-body: #3d5a7a;
            --text-muted: #64748b;
            --bg-page: #edf2f7;
            --bg-light: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(160deg, #eaf6f0 0%, #e8f4fb 50%, #eef6f0 100%);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            position: relative;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #eaf6f0 0%, #e8f4fb 50%, #eef6f0 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: hidden;
            box-shadow: 2px 0 16px rgba(13, 45, 82, 0.06);
            border-right: 1px solid rgba(30, 122, 74, 0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(30, 122, 74, 0.15);
            background: linear-gradient(135deg, rgba(30, 122, 74, 0.08) 0%, rgba(30, 122, 74, 0.04) 100%);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--navy);
            text-decoration: none;
        }
        
        .sidebar-logo img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }
        
        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-logo-name {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: var(--navy);
        }
        
        .sidebar-logo-subtitle {
            font-size: 0.65rem;
            opacity: 0.9;
            letter-spacing: 0.5px;
            color: var(--green);
            font-weight: 600;
        }
        
        .sidebar-nav {
            padding: 0.5rem 0;
            overflow-y: hidden;
            overflow-x: hidden;
            height: calc(100vh - 81px);
            position: relative;
        }
        
        /* Subtle botanical decoration in sidebar */
        .sidebar-nav::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: linear-gradient(to top, rgba(30, 122, 74, 0.04) 0%, transparent 100%);
            pointer-events: none;
        }
        
        /* Decorative leaves in sidebar */
        .sidebar-leaf {
            position: absolute;
            pointer-events: none;
            opacity: 0.08;
            color: var(--green);
            z-index: 1;
        }
        
        .sidebar-leaf-top {
            top: 120px;
            right: 20px;
            font-size: 4rem;
            transform: rotate(25deg);
        }
        
        .sidebar-leaf-bottom {
            bottom: 80px;
            left: 15px;
            font-size: 3.5rem;
            transform: rotate(-35deg);
        }
        
        .sidebar-leaf-middle {
            top: 50%;
            right: 15px;
            font-size: 2.5rem;
            transform: translateY(-50%) rotate(15deg);
            opacity: 0.05;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }
        
        .nav-section-title {
            padding: 0 1.5rem;
            margin-bottom: 0.35rem;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: var(--text-body);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.7);
            color: var(--green);
            border-left-color: var(--green);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.9);
            color: var(--green);
            border-left-color: var(--green);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(30, 122, 74, 0.15);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .nav-link-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .nav-link-badge {
            background: #1e7a4a;
            color: white;
            padding: 0.125rem 0.4rem;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
            width: calc(100vw - 280px);
            max-width: calc(100vw - 280px);
        }
        
        /* Decorative botanical elements */
        .main-content::before {
            content: '';
            position: fixed;
            top: -80px;
            left: 280px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(ellipse, rgba(30, 122, 74, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* Top Header */
        .top-header {
            background: linear-gradient(90deg, #eaf6f0 0%, #e8f4fb 50%, #eef6f0 100%);
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(30, 122, 74, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 16px rgba(13, 45, 82, 0.06);
        }
        
        .top-header > * {
            position: relative;
        }
        
        /* Decorative leaves in header */
        .header-leaf {
            position: absolute;
            pointer-events: none;
            opacity: 0.06;
            color: var(--green);
            z-index: 1;
        }
        
        .header-leaf-left {
            top: 50%;
            left: 320px;
            font-size: 3rem;
            transform: translateY(-50%) rotate(-25deg);
        }
        
        .header-leaf-right {
            top: 50%;
            right: 40px;
            font-size: 2.5rem;
            transform: translateY(-50%) rotate(35deg);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: -0.3px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }
        
        .header-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12));
            border-radius: 50%;
            color: #1e7a4a;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 2px 8px rgba(30, 122, 74, 0.1);
        }
        
        .header-icon-link:hover {
            background: linear-gradient(135deg, #1e7a4a, #145e38);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(30, 122, 74, 0.3);
        }
        
        .header-icon-link .badge {
            font-size: 0.65rem;
            padding: 0.25em 0.5em;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12));
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(30, 122, 74, 0.1);
        }
        
        .user-dropdown:hover {
            background: linear-gradient(135deg, rgba(30, 122, 74, 0.18), rgba(20, 94, 56, 0.18));
            box-shadow: 0 4px 12px rgba(30, 122, 74, 0.15);
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
            background: rgba(30,122,74,0.1);
            color: #1e7a4a;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e2e8f0;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e7a4a 0%, #145e38 100%);
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
            position: relative;
            z-index: 1;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }
        
        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(6px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 16px rgba(13, 45, 82, 0.06);
            transition: all 0.35s ease;
        }
        
        .card:hover {
            box-shadow: 0 20px 50px rgba(13, 45, 82, 0.1);
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.95);
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
            background: linear-gradient(180deg, #1e7a4a 0%, #145e38 100%);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #1e7a4a 0%, #145e38 100%);
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
            background: linear-gradient(135deg, #1e7a4a 0%, #145e38 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30,122,74,0.3);
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
            background: rgba(255, 255, 255, 0.9);
            border: none;
            font-size: 1.5rem;
            color: var(--green);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 10px;
            line-height: 1;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(13, 45, 82, 0.08);
            transition: all 0.3s ease;
        }
        .sidebar-toggle:hover { 
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 12px rgba(13, 45, 82, 0.12);
            transform: scale(1.05);
        }

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
                width: 100vw;
                max-width: 100vw;
                overflow-x: hidden;
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
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
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
                padding: 1rem;
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
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

        /* Pagination fixes */
        .pagination {
            margin-top: 1.5rem !important;
            margin-bottom: 1rem !important;
            display: flex !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
            gap: 0.25rem !important;
        }
        .pagination .page-item .page-link {
            padding: 0.45rem 0.75rem !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            line-height: 1.4 !important;
            box-shadow: none !important;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #1e7a4a 0%, #145e38 100%) !important;
            border-color: #1e7a4a !important;
            color: #fff !important;
        }
        .pagination .page-item.disabled .page-link {
            color: #94a3b8 !important;
            background: #f8fafc !important;
        }
        .pagination .page-item .page-link:hover {
            background: #f1f5f9 !important;
            color: #1e293b !important;
        }
        .pagination .page-item.active .page-link:hover {
            background: linear-gradient(135deg, #1e7a4a 0%, #145e38 100%) !important;
            color: #fff !important;
        }
        /* Pagination wrapper */
        nav[aria-label="pagination"] {
            display: flex;
            justify-content: center;
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
            .sidebar-close { display: none; }
        }
        
        /* Botanical Decorations */
        .botanical-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            opacity: 0.12;
            color: var(--green);
        }
        
        .botanical-top-right {
            top: 100px;
            right: 50px;
            font-size: 6rem;
            transform: rotate(25deg);
        }
        
        .botanical-bottom-left {
            bottom: 50px;
            left: 350px;
            font-size: 5rem;
            transform: rotate(-15deg);
        }
        
        .botanical-middle {
            top: 50%;
            right: 150px;
            font-size: 4rem;
            transform: translateY(-50%) rotate(45deg);
        }
        
        /* Fade up animation for content */
        .fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }
        
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ═══════════════════════════════════════════════════════════════
           MODAL Z-INDEX FIX - Ensure modals are always clickable
           ═══════════════════════════════════════════════════════════════ */
        .modal-backdrop {
            z-index: 10000 !important;
        }
        .modal {
            z-index: 10001 !important;
        }
        .modal-dialog {
            z-index: 10002 !important;
            pointer-events: auto !important;
        }
        .modal-content {
            pointer-events: auto !important;
            position: relative;
            z-index: 10003 !important;
        }
        .modal-body, .modal-header, .modal-footer {
            pointer-events: auto !important;
        }
        .modal-body *, .modal-header *, .modal-footer * {
            pointer-events: auto !important;
        }
    </style>
</head>
<body>
    <!-- Botanical Decorations -->
    <div class="botanical-decoration botanical-top-right">
        <i class="bi bi-flower1"></i>
    </div>
    <div class="botanical-decoration botanical-bottom-left">
        <i class="bi bi-flower2"></i>
    </div>
    <div class="botanical-decoration botanical-middle">
        <i class="bi bi-flower3"></i>
    </div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-logo">
                <img src="{{ asset('logo.png') }}" alt="BNHS Care Konek">
                <div class="sidebar-logo-text">
                    <span class="sidebar-logo-name">Care Konek</span>
                    <span class="sidebar-logo-subtitle">BNHS Referral & Case Management</span>
                </div>
            </a>
            <button class="sidebar-close" onclick="closeSidebar()" aria-label="Close menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav" style="display:flex; flex-direction:column; height:calc(100vh - 81px);">
            <!-- Decorative Leaves -->
            <div class="sidebar-leaf sidebar-leaf-top">
                <i class="bi bi-flower1"></i>
            </div>
            <div class="sidebar-leaf sidebar-leaf-middle">
                <i class="bi bi-flower2"></i>
            </div>
            <div class="sidebar-leaf sidebar-leaf-bottom">
                <i class="bi bi-flower3"></i>
            </div>
            
            @auth
                @if(Auth::user()->isStudent())
                    <div class="nav-section">
                        <div class="nav-section-title">Main</div>
                        <a href="{{ route('student.dashboard') }}" class="nav-link @if(request()->is('student/dashboard')) active @endif">
                            <i class="bi bi-house-heart-fill"></i>
                            <span class="nav-link-text">Tambayan</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">BNHS Care Konek</div>
                        <a href="{{ route('student.new-here') }}" class="nav-link @if(request()->is('student/new-here*')) active @endif">
                            <i class="bi bi-person-plus-fill"></i>
                            <span class="nav-link-text">New Here?</span>
                        </a>
                        <a href="{{ route('student.spill-tea') }}" class="nav-link @if(request()->is('student/spill-tea*')) active @endif">
                            <i class="bi bi-chat-heart-fill"></i>
                            <span class="nav-link-text">Spill the Tea</span>
                        </a>
                        <a href="{{ route('student.connect') }}" class="nav-link @if(request()->is('student/connect*')) active @endif">
                            <i class="bi bi-people-fill"></i>
                            <span class="nav-link-text">Connect with Ate/Kuya</span>
                        </a>
                        <a href="{{ route('student.mind-check') }}" class="nav-link @if(request()->is('student/mind-check*')) active @endif">
                            <i class="bi bi-heart-pulse-fill"></i>
                            <span class="nav-link-text">Mind Check</span>
                        </a>
                        <a href="{{ route('student.resources.index') }}" class="nav-link @if(request()->is('student/resources*') || request()->is('student/real-talk*') || request()->is('student/unfiltered*') || request()->is('student/find-people*') || request()->is('student/exit-check*') || request()->is('student/future-me*')) active @endif">
                            <i class="bi bi-bookmark-star-fill"></i>
                            <span class="nav-link-text">Resources & Community</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">My Activity</div>
                        <a href="{{ route('student.concerns.index') }}" class="nav-link @if(request()->is('student/concerns') && !request()->is('student/concerns/create')) active @endif">
                            <i class="bi bi-chat-dots"></i>
                            <span class="nav-link-text">My Concerns</span>
                        </a>
                        <a href="{{ route('student.appointments.index') }}" class="nav-link @if(request()->is('student/appointments*')) active @endif">
                            <i class="bi bi-calendar3"></i>
                            <span class="nav-link-text">My Appointments</span>
                        </a>
                        <a href="{{ route('student.forms.index') }}" class="nav-link @if(request()->is('student/forms*')) active @endif">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-link-text">My Forms</span>
                        </a>
                    </div>

                    
                @elseif(Auth::user()->isCounselor())
                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Dashboard</div>
                        <a href="{{ route('counselor.dashboard') }}" class="nav-link @if(request()->is('counselor/dashboard')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Cases & Referrals</div>
                        <a href="{{ route('counselor.concerns.index') }}" class="nav-link @if(request()->is('counselor/concerns*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-chat-dots"></i>
                            <span class="nav-link-text">Student Concerns</span>
                            <span class="nav-link-badge">{{ App\Models\Concern::where('status', 'submitted')->count() }}</span>
                        </a>
                        <a href="{{ route('counselor.incident-reports.index') }}" class="nav-link @if(request()->is('counselor/incident-reports*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-link-text">Incident Reports</span>
                            @php $pendingIR = App\Models\IncidentReport::where('status','pending')->count(); @endphp
                            @if($pendingIR > 0)
                                <span class="nav-link-badge">{{ $pendingIR }}</span>
                            @endif
                        </a>
                        <a href="{{ route('counselor.referrals.index') }}" class="nav-link @if(request()->is('counselor/referrals*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-person-check"></i>
                            <span class="nav-link-text">Teacher Referrals</span>
                            @php $pendingRef = App\Models\StudentReferral::where('status','pending')->count(); @endphp
                            @if($pendingRef > 0)
                                <span class="nav-link-badge">{{ $pendingRef }}</span>
                            @endif
                        </a>
                        <a href="{{ route('counselor.mental-health.index') }}" class="nav-link @if(request()->is('counselor/mental-health*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-heart-pulse-fill"></i>
                            <span class="nav-link-text">Mental Health Assessments</span>
                            @php $highRisk = App\Models\MentalHealthAssessment::whereIn('risk_level', ['high', 'moderately-high'])->where('follow_up_scheduled', false)->count(); @endphp
                            @if($highRisk > 0)
                                <span class="nav-link-badge bg-danger">{{ $highRisk }}</span>
                            @endif
                        </a>
                        <a href="{{ route('counselor.student-forms.index') }}" class="nav-link @if(request()->is('counselor/student-forms*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-file-earmark-check"></i>
                            <span class="nav-link-text">Student Forms</span>
                            @php $pendingForms = App\Models\StudentFormSubmission::where('status', 'submitted')->count(); @endphp
                            @if($pendingForms > 0)
                                <span class="nav-link-badge">{{ $pendingForms }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Sessions & Appointments</div>
                        <a href="{{ route('counselor.appointments.index') }}" class="nav-link @if(request()->is('counselor/appointments*') && !request()->is('counselor/calendar*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-calendar3"></i>
                            <span class="nav-link-text">Appointments</span>
                            @php
                                $pendingTeacherAppts = \App\Models\Appointment::where('counselor_id', Auth::id())
                                    ->where('requester_type', 'teacher')
                                    ->where('status', 'scheduled')
                                    ->count();
                            @endphp
                            @if($pendingTeacherAppts > 0)
                                <span class="nav-link-badge" style="background:#6366f1;">{{ $pendingTeacherAppts }}</span>
                            @endif
                        </a>
                        <a href="{{ route('counselor.calendar') }}" class="nav-link @if(request()->is('counselor/calendar*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-calendar-week"></i>
                            <span class="nav-link-text">Calendar View</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Resources & Community</div>
                        <a href="{{ route('counselor.resources-community') }}" class="nav-link @if(request()->is('counselor/resources-community*') || request()->is('counselor/resources/*') || request()->is('counselor/student-submissions*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-collection-fill"></i>
                            <span class="nav-link-text">Resources & Community</span>
                            @php $pendingSubmissions = \App\Models\StudentSubmission::where('status', 'pending')->count(); @endphp
                            @if($pendingSubmissions > 0)
                                <span class="nav-link-badge" style="background:var(--green);">{{ $pendingSubmissions }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Forms & Downloads</div>
                        <a href="{{ route('counselor.forms.index') }}" class="nav-link @if(request()->is('counselor/forms*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <span class="nav-link-text">Forms/Downloads</span>
                            @php $pendingForms = \App\Models\TeacherFormSubmission::where('status','submitted')->count(); @endphp
                            @if($pendingForms > 0)
                                <span class="nav-link-badge">{{ $pendingForms }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="nav-section" style="margin-bottom:.6rem;">
                        <div class="nav-section-title">Account Management</div>
                        <a href="{{ route('counselor.pending-accounts') }}" class="nav-link @if(request()->is('counselor/pending-accounts*')) active @endif" style="padding:.5rem 1.5rem;font-size:.83rem;">
                            <i class="bi bi-person-check"></i>
                            <span class="nav-link-text">Pending Approvals</span>
                            @php $pendingApprovals = \App\Models\User::where('is_active', false)->whereHas('role', fn($q) => $q->whereIn('name', ['teacher','student']))->count(); @endphp
                            @if($pendingApprovals > 0)
                                <span class="nav-link-badge">{{ $pendingApprovals }}</span>
                            @endif
                        </a>
                    </div>

                @elseif(Auth::user()->isTeacher())
                    {{-- Compact nav for teachers: more items need to fit --}}
                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">Dashboard</div>
                        <a href="{{ route('teacher.dashboard') }}" class="nav-link @if(request()->is('teacher/dashboard')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">Submit Cases</div>
                        <a href="{{ route('teacher.incident-reports.create') }}" class="nav-link @if(request()->is('teacher/incident-reports/create')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span class="nav-link-text">Report Incident</span>
                        </a>
                        <a href="{{ route('teacher.referrals.create') }}" class="nav-link @if(request()->is('teacher/referrals/create')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-person-plus"></i>
                            <span class="nav-link-text">Refer a Student</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">My Cases</div>
                        <a href="{{ route('teacher.incident-reports.index') }}" class="nav-link @if(request()->is('teacher/incident-reports') && !request()->is('teacher/incident-reports/create')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-link-text">My Reports</span>
                        </a>
                        <a href="{{ route('teacher.referrals.index') }}" class="nav-link @if(request()->is('teacher/referrals') && !request()->is('teacher/referrals/create')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-person-lines-fill"></i>
                            <span class="nav-link-text">My Referrals</span>
                        </a>
                        <a href="{{ route('teacher.case-tracking.index') }}" class="nav-link @if(request()->is('teacher/case-tracking*')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-kanban"></i>
                            <span class="nav-link-text">Track All Cases</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">Resources</div>
                        <a href="{{ route('teacher.resources') }}" class="nav-link @if(request()->is('teacher/resources*')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-book-half"></i>
                            <span class="nav-link-text">Teacher Resources</span>
                        </a>
                        <a href="{{ route('teacher.forms.index') }}" class="nav-link @if(request()->is('teacher/forms')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-link-text">Forms/Downloads</span>
                        </a>
                        <a href="{{ route('teacher.intervention-guides.index') }}" class="nav-link @if(request()->is('teacher/intervention-guides*')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-journal-bookmark"></i>
                            <span class="nav-link-text">Intervention Guides</span>
                        </a>
                    </div>
                    
                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">Support</div>
                        <a href="{{ route('teacher.talk-to-counselor') }}" class="nav-link @if(request()->is('teacher/talk-to-counselor') || request()->is('teacher/appointments*')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">
                            <i class="bi bi-chat-heart"></i>
                            <span class="nav-link-text">Talk to Counselor</span>
                            @php
                                $myUpcoming = \App\Models\Appointment::where('student_id', Auth::id())
                                    ->where('requester_type','teacher')
                                    ->whereIn('status',['scheduled','confirmed'])
                                    ->count();
                            @endphp
                            @if($myUpcoming > 0)
                                <span class="nav-link-badge">{{ $myUpcoming }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="nav-section" style="margin-bottom:0.75rem;">
                        <div class="nav-section-title">Account</div>
                        <a href="{{ route('settings') }}" class="nav-link @if(request()->is('settings')) active @endif" style="padding:0.5rem 1.5rem;font-size:0.83rem;">

                @elseif(Auth::user()->isAdmin())
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
            @endauth


        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <!-- Decorative Leaves -->
            <div class="header-leaf header-leaf-left">
                <i class="bi bi-flower2"></i>
            </div>
            <div class="header-leaf header-leaf-right">
                <i class="bi bi-flower1"></i>
            </div>
            
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            
            <div class="header-right">
                @auth
                    <!-- Messages Icon -->
                    <a href="{{ route('messages.index') }}" class="header-icon-link position-relative me-3" title="Messages">
                        <i class="bi bi-chat-dots-fill fs-5"></i>
                        @php $unreadCount = Auth::user()->unreadMessagesCount(); @endphp
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- User Dropdown -->
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
                                @if(Auth::user()->isStudent()) Student
                                @elseif(Auth::user()->isCounselor()) Counselor
                                @elseif(Auth::user()->isAdmin()) Administrator
                                @elseif(Auth::user()->isTeacher()) Teacher
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end" style="margin-top: 0.5rem;">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
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
        <div class="content-area fade-up">
            @yield('content')
        </div>
    </main>
    
    <!-- Sidebar backdrop -->  
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ── GLOBAL TOAST SYSTEM ── --}}
    <style>
        .toast-container-custom {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            max-width: 400px;
            width: calc(100vw - 3rem);
        }
        .toast-custom {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            padding: 1rem 1.15rem;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13), 0 2px 8px rgba(0,0,0,0.07);
            border-left: 4px solid transparent;
            opacity: 0;
            transform: translateX(110%);
            transition: opacity 0.35s cubic-bezier(0.4,0,0.2,1), transform 0.35s cubic-bezier(0.4,0,0.2,1);
            pointer-events: auto;
            position: relative;
            overflow: hidden;
        }
        .toast-custom.show {
            opacity: 1;
            transform: translateX(0);
        }
        .toast-custom.hide {
            opacity: 0;
            transform: translateX(110%);
        }
        .toast-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            animation: toastTimer 4s linear forwards;
        }
        @keyframes toastTimer {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .toast-custom.toast-success { border-color: #22c55e; color: #16a34a; }
        .toast-custom.toast-error   { border-color: #ef4444; color: #dc2626; }
        .toast-custom.toast-warning { border-color: #f59e0b; color: #d97706; }
        .toast-custom.toast-info    { border-color: #3b82f6; color: #2563eb; }
        .toast-icon {
            font-size: 1.35rem;
            flex-shrink: 0;
            margin-top: 0.05rem;
        }
        .toast-body { flex: 1; }
        .toast-title {
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }
        .toast-msg {
            font-size: 0.92rem;
            color: #334155;
            line-height: 1.45;
            font-weight: 500;
        }
        .toast-close {
            background: none;
            border: none;
            font-size: 1rem;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: color 0.2s;
        }
        .toast-close:hover { color: #475569; }
    </style>

    <div class="toast-container-custom" id="toastContainer"></div>

    <script>
        /* ── Toast helper ── */
        function showToast(type, message) {
            const cfg = {
                success: { icon: 'bi-check-circle-fill', title: 'Success' },
                error:   { icon: 'bi-x-circle-fill',    title: 'Error'   },
                warning: { icon: 'bi-exclamation-triangle-fill', title: 'Warning' },
                info:    { icon: 'bi-info-circle-fill',  title: 'Info'    },
            };
            const c = cfg[type] || cfg.info;
            const t = document.createElement('div');
            t.className = `toast-custom toast-${type}`;
            t.innerHTML = `
                <i class="bi ${c.icon} toast-icon"></i>
                <div class="toast-body">
                    <div class="toast-title">${c.title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" onclick="dismissToast(this.parentElement)">&times;</button>`;
            document.getElementById('toastContainer').appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => dismissToast(t), 4000);
        }

        function dismissToast(el) {
            if (!el || el.classList.contains('hide')) return;
            el.classList.add('hide');
            el.style.animation = 'none'; /* stop timer bar */
            setTimeout(() => el.remove(), 380);
        }

        /* ── Fire session flashes ── */
        @if(session('success'))
            showToast('success', @json(session('success')));
        @endif
        @if(session('error'))
            showToast('error', @json(session('error')));
        @endif
        @if(session('warning'))
            showToast('warning', @json(session('warning')));
        @endif
        @if(session('info'))
            showToast('info', @json(session('info')));
        @endif
    </script>
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

    @stack('scripts')
</body>
</html>
