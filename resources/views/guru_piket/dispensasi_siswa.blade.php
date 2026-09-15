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

<<<<<<< HEAD
    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }

    .card-custom-body {
        padding: 24px;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Tombol Simpan Navy Modern Konsisten (Sesuai Gambar media_1788625196097.png) */
    .btn-submit-navy, .btn-submit-custom {
        background: #2b3957;
        color: #ffffff;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(43, 57, 87, 0.25);
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-submit-navy:hover, .btn-submit-custom:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(30, 41, 59, 0.35);
    }

    /* Tombol Reset Form Abu-abu Muda (Sesuai Gambar media_1788624975339.png) */
    .btn-reset-light {
        background: #e2e8f0;
        color: #334155;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-reset-light:hover {
        background: #cbd5e1;
        color: #0f172a;
=======
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

<<<<<<< HEAD
    .action-btn-wa { background: #25d366; color: #ffffff; }
    .action-btn-wa:hover { background: #1da851; color: #ffffff; }
    .action-btn-copy { background: #3b82f6; color: #ffffff; }
    .action-btn-copy:hover { background: #2563eb; color: #ffffff; }
    .action-btn-barcode { background: #64748b; color: #ffffff; border: 1px solid #475569; }
    .action-btn-barcode:hover { background: #475569; color: #ffffff; border-color: #334155; }
    .action-btn-edit { background: #f59e0b; color: #ffffff; }
    .action-btn-edit:hover { background: #d97706; color: #ffffff; }
    .action-btn-delete { background: #ef4444; color: #ffffff; }
    .action-btn-delete:hover { background: #dc2626; color: #ffffff; }
=======
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

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
    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .mobile-page-topbar,
    .mobile-dispen-stat-carousel-wrap,
    .mobile-dispen-section,
    #mobileFilterModal,
    .dispen-btn-text-short {
        display: none !important;
    }

    @media (max-width: 768px) {
        .dispen-desktop-table-card,
        .dispen-desktop-stat-grid,
        .dispen-btn-text-full {
            display: none !important;
        }

        .mobile-page-topbar {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #e2e8f0;
        }

        .mobile-back-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3a8a;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .mobile-back-btn:active {
            background: #eff6ff;
            transform: scale(0.95);
        }

        .mobile-topbar-title-wrap {
            flex: 1;
            min-width: 0;
        }

        .mobile-topbar-title {
            font-size: 17px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .mobile-topbar-sub {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            display: block;
            margin-top: 1px;
        }

        .m-btn-trash-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            padding: 5px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            color: #e11d48;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            flex-shrink: 0;
        }

        .m-trash-badge {
            background: #e11d48;
            color: #ffffff;
            font-size: 9.5px;
            padding: 1px 5px;
            border-radius: 9999px;
            font-weight: 800;
        }

        .mobile-dispen-stat-carousel-wrap,
        .mobile-dispen-section {
            display: flex !important;
        }

        #mobileFilterModal.active {
            display: flex !important;
        }

        .dispen-btn-text-short {
            display: inline !important;
        }

        .dispen-page-container {
            padding-bottom: 24px;
        }

        /* Mobile Stat Cards Carousel */
        .mobile-dispen-stat-carousel-wrap {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .mobile-dispen-stat-container {
            position: relative;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            touch-action: pan-y;
            background: transparent;
        }

        .mobile-dispen-stat-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }

        .mobile-dispen-stat-slide {
            flex: 0 0 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .mobile-dispen-stat-slide .dispen-stat-card {
            width: 100%;
            margin: 0;
            border-radius: 16px;
            padding: 16px 18px;
            box-sizing: border-box;
        }

        .m-stat-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            transition: opacity 0.25s ease, transform 0.2s ease, visibility 0.25s ease;
        }

        .mobile-dispen-stat-container:hover .m-stat-arrow,
        .mobile-dispen-stat-container.is-hovered .m-stat-arrow {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
        }

        .m-stat-arrow:hover,
        .m-stat-arrow:active {
            color: #2563eb;
            background: #f8fafc;
            transform: translateY(-50%) scale(0.92);
        }

        .m-stat-prev { left: 8px; }
        .m-stat-next { right: 8px; }

        .mobile-dispen-stat-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .m-stat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .m-stat-dot.active {
            width: 20px;
            height: 6px;
            border-radius: 9999px;
            background: #2563eb;
        }

        /* Card & Form on Mobile */
        .dispen-card {
            border-radius: 16px;
            margin-bottom: 16px;
        }

        .dispen-card-header {
            padding: 14px 16px;
        }

        .dispen-card-body {
            padding: 16px;
        }

        .dispen-form-grid, .dispen-form-grid-3 {
            grid-template-columns: 1fr !important;
            gap: 14px;
        }

        .dispen-input, .dispen-textarea, .select2-container .select2-selection--single {
            min-height: 42px !important;
            font-size: 13px !important;
        }

        .select2-container--default .select2-selection--single {
            height: 42px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .dispen-form-actions {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 8px !important;
            margin-top: 16px;
            padding-top: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .dispen-btn-reset, .dispen-btn-submit {
            width: 100% !important;
            justify-content: center !important;
            height: 42px !important;
            min-height: 42px !important;
            padding: 0 8px !important;
            font-size: 12.5px !important;
            border-radius: 10px !important;
            gap: 6px !important;
            white-space: nowrap !important;
            box-sizing: border-box !important;
        }

        /* Mobile Section: Filter Card + Cards List */
        .mobile-dispen-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .mobile-dispen-filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mobile-dispen-filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .m-card-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .mobile-dispen-search-row {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .m-search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .m-search-input-box {
            position: relative;
            flex: 1;
            min-width: 0;
        }

        .m-search-input-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }

        .m-search-input {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px 0 34px !important;
            font-size: 12.5px;
            color: #1e293b;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .m-search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .m-btn-filter-trigger {
            height: 38px;
            padding: 0 16px;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
            transition: background 0.15s ease;
            position: relative;
        }

        .m-btn-filter-trigger:hover,
        .m-btn-filter-trigger:active {
            background: #1d4ed8;
        }

        .m-filter-active-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34d399;
            border: 1.5px solid #ffffff;
            margin-left: 2px;
        }

        /* Mobile Cards List */
        .mobile-dispen-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .mobile-dispen-card-item {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px 16px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .mobile-dispen-card-item.is-approved {
            border-left: 4px solid #10b981;
        }

        .mobile-dispen-card-item.is-pending {
            border-left: 4px solid #f59e0b;
        }

        .mobile-dispen-card-item.is-rejected {
            border-left: 4px solid #ef4444;
        }

        .m-dispen-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .m-dispen-title-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .m-dispen-student-name {
            font-size: 14px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-dispen-meta-sub {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .m-dispen-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .m-dispen-info-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .m-dispen-info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.02em;
        }

        .m-dispen-info-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .m-dispen-alasan-box {
            background: #f8fafc;
            border-left: 3px solid #cbd5e1;
            padding: 8px 12px;
            border-radius: 0 8px 8px 0;
            font-size: 12px;
            font-style: italic;
            color: #475569;
            line-height: 1.4;
        }

        .m-dispen-action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px dashed #e2e8f0;
            margin-top: 2px;
        }

        .m-btn-detail-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: #2563eb;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .m-btn-detail-link:active {
            background: #dbeafe;
            transform: scale(0.97);
        }

        .m-dispen-quick-icons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .m-dispen-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .m-dispen-icon-btn.m-btn-link:hover {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .m-dispen-icon-btn.m-btn-wa {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .m-dispen-icon-btn.m-btn-barcode {
            background: #fdf4ff;
            color: #9333ea;
            border-color: #f0abfc;
        }

        .m-dispen-icon-btn.m-btn-edit {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
        }

        .m-dispen-icon-btn.m-btn-del {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Modal Filter Mobile Bottom Sheet */
        .mobile-filter-modal-wrap {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 99999;
            display: none;
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }

        .mobile-filter-sheet {
            background: #ffffff;
            border-radius: 20px 20px 0 0;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: sheetSlideUp 0.25s ease-out;
            max-height: 85vh;
        }

        @keyframes sheetSlideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .mobile-filter-sheet-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-filter-sheet-title {
            font-size: 15px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mobile-filter-sheet-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            overflow-y: auto;
        }

        .mobile-filter-actions-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }

        .mobile-filter-sheet-close {
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            font-size: 14px;
        }
    }
<<<<<<< HEAD
    .modal-header { padding: 18px 24px; background: #384972; color: #ffffff; display: flex; align-items: center; justify-content: space-between; }
    .modal-body { padding: 24px; max-height: 80vh; overflow-y: auto; }
    @keyframes pulseRed {
        0% { opacity: 1; transform: scale(1); }
        100% { opacity: 0.3; transform: scale(0.85); }
    }
=======
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
</style>
@endsection

@section('content')
<<<<<<< HEAD
<div class="guru-izin-container">
    
    <!-- Top Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-id-card-clip" style="color: #2563eb;"></i> Dispensasi Siswa</h1>
            <p>Input data permohonan izin dispensasi siswa oleh Guru Piket & verifikasi persetujuan Waka Kesiswaan</p>
=======
<div class="dispen-page-container">

    <!-- ─── MOBILE TOPBAR (TITLE + SAMPAH PILL) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Dispensasi Siswa</h1>
            <span class="mobile-topbar-sub">Kelola permohonan dispen siswa</span>
        </div>
        <div class="mobile-topbar-right">
            @php
                $trashCount = \App\Models\SiswaDispen::onlyTrashed()->count();
            @endphp
            <a href="{{ route('piket.dispensasi-siswa.trash') }}" class="m-btn-trash-pill" title="Sampah">
                <i class="fa-solid fa-trash-can"></i>
                <span>Sampah</span>
                @if($trashCount > 0)
                    <span class="m-trash-badge">{{ $trashCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- ─── TOP 4 STAT CARDS DATA CALCULATION ─── -->
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

    <!-- ─── MOBILE 4-STAT CAROUSEL (SWIPEABLE + DOT INDICATORS) ─── -->
    <div class="mobile-dispen-stat-carousel-wrap">
        <div class="mobile-dispen-stat-container" id="mobileDispenStatContainer">
            <button type="button" class="m-stat-arrow m-stat-prev" onclick="prevDispenStatSlide()" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-stat-arrow m-stat-next" onclick="nextDispenStatSlide()" aria-label="Berikutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div class="mobile-dispen-stat-track" id="mobileDispenStatTrack">
                <!-- Slide 1: Total Pengajuan -->
                <div class="mobile-dispen-stat-slide">
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
                </div>

                <!-- Slide 2: Disetujui -->
                <div class="mobile-dispen-stat-slide">
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
                </div>

                <!-- Slide 3: Menunggu -->
                <div class="mobile-dispen-stat-slide">
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
                </div>

                <!-- Slide 4: Ditolak -->
                <div class="mobile-dispen-stat-slide">
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
            </div>
        </div>

        <!-- Carousel Dots -->
        <div class="mobile-dispen-stat-dots" id="mobileDispenStatDots">
            <span class="m-stat-dot active" onclick="goToDispenStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToDispenStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToDispenStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToDispenStatSlide(3)"></span>
        </div>
    </div>

    <!-- ─── TOP 4 STAT CARDS DESKTOP ─── -->
    <div class="dispen-desktop-stat-grid">
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
                                Link Persetujuan Waka Kesiswaan telah berhasil dibuat. Silakan kirimkan link di bawah kepada Waka Kesiswaan untuk verifikasi NIP & Password:
                            </p>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <input type="text" id="successApprovalUrlInput" value="{{ session('approval_url') }}" readonly class="dispen-input" style="flex: 1; background: #ffffff; border-color: #a7f3d0; font-family: monospace; font-weight: 700; color: #065f46; padding-left: 14px;">
                                <button type="button" onclick="copyLink(`{{ session('approval_url') }}`)" class="dispen-act-btn dispen-act-detail" style="width: auto; height: 38px; padding: 0 16px; font-weight: 700; border-radius: 10px; gap: 6px;">
                                    <i class="fa-solid fa-copy"></i> Salin Link
                                </button>
                                @if(session('wa_waka_url'))
<<<<<<< HEAD
                                    <a href="{{ session('wa_waka_url') }}" target="_blank" class="action-btn action-btn-wa" style="padding: 10px 16px; font-size: 12.5px;">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA ke Waka Kesiswaan ({{ session('waka_nama') ?? 'Waka Kesiswaan' }})
=======
                                    <a href="{{ session('wa_waka_url') }}" target="_blank" class="dispen-act-btn dispen-act-wa" style="width: auto; height: 38px; padding: 0 16px; font-weight: 700; border-radius: 10px; gap: 6px;">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA ke Waka ({{ session('waka_nama') ?? 'Waka' }})
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
<<<<<<< HEAD
        <div class="card-custom-body">
            <form id="formDispensasiSiswa" action="{{ route('piket.dispensasi-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden Inputs from Surat Dispen Pop-up Modal -->
                <input type="hidden" name="id_guru_piket_select" id="hiddenIdGuruPiket">
                <input type="hidden" name="nama_guru_piket" id="hiddenNamaGuruPiket">
                <input type="hidden" name="nip_guru_piket" id="hiddenNipGuruPiket">
                <input type="hidden" name="ttd_siswa_data" id="hiddenTtdSiswaData">
                <input type="hidden" name="ttd_guru_piket_data" id="hiddenTtdGuruPiketData">
                <input type="hidden" name="kode_dispen" id="hiddenKodeDispen">

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 18px;">
                    
=======

        <div class="dispen-card-body">
            <form action="{{ route('piket.dispensasi-siswa.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateTimeInput(this);">
                @csrf
                
                <!-- Baris 1: Siswa & Waka -->
                <div class="dispen-form-grid">
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                    <!-- Select Siswa -->
                    <div class="dispen-form-group">
                        <label class="dispen-label">
                            <span>Pilih Siswa Mengajukan Dispen <span class="req">*</span></span>
                        </label>
                        <select name="id_siswa" id="selectSiswa" class="select2-search" required style="width: 100%;">
                            <option value="">-- Cari Nama Siswa / NISN / Kelas --</option>
                            @foreach($siswaList as $s)
                                @php
                                    $namaJurusan = $s->kelas->jurusan->nama_jurusan ?? ($s->kelas->nama_jurusan ?? 'Manajemen Perkantoran dan Layanan Bisnis');
                                @endphp
                                <option value="{{ $s->id_siswa }}" 
                                        data-nama="{{ $s->nama_siswa }}" 
                                        data-nisn="{{ $s->nisn ?? ($s->nis ?? '-') }}" 
                                        data-kelas="{{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }}"
                                        data-jurusan="{{ $namaJurusan }}"
                                        {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} - NISN: {{ $s->nisn ?? '-' }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

<<<<<<< HEAD
                    <!-- Select Waka Kesiswaan Tujuan (Role Waka Kesiswaan) -->
                    <div>
                        <label class="form-label-custom">Pilih Waka Kesiswaan Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
                        <select name="id_user_waka" id="selectWaka" class="form-control-custom select2-search" required style="width: 100%;">
                            <option value="">-- Pilih Waka Kesiswaan (Nama, NIP, No HP) --</option>
=======
                    <!-- Select Waka -->
                    <div class="dispen-form-group">
                        <label class="dispen-label">
                            <span>Pilih Waka Tujuan (Persetujuan) <span class="req">*</span></span>
                        </label>
                        <select name="id_user_waka" id="selectWaka" class="select2-search" required style="width: 100%;">
                            <option value="">-- Pilih Waka (Nama, NIP, No HP) --</option>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                            @foreach($wakaList as $w)
                                <option value="{{ $w->id }}" {{ old('id_user_waka') == $w->id ? 'selected' : '' }}>
                                    {{ $w->name }} @if($w->nip) (NIP: {{ $w->nip }}) @endif @if($w->no_hp) - HP: {{ $w->no_hp }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

<<<<<<< HEAD
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 18px;">
                    <!-- Tanggal -->
                    <div>
                        <label class="form-label-custom">Tanggal Dispensasi <span style="color: #dc2626;">*</span></label>
                        <input type="date" name="tanggal" id="inputTanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control-custom" required>
=======
                <!-- Baris 2: Tanggal, Jam Keluar, Jam Kembali -->
                <div class="dispen-form-grid-3">
                    <div class="dispen-form-group">
                        <label class="dispen-label">Tanggal Dispensasi <span class="req">*</span></label>
                        <div class="dispen-input-wrapper">
                            <i class="fa-regular fa-calendar-days dispen-input-icon"></i>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="dispen-input" required>
                        </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

<<<<<<< HEAD
                <!-- Alasan Dispensasi -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label-custom">Alasan / Keperluan Dispensasi <span style="color: #dc2626;">*</span></label>
                    <textarea name="alasan" id="inputAlasan" rows="3" class="form-control-custom" placeholder="Tuliskan alasan lengkap siswa izin keluar sekolah (misal: Mengikuti Lomba OSN Tingkat Kabupaten, Berobat, Urusan Keluarga)..." required>{{ old('alasan') }}</textarea>
                </div>

                <!-- Tempat / Lokasi Kegiatan -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label-custom">Tempat / Lokasi Kegiatan Dispensasi <span style="color: #64748b; font-weight: 500;">(Opsional)</span></label>
                    <input type="text" name="tempat" id="inputTempat" class="form-control-custom" placeholder="Misal: Aula Dinas Pendidikan Kabupaten Tulungagung / Lapangan Olahraga / Rumah Sakit" value="{{ old('tempat') }}">
                </div>

                <!-- Input Hidden Foto Siswa Live Base64 dari Kamera (Wajib Live) -->
                <input type="hidden" name="foto_siswa_live" id="inputFotoSiswaLive" value="">

                <!-- Fitur Ambil Foto Siswa (wajib live) Sesuai media_1788699849946.png -->
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom" style="font-size: 13.5px; font-weight: 800; color: #1e293b; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span>Ambil Foto Siswa (wajib live) <span style="color: #dc2626;">*</span></span>
                        <span id="badgeFotoLiveStatus" style="display: none; font-size: 11.5px; font-weight: 700; color: #166534; background: #dcfce7; border: 1px solid #86efac; padding: 2px 8px; border-radius: 6px;">
                            <i class="fa-solid fa-circle-check"></i> Foto Live Terpasang
                        </span>
                    </label>

                    <div id="boxTriggerCamera" onclick="openLiveCameraModal()" style="width: 100%; min-height: 125px; background: #e5e7eb; border: 1.5px dashed #9ca3af; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; padding: 18px; box-sizing: border-box; position: relative;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#3b82f6';" onmouseout="if(!document.getElementById('inputFotoSiswaLive').value){ this.style.background='#e5e7eb'; this.style.borderColor='#9ca3af'; }">
                        
                        <!-- State Belum Ada Foto (Icon Kamera Besar Sesuai media_1788699849946.png) -->
                        <div id="cameraEmptyState" style="text-align: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 58px; height: 58px; margin: 0 auto; display: block;">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                            <div style="font-size: 13px; font-weight: 700; color: #334155; margin-top: 8px;">
                                Klik di sini untuk membuka kamera &amp; ambil foto siswa secara live
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                Wajib jepret langsung dari kamera perangkat (bukan file lokal) &bull; Otomatis terhubung ke Satpam &amp; WhatsApp
                            </div>
                        </div>

                        <!-- State Sudah Ada Foto Terjepret -->
                        <div id="cameraFilledState" style="display: none; width: 100%; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap;">
                            <img id="previewFotoSiswaLive" src="" alt="Foto Siswa Live" style="max-height: 140px; max-width: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #2563eb; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                            <div style="text-align: left;">
                                <div style="font-size: 13.5px; font-weight: 800; color: #166534; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-circle-check" style="font-size: 16px; color: #16a34a;"></i> Foto Siswa Berhasil Diambil Secara Live
                                </div>
                                <div style="font-size: 11.5px; color: #475569; margin: 4px 0 12px 0; font-weight: 600;">
                                    Foto siap tersimpan &amp; akan otomatis terkirim ke Portal Satpam saat Waka Kesiswaan menyetujui.
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <button type="button" onclick="event.stopPropagation(); openLiveCameraModal();" class="action-btn" style="background: #2563eb; color: #ffffff; padding: 7px 16px; font-size: 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-camera-rotate"></i> Foto Ulang
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); hapusFotoSiswaLive();" class="action-btn" style="background: #ef4444; color: #ffffff; padding: 7px 16px; font-size: 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Upload Foto (Surat Dispen & Kartu Identitas / Pelajar) -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div>
                        <label class="form-label-custom">
                            <i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Upload Foto Surat Dispensasi Resmi <span style="color: #64748b; font-weight: 500;">(Opsional)</span>
                        </label>
                        <input type="file" name="foto_surat_dispen" accept="image/*" class="form-control-custom" style="background: #ffffff;">
                        <span style="font-size: 11px; color: #64748b;">Format: JPG, PNG, WEBP (Max 4MB)</span>
                    </div>

                    <div>
                        <label class="form-label-custom">
                            <i class="fa-solid fa-address-card" style="color: #10b981;"></i> Upload Foto Kartu Identitas Siswa / Kartu Pelajar <span style="color: #2563eb; font-weight: 700;">(Sangat Disarankan)</span>
                        </label>
                        <input type="file" name="foto_kartu_identitas" accept="image/*" class="form-control-custom" style="background: #ffffff;">
                        <span style="font-size: 11px; color: #64748b;">Foto Kartu Pelajar untuk verifikasi Satpam di pintu gerbang sekolah.</span>
                    </div>
                </div>

                <!-- Action Buttons: Reset Form (Kiri) & Simpan Data (Kanan) -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                    <button type="button" onclick="resetFormDispensasiSiswa()" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Form</span>
                    </button>

                    <button type="button" onclick="openModalSuratDispenInput()" class="btn-submit-navy">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Simpan Data &amp; Buat Link Persetujuan Waka Kesiswaan</span>
=======
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
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="dispen-btn-text-full">Reset Form</span>
                        <span class="dispen-btn-text-short">Reset</span>
                    </button>
                    <button type="submit" class="dispen-btn-submit">
                        <i class="fa-solid fa-link"></i>
                        <span class="dispen-btn-text-full">Simpan Data & Buat Link Persetujuan Waka</span>
                        <span class="dispen-btn-text-short">Simpan & Link</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DAFTAR DATA SURAT DISPENSASI SISWA (DESKTOP VIEW) ─── -->
    <div class="dispen-card dispen-desktop-table-card">
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

<<<<<<< HEAD
        <!-- Filter Bar -->
        <div style="padding: 16px 24px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <form action="{{ route('piket.dispensasi-siswa') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama Siswa, NISN, Kode..." class="form-control-custom" style="width: 240px; background: #ffffff;">
                <select name="status" class="form-control-custom" style="width: 200px; background: #ffffff;">
                    <option value="">-- Semua Status Waka Kesiswaan --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Waka Kesiswaan</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Waka Kesiswaan</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak Waka Kesiswaan</option>
=======
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
<<<<<<< HEAD
                        <th style="padding: 14px 18px; font-weight: 800;">KODE & SISWA</th>
                        <th style="padding: 14px 18px; font-weight: 800;">TANGGAL & JAM</th>
                        <th style="padding: 14px 18px; font-weight: 800;">ALASAN DISPEN</th>
                        <th style="padding: 14px 18px; font-weight: 800;">FOTO SISWA / IDENTITAS / SURAT</th>
                        <th style="padding: 14px 18px; font-weight: 800;">WAKA KESISWAAN</th>
                        <th style="padding: 14px 18px; font-weight: 800;">STATUS WAKA KESISWAAN</th>
                        <th style="padding: 14px 18px; font-weight: 800; text-align: center;">AKSI</th>
=======
                        <th style="width: 40px; text-align: center;">NO</th>
                        <th style="width: 100px;">NISN</th>
                        <th style="min-width: 160px;">NAMA SISWA</th>
                        <th style="width: 90px;">KELAS</th>
                        <th style="min-width: 140px;">TANGGAL & JAM</th>
                        <th style="min-width: 160px;">ALASAN / KEPERLUAN</th>
                        <th style="min-width: 140px;">WAKA TUJUAN</th>
                        <th style="width: 110px;">STATUS WAKA</th>
                        <th style="width: 150px; text-align: center;">AKSI</th>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
<<<<<<< HEAD
                            <td style="padding: 14px 18px;">
                                <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                    @if($d->foto_siswa_live)
                                        <a href="{{ asset($d->foto_siswa_live) }}" target="_blank" title="Lihat Foto Live Siswa (Kamera Pos Piket)">
                                            <div style="position: relative; display: inline-block;">
                                                <img src="{{ asset($d->foto_siswa_live) }}" style="width: 42px; height: 42px; object-fit: cover; border-radius: 8px; border: 2px solid #2563eb; box-shadow: 0 2px 6px rgba(37,99,235,0.25);">
                                                <span style="position: absolute; bottom: -3px; right: -3px; background: #2563eb; color: #fff; font-size: 7.5px; padding: 1px 3px; border-radius: 3px; font-weight: 800; line-height: 1;"><i class="fa-solid fa-camera"></i> LIVE</span>
                                            </div>
                                        </a>
                                    @endif
                                    @if($d->foto_kartu_identitas)
                                        <a href="{{ asset($d->foto_kartu_identitas) }}" target="_blank" title="Lihat Foto Kartu Pelajar">
                                            <img src="{{ asset($d->foto_kartu_identitas) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                        </a>
                                    @endif
                                    @if($d->foto_surat_dispen)
                                        <a href="{{ asset($d->foto_surat_dispen) }}" target="_blank" title="Lihat Foto Surat Dispensasi">
                                            <img src="{{ asset($d->foto_surat_dispen) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #10b981;">
                                        </a>
                                    @endif
                                    @if(!$d->foto_siswa_live && !$d->foto_kartu_identitas && !$d->foto_surat_dispen)
                                        <span style="font-size: 11.5px; color: #94a3b8; font-style: italic;">Tanpa Foto</span>
=======
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 700; color: #1e293b; font-size: 11px;">{{ $d->nama_waka ?? ($d->wakaUser->name ?? '-') }}</span>
                                    @if($d->nip_waka)
                                        <span style="font-size: 10px; color: #64748b;">NIP: {{ $d->nip_waka }}</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
                                                . "Halo Bapak/Ibu Waka Kesiswaan,\nAda permohonan dispensasi siswa (Kode: {$d->kode_dispen}, Siswa: " . ($d->siswa->nama_siswa ?? '-') . ").\nMohon verifikasi di link berikut:\n{$appUrl}";
                                            $waWakaLink = "https://api.whatsapp.com/send?phone={$hpFmt}&text=" . urlencode($msgWa);
                                        }
                                    @endphp

<<<<<<< HEAD
                                    @if($waWakaLink && $d->status_waka === 'pending')
                                        <a href="{{ $waWakaLink }}" target="_blank" class="action-btn action-btn-wa" title="Kirim WA ke Waka Kesiswaan">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif

                                    <button type="button" onclick="copyLink(`{{ $appUrl }}`)" class="action-btn action-btn-copy" title="Salin Link Approval Waka Kesiswaan">
                                        <i class="fa-solid fa-link"></i> Link
                                    </button>

                                    <button type="button" onclick="showDetailModal({{ json_encode($d) }})" class="action-btn" style="background: #384972; color: #fff;" title="Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    @if($d->status_waka === 'approved')
                                        <button type="button" onclick="showBarcodeModal({{ json_encode($d) }})" class="action-btn action-btn-barcode" title="Lihat Barcode Dispen (Sekali Pakai)">
                                            <i class="fa-solid fa-qrcode"></i> Barcode
=======
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

    <!-- ─── DAFTAR DATA DISPENSASI SISWA (MOBILE VIEW: CARD LIST) ─── -->
    <div class="mobile-dispen-section">
        <!-- Mobile Filter Card -->
        <div class="mobile-dispen-filter-card">
            <div class="mobile-dispen-filter-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="m-card-icon-wrap">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 14.5px; font-weight: 800; color: #1e3a8a; margin: 0;">Riwayat Dispensasi</h2>
                        <span style="font-size: 11px; font-weight: 600; color: #64748b;">Total {{ $totalPengajuan }} Pengajuan Dispen</span>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Row -->
            <div class="mobile-dispen-search-row">
                <form action="{{ route('piket.dispensasi-siswa') }}" method="GET" class="m-search-form">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('tanggal'))
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    @endif
                    <div class="m-search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari siswa, NISN, kode..." class="m-search-input">
                    </div>
                    <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Filter</span>
                        @if(request('status') || request('tanggal') || request('q'))
                            <span class="m-filter-active-dot"></span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Card List -->
        <div class="mobile-dispen-cards-list">
            @forelse($dispenList as $d)
                @php
                    $statusDispen = $d->status_waka ?? $d->status_wali_kelas ?? 'pending';
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

                <div class="mobile-dispen-card-item is-{{ $statusDispen }}">
                    <!-- Card Top: Avatar/Icon + Name + Status Badge -->
                    <div class="m-dispen-header-row">
                        <div class="m-dispen-title-box">
                            <div class="m-card-icon-wrap" style="width: 38px; height: 38px;">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div style="min-width: 0; flex: 1;">
                                <div class="m-dispen-student-name">{{ $d->siswa->nama_siswa ?? '-' }}</div>
                                <div class="m-dispen-meta-sub">
                                    <span style="background: #f1f5f9; padding: 1px 6px; border-radius: 5px; font-weight: 700; color: #475569;">
                                        {{ $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? '-') }}
                                    </span>
                                    <span>•</span>
                                    <span style="font-family: monospace; font-weight: 700; color: #2563eb;">{{ $d->kode_dispen }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($statusDispen === 'approved')
                                <span class="status-badge status-approved" style="font-size: 11px; padding: 4px 9px;">
                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                </span>
                            @elseif($statusDispen === 'rejected')
                                <span class="status-badge status-rejected" style="font-size: 11px; padding: 4px 9px;">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @else
                                <span class="status-badge status-pending" style="font-size: 11px; padding: 4px 9px;">
                                    <i class="fa-solid fa-clock"></i> Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Info Grid: Tanggal & Waktu, Waka -->
                    <div class="m-dispen-info-grid">
                        <div class="m-dispen-info-cell">
                            <span class="m-dispen-info-label"><i class="fa-regular fa-calendar-days"></i> Tanggal</span>
                            <span class="m-dispen-info-val">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</span>
                        </div>
                        <div class="m-dispen-info-cell">
                            <span class="m-dispen-info-label"><i class="fa-regular fa-clock"></i> Jam Keluar - Kembali</span>
                            <span class="m-dispen-info-val" style="color: #d97706;">{{ $d->jam_keluar ?? '00:00' }} - {{ $d->jam_kembali ?? '00:00' }}</span>
                        </div>
                        <div class="m-dispen-info-cell" style="grid-column: 1 / -1;">
                            <span class="m-dispen-info-label"><i class="fa-solid fa-user-tie"></i> Waka Tujuan</span>
                            <span class="m-dispen-info-val">{{ $d->nama_waka ?? ($d->wakaUser->name ?? '-') }} @if($d->nip_waka) <span style="font-weight: normal; font-size: 11px; color: #64748b;">(NIP: {{ $d->nip_waka }})</span> @endif</span>
                        </div>
                    </div>

                    <!-- Alasan / Keperluan -->
                    <div class="m-dispen-alasan-box">
                        "{{ $d->alasan }}"
                    </div>

                    <!-- Barcode indicator if approved -->
                    @if($statusDispen === 'approved')
                        <div style="display: flex; align-items: center; justify-content: space-between; background: #faf5ff; border: 1px solid #f3e8ff; border-radius: 10px; padding: 6px 10px;">
                            <span style="font-size: 11px; font-weight: 700; color: #7e22ce; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-qrcode"></i> Barcode Validasi Satpam
                            </span>
                            <button type="button" onclick="showBarcodeModal({{ json_encode($d) }})" style="border: none; background: #9333ea; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                Tampilkan
                            </button>
                        </div>
                    @endif

                    <!-- Action Row -->
                    <div class="m-dispen-action-row">
                        <button type="button" onclick="showDetailModal({{ json_encode($d) }})" class="m-btn-detail-link">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                        </button>

                        <div class="m-dispen-quick-icons">
                            <!-- Salin Link Button -->
                            <button type="button" onclick="copyLink(`{{ $appUrl }}`)" class="m-dispen-icon-btn m-btn-link" title="Salin Link Persetujuan">
                                <i class="fa-solid fa-link"></i>
                            </button>

                            <!-- WhatsApp Button (if pending) -->
                            @if($waWakaLink && $statusDispen === 'pending')
                                <a href="{{ $waWakaLink }}" target="_blank" class="m-dispen-icon-btn m-btn-wa" title="Kirim WA ke Waka">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif

                            <!-- Edit Button (if pending) -->
                            @if($statusDispen === 'pending')
                                <button type="button" onclick="showEditModal({{ json_encode($d) }})" class="m-dispen-icon-btn m-btn-edit" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            @endif

                            <!-- Delete to trash Button (Option A) -->
                            <form action="{{ route('piket.dispensasi-siswa.destroy', $d->id_siswa_dispen) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Pindahkan data dispensasi siswa ini ke Sampah?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-dispen-icon-btn m-btn-del" title="Hapus ke Sampah">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dispen-card" style="border-radius: 16px; padding: 32px 16px; text-align: center;">
                    <div class="dispen-empty-icon" style="margin: 0 auto 12px auto;">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <h3 class="dispen-empty-title">Belum ada permohonan dispensasi</h3>
                    <p class="dispen-empty-desc">Gunakan form di atas untuk mencatat pengajuan izin keluar siswa.</p>
                </div>
            @endforelse

            @if($dispenList->hasPages())
                <div style="padding: 12px; background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0;">
                    {{ $dispenList->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<<<<<<< HEAD
<!-- Modal Live Camera Capture (Wajib Live dari Kamera Perangkat) -->
<div id="liveCameraModal" class="modal-backdrop-custom" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(8px); z-index: 100000; align-items: center; justify-content: center; padding: 16px;">
    <div class="modal-card" style="max-width: 580px; width: 100%; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); border: 1px solid #334155;">
        <!-- Header -->
        <div class="modal-header" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #ffffff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #334155;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #2563eb; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(37,99,235,0.4);">
                    <i class="fa-solid fa-camera fa-lg" style="color: #ffffff;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; letter-spacing: -0.01em;">Ambil Foto Siswa Secara Live</h3>
                    <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Wajib live menggunakan kamera aktif (webcam/kamera HP)</span>
                </div>
            </div>
            <button type="button" onclick="closeLiveCameraModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; font-size: 20px; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" title="Tutup Kamera">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body" style="padding: 24px; text-align: center; background: #0b1120;">
            <!-- Alert / Error Camera -->
            <div id="cameraErrorAlert" style="display: none; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 16px; text-align: left;">
                <i class="fa-solid fa-triangle-exclamation"></i> <span id="cameraErrorMessage">Akses kamera gagal dibuka. Pastikan izin kamera telah diberikan di browser Anda.</span>
            </div>

            <!-- Viewport Container Kamera -->
            <div style="position: relative; width: 100%; aspect-ratio: 4/3; max-height: 380px; background: #000000; border-radius: 14px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: inset 0 0 25px rgba(0,0,0,0.8); border: 2px solid #1e293b;">
                <!-- Live Video Feed -->
                <video id="liveCameraVideo" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                
                <!-- Captured Snapshot Canvas (Hidden) -->
                <canvas id="liveCameraCanvas" style="display: none;"></canvas>

                <!-- Captured Image Preview (Shown after snap) -->
                <img id="liveCameraSnapshotPreview" src="" alt="Hasil Jepretan Siswa" style="display: none; width: 100%; height: 100%; object-fit: cover;">

                <!-- Framing Guide saat video aktif -->
                <div id="cameraFaceGuide" style="position: absolute; width: 180px; height: 230px; border: 2.5px dashed rgba(255,255,255,0.85); border-radius: 50%; pointer-events: none; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.35);">
                    <div style="position: absolute; bottom: -28px; width: 100%; text-align: center; color: #ffffff; font-size: 11px; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.9); letter-spacing: 0.3px;">
                        POSISI WAJAH SISWA
                    </div>
                </div>

                <!-- Status Badge Live -->
                <div id="cameraLiveBadge" style="position: absolute; top: 12px; left: 12px; background: rgba(220, 38, 38, 0.9); color: #ffffff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.4);">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff; display: inline-block; animation: pulseRed 1s infinite alternate;"></span> LIVE KAMERA
                </div>
            </div>

            <!-- Controls Area -->
            <div style="margin-top: 20px;">
                <!-- State 1: Streaming (Sebelum Jepret) -->
                <div id="cameraStreamControls" style="display: flex; gap: 12px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="switchCameraFacing()" id="btnSwitchCam" class="action-btn" style="background: #1e293b; color: #e2e8f0; border: 1px solid #334155; padding: 12px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer;" title="Putar Kamera Depan / Belakang">
                        <i class="fa-solid fa-camera-rotate"></i> Putar Kamera
                    </button>
                    <button type="button" onclick="takeSnapshotLive()" class="btn-submit-navy" style="padding: 13px 32px; font-size: 14.5px; background: #2563eb; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 16px rgba(37,99,235,0.4);">
                        <i class="fa-solid fa-camera"></i> Jepret Foto Siswa
                    </button>
                </div>

                <!-- State 2: Post-Snap (Setelah Jepret) -->
                <div id="cameraPreviewControls" style="display: none; gap: 12px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="retakeLiveSnapshot()" class="action-btn" style="background: #1e293b; color: #f1f5f9; border: 1px solid #475569; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-rotate-left"></i> Foto Ulang (Retake)
                    </button>
                    <button type="button" onclick="confirmLiveSnapshot()" class="btn-submit-navy" style="background: #16a34a; padding: 13px 28px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 4px 16px rgba(22,163,74,0.4);">
                        <i class="fa-solid fa-check"></i> Gunakan Foto Ini &amp; Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Dispensasi -->
<div id="detailModal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-id-card"></i> Detail Dispensasi Siswa</h3>
            <i class="fa-solid fa-xmark" onclick="closeDetailModal()" style="cursor: pointer; font-size: 18px;"></i>
=======
<!-- ─── MODAL FILTER MOBILE (BOTTOM SHEET) ─── -->
<div id="mobileFilterModal" class="mobile-filter-modal-wrap">
    <div class="mobile-filter-sheet">
        <div class="mobile-filter-sheet-header">
            <h3 class="mobile-filter-sheet-title">
                <i class="fa-solid fa-sliders" style="color: #2563eb;"></i> Filter Dispensasi Siswa
            </h3>
            <button type="button" class="mobile-filter-sheet-close" onclick="closeMobileFilterModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
        <form action="{{ route('piket.dispensasi-siswa') }}" method="GET" class="mobile-filter-sheet-body">
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 6px;">Pencarian Kata Kunci</label>
                <div style="position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama siswa, NISN, atau kode..." class="dispen-input" style="padding-left: 36px; height: 42px; border-radius: 10px;">
                </div>
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 6px;">Status Verifikasi Waka</label>
                <select name="status" class="dispen-input" style="height: 42px; border-radius: 10px;">
                    <option value="">Semua Status Waka</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Waka</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Waka</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak Waka</option>
                </select>
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 6px;">Tanggal Dispensasi</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="dispen-input" style="height: 42px; border-radius: 10px;">
            </div>

            <div class="mobile-filter-actions-row">
                <a href="{{ route('piket.dispensasi-siswa') }}" class="dispen-btn-reset" style="height: 42px; justify-content: center; text-decoration: none; display: flex; align-items: center;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="dispen-btn-submit" style="height: 42px; justify-content: center;">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </div>
        </form>
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
                
<<<<<<< HEAD
                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Pilih Waka Kesiswaan Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
                    <select name="id_user_waka" id="editWaka" class="form-control-custom" required>
=======
                <div class="dispen-form-group" style="margin-bottom: 14px;">
                    <label class="dispen-label">Pilih Waka Tujuan (Persetujuan) <span class="req">*</span></label>
                    <select name="id_user_waka" id="editWaka" class="dispen-input" required style="padding-left: 12px;">
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

<<<<<<< HEAD
                <!-- Foto Siswa Live Edit -->
                <input type="hidden" name="foto_siswa_live" id="editFotoSiswaLive" value="">
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Foto Siswa (Live Kamera)</label>
                    <div style="display: flex; gap: 12px; align-items: center; background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <img id="editPreviewFotoSiswaLive" src="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid #2563eb; display: none;">
                        <span id="editNoFotoText" style="font-size: 12px; color: #94a3b8; font-style: italic;">Belum ada foto live</span>
                        <button type="button" onclick="openLiveCameraModal('editFotoSiswaLive', 'editPreviewFotoSiswaLive')" class="action-btn" style="background: #2563eb; color: #ffffff; font-size: 11.5px; padding: 7px 12px; margin-left: auto; border-radius: 8px; cursor: pointer;">
                            <i class="fa-solid fa-camera"></i> Buka Kamera &amp; Foto Ulang
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Ganti Foto Surat Dispensasi Resmi (Opsional)</label>
                    <input type="file" name="foto_surat_dispen" accept="image/*" class="form-control-custom">
=======
                <div class="dispen-form-group" style="margin-bottom: 14px;">
                    <label class="dispen-label">Ganti Foto Surat Dispensasi Resmi (Opsional)</label>
                    <input type="file" name="foto_surat_dispen" accept="image/*" class="dispen-input" style="padding-left: 12px;">
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

<<<<<<< HEAD
<!-- Modal Barcode Single-Use Dispensasi -->
<div id="barcodeModal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); color: #ffffff;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-qrcode"></i> Barcode Dispen Siswa (Sekali Pakai)</h3>
            <i class="fa-solid fa-xmark" onclick="closeBarcodeModal()" style="cursor: pointer; font-size: 18px;"></i>
=======
<!-- ─── MODAL BARCODE SATPAM ─── -->
<div id="barcodeModal" class="dispen-modal-backdrop">
    <div class="dispen-modal-card">
        <div class="dispen-modal-header" style="background: #6d28d9;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-qrcode" style="color: #c4b5fd;"></i> Barcode Dispen Siswa (Sekali Pakai)
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeBarcodeModal()" style="cursor: pointer; font-size: 18px; color: #ddd6fe; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#ddd6fe'"></i>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
        <div class="dispen-modal-body" style="text-align: center;">
            <div id="barcodeModalContent">
                <!-- Dynamic Content via JS -->
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Modal Pop-Up Lembar Surat Dispensasi Siswa (Format media_1788623102688.png) -->
<div id="modalSuratDispenInput" class="modal-backdrop-custom" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
    <div class="modal-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 740px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); position: relative; padding: 36px 42px; font-family: 'Times New Roman', Times, serif; color: #000000; box-sizing: border-box; max-height: 90vh; overflow-y: auto;">
        
        <button type="button" onclick="closeModalSuratDispenInput()" style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; font-size: 20px; color: #475569; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Tutup">&times;</button>

        <!-- Kop Surat Resmi SMKN 1 Boyolangu -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <img src="{{ asset('images/logo_sekolah.jpeg') }}" style="width: 80px; height: auto; object-fit: contain;" onerror="this.src='{{ asset('logo_sekolah.jpeg') }}'">
            <div style="flex: 1; text-align: center; line-height: 1.25;">
                <div style="font-size: 13.5px; font-weight: 700; letter-spacing: 0.5px;">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div style="font-size: 18px; font-weight: 900; letter-spacing: 1px; margin-top: 2px;">SMK NEGERI 1 BOYOLANGU</div>
                <div style="font-size: 12px; font-weight: 800; letter-spacing: 0.5px;">SEKOLAH KEJURUAN NEGERI UNGGULAN</div>
                <div style="font-size: 10.5px; margin-top: 3px; color: #1e293b;">Jl. Ki Mangunsarkoro VI/3, Beji, Kecamatan Boyolangu<br>Kabupaten Tulungagung, Jawa Timur 66233</div>
                <div style="font-size: 10px; color: #334155; margin-top: 2px;">Telp. (0355) 323021 / 323024 | Website: https://smkn1boyolangu.sch.id/</div>
                <div style="font-size: 10.5px; font-weight: 700;">NPSN: 20537286</div>
            </div>
            <div style="width: 80px;"></div>
        </div>

        <!-- Double Divider Line -->
        <div style="border-top: 3px solid #000000; border-bottom: 1px solid #000000; height: 3px; margin: 10px 0 18px 0;"></div>

        <!-- Judul Surat -->
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 14pt; font-weight: 900; text-decoration: underline; letter-spacing: 0.5px;">SURAT DISPENSASI SISWA</div>
            <div style="font-size: 11pt; margin-top: 4px;">Nomor: 421.3/<span id="suratKodeDispenSpan">DSP-...</span>/SMKN1.BYL/{{ date('Y') }}</div>
        </div>

        <!-- Tujuan / Kepada Yth -->
        <div style="font-size: 11.5pt; line-height: 1.5; margin-bottom: 12px;">
            Kepada Yth.<br>
            Bapak/Ibu Guru Piket<br>
            SMK Negeri 1 Boyolangu<br>
            di tempat
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; text-align: justify; margin-bottom: 10px;">
            Dengan hormat,<br>
            Berdasarkan permohonan izin dari orang tua/wali siswa dan sehubungan dengan keperluan kegiatan yang tidak dapat ditinggalkan, maka dengan ini kami mohon agar siswa berikut diberikan dispensasi (izin tidak mengikuti kegiatan pembelajaran) pada waktu yang telah ditentukan.
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; margin-bottom: 4px;">
            Adapun data siswa yang mengajukan dispensasi adalah sebagai berikut:
        </div>

        <!-- Tabel Data Siswa & Pasfoto Siswa Live -->
        <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 12px;">
            <table style="flex: 1; border-collapse: collapse; font-size: 11.5pt; padding-left: 10px;">
                <tr>
                    <td style="width: 170px; padding: 2.5px 0;">Nama</td>
                    <td style="width: 15px; text-align: center;">:</td>
                    <td style="font-weight: 700; text-transform: uppercase;" id="suratNamaSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">NISN</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratNisnSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">Kelas</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratKelasSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">Program Keahlian</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratJurusanSiswaSpan">-</td>
                </tr>
            </table>

            <div id="suratFotoLiveContainer" style="text-align: center; border: 1.5px solid #334155; padding: 4px; border-radius: 6px; background: #f8fafc; width: 85px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <img id="suratFotoLiveImg" src="" alt="Foto Siswa Live" style="width: 77px; height: 98px; object-fit: cover; border-radius: 4px; display: block;">
                <span style="font-size: 7.5pt; font-family: sans-serif; font-weight: 800; color: #1e3a8a; margin-top: 3px; display: block; letter-spacing: 0.5px;">LIVE FOTO</span>
            </div>
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; margin-bottom: 4px;">
            Untuk diberikan dispensasi agar tidak mengikuti proses kegiatan belajar mengajar di sekolah selama kegiatan berlangsung, dengan keterangan sebagai berikut:
        </div>

        <!-- Tabel Keterangan -->
        <table style="width: 100%; border-collapse: collapse; font-size: 11.5pt; margin-bottom: 14px; padding-left: 10px;">
            <tr>
                <td style="width: 170px; padding: 2.5px 0;">Hari / Tanggal</td>
                <td style="width: 15px; text-align: center;">:</td>
                <td id="suratHariTanggalSpan">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Pukul</td>
                <td style="text-align: center;">:</td>
                <td id="suratPukulSpan">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Keperluan</td>
                <td style="text-align: center;">:</td>
                <td id="suratKeperluanSpan" style="font-weight: 700;">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Tempat</td>
                <td style="text-align: center;">:</td>
                <td id="suratTempatSpan">-</td>
            </tr>
        </table>

        <div style="font-size: 11.5pt; line-height: 1.55; text-align: justify; margin-bottom: 16px;">
            Demikian surat dispensasi ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </div>

        <!-- Tanggal Surat -->
        <div style="text-align: right; font-size: 11.5pt; margin-bottom: 8px;">
            Boyolangu, <span id="suratTanggalCetakSpan">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</span>
        </div>

        <!-- 2 Kolom Tanda Tangan: Guru Piket (Kiri) & Siswa (Kanan) - WAJIB DIISI -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; text-align: center; margin-top: 10px;">
            <!-- Left: Guru Piket -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="font-size: 11.5pt;">Hormat kami,</div>
                <div style="font-size: 11.5pt; font-weight: 700; margin-bottom: 4px;">Guru Piket</div>
                
                <!-- Dropdown Guru Piket dari TU Master Data dengan Fitur Cari & Reset Cari -->
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; text-align: left; width: 100%; margin-bottom: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label style="font-size: 11px; font-weight: 700; color: #334155;">
                            Pilih Guru Piket Bertugas: <span style="color: #dc2626;">*</span>
                        </label>
                        <span id="guruPiketSearchCount" style="font-size: 10.5px; color: #64748b; font-weight: 600;">(149 Guru)</span>
                    </div>

                    <!-- Input Fitur Cari Data Guru & Tombol Reset Cari -->
                    <div style="display: flex; gap: 6px; margin-bottom: 6px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #94a3b8;"></i>
                            <input type="text" id="modalSearchGuruPiketInput" placeholder="Ketik cari nama guru / NIP..." 
                                oninput="filterGuruPiketOptions(this.value)" 
                                style="width: 100%; padding: 6px 10px 6px 28px; font-size: 11.5px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s ease;">
                        </div>
                        <button type="button" onclick="resetSearchGuruPiket()" title="Reset Pencarian Guru" 
                            style="background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; transition: all 0.15s ease;">
                            <i class="fa-solid fa-rotate-left"></i> Reset Cari
                        </button>
                    </div>

                    <!-- Dropdown Select Guru Piket -->
                    <select id="modalSelectGuruPiket" class="form-control-custom" style="font-size: 12px; padding: 7px 10px; background: #f8fafc; width: 100%;" onchange="updateGuruPiketDisplay()">
                        <option value="">-- Pilih Guru Piket (Nama & NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" data-nama="{{ $g->nama_guru }}" data-nip="{{ $g->nip ?: '-' }}" {{ (Auth::check() && Auth::user()->nip == $g->nip) ? 'selected' : '' }}>
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Canvas TTD Guru Piket -->
                <div id="wrapperCanvasPiket" style="border: 2px dashed #94a3b8; border-radius: 8px; background: #ffffff; height: 110px; position: relative; cursor: crosshair; touch-action: none; width: 100%; box-sizing: border-box; transition: all 0.2s ease;">
                    <canvas id="modalCanvasPiket" style="width: 100%; height: 100%; display: block; border-radius: 6px;"></canvas>
                    <div id="modalHintPiket" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 11px; font-weight: 600; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i class="fa-solid fa-pen-nib" style="margin-right: 5px; color: #2563eb;"></i> Guru Piket tanda tangan di sini (sentuh / mouse)
                    </div>
                </div>

                <div style="margin-top: 6px;">
                    <div style="font-weight: 800; text-decoration: underline; font-size: 11.5pt;" id="suratNamaGuruPiketDisplay">Pilih Guru Piket</div>
                    <div style="font-size: 11pt; color: #1e293b;" id="suratNipGuruPiketDisplay">NIP. -</div>
                </div>
            </div>

            <!-- Right: Siswa -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="font-size: 11.5pt;">Yang mengajukan izin,</div>
                <div style="font-size: 11.5pt; font-weight: 700; margin-bottom: 4px;">Siswa</div>
                
                <!-- Spacer to balance dropdown & search box on left -->
                <div style="height: 74px;"></div>

                <!-- Canvas TTD Siswa -->
                <div id="wrapperCanvasSiswa" style="border: 2px dashed #94a3b8; border-radius: 8px; background: #ffffff; height: 110px; position: relative; cursor: crosshair; touch-action: none; width: 100%; box-sizing: border-box; transition: all 0.2s ease;">
                    <canvas id="modalCanvasSiswa" style="width: 100%; height: 100%; display: block; border-radius: 6px;"></canvas>
                    <div id="modalHintSiswa" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 11px; font-weight: 600; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i class="fa-solid fa-pen-nib" style="margin-right: 5px; color: #2563eb;"></i> Siswa tanda tangan di sini (sentuh / mouse)
                    </div>
                </div>

                <div style="margin-top: 6px;">
                    <div style="font-weight: 800; text-decoration: underline; font-size: 11.5pt;" id="suratNamaSiswaDisplay">-</div>
                    <div style="font-size: 11pt; color: #1e293b;" id="suratNisnSiswaDisplay">NISN. -</div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Bawah Modal -->
        <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; font-family: 'Plus Jakarta Sans', sans-serif;">
            <button type="button" onclick="closeModalSuratDispenInput()" class="action-btn" style="background: #e2e8f0; color: #334155; padding: 10px 18px; font-size: 13px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali / Batal
            </button>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="button" onclick="resetInputSignatures()" class="action-btn" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; padding: 10px 18px; font-size: 13px; font-weight: 700; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Tanda Tangan
                </button>

                <button type="button" onclick="submitFinalDispensasiForm()" class="btn-submit-navy" style="padding: 11px 24px; font-size: 13.5px; border-radius: 12px;">
                    <i class="fa-solid fa-link"></i> Simpan Data &amp; Buat Link Persetujuan Waka Kesiswaan
                </button>
            </div>
        </div>

    </div>
</div>

=======
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

>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
let currentDispenStatSlide = 0;
const totalDispenStatSlides = 4;

function updateDispenStatCarousel() {
    const track = document.getElementById('mobileDispenStatTrack');
    const dots = document.querySelectorAll('#mobileDispenStatDots .m-stat-dot');
    if (track) {
        track.style.transform = `translateX(-${currentDispenStatSlide * 100}%)`;
    }
    dots.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === currentDispenStatSlide);
    });
}

function nextDispenStatSlide() {
    currentDispenStatSlide = (currentDispenStatSlide + 1) % totalDispenStatSlides;
    updateDispenStatCarousel();
}

function prevDispenStatSlide() {
    currentDispenStatSlide = (currentDispenStatSlide - 1 + totalDispenStatSlides) % totalDispenStatSlides;
    updateDispenStatCarousel();
}

function goToDispenStatSlide(index) {
    currentDispenStatSlide = index;
    updateDispenStatCarousel();
}

function initDispenStatCarousel() {
    const container = document.getElementById('mobileDispenStatContainer');
    if (!container) return;

    let touchStartX = 0;
    let touchEndX = 0;

    container.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    container.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        const swipeThreshold = 40;
        if (touchEndX < touchStartX - swipeThreshold) {
            nextDispenStatSlide();
        } else if (touchEndX > touchStartX + swipeThreshold) {
            prevDispenStatSlide();
        }
    }, { passive: true });
}

function openMobileFilterModal() {
    const modal = document.getElementById('mobileFilterModal');
    if (modal) modal.classList.add('active');
}

function closeMobileFilterModal() {
    const modal = document.getElementById('mobileFilterModal');
    if (modal) modal.classList.remove('active');
}

window.addEventListener('click', function(e) {
    const filterModal = document.getElementById('mobileFilterModal');
    if (e.target === filterModal) closeMobileFilterModal();
});

$(document).ready(function() {
    $('.select2-search').select2({
        placeholder: "Cari & Pilih Data...",
        allowClear: true,
        width: '100%'
    });
<<<<<<< HEAD
    initGuruPiketOptionsCache();
});

// ─── Live Camera Capture System (Wajib Live dari Perangkat) ───────────────────
let currentCameraStream = null;
let currentFacingMode = 'user'; // 'user' (depan/webcam) atau 'environment' (belakang)
let currentCapturedBase64 = null;
let currentCameraTargetInput = 'inputFotoSiswaLive';
let currentCameraTargetPreview = 'previewFotoSiswaLive';
=======
    initDispenStatCarousel();
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

async function openLiveCameraModal(targetInputId = 'inputFotoSiswaLive', targetPreviewId = 'previewFotoSiswaLive') {
    currentCameraTargetInput = targetInputId;
    currentCameraTargetPreview = targetPreviewId;
    const modal = document.getElementById('liveCameraModal');
    if (!modal) return;
    
    modal.style.display = 'flex';
    document.getElementById('cameraErrorAlert').style.display = 'none';
    
    // Reset state tampilan modal
    document.getElementById('liveCameraVideo').style.display = 'block';
    document.getElementById('liveCameraSnapshotPreview').style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'block';
    document.getElementById('cameraLiveBadge').style.display = 'flex';
    document.getElementById('cameraStreamControls').style.display = 'flex';
    document.getElementById('cameraPreviewControls').style.display = 'none';
    
    await startCameraStream(currentFacingMode);
}

async function startCameraStream(facingMode) {
    stopCurrentCameraStream();
    
    try {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Browser atau perangkat ini tidak mendukung akses kamera secara langsung (getUserMedia tidak tersedia atau bukan koneksi HTTPS / Localhost).');
        }
        
        const constraints = {
            video: {
                facingMode: facingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: false
        };
        
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        currentCameraStream = stream;
        const video = document.getElementById('liveCameraVideo');
        video.srcObject = stream;
        await video.play();
    } catch (err) {
        console.error('Kamera Error:', err);
        const errAlert = document.getElementById('cameraErrorAlert');
        const errMsg = document.getElementById('cameraErrorMessage');
        let text = 'Gagal mengakses kamera perangkat: ' + (err.message || err.name);
        if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
            text = 'Akses izin kamera ditolak oleh browser. Silakan klik ikon gembok di sebelah kiri address bar URL browser Anda, pilih Izinkan (Allow) Akses Kamera, lalu coba buka kembali.';
        } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
            text = 'Tidak ditemukan perangkat kamera (webcam) yang aktif di komputer/laptop atau HP ini.';
        }
        errMsg.textContent = text;
        errAlert.style.display = 'block';
    }
}

function stopCurrentCameraStream() {
    if (currentCameraStream) {
        currentCameraStream.getTracks().forEach(track => track.stop());
        currentCameraStream = null;
    }
    const video = document.getElementById('liveCameraVideo');
    if (video) video.srcObject = null;
}

function closeLiveCameraModal() {
    stopCurrentCameraStream();
    const modal = document.getElementById('liveCameraModal');
    if (modal) modal.style.display = 'none';
}

async function switchCameraFacing() {
    currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
    await startCameraStream(currentFacingMode);
}

function takeSnapshotLive() {
    const video = document.getElementById('liveCameraVideo');
    const canvas = document.getElementById('liveCameraCanvas');
    if (!video || !video.videoWidth) {
        alert('Kamera belum siap atau streaming belum aktif. Silakan tunggu 1 detik lalu coba kembali.');
        return;
    }
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    
    // Jika mirror facing user
    if (currentFacingMode === 'user') {
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
    }
    
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    currentCapturedBase64 = canvas.toDataURL('image/jpeg', 0.9);
    
    // Tampilkan preview hasil jepretan
    const previewImg = document.getElementById('liveCameraSnapshotPreview');
    previewImg.src = currentCapturedBase64;
    previewImg.style.display = 'block';
    video.style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'none';
    document.getElementById('cameraLiveBadge').style.display = 'none';
    
    document.getElementById('cameraStreamControls').style.display = 'none';
    document.getElementById('cameraPreviewControls').style.display = 'flex';
}

function retakeLiveSnapshot() {
    currentCapturedBase64 = null;
    document.getElementById('liveCameraVideo').style.display = 'block';
    document.getElementById('liveCameraSnapshotPreview').style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'block';
    document.getElementById('cameraLiveBadge').style.display = 'flex';
    
    document.getElementById('cameraStreamControls').style.display = 'flex';
    document.getElementById('cameraPreviewControls').style.display = 'none';
}

function confirmLiveSnapshot() {
    if (!currentCapturedBase64) return;
    
    const targetInput = document.getElementById(currentCameraTargetInput);
    if (targetInput) targetInput.value = currentCapturedBase64;
    
    const targetPreview = document.getElementById(currentCameraTargetPreview);
    if (targetPreview) {
        targetPreview.src = currentCapturedBase64;
        targetPreview.style.display = 'block';
    }
    
    if (currentCameraTargetInput === 'inputFotoSiswaLive') {
        document.getElementById('cameraEmptyState').style.display = 'none';
        document.getElementById('cameraFilledState').style.display = 'flex';
        document.getElementById('badgeFotoLiveStatus').style.display = 'inline-flex';
        
        const box = document.getElementById('boxTriggerCamera');
        if (box) {
            box.style.background = '#f0fdf4';
            box.style.borderColor = '#16a34a';
            box.style.borderStyle = 'solid';
            box.style.boxShadow = 'none';
        }
    } else if (currentCameraTargetInput === 'editFotoSiswaLive') {
        const noFoto = document.getElementById('editNoFotoText');
        if (noFoto) noFoto.style.display = 'none';
    }
    
    closeLiveCameraModal();
}

function hapusFotoSiswaLive() {
    document.getElementById('inputFotoSiswaLive').value = '';
    document.getElementById('previewFotoSiswaLive').src = '';
    document.getElementById('cameraEmptyState').style.display = 'block';
    document.getElementById('cameraFilledState').style.display = 'none';
    document.getElementById('badgeFotoLiveStatus').style.display = 'none';
    
    const box = document.getElementById('boxTriggerCamera');
    if (box) {
        box.style.background = '#e5e7eb';
        box.style.borderColor = '#9ca3af';
        box.style.borderStyle = 'dashed';
    }
}

// Signature Pad Utility State
const padState = {};

function initSignaturePad(canvasId, hintId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    // Adjust canvas resolution to element width
    const rect = canvas.parentElement.getBoundingClientRect();
    canvas.width = rect.width || 320;
    canvas.height = 110;

    const ctx = canvas.getContext('2d');
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.strokeStyle = '#0f172a';

    let isDrawing = false;
    padState[canvasId] = { hasDrawn: false };

    function getPos(e) {
        const r = canvas.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: (clientX - r.left) * (canvas.width / r.width),
            y: (clientY - r.top) * (canvas.height / r.height)
        };
    }

    function start(e) {
        isDrawing = true;
        padState[canvasId].hasDrawn = true;
        const hint = document.getElementById(hintId);
        if (hint) hint.style.display = 'none';

        // Feedback visual saat mulai tanda tangan (border hijau)
        if (canvas.parentElement) {
            canvas.parentElement.style.borderColor = '#16a34a';
            canvas.parentElement.style.backgroundColor = '#f0fdf4';
        }

        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        if (e.cancelable && e.type.startsWith('touch')) e.preventDefault();
    }

    function move(e) {
        if (!isDrawing) return;
        const pos = getPos(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        if (e.cancelable && e.type.startsWith('touch')) e.preventDefault();
    }

    function stop() {
        if (isDrawing) {
            isDrawing = false;
        }
    }

    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', stop);

    canvas.addEventListener('touchstart', start, { passive: false });
    canvas.addEventListener('touchmove', move, { passive: false });
    window.addEventListener('touchend', stop);
}

function clearSignaturePad(canvasId, hintId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (padState[canvasId]) padState[canvasId].hasDrawn = false;
    const hint = document.getElementById(hintId);
    if (hint) hint.style.display = 'flex';
    if (canvas.parentElement) {
        canvas.parentElement.style.borderColor = '#94a3b8';
        canvas.parentElement.style.backgroundColor = '#ffffff';
    }
}

function resetInputSignatures() {
    clearSignaturePad('modalCanvasPiket', 'modalHintPiket');
    clearSignaturePad('modalCanvasSiswa', 'modalHintSiswa');
}

function formatTanggalIndo(dateStr) {
    if (!dateStr) return '-';
    const parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    const year = parts[0];
    const month = parseInt(parts[1], 10);
    const day = parseInt(parts[2], 10);
    
    const d = new Date(year, month - 1, day);
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    const hariNama = days[d.getDay()];
    const blnNama = months[month - 1];
    
    return `${hariNama}, ${day < 10 ? '0' + day : day} ${blnNama} ${year}`;
}

function formatHariIniIndo() {
    const d = new Date();
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const day = d.getDate();
    return `${day < 10 ? '0' + day : day} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

function generateRandomCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let res = '';
    for (let i = 0; i < 4; i++) {
        res += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    return `DSP-${y}${m}${d}-${res}`;
}

// Data Cache untuk Pencarian Guru Piket di Lembar Surat Dispen
let allGuruPiketData = [];

function initGuruPiketOptionsCache() {
    const select = document.getElementById('modalSelectGuruPiket');
    if (!select || allGuruPiketData.length > 0) return;

    allGuruPiketData = [];
    for (let i = 1; i < select.options.length; i++) {
        const opt = select.options[i];
        allGuruPiketData.push({
            value: opt.value,
            text: opt.textContent.trim(),
            nama: opt.getAttribute('data-nama') || '',
            nip: opt.getAttribute('data-nip') || '-',
            selected: opt.selected
        });
    }
}

function filterGuruPiketOptions(query) {
    initGuruPiketOptionsCache();
    const select = document.getElementById('modalSelectGuruPiket');
    const countEl = document.getElementById('guruPiketSearchCount');
    if (!select) return;

    const term = (query || '').toLowerCase().trim();
    const currentVal = select.value;

    // Bersihkan semua opsi kecuali placeholder awal
    while (select.options.length > 1) {
        select.remove(1);
    }

    let matchCount = 0;
    allGuruPiketData.forEach(item => {
        const match = !term ||
            item.text.toLowerCase().includes(term) ||
            item.nama.toLowerCase().includes(term) ||
            item.nip.toLowerCase().includes(term);

        if (match) {
            matchCount++;
            const opt = document.createElement('option');
            opt.value = item.value;
            opt.textContent = item.text;
            opt.setAttribute('data-nama', item.nama);
            opt.setAttribute('data-nip', item.nip);
            if (item.value === currentVal) {
                opt.selected = true;
            }
            select.appendChild(opt);
        }
    });

    if (countEl) {
        if (!term) {
            countEl.textContent = `(${allGuruPiketData.length} Guru)`;
            countEl.style.color = '#64748b';
        } else {
            countEl.textContent = `(${matchCount} ditemukan)`;
            countEl.style.color = matchCount > 0 ? '#166534' : '#dc2626';
        }
    }

    // Jika hanya cocok tepat 1 guru, otomatis pilihkan
    if (term && matchCount === 1) {
        select.selectedIndex = 1;
        updateGuruPiketDisplay();
    } else {
        updateGuruPiketDisplay();
    }
}

function resetSearchGuruPiket() {
    const searchInput = document.getElementById('modalSearchGuruPiketInput');
    if (searchInput) {
        searchInput.value = '';
    }
    filterGuruPiketOptions('');
}

function updateGuruPiketDisplay() {
    const sel = document.getElementById('modalSelectGuruPiket');
    if (sel && sel.selectedIndex > 0) {
        const opt = sel.options[sel.selectedIndex];
        document.getElementById('suratNamaGuruPiketDisplay').innerText = opt.getAttribute('data-nama') || '-';
        document.getElementById('suratNipGuruPiketDisplay').innerText = 'NIP. ' + (opt.getAttribute('data-nip') || '-');
    } else {
        document.getElementById('suratNamaGuruPiketDisplay').innerText = 'Pilih Guru Piket';
        document.getElementById('suratNipGuruPiketDisplay').innerText = 'NIP. -';
    }
}

/**
 * Reset Seluruh Pengisian Form Input Permohonan Dispensasi Siswa
 */
function resetFormDispensasiSiswa() {
    const form = document.getElementById('formDispensasiSiswa');
    if (form) {
        form.reset();
    }

    // Reset Select2 Siswa & Waka
    if (window.jQuery && $.fn.select2) {
        $('#selectSiswa').val('').trigger('change');
        $('#selectWaka').val('').trigger('change');
    }

    // Kembalikan default tanggal hari ini & jam standar
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    const todayStr = `${y}-${m}-${d}`;

    const inputTgl = document.getElementById('inputTanggal');
    if (inputTgl) inputTgl.value = todayStr;

    const jamKeluar = document.getElementById('jamKeluarInput');
    if (jamKeluar) jamKeluar.value = '08:00';

    const jamKembali = document.getElementById('jamKembaliInput');
    if (jamKembali) jamKembali.value = '11:30';

    const inputAlasan = document.getElementById('inputAlasan');
    if (inputAlasan) inputAlasan.value = '';

    const inputTempat = document.getElementById('inputTempat');
    if (inputTempat) inputTempat.value = '';

    // Reset Hidden Inputs
    document.getElementById('hiddenIdGuruPiket').value = '';
    document.getElementById('hiddenNamaGuruPiket').value = '';
    document.getElementById('hiddenNipGuruPiket').value = '';
    document.getElementById('hiddenTtdSiswaData').value = '';
    document.getElementById('hiddenTtdGuruPiketData').value = '';
    document.getElementById('hiddenKodeDispen').value = '';

    // Bersihkan file upload inputs
    if (form) {
        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(fi => fi.value = '');
    }

    // Reset modal signatures & search filter
    resetInputSignatures();
    resetSearchGuruPiket();
    hapusFotoSiswaLive();

    // Reset selected guru piket di modal
    const selPiket = document.getElementById('modalSelectGuruPiket');
    if (selPiket) {
        selPiket.selectedIndex = 0;
        updateGuruPiketDisplay();
    }
}

function openModalSuratDispenInput() {
    const selectSiswa = document.getElementById('selectSiswa');
    if (!selectSiswa.value) {
        alert('Silakan pilih Siswa yang mengajukan permohonan dispensasi terlebih dahulu!');
        $(selectSiswa).select2('open');
        return;
    }

    const selectWaka = document.getElementById('selectWaka');
    if (!selectWaka.value) {
        alert('Silakan pilih Waka Kesiswaan tujuan untuk persetujuan permohonan dispensasi!');
        $(selectWaka).select2('open');
        return;
    }

    const tgl = document.getElementById('inputTanggal').value;
    if (!tgl) {
        alert('Silakan tentukan Tanggal Dispensasi!');
        document.getElementById('inputTanggal').focus();
        return;
    }

    const jamKeluar = document.getElementById('jamKeluarInput').value;
    const jamKembali = document.getElementById('jamKembaliInput').value;
    if (!jamKeluar || !jamKembali) {
        alert('Silakan isi Rencana Jam Keluar dan Jam Kembali!');
        return;
    }

    if (jamKembali <= jamKeluar) {
        alert('Validasi Gagal!\n\nRencana Jam Kembali (' + jamKembali + ') harus lebih akhir daripada Rencana Jam Keluar (' + jamKeluar + ').');
        return;
    }

    const alasan = document.getElementById('inputAlasan').value.trim();
    if (!alasan) {
        alert('Silakan tuliskan Alasan / Keperluan dispensasi siswa!');
        document.getElementById('inputAlasan').focus();
        return;
    }

    // Validasi Wajib Foto Siswa Live dari Kamera Perangkat
    const fotoLive = document.getElementById('inputFotoSiswaLive').value;
    if (!fotoLive) {
        alert('Foto Siswa (Wajib Live) belum diambil!\n\nSilakan klik kotak "Ambil Foto Siswa (wajib live)" untuk membuka kamera dan memfoto langsung siswa yang izin dispensasi.');
        const triggerBox = document.getElementById('boxTriggerCamera');
        if (triggerBox) {
            triggerBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            triggerBox.style.borderColor = '#ef4444';
            triggerBox.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.25)';
        }
        return;
    }

    const tempat = document.getElementById('inputTempat').value.trim() || 'Aula Dinas Pendidikan Kabupaten Tulungagung';

    // Ambil Data Siswa dari opsi terpilih
    const opt = selectSiswa.options[selectSiswa.selectedIndex];
    const namaSiswa = opt.getAttribute('data-nama') || opt.text;
    const nisnSiswa = opt.getAttribute('data-nisn') || '-';
    const kelasSiswa = opt.getAttribute('data-kelas') || '-';
    const jurusanSiswa = opt.getAttribute('data-jurusan') || 'Manajemen Perkantoran dan Layanan Bisnis';

    // Kode Dispen
    let kode = document.getElementById('hiddenKodeDispen').value;
    if (!kode) {
        kode = generateRandomCode();
        document.getElementById('hiddenKodeDispen').value = kode;
    }

    // Isi Nilai ke Lembar Surat
    document.getElementById('suratKodeDispenSpan').innerText = kode;
    document.getElementById('suratNamaSiswaSpan').innerText = namaSiswa;
    document.getElementById('suratNisnSiswaSpan').innerText = nisnSiswa;
    document.getElementById('suratKelasSiswaSpan').innerText = kelasSiswa;
    document.getElementById('suratJurusanSiswaSpan').innerText = jurusanSiswa;
    document.getElementById('suratHariTanggalSpan').innerText = formatTanggalIndo(tgl);
    document.getElementById('suratPukulSpan').innerText = jamKeluar + ' WIB s.d. ' + jamKembali + ' WIB';
    document.getElementById('suratKeperluanSpan').innerText = alasan;
    document.getElementById('suratTempatSpan').innerText = tempat;

    // Tanda Tangan Siswa Info
    document.getElementById('suratNamaSiswaDisplay').innerText = namaSiswa;
    document.getElementById('suratNisnSiswaDisplay').innerText = 'NISN. ' + nisnSiswa;
    document.getElementById('suratTanggalCetakSpan').innerText = formatHariIniIndo();

    // Pasang Foto Siswa Live di Lembar Surat
    const containerFotoLive = document.getElementById('suratFotoLiveContainer');
    const imgFotoLive = document.getElementById('suratFotoLiveImg');
    if (fotoLive) {
        if (imgFotoLive) imgFotoLive.src = fotoLive;
        if (containerFotoLive) containerFotoLive.style.display = 'block';
    } else {
        if (containerFotoLive) containerFotoLive.style.display = 'none';
    }

    // Update Guru Piket & Inisialisasi Fitur Cari
    initGuruPiketOptionsCache();
    resetSearchGuruPiket();
    updateGuruPiketDisplay();

    // Tampilkan Modal
    document.getElementById('modalSuratDispenInput').style.display = 'flex';

    // Inisialisasi Canvas TTD
    setTimeout(() => {
        initSignaturePad('modalCanvasPiket', 'modalHintPiket');
        initSignaturePad('modalCanvasSiswa', 'modalHintSiswa');
    }, 150);
}

function closeModalSuratDispenInput() {
    document.getElementById('modalSuratDispenInput').style.display = 'none';
}

function submitFinalDispensasiForm() {
    const sel = document.getElementById('modalSelectGuruPiket');
    if (!sel || !sel.value) {
        alert('Validasi Gagal!\n\nSilakan pilih Guru Piket yang bertugas pada surat dispensasi ini!');
        if (sel) sel.focus();
        return;
    }

    // 1. Validasi Wajib Tanda Tangan Guru Piket
    const cPiket = document.getElementById('modalCanvasPiket');
    const piketHasDrawn = (cPiket && padState['modalCanvasPiket'] && padState['modalCanvasPiket'].hasDrawn);
    if (!piketHasDrawn) {
        const wrapPiket = document.getElementById('wrapperCanvasPiket');
        if (wrapPiket) {
            wrapPiket.style.borderColor = '#dc2626';
            wrapPiket.style.backgroundColor = '#fef2f2';
        }
        alert('Validasi Gagal!\n\nTanda tangan Guru Piket WAJIB diisi.\nSilakan Guru Piket melakukan tanda tangan pada kolom yang disediakan terlebih dahulu.');
        return;
    }

    // 2. Validasi Wajib Tanda Tangan Siswa
    const cSiswa = document.getElementById('modalCanvasSiswa');
    const siswaHasDrawn = (cSiswa && padState['modalCanvasSiswa'] && padState['modalCanvasSiswa'].hasDrawn);
    if (!siswaHasDrawn) {
        const wrapSiswa = document.getElementById('wrapperCanvasSiswa');
        if (wrapSiswa) {
            wrapSiswa.style.borderColor = '#dc2626';
            wrapSiswa.style.backgroundColor = '#fef2f2';
        }
        alert('Validasi Gagal!\n\nTanda tangan Siswa WAJIB diisi.\nSilakan Siswa yang mengajukan dispensasi melakukan tanda tangan pada kolom yang disediakan terlebih dahulu.');
        return;
    }

    const opt = sel.options[sel.selectedIndex];
    document.getElementById('hiddenIdGuruPiket').value = sel.value;
    document.getElementById('hiddenNamaGuruPiket').value = opt.getAttribute('data-nama') || '';
    document.getElementById('hiddenNipGuruPiket').value = opt.getAttribute('data-nip') || '-';

    // Simpan tanda tangan jika telah digambar
    document.getElementById('hiddenTtdSiswaData').value = cSiswa.toDataURL('image/png');
    document.getElementById('hiddenTtdGuruPiketData').value = cPiket.toDataURL('image/png');

    // Submit form permohonan
    document.getElementById('formDispensasiSiswa').submit();
}

function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Link Persetujuan Waka Kesiswaan berhasil disalin ke clipboard!\n\n' + url);
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
        alert('Link Persetujuan Waka Kesiswaan berhasil disalin ke clipboard!\n\n' + text);
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

<<<<<<< HEAD
    let statusBadge = '<span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu Waka Kesiswaan</span>';
    if (data.status_waka === 'approved') {
        statusBadge = '<span class="badge-status badge-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka Kesiswaan</span>';
    } else if (data.status_waka === 'rejected') {
        statusBadge = '<span class="badge-status badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka Kesiswaan</span>';
=======
    let statusBadge = '<span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Menunggu Waka</span>';
    if (status === 'approved') {
        statusBadge = '<span class="status-badge status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka</span>';
    } else if (status === 'rejected') {
        statusBadge = '<span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka</span>';
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    let notesHtml = '';
    if (status === 'rejected') {
        notesHtml = `
<<<<<<< HEAD
            <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 10px; margin-top: 12px;">
                <div style="font-weight: 800; color: #991b1b; font-size: 12px; text-transform: uppercase;">Alasan Penolakan Waka Kesiswaan:</div>
                <div style="font-weight: 600; color: #7f1d1d; margin-top: 4px; font-size: 13.5px;">"${data.catatan_waka || 'Tanpa Alasan'}"</div>
=======
            <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 10px; margin-top: 14px;">
                <div style="font-weight: 800; color: #991b1b; font-size: 11px; text-transform: uppercase;">Catatan Penolakan Waka:</div>
                <div style="font-weight: 600; color: #7f1d1d; margin-top: 4px; font-size: 13px;">"${data.catatan_waka || 'Tanpa Catatan'}"</div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
        `;
    }

    let fotoSiswaLiveHtml = '';
    if (data.foto_siswa_live) {
        fotoSiswaLiveHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11.5px; color: #2563eb; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">
                    <i class="fa-solid fa-camera"></i> Foto Siswa (Live Kamera Saat Izin Dispensasi)
                </div>
                <a href="{{ asset('') }}${data.foto_siswa_live}" target="_blank" title="Klik untuk perbesar Foto Live Siswa">
                    <img src="{{ asset('') }}${data.foto_siswa_live}" style="width: 100%; max-height: 240px; object-fit: contain; background: #eff6ff; border-radius: 10px; border: 2px solid #3b82f6; box-shadow: 0 4px 10px rgba(37,99,235,0.15);">
                </a>
                <div style="font-size: 11px; color: #166534; font-weight: 700; margin-top: 4px;">
                    <i class="fa-solid fa-circle-check"></i> Foto siswa diambil live di pos Guru Piket untuk dicocokkan Satpam di pintu gerbang.
                </div>
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
<<<<<<< HEAD
        ${fotoSiswaLiveHtml}
        ${fotoKartuHtml}
        ${fotoSuratHtml}
        ${data.ttd_siswa || data.ttd_guru_piket ? `
            <div style="margin-bottom: 14px; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">Tanda Tangan Digital</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: center;">
                    <div style="background: #ffffff; padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TTD Siswa</div>
                        ${data.ttd_siswa ? `<img src="{{ asset('') }}${data.ttd_siswa}" style="max-height: 60px; max-width: 100%; object-fit: contain;">` : '<span style="font-size: 11px; color: #94a3b8; font-style: italic;">Belum TTD</span>'}
                        <div style="font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px;">${siswaNama}</div>
                    </div>
                    <div style="background: #ffffff; padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TTD Guru Piket</div>
                        ${data.ttd_guru_piket ? `<img src="{{ asset('') }}${data.ttd_guru_piket}" style="max-height: 60px; max-width: 100%; object-fit: contain;">` : '<span style="font-size: 11px; color: #94a3b8; font-style: italic;">Belum TTD</span>'}
                        <div style="font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px;">${data.nama_guru_piket || 'Guru Piket'}</div>
                    </div>
                </div>
            </div>
        ` : ''}
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Waka Kesiswaan Tujuan</div>
            <div style="font-size: 14px; font-weight: 700; color: #1e293b;">${wakaNama} (NIP: ${nipWaka})</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Status Persetujuan Waka Kesiswaan</div>
            ${statusBadge}
        </div>
=======

        <div style="margin-bottom: 14px;">
            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Waka Tujuan / Persetujuan</div>
            <div style="font-size: 13px; font-weight: 700; color: #1e293b;">${wakaNama} ${nipWaka !== '-' ? `(NIP: ${nipWaka})` : ''}</div>
        </div>

        ${fotoKartuHtml}
        ${fotoSuratHtml}
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        ${notesHtml}

        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">

        <div>
<<<<<<< HEAD
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Link Approval Waka Kesiswaan</div>
=======
            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">Link Persetujuan Waka</div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            <div style="display: flex; gap: 8px;">
                <input type="text" value="${appUrl}" readonly class="dispen-input" style="font-family: monospace; font-size: 12px; padding-left: 12px;">
                <button type="button" onclick="copyLink('${appUrl}')" class="dispen-btn-submit" style="white-space: nowrap; padding: 8px 14px; font-size: 12px;">
                    <i class="fa-solid fa-copy"></i> Salin
                </button>
            </div>
        </div>

        <div style="display: flex; gap: 8px; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
            <form action="{{ url('/guru-piket/dispensasi-siswa') }}/${data.id_siswa_dispen}" method="POST" style="margin: 0;" onsubmit="return confirm('Pindahkan data dispensasi siswa ini ke Sampah?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dispen-btn-reset" style="height: 36px; padding: 0 14px; border-radius: 8px; font-weight: 700; gap: 6px; color: #dc2626; border-color: #fca5a5; background: #fee2e2;">
                    <i class="fa-solid fa-trash-can"></i> Pindahkan ke Sampah
                </button>
            </form>
            <button type="button" onclick="closeDetailModal()" class="dispen-btn-reset" style="height: 36px; padding: 0 16px;">
                Tutup
            </button>
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

    // Reset dan inisialisasi foto live siswa di modal edit
    document.getElementById('editFotoSiswaLive').value = '';
    const editImg = document.getElementById('editPreviewFotoSiswaLive');
    const noFotoText = document.getElementById('editNoFotoText');
    if (data.foto_siswa_live) {
        editImg.src = `{{ asset('') }}${data.foto_siswa_live}`;
        editImg.style.display = 'block';
        if (noFotoText) noFotoText.style.display = 'none';
    } else {
        editImg.src = '';
        editImg.style.display = 'none';
        if (noFotoText) noFotoText.style.display = 'inline';
    }

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

<<<<<<< HEAD
        <div style="font-size: 20px; font-family: monospace; font-weight: 800; color: #2563eb; margin-bottom: 4px;">${data.kode_dispen}</div>
        <div style="font-size: 16px; font-weight: 800; color: #0f172a;">${siswaNama}</div>
        <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelas ${kelasNama} | ${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'}</div>

        <div style="background: #ffffff; padding: 16px; border-radius: 16px; border: 2px dashed #2563eb; display: inline-block; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);">
            <img src="${qrUrl}" alt="QR Code Barcode Dispen" style="width: 210px; height: 210px; display: block;">
=======
        <div style="font-size: 20px; font-family: monospace; font-weight: 800; color: #6d28d9; margin-bottom: 4px;">${data.kode_dispen}</div>
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">${siswaNama}</div>
        <div style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelas ${kelasNama} | ${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'}</div>

        <div style="background: #ffffff; padding: 14px; border-radius: 16px; border: 2px dashed #7c3aed; display: inline-block; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.12);">
            <img src="${qrUrl}" alt="QR Code Barcode Dispen" style="width: 200px; height: 200px; display: block;">
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>

        ${fotoKartuHtml}

<<<<<<< HEAD
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 12px 16px; border-radius: 10px; margin-top: 16px; text-align: left; font-size: 12px; color: #334155; font-weight: 600;">
            <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> <strong>Instruksi Alur Sistem:</strong><br>
            Siswa dapat mengambil foto Barcode ini. Saat berada di depan pintu gerbang sekolah, tunjukkan foto Barcode ini & Kartu Pelajar kepada Satpam untuk discan & divalidasi keluar.
=======
        <div style="background: #f3e8ff; border: 1px solid #d8b4fe; padding: 10px 14px; border-radius: 10px; margin-top: 16px; text-align: left; font-size: 11.5px; color: #6b21a8; font-weight: 600;">
            <i class="fa-solid fa-circle-info"></i> <strong>Instruksi Satpam:</strong><br>
            Siswa menunjukkan Barcode ini & Kartu Pelajar kepada Satpam saat melewati pintu gerbang sekolah untuk discan & divalidasi keluar.
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
