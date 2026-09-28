<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard TU — EDU JOURNAL')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --sidebar-bg: #384972;
            --sidebar-active: #4a5e8c;
            --sidebar-text: #b6c5e3;
            --sidebar-text-active: #ffffff;
            --body-bg: #cbd3e0;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --sidebar-width: 250px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            width: 100%;
            max-width: 100%;
            overflow-x: clip;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            width: 100%;
            max-width: 100%;
            overflow-x: clip;
            box-sizing: border-box;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            z-index: 100;
            box-shadow: 2px 0 15px rgba(0,0,0,0.08);
        }

        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand .logo-icon {
            width: 92px; height: 92px;
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            overflow: visible;
            padding: 0;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.4));
        }

        .sidebar-brand .logo-text h2 {
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .sidebar-brand .logo-text span {
            font-size: 11px;
            color: #a5b6dc;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 12px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .menu-category {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #93a5cc;
            padding: 16px 12px 6px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #c0cdf0;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-item.active {
            color: #ffffff;
            background: var(--sidebar-active);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .nav-item .badge-count {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* Dropdown Accordion Sidebar */
        .sidebar-dropdown {
            display: flex;
            flex-direction: column;
        }

        .sidebar-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .sidebar-dropdown-toggle .toggle-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            text-decoration: none;
            color: inherit;
        }

        .sidebar-dropdown-toggle .chevron-btn {
            background: transparent;
            border: none;
            color: #93a5cc;
            font-size: 11px;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 6px;
            transition: transform 0.25s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-dropdown-toggle .chevron-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
        }

        .sidebar-dropdown.open .chevron-btn i {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease;
            opacity: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-top: 2px;
            padding-left: 14px;
            border-left: 2px solid rgba(255, 255, 255, 0.15);
            margin-left: 22px;
        }

        .sidebar-dropdown.open .sidebar-submenu {
            max-height: 200px;
            opacity: 1;
        }

        .sidebar-submenu .submenu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: #b6c5e3;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sidebar-submenu .submenu-item i {
            font-size: 13px;
            width: 16px;
            text-align: center;
        }

        .sidebar-submenu .submenu-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-submenu .submenu-item.active {
            color: #ffffff;
            background: #4a5e8c;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #9aa8c7;
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
        }

        .user-info .name {
            font-size: 12.5px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }
        .user-info .role {
            font-size: 10.5px;
            color: #a0b2db;
            font-weight: 600;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 2px;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 9px;
            font-size: 11.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #c0cdf0;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-footer-action.btn-icon-only {
            width: 36px;
            height: 36px;
            padding: 0;
            flex: 0 0 36px;
            font-size: 14px;
        }

        .btn-footer-action i {
            font-size: 13px;
        }

        .btn-footer-action:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .btn-footer-action.btn-logout {
            color: #f87171;
            background: rgba(239, 68, 68, 0.15);
        }

        .btn-footer-action.btn-logout:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #ffffff;
        }

        /* SweetAlert2 Logout Modal Styling */
        .swal2-logout-popup {
            border-radius: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            padding: 24px 20px !important;
        }
        .swal2-logout-popup .swal2-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 6px !important;
        }
        .swal2-logout-popup .swal2-html-container {
            font-size: 0.95rem !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            margin: 6px 0 0 0 !important;
        }
        .swal2-logout-popup .swal2-actions {
            margin-top: 20px !important;
            gap: 10px !important;
        }
        .swal2-logout-confirm {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            padding: 10px 20px !important;
            background-color: #ef4444 !important;
        }
        .swal2-logout-cancel {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            padding: 10px 20px !important;
            background-color: #64748b !important;
        }

        .btn-footer-action.active {
            background: var(--sidebar-active);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100vw - var(--sidebar-width));
            overflow-x: clip;
            box-sizing: border-box;
        }

        /* Topbar Header */
        .topbar {
            height: 64px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #e2e8f0;
            width: 100%;
            box-sizing: border-box;
        }

        .search-box {
            position: relative;
            width: 320px;
        }

        .search-box input {
            width: 100%;
            background: #f1f5f9;
            border: none;
            padding: 10px 16px 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-family: inherit;
            color: #334155;
            outline: none;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: nowrap;
        }

        .ta-selector {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .ta-text-short { display: none; }
        .ta-text-full { display: inline; }

        /* Content Area */
        .content-body {
            padding: 24px 28px;
            flex: 1;
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
        }

        /* Global Page Header Container (Top-Left Title & Subtitle) */
        .page-header-container,
        .dashboard-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title-group h1,
        .page-header-title h1,
        .header-left h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 4px 0;
        }

        .page-title-group p,
        .page-header-title p,
        .header-left p {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 600;
            margin: 0;
        }

        /* Alerts */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Fix Laravel Default Pagination Giant SVGs & Unstyled Links */
        .pagination-bar svg,
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .pagination-bar nav,
        nav[role="navigation"] {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 4px !important;
        }

        .pagination-bar nav > div:first-child,
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }

        .pagination-bar nav > div:last-child,
        nav[role="navigation"] > div:last-child {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .pagination-bar nav span,
        .pagination-bar nav a,
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }

        .pagination-bar nav a:hover,
        nav[role="navigation"] a:hover {
            background: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        .pagination-bar nav span[aria-current="page"],
        nav[role="navigation"] span[aria-current="page"] {
            background: #1f293d !important;
            color: #ffffff !important;
            border-color: #1f293d !important;
        }

        .pagination-bar nav span[aria-disabled="true"],
        nav[role="navigation"] span[aria-disabled="true"] {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #f8fafc !important;
        }

        /* Custom Pagination Bar Styling (partials.custom-pagination) */
        .custom-pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-top: 0;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-info {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        .pagination-list {
            display: flex;
            align-items: center;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination-list .page-item {
            display: inline-block;
            margin: 0;
            list-style: none;
        }

        .pagination-list .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .pagination-list .page-item.active .page-link {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .pagination-list .page-item a.page-link:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .pagination-list .page-item.disabled .page-link {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }

        /* Pagination SVG size constraint safeguard */
        nav[role="navigation"] svg,
        .pagination svg,
        .custom-pagination-bar svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            max-width: 20px !important;
            max-height: 20px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        /* Sidebar Mobile Drawer & Toggle Button */
        .btn-sidebar-toggle {
            display: none;
        }

        .sidebar-close-btn {
            display: none;
        }

        .topbar-mobile-brand {
            display: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .sidebar { 
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 270px !important;
                max-width: 82vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                max-height: 100dvh !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1050 !important;
                box-shadow: 4px 0 25px rgba(0,0,0,0.3);
                display: flex !important;
                flex-direction: column !important;
                overflow: hidden !important;
                overscroll-behavior: contain !important;
            }
            .sidebar.open {
                transform: translateX(0) !important;
            }
            .sidebar-brand {
                flex-shrink: 0 !important;
                padding: 16px 18px !important;
            }
            .sidebar-menu {
                flex: 1 1 auto !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
            }
            .sidebar-footer {
                flex-shrink: 0 !important;
                margin-top: auto !important;
                padding: 12px 14px !important;
            }
            .sidebar-overlay {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                touch-action: none !important;
                overscroll-behavior: none !important;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                overflow-x: clip !important;
            }
            .topbar {
                height: auto !important;
                min-height: unset !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 1000 !important;
                background: #ffffff !important;
                padding: 6px 10px !important;
                gap: 5px 6px !important;
                display: grid !important;
                grid-template-columns: auto 1fr !important;
                align-items: center !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                border-bottom: 1px solid var(--border-color) !important;
            }
            .topbar-right {
                display: contents !important;
            }
            .topbar-left {
                grid-column: 1 / 2 !important;
                grid-row: 1 / 2 !important;
                display: flex !important;
                align-items: center !important;
                gap: 6px !important;
                justify-self: start !important;
                align-self: center !important;
            }
            .btn-sidebar-toggle {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                width: 32px !important;
                height: 32px !important;
                border-radius: 8px !important;
                background: #f1f5f9;
                border: 1px solid #cbd5e1;
                color: #1e293b;
                font-size: 13px !important;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 1px 2px rgba(0,0,0,0.04);
                flex-shrink: 0;
                margin: 0 !important;
            }
            .btn-sidebar-toggle:hover, .btn-sidebar-toggle:active {
                background: #e2e8f0;
                color: #0f172a;
            }
            .ta-selector {
                grid-column: 2 / 3 !important;
                grid-row: 1 / 2 !important;
                justify-self: end !important;
                align-self: center !important;
                padding: 4px 8px !important;
                font-size: 11px !important;
                height: 32px !important;
                border-radius: 8px !important;
                gap: 5px !important;
                display: inline-flex !important;
                align-items: center !important;
                margin: 0 !important;
                box-sizing: border-box !important;
            }
            .ta-text-full { display: none !important; }
            .ta-text-short { display: inline !important; }
            .live-clock-wrapper {
                grid-column: 1 / -1 !important;
                grid-row: 2 / 3 !important;
                width: 100% !important;
                margin: 0 !important;
            }
            .content-body {
                padding: 10px 12px !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                box-sizing: border-box;
                overflow-x: clip !important;
            }
            body.sidebar-open {
                overflow: hidden;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 5px 8px !important;
                gap: 4px 6px !important;
            }
            .btn-sidebar-toggle {
                width: 30px !important;
                height: 30px !important;
                font-size: 12px !important;
            }
            .ta-selector {
                padding: 3px 6px !important;
                font-size: 10.5px !important;
                height: 30px !important;
                gap: 4px !important;
            }
            .content-body {
                padding: 8px 8px !important;
                overflow-x: clip !important;
            }
        }

        @media (max-width: 768px) {
            .page-title-group h1,
            .page-header-title h1,
            .header-left h1,
            .dashboard-page-header h1,
            .page-header-container h1,
            .ta-title-area h1 {
                font-size: 25px !important;
                font-weight: 800 !important;
                line-height: 1.25 !important;
                letter-spacing: -0.02em !important;
            }
            .page-title-group p,
            .page-header-title p,
            .header-left p,
            .dashboard-page-header p,
            .page-header-container p,
            .ta-title-area p {
                font-size: 13px !important;
                line-height: 1.4 !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
            </div>
            <div class="logo-text">
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi Digital</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">MASTER DATA</div>
            <a href="{{ route('admin.verifikasi-guru') }}" class="nav-item {{ (request()->routeIs('admin.verifikasi-guru') || request()->routeIs('admin.pengguna') || request()->routeIs('admin.users-trash')) ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Pengguna</span>
                @php
                    $pendingCount = \App\Models\User::where('status_verifikasi', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge-count">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('siswa.index') }}" class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Siswa</span>
            </a>

            {{-- Dropdown Menu Guru --}}
            <div class="sidebar-dropdown {{ (request()->routeIs('guru.*') || request()->routeIs('admin.guru-piket') || request()->routeIs('admin.wali-kelas-list')) ? 'open' : '' }}" id="guruDropdown">
                <div class="nav-item sidebar-dropdown-toggle {{ (request()->routeIs('guru.index') && !request('role')) ? 'active' : '' }}">
                    <a href="{{ route('guru.index') }}" class="toggle-left">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Guru</span>
                    </a>
                    <button type="button" class="chevron-btn" onclick="toggleGuruSubmenu(event)" title="Buka/Tutup Submenu Guru">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="sidebar-submenu" id="guruSubmenu">
                    <a href="{{ route('admin.guru-piket') }}" class="submenu-item {{ request()->routeIs('admin.guru-piket') || (request()->routeIs('guru.index') && request('role') == 'piket') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-user"></i>
                        <span>Guru Piket</span>
                    </a>
                    <a href="{{ route('admin.wali-kelas-list') }}" class="submenu-item {{ request()->routeIs('admin.wali-kelas-list') || (request()->routeIs('guru.index') && request('role') == 'wali_kelas') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card-clip"></i>
                        <span>Wali Kelas</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('kelas.index') }}" class="nav-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <i class="fa-solid fa-school"></i>
                <span>Kelas</span>
            </a>
            <a href="{{ route('mapel.index') }}" class="nav-item {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i>
                <span>Mapel</span>
            </a>
            <a href="{{ route('jam-pelajaran.index') }}" class="nav-item {{ request()->routeIs('jam-pelajaran.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i>
                <span>Master Jam Pelajaran</span>
            </a>

            <div class="menu-category">AKADEMIK</div>
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="nav-item {{ request()->routeIs('admin.tahun-ajaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Tahun Ajaran</span>
            </a>
            <a href="{{ route('jadwal.index') }}" class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('admin.jurnal-mengajar') }}" class="nav-item {{ request()->routeIs('admin.jurnal-mengajar*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>Jurnal Mengajar</span>
            </a>
            <div class="menu-category">LAYANAN & PENGADUAN</div>
            <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="fa-solid fa-headset"></i>
                <span>Laporan</span>
                @php
                    $pendingLaporanCount = \App\Models\LaporanTu::where('status', 'pending')->count();
                @endphp
                @if($pendingLaporanCount > 0)
                    <span class="badge-count" id="sidebarLaporanBadge">{{ $pendingLaporanCount }}</span>
                @endif
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar" style="overflow: hidden;">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="name" title="{{ Auth::user()->name ?? 'Admin Tata Usaha' }}">{{ Auth::user()->name ?? 'Admin Tata Usaha' }}</div>
                    <div class="role">ROLE: {{ strtoupper(Auth::user()->role_label ?? 'TU') }}</div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="button" class="btn-footer-action btn-logout" title="Keluar dari sistem" style="width:100%;" onclick="confirmLogout(event)">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" title="Pengaturan">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('customer-service.*') ? 'active' : '' }}" title="Customer Service & Bantuan">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-sidebar-toggle" id="sidebarToggleBtn" aria-label="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div class="topbar-right">
                <div class="ta-selector">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i>
                    <span class="ta-text-full">T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - Semester {{ $activeTahunAjaran->semester ?? 'Ganjil' }}</span>
                    <span class="ta-text-short">T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }}</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px;"></i>
                </div>

                @include('partials.live-clock')
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleGuruSubmenu(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const dropdown = document.getElementById('guruDropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        }

        // Mobile Sidebar Drawer Logic
        (function() {
            const sidebar = document.getElementById('adminSidebar');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            let scrollY = 0;

            function openSidebar() {
                if (sidebar) sidebar.classList.add('open');
                if (sidebarOverlay) sidebarOverlay.classList.add('active');
                scrollY = window.pageYOffset || document.documentElement.scrollTop;
                document.body.style.top = `-${scrollY}px`;
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.classList.add('sidebar-open');
                document.documentElement.classList.add('sidebar-open');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('open');
                if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.width = '';
                document.body.classList.remove('sidebar-open');
                document.documentElement.classList.remove('sidebar-open');
                window.scrollTo(0, scrollY);
            }

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', openSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
                sidebarOverlay.addEventListener('touchmove', function(e) {
                    e.preventDefault();
                }, { passive: false });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            // Auto close drawer when navigating on mobile screen
            if (sidebar) {
                const navLinks = sidebar.querySelectorAll('.nav-item, .submenu-item, .user-profile, .btn-footer-action');
                navLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Don't close if it's the guru dropdown toggle button
                        if (this.classList.contains('sidebar-dropdown-toggle') && e.target.closest('.chevron-btn')) {
                            return;
                        }
                        // Don't auto-close drawer immediately on logout click so SweetAlert can display cleanly
                        if (this.classList.contains('btn-logout') || this.closest('form#logout-form')) {
                            return;
                        }
                        if (window.innerWidth <= 992 && !this.classList.contains('sidebar-dropdown-toggle')) {
                            closeSidebar();
                        }
                    });
                });
            }
        })();

        // Global Confirmation Modal for Logout
        function confirmLogout(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const form = (event && event.currentTarget) ? event.currentTarget.closest('form') : (document.getElementById('logout-form') || document.querySelector('form[action*="logout"]'));

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar dari akun Anda?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 6px;"></i> Ya, Keluar',
                    cancelButtonText: '<i class="fa-solid fa-xmark" style="margin-right: 6px;"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'swal2-logout-popup',
                        confirmButton: 'swal2-logout-confirm',
                        cancelButton: 'swal2-logout-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (form) {
                            form.submit();
                        } else {
                            const fallbackForm = document.createElement('form');
                            fallbackForm.method = 'POST';
                            fallbackForm.action = '{{ route("logout") }}';
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            fallbackForm.appendChild(csrfInput);
                            document.body.appendChild(fallbackForm);
                            fallbackForm.submit();
                        }
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari akun Anda?')) {
                    if (form) form.submit();
                }
            }
            return false;
        }
    </script>
    @yield('scripts')
</body>
</html>
