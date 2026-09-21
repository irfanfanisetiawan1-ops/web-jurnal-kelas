@extends('layouts.admin')

@section('title', 'Tahun Ajaran — EDU JOURNAL')

@section('styles')
<style>
    /* Global Page Styling */
    .ta-page-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    /* Page Header */
    .ta-header-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .ta-title-area h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 5px 0;
        letter-spacing: -0.02em;
    }

    .ta-title-area p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
        margin: 0;
    }

    .ta-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-action-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .btn-action-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: #1e293b;
        border: 1px solid #1e293b;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(30, 41, 59, 0.2);
    }

    .btn-action-primary:hover {
        background: #0f172a;
        border-color: #0f172a;
        transform: translateY(-1px);
    }

    /* 5 KPI Metric Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }

    @media (max-width: 1200px) {
        .kpi-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .kpi-grid { grid-template-columns: 1fr; }
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 115px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: relative;
        transition: all 0.2s ease;
    }

    .kpi-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .kpi-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .kpi-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
    }

    .kpi-icon-wrapper {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .kpi-icon-blue { background: #eff6ff; color: #3b82f6; }
    .kpi-icon-slate { background: #f1f5f9; color: #64748b; }
    .kpi-icon-green { background: #ecfdf5; color: #10b981; }
    .kpi-icon-lock { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
    .kpi-icon-red { background: #fef2f2; color: #ef4444; }

    .kpi-value {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .kpi-subtext {
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .kpi-subtext.text-green { color: #059669; }
    .kpi-subtext.text-muted { color: #64748b; }
    .kpi-subtext.text-red { color: #ef4444; }

    /* Main Content Card */
    .ta-main-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Tabs Bar */
    .ta-tabs-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ta-nav-tabs {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .ta-tab-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 16px 4px;
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        transition: all 0.2s ease;
        position: relative;
    }

    .ta-tab-item:hover {
        color: #0f172a;
    }

    .ta-tab-item.active {
        color: #1e40af;
        border-bottom-color: #2563eb;
    }

    .ta-tab-badge {
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
    }

    .ta-tab-badge.badge-active {
        background: #dbeafe;
        color: #1e40af;
    }

    .ta-tab-badge.badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .ta-school-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    /* Filter & Search Bar */
    .ta-filter-bar {
        padding: 18px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .search-input-group {
        flex: 1;
        min-width: 260px;
        position: relative;
    }

    .search-input-group i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .search-input-group input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border 0.2s ease;
    }

    .search-input-group input:focus {
        border-color: #3b82f6;
        background: #ffffff;
    }

    .ta-select-filter {
        padding: 9px 34px 9px 14px;
        background: #f8fafc url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") no-repeat right 10px center/14px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        outline: none;
        cursor: pointer;
        appearance: none;
        min-width: 150px;
    }

    .ta-select-filter:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
    }

    .btn-search {
        padding: 9px 18px;
        background: #1e293b;
        border: 1px solid #1e293b;
        border-radius: 10px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-search:hover {
        background: #0f172a;
    }

    .btn-reset {
        padding: 9px 16px;
        background: #f59e0b;
        border: 1px solid #f59e0b;
        border-radius: 10px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-reset:hover {
        background: #d97706;
    }

    /* Bulk Action Bar (Floating) */
    .bulk-bar {
        background: #0f172a;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 12px 24px;
        font-size: 13px;
        font-weight: 600;
    }

    .bulk-bar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-bulk-danger {
        background: #ef4444;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-bulk-teal {
        background: #0d9488;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    /* Table Styling */
    .ta-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .ta-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .ta-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .ta-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }

    .ta-table tr:hover td {
        background-color: #fafbfc;
    }

    /* Column Specific Styles */
    .col-checkbox { width: 44px; text-align: center; }
    .col-no { width: 50px; text-align: center; font-weight: 700; color: #64748b; }

    .ta-name-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .ta-year-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .ta-period-sub {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    /* Semester Badges */
    .badge-semester {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0369a1;
        white-space: nowrap;
    }

    .badge-semester.sem-genap {
        background: #f1f5f9;
        color: #475569;
    }

    /* Status Badges */
    .badge-status-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: #ecfdf5;
        color: #059669;
    }

    .badge-status-active .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
    }

    .badge-status-inactive {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
    }

    /* Akses Jurnal Badges */
    .akses-jurnal-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .akses-jurnal-group.open {
        color: #0d9488;
    }

    .akses-jurnal-group.locked {
        color: #64748b;
    }

    .akses-jurnal-group i {
        font-size: 14px;
    }

    /* Action Buttons */
    .action-buttons-group {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-act-activate {
        padding: 6px 12px;
        background: #f0fdfa;
        border: 1px solid #99f6e4;
        border-radius: 8px;
        color: #0d9488;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-act-activate:hover {
        background: #ccfbf1;
        border-color: #5eead4;
        color: #0f766e;
    }

    .btn-act-detail {
        padding: 6px 12px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-act-detail:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-act-edit {
        padding: 6px 14px;
        background: #1e293d;
        border: 1px solid #1e293d;
        border-radius: 8px;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-act-edit:hover {
        background: #0f172a;
    }

    .btn-act-delete {
        width: 32px;
        height: 32px;
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #ef4444;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 13px;
    }

    .btn-act-delete:hover {
        background: #fee2e2;
        border-color: #fca5a5;
    }

    .btn-act-restore {
        padding: 6px 12px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        color: #059669;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-act-restore:hover {
        background: #d1fae5;
    }

    /* Table Footer & Pagination */
    .ta-table-footer {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ta-footer-info {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    /* Modal Overlay & Card */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 16px;
    }

    .modal-backdrop-custom.active {
        display: flex;
    }

    .modal-card-custom {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 620px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalFadeIn 0.25s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(10px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .btn-close-modal {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .btn-close-modal:hover {
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 20px 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .form-group-custom {
        margin-bottom: 16px;
    }

    .form-group-custom label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-group-custom label .req {
        color: #ef4444;
    }

    .form-control-custom {
        width: 100%;
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s;
        background: #ffffff;
    }

    .form-control-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    /* Month Selector Helper Box */
    .month-picker-container {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 14px;
    }

    .month-picker-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .month-picker-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 8px;
    }

    .month-select-sub {
        width: 100%;
        padding: 7px 10px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        background: #ffffff;
        outline: none;
    }

    .month-select-sub:focus {
        border-color: #2563eb;
    }

    .checkbox-switch-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .checkbox-switch-group input[type="checkbox"] {
        width: 17px;
        height: 17px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    .checkbox-switch-group span {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Detail Modal Elements */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .detail-item {
        background: #f8fafc;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .detail-item-full {
        grid-column: span 2;
        background: #f8fafc;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .detail-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .detail-val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
</style>
@endsection

@section('content')
<div class="ta-page-container">

    {{-- Page Header --}}
    <div class="ta-header-wrapper">
        <div class="ta-title-area">
            <h1>Tahun Ajaran</h1>
            <p>Kelola tahun ajaran dan semester aktif untuk kontrol pengisian jurnal guru dan jadwal pelajaran SMKN 1 Boyolangu.</p>
        </div>

        <div class="ta-header-actions">
            <a href="{{ route('admin.tahun-ajaran.export') }}" class="btn-action-outline" title="Unduh format rekap data tahun ajaran">
                <i class="fa-solid fa-file-export" style="color: #64748b;"></i>
                <span>Ekspor Rekap</span>
            </a>

            <button type="button" class="btn-action-primary" onclick="openCreateModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Tahun Ajaran</span>
            </button>
        </div>
    </div>

    {{-- 5 KPI Metric Cards --}}
    <div class="kpi-grid">
        {{-- Card 1: Periode Saat Ini --}}
        <div class="kpi-card">
            <div>
                <div class="kpi-card-header">
                    <span class="kpi-label">PERIODE SAAT INI</span>
                    <div class="kpi-icon-wrapper kpi-icon-blue">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ $activeTa ? $activeTa->tahun_ajaran . ' ' . $activeTa->semester : '2026/2027 Ganjil' }}</div>
            </div>
            <div class="kpi-subtext text-green">
                <span>●</span> Aktif Berjalan (SMKN 1 BOYOLANGU)
            </div>
        </div>

        {{-- Card 2: Total Data --}}
        <div class="kpi-card">
            <div>
                <div class="kpi-card-header">
                    <span class="kpi-label">TOTAL DATA</span>
                    <div class="kpi-icon-wrapper kpi-icon-slate">
                        <i class="fa-regular fa-clone"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ $totalData }}</div>
            </div>
            <div class="kpi-subtext text-muted">
                Semua Semester
            </div>
        </div>

        {{-- Card 3: Status Aktif --}}
        <div class="kpi-card">
            <div>
                <div class="kpi-card-header">
                    <span class="kpi-label">STATUS AKTIF</span>
                    <div class="kpi-icon-wrapper kpi-icon-green">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                </div>
                <div class="kpi-value" style="color: #059669;">{{ $totalAktif }}</div>
            </div>
            <div class="kpi-subtext text-green">
                <i class="fa-solid fa-check"></i> Sedang Berjalan
            </div>
        </div>

        {{-- Card 4: Arsip --}}
        <div class="kpi-card">
            <div>
                <div class="kpi-card-header">
                    <span class="kpi-label">ARSIP</span>
                    <div class="kpi-icon-wrapper kpi-icon-lock">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ $totalArsip }}</div>
            </div>
            <div class="kpi-subtext text-muted">
                Terkunci otomatis
            </div>
        </div>

        {{-- Card 5: Di Sampah --}}
        <div class="kpi-card">
            <div>
                <div class="kpi-card-header">
                    <span class="kpi-label">DI SAMPAH</span>
                    <div class="kpi-icon-wrapper kpi-icon-red">
                        <i class="fa-regular fa-trash-can"></i>
                    </div>
                </div>
                <div class="kpi-value" style="color: #ef4444;">{{ $totalSampah }}</div>
            </div>
            <div class="kpi-subtext text-red">
                Bisa dipulihkan
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="ta-main-card">
        {{-- Tabs Bar --}}
        <div class="ta-tabs-bar">
            <div class="ta-nav-tabs">
                <a href="{{ route('admin.tahun-ajaran.index', ['tab' => 'aktif']) }}" class="ta-tab-item {{ $tab !== 'trash' ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Daftar Tahun Ajaran</span>
                    <span class="ta-tab-badge {{ $tab !== 'trash' ? 'badge-active' : '' }}">{{ $totalData }}</span>
                </a>

                <a href="{{ route('admin.tahun-ajaran.index', ['tab' => 'trash']) }}" class="ta-tab-item {{ $tab === 'trash' ? 'active' : '' }}">
                    <i class="fa-regular fa-trash-can"></i>
                    <span>Kotak Sampah</span>
                    <span class="ta-tab-badge {{ $tab === 'trash' ? 'badge-red' : '' }}">{{ $totalSampah }}</span>
                </a>
            </div>

            <div class="ta-school-label">
                SMKN 1 Boyolangu • TA {{ $activeTa ? $activeTa->tahun_ajaran : '2026/2027' }}
            </div>
        </div>

        {{-- Filter & Search Bar --}}
        <form method="GET" action="{{ route('admin.tahun-ajaran.index') }}" class="ta-filter-bar">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Tahun Ajaran, Semester...">
            </div>

            <select name="semester" class="ta-select-filter">
                <option value="">Semua Semester</option>
                <option value="Ganjil" {{ request('semester') === 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                <option value="Genap" {{ request('semester') === 'Genap' ? 'selected' : '' }}>Semester Genap</option>
            </select>

            <select name="status" class="ta-select-filter">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cari</span>
            </button>

            <a href="{{ route('admin.tahun-ajaran.index', ['tab' => $tab]) }}" class="btn-reset">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset</span>
            </a>
        </form>

        {{-- Bulk Action Bar (Hidden by Default) --}}
        <div id="bulkBar" class="bulk-bar" style="display: none;">
            <div id="bulkSelectedText">0 data terpilih</div>
            <div class="bulk-bar-actions">
                @if($tab === 'trash')
                    <button type="button" class="btn-bulk-teal" onclick="submitBulkAction('restore')">
                        <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
                    </button>
                    <button type="button" class="btn-bulk-danger" onclick="submitBulkAction('forceDelete')">
                        <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                    </button>
                    <button type="button" class="btn-action-outline" style="background:#334155; color:white; border:none;" onclick="emptyTrashConfirm()">
                        Kosongkan Sampah
                    </button>
                @else
                    <button type="button" class="btn-bulk-danger" onclick="submitBulkAction('delete')">
                        <i class="fa-solid fa-trash-can"></i> Pindahkan ke Sampah
                    </button>
                @endif
            </div>
        </div>

        {{-- Data Table --}}
        <div class="ta-table-container">
            <table class="ta-table">
                <thead>
                    <tr>
                        <th class="col-checkbox">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="cursor: pointer;">
                        </th>
                        <th class="col-no">NO</th>
                        <th>TAHUN AJARAN</th>
                        <th>SEMESTER</th>
                        <th>STATUS</th>
                        <th>AKSES JURNAL GURU</th>
                        <th style="text-align: right;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAjaranList as $index => $item)
                        <tr>
                            <td class="col-checkbox">
                                <input type="checkbox" class="row-checkbox" value="{{ $item->id }}" data-active="{{ $item->is_aktif ? '1' : '0' }}" onchange="handleRowCheckbox()" style="cursor: pointer;">
                            </td>
                            <td class="col-no">{{ $tahunAjaranList->firstItem() + $index }}</td>
                            <td>
                                <div class="ta-name-group">
                                    <span class="ta-year-title">{{ $item->tahun_ajaran }}</span>
                                    <span class="ta-period-sub">{{ $item->periode_label ?? ($item->semester === 'Ganjil' ? 'Juli - Desember ' . explode('/', $item->tahun_ajaran)[0] : 'Januari - Juni ' . (explode('/', $item->tahun_ajaran)[1] ?? '')) }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-semester {{ $item->semester === 'Genap' ? 'sem-genap' : '' }}">
                                    {{ $item->semester_formatted }}
                                </span>
                            </td>
                            <td>
                                @if($item->is_aktif)
                                    <span class="badge-status-active">
                                        <span class="dot"></span> Aktif
                                    </span>
                                @else
                                    <span class="badge-status-inactive">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($item->buka_jurnal)
                                    <div class="akses-jurnal-group open" title="Pengisian jurnal guru dapat dilakukan untuk periode ini">
                                        <i class="fa-solid fa-lock-open"></i>
                                        <span>Terbuka (Bisa Input)</span>
                                    </div>
                                @else
                                    <div class="akses-jurnal-group locked" title="Pengisian jurnal guru terkunci (Arsip)">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>Terkunci (Arsip)</span>
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div class="action-buttons-group" style="justify-content: flex-end;">
                                    @if($tab === 'trash')
                                        {{-- Actions in Trash Tab --}}
                                        <button type="button" class="btn-act-restore" onclick="confirmRestore({{ $item->id }}, '{{ $item->nama_lengkap }}')">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                        <button type="button" class="btn-act-delete" onclick="confirmForceDelete({{ $item->id }}, '{{ $item->nama_lengkap }}')" title="Hapus Permanen">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @else
                                        {{-- Actions in Active List --}}
                                        @if(!$item->is_aktif)
                                            <button type="button" class="btn-act-activate" onclick="confirmActivate({{ $item->id }}, '{{ $item->nama_lengkap }}')">
                                                Aktifkan
                                            </button>
                                        @endif

                                        <button type="button" class="btn-act-detail" onclick="openDetailModal({{ $item->id }})">
                                            Detail
                                        </button>

                                        <button type="button" class="btn-act-edit" onclick="openEditModal({{ $item->id }})">
                                            Edit
                                        </button>

                                        @if($item->is_aktif)
                                            <button type="button" class="btn-act-delete" style="opacity: 0.4; cursor: not-allowed;" onclick="alertActiveCannotDelete()" title="Periode aktif tidak dapat dipindahkan ke sampah">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn-act-delete" onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_lengkap }}')" title="Pindahkan ke Kotak Sampah">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px 20px;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; color: #94a3b8;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 38px;"></i>
                                    <span style="font-size: 14px; font-weight: 600; color: #64748b;">
                                        @if($tab === 'trash')
                                            Kotak sampah kosong. Tidak ada data tahun ajaran yang dihapus.
                                        @else
                                            Tidak ada data tahun ajaran yang sesuai dengan pencarian / filter.
                                        @endif
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer & Pagination --}}
        <div class="ta-table-footer">
            <div class="ta-footer-info">
                Menampilkan {{ $tahunAjaranList->firstItem() ?? 0 }}-{{ $tahunAjaranList->lastItem() ?? 0 }} dari {{ $tahunAjaranList->total() }} data periode {{ $tab === 'trash' ? 'sampah' : 'aktif' }}
            </div>

            <div class="pagination-bar">
                {{ $tahunAjaranList->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Tahun Ajaran --}}
<div id="createModal" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3>+ Tambah Tahun Ajaran Baru</h3>
            <button type="button" class="btn-close-modal" onclick="closeCreateModal()">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.tahun-ajaran.store') }}">
            @csrf
            {{-- Input asli yang dikirim ke controller --}}
            <input type="hidden" name="tahun_ajaran" id="create_tahun_ajaran_real" value="2026/2027">

            <div class="modal-body-custom">
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label>Pilihan Tahun Ajaran <span class="req">*</span></label>
                        <select id="create_tahun_ajaran_select" class="form-control-custom" onchange="handleTahunAjaranSelectChange('create')">
                            @php
                                $currentYr = 2026;
                                $years = [
                                    '2023/2024',
                                    '2024/2025',
                                    '2025/2026',
                                    '2026/2027',
                                    '2027/2028',
                                    '2028/2029',
                                    '2029/2030',
                                    '2030/2031',
                                    '2031/2032',
                                    '2032/2033',
                                    '2033/2034',
                                    '2034/2035',
                                ];
                            @endphp
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $yr === '2026/2027' ? 'selected' : '' }}>T.A. {{ $yr }}</option>
                            @endforeach
                            <option value="custom">+ Input Tahun Kustom...</option>
                        </select>

                        {{-- Input Text Kustom (Muncul jika opsi custom dipilih) --}}
                        <div id="create_tahun_ajaran_custom_wrapper" style="display: none; margin-top: 6px;">
                            <input type="text" id="create_tahun_ajaran_custom" class="form-control-custom" placeholder="Contoh: 2035/2036" pattern="\d{4}/\d{4}" oninput="handleTahunAjaranCustomInput('create')">
                            <small style="color: #64748b; font-size: 11px;">Format wajib: YYYY/YYYY (contoh: 2035/2036)</small>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Semester <span class="req">*</span></label>
                        <select name="semester" id="create_semester" class="form-control-custom" onchange="handleSemesterChange('create')" required>
                            <option value="Ganjil">Semester Ganjil</option>
                            <option value="Genap">Semester Genap</option>
                        </select>
                    </div>
                </div>

                {{-- Box Pemilihan Bulan & Label Periode Rentang Waktu --}}
                <div class="month-picker-container">
                    <div class="month-picker-title">
                        <i class="fa-regular fa-calendar-check" style="color: #2563eb;"></i>
                        <span>Pilihan Bulan Rentang Waktu (Otomatis menyesuaikan tahun yang dipilih)</span>
                    </div>

                    <div class="month-picker-grid">
                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Bulan Mulai</label>
                            <select id="create_bulan_awal" class="month-select-sub" onchange="updatePeriodeLabel('create')">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli" selected>Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>

                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Bulan Selesai</label>
                            <select id="create_bulan_akhir" class="month-select-sub" onchange="updatePeriodeLabel('create')">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember" selected>Desember</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px; display: block;">Hasil Label Periode Rentang Waktu</label>
                        <input type="text" name="periode_label" id="create_periode_label" class="form-control-custom" value="Juli - Desember 2026" placeholder="Hasil label periode...">
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label>Tanggal Mulai KBM</label>
                        <input type="date" name="tanggal_mulai" class="form-control-custom">
                    </div>

                    <div class="form-group-custom">
                        <label>Tanggal Selesai KBM</label>
                        <input type="date" name="tanggal_selesai" class="form-control-custom">
                    </div>
                </div>

                <label class="checkbox-switch-group">
                    <input type="checkbox" name="is_aktif" value="1">
                    <span>Tetapkan sebagai Tahun Ajaran AKTIF saat ini</span>
                </label>

                <label class="checkbox-switch-group">
                    <input type="checkbox" name="buka_jurnal" value="1" checked>
                    <span>Buka Akses Pengisian Jurnal Guru (Bisa Input)</span>
                </label>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label>Catatan / Keterangan</label>
                    <textarea name="keterangan" rows="2" class="form-control-custom" placeholder="Keterangan tambahan operasional akademik..."></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-action-outline" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-action-primary">Simpan Tahun Ajaran</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Tahun Ajaran --}}
<div id="editModal" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3>Edit Tahun Ajaran</h3>
            <button type="button" class="btn-close-modal" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')
            {{-- Input asli yang dikirim ke controller --}}
            <input type="hidden" name="tahun_ajaran" id="edit_tahun_ajaran_real" value="">

            <div class="modal-body-custom">
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label>Pilihan Tahun Ajaran <span class="req">*</span></label>
                        <select id="edit_tahun_ajaran_select" class="form-control-custom" onchange="handleTahunAjaranSelectChange('edit')">
                            @foreach($years as $yr)
                                <option value="{{ $yr }}">T.A. {{ $yr }}</option>
                            @endforeach
                            <option value="custom">+ Input Tahun Kustom...</option>
                        </select>

                        <div id="edit_tahun_ajaran_custom_wrapper" style="display: none; margin-top: 6px;">
                            <input type="text" id="edit_tahun_ajaran_custom" class="form-control-custom" placeholder="Contoh: 2035/2036" pattern="\d{4}/\d{4}" oninput="handleTahunAjaranCustomInput('edit')">
                            <small style="color: #64748b; font-size: 11px;">Format wajib: YYYY/YYYY</small>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Semester <span class="req">*</span></label>
                        <select id="edit_semester" name="semester" class="form-control-custom" onchange="handleSemesterChange('edit')" required>
                            <option value="Ganjil">Semester Ganjil</option>
                            <option value="Genap">Semester Genap</option>
                        </select>
                    </div>
                </div>

                {{-- Box Pemilihan Bulan & Label Periode Rentang Waktu (Edit) --}}
                <div class="month-picker-container">
                    <div class="month-picker-title">
                        <i class="fa-regular fa-calendar-check" style="color: #2563eb;"></i>
                        <span>Pilihan Bulan Rentang Waktu (Otomatis menyesuaikan tahun yang dipilih)</span>
                    </div>

                    <div class="month-picker-grid">
                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Bulan Mulai</label>
                            <select id="edit_bulan_awal" class="month-select-sub" onchange="updatePeriodeLabel('edit')">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>

                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Bulan Selesai</label>
                            <select id="edit_bulan_akhir" class="month-select-sub" onchange="updatePeriodeLabel('edit')">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px; display: block;">Hasil Label Periode Rentang Waktu</label>
                        <input type="text" id="edit_periode_label" name="periode_label" class="form-control-custom" placeholder="Hasil label periode...">
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label>Tanggal Mulai KBM</label>
                        <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai" class="form-control-custom">
                    </div>

                    <div class="form-group-custom">
                        <label>Tanggal Selesai KBM</label>
                        <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai" class="form-control-custom">
                    </div>
                </div>

                <label class="checkbox-switch-group">
                    <input type="checkbox" id="edit_is_aktif" name="is_aktif" value="1">
                    <span>Tetapkan sebagai Tahun Ajaran AKTIF saat ini</span>
                </label>

                <label class="checkbox-switch-group">
                    <input type="checkbox" id="edit_buka_jurnal" name="buka_jurnal" value="1">
                    <span>Buka Akses Pengisian Jurnal Guru (Bisa Input)</span>
                </label>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label>Catatan / Keterangan</label>
                    <textarea id="edit_keterangan" name="keterangan" rows="2" class="form-control-custom"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-action-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-action-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Tahun Ajaran --}}
<div id="detailModal" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3 id="detailHeaderTitle">Detail Tahun Ajaran</h3>
            <button type="button" class="btn-close-modal" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-body-custom">
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Tahun Ajaran</div>
                    <div id="dt_tahun_ajaran" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Semester</div>
                    <div id="dt_semester" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status Operasional</div>
                    <div id="dt_status" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Akses Jurnal Guru</div>
                    <div id="dt_akses" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Tanggal Mulai</div>
                    <div id="dt_mulai" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Tanggal Selesai</div>
                    <div id="dt_selesai" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Durasi Hari Kalender</div>
                    <div id="dt_durasi" class="detail-val">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Total Jadwal Terhubung</div>
                    <div id="dt_jadwal" class="detail-val">-</div>
                </div>

                <div class="detail-item-full">
                    <div class="detail-label">Label Periode</div>
                    <div id="dt_periode_label" class="detail-val">-</div>
                </div>

                <div class="detail-item-full">
                    <div class="detail-label">Keterangan / Catatan</div>
                    <div id="dt_keterangan" class="detail-val">-</div>
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-action-primary" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- Hidden Form Helpers for Actions --}}
<form id="actionActivateForm" method="POST" action="" style="display: none;">@csrf</form>
<form id="actionDeleteForm" method="POST" action="" style="display: none;">@csrf @method('DELETE')</form>
<form id="actionRestoreForm" method="POST" action="" style="display: none;">@csrf</form>
<form id="actionForceDeleteForm" method="POST" action="" style="display: none;">@csrf @method('DELETE')</form>
<form id="bulkForm" method="POST" action="" style="display: none;">@csrf</form>
@endsection

@section('scripts')
<script>
    // Modal Helpers
    function openCreateModal() {
        document.getElementById('createModal').classList.add('active');
        updatePeriodeLabel('create');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.remove('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    // Dynamic Academic Year & Month Helper Functions
    function getTahunAjaranValue(prefix) {
        const select = document.getElementById(`${prefix}_tahun_ajaran_select`);
        if (!select) return '';
        if (select.value === 'custom') {
            return document.getElementById(`${prefix}_tahun_ajaran_custom`).value.trim();
        }
        return select.value;
    }

    function handleTahunAjaranSelectChange(prefix) {
        const select = document.getElementById(`${prefix}_tahun_ajaran_select`);
        const customWrapper = document.getElementById(`${prefix}_tahun_ajaran_custom_wrapper`);
        const hiddenRealInput = document.getElementById(`${prefix}_tahun_ajaran_real`);

        if (select.value === 'custom') {
            customWrapper.style.display = 'block';
            hiddenRealInput.value = document.getElementById(`${prefix}_tahun_ajaran_custom`).value.trim();
        } else {
            customWrapper.style.display = 'none';
            hiddenRealInput.value = select.value;
        }
        updatePeriodeLabel(prefix);
    }

    function handleTahunAjaranCustomInput(prefix) {
        const customVal = document.getElementById(`${prefix}_tahun_ajaran_custom`).value.trim();
        document.getElementById(`${prefix}_tahun_ajaran_real`).value = customVal;
        updatePeriodeLabel(prefix);
    }

    function handleSemesterChange(prefix) {
        const sem = document.getElementById(`${prefix}_semester`).value;
        const bulanAwal = document.getElementById(`${prefix}_bulan_awal`);
        const bulanAkhir = document.getElementById(`${prefix}_bulan_akhir`);

        if (sem === 'Ganjil') {
            bulanAwal.value = 'Juli';
            bulanAkhir.value = 'Desember';
        } else {
            bulanAwal.value = 'Januari';
            bulanAkhir.value = 'Juni';
        }
        updatePeriodeLabel(prefix);
    }

    function updatePeriodeLabel(prefix) {
        const taVal = getTahunAjaranValue(prefix);
        const sem = document.getElementById(`${prefix}_semester`).value;
        const bulanAwal = document.getElementById(`${prefix}_bulan_awal`).value;
        const bulanAkhir = document.getElementById(`${prefix}_bulan_akhir`).value;
        const labelInput = document.getElementById(`${prefix}_periode_label`);

        let targetYear = '';
        if (taVal && taVal.includes('/')) {
            const parts = taVal.split('/');
            targetYear = (sem === 'Ganjil') ? parts[0] : (parts[1] || parts[0]);
        } else if (taVal) {
            targetYear = taVal;
        } else {
            targetYear = '2026';
        }

        if (bulanAwal && bulanAkhir && targetYear) {
            labelInput.value = `${bulanAwal} - ${bulanAkhir} ${targetYear}`;
        }
    }

    // Detail AJAX fetch
    function openDetailModal(id) {
        fetch(`{{ url('admin/tahun-ajaran') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const d = res.data;
                    document.getElementById('detailHeaderTitle').textContent = `Detail: ${d.nama_lengkap}`;
                    document.getElementById('dt_tahun_ajaran').textContent = d.tahun_ajaran;
                    document.getElementById('dt_semester').textContent = d.semester_formatted;
                    document.getElementById('dt_status').innerHTML = d.is_aktif ? '<span class="badge-status-active"><span class="dot"></span> Aktif</span>' : '<span class="badge-status-inactive">Tidak Aktif</span>';
                    document.getElementById('dt_akses').innerHTML = d.buka_jurnal ? '<span style="color:#0d9488;"><i class="fa-solid fa-lock-open"></i> Terbuka (Bisa Input)</span>' : '<span style="color:#64748b;"><i class="fa-solid fa-lock"></i> Terkunci (Arsip)</span>';
                    document.getElementById('dt_mulai').textContent = d.tanggal_mulai;
                    document.getElementById('dt_selesai').textContent = d.tanggal_selesai;
                    document.getElementById('dt_durasi').textContent = d.durasi_hari ? `${d.durasi_hari} Hari` : '-';
                    document.getElementById('dt_jadwal').textContent = `${d.total_jadwal} Sesi Jadwal`;
                    document.getElementById('dt_periode_label').textContent = d.periode_label;
                    document.getElementById('dt_keterangan').textContent = d.keterangan;

                    document.getElementById('detailModal').classList.add('active');
                }
            })
            .catch(err => {
                alert('Gagal mengambil data rincian.');
            });
    }

    // Edit AJAX fetch
    function openEditModal(id) {
        fetch(`{{ url('admin/tahun-ajaran') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const d = res.data;
                    document.getElementById('editForm').action = `{{ url('admin/tahun-ajaran') }}/${id}`;

                    // Set Tahun Ajaran Select / Custom
                    const selectTa = document.getElementById('edit_tahun_ajaran_select');
                    const customWrapper = document.getElementById('edit_tahun_ajaran_custom_wrapper');
                    const customInput = document.getElementById('edit_tahun_ajaran_custom');
                    const realInput = document.getElementById('edit_tahun_ajaran_real');

                    let optionExists = false;
                    for (let i = 0; i < selectTa.options.length; i++) {
                        if (selectTa.options[i].value === d.tahun_ajaran) {
                            selectTa.selectedIndex = i;
                            optionExists = true;
                            break;
                        }
                    }

                    if (optionExists) {
                        customWrapper.style.display = 'none';
                        realInput.value = d.tahun_ajaran;
                    } else {
                        selectTa.value = 'custom';
                        customWrapper.style.display = 'block';
                        customInput.value = d.tahun_ajaran;
                        realInput.value = d.tahun_ajaran;
                    }

                    document.getElementById('edit_semester').value = d.semester;

                    // Parse Month range if possible (e.g. "Juli - Desember 2026")
                    if (d.periode_label && d.periode_label !== '-') {
                        document.getElementById('edit_periode_label').value = d.periode_label;
                        const match = d.periode_label.match(/^([a-zA-Z]+)\s*-\s*([a-zA-Z]+)/);
                        if (match) {
                            document.getElementById('edit_bulan_awal').value = match[1];
                            document.getElementById('edit_bulan_akhir').value = match[2];
                        }
                    } else {
                        handleSemesterChange('edit');
                    }

                    document.getElementById('edit_tanggal_mulai').value = d.tanggal_mulai_raw;
                    document.getElementById('edit_tanggal_selesai').value = d.tanggal_selesai_raw;
                    document.getElementById('edit_is_aktif').checked = d.is_aktif;
                    document.getElementById('edit_buka_jurnal').checked = d.buka_jurnal;
                    document.getElementById('edit_keterangan').value = d.keterangan !== '-' ? d.keterangan : '';

                    document.getElementById('editModal').classList.add('active');
                }
            })
            .catch(err => {
                alert('Gagal mengambil data untuk diedit.');
            });
    }

    // Actions Confirmations
    function confirmActivate(id, name) {
        if (confirm(`Apakah Anda yakin ingin menetapkan '${name}' sebagai Tahun Ajaran AKTIF?\n\nPeriode yang sedang aktif sebelumnya akan otomatis dinonaktifkan.`)) {
            const form = document.getElementById('actionActivateForm');
            form.action = `{{ url('admin/tahun-ajaran') }}/${id}/activate`;
            form.submit();
        }
    }

    function confirmDelete(id, name) {
        if (confirm(`Pindahkan '${name}' ke Kotak Sampah?`)) {
            const form = document.getElementById('actionDeleteForm');
            form.action = `{{ url('admin/tahun-ajaran') }}/${id}`;
            form.submit();
        }
    }

    function alertActiveCannotDelete() {
        alert('PERINGATAN:\nTahun Ajaran yang sedang AKTIF tidak dapat dipindahkan ke Kotak Sampah!\n\nSilakan aktifkan periode Tahun Ajaran lain terlebih dahulu.');
    }

    function confirmRestore(id, name) {
        if (confirm(`Pulihkan '${name}' dari Kotak Sampah?`)) {
            const form = document.getElementById('actionRestoreForm');
            form.action = `{{ url('admin/tahun-ajaran-trash') }}/${id}/restore`;
            form.submit();
        }
    }

    function confirmForceDelete(id, name) {
        if (confirm(`PERINGATAN KERAS:\nApakah Anda yakin ingin menghapus '${name}' secara PERMANEN?\n\nTindakan ini TIDAK DAPAT DIBATALKAN!`)) {
            const form = document.getElementById('actionForceDeleteForm');
            form.action = `{{ url('admin/tahun-ajaran-trash') }}/${id}/force`;
            form.submit();
        }
    }

    function emptyTrashConfirm() {
        if (confirm('PERINGATAN KERAS:\nApakah Anda yakin ingin MENGOSONGKAN SELURUH ISI KOTAK SAMPAH secara permanen?')) {
            const form = document.getElementById('bulkForm');
            form.action = `{{ route('admin.tahun-ajaran.empty-trash') }}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            form.submit();
        }
    }

    // Checkbox & Bulk Actions
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        handleRowCheckbox();
    }

    function handleRowCheckbox() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        const bulkBar = document.getElementById('bulkBar');
        const text = document.getElementById('bulkSelectedText');

        if (checked.length > 0) {
            bulkBar.style.display = 'flex';
            text.textContent = `${checked.length} data terpilih`;
        } else {
            bulkBar.style.display = 'none';
        }
    }

    function submitBulkAction(actionType) {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data terlebih dahulu.');
            return;
        }

        const ids = Array.from(checked).map(cb => cb.value);

        const form = document.getElementById('bulkForm');
        form.innerHTML = '@csrf';

        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        if (actionType === 'delete') {
            if (confirm(`Pindahkan ${ids.length} data tahun ajaran terpilih ke Kotak Sampah?`)) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                form.action = `{{ route('admin.tahun-ajaran.destroy-batch') }}`;
                form.submit();
            }
        } else if (actionType === 'restore') {
            if (confirm(`Pulihkan ${ids.length} data tahun ajaran dari Kotak Sampah?`)) {
                form.action = `{{ route('admin.tahun-ajaran.restore-batch') }}`;
                form.submit();
            }
        } else if (actionType === 'forceDelete') {
            if (confirm(`PERINGATAN:\nHapus ${ids.length} data terpilih secara PERMANEN dari database?`)) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                form.action = `{{ route('admin.tahun-ajaran.force-delete-batch') }}`;
                form.submit();
            }
        }
    }
</script>
@endsection
