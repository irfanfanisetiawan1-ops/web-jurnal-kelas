@extends('layouts.guru')

@section('title', 'Jurnal Mengajar — Guru Piket')
@section('header_title', 'Jurnal Mengajar')

@section('styles')
<style>
    /* Root Page Layout */
    .jurnal-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }

    /* 1. Welcome Greeting Header Banner */
    .welcome-greeting-card {
        background: linear-gradient(135deg, #eef6ff 0%, #f0f4ff 50%, #f6f8fe 100%);
        border: 1px solid rgba(219, 234, 254, 0.9);
        border-radius: 18px;
        padding: 22px 28px;
        box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.04);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-greeting-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: 15%;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(191, 219, 254, 0.35) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .greeting-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .greeting-title-group p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .wave-hand {
        display: inline-block;
        animation: wave 2.2s infinite;
        transform-origin: 70% 70%;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        20%, 60% { transform: rotate(14deg); }
        40%, 80% { transform: rotate(-8deg); }
    }

    /* 2. 4 Stat Cards Grid */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        width: 100%;
    }

    .stat-metric-card {
        border-radius: 20px;
        padding: 16px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.06);
    }

    /* Card Themes */
    .card-theme-blue {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eff6ff 100%);
        border: 1px solid rgba(219, 234, 254, 0.7);
    }
    .icon-box-blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }
    .text-theme-blue {
        color: #2563eb;
    }
    .wave-theme-blue {
        color: #bfdbfe;
        opacity: 0.75;
    }

    .card-theme-emerald {
        background: linear-gradient(135deg, #ffffff 0%, #f9fdfa 50%, #f0fdf4 100%);
        border: 1px solid rgba(209, 250, 229, 0.7);
    }
    .icon-box-emerald {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    }
    .text-theme-emerald {
        color: #059669;
    }
    .wave-theme-emerald {
        color: #bbf7d0;
        opacity: 0.7;
    }

    .card-theme-amber {
        background: linear-gradient(135deg, #ffffff 0%, #fffcf7 50%, #fff7ed 100%);
        border: 1px solid rgba(255, 237, 213, 0.7);
    }
    .icon-box-amber {
        background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
    }
    .text-theme-amber {
        color: #ea580c;
    }
    .wave-theme-amber {
        color: #fed7aa;
        opacity: 0.7;
    }

    .card-theme-purple {
        background: linear-gradient(135deg, #ffffff 0%, #faf8ff 50%, #f5f3ff 100%);
        border: 1px solid rgba(237, 233, 254, 0.7);
    }
    .icon-box-purple {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    }
    .text-theme-purple {
        color: #7c3aed;
    }
    .wave-theme-purple {
        color: #ddd6fe;
        opacity: 0.75;
    }

    /* Icon Box */
    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    /* Info Content Stack */
    .stat-info {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
        position: relative;
        z-index: 2;
    }

    .stat-info-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .stat-info-value-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .stat-info-value {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .stat-info-unit {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-info-subtext {
        font-size: 10px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 3px;
        letter-spacing: -0.015em;
        line-height: 1.25;
    }

    /* Decorative Corner Elements */
    .stat-corner-elem {
        position: absolute;
        top: 13px;
        right: 14px;
        z-index: 2;
        pointer-events: none;
    }

    /* Decorative Bottom-Right Wave */
    .stat-card-wave {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 96px;
        height: 52px;
        pointer-events: none;
        z-index: 1;
    }

    /* 3. Main Data Panel */
    .main-data-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 22px 24px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
    }

    .main-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 20px;
    }

    .main-card-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .main-card-icon-badge {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .main-card-title-group h2 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .main-card-title-group p {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    .btn-action-export {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 11px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .btn-action-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Filter & Search Bar Form */
    .filter-section {
        margin-bottom: 22px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    .filter-row-top {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-row-bottom {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input-search-wrap {
        flex: 1.8;
        min-width: 240px;
        position: relative;
    }

    .filter-input-search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-input-search {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .filter-input-search:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-input-select-wrap {
        flex: 1.1;
        min-width: 150px;
        position: relative;
    }

    .filter-input-select-wrap i.select-icon-left {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }

    .filter-select {
        width: 100%;
        padding: 9px 28px 9px 34px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #334155;
        font-weight: 600;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 8px center;
        background-repeat: no-repeat;
        background-size: 16px 16px;
        transition: all 0.2s ease;
        box-sizing: border-box;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-date-input {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #334155;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .filter-date-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-filter-submit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-size: 12.5px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter-submit:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .btn-filter-reset {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter-reset:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    /* 4. Table Styling */
    .table-responsive-box {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
    }

    .table-jurnal-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
        min-width: 880px;
    }

    .table-jurnal-custom thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 10px;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }

    .table-jurnal-custom thead th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        border-left: 1px solid #e2e8f0;
    }

    .table-jurnal-custom thead th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-right: 1px solid #e2e8f0;
        text-align: center;
    }

    .table-jurnal-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-jurnal-custom tbody tr:hover {
        background-color: #fafbfd;
    }

    .table-jurnal-custom tbody td {
        padding: 11px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 12.5px;
    }

    /* Date Cell with Left Accent Colored Bar */
    .date-column-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        padding-left: 8px;
    }

    .date-accent-indicator {
        position: absolute;
        left: 0;
        top: 1px;
        bottom: 1px;
        width: 3.5px;
        border-radius: 4px;
    }

    .date-day-large {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .date-my-group {
        display: flex;
        flex-direction: column;
        font-size: 9px;
        font-weight: 800;
        color: #94a3b8;
        line-height: 1.1;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Pastel Mapel Badges */
    .mapel-pill-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
    }

    /* Status Badges */
    .status-badge-terlaksana {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 4px 11px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .status-badge-belum {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 4px 11px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    /* Table Action Buttons */
    .table-actions-cluster {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-icon-table-action {
        width: 29px;
        height: 29px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-icon-table-action:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    /* Table Footer & Pagination */
    .table-pagination-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-records-info {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .pagination-pills-list {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination-pill-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .pagination-pill-btn:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    .pagination-pill-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    /* Responsive Breakpoints */
    @media (max-width: 1200px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .welcome-greeting-card {
            padding: 18px 20px;
        }
        .greeting-title-group h1 {
            font-size: 20px;
        }
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
        .filter-row-top, .filter-row-bottom {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-input-search-wrap,
        .filter-input-select-wrap,
        .btn-filter-submit,
        .btn-filter-reset {
            width: 100%;
            min-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="jurnal-page-wrapper">

    <!-- 1. Top Welcome Greeting Header Banner -->
    <div class="welcome-greeting-card">
        <div class="greeting-title-group">
            <h1>
                <span>Halo, {{ Auth::user()->name ?? 'Petugas Piket' }}!</span>
                <span class="wave-hand">👋</span>
            </h1>
            <p>Pantau dan kelola seluruh aktivitas jurnal mengajar di sini.</p>
        </div>
    </div>

    <!-- 2. 4 Stat Cards Metric Overview -->
    <div class="stat-cards-grid">
        <!-- Card 1: Total Pertemuan -->
        <div class="stat-metric-card card-theme-blue">
            <div class="stat-icon-box icon-box-blue">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3.5" y="5.5" width="21" height="18.5" rx="5" stroke="#2563eb" stroke-width="2.3"/>
                    <path d="M3.5 11.5H24.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                    <path d="M8.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                    <path d="M19.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-blue">Total Pertemuan</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['totalPertemuan'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext">Seluruh pertemuan pada periode ini</span>
            </div>
            <!-- Loop Doodle -->
            <div class="stat-corner-elem">
                <svg width="34" height="22" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 18 C 10 18, 16 10, 20 6 C 24 2, 28 4, 28 8 C 28 13, 23 16, 18 14 C 15 12, 16 7, 21 5 C 26 3, 31 8, 33 11" stroke="#60a5fa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" opacity="0.85"/>
                </svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 2: Terlaksana -->
        <div class="stat-metric-card card-theme-emerald">
            <div class="stat-icon-box icon-box-emerald">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="10.5" stroke="#059669" stroke-width="2.3"/>
                    <path d="M9.5 14L12.5 17L18.5 11" stroke="#059669" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-emerald">Terlaksana</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['terlaksana'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext">Seluruh pertemuan pada periode ini</span>
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #34d399;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 3: Belum Terlaksana -->
        <div class="stat-metric-card card-theme-amber">
            <div class="stat-icon-box icon-box-amber">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="10.5" stroke="#ea580c" stroke-width="2.3"/>
                    <path d="M14 8.5V14H18" stroke="#ea580c" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-amber">Belum Terlaksana</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['belumTerlaksana'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext"><strong style="color: #ea580c; font-weight: 700;">{{ $stats['pctBelum'] }}%</strong> dari total pertemuan</span>
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #fb923c;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-amber" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 4: Guru Aktif -->
        <div class="stat-metric-card card-theme-purple">
            <div class="stat-icon-box icon-box-purple">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="9.5" r="4.5" stroke="#7c3aed" stroke-width="2.3"/>
                    <path d="M6 22C6 18.134 9.58172 15 14 15C18.4183 15 22 18.134 22 22" stroke="#7c3aed" stroke-width="2.3" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-purple">Guru Aktif</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['guruAktif'] }}</span>
                    <span class="stat-info-unit">Guru</span>
                </div>
                <span class="stat-info-subtext">Mengajar pada periode ini</span>
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #a78bfa;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>
    </div>

    <!-- 3. Main Data Panel (Daftar Jurnal Mengajar) -->
    <div class="main-data-card">
        <!-- Panel Header -->
        <div class="main-card-header">
            <div class="main-card-title-group">
                <div class="main-card-icon-badge">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div>
                    <h2>Daftar Jurnal Mengajar</h2>
                    <p>Berikut adalah daftar kegiatan mengajar pada periode yang dipilih.</p>
                </div>
            </div>

            <a href="{{ route('piket.jurnal-mengajar.export', request()->query()) }}" class="btn-action-export" title="Ekspor data ke CSV">
                <i class="fa-solid fa-download"></i>
                <span>Export</span>
            </a>
        </div>

        <!-- Search & Filter Form Bar -->
        <form action="{{ route('piket.jurnal-mengajar') }}" method="GET" class="filter-section">
            <!-- Row 1: Search, Date, Guru, Kelas -->
            <div class="filter-row-top">
                <div class="filter-input-search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $search }}" class="filter-input-search" placeholder="Cari Mata Pelajaran / Guru / Kelas...">
                </div>

                <div class="filter-input-select-wrap" style="flex: 1; min-width: 140px;">
                    <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="filter-date-input" title="Filter Tanggal Mulai">
                </div>

                <div class="filter-input-select-wrap">
                    <i class="fa-solid fa-user-tie select-icon-left"></i>
                    <select name="id_guru" class="filter-select">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-input-select-wrap">
                    <i class="fa-solid fa-school select-icon-left"></i>
                    <select name="id_kelas" class="filter-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Mapel, Filter Submit & Reset -->
            <div class="filter-row-bottom">
                <div class="filter-input-select-wrap" style="flex: 0 0 220px; max-width: 260px;">
                    <i class="fa-solid fa-book select-icon-left"></i>
                    <select name="id_mapel" class="filter-select">
                        <option value="">Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-submit">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>

        <!-- 4. Table Jurnal Mengajar -->
        <div class="table-responsive-box">
            <table class="table-jurnal-custom">
                <thead>
                    <tr>
                        <th style="width: 85px;">TANGGAL <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 145px;">MATA PELAJARAN <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 75px;">KELAS <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 160px;">GURU <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th>MATERI <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 95px;">PERTEMUAN <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 130px;">STATUS <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 80px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Palet warna pastel untuk variasi per baris / mapel sesuai screenshot
                        $colorPalette = [
                            ['bar' => '#38bdf8', 'bg' => '#e0f2fe', 'text' => '#0284c7'], // Blue / Sky (Dasar TKI)
                            ['bar' => '#f472b6', 'bg' => '#fce7f3', 'text' => '#db2777'], // Pink (Bahasa Inggris)
                            ['bar' => '#4ade80', 'bg' => '#dcfce7', 'text' => '#16a34a'], // Green (Pendidikan Pancasila)
                            ['bar' => '#a78bfa', 'bg' => '#ede9fe', 'text' => '#7c3aed'], // Purple (Bahasa Indonesia)
                            ['bar' => '#fb923c', 'bg' => '#ffedd5', 'text' => '#ea580c'], // Orange (Informatika)
                        ];
                    @endphp

                    @forelse($jurnals as $index => $row)
                        @php
                            $tgl = !empty($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $row->tanggal_formatted_day ?? ($tgl ? $tgl->format('d') : sprintf('%02d', $index + 1));
                            
                            $monthOnly = $tgl ? strtoupper($tgl->format('M')) : 'AUG';
                            $yearOnly  = $tgl ? $tgl->format('Y') : '2026';
                            if (!empty($row->tanggal_formatted_month)) {
                                $parts = explode(' ', trim($row->tanggal_formatted_month));
                                $monthOnly = $parts[0] ?? 'AUG';
                                $yearOnly  = $parts[1] ?? '2026';
                            }

                            $mapelNama = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Mata Pelajaran');
                            $kelasNama = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'Kelas');
                            $guruNama  = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Mengajar');
                            $materi    = $row->materi ?? '-';
                            $pertemuan = $row->pertemuan_ke ?? '12 / 36';
                            $statusText = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Terlaksana');
                            $isTerlaksana = in_array(strtolower($statusText), ['terlaksana', 'hadir', 'terisi']);

                            // Tentukan warna aksen berdasarkan hash mapel agar konsisten
                            $themeIndex = abs(crc32($mapelNama)) % count($colorPalette);
                            $theme = $colorPalette[$themeIndex];
                        @endphp
                        <tr>
                            <!-- 1. TANGGAL dengan left accent colored bar -->
                            <td>
                                <div class="date-column-cell">
                                    <div class="date-accent-indicator" style="background-color: {{ $theme['bar'] }};"></div>
                                    <span class="date-day-large">{{ $dayStr }}</span>
                                    <div class="date-my-group">
                                        <span>{{ $monthOnly }}</span>
                                        <span>{{ $yearOnly }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- 2. MATA PELAJARAN dengan pastel pill badge -->
                            <td>
                                <span class="mapel-pill-badge" style="background-color: {{ $theme['bg'] }}; color: {{ $theme['text'] }};">
                                    {{ $mapelNama }}
                                </span>
                            </td>

                            <!-- 3. KELAS -->
                            <td>
                                <span style="font-weight: 600; color: #475569;">{{ $kelasNama }}</span>
                            </td>

                            <!-- 4. GURU -->
                            <td>
                                <span style="font-weight: 600; color: #1e293b;">{{ $guruNama }}</span>
                            </td>

                            <!-- 5. MATERI -->
                            <td>
                                <span style="color: #64748b; font-size: 12px; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;" title="{{ $materi }}">
                                    {{ $materi }}
                                </span>
                            </td>

                            <!-- 6. PERTEMUAN -->
                            <td>
                                <span style="font-weight: 600; color: #475569; font-size: 12px;">{{ $pertemuan }}</span>
                            </td>

                            <!-- 7. STATUS -->
                            <td>
                                @if($isTerlaksana)
                                    <span class="status-badge-terlaksana">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Terlaksana</span>
                                    </span>
                                @else
                                    <span class="status-badge-belum">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>Belum Terlaksana</span>
                                    </span>
                                @endif
                            </td>

                            <!-- 8. AKSI -->
                            <td style="text-align: center;">
                                <div class="table-actions-cluster">
                                    <button type="button" class="btn-icon-table-action" 
                                            onclick="openDetailModal('{{ $row->id_jurnal ?? $index }}', '{{ addslashes($guruNama) }}', '{{ addslashes($mapelNama) }}', '{{ addslashes($kelasNama) }}', '{{ addslashes($dayStr . ' ' . $monthOnly . ' ' . $yearOnly) }}', '{{ addslashes($materi) }}', '{{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}')" 
                                            title="Lihat Detail Jurnal">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-icon-table-action" 
                                            onclick="openDetailModal('{{ $row->id_jurnal ?? $index }}', '{{ addslashes($guruNama) }}', '{{ addslashes($mapelNama) }}', '{{ addslashes($kelasNama) }}', '{{ addslashes($dayStr . ' ' . $monthOnly . ' ' . $yearOnly) }}', '{{ addslashes($materi) }}', '{{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}')"
                                            title="Opsi Lainnya">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px 20px;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 32px; color: #cbd5e1;"></i>
                                    <span style="font-weight: 600; font-size: 13.5px;">Tidak ada data jurnal mengajar yang sesuai filter.</span>
                                    <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset" style="margin-top: 6px;">Reset Filter</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 5. Table Footer & Pagination -->
        <div class="table-pagination-footer">
            <div class="pagination-records-info">
                Menampilkan 1 - {{ min(count($jurnals), 10) }} dari {{ $stats['totalPertemuan'] ?? count($jurnals) }} data
            </div>

            <div class="pagination-pills-list">
                <a href="#" class="pagination-pill-btn" title="Halaman Pertama">&laquo;</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Sebelumnya">&lsaquo;</a>
                <a href="#" class="pagination-pill-btn active">1</a>
                <a href="#" class="pagination-pill-btn">2</a>
                <a href="#" class="pagination-pill-btn">3</a>
                <a href="#" class="pagination-pill-btn">4</a>
                <a href="#" class="pagination-pill-btn">5</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Berikutnya">&rsaquo;</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Terakhir">&raquo;</a>
            </div>
        </div>
    </div>

</div>

<!-- Modal Modern Detail Jurnal Mengajar -->
<div id="detailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(3px); z-index: 999; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; width: 100%; max-width: 520px; border-radius: 20px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Detail Jurnal Mengajar</h3>
                    <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Informasi aktivitas KBM guru pengajar</p>
                </div>
            </div>
            <button onclick="closeDetailModal()" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 16px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">&times;</button>
        </div>

        <!-- Modal Content Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 12.5px; margin-bottom: 16px;">
            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Guru Pengajar</span>
                <div id="modalGuru" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Mata Pelajaran</span>
                <div id="modalMapel" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Kelas</span>
                <div id="modalKelas" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Tanggal</span>
                <div id="modalTanggal" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 12px 14px; border-radius: 12px; border: 1px solid #f1f5f9; margin-bottom: 14px;">
            <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Materi Pembelajaran</span>
            <p id="modalMateri" style="margin: 4px 0 0 0; color: #334155; font-size: 13px; font-weight: 600; line-height: 1.5;">-</p>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #ecfdf5; border-radius: 12px; border: 1px solid #d1fae5; margin-bottom: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #065f46;">Status Pelaksanaan:</span>
            <span id="modalStatusBadge" class="status-badge-terlaksana">
                <i class="fa-solid fa-circle-check"></i>
                <span id="modalStatusText">Terlaksana</span>
            </span>
        </div>

        <!-- Modal Footer -->
        <div style="display: flex; justify-content: flex-end; gap: 8px;">
            <button onclick="closeDetailModal()" style="background: #2563eb; color: #ffffff; border: none; padding: 9px 20px; border-radius: 10px; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background 0.15s ease;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes modalPop {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    function openDetailModal(id, guru, mapel, kelas, tanggal, materi, status) {
        document.getElementById('modalGuru').textContent = guru || '-';
        document.getElementById('modalMapel').textContent = mapel || '-';
        document.getElementById('modalKelas').textContent = kelas || '-';
        document.getElementById('modalTanggal').textContent = tanggal || '-';
        document.getElementById('modalMateri').textContent = materi || '-';

        const statusBadge = document.getElementById('modalStatusBadge');
        const statusText = document.getElementById('modalStatusText');
        statusText.textContent = status;

        if (status === 'Terlaksana') {
            statusBadge.className = 'status-badge-terlaksana';
            statusBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>Terlaksana</span>';
        } else {
            statusBadge.className = 'status-badge-belum';
            statusBadge.innerHTML = '<i class="fa-regular fa-clock"></i> <span>Belum Terlaksana</span>';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Tutup modal jika klik di luar box
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('detailModal');
        if (e.target === modal) {
            closeDetailModal();
        }
    });
</script>
@endsection
