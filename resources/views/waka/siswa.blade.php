@extends('layouts.waka')

@section('title', 'Data Siswa — Waka Kesiswaan')

@section('styles')
<style>
    .siswa-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Header Box */
    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        width: 100%;
    }

    .page-main-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }

    .breadcrumb-nav a {
        color: #2563eb;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-nav a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .breadcrumb-nav span.current {
        color: #0f172a;
        font-weight: 700;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Action Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-outline {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .btn-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .btn-alumni {
        background: #e0f2fe;
        color: #0369a1;
        border: 1.5px solid #bae6fd;
    }
    .btn-alumni:hover {
        background: #bae6fd;
        color: #075985;
    }

    .badge-count {
        background: #0284c7;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
        font-weight: 800;
    }

    /* 4 Stat Cards Matching Design */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        width: 100%;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #e2e8f0;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 0;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .icon-bg-purple { background: #ede9fe; color: #7c3aed; }
    .icon-bg-green  { background: #dcfce7; color: #16a34a; }
    .icon-bg-pink   { background: #ffe4e6; color: #e11d48; }
    .icon-bg-orange { background: #ffedd5; color: #ea580c; }

    .stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .stat-sub {
        font-size: 11.5px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* Main Table & Filter Card */
    .main-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    /* Filter Toolbar Grid */
    .filter-toolbar {
        padding: 18px 20px;
        background: #ffffff;
        border-bottom: 1.5px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .filter-form-grid {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-input-group {
        position: relative;
        flex: 1 1 200px;
        min-width: 180px;
    }

    .search-input-group i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-group input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13.5px;
        color: #0f172a;
        font-weight: 500;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .search-input-group input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .filter-select {
        flex: 0 1 auto;
        min-width: 130px;
        padding: 10px 32px 10px 14px;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 10px center;
        background-size: 13px;
        appearance: none;
        -webkit-appearance: none;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13.5px;
        color: #334155;
        font-weight: 600;
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .filter-select:focus {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .btn-filter {
        padding: 10px 18px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-filter:hover {
        background: #1d4ed8;
    }

    .btn-reset {
        padding: 10px 14px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .filter-sub-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
    }

    .active-filter-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 12px;
    }

    .filter-tag {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Data Table Styling */
    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .siswa-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .siswa-table thead tr {
        background: #f8fafc;
        border-top: 1.5px solid #38bdf8;
        border-bottom: 2px solid #e2e8f0;
    }

    .siswa-table th {
        padding: 14px 18px;
        font-size: 12.5px;
        font-weight: 800;
        color: #334155;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    .siswa-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .siswa-table tbody tr:hover {
        background: #f8fafc;
    }

    .siswa-table td {
        padding: 14px 18px;
        font-size: 13.5px;
        color: #1e293b;
        vertical-align: middle;
    }

    /* Gender Badges with Icon + Text Label */
    .gender-badge-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .gender-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
    }

    .gender-badge-l {
        background: #818cf8;
        color: #ffffff;
    }

    .gender-badge-p {
        background: #f87171;
        color: #ffffff;
    }

    .gender-text-l {
        font-size: 13px;
        font-weight: 700;
        color: #4338ca;
    }

    .gender-text-p {
        font-size: 13px;
        font-weight: 700;
        color: #e11d48;
    }

    /* Badges */
    .badge-kelas {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .badge-jurusan {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        background: #ede9fe;
        color: #6d28d9;
    }

    /* Non-editable Status Pill Badge */
    .status-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 20px;
        letter-spacing: 0.02em;
    }
    .status-badge-pill.active {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .status-badge-pill.inactive {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    /* Action Button (Detail Only) */
    .btn-detail-only {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-detail-only:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    /* Table Footer & Pagination */
    .table-footer {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: #f8fafc;
        border-top: 1.5px solid #f1f5f9;
    }

    /* Rich Detail Modal System */
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
        max-width: 800px;
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
    .modal-close:hover {
        color: #0f172a;
    }

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

    /* Modal Sub-cards */
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
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 12px;
    }

    .detail-item-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: block;
        margin-bottom: 3px;
    }

    .detail-item-value {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    /* Mini Stat Grid inside Modal */
    .mini-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .mini-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
    }

    .mini-stat-num {
        font-size: 18px;
        font-weight: 900;
        line-height: 1.1;
    }

    .mini-stat-text {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        margin-top: 2px;
    }

    @media (max-width: 1024px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .filter-form-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 640px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .filter-form-grid { grid-template-columns: 1fr; }
        .detail-grid-2 { grid-template-columns: 1fr; }
        .mini-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')
<div class="siswa-container">

    <!-- Header Box -->
    <div class="page-header-box">
        <div>
            <h1 class="page-main-title">Data Siswa</h1>
            <div class="breadcrumb-nav">
                <a href="{{ route('waka.dashboard') }}">Dashboard</a>
                <span>/</span>
                <span class="current">Data Siswa</span>
            </div>
        </div>

        <div class="header-actions">
            <!-- Ekspor CSV -->
            <a href="{{ route('waka.siswa.export', request()->all()) }}" class="btn-action btn-outline" title="Ekspor Data Siswa ke CSV">
                <i class="fa-solid fa-file-csv" style="color: #059669;"></i> Ekspor CSV
            </a>

            <!-- Cetak Dokumen -->
            <a href="{{ route('waka.siswa.print', request()->all()) }}" target="_blank" class="btn-action btn-outline" title="Cetak Data Siswa">
                <i class="fa-solid fa-print" style="color: #2563eb;"></i> Cetak
            </a>

            <!-- Data Alumni -->
            <a href="{{ route('waka.siswa.alumni') }}" class="btn-action btn-alumni" title="Lihat Data Siswa Alumni">
                <i class="fa-solid fa-user-graduate"></i> Data Alumni
                @if(($stats['alumni_count'] ?? 0) > 0)
                    <span class="badge-count">{{ $stats['alumni_count'] }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div style="background:#ecfdf5; border:1.5px solid #a7f3d0; color:#065f46; padding:14px 18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-check" style="font-size:18px; color:#10b981;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fef2f2; border:1.5px solid #fecaca; color:#991b1b; padding:14px 18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px; color:#ef4444;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- 4 Stat Cards Matching Design -->
    <div class="stat-cards-grid">
        <!-- 1. Total Siswa -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-bg-purple">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Siswa</span>
                <span class="stat-value">{{ number_format($stats['total_siswa'], 0, ',', '.') }}</span>
                <span class="stat-sub">Semua Siswa</span>
            </div>
        </div>

        <!-- 2. Siswa Laki-laki -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-bg-green">
                <i class="fa-solid fa-person"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Siswa Laki-laki</span>
                <span class="stat-value">{{ number_format($stats['total_laki'], 0, ',', '.') }}</span>
                <span class="stat-sub">{{ $stats['persen_laki'] }}%</span>
            </div>
        </div>

        <!-- 3. Siswa Perempuan -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-bg-pink">
                <i class="fa-solid fa-person-dress"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Siswa Perempuan</span>
                <span class="stat-value">{{ number_format($stats['total_perempuan'], 0, ',', '.') }}</span>
                <span class="stat-sub">{{ $stats['persen_perempuan'] }}%</span>
            </div>
        </div>

        <!-- 4. Total Kelas -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-bg-orange">
                <i class="fa-solid fa-school"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Kelas</span>
                <span class="stat-value">{{ number_format($stats['total_kelas'], 0, ',', '.') }}</span>
                <span class="stat-sub">Kelas Aktif</span>
            </div>
        </div>
    </div>

    <!-- Main Data Table & Filter Card -->
    <div class="main-card">
        
        <!-- Filter Toolbar -->
        <div class="filter-toolbar">
            <form method="GET" action="{{ route('waka.siswa') }}" class="filter-form-grid" id="filterForm">
                <!-- 1. Search Box -->
                <div class="search-input-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / NIS / kelas...">
                </div>

                <!-- 2. Filter Kelas -->
                <select name="id_kelas" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($id_kelas == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <!-- 3. Filter Jurusan -->
                <select name="id_jurusan" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusanList as $j)
                        <option value="{{ $j->id_jurusan }}" {{ ($id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>
                            {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                        </option>
                    @endforeach
                </select>

                <!-- 4. Filter Tingkat -->
                <select name="tingkat" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Tingkat</option>
                    <option value="X" {{ ($tingkat == 'X') ? 'selected' : '' }}>Kelas X</option>
                    <option value="XI" {{ ($tingkat == 'XI') ? 'selected' : '' }}>Kelas XI</option>
                    <option value="XII" {{ ($tingkat == 'XII') ? 'selected' : '' }}>Kelas XII</option>
                </select>

                <!-- 5. Filter JK -->
                <select name="jenis_kelamin" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua JK</option>
                    <option value="L" {{ ($jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ ($jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan (P)</option>
                </select>

                <!-- 6. Filter Status -->
                <select name="status" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ ($status === 'active') ? 'selected' : '' }}>Aktif (ON)</option>
                    <option value="inactive" {{ ($status === 'inactive') ? 'selected' : '' }}>Nonaktif (OFF)</option>
                </select>

                <!-- 7. Action Buttons -->
                <div style="display:flex; gap:6px;">
                    <button type="submit" class="btn-filter" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('waka.siswa') }}" class="btn-reset" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </form>

            <!-- Filter Sub-bar: Active Tag Indicators -->
            <div class="filter-sub-bar">
                <div class="active-filter-tags">
                    <span style="font-weight:700; color:#64748b;">Filter Aktif:</span>
                    @if(!empty($search))
                        <span class="filter-tag"><i class="fa-solid fa-magnifying-glass"></i> "{{ $search }}"</span>
                    @endif
                    @if(!empty($id_kelas))
                        @php $selKls = $kelasList->firstWhere('id_kelas', $id_kelas); @endphp
                        @if($selKls) <span class="filter-tag"><i class="fa-solid fa-door-open"></i> {{ $selKls->nama_kelas }}</span> @endif
                    @endif
                    @if(!empty($id_jurusan))
                        @php $selJur = $jurusanList->firstWhere('id_jurusan', $id_jurusan); @endphp
                        @if($selJur) <span class="filter-tag"><i class="fa-solid fa-book"></i> {{ $selJur->kode_jurusan }}</span> @endif
                    @endif
                    @if(!empty($tingkat))
                        <span class="filter-tag"><i class="fa-solid fa-layer-group"></i> Tingkat {{ $tingkat }}</span>
                    @endif
                    @if(!empty($jenis_kelamin))
                        <span class="filter-tag"><i class="fa-solid fa-venus-mars"></i> {{ $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    @endif
                    @if(!empty($status))
                        <span class="filter-tag"><i class="fa-solid fa-power-off"></i> {{ $status == 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                    @endif
                    @if(empty($search) && empty($id_kelas) && empty($id_jurusan) && empty($tingkat) && empty($jenis_kelamin) && empty($status))
                        <span style="color:#94a3b8; font-style:italic;">Menampilkan seluruh data siswa</span>
                    @endif
                </div>

                <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                    Total: <strong style="color: #2563eb;">{{ $siswas->total() }}</strong> Siswa
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-scroll-wrapper">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 140px;">NISN</th>
                        <th>Nama Siswa</th>
                        <th style="width: 130px;">Kelas</th>
                        <th style="width: 100px;">Jurusan</th>
                        <th style="width: 150px;">Jenis Kelamin</th>
                        <th style="width: 160px;">Tanggal Lahir</th>
                        <th style="width: 130px; text-align: center;">Status</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $idx => $s)
                        @php
                            $isFemale = ($s->jenis_kelamin == 'P');
                            $genderClass = $isFemale ? 'gender-badge-p' : 'gender-badge-l';
                            $genderIcon  = $isFemale ? 'fa-person-dress' : 'fa-person';
                            $genderLabel = $isFemale ? 'Perempuan' : 'Laki-laki';
                            $genderTextClass = $isFemale ? 'gender-text-p' : 'gender-text-l';
                            $formattedTgl = $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') : '-';
                            $jurusanKode = $s->kelas && $s->kelas->jurusan ? $s->kelas->jurusan->kode_jurusan : ($s->kelas->nama_kelas ?? '-');
                        @endphp
                        <tr id="row-siswa-{{ $s->id_siswa }}">
                            <td style="text-align: center; color: #64748b; font-weight: 700;">
                                {{ $siswas->firstItem() + $idx }}
                            </td>
                            <td>
                                <span style="font-family: monospace; font-weight: 700; color: #0f172a; letter-spacing: 0.05em;">{{ $s->nisn }}</span>
                                @if($s->nis)
                                    <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">NIS: {{ $s->nis }}</div>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #0f172a; font-weight: 800; cursor: pointer;" onclick="fetchAndShowDetailSiswa({{ $s->id_siswa }})" title="Klik untuk melihat detail lengkap siswa">
                                    {{ $s->nama_siswa }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge-kelas">{{ $s->kelas->nama_kelas ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge-jurusan">{{ $jurusanKode }}</span>
                            </td>
                            <td>
                                <!-- Cute Circular Badge + Text Label Matching Request -->
                                <div class="gender-badge-wrap" title="{{ $genderLabel }}">
                                    <div class="gender-badge {{ $genderClass }}">
                                        <i class="fa-solid {{ $genderIcon }}"></i>
                                    </div>
                                    <span class="{{ $genderTextClass }}">{{ $genderLabel }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $formattedTgl }}</span>
                                @if($s->kota_lahir)
                                    <div style="font-size: 11px; color: #94a3b8;">{{ $s->kota_lahir }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <!-- Non-editable Status Badge Pill -->
                                @if($s->is_active ?? 1)
                                    <span class="status-badge-pill active" title="Status Siswa: Aktif Terdaftar">
                                        <i class="fa-solid fa-circle-check"></i> Aktif
                                    </span>
                                @else
                                    <span class="status-badge-pill inactive" title="Status Siswa: Nonaktif">
                                        <i class="fa-solid fa-circle-xmark"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <!-- Hanya Fitur Lihat Detail Siswa Lengkap -->
                                <button type="button" class="btn-detail-only" onclick="fetchAndShowDetailSiswa({{ $s->id_siswa }})" title="Lihat Detail Lengkap Siswa">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <div style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1;"><i class="fa-solid fa-user-slash"></i></div>
                                <h4 style="font-size: 16px; font-weight: 800; color: #475569; margin: 0 0 6px 0;">Tidak Ada Data Siswa Ditemukan</h4>
                                <p style="font-size: 13px; margin: 0;">Silakan periksa kata kunci pencarian atau sesuaikan filter yang digunakan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer & Pagination -->
        <div class="table-footer">
            {{ $siswas->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL SISWA RINCI & LENGKAP -->
<!-- ========================================================================= -->
<div class="modal-backdrop" id="modalDetailSiswa">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-id-card" style="color: #2563eb;"></i> Detail Lengkap Siswa
            </h3>
            <button type="button" class="modal-close" onclick="closeModalDetailSiswa()">&times;</button>
        </div>

        <div class="modal-body" id="detailModalBody">
            <!-- Loading State -->
            <div id="detailLoading" style="text-align: center; padding: 40px 20px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: #2563eb;"></i>
                <p style="margin: 12px 0 0; color: #64748b; font-weight: 700; font-size: 14px;">Memuat data lengkap siswa...</p>
            </div>

            <!-- Content State -->
            <div id="detailContent" style="display: none;">
                <!-- Profile Header Banner -->
                <div style="display: flex; align-items: center; gap: 18px; padding-bottom: 18px; border-bottom: 1.5px solid #e2e8f0; margin-bottom: 16px;">
                    <div id="detailAvatar" style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 800; color: #ffffff; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    </div>
                    <div>
                        <h3 id="detailNama" style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 4px 0;"></h3>
                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <span id="detailBadgeKelas" class="badge-kelas"></span>
                            <span id="detailBadgeJurusan" class="badge-jurusan"></span>
                            <span id="detailBadgeStatus" class="status-badge-pill active"></span>
                        </div>
                    </div>
                </div>

                <!-- Section 1: Biodata Siswa -->
                <div class="detail-section-card">
                    <h4 class="detail-section-title">
                        <i class="fa-solid fa-user" style="color: #2563eb;"></i> Biodata Pribadi
                    </h4>
                    <div class="detail-grid-2">
                        <div class="detail-item-box">
                            <span class="detail-item-label">NISN</span>
                            <span id="detailNisn" class="detail-item-value" style="font-family: monospace;"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">NIS</span>
                            <span id="detailNis" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">Jenis Kelamin</span>
                            <span id="detailJk" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">Tempat & Tanggal Lahir</span>
                            <span id="detailTtl" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box" style="grid-column: 1 / -1;">
                            <span class="detail-item-label">Alamat Lengkap</span>
                            <span id="detailAlamat" class="detail-item-value" style="font-weight: 600; color: #334155;"></span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Akademik & Wali Kelas & Orang Tua -->
                <div class="detail-section-card">
                    <h4 class="detail-section-title">
                        <i class="fa-solid fa-graduation-cap" style="color: #7c3aed;"></i> Informasi Kelas & Wali
                    </h4>
                    <div class="detail-grid-2">
                        <div class="detail-item-box">
                            <span class="detail-item-label">Kelas & Tingkat</span>
                            <span id="detailKelasTingkat" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">Kompetensi Keahlian (Jurusan)</span>
                            <span id="detailJurusan" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">Wali Kelas</span>
                            <span id="detailWaliKelas" class="detail-item-value"></span>
                        </div>
                        <div class="detail-item-box">
                            <span class="detail-item-label">Akun Orang Tua / Wali</span>
                            <span id="detailOrtu" class="detail-item-value"></span>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Rekapitulasi Kesiswaan & Kedisiplinan -->
                <div class="detail-section-card">
                    <h4 class="detail-section-title">
                        <i class="fa-solid fa-chart-pie" style="color: #059669;"></i> Rekap Kesiswaan & Kedisiplinan
                    </h4>
                    <div class="mini-stat-grid">
                        <div class="mini-stat-card" style="border-top: 3px solid #2563eb;">
                            <div class="mini-stat-num" id="statDispen" style="color: #2563eb;">0</div>
                            <div class="mini-stat-text">Dispensasi</div>
                        </div>
                        <div class="mini-stat-card" style="border-top: 3px solid #ea580c;">
                            <div class="mini-stat-num" id="statTelat" style="color: #ea580c;">0</div>
                            <div class="mini-stat-text">Siswa Telat</div>
                        </div>
                        <div class="mini-stat-card" style="border-top: 3px solid #e11d48;">
                            <div class="mini-stat-num" id="statAbsen" style="color: #e11d48;">0</div>
                            <div class="mini-stat-text">Total Izin/Sakit/Alpa</div>
                        </div>
                        <div class="mini-stat-card" style="border-top: 3px solid #16a34a;">
                            <div class="mini-stat-num" id="statPrestasi" style="color: #16a34a;">0</div>
                            <div class="mini-stat-text">Prestasi Siswa</div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Riwayat Kesiswaan Terbaru (Dispensasi, Keterlambatan, Prestasi) -->
                <div id="sectionRiwayat" style="display: none;">
                    <!-- Riwayat Dispensasi -->
                    <div id="boxDispen" class="detail-section-card" style="display: none;">
                        <h4 class="detail-section-title">
                            <i class="fa-solid fa-clock-rotate-left" style="color: #2563eb;"></i> Riwayat Dispensasi Terbaru
                        </h4>
                        <div id="listDispen" style="font-size: 13px;"></div>
                    </div>

                    <!-- Riwayat Keterlambatan -->
                    <div id="boxTelat" class="detail-section-card" style="display: none;">
                        <h4 class="detail-section-title">
                            <i class="fa-solid fa-person-running" style="color: #ea580c;"></i> Riwayat Keterlambatan (Siswa Telat)
                        </h4>
                        <div id="listTelat" style="font-size: 13px;"></div>
                    </div>

                    <!-- Riwayat Prestasi -->
                    <div id="boxPrestasi" class="detail-section-card" style="display: none;">
                        <h4 class="detail-section-title">
                            <i class="fa-solid fa-trophy" style="color: #16a34a;"></i> Riwayat Prestasi Siswa
                        </h4>
                        <div id="listPrestasi" style="font-size: 13px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeModalDetailSiswa()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    async function fetchAndShowDetailSiswa(id) {
        const modal = document.getElementById('modalDetailSiswa');
        const loading = document.getElementById('detailLoading');
        const content = document.getElementById('detailContent');

        modal.classList.add('show');
        loading.style.display = 'block';
        content.style.display = 'none';

        try {
            const response = await fetch(`/waka/siswa/${id}/detail`);
            const res = await response.json();

            if (res.success && res.data) {
                const d = res.data;
                const isFemale = d.jk_code === 'P';

                // Avatar & Name
                const avatar = document.getElementById('detailAvatar');
                avatar.style.background = isFemale ? '#f43f5e' : '#2563eb';
                avatar.innerHTML = isFemale ? '<i class="fa-solid fa-person-dress"></i>' : '<i class="fa-solid fa-person"></i>';

                document.getElementById('detailNama').innerText = d.nama_siswa;
                document.getElementById('detailBadgeKelas').innerText = d.kelas.nama_kelas;
                document.getElementById('detailBadgeJurusan').innerText = d.kelas.kode_jurusan;

                const badgeStatus = document.getElementById('detailBadgeStatus');
                badgeStatus.innerText = d.status_label;
                badgeStatus.className = 'status-badge-pill ' + (d.is_active ? 'active' : 'inactive');

                // Biodata
                document.getElementById('detailNisn').innerText = d.nisn;
                document.getElementById('detailNis').innerText = d.nis;
                document.getElementById('detailJk').innerText = d.jenis_kelamin;
                document.getElementById('detailTtl').innerText = `${d.kota_lahir}, ${d.tanggal_lahir} (${d.usia})`;
                document.getElementById('detailAlamat').innerText = d.alamat_lengkap;

                // Akademik
                document.getElementById('detailKelasTingkat').innerText = `${d.kelas.nama_kelas} (Tingkat ${d.kelas.tingkat})`;
                document.getElementById('detailJurusan').innerText = d.kelas.jurusan;
                document.getElementById('detailWaliKelas').innerText = `${d.kelas.wali_kelas} (NIP: ${d.kelas.nip_wali})`;
                document.getElementById('detailOrtu').innerText = d.orang_tua.terdaftar ? `${d.orang_tua.nama} (${d.orang_tua.username})` : 'Belum terhubung akun Orang Tua';

                // Statistik Kesiswaan
                document.getElementById('statDispen').innerText = d.statistik.total_dispen;
                document.getElementById('statTelat').innerText = d.statistik.total_telat;
                document.getElementById('statAbsen').innerText = (d.statistik.total_sakit + d.statistik.total_izin + d.statistik.total_alpa);
                document.getElementById('statPrestasi').innerText = d.statistik.total_prestasi;

                // Riwayat Section
                const secRiwayat = document.getElementById('sectionRiwayat');
                let hasRiwayat = false;

                // 1. Dispensasi
                const boxDispen = document.getElementById('boxDispen');
                const listDispen = document.getElementById('listDispen');
                if (d.riwayat && d.riwayat.dispensasi && d.riwayat.dispensasi.length > 0) {
                    hasRiwayat = true;
                    boxDispen.style.display = 'block';
                    let html = '<ul style="margin: 0; padding-left: 18px; color: #334155; line-height: 1.6;">';
                    d.riwayat.dispensasi.forEach(item => {
                        const info = item.tempat ? `${item.alasan} (Tempat: ${item.tempat})` : item.alasan;
                        html += `<li><strong>${info}</strong> (${item.tanggal}) — Status Waka: <span style="font-weight:700; color:${item.status_waka === 'approved' ? '#16a34a' : (item.status_waka === 'rejected' ? '#dc2626' : '#d97706')}">${item.status_waka || 'Pending'}</span></li>`;
                    });
                    html += '</ul>';
                    listDispen.innerHTML = html;
                } else {
                    boxDispen.style.display = 'none';
                }

                // 2. Telat
                const boxTelat = document.getElementById('boxTelat');
                const listTelat = document.getElementById('listTelat');
                if (d.riwayat && d.riwayat.telat && d.riwayat.telat.length > 0) {
                    hasRiwayat = true;
                    boxTelat.style.display = 'block';
                    let html = '<ul style="margin: 0; padding-left: 18px; color: #334155; line-height: 1.6;">';
                    d.riwayat.telat.forEach(item => {
                        html += `<li><strong>${item.alasan || 'Terlambat Datang'}</strong> (Pukul ${item.jam_terlambat || '-'}, ${item.tanggal}) — Tindakan: <span style="color:#ea580c; font-weight:700;">${item.tindakan_hukuman || 'Diberi Arahan Piket'}</span></li>`;
                    });
                    html += '</ul>';
                    listTelat.innerHTML = html;
                } else {
                    boxTelat.style.display = 'none';
                }

                // 3. Prestasi
                const boxPrestasi = document.getElementById('boxPrestasi');
                const listPrestasi = document.getElementById('listPrestasi');
                if (d.riwayat && d.riwayat.prestasi && d.riwayat.prestasi.length > 0) {
                    hasRiwayat = true;
                    boxPrestasi.style.display = 'block';
                    let html = '<ul style="margin: 0; padding-left: 18px; color: #334155; line-height: 1.6;">';
                    d.riwayat.prestasi.forEach(item => {
                        html += `<li><strong>${item.nama_prestasi}</strong> (${item.peringkat || 'Peserta'}) — Tingkat ${item.tingkat || 'Sekolah'} (${item.kategori || 'Umum'})</li>`;
                    });
                    html += '</ul>';
                    listPrestasi.innerHTML = html;
                } else {
                    boxPrestasi.style.display = 'none';
                }

                secRiwayat.style.display = hasRiwayat ? 'block' : 'none';

                loading.style.display = 'none';
                content.style.display = 'block';
            } else {
                alert(res.message || 'Gagal mengambil data siswa.');
                closeModalDetailSiswa();
            }
        } catch (e) {
            console.error(e);
            alert('Terjadi kesalahan koneksi.');
            closeModalDetailSiswa();
        }
    }

    function closeModalDetailSiswa() {
        document.getElementById('modalDetailSiswa').classList.remove('show');
    }
</script>
@endsection