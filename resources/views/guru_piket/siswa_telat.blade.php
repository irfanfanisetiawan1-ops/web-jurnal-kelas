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
    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .mobile-page-topbar,
    .mobile-telat-stat-carousel-wrap,
    .mobile-telat-form-card,
    .mobile-telat-section,
    #mobileFilterModal,
    .telat-btn-text-short {
        display: none !important;
    }

    @media (max-width: 768px) {
        .telat-desktop-table-card,
        .telat-desktop-stat-grid,
        .telat-btn-text-full {
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

        .mobile-telat-stat-carousel-wrap,
        .mobile-telat-form-card,
        .mobile-telat-section {
            display: flex !important;
        }

        #mobileFilterModal.active,
        #detailModalSiswaTelat.active {
            display: flex !important;
        }

        .telat-btn-text-short {
            display: inline !important;
        }

        .telat-page-container {
            padding-bottom: 24px;
        }

        /* Mobile Stat Cards Carousel */
        .mobile-telat-stat-carousel-wrap {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .mobile-telat-stat-container {
            position: relative;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            touch-action: pan-y;
            background: transparent;
        }

        .mobile-telat-stat-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }

        .mobile-telat-stat-slide {
            flex: 0 0 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .mobile-telat-stat-slide .telat-stat-card {
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

        .mobile-telat-stat-container:hover .m-stat-arrow,
        .mobile-telat-stat-container.is-hovered .m-stat-arrow {
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

        .mobile-telat-stat-dots {
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

        /* Mobile Form Card */
        .mobile-telat-form-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
            margin-bottom: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .mobile-telat-form-header {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .m-card-icon-wrap {
            width: 38px;
            height: 38px;
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

        .mobile-telat-form-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .mobile-telat-form-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 10px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            width: 100%;
            box-sizing: border-box;
        }

        .m-btn-form-reset, .m-btn-form-submit {
            height: 42px;
            min-height: 42px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
            white-space: nowrap;
        }

        .m-btn-form-reset {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
        }

        .m-btn-form-submit {
            background: #2563eb;
            border: 1px solid #1d4ed8;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        /* Mobile Section: Filter + Cards List */
        .mobile-telat-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .mobile-telat-filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mobile-telat-filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .mobile-telat-search-row {
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

        .m-filter-active-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34d399;
            border: 1.5px solid #ffffff;
            margin-left: 2px;
        }

        /* Mobile Cards List */
        .mobile-telat-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .mobile-telat-card-item {
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
            border-left: 4px solid #f97316;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .m-telat-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .m-telat-title-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .m-telat-student-name {
            font-size: 14px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-telat-meta-sub {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .badge-telat-time-mobile {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .m-telat-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .m-telat-info-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .m-telat-info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.02em;
        }

        .m-telat-info-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .m-telat-alasan-box {
            background: #f8fafc;
            border-left: 3px solid #cbd5e1;
            padding: 8px 12px;
            border-radius: 0 8px 8px 0;
            font-size: 12px;
            font-style: italic;
            color: #475569;
            line-height: 1.4;
        }

        .m-telat-hukuman-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #991b1b;
            font-size: 11.5px;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .m-telat-action-row {
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

        .m-telat-quick-icons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .m-telat-icon-btn {
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

        .m-telat-icon-btn.m-btn-wa {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .m-telat-icon-btn.m-btn-edit {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
        }

        .m-telat-icon-btn.m-btn-del {
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

        .mobile-filter-modal-wrap.active {
            display: flex !important;
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

        @keyframes sheetSlideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    }
</style>
@endsection

@section('content')
<div class="telat-page-container">

    <!-- ─── MOBILE TOPBAR (TITLE + SAMPAH PILL) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Siswa Telat</h1>
            <span class="mobile-topbar-sub">Pencatatan & riwayat keterlambatan siswa</span>
        </div>
        <div class="mobile-topbar-right">
            @php
                $trashedCount = \App\Models\SiswaTelat::onlyTrashed()->count();
            @endphp
            <a href="{{ route('piket.siswa-telat.trash') }}" class="m-btn-trash-pill" title="Sampah">
                <i class="fa-solid fa-trash-can"></i>
                <span>Sampah</span>
                @if($trashedCount > 0)
                    <span class="m-trash-badge">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- ─── MOBILE 3-STAT CAROUSEL (SWIPEABLE + DOT INDICATORS) ─── -->
    <div class="mobile-telat-stat-carousel-wrap">
        <div class="mobile-telat-stat-container" id="mobileTelatStatContainer">
            <button type="button" class="m-stat-arrow m-stat-prev" onclick="prevTelatStatSlide()" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-stat-arrow m-stat-next" onclick="nextTelatStatSlide()" aria-label="Berikutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div class="mobile-telat-stat-track" id="mobileTelatStatTrack">
                <!-- Slide 1: Total Telat Hari Ini -->
                <div class="mobile-telat-stat-slide">
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
                </div>

                <!-- Slide 2: Terlambat Bulan Ini -->
                <div class="mobile-telat-stat-slide">
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
                </div>

                <!-- Slide 3: Total Data Siswa -->
                <div class="mobile-telat-stat-slide">
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
            </div>
        </div>

        <!-- Carousel Dots -->
        <div class="mobile-telat-stat-dots" id="mobileTelatStatDots">
            <span class="m-stat-dot active" onclick="goToTelatStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToTelatStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToTelatStatSlide(2)"></span>
        </div>
    </div>

    <!-- ─── TOP 3 STAT CARDS DESKTOP ─── -->
    <div class="telat-desktop-stat-grid">
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
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
<<<<<<< HEAD
        <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 700;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #10b981;"></i>
                <div>
                    <div>{{ session('success') }}</div>
                    <div style="font-size: 12px; font-weight: 500; color: #047857; margin-top: 2px;">
                        Data berhasil disimpan di sistem dan tersinkronisasi dengan portal Guru Mengajar & database.
                    </div>
                </div>
            </div>
            @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank" class="badge-wa-ok" style="font-size: 12.5px; padding: 8px 14px; text-decoration: none; border-radius: 8px; font-weight: 800; background: #25d366; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3);">
                    <i class="fa-brands fa-whatsapp" style="font-size: 15px;"></i> Buka Chat WA Manual ({{ session('guru_nama') }})
                </a>
            @endif
=======
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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

    <!-- ─── FORM PENCATATAN SISWA TELAT (MOBILE ONLY) ─── -->
    <div class="mobile-telat-form-card">
        <div class="mobile-telat-form-header">
            <div class="m-card-icon-wrap">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <h2 style="font-size: 14.5px; font-weight: 800; color: #1e3a8a; margin: 0;">Catat Siswa Telat</h2>
                <span style="font-size: 11px; font-weight: 600; color: #64748b;">Notifikasi otomatis ke Guru Mengajar</span>
            </div>
        </div>

        <form action="{{ route('piket.siswa-telat.store') }}" method="POST">
            @csrf
            <div class="mobile-telat-form-body">
                <!-- Pilih Siswa -->
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Pilih Siswa <span style="color: #ef4444;">*</span></label>
                    <select name="id_siswa" id="mobile_id_siswa" class="select2-siswa-mobile" style="width: 100%;" required onchange="onMobileSiswaSelected(this.value)">
                        <option value="">-- Cari Nama Siswa / NIS / Kelas --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_siswa }}">
                                {{ $s->nama_siswa }} — Kelas {{ $s->kelas->nama_kelas ?? '-' }} (NIS: {{ $s->nis ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Preview Identitas Siswa Mobile -->
                <div id="studentPreviewContainerMobile" class="student-preview-card" style="display: none; margin-bottom: 0;">
                    <div>
                        <span>Nama Lengkap:</span>
                        <strong id="mobile_prev_nama_siswa">-</strong>
                    </div>
                    <div>
                        <span>Kelas:</span>
                        <strong id="mobile_prev_kelas_siswa" style="color: #2563eb;">-</strong>
                    </div>
                    <div>
                        <span>NIS / NISN:</span>
                        <strong id="mobile_prev_nis_siswa">-</strong>
                    </div>
                    <div>
                        <span>Jenis Kelamin:</span>
                        <strong id="mobile_prev_jk_siswa">-</strong>
                    </div>
                </div>

                <!-- Guru Mengajar Target -->
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Guru Mengajar Target <span style="color: #ef4444;">*</span></label>
                    <input type="hidden" name="id_jadwal" id="mobile_id_jadwal" value="">
                    <select name="id_guru_mengajar" id="mobile_id_guru_mengajar" class="select2-guru-mobile" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal & Jam -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Tanggal <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="mobile_tanggal" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" class="form-control-custom" style="height: 42px;" required>
                    </div>
                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Jam Datang <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}" class="form-control-custom" style="height: 42px;" placeholder="07:25" required>
                    </div>
                </div>

                <!-- Alasan -->
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Alasan Keterlambatan <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" rows="2" class="form-control-custom" placeholder="Tulis alasan terlambat..." required></textarea>
                </div>

                <!-- Tindakan / Sanksi -->
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Tindakan / Sanksi Piket (Opsional)</label>
                    <textarea name="tindakan_hukuman" rows="2" class="form-control-custom" placeholder="Contoh: Membersihkan halaman sekolah..."></textarea>
                </div>

                <!-- Action Buttons Side-by-Side -->
                <div class="mobile-telat-form-actions">
                    <button type="reset" class="m-btn-form-reset" onclick="resetMobileTelatForm()">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" class="m-btn-form-submit">
                        <i class="fa-solid fa-paper-plane"></i> Simpan Catatan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ─── DATA TABLE CARD & CONTROLS (DESKTOP VIEW) ─── -->
    <div class="telat-card telat-desktop-table-card">
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

    <!-- ─── MOBILE CARD LIST & FILTER SECTION (MOBILE ONLY) ─── -->
    <div class="mobile-telat-section">
        <!-- Filter & Search Toolbar Mobile -->
        <div class="mobile-telat-filter-bar">
            <div style="flex: 1; position: relative;">
                <form action="{{ route('piket.siswa-telat') }}" method="GET" id="mobileSearchForm" style="margin: 0;">
                    @if(request('id_kelas'))
                        <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}">
                    @endif
                    @if(request('tanggal'))
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    @endif
                    <div style="position: relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari siswa / alasan..." class="m-search-input" onkeydown="if(event.key==='Enter') this.form.submit()">
                        @if(request('q'))
                            <a href="{{ route('piket.siswa-telat', request()->except('q')) }}" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; text-decoration: none;">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()" title="Filter Data">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter</span>
                @if(request('id_kelas') || request('tanggal') || request('q'))
                    <span class="m-filter-active-dot"></span>
                @endif
            </button>
        </div>

        @if(request('id_kelas') || request('tanggal') || request('q'))
            <div style="display: flex; align-items: center; justify-content: space-between; background: #eff6ff; border: 1px solid #bfdbfe; padding: 8px 12px; border-radius: 10px; font-size: 12px; color: #1e40af; margin-bottom: 10px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-filter fa-sm"></i>
                    <span>Filter aktif: <strong>{{ request('q') ? '"'.request('q').'" ' : '' }}{{ request('id_kelas') ? 'Kelas ' : '' }}{{ request('tanggal') ? request('tanggal') : '' }}</strong></span>
                </div>
                <a href="{{ route('piket.siswa-telat') }}" style="color: #ef4444; font-weight: 700; text-decoration: none; font-size: 11px;">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            </div>
        @endif

        <!-- Card Items List -->
        <div class="mobile-telat-cards-list">
            @forelse($telatList as $row)
                @php
                    $siswaObj = $row->siswa;
                    $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                    $guruObj  = $row->guruMengajar;

                    $rawHp = null;
                    if ($guruObj && !empty($guruObj->no_hp)) {
                        $rawHp = preg_replace('/[^0-9]/', '', $guruObj->no_hp);
                        if (str_starts_with($rawHp, '0')) {
                            $rawHp = '62' . substr($rawHp, 1);
                        }
                    }

                    $waTextMsg = "*PEMBERITAHUAN SISWA TERLAMBAT (GURU PIKET)*\n\n"
                        . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Guru *".($guruObj->nama_guru ?? 'Guru')."*,\n\n"
                        . "Memberitahukan bahwa siswa dari kelas Bapak/Ibu terlambat hadir di sekolah:\n"
                        . "• *Nama Siswa*: ".($siswaObj->nama_siswa ?? '-')."\n"
                        . "• *NIS / NISN*: ".($siswaObj->nis ?? '-')." / ".($siswaObj->nisn ?? '-')."\n"
                        . "• *Kelas*: ".($kelasObj->nama_kelas ?? '-')."\n"
                        . "• *Jam Datang*: {$row->jam_terlambat} WIB\n"
                        . "• *Alasan*: {$row->alasan}\n"
                        . "• *Tindakan/Hukuman*: ".($row->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Piket')."\n\n"
                        . "Siswa telah melapor ke Guru Piket dan diarahkan ke kelas.\n- Petugas Piket";

                    $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . urlencode($waTextMsg) : null;
                @endphp
                <div class="mobile-telat-card-item">
                    <!-- Header: Icon + Name + Time Badge -->
                    <div class="m-telat-header-row">
                        <div class="m-telat-title-box">
                            <div class="m-card-icon-wrap">
                                <i class="fa-solid fa-user-clock"></i>
                            </div>
                            <div style="min-width: 0;">
                                <div class="m-telat-student-name">{{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}</div>
                                <div class="m-telat-meta-sub">
                                    <span>Kelas {{ $kelasObj->nama_kelas ?? '-' }}</span>
                                    <span>•</span>
                                    <span>NIS: {{ $siswaObj->nis ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="badge-telat-time-mobile">
                            <i class="fa-regular fa-clock"></i> {{ $row->jam_terlambat }} WIB
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="m-telat-info-grid">
                        <div class="m-telat-info-cell">
                            <span class="m-telat-info-label">Tanggal</span>
                            <span class="m-telat-info-val">
                                <i class="fa-regular fa-calendar" style="color: #2563eb; font-size: 11px;"></i>
                                {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <div class="m-telat-info-cell">
                            <span class="m-telat-info-label">Guru Target</span>
                            <span class="m-telat-info-val" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $guruObj->nama_guru ?? '-' }}">
                                <i class="fa-solid fa-user-tie" style="color: #64748b; font-size: 11px;"></i>
                                {{ $guruObj->nama_guru ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="m-telat-alasan-box">
                        "{{ $row->alasan }}"
                    </div>

                    <!-- Hukuman / Sanksi (if any) -->
                    @if($row->tindakan_hukuman)
                        <div class="m-telat-hukuman-box">
                            <i class="fa-solid fa-gavel"></i> <strong>Sanksi:</strong> {{ $row->tindakan_hukuman }}
                        </div>
                    @endif

                    <!-- Action Row -->
                    <div class="m-telat-action-row">
                        <button type="button" onclick='showTelatDetailModal(@json($row), @json($siswaObj), @json($kelasObj), @json($guruObj), {{ json_encode($waDirectUrl) }})' class="m-btn-detail-link">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                        </button>

                        <div class="m-telat-quick-icons">
                            @if($waDirectUrl)
                                <a href="{{ $waDirectUrl }}" target="_blank" class="m-telat-icon-btn m-btn-wa" title="Kirim WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif

                            <button type="button" class="m-telat-icon-btn m-btn-edit" onclick='openEditModal(@json($row), @json($siswaObj), @json($kelasObj))' title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <form action="{{ route('piket.siswa-telat.destroy', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Pindahkan catatan siswa telat ini ke Sampah?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-telat-icon-btn m-btn-del" title="Pindahkan ke Sampah">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 36px 20px; text-align: center;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <h3 style="font-size: 14px; font-weight: 800; color: #1e3a8a; margin: 0 0 6px 0;">Belum Ada Catatan Siswa Telat</h3>
                    <p style="font-size: 12px; color: #64748b; margin: 0; line-height: 1.5;">Tidak ada siswa yang tercatat terlambat untuk tanggal atau filter yang dipilih.</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Pagination -->
        <div style="margin-top: 14px; display: flex; justify-content: center;">
            {{ $telatList->withQueryString()->links() }}
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

<!-- ─── MODAL FILTER MOBILE (BOTTOM SHEET) ─── -->
<div id="mobileFilterModal" class="mobile-filter-modal-wrap">
    <div class="mobile-filter-sheet">
        <div class="mobile-filter-sheet-header">
            <h3 class="mobile-filter-sheet-title">
                <i class="fa-solid fa-sliders" style="color: #2563eb;"></i> Filter Siswa Telat
            </h3>
            <button type="button" class="mobile-filter-sheet-close" onclick="closeMobileFilterModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('piket.siswa-telat') }}" method="GET" style="margin: 0;">
            <div class="mobile-filter-sheet-body">
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Kata Kunci Pencarian</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa / NIS / alasan..." class="form-control-custom">
                </div>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Filter Kelas</label>
                    <select name="id_kelas" class="form-control-custom">
                        <option value="">Semua Kelas</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label class="form-label-custom">Filter Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control-custom">
                </div>

                <div class="mobile-filter-actions-row">
                    <a href="{{ route('piket.siswa-telat') }}" class="telat-btn-reset" style="justify-content: center; height: 42px; text-decoration: none;">
                        Reset
                    </a>
                    <button type="submit" class="telat-btn-cari" style="justify-content: center; height: 42px;">
                        <i class="fa-solid fa-check"></i> Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ─── MODAL DETAIL SISWA TELAT (MOBILE & DESKTOP) ─── -->
<div id="detailModalSiswaTelat" class="telat-modal-backdrop">
    <div class="telat-modal-card" style="max-width: 480px;">
        <div class="telat-modal-header">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-clock" style="color: #60a5fa;"></i> Detail Catatan Siswa Telat
            </h3>
            <i class="fa-solid fa-xmark" onclick="closeTelatDetailModal()" style="cursor: pointer; font-size: 18px; color: #94a3b8; transition: color 0.15s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'"></i>
        </div>
        <div class="telat-modal-body" id="modalDetailContentTelat" style="padding: 20px;">
            <!-- Rendered by JS -->
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

        $('.select2-siswa-mobile').select2({
            placeholder: '-- Cari Nama Siswa / NIS / Kelas --',
            width: '100%'
        });

        $('.select2-guru-mobile').select2({
            placeholder: '-- Pilih Guru Mengajar --',
            width: '100%'
        });

        initTelatStatCarousel();

        $('#mobile_tanggal, .mobile-telat-form-body input[name="jam_terlambat"]').on('change keyup', function() {
            const idSiswa = $('#mobile_id_siswa').val();
            if (idSiswa) {
                onMobileSiswaSelected(idSiswa);
            }
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

    // ─── MOBILE FUNCTIONS ───
    let currentTelatSlide = 0;
    const totalTelatSlides = 3;

    function goToTelatStatSlide(idx) {
        currentTelatSlide = idx;
        const track = document.getElementById('mobileTelatStatTrack');
        const dots = document.querySelectorAll('#mobileTelatStatDots .m-stat-dot');
        if (track) {
            track.style.transform = `translateX(-${currentTelatSlide * 100}%)`;
        }
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentTelatSlide);
        });
    }

    function initTelatStatCarousel() {
        const track = document.getElementById('mobileTelatStatTrack');
        if (!track) return;
        let startX = 0;
        let isSwiping = false;

        track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isSwiping = true;
        }, { passive: true });

        track.addEventListener('touchend', (e) => {
            if (!isSwiping) return;
            const diffX = e.changedTouches[0].clientX - startX;
            if (Math.abs(diffX) > 40) {
                if (diffX < 0 && currentTelatSlide < totalTelatSlides - 1) {
                    goToTelatStatSlide(currentTelatSlide + 1);
                } else if (diffX > 0 && currentTelatSlide > 0) {
                    goToTelatStatSlide(currentTelatSlide - 1);
                }
            }
            isSwiping = false;
        });
    }

    function onMobileSiswaSelected(idSiswa) {
        if (!idSiswa) {
            document.getElementById('studentPreviewContainerMobile').style.display = 'none';
            return;
        }

        const tgl = document.getElementById('mobile_tanggal') ? document.getElementById('mobile_tanggal').value : '';
        const jam = document.querySelector('.mobile-telat-form-body input[name="jam_terlambat"]') ? document.querySelector('.mobile-telat-form-body input[name="jam_terlambat"]').value : '';

        const url = "/guru-piket/api/siswa-schedule-guru/" + idSiswa + "?tanggal=" + encodeURIComponent(tgl) + "&jam_terlambat=" + encodeURIComponent(jam);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.siswa;
                    const k = data.kelas;
                    const matchedJadwal = data.matched_jadwal;

                    document.getElementById('mobile_prev_nama_siswa').innerText = s.nama_siswa || '-';
                    document.getElementById('mobile_prev_kelas_siswa').innerText = k ? k.nama_kelas : '-';
                    document.getElementById('mobile_prev_nis_siswa').innerText = (s.nis || '-') + " / " + (s.nisn || '-');
                    const jkTeks = s.jenis_kelamin_teks ? s.jenis_kelamin_teks : (s.jenis_kelamin === 'L' ? 'Laki-laki' : (s.jenis_kelamin === 'P' ? 'Perempuan' : '-'));
                    document.getElementById('mobile_prev_jk_siswa').innerText = jkTeks;
                    document.getElementById('studentPreviewContainerMobile').style.display = 'grid';

                    if (data.matched_guru_id) {
                        $('#mobile_id_guru_mengajar').val(data.matched_guru_id).trigger('change');
                    }

                    if (matchedJadwal && matchedJadwal.id_jadwal) {
                        document.getElementById('mobile_id_jadwal').value = matchedJadwal.id_jadwal;
                    } else {
                        document.getElementById('mobile_id_jadwal').value = '';
                    }
                }
            })
            .catch(err => console.error("Error fetching student schedule mobile:", err));
    }

    function resetMobileTelatForm() {
        document.getElementById('studentPreviewContainerMobile').style.display = 'none';
        $('#mobile_id_siswa').val('').trigger('change');
        $('#mobile_id_guru_mengajar').val('').trigger('change');
        document.getElementById('mobile_id_jadwal').value = '';
    }

    function openMobileFilterModal() {
        const m = document.getElementById('mobileFilterModal');
        if (m) {
            m.classList.add('active');
            m.style.display = 'flex';
        }
    }

    function closeMobileFilterModal() {
        const m = document.getElementById('mobileFilterModal');
        if (m) {
            m.classList.remove('active');
            m.style.display = 'none';
        }
    }

    function showTelatDetailModal(row, siswa, kelas, guru, waUrl) {
        const sNama = siswa ? siswa.nama_siswa : '-';
        const kNama = kelas ? kelas.nama_kelas : (siswa && siswa.kelas ? siswa.kelas.nama_kelas : '-');
        const nisTeks = siswa ? `${siswa.nis || '-'} / ${siswa.nisn || '-'}` : '-';
        const jkTeks = siswa ? (siswa.jenis_kelamin_teks || (siswa.jenis_kelamin === 'L' ? 'Laki-laki' : (siswa.jenis_kelamin === 'P' ? 'Perempuan' : '-'))) : '-';
        const gNama = guru ? guru.nama_guru : '-';
        const gNip = guru && guru.nip ? guru.nip : '-';
        const mMapel = guru && guru.mapel ? guru.mapel.nama_mapel : '-';

        let hukumanHtml = '';
        if (row.tindakan_hukuman) {
            hukumanHtml = `
                <div style="background: #fff1f2; border: 1px solid #fecdd3; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;">
                    <div style="font-size: 11px; font-weight: 800; color: #991b1b; text-transform: uppercase;">Tindakan / Sanksi Piket:</div>
                    <div style="font-size: 12.5px; font-weight: 600; color: #881337; margin-top: 4px;">${row.tindakan_hukuman}</div>
                </div>
            `;
        }

        let waBtnHtml = '';
        if (waUrl) {
            waBtnHtml = `
                <div style="margin-top: 14px;">
                    <a href="${waUrl}" target="_blank" class="telat-btn-cari" style="background: #16a34a; border-color: #15803d; justify-content: center; width: 100%; text-decoration: none; height: 40px; font-size: 13px;">
                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim Notifikasi WhatsApp ke Guru
                    </a>
                </div>
            `;
        }

        const html = `
            <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 12px; margin-bottom: 14px; border-bottom: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: #eff6ff; border: 1px solid #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #1e3a8a;">${sNama}</h4>
                        <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">Kelas ${kNama}</span>
                    </div>
                </div>
                <span class="badge-telat-time" style="font-size: 11px; padding: 4px 8px;">
                    <i class="fa-regular fa-clock"></i> ${row.jam_terlambat} WIB
                </span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8fafc; border: 1px solid #f1f5f9; padding: 10px 12px; border-radius: 10px; margin-bottom: 14px;">
                <div>
                    <div style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">NIS / NISN</div>
                    <div style="font-size: 12px; font-weight: 700; color: #1e293b;">${nisTeks}</div>
                </div>
                <div>
                    <div style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Jenis Kelamin</div>
                    <div style="font-size: 12px; font-weight: 700; color: #1e293b;">${jkTeks}</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tanggal</div>
                    <div style="font-size: 13px; font-weight: 700; color: #0f172a;">${row.tanggal ? row.tanggal.substring(0, 10) : '-'}</div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Guru Mengajar Target</div>
                    <div style="font-size: 13px; font-weight: 700; color: #0f172a;">${gNama}</div>
                    <div style="font-size: 11px; color: #64748b;">${mMapel}</div>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Alasan Keterlambatan</div>
                <div style="background: #f8fafc; border-left: 3px solid #cbd5e1; padding: 8px 12px; font-size: 12.5px; color: #334155; font-style: italic; border-radius: 0 8px 8px 0;">
                    "${row.alasan}"
                </div>
            </div>

            ${hukumanHtml}
            ${waBtnHtml}

            <div style="display: flex; gap: 8px; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <form action="/guru-piket/siswa-telat/${row.id_siswa_telat}" method="POST" style="margin: 0;" onsubmit="return confirm('Pindahkan data siswa telat ini ke Sampah?');">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="telat-btn-reset" style="height: 36px; padding: 0 14px; border-radius: 8px; font-weight: 700; gap: 6px; color: #dc2626; border-color: #fca5a5; background: #fee2e2;">
                        <i class="fa-solid fa-trash-can"></i> Pindahkan ke Sampah
                    </button>
                </form>
                <button type="button" onclick="closeTelatDetailModal()" class="telat-btn-reset" style="height: 36px; padding: 0 16px;">
                    Tutup
                </button>
            </div>
        `;

        document.getElementById('modalDetailContentTelat').innerHTML = html;
        const m = document.getElementById('detailModalSiswaTelat');
        if (m) {
            m.classList.add('active');
            m.style.display = 'flex';
        }
    }

    function closeTelatDetailModal() {
        const m = document.getElementById('detailModalSiswaTelat');
        if (m) {
            m.classList.remove('active');
            m.style.display = 'none';
        }
    }
</script>
@endsection
