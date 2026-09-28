@extends('layouts.waka_kurikulum')

@section('title', 'Kelola Jadwal Pelajaran — Waka Kurikulum')

@section('styles')
<style>
    .jadwal-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-primary { background: #2563eb; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25); }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

    .btn-emerald { background: #059669; color: #ffffff; box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25); }
    .btn-emerald:hover { background: #047857; transform: translateY(-1px); }

    .btn-indigo { background: #4f46e5; color: #ffffff; }
    .btn-indigo:hover { background: #4338ca; }

    .btn-outline { background: #ffffff; color: #334155; border: 1px solid #cbd5e1; }
    .btn-outline:hover { background: #f8fafc; border-color: #94a3b8; }

    .btn-trash { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .btn-trash:hover { background: #fecaca; }

    /* 4 Stat Cards Row */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        width: 100%;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 0;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue    { background: #eff6ff; color: #2563eb; }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-purple  { background: #f5f3ff; color: #7c3aed; }
    .icon-amber   { background: #fffbeb; color: #d97706; }

    .stat-info-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-count {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 1px;
        line-height: 1.2;
    }

    /* Filter & View Mode Controls */
    .control-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .view-mode-tabs {
        display: flex;
        gap: 6px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .tab-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .tab-btn:hover { background: #f1f5f9; color: #0f172a; }
    .tab-btn.active { background: #2563eb; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25); }

    .filter-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px;
        align-items: end;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .form-group-filter label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }

    .form-control-filter {
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s ease;
        height: 38px;
        box-sizing: border-box;
    }

    .form-control-filter:focus {
        border-color: #2563eb;
    }

    .filter-btn-group {
        display: flex;
        gap: 8px;
        align-items: flex-end;
    }

    /* Table Section */
    .table-wrapper-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-header-bar {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .table-header-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-header-count {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .desktop-jadwal-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 850px;
    }

    .jadwal-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .jadwal-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .jadwal-table tr:hover td {
        background: #f8fafc;
    }

    .day-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }
    .day-Senin   { background: #eff6ff; color: #1d4ed8; }
    .day-Selasa  { background: #fdf2f8; color: #be185d; }
    .day-Rabu    { background: #f0fdf4; color: #15803d; }
    .day-Kamis   { background: #fefce8; color: #a16207; }
    .day-Jumat   { background: #faf5ff; color: #7e22ce; }
    .day-Sabtu   { background: #fff7ed; color: #c2410c; }

    .class-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        border-radius: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        font-weight: 800;
        font-size: 11.5px;
    }

    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 11.5px;
        font-weight: 600;
    }

    /* Mobile Jadwal Cards (Hidden on Desktop) */
    .mobile-jadwal-wrapper {
        display: none;
    }

    /* Matrix View Styles */
    .matrix-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .matrix-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .matrix-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        min-width: 900px;
    }

    .matrix-table th {
        background: #1e293b;
        color: #ffffff;
        padding: 10px 12px;
        text-align: center;
        font-weight: 700;
        border: 1px solid #334155;
    }

    .matrix-table td {
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
        vertical-align: top;
        font-size: 12px;
    }

    .matrix-cell-empty {
        background: #fafafa;
        color: #cbd5e1;
        text-align: center;
        font-style: italic;
        padding: 12px 6px;
    }

    .matrix-cell-filled {
        background: #f8fafc;
        border-radius: 6px;
        padding: 8px;
        border-left: 3px solid #2563eb;
    }

    .matrix-cell-break {
        background: #fef3c7;
        color: #92400e;
        text-align: center;
        font-weight: 800;
        font-size: 11.5px;
        padding: 6px;
    }

    .matrix-scroll-hint {
        display: none;
    }

    /* Modals */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-lg { max-width: 800px; }

    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
    }
    .modal-close-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .modal-body { padding: 20px; }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    .modal-input, .modal-select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        margin-top: 4px;
        box-sizing: border-box;
    }

    .modal-input:focus, .modal-select:focus {
        border-color: #2563eb;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* Action Buttons in Row */
    .btn-row-action {
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.15s ease;
    }
    .btn-row-detail {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 6px 14px;
    }
    .btn-row-detail:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    }

    /* Responsive Breakpoints */
    @media (max-width: 1024px) {
        .stat-cards-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .filter-form-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .jadwal-container {
            gap: 14px;
        }

        .page-header-box {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .page-main-title {
            font-size: 19px !important;
            line-height: 1.25 !important;
        }

        .page-sub-title {
            font-size: 12px !important;
            line-height: 1.4 !important;
        }

        .header-actions {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .header-actions .btn-action {
            width: 100% !important;
            justify-content: center !important;
            padding: 8px 10px !important;
            font-size: 12px !important;
            box-sizing: border-box;
        }

        /* 4 Stat Cards in 2x2 Grid */
        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
        }

        .stat-card-item {
            padding: 12px 12px !important;
            gap: 10px !important;
            border-radius: 12px !important;
        }

        .stat-icon-wrapper {
            width: 38px !important;
            height: 38px !important;
            font-size: 16px !important;
            border-radius: 10px !important;
        }

        .stat-title {
            font-size: 11px !important;
        }

        .stat-count {
            font-size: 17px !important;
        }

        /* Control Card on Mobile */
        .control-card {
            padding: 14px !important;
            border-radius: 14px !important;
        }

        .view-mode-tabs {
            padding-bottom: 10px !important;
            gap: 6px !important;
        }

        .tab-btn {
            padding: 7px 12px !important;
            font-size: 12px !important;
        }

        .filter-form-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
        }

        .filter-search-col {
            grid-column: 1 / -1 !important;
        }

        .filter-btn-group {
            grid-column: 1 / -1 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .filter-btn-group .btn-action {
            width: 100% !important;
            justify-content: center !important;
        }

        /* TAB 1: Hide Desktop Table, Show Mobile Cards */
        .desktop-jadwal-table-wrapper {
            display: none !important;
        }

        .mobile-jadwal-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 12px !important;
            background: #f8fafc !important;
        }

        .mobile-jadwal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: border-color 0.2s ease;
        }

        .mobile-jadwal-card:hover {
            border-color: #cbd5e1;
        }

        .mobile-jadwal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }

        .mobile-jadwal-header-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .mobile-jadwal-index {
            font-weight: 800;
            color: #94a3b8;
            font-size: 11.5px;
        }

        .mobile-jadwal-body {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-mapel-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.3;
        }

        .mobile-guru-info {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .mobile-jadwal-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            padding: 9px 12px;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
            font-size: 12px;
        }

        .mobile-meta-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .mobile-meta-lbl {
            font-size: 10.5px;
            font-weight: 700;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mobile-meta-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .mobile-btn-detail {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        .mobile-btn-detail:hover {
            background: #dbeafe;
        }

        /* TAB 2 & 3: Matrix Views Mobile Optimization */
        .matrix-card {
            padding: 14px !important;
            border-radius: 14px !important;
        }

        .matrix-header-box {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }

        .matrix-controls-form {
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .matrix-controls-form select {
            width: 100% !important;
            min-width: 0 !important;
        }

        .matrix-controls-form .btn-action {
            width: 100% !important;
            justify-content: center !important;
        }

        .matrix-scroll-hint {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11.5px;
            font-weight: 700;
            border-radius: 8px;
            margin-bottom: 12px;
            border: 1px dashed #bfdbfe;
            text-align: center;
        }

        .matrix-table {
            min-width: 780px !important;
            font-size: 11.5px !important;
        }

        .matrix-table th {
            padding: 8px 6px !important;
            font-size: 11px !important;
        }

        .matrix-table td {
            padding: 6px 8px !important;
            font-size: 11px !important;
        }

        .matrix-cell-filled {
            padding: 6px !important;
            border-radius: 5px !important;
        }

        /* Modals on Mobile */
        .modal-overlay {
            padding: 12px !important;
        }

        .modal-box {
            max-width: 100% !important;
            max-height: 92vh !important;
            border-radius: 14px !important;
        }

        .modal-header {
            padding: 14px 16px !important;
        }

        .modal-header h3 {
            font-size: 15px !important;
        }

        .modal-body {
            padding: 14px 16px !important;
        }

        .modal-footer {
            padding: 12px 16px !important;
        }

        .modal-footer .btn-action {
            width: 100% !important;
            justify-content: center !important;
        }
    }

    @media (max-width: 480px) {
        .filter-form-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="jadwal-container">

    {{-- Header & Action Buttons --}}
    <div class="page-header-box">
        <div>
            <h1 class="page-main-title">Jadwal Pelajaran</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Pemantauan Jadwal KBM, Pemetaan Guru &amp; Distribusi Jam Pembelajaran</p>
        </div>

        <div class="header-actions">
            <button type="button" class="btn-action btn-outline" onclick="openCetakModal()">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
            <a href="{{ route('waka-kurikulum.jadwal.export', request()->all()) }}" class="btn-action btn-primary">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- 4 Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Jadwal Aktif</span>
                <span class="stat-count">{{ number_format($stats['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Kelas Terjadwal</span>
                <span class="stat-count">{{ $stats['kelas_terjadwal'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Kelas</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Guru Mengajar</span>
                <span class="stat-count">{{ $stats['guru_mengajar'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Guru</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Ruangan Digunakan</span>
                <span class="stat-count">{{ $stats['ruangan_digunakan'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Ruang</span></span>
            </div>
        </div>
    </div>

    {{-- Control Panel: Filter & View Mode --}}
    <div class="control-card">
        <div class="view-mode-tabs">
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'table'])) }}" 
               class="tab-btn {{ ($viewMode === 'table') ? 'active' : '' }}">
                <i class="fa-solid fa-table-list"></i> Tabel Jadwal
            </a>
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'matriks_kelas'])) }}" 
               class="tab-btn {{ ($viewMode === 'matriks_kelas') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells"></i> Matriks Per Kelas
            </a>
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'matriks_guru'])) }}" 
               class="tab-btn {{ ($viewMode === 'matriks_guru') ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie"></i> Matriks Per Guru
            </a>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" class="filter-form-grid">
            <input type="hidden" name="view_mode" value="{{ $viewMode }}">

            <div class="form-group-filter">
                <label>Filter Hari</label>
                <select name="hari" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                        <option value="{{ $h }}" {{ ($hariFilter === $h) ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Kelas</label>
                <select name="id_kelas" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($kelasFilter == $k->id_kelas) ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Guru Pengampu</label>
                <select name="id_guru" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Guru --</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}" {{ ($guruFilter == $g->id_guru) ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter filter-search-col">
                <label>Cari Kata Kunci</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control-filter" placeholder="Mapel / Ruangan...">
            </div>

            <div class="filter-btn-group">
                <button type="submit" class="btn-action btn-primary" style="height: 38px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-kurikulum.jadwal', ['view_mode' => $viewMode]) }}" class="btn-action btn-outline" style="height: 38px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL VIEW --}}
    @if($viewMode === 'table')
    <div class="table-wrapper-card">
        <div class="table-header-bar">
            <div class="table-header-title">
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                Daftar Data Tabel Jadwal Pelajaran
            </div>
            <div class="table-header-count">
                Menampilkan <span style="color: #0f172a; font-weight: 800;">{{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }}</span> dari <span style="color: #0f172a; font-weight: 800;">{{ $jadwals->total() }}</span> Data
            </div>
        </div>

        {{-- Desktop View Table (100% Intact) --}}
        <div class="desktop-jadwal-table-wrapper">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">NO</th>
                        <th>HARI</th>
                        <th>JAM KE</th>
                        <th>WAKTU KBM</th>
                        <th>KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>GURU PENGAMPU</th>
                        <th>RUANGAN</th>
                        <th style="text-align: center; width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $index => $jadwal)
                        @php
                            $waktuMulaiStr = $jadwal->jamMulai ? substr($jadwal->jamMulai->jam_mulai, 0, 5) : '-';
                            $waktuSelesaiStr = $jadwal->jamSelesai ? substr($jadwal->jamSelesai->jam_selesai, 0, 5) : '-';
                            $rangeWaktu = ($waktuMulaiStr !== '-' && $waktuSelesaiStr !== '-') ? "{$waktuMulaiStr} – {$waktuSelesaiStr} WIB" : '-';
                            $labelJamKe = $jadwal->jam_mulai_ke == $jadwal->jam_selesai_ke ? "Jam Ke-{$jadwal->jam_mulai_ke}" : "Jam Ke-{$jadwal->jam_mulai_ke} – {$jadwal->jam_selesai_ke}";
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 12px;">
                                {{ $jadwals->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="day-badge day-{{ $jadwal->hari }}">
                                    {{ $jadwal->hari }}
                                </span>
                            </td>
                            <td style="font-weight: 700; color: #1d4ed8;">
                                {{ $labelJamKe }}
                            </td>
                            <td style="font-size: 12px; color: #475569; font-weight: 600;">
                                <i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 3px;"></i> {{ $rangeWaktu }}
                            </td>
                            <td style="font-weight: 800; color: #0f172a;">
                                {{ $jadwal->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td style="font-weight: 700; color: #2563eb;">
                                {{ $jadwal->mapel->nama_mapel ?? '-' }}
                                <div style="font-size: 11px; color: #64748b; font-weight: 600;">{{ $jadwal->mapel->kode_mapel ?? '' }}</div>
                            </td>
                            <td style="font-weight: 600; color: #334155;">
                                {{ $jadwal->guru->nama_guru ?? '-' }}
                            </td>
                            <td style="font-size: 12px; color: #64748b;">
                                {{ $jadwal->ruangan->nama_ruangan ?? 'Kelas Reguler' }}
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-row-action btn-row-detail" title="Lihat Detail Jadwal"
                                    data-hari="{{ $jadwal->hari }}"
                                    data-jam-ke="{{ $labelJamKe }}"
                                    data-waktu="{{ $rangeWaktu }}"
                                    data-kelas="{{ $jadwal->kelas->nama_kelas ?? '-' }}"
                                    data-tingkat="{{ $jadwal->kelas->tingkat ?? '-' }}"
                                    data-jurusan="{{ $jadwal->kelas->jurusan->nama_jurusan ?? '-' }}"
                                    data-mapel="{{ $jadwal->mapel->nama_mapel ?? '-' }}"
                                    data-kode-mapel="{{ $jadwal->mapel->kode_mapel ?? '-' }}"
                                    data-guru="{{ $jadwal->guru->nama_guru ?? '-' }}"
                                    data-nip="{{ $jadwal->guru->nip ?? '-' }}"
                                    data-ruangan="{{ $jadwal->ruangan->nama_ruangan ?? 'Kelas Reguler' }}"
                                    onclick="openDetailModalFromDataset(this)">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 36px 20px; color: #94a3b8;">
                                <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; margin-bottom: 8px;"></i>
                                <p style="font-weight: 700;">Tidak ada data jadwal yang sesuai dengan filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile View Cards (Responsive for Handphones <= 768px) --}}
        <div class="mobile-jadwal-wrapper">
            @forelse($jadwals as $index => $jadwal)
                @php
                    $waktuMulaiStr = $jadwal->jamMulai ? substr($jadwal->jamMulai->jam_mulai, 0, 5) : '-';
                    $waktuSelesaiStr = $jadwal->jamSelesai ? substr($jadwal->jamSelesai->jam_selesai, 0, 5) : '-';
                    $rangeWaktu = ($waktuMulaiStr !== '-' && $waktuSelesaiStr !== '-') ? "{$waktuMulaiStr} – {$waktuSelesaiStr} WIB" : '-';
                    $labelJamKe = $jadwal->jam_mulai_ke == $jadwal->jam_selesai_ke ? "Jam Ke-{$jadwal->jam_mulai_ke}" : "Jam Ke-{$jadwal->jam_mulai_ke} – {$jadwal->jam_selesai_ke}";
                @endphp
                <div class="mobile-jadwal-card">
                    {{-- Header Card --}}
                    <div class="mobile-jadwal-header">
                        <div class="mobile-jadwal-header-left">
                            <span class="mobile-jadwal-index">#{{ $jadwals->firstItem() + $index }}</span>
                            <span class="day-badge day-{{ $jadwal->hari }}">
                                {{ $jadwal->hari }}
                            </span>
                            <span class="class-chip">
                                <i class="fa-solid fa-graduation-cap"></i> {{ $jadwal->kelas->nama_kelas ?? '-' }}
                            </span>
                        </div>
                        <span class="room-badge">
                            <i class="fa-solid fa-door-open"></i> {{ $jadwal->ruangan->nama_ruangan ?? 'R. Kelas' }}
                        </span>
                    </div>

                    {{-- Body Card --}}
                    <div class="mobile-jadwal-body">
                        <div>
                            <div class="mobile-mapel-title">{{ $jadwal->mapel->nama_mapel ?? '-' }}</div>
                            @if(!empty($jadwal->mapel->kode_mapel))
                                <div style="font-size: 11px; color: #64748b; font-weight: 700;">Kode: {{ $jadwal->mapel->kode_mapel }}</div>
                            @endif
                        </div>

                        <div class="mobile-guru-info">
                            <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i>
                            <span>{{ $jadwal->guru->nama_guru ?? '-' }}</span>
                        </div>

                        {{-- Meta Info --}}
                        <div class="mobile-jadwal-meta-grid">
                            <div class="mobile-meta-item">
                                <span class="mobile-meta-lbl"><i class="fa-solid fa-clock-rotate-left"></i> Jam Pelajaran</span>
                                <span class="mobile-meta-val" style="color: #1d4ed8;">
                                    {{ $labelJamKe }}
                                </span>
                            </div>
                            <div class="mobile-meta-item">
                                <span class="mobile-meta-lbl"><i class="fa-regular fa-clock"></i> Waktu KBM</span>
                                <span class="mobile-meta-val">
                                    {{ $rangeWaktu }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <button type="button" class="mobile-btn-detail"
                        data-hari="{{ $jadwal->hari }}"
                        data-jam-ke="{{ $labelJamKe }}"
                        data-waktu="{{ $rangeWaktu }}"
                        data-kelas="{{ $jadwal->kelas->nama_kelas ?? '-' }}"
                        data-tingkat="{{ $jadwal->kelas->tingkat ?? '-' }}"
                        data-jurusan="{{ $jadwal->kelas->jurusan->nama_jurusan ?? '-' }}"
                        data-mapel="{{ $jadwal->mapel->nama_mapel ?? '-' }}"
                        data-kode-mapel="{{ $jadwal->mapel->kode_mapel ?? '-' }}"
                        data-guru="{{ $jadwal->guru->nama_guru ?? '-' }}"
                        data-nip="{{ $jadwal->guru->nip ?? '-' }}"
                        data-ruangan="{{ $jadwal->ruangan->nama_ruangan ?? 'Kelas Reguler' }}"
                        onclick="openDetailModalFromDataset(this)">
                        <i class="fa-solid fa-eye"></i> Detail Jadwal Pelajaran
                    </button>
                </div>
            @empty
                <div style="text-align: center; padding: 35px 15px; color: #94a3b8; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; margin-bottom: 8px;"></i>
                    <p style="font-weight: 700; font-size: 13px; margin: 0;">Tidak ada data jadwal yang sesuai dengan filter pencarian.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; overflow-x: auto;">
            {{ $jadwals->links('partials.custom-pagination') }}
        </div>
    </div>
    @endif

    {{-- VIEW 2: MATRIKS KELAS --}}
    @if($viewMode === 'matriks_kelas')
    <div class="matrix-card">
        <div class="matrix-header-box">
            <div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chalkboard" style="color: #2563eb;"></i>
                    Matriks Jadwal Mingguan: <span style="color: #2563eb;">{{ $selectedKelasObj->nama_kelas ?? 'Pilih Kelas' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    Format alokasi waktu &amp; jam KBM disesuaikan dengan kurikulum resmi SMKN 1 Boyolangu
                </div>
            </div>

            <div class="matrix-controls-form">
                <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    <input type="hidden" name="view_mode" value="matriks_kelas">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; white-space: nowrap;">Pilih Kelas:</label>
                    <select name="selected_kelas" class="form-control-filter" onchange="this.form.submit()" style="width: auto; min-width: 160px; height: 36px; flex: 1;">
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ ($selectedKelas == $k->id_kelas) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tingkat }})
                            </option>
                        @endforeach
                    </select>
                </form>

                @if($selectedKelas)
                <a href="{{ route('waka-kurikulum.jadwal.print-kelas', $selectedKelas) }}" target="_blank" class="btn-action btn-outline" style="padding: 7px 12px; font-size: 12px;">
                    <i class="fa-solid fa-print"></i> Cetak Jadwal Kelas Ini
                </a>
                @endif
            </div>
        </div>

        <div class="matrix-scroll-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Geser tabel ke samping untuk melihat seluruh hari (Senin – Jumat)
        </div>

        <div class="table-scroll-wrapper">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Jam</th>
                        <th style="width: 110px;">Waktu (Senin–Kamis)</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th style="width: 110px;">Waktu (Jumat)</th>
                        <th>Jumat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $timesSeninKamis = [
                            1 => '07:00 – 07:40',
                            2 => '07:40 – 08:20',
                            3 => '08:20 – 09:00',
                            4 => '09:00 – 09:40',
                            5 => '10:00 – 10:35',
                            6 => '10:35 – 11:10',
                            7 => '11:10 – 11:45',
                            8 => '13:15 – 13:50',
                            9 => '13:50 – 14:25',
                            10 => '14:25 – 15:00',
                        ];

                        $timesJumat = [
                            1 => '07:00 – 07:30',
                            2 => '07:30 – 08:00',
                            3 => '08:00 – 08:30',
                            4 => '08:30 – 09:00',
                            5 => '09:00 – 09:30',
                            6 => '09:50 – 10:20',
                            7 => '10:20 – 10:50',
                            8 => '10:50 – 11:20',
                            9 => '13:00 – 13:30',
                            10 => '13:30 – 14:00',
                            11 => '14:00 – 14:30',
                            12 => '14:30 – 15:00',
                            13 => '15:00 – 15:35',
                        ];
                    @endphp

                    @for($jam = 1; $jam <= $maxJamKelas; $jam++)
                        {{-- Istirahat 1 Notification --}}
                        @if($jam === 5)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-mug-hot"></i> ISTIRAHAT 1 (Senin–Kamis: 09:40 – 10:00 WIB)
                                </td>
                            </tr>
                        @endif

                        {{-- Istirahat 2 Notification --}}
                        @if($jam === 8)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-utensils"></i> ISTIRAHAT 2 / ISHOMA (Senin–Kamis: 11:45 – 13:15 WIB)
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td style="text-align: center; font-weight: 800; background: #f8fafc;">{{ $jam }}</td>
                            <td style="text-align: center; font-weight: 600; color: #475569; background: #f8fafc; font-size: 11.5px;">
                                {{ $timesSeninKamis[$jam] ?? '-' }}
                            </td>

                            {{-- Senin, Selasa, Rabu, Kamis --}}
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis'] as $day)
                                @php
                                    $cell = $matriksKelasData[$day][$jam] ?? null;
                                @endphp
                                @if($cell)
                                    <td class="matrix-cell-filled">
                                        <div style="font-weight: 800; color: #1e3a8a; font-size: 12.5px;">
                                            {{ $cell->mapel->nama_mapel ?? 'Mapel' }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #334155; font-weight: 600; margin-top: 2px;">
                                            <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i> {{ $cell->guru->nama_guru ?? '-' }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <i class="fa-solid fa-door-open"></i> {{ $cell->ruangan->nama_ruangan ?? 'R. Kelas' }}
                                        </div>
                                    </td>
                                @else
                                    <td class="matrix-cell-empty">-</td>
                                @endif
                            @endforeach

                            {{-- Waktu Jumat --}}
                            <td style="text-align: center; font-weight: 600; color: #475569; background: #f8fafc; font-size: 11.5px;">
                                {{ $timesJumat[$jam] ?? '-' }}
                            </td>

                            {{-- Kolom Jumat --}}
                            @php
                                $cellJumat = $matriksKelasData['Jumat'][$jam] ?? null;
                            @endphp
                            @if($jam === 1 && !$cellJumat)
                                <td class="matrix-cell-filled" style="border-left-color: #059669;">
                                    <div style="font-weight: 800; color: #065f46; font-size: 12px;">
                                        <i class="fa-solid fa-mosque"></i> Pembiasaan Hari Jumat
                                    </div>
                                    <div style="font-size: 11px; color: #047857;">(Sholat Dhuha / Literasi)</div>
                                </td>
                            @elseif($cellJumat)
                                <td class="matrix-cell-filled" style="border-left-color: #7c3aed;">
                                    <div style="font-weight: 800; color: #581c87; font-size: 12.5px;">
                                        {{ $cellJumat->mapel->nama_mapel ?? 'Mapel' }}
                                    </div>
                                    <div style="font-size: 11.5px; color: #334155; font-weight: 600; margin-top: 2px;">
                                        <i class="fa-solid fa-chalkboard-user"></i> {{ $cellJumat->guru->nama_guru ?? '-' }}
                                    </div>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        <i class="fa-solid fa-door-open"></i> {{ $cellJumat->ruangan->nama_ruangan ?? 'R. Kelas' }}
                                    </div>
                                </td>
                            @else
                                <td class="matrix-cell-empty">-</td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- VIEW 3: MATRIKS GURU --}}
    @if($viewMode === 'matriks_guru')
    <div class="matrix-card">
        <div class="matrix-header-box">
            <div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-user-tie" style="color: #2563eb;"></i>
                    Matriks Jadwal Mengajar Guru: <span style="color: #2563eb;">{{ $selectedGuruObj->nama_guru ?? 'Pilih Guru' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    NIP: {{ $selectedGuruObj->nip ?? '-' }} | Beban Mengajar &amp; Ruang KBM Terjadwal
                </div>
            </div>

            <div class="matrix-controls-form">
                <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    <input type="hidden" name="view_mode" value="matriks_guru">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; white-space: nowrap;">Pilih Guru:</label>
                    <select name="selected_guru" class="form-control-filter" onchange="this.form.submit()" style="width: auto; min-width: 200px; height: 36px; flex: 1;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($selectedGuru == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="matrix-scroll-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Geser tabel ke samping untuk melihat seluruh jadwal mengajar mingguan
        </div>

        <div class="table-scroll-wrapper">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Jam</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                    </tr>
                </thead>
                <tbody>
                    @for($jam = 1; $jam <= $maxJamGuru; $jam++)
                        <tr>
                            <td style="text-align: center; font-weight: 800; background: #f8fafc;">Jam ke-{{ $jam }}</td>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                @php
                                    $cell = $matriksGuruData[$day][$jam] ?? null;
                                @endphp
                                @if($cell)
                                    <td class="matrix-cell-filled" style="border-left-color: #059669;">
                                        <div style="font-weight: 800; color: #065f46; font-size: 12.5px;">
                                            <i class="fa-solid fa-graduation-cap"></i> {{ $cell->kelas->nama_kelas ?? 'Kelas' }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #1e293b; font-weight: 700; margin-top: 2px;">
                                            {{ $cell->mapel->nama_mapel ?? 'Mapel' }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <i class="fa-solid fa-door-open"></i> {{ $cell->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                                        </div>
                                    </td>
                                @else
                                    <td class="matrix-cell-empty">-</td>
                                @endif
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

{{-- MODAL DETAIL JADWAL --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box" style="max-width: 520px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div class="modal-header" style="background: #2563eb; color: #ffffff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px; color: #ffffff;">
                <i class="fa-solid fa-circle-info"></i> Detail Jadwal Pelajaran
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()" style="color: #ffffff; background: none; border: none; font-size: 18px; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body" style="padding: 20px;">
            {{-- Top Badge Card --}}
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span id="det_badge_hari" class="day-badge day-Senin" style="font-size: 13px; font-weight: 800; padding: 4px 12px; border-radius: 8px;">Senin</span>
                    <span id="det_badge_jam" style="font-weight: 800; color: #1d4ed8; font-size: 13.5px;">Jam Ke-1</span>
                </div>
                <div id="det_badge_waktu" style="font-size: 12px; font-weight: 700; color: #2563eb; background: #ffffff; border: 1px solid #bfdbfe; padding: 4px 10px; border-radius: 8px;">
                    <i class="fa-regular fa-clock"></i> 07:00 – 07:40 WIB
                </div>
            </div>

            <table style="width: 100%; font-size: 13px; border-collapse: collapse; word-break: break-word;">
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b; width: 38%;"><i class="fa-solid fa-graduation-cap" style="color: #2563eb; width: 18px;"></i> Kelas Target</td>
                    <td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_kelas">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;"><i class="fa-solid fa-book-open" style="color: #2563eb; width: 18px;"></i> Mata Pelajaran</td>
                    <td style="padding: 10px; font-weight: 800; color: #2563eb;" id="det_mapel">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;"><i class="fa-solid fa-barcode" style="color: #64748b; width: 18px;"></i> Kode Mapel</td>
                    <td style="padding: 10px; font-weight: 700; color: #475569;" id="det_kode_mapel">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;"><i class="fa-solid fa-chalkboard-user" style="color: #10b981; width: 18px;"></i> Guru Pengampu</td>
                    <td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_guru">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;"><i class="fa-solid fa-id-card" style="color: #64748b; width: 18px;"></i> NIP Guru</td>
                    <td style="padding: 10px; font-weight: 700; color: #475569;" id="det_nip">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;"><i class="fa-solid fa-door-open" style="color: #f59e0b; width: 18px;"></i> Ruangan Belajar</td>
                    <td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_ruangan">-</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailModal()" style="padding: 8px 18px; font-size: 13px; font-weight: 700; border-radius: 8px;">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL CETAK --}}
<div class="modal-overlay" id="modalCetak">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-print" style="color: #0f172a;"></i> Pilihan Cetak Jadwal Pelajaran</h3>
            <button type="button" class="modal-close-btn" onclick="closeCetakModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <a href="{{ route('waka-kurikulum.jadwal.print', request()->all()) }}" target="_blank" class="btn-action btn-primary" style="padding: 12px; justify-content: center; text-decoration: none;">
                    <i class="fa-solid fa-table-list"></i> Cetak Master Jadwal (Sesuai Filter)
                </a>

                <div style="border-top: 1px solid #e2e8f0; padding-top: 14px;">
                    <label style="font-size: 13px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Cetak Matriks Jadwal Per Kelas:</label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <select id="cetakKelasSelect" class="modal-select" style="flex: 1; min-width: 160px;">
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-action btn-emerald" onclick="cetakPerKelas()" style="white-space: nowrap; flex-shrink: 0;">
                            <i class="fa-solid fa-print"></i> Cetak Kelas
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeCetakModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openDetailModalFromDataset(btn) {
        const hari = btn.getAttribute('data-hari') || '-';
        const jamKe = btn.getAttribute('data-jam-ke') || '-';
        const waktu = btn.getAttribute('data-waktu') || '-';
        const kelas = btn.getAttribute('data-kelas') || '-';
        const mapel = btn.getAttribute('data-mapel') || '-';
        const kodeMapel = btn.getAttribute('data-kode-mapel') || '-';
        const guru = btn.getAttribute('data-guru') || '-';
        const nip = btn.getAttribute('data-nip') || '-';
        const ruangan = btn.getAttribute('data-ruangan') || 'Kelas Reguler';

        const badgeHari = document.getElementById('det_badge_hari');
        if (badgeHari) {
            badgeHari.textContent = hari;
            badgeHari.className = 'day-badge day-' + hari;
        }
        const badgeJam = document.getElementById('det_badge_jam');
        if (badgeJam) badgeJam.textContent = jamKe;
        const badgeWaktu = document.getElementById('det_badge_waktu');
        if (badgeWaktu) badgeWaktu.innerHTML = `<i class="fa-regular fa-clock"></i> ${waktu}`;

        document.getElementById('det_kelas').textContent = kelas;
        document.getElementById('det_mapel').textContent = mapel;
        document.getElementById('det_kode_mapel').textContent = (kodeMapel && kodeMapel !== '-') ? kodeMapel : '-';
        document.getElementById('det_guru').textContent = guru;
        document.getElementById('det_nip').textContent = (nip && nip !== '-') ? nip : 'NIP: -';
        document.getElementById('det_ruangan').textContent = ruangan;

        document.getElementById('modalDetail').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetail').style.display = 'none';
    }

    function openCetakModal() {
        document.getElementById('modalCetak').style.display = 'flex';
    }

    function closeCetakModal() {
        document.getElementById('modalCetak').style.display = 'none';
    }

    function cetakPerKelas() {
        const idKelas = document.getElementById('cetakKelasSelect').value;
        if (idKelas) {
            window.open('/waka-kurikulum/jadwal/print-kelas/' + idKelas, '_blank');
        }
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection

