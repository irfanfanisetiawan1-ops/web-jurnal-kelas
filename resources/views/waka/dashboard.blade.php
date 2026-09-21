@extends('layouts.waka')

@section('title', 'Dashboard Wakil Kesiswaan — Jurnal SMEA')

@section('styles')
<style>
    /* Global Dashboard Styles */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Page Header */
    .page-header-box {
        margin-bottom: 4px;
    }

    .page-main-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-sub-title {
        font-size: 14px;
        color: #475569;
        font-weight: 500;
        margin-top: 4px;
    }

    /* 4 Top Stat Cards (According to User Mockup) */
    .stat-cards-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-box-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .stat-box-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .stat-icon-circle {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    /* Color variants for icon circles */
    .icon-circle-blue {
        background: #bae6fd;
        color: #0369a1;
    }

    .icon-circle-green {
        background: #bbf7d0;
        color: #15803d;
    }

    .icon-circle-orange {
        background: #fed7aa;
        color: #c2410c;
    }

    .icon-circle-purple {
        background: #e9d5ff;
        color: #7e22ce;
    }

    .stat-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stat-label-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .stat-number-text {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .stat-subtext {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
    }

    /* 2-Column Main Section Grid */
    .dashboard-main-grid {
        display: grid;
        grid-template-columns: 1.15fr 1.35fr;
        gap: 20px;
    }

    .panel-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
    }

    .panel-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .panel-card-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-header-link {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.15s ease;
    }

    .panel-header-link:hover {
        color: #2563eb;
    }

    /* Chart Container (Rekap Kehadiran Minggu Ini) */
    .chart-wrapper {
        position: relative;
        height: 230px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-top: 10px;
    }

    .chart-grid-area {
        position: relative;
        flex: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        padding-left: 48px;
        border-bottom: 1.5px solid #cbd5e1;
        margin-bottom: 8px;
    }

    /* Y-Axis lines and labels */
    .y-axis-lines {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
    }

    .y-grid-line {
        position: relative;
        width: 100%;
        height: 1px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
    }

    .y-grid-label {
        position: absolute;
        left: 0;
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        width: 44px;
    }

    /* Bar Item */
    .bar-column-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        z-index: 2;
        width: 15%;
        cursor: pointer;
        position: relative;
    }

    .bar-rect {
        width: 38px;
        background: #2b3957;
        border-radius: 5px 5px 0 0;
        transition: height 0.6s cubic-bezier(0.16, 1, 0.3, 1), background 0.2s ease;
        position: relative;
    }

    .bar-column-group:hover .bar-rect {
        background: #1d4ed8;
    }

    .bar-rect.is-active-day {
        background: #2563eb;
        box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);
    }

    /* Bar Tooltip on Hover */
    .bar-tooltip {
        position: absolute;
        top: -42px;
        background: #0f172a;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 9px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease;
        transform: translateY(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10;
        text-align: center;
        line-height: 1.3;
    }

    .bar-tooltip::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 4px 4px 0;
        border-style: solid;
        border-color: #0f172a transparent;
        display: block;
        width: 0;
    }

    .bar-column-group:hover .bar-tooltip {
        opacity: 1;
        transform: translateY(0);
    }

    .x-axis-labels {
        display: flex;
        justify-content: space-around;
        padding-left: 48px;
    }

    .x-label-item {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        width: 15%;
        text-align: center;
    }

    .x-label-item.is-active-day {
        color: #2563eb;
        font-weight: 800;
    }

    /* Table / List Pengajuan Izin Terbaru */
    .recent-izin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .recent-izin-table thead {
        border-bottom: 1.5px solid #e2e8f0;
    }

    .recent-izin-table th {
        padding: 0 0 12px 0;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        text-align: left;
    }

    .recent-izin-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
        cursor: pointer;
    }

    .recent-izin-table tbody tr:last-child {
        border-bottom: none;
    }

    .recent-izin-table tbody tr:hover {
        background: #f8fafc;
    }

    .recent-izin-table td {
        padding: 14px 6px;
        font-size: 13px;
        color: #0f172a;
    }

    .col-nama {
        font-weight: 700;
        color: #0f172a;
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .col-kelas {
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .col-alasan {
        font-weight: 500;
        color: #334155;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .col-tanggal {
        font-weight: 700;
        color: #0f172a;
        text-align: right;
        white-space: nowrap;
        font-size: 12.5px;
    }

    /* Category Badges */
    .badge-cat {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 800;
        margin-right: 4px;
        text-transform: uppercase;
    }
    .badge-cat-sakit { background: #fee2e2; color: #991b1b; }
    .badge-cat-izin { background: #dbeafe; color: #1e40af; }
    .badge-cat-dispen { background: #fef3c7; color: #92400e; }

    /* Secondary Lower Section (Approvals & Monitoring) */
    .lower-section-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
    }

    .approval-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .approval-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        gap: 12px;
    }

    .approval-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #cbd5e1;
        color: #1e293b;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-details-text .name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .user-details-text .subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .reason-text {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        flex: 1;
        padding: 0 10px;
    }

    .approval-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action-reject {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fecdd3;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-action-reject:hover {
        background: #fee2e2;
    }

    .btn-action-approve {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        transition: all 0.15s ease;
    }

    .btn-action-approve:hover {
        background: #1d4ed8;
    }

    /* Monitoring Bars */
    .progress-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 4px;
    }

    .progress-item-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .progress-bar-bg {
        width: 100%;
        height: 9px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #2b3957;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    /* Quick Action Mini Cards */
    .mini-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .mini-stat-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mini-stat-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
    }

    .mini-stat-val {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Modals */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-card-custom {
        background: #ffffff;
        width: 100%;
        max-width: 600px;
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        border: 1px solid #cbd5e1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-custom {
        padding: 22px 24px;
        overflow-y: auto;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .modal-footer-custom {
        padding: 14px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .btn-modal-close {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-modal-close:hover {
        background: #cbd5e1;
    }

    .info-group-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .info-box {
        background: #f8fafc;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .info-box .label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-box .value {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }

    /* Prestasi List Item in Modal */
    .prestasi-item-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .prestasi-icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #e9d5ff;
        color: #7e22ce;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    @media (max-width: 1100px) {
        .stat-cards-row { grid-template-columns: repeat(2, 1fr); }
        .dashboard-main-grid { grid-template-columns: 1fr; }
        .lower-section-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .stat-cards-row { grid-template-columns: 1fr; }
        .info-group-grid { grid-template-columns: 1fr; }
        .mini-stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Flash Alert Success -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 12px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fecdd3; padding: 14px 18px; border-radius: 12px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header-box">
        <h1 class="page-main-title">Wakil Kesiswaan</h1>
        <p class="page-sub-title">Bersama kelola potensi dan karakter siswa untuk masa depan yang lebih baik.</p>
    </div>

    <!-- 4 Top Stat Cards Row -->
    <div class="stat-cards-row">
        <!-- Card 1: Total Siswa -->
        <a href="{{ route('waka.siswa') }}" class="stat-box-card" title="Lihat Data Siswa">
            <div class="stat-icon-circle icon-circle-blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Total Siswa</span>
                <span class="stat-number-text">{{ number_format($totalSiswa, 0, ',', '.') }}</span>
                <span class="stat-subtext">Siswa Aktif Terdaftar</span>
            </div>
        </a>

        <!-- Card 2: Siswa Hadir -->
        <a href="{{ route('waka.rekap-kehadiran') }}" class="stat-box-card" title="Kehadiran Siswa Hari Ini">
            <div class="stat-icon-circle icon-circle-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Siswa Hadir</span>
                <span class="stat-number-text">{{ number_format($siswaHadir, 0, ',', '.') }}</span>
                <span class="stat-subtext" style="color: #16a34a;">{{ $persentaseHadir }}% Tingkat Kehadiran</span>
            </div>
        </a>

        <!-- Card 3: Pengajuan Izin -->
        <a href="{{ route('waka.persetujuan-izin') }}" class="stat-box-card" title="Kelola Persetujuan Izin">
            <div class="stat-icon-circle icon-circle-orange">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Pengajuan Izin</span>
                <span class="stat-number-text">{{ number_format($pengajuanIzinCount, 0, ',', '.') }}</span>
                <span class="stat-subtext">{{ $pengajuanIzinPendingCount }} Menunggu Verifikasi</span>
            </div>
        </a>

        <!-- Card 4: Prestasi Bulan Ini -->
        <div class="stat-box-card" style="cursor: pointer;" onclick="openPrestasiModal()" title="Klik untuk melihat capaian prestasi">
            <div class="stat-icon-circle icon-circle-purple">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Prestasi Bulan Ini</span>
                <span class="stat-number-text">{{ number_format($prestasiBulanIniCount, 0, ',', '.') }}</span>
                <span class="stat-subtext">Total {{ $totalPrestasiCount }} Prestasi Sekolah &rarr;</span>
            </div>
        </div>
    </div>

    <!-- Middle 2-Column Section Grid -->
    <div class="dashboard-main-grid">
        
        <!-- Left Column: Rekap Kehadiran Minggu Ini (Bar Chart) -->
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">
                    <i class="fa-solid fa-chart-column" style="color: #2563eb; font-size: 16px;"></i>
                    <span>Rekap Kehadiran Minggu Ini</span>
                </h2>
                <a href="{{ route('waka.rekap-kehadiran') }}" class="panel-header-link">
                    <span>Lihat Detail</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                </a>
            </div>

            <div class="chart-wrapper">
                <div class="chart-grid-area">
                    <!-- Dynamic Y-Axis Grid Lines -->
                    <div class="y-axis-lines">
                        @foreach($yTicks as $tick)
                            <div class="y-grid-line" style="{{ $loop->last ? 'border-bottom:none;' : '' }}">
                                <span class="y-grid-label">{{ number_format($tick, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Bars for Sen, Sel, Rab, Kam, Jum -->
                    @foreach($rekapMingguan as $item)
                        <div class="bar-column-group">
                            <div class="bar-tooltip">
                                <div style="font-weight: 800;">{{ $item['tanggal'] }}</div>
                                <div>{{ number_format($item['hadir'], 0, ',', '.') }} Hadir ({{ $item['persentase'] }}%)</div>
                                <div style="color: #cbd5e1; font-size: 10px;">{{ $item['tidak_hadir'] }} Tidak Hadir</div>
                            </div>
                            <div class="bar-rect {{ $item['is_today'] ? 'is-active-day' : '' }}" style="height: {{ $item['height_pct'] }}%;"></div>
                        </div>
                    @endforeach
                </div>

                <!-- X-Axis Labels -->
                <div class="x-axis-labels">
                    @foreach($rekapMingguan as $item)
                        <div class="x-label-item {{ $item['is_today'] ? 'is-active-day' : '' }}">{{ $item['label'] }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Pengajuan Izin Terbaru -->
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">
                    <i class="fa-solid fa-clipboard-list" style="color: #d97706; font-size: 16px;"></i>
                    <span>Pengajuan Izin Terbaru</span>
                </h2>
                <a href="{{ route('waka.persetujuan-izin') }}" class="panel-header-link" style="color: #2563eb;">
                    <span>Semua Izin</span>
                    <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="recent-izin-table">
                    <tbody>
                        @forelse($pengajuanIzinTerbaru as $izin)
                            <tr onclick='openIzinDetailModal(@json($izin))' title="Klik untuk melihat detail permohonan">
                                <td class="col-nama" title="{{ $izin->nama_siswa }}">
                                    @if(str_contains(strtolower($izin->kategori), 'sakit'))
                                        <span class="badge-cat badge-cat-sakit">Sakit</span>
                                    @elseif(str_contains(strtolower($izin->kategori), 'dispen'))
                                        <span class="badge-cat badge-cat-dispen">Dispen</span>
                                    @else
                                        <span class="badge-cat badge-cat-izin">Izin</span>
                                    @endif
                                    {{ $izin->nama_siswa }}
                                </td>
                                <td class="col-kelas">{{ $izin->kelas }}</td>
                                <td class="col-alasan" title="{{ $izin->alasan }}">{{ $izin->alasan }}</td>
                                <td class="col-tanggal">{{ $izin->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 24px;">
                                    Belum ada pengajuan izin terbaru hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Secondary Lower Section: Antrean Persetujuan Waka & Monitoring Tingkat Kelas -->
    <div class="lower-section-grid">
        
        <!-- Left: Antrean Persetujuan (Quick Action) -->
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">
                    <i class="fa-solid fa-hourglass-half" style="color: #ea580c; font-size: 16px;"></i>
                    <span>Antrean Persetujuan Cepat</span>
                </h2>
                <a href="{{ route('waka.persetujuan-izin') }}" class="panel-header-link" style="color: #2563eb;">
                    <span>Kelola Lengkap</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                </a>
            </div>

            <div class="approval-list">
                @forelse($antreanPersetujuan as $item)
                    <div class="approval-item">
                        <div class="approval-item-left">
                            <div class="user-avatar-circle">{{ $item->initials }}</div>
                            <div class="user-details-text">
                                <div class="name">{{ $item->nama }}</div>
                                <div class="subtext">{{ $item->subtext }}</div>
                            </div>
                        </div>

                        <div class="reason-text" title="{{ $item->alasan }}">
                            {{ Str::limit($item->alasan, 45) }}
                        </div>

                        <div class="approval-actions">
                            @if($item->type === 'guru_izin')
                                <form action="{{ route('waka.izin.reject', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak permohonan izin guru ini?')">
                                    @csrf
                                    <button type="submit" class="btn-action-reject">Tolak</button>
                                </form>
                                <form action="{{ route('waka.izin.approve', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-approve">Setujui</button>
                                </form>
                            @else
                                <form action="{{ route('waka.dispen.reject', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak permohonan dispensasi siswa ini?')">
                                    @csrf
                                    <button type="submit" class="btn-action-reject">Tolak</button>
                                </form>
                                <form action="{{ route('waka.dispen.approve', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-approve">Setujui</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #64748b; padding: 24px 0; font-size: 13.5px; font-weight: 600;">
                        <i class="fa-solid fa-check-circle" style="color: #10b981; margin-right: 6px; font-size: 18px;"></i>
                        Semua antrean izin & dispensasi telah selesai diproses.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Monitoring Kehadiran Tingkat Kelas & Disiplin -->
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">
                    <i class="fa-solid fa-layer-group" style="color: #2563eb; font-size: 16px;"></i>
                    <span>Monitoring Tingkat Kelas</span>
                </h2>
                <span style="font-size: 12px; font-weight: 700; color: #64748b;">Hari Ini</span>
            </div>

            <div class="progress-list">
                <!-- Grade X -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas X ({{ number_format($monitoringKehadiran['total_x'] ?? 580, 0, ',', '.') }} Siswa)</span>
                        <span>{{ $monitoringKehadiran['kelas_x'] ?? 96 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_x'] ?? 96 }}%;"></div>
                    </div>
                </div>

                <!-- Grade XI -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas XI ({{ number_format($monitoringKehadiran['total_xi'] ?? 570, 0, ',', '.') }} Siswa)</span>
                        <span>{{ $monitoringKehadiran['kelas_xi'] ?? 93 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_xi'] ?? 93 }}%;"></div>
                    </div>
                </div>

                <!-- Grade XII -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas XII ({{ number_format($monitoringKehadiran['total_xii'] ?? 563, 0, ',', '.') }} Siswa)</span>
                        <span>{{ $monitoringKehadiran['kelas_xii'] ?? 91 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_xii'] ?? 91 }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Mini Indicators Kedisiplinan Siswa -->
            <div class="mini-stats-grid">
                <div class="mini-stat-pill">
                    <div class="mini-stat-title"><i class="fa-solid fa-person-running" style="color:#d97706; margin-right:4px;"></i> Siswa Telat</div>
                    <div class="mini-stat-val">{{ $siswaTelatHariIniCount }}</div>
                </div>
                <div class="mini-stat-pill">
                    <div class="mini-stat-title"><i class="fa-solid fa-shield-halved" style="color:#dc2626; margin-right:4px;"></i> Lapor Siswa</div>
                    <div class="mini-stat-val">{{ $laporSiswaCount }}</div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- MODAL DETAIL PENGAJUAN IZIN / DISPENSASI -->
<div id="modalIzinDetail" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-file-lines"></i> Detail Permohonan Izin / Dispensasi</h3>
            <button type="button" onclick="closeIzinDetailModal()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-custom">
            <div class="info-group-grid">
                <div class="info-box">
                    <div class="label">Nama Siswa</div>
                    <div class="value" id="mdlNamaSiswa">-</div>
                </div>
                <div class="info-box">
                    <div class="label">Kelas / NISN</div>
                    <div class="value" id="mdlKelasNisn">-</div>
                </div>
                <div class="info-box">
                    <div class="label">Kategori Permohonan</div>
                    <div class="value" id="mdlKategori">-</div>
                </div>
                <div class="info-box">
                    <div class="label">Tanggal Berlaku</div>
                    <div class="value" id="mdlTanggal">-</div>
                </div>
            </div>

            <div class="info-box">
                <div class="label">Keterangan / Alasan Lengkap</div>
                <div class="value" id="mdlAlasan" style="font-weight: 500; font-size: 13.5px; line-height: 1.4; margin-top: 4px;">-</div>
            </div>

            <div id="mdlFotoContainer" style="display: none;">
                <div class="label" style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Bukti / Surat Terlampir</div>
                <div style="border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0; max-height: 220px; text-align: center; background: #0f172a;">
                    <img id="mdlFotoImg" src="" alt="Bukti Surat" style="max-width: 100%; max-height: 220px; object-fit: contain;">
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-modal-close" onclick="closeIzinDetailModal()">Tutup</button>
            <a href="{{ route('waka.persetujuan-izin') }}" class="btn-action-approve" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <span>Buka di Halaman Persetujuan</span>
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i>
            </a>
        </div>
    </div>
</div>

<!-- MODAL DAFTAR PRESTASI SISWA -->
<div id="modalPrestasi" class="modal-backdrop-custom">
    <div class="modal-card-custom" style="max-width: 680px;">
        <div class="modal-header-custom" style="background: #7e22ce;">
            <h3><i class="fa-solid fa-trophy"></i> Capaian Prestasi Siswa SMEA</h3>
            <button type="button" onclick="closePrestasiModal()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-custom" style="max-height: 60vh;">
            <p style="font-size: 13px; color: #64748b; margin-top: -4px;">Daftar siswa yang telah menorehkan prestasi membanggakan pada perlombaan tingkat regional hingga nasional:</p>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($prestasiTerbaruList as $prestasi)
                    <div class="prestasi-item-row">
                        <div class="prestasi-icon-circle">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $prestasi->nama_prestasi }}</div>
                            <div style="font-size: 12px; font-weight: 700; color: #7e22ce; margin-top: 2px;">
                                {{ $prestasi->peringkat }} — Tingkat {{ $prestasi->tingkat }}
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 4px;">
                                Siswa: <strong>{{ $prestasi->siswa->nama_siswa ?? '-' }}</strong> ({{ $prestasi->kelas->nama_kelas ?? '-' }})
                            </div>
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                Penyelenggara: {{ $prestasi->penyelenggara ?? '-' }} &bull; Tanggal: {{ \Carbon\Carbon::parse($prestasi->tanggal_prestasi)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 30px;">Belum ada data prestasi yang tercatat.</div>
                @endforelse
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-modal-close" onclick="closePrestasiModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openIzinDetailModal(data) {
        document.getElementById('mdlNamaSiswa').innerText = data.nama_siswa || '-';
        document.getElementById('mdlKelasNisn').innerText = (data.kelas || '-') + ' / ' + (data.nisn || '-');
        document.getElementById('mdlKategori').innerText = data.kategori || 'Izin';
        document.getElementById('mdlTanggal').innerText = data.tanggal || '-';
        document.getElementById('mdlAlasan').innerText = data.alasan || data.keterangan || '-';

        const fotoContainer = document.getElementById('mdlFotoContainer');
        const fotoImg = document.getElementById('mdlFotoImg');
        const fotoUrl = data.foto_bukti || data.foto_surat || data.foto_kartu;

        if (fotoUrl) {
            fotoImg.src = fotoUrl;
            fotoContainer.style.display = 'block';
        } else {
            fotoContainer.style.display = 'none';
            fotoImg.src = '';
        }

        document.getElementById('modalIzinDetail').style.display = 'flex';
    }

    function closeIzinDetailModal() {
        document.getElementById('modalIzinDetail').style.display = 'none';
    }

    function openPrestasiModal() {
        document.getElementById('modalPrestasi').style.display = 'flex';
    }

    function closePrestasiModal() {
        document.getElementById('modalPrestasi').style.display = 'none';
    }

    // Close on click backdrop
    window.onclick = function(event) {
        const mdlIzin = document.getElementById('modalIzinDetail');
        const mdlPrestasi = document.getElementById('modalPrestasi');
        if (event.target === mdlIzin) {
            closeIzinDetailModal();
        }
        if (event.target === mdlPrestasi) {
            closePrestasiModal();
        }
    };
</script>
@endsection
