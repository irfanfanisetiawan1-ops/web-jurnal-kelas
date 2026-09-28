@extends('layouts.guru')

@section('title', 'Surat Izin Siswa — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Class & Student Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .surat-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Style Override Select2 & Prevent Horizontal Overflow */
    .select2-container {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    .select2-container .select2-selection--single {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        height: 42px !important;
        padding: 0 10px !important;
        box-sizing: border-box !important;
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        max-width: 100% !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.2s ease !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        background-color: #ffffff !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 40px !important;
        padding-left: 2px !important;
        padding-right: 32px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        position: absolute !important;
        top: 0 !important;
        right: 8px !important;
        width: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        z-index: 99999 !important;
        overflow: hidden !important;
        background: #ffffff !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    .select2-search--dropdown {
        padding: 8px !important;
    }

    .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        padding: 7px 10px !important;
        font-size: 12.5px !important;
        outline: none !important;
        font-family: inherit !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }

    .select2-search__field:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
    }

    .select2-results__option {
        padding: 9px 12px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563eb !important;
        color: #ffffff !important;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Stats Grid */
    .stats-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }
    .stat-card-item:hover { transform: translateY(-2px); }

    .stat-card-item.dark-blue {
        background: #384972;
        color: #ffffff;
        border-color: #2b3957;
    }

    .stat-card-item.sky-blue {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-top: 3px solid #0284c7;
    }

    .stat-card-item.amber-bg {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-top: 3px solid #d97706;
    }

    .stat-card-item.purple-bg {
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
        border-top: 3px solid #7c3aed;
    }

    .stat-card-item .title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 8px;
    }

    .stat-card-item.dark-blue .title { color: #cbd5e1; }
    .stat-card-item.sky-blue .title { color: #0369a1; }
    .stat-card-item.amber-bg .title { color: #b45309; }
    .stat-card-item.purple-bg .title { color: #6d28d9; }

    .stat-card-item .number {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
    }

    .stat-card-item.dark-blue .number { color: #ffffff; }

    .stat-card-item .subtitle {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }
    .stat-card-item.dark-blue .subtitle { color: #94a3b8; }

    /* Info Alert Box */
    .alert-sync-info {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #93c5fd;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        color: #1e40af;
    }

    .alert-sync-info i {
        font-size: 24px;
        color: #2563eb;
        flex-shrink: 0;
    }

    .alert-sync-info h4 {
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 2px 0;
        color: #1e3a8a;
    }

    .alert-sync-info p {
        font-size: 12.5px;
        font-weight: 600;
        margin: 0;
        color: #1e40af;
    }

    /* Form & Cards */
    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }

    .card-custom-body {
        padding: 24px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
    }

    .form-control-custom, .select-custom, .textarea-custom {
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

    .form-control-custom:focus, .select-custom:focus, .textarea-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control-custom.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    /* Wali Kelas Badge Info Box */
    .wali-kelas-badge {
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

    .wali-kelas-badge.empty {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }

    /* Durasi Pill Badge */
    .durasi-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e0e7ff;
        color: #3730a3;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: 6px;
    }

    .date-validation-warning {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 10px;
        display: none;
        align-items: center;
        gap: 8px;
    }

    /* Filter Bar */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s ease;
        box-sizing: border-box;
    }
    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-trash-pink {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    /* Badges */
    .badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .badge-kategori.sakit { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-kategori.izin { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-kategori.dispen { background: #f3e8ff; color: #6d28d9; border: 1px solid #ddd6fe; }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
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

    .student-info .name {
        font-weight: 700;
        font-size: 13.5px;
        color: #0f172a;
    }

    .student-info .sub {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-action-icon.btn-detail { background: #eff6ff; color: #2563eb; }
    .btn-action-icon.btn-detail:hover { background: #dbeafe; color: #1d4ed8; }
    .btn-action-icon.btn-edit { background: #e0f2fe; color: #0284c7; }
    .btn-action-icon.btn-edit:hover { background: #bae6fd; color: #0369a1; }
    .btn-action-icon.btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-action-icon.btn-delete:hover { background: #fca5a5; color: #991b1b; }
    .btn-action-icon.btn-preview { background: #f3e8ff; color: #7c3aed; }
    .btn-action-icon.btn-preview:hover { background: #ddd6fe; color: #6d28d9; }
    .btn-action-icon.btn-whatsapp { background: #22c55e; color: #ffffff; font-size: 15px; }
    .btn-action-icon.btn-whatsapp:hover { background: #16a34a; color: #ffffff; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(34, 197, 94, 0.35); }

    /* Custom Table Styling */
    .table-custom {
        width: 100%;
        min-width: 950px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 12px 14px;
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #cbd5e1;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 12px 14px;
        font-size: 12.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    /* Modal Overlay - FIX OVERLAP WITH TOPBAR (z-index 99999) */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 99999 !important;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 18px;
        max-width: 650px;
        width: 100%;
        max-height: calc(100vh - 36px);
        overflow-y: auto;
        box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.25);
        animation: modalSlide 0.2s ease-out;
        margin: auto;
        box-sizing: border-box;
    }

    @keyframes modalSlide {
        from { transform: translateY(16px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }

    .modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-body {
        padding: 20px;
    }

    .btn-close-modal {
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
        font-size: 16px;
    }
    .btn-close-modal:hover { background: #e2e8f0; color: #0f172a; }

    /* Detail Grid Layout inside Modal */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .detail-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .detail-item .label {
        font-size: 10.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .detail-item .val {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    /* ======================================================== */
    /* MOBILE CARD LIST (FOR SCREEN <= 768px)                   */
    /* ======================================================== */
    .mobile-card-list {
        display: none;
        flex-direction: column;
        gap: 12px;
        padding: 12px;
    }

    .mobile-surat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .mobile-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .mobile-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-top: 4px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 8px;
    }

    .mobile-card-actions .btn-action-mobile {
        padding: 8px 10px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .desktop-table-container {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-sizing: border-box;
    }

    .filter-actions-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* ======================================================== */
    /* RESPONSIVE MEDIA QUERIES (MOBILE HP & TABLETS)           */
    /* ======================================================== */
    @media (max-width: 1080px) and (min-width: 769px) {
        .form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 992px) {
        .stats-summary-grid { grid-template-columns: repeat(2, 1fr) !important; }
    }

    @media (max-width: 768px) {
        .dashboard-page-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .header-left h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.5px !important;
            line-height: 1.2 !important;
        }

        .header-left p {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        .stats-summary-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }

        .stat-card-item {
            padding: 14px !important;
            border-radius: 12px !important;
        }

        .stat-card-item .number {
            font-size: 26px !important;
        }

        .alert-sync-info {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
            padding: 14px !important;
            margin-bottom: 16px !important;
        }

        .form-grid {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            max-width: 100% !important;
            gap: 14px !important;
        }

        .form-grid > div,
        .form-group {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        .form-actions-stack {
            flex-direction: column !important;
            width: 100% !important;
            gap: 10px !important;
        }

        .form-actions-stack button,
        .form-actions-stack a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .card-custom-header {
            padding: 16px 18px !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 6px !important;
        }

        .card-custom-header h2 {
            font-size: 15.5px !important;
            line-height: 1.3 !important;
        }

        .card-custom-body {
            padding: 16px 14px !important;
        }

        .filter-bar-container {
            padding: 12px 14px !important;
        }

        .filter-bar-container form {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
        }

        .filter-input {
            flex: none !important;
            height: 38px !important;
            min-height: 38px !important;
            max-height: 38px !important;
            width: 100% !important;
            min-width: 0 !important;
            padding: 8px 12px !important;
            font-size: 12.5px !important;
            box-sizing: border-box !important;
        }

        .filter-actions-group {
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            margin-left: 0 !important;
        }

        .filter-actions-group .btn-filter-dark,
        .filter-actions-group .btn-reset-light,
        .filter-actions-group .btn-trash-pink,
        .filter-actions-group #btnBulkDelete {
            width: 100% !important;
            height: 38px !important;
            justify-content: center !important;
            margin-left: 0 !important;
            font-size: 12px !important;
            box-sizing: border-box !important;
        }

        .desktop-table-container {
            display: none !important;
        }

        .mobile-card-list {
            display: flex !important;
            flex-direction: column !important;
            gap: 14px !important;
            padding: 14px 12px !important;
        }

        .detail-grid {
            grid-template-columns: 1fr !important;
        }

        .modal-overlay {
            padding: 12px !important;
        }

        .modal-box {
            width: 100% !important;
            max-width: 100% !important;
            max-height: calc(100vh - 24px) !important;
            padding: 0 !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            box-sizing: border-box !important;
        }

        .modal-header {
            padding: 14px 16px !important;
            flex-shrink: 0 !important;
        }

        .modal-body {
            padding: 16px 14px !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            max-height: calc(85vh - 60px) !important;
            flex: 1 1 auto !important;
        }

        .modal-footer-actions {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .modal-footer-actions button,
        .modal-footer-actions a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }
    }

    @media (min-width: 769px) {
        .desktop-table-container {
            display: block !important;
        }
        .mobile-card-list {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .header-left h1 {
            font-size: 28px !important;
            line-height: 1.25 !important;
        }
        .stats-summary-grid {
            grid-template-columns: 1fr !important;
        }
        .mobile-card-actions {
            grid-template-columns: 1fr 1fr !important;
        }
    }

    @media (max-width: 420px) {
        .header-left h1 {
            font-size: 26px !important;
            line-height: 1.25 !important;
        }
        .filter-actions-group {
            grid-template-columns: 1fr !important;
        }
        .mobile-card-actions {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="surat-izin-container">
    
    <!-- Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Surat Izin &amp; Ketidakhadiran Siswa</h1>
            <p>Input &amp; kelola surat izin (Sakit, Izin, Dispen Luar Sekolah) oleh Guru Piket dengan Auto-Sync Presensi Real-Time</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-error" style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px; border-radius: 12px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-exclamation"></i>
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

    <!-- Top Stat Cards -->
    <div class="stats-summary-grid">
        <div class="stat-card-item dark-blue">
            <div>
                <div class="title">Total Izin Hari Ini</div>
                <div class="number">{{ $totalIzinHariIni }}</div>
            </div>
            <div class="subtitle">Siswa Aktif (Sakit: {{ $sakitHariIni }}, Izin: {{ $izinHariIni }}, Dispen: {{ $dispenHariIni }})</div>
        </div>

        <div class="stat-card-item sky-blue">
            <div>
                <div class="title">Sakit</div>
                <div class="number">{{ $sakitHariIni }}</div>
            </div>
            <div class="subtitle">Surat Dokter / Orang Tua</div>
        </div>

        <div class="stat-card-item amber-bg">
            <div>
                <div class="title">Izin</div>
                <div class="number">{{ $izinHariIni }}</div>
            </div>
            <div class="subtitle">Izin Kepentingan Keluarga</div>
        </div>

        <div class="stat-card-item purple-bg">
            <div>
                <div class="title">Dispen Luar Sekolah</div>
                <div class="number">{{ $dispenHariIni }}</div>
            </div>
            <div class="subtitle">Lomba / Kegiatan Luar</div>
        </div>
    </div>

    <!-- Auto Sync Information Banner -->
    <div class="alert-sync-info">
        <i class="fa-solid fa-bolt"></i>
        <div>
            <h4>Auto-Sync Presensi Real-Time &amp; Integrasi Wali Kelas</h4>
            <p>Setiap surat izin yang di-inputkan oleh Guru Piket di halaman ini akan secara otomatis memperbarui presensi di Jurnal Mengajar (multi-hari) dan langsung masuk ke halaman monitoring <strong>Wali Kelas</strong>.</p>
        </div>
    </div>

    <!-- Form Input Surat Izin Siswa Baru -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2><i class="fa-solid fa-pen-to-square" style="color: #384972; margin-right: 8px;"></i>Form Input Surat Izin / Ketidakhadiran Siswa (Oleh Guru Piket)</h2>
        </div>
        <div class="card-custom-body">
            <form id="suratIzinInputForm" action="{{ route('piket.surat-izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <!-- 1. Pilih Kelas Filter Dropdown (Searchable Select2) -->
                    <div class="form-group" style="min-width: 0;">
                        <label class="form-label-custom">1. Pilih Kelas Siswa <span style="color:#ef4444;">*</span></label>
                        <select id="form_select_kelas" name="id_kelas_form" class="select-custom" style="width: 100%;" required>
                            <option value="">-- Cari / Pilih Kelas Siswa --</option>
                            @foreach($kelases as $kls)
                                @php
                                    $waliNama = $kls->waliKelas->nama_guru ?? '';
                                    $waliNip  = $kls->waliKelas->nip ?? '';
                                @endphp
                                <option value="{{ $kls->id_kelas }}" data-wali-nama="{{ $waliNama }}" data-wali-nip="{{ $waliNip }}" {{ old('id_kelas_form') == $kls->id_kelas ? 'selected' : '' }}>
                                    {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Dynamic Wali Kelas Display Badge -->
                        <div id="form_wali_kelas_badge" class="wali-kelas-badge">
                            <i class="fa-solid fa-user-tie"></i>
                            <span id="form_wali_kelas_text">-- Pilih Kelas Terlebih Dahulu --</span>
                        </div>
                    </div>

                    <!-- 2. Pilih Siswa (Searchable Select2) -->
                    <div class="form-group" style="min-width: 0;">
                        <label class="form-label-custom">2. Pilih Siswa yang Izin <span style="color:#ef4444;">*</span></label>
                        <select name="id_siswa" id="form_select_siswa" class="select-custom" style="width: 100%;" required disabled>
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- 3. Tanggal Mulai Izin -->
                    <div class="form-group">
                        <label class="form-label-custom">3. Tanggal Mulai Izin <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="form_tgl_mulai" class="form-control-custom" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                    </div>

                    <!-- 4. Tanggal Selesai Izin + Auto Durasi -->
                    <div class="form-group">
                        <label class="form-label-custom">
                            4. Tanggal Selesai Izin <span style="color:#ef4444;">*</span>
                            <span id="durasiPillBadge" class="durasi-pill">1 Hari</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="form_tgl_selesai" class="form-control-custom" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                    </div>

                    <!-- 5. Kategori Izin -->
                    <div class="form-group">
                        <label class="form-label-custom">5. Kategori Ketidakhadiran <span style="color:#ef4444;">*</span></label>
                        <select name="kategori" class="select-custom" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin" selected>Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah (Dispensasi dari Luar)</option>
                        </select>
                    </div>

                    <!-- 6. Foto Bukti Surat / Dokumen (WAJIB) -->
                    <div class="form-group">
                        <label class="form-label-custom">6. Foto Bukti Surat / Dokumen (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <input type="file" name="foto_bukti" id="form_foto_bukti" class="form-control-custom" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                        <span style="font-size: 11px; color: #64748b;">Foto bukti fisik surat / surat dokter / tugas dispen wajib diunggah. Maks 5MB.</span>
                    </div>

                    <!-- 7. Keterangan / Alasan (WAJIB) -->
                    <div class="form-group full-width">
                        <label class="form-label-custom">7. Keterangan / Detail Alasan (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <textarea name="keterangan" id="form_keterangan" rows="2" class="textarea-custom" placeholder="Tuliskan keterangan detail surat izin (misal: Sakit demam tinggi dengan surat dokter Puskesmas, atau Lomba Olahraga tingkat kota)..." required></textarea>
                    </div>
                </div>

                <!-- Date Error Warning Message -->
                <div id="dateValidationWarning" class="date-validation-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="dateValidationText">Validasi Gagal: Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin!</span>
                </div>

                <!-- Action Buttons: Reset & Submit -->
                <div class="form-actions-stack" style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                    <button type="button" class="btn-reset-light" onclick="resetFormCustom()" style="padding: 11px 20px; border-radius: 10px; font-size: 13px;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>

                    <button type="submit" id="btnSubmitForm" class="btn-filter-dark" style="padding: 11px 24px; font-size: 13px; border-radius: 10px;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim &amp; Ter-absenkan Otomatis</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table & Filter Bar Container -->
    <div class="card-custom">
        <!-- Table Box Title with Total Count Badge -->
        <div class="card-custom-header">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 12px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <h2><i class="fa-solid fa-table-list" style="color: #384972; margin-right: 8px;"></i>Daftar Data Surat Izin &amp; Ketidakhadiran Siswa</h2>
                        <span style="background: #384972; color: #ffffff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; letter-spacing: 0.3px;">
                            Total Database: {{ $suratIzinList->total() }} Data Surat
                        </span>
                    </div>
                    <span style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px; display: block;">Data urut terbaru di atas &amp; terintegrasi ke Wali Kelas</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar + Relocated Trash Button -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.surat-izin-siswa') }}" method="GET" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; width: 100%;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari nama siswa / keterangan..." style="flex: 1.5 1 200px; min-width: 160px;">

                <select name="id_kelas" class="filter-input" style="flex: 1 1 140px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="kategori" class="filter-input" style="flex: 1 1 140px;">
                    <option value="">Semua Kategori</option>
                    <option value="Sakit" {{ request('kategori') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ request('kategori') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Dispen Luar Sekolah" {{ request('kategori') == 'Dispen Luar Sekolah' ? 'selected' : '' }}>Dispen Luar Sekolah</option>
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" style="flex: 1 1 130px;">

                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    <a href="{{ route('piket.surat-izin-siswa') }}" class="btn-reset-light" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </a>

                    <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" style="background: #ef4444; color: #ffffff; padding: 9px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap;" title="Hapus Data Terpilih">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>

                    <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="btn-trash-pink" title="Lihat Sampah Data Izin Siswa">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Sampah</span>
                        @php
                            $trashedTotal = $trashCount ?? \App\Models\SiswaSuratIzin::onlyTrashed()->count();
                        @endphp
                        @if($trashedTotal > 0)
                            <span style="background: #ffffff; color: #991b1b; font-size: 11px; padding: 1px 6px; border-radius: 10px; font-weight: 800; margin-left: 4px;">{{ $trashedTotal }}</span>
                        @endif
                    </a>
                </div>
            </form>
        </div>

        <!-- DESKTOP TABLE CONTAINER -->
        <div class="desktop-table-container">
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                            </th>
                            <th style="width: 50px;">NO</th>
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th style="width: 130px; text-align: center;">KATEGORI</th>
                            <th style="width: 180px;">TANGGAL &amp; RENTANG</th>
                            <th style="width: 80px; text-align: center;">DURASI</th>
                            <th>KETERANGAN / ALASAN</th>
                            <th style="width: 100px; text-align: center;">BUKTI FOTO</th>
                            <th>PETUGAS PIKET</th>
                            <th style="width: 110px; text-align: center;">STATUS</th>
                            <th style="width: 155px; text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratIzinList as $index => $item)
                            @php
                                $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                                $namaKelas = $item->kelas->nama_kelas ?? '-';
                                $waliKelasObj = $item->kelas->waliKelas ?? ($item->siswa->kelas->waliKelas ?? null);
                                $waliNama = $waliKelasObj->nama_guru ?? null;
                                $waliNip  = $waliKelasObj->nip ?? null;
                                $waliHpRaw = $waliKelasObj->no_hp ?? ($waliKelasObj->user->no_hp ?? null);

                                $rawHp = preg_replace('/[^0-9]/', '', (string)$waliHpRaw);
                                if (str_starts_with($rawHp, '0')) {
                                    $rawHp = '62' . substr($rawHp, 1);
                                } elseif (str_starts_with($rawHp, '8')) {
                                    $rawHp = '62' . $rawHp;
                                }

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
                                    'Terverifikasi' => '#d1fae5',
                                    'Ditolak'       => '#fee2e2',
                                    default         => '#fef3c7',
                                };
                                $statusColor = match($item->status) {
                                    'Terverifikasi' => '#065f46',
                                    'Ditolak'       => '#991b1b',
                                    default         => '#b45309',
                                };
                                $statusBorder = match($item->status) {
                                    'Terverifikasi' => '#a7f3d0',
                                    'Ditolak'       => '#fca5a5',
                                    default         => '#fde68a',
                                };

                                $tglMulaiFmt   = \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y');
                                $tglSelesaiFmt = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                                $rentangFmt    = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                                $durasiText    = ($item->durasi_hari > 0 ? $item->durasi_hari : 1) . ' Hari';

                                $notificationUrl = \App\Services\WhatsAppNotificationService::makeSuratIzinNotificationUrl($item->id_surat_izin);
                                $waService = app(\App\Services\WhatsAppNotificationService::class);
                                $waTextMsg = $waService->buildPesanSuratIzinWaliKelas($item, $notificationUrl);
                                $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . rawurlencode($waTextMsg) : null;

                                $itemDataJson = [
                                    'id_surat_izin'    => $item->id_surat_izin,
                                    'nama_siswa'       => $namaSiswa,
                                    'nis'              => $item->siswa->nis ?? '-',
                                    'nama_kelas'       => $namaKelas,
                                    'wali_nama'        => $waliNama,
                                    'wali_nip'         => $waliNip,
                                    'wali_hp'          => $waliHpRaw,
                                    'notification_url' => $notificationUrl,
                                    'wa_url'           => $waDirectUrl,
                                    'wa_text_msg'      => $waTextMsg,
                                    'tanggal'          => $item->tanggal,
                                    'tanggal_selesai'  => $item->tanggal_selesai ?? $item->tanggal,
                                    'durasi_hari'      => $item->durasi_hari,
                                    'kategori'         => $item->kategori,
                                    'keterangan'       => $item->keterangan,
                                    'foto_url'         => $item->foto_url,
                                    'petugas_nama'     => $petugasNama,
                                    'petugas_nip'      => $petugasNip,
                                    'status'           => $item->status ?? 'Terverifikasi',
                                    'created_at'       => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" class="surat-checkbox" value="{{ $item->id_surat_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                                </td>
                                <td style="font-weight: 700; color: #64748b;">
                                    {{ $suratIzinList->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="student-cell">
                                        <div class="student-avatar">{{ $initials }}</div>
                                        <div class="student-info">
                                            <div class="name">{{ $namaSiswa }}</div>
                                            <div class="sub">NIS: {{ $item->siswa->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #384972;">{{ $namaKelas }}</div>
                                    @if($waliNama)
                                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">Wali: {{ $waliNama }}</div>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge-kategori {{ $katClass }}">
                                        @if($item->kategori == 'Sakit')
                                            <i class="fa-solid fa-notes-medical"></i> Sakit
                                        @elseif($item->kategori == 'Izin')
                                            <i class="fa-solid fa-envelope"></i> Izin
                                        @else
                                            <i class="fa-solid fa-award"></i> Dispen Luar
                                        @endif
                                    </span>
                                </td>
                                <td style="font-weight: 700; font-size: 12.5px;">{{ $rentangFmt }}</td>
                                <td style="text-align: center;">
                                    <span class="durasi-pill">{{ $durasiText }}</span>
                                </td>
                                <td style="color: #475569; font-size: 12.5px;">{{ $item->keterangan ?? '-' }}</td>
                                <td style="text-align: center;">
                                    @if($item->foto_url)
                                        <button type="button" class="btn-action-icon btn-preview" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" title="Lihat Bukti Foto">
                                            <i class="fa-solid fa-image"></i>
                                        </button>
                                    @else
                                        <span style="font-size: 11.5px; color: #94a3b8; font-style: italic;">Tanpa foto</span>
                                    @endif
                                </td>
                                <td style="font-size: 12px; color: #475569;">
                                    <div style="font-weight: 700; color: #0f172a;">{{ $petugasNama }}</div>
                                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">NIP: {{ $petugasNip }}</div>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge" style="background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusBorder }}; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 800;">
                                        {{ $item->status ?? 'Terverifikasi' }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                        <button type="button" class="btn-action-icon btn-whatsapp" onclick="openChatbotWaModal({{ json_encode($itemDataJson) }})" title="Kirim Pemberitahuan ChatBot WhatsApp ke Wali Kelas ({{ $waliNama ?? $namaKelas }})">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon btn-detail" onclick="openDetailModal({{ json_encode($itemDataJson) }})" title="Lihat Detail Surat Izin">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon btn-edit" onclick="openEditModal({{ json_encode($itemDataJson) }})" title="Edit Surat Izin">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('piket.surat-izin-siswa.destroy', $item->id_surat_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan surat izin ini ke sampah?');" style="margin: 0; display: inline-flex;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-delete" title="Hapus ke Sampah">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                                    Belum ada data surat izin siswa yang di-input.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MOBILE CARD LIST (FOR PHONE USERS) -->
        <div class="mobile-card-list">
            @forelse($suratIzinList as $index => $item)
                @php
                    $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                    $namaKelas = $item->kelas->nama_kelas ?? '-';
                    $waliKelasObj = $item->kelas->waliKelas ?? ($item->siswa->kelas->waliKelas ?? null);
                    $waliNama = $waliKelasObj->nama_guru ?? null;
                    $waliNip  = $waliKelasObj->nip ?? null;
                    $waliHpRaw = $waliKelasObj->no_hp ?? ($waliKelasObj->user->no_hp ?? null);

                    $rawHp = preg_replace('/[^0-9]/', '', (string)$waliHpRaw);
                    if (str_starts_with($rawHp, '0')) {
                        $rawHp = '62' . substr($rawHp, 1);
                    } elseif (str_starts_with($rawHp, '8')) {
                        $rawHp = '62' . $rawHp;
                    }

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

                    $tglMulaiFmt   = \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y');
                    $tglSelesaiFmt = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                    $rentangFmt    = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                    $durasiText    = ($item->durasi_hari > 0 ? $item->durasi_hari : 1) . ' Hari';

                    $notificationUrl = \App\Services\WhatsAppNotificationService::makeSuratIzinNotificationUrl($item->id_surat_izin);
                    $waService = app(\App\Services\WhatsAppNotificationService::class);
                    $waTextMsg = $waService->buildPesanSuratIzinWaliKelas($item, $notificationUrl);
                    $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . rawurlencode($waTextMsg) : null;

                    $itemDataJson = [
                        'id_surat_izin'    => $item->id_surat_izin,
                        'nama_siswa'       => $namaSiswa,
                        'nis'              => $item->siswa->nis ?? '-',
                        'nama_kelas'       => $namaKelas,
                        'wali_nama'        => $waliNama,
                        'wali_nip'         => $waliNip,
                        'wali_hp'          => $waliHpRaw,
                        'notification_url' => $notificationUrl,
                        'wa_url'           => $waDirectUrl,
                        'wa_text_msg'      => $waTextMsg,
                        'tanggal'          => $item->tanggal,
                        'tanggal_selesai'  => $item->tanggal_selesai ?? $item->tanggal,
                        'durasi_hari'      => $item->durasi_hari,
                        'kategori'         => $item->kategori,
                        'keterangan'       => $item->keterangan,
                        'foto_url'         => $item->foto_url,
                        'petugas_nama'     => $petugasNama,
                        'petugas_nip'      => $petugasNip,
                        'status'           => $item->status ?? 'Terverifikasi',
                        'created_at'       => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                @endphp
                <div class="mobile-surat-card">
                    <div class="mobile-card-header">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" class="surat-checkbox" value="{{ $item->id_surat_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            <div class="student-avatar" style="width: 32px; height: 32px; font-size: 11.5px;">{{ $initials }}</div>
                            <div>
                                <strong style="font-size: 13px; color: #0f172a;">{{ $namaSiswa }}</strong>
                                <div style="font-size: 11px; color: #64748b;">Kelas: <strong>{{ $namaKelas }}</strong> | NIS: {{ $item->siswa->nis ?? '-' }}</div>
                            </div>
                        </div>
                        <span class="badge-kategori {{ $katClass }}">
                            {{ $item->kategori }}
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 12px; font-weight: 700; color: #1e293b;">
                            <i class="fa-regular fa-calendar" style="color: #2563eb;"></i> {{ $rentangFmt }}
                        </span>
                        <span class="durasi-pill">{{ $durasiText }}</span>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px; font-size: 12px; color: #334155;">
                        <strong>Alasan:</strong> {{ $item->keterangan ?? '-' }}
                        @if($waliNama)
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px; border-top: 1px dashed #e2e8f0; padding-top: 4px;">
                                Wali Kelas: <strong>{{ $waliNama }}</strong>
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 11px; color: #64748b;">
                        <div>
                            Petugas: <strong>{{ $petugasNama }}</strong>
                        </div>
                        @if($item->foto_url)
                            <button type="button" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" style="background: #f3e8ff; color: #7c3aed; border: 1px solid #ddd6fe; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                <i class="fa-solid fa-image"></i> Bukti Foto
                            </button>
                        @endif
                    </div>

                    <div class="mobile-card-actions">
                        <button type="button" class="btn-action-mobile" onclick="openChatbotWaModal({{ json_encode($itemDataJson) }})" style="background: #dcfce7; color: #166534; border-color: #bbf7d0;">
                            <i class="fa-brands fa-whatsapp"></i> WA Wali
                        </button>
                        <button type="button" class="btn-action-mobile" onclick="openDetailModal({{ json_encode($itemDataJson) }})" style="background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;">
                            <i class="fa-solid fa-eye"></i> Detail
                        </button>
                        <button type="button" class="btn-action-mobile" onclick="openEditModal({{ json_encode($itemDataJson) }})" style="background: #fef3c7; color: #b45309; border-color: #fde68a;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form action="{{ route('piket.surat-izin-siswa.destroy', $item->id_surat_izin) }}" method="POST" onsubmit="return confirm('Pindahkan surat izin ini ke sampah?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-mobile" style="width: 100%; background: #fee2e2; color: #dc2626; border-color: #fca5a5;">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 36px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                    Belum ada data surat izin siswa yang di-input.
                </div>
            @endforelse
        </div>

        @if($suratIzinList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                {{ $suratIzinList->withQueryString()->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Detail Surat Izin Siswa -->
<div id="detailModal" class="modal-overlay" onclick="closeDetailModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-address-card" style="color:#2563eb; margin-right: 6px;"></i>Detail Informasi Surat Izin Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeDetailModalDirect()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item" style="grid-column: 1 / -1; display: flex; align-items: center; gap: 14px; background: #f1f5f9;">
                    <div id="det_avatar" class="student-avatar" style="width: 44px; height: 44px; font-size: 15px;">--</div>
                    <div>
                        <div id="det_nama_siswa" style="font-size: 15px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="det_kelas_nis" style="font-size: 12px; color: #64748b; font-weight: 600;">-</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="label">Wali Kelas</div>
                    <div class="val" id="det_wali_kelas">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Kategori Ketidakhadiran</div>
                    <div class="val" id="det_kategori">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Status Verifikasi</div>
                    <div class="val" id="det_status" style="color: #059669;">Terverifikasi</div>
                </div>

                <div class="detail-item">
                    <div class="label">Tanggal Mulai Izin</div>
                    <div class="val" id="det_tgl_mulai">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Tanggal Selesai Izin</div>
                    <div class="val" id="det_tgl_selesai">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1; background: #e0e7ff; border-color: #c7d2fe;">
                    <div class="label" style="color: #3730a3;">Total Durasi Ketidakhadiran</div>
                    <div class="val" id="det_durasi" style="color: #312e81; font-size: 14px;">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1;">
                    <div class="label">Keterangan / Detail Alasan (WAJIB)</div>
                    <div class="val" id="det_keterangan" style="font-weight: 600; color: #334155; line-height: 1.4;">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Petugas Piket Peng-input</div>
                    <div class="val" id="det_petugas">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Waktu Penginputan</div>
                    <div class="val" id="det_waktu_input">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1; text-align: center;">
                    <div class="label" style="margin-bottom: 6px;">Foto Bukti Fisik Surat / Dokumen</div>
                    <div id="det_foto_container">
                        <img id="det_foto_img" src="" alt="Bukti Surat" style="max-width: 100%; max-height: 280px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.12);">
                    </div>
                </div>
            </div>

            <div class="modal-footer-actions" style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; flex-wrap: wrap; gap: 10px;">
                <button type="button" id="det_btn_wa" onclick="openChatbotFromDetail()" class="btn-action-icon btn-whatsapp" style="width: auto; padding: 0 16px; height: 38px; gap: 8px; font-weight: 700; border-radius: 10px; font-size: 12.5px; text-decoration: none; border: none; cursor: pointer;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> Kirim Notifikasi WA ke Wali Kelas
                </button>
                <button type="button" id="det_btn_close" class="btn-filter-dark" onclick="closeDetailModalDirect()" style="padding: 9px 18px; font-size: 12.5px; border-radius: 8px;">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Bukti (Lightbox) -->
<div id="fotoModal" class="modal-overlay" onclick="closeFotoModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 id="modalFotoTitle">Bukti Surat / Dokumen Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeFotoModalDirect()">&times;</button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <img id="modalFotoImg" src="" alt="Bukti Surat Izin Siswa" style="max-width: 100%; max-height: 70vh; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    </div>
</div>

<!-- Modal Edit Data Surat Izin -->
<div id="editModal" class="modal-overlay" onclick="closeEditModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="color: #0284c7; margin-right: 6px;"></i>Edit Data Surat Izin Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeEditModalDirect()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label-custom">Nama Siswa &amp; Kelas</label>
                        <input type="text" id="edit_siswa_nama" class="form-control-custom" readonly style="background: #e2e8f0; font-weight: 700;">
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Wali Kelas</label>
                        <input type="text" id="edit_wali_kelas" class="form-control-custom" readonly style="background: #f1f5f9; color: #475569; font-weight: 600;">
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Tanggal Mulai Izin</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control-custom" onchange="calculateEditDurasi()" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">
                            Tanggal Selesai Izin
                            <span id="editDurasiPill" class="durasi-pill">1 Hari</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="calculateEditDurasi()" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Kategori Ketidakhadiran</label>
                        <select name="kategori" id="edit_kategori" class="select-custom" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Status Verifikasi</label>
                        <select name="status" id="edit_status" class="select-custom" required>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <!-- Pratinjau Foto Bukti Lama -->
                    <div class="form-group">
                        <label class="form-label-custom">Foto Bukti Surat / Dokumen</label>
                        <div id="edit_foto_preview_container" style="margin-bottom: 8px; text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1;">
                            <img id="edit_foto_preview_img" src="" alt="Foto Bukti Lama" style="max-height: 140px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <div id="edit_foto_none_text" style="display:none; font-size: 12px; color: #94a3b8; font-style: italic;">Belum ada foto yang diunggah.</div>
                        </div>
                        <input type="file" name="foto_bukti" class="form-control-custom" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <span style="font-size: 11px; color: #64748b;">Pilih file gambar baru jika ingin mengganti foto bukti fisik yang tersimpan.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Keterangan / Detail Alasan (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <textarea name="keterangan" id="edit_keterangan" rows="3" class="textarea-custom" required></textarea>
                    </div>

                    <div class="modal-footer-actions" style="margin-top: 10px; display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
                        <button type="button" class="btn-reset-light" onclick="closeEditModalDirect()" style="padding: 10px 18px; font-size: 13px; border-radius: 8px;">Batal</button>
                        <button type="submit" class="btn-filter-dark" style="padding: 10px 20px; font-size: 13px; border-radius: 8px;">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Interaktif Kirim ChatBot WhatsApp ke Wali Kelas -->
<div id="chatbotWaModal" class="modal-overlay" onclick="closeChatbotWaModal(event)">
    <div class="modal-box" style="max-width: 580px;" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h3 style="color: #0f172a; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-brands fa-whatsapp" style="color: #22c55e; font-size: 22px;"></i>
                Kirim Pemberitahuan WhatsApp ke Wali Kelas
            </h3>
            <button type="button" class="btn-close-modal" onclick="closeChatbotWaModalDirect()">&times;</button>
        </div>
        <div class="modal-body" style="padding: 20px;">
            <!-- Informasi Target Siswa & Wali Kelas -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px; margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; margin-bottom: 4px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                        <span id="cb_modal_siswa_nama">-</span>
                        <span id="cb_modal_kelas" style="font-size: 11.5px; color: #3b82f6; font-weight: 700; background: #eff6ff; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 12px; margin-left: 6px;">-</span>
                    </div>
                    <div id="cb_modal_wa_badge"></div>
                </div>
                <div style="font-size: 12px; color: #475569; font-weight: 600;">
                    <i class="fa-solid fa-user-tie" style="color: #64748b; margin-right: 4px;"></i> Wali Kelas: <strong id="cb_modal_wali_nama" style="color: #0f172a;">-</strong>
                    <span id="cb_modal_wali_hp_text" style="color: #059669; font-weight: 700; margin-left: 6px;"></span>
                </div>
            </div>

            <!-- Tautan Halaman Pemberitahuan Resmi -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 12px; margin-bottom: 14px;">
                <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 3px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-link" style="color: #16a34a;"></i> Tautan Halaman Pemberitahuan (Link Biru):
                </div>
                <div style="word-break: break-all; font-size: 12px;">
                    <a id="cb_modal_link" href="#" target="_blank" style="color: #15803d; font-weight: 700; text-decoration: underline;">-</a>
                </div>
            </div>

            <!-- Preview Teks Pesan -->
            <label class="form-label-custom" style="margin-bottom: 4px; display: block; font-size: 11.5px;">Pratinjau Isi Pesan WhatsApp:</label>
            <textarea id="cb_modal_text" rows="5" class="textarea-custom" readonly style="font-size: 11.5px; font-family: monospace; background: #f8fafc; resize: vertical; line-height: 1.35; margin-bottom: 14px;"></textarea>

            <!-- Alert response status -->
            <div id="cb_status_alert" style="display: none; padding: 10px; border-radius: 8px; margin-bottom: 14px; font-size: 12px; font-weight: 700;"></div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                <div style="display: flex; gap: 6px; flex-wrap: wrap; width: 100%;">
                    <button type="button" id="btn_submit_chatbot" class="btn" style="background: #16a34a; color: #ffffff; font-weight: 700; padding: 8px 14px; border-radius: 7px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 12px;" onclick="submitSendChatbotWa()">
                        <i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>
                    </button>
                    <a id="cb_modal_manual_link" href="#" target="_blank" class="btn" style="background: #22c55e; color: #ffffff; font-weight: 700; padding: 8px 14px; border-radius: 7px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                        <i class="fa-brands fa-whatsapp"></i> Cadangan Manual WA
                    </a>
                    <button type="button" class="btn" style="background: #0284c7; color: #ffffff; font-weight: 700; padding: 8px 12px; border-radius: 7px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;" onclick="copyChatbotWaText()">
                        <i class="fa-solid fa-copy"></i> Salin
                    </button>
                </div>
                <button type="button" class="btn-reset-light" onclick="closeChatbotWaModalDirect()" style="padding: 8px 16px; font-size: 12px; border-radius: 7px; width: 100%;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Notifikasi Jika Nomor WA Wali Kelas Belum Tersedia -->
<div id="noWaWaliModal" class="modal-overlay" onclick="closeNoWaWaliModal(event)">
    <div class="modal-box" style="max-width: 540px;" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h3 style="color: #0f172a; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-brands fa-whatsapp" style="color: #22c55e; font-size: 20px;"></i>
                Pemberitahuan WhatsApp ke Wali Kelas
            </h3>
            <button type="button" class="btn-close-modal" onclick="closeNoWaWaliModalDirect()">&times;</button>
        </div>
        <div class="modal-body" style="padding: 20px;">
            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; display: flex; align-items: flex-start; gap: 10px;">
                <i class="fa-solid fa-triangle-exclamation" style="color: #d97706; font-size: 18px; margin-top: 2px;"></i>
                <div style="font-size: 12px; color: #92400e; line-height: 1.4;">
                    <strong>Nomor WhatsApp Belum Terdaftar:</strong><br>
                    Wali Kelas untuk kelas <strong id="noWaModalKelas">-</strong> (<span id="noWaModalWali">-</span>) belum memiliki nomor HP/WhatsApp yang terdaftar pada sistem.
                </div>
            </div>

            <label class="form-label-custom" style="margin-bottom: 4px; display: block; font-size: 11.5px;">Teks Pesan Pemberitahuan Surat Izin:</label>
            <textarea id="noWaModalText" rows="6" class="textarea-custom" readonly style="font-size: 11.5px; font-family: monospace; background: #f8fafc; resize: vertical; line-height: 1.35; margin-bottom: 14px;"></textarea>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                <div style="display: flex; gap: 6px; flex-wrap: wrap; width: 100%;">
                    <button type="button" class="btn-filter-dark" onclick="copyWaMessageToClipboard()" style="background: #0284c7; padding: 8px 14px; font-size: 12px; border-radius: 7px;">
                        <i class="fa-solid fa-copy"></i> <span id="btnCopyWaText">Salin Pesan</span>
                    </button>
                    <a id="btnOpenWebWaDirect" href="https://web.whatsapp.com" target="_blank" class="btn-filter-dark" style="background: #22c55e; padding: 8px 14px; font-size: 12px; border-radius: 7px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fa-brands fa-whatsapp"></i> Buka WA Web
                    </a>
                </div>
                <button type="button" class="btn-reset-light" onclick="closeNoWaWaliModalDirect()" style="padding: 8px 16px; font-size: 12px; border-radius: 7px; width: 100%;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Massal Surat Izin -->
<div id="bulkDeleteModal" class="modal-overlay" style="display: none; align-items: center; justify-content: center;">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header" style="background: #ef4444; color: #ffffff;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #ffffff;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" class="btn-close-modal" onclick="closeBulkDeleteModal()" style="color: #ffffff; background: rgba(255,255,255,0.2);">&times;</button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 20px;">
            <div style="width: 52px; height: 52px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; color: #ef4444; font-size: 24px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px; line-height: 1.4;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data surat izin siswa yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                <button type="button" onclick="closeBulkDeleteModal()" class="btn-reset-light" style="height: 36px; padding: 0 18px; font-size: 12.5px; font-weight: 700;">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" style="height: 36px; padding: 0 20px; font-size: 12.5px; font-weight: 800; background: #ef4444; color: #ffffff; border: none; border-radius: 7px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
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
@endsection

@section('scripts')
<!-- Select2 JS & jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const allSiswaMaster = [
        @foreach($siswas as $sis)
        {
            id: "{{ $sis->id_siswa }}",
            nama: "{{ addslashes($sis->nama_siswa) }}",
            nis: "{{ addslashes($sis->nisn ?? $sis->nis ?? '') }}",
            id_kelas: "{{ $sis->id_kelas }}",
            nama_kelas: "{{ addslashes($sis->kelas->nama_kelas ?? 'Kelas') }}"
        },
        @endforeach
    ];

    $(document).ready(function() {
        $('#form_select_kelas').select2({
            placeholder: '-- Cari / Pilih Kelas Siswa --',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            filterSiswaByKelasForm();
        });

        $('#form_select_siswa').select2({
            placeholder: '-- Cari / Pilih Siswa yang Izin --',
            allowClear: true,
            width: '100%'
        });

        calculateDurasiLive();

        const oldSiswaId = "{{ old('id_siswa') }}";
        const oldKelasId = "{{ old('id_kelas_form') }}";
        if (oldKelasId) {
            $('#form_select_kelas').val(oldKelasId).trigger('change');
            if (oldSiswaId) {
                setTimeout(() => {
                    $('#form_select_siswa').val(oldSiswaId).trigger('change');
                }, 150);
            }
        }
    });

    function filterSiswaByKelasForm() {
        const selectKelas = document.getElementById('form_select_kelas');
        const selectedKelasId = $('#form_select_kelas').val();

        const waliBadge = document.getElementById('form_wali_kelas_badge');
        const waliText  = document.getElementById('form_wali_kelas_text');

        if (!selectedKelasId) {
            waliBadge.style.display = 'none';
            waliBadge.className = 'wali-kelas-badge';
            waliText.textContent = '-- Pilih Kelas Terlebih Dahulu --';
        } else {
            const selectedOption = selectKelas.options[selectKelas.selectedIndex];
            const waliNama = selectedOption ? selectedOption.getAttribute('data-wali-nama') : '';
            const waliNip  = selectedOption ? selectedOption.getAttribute('data-wali-nip') : '';

            if (waliNama && waliNama.trim() !== '') {
                const nipStr = (waliNip && waliNip.trim() !== '') ? ` (NIP: ${waliNip})` : '';
                waliText.innerHTML = `Wali Kelas: <strong>${waliNama}</strong>${nipStr}`;
                waliBadge.className = 'wali-kelas-badge';
                waliBadge.style.display = 'inline-flex';
            } else {
                waliText.innerHTML = `Wali Kelas: <em>Belum Ada Wali Kelas Terdaftar</em>`;
                waliBadge.className = 'wali-kelas-badge empty';
                waliBadge.style.display = 'inline-flex';
            }
        }

        const $siswaSelect = $('#form_select_siswa');
        $siswaSelect.empty();

        if (!selectedKelasId) {
            $siswaSelect.append(new Option('-- Pilih Kelas Terlebih Dahulu --', '', true, true));
            $siswaSelect.prop('disabled', true);
            $siswaSelect.trigger('change');
            return;
        }

        const filteredSiswa = allSiswaMaster.filter(s => String(s.id_kelas) === String(selectedKelasId));

        if (filteredSiswa.length === 0) {
            $siswaSelect.append(new Option('-- Tidak Ada Siswa Terdaftar di Kelas Ini --', '', true, true));
            $siswaSelect.prop('disabled', true);
        } else {
            $siswaSelect.prop('disabled', false);
            $siswaSelect.append(new Option('-- Cari / Pilih Siswa yang Izin --', '', true, true));
            filteredSiswa.forEach(s => {
                const label = `${s.nama} (${s.nama_kelas})${s.nis ? ' - NIS: ' + s.nis : ''}`;
                $siswaSelect.append(new Option(label, s.id));
            });
        }

        $siswaSelect.trigger('change');
    }

    function calculateDurasiLive() {
        const tglMulaiInput = document.getElementById('form_tgl_mulai');
        const tglSelesaiInput = document.getElementById('form_tgl_selesai');
        const durasiBadge = document.getElementById('durasiPillBadge');
        const warningBox = document.getElementById('dateValidationWarning');
        const btnSubmit = document.getElementById('btnSubmitForm');

        if (!tglMulaiInput || !tglSelesaiInput) return;

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai < dateMulai) {
            tglSelesaiInput.classList.add('is-invalid');
            if (warningBox) warningBox.style.display = 'flex';
            if (durasiBadge) {
                durasiBadge.textContent = 'Invalid Date';
                durasiBadge.style.background = '#fee2e2';
                durasiBadge.style.color = '#991b1b';
            }
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.5';
                btnSubmit.style.cursor = 'not-allowed';
            }
        } else {
            tglSelesaiInput.classList.remove('is-invalid');
            if (warningBox) warningBox.style.display = 'none';
            if (btnSubmit) {
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
                btnSubmit.style.cursor = 'pointer';
            }

            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (durasiBadge) {
                durasiBadge.textContent = diffDays + ' Hari';
                durasiBadge.style.background = '#e0e7ff';
                durasiBadge.style.color = '#3730a3';
            }
        }
    }

    function calculateEditDurasi() {
        const tglMulaiInput = document.getElementById('edit_tanggal');
        const tglSelesaiInput = document.getElementById('edit_tanggal_selesai');
        const durasiBadge = document.getElementById('editDurasiPill');

        if (!tglMulaiInput || !tglSelesaiInput) return;

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai >= dateMulai) {
            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            if (durasiBadge) durasiBadge.textContent = diffDays + ' Hari';
        } else {
            if (durasiBadge) durasiBadge.textContent = 'Invalid';
        }
    }

    function resetFormCustom() {
        document.getElementById('suratIzinInputForm').reset();
        $('#form_select_kelas').val('').trigger('change');
        filterSiswaByKelasForm();
        calculateDurasiLive();
    }

    let currentDetailItem = null;

    function openDetailModal(item) {
        currentDetailItem = item;
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

        const waliNama = item.wali_nama;
        const waliNip  = item.wali_nip;
        if (waliNama && waliNama.trim() !== '') {
            const nipStr = waliNip ? ` (NIP: ${waliNip})` : '';
            document.getElementById('det_wali_kelas').innerHTML = `<strong>${waliNama}</strong>${nipStr}`;
        } else {
            document.getElementById('det_wali_kelas').innerHTML = `<em style="color:#94a3b8;">Belum Ada Wali Kelas</em>`;
        }

        document.getElementById('det_kategori').textContent = item.kategori;
        
        const statusVal = item.status || 'Terverifikasi';
        const detStatusEl = document.getElementById('det_status');
        detStatusEl.textContent = statusVal;
        if (statusVal === 'Terverifikasi') {
            detStatusEl.style.color = '#059669';
        } else if (statusVal === 'Ditolak') {
            detStatusEl.style.color = '#dc2626';
        } else {
            detStatusEl.style.color = '#d97706';
        }

        const tglMulaiFmt   = formatDateIndo(item.tanggal);
        const tglSelesaiFmt = item.tanggal_selesai ? formatDateIndo(item.tanggal_selesai) : tglMulaiFmt;
        const durasiText    = (item.durasi_hari > 0 ? item.durasi_hari : 1) + ' Hari';

        document.getElementById('det_tgl_mulai').textContent = tglMulaiFmt;
        document.getElementById('det_tgl_selesai').textContent = tglSelesaiFmt;
        document.getElementById('det_durasi').textContent = `${durasiText} (${tglMulaiFmt} ${tglMulaiFmt !== tglSelesaiFmt ? 's/d ' + tglSelesaiFmt : ''})`;

        document.getElementById('det_keterangan').textContent = item.keterangan || '-';

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

        const detBtnWa = document.getElementById('det_btn_wa');
        if (detBtnWa) {
            detBtnWa.onclick = function(e) {
                e.preventDefault();
                openChatbotWaModal(item);
            };
            detBtnWa.title = `Kirim Notifikasi WhatsApp ke Wali Kelas (${item.wali_nama || item.nama_kelas})`;
        }

        document.getElementById('detailModal').classList.add('active');
    }

    function openChatbotFromDetail() {
        if (currentDetailItem) {
            openChatbotWaModal(currentDetailItem);
        }
    }

    function closeDetailModal(e) {
        if (e.target.id === 'detailModal') closeDetailModalDirect();
    }

    function closeDetailModalDirect() {
        document.getElementById('detailModal').classList.remove('active');
    }

    let currentChatbotItem = null;

    function openChatbotWaModal(itemData) {
        currentChatbotItem = itemData;

        document.getElementById('cb_modal_siswa_nama').textContent = itemData.nama_siswa;
        document.getElementById('cb_modal_kelas').textContent = itemData.nama_kelas;
        document.getElementById('cb_modal_wali_nama').textContent = itemData.wali_nama || 'Belum Ada Wali Kelas';
        
        const badgeBox   = document.getElementById('cb_modal_wa_badge');
        const hpText     = document.getElementById('cb_modal_wali_hp_text');
        const btnChatbot = document.getElementById('btn_submit_chatbot');
        const btnManual  = document.getElementById('cb_modal_manual_link');

        if (itemData.wali_hp && itemData.wali_hp.trim() !== '') {
            badgeBox.innerHTML = '<span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 8px; border: 1px solid #86efac;"><i class="fa-solid fa-circle-check"></i> WA Ada</span>';
            hpText.textContent = `(${itemData.wali_hp})`;
            btnChatbot.style.display = 'inline-flex';
            btnChatbot.disabled = false;
        } else {
            badgeBox.innerHTML = '<span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 8px; border: 1px solid #fca5a5;"><i class="fa-solid fa-triangle-exclamation"></i> WA Kosong</span>';
            hpText.textContent = '(Nomor belum ada)';
            btnChatbot.style.display = 'none';
        }

        const linkEl = document.getElementById('cb_modal_link');
        linkEl.href = itemData.notification_url;
        linkEl.textContent = itemData.notification_url;

        document.getElementById('cb_modal_text').value = itemData.wa_text_msg;

        if (itemData.wa_url) {
            btnManual.href = itemData.wa_url;
            btnManual.style.display = 'inline-flex';
        } else {
            btnManual.href = 'https://web.whatsapp.com';
            btnManual.style.display = 'inline-flex';
        }

        const alertBox = document.getElementById('cb_status_alert');
        alertBox.style.display = 'none';

        document.getElementById('chatbotWaModal').classList.add('active');
    }

    function closeChatbotWaModal(event) {
        if (event.target === document.getElementById('chatbotWaModal')) {
            closeChatbotWaModalDirect();
        }
    }

    function closeChatbotWaModalDirect() {
        document.getElementById('chatbotWaModal').classList.remove('active');
    }

    function copyChatbotWaText() {
        const textVal = document.getElementById('cb_modal_text').value;
        navigator.clipboard.writeText(textVal).then(() => {
            alert('Teks pesan pemberitahuan berhasil disalin ke clipboard!');
        }).catch(() => {
            const ta = document.getElementById('cb_modal_text');
            ta.select();
            document.execCommand('copy');
            alert('Teks pesan berhasil disalin!');
        });
    }

    function submitSendChatbotWa() {
        if (!currentChatbotItem || !currentChatbotItem.id_surat_izin) return;

        const btn = document.getElementById('btn_submit_chatbot');
        const alertBox = document.getElementById('cb_status_alert');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengirim...</span>';
        alertBox.style.display = 'none';

        fetch(`/guru-piket/surat-izin-siswa/${currentChatbotItem.id_surat_izin}/send-chatbot`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            return { ok: res.ok, status: res.status, body: data };
        })
        .then(response => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';

            if (response.body && response.body.success) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#dcfce7';
                alertBox.style.color = '#15803d';
                alertBox.style.border = '1px solid #86efac';
                alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (response.body.message || 'Pesan berhasil dikirim via ChatBot!');
            } else {
                alertBox.style.display = 'block';
                alertBox.style.background = '#fee2e2';
                alertBox.style.color = '#991b1b';
                alertBox.style.border = '1px solid #fca5a5';
                alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + (response.body?.message || 'Gagal mengirim pesan via ChatBot.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';

            alertBox.style.display = 'block';
            alertBox.style.background = '#fee2e2';
            alertBox.style.color = '#991b1b';
            alertBox.style.border = '1px solid #fca5a5';
            alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan koneksi saat mengirim permintaan ChatBot.';
        });
    }

    function showNoWaWaliModal(namaSiswa, namaKelas, waliNama, waMessage) {
        document.getElementById('noWaModalKelas').textContent = namaKelas || '-';
        document.getElementById('noWaModalWali').textContent = waliNama || 'Belum Ditentukan';
        document.getElementById('noWaModalText').value = waMessage || '';
        
        const openWaBtn = document.getElementById('btnOpenWebWaDirect');
        if (openWaBtn) {
            openWaBtn.href = "https://api.whatsapp.com/send?text=" + encodeURIComponent(waMessage || '');
        }

        const copyBtnText = document.getElementById('btnCopyWaText');
        if (copyBtnText) copyBtnText.textContent = 'Salin Isi Pesan';

        document.getElementById('noWaWaliModal').classList.add('active');
    }

    function closeNoWaWaliModal(e) {
        if (e.target.id === 'noWaWaliModal') closeNoWaWaliModalDirect();
    }

    function closeNoWaWaliModalDirect() {
        document.getElementById('noWaWaliModal').classList.remove('active');
    }

    function copyWaMessageToClipboard() {
        const textArea = document.getElementById('noWaModalText');
        if (!textArea) return;
        textArea.select();
        textArea.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(textArea.value).then(function() {
            const copyBtnText = document.getElementById('btnCopyWaText');
            if (copyBtnText) {
                copyBtnText.textContent = '✓ Pesan Tersalin!';
                setTimeout(() => { copyBtnText.textContent = 'Salin Isi Pesan'; }, 2500);
            }
        }).catch(function(err) {
            document.execCommand('copy');
        });
    }

    function showFotoModal(imgUrl, title) {
        document.getElementById('modalFotoImg').src = imgUrl;
        document.getElementById('modalFotoTitle').textContent = title;
        document.getElementById('fotoModal').classList.add('active');
    }

    function closeFotoModal(e) {
        if (e.target.id === 'fotoModal') closeFotoModalDirect();
    }

    function closeFotoModalDirect() {
        document.getElementById('fotoModal').classList.remove('active');
    }

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
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu data surat izin yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').style.display = 'flex';
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').style.display = 'none';
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
