@extends('layouts.guru')

@section('title', 'Dashboard Guru Piket — EDU JOURNAL')
@section('header_title', 'Dashboard Guru Piket')

@section('styles')
<style>
    /* Dashboard Page Header Style (Matching Dashboard TU Example) */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-header-primary {
        background: #384972;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.25);
    }

    .btn-header-primary:hover {
        background: #2b3957;
        color: #ffffff;
    }

    .btn-header-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .btn-header-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .piket-dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Stat Cards Grid (4 Columns) */
    .stat-grid {
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    }

    .stat-card .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-card .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-card .stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
    }

    .stat-card .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-card .stat-subtitle {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Middle Row Grid (2 Columns) */
    .middle-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .section-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }

    .section-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .section-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .section-card-title .icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #cbd5e1;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .btn-see-all {
        background: #2b3957;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-see-all:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* Custom Tables */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-table th {
        background: #dfd8c8;
        color: #334155;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #d1c9b6;
        border-bottom: 1px solid #d1c9b6;
    }

    .custom-table th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .custom-table th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .custom-table td {
        padding: 12px 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .teacher-subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        display: block;
    }

    /* Bottom Row Grid (3 Columns) */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr 1fr;
        gap: 20px;
    }

    /* Widget 1: Schedule Timeline */
    .timeline-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
        padding-left: 24px;
        margin-top: 6px;
    }

    .timeline-list::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #cbd5e1;
    }

    .timeline-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -21px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #2b3957;
        border: 2px solid #ffffff;
    }

    .timeline-content {
        display: flex;
        flex-direction: column;
    }

    .timeline-time {
        font-size: 12px;
        font-weight: 800;
        color: #1e293b;
    }

    .timeline-subject {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        margin-top: 1px;
    }

    .timeline-teacher {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .status-icon {
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-icon.success { color: #10b981; }
    .status-icon.warning { color: #f59e0b; }
    .status-icon.alert { color: #ef4444; }

    /* Widget 2: Weekly Chart */
    .chart-container {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: flex-end;
        padding-top: 20px;
    }

    .bars-wrapper {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 180px;
        padding: 0 10px;
        border-bottom: 2px solid #cbd5e1;
    }

    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        width: 16%;
    }

    .bar-val {
        font-size: 12px;
        font-weight: 800;
        color: #1e293b;
    }

    .bar-fill {
        width: 100%;
        max-width: 44px;
        background: #2b3957;
        border-radius: 4px 4px 0 0;
        transition: height 0.5s ease;
    }

    .bar-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: capitalize;
    }

    /* Widget 3: Pengumuman Cards */
    .announcement-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .announcement-card {
        background: #fdfbf7;
        border: 1px solid #f3ebd8;
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .announcement-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #e2e8f0;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .announcement-text {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.35;
    }

    .announcement-time {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 4px;
    }

    @media (max-width: 1200px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .middle-grid { grid-template-columns: 1fr; }
        .bottom-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .stat-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .dashboard-page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 14px;
        }

        .header-left h1 {
            font-size: 20px;
        }

        .header-left p {
            font-size: 11.5px;
            line-height: 1.35;
        }

        .header-actions-group {
            display: flex;
            width: 100%;
            gap: 8px;
        }

        .btn-header-action {
            flex: 1;
            justify-content: center;
            padding: 8px 10px;
            font-size: 11.5px;
            border-radius: 9px;
            text-align: center;
        }

        .piket-dashboard-container {
            gap: 16px;
        }

        .stat-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 10px;
        }

        .stat-card {
            padding: 12px 14px;
            border-radius: 14px;
            gap: 12px;
            min-width: 0;
        }

        .stat-card .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            font-size: 17px;
        }

        .stat-card .stat-title {
            font-size: 11.5px;
        }

        .stat-card .stat-value {
            font-size: 19px;
        }

        .stat-card .stat-subtitle {
            font-size: 10.5px;
            margin-top: 2px;
        }

        .middle-grid,
        .bottom-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .section-card {
            padding: 14px 12px;
            border-radius: 14px;
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
        }

        .section-card-header {
            margin-bottom: 12px;
            gap: 8px;
            align-items: center;
        }

        .section-card-title {
            font-size: 13px;
            gap: 8px;
            min-width: 0;
            flex: 1;
        }

        .section-card-title span {
            white-space: normal;
            line-height: 1.25;
        }

        .section-card-title .icon-badge {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 13px;
            flex-shrink: 0;
        }

        .btn-see-all {
            padding: 5px 9px;
            font-size: 10.5px;
            border-radius: 8px;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
        }

        .custom-table {
            min-width: 460px;
            font-size: 11.5px;
        }

        .custom-table th {
            padding: 9px 8px;
            font-size: 10.5px;
        }

        .custom-table td {
            padding: 9px 8px;
            font-size: 11.5px;
        }

        .timeline-list {
            gap: 12px;
            padding-left: 20px;
        }

        .timeline-time {
            font-size: 11px;
        }

        .timeline-subject {
            font-size: 12px;
        }

        .timeline-teacher {
            font-size: 10.5px;
        }

        .chart-container {
            padding-top: 10px;
        }

        .chart-wrapper {
            height: 180px !important;
            gap: 10px !important;
        }

        .bar-label {
            font-size: 10.5px;
        }

        .announcement-card {
            padding: 10px 10px;
            gap: 10px;
            border-radius: 11px;
        }

        .announcement-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 12px;
        }

        .announcement-text {
            font-size: 11.5px;
        }

        .announcement-time {
            font-size: 10px;
        }
    }
