@extends('layouts.guru')

@section('title', 'Jadwal Mengajar — EDU JOURNAL')
@section('header_title', 'Jadwal Mengajar Guru')

@section('styles')
<style>
    /* =========================================================
       PAGE LAYOUT & CONTAINER
       ========================================================= */
    .jadwal-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    /* 3-Column Info Cards Grid (Horizontal on Desktop, 1-Col Stack on Mobile) */
    .stats-cards-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
        align-items: stretch;
    }

    @media (max-width: 1024px) {
        .stats-cards-row {
            grid-template-columns: 1fr;
        }
    }


    /* =========================================================
       UNIFIED MASTER HEADER CARD
       (Combines Title, Actions, Day Tabs, and Search/Filter)
       ========================================================= */
    .jadwal-master-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 55%, #f0f7ff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        overflow: hidden;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    /* Section 1: Top Toolbar (Global Actions & Wali Context Switcher) */
    .master-header-top {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.6);
    }

    .jadwal-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Toolbar Action Buttons */
    .btn-toolbar-modern {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 15px;
        border-radius: 12px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .btn-toolbar-modern:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-toolbar-modern.active,
    .btn-toolbar-modern.btn-primary {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-toolbar-modern.active:hover,
    .btn-toolbar-modern.btn-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    /* Section 1.5: Dual Context Switcher (Wali Kelas) */
    .master-header-context {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .context-pill-container {
        display: inline-flex;
        align-items: center;
        background: #e2e8f0;
        padding: 3px;
        border-radius: 12px;
        gap: 3px;
        max-width: fit-content;
    }

    .context-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 16px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .context-pill-btn:hover {
        color: #0f172a;
    }

    .context-pill-btn.active {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
    }

    /* Section 2: Day Segmented Pill Navigation */
    .master-header-days {
        padding: 12px 24px;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        background: rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .segmented-days-track {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 14px;
        gap: 4px;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .segmented-days-track::-webkit-scrollbar {
        display: none;
    }

    .segmented-day-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        position: relative;
    }

    .segmented-day-item:hover:not(.active) {
        color: #0f172a;
        background: rgba(255, 255, 255, 0.6);
    }

    .segmented-day-item.active {
        background: #ffffff;
        color: #0f172a;
        font-weight: 800;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }

    .day-badge-num {
        font-size: 11px;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 6px;
        border-radius: 6px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .segmented-day-item.active .day-badge-num {
        background: #eff6ff;
        color: #2563eb;
    }

    /* Subtle indicator dot for "Hari Ini" */
    .today-indicator-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
        flex-shrink: 0;
    }

    .days-active-indicator {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    /* Section 3: Filter & Search Toolbar */
    .master-header-filter {
        padding: 14px 24px;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        background: rgba(255, 255, 255, 0.75);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .search-filter-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        max-width: 520px;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .input-search-jadwal {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        background: #f8fafc;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
    }

    .input-search-jadwal:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .select-status-filter {
        padding: 9px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        color: #334155;
        background: #f8fafc;
        font-weight: 600;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .select-status-filter:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Integrated Sleek Counter Badge */
    .header-counter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(37, 99, 235, 0.05);
        border: 1px solid rgba(191, 219, 254, 0.7);
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12px;
        color: #1e40af;
        font-weight: 600;
        white-space: nowrap;
    }


    /* =========================================================
       URGENT 5-MINUTE WARNING BANNER
       ========================================================= */
    .urgent-banner-card {
        background: linear-gradient(135deg, #ffffff 0%, #fff1f2 50%, #ffe4e6 100%);
        border: 1px solid rgba(254, 205, 211, 0.85);
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 4px 18px rgba(225, 29, 72, 0.08);
        position: relative;
        overflow: hidden;
    }

    .urgent-banner-left {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 2;
    }

    .urgent-banner-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
        animation: pulseWarning 1.8s infinite;
    }

    @keyframes pulseWarning {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.4); }
        70% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(225, 29, 72, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0); }
    }

    .urgent-banner-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #9f1239;
    }

    .urgent-banner-desc {
        font-size: 12.5px;
        color: #be123c;
        margin-top: 2px;
        line-height: 1.35;
    }

    .btn-urgent-fill {
        background: #e11d48;
        color: #ffffff;
        font-weight: 800;
        padding: 9px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 12.5px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        position: relative;
        z-index: 2;
    }

    .btn-urgent-fill:hover {
        background: #be123c;
        transform: translateY(-1px);
    }

    /* =========================================================
       SCHEDULE TABLE CARD & ROWS
       (SOFT STYLING: NO HARSH RED ON WAKTU HABIS!)
       ========================================================= */
    .card-jadwal-table {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #f1f5f9;
        padding: 16px 20px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
    }

    .table-schedule {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 8px 16px;
        text-align: left;
        letter-spacing: 0.6px;
        border: none;
    }

    .table-schedule tr.row-jadwal {
        background: #ffffff;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f1f5f9;
    }

    .table-schedule tr.row-jadwal:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }

    .table-schedule tr.row-jadwal td {
        padding: 14px 16px;
        font-size: 13px;
        vertical-align: middle;
        background: inherit;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-schedule tr.row-jadwal td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        border-left: 1px solid #f1f5f9;
    }

    .table-schedule tr.row-jadwal td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
        border-right: 1px solid #f1f5f9;
    }

    /* Soft status indicators via border-left accent (Clean White Background) */
    .row-selesai td:first-child {
        border-left: 4px solid #10b981 !important;
    }
    .row-berlangsung td:first-child {
        border-left: 4px solid #2563eb !important;
    }
    /* "Waktu Habis" row: SOFT WHITE BACKGROUND with gentle rose accent */
    .row-belum td:first-child {
        border-left: 4px solid #fb7185 !important;
    }
    .row-future td:first-child {
        border-left: 4px solid #cbd5e1 !important;
    }
    .row-guru-pengganti td:first-child {
        border-left: 4px solid #a855f7 !important;
    }

    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }

    .badge-status-selesai {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .badge-status-berlangsung { 
        background: #eff6ff; 
        color: #2563eb; 
        border: 1px solid #bfdbfe;
    }

    .badge-status-urgent {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        animation: pulseWarning 1.8s infinite;
    }

    /* Soft rose badge for "Waktu Habis" */
    .badge-status-belum { 
        background: #fff1f2; 
        color: #be123c; 
        border: 1px solid #fecdd3; 
    }

    .badge-status-future { 
        background: #f1f5f9; 
        color: #64748b; 
        border: 1px solid #e2e8f0; 
    }

    .badge-status-pengganti { 
        background: #faf5ff; 
        color: #7c3aed; 
        border: 1px solid #e9d5ff; 
    }

    /* Action Buttons in Rows */
    .btn-action-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-jurnal-isi { 
        background: #2563eb; 
        color: #ffffff; 
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }
    .btn-jurnal-isi:hover { 
        background: #1d4ed8; 
        transform: translateY(-1px);
    }

    .btn-jurnal-terisi { 
        background: #ffffff; 
        color: #059669; 
        border: 1px solid #a7f3d0; 
    }
    .btn-jurnal-terisi:hover { 
        background: #ecfdf5; 
        border-color: #6ee7b7;
    }

    .btn-jurnal-locked { 
        background: #f1f5f9; 
        color: #94a3b8; 
        border: 1px solid #e2e8f0; 
        cursor: not-allowed; 
        opacity: 0.85;
    }

    .btn-modal-detail {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-modal-detail:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    /* =========================================================
       MATRIKS TIMETABLE GRID (aSc TIMETABLES STYLE)
       ========================================================= */
    .matrix-timetable {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .matrix-timetable th, .matrix-timetable td {
        border: 1px solid #e2e8f0;
        padding: 8px;
        vertical-align: top;
    }

    .matrix-timetable th {
        background: #f8fafc;
        font-weight: 800;
        text-align: center;
        color: #1e293b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .matrix-cell-card {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 3px solid #2563eb;
        border-radius: 8px;
        padding: 7px 9px;
        margin-bottom: 5px;
        font-size: 11.5px;
        line-height: 1.35;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .matrix-cell-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.1);
    }

    /* =========================================================
       SIDEBAR GRADIENT CARDS (MATCHING PENGUMUMAN STYLE)
       (NO ARROW CHEVRONS, SOLID CIRCLE ICONS, WAVE & SPARKLES)
       ========================================================= */
    .sidebar-widget-gradient {
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }


    .sidebar-widget-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(15, 23, 42, 0.06);
    }

    /* Theme Purple */
    .card-theme-purple {
        background: linear-gradient(135deg, #ffffff 0%, #faf5ff 50%, #f3e8ff 100%);
        border: 1px solid rgba(216, 180, 254, 0.75);
    }
    .text-purple-600 { color: #7c3aed; }
    .wave-purple { color: #d8b4fe; opacity: 0.55; }

    /* Theme Blue */
    .card-theme-blue {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 50%, #e0f2fe 100%);
        border: 1px solid rgba(186, 230, 253, 0.75);
    }
    .text-blue-600 { color: #2563eb; }
    .wave-blue { color: #bae6fd; opacity: 0.55; }

    /* Theme Emerald */
    .card-theme-emerald {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #dcfce7 100%);
        border: 1px solid rgba(187, 247, 208, 0.75);
    }
    .text-emerald-600 { color: #059669; }
    .wave-emerald { color: #bbf7d0; opacity: 0.55; }

    /* Circular Solid Colored Icon Box */
    .stat-circle-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .icon-solid-purple {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.28);
    }

    .icon-solid-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
    }

    .icon-solid-emerald {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.28);
    }

    /* Decorative Corner Elements (Sparkles) */
    .stat-corner-elem {
        position: absolute;
        top: 14px;
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
        width: 110px;
        height: 55px;
        pointer-events: none;
        z-index: 1;
    }

    .widget-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        position: relative;
        z-index: 2;
    }

    .widget-header-title-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .widget-title-text {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .widget-subtitle-text {
        font-size: 11.5px;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .widget-actions-dual {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    /* Mini Bar Chart Sebaran JP */
    .mini-chart-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 6px;
        align-items: flex-end;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(4px);
        padding: 8px 6px 6px 6px;
        border-radius: 12px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        margin-top: 6px;
        position: relative;
        z-index: 2;
    }

    .mini-chart-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .mini-chart-col:hover {
        transform: translateY(-2px);
    }

    .mini-bar-track {
        width: 100%;
        max-width: 22px;
        height: 36px;
        background: #f1f5f9;
        border-radius: 5px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .mini-bar-fill {
        width: 100%;
        border-radius: 6px 6px 0 0;
        transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mini-chart-day {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
    }

    .mini-chart-jp {
        font-size: 11px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 1px;
    }

    /* =========================================================
       MODALS (DETAIL JADWAL & DETAIL JURNAL)
       ========================================================= */
    .custom-modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(5px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .custom-modal-box {
        background: #ffffff;
        border-radius: 22px;
        width: 100%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        border: 1px solid #e2e8f0;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        0% { opacity: 0; transform: scale(0.96) translateY(6px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-header-styled {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body-styled {
        padding: 22px 24px;
    }

    .modal-footer-styled {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        border-radius: 0 0 22px 22px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="jadwal-page-wrapper">

    <!-- 1. Master Toolbar & Filter Card (Actions, Days, and Search/Filter) -->
    <div class="jadwal-master-header-card">

        <!-- Top Toolbar: Mode Switcher (Wali Kelas) & Global Action Buttons -->
        <div class="master-header-top">
            @if(isset($isWaliKelas) && $isWaliKelas && !empty($kelasWali))
                <div class="master-header-context">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Mode:</span>
                    <div class="context-pill-container">
                        <a href="{{ route('guru.jadwal', ['tab' => 'saya', 'hari' => $hariFilter, 'tampilan' => $viewMode]) }}" class="context-pill-btn {{ $activeTab === 'saya' ? 'active' : '' }}">
                            <i class="fa-solid fa-chalkboard-user"></i> Jadwal Mengajar Saya
                        </a>
                        <a href="{{ route('guru.jadwal', ['tab' => 'perwalian', 'hari' => $hariFilter, 'tampilan' => $viewMode]) }}" class="context-pill-btn {{ $activeTab === 'perwalian' ? 'active' : '' }}">
                            <i class="fa-solid fa-graduation-cap"></i> Jadwal KBM Kelas Perwalian ({{ $kelasWali->nama_kelas }})
                        </a>
                    </div>
                </div>
            @endif

            <!-- Global Action Buttons -->
            <div class="jadwal-header-actions">
                <a href="{{ route('guru.jadwal.print', ['tab' => $activeTab]) }}" target="_blank" class="btn-toolbar-modern" title="Cetak Lembar Resmi Jadwal">
                    <i class="fa-solid fa-print" style="color: #2563eb;"></i> Cetak Jadwal
                </a>
                <a href="{{ route('guru.jadwal.export', ['tab' => $activeTab]) }}" class="btn-toolbar-modern" title="Ekspor ke format CSV/Excel">
                    <i class="fa-solid fa-file-excel" style="color: #10b981;"></i> Ekspor CSV
                </a>
                <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $hariFilter, 'tampilan' => ($viewMode === 'matriks' ? 'tabel' : 'matriks')]) }}" class="btn-toolbar-modern {{ $viewMode === 'matriks' ? 'active' : '' }}" title="Beralih Mode Tampilan">
                    <i class="fa-solid {{ $viewMode === 'matriks' ? 'fa-table-list' : 'fa-table-cells' }}"></i> {{ $viewMode === 'matriks' ? 'Tampilan Tabel' : 'Matriks Mingguan' }}
                </a>
            </div>
        </div>

        <!-- Middle Section: Day Segmented Pill Navigation -->
        <div class="master-header-days">
            <div class="segmented-days-track">
                <!-- Pill Semua Hari -->
                <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => 'semua', 'tampilan' => $viewMode]) }}" class="segmented-day-item {{ $hariFilter === 'semua' ? 'active' : '' }}" title="Tampilkan Semua Jadwal Mingguan">
                    <i class="fa-solid fa-calendar-week" style="font-size: 12px; color: {{ $hariFilter === 'semua' ? '#2563eb' : '#94a3b8' }};"></i>
                    <span>SEMUA</span>
                </a>

                @foreach($dayDates as $key => $d)
                    <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $key, 'tampilan' => $viewMode]) }}" class="segmented-day-item {{ $hariFilter === $key ? 'active' : '' }}" title="{{ $d['full'] }}">
                        <span>{{ $d['name'] }}</span>
                        <span class="day-badge-num">{{ $d['num'] }}</span>
                        @if(!empty($d['is_today']))
                            <span class="today-indicator-dot" title="Hari Ini"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="days-active-indicator">
                <i class="fa-regular fa-calendar-check" style="color: #2563eb;"></i>
                <span>
                    @if($hariFilter === 'semua')
                        Semua Hari KBM (Senin – Jumat)
                    @elseif(isset($dayDates[$hariFilter]))
                        Hari {{ $dayDates[$hariFilter]['day_name'] }}, {{ $dayDates[$hariFilter]['formatted'] }}
                        @if(!empty($dayDates[$hariFilter]['is_today']))
                            <span style="font-size: 10px; background: #ecfdf5; color: #059669; padding: 2px 7px; border-radius: 6px; font-weight: 800; border: 1px solid #a7f3d0; margin-left: 4px;">HARI INI</span>
                        @endif
                    @endif
                </span>
            </div>
        </div>

        <!-- Bottom Section: Filter & Search Toolbar -->
        <div class="master-header-filter">
            <form method="GET" action="{{ route('guru.jadwal') }}" class="search-filter-box">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <input type="hidden" name="hari" value="{{ $hariFilter }}">
                <input type="hidden" name="tampilan" value="{{ $viewMode }}">
                
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" id="inputSearchJadwal" value="{{ $searchQuery }}" class="input-search-jadwal" placeholder="Cari kelas, mata pelajaran, atau ruangan..." onkeyup="filterTableLive()">
                </div>
                
                <select name="status_kbm" id="selectStatusKbm" class="select-status-filter" onchange="this.form.submit()">
                    <option value="semua" {{ $statusFilter === 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>Selesai / Terisi</option>
                    <option value="berlangsung" {{ $statusFilter === 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="belum_mulai" {{ $statusFilter === 'belum_mulai' ? 'selected' : '' }}>Belum Dimulai</option>
                    <option value="terlewat" {{ $statusFilter === 'terlewat' ? 'selected' : '' }}>Belum Diisi / Terlewat</option>
                </select>
            </form>

            <div class="header-counter-badge">
                <i class="fa-solid fa-layer-group" style="color: #2563eb; font-size: 11px;"></i>
                <span>Menampilkan <strong>{{ $jadwals->count() }}</strong> Sesi KBM</span>
                <span style="color: #93c5fd;">&bull;</span>
                <span style="color: #3b82f6; font-weight: 500;">
                    @if($activeTab === 'perwalian')
                        Kelas {{ $kelasWali->nama_kelas ?? '-' }}
                    @else
                        {{ Auth::user()->name }}
                    @endif
                </span>
            </div>
        </div>

    </div>

    @php
        $userAuth = Auth::user();
        $currentGuruId = $userAuth ? ($userAuth->id_guru ?? (optional($userAuth->guru)->id_guru ?? null)) : null;
        if (!$currentGuruId && $userAuth && $userAuth->nip) {
            $findCurrentGuru = \App\Models\Guru::where('nip', $userAuth->nip)->first();
            if ($findCurrentGuru) {
                $currentGuruId = $findCurrentGuru->id_guru;
            }
        }

        // Peringatan 5 menit hanya aktif untuk jadwal mengajar yang diampu user login sendiri
        $urgentJadwal = $jadwals->first(function($j) use ($currentGuruId) {
            $isOwner = ($currentGuruId && $j->id_guru == $currentGuruId) || !empty($j->is_guru_pengganti);
            return $isOwner && $j->hampir_habis;
        });
    @endphp

    <!-- 5. Urgent 5-Minute Warning Banner -->
    @if($urgentJadwal)
        <div class="urgent-banner-card">
            <div class="urgent-banner-left">
                <div class="urgent-banner-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="urgent-banner-title">Peringatan 5 Menit Terakhir: Jam Pelajaran Segera Habis!</div>
                    <div class="urgent-banner-desc">
                        Jam pelajaran <strong>{{ $urgentJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $urgentJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong>{{ $urgentJadwal->sisa_menit_selesai }} menit lagi</strong> (berakhir pukul {{ $urgentJadwal->waktu_selesai_effective }} WIB) dan jurnal belum diisi. Segera isi jurnal sekarang sebelum waktu KBM habis dan fitur isi jurnal terkunci!
                    </div>
                </div>
            </div>
            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $urgentJadwal->id_jadwal]) }}" class="btn-urgent-fill">
                <i class="fa-solid fa-pen-to-square"></i> Isi Sekarang
            </a>
        </div>
    @endif

    <!-- 2. Ringkasan & Statistik KBM (3 Kartu Sejajar Horizontal) -->
    <div class="stats-cards-row">
        @if($activeTab === 'perwalian' && isset($isWaliKelas) && $isWaliKelas && !empty($kelasWali))
            <!-- ================= WIDGETS TAB PERWALIAN ================= -->
            
            <!-- Card 1: Progres Jurnal KBM Kelas Perwalian (Card Theme Purple) -->
            <div class="sidebar-widget-gradient card-theme-purple">
                <div>
                    <div class="widget-header-row">
                        <div class="widget-header-title-box">
                            <div class="stat-circle-icon icon-solid-purple">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div>
                                <h3 class="widget-title-text text-purple-600">Progres Jurnal Kelas</h3>
                                <p class="widget-subtitle-text">Kelas {{ $kelasWali->nama_kelas }}</p>
                            </div>
                        </div>
                        <span style="font-size: 11px; background: #ecfdf5; color: #059669; padding: 3px 10px; border-radius: 20px; font-weight: 800; border: 1px solid #a7f3d0; position: relative; z-index: 2;">
                            {{ $statsProgres['persen'] ?? 0 }}%
                        </span>
                    </div>

                    <!-- Sparkles & Wave -->
                    <div class="stat-corner-elem" style="color: #c084fc;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>

                    <div style="position: relative; z-index: 2; margin-top: 6px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">
                            <span>Status Terisi</span>
                            <span style="color: #0f172a;">{{ $statsProgres['terisi'] ?? 0 }} / {{ $statsProgres['total'] ?? 0 }} Sesi</span>
                        </div>
                        <div style="width: 100%; height: 7px; background: rgba(241, 245, 249, 0.8); border-radius: 6px; overflow: hidden; margin-bottom: 12px; border: 1px solid rgba(226, 232, 240, 0.8);">
                            <div style="width: {{ $statsProgres['persen'] ?? 0 }}%; height: 100%; background: linear-gradient(90deg, #8b5cf6, #3b82f6); border-radius: 6px; transition: width 0.4s ease;"></div>
                        </div>
                    </div>
                </div>

                <!-- Shortcut Action Buttons Khusus Wali Kelas (Side-by-side) -->
                <div class="widget-actions-dual" style="position: relative; z-index: 2; margin-top: 4px;">
                    <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; justify-content: center; padding: 8px 6px; border-radius: 9px; font-weight: 800; font-size: 11.5px; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-users-viewfinder"></i> Presensi Kelas
                    </a>
                    <a href="{{ route('guru.surat-izin.trash') }}" class="btn-action-jurnal" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; justify-content: center; padding: 8px 6px; border-radius: 9px; font-weight: 700; font-size: 11.5px;">
                        <i class="fa-solid fa-envelope-open-text" style="color: #2563eb;"></i> Surat Izin
                    </a>
                </div>
            </div>

            <!-- Card 2: Beban Mengajar Pribadi Guru (Card Theme Blue) -->
            <div class="sidebar-widget-gradient card-theme-blue">
                <div>
                    <div class="widget-header-row">
                        <div class="widget-header-title-box">
                            <div class="stat-circle-icon icon-solid-blue">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <div>
                                <h3 class="widget-title-text text-blue-600">Beban Mengajar</h3>
                                <p class="widget-subtitle-text">Total Jam Mengajar</p>
                            </div>
                        </div>
                        <span style="font-size: 11px; background: #eff6ff; color: #2563eb; padding: 3px 10px; border-radius: 20px; font-weight: 800; border: 1px solid #bfdbfe; position: relative; z-index: 2;">
                            {{ $statsBeban['totalJpSeminggu'] ?? 0 }} JP / MINGGU
                        </span>
                    </div>

                    <!-- Sparkles & Wave -->
                    <div class="stat-corner-elem" style="color: #60a5fa;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>

                    <div style="position: relative; z-index: 2; margin-top: 6px;">
                        <div style="background: rgba(255, 255, 255, 0.85); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 10px; padding: 6px 10px; margin-bottom: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; text-align: center;">
                            <div style="border-right: 1px solid #e2e8f0;">
                                <div style="font-size: 9.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Jam Hari Ini</div>
                                <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 1px;">{{ $statsBeban['totalJpHariIni'] ?? 0 }} JP</div>
                            </div>
                            <div>
                                <div style="font-size: 9.5px; color: #059669; font-weight: 700; text-transform: uppercase;">JP Terlaksana</div>
                                <div style="font-size: 16px; font-weight: 800; color: #059669; margin-top: 1px;">{{ $statsBeban['totalJpTerisiHariIni'] ?? 0 }} JP</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('guru.jadwal', ['tab' => 'saya']) }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 8px; border-radius: 9px; font-weight: 700; font-size: 11.5px; position: relative; z-index: 2;">
                    <i class="fa-solid fa-chalkboard-user"></i> Beralih ke Jadwal Saya
                </a>
            </div>

            <!-- Card 3: Status Kehadiran Siswa Perwalian Hari Ini (Card Theme Emerald) -->
            @if(!empty($dataWaliKelas))
                <div class="sidebar-widget-gradient card-theme-emerald">
                    <div>
                        <div class="widget-header-row">
                            <div class="widget-header-title-box">
                                <div class="stat-circle-icon icon-solid-emerald">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                </div>
                                <div>
                                    <h3 class="widget-title-text text-emerald-600">Presensi Siswa</h3>
                                    <p class="widget-subtitle-text">{{ $dataWaliKelas['hariNama'] ?? 'Hari Ini' }} &bull; {{ $dataWaliKelas['kelas']->nama_kelas }}</p>
                                </div>
                            </div>
                            <span style="font-size: 10px; background: #ecfdf5; color: #059669; padding: 3px 8px; border-radius: 6px; font-weight: 800; border: 1px solid #a7f3d0; position: relative; z-index: 2;">
                                KELAS {{ $dataWaliKelas['kelas']->nama_kelas }}
                            </span>
                        </div>

                        <!-- Sparkles & Wave -->
                        <div class="stat-corner-elem" style="color: #34d399;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                        </svg>

                        <div style="position: relative; z-index: 2; margin-top: 6px;">
                            <!-- 4 Grid Badge Hadir / Sakit / Izin / Alpa -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 8px;">
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                    <div style="font-size: 9px; font-weight: 800; color: #166534;">HADIR</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #15803d;">{{ $dataWaliKelas['totalHadir'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                    <div style="font-size: 9px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #a16207;">{{ $dataWaliKelas['rekapAbsensi']['sakit'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                    <div style="font-size: 9px; font-weight: 800; color: #075985;">IZIN</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0369a1;">{{ $dataWaliKelas['rekapAbsensi']['izin'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                    <div style="font-size: 9px; font-weight: 800; color: #991b1b;">ALPA</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #b91c1c;">{{ $dataWaliKelas['rekapAbsensi']['alpa'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-action-jurnal" style="background: #ffffff; color: #059669; border: 1px solid #a7f3d0; width: 100%; justify-content: center; padding: 8px; border-radius: 9px; font-weight: 700; font-size: 11.5px; position: relative; z-index: 2;">
                        <i class="fa-solid fa-clipboard-user"></i> Lihat Detail Presensi
                    </a>
                </div>
            @endif

        @else
            <!-- ================= WIDGETS TAB JADWAL SAYA ================= -->
            
            <!-- Card 1: Progres Jurnal Mengajar Saya (Card Theme Purple) -->
            <div class="sidebar-widget-gradient card-theme-purple">
                <div>
                    <div class="widget-header-row">
                        <div class="widget-header-title-box">
                            <div class="stat-circle-icon icon-solid-purple">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div>
                                <h3 class="widget-title-text text-purple-600">Progres Jurnal Saya</h3>
                                <p class="widget-subtitle-text">
                                    {{ $hariFilter === 'semua' ? 'Mingguan' : ($dayDates[$hariFilter]['day_name'] ?? ucfirst($hariFilter)) }}
                                </p>
                            </div>
                        </div>
                        <span style="font-size: 11px; background: #ecfdf5; color: #059669; padding: 3px 10px; border-radius: 20px; font-weight: 800; border: 1px solid #a7f3d0; position: relative; z-index: 2;">
                            {{ $statsProgres['persen'] ?? 0 }}%
                        </span>
                    </div>

                    <!-- Sparkles & Wave -->
                    <div class="stat-corner-elem" style="color: #c084fc;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>

                    <div style="position: relative; z-index: 2; margin-top: 6px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">
                            <span>Status Terisi</span>
                            <span style="color: #0f172a;">{{ $statsProgres['terisi'] ?? 0 }} / {{ $statsProgres['total'] ?? 0 }} Kelas</span>
                        </div>
                        <div style="width: 100%; height: 7px; background: rgba(241, 245, 249, 0.8); border-radius: 6px; overflow: hidden; margin-bottom: 12px; border: 1px solid rgba(226, 232, 240, 0.8);">
                            <div style="width: {{ $statsProgres['persen'] ?? 0 }}%; height: 100%; background: linear-gradient(90deg, #8b5cf6, #3b82f6); border-radius: 6px; transition: width 0.4s ease;"></div>
                        </div>
                    </div>
                </div>

                <!-- Shortcut Action Buttons (Side-by-side) -->
                <div class="widget-actions-dual" style="position: relative; z-index: 2; margin-top: 4px;">
                    <a href="{{ route('guru.jurnal-harian') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; justify-content: center; padding: 8px 6px; border-radius: 9px; font-weight: 800; font-size: 11.5px; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal
                    </a>
                    <a href="{{ route('guru.absensi-siswa') }}" class="btn-action-jurnal" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; justify-content: center; padding: 8px 6px; border-radius: 9px; font-weight: 700; font-size: 11.5px;">
                        <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi
                    </a>
                </div>
            </div>

            <!-- Card 2: Beban Mengajar & Mini Bar Chart (Card Theme Blue) -->
            <div class="sidebar-widget-gradient card-theme-blue">
                <div>
                    <div class="widget-header-row">
                        <div class="widget-header-title-box">
                            <div class="stat-circle-icon icon-solid-blue">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <div>
                                <h3 class="widget-title-text text-blue-600">Beban Mengajar</h3>
                                <p class="widget-subtitle-text">Distribusi JP Mingguan</p>
                            </div>
                        </div>
                        <span style="font-size: 11px; background: #eff6ff; color: #2563eb; padding: 3px 10px; border-radius: 20px; font-weight: 800; border: 1px solid #bfdbfe; position: relative; z-index: 2;">
                            {{ $statsBeban['totalJpSeminggu'] ?? 0 }} JP / MGG
                        </span>
                    </div>

                    <!-- Sparkles & Wave -->
                    <div class="stat-corner-elem" style="color: #60a5fa;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>

                    <div style="position: relative; z-index: 2; margin-top: 4px;">
                        <!-- Ringkasan Jam Hari Ini vs Terlaksana -->
                        <div style="background: rgba(255, 255, 255, 0.85); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 10px; padding: 6px 10px; margin-bottom: 6px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; text-align: center;">
                            <div style="border-right: 1px solid #e2e8f0;">
                                <div style="font-size: 9px; color: #64748b; font-weight: 700; text-transform: uppercase;">Hari Ini</div>
                                <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 1px;">{{ $statsBeban['totalJpHariIni'] ?? 0 }} <span style="font-size: 9.5px; font-weight: 600; color: #64748b;">JP</span></div>
                            </div>
                            <div>
                                <div style="font-size: 9px; color: #059669; font-weight: 700; text-transform: uppercase;">Terlaksana</div>
                                <div style="font-size: 15px; font-weight: 800; color: #059669; margin-top: 1px;">{{ $statsBeban['totalJpTerisiHariIni'] ?? 0 }} <span style="font-size: 9.5px; font-weight: 600; color: #059669;">JP</span></div>
                            </div>
                        </div>

                        <!-- Mini Bar Chart Sebaran JP Mingguan -->
                        @php
                            $daysMap = ['senin' => 'SEN', 'selasa' => 'SEL', 'rabu' => 'RAB', 'kamis' => 'KAM', 'jumat' => 'JUM'];
                            $maxJpInWeek = max(array_values($statsBeban['jpHarian'] ?? [0]));
                            if ($maxJpInWeek <= 0) $maxJpInWeek = 8;
                        @endphp

                        <div class="mini-chart-container">
                            @foreach($daysMap as $hKey => $hShort)
                                @php
                                    $jpVal = $statsBeban['jpHarian'][$hKey] ?? 0;
                                    $isCurrent = strtolower($hariFilter) === $hKey;
                                    $barPercent = $jpVal > 0 ? max(round(($jpVal / $maxJpInWeek) * 100), 18) : 6;
                                @endphp
                                <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $hKey, 'tampilan' => $viewMode]) }}" class="mini-chart-col" title="{{ ucfirst($hKey) }}: {{ $jpVal }} JP (Klik untuk filter)">
                                    <div class="mini-bar-track">
                                        <div class="mini-bar-fill" style="height: {{ $barPercent }}%; background: {{ $isCurrent ? '#1e293b' : ($jpVal > 0 ? 'linear-gradient(180deg, #3b82f6, #2563eb)' : '#cbd5e1') }};"></div>
                                    </div>
                                    <span class="mini-chart-day" style="{{ $isCurrent ? 'color: #2563eb; font-weight: 900;' : '' }}">{{ $hShort }}</span>
                                    <span class="mini-chart-jp" style="{{ $isCurrent ? 'color: #2563eb;' : '' }}">{{ $jpVal }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Kontekstual Role (Wali Kelas / Guru Mengajar) (Card Theme Emerald) -->
            @if(isset($isWaliKelas) && $isWaliKelas && !empty($dataWaliKelas))
                <!-- Card Khusus Role Wali Kelas -->
                <div class="sidebar-widget-gradient card-theme-emerald">
                    <div>
                        <div class="widget-header-row">
                            <div class="widget-header-title-box">
                                <div class="stat-circle-icon icon-solid-emerald">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <h3 class="widget-title-text text-emerald-600">Kelas Perwalian</h3>
                                    <p class="widget-subtitle-text">Wali Kelas {{ $dataWaliKelas['kelas']->nama_kelas ?? '' }}</p>
                                </div>
                            </div>
                            <span style="font-size: 10px; background: #ecfdf5; color: #059669; padding: 3px 8px; border-radius: 6px; font-weight: 800; border: 1px solid #a7f3d0; position: relative; z-index: 2;">
                                WALI KELAS
                            </span>
                        </div>

                        <!-- Sparkles & Wave -->
                        <div class="stat-corner-elem" style="color: #34d399;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                        </svg>

                        <div style="position: relative; z-index: 2; margin-top: 6px;">
                            <!-- Status Kehadiran Kelas Wali Hari Ini -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 8px;">
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                    <div style="font-size: 9px; font-weight: 800; color: #166534;">HADIR</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #15803d;">{{ $dataWaliKelas['totalHadir'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                    <div style="font-size: 9px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #a16207;">{{ $dataWaliKelas['rekapAbsensi']['sakit'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                    <div style="font-size: 9px; font-weight: 800; color: #075985;">IZIN</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0369a1;">{{ $dataWaliKelas['rekapAbsensi']['izin'] ?? 0 }}</div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); padding: 5px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                    <div style="font-size: 9px; font-weight: 800; color: #991b1b;">ALPA</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #b91c1c;">{{ $dataWaliKelas['rekapAbsensi']['alpa'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('guru.jadwal', ['tab' => 'perwalian']) }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 8px; border-radius: 9px; font-weight: 700; font-size: 11.5px; position: relative; z-index: 2;">
                        <i class="fa-solid fa-graduation-cap"></i> Pantau Jadwal Perwalian
                    </a>
                </div>
            @else
                <!-- Card Ringkasan Kelas Ampuhan (Guru Mengajar Regular) -->
                <div class="sidebar-widget-gradient card-theme-emerald">
                    <div>
                        <div class="widget-header-row">
                            <div class="widget-header-title-box">
                                <div class="stat-circle-icon icon-solid-emerald">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div>
                                    <h3 class="widget-title-text text-emerald-600">Ringkasan Mengajar</h3>
                                    <p class="widget-subtitle-text">Tahun Ajaran Aktif</p>
                                </div>
                            </div>
                            <span style="font-size: 10px; background: #ecfdf5; color: #059669; padding: 3px 8px; border-radius: 6px; font-weight: 800; border: 1px solid #a7f3d0; position: relative; z-index: 2;">
                                GURU
                            </span>
                        </div>

                        <!-- Sparkles & Wave -->
                        <div class="stat-corner-elem" style="color: #34d399;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                        </svg>

                        <div style="position: relative; z-index: 2; margin-top: 6px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
                                <div style="background: rgba(255, 255, 255, 0.85); border: 1px solid rgba(226, 232, 240, 0.8); padding: 8px; border-radius: 10px; text-align: center;">
                                    <div style="font-size: 9.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Kelas</div>
                                    <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 1px;">{{ $statsBeban['totalKelasDiajar'] ?? 0 }} <span style="font-size: 10px; font-weight: 600; color: #64748b;">Kelas</span></div>
                                </div>
                                <div style="background: rgba(255, 255, 255, 0.85); border: 1px solid rgba(226, 232, 240, 0.8); padding: 8px; border-radius: 10px; text-align: center;">
                                    <div style="font-size: 9.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Mata Pelajaran</div>
                                    <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 1px;">{{ $statsBeban['totalMapelDiajar'] ?? 0 }} <span style="font-size: 10px; font-weight: 600; color: #64748b;">Mapel</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-action-jurnal" style="background: #ffffff; color: #059669; border: 1px solid #a7f3d0; width: 100%; justify-content: center; padding: 8px; border-radius: 9px; font-weight: 700; font-size: 11.5px; position: relative; z-index: 2;">
                        <i class="fa-solid fa-book-open"></i> Lihat Riwayat Jurnal
                    </a>
                </div>
            @endif
        @endif
    </div>

    <!-- 3. Schedule Data (Full-Width Table or Matrix Grid) -->
    @if($viewMode === 'matriks')

                <!-- Mode Tampilan Matriks Mingguan (Timetable aSc Style) -->
                <div class="card-jadwal-table">
                    <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-table-cells" style="color: #2563eb;"></i> Matriks Jadwal Mingguan
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                            Format Matriks Mingguan SMKN 1 Boyolangu
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="matrix-timetable">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Jam Ke</th>
                                    <th style="width: 95px;">Senin–Kamis</th>
                                    <th style="width: 85px;">Jumat</th>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayCol)
                                        <th style="min-width: 140px;">{{ $dayCol }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($masterJamList as $jam)
                                    <tr>
                                        <td style="text-align: center; font-weight: 800; background: #f8fafc; color: #0f172a;">
                                            {{ $jam->jam_ke }}
                                        </td>
                                        <td style="text-align: center; font-size: 11px; color: #475569; background: #f8fafc;">
                                            {{ $jam->jam_mulai ? substr($jam->jam_mulai, 0, 5) . ' - ' . substr($jam->jam_selesai, 0, 5) : '-' }}
                                        </td>
                                        <td style="text-align: center; font-size: 11px; color: #475569; background: #f8fafc;">
                                            {{ $jam->jam_mulai_jumat ? substr($jam->jam_mulai_jumat, 0, 5) . ' - ' . substr($jam->jam_selesai_jumat, 0, 5) : '-' }}
                                        </td>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayCol)
                                            @php
                                                $matchingJadwals = ($jadwalsMatrixByDay[$dayCol] ?? collect())->filter(function($j) use ($jam) {
                                                    return $j->id_jam_mulai <= $jam->id_jam && $j->id_jam_selesai >= $jam->id_jam;
                                                });
                                            @endphp
                                            <td>
                                                @forelse($matchingJadwals as $mJ)
                                                    <div class="matrix-cell-card">
                                                        <strong style="color: #1e3a8a;">{{ $mJ->kelas->nama_kelas ?? '-' }}</strong>
                                                        <div style="font-weight: 700; color: #0f172a; margin-top: 1px;">{{ $mJ->mapel->nama_mapel ?? '-' }}</div>
                                                        @if($activeTab === 'perwalian')
                                                            <div style="font-size: 10px; color: #475569; margin-top: 2px;">Guru: {{ $mJ->guru->nama_guru ?? '-' }}</div>
                                                        @endif
                                                        <div style="font-size: 10px; color: #64748b; margin-top: 3px; display: flex; align-items: center; gap: 4px;">
                                                            <i class="fa-solid fa-location-dot" style="font-size: 9px; color: #94a3b8;"></i> {{ $mJ->ruangan->nama_ruangan ?? '-' }}
                                                        </div>
                                                    </div>
                                                @empty
                                                    <span style="color: #cbd5e1; font-size: 11px;">-</span>
                                                @endforelse
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Mode Tampilan Tabel Standar & Interaktif -->
                <div class="card-jadwal-table">
                    <div style="overflow-x: auto;">
                        <table class="table-schedule" id="tableJadwalMengajar">
                            <thead>
                                <tr>
                                    <th style="width: 135px;">JAM & SESI KBM</th>
                                    <th>{{ $activeTab === 'perwalian' ? 'MAPEL & GURU PENGAMPU' : 'NAMA / KELAS' }}</th>
                                    <th>{{ $activeTab === 'perwalian' ? 'ALOKASI KELAS' : 'MATA PELAJARAN' }}</th>
                                    <th style="width: 120px;">RUANG</th>
                                    <th style="width: 140px; text-align: center;">STATUS</th>
                                    <th style="width: 160px; text-align: right;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $j)
                                    @php
                                        $hKey = strtolower(trim($j->hari));
                                        $targetDateRow = ($hariFilter !== 'semua' && isset($dayDates[$hKey]))
                                            ? $dayDates[$hKey]['date']
                                            : ($dayDates[$hKey]['date'] ?? \Carbon\Carbon::now('Asia/Jakarta')->toDateString());
                                        
                                        $isTargetToday = ($dayDates[$hKey]['is_today'] ?? false);
                                        $isPast = ($targetDateRow < \Carbon\Carbon::now('Asia/Jakarta')->toDateString());
                                        $isFuture = ($targetDateRow > \Carbon\Carbon::now('Asia/Jakarta')->toDateString());

                                        $jurnalRecord = $j->getJurnalPadaTanggal($targetDateRow);
                                        $sudahDiisi = ($jurnalRecord !== null);
                                        $isSedangBerlangsung = $isTargetToday && $j->is_sedang_berlangsung;
                                        $isHampirHabis = $isSedangBerlangsung && $j->hampir_habis;
                                        $isJamSelesai = $isPast || ($isTargetToday && $j->is_jam_sudah_selesai);

                                        // Cek kepemilikan sesi mengajar ini:
                                        $isOwnerGuru = ($currentGuruId && $j->id_guru == $currentGuruId) || !empty($j->is_guru_pengganti);

                                        // Default status & button
                                        $rowClass = 'row-future';
                                        $statusBadge = '<span class="badge-status badge-status-future"><i class="fa-regular fa-clock"></i> Belum Dimulai</span>';
                                        $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-locked" disabled title="Jadwal KBM belum dimulai"><i class="fa-solid fa-lock"></i> Belum Mulai</button>';

                                        if ($sudahDiisi) {
                                            $rowClass = 'row-selesai';
                                            $statusBadge = '<span class="badge-status badge-status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</span>';
                                            $actionBtn = '<button type="button" onclick="showJurnalDetailModal(' . $jurnalRecord->id_jurnal . ')" class="btn-action-jurnal btn-jurnal-terisi" title="Lihat detail jurnal KBM yang telah diisi"><i class="fa-solid fa-eye"></i> Lihat Jurnal</button>';
                                        } elseif ($activeTab === 'perwalian' && !$isOwnerGuru) {
                                            // Mode Pantau Kelas Perwalian (Diampu oleh Guru Mapel Lain)
                                            if ($isSedangBerlangsung) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status badge-status-berlangsung"><i class="fa-solid fa-signal"></i> Berlangsung</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; cursor: default;" title="KBM sedang berlangsung dan diampu oleh ' . e($j->guru->nama_guru ?? 'Guru Pengampu') . '"><i class="fa-solid fa-chalkboard-user"></i> Diampu Guru</button>';
                                            } elseif ($isJamSelesai) {
                                                $rowClass = 'row-belum';
                                                $statusBadge = '<span class="badge-status badge-status-belum"><i class="fa-solid fa-clock-rotate-left"></i> Belum Diisi</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-locked" disabled title="Guru pengampu belum/tidak mengisi jurnal pada sesi ini"><i class="fa-solid fa-circle-exclamation"></i> Belum Diisi Guru</button>';
                                            } else {
                                                $rowClass = 'row-future';
                                                $statusBadge = '<span class="badge-status badge-status-future"><i class="fa-regular fa-clock"></i> Belum Dimulai</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-locked" disabled title="Jadwal KBM belum dimulai"><i class="fa-solid fa-lock"></i> Belum Mulai</button>';
                                            }
                                        } else {
                                            // Mode Guru Pengampu Sendiri (Tab Saya atau Guru Pengampu di Kelas Perwalian)
                                            if ($isHampirHabis) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status badge-status-urgent"><i class="fa-solid fa-triangle-exclamation"></i> Sisa ' . $j->sisa_menit_selesai . ' Menit</span>';
                                                $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal, 'tanggal' => $targetDateRow]) . '" class="btn-action-jurnal" style="background: #e11d48; color: #ffffff; font-weight: 800; box-shadow: 0 4px 12px rgba(225,29,72,0.3); animation: pulseWarning 1.8s infinite;" title="Segera isi jurnal sebelum jam KBM selesai!"><i class="fa-solid fa-bell"></i> Segera Isi</a>';
                                            } elseif ($isSedangBerlangsung) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status badge-status-berlangsung"><i class="fa-solid fa-signal"></i> Berlangsung</span>';
                                                $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal, 'tanggal' => $targetDateRow]) . '" class="btn-action-jurnal btn-jurnal-isi" title="Jam KBM sedang berlangsung. Klik untuk mengisi jurnal."><i class="fa-solid fa-pen-to-square"></i> Isi Jurnal</a>';
                                            } elseif ($isJamSelesai) {
                                                $rowClass = 'row-belum';
                                                $statusBadge = '<span class="badge-status badge-status-belum"><i class="fa-solid fa-ban"></i> Waktu Habis</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-locked" disabled title="Waktu jam pelajaran telah berakhir (Pukul ' . $j->waktu_selesai_effective . ' WIB). Pengisian jurnal telah ditutup."><i class="fa-solid fa-lock"></i> Waktu Habis</button>';
                                            }
                                        }

                                        if (!empty($j->is_guru_pengganti)) {
                                            $rowClass = 'row-guru-pengganti';
                                            $statusBadge = '<span class="badge-status badge-status-pengganti"><i class="fa-solid fa-user-shield"></i> Guru Pengganti</span>';
                                        }
                                    @endphp

                                    <tr class="row-jadwal {{ $rowClass }}" data-search="{{ strtolower($j->kelas->nama_kelas ?? '') }} {{ strtolower($j->mapel->nama_mapel ?? '') }} {{ strtolower($j->guru->nama_guru ?? '') }} {{ strtolower($j->ruangan->nama_ruangan ?? '') }}">
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <strong style="color: #0f172a;">{{ $j->jam_range }}</strong>
                                                <span style="font-size: 10.5px; background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 6px; font-weight: 800;">
                                                    {{ $j->jumlah_jp }} JP
                                                </span>
                                            </div>
                                            <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                                {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} WIB
                                            </div>
                                            @if($hariFilter === 'semua')
                                                <div style="font-size: 11px; font-weight: 800; color: #2563eb; margin-top: 3px;">
                                                    {{ $j->hari }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            @if($activeTab === 'perwalian')
                                                <strong style="font-size: 13.5px; color: #0f172a;">{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                                <div style="font-size: 12px; color: #64748b; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                                                    <i class="fa-solid fa-user-tie" style="font-size: 10px; color: #94a3b8;"></i> {{ $j->guru->nama_guru ?? 'Guru Mapel' }}
                                                </div>
                                            @else
                                                <strong style="font-size: 14px; color: #0f172a;">{{ $j->kelas->nama_kelas ?? '-' }}</strong>
                                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                                    {{ $j->guru->nama_guru ?? Auth::user()->name }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            @if($activeTab === 'perwalian')
                                                <span style="font-weight: 700; color: #1e293b;">{{ $j->kelas->nama_kelas ?? '-' }}</span>
                                                <div style="font-size: 11px; color: #94a3b8;">Kelas Perwalian</div>
                                            @else
                                                <strong style="color: #1e293b;">{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                                <div style="font-size: 11px; color: #94a3b8;">{{ $j->mapel->kode_mapel ?? 'Kurikulum Merdeka' }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-location-dot" style="color: #94a3b8; font-size: 11px;"></i>
                                                <strong style="color: #334155;">{{ $j->ruangan->nama_ruangan ?? '-' }}</strong>
                                            </div>
                                        </td>

                                        <td style="text-align: center;">
                                            {!! $statusBadge !!}
                                        </td>

                                        <td style="text-align: right;">
                                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                                {!! $actionBtn !!}
                                                <button type="button" onclick="showJadwalModal({{ $j->id_jadwal }}, '{{ $j->kelas->nama_kelas ?? '-' }}', '{{ $j->mapel->nama_mapel ?? '-' }}', '{{ $j->guru->nama_guru ?? '-' }}', '{{ $j->ruangan->nama_ruangan ?? '-' }}', '{{ $j->hari }}', '{{ $j->jam_range }}', '{{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} WIB', '{{ $j->jumlah_jp }} JP', {{ $isOwnerGuru ? 'true' : 'false' }})" class="btn-modal-detail" title="Detail Jadwal">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 42px 20px;">
                                            <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; margin-bottom: 10px; display: block; opacity: 0.4;"></i>
                                            <div style="font-size: 14px; font-weight: 700; color: #64748b;">Tidak Ada Jadwal Mengajar</div>
                                            <div style="font-size: 12.5px; color: #94a3b8; margin-top: 2px;">
                                                Tidak ditemukan jadwal pada {{ $hariFilter === 'semua' ? 'seluruh hari' : 'hari ' . ($dayDates[$hariFilter]['day_name'] ?? ucfirst($hariFilter)) }}.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

    <!-- Modal 1: Detail Jadwal Pelajaran -->
    <div id="modalDetailJadwal" class="custom-modal-backdrop">
        <div class="custom-modal-box">
            <div class="modal-header-styled">
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-calendar-day" style="color: #2563eb;"></i> Detail Jadwal KBM
                </div>
                <button type="button" onclick="closeModal('modalDetailJadwal')" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-styled">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <span id="modalKelasName" style="font-size: 18px; font-weight: 800; color: #0f172a;">-</span>
                        <span id="modalAlokasiJp" style="font-size: 12px; background: #eff6ff; color: #2563eb; padding: 3px 10px; border-radius: 8px; font-weight: 800; border: 1px solid #bfdbfe;">- JP</span>
                    </div>
                    <div id="modalMapelName" style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">-</div>
                    <div style="font-size: 12.5px; color: #64748b; display: flex; align-items: center; gap: 14px;">
                        <span><i class="fa-solid fa-user-tie" style="margin-right: 4px; color: #94a3b8;"></i> <span id="modalGuruName">-</span></span>
                        <span><i class="fa-solid fa-location-dot" style="margin-right: 4px; color: #94a3b8;"></i> <span id="modalRuangName">-</span></span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; background: #ffffff;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Hari & Jam Pelajaran</div>
                        <div id="modalHariJam" style="font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                    </div>
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; background: #ffffff;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Waktu Efektif KBM</div>
                        <div id="modalWaktuEfektif" style="font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-styled">
                <button type="button" onclick="closeModal('modalDetailJadwal')" class="btn-toolbar-modern">
                    Tutup
                </button>
                <a id="modalBtnIsiJurnal" href="{{ route('guru.jurnal-harian') }}" class="btn-toolbar-modern btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Jurnal Harian
                </a>
            </div>
        </div>
    </div>

    <!-- Modal 2: Quick View Jurnal Terisi -->
    <div id="modalDetailJurnal" class="custom-modal-backdrop">
        <div class="custom-modal-box" style="max-width: 620px;">
            <div class="modal-header-styled">
                <div style="font-size: 16px; font-weight: 800; color: #059669; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Detail Jurnal Mengajar
                </div>
                <button type="button" onclick="closeModal('modalDetailJurnal')" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-styled" id="modalJurnalContent">
                <div style="text-align: center; padding: 24px; color: #64748b;">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 24px; color: #2563eb;"></i>
                    <div style="margin-top: 8px; font-weight: 600;">Memuat data jurnal...</div>
                </div>
            </div>
            <div class="modal-footer-styled">
                <button type="button" onclick="closeModal('modalDetailJurnal')" class="btn-toolbar-modern">
                    Tutup
                </button>
                <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-toolbar-modern btn-primary">
                    <i class="fa-solid fa-book-open"></i> Riwayat Lengkap
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Live Client-side Filter Table
    function filterTableLive() {
        const input = document.getElementById('inputSearchJadwal').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tableJadwalMengajar tbody tr.row-jadwal');
        
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Handlers
    function showJadwalModal(id, kelas, mapel, guru, ruang, hari, jamRange, waktuRange, alokasi, isOwner = false) {
        document.getElementById('modalKelasName').innerText = kelas;
        document.getElementById('modalMapelName').innerText = mapel;
        document.getElementById('modalGuruName').innerText = guru;
        document.getElementById('modalRuangName').innerText = ruang;
        document.getElementById('modalHariJam').innerText = hari + ' (' + jamRange + ')';
        document.getElementById('modalWaktuEfektif').innerText = waktuRange;
        document.getElementById('modalAlokasiJp').innerText = alokasi;
        
        const btnIsi = document.getElementById('modalBtnIsiJurnal');
        if (btnIsi) {
            if (isOwner) {
                btnIsi.style.display = 'inline-flex';
                btnIsi.href = "{{ route('guru.jurnal-harian') }}?id_jadwal=" + id;
            } else {
                btnIsi.style.display = 'none';
            }
        }

        document.getElementById('modalDetailJadwal').style.display = 'flex';
    }

    function showJurnalDetailModal(idJurnal) {
        const modal = document.getElementById('modalDetailJurnal');
        const content = document.getElementById('modalJurnalContent');
        modal.style.display = 'flex';
        content.innerHTML = `
            <div style="text-align: center; padding: 24px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 24px; color: #2563eb;"></i>
                <div style="margin-top: 8px; font-weight: 600;">Memuat rincian jurnal mengajar...</div>
            </div>
        `;

        fetch(`{{ url('/guru-jurnal-detail') }}/${idJurnal}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success || !res.data) {
                    content.innerHTML = `
                        <div style="text-align: center; color: #be123c; padding: 16px;">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; margin-bottom: 6px;"></i>
                            <div>Gagal memuat rincian jurnal mengajar.</div>
                        </div>
                    `;
                    return;
                }

                const d = res.data;
                const stats = d.statistik_kehadiran || { total_siswa: 0, hadir: 0, sakit: 0, izin: 0, alpa: 0 };
                const absenItems = d.daftar_absen || [];

                let absenTableHtml = '';
                if (absenItems.length > 0) {
                    const rows = absenItems.map(a => `
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 7px 8px; font-weight: 600; color: #1e293b;">
                                ${a.nama_siswa} <span style="font-size: 10px; color: #94a3b8;">(${a.nisn})</span>
                            </td>
                            <td style="padding: 7px 8px; text-align: right;">
                                <span style="font-weight: 800; font-size: 10.5px; padding: 3px 8px; border-radius: 6px; ${a.keterangan === 'Sakit' ? 'background: #fef9c3; color: #854d0e; border: 1px solid #fef08a;' : (a.keterangan === 'Alpa' ? 'background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;' : 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;')}">${a.keterangan}</span>
                            </td>
                        </tr>
                    `).join('');

                    absenTableHtml = `
                        <div style="margin-top: 12px; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Daftar Siswa Tidak Hadir:</div>
                            <table style="width: 100%; font-size: 11.5px; border-collapse: collapse;">
                                <thead>
                                    <tr style="text-align: left; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        <th style="padding: 4px 8px;">Nama Siswa</th>
                                        <th style="padding: 4px 8px; text-align: right;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>
                    `;
                } else {
                    absenTableHtml = `
                        <div style="font-size: 11.5px; color: #059669; font-weight: 700; text-align: center; padding: 8px; background: #ecfdf5; border-radius: 8px; margin-top: 10px; border: 1px solid #a7f3d0;">
                            <i class="fa-solid fa-check-double" style="margin-right: 4px;"></i> Seluruh siswa hadir dalam pembelajaran ini.
                        </div>
                    `;
                }

                content.innerHTML = `
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px; margin-bottom: 14px;">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 8px;">
                            <div>
                                <div style="font-size: 16px; font-weight: 800; color: #0f172a;">${d.mapel}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    <span style="font-weight: 700; color: #334155;">${d.kelas}</span> &bull; 
                                    <span>${d.ruangan}</span> &bull; 
                                    <span>${d.hari}, ${d.tanggal_formatted}</span>
                                </div>
                            </div>
                            <span style="background: #ecfdf5; color: #059669; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; white-space: nowrap; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-circle-check"></i> TERISI
                            </span>
                        </div>
                        
                        <div style="font-size: 12px; color: #475569; display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; padding-top: 8px; border-top: 1px dashed #cbd5e1;">
                            <div><i class="fa-solid fa-user-tie" style="color: #2563eb; margin-right: 4px;"></i> <strong>Guru:</strong> ${d.guru} ${d.is_guru_pengganti ? `(Pengganti: ${d.guru_pengganti})` : ''}</div>
                            <div><i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 4px;"></i> <strong>Jam:</strong> ${d.jam_ke} (${d.waktu_kbm})</div>
                            <div><i class="fa-solid fa-layer-group" style="color: #2563eb; margin-right: 4px;"></i> <strong>Pertemuan:</strong> Ke-${d.pertemuan_ke}</div>
                        </div>
                    </div>

                    <!-- Materi & Catatan -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; margin-bottom: 14px;">
                        <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Materi Pembelajaran</div>
                        <div style="font-size: 13px; font-weight: 600; color: #1e293b; line-height: 1.4;">${d.materi || '-'}</div>
                        
                        <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-top: 10px; margin-bottom: 4px;">Catatan / Evaluasi KBM</div>
                        <div style="font-size: 12px; color: #475569; line-height: 1.4;">${d.catatan || 'Tidak ada catatan.'}</div>
                    </div>

                    <!-- Rekap Presensi Siswa -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                        <div style="font-size: 12.5px; font-weight: 800; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-solid fa-users" style="color: #2563eb; margin-right: 6px;"></i> Presensi Siswa (${stats.total_siswa} Siswa)</span>
                            <span style="font-size: 11.5px; color: #059669; font-weight: 800;">Hadir: ${stats.hadir} Siswa</span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 8px;">
                            <div style="background: #ecfdf5; padding: 6px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                <div style="font-size: 9.5px; font-weight: 800; color: #059669;">HADIR</div>
                                <div style="font-size: 13px; font-weight: 800; color: #059669;">${stats.hadir}</div>
                            </div>
                            <div style="background: #fef9c3; padding: 6px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                <div style="font-size: 9.5px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                <div style="font-size: 13px; font-weight: 800; color: #a16207;">${stats.sakit}</div>
                            </div>
                            <div style="background: #e0f2fe; padding: 6px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                <div style="font-size: 9.5px; font-weight: 800; color: #075985;">IZIN</div>
                                <div style="font-size: 13px; font-weight: 800; color: #0369a1;">${stats.izin}</div>
                            </div>
                            <div style="background: #fee2e2; padding: 6px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                <div style="font-size: 9.5px; font-weight: 800; color: #991b1b;">ALPA</div>
                                <div style="font-size: 13px; font-weight: 800; color: #b91c1c;">${stats.alpa}</div>
                            </div>
                        </div>
                        
                        ${absenTableHtml}
                    </div>
                `;
            })
            .catch(() => {
                content.innerHTML = `
                    <div style="text-align: center; color: #be123c; padding: 16px;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; margin-bottom: 6px;"></i>
                        <div>Gagal memuat rincian jurnal mengajar.</div>
                    </div>
                `;
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Close on backdrop click
    window.addEventListener('click', function(e) {
        ['modalDetailJadwal', 'modalDetailJurnal'].forEach(id => {
            const el = document.getElementById(id);
            if (el && e.target === el) {
                el.style.display = 'none';
            }
        });
    });
</script>
@endsection
