@extends('layouts.waka')

@section('title', 'Rekap Kehadiran Siswa — Jurnal SMEA')

@section('styles')
<style>
    /* Rekap Kehadiran Container */
    .rekap-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Page Header */
    .rekap-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-title-box p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin-top: 4px;
    }

    .header-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 9px 18px;
        border-radius: 14px;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .header-date-badge:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .header-date-badge i.cal-icon {
        color: #64748b;
        font-size: 15px;
    }

    .header-date-badge i.chevron-icon {
        color: #94a3b8;
        font-size: 11px;
    }

    /* 4 Top Stat Cards (According to User Image 2 Mockup) */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card-item {
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid transparent;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    }

    /* Card 1: Total Siswa */
    .card-total {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }
    .card-total .stat-circle {
        background: #e2e8f0;
        color: #334155;
    }

    /* Card 2: Hadir */
    .card-hadir {
        background: #e8f7ee;
        border-color: #d1fae5;
    }
    .card-hadir .stat-circle {
        background: #22c55e;
        color: #ffffff;
    }

    /* Card 3: Izin / Sakit */
    .card-izin {
        background: #fef3e7;
        border-color: #ffedd5;
    }
    .card-izin .stat-circle {
        background: #f97316;
        color: #ffffff;
    }

    /* Card 4: Tidak Hadir / Alpa */
    .card-alpa {
        background: #fde8e8;
        border-color: #fee2e2;
    }
    .card-alpa .stat-circle {
        background: #ef4444;
        color: #ffffff;
    }

    .stat-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-info .stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    .stat-info .stat-number {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        margin: 2px 0;
    }

    .stat-info .stat-desc {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    /* Toolbar Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 14px 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .filter-form-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .search-input-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-wrap input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-input-wrap input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-select {
        padding: 10px 36px 10px 14px;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 12px center;
        background-size: 14px;
        appearance: none;
        -webkit-appearance: none;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 140px;
    }

    .filter-select:focus {
        background-color: #ffffff;
        border-color: #2563eb;
    }

    .filter-date-input {
        padding: 9px 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        cursor: pointer;
    }

    .btn-filter-action {
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
        font-family: inherit;
    }

    .btn-apply-filter {
        background: #2563eb;
        color: #ffffff;
    }
    .btn-apply-filter:hover { background: #1d4ed8; }

    .btn-reset-filter {
        background: #f1f5f9;
        color: #64748b;
    }
    .btn-reset-filter:hover { background: #e2e8f0; color: #334155; }

    .btn-export-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .btn-export-pill {
        background: #e0e7ff;
        color: #4338ca;
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-export-pill:hover {
        background: #c7d2fe;
        color: #3730a3;
    }

    .btn-print-pill {
        background: #f1f5f9;
        color: #334155;
        padding: 10px 16px;
        border-radius: 14px;
        font-size: 13.5px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-print-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Table Container */
    .table-container-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .table-responsive-box {
        width: 100%;
        overflow-x: auto;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .rekap-table thead tr {
        background: #f1f5f9;
    }

    .rekap-table thead th {
        padding: 14px 18px;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        border: none;
    }

    .rekap-table thead th.text-center,
    .rekap-table tbody td.text-center {
        text-align: center;
    }

    .rekap-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
        cursor: pointer;
    }

    .rekap-table tbody tr:hover {
        background: #f8fafc;
    }

    .rekap-table tbody td {
        padding: 16px 18px;
        font-size: 14px;
        color: #1e293b;
        vertical-align: middle;
    }

    .student-name-text {
        font-weight: 700;
        color: #0f172a;
        font-size: 14px;
    }

    .student-nis-sub {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .student-class-badge {
        font-weight: 700;
        color: #334155;
    }

    /* Indicators (Circles with Icons Matching Design Mockup) */
    .indicator-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .indicator-hadir {
        border: 2px solid #22c55e;
        color: #22c55e;
        background: #f0fdf4;
    }

    .indicator-izin {
        background: #f97316;
        color: #ffffff;
    }

    .indicator-sakit {
        background: #ef4444;
        color: #ffffff;
    }

    .indicator-alpa {
        background: #ef4444;
        color: #ffffff;
    }

    .indicator-dash {
        color: #94a3b8;
        font-weight: 600;
        font-size: 16px;
    }

    /* Status Badges */
    .status-pill {
        display: inline-block;
        padding: 7px 22px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        min-width: 90px;
    }

    .status-pill-hadir {
        background: #bbf7d0;
        color: #15803d;
    }

    .status-pill-izin {
        background: #fed7aa;
        color: #c2410c;
    }

    .status-pill-sakit {
        background: #fecdd3;
        color: #e11d48;
    }

    .status-pill-alpa {
        background: #fecaca;
        color: #dc2626;
    }

    /* Empty State */
    .empty-state-box {
        padding: 48px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .empty-state-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #94a3b8;
    }

    /* Table Footer & Custom Pagination Bar */
    .table-footer-bar {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
    }

    .footer-count-text {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
    }

    /* Custom Pagination Styling within page */
    .custom-pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-list {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-list .page-item {
        display: inline-block;
    }

    .pagination-list .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .pagination-list .page-item:not(.active):not(.disabled) .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .pagination-list .page-item.active .page-link {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .pagination-list .page-item.disabled .page-link {
        color: #94a3b8 !important;
        background: #f8fafc !important;
        border-color: #f1f5f9 !important;
        cursor: not-allowed;
    }

    /* Modal Detail Presensi Siswa */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-backdrop.show {
        display: flex;
    }

    .modal-dialog {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 640px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    @keyframes modalPop {
        from { transform: scale(0.95) translateY(10px); opacity: 0; }
        to { transform: scale(1) translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 18px 24px;
        border-bottom: 1.5px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }

    .modal-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 20px;
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }
    .modal-close:hover { color: #0f172a; }

    .modal-body {
        padding: 22px 24px;
        overflow-y: auto;
        max-height: calc(90vh - 140px);
    }

    .modal-footer {
        padding: 14px 24px;
        border-top: 1.5px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-modal-close {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-modal-close:hover { background: #cbd5e1; }

    .detail-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 14px;
    }

    .detail-section-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .detail-item-box {
        display: flex;
        flex-direction: column;
    }

    .detail-item-box .label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-item-box .val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }

    .month-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        text-align: center;
    }

    .month-stat-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 6px;
    }

    .month-stat-box .num {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .month-stat-box .lbl {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .filter-form-row { flex-direction: column; align-items: stretch; }
        .btn-export-group { margin-left: 0; justify-content: flex-start; }
        .detail-grid-2 { grid-template-columns: 1fr; }
        .month-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')
<div class="rekap-container">

    <!-- Header Row -->
    <div class="rekap-header-row">
        <div class="page-title-box">
            <h1>Rekap Kehadiran Siswa</h1>
            <p>Pantau dan kelola kehadiran siswa secara harian, mingguan, maupun bulanan.</p>
        </div>

        <form action="{{ route('waka.rekap-kehadiran') }}" method="GET" id="dateSelectorForm">
            @if(request('id_kelas')) <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}"> @endif
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

            <label class="header-date-badge" for="headerDateInput" title="Klik untuk mengubah tanggal rekap">
                <i class="fa-regular fa-calendar cal-icon"></i>
                <span>{{ $formattedDateIndo }}</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
                <input type="date" id="headerDateInput" name="tanggal" value="{{ $selectedDate }}" style="position:absolute; opacity:0; width:0; height:0;" onchange="document.getElementById('dateSelectorForm').submit();">
            </label>
        </form>
    </div>

    <!-- 4 Top Stat Cards (According to User Image 2 Mockup) -->
    <div class="stat-cards-grid">
        <!-- 1. Total Siswa -->
        <a href="{{ route('waka.rekap-kehadiran', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" class="stat-card-item card-total" title="Total Siswa">
            <div class="stat-circle">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Siswa</span>
                <span class="stat-number">{{ number_format($statTotalSiswa, 0, ',', '.') }}</span>
                <span class="stat-desc">Siswa</span>
            </div>
        </a>

        <!-- 2. Hadir -->
        <a href="{{ route('waka.rekap-kehadiran', array_merge(request()->except('status', 'page'), ['status' => 'Hadir'])) }}" class="stat-card-item card-hadir" title="Filter Siswa Hadir">
            <div class="stat-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Hadir</span>
                <span class="stat-number">{{ number_format($countHadir, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #16a34a;">siswa ({{ $statHadirPersen }}%)</span>
            </div>
        </a>

        <!-- 3. Izin / Sakit -->
        <a href="{{ route('waka.rekap-kehadiran', array_merge(request()->except('status', 'page'), ['status' => 'Izin'])) }}" class="stat-card-item card-izin" title="Filter Siswa Izin / Sakit">
            <div class="stat-circle">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Izin / Sakit</span>
                <span class="stat-number">{{ number_format($statIzinSakitTotal, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #ea580c;">siswa ({{ $statIzinSakitPersen }}%)</span>
            </div>
        </a>

        <!-- 4. Tidak Hadir / Alpa -->
        <a href="{{ route('waka.rekap-kehadiran', array_merge(request()->except('status', 'page'), ['status' => 'Alpa'])) }}" class="stat-card-item card-alpa" title="Filter Siswa Tidak Hadir / Alpa">
            <div class="stat-circle">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Tidak Hadir</span>
                <span class="stat-number">{{ number_format($countAlpa, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #dc2626;">siswa ({{ $statTidakHadirPersen }}%)</span>
            </div>
        </a>
    </div>

    <!-- Filter Bar Card -->
    <div class="filter-card">
        <form action="{{ route('waka.rekap-kehadiran') }}" method="GET" class="filter-form-row">
            <!-- Search Box -->
            <div class="search-input-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIS / kelas...">
            </div>

            <!-- Kelas Filter -->
            <select name="id_kelas" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $k)
                    <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Siswa</option>
                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
            </select>

            <!-- Tanggal Filter -->
            <input type="date" name="tanggal" value="{{ $selectedDate }}" class="filter-date-input" title="Pilih Tanggal" onchange="this.form.submit()">

            <button type="submit" class="btn-filter-action btn-apply-filter">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['q', 'id_kelas', 'status']) || request('tanggal') != \Carbon\Carbon::today('Asia/Jakarta')->toDateString())
                <a href="{{ route('waka.rekap-kehadiran') }}" class="btn-filter-action btn-reset-filter" title="Reset semua filter">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    <span>Reset</span>
                </a>
            @endif

            <!-- Export Buttons -->
            <div class="btn-export-group">
                <a href="{{ route('waka.rekap-kehadiran.export', request()->all()) }}" class="btn-export-pill" title="Ekspor Data Rekap ke CSV / Excel">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    <span>Export</span>
                </a>
                <a href="{{ route('waka.rekap-kehadiran.print', request()->all()) }}" target="_blank" class="btn-print-pill" title="Cetak Rekap Kehadiran PDF">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="table-container-card">
        <div class="table-responsive-box">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th class="text-center" style="width: 90px;">Hadir</th>
                        <th class="text-center" style="width: 90px;">Izin</th>
                        <th class="text-center" style="width: 90px;">Sakit</th>
                        <th class="text-center" style="width: 90px;">Alpa</th>
                        <th class="text-center" style="width: 130px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                        <tr onclick="openModalDetailPresensi('{{ $siswa->id_siswa }}')" title="Klik untuk melihat rincian presensi siswa">
                            <td class="text-center" style="color: #64748b; font-weight: 700;">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="student-name-text">{{ $siswa->nama_siswa }}</div>
                                <div class="student-nis-sub">NIS: {{ $siswa->nis }} {{ $siswa->nisn ? '• NISN: ' . $siswa->nisn : '' }}</div>
                            </td>
                            <td>
                                <span class="student-class-badge">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                            </td>
                            
                            <!-- Kolom Hadir -->
                            <td class="text-center">
                                @if($siswa->is_hadir)
                                    <span class="indicator-icon indicator-hadir" title="Hadir">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                @else
                                    <span class="indicator-dash">-</span>
                                @endif
                            </td>

                            <!-- Kolom Izin -->
                            <td class="text-center">
                                @if($siswa->is_izin)
                                    <span class="indicator-icon indicator-izin" title="{{ $siswa->keterangan_kehadiran }}">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                @else
                                    <span class="indicator-dash">-</span>
                                @endif
                            </td>

                            <!-- Kolom Sakit -->
                            <td class="text-center">
                                @if($siswa->is_sakit)
                                    <span class="indicator-icon indicator-sakit" title="{{ $siswa->keterangan_kehadiran }}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                @else
                                    <span class="indicator-dash">-</span>
                                @endif
                            </td>

                            <!-- Kolom Alpa -->
                            <td class="text-center">
                                @if($siswa->is_alpa)
                                    <span class="indicator-icon indicator-alpa" title="Alpa / Tanpa Keterangan">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                @else
                                    <span class="indicator-dash">-</span>
                                @endif
                            </td>

                            <!-- Kolom Status Pill Badge -->
                            <td class="text-center">
                                @if($siswa->kehadiran_status === 'Hadir')
                                    <span class="status-pill status-pill-hadir">Hadir</span>
                                @elseif($siswa->kehadiran_status === 'Izin')
                                    <span class="status-pill status-pill-izin">Izin</span>
                                @elseif($siswa->kehadiran_status === 'Sakit')
                                    <span class="status-pill status-pill-sakit">Sakit</span>
                                @else
                                    <span class="status-pill status-pill-alpa">Alpa</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state-box">
                                    <div class="empty-state-icon">
                                        <i class="fa-solid fa-user-xmark"></i>
                                    </div>
                                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Tidak Ada Data Kehadiran</h3>
                                    <p style="font-size: 13.5px; color: #64748b; margin: 0; max-width: 400px;">Tidak ditemukan data presensi siswa yang sesuai dengan filter pencarian atau tanggal yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer & Custom Beautiful Pagination -->
        @if($siswas->total() > 0)
            <div class="table-footer-bar">
                <div class="footer-count-text">
                    Menampilkan <strong>{{ $siswas->firstItem() }}</strong> - <strong>{{ $siswas->lastItem() }}</strong> dari <strong>{{ number_format($siswas->total(), 0, ',', '.') }}</strong> data
                </div>
                <div>
                    {{ $siswas->links('partials.custom-pagination') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL PRESENSI SISWA -->
<!-- ========================================================================= -->
<div class="modal-backdrop" id="modalDetailPresensi">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-clipboard-user" style="color: #2563eb;"></i> Detail Kehadiran Siswa
            </h3>
            <button type="button" class="modal-close" onclick="closeModalDetailPresensi()">&times;</button>
        </div>

        <div class="modal-body" id="modalDetailPresensiBody">
            <div style="text-align:center; padding: 30px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-weight: 600;">Memuat data rincian presensi...</p>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeModalDetailPresensi()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModalDetailPresensi(idSiswa) {
        const modal = document.getElementById('modalDetailPresensi');
        const modalBody = document.getElementById('modalDetailPresensiBody');
        modal.classList.add('show');
        modalBody.innerHTML = `
            <div style="text-align:center; padding: 30px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-weight: 600;">Memuat data rincian presensi...</p>
            </div>
        `;

        fetch(`{{ url('/waka/rekap-kehadiran/detail-siswa') }}/${idSiswa}?tanggal={{ $selectedDate }}`)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    modalBody.innerHTML = `<div style="color: #dc2626; padding: 20px; text-align: center;">${data.message || 'Gagal memuat data.'}</div>`;
                    return;
                }

                const s = data.siswa;
                const m = data.month_summary;
                
                let badgeClass = 'status-pill-hadir';
                if (data.status_today === 'Izin') badgeClass = 'status-pill-izin';
                else if (data.status_today === 'Sakit') badgeClass = 'status-pill-sakit';
                else if (data.status_today === 'Alpa') badgeClass = 'status-pill-alpa';

                modalBody.innerHTML = `
                    <!-- Info Siswa -->
                    <div class="detail-section-card">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-id-badge" style="color: #2563eb;"></i>
                            <span>Profil Siswa</span>
                        </div>
                        <div class="detail-grid-2">
                            <div class="detail-item-box">
                                <span class="label">Nama Lengkap</span>
                                <span class="val">${s.nama_siswa}</span>
                            </div>
                            <div class="detail-item-box">
                                <span class="label">NIS / NISN</span>
                                <span class="val">${s.nis} / ${s.nisn}</span>
                            </div>
                            <div class="detail-item-box">
                                <span class="label">Kelas / Jurusan</span>
                                <span class="val">${s.kelas} (${s.jurusan})</span>
                            </div>
                            <div class="detail-item-box">
                                <span class="label">Jenis Kelamin</span>
                                <span class="val">${s.jenis_kelamin}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Presensi Pada Tanggal Terpilih -->
                    <div class="detail-section-card">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-calendar-check" style="color: #16a34a;"></i>
                            <span>Status Presensi (${data.selected_date})</span>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                            <span class="status-pill ${badgeClass}">${data.status_today}</span>
                            <span style="font-size: 13px; font-weight: 600; color: #475569;">${data.keterangan_today}</span>
                        </div>
                    </div>

                    <!-- Ringkasan Presensi Bulan Ini -->
                    <div class="detail-section-card" style="margin-bottom: 0;">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-chart-pie" style="color: #7c3aed;"></i>
                            <span>Akumulasi Presensi Bulan ${m.bulan_tahun}</span>
                        </div>
                        <div class="month-stats-grid">
                            <div class="month-stat-box">
                                <div class="num" style="color: #16a34a;">${m.hadir}</div>
                                <div class="lbl">Hadir</div>
                            </div>
                            <div class="month-stat-box">
                                <div class="num" style="color: #ea580c;">${m.izin}</div>
                                <div class="lbl">Izin</div>
                            </div>
                            <div class="month-stat-box">
                                <div class="num" style="color: #e11d48;">${m.sakit}</div>
                                <div class="lbl">Sakit</div>
                            </div>
                            <div class="month-stat-box">
                                <div class="num" style="color: #dc2626;">${m.alpa}</div>
                                <div class="lbl">Alpa</div>
                            </div>
                        </div>
                        <div style="margin-top: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #1e293b;">
                            Tingkat Kehadiran: <span style="color: #16a34a;">${m.persentase}%</span>
                        </div>
                    </div>
                `;
            })
            .catch(err => {
                modalBody.innerHTML = `<div style="color: #dc2626; padding: 20px; text-align: center;">Terjadi kesalahan saat mengambil data presensi.</div>`;
            });
    }

    function closeModalDetailPresensi() {
        document.getElementById('modalDetailPresensi').classList.remove('show');
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalDetailPresensi');
        if (e.target === modal) {
            closeModalDetailPresensi();
        }
    });
</script>
@endsection