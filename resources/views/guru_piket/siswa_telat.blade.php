@extends('layouts.guru')

@section('title', 'Siswa Telat — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Student & Guru Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Container & Base Styles */
    .telat-page-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ─── Top 3 Stat Cards (Tanpa Panah / Chevron) ─── */
    .telat-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    @media (max-width: 992px) {
        .telat-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .telat-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .telat-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .telat-stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
    }

    .telat-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .telat-stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .telat-stat-icon.green {
        background: #ecfdf5;
        color: #10b981;
    }

    .telat-stat-icon.orange {
        background: #fff7ed;
        color: #f97316;
    }

    .telat-stat-icon.purple {
        background: #faf5ff;
        color: #a855f7;
    }

    .telat-stat-info {
        display: flex;
        flex-direction: column;
    }

    .telat-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 2px;
    }

    .telat-stat-number-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .telat-stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .telat-stat-unit {
        font-size: 14px;
        font-weight: 700;
        color: #475569;
    }

    .telat-stat-sub {
        font-size: 11.5px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* ─── Card Container Standard ─── */
    .telat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .telat-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .telat-card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .telat-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .telat-card-title {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .telat-card-subtitle {
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .telat-pill-badge {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* ─── Filter & Toolbar Block (Kompak, Rapi & Menyatu) ─── */
    .telat-filter-block {
        padding: 14px 20px 12px 20px;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .telat-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .telat-search-box {
        flex: 1 1 220px;
        min-width: 180px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .telat-search-box i {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }

    .telat-search-input {
        width: 100%;
        padding: 8px 12px 8px 34px !important;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .telat-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .telat-filter-select {
        flex: 0 1 160px;
        min-width: 135px;
        padding: 8px 10px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
        cursor: pointer;
    }

    .telat-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .telat-filter-date {
        flex: 0 1 140px;
        min-width: 130px;
        padding: 7px 10px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .telat-filter-date:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .telat-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        flex-shrink: 0;
    }

    .telat-btn-cari {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #1d4ed8;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        box-shadow: 0 1px 4px rgba(37, 99, 235, 0.2);
    }

    .telat-btn-cari:hover {
        background: #1d4ed8;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }

    .telat-btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 7px 12px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .telat-btn-reset:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* Baris 2: Toolbar Aksi Tabel */
    .telat-action-toolbar {
        padding: 0;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    .telat-toolbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 32px;
    }

    .telat-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    /* Placeholder Toolbar */
    .telat-bulk-placeholder {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 11.5px;
        font-weight: 500;
        color: #64748b;
        height: 32px;
        box-sizing: border-box;
        user-select: none;
    }

    .telat-bulk-placeholder i {
        font-size: 12px;
        color: #3b82f6;
    }

    .telat-btn-bulk-del {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        height: 32px;
        box-sizing: border-box;
        box-shadow: 0 1px 2px rgba(220, 38, 38, 0.08);
    }

    .telat-btn-bulk-del:hover {
        background: #fecaca;
        color: #b91c1c;
        border-color: #f87171;
    }

    .telat-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #1d4ed8;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        height: 32px;
        box-sizing: border-box;
        box-shadow: 0 1px 4px rgba(37, 99, 235, 0.2);
    }

    .telat-btn-add:hover {
        background: #1d4ed8;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
    }

    .telat-btn-trash-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        color: #db2777;
        border: 1px solid #fbcfe8;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        height: 32px;
        box-sizing: border-box;
        box-shadow: 0 1px 2px rgba(219, 39, 119, 0.04);
    }

    .telat-btn-trash-link:hover {
        background: #fdf2f8;
        color: #be185d;
        border-color: #f472b6;
    }

    /* Checkbox Styling */
    .telat-checkbox {
        width: 15px;
        height: 15px;
        border-radius: 4px;
        border: 1.5px solid #94a3b8 !important;
        background-color: #ffffff;
        cursor: pointer;
        accent-color: #2563eb;
        display: inline-block;
        vertical-align: middle;
        margin: 0;
        padding: 0;
        transition: all 0.15s ease;
    }

    .telat-checkbox:hover {
        border-color: #2563eb !important;
    }

    .telat-checkbox:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25);
    }

    /* ─── Table Styles ─── */
    .telat-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-top: 1px solid #e2e8f0;
    }

    .telat-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .telat-table thead {
        background: #f1f5f9;
    }

    .telat-table th {
        background: #f1f5f9;
        color: #334155;
        font-size: 10px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 10px 8px;
        border-bottom: 1.5px solid #cbd5e1;
        white-space: nowrap;
        vertical-align: middle;
    }

    .telat-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 11.5px;
        color: #1e293b;
        vertical-align: middle;
    }

    .telat-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge-telat-time {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-size: 10.5px;
        font-weight: 750;
        padding: 2px 7px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-system-ok {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 10.5px;
        font-weight: 750;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-wa-link {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        font-size: 10.5px;
        font-weight: 750;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.15s ease;
    }

    .badge-wa-link:hover {
        background: #10b981;
        color: #ffffff;
        border-color: #059669;
    }

    /* Action Buttons in Table */
    .telat-act-btn {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }

    .telat-act-wa { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .telat-act-wa:hover { background: #059669; color: #ffffff; }

    .telat-act-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .telat-act-edit:hover { background: #2563eb; color: #ffffff; }

    .telat-act-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .telat-act-delete:hover { background: #dc2626; color: #ffffff; }

    /* Empty State */
    .telat-empty-box {
        padding: 50px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .telat-empty-illustration {
        width: 72px;
        height: 72px;
        border-radius: 24px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 16px;
        position: relative;
    }

    .telat-empty-subbadge {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 28px;
        height: 28px;
        background: #ffffff;
        border: 2px solid #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #10b981;
    }

    .telat-empty-title {
        font-size: 15px;
        font-weight: 750;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .telat-empty-desc {
        font-size: 12.5px;
        color: #64748b;
        margin: 0;
    }

    /* Modal Styling */
    .telat-modal-backdrop {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center;
        z-index: 9999; padding: 20px;
    }
    .telat-modal-card {
        background: #ffffff; border-radius: 18px; width: 100%; max-width: 620px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .telat-modal-header {
        padding: 18px 24px; background: #1e293b; color: #ffffff;
        display: flex; align-items: center; justify-content: space-between;
    }
    .telat-modal-body { padding: 24px; max-height: 80vh; overflow-y: auto; }
    .telat-modal-footer {
        padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-control-custom {
        width: 100%;
        padding: 9px 12px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12.5px;
        color: #0f172a;
        outline: none;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .student-preview-card {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        font-size: 12px;
        margin-bottom: 14px;
    }

    .student-preview-card div span {
        color: #64748b;
        font-weight: 600;
        display: block;
        font-size: 10.5px;
    }

    .student-preview-card div strong {
        color: #0f172a;
        font-weight: 800;
        font-size: 12.5px;
    }

    /* Select2 custom tweak */
    .select2-container--default .select2-selection--single {
        height: 40px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 9px !important;
        padding: 5px 10px !important;
        background: #ffffff !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        font-size: 12.5px !important;
        color: #0f172a !important;
        font-weight: 600 !important;
        padding-left: 0 !important;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        font-size: 12.5px !important;
        z-index: 10000 !important;
    }
</style>
@endsection

@section('content')
<div class="telat-page-container">

    <!-- ─── TOP 3 STAT CARDS (TANPA PANAH / CHEVRON) ─── -->
    <div class="telat-stats-grid">
        <!-- Card 1: Total Telat Hari Ini -->
        <div class="telat-stat-card">
            <div class="telat-stat-left">
                <div class="telat-stat-icon blue">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="telat-stat-info">
                    <span class="telat-stat-title">Total Telat Hari Ini</span>
                    <div class="telat-stat-number-wrap">
                        <span class="telat-stat-number">{{ $totalTelatToday }}</span>
                        <span class="telat-stat-unit">Siswa</span>
                    </div>
                    <span class="telat-stat-sub">Siswa yang datang terlambat hari ini</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Terlambat Bulan Ini -->
        <div class="telat-stat-card">
            <div class="telat-stat-left">
                <div class="telat-stat-icon green">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div class="telat-stat-info">
                    <span class="telat-stat-title">Terlambat Bulan Ini</span>
                    <div class="telat-stat-number-wrap">
                        <span class="telat-stat-number">{{ $totalTelatBulanIni }}</span>
                        <span class="telat-stat-unit">Siswa</span>
                    </div>
                    <span class="telat-stat-sub">Akumulasi keterlambatan bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Data Siswa -->
        <div class="telat-stat-card">
            <div class="telat-stat-left">
                <div class="telat-stat-icon orange">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="telat-stat-info">
                    <span class="telat-stat-title">Total Data Siswa</span>
                    <div class="telat-stat-number-wrap">
                        <span class="telat-stat-number">{{ $siswaList->count() }}</span>
                        <span class="telat-stat-unit">Siswa</span>
                    </div>
                    <span class="telat-stat-sub">Data siswa yang terdaftar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="telat-card" style="border-left: 5px solid #10b981; background: #ecfdf5; margin-bottom: 20px;">
            <div style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 10px; color: #065f46; font-size: 13.5px; font-weight: 750;">
                    <i class="fa-solid fa-circle-check" style="font-size: 20px; color: #10b981;"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @if(session('wa_url'))
                    <a href="{{ session('wa_url') }}" target="_blank" class="badge-wa-link" style="padding: 7px 14px; font-size: 12px;">
                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA Ke {{ session('guru_nama') }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="telat-card" style="border-left: 5px solid #ef4444; background: #fef2f2; margin-bottom: 20px;">
            <div style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #991b1b; font-size: 13.5px; font-weight: 750; margin-bottom: 6px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                    <span>Terdapat Kesalahan Validasi:</span>
                </div>
                <ul style="margin: 0; padding-left: 28px; color: #991b1b; font-size: 12.5px; font-weight: 600;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- ─── DATA TABLE CARD & CONTROLS ─── -->
    <div class="telat-card">
        <!-- Filter & Toolbar Block -->
        <div class="telat-filter-block">
            <!-- Baris 1: Filter Form -->
            <form action="{{ route('piket.siswa-telat') }}" method="GET" class="telat-filter-form">
                <!-- Search Box (flex-1) -->
                <div class="telat-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama Siswa / NISN / Alasan..." class="telat-search-input">
                </div>

                <!-- Dropdown Semua Kelas -->
                <select name="id_kelas" class="telat-filter-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <!-- Date Picker -->
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="telat-filter-date" title="Filter Tanggal">

                <!-- Dropdown Status Keterlambatan -->
                <select name="status_notifikasi" class="telat-filter-select">
                    <option value="">-- Status Keterlambatan --</option>
                    <option value="terkirim" {{ request('status_notifikasi') === 'terkirim' ? 'selected' : '' }}>Pemberitahuan Terkirim</option>
                    <option value="tertunda" {{ request('status_notifikasi') === 'tertunda' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                </select>

                <!-- Action Buttons -->
                <div class="telat-filter-actions">
                    <button type="submit" class="telat-btn-cari">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    <a href="{{ route('piket.siswa-telat') }}" class="telat-btn-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Baris 2: Toolbar Aksi -->
            <div class="telat-action-toolbar">
                <div class="telat-toolbar-left">
                    <div class="telat-bulk-placeholder" id="bulkPlaceholder">
                        <i class="fa-solid fa-circle-info"></i> Pilih data pada tabel untuk opsi tindakan massal
                    </div>
                    <button type="button" id="btnBatchDelete" onclick="confirmBatchDelete()" class="telat-btn-bulk-del" style="display: none;">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <div class="telat-toolbar-right">
                    <button type="button" class="telat-btn-add" onclick="openAddModal()">
                        <i class="fa-solid fa-plus-circle"></i> Catat Siswa Telat
                    </button>
                    @php
                        $trashedCount = \App\Models\SiswaTelat::onlyTrashed()->count();
                    @endphp
                    <a href="{{ route('piket.siswa-telat.trash') }}" class="telat-btn-trash-link" title="Lihat Data Terhapus di Sampah">
                        <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Tersembunyi untuk Batch Delete -->
        <form id="formBatchDelete" action="{{ route('piket.siswa-telat.destroy-batch') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <div id="batchDeleteInputsContainer"></div>
        </form>

        <!-- Table Container -->
        <div class="telat-table-wrapper">
            <table class="telat-table">
                <thead>
                    <tr>
                        <th style="width: 38px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckboxes" class="telat-checkbox" title="Pilih Semua (Select All)">
                        </th>
                        <th style="width: 40px; text-align: center;">NO</th>
                        <th style="min-width: 135px;">WAKTU & TANGGAL</th>
                        <th style="min-width: 180px;">NAMA SISWA</th>
                        <th style="width: 90px;">KELAS</th>
                        <th style="min-width: 170px;">GURU MENGAJAR TARGET</th>
                        <th style="min-width: 180px;">ALASAN / HUKUMAN PIKET</th>
                        <th style="width: 140px; text-align: center;">PEMBERITAHUAN</th>
                        <th style="width: 110px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($telatList as $index => $row)
                        @php
                            $siswaObj = $row->siswa;
                            $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                            $guruObj  = $row->guruMengajar;

                            // Format WA Direct Link
                            $rawHp = preg_replace('/[^0-9]/', '', $guruObj->no_hp ?? '');
                            if (str_starts_with($rawHp, '0')) {
                                $rawHp = '62' . substr($rawHp, 1);
                            }

                            $waTextMsg = "*PEMBERITAHUAN SISWA TERLAMBAT (GURU PIKET)*\n\n"
                                . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Guru *".($guruObj->nama_guru ?? 'Guru')."*,\n\n"
                                . "Memberitahukan bahwa siswa dari kelas Bapak/Ibu terlambat hadir di sekolah:\n"
                                . "• *Nama Siswa*: ".($siswaObj->nama_siswa ?? '-')."\n"
                                . "• *NIS / NISN*: ".($siswaObj->nis ?? '-')." / ".($siswaObj->nisn ?? '-')."\n"
                                . "• *Kelas*: ".($kelasObj->nama_kelas ?? '-')."\n"
                                . "• *Jenis Kelamin*: ".($siswaObj ? $siswaObj->jenis_kelamin_teks : '-')."\n"
                                . "• *Jam Datang*: {$row->jam_terlambat} WIB\n"
                                . "• *Alasan*: {$row->alasan}\n"
                                . "• *Tindakan/Hukuman*: ".($row->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Piket')."\n\n"
                                . "Siswa saat ini telah melapor ke Guru Piket dan diarahkan memasuki kelas. Notifikasi web sistem telah dikirimkan. Mohon Bapak/Ibu Guru Mengajar dapat menyesuaikan presensi siswa di kelas.\n\n"
                                . "Terima kasih.\n- Petugas Piket";

                            $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . urlencode($waTextMsg) : null;
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" value="{{ $row->id_siswa_telat }}" class="item-checkbox telat-checkbox" onchange="updateBatchState()">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $telatList->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    <span style="font-weight: 750; color: #1e293b; font-size: 11.5px;">
                                        <i class="fa-regular fa-calendar-days" style="color: #2563eb; margin-right: 3px;"></i>
                                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                    <div>
                                        <span class="badge-telat-time">
                                            <i class="fa-regular fa-clock"></i> {{ $row->jam_terlambat }} WIB
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 750; color: #0f172a; font-size: 12px;">{{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}</span>
                                    <span style="font-size: 10.5px; color: #64748b; margin-top: 1px;">
                                        NIS: {{ $siswaObj->nis ?? '-' }} / NISN: {{ $siswaObj->nisn ?? '-' }} ({{ $siswaObj ? $siswaObj->jenis_kelamin_teks : '-' }})
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="display: inline-block; background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 6px; font-weight: 700; font-size: 11px; border: 1px solid #e2e8f0;">
                                    {{ $kelasObj->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 750; color: #1e293b; font-size: 11.5px;">
                                        <i class="fa-solid fa-user-tie" style="color: #475569; margin-right: 4px;"></i>
                                        {{ $guruObj->nama_guru ?? 'Guru Tidak Terpilih' }}
                                    </span>
                                    <span style="font-size: 10.5px; color: #64748b;">
                                        Mapel: {{ $guruObj->mapel->nama_mapel ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td style="max-width: 220px;">
                                <div style="color: #334155; font-size: 11px; line-height: 1.4;">
                                    "{{ $row->alasan }}"
                                </div>
                                @if($row->tindakan_hukuman)
                                    <div style="font-size: 10.5px; color: #991b1b; background: #fff1f2; padding: 3px 6px; border-radius: 6px; margin-top: 4px; border: 1px solid #fecdd3;">
                                        <strong>Hukuman:</strong> {{ $row->tindakan_hukuman }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                    <span class="badge-system-ok">
                                        <i class="fa-solid fa-globe"></i> Sistem Web OK
                                    </span>
                                    @if($waDirectUrl)
                                        <a href="{{ $waDirectUrl }}" target="_blank" class="badge-wa-link" title="Kirim WA ke Guru Mengajar">
                                            <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                        </a>
                                    @else
                                        <span style="font-size: 10px; color: #94a3b8;">(No WA Kosong)</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center; align-items: center; flex-wrap: nowrap;">
                                    @if($waDirectUrl)
                                        <a href="{{ $waDirectUrl }}" target="_blank" class="telat-act-btn telat-act-wa" title="Kirim WA">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif

                                    <button type="button" class="telat-act-btn telat-act-edit" onclick='openEditModal(@json($row), @json($siswaObj), @json($kelasObj))' title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('piket.siswa-telat.destroy', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Pindahkan data siswa telat ini ke Sampah?');" style="display: inline; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="telat-act-btn telat-act-delete" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="telat-empty-box">
                                    <div class="telat-empty-illustration">
                                        <i class="fa-regular fa-clipboard"></i>
                                        <div class="telat-empty-subbadge">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                    </div>
                                    <h3 class="telat-empty-title">Belum ada data siswa yang telat hari ini.</h3>
                                    <p class="telat-empty-desc">Saat ada siswa yang datang terlambat, data akan ditampilkan di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: #ffffff;">
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                @if($telatList->total() > 0)
                    Menampilkan {{ $telatList->firstItem() }} - {{ $telatList->lastItem() }} dari {{ $telatList->total() }} data
                @else
                    Menampilkan 0 - 0 dari 0 data
                @endif
            </div>
            <div>
                {{ $telatList->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>

<!-- ─── MODAL TAMBAH SISWA TELAT ─── -->
<div id="addSiswaTelatModal" class="telat-modal-backdrop">
    <div class="telat-modal-card">
        <div class="telat-modal-header">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-clock" style="color: #60a5fa;"></i> Tambah & Kirim Pemberitahuan Siswa Telat
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeAddModal()" style="cursor: pointer; font-size: 18px; color: #94a3b8; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'"></i>
        </div>

        <form action="{{ route('piket.siswa-telat.store') }}" method="POST">
            @csrf
            <div class="telat-modal-body">
                
                <!-- Pilih Siswa -->
                <div class="form-group-custom">
                    <label class="form-label-custom">Pilih Siswa (Data Master TU) <span style="color: #ef4444;">*</span></label>
                    <select name="id_siswa" id="add_id_siswa" class="select2-siswa" style="width: 100%;" required onchange="onSiswaSelected(this.value)">
                        <option value="">-- Cari Nama Siswa / NIS / NISN / Kelas --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_siswa }}">
                                {{ $s->nama_siswa }} — Kelas {{ $s->kelas->nama_kelas ?? '-' }} (NIS: {{ $s->nis ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Preview Identitas Siswa -->
                <div id="studentPreviewContainer" class="student-preview-card" style="display: none;">
                    <div>
                        <span>Nama Lengkap Siswa:</span>
                        <strong id="prev_nama_siswa">-</strong>
                    </div>
                    <div>
                        <span>Kelas Siswa:</span>
                        <strong id="prev_kelas_siswa" style="color: #2563eb;">-</strong>
                    </div>
                    <div>
                        <span>NIS / NISN:</span>
                        <strong id="prev_nis_siswa">-</strong>
                    </div>
                    <div>
                        <span>Jenis Kelamin:</span>
                        <strong id="prev_jk_siswa">-</strong>
                    </div>
                </div>

                <!-- Guru Mengajar Target -->
                <div class="form-group-custom">
                    <label class="form-label-custom">
                        Guru Mengajar di Kelas Saat Ini (Target Pemberitahuan) <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="font-size: 11px; color: #64748b; margin-bottom: 4px;" id="scheduleHelpText">
                        Pemberitahuan akan masuk ke Halaman Pengumuman Guru Mengajar tersebut & pesan WhatsApp.
                    </div>
                    <input type="hidden" name="id_jadwal" id="add_id_jadwal" value="">
                    <select name="id_guru_mengajar" id="add_id_guru_mengajar" class="select2-guru" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="add_tanggal" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" class="form-control-custom" required>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Jam Kedatangan / Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}" class="form-control-custom" placeholder="Contoh: 07:25" required>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Alasan Keterlambatan Siswa <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" rows="2" class="form-control-custom" placeholder="Contoh: Ban sepeda motor bocor di jalan, bangun kesiangan..." required></textarea>
                </div>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Tindakan / Hukuman Piket (Opsional)</label>
                    <textarea name="tindakan_hukuman" rows="2" class="form-control-custom" placeholder="Contoh: Membersihkan halaman sekolah & lari keliling lapangan 2 kali..."></textarea>
                </div>

            </div>

            <div class="telat-modal-footer">
                <button type="button" onclick="closeAddModal()" class="telat-btn-reset">Batal</button>
                <button type="submit" class="telat-btn-cari">
                    <i class="fa-solid fa-paper-plane"></i> Simpan & Kirim Pemberitahuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ─── MODAL EDIT SISWA TELAT ─── -->
<div id="editSiswaTelatModal" class="telat-modal-backdrop">
    <div class="telat-modal-card">
        <div class="telat-modal-header" style="background: #0f172a;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Edit Data Siswa Telat
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeEditModal()" style="cursor: pointer; font-size: 18px; color: #94a3b8; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'"></i>
        </div>

        <form id="editFormSiswaTelat" method="POST">
            @csrf
            @method('PUT')
            <div class="telat-modal-body">
                
                <div class="student-preview-card" style="display: grid;">
                    <div>
                        <span>Nama Siswa:</span>
                        <strong id="edit_nama_siswa">-</strong>
                    </div>
                    <div>
                        <span>Kelas:</span>
                        <strong id="edit_kelas_siswa" style="color: #2563eb;">-</strong>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Guru Mengajar Target <span style="color: #ef4444;">*</span></label>
                    <select name="id_guru_mengajar" id="edit_id_guru_mengajar" class="select2-guru-edit" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control-custom" required>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Jam Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" id="edit_jam_terlambat" class="form-control-custom" required>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Alasan Terlambat <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" id="edit_alasan" rows="2" class="form-control-custom" required></textarea>
                </div>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Tindakan / Hukuman Piket</label>
                    <textarea name="tindakan_hukuman" id="edit_tindakan_hukuman" rows="2" class="form-control-custom"></textarea>
                </div>

            </div>

            <div class="telat-modal-footer">
                <button type="button" onclick="closeEditModal()" class="telat-btn-reset">Batal</button>
                <button type="submit" class="telat-btn-cari" style="background: #f59e0b; border-color: #d97706;">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ─── MODAL KONFIRMASI HAPUS MASSAL ─── -->
<div id="batchDeleteModal" class="telat-modal-backdrop">
    <div class="telat-modal-card" style="max-width: 440px;">
        <div class="telat-modal-header" style="background: #ef4444; color: #ffffff;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeBatchDeleteModal()" style="cursor: pointer; font-size: 18px; color: #fee2e2;"></i>
        </div>
        <div class="telat-modal-body" style="text-align: center; padding: 24px;">
            <div style="width: 54px; height: 54px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 24px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13px; color: #64748b; font-weight: 500; margin: 0 0 20px 0; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBatchCount" style="color: #ef4444;">0</strong> data siswa telat yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeBatchDeleteModal()" class="telat-btn-reset">
                    Batal
                </button>
                <button type="button" onclick="executeBatchDelete()" class="telat-btn-cari" style="background: #ef4444; border-color: #dc2626;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-siswa').select2({
            dropdownParent: $('#addSiswaTelatModal'),
            placeholder: '-- Cari Nama Siswa / NIS / Kelas --',
            width: '100%'
        });

        $('.select2-guru').select2({
            dropdownParent: $('#addSiswaTelatModal'),
            placeholder: '-- Pilih Guru Mengajar (Cari Nama / NIP) --',
            width: '100%'
        });

        $('.select2-guru-edit').select2({
            dropdownParent: $('#editSiswaTelatModal'),
            placeholder: '-- Pilih Guru Mengajar (Cari Nama / NIP) --',
            width: '100%'
        });

        $('#selectAllCheckboxes').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox').prop('checked', isChecked);
            updateBatchState();
        });

        $('#add_tanggal, input[name="jam_terlambat"]').on('change keyup', function() {
            const idSiswa = $('#add_id_siswa').val();
            if (idSiswa) {
                triggerScheduleLookup(idSiswa);
            }
        });

        @if(session('wa_url'))
            // Auto open WhatsApp direct URL link if flash session present
            window.open("{{ session('wa_url') }}", "_blank");
        @endif
    });

    function updateBatchState() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox').length;
        const btn = $('#btnBatchDelete');
        const placeholder = $('#bulkPlaceholder');

        $('#selectedCount').text(count);

        if (totalItems > 0 && count === totalItems) {
            $('#selectAllCheckboxes').prop('checked', true);
        } else {
            $('#selectAllCheckboxes').prop('checked', false);
        }

        if (count > 0) {
            btn.css('display', 'inline-flex');
            placeholder.css('display', 'none');
        } else {
            btn.css('display', 'none');
            placeholder.css('display', 'inline-flex');
        }
    }

    function confirmBatchDelete() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;

        if (count === 0) {
            alert('Silakan pilih minimal satu data siswa telat yang ingin dihapus.');
            return;
        }

        $('#modalBatchCount').text(count);
        document.getElementById('batchDeleteModal').style.display = 'flex';
    }

    function closeBatchDeleteModal() {
        document.getElementById('batchDeleteModal').style.display = 'none';
    }

    function executeBatchDelete() {
        const checkedItems = $('.item-checkbox:checked');
        const container = $('#batchDeleteInputsContainer');
        container.empty();
        checkedItems.each(function() {
            container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
        });
        $('#formBatchDelete').submit();
    }

    function openAddModal() {
        document.getElementById('addSiswaTelatModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addSiswaTelatModal').style.display = 'none';
    }

    function openEditModal(row, siswa, kelas) {
        document.getElementById('editFormSiswaTelat').action = "/guru-piket/siswa-telat/" + row.id_siswa_telat;
        document.getElementById('edit_nama_siswa').innerText = siswa ? siswa.nama_siswa : '-';
        document.getElementById('edit_kelas_siswa').innerText = kelas ? kelas.nama_kelas : '-';
        $('#edit_id_guru_mengajar').val(row.id_guru_mengajar).trigger('change');
        document.getElementById('edit_tanggal').value = row.tanggal ? row.tanggal.substring(0, 10) : '';
        document.getElementById('edit_jam_terlambat').value = row.jam_terlambat;
        document.getElementById('edit_alasan').value = row.alasan;
        document.getElementById('edit_tindakan_hukuman').value = row.tindakan_hukuman || '';
        document.getElementById('editSiswaTelatModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editSiswaTelatModal').style.display = 'none';
    }

    function onSiswaSelected(idSiswa) {
        triggerScheduleLookup(idSiswa);
    }

    // AJAX helper to lookup schedule based on student ID, selected date, and time
    function triggerScheduleLookup(idSiswa) {
        if (!idSiswa) {
            document.getElementById('studentPreviewContainer').style.display = 'none';
            return;
        }

        const tgl = document.getElementById('add_tanggal') ? document.getElementById('add_tanggal').value : '';
        const jam = document.querySelector('#addSiswaTelatModal input[name="jam_terlambat"]') ? document.querySelector('#addSiswaTelatModal input[name="jam_terlambat"]').value : '';

        const url = "/guru-piket/api/siswa-schedule-guru/" + idSiswa + "?tanggal=" + encodeURIComponent(tgl) + "&jam_terlambat=" + encodeURIComponent(jam);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.siswa;
                    const k = data.kelas;
                    const matchedJadwal = data.matched_jadwal;

                    document.getElementById('prev_nama_siswa').innerText = s.nama_siswa || '-';
                    document.getElementById('prev_kelas_siswa').innerText = k ? k.nama_kelas : '-';
                    document.getElementById('prev_nis_siswa').innerText = (s.nis || '-') + " / " + (s.nisn || '-');
                    const jkTeks = s.jenis_kelamin_teks ? s.jenis_kelamin_teks : (s.jenis_kelamin === 'L' ? 'Laki-laki' : (s.jenis_kelamin === 'P' ? 'Perempuan' : '-'));
                    document.getElementById('prev_jk_siswa').innerText = jkTeks;
                    document.getElementById('studentPreviewContainer').style.display = 'grid';

                    // Auto-select Guru Mengajar matched by date and time & set id_jadwal
                    if (data.matched_guru_id) {
                        $('#add_id_guru_mengajar').val(data.matched_guru_id).trigger('change');
                    }

                    if (matchedJadwal && matchedJadwal.id_jadwal) {
                        document.getElementById('add_id_jadwal').value = matchedJadwal.id_jadwal;
                    } else {
                        document.getElementById('add_id_jadwal').value = '';
                    }

                    // Display informative schedule status badge
                    if (matchedJadwal) {
                        const gNama = matchedJadwal.guru ? matchedJadwal.guru.nama_guru : 'Guru';
                        const gNip  = matchedJadwal.guru && matchedJadwal.guru.nip ? matchedJadwal.guru.nip : '-';
                        const mMapel = matchedJadwal.mapel ? matchedJadwal.mapel.nama_mapel : 'Pelajaran';
                        const jRange = matchedJadwal.jam_range_formatted ? matchedJadwal.jam_range_formatted : '';

                        if (data.is_exact_time_match) {
                            document.getElementById('scheduleHelpText').innerHTML = 
                                `<span style="color: #059669; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Jadwal Pelajaran Ditemukan (${data.hari_indo}, Waktu ${data.jam_input} WIB): <strong>${gNama}</strong> (NIP: ${gNip}) — Mapel ${mMapel} [${jRange}]</span>`;
                        } else {
                            document.getElementById('scheduleHelpText').innerHTML = 
                                `<span style="color: #d97706; font-weight: 700;"><i class="fa-solid fa-circle-info"></i> Jadwal Pelajaran (${data.hari_indo}): <strong>${gNama}</strong> (NIP: ${gNip}) — Mapel ${mMapel} [${jRange}]</span>`;
                        }
                    } else {
                        document.getElementById('scheduleHelpText').innerHTML = 
                            `<span style="color: #64748b; font-weight: 600;"><i class="fa-solid fa-circle-exclamation"></i> Tidak ada jadwal pelajaran di kelas siswa pada ${data.hari_indo}. Silakan pilih Guru Mengajar secara manual.</span>`;
                    }
                }
            })
            .catch(err => console.error("Error fetching student schedule:", err));
    }
</script>
@endsection
