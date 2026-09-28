@extends('layouts.guru')

@section('title', 'Permintaan Izin Guru — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Teacher Select (NIP / Nama) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Container Page Fitting Fixes */
    .permintaan-izin-container {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .page-title-box {
        margin-bottom: 20px;
    }

    .page-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-title-box p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        font-weight: 600;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .card-custom-header {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-custom-header h2 {
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-count-pill {
        font-size: 11.5px;
        color: #1d4ed8;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .card-custom-body {
        padding: 20px;
    }

    .form-label-custom {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 4px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 9px 12px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
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

    /* Form Responsive Grids */
    .form-grid-2-1 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-grid-1-1 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-actions-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Select2 Modern Override */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        height: 40px;
        padding: 5px 8px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        line-height: 28px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    .btn-create-link {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-create-link:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-1px);
        color: #ffffff;
    }

    /* ======================================================== */
    /* COMPACT & PRECISE FILTER BAR                             */
    /* ======================================================== */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 7px 11px;
        height: 36px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        font-size: 12px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s ease;
    }

    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .filter-input-search {
        flex: 1.5 1 200px;
        min-width: 160px;
    }

    .filter-input-select {
        flex: 0.8 1 130px;
        min-width: 120px;
    }

    .filter-input-date {
        flex: 0.8 1 130px;
        min-width: 120px;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        height: 36px;
        padding: 0 14px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        height: 36px;
        padding: 0 14px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-bulk-delete-danger {
        background: #ef4444;
        color: #ffffff;
        height: 36px;
        padding: 0 14px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        opacity: 0.5;
        pointer-events: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-bulk-delete-danger.active {
        opacity: 1;
        pointer-events: auto;
    }
    .btn-bulk-delete-danger.active:hover { background: #dc2626; }

    .btn-trash-pink {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        height: 36px;
        padding: 0 14px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        margin-left: auto;
        flex-shrink: 0;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    /* ======================================================== */
    /* COMPACT & PRECISE TABLE STYLING                          */
    /* ======================================================== */
    .table-responsive {
        overflow-x: auto;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .table-custom-compact {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
    }

    .table-custom-compact th {
        background: #f8fafc;
        padding: 10px 10px;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom-compact td {
        padding: 8px 10px;
        font-size: 12px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom-compact tr:hover td {
        background: #f8fafc;
    }

    /* Teacher Cell */
    .cell-guru-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 12.5px;
        line-height: 1.25;
    }

    .cell-guru-nip {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Date & Category */
    .cell-date-text {
        font-weight: 700;
        color: #1e293b;
        font-size: 11.5px;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Status Mini Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge.disetujui, .status-badge.approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-badge.menunggu, .status-badge.pending   { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .status-badge.ditolak, .status-badge.rejected   { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    
    .badge-cuti  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-biasa { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* Final Status Badges */
    .final-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }
    .final-badge.approved { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .final-badge.pending  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .final-badge.rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

    /* ======================================================== */
    /* COMPACT 2-TIER ACTION BUTTONS                            */
    /* ======================================================== */
    .action-compact-container {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 170px;
        width: 170px;
    }

    .action-row-top {
        display: flex;
        gap: 4px;
    }

    .action-row-bottom {
        display: flex;
        gap: 4px;
    }

    .btn-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 3px 6px;
        height: 25px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.15s ease;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
        flex: 1;
        box-sizing: border-box;
    }

    .btn-action-wa { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
    .btn-action-wa:hover { background: #bbf7d0; color: #14532d; }

    .btn-action-copy { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .btn-action-copy:hover { background: #dbeafe; }

    .btn-action-detail { background: #f1f5f9; color: #334155; border-color: #cbd5e1; }
    .btn-action-detail:hover { background: #e2e8f0; color: #0f172a; }

    .btn-action-edit { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .btn-action-edit:hover { background: #fde68a; color: #92400e; }

    .btn-action-delete { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
    .btn-action-delete:hover { background: #fca5a5; color: #991b1b; }

    /* ======================================================== */
    /* MODAL FIX: Z-INDEX OVERRIDE TO OVERCOME STICKY HEADER   */
    /* ======================================================== */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 99999 !important;
        justify-content: center;
        align-items: center;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 580px;
        width: 100%;
        max-height: calc(100vh - 36px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        animation: fadeInModal 0.2s ease;
        margin: auto;
    }

    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        background: #1e293b;
        color: #ffffff;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }

    .modal-header h3 { margin: 0; font-size: 16px; font-weight: 800; }

    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }

    .modal-footer {
        padding: 12px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex-shrink: 0;
    }

    .modal-grid-1-1 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 14px;
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

    .mobile-izin-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
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

    .mobile-approval-steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px;
        text-align: center;
    }

    .mobile-step-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        align-items: center;
    }

    .mobile-step-label {
        font-size: 9.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
    }

    .mobile-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-top: 4px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 8px;
    }

    .mobile-card-actions .btn-action-btn {
        height: 32px;
        font-size: 11.5px;
        border-radius: 7px;
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
    @media (max-width: 768px) {
        .page-title-box h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.5px !important;
            line-height: 1.2 !important;
        }

        .page-title-box p {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        .form-grid-2-1,
        .form-grid-1-1,
        .modal-grid-1-1 {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
            margin-bottom: 12px !important;
        }

        .form-actions-row {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .form-actions-row button,
        .form-actions-row a {
            width: 100% !important;
            justify-content: center !important;
        }

        .card-custom-body {
            padding: 14px !important;
        }

        .filter-bar-container {
            padding: 12px !important;
        }

        .filter-bar-container form {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
        }

        .filter-input,
        .filter-input-search,
        .filter-input-select,
        .filter-input-date {
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
        }

        .btn-filter-dark,
        .btn-reset-light,
        .btn-bulk-delete-danger,
        .btn-trash-pink {
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
        }

        .modal-card {
            width: 95% !important;
            max-height: calc(100vh - 20px) !important;
        }

        .modal-body {
            padding: 14px !important;
        }

        .modal-footer {
            flex-direction: column !important;
            gap: 8px !important;
        }

        .modal-footer button,
        .modal-footer a {
            width: 100% !important;
            justify-content: center !important;
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

    @media (max-width: 420px) {
        .page-title-box h1 {
            font-size: 26px !important;
        }
        .filter-actions-group {
            grid-template-columns: 1fr !important;
        }
        .mobile-approval-steps {
            grid-template-columns: 1fr !important;
            gap: 4px !important;
        }
        .mobile-step-item {
            flex-direction: row !important;
            justify-content: space-between !important;
            width: 100% !important;
            padding: 2px 4px !important;
        }
        .mobile-card-actions {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="permintaan-izin-container">

    <!-- Header Top Bar -->
    <div class="page-title-box">
        <h1>Permintaan Izin Guru</h1>
        <p>Verifikasi dan persetujuan pengajuan izin ketidakhadiran guru harian</p>
    </div>

    @if(session('approval_url'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 800; color: #065f46;">
                        <i class="fa-solid fa-circle-check"></i> Notifikasi Persetujuan Izin Guru Terkirim Otomatis
                    </h4>
                    <p style="margin: 0; font-size: 12.5px; color: #047857;">
                        Sistem otomatis mengirimkan pesan notifikasi persetujuan secara paralel ke <strong>Waka Kurikulum, Waka SDM, dan Kepala Sekolah</strong>.
                    </p>
                    <div style="margin-top: 8px; background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #a7f3d0; font-family: monospace; font-size: 12px; color: #0f172a; word-break: break-all; user-select: all;">
                        {{ session('approval_url') }}
                    </div>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; width: 100%;">
                    @if(session('wa_url'))
                        <a href="{{ session('wa_url') }}" target="_blank" class="btn-create-link" style="background: #25d366; color: #ffffff;" title="Kirim Pesan WhatsApp Cadangan">
                            <i class="fa-brands fa-whatsapp"></i> Cadangan Kirim WA
                        </a>
                    @endif
                    <button type="button" class="btn-action-btn btn-action-copy" onclick="copyToClipboard('{{ session('approval_url') }}')" style="padding: 9px 15px; height: auto;">
                        <i class="fa-regular fa-copy"></i> Salin Link
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-weight: 700;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <!-- Banner Permintaan Izin Guru Mengajar Baru -->
    @if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
        <div style="background: #fffbe6; border: 1.5px solid #ffe58f; border-radius: 14px; padding: 18px 20px; margin-bottom: 20px; box-shadow: 0 4px 16px rgba(250, 173, 20, 0.12);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="background: #faad14; color: #fff; width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                        <i class="fa-solid fa-bell"></i>
                    </span>
                    <div>
                        <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #873800;">
                            Ada <span id="pendingCountText">{{ $pendingRequests->count() }}</span> Permintaan Izin Guru Mengajar Baru yang Belum Diproses!
                        </h3>
                        <p style="margin: 2px 0 0 0; font-size: 12px; color: #d48806; font-weight: 600;">
                            Guru Mengajar mengirimkan data izin melalui web. Klik "Isi Otomatis ke Form & Proses" untuk memprosesnya.
                        </p>
                    </div>
                </div>
                <span style="background: #ffffff; border: 1px solid #ffe58f; color: #d48806; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                    <i class="fa-solid fa-hourglass-start"></i> Menunggu Verifikasi Piket
                </span>
            </div>

            <!-- Filter & Search Bar untuk Notifikasi Permintaan Izin Baru -->
            <div style="background: #ffffff; border: 1px solid #ffd591; border-radius: 10px; padding: 8px 12px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 220px; position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #d48806; font-size: 12px;"></i>
                    <input type="text" id="searchPendingInput" onkeyup="filterPendingRequests()" placeholder="Cari Nama Guru Pengaju, NIP, Alasan, Titipan..." style="width: 100%; padding: 7px 10px 7px 30px; border: 1px solid #ffe58f; border-radius: 7px; font-size: 12px; font-weight: 600; color: #1e293b; outline: none; background: #fffbe6; box-sizing: border-box;">
                </div>
                <button type="button" onclick="resetPendingFilter()" style="padding: 7px 12px; font-size: 11.5px; font-weight: 700; background: #fff1b8; color: #873800; border: 1px solid #ffe58f; border-radius: 7px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Cari
                </button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;" id="pendingRequestsContainer">
                @foreach($pendingRequests as $pReq)
                    <div class="pending-request-card" style="background: #ffffff; border: 1px solid #ffd591; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">
                                <i class="fa-solid fa-user-circle" style="color: #2563eb;"></i> {{ $pReq->guru->nama_guru ?? 'Guru' }} @if($pReq->guru->nip ?? null) <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">(NIP. {{ $pReq->guru->nip }})</span> @endif
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 3px;">
                                <strong>Kategori & Tanggal:</strong> 
                                <span class="badge-biasa" style="padding: 1px 7px; font-size: 10.5px; border-radius: 4px;">{{ ucfirst($pReq->kategori_izin) }}</span>
                                ({{ \Carbon\Carbon::parse($pReq->tanggal_mulai)->format('d-m-Y') }} @if($pReq->tanggal_selesai && $pReq->tanggal_selesai !== $pReq->tanggal_mulai) s/d {{ \Carbon\Carbon::parse($pReq->tanggal_selesai)->format('d-m-Y') }} @endif)
                            </div>
                            <div style="font-size: 12px; color: #334155; margin-top: 3px;">
                                <strong>Alasan:</strong> "{{ $pReq->alasan }}"
                                @if($pReq->materi_dititipkan) | <strong>Titipan:</strong> {{ $pReq->materi_dititipkan }} @endif
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="isiOtomatisForm({{ json_encode($pReq) }})" class="btn-create-link" style="padding: 7px 14px; font-size: 12px; background: #faad14; border-color: #d48806; box-shadow: 0 3px 8px rgba(250, 173, 20, 0.25);">
                                <i class="fa-solid fa-square-check"></i> Isi Otomatis ke Form & Proses
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Form Buat Permintaan Izin -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2><i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> Buat Permintaan Izin / Cuti Guru</h2>
        </div>
        <div class="card-custom-body">
            <form action="{{ route('piket.permintaan-izin.store') }}" method="POST" enctype="multipart/form-data" id="formBuatIzin">
                @csrf
                <input type="hidden" name="id_guru_izin_pengajuan" id="id_guru_izin_pengajuan" value="">

                <div id="infoIsiOtomatis" style="display: none; background: #e0f2fe; border: 1px solid #7dd3fc; color: #0369a1; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 12.5px; font-weight: 700;">
                </div>
                
                <div class="form-grid-2-1">
                    <div>
                        <label class="form-label-custom">Guru yang meminta izin</label>
                        <small style="color: #2563eb; font-weight: 700; display: block; margin-bottom: 4px; font-size: 11px;">
                            <i class="fa-solid fa-circle-info"></i> Fitur Cari: Ketik Nama atau NIP Guru pada kotak pilihan di bawah ini.
                        </small>
                        <select name="id_guru" id="selectGuruSearch" class="form-control-custom" required style="width: 100%;">
                            <option value="">Pilih guru</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">
                                    @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label-custom">Kategori Izin</label>
                        <select name="kategori_izin" id="selectKategoriIzin" class="form-control-custom" onchange="checkDurationCategory()" required>
                            <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                            <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-1-1">
                    <div>
                        <label class="form-label-custom">Tanggal Mulai Izin</label>
                        <input type="date" name="tanggal_mulai" id="inputTglMulai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Tanggal Selesai Izin</label>
                        <input type="date" name="tanggal_selesai" id="inputTglSelesai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()">
                    </div>
                </div>

                <!-- Banner Notifikasi Cuti (> 3 Hari) -->
                <div id="bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; color: #c2410c; font-size: 12.5px; font-weight: 700;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Keterangan Khusus & mengunggah Dokumen Bukti Resmi Cuti!
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Alasan Umum Izin</label>
                    <textarea name="alasan" class="form-control-custom" rows="2" placeholder="Tuliskan alasan umum tidak dapat mengajar..." required></textarea>
                </div>

                <!-- Container Keterangan Khusus Cuti -->
                <div id="keteranganKhususContainer" style="display: none; margin-bottom: 16px; background: #fff7ed; padding: 14px; border-radius: 10px; border: 1px solid #fed7aa;">
                    <label class="form-label-custom" style="color: #c2410c; font-size: 12.5px;">
                        <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti / Izin Khusus (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                    </label>
                    <small style="color: #ea580c; display: block; margin-bottom: 6px; font-size: 11px;">
                        Tuliskan rincian penjelasan mengapa permohonan izin dilakukan lebih dari 3 hari (Cuti).
                    </small>
                    <textarea name="keterangan_khusus" id="inputKeteranganKhusus" class="form-control-custom" rows="2" placeholder="Tuliskan penjelasan khusus permohonan Cuti..."></textarea>
                </div>

                <!-- Opsi Titipan & Lampiran Surat -->
                <div class="form-grid-1-1">
                    <div>
                        <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                        <input type="text" name="materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                    </div>
                    <div>
                        <label class="form-label-custom" id="labelFotoSurat">Upload Foto Surat / Bukti Izin</label>
                        <input type="file" name="foto_surat" id="inputFotoSurat" class="form-control-custom" accept="image/*" required>
                    </div>
                </div>

                <!-- Upload File Tugas -->
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Upload File Tugas (Opsional)</label>
                    <input type="file" name="file_tugas" id="inputFileTugas" class="form-control-custom">
                </div>

                <div class="form-actions-row">
                    <button type="submit" class="btn-create-link">
                        <i class="fa-solid fa-link"></i> Buat Link Persetujuan
                    </button>
                    <button type="button" onclick="resetFormBuatIzin()" class="btn-reset-light" style="padding: 0 16px; height: 38px; font-size: 12.5px; border-radius: 8px; font-weight: 700;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- FITUR: STATUS PERMINTAAN IZIN (COMPACT & PRECISE)        -->
    <!-- ======================================================== -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2>
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i> Status Permintaan Izin
            </h2>
            <span class="badge-count-pill">Total: {{ $guruIzinList->count() }} Pengajuan</span>
        </div>

        <!-- Filter & Search Bar + Reset + Bulk Delete + Sampah -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.permintaan-izin') }}" method="GET">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input filter-input-search" placeholder="Cari Nama Guru, NIP, Alasan...">

                <select name="status" class="filter-input filter-input-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input filter-input-date" title="Filter Tanggal">

                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    <a href="{{ route('piket.permintaan-izin') }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>

                    <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="btn-bulk-delete-danger" title="Hapus Data Terpilih">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>

                    <a href="{{ route('piket.permintaan-izin.trash') }}" class="btn-trash-pink">
                        <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
                    </a>
                </div>
            </form>
        </div>

        <div class="card-custom-body" style="padding: 0;">
            <!-- DESKTOP COMPACT TABLE VIEW -->
            <div class="desktop-table-container">
                <div class="table-responsive">
                    <table class="table-custom-compact">
                        <thead>
                            <tr>
                                <th style="width: 36px; text-align: center;">
                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 15px; height: 15px; cursor: pointer;">
                                </th>
                                <th style="min-width: 140px;">GURU</th>
                                <th style="min-width: 130px;">TANGGAL & KATEGORI</th>
                                <th style="min-width: 160px; max-width: 220px;">ALASAN</th>
                                <th style="text-align: center; min-width: 110px;">STATUS WAKA KURIKULUM</th>
                                <th style="text-align: center; min-width: 95px;">STATUS WAKA SDM</th>
                                <th style="text-align: center; min-width: 95px;">STATUS KEPSEK</th>
                                <th style="text-align: center; min-width: 105px;">STATUS FINAL</th>
                                <th style="text-align: center; min-width: 175px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guruIzinList as $iz)
                            @php
                                $tokenUrl = \App\Services\WhatsAppNotificationService::makeApprovalGuruIzinUrl($iz->token_approval);
                                $isCutiRow = ($iz->kategori_izin === 'cuti') || ($iz->tanggal_mulai && $iz->tanggal_selesai && \Carbon\Carbon::parse($iz->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($iz->tanggal_selesai)) + 1 > 3);

                                $tglMulaiFmt = \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d/m/Y');
                                $tglSelesaiFmt = !empty($iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                                $rentangTanggalFmt = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                                $kategoriTeks = $isCutiRow ? 'Cuti (>3 Hari)' : 'Izin Biasa';
                                $tugasTeks = $iz->tugas_dititipkan ?: ($iz->materi_dititipkan ?: '-');
                                $namaGuruRow = $iz->guru->nama_guru ?? 'Guru Mengajar';
                                $nipGuruRow  = $iz->guru->nip ?? '-';

                                $waService = app(\App\Services\WhatsAppNotificationService::class);
                                $msgGeneral = $waService->buildPesanIzinGuru($iz, 'Waka Kurikulum / Waka SDM / Kepala Sekolah', $tokenUrl);
                                $msgKurikulum = $waService->buildPesanIzinGuru($iz, 'Waka Kurikulum', $tokenUrl);
                                $msgSdm = $waService->buildPesanIzinGuru($iz, 'Waka SDM', $tokenUrl);
                                $msgKepsek = $waService->buildPesanIzinGuru($iz, 'Kepala Sekolah', $tokenUrl);

                                $waModalData = [
                                    'id_guru_izin' => $iz->id_guru_izin,
                                    'nama_guru'    => $namaGuruRow,
                                    'nip'          => $nipGuruRow,
                                    'kategori'     => $kategoriTeks,
                                    'is_cuti'      => $isCutiRow,
                                    'tanggal'      => $rentangTanggalFmt,
                                    'alasan'       => $iz->alasan ?? '-',
                                    'tugas'        => $tugasTeks,
                                    'approval_url' => $tokenUrl,
                                    'messages'     => [
                                        'all'            => $msgGeneral,
                                        'waka_kurikulum' => $msgKurikulum,
                                        'waka_sdm'       => $msgSdm,
                                        'kepala_sekolah' => $msgKepsek,
                                    ],
                                ];

                                $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                                $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                                $detailData = [
                                    'id_guru_izin' => $iz->id_guru_izin,
                                    'nama_guru' => $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                                    'nip' => $iz->guru->nip ?? '-',
                                    'tanggal' => ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y'),
                                    'durasi' => $iz->durasi ?? '1 Hari Full',
                                    'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                                    'is_cuti' => $isCutiRow,
                                    'alasan' => $iz->alasan,
                                    'keterangan_khusus' => $iz->keterangan_khusus ?? '-',
                                    'materi' => $iz->materi_dititipkan ?? '-',
                                    'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                                    'file_tugas_url' => $iz->file_tugas_url,
                                    'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                                    'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                                    'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                                    'catatan_waka' => $iz->catatan_waka ?? '-',
                                    'catatan_kepsek' => $iz->catatan_kepsek ?? '-',
                                    'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                                    'link' => $tokenUrl,
                                ];

                                $editData = [
                                    'id_guru_izin' => $iz->id_guru_izin,
                                    'id_guru' => $iz->id_guru,
                                    'tanggal_mulai' => $iz->tanggal_mulai,
                                    'tanggal_selesai' => $iz->tanggal_selesai,
                                    'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                                    'alasan' => $iz->alasan,
                                    'keterangan_khusus' => $iz->keterangan_khusus,
                                    'materi_dititipkan' => $iz->materi_dititipkan,
                                    'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                                    'file_tugas_url' => $iz->file_tugas_url,
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" class="permintaan-izin-checkbox" value="{{ $iz->id_guru_izin }}" onchange="updateSelectedState()" style="width: 15px; height: 15px; cursor: pointer;">
                                </td>
                                <td>
                                    <div class="cell-guru-title">
                                        {{ $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}
                                    </div>
                                    @if($iz->guru && $iz->guru->nip)
                                        <div class="cell-guru-nip">NIP. {{ $iz->guru->nip }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="cell-date-text">
                                        <i class="fa-regular fa-calendar" style="color: #2563eb; font-size: 11px;"></i>
                                        @if($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y') }}
                                        @endif
                                    </div>
                                    <div style="margin-top: 3px;">
                                        @if($isCutiRow)
                                            <span class="status-badge badge-cuti"><i class="fa-solid fa-ribbon"></i> Cuti (>3 Hari)</span>
                                        @else
                                            <span class="status-badge badge-biasa">Izin Biasa</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="max-width: 220px;">
                                    <div style="color: #334155; font-weight: 500; font-size: 12px; line-height: 1.35;">{{ $iz->alasan }}</div>
                                    @if($isCutiRow && $iz->keterangan_khusus)
                                        <div style="font-size: 10.5px; color: #c2410c; margin-top: 3px; background: #fff7ed; padding: 2px 6px; border-radius: 4px; border: 1px solid #fed7aa; display: inline-block;">
                                            <i class="fa-solid fa-note-sticky"></i> <strong>Ket. Cuti:</strong> {{ \Illuminate\Support\Str::limit($iz->keterangan_khusus, 40) }}
                                        </div>
                                    @endif
                                    @if($iz->status_waka === 'rejected' && $iz->catatan_waka)
                                        <div style="font-size: 10.5px; color: #dc2626; margin-top: 2px;">
                                            <i class="fa-solid fa-circle-exclamation"></i> <strong>Tolak Waka:</strong> {{ \Illuminate\Support\Str::limit($iz->catatan_waka, 35) }}
                                        </div>
                                    @endif
                                    @if($iz->status_kepsek === 'rejected' && $iz->catatan_kepsek)
                                        <div style="font-size: 10.5px; color: #dc2626; margin-top: 2px;">
                                            <i class="fa-solid fa-circle-exclamation"></i> <strong>Tolak Kepsek:</strong> {{ \Illuminate\Support\Str::limit($iz->catatan_kepsek, 35) }}
                                        </div>
                                    @endif
                                </td>
                                <!-- Status Waka Kurikulum -->
                                <td style="text-align: center;">
                                    @if($iz->status_waka === 'approved')
                                        <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    @elseif($iz->status_waka === 'rejected')
                                        <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                    @else
                                        <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                    @endif
                                </td>
                                <!-- Status Waka SDM -->
                                <td style="text-align: center;">
                                    @if($iz->status_waka_sdm === 'approved')
                                        <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    @elseif($iz->status_waka_sdm === 'rejected')
                                        <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                    @else
                                        <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                    @endif
                                </td>
                                <!-- Status Kepsek -->
                                <td style="text-align: center;">
                                    @if($iz->status_kepsek === 'approved')
                                        <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    @elseif($iz->status_kepsek === 'rejected')
                                        <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                    @else
                                        <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                    @endif
                                </td>
                                <!-- Status Final -->
                                <td style="text-align: center;">
                                    @if($isRejectedRow)
                                        <span class="final-badge rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                    @elseif($isApprovedFullRow)
                                        <span class="final-badge approved"><i class="fa-solid fa-circle-check"></i> Disetujui Full</span>
                                    @else
                                        <span class="final-badge pending"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Structured 2-Tier Mini Action Toolbar (Zero Vertical Bloat) -->
                                    <div class="action-compact-container">
                                        <div class="action-row-top">
                                            <button type="button" class="btn-action-btn btn-action-wa" onclick='openChatbotWaModal(@json($waModalData))' title="Kirim Persetujuan via WhatsApp">
                                                <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                            </button>
                                            <button type="button" class="btn-action-btn btn-action-copy" onclick="copyToClipboard('{{ $tokenUrl }}')" title="Salin Link Persetujuan Otomatis">
                                                <i class="fa-regular fa-copy"></i> Salin Link
                                            </button>
                                        </div>
                                        <div class="action-row-bottom">
                                            <button type="button" class="btn-action-btn btn-action-detail" onclick='openDetailModal({{ json_encode($detailData) }})' title="Lihat Rincian Detail">
                                                <i class="fa-regular fa-eye"></i> Detail
                                            </button>
                                            <button type="button" class="btn-action-btn btn-action-edit" onclick='openEditModal({{ json_encode($editData) }})' title="Edit Data Izin">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </button>
                                            <form action="{{ route('piket.permintaan-izin.destroy', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Pindahkan data izin guru ini ke Sampah?');" style="display: inline; flex: 1; margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-btn btn-action-delete" title="Pindahkan ke Sampah" style="width: 100%;">
                                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 36px 16px; color: #94a3b8; font-weight: 600;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                    Belum ada data permintaan izin guru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MOBILE CARD LIST VIEW (FOR SMARTPHONES) -->
            <div class="mobile-card-list">
                @forelse($guruIzinList as $iz)
                @php
                    $tokenUrl = \App\Services\WhatsAppNotificationService::makeApprovalGuruIzinUrl($iz->token_approval);
                    $isCutiRow = ($iz->kategori_izin === 'cuti') || ($iz->tanggal_mulai && $iz->tanggal_selesai && \Carbon\Carbon::parse($iz->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($iz->tanggal_selesai)) + 1 > 3);
                    $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                    $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                    $tglMulaiFmt = \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d/m/Y');
                    $tglSelesaiFmt = !empty($iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                    $rentangTanggalFmt = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                    $kategoriTeks = $isCutiRow ? 'Cuti (>3 Hari)' : 'Izin Biasa';
                    $tugasTeks = $iz->tugas_dititipkan ?: ($iz->materi_dititipkan ?: '-');
                    $namaGuruRow = $iz->guru->nama_guru ?? 'Guru Mengajar';
                    $nipGuruRow  = $iz->guru->nip ?? '-';

                    $waService = app(\App\Services\WhatsAppNotificationService::class);
                    $msgGeneral = $waService->buildPesanIzinGuru($iz, 'Waka Kurikulum / Waka SDM / Kepala Sekolah', $tokenUrl);
                    $msgKurikulum = $waService->buildPesanIzinGuru($iz, 'Waka Kurikulum', $tokenUrl);
                    $msgSdm = $waService->buildPesanIzinGuru($iz, 'Waka SDM', $tokenUrl);
                    $msgKepsek = $waService->buildPesanIzinGuru($iz, 'Kepala Sekolah', $tokenUrl);

                    $waModalData = [
                        'id_guru_izin' => $iz->id_guru_izin,
                        'nama_guru'    => $namaGuruRow,
                        'nip'          => $nipGuruRow,
                        'kategori'     => $kategoriTeks,
                        'is_cuti'      => $isCutiRow,
                        'tanggal'      => $rentangTanggalFmt,
                        'alasan'       => $iz->alasan ?? '-',
                        'tugas'        => $tugasTeks,
                        'approval_url' => $tokenUrl,
                        'messages'     => [
                            'all'            => $msgGeneral,
                            'waka_kurikulum' => $msgKurikulum,
                            'waka_sdm'       => $msgSdm,
                            'kepala_sekolah' => $msgKepsek,
                        ],
                    ];

                    $detailData = [
                        'id_guru_izin' => $iz->id_guru_izin,
                        'nama_guru' => $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                        'nip' => $iz->guru->nip ?? '-',
                        'tanggal' => ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y'),
                        'durasi' => $iz->durasi ?? '1 Hari Full',
                        'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                        'is_cuti' => $isCutiRow,
                        'alasan' => $iz->alasan,
                        'keterangan_khusus' => $iz->keterangan_khusus ?? '-',
                        'materi' => $iz->materi_dititipkan ?? '-',
                        'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                        'file_tugas_url' => $iz->file_tugas_url,
                        'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                        'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                        'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                        'catatan_waka' => $iz->catatan_waka ?? '-',
                        'catatan_kepsek' => $iz->catatan_kepsek ?? '-',
                        'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                        'link' => $tokenUrl,
                    ];

                    $editData = [
                        'id_guru_izin' => $iz->id_guru_izin,
                        'id_guru' => $iz->id_guru,
                        'tanggal_mulai' => $iz->tanggal_mulai,
                        'tanggal_selesai' => $iz->tanggal_selesai,
                        'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                        'alasan' => $iz->alasan,
                        'keterangan_khusus' => $iz->keterangan_khusus,
                        'materi_dititipkan' => $iz->materi_dititipkan,
                        'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                        'file_tugas_url' => $iz->file_tugas_url,
                    ];
                @endphp
                <div class="mobile-izin-card">
                    <div class="mobile-card-header">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" class="permintaan-izin-checkbox" value="{{ $iz->id_guru_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            <div>
                                <strong style="font-size: 13px; color: #0f172a;">{{ $iz->guru->nama_guru ?? 'Guru' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">NIP. {{ $iz->guru->nip ?? '-' }}</div>
                            </div>
                        </div>
                        <div>
                            @if($isRejectedRow)
                                <span class="final-badge rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                            @elseif($isApprovedFullRow)
                                <span class="final-badge approved"><i class="fa-solid fa-circle-check"></i> Disetujui Full</span>
                            @else
                                <span class="final-badge pending"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                            @endif
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 12px; font-weight: 700; color: #1e293b;">
                            <i class="fa-regular fa-calendar" style="color: #2563eb;"></i> {{ $rentangTanggalFmt }}
                        </span>
                        @if($isCutiRow)
                            <span class="status-badge badge-cuti"><i class="fa-solid fa-ribbon"></i> Cuti (>3 Hari)</span>
                        @else
                            <span class="status-badge badge-biasa">Izin Biasa</span>
                        @endif
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px; font-size: 12px; color: #334155;">
                        <strong>Alasan:</strong> {{ $iz->alasan }}
                    </div>

                    <!-- 3 Step Approvals -->
                    <div class="mobile-approval-steps">
                        <div class="mobile-step-item">
                            <span class="mobile-step-label">Waka Kur</span>
                            @if($iz->status_waka === 'approved')
                                <span class="status-badge disetujui" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Ok</span>
                            @elseif($iz->status_waka === 'rejected')
                                <span class="status-badge ditolak" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Tolak</span>
                            @else
                                <span class="status-badge menunggu" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Tunggu</span>
                            @endif
                        </div>
                        <div class="mobile-step-item">
                            <span class="mobile-step-label">Waka SDM</span>
                            @if($iz->status_waka_sdm === 'approved')
                                <span class="status-badge disetujui" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Ok</span>
                            @elseif($iz->status_waka_sdm === 'rejected')
                                <span class="status-badge ditolak" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Tolak</span>
                            @else
                                <span class="status-badge menunggu" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Tunggu</span>
                            @endif
                        </div>
                        <div class="mobile-step-item">
                            <span class="mobile-step-label">Kepsek</span>
                            @if($iz->status_kepsek === 'approved')
                                <span class="status-badge disetujui" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Ok</span>
                            @elseif($iz->status_kepsek === 'rejected')
                                <span class="status-badge ditolak" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Tolak</span>
                            @else
                                <span class="status-badge menunggu" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Tunggu</span>
                            @endif
                        </div>
                    </div>

                    <div class="mobile-card-actions">
                        <button type="button" class="btn-action-btn btn-action-wa" onclick='openChatbotWaModal(@json($waModalData))'>
                            <i class="fa-brands fa-whatsapp"></i> Kirim WA
                        </button>
                        <button type="button" class="btn-action-btn btn-action-copy" onclick="copyToClipboard('{{ $tokenUrl }}')">
                            <i class="fa-regular fa-copy"></i> Salin Link
                        </button>
                        <button type="button" class="btn-action-btn btn-action-detail" onclick='openDetailModal({{ json_encode($detailData) }})'>
                            <i class="fa-regular fa-eye"></i> Detail
                        </button>
                        <button type="button" class="btn-action-btn btn-action-edit" onclick='openEditModal({{ json_encode($editData) }})'>
                            <i class="fa-regular fa-pen-to-square"></i> Edit
                        </button>
                    </div>
                    <form action="{{ route('piket.permintaan-izin.destroy', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Pindahkan data izin guru ini ke Sampah?');" style="margin-top: 2px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-btn btn-action-delete" style="width: 100%; height: 30px;">
                            <i class="fa-regular fa-trash-can"></i> Hapus ke Sampah
                        </button>
                    </form>
                </div>
                @empty
                <div style="text-align: center; padding: 36px 16px; color: #94a3b8; font-weight: 600;">
                    <i class="fa-solid fa-folder-open" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                    Belum ada data permintaan izin guru.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: DETAIL PERMINTAAN IZIN GURU                       -->
<!-- ======================================================== -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-circle-info" style="color: #60a5fa;"></i> Detail Permintaan Izin Guru</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="dt_cuti_badge_container" style="display: none; margin-bottom: 14px; background: #fff7ed; border: 1px solid #fed7aa; padding: 10px 14px; border-radius: 8px; color: #c2410c; font-weight: 800; font-size: 12.5px;">
                <i class="fa-solid fa-ribbon"></i> KATEGORI: CUTI / IZIN KHUSUS (> 3 HARI)
            </div>

            <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase;">NAMA GURU MENGAJAR</div>
                <div id="dt_nama_guru" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;"></div>
                <div id="dt_nip" style="font-size: 11.5px; color: #64748b;"></div>
            </div>

            <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase;">TANGGAL & DURASI IZIN</div>
                <div id="dt_tanggal_durasi" style="font-size: 13.5px; font-weight: 700; color: #334155; margin-top: 2px;"></div>
            </div>

            <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase;">ALASAN UNTUK TIDAK HADIR</div>
                <div id="dt_alasan" style="font-size: 13px; color: #1e293b; margin-top: 4px; background: #f8fafc; padding: 9px 12px; border-radius: 8px; border: 1px solid #e2e8f0;"></div>
            </div>

            <div id="dt_keterangan_khusus_container" style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; display: none;">
                <div style="font-size: 10.5px; font-weight: 800; color: #c2410c; text-transform: uppercase;">KETERANGAN KHUSUS CUTI (> 3 HARI)</div>
                <div id="dt_keterangan_khusus" style="font-size: 13px; color: #9a3412; margin-top: 4px; background: #fff7ed; padding: 9px 12px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;"></div>
            </div>

            <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase;">TITIPAN MATERI / TUGAS SISWA</div>
                <div id="dt_materi" style="font-size: 13px; color: #334155; margin-top: 2px;"></div>
            </div>

            <div id="dt_foto_container" style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; display: none;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">FOTO SURAT KETERANGAN / LAMPIRAN BUKTI</div>
                <div style="margin-bottom: 8px; text-align: center; background: #f8fafc; padding: 8px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <img id="dt_foto_img" src="" alt="Foto Surat Keterangan" style="max-width: 100%; max-height: 200px; border-radius: 6px; object-fit: contain;">
                </div>
                <div>
                    <a id="dt_foto_link" href="" target="_blank" style="color: #2563eb; font-size: 12.5px; font-weight: 700; text-decoration: none;">
                        <i class="fa-solid fa-up-right-from-square"></i> Lihat Lampiran Surat Foto Ukuran Penuh (Full Size)
                    </a>
                </div>
            </div>

            <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 10.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">STATUS PERSETUJUAN BERJENJANG</div>
                <div style="font-size: 12.5px; color: #334155; margin-bottom: 3px;">
                    <strong>Waka Kurikulum:</strong> <span id="dt_status_waka"></span>
                </div>
                <div style="font-size: 12.5px; color: #334155; margin-bottom: 3px;">
                    <strong>Waka SDM:</strong> <span id="dt_status_waka_sdm"></span>
                </div>
                <div style="font-size: 12.5px; color: #334155;">
                    <strong>Kepsek:</strong> <span id="dt_status_kepsek"></span>
                </div>
            </div>

            <div style="background: #f1f5f9; padding: 10px 12px; border-radius: 8px; font-size: 11.5px; word-break: break-all; border: 1px solid #e2e8f0;">
                <strong style="color: #475569;">Link Persetujuan Publik (Teks Informasi):</strong><br>
                <span id="dt_link_display" style="font-family: monospace; color: #1e293b; font-weight: 700; display: inline-block; margin-top: 3px; user-select: all;"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-reset-light" onclick="closeDetailModal()" style="height: 36px; padding: 0 16px; font-size: 12px;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT PERMINTAAN IZIN GURU                         -->
<!-- ======================================================== -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-regular fa-pen-to-square" style="color: #60a5fa;"></i> Edit Permintaan Izin Guru</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; overflow: hidden; flex: 1; margin: 0;">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Guru Mengajar</label>
                    <select name="id_guru" id="edit_id_guru" class="form-control-custom" required style="width: 100%;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="edit_kategori_izin" class="form-control-custom" onchange="checkEditDurationCategory()">
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>

                <div class="modal-grid-1-1">
                    <div>
                        <label class="form-label-custom">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="checkEditDurationCategory()">
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Alasan Izin</label>
                    <textarea name="alasan" id="edit_alasan" class="form-control-custom" rows="2" required></textarea>
                </div>

                <div id="editKeteranganKhususContainer" style="display: none; margin-bottom: 14px; background: #fff7ed; padding: 12px; border-radius: 8px; border: 1px solid #fed7aa;">
                    <label class="form-label-custom" style="color: #c2410c;">
                        <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                    </label>
                    <textarea name="keterangan_khusus" id="edit_keterangan_khusus" class="form-control-custom" rows="2" placeholder="Tuliskan keterangan khusus Cuti..."></textarea>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" id="edit_materi_dititipkan" class="form-control-custom">
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom" id="editLabelFotoSurat">Upload Foto Surat / Bukti Izin Baru</label>
                    <input type="file" name="foto_surat" id="edit_foto_surat" class="form-control-custom" accept="image/*">
                    
                    <!-- Pratinjau Foto Bukti Terlampir -->
                    <div id="edit_piket_foto_preview_container" style="display: none; margin-top: 8px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px 12px;">
                        <small style="font-size: 11px; font-weight: 800; color: #1e40af; text-transform: uppercase; display: block; margin-bottom: 4px;">
                            <i class="fa-solid fa-image"></i> Foto Surat / Bukti Terlampir Saat Ini:
                        </small>
                        <a id="edit_piket_foto_link" href="#" target="_blank">
                            <img id="edit_piket_foto_img" src="" alt="Pratinjau Foto" style="max-height: 110px; border-radius: 6px; border: 1px solid #93c5fd; object-fit: contain; display: block;">
                        </a>
                    </div>
                </div>

                <!-- Upload File Tugas Baru -->
                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Upload File Tugas Baru (Opsional)</label>
                    <input type="file" name="file_tugas" id="edit_piket_file_tugas" class="form-control-custom">

                    <div id="edit_piket_file_preview_container" style="display: none; margin-top: 6px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 7px; padding: 6px 10px;">
                        <small style="font-size: 11.5px; color: #1e293b; font-weight: 700;">
                            <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Saat Ini: <a id="edit_piket_file_link" href="#" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-reset-light" onclick="closeEditModal()" style="height: 36px; padding: 0 16px; font-size: 12px;">
                    Batal
                </button>
                <button type="submit" class="btn-create-link" style="padding: 0 16px; height: 36px; font-size: 12.5px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: CHATBOT WA UNTUK PERSETUJUAN IZIN GURU            -->
<!-- ======================================================== -->
<div id="chatbotWaModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 580px;">
        <div class="modal-header">
            <h3 style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-brands fa-whatsapp" style="color: #22c55e; font-size: 18px;"></i>
                <span>Kirim Persetujuan Izin Guru via WhatsApp</span>
            </h3>
            <button type="button" onclick="closeChatbotWaModalDirect()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <!-- Informasi Guru & Izin -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; margin-bottom: 4px;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                        <span id="cb_modal_guru_nama">-</span>
                        <span id="cb_modal_kategori_badge" style="font-size: 11px; margin-left: 6px;">-</span>
                    </div>
                    <div id="cb_modal_wa_badge"></div>
                </div>
                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                    <i class="fa-solid fa-id-card"></i> NIP: <span id="cb_modal_nip" style="color: #334155;">-</span>
                    <span style="margin: 0 6px; color: #cbd5e1;">|</span>
                    <i class="fa-regular fa-calendar-days"></i> Tanggal: <strong id="cb_modal_tanggal" style="color: #1e293b;">-</strong>
                </div>
                <div style="font-size: 11.5px; color: #475569; margin-top: 3px;">
                    <strong>Alasan:</strong> <span id="cb_modal_alasan">-</span>
                </div>
            </div>

            <!-- Pilihan Target Pejabat Sekolah -->
            <div style="margin-bottom: 14px;">
                <label class="form-label-custom" style="margin-bottom: 4px; display: block; font-size: 11.5px;">
                    <i class="fa-solid fa-user-check" style="color: #2563eb;"></i> Target Penerima Persetujuan (Pejabat Sekolah):
                </label>
                <select id="cb_modal_target_select" class="form-control-custom" onchange="onTargetPejabatChanged()" style="width: 100%; font-size: 12px; font-weight: 600; padding: 7px 10px; border-radius: 7px;">
                    <option value="all">Semua Pejabat (Waka Kurikulum, Waka SDM, Kepala Sekolah)</option>
                    @if(isset($pejabatSekolah['waka_kurikulum']))
                        <option value="waka_kurikulum">Waka Kurikulum ({{ $pejabatSekolah['waka_kurikulum']['nama'] }} - {{ $pejabatSekolah['waka_kurikulum']['no_hp'] ?: 'Belum Ada HP' }})</option>
                    @endif
                    @if(isset($pejabatSekolah['waka_sdm']))
                        <option value="waka_sdm">Waka SDM ({{ $pejabatSekolah['waka_sdm']['nama'] }} - {{ $pejabatSekolah['waka_sdm']['no_hp'] ?: 'Belum Ada HP' }})</option>
                    @endif
                    @if(isset($pejabatSekolah['kepala_sekolah']))
                        <option value="kepala_sekolah">Kepala Sekolah ({{ $pejabatSekolah['kepala_sekolah']['nama'] }} - {{ $pejabatSekolah['kepala_sekolah']['no_hp'] ?: 'Belum Ada HP' }})</option>
                    @endif
                </select>
                <div id="cb_modal_target_info" style="font-size: 11px; color: #64748b; margin-top: 3px; font-weight: 600;">
                    Nomor WhatsApp aktif dari sistem akan digunakan otomatis oleh ChatBot.
                </div>
            </div>

            <!-- Tautan Halaman Persetujuan -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 12px; margin-bottom: 14px;">
                <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 3px; display: align-items: center; gap: 5px;">
                    <i class="fa-solid fa-link" style="color: #16a34a;"></i> Tautan Persetujuan Izin Guru (Link Biru):
                </div>
                <div style="word-break: break-all; font-size: 12px;">
                    <a id="cb_modal_link" href="#" target="_blank" style="color: #15803d; font-weight: 700; text-decoration: underline;">-</a>
                </div>
            </div>

            <!-- Pratinjau Isi Pesan WhatsApp -->
            <label class="form-label-custom" style="margin-bottom: 4px; display: block; font-size: 11.5px;">Pratinjau Isi Pesan WhatsApp:</label>
            <textarea id="cb_modal_text" rows="6" readonly class="textarea-custom" style="font-size: 11.5px; font-family: monospace; background: #f8fafc; resize: vertical; line-height: 1.35; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 7px; padding: 8px; margin-bottom: 12px;"></textarea>

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
                <button type="button" class="btn-reset-light" onclick="closeChatbotWaModalDirect()" style="height: 36px; padding: 0 16px; font-size: 12px; border-radius: 7px; font-weight: 700; width: 100%;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: KONFIRMASI HAPUS MASSAL                           -->
<!-- ======================================================== -->
<div id="bulkDeleteModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 440px;">
        <div class="modal-header" style="background: #ef4444;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" onclick="closeBulkDeleteModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 20px;">
            <div style="width: 52px; height: 52px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; color: #ef4444; font-size: 24px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px; line-height: 1.4;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data permintaan izin guru yang dipilih ke fitur Sampah?
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

<!-- Form Hidden untuk Hapus Massal Permintaan Izin Guru -->
<form id="bulkDeleteForm" action="{{ route('piket.permintaan-izin.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Select2 & Helper Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#selectGuruSearch').select2({
        placeholder: "Cari NIP atau Nama Guru...",
        allowClear: true
    });
});

/**
 * Cek Durasi & Kategori Izin (Biasa vs Cuti > 3 Hari) untuk Form Buat Izin
 */
function checkDurationCategory() {
    const tglMulai = document.getElementById('inputTglMulai').value;
    let tglSelesai = document.getElementById('inputTglSelesai').value;
    const kategori = document.getElementById('selectKategoriIzin').value;

    if (tglMulai && tglSelesai && tglSelesai < tglMulai) {
        alert('Peringatan: Tanggal Selesai Izin (' + tglSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tglMulai + ')!');
        document.getElementById('inputTglSelesai').value = tglMulai;
        tglSelesai = tglMulai;
    }

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const container = document.getElementById('keteranganKhususContainer');
    const inputKet = document.getElementById('inputKeteranganKhusus');
    const banner = document.getElementById('bannerCutiWarning');
    const labelFoto = document.getElementById('labelFotoSurat');
    const inputFoto = document.getElementById('inputFotoSurat');

    const hasAutoFillPhoto = document.getElementById('previewFotoAutoFill') && document.getElementById('previewFotoAutoFill').style.display !== 'none';

    if (isCuti) {
        document.getElementById('selectKategoriIzin').value = 'cuti';
        container.style.display = 'block';
        banner.style.display = 'block';
        inputKet.setAttribute('required', 'required');

        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti <span style="color: #10b981; font-weight: 700;">(Foto Guru Mengajar Terlampir)</span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti';
        }
    } else {
        container.style.display = 'none';
        banner.style.display = 'none';
        inputKet.removeAttribute('required');
        
        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin <span style="color: #10b981; font-weight: 700;">(Foto Guru Mengajar Terlampir)</span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin';
        }
    }
}

/**
 * Cek Durasi & Kategori Izin untuk Form Edit
 */
function checkEditDurationCategory() {
    const tglMulai = document.getElementById('edit_tanggal_mulai').value;
    let tglSelesai = document.getElementById('edit_tanggal_selesai').value || tglMulai;
    const kategori = document.getElementById('edit_kategori_izin').value;

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const container = document.getElementById('editKeteranganKhususContainer');
    const inputKet = document.getElementById('edit_keterangan_khusus');
    const labelFoto = document.getElementById('editLabelFotoSurat');
    const inputFoto = document.getElementById('edit_foto_surat');
    const hasFotoPreview = document.getElementById('edit_piket_foto_preview_container') && document.getElementById('edit_piket_foto_preview_container').style.display !== 'none';

    if (hasFotoPreview) {
        if (inputFoto) inputFoto.removeAttribute('required');
    } else {
        if (inputFoto) inputFoto.setAttribute('required', 'required');
    }

    if (isCuti) {
        document.getElementById('edit_kategori_izin').value = 'cuti';
        container.style.display = 'block';
        inputKet.setAttribute('required', 'required');
        if (labelFoto) {
            labelFoto.innerHTML = hasFotoPreview 
                ? 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                : 'Upload Foto Surat / Dokumen Bukti Cuti Baru';
        }
    } else {
        container.style.display = 'none';
        inputKet.removeAttribute('required');
        if (labelFoto) {
            labelFoto.innerHTML = hasFotoPreview 
                ? 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                : 'Upload Foto Surat / Bukti Izin Baru';
        }
    }
}

/**
 * Robust Fallback Copy to Clipboard
 */
function copyToClipboard(text) {
    let tempTextArea = document.createElement("textarea");
    tempTextArea.value = text;
    tempTextArea.style.position = "fixed";
    tempTextArea.style.left = "-9999px";
    tempTextArea.style.top = "-9999px";
    document.body.appendChild(tempTextArea);
    tempTextArea.focus();
    tempTextArea.select();
    tempTextArea.setSelectionRange(0, 99999);

    try {
        let successful = document.execCommand('copy');
        if (successful) {
            alert('Link approval persetujuan berhasil disalin ke clipboard!');
        } else {
            prompt('Salin link persetujuan berikut secara manual:', text);
        }
    } catch (err) {
        prompt('Salin link persetujuan berikut secara manual:', text);
    }

    document.body.removeChild(tempTextArea);
}

/**
 * Tampilkan Modal Detail
 */
function openDetailModal(data) {
    document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
    document.getElementById('dt_nip').innerText = 'NIP. ' + (data.nip || '-');
    document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari Full') + ')';
    document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
    document.getElementById('dt_materi').innerText = data.materi || '-';
    document.getElementById('dt_status_waka').innerText = (data.status_waka || 'Pending') + ' (Catatan: ' + (data.catatan_waka || '-') + ')';
    document.getElementById('dt_status_waka_sdm').innerText = (data.status_waka_sdm || 'Pending');
    document.getElementById('dt_status_kepsek').innerText = (data.status_kepsek || 'Pending') + ' (Catatan: ' + (data.catatan_kepsek || '-') + ')';
    document.getElementById('dt_link_display').innerText = data.link || '-';

    const cutiBadge = document.getElementById('dt_cuti_badge_container');
    const ketKhususContainer = document.getElementById('dt_keterangan_khusus_container');

    if (data.is_cuti || data.kategori_izin === 'cuti') {
        cutiBadge.style.display = 'block';
        if (data.keterangan_khusus && data.keterangan_khusus !== '-') {
            document.getElementById('dt_keterangan_khusus').innerText = data.keterangan_khusus;
            ketKhususContainer.style.display = 'block';
        } else {
            ketKhususContainer.style.display = 'none';
        }
    } else {
        cutiBadge.style.display = 'none';
        ketKhususContainer.style.display = 'none';
    }

    let fotoContainer = document.getElementById('dt_foto_container');
    if (data.foto_url) {
        document.getElementById('dt_foto_img').src = data.foto_url;
        document.getElementById('dt_foto_link').href = data.foto_url;
        fotoContainer.style.display = 'block';
    } else {
        fotoContainer.style.display = 'none';
    }

    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

/**
 * Tampilkan Modal Edit Data Izin
 */
function openEditModal(data) {
    document.getElementById('editForm').action = "{{ url('/guru-piket/permintaan-izin') }}/" + data.id_guru_izin;
    document.getElementById('edit_id_guru').value = data.id_guru;
    
    if (window.jQuery && $.fn.select2) {
        $('#edit_id_guru').trigger('change');
    }

    document.getElementById('edit_kategori_izin').value = data.kategori_izin || 'biasa';
    document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
    document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || data.tanggal_mulai;
    document.getElementById('edit_alasan').value = data.alasan;
    document.getElementById('edit_keterangan_khusus').value = data.keterangan_khusus || '';
    document.getElementById('edit_materi_dititipkan').value = data.materi_dititipkan || '';

    const fotoPreviewContainer = document.getElementById('edit_piket_foto_preview_container');
    const editFotoInput = document.getElementById('edit_foto_surat');
    const editLabelFoto = document.getElementById('editLabelFotoSurat');

    if (data.foto_url) {
        document.getElementById('edit_piket_foto_img').src = data.foto_url;
        document.getElementById('edit_piket_foto_link').href = data.foto_url;
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'block';
        if (editFotoInput) editFotoInput.removeAttribute('required');
        if (editLabelFoto) editLabelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>';
    } else {
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'none';
        if (editFotoInput) editFotoInput.setAttribute('required', 'required');
        if (editLabelFoto) editLabelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin Baru';
    }

    checkEditDurationCategory();
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

/**
 * Isi Otomatis Form Buat Permintaan Izin dari Data Pengajuan Guru Mengajar
 */
function isiOtomatisForm(pReq) {
    document.getElementById('id_guru_izin_pengajuan').value = pReq.id_guru_izin;
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val(pReq.id_guru).trigger('change');
    } else {
        document.getElementById('selectGuruSearch').value = pReq.id_guru;
    }
    
    document.getElementById('inputTglMulai').value = pReq.tanggal_mulai;
    document.getElementById('inputTglSelesai').value = pReq.tanggal_selesai || pReq.tanggal_mulai;
    
    document.getElementById('selectKategoriIzin').value = pReq.kategori_izin || 'biasa';

    if (document.getElementsByName('alasan')[0]) {
        document.getElementsByName('alasan')[0].value = pReq.alasan || '';
    }
    if (document.getElementById('inputKeteranganKhusus') && pReq.keterangan_khusus) {
        document.getElementById('inputKeteranganKhusus').value = pReq.keterangan_khusus;
    }
    if (document.getElementsByName('materi_dititipkan')[0]) {
        document.getElementsByName('materi_dititipkan')[0].value = pReq.materi_dititipkan || '';
    }

    // Auto Fill Foto
    const inputFoto = document.getElementById('inputFotoSurat');
    let previewBox = document.getElementById('previewFotoAutoFill');
    if (pReq.foto_surat) {
        const fotoUrl = "{{ asset('uploads/guru_izin') }}/" + pReq.foto_surat;
        if (!previewBox) {
            previewBox = document.createElement('div');
            previewBox.id = 'previewFotoAutoFill';
            previewBox.style.cssText = 'margin-top: 8px; background: #eff6ff; border: 1.5px solid #93c5fd; border-radius: 10px; padding: 10px 14px;';
            inputFoto.parentNode.appendChild(previewBox);
        }
        previewBox.style.display = 'block';
        previewBox.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #1e40af; text-transform: uppercase;">
                    <i class="fa-solid fa-image"></i> Foto Bukti dari Guru Mengajar Terlampir:
                </span>
                <a href="${fotoUrl}" target="_blank" style="font-size: 11.5px; font-weight: 700; color: #2563eb; text-decoration: underline;">
                    Lihat Ukuran Penuh
                </a>
            </div>
            <a href="${fotoUrl}" target="_blank">
                <img src="${fotoUrl}" alt="Foto Bukti Guru Mengajar" style="max-height: 140px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: contain; display: block; background: #ffffff; padding: 4px;">
            </a>
            <small style="color: #0369a1; font-weight: 600; display: block; margin-top: 5px; font-size: 11px;">
                <i class="fa-solid fa-circle-check"></i> Foto terisi otomatis dari pengajuan Guru Mengajar (${pReq.guru ? pReq.guru.nama_guru : 'Guru'}). Anda tidak perlu mengunggah ulang foto.
            </small>
        `;
        if (inputFoto) inputFoto.removeAttribute('required');
    } else {
        if (previewBox) {
            previewBox.style.display = 'none';
            previewBox.innerHTML = '';
        }
    }

    // Auto Fill File Tugas
    const inputFileTugas = document.getElementById('inputFileTugas');
    let filePreviewBox = document.getElementById('previewFileTugasAutoFill');
    if (pReq.file_tugas || pReq.file_tugas_url) {
        const fileUrl = pReq.file_tugas_url || ("{{ asset('uploads/tugas_pengganti') }}/" + pReq.file_tugas);
        if (inputFileTugas) {
            if (!filePreviewBox) {
                filePreviewBox = document.createElement('div');
                filePreviewBox.id = 'previewFileTugasAutoFill';
                filePreviewBox.style.cssText = 'margin-top: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px;';
                inputFileTugas.parentNode.appendChild(filePreviewBox);
            }
            filePreviewBox.style.display = 'block';
            filePreviewBox.innerHTML = `
                <small style="font-size: 12px; color: #1e293b; font-weight: 700;">
                    <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Terlampir dari Guru Mengajar: <a href="${fileUrl}" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                </small>
            `;
        }
    } else {
        if (filePreviewBox) {
            filePreviewBox.style.display = 'none';
            filePreviewBox.innerHTML = '';
        }
    }

    checkDurationCategory();

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'block';
        infoBox.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Data pengajuan dari Guru Mengajar (' + (pReq.guru ? pReq.guru.nama_guru : 'Guru') + ') telah diisikan secara otomatis ke form. Silakan periksa kembali dan klik "Buat Link Persetujuan" untuk memvalidasi dan mengirimkan link ke Waka & Kepsek.';
    }

    document.getElementById('formBuatIzin').scrollIntoView({ behavior: 'smooth' });
}

/**
 * Filter pencarian real-time untuk banner notifikasi pengajuan baru
 */
function filterPendingRequests() {
    const input = document.getElementById('searchPendingInput');
    if (!input) return;
    const query = input.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.pending-request-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countSpan = document.getElementById('pendingCountText');
    if (countSpan) {
        countSpan.innerText = visibleCount;
    }
}

function resetPendingFilter() {
    const input = document.getElementById('searchPendingInput');
    if (input) {
        input.value = '';
        filterPendingRequests();
    }
}

/**
 * Reset seluruh isian form Buat Permintaan Izin / Cuti Guru
 */
function resetFormBuatIzin() {
    const form = document.getElementById('formBuatIzin');
    if (form) {
        form.reset();
    }
    
    document.getElementById('id_guru_izin_pengajuan').value = '';
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val('').trigger('change');
    } else if (document.getElementById('selectGuruSearch')) {
        document.getElementById('selectGuruSearch').value = '';
    }

    const todayStr = "{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}";
    document.getElementById('inputTglMulai').value = todayStr;
    document.getElementById('inputTglSelesai').value = todayStr;
    document.getElementById('selectKategoriIzin').value = 'biasa';

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'none';
        infoBox.innerHTML = '';
    }

    const previewBox = document.getElementById('previewFotoAutoFill');
    if (previewBox) {
        previewBox.style.display = 'none';
        previewBox.innerHTML = '';
    }

    const filePreviewBox = document.getElementById('previewFileTugasAutoFill');
    if (filePreviewBox) {
        filePreviewBox.style.display = 'none';
        filePreviewBox.innerHTML = '';
    }

    checkDurationCategory();
}

// Fitur Checkbox & Hapus Massal Permintaan Izin Guru
function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateSelectedState();
}

function updateSelectedState() {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
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
            btnBulk.classList.add('active');
        } else {
            btnBulk.classList.remove('active');
        }
    }
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan pilih minimal satu data permintaan izin yang mau dihapus.');
        return;
    }

    document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

function executeBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
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

/**
 * Logika Modal Interaktif ChatBot WhatsApp untuk Permintaan Izin Guru
 */
let currentChatbotData = null;
const pejabatSekolahData = @json($pejabatSekolah ?? []);

function openChatbotWaModal(data) {
    currentChatbotData = data;
    document.getElementById('cb_modal_guru_nama').textContent = data.nama_guru || 'Guru';
    document.getElementById('cb_modal_nip').textContent = data.nip || '-';
    document.getElementById('cb_modal_tanggal').textContent = data.tanggal || '-';
    document.getElementById('cb_modal_alasan').textContent = data.alasan || '-';

    const katBadge = document.getElementById('cb_modal_kategori_badge');
    if (data.is_cuti) {
        katBadge.className = 'status-badge badge-cuti';
        katBadge.innerHTML = '<i class="fa-solid fa-ribbon"></i> Cuti (>3 Hari)';
    } else {
        katBadge.className = 'status-badge badge-biasa';
        katBadge.textContent = 'Izin Biasa';
    }

    const linkEl = document.getElementById('cb_modal_link');
    linkEl.href = data.approval_url;
    linkEl.textContent = data.approval_url;

    const targetSelect = document.getElementById('cb_modal_target_select');
    if (targetSelect) {
        targetSelect.value = 'all';
    }
    onTargetPejabatChanged();

    const alertBox = document.getElementById('cb_status_alert');
    alertBox.style.display = 'none';

    document.getElementById('chatbotWaModal').style.display = 'flex';
}

function closeChatbotWaModalDirect() {
    document.getElementById('chatbotWaModal').style.display = 'none';
}

function onTargetPejabatChanged() {
    if (!currentChatbotData) return;

    const target = document.getElementById('cb_modal_target_select').value;
    const msg = (currentChatbotData.messages && currentChatbotData.messages[target]) ? currentChatbotData.messages[target] : (currentChatbotData.messages ? currentChatbotData.messages['all'] : '');
    document.getElementById('cb_modal_text').value = msg;

    const manualLinkBtn = document.getElementById('cb_modal_manual_link');
    const badgeBox = document.getElementById('cb_modal_wa_badge');
    const infoBox = document.getElementById('cb_modal_target_info');

    if (target === 'all') {
        badgeBox.innerHTML = '<span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px; border: 1px solid #86efac;"><i class="fa-solid fa-users"></i> 3 Pejabat</span>';
        infoBox.innerHTML = 'ChatBot WhatsApp akan mengirimkan pesan persetujuan secara paralel ke <strong>Waka Kurikulum, Waka SDM, dan Kepala Sekolah</strong>.';
        manualLinkBtn.href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(msg);
    } else {
        const pj = pejabatSekolahData[target];
        if (pj && pj.no_hp) {
            badgeBox.innerHTML = '<span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px; border: 1px solid #86efac;"><i class="fa-solid fa-circle-check"></i> WA: ' + pj.no_hp + '</span>';
            infoBox.innerHTML = 'Kirim ke <strong>' + pj.jabatan + ' (' + pj.nama + ')</strong> via nomor WhatsApp: <strong>' + pj.no_hp + '</strong>';
            
            let cleanPhone = pj.no_hp.replace(/[^0-9]/g, '');
            if (cleanPhone.startsWith('0')) {
                cleanPhone = '62' + cleanPhone.slice(1);
            }
            manualLinkBtn.href = 'https://api.whatsapp.com/send?phone=' + cleanPhone + '&text=' + encodeURIComponent(msg);
        } else {
            badgeBox.innerHTML = '<span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px; border: 1px solid #fca5a5;"><i class="fa-solid fa-triangle-exclamation"></i> Nomor Belum Terdaftar</span>';
            infoBox.innerHTML = '<span style="color: #dc2626;">Nomor WhatsApp pejabat belum terdaftar pada profil pengguna sistem.</span>';
            manualLinkBtn.href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(msg);
        }
    }
}

function copyChatbotWaText() {
    const textVal = document.getElementById('cb_modal_text').value;
    navigator.clipboard.writeText(textVal).then(() => {
        alert('Teks pesan persetujuan izin guru berhasil disalin ke clipboard!');
    }).catch(() => {
        const ta = document.getElementById('cb_modal_text');
        ta.select();
        document.execCommand('copy');
        alert('Teks pesan berhasil disalin!');
    });
}

function submitSendChatbotWa() {
    if (!currentChatbotData || !currentChatbotData.id_guru_izin) return;

    const btn = document.getElementById('btn_submit_chatbot');
    const alertBox = document.getElementById('cb_status_alert');
    const target = document.getElementById('cb_modal_target_select').value;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengirim...</span>';
    alertBox.style.display = 'none';

    fetch(`/guru-piket/permintaan-izin/${currentChatbotData.id_guru_izin}/send-chatbot`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ target: target })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';
        alertBox.style.display = 'block';

        if (data.success) {
            alertBox.style.background = '#dcfce7';
            alertBox.style.color = '#15803d';
            alertBox.style.border = '1px solid #86efac';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Pesan persetujuan berhasil dikirim via ChatBot WhatsApp!');
        } else {
            alertBox.style.background = '#fee2e2';
            alertBox.style.color = '#991b1b';
            alertBox.style.border = '1px solid #fca5a5';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> ' + (data.message || 'Gagal mengirim pesan via ChatBot WhatsApp.');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';
        alertBox.style.display = 'block';
        alertBox.style.background = '#fee2e2';
        alertBox.style.color = '#991b1b';
        alertBox.style.border = '1px solid #fca5a5';
        alertBox.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Terjadi kesalahan koneksi server: ' + err.message;
    });
}
</script>
@endsection
