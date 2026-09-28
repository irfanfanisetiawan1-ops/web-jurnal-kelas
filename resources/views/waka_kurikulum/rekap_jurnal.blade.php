@extends('layouts.waka_kurikulum')

@section('title', 'Rekap Jurnal Mengajar — Waka Kurikulum')

@section('styles')
<style>
    .rekap-container {
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

    .btn-primary { 
        background: #2563eb; 
        color: #ffffff; 
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25); 
    }
    .btn-primary:hover { 
        background: #1d4ed8; 
        transform: translateY(-1px); 
    }

    .btn-outline { 
        background: #ffffff; 
        color: #334155; 
        border: 1px solid #cbd5e1; 
    }
    .btn-outline:hover { 
        background: #f8fafc; 
        border-color: #94a3b8; 
    }

    /* 4 Stat Cards */
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

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
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

    /* Table Card */
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

    .desktop-rekap-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 950px;
    }

    .rekap-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .rekap-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .rekap-table tr:hover td { 
        background: #f8fafc; 
    }

    .badge-kondisi {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }
    .badge-kondusif { background: #dcfce7; color: #15803d; }
    .badge-cukup    { background: #e0e7ff; color: #4338ca; }
    .badge-kurang   { background: #fef3c7; color: #b45309; }

    .badge-verif {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }
    .verif-yes { background: #dcfce7; color: #15803d; }
    .verif-no  { background: #f1f5f9; color: #64748b; }

    /* Class Chip & Badges */
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

    /* Mobile Rekap Cards (Hidden on Desktop) */
    .mobile-rekap-wrapper {
        display: none;
    }

    /* Detail Modal */
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
        max-width: 600px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        overflow-y: auto;
    }

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
        display: flex;
        align-items: center;
        gap: 8px;
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

    .modal-body { 
        padding: 20px; 
    }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1024px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .filter-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .rekap-container {
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

        /* Filter Card on Mobile */
        .filter-card {
            padding: 14px !important;
            border-radius: 14px !important;
        }

        .filter-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
        }

        .form-group-filter {
            width: 100% !important;
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

        /* Hide Wide Desktop Table, Show Mobile Cards */
        .desktop-rekap-table-wrapper {
            display: none !important;
        }

        .mobile-rekap-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 12px !important;
            background: #f8fafc !important;
        }

        .mobile-rekap-card {
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

        .mobile-rekap-card:hover {
            border-color: #cbd5e1;
        }

        .mobile-rekap-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }

        .mobile-rekap-header-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .mobile-rekap-index {
            font-weight: 800;
            color: #94a3b8;
            font-size: 11.5px;
        }

        .mobile-rekap-header-badges {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .mobile-rekap-body {
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

        .mobile-materi-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #3b82f6;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 12px;
            color: #334155;
            line-height: 1.4;
        }

        .mobile-rekap-meta-grid {
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

        /* Modal Mobile Optimization */
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
        .filter-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="rekap-container">

    {{-- Header --}}
    <div class="page-header-box">
        <div>
            <h1 class="page-main-title">Rekap Jurnal Mengajar</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Pemantauan KBM, Materi Ajar, dan Ketercapaian Pembelajaran</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('waka-kurikulum.rekap-jurnal.print', request()->all()) }}" target="_blank" class="btn-action btn-outline">
                <i class="fa-solid fa-print"></i> Cetak Rekap
            </a>
            <a href="{{ route('waka-kurikulum.rekap-jurnal.export', request()->all()) }}" class="btn-action btn-primary">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Jurnal Tercatat</span>
                <span class="stat-count">{{ number_format($stats['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Jurnal Hari Ini</span>
                <span class="stat-count">{{ number_format($stats['today'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Tingkat Kondusif</span>
                <span class="stat-count">{{ $stats['kondusif_persen'] ?? 100 }}%</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Absensi Siswa</span>
                <span class="stat-count">{{ number_format($stats['total_absen'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('waka-kurikulum.rekap-jurnal') }}" class="filter-grid">
            <div class="form-group-filter">
                <label>Pilih Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control-filter" onchange="this.form.submit()">
            </div>

            <div class="form-group-filter">
                <label>Filter Kelas</label>
                <select name="id_kelas" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($idKelas == $k->id_kelas) ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Guru</label>
                <select name="id_guru" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Guru --</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}" {{ ($idGuru == $g->id_guru) ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Mapel</label>
                <select name="id_mapel" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Mapel --</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ ($idMapel == $m->id_mapel) ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter filter-search-col">
                <label>Cari Materi / Catatan</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control-filter" placeholder="Ketik kata kunci pencarian...">
            </div>

            <div class="filter-btn-group">
                <button type="submit" class="btn-action btn-primary" style="height: 38px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <a href="{{ route('waka-kurikulum.rekap-jurnal') }}" class="btn-action btn-outline" style="height: 38px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="table-wrapper-card">
        <div class="table-header-bar">
            <div class="table-header-title">
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                Daftar Data Rekap Jurnal Mengajar
            </div>
            <div class="table-header-count">
                Menampilkan <span style="color: #0f172a; font-weight: 800;">{{ $jurnalList->firstItem() ?? 0 }} - {{ $jurnalList->lastItem() ?? 0 }}</span> dari <span style="color: #0f172a; font-weight: 800;">{{ $jurnalList->total() }}</span> Data
            </div>
        </div>

        {{-- Desktop View Table (100% Intact) --}}
        <div class="desktop-rekap-table-wrapper">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th>TANGGAL &amp; JAM</th>
                        <th>KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>GURU PENGAJAR</th>
                        <th>MATERI PEMBELAJARAN</th>
                        <th>KONDISI</th>
                        <th>STATUS JURNAL</th>
                        <th style="text-align: center;">DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnalList as $j)
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">
                                    {{ Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                                    Jam {{ $j->jadwal->jam_mulai_ke ?? '-' }} - {{ $j->jadwal->jam_selesai_ke ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="class-chip">
                                    <i class="fa-solid fa-graduation-cap"></i> {{ $j->jadwal->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td style="font-weight: 700;">
                                {{ $j->jadwal->mapel->nama_mapel ?? '-' }}
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    {{ $j->jadwal->guru->nama_guru ?? '-' }}
                                </div>
                                @if($j->guruPengganti)
                                    <div style="font-size: 11px; color: #059669; font-weight: 700; margin-top: 2px;">
                                        <i class="fa-solid fa-user-tag"></i> Pengganti: {{ $j->guruPengganti->nama_guru }}
                                    </div>
                                @endif
                            </td>
                            <td style="max-width: 250px;">
                                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;" title="{{ $j->materi }}">
                                    {{ $j->materi ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-kondisi {{ stripos($j->kondisi_kelas, 'Kondusif') !== false ? 'badge-kondusif' : 'badge-kurang' }}">
                                    {{ $j->kondisi_kelas ?? 'Kondusif' }}
                                </span>
                            </td>
                            <td>
                                @if(($j->is_draft ?? 0) == 0)
                                    <span class="badge-verif verif-yes"><i class="fa-solid fa-circle-check"></i> Selesai</span>
                                @else
                                    <span class="badge-verif verif-no"><i class="fa-solid fa-file-pen"></i> Draft</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action btn-outline" style="padding: 5px 10px; font-size: 12px;" onclick="loadDetailJurnal({{ $j->id_jurnal }})">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                <i class="fa-regular fa-folder-open" style="font-size: 36px; margin-bottom: 8px;"></i>
                                <p style="font-weight: 700; margin-top: 4px;">Tidak ada rekap jurnal mengajar yang sesuai filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile View Cards (Responsive for Handphones <= 768px) --}}
        <div class="mobile-rekap-wrapper">
            @forelse($jurnalList as $index => $j)
                <div class="mobile-rekap-card">
                    {{-- Header Card --}}
                    <div class="mobile-rekap-header">
                        <div class="mobile-rekap-header-left">
                            <span class="mobile-rekap-index">#{{ $jurnalList->firstItem() + $index }}</span>
                            <span class="class-chip">
                                <i class="fa-solid fa-graduation-cap"></i> {{ $j->jadwal->kelas->nama_kelas ?? '-' }}
                            </span>
                        </div>
                        <div class="mobile-rekap-header-badges">
                            <span class="badge-kondisi {{ stripos($j->kondisi_kelas, 'Kondusif') !== false ? 'badge-kondusif' : 'badge-kurang' }}">
                                {{ $j->kondisi_kelas ?? 'Kondusif' }}
                            </span>
                            @if(($j->is_draft ?? 0) == 0)
                                <span class="badge-verif verif-yes"><i class="fa-solid fa-circle-check"></i> Selesai</span>
                            @else
                                <span class="badge-verif verif-no"><i class="fa-solid fa-file-pen"></i> Draft</span>
                            @endif
                        </div>
                    </div>

                    {{-- Body Card --}}
                    <div class="mobile-rekap-body">
                        <div class="mobile-mapel-title">{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</div>
                        <div class="mobile-guru-info">
                            <span><i class="fa-solid fa-chalkboard-user" style="color: #64748b;"></i> {{ $j->jadwal->guru->nama_guru ?? '-' }}</span>
                            @if($j->guruPengganti)
                                <div style="width: 100%; font-size: 11px; color: #059669; font-weight: 700; margin-top: 2px;">
                                    <i class="fa-solid fa-user-tag"></i> Pengganti: {{ $j->guruPengganti->nama_guru }}
                                </div>
                            @endif
                        </div>

                        {{-- Materi --}}
                        <div class="mobile-materi-box">
                            <div style="font-size: 10.5px; font-weight: 800; color: #64748b; margin-bottom: 2px; text-transform: uppercase;">
                                Materi Pembelajaran:
                            </div>
                            <div style="font-weight: 600;">{{ $j->materi ?? '-' }}</div>
                        </div>

                        {{-- Meta Info --}}
                        <div class="mobile-rekap-meta-grid">
                            <div class="mobile-meta-item">
                                <span class="mobile-meta-lbl"><i class="fa-regular fa-calendar"></i> Tanggal KBM</span>
                                <span class="mobile-meta-val">
                                    {{ Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <div class="mobile-meta-item">
                                <span class="mobile-meta-lbl"><i class="fa-regular fa-clock"></i> Jam Pelajaran</span>
                                <span class="mobile-meta-val" style="color: #d97706;">
                                    Jam {{ $j->jadwal->jam_mulai_ke ?? '-' }} - {{ $j->jadwal->jam_selesai_ke ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <button type="button" class="mobile-btn-detail" onclick="loadDetailJurnal({{ $j->id_jurnal }})">
                        <i class="fa-solid fa-eye"></i> Rincian Lengkap Jurnal
                    </button>
                </div>
            @empty
                <div style="text-align: center; padding: 35px 15px; color: #94a3b8; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <i class="fa-regular fa-folder-open" style="font-size: 32px; margin-bottom: 8px;"></i>
                    <p style="font-weight: 700; font-size: 13px; margin: 0;">Tidak ada rekap jurnal mengajar yang sesuai filter.</p>
                </div>
            @endforelse
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; overflow-x: auto;">
            {{ $jurnalList->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

{{-- MODAL DETAIL JURNAL --}}
<div class="modal-overlay" id="modalDetailJurnal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-invoice" style="color: #2563eb;"></i> Rincian Jurnal Mengajar Guru</h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailJurnal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body" id="detailJurnalBody">
            <div style="text-align: center; padding: 20px; color: #94a3b8;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px;"></i>
                <p style="margin-top: 8px;">Memuat data...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailJurnal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function loadDetailJurnal(id) {
        const modal = document.getElementById('modalDetailJurnal');
        const body = document.getElementById('detailJurnalBody');
        modal.style.display = 'flex';
        body.innerHTML = '<div style="text-align:center; padding:20px; color:#94a3b8;"><i class="fa-solid fa-spinner fa-spin" style="font-size:24px;"></i><p style="margin-top:8px;">Memuat detail jurnal...</p></div>';

        fetch('/waka-kurikulum/rekap-jurnal/' + id)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const d = res.data;
                    let absenHtml = '<span style="color:#64748b; font-style:italic;">Nihil (Seluruh siswa hadir lengkap)</span>';
                    if (d.ketidakhadiran && d.ketidakhadiran.length > 0) {
                        absenHtml = '<ul style="padding-left:18px; margin:4px 0 0 0;">' + 
                            d.ketidakhadiran.map(s => `<li><strong>${s.nama_siswa}</strong> (${s.nis}) — Status: <span style="color:#dc2626; font-weight:700;">${s.status}</span> (${s.keterangan || '-'})</li>`).join('') + 
                            '</ul>';
                    }

                    body.innerHTML = `
                        <table style="width:100%; font-size:13px; border-collapse:collapse; word-break:break-word;">
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b; width:35%;">Tanggal & Hari</td><td style="padding:8px 0; font-weight:800; color:#0f172a;">${d.tanggal}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Jam Pelajaran</td><td style="padding:8px 0; font-weight:700;">${d.jam_pelajaran}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Kelas / Ruang</td><td style="padding:8px 0; font-weight:800; color:#2563eb;">${d.kelas} (${d.ruangan})</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Mata Pelajaran</td><td style="padding:8px 0; font-weight:800;">${d.mata_pelajaran} (${d.kode_mapel})</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Guru Pengajar</td><td style="padding:8px 0; font-weight:700;">${d.guru_pengajar}</td></tr>
                            ${d.guru_pengganti ? `<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#059669;">Guru Pengganti</td><td style="padding:8px 0; font-weight:800; color:#059669;">${d.guru_pengganti}</td></tr>` : ''}
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Materi Ajar</td><td style="padding:8px 0; font-weight:700; color:#0f172a;">${d.materi}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Aktivitas KBM</td><td style="padding:8px 0;">${d.kegiatan}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Kondisi Kelas</td><td style="padding:8px 0; font-weight:700;">${d.kondisi_kelas}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Status Guru</td><td style="padding:8px 0; font-weight:800; color:#059669;">${d.status_guru}</td></tr>
                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:8px 0; font-weight:700; color:#64748b;">Status Jurnal</td><td style="padding:8px 0; font-weight:800; color:#2563eb;">${d.status_jurnal}</td></tr>
                            <tr><td style="padding:8px 0; font-weight:700; color:#64748b;">Ketidakhadiran Siswa</td><td style="padding:8px 0;">${absenHtml}</td></tr>
                        </table>
                    `;
                }
            })
            .catch(err => {
                body.innerHTML = '<div style="color:#ef4444; text-align:center; padding:20px;">Gagal memuat detail jurnal.</div>';
            });
    }

    function closeDetailJurnal() {
        document.getElementById('modalDetailJurnal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection
