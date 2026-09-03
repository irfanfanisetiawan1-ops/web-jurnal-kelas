@extends('layouts.guru')

@section('title', 'Jadwal Hari Ini — Guru Piket')
@section('header_title', 'Jadwal Hari Ini')

@section('styles')
<style>
    .jadwal-hari-ini-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: -12px;
        margin-bottom: 4px;
    }

    /* Filter Bar */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .filter-item {
        flex: 1;
        min-width: 160px;
    }

    .filter-item select, .filter-item input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
    }

    .btn-filter-action {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .btn-filter-action:hover {
        background: #1e293b;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-orange { background: #ffedd5; color: #ea580c; }
    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-subtext {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Main Grid: 2 Columns (Left Schedule List + Right Widgets) */
    .main-grid-layout {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
    }

    /* Left Schedule Panel */
    .schedule-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .schedule-card-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .schedule-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .schedule-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .schedule-left-time {
        display: flex;
        flex-direction: column;
        min-width: 90px;
    }

    .time-start {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .time-end {
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
    }

    .schedule-mid-details {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 0 16px;
    }

    .subject-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #1e293b;
    }

    .class-room-info {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-top: 2px;
    }

    .teacher-name {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .badge-sedang-berlangsung {
        background: #d1fae5;
        color: #059669;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-belum-dimulai {
        background: #ffedd5;
        color: #ea580c;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-purple-dimulai {
        background: #ede9fe;
        color: #7c3aed;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Right Widgets Column */
    .right-widgets-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .widget-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .widget-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .widget-panel-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14.5px;
        font-weight: 800;
        color: #1e293b;
    }

    .btn-see-all-sm {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
    }

    .class-summary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
    }

    .class-summary-table th {
        background: #dfd8c8;
        color: #1e293b;
        font-weight: 800;
        padding: 10px 8px;
        text-align: center;
    }

    .class-summary-table th:first-child { text-align: left; border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    .class-summary-table th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }

    .class-summary-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        color: #334155;
        text-align: center;
    }

    .class-summary-table td:first-child { text-align: left; font-weight: 800; color: #1e293b; }

    .val-sedang { color: #059669; }
    .val-selesai { color: #2563eb; }
    .val-belum { color: #d97706; }

    /* Info Guru Pengganti Widget Items */
    .info-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .info-item-card:hover {
        background: #f8fafc;
    }

    .info-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .info-icon-red { background: #fee2e2; color: #dc2626; }
    .info-icon-blue { background: #dbeafe; color: #2563eb; }

    .info-item-title {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .info-item-subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    /* Bottom Info Alert Banner */
    .alert-banner {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .main-grid-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .filter-grid { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')
<div class="jadwal-hari-ini-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jadwal Hari Ini</h1>
            <p>Daftar seluruh sesi jadwal pelajaran dan pemetaan ruang kelas hari ini</p>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-val">{{ $stats['totalJadwal'] }}</span>
                <span class="stat-subtext">jadwal hari ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sedang Berlangsung</span>
                <span class="stat-val">{{ $stats['sedangBerlangsung'] }}</span>
                <span class="stat-subtext">jadwal sekarang</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sudah Selesai</span>
                <span class="stat-val">{{ $stats['sudahSelesai'] }}</span>
                <span class="stat-subtext">jadwal selesai</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-purple">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Dimulai</span>
                <span class="stat-val">{{ $stats['belumDimulai'] }}</span>
                <span class="stat-subtext">jadwal mendatang</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Grid Layout (2 Columns) -->
    <div class="main-grid-layout">

        <!-- Left Panel: Daftar Jadwal Hari Ini -->
        <div class="schedule-panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fa-solid fa-calendar-days" style="color: #2b3957;"></i>
                    <span>Daftar Jadwal Hari Ini</span>
                </div>
            </div>

            <!-- Filter & Search Bar (Di Atas Daftar Jadwal) -->
            <div class="filter-bar-container" style="border-radius: 0; padding: 12px 18px;">
                <form action="{{ route('piket.jadwal') }}" method="GET">
                    <div>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">
                    </div>

                    <div>
                        <select name="id_kelas" class="filter-input">
                            <option value="">🎓 Kelas: Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_mapel" class="filter-input">
                            <option value="">📖 Mapel: Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    <a href="{{ route('piket.jadwal') }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </form>
            </div>

            <div class="schedule-card-list">
                @forelse($jadwals as $index => $row)
                    @php
                        $times = explode('-', $row->jam_pelajaran_format ?? '07.00 - 08.30');
                        $tStart = trim($times[0] ?? '07.00');
                        $tEnd = trim($times[1] ?? '08.30');

                        $stTeks = $row->status_teks ?? ($index < 2 ? 'Sedang Berlangsung' : 'Belum Dimulai');
                        $stClass = 'badge-sedang-berlangsung';
                        if ($stTeks === 'Belum Dimulai') {
                            $stClass = ($index === 3) ? 'badge-purple-dimulai' : 'badge-belum-dimulai';
                        }
                    @endphp
                    <div class="schedule-item-card">
                        <div class="schedule-left-time">
                            <span class="time-start">{{ $tStart }}</span>
                            <span class="time-end">-{{ $tEnd }}</span>
                        </div>

                        <div class="schedule-mid-details">
                            <span class="subject-title">{{ $row->mapel_nama ?? ($row->mapel->nama_mapel ?? 'Matematika') }}</span>
                            <span class="class-room-info">{{ $row->kelas_nama ?? ($row->kelas->nama_kelas ?? 'Kelas XI RPL 1') }} &bull; {{ $row->ruangan_nama ?? ($row->ruangan->nama_ruangan ?? 'Ruang 57') }}</span>
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px;">
                            <span class="teacher-name">{{ $row->guru_nama ?? ($row->guru->nama_guru ?? 'Guru') }}</span>
                            <span class="{{ $stClass }}">{{ $stTeks }}</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada jadwal pelajaran ditemukan.</div>
                @endforelse
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <a href="#" style="font-size: 13px; font-weight: 700; color: #2b3957; text-decoration: none;">Lihat Semua Jadwal <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Right Column Widgets -->
        <div class="right-widgets-col">

            <!-- Right Widget 1: Ringkasan per Kelas -->
            <div class="widget-panel">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-users-viewfinder" style="color: #2b3957;"></i>
                        <span>Ringkasan per Kelas</span>
                    </div>
                    <a href="#" class="btn-see-all-sm">Lihat Semua</a>
                </div>

                <div style="overflow-x: auto;">
                    <table class="class-summary-table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Total Jadwal</th>
                                <th>Sedang</th>
                                <th>Selesai</th>
                                <th>Belum Dimulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ringkasanPerKelas as $rk)
                                <tr>
                                    <td>{{ $rk->nama_kelas }}</td>
                                    <td>{{ $rk->total }}</td>
                                    <td class="val-sedang">{{ $rk->sedang }}</td>
                                    <td class="val-selesai">{{ $rk->selesai }}</td>
                                    <td class="val-belum">{{ $rk->belum }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Widget 2: Informasi Guru Pengganti Hari Ini -->
            <div class="widget-panel">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-user-gear" style="color: #2b3957;"></i>
                        <span>Informasi Guru Pengganti Hari Ini</span>
                    </div>
                    <a href="{{ route('piket.guru-pengganti') }}" class="btn-see-all-sm">Lihat Semua</a>
                </div>

                <a href="{{ route('piket.guru-pengganti') }}" class="info-item-card">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-red">
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #dc2626;">2 Guru Tidak Hadir</div>
                            <div class="info-item-subtext">Lihat detail di menu Guru Pengganti</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 13px;"></i>
                </a>

                <a href="{{ route('piket.guru-pengganti') }}" class="info-item-card" style="margin-bottom: 0;">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-blue">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #2563eb;">2 Penugasan Guru Pengganti</div>
                            <div class="info-item-subtext">Lihat detail di menu Guru Pengganti</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 13px;"></i>
                </a>
            </div>

        </div>

    </div>

    <!-- 4. Bottom Info Alert Banner -->
    <div class="alert-banner">
        <i class="fa-solid fa-circle-info" style="color: #2563eb; font-size: 16px;"></i>
        <span>Jadwal dapat berubah sewaktu -waktu. Pastikan untuk selalu memantau informasi terbaru.</span>
    </div>

</div>
@endsection
