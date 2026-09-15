@extends('layouts.guru')

@section('title', 'Guru Pengganti — Guru Piket')
@section('header_title', 'Guru Pengganti')

@section('styles')
<style>
    .guru-pengganti-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: -12px;
        margin-bottom: 4px;
    }

    /* Form Input & Placeholder Styling - Subtle & Transparent for Easy Guidance */
    ::placeholder {
        color: #94a3b8 !important;
        opacity: 0.75 !important;
        font-weight: 500 !important;
        font-style: italic !important;
    }
    ::-webkit-input-placeholder {
        color: #94a3b8 !important;
        opacity: 0.75 !important;
        font-weight: 500 !important;
        font-style: italic !important;
    }
    :-ms-input-placeholder {
        color: #94a3b8 !important;
        opacity: 0.75 !important;
        font-weight: 500 !important;
        font-style: italic !important;
    }

    .form-hint-text {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 4px;
        opacity: 0.85;
    }

    /* Alert Banner */
    .alert-banner {
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* Form Direct Card (Atas) */
    .direct-form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #cbd5e1;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-card-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .direct-form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .form-group-full {
        grid-column: span 3;
    }

    .form-group-half {
        grid-column: span 1.5;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
        font-weight: 600;
        transition: border-color 0.2s ease;
    }

    .form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .input-error-border {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .field-error-text {
        font-size: 11.5px;
        color: #dc2626;
        font-weight: 700;
        margin-top: 4px;
    }

    .btn-submit-penugasan {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .btn-submit-penugasan:hover {
        background: #1e293b;
    }

    .btn-reset-form {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-reset-form:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-toggle-guru-lainnya {
        background: #f8fafc;
        color: #2563eb;
        border: 1px dashed #cbd5e1;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        transition: all 0.2s ease;
    }
    .btn-toggle-guru-lainnya:hover {
        background: #eff6ff;
        border-color: #93c5fd;
    }

    /* Unified Schedule Selector Panel */
    .jadwal-unified-panel {
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%);
        border: 1.5px solid #86efac;
        border-radius: 14px;
        padding: 16px 18px;
        margin-top: 4px;
        margin-bottom: 6px;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.06);
        transition: all 0.25s ease;
    }

    .jadwal-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #dcfce7;
    }

    .jadwal-panel-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .jadwal-panel-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #dcfce7;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .jadwal-panel-title {
        margin: 0;
        font-size: 13.5px;
        font-weight: 800;
        color: #14532d;
        letter-spacing: -0.01em;
    }

    .jadwal-panel-subtitle {
        margin: 2px 0 0 0;
        font-size: 11.5px;
        font-weight: 600;
        color: #166534;
        opacity: 0.9;
    }

    .jadwal-panel-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-panel-action {
        padding: 6px 13px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-select-all {
        background: #ffffff;
        border: 1.5px solid #22c55e;
        color: #15803d;
    }
    .btn-select-all:hover {
        background: #22c55e;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(34, 197, 94, 0.2);
    }

    .btn-unselect-all {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #64748b;
    }
    .btn-unselect-all:hover {
        background: #f1f5f9;
        color: #334155;
        border-color: #94a3b8;
    }

    /* Sehari Penuh Quick Banner */
    .jadwal-sehari-penuh-card {
        margin-top: 10px;
        background: #ffffff;
        border: 1.5px solid #bfdbfe;
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: all 0.2s ease;
    }

    .jadwal-sehari-penuh-card.active {
        background: #eff6ff;
        border-color: #3b82f6;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }

    .sehari-penuh-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 12.5px;
        color: #1e40af;
        margin: 0;
        user-select: none;
    }

    /* Grid of Session Cards */
    .jadwal-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .jadwal-card-item {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 14px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .jadwal-card-item:hover {
        border-color: #86efac;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .jadwal-card-item.selected {
        border-color: #22c55e;
        background: #f0fdf4;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
    }

    .jadwal-card-item.sehari-penuh-selected {
        border-color: #3b82f6;
        background: #eff6ff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .jadwal-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .jadwal-card-checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .jadwal-card-checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #16a34a;
        cursor: pointer;
    }

    .jadwal-sesi-badge {
        font-size: 10.5px;
        font-weight: 800;
        background: #e0f2fe;
        color: #0369a1;
        padding: 2px 8px;
        border-radius: 6px;
        letter-spacing: 0.02em;
    }

    .jadwal-card-item.selected .jadwal-sesi-badge {
        background: #dcfce7;
        color: #15803d;
    }

    .jadwal-card-item.sehari-penuh-selected .jadwal-sesi-badge {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .jadwal-card-class {
        font-weight: 800;
        font-size: 13.5px;
        color: #0f172a;
    }

    .jadwal-card-mapel {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .jadwal-card-time {
        font-size: 11.5px;
        font-weight: 700;
        color: #2563eb;
        background: #eff6ff;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
    }

    .jadwal-card-item.selected .jadwal-card-time {
        background: #dcfce7;
        color: #15803d;
    }

    .jadwal-card-footer-hint {
        font-size: 10.5px;
        font-weight: 700;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2px;
        padding-top: 6px;
        border-top: 1px dashed #e2e8f0;
    }

    .jadwal-card-item.selected .jadwal-card-footer-hint {
        color: #16a34a;
        border-color: #bbf7d0;
    }

    /* Live Feedback Footer Bar */
    .jadwal-feedback-bar {
        margin-top: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .jadwal-feedback-single {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .jadwal-feedback-multi {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .jadwal-feedback-all {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .jadwal-empty-alert {
        padding: 14px 16px;
        border-radius: 10px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
        font-size: 12.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1.5;
        min-width: 220px;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }

    .filter-item {
        flex: 1;
        min-width: 130px;
    }

    .filter-item select, .filter-item input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
    }

    .btn-filter-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: background 0.2s ease;
    }
    .btn-filter-submit:hover { background: #1d4ed8; }

    .btn-filter-reset {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .btn-filter-reset:hover { background: #e2e8f0; color: #1e293b; }

    /* Stat Cards Grid (3 Cards) */
    .stat-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }
    .stat-icon-gold   { background: #fef3c7; color: #d97706; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-link {
        font-size: 12px;
        font-weight: 700;
        color: #6366f1;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .stat-link:hover { text-decoration: underline; }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .btn-trash-toggle {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-trash-toggle:hover {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-penugasan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-penugasan-table th {
        background: #dfd8c8;
        color: #1e293b;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #d1c9b6;
        border-bottom: 1px solid #d1c9b6;
    }

    .custom-penugasan-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .custom-penugasan-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; }

    .custom-penugasan-table td {
        padding: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .date-cell {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .date-day {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .date-month {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .badge-status-aktif {
        background: #d1fae5;
        color: #065f46;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-selesai {
        background: #dbeafe;
        color: #1e40af;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-dibatalkan {
        background: #fee2e2;
        color: #991b1b;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .btn-action-dots {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-dots:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    .btn-action-edit:hover {
        background: #d97706 !important;
        color: #ffffff !important;
        border-color: #d97706 !important;
    }

    .btn-action-trash:hover {
        background: #ef4444 !important;
        color: #ffffff !important;
        border-color: #ef4444 !important;
    }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .page-btn.active {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-content {
        background: #ffffff;
        width: 100%;
        max-width: 640px;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    @media (max-width: 992px) {
        .direct-form-grid { grid-template-columns: 1fr; }
        .form-group-full, .form-group-half { grid-column: span 1; }
        .stat-grid-3 { grid-template-columns: 1fr; }
        .filter-grid { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')
<div class="guru-pengganti-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Guru Pengganti</h1>
            <p>Kelola penunjukan guru pengganti untuk kelas yang gurunya berhalangan hadir</p>
        </div>
    </div>

    <!-- Alert Success / Errors Notification -->
    @if(session('success'))
        <div class="alert-banner alert-success">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-banner alert-danger">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
            <div>
                <strong>Terdapat kesalahan atau kendala penugasan:</strong>
                <ul style="margin-top: 4px; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- 1. Form Penugasan Guru Pengganti DIRECT (Tersedia Paling Atas) -->
    <div class="direct-form-card">
        <div class="form-card-header">
            <div class="form-card-title">
                <i class="fa-solid fa-user-plus" style="color: #2b3957; font-size: 20px;"></i>
                <span>Tambah Penugasan Guru Pengganti</span>
            </div>
        </div>

        <form action="{{ route('piket.guru-pengganti.store') }}" method="POST" enctype="multipart/form-data" id="formDirectPenugasan">
            @csrf
            <input type="hidden" name="id_jadwal" id="input_id_jadwal" value="{{ old('id_jadwal') }}">
            <div class="direct-form-grid">
                
                <!-- ROW 1: Guru Tidak Hadir & Guru Pengganti (Diubah Paling Atas Sesuai Instruksi) -->
                <div class="form-group-half" style="grid-column: span 1.5;">
                    <label class="form-label">Guru Tidak Hadir (Izin / Sakit) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative; margin-bottom: 6px;">
                        <input type="text" id="search_guru_tidak_hadir" class="form-input" placeholder="🔍 Cari Nama / NIP Guru Tidak Hadir..." onkeyup="filterSelectOptions('select_guru_tidak_hadir', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                    </div>
                    <select name="id_guru_tidak_hadir" id="select_guru_tidak_hadir" data-old-val="{{ old('id_guru_tidak_hadir', $selectedGuruTidakHadirId ?? '') }}" class="form-input @error('id_guru_tidak_hadir') input-error-border @enderror" required onchange="onGuruTidakHadirChanged(this)">
                        <option value="">-- Pilih Guru Tidak Hadir (Tersedia Data Izin Disetujui Waka & Kepsek) --</option>
                        <optgroup label="✅ Guru Izin Tidak Hadir (Disetujui Waka & Kepala Sekolah)">
                            @forelse($guruTidakHadirOptions as $iz)
                                @if($iz->guru)
                                    @php
                                        $isSelected = (old('id_guru_tidak_hadir') == $iz->id_guru) || (isset($selectedGuruTidakHadirId) && ($selectedGuruTidakHadirId == $iz->id_guru || $selectedGuruTidakHadirId == $iz->id_guru_izin));
                                    @endphp
                                    <option value="{{ $iz->id_guru }}" data-id-izin="{{ $iz->id_guru_izin }}" data-materi="{{ $iz->materi_dititipkan ?? '' }}" data-tugas="{{ $iz->tugas_dititipkan ?? '' }}" {{ $isSelected ? 'selected' : '' }}>
                                        ✅ {{ $iz->guru->nama_guru }} (NIP: {{ $iz->guru->nip ?? '-' }}) [Disetujui Waka & Kepsek | {{ $iz->alasan }} - {{ $iz->durasi_formatted }}]
                                    </option>
                                @endif
                            @empty
                                <option value="" disabled>-- Tidak Ada Guru Izin Tidak Hadir yang Disetujui Saat Ini --</option>
                            @endforelse
                        </optgroup>
                    </select>

                    <button type="button" id="btnToggleGuruTidakHadirLainnya" class="btn-toggle-guru-lainnya" style="margin-top: 6px;" onclick="toggleGuruTidakHadirLainnya()">
                        <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                    </button>

                    <!-- Interactive Dynamic Schedule List for Absent Teacher -->
                    <div id="wrapper_jadwal_pilihan" style="display: none; margin-top: 8px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; font-size: 12px; color: #166534;">
                        <strong><i class="fa-solid fa-list-check" style="color: #15803d;"></i> Sesi Jadwal Mengajar Guru Ini Hari Ini (Klik untuk Otomatis Mengisi):</strong>
                        <div id="jadwal_pilihan_list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;"></div>
                    </div>

                    @error('id_guru_tidak_hadir')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-half" style="grid-column: span 1.5;">
                    <label class="form-label">Guru Pengganti (Prioritas Guru Piket) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative; margin-bottom: 6px;">
                        <input type="text" id="search_guru_pengganti" class="form-input" placeholder="🔍 Cari Nama / NIP Guru Pengganti..." onkeyup="filterSelectOptions('select_guru_pengganti', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                    </div>
                    <select name="id_guru_pengganti" id="select_guru_pengganti" data-old-val="{{ old('id_guru_pengganti') }}" class="form-input @error('id_guru_pengganti') input-error-border @enderror" required>
                        <option value="">-- Pilih Guru Pengganti --</option>
                        <optgroup label="📌 Guru Piket pada Tanggal Tersebut (Hari {{ $targetDateFormatted ?? '-' }})" id="optgroup_guru_piket_main">
                            @php
                                $hasPiketInitial = false;
                            @endphp
                            @foreach($guruList as $g)
                                @if(!empty($g->is_piket_today))
                                    @php $hasPiketInitial = true; @endphp
                                    <option value="{{ $g->id_guru }}" {{ old('id_guru_pengganti') == $g->id_guru ? 'selected' : '' }}>
                                        [Guru Piket{{ !empty($g->slot_piket) ? ' S'.$g->slot_piket : '' }}] {{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }}) ({{ $g->mapel->nama_mapel ?? 'Guru' }})
                                    </option>
                                @endif
                            @endforeach
                            @if(!$hasPiketInitial)
                                <option value="" disabled>(Tidak ada jadwal guru piket terdaftar pada tanggal ini)</option>
                            @endif
                        </optgroup>
                    </select>
                    
                    <button type="button" id="btnToggleGuruLainnya" class="btn-toggle-guru-lainnya" onclick="toggleGuruMengajarLainnya()">
                        <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                    </button>

                    @error('id_guru_pengganti')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- UNIFIED PANEL SESI JADWAL GURU TIDAK HADIR -->
                <div id="wrapper_jadwal_unified" class="form-group-full jadwal-unified-panel" style="display: none;">
                    <div class="jadwal-panel-header">
                        <div class="jadwal-panel-title-group">
                            <div class="jadwal-panel-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <h4 class="jadwal-panel-title">Sesi Jadwal KBM Guru Tidak Hadir</h4>
                                <p class="jadwal-panel-subtitle" id="jadwal_panel_subtitle">
                                    Pilih satu atau beberapa sesi KBM untuk dialihkan ke Guru Pengganti:
                                </p>
                            </div>
                        </div>
                        <div class="jadwal-panel-actions">
                            <button type="button" class="btn-panel-action btn-select-all" onclick="toggleSelectAllJadwal(true)">
                                <i class="fa-solid fa-check-double"></i> Pilih Semua (Sehari Penuh)
                            </button>
                            <button type="button" class="btn-panel-action btn-unselect-all" onclick="toggleSelectAllJadwal(false)">
                                <i class="fa-solid fa-rotate-left"></i> Reset Pilihan
                            </button>
                        </div>
                    </div>

                    <!-- Mode Sehari Penuh Quick Banner Toggle -->
                    <div class="jadwal-sehari-penuh-card" id="sehari_penuh_strip">
                        <label class="sehari-penuh-label">
                            <input type="checkbox" name="sehari_penuh" id="check_sehari_penuh" value="1" {{ old('sehari_penuh') ? 'checked' : '' }} onchange="toggleSehariPenuh(this)" style="width: 18px; height: 18px; accent-color: #2563eb; cursor: pointer;">
                            <span>
                                <strong><i class="fa-solid fa-calendar-week" style="color: #2563eb;"></i> Mode Penugasan Sehari Penuh</strong> — Otomatis tugaskan guru pengganti untuk seluruh sesi KBM guru ini pada tanggal terpilih
                            </span>
                        </label>
                    </div>

                    <!-- Grid Cards Sesi KBM -->
                    <div id="jadwal_cards_grid" class="jadwal-cards-grid"></div>

                    <!-- Dynamic Feedback Bar -->
                    <div id="jadwal_feedback_bar" class="jadwal-feedback-bar" style="display: none;"></div>
                </div>

                <!-- ROW 2: Tanggal Penugasan, Jam Pelajaran (Master TU), dan Kelas -->
                <div>
                    <label class="form-label">Tanggal Penugasan <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal" id="input_tanggal_penugasan" value="{{ old('tanggal', $targetDate ?? $todayDate) }}" class="form-input @error('tanggal') input-error-border @enderror" required onchange="onTanggalPenugasanChanged()">
                    
                    <div id="label_hari_penugasan" style="font-size: 12.5px; font-weight: 800; color: #2563eb; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-calendar-day"></i> Hari: <span id="text_nama_hari">-</span>
                    </div>
                    
                    <div id="label_warning_past_date" style="font-size: 11.5px; font-weight: 800; color: #dc2626; margin-top: 4px; display: none;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Tanggal yang dipilih telah berlalu! Penugasan tidak dapat disimpan.
                    </div>

                    @error('tanggal')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div id="wrapper_jam_pelajaran">
                    <label class="form-label" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <span>Jam Pelajaran (Master TU) <span style="color: #ef4444;">*</span></span>
                        <span id="lock_badge_jam" style="display: none; font-size: 11px; padding: 2px 8px; border-radius: 6px; background: #fee2e2; color: #b91c1c; font-weight: 700;">
                            <i class="fa-solid fa-lock"></i> Terkunci Otomatis
                        </span>
                    </label>
                    <select name="jam_pelajaran" id="select_jam_pelajaran" data-old-val="{{ old('jam_pelajaran') }}" class="form-input @error('jam_pelajaran') input-error-border @enderror" required>
                        <option value="">-- Pilih Jam Pelajaran (Master TU) --</option>
                    </select>

                    <!-- Fitur Pencarian Jam Pelajaran (Di Bawah Fitur Pengisian) -->
                    <div id="wrapper_search_jam" style="position: relative; margin-top: 6px;">
                        <input type="text" id="search_jam_pelajaran" class="form-input" placeholder="🔍 Cari Sesi Jam Pelajaran (misal: 1, 7-8, 10:15)..." onkeyup="filterSelectOptions('select_jam_pelajaran', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                    </div>

                    <div id="lock_hint_jam" style="display: none; font-size: 11.5px; color: #0284c7; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-info"></i> Jam pelajaran otomatis ditentukan oleh kartu sesi KBM yang dipilih di atas.
                    </div>

                    @error('jam_pelajaran')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div id="wrapper_kelas">
                    <label class="form-label" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <span>Kelas <span style="color: #ef4444;">*</span></span>
                        <span id="lock_badge_kelas" style="display: none; font-size: 11px; padding: 2px 8px; border-radius: 6px; background: #fee2e2; color: #b91c1c; font-weight: 700;">
                            <i class="fa-solid fa-lock"></i> Terkunci Otomatis
                        </span>
                    </label>
                    <select name="id_kelas" id="select_kelas" class="form-input @error('id_kelas') input-error-border @enderror" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <div id="lock_hint_kelas" style="display: none; font-size: 11.5px; color: #0284c7; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-info"></i> Kelas otomatis ditentukan oleh kartu sesi KBM yang dipilih di atas.
                    </div>

                    @error('id_kelas')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Titipan Materi & Tugas -->
                <div class="form-group-full" style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <label class="form-label" style="color: #2563eb;"><i class="fa-solid fa-book-open"></i> Titipan Materi Pembelajaran (Opsional)</label>
                    <textarea name="materi_dititipkan" id="materi_dititipkan_field" rows="2" placeholder="Tuliskan pokok bahasan / materi yang dititipkan oleh guru utama..." class="form-input" style="resize: vertical;">{{ old('materi_dititipkan') }}</textarea>
                </div>

                <div class="form-group-full" style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <label class="form-label" style="color: #2563eb;"><i class="fa-solid fa-tasks"></i> Titipan Tugas / Instruksi Kelas (Opsional)</label>
                    <textarea name="tugas_dititipkan" id="tugas_dititipkan_field" rows="2" placeholder="Tuliskan instruksi tugas atau soal latihan untuk siswa di kelas..." class="form-input" style="resize: vertical;">{{ old('tugas_dititipkan') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Upload File Tugas (Opsional)</label>
                    <input type="file" name="file_tugas" id="input_file_tugas" class="form-input @error('file_tugas') input-error-border @enderror">
                    @error('file_tugas')
                        <div class="field-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-half">
                    <label class="form-label">Catatan Tambahan Piket</label>
                    <input type="text" name="catatan" id="input_catatan" value="{{ old('catatan') }}" placeholder="Keterangan penugasan..." class="form-input">
                </div>

            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                <button type="button" class="btn-reset-form" onclick="resetFormDirectPenugasan()">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit-penugasan">
                    <i class="fa-solid fa-paper-plane"></i> Simpan Penugasan Guru Pengganti
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Stat Cards Grid (3 Cards) -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Guru Tidak Hadir</span>
                    <span class="stat-val">{{ $stats['guruTidakHadir'] }} Guru</span>
                </div>
            </div>
            <a href="#" onclick="openModalStatGuruTidakHadir(); return false;" class="stat-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-gold">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Guru Pengganti</span>
                    <span class="stat-val">{{ $stats['guruPengganti'] }} Guru</span>
                </div>
            </div>
            <a href="#" onclick="openModalStatGuruPengganti(); return false;" class="stat-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Penugasan Aktif</span>
                    <span class="stat-val">{{ $stats['penugasanAktif'] }} Penugasan</span>
                </div>
            </div>
            <a href="{{ route('piket.guru-pengganti', ['status' => 'aktif']) }}" class="stat-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <!-- 3. Main Table Panel (Daftar Penugasan Guru Pengganti + Fitur Sampah) -->
    <div class="main-table-panel" id="penugasanTable">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-calendar-days" style="color: #2b3957;"></i>
                <span>Daftar Penugasan Guru Pengganti</span>
            </div>
            <button type="button" onclick="openTrashModal()" class="btn-trash-toggle">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashCount }})
            </button>
        </div>

        <!-- Filter & Search Bar (Di Atas Tabel) -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.guru-pengganti') }}" method="GET">
                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari Guru / Mapel / Kelas..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">
                </div>

                <div>
                    <select name="id_kelas" class="filter-input">
                        <option value="">Kelas: Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input">
                        <option value="">Mata Pelajaran: Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="status" class="filter-input">
                        <option value="">Status: Semua Status</option>
                        <option value="aktif" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $statusFilter === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <a href="{{ route('piket.guru-pengganti') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" style="background: #ef4444; color: #ffffff; padding: 9px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap; width: auto; height: auto;" title="Hapus Data Terpilih">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </form>
        </div>

        <div class="table-container">
            <table class="custom-penugasan-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th>Tanggal</th>
                        <th>Guru Tidak Hadir</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam</th>
                        <th>Guru Pengganti</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penugasans as $row)
                        @php
                            $tgl = isset($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $row->tanggal_day ?? ($tgl ? $tgl->format('d') : '05');
                            $monthStr = $row->tanggal_month ?? ($tgl ? strtoupper($tgl->format('M Y')) : 'JUN 2026');
                            
                            $stTeks = $row->status_teks ?? ucfirst($row->status ?? 'aktif');
                            $stClass = 'badge-status-aktif';
                            if (strtolower($stTeks) === 'selesai') $stClass = 'badge-status-selesai';
                            if (strtolower($stTeks) === 'dibatalkan') $stClass = 'badge-status-dibatalkan';

                            $guruTidakHadirNama = $row->guru_tidak_hadir_nama ?? ($row->guruTidakHadir->nama_guru ?? 'Guru Tidak Hadir');
                            $guruPenggantiNama  = $row->guru_pengganti_nama ?? ($row->guruPengganti->nama_guru ?? 'Guru Pengganti');
                            $kelasNama          = $row->kelas_nama ?? ($row->kelas->nama_kelas ?? '-');
                            $mapelNama          = $row->mapel_nama ?? ($row->guruTidakHadir->mapel->nama_mapel ?? '-');
                            $jamStr             = $row->jam ?? ($row->jam_pelajaran ?? '-');

                            $jsonData = [
                                'id_penugasan'         => $row->id_penugasan ?? null,
                                'tanggal'              => $row->tanggal ?? '',
                                'id_guru_tidak_hadir'  => $row->id_guru_tidak_hadir ?? null,
                                'guru_tidak_hadir_nama'=> $guruTidakHadirNama,
                                'id_guru_pengganti'    => $row->id_guru_pengganti ?? null,
                                'guru_pengganti_nama'  => $guruPenggantiNama,
                                'id_kelas'             => $row->id_kelas ?? null,
                                'kelas_nama'           => $kelasNama,
                                'mapel_nama'           => $mapelNama,
                                'jam_pelajaran'        => $jamStr,
                                'status'               => strtolower($row->status ?? 'aktif'),
                                'materi_dititipkan'    => $row->materi_dititipkan ?? '',
                                'tugas_dititipkan'     => $row->tugas_dititipkan ?? '',
                                'file_tugas'           => $row->file_tugas ?? '',
                                'catatan'              => $row->catatan ?? '',
                            ];
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="guru-pengganti-checkbox" value="{{ $row->id_penugasan }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            </td>
                            <td>
                                <div class="date-cell">
                                    <span class="date-day">{{ $dayStr }}</span>
                                    <span class="date-month">{{ $monthStr }}</span>
                                </div>
                            </td>
                            <td>{{ $guruTidakHadirNama }}</td>
                            <td>{{ $kelasNama }}</td>
                            <td><strong>{{ $mapelNama }}</strong></td>
                            <td>{{ $jamStr }}</td>
                            <td><strong>{{ $guruPenggantiNama }}</strong></td>
                            <td>
                                <span class="{{ $stClass }}">{{ ucfirst($stTeks) }}</span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <!-- Button Lihat Detail Lengkap -->
                                    <button type="button" class="btn-action-dots" onclick='showDetailModalComplete(@json($jsonData))' title="Lihat Detail Lengkap">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    @if(isset($row->id_penugasan) && is_numeric($row->id_penugasan))
                                        <!-- Button Edit Penugasan -->
                                        <button type="button" class="btn-action-dots btn-action-edit" onclick='openEditModal(@json($jsonData))' title="Edit Penugasan">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- Button Soft Delete -->
                                        <form action="{{ route('piket.guru-pengganti.destroy', $row->id_penugasan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Pindahkan penugasan ini ke Sampah?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-dots btn-action-trash" style="color: #ef4444;" title="Pindahkan ke Sampah">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #94a3b8; padding: 24px;">Belum ada penugasan guru pengganti ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan {{ count($penugasans) > 0 ? 1 : 0 }} - {{ count($penugasans) }} dari {{ count($penugasans) }} data
            </div>

            <div class="custom-pagination">
                <a href="#" class="page-btn">&lt;&lt;</a>
                <a href="#" class="page-btn">&lt;</a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">&gt;</a>
                <a href="#" class="page-btn">&gt;&gt;</a>
            </div>
        </div>
    </div>

</div>

<!-- Modal 1: Detail Lengkap Penugasan Guru Pengganti (Termasuk View File Tugas) -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Lengkap Penugasan Guru Pengganti</h4>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
            <div style="background: #f1f5f9; padding: 14px; border-radius: 12px; border: 1px solid #cbd5e1; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div><strong>Guru Tidak Hadir:</strong> <div id="detailGuruUtama" style="color: #991b1b; font-weight: 700;"></div></div>
                <div><strong>Guru Pengganti:</strong> <div id="detailGuruPengganti" style="color: #2563eb; font-weight: 700;"></div></div>
                <div><strong>Tanggal & Hari:</strong> <div id="detailTanggal"></div></div>
                <div><strong>Status:</strong> <div id="detailStatus"></div></div>
                <div><strong>Kelas:</strong> <div id="detailKelas"></div></div>
                <div><strong>Mata Pelajaran:</strong> <div id="detailMapel"></div></div>
                <div style="grid-column: span 2;"><strong>Jam Pelajaran:</strong> <div id="detailJam"></div></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-solid fa-book"></i> Materi Pembelajaran Dititipkan:</label>
                <div id="detailMateri" style="background: #fff; border: 1px solid #cbd5e1; padding: 10px 12px; border-radius: 8px; color: #1e293b; white-space: pre-line;"></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-solid fa-list-check"></i> Tugas / Instruksi Kelas Dititipkan:</label>
                <div id="detailTugas" style="background: #fff; border: 1px solid #cbd5e1; padding: 10px 12px; border-radius: 8px; color: #1e293b; white-space: pre-line;"></div>
            </div>

            <!-- Upload File Tugas Container -->
            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-solid fa-paperclip"></i> Upload File Tugas (Opsional):</label>
                <div id="detailFileTugasBox" style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px;"></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-solid fa-comment-dots"></i> Catatan Tambahan Piket:</label>
                <div id="detailCatatan" style="background: #fff; border: 1px solid #cbd5e1; padding: 8px 12px; border-radius: 8px; color: #475569;"></div>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <button type="button" onclick="closeDetailModal()" class="btn-submit-penugasan">Tutup Detail</button>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Penugasan Guru Pengganti -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 680px;">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-pen-to-square" style="color: #d97706;"></i> Edit Penugasan Guru Pengganti</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form id="formEditPenugasan" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_jadwal" id="edit_input_id_jadwal">

            <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
                
                <!-- ROW 1: Guru Tidak Hadir & Guru Pengganti -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label class="form-label">Guru Tidak Hadir (Izin / Sakit) <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative; margin-bottom: 6px;">
                            <input type="text" id="edit_search_guru_tidak_hadir" class="form-input" placeholder="🔍 Cari Nama / NIP Guru Tidak Hadir..." onkeyup="filterSelectOptions('edit_select_guru_tidak_hadir', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                        </div>
                        <select name="id_guru_tidak_hadir" id="edit_select_guru_tidak_hadir" class="form-input" required onchange="onEditGuruTidakHadirChanged(this)">
                            <option value="">-- Pilih Guru Tidak Hadir (Terdata Izin / Sakit) --</option>
                            <optgroup label="⚠️ Guru Terdata Izin / Sakit Saat Ini">
                                @foreach($guruTidakHadirOptions as $iz)
                                    @if($iz->guru)
                                        <option value="{{ $iz->id_guru }}" data-materi="{{ $iz->materi_dititipkan ?? '' }}" data-tugas="{{ $iz->tugas_dititipkan ?? '' }}">
                                            ⚠️ {{ $iz->guru->nama_guru }} (NIP: {{ $iz->guru->nip ?? '-' }}) (Izin: {{ $iz->alasan }} | {{ $iz->durasi_formatted }})
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>

                        <button type="button" id="edit_btnToggleGuruTidakHadirLainnya" class="btn-toggle-guru-lainnya" style="margin-top: 6px;" onclick="toggleEditGuruTidakHadirLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>
                    </div>

                    <div>
                        <label class="form-label">Guru Pengganti (Prioritas Guru Piket) <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative; margin-bottom: 6px;">
                            <input type="text" id="edit_search_guru_pengganti" class="form-input" placeholder="🔍 Cari Nama / NIP Guru Pengganti..." onkeyup="filterSelectOptions('edit_select_guru_pengganti', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                        </div>
                        <select name="id_guru_pengganti" id="edit_select_guru_pengganti" class="form-input" required>
                            <option value="">-- Pilih Guru Pengganti --</option>
                            <optgroup label="📌 Guru Piket Hari Ini (Tampil Utama)">
                                @foreach($guruList as $g)
                                    @if(!empty($g->is_piket_today))
                                        <option value="{{ $g->id_guru }}">[Guru Piket] {{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }})</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>

                        <button type="button" id="edit_btnToggleGuruLainnya" class="btn-toggle-guru-lainnya" onclick="toggleEditGuruMengajarLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>
                    </div>
                </div>

                <!-- Interactive Dynamic Schedule List for Absent Teacher in Edit Modal -->
                <div id="edit_wrapper_jadwal_pilihan" style="display: none; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; font-size: 12px; color: #166534;">
                    <strong><i class="fa-solid fa-list-check" style="color: #15803d;"></i> Sesi Jadwal Mengajar Guru Ini (Klik untuk Otomatis Mengisi):</strong>
                    <div id="edit_jadwal_pilihan_list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;"></div>
                </div>

                <!-- ROW 2: Tanggal Penugasan & Status -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label class="form-label">Tanggal Penugasan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="edit_input_tanggal" class="form-input" required onchange="onEditTanggalPenugasanChanged()">
                        
                        <div id="edit_label_hari_penugasan" style="font-size: 12px; font-weight: 800; color: #2563eb; margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-calendar-day"></i> Hari: <span id="edit_text_nama_hari">-</span>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Status Penugasan <span style="color: #ef4444;">*</span></label>
                        <select name="status" id="edit_select_status" class="form-input" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 3: Jam Pelajaran (Master TU) & Kelas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label class="form-label">Jam Pelajaran (Master TU) <span style="color: #ef4444;">*</span></label>
                        <select name="jam_pelajaran" id="edit_select_jam_pelajaran" class="form-input" required>
                            <option value="">-- Pilih Jam Pelajaran (Master TU) --</option>
                        </select>

                        <!-- Fitur Pencarian Jam Pelajaran (Di Bawah Fitur Pengisian) -->
                        <div style="position: relative; margin-top: 6px;">
                            <input type="text" id="edit_search_jam_pelajaran" class="form-input" placeholder="🔍 Cari Sesi Jam Pelajaran (misal: 1, 7-8, 10:15)..." onkeyup="filterSelectOptions('edit_select_jam_pelajaran', this.value)" style="padding-left: 30px; font-size: 11.5px; height: 34px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Kelas <span style="color: #ef4444;">*</span></label>
                        <select name="id_kelas" id="edit_select_kelas" class="form-input" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Form Titipan Materi & Tugas -->
                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px dashed #cbd5e1;">
                    <label class="form-label" style="color: #2563eb;"><i class="fa-solid fa-book-open"></i> Titipan Materi Pembelajaran (Opsional)</label>
                    <textarea name="materi_dititipkan" id="edit_textarea_materi" rows="2" placeholder="Tuliskan pokok bahasan / materi..." class="form-input" style="resize: vertical;"></textarea>
                </div>

                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px dashed #cbd5e1;">
                    <label class="form-label" style="color: #2563eb;"><i class="fa-solid fa-tasks"></i> Titipan Tugas / Instruksi Kelas (Opsional)</label>
                    <textarea name="tugas_dititipkan" id="edit_textarea_tugas" rows="2" placeholder="Tuliskan instruksi tugas..." class="form-input" style="resize: vertical;"></textarea>
                </div>

                <div>
                    <label class="form-label">Upload File Tugas Baru (Opsional - Menggantikan File Lama)</label>
                    <input type="file" name="file_tugas" class="form-input">
                    <div id="edit_current_file_info" style="font-size: 12px; color: #2563eb; margin-top: 4px;"></div>
                </div>

                <div>
                    <label class="form-label">Catatan Tambahan Piket</label>
                    <input type="text" name="catatan" id="edit_input_catatan" placeholder="Keterangan penugasan..." class="form-input">
                </div>

            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeEditModal()" class="btn-reset-form">Batal</button>
                <button type="submit" class="btn-submit-penugasan" style="background: #d97706;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Edit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Fitur Sampah (Trash Soft Delete) -->
<div id="trashModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 820px;">
        <div class="modal-header">
            <h4 class="modal-title" style="color: #991b1b;"><i class="fa-solid fa-trash-can"></i> Sampah Penugasan Guru Pengganti (Soft Delete)</h4>
            <button type="button" onclick="closeTrashModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        @if($trashCount > 0)
            <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                <form action="{{ route('piket.guru-pengganti.empty-trash') }}" method="POST" onsubmit="return confirm('Kosongkan SELURUH sampah secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #ef4444; color: #fff; border: none; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer;">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            </div>
        @endif

        <div style="overflow-x: auto; max-height: 400px;">
            <table class="custom-penugasan-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Guru Tidak Hadir</th>
                        <th>Guru Pengganti</th>
                        <th>Kelas & Jam</th>
                        <th>Dihapus Pada</th>
                        <th style="text-align: center;">Aksi Sampah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashPenugasans as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $t->guruTidakHadir->nama_guru ?? '-' }}</td>
                            <td>{{ $t->guruPengganti->nama_guru ?? '-' }}</td>
                            <td>{{ $t->kelas->nama_kelas ?? '-' }} ({{ $t->jam_pelajaran }})</td>
                            <td><span style="font-size: 11.5px; color: #94a3b8;">{{ $t->deleted_at->format('d M Y H:i') }}</span></td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <!-- Pulihkan -->
                                    <form action="{{ route('piket.guru-pengganti.restore', $t->id_penugasan) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <!-- Hapus Permanen -->
                                    <form action="{{ route('piket.guru-pengganti.force-delete', $t->id_penugasan) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada data penugasan di dalam Sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeTrashModal()" class="btn-submit-penugasan">Tutup Sampah</button>
        </div>
    </div>
</div>

<!-- Modal 4: Stat Card 1 - Detail Guru Tidak Hadir -->
<div id="modalStatGuruTidakHadir" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-user-xmark" style="color: #2563eb;"></i> Daftar Guru Tidak Hadir (Izin / Sakit)</h4>
            <button type="button" onclick="closeModalStatGuruTidakHadir()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 380px; overflow-y: auto;">
            @forelse($guruTidakHadirOptions as $iz)
                @if($iz->guru)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                        <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">{{ $iz->guru->nama_guru }}</div>
                        <div style="font-size: 12px; color: #2563eb; font-weight: 700; margin-top: 2px;">
                            Alasan: {{ $iz->alasan }} | Durasi: {{ $iz->durasi_formatted }}
                        </div>
                        @if($iz->materi_dititipkan)
                            <div style="font-size: 12px; color: #475569; margin-top: 4px; background: #fff; padding: 6px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <strong>Titipan Materi:</strong> {{ $iz->materi_dititipkan }}
                            </div>
                        @endif
                    </div>
                @endif
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px;">Seluruh guru mengajar hadir penuh hari ini.</div>
            @endforelse
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeModalStatGuruTidakHadir()" class="btn-submit-penugasan">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal 5: Stat Card 2 - Detail Guru Pengganti Assigned -->
<div id="modalStatGuruPengganti" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-user-gear" style="color: #d97706;"></i> Ringkasan Guru Pengganti Bertugas</h4>
            <button type="button" onclick="closeModalStatGuruPengganti()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 380px; overflow-y: auto;">
            @forelse($penugasans as $row)
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong style="color: #92400e; font-size: 13.5px;">Guru Pengganti: {{ $row->guru_pengganti_nama ?? ($row->guruPengganti->nama_guru ?? 'Pengganti') }}</strong>
                        <span style="font-size: 11px; font-weight: 800; background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 10px;">{{ ucfirst($row->status ?? 'aktif') }}</span>
                    </div>
                    <div style="font-size: 12px; color: #78350f; margin-top: 4px;">
                        Menggantikan: {{ $row->guru_tidak_hadir_nama ?? ($row->guruTidakHadir->nama_guru ?? '-') }} | Kelas: {{ $row->kelas_nama ?? ($row->kelas->nama_kelas ?? '-') }} | Jam: {{ $row->jam ?? ($row->jam_pelajaran ?? '-') }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada penugasan guru pengganti aktif hari ini.</div>
            @endforelse
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeModalStatGuruPengganti()" class="btn-submit-penugasan">Tutup</button>
        </div>
    </div>
</div>

<script>
    // Data Master Jam Pelajaran dari Laravel
    const jamPelajaranMaster = @json($jamPelajaranList ?? []);
    const todayDateStr = "{{ $todayDate }}";

    // Data Master Seluruh Guru Mengajar dari Role TU
    const allGuruListMaster = [
        @foreach($guruList as $g)
            { id_guru: "{{ $g->id_guru }}", nama_guru: "{{ addslashes($g->nama_guru) }}", nip: "{{ addslashes($g->nip ?? '-') }}", mapel: "{{ addslashes($g->mapel->nama_mapel ?? 'Guru') }}" },
        @endforeach
    ];

    // Data Guru Mengajar Lainnya untuk Toggle Guru Pengganti
    let guruMengajarLainnyaList = [
        @foreach($guruList as $g)
            @if(empty($g->is_piket_today))
                { id_guru: "{{ $g->id_guru }}", nama_guru: "{{ addslashes($g->nama_guru) }}", nip: "{{ addslashes($g->nip ?? '-') }}", mapel: "{{ addslashes($g->mapel->nama_mapel ?? 'Guru') }}" },
            @endif
        @endforeach
    ];

    // Handler Utama Perubahan Tanggal Penugasan
    function onTanggalPenugasanChanged() {
        updateNamaHariLabel();
        updateJamOptionsByDate();
        validateTanggalPenugasan();
        fetchJadwalGuruTidakHadirList();
        fetchPiketGuruByDate();
    }

    function resetFormDirectPenugasan() {
        const form = document.getElementById('formDirectPenugasan');
        if (form) form.reset();

        const inputJadwal = document.getElementById('input_id_jadwal');
        if (inputJadwal) inputJadwal.value = '';

        const inputTanggal = document.getElementById('input_tanggal_penugasan');
        if (inputTanggal) inputTanggal.value = todayDateStr;

        const selTidakHadir = document.getElementById('select_guru_tidak_hadir');
        if (selTidakHadir) selTidakHadir.value = '';

        const selPengganti = document.getElementById('select_guru_pengganti');
        if (selPengganti) selPengganti.value = '';

        const selKelas = document.getElementById('select_kelas');
        if (selKelas) selKelas.value = '';

        const selJam = document.getElementById('select_jam_pelajaran');
        if (selJam) selJam.value = '';

        if (typeof setManualInputsLocked === 'function') {
            setManualInputsLocked(false);
        }

        const materiField = document.getElementById('materi_dititipkan_field');
        if (materiField) materiField.value = '';

        const tugasField = document.getElementById('tugas_dititipkan_field');
        if (tugasField) tugasField.value = '';

        const catatanField = document.getElementById('input_catatan');
        if (catatanField) catatanField.value = '';

        const fileInput = document.getElementById('input_file_tugas');
        if (fileInput) fileInput.value = '';

        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh) {
            chkSehariPenuh.checked = false;
        }

        const wrapperUnified = document.getElementById('wrapper_jadwal_unified');
        if (wrapperUnified) wrapperUnified.style.display = 'none';

        const cardsGrid = document.getElementById('jadwal_cards_grid');
        if (cardsGrid) cardsGrid.innerHTML = '';

        const feedbackBar = document.getElementById('jadwal_feedback_bar');
        if (feedbackBar) {
            feedbackBar.style.display = 'none';
            feedbackBar.innerHTML = '';
        }

        const sehariStrip = document.getElementById('sehari_penuh_strip');
        if (sehariStrip) sehariStrip.classList.remove('active');

        document.querySelectorAll('.input-error-border').forEach(el => el.classList.remove('input-error-border'));

        onTanggalPenugasanChanged();
    }

    // Tampilkan Nama Hari Secara Bahasa Indonesia
    function updateNamaHariLabel() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const labelHari = document.getElementById('text_nama_hari');
        if (!dateInput || !labelHari) return;

        const val = dateInput.value;
        if (!val) {
            labelHari.innerText = '-';
            return;
        }

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const monthsIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = daysIndo[dateObj.getDay()];
        const dayNum = dateObj.getDate();
        const monthName = monthsIndo[dateObj.getMonth()];
        const yearNum = dateObj.getFullYear();

        labelHari.innerHTML = `<strong>${dayName}</strong>, ${dayNum} ${monthName} ${yearNum}`;
    }

    // Validasi Tanggal
    function validateTanggalPenugasan() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const warningPast = document.getElementById('label_warning_past_date');
        if (!dateInput) return;

        const selectedDate = dateInput.value;
        if (!selectedDate) return;

        if (selectedDate < todayDateStr) {
            if (warningPast) warningPast.style.display = 'block';
            dateInput.classList.add('input-error-border');
        } else {
            if (warningPast) warningPast.style.display = 'none';
            dateInput.classList.remove('input-error-border');
        }
    }

    // Dynamic Generator Rentang Multi-Jam Pelajaran Lengkap Sesuai Data Jadwal TU & Master Jam Pelajaran Database
    function generateMultiJamOptions(isJumat) {
        const multiPairs = [
            // 2 Sesi
            [1,2], [2,3], [3,4], [4,5], [5,6], [6,7], [7,8], [8,9], [9,10], [10,11], [11,12], [12,13],
            // 3 Sesi
            [1,3], [2,4], [3,5], [4,6], [5,7], [6,8], [7,9], [8,10], [9,11], [10,12], [11,13],
            // 4 Sesi
            [1,4], [2,5], [3,6], [4,7], [5,8], [6,9], [7,10], [8,11], [9,12], [10,13],
            // 5 Sesi
            [1,5], [2,6], [3,7], [4,8], [5,9], [6,10], [7,11], [8,12], [9,13],
            // 6 Sesi S/D Blok Multi Jam Sesuai Jadwal Mengajar TU (1-6, 1-7, 2-7, 2-8, 3-8, 3-9, 4-9, 4-10, 5-10, 5-11, 5-13, 6-11, 6-12, 6-13, 7-12, 7-13, 8-13)
            [1,6], [1,7], [2,7], [2,8], [3,8], [3,9], [4,9], [4,10], [5,10], [5,11], [5,13], [6,11], [6,12], [6,13], [7,12], [7,13], [8,13]
        ];

        let results = [];

        multiPairs.forEach(p => {
            const start = p[0];
            const end = p[1];

            const mung = jamPelajaranMaster.find(j => j.id_jam == start || j.jam_ke == `Jam Ke-${start}`);
            const sel  = jamPelajaranMaster.find(j => j.id_jam == end || j.jam_ke == `Jam Ke-${end}`);

            let startTime = '';
            let endTime = '';

            if (isJumat) {
                if (mung && mung.jam_mulai_jumat) startTime = mung.jam_mulai_jumat.substring(0, 5);
                if (sel && sel.jam_selesai_jumat) endTime = sel.jam_selesai_jumat.substring(0, 5);

                if (!endTime) {
                    for (let k = end - 1; k >= start; k--) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_selesai_jumat) {
                            endTime = sub.jam_selesai_jumat.substring(0, 5);
                            break;
                        }
                    }
                }
            } else {
                if (mung && mung.jam_mulai) startTime = mung.jam_mulai.substring(0, 5);
                if (sel && sel.jam_selesai) endTime = sel.jam_selesai.substring(0, 5);

                if (!endTime) {
                    for (let k = end - 1; k >= start; k--) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_selesai) {
                            endTime = sub.jam_selesai.substring(0, 5);
                            break;
                        }
                    }
                    if (!endTime) endTime = '15:00';
                }
                if (!startTime) {
                    for (let k = start + 1; k <= end; k++) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_mulai) {
                            startTime = sub.jam_mulai.substring(0, 5);
                            break;
                        }
                    }
                    if (!startTime) startTime = '07:00';
                }
            }

            if (startTime && endTime) {
                results.push(`Jam Ke-${start} - ${end} (${startTime} - ${endTime} WIB)`);
            } else if (startTime) {
                results.push(`Jam Ke-${start} - ${end} (${startTime} WIB)`);
            } else {
                results.push(`Jam Ke-${start} - ${end}`);
            }
        });

        return results;
    }

    // Update Opsi Jam Pelajaran
    function updateJamOptionsByDate() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const jamSelect = document.getElementById('select_jam_pelajaran');
        if (!dateInput || !jamSelect) return;

        const val = dateInput.value;
        if (!val) return;

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const day = dateObj.getDay();
        const isJumat = (day === 5);

        const oldSelected = jamSelect.getAttribute('data-old-val') || jamSelect.value;
        jamSelect.innerHTML = '<option value="">-- Pilih Jam Pelajaran (Master TU) --</option>';

        const grpSingle = document.createElement('optgroup');
        grpSingle.label = isJumat ? 'Satu Sesi Jam Pelajaran (Master TU - Khusus Hari Jumat)' : 'Satu Sesi Jam Pelajaran (Master TU - Senin s/d Kamis)';

        jamPelajaranMaster.forEach(item => {
            let timeStr = '';
            if (isJumat) {
                if (item.jam_mulai_jumat && item.jam_selesai_jumat) {
                    timeStr = `${item.jam_mulai_jumat.substring(0,5)} - ${item.jam_selesai_jumat.substring(0,5)} WIB`;
                }
            } else {
                if (item.jam_mulai && item.jam_selesai) {
                    timeStr = `${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} WIB`;
                }
            }

            if (timeStr) {
                const optVal = `${item.jam_ke} (${timeStr})`;
                const opt = document.createElement('option');
                opt.value = optVal;
                opt.textContent = `${item.jam_ke} (${timeStr}) — ${item.keterangan || 'Sesi Pembelajaran'}`;
                if (oldSelected === optVal) opt.selected = true;
                grpSingle.appendChild(opt);
            }
        });

        jamSelect.appendChild(grpSingle);

        const grpMulti = document.createElement('optgroup');
        grpMulti.label = isJumat ? 'Rentang Multi-Jam Pembelajaran Lengkap (Khusus Hari Jumat)' : 'Rentang Multi-Jam Pembelajaran Lengkap (Senin s/d Kamis)';

        let multiOptions = generateMultiJamOptions(isJumat);

        multiOptions.forEach(optVal => {
            const opt = document.createElement('option');
            opt.value = optVal;
            opt.textContent = optVal;
            if (oldSelected === optVal) opt.selected = true;
            grpMulti.appendChild(opt);
        });

        jamSelect.appendChild(grpMulti);
    }

    // Toggle Sehari Penuh Feature
    function toggleSehariPenuh(chk) {
        const sehariStrip = document.getElementById('sehari_penuh_strip');
        const checkboxes  = document.querySelectorAll('.cb-jadwal-sesi');

        if (chk.checked) {
            checkboxes.forEach(cb => { cb.checked = true; });
            if (sehariStrip) sehariStrip.classList.add('active');
        } else {
            checkboxes.forEach(cb => { cb.checked = false; });
            if (sehariStrip) sehariStrip.classList.remove('active');
        }
        onJadwalSelectionChanged();
    }

    // Handler Perubahan Guru Tidak Hadir
    function onGuruTidakHadirChanged(selectElem) {
        autoFillMateriFromIzin(selectElem);
        fetchJadwalGuruTidakHadirList();
    }

    // Fetch List Jadwal Guru Tidak Hadir (Unified Cards Renderer)
    function fetchJadwalGuruTidakHadirList() {
        const selectGuruHadir = document.getElementById('select_guru_tidak_hadir');
        const inputTanggal    = document.getElementById('input_tanggal_penugasan');
        const wrapperUnified  = document.getElementById('wrapper_jadwal_unified');
        const cardsGrid       = document.getElementById('jadwal_cards_grid');
        const feedbackBar     = document.getElementById('jadwal_feedback_bar');
        const subtitleElem    = document.getElementById('jadwal_panel_subtitle');
        const chkSehariPenuh  = document.getElementById('check_sehari_penuh');
        const sehariStrip     = document.getElementById('sehari_penuh_strip');

        if (!selectGuruHadir || !inputTanggal || !wrapperUnified || !cardsGrid) return;

        const idGuru  = selectGuruHadir.value;
        const tanggal = inputTanggal.value;

        if (!idGuru) {
            wrapperUnified.style.display = 'none';
            cardsGrid.innerHTML = '';
            if (feedbackBar) feedbackBar.style.display = 'none';
            return;
        }

        cardsGrid.innerHTML = `<div style="grid-column: 1 / -1; padding: 20px; text-align: center; color: #166534; font-weight: 700;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size: 18px; margin-right: 8px;"></i> Memuat sesi jadwal KBM guru pada tanggal ini...
        </div>`;
        wrapperUnified.style.display = 'block';

        fetch(`{{ route('piket.guru-pengganti.jadwal-guru') }}?id_guru=${idGuru}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.jadwals && data.jadwals.length > 0) {
                    if (subtitleElem) {
                        subtitleElem.innerHTML = `Ditemukan <strong>${data.jadwals.length} Sesi KBM</strong> pada hari <strong>${data.hari} (${tanggal})</strong>. Klik sesi yang ingin dialihkan:`;
                    }
                    if (sehariStrip) sehariStrip.style.display = 'flex';

                    let cardsHtml = '';
                    data.jadwals.forEach((j, idx) => {
                        cardsHtml += `
                        <div class="jadwal-card-item" id="card_jadwal_${j.id_jadwal}" onclick="onCardContainerClick(event, ${j.id_jadwal})">
                            <div class="jadwal-card-top">
                                <div class="jadwal-card-checkbox-group">
                                    <input type="checkbox" name="selected_jadwal_ids[]" value="${j.id_jadwal}" id="cb_jadwal_${j.id_jadwal}" data-id-jadwal="${j.id_jadwal}" data-jam="${j.jam_pelajaran}" data-id-kelas="${j.id_kelas}" data-kelas-name="${j.nama_kelas}" class="cb-jadwal-sesi" onchange="onJadwalSelectionChanged()" onclick="event.stopPropagation()">
                                    <span class="jadwal-card-class">${j.nama_kelas}</span>
                                </div>
                                <span class="jadwal-sesi-badge">Sesi ${idx + 1}</span>
                            </div>
                            <div class="jadwal-card-mapel">
                                <i class="fa-solid fa-book-bookmark" style="color: #64748b;"></i> ${j.nama_mapel}
                            </div>
                            <div class="jadwal-card-time">
                                <i class="fa-solid fa-clock"></i> ${j.jam_pelajaran}
                            </div>
                            <div class="jadwal-card-footer-hint">
                                <span class="hint-text"><i class="fa-solid fa-hand-pointer"></i> Klik sesi untuk memilih</span>
                                <span class="badge-status-pill" id="pill_jadwal_${j.id_jadwal}" style="display: none; font-size: 11px; font-weight: 800; color: #16a34a;"><i class="fa-solid fa-check"></i> Terpilih</span>
                            </div>
                        </div>`;
                    });

                    cardsGrid.innerHTML = cardsHtml;

                    // Tambahkan opsi sesi mengajar ke dropdown jam
                    updateJamOptionsWithTeacherSchedules(data.jadwals);

                    // Re-sync selection state if sehari_penuh is checked
                    if (chkSehariPenuh && chkSehariPenuh.checked) {
                        toggleSehariPenuh(chkSehariPenuh);
                    } else {
                        onJadwalSelectionChanged();
                    }
                } else {
                    if (subtitleElem) {
                        subtitleElem.innerText = `Guru tidak memiliki jadwal KBM terjadwal pada hari ${data.hari || ''} (${tanggal}).`;
                    }
                    if (sehariStrip) sehariStrip.style.display = 'none';
                    if (feedbackBar) feedbackBar.style.display = 'none';
                    cardsGrid.innerHTML = `
                    <div class="jadwal-empty-alert" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-circle-info" style="font-size: 18px; color: #d97706;"></i>
                        <div>
                            <strong>Tidak Ada Jadwal KBM Terjadwal:</strong> Guru ini tidak memiliki jam mengajar pada hari ${data.hari || ''} (${tanggal}). Anda tetap dapat mengisi <u>Jam Pelajaran (Master TU)</u> & <u>Kelas</u> secara manual di kolom bawah.
                        </div>
                    </div>`;
                    onJadwalSelectionChanged();
                }
            })
            .catch(err => {
                cardsGrid.innerHTML = `<div class="jadwal-empty-alert" style="grid-column: 1 / -1; color: #dc2626; border-color: #fca5a5; background: #fef2f2;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat jadwal guru tidak hadir.
                </div>`;
            });
    }

    // Click anywhere on card to toggle
    function onCardContainerClick(event, idJadwal) {
        const cb = document.getElementById(`cb_jadwal_${idJadwal}`);
        if (cb) {
            cb.checked = !cb.checked;
            onJadwalSelectionChanged();
        }
    }

    // Helper to Lock / Unlock Manual Jam Pelajaran & Kelas Inputs
    function setManualInputsLocked(locked, reasonText = '') {
        const selectJam = document.getElementById('select_jam_pelajaran');
        const searchJam = document.getElementById('search_jam_pelajaran');
        const selectKelas = document.getElementById('select_kelas');
        const badgeJam = document.getElementById('lock_badge_jam');
        const badgeKelas = document.getElementById('lock_badge_kelas');
        const hintJam = document.getElementById('lock_hint_jam');
        const hintKelas = document.getElementById('lock_hint_kelas');

        if (locked) {
            if (selectJam) {
                selectJam.disabled = true;
                selectJam.removeAttribute('required');
                selectJam.style.background = '#f1f5f9';
                selectJam.style.color = '#64748b';
                selectJam.style.cursor = 'not-allowed';
                selectJam.style.borderColor = '#cbd5e1';
            }
            if (searchJam) {
                searchJam.disabled = true;
                searchJam.style.background = '#f1f5f9';
                searchJam.style.color = '#94a3b8';
                searchJam.style.cursor = 'not-allowed';
                searchJam.value = '';
            }
            if (selectKelas) {
                selectKelas.disabled = true;
                selectKelas.removeAttribute('required');
                selectKelas.style.background = '#f1f5f9';
                selectKelas.style.color = '#64748b';
                selectKelas.style.cursor = 'not-allowed';
                selectKelas.style.borderColor = '#cbd5e1';
            }
            if (badgeJam) {
                badgeJam.style.display = 'inline-flex';
                if (reasonText) badgeJam.innerHTML = `<i class="fa-solid fa-lock" style="margin-right: 4px;"></i> ${reasonText}`;
            }
            if (badgeKelas) {
                badgeKelas.style.display = 'inline-flex';
                if (reasonText) badgeKelas.innerHTML = `<i class="fa-solid fa-lock" style="margin-right: 4px;"></i> ${reasonText}`;
            }
            if (hintJam) hintJam.style.display = 'block';
            if (hintKelas) hintKelas.style.display = 'block';
        } else {
            if (selectJam) {
                selectJam.disabled = false;
                selectJam.style.background = '#ffffff';
                selectJam.style.color = '';
                selectJam.style.cursor = '';
                selectJam.style.borderColor = '';
            }
            if (searchJam) {
                searchJam.disabled = false;
                searchJam.style.background = '#ffffff';
                searchJam.style.color = '';
                searchJam.style.cursor = '';
            }
            if (selectKelas) {
                selectKelas.disabled = false;
                selectKelas.style.background = '#ffffff';
                selectKelas.style.color = '';
                selectKelas.style.cursor = '';
                selectKelas.style.borderColor = '';
            }
            if (badgeJam) badgeJam.style.display = 'none';
            if (badgeKelas) badgeKelas.style.display = 'none';
            if (hintJam) hintJam.style.display = 'none';
            if (hintKelas) hintKelas.style.display = 'none';
        }
    }

    // Unified Selection Handler
    function onJadwalSelectionChanged() {
        const checkboxes = document.querySelectorAll('.cb-jadwal-sesi');
        const checked = document.querySelectorAll('.cb-jadwal-sesi:checked');
        const totalCards = checkboxes.length;
        const checkedCount = checked.length;

        const feedbackBar = document.getElementById('jadwal_feedback_bar');
        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        const sehariStrip = document.getElementById('sehari_penuh_strip');
        const selectJam = document.getElementById('select_jam_pelajaran');
        const selectKelas = document.getElementById('select_kelas');
        const inputJadwal = document.getElementById('input_id_jadwal');

        checkboxes.forEach(cb => {
            const card = document.getElementById(`card_jadwal_${cb.value}`);
            const pill = document.getElementById(`pill_jadwal_${cb.value}`);
            if (card) {
                if (cb.checked) {
                    card.classList.add('selected');
                    if (checkedCount === totalCards && totalCards > 0) {
                        card.classList.add('sehari-penuh-selected');
                    } else {
                        card.classList.remove('sehari-penuh-selected');
                    }
                    if (pill) pill.style.display = 'inline-flex';
                } else {
                    card.classList.remove('selected', 'sehari-penuh-selected');
                    if (pill) pill.style.display = 'none';
                }
            }
        });

        if (checkedCount === 0) {
            if (feedbackBar) {
                feedbackBar.style.display = 'none';
                feedbackBar.className = 'jadwal-feedback-bar';
                feedbackBar.innerHTML = '';
            }
            if (chkSehariPenuh) chkSehariPenuh.checked = false;
            if (sehariStrip) sehariStrip.classList.remove('active');

            if (inputJadwal) inputJadwal.value = '';
            setManualInputsLocked(false);
            if (selectJam) {
                selectJam.setAttribute('required', 'required');
            }
            if (selectKelas) {
                selectKelas.setAttribute('required', 'required');
            }
        } else if (checkedCount === 1) {
            const firstCb = checked[0];
            const jamVal = firstCb.getAttribute('data-jam');
            const kelasVal = firstCb.getAttribute('data-id-kelas');
            const kelasName = firstCb.getAttribute('data-kelas-name');
            const idJadwalVal = firstCb.getAttribute('data-id-jadwal');

            if (inputJadwal) inputJadwal.value = idJadwalVal;
            setManualInputsLocked(false);

            if (selectKelas && kelasVal) selectKelas.value = kelasVal;
            if (selectJam && jamVal) {
                let found = Array.from(selectJam.options).some(o => o.value === jamVal);
                if (!found) {
                    const opt = document.createElement('option');
                    opt.value = jamVal;
                    opt.textContent = jamVal;
                    selectJam.appendChild(opt);
                }
                selectJam.value = jamVal;
            }

            if (selectJam) {
                selectJam.removeAttribute('required');
            }
            if (selectKelas) {
                selectKelas.removeAttribute('required');
            }

            if (chkSehariPenuh) chkSehariPenuh.checked = (totalCards === 1);
            if (sehariStrip) {
                if (totalCards === 1) {
                    sehariStrip.classList.add('active');
                    setManualInputsLocked(true, 'Terkunci (Sehari Penuh)');
                } else {
                    sehariStrip.classList.remove('active');
                }
            }

            if (feedbackBar) {
                feedbackBar.style.display = 'flex';
                feedbackBar.className = 'jadwal-feedback-bar jadwal-feedback-single';
                feedbackBar.innerHTML = `<i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> <span><strong>1 Sesi Terpilih (${kelasName} — ${jamVal}):</strong> Jam Pelajaran & Kelas pada form di bawah telah otomatis disesuaikan.</span>`;
            }
        } else if (checkedCount > 1 && checkedCount < totalCards) {
            if (inputJadwal) inputJadwal.value = '';
            setManualInputsLocked(true, 'Terkunci (Multi-Sesi)');

            if (chkSehariPenuh) chkSehariPenuh.checked = false;
            if (sehariStrip) sehariStrip.classList.remove('active');

            if (feedbackBar) {
                feedbackBar.style.display = 'flex';
                feedbackBar.className = 'jadwal-feedback-bar jadwal-feedback-multi';
                feedbackBar.innerHTML = `<i class="fa-solid fa-check-double" style="font-size: 15px;"></i> <span><strong>${checkedCount} Sesi Terpilih:</strong> Kolom Jam Pelajaran & Kelas dikunci otomatis. Sistem akan membuat ${checkedCount} penugasan guru pengganti sekaligus untuk setiap sesi jam pelajaran & kelas yang dicentang saat form disimpan.</span>`;
            }
        } else if (checkedCount === totalCards && totalCards > 0) {
            if (inputJadwal) inputJadwal.value = '';
            setManualInputsLocked(true, 'Terkunci (Sehari Penuh)');

            if (chkSehariPenuh) chkSehariPenuh.checked = true;
            if (sehariStrip) sehariStrip.classList.add('active');

            if (feedbackBar) {
                feedbackBar.style.display = 'flex';
                feedbackBar.className = 'jadwal-feedback-bar jadwal-feedback-all';
                feedbackBar.innerHTML = `<i class="fa-solid fa-calendar-check" style="font-size: 16px;"></i> <span><strong>Penugasan Sehari Penuh Aktif (${checkedCount} Sesi Terpilih):</strong> Kolom Jam Pelajaran & Kelas dikunci otomatis. Semua sesi KBM guru tidak hadir pada hari ini akan otomatis dibuatkan penugasan sekaligus saat form disimpan.</span>`;
            }
        }
    }

    function toggleSelectAllJadwal(selectAll) {
        const checkboxes = document.querySelectorAll('.cb-jadwal-sesi');
        checkboxes.forEach(cb => {
            cb.checked = selectAll;
        });
        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh) chkSehariPenuh.checked = selectAll;
        onJadwalSelectionChanged();
    }

    // Dynamic Fetch Opsi Guru Piket Berdasarkan Tanggal Penugasan
    function fetchPiketGuruByDate() {
        const inputTanggal = document.getElementById('input_tanggal_penugasan');
        const selectPengganti = document.getElementById('select_guru_pengganti');
        if (!inputTanggal || !selectPengganti) return;

        const tanggal = inputTanggal.value;
        if (!tanggal) return;

        fetch(`{{ route('piket.guru-pengganti.piket-date') }}?tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const currentSelectedVal = selectPengganti.value || selectPengganti.getAttribute('data-old-val');
                    
                    // Update list guru mengajar lainnya secara global
                    guruMengajarLainnyaList = (data.other_gurus || []).map(g => ({
                        id_guru: g.id_guru,
                        nama_guru: g.nama_guru,
                        nip: g.nip,
                        mapel: g.mapel_nama
                    }));

                    selectPengganti.innerHTML = '<option value="">-- Pilih Guru Pengganti --</option>';

                    const optgrpPiket = document.createElement('optgroup');
                    optgrpPiket.id = 'optgroup_guru_piket_main';
                    optgrpPiket.label = `📌 Guru Piket pada Tanggal Tersebut (Hari ${data.formatted_date})`;

                    if (data.piket_gurus && data.piket_gurus.length > 0) {
                        data.piket_gurus.forEach(g => {
                            const opt = document.createElement('option');
                            opt.value = g.id_guru;
                            opt.textContent = `[Guru Piket S${g.slot_ke || 1}] ${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel_nama})`;
                            if (currentSelectedVal && currentSelectedVal == g.id_guru) {
                                opt.selected = true;
                            }
                            optgrpPiket.appendChild(opt);
                        });
                    } else {
                        const opt = document.createElement('option');
                        opt.disabled = true;
                        opt.textContent = '(Tidak ada jadwal guru piket terdaftar pada tanggal ini)';
                        optgrpPiket.appendChild(opt);
                    }
                    selectPengganti.appendChild(optgrpPiket);

                    // Re-append Guru Mengajar Lainnya jika sebelumnya dibuka atau guru tergolong guru lain
                    const isSelectedInPiket = (data.piket_gurus || []).some(g => g.id_guru == currentSelectedVal);
                    if (isGuruLainnyaVisible || (currentSelectedVal && !isSelectedInPiket)) {
                        isGuruLainnyaVisible = false;
                        toggleGuruMengajarLainnya(true);
                    }
                    if (currentSelectedVal) {
                        selectPengganti.value = currentSelectedVal;
                    }
                }
            })
            .catch(err => {
                console.error("Gagal memuat daftar guru piket per tanggal:", err);
            });
    }

    // Dynamic Fetch Opsi Guru Piket untuk Modal Edit Berdasarkan Tanggal Penugasan
    function fetchEditPiketGuruByDate() {
        const inputTanggal = document.getElementById('edit_input_tanggal');
        const selectPengganti = document.getElementById('edit_select_guru_pengganti');
        if (!inputTanggal || !selectPengganti) return;

        const tanggal = inputTanggal.value;
        if (!tanggal) return;

        fetch(`{{ route('piket.guru-pengganti.piket-date') }}?tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const currentSelectedVal = selectPengganti.value;

                    selectPengganti.innerHTML = '<option value="">-- Pilih Guru Pengganti --</option>';

                    const optgrpPiket = document.createElement('optgroup');
                    optgrpPiket.id = 'edit_optgroup_guru_piket_main';
                    optgrpPiket.label = `📌 Guru Piket pada Tanggal Tersebut (Hari ${data.formatted_date})`;

                    if (data.piket_gurus && data.piket_gurus.length > 0) {
                        data.piket_gurus.forEach(g => {
                            const opt = document.createElement('option');
                            opt.value = g.id_guru;
                            opt.textContent = `[Guru Piket S${g.slot_ke || 1}] ${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel_nama})`;
                            if (currentSelectedVal && currentSelectedVal == g.id_guru) {
                                opt.selected = true;
                            }
                            optgrpPiket.appendChild(opt);
                        });
                    } else {
                        const opt = document.createElement('option');
                        opt.disabled = true;
                        opt.textContent = '(Tidak ada jadwal guru piket terdaftar pada tanggal ini)';
                        optgrpPiket.appendChild(opt);
                    }
                    selectPengganti.appendChild(optgrpPiket);

                    const isSelectedInPiket = (data.piket_gurus || []).some(g => g.id_guru == currentSelectedVal);
                    if (isEditGuruLainnyaVisible || (currentSelectedVal && !isSelectedInPiket)) {
                        isEditGuruLainnyaVisible = false;
                        toggleEditGuruMengajarLainnya(true);
                    }
                    if (currentSelectedVal) {
                        selectPengganti.value = currentSelectedVal;
                    }
                }
            })
            .catch(err => {
                console.error("Gagal memuat daftar guru piket per tanggal di modal edit:", err);
            });
    }

    // Sisipkan Sesi Mengajar Guru Tidak Hadir di Paling Atas Dropdown Jam Pelajaran
    function updateJamOptionsWithTeacherSchedules(jadwals) {
        const jamSelect = document.getElementById('select_jam_pelajaran');
        if (!jamSelect || !jadwals || jadwals.length === 0) return;

        const oldOptGroup = document.getElementById('optgroup_jadwal_guru_tidak_hadir');
        if (oldOptGroup) oldOptGroup.remove();

        const grpTeacher = document.createElement('optgroup');
        grpTeacher.id = 'optgroup_jadwal_guru_tidak_hadir';
        grpTeacher.label = '📌 Sesi Mengajar Guru Tidak Hadir pada Tanggal Ini (Otomatis Sync Kelas)';

        jadwals.forEach(j => {
            const opt = document.createElement('option');
            opt.value = j.jam_pelajaran;
            opt.textContent = `[Jadwal Mengajar] ${j.nama_kelas} (${j.nama_mapel}) — ${j.jam_pelajaran}`;
            opt.setAttribute('data-id-jadwal', j.id_jadwal);
            opt.setAttribute('data-id-kelas', j.id_kelas);
            grpTeacher.appendChild(opt);
        });

        jamSelect.insertBefore(grpTeacher, jamSelect.children[1] || null);
    }

    // Filter Real-Time Options Dropdown Berdasarkan Nama / NIP
    function filterSelectOptions(selectId, keyword) {
        const selectElem = document.getElementById(selectId);
        if (!selectElem) return;

        const term = (keyword || '').toLowerCase().trim();

        // Auto-expand "Guru Mengajar Lainnya" saat pengguna mengetik kata kunci pencarian
        if (term.length >= 1) {
            if (selectId === 'select_guru_tidak_hadir') toggleGuruTidakHadirLainnya(true);
            if (selectId === 'select_guru_pengganti') toggleGuruMengajarLainnya(true);
            if (selectId === 'edit_select_guru_tidak_hadir') toggleEditGuruTidakHadirLainnya(true);
            if (selectId === 'edit_select_guru_pengganti') toggleEditGuruMengajarLainnya(true);
        }

        const options = selectElem.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) {
                opt.style.display = ''; // Selalu tampilkan placeholder default
                return;
            }

            const text = opt.textContent.toLowerCase();
            if (term === '' || text.includes(term)) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });

        // Sembunyikan optgroup jika seluruh child option di dalamnya terfilter
        const optgroups = selectElem.querySelectorAll('optgroup');
        optgroups.forEach(grp => {
            const visibleOpts = Array.from(grp.querySelectorAll('option')).filter(o => o.style.display !== 'none');
            if (term === '' || visibleOpts.length > 0) {
                grp.style.display = '';
            } else {
                grp.style.display = 'none';
            }
        });
    }

    // Toggle Guru Tidak Hadir Lainnya (Add Form)
    let isGuruTidakHadirLainnyaVisible = false;
    function toggleGuruTidakHadirLainnya(forceShow = false) {
        const selectElem = document.getElementById('select_guru_tidak_hadir');
        const btn = document.getElementById('btnToggleGuruTidakHadirLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isGuruTidakHadirLainnyaVisible) {
            if (document.getElementById('optgroup_guru_tidak_hadir_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'optgroup_guru_tidak_hadir_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya (Seluruh Data Guru TU)';

            allGuruListMaster.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                const oldVal = selectElem.getAttribute('data-old-val');
                if (oldVal && oldVal == g.id_guru) opt.selected = true;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isGuruTidakHadirLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('optgroup_guru_tidak_hadir_lainnya_dynamic');
            if (grp) grp.remove();
            isGuruTidakHadirLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#f8fafc';
            btn.style.borderColor = '#cbd5e1';
        }
    }

    // Toggle Guru Mengajar Lainnya (Guru Pengganti - Add Form)
    let isGuruLainnyaVisible = false;
    function toggleGuruMengajarLainnya(forceShow = false) {
        const selectElem = document.getElementById('select_guru_pengganti');
        const btn = document.getElementById('btnToggleGuruLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isGuruLainnyaVisible) {
            if (document.getElementById('optgroup_guru_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'optgroup_guru_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya';

            guruMengajarLainnyaList.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                const oldVal = selectElem.getAttribute('data-old-val');
                if (oldVal && oldVal == g.id_guru) opt.selected = true;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isGuruLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('optgroup_guru_lainnya_dynamic');
            if (grp) grp.remove();
            isGuruLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#f8fafc';
            btn.style.borderColor = '#cbd5e1';
        }
    }

    // Modal Lihat Detail Lengkap
    function showDetailModalComplete(data) {
        document.getElementById('detailGuruUtama').innerText = data.guru_tidak_hadir_nama || '-';
        document.getElementById('detailGuruPengganti').innerText = data.guru_pengganti_nama || '-';
        
        let tglFormatted = data.tanggal;
        if (data.tanggal) {
            const p = data.tanggal.split('-');
            if (p.length === 3) tglFormatted = `${p[2]}/${p[1]}/${p[0]}`;
        }
        document.getElementById('detailTanggal').innerText = tglFormatted;

        const st = (data.status || 'aktif').toLowerCase();
        let stBadge = '<span class="badge-status-aktif">Aktif</span>';
        if (st === 'selesai') stBadge = '<span class="badge-status-selesai">Selesai</span>';
        if (st === 'dibatalkan') stBadge = '<span class="badge-status-dibatalkan">Dibatalkan</span>';
        document.getElementById('detailStatus').innerHTML = stBadge;

        document.getElementById('detailKelas').innerText = data.kelas_nama || '-';
        document.getElementById('detailMapel').innerText = data.mapel_nama || '-';
        document.getElementById('detailJam').innerText   = data.jam_pelajaran || '-';
        
        document.getElementById('detailMateri').innerText = data.materi_dititipkan || 'Materi Reguler/Sesuai Kurikulum';
        document.getElementById('detailTugas').innerText  = data.tugas_dititipkan || 'Latihan Soal & Presensi Siswa';
        document.getElementById('detailCatatan').innerText = data.catatan || 'Keterangan penugasan normal';

        // Render File Tugas Attachment Link
        const fileBox = document.getElementById('detailFileTugasBox');
        if (data.file_tugas) {
            const fileUrl = `{{ asset('uploads/tugas_pengganti') }}/${data.file_tugas}`;
            fileBox.innerHTML = `<a href="${fileUrl}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #2563eb; font-weight: 800; text-decoration: none; background: #eff6ff; padding: 8px 14px; border-radius: 8px; border: 1px solid #bfdbfe;">
                <i class="fa-solid fa-file-arrow-down" style="font-size: 16px;"></i> Unduh / Lihat File Tugas (${data.file_tugas})
            </a>`;
        } else {
            fileBox.innerHTML = '<span style="color: #94a3b8; font-style: italic;">Tidak ada file tugas diunggah (Opsional).</span>';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Modal Edit Penugasan
    function openEditModal(data) {
        if (!data || !data.id_penugasan) return;

        const form = document.getElementById('formEditPenugasan');
        form.action = `{{ url('/guru-piket/guru-pengganti') }}/${data.id_penugasan}`;

        const inputJadwal = document.getElementById('edit_input_id_jadwal');
        if (inputJadwal) inputJadwal.value = data.id_jadwal || '';

        const inputTanggal = document.getElementById('edit_input_tanggal');
        if (inputTanggal) inputTanggal.value = data.tanggal || '';

        const selStatus = document.getElementById('edit_select_status');
        if (selStatus) selStatus.value = (data.status || 'aktif').toLowerCase();
        
        const selTidakHadir = document.getElementById('edit_select_guru_tidak_hadir');
        if (selTidakHadir && data.id_guru_tidak_hadir) {
            let existsInIzin = Array.from(selTidakHadir.options).some(o => o.value == data.id_guru_tidak_hadir);
            if (!existsInIzin) {
                toggleEditGuruTidakHadirLainnya(true);
            }
            selTidakHadir.value = data.id_guru_tidak_hadir;
        }

        const selPengganti = document.getElementById('edit_select_guru_pengganti');
        if (selPengganti && data.id_guru_pengganti) {
            let existsInPiket = Array.from(selPengganti.options).some(o => o.value == data.id_guru_pengganti);
            if (!existsInPiket) {
                toggleEditGuruMengajarLainnya(true);
            }
            selPengganti.value = data.id_guru_pengganti;
        }

        const selKelas = document.getElementById('edit_select_kelas');
        if (selKelas && data.id_kelas) selKelas.value = data.id_kelas;
        
        const textMateri = document.getElementById('edit_textarea_materi');
        if (textMateri) textMateri.value = data.materi_dititipkan || '';

        const textTugas = document.getElementById('edit_textarea_tugas');
        if (textTugas) textTugas.value = data.tugas_dititipkan || '';

        const inputCatatan = document.getElementById('edit_input_catatan');
        if (inputCatatan) inputCatatan.value = data.catatan || '';

        const fileInfo = document.getElementById('edit_current_file_info');
        if (data.file_tugas) {
            fileInfo.innerHTML = `<i class="fa-solid fa-paperclip"></i> File tugas saat ini: <strong>${data.file_tugas}</strong>`;
        } else {
            fileInfo.innerText = '';
        }

        // Trigger updates for Date, Master Jam options, and Schedule Chips in Edit Modal
        onEditTanggalPenugasanChanged(data.jam_pelajaran);

        document.getElementById('editModal').style.display = 'flex';
    }

    let isEditGuruTidakHadirLainnyaVisible = false;
    function toggleEditGuruTidakHadirLainnya(forceShow = false) {
        const selectElem = document.getElementById('edit_select_guru_tidak_hadir');
        const btn = document.getElementById('edit_btnToggleGuruTidakHadirLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isEditGuruTidakHadirLainnyaVisible) {
            if (document.getElementById('edit_optgroup_guru_tidak_hadir_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'edit_optgroup_guru_tidak_hadir_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya (Seluruh Data Guru TU)';

            allGuruListMaster.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isEditGuruTidakHadirLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('edit_optgroup_guru_tidak_hadir_lainnya_dynamic');
            if (grp) grp.remove();
            isEditGuruTidakHadirLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#f8fafc';
            btn.style.borderColor = '#cbd5e1';
        }
    }

    let isEditGuruLainnyaVisible = false;
    function toggleEditGuruMengajarLainnya(forceShow = false) {
        const selectElem = document.getElementById('edit_select_guru_pengganti');
        const btn = document.getElementById('edit_btnToggleGuruLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isEditGuruLainnyaVisible) {
            if (document.getElementById('edit_optgroup_guru_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'edit_optgroup_guru_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya';

            guruMengajarLainnyaList.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isEditGuruLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('edit_optgroup_guru_lainnya_dynamic');
            if (grp) grp.remove();
            isEditGuruLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#f8fafc';
            btn.style.borderColor = '#cbd5e1';
        }
    }

    function onEditTanggalPenugasanChanged(targetJamVal = null) {
        updateEditNamaHariLabel();
        updateEditJamOptionsByDate(targetJamVal);
        fetchEditJadwalGuruTidakHadirList();
        fetchEditPiketGuruByDate();
    }

    function updateEditNamaHariLabel() {
        const dateInput = document.getElementById('edit_input_tanggal');
        const labelHari = document.getElementById('edit_text_nama_hari');
        if (!dateInput || !labelHari) return;

        const val = dateInput.value;
        if (!val) {
            labelHari.innerText = '-';
            return;
        }

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const monthsIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = daysIndo[dateObj.getDay()];
        const dayNum = dateObj.getDate();
        const monthName = monthsIndo[dateObj.getMonth()];
        const yearNum = dateObj.getFullYear();

        labelHari.innerHTML = `<strong>${dayName}</strong>, ${dayNum} ${monthName} ${yearNum}`;
    }

    function updateEditJamOptionsByDate(targetJamVal = null) {
        const dateInput = document.getElementById('edit_input_tanggal');
        const jamSelect = document.getElementById('edit_select_jam_pelajaran');
        if (!dateInput || !jamSelect) return;

        const val = dateInput.value;
        if (!val) return;

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const day = dateObj.getDay();
        const isJumat = (day === 5);

        const currentSelected = targetJamVal || jamSelect.value;
        jamSelect.innerHTML = '<option value="">-- Pilih Jam Pelajaran (Master TU) --</option>';

        const grpSingle = document.createElement('optgroup');
        grpSingle.label = isJumat ? 'Satu Sesi Jam Pelajaran (Master TU - Khusus Hari Jumat)' : 'Satu Sesi Jam Pelajaran (Master TU - Senin s/d Kamis)';

        jamPelajaranMaster.forEach(item => {
            let timeStr = '';
            if (isJumat) {
                if (item.jam_mulai_jumat && item.jam_selesai_jumat) {
                    timeStr = `${item.jam_mulai_jumat.substring(0,5)} - ${item.jam_selesai_jumat.substring(0,5)} WIB`;
                }
            } else {
                if (item.jam_mulai && item.jam_selesai) {
                    timeStr = `${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} WIB`;
                }
            }

            if (timeStr) {
                const optVal = `${item.jam_ke} (${timeStr})`;
                const opt = document.createElement('option');
                opt.value = optVal;
                opt.textContent = `${item.jam_ke} (${timeStr}) — ${item.keterangan || 'Sesi Pembelajaran'}`;
                if (currentSelected === optVal) opt.selected = true;
                grpSingle.appendChild(opt);
            }
        });

        jamSelect.appendChild(grpSingle);

        const grpMulti = document.createElement('optgroup');
        grpMulti.label = isJumat ? 'Rentang Multi-Jam Pembelajaran Lengkap (Khusus Hari Jumat)' : 'Rentang Multi-Jam Pembelajaran Lengkap (Senin s/d Kamis)';

        let multiOptions = generateMultiJamOptions(isJumat);

        multiOptions.forEach(optVal => {
            const opt = document.createElement('option');
            opt.value = optVal;
            opt.textContent = optVal;
            if (currentSelected === optVal) opt.selected = true;
            grpMulti.appendChild(opt);
        });

        jamSelect.appendChild(grpMulti);

        if (currentSelected) {
            let exists = Array.from(jamSelect.options).some(o => o.value === currentSelected);
            if (!exists) {
                const opt = document.createElement('option');
                opt.value = currentSelected;
                opt.textContent = currentSelected;
                opt.selected = true;
                jamSelect.appendChild(opt);
            } else {
                jamSelect.value = currentSelected;
            }
        }
    }

    function onEditGuruTidakHadirChanged(selectElem) {
        fetchEditJadwalGuruTidakHadirList();
    }

    function fetchEditJadwalGuruTidakHadirList() {
        const selectGuruHadir = document.getElementById('edit_select_guru_tidak_hadir');
        const inputTanggal   = document.getElementById('edit_input_tanggal');
        const wrapperJadwal  = document.getElementById('edit_wrapper_jadwal_pilihan');
        const listContainer  = document.getElementById('edit_jadwal_pilihan_list');

        if (!selectGuruHadir || !inputTanggal || !wrapperJadwal || !listContainer) return;

        const idGuru  = selectGuruHadir.value;
        const tanggal = inputTanggal.value;

        if (!idGuru) {
            wrapperJadwal.style.display = 'none';
            listContainer.innerHTML = '';
            return;
        }

        fetch(`{{ route('piket.guru-pengganti.jadwal-guru') }}?id_guru=${idGuru}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.jadwals && data.jadwals.length > 0) {
                    let html = '';
                    data.jadwals.forEach(j => {
                        html += `<button type="button" class="btn-edit-schedule-chip" onclick='applyEditScheduleChoice(${j.id_jadwal}, ${j.id_kelas}, "${j.jam_pelajaran}")' style="background: #ffffff; border: 1px solid #86efac; color: #14532d; padding: 6px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 11.5px; transition: all 0.2s ease;">
                            <i class="fa-solid fa-clock" style="color: #16a34a;"></i> ${j.nama_kelas} (${j.nama_mapel}) — ${j.jam_pelajaran}
                        </button>`;
                    });
                    listContainer.innerHTML = html;
                    wrapperJadwal.style.display = 'block';
                } else {
                    wrapperJadwal.style.display = 'block';
                    listContainer.innerHTML = `<span style="color: #dc2626; font-style: italic;"><i class="fa-solid fa-info-circle"></i> Guru ini tidak memiliki jadwal mengajar pada hari ${data.hari || ''} (${tanggal}).</span>`;
                }
            })
            .catch(err => {
                wrapperJadwal.style.display = 'none';
            });
    }

    function applyEditScheduleChoice(idJadwal, idKelas, jamPelajaran) {
        const inputJadwal = document.getElementById('edit_input_id_jadwal');
        if (inputJadwal) inputJadwal.value = idJadwal;

        const selectKelas = document.getElementById('edit_select_kelas');
        if (selectKelas) selectKelas.value = idKelas;

        const selectJam = document.getElementById('edit_select_jam_pelajaran');
        if (selectJam) {
            let found = Array.from(selectJam.options).some(opt => opt.value === jamPelajaran);
            if (!found) {
                const opt = document.createElement('option');
                opt.value = jamPelajaran;
                opt.textContent = jamPelajaran;
                selectJam.appendChild(opt);
            }
            selectJam.value = jamPelajaran;
        }

        document.querySelectorAll('.btn-edit-schedule-chip').forEach(btn => {
            btn.style.background = '#ffffff';
            btn.style.borderColor = '#86efac';
            btn.style.color = '#14532d';
        });
        if (event && event.currentTarget) {
            event.currentTarget.style.background = '#dcfce7';
            event.currentTarget.style.borderColor = '#22c55e';
            event.currentTarget.style.color = '#15803d';
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Modal Trash (Sampah)
    function openTrashModal() {
        document.getElementById('trashModal').style.display = 'flex';
    }
    function closeTrashModal() {
        document.getElementById('trashModal').style.display = 'none';
    }

    function openModalStatGuruTidakHadir() {
        document.getElementById('modalStatGuruTidakHadir').style.display = 'flex';
    }
    function closeModalStatGuruTidakHadir() {
        document.getElementById('modalStatGuruTidakHadir').style.display = 'none';
    }

    function openModalStatGuruPengganti() {
        document.getElementById('modalStatGuruPengganti').style.display = 'flex';
    }
    function closeModalStatGuruPengganti() {
        document.getElementById('modalStatGuruPengganti').style.display = 'none';
    }

    // Auto-fill materi & tugas dari GuruIzin
    function autoFillMateriFromIzin(selectElem) {
        const selectedOpt = selectElem.options[selectElem.selectedIndex];
        if (selectedOpt) {
            const materi = selectedOpt.getAttribute('data-materi');
            const tugas = selectedOpt.getAttribute('data-tugas');
            const materiField = document.getElementById('materi_dititipkan_field');
            const tugasField = document.getElementById('tugas_dititipkan_field');

            if (materi && materiField && !materiField.value) {
                materiField.value = materi;
            }
            if (tugas && tugasField && !tugasField.value) {
                tugasField.value = tugas;
            }
        }
    }

    // Client-side validation: cegah tanggal lalu & guru sama
    document.addEventListener('DOMContentLoaded', function() {
        onTanggalPenugasanChanged();

        const selectJamPelajaran = document.getElementById('select_jam_pelajaran');
        if (selectJamPelajaran) {
            selectJamPelajaran.addEventListener('change', function() {
                const selectedOpt = this.options[this.selectedIndex];
                if (selectedOpt) {
                    const idJadwal = selectedOpt.getAttribute('data-id-jadwal');
                    const idKelas = selectedOpt.getAttribute('data-id-kelas');
                    if (idJadwal) {
                        const inputJadwal = document.getElementById('input_id_jadwal');
                        if (inputJadwal) inputJadwal.value = idJadwal;

                        // Centang checklist terkait
                        const checkboxes = document.querySelectorAll('.cb-jadwal-sesi');
                        checkboxes.forEach(cb => {
                            cb.checked = (cb.value == idJadwal);
                        });
                        onJadwalSelectionChanged();
                    }
                    if (idKelas) {
                        const selectKelas = document.getElementById('select_kelas');
                        if (selectKelas) selectKelas.value = idKelas;
                    }
                }
            });
        }

        const selectPengganti = document.getElementById('select_guru_pengganti');
        if (selectPengganti) {
            const oldVal = selectPengganti.getAttribute('data-old-val');
            if (oldVal) {
                const isPiket = Array.from(selectPengganti.options).some(o => o.value == oldVal);
                if (!isPiket) {
                    toggleGuruMengajarLainnya();
                }
            }
        }

        const selectTidakHadir = document.getElementById('select_guru_tidak_hadir');
        if (selectTidakHadir) {
            const oldValHadir = selectTidakHadir.getAttribute('data-old-val');
            if (oldValHadir) {
                const isIzin = Array.from(selectTidakHadir.options).some(o => o.value == oldValHadir);
                if (!isIzin) {
                    toggleGuruTidakHadirLainnya(true);
                }
            }
        }

        const form = document.getElementById('formDirectPenugasan');
        const inputTanggal = document.getElementById('input_tanggal_penugasan');
        const selTidakHadir = document.getElementById('select_guru_tidak_hadir');
        const selPengganti = document.getElementById('select_guru_pengganti');
        const chkSehariPenuh = document.getElementById('check_sehari_penuh');

        if (form && selTidakHadir && selPengganti) {
            form.addEventListener('submit', function(e) {
                const selectedDate = inputTanggal ? inputTanggal.value : '';
                if (selectedDate && selectedDate < todayDateStr) {
                    e.preventDefault();
                    alert('Validasi Gagal: Penugasan Guru Pengganti tidak dapat dibuat untuk tanggal yang sudah berlalu (sebelum hari ini)!');
                    inputTanggal.focus();
                    return false;
                }

                if (selTidakHadir.value && selPengganti.value && selTidakHadir.value === selPengganti.value) {
                    e.preventDefault();
                    alert('Validasi Gagal: Guru Pengganti tidak boleh sama dengan Guru yang Tidak Hadir!');
                    selPengganti.focus();
                    return false;
                }
            });
        }
    });

    // Fitur Checkbox & Hapus Massal Penugasan Guru Pengganti
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.guru-pengganti-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.guru-pengganti-checkbox');
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
        const btnBulk = document.getElementById('btnBulkDelete');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllCb = document.getElementById('selectAllCheckbox');

        const count = checkedBoxes.length;
        if (selectedCountSpan) selectedCountSpan.textContent = count;

        if (selectAllCb && checkboxes.length > 0) {
            selectAllCb.checked = (checkboxes.length === count);
        }

        if (btnBulk) {
            if (count > 0) {
                btnBulk.style.opacity = '1';
                btnBulk.style.pointerEvents = 'auto';
            } else {
                btnBulk.style.opacity = '0.5';
                btnBulk.style.pointerEvents = 'none';
            }
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu penugasan guru pengganti yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').style.display = 'flex';
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').style.display = 'none';
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
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

<!-- Form Hidden untuk Hapus Massal Penugasan Guru Pengganti -->
<form id="bulkDeleteForm" action="{{ route('piket.guru-pengganti.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal Penugasan Guru Pengganti -->
<div id="bulkDeleteModal" class="modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 9999; padding: 20px;">
    <div class="modal-content" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden; padding: 0;">
        <div style="padding: 18px 24px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" onclick="closeBulkDeleteModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="text-align: center; padding: 24px;">
            <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 28px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> penugasan guru pengganti yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="btn-reset-light" style="padding: 10px 20px; font-size: 13px; font-weight: 700;">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" style="padding: 10px 24px; font-size: 13px; font-weight: 800; background: #ef4444; color: #ffffff; border: none; border-radius: 8px; cursor: pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