</style>
@endsection

@section('content')

@php
    $nowPiket = \Carbon\Carbon::now('Asia/Jakarta');
    $daysId = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $monthsId = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $formattedDatePiket = $daysId[$nowPiket->dayOfWeek] . ', ' . $nowPiket->day . ' ' . $monthsId[$nowPiket->month] . ' ' . $nowPiket->year;
@endphp

<div class="piket-dashboard-container">

    <!-- Page Location Header (Keterangan Keberadaan Halaman - Dashboard TU Style) -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Dashboard Guru Piket</h1>
            <p>{{ $formattedDatePiket }} &nbsp;•&nbsp; Monitoring presensi, jurnal mengajar &amp; ketertiban sekolah hari ini</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('piket.rekap-kehadiran.export') }}" class="btn-header-action btn-header-secondary">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor Rekap</span>
            </a>
            <a href="{{ route('piket.guru-pengganti') }}" class="btn-header-action btn-header-primary">
                <i class="fa-solid fa-user-group"></i>
                <span>Guru Pengganti</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards Top Section (4 Cards) -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-details">
                <span class="stat-title">Total Jurnal Hari Ini</span>
                <span class="stat-value">{{ $totalJurnalHariIni }} Jurnal</span>
                <span class="stat-subtitle">Semua jurnal hari ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-details">
                <span class="stat-title">Guru Tidak Hadir</span>
                <span class="stat-value">{{ $guruTidakHadirCount }} Guru</span>
                <span class="stat-subtitle">Perlu penugasan</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-arrows-rotate"></i>
            </div>
            <div class="stat-details">
                <span class="stat-title">Guru Pengganti</span>
                <span class="stat-value">{{ $guruPenggantiCount }} Penugasan</span>
                <span class="stat-subtitle">Penugasan Hari Ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-title">Kelas Sudah Terisi</span>
                <span class="stat-value">{{ $kelasTerisiPercentage }}%</span>
                <span class="stat-subtitle">Dari total jadwal hari ini</span>
            </div>
        </div>
    </div>

    <!-- 2. Middle Row Section (2 Tables) -->
    <div class="middle-grid">

        <!-- Table 1: Monitoring Jurnal Mengajar Hari Ini -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="icon-badge">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <span>Monitoring Jurnal Mengajar Hari Ini</span>
                </div>
                <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-see-all">Lihat Semua</a>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoringJurnalToday as $row)
                            <tr>
                                <td>{{ $row->jam ?? ($row->jadwal->jam_pelajaran_format ?? '07.00 - 08.30') }}</td>
                                <td>{{ $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Mengajar') }}</td>
                                <td>{{ $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Mata Pelajaran') }}</td>
                                <td>{{ $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'Kelas') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada jurnal mengajar diisi hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 2: Penugasan Guru Pengganti Hari Ini -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="icon-badge">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <span>Penugasan Guru Pengganti Hari Ini</span>
                </div>
                <a href="{{ route('piket.guru-pengganti') }}" class="btn-see-all">Lihat Semua</a>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Guru Tidak Hadir</th>
                            <th>Guru Pengganti</th>
                            <th>Kelas</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasanToday as $p)
                            <tr>
                                <td>
                                    {{ $p->guru_tidak_hadir_nama ?? ($p->guruTidakHadir->nama_guru ?? 'Guru Tidak Hadir') }}
                                    <span class="teacher-subtext">{{ $p->mapel_nama ?? ($p->guruTidakHadir->mapel->nama_mapel ?? 'Mata Pelajaran') }}</span>
                                </td>
                                <td>{{ $p->guru_pengganti_nama ?? ($p->guruPengganti->nama_guru ?? 'Guru Pengganti') }}</td>
                                <td>{{ $p->kelas_nama ?? ($p->kelas->nama_kelas ?? 'Kelas') }}</td>
                                <td>{{ $p->jam ?? $p->jam_pelajaran }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada penugasan guru pengganti hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- 3. Bottom Row Section (3 Widgets) -->
    <div class="bottom-grid">

        <!-- Widget 1: Jadwal Hari Ini Timeline -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="icon-badge">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span>Jadwal Hari Ini</span>
                </div>
            </div>

            <div class="timeline-list">
                @forelse($timelineJadwal as $idx => $j)
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <span class="timeline-time">{{ $j->jam_pelajaran_format ?? '07.00 - 08.30' }}</span>
                            <span class="timeline-subject">{{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
                            <span class="timeline-teacher">{{ $j->guru->nama_guru ?? 'Nama Guru' }}</span>
                        </div>
                        <div class="status-icon {{ $idx === 0 ? 'success' : ($idx === 1 ? 'warning' : 'alert') }}">
                            @if($idx === 0)
                                <i class="fa-solid fa-circle-check"></i>
                            @elseif($idx === 1)
                                <i class="fa-solid fa-clock"></i>
                            @else
                                <i class="fa-solid fa-arrows-rotate"></i>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="color: #94a3b8; font-size: 13px; text-align: center; padding: 10px;">Tidak ada jadwal hari ini.</div>
                @endforelse
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('piket.jadwal') }}" class="btn-see-all" style="width: 100%; display: block; text-align: center;">Lihat Semua Jadwal</a>
            </div>
        </div>

        <!-- Widget 2: Jurnal Mengajar Mingguan Bar Chart -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <span>Jurnal Mengajar Mingguan</span>
                </div>
            </div>

            <div class="chart-container">
                <div class="bars-wrapper">
                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $day)
                        @php
                            $val = $jurnalMingguan[$day] ?? 30;
                            $pct = round(($val / 60) * 100);
                        @endphp
                        <div class="bar-group">
                            <span class="bar-val">{{ $val }}</span>
                            <div class="bar-fill" style="height: {{ $pct }}%;"></div>
                            <span class="bar-label">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-align: center; margin-top: 10px;">
                    <i class="fa-solid fa-square" style="color: #2b3957;"></i> Jumlah Jurnal
                </div>
            </div>
        </div>

        <!-- Widget 3: Pengumuman Cards -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="icon-badge">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <span>Pengumuman</span>
                </div>
            </div>

            <div class="announcement-list">
                @foreach($pengumumanList as $idx => $p)
                    <div class="announcement-card">
                        <div class="announcement-icon">
                            <i class="fa-solid {{ $p->icon ?? ($idx === 0 ? 'fa-bell' : ($idx === 1 ? 'fa-file-lines' : 'fa-circle-info')) }}"></i>
                        </div>
                        <div>
                            <div class="announcement-text">{{ $p->judul ?? $p->isi }}</div>
                            <div class="announcement-time">{{ $p->tanggal_formatted ?? '22 Agustus 2026 | 08.00' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 16px; text-align: center;">
                <a href="{{ route('piket.pengumuman') }}" class="btn-see-all" style="width: 100%; display: block; text-align: center;">Lihat Semua Pengumuman</a>
            </div>
        </div>

    </div>

</div>
@endsection
