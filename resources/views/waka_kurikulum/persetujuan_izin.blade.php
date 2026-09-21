@extends('layouts.waka_kurikulum')

@section('title', 'Persetujuan Izin Guru — EDU JOURNAL')

@section('styles')
<style>
    /* ─── Base Persetujuan Izin Layout (No Horizontal Page Scrollbar) ─── */
    .izin-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Page Header Banner (Clean, Modern & Focused) */
    .page-header-box {
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        width: 100%;
        box-sizing: border-box;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 5px;
        margin-bottom: 0;
        line-height: 1.4;
    }

    /* ─── 5 Stat Metric Cards Row ─── */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease, border-color 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        box-sizing: border-box;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.06);
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .icon-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .icon-purple { background: #faf5ff; color: #7c3aed; border: 1px solid #f3e8ff; }
    .icon-gray   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .icon-orange { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }

    .stat-card-content {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .stat-card-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-card-num {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-card-sub {
        font-size: 10.5px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ─── Filter & Action Bar ─── */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 16px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        width: 100%;
        box-sizing: border-box;
    }

    .filter-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-inputs-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        flex-wrap: wrap;
        min-width: 0;
    }

    .search-input-box {
        position: relative;
        flex: 2 1 200px;
        min-width: 180px;
    }

    .search-input-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .form-input-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12.5px;
        font-family: inherit;
        color: #0f172a;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .search-input-box .form-input-control {
        padding-left: 34px;
    }

    .form-input-control:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-actions-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn-filter-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-filter-submit:hover {
        background: #1d4ed8;
    }

    .btn-filter-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-filter-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-batch-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-batch-delete:hover:not(:disabled) {
        background: #fecaca;
        color: #b91c1c;
    }

    .btn-batch-delete:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .btn-trash-view {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-trash-view:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ─── Main Panel & Tabs ─── */
    .main-panel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .panel-top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .tabs-nav {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 10px;
        gap: 3px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        font-family: inherit;
        text-decoration: none;
    }

    .tab-btn.active {
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .tab-badge {
        padding: 1px 7px;
        border-radius: 10px;
        font-size: 10.5px;
        font-weight: 800;
        line-height: 1.3;
    }

    .tab-badge-blue  { background: #eff6ff; color: #2563eb; }
    .tab-badge-green { background: #f0fdf4; color: #16a34a; }
    .tab-badge-purple{ background: #faf5ff; color: #7c3aed; }
    .tab-badge-gray  { background: #e2e8f0; color: #475569; }

    /* Batch Selection Strip */
    .batch-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
        box-sizing: border-box;
    }

    .batch-select-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
    }

    /* ─── Table Layout (Clean, Proportional, No Horizontal Scroll Shifts) ─── */
    .table-responsive {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-sizing: border-box;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 11px 12px;
        font-weight: 800;
        color: #475569;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
        font-size: 11px;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .custom-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    /* Teacher Cell */
    .teacher-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1.5px solid #bfdbfe;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
        line-height: 1.2;
    }

    .badge-pending   { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-approved  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-rejected  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-cuti      { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .badge-biasa     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-final-ok  { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border: 1px solid #1d4ed8; }

    /* Approval Matrix Box */
    .approval-matrix-box {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 125px;
    }

    .matrix-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        font-size: 10.5px;
    }

    .matrix-role-name {
        color: #64748b;
        font-weight: 700;
        font-size: 9.5px;
        text-transform: uppercase;
    }

    /* ─── Action Buttons (Kombinasi Modern Abu-abu, Biru, Putih, Abu-abu Muda) ─── */
    .btn-action-group {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 5.5px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    /* Tombol Setujui (Biru Primer Modern & Putih) */
    .btn-action-approve {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #1d4ed8;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2);
    }
    .btn-action-approve:hover {
        background: #1d4ed8;
        border-color: #1e40af;
        transform: translateY(-1px);
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.3);
    }

    /* Tombol Tolak (Abu-abu Muda Cerah / Putih dengan Border Slate & Teks Elegan) */
    .btn-action-reject {
        background: #ffffff;
        color: #b91c1c;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }
    .btn-action-reject:hover {
        background: #f8fafc;
        border-color: #fca5a5;
        color: #991b1b;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.1);
    }

    /* Tombol Detail (Abu-abu Cerah, Putih, Border Biru Halus, Teks Biru) */
    .btn-action-detail {
        background: #f8fafc;
        color: #2563eb;
        border: 1px solid #dbeafe;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
    }
    .btn-action-detail:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
        transform: translateY(-1px);
    }

    /* Tombol Link (Abu-abu Muda Cerah, Border Abu-abu, Teks Slate) */
    .btn-action-link {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
    }
    .btn-action-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* Tombol Hapus */
    .btn-action-delete {
        background: #ffffff;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }
    .btn-action-delete:hover {
        background: #fff1f2;
        border-color: #fca5a5;
        color: #be123c;
    }

    /* ─── Modal Styles ─── */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-backdrop-custom.show {
        display: flex;
    }

    .modal-dialog-custom {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalSlideUp 0.2s ease-out;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(15px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-dialog-custom.modal-lg {
        max-width: 820px;
    }

    .modal-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
    }

    .modal-header-custom h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 20px;
        cursor: pointer;
        padding: 2px;
        line-height: 1;
        transition: color 0.2s;
    }

    .modal-close-btn:hover {
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 14px;
        background: #ffffff;
    }

    .modal-footer-custom {
        padding: 12px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    /* Detail Grid Layout */
    .detail-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        background: #f8fafc;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .detail-item-col {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 10.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-val {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }

    /* Surat Card in Modal */
    .surat-preview-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-align: center;
        transition: border-color 0.2s;
    }

    .surat-preview-card:hover {
        border-color: #2563eb;
    }

    .surat-preview-card img {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
    }

    /* Toast Notification */
    #copyToast {
        visibility: hidden;
        min-width: 250px;
        background-color: #0f172a;
        color: #fff;
        text-align: center;
        border-radius: 10px;
        padding: 12px 18px;
        position: fixed;
        z-index: 1100;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        opacity: 0;
        transition: opacity 0.3s, bottom 0.3s;
    }

    #copyToast.show {
        visibility: visible;
        opacity: 1;
        bottom: 40px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stat-cards-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .tabs-nav { width: 100%; overflow-x: auto; }
        .detail-info-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="izin-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 18px; color: #ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <i class="fa-solid fa-triangle-exclamation" style="color: #ef4444;"></i>
                <span>Terdapat beberapa kendala validasi:</span>
            </div>
            <ul style="margin: 0; padding-left: 20px; font-size: 12px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header Box (Clean & Focused) -->
    <div class="page-header-box">
        <h1 class="page-main-title">
            <i class="fa-solid fa-clipboard-check" style="color: #2563eb;"></i>
            <span>Persetujuan &amp; Monitoring Izin Guru Pengampu</span>
        </h1>
        <p class="page-sub-title">
            Verifikasi izin mengajar dewan guru, berikan persetujuan/penolakan kurikulum, pantau status berjenjang (Waka Kurikulum, Waka SDM, Kepala Sekolah), serta pantau penugasan guru pengganti oleh Guru Piket.
        </p>
    </div>

    <!-- 5 Top Stat Metric Cards -->
    <div class="stat-cards-grid">
        <!-- Card 1: Menunggu Persetujuan Waka -->
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'pending']) }}" class="stat-card" title="Lihat pengajuan yang menunggu persetujuan Waka Kurikulum">
            <div class="stat-card-icon icon-blue">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-card-label">Menunggu Persetujuan</span>
                <span class="stat-card-num" style="color: {{ $totalPendingIzinWaka > 0 ? '#2563eb' : '#0f172a' }};">{{ $totalPendingIzinWaka }}</span>
                <span class="stat-card-sub">Antrean Waka Kurikulum</span>
            </div>
        </a>

        <!-- Card 2: Izin Resmi Disetujui -->
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi']) }}" class="stat-card" title="Lihat daftar seluruh izin guru yang telah resmi disetujui">
            <div class="stat-card-icon icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-card-label">Izin Resmi Disetujui</span>
                <span class="stat-card-num" style="color: #2563eb;">{{ $totalIzinResmi }}</span>
                <span class="stat-card-sub">Disetujui Waka &amp; Kepsek</span>
            </div>
        </a>

        <!-- Card 3: Riwayat Keputusan Waka -->
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'history']) }}" class="stat-card" title="Lihat riwayat perizinan yang telah direspon Waka Kurikulum">
            <div class="stat-card-icon icon-purple">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-card-label">Riwayat Keputusan</span>
                <span class="stat-card-num" style="color: #7c3aed;">{{ $totalHistoryWaka }}</span>
                <span class="stat-card-sub">Diputuskan Kurikulum</span>
            </div>
        </a>

        <!-- Card 4: Guru Izin Hari Ini -->
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi', 'tanggal' => $today]) }}" class="stat-card" title="Lihat guru yang izin aktif pada hari ini">
            <div class="stat-card-icon icon-gray">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-card-label">Guru Izin Hari Ini</span>
                <span class="stat-card-num">{{ $totalIzinHariIni }}</span>
                <span class="stat-card-sub">Pendidik Berhalangan</span>
            </div>
        </a>

        <!-- Card 5: Perlu Penugasan Pengganti -->
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi']) }}" class="stat-card" title="Lihat izin resmi yang belum mendapatkan penugasan guru pengganti dari piket">
            <div class="stat-card-icon icon-orange">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-card-label">Perlu Pengganti</span>
                <span class="stat-card-num" style="color: {{ $totalPerluPengganti > 0 ? '#ea580c' : '#0f172a' }};">{{ $totalPerluPengganti }}</span>
                <span class="stat-card-sub">Belum Ada Pengganti</span>
            </div>
        </a>
    </div>

    <!-- Filter & Action Bar Card -->
    <div class="filter-card">
        <form method="GET" action="{{ route('waka-kurikulum.persetujuan-izin') }}" class="filter-form" id="filterForm">
            <input type="hidden" name="tab" value="{{ $activeTab }}">

            <div class="filter-inputs-group">
                <!-- Search Box -->
                <div class="search-input-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama guru, NIP, mapel, alasan..." class="form-input-control">
                </div>

                <!-- Dropdown Status -->
                <div style="min-width: 140px; flex: 1 1 140px;">
                    <select name="status" class="form-input-control">
                        <option value="all" {{ $filterStatus == 'all' ? 'selected' : '' }}>-- Semua Status --</option>
                        <option value="pending" {{ $filterStatus == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="approved" {{ $filterStatus == 'approved' ? 'selected' : '' }}>Disetujui Waka</option>
                        <option value="rejected" {{ $filterStatus == 'rejected' ? 'selected' : '' }}>Ditolak Waka</option>
                        <option value="final_approved" {{ $filterStatus == 'final_approved' ? 'selected' : '' }}>Disetujui Resmi Full</option>
                    </select>
                </div>

                <!-- Dropdown Kategori -->
                <div style="min-width: 130px; flex: 1 1 130px;">
                    <select name="kategori" class="form-input-control">
                        <option value="all" {{ ($kategori == 'all' || empty($kategori)) ? 'selected' : '' }}>-- Kategori Izin --</option>
                        <option value="biasa" {{ $kategori == 'biasa' ? 'selected' : '' }}>Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti" {{ $kategori == 'cuti' ? 'selected' : '' }}>Cuti / Izin Khusus (&gt;3 Hari)</option>
                    </select>
                </div>

                <!-- Tanggal Filter -->
                <div style="min-width: 120px; flex: 1 1 120px;">
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-input-control" title="Filter berdasarkan tanggal izin">
                </div>

                <!-- Action Filter / Reset Buttons -->
                <button type="submit" class="btn-filter-submit">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                @if(!empty($search) || ($filterStatus !== 'all' && !empty($filterStatus)) || (!empty($kategori) && $kategori !== 'all') || !empty($tanggal))
                    <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => $activeTab]) }}" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                @endif
            </div>

            <!-- Right Actions: Hapus Terpilih & Sampah -->
            <div class="filter-actions-right">
                <!-- Tombol Hapus Terpilih -->
                <button type="button" class="btn-batch-delete" id="btnBatchDelete" onclick="submitBatchDelete()" disabled title="Pilih checkbox data yang ingin dihapus">
                    <i class="fa-solid fa-trash-can"></i>
                    <span id="labelBatchDelete">Hapus Terpilih ( 0 )</span>
                </button>

                <!-- Tombol Kotak Sampah -->
                <a href="{{ route('waka-kurikulum.persetujuan-izin.trash') }}" class="btn-trash-view" title="Buka Kotak Sampah Perizinan Guru">
                    <i class="fa-solid fa-trash"></i>
                    <span>Sampah ({{ $trashedCount }})</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Hidden Form for Batch Delete -->
    <form action="{{ route('waka-kurikulum.izin.batch-delete') }}" method="POST" id="formBatchDelete" style="display:none;">
        @csrf
        <div id="batchDeleteInputsContainer"></div>
    </form>

    <!-- Main Panel Card with Tabs -->
    <div class="main-panel-card">
        <div class="panel-top-nav">
            <!-- Tabs Navigation -->
            <div class="tabs-nav">
                <button type="button" class="tab-btn {{ $activeTab == 'pending' ? 'active' : '' }}" onclick="switchTab('pending', this)">
                    <i class="fa-solid fa-clock"></i>
                    <span>Menunggu Persetujuan</span>
                    <span class="tab-badge tab-badge-blue">{{ $pendingIzinList->count() }}</span>
                </button>
                <button type="button" class="tab-btn {{ $activeTab == 'resmi' ? 'active' : '' }}" onclick="switchTab('resmi', this)">
                    <i class="fa-solid fa-user-check"></i>
                    <span>Izin Resmi Disetujui</span>
                    <span class="tab-badge tab-badge-green">{{ $guruIzinResmiList->count() }}</span>
                </button>
                <button type="button" class="tab-btn {{ $activeTab == 'history' ? 'active' : '' }}" onclick="switchTab('history', this)">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Keputusan</span>
                    <span class="tab-badge tab-badge-purple">{{ $historyIzinList->count() }}</span>
                </button>
                <button type="button" class="tab-btn {{ $activeTab == 'all' ? 'active' : '' }}" onclick="switchTab('all', this)">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Semua Pengajuan</span>
                    <span class="tab-badge tab-badge-gray">{{ $totalPengajuan }}</span>
                </button>
            </div>

            <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Alur: <b>Waka Kurikulum</b> &rarr; <b>Waka SDM</b> &rarr; <b>Kepala Sekolah</b>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!-- TAB 1: MENUNGGU PERSETUJUAN (PENDING WAKA KURIKULUM)                -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <div id="pane-pending" class="tab-pane-content" style="{{ $activeTab == 'pending' ? '' : 'display:none;' }}">
            @if($pendingIzinList->isEmpty())
                <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 12px;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Tidak Ada Pengajuan Izin Menunggu</h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Seluruh permohonan izin guru dari Guru Piket telah diverifikasi dan diputuskan.</p>
                </div>
            @else
                <form action="{{ route('waka-kurikulum.izin.batch-approve') }}" method="POST" id="formBatchApprove">
                    @csrf
                    <div class="batch-strip">
                        <label class="batch-select-label">
                            <input type="checkbox" id="selectAllPending" onchange="toggleSelectAll(this, 'row-check-item')" style="width: 16px; height: 16px; accent-color: #2563eb; cursor: pointer;">
                            <span>Pilih Semua Pengajuan Pending ({{ $pendingIzinList->count() }})</span>
                        </label>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button type="submit" class="btn-table-action btn-action-approve" style="padding: 7px 15px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menyetujui seluruh pengajuan izin yang dipilih sekaligus?')">
                                <i class="fa-solid fa-check-double"></i> Setujui Terpilih Sekaligus
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top: 12px;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 38px; text-align: center;">#</th>
                                    <th style="width: 25%;">Guru Pemohon</th>
                                    <th style="width: 20%;">Tanggal &amp; Kategori</th>
                                    <th style="width: 21%;">Alasan Izin</th>
                                    <th style="width: 16%; text-align: center;">Status Berjenjang</th>
                                    <th style="width: 18%; text-align: center;">Aksi Persetujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingIzinList as $izin)
                                    @php
                                        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                        $mapelGuru = $izin->guru->mapel->nama_mapel ?? 'Pengampu KBM';
                                        $tglMulai = Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
                                        $tglSelesai = $izin->tanggal_selesai ? Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') : $tglMulai;
                                        $isCuti = strtolower($izin->kategori_izin ?? '') === 'cuti' || str_contains(strtolower($izin->kategori_izin ?? ''), 'cuti');
                                        
                                        // Bersihkan string durasi agar tidak berulang
                                        $durasiRaw = $izin->durasi ?? '';
                                        if (preg_match('/(\d+\s*Hari)/i', $durasiRaw, $m)) {
                                            $durasiDisplay = $m[1];
                                        } elseif (!empty($durasiRaw) && !str_contains(strtolower($durasiRaw), 'cuti') && !str_contains(strtolower($durasiRaw), 'izin')) {
                                            $durasiDisplay = $durasiRaw;
                                        } else {
                                            $durasiDisplay = $tglMulai === $tglSelesai ? '1 Hari' : 'Multi Hari';
                                        }

                                        $hasMateri = !empty($izin->materi_dititipkan) || !empty($izin->tugas_dititipkan) || !empty($izin->file_tugas);
                                        $hasFoto = !empty($izin->foto_surat);
                                    @endphp
                                    <tr>
                                        <td style="text-align: center;">
                                            <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="row-check-item" onchange="updateSelectedCount()" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                        </td>
                                        <td>
                                            <div class="teacher-cell">
                                                <div class="avatar-circle">
                                                    {{ strtoupper(substr($namaGuru, 0, 1)) }}
                                                </div>
                                                <div style="min-width: 0;">
                                                    <div style="font-weight: 800; color: #0f172a; font-size: 13px; line-height: 1.2;">
                                                        {{ $namaGuru }}
                                                    </div>
                                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                                        NIP: {{ $izin->guru->nip ?? '-' }}
                                                    </div>
                                                    <div style="font-size: 11px; color: #2563eb; font-weight: 600; margin-top: 1px;">
                                                        {{ $mapelGuru }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 12.5px;">
                                                {{ $tglMulai }}
                                                @if($tglSelesai !== $tglMulai)
                                                    <span style="color: #64748b; font-weight: 500;">s/d</span> {{ $tglSelesai }}
                                                @endif
                                            </div>
                                            <div style="margin-top: 3px;">
                                                <span class="badge-status {{ $isCuti ? 'badge-cuti' : 'badge-biasa' }}">
                                                    <i class="fa-solid {{ $isCuti ? 'fa-calendar-minus' : 'fa-calendar-check' }}"></i>
                                                    {{ $isCuti ? 'Cuti Khusus' : 'Izin Biasa' }} ({{ $durasiDisplay }})
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #0f172a; font-size: 12.5px; line-height: 1.35;">
                                                {{ $izin->alasan ?? '-' }}
                                            </div>
                                            @if($izin->keterangan_khusus)
                                                <div style="font-size: 11px; color: #ea580c; font-weight: 600; margin-top: 2px;">
                                                    <i class="fa-solid fa-bookmark"></i> {{ $izin->keterangan_khusus }}
                                                </div>
                                            @endif
                                            @if($hasMateri || $hasFoto)
                                                <div style="margin-top: 4px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                                                    @if($hasMateri)
                                                        <span style="background: #eff6ff; color: #2563eb; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; border: 1px solid #bfdbfe;" title="Tersedia materi/tugas titipan di detail">
                                                            <i class="fa-solid fa-book-open"></i> Titipan KBM
                                                        </span>
                                                    @endif
                                                    @if($hasFoto)
                                                        <span style="background: #f8fafc; color: #475569; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; border: 1px solid #cbd5e1;" title="Tersedia bukti surat di detail">
                                                            <i class="fa-solid fa-file-image"></i> Ada Surat
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="approval-matrix-box" style="margin: 0 auto;">
                                                <div class="matrix-item">
                                                    <span class="matrix-role-name">Kurikulum</span>
                                                    <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                                </div>
                                                <div class="matrix-item">
                                                    <span class="matrix-role-name">SDM</span>
                                                    @if($izin->status_waka_sdm === 'approved')
                                                        <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Setuju</span>
                                                    @elseif($izin->status_waka_sdm === 'rejected')
                                                        <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                                    @else
                                                        <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                                    @endif
                                                </div>
                                                <div class="matrix-item">
                                                    <span class="matrix-role-name">Kepsek</span>
                                                    @if($izin->status_kepsek === 'approved')
                                                        <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Setuju</span>
                                                    @elseif($izin->status_kepsek === 'rejected')
                                                        <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                                    @else
                                                        <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-action-group" style="justify-content: center;">
                                                <!-- Tombol Setujui (Biru Primer Modern & Putih) -->
                                                <button type="button" class="btn-table-action btn-action-approve" onclick="openApproveModal({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')">
                                                    <i class="fa-solid fa-check"></i> Setujui
                                                </button>

                                                <!-- Tombol Tolak (Abu-abu Muda Cerah / Putih dengan Border Slate) -->
                                                <button type="button" class="btn-table-action btn-action-reject" onclick="openRejectModal({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')">
                                                    <i class="fa-solid fa-xmark"></i> Tolak
                                                </button>

                                                <!-- Tombol Detail AJAX (Abu-abu muda cerah dengan border & teks biru) -->
                                                <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                                    <i class="fa-solid fa-circle-info"></i> Detail
                                                </button>

                                                <!-- Tombol Link Approval (Abu-abu muda cerah) -->
                                                @if($izin->token_approval)
                                                    <button type="button" class="btn-table-action btn-action-link" onclick="copyApprovalLink('{{ route('approval.guru-izin.show', $izin->token_approval) }}')" title="Salin Link Approval Resmi">
                                                        <i class="fa-solid fa-link"></i> Link
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            @endif
        </div>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!-- TAB 2: IZIN RESMI DISETUJUI (SINKRON GURU PIKET & KEPSEK)            -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <div id="pane-resmi" class="tab-pane-content" style="{{ $activeTab == 'resmi' ? '' : 'display:none;' }}">
            @if($guruIzinResmiList->isEmpty())
                <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-user-check" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <h4 style="font-size: 15px; font-weight: 700; color: #475569; margin: 0;">Belum Ada Izin Resmi Disetujui</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0 0;">Daftar izin yang telah disetujui resmi oleh Waka &amp; Kepala Sekolah akan otomatis tampil di sini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 38px; text-align: center;">
                                    <input type="checkbox" onchange="toggleSelectAll(this, 'resmi-check-item')" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                </th>
                                <th style="width: 25%;">Guru Tidak Hadir</th>
                                <th style="width: 20%;">Tanggal &amp; Kategori</th>
                                <th style="width: 21%;">Alasan Izin</th>
                                <th style="width: 14%; text-align: center;">Persetujuan</th>
                                <th style="width: 12%; text-align: center;">Guru Pengganti</th>
                                <th style="width: 8%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guruIzinResmiList as $idx => $izin)
                                @php
                                    $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                    $mapelGuru = $izin->guru->mapel->nama_mapel ?? 'Pengampu KBM';
                                    $tglMulai = Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y');
                                    $tglSelesai = $izin->tanggal_selesai ? Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-m-Y') : $tglMulai;
                                    $isCuti = strtolower($izin->kategori_izin ?? '') === 'cuti' || str_contains(strtolower($izin->kategori_izin ?? ''), 'cuti');
                                    
                                    $durasiRaw = $izin->durasi ?? '';
                                    if (preg_match('/(\d+\s*Hari)/i', $durasiRaw, $m)) {
                                        $durasiDisplay = $m[1];
                                    } elseif (!empty($durasiRaw) && !str_contains(strtolower($durasiRaw), 'cuti') && !str_contains(strtolower($durasiRaw), 'izin')) {
                                        $durasiDisplay = $durasiRaw;
                                    } else {
                                        $durasiDisplay = $tglMulai === $tglSelesai ? '1 Hari' : 'Multi Hari';
                                    }
                                @endphp
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="row-check-item resmi-check-item" onchange="updateSelectedCount()" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                    </td>
                                    <td>
                                        <div class="teacher-cell">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($namaGuru, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 800; color: #0f172a; font-size: 13px;">
                                                    {{ $namaGuru }}
                                                </div>
                                                <div style="font-size: 11px; color: #64748b;">
                                                    NIP: {{ $izin->guru->nip ?? '-' }}
                                                </div>
                                                <div style="font-size: 11px; color: #2563eb; font-weight: 600;">
                                                    {{ $mapelGuru }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 12.5px;">
                                            {{ $tglMulai }}
                                            @if($tglSelesai !== $tglMulai)
                                                <span style="color: #64748b; font-weight: 500;">s/d</span> {{ $tglSelesai }}
                                            @endif
                                        </div>
                                        <div style="margin-top: 3px;">
                                            <span class="badge-status {{ $isCuti ? 'badge-cuti' : 'badge-biasa' }}">
                                                <i class="fa-solid {{ $isCuti ? 'fa-calendar-minus' : 'fa-calendar-check' }}"></i>
                                                {{ $isCuti ? 'Cuti Khusus' : 'Izin Biasa' }} ({{ $durasiDisplay }})
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #0f172a; font-size: 12.5px; line-height: 1.35;">
                                            {{ $izin->alasan ?? '-' }}
                                        </div>
                                        @if($izin->materi_dititipkan || $izin->tugas_dititipkan || $izin->foto_surat)
                                            <div style="margin-top: 4px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                                                @if($izin->materi_dititipkan || $izin->tugas_dititipkan)
                                                    <span style="background: #eff6ff; color: #2563eb; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; border: 1px solid #bfdbfe;">
                                                        <i class="fa-solid fa-book-open"></i> Ada Materi
                                                    </span>
                                                @endif
                                                @if($izin->foto_surat)
                                                    <span style="background: #f8fafc; color: #475569; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                                        <i class="fa-solid fa-file-image"></i> Ada Surat
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="approval-matrix-box" style="margin: 0 auto;">
                                            <div class="matrix-item">
                                                <span class="matrix-role-name">Kurikulum</span>
                                                <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Disetujui</span>
                                            </div>
                                            <div class="matrix-item">
                                                <span class="matrix-role-name">Kepsek</span>
                                                <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Disetujui</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->has_penugasan)
                                            <span class="badge-status badge-approved" title="Guru Pengganti: {{ $izin->nama_guru_pengganti }}">
                                                <i class="fa-solid fa-user-shield"></i> Ada Pengganti
                                            </span>
                                            <div style="font-size: 11px; color: #166534; font-weight: 700; margin-top: 2px;">
                                                {{ $izin->nama_guru_pengganti }}
                                            </div>
                                        @else
                                            <span class="badge-status badge-pending">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-action-group" style="justify-content: center;">
                                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                                <i class="fa-solid fa-circle-info"></i> Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!-- TAB 3: RIWAYAT KEPUTUSAN WAKA KURIKULUM                            -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <div id="pane-history" class="tab-pane-content" style="{{ $activeTab == 'history' ? '' : 'display:none;' }}">
            @if($historyIzinList->isEmpty())
                <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <h4 style="font-size: 15px; font-weight: 700; color: #475569; margin: 0;">Belum Ada Riwayat Keputusan</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0 0;">Seluruh permohonan yang telah Anda setujui atau tolak akan tercatat di sini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 38px; text-align: center;">
                                    <input type="checkbox" onchange="toggleSelectAll(this, 'history-check-item')" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                </th>
                                <th style="width: 25%;">Guru yang Mengajukan</th>
                                <th style="width: 18%;">Tanggal Izin</th>
                                <th style="width: 20%;">Alasan</th>
                                <th style="width: 13%; text-align: center;">Keputusan Waka</th>
                                <th style="width: 16%;">Catatan Kurikulum</th>
                                <th style="width: 8%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyIzinList as $idx => $izin)
                                @php
                                    $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                    $tglMulai = Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
                                    $tglSelesai = $izin->tanggal_selesai ? Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') : $tglMulai;
                                @endphp
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="row-check-item history-check-item" onchange="updateSelectedCount()" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                    </td>
                                    <td>
                                        <div class="teacher-cell">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($namaGuru, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 800; color: #0f172a; font-size: 13px;">{{ $namaGuru }}</div>
                                                <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">
                                            {{ $tglMulai }}
                                            @if($tglSelesai !== $tglMulai)
                                                <span style="color: #64748b;">s/d</span> {{ $tglSelesai }}
                                            @endif
                                        </div>
                                        <span class="badge-status {{ strtolower($izin->kategori_izin ?? '') === 'cuti' ? 'badge-cuti' : 'badge-biasa' }}" style="margin-top: 2px;">
                                            {{ ucfirst($izin->kategori_izin ?? 'biasa') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: 12.5px; color: #334155; line-height: 1.35;">
                                            {{ $izin->alasan ?? '-' }}
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->status_waka === 'approved')
                                            <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Disetujui</span>
                                        @elseif($izin->status_waka === 'rejected')
                                            <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size: 12px; color: #475569; font-style: italic;">
                                            {{ $izin->catatan_waka ?? '-' }}
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-action-group" style="justify-content: center;">
                                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                                <i class="fa-solid fa-circle-info"></i> Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!-- TAB 4: SEMUA PENGAJUAN IZIN GURU (FULL PAGINATED)                   -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <div id="pane-all" class="tab-pane-content" style="{{ $activeTab == 'all' ? '' : 'display:none;' }}">
            @if($semuaIzinList->isEmpty())
                <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <h4 style="font-size: 15px; font-weight: 700; color: #475569; margin: 0;">Data Pengajuan Tidak Ditemukan</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0 0;">Tidak ada data perizinan yang sesuai dengan filter pencarian Anda.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 38px; text-align: center;">
                                    <input type="checkbox" onchange="toggleSelectAll(this, 'all-check-item')" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                </th>
                                <th style="width: 24%;">Guru yang Mengajukan</th>
                                <th style="width: 17%;">Tanggal &amp; Kategori</th>
                                <th style="width: 18%;">Alasan</th>
                                <th style="width: 10%; text-align: center;">Kurikulum</th>
                                <th style="width: 10%; text-align: center;">SDM</th>
                                <th style="width: 10%; text-align: center;">Kepsek</th>
                                <th style="width: 11%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaIzinList as $izin)
                                @php
                                    $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                    $mapelGuru = $izin->guru->mapel->nama_mapel ?? 'Pengampu KBM';
                                    $tglMulai = Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
                                    $tglSelesai = $izin->tanggal_selesai ? Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') : $tglMulai;
                                    $isCuti = strtolower($izin->kategori_izin ?? '') === 'cuti' || str_contains(strtolower($izin->kategori_izin ?? ''), 'cuti');
                                @endphp
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="row-check-item all-check-item" onchange="updateSelectedCount()" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                    </td>
                                    <td>
                                        <div class="teacher-cell">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($namaGuru, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 800; color: #0f172a; font-size: 13px;">{{ $namaGuru }}</div>
                                                <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                                <div style="font-size: 11px; color: #2563eb; font-weight: 600;">{{ $mapelGuru }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">
                                            {{ $tglMulai }}
                                            @if($tglSelesai !== $tglMulai)
                                                <span style="color: #64748b;">s/d</span> {{ $tglSelesai }}
                                            @endif
                                        </div>
                                        <span class="badge-status {{ $isCuti ? 'badge-cuti' : 'badge-biasa' }}" style="margin-top: 2px;">
                                            {{ $isCuti ? 'Cuti Khusus' : 'Izin Biasa' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: 12.5px; color: #334155; line-height: 1.35;">{{ $izin->alasan ?? '-' }}</div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->status_waka === 'approved')
                                            <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Setuju</span>
                                        @elseif($izin->status_waka === 'rejected')
                                            <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->status_waka_sdm === 'approved')
                                            <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Setuju</span>
                                        @elseif($izin->status_waka_sdm === 'rejected')
                                            <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->status_kepsek === 'approved')
                                            <span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Setuju</span>
                                        @elseif($izin->status_kepsek === 'rejected')
                                            <span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-action-group" style="justify-content: center;">
                                            @if($izin->status_waka === 'pending' || empty($izin->status_waka))
                                                <button type="button" class="btn-table-action btn-action-approve" onclick="openApproveModal({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')" title="Setujui Izin">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                                <button type="button" class="btn-table-action btn-action-reject" onclick="openRejectModal({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')" title="Tolak Izin">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})" title="Lihat Detail Lengkap">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>
                                            @if($izin->token_approval)
                                                <button type="button" class="btn-table-action btn-action-link" onclick="copyApprovalLink('{{ route('approval.guru-izin.show', $izin->token_approval) }}')" title="Salin Link Approval">
                                                    <i class="fa-solid fa-link"></i>
                                                </button>
                                            @endif
                                            <form action="{{ route('waka-kurikulum.izin.destroy', $izin->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Pindahkan permohonan izin ini ke kotak sampah?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-table-action btn-action-delete" title="Hapus ke Kotak Sampah">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Container -->
                <div style="margin-top: 16px;">
                    {{ $semuaIzinList->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!-- MODAL 1: SETUJUI IZIN GURU (WAKA KURIKULUM)                             -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->
<div id="modalApprove" class="modal-backdrop-custom">
    <div class="modal-dialog-custom">
        <form method="POST" id="formApproveIzin" action="">
            @csrf
            <div class="modal-header-custom">
                <h3>
                    <i class="fa-solid fa-circle-check" style="color: #2563eb;"></i>
                    <span>Konfirmasi Persetujuan Izin</span>
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalApprove')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px 14px; border-radius: 10px; color: #1e40af; font-size: 13px; line-height: 1.4;">
                    Anda akan <b>MENYETUJUI</b> permohonan izin untuk guru <b id="approveNamaGuru">-</b>. Data keputusan akan langsung diteruskan ke Guru Piket dan Kepala Sekolah.
                </div>
                <div>
                    <label class="detail-label" for="catatan_waka_approve">Catatan Persetujuan Waka Kurikulum (Opsional)</label>
                    <textarea name="catatan" id="catatan_waka_approve" rows="3" class="form-input-control" placeholder="Tuliskan catatan akademik atau instruksi pembelajaran (opsional)..." style="width: 100%; margin-top: 4px;"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-filter-reset" onclick="closeModal('modalApprove')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-approve" style="padding: 8px 16px; font-size: 13px;">
                    <i class="fa-solid fa-check"></i> Setujui Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!-- MODAL 2: TOLAK IZIN GURU (WAKA KURIKULUM)                               -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->
<div id="modalReject" class="modal-backdrop-custom">
    <div class="modal-dialog-custom">
        <form method="POST" id="formRejectIzin" action="">
            @csrf
            <div class="modal-header-custom">
                <h3>
                    <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i>
                    <span>Konfirmasi Penolakan Izin</span>
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalReject')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 12px 14px; border-radius: 10px; color: #991b1b; font-size: 13px; line-height: 1.4;">
                    Anda akan <b>MENOLAK</b> pengajuan izin untuk guru <b id="rejectNamaGuru">-</b>. Mohon berikan alasan penolakan yang jelas agar guru bersangkutan mendapatkan kejelasan.
                </div>
                <div>
                    <label class="detail-label" for="catatan_waka_reject" style="color: #dc2626;">Alasan / Catatan Penolakan (Wajib Diisi) *</label>
                    <textarea name="catatan" id="catatan_waka_reject" rows="3" required class="form-input-control" placeholder="Tuliskan alasan penolakan pengajuan izin ini..." style="width: 100%; margin-top: 4px;"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-filter-reset" onclick="closeModal('modalReject')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-reject" style="padding: 8px 16px; font-size: 13px; background: #b91c1c; color: #ffffff; border-color: #991b1b;">
                    <i class="fa-solid fa-ban"></i> Tolak Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!-- MODAL 3: DETAIL LENGKAP IZIN, TITIPAN MATERI & BUKTI SURAT (AJAX)       -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->
<div id="modalDetail" class="modal-backdrop-custom">
    <div class="modal-dialog-custom modal-lg">
        <div class="modal-header-custom">
            <h3>
                <i class="fa-solid fa-id-card-clip" style="color: #2563eb;"></i>
                <span>Rincian Lengkap Permintaan Izin Guru</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div class="modal-body-custom" id="modalDetailBody">
            <div style="text-align:center; padding: 36px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-size: 13px; font-weight: 600;">Memuat rincian izin, materi titipan &amp; bukti surat...</p>
            </div>
        </div>
        <div class="modal-footer-custom" id="modalDetailFooter">
            <button type="button" class="btn-filter-reset" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!-- MODAL 4: PREVIEW FOTO BUKTI SURAT (UKURAN FULL)                         -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->
<div id="modalSurat" class="modal-backdrop-custom" style="z-index: 1060;">
    <div class="modal-dialog-custom">
        <div class="modal-header-custom">
            <h3>
                <i class="fa-solid fa-file-image" style="color: #2563eb;"></i>
                <span id="suratModalTitle">Foto Surat Keterangan / Bukti Izin</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalSurat')">&times;</button>
        </div>
        <div class="modal-body-custom" style="align-items: center; justify-content: center; background: #0f172a; padding: 16px;">
            <img id="suratModalImg" src="" alt="Surat Izin Full" style="max-width: 100%; max-height: 65vh; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
        </div>
        <div class="modal-footer-custom" style="justify-content: space-between;">
            <div style="font-size: 12px; color: #64748b;" id="suratModalInfo">-</div>
            <div style="display: flex; gap: 8px;">
                <a id="suratModalDownload" href="#" target="_blank" class="btn-table-action btn-action-detail">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Ukuran Asli
                </a>
                <button type="button" class="btn-filter-reset" onclick="closeModal('modalSurat')">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Feedback for Copy Link -->
<div id="copyToast"><i class="fa-solid fa-check-circle" style="color: #4ade80; margin-right: 6px;"></i> Link Approval berhasil disalin ke clipboard!</div>
@endsection

@section('scripts')
<script>
    // Tab Switcher
    function switchTab(tabName, btnElement) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane-content').forEach(pane => pane.style.display = 'none');

        if (btnElement) {
            btnElement.classList.add('active');
        }

        const pane = document.getElementById('pane-' + tabName);
        if (pane) {
            pane.style.display = 'block';
        }

        // Uncheck master and reset batch count
        const masterCb = document.getElementById('selectAllPending');
        if (masterCb) masterCb.checked = false;
        updateSelectedCount();

        // Update URL query tanpa reload penuh
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
    }

    // Toggle Select All Checkboxes
    function toggleSelectAll(masterCheckbox, className) {
        const checkboxes = document.querySelectorAll('.' + className);
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateSelectedCount();
    }

    // Update Selected Checkboxes Count for Batch Delete
    function updateSelectedCount() {
        const checked = document.querySelectorAll('.row-check-item:checked');
        const count = checked.length;
        const btnDelete = document.getElementById('btnBatchDelete');
        const labelDelete = document.getElementById('labelBatchDelete');

        if (btnDelete && labelDelete) {
            labelDelete.innerText = 'Hapus Terpilih ( ' + count + ' )';
            if (count > 0) {
                btnDelete.disabled = false;
            } else {
                btnDelete.disabled = true;
            }
        }
    }

    // Submit Batch Delete
    function submitBatchDelete() {
        const checked = document.querySelectorAll('.row-check-item:checked');
        if (checked.length === 0) {
            alert('Pilih minimal satu data izin guru untuk dihapus.');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data izin guru yang dipilih ke kotak sampah?')) {
            return;
        }

        const container = document.getElementById('batchDeleteInputsContainer');
        container.innerHTML = '';

        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('formBatchDelete').submit();
    }

    // Modal Handlers
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
        }
    }

    // Open Modal Setujui
    function openApproveModal(id, namaGuru) {
        document.getElementById('approveNamaGuru').innerText = namaGuru;
        document.getElementById('formApproveIzin').action = "{{ url('/waka-kurikulum/izin') }}/" + id + "/approve";
        document.getElementById('catatan_waka_approve').value = '';
        document.getElementById('modalApprove').classList.add('show');
    }

    // Open Modal Tolak
    function openRejectModal(id, namaGuru) {
        document.getElementById('rejectNamaGuru').innerText = namaGuru;
        document.getElementById('formRejectIzin').action = "{{ url('/waka-kurikulum/izin') }}/" + id + "/reject";
        document.getElementById('catatan_waka_reject').value = '';
        document.getElementById('modalReject').classList.add('show');
    }

    // Open Modal Foto Surat
    function openSuratModal(namaGuru, tgl, alasan, imgUrl) {
        document.getElementById('suratModalTitle').innerText = 'Surat Keterangan: ' + namaGuru;
        document.getElementById('suratModalImg').src = imgUrl;
        document.getElementById('suratModalInfo').innerText = tgl + ' • ' + (alasan || 'Permohonan Izin');
        document.getElementById('suratModalDownload').href = imgUrl;
        document.getElementById('modalSurat').classList.add('show');
    }

    // Open Modal Detail AJAX (Menampilkan Profil, Alasan, Titipan Materi, Bukti Surat, Matriks 3 Tingkat, Jadwal Terdampak, & Guru Pengganti)
    function openDetailModal(id) {
        const modal = document.getElementById('modalDetail');
        const body = document.getElementById('modalDetailBody');
        const footer = document.getElementById('modalDetailFooter');

        modal.classList.add('show');
        body.innerHTML = `
            <div style="text-align:center; padding: 36px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #2563eb;"></i>
                <p style="margin-top: 10px; font-size: 13px; font-weight: 600;">Memuat rincian izin, materi titipan &amp; bukti surat...</p>
            </div>
        `;

        fetch("{{ url('/waka-kurikulum/izin') }}/" + id + "/detail-json")
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    body.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 20px;">Gagal memuat data detail izin.</div>`;
                    return;
                }
                const d = res.data;

                // Status formatting helper
                const renderStatusBadge = (status) => {
                    if (status === 'approved' || status === 'Disetujui') {
                        return `<span class="badge-status badge-approved"><i class="fa-solid fa-check"></i> Disetujui</span>`;
                    } else if (status === 'rejected' || status === 'Ditolak') {
                        return `<span class="badge-status badge-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>`;
                    }
                    return `<span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>`;
                };

                let jadwalRows = '';
                if (d.jadwals_terdampak && d.jadwals_terdampak.length > 0) {
                    d.jadwals_terdampak.forEach(j => {
                        jadwalRows += `
                            <tr>
                                <td style="font-weight:700; color:#0f172a;">${j.hari}</td>
                                <td>${j.jam_ke} <span style="font-size:11px; color:#64748b;">(${j.waktu})</span></td>
                                <td style="font-weight:700; color:#2563eb;">${j.kelas}</td>
                                <td style="font-weight:600; color:#334155;">${j.mapel}</td>
                                <td><span style="background:#f1f5f9; padding:2px 8px; border-radius:5px; font-size:11px; font-weight:600;">${j.ruangan}</span></td>
                            </tr>
                        `;
                    });
                } else {
                    jadwalRows = `<tr><td colspan="5" style="text-align:center; color:#94a3b8; font-style:italic; padding:12px;">Tidak ada jadwal mengajar tetap yang terdaftar untuk guru ini.</td></tr>`;
                }

                let penggantiHtml = '';
                if (d.penugasan_pengganti && d.penugasan_pengganti.length > 0) {
                    d.penugasan_pengganti.forEach(p => {
                        penggantiHtml += `
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px 14px; border-radius: 10px; margin-top: 6px; display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <div style="font-weight:800; color:#166534; font-size:13px;">${p.guru_pengganti}</div>
                                    <div style="font-size:11px; color:#15803d; margin-top:2px;">NIP: ${p.nip_pengganti} • Tanggal Bertugas: <b>${p.tanggal}</b></div>
                                </div>
                                <span class="badge-status badge-approved"><i class="fa-solid fa-user-shield"></i> Ditugaskan Piket</span>
                            </div>
                        `;
                    });
                } else {
                    penggantiHtml = `
                        <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 10px 14px; border-radius: 10px; font-size: 12.5px; color: #92400e; display:flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size:16px;"></i>
                            <span>Belum ada penugasan guru pengganti oleh Guru Piket untuk masa izin ini.</span>
                        </div>
                    `;
                }

                // Bukti Surat HTML
                let suratHtml = '';
                if (d.foto_surat_url) {
                    suratHtml = `
                        <div class="surat-preview-card">
                            <div style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;">
                                <i class="fa-solid fa-image" style="color: #2563eb;"></i> Dokumen Surat Izin
                            </div>
                            <img src="${d.foto_surat_url}" alt="Foto Surat" onclick="openSuratModal('${d.nama_guru.replace(/'/g, "\\'")}', '${d.tanggal_mulai}', '${d.alasan.replace(/'/g, "\\'")}', '${d.foto_surat_url}')" onerror="this.onerror=null; this.parentNode.innerHTML='<div style=\\'color:#94a3b8; font-size:12px; padding:20px;\\'><i class=\\'fa-solid fa-file-excel\\'></i> Gambar tidak dapat dimuat</div>';">
                            <div style="display: flex; gap: 6px; margin-top: 4px;">
                                <button type="button" class="btn-table-action btn-action-detail" onclick="openSuratModal('${d.nama_guru.replace(/'/g, "\\'")}', '${d.tanggal_mulai}', '${d.alasan.replace(/'/g, "\\'")}', '${d.foto_surat_url}')" style="font-size: 11px; padding: 5px 10px;">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i> Perbesar
                                </button>
                                <a href="${d.foto_surat_url}" target="_blank" class="btn-table-action btn-action-link" style="font-size: 11px; padding: 5px 10px;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Tab Baru
                                </a>
                            </div>
                        </div>
                    `;
                } else {
                    suratHtml = `
                        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 24px 14px; text-align: center; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; box-sizing: border-box;">
                            <i class="fa-solid fa-file-slash" style="font-size: 28px; margin-bottom: 6px; color: #cbd5e1;"></i>
                            <div style="font-weight: 700; font-size: 12px; color: #64748b;">Tidak Ada Lampiran Surat</div>
                            <div style="font-size: 11px; margin-top: 2px;">Izin disampaikan lisan/langsung ke Guru Piket</div>
                        </div>
                    `;
                }

                body.innerHTML = `
                    <!-- 1. Hero Guru Profile -->
                    <div style="background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%); border: 1px solid #dbeafe; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="avatar-circle" style="width: 46px; height: 46px; font-size: 17px; background: #2563eb; color: #ffffff; border-color: #1d4ed8;">
                                ${d.nama_guru.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <div style="font-weight: 800; color: #0f172a; font-size: 15px;">${d.nama_guru}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 1px;">
                                    NIP: <b>${d.nip}</b> • Mapel: <b style="color: #2563eb;">${d.mapel}</b>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            ${d.no_hp && d.no_hp !== '-' ? `
                                <a href="https://wa.me/${d.no_hp.replace(/[^0-9]/g, '')}" target="_blank" class="btn-table-action" style="background: #2563eb; color: #ffffff; border: 1px solid #1d4ed8; padding: 6px 12px; font-size: 11.5px;">
                                    <i class="fa-brands fa-whatsapp"></i> Chat Guru (${d.no_hp})
                                </a>
                            ` : ''}
                            <span class="badge-status ${d.kategori_izin.toLowerCase().includes('cuti') ? 'badge-cuti' : 'badge-biasa'}" style="font-size: 11.5px; padding: 6px 10px;">
                                <i class="fa-solid fa-tag"></i> ${d.kategori_izin}
                            </span>
                        </div>
                    </div>

                    <!-- 2. Grid Info: Data Izin & Materi Titipan (Kiri) + Bukti Surat (Kanan) -->
                    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 12px;">
                        <!-- Kolom Kiri: Detail Izin & Titipan Materi -->
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div class="detail-info-grid" style="grid-template-columns: 1fr;">
                                <div class="detail-item-col">
                                    <span class="detail-label">Masa Berlaku Izin</span>
                                    <span class="detail-val" style="color: #2563eb; font-size: 13.5px;">
                                        ${d.tanggal_mulai} ${d.tanggal_mulai !== d.tanggal_selesai ? 's/d ' + d.tanggal_selesai : ''}
                                    </span>
                                    <span style="font-size: 11px; color: #475569; font-weight: 700; margin-top: 2px;">
                                        Durasi: ${d.durasi}
                                    </span>
                                </div>
                                <div class="detail-item-col" style="margin-top: 4px;">
                                    <span class="detail-label">Alasan Izin</span>
                                    <span class="detail-val" style="color: #0f172a; font-weight: 600; line-height: 1.4;">
                                        ${d.alasan}
                                    </span>
                                </div>
                                ${d.keterangan_khusus && d.keterangan_khusus !== '-' ? `
                                    <div class="detail-item-col" style="margin-top: 4px;">
                                        <span class="detail-label" style="color: #ea580c;">Keterangan Cuti Khusus</span>
                                        <span class="detail-val" style="color: #c2410c;">${d.keterangan_khusus}</span>
                                    </div>
                                ` : ''}
                            </div>

                            <!-- Box Titipan Materi & Tugas Siswa -->
                            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                                <div style="font-size: 11.5px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                                    <i class="fa-solid fa-book-bookmark" style="color: #2563eb;"></i> Titipan Materi &amp; Tugas Pembelajaran KBM
                                </div>
                                <div style="font-size: 12.5px; color: #1e293b; line-height: 1.4;">
                                    <div style="margin-bottom: 4px;">
                                        <span style="font-weight: 700; color: #475569;">Materi:</span> ${d.materi_dititipkan !== '-' ? d.materi_dititipkan : '<span style="color:#94a3b8; font-style:italic;">Tidak ada keterangan materi</span>'}
                                    </div>
                                    <div>
                                        <span style="font-weight: 700; color: #475569;">Tugas:</span> ${d.tugas_dititipkan !== '-' ? d.tugas_dititipkan : '<span style="color:#94a3b8; font-style:italic;">Tidak ada tugas titipan tertulis</span>'}
                                    </div>
                                </div>
                                ${d.file_tugas_url ? `
                                    <div style="margin-top: 10px; border-top: 1px dashed #cbd5e1; padding-top: 8px;">
                                        <a href="${d.file_tugas_url}" target="_blank" class="btn-table-action btn-action-approve" style="font-size: 11.5px; padding: 6px 12px;">
                                            <i class="fa-solid fa-download"></i> Unduh Berkas / Dokumen Tugas Siswa
                                        </a>
                                    </div>
                                ` : ''}
                            </div>
                        </div>

                        <!-- Kolom Kanan: Bukti Surat Keterangan -->
                        <div>
                            ${suratHtml}
                        </div>
                    </div>

                    <!-- 3. Status Persetujuan Berjenjang 3 Tingkat -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                        <span class="detail-label" style="margin-bottom: 8px; display:block;">Status Persetujuan Berjenjang Resmi</span>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                            <div style="background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">1. Waka Kurikulum</div>
                                <div style="margin-top: 4px;">${renderStatusBadge(d.status_waka)}</div>
                                <div style="font-size: 11px; color: #475569; margin-top: 4px; font-style: italic;">${d.catatan_waka || '-'}</div>
                            </div>

                            <div style="background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">2. Waka SDM</div>
                                <div style="margin-top: 4px;">${renderStatusBadge(d.status_waka_sdm)}</div>
                                <div style="font-size: 11px; color: #475569; margin-top: 4px; font-style: italic;">Persetujuan SDM</div>
                            </div>

                            <div style="background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">3. Kepala Sekolah</div>
                                <div style="margin-top: 4px;">${renderStatusBadge(d.status_kepsek)}</div>
                                <div style="font-size: 11px; color: #475569; margin-top: 4px; font-style: italic;">${d.catatan_kepsek || '-'}</div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Jadwal Pelajaran Guru yang Terdampak -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-calendar-week" style="color: #2563eb;"></i> Jadwal Pelajaran Guru yang Terdampak
                        </h4>
                        <div class="table-responsive">
                            <table class="custom-table" style="background: #ffffff;">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Sesi / Waktu</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${jadwalRows}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 5. Status Penugasan Guru Pengganti (Guru Piket) -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-user-shield" style="color: #2563eb;"></i> Penugasan Guru Pengganti (Guru Piket)
                        </h4>
                        ${penggantiHtml}
                    </div>

                    <!-- 6. Info Petugas Piket & Salin Link -->
                    <div style="background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                            <div>
                                <span class="detail-label">Petugas Piket yang Memproses</span>
                                <div style="font-size: 12.5px; font-weight: 700; color: #0f172a;">${d.nama_guru_piket}</div>
                            </div>
                            <div>
                                <span class="detail-label">Link Approval Publik</span>
                                <div>
                                    <button type="button" class="btn-table-action btn-action-link" onclick="copyApprovalLink('${d.approval_url}')">
                                        <i class="fa-solid fa-copy"></i> Salin Link Verifikasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Update Footer Modal: jika waka belum memutuskan, berikan tombol aksi langsung
                if (d.status_waka === 'pending' || !d.status_waka) {
                    footer.innerHTML = `
                        <button type="button" class="btn-table-action btn-action-approve" style="padding: 7px 14px; font-size: 12px;" onclick="closeModal('modalDetail'); openApproveModal(${d.id_guru_izin}, '${d.nama_guru.replace(/'/g, "\\'")}')">
                            <i class="fa-solid fa-check"></i> Setujui Izin Ini
                        </button>
                        <button type="button" class="btn-table-action btn-action-reject" style="padding: 7px 14px; font-size: 12px;" onclick="closeModal('modalDetail'); openRejectModal(${d.id_guru_izin}, '${d.nama_guru.replace(/'/g, "\\'")}')">
                            <i class="fa-solid fa-xmark"></i> Tolak Izin Ini
                        </button>
                        <button type="button" class="btn-filter-reset" onclick="closeModal('modalDetail')">Tutup</button>
                    `;
                } else {
                    footer.innerHTML = `
                        <button type="button" class="btn-filter-reset" onclick="closeModal('modalDetail')">Tutup</button>
                    `;
                }
            })
            .catch(err => {
                body.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 20px;">Terjadi kesalahan saat memuat data detail izin.</div>`;
            });
    }

    // Copy Link Clipboard Function
    function copyApprovalLink(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                showToast();
            }).catch(() => {
                fallbackCopyTextToClipboard(url);
            });
        } else {
            fallbackCopyTextToClipboard(url);
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.top = "0";
        textArea.style.left = "0";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showToast();
        } catch (err) {
            prompt("Salin link manual di bawah ini:", text);
        }
        document.body.removeChild(textArea);
    }

    function showToast() {
        var x = document.getElementById("copyToast");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }

    // Close modal on escape
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop-custom').forEach(m => m.classList.remove('show'));
        }
    });

    // Initialize check counts on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateSelectedCount();
    });
</script>
@endsection
