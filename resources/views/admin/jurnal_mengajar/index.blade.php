@extends('layouts.admin')

@section('title', 'Akademik - Jurnal Mengajar — EDU JOURNAL')

@section('styles')
<style>
    .page-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header-title h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .page-header-title p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
    }

    /* Top Action Bar (Without search input) */
    .top-action-bar {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-action-export {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        padding: 10px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-action-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-action-add {
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(30, 41, 59, 0.25);
        transition: background-color 0.2s, transform 0.1s;
    }

    .btn-action-add:hover {
        background: #0f172a;
        transform: translateY(-1px);
    }

    /* Red Card: Laporan Guru Alpa */
    .card-alpa {
        background: #fee2e2;
        border-radius: 20px;
        padding: 22px 24px;
        margin-bottom: 24px;
        border: 1px solid #fca5a5;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.05);
    }

    .card-alpa-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-alpa h2 {
        font-size: 20px;
        font-weight: 800;
        color: #991b1b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-alpa {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .table-alpa th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 12px 16px;
        text-align: left;
        background: #ffffff;
        border-bottom: 1px solid #fee2e2;
    }

    .table-alpa td {
        padding: 12px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #fecaca;
        vertical-align: middle;
    }

    /* Pagination for Laporan Guru Alpa */
    .alpa-pagination-wrapper {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed #fca5a5;
    }

    .alpa-pagination-container {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .alpa-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border: none;
        background: transparent;
        color: #334155;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .alpa-page-btn:hover:not(:disabled) {
        background: #f1f5f9;
        color: #0f172a;
    }

    .alpa-page-btn.active {
        background: #1e293b;
        color: #ffffff !important;
        box-shadow: 0 2px 5px rgba(30, 41, 59, 0.3);
    }

    .alpa-page-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .alpa-page-btn.alpa-nav-btn {
        font-size: 12px;
        color: #64748b;
    }

    .badge-alpa-red {
        background: #fca5a5;
        color: #991b1b;
        font-weight: 800;
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 10px;
        display: inline-block;
    }

    /* Dark Header Banner */
    .header-banner-dark {
        background: #1f293d;
        color: #ffffff;
        border-radius: 14px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(31, 41, 61, 0.15);
    }

    .header-banner-dark i {
        font-size: 18px;
        color: #a5b6dc;
    }

    /* Filter Bar Component */
    .filter-section-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .filter-control-date {
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
    }

    .filter-select {
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        min-width: 140px;
    }

    .btn-filter-blue {
        background: #2563eb;
        color: white;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-blue:hover {
        background: #1d4ed8;
    }

    .btn-today-orange {
        background: #fbbf24;
        color: #78350f;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-today-orange:hover {
        background: #f59e0b;
    }

    .btn-filter-reset {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-reset:hover {
        background: #fecaca;
    }

    /* 4 Stat Summary Cards Grid */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .stat-purple { background: #f3e8ff; color: #9333ea; }
    .stat-green  { background: #dcfce7; color: #16a34a; }
    .stat-orange { background: #fef3c7; color: #d97706; }
    .stat-blue   { background: #dbeafe; color: #2563eb; }

    .stat-content .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
    }

    .stat-content .stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Table Component (Jurnal Tersimpan) */
    .table-container-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-container-card h2 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 18px;
    }

    .table-saved {
        width: 100%;
        border-collapse: collapse;
    }

    .table-saved th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 12px 14px;
        text-align: left;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-saved td {
        padding: 14px 14px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-hadir-green {
        background: #bbf7d0;
        color: #166534;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 14px;
        border-radius: 12px;
        display: inline-block;
    }

    .badge-absen-red {
        background: #fee2e2;
        color: #991b1b;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 14px;
        border-radius: 12px;
        display: inline-block;
    }

    /* Photo Thumbnail Component */
    .photo-thumb-box {
        width: 48px;
        height: 36px;
        background: #cbd5e1;
        border-radius: 6px;
        display: inline-block;
        object-fit: cover;
    }

    /* Action Buttons & Dropdown */
    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
    }

    .btn-action-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action-icon:hover {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
    }

    /* 3-Dots Dropdown Menu */
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .action-dropdown-menu {
        position: absolute;
        right: 0;
        top: 110%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        min-width: 170px;
        z-index: 100;
        display: none;
        overflow: hidden;
        padding: 6px 0;
    }

    .action-dropdown-menu.show {
        display: block;
    }

    .dropdown-menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.15s;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .dropdown-menu-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .dropdown-menu-item.danger-item {
        color: #dc2626;
    }

    .dropdown-menu-item.danger-item:hover {
        background: #fee2e2;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content-box {
        background: #ffffff;
        border-radius: 24px;
        max-width: 650px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 28px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
        animation: modalFadeIn 0.25s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 14px;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .btn-modal-close {
        background: transparent;
        border: none;
        font-size: 18px;
        color: #64748b;
        cursor: pointer;
    }

    .modal-body-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .detail-item-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .detail-item-box span {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .detail-item-box strong {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .pagination-bar {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Fix Laravel Pagination Giant SVG Arrows */
    .pagination-bar svg,
    nav[role="navigation"] svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
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
        min-width: 32px !important;
        height: 32px !important;
        padding: 0 8px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
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
        opacity: 0.4 !important;
        cursor: not-allowed !important;
        background: #f8fafc !important;
    }
</style>
@endsection

@section('content')

    <!-- Top Header Title & Actions (Top Search Bar Removed as requested) -->
    <div class="page-header-container">
        <div class="page-header-title">
            <h1>Akademik - Jurnal Mengajar</h1>
            <p>Catatan kegiatan mengajar guru setiap pertemuan</p>
        </div>

        <div class="top-action-bar">
            <a href="{{ route('admin.jurnal-mengajar.export', request()->query()) }}" class="btn-action-export">
                <i class="fa-solid fa-download"></i>
                <span>Export</span>
            </a>

            <button type="button" class="btn-action-add" onclick="openCreateModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah jurnal</span>
            </button>
        </div>
    </div>

    <!-- Container 1: Laporan Guru Alpa -->
    <div class="card-alpa">
        <div class="card-alpa-header">
            <h2>
                <i class="fa-solid fa-triangle-exclamation"></i>
                Laporan Guru Alpa - {{ \Carbon\Carbon::parse($targetTanggal ?? now())->translatedFormat('d F Y') }}
            </h2>

            <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                <input type="date" name="tanggal" value="{{ $targetTanggal ?? \Carbon\Carbon::today()->toDateString() }}" class="filter-control-date" style="padding: 5px 10px; font-size: 12.5px;">
                <button type="submit" class="btn-filter-blue" style="padding: 6px 14px; font-size: 12.5px;">Filter</button>
                <a href="{{ route('admin.jurnal-mengajar') }}" class="btn-today-orange" style="padding: 6px 14px; font-size: 12.5px;">Hari Ini</a>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-alpa" id="tableGuruAlpa">
                <thead>
                    <tr>
                        <th style="width: 100px;">JAM</th>
                        <th>GURU & MAPEL</th>
                        <th>KELAS</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody id="tbodyGuruAlpa">
                    @forelse($guruAlpaList as $alpa)
                        <tr class="alpa-row">
                            <td><strong>{{ $alpa->jam_range ?? '-' }}</strong></td>
                            <td>
                                <strong>{{ $alpa->guru->nama_guru ?? '-' }}</strong><br>
                                <small style="color:#64748b;">{{ $alpa->mapel->nama_mapel ?? '-' }}</small>
                            </td>
                            <td><strong>{{ $alpa->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td><span class="badge-alpa-red">TIDAK MENGISI JURNAL (ALPA)</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #166534; font-weight: 700; padding: 16px;">
                                <i class="fa-solid fa-circle-check" style="font-size: 18px; margin-right: 6px;"></i>
                                Semua guru mengajar telah mengisi jurnal pada tanggal ini!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Bar untuk Laporan Guru Alpa --}}
        <div class="alpa-pagination-wrapper" id="alpaPaginationWrapper">
            <div class="alpa-pagination-container">
                <button type="button" class="alpa-page-btn alpa-nav-btn" id="alpaPrevBtn" title="Halaman Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div id="alpaPageNumbers" style="display: inline-flex; gap: 4px;"></div>
                <button type="button" class="alpa-page-btn alpa-nav-btn" id="alpaNextBtn" title="Halaman Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Header Navy Banner -->
    <div class="header-banner-dark">
        <i class="fa-regular fa-calendar-days"></i>
        <span>Daftar Jurnal Mengajar</span>
    </div>

    <!-- Filter Section Bar (With Search & Reset Button) -->
    <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" class="filter-section-bar">
        <div style="position:relative; flex:1; min-width:180px;">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="filter-control-date" style="width:100%; padding-left:34px;" placeholder="Cari Materi / Catatan / Guru...">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
        </div>

        <div style="display: flex; align-items: center; gap: 6px;">
            <i class="fa-regular fa-calendar" style="color: #64748b;"></i>
            <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-control-date" title="Filter Tanggal">
        </div>

        <select name="id_guru" class="filter-select">
            <option value="">Semua Guru</option>
            @foreach($guruList as $g)
                <option value="{{ $g->id_guru }}" {{ ($idGuru == $g->id_guru) ? 'selected' : '' }}>
                    {{ $g->nama_guru }}
                </option>
            @endforeach
        </select>

        <select name="id_kelas" class="filter-select">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
                <option value="{{ $k->id_kelas }}" {{ ($idKelas == $k->id_kelas) ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <select name="id_mapel" class="filter-select">
            <option value="">Semua Mapel</option>
            @foreach($mapelList as $m)
                <option value="{{ $m->id_mapel }}" {{ ($idMapel == $m->id_mapel) ? 'selected' : '' }}>
                    {{ $m->nama_mapel }}
                </option>
            @endforeach
        </select>

        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="Terlaksana" {{ ($status == 'Terlaksana') ? 'selected' : '' }}>Terlaksana (Hadir)</option>
            <option value="Belum Terlaksana" {{ ($status == 'Belum Terlaksana') ? 'selected' : '' }}>Belum Terlaksana (Izin/Sakit/Alpa)</option>
        </select>

        <button type="submit" class="btn-filter-blue">
            <i class="fa-solid fa-filter"></i>
            <span>Filter</span>
        </button>

        @if(!empty($search) || !empty($tanggal) || !empty($idGuru) || !empty($idKelas) || !empty($idMapel) || !empty($status))
            <a href="{{ route('admin.jurnal-mengajar') }}" class="btn-filter-reset" title="Reset semua filter">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>

    <!-- 4 Summary Stat Cards Grid (Dynamic & Synchronized) -->
    <div class="stat-cards-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-purple">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Pertemuan</div>
                <div class="stat-value">{{ $totalPertemuan }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Terlaksana</div>
                <div class="stat-value">{{ $terlaksanaCount }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-orange">
                <i class="fa-solid fa-clock-history"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Belum Terlaksana</div>
                <div class="stat-value">{{ $belumTerlaksanaCount }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-blue">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Guru Aktif</div>
                <div class="stat-value">{{ $guruAktifCount }} Guru</div>
            </div>
        </div>
    </div>

    <!-- Data Table Container: Jurnal Tersimpan (With Bukti Foto & Catatan & Siswa Tidak Hadir) -->
    <div class="table-container-card">
        <h2>Jurnal Tersimpan - {{ \Carbon\Carbon::parse($targetTanggal ?? now())->translatedFormat('d F Y') }}</h2>

        <div style="overflow-x: auto;">
            <table class="table-saved">
                <thead>
                    <tr>
                        <th style="width: 100px;">TANGGAL</th>
                        <th>GURU & MAPEL</th>
                        <th style="width: 90px;">KELAS</th>
                        <th style="width: 100px;">STATUS</th>
                        <th style="width: 90px;">BUKTI FOTO</th>
                        <th>MATERI/CATATAN</th>
                        <th>SISWA TIDAK HADIR</th>
                        <th style="width: 90px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                        @php
                            $isHadir = ($j->status_kehadiran_guru === 'Hadir');
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($j->tanggal)->format('Y-m-d') }}</strong>
                            </td>
                            <td>
                                <strong>{{ $j->jadwal->guru->nama_guru ?? '-' }}</strong><br>
                                <small style="color:#64748b;">{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</small>
                            </td>
                            <td>
                                <strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong>
                            </td>
                            <td>
                                @if($isHadir)
                                    <span class="badge-hadir-green">Hadir</span>
                                @else
                                    <span class="badge-absen-red">{{ $j->status_kehadiran_guru }}</span>
                                @endif
                            </td>
                            <td>
                                @if($j->dokumentasi)
                                    <img src="{{ asset('storage/' . $j->dokumentasi) }}" class="photo-thumb-box" alt="Bukti Foto">
                                @else
                                    <div class="photo-thumb-box" title="Foto tidak diupload"></div>
                                @endif
                            </td>
                            <td>
                                <div>{{ Str::limit($j->materi, 45) }}</div>
                                @if($j->catatan)
                                    <small style="color:#64748b;">{{ Str::limit($j->catatan, 35) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                                    @foreach($j->detailKetidakhadiran as $d)
                                        <span style="color:#dc2626; font-weight:700; display:block;">
                                            {{ $d->siswa->nama_siswa ?? 'Siswa' }} - {{ strtolower($d->keterangan) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span style="color:#166534; font-weight:700;">nihil</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <!-- Button 1: Eye Icon for Detail Modal -->
                                    <button type="button" class="btn-action-icon" onclick="openDetailModal({{ $j->id_jurnal }})" title="Lihat Detail Jurnal">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <!-- Button 2: 3-Dots Dropdown Menu -->
                                    <div class="action-dropdown">
                                        <button type="button" class="btn-action-icon" onclick="toggleActionDropdown(event, {{ $j->id_jurnal }})" title="Menu Aksi">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="action-dropdown-menu" id="dropdownMenu-{{ $j->id_jurnal }}">
                                            <button type="button" class="dropdown-menu-item" onclick="openDetailModal({{ $j->id_jurnal }})">
                                                <i class="fa-regular fa-eye" style="color: #2563eb;"></i>
                                                <span>Lihat Detail</span>
                                            </button>

                                            <a href="{{ route('admin.jurnal-mengajar.print-detail', $j->id_jurnal) }}" target="_blank" class="dropdown-menu-item">
                                                <i class="fa-solid fa-print" style="color: #059669;"></i>
                                                <span>Cetak / Download PDF</span>
                                            </a>

                                            <form action="{{ route('admin.jurnal-mengajar.destroy', $j->id_jurnal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-menu-item danger-item">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                    <span>Hapus Jurnal</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">
                                <i class="fa-regular fa-folder-open" style="font-size: 32px; margin-bottom: 10px; display: block; color: #94a3b8;"></i>
                                Tidak ada data jurnal tersimpan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Bar -->
        <div class="pagination-bar">
            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                Menampilkan {{ $jurnals->firstItem() ?? 0 }} - {{ $jurnals->lastItem() ?? 0 }} dari {{ $jurnals->total() }} data
            </div>
            <div>
                {{ $jurnals->links() }}
            </div>
        </div>
    </div>

    <!-- Modal 1: Detail Jurnal Popup -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content-box">
            <div class="modal-header">
                <h3>Detail Jurnal Mengajar</h3>
                <button type="button" class="btn-modal-close" onclick="closeDetailModal()">&times;</button>
            </div>

            <div id="modalDetailContent">
                <div style="text-align: center; padding: 30px; color: #64748b;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                    <p>Memuat detail jurnal...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Tambah Jurnal Mengajar Baru -->
    <div class="modal-overlay" id="createModal">
        <div class="modal-content-box">
            <div class="modal-header">
                <h3>+ Tambah Jurnal Mengajar Baru</h3>
                <button type="button" class="btn-modal-close" onclick="closeCreateModal()">&times;</button>
            </div>

            <form action="{{ route('admin.jurnal-mengajar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Pilih Jadwal Pelajaran *</label>
                        <select name="id_jadwal" class="filter-select" style="width: 100%;" required>
                            <option value="">-- Pilih Jadwal (Guru, Mapel, Kelas) --</option>
                            @foreach($jadwalList as $jadwal)
                                <option value="{{ $jadwal->id_jadwal }}">
                                    {{ $jadwal->hari }} | {{ $jadwal->kelas->nama_kelas ?? '-' }} - {{ $jadwal->mapel->nama_mapel ?? '-' }} ({{ $jadwal->guru->nama_guru ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Tanggal Mengajar *</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="filter-control-date" style="width: 100%;" required>
                        </div>

                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Status Kehadiran Guru *</label>
                            <select name="status_kehadiran_guru" class="filter-select" style="width: 100%;" required>
                                <option value="Hadir" selected>Hadir (Terlaksana)</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Tanpa Keterangan">Tanpa Keterangan (Alpa)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Materi Pembelajaran *</label>
                        <textarea name="materi" rows="3" class="filter-control-date" style="width: 100%; font-family: inherit;" placeholder="Tuliskan materi pembelajaran yang disampaikan..." required></textarea>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Catatan Pembelajaran / Kejadian (Opsional)</label>
                        <textarea name="catatan" rows="2" class="filter-control-date" style="width: 100%; font-family: inherit;" placeholder="Tuliskan catatan kejadian kelas..."></textarea>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Upload Foto Dokumentasi (Opsional)</label>
                        <input type="file" name="dokumentasi" accept="image/*" class="filter-control-date" style="width: 100%;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 14px;">
                    <button type="button" class="btn-filter-blue" style="background:#64748b;" onclick="closeCreateModal()">Batal</button>
                    <button type="submit" class="btn-action-add" style="border-radius: 12px;">Simpan Jurnal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function toggleActionDropdown(event, idJurnal) {
        event.stopPropagation();
        const allMenus = document.querySelectorAll('.action-dropdown-menu');
        allMenus.forEach(m => {
            if (m.id !== `dropdownMenu-${idJurnal}`) {
                m.classList.remove('show');
            }
        });

        const targetMenu = document.getElementById(`dropdownMenu-${idJurnal}`);
        if (targetMenu) {
            targetMenu.classList.toggle('show');
        }
    }

    document.addEventListener('click', function() {
        const allMenus = document.querySelectorAll('.action-dropdown-menu');
        allMenus.forEach(m => m.classList.remove('show'));
    });

    function openDetailModal(idJurnal) {
        const modal = document.getElementById('detailModal');
        const container = document.getElementById('modalDetailContent');

        modal.classList.add('active');
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Memuat detail jurnal...</p>
            </div>
        `;

        fetch(`{{ url('/admin/jurnal-mengajar-admin/detail') }}/${idJurnal}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const d = res.data;
                let absensiHtml = '';
                if (d.absensi_siswa && d.absensi_siswa.length > 0) {
                    absensiHtml = d.absensi_siswa.map((s, idx) => `
                        <tr>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;">${idx + 1}</td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;"><strong>${s.nama_siswa}</strong></td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;">${s.nis}</td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0; font-weight:700; color:#dc2626;">${s.keterangan}</td>
                        </tr>
                    `).join('');
                } else {
                    absensiHtml = `<tr><td colspan="4" style="text-align:center; color:#166534; font-weight:700; padding:12px;">Semua siswa hadir (Nihil)</td></tr>`;
                }

                let photoHtml = '';
                if (d.dokumentasi_url) {
                    photoHtml = `
                        <div style="margin-top:16px; text-align:center;">
                            <span style="display:block; font-size:11px; font-weight:700; color:#64748b; margin-bottom:6px;">FOTO BUKTI DOKUMENTASI</span>
                            <img src="${d.dokumentasi_url}" style="max-width:100%; max-height:240px; border-radius:12px; border:1px solid #cbd5e1; object-fit:cover;">
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div class="modal-body-grid">
                        <div class="detail-item-box">
                            <span>TANGGAL</span>
                            <strong>${d.tanggal}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>STATUS GURU</span>
                            <strong style="color: ${d.status_kehadiran_guru === 'Hadir' ? '#166534' : '#dc2626'};">${d.status_kehadiran_guru}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>GURU PENGAJAR</span>
                            <strong>${d.guru}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>MATA PELAJARAN</span>
                            <strong>${d.mapel}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>KELAS & RUANGAN</span>
                            <strong>${d.kelas} — Ruang ${d.ruangan}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>JAM KE-</span>
                            <strong>Jam Ke-${d.jam_ke}</strong>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:4px;">MATERI PEMBELAJARAN</span>
                        <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:12px; font-size:13px; line-height:1.5;">${d.materi}</div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:4px;">CATATAN PEMBELAJARAN</span>
                        <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:12px; font-size:13px; color:#475569;">${d.catatan}</div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">DAFTAR SISWA TIDAK HADIR</span>
                        <table style="width:100%; border-collapse:collapse; background:#ffffff; border:1px solid #cbd5e1; border-radius:10px; overflow:hidden; font-size:12.5px;">
                            <thead>
                                <tr style="background:#f1f5f9; text-align:left; font-size:11px; color:#475569;">
                                    <th style="padding:8px 12px;">NO</th>
                                    <th style="padding:8px 12px;">NAMA SISWA</th>
                                    <th style="padding:8px 12px;">NISN</th>
                                    <th style="padding:8px 12px;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>${absensiHtml}</tbody>
                        </table>
                    </div>

                    ${photoHtml}

                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; border-top:1px solid #e2e8f0; padding-top:14px;">
                        <a href="{{ url('/admin/jurnal-mengajar-admin/print-detail') }}/${d.id_jurnal}" target="_blank" class="btn-action-add" style="border-radius:12px; text-decoration:none;">
                            <i class="fa-solid fa-print"></i> Cetak PDF / Detail
                        </a>
                    </div>
                `;
            }
        })
        .catch(err => {
            container.innerHTML = `<p style="color:#dc2626; text-align:center;">Gagal memuat detail jurnal.</p>`;
        });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    function openCreateModal() {
        document.getElementById('createModal').classList.add('active');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.remove('active');
    }

    // ── Pagination for Laporan Guru Alpa Table ─────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 5;
        const rows = document.querySelectorAll('#tbodyGuruAlpa tr.alpa-row');
        const totalRows = rows.length;
        const paginationWrapper = document.getElementById('alpaPaginationWrapper');
        const pageNumbersContainer = document.getElementById('alpaPageNumbers');
        const prevBtn = document.getElementById('alpaPrevBtn');
        const nextBtn = document.getElementById('alpaNextBtn');

        if (!paginationWrapper) return;

        if (totalRows <= rowsPerPage) {
            paginationWrapper.style.display = 'none';
            return;
        }

        paginationWrapper.style.display = 'flex';
        let currentPage = 1;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            renderPageNumbers();
            if (prevBtn) prevBtn.disabled = (currentPage === 1);
            if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
        }

        function renderPageNumbers() {
            if (!pageNumbersContainer) return;
            pageNumbersContainer.innerHTML = '';

            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'alpa-page-btn' + (i === currentPage ? ' active' : '');
                btn.textContent = i;
                btn.addEventListener('click', function () {
                    showPage(i);
                });
                pageNumbersContainer.appendChild(btn);
            }
        }

        if (prevBtn) {
            prevBtn.onclick = function () {
                if (currentPage > 1) showPage(currentPage - 1);
            };
        }

        if (nextBtn) {
            nextBtn.onclick = function () {
                if (currentPage < totalPages) showPage(currentPage + 1);
            };
        }

        showPage(1);
    });
</script>
@endsection
