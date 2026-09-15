@extends('layouts.guru')

@section('title', 'Surat Izin Siswa — EDU JOURNAL')

@section('styles')
<style>
    /* Container & Base Styles */
    .sis-page-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ─── Top 4 Stat Cards ─── */
    .sis-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 1100px) {
        .sis-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .sis-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .sis-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .sis-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .sis-stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .sis-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .sis-stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .sis-stat-icon.green {
        background: #ecfdf5;
        color: #10b981;
    }

    .sis-stat-icon.orange {
        background: #fff7ed;
        color: #f97316;
    }

    .sis-stat-icon.purple {
        background: #faf5ff;
        color: #a855f7;
    }

    .sis-stat-info {
        display: flex;
        flex-direction: column;
    }

    .sis-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 2px;
    }

    .sis-stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .sis-stat-sub {
        font-size: 11.5px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* ─── Auto-Sync Banner ─── */
    .sis-sync-banner {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .sis-sync-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .sis-sync-icon-badge {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);
        flex-shrink: 0;
    }

    .sis-sync-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
    }

    .sis-sync-desc {
        font-size: 12px;
        font-weight: 500;
        color: #2563eb;
        margin: 2px 0 0 0;
    }

    .sis-sync-right-graphic {
        opacity: 0.85;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    /* ─── Card Container Standard ─── */
    .sis-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .sis-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .sis-card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sis-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sis-card-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .sis-card-subtitle {
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .sis-pill-badge {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .sis-card-body {
        padding: 24px;
    }

    /* ─── Form Input Styles ─── */
    .sis-form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    @media (max-width: 992px) {
        .sis-form-grid {
            grid-template-columns: 1fr;
        }
    }

    .sis-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .sis-form-group.full-width {
        grid-column: 1 / -1;
    }

    .sis-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sis-label .req {
        color: #ef4444;
        margin-left: 2px;
    }

    .sis-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .sis-input-icon {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .sis-input, .sis-select {
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

    .sis-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 36px;
    }

    .sis-input:focus, .sis-select:focus, .sis-textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: #ffffff;
    }

    .sis-textarea {
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

    .sis-durasi-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .sis-wali-badge {
        display: none;
        align-items: center;
        gap: 8px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 12px;
        color: #0369a1;
        font-weight: 700;
        margin-top: 4px;
    }

    .sis-wali-badge.empty {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }

    /* Custom File Input Container */
    .sis-file-container {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 6px 12px;
        gap: 10px;
        cursor: pointer;
        transition: border-color 0.2s ease;
    }

    .sis-file-container:hover {
        border-color: #94a3b8;
    }

    .sis-btn-file {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .sis-file-name {
        font-size: 12.5px;
        color: #64748b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1;
    }

    .sis-file-icon-right {
        color: #94a3b8;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sis-file-hint {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    .sis-date-warning {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 14px;
        display: none;
        align-items: center;
        gap: 8px;
    }

    /* Form Action Buttons */
    .sis-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .sis-btn-reset {
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

    .sis-btn-reset:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .sis-btn-submit {
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

    .sis-btn-submit:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
    }

    /* ─── Filter & Toolbar Controls Block (Ringkas & Proporsional) ─── */
    .sis-filter-block {
        padding: 14px 20px 12px 20px;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .sis-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .sis-search-box {
        flex: 1 1 200px;
        min-width: 180px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .sis-search-box i {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }

    .sis-search-input {
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

    .sis-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .sis-filter-select {
        flex: 0 1 150px;
        min-width: 130px;
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

    .sis-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .sis-filter-date {
        flex: 0 1 135px;
        min-width: 125px;
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

    .sis-filter-date:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .sis-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        flex-shrink: 0;
    }

    .sis-btn-filter-dark {
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

    .sis-btn-filter-dark:hover {
        background: #0f172a;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
    }

    .sis-btn-filter-reset {
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

    .sis-btn-filter-reset:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* ─── Baris 2: Toolbar Aksi Tabel (Kompak & Menyatu) ─── */
    .sis-action-toolbar {
        padding: 0;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    .sis-toolbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 32px;
    }

    .sis-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    /* Placeholder dengan background tint lembut (bg-slate-50 / border-slate-200) */
    .sis-bulk-placeholder {
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

    .sis-bulk-placeholder i {
        font-size: 12px;
        color: #3b82f6;
    }

    .sis-btn-bulk-del {
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

    .sis-btn-bulk-del:hover {
        background: #fecaca;
        color: #b91c1c;
        border-color: #f87171;
    }

    .sis-btn-trash-link {
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

    .sis-btn-trash-link:hover {
        background: #fdf2f8;
        color: #be185d;
        border-color: #f472b6;
    }

    /* Checkbox Styling */
    .sis-checkbox {
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

    .sis-checkbox:hover {
        border-color: #2563eb !important;
    }

    .sis-checkbox:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25);
    }

    /* ─── Table Styles ─── */
    .sis-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-top: 1px solid #e2e8f0;
    }

    .sis-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .sis-table thead {
        background: #f1f5f9;
    }

    .sis-table th {
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

    .sis-table td {
        padding: 9px 8px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 11.5px;
        color: #1e293b;
        vertical-align: middle;
    }

    .sis-table tr:hover td {
        background: #f8fafc;
    }

    /* Action Column */
    .sis-col-aksi {
        text-align: center;
        white-space: nowrap;
    }

    /* Student Cell */
    .sis-student-cell {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .sis-student-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
        font-size: 10.5px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sis-student-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .sis-student-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 11.5px;
        line-height: 1.25;
        max-width: 125px;
        word-break: break-word;
    }

    .sis-student-nis {
        font-size: 10px;
        color: #64748b;
        font-weight: 600;
    }

    /* Badges */
    .sis-badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 7px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .sis-badge-kategori.sakit {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .sis-badge-kategori.izin {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .sis-badge-kategori.dispen {
        background: #faf5ff;
        color: #7e22ce;
        border: 1px solid #e9d5ff;
    }

    /* Action Buttons in Table */
    .sis-btn-action {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: 11px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .sis-btn-action.detail {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .sis-btn-action.detail:hover {
        background: #2563eb;
        color: #ffffff;
    }

    .sis-btn-action.edit {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .sis-btn-action.edit:hover {
        background: #16a34a;
        color: #ffffff;
    }

    .sis-btn-action.delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .sis-btn-action.delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .sis-btn-preview-foto {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #3b82f6;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        transition: all 0.2s ease;
    }
    .sis-btn-preview-foto:hover {
        background: #eff6ff;
        border-color: #93c5fd;
    }

    /* Empty State */
    .sis-empty-box {
        text-align: center;
        padding: 48px 20px;
        color: #64748b;
    }

    .sis-empty-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 12px auto;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 24px;
    }

    .sis-empty-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
    }

    /* Table Footer & Pagination */
    .sis-table-footer {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 12.5px;
        color: #64748b;
    }

    /* Modal Overlay & Base */
    .sis-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .sis-modal-overlay.active {
        display: flex;
    }

    .sis-modal-box {
        background: #ffffff;
        border-radius: 20px;
        max-width: 620px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        animation: sisModalSlide 0.25s ease-out;
    }

    @keyframes sisModalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .sis-modal-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sis-modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sis-modal-close {
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
        transition: all 0.2s ease;
    }

    .sis-modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .sis-modal-body {
        padding: 24px;
    }

    /* Alerts */
    .sis-alert {
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .sis-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .sis-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .mobile-sis-stat-carousel-wrap,
    .mobile-sis-section,
    #mobileFilterModal,
    .sis-btn-text-short {
        display: none !important;
    }

    @media (max-width: 768px) {
        .sis-desktop-table-card,
        .sis-desktop-stat-grid,
        .sis-btn-text-full {
            display: none !important;
        }

        .mobile-sis-stat-carousel-wrap,
        .mobile-sis-section {
            display: flex !important;
        }

        #mobileFilterModal.active {
            display: flex !important;
        }

        .sis-btn-text-short {
            display: inline !important;
        }

        .sis-page-container {
            padding-bottom: 24px;
        }

        /* Modal Overlay & Box on Mobile */
        .sis-modal-overlay {
            padding: 12px;
        }

        .sis-modal-box {
            padding: 16px 14px;
            border-radius: 18px;
            max-height: 92vh;
            width: 100%;
        }

        /* Mobile Stat Cards Carousel */
        .mobile-sis-stat-carousel-wrap {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .mobile-sis-stat-container {
            position: relative;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            touch-action: pan-y;
            background: transparent;
        }

        .mobile-sis-stat-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }

        .mobile-sis-stat-slide {
            flex: 0 0 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .mobile-sis-stat-slide .sis-stat-card {
            width: 100%;
            margin: 0;
            border-radius: 18px;
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

        .mobile-sis-stat-container:hover .m-stat-arrow,
        .mobile-sis-stat-container.is-hovered .m-stat-arrow {
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

        .mobile-sis-stat-dots {
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

        /* Banner & Card on Mobile */
        .sis-sync-banner {
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 16px;
        }

        .sis-sync-right-graphic svg {
            width: 36px;
            height: 36px;
        }

        .sis-card {
            border-radius: 16px;
            margin-bottom: 16px;
        }

        .sis-card-header {
            padding: 14px 16px;
        }

        .sis-card-body {
            padding: 16px;
        }

        /* Form Controls on Mobile */
        .sis-form-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .sis-input, .sis-select, .sis-file-container {
            height: 42px;
            min-height: 42px;
            font-size: 13px;
        }

        .sis-form-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            width: 100%;
        }

        .sis-btn-reset, .sis-btn-submit {
            width: 100%;
            justify-content: center;
            height: 42px;
            min-height: 42px;
            padding: 0 10px;
            font-size: 12.5px;
            border-radius: 9px;
            gap: 6px;
            white-space: nowrap;
        }

        .sis-btn-submit {
            font-weight: 700;
        }

        .sis-btn-reset {
            font-weight: 600;
        }

        /* Mobile Section: Filter Card + Cards List */
        .mobile-sis-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .mobile-sis-filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mobile-sis-filter-header {
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

        .m-btn-trash-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            color: #e11d48;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .m-btn-trash-pill:hover,
        .m-btn-trash-pill:active {
            background: #ffe4e6;
            border-color: #fda4af;
            color: #be123c;
        }

        .mobile-sis-search-row {
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
        .mobile-sis-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .mobile-sis-card-item {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: stretch;
            padding: 12px 14px 12px 10px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .mobile-sis-card-item.card-sakit {
            border-color: #bbf7d0;
            background: #fcfffd;
        }

        .mobile-sis-card-item.card-izin {
            border-color: #fde68a;
            background: #fffdf7;
        }

        .mobile-sis-card-item.card-dispen {
            border-color: #e9d5ff;
            background: #fdfcff;
        }

        /* Tiered Date Column */
        .mobile-card-date-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            padding: 2px 10px 2px 4px;
            border-right: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .m-date-day {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
            text-align: center;
        }

        .date-sakit .m-date-day { color: #15803d; }
        .date-izin .m-date-day { color: #b45309; }
        .date-dispen .m-date-day { color: #7e22ce; }

        .m-date-month {
            font-size: 10px;
            font-weight: 800;
            margin-top: 2px;
            text-transform: uppercase;
        }

        .date-sakit .m-date-month { color: #16a34a; }
        .date-izin .m-date-month { color: #d97706; }
        .date-dispen .m-date-month { color: #9333ea; }

        .m-date-year {
            font-size: 9.5px;
            font-weight: 600;
            color: #94a3b8;
        }

        .m-date-durasi-badge {
            font-size: 9px;
            font-weight: 800;
            padding: 1px 5px;
            border-radius: 6px;
            margin-top: 3px;
            white-space: nowrap;
        }

        .date-sakit .m-date-durasi-badge { background: #dcfce7; color: #166534; }
        .date-izin .m-date-durasi-badge { background: #fef3c7; color: #92400e; }
        .date-dispen .m-date-durasi-badge { background: #f3e8ff; color: #6b21a8; }

        /* Right Card Content */
        .mobile-card-content {
            flex: 1;
            min-width: 0;
            padding-left: 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            justify-content: center;
        }

        .m-card-badges-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            flex-wrap: wrap;
        }

        .m-card-student-name {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
        }

        .m-card-sub-info {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .m-card-class-badge {
            font-size: 10.5px;
            font-weight: 700;
            color: #1e3a8a;
            background: #eff6ff;
            padding: 1px 6px;
            border-radius: 6px;
            border: 1px solid #dbeafe;
        }

        .m-card-reason-box {
            font-size: 11.5px;
            color: #334155;
            background: #f8fafc;
            padding: 5px 8px;
            border-radius: 6px;
            border: 1px solid #f1f5f9;
            line-height: 1.35;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .m-card-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
            padding-top: 6px;
            border-top: 1px dashed #f1f5f9;
        }

        .m-btn-detail-link {
            font-size: 12px;
            font-weight: 700;
            color: #2563eb;
            background: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: background 0.15s ease;
        }

        .m-btn-detail-link:hover {
            background: #eff6ff;
        }

        .m-btn-modal-delete {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .m-btn-modal-delete:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .mobile-pagination-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 14px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .m-filter-label {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .m-filter-select, .m-filter-input {
            width: 100%;
            height: 42px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px;
            font-size: 12.5px;
            color: #1e293b;
            outline: none;
            box-sizing: border-box;
        }

        .m-filter-select:focus, .m-filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
    }
</style>
@endsection

@section('content')
<div class="sis-page-container">

    <!-- ─── MOBILE TOPBAR (TITLE + SAMPAH PILL) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Surat Izin Siswa</h1>
            <span class="mobile-topbar-sub">Kelola permohonan izin siswa</span>
        </div>
        @php
            $trashCountSis = \App\Models\SiswaSuratIzin::onlyTrashed()->count();
        @endphp
        <div class="mobile-topbar-right">
            <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="m-btn-trash-pill" title="Sampah">
                <i class="fa-solid fa-trash-can"></i>
                <span>Sampah</span>
                @if($trashCountSis > 0)
                    <span class="m-trash-badge">{{ $trashCountSis }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="sis-alert sis-alert-success">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a; flex-shrink: 0;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="sis-alert sis-alert-error">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626; flex-shrink: 0;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="sis-alert sis-alert-error">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 18px; color: #dc2626; flex-shrink: 0;"></i>
            <div>
                <strong>Gagal Menyimpan Data:</strong>
                <ul style="margin: 4px 0 0 18px; padding: 0;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- 1. Top 4 Stat Cards (Desktop Grid) -->
    <div class="sis-stats-grid sis-desktop-stat-grid">
        <!-- Card 1: Total Izin Hari Ini -->
        <div class="sis-stat-card">
            <div class="sis-stat-left">
                <div class="sis-stat-icon blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="sis-stat-info">
                    <span class="sis-stat-title">Total Izin Hari Ini</span>
                    <span class="sis-stat-number">{{ $totalIzinHariIni }}</span>
                    <span class="sis-stat-sub">Siswa Aktif (Sakit: {{ $sakitHariIni }}, Izin: {{ $izinHariIni }}, Dispen: {{ $dispenHariIni }})</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Sakit -->
        <div class="sis-stat-card">
            <div class="sis-stat-left">
                <div class="sis-stat-icon green">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div class="sis-stat-info">
                    <span class="sis-stat-title" style="color: #15803d;">Sakit</span>
                    <span class="sis-stat-number">{{ $sakitHariIni }}</span>
                    <span class="sis-stat-sub">Surat Dokter / Orang Tua</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Izin -->
        <div class="sis-stat-card">
            <div class="sis-stat-left">
                <div class="sis-stat-icon orange">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="sis-stat-info">
                    <span class="sis-stat-title" style="color: #b45309;">Izin</span>
                    <span class="sis-stat-number">{{ $izinHariIni }}</span>
                    <span class="sis-stat-sub">Izin Kepentingan Keluarga</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Dispen Luar Sekolah -->
        <div class="sis-stat-card">
            <div class="sis-stat-left">
                <div class="sis-stat-icon purple">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="sis-stat-info">
                    <span class="sis-stat-title" style="color: #7e22ce;">Dispen Luar Sekolah</span>
                    <span class="sis-stat-number">{{ $dispenHariIni }}</span>
                    <span class="sis-stat-sub">Lomba / Kegiatan Luar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 1b. Mobile Stat Cards Carousel (Mobile View) -->
    <div class="mobile-sis-stat-carousel-wrap">
        <div class="mobile-sis-stat-container" id="mobileStatContainer">
            <div class="mobile-sis-stat-track" id="mobileStatTrack">
                
                <!-- Slide 1: Total Izin Hari Ini -->
                <div class="mobile-sis-stat-slide">
                    <div class="sis-stat-card">
                        <div class="sis-stat-left">
                            <div class="sis-stat-icon blue">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="sis-stat-info">
                                <span class="sis-stat-title">Total Izin Hari Ini</span>
                                <span class="sis-stat-number">{{ $totalIzinHariIni }}</span>
                                <span class="sis-stat-sub">Siswa Aktif (Sakit: {{ $sakitHariIni }}, Izin: {{ $izinHariIni }}, Dispen: {{ $dispenHariIni }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Sakit -->
                <div class="mobile-sis-stat-slide">
                    <div class="sis-stat-card">
                        <div class="sis-stat-left">
                            <div class="sis-stat-icon green">
                                <i class="fa-solid fa-notes-medical"></i>
                            </div>
                            <div class="sis-stat-info">
                                <span class="sis-stat-title" style="color: #15803d;">Sakit</span>
                                <span class="sis-stat-number">{{ $sakitHariIni }}</span>
                                <span class="sis-stat-sub">Surat Dokter / Orang Tua</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Izin -->
                <div class="mobile-sis-stat-slide">
                    <div class="sis-stat-card">
                        <div class="sis-stat-left">
                            <div class="sis-stat-icon orange">
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </div>
                            <div class="sis-stat-info">
                                <span class="sis-stat-title" style="color: #b45309;">Izin</span>
                                <span class="sis-stat-number">{{ $izinHariIni }}</span>
                                <span class="sis-stat-sub">Izin Kepentingan Keluarga</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Dispen Luar Sekolah -->
                <div class="mobile-sis-stat-slide">
                    <div class="sis-stat-card">
                        <div class="sis-stat-left">
                            <div class="sis-stat-icon purple">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div class="sis-stat-info">
                                <span class="sis-stat-title" style="color: #7e22ce;">Dispen Luar Sekolah</span>
                                <span class="sis-stat-number">{{ $dispenHariIni }}</span>
                                <span class="sis-stat-sub">Lomba / Kegiatan Luar</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Navigation Arrows -->
            <button type="button" class="m-stat-arrow m-stat-prev" id="statPrevBtn" onclick="prevSisStatSlide()" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-stat-arrow m-stat-next" id="statNextBtn" onclick="nextSisStatSlide()" aria-label="Selanjutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Dot Indicators (4 Dots) -->
        <div class="mobile-sis-stat-dots" id="mobileStatDots">
            <span class="m-stat-dot active" onclick="goToSisStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToSisStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToSisStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToSisStatSlide(3)"></span>
        </div>
    </div>

    <!-- 2. Auto-Sync Information Banner -->
    <div class="sis-sync-banner">
        <div class="sis-sync-left">
            <div class="sis-sync-icon-badge">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <h4 class="sis-sync-title">Auto-Sync Data Presensi Real-Time</h4>
                <p class="sis-sync-desc">Data izin siswa akan otomatis terhubung dengan presensi harian. Pastikan data diinput dengan benar.</p>
            </div>
        </div>
        <div class="sis-sync-right-graphic">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="4" width="14" height="17" rx="3" fill="#ffffff" stroke="#93c5fd" stroke-width="1.5"/>
                <path d="M9 3C9 2.44772 9.44772 2 10 2H14C14.5523 2 15 2.44772 15 3V5H9V3Z" fill="#3b82f6"/>
                <path d="M8.5 10H15.5M8.5 14H12.5" stroke="#93c5fd" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="16" cy="16" r="4" fill="#2563eb"/>
                <path d="M14.5 16L15.5 17L17.5 15" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <!-- 3. Form Input Surat Izin / Ketidakhadiran Siswa -->
    <div class="sis-card">
        <div class="sis-card-header">
            <div class="sis-card-header-left">
                <div class="sis-card-icon">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <div>
                    <h2 class="sis-card-title">Form Input Surat Izin / Ketidakhadiran Siswa</h2>
                    <p class="sis-card-subtitle">Isi data pengajuan izin siswa dengan lengkap dan benar.</p>
                </div>
            </div>
        </div>

        <div class="sis-card-body">
            <form id="suratIzinInputForm" action="{{ route('piket.surat-izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="sis-form-grid">
                    <!-- 1. Pilih Kelas Siswa -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>1. Pilih Kelas Siswa <span class="req">*</span></span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-solid fa-users sis-input-icon"></i>
                            <select id="form_select_kelas" class="sis-select" onchange="filterSiswaByKelasForm()" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelases as $kls)
                                    @php
                                        $waliNama = $kls->waliKelas->nama_guru ?? '';
                                        $waliNip  = $kls->waliKelas->nip ?? '';
                                    @endphp
                                    <option value="{{ $kls->id_kelas }}" data-wali-nama="{{ $waliNama }}" data-wali-nip="{{ $waliNip }}">
                                        {{ $kls->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Dynamic Wali Kelas Display Badge -->
                        <div id="form_wali_kelas_badge" class="sis-wali-badge">
                            <i class="fa-solid fa-user-tie"></i>
                            <span id="form_wali_kelas_text">-- Pilih Kelas Terlebih Dahulu --</span>
                        </div>
                    </div>

                    <!-- 2. Pilih Siswa yang Izin -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>2. Pilih Siswa yang Izin <span class="req">*</span></span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-regular fa-user sis-input-icon"></i>
                            <select name="id_siswa" id="form_select_siswa" class="sis-select" required disabled>
                                <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                                @foreach($siswas as $sis)
                                    <option value="{{ $sis->id_siswa }}" data-kelas="{{ $sis->id_kelas }}">
                                        {{ $sis->nama_siswa }} ({{ $sis->kelas->nama_kelas ?? 'Kelas' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- 3. Tanggal Mulai Izin -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>3. Tanggal Mulai Izin <span class="req">*</span></span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-regular fa-calendar-days sis-input-icon"></i>
                            <input type="date" name="tanggal" id="form_tgl_mulai" class="sis-input" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                        </div>
                    </div>

                    <!-- 4. Tanggal Selesai Izin + Auto Durasi -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>4. Tanggal Selesai Izin <span class="req">*</span></span>
                            <span id="durasiPillBadge" class="sis-durasi-pill">1 Hari</span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-regular fa-calendar-days sis-input-icon"></i>
                            <input type="date" name="tanggal_selesai" id="form_tgl_selesai" class="sis-input" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                        </div>
                    </div>

                    <!-- 5. Kategori Ketidakhadiran -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>5. Kategori Ketidakhadiran <span class="req">*</span></span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-solid fa-tag sis-input-icon"></i>
                            <select name="kategori" class="sis-select" required>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin" selected>Izin</option>
                                <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                            </select>
                        </div>
                    </div>

                    <!-- 6. Foto Bukti Surat / Dokumen (WAJIB) -->
                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>6. Foto Bukti Surat / Dokumen (WAJIB) <span class="req">*</span></span>
                        </label>
                        <input type="file" name="foto_bukti" id="form_foto_bukti" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;" onchange="updateFileNameDisplay(this)" required>
                        <div class="sis-file-container" onclick="document.getElementById('form_foto_bukti').click()">
                            <span class="sis-btn-file">
                                <i class="fa-regular fa-folder-open"></i> Pilih File
                            </span>
                            <span id="fileNameDisplay" class="sis-file-name">Tidak ada file yang dipilih</span>
                            <i class="fa-regular fa-image sis-file-icon-right"></i>
                        </div>
                        <span class="sis-file-hint">Foto bukti fisik surat / surat dokter / tugas dispen wajib diunggah. Maks 5MB.</span>
                    </div>

                    <!-- 7. Keterangan / Detail Alasan (WAJIB) -->
                    <div class="sis-form-group full-width">
                        <label class="sis-label">
                            <span>7. Keterangan / Detail Alasan (WAJIB) <span class="req">*</span></span>
                        </label>
                        <div class="sis-input-wrapper">
                            <i class="fa-regular fa-comment-dots sis-input-icon" style="top: 14px;"></i>
                            <textarea name="keterangan" id="form_keterangan" rows="2" class="sis-textarea" placeholder="Tuliskan keterangan detail surat izin (misal: Sakit demam tinggi dengan surat dokter Puskesmas, atau Lomba Olahraga tingkat kota)..." required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Date Error Warning Message -->
                <div id="dateValidationWarning" class="sis-date-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="dateValidationText">Validasi Gagal: Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin!</span>
                </div>

                <!-- Action Buttons: Reset & Submit -->
                <div class="sis-form-actions">
                    <button type="button" class="sis-btn-reset" onclick="resetFormCustom()">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span class="sis-btn-text-full">Reset Form</span>
                        <span class="sis-btn-text-short">Reset</span>
                    </button>

                    <button type="submit" id="btnSubmitForm" class="sis-btn-submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span class="sis-btn-text-full">Kirim &amp; Ter-absenkan Otomatis</span>
                        <span class="sis-btn-text-short">Kirim Izin</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. Card Daftar Data Surat Izin & Ketidakhadiran Siswa (Desktop View) -->
    <div class="sis-card sis-desktop-table-card">
        <div class="sis-card-header">
            <div class="sis-card-header-left">
                <div class="sis-card-icon">
                    <i class="fa-solid fa-table-list"></i>
                </div>
                <div>
                    <h2 class="sis-card-title">Daftar Data Surat Izin &amp; Ketidakhadiran Siswa</h2>
                </div>
                <span class="sis-pill-badge">
                    Total Database: {{ $suratIzinList->total() }} Data Surat
                </span>
            </div>
        </div>

        <!-- Filter & Toolbar Controls Block (Ringkas & Proporsional) -->
        <div class="sis-filter-block">
            <!-- Baris 1: Filter Utama -->
            <form action="{{ route('piket.surat-izin-siswa') }}" method="GET" class="sis-filter-form">
                <!-- Search Input (flex-1 lebih lebar) -->
                <div class="sis-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ request('q') }}" class="sis-search-input" placeholder="Cari nama siswa / NIS / keterangan...">
                </div>

                <!-- Dropdown Filter Kelas -->
                <select name="id_kelas" class="sis-filter-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <!-- Dropdown Filter Kategori -->
                <select name="kategori" class="sis-filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="Sakit" {{ request('kategori') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ request('kategori') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Dispen Luar Sekolah" {{ request('kategori') == 'Dispen Luar Sekolah' ? 'selected' : '' }}>Dispen Luar Sekolah</option>
                </select>

                <!-- Date Picker -->
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="sis-filter-date">

                <!-- Tombol Filter & Reset Filter (Group Rata Kanan) -->
                <div class="sis-filter-actions">
                    <button type="submit" class="sis-btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    <a href="{{ route('piket.surat-izin-siswa') }}" class="sis-btn-filter-reset" title="Reset Filter">
                        <i class="fa-solid fa-rotate-right"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Baris 2: Toolbar Aksi Tabel (Tepat di bawah filter dengan jarak kompak) -->
            <div class="sis-action-toolbar">
                <div class="sis-toolbar-left">
                    <!-- Placeholder reserved space saat tidak ada checkbox dicentang -->
                    <div id="bulkActionPlaceholder" class="sis-bulk-placeholder">
                        <i class="fa-regular fa-square-check"></i>
                        <span>Pilih data pada tabel untuk opsi tindakan massal</span>
                    </div>

                    <!-- Tombol Hapus Terpilih (Contextual: muncul di posisi kiri) -->
                    <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="sis-btn-bulk-del" style="display: none;" title="Hapus Data Terpilih">
                        <i class="fa-regular fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <div class="sis-toolbar-right">
                    @php
                        $trashCount = \App\Models\SiswaSuratIzin::onlyTrashed()->count();
                    @endphp
                    <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="sis-btn-trash-link" title="Lihat Sampah Data Izin Siswa">
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Sampah ({{ $trashCount }})</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="sis-table-wrapper">
            <table class="sis-table">
                <thead>
                    <tr>
                        <th style="width: 30px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="sis-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" title="Pilih Semua (Select All)">
                        </th>
                        <th style="width: 28px; text-align: center;">NO</th>
                        <th style="min-width: 110px; max-width: 130px;">SISWA</th>
                        <th style="width: 80px;">KELAS</th>
                        <th style="width: 75px; text-align: center;">KATEGORI</th>
                        <th style="width: 85px;">TANGGAL &amp; RENTANG</th>
                        <th style="width: 48px; text-align: center;">DURASI</th>
                        <th style="min-width: 110px; max-width: 130px;">KETERANGAN</th>
                        <th style="width: 55px; text-align: center;">BUKTI FOTO</th>
                        <th style="width: 105px;">PETUGAS PIKET</th>
                        <th style="width: 85px; text-align: center;">STATUS</th>
                        <th style="width: 88px; text-align: center;" class="sis-col-aksi">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratIzinList as $index => $item)
                        @php
                            $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                            $namaKelas = $item->kelas->nama_kelas ?? '-';
                            $waliKelasObj = $item->kelas->waliKelas ?? null;
                            $waliNama = $waliKelasObj->nama_guru ?? null;
                            $waliNip  = $waliKelasObj->nip ?? null;

                            $petugasObj  = $item->petugasPiket;
                            $petugasNama = $petugasObj->name ?? 'Petugas Piket';
                            $petugasNip  = $petugasObj->nip ?? ($petugasObj->username ?? '-');

                            $nameParts = explode(' ', trim($namaSiswa));
                            $initials  = count($nameParts) >= 2 
                                ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                                : strtoupper(substr($namaSiswa, 0, 2));

                            $katClass = match($item->kategori) {
                                'Sakit' => 'sakit',
                                'Izin'  => 'izin',
                                default => 'dispen'
                            };

                            $statusBg = match($item->status) {
                                'Terverifikasi' => '#ecfdf5',
                                'Ditolak'       => '#fef2f2',
                                default         => '#fffbeb',
                            };
                            $statusColor = match($item->status) {
                                'Terverifikasi' => '#065f46',
                                'Ditolak'       => '#991b1b',
                                default         => '#b45309',
                            };
                            $statusBorder = match($item->status) {
                                'Terverifikasi' => '#a7f3d0',
                                'Ditolak'       => '#fecaca',
                                default         => '#fde68a',
                            };

                            $tglMulaiFmt   = \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y');
                            $tglSelesaiFmt = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                            $rentangHtml   = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt}<div style='font-size: 9.5px; color: #94a3b8; font-weight: 500; line-height: 1.2;'>s/d {$tglSelesaiFmt}</div>";
                            $durasiText    = ($item->durasi_hari > 0 ? $item->durasi_hari : 1) . ' Hari';

                            // Format json data for modals
                            $itemDataJson = [
                                'id_surat_izin' => $item->id_surat_izin,
                                'nama_siswa'    => $namaSiswa,
                                'nis'           => $item->siswa->nis ?? '-',
                                'nama_kelas'    => $namaKelas,
                                'wali_nama'     => $waliNama,
                                'wali_nip'      => $waliNip,
                                'tanggal'       => $item->tanggal,
                                'tanggal_selesai' => $item->tanggal_selesai ?? $item->tanggal,
                                'durasi_hari'   => $item->durasi_hari,
                                'kategori'      => $item->kategori,
                                'keterangan'    => $item->keterangan,
                                'foto_url'      => $item->foto_url,
                                'petugas_nama'  => $petugasNama,
                                'petugas_nip'   => $petugasNip,
                                'status'        => $item->status ?? 'Terverifikasi',
                                'created_at'    => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                            ];
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="surat-checkbox sis-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" value="{{ $item->id_surat_izin }}" onchange="updateSelectedState()">
                            </td>
                            <td style="font-weight: 700; color: #64748b; text-align: center; font-size: 11px;">
                                {{ $suratIzinList->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="sis-student-cell">
                                    <div class="sis-student-avatar">{{ $initials }}</div>
                                    <div class="sis-student-info">
                                        <span class="sis-student-name">{{ $namaSiswa }}</span>
                                        <span class="sis-student-nis">NIS: {{ $item->siswa->nis ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e3a8a; font-size: 11.5px;">{{ $namaKelas }}</div>
                                @if($waliNama)
                                    <div style="font-size: 10px; color: #64748b; font-weight: 500;">Wali: {{ \Illuminate\Support\Str::limit($waliNama, 16) }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <span class="sis-badge-kategori {{ $katClass }}">
                                    @if($item->kategori == 'Sakit')
                                        <i class="fa-solid fa-notes-medical"></i> Sakit
                                    @elseif($item->kategori == 'Izin')
                                        <i class="fa-solid fa-envelope"></i> Izin
                                    @else
                                        <i class="fa-solid fa-award"></i> Dispen
                                    @endif
                                </span>
                            </td>
                            <td style="font-weight: 600; font-size: 11px; color: #334155; line-height: 1.25;">{!! $rentangHtml !!}</td>
                            <td style="text-align: center;">
                                <span class="sis-durasi-pill">{{ $durasiText }}</span>
                            </td>
                            <td style="color: #475569; font-size: 11px; max-width: 115px;">
                                <span title="{{ $item->keterangan }}">{{ \Illuminate\Support\Str::limit($item->keterangan ?? '-', 28) }}</span>
                            </td>
                            <td style="text-align: center;">
                                @if($item->foto_url)
                                    <button type="button" class="sis-btn-preview-foto" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" title="Lihat Bukti Foto">
                                        <i class="fa-regular fa-image"></i>
                                    </button>
                                @else
                                    <span style="font-size: 10px; color: #94a3b8; font-style: italic;">Tanpa foto</span>
                                @endif
                            </td>
                            <td style="font-size: 11px; color: #475569; line-height: 1.25;">
                                <div style="font-weight: 700; color: #0f172a;">{{ $petugasNama }}</div>
                                <div style="font-size: 10px; color: #64748b;">NIP: {{ $petugasNip }}</div>
                            </td>
                            <td style="text-align: center;">
                                <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusBorder }}; font-size: 10px; padding: 3px 8px; border-radius: 10px; font-weight: 800; display: inline-block; white-space: nowrap;">
                                    {{ $item->status ?? 'Terverifikasi' }}
                                </span>
                            </td>
                            <td class="sis-col-aksi">
                                <div style="display: flex; gap: 3px; justify-content: center;">
                                    <!-- Tombol Detail -->
                                    <button type="button" class="sis-btn-action detail" onclick="openDetailModal({{ json_encode($itemDataJson) }})" title="Lihat Detail Surat Izin">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <!-- Tombol Edit -->
                                    <button type="button" class="sis-btn-action edit" onclick="openEditModal({{ json_encode($itemDataJson) }})" title="Edit Surat Izin">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <!-- Tombol Hapus (Soft Delete) -->
                                    <form action="{{ route('piket.surat-izin-siswa.destroy', $item->id_surat_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan surat izin ini ke sampah?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sis-btn-action delete" title="Hapus ke Sampah">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="sis-empty-box">
                                    <div class="sis-empty-icon">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <div class="sis-empty-text">
                                        Belum ada data permintaan izin siswa yang di-input.
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer & Pagination -->
        <div class="sis-table-footer">
            <div>
                Menampilkan {{ $suratIzinList->firstItem() ?? 0 }} - {{ $suratIzinList->lastItem() ?? 0 }} dari {{ $suratIzinList->total() }} data
            </div>
            <div>
                @if($suratIzinList->hasPages())
                    {{ $suratIzinList->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </div>

    <!-- 5. Mobile Section (Filter Card + Cards List + Pagination) -->
    <div class="mobile-sis-section">
        
        <!-- Filter Card Mobile -->
        <div class="mobile-sis-filter-card">
            <div class="mobile-sis-filter-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="m-card-icon-wrap">
                        <i class="fa-solid fa-table-list"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Surat Izin Siswa</h2>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 1px;">
                            Total: {{ $suratIzinList->total() }} Data Surat
                        </div>
                    </div>
                </div>
                @php
                    $trashCount = \App\Models\SiswaSuratIzin::onlyTrashed()->count();
                @endphp
                <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="m-btn-trash-pill" title="Lihat Sampah Data Izin Siswa">
                    <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashCount }})
                </a>
            </div>

            <!-- Search Bar + Filter Trigger Button -->
            <div class="mobile-sis-search-row">
                <form action="{{ route('piket.surat-izin-siswa') }}" method="GET" class="m-search-form">
                    @if(request('id_kelas'))
                        <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}">
                    @endif
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    @if(request('tanggal'))
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    @endif
                    <div class="m-search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Siswa / NIS / Keterangan..." class="m-search-input">
                    </div>
                    <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()">
                        <i class="fa-solid fa-filter"></i> Filter
                        @if(request('id_kelas') || request('kategori') || request('tanggal'))
                            <span class="m-filter-active-dot"></span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Cards List Mobile -->
        <div class="mobile-sis-cards-list">
            @forelse($suratIzinList as $item)
                @php
                    $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                    $namaKelas = $item->kelas->nama_kelas ?? '-';
                    $waliKelasObj = $item->kelas->waliKelas ?? null;
                    $waliNama = $waliKelasObj->nama_guru ?? null;
                    $waliNip  = $waliKelasObj->nip ?? null;

                    $petugasObj  = $item->petugasPiket;
                    $petugasNama = $petugasObj->name ?? 'Petugas Piket';
                    $petugasNip  = $petugasObj->nip ?? ($petugasObj->username ?? '-');

                    $katClass = match($item->kategori) {
                        'Sakit' => 'sakit',
                        'Izin'  => 'izin',
                        default => 'dispen'
                    };

                    $statusBg = match($item->status) {
                        'Terverifikasi' => '#ecfdf5',
                        'Ditolak'       => '#fef2f2',
                        default         => '#fffbeb',
                    };
                    $statusColor = match($item->status) {
                        'Terverifikasi' => '#065f46',
                        'Ditolak'       => '#991b1b',
                        default         => '#b45309',
                    };
                    $statusBorder = match($item->status) {
                        'Terverifikasi' => '#a7f3d0',
                        'Ditolak'       => '#fecaca',
                        default         => '#fde68a',
                    };

                    $startDate = \Carbon\Carbon::parse($item->tanggal);
                    $endDate = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai) : $startDate;
                    $isMultiDay = ($item->tanggal_selesai && $item->tanggal !== $item->tanggal_selesai);

                    if (!$isMultiDay) {
                        $dayDisplay = $startDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } elseif ($startDate->format('m Y') === $endDate->format('m Y')) {
                        $dayDisplay = $startDate->format('d') . '-' . $endDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } else {
                        $dayDisplay = $startDate->format('d/m') . '-' . $endDate->format('d/m');
                        $monthDisplay = $startDate->format('Y');
                        $yearDisplay = '';
                    }

                    $durasiNum = $item->durasi_hari > 0 ? $item->durasi_hari : 1;
                    $durasiText = $durasiNum . ' Hari';

                    $itemDataJson = [
                        'id_surat_izin' => $item->id_surat_izin,
                        'nama_siswa'    => $namaSiswa,
                        'nis'           => $item->siswa->nis ?? '-',
                        'nama_kelas'    => $namaKelas,
                        'wali_nama'     => $waliNama,
                        'wali_nip'      => $waliNip,
                        'tanggal'       => $item->tanggal,
                        'tanggal_selesai' => $item->tanggal_selesai ?? $item->tanggal,
                        'durasi_hari'   => $item->durasi_hari,
                        'kategori'      => $item->kategori,
                        'keterangan'    => $item->keterangan,
                        'foto_url'      => $item->foto_url,
                        'petugas_nama'  => $petugasNama,
                        'petugas_nip'   => $petugasNip,
                        'status'        => $item->status ?? 'Terverifikasi',
                        'created_at'    => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                @endphp

                <div class="mobile-sis-card-item card-{{ $katClass }}">
                    <!-- Left Tiered Date Column -->
                    <div class="mobile-card-date-col date-{{ $katClass }}">
                        <div class="m-date-day">{{ $dayDisplay }}</div>
                        <div class="m-date-month">{{ $monthDisplay }}</div>
                        @if($yearDisplay)
                            <div class="m-date-year">{{ $yearDisplay }}</div>
                        @endif
                        <span class="m-date-durasi-badge">{{ $durasiText }}</span>
                    </div>

                    <!-- Right Card Content -->
                    <div class="mobile-card-content">
                        <!-- Badges Row -->
                        <div class="m-card-badges-row">
                            <span class="sis-badge-kategori {{ $katClass }}">
                                @if($item->kategori == 'Sakit')
                                    <i class="fa-solid fa-notes-medical"></i> Sakit
                                @elseif($item->kategori == 'Izin')
                                    <i class="fa-solid fa-envelope"></i> Izin
                                @else
                                    <i class="fa-solid fa-award"></i> Dispen
                                @endif
                            </span>

                            <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusBorder }}; font-size: 10px; padding: 2px 7px; border-radius: 8px; font-weight: 800; display: inline-block; white-space: nowrap;">
                                {{ $item->status ?? 'Terverifikasi' }}
                            </span>
                        </div>

                        <!-- Student & Class Info -->
                        <div>
                            <div class="m-card-student-name">{{ $namaSiswa }}</div>
                            <div class="m-card-sub-info">
                                <span class="m-card-class-badge">{{ $namaKelas }}</span>
                                <span>NIS: {{ $item->siswa->nis ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Wali Kelas Info if exists -->
                        @if($waliNama)
                            <div style="font-size: 10.5px; color: #64748b; font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-user-tie" style="color: #94a3b8; font-size: 10px;"></i>
                                <span>Wali: {{ $waliNama }}</span>
                            </div>
                        @endif

                        <!-- Reason Quote Box -->
                        <div class="m-card-reason-box">
                            "{{ Str::limit($item->keterangan ?? 'Tidak ada keterangan.', 70) }}"
                        </div>

                        <!-- Foto Bukti Indicator -->
                        @if($item->foto_url)
                            <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                <button type="button" class="sis-btn-preview-foto" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" title="Lihat Bukti Foto" style="width: auto; height: 26px; padding: 0 8px; gap: 4px; font-size: 10.5px; font-weight: 600;">
                                    <i class="fa-regular fa-image"></i>
                                    <span>Bukti Foto Terlampir</span>
                                </button>
                            </div>
                        @endif

                        <!-- Footer Actions -->
                        <div class="m-card-footer-row">
                            <button type="button" class="sis-btn-action edit" onclick="openEditModal({{ json_encode($itemDataJson) }})" title="Edit Surat Izin" style="width: auto; height: 26px; padding: 0 8px; gap: 4px; font-size: 11px; font-weight: 700; border-radius: 7px;">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </button>
                            <button type="button" class="m-btn-detail-link" onclick="openDetailModal({{ json_encode($itemDataJson) }})">
                                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="sis-card" style="text-align: center; padding: 36px 16px; margin-bottom: 0;">
                    <div class="sis-empty-box" style="padding: 10px 0;">
                        <div class="sis-empty-icon">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        <div class="sis-empty-text">Belum ada data permintaan izin siswa yang di-input.</div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Mobile Pagination Card -->
        @if($suratIzinList->hasPages())
            <div class="mobile-pagination-card">
                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                    {{ $suratIzinList->firstItem() ?? 0 }}-{{ $suratIzinList->lastItem() ?? 0 }} dari {{ $suratIzinList->total() }}
                </span>
                <div>
                    {{ $suratIzinList->withQueryString()->links() }}
                </div>
            </div>
        @endif

    </div>

</div>

<!-- Modal Detail Surat Izin Siswa -->
<div id="detailModal" class="sis-modal-overlay" onclick="closeDetailModal(event)">
    <div class="sis-modal-box" onclick="event.stopPropagation()">
        <div class="sis-modal-header">
            <h3><i class="fa-solid fa-address-card" style="color:#2563eb;"></i> Detail Informasi Surat Izin Siswa</h3>
            <button type="button" class="sis-modal-close" onclick="closeDetailModalDirect()">&times;</button>
        </div>
        <div class="sis-modal-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px;">
                <div style="grid-column: 1 / -1; display: flex; align-items: center; gap: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px;">
                    <div id="det_avatar" class="sis-student-avatar" style="width: 44px; height: 44px; font-size: 15px;">--</div>
                    <div>
                        <div id="det_nama_siswa" style="font-size: 15px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="det_kelas_nis" style="font-size: 12px; color: #64748b; font-weight: 600;">-</div>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Wali Kelas</div>
                    <div id="det_wali_kelas" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kategori Ketidakhadiran</div>
                    <div id="det_kategori" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tanggal Mulai Izin</div>
                    <div id="det_tgl_mulai" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tanggal Selesai Izin</div>
                    <div id="det_tgl_selesai" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="grid-column: 1 / -1; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #1d4ed8; text-transform: uppercase;">Total Durasi Ketidakhadiran</div>
                    <div id="det_durasi" style="font-size: 14px; font-weight: 800; color: #1e3a8a; margin-top: 2px;">-</div>
                </div>

                <div style="grid-column: 1 / -1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Keterangan / Detail Alasan</div>
                    <div id="det_keterangan" style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px; line-height: 1.4;">-</div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Petugas Piket Peng-input</div>
                    <div id="det_petugas" style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Waktu Penginputan</div>
                    <div id="det_waktu_input" style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">-</div>
                </div>

                <div style="grid-column: 1 / -1; text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Foto Bukti Fisik Surat / Dokumen</div>
                    <div id="det_foto_container">
                        <img id="det_foto_img" src="" alt="Bukti Surat" style="max-width: 100%; max-height: 300px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>

            <!-- Footer: Option A Delete Button + Edit Button + Close Button -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px; border-top: 1px solid #e2e8f0; padding-top: 14px; flex-wrap: wrap; gap: 8px;">
                <form id="formDeleteDetail" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan surat izin siswa ini ke sampah?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="m-btn-modal-delete">
                        <i class="fa-regular fa-trash-can"></i> Pindahkan ke Sampah
                    </button>
                </form>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" id="det_btn_edit" class="sis-btn-reset" style="padding: 7px 14px; font-size: 12px; gap: 6px; font-weight: 700; border-radius: 10px;">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="sis-btn-submit" onclick="closeDetailModalDirect()" style="padding: 7px 18px; font-size: 12.5px; border-radius: 10px;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Bukti (Lightbox) -->
<div id="fotoModal" class="sis-modal-overlay" onclick="closeFotoModal(event)">
    <div class="sis-modal-box" onclick="event.stopPropagation()" style="max-width: 580px;">
        <div class="sis-modal-header">
            <h3 id="modalFotoTitle"><i class="fa-regular fa-image" style="color: #2563eb;"></i> Bukti Surat / Dokumen Siswa</h3>
            <button type="button" class="sis-modal-close" onclick="closeFotoModalDirect()">&times;</button>
        </div>
        <div class="sis-modal-body" style="text-align: center;">
            <img id="modalFotoImg" src="" alt="Bukti Surat Izin Siswa" style="max-width: 100%; max-height: 65vh; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    </div>
</div>

<!-- Modal Edit Data Surat Izin -->
<div id="editModal" class="sis-modal-overlay" onclick="closeEditModal(event)">
    <div class="sis-modal-box" onclick="event.stopPropagation()" style="max-width: 580px;">
        <div class="sis-modal-header">
            <h3><i class="fa-regular fa-pen-to-square" style="color: #2563eb;"></i> Edit Data Surat Izin Siswa</h3>
            <button type="button" class="sis-modal-close" onclick="closeEditModalDirect()">&times;</button>
        </div>
        <div class="sis-modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div class="sis-form-group">
                        <label class="sis-label"><span>Nama Siswa &amp; Kelas</span></label>
                        <input type="text" id="edit_siswa_nama" class="sis-input" readonly style="background: #f1f5f9; font-weight: 700; color: #334155; padding-left: 14px;">
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label"><span>Wali Kelas</span></label>
                        <input type="text" id="edit_wali_kelas" class="sis-input" readonly style="background: #f8fafc; color: #64748b; font-weight: 600; padding-left: 14px;">
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label"><span>Tanggal Mulai Izin</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="sis-input" onchange="calculateEditDurasi()" required style="padding-left: 14px;">
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label">
                            <span>Tanggal Selesai Izin</span>
                            <span id="editDurasiPill" class="sis-durasi-pill">1 Hari</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="sis-input" onchange="calculateEditDurasi()" required style="padding-left: 14px;">
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label"><span>Kategori Ketidakhadiran</span></label>
                        <select name="kategori" id="edit_kategori" class="sis-select" required style="padding-left: 14px;">
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                        </select>
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label"><span>Status Verifikasi</span></label>
                        <select name="status" id="edit_status" class="sis-select" required style="padding-left: 14px;">
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <!-- Pratinjau Foto Bukti Lama -->
                    <div class="sis-form-group">
                        <label class="sis-label"><span>Foto Bukti Surat / Dokumen</span></label>
                        <div id="edit_foto_preview_container" style="margin-bottom: 8px; text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1;">
                            <img id="edit_foto_preview_img" src="" alt="Foto Bukti Lama" style="max-height: 150px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div id="edit_foto_none_text" style="display:none; font-size: 12px; color: #94a3b8; font-style: italic;">Belum ada foto yang diunggah.</div>
                        </div>
                        <input type="file" name="foto_bukti" class="sis-input" accept="image/jpeg,image/png,image/jpg,image/webp" style="padding-left: 14px;">
                        <span class="sis-file-hint">Pilih file gambar baru jika ingin mengganti foto bukti fisik yang tersimpan.</span>
                    </div>

                    <div class="sis-form-group">
                        <label class="sis-label"><span>Keterangan / Detail Alasan <span class="req">*</span></span></label>
                        <textarea name="keterangan" id="edit_keterangan" rows="3" class="sis-textarea" required style="padding-left: 14px;"></textarea>
                    </div>

                    <div style="margin-top: 10px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" class="sis-btn-reset" onclick="closeEditModalDirect()">Batal</button>
                        <button type="submit" class="sis-btn-submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Massal Surat Izin -->
<div id="bulkDeleteModal" class="sis-modal-overlay" onclick="if(event.target.id==='bulkDeleteModal') closeBulkDeleteModal()">
    <div class="sis-modal-box" onclick="event.stopPropagation()" style="max-width: 440px;">
        <div class="sis-modal-header" style="background: #fef2f2; border-bottom: 1px solid #fee2e2;">
            <h3 style="color: #dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" class="sis-modal-close" onclick="closeBulkDeleteModal()">&times;</button>
        </div>
        <div class="sis-modal-body" style="text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; color: #dc2626; font-size: 24px;">
                <i class="fa-regular fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13px; color: #64748b; font-weight: 500; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #dc2626;">0</strong> data surat izin siswa yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="sis-btn-reset">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" class="sis-btn-submit" style="background: #dc2626; border-color: #b91c1c; box-shadow: 0 2px 8px rgba(220,38,38,0.25);">
                    <i class="fa-regular fa-trash-can"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Hapus Massal Surat Izin -->
<form id="bulkDeleteForm" action="{{ route('piket.surat-izin-siswa.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Filter Mobile Surat Izin Siswa -->
<div id="mobileFilterModal" class="sis-modal-overlay">
    <div class="sis-modal-box" style="max-width: 440px;">
        <div class="sis-modal-header">
            <h3><i class="fa-solid fa-filter" style="color: #2563eb;"></i> Filter Surat Izin Siswa</h3>
            <button type="button" class="sis-modal-close" onclick="closeMobileFilterModal()">&times;</button>
        </div>
        <form action="{{ route('piket.surat-izin-siswa') }}" method="GET">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label class="m-filter-label"><i class="fa-solid fa-users" style="color: #2563eb;"></i> Kelas Siswa</label>
                    <select name="id_kelas" class="m-filter-select">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="m-filter-label"><i class="fa-solid fa-tag" style="color: #2563eb;"></i> Kategori Ketidakhadiran</label>
                    <select name="kategori" class="m-filter-select">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Sakit" {{ request('kategori') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ request('kategori') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Dispen Luar Sekolah" {{ request('kategori') == 'Dispen Luar Sekolah' ? 'selected' : '' }}>Dispen Luar Sekolah</option>
                    </select>
                </div>
                <div>
                    <label class="m-filter-label"><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> Tanggal Izin</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="m-filter-input">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('piket.surat-izin-siswa') }}" class="sis-btn-reset" style="text-decoration: none; justify-content: center; height: 42px; font-weight: 700;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="sis-btn-submit" style="justify-content: center; height: 42px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer;">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File Input Name Display Handler
    function updateFileNameDisplay(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files.length > 0) {
            display.textContent = input.files[0].name;
            display.style.color = '#0f172a';
            display.style.fontWeight = '600';
        } else {
            display.textContent = 'Tidak ada file yang dipilih';
            display.style.color = '#64748b';
            display.style.fontWeight = 'normal';
        }
    }

    // Dynamic Filter Student by Class & Display Wali Kelas Info
    function filterSiswaByKelasForm() {
        const selectKelas = document.getElementById('form_select_kelas');
        const selectedOption = selectKelas.options[selectKelas.selectedIndex];
        const selectedKelasId = selectKelas.value;

        const waliBadge = document.getElementById('form_wali_kelas_badge');
        const waliText  = document.getElementById('form_wali_kelas_text');

        if (!selectedKelasId) {
            waliBadge.style.display = 'none';
            waliBadge.className = 'sis-wali-badge';
            waliText.textContent = '-- Pilih Kelas Terlebih Dahulu --';
        } else {
            const waliNama = selectedOption.getAttribute('data-wali-nama');
            const waliNip  = selectedOption.getAttribute('data-wali-nip');

            if (waliNama && waliNama.trim() !== '') {
                const nipStr = (waliNip && waliNip.trim() !== '') ? ` (NIP: ${waliNip})` : '';
                waliText.innerHTML = `Wali Kelas: <strong>${waliNama}</strong>${nipStr}`;
                waliBadge.className = 'sis-wali-badge';
                waliBadge.style.display = 'inline-flex';
            } else {
                waliText.innerHTML = `Wali Kelas: <em>Belum Ada Wali Kelas Terdaftar</em>`;
                waliBadge.className = 'sis-wali-badge empty';
                waliBadge.style.display = 'inline-flex';
            }
        }

        // Filter Student Dropdown
        const siswaSelect = document.getElementById('form_select_siswa');
        const options = siswaSelect.querySelectorAll('option');

        siswaSelect.selectedIndex = 0;

        if (!selectedKelasId) {
            siswaSelect.disabled = true;
            options[0].textContent = '-- Pilih Kelas Terlebih Dahulu --';
            return;
        }

        siswaSelect.disabled = false;
        options[0].textContent = '-- Pilih Siswa --';

        let countVisible = 0;
        options.forEach((opt, idx) => {
            if (idx === 0) return;
            const optKelasId = opt.getAttribute('data-kelas');
            if (optKelasId === selectedKelasId) {
                opt.style.display = 'block';
                countVisible++;
            } else {
                opt.style.display = 'none';
            }
        });

        if (countVisible === 0) {
            options[0].textContent = '-- Tidak ada siswa di kelas ini --';
        }
    }

    // Live Calculate Durasi Hari & Strict Date Validation
    function calculateDurasiLive() {
        const tglMulaiInput = document.getElementById('form_tgl_mulai');
        const tglSelesaiInput = document.getElementById('form_tgl_selesai');
        const durasiBadge = document.getElementById('durasiPillBadge');
        const warningBox = document.getElementById('dateValidationWarning');
        const btnSubmit = document.getElementById('btnSubmitForm');

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai < dateMulai) {
            tglSelesaiInput.style.borderColor = '#ef4444';
            warningBox.style.display = 'flex';
            durasiBadge.textContent = 'Invalid Date';
            durasiBadge.style.background = '#fee2e2';
            durasiBadge.style.color = '#991b1b';
            durasiBadge.style.borderColor = '#fca5a5';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
            btnSubmit.style.cursor = 'not-allowed';
        } else {
            tglSelesaiInput.style.borderColor = '#cbd5e1';
            warningBox.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
            btnSubmit.style.cursor = 'pointer';

            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            durasiBadge.textContent = diffDays + ' Hari';
            durasiBadge.style.background = '#eff6ff';
            durasiBadge.style.color = '#2563eb';
            durasiBadge.style.borderColor = '#bfdbfe';
        }
    }

    function calculateEditDurasi() {
        const tglMulaiInput = document.getElementById('edit_tanggal');
        const tglSelesaiInput = document.getElementById('edit_tanggal_selesai');
        const durasiBadge = document.getElementById('editDurasiPill');

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai >= dateMulai) {
            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            durasiBadge.textContent = diffDays + ' Hari';
            durasiBadge.style.background = '#eff6ff';
            durasiBadge.style.color = '#2563eb';
            durasiBadge.style.borderColor = '#bfdbfe';
        } else {
            durasiBadge.textContent = 'Invalid';
            durasiBadge.style.background = '#fee2e2';
            durasiBadge.style.color = '#991b1b';
            durasiBadge.style.borderColor = '#fca5a5';
        }
    }

    // Reset Form Custom
    function resetFormCustom() {
        document.getElementById('suratIzinInputForm').reset();
        document.getElementById('fileNameDisplay').textContent = 'Tidak ada file yang dipilih';
        document.getElementById('fileNameDisplay').style.color = '#64748b';
        document.getElementById('fileNameDisplay').style.fontWeight = 'normal';
        filterSiswaByKelasForm();
        calculateDurasiLive();
    }

    // Open Detail Modal
    function openDetailModal(item) {
        const namaSiswa = item.nama_siswa || 'Siswa';
        const namaKelas = item.nama_kelas || '-';
        const nis       = item.nis || '-';

        const nameParts = namaSiswa.split(' ');
        const initials = nameParts.length >= 2
            ? (nameParts[0][0] + nameParts[1][0]).toUpperCase()
            : namaSiswa.substring(0, 2).toUpperCase();

        document.getElementById('det_avatar').textContent = initials;
        document.getElementById('det_nama_siswa').textContent = namaSiswa;
        document.getElementById('det_kelas_nis').textContent = `Kelas: ${namaKelas} | NIS: ${nis}`;

        // Wali Kelas Info
        const waliNama = item.wali_nama;
        const waliNip  = item.wali_nip;
        if (waliNama && waliNama.trim() !== '') {
            const nipStr = waliNip ? ` (NIP: ${waliNip})` : '';
            document.getElementById('det_wali_kelas').innerHTML = `<strong>${waliNama}</strong>${nipStr}`;
        } else {
            document.getElementById('det_wali_kelas').innerHTML = `<em style="color:#94a3b8;">Belum Ada Wali Kelas</em>`;
        }

        document.getElementById('det_kategori').textContent = item.kategori;

        const tglMulaiFmt   = formatDateIndo(item.tanggal);
        const tglSelesaiFmt = item.tanggal_selesai ? formatDateIndo(item.tanggal_selesai) : tglMulaiFmt;
        const durasiText    = (item.durasi_hari > 0 ? item.durasi_hari : 1) + ' Hari';

        document.getElementById('det_tgl_mulai').textContent = tglMulaiFmt;
        document.getElementById('det_tgl_selesai').textContent = tglSelesaiFmt;
        document.getElementById('det_durasi').textContent = `${durasiText} (${tglMulaiFmt} ${tglMulaiFmt !== tglSelesaiFmt ? 's/d ' + tglSelesaiFmt : ''})`;

        document.getElementById('det_keterangan').textContent = item.keterangan || '-';

        // Petugas Piket Info with NIP
        const petNama = item.petugas_nama || 'Guru Piket';
        const petNip  = item.petugas_nip || '-';
        document.getElementById('det_petugas').innerHTML = `<strong>${petNama}</strong> (NIP: ${petNip})`;
        
        document.getElementById('det_waktu_input').textContent = item.created_at ? formatDateIndoTime(item.created_at) : '-';

        const fotoContainer = document.getElementById('det_foto_container');
        const fotoImg = document.getElementById('det_foto_img');
        if (item.foto_url) {
            fotoImg.src = item.foto_url;
            fotoContainer.style.display = 'block';
        } else {
            fotoContainer.innerHTML = '<span style="font-size: 12px; color: #94a3b8; font-style: italic;">Tidak ada foto bukti yang terlampir.</span>';
        }

        // Option A Delete Form & Edit Button Handler
        const formDel = document.getElementById('formDeleteDetail');
        if (formDel) {
            formDel.action = `/guru-piket/surat-izin-siswa/${item.id_surat_izin}`;
        }
        const editBtn = document.getElementById('det_btn_edit');
        if (editBtn) {
            editBtn.onclick = function() {
                closeDetailModalDirect();
                openEditModal(item);
            };
        }

        document.getElementById('detailModal').classList.add('active');
    }

    function closeDetailModal(e) {
        if (e.target.id === 'detailModal') closeDetailModalDirect();
    }

    function closeDetailModalDirect() {
        document.getElementById('detailModal').classList.remove('active');
    }

    // Modal Foto Lightbox
    function showFotoModal(imgUrl, title) {
        document.getElementById('modalFotoImg').src = imgUrl;
        document.getElementById('modalFotoTitle').innerHTML = `<i class="fa-regular fa-image" style="color: #2563eb;"></i> ${title}`;
        document.getElementById('fotoModal').classList.add('active');
    }

    function closeFotoModal(e) {
        if (e.target.id === 'fotoModal') closeFotoModalDirect();
    }

    function closeFotoModalDirect() {
        document.getElementById('fotoModal').classList.remove('active');
    }

    // Modal Edit
    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = `/guru-piket/surat-izin-siswa/${item.id_surat_izin}`;
        document.getElementById('edit_siswa_nama').value = (item.nama_siswa || 'Siswa') + ' (' + (item.nama_kelas || '-') + ')';
        
        const waliNama = item.wali_nama;
        const waliNip  = item.wali_nip;
        if (waliNama && waliNama.trim() !== '') {
            document.getElementById('edit_wali_kelas').value = waliNama + (waliNip ? ` (NIP: ${waliNip})` : '');
        } else {
            document.getElementById('edit_wali_kelas').value = 'Belum Ada Wali Kelas';
        }

        document.getElementById('edit_tanggal').value = item.tanggal;
        document.getElementById('edit_tanggal_selesai').value = item.tanggal_selesai || item.tanggal;
        document.getElementById('edit_kategori').value = item.kategori;
        document.getElementById('edit_status').value = item.status || 'Terverifikasi';
        document.getElementById('edit_keterangan').value = item.keterangan || '';

        // Existing Photo Preview in Edit Modal
        const previewImg = document.getElementById('edit_foto_preview_img');
        const noneText   = document.getElementById('edit_foto_none_text');
        if (item.foto_url) {
            previewImg.src = item.foto_url;
            previewImg.style.display = 'inline-block';
            noneText.style.display = 'none';
        } else {
            previewImg.style.display = 'none';
            noneText.style.display = 'block';
        }

        calculateEditDurasi();
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal(e) {
        if (e.target.id === 'editModal') closeEditModalDirect();
    }

    function closeEditModalDirect() {
        document.getElementById('editModal').classList.remove('active');
    }

    // Helper Date Formatters
    function formatDateIndo(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }

    function formatDateIndoTime(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    // Mobile Carousel Logic
    let currentSisStatSlide = 0;
    const totalSisStatSlides = 4;

    function updateSisStatCarousel() {
        const track = document.getElementById('mobileStatTrack');
        if (!track) return;
        track.style.transform = 'translateX(-' + (currentSisStatSlide * 100) + '%)';
        
        const dots = document.querySelectorAll('#mobileStatDots .m-stat-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentSisStatSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function nextSisStatSlide() {
        currentSisStatSlide = (currentSisStatSlide + 1) % totalSisStatSlides;
        updateSisStatCarousel();
    }

    function prevSisStatSlide() {
        currentSisStatSlide = (currentSisStatSlide - 1 + totalSisStatSlides) % totalSisStatSlides;
        updateSisStatCarousel();
    }

    function goToSisStatSlide(index) {
        currentSisStatSlide = index;
        updateSisStatCarousel();
    }

    function initSisStatCarousel() {
        const container = document.getElementById('mobileStatContainer');
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
                nextSisStatSlide();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                prevSisStatSlide();
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

    // Initialize Live Duration on Load
    document.addEventListener('DOMContentLoaded', function() {
        calculateDurasiLive();
        initSisStatCarousel();
    });

    // Checkbox & Bulk Delete Handler
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.surat-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.surat-checkbox');
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
        const btnBulk = document.getElementById('btnBulkDelete');
        const placeholder = document.getElementById('bulkActionPlaceholder');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllCb = document.getElementById('selectAllCheckbox');

        const count = checkedBoxes.length;
        if (selectedCountSpan) selectedCountSpan.textContent = count;

        if (selectAllCb && checkboxes.length > 0) {
            selectAllCb.checked = (checkboxes.length === count);
            selectAllCb.indeterminate = (count > 0 && count < checkboxes.length);
        }

        if (btnBulk) {
            if (count > 0) {
                btnBulk.style.display = 'inline-flex';
                btnBulk.style.opacity = '1';
                btnBulk.style.pointerEvents = 'auto';
                if (placeholder) placeholder.style.display = 'none';
            } else {
                btnBulk.style.display = 'none';
                if (placeholder) placeholder.style.display = 'inline-flex';
            }
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu data surat izin yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').classList.add('active');
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').classList.remove('active');
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
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
