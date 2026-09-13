@extends('layouts.guru')

@section('title', 'Dispensasi Siswa — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Student & Waka Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Container & Base Styles */
    .dispen-page-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ─── Top 4 Stat Cards (Tanpa Panah / Chevron) ─── */
    .dispen-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    @media (max-width: 1100px) {
        .dispen-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .dispen-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .dispen-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dispen-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .dispen-stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
    }

    .dispen-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .dispen-stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .dispen-stat-icon.green {
        background: #ecfdf5;
        color: #10b981;
    }

    .dispen-stat-icon.amber {
        background: #fffbeb;
        color: #f59e0b;
    }

    .dispen-stat-icon.rose {
        background: #fff1f2;
        color: #f43f5e;
    }

    .dispen-stat-info {
        display: flex;
        flex-direction: column;
    }

    .dispen-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 2px;
    }

    .dispen-stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .dispen-stat-sub {
        font-size: 11.5px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* ─── Card Container Standard ─── */
    .dispen-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .dispen-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dispen-card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dispen-card-icon {
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

    .dispen-card-title {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .dispen-card-subtitle {
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .dispen-pill-badge {
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

    .dispen-card-body {
        padding: 24px;
    }

    /* ─── Form Input Styles ─── */
    .dispen-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    .dispen-form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    @media (max-width: 900px) {
        .dispen-form-grid, .dispen-form-grid-3 {
            grid-template-columns: 1fr;
        }
    }

    .dispen-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .dispen-form-group.full-width {
        grid-column: 1 / -1;
    }

    .dispen-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .dispen-label .req {
        color: #ef4444;
    }

    .dispen-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .dispen-input-icon {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
        z-index: 1;
    }

    .dispen-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .dispen-input:focus, .dispen-textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: #ffffff;
    }

    .dispen-textarea {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
        resize: vertical;
        font-family: inherit;
    }

    /* File Dropzone / Upload Box */
    .dispen-upload-box {
        background: #ffffff;
        border: 1.5px dashed #cbd5e1;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.2s ease;
        position: relative;
    }

    .dispen-upload-box:hover {
        border-color: #3b82f6;
        background: #f8fafc;
    }

    .dispen-upload-box.has-file {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .dispen-upload-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dispen-upload-title {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dispen-upload-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .dispen-upload-badge.optional {
        background: #f1f5f9;
        color: #64748b;
    }

    .dispen-upload-badge.recommended {
        background: #eff6ff;
        color: #2563eb;
    }

    .dispen-upload-body {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dispen-file-btn {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.15s ease;
    }

    .dispen-file-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .dispen-file-name {
        font-size: 12px;
        color: #64748b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1;
    }

    .dispen-upload-hint {
        font-size: 11px;
        color: #94a3b8;
    }

    /* Form Action Buttons */
    .dispen-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .dispen-btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .dispen-btn-reset:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .dispen-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #2563eb;
        border: 1px solid #1d4ed8;
        border-radius: 12px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .dispen-btn-submit:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
    }

    /* ─── Filter & Toolbar Controls Block (Kompak, Proporsional, & Bersatu) ─── */
    .dispen-filter-block {
        padding: 14px 20px 12px 20px;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dispen-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .dispen-search-box {
        flex: 1 1 220px;
        min-width: 180px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .dispen-search-box i {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }

    .dispen-search-input {
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

    .dispen-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .dispen-filter-select {
        flex: 0 1 170px;
        min-width: 140px;
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

    .dispen-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .dispen-filter-date {
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

    .dispen-filter-date:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .dispen-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        flex-shrink: 0;
    }

    .dispen-btn-filter-dark {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 8px 15px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .dispen-btn-filter-dark:hover {
        background: #0f172a;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
    }

    .dispen-btn-filter-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
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

    .dispen-btn-filter-reset:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* Baris 2 Toolbar: Aksi Tabel */
    .dispen-action-toolbar {
        padding: 0;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    .dispen-toolbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 32px;
    }

    .dispen-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    /* Placeholder Toolbar */
    .dispen-bulk-placeholder {
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

    .dispen-bulk-placeholder i {
        font-size: 12px;
        color: #3b82f6;
    }

    .dispen-btn-bulk-del {
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

    .dispen-btn-bulk-del:hover {
        background: #fecaca;
        color: #b91c1c;
        border-color: #f87171;
    }

    .dispen-btn-trash-link {
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

    .dispen-btn-trash-link:hover {
        background: #fdf2f8;
        color: #be185d;
        border-color: #f472b6;
    }

    /* Checkbox Styling */
    .dispen-checkbox {
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

    .dispen-checkbox:hover {
        border-color: #2563eb !important;
    }

    .dispen-checkbox:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25);
    }

    /* ─── Table Styles ─── */
    .dispen-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-top: 1px solid #e2e8f0;
    }

    .dispen-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .dispen-table thead {
        background: #f1f5f9;
    }

    .dispen-table th {
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

    .dispen-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 11.5px;
        color: #1e293b;
        vertical-align: middle;
    }

    .dispen-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .status-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-pending  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

    /* Action Buttons in Table */
    .dispen-act-btn {
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

    .dispen-act-detail { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .dispen-act-detail:hover { background: #2563eb; color: #ffffff; }

    .dispen-act-link { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .dispen-act-link:hover { background: #16a34a; color: #ffffff; }

    .dispen-act-wa { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .dispen-act-wa:hover { background: #059669; color: #ffffff; }

    .dispen-act-barcode { background: #faf5ff; color: #9333ea; border: 1px solid #e9d5ff; }
    .dispen-act-barcode:hover { background: #9333ea; color: #ffffff; }

    .dispen-act-edit { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .dispen-act-edit:hover { background: #d97706; color: #ffffff; }

    .dispen-act-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .dispen-act-delete:hover { background: #dc2626; color: #ffffff; }

    /* Empty State */
    .dispen-empty-box {
        padding: 50px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .dispen-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 14px;
    }

    .dispen-empty-title {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        margin: 0 0 4px 0;
    }

    .dispen-empty-desc {
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }

    /* Modal Styling */
    .dispen-modal-backdrop {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center;
        z-index: 9999; padding: 20px;
    }
    .dispen-modal-card {
        background: #ffffff; border-radius: 18px; width: 100%; max-width: 580px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .dispen-modal-header {
        padding: 18px 24px; background: #1e293b; color: #ffffff;
        display: flex; align-items: center; justify-content: space-between;
    }
    .dispen-modal-body { padding: 24px; max-height: 80vh; overflow-y: auto; }

    /* Custom Select2 Overrides */
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 7px 12px;
        background-color: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #0f172a;
        font-size: 13px;
        font-weight: 500;
        line-height: 26px;
        padding-left: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 10px;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        overflow: hidden;
        font-size: 13px;
        z-index: 10000;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12.5px;
        outline: none;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #2563eb;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563eb;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="dispen-page-container">

    <!-- ─── TOP 4 STAT CARDS (TANPA PANAH / CHEVRON) ─── -->
    @php
        $hasStatusWaka = \Illuminate\Support\Facades\Schema::hasColumn('siswa_dispen', 'status_waka');
        $countApproved = $hasStatusWaka
            ? \App\Models\SiswaDispen::where('status_waka', 'approved')->count()
            : \App\Models\SiswaDispen::where('status_wali_kelas', 'approved')->count();
        $countPending  = $hasStatusWaka
            ? \App\Models\SiswaDispen::where('status_waka', 'pending')->count()
            : \App\Models\SiswaDispen::where('status_wali_kelas', 'pending')->count();
        $countRejected = $hasStatusWaka
            ? \App\Models\SiswaDispen::where('status_waka', 'rejected')->count()
            : \App\Models\SiswaDispen::where('status_wali_kelas', 'rejected')->count();
    @endphp

    <div class="dispen-stats-grid">
        <!-- Card 1: Total Pengajuan -->
        <div class="dispen-stat-card">
            <div class="dispen-stat-left">
                <div class="dispen-stat-icon blue">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div class="dispen-stat-info">
                    <span class="dispen-stat-title">Total Pengajuan</span>
                    <span class="dispen-stat-number">{{ $totalPengajuan }}</span>
                    <span class="dispen-stat-sub">Semua permohonan dispen</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Disetujui -->
        <div class="dispen-stat-card">
            <div class="dispen-stat-left">
                <div class="dispen-stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="dispen-stat-info">
                    <span class="dispen-stat-title">Disetujui</span>
                    <span class="dispen-stat-number">{{ $countApproved }}</span>
                    <span class="dispen-stat-sub">Telah di-ACC oleh Waka</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Menunggu -->
        <div class="dispen-stat-card">
            <div class="dispen-stat-left">
                <div class="dispen-stat-icon amber">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="dispen-stat-info">
                    <span class="dispen-stat-title">Menunggu</span>
                    <span class="dispen-stat-number">{{ $countPending }}</span>
                    <span class="dispen-stat-sub">Menunggu verifikasi Waka</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Ditolak -->
        <div class="dispen-stat-card">
            <div class="dispen-stat-left">
                <div class="dispen-stat-icon rose">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="dispen-stat-info">
                    <span class="dispen-stat-title">Ditolak</span>
                    <span class="dispen-stat-number">{{ $countRejected }}</span>
                    <span class="dispen-stat-sub">Ditolak / tidak diizinkan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Error Validation -->
    @if($errors->any())
        <div class="dispen-card" style="border-left: 5px solid #ef4444; background: #fef2f2; margin-bottom: 20px;">
            <div class="dispen-card-body" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #991b1b; font-weight: 700; font-size: 13.5px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 20px;"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert Banner Generated Link Waka -->
    @if(session('success'))
        <div class="dispen-card" style="border-left: 5px solid #10b981; background: #ecfdf5; margin-bottom: 20px;">
            <div class="dispen-card-body" style="padding: 18px 24px;">
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 24px; color: #10b981; margin-top: 2px;"></i>
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 4px 0; font-size: 15px; font-weight: 800; color: #065f46;">{{ session('success') }}</h4>
                        @if(session('approval_url'))
                            <p style="margin: 4px 0 10px 0; font-size: 13px; color: #047857; font-weight: 600;">
                                Link Persetujuan Waka telah berhasil dibuat. Silakan kirimkan link di bawah kepada Waka untuk verifikasi NIP & Password:
                            </p>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <input type="text" id="successApprovalUrlInput" value="{{ session('approval_url') }}" readonly class="dispen-input" style="flex: 1; background: #ffffff; border-color: #a7f3d0; font-family: monospace; font-weight: 700; color: #065f46; padding-left: 14px;">
                                <button type="button" onclick="copyLink(`{{ session('approval_url') }}`)" class="dispen-act-btn dispen-act-detail" style="width: auto; height: 38px; padding: 0 16px; font-weight: 700; border-radius: 10px; gap: 6px;">
                                    <i class="fa-solid fa-copy"></i> Salin Link
                                </button>
                                @if(session('wa_waka_url'))
                                    <a href="{{ session('wa_waka_url') }}" target="_blank" class="dispen-act-btn dispen-act-wa" style="width: auto; height: 38px; padding: 0 16px; font-weight: 700; border-radius: 10px; gap: 6px;">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA ke Waka ({{ session('waka_nama') ?? 'Waka' }})
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ─── FORM INPUT PERMOHONAN DISPENSASI SISWA ─── -->
    <div class="dispen-card">
        <div class="dispen-card-header">
            <div class="dispen-card-header-left">
                <div class="dispen-card-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h2 class="dispen-card-title">Form Input Permohonan Dispensasi Siswa</h2>
                    <p class="dispen-card-subtitle">Input data siswa izin keluar sekolah & verifikasi persetujuan Waka</p>
                </div>
            </div>
            <div>
                <span class="dispen-pill-badge">
                    <i class="fa-solid fa-user-pen" style="color: #2563eb;"></i> Input Guru Piket
                </span>
            </div>
        </div>

        <div class="dispen-card-body">
            <form action="{{ route('piket.dispensasi-siswa.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateTimeInput(this);">
                @csrf
                
                <!-- Baris 1: Siswa & Waka -->
                <div class="dispen-form-grid">
                    <!-- Select Siswa -->
                    <div class="dispen-form-group">
                        <label class="dispen-label">
                            <span>Pilih Siswa Mengajukan Dispen <span class="req">*</span></span>
                        </label>
                        <select name="id_siswa" id="selectSiswa" class="select2-search" required style="width: 100%;">
                            <option value="">-- Cari Nama Siswa / NISN / Kelas --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->id_siswa }}" {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} - NISN: {{ $s->nisn ?? '-' }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Waka -->
                    <div class="dispen-form-group">
                        <label class="dispen-label">
                            <span>Pilih Waka Tujuan (Persetujuan) <span class="req">*</span></span>
                        </label>
                        <select name="id_user_waka" id="selectWaka" class="select2-search" required style="width: 100%;">
                            <option value="">-- Pilih Waka (Nama, NIP, No HP) --</option>
                            @foreach($wakaList as $w)
                                <option value="{{ $w->id }}" {{ old('id_user_waka') == $w->id ? 'selected' : '' }}>
                                    {{ $w->name }} @if($w->nip) (NIP: {{ $w->nip }}) @endif @if($w->no_hp) - HP: {{ $w->no_hp }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Baris 2: Tanggal, Jam Keluar, Jam Kembali -->
                <div class="dispen-form-grid-3">
                    <div class="dispen-form-group">
                        <label class="dispen-label">Tanggal Dispensasi <span class="req">*</span></label>
                        <div class="dispen-input-wrapper">
                            <i class="fa-regular fa-calendar-days dispen-input-icon"></i>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="dispen-input" required>
                        </div>
                    </div>

                    <div class="dispen-form-group">
                        <label class="dispen-label">Rencana Jam Keluar <span class="req">*</span></label>
                        <div class="dispen-input-wrapper">
                            <i class="fa-regular fa-clock dispen-input-icon"></i>
                            <input type="time" name="jam_keluar" id="jamKeluarInput" value="{{ old('jam_keluar', '08:00') }}" class="dispen-input" required>
                        </div>
                    </div>

                    <div class="dispen-form-group">
                        <label class="dispen-label">Rencana Jam Kembali <span class="req">*</span></label>
                        <div class="dispen-input-wrapper">
                            <i class="fa-solid fa-clock-rotate-left dispen-input-icon"></i>
                            <input type="time" name="jam_kembali" id="jamKembaliInput" value="{{ old('jam_kembali', '11:30') }}" class="dispen-input" required>
                        </div>
                    </div>
                </div>

                <!-- Baris 3: Alasan -->
                <div class="dispen-form-group" style="margin-bottom: 18px;">
                    <label class="dispen-label">Alasan / Keperluan Dispensasi <span class="req">*</span></label>
                    <div class="dispen-input-wrapper">
                        <i class="fa-regular fa-comment-dots dispen-input-icon" style="top: 14px;"></i>
                        <textarea name="alasan" rows="3" class="dispen-textarea" placeholder="Tuliskan alasan lengkap siswa izin keluar sekolah (misal: Lomba OSN, Berobat, Urusan Keluarga)..." required>{{ old('alasan') }}</textarea>
                    </div>
                </div>

                <!-- Baris 4: Upload Foto -->
                <div class="dispen-form-grid" style="margin-bottom: 12px;">
                    <!-- Foto Surat -->
                    <div class="dispen-upload-box" id="uploadBoxSurat">
                        <div class="dispen-upload-header">
                            <span class="dispen-upload-title">
                                <i class="fa-solid fa-file-lines" style="color: #2563eb;"></i> Upload Foto Surat Dispensasi Resmi
                            </span>
                            <span class="dispen-upload-badge optional">Opsional</span>
                        </div>
                        <div class="dispen-upload-body">
                            <label class="dispen-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Pilih Foto
                                <input type="file" name="foto_surat_dispen" id="fileSurat" accept="image/*" style="display: none;" onchange="handleFileChange(this, 'suratFileName', 'uploadBoxSurat')">
                            </label>
                            <span class="dispen-file-name" id="suratFileName">Belum ada file dipilih</span>
                        </div>
                        <span class="dispen-upload-hint">Format: JPG, JPEG, PNG, WEBP (Maks 4MB)</span>
                    </div>

                    <!-- Foto Kartu Identitas -->
                    <div class="dispen-upload-box" id="uploadBoxIdentitas">
                        <div class="dispen-upload-header">
                            <span class="dispen-upload-title">
                                <i class="fa-solid fa-address-card" style="color: #10b981;"></i> Upload Foto Kartu Pelajar / Identitas
                            </span>
                            <span class="dispen-upload-badge recommended">Sangat Disarankan</span>
                        </div>
                        <div class="dispen-upload-body">
                            <label class="dispen-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Pilih Foto
                                <input type="file" name="foto_kartu_identitas" id="fileIdentitas" accept="image/*" style="display: none;" onchange="handleFileChange(this, 'identitasFileName', 'uploadBoxIdentitas')">
                            </label>
                            <span class="dispen-file-name" id="identitasFileName">Belum ada file dipilih</span>
                        </div>
                        <span class="dispen-upload-hint">Foto kartu pelajar untuk verifikasi Satpam di gerbang sekolah</span>
                    </div>
                </div>

                <!-- Action Buttons Form -->
                <div class="dispen-form-actions">
                    <button type="reset" class="dispen-btn-reset" onclick="resetFileUploads()">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>
                    <button type="submit" class="dispen-btn-submit">
                        <i class="fa-solid fa-link"></i> Simpan Data & Buat Link Persetujuan Waka
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DAFTAR DATA SURAT DISPENSASI SISWA ─── -->
    <div class="dispen-card">
        <div class="dispen-card-header">
            <div class="dispen-card-header-left">
                <div class="dispen-card-icon">
                    <i class="fa-solid fa-table-list"></i>
                </div>
                <div>
                    <h2 class="dispen-card-title">Daftar Data Surat Dispensasi Siswa</h2>
                    <p class="dispen-card-subtitle">Riwayat dan monitoring status permohonan dispensasi siswa</p>
                </div>
            </div>
            <div>
                <span class="dispen-pill-badge">
                    <i class="fa-solid fa-database" style="color: #2563eb;"></i> Total Database: {{ $totalPengajuan }} Data
                </span>
            </div>
        </div>

        <!-- Filter & Toolbar Block -->
        <div class="dispen-filter-block">
            <!-- Baris 1: Form Filter -->
            <form action="{{ route('piket.dispensasi-siswa') }}" method="GET" class="dispen-filter-form">
                <!-- Search Box -->
                <div class="dispen-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Siswa, NISN, Kode..." class="dispen-search-input">
                </div>

                <!-- Dropdown Status Waka -->
                <select name="status" class="dispen-filter-select">
                    <option value="">Semua Status Waka</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Waka</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Waka</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak Waka</option>
                </select>

                <!-- Date Filter -->
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="dispen-filter-date">

                <!-- Filter Actions -->
                <div class="dispen-filter-actions">
                    <button type="submit" class="dispen-btn-filter-dark">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('piket.dispensasi-siswa') }}" class="dispen-btn-filter-reset">
                        <i class="fa-solid fa-rotate"></i> Reset Filter
                    </a>
                </div>
            </form>

            <!-- Baris 2: Action Toolbar -->
            <div class="dispen-action-toolbar">
                <div class="dispen-toolbar-left">
                    <div class="dispen-bulk-placeholder" id="bulkPlaceholder">
                        <i class="fa-solid fa-circle-info"></i> Pilih data pada tabel untuk opsi tindakan massal
                    </div>
                    <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="dispen-btn-bulk-del" style="display: none;">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <div class="dispen-toolbar-right">
                    @php
                        $trashCount = \App\Models\SiswaDispen::onlyTrashed()->count();
                    @endphp
                    <a href="{{ route('piket.dispensasi-siswa.trash') }}" class="dispen-btn-trash-link" title="Lihat Data Terhapus di Sampah">
                        <i class="fa-solid fa-trash-can"></i> Sampah
                        @if($trashCount > 0)
                            <span style="background: #f43f5e; color: #ffffff; font-size: 10px; padding: 1px 6px; border-radius: 10px; font-weight: 800; margin-left: 2px;">{{ $trashCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="dispen-table-wrapper">
            <table class="dispen-table">
                <thead>
                    <tr>
                        <th style="width: 38px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="dispen-checkbox" title="Pilih Semua">
                        </th>
                        <th style="width: 40px; text-align: center;">NO</th>
                        <th style="width: 100px;">NISN</th>
                        <th style="min-width: 160px;">NAMA SISWA</th>
                        <th style="width: 90px;">KELAS</th>
                        <th style="min-width: 140px;">TANGGAL & JAM</th>
                        <th style="min-width: 160px;">ALASAN / KEPERLUAN</th>
                        <th style="min-width: 140px;">WAKA TUJUAN</th>
                        <th style="width: 110px;">STATUS WAKA</th>
                        <th style="width: 150px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenList as $d)
                        @php
                            $statusDispen = $d->status_waka ?? $d->status_wali_kelas ?? 'pending';
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="dispen-checkbox" value="{{ $d->id_siswa_dispen }}" onchange="updateSelectedState()">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ ($dispenList->currentPage() - 1) * $dispenList->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-family: monospace; font-size: 11px; color: #64748b; font-weight: 600;">
                                {{ $d->siswa->nisn ?? '-' }}
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 750; color: #0f172a; font-size: 12px;">{{ $d->siswa->nama_siswa ?? '-' }}</span>
                                    <span style="font-family: monospace; font-size: 10.5px; color: #2563eb; font-weight: 700;">{{ $d->kode_dispen }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="display: inline-block; background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 6px; font-weight: 700; font-size: 11px; border: 1px solid #e2e8f0;">
                                    {{ $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-weight: 700; color: #334155; font-size: 11px;">
                                        <i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i> {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}
                                    </span>
                                    <span style="font-size: 10.5px; color: #d97706; font-weight: 700;">
                                        <i class="fa-regular fa-clock"></i> {{ $d->jam_keluar ?? '00:00' }} - {{ $d->jam_kembali ?? '00:00' }}
                                    </span>
                                </div>
                            </td>
                            <td style="max-width: 220px;">
                                <div style="color: #334155; font-size: 11px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $d->alasan }}">
                                    "{{ $d->alasan }}"
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 700; color: #1e293b; font-size: 11px;">{{ $d->nama_waka ?? ($d->wakaUser->name ?? '-') }}</span>
                                    @if($d->nip_waka)
                                        <span style="font-size: 10px; color: #64748b;">NIP: {{ $d->nip_waka }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($statusDispen === 'approved')
                                    <span class="status-badge status-approved">
                                        <i class="fa-solid fa-circle-check"></i> Disetujui
                                    </span>
                                @elseif($statusDispen === 'rejected')
                                    <span class="status-badge status-rejected">
                                        <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fa-solid fa-clock"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center; align-items: center; flex-wrap: nowrap;">
                                    @php
                                        $appUrl = url("/approval/dispen/{$d->token_wali_kelas}");
                                        $hpWaka = $d->no_hp_waka ?? ($d->wakaUser->no_hp ?? null);
                                        $waWakaLink = null;
                                        if ($hpWaka) {
                                            $hpFmt = preg_replace('/[^0-9]/', '', $hpWaka);
                                            if (str_starts_with($hpFmt, '0')) $hpFmt = '62' . substr($hpFmt, 1);
                                            $msgWa = "*PERMOHONAN PERSETUJUAN DISPENSASI SISWA*\n"
                                                . "Halo Bapak/Ibu Waka,\nAda permohonan dispensasi siswa (Kode: {$d->kode_dispen}, Siswa: " . ($d->siswa->nama_siswa ?? '-') . ").\nMohon verifikasi di link berikut:\n{$appUrl}";
                                            $waWakaLink = "https://api.whatsapp.com/send?phone={$hpFmt}&text=" . urlencode($msgWa);
                                        }
                                    @endphp

                                    <!-- Detail Button -->
                                    <button type="button" onclick="showDetailModal({{ json_encode($d) }})" class="dispen-act-btn dispen-act-detail" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Copy Link Button -->
                                    <button type="button" onclick="copyLink(`{{ $appUrl }}`)" class="dispen-act-btn dispen-act-link" title="Salin Link Approval Waka">
                                        <i class="fa-solid fa-link"></i>
                                    </button>

                                    <!-- WhatsApp Button (if pending) -->
                                    @if($waWakaLink && $statusDispen === 'pending')
                                        <a href="{{ $waWakaLink }}" target="_blank" class="dispen-act-btn dispen-act-wa" title="Kirim WA ke Waka">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif

                                    <!-- Barcode Button (if approved) -->
                                    @if($statusDispen === 'approved')
                                        <button type="button" onclick="showBarcodeModal({{ json_encode($d) }})" class="dispen-act-btn dispen-act-barcode" title="Lihat Barcode Satpam">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>
                                    @endif

                                    <!-- Edit Button (if pending) -->
                                    @if($statusDispen === 'pending')
                                        <button type="button" onclick="showEditModal({{ json_encode($d) }})" class="dispen-act-btn dispen-act-edit" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    @endif

                                    <!-- Delete Single Button -->
                                    <form action="{{ route('piket.dispensasi-siswa.destroy', $d->id_siswa_dispen) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Pindahkan data dispensasi siswa ini ke Sampah?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dispen-act-btn dispen-act-delete" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="dispen-empty-box">
                                    <div class="dispen-empty-icon">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <h3 class="dispen-empty-title">Belum ada data permohonan dispensasi siswa.</h3>
                                    <p class="dispen-empty-desc">Silakan buat pengajuan dispensasi baru melalui form di atas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dispenList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; background: #ffffff;">
                {{ $dispenList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ─── MODAL DETAIL DISPENSASI ─── -->
<div id="detailModal" class="dispen-modal-backdrop">
    <div class="dispen-modal-card">
        <div class="dispen-modal-header">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-id-card-clip" style="color: #60a5fa;"></i> Detail Permohonan Dispensasi
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeDetailModal()" style="cursor: pointer; font-size: 18px; color: #94a3b8; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'"></i>
        </div>
        <div class="dispen-modal-body" id="modalDetailContent">
            <!-- Dynamic Content via JS -->
        </div>
    </div>
</div>

<!-- ─── MODAL EDIT DISPENSASI ─── -->
<div id="editModal" class="dispen-modal-backdrop">
    <div class="dispen-modal-card">
        <div class="dispen-modal-header" style="background: #0f172a;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Edit Permohonan Dispensasi
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeEditModal()" style="cursor: pointer; font-size: 18px; color: #94a3b8; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'"></i>
        </div>
        <div class="dispen-modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data" onsubmit="return validateTimeInput(this);">
                @csrf
                @method('PUT')
                
                <div class="dispen-form-group" style="margin-bottom: 14px;">
                    <label class="dispen-label">Pilih Waka Tujuan (Persetujuan) <span class="req">*</span></label>
                    <select name="id_user_waka" id="editWaka" class="dispen-input" required style="padding-left: 12px;">
                        @foreach($wakaList as $w)
                            <option value="{{ $w->id }}">
                                {{ $w->name }} @if($w->nip) (NIP: {{ $w->nip }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                    <div class="dispen-form-group">
                        <label class="dispen-label">Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" id="editTanggal" class="dispen-input" required style="padding-left: 12px;">
                    </div>
                    <div class="dispen-form-group">
                        <label class="dispen-label">Jam Keluar <span class="req">*</span></label>
                        <input type="time" name="jam_keluar" id="editJamKeluar" class="dispen-input" required style="padding-left: 12px;">
                    </div>
                    <div class="dispen-form-group">
                        <label class="dispen-label">Jam Kembali <span class="req">*</span></label>
                        <input type="time" name="jam_kembali" id="editJamKembali" class="dispen-input" required style="padding-left: 12px;">
                    </div>
                </div>

                <div class="dispen-form-group" style="margin-bottom: 14px;">
                    <label class="dispen-label">Alasan Dispensasi <span class="req">*</span></label>
                    <textarea name="alasan" id="editAlasan" rows="3" class="dispen-textarea" required style="padding-left: 12px;"></textarea>
                </div>

                <div class="dispen-form-group" style="margin-bottom: 14px;">
                    <label class="dispen-label">Ganti Foto Surat Dispensasi Resmi (Opsional)</label>
                    <input type="file" name="foto_surat_dispen" accept="image/*" class="dispen-input" style="padding-left: 12px;">
                </div>

                <div class="dispen-form-group" style="margin-bottom: 20px;">
                    <label class="dispen-label">Ganti Foto Kartu Identitas Siswa / Pelajar (Opsional)</label>
                    <input type="file" name="foto_kartu_identitas" accept="image/*" class="dispen-input" style="padding-left: 12px;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeEditModal()" class="dispen-btn-reset">Batal</button>
                    <button type="submit" class="dispen-btn-submit" style="background: #f59e0b; border-color: #d97706;">
                        <i class="fa-solid fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ─── MODAL BARCODE SATPAM ─── -->
<div id="barcodeModal" class="dispen-modal-backdrop">
    <div class="dispen-modal-card">
        <div class="dispen-modal-header" style="background: #6d28d9;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-qrcode" style="color: #c4b5fd;"></i> Barcode Dispen Siswa (Sekali Pakai)
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeBarcodeModal()" style="cursor: pointer; font-size: 18px; color: #ddd6fe; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#ddd6fe'"></i>
        </div>
        <div class="dispen-modal-body" style="text-align: center;">
            <div id="barcodeModalContent">
                <!-- Dynamic Content via JS -->
            </div>
        </div>
    </div>
</div>

<!-- ─── MODAL KONFIRMASI HAPUS MASSAL ─── -->
<div id="bulkDeleteModal" class="dispen-modal-backdrop">
    <div class="dispen-modal-card" style="max-width: 440px;">
        <div class="dispen-modal-header" style="background: #ef4444; color: #ffffff;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeBulkDeleteModal()" style="cursor: pointer; font-size: 18px; color: #fee2e2;"></i>
        </div>
        <div class="dispen-modal-body" style="text-align: center; padding: 24px;">
            <div style="width: 54px; height: 54px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 24px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13px; color: #64748b; font-weight: 500; margin: 0 0 20px 0; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data dispensasi siswa yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="dispen-btn-reset">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" class="dispen-btn-submit" style="background: #ef4444; border-color: #dc2626;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Hapus Massal -->
<form id="bulkDeleteForm" action="{{ route('piket.dispensasi-siswa.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-search').select2({
        placeholder: "Cari & Pilih Data...",
        allowClear: true,
        width: '100%'
    });
});

function handleFileChange(input, nameElemId, boxId) {
    const nameElem = document.getElementById(nameElemId);
    const box = document.getElementById(boxId);
    if (input.files && input.files.length > 0) {
        nameElem.textContent = input.files[0].name;
        nameElem.style.color = '#10b981';
        nameElem.style.fontWeight = '700';
        if (box) box.classList.add('has-file');
    } else {
        nameElem.textContent = 'Belum ada file dipilih';
        nameElem.style.color = '#64748b';
        nameElem.style.fontWeight = 'normal';
        if (box) box.classList.remove('has-file');
    }
}

function resetFileUploads() {
    const suratText = document.getElementById('suratFileName');
    const identitasText = document.getElementById('identitasFileName');
    const boxSurat = document.getElementById('uploadBoxSurat');
    const boxIden = document.getElementById('uploadBoxIdentitas');

    if (suratText) {
        suratText.textContent = 'Belum ada file dipilih';
        suratText.style.color = '#64748b';
        suratText.style.fontWeight = 'normal';
    }
    if (identitasText) {
        identitasText.textContent = 'Belum ada file dipilih';
        identitasText.style.color = '#64748b';
        identitasText.style.fontWeight = 'normal';
    }
    if (boxSurat) boxSurat.classList.remove('has-file');
    if (boxIden) boxIden.classList.remove('has-file');

    $('#selectSiswa').val(null).trigger('change');
    $('#selectWaka').val(null).trigger('change');
}

function validateTimeInput(form) {
    const jamKeluar = form.querySelector('[name="jam_keluar"]').value;
    const jamKembali = form.querySelector('[name="jam_kembali"]').value;

    if (jamKeluar && jamKembali) {
        if (jamKembali <= jamKeluar) {
            alert('Validasi Gagal!\n\nRencana Jam Kembali (' + jamKembali + ') harus lebih akhir daripada Rencana Jam Keluar (' + jamKeluar + ').');
            return false;
        }
    }
    return true;
}

function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Link Persetujuan Waka berhasil disalin ke clipboard!\n\n' + url);
        }).catch(function(err) {
            fallbackCopyTextToClipboard(url);
        });
    } else {
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        alert('Link Persetujuan Waka berhasil disalin ke clipboard!\n\n' + text);
    } catch (err) {
        alert('Gagal menyalin link. Silakan salin secara manual: ' + text);
    }
    document.body.removeChild(textArea);
}

function showDetailModal(data) {
    const siswaNama = data.siswa ? data.siswa.nama_siswa : '-';
    const kelasNama = data.kelas ? data.kelas.nama_kelas : (data.siswa && data.siswa.kelas ? data.siswa.kelas.nama_kelas : '-');
    const wakaNama  = data.nama_waka ? data.nama_waka : (data.waka_user ? data.waka_user.name : '-');
    const nipWaka   = data.nip_waka ? data.nip_waka : '-';
    const appUrl    = `{{ url('/approval/dispen') }}/${data.token_wali_kelas}`;
    const status    = data.status_waka || data.status_wali_kelas || 'pending';

    let statusBadge = '<span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Menunggu Waka</span>';
    if (status === 'approved') {
        statusBadge = '<span class="status-badge status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka</span>';
    } else if (status === 'rejected') {
        statusBadge = '<span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka</span>';
    }

    let notesHtml = '';
    if (status === 'rejected') {
        notesHtml = `
            <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 10px; margin-top: 14px;">
                <div style="font-weight: 800; color: #991b1b; font-size: 11px; text-transform: uppercase;">Catatan Penolakan Waka:</div>
                <div style="font-weight: 600; color: #7f1d1d; margin-top: 4px; font-size: 13px;">"${data.catatan_waka || 'Tanpa Catatan'}"</div>
            </div>
        `;
    }

    let fotoKartuHtml = '';
    if (data.foto_kartu_identitas) {
        fotoKartuHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Foto Kartu Pelajar / Identitas</div>
                <a href="{{ asset('') }}${data.foto_kartu_identitas}" target="_blank">
                    <img src="{{ asset('') }}${data.foto_kartu_identitas}" style="width: 100%; max-height: 220px; object-fit: contain; background: #f8fafc; border-radius: 10px; border: 1px solid #cbd5e1;">
                </a>
            </div>
        `;
    }

    let fotoSuratHtml = '';
    if (data.foto_surat_dispen) {
        fotoSuratHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Foto Surat Dispensasi Resmi</div>
                <a href="{{ asset('') }}${data.foto_surat_dispen}" target="_blank">
                    <img src="{{ asset('') }}${data.foto_surat_dispen}" style="width: 100%; max-height: 220px; object-fit: contain; background: #f8fafc; border-radius: 10px; border: 1px solid #cbd5e1;">
                </a>
            </div>
        `;
    }

    const html = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0;">
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">KODE DISPENSASI</div>
                <div style="font-size: 18px; font-family: monospace; font-weight: 800; color: #2563eb;">${data.kode_dispen}</div>
            </div>
            <div>${statusBadge}</div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Nama Siswa</div>
                <div style="font-size: 14px; font-weight: 750; color: #0f172a;">${siswaNama}</div>
            </div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Kelas</div>
                <div style="font-size: 14px; font-weight: 700; color: #334155;">${kelasNama}</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Tanggal Dispensasi</div>
                <div style="font-size: 13px; font-weight: 700; color: #334155;">${data.tanggal}</div>
            </div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Waktu Keluar / Kembali</div>
                <div style="font-size: 13px; font-weight: 700; color: #d97706;">${data.jam_keluar || '00:00'} - ${data.jam_kembali || '00:00'}</div>
            </div>
        </div>

        <div style="margin-bottom: 14px;">
            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Alasan / Keperluan</div>
            <div style="font-size: 13px; background: #f8fafc; padding: 10px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600; color: #1e293b;">"${data.alasan}"</div>
        </div>

        <div style="margin-bottom: 14px;">
            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Waka Tujuan / Persetujuan</div>
            <div style="font-size: 13px; font-weight: 700; color: #1e293b;">${wakaNama} ${nipWaka !== '-' ? `(NIP: ${nipWaka})` : ''}</div>
        </div>

        ${fotoKartuHtml}
        ${fotoSuratHtml}
        ${notesHtml}

        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">

        <div>
            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">Link Persetujuan Waka</div>
            <div style="display: flex; gap: 8px;">
                <input type="text" value="${appUrl}" readonly class="dispen-input" style="font-family: monospace; font-size: 12px; padding-left: 12px;">
                <button type="button" onclick="copyLink('${appUrl}')" class="dispen-btn-submit" style="white-space: nowrap; padding: 8px 14px; font-size: 12px;">
                    <i class="fa-solid fa-copy"></i> Salin
                </button>
            </div>
        </div>
    `;

    document.getElementById('modalDetailContent').innerHTML = html;
    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function showEditModal(data) {
    const actionUrl = `{{ url('/guru-piket/dispensasi-siswa') }}/${data.id_siswa_dispen}`;
    document.getElementById('editForm').action = actionUrl;

    document.getElementById('editWaka').value = data.id_user_waka;
    document.getElementById('editTanggal').value = data.tanggal;
    document.getElementById('editJamKeluar').value = data.jam_keluar ? data.jam_keluar.replace('.', ':') : '08:00';
    document.getElementById('editJamKembali').value = data.jam_kembali ? data.jam_kembali.replace('.', ':') : '11:30';
    document.getElementById('editAlasan').value = data.alasan;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function showBarcodeModal(data) {
    const siswaNama = data.siswa ? data.siswa.nama_siswa : '-';
    const kelasNama = data.kelas ? data.kelas.nama_kelas : (data.siswa && data.siswa.kelas ? data.siswa.kelas.nama_kelas : '-');
    const qrUrl     = `https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=${encodeURIComponent(data.kode_dispen)}`;

    let statusBadge = '';
    if (data.status_satpam === 'belum_keluar') {
        statusBadge = `
            <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> BARCODE AKTIF (Sekali Pakai)
            </div>
        `;
    } else {
        statusBadge = `
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-lock" style="color: #dc2626;"></i> BARCODE SUDAH TERPAKAI / KADALUARSA
            </div>
        `;
    }

    let fotoKartuHtml = '';
    if (data.foto_kartu_identitas) {
        fotoKartuHtml = `
            <div style="margin-top: 14px; padding: 10px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 6px;"><i class="fa-solid fa-address-card" style="color: #10b981;"></i> Foto Kartu Identitas / Pelajar:</div>
                <img src="{{ asset('') }}${data.foto_kartu_identitas}" style="max-height: 140px; border-radius: 6px; border: 1px solid #cbd5e1;">
            </div>
        `;
    }

    const html = `
        <div style="margin-bottom: 12px;">
            ${statusBadge}
        </div>

        <div style="font-size: 20px; font-family: monospace; font-weight: 800; color: #6d28d9; margin-bottom: 4px;">${data.kode_dispen}</div>
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">${siswaNama}</div>
        <div style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelas ${kelasNama} | ${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'}</div>

        <div style="background: #ffffff; padding: 14px; border-radius: 16px; border: 2px dashed #7c3aed; display: inline-block; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.12);">
            <img src="${qrUrl}" alt="QR Code Barcode Dispen" style="width: 200px; height: 200px; display: block;">
        </div>

        ${fotoKartuHtml}

        <div style="background: #f3e8ff; border: 1px solid #d8b4fe; padding: 10px 14px; border-radius: 10px; margin-top: 16px; text-align: left; font-size: 11.5px; color: #6b21a8; font-weight: 600;">
            <i class="fa-solid fa-circle-info"></i> <strong>Instruksi Satpam:</strong><br>
            Siswa menunjukkan Barcode ini & Kartu Pelajar kepada Satpam saat melewati pintu gerbang sekolah untuk discan & divalidasi keluar.
        </div>
    `;

    document.getElementById('barcodeModalContent').innerHTML = html;
    document.getElementById('barcodeModal').style.display = 'flex';
}

function closeBarcodeModal() {
    document.getElementById('barcodeModal').style.display = 'none';
}

function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.dispen-checkbox:not(#selectAllCheckbox)');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateSelectedState();
}

function updateSelectedState() {
    const checkboxes = document.querySelectorAll('.dispen-checkbox:not(#selectAllCheckbox)');
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:not(#selectAllCheckbox):checked');
    const btnBulk = document.getElementById('btnBulkDelete');
    const bulkPlaceholder = document.getElementById('bulkPlaceholder');
    const selectedCountSpan = document.getElementById('selectedCount');
    const selectAllCb = document.getElementById('selectAllCheckbox');

    const count = checkedBoxes.length;
    if (selectedCountSpan) selectedCountSpan.textContent = count;

    if (selectAllCb && checkboxes.length > 0) {
        selectAllCb.checked = (checkboxes.length === count);
    }

    if (btnBulk && bulkPlaceholder) {
        if (count > 0) {
            btnBulk.style.display = 'inline-flex';
            bulkPlaceholder.style.display = 'none';
        } else {
            btnBulk.style.display = 'none';
            bulkPlaceholder.style.display = 'inline-flex';
        }
    }
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:not(#selectAllCheckbox):checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan pilih minimal satu data dispensasi yang mau dihapus.');
        return;
    }

    document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

function executeBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:not(#selectAllCheckbox):checked');
    const container = document.getElementById('bulkDeleteInputsContainer');
    container.innerHTML = '';

    checkedBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });

    document.getElementById('bulkDeleteForm').submit();
}
</script>
@endsection
