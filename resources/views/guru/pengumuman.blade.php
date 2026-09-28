@extends('layouts.guru')

@section('title', 'Informasi Pengumuman — Portal Guru')
@section('header_title', 'Pengumuman')

@section('styles')
<style>
    /* =========================================================
       PAGE CONTAINER & THEME
       ========================================================= */
    .pengumuman-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    /* Page Header */
    .pengumuman-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .pengumuman-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pengumuman-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
        flex-shrink: 0;
    }

    .pengumuman-header-text h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px 0;
        letter-spacing: -0.02em;
    }

    .pengumuman-header-text p {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin: 0;
    }

    /* =========================================================
       4 KARTU STATISTIK (GRADIENT CARDS + SOLID ICONS + WAVE & SPARKLES)
       ========================================================= */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card-gradient {
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(15, 23, 42, 0.06);
    }

    /* Card Themes */
    .card-theme-purple {
        background: linear-gradient(135deg, #ffffff 0%, #faf5ff 50%, #f3e8ff 100%);
        border: 1px solid rgba(216, 180, 254, 0.75);
    }
    .text-purple-600 { color: #7c3aed; }
    .wave-purple { color: #d8b4fe; opacity: 0.55; }

    .card-theme-rose {
        background: linear-gradient(135deg, #ffffff 0%, #fff1f2 50%, #ffe4e6 100%);
        border: 1px solid rgba(254, 205, 211, 0.75);
    }
    .text-rose-600 { color: #e11d48; }
    .text-rose-500 { color: #f43f5e; }
    .wave-rose { color: #fecdd3; opacity: 0.55; }

    .card-theme-emerald {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #dcfce7 100%);
        border: 1px solid rgba(187, 247, 208, 0.75);
    }
    .text-emerald-600 { color: #059669; }
    .text-emerald-500 { color: #10b981; }
    .wave-emerald { color: #bbf7d0; opacity: 0.55; }

    .card-theme-blue {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 50%, #e0f2fe 100%);
        border: 1px solid rgba(186, 230, 253, 0.75);
    }
    .text-blue-600 { color: #2563eb; }
    .wave-blue { color: #bae6fd; opacity: 0.55; }

    .stat-card-left {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 2;
    }

    /* Circular Solid Colored Icon Box */
    .stat-circle-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .icon-solid-purple {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.28);
    }

    .icon-solid-rose {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.28);
    }

    .icon-solid-emerald {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.28);
    }

    .icon-solid-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
    }

    .stat-meta {
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 2;
    }

    .stat-meta-label {
        font-size: 11.5px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .stat-meta-value-wrap {
        display: flex;
        align-items: baseline;
        gap: 5px;
    }

    .stat-meta-value {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .stat-meta-unit {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-meta-sub {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 3px;
    }

    /* Decorative Corner Elements (Sparkles) */
    .stat-corner-elem {
        position: absolute;
        top: 12px;
        right: 14px;
        z-index: 2;
        pointer-events: none;
        display: flex;
        gap: 3px;
        align-items: flex-start;
    }

    /* Decorative Bottom-Right Wave */
    .stat-card-wave {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 100px;
        height: 52px;
        pointer-events: none;
        z-index: 1;
    }

    /* =========================================================
       FILTER BAR & TOOLBAR (HORIZONTAL ON DESKTOP)
       ========================================================= */
    .filter-card-ref {
        background: #ffffff;
        border-radius: 18px;
        padding: 16px 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Row 1: Single Horizontal Line on Desktop */
    .filter-main-row {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .search-input-wrapper {
        flex: 1;
        min-width: 220px;
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 9.5px 14px 9.5px 38px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
        font-family: inherit;
    }

    .search-input-wrapper input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .filter-select-wrapper {
        flex: 0 0 170px;
        min-width: 150px;
    }

    .filter-select-wrapper select {
        width: 100%;
        padding: 9.5px 32px 9.5px 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 13px;
        color: #334155;
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 10px center;
        background-repeat: no-repeat;
        background-size: 16px 16px;
        appearance: none;
    }

    .filter-select-wrapper select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .filter-date-wrapper {
        flex: 0 0 155px;
        min-width: 140px;
    }

    .filter-date-wrapper input {
        width: 100%;
        padding: 9.5px 12px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 13px;
        color: #334155;
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    .filter-date-wrapper input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .filter-btns-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-search-dark {
        background: #334e68;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .btn-search-dark:hover {
        background: #243b53;
    }

    .btn-reset-outline {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-reset-outline:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    /* Row 2: Actions & Toolbar */
    .filter-toolbar-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        flex-wrap: wrap;
    }

    .actions-left, .actions-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action-outline {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-action-outline:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .btn-batch-trash {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-batch-trash:hover:not(:disabled) {
        background: #fee2e2;
        color: #be123c;
    }

    .btn-batch-trash:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background: #f8fafc;
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    .btn-trash-menu {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-trash-menu:hover {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fca5a5;
    }

    /* =========================================================
       DAFTAR PENGUMUMAN (CARD LIST CONTAINER)
       ========================================================= */
    .announcement-list-container {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .list-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .list-title-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .list-icon-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .list-title-text h2 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .list-title-text p {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    .sort-dropdown-wrapper select {
        padding: 7px 28px 7px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        outline: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 8px center;
        background-repeat: no-repeat;
        background-size: 14px 14px;
        appearance: none;
    }

    /* Cards Stack */
    .announcement-cards-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .announcement-card-item {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        border-left-width: 5px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .announcement-card-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    }

    .card-left-group {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    /* Custom Checkbox */
    .item-checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-checkbox {
        width: 17px;
        height: 17px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
        cursor: pointer;
        accent-color: #2563eb;
    }

    /* Category Icon Box */
    .category-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .category-badge-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .card-text-block {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .card-main-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-main-snippet {
        font-size: 12.5px;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Right Meta & Actions */
    .card-right-group {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-shrink: 0;
    }

    .card-meta-column {
        display: flex;
        flex-direction: column;
        gap: 3px;
        font-size: 12px;
        color: #64748b;
        min-width: 140px;
    }

    .card-meta-row {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .card-meta-row i {
        color: #94a3b8;
        font-size: 11.5px;
        width: 14px;
        text-align: center;
    }

    /* Status Read Badges */
    .badge-status-unread {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #ffe4e6;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-status-unread .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #e11d48;
        display: inline-block;
    }

    .badge-status-read {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #d1fae5;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-status-read i {
        font-size: 11px;
    }

    /* Buttons */
    .btn-card-detail {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #2563eb;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-card-detail:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    /* Menu 3-Dots Dropdown */
    .menu-dots-container {
        position: relative;
    }

    .btn-dots-toggle {
        background: transparent;
        border: none;
        color: #94a3b8;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-dots-toggle:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .dots-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.1);
        min-width: 190px;
        z-index: 50;
        padding: 6px;
        margin-top: 4px;
    }

    .dots-dropdown-menu.show {
        display: block;
    }

    .dots-menu-item {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 8px 12px;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        border: none;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        text-align: left;
        text-decoration: none;
        transition: background 0.15s;
    }

    .dots-menu-item:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .dots-menu-item.text-danger:hover {
        background: #fff1f2;
        color: #e11d48;
    }

    /* =========================================================
       PAGINATION (INDIVIDUAL ROUNDED BOXES)
       ========================================================= */
    .pagination-bar-wrapper {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #f8fafc;
    }

    .page-box-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .page-box-btn:hover:not(.active):not(:disabled) {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .page-box-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .page-box-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f8fafc;
    }

    /* =========================================================
       MODALS & TOAST
       ========================================================= */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .modal-content-ref {
        background: #ffffff;
        width: 100%;
        max-width: 640px;
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
        border: 1px solid #e2e8f0;
    }

    #pengumumanToast {
        display: none;
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        z-index: 9999;
        align-items: center;
        gap: 10px;
    }

    /* Empty state */
    .empty-state-box {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
    }

    .empty-state-box i {
        font-size: 42px;
        margin-bottom: 12px;
        color: #cbd5e1;
    }

    /* =========================================================
       RESPONSIVE BREAKPOINTS
       ========================================================= */
    @media (max-width: 1100px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .announcement-card-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .card-right-group {
            width: 100%;
            justify-content: space-between;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
    }

    @media (max-width: 950px) {
        .filter-main-row {
            flex-wrap: wrap;
        }
        .search-input-wrapper {
            flex: 1 1 100%;
        }
        .filter-select-wrapper, .filter-date-wrapper {
            flex: 1 1 calc(50% - 6px);
        }
        .filter-btns-group {
            width: 100%;
            justify-content: flex-end;
        }
    }

    @media (max-width: 640px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .filter-select-wrapper, .filter-date-wrapper {
            flex: 1 1 100%;
        }
        .filter-btns-group {
            flex-direction: column;
            width: 100%;
        }
        .filter-btns-group button, .filter-btns-group a {
            width: 100%;
            justify-content: center;
        }
        .filter-toolbar-row {
            flex-direction: column;
            align-items: stretch;
        }
        .actions-left, .actions-right {
            width: 100%;
            justify-content: space-between;
        }
        .card-left-group { flex-wrap: wrap; }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-page-wrapper">

    <!-- 1. Header Section -->
    <div class="pengumuman-header-bar">
        <div class="pengumuman-header-left">
            <div class="pengumuman-header-icon">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="pengumuman-header-text">
                <h1>Pengumuman</h1>
                <p>Informasi terbaru seputar kegiatan, jadwal, dan pemberitahuan sekolah.</p>
            </div>
        </div>
    </div>

    <!-- 2. 4 Kartu Statistik (Gradient Cards dengan Ikon Solid Colored & Wave/Sparkle) -->
    @php
        $uniqueCategoriesCount = $pengumumanList->pluck('kategori')->filter()->unique()->count();
        if ($uniqueCategoriesCount === 0 && count($pengumumanList) > 0) {
            $uniqueCategoriesCount = 1;
        }
    @endphp
    <div class="stat-cards-grid">
        <!-- Card 1: Total Pengumuman (Ungu / Purple Gradient) -->
        <div class="stat-card-gradient card-theme-purple">
            <div class="stat-card-left">
                <div class="stat-circle-icon icon-solid-purple">
                    <i class="fa-regular fa-bell"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-meta-label text-purple-600">Total Pengumuman</span>
                    <div class="stat-meta-value-wrap">
                        <span class="stat-meta-value" id="statTotalVal">{{ $stats['totalPengumuman'] ?? count($pengumumanList) }}</span>
                        <span class="stat-meta-unit">Data</span>
                    </div>
                    <span class="stat-meta-sub">Informasi terbaru untuk Anda</span>
                </div>
            </div>

            <!-- Corner Sparkles -->
            <div class="stat-corner-elem" style="color: #c084fc;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 2: Baru (Belum Dibaca) (Merah / Rose Gradient) -->
        <div class="stat-card-gradient card-theme-rose">
            <div class="stat-card-left">
                <div class="stat-circle-icon icon-solid-rose">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-meta-label text-rose-600">Baru (Belum Dibaca)</span>
                    <div class="stat-meta-value-wrap">
                        <span class="stat-meta-value text-rose-600" id="statUnreadVal">{{ $stats['totalUnread'] ?? 0 }}</span>
                        <span class="stat-meta-unit text-rose-500">Data</span>
                    </div>
                    <span class="stat-meta-sub">Jangan lewatkan informasinya</span>
                </div>
            </div>

            <!-- Corner Sparkles -->
            <div class="stat-corner-elem" style="color: #fb7185;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-rose" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 3: Sudah Dibaca (Hijau / Emerald Gradient) -->
        <div class="stat-card-gradient card-theme-emerald">
            <div class="stat-card-left">
                <div class="stat-circle-icon icon-solid-emerald">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-meta-label text-emerald-600">Sudah Dibaca</span>
                    <div class="stat-meta-value-wrap">
                        <span class="stat-meta-value text-emerald-600" id="statReadVal">{{ $stats['totalRead'] ?? 0 }}</span>
                        <span class="stat-meta-unit text-emerald-500">Data</span>
                    </div>
                    <span class="stat-meta-sub">Terima kasih sudah membaca</span>
                </div>
            </div>

            <!-- Corner Sparkles -->
            <div class="stat-corner-elem" style="color: #34d399;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 4: Kategori (Biru / Blue Gradient) -->
        <div class="stat-card-gradient card-theme-blue">
            <div class="stat-card-left">
                <div class="stat-circle-icon icon-solid-blue">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-meta-label text-blue-600">Kategori</span>
                    <div class="stat-meta-value-wrap">
                        <span class="stat-meta-value">{{ $uniqueCategoriesCount }}</span>
                        <span class="stat-meta-unit">Kategori</span>
                    </div>
                    <span class="stat-meta-sub">Berbagai jenis pengumuman</span>
                </div>
            </div>

            <!-- Corner Sparkles -->
            <div class="stat-corner-elem" style="color: #60a5fa;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>
    </div>

    <!-- Alert Flash Message -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 14px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- 3. Filter Bar & Toolbar Aksi (Horizontal Sejajar di Desktop) -->
    <div class="filter-card-ref">
        <form action="{{ route('guru.pengumuman') }}" method="GET" id="pengumumanFilterForm">
            <!-- Row 1: Input Pencarian, Dropdown, Date Picker, dan Tombol Cari & Reset (Sejajar Horizontal) -->
            <div class="filter-main-row">
                <!-- Search Input (flex-1) -->
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul pengumuman, kata kunci...">
                </div>

                <!-- Dropdown Kategori -->
                <div class="filter-select-wrapper">
                    <select name="kategori">
                        <option value="">Kategori: Semua</option>
                        @php
                            $knownCategories = ['Umum', 'Akademik', 'Kurikulum', 'Kegiatan', 'Penugasan', 'Workshop', 'Rapat', 'Perubahan Jadwal', 'Kesiswaan', 'Siswa Telat'];
                        @endphp
                        @foreach($knownCategories as $kat)
                            <option value="{{ $kat }}" {{ $kategoriFilter === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Status Baca (Semua / Belum Dibaca / Sudah Dibaca) -->
                <div class="filter-select-wrapper">
                    <select name="read_status">
                        <option value="">Status: Semua</option>
                        <option value="unread" {{ $readStatusFilter === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="read" {{ $readStatusFilter === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                </div>

                <!-- Date Picker (Single Date) -->
                <div class="filter-date-wrapper">
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" title="Pilih Tanggal Pengumuman">
                </div>

                <!-- Tombol Cari & Reset di sisi kanan baris filter -->
                <div class="filter-btns-group">
                    <button type="submit" class="btn-search-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    <a href="{{ route('guru.pengumuman') }}" class="btn-reset-outline">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </div>

            <!-- Row 2: Toolbar Aksi (Pilih Semua, Tandai Semua, Hapus Terpilih, Sampah) -->
            <div class="filter-toolbar-row">
                <div class="actions-left">
                    <!-- Checkbox Pilih Semua -->
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; cursor: pointer; display: flex; align-items: center; gap: 8px; margin: 0; user-select: none;">
                        <input type="checkbox" id="selectAllPengumumanCheckboxes" style="width: 16px; height: 16px; cursor: pointer; accent-color: #2563eb;">
                        <span>Pilih Semua</span>
                    </label>
                </div>

                <div class="actions-right">
                    <!-- Tombol Tandai Semua Sudah Dibaca -->
                    <button type="button" class="btn-action-outline" onclick="markAllAsRead()" title="Tandai semua pengumuman yang tampil sebagai sudah dibaca">
                        <i class="fa-solid fa-check" style="color: #2563eb;"></i> Tandai Semua Sudah Dibaca
                    </button>

                    <!-- Tombol Hapus Terpilih (Batch Delete) -->
                    <button type="button" id="btnBatchDeleteTop" class="btn-batch-trash" onclick="confirmBatchDeletePengumuman()" disabled>
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="batchDeleteCountText">0</span>)
                    </button>

                    <!-- Tombol Sampah Pribadi Guru (Fitur Lokal Tetap Terjaga) -->
                    <a href="{{ route('guru.pengumuman.trash') }}" class="btn-trash-menu" title="Buka Tempat Sampah Pengumuman">
                        <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount ?? 0 }})
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Hidden Form for Batch Delete -->
    <form id="formBatchDeletePengumuman" action="{{ route('guru.pengumuman.destroy-batch') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <div id="batchDeleteInputsContainer"></div>
    </form>

    <!-- 4. Daftar Pengumuman (Card List View) -->
    <div class="announcement-list-container" id="daftarPengumumanCard">
        <!-- List Header Bar -->
        <div class="list-header-bar">
            <div class="list-title-box">
                <div class="list-icon-badge">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <div class="list-title-text">
                    <h2>Daftar Pengumuman</h2>
                    <p>Menampilkan <span id="displayedCountText">0</span> dari {{ count($pengumumanList) }} data</p>
                </div>
            </div>

            <!-- Sorting Dropdown (Terbaru / Terlama via Client-Side JS) -->
            <div class="sort-dropdown-wrapper">
                <select id="sortPengumumanSelect" onchange="applySorting(this.value)">
                    <option value="terbaru">Terbaru</option>
                    <option value="terlama">Terlama</option>
                </select>
            </div>
        </div>

        <!-- Announcement Cards Stack -->
        <div class="announcement-cards-stack" id="announcementCardsContainer">
            @forelse($pengumumanList as $index => $row)
                @php
                    $isTelat = strtolower($row->kategori ?? '') === 'siswa telat';
                    $kelasNama = $row->kelas->nama_kelas ?? ($row->id_kelas ? 'Kelas #'.$row->id_kelas : 'Semua Kelas');
                    $pembuatNama = $row->pembuat->nama_guru ?? ($isTelat ? 'Guru Piket' : 'Admin Sekolah');
                    $tanggalFormatted = \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y');
                    $waktuFormatted = $row->jam_mengajar ?: \Carbon\Carbon::parse($row->created_at)->format('H:i');
                    $isRead = in_array($row->id_pengumuman, $readAnnouncementIds);
                    $timestampVal = \Carbon\Carbon::parse($row->tanggal)->timestamp + ($row->created_at ? \Carbon\Carbon::parse($row->created_at)->timestamp % 86400 : 0);

                    // Category visual tokens based on reference screenshot
                    $katName = trim($row->kategori ?: 'Umum');
                    $kLow = strtolower($katName);

                    if (str_contains($kLow, 'umum')) {
                        $borderLeftColor = '#f43f5e'; // Red
                        $badgeBg = '#ffe4e6';
                        $badgeText = '#e11d48';
                        $iconBg = '#fff1f2';
                        $iconColor = '#f43f5e';
                        $iconClass = 'fa-solid fa-bullhorn';
                    } elseif (str_contains($kLow, 'akademik') || str_contains($kLow, 'kurikulum')) {
                        $borderLeftColor = '#10b981'; // Green
                        $badgeBg = '#d1fae5';
                        $badgeText = '#059669';
                        $iconBg = '#ecfdf5';
                        $iconColor = '#10b981';
                        $iconClass = 'fa-solid fa-book-open';
                    } elseif (str_contains($kLow, 'kegiatan') || str_contains($kLow, 'telat')) {
                        $borderLeftColor = '#f59e0b'; // Amber / Orange
                        $badgeBg = '#fef3c7';
                        $badgeText = '#d97706';
                        $iconBg = '#fffbeb';
                        $iconColor = '#f59e0b';
                        $iconClass = str_contains($kLow, 'telat') ? 'fa-solid fa-user-clock' : 'fa-regular fa-calendar-days';
                    } elseif (str_contains($kLow, 'kesiswaan')) {
                        $borderLeftColor = '#3b82f6'; // Blue
                        $badgeBg = '#dbeafe';
                        $badgeText = '#2563eb';
                        $iconBg = '#eff6ff';
                        $iconColor = '#3b82f6';
                        $iconClass = 'fa-solid fa-users';
                    } else {
                        // Pengumuman, Penugasan, Workshop, Rapat
                        $borderLeftColor = '#8b5cf6'; // Purple
                        $badgeBg = '#ede9fe';
                        $badgeText = '#7c3aed';
                        $iconBg = '#f5f3ff';
                        $iconColor = '#8b5cf6';
                        $iconClass = 'fa-regular fa-file-lines';
                    }
                @endphp

                <div class="announcement-card-item {{ $isRead ? 'is-read-done' : 'is-unread' }}" 
                     id="card-pengumuman-{{ $row->id_pengumuman }}"
                     data-id="{{ $row->id_pengumuman }}"
                     data-timestamp="{{ $timestampVal }}"
                     style="border-left-color: {{ $borderLeftColor }};">
                    
                    <!-- Left: Checkbox, Category Icon, Badge, Judul & Cuplikan -->
                    <div class="card-left-group">
                        <div class="item-checkbox-wrapper">
                            <input type="checkbox" 
                                   value="{{ $row->id_pengumuman }}" 
                                   class="item-checkbox item-checkbox-pengumuman" 
                                   onchange="updateBatchPengumumanState()">
                        </div>

                        <!-- Category Icon Box -->
                        <div class="category-icon-box" style="background: {{ $iconBg }}; color: {{ $iconColor }};">
                            <i class="{{ $iconClass }}"></i>
                        </div>

                        <!-- Category Badge Pill -->
                        <span class="category-badge-pill" style="background: {{ $badgeBg }}; color: {{ $badgeText }};">
                            {{ $katName }}
                        </span>

                        <!-- Main Title & Excerpt -->
                        <div class="card-text-block">
                            <h3 class="card-main-title" title="{{ $row->judul }}">
                                {{ $row->judul }}
                            </h3>
                            <p class="card-main-snippet" title="{{ $row->isi }}">
                                {{ Str::limit(strip_tags($row->isi), 110, '...') }}
                            </p>
                        </div>
                    </div>

                    <!-- Right: Meta Info, Status Badge, Detail Button, 3-Dots Menu -->
                    <div class="card-right-group">
                        <!-- Date & Author Meta -->
                        <div class="card-meta-column">
                            <div class="card-meta-row">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ $tanggalFormatted }}, {{ $waktuFormatted }}</span>
                            </div>
                            <div class="card-meta-row">
                                <i class="fa-regular fa-user"></i>
                                <span>{{ Str::limit($pembuatNama, 20) }}</span>
                            </div>
                        </div>

                        <!-- Status Badge (Belum Dibaca / Sudah Dibaca) -->
                        <div id="badge-read-wrapper-{{ $row->id_pengumuman }}">
                            @if(!$isRead)
                                <span class="badge-status-unread">
                                    <span class="dot"></span> Belum Dibaca
                                </span>
                            @else
                                <span class="badge-status-read">
                                    <i class="fa-solid fa-check"></i> Sudah Dibaca
                                </span>
                            @endif
                        </div>

                        <!-- Tombol Detail -->
                        <button type="button" 
                                class="btn-card-detail" 
                                onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "{{ addslashes($pembuatNama) }}", "{{ $tanggalFormatted }}", {{ $row->id_pengumuman }})'>
                            <i class="fa-regular fa-eye"></i> Detail
                        </button>

                        <!-- Menu 3-Dots -->
                        <div class="menu-dots-container">
                            <button type="button" class="btn-dots-toggle" onclick="toggleDotsMenu({{ $row->id_pengumuman }}, event)" title="Opsi Lain">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dots-dropdown-menu" id="dotsMenu-{{ $row->id_pengumuman }}">
                                <button type="button" 
                                        class="dots-menu-item" 
                                        id="btn-toggle-read-{{ $row->id_pengumuman }}"
                                        onclick="toggleReadStatus({{ $row->id_pengumuman }})">
                                    <i class="{{ $isRead ? 'fa-regular fa-envelope' : 'fa-solid fa-envelope-open' }}"></i>
                                    <span>{{ $isRead ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}</span>
                                </button>
                                
                                <form action="{{ route('guru.pengumuman.destroy', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan pengumuman ini ke Sampah?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dots-menu-item text-danger">
                                        <i class="fa-regular fa-trash-can" style="color: #e11d48;"></i>
                                        <span>Pindahkan ke Sampah</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="empty-state-box">
                    <i class="fa-solid fa-bullhorn"></i>
                    <h4 style="font-size: 15px; font-weight: 700; color: #475569; margin-bottom: 4px;">Tidak ada pengumuman ditemukan</h4>
                    <p style="font-size: 13px; color: #94a3b8; margin: 0;">Silakan ubah filter pencarian atau tanggal untuk menampilkan informasi lainnya.</p>
                </div>
            @endforelse
        </div>

        <!-- 5. Client-Side Pagination (Individual Rounded Boxes) -->
        @if(count($pengumumanList) > 0)
            <div class="pagination-bar-wrapper" id="paginationBarContainer">
                <!-- Di-render via JavaScript secara dinamis -->
            </div>
        @endif
    </div>

</div>

<!-- =========================================================
     MODAL DETAIL PENGUMUMAN
     ========================================================= -->
<div id="guruDetailPengumumanModal" class="modal-overlay">
    <div class="modal-content-ref">
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Detail Informasi Pengumuman</h3>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="display: flex; flex-direction: column; gap: 14px;">
            <!-- Category & Read Status -->
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <span id="detailKategori" style="font-size: 11.5px; background: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 20px; font-weight: 700;"></span>
                <div id="detailReadBadge"></div>
            </div>

            <!-- Title -->
            <h2 id="detailJudul" style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.35;"></h2>

            <!-- Meta Information Box -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px;">
                <div><span style="color: #64748b; font-weight: 600;">Kelas Target:</span> <strong id="detailKelas" style="color: #0f172a;"></strong></div>
                <div><span style="color: #64748b; font-weight: 600;">Waktu/Jam:</span> <strong id="detailJam" style="color: #0f172a;"></strong></div>
                <div><span style="color: #64748b; font-weight: 600;">Pembuat:</span> <strong id="detailPembuat" style="color: #0f172a;"></strong></div>
                <div><span style="color: #64748b; font-weight: 600;">Tanggal:</span> <strong id="detailTanggal" style="color: #0f172a;"></strong></div>
                <div style="grid-column: span 2;"><span style="color: #64748b; font-weight: 600;">Keterangan:</span> <strong id="detailKeterangan" style="color: #0f172a;"></strong></div>
            </div>

            <!-- Content Area -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; font-size: 13.5px; line-height: 1.6; color: #334155; white-space: pre-line; max-height: 240px; overflow-y: auto;" id="detailIsi">
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px;">
            <div id="modalFooterToggleRead"></div>
            <button type="button" onclick="closeDetailModal()" class="btn-card-detail" style="padding: 8px 22px; font-size: 13px;">Tutup</button>
        </div>
    </div>
</div>

<!-- =========================================================
     MODAL BATCH DELETE CONFIRMATION
     ========================================================= -->
<div id="modalBatchDeletePengumuman" class="modal-overlay">
    <div class="modal-content-ref" style="max-width: 440px; text-align: center; padding: 28px 24px;">
        <div style="width: 54px; height: 54px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 16px;">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Hapus Pengumuman Terpilih ke Sampah?</h3>
        <p style="font-size: 13px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
            Anda akan memindahkan <strong id="modalBatchPengumumanCount" style="color: #ef4444;">0</strong> pengumuman terpilih ke Tempat Sampah dan dapat dipulihkan kapan saja.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" onclick="closeBatchDeletePengumumanModal()" style="padding: 9px 20px; background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px;">
                Batal
            </button>
            <button type="button" onclick="submitBatchDeletePengumuman()" style="padding: 9px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px;">
                Ya, Hapus Terpilih
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="pengumumanToast">
    <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 17px;"></i>
    <span id="toastMessage">Pemberitahuan berhasil diperbarui</span>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

    // =========================================================
    // CLIENT-SIDE PAGINATION & SORTING STATE
    // =========================================================
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let currentCards = [];

    $(document).ready(function() {
        initCardsList();

        // Checkbox pilih semua
        $('#selectAllPengumumanCheckboxes').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox-pengumuman').prop('checked', isChecked);
            updateBatchPengumumanState();
        });

        // Close 3-dots dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.menu-dots-container').length) {
                $('.dots-dropdown-menu').removeClass('show');
            }
        });
    });

    function initCardsList() {
        currentCards = $('.announcement-card-item').toArray();
        renderPagination();
        showCurrentPageCards();
    }

    function toggleDotsMenu(id, e) {
        e.stopPropagation();
        const menu = $('#dotsMenu-' + id);
        $('.dots-dropdown-menu').not(menu).removeClass('show');
        menu.toggleClass('show');
    }

    function applySorting(mode) {
        const container = $('#announcementCardsContainer');
        currentCards.sort(function(a, b) {
            const timeA = parseInt($(a).data('timestamp')) || 0;
            const timeB = parseInt($(b).data('timestamp')) || 0;
            return mode === 'terlama' ? (timeA - timeB) : (timeB - timeA);
        });

        // Re-append in sorted order
        currentCards.forEach(function(card) {
            container.append(card);
        });

        currentPage = 1;
        renderPagination();
        showCurrentPageCards();
    }

    function showCurrentPageCards() {
        const totalItems = currentCards.length;
        if (totalItems === 0) {
            $('#displayedCountText').text('0');
            return;
        }

        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, totalItems);

        currentCards.forEach(function(card, idx) {
            if (idx >= startIndex && idx < endIndex) {
                $(card).show();
            } else {
                $(card).hide();
            }
        });

        $('#displayedCountText').text((endIndex - startIndex));
    }

    function renderPagination() {
        const container = $('#paginationBarContainer');
        container.empty();

        const totalItems = currentCards.length;
        const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);

        if (totalPages <= 1) {
            return; // No pagination needed for <= 1 page
        }

        // First page «
        const btnFirst = $(`<button type="button" class="page-box-btn" title="Halaman Pertama">&laquo;</button>`);
        if (currentPage === 1) btnFirst.prop('disabled', true);
        btnFirst.on('click', function() { goToPage(1); });
        container.append(btnFirst);

        // Prev page ‹
        const btnPrev = $(`<button type="button" class="page-box-btn" title="Halaman Sebelumnya">&lsaquo;</button>`);
        if (currentPage === 1) btnPrev.prop('disabled', true);
        btnPrev.on('click', function() { goToPage(currentPage - 1); });
        container.append(btnPrev);

        // Numbered Pages
        for (let i = 1; i <= totalPages; i++) {
            const btnPage = $(`<button type="button" class="page-box-btn ${i === currentPage ? 'active' : ''}">${i}</button>`);
            btnPage.on('click', (function(p) {
                return function() { goToPage(p); };
            })(i));
            container.append(btnPage);
        }

        // Next page ›
        const btnNext = $(`<button type="button" class="page-box-btn" title="Halaman Selanjutnya">&rsaquo;</button>`);
        if (currentPage === totalPages) btnNext.prop('disabled', true);
        btnNext.on('click', function() { goToPage(currentPage + 1); });
        container.append(btnNext);

        // Last page »
        const btnLast = $(`<button type="button" class="page-box-btn" title="Halaman Terakhir">&raquo;</button>`);
        if (currentPage === totalPages) btnLast.prop('disabled', true);
        btnLast.on('click', function() { goToPage(totalPages); });
        container.append(btnLast);
    }

    function goToPage(page) {
        const totalPages = Math.ceil(currentCards.length / ITEMS_PER_PAGE);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPagination();
        showCurrentPageCards();
        
        // Smooth scroll to top of card container if scrolled down
        const cardTop = $('#daftarPengumumanCard').offset().top - 20;
        if ($(window).scrollTop() > cardTop) {
            $('html, body').animate({ scrollTop: cardTop }, 200);
        }
    }

    // =========================================================
    // TOAST NOTIFICATION
    // =========================================================
    function showToast(message, isSuccess = true) {
        const toast = $('#pengumumanToast');
        const icon = toast.find('i');
        $('#toastMessage').text(message);
        
        if (isSuccess) {
            icon.attr('class', 'fa-solid fa-circle-check').css('color', '#10b981');
        } else {
            icon.attr('class', 'fa-solid fa-circle-exclamation').css('color', '#ef4444');
        }

        toast.stop(true, true).fadeIn(200).delay(3000).fadeOut(300);
    }

    // =========================================================
    // BATCH SELECTION & DELETE
    // =========================================================
    function updateBatchPengumumanState() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox-pengumuman').length;
        const btnBatch = $('#btnBatchDeleteTop');
        const badgeCount = $('#batchDeleteCountText');
        const selectAllCb = $('#selectAllPengumumanCheckboxes');

        badgeCount.text(count);

        if (totalItems > 0 && count === totalItems) {
            selectAllCb.prop('checked', true);
        } else {
            selectAllCb.prop('checked', false);
        }

        if (count > 0) {
            btnBatch.prop('disabled', false);
        } else {
            btnBatch.prop('disabled', true);
        }
    }

    function confirmBatchDeletePengumuman() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;

        if (count === 0) {
            showToast('Silakan centang minimal satu pengumuman yang ingin dihapus.', false);
            return;
        }

        $('#modalBatchPengumumanCount').text(count);
        $('#modalBatchDeletePengumuman').css('display', 'flex');
    }

    function closeBatchDeletePengumumanModal() {
        $('#modalBatchDeletePengumuman').css('display', 'none');
    }

    function submitBatchDeletePengumuman() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const container = $('#batchDeleteInputsContainer');
        container.empty();
        checkedItems.each(function() {
            container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
        });
        $('#formBatchDeletePengumuman').submit();
    }

    // =========================================================
    // REALTIME READ / UNREAD STATUS UI UPDATE
    // =========================================================
    function updateCardReadUI(id, isRead) {
        const card = $('#card-pengumuman-' + id);
        const badgeWrapper = $('#badge-read-wrapper-' + id);
        const menuBtn = $('#btn-toggle-read-' + id);

        if (isRead) {
            card.removeClass('is-unread').addClass('is-read-done');
            badgeWrapper.html(`
                <span class="badge-status-read">
                    <i class="fa-solid fa-check"></i> Sudah Dibaca
                </span>
            `);
            menuBtn.html('<i class="fa-regular fa-envelope"></i> <span>Tandai Belum Dibaca</span>');
        } else {
            card.removeClass('is-read-done').addClass('is-unread');
            badgeWrapper.html(`
                <span class="badge-status-unread">
                    <span class="dot"></span> Belum Dibaca
                </span>
            `);
            menuBtn.html('<i class="fa-solid fa-envelope-open"></i> <span>Tandai Sudah Dibaca</span>');
        }
    }

    function refreshStatsFromDOM() {
        const totalCards = $('.announcement-card-item').length;
        const unreadCards = $('.badge-status-unread').length;
        const readCards = $('.badge-status-read').length;

        $('#statUnreadVal').text(unreadCards);
        $('#statReadVal').text(readCards);

        // Live update sidebar badge if present
        const sidebarBadge = $('#sidebarPengumumanUnreadBadge');
        if (sidebarBadge.length) {
            sidebarBadge.text(unreadCards);
            sidebarBadge.toggle(unreadCards > 0);
        }
    }

    // =========================================================
    // AJAX ACTIONS: TOGGLE READ, MARK ALL READ, DETAIL
    // =========================================================
    function toggleReadStatus(id) {
        $.ajax({
            url: '/guru-pengumuman/' + id + '/toggle-read',
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCardReadUI(id, response.is_read);
                    refreshStatsFromDOM();
                    showToast(response.message);

                    if ($('#guruDetailPengumumanModal').is(':visible')) {
                        updateModalReadBadge(response.is_read);
                    }
                }
            },
            error: function() {
                showToast('Gagal mengubah status baca. Silakan coba lagi.', false);
            }
        });
    }

    function markAsReadSilent(id) {
        $.ajax({
            url: '/guru-pengumuman/' + id + '/mark-read',
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCardReadUI(id, true);
                    refreshStatsFromDOM();
                    updateModalReadBadge(true);
                }
            }
        });
    }

    function markAllAsRead() {
        if (!confirm('Tandai semua pengumuman sebagai sudah dibaca?')) return;

        $.ajax({
            url: '{{ route("guru.pengumuman.mark-all-read") }}',
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.announcement-card-item').each(function() {
                        const id = $(this).data('id');
                        if (id) updateCardReadUI(id, true);
                    });
                    refreshStatsFromDOM();
                    showToast(response.message || 'Semua pengumuman berhasil ditandai sudah dibaca.');
                }
            },
            error: function() {
                showToast('Gagal memproses permintaan.', false);
            }
        });
    }

    function updateModalReadBadge(isRead) {
        if (isRead) {
            $('#detailReadBadge').html(`
                <span class="badge-status-read">
                    <i class="fa-solid fa-check"></i> Sudah Dibaca
                </span>
            `);
        } else {
            $('#detailReadBadge').html(`
                <span class="badge-status-unread">
                    <span class="dot"></span> Belum Dibaca
                </span>
            `);
        }
    }

    function openDetailModal(data, kelasNama, pembuatNama, tanggalFormatted, idPengumuman) {
        document.getElementById('detailJudul').innerText = data.judul || '-';
        document.getElementById('detailKategori').innerText = data.kategori || 'Umum';
        document.getElementById('detailKelas').innerText = kelasNama;
        document.getElementById('detailJam').innerText = data.jam_mengajar || '-';
        document.getElementById('detailPembuat').innerText = pembuatNama;
        document.getElementById('detailTanggal').innerText = tanggalFormatted;
        document.getElementById('detailKeterangan').innerText = data.keterangan || '-';
        document.getElementById('detailIsi').innerText = data.isi || '-';

        updateModalReadBadge(true);

        $('#modalFooterToggleRead').html(`
            <button type="button" class="btn-card-detail" onclick="toggleReadStatus(${idPengumuman})" style="color: #64748b;">
                <i class="fa-regular fa-envelope"></i> Ubah Status Jadi Belum Dibaca
            </button>
        `);

        if (idPengumuman) {
            markAsReadSilent(idPengumuman);
        }

        document.getElementById('guruDetailPengumumanModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('guruDetailPengumumanModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('guruDetailPengumumanModal');
        if (event.target === modal) closeDetailModal();
    };
</script>
@endsection
