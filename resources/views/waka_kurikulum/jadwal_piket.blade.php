@extends('layouts.waka_kurikulum')

@section('title', 'Jadwal Guru Piket — EDU JOURNAL')

@section('styles')
<style>
    .jadwal-piket-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Page Title Bar */
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .page-main-title {
        font-size: 24px;
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

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .btn-action-excel {
        background: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .btn-action-excel:hover {
        background: #10b981;
        color: #ffffff;
    }

    .btn-action-print {
        background: #f8fafc;
        color: #334155;
        border-color: #cbd5e1;
    }
    .btn-action-print:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-action-primary {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    }
    .btn-action-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-action-import {
        background: #f5f3ff;
        color: #7c3aed;
        border-color: #ddd6fe;
        box-shadow: 0 2px 6px rgba(124, 58, 237, 0.12);
    }
    .btn-action-import:hover {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(124, 58, 237, 0.25);
    }

    .import-dropzone {
        border: 2px dashed #c4b5fd;
        background: #faf5ff;
        border-radius: 14px;
        padding: 24px 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .import-dropzone:hover, .import-dropzone.dragover {
        border-color: #7c3aed;
        background: #f3e8ff;
    }

    /* Metric Cards */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .stat-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
    }

    .stat-icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .icon-blue { background: #eff6ff; color: #2563eb; }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-amber { background: #fffbeb; color: #d97706; }
    .icon-purple { background: #faf5ff; color: #9333ea; }

    .stat-meta-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-meta-value {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 1px;
    }

    .stat-meta-sub {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    /* Filter Month Card */
    .filter-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .filter-form-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 8px 12px;
        border-radius: 9px;
        border: 1.5px solid #cbd5e1;
        font-size: 12.5px;
        font-weight: 600;
        color: #0f172a;
        background: #f8fafc;
        outline: none;
        font-family: inherit;
        cursor: pointer;
    }
    .filter-select:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .btn-submit-filter {
        background: #3b5490;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-submit-filter:hover {
        background: #2b3e6c;
    }

    /* Table Schedule Container (Full Width Fit Without Horizontal Scrolling) */
    .table-schedule-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .table-card-header {
        padding: 14px 18px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .table-card-header h3 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-card-header p {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* ─── Toolbar Filter & Pencarian Tabel Jadwal ─── */
    .table-filter-toolbar {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .toolbar-left-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        min-width: 240px;
        flex: 1;
        max-width: 320px;
    }

    .search-input-wrapper i.search-icon {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }

    .table-search-input {
        width: 100%;
        padding: 7px 32px 7px 34px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.15s ease;
        font-family: inherit;
    }

    .table-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
    }

    .btn-clear-search {
        position: absolute;
        right: 8px;
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 12px;
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .btn-clear-search:hover {
        color: #ef4444;
    }

    .toolbar-select {
        padding: 7px 10px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        background: #ffffff;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        max-width: 175px;
    }

    .toolbar-select:focus {
        border-color: #2563eb;
    }

    .toolbar-right-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-count-badge {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        background: #e2e8f0;
        padding: 5px 10px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-reset-filter {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-reset-filter:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .btn-quick-assign {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-quick-assign:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Table Grid Fit */
    .table-fit-box {
        width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .table-piket-grid {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 11.5px;
        box-sizing: border-box;
    }

    .table-piket-grid thead th {
        background: #f1f5f9;
        color: #334155;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 8px 4px;
        border-bottom: 2px solid #cbd5e1;
        border-right: 1px solid #e2e8f0;
        text-align: center;
        line-height: 1.2;
    }

    .table-piket-grid thead th.th-group-pagi {
        background: #eff6ff;
        color: #1e40af;
        border-bottom: 1px solid #bfdbfe;
        font-size: 11px;
    }

    .table-piket-grid thead th.th-group-siang {
        background: #fef3c7;
        color: #92400e;
        border-bottom: 1px solid #fde68a;
        font-size: 11px;
    }

    .table-piket-grid thead th.th-sub-pagi {
        background: #f0f7ff;
        color: #1e3a8a;
    }

    .table-piket-grid thead th.th-sub-siang {
        background: #fffbeb;
        color: #78350f;
    }

    .table-piket-grid tbody td {
        padding: 5px 3px;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
        background: #ffffff;
        box-sizing: border-box;
    }

    .table-piket-grid tbody tr:hover td {
        background: #f8fafc;
    }

    .td-date-cell {
        padding: 4px 6px !important;
        text-align: center;
    }

    .date-day-badge {
        font-size: 11px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
    }
    .date-num-text {
        font-size: 10px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    .slot-cell-container {
        display: flex;
        align-items: center;
        gap: 3px;
        width: 100%;
        position: relative;
        box-sizing: border-box;
    }

    .guru-slot-select {
        flex: 1;
        min-width: 0;
        width: 100%;
        height: 28px;
        padding: 2px 4px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        transition: all 0.15s ease;
    }
    .guru-slot-select:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
    }
    .guru-slot-select.is-assigned {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #93c5fd;
        font-weight: 700;
    }
    .guru-slot-select.is-coord.is-assigned {
        background: #fefce8;
        color: #854d0e;
        border-color: #fde047;
    }
    .filter-match-highlight {
        box-shadow: 0 0 0 2.5px #10b981 !important;
        border-color: #10b981 !important;
        background: #ecfdf5 !important;
        color: #065f46 !important;
    }

    .btn-slot-search {
        width: 24px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
        padding: 0;
    }
    .btn-slot-search:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .btn-reset-row {
        width: 26px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #ef4444;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.15s ease;
        padding: 0;
    }
    .btn-reset-row:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* ─── Sticky Bottom Action Bar ─── */
    .sticky-submit-bar {
        position: sticky;
        bottom: 12px;
        z-index: 99;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }
    .sticky-bar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sticky-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .sticky-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }
    .sticky-desc {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 1px;
    }
    .sticky-bar-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-cancel-schedule {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .btn-cancel-schedule:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .btn-save-schedule {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        padding: 9px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save-schedule:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    }

    /* ─── Modal Dialog Styling ─── */
    .modal-piket-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-piket-backdrop.active {
        display: flex;
    }

    .modal-piket-dialog {
        background: #ffffff;
        width: 100%;
        max-width: 620px;
        max-height: 88vh;
        border-radius: 18px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalSlideUp 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-piket-header {
        padding: 16px 20px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-piket-header h4 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close-btn {
        background: #f1f5f9;
        border: none;
        color: #64748b;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.15s ease;
    }

    .modal-close-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .modal-target-banner {
        padding: 10px 20px;
        background: #eff6ff;
        border-bottom: 1px solid #dbeafe;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12.5px;
        color: #1e40af;
        font-weight: 600;
    }

    .modal-search-box {
        padding: 12px 20px;
        position: relative;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .modal-search-box i {
        position: absolute;
        left: 32px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .modal-search-input {
        width: 100%;
        padding: 9px 12px 9px 36px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        font-size: 13px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }

    .modal-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .modal-teacher-list {
        flex: 1;
        overflow-y: auto;
        padding: 12px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 420px;
    }

    .teacher-item-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .teacher-item-card:hover {
        border-color: #2563eb;
        background: #f0f7ff;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);
    }

    .teacher-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #384972;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .teacher-info-name {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .teacher-info-sub {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .teacher-pick-btn {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 5px 12px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }

    .teacher-item-card:hover .teacher-pick-btn {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }
</style>
@endsection

@section('content')
<div class="jadwal-piket-container">

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
        <div class="alert alert-success" style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:12px 16px; border-radius:12px; font-weight:700; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check" style="font-size:17px; color:#10b981;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:12px; font-weight:700; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:17px; color:#ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header & Action Buttons (Ekspor CSV & Cetak Jadwal) -->
    <div class="page-header-box">
        <div>
            <h1 class="page-main-title">
                <i class="fa-solid fa-calendar-check" style="color:#2563eb; margin-right:6px;"></i> 
                Jadwal Guru Piket
            </h1>
            <p class="page-sub-title">
                Pusat penugasan dan penjadwalan guru piket harian (8 slot per hari) selama satu bulan penuh.
            </p>
        </div>

        <div class="header-actions-group">
            <button type="button" class="btn-action-custom btn-action-import" onclick="openImportModal()" title="Tambah jadwal guru piket baru dengan import file (Word, PDF, Excel, CSV)">
                <i class="fa-solid fa-file-arrow-up"></i> Import File
            </button>
            <a href="{{ route('waka-kurikulum.jadwal-piket.export', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn-action-custom btn-action-excel" title="Ekspor ke format Excel / CSV">
                <i class="fa-solid fa-file-excel"></i> Ekspor CSV
            </a>
            <a href="{{ route('waka-kurikulum.jadwal-piket.print', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" target="_blank" class="btn-action-custom btn-action-print" title="Cetak Lembar Resmi Jadwal Guru Piket">
                <i class="fa-solid fa-print"></i> Cetak Jadwal
            </a>
            <button type="button" class="btn-action-custom btn-action-primary" onclick="submitMainForm()" title="Simpan seluruh jadwal yang diedit">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal
            </button>
        </div>
    </div>

    <!-- 4 Metric Cards Bar -->
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <div class="stat-meta-label">Hari KBM Aktif</div>
                <div class="stat-meta-value">{{ $totalHariKerja }} Hari</div>
                <div class="stat-meta-sub">Kecuali Sabtu &amp; Minggu</div>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <div class="stat-meta-label">Slot Terisi</div>
                <div class="stat-meta-value">{{ $totalSlotTerisi }} / {{ $totalSlotTersedia }}</div>
                <div class="stat-meta-sub">Keterisian {{ $persenKeterisian }}%</div>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="stat-meta-label">Guru Bertugas</div>
                <div class="stat-meta-value">{{ $totalGuruTerlibat }} Guru</div>
                <div class="stat-meta-sub">Pendidik Mengajar &amp; Wali</div>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <div class="stat-meta-label">Kapasitas Slot</div>
                <div class="stat-meta-value">8 Slot / Hari</div>
                <div class="stat-meta-sub">KBM Pagi &amp; Siang</div>
            </div>
        </div>
    </div>

    <!-- Filter Bulan & Tahun Card -->
    <div class="filter-card">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-filter" style="color:#2563eb; font-size:18px;"></i>
            <div>
                <strong style="font-size:13.5px; color:#0f172a;">Pilih Periode Bulan &amp; Tahun</strong>
                <p style="font-size:12px; color:#64748b; margin:0;">Tampilkan seluruh hari kerja pada bulan yang dipilih untuk penjadwalan massal.</p>
            </div>
        </div>

        <form action="{{ route('waka-kurikulum.jadwal-piket') }}" method="GET" class="filter-form-row">
            <div>
                <select name="bulan" class="filter-select">
                    @foreach($daftarBulan as $num => $namaBulan)
                        <option value="{{ $num }}" {{ $selectedBulan == $num ? 'selected' : '' }}>
                            Bulan: {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="tahun" class="filter-select" style="min-width:105px;">
                    @for($y = 2024; $y <= 2030; $y++)
                        <option value="{{ $y }}" {{ $selectedTahun == $y ? 'selected' : '' }}>
                            Tahun: {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="btn-submit-filter">
                <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
            </button>
        </form>
    </div>

    <!-- Main Schedule Form & Interactive Grid (Fits Screen Width) -->
    <form id="formJadwalPiketMain" action="{{ route('waka-kurikulum.jadwal-piket.store') }}" method="POST">
        @csrf
        <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
        <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

        <div class="table-schedule-card">
            <div class="table-card-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-clipboard-list" style="color:#2563eb;"></i> 
                        Tabel Jadwal Guru Piket Bulan {{ $daftarBulan[$selectedBulan] ?? $selectedBulan }} {{ $selectedTahun }}
                    </h3>
                    <p>
                        Pilih guru dari role <strong>Guru Mengajar</strong> atau <strong>Wali Kelas</strong> pada masing-masing 8 slot setiap hari kerja.
                    </p>
                </div>

                <div style="font-size:11.5px; font-weight:700; color:#475569; background:#f1f5f9; padding:5px 12px; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-circle-check" style="color:#10b981;"></i>
                    Sabtu &amp; Minggu Libur (Otomatis Dikecualikan)
                </div>
            </div>

            <!-- ─── Bar Toolbar Filter & Pencarian Tabel Jadwal ─── -->
            <div class="table-filter-toolbar">
                <div class="toolbar-left-controls">
                    <!-- Search Input Live -->
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input 
                            type="text" 
                            id="liveTableSearch" 
                            class="table-search-input" 
                            placeholder="Cari guru, NIP, hari, tgl..." 
                            oninput="filterScheduleTable()"
                        >
                        <button type="button" id="btnClearTableSearch" class="btn-clear-search" onclick="clearLiveTableSearch()" title="Hapus pencarian">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Filter Hari -->
                    <select id="filterHariSelect" class="toolbar-select" onchange="filterScheduleTable()">
                        <option value="">Semua Hari</option>
                        <option value="Senin">Hari Senin</option>
                        <option value="Selasa">Hari Selasa</option>
                        <option value="Rabu">Hari Rabu</option>
                        <option value="Kamis">Hari Kamis</option>
                        <option value="Jumat">Hari Jumat</option>
                    </select>

                    <!-- Filter Guru Tertentu -->
                    <select id="filterGuruSelect" class="toolbar-select" style="max-width:180px;" onchange="filterScheduleTable()">
                        <option value="">Filter Guru</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Status Keterisian Slot -->
                    <select id="filterStatusSelect" class="toolbar-select" onchange="filterScheduleTable()">
                        <option value="">Status Slot</option>
                        <option value="lengkap">Lengkap (8 Slot)</option>
                        <option value="belum">Ada Slot Kosong</option>
                    </select>
                </div>

                <div class="toolbar-right-controls">
                    <div class="filter-count-badge">
                        <span>Menampilkan:</span>
                        <strong id="filterResultCount">{{ count($workDays) }}</strong> / {{ count($workDays) }} Hari
                    </div>

                    <button type="button" class="btn-reset-filter" onclick="resetScheduleFilter()" title="Kembalikan semua filter dan pencarian ke tampilan awal">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </button>

                    <button type="button" class="btn-quick-assign" onclick="openQuickAssignModal()" title="Buka dialog pencarian guru untuk penugasan cepat">
                        <i class="fa-solid fa-user-plus"></i> Cari &amp; Pilih Guru
                    </button>
                </div>
            </div>

            <div class="table-fit-box">
                <table class="table-piket-grid">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:32px;">NO</th>
                            <th rowspan="2" style="width:105px;">HARI / TGL</th>
                            <th colspan="3" class="th-group-pagi">PETUGAS PIKET KBM PAGI (07.00 - 11.00)</th>
                            <th class="th-group-pagi" style="width:11.5%;">KOORDINATOR</th>
                            <th colspan="3" class="th-group-siang">PETUGAS PIKET KBM SIANG (11.00 - 15.00)</th>
                            <th class="th-group-siang" style="width:11.5%;">KOORDINATOR</th>
                            <th rowspan="2" style="width:38px;" title="Reset 8 slot pada baris ini"><i class="fa-solid fa-rotate-left"></i></th>
                        </tr>
                        <tr>
                            <th class="th-sub-pagi" style="width:10.5%;">Piket 1</th>
                            <th class="th-sub-pagi" style="width:10.5%;">Piket 2</th>
                            <th class="th-sub-pagi" style="width:10.5%;">Piket 3</th>
                            <th class="th-sub-pagi" style="background:#e0f2fe; color:#0369a1; width:11.5%;">Koord. Pagi</th>
                            <th class="th-sub-siang" style="width:10.5%;">Piket 4</th>
                            <th class="th-sub-siang" style="width:10.5%;">Piket 5</th>
                            <th class="th-sub-siang" style="width:10.5%;">Piket 6</th>
                            <th class="th-sub-siang" style="background:#fef08a; color:#713f12; width:11.5%;">Koord. Siang</th>
                        </tr>
                    </thead>
                    <tbody id="tablePiketBody">
                        @forelse($workDays as $index => $wd)
                            @php
                                $tgl = $wd['tanggal'];
                            @endphp
                            <tr id="row-{{ $tgl }}" class="piket-data-row" data-tanggal="{{ $tgl }}" data-hari="{{ $wd['hari'] }}" data-label="{{ $wd['tanggal_format'] }}">
                                <td style="text-align:center; font-weight:800; color:#64748b; font-size:11px;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="td-date-cell">
                                    <div class="date-day-badge">{{ $wd['hari'] }}</div>
                                    <div class="date-num-text">{{ $wd['tanggal_format'] }}</div>
                                </td>

                                <!-- 8 Slot Guru Piket -->
                                @for($slot = 1; $slot <= 8; $slot++)
                                    @php
                                        $currentIdGuru = $jadwalMatrix[$tgl][$slot]['id_guru'] ?? null;
                                        $currentNamaGuru = $jadwalMatrix[$tgl][$slot]['nama_guru'] ?? '';
                                        $isCoord = in_array($slot, [4, 8]);
                                    @endphp
                                    <td style="text-align:center;">
                                        <div class="slot-cell-container">
                                            <select 
                                                name="jadwal[{{ $tgl }}][{{ $slot }}]" 
                                                id="select-{{ $tgl }}-{{ $slot }}"
                                                class="guru-slot-select {{ $currentIdGuru ? 'is-assigned' : '' }} {{ $isCoord ? 'is-coord' : '' }}"
                                                onchange="handleSelectChange(this)"
                                                data-tanggal="{{ $tgl }}"
                                                data-slot="{{ $slot }}"
                                                data-hari="{{ $wd['hari'] }}"
                                                data-tgl-label="{{ $wd['tanggal_format'] }}"
                                                title="Slot {{ $slot }} ({{ $wd['hari'] }}, {{ $wd['tanggal_format'] }}): {{ $currentNamaGuru ?: 'Kosong' }}"
                                            >
                                                <option value="">-- Kosong --</option>
                                                @foreach($gurus as $g)
                                                    <option 
                                                        value="{{ $g->id_guru }}" 
                                                        {{ $currentIdGuru == $g->id_guru ? 'selected' : '' }} 
                                                        data-nama="{{ $g->nama_guru }}"
                                                        data-nip="{{ $g->nip }}"
                                                        data-mapel="{{ $g->mapel->nama_mapel ?? '-' }}"
                                                        data-role="{{ $g->user->role ?? 'guru' }}"
                                                        title="{{ $g->nama_guru }} | NIP: {{ $g->nip ?: '-' }}"
                                                    >
                                                        {{ $g->nama_guru }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button 
                                                type="button" 
                                                class="btn-slot-search" 
                                                onclick="openQuickAssignModal('{{ $tgl }}', {{ $slot }})"
                                                title="Cari & pilih guru untuk slot ini"
                                            >
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </td>
                                @endfor

                                <td style="text-align:center;">
                                    <button type="button" class="btn-reset-row" onclick="resetRow('{{ $tgl }}')" title="Kosongkan 8 slot pada {{ $wd['hari'] }}, {{ $wd['tanggal_format'] }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align:center; padding:36px; color:#64748b;">
                                    <i class="fa-solid fa-calendar-xmark" style="font-size:32px; color:#cbd5e1; margin-bottom:8px; display:block;"></i>
                                    Tidak ada hari kerja pada bulan yang dipilih.
                                </td>
                            </tr>
                        @endforelse

                        <!-- Row Pesan Kosong saat Filter Tidak Menemukan Jadwal -->
                        <tr id="emptyFilterRow" style="display:none;">
                            <td colspan="11" style="text-align:center; padding:36px 20px; color:#64748b; background:#f8fafc;">
                                <i class="fa-solid fa-filter-circle-xmark" style="font-size:34px; color:#94a3b8; margin-bottom:10px; display:block;"></i>
                                <strong style="font-size:14px; color:#0f172a; display:block;">Tidak Ada Jadwal yang Sesuai dengan Kriteria Filter</strong>
                                <p style="font-size:12px; color:#64748b; margin-top:4px; margin-bottom:14px;">Coba ubah kata kunci pencarian atau bersihkan filter yang aktif.</p>
                                <button type="button" class="btn-reset-filter" onclick="resetScheduleFilter()">
                                    <i class="fa-solid fa-rotate-left"></i> Reset Filter Sekarang
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ─── Sticky Bottom Action Bar (Kombinasi Putih, Abu-abu Muda Cerah & Biru) ─── -->
        <div class="sticky-submit-bar">
            <div class="sticky-bar-left">
                <div class="sticky-icon-box">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <div class="sticky-title">Penjadwalan Massal 1 Bulan: {{ $daftarBulan[$selectedBulan] ?? '' }} {{ $selectedTahun }}</div>
                    <div class="sticky-desc">
                        Total {{ count($workDays) }} hari kerja &times; 8 slot penugasan guru piket.
                    </div>
                </div>
            </div>

            <div class="sticky-bar-actions">
                <a href="{{ route('waka-kurikulum.jadwal-piket', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn-cancel-schedule" title="Kembalikan ke data tersimpan">
                    <i class="fa-solid fa-rotate-left"></i> Batal / Muat Ulang
                </a>
                <button type="submit" class="btn-save-schedule" title="Simpan seluruh perubahan ke database">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Seluruh Jadwal Piket
                </button>
            </div>
        </div>
    </form>

</div>

<!-- ─── Modal Dialog Pencarian & Penugasan Cepat Guru Piket ─── -->
<div id="quickAssignModal" class="modal-piket-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-piket-dialog" onclick="event.stopPropagation()">
        <div class="modal-piket-header">
            <h4>
                <i class="fa-solid fa-user-plus" style="color:#2563eb;"></i>
                Pencarian &amp; Penugasan Guru Piket
            </h4>
            <button type="button" class="modal-close-btn" onclick="closeQuickAssignModal()" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Banner Info Slot Target -->
        <div class="modal-target-banner">
            <div>
                <i class="fa-solid fa-bullseye" style="margin-right:6px;"></i>
                Target Slot: <span id="modalTargetLabel">Slot 1 (Piket 1) &bull; Senin, 01/09/2026</span>
            </div>
            <div id="modalTargetSlotBadge" style="background:#2563eb; color:#fff; padding:2px 8px; border-radius:6px; font-size:11px;">
                Slot 1
            </div>
        </div>

        <!-- Select Target Tanggal & Slot jika dibuka dari tombol toolbar atas -->
        <div id="modalTargetSelectBox" style="padding:10px 20px 0 20px; display:flex; gap:10px; flex-wrap:wrap;">
            <div style="flex:1; min-width:180px;">
                <label style="font-size:11px; font-weight:700; color:#64748b; display:block; margin-bottom:3px;">Pilih Hari / Tanggal:</label>
                <select id="modalDatePicker" class="toolbar-select" style="width:100%; max-width:100%;" onchange="syncModalTargetFromDropdowns()">
                    @foreach($workDays as $wd)
                        <option value="{{ $wd['tanggal'] }}" data-hari="{{ $wd['hari'] }}" data-label="{{ $wd['tanggal_format'] }}">
                            {{ $wd['hari'] }}, {{ $wd['tanggal_format'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="width:140px;">
                <label style="font-size:11px; font-weight:700; color:#64748b; display:block; margin-bottom:3px;">Pilih Slot Piket:</label>
                <select id="modalSlotPicker" class="toolbar-select" style="width:100%;" onchange="syncModalTargetFromDropdowns()">
                    <option value="1">Slot 1 (Pagi)</option>
                    <option value="2">Slot 2 (Pagi)</option>
                    <option value="3">Slot 3 (Pagi)</option>
                    <option value="4">Slot 4 (Koord Pagi)</option>
                    <option value="5">Slot 5 (Siang)</option>
                    <option value="6">Slot 6 (Siang)</option>
                    <option value="7">Slot 7 (Siang)</option>
                    <option value="8">Slot 8 (Koord Siang)</option>
                </select>
            </div>
        </div>

        <!-- Search Input Box in Modal -->
        <div class="modal-search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input 
                type="text" 
                id="modalTeacherSearchInput" 
                class="modal-search-input" 
                placeholder="Ketik nama guru, NIP, atau mata pelajaran..." 
                oninput="filterModalTeacherList()"
                autocomplete="off"
            >
        </div>

        <!-- Teacher List -->
        <div class="modal-teacher-list" id="modalTeacherList">
            <!-- Option Kosongkan Slot -->
            <div class="teacher-item-card" onclick="assignTeacherToActiveSlot('', '-- Kosong --')">
                <div class="teacher-avatar-circle" style="background:#ef4444;">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div style="flex:1;">
                    <div class="teacher-info-name" style="color:#dc2626;">Kosongkan Slot Penugasan Ini</div>
                    <div class="teacher-info-sub">Hapus guru dari slot terpilih</div>
                </div>
                <button type="button" class="teacher-pick-btn" style="color:#dc2626; border-color:#fca5a5; background:#fee2e2;">
                    Kosongkan
                </button>
            </div>

            @foreach($gurus as $g)
                @php
                    $inisial = strtoupper(substr($g->nama_guru, 0, 1));
                    $mapelName = $g->mapel->nama_mapel ?? 'Semua Mapel';
                    $roleLabel = ($g->user && $g->user->role === 'wali_kelas') ? 'Wali Kelas' : 'Guru Mengajar';
                @endphp
                <div 
                    class="teacher-item-card modal-teacher-card" 
                    data-id="{{ $g->id_guru }}" 
                    data-nama="{{ $g->nama_guru }}"
                    data-nip="{{ $g->nip }}"
                    data-mapel="{{ $mapelName }}"
                    data-role="{{ $roleLabel }}"
                    onclick="assignTeacherToActiveSlot('{{ $g->id_guru }}', '{{ addslashes($g->nama_guru) }}')"
                >
                    <div class="teacher-avatar-circle">
                        {{ $inisial }}
                    </div>
                    <div style="flex:1;">
                        <div class="teacher-info-name">{{ $g->nama_guru }}</div>
                        <div class="teacher-info-sub">
                            <span>NIP: {{ $g->nip ?: '-' }}</span> &bull; 
                            <span style="color:#2563eb; font-weight:600;">{{ $mapelName }}</span> &bull;
                            <span style="background:#e2e8f0; color:#334155; padding:1px 5px; border-radius:4px; font-size:10px;">{{ $roleLabel }}</span>
                        </div>
                    </div>
                    <button type="button" class="teacher-pick-btn">
                        Pilih
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ─── Modal Dialog Tambah Jadwal Guru Piket Via Import File ─── -->
<div id="modalImportJadwal" class="modal-piket-backdrop" onclick="handleImportBackdropClick(event)">
    <div class="modal-piket-dialog" style="max-width:580px;" onclick="event.stopPropagation()">
        <div class="modal-piket-header">
            <h4>
                <i class="fa-solid fa-file-arrow-up" style="color:#7c3aed;"></i>
                Tambah Jadwal Guru Piket Via Import File
            </h4>
            <button type="button" class="modal-close-btn" onclick="closeImportModal()" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formImportJadwalFile" onsubmit="handleImportSubmit(event)" enctype="multipart/form-data" style="margin:0; padding:20px; display:flex; flex-direction:column; gap:16px;">
            @csrf
            <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
            <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

            <!-- Support Format Badges Banner -->
            <div style="background:#f5f3ff; border:1px solid #ddd6fe; border-radius:12px; padding:12px 16px;">
                <div style="font-size:12px; font-weight:800; color:#6d28d9; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-circle-check"></i> Mendukung Berbagai Format Dokumen Sekolah:
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <span style="background:#ffffff; border:1px solid #c4b5fd; color:#5b21b6; padding:3px 8px; border-radius:6px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-file-word" style="color:#2563eb;"></i> Word (.docx, .doc)
                    </span>
                    <span style="background:#ffffff; border:1px solid #c4b5fd; color:#5b21b6; padding:3px 8px; border-radius:6px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-file-pdf" style="color:#ef4444;"></i> PDF (.pdf)
                    </span>
                    <span style="background:#ffffff; border:1px solid #c4b5fd; color:#5b21b6; padding:3px 8px; border-radius:6px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-file-excel" style="color:#10b981;"></i> Excel (.xlsx, .xls)
                    </span>
                    <span style="background:#ffffff; border:1px solid #c4b5fd; color:#5b21b6; padding:3px 8px; border-radius:6px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-file-csv" style="color:#059669;"></i> CSV (.csv)
                    </span>
                </div>
                <p style="font-size:11.5px; color:#6b7280; margin-top:8px; margin-bottom:0; line-height:1.4;">
                    Sistem secara otomatis membaca jadwal, mengekstrak tanggal hari kerja, dan mencocokkan nama guru ke dalam 8 slot penugasan bulan <strong>{{ $daftarBulan[$selectedBulan] ?? $selectedBulan }} {{ $selectedTahun }}</strong>.
                </p>
            </div>

            <!-- Drag & Drop Zone -->
            <div 
                id="dropZoneContainer" 
                class="import-dropzone" 
                onclick="document.getElementById('fileJadwalInput').click()"
                ondragover="handleDragOver(event)"
                ondragleave="handleDragLeave(event)"
                ondrop="handleFileDrop(event)"
            >
                <input 
                    type="file" 
                    id="fileJadwalInput" 
                    name="file_jadwal" 
                    accept=".pdf,.docx,.doc,.xlsx,.xls,.csv,.txt" 
                    style="display:none;" 
                    onchange="handleFileChosen(this)"
                    required
                >
                <div id="dropZonePrompt">
                    <div style="width:50px; height:50px; border-radius:14px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:22px; margin:0 auto 10px auto;">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div style="font-size:13.5px; font-weight:800; color:#0f172a;">
                        Pilih atau Tarik File Jadwal ke Sini
                    </div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
                        Maksimal ukuran file: 20 MB (Word, PDF, Excel, atau CSV)
                    </div>
                </div>

                <!-- Selected File Display -->
                <div id="dropZoneSelectedFile" style="display:none;">
                    <div style="display:flex; align-items:center; gap:12px; background:#ffffff; border:1px solid #cbd5e1; border-radius:10px; padding:10px 14px; text-align:left;">
                        <div id="selectedFileIcon" style="font-size:26px; color:#2563eb;">
                            <i class="fa-solid fa-file"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div id="selectedFileName" style="font-size:12.5px; font-weight:800; color:#0f172a; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">-</div>
                            <div id="selectedFileSize" style="font-size:11px; color:#64748b;">-</div>
                        </div>
                        <button type="button" onclick="clearSelectedImportFile(event)" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:7px; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px;" title="Hapus file">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status / Loading Indicator -->
            <div id="importLoadingState" style="display:none; text-align:center; padding:10px 0;">
                <div style="display:inline-flex; align-items:center; gap:10px; font-size:12.5px; font-weight:700; color:#7c3aed;">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size:18px;"></i>
                    <span>Sedang memproses &amp; membaca data file jadwal...</span>
                </div>
            </div>

            <!-- Import Result Alert Box -->
            <div id="importResultBox" style="display:none;"></div>

            <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; margin-top:4px;">
                <button type="button" class="btn-cancel-schedule" onclick="closeImportModal()">
                    Batal
                </button>
                <button type="submit" id="btnSubmitImport" class="btn-save-schedule" style="background:linear-gradient(135deg, #7c3aed, #6d28d9); box-shadow:0 4px 12px rgba(124, 58, 237, 0.25);">
                    <i class="fa-solid fa-file-import"></i> Proses &amp; Masukkan ke Tabel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // State Active Target untuk Modal Penugasan Cepat
    let activeTargetTanggal = '';
    let activeTargetSlot = 1;

    function handleSelectChange(selectElem) {
        if (selectElem.value !== '') {
            selectElem.classList.add('is-assigned');
            const selectedText = selectElem.options[selectElem.selectedIndex].text;
            selectElem.setAttribute('title', selectedText);
        } else {
            selectElem.classList.remove('is-assigned');
            selectElem.setAttribute('title', 'Kosong');
        }
    }

    function resetRow(tgl) {
        if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh 8 slot guru piket pada tanggal ini?')) {
            return;
        }
        const row = document.getElementById('row-' + tgl);
        if (row) {
            const selects = row.querySelectorAll('.guru-slot-select');
            selects.forEach(sel => {
                sel.value = '';
                sel.classList.remove('is-assigned');
                sel.setAttribute('title', 'Kosong');
            });
        }
    }

    // ─── Filter & Pencarian Tabel Jadwal ───
    function filterScheduleTable() {
        const keyword = (document.getElementById('liveTableSearch').value || '').toLowerCase().trim();
        const selectedHari = document.getElementById('filterHariSelect').value;
        const selectedGuruId = document.getElementById('filterGuruSelect').value;
        const selectedStatus = document.getElementById('filterStatusSelect').value;

        const clearBtn = document.getElementById('btnClearTableSearch');
        if (clearBtn) {
            clearBtn.style.display = keyword.length > 0 ? 'inline-flex' : 'none';
        }

        const rows = document.querySelectorAll('.piket-data-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const tgl = row.getAttribute('data-tanggal');
            const hari = row.getAttribute('data-hari');
            const tglLabel = row.getAttribute('data-label') || '';

            const selects = row.querySelectorAll('.guru-slot-select');
            let matchKeyword = false;
            let matchHari = true;
            let matchGuru = true;
            let matchStatus = true;

            // 1. Cek Hari
            if (selectedHari && hari !== selectedHari) {
                matchHari = false;
            }

            // 2. Cek Guru & Highlight
            let assignedCount = 0;
            let rowHasSelectedGuru = false;
            let rowHasKeyword = false;

            // Cek jika keyword cocok dengan nama hari atau tanggal
            if (keyword && (hari.toLowerCase().includes(keyword) || tglLabel.toLowerCase().includes(keyword) || tgl.toLowerCase().includes(keyword))) {
                rowHasKeyword = true;
            }

            selects.forEach(sel => {
                const val = sel.value;
                const opt = sel.options[sel.selectedIndex];
                const text = opt ? opt.text.toLowerCase() : '';
                const nip = opt ? (opt.getAttribute('data-nip') || '').toLowerCase() : '';
                const mapel = opt ? (opt.getAttribute('data-mapel') || '').toLowerCase() : '';

                if (val !== '') {
                    assignedCount++;
                }

                if (selectedGuruId && val === selectedGuruId) {
                    rowHasSelectedGuru = true;
                }

                let slotMatchesKeyword = false;
                if (keyword && val !== '' && (text.includes(keyword) || nip.includes(keyword) || mapel.includes(keyword))) {
                    slotMatchesKeyword = true;
                    rowHasKeyword = true;
                }

                // Highlight slot yang cocok dengan pencarian
                if ((keyword && slotMatchesKeyword) || (selectedGuruId && val === selectedGuruId)) {
                    sel.classList.add('filter-match-highlight');
                } else {
                    sel.classList.remove('filter-match-highlight');
                }
            });

            if (selectedGuruId && !rowHasSelectedGuru) {
                matchGuru = false;
            }

            if (keyword && !rowHasKeyword) {
                matchKeyword = false;
            } else {
                matchKeyword = true;
            }

            // 3. Cek Status Keterisian
            if (selectedStatus === 'lengkap' && assignedCount < 8) {
                matchStatus = false;
            } else if (selectedStatus === 'belum' && assignedCount === 8) {
                matchStatus = false;
            }

            // Hasil akhir filter baris
            if (matchHari && matchGuru && matchKeyword && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counter & Empty state
        const countDisplay = document.getElementById('filterResultCount');
        if (countDisplay) {
            countDisplay.innerText = visibleCount;
        }

        const emptyRow = document.getElementById('emptyFilterRow');
        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 ? '' : 'none';
        }
    }

    function clearLiveTableSearch() {
        const input = document.getElementById('liveTableSearch');
        if (input) {
            input.value = '';
            filterScheduleTable();
            input.focus();
        }
    }

    function resetScheduleFilter() {
        const searchInput = document.getElementById('liveTableSearch');
        if (searchInput) searchInput.value = '';

        const hariSelect = document.getElementById('filterHariSelect');
        if (hariSelect) hariSelect.value = '';

        const guruSelect = document.getElementById('filterGuruSelect');
        if (guruSelect) guruSelect.value = '';

        const statusSelect = document.getElementById('filterStatusSelect');
        if (statusSelect) statusSelect.value = '';

        filterScheduleTable();
    }

    // ─── Quick Assign Modal Logic ───
    function openQuickAssignModal(tanggal = '', slot = 1) {
        const modal = document.getElementById('quickAssignModal');
        if (!modal) return;

        if (!tanggal) {
            const firstRow = document.querySelector('.piket-data-row');
            if (firstRow) {
                tanggal = firstRow.getAttribute('data-tanggal');
            }
        }

        activeTargetTanggal = tanggal;
        activeTargetSlot = slot;

        const datePicker = document.getElementById('modalDatePicker');
        if (datePicker && tanggal) {
            datePicker.value = tanggal;
        }

        const slotPicker = document.getElementById('modalSlotPicker');
        if (slotPicker) {
            slotPicker.value = slot;
        }

        updateModalTargetBanner();

        const searchInput = document.getElementById('modalTeacherSearchInput');
        if (searchInput) {
            searchInput.value = '';
            filterModalTeacherList();
        }

        modal.classList.add('active');
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 100);
    }

    function closeQuickAssignModal() {
        const modal = document.getElementById('quickAssignModal');
        if (modal) {
            modal.classList.remove('active');
        }
    }

    function handleBackdropClick(event) {
        if (event.target && event.target.id === 'quickAssignModal') {
            closeQuickAssignModal();
        }
    }

    function syncModalTargetFromDropdowns() {
        const datePicker = document.getElementById('modalDatePicker');
        const slotPicker = document.getElementById('modalSlotPicker');
        if (datePicker) activeTargetTanggal = datePicker.value;
        if (slotPicker) activeTargetSlot = parseInt(slotPicker.value) || 1;
        updateModalTargetBanner();
    }

    function updateModalTargetBanner() {
        const bannerLabel = document.getElementById('modalTargetLabel');
        const badge = document.getElementById('modalTargetSlotBadge');
        
        const datePicker = document.getElementById('modalDatePicker');
        const selectedOpt = datePicker ? datePicker.options[datePicker.selectedIndex] : null;
        const hari = selectedOpt ? selectedOpt.getAttribute('data-hari') : '';
        const tglLabel = selectedOpt ? selectedOpt.getAttribute('data-label') : '';

        const slotNames = {
            1: 'Piket 1 (KBM Pagi)',
            2: 'Piket 2 (KBM Pagi)',
            3: 'Piket 3 (KBM Pagi)',
            4: 'Koordinator Pagi (KBM Pagi)',
            5: 'Piket 4 (KBM Siang)',
            6: 'Piket 5 (KBM Siang)',
            7: 'Piket 6 (KBM Siang)',
            8: 'Koordinator Siang (KBM Siang)'
        };

        const slotName = slotNames[activeTargetSlot] || `Slot ${activeTargetSlot}`;

        if (bannerLabel) {
            bannerLabel.innerHTML = `<strong>${slotName}</strong> &bull; ${hari}, ${tglLabel}`;
        }
        if (badge) {
            badge.innerText = `Slot ${activeTargetSlot}`;
        }
    }

    function filterModalTeacherList() {
        const query = (document.getElementById('modalTeacherSearchInput').value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.modal-teacher-card');

        cards.forEach(card => {
            const nama = (card.getAttribute('data-nama') || '').toLowerCase();
            const nip = (card.getAttribute('data-nip') || '').toLowerCase();
            const mapel = (card.getAttribute('data-mapel') || '').toLowerCase();
            const role = (card.getAttribute('data-role') || '').toLowerCase();

            if (!query || nama.includes(query) || nip.includes(query) || mapel.includes(query) || role.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function assignTeacherToActiveSlot(idGuru, namaGuru) {
        if (!activeTargetTanggal || !activeTargetSlot) return;

        const selectId = `select-${activeTargetTanggal}-${activeTargetSlot}`;
        const selectElem = document.getElementById(selectId);

        if (selectElem) {
            selectElem.value = idGuru;
            handleSelectChange(selectElem);

            selectElem.style.transition = 'all 0.3s ease';
            selectElem.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.4)';
            setTimeout(() => {
                selectElem.style.boxShadow = '';
            }, 1200);
        }

        closeQuickAssignModal();
    }

    function submitMainForm() {
        const form = document.getElementById('formJadwalPiketMain');
        if (form) {
            form.submit();
        }
    }

    // ─── Modal Import Jadwal Guru Piket Logic ───
    let selectedImportFile = null;

    function openImportModal() {
        const modal = document.getElementById('modalImportJadwal');
        if (!modal) return;

        // Reset form state
        clearSelectedImportFile();
        const resultBox = document.getElementById('importResultBox');
        if (resultBox) {
            resultBox.style.display = 'none';
            resultBox.innerHTML = '';
        }
        const loadingState = document.getElementById('importLoadingState');
        if (loadingState) loadingState.style.display = 'none';

        modal.classList.add('active');
    }

    function closeImportModal() {
        const modal = document.getElementById('modalImportJadwal');
        if (modal) {
            modal.classList.remove('active');
        }
    }

    function handleImportBackdropClick(event) {
        if (event.target && event.target.id === 'modalImportJadwal') {
            closeImportModal();
        }
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropzone = document.getElementById('dropZoneContainer');
        if (dropzone) dropzone.classList.add('dragover');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropzone = document.getElementById('dropZoneContainer');
        if (dropzone) dropzone.classList.remove('dragover');
    }

    function handleFileDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropzone = document.getElementById('dropZoneContainer');
        if (dropzone) dropzone.classList.remove('dragover');

        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            const file = e.dataTransfer.files[0];
            const fileInput = document.getElementById('fileJadwalInput');
            if (fileInput) {
                fileInput.files = e.dataTransfer.files;
            }
            displaySelectedFile(file);
        }
    }

    function handleFileChosen(input) {
        if (input.files && input.files[0]) {
            displaySelectedFile(input.files[0]);
        }
    }

    function displaySelectedFile(file) {
        selectedImportFile = file;
        const prompt = document.getElementById('dropZonePrompt');
        const selectedDisplay = document.getElementById('dropZoneSelectedFile');
        const fileNameElem = document.getElementById('selectedFileName');
        const fileSizeElem = document.getElementById('selectedFileSize');
        const fileIconElem = document.getElementById('selectedFileIcon');

        if (prompt) prompt.style.display = 'none';
        if (selectedDisplay) selectedDisplay.style.display = 'block';
        if (fileNameElem) fileNameElem.innerText = file.name;

        // Size format
        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const sizeText = file.size > 1024 * 1024 ? `${sizeMB} MB` : `${sizeKB} KB`;
        if (fileSizeElem) fileSizeElem.innerText = `${sizeText} • Siap diproses`;

        // Icon based on ext
        const ext = file.name.split('.').pop().toLowerCase();
        let iconHtml = '<i class="fa-solid fa-file"></i>';
        if (ext === 'pdf') {
            iconHtml = '<i class="fa-solid fa-file-pdf" style="color:#ef4444;"></i>';
        } else if (['docx', 'doc'].includes(ext)) {
            iconHtml = '<i class="fa-solid fa-file-word" style="color:#2563eb;"></i>';
        } else if (['xlsx', 'xls'].includes(ext)) {
            iconHtml = '<i class="fa-solid fa-file-excel" style="color:#10b981;"></i>';
        } else if (ext === 'csv') {
            iconHtml = '<i class="fa-solid fa-file-csv" style="color:#059669;"></i>';
        }
        if (fileIconElem) fileIconElem.innerHTML = iconHtml;
    }

    function clearSelectedImportFile(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        selectedImportFile = null;
        const fileInput = document.getElementById('fileJadwalInput');
        if (fileInput) fileInput.value = '';

        const prompt = document.getElementById('dropZonePrompt');
        const selectedDisplay = document.getElementById('dropZoneSelectedFile');
        if (prompt) prompt.style.display = 'block';
        if (selectedDisplay) selectedDisplay.style.display = 'none';
    }

    function handleImportSubmit(e) {
        e.preventDefault();

        const fileInput = document.getElementById('fileJadwalInput');
        if (!fileInput || !fileInput.files || !fileInput.files[0]) {
            alert('Silakan pilih file jadwal (Word, PDF, Excel, atau CSV) terlebih dahulu!');
            return;
        }

        const form = document.getElementById('formImportJadwalFile');
        const formData = new FormData(form);

        const btnSubmit = document.getElementById('btnSubmitImport');
        const loadingState = document.getElementById('importLoadingState');
        const resultBox = document.getElementById('importResultBox');

        if (btnSubmit) btnSubmit.disabled = true;
        if (loadingState) loadingState.style.display = 'block';
        if (resultBox) {
            resultBox.style.display = 'none';
            resultBox.innerHTML = '';
        }

        fetch("{{ route('waka-kurikulum.jadwal-piket.import') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (btnSubmit) btnSubmit.disabled = false;
            if (loadingState) loadingState.style.display = 'none';

            if (data.success) {
                // Populate into Table
                let populatedCount = 0;
                const scheduleMatrix = data.schedule_matrix || {};

                for (const tanggal in scheduleMatrix) {
                    const slots = scheduleMatrix[tanggal];
                    for (const slot in slots) {
                        const idGuru = slots[slot];
                        const selectElem = document.getElementById(`select-${tanggal}-${slot}`);
                        if (selectElem) {
                            if (idGuru !== null && idGuru !== undefined) {
                                selectElem.value = idGuru;
                                handleSelectChange(selectElem);
                                populatedCount++;

                                selectElem.style.transition = 'all 0.4s ease';
                                selectElem.classList.add('filter-match-highlight');
                                setTimeout(() => {
                                    selectElem.classList.remove('filter-match-highlight');
                                }, 4000);
                            }
                        }
                    }
                }

                // Update dynamic stats counters on page
                updateDynamicTableStats();

                if (resultBox) {
                    resultBox.style.display = 'block';
                    let unmatchedHtml = '';
                    if (data.unmatched_count > 0 && data.unmatched_samples && data.unmatched_samples.length > 0) {
                        unmatchedHtml = `
                            <div style="margin-top:8px; padding:8px 10px; background:#fffbeb; border:1px solid #fef3c7; border-radius:8px; font-size:11.5px; color:#92400e;">
                                <strong><i class="fa-solid fa-triangle-exclamation"></i> Catatan (${data.unmatched_count} slot kosong/tidak cocok):</strong>
                                <ul style="margin:4px 0 0 16px; padding:0;">
                                    ${data.unmatched_samples.map(s => `<li>${s}</li>`).join('')}
                                </ul>
                            </div>
                        `;
                    }

                    resultBox.innerHTML = `
                        <div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:14px 16px; border-radius:12px; font-size:12.5px;">
                            <div style="display:flex; align-items:center; gap:8px; font-weight:800; font-size:13.5px; margin-bottom:4px;">
                                <i class="fa-solid fa-circle-check" style="color:#10b981; font-size:18px;"></i>
                                File Berhasil Diproses! (${populatedCount} Penugasan Guru Dimasukkan ke Tabel)
                            </div>
                            <p style="margin:0 0 8px 0; font-size:12px; color:#047857;">
                                ${data.message}
                            </p>
                            ${unmatchedHtml}
                            <div style="font-size:11.5px; background:#ffffff; padding:8px 12px; border-radius:8px; border:1px solid #a7f3d0; color:#334155; margin-top:8px;">
                                <i class="fa-solid fa-info-circle" style="color:#2563eb;"></i> 
                                <strong>Langkah Selanjutnya:</strong> Seluruh data telah masuk ke tabel secara otomatis (termasuk Piket 1 s.d. Koord Siang). Silakan periksa kembali, lalu klik tombol <strong>'Simpan Seluruh Jadwal Piket'</strong> di bagian bawah untuk menyimpan ke database.
                            </div>
                        </div>
                    `;
                }

                setTimeout(() => {
                    closeImportModal();
                }, 2800);

            } else {
                if (resultBox) {
                    resultBox.style.display = 'block';
                    resultBox.innerHTML = `
                        <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:12px; font-size:12.5px; font-weight:600;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; margin-right:6px;"></i>
                            ${data.message || 'Gagal memproses file impor.'}
                        </div>
                    `;
                }
            }
        })
        .catch(err => {
            if (btnSubmit) btnSubmit.disabled = false;
            if (loadingState) loadingState.style.display = 'none';
            if (resultBox) {
                resultBox.style.display = 'block';
                resultBox.innerHTML = `
                    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:12px; font-size:12.5px; font-weight:600;">
                        <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; margin-right:6px;"></i>
                        Terjadi kesalahan jaringan atau server saat memproses file.
                    </div>
                `;
            }
        });
    }

    function updateDynamicTableStats() {
        const allSelects = document.querySelectorAll('.guru-slot-select');
        let filledCount = 0;
        const uniqueTeachers = new Set();

        allSelects.forEach(sel => {
            if (sel.value !== '') {
                filledCount++;
                uniqueTeachers.add(sel.value);
            }
        });

        const totalSlots = allSelects.length;
        const percent = totalSlots > 0 ? ((filledCount / totalSlots) * 100).toFixed(1) : 0;

        const statCards = document.querySelectorAll('.stat-card-item');
        if (statCards.length >= 3) {
            // Card 2: Slot Terisi
            const valSlot = statCards[1].querySelector('.stat-meta-value');
            const subSlot = statCards[1].querySelector('.stat-meta-sub');
            if (valSlot) valSlot.innerText = `${filledCount} / ${totalSlots}`;
            if (subSlot) subSlot.innerText = `Keterisian ${percent}%`;

            // Card 3: Guru Bertugas
            const valGuru = statCards[2].querySelector('.stat-meta-value');
            if (valGuru) valGuru.innerText = `${uniqueTeachers.size} Guru`;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuickAssignModal();
            closeImportModal();
        }
    });
</script>
@endsection