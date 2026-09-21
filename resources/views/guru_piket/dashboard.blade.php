@extends('layouts.guru')

@section('title', 'Dashboard Guru Piket — EDU JOURNAL')
@section('header_title', 'Dashboard Guru Piket')

@section('styles')
<style>
    /* Dashboard Page Header Style */
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
        transform: translateY(-1px);
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
        transform: translateY(-1px);
    }

    .piket-dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    /* Verification Alert Banner */
    .verification-status-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        flex-wrap: wrap;
        gap: 14px;
    }

    .banner-verified {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #16a34a;
    }

    .banner-pending {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #2563eb;
    }

    .banner-locked {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #94a3b8;
    }

    /* Stat Cards Grid (4 Columns) */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
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
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        height: 100%;
        box-sizing: border-box;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
        border-color: #cbd5e1;
    }

    .stat-card .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-card .stat-icon.icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-card .stat-icon.icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-card .stat-icon.icon-purple { background: #faf5ff; color: #9333ea; }
    .stat-card .stat-icon.icon-green  { background: #f0fdf4; color: #16a34a; }

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
        background: #e2e8f0;
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
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-see-all:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .custom-table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-align: left;
        padding: 12px 14px;
        border: none;
    }

    .custom-table th:first-child { border-radius: 8px 0 0 8px; }
    .custom-table th:last-child { border-radius: 0 8px 8px 0; }

    .custom-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: #fafcff;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .teacher-subtext {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Bottom Row Grid (3 Columns) - Balanced & Proportional */
    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        align-items: stretch;
    }

    .bottom-grid .section-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Widget 1: Timeline Jadwal */
    .timeline-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 12px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    .timeline-item:hover {
        background: #f1f5f9;
        transform: translateX(2px);
    }

    .timeline-content {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .timeline-time {
        font-size: 10.5px;
        font-weight: 800;
        color: #2563eb;
    }

    .timeline-subject {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .timeline-teacher {
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
    }

    .status-icon {
        font-size: 14px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .status-icon.success { background: #dcfce7; color: #16a34a; }
    .status-icon.warning { background: #fef3c7; color: #d97706; }
    .status-icon.alert   { background: #fee2e2; color: #ef4444; }
    .status-icon.muted   { background: #f1f5f9; color: #94a3b8; }

    /* Widget 2: Weekly Chart */
    .chart-container {
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
    }

    .chart-stat-boxes {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
    }

    .chart-stat-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 9px 12px;
    }

    .chart-stat-box.highlight {
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .chart-stat-label {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        display: block;
    }

    .chart-stat-box.highlight .chart-stat-label {
        color: #1d4ed8;
    }

    .chart-stat-val {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .chart-stat-box.highlight .chart-stat-val {
        color: #2563eb;
    }

    .bars-wrapper {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 120px;
        padding: 0 6px 8px 6px;
        border-bottom: 2px solid #e2e8f0;
        gap: 10px;
    }

    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
        width: 18%;
        gap: 4px;
    }

    .bar-val {
        font-size: 11px;
        font-weight: 800;
        color: #1e293b;
    }

    .bar-track {
        width: 100%;
        max-width: 38px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 6px 6px 0 0;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .bar-fill {
        width: 100%;
        background: linear-gradient(180deg, #384972 0%, #1e293b 100%);
        border-radius: 5px 5px 0 0;
        transition: height 0.5s ease;
        min-height: 4px;
    }

    .bar-group.today-bar .bar-fill {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
    }

    .bar-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: capitalize;
    }

    .bar-group.today-bar .bar-label {
        color: #2563eb;
        font-weight: 800;
    }

    /* Widget 3: Pengumuman Cards */
    .announcement-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .announcement-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 11px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        transition: background-color 0.15s ease;
    }

    .announcement-card:hover {
        background: #f1f5f9;
    }

    .announcement-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #e2e8f0;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .announcement-text {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .announcement-time {
        font-size: 10.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 2px;
    }

    @media (max-width: 1200px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .middle-grid { grid-template-columns: 1fr; }
        .bottom-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .stat-grid { grid-template-columns: 1fr; }
        .dashboard-page-header { flex-direction: column; align-items: flex-start; }
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

    <!-- Page Location Header -->
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
        </div>
    </div>

    <!-- Verification Status Quick Indicator (Ringkas, Rapi & Selaras) -->
    @if(isset($verifikasiHariIni) && $verifikasiHariIni)
        <div class="verification-status-banner banner-verified">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <strong style="font-size: 14px; color: #0f172a;">Jurnal Mengajar Hari Ini Telah Diverifikasi</strong>
                        <span style="background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-size: 10.5px; font-weight: 800; padding: 1.5px 7px; border-radius: 5px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-circle-check"></i> Terverifikasi
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 2px; font-weight: 500;">
                        Divalidasi oleh <strong>{{ $verifikasiHariIni->nama_guru_piket }}</strong> pada {{ \Carbon\Carbon::parse($verifikasiHariIni->waktu_verifikasi)->format('d/m/Y H:i') }} WIB ({{ $verifikasiHariIni->total_jurnal_diverifikasi }} jurnal sah).
                    </div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $todayDate]) }}" class="btn-header-action btn-header-secondary" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-eye"></i>
                    <span>Lihat Jurnal</span>
                </a>
                <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $todayDate]) }}" target="_blank" class="btn-header-action btn-header-primary" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Dokumen</span>
                </a>
            </div>
        </div>
    @elseif(isset($isJamSekolahSelesai) && $isJamSekolahSelesai)
        <div class="verification-status-banner banner-pending">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                    <i class="fa-solid fa-signature"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <strong style="font-size: 14px; color: #0f172a;">Jurnal Hari Ini Siap Ditandatangani</strong>
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 10.5px; font-weight: 800; padding: 1.5px 7px; border-radius: 5px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-bell"></i> Siap Diverifikasi
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 2px; font-weight: 500;">
                        KBM telah selesai (Pukul {{ $jamSelesaiSekolah }} WIB). Silakan bubuhkan tanda tangan validasi harian.
                    </div>
                </div>
            </div>
            <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $todayDate]) }}" class="btn-header-action btn-header-primary" style="padding: 8px 16px; font-size: 12.5px; background: #2563eb;">
                <i class="fa-solid fa-pen-nib"></i>
                <span>Tanda Tangani Jurnal</span>
            </a>
        </div>
    @endif

    <!-- 1. Stat Cards Top Section (4 Cards) -->
    <div class="stat-grid">
        <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $todayDate]) }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-title">Total Jurnal Hari Ini</span>
                    <span class="stat-value">{{ $totalJurnalHariIni }} Jurnal</span>
                    <span class="stat-subtitle">Dari {{ $totalJadwalToday }} jadwal KBM hari ini</span>
                </div>
            </div>
        </a>

        <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon icon-amber">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-title">Guru Tidak Hadir</span>
                    <span class="stat-value">{{ $guruTidakHadirCount }} Guru</span>
                    <span class="stat-subtitle">Perlu penugasan pengganti</span>
                </div>
            </div>
        </a>

        <a href="{{ route('piket.guru-pengganti') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-title">Guru Pengganti</span>
                    <span class="stat-value">{{ $guruPenggantiCount }} Penugasan</span>
                    <span class="stat-subtitle">Penugasan aktif hari ini</span>
                </div>
            </div>
        </a>

        <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $todayDate]) }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-title">Kelas Sudah Terisi</span>
                    <span class="stat-value">{{ $kelasTerisiPercentage }}%</span>
                    <span class="stat-subtitle">{{ $totalJurnalHariIni }} dari {{ $totalJadwalToday }} kelas terisi</span>
                </div>
            </div>
        </a>
    </div>

    <!-- 2. Middle Row Section (2 Tables) -->
    <div class="middle-grid">

        <!-- Table 1: Monitoring Jurnal Mengajar Hari Ini -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="icon-badge">
                        <i class="fa-solid fa-book-open-reader"></i>
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
                                <td>
                                    <div style="font-weight: 700; color: #1e293b;">{{ $row->jadwal->jam_range ?? ($row->jam_ke ? 'Jam ' . $row->jam_ke : '-') }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $row->jadwal->waktu_mulai_effective ?? '07:00' }} - {{ $row->jadwal->waktu_selesai_effective ?? '08:20' }} WIB</div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">{{ $row->guruPengganti->nama_guru ?? ($row->jadwal->guru->nama_guru ?? ($row->guru_nama ?? '-')) }}</div>
                                    @if($row->id_guru_pengganti)
                                        <span class="badge" style="background: #f59e0b; color: #ffffff; font-size: 10px; padding: 2px 6px; border-radius: 4px;">Guru Pengganti</span>
                                    @endif
                                </td>
                                <td>{{ $row->jadwal->mapel->nama_mapel ?? ($row->mapel_nama ?? '-') }}</td>
                                <td><span class="badge" style="background: #e2e8f0; color: #334155; font-weight: 700; padding: 3px 8px; border-radius: 6px;">{{ $row->jadwal->kelas->nama_kelas ?? ($row->kelas_nama ?? '-') }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 28px;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                    Belum ada jurnal mengajar yang diisi hari ini.
                                </td>
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
                                    <div style="font-weight: 700; color: #0f172a;">{{ $p->guruTidakHadir->nama_guru ?? ($p->guru_tidak_hadir_nama ?? 'Guru Tidak Hadir') }}</div>
                                    <span class="teacher-subtext" style="font-size: 11px; color: #64748b;">{{ $p->guruTidakHadir->mapel->nama_mapel ?? ($p->mapel_nama ?? 'Mata Pelajaran') }}</span>
                                </td>
                                <td><div style="font-weight: 700; color: #2563eb;">{{ $p->guruPengganti->nama_guru ?? ($p->guru_pengganti_nama ?? 'Guru Pengganti') }}</div></td>
                                <td><span class="badge" style="background: #e2e8f0; color: #334155; font-weight: 700; padding: 3px 8px; border-radius: 6px;">{{ $p->kelas->nama_kelas ?? ($p->kelas_nama ?? '-') }}</span></td>
                                <td>{{ $p->jam ?? ($p->jadwal->jam_range ? 'Jam ' . $p->jadwal->jam_range : ($p->jam_pelajaran ?? '-')) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 28px;">
                                    <i class="fa-solid fa-circle-check" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5; color: #10b981;"></i>
                                    Tidak ada penugasan guru pengganti aktif hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- 3. Bottom Row Section (3 Widgets - Rapi, Seimbang & Tidak Melar) -->
    <div class="bottom-grid">

        <!-- Widget 1: Jadwal Hari Ini Timeline -->
        <div class="section-card">
            <div>
                <div class="section-card-header">
                    <div class="section-card-title">
                        <div class="icon-badge">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <span>Jadwal Hari Ini</span>
                    </div>
                    <span style="font-size: 11px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 12px; font-weight: 700;">
                        {{ count($timelineJadwal) }} Sesi
                    </span>
                </div>

                <div class="timeline-list">
                    @forelse($timelineJadwal->take(4) as $idx => $j)
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <span class="timeline-time">{{ $j->jam_range ? 'Jam ' . $j->jam_range : ($j->jam_pelajaran_format ?? '07.00 - 08.30') }} • {{ $j->waktu_mulai_effective ?? '07:00' }} - {{ $j->waktu_selesai_effective ?? '08:20' }} WIB</span>
                                <span class="timeline-subject">{{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $j->kelas->nama_kelas ?? 'Kelas' }})</span>
                                <span class="timeline-teacher">{{ $j->guru->nama_guru ?? 'Nama Guru' }}</span>
                            </div>
                            <div class="status-icon {{ !empty($j->sudah_diisi) ? 'success' : 'muted' }}" title="{{ !empty($j->sudah_diisi) ? 'Jurnal Sudah Terisi' : 'Belum Diisi' }}">
                                @if(!empty($j->sudah_diisi))
                                    <i class="fa-solid fa-circle-check"></i>
                                @else
                                    <i class="fa-solid fa-clock"></i>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="color: #94a3b8; font-size: 13px; text-align: center; padding: 20px;">Tidak ada jadwal KBM hari ini.</div>
                    @endforelse
                </div>
            </div>

            <div style="margin-top: 14px; text-align: center;">
                <a href="{{ route('piket.jadwal') }}" class="btn-see-all" style="width: 100%; display: block; text-align: center;">Lihat Semua Jadwal</a>
            </div>
        </div>

        <!-- Widget 2: Jurnal Mengajar Mingguan Bar Chart -->
        <div class="section-card">
            <div>
                <div class="section-card-header">
                    <div class="section-card-title">
                        <div class="icon-badge">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <span>Jurnal Mingguan</span>
                    </div>
                    <span style="font-size: 11px; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 2px 8px; border-radius: 12px; font-weight: 700;">
                        {{ array_sum($jurnalMingguan) }} Sesi
                    </span>
                </div>

                <div class="chart-container">
                    <div class="chart-stat-boxes">
                        <div class="chart-stat-box">
                            <span class="chart-stat-label">Total Minggu Ini</span>
                            <div class="chart-stat-val">{{ array_sum($jurnalMingguan) }} <span style="font-size: 11px; font-weight: 600; color: #94a3b8;">Jurnal</span></div>
                        </div>
                        <div class="chart-stat-box highlight">
                            <span class="chart-stat-label">{{ ucfirst($hariIni) }} (Hari Ini)</span>
                            <div class="chart-stat-val">{{ $jurnalMingguan[strtolower(trim($hariIni))] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #60a5fa;">Jurnal</span></div>
                        </div>
                    </div>

                    <div class="bars-wrapper">
                        @php
                            $maxValChart = max(array_merge([1], array_values($jurnalMingguan)));
                            $currentDayLower = strtolower(trim($hariIni));
                        @endphp
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $day)
                            @php
                                $val = $jurnalMingguan[$day] ?? 0;
                                $pct = $maxValChart > 0 ? round(($val / $maxValChart) * 100) : 0;
                                $isToday = ($day === $currentDayLower);
                            @endphp
                            <div class="bar-group {{ $isToday ? 'today-bar' : '' }}">
                                <span class="bar-val">{{ $val }}</span>
                                <div class="bar-track">
                                    <div class="bar-fill" style="height: {{ max($pct, 8) }}%;" title="{{ ucfirst($day) }}: {{ $val }} Jurnal"></div>
                                </div>
                                <span class="bar-label">{{ $day }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-align: center; margin-top: 8px;">
                        <i class="fa-solid fa-square" style="color: #2563eb;"></i> Hari Ini &nbsp;&bull;&nbsp; <i class="fa-solid fa-square" style="color: #384972;"></i> Hari Lain
                    </div>
                </div>
            </div>

            <div style="margin-top: 14px; text-align: center;">
                <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-see-all" style="width: 100%; display: block; text-align: center;">Lihat Monitoring Jurnal</a>
            </div>
        </div>

        <!-- Widget 3: Pengumuman Cards -->
        <div class="section-card">
            <div>
                <div class="section-card-header">
                    <div class="section-card-title">
                        <div class="icon-badge">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <span>Pengumuman</span>
                    </div>
                    <span style="font-size: 11px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; padding: 2px 8px; border-radius: 12px; font-weight: 700;">
                        {{ count($pengumumanList) }} Info
                    </span>
                </div>

                <div class="announcement-list">
                    @forelse($pengumumanList->take(4) as $idx => $p)
                        <div class="announcement-card">
                            <div class="announcement-icon">
                                <i class="fa-solid {{ $idx === 0 ? 'fa-bell' : ($idx === 1 ? 'fa-file-lines' : ($idx === 2 ? 'fa-bullhorn' : 'fa-circle-info')) }}"></i>
                            </div>
                            <div>
                                <div class="announcement-text">{{ Str::limit($p->judul ?? $p->isi, 55) }}</div>
                                <div class="announcement-time">{{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at)->translatedFormat('d F Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="color: #94a3b8; font-size: 13px; text-align: center; padding: 20px;">Belum ada pengumuman terbaru.</div>
                    @endforelse
                </div>
            </div>

            <div style="margin-top: 14px; text-align: center;">
                <a href="{{ route('piket.pengumuman') }}" class="btn-see-all" style="width: 100%; display: block; text-align: center;">Lihat Semua Pengumuman</a>
            </div>
        </div>

    </div>

</div>
@endsection