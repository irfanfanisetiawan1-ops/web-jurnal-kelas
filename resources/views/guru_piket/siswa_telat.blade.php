@extends('layouts.guru')

@section('title', 'Siswa Telat — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Student & Guru Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .guru-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
        width: 100%;
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

    .stat-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
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
        box-sizing: border-box;
        transition: transform 0.2s ease;
    }
    .stat-card:hover { transform: translateY(-2px); }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-amber  { background: #fef3c7; color: #d97706; }
    .stat-icon-purple { background: #f3e8ff; color: #7e22ce; }
    .stat-icon-blue   { background: #dbeafe; color: #1d4ed8; }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

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
        box-sizing: border-box;
    }

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

    textarea.form-control-custom {
        width: 100% !important;
        min-height: 75px;
        resize: vertical;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-family: inherit;
        font-size: 13px;
        color: #1e293b;
        box-sizing: border-box;
    }

    .form-control-custom:focus,
    textarea.form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
        height: 38px;
        box-sizing: border-box;
    }
    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-actions-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
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
        height: 38px;
        box-sizing: border-box;
        white-space: nowrap;
        transition: all 0.15s ease;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        height: 38px;
        box-sizing: border-box;
        white-space: nowrap;
        transition: all 0.15s ease;
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
        height: 38px;
        box-sizing: border-box;
        white-space: nowrap;
        transition: all 0.15s ease;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    .btn-add-primary {
        background: #f59e0b;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-add-primary:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .desktop-table-container {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-sizing: border-box;
    }

    .table-custom {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-custom th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-align: left;
        padding: 12px 16px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .table-custom td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .table-custom tr:hover {
        background-color: #f8fafc;
    }

    .badge-telat {
        background: #fef3c7;
        color: #b45309;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-system-ok {
        background: #d1fae5;
        color: #065f46;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-wa-ok {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-wa-action { background: #25d366; color: #ffffff; }
    .btn-wa-action:hover { background: #128c7e; color: #ffffff; }

    .btn-edit-action { background: #e0e7ff; color: #3730a3; }
    .btn-edit-action:hover { background: #c7d2fe; }

    .btn-delete-action { background: #fee2e2; color: #991b1b; }
    .btn-delete-action:hover { background: #fca5a5; }

    /* Modal Overlay & Card - z-index 99999 */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999 !important;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 650px;
        max-height: calc(100vh - 36px);
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }

    .modal-header h3 {
        font-size: 16.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        box-sizing: border-box;
    }

    .modal-footer {
        padding: 16px 22px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }

    .student-preview-card {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 14px 18px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        font-size: 12.5px;
        box-sizing: border-box;
    }

    .student-preview-card div span {
        color: #64748b;
        font-weight: 600;
        display: block;
        font-size: 11px;
    }
    .student-preview-card div strong {
        color: #0f172a;
        font-weight: 800;
        font-size: 13px;
    }

    .modal-date-time-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Select2 custom tweak */
    .select2-container {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 6px 10px !important;
        background: #f8fafc !important;
        width: 100% !important;
        box-sizing: border-box !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        font-weight: 600 !important;
        padding-right: 28px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .select2-dropdown {
        z-index: 999999 !important;
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
    }

    /* ======================================================== */
    /* MOBILE CARD LIST (FOR SCREEN <= 768px)                   */
    /* ======================================================== */
    .mobile-card-list {
        display: none;
        flex-direction: column;
        gap: 12px;
        padding: 12px;
        box-sizing: border-box;
    }

    .mobile-telat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
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
        box-sizing: border-box;
    }

    /* ======================================================== */
    /* RESPONSIVE MEDIA QUERIES (MOBILE HP & TABLETS)           */
    /* ======================================================== */
    @media (max-width: 992px) {
        .stat-grid-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
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

        .btn-add-primary {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 16px !important;
            font-size: 13.5px !important;
        }

        .stat-grid-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }

        .stat-card {
            padding: 14px !important;
            border-radius: 12px !important;
        }

        .stat-val {
            font-size: 20px !important;
        }

        .stat-icon-wrapper {
            width: 40px !important;
            height: 40px !important;
            font-size: 17px !important;
        }

        .card-custom-header {
            padding: 16px 14px !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 6px !important;
        }

        .card-custom-body {
            padding: 14px 12px !important;
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
        .filter-actions-group #btnBatchDelete {
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

        .modal-date-time-grid {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .student-preview-card {
            grid-template-columns: 1fr !important;
            padding: 12px 14px !important;
        }

        .modal-overlay {
            padding: 12px !important;
        }

        .modal-card {
            width: 100% !important;
            max-width: 100% !important;
            max-height: calc(100vh - 24px) !important;
            border-radius: 16px !important;
        }

        .modal-header {
            padding: 14px 16px !important;
        }

        .modal-header h3 {
            font-size: 15px !important;
        }

        .modal-body {
            padding: 16px 14px !important;
            gap: 14px !important;
        }

        .modal-footer {
            padding: 14px 16px !important;
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .modal-footer button,
        .modal-footer a {
            width: 100% !important;
            justify-content: center !important;
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
            font-size: 26px !important;
        }
        .stat-grid-3 {
            grid-template-columns: 1fr !important;
        }
        .mobile-card-actions {
            grid-template-columns: 1fr 1fr !important;
        }
    }

    @media (max-width: 420px) {
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
<div class="guru-izin-container">

    <!-- Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-user-clock" style="color: #d97706; margin-right: 8px;"></i> Siswa Telat</h1>
            <p>Pendataan siswa terlambat & pengiriman pemberitahuan otomatis ke Guru Mengajar (Sistem Web & WhatsApp)</p>
        </div>
        <button type="button" class="btn-add-primary" onclick="openAddModal()">
            <i class="fa-solid fa-plus-circle"></i> Tambah Data Siswa Telat
        </button>
    </div>

    <!-- WhatsApp Action Button (Hanya jika link chat manual di-generate) -->
    @if(session('wa_url'))
        <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
            <div style="font-size: 13px; font-weight: 600; color: #047857;">
                Pemberitahuan otomatis disinkronisasi ke portal Guru Mengajar. Kirim pesan manual melalui tautan di samping jika diperlukan:
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" class="badge-wa-ok" style="font-size: 12.5px; padding: 8px 14px; text-decoration: none; border-radius: 8px; font-weight: 800; background: #25d366; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3);">
                <i class="fa-brands fa-whatsapp" style="font-size: 15px;"></i> Buka Chat WA Manual ({{ session('guru_nama') }})
            </a>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Stat Cards Grid -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-amber">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="stat-label">Terlambat Hari Ini</div>
                    <div class="stat-val">{{ $totalTelatToday }} Siswa</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <div>
                    <div class="stat-label">Terlambat Bulan Ini</div>
                    <div class="stat-val">{{ $totalTelatBulanIni }} Siswa</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="stat-label">Total Data Siswa</div>
                    <div class="stat-val">{{ $siswaList->count() }} Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card-custom">
        <!-- Filter Bar -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.siswa-telat') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; width: 100%; align-items: center;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Nama Siswa / NIS / Alasan..." style="flex: 1.5 1 200px; min-width: 160px;">
                
                <select name="id_kelas" class="filter-input" style="flex: 1 1 140px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" title="Filter Tanggal" style="flex: 1 1 130px;">

                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>

                    <a href="{{ route('piket.siswa-telat') }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>

                    <!-- Tombol Hapus Terpilih (Batch Delete) -->
                    <button type="button" id="btnBatchDelete" class="btn-trash-pink" onclick="confirmBatchDelete()" style="opacity: 0.5; cursor: not-allowed;" disabled>
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                    </button>

                    @php
                        $trashedCount = \App\Models\SiswaTelat::onlyTrashed()->count();
                    @endphp
                    <a href="{{ route('piket.siswa-telat.trash') }}" class="btn-trash-pink" title="Lihat Sampah Data Siswa Telat">
                        <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
                    </a>
                </div>
            </form>
        </div>

        <!-- Form Tersembunyi untuk Batch Delete -->
        <form id="formBatchDelete" action="{{ route('piket.siswa-telat.destroy-batch') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <div id="batchDeleteInputsContainer"></div>
        </form>

        <!-- DESKTOP TABLE CONTAINER -->
        <div class="desktop-table-container">
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckboxes" title="Pilih Semua (Select All)" style="width: 16px; height: 16px; cursor: pointer;">
                            </th>
                            <th style="width: 45px; text-align: center;">No</th>
                            <th>Waktu & Tanggal</th>
                            <th>Data Siswa (TU)</th>
                            <th>Guru Mengajar Target</th>
                            <th>Alasan & Hukuman Piket</th>
                            <th style="text-align: center;">Pemberitahuan</th>
                            <th style="text-align: center; width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($telatList as $index => $row)
                            @php
                                $siswaObj = $row->siswa;
                                $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                                $guruObj  = $row->guruMengajar;

                                // Resolve phone number using WhatsAppNotificationService
                                $guruUser = $guruObj ? \App\Models\User::where('id_guru', $guruObj->id_guru)->orWhere('nip', $guruObj->nip)->first() : null;
                                $guruPhone = app(\App\Services\WhatsAppNotificationService::class)->resolvePhoneNumber($guruUser) ?: ($guruObj->no_hp ?? null);
                                $rawHp = \App\Services\WhatsAppNotificationService::formatPhoneNumber($guruPhone);

                                $notificationUrl = \App\Services\WhatsAppNotificationService::makeSiswaTelatNotificationUrl($row->id_siswa_telat);
                                $waTextMsg = app(\App\Services\WhatsAppNotificationService::class)->buildPesanSiswaTelatGuruMengajar($row, $notificationUrl);
                                $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . urlencode($waTextMsg) : null;

                                $cbPayload = [
                                    'id_siswa_telat'   => $row->id_siswa_telat,
                                    'siswa_nama'       => $siswaObj->nama_siswa ?? 'Siswa',
                                    'kelas_nama'       => $kelasObj->nama_kelas ?? '-',
                                    'guru_nama'        => $guruObj->nama_guru ?? 'Guru Mengajar',
                                    'guru_hp'          => $rawHp,
                                    'notification_url' => $notificationUrl,
                                    'wa_text_msg'      => $waTextMsg,
                                    'wa_url'           => $waDirectUrl,
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" value="{{ $row->id_siswa_telat }}" class="item-checkbox" style="width: 16px; height: 16px; cursor: pointer;" onchange="updateBatchState()">
                                </td>
                                <td style="text-align: center; font-weight: 700; color: #64748b;">
                                    {{ $telatList->firstItem() + $index }}
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a;">
                                        <i class="fa-regular fa-calendar-check" style="color: #384972; margin-right: 4px;"></i>
                                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="badge-telat" style="margin-top: 4px;">
                                        <i class="fa-solid fa-clock"></i> {{ $row->jam_terlambat }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                        {{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}
                                    </div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                        <span style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-weight: 700; color: #334155;">
                                            {{ $kelasObj->nama_kelas ?? 'Kelas -' }}
                                        </span>
                                        • NIS: {{ $siswaObj->nis ?? '-' }} / NISN: {{ $siswaObj->nisn ?? '-' }}
                                        • ({{ $siswaObj ? $siswaObj->jenis_kelamin_teks : '-' }})
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #1e293b;">
                                        <i class="fa-solid fa-user-tie" style="color: #475569; margin-right: 4px;"></i>
                                        {{ $guruObj->nama_guru ?? 'Guru Tidak Terpilih' }}
                                    </div>
                                    <div style="font-size: 11.5px; color: #64748b;">
                                        Mapel: {{ $guruObj->mapel->nama_mapel ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #1e293b;">
                                        <i class="fa-solid fa-comment-dots" style="color: #f59e0b; margin-right: 4px;"></i>
                                        {{ $row->alasan }}
                                    </div>
                                    @if($row->tindakan_hukuman)
                                        <div style="font-size: 12px; color: #991b1b; background: #fff1f2; padding: 4px 8px; border-radius: 6px; margin-top: 4px; border: 1px solid #fecdd3;">
                                            <strong>Hukuman/Tindakan:</strong> {{ $row->tindakan_hukuman }}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                        <span class="badge-system-ok">
                                            <i class="fa-solid fa-globe"></i> Sistem Web OK
                                        </span>
                                        <button type="button" class="badge-wa-ok" onclick='openChatbotWaModal(@json($cbPayload))' title="Kirim Pemberitahuan WhatsApp ke Guru Mengajar" style="cursor: pointer; border: none; font-family: inherit;">
                                            <i class="fa-brands fa-whatsapp"></i> ChatBot WA
                                        </button>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                        <button type="button" class="btn-action-icon btn-wa-action" onclick='openChatbotWaModal(@json($cbPayload))' title="Kirim WhatsApp via ChatBot">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </button>

                                        <button type="button" class="btn-action-icon btn-edit-action" onclick='openEditModal(@json($row), @json($siswaObj), @json($kelasObj))' title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <form action="{{ route('piket.siswa-telat.destroy', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data siswa telat ini ke Sampah?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-delete-action" title="Hapus ke Sampah">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa-solid fa-user-clock" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                                    <p style="font-weight: 700; font-size: 14px; margin: 0; color: #64748b;">Belum ada data siswa telat yang dicatat hari ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MOBILE CARDS LIST -->
        <div class="mobile-card-list">
            @forelse($telatList as $index => $row)
                @php
                    $siswaObj = $row->siswa;
                    $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                    $guruObj  = $row->guruMengajar;

                    // Phone & message
                    $guruUser = $guruObj ? \App\Models\User::where('id_guru', $guruObj->id_guru)->orWhere('nip', $guruObj->nip)->first() : null;
                    $guruPhone = app(\App\Services\WhatsAppNotificationService::class)->resolvePhoneNumber($guruUser) ?: ($guruObj->no_hp ?? null);
                    $rawHp = \App\Services\WhatsAppNotificationService::formatPhoneNumber($guruPhone);

                    $notificationUrl = \App\Services\WhatsAppNotificationService::makeSiswaTelatNotificationUrl($row->id_siswa_telat);
                    $waTextMsg = app(\App\Services\WhatsAppNotificationService::class)->buildPesanSiswaTelatGuruMengajar($row, $notificationUrl);
                    $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . urlencode($waTextMsg) : null;

                    $cbPayload = [
                        'id_siswa_telat'   => $row->id_siswa_telat,
                        'siswa_nama'       => $siswaObj->nama_siswa ?? 'Siswa',
                        'kelas_nama'       => $kelasObj->nama_kelas ?? '-',
                        'guru_nama'        => $guruObj->nama_guru ?? 'Guru Mengajar',
                        'guru_hp'          => $rawHp,
                        'notification_url' => $notificationUrl,
                        'wa_text_msg'      => $waTextMsg,
                        'wa_url'           => $waDirectUrl,
                    ];
                @endphp
                <div class="mobile-telat-card">
                    <div class="mobile-card-header">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" value="{{ $row->id_siswa_telat }}" class="item-checkbox" style="width: 17px; height: 17px; cursor: pointer;" onchange="updateBatchState()">
                            <span style="font-weight: 800; font-size: 11.5px; color: #64748b;">#{{ $telatList->firstItem() + $index }}</span>
                            <span style="background: #e2e8f0; padding: 2px 8px; border-radius: 6px; font-weight: 700; color: #334155; font-size: 11.5px;">
                                {{ $kelasObj->nama_kelas ?? 'Kelas -' }}
                            </span>
                        </div>
                        <div class="badge-telat" style="font-size: 11px;">
                            <i class="fa-solid fa-clock"></i> {{ $row->jam_terlambat }} WIB
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="font-weight: 800; color: #0f172a; font-size: 14.5px;">
                            {{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}
                        </div>
                        <div style="font-size: 11.5px; color: #64748b;">
                            NIS: {{ $siswaObj->nis ?? '-' }} / NISN: {{ $siswaObj->nisn ?? '-' }} • ({{ $siswaObj ? $siswaObj->jenis_kelamin_teks : '-' }})
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 10px; padding: 10px 12px; display: flex; flex-direction: column; gap: 6px; border: 1px solid #f1f5f9; font-size: 12px;">
                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Waktu & Tanggal:</span>
                            <strong style="color: #0f172a;">
                                <i class="fa-regular fa-calendar-check" style="color: #384972; margin-right: 4px;"></i>
                                {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                            </strong>
                        </div>

                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Guru Mengajar Target:</span>
                            <strong style="color: #1e293b;">
                                <i class="fa-solid fa-user-tie" style="color: #475569; margin-right: 4px;"></i>
                                {{ $guruObj->nama_guru ?? 'Guru Tidak Terpilih' }}
                            </strong>
                            <span style="color: #64748b; font-size: 11px;">(Mapel: {{ $guruObj->mapel->nama_mapel ?? '-' }})</span>
                        </div>

                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Alasan:</span>
                            <span style="font-weight: 700; color: #1e293b;">{{ $row->alasan }}</span>
                        </div>

                        @if($row->tindakan_hukuman)
                            <div style="font-size: 11.5px; color: #991b1b; background: #fff1f2; padding: 4px 8px; border-radius: 6px; border: 1px solid #fecdd3;">
                                <strong>Hukuman/Tindakan:</strong> {{ $row->tindakan_hukuman }}
                            </div>
                        @endif

                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 4px; padding-top: 6px; border-top: 1px dashed #e2e8f0;">
                            <span class="badge-system-ok">
                                <i class="fa-solid fa-globe"></i> Sistem Web OK
                            </span>
                            <button type="button" class="badge-wa-ok" onclick='openChatbotWaModal(@json($cbPayload))' title="Kirim WhatsApp" style="cursor: pointer; border: none; font-family: inherit;">
                                <i class="fa-brands fa-whatsapp"></i> ChatBot WA
                            </button>
                        </div>
                    </div>

                    <div class="mobile-card-actions">
                        <button type="button" class="btn-action-mobile btn-wa-action" onclick='openChatbotWaModal(@json($cbPayload))' style="background: #22c55e; color: #ffffff; border: none;">
                            <i class="fa-brands fa-whatsapp"></i> ChatBot WA
                        </button>
                        <button type="button" class="btn-action-mobile btn-edit-action" onclick='openEditModal(@json($row), @json($siswaObj), @json($kelasObj))' style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form action="{{ route('piket.siswa-telat.destroy', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data siswa telat ini ke Sampah?');" style="grid-column: 1 / -1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-mobile btn-delete-action" style="width: 100%; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;">
                                <i class="fa-solid fa-trash-can"></i> Hapus ke Sampah
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 32px 16px; background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; color: #94a3b8;">
                    <i class="fa-solid fa-user-clock" style="font-size: 36px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                    <p style="font-weight: 700; font-size: 13.5px; margin: 0; color: #64748b;">Belum ada data siswa telat yang dicatat hari ini.</p>
                </div>
            @endforelse
        </div>

        @if($telatList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0;">
                {{ $telatList->withQueryString()->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Tambah Siswa Telat -->
<div id="addSiswaTelatModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <i class="fa-solid fa-user-clock" style="color: #f59e0b;"></i> Tambah & Kirim Pemberitahuan Siswa Telat
            </h3>
            <button type="button" onclick="closeAddModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('piket.siswa-telat.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                
                <!-- 1. Pilih Siswa (Data Master TU) -->
                <div>
                    <label class="form-label-custom">Pilih Siswa (Data Master TU / Database) <span style="color: #ef4444;">*</span></label>
                    <select name="id_siswa" id="add_id_siswa" class="form-control-custom select2-siswa" style="width: 100%;" required onchange="onSiswaSelected(this.value)">
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

                <!-- 2. Pilih Guru Mengajar saat Jam Pelajaran -->
                <div>
                    <label class="form-label-custom">
                        Guru Mengajar di Kelas Saat Ini (Target Pemberitahuan) <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="font-size: 11.5px; color: #64748b; margin-bottom: 6px;" id="scheduleHelpText">
                        Pemberitahuan akan masuk ke Halaman Pengumuman Guru Mengajar tersebut & pesan WhatsApp.
                    </div>
                    <input type="hidden" name="id_jadwal" id="add_id_jadwal" value="">
                    <select name="id_guru_mengajar" id="add_id_guru_mengajar" class="form-control-custom select2-guru" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-date-time-grid">
                    <div>
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="add_tanggal" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Kedatangan / Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}" class="form-control-custom" placeholder="Contoh: 07:25" required>
                    </div>
                </div>

                <div>
                    <label class="form-label-custom">Alasan Keterlambatan Siswa <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" rows="2" class="form-control-custom" placeholder="Contoh: Ban sepeda motor bocor di jalan, bangun kesiangan..." required></textarea>
                </div>

                <div>
                    <label class="form-label-custom">Tindakan / Hukuman Piket (Opsional)</label>
                    <textarea name="tindakan_hukuman" rows="2" class="form-control-custom" placeholder="Contoh: Membersihkan halaman sekolah & lari keliling lapangan 2 kali..."></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeAddModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-add-primary">
                    <i class="fa-solid fa-paper-plane"></i> Simpan & Kirim Pemberitahuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Siswa Telat -->
<div id="editSiswaTelatModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Edit Data Siswa Telat
            </h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form id="editFormSiswaTelat" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                
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

                <div>
                    <label class="form-label-custom">Guru Mengajar Target <span style="color: #ef4444;">*</span></label>
                    <select name="id_guru_mengajar" id="edit_id_guru_mengajar" class="form-control-custom select2-guru-edit" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-date-time-grid">
                    <div>
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" id="edit_jam_terlambat" class="form-control-custom" required>
                    </div>
                </div>

                <div>
                    <label class="form-label-custom">Alasan Terlambat <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" id="edit_alasan" rows="2" class="form-control-custom" required></textarea>
                </div>

                <div>
                    <label class="form-label-custom">Tindakan / Hukuman Piket</label>
                    <textarea name="tindakan_hukuman" id="edit_tindakan_hukuman" rows="2" class="form-control-custom"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-filter-dark" style="background: #2563eb;">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Interaktif Kirim ChatBot WhatsApp ke Guru Mengajar -->
<div id="chatbotWaModal" class="modal-overlay" onclick="closeChatbotWaModal(event)">
    <div class="modal-card" style="max-width: 580px;" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h3 style="color: #0f172a; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-brands fa-whatsapp" style="color: #22c55e; font-size: 22px;"></i>
                Kirim Pemberitahuan WhatsApp ke Guru Mengajar
            </h3>
            <button type="button" onclick="closeChatbotWaModalDirect()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body" style="padding: 22px; display: flex; flex-direction: column; gap: 16px;">
            <!-- Informasi Target Siswa & Guru Mengajar -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 6px;">
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a;">
                        <span id="cb_modal_siswa_nama">-</span>
                        <span id="cb_modal_kelas" style="font-size: 12px; color: #3b82f6; font-weight: 700; background: #eff6ff; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 12px; margin-left: 6px;">-</span>
                    </div>
                    <div id="cb_modal_wa_badge"></div>
                </div>
                <div style="font-size: 12.5px; color: #475569; font-weight: 600;">
                    <i class="fa-solid fa-user-tie" style="color: #64748b; margin-right: 4px;"></i> Guru Mengajar Target: <strong id="cb_modal_guru_nama" style="color: #0f172a;">-</strong>
                    <span id="cb_modal_guru_hp_text" style="color: #059669; font-weight: 700; margin-left: 6px;"></span>
                </div>
            </div>

            <!-- Tautan Halaman Pemberitahuan Resmi (Link Biru) -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 14px;">
                <div style="font-size: 11.5px; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-link" style="color: #16a34a;"></i> Tautan Halaman Pemberitahuan (Link Biru):
                </div>
                <div style="word-break: break-all; font-size: 12.5px;">
                    <a id="cb_modal_link" href="#" target="_blank" style="color: #15803d; font-weight: 700; text-decoration: underline;">-</a>
                </div>
            </div>

            <!-- Preview Teks Pesan -->
            <div>
                <label class="form-label-custom" style="margin-bottom: 6px; display: block; font-size: 12px; font-weight: 700; color: #334155;">Pratinjau Isi Pesan WhatsApp:</label>
                <textarea id="cb_modal_text" rows="6" readonly style="font-size: 12px; font-family: monospace; background: #f8fafc; resize: vertical; line-height: 1.4; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px;"></textarea>
            </div>

            <!-- Alert response status -->
            <div id="cb_status_alert" style="display: none; padding: 12px; border-radius: 10px; font-size: 12.5px; font-weight: 700;"></div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 4px;">
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button type="button" id="btn_submit_chatbot" style="background: #16a34a; color: #ffffff; font-weight: 700; padding: 9px 16px; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 13px;" onclick="submitSendChatbotWa()">
                        <i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>
                    </button>
                    <a id="cb_modal_manual_link" href="#" target="_blank" style="background: #22c55e; color: #ffffff; font-weight: 700; padding: 9px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
                        <i class="fa-brands fa-whatsapp"></i> Cadangan Manual WA
                    </a>
                    <button type="button" style="background: #0284c7; color: #ffffff; font-weight: 700; padding: 9px 14px; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;" onclick="copyChatbotWaText()">
                        <i class="fa-solid fa-copy"></i> Salin Pesan
                    </button>
                </div>
                <button type="button" class="btn-reset-light" onclick="closeChatbotWaModalDirect()" style="padding: 9px 18px; font-size: 12.5px; border-radius: 8px;">
                    Tutup
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
    });

    function updateBatchState() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox').length;

        $('#selectedCount').text(count);

        if (totalItems > 0 && count === totalItems) {
            $('#selectAllCheckboxes').prop('checked', true);
        } else {
            $('#selectAllCheckboxes').prop('checked', false);
        }

        const btn = $('#btnBatchDelete');
        if (count > 0) {
            btn.prop('disabled', false)
               .css({ opacity: 1, cursor: 'pointer', background: '#fee2e2', color: '#991b1b', border: '1px solid #fca5a5' });
        } else {
            btn.prop('disabled', true)
               .css({ opacity: 0.5, cursor: 'not-allowed' });
        }
    }

    function confirmBatchDelete() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;

        if (count === 0) {
            alert('Silakan centang minimal satu data siswa telat yang ingin dihapus.');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + count + ' data siswa telat terpilih ke Sampah?')) {
            const container = $('#batchDeleteInputsContainer');
            container.empty();
            checkedItems.each(function() {
                container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
            });
            $('#formBatchDelete').submit();
        }
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

    // ChatBot WhatsApp Modal Functions
    let currentChatbotItem = null;

    function openChatbotWaModal(itemData) {
        currentChatbotItem = itemData;
        document.getElementById('cb_modal_siswa_nama').textContent = itemData.siswa_nama || '-';
        document.getElementById('cb_modal_kelas').textContent = itemData.kelas_nama || '-';
        document.getElementById('cb_modal_guru_nama').textContent = itemData.guru_nama || '-';

        const badgeBox   = document.getElementById('cb_modal_wa_badge');
        const hpText     = document.getElementById('cb_modal_guru_hp_text');
        const btnChatbot = document.getElementById('btn_submit_chatbot');
        const btnManual  = document.getElementById('cb_modal_manual_link');

        if (itemData.guru_hp && itemData.guru_hp.trim() !== '') {
            badgeBox.innerHTML = '<span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px; border: 1px solid #86efac;"><i class="fa-solid fa-circle-check"></i> WA Terdaftar</span>';
            hpText.textContent = `(${itemData.guru_hp})`;
            btnChatbot.style.display = 'inline-flex';
            btnChatbot.disabled = false;
        } else {
            badgeBox.innerHTML = '<span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px; border: 1px solid #fca5a5;"><i class="fa-solid fa-triangle-exclamation"></i> WA Belum Ada</span>';
            hpText.textContent = '(Nomor HP belum terdaftar)';
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

        document.getElementById('chatbotWaModal').style.display = 'flex';
    }

    function closeChatbotWaModal(event) {
        if (event.target === document.getElementById('chatbotWaModal')) {
            closeChatbotWaModalDirect();
        }
    }

    function closeChatbotWaModalDirect() {
        document.getElementById('chatbotWaModal').style.display = 'none';
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
        if (!currentChatbotItem || !currentChatbotItem.id_siswa_telat) return;

        const btn = document.getElementById('btn_submit_chatbot');
        const alertBox = document.getElementById('cb_status_alert');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengirim via ChatBot...</span>';
        alertBox.style.display = 'none';

        fetch(`/guru-piket/siswa-telat/${currentChatbotItem.id_siswa_telat}/send-chatbot`, {
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
</script>
@endsection
