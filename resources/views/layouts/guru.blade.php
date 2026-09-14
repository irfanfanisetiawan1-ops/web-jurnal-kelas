<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru — EDU JOURNAL')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-active: #eef2ff;
            --sidebar-text: #475569;
            --sidebar-text-active: #0f172a;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --sidebar-width: 224px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar Navigation: Full Height, Compact, Non-Scrollable */
        .sidebar {
            width: 224px;
            min-width: 224px;
            max-width: 224px;
            background: #ffffff;
            border-right: 1px solid rgba(226, 232, 240, 0.85);
            border-left: 1px solid rgba(226, 232, 240, 0.85);
            border-top: none;
            border-bottom: none;
            box-shadow: 2px 0 12px -2px rgba(0, 0, 0, 0.04);
            color: #1e293b;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 10px;
            bottom: 0;
            height: 100vh;
            max-height: 100vh;
            border-radius: 0;
            overflow: hidden;
            box-sizing: border-box;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-content {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 8px 10px 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-shrink: 0;
            border-bottom: none;
        }

        .sidebar-brand .logo-icon {
            width: 100%;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
            padding: 0;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon img {
            width: 58px;
            max-width: 62px;
            height: auto;
            object-fit: contain;
            transition: transform 0.2s;
            filter: none;
        }

        .sidebar-brand .logo-text {
            display: none;
        }

        .sidebar-menu {
            padding: 0 8px;
            flex: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        @media (max-height: 750px) {
            .sidebar-menu {
                overflow-y: auto !important;
                scrollbar-width: none;
            }
            .sidebar-menu::-webkit-scrollbar {
                display: none;
            }
        }

        .menu-category {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 4px 6px 2px 6px;
            flex-shrink: 0;
        }

        .menu-category:first-child {
            padding-top: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 34px;
            padding: 0 8px;
            box-sizing: border-box;
            color: #475569;
            text-decoration: none;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .nav-item i,
        .nav-item .material-symbols-outlined,
        .nav-item svg {
            font-size: 15px;
            width: 18px;
            text-align: center;
            color: #94a3b8;
            transition: color 0.2s ease;
            flex-shrink: 0;
        }

        .nav-item:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .nav-item:hover i,
        .nav-item:hover .material-symbols-outlined,
        .nav-item:hover svg {
            color: #2563eb;
        }

        .nav-item.active {
            color: #0f172a !important;
            background: #eef2ff !important;
            font-weight: 700;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            bottom: 5px;
            width: 3.5px;
            background-color: #2563eb;
            border-top-right-radius: 9999px;
            border-bottom-right-radius: 9999px;
        }

        .nav-item.active i,
        .nav-item.active .material-symbols-outlined,
        .nav-item.active svg {
            color: #1e293b !important;
        }

        .nav-item .badge-count,
        .nav-item .badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 9.5px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: normal;
        }

        .nav-item .badge-tag-amber {
            margin-left: auto;
            background: #fef3c7;
            color: #b45309;
            font-size: 9.5px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: normal;
        }

        /* Sidebar Bottom Profile & Controls */
        .sidebar-footer {
            padding: 6px 10px;
            border-top: 1px solid #f1f5f9;
            background: #ffffff;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
            margin-top: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            padding: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 11px;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.15);
        }

        .user-info {
            overflow: hidden;
            min-width: 0;
        }

        .user-info .name {
            font-size: 11.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }
        .user-info .role {
            font-size: 9px;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1px;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            padding-top: 0;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4px 6px;
            height: 30px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-family: inherit;
            box-sizing: border-box;
        }

        .btn-footer-action.btn-icon-only {
            width: 30px;
            height: 30px;
            padding: 0;
            flex: 0 0 30px;
            font-size: 11px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            border-radius: 7px;
        }

        .btn-footer-action.btn-icon-only:hover {
            background: #f8fafc;
            color: #2563eb;
            border-color: #cbd5e1;
        }

        .btn-footer-action.btn-logout {
            color: #e11d48;
            background: #fff1f2;
            flex: 1;
        }

        .btn-footer-action.btn-logout:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .btn-footer-action.active {
            background: #eef2ff;
            color: #2563eb;
            border-color: #c7d2fe;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 234px;
            width: calc(100% - 234px);
            max-width: calc(100% - 234px);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            padding: 0 10px 3.5rem 10px;
            background-color: rgba(248, 250, 252, 0.6);
            box-sizing: border-box;
        }

        /* Topbar Header Container */
        .topbar, .header {
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-top: none;
            border-radius: 0 0 14px 14px;
            padding: 8px 18px;
            min-height: 52px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
            margin: 0 auto 20px auto;
            position: sticky;
            top: 0;
            z-index: 80;
            backdrop-filter: blur(8px);
            box-sizing: border-box;
        }

        .topbar-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .title-section,
        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 0 1 auto;
            min-width: 0;
        }

        .title-section h1,
        .header-title h1,
        .page-header-main-title {
            font-size: 17px !important;
            font-weight: 700 !important;
            color: #0f2744 !important;
            letter-spacing: -0.01em !important;
            line-height: 1.2 !important;
            margin: 0 !important;
        }

        .title-section p,
        .header-title p,
        .page-header-sub-title {
            font-size: 11px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            margin: 1px 0 0 0 !important;
            line-height: 1.2 !important;
        }

        .title-section-content {
            min-width: 0;
            flex: 0 1 auto;
        }

        .header-controls {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            width: fit-content;
        }

        .header-control {
            flex: 0 0 auto;
            box-sizing: border-box;
        }

        .btn-mobile-sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .btn-mobile-sidebar-toggle:hover {
            background: #f1f5f9;
            color: #2563eb;
        }

        /* 3 Header Compact Containers - Matching Admin */
        .ta-selector.academic-year.header-control,
        .academic-year,
        .ta-selector {
            width: 220px;
            min-width: 220px;
            max-width: 220px;
            flex: 0 0 220px;
            height: 36px;
            padding: 0 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            white-space: nowrap;
            box-sizing: border-box;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .ta-selector.academic-year.header-control:hover,
        .academic-year:hover,
        .ta-selector:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .academic-year i.fa-graduation-cap,
        .ta-selector i.fa-graduation-cap {
            font-size: 13px;
            color: #475569;
            flex-shrink: 0;
            margin-right: 5px;
        }

        .academic-year span,
        .ta-selector span {
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .academic-year i.fa-chevron-down,
        .ta-selector i.fa-chevron-down {
            font-size: 9px;
            color: #94a3b8;
            margin-left: auto;
            flex-shrink: 0;
        }

        .live-lesson-hour-card.kbm-status.header-control,
        .kbm-status,
        .live-lesson-hour-card {
            width: 170px;
            min-width: 170px;
            max-width: 170px;
            flex: 0 0 170px;
            height: 36px;
            padding: 0 8px;
            box-sizing: border-box;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .live-clock-card.date-time.header-control,
        .date-time,
        .live-clock-card {
            width: 220px;
            min-width: 220px;
            max-width: 220px;
            flex: 0 0 220px;
            height: 36px;
            padding: 0 8px;
            box-sizing: border-box;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .live-clock-wrapper {
            display: contents !important;
        }

        /* Content Area */
        .content-body {
            padding: 0;
            flex: 1;
            width: 100%;
            margin: 0 auto;
        }

        /* Global Page Header Container (Top-Left Title & Subtitle) */
        .page-header-container,
        .dashboard-page-header,
        .page-title-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title-group h1,
        .page-header-title h1,
        .header-left h1,
        .page-title-box h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 4px 0;
        }

        .page-title-group p,
        .page-header-title p,
        .header-left p,
        .page-title-box p {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 600;
            margin: 0;
        }

        /* Global Table Header Filter Bar (Matching Permintaan Izin / Image Example) */
        .filter-bar-container {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 16px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .filter-bar-container form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
        }

        .filter-input {
            padding: 9px 14px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 12.5px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-filter-dark {
            background: #384972;
            color: #ffffff;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

        .btn-reset-light {
            background: #e2e8f0;
            color: #475569;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

        .btn-trash-pink {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

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

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            z-index: 95;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.active {
            display: block;
            opacity: 1;
        }
        @media (max-width: 1024px) {
            body {
                display: block !important;
                width: 100% !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                width: 250px;
                min-width: 250px;
                max-width: 85vw;
                transform: translateX(-100%);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                z-index: 1050;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .btn-sidebar-close {
                display: flex !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                padding-left: 10px;
                padding-right: 10px;
                padding-top: 0;
                overflow-x: hidden !important;
                box-sizing: border-box;
            }
            .topbar {
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 16px;
                padding: 8px 14px;
                border-radius: 0 0 12px 12px;
                box-sizing: border-box;
            }
            .topbar-container {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
            }
            .header-controls {
                max-width: 100% !important;
                min-width: 0 !important;
            }
            .btn-mobile-sidebar-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 900px) {
            .topbar-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .header-controls {
                margin-left: 0;
                width: 100%;
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 2px;
                gap: 8px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            .header-controls::-webkit-scrollbar {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .topbar-container {
                gap: 8px;
            }
            .title-section {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .header-controls {
                gap: 6px;
                padding-bottom: 0;
            }
            .ta-selector.academic-year.header-control,
            .academic-year,
            .ta-selector {
                width: auto !important;
                min-width: 0 !important;
                max-width: none !important;
                flex: 0 0 auto !important;
                height: 32px !important;
                padding: 0 8px !important;
                font-size: 10.5px !important;
                border-radius: 8px !important;
            }
            .live-lesson-hour-card.kbm-status.header-control,
            .kbm-status,
            .live-lesson-hour-card {
                width: auto !important;
                min-width: 0 !important;
                max-width: none !important;
                flex: 0 0 auto !important;
                height: 32px !important;
                padding: 0 8px !important;
                font-size: 10.5px !important;
                border-radius: 8px !important;
            }
            .live-clock-card.date-time.header-control,
            .live-clock-card {
                width: auto !important;
                min-width: 0 !important;
                max-width: none !important;
                flex: 0 0 auto !important;
                height: 32px !important;
                padding: 0 8px !important;
                font-size: 10.5px !important;
                border-radius: 8px !important;
            }
        }

        /* Topbar Mobile & Bottom Nav Base Styles */
        .mobile-topbar-container {
            display: none;
        }

        .mobile-bottom-nav {
            display: none;
        }

        .mobile-bottom-sheet-backdrop,
        .mobile-bottom-sheet {
            display: none;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                padding-top: 0 !important;
                padding-bottom: 76px !important;
                box-sizing: border-box !important;
            }

            .topbar {
                top: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 0 14px 0 !important;
                padding: 14px 14px 10px 14px !important; /* pt-3.5/pt-4 breathing room from phone status bar */
                border-radius: 0 !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-bottom: 1px solid #e2e8f0 !important;
                box-sizing: border-box !important;
                position: sticky;
                z-index: 80;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
            }

            .content-body {
                padding-left: 12px !important;
                padding-right: 12px !important;
                box-sizing: border-box !important;
                width: 100% !important;
            }

            .desktop-topbar-container {
                display: none !important;
            }

            .mobile-topbar-container {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                max-width: 100%;
                min-width: 0;
                gap: 8px;
                box-sizing: border-box;
            }

            .mobile-brand-group {
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                flex: 1;
                min-width: 0;
            }

            .mobile-brand-logo {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                background: transparent;
            }

            .mobile-brand-logo img {
                width: 36px;
                height: 36px;
                max-width: 36px;
                max-height: 36px;
                object-fit: contain;
                display: block;
            }

            .mobile-brand-text {
                display: flex;
                flex-direction: column;
                line-height: 1.15;
                min-width: 0;
                overflow: hidden;
            }

            .mobile-brand-text .brand-school {
                font-size: 11px;
                font-weight: 800;
                color: #1e3a8a;
                letter-spacing: -0.01em;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .mobile-brand-text .brand-school .brand-city {
                color: #2563eb;
            }

            .mobile-brand-text .brand-app {
                font-size: 10.5px;
                font-weight: 800;
                color: #0f172a;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Rotating Info Badge in Header */
            .mobile-info-badge-container {
                position: relative;
                display: inline-flex;
                align-items: center;
                flex-shrink: 0;
            }

            .mobile-header-infobadge {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 4px 8px;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 10.5px;
                font-weight: 600;
                color: #334155;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
                white-space: nowrap;
                flex-shrink: 0;
                cursor: pointer;
                user-select: none;
                transition: all 0.2s ease;
                height: 32px;
                box-sizing: border-box;
            }

            .mobile-header-infobadge:hover,
            .mobile-header-infobadge:active {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .m-infobadge-slider {
                position: relative;
                width: 146px;
                height: 18px;
                overflow: hidden;
            }

            .m-info-slide {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                opacity: 0;
                transform: translateY(4px);
                transition: opacity 0.35s ease, transform 0.35s ease;
                pointer-events: none;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-size: 10px;
                font-weight: 600;
                color: #334155;
            }

            .m-info-slide.active {
                opacity: 1;
                transform: translateY(0);
                pointer-events: auto;
            }

            .m-infobadge-chevron {
                font-size: 8.5px;
                color: #94a3b8;
                margin-left: 2px;
                transition: transform 0.2s ease;
                flex-shrink: 0;
            }

            .mobile-header-infobadge.is-open .m-infobadge-chevron {
                transform: rotate(180deg);
                color: #2563eb;
            }

            /* Tooltip Preview */
            .mobile-info-tooltip {
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                width: 240px;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.12), 0 4px 10px -2px rgba(0, 0, 0, 0.04);
                z-index: 100;
                padding: 12px;
                display: none;
                box-sizing: border-box;
                animation: mTooltipFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            }

            @keyframes mTooltipFade {
                from { opacity: 0; transform: translateY(-4px) scale(0.97); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }

            .m-tooltip-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 8px;
                padding-bottom: 6px;
                border-bottom: 1px solid #f1f5f9;
                font-size: 10px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }

            .m-tooltip-close {
                background: none;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                font-size: 12px;
                padding: 2px 4px;
                border-radius: 4px;
            }

            .m-tooltip-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .m-tooltip-item {
                display: flex;
                align-items: flex-start;
                gap: 8px;
            }

            .m-tooltip-icon {
                width: 24px;
                height: 24px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 11px;
                flex-shrink: 0;
                margin-top: 1px;
            }

            .m-tooltip-content {
                display: flex;
                flex-direction: column;
                line-height: 1.25;
                min-width: 0;
            }

            .m-tooltip-label {
                font-size: 9.5px;
                font-weight: 500;
                color: #64748b;
            }

            .m-tooltip-val {
                font-size: 10.5px;
                font-weight: 700;
                color: #1e293b;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .mobile-bottom-nav {
                display: flex !important;
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                height: 60px !important;
                min-height: 60px !important;
                max-height: 60px !important;
                margin: 0 !important;
                padding: 0 12px !important;
                background: #ffffff !important;
                border-top: 1px solid #e2e8f0 !important;
                border-bottom: none !important;
                border-left: none !important;
                border-right: none !important;
                border-radius: 0 !important;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.04) !important;
                z-index: 1060 !important;
                transform: none !important;
                box-sizing: border-box !important;
                align-items: center;
                justify-content: space-around;
            }

            .bottom-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                color: #64748b;
                font-size: 11px;
                font-weight: 600;
                gap: 3px;
                position: relative;
                padding: 6px 16px;
                height: 100%;
                box-sizing: border-box;
                cursor: pointer;
                background: transparent;
                border: none;
                outline: none;
                -webkit-tap-highlight-color: transparent;
                transition: color 0.15s ease;
            }

            .bottom-nav-item i {
                font-size: 19px;
            }

            .bottom-nav-item.active {
                color: #2563eb !important;
                font-weight: 700;
            }

            .bottom-nav-item .nav-dot-indicator {
                position: absolute;
                bottom: 4px;
                left: 50%;
                transform: translateX(-50%);
                width: 4px;
                height: 4px;
                background: #2563eb;
                border-radius: 50%;
            }

            /* Disable old sidebar drawer on mobile */
            .sidebar {
                display: none !important;
            }
            .sidebar-backdrop {
                display: none !important;
            }

            /* Bottom Sheet Panel (Slide up from bottom above bottom nav) */
            .mobile-bottom-sheet-backdrop {
                display: none;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                background: rgba(15, 23, 42, 0.45);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                z-index: 1040 !important;
                opacity: 0;
                transition: opacity 0.28s ease;
                pointer-events: none;
                touch-action: none;
                overscroll-behavior: contain;
            }

            .mobile-bottom-sheet-backdrop.active {
                display: block !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }

            .mobile-bottom-sheet {
                position: fixed !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 60px !important; /* Sits directly above bottom navigation bar */
                width: 100% !important;
                max-width: 100vw !important;
                margin: 0 !important;
                background: #ffffff;
                border-top: 1px solid #e2e8f0;
                border-bottom: none !important;
                border-left: none !important;
                border-right: none !important;
                border-radius: 22px 22px 0 0;
                box-shadow: 0 -10px 30px -4px rgba(0, 0, 0, 0.12), 0 -4px 10px -2px rgba(0, 0, 0, 0.05);
                z-index: 1050 !important;
                max-height: calc(85vh - 60px);
                display: flex !important;
                flex-direction: column;
                transform: translateY(105%);
                visibility: hidden;
                opacity: 0;
                pointer-events: none;
                transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, visibility 0.25s ease;
                box-sizing: border-box !important;
                overflow: hidden;
                overscroll-behavior: contain;
            }

            .mobile-bottom-sheet.open {
                transform: translateY(0) !important;
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }

            .bottom-sheet-handle-bar {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding-top: 12px;
                padding-bottom: 8px;
                cursor: grab;
                touch-action: pan-y;
                flex-shrink: 0;
            }

            .bottom-sheet-handle {
                width: 38px;
                height: 4.5px;
                background: #cbd5e1;
                border-radius: 9999px;
            }

            .bottom-sheet-body {
                flex: 1;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                padding: 4px 0 10px 0;
            }

            .bs-menu-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 11px 18px;
                text-decoration: none;
                border-bottom: 1px solid #f8fafc;
                box-sizing: border-box;
                transition: background 0.15s ease, border-color 0.15s ease;
            }

            .bs-menu-item:hover,
            .bs-menu-item:active {
                background: #f8fafc;
            }

            .bs-menu-item.active {
                background: #eff6ff !important;
                border-left: 3.5px solid #2563eb !important;
            }

            .bs-menu-left {
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 0;
            }

            .bs-menu-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 13px;
                flex-shrink: 0;
                background: #f1f5f9;
                color: #475569;
                transition: all 0.15s ease;
            }

            .bs-menu-item.active .bs-menu-icon {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .bs-menu-text {
                font-size: 12.5px;
                font-weight: 600;
                color: #334155;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .bs-menu-item.active .bs-menu-text {
                color: #1d4ed8;
                font-weight: 800;
            }

            .bs-menu-right {
                display: flex;
                align-items: center;
                gap: 6px;
                flex-shrink: 0;
            }

            .bs-menu-active-pill {
                font-size: 9.5px;
                font-weight: 700;
                background: #dbeafe;
                color: #1d4ed8;
                padding: 2px 7px;
                border-radius: 6px;
                letter-spacing: 0.02em;
            }

            .bs-menu-badge {
                font-size: 10px;
                font-weight: 800;
                background: #ef4444;
                color: #ffffff;
                padding: 2px 6.5px;
                border-radius: 9999px;
            }

            .bs-menu-chevron {
                font-size: 10.5px;
                color: #cbd5e1;
            }

            .bs-menu-item.active .bs-menu-chevron {
                color: #93c5fd;
            }

            .main-wrapper {
                padding-bottom: 76px !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Backdrop for Mobile Sidebar -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-content">
            <!-- Brand Header -->
            <div class="sidebar-brand" style="position: relative;">
                <div class="logo-icon">
                    <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
                </div>
                <button type="button" class="btn-sidebar-close" onclick="toggleSidebar()" aria-label="Tutup Menu" style="display: none; position: absolute; right: 10px; top: 12px; width: 30px; height: 30px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; transition: all 0.2s;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <nav class="sidebar-menu">
                @if(Auth::check() && Auth::user()->isWaka())
                    <div class="menu-category">MENU WAKA</div>
                    <a href="{{ route('waka.dashboard') }}" class="nav-item {{ request()->routeIs('waka.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Dashboard Waka</span>
                    </a>
                @elseif(Auth::check() && Auth::user()->isKepalaSekolah())
                    <div class="menu-category">MENU KEPALA SEKOLAH</div>
                    <a href="{{ route('kepala-sekolah.dashboard') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Dashboard Kepsek</span>
                    </a>
                @elseif(Auth::check() && Auth::user()->isSatpam())
                    @php
                        $countPendingValidasiSatpam = \App\Models\SiswaDispen::whereDate('tanggal', \Carbon\Carbon::today())
                            ->where(function($q) {
                                $q->where('status_waka', 'approved')
                                  ->orWhere('status_wali_kelas', 'approved');
                            })
                            ->where('status_satpam', 'belum_keluar')
                            ->count();
                    @endphp

                    <div class="menu-category">UTAMA</div>
                    <a href="{{ route('satpam.dashboard') }}" class="nav-item {{ request()->routeIs('satpam.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-grip"></i>
                        <span>Dashboard Satpam</span>
                    </a>

                    <div class="menu-category">DATA MASTER</div>
                    <a href="{{ route('satpam.validasi') }}" class="nav-item {{ request()->routeIs('satpam.validasi*') ? 'active' : '' }}">
                        <i class="fa-solid fa-qrcode"></i>
                        <span>Validasi</span>
                        @if($countPendingValidasiSatpam > 0)
                            <span class="badge-count">{{ $countPendingValidasiSatpam }}</span>
                        @endif
                    </a>

                    <a href="{{ route('satpam.lapor-siswa') }}" class="nav-item {{ request()->routeIs('satpam.lapor-siswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Lapor Siswa</span>
                    </a>

                    <a href="{{ route('satpam.log-aktivitas') }}" class="nav-item {{ request()->routeIs('satpam.log-aktivitas*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Log Aktivitas</span>
                    </a>
                @elseif(Auth::check() && Auth::user()->isOrangTua())
                    <div class="menu-category">MENU ORANG TUA</div>
                    <a href="{{ route('orang-tua.dashboard') }}" class="nav-item {{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Portal Orang Tua</span>
                    </a>
                @elseif(Auth::check() && Auth::user()->isGuruPiket())
                    @php
                        $uObj = Auth::user();
                        $tglNow = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                        $gId = $uObj->id_guru ?? null;
                        if (!$gId && $uObj->nip) {
                            $gFind = \App\Models\Guru::where('nip', $uObj->nip)->first();
                            if ($gFind) $gId = $gFind->id_guru;
                        }

                        $piketAktifList = collect();
                        if ($gId) {
                            $piketAktifList = \App\Models\PenugasanGuruPengganti::where('status', 'aktif')
                                ->where('id_guru_pengganti', $gId)
                                ->whereDate('tanggal', $tglNow)
                                ->get();
                        }

                        $hasActivePenggantiPiket = $piketAktifList->isNotEmpty();

                        $penugasanUrgent = null;
                        foreach ($piketAktifList as $pUk) {
                            if ($pUk->hampir_habis) {
                                $penugasanUrgent = $pUk;
                                break;
                            }
                        }
                    @endphp

                    <div class="menu-category">MENU PETUGAS PIKET</div>
                    
                    <a href="{{ route('piket.dashboard') }}" class="nav-item {{ request()->routeIs('piket.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>

                    @if($hasActivePenggantiPiket)
                        <a href="{{ route('piket.isi-jurnal-pengganti') }}" class="nav-item {{ request()->routeIs('piket.isi-jurnal-pengganti*') ? 'active' : '' }}" style="background: #fffbeb; border: 1px solid #fde68a; color: #b45309;">
                            <i class="fa-solid fa-file-pen" style="color: #d97706;"></i>
                            <span>Jurnal & Presensi Pengganti</span>
                            <span class="badge-tag-amber">Aktif</span>
                        </a>
                    @endif

                    <a href="{{ route('piket.jurnal-mengajar') }}" class="nav-item {{ request()->routeIs('piket.jurnal-mengajar*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-open-reader"></i>
                        <span>Jurnal Mengajar</span>
                    </a>

                    <a href="{{ route('piket.guru-pengganti') }}" class="nav-item {{ request()->routeIs('piket.guru-pengganti*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Guru Pengganti</span>
                    </a>

                    @php
                        $countPendingIzinPiket = 0;
                        if (\Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'is_pengajuan_guru') && \Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'status_piket')) {
                            try {
                                $countPendingIzinPiket = \App\Models\GuruIzin::where('is_pengajuan_guru', 1)->where('status_piket', 'pending')->count();
                            } catch (\Throwable $e) {
                                $countPendingIzinPiket = 0;
                            }
                        }
                    @endphp

                    <a href="{{ route('piket.permintaan-izin') }}" class="nav-item {{ request()->routeIs('piket.permintaan-izin*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-signature"></i>
                        <span>Permintaan Izin Guru</span>
                        @if($countPendingIzinPiket > 0)
                            <span class="badge-count">{{ $countPendingIzinPiket }}</span>
                        @endif
                    </a>

                    <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="nav-item {{ request()->routeIs('piket.guru-izin-tidak-hadir*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-check"></i>
                        <span>Guru Izin Tidak Hadir</span>
                    </a>

                    <a href="{{ route('piket.surat-izin-siswa') }}" class="nav-item {{ request()->routeIs('piket.surat-izin-siswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <span>Surat Izin Siswa</span>
                    </a>

                    <a href="{{ route('piket.dispensasi-siswa') }}" class="nav-item {{ request()->routeIs('piket.dispensasi-siswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card-clip"></i>
                        <span>Dispensasi Siswa</span>
                    </a>

                    <a href="{{ route('piket.siswa-telat') }}" class="nav-item {{ request()->routeIs('piket.siswa-telat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-clock"></i>
                        <span>Siswa Telat</span>
                    </a>

                    <a href="{{ route('piket.jadwal') }}" class="nav-item {{ request()->routeIs('piket.jadwal*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Jadwal Hari Ini</span>
                    </a>

                    <a href="{{ route('piket.rekap-kehadiran') }}" class="nav-item {{ request()->routeIs('piket.rekap-kehadiran*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Rekap Kehadiran</span>
                    </a>

                    <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                @else
                    @php
                        $unreadPengumumanCount = 0;
                        if (Auth::check()) {
                            $uId = Auth::id();
                            $unreadPengumumanCount = \App\Models\Pengumuman::where('status', 'aktif')
                                ->whereNull('deleted_at')
                                ->whereDoesntHave('reads', function($q) use ($uId) {
                                    $q->where('user_id', $uId);
                                })->count();
                        }
                    @endphp

                    <div class="menu-category">MENU UTAMA</div>

                    <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('guru.pengumuman') }}" class="nav-item {{ request()->routeIs('guru.pengumuman*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Pengumuman</span>
                        @if($unreadPengumumanCount > 0)
                            <span class="badge-count">{{ $unreadPengumumanCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('guru.jadwal') }}" class="nav-item {{ request()->routeIs('guru.jadwal') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Jadwal Mengajar</span>
                    </a>

                    <a href="{{ route('guru.jurnal-harian') }}" class="nav-item {{ request()->routeIs('guru.jurnal-harian') ? 'active' : '' }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Jurnal Harian</span>
                    </a>

                    <a href="{{ route('guru.absensi-siswa') }}" class="nav-item {{ request()->routeIs('guru.absensi-siswa') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-check"></i>
                        <span>Presensi Siswa</span>
                    </a>

                    <a href="{{ route('guru.permintaan-izin') }}" class="nav-item {{ request()->routeIs('guru.permintaan-izin*') ? 'active' : '' }}">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <span>Permintaan Izin Saya</span>
                    </a>

                    <a href="{{ route('guru.nilai-rapor') }}" class="nav-item {{ request()->routeIs('guru.nilai-rapor*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Nilai & Rapor</span>
                    </a>

                    <a href="{{ route('guru.riwayat-jurnal') }}" class="nav-item {{ request()->routeIs('guru.riwayat-jurnal') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Riwayat Jurnal</span>
                    </a>

                    <a href="{{ route('guru.beralih-ke-guru-piket') }}" class="nav-item {{ request()->routeIs('guru.beralih-ke-guru-piket*') ? 'active' : '' }}">
                        <i class="fa-solid fa-right-left"></i>
                        <span>Beralih ke Guru Piket</span>
                    </a>

                    <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i>
                        <span>Pengaturan Profil</span>
                    </a>

                    @if(Auth::check() && Auth::user()->isWaliKelas())
                        <div class="menu-category">WALI KELAS</div>

                        <a href="{{ route('guru.kehadiran-kelas') }}" class="nav-item {{ request()->routeIs('guru.kehadiran-kelas') ? 'active' : '' }}">
                            <i class="fa-solid fa-id-card-clip"></i>
                            <span>Presensi & Perkembangan Kelas</span>
                        </a>
                    @endif
                @endif
            </nav>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar" style="overflow: hidden;">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="name" title="{{ Auth::user()->name ?? 'Pengguna' }}">
                        {{ Auth::user()->name ?? 'Pengguna' }}
                    </div>
                    <div class="role">
                        ROLE: {{ strtoupper(Auth::user()->role_label ?? Auth::user()->role) }}
                    </div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="btn-footer-action btn-logout" title="Keluar dari sistem" style="width:100%;">
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

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <header class="topbar">
            <!-- Desktop Topbar Container -->
            <div class="topbar-container desktop-topbar-container">
                <div class="title-section header-title">
                    <button type="button" class="btn-mobile-sidebar-toggle" onclick="toggleSidebar()" aria-label="Buka Menu Navigasi" title="Menu Navigasi">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="title-section-content">
                        @yield('topbar_left')
                    </div>
                </div>

                <div class="header-controls">
                    <div class="ta-selector academic-year header-control">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>T.A. 2025/2026 – Semester Genap</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    @if(Auth::check() && Auth::user()->isSatpam() && isset($countPendingValidasiSatpam) && $countPendingValidasiSatpam > 0)
                        <button type="button" class="header-control notification-btn" title="Notifikasi Satpam" style="position: relative; width: 36px; height: 36px; border-radius: 9px; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer;">
                            <i class="fa-regular fa-bell"></i>
                            <span style="position: absolute; top: -3px; right: -3px; background: #ef4444; color: #ffffff; font-size: 9px; font-weight: 800; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                {{ $countPendingValidasiSatpam }}
                            </span>
                        </button>
                    @endif

                    @include('partials.live-clock')
                </div>
            </div>

            <!-- Mobile-Only Topbar Container (Full-Width, School Emblem, Auto-Rotating Info Badge) -->
            <div class="mobile-topbar-container">
                <div class="mobile-brand-group">
                    <div class="mobile-brand-logo">
                        <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="Logo SMKN 1 Boyolangu">
                    </div>
                    <div class="mobile-brand-text">
                        <div class="brand-school">SMKN 1 <span class="brand-city">BOYOLANGU</span></div>
                        <div class="brand-app">Edu Journal</div>
                    </div>
                </div>

                @php
                    $nowShort = \Carbon\Carbon::now('Asia/Jakarta');
                    $shortM = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    $daysIndoShort = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $initialClockStr = $nowShort->day . ' ' . $shortM[$nowShort->month] . ' ' . $nowShort->year . ' • ' . $nowShort->format('H:i') . ' WIB';
                    $fullClockStr = $daysIndoShort[$nowShort->dayOfWeek] . ', ' . $nowShort->day . ' ' . $shortM[$nowShort->month] . ' ' . $nowShort->year . ' • ' . $nowShort->format('H:i') . ' WIB';
                    $initialKbm = \App\Models\JamPelajaran::getCurrentLessonStatus($nowShort);
                @endphp
                <div class="mobile-info-badge-container">
                    <div class="mobile-header-infobadge" id="mobileHeaderInfobadge" onclick="toggleMobileInfoTooltip(event)" title="Ketuk untuk melihat ringkasan info">
                        <div class="m-infobadge-slider" id="mInfobadgeSlider">
                            <!-- Slide 1: Real-time Date & Time -->
                            <div class="m-info-slide active" data-index="0">
                                <i class="fa-regular fa-calendar-days" style="color: #2563eb; font-size: 11px;"></i>
                                <span class="live-clock-mobile-str">{{ $initialClockStr }}</span>
                            </div>

                            <!-- Slide 2: Status KBM -->
                            <div class="m-info-slide" data-index="1">
                                <i class="fa-solid {{ $initialKbm['icon'] ?? 'fa-school' }}" id="mInfoKbmIcon" style="color: {{ $initialKbm['color'] ?? '#059669' }}; font-size: 11px;"></i>
                                <span id="mInfoKbmText">{{ $initialKbm['label'] ?? 'Luar Jam KBM' }}</span>
                            </div>

                            <!-- Slide 3: T.A. & Semester -->
                            <div class="m-info-slide" data-index="2">
                                <i class="fa-solid fa-graduation-cap" style="color: #7c3aed; font-size: 11px;"></i>
                                <span>T.A. 2025/2026 • Genap</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down m-infobadge-chevron"></i>
                    </div>

                    <!-- Non-Interactive Info Preview Tooltip -->
                    <div class="mobile-info-tooltip" id="mobileInfoTooltip" onclick="event.stopPropagation()">
                        <div class="m-tooltip-header">
                            <span>Info Sistem & Waktu</span>
                            <button type="button" class="m-tooltip-close" onclick="closeMobileInfoTooltip(event)" aria-label="Tutup">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="m-tooltip-list">
                            <div class="m-tooltip-item">
                                <div class="m-tooltip-icon" style="background: #eff6ff; color: #2563eb;">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>
                                <div class="m-tooltip-content">
                                    <span class="m-tooltip-label">Waktu & Tanggal</span>
                                    <span class="m-tooltip-val live-clock-mobile-str-full">{{ $fullClockStr }}</span>
                                </div>
                            </div>
                            <div class="m-tooltip-item">
                                <div class="m-tooltip-icon" style="background: #ecfdf5; color: #059669;" id="mTooltipIconWrapper">
                                    <i class="fa-solid {{ $initialKbm['icon'] ?? 'fa-school' }}" id="mTooltipKbmIcon" style="color: {{ $initialKbm['color'] ?? '#059669' }};"></i>
                                </div>
                                <div class="m-tooltip-content">
                                    <span class="m-tooltip-label">Status KBM</span>
                                    <span class="m-tooltip-val" id="mTooltipKbmText">
                                        {{ $initialKbm['label'] ?? 'Luar Jam KBM' }} <span style="font-weight: 500; color: #64748b; font-size: 9.5px;">({{ $initialKbm['detail'] ?? '-' }})</span>
                                    </span>
                                </div>
                            </div>
                            <div class="m-tooltip-item">
                                <div class="m-tooltip-icon" style="background: #f5f3ff; color: #7c3aed;">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                                <div class="m-tooltip-content">
                                    <span class="m-tooltip-label">Tahun Ajaran & Semester</span>
                                    <span class="m-tooltip-val">T.A. 2025/2026 – Semester Genap</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-body">
            @if(isset($penugasanUrgent) && $penugasanUrgent)
                <div class="alert alert-warning" style="background:#fffbebf0; border:1px solid #fde68a; color:#b45309; font-weight:700; border-radius:14px; margin-bottom:20px; padding:14px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px; box-shadow:0 4px 15px rgba(217,119,6,0.15);">
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div style="width:40px; height:40px; background:#fef3c7; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa-solid fa-bell fa-bounce" style="font-size:20px; color:#d97706;"></i>
                        </div>
                        <div>
                            <div style="font-size:14px; font-weight:800; color:#92400e;">PERINGATAN WAKTU JAM PELAJARAN (Tinggal {{ max($penugasanUrgent->sisa_menit_selesai, 0) }} Menit Lagi)</div>
                            <div style="font-size:12.5px; font-weight:600; color:#b45309; margin-top:2px;">
                                Jam pelajaran <strong>{{ $penugasanUrgent->jadwal->mapel->nama_mapel ?? ($penugasanUrgent->guruTidakHadir->mapel->nama_mapel ?? 'Mata Pelajaran') }}</strong> ({{ $penugasanUrgent->kelas->nama_kelas ?? 'Kelas' }}) akan berakhir pukul <strong>{{ $penugasanUrgent->waktu_selesai_effective }} WIB</strong> dan Jurnal belum diisi! Mohon segera lengkapi jurnal & presensi siswa.
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('piket.isi-jurnal-pengganti', ['id_penugasan' => $penugasanUrgent->id_penugasan]) }}" class="btn" style="background:#d97706; color:#ffffff; font-weight:800; padding:9px 18px; border-radius:10px; text-decoration:none; font-size:12.5px; white-space:nowrap; box-shadow:0 2px 6px rgba(217,119,6,0.3);">
                        <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Sekarang
                    </a>
                </div>
            @endif

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

    <!-- Mobile Bottom Navigation Bar (Fixed) -->
    @php
        $isDashboard = request()->routeIs('piket.dashboard') || request()->routeIs('guru.dashboard') || request()->routeIs('satpam.dashboard') || request()->routeIs('waka.dashboard') || request()->routeIs('kepala-sekolah.dashboard');
        $isProfil = request()->routeIs('pengaturan.*');
        $isMenu = !$isDashboard && !$isProfil;
        $dashboardRoute = route('piket.dashboard');
        if (Auth::check()) {
            if (Auth::user()->isGuruPiket()) {
                $dashboardRoute = route('piket.dashboard');
            } elseif (Auth::user()->isSatpam()) {
                $dashboardRoute = route('satpam.dashboard');
            } elseif (Auth::user()->isWaka()) {
                $dashboardRoute = route('waka.dashboard');
            } elseif (Auth::user()->isKepalaSekolah()) {
                $dashboardRoute = route('kepala-sekolah.dashboard');
            } elseif (Auth::user()->isGuru()) {
                $dashboardRoute = route('guru.dashboard');
            }
        }
    @endphp
    <nav class="mobile-bottom-nav" aria-label="Navigasi Utama Mobile">
        <a href="{{ $dashboardRoute }}" class="bottom-nav-item {{ $isDashboard ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
            @if($isDashboard)
                <span class="nav-dot-indicator"></span>
            @endif
        </a>

        <button type="button" class="bottom-nav-item {{ $isMenu ? 'active' : '' }}" id="bottomNavMenuBtn" onclick="toggleBottomSheet()" aria-label="Buka Seluruh Menu">
            <i class="fa-solid fa-table-cells-large"></i>
            <span>Menu</span>
            @if($isMenu)
                <span class="nav-dot-indicator"></span>
            @endif
        </button>

        <a href="{{ route('pengaturan.index') }}" class="bottom-nav-item {{ $isProfil ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span>Profil</span>
            @if($isProfil)
                <span class="nav-dot-indicator"></span>
            @endif
        </a>
    </nav>

    <!-- Mobile Bottom Sheet Backdrop -->
    <div id="mobileBottomSheetBackdrop" class="mobile-bottom-sheet-backdrop" onclick="closeBottomSheet()"></div>

    <!-- Mobile Bottom Sheet Menu Panel (Slide-up above bottom nav) -->
    <div id="mobileBottomSheet" class="mobile-bottom-sheet" aria-label="Menu Navigasi Mobile">
        <div class="bottom-sheet-handle-bar" id="bottomSheetHandleBar">
            <div class="bottom-sheet-handle"></div>
        </div>

        <div class="bottom-sheet-body">
            @if(Auth::check() && Auth::user()->isGuruPiket())
                @php
                    if (!isset($countPendingIzinPiket)) {
                        $countPendingIzinPiket = 0;
                        if (\Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'is_pengajuan_guru') && \Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'status_piket')) {
                            try {
                                $countPendingIzinPiket = \App\Models\GuruIzin::where('is_pengajuan_guru', 1)->where('status_piket', 'pending')->count();
                            } catch (\Throwable $e) {
                                $countPendingIzinPiket = 0;
                            }
                        }
                    }
                @endphp

                {{-- 1. Jurnal Mengajar --}}
                @php $isActive = request()->routeIs('piket.jurnal-mengajar*') || request()->is('guru-piket/jurnal-mengajar*'); @endphp
                <a href="{{ route('piket.jurnal-mengajar') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <span class="bs-menu-text">Jurnal Mengajar</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- Urgent Penugasan Pengganti jika ada --}}
                @if(isset($hasActivePenggantiPiket) && $hasActivePenggantiPiket)
                    @php $isActivePengganti = request()->routeIs('piket.isi-jurnal-pengganti*') || request()->is('guru-piket/isi-jurnal-pengganti*'); @endphp
                    <a href="{{ route('piket.isi-jurnal-pengganti') }}" class="bs-menu-item {{ $isActivePengganti ? 'active' : '' }}" onclick="closeBottomSheet()" style="background: #fffbeb;">
                        <div class="bs-menu-left">
                            <div class="bs-menu-icon" style="background: #fef3c7; color: #d97706;">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>
                            <span class="bs-menu-text" style="color: #b45309;">Jurnal & Presensi Pengganti</span>
                        </div>
                        <div class="bs-menu-right">
                            <span style="font-size: 10px; font-weight: 800; background: #f59e0b; color: #ffffff; padding: 2px 7px; border-radius: 6px;">Aktif</span>
                        </div>
                    </a>
                @endif

                {{-- 2. Guru Pengganti --}}
                @php $isActive = request()->routeIs('piket.guru-pengganti*') || request()->is('guru-piket/guru-pengganti*'); @endphp
                <a href="{{ route('piket.guru-pengganti') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <span class="bs-menu-text">Guru Pengganti</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 3. Permintaan Izin Guru --}}
                @php $isActive = request()->routeIs('piket.permintaan-izin*') || request()->is('guru-piket/permintaan-izin*'); @endphp
                <a href="{{ route('piket.permintaan-izin') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <span class="bs-menu-text">Permintaan Izin Guru</span>
                    </div>
                    <div class="bs-menu-right">
                        @if(isset($countPendingIzinPiket) && $countPendingIzinPiket > 0)
                            <span class="bs-menu-badge">{{ $countPendingIzinPiket }}</span>
                        @endif
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 4. Guru Izin Tidak Hadir --}}
                @php $isActive = request()->routeIs('piket.guru-izin-tidak-hadir*') || request()->is('guru-piket/guru-izin-tidak-hadir*'); @endphp
                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <span class="bs-menu-text">Guru Izin Tidak Hadir</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 5. Surat Izin Siswa --}}
                @php $isActive = request()->routeIs('piket.surat-izin-siswa*') || request()->is('guru-piket/surat-izin-siswa*'); @endphp
                <a href="{{ route('piket.surat-izin-siswa') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <span class="bs-menu-text">Surat Izin Siswa</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 6. Dispensasi Siswa --}}
                @php $isActive = request()->routeIs('piket.dispensasi-siswa*') || request()->is('guru-piket/dispensasi-siswa*'); @endphp
                <a href="{{ route('piket.dispensasi-siswa') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-id-card-clip"></i>
                        </div>
                        <span class="bs-menu-text">Dispensasi Siswa</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 7. Siswa Telat --}}
                @php $isActive = request()->routeIs('piket.siswa-telat*') || request()->is('guru-piket/siswa-telat*'); @endphp
                <a href="{{ route('piket.siswa-telat') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <span class="bs-menu-text">Siswa Telat</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 8. Jadwal Hari Ini --}}
                @php $isActive = request()->routeIs('piket.jadwal*') || request()->is('guru-piket/jadwal*'); @endphp
                <a href="{{ route('piket.jadwal') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <span class="bs-menu-text">Jadwal Hari Ini</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 9. Rekap Kehadiran --}}
                @php $isActive = request()->routeIs('piket.rekap-kehadiran*') || request()->is('guru-piket/rekap-kehadiran*'); @endphp
                <a href="{{ route('piket.rekap-kehadiran') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <span class="bs-menu-text">Rekap Kehadiran</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>

                {{-- 10. Pengaturan --}}
                @php $isActive = request()->routeIs('pengaturan.*') || request()->is('pengaturan*'); @endphp
                <a href="{{ route('pengaturan.index') }}" class="bs-menu-item {{ $isActive ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left">
                        <div class="bs-menu-icon">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <span class="bs-menu-text">Pengaturan</span>
                    </div>
                    <div class="bs-menu-right">
                        @if($isActive)
                            <span class="bs-menu-active-pill">Aktif</span>
                        @else
                            <i class="fa-solid fa-chevron-right bs-menu-chevron"></i>
                        @endif
                    </div>
                </a>
            @elseif(Auth::check() && Auth::user()->isSatpam())
                <a href="{{ route('satpam.dashboard') }}" class="bs-menu-item {{ request()->routeIs('satpam.dashboard') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-grip"></i></div><span class="bs-menu-text">Dashboard Satpam</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('satpam.validasi') }}" class="bs-menu-item {{ request()->routeIs('satpam.validasi*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-qrcode"></i></div><span class="bs-menu-text">Validasi</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('satpam.lapor-siswa') }}" class="bs-menu-item {{ request()->routeIs('satpam.lapor-siswa*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-triangle-exclamation"></i></div><span class="bs-menu-text">Lapor Siswa</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('satpam.log-aktivitas') }}" class="bs-menu-item {{ request()->routeIs('satpam.log-aktivitas*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-clock-rotate-left"></i></div><span class="bs-menu-text">Log Aktivitas</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('pengaturan.index') }}" class="bs-menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-gear"></i></div><span class="bs-menu-text">Pengaturan</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
            @elseif(Auth::check() && Auth::user()->isWaka())
                <a href="{{ route('waka.dashboard') }}" class="bs-menu-item {{ request()->routeIs('waka.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-user-tie"></i></div><span class="bs-menu-text">Dashboard Waka</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('pengaturan.index') }}" class="bs-menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-gear"></i></div><span class="bs-menu-text">Pengaturan</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
            @elseif(Auth::check() && Auth::user()->isKepalaSekolah())
                <a href="{{ route('kepala-sekolah.dashboard') }}" class="bs-menu-item {{ request()->routeIs('kepala-sekolah.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-user-graduate"></i></div><span class="bs-menu-text">Dashboard Kepsek</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('pengaturan.index') }}" class="bs-menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-gear"></i></div><span class="bs-menu-text">Pengaturan</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
            @else
                <a href="{{ route('guru.dashboard') }}" class="bs-menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-house"></i></div><span class="bs-menu-text">Beranda</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('guru.pengumuman') }}" class="bs-menu-item {{ request()->routeIs('guru.pengumuman*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-bullhorn"></i></div><span class="bs-menu-text">Pengumuman</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('guru.jadwal') }}" class="bs-menu-item {{ request()->routeIs('guru.jadwal') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-calendar-days"></i></div><span class="bs-menu-text">Jadwal Mengajar</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('guru.jurnal-harian') }}" class="bs-menu-item {{ request()->routeIs('guru.jurnal-harian') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-pen-to-square"></i></div><span class="bs-menu-text">Jurnal Harian</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('guru.absensi-siswa') }}" class="bs-menu-item {{ request()->routeIs('guru.absensi-siswa') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-user-check"></i></div><span class="bs-menu-text">Presensi Siswa</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
                <a href="{{ route('pengaturan.index') }}" class="bs-menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" onclick="closeBottomSheet()">
                    <div class="bs-menu-left"><div class="bs-menu-icon"><i class="fa-solid fa-gear"></i></div><span class="bs-menu-text">Pengaturan</span></div>
                    <div class="bs-menu-right"><i class="fa-solid fa-chevron-right bs-menu-chevron"></i></div>
                </a>
            @endif
        </div>
    </div>

    <script>
        function toggleBottomSheet() {
            const sheet = document.getElementById('mobileBottomSheet');
            if (!sheet) return;
            if (sheet.classList.contains('open')) {
                closeBottomSheet();
            } else {
                openBottomSheet();
            }
        }

        function openBottomSheet() {
            const sheet = document.getElementById('mobileBottomSheet');
            const backdrop = document.getElementById('mobileBottomSheetBackdrop');
            const menuBtn = document.getElementById('bottomNavMenuBtn');
            if (sheet) {
                sheet.style.transform = '';
                sheet.classList.add('open');
            }
            if (backdrop) backdrop.classList.add('active');
            if (menuBtn) menuBtn.classList.add('active');
            // Do not touch document.body.style.overflow to prevent any layout shift or scrollbar jitter on fixed bottom nav
        }

        function closeBottomSheet() {
            const sheet = document.getElementById('mobileBottomSheet');
            const backdrop = document.getElementById('mobileBottomSheetBackdrop');
            const menuBtn = document.getElementById('bottomNavMenuBtn');
            if (sheet) {
                sheet.style.transform = '';
                sheet.classList.remove('open');
            }
            if (backdrop) backdrop.classList.remove('active');
            @if(!$isMenu)
            if (menuBtn) menuBtn.classList.remove('active');
            @endif
            // Do not touch document.body.style.overflow
        }

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                toggleBottomSheet();
                return;
            }
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('open');
            if (backdrop) backdrop.classList.toggle('active');
            if (document.body) {
                if (sidebar && sidebar.classList.contains('open')) {
                    document.body.style.overflowY = 'hidden';
                } else {
                    document.body.style.overflowY = '';
                }
            }
        }

        // Swipe-down to close on bottom sheet handle & backdrop touch prevention
        document.addEventListener('DOMContentLoaded', function() {
            const backdrop = document.getElementById('mobileBottomSheetBackdrop');
            if (backdrop) {
                backdrop.addEventListener('touchmove', function(e) {
                    e.preventDefault();
                }, { passive: false });
            }

            const handleBar = document.getElementById('bottomSheetHandleBar');
            const sheet = document.getElementById('mobileBottomSheet');
            if (handleBar && sheet) {
                let startY = 0;
                let currentY = 0;

                handleBar.addEventListener('touchstart', function(e) {
                    startY = e.touches[0].clientY;
                    sheet.style.transition = 'none';
                }, { passive: true });

                handleBar.addEventListener('touchmove', function(e) {
                    currentY = e.touches[0].clientY;
                    const delta = currentY - startY;
                    if (delta > 0) {
                        sheet.style.transform = `translateY(${delta}px)`;
                    }
                }, { passive: true });

                handleBar.addEventListener('touchend', function(e) {
                    sheet.style.transition = 'transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, visibility 0.25s ease';
                    const delta = currentY - startY;
                    if (delta > 50) {
                        closeBottomSheet();
                    } else {
                        sheet.style.transform = 'translateY(0)';
                    }
                }, { passive: true });
            }
        });

        // Mobile Header Auto-Rotating Info Badge (every 2 minutes = 120000ms)
        let currentInfoSlideIdx = 0;
        function rotateMobileInfoSlide() {
            const slides = document.querySelectorAll('#mInfobadgeSlider .m-info-slide');
            if (!slides || slides.length === 0) return;
            slides[currentInfoSlideIdx].classList.remove('active');
            currentInfoSlideIdx = (currentInfoSlideIdx + 1) % slides.length;
            slides[currentInfoSlideIdx].classList.add('active');
        }
        setInterval(rotateMobileInfoSlide, 120000);

        function toggleMobileInfoTooltip(e) {
            e.stopPropagation();
            const tt = document.getElementById('mobileInfoTooltip');
            const badge = document.getElementById('mobileHeaderInfobadge');
            if (!tt) return;
            const isOpen = tt.style.display === 'block';
            tt.style.display = isOpen ? 'none' : 'block';
            if (badge) badge.classList.toggle('is-open', !isOpen);
        }

        function closeMobileInfoTooltip(e) {
            if (e) e.stopPropagation();
            const tt = document.getElementById('mobileInfoTooltip');
            const badge = document.getElementById('mobileHeaderInfobadge');
            if (tt) tt.style.display = 'none';
            if (badge) badge.classList.remove('is-open');
        }

        document.addEventListener('click', function(e) {
            const tt = document.getElementById('mobileInfoTooltip');
            const badge = document.getElementById('mobileHeaderInfobadge');
            if (tt && tt.style.display === 'block') {
                if (!tt.contains(e.target) && !badge.contains(e.target)) {
                    tt.style.display = 'none';
                    if (badge) badge.classList.remove('is-open');
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
