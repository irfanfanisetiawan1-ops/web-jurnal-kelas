@extends('layouts.waka')

@section('title', 'Pelanggaran Siswa — Jurnal SMEA')

@section('styles')
<style>
    /* Container */
    .pelanggaran-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-title-box p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin-top: 4px;
    }

    .header-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 9px 18px;
        border-radius: 14px;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .header-date-badge:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .header-date-badge i.cal-icon { color: #64748b; font-size: 15px; }
    .header-date-badge i.chevron-icon { color: #94a3b8; font-size: 11px; }

    /* 4 Stat Cards (Matching Mockup) */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card-item {
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid transparent;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    }

    /* Card 1: Total Pelanggaran */
    .card-stat-total {
        background: #fde8e8;
        border-color: #fee2e2;
    }
    .card-stat-total .stat-circle {
        background: #fca5a5;
        color: #b91c1c;
    }

    /* Card 2: Pelanggaran Ringan */
    .card-stat-ringan {
        background: #ffedd5;
        border-color: #fed7aa;
    }
    .card-stat-ringan .stat-circle {
        background: #fdba74;
        color: #c2410c;
    }

    /* Card 3: Pelanggaran Sedang */
    .card-stat-sedang {
        background: #fef9c3;
        border-color: #fef08a;
    }
    .card-stat-sedang .stat-circle {
        background: #fde047;
        color: #854d0e;
    }

    /* Card 4: Pelanggaran Berat */
    .card-stat-berat {
        background: #ffe4e6;
        border-color: #fecdd3;
    }
    .card-stat-berat .stat-circle {
        background: #fda4af;
        color: #be123c;
    }

    .stat-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-info .stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    .stat-info .stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin: 2px 0 3px;
    }

    .stat-info .stat-desc {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    /* Filter Bar */
    .filter-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 14px 18px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
    }

    .filter-form-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .search-input-wrap {
        position: relative;
        flex: 1 1 280px;
        min-width: 220px;
    }

    .search-input-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-wrap input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13.5px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .search-input-wrap input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-date-input,
    .filter-select {
        padding: 10px 14px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-date-input:focus,
    .filter-select:focus {
        background: #ffffff;
        border-color: #2563eb;
    }

    .btn-action-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-create-pelanggaran {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .btn-create-pelanggaran:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-trash-view {
        background: #ea580c;
        color: #ffffff;
    }
    .btn-trash-view:hover {
        background: #c2410c;
    }

    .btn-batch-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1.5px solid #fca5a5;
        animation: pulse 1.5s infinite;
    }
    .btn-batch-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .btn-export-pill {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-export-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-print-pill {
        background: #f8fafc;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-print-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-reset-filter {
        background: #f1f5f9;
        color: #64748b;
        padding: 10px 12px;
    }
    .btn-reset-filter:hover { background: #e2e8f0; color: #334155; }

    /* Table Container */
    .table-container-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .table-responsive-box {
        width: 100%;
        overflow-x: auto;
    }

    .pelanggaran-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .pelanggaran-table thead tr {
        background: #f1f5f9;
    }

    .pelanggaran-table thead th {
        padding: 14px 16px;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        border: none;
    }

    .pelanggaran-table thead th.text-center,
    .pelanggaran-table tbody td.text-center {
        text-align: center;
    }

    .pelanggaran-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }

    .pelanggaran-table tbody tr:hover {
        background: #f8fafc;
    }

    .pelanggaran-table tbody td {
        padding: 15px 16px;
        font-size: 14px;
        color: #1e293b;
        vertical-align: middle;
    }

    .student-name-text {
        font-weight: 700;
        color: #0f172a;
        font-size: 14px;
    }

    .student-nis-sub {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .class-badge {
        font-weight: 700;
        color: #334155;
    }

    .badge-kategori-ringan {
        background: #ffedd5;
        color: #c2410c;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 4px;
    }

    .badge-kategori-sedang {
        background: #fef9c3;
        color: #854d0e;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 4px;
    }

    .badge-kategori-berat {
        background: #fee2e2;
        color: #991b1b;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 4px;
    }

    /* Action Buttons in Table */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        border: none;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-view-detail {
        background: #eff6ff;
        color: #2563eb;
    }
    .btn-view-detail:hover { background: #2563eb; color: #ffffff; }

    .btn-edit-item {
        background: #fef3c7;
        color: #d97706;
    }
    .btn-edit-item:hover { background: #d97706; color: #ffffff; }

    .btn-wa-notify {
        background: #dcfce7;
        color: #16a34a;
    }
    .btn-wa-notify:hover { background: #16a34a; color: #ffffff; }

    .btn-delete-item {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-delete-item:hover { background: #dc2626; color: #ffffff; }

    /* Modals */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-backdrop.show {
        display: flex;
    }

    .modal-dialog {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalSlideUp 0.25s ease-out;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    @keyframes modalSlideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 18px 24px;
        border-bottom: 1.5px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .modal-close {
        background: transparent;
        border: none;
        font-size: 20px;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        line-height: 1;
        transition: color 0.15s;
    }
    .modal-close:hover { color: #0f172a; }

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
        gap: 10px;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
        position: relative;
    }

    .form-group-custom label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #0f172a;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }
    .form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
    }

    /* Searchable Custom Select Component */
    .searchable-select-wrap {
        position: relative;
        width: 100%;
    }

    .searchable-select-trigger {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #0f172a;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        user-select: none;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .searchable-select-trigger:hover,
    .searchable-select-wrap.active .searchable-select-trigger {
        background: #ffffff;
        border-color: #2563eb;
    }

    .searchable-select-trigger .trigger-text {
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .searchable-select-trigger .trigger-text.placeholder {
        color: #64748b;
        font-weight: 500;
    }

    .searchable-select-trigger .trigger-chevron {
        font-size: 12px;
        color: #94a3b8;
        transition: transform 0.2s ease;
        margin-left: 8px;
    }

    .searchable-select-wrap.active .searchable-select-trigger .trigger-chevron {
        transform: rotate(180deg);
        color: #2563eb;
    }

    .searchable-select-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        z-index: 1050;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: dropFade 0.15s ease-out;
    }

    @keyframes dropFade {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .searchable-select-wrap.active .searchable-select-dropdown {
        display: flex;
    }

    .searchable-search-box {
        padding: 10px 12px;
        border-bottom: 1px solid #e2e8f0;
        position: relative;
        background: #f8fafc;
    }

    .searchable-search-box i {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .searchable-search-box input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        outline: none;
        background: #ffffff;
        box-sizing: border-box;
    }

    .searchable-search-box input:focus {
        border-color: #2563eb;
    }

    .searchable-options-list {
        max-height: 220px;
        overflow-y: auto;
        padding: 6px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .searchable-option-item {
        padding: 9px 12px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background 0.15s ease;
    }

    .searchable-option-item:hover,
    .searchable-option-item.selected {
        background: #eff6ff;
    }

    .searchable-option-item .opt-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #dbeafe;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .searchable-option-item .opt-content {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .searchable-option-item .opt-name {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .searchable-option-item .opt-details {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
    }

    .searchable-empty-msg {
        padding: 16px;
        text-align: center;
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
        display: none;
    }

    .detail-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 14px;
    }

    .detail-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .detail-item-box .label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }

    .detail-item-box .val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }

    /* Checkbox Styles */
    .custom-checkbox {
        width: 17px;
        height: 17px;
        cursor: pointer;
        accent-color: #2563eb;
        border-radius: 4px;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .filter-form-row { flex-direction: column; align-items: stretch; }
        .detail-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="pelanggaran-container">

    <!-- Flash Alerts -->
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

    <!-- Header Row -->
    <div class="page-header-row">
        <div class="page-title-box">
            <h1>Pelanggaran Siswa</h1>
            <p>Kelola data pelanggaran siswa, jenis pelanggaran, dan sanksi yang diberikan.</p>
        </div>

        <form action="{{ route('waka.pelanggaran-siswa') }}" method="GET" id="dateSelectorForm">
            @if(request('id_kelas')) <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}"> @endif
            @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

            <label class="header-date-badge" for="headerDateInput" title="Klik untuk memfilter tanggal">
                <i class="fa-regular fa-calendar cal-icon"></i>
                <span>{{ $formattedDateIndo }}</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
                <input type="date" id="headerDateInput" name="tanggal" value="{{ $tanggal }}" style="position:absolute; opacity:0; width:0; height:0;" onchange="document.getElementById('dateSelectorForm').submit();">
            </label>
        </form>
    </div>

    <!-- 4 Top Stat Cards (According to User Mockup) -->
    <div class="stat-cards-grid">
        <!-- 1. Total Pelanggaran -->
        <a href="{{ route('waka.pelanggaran-siswa', array_merge(request()->except('kategori', 'page'), ['kategori' => 'all'])) }}" class="stat-card-item card-stat-total" title="Semua Pelanggaran">
            <div class="stat-circle">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Pelanggaran</span>
                <span class="stat-number">{{ number_format($totalPelanggaran, 0, ',', '.') }}</span>
                <span class="stat-desc">dalam 7 hari terakhir</span>
            </div>
        </a>

        <!-- 2. Pelanggaran Ringan -->
        <a href="{{ route('waka.pelanggaran-siswa', array_merge(request()->except('kategori', 'page'), ['kategori' => 'Ringan'])) }}" class="stat-card-item card-stat-ringan" title="Filter Pelanggaran Ringan">
            <div class="stat-circle">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pelanggaran Ringan</span>
                <span class="stat-number">{{ number_format($countRingan, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #ea580c;">{{ $pctRingan }}% dari total</span>
            </div>
        </a>

        <!-- 3. Pelanggaran Sedang -->
        <a href="{{ route('waka.pelanggaran-siswa', array_merge(request()->except('kategori', 'page'), ['kategori' => 'Sedang'])) }}" class="stat-card-item card-stat-sedang" title="Filter Pelanggaran Sedang">
            <div class="stat-circle">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pelanggaran Sedang</span>
                <span class="stat-number">{{ number_format($countSedang, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #a16207;">{{ $pctSedang }}% dari total</span>
            </div>
        </a>

        <!-- 4. Pelanggaran Berat -->
        <a href="{{ route('waka.pelanggaran-siswa', array_merge(request()->except('kategori', 'page'), ['kategori' => 'Berat'])) }}" class="stat-card-item card-stat-berat" title="Filter Pelanggaran Berat">
            <div class="stat-circle">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pelanggaran Berat</span>
                <span class="stat-number">{{ number_format($countBerat, 0, ',', '.') }}</span>
                <span class="stat-desc" style="color: #e11d48;">{{ $pctBerat }}% dari total</span>
            </div>
        </a>
    </div>

    <!-- Filter Bar Card -->
    <div class="filter-card">
        <form action="{{ route('waka.pelanggaran-siswa') }}" method="GET" class="filter-form-row">
            <!-- Search -->
            <div class="search-input-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / jenis pelanggaran / tingkat...">
            </div>

            <!-- Tanggal Filter -->
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="filter-date-input" title="Filter Tanggal" onchange="this.form.submit()">

            <!-- Kategori / Jenis Pelanggaran Filter -->
            <select name="kategori" class="filter-select" onchange="this.form.submit()">
                <option value="">Jenis Pelanggaran</option>
                <option value="Ringan" {{ request('kategori') == 'Ringan' ? 'selected' : '' }}>Pelanggaran Ringan</option>
                <option value="Sedang" {{ request('kategori') == 'Sedang' ? 'selected' : '' }}>Pelanggaran Sedang</option>
                <option value="Berat" {{ request('kategori') == 'Berat' ? 'selected' : '' }}>Pelanggaran Berat</option>
            </select>

            <button type="button" class="btn-action-pill btn-create-pelanggaran" onclick="openModalTambahPelanggaran()">
                <i class="fa-solid fa-plus"></i>
                <span>Catat Pelanggaran</span>
            </button>

            <!-- Tombol Hapus Terpilih (Batch Delete) -->
            <button type="button" id="btnHapusTerpilih" class="btn-action-pill btn-batch-delete" style="display: none;" onclick="submitBatchDeletePelanggaran()">
                <i class="fa-solid fa-trash-can"></i>
                <span>Hapus Terpilih (<strong id="selectedCountText">0</strong>)</span>
            </button>

            @if(request()->hasAny(['q', 'tanggal', 'kategori', 'id_kelas']))
                <a href="{{ route('waka.pelanggaran-siswa') }}" class="btn-action-pill btn-reset-filter" title="Reset filter">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            @endif

            <a href="{{ route('waka.pelanggaran-siswa.trash') }}" class="btn-action-pill btn-trash-view" title="Kotak Sampah Pelanggaran">
                <i class="fa-solid fa-trash-can"></i>
                <span>Sampah ({{ $trashedCount }})</span>
            </a>

            <!-- Export Buttons -->
            <div style="display: flex; gap: 8px; margin-left: auto;">
                <a href="{{ route('waka.pelanggaran-siswa.export', request()->all()) }}" class="btn-action-pill btn-export-pill" title="Ekspor CSV">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    <span>Export</span>
                </a>
                <a href="{{ route('waka.pelanggaran-siswa.print', request()->all()) }}" target="_blank" class="btn-action-pill btn-print-pill" title="Cetak PDF">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Hidden Form for Batch Delete -->
    <form id="formBatchDeletePelanggaran" action="{{ route('waka.pelanggaran-siswa.batch-delete') }}" method="POST" style="display: none;">
        @csrf
        <div id="batchDeleteInputs"></div>
    </form>

    <!-- Table Card -->
    <div class="table-container-card">
        <div class="table-responsive-box">
            <table class="pelanggaran-table">
                <thead>
                    <tr>
                        <th style="width: 42px; text-align: center;">
                            <input type="checkbox" id="checkAllPelanggaran" class="custom-checkbox" title="Pilih Semua" onchange="toggleSelectAllPelanggaran(this)">
                        </th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggarans as $p)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="pelanggaran-row-checkbox custom-checkbox" value="{{ $p->id_pelanggaran }}" onchange="updateBatchDeleteState()">
                            </td>
                            <td>
                                <div class="student-name-text">{{ $p->siswa->nama_siswa ?? '-' }}</div>
                                <div class="student-nis-sub">NIS: {{ $p->siswa->nis ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="class-badge">{{ $p->kelas->nama_kelas ?? ($p->siswa->kelas->nama_kelas ?? '-') }}</span>
                            </td>
                            <td>
                                @if($p->kategori_pelanggaran === 'Ringan')
                                    <span class="badge-kategori-ringan">Ringan</span>
                                @elseif($p->kategori_pelanggaran === 'Sedang')
                                    <span class="badge-kategori-sedang">Sedang</span>
                                @else
                                    <span class="badge-kategori-berat">Berat</span>
                                @endif
                                <strong style="color: #0f172a;">{{ $p->jenis_pelanggaran }}</strong>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM Y') : '-' }}</span>
                            </td>
                            <td>
                                <span style="color: #475569;">{{ $p->alasan ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-icon btn-view-detail" onclick="openModalDetailPelanggaran({{ $p->id_pelanggaran }})" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-action-icon btn-edit-item" onclick="openModalEditPelanggaran({{ $p->id_pelanggaran }})" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="btn-action-icon btn-wa-notify" onclick="kirimWaPelanggaran({{ $p->id_pelanggaran }})" title="Kirim Notifikasi WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </button>
                                    <form action="{{ route('waka.pelanggaran-siswa.destroy', $p->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Pindahkan data pelanggaran ini ke kotak sampah?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-delete-item" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <div style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1;"><i class="fa-solid fa-shield-halved"></i></div>
                                <h4 style="font-size: 16px; font-weight: 800; color: #475569; margin: 0 0 6px 0;">Tidak Ada Data Pelanggaran Siswa</h4>
                                <p style="font-size: 13px; margin: 0;">Seluruh siswa mematuhi tata tertib atau tidak ada data yang cocok dengan filter yang dipilih.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div style="padding: 16px 20px; background: #ffffff; border-top: 1px solid #f1f5f9;">
            {{ $pelanggarans->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL TAMBAH PELANGGARAN SISWA (WITH SEARCHABLE STUDENT SELECT) -->
<!-- ========================================================================= -->
<div class="modal-backdrop" id="modalTambahPelanggaran">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-triangle-exclamation" style="color: #ef4444;"></i> Catat Pelanggaran Siswa
            </h3>
            <button type="button" class="modal-close" onclick="closeModalTambahPelanggaran()">&times;</button>
        </div>
        <form action="{{ route('waka.pelanggaran-siswa.store') }}" method="POST" enctype="multipart/form-data" id="formTambahPelanggaran">
            @csrf
            <div class="modal-body">
                <!-- Searchable Student Select Component -->
                <div class="form-group-custom">
                    <label>Pilih Siswa Pelanggar <span style="color:#ef4444;">*</span></label>
                    <div class="searchable-select-wrap" id="searchableSelectTambah">
                        <div class="searchable-select-trigger" onclick="toggleSearchableSelect('searchableSelectTambah')">
                            <span class="trigger-text placeholder" id="selectedStudentTextTambah">-- Cari dan Pilih Siswa --</span>
                            <i class="fa-solid fa-chevron-down trigger-chevron"></i>
                        </div>
                        <div class="searchable-select-dropdown">
                            <div class="searchable-search-box">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" id="searchInputTambah" placeholder="Ketik nama / NIS / kelas siswa..." oninput="filterSearchableOptions('searchableSelectTambah', this.value)" autocomplete="off">
                            </div>
                            <div class="searchable-options-list" id="optionsListTambah">
                                @foreach($siswaList as $s)
                                    <div class="searchable-option-item" 
                                         data-id="{{ $s->id_siswa }}" 
                                         data-name="{{ strtolower($s->nama_siswa) }}" 
                                         data-nis="{{ $s->nis }}" 
                                         data-kelas="{{ strtolower($s->kelas->nama_kelas ?? '') }}"
                                         onclick="selectStudent('searchableSelectTambah', '{{ $s->id_siswa }}', '{{ addslashes($s->nama_siswa) }}', '{{ $s->nis }}', '{{ addslashes($s->kelas->nama_kelas ?? '-') }}', 'hidden_id_siswa_tambah', 'selectedStudentTextTambah')">
                                        <div class="opt-avatar"><i class="fa-solid fa-user-graduate"></i></div>
                                        <div class="opt-content">
                                            <div class="opt-name">{{ $s->nama_siswa }}</div>
                                            <div class="opt-details">NIS: {{ $s->nis }} &bull; {{ $s->kelas->nama_kelas ?? '-' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="searchable-empty-msg" id="emptyMsgTambah">
                                <i class="fa-solid fa-circle-question"></i> Tidak ada siswa yang sesuai
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_siswa" id="hidden_id_siswa_tambah" required>
                </div>

                <div class="detail-grid-2">
                    <div class="form-group-custom">
                        <label>Kategori Pelanggaran <span style="color:#ef4444;">*</span></label>
                        <select name="kategori_pelanggaran" class="form-control-custom" id="kategoriTambahSelect" onchange="autoFillPoinDefault('Tambah')" required>
                            <option value="Ringan">Pelanggaran Ringan</option>
                            <option value="Sedang">Pelanggaran Sedang</option>
                            <option value="Berat">Pelanggaran Berat</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label>Poin Pelanggaran</label>
                        <input type="number" name="poin_pelanggaran" id="poinTambahInput" value="5" min="1" max="100" class="form-control-custom">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label>Jenis Pelanggaran <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="jenis_pelanggaran" placeholder="Contoh: Terlambat Masuk Sekolah, Atribut Tidak Lengkap, Merokok..." class="form-control-custom" required>
                </div>

                <div class="detail-grid-2">
                    <div class="form-group-custom">
                        <label>Tanggal Kejadian <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control-custom" required>
                    </div>

                    <div class="form-group-custom">
                        <label>Waktu / Jam</label>
                        <input type="text" name="jam" value="{{ date('H.i') }} WIB" class="form-control-custom">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label>Alasan Siswa</label>
                    <textarea name="alasan" rows="2" placeholder="Alasan yang disampaikan siswa..." class="form-control-custom"></textarea>
                </div>

                <div class="form-group-custom">
                    <label>Tindakan / Sanksi / Hukuman yang Diberikan</label>
                    <textarea name="tindakan_sanksi" rows="2" placeholder="Tindakan atau sanksi pembinaan..." class="form-control-custom"></textarea>
                </div>

                <div class="form-group-custom">
                    <label>Foto Bukti Pelanggaran (Opsional)</label>
                    <input type="file" name="foto_bukti" accept="image/*,.pdf" class="form-control-custom">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action-pill" style="background:#e2e8f0; color:#334155;" onclick="closeModalTambahPelanggaran()">Batal</button>
                <button type="submit" class="btn-action-pill btn-create-pelanggaran">Simpan Pelanggaran</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL PELANGGARAN SISWA -->
<!-- ========================================================================= -->
<div class="modal-backdrop" id="modalDetailPelanggaran">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Pelanggaran Siswa
            </h3>
            <button type="button" class="modal-close" onclick="closeModalDetailPelanggaran()">&times;</button>
        </div>
        <div class="modal-body" id="modalDetailPelanggaranBody">
            <!-- Loaded via AJAX -->
            <div style="text-align:center; padding: 40px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-weight: 600;">Memuat detail pelanggaran...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action-pill" style="background:#e2e8f0; color:#334155;" onclick="closeModalDetailPelanggaran()">Tutup</button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL EDIT PELANGGARAN SISWA -->
<!-- ========================================================================= -->
<div class="modal-backdrop" id="modalEditPelanggaran">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-pen-to-square" style="color: #d97706;"></i> Edit Pelanggaran Siswa
            </h3>
            <button type="button" class="modal-close" onclick="closeModalEditPelanggaran()">&times;</button>
        </div>
        <form id="formEditPelanggaran" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body" id="modalEditPelanggaranBody">
                <!-- Loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action-pill" style="background:#e2e8f0; color:#334155;" onclick="closeModalEditPelanggaran()">Batal</button>
                <button type="submit" class="btn-action-pill" style="background:#d97706; color:#ffffff;">Perbarui Pelanggaran</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // =========================================================================
    // SEARCHABLE SELECT LOGIC
    // =========================================================================
    function toggleSearchableSelect(wrapId) {
        const wrap = document.getElementById(wrapId);
        const isActive = wrap.classList.contains('active');
        
        // Close other searchable dropdowns
        document.querySelectorAll('.searchable-select-wrap').forEach(el => el.classList.remove('active'));
        
        if (!isActive) {
            wrap.classList.add('active');
            const searchInput = wrap.querySelector('.searchable-search-box input');
            if (searchInput) {
                setTimeout(() => searchInput.focus(), 50);
            }
        }
    }

    function filterSearchableOptions(wrapId, query) {
        const wrap = document.getElementById(wrapId);
        const options = wrap.querySelectorAll('.searchable-option-item');
        const emptyMsg = wrap.querySelector('.searchable-empty-msg');
        const q = query.toLowerCase().trim();
        let matchCount = 0;

        options.forEach(opt => {
            const name = opt.getAttribute('data-name') || '';
            const nis = opt.getAttribute('data-nis') || '';
            const kelas = opt.getAttribute('data-kelas') || '';

            if (name.includes(q) || nis.includes(q) || kelas.includes(q)) {
                opt.style.display = 'flex';
                matchCount++;
            } else {
                opt.style.display = 'none';
            }
        });

        if (emptyMsg) {
            emptyMsg.style.display = matchCount === 0 ? 'block' : 'none';
        }
    }

    function selectStudent(wrapId, id, name, nis, kelas, hiddenInputId, labelId) {
        document.getElementById(hiddenInputId).value = id;
        const labelEl = document.getElementById(labelId);
        labelEl.textContent = `${name} (NIS: ${nis} • ${kelas})`;
        labelEl.classList.remove('placeholder');

        const wrap = document.getElementById(wrapId);
        wrap.querySelectorAll('.searchable-option-item').forEach(opt => {
            if (opt.getAttribute('data-id') == id) {
                opt.classList.add('selected');
            } else {
                opt.classList.remove('selected');
            }
        });
        wrap.classList.remove('active');
    }

    function autoFillPoinDefault(prefix) {
        const kat = document.getElementById(`kategori${prefix}Select`).value;
        const poinInput = document.getElementById(`poin${prefix}Input`);
        if (kat === 'Ringan') poinInput.value = 5;
        else if (kat === 'Sedang') poinInput.value = 15;
        else if (kat === 'Berat') poinInput.value = 25;
    }

    // =========================================================================
    // BATCH DELETE / HAPUS TERPILIH
    // =========================================================================
    function toggleSelectAllPelanggaran(mainCheckbox) {
        const rowCheckboxes = document.querySelectorAll('.pelanggaran-row-checkbox');
        rowCheckboxes.forEach(cb => {
            cb.checked = mainCheckbox.checked;
        });
        updateBatchDeleteState();
    }

    function updateBatchDeleteState() {
        const rowCheckboxes = document.querySelectorAll('.pelanggaran-row-checkbox');
        const selectedCheckboxes = document.querySelectorAll('.pelanggaran-row-checkbox:checked');
        const mainCheckbox = document.getElementById('checkAllPelanggaran');
        const btnBatch = document.getElementById('btnHapusTerpilih');
        const countText = document.getElementById('selectedCountText');

        const count = selectedCheckboxes.length;
        countText.textContent = count;

        if (count > 0) {
            btnBatch.style.display = 'inline-flex';
        } else {
            btnBatch.style.display = 'none';
        }

        if (rowCheckboxes.length > 0 && selectedCheckboxes.length === rowCheckboxes.length) {
            mainCheckbox.checked = true;
            mainCheckbox.indeterminate = false;
        } else if (selectedCheckboxes.length > 0) {
            mainCheckbox.checked = false;
            mainCheckbox.indeterminate = true;
        } else {
            mainCheckbox.checked = false;
            mainCheckbox.indeterminate = false;
        }
    }

    function submitBatchDeletePelanggaran() {
        const selectedCheckboxes = document.querySelectorAll('.pelanggaran-row-checkbox:checked');
        const count = selectedCheckboxes.length;
        if (count === 0) {
            alert('Silakan pilih minimal satu data pelanggaran yang ingin dihapus.');
            return;
        }

        if (!confirm(`Konfirmasi: Pindahkan ${count} data pelanggaran siswa yang dipilih ke kotak sampah?`)) {
            return;
        }

        const container = document.getElementById('batchDeleteInputs');
        container.innerHTML = '';
        selectedCheckboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('formBatchDeletePelanggaran').submit();
    }

    // =========================================================================
    // MODAL TAMBAH PELANGGARAN
    // =========================================================================
    function openModalTambahPelanggaran() {
        document.getElementById('modalTambahPelanggaran').classList.add('show');
    }

    function closeModalTambahPelanggaran() {
        document.getElementById('modalTambahPelanggaran').classList.remove('show');
    }

    // =========================================================================
    // MODAL DETAIL PELANGGARAN
    // =========================================================================
    function openModalDetailPelanggaran(id) {
        const modal = document.getElementById('modalDetailPelanggaran');
        const body = document.getElementById('modalDetailPelanggaranBody');
        modal.classList.add('show');
        body.innerHTML = `
            <div style="text-align:center; padding: 40px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-weight: 600;">Memuat detail pelanggaran...</p>
            </div>
        `;

        fetch(`{{ url('/waka/pelanggaran-siswa/detail-json') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    body.innerHTML = `<div style="color:#ef4444; padding:20px; text-align:center;">${res.message || 'Gagal memuat detail data.'}</div>`;
                    return;
                }
                const d = res.data;
                const s = d.siswa;
                const sum = d.summary_siswa;

                let katBadge = `<span class="badge-kategori-ringan">Ringan</span>`;
                if (d.kategori_pelanggaran === 'Sedang') {
                    katBadge = `<span class="badge-kategori-sedang">Sedang</span>`;
                } else if (d.kategori_pelanggaran === 'Berat') {
                    katBadge = `<span class="badge-kategori-berat">Berat</span>`;
                }

                body.innerHTML = `
                    <div class="detail-section-card" style="display:flex; align-items:center; gap:16px;">
                        <div style="width:54px; height:54px; border-radius:50%; background:#dbeafe; color:#1d4ed8; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div style="flex:1;">
                            <h4 style="margin:0; font-size:16px; font-weight:800; color:#0f172a;">${s.nama_siswa}</h4>
                            <div style="font-size:12.5px; color:#64748b; font-weight:600; margin-top:2px;">
                                NIS: ${s.nis} &bull; Kelas: <strong>${s.kelas}</strong>
                            </div>
                            <div style="font-size:12px; color:#475569; margin-top:3px;">
                                Jurusan: ${s.jurusan}
                            </div>
                        </div>
                    </div>

                    <div class="detail-section-card">
                        <div class="detail-grid-2">
                            <div class="detail-item-box">
                                <span class="label">Kategori</span>
                                <div class="val">${katBadge} (${d.poin_pelanggaran} Poin)</div>
                            </div>
                            <div class="detail-item-box">
                                <span class="label">Jenis Pelanggaran</span>
                                <span class="val">${d.jenis_pelanggaran}</span>
                            </div>
                        </div>
                        <div class="detail-item-box" style="margin-top: 10px;">
                            <span class="label">Tanggal & Waktu</span>
                            <span class="val">${d.tanggal}, ${d.jam}</span>
                        </div>
                        <div style="margin-top: 10px;">
                            <div class="detail-item-box" style="margin-bottom: 8px;">
                                <span class="label">Alasan Pelanggaran</span>
                                <span class="val" style="font-weight:500;">${d.alasan}</span>
                            </div>
                            <div class="detail-item-box">
                                <span class="label">Tindakan / Sanksi</span>
                                <span class="val" style="font-weight:600; color:#1e293b;">${d.tindakan_sanksi}</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section-card" style="margin-bottom:0; text-align:center;">
                        <span style="font-size: 12px; font-weight: 700; color: #64748b;">Akumulasi Pelanggaran Siswa Ini:</span>
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                            ${sum.total_pelanggaran} Kali Pelanggaran • Total ${sum.total_poin} Poin
                        </div>
                    </div>
                `;
            })
            .catch(err => {
                body.innerHTML = `<div style="color:#ef4444; padding:20px; text-align:center;">Terjadi kesalahan saat memuat data.</div>`;
            });
    }

    function closeModalDetailPelanggaran() {
        document.getElementById('modalDetailPelanggaran').classList.remove('show');
    }

    // =========================================================================
    // MODAL EDIT PELANGGARAN (WITH SEARCHABLE STUDENT SELECT IN EDIT)
    // =========================================================================
    function openModalEditPelanggaran(id) {
        const modal = document.getElementById('modalEditPelanggaran');
        const form = document.getElementById('formEditPelanggaran');
        const body = document.getElementById('modalEditPelanggaranBody');
        form.action = `{{ url('/waka/pelanggaran-siswa') }}/${id}`;
        modal.classList.add('show');
        body.innerHTML = `
            <div style="text-align:center; padding: 30px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-weight: 600;">Memuat form edit...</p>
            </div>
        `;

        fetch(`{{ url('/waka/pelanggaran-siswa/detail-json') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    body.innerHTML = `<div style="color:#ef4444; padding:20px; text-align:center;">${res.message || 'Gagal memuat form edit.'}</div>`;
                    return;
                }
                const d = res.data;
                const s = d.siswa;

                body.innerHTML = `
                    <div class="form-group-custom">
                        <label>Siswa Pelanggar</label>
                        <div class="searchable-select-wrap" id="searchableSelectEdit">
                            <div class="searchable-select-trigger" onclick="toggleSearchableSelect('searchableSelectEdit')">
                                <span class="trigger-text" id="selectedStudentTextEdit">${s.nama_siswa} (NIS: ${s.nis} • ${s.kelas})</span>
                                <i class="fa-solid fa-chevron-down trigger-chevron"></i>
                            </div>
                            <div class="searchable-select-dropdown">
                                <div class="searchable-search-box">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" id="searchInputEdit" placeholder="Ketik nama / NIS / kelas..." oninput="filterSearchableOptions('searchableSelectEdit', this.value)" autocomplete="off">
                                </div>
                                <div class="searchable-options-list" id="optionsListEdit">
                                    @foreach($siswaList as $sItem)
                                        <div class="searchable-option-item ${s.id_siswa == {{ $sItem->id_siswa }} ? 'selected' : ''}" 
                                             data-id="{{ $sItem->id_siswa }}" 
                                             data-name="{{ strtolower($sItem->nama_siswa) }}" 
                                             data-nis="{{ $sItem->nis }}" 
                                             data-kelas="{{ strtolower($sItem->kelas->nama_kelas ?? '') }}"
                                             onclick="selectStudent('searchableSelectEdit', '{{ $sItem->id_siswa }}', '{{ addslashes($sItem->nama_siswa) }}', '{{ $sItem->nis }}', '{{ addslashes($sItem->kelas->nama_kelas ?? '-') }}', 'hidden_id_siswa_edit', 'selectedStudentTextEdit')">
                                            <div class="opt-avatar"><i class="fa-solid fa-user-graduate"></i></div>
                                            <div class="opt-content">
                                                <div class="opt-name">{{ $sItem->nama_siswa }}</div>
                                                <div class="opt-details">NIS: {{ $sItem->nis }} &bull; {{ $sItem->kelas->nama_kelas ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="searchable-empty-msg">
                                    <i class="fa-solid fa-circle-question"></i> Tidak ada siswa yang sesuai
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_siswa" id="hidden_id_siswa_edit" value="${s.id_siswa}">
                    </div>

                    <div class="detail-grid-2">
                        <div class="form-group-custom">
                            <label>Kategori Pelanggaran <span style="color:#ef4444;">*</span></label>
                            <select name="kategori_pelanggaran" class="form-control-custom" id="kategoriEditSelect" onchange="autoFillPoinDefault('Edit')" required>
                                <option value="Ringan" ${d.kategori_pelanggaran === 'Ringan' ? 'selected' : ''}>Pelanggaran Ringan</option>
                                <option value="Sedang" ${d.kategori_pelanggaran === 'Sedang' ? 'selected' : ''}>Pelanggaran Sedang</option>
                                <option value="Berat" ${d.kategori_pelanggaran === 'Berat' ? 'selected' : ''}>Pelanggaran Berat</option>
                            </select>
                        </div>

                        <div class="form-group-custom">
                            <label>Poin Pelanggaran</label>
                            <input type="number" name="poin_pelanggaran" id="poinEditInput" value="${d.poin_pelanggaran}" min="1" max="100" class="form-control-custom">
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Jenis Pelanggaran <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="jenis_pelanggaran" value="${d.jenis_pelanggaran}" class="form-control-custom" required>
                    </div>

                    <div class="detail-grid-2">
                        <div class="form-group-custom">
                            <label>Tanggal Kejadian <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="tanggal" value="${d.tanggal_raw}" class="form-control-custom" required>
                        </div>

                        <div class="form-group-custom">
                            <label>Waktu / Jam</label>
                            <input type="text" name="jam" value="${d.jam}" class="form-control-custom">
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Alasan Siswa</label>
                        <textarea name="alasan" rows="2" class="form-control-custom">${d.alasan}</textarea>
                    </div>

                    <div class="form-group-custom">
                        <label>Tindakan / Sanksi / Hukuman</label>
                        <textarea name="tindakan_sanksi" rows="2" class="form-control-custom">${d.tindakan_sanksi}</textarea>
                    </div>

                    <div class="form-group-custom">
                        <label>Ganti Foto Bukti (Opsional)</label>
                        <input type="file" name="foto_bukti" accept="image/*,.pdf" class="form-control-custom">
                    </div>
                `;
            })
            .catch(err => {
                body.innerHTML = `<div style="color:#ef4444; padding:20px; text-align:center;">Terjadi kesalahan saat memuat form edit.</div>`;
            });
    }

    function closeModalEditPelanggaran() {
        document.getElementById('modalEditPelanggaran').classList.remove('show');
    }

    // =========================================================================
    // KIRIM WA NOTIFIKASI
    // =========================================================================
    function kirimWaPelanggaran(id) {
        if (!confirm('Kirim notifikasi pelanggaran siswa ini via WhatsApp ke nomor orang tua / wali murid?')) {
            return;
        }

        fetch(`{{ url('/waka/pelanggaran-siswa') }}/${id}/kirim-wa`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.wa_url) {
                window.open(res.wa_url, '_blank');
            } else {
                alert(res.message || 'Berhasil memperbarui status.');
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan saat menghubungi server WhatsApp.');
        });
    }

    // =========================================================================
    // GLOBAL CLICK LISTENER (CLOSE DROPDOWNS & MODALS)
    // =========================================================================
    window.addEventListener('click', function(e) {
        // Close modal if click backdrop
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.classList.remove('show');
        }

        // Close searchable dropdown if click outside
        if (!e.target.closest('.searchable-select-wrap')) {
            document.querySelectorAll('.searchable-select-wrap').forEach(wrap => wrap.classList.remove('active'));
        }
    });
</script>
@endsection