@extends('layouts.guru')

@section('title', 'Jadwal Hari Ini — Guru Piket')
@section('header_title', 'Jadwal Hari Ini')

@section('styles')
<style>
    /* Main Layout & Colors (Abu-abu, Biru, Putih, Abu-abu Muda Cerah) */
    .jadwal-hari-ini-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 4px;
    }

    .page-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-group p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        font-weight: 600;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-slate  { background: #f1f5f9; color: #475569; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .stat-subtext {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 3px;
    }

    /* Main Grid Layout: Left Schedule List + Right Widgets */
    .main-grid-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 22px;
        align-items: start;
    }

    /* Left Schedule Panel */
    .schedule-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .panel-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .panel-title-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16.5px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Filter Form Styling */
    .filter-box-compact {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
    }

    .filter-grid-compact {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-ctrl {
        flex: 1;
        min-width: 140px;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-ctrl:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-filter-dark:hover {
        background: #1e293b;
    }

    .btn-reset-light {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-reset-light:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Schedule Card List */
    .schedule-card-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .schedule-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 15px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .schedule-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }

    .schedule-time-box {
        display: flex;
        flex-direction: column;
        min-width: 105px;
        flex-shrink: 0;
    }

    .time-badge-jam {
        font-size: 11px;
        font-weight: 800;
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        padding: 2px 7px;
        border-radius: 6px;
        display: inline-block;
        width: fit-content;
        margin-bottom: 3px;
    }

    .time-clock-range {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .schedule-info-box {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 0 10px;
    }

    .subject-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }

    .class-room-info {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .teacher-name-box {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .schedule-status-box {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Badges Status KBM */
    .badge-status-kbm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-sedang-berlangsung {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
    }

    .badge-sudah-selesai {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .badge-belum-dimulai {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-jurnal-terisi {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #16a34a;
        box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
        animation: pulseAnimation 1.6s infinite;
    }

    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    /* Right Column Widgets */
    .right-widgets-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .widget-panel-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .widget-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .widget-panel-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .class-summary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
    }

    .class-summary-table th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        padding: 10px 10px;
        text-align: center;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .class-summary-table th:first-child { text-align: left; border-left: 1px solid #e2e8f0; border-radius: 8px 0 0 8px; }
    .class-summary-table th:last-child { border-right: 1px solid #e2e8f0; border-radius: 0 8px 8px 0; }

    .class-summary-table td {
        padding: 10px 10px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        color: #334155;
        text-align: center;
    }

    .class-summary-table tr:hover td {
        background: #f8fafc;
    }

    .class-summary-table td:first-child { text-align: left; font-weight: 800; color: #0f172a; }

    .val-sedang { color: #16a34a; }
    .val-selesai { color: #475569; }
    .val-belum { color: #2563eb; }

    /* Info Guru Pengganti Widget Items */
    .info-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .info-item-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateX(2px);
    }

    .info-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-item-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-icon-red { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .info-icon-blue { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

    .info-item-title {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
    }

    .info-item-subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    .alert-banner-custom {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-styled {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        border-radius: 20px 20px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Custom Pagination Styling */
    .custom-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .page-nav-btn, .page-num-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .page-nav-btn:hover, .page-num-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .page-num-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .page-nav-btn.disabled {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #e2e8f0;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .page-num-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 38px;
        color: #94a3b8;
        font-weight: 700;
        font-size: 14px;
    }

    /* Force constraint on any stray SVG icons in page */
    .schedule-panel svg,
    .jadwal-hari-ini-container svg {
        max-width: 24px !important;
        max-height: 24px !important;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .main-grid-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .filter-grid-compact { flex-direction: column; align-items: stretch; }
        .schedule-item-card { flex-direction: column; align-items: flex-start; }
        .schedule-status-box { align-items: flex-start; width: 100%; }
    }
</style>
@endsection

@section('content')

@php
    $cDate = \Carbon\Carbon::parse($tanggalFilter);
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $dateTitleFormatted = $hariFilter . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
@endphp

<div class="jadwal-hari-ini-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jadwal Pelajaran Hari Ini</h1>
            <p>{{ $dateTitleFormatted }} &nbsp;•&nbsp; Monitoring seluruh sesi KBM dan pemetaan ruang kelas</p>
        </div>

        <div>
            <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $tanggalFilter]) }}" class="btn-filter-dark" style="text-decoration: none; padding: 10px 18px; border-radius: 12px; font-size: 13px;">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>Lihat Jurnal Mengajar</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards Dinamis dari Database) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-val">{{ $stats['totalJadwal'] }} Sesi</span>
                <span class="stat-subtext">Jadwal hari {{ $hariFilter }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sedang Berlangsung</span>
                <span class="stat-val">{{ $stats['sedangBerlangsung'] }} Sesi</span>
                <span class="stat-subtext">KBM aktif sekarang</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-amber">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sudah Selesai</span>
                <span class="stat-val">{{ $stats['sudahSelesai'] }} Sesi</span>
                <span class="stat-subtext">Jam pelajaran terlewati</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-slate">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Dimulai</span>
                <span class="stat-val">{{ $stats['belumDimulai'] }} Sesi</span>
                <span class="stat-subtext">Jadwal sesi mendatang</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Grid Layout (2 Columns: Left Schedule List + Right Widgets) -->
    <div class="main-grid-layout">

        <!-- Left Panel: Daftar Jadwal Hari Ini -->
        <div class="schedule-panel">
            <div class="panel-header-custom">
                <div class="panel-title-custom">
                    <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i>
                    <span>Daftar Sesi Jadwal ({{ $hariFilter }})</span>
                    <span style="font-size: 12px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 12px; font-weight: 700;">
                        {{ $jadwals->total() }} Sesi
                    </span>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="filter-box-compact">
                <form action="{{ route('piket.jadwal') }}" method="GET" class="filter-grid-compact">
                    <div>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-ctrl" title="Filter Tanggal KBM" onchange="this.form.submit()">
                    </div>

                    <div>
                        <select name="id_kelas" class="filter-ctrl" onchange="this.form.submit()">
                            <option value="">🎓 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_mapel" class="filter-ctrl" onchange="this.form.submit()">
                            <option value="">📖 Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="flex: 1.5; min-width: 160px;">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari guru / mapel / kelas..." class="filter-ctrl" style="width: 100%;">
                    </div>

                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    @if($idKelasFilter || $idMapelFilter || $idGuruFilter || $search || $tanggalFilter !== \Carbon\Carbon::now('Asia/Jakarta')->toDateString())
                        <a href="{{ route('piket.jadwal') }}" class="btn-reset-light">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Schedule Card List -->
            <div class="schedule-card-list">
                @forelse($jadwals as $row)
                    @php
                        $mulaiEffective = $row->waktu_mulai_effective;
                        $selesaiEffective = $row->waktu_selesai_effective;
                        $jamRange = $row->jam_range;
                        
                        // Perhitungan status sesi
                        if ($isPast) {
                            $statusKbm = 'selesai';
                        } elseif ($isFuture) {
                            $statusKbm = 'belum';
                        } else {
                            if ($currentTimeStr >= $selesaiEffective) {
                                $statusKbm = 'selesai';
                            } elseif ($currentTimeStr >= $mulaiEffective) {
                                $statusKbm = 'berlangsung';
                            } else {
                                $statusKbm = 'belum';
                            }
                        }

                        $hasJurnal = $row->jurnalMengajars->isNotEmpty();
                        $penugasanPengganti = $penugasanMap->get($row->id_jadwal);
                    @endphp

                    <div class="schedule-item-card">
                        <!-- Waktu KBM -->
                        <div class="schedule-time-box">
                            <span class="time-badge-jam">Jam Ke-{{ $jamRange }}</span>
                            <span class="time-clock-range">{{ $mulaiEffective }} - {{ $selesaiEffective }}</span>
                            <span style="font-size: 10px; color: #94a3b8; font-weight: 700;">WIB • {{ $row->jumlah_jp }} JP</span>
                        </div>

                        <!-- Informasi Mata Pelajaran & Kelas -->
                        <div class="schedule-info-box">
                            <span class="subject-title">{{ $row->mapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
                            <div class="class-room-info">
                                <span><i class="fa-solid fa-graduation-cap" style="color: #2563eb;"></i> {{ $row->kelas->nama_kelas ?? 'Kelas' }}</span>
                                <span>&bull;</span>
                                <span><i class="fa-solid fa-location-dot" style="color: #64748b;"></i> {{ $row->ruangan->nama_ruangan ?? 'Ruang Kelas' }}</span>
                            </div>

                            <div class="teacher-name-box">
                                @if($penugasanPengganti && $penugasanPengganti->guruPengganti)
                                    <span style="color: #0f172a; font-weight: 700;"><i class="fa-solid fa-user-shield" style="color: #d97706;"></i> {{ $penugasanPengganti->guruPengganti->nama_guru }}</span>
                                    <span style="font-size: 10.5px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 1px 6px; border-radius: 4px; font-weight: 700;">Guru Pengganti</span>
                                    <span style="font-size: 10.5px; color: #94a3b8;">(Utama: {{ $row->guru->nama_guru ?? '-' }})</span>
                                @else
                                    <span><i class="fa-solid fa-chalkboard-user" style="color: #475569;"></i> {{ $row->guru->nama_guru ?? 'Guru Pengampu' }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status KBM & Jurnal -->
                        <div class="schedule-status-box">
                            @if($statusKbm === 'berlangsung')
                                <span class="badge-status-kbm badge-sedang-berlangsung">
                                    <span class="pulse-dot"></span>
                                    Sedang Berlangsung
                                </span>
                            @elseif($statusKbm === 'selesai')
                                <span class="badge-status-kbm badge-sudah-selesai">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Sudah Selesai
                                </span>
                            @else
                                <span class="badge-status-kbm badge-belum-dimulai">
                                    <i class="fa-solid fa-clock"></i>
                                    Belum Dimulai
                                </span>
                            @endif

                            @if($hasJurnal)
                                <span class="badge-jurnal-terisi">
                                    <i class="fa-solid fa-file-circle-check"></i> Jurnal Terisi
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 40px 20px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                        Tidak ada sesi jadwal pelajaran yang sesuai dengan kriteria filter hari {{ $hariFilter }}.
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            @if ($jadwals->hasPages())
                <div class="custom-pagination-wrapper">
                    {{-- Previous Page Link --}}
                    @if ($jadwals->onFirstPage())
                        <span class="page-nav-btn disabled" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $jadwals->previousPageUrl() }}" class="page-nav-btn" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif

                    {{-- First Page & Leading Ellipsis --}}
                    @php
                        $start = max(1, $jadwals->currentPage() - 2);
                        $end = min($jadwals->lastPage(), $jadwals->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $jadwals->url(1) }}" class="page-num-btn">1</a>
                        @if ($start > 2)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $jadwals->currentPage())
                            <span class="page-num-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $jadwals->url($page) }}" class="page-num-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Trailing Ellipsis & Last Page --}}
                    @if ($end < $jadwals->lastPage())
                        @if ($end < $jadwals->lastPage() - 1)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                        <a href="{{ $jadwals->url($jadwals->lastPage()) }}" class="page-num-btn">{{ $jadwals->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($jadwals->hasMorePages())
                        <a href="{{ $jadwals->nextPageUrl() }}" class="page-nav-btn" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span class="page-nav-btn disabled" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
                <div style="text-align: center; font-size: 12px; color: #64748b; margin-top: 8px; font-weight: 600;">
                    Menampilkan {{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }} dari {{ $jadwals->total() }} jadwal
                </div>
            @endif
        </div>

        <!-- Right Column Widgets -->
        <div class="right-widgets-col">

            <!-- Right Widget 1: Ringkasan per Kelas -->
            <div class="widget-panel-box">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-users-viewfinder" style="color: #2563eb;"></i>
                        <span>Ringkasan per Kelas</span>
                    </div>
                    <button type="button" onclick="openClassSummaryModal()" class="btn-reset-light" style="padding: 4px 10px; font-size: 11px;">
                        Lihat Semua ({{ count($ringkasanPerKelas) }})
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table class="class-summary-table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Total</th>
                                <th>Sedang</th>
                                <th>Selesai</th>
                                <th>Belum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ringkasanPerKelas->take(6) as $rk)
                                <tr>
                                    <td>{{ $rk->nama_kelas }}</td>
                                    <td>{{ $rk->total }}</td>
                                    <td class="val-sedang">{{ $rk->sedang }}</td>
                                    <td class="val-selesai">{{ $rk->selesai }}</td>
                                    <td class="val-belum">{{ $rk->belum }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada data kelas aktif hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Widget 2: Informasi Guru Tidak Hadir & Pengganti Hari Ini -->
            <div class="widget-panel-box">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-user-gear" style="color: #2563eb;"></i>
                        <span>Informasi Guru Piket Hari Ini</span>
                    </div>
                    <a href="{{ route('piket.guru-pengganti') }}" class="btn-reset-light" style="padding: 4px 10px; font-size: 11px;">
                        Kelola
                    </a>
                </div>

                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="info-item-card">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-red">
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #dc2626;">{{ $guruTidakHadirCount }} Guru Izin / Tidak Hadir</div>
                            <div class="info-item-subtext">Lihat daftar surat izin guru hari ini</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 12px;"></i>
                </a>

                <a href="{{ route('piket.guru-pengganti') }}" class="info-item-card" style="margin-bottom: 0;">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-blue">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #2563eb;">{{ $guruPenggantiCount }} Penugasan Guru Pengganti</div>
                            <div class="info-item-subtext">Kelola penugasan guru pengganti aktif</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 12px;"></i>
                </a>
            </div>

            <!-- Right Widget 3: Quick Alert Note -->
            <div class="alert-banner-custom">
                <i class="fa-solid fa-circle-info" style="color: #2563eb; font-size: 16px; flex-shrink: 0;"></i>
                <span>Alokasi jam KBM mengacu pada Master Jam Pelajaran TU (10 JP Senin–Kamis / 13 JP Jumat).</span>
            </div>

        </div>

    </div>

</div>

<!-- Modal Dialog: Seluruh Ringkasan per Kelas -->
<div id="modalClassSummary" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-users-viewfinder" style="font-size: 18px;"></i>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Ringkasan Jadwal Seluruh Kelas ({{ $hariFilter }})</h3>
            </div>
            <button type="button" onclick="closeClassSummaryModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px;">
            <table class="class-summary-table">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Total Jadwal</th>
                        <th>Sedang</th>
                        <th>Selesai</th>
                        <th>Belum</th>
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
</div>

@endsection

@section('scripts')
<script>
    function openClassSummaryModal() {
        document.getElementById('modalClassSummary').style.display = 'flex';
    }
    function closeClassSummaryModal() {
        document.getElementById('modalClassSummary').style.display = 'none';
    }
    window.onclick = function(e) {
        var modal = document.getElementById('modalClassSummary');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
@endsection