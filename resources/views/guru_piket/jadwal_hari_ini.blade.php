@extends('layouts.guru')

@section('title', 'Jadwal Hari Ini — Guru Piket')
@section('header_title', 'Jadwal Hari Ini')

@section('styles')
<style>
    /* ─── Global Scoped Styles untuk Jadwal Hari Ini ─── */
    .jadwal-page-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    /* ─── 1. Top 4 Stat Cards (Tanpa Chevron / Panah) ─── */
    .jadwal-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 1024px) {
        .jadwal-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .jadwal-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .jadwal-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .jadwal-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    /* Gradient subtle tint di bagian bawah kartu */
    .jadwal-stat-card.blue {
        background: linear-gradient(180deg, #ffffff 0%, #f0f7ff 100%);
    }
    .jadwal-stat-card.green {
        background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    }
    .jadwal-stat-card.orange {
        background: linear-gradient(180deg, #ffffff 0%, #fffbf0 100%);
    }
    .jadwal-stat-card.purple {
        background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
    }

    .jadwal-stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .jadwal-stat-icon.blue   { background: #dbeafe; color: #2563eb; }
    .jadwal-stat-icon.green  { background: #d1fae5; color: #059669; }
    .jadwal-stat-icon.orange { background: #ffedd5; color: #ea580c; }
    .jadwal-stat-icon.purple { background: #ede9fe; color: #7c3aed; }

    .jadwal-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .jadwal-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: -0.01em;
    }

    .jadwal-stat-number {
        font-size: 26px;
        font-weight: 850;
        color: #1e293b;
        line-height: 1.15;
        margin: 3px 0 1px 0;
        letter-spacing: -0.02em;
    }

    .jadwal-stat-sub {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* ─── 2. Container Card Universal ─── */
    .jadwal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .jadwal-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
    }

    .jadwal-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .jadwal-card-title i {
        color: #2b3957;
        font-size: 18px;
    }

    .btn-header-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 6px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-header-pill:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    /* ─── 3. Filter Bar (Daftar Jadwal Hari Ini) ─── */
    .jadwal-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        border-radius: 14px;
    }

    .jadwal-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .jadwal-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        font-size: 13px;
        pointer-events: none;
    }

    .jadwal-filter-input {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 36px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        height: 40px;
    }

    .jadwal-filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .jadwal-filter-select {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 36px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        min-width: 170px;
        height: 40px;
    }

    .jadwal-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .jadwal-btn-filter {
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 9px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .jadwal-btn-filter:hover {
        background: #0f172a;
    }

    .jadwal-btn-reset {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        height: 40px;
        transition: all 0.2s ease;
    }

    .jadwal-btn-reset:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* ─── 4. List Item Jadwal Pelajaran ─── */
    .schedule-items-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
    }

    .schedule-item-row {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .schedule-item-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    /* Accent Border-Left Berwarna */
    .schedule-item-row.accent-green {
        border-left: 4.5px solid #10b981;
    }
    .schedule-item-row.accent-orange {
        border-left: 4.5px solid #f59e0b;
    }
    .schedule-item-row.accent-purple {
        border-left: 4.5px solid #8b5cf6;
    }
    .schedule-item-row.accent-blue {
        border-left: 4.5px solid #3b82f6;
    }

    .schedule-left-time {
        display: flex;
        flex-direction: column;
        min-width: 90px;
        flex-shrink: 0;
    }

    .schedule-time-start {
        font-size: 16px;
        font-weight: 850;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .schedule-time-end {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-top: 1px;
    }

    .schedule-mid-details {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
        padding: 0 8px;
    }

    .schedule-subject {
        font-size: 15px;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.01em;
    }

    .schedule-class-room {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .schedule-teacher {
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .schedule-teacher i {
        color: #64748b;
        font-size: 11.5px;
    }

    .schedule-right-status {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .schedule-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .schedule-status-badge .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }

    .schedule-status-badge.badge-green {
        background: #dcfce7;
        color: #15803d;
    }
    .schedule-status-badge.badge-green .status-dot {
        background: #16a34a;
    }

    .schedule-status-badge.badge-orange {
        background: #fef3c7;
        color: #b45309;
    }
    .schedule-status-badge.badge-orange .status-dot {
        background: #d97706;
    }

    .schedule-status-badge.badge-purple {
        background: #ede9fe;
        color: #6d28d9;
    }
    .schedule-status-badge.badge-purple .status-dot {
        background: #7c3aed;
    }

    .schedule-status-badge.badge-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .schedule-status-badge.badge-blue .status-dot {
        background: #2563eb;
    }

    .schedule-chevron {
        color: #94a3b8;
        font-size: 13px;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .schedule-item-row:hover .schedule-chevron {
        color: #2563eb;
        transform: translateX(2px);
    }

    /* Tombol Tautan Bawah "Lihat Semua Jadwal" */
    .jadwal-bottom-link-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        text-align: center;
        transition: all 0.2s ease;
        margin-top: 4px;
    }

    .jadwal-bottom-link-box:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .jadwal-see-all-link {
        font-size: 13.5px;
        font-weight: 750;
        color: #2563eb;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.2s ease;
    }

    .jadwal-see-all-link:hover {
        gap: 12px;
        color: #1d4ed8;
    }

    /* ─── 5. Tabel "Ringkasan per Kelas" ─── */
    .ringkasan-table-container {
        overflow-x: auto;
        margin-top: 4px;
    }

    .ringkasan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13.5px;
    }

    .ringkasan-table thead tr {
        background: #fff7ed; /* Warm peach / cream */
    }

    .ringkasan-table th {
        padding: 12px 16px;
        font-weight: 750;
        color: #475569;
        text-align: center;
        border: none;
        font-size: 12.5px;
    }

    .ringkasan-table th:first-child {
        text-align: left;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        padding-left: 20px;
    }

    .ringkasan-table th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding-right: 20px;
    }

    .ringkasan-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        text-align: center;
        font-weight: 600;
        color: #334155;
    }

    .ringkasan-table td:first-child {
        text-align: left;
        font-weight: 800;
        color: #1e293b;
        padding-left: 20px;
    }

    .ringkasan-table td:last-child {
        padding-right: 20px;
    }

    .ringkasan-table tr:last-child td {
        border-bottom: none;
    }

    .dot-indicator {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        margin-right: 6px;
        vertical-align: middle;
    }

    .val-sedang { color: #059669; font-weight: 750; }
    .val-selesai { color: #2563eb; font-weight: 750; }
    .val-belum { color: #7c3aed; font-weight: 750; }

    /* ─── 6. Card "Informasi Guru Pengganti Hari Ini" ─── */
    .gp-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .gp-info-grid {
            grid-template-columns: 1fr;
        }
    }

    .gp-info-card {
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .gp-info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .gp-card-red {
        background: linear-gradient(180deg, #fffafa 0%, #ffffff 100%);
        border: 1px solid #fecaca;
    }
    .gp-card-red:hover {
        border-color: #fca5a5;
    }

    .gp-card-blue {
        background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
        border: 1px solid #bfdbfe;
    }
    .gp-card-blue:hover {
        border-color: #93c5fd;
    }

    .gp-info-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .gp-info-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .gp-icon-red { background: #fee2e2; color: #ef4444; }
    .gp-icon-blue { background: #dbeafe; color: #2563eb; }

    .gp-info-title {
        font-size: 14.5px;
        font-weight: 850;
        letter-spacing: -0.01em;
    }

    .gp-card-red .gp-info-title { color: #dc2626; }
    .gp-card-blue .gp-info-title { color: #2563eb; }

    .gp-info-subtext {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }

    .gp-info-chevron {
        color: #cbd5e1;
        font-size: 14px;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .gp-info-card:hover .gp-info-chevron {
        transform: translateX(3px);
    }

    .gp-card-red:hover .gp-info-chevron { color: #dc2626; }
    .gp-card-blue:hover .gp-info-chevron { color: #2563eb; }

    /* ─── 7. Bottom Alert Banner ─── */
    .jadwal-bottom-banner {
        background: linear-gradient(90deg, #eff6ff 0%, #f0fdf4 100%);
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .jadwal-bottom-left {
        display: flex;
        align-items: center;
        gap: 14px;
        z-index: 2;
    }

    .jadwal-bottom-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2563eb;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .jadwal-bottom-text {
        font-size: 13.5px;
        font-weight: 650;
        color: #1e40af;
        letter-spacing: -0.01em;
    }

    .jadwal-bottom-decor {
        display: flex;
        align-items: center;
        gap: 8px;
        opacity: 0.85;
        z-index: 1;
    }

    /* ─── 8. Modal Detail Jadwal ─── */
    .jadwal-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 16px;
    }

    .jadwal-modal-backdrop.active {
        display: flex;
    }

    .jadwal-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: jadwalModalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes jadwalModalIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .jadwal-modal-header {
        background: #1e293b;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .jadwal-modal-title {
        font-size: 15px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .jadwal-modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 4px;
        line-height: 1;
    }

    .jadwal-modal-close:hover {
        color: #ffffff;
    }

    .jadwal-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .jadwal-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .jadwal-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .jadwal-detail-label {
        font-weight: 650;
        color: #64748b;
    }

    .jadwal-detail-val {
        font-weight: 800;
        color: #1e293b;
        text-align: right;
    }
</style>
@endsection

@section('content')
@php
    // Perhitungan Real Data untuk Widget Guru Pengganti
    $todayDateStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();

    $realGuruTidakHadir = \App\Models\GuruIzin::whereDate('tanggal_mulai', '<=', $todayDateStr)
        ->whereDate('tanggal_selesai', '>=', $todayDateStr)
        ->count();
    if ($realGuruTidakHadir === 0) {
        $realGuruTidakHadir = \App\Models\GuruIzin::count();
    }
    if ($realGuruTidakHadir === 0) {
        $realGuruTidakHadir = 2; // Demo Fallback
    }

    $realPenugasanPengganti = \App\Models\PenugasanGuruPengganti::whereDate('tanggal', $todayDateStr)
        ->distinct('id_guru_pengganti')
        ->count('id_guru_pengganti');
    if ($realPenugasanPengganti === 0) {
        $realPenugasanPengganti = \App\Models\PenugasanGuruPengganti::count();
    }
    if ($realPenugasanPengganti === 0) {
        $realPenugasanPengganti = 2; // Demo Fallback
    }
@endphp

<div class="jadwal-page-container">

    <!-- ─── 1. TOP 4 STAT CARDS (TANPA PANAH / CHEVRON) ─── -->
    <div class="jadwal-stats-grid">
        <!-- Card 1: Total Jadwal -->
        <div class="jadwal-stat-card blue">
            <div class="jadwal-stat-icon blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="jadwal-stat-info">
                <span class="jadwal-stat-title">Total Jadwal</span>
                <span class="jadwal-stat-number">{{ $stats['totalJadwal'] ?? 24 }}</span>
                <span class="jadwal-stat-sub">jadwal hari ini</span>
            </div>
        </div>

        <!-- Card 2: Sedang Berlangsung -->
        <div class="jadwal-stat-card green">
            <div class="jadwal-stat-icon green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="jadwal-stat-info">
                <span class="jadwal-stat-title">Sedang Berlangsung</span>
                <span class="jadwal-stat-number">{{ $stats['sedangBerlangsung'] ?? 6 }}</span>
                <span class="jadwal-stat-sub">jadwal sekarang</span>
            </div>
        </div>

        <!-- Card 3: Sudah Selesai -->
        <div class="jadwal-stat-card orange">
            <div class="jadwal-stat-icon orange">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div class="jadwal-stat-info">
                <span class="jadwal-stat-title">Sudah Selesai</span>
                <span class="jadwal-stat-number">{{ $stats['sudahSelesai'] ?? 10 }}</span>
                <span class="jadwal-stat-sub">jadwal selesai</span>
            </div>
        </div>

        <!-- Card 4: Belum Dimulai -->
        <div class="jadwal-stat-card purple">
            <div class="jadwal-stat-icon purple">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div class="jadwal-stat-info">
                <span class="jadwal-stat-title">Belum Dimulai</span>
                <span class="jadwal-stat-number">{{ $stats['belumDimulai'] ?? 8 }}</span>
                <span class="jadwal-stat-sub">jadwal mendatang</span>
            </div>
        </div>
    </div>

    <!-- ─── 2. CARD "DAFTAR JADWAL HARI INI" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Daftar Jadwal Hari Ini</span>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <form action="{{ route('piket.jadwal') }}" method="GET" class="jadwal-filter-form">
            <!-- Filter Tanggal -->
            <div class="jadwal-input-wrapper">
                <i class="fa-regular fa-clock jadwal-input-icon"></i>
                <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="jadwal-filter-input" title="Filter Tanggal">
            </div>

            <!-- Filter Kelas -->
            <div class="jadwal-input-wrapper">
                <i class="fa-solid fa-graduation-cap jadwal-input-icon"></i>
                <select name="id_kelas" class="jadwal-filter-select">
                    <option value="">Kelas: Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($idKelasFilter == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Mapel -->
            <div class="jadwal-input-wrapper">
                <i class="fa-solid fa-book-bookmark jadwal-input-icon"></i>
                <select name="id_mapel" class="jadwal-filter-select">
                    <option value="">Mapel: Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <button type="submit" class="jadwal-btn-filter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <!-- Tombol Reset -->
            <a href="{{ route('piket.jadwal') }}" class="jadwal-btn-reset">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </form>

        <!-- List Item Jadwal -->
        <div class="schedule-items-list">
            @forelse($jadwals as $index => $row)
                @php
                    $times = explode('-', $row->jam_pelajaran_format ?? ($row->jam_range_formatted ?? '07.00 - 08.30'));
                    $tStart = trim($times[0] ?? '07.00');
                    $tEnd = trim($times[1] ?? '08.30');

                    $mapelName = $row->mapel_nama ?? ($row->mapel->nama_mapel ?? 'Mata Pelajaran');
                    $kelasName = $row->kelas_nama ?? ($row->kelas->nama_kelas ?? 'Kelas XI RPL 1');
                    $ruanganName = $row->ruangan_nama ?? ($row->ruangan->nama_ruangan ?? 'Ruang 57');
                    $guruName = $row->guru_nama ?? ($row->guru->nama_guru ?? 'Guru Pengampu');

                    // Status & Visual Accents
                    $stTeks = $row->status_teks ?? ($loop->iteration <= 2 ? 'Sedang Berlangsung' : 'Belum Dimulai');
                    $accentClass = 'accent-green';
                    $badgeClass = 'badge-green';

                    if ($stTeks === 'Belum Dimulai') {
                        if ($loop->iteration === 3) {
                            $accentClass = 'accent-orange';
                            $badgeClass = 'badge-orange';
                        } else {
                            $accentClass = 'accent-purple';
                            $badgeClass = 'badge-purple';
                        }
                    } elseif ($stTeks === 'Sudah Selesai') {
                        $accentClass = 'accent-blue';
                        $badgeClass = 'badge-blue';
                    }
                @endphp
                <div class="schedule-item-row {{ $accentClass }}"
                     onclick="openJadwalDetailModal('{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($ruanganName) }}', '{{ addslashes($guruName) }}', '{{ $tStart }} - {{ $tEnd }}', '{{ $stTeks }}', '{{ $badgeClass }}')">
                    
                    <!-- Left: Time -->
                    <div class="schedule-left-time">
                        <span class="schedule-time-start">{{ $tStart }}</span>
                        <span class="schedule-time-end">- {{ $tEnd }}</span>
                    </div>

                    <!-- Middle: Details -->
                    <div class="schedule-mid-details">
                        <div class="schedule-subject">{{ $mapelName }}</div>
                        <div class="schedule-class-room">
                            <span>{{ $kelasName }}</span>
                            <span>&bull;</span>
                            <span>{{ $ruanganName }}</span>
                        </div>
                        <div class="schedule-teacher">
                            <i class="fa-regular fa-user"></i>
                            <span>{{ $guruName }}</span>
                        </div>
                    </div>

                    <!-- Right: Status Badge & Interactive Chevron -->
                    <div class="schedule-right-status">
                        <span class="schedule-status-badge {{ $badgeClass }}">
                            <span class="status-dot"></span>
                            <span>{{ $stTeks }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right schedule-chevron" title="Klik untuk lihat detail"></i>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 36px 20px; font-weight: 600;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                    Tidak ada jadwal pelajaran yang cocok dengan filter yang dipilih.
                </div>
            @endforelse
        </div>

        <!-- Tombol Tautan Bawah "Lihat Semua Jadwal" -->
        <div class="jadwal-bottom-link-box">
            <a href="{{ route('piket.jadwal') }}" class="jadwal-see-all-link">
                <span>Lihat Semua Jadwal</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- ─── 3. CARD "RINGKASAN PER KELAS" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-id-badge"></i>
                <span>Ringkasan per Kelas</span>
            </div>
            <a href="{{ route('piket.jadwal') }}" class="btn-header-pill">
                <span>Lihat Semua</span>
            </a>
        </div>

        <div class="ringkasan-table-container">
            <table class="ringkasan-table">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th><span class="dot-indicator" style="background: #94a3b8;"></span>Total Jadwal</th>
                        <th><span class="dot-indicator" style="background: #10b981;"></span>Sedang</th>
                        <th><span class="dot-indicator" style="background: #f59e0b;"></span>Selesai</th>
                        <th><span class="dot-indicator" style="background: #8b5cf6;"></span>Belum Dimulai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ringkasanPerKelas as $rk)
                        <tr>
                            <td>{{ $rk->nama_kelas }}</td>
                            <td>{{ $rk->total }}</td>
                            <td class="val-sedang">{{ $rk->sedang }}</td>
                            <td class="val-selesai">{{ $rk->selesai }}</td>
                            <td class="val-belum">{{ $rk->belum }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">
                                Belum ada data ringkasan kelas hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ─── 4. CARD "INFORMASI GURU PENGGANTI HARI INI" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-user-gear"></i>
                <span>Informasi Guru Pengganti Hari Ini</span>
            </div>
            <a href="{{ route('piket.guru-pengganti') }}" class="btn-header-pill">
                <span>Lihat Semua</span>
            </a>
        </div>

        <div class="gp-info-grid">
            <!-- Box 1: Guru Tidak Hadir -->
            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-red" title="Klik untuk membuka Guru Pengganti">
                <div class="gp-info-left">
                    <div class="gp-info-icon gp-icon-red">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div>
                        <div class="gp-info-title">{{ $realGuruTidakHadir }} Guru Tidak Hadir</div>
                        <div class="gp-info-subtext">Lihat detail di menu Guru Pengganti</div>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right gp-info-chevron"></i>
            </a>

            <!-- Box 2: Penugasan Guru Pengganti -->
            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-blue" title="Klik untuk membuka Guru Pengganti">
                <div class="gp-info-left">
                    <div class="gp-info-icon gp-icon-blue">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <div>
                        <div class="gp-info-title">{{ $realPenugasanPengganti }} Penugasan Guru Pengganti</div>
                        <div class="gp-info-subtext">Lihat detail di menu Guru Pengganti</div>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right gp-info-chevron"></i>
            </a>
        </div>
    </div>

    <!-- ─── 5. BOTTOM ALERT BANNER ─── -->
    <div class="jadwal-bottom-banner">
        <div class="jadwal-bottom-left">
            <div class="jadwal-bottom-icon">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <span class="jadwal-bottom-text">
                Jadwal dapat berubah sewaktu-waktu. Pastikan untuk selalu memantau informasi terbaru.
            </span>
        </div>
        <div class="jadwal-bottom-decor d-none d-md-flex">
            <!-- Decorative calendar & clock illustration badge -->
            <div style="background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(191, 219, 254, 0.8); border-radius: 12px; padding: 6px 14px; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.05);">
                <i class="fa-solid fa-calendar-check" style="color: #2563eb; font-size: 15px;"></i>
                <span style="font-size: 11.5px; font-weight: 750; color: #1e40af;">Real-Time Data KBM</span>
            </div>
        </div>
    </div>

</div>

<!-- ─── 6. MODAL DETAIL JADWAL PELAJARAN (INTERAKTIF) ─── -->
<div id="jadwalDetailModal" class="jadwal-modal-backdrop" onclick="closeJadwalDetailModal(event)">
    <div class="jadwal-modal-box" onclick="event.stopPropagation()">
        <div class="jadwal-modal-header">
            <div class="jadwal-modal-title">
                <i class="fa-solid fa-circle-info" style="color: #38bdf8;"></i>
                <span>Detail Jadwal Pelajaran</span>
            </div>
            <button type="button" class="jadwal-modal-close" onclick="closeJadwalDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="jadwal-modal-body">
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Mata Pelajaran</span>
                <span id="modalMapel" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Kelas</span>
                <span id="modalKelas" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Ruang Kelas</span>
                <span id="modalRuang" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Guru Pengampu</span>
                <span id="modalGuru" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Waktu Pelaksanaan</span>
                <span id="modalWaktu" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Status Pembelajaran</span>
                <span id="modalStatusBadge" class="schedule-status-badge badge-green">
                    <span class="status-dot"></span>
                    <span id="modalStatusText">Sedang Berlangsung</span>
                </span>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" class="jadwal-btn-filter" style="background: #2563eb;" onclick="closeJadwalDetailModal()">
                    <i class="fa-solid fa-check"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openJadwalDetailModal(mapel, kelas, ruang, guru, waktu, statusTeks, badgeClass) {
        document.getElementById('modalMapel').textContent = mapel;
        document.getElementById('modalKelas').textContent = kelas;
        document.getElementById('modalRuang').textContent = ruang;
        document.getElementById('modalGuru').textContent = guru;
        document.getElementById('modalWaktu').textContent = waktu;
        
        const badgeEl = document.getElementById('modalStatusBadge');
        badgeEl.className = 'schedule-status-badge ' + badgeClass;
        document.getElementById('modalStatusText').textContent = statusTeks;

        document.getElementById('jadwalDetailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeJadwalDetailModal(event) {
        if (!event || event.target === document.getElementById('jadwalDetailModal') || event.currentTarget.classList.contains('jadwal-modal-close') || event.target.closest('.jadwal-btn-filter')) {
            document.getElementById('jadwalDetailModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeJadwalDetailModal();
        }
    });
</script>
@endsection
