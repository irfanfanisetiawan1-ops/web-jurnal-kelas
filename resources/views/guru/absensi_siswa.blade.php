@extends('layouts.guru')

@section('title', 'Presensi Siswa — EDU JOURNAL')
@section('header_title', 'Presensi Siswa')

@section('styles')
<style>
    /* =========================================================
       PAGE WRAPPER & 1-COLUMN FULL-WIDTH LAYOUT
       Consistent with Pengumuman, Jadwal, and Jurnal Harian
       ========================================================= */
    .presensi-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    /* Save Button & Bottom Action Bar */
    .presensi-bottom-action-bar {
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .bottom-action-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
    }

    .btn-simpan-bottom,
    .btn-simpan-top {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        padding: 11px 28px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-simpan-bottom:hover,
    .btn-simpan-top:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }

    .btn-simpan-bottom:active,
    .btn-simpan-top:active {
        transform: translateY(0);
    }

    @media (max-width: 640px) {
        .presensi-bottom-action-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .btn-simpan-bottom {
            justify-content: center;
            width: 100%;
        }
    }

    /* 2. Selector Toolbar (Full Width) */
    .selector-bar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 14px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .selector-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .selector-label {
        font-size: 12.5px;
        font-weight: 800;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .select-custom {
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .select-custom:focus {
        border-color: #3b82f6;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .status-badge-filled {
        font-size: 11.5px;
        font-weight: 800;
        background: #ecfdf5;
        color: #059669;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid #a7f3d0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge-empty {
        font-size: 11.5px;
        font-weight: 800;
        background: #fffbeb;
        color: #b45309;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid #fde68a;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* 3. Card Ringkasan Presensi (Full Width Mini Stat Cards Grid) */
    .summary-section-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 18px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }

    .summary-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .summary-card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .summary-circle-icon {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
        flex-shrink: 0;
    }

    .summary-card-title {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .summary-card-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0 0;
        font-weight: 500;
    }

    /* Realtime Pulsing Dot */
    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        animation: pulseGreen 2s infinite;
        display: inline-block;
    }

    .badge-live-realtime {
        font-size: 11px;
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* 6 Horizontal Mini Stat Cards */
    .summary-stat-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }

    @media (max-width: 1100px) {
        .summary-stat-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
    }

    @media (max-width: 640px) {
        .summary-stat-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }

    .stat-mini-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-mini-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .stat-mini-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 8px;
    }

    .stat-mini-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stat-mini-icon-circle {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .icon-bg-total  { background: #f1f5f9; color: #475569; }
    .icon-bg-hadir  { background: #ecfdf5; color: #10b981; }
    .icon-bg-sakit  { background: #fffbeb; color: #f59e0b; }
    .icon-bg-izin   { background: #f0f9ff; color: #0ea5e9; }
    .icon-bg-alpa   { background: #fef2f2; color: #ef4444; }
    .icon-bg-dispen { background: #f5f3ff; color: #8b5cf6; }

    .stat-mini-number {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .color-hadir  { color: #16a34a; }
    .color-sakit  { color: #d97706; }
    .color-izin   { color: #0284c7; }
    .color-alpa   { color: #dc2626; }
    .color-dispen { color: #7c3aed; }

    .stat-mini-subtext {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 5px;
    }

    /* 4. Card Daftar Presensi (Full Width) */
    .main-presensi-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 22px 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }

    .main-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .main-box-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .main-box-count {
        font-size: 12px;
        color: #475569;
        font-weight: 700;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Action Toolbar: Search & Filter Pills */
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
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .search-input-wrapper i.search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .input-search-siswa {
        width: 100%;
        padding: 9px 14px 9px 36px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: all 0.15s ease;
    }

    .input-search-siswa:focus {
        border-color: #3b82f6;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-reset-search {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 13px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-reset-search:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-set-hadir {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 12.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-set-hadir:hover {
        background: #d1fae5;
        color: #047857;
        border-color: #6ee7b7;
        transform: translateY(-1px);
    }

    /* Filter Pills */
    .filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .pill-item {
        padding: 6px 13px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
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
        color: #334155;
    }

    .pill-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        transition: all 0.15s ease;
    }

    /* Distinct Active Color Per Status */
    .pill-item[data-filter="all"].active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
    }
    .pill-item[data-filter="all"].active .pill-badge {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .pill-item[data-filter="hadir"].active {
        background: #16a34a;
        color: #ffffff;
        border-color: #16a34a;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.25);
    }
    .pill-item[data-filter="hadir"].active .pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .pill-item[data-filter="sakit"].active {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
        box-shadow: 0 2px 8px rgba(217, 119, 6, 0.25);
    }
    .pill-item[data-filter="sakit"].active .pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .pill-item[data-filter="izin"].active {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
    }
    .pill-item[data-filter="izin"].active .pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .pill-item[data-filter="alpa"].active {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
    }
    .pill-item[data-filter="alpa"].active .pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .pill-item[data-filter="dispen"].active {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.25);
    }
    .pill-item[data-filter="dispen"].active .pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Full-Width Student Card Row */
    .student-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .student-card-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .student-card-item {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .siad-buttons {
            justify-content: flex-end;
        }
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
        border-radius: 12px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #334155;
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(0,0,0,0.05);
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
        font-weight: 500;
    }

    /* Badges for Surat Izin, Dispen, Telat */
    .badge-cross-system {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 6px;
        margin-top: 5px;
    }

    .badge-izin-system {
        background: #f0f9ff;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .badge-dispen-system {
        background: #f5f3ff;
        color: #6b21a8;
        border: 1px solid #ddd6fe;
    }

    .badge-telat-system {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
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
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .tag-sakit {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .tag-izin {
        background: #f0f9ff;
        color: #0284c7;
        border: 1px solid #bae6fd;
    }

    .tag-alpa {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .tag-dispen {
        background: #f5f3ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    /* SIAD Radio Action Buttons */
    .siad-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }

    .siad-btn {
        width: 38px;
        height: 38px;
        border-radius: 9px;
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
        color: #0f172a;
    }

    .siad-input { display: none; }

    /* Modern Active SIAD Colors */
    .siad-input-s:checked + .siad-btn-s {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.35);
    }

    .siad-input-i:checked + .siad-btn-i {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 3px 8px rgba(2, 132, 199, 0.35);
    }

    .siad-input-a:checked + .siad-btn-a {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.35);
    }

    .siad-input-d:checked + .siad-btn-d {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        box-shadow: 0 3px 8px rgba(124, 58, 237, 0.35);
    }

    /* 5. Riwayat Absensi (Bottom 2-Column Grid) */
    .bottom-history-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 800px) {
        .bottom-history-grid {
            grid-template-columns: 1fr;
        }
    }

    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 18px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }

    .widget-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        gap: 10px;
    }

    .widget-header-title-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .widget-circle-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #ffffff;
        flex-shrink: 0;
    }

    .icon-circle-amber {
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        box-shadow: 0 3px 10px rgba(217, 119, 6, 0.25);
    }

    .icon-circle-rose {
        background: linear-gradient(135deg, #f87171 0%, #dc2626 100%);
        box-shadow: 0 3px 10px rgba(220, 38, 38, 0.25);
    }

    .widget-title-text {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* Absence History List Items */
    .history-list-item {
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f8fafc;
    }
    .history-list-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .history-name-rendah {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .history-name-tinggi {
        font-size: 13px;
        font-weight: 800;
        color: #b91c1c;
    }

    .history-desc-pill {
        display: inline-block;
        font-size: 11.5px;
        color: #64748b;
        margin-top: 3px;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="presensi-page-wrapper">

    <!-- Flash Notification -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700;">
                <i class="fa-solid fa-circle-check" style="font-size: 16px; color: #10b981;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 15px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- 1. Filter & Schedule Selector Bar (Full Width) -->
    <div class="selector-bar">
        <form id="filterForm" method="GET" action="{{ route('guru.absensi-siswa') }}" style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 14px; margin: 0;">
            <div class="selector-group">
                <label for="selectJadwal" class="selector-label">
                    <i class="fa-solid fa-calendar-days" style="color: #3b82f6;"></i> Jadwal / Kelas:
                </label>
                <select name="id_jadwal" id="selectJadwal" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                    @if($jadwals->isNotEmpty())
                        <optgroup label="Jadwal Mengajar">
                            @foreach($jadwals as $j)
                                @php
                                    $mulai = $j->jamMulai ? substr($j->jamMulai->jam_mulai, 0, 5) : '';
                                    $selesai = $j->jamSelesai ? substr($j->jamSelesai->jam_selesai, 0, 5) : '';
                                    $jamLabel = ($mulai && $selesai) ? "({$mulai} - {$selesai})" : '';
                                    $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal && !$isModeWali);
                                @endphp
                                <option value="{{ $j->id_jadwal }}" {{ $isSelected ? 'selected' : '' }}>
                                    [{{ $j->hari }}] {{ $j->mapel->nama_mapel ?? 'Mapel' }} – {{ $j->kelas->nama_kelas ?? 'Kelas' }} {{ $jamLabel }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($isWaliKelas && $kelasWali)
                        <optgroup label="Kelas Perwalian (Wali Kelas)">
                            <option value="wali" {{ $isModeWali ? 'selected' : '' }}>
                                [Wali Kelas] Presensi Harian Kelas {{ $kelasWali->nama_kelas }}
                            </option>
                        </optgroup>
                    @endif
                </select>
            </div>

            <div class="selector-group">
                <label for="inputTanggal" class="selector-label">
                    <i class="fa-solid fa-clock" style="color: #3b82f6;"></i> Tanggal:
                </label>
                <input type="date" name="tanggal" id="inputTanggal" value="{{ $targetDate }}" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                
                @if($existingJurnal)
                    <span class="status-badge-filled" title="Presensi tanggal ini telah tercatat di Jurnal">
                        <i class="fa-solid fa-circle-check"></i> Sudah Terisi
                    </span>
                @else
                    <span class="status-badge-empty" title="Presensi tanggal ini belum disimpan di Jurnal">
                        <i class="fa-solid fa-clock-rotate-left"></i> Belum Diisi
                    </span>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Card Ringkasan Presensi (Full Width Horizontal Mini Stat Cards) -->
    <div class="summary-section-card">
        <div class="summary-card-header">
            <div class="summary-card-header-left">
                <div class="summary-circle-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div>
                    <h3 class="summary-card-title">Ringkasan Presensi Kehadiran</h3>
                    <p class="summary-card-subtitle">Kalkulasi status kehadiran seluruh siswa di kelas aktif</p>
                </div>
            </div>
            <span class="badge-live-realtime" title="Kalkulasi instan pada perubahan status">
                <span class="pulse-dot"></span> Live Realtime
            </span>
        </div>

        <div class="summary-stat-grid">
            <!-- Card 1: Total Siswa -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Jumlah Siswa</span>
                    <div class="stat-mini-icon-circle icon-bg-total">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="stat-mini-number" id="counterTotal">{{ $ringkasanPresensi['total'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Total terdaftar</div>
            </div>

            <!-- Card 2: Hadir -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Hadir</span>
                    <div class="stat-mini-icon-circle icon-bg-hadir">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="stat-mini-number color-hadir" id="counterHadir">{{ $ringkasanPresensi['hadir'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Mengikuti KBM</div>
            </div>

            <!-- Card 3: Sakit -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Sakit</span>
                    <div class="stat-mini-icon-circle icon-bg-sakit">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                </div>
                <div class="stat-mini-number color-sakit" id="counterSakit">{{ $ringkasanPresensi['sakit'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Dengan keterangan</div>
            </div>

            <!-- Card 4: Izin -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Izin</span>
                    <div class="stat-mini-icon-circle icon-bg-izin">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                </div>
                <div class="stat-mini-number color-izin" id="counterIzin">{{ $ringkasanPresensi['izin'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Surat / izin piket</div>
            </div>

            <!-- Card 5: Alpa -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Alpa</span>
                    <div class="stat-mini-icon-circle icon-bg-alpa">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <div class="stat-mini-number color-alpa" id="counterAlpa">{{ $ringkasanPresensi['alpa'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Tanpa keterangan</div>
            </div>

            <!-- Card 6: Dispen -->
            <div class="stat-mini-card">
                <div class="stat-mini-top">
                    <span class="stat-mini-label">Dispen</span>
                    <div class="stat-mini-icon-circle icon-bg-dispen">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                </div>
                <div class="stat-mini-number color-dispen" id="counterDispen">{{ $ringkasanPresensi['dispen'] ?? 0 }}</div>
                <div class="stat-mini-subtext">Disetujui Waka</div>
            </div>
        </div>
    </div>

    <!-- 4. Card Daftar Presensi Kehadiran Siswa (Full Width) -->
    <div class="main-presensi-box">
        
        <div class="main-box-header">
            <h2 class="main-box-title">
                <i class="fa-solid fa-list-check" style="color: #3b82f6; font-size: 15px;"></i>
                Daftar Presensi Kehadiran Siswa
            </h2>
            <span class="main-box-count">
                Total: <strong style="color: #0f172a;">{{ $siswas->count() }}</strong> Siswa
            </span>
        </div>

        <!-- Action Toolbar: Search, Reset & Filter Pills -->
        <div class="action-toolbar">
            <div class="search-row">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="inputCariSiswa" placeholder="Cari nama siswa atau NISN..." class="input-search-siswa">
                </div>
                <button type="button" id="btnResetSearch" class="btn-reset-search" title="Bersihkan Pencarian">
                    <i class="fa-solid fa-xmark"></i> Reset
                </button>
                <button type="button" id="btnSetSemuaHadir" class="btn-set-hadir" title="Tandai seluruh siswa sebagai Hadir">
                    <i class="fa-solid fa-check-double"></i> Set Semua Hadir
                </button>
            </div>

            <div class="filter-pills">
                <div class="pill-item active" data-filter="all">
                    Semua <span class="pill-badge" id="pillCountSemua">{{ $ringkasanPresensi['total'] }}</span>
                </div>
                <div class="pill-item" data-filter="hadir">
                    Hadir <span class="pill-badge" id="pillCountHadir">{{ $ringkasanPresensi['hadir'] }}</span>
                </div>
                <div class="pill-item" data-filter="sakit">
                    Sakit <span class="pill-badge" id="pillCountSakit">{{ $ringkasanPresensi['sakit'] }}</span>
                </div>
                <div class="pill-item" data-filter="izin">
                    Izin <span class="pill-badge" id="pillCountIzin">{{ $ringkasanPresensi['izin'] }}</span>
                </div>
                <div class="pill-item" data-filter="alpa">
                    Alpa <span class="pill-badge" id="pillCountAlpa">{{ $ringkasanPresensi['alpa'] }}</span>
                </div>
                <div class="pill-item" data-filter="dispen">
                    Dispen <span class="pill-badge" id="pillCountDispen">{{ $ringkasanPresensi['dispen'] }}</span>
                </div>
            </div>
        </div>

        <!-- Attendance Form -->
        <form id="formPresensi" method="POST" action="{{ route('guru.absensi-siswa.store') }}">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $isModeWali ? 'wali' : ($selectedJadwal ? $selectedJadwal->id_jadwal : '') }}">
            <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
            <input type="hidden" name="tanggal" value="{{ $targetDate }}">

            <div id="studentCardsContainer">
                @forelse($siswas as $idx => $s)
                    @php
                        $nameArr = explode(' ', trim($s->nama_siswa));
                        $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                        $currStatus = $s->status_presensi ?? '';
                    @endphp
                    <div class="student-card-item" data-id="{{ $s->id_siswa }}" data-nama="{{ strtolower($s->nama_siswa) }}" data-nisn="{{ $s->nisn }}" data-status="{{ $currStatus ? strtolower($currStatus) : 'hadir' }}">
                        <div class="student-info">
                            <div class="avatar-initial">{{ $initials }}</div>
                            <div style="min-width: 0; flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <div class="student-name" title="{{ $s->nama_siswa }}">{{ $s->nama_siswa }}</div>
                                    <span class="badge-status-tag tag-{{ $currStatus ? strtolower($currStatus) : 'hadir' }}" id="statusBadge_{{ $s->id_siswa }}">
                                        {{ $currStatus ? $currStatus : 'Hadir' }}
                                    </span>
                                </div>
                                <div class="student-nisn">NISN {{ $s->nisn ?? '-' }}</div>

                                <!-- Cross-system badges -->
                                @if($s->surat_izin_info)
                                    <div class="badge-cross-system badge-izin-system" title="Alasan: {{ $s->surat_izin_info['keterangan'] }} ({{ $s->surat_izin_info['rentang'] }})">
                                        <i class="fa-solid fa-envelope-open-text"></i>
                                        <span><strong>Surat {{ $s->surat_izin_info['kategori'] ?? $s->surat_izin_info['jenis'] }}</strong> ({{ $s->surat_izin_info['source'] }}): {{ Str::limit($s->surat_izin_info['keterangan'], 45) }} &bull; <span style="font-weight: 600; opacity: 0.85;">{{ $s->surat_izin_info['rentang'] }}</span></span>
                                    </div>
                                @endif

                                @if($s->dispen_info)
                                    <div class="badge-cross-system badge-dispen-system" title="Keperluan: {{ $s->dispen_info['alasan'] }}">
                                        <i class="fa-solid fa-id-card-clip"></i>
                                        <span><strong>Dispen Disetujui:</strong> {{ Str::limit($s->dispen_info['alasan'], 45) }}{{ $s->dispen_info['jam'] }}</span>
                                    </div>
                                @endif

                                @if($s->telat_info)
                                    <div class="badge-cross-system badge-telat-system" title="Terlambat Pukul {{ $s->telat_info['jam_terlambat'] }} WIB (Alasan: {{ $s->telat_info['alasan'] }})">
                                        <i class="fa-solid fa-user-clock" style="color: #d97706;"></i>
                                        <span><strong>(Siswa Tersebut Telat):</strong> Jam {{ $s->telat_info['jam_terlambat'] }} WIB &bull; {{ Str::limit($s->telat_info['alasan'], 45) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- SIAD Radio Options (Toggleable) -->
                        <div class="siad-buttons">
                            <div title="Sakit">
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="s_{{ $s->id_siswa }}" value="Sakit" class="siad-input siad-input-s" {{ $currStatus === 'Sakit' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Sakit' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                <label for="s_{{ $s->id_siswa }}" class="siad-btn siad-btn-s" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">S</label>
                            </div>

                            <div title="Izin">
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="i_{{ $s->id_siswa }}" value="Izin" class="siad-input siad-input-i" {{ $currStatus === 'Izin' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Izin' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                <label for="i_{{ $s->id_siswa }}" class="siad-btn siad-btn-i" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">I</label>
                            </div>

                            <div title="Alpa / Tanpa Keterangan">
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="a_{{ $s->id_siswa }}" value="Alpa" class="siad-input siad-input-a" {{ $currStatus === 'Alpa' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Alpa' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                <label for="a_{{ $s->id_siswa }}" class="siad-btn siad-btn-a" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">A</label>
                            </div>

                            <div title="{{ $s->dispen_info ? 'Dispensasi Resmi Disetujui Waka Kesiswaan' : 'Opsi Dispen dikunci (hanya dapat diisi otomatis jika disetujui Waka Kesiswaan)' }}">
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="d_{{ $s->id_siswa }}" value="Dispen" class="siad-input siad-input-d" {{ $currStatus === 'Dispen' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Dispen' ? 'true' : 'false' }}" {{ !$s->dispen_info ? 'disabled' : '' }}>
                                <label for="d_{{ $s->id_siswa }}" class="siad-btn siad-btn-d" style="{{ !$s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">D</label>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                        <i class="fa-solid fa-users-slash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px;"></i>
                        <div style="font-size: 14.5px; font-weight: 700; color: #334155;">Tidak ada data siswa</div>
                        <div style="font-size: 12.5px; margin-top: 4px;">Belum ada siswa terdaftar di kelas ini.</div>
                    </div>
                @endforelse
            </div>

            <div id="noMatchMessage" style="display: none; text-align: center; padding: 36px 20px; color: #64748b; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; margin-top: 10px;">
                <i class="fa-solid fa-user-xmark" style="font-size: 28px; color: #94a3b8; margin-bottom: 10px;"></i>
                <div style="font-weight: 700; font-size: 14px; color: #334155;">Tidak ada siswa yang sesuai</div>
                <div style="font-size: 12.5px; margin-top: 4px;">Periksa kembali kata kunci pencarian atau ganti filter status.</div>
            </div>

            <!-- Bottom Save Action Bar inside Daftar Presensi Container -->
            <div class="presensi-bottom-action-bar">
                <div class="bottom-action-info">
                    <i class="fa-solid fa-circle-info" style="color: #3b82f6;"></i>
                    <span>Pastikan data presensi telah diperiksa dengan benar sebelum disimpan.</span>
                </div>
                <button type="button" onclick="document.getElementById('formPresensi').submit()" class="btn-simpan-bottom" title="Simpan data presensi">
                    <i class="fa-solid fa-check"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- 5. Riwayat Absensi (Bottom 2-Column Grid) -->
    <div class="bottom-history-grid">
        <!-- Riwayat Absensi Rendah -->
        <div class="widget-card">
            <div class="widget-header-row">
                <div class="widget-header-title-left">
                    <div class="widget-circle-icon icon-circle-amber">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h3 class="widget-title-text">Riwayat Absensi Rendah</h3>
                </div>
                <span style="font-size: 11px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 2px 8px; border-radius: 6px; font-weight: 700;">
                    1–2x Bulan Ini
                </span>
            </div>
            <div>
                @forelse($absensiRendah as $ar)
                    <div class="history-list-item">
                        <div class="history-name-rendah">{{ $ar->nama_siswa }}</div>
                        <span class="history-desc-pill">{{ $ar->keterangan }}</span>
                    </div>
                @empty
                    <div style="font-size: 12.5px; color: #94a3b8; font-style: italic; padding: 6px 0;">
                        <i class="fa-solid fa-check" style="color: #10b981; margin-right: 4px;"></i> Tidak ada catatan absensi rendah bulan ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Riwayat Absensi Tinggi -->
        <div class="widget-card">
            <div class="widget-header-row">
                <div class="widget-header-title-left">
                    <div class="widget-circle-icon icon-circle-rose">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="widget-title-text">Riwayat Absensi Tinggi</h3>
                </div>
                <span style="font-size: 11px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                    ≥ 3x Bulan Ini
                </span>
            </div>
            <div>
                @forelse($absensiTinggi as $at)
                    <div class="history-list-item">
                        <div class="history-name-tinggi">{{ $at->nama_siswa }}</div>
                        <span class="history-desc-pill" style="color: #991b1b; font-weight: 600;">{{ $at->keterangan }}</span>
                    </div>
                @empty
                    <div style="font-size: 12.5px; color: #94a3b8; font-style: italic; padding: 6px 0;">
                        <i class="fa-solid fa-circle-check" style="color: #10b981; margin-right: 4px;"></i> Semua siswa tertib bulan ini (tidak ada absensi tinggi).
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
        let sakit = 0, izin = 0, alpa = 0, dispen = 0;

        studentCards.forEach(card => {
            const id = card.dataset.id;
            const radios = card.querySelectorAll('input[type="radio"]');
            let checkedRadio = null;

            radios.forEach(r => {
                if (r.checked) checkedRadio = r;
            });

            const badge = document.getElementById('statusBadge_' + id);
            let status = 'hadir';

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

            card.dataset.status = status;
        });

        let hadir = Math.max(0, total - (sakit + izin + alpa + dispen));

        // Update horizontal summary cards
        const elTotal = document.getElementById('counterTotal');
        const elHadir = document.getElementById('counterHadir');
        const elSakit = document.getElementById('counterSakit');
        const elIzin = document.getElementById('counterIzin');
        const elAlpa = document.getElementById('counterAlpa');
        const elDispen = document.getElementById('counterDispen');

        if (elTotal) elTotal.textContent = total;
        if (elHadir) elHadir.textContent = hadir;
        if (elSakit) elSakit.textContent = sakit;
        if (elIzin) elIzin.textContent = izin;
        if (elAlpa) elAlpa.textContent = alpa;
        if (elDispen) elDispen.textContent = dispen;

        // Update filter pills
        const pillSemua = document.getElementById('pillCountSemua');
        const pillHadir = document.getElementById('pillCountHadir');
        const pillSakit = document.getElementById('pillCountSakit');
        const pillIzin = document.getElementById('pillCountIzin');
        const pillAlpa = document.getElementById('pillCountAlpa');
        const pillDispen = document.getElementById('pillCountDispen');

        if (pillSemua) pillSemua.textContent = total;
        if (pillHadir) pillHadir.textContent = hadir;
        if (pillSakit) pillSakit.textContent = sakit;
        if (pillIzin) pillIzin.textContent = izin;
        if (pillAlpa) pillAlpa.textContent = alpa;
        if (pillDispen) pillDispen.textContent = dispen;

        filterRows();
    }

    // 2. Filter & Search logic
    function filterRows() {
        const query = (inputCari && inputCari.value ? inputCari.value : '').trim().toLowerCase();
        let visibleCount = 0;

        studentCards.forEach(card => {
            const nama = card.dataset.nama || '';
            const nisn = card.dataset.nisn || '';
            const status = card.dataset.status || 'hadir';

            const matchesSearch = query === '' || nama.includes(query) || nisn.includes(query);
            const matchesFilter = (currentFilter === 'all') || (status === currentFilter);

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
            const isCurrentlyChecked = this.dataset.checked === 'true';
            const groupName = this.name;

            // Clear dataset.checked for all radios in this student card
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                r.dataset.checked = 'false';
            });

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
    if (inputCari) {
        inputCari.addEventListener('input', filterRows);
    }

    // 5. Reset search
    if (btnResetSearch && inputCari) {
        btnResetSearch.addEventListener('click', function() {
            inputCari.value = '';
            filterRows();
            inputCari.focus();
        });
    }

    // 6. Set Semua Hadir Button
    if (btnSetSemuaHadir) {
        btnSetSemuaHadir.addEventListener('click', function() {
            document.querySelectorAll('.siad-input').forEach(radio => {
                // Do not uncheck if locked by dispen
                if (!radio.disabled || radio.value !== 'Dispen') {
                    radio.checked = false;
                    radio.dataset.checked = 'false';
                }
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

    // Initial calculation on load
    updatePresensiUI();
});
</script>
@endsection
