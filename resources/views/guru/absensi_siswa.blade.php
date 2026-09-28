@extends('layouts.guru')

@section('title', 'Presensi Siswa — EDU JOURNAL')
@section('header_title', 'Presensi Siswa')

@section('styles')
<style>
    .presensi-grid {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .presensi-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Top Selector Toolbar */
    .selector-bar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .selector-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .select-custom {
        padding: 9px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        cursor: pointer;
        transition: border 0.15s ease, background 0.15s ease;
    }

    .select-custom:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    /* Action bar above student list */
    .action-toolbar {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .search-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .search-input-wrapper i.search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13.5px;
    }

    .input-search-siswa {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: all 0.15s ease;
    }

    .input-search-siswa:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-reset-search {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-reset-search:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-set-hadir {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-set-hadir:hover {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Filter pills */
    .filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .pill-item {
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        user-select: none;
    }

    .pill-item:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .pill-item.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
    }

    .pill-badge {
        background: rgba(0,0,0,0.08);
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 11px;
    }

    .pill-item.active .pill-badge {
        background: rgba(255,255,255,0.25);
    }

    /* Main Presensi Box */
    .main-presensi-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .btn-simpan-top {
        background: #2563eb;
        color: #ffffff;
        padding: 9px 22px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13.5px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
        transition: background 0.15s ease, transform 0.1s ease;
    }

    .btn-simpan-top:hover {
        background: #1d4ed8;
    }

    .btn-simpan-top:active {
        transform: scale(0.98);
    }

    .student-card-item {
        background: #fdfbf7;
        border: 1px solid #f3ebe0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.15s ease;
    }

    .student-card-item:hover {
        border-color: #e2d9cc;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .avatar-initial {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #d6ccc2;
        color: #1e293b;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .student-nisn {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Badges for Surat Izin & Dispen */
    .badge-cross-system {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        margin-top: 4px;
    }

    .badge-izin-system {
        background: #fef9c3;
        color: #a16207;
        border: 1px solid #fde047;
    }

    .badge-sakit-system {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-dispen-system {
        background: #f3e8ff;
        color: #7e22ce;
        border: 1px solid #d8b4fe;
    }

    .badge-telat-system {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .badge-status-tag {
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tag-hadir {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .tag-sakit {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .tag-izin {
        background: #fef9c3;
        color: #a16207;
        border: 1px solid #fde047;
    }

    .tag-alpa {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    .tag-dispen {
        background: #f3e8ff;
        color: #7e22ce;
        border: 1px solid #d8b4fe;
    }

    .tag-terlambat, .tag-telat {
        background: #ffedd5;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    /* SIAD Radio Buttons */
    .siad-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }

    .siad-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .siad-btn:hover {
        border-color: #94a3b8;
        background: #f8fafc;
    }

    .siad-input { display: none; }

    /* Active colors: Sakit = Biru, Izin = Kuning, Alpa = Merah, Dispen = Ungu */
    .siad-input-s:checked + .siad-btn-s { background: #2563eb; color: #ffffff; border-color: #2563eb; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35); }
    .siad-input-i:checked + .siad-btn-i { background: #eab308; color: #ffffff; border-color: #eab308; box-shadow: 0 2px 6px rgba(234, 179, 8, 0.35); }
    .siad-input-a:checked + .siad-btn-a { background: #dc2626; color: #ffffff; border-color: #dc2626; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.35); }
    .siad-input-d:checked + .siad-btn-d { background: #9333ea; color: #ffffff; border-color: #9333ea; box-shadow: 0 2px 6px rgba(147, 51, 234, 0.35); }

    /* Locked states */
    .siad-btn.locked-active-s { background: #2563eb !important; color: #ffffff !important; border-color: #2563eb !important; cursor: not-allowed; }
    .siad-btn.locked-active-i { background: #eab308 !important; color: #ffffff !important; border-color: #eab308 !important; cursor: not-allowed; }
    .siad-btn.locked-active-a { background: #dc2626 !important; color: #ffffff !important; border-color: #dc2626 !important; cursor: not-allowed; }
    .siad-btn.locked-active-d { background: #9333ea !important; color: #ffffff !important; border-color: #9333ea !important; cursor: not-allowed; }
    .siad-btn.locked-disabled { opacity: 0.35 !important; cursor: not-allowed !important; background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #94a3b8 !important; }
    .siad-btn.dispen-disabled { opacity: 0.45 !important; cursor: not-allowed !important; background: #f8fafc !important; border: 1px dashed #cbd5e1 !important; color: #94a3b8 !important; }

    /* Widgets */
    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .summary-row:last-child { border-bottom: none; }

    .summary-label {
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-val {
        font-weight: 800;
        color: #0f172a;
        font-size: 15px;
    }

    .dot-bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .wali-presensi-absen-desktop-table {
        display: block;
    }

    .wali-presensi-absen-mobile-cards {
        display: none;
    }

    /* Mobile Responsive Optimizations */
    @media (max-width: 768px) {
        .wali-presensi-absen-desktop-table {
            display: none !important;
        }

        .wali-presensi-absen-mobile-cards {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }

        .wali-status-wrap {
            width: 100% !important;
            display: flex !important;
            justify-content: flex-end !important;
            padding-top: 6px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        .wali-status-wrap span {
            font-size: 12px !important;
            padding: 5px 12px !important;
        }

        .presensi-grid {
            grid-template-columns: 100% !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            gap: 18px !important;
        }

        .page-header-presensi {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .page-title-presensi {
            font-size: 28px !important;
            line-height: 1.25 !important;
            font-weight: 800 !important;
        }

        .page-subtitle-presensi {
            font-size: 13px !important;
            margin-top: 6px !important;
        }

        .header-badge-wrap {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .header-badge-wrap .btn-simpan-top,
        .header-badge-wrap span {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 11px 16px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .tabs-container {
            flex-direction: column !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .tab-btn {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .selector-bar {
            padding: 14px 14px !important;
            border-radius: 14px !important;
            margin-bottom: 18px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .selector-bar form {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .selector-group {
            width: 100% !important;
            max-width: 100% !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            box-sizing: border-box !important;
        }

        .select-custom {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            font-size: 13px !important;
            padding: 10px 12px !important;
        }

        .selector-date-actions {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 6px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .selector-date-actions a {
            justify-content: center !important;
            text-align: center !important;
            padding: 8px 4px !important;
            font-size: 11px !important;
            box-sizing: border-box !important;
        }

        .selector-extra-links {
            display: flex !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            flex-wrap: wrap !important;
            box-sizing: border-box !important;
        }

        .selector-extra-links > * {
            flex: 1 1 auto !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 8px 10px !important;
            font-size: 12px !important;
            box-sizing: border-box !important;
        }

        .notice-banner-responsive {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            padding: 14px 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .notice-banner-responsive > div {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .notice-banner-responsive a,
        .notice-banner-responsive span.badge-btn {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .main-presensi-box {
            padding: 16px 14px !important;
            border-radius: 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .card-header-presensi {
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            gap: 8px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .card-header-presensi h2 {
            font-size: 15px !important;
        }

        .action-toolbar {
            gap: 12px !important;
            margin-bottom: 16px !important;
            padding-bottom: 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .search-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .search-input-wrapper {
            min-width: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .search-input-wrapper input {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .search-row-actions {
            display: flex !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .search-row-actions button {
            flex: 1 1 0 !important;
            justify-content: center !important;
            padding: 10px 10px !important;
            font-size: 12.5px !important;
            box-sizing: border-box !important;
        }

        .filter-pills {
            overflow-x: auto !important;
            flex-wrap: nowrap !important;
            padding: 2px 2px 8px 2px !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        .filter-pills::-webkit-scrollbar {
            display: none;
        }

        .pill-item {
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
        }

        .student-card-item {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            padding: 14px 12px !important;
            border-radius: 12px !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .student-info {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }

        .avatar-initial {
            width: 40px !important;
            height: 40px !important;
            font-size: 14px !important;
            flex-shrink: 0 !important;
        }

        .student-name {
            white-space: normal !important;
            word-break: break-word !important;
            font-size: 14px !important;
            line-height: 1.35 !important;
        }

        .badge-cross-system {
            white-space: normal !important;
            word-break: break-word !important;
            font-size: 11px !important;
            padding: 4px 8px !important;
            line-height: 1.35 !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .siad-buttons {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            gap: 6px !important;
            box-sizing: border-box !important;
        }

        .siad-buttons > div {
            width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        .siad-btn {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            height: 40px !important;
            font-size: 14px !important;
            border-radius: 9px !important;
            box-sizing: border-box !important;
        }

        .bottom-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .bottom-action-bar button,
        .bottom-action-bar span,
        .bottom-action-bar a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .widget-card {
            padding: 16px 14px !important;
            border-radius: 14px !important;
            margin-bottom: 16px !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .summary-row {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .summary-label {
            flex: 1 1 auto !important;
            min-width: 0 !important;
        }

        .summary-val {
            flex-shrink: 0 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .perwalian-metric-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-presensi {
            font-size: 25px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
        }

        .perwalian-metric-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 8px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Top Header -->
    <div class="page-header-presensi" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="page-title-presensi" style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-user-check" style="color: #2563eb;"></i>
                Presensi Siswa
            </h1>
            <p class="page-subtitle-presensi" style="font-size: 13.5px; color: #64748b; margin-top: 4px; margin-bottom: 0;">
                {{ $subJudul }}
            </p>
        </div>
        <div class="header-badge-wrap" style="display: flex; align-items: center; gap: 12px;">
            @if(!$isModeWali && $canSavePresensi)
                <button type="button" onclick="document.getElementById('formPresensi').submit()" class="btn-simpan-top">
                    <i class="fa-solid fa-check"></i> Simpan Presensi
                </button>
            @elseif($isModeWali)
                <span style="background: #ecfdf5; color: #047857; font-weight: 800; font-size: 13px; padding: 8px 16px; border-radius: 10px; border: 1.5px solid #a7f3d0; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-eye"></i> Mode Monitoring Perwalian (Hanya Pantau)
                </span>
            @else
                <span style="background: #f8fafc; color: #64748b; font-weight: 800; font-size: 12.5px; padding: 8px 16px; border-radius: 10px; border: 1.5px solid #cbd5e1; display: inline-flex; align-items: center; gap: 6px;" title="{{ $timeLockReason }}">
                    <i class="fa-solid fa-lock"></i> Presensi Terkunci (Read-Only)
                </span>
            @endif
        </div>
    </div>

    <!-- Context Tab Switcher for Wali Kelas -->
    @if($isWaliKelas && $kelasWali)
        <div class="tabs-container" style="display: flex; gap: 10px; margin-bottom: 22px; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; flex-wrap: wrap;">
            <a href="{{ route('guru.absensi-siswa', ['tab' => 'saya']) }}" 
               class="tab-btn {{ !$isModeWali ? 'active' : '' }}" 
               style="padding: 10px 20px; border-radius: 12px; font-weight: 800; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; {{ !$isModeWali ? 'background: #2563eb; color: #ffffff; box-shadow: 0 4px 12px rgba(37,99,235,0.25);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Presensi Jadwal Mengajar Saya</span>
                @if(isset($jadwalsHariIni) && $jadwalsHariIni->count() > 0)
                    <span style="background: {{ !$isModeWali ? 'rgba(255,255,255,0.25)' : '#e2e8f0' }}; color: {{ !$isModeWali ? '#ffffff' : '#334155' }}; padding: 2px 8px; border-radius: 20px; font-size: 11px;">
                        {{ $jadwalsHariIni->count() }} KBM
                    </span>
                @endif
            </a>

            <a href="{{ route('guru.absensi-siswa', ['tab' => 'perwalian', 'tanggal' => $targetDate]) }}" 
               class="tab-btn {{ $isModeWali ? 'active' : '' }}" 
               style="padding: 10px 20px; border-radius: 12px; font-weight: 800; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; {{ $isModeWali ? 'background: #059669; color: #ffffff; box-shadow: 0 4px 12px rgba(5,150,105,0.25);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
                <i class="fa-solid fa-users-rectangle"></i>
                <span>Presensi & Monitoring Kelas Perwalian ({{ $kelasWali->nama_kelas }})</span>
                <span style="background: {{ $isModeWali ? 'rgba(255,255,255,0.25)' : '#d1fae5' }}; color: {{ $isModeWali ? '#ffffff' : '#047857' }}; padding: 2px 8px; border-radius: 20px; font-size: 11px;">
                    Wali Kelas
                </span>
            </a>
        </div>
    @endif

    <!-- Wali Kelas Perwalian Overview Card -->
    @if($isModeWali && $kelasWali)
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 18px 22px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #a7f3d0;">
                        <i class="fa-solid fa-chalkboard"></i>
                    </div>
                    <div>
                        <div style="font-size: 16px; font-weight: 800; color: #0f172a;">
                            Kelas Perwalian: {{ $kelasWali->nama_kelas }}
                        </div>
                        <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                            Wali Kelas: <strong>{{ Auth::user()->name }}</strong> &bull; Total Siswa: <strong>{{ $siswas->count() }} Siswa</strong> &bull; Hari: <strong>{{ $hariTarget }}, {{ \Carbon\Carbon::parse($targetDate)->translatedFormat('d F Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 Summary Metric Cards -->
            <div class="perwalian-metric-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 12px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total KBM Hari {{ $hariTarget }}</div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $rekapPerwalianHariIni['total_kbm'] }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Jam Mapel</span></div>
                </div>

                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 14px 16px;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #065f46; text-transform: uppercase;">Jurnal KBM Terisi</div>
                    <div style="font-size: 20px; font-weight: 800; color: #059669; margin-top: 4px;">{{ $rekapPerwalianHariIni['terisi'] }} <span style="font-size: 13px; font-weight: 600; color: #047857;">Selesai</span></div>
                </div>

                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px 16px;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #92400e; text-transform: uppercase;">Belum Terisi</div>
                    <div style="font-size: 20px; font-weight: 800; color: #d97706; margin-top: 4px;">{{ $rekapPerwalianHariIni['belum'] }} <span style="font-size: 13px; font-weight: 600; color: #b45309;">Pending</span></div>
                </div>

                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 16px;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #991b1b; text-transform: uppercase;">Ketidakhadiran Siswa</div>
                    <div style="font-size: 20px; font-weight: 800; color: #dc2626; margin-top: 4px;">
                        {{ ($rekapPerwalianHariIni['siswa_sakit'] + $rekapPerwalianHariIni['siswa_izin'] + $rekapPerwalianHariIni['siswa_alpa'] + $rekapPerwalianHariIni['siswa_dispen']) }} <span style="font-size: 13px; font-weight: 600; color: #991b1b;">Siswa</span>
                    </div>
                    <div style="font-size: 11.5px; font-weight: 700; color: #7f1d1d; margin-top: 3px;">
                        (S: {{ $rekapPerwalianHariIni['siswa_sakit'] }}, I: {{ $rekapPerwalianHariIni['siswa_izin'] }}, A: {{ $rekapPerwalianHariIni['siswa_alpa'] }}, D: {{ $rekapPerwalianHariIni['siswa_dispen'] }})
                        @if(($rekapPerwalianHariIni['siswa_telat'] ?? 0) > 0)
                            &bull; <span style="color: #ea580c; font-weight: 800;">{{ $rekapPerwalianHariIni['siswa_telat'] }} Telat</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter & Schedule Selector Bar -->
    <div class="selector-bar">
        <form id="filterForm" method="GET" action="{{ route('guru.absensi-siswa') }}" style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 16px;">
            <input type="hidden" name="tab" value="{{ $activeTab }}">

            <div class="selector-group">
                @if($isModeWali && $kelasWali)
                    <label for="selectJadwal" style="font-size: 13px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-list-check" style="color: #059669;"></i> Jam KBM / Mapel Kelas:
                    </label>
                    <select name="id_jadwal" id="selectJadwal" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                        @if($jadwalsKelasPerwalianHariIni->isNotEmpty())
                            @foreach($jadwalsKelasPerwalianHariIni as $jk)
                                @php
                                    $isSelKls = ($selectedJadwal && $selectedJadwal->id_jadwal == $jk->id_jadwal);
                                    $hasJurnal = isset($jurnalsKelasPerwalianMap[$jk->id_jadwal]);
                                    $waktuText = $jk->waktu_range !== '-' ? $jk->waktu_range : "Jam ke-{$jk->jam_range}";
                                @endphp
                                <option value="{{ $jk->id_jadwal }}" {{ $isSelKls ? 'selected' : '' }}>
                                    [{{ $waktuText }}] {{ $jk->mapel->nama_mapel ?? 'Mapel' }} — Guru: {{ $jk->guru->nama_guru ?? 'Guru' }} {{ $hasJurnal ? '✓ (Terisi)' : '⏳ (Belum Diisi)' }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Tidak ada jadwal KBM kelas hari ini ({{ $hariTarget }})</option>
                        @endif
                    </select>
                @else
                    <label for="selectJadwal" style="font-size: 13px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i> Jadwal / Kelas:
                    </label>
                    <select name="id_jadwal" id="selectJadwal" class="select-custom">
                        @if($jadwals->isNotEmpty())
                            @if($jadwalsHariIni->isNotEmpty())
                                <optgroup label="Jadwal Mengajar Hari Ini ({{ $hariTarget }})">
                                    @foreach($jadwalsHariIni as $j)
                                        @php
                                             $waktuText = $j->waktu_range !== '-' ? "({$j->waktu_range})" : ($j->jam_range ? "(Jam ke-{$j->jam_range})" : '');
                                             $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal && !$isModeWali);
                                             $optDate = $weekDates[$j->hari] ?? $targetDate;
                                        @endphp
                                        <option value="{{ $j->id_jadwal }}" {{ $isSelected ? 'selected' : '' }} data-hari="{{ $j->hari }}" data-date="{{ $optDate }}">
                                            [{{ $j->hari }}, {{ \Carbon\Carbon::parse($optDate)->translatedFormat('d M Y') }}] {{ $j->mapel->nama_mapel ?? 'Mapel' }} – {{ $j->kelas->nama_kelas ?? 'Kelas' }} {{ $waktuText }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            @if($jadwals->where('hari', '!=', $hariTarget)->isNotEmpty())
                                <optgroup label="{{ $jadwalsHariIni->isNotEmpty() ? 'Jadwal Mengajar Hari Lainnya' : 'Daftar Seluruh Jadwal Mengajar Anda' }}">
                                    @foreach($jadwals->where('hari', '!=', $hariTarget) as $j)
                                        @php
                                            $waktuText = $j->waktu_range !== '-' ? "({$j->waktu_range})" : ($j->jam_range ? "(Jam ke-{$j->jam_range})" : '');
                                            $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal && !$isModeWali);
                                            $optDate = $weekDates[$j->hari] ?? $targetDate;
                                        @endphp
                                        <option value="{{ $j->id_jadwal }}" {{ $isSelected ? 'selected' : '' }} data-hari="{{ $j->hari }}" data-date="{{ $optDate }}">
                                            [{{ $j->hari }}, {{ \Carbon\Carbon::parse($optDate)->translatedFormat('d M Y') }}] {{ $j->mapel->nama_mapel ?? 'Mapel' }} – {{ $j->kelas->nama_kelas ?? 'Kelas' }} {{ $waktuText }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @else
                            <option value="">Tidak ada jadwal mengajar</option>
                        @endif
                    </select>
                @endif
            </div>

            <div class="selector-group" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <label for="inputTanggal" style="font-size: 13px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-clock" style="color: #2563eb;"></i> Tanggal:
                </label>
                <input type="date" name="tanggal" id="inputTanggal" value="{{ $targetDate }}" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                
                @php
                    $actualTodayStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                    $prevDay = \Carbon\Carbon::parse($targetDate)->subDay()->toDateString();
                    $nextDay = \Carbon\Carbon::parse($targetDate)->addDay()->toDateString();
                @endphp
                <div class="selector-date-actions" style="display: inline-flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                    @if($targetDate !== $actualTodayStr)
                        <a href="{{ route('guru.absensi-siswa', array_filter(['tab' => $activeTab, 'id_jadwal' => $isModeWali ? null : ($selectedJadwal->id_jadwal ?? null), 'tanggal' => $actualTodayStr])) }}" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 6px 10px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-rotate-left"></i> Hari Ini
                        </a>
                    @endif
                    <a href="{{ route('guru.absensi-siswa', array_filter(['tab' => $activeTab, 'id_jadwal' => $isModeWali ? null : ($selectedJadwal->id_jadwal ?? null), 'tanggal' => $prevDay])) }}" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 700; padding: 6px 10px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Hari Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i> Kemarin
                    </a>
                    <a href="{{ route('guru.absensi-siswa', array_filter(['tab' => $activeTab, 'id_jadwal' => $isModeWali ? null : ($selectedJadwal->id_jadwal ?? null), 'tanggal' => $nextDay])) }}" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 700; padding: 6px 10px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Hari Berikutnya">
                        Besok <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>

                <div class="selector-extra-links" style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    @if($existingJurnal)
                        <span style="font-size: 11.5px; font-weight: 800; background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 8px; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-circle-check"></i> Sudah Terisi
                        </span>
                    @else
                        <span style="font-size: 11.5px; font-weight: 800; background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 8px; border: 1px solid #fde68a; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-clock-rotate-left"></i> Belum Diisi
                        </span>
                    @endif

                    <a href="{{ route('guru.jurnal-harian', ['tab' => $activeTab, 'tanggal' => $targetDate]) }}" style="background: #ffffff; color: #2563eb; border: 1px solid #bfdbfe; padding: 6px 12px; border-radius: 8px; font-weight: 800; font-size: 11.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;" title="Buka Jurnal Harian">
                        <i class="fa-solid fa-book-open"></i> Jurnal Harian
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Peringatan Hari Tidak Sesuai jika ada -->
    @if(empty($isHariSesuai) && !empty($selectedJadwal) && !$isModeWali)
        @php
            $matchingDateForSchedule = $weekDates[$selectedJadwal->hari] ?? $targetDate;
            $matchingDateFormatted = \Carbon\Carbon::parse($matchingDateForSchedule)->translatedFormat('d F Y');
        @endphp
        <div class="notice-banner-responsive" style="background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; padding: 14px 18px; border-radius: 14px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-triangle-exclamation" style="color: #d97706; font-size: 18px; flex-shrink: 0;"></i>
                <span>Perhatian: Jadwal KBM yang dipilih dijadwalkan pada hari <strong>{{ $selectedJadwal->hari }}</strong>, sedangkan tanggal yang dipilih adalah hari <strong>{{ $hariTarget }}</strong> ({{ \Carbon\Carbon::parse($targetDate)->translatedFormat('d F Y') }}). Pastikan data presensi dicatat pada tanggal KBM yang tepat.</span>
            </div>
            @if($matchingDateForSchedule !== $targetDate)
                <a href="{{ route('guru.absensi-siswa', ['tab' => $activeTab, 'id_jadwal' => $selectedJadwal->id_jadwal, 'tanggal' => $matchingDateForSchedule]) }}" style="background: #d97706; color: #ffffff; padding: 7px 14px; border-radius: 8px; font-weight: 800; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(217,119,6,0.25);">
                    <i class="fa-solid fa-calendar-check"></i> Sesuaikan Tanggal ke Hari {{ $selectedJadwal->hari }} ({{ $matchingDateFormatted }})
                </a>
            @endif
        </div>
    @endif

    <!-- Guru Izin Tidak Hadir Notice Banner -->
    @if(!empty($isGuruIzinTarget) && !empty($guruIzinTarget))
        <div class="notice-banner-responsive" style="background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); border: 1px solid #fecdd3; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #e11d48; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 800; color: #9f1239;">
                        Pemberitahuan: Anda Tercatat Izin Tidak Hadir Resmi pada Tanggal Ini
                    </div>
                    <div style="font-size: 13px; color: #4c0519; margin-top: 3px; font-weight: 600;">
                        Keterangan: <strong style="color: #881337;">{{ $guruIzinTarget->keterangan ?? $guruIzinTarget->alasan_izin ?? 'Izin Resmi' }}</strong>
                        &bull; Tanggal: <strong>{{ \Carbon\Carbon::parse($guruIzinTarget->tanggal_mulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($guruIzinTarget->tanggal_selesai)->translatedFormat('d M Y') }}</strong>
                    </div>
                    <div style="font-size: 12px; color: #9f1239; margin-top: 2px;">
                        <i class="fa-solid fa-circle-info"></i> Pengisian presensi dan jurnal mengajar kelas ini dialihkan kepada Guru Pengganti yang ditugaskan oleh Guru Piket. Form penyimpanan dikunci.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Info Banner Terkunci Jam / Hari / Tanggal untuk Tab Saya -->
    @if(!$isModeWali && !$canSavePresensi && !empty($timeLockReason))
        <div class="notice-banner-responsive" style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-left: 5px solid #64748b; border-radius: 14px; padding: 14px 18px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 13.5px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span>Status Form Presensi: Mode Baca Saja (Terkunci)</span>
                        <span style="background: #fee2e2; color: #991b1b; font-size: 11px; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                            <i class="fa-solid fa-lock"></i> Terkunci
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px; font-weight: 600; word-break: break-word;">
                        {{ $timeLockReason }}
                    </div>
                </div>
            </div>
            @if(!empty($selectedJadwal) && isset($weekDates[$selectedJadwal->hari]))
                @php
                    $schedMatchingDate = $weekDates[$selectedJadwal->hari];
                @endphp
                @if($schedMatchingDate !== $targetDate)
                    <a href="{{ route('guru.absensi-siswa', ['tab' => $activeTab, 'id_jadwal' => $selectedJadwal->id_jadwal, 'tanggal' => $schedMatchingDate]) }}" style="background: #2563eb; color: #ffffff; padding: 7px 14px; border-radius: 8px; font-weight: 800; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(37,99,235,0.25);">
                        <i class="fa-solid fa-calendar-check"></i> Buka Tanggal Jadwal ({{ \Carbon\Carbon::parse($schedMatchingDate)->translatedFormat('d M Y') }})
                    </a>
                @endif
            @endif
        </div>
    @endif

    <!-- Main Presensi Grid -->
    <div class="presensi-grid">
        
        <!-- Left: List of Students for Attendance -->
        <div class="main-presensi-box">
            
            <div class="card-header-presensi" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    Daftar Presensi Kehadiran Siswa
                </h2>
                <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
                    Total: <strong style="color: #0f172a;">{{ $siswas->count() }}</strong> Siswa
                </span>
            </div>

            @php
                $lockedDispenCount = $siswas->where('is_locked', true)->where('locked_status', 'Dispen')->count();
                $lockedSakitCount = $siswas->where('is_locked', true)->where('locked_status', 'Sakit')->count();
                $lockedIzinCount = $siswas->where('is_locked', true)->where('locked_status', 'Izin')->count();
            @endphp
            @if($lockedDispenCount > 0)
                <div style="background: #faf5ff; border: 1px solid #e9d5ff; color: #6b21a8; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-file-signature" style="color: #9333ea; font-size: 16px; flex-shrink: 0;"></i>
                    <span>Pemberitahuan Waka Kesiswaan & Guru Piket: Terdapat <strong>{{ $lockedDispenCount }} siswa dispensasi resmi</strong> pada jam ini. Status <em>Dispen</em> telah otomatis disematkan dan dikunci oleh sistem (tidak bisa diedit guru).</span>
                </div>
            @endif
            @if(($lockedSakitCount + $lockedIzinCount) > 0)
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-file-medical" style="color: #2563eb; font-size: 16px; flex-shrink: 0;"></i>
                    <span>Pemberitahuan Guru Piket: Terdapat <strong>{{ ($lockedSakitCount + $lockedIzinCount) }} siswa berhalangan hadir</strong> (Sakit: {{ $lockedSakitCount }}, Izin: {{ $lockedIzinCount }}) dalam Surat Izin Siswa. Status telah otomatis terisi dan dikunci oleh sistem (tidak bisa diedit guru).</span>
                </div>
            @endif

            <!-- Action Toolbar: Search, Reset & Filter Pills -->
            <div class="action-toolbar">
                <div class="search-row">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="inputCariSiswa" placeholder="Cari nama siswa atau NISN..." class="input-search-siswa">
                    </div>
                    <div class="search-row-actions">
                        <button type="button" id="btnResetSearch" class="btn-reset-search" title="Bersihkan Pencarian">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </button>
                        @if(!$isModeWali && $canSavePresensi)
                            <button type="button" id="btnSetSemuaHadir" class="btn-set-hadir" title="Tandai seluruh siswa sebagai Hadir">
                                <i class="fa-solid fa-check-double"></i> Set Semua Hadir
                            </button>
                        @endif
                    </div>
                </div>

                <div class="filter-pills">
                    <div class="pill-item active" data-filter="all">
                        Semua <span class="pill-badge" id="pillCountSemua">{{ $ringkasanPresensi['total'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="hadir">
                        Hadir <span class="pill-badge" id="pillCountHadir">{{ $ringkasanPresensi['hadir'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="sakit">
                        Sakit <span class="pill-badge" id="pillCountSakit" style="background: rgba(37,99,235,0.15); color: #1d4ed8;">{{ $ringkasanPresensi['sakit'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="izin">
                        Izin <span class="pill-badge" id="pillCountIzin" style="background: rgba(234,179,8,0.18); color: #a16207;">{{ $ringkasanPresensi['izin'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="alpa">
                        Alpa <span class="pill-badge" id="pillCountAlpa" style="background: rgba(220,38,38,0.15); color: #dc2626;">{{ $ringkasanPresensi['alpa'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="dispen">
                        Dispen <span class="pill-badge" id="pillCountDispen" style="background: rgba(147,51,234,0.15); color: #7e22ce;">{{ $ringkasanPresensi['dispen'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="telat">
                        Terlambat <span class="pill-badge" id="pillCountTelat" style="background: rgba(234,88,12,0.15); color: #c2410c;">{{ $ringkasanPresensi['telat'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Attendance Form -->
            <form id="formPresensi" method="POST" action="{{ route('guru.absensi-siswa.store') }}">
                @csrf
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal ? $selectedJadwal->id_jadwal : '' }}">
                <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                <input type="hidden" name="tanggal" value="{{ $targetDate }}">

                <div id="studentCardsContainer">
                    @forelse($siswas as $idx => $s)
                        @php
                            $nameArr = explode(' ', trim($s->nama_siswa));
                            $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                            $isLocked = !empty($s->is_locked);
                            $lockedStatus = $s->locked_status ?? null;
                            $lockedInfo = $s->locked_info ?? null;
                            $currStatus = $isLocked ? $lockedStatus : ($s->status_presensi ?? '');
                            if (!$isLocked && $currStatus === 'Dispen') {
                                $currStatus = '';
                            }
                        @endphp
                        <div class="student-card-item" data-id="{{ $s->id_siswa }}" data-nama="{{ strtolower($s->nama_siswa) }}" data-nisn="{{ $s->nisn }}" data-status="{{ $currStatus ? strtolower($currStatus) : 'hadir' }}" data-locked="{{ $isLocked ? 'true' : 'false' }}" data-locked-status="{{ $lockedStatus ?? '' }}" data-telat="{{ !empty($s->telat_info) ? 'true' : 'false' }}">
                            <div class="student-info">
                                <div class="avatar-initial">{{ $initials }}</div>
                                <div style="min-width: 0; flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        <div class="student-name" title="{{ $s->nama_siswa }}">{{ $s->nama_siswa }}</div>
                                        <span class="badge-status-tag tag-{{ $currStatus ? strtolower($currStatus) : 'hadir' }}" id="statusBadge_{{ $s->id_siswa }}">
                                            @if($isLocked)
                                                <i class="fa-solid fa-lock" style="font-size: 9px; margin-right: 2px;"></i>
                                            @endif
                                            {{ $currStatus ? $currStatus : 'Hadir' }}
                                        </span>
                                    </div>
                                    <div class="student-nisn">NISN {{ $s->nisn ?? '-' }}</div>

                                    <!-- Cross-system badges -->
                                    @if($isLocked)
                                        <div class="badge-cross-system" style="background: {{ $lockedStatus === 'Dispen' ? '#f3e8ff' : ($lockedStatus === 'Sakit' ? '#dbeafe' : '#fef9c3') }}; color: {{ $lockedStatus === 'Dispen' ? '#7e22ce' : ($lockedStatus === 'Sakit' ? '#1d4ed8' : '#a16207') }}; border: 1px solid {{ $lockedStatus === 'Dispen' ? '#d8b4fe' : ($lockedStatus === 'Sakit' ? '#bfdbfe' : '#fde047') }};">
                                            <i class="fa-solid fa-lock" style="font-size: 10px;"></i>
                                            <span><strong>{{ $lockedInfo['badge_title'] ?? ($lockedStatus . ' Terverifikasi') }}</strong> &bull; {{ Str::limit($lockedInfo['alasan'] ?? '', 40) }}</span>
                                        </div>
                                    @elseif($s->surat_izin_info)
                                        @php
                                            $jenisIzin = $s->surat_izin_info['jenis'] ?? '';
                                            $isIzinSakit = str_contains(strtolower($jenisIzin), 'sakit');
                                        @endphp
                                        <div class="badge-cross-system {{ $isIzinSakit ? 'badge-sakit-system' : 'badge-izin-system' }}" title="Alasan: {{ $s->surat_izin_info['keterangan'] }} ({{ $s->surat_izin_info['rentang'] }})">
                                            <i class="fa-solid {{ $isIzinSakit ? 'fa-file-medical' : 'fa-envelope-open-text' }}"></i>
                                            <span><strong>Surat {{ $s->surat_izin_info['kategori'] ?? $s->surat_izin_info['jenis'] }}</strong> ({{ $s->surat_izin_info['source'] }}): {{ Str::limit($s->surat_izin_info['keterangan'], 35) }} &bull; <span style="font-weight: 600; opacity: 0.85;">{{ $s->surat_izin_info['rentang'] }}</span></span>
                                        </div>
                                    @endif

                                    @if(!$isLocked && $s->dispen_info)
                                        <div class="badge-cross-system badge-dispen-system" title="Keperluan: {{ $s->dispen_info['alasan'] }}">
                                            <i class="fa-solid fa-id-card-clip"></i>
                                            <span><strong>Dispen Disetujui:</strong> {{ Str::limit($s->dispen_info['alasan'], 35) }}{{ $s->dispen_info['jam'] }}</span>
                                        </div>
                                    @endif

                                    @if($s->telat_info)
                                        <div class="badge-cross-system badge-telat-system" title="Terlambat Pukul {{ $s->telat_info['jam_terlambat'] }} WIB (Alasan: {{ $s->telat_info['alasan'] }})">
                                            <i class="fa-solid fa-user-clock" style="color: #ea580c;"></i>
                                            <span><strong>(Siswa Tersebut Telat):</strong> Jam {{ $s->telat_info['jam_terlambat'] }} WIB &bull; {{ Str::limit($s->telat_info['alasan'], 35) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- SIAD Action Options -->
                            @if($isModeWali)
                                <!-- Mode Pemantauan Kelas Perwalian (Murni Monitoring / View Only) -->
                                <div class="wali-status-wrap" style="display: flex; align-items: center; gap: 8px;">
                                    <span class="badge-status-tag tag-{{ $currStatus ? strtolower($currStatus) : 'hadir' }}" style="font-size: 12.5px; padding: 6px 14px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; font-weight: 800;">
                                        @if($isLocked)
                                            <i class="fa-solid fa-lock" style="font-size: 10px;"></i>
                                        @elseif($currStatus && in_array($currStatus, ['Sakit', 'Izin', 'Alpa']))
                                            <i class="fa-solid fa-triangle-exclamation" style="font-size: 11px;"></i>
                                        @else
                                            <i class="fa-solid fa-circle-check" style="font-size: 11px;"></i>
                                        @endif
                                        {{ $currStatus ? $currStatus : 'Hadir' }}
                                    </span>
                                </div>
                            @elseif(!$canSavePresensi)
                                <!-- Mode Terkunci pada Tab Saya (Di Luar Hari/Tanggal/Jam KBM) -->
                                <div class="siad-buttons" style="opacity: 0.65; pointer-events: none;" title="Presensi terkunci: hanya dapat diisi pada hari, tanggal dan jam pelajaran yang sesuai">
                                    <div title="Sakit (Terkunci)">
                                        <input type="radio" disabled class="siad-input siad-input-s" {{ $currStatus === 'Sakit' ? 'checked' : '' }}>
                                        <label class="siad-btn siad-btn-s {{ $currStatus === 'Sakit' ? 'locked-active-s' : 'locked-disabled' }}">
                                            @if($currStatus === 'Sakit') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else S @endif
                                        </label>
                                    </div>
                                    <div title="Izin (Terkunci)">
                                        <input type="radio" disabled class="siad-input siad-input-i" {{ $currStatus === 'Izin' ? 'checked' : '' }}>
                                        <label class="siad-btn siad-btn-i {{ $currStatus === 'Izin' ? 'locked-active-i' : 'locked-disabled' }}">
                                            @if($currStatus === 'Izin') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else I @endif
                                        </label>
                                    </div>
                                    <div title="Alpa (Terkunci)">
                                        <input type="radio" disabled class="siad-input siad-input-a" {{ $currStatus === 'Alpa' ? 'checked' : '' }}>
                                        <label class="siad-btn siad-btn-a {{ $currStatus === 'Alpa' ? 'locked-active-a' : 'locked-disabled' }}">
                                            @if($currStatus === 'Alpa') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else A @endif
                                        </label>
                                    </div>
                                    <div title="Dispen (Terkunci)">
                                        <input type="radio" disabled class="siad-input siad-input-d" {{ $currStatus === 'Dispen' ? 'checked' : '' }}>
                                        <label class="siad-btn siad-btn-d {{ $currStatus === 'Dispen' ? 'locked-active-d' : 'locked-disabled' }}">
                                            @if($currStatus === 'Dispen') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else D @endif
                                        </label>
                                    </div>
                                </div>
                            @else
                                <!-- Mode Aktif Simpan (Saat Jam Pelajaran Berlangsung) -->
                                <div class="siad-buttons">
                                    @if($isLocked)
                                        <!-- Hidden input to guarantee locked attendance submission -->
                                        <input type="hidden" name="absensi[{{ $s->id_siswa }}]" value="{{ $lockedStatus }}">

                                        <div title="Sakit (Terkunci oleh sistem)">
                                            <input type="radio" disabled class="siad-input siad-input-s" {{ $lockedStatus === 'Sakit' ? 'checked' : '' }}>
                                            <label class="siad-btn siad-btn-s {{ $lockedStatus === 'Sakit' ? 'locked-active-s' : 'locked-disabled' }}">
                                                 @if($lockedStatus === 'Sakit') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else S @endif
                                            </label>
                                        </div>

                                        <div title="Izin (Terkunci oleh sistem)">
                                            <input type="radio" disabled class="siad-input siad-input-i" {{ $lockedStatus === 'Izin' ? 'checked' : '' }}>
                                            <label class="siad-btn siad-btn-i {{ $lockedStatus === 'Izin' ? 'locked-active-i' : 'locked-disabled' }}">
                                                @if($lockedStatus === 'Izin') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else I @endif
                                            </label>
                                        </div>

                                        <div title="Alpa (Terkunci oleh sistem)">
                                            <input type="radio" disabled class="siad-input siad-input-a">
                                            <label class="siad-btn siad-btn-a locked-disabled">A</label>
                                        </div>

                                        <div title="Dispen (Terkunci oleh sistem)">
                                            <input type="radio" disabled class="siad-input siad-input-d" {{ $lockedStatus === 'Dispen' ? 'checked' : '' }}>
                                            <label class="siad-btn siad-btn-d {{ $lockedStatus === 'Dispen' ? 'locked-active-d' : 'locked-disabled' }}">
                                                @if($lockedStatus === 'Dispen') <i class="fa-solid fa-lock" style="font-size: 10px;"></i> @else D @endif
                                            </label>
                                        </div>
                                    @else
                                        <div title="Sakit (Klik untuk menandai / lepas tanda)">
                                            <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="s_{{ $s->id_siswa }}" value="Sakit" class="siad-input siad-input-s" {{ $currStatus === 'Sakit' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Sakit' ? 'true' : 'false' }}">
                                            <label for="s_{{ $s->id_siswa }}" class="siad-btn siad-btn-s">S</label>
                                        </div>

                                        <div title="Izin (Klik untuk menandai / lepas tanda)">
                                            <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="i_{{ $s->id_siswa }}" value="Izin" class="siad-input siad-input-i" {{ $currStatus === 'Izin' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Izin' ? 'true' : 'false' }}">
                                            <label for="i_{{ $s->id_siswa }}" class="siad-btn siad-btn-i">I</label>
                                        </div>

                                        <div title="Alpa (Klik untuk menandai / lepas tanda)">
                                            <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="a_{{ $s->id_siswa }}" value="Alpa" class="siad-input siad-input-a" {{ $currStatus === 'Alpa' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Alpa' ? 'true' : 'false' }}">
                                            <label for="a_{{ $s->id_siswa }}" class="siad-btn siad-btn-a">A</label>
                                        </div>

                                        <div title="Dispen hanya terisi otomatis dari sistem (surat dispen waka / guru piket)">
                                            <input type="radio" disabled class="siad-input siad-input-d">
                                            <label class="siad-btn siad-btn-d dispen-disabled" title="Dispen tidak bisa diisi manual oleh guru"><i class="fa-solid fa-lock" style="font-size: 10px;"></i></label>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                            <i class="fa-solid fa-users-slash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px;"></i>
                            <div style="font-size: 15px; font-weight: 700; color: #334155;">Tidak ada data siswa</div>
                            <div style="font-size: 13px;">Belum ada siswa terdaftar di kelas ini.</div>
                        </div>
                    @endforelse
                </div>

                <div id="noMatchMessage" style="display: none; text-align: center; padding: 36px 20px; color: #64748b; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; margin-top: 10px;">
                    <i class="fa-solid fa-user-xmark" style="font-size: 28px; color: #94a3b8; margin-bottom: 10px;"></i>
                    <div style="font-weight: 700; font-size: 14px; color: #334155;">Tidak ada siswa yang sesuai</div>
                    <div style="font-size: 12.5px; margin-top: 4px;">Periksa kembali kata kunci pencarian atau ganti filter status.</div>
                </div>

                <!-- Bottom Action Bar -->
                @if(!$isModeWali && $canSavePresensi)
                    <div class="bottom-action-bar" style="display: flex; align-items: center; justify-content: space-between; margin-top: 24px; padding-top: 18px; border-top: 1px solid #e2e8f0; flex-wrap: wrap; gap: 14px;">
                        <div style="font-size: 12.5px; color: #64748b; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i>
                            <span>Pastikan status kehadiran siswa telah diperiksa sebelum menekan tombol simpan.</span>
                        </div>
                        <button type="submit" class="btn-simpan-top" style="padding: 11px 24px; font-size: 13.5px; border-radius: 10px;">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Presensi Siswa
                        </button>
                    </div>
                @elseif($isModeWali)
                    <div class="bottom-action-bar" style="display: flex; align-items: center; justify-content: space-between; margin-top: 24px; padding: 14px 18px; background: #f0fdf4; border-radius: 12px; border: 1px solid #bbf7d0; flex-wrap: wrap; gap: 12px;">
                        <div style="font-size: 13px; color: #166534; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-shield-halved" style="color: #15803d; font-size: 16px;"></i>
                            <span>Mode Pemantauan Wali Kelas: Data presensi siswa dicatat oleh Guru Mata Pelajaran / Guru Piket sesuai jam KBM berlangsung.</span>
                        </div>
                        <span style="font-size: 12px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 5px 12px; border-radius: 8px; border: 1px solid #86efac; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-eye"></i> Hanya Pantau (Read-Only)
                        </span>
                    </div>
                @else
                    <div class="bottom-action-bar" style="display: flex; align-items: center; justify-content: space-between; margin-top: 24px; padding: 14px 18px; background: #f8fafc; border-radius: 12px; border: 1px solid #cbd5e1; flex-wrap: wrap; gap: 12px;">
                        <div style="font-size: 13px; color: #475569; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-lock" style="color: #64748b; font-size: 16px;"></i>
                            <span>{{ $timeLockReason ?: 'Pengisian dan penyimpanan presensi saat ini terkunci.' }}</span>
                        </div>
                        <span style="font-size: 12px; font-weight: 800; color: #475569; background: #e2e8f0; padding: 5px 12px; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-lock"></i> Form Terkunci
                        </span>
                    </div>
                @endif
            </form>

            @if($isModeWali && !empty($siswaAbsenPerwalianHariIni) && count($siswaAbsenPerwalianHariIni) > 0)
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 20px; margin-top: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-triangle-exclamation" style="color: #d97706;"></i>
                        Daftar Siswa Tidak Hadir Kelas Perwalian Hari Ini (Kumulatif KBM)
                    </h3>
                    
                    <!-- Desktop Table -->
                    <div class="wali-presensi-absen-desktop-table" style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%; box-sizing: border-box;">
                        <table style="width: 100%; min-width: 580px; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569;">Nama Siswa</th>
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569;">NISN</th>
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569;">Status</th>
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569;">Mata Pelajaran Terdampak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswaAbsenPerwalianHariIni as $idS => $abs)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 10px 14px; font-weight: 800; color: #1e293b;">{{ $abs['nama'] }}</td>
                                        <td style="padding: 10px 14px; color: #64748b;">{{ $abs['nisn'] }}</td>
                                        <td style="padding: 10px 14px;">
                                            <span class="badge-status-tag tag-{{ strtolower(trim($abs['status'])) }}">
                                                {{ $abs['status'] }}
                                            </span>
                                        </td>
                                        <td style="padding: 10px 14px; color: #475569;">
                                            {{ implode(', ', $abs['mapel_list']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="wali-presensi-absen-mobile-cards">
                        @foreach($siswaAbsenPerwalianHariIni as $idS => $abs)
                            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                    <div style="font-weight: 800; font-size: 13.5px; color: #0f172a;">{{ $abs['nama'] }}</div>
                                    <span class="badge-status-tag tag-{{ strtolower(trim($abs['status'])) }}" style="font-size: 11px; padding: 2px 8px;">
                                        {{ $abs['status'] }}
                                    </span>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    NISN: <strong style="color: #334155;">{{ $abs['nisn'] }}</strong>
                                </div>
                                <div style="font-size: 12px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 10px; margin-top: 2px;">
                                    <i class="fa-solid fa-book" style="color: #64748b; margin-right: 4px;"></i> Mapel: <strong>{{ implode(', ', $abs['mapel_list']) }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Side Widgets -->
        <div>
            <!-- Ringkasan Presensi -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Ringkasan Presensi</span>
                    <span style="font-size: 11px; background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 6px; font-weight: 700;">Live Realtime</span>
                </div>
                <div>
                    <div class="summary-row">
                        <span class="summary-label">Jumlah siswa</span>
                        <span class="summary-val" id="counterTotal">{{ $ringkasanPresensi['total'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #16a34a;"></span> Hadir</span>
                        <span class="summary-val" id="counterHadir" style="color: #16a34a;">{{ $ringkasanPresensi['hadir'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #2563eb;"></span> Sakit</span>
                        <span class="summary-val" id="counterSakit" style="color: #1d4ed8;">{{ $ringkasanPresensi['sakit'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #eab308;"></span> Izin</span>
                        <span class="summary-val" id="counterIzin" style="color: #a16207;">{{ $ringkasanPresensi['izin'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #dc2626;"></span> Alpa</span>
                        <span class="summary-val" id="counterAlpa" style="color: #dc2626;">{{ $ringkasanPresensi['alpa'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #9333ea;"></span> Dispen</span>
                        <span class="summary-val" id="counterDispen" style="color: #7e22ce;">{{ $ringkasanPresensi['dispen'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #ea580c;"></span> Terlambat</span>
                        <span class="summary-val" id="counterTelat" style="color: #c2410c;">{{ $ringkasanPresensi['telat'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Absensi Rendah -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Riwayat Absensi Rendah</span>
                    <span style="font-size: 11px; color: #64748b; font-weight: 600;">1–2x Bulan Ini</span>
                </div>
                <div>
                    @forelse($absensiRendah as $ar)
                        <div style="margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f8fafc;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">{{ $ar->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $ar->keterangan }}</div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8; font-style: italic;">
                            Tidak ada catatan absensi rendah bulan ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Absensi Tinggi -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Riwayat Absensi Tinggi</span>
                    <span style="font-size: 11px; color: #dc2626; font-weight: 700;">≥ 3x Bulan Ini</span>
                </div>
                <div>
                    @forelse($absensiTinggi as $at)
                        <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #991b1b;">{{ $at->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $at->keterangan }}</div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8; font-style: italic;">
                            Tidak ada catatan absensi tinggi bulan ini (semua tertib).
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentCards = document.querySelectorAll('.student-card-item');
    const inputCari = document.getElementById('inputCariSiswa');
    const btnResetSearch = document.getElementById('btnResetSearch');
    const btnSetSemuaHadir = document.getElementById('btnSetSemuaHadir');
    const filterPills = document.querySelectorAll('.pill-item');
    const noMatchMessage = document.getElementById('noMatchMessage');

    let currentFilter = 'all';

    // 1. Recalculate counters and badges
    function updatePresensiUI() {
        let total = studentCards.length;
        let sakit = 0, izin = 0, alpa = 0, dispen = 0, telat = 0;

        studentCards.forEach(card => {
            const id = card.dataset.id;
            const isLocked = card.dataset.locked === 'true';
            const lockedStatus = card.dataset.lockedStatus || '';
            const isTelat = card.dataset.telat === 'true';
            if (isTelat) telat++;

            const badge = document.getElementById('statusBadge_' + id);
            let status = 'hadir';

            if (isLocked && lockedStatus) {
                status = lockedStatus.toLowerCase();
                if (status === 'sakit') sakit++;
                else if (status === 'izin') izin++;
                else if (status === 'alpa') alpa++;
                else if (status === 'dispen') dispen++;

                if (badge) {
                    badge.className = 'badge-status-tag tag-' + status;
                    badge.innerHTML = '<i class="fa-solid fa-lock" style="font-size: 9px; margin-right: 2px;"></i> ' + lockedStatus;
                }
            } else {
                const radios = card.querySelectorAll('input[type="radio"]:not([disabled])');
                if (radios.length > 0) {
                    let checkedRadio = null;

                    radios.forEach(r => {
                        if (r.checked) checkedRadio = r;
                    });

                    if (checkedRadio) {
                        const val = checkedRadio.value;
                        if (val === 'Sakit') { sakit++; status = 'sakit'; }
                        else if (val === 'Izin') { izin++; status = 'izin'; }
                        else if (val === 'Alpa') { alpa++; status = 'alpa'; }
                        else if (val === 'Dispen') { dispen++; status = 'dispen'; }

                        if (badge) {
                            badge.className = 'badge-status-tag tag-' + status;
                            badge.textContent = val;
                        }
                    } else {
                        if (badge) {
                            badge.className = 'badge-status-tag tag-hadir';
                            badge.textContent = 'Hadir';
                        }
                    }
                } else {
                    // Mode Wali Kelas atau Form Terkunci: hitung dari status yang sudah disematkan server
                    const presetStatus = (card.dataset.status || 'hadir').toLowerCase();
                    if (presetStatus === 'sakit') { sakit++; status = 'sakit'; }
                    else if (presetStatus === 'izin') { izin++; status = 'izin'; }
                    else if (presetStatus === 'alpa') { alpa++; status = 'alpa'; }
                    else if (presetStatus === 'dispen') { dispen++; status = 'dispen'; }
                    else { status = 'hadir'; }
                }
            }

            card.dataset.status = status;
        });

        let hadir = Math.max(0, total - (sakit + izin + alpa + dispen));

        // Update right sidebar
        document.getElementById('counterTotal').textContent = total;
        document.getElementById('counterHadir').textContent = hadir;
        document.getElementById('counterSakit').textContent = sakit;
        document.getElementById('counterIzin').textContent = izin;
        document.getElementById('counterAlpa').textContent = alpa;
        document.getElementById('counterDispen').textContent = dispen;
        const counterTelatEl = document.getElementById('counterTelat');
        if (counterTelatEl) counterTelatEl.textContent = telat;

        // Update filter pills
        document.getElementById('pillCountSemua').textContent = total;
        document.getElementById('pillCountHadir').textContent = hadir;
        document.getElementById('pillCountSakit').textContent = sakit;
        document.getElementById('pillCountIzin').textContent = izin;
        document.getElementById('pillCountAlpa').textContent = alpa;
        document.getElementById('pillCountDispen').textContent = dispen;
        const pillTelatEl = document.getElementById('pillCountTelat');
        if (pillTelatEl) pillTelatEl.textContent = telat;

        filterRows();
    }

    // 2. Filter & Search logic
    function filterRows() {
        const query = (inputCari.value || '').trim().toLowerCase();
        let visibleCount = 0;

        studentCards.forEach(card => {
            const nama = card.dataset.nama || '';
            const nisn = card.dataset.nisn || '';
            const status = card.dataset.status || 'hadir';
            const isTelat = card.dataset.telat === 'true';

            const matchesSearch = query === '' || nama.includes(query) || nisn.includes(query);
            let matchesFilter = false;

            if (currentFilter === 'all') {
                matchesFilter = true;
            } else if (currentFilter === 'telat') {
                matchesFilter = isTelat || (status === 'telat' || status === 'terlambat');
            } else {
                matchesFilter = (status === currentFilter);
            }

            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noMatchMessage) {
            noMatchMessage.style.display = (visibleCount === 0 && studentCards.length > 0) ? 'block' : 'none';
        }
    }

    // 3. Radio Toggle Mechanism
    document.querySelectorAll('.siad-input').forEach(radio => {
        radio.addEventListener('click', function(e) {
            if (this.disabled) {
                e.preventDefault();
                return;
            }

            const isCurrentlyChecked = this.dataset.checked === 'true';
            const groupName = this.name;

            // Clear dataset.checked for all radios in this student card
            if (groupName) {
                document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                    r.dataset.checked = 'false';
                });
            }

            if (isCurrentlyChecked) {
                // Toggle off -> Hadir
                this.checked = false;
                this.dataset.checked = 'false';
            } else {
                // Check this one
                this.checked = true;
                this.dataset.checked = 'true';
            }

            updatePresensiUI();
        });
    });

    // 4. Search input event
    inputCari.addEventListener('input', filterRows);

    // 5. Reset search
    btnResetSearch.addEventListener('click', function() {
        inputCari.value = '';
        filterRows();
        inputCari.focus();
    });

    // 6. Set Semua Hadir Button (Respects locked official statuses)
    if (btnSetSemuaHadir) {
        btnSetSemuaHadir.addEventListener('click', function() {
            studentCards.forEach(card => {
                if (card.dataset.locked === 'true') {
                    return; // Jangan reset siswa yang terkunci resmi (Sakit/Izin/Dispen)
                }
                card.querySelectorAll('.siad-input:not([disabled])').forEach(radio => {
                    radio.checked = false;
                    radio.dataset.checked = 'false';
                });
            });
            updatePresensiUI();
        });
    }

    // 7. Filter Pills Click
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterRows();
        });
    });

    // 8. Jadwal selection change: auto-sync date if option has data-date
    const selectJadwal = document.getElementById('selectJadwal');
    const inputTanggal = document.getElementById('inputTanggal');
    const filterForm = document.getElementById('filterForm');
    if (selectJadwal && inputTanggal && filterForm) {
        selectJadwal.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            if (selectedOpt && selectedOpt.dataset.date) {
                inputTanggal.value = selectedOpt.dataset.date;
            }
            filterForm.submit();
        });
    }

    // Initial calculation on load
    updatePresensiUI();
});
</script>
@endsection
