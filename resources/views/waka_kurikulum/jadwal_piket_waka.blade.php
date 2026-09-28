@extends('layouts.waka_kurikulum')

@section('title', 'Jadwal Piket Waka — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Teacher Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .jadwal-waka-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .page-main-title {
        font-size: 23px;
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

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .btn-action-excel {
        background: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .btn-action-excel:hover {
        background: #10b981;
        color: #ffffff;
    }

    .btn-action-print {
        background: #f8fafc;
        color: #334155;
        border-color: #cbd5e1;
    }
    .btn-action-print:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-action-primary {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    }
    .btn-action-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-action-import {
        background: #f5f3ff;
        color: #7c3aed;
        border-color: #ddd6fe;
        box-shadow: 0 2px 6px rgba(124, 58, 237, 0.12);
    }
    .btn-action-import:hover {
        background: #7c3aed;
        color: #ffffff;
    }

    .btn-action-danger {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .btn-action-danger:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* Filter & Summary Box */
    .filter-summary-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .month-filter-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .selector-form-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .selector-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-select-filter {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .form-select-filter:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Statistics Grid */
    .stat-counters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 12px;
    }

    .stat-card-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    .stat-card-item:hover {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .stat-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .stat-meta-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-meta-value {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .stat-meta-sub {
        font-size: 11px;
        color: #16a34a;
        font-weight: 700;
    }

    /* Table Toolbar */
    .table-toolbar-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 12px;
    }

    .table-search-wrapper {
        position: relative;
        min-width: 260px;
        max-width: 360px;
        flex: 1;
    }

    .table-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }

    .table-search-input {
        width: 100%;
        padding: 8px 32px 8px 34px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        font-size: 12.5px;
        font-weight: 600;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }
    .table-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .btn-clear-search {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 12px;
        display: none;
    }
    .btn-clear-search:hover {
        color: #ef4444;
    }

    /* Table Container */
    .table-card-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-responsive-box {
        width: 100%;
        overflow-x: auto;
    }

    .table-piket-waka {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .table-piket-waka thead th {
        background: #f8fafc;
        color: #334155;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 2px solid #e2e8f0;
        border-right: 1px solid #f1f5f9;
        text-align: left;
        white-space: nowrap;
    }

    .table-piket-waka tbody td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f8fafc;
        vertical-align: middle;
        color: #1e293b;
    }

    .table-piket-waka tbody tr:hover {
        background: #f8fafc;
    }

    .day-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .day-senin { background: #dbeafe; color: #1e40af; }
    .day-selasa { background: #e0e7ff; color: #3730a3; }
    .day-rabu { background: #fef3c7; color: #92400e; }
    .day-kamis { background: #f3e8ff; color: #6b21a8; }
    .day-jumat { background: #dcfce7; color: #166534; }

    .teacher-select-box {
        width: 100%;
        min-width: 280px;
    }

    .form-control-table {
        width: 100%;
        padding: 7px 10px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        box-sizing: border-box;
    }
    .form-control-table:focus {
        border-color: #2563eb;
    }

    /* Modal Styles */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 1060;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 540px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalScaleUp 0.2s ease;
    }

    @keyframes modalScaleUp {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body-custom {
        padding: 20px;
    }

    .modal-footer-custom {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .dropzone-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 28px 16px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .dropzone-area.dragover {
        border-color: #7c3aed;
        background: #f5f3ff;
    }

    /* Floating Bottom Action Bar */
    .bottom-save-bar {
        position: sticky;
        bottom: 16px;
        z-index: 90;
        background: #ffffff;
        border-radius: 14px;
        padding: 12px 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Select2 overrides */
    .select2-container--default .select2-selection--single {
        height: 36px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 3px 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px;
    }

    .m-idx-badge,
    .m-day-badge,
    .m-row-actions,
    .m-field-label {
        display: none;
    }

    /* ═══════════════════════════════════════════════════════════════════ */
    /* ─── RESPONSIVE MEDIA QUERIES (MOBILE / HP OPTIMIZATION) ─────────── */
    /* ═══════════════════════════════════════════════════════════════════ */
    @media (max-width: 1200px) {
        .stat-counters-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .jadwal-waka-container {
            gap: 14px;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }

        /* Page Header */
        .page-header-box {
            padding: 16px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            box-sizing: border-box !important;
        }

        .page-main-title {
            font-size: 18px !important;
        }

        .page-sub-title {
            font-size: 12px !important;
        }

        .header-actions-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .btn-action-custom {
            width: 100% !important;
            justify-content: center !important;
            padding: 9px 10px !important;
            font-size: 11.5px !important;
            box-sizing: border-box !important;
        }

        /* Filter Summary Card */
        .filter-summary-card {
            padding: 14px !important;
            border-radius: 14px !important;
            gap: 12px !important;
            box-sizing: border-box !important;
        }

        .month-filter-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            padding-bottom: 12px !important;
        }

        .selector-form-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .selector-label {
            grid-column: 1 / -1 !important;
            margin-bottom: 2px !important;
        }

        .form-select-filter {
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        .selector-form-group .btn-action-custom {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 8px !important;
        }

        /* 4 Stat Cards */
        .stat-counters-row {
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .stat-card-item {
            padding: 10px 10px !important;
            gap: 8px !important;
            border-radius: 12px !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        .stat-card-icon {
            width: 36px !important;
            height: 36px !important;
            font-size: 16px !important;
            border-radius: 10px !important;
            flex-shrink: 0 !important;
        }

        .stat-meta-title {
            font-size: 10px !important;
            line-height: 1.2 !important;
            word-break: break-word !important;
        }

        .stat-meta-value {
            font-size: 16px !important;
            line-height: 1.2 !important;
        }

        .stat-meta-sub {
            font-size: 9.5px !important;
            line-height: 1.2 !important;
            word-break: break-word !important;
        }

        /* Table Toolbar */
        .table-toolbar-box {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            margin-bottom: 12px !important;
        }

        .table-toolbar-box > div:first-child {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .table-search-wrapper {
            min-width: 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-search-input {
            padding: 8px 30px 8px 32px !important;
            font-size: 12px !important;
        }

        #filterStatusSelect {
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        .table-toolbar-box .btn-action-custom {
            width: 100% !important;
            justify-content: center !important;
            padding: 8px !important;
        }

        /* ─── TABLE TO MOBILE CARDS TRANSFORMATION ─── */
        .table-card-container {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            overflow: visible !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-responsive-box {
            overflow: visible !important;
            width: 100% !important;
        }

        .table-piket-waka {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .table-piket-waka thead {
            display: none !important;
        }

        .table-piket-waka tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        .schedule-row {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 14px !important;
            padding: 12px 14px !important;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .td-no, 
        .td-day, 
        .td-actions-desktop {
            display: none !important;
        }

        .td-date {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 0 10px 0 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-right: none !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .m-date-header-left {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            min-width: 0 !important;
        }

        .m-idx-badge {
            display: inline-flex !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            color: #2563eb !important;
            background: #eff6ff !important;
            border: 1px solid #bfdbfe !important;
            padding: 2px 7px !important;
            border-radius: 6px !important;
        }

        .m-day-badge {
            display: inline-flex !important;
        }

        .m-row-actions {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            flex-shrink: 0 !important;
        }

        .m-row-actions .btn-action-custom {
            padding: 6px 10px !important;
            font-size: 11.5px !important;
            border-radius: 8px !important;
        }

        .td-teacher, 
        .td-meta, 
        .td-notes {
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
            padding: 0 !important;
            border: none !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .m-field-label {
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.03em !important;
        }

        .teacher-select-box {
            min-width: 100% !important;
            width: 100% !important;
        }

        .m-meta-box {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 8px 10px !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .form-control-table {
            font-size: 12px !important;
            padding: 8px 10px !important;
            border-radius: 8px !important;
        }

        /* Sticky Bottom Action Bar */
        .bottom-save-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            padding: 12px 14px !important;
            bottom: 8px !important;
            border-radius: 12px !important;
            box-sizing: border-box !important;
        }

        .bottom-save-bar > div:last-child {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .bottom-save-bar .btn-action-custom {
            width: 100% !important;
            justify-content: center !important;
            padding: 9px 10px !important;
            font-size: 12px !important;
            box-sizing: border-box !important;
        }

        /* Modals */
        .modal-backdrop-custom {
            padding: 10px !important;
        }

        .modal-card {
            width: 100% !important;
            max-width: 100% !important;
            max-height: 94vh !important;
            border-radius: 14px !important;
            margin: auto !important;
        }

        .modal-header-custom {
            padding: 12px 14px !important;
        }

        .modal-body-custom {
            padding: 14px !important;
        }

        .modal-footer-custom {
            padding: 12px 14px !important;
            flex-direction: row !important;
            gap: 8px !important;
        }

        .modal-footer-custom .btn-action-custom {
            flex: 1 1 auto !important;
            justify-content: center !important;
            padding: 9px 10px !important;
            font-size: 12px !important;
        }
    }

    @media (max-width: 480px) {
        .stat-counters-row {
            grid-template-columns: 1fr 1fr !important;
            gap: 6px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="jadwal-waka-container">

    <!-- Page Header & Action Buttons -->
    <div class="page-header-box">
        <div>
            <div class="page-main-title">
                Jadwal Piket Waka
            </div>
            <div class="page-sub-title">
                Atur dan tugaskan guru menjadi Piket Waka per hari kerja dalam satu bulan. Guru yang ditugaskan otomatis terhubung ke Form Dispensasi Siswa &amp; ChatBot WhatsApp.
            </div>
        </div>

        <div class="header-actions-group">
            <button type="button" onclick="openImportModal()" class="btn-action-custom btn-action-import" title="Import Jadwal dari File Word, PDF, Excel, CSV">
                <i class="fa-solid fa-file-import"></i>
                <span>Import Jadwal</span>
            </button>
            <a href="{{ route('waka-kurikulum.jadwal-piket-waka.export', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn-action-custom btn-action-excel" title="Ekspor ke CSV">
                <i class="fa-solid fa-file-csv"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('waka-kurikulum.jadwal-piket-waka.print', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" target="_blank" class="btn-action-custom btn-action-print" title="Cetak Lembar Jadwal Piket Waka">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Jadwal</span>
            </a>
            <button type="button" onclick="openResetModal()" class="btn-action-custom btn-action-danger" title="Kosongkan jadwal bulan ini">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset Bulan Ini</span>
            </button>
        </div>
    </div>

    <!-- Filter & Statistics Card -->
    <div class="filter-summary-card">
        <!-- Month & Year Filter Form -->
        <div class="month-filter-row">
            <form id="filterBulanTahunForm" action="{{ route('waka-kurikulum.jadwal-piket-waka') }}" method="GET" class="selector-form-group">
                <div class="selector-label">
                    <i class="fa-solid fa-calendar-days text-blue-600"></i>
                    <span>Pilih Periode:</span>
                </div>
                <select name="bulan" class="form-select-filter" onchange="this.form.submit()">
                    @foreach($daftarBulan as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ $selectedBulan == $mNum ? 'selected' : '' }}>
                            {{ $mName }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun" class="form-select-filter" onchange="this.form.submit()">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $selectedTahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
                <a href="{{ route('waka-kurikulum.jadwal-piket-waka', ['bulan' => date('n'), 'tahun' => date('Y')]) }}" class="btn-action-custom btn-action-print" style="padding: 7px 12px; font-size: 11.5px;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Bulan Sekarang
                </a>
            </form>

            <div style="font-size: 12.5px; color: #64748b; font-weight: 600;">
                Periode Aktif: <strong style="color: #0f172a;">{{ $daftarBulan[$selectedBulan] ?? $selectedBulan }} {{ $selectedTahun }}</strong>
            </div>
        </div>

        <!-- Statistics Badges -->
        <div class="stat-counters-row">
            <div class="stat-card-item">
                <div class="stat-card-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div>
                    <div class="stat-meta-title">Hari Kerja</div>
                    <div class="stat-meta-value">{{ $totalHariKerja }} Hari</div>
                    <div style="font-size: 10.5px; color: #64748b;">Senin - Jumat</div>
                </div>
            </div>

            <div class="stat-card-item">
                <div class="stat-card-icon" style="background: #ecfdf5; color: #059669;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="stat-meta-title">Hari Terisi</div>
                    <div class="stat-meta-value" id="statTerisiValue">{{ $totalTerisi }} Hari</div>
                    <div class="stat-meta-sub" id="statKeterisianPercent">{{ $persenKeterisian }}% Keterisian</div>
                </div>
            </div>

            <div class="stat-card-item">
                <div class="stat-card-icon" style="background: #fff7ed; color: #ea580c;">
                    <div style="font-size: 14px; font-weight: 800;">!</div>
                </div>
                <div>
                    <div class="stat-meta-title">Belum Terisi</div>
                    <div class="stat-meta-value" id="statBelumTerisiValue">{{ $totalBelumTerisi }} Hari</div>
                    <div style="font-size: 10.5px; color: #ea580c; font-weight: 600;">Perlu penugasan</div>
                </div>
            </div>

            <div class="stat-card-item">
                <div class="stat-card-icon" style="background: #f5f3ff; color: #7c3aed;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="stat-meta-title">Guru Bertugas</div>
                    <div class="stat-meta-value" id="statGuruValue">{{ $totalGuruTerlibat }} Guru</div>
                    <div style="font-size: 10.5px; color: #64748b;" id="statGuruSub">Terjadwal Piket Waka</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Schedule Form -->
    <form id="formSimpanJadwalWaka" action="{{ route('waka-kurikulum.jadwal-piket-waka.store') }}" method="POST">
        @csrf
        <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
        <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

        <!-- Table Toolbar: Search & Filter -->
        <div class="table-toolbar-box">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1;">
                <div class="table-search-wrapper">
                    <i class="fa-solid fa-magnifying-glass table-search-icon"></i>
                    <input type="text" id="inputSearchSchedule" class="table-search-input" placeholder="Cari hari, tanggal, atau nama guru piket..." oninput="handleTableSearch(this.value)">
                    <button type="button" id="btnClearSearch" class="btn-clear-search" onclick="clearTableSearch()">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>

                <select id="filterStatusSelect" class="form-select-filter" style="font-size: 12px; padding: 7px 10px;" onchange="handleFilterStatus(this.value)">
                    <option value="all">Semua Status ({{ $totalHariKerja }})</option>
                    <option value="terisi">Hanya Terisi ({{ $totalTerisi }})</option>
                    <option value="kosong">Hanya Kosong ({{ $totalBelumTerisi }})</option>
                </select>

                <button type="button" onclick="resetTableFilters()" class="btn-action-custom btn-action-print" style="padding: 7px 12px; font-size: 11.5px;">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Reset Filter
                </button>
            </div>

            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                Menampilkan <strong id="visibleRowCount" style="color: #0f172a;">{{ count($workDays) }}</strong> dari {{ count($workDays) }} hari kerja
            </div>
        </div>

        <!-- Schedule Table -->
        <div class="table-card-container">
            <div class="table-responsive-box">
                <table class="table-piket-waka" id="tableJadwalPiketWaka">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">No</th>
                            <th style="width: 90px; text-align: center;">Hari</th>
                            <th style="width: 140px;">Tanggal</th>
                            <th style="min-width: 280px;">Guru Piket Waka (Ditugaskan)</th>
                            <th style="width: 200px;">NIP &amp; Kontak WhatsApp</th>
                            <th style="min-width: 200px;">Catatan Penugasan</th>
                            <th style="width: 110px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workDays as $idx => $wd)
                            @php
                                $tgl = $wd['tanggal'];
                                $item = $jadwalList[$tgl] ?? null;
                                $assignedGuruId = $item ? $item->id_guru : null;
                                $assignedUser = $item ? $item->user : null;
                                $assignedGuru = $item ? $item->guru : null;
                                $dayClass = 'day-' . strtolower($wd['hari']);
                            @endphp
                            <tr class="schedule-row" 
                                id="row-{{ $tgl }}"
                                data-tanggal="{{ $tgl }}" 
                                data-hari="{{ strtolower($wd['hari']) }}"
                                data-status="{{ $assignedGuruId ? 'terisi' : 'kosong' }}">
                                <td class="td-no" style="text-align: center; font-weight: 700; color: #64748b;">
                                    {{ $idx + 1 }}
                                </td>
                                <td class="td-day" style="text-align: center;">
                                    <span class="day-badge {{ $dayClass }}">{{ $wd['hari'] }}</span>
                                </td>
                                <td class="td-date" style="white-space: nowrap;">
                                    <div class="m-date-header-left">
                                        <span class="m-idx-badge">#{{ $idx + 1 }}</span>
                                        <span class="day-badge {{ $dayClass }} m-day-badge">{{ $wd['hari'] }}</span>
                                        <div class="m-date-wrapper">
                                            <div style="font-weight: 800; font-size: 13px; color: #0f172a; line-height: 1.3;">{{ $wd['tanggal_format'] }}</div>
                                            <div style="font-size: 11.5px; color: #64748b; font-weight: 600; line-height: 1.3; margin-top: 1px;">{{ $wd['tanggal_indo'] }}</div>
                                        </div>
                                    </div>
                                    <div class="m-row-actions">
                                        <button type="button" 
                                                class="btn-action-custom btn-action-danger" 
                                                style="padding: 5px 8px; font-size: 11px;" 
                                                title="Kosongkan baris ini"
                                                onclick="clearRowSelection('{{ $tgl }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn-action-custom btn-action-primary" 
                                                style="padding: 5px 8px; font-size: 11px;" 
                                                title="Simpan baris ini saja"
                                                onclick="saveSingleRow('{{ $tgl }}', '{{ $item ? $item->id : '' }}')">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="td-teacher">
                                    <div class="m-field-label">
                                        <i class="fa-solid fa-user-shield" style="color:#2563eb;"></i> Guru Piket Waka (Ditugaskan)
                                    </div>
                                    <div class="teacher-select-box">
                                        <select name="jadwal[{{ $tgl }}][id_guru]" 
                                                id="select-{{ $tgl }}"
                                                class="form-control-table select2-teacher guru-select-input" 
                                                data-tanggal="{{ $tgl }}"
                                                onchange="handleRowTeacherChange('{{ $tgl }}', this)">
                                            <option value="">-- Belum Ditugaskan (Kosong) --</option>
                                            @foreach($gurus as $g)
                                                <option value="{{ $g->id_guru }}" 
                                                        data-nip="{{ $g->nip ?? '-' }}"
                                                        data-nohp="{{ $g->user->no_hp ?? ($g->no_hp ?? '-') }}"
                                                        {{ $assignedGuruId == $g->id_guru ? 'selected' : '' }}>
                                                    {{ $g->nama_guru }} @if($g->nip) ({{ $g->nip }}) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="td-meta">
                                    <div class="m-field-label">
                                        <i class="fa-solid fa-id-card" style="color:#64748b;"></i> NIP &amp; Kontak WhatsApp
                                    </div>
                                    <div class="m-meta-box">
                                        <div id="meta-nip-{{ $tgl }}" style="font-weight: 700; font-size: 12px; color: #1e293b;">
                                            {{ $assignedGuru && $assignedGuru->nip ? 'NIP. ' . $assignedGuru->nip : ($assignedUser && $assignedUser->nip ? 'NIP. ' . $assignedUser->nip : '-') }}
                                        </div>
                                        <div id="meta-nohp-{{ $tgl }}" style="font-size: 11.5px; color: #059669; font-weight: 600; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                            <i class="fa-brands fa-whatsapp"></i>
                                            <span>{{ $assignedUser && $assignedUser->no_hp ? $assignedUser->no_hp : ($assignedGuru && $assignedGuru->no_hp ? $assignedGuru->no_hp : 'No HP Belum Ada') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-notes">
                                    <div class="m-field-label">
                                        <i class="fa-solid fa-pen-to-square" style="color:#64748b;"></i> Catatan Penugasan
                                    </div>
                                    <input type="text" 
                                           name="jadwal[{{ $tgl }}][catatan]" 
                                           id="catatan-{{ $tgl }}"
                                           value="{{ $item ? $item->catatan : ('Piket Waka ' . $wd['hari']) }}" 
                                           class="form-control-table" 
                                           placeholder="Tuliskan catatan...">
                                </td>
                                <td class="td-actions-desktop" style="text-align: center;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                        <button type="button" 
                                                class="btn-action-custom btn-action-danger" 
                                                style="padding: 5px 8px; font-size: 11px;" 
                                                title="Kosongkan baris ini"
                                                onclick="clearRowSelection('{{ $tgl }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn-action-custom btn-action-primary" 
                                                style="padding: 5px 8px; font-size: 11px;" 
                                                title="Simpan baris ini saja"
                                                onclick="saveSingleRow('{{ $tgl }}', '{{ $item ? $item->id : '' }}')">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: #64748b;">
                                    Tidak ada hari kerja pada bulan yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sticky Bottom Bar -->
        <div class="bottom-save-bar">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-info text-blue-600 fa-lg"></i>
                <span style="font-size: 12.5px; color: #334155; font-weight: 600;">
                    Setelah mengatur atau mengimpor guru piket waka, klik tombol <strong>Simpan Seluruh Jadwal</strong> untuk menyimpan perubahan.
                </span>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('waka-kurikulum.jadwal-piket-waka', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn-action-custom btn-action-print" style="padding: 9px 18px;">
                    <i class="fa-solid fa-rotate-left"></i> Batal / Muat Ulang
                </a>
                <button type="submit" class="btn-action-custom btn-action-primary" style="padding: 9px 24px; font-size: 13.5px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Seluruh Jadwal Piket Waka
                </button>
            </div>
        </div>
    </form>

</div>

<!-- Modal Import Jadwal dari File -->
<div id="modalImportJadwal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header-custom" style="background: #f5f3ff; border-bottom: 1px solid #ddd6fe;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: #7c3aed; color: #ffffff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                    <i class="fa-solid fa-file-import"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #0f172a;">Import Jadwal Piket Waka</h3>
                    <p style="margin: 0; font-size: 11.5px; color: #64748b;">Word (.docx, .doc), PDF (.pdf), Excel (.xlsx, .xls), CSV (.csv)</p>
                </div>
            </div>
            <i class="fa-solid fa-xmark" onclick="closeImportModal()" style="cursor: pointer; font-size: 18px; color: #64748b;"></i>
        </div>

        <form id="formImportFile" enctype="multipart/form-data" onsubmit="handleImportSubmit(event)">
            @csrf
            <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
            <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

            <div class="modal-body-custom">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 10px 14px; border-radius: 10px; font-size: 12px; margin-bottom: 16px;">
                    <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i>
                    Sistem otomatis membaca kolom/baris jadwal Piket Waka pada file, mencocokkan guru ke master sekolah, dan langsung memasukkan data ke tabel jadwal bulan <strong>{{ $daftarBulan[$selectedBulan] ?? $selectedBulan }} {{ $selectedTahun }}</strong>.
                </div>

                <div class="dropzone-area" id="dropzoneArea" 
                     onclick="document.getElementById('fileJadwalInput').click()"
                     ondragover="handleDragOver(event)" 
                     ondragleave="handleDragLeave(event)" 
                     ondrop="handleFileDrop(event)">
                    
                    <input type="file" id="fileJadwalInput" name="file_jadwal" accept=".docx,.doc,.pdf,.xlsx,.xls,.csv,.txt" style="display: none;" onchange="handleFileChosen(this)">

                    <div id="dropzonePrompt">
                        <div style="font-size: 38px; color: #7c3aed; margin-bottom: 8px;">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #1e293b;">
                            Pilih file atau seret file ke sini
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">
                            Mendukung file SK/Jadwal Piket Bulanan (.pdf, .docx, .xlsx, .csv)
                        </div>
                    </div>

                    <div id="dropzoneSelectedFile" style="display: none;">
                        <div id="selectedFileIcon" style="font-size: 36px; margin-bottom: 6px;"></div>
                        <div id="selectedFileName" style="font-size: 13px; font-weight: 800; color: #0f172a;"></div>
                        <div id="selectedFileSize" style="font-size: 11px; color: #64748b; margin-top: 2px;"></div>
                        <button type="button" onclick="clearSelectedFile(event)" style="margin-top: 8px; background: #fee2e2; color: #dc2626; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Ganti File
                        </button>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="importLoadingState" style="display: none; text-align: center; padding: 18px 0;">
                    <i class="fa-solid fa-spinner fa-spin fa-2xl" style="color: #7c3aed;"></i>
                    <div style="font-size: 13px; font-weight: 700; color: #1e293b; margin-top: 10px;">
                        Membaca dan mencocokkan data jadwal...
                    </div>
                    <div style="font-size: 11.5px; color: #64748b;">Mohon tunggu beberapa saat</div>
                </div>

                <!-- Result Box -->
                <div id="importResultBox" style="display: none; margin-top: 14px;"></div>
            </div>

            <div class="modal-footer-custom">
                <button type="button" onclick="closeImportModal()" class="btn-action-custom btn-action-print">
                    Batal
                </button>
                <button type="submit" id="btnSubmitImport" class="btn-action-custom btn-action-import" style="background: #7c3aed; color: #ffffff;">
                    <i class="fa-solid fa-bolt"></i> Proses &amp; Masukkan ke Tabel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Jadwal Bulan Ini -->
<div id="modalResetJadwal" class="modal-backdrop-custom">
    <div class="modal-card" style="max-width: 440px;">
        <div class="modal-header-custom" style="background: #fef2f2; border-bottom: 1px solid #fee2e2;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: #ef4444; color: #ffffff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #991b1b;">Konfirmasi Reset Jadwal</h3>
            </div>
            <i class="fa-solid fa-xmark" onclick="closeResetModal()" style="cursor: pointer; font-size: 18px; color: #64748b;"></i>
        </div>

        <form action="{{ route('waka-kurikulum.jadwal-piket-waka.reset') }}" method="POST">
            @csrf
            <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
            <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

            <div class="modal-body-custom" style="text-align: center; padding: 24px 20px;">
                <p style="font-size: 13.5px; color: #334155; line-height: 1.5; margin: 0;">
                    Apakah Anda yakin ingin mengosongkan seluruh penugasan Piket Waka untuk bulan <strong>{{ $daftarBulan[$selectedBulan] ?? $selectedBulan }} {{ $selectedTahun }}</strong>?
                </p>
                <div style="font-size: 12px; color: #ef4444; margin-top: 10px; font-weight: 600;">
                    Tindakan ini akan menghapus semua penugasan guru piket waka pada bulan tersebut.
                </div>
            </div>

            <div class="modal-footer-custom">
                <button type="button" onclick="closeResetModal()" class="btn-action-custom btn-action-print">
                    Batal
                </button>
                <button type="submit" class="btn-action-custom btn-action-danger">
                    <i class="fa-solid fa-trash-can"></i> Ya, Kosongkan Bulan Ini
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Init Select2 on each teacher dropdown
        $('.select2-teacher').select2({
            placeholder: "-- Pilih Guru Piket Waka --",
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            const tgl = $(this).attr('data-tanggal');
            if (tgl) {
                handleRowTeacherChange(tgl, this);
            }
        });
    });

    // ─────────────────────────────────────────────────────────────────────────
    // DYNAMIC STATS & ROW HANDLERS
    // ─────────────────────────────────────────────────────────────────────────

    function handleRowTeacherChange(tanggal, selectElem) {
        const selectedVal = $(selectElem).val();
        const row = document.getElementById('row-' + tanggal);
        const metaNip = document.getElementById('meta-nip-' + tanggal);
        const metaNohp = document.getElementById('meta-nohp-' + tanggal);

        if (selectedVal && selectedVal !== '') {
            const opt = $(selectElem).find('option:selected');
            const nip = opt.attr('data-nip') || '-';
            const nohp = opt.attr('data-nohp') || '-';

            if (metaNip) metaNip.innerText = (nip && nip !== '-') ? 'NIP. ' + nip : 'NIP. -';
            if (metaNohp) metaNohp.innerHTML = '<i class="fa-brands fa-whatsapp"></i> <span>' + (nohp && nohp !== '-' ? nohp : 'No HP Belum Ada') + '</span>';
            if (row) row.setAttribute('data-status', 'terisi');
        } else {
            if (metaNip) metaNip.innerText = '-';
            if (metaNohp) metaNohp.innerHTML = '<i class="fa-brands fa-whatsapp"></i> <span>No HP Belum Ada</span>';
            if (row) row.setAttribute('data-status', 'kosong');
        }

        updateDynamicStats();
    }

    function clearRowSelection(tanggal) {
        const select = $('#select-' + tanggal);
        select.val('').trigger('change');
        const catatan = document.getElementById('catatan-' + tanggal);
        if (catatan) catatan.value = '';
    }

    function saveSingleRow(tanggal, jadwalId) {
        const selectVal = $('#select-' + tanggal).val();
        const catatanVal = $('#catatan-' + tanggal).val();

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('tanggal', tanggal);
        formData.append('id_guru', selectVal || '');
        formData.append('catatan', catatanVal || '');

        const targetId = jadwalId || 'new';

        fetch("{{ url('waka-kurikulum/jadwal-piket-waka') }}/" + targetId, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Jadwal piket waka tanggal ' + tanggal + ' berhasil disimpan!');
            } else {
                alert('Gagal menyimpan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan koneksi saat menyimpan jadwal.');
        });
    }

    function updateDynamicStats() {
        const rows = document.querySelectorAll('.schedule-row');
        let terisiCount = 0;
        const guruSet = new Set();

        rows.forEach(r => {
            const sel = $(r).find('.guru-select-input');
            const val = sel.val();
            if (val && val !== '') {
                terisiCount++;
                guruSet.add(val);
                r.setAttribute('data-status', 'terisi');
            } else {
                r.setAttribute('data-status', 'kosong');
            }
        });

        const totalRows = rows.length;
        const belumTerisi = totalRows - terisiCount;
        const percent = totalRows > 0 ? ((terisiCount / totalRows) * 100).toFixed(1) : 0;

        const statTerisi = document.getElementById('statTerisiValue');
        const statBelum = document.getElementById('statBelumTerisiValue');
        const statPercent = document.getElementById('statKeterisianPercent');
        const statGuru = document.getElementById('statGuruValue');
        const statGuruSub = document.getElementById('statGuruSub');

        if (statTerisi) statTerisi.innerText = `${terisiCount} Hari`;
        if (statBelum) statBelum.innerText = `${belumTerisi} Hari`;
        if (statPercent) statPercent.innerText = `${percent}% Keterisian`;
        if (statGuru) statGuru.innerText = `${guruSet.size} Guru`;
        if (statGuruSub) statGuruSub.innerText = `${guruSet.size} Guru Terjadwal`;

        // Update dropdown filter option counts
        const optAll = document.querySelector('#filterStatusSelect option[value="all"]');
        const optTerisi = document.querySelector('#filterStatusSelect option[value="terisi"]');
        const optKosong = document.querySelector('#filterStatusSelect option[value="kosong"]');

        if (optAll) optAll.innerText = `Semua Status (${totalRows})`;
        if (optTerisi) optTerisi.innerText = `Hanya Terisi (${terisiCount})`;
        if (optKosong) optKosong.innerText = `Hanya Kosong (${belumTerisi})`;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SEARCH & FILTER SYSTEM
    // ─────────────────────────────────────────────────────────────────────────

    function handleTableSearch(keyword) {
        const btnClear = document.getElementById('btnClearSearch');
        if (btnClear) btnClear.style.display = keyword.trim() ? 'block' : 'none';
        applyTableFilters();
    }

    function clearTableSearch() {
        const input = document.getElementById('inputSearchSchedule');
        if (input) {
            input.value = '';
            input.focus();
        }
        const btnClear = document.getElementById('btnClearSearch');
        if (btnClear) btnClear.style.display = 'none';
        applyTableFilters();
    }

    function handleFilterStatus(status) {
        applyTableFilters();
    }

    function resetTableFilters() {
        const input = document.getElementById('inputSearchSchedule');
        if (input) input.value = '';
        const select = document.getElementById('filterStatusSelect');
        if (select) select.value = 'all';
        const btnClear = document.getElementById('btnClearSearch');
        if (btnClear) btnClear.style.display = 'none';
        applyTableFilters();
    }

    function applyTableFilters() {
        const searchVal = (document.getElementById('inputSearchSchedule')?.value || '').toLowerCase().trim();
        const statusVal = document.getElementById('filterStatusSelect')?.value || 'all';

        const rows = document.querySelectorAll('.schedule-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            const rowStatus = row.getAttribute('data-status');

            const matchesSearch = !searchVal || rowText.includes(searchVal);
            const matchesStatus = (statusVal === 'all') || (rowStatus === statusVal);

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countElem = document.getElementById('visibleRowCount');
        if (countElem) countElem.innerText = visibleCount;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // MODAL IMPORT SYSTEM (WORD, PDF, EXCEL, CSV)
    // ─────────────────────────────────────────────────────────────────────────

    function openImportModal() {
        const m = document.getElementById('modalImportJadwal');
        if (m) m.style.display = 'flex';
    }

    function closeImportModal() {
        const m = document.getElementById('modalImportJadwal');
        if (m) m.style.display = 'none';
    }

    function openResetModal() {
        const m = document.getElementById('modalResetJadwal');
        if (m) m.style.display = 'flex';
    }

    function closeResetModal() {
        const m = document.getElementById('modalResetJadwal');
        if (m) m.style.display = 'none';
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        const dz = document.getElementById('dropzoneArea');
        if (dz) dz.classList.add('dragover');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        const dz = document.getElementById('dropzoneArea');
        if (dz) dz.classList.remove('dragover');
    }

    function handleFileDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        const dz = document.getElementById('dropzoneArea');
        if (dz) dz.classList.remove('dragover');

        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            const file = e.dataTransfer.files[0];
            const fileInput = document.getElementById('fileJadwalInput');
            if (fileInput) {
                fileInput.files = e.dataTransfer.files;
            }
            displaySelectedFileInfo(file);
        }
    }

    function handleFileChosen(input) {
        if (input.files && input.files[0]) {
            displaySelectedFileInfo(input.files[0]);
        }
    }

    function displaySelectedFileInfo(file) {
        const prompt = document.getElementById('dropzonePrompt');
        const display = document.getElementById('dropzoneSelectedFile');
        const nameElem = document.getElementById('selectedFileName');
        const sizeElem = document.getElementById('selectedFileSize');
        const iconElem = document.getElementById('selectedFileIcon');

        if (prompt) prompt.style.display = 'none';
        if (display) display.style.display = 'block';
        if (nameElem) nameElem.innerText = file.name;

        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const sizeText = file.size > 1024 * 1024 ? `${sizeMB} MB` : `${sizeKB} KB`;
        if (sizeElem) sizeElem.innerText = `${sizeText} • Siap diimpor`;

        const ext = file.name.split('.').pop().toLowerCase();
        let iconHtml = '<i class="fa-solid fa-file"></i>';
        if (ext === 'pdf') {
            iconHtml = '<i class="fa-solid fa-file-pdf" style="color:#ef4444;"></i>';
        } else if (['docx', 'doc'].includes(ext)) {
            iconHtml = '<i class="fa-solid fa-file-word" style="color:#2563eb;"></i>';
        } else if (['xlsx', 'xls'].includes(ext)) {
            iconHtml = '<i class="fa-solid fa-file-excel" style="color:#10b981;"></i>';
        } else if (ext === 'csv') {
            iconHtml = '<i class="fa-solid fa-file-csv" style="color:#059669;"></i>';
        }
        if (iconElem) iconElem.innerHTML = iconHtml;
    }

    function clearSelectedFile(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const fileInput = document.getElementById('fileJadwalInput');
        if (fileInput) fileInput.value = '';

        const prompt = document.getElementById('dropzonePrompt');
        const display = document.getElementById('dropzoneSelectedFile');
        if (prompt) prompt.style.display = 'block';
        if (display) display.style.display = 'none';
    }

    function handleImportSubmit(e) {
        e.preventDefault();

        const fileInput = document.getElementById('fileJadwalInput');
        if (!fileInput || !fileInput.files || !fileInput.files[0]) {
            alert('Silakan pilih file jadwal (Word, PDF, Excel, atau CSV) terlebih dahulu!');
            return;
        }

        const form = document.getElementById('formImportFile');
        const formData = new FormData(form);

        const btnSubmit = document.getElementById('btnSubmitImport');
        const loading = document.getElementById('importLoadingState');
        const resultBox = document.getElementById('importResultBox');

        if (btnSubmit) btnSubmit.disabled = true;
        if (loading) loading.style.display = 'block';
        if (resultBox) {
            resultBox.style.display = 'none';
            resultBox.innerHTML = '';
        }

        fetch("{{ route('waka-kurikulum.jadwal-piket-waka.import') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (btnSubmit) btnSubmit.disabled = false;
            if (loading) loading.style.display = 'none';

            if (data.success) {
                const matrix = data.schedule_matrix || {};
                let populated = 0;

                for (const tgl in matrix) {
                    const rowData = matrix[tgl];
                    const idGuru = rowData.id_guru;
                    const select = $('#select-' + tgl);

                    if (select.length && idGuru) {
                        select.val(idGuru).trigger('change');
                        if (rowData.catatan) {
                            const catInput = document.getElementById('catatan-' + tgl);
                            if (catInput) catInput.value = rowData.catatan;
                        }
                        populated++;
                    }
                }

                updateDynamicStats();

                if (resultBox) {
                    resultBox.style.display = 'block';
                    resultBox.innerHTML = `
                        <div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:12px 16px; border-radius:12px; font-size:12.5px;">
                            <div style="font-weight:800; font-size:13.5px; margin-bottom:4px;">
                                <i class="fa-solid fa-circle-check" style="color:#10b981;"></i> File Berhasil Diproses!
                            </div>
                            <p style="margin:0 0 6px 0;">${data.message}</p>
                            <div style="font-size:11.5px; color:#047857;">
                                Sebanyak <strong>${populated}</strong> penugasan Piket Waka telah dimasukkan ke tabel. Jangan lupa klik <strong>'Simpan Seluruh Jadwal Piket Waka'</strong> di bagian bawah untuk menyimpan ke database.
                            </div>
                        </div>
                    `;
                }

                setTimeout(() => {
                    closeImportModal();
                }, 2200);

            } else {
                if (resultBox) {
                    resultBox.style.display = 'block';
                    resultBox.innerHTML = `
                        <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:12px; font-size:12.5px;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; margin-right:6px;"></i>
                            ${data.message || 'Gagal memproses file impor.'}
                        </div>
                    `;
                }
            }
        })
        .catch(err => {
            if (btnSubmit) btnSubmit.disabled = false;
            if (loading) loading.style.display = 'none';
            if (resultBox) {
                resultBox.style.display = 'block';
                resultBox.innerHTML = `
                    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:12px; font-size:12.5px;">
                        <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; margin-right:6px;"></i>
                        Terjadi kesalahan jaringan atau server saat memproses file.
                    </div>
                `;
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImportModal();
            closeResetModal();
        }
    });
</script>
@endsection
