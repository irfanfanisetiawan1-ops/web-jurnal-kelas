@extends('layouts.admin')

@section('title', 'Master Data — Pengguna — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0f7ff',
              100: '#e0effe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              900: '#1e3a8a',
            }
          },
          boxShadow: {
            'card-subtle': '0 2px 10px 0 rgba(15, 23, 42, 0.04)',
            '2xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
          }
        }
      }
    }
</script>

<style>
    /* Custom scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
<<<<<<< HEAD

    .page-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .page-title-group p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .header-user-badge {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #faf3e0;
        padding: 10px 18px;
        border-radius: 20px;
        border: 1px solid #f0e4c8;
    }

    .header-date-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }

    .header-date-info i {
        font-size: 16px;
        color: #3b82f6;
    }

    .header-welcome {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .header-avatar-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background: #334155;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    /* Top Cards Grid */
    .role-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .role-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 95px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .role-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .role-card.active {
        border: 2px solid #4f46e5 !important;
        background: #eff6ff !important;
    }

    /* Filter Panel Drawer */
    .filter-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        display: none;
        animation: filterSlide 0.2s ease-out;
    }

    .filter-panel.show {
        display: block;
    }

    @keyframes filterSlide {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .role-card .role-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    .role-card .role-count {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Controls Bar: Search, + Tambah Pengguna, Filter */
    .controls-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        max-width: 420px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border-radius: 25px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 14px;
        outline: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: all 0.2s;
    }

    .search-input-wrapper input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .action-buttons-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-tambah-user {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 55%, #f1f5f9 100%);
        color: #1e293b;
        border: 1.5px solid #cbd5e1;
        padding: 6px 18px 6px 8px;
        border-radius: 25px;
        font-size: 13.5px;
        font-weight: 700;
        letter-spacing: 0.15px;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.95);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-tambah-icon-wrap {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .btn-tambah-user:hover {
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        color: #1d4ed8;
        border-color: #3b82f6;
        transform: translateY(-1.5px);
        box-shadow: 0 6px 18px -2px rgba(37, 99, 235, 0.2), inset 0 1px 0 rgba(255, 255, 255, 1);
    }

    .btn-tambah-user:hover .btn-tambah-icon-wrap {
        transform: rotate(90deg) scale(1.06);
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.45);
    }

    .btn-tambah-user:active {
        transform: translateY(0) scale(0.98);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .btn-filter-toggle {
        background: #e2d9c8;
        color: #1e293b;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-filter-toggle:hover {
        background: #d4c8b2;
    }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-trash:hover {
        background: #fde68a;
        color: #78350f;
    }

    .btn-trash .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    /* Filter Drawer Panel */
    .filter-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        display: none;
    }

    .filter-panel.show {
        display: block;
    }

    /* Main Table Container */
    .users-table-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .custom-users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-users-table thead tr {
        background: #2b3655;
        color: #ffffff;
    }

    .custom-users-table th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 700;
        text-align: left;
        letter-spacing: 0.3px;
    }

    .custom-users-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        background: #fdfbf7;
    }

    .custom-users-table tbody tr:nth-child(even) td {
        background: #ffffff;
    }

    .custom-users-table tbody tr:hover td {
=======
    ::-webkit-scrollbar-track {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    ::-webkit-scrollbar-button {
        display: none;
        width: 0;
        height: 0;
    }

<<<<<<< HEAD
    /* Toggle Switch ON/OFF Real-time Styling */
    .user-status-switch-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }

    .user-toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
        margin: 0;
        cursor: pointer;
    }

    .user-toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .user-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 24px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .user-toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
    }

    .user-toggle-switch input:checked + .user-toggle-slider {
        background-color: #22c55e;
    }

    .user-toggle-switch input:focus + .user-toggle-slider {
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2), inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .user-toggle-switch input:checked + .user-toggle-slider:before {
        transform: translateX(20px);
    }

    .user-toggle-switch input:disabled + .user-toggle-slider {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .user-status-label {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.2px;
        transition: color 0.2s;
        min-width: 48px;
        text-align: left;
    }

    .user-status-label.status-on {
        color: #16a34a;
    }

    .user-status-label.status-off {
        color: #64748b;
    }

    /* Floating Real-time Toast */
    .realtime-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 999999;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 12px;
        background: #0f172a;
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 600;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    .realtime-toast.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .realtime-toast.toast-success {
        border-left: 5px solid #22c55e;
    }

    .realtime-toast.toast-error {
        border-left: 5px solid #ef4444;
    }

    /* Role Badges */
    .role-badge {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 6px;
=======
    /* Hidden Scrollbar for Role Metrics Cards (Clean Arrow Navigation) */
    .role-metrics-scroll {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
        -webkit-overflow-scrolling: touch;
    }
    .role-metrics-scroll::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
        width: 0;
        height: 0;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    /* Role Cards Arrow Navigation Buttons */
    .role-nav-btn {
        opacity: 0;
        pointer-events: none;
        visibility: hidden;
        transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease, visibility 0.22s ease;
    }
    #roleMetricsWrapper:hover .role-nav-btn.can-scroll,
    #roleMetricsWrapper:focus-within .role-nav-btn.can-scroll {
        opacity: 1;
        pointer-events: auto;
        visibility: visible;
    }

    /* Clean User Table Pagination (Individual Separate Rounded-lg Buttons) */
    .user-table-pagination nav > div.sm\:hidden {
        display: none !important;
    }
    .user-table-pagination nav div.sm\:flex-1 > div:first-child {
        display: none !important;
    }
    .user-table-pagination nav div.sm\:flex-1 {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
    }
    /* Strip outer container pill styling completely */
    .user-table-pagination nav span.shadow-sm.rounded-md {
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
        border-radius: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.375rem !important; /* gap-1.5 */
    }
    /* Strip wrapper spans that enclose links or active pages */
    .user-table-pagination nav span.shadow-sm.rounded-md > span,
    .user-table-pagination nav span[aria-disabled="true"],
    .user-table-pagination nav span[aria-current="page"] {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: inline-flex !important;
    }
    /* Individual button styling: buttons can be <a> or <span> */
    .user-table-pagination nav span.shadow-sm.rounded-md a,
    .user-table-pagination nav span.shadow-sm.rounded-md > span > span,
    .user-table-pagination nav span.shadow-sm.rounded-md span[aria-disabled="true"] > span,
    .user-table-pagination nav span.shadow-sm.rounded-md span[aria-current="page"] > span {
        width: 2rem !important; /* 32px (w-8) */
        height: 2rem !important; /* 32px (h-8) */
        min-width: 2rem !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 0.5rem !important; /* rounded-lg */
        font-size: 0.75rem !important; /* text-xs */
        font-weight: 600 !important;
        margin: 0 !important;
        box-shadow: none !important;
        transition: all 0.15s ease !important;
        border: 1px solid #e2e8f0 !important; /* border-slate-200 */
        background-color: #ffffff !important;
        color: #475569 !important; /* text-slate-600 */
        text-decoration: none !important;
    }
    /* Inactive page link hover */
    .user-table-pagination nav span.shadow-sm.rounded-md a:hover {
        background-color: #f8fafc !important; /* hover:bg-slate-50 */
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }
    /* Active Page Button */
    .user-table-pagination nav span.shadow-sm.rounded-md span[aria-current="page"] > span {
        background-color: #2563eb !important; /* bg-blue-600 */
        border-color: #2563eb !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    /* Disabled Previous / Next buttons */
    .user-table-pagination nav span.shadow-sm.rounded-md span[aria-disabled="true"] > span {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important; /* text-slate-300 */
        cursor: not-allowed !important;
        opacity: 0.7 !important;
    }
    /* Arrow icon sizing inside buttons */
    .user-table-pagination nav span.shadow-sm.rounded-md svg {
        width: 0.875rem !important;
        height: 0.875rem !important;
    }

    /* Modal Backdrop & Popup Animation */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-backdrop-custom.active,
    .modal-backdrop-custom.show {
        display: flex;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 1.25rem;
        max-width: 580px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalPop 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.96) translateY(6px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

<<<<<<< HEAD
    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        background: #2b3655;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 700;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.8;
    }

    .modal-close:hover { opacity: 1; }

    .modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #4f46e5;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #4f46e5;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-grey-batch {
        background: #64748b;
        color: #ffffff;
        border: 1px solid #475569;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 5px rgba(100, 116, 139, 0.25);
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-grey-batch:hover {
        background: #475569;
        border-color: #334155;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(71, 85, 105, 0.35);
    }
    .btn-grey-batch:active {
        transform: translateY(0);
    }

    .btn-bulk-delete {
        background: #e11d48;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(225, 29, 72, 0.2);
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-bulk-delete:disabled,
    .btn-bulk-delete.is-disabled {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #cbd5e1;
        opacity: 0.6;
        cursor: not-allowed;
        box-shadow: none;
    }
    .btn-bulk-delete:not(:disabled):hover {
        background: #be123c;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.35);
    }
    .btn-bulk-delete:not(:disabled):active {
        transform: translateY(0);
    }
    .badge-count-bulk {
        background: rgba(255, 255, 255, 0.25);
        color: inherit;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 20px;
        min-width: 20px;
        text-align: center;
    }
    .btn-bulk-delete:disabled .badge-count-bulk,
    .btn-bulk-delete.is-disabled .badge-count-bulk {
        background: #e2e8f0;
        color: #64748b;
    }

    @media (max-width: 992px) {
        .role-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .role-cards-grid {
            grid-template-columns: 1fr;
        }
=======
    /* Clean up pagination text */
    nav[role="navigation"] p.text-sm {
        display: none;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 700; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Master Data — Pengguna
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 480px;">
        Kelola data akun pengguna, verifikasi pendaftaran guru, dan atur hak akses role sistem
    </p>
</div>
@endsection

@section('content')

<div class="space-y-5">

    <!-- Flash Notification Alerts -->
    @if(session('success'))
        <div class="flex items-center justify-between gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                    </svg>
                </span>
                <span class="flex-1">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
    @endif

<<<<<<< HEAD
<div class="role-cards-grid" style="grid-template-columns: repeat(6, 1fr); margin-bottom: 24px;">
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'waka'])) }}" 
       class="role-card {{ request('role') == 'waka' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Waka Kurikulum">
        <div class="role-title">Waka Kurikulum</div>
        <div class="role-count">{{ $countWaka ?? 0 }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'waka_kesiswaan'])) }}" 
       class="role-card {{ request('role') == 'waka_kesiswaan' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Waka Kesiswaan">
        <div class="role-title">Waka Kesiswaan</div>
        <div class="role-count">{{ $countWakaKesiswaan ?? 0 }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'waka_sdm'])) }}" 
       class="role-card {{ request('role') == 'waka_sdm' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Waka SDM">
        <div class="role-title">Waka SDM</div>
        <div class="role-count">{{ $countWakaSdm ?? 0 }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'kepala_sekolah'])) }}" 
       class="role-card {{ request('role') == 'kepala_sekolah' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Kepala Sekolah">
        <div class="role-title">Kepala Sekolah</div>
        <div class="role-count">{{ $countKepalaSekolah ?? 0 }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'satpam'])) }}" 
       class="role-card {{ request('role') == 'satpam' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Satpam">
        <div class="role-title">Satpam Gerbang</div>
        <div class="role-count">{{ $countSatpam ?? 0 }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'orang_tua'])) }}" 
       class="role-card {{ request('role') == 'orang_tua' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Orang Tua">
        <div class="role-title">Orang Tua</div>
        <div class="role-count">{{ $countOrangTua ?? 0 }}</div>
    </a>
</div>

@if($countPending > 0)
    <div class="alert alert-error" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a;">
        <i class="fa-solid fa-bell"></i>
        <span>Terdapat <strong>{{ $countPending }} akun baru</strong> yang menunggu verifikasi persetujuan dari Anda (Admin TU).</span>
    </div>
@endif

<!-- Controls Bar: Search & Action Buttons -->
<div class="controls-bar">
    <form action="{{ route('admin.verifikasi-guru') }}" method="GET" class="search-input-wrapper">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pengguna...." onchange="this.form.submit()">
        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    </form>

    <div class="action-buttons-group">
        <button type="button" class="btn-tambah-user" onclick="openModal('modalTambahUser')">
            <span class="btn-tambah-icon-wrap">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span>Tambah Pengguna</span>
=======
    @if(session('error'))
        <div class="flex items-center justify-between gap-3 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center shrink-0 text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"/>
                    </svg>
                </span>
                <span class="flex-1">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
    @endif

    <!-- BEGIN: 8 Role Metric Cards (Horizontal Scrollable with Floating Arrow Nav) -->
    <div class="relative group/metrics" id="roleMetricsWrapper">
        <!-- Tombol Panah Kiri -->
        <button type="button" 
                id="roleScrollLeftBtn"
                aria-label="Geser kartu ke kiri"
                class="role-nav-btn absolute -left-1 sm:-left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/95 backdrop-blur-md shadow-md hover:shadow-lg border border-slate-200/80 text-slate-700 hover:text-blue-600 hover:bg-white hover:scale-105 active:scale-95 flex items-center justify-center cursor-pointer transition-all duration-200 focus:outline-hidden focus:ring-2 focus:ring-blue-500/40 select-none"
                title="Geser ke kiri">
            <svg class="w-5 h-5 -ml-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </button>

        <!-- Container Kartu -->
        <section class="flex items-center gap-3.5 overflow-x-auto py-1.5 px-1 sm:px-1.5 role-metrics-scroll scroll-smooth select-none" 
                 id="roleMetricsScroll" 
                 data-purpose="role-metrics-scroll">
        <!-- 1. Admin / TU (Biru) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'tu' ? null : 'tu'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'tu' ? 'border-2 border-blue-600 bg-gradient-to-br from-blue-50 via-blue-50/60 to-white ring-2 ring-blue-500/20' : 'border border-blue-100/70 bg-gradient-to-br from-blue-50/80 via-white to-blue-50/30 hover:border-blue-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Admin / TU">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'tu' ? 'bg-gradient-to-b from-blue-100 to-blue-200/70 border-blue-300/60 text-blue-700 scale-105' : 'bg-gradient-to-b from-blue-100/90 to-blue-200/50 border-blue-200/40 text-blue-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11v2m1-1h-2"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'tu' ? 'text-blue-800' : 'text-slate-700 group-hover:text-blue-700' }} transition-colors truncate">
                    Admin / TU
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countAdmin) }}
                    </span>
                    @if(request('role') == 'tu')
                        <span class="w-2 h-2 rounded-full bg-blue-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-blue-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

<<<<<<< HEAD
        <button type="button" id="btnBulkDeleteUsers" class="btn-bulk-delete is-disabled" disabled onclick="confirmBulkDeleteUsers()" title="Pilih akun pengguna dengan mencentang checkbox untuk menghapus secara massal">
            <i class="fa-solid fa-trash-can"></i>
            <span>Hapus Terpilih</span>
            <span class="badge-count-bulk" id="bulkDeleteCount">0</span>
=======
        <!-- 2. Guru Mapel (Ungu) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'guru' ? null : 'guru'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'guru' ? 'border-2 border-purple-600 bg-gradient-to-br from-purple-50 via-purple-50/60 to-white ring-2 ring-purple-500/20' : 'border border-purple-100/70 bg-gradient-to-br from-purple-50/80 via-white to-purple-50/30 hover:border-purple-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Guru Mapel">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'guru' ? 'bg-gradient-to-b from-purple-100 to-purple-200/70 border-purple-300/60 text-purple-700 scale-105' : 'bg-gradient-to-b from-purple-100/90 to-purple-200/50 border-purple-200/40 text-purple-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'guru' ? 'text-purple-800' : 'text-slate-700 group-hover:text-purple-700' }} transition-colors truncate">
                    Guru Mapel
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countGuruMapel) }}
                    </span>
                    @if(request('role') == 'guru')
                        <span class="w-2 h-2 rounded-full bg-purple-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-purple-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 3. Wali Kelas (Hijau) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'wali_kelas' ? null : 'wali_kelas'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'wali_kelas' ? 'border-2 border-emerald-600 bg-gradient-to-br from-emerald-50 via-emerald-50/60 to-white ring-2 ring-emerald-500/20' : 'border border-emerald-100/70 bg-gradient-to-br from-emerald-50/80 via-white to-emerald-50/30 hover:border-emerald-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Wali Kelas">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'wali_kelas' ? 'bg-gradient-to-b from-emerald-100 to-emerald-200/70 border-emerald-300/60 text-emerald-700 scale-105' : 'bg-gradient-to-b from-emerald-100/90 to-emerald-200/50 border-emerald-200/40 text-emerald-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'wali_kelas' ? 'text-emerald-800' : 'text-slate-700 group-hover:text-emerald-700' }} transition-colors truncate">
                    Wali Kelas
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countWaliKelas) }}
                    </span>
                    @if(request('role') == 'wali_kelas')
                        <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-emerald-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 4. Guru Piket (Oranye) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'piket' ? null : 'piket'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'piket' ? 'border-2 border-amber-600 bg-gradient-to-br from-amber-50 via-amber-50/60 to-white ring-2 ring-amber-500/20' : 'border border-amber-100/70 bg-gradient-to-br from-amber-50/80 via-white to-orange-50/30 hover:border-amber-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Guru Piket">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'piket' ? 'bg-gradient-to-b from-amber-100 to-amber-200/70 border-amber-300/60 text-amber-700 scale-105' : 'bg-gradient-to-b from-amber-100/90 to-amber-200/50 border-amber-200/40 text-amber-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'piket' ? 'text-amber-800' : 'text-slate-700 group-hover:text-amber-700' }} transition-colors truncate">
                    Guru Piket
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countGuruPiket) }}
                    </span>
                    @if(request('role') == 'piket')
                        <span class="w-2 h-2 rounded-full bg-amber-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-amber-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="45" cy="50" r="9" fill="currentColor" opacity="0.4"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 5. Waka Kurikulum (Teal) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'waka' ? null : 'waka'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'waka' ? 'border-2 border-teal-600 bg-gradient-to-br from-teal-50 via-teal-50/60 to-white ring-2 ring-teal-500/20' : 'border border-teal-100/70 bg-gradient-to-br from-teal-50/80 via-white to-cyan-50/30 hover:border-teal-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Waka Kurikulum">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'waka' ? 'bg-gradient-to-b from-teal-100 to-teal-200/70 border-teal-300/60 text-teal-700 scale-105' : 'bg-gradient-to-b from-teal-100/90 to-teal-200/50 border-teal-200/40 text-teal-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'waka' ? 'text-teal-800' : 'text-slate-700 group-hover:text-teal-700' }} transition-colors truncate">
                    Waka Kurikulum
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countWaka ?? 0) }}
                    </span>
                    @if(request('role') == 'waka')
                        <span class="w-2 h-2 rounded-full bg-teal-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-teal-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 6. Waka SDM (Pink / Rose) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'waka_sdm' ? null : 'waka_sdm'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'waka_sdm' ? 'border-2 border-rose-600 bg-gradient-to-br from-rose-50 via-rose-50/60 to-white ring-2 ring-rose-500/20' : 'border border-rose-100/70 bg-gradient-to-br from-rose-50/80 via-white to-pink-50/30 hover:border-rose-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Waka SDM">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'waka_sdm' ? 'bg-gradient-to-b from-rose-100 to-rose-200/70 border-rose-300/60 text-rose-700 scale-105' : 'bg-gradient-to-b from-rose-100/90 to-rose-200/50 border-rose-200/40 text-rose-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2H9.17A3.001 3.001 0 0112 14z"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'waka_sdm' ? 'text-rose-800' : 'text-slate-700 group-hover:text-rose-700' }} transition-colors truncate">
                    Waka SDM
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countWakaSdm ?? 0) }}
                    </span>
                    @if(request('role') == 'waka_sdm')
                        <span class="w-2 h-2 rounded-full bg-rose-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-rose-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 7. Kepala Sekolah (Sky / Biru Muda) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'kepala_sekolah' ? null : 'kepala_sekolah'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'kepala_sekolah' ? 'border-2 border-sky-600 bg-gradient-to-br from-sky-50 via-sky-50/60 to-white ring-2 ring-sky-500/20' : 'border border-sky-100/70 bg-gradient-to-br from-sky-50/80 via-white to-blue-50/30 hover:border-sky-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Kepala Sekolah">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'kepala_sekolah' ? 'bg-gradient-to-b from-sky-100 to-sky-200/70 border-sky-300/60 text-sky-700 scale-105' : 'bg-gradient-to-b from-sky-100/90 to-sky-200/50 border-sky-200/40 text-sky-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'kepala_sekolah' ? 'text-sky-800' : 'text-slate-700 group-hover:text-sky-700' }} transition-colors truncate">
                    Kepala Sekolah
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countKepalaSekolah ?? 0) }}
                    </span>
                    @if(request('role') == 'kepala_sekolah')
                        <span class="w-2 h-2 rounded-full bg-sky-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-sky-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>

        <!-- 8. Satpam Gerbang (Indigo / Ungu Muda) -->
        <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => request('role') == 'satpam' ? null : 'satpam'])) }}" 
           class="w-56 min-w-[224px] max-w-[224px] shrink-0 h-[86px] rounded-2xl p-3.5 {{ request('role') == 'satpam' ? 'border-2 border-indigo-600 bg-gradient-to-br from-indigo-50 via-indigo-50/60 to-white ring-2 ring-indigo-500/20' : 'border border-indigo-100/70 bg-gradient-to-br from-indigo-50/80 via-white to-purple-50/30 hover:border-indigo-300' }} shadow-2xs hover:shadow-xs hover:-translate-y-0.5 transition-all duration-150 flex items-center gap-3 group no-underline relative overflow-hidden"
           title="Filter: Satpam Gerbang">
            <div class="w-12 h-12 rounded-[18px] {{ request('role') == 'satpam' ? 'bg-gradient-to-b from-indigo-100 to-indigo-200/70 border-indigo-300/60 text-indigo-700 scale-105' : 'bg-gradient-to-b from-indigo-100/90 to-indigo-200/50 border-indigo-200/40 text-indigo-600 group-hover:scale-105' }} border flex items-center justify-center shrink-0 shadow-2xs transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="flex flex-col min-w-0 flex-1 justify-center z-10">
                <span class="text-xs font-bold {{ request('role') == 'satpam' ? 'text-indigo-800' : 'text-slate-700 group-hover:text-indigo-700' }} transition-colors truncate">
                    Satpam Gerbang
                </span>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                        {{ number_format($countSatpam ?? 0) }}
                    </span>
                    @if(request('role') == 'satpam')
                        <span class="w-2 h-2 rounded-full bg-indigo-600 shrink-0"></span>
                    @endif
                </div>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-indigo-200/50 pointer-events-none z-0" viewBox="0 0 100 100" fill="none">
                <circle cx="90" cy="90" r="70" stroke="currentColor" stroke-width="8" opacity="0.4"/>
                <circle cx="90" cy="90" r="45" stroke="currentColor" stroke-width="7" opacity="0.55"/>
                <circle cx="90" cy="90" r="20" stroke="currentColor" stroke-width="6" opacity="0.7"/>
            </svg>
        </a>
    </section>

        <!-- Tombol Panah Kanan -->
        <button type="button" 
                id="roleScrollRightBtn"
                aria-label="Geser kartu ke kanan"
                class="role-nav-btn absolute -right-1 sm:-right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/95 backdrop-blur-md shadow-md hover:shadow-lg border border-slate-200/80 text-slate-700 hover:text-blue-600 hover:bg-white hover:scale-105 active:scale-95 flex items-center justify-center cursor-pointer transition-all duration-200 focus:outline-hidden focus:ring-2 focus:ring-blue-500/40 select-none"
                title="Geser ke kanan">
            <svg class="w-5 h-5 -mr-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </button>
    </div>
    <!-- END: 8 Role Metric Cards -->

    <!-- BEGIN: Verification Alert Banner (Clean SVG Bell) -->
    @if($countPending > 0)
        <section class="bg-amber-50/90 border border-amber-200/80 rounded-2xl px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-amber-900 shadow-2xs" data-purpose="notification-alert">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-amber-100/90 border border-amber-200 flex items-center justify-center shrink-0 text-amber-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </span>
                <p class="text-xs sm:text-sm font-medium">
                    Terdapat <strong class="font-black text-amber-950">{{ $countPending }} akun baru</strong> yang menunggu verifikasi persetujuan dari Anda (Admin TU).
                </p>
            </div>
            <a href="{{ route('admin.verifikasi-guru', ['status' => 'pending']) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-800 hover:text-amber-950 bg-amber-200/70 hover:bg-amber-200 px-3.5 py-1.5 rounded-xl transition-colors shrink-0 no-underline self-start sm:self-auto">
                <span>Tinjau Akun Pending</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </a>
        </section>
    @endif
    <!-- END: Verification Alert Banner -->

    <!-- BEGIN: Filter & Toolbar Controls Card -->
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-card-subtle p-4 sm:p-5 space-y-4" data-purpose="toolbar-controls">
        <!-- Top Row: Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3.5 border-b border-slate-100">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Daftar Akun Pengguna</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pencarian akun, seleksi role, verifikasi status, dan kelola kredensial pengguna.</p>
            </div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <!-- Tambah Pengguna Button -->
                <button type="button" onclick="openModal('modalTambahUser')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-sm transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Tambah Pengguna</span>
                </button>

                <!-- Trash Bin Button -->
                <a href="{{ route('admin.users-trash') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 text-amber-800 font-semibold rounded-xl text-xs shadow-2xs transition-colors no-underline">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Lihat Sampah Pengguna</span>
                    <span class="inline-flex items-center justify-center px-1.5 py-0.5 bg-amber-500 text-white rounded-full text-[10px] font-bold leading-none">{{ $trashedCount ?? 0 }}</span>
                </a>
            </div>
        </div>

<<<<<<< HEAD
        <div style="flex:1; min-width:180px;">
            <label style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:4px; display:block;">Status Akun / Verifikasi</label>
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif (ON)</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif (OFF)</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified (Disetujui)</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
            </select>
=======
        <!-- Bottom Row: Filter Bar (Search + Dropdown Role + Dropdown Status + Cari & Reset) -->
        <form action="{{ route('admin.verifikasi-guru') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
            <!-- Search Input -->
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, username, atau email..." class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-2xs">
            </div>

            <!-- Filter Dropdown Role -->
            <div class="w-full lg:w-48">
                <select name="role" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-2xs">
                    <option value="">-- Semua Role --</option>
                    <option value="tu" {{ request('role') == 'tu' ? 'selected' : '' }}>Admin / TU</option>
                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru Mapel</option>
                    <option value="piket" {{ request('role') == 'piket' ? 'selected' : '' }}>Guru Piket</option>
                    <option value="wali_kelas" {{ request('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="waka" {{ request('role') == 'waka' ? 'selected' : '' }}>Waka Kurikulum</option>
                    <option value="waka_sdm" {{ request('role') == 'waka_sdm' ? 'selected' : '' }}>Waka SDM</option>
                    <option value="kepala_sekolah" {{ request('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="satpam" {{ request('role') == 'satpam' ? 'selected' : '' }}>Satpam Gerbang</option>
                    <option value="orang_tua" {{ request('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                </select>
            </div>

            <!-- Filter Dropdown Status -->
            <div class="w-full lg:w-44">
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-2xs">
                    <option value="">-- Semua Status --</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified (Disetujui)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                </select>
            </div>

            <!-- Grouped Buttons: Cari & Reset -->
            <div class="flex items-center gap-2 shrink-0">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-2xs transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Cari</span>
                </button>
                <a href="{{ route('admin.verifikasi-guru') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs border border-slate-200 shadow-2xs transition-colors no-underline">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </section>
    <!-- END: Filter & Toolbar Controls Card -->

    <!-- BEGIN: Contextual Selection & Bulk Action Toolbar -->
    <div id="bulkActionsToolbar" class="hidden p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
        <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                </svg>
            </span>
            <span>
                <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> akun pengguna dipilih
            </span>
            <span class="text-rose-300 mx-1">|</span>
            <button type="button" onclick="deselectAllUsers()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
                Batalkan pilihan
            </button>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>

        <button type="button" id="btnBulkDelete" onclick="openBulkDeleteModal()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-xs cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
            <span>Hapus Terpilih</span>
        </button>
    </div>
    <!-- END: Contextual Selection & Bulk Action Toolbar -->

<<<<<<< HEAD
<!-- Table Data Pengguna Form Bulk Delete -->
<form id="formBulkDeleteUsers" action="{{ route('admin.users.destroy-batch') }}" method="POST">
    @csrf
    @method('DELETE')

    <div class="users-table-container">
        <div style="overflow-x: auto;">
            <table class="custom-users-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllUsers" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua di Halaman Ini" onchange="toggleSelectAllUsers(this)">
                        </th>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th style="width: 140px; text-align: center;">Status</th>
                        <th style="width: 340px; min-width: 320px; white-space: nowrap; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        <tr data-user="{{ json_encode($u) }}" onclick="openDetailModalFromEl(this)" style="cursor: pointer;" title="Klik baris data ini untuk melihat rincian detail akun {{ $u->name }}">
                            <td style="text-align: center;" onclick="event.stopPropagation();">
                                <input type="checkbox" name="ids[]" value="{{ $u->id }}" class="user-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()" {{ $u->id === Auth::id() ? 'disabled title="Tidak dapat menghapus akun Anda sendiri yang sedang digunakan"' : '' }}>
                            </td>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $u->name }}</div>
                                <div style="font-size: 12px; color: #64748b;">
                                    @if(in_array($u->role, ['piket', 'satpam']))
                                        Username: <strong style="color: #0284c7;">{{ $u->username ?? '-' }}</strong> <span style="font-size: 11px; color: #64748b;">(Akun Petugas - Tanpa NIP)</span>
                                    @else
                                        {{ $u->role === 'orang_tua' ? 'NISN' : 'NIP' }}: {{ $u->nip ?? '-' }} | Username: {{ $u->username ?? '-' }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="password-simple-badge" title="Password terenkripsi (Bcrypt)">
                                    <i class="fa-solid fa-lock" style="font-size:11px; color:#4f46e5;"></i>
                                    <span>Terenkripsi</span>
                                </div>
                            </td>
                            <td>
                                <div class="role-badge">
                                    <span>
                                        {{ $u->role_label }}
                                    </span>
                                    @if(in_array($u->role, ['admin', 'tu']))
                                        <span class="pill-super">Super</span>
                                    @endif
                                    @if($u->status_verifikasi === 'pending')
                                        <span class="pill-pending">Pending</span>
                                    @endif
                                </div>
                            </td>
                            <td style="font-size: 13px; color: #475569;">
                                {{ $u->created_at ? $u->created_at->format('d/m/Y') : '11/02/2026' }}
                            </td>
                            <td style="text-align: center; white-space: nowrap;" onclick="event.stopPropagation();">
                                <div class="user-status-switch-wrapper" style="justify-content: center;">
                                    <label class="user-toggle-switch" title="{{ $u->id === Auth::id() ? 'Akun Anda sedang aktif digunakan (tidak dapat dinonaktifkan)' : ($u->isActive() ? 'Klik untuk Menonaktifkan akun ini (OFF)' : 'Klik untuk Mengaktifkan akun ini (ON)') }}">
                                        <input type="checkbox" 
                                               id="toggle-user-{{ $u->id }}" 
                                               class="user-active-checkbox"
                                               {{ $u->isActive() ? 'checked' : '' }} 
                                               {{ $u->id === Auth::id() ? 'disabled' : '' }}
                                               onchange="handleUserToggle(this, {{ $u->id }}, '{{ addslashes($u->name) }}')">
                                        <span class="user-toggle-slider"></span>
                                    </label>
                                    <span class="user-status-label {{ $u->isActive() ? 'status-on' : 'status-off' }}" id="status-label-{{ $u->id }}">
                                        {{ $u->isActive() ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </td>
                            <td style="white-space: nowrap;" onclick="event.stopPropagation();">
                                <div class="table-actions" style="justify-content: center;">
                                    @if($u->status_verifikasi === 'pending')
                                        <form action="{{ route('admin.verifikasi-guru.approve', $u->id) }}" method="POST" style="display:inline-flex; flex-shrink:0; margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-action-badge btn-action-approve" title="Setujui: Mengonfirmasi dan mengaktifkan pendaftaran akun">
                                                <i class="fa-solid fa-circle-check"></i> <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi-guru.reject', $u->id) }}" method="POST" style="display:inline-flex; flex-shrink:0; margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-action-badge btn-action-reject" title="Tolak: Menolak pendaftaran akun guru ini">
                                                <i class="fa-solid fa-circle-xmark"></i> <span>Tolak</span>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn-action-badge btn-action-view" data-user="{{ json_encode($u) }}" onclick="event.stopPropagation(); openDetailModalFromEl(this);" title="Lihat Detail: Menampilkan rincian lengkap data profil & akun pengguna">
                                            <i class="fa-solid fa-eye"></i> <span>Detail</span>
                                        </button>

                                        <button type="button" class="btn-action-badge btn-action-edit" data-user="{{ json_encode($u) }}" onclick="event.stopPropagation(); openEditModalFromEl(this);" title="Edit Role: Mengubah NIP, nama, email, role hak akses & status akun">
                                            <i class="fa-solid fa-pen-to-square"></i> <span>Edit</span>
                                        </button>

                                        <button type="button" class="btn-action-badge btn-action-key" onclick="event.stopPropagation(); openResetPasswordModal({{ $u->id }}, '{{ addslashes($u->name) }}');" title="Ubah Password: Mengubah password akun ini dengan password baru">
                                            <i class="fa-solid fa-key"></i> <span>Ubah Pass</span>
                                        </button>

                                        @if($u->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onclick="event.stopPropagation();" onsubmit="return confirm('Pindahkan akun {{ addslashes($u->name) }} ({{ addslashes($u->getRoleLabelAttribute()) }}) ke Tempat Sampah?')" style="display:inline-flex; flex-shrink:0; margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-badge btn-action-delete" title="Hapus Akun: Memindahkan akun pengguna ini ke Tempat Sampah">
                                                    <i class="fa-solid fa-trash-can"></i> <span>Hapus</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-user-slash" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="table-footer">
            <div>
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</form>
=======
    <!-- BEGIN: User Data Table Container -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden" data-purpose="table-wrapper">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse" id="user-management-table">
                <!-- Table Header: Light Style (Consistent with Guru/Kelas/Mapel) -->
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-slate-700 uppercase text-[11px] font-bold tracking-wider">
                        <th class="py-3.5 pl-6 pr-3 w-12 text-center" scope="col">
                            <input type="checkbox" id="selectAllUsers" onchange="toggleSelectAllUsers(this)" class="rounded border-slate-300 bg-white text-blue-600 focus:ring-0 focus:ring-offset-0 cursor-pointer" title="Pilih Semua (Select All)">
                        </th>
                        <th class="py-3.5 px-3 text-center text-slate-500 font-semibold w-12" scope="col">No</th>
                        <th class="py-3.5 px-5 min-w-[240px]" scope="col">Nama Pengguna</th>
                        <th class="py-3.5 px-4 text-center min-w-[130px]" scope="col">Password</th>
                        <th class="py-3.5 px-5 min-w-[160px]" scope="col">Role</th>
                        <th class="py-3.5 px-4 text-slate-500 min-w-[110px]" scope="col">Dibuat Pada</th>
                        <th class="py-3.5 pl-4 pr-6 sm:pr-8 text-center min-w-[340px]" scope="col">Aksi</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="divide-y divide-slate-100 font-normal text-slate-700">
                    @forelse($users as $index => $u)
                        @php
                            $isPending = ($u->status_verifikasi === 'pending');
                            $isSelf = ($u->id === Auth::id());
                            $userPayload = [
                                'id' => $u->id,
                                'name' => $u->name,
                                'nip' => $u->nip,
                                'username' => $u->username,
                                'email' => $u->email,
                                'role' => $u->role,
                                'role_label' => $u->role_label,
                                'jenis_kelamin' => $u->jenis_kelamin,
                                'no_hp' => $u->no_hp,
                                'status_verifikasi' => $u->status_verifikasi,
                                'created_at_formatted' => $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-',
                            ];
                        @endphp
                        <tr class="{{ $isPending ? 'bg-amber-50/35 hover:bg-amber-50/70' : 'hover:bg-slate-50/80' }} transition-colors" data-user="{{ json_encode($userPayload) }}">
                            <!-- Checkbox Column -->
                            <td class="py-3.5 pl-6 pr-3 text-center">
                                <input type="checkbox" class="user-row-checkbox rounded border-slate-300 text-blue-600 focus:ring-0 focus:ring-offset-0 cursor-pointer" 
                                       value="{{ $u->id }}" 
                                       data-name="{{ $u->name }}" 
                                       onchange="handleUserCheckboxChange()"
                                       {{ $isSelf ? 'disabled title="Tidak dapat menghapus akun Anda sendiri"' : '' }}>
                            </td>

                            <!-- No Column -->
                            <td class="py-3.5 px-3 text-center font-semibold text-slate-500">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <!-- Nama & Identitas Pengguna -->
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $u->name }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1.5 flex-wrap">
                                    <span>{{ $u->role === 'orang_tua' ? 'NISN' : 'NIP' }}: <code class="font-mono text-slate-700 bg-slate-100 px-1 py-0.5 rounded">{{ $u->nip ?? '-' }}</code></span>
                                    <span class="text-slate-300">|</span>
                                    <span>Username: <span class="font-medium text-slate-700">{{ $u->username ?? '-' }}</span></span>
                                </div>
                            </td>

                            <!-- Password Terenkripsi Badge -->
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200/70 rounded-full text-xs font-medium shadow-2xs" title="Password terenkripsi satu arah dengan Bcrypt">
                                    <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    </svg>
                                    <span>Terenkripsi</span>
                                </span>
                            </td>

                            <!-- Role & Status Badge -->
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="font-semibold text-slate-800 text-xs">{{ $u->role_label }}</span>
                                    @if(in_array($u->role, ['admin', 'tu']))
                                        <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 border border-blue-200 rounded text-[10px] font-bold leading-none">Super</span>
                                    @endif
                                    @if($u->status_verifikasi === 'pending')
                                        <span class="px-1.5 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 rounded text-[10px] font-bold leading-none">Pending</span>
                                    @elseif($u->status_verifikasi === 'rejected')
                                        <span class="px-1.5 py-0.5 bg-rose-100 text-rose-800 border border-rose-300 rounded text-[10px] font-bold leading-none">Ditolak</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Dibuat Pada -->
                            <td class="py-3.5 px-4 text-slate-500 font-medium text-xs">
                                {{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}
                            </td>

                            <!-- Aksi Column -->
                            <td class="py-3.5 pl-4 pr-6 sm:pr-8 text-center whitespace-nowrap">
                                @if($isPending)
                                    <!-- Pending Approval Actions -->
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.verifikasi-guru.approve', $u->id) }}" method="POST" class="inline-flex m-0">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/80 rounded-lg text-xs font-bold transition-colors cursor-pointer" title="Setujui pendaftaran akun pengguna ini">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                                                </svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi-guru.reject', $u->id) }}" method="POST" class="inline-flex m-0">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 rounded-lg text-xs font-bold transition-colors cursor-pointer" title="Tolak pendaftaran akun guru ini">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                                                </svg>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Verified Standard Actions (Detail = Sky, Edit = Amber, Ubah Pass = Indigo, Hapus = Rose) -->
                                    <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                        <!-- Detail Button -->
                                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200/70 rounded-lg text-xs font-semibold transition-colors cursor-pointer" data-user="{{ json_encode($userPayload) }}" onclick="openDetailModalFromEl(this)" title="Lihat Detail Profil Akun">
                                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        <!-- Edit Button -->
                                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/70 rounded-lg text-xs font-semibold transition-colors cursor-pointer" data-user="{{ json_encode($userPayload) }}" onclick="openEditModalFromEl(this)" title="Edit Role & Identitas Akun">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Edit</span>
                                        </button>

                                        <!-- Ubah Pass Button: Indigo Palette (No Purple!) -->
                                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200/70 rounded-lg text-xs font-semibold transition-colors cursor-pointer" onclick="openResetPasswordModal({{ $u->id }}, '{{ addslashes($u->name) }}')" title="Ubah Password Akun">
                                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Ubah Pass</span>
                                        </button>

                                        <!-- Hapus Button -->
                                        @if(!$isSelf)
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Pindahkan akun {{ addslashes($u->name) }} ({{ addslashes($u->getRoleLabelAttribute()) }}) ke Tempat Sampah?')" class="inline-flex m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/70 rounded-lg text-xs font-semibold transition-colors cursor-pointer" title="Pindahkan Akun ke Tempat Sampah">
                                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 px-4 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"/>
                                </svg>
                                <span class="block font-bold text-slate-600 text-sm">Tidak ada data pengguna yang sesuai kriteria.</span>
                                <span class="text-xs text-slate-400 mt-1 block">Silakan sesuaikan kata kunci pencarian atau bersihkan filter role/status.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <footer class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-t border-slate-100 bg-white" data-purpose="table-pagination-container">
            <p class="text-xs font-medium text-slate-500">
                Menampilkan <span class="font-semibold text-slate-800">{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-800">{{ $users->total() }}</span> data
            </p>
            <div class="user-table-pagination">
                {{ $users->links() }}
            </div>
        </footer>
    </div>
    <!-- END: User Data Table Container -->

</div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODALS SECTION -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->

<!-- Modal 1: Tambah Pengguna Baru -->
<div class="modal-backdrop-custom" id="modalTambahUser">
    <div class="modal-box-custom max-w-2xl max-h-[92vh] flex flex-col">
        <!-- Modal Header -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Buat Akun Pengguna Baru</h3>
                    <p class="text-[11px] text-slate-500">Otorisasi pendaftaran akun pengguna oleh Administrator TU.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalTambahUser')" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validatePasswordSubmit(event)" class="overflow-y-auto p-5 space-y-4 text-xs">
            @csrf
            <input type="hidden" name="id_siswa" id="add_id_siswa" value="">

            <div class="p-3.5 bg-blue-50/80 border border-blue-200/80 rounded-xl text-blue-900 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><line x1="12" y1="16" x2="12" y2="12" stroke-width="2"/><line x1="12" y1="8" x2="12.01" y2="8" stroke-width="2"/></svg>
                <div>
                    <strong class="font-bold block text-blue-950">Persyaratan NIP / NISN &amp; Role:</strong>
                    <span>Pilih guru dari Data Master Guru untuk auto-fill data. Khusus role <em>Orang Tua</em>, pilih NISN dari Data Master Siswa.</span>
                </div>
            </div>

            <!-- Master Data Guru Quick Picker -->
            <div id="guruPickerContainer" class="p-3.5 bg-slate-50 border border-dashed border-slate-300 rounded-xl space-y-2.5">
                <div class="flex items-center justify-between">
                    <label class="font-bold text-slate-700 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        <span>Pilih dari Data Master Guru</span>
                    </label>
                    <span id="guruMatchCount" class="text-[11px] font-bold text-blue-600"></span>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </span>
                    <input type="text" id="searchGuruPicker" placeholder="Cari NIP / Nama Guru..." oninput="filterGuruPicker(this.value)" class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>

                <select id="selectGuruPicker" onchange="autoFillGuruData(this)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                    <option value="">-- Ketik NIP Manual atau Pilih dari Master Guru --</option>
                    @foreach($guruList as $g)
                        @php
                            $hasUser = !empty($g->user);
                            $isWali = $g->kelasWali->isNotEmpty();
                            $waliKelasName = $isWali ? $g->kelasWali->first()->nama_kelas : '';
                        @endphp
                        <option value="{{ $g->nip }}"
                                data-id-guru="{{ $g->id_guru }}"
                                data-nip="{{ $g->nip }}"
                                data-nama="{{ $g->nama_guru }}"
                                data-jk="{{ $g->jenis_kelamin }}"
                                data-hp="{{ $g->no_hp }}"
                                data-is-wali="{{ $isWali ? '1' : '0' }}"
                                data-kelas-wali="{{ $waliKelasName }}"
                                data-has-account="{{ $hasUser ? '1' : '0' }}">
                            {{ $g->nama_guru }} (NIP: {{ $g->nip }}) {{ $isWali ? '[Wali Kelas ' . $waliKelasName . ']' : '' }} {{ $hasUser ? '[Sudah Ada Akun]' : '[Belum Ada Akun]' }}
                        </option>
                    @endforeach
                </select>
                <small class="text-[10px] text-slate-500 block">Pilih guru di atas untuk pengisian otomatis NIP, Nama, Jenis Kelamin, Nomor HP, dan Role.</small>
            </div>

            <!-- Master Data Siswa Quick Picker (Khusus Role Orang Tua) -->
            <div id="siswaPickerContainer" style="display:none;" class="p-3.5 bg-blue-50/60 border border-dashed border-blue-300 rounded-xl space-y-2.5">
                <div class="flex items-center justify-between">
                    <label class="font-bold text-blue-900 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        <span>Pilih NISN dari Data Master Siswa</span>
                    </label>
                    <span id="siswaMatchCount" class="text-[11px] font-bold text-blue-600"></span>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </span>
                    <input type="text" id="searchSiswaPicker" placeholder="Cari NISN / Nama Siswa..." oninput="filterSiswaPicker(this.value)" class="w-full pl-8 pr-3 py-1.5 bg-white border border-blue-200 rounded-lg text-xs placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>

                <select id="selectSiswaPicker" onchange="autoFillSiswaData(this)" class="w-full px-3 py-2 bg-white border border-blue-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                    <option value="">-- Pilih NISN Siswa dari Master Data Siswa --</option>
                    @foreach($siswaList as $s)
                        <option value="{{ $s->nisn }}"
                                data-id-siswa="{{ $s->id_siswa }}"
                                data-nisn="{{ $s->nisn }}"
                                data-nama="{{ $s->nama_siswa }}"
                                data-jk="{{ $s->jenis_kelamin }}"
                                data-kelas="{{ $s->kelas ? $s->kelas->nama_kelas : '-' }}">
                            {{ $s->nama_siswa }} (NISN: {{ $s->nisn }}) - Kelas {{ $s->kelas ? $s->kelas->nama_kelas : '-' }}
                        </option>
                    @endforeach
                </select>
                <small class="text-[10px] text-blue-700 block">Pilih siswa di atas untuk otomatis mengisi NISN, Nama Pengguna, dan Password akun Orang Tua.</small>
            </div>

            <!-- Auto-Fill Lock Banners -->
            <div id="siswaLockBanner" style="display:none;" class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-900 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2" stroke-width="2"/><path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2"/></svg>
                <span><strong>Data Terisi Otomatis &amp; Terkunci:</strong> NISN, Nama, dan Jenis Kelamin dikunci dari Master Siswa.</span>
            </div>

            <div id="guruLockBanner" style="display:none;" class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-900 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2" stroke-width="2"/><path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2"/></svg>
                <span><strong>Data Terisi Otomatis &amp; Terkunci:</strong> NIP, Nama, Jenis Kelamin, Nomor HP, dan Role dikunci dari Master Guru.</span>
            </div>

            <!-- Input Fields Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label id="nipLabel" class="block font-bold text-slate-700 mb-1">NIP * (18 Digit)</label>
                    <input type="text" name="nip" id="add_nip" placeholder="198001012005011000" maxlength="18" minlength="5" inputmode="numeric" oninput="handleNipInput(this);" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Username (Opsional)</label>
                    <input type="text" name="username" id="add_username" placeholder="username.guru" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" id="add_name" placeholder="Contoh: Budi Santoso, S.Pd" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" id="add_jenis_kelamin" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor HP / WA</label>
                    <input type="text" name="no_hp" id="add_no_hp" placeholder="081234567890" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Email (Opsional)</label>
                <input type="email" name="email" id="add_email" placeholder="user@sekolah.sch.id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
            </div>

<<<<<<< HEAD
                    <div style="position:relative; margin-bottom:8px;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="text" id="searchSiswaPicker" class="form-control" 
                               placeholder="Cari NISN / Nama Siswa..." 
                               oninput="filterSiswaPicker(this.value)"
                               style="padding-left:36px; font-size:13px; background:#ffffff; border-color:#93c5fd;">
                    </div>

                    <select id="selectSiswaPicker" class="form-control" onchange="autoFillSiswaData(this)">
                        <option value="">-- Pilih NISN Siswa dari Master Data Siswa --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->nisn }}"
                                    data-id-siswa="{{ $s->id_siswa }}"
                                    data-nisn="{{ $s->nisn }}"
                                    data-nama="{{ $s->nama_siswa }}"
                                    data-jk="{{ $s->jenis_kelamin }}"
                                    data-tanggal-lahir="{{ (!empty($s->tanggal_lahir) && $s->tanggal_lahir !== '0000-00-00') ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('Y-m-d') : '' }}"
                                    data-kelas="{{ $s->kelas ? $s->kelas->nama_kelas : '-' }}">
                                {{ $s->nama_siswa }} (NISN: {{ $s->nisn }}) - Kelas {{ $s->kelas ? $s->kelas->nama_kelas : '-' }}
                            </option>
                        @endforeach
=======
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Role Hak Akses *</label>
                    <select name="role" id="add_role" required onchange="handleRoleChange(this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <option value="guru">Guru Mapel</option>
                        <option value="piket">Guru Piket</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="waka">Waka Kurikulum</option>
                        <option value="waka_sdm">Waka SDM (Kepegawaian)</option>
                        <option value="kepala_sekolah">Kepala Sekolah</option>
                        <option value="satpam">Satpam Gerbang</option>
                        <option value="orang_tua">Orang Tua / Wali Murid</option>
                        <option value="tu">Admin / TU (Tata Usaha)</option>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                    </select>
                </div>
<<<<<<< HEAD

                {{-- Fitur Tombol Abu-abu: Tambah Akun Ortu Dari Semua Siswa (Khusus Role Orang Tua) --}}
                <div id="batchOrtuContainer" style="display:none; background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:12px; padding:14px 16px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div style="flex:1; min-width:220px;">
                            <div style="font-size:13px; font-weight:800; color:#334155;">
                                <i class="fa-solid fa-users-gear" style="color:#64748b; margin-right:6px;"></i> Pembuatan Akun Ortu Sekaligus Banyak
                            </div>
                            <div style="font-size:11.5px; color:#64748b; margin-top:3px; line-height:1.4;">
                                Buat akun Orang Tua otomatis untuk semua siswa di Daftar Data Siswa. Password menggunakan <strong>tanggal lahir siswa</strong> (default: <code>ortu123</code> jika belum ada tanggal lahir). Siswa yang sudah berakun akan otomatis dilewati.
                            </div>
                        </div>
                        <div>
                            <button type="button" id="btnBatchOrtu" onclick="confirmGenerateAllOrangTua()" class="btn-grey-batch" title="Klik untuk membuat akun Orang Tua dari seluruh siswa di Daftar Data Siswa">
                                <i class="fa-solid fa-user-group"></i> Tambah Akun Ortu Dari Semua Siswa
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Banner Informasi Data Terkunci dari Master Siswa --}}
                <div id="siswaLockBanner" style="display:none; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:10px 14px; border-radius:10px; font-size:12px; margin-bottom:16px;">
                    <i class="fa-solid fa-lock" style="color:#2563eb; margin-right:4px;"></i> 
                    <strong>Data Terisi Otomatis &amp; Terkunci:</strong> Data NISN, Nama Lengkap, dan Jenis Kelamin dikunci karena dipilih dari Data Master Siswa. Untuk mengedit manual, pilih <em>'-- Pilih NISN Siswa dari Master Data Siswa --'</em> pada pilihan di atas.
                </div>

                {{-- Banner Informasi Data Terkunci dari Master Guru --}}
                <div id="guruLockBanner" style="display:none; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:10px 14px; border-radius:10px; font-size:12px; margin-bottom:16px;">
                    <i class="fa-solid fa-lock" style="color:#2563eb; margin-right:4px;"></i> 
                    <strong>Data Terisi Otomatis &amp; Terkunci:</strong> Data NIP, Nama, Jenis Kelamin, HP, dan Role dikunci karena dipilih dari Data Master Guru. Untuk mengedit manual, pilih <em>'-- Ketik NIP Manual atau Pilih dari Master Guru --'</em> pada pilihan di atas.
                </div>

                <div style="display:flex; gap:12px;" id="nipUsernameRow">
                    <div class="form-group" style="flex:1;" id="nipGroup">
                        <label id="nipLabel">NIP * (18 Digit)</label>
                        <input type="text" name="nip" id="add_nip" class="form-control" placeholder="198001012005011000"
                               maxlength="30" minlength="5" inputmode="numeric"
                               oninput="handleNipInput(this);" required>
                    </div>
                    <div class="form-group" style="flex:1;" id="usernameGroup">
                        <label id="usernameLabel">Username (Opsional)</label>
                        <input type="text" name="username" id="add_username" class="form-control" placeholder="username.guru">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" id="add_name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd" required>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="add_jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Nomor HP / WA</label>
                        <input type="text" name="no_hp" id="add_no_hp" class="form-control" placeholder="081234567890"
                               maxlength="15" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email (Opsional)</label>
                    <input type="email" name="email" id="add_email" class="form-control" placeholder="user@sekolah.sch.id">
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Role Hak Akses *</label>
                        <select name="role" id="add_role" class="form-control" required onchange="handleRoleChange(this.value)">
                            <option value="guru">Guru Mapel</option>
                            <option value="piket">Guru Piket</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="waka">Waka Kurikulum</option>
                            <option value="waka_kesiswaan">Waka Kesiswaan</option>
                            <option value="waka_sdm">Waka SDM (Kepegawaian)</option>
                            <option value="kepala_sekolah">Kepala Sekolah</option>
                            <option value="satpam">Satpam Gerbang</option>
                            <option value="orang_tua">Orang Tua / Wali Murid</option>
                            <option value="tu">Admin / TU (Tata Usaha)</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Status Verifikasi *</label>
                        <select name="status_verifikasi" class="form-control" required>
                            <option value="verified">Verified (Disetujui)</option>
                            <option value="pending">Pending (Menunggu)</option>
                        </select>
                    </div>
                </div>

                {{-- Password & Konfirmasi Password --}}
                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Password Akun *</label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password" id="add_password" class="form-control" 
                                   placeholder="Minimal 6 karakter" minlength="6" required oninput="validatePasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('add_password', this)" title="Tampilkan/Sembunyikan Password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Konfirmasi Password *</label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password_confirmation" id="add_password_confirmation" class="form-control" 
                                   placeholder="Ulangi password" minlength="6" required oninput="validatePasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('add_password_confirmation', this)" title="Tampilkan/Sembunyikan Password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <small id="passwordMatchMsg" style="display:none; font-size:12px; font-weight:600; margin-top:-6px; margin-bottom:12px;"></small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="resetTambahUserForm()" style="background:#fbbf24; color:#78350f;"><i class="fa-solid fa-rotate-left"></i> Reset Form</button>
                <button type="button" class="btn-secondary" onclick="closeModal('modalTambahUser')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Simpan & Buat Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Form Submit Hidden untuk Pembuatan Massal Akun Orang Tua --}}
<form id="formGenerateAllOrangTua" action="{{ route('admin.users.generate-all-orang-tua') }}" method="POST" style="display:none;">
    @csrf
</form>


<!-- Modal 2: Edit Hak Akses & Role -->
<div class="modal-backdrop" id="modalEditUser">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-pen" style="margin-right:8px;"></i> Ubah Hak Akses & Profile</h3>
            <button class="modal-close" onclick="closeModal('modalEditUser')">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;" id="editNipGroup">
                        <label id="edit_nip_label">NIP * (18 Digit)</label>
                        <input type="text" name="nip" id="edit_nip" class="form-control"
                               maxlength="30" inputmode="numeric"
                               oninput="handleEditNipInput(this);" required>
                    </div>
                    <div class="form-group" style="flex:1;" id="editUsernameGroup">
                        <label id="edit_username_label">Username (Opsional)</label>
                        <input type="text" name="username" id="edit_username" class="form-control" placeholder="username.akun">
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="edit_jk" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Nomor HP / WA</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="form-control" placeholder="081234567890"
                               maxlength="15" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Role Hak Akses *</label>
                        <select name="role" id="edit_role" class="form-control" required onchange="handleEditRoleChange(this.value)">
                            <option value="tu">Admin / TU (Tata Usaha)</option>
                            <option value="admin">Administrator (Super)</option>
                            <option value="guru">Guru Mapel</option>
                            <option value="piket">Guru Piket</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="waka">Waka Kurikulum</option>
                            <option value="waka_kesiswaan">Waka Kesiswaan</option>
                            <option value="waka_sdm">Waka SDM (Kepegawaian)</option>
                            <option value="kepala_sekolah">Kepala Sekolah</option>
                            <option value="satpam">Satpam Gerbang</option>
                            <option value="orang_tua">Orang Tua / Wali Murid</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Status Verifikasi *</label>
                        <select name="status_verifikasi" id="edit_status" class="form-control" required>
                            <option value="verified">Verified (Disetujui)</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected (Ditolak)</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Status Akun (ON/OFF) *</label>
                        <select name="is_active" id="edit_is_active" class="form-control" required>
                            <option value="1">Aktif (ON)</option>
                            <option value="0">Nonaktif (OFF)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:12px; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;">
                    <div style="font-size:12px; font-weight:700; color:#475569; margin-bottom:8px;">
                        <i class="fa-solid fa-key" style="color:#6366f1;"></i> Ganti Password (Opsional — Kosongkan jika tidak ingin diubah)
                    </div>
                    <div style="display:flex; gap:12px;">
                        <div class="form-group" style="flex:1; margin-bottom:0;">
                            <label style="font-size:12px;">Password Baru</label>
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="form-group" style="flex:1; margin-bottom:0;">
                            <label style="font-size:12px;">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>
=======
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Verifikasi *</label>
                    <select name="status_verifikasi" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs" required>
                        <option value="verified">Verified (Disetujui)</option>
                        <option value="pending">Pending (Menunggu)</option>
                    </select>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                </div>
            </div>

            <!-- Password & Konfirmasi Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Password Akun *</label>
                    <div class="relative">
                        <input type="password" name="password" id="add_password" placeholder="Minimal 6 karakter" minlength="6" required oninput="validatePasswordMatch()" class="w-full pl-3 pr-9 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <button type="button" onclick="togglePasswordVisibility('add_password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Konfirmasi Password *</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="add_password_confirmation" placeholder="Ulangi password" minlength="6" required oninput="validatePasswordMatch()" class="w-full pl-3 pr-9 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <button type="button" onclick="togglePasswordVisibility('add_password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <small id="passwordMatchMsg" style="display:none;" class="text-xs font-semibold block mt-1"></small>

            <!-- Modal Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2.5">
                <button type="button" onclick="resetTambahUserForm()" class="px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-semibold transition-colors cursor-pointer flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <span>Reset Form</span>
                </button>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeModal('modalTambahUser')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-sm transition-colors cursor-pointer flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        <span>Simpan &amp; Buat Akun</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Edit Hak Akses & Profile -->
<div class="modal-backdrop-custom" id="modalEditUser">
    <div class="modal-box-custom max-w-xl flex flex-col">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Ubah Hak Akses &amp; Profil</h3>
                    <p class="text-[11px] text-slate-500">Sesuaikan role, NIP/NISN, nomor HP, atau status verifikasi pengguna.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEditUser')" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <form id="formEditUser" method="POST" class="p-5 space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label id="edit_nip_label" class="block font-bold text-slate-700 mb-1">NIP * (18 Digit)</label>
                    <input type="text" name="nip" id="edit_nip" maxlength="18" minlength="5" inputmode="numeric" oninput="handleEditNipInput(this);" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="edit_jk" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor HP / WA</label>
                    <input type="text" name="no_hp" id="edit_no_hp" placeholder="081234567890" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Role Hak Akses *</label>
                    <select name="role" id="edit_role" required onchange="handleEditRoleChange(this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <option value="tu">Admin / TU (Tata Usaha)</option>
                        <option value="admin">Administrator (Super)</option>
                        <option value="guru">Guru Mapel</option>
                        <option value="piket">Guru Piket</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="waka">Waka Kurikulum</option>
                        <option value="waka_sdm">Waka SDM (Kepegawaian)</option>
                        <option value="kepala_sekolah">Kepala Sekolah</option>
                        <option value="satpam">Satpam Gerbang</option>
                        <option value="orang_tua">Orang Tua / Wali Murid</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Verifikasi *</label>
                    <select name="status_verifikasi" id="edit_status" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-2xs">
                        <option value="verified">Verified (Aktif)</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected (Ditolak)</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalEditUser')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-sm transition-colors cursor-pointer">Update Data Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Ubah Password (Indigo Palette) -->
<div class="modal-backdrop-custom" id="modalResetPassword">
    <div class="modal-box-custom max-w-md flex flex-col">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-indigo-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Ubah Sandi Pengguna</h3>
                    <p class="text-[11px] text-slate-500">Tetapkan password baru untuk akun yang dipilih.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalResetPassword')" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <form id="formResetPassword" method="POST" onsubmit="return validateResetPasswordSubmit(event)" class="p-5 space-y-4 text-xs">
            @csrf
            <p class="text-xs text-slate-600">
                Anda akan memperbarui password untuk akun: <strong id="reset_user_name" class="text-slate-900 font-bold"></strong>
            </p>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Password Baru *</label>
                <div class="relative">
                    <input type="password" id="reset_password" name="password" placeholder="Minimal 6 karakter" minlength="6" required oninput="validateResetPasswordMatch()" class="w-full pl-3 pr-9 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-2xs">
                    <button type="button" onclick="togglePasswordVisibility('reset_password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Konfirmasi Password Baru *</label>
                <div class="relative">
                    <input type="password" id="reset_password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" minlength="6" required oninput="validateResetPasswordMatch()" class="w-full pl-3 pr-9 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-2xs">
                    <button type="button" onclick="togglePasswordVisibility('reset_password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>
            <small id="resetPasswordMatchMsg" style="display:none;" class="text-xs font-semibold block mt-1"></small>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeModal('modalResetPassword')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-sm transition-colors cursor-pointer flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <span>Simpan Password Baru</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 4: View Detail -->
<div class="modal-backdrop-custom" id="modalDetailUser">
    <div class="modal-box-custom max-w-lg flex flex-col">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-sky-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Detail Akun Pengguna</h3>
                    <p class="text-[11px] text-slate-500">Informasi profil lengkap dan hak akses akun.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalDetailUser')" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
<<<<<<< HEAD
        <div class="modal-body">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nama Lengkap:</td><td id="detail_name" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr id="detail_nip_row"><td style="padding:8px 0; color:#64748b; font-weight:600;" id="detail_nip_label">NIP:</td><td id="detail_nip" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Jenis Kelamin:</td><td id="detail_jk" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nomor HP / WA:</td><td id="detail_no_hp" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Username:</td><td id="detail_username"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Email:</td><td id="detail_email"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Role:</td><td id="detail_role"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Status Verifikasi:</td><td id="detail_status"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Status Akun (ON/OFF):</td><td id="detail_is_active"></td></tr>
                <tr id="detail_siswa_row" style="display:none;"><td style="padding:8px 0; color:#1e40af; font-weight:700;"><i class="fa-solid fa-graduation-cap"></i> Data Siswa Anak:</td><td id="detail_siswa_text" style="font-weight:700; color:#1e40af;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Dibuat Pada:</td><td id="detail_created_at"></td></tr>
            </table>
=======

        <div class="p-5 space-y-3 text-xs">
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Nama Lengkap:</span>
                <span id="detail_name" class="col-span-2 font-bold text-slate-900"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span id="detail_nip_label" class="text-slate-500 font-medium">NIP:</span>
                <span id="detail_nip" class="col-span-2 font-mono font-bold text-blue-600"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Jenis Kelamin:</span>
                <span id="detail_jk" class="col-span-2 font-semibold text-slate-800"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Nomor HP / WA:</span>
                <span id="detail_no_hp" class="col-span-2 font-medium text-slate-800"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Username:</span>
                <span id="detail_username" class="col-span-2 font-medium text-slate-800"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Email:</span>
                <span id="detail_email" class="col-span-2 font-medium text-slate-800"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Role Hak Akses:</span>
                <span id="detail_role" class="col-span-2 font-bold text-slate-900"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5 border-b border-slate-100">
                <span class="text-slate-500 font-medium">Status Verifikasi:</span>
                <span id="detail_status" class="col-span-2"></span>
            </div>
            <div class="grid grid-cols-3 gap-2 py-1.5">
                <span class="text-slate-500 font-medium">Dibuat Pada:</span>
                <span id="detail_created_at" class="col-span-2 text-slate-600"></span>
            </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>

        <div class="p-4 border-t border-slate-100 flex justify-end bg-slate-50/50">
            <button type="button" onclick="closeModal('modalDetailUser')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs transition-colors cursor-pointer">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal 5: Konfirmasi Bulk Delete (Hapus Terpilih) -->
<div class="modal-backdrop-custom" id="modalConfirmBulkDelete">
    <div class="modal-box-custom max-w-md flex flex-col p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </div>

        <h3 class="text-base font-bold text-slate-900 mb-1.5">Konfirmasi Hapus Terpilih</h3>
        <p class="text-xs text-slate-500 mb-4 leading-relaxed">
            Apakah Anda yakin ingin memindahkan <strong id="bulkModalCount" class="text-rose-600 font-bold">0</strong> akun pengguna terpilih ke Tempat Sampah?
        </p>

        <!-- Preview names list -->
        <div id="bulkSelectedNamesList" class="max-h-36 overflow-y-auto p-3 bg-slate-50 border border-slate-200/80 rounded-xl text-left text-[11px] space-y-1 text-slate-700 mb-5">
        </div>

        <div class="flex items-center justify-center gap-2.5">
            <button type="button" onclick="closeModal('modalConfirmBulkDelete')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors cursor-pointer">
                Batal
            </button>
            <button type="button" id="btnSubmitBulkDelete" onclick="executeBulkDelete()" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs shadow-sm transition-colors cursor-pointer flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                <span>Hapus Sekarang</span>
            </button>
        </div>
    </div>
</div>

<!-- Floating Real-time Toast Component -->
<div id="realtimeToast" class="realtime-toast">
    <i id="realtimeToastIcon" class="fa-solid fa-circle-check" style="font-size:18px; color:#22c55e;"></i>
    <span id="realtimeToastMsg">Status akun berhasil diperbarui.</span>
</div>

@endsection

@section('scripts')
<script>
    // 0. ROLE METRIC CARDS HORIZONTAL SCROLL NAVIGATION
    (function initRoleCardsScroll() {
        const container = document.getElementById('roleMetricsScroll');
        const leftBtn = document.getElementById('roleScrollLeftBtn');
        const rightBtn = document.getElementById('roleScrollRightBtn');
        if (!container || !leftBtn || !rightBtn) return;

        function updateArrowVisibility() {
            const scrollLeft = Math.round(container.scrollLeft);
            const maxScroll = Math.round(container.scrollWidth - container.clientWidth);
            const tolerance = 4;

            if (maxScroll <= tolerance) {
                leftBtn.classList.remove('can-scroll');
                rightBtn.classList.remove('can-scroll');
                leftBtn.setAttribute('disabled', 'true');
                rightBtn.setAttribute('disabled', 'true');
                return;
            }

            if (scrollLeft > tolerance) {
                leftBtn.classList.add('can-scroll');
                leftBtn.removeAttribute('disabled');
            } else {
                leftBtn.classList.remove('can-scroll');
                leftBtn.setAttribute('disabled', 'true');
            }

            if (scrollLeft < (maxScroll - tolerance)) {
                rightBtn.classList.add('can-scroll');
                rightBtn.removeAttribute('disabled');
            } else {
                rightBtn.classList.remove('can-scroll');
                rightBtn.setAttribute('disabled', 'true');
            }
        }

        function getScrollAmount() {
            return Math.max(240, Math.floor(container.clientWidth * 0.75));
        }

        leftBtn.addEventListener('click', function(e) {
            e.preventDefault();
            container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        rightBtn.addEventListener('click', function(e) {
            e.preventDefault();
            container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        container.addEventListener('scroll', updateArrowVisibility, { passive: true });
        window.addEventListener('resize', updateArrowVisibility);

        @if(request('role'))
            setTimeout(function() {
                const cards = container.querySelectorAll('a[title*="Filter:"]');
                cards.forEach(function(card) {
                    if (card.classList.contains('border-2')) {
                        card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    }
                });
            }, 100);
        @endif

        updateArrowVisibility();
        setTimeout(updateArrowVisibility, 150);
        setTimeout(updateArrowVisibility, 400);
        window.addEventListener('load', updateArrowVisibility);
    })();

    // 1. MODAL HELPERS
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
            if (id === 'modalTambahUser') {
                const roleSelect = document.getElementById('add_role');
                const roleVal = roleSelect ? roleSelect.value : 'guru';
                handleRoleChange(roleVal);

                const pass = document.getElementById('add_password');
                const confirmPass = document.getElementById('add_password_confirmation');
                const msg = document.getElementById('passwordMatchMsg');
                if (pass) pass.value = '';
                if (confirmPass) confirmPass.value = '';
                if (msg) msg.style.display = 'none';
            }
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('active');
    }

    // Close modal on click backdrop
    document.addEventListener('click', function(e) {
        ['modalTambahUser', 'modalEditUser', 'modalResetPassword', 'modalDetailUser', 'modalConfirmBulkDelete'].forEach(id => {
            const el = document.getElementById(id);
            if (el && e.target === el) {
                el.classList.remove('active');
            }
        });
    });

    // 2. CHECKBOXES & CONTEXTUAL BULK ACTION TOOLBAR
    function toggleSelectAllUsers(masterCheckbox) {
        const rowCheckboxes = document.querySelectorAll('.user-row-checkbox:not(:disabled)');
        rowCheckboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateBulkToolbar();
    }

    function handleUserCheckboxChange() {
        const activeCheckboxes = document.querySelectorAll('.user-row-checkbox:not(:disabled)');
        const checkedBoxes = document.querySelectorAll('.user-row-checkbox:checked');
        const masterCheckbox = document.getElementById('selectAllUsers');
        
        if (masterCheckbox) {
            masterCheckbox.checked = (activeCheckboxes.length > 0 && checkedBoxes.length === activeCheckboxes.length);
        }
        updateBulkToolbar();
    }

    function deselectAllUsers() {
        const masterCheckbox = document.getElementById('selectAllUsers');
        if (masterCheckbox) masterCheckbox.checked = false;
        
        const rowCheckboxes = document.querySelectorAll('.user-row-checkbox');
        rowCheckboxes.forEach(cb => cb.checked = false);
        
        updateBulkToolbar();
    }

    function updateBulkToolbar() {
        const checkedBoxes = document.querySelectorAll('.user-row-checkbox:checked');
        const toolbar = document.getElementById('bulkActionsToolbar');
        const countSpan = document.getElementById('bulkDeleteCount');
        
        if (toolbar && countSpan) {
            const count = checkedBoxes.length;
            countSpan.textContent = count;
            if (count > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
            } else {
                toolbar.classList.add('hidden');
                toolbar.classList.remove('flex');
            }
        }
    }

    function openBulkDeleteModal() {
        const checkedBoxes = document.querySelectorAll('.user-row-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        const countSpan = document.getElementById('bulkModalCount');
        if (countSpan) countSpan.textContent = checkedBoxes.length;

        const listContainer = document.getElementById('bulkSelectedNamesList');
        if (listContainer) {
            let html = '';
            checkedBoxes.forEach((cb, idx) => {
                const userName = cb.getAttribute('data-name') || ('User ID #' + cb.value);
                html += `<div class="flex items-center gap-2 truncate"><span class="w-4 text-slate-400 font-mono">${idx+1}.</span><strong class="text-slate-800">${userName}</strong></div>`;
            });
            listContainer.innerHTML = html;
        }

        openModal('modalConfirmBulkDelete');
    }

    async function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.user-row-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        const submitBtn = document.getElementById('btnSubmitBulkDelete');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menghapus...</span>
            `;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        try {
            const promises = Array.from(checkedBoxes).map(cb => {
                return fetch(`/admin/users/${cb.value}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'DELETE',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ _method: 'DELETE' })
                });
            });

            await Promise.all(promises);
            window.location.reload();
        } catch (err) {
            alert('Terjadi kendala saat memproses penghapusan massal. Halaman akan dimuat ulang.');
            window.location.reload();
        }
    }

    // 3. EDIT & DETAIL MODAL LOGIC
    function openEditModalFromEl(button) {
        try {
            const user = JSON.parse(button.getAttribute('data-user'));
            document.getElementById('formEditUser').action = '/admin/verifikasi-guru/' + user.id + '/update-role';
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_nip').value = user.nip || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_jk').value = user.jenis_kelamin || '';
            document.getElementById('edit_no_hp').value = user.no_hp || '';
            document.getElementById('edit_role').value = user.role || 'guru';
            document.getElementById('edit_status').value = user.status_verifikasi || 'verified';
            
            handleEditRoleChange(user.role || 'guru');
            openModal('modalEditUser');
        } catch (e) {
            console.error('Failed to parse user data for edit', e);
        }
    }

    function openDetailModalFromEl(el) {
        try {
            let dataAttr = el.getAttribute('data-user');
            if (!dataAttr && el.closest('tr')) {
                dataAttr = el.closest('tr').getAttribute('data-user');
            }
            if (!dataAttr) return;

            const u = JSON.parse(dataAttr);
            document.getElementById('detail_name').textContent = u.name || '-';
            
            const isOrtu = (u.role === 'orang_tua');
            document.getElementById('detail_nip_label').textContent = isOrtu ? 'NISN:' : 'NIP:';
            document.getElementById('detail_nip').textContent = u.nip || '-';
            
            document.getElementById('detail_jk').textContent = (u.jenis_kelamin === 'L') ? 'Laki-laki' : ((u.jenis_kelamin === 'P') ? 'Perempuan' : '-');
            document.getElementById('detail_no_hp').textContent = u.no_hp || '-';
            document.getElementById('detail_username').textContent = u.username || '-';
            document.getElementById('detail_email').textContent = u.email || '-';
            document.getElementById('detail_role').textContent = u.role_label || u.role || '-';
            
            const statusContainer = document.getElementById('detail_status');
            if (u.status_verifikasi === 'verified') {
                statusContainer.innerHTML = '<span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">Verified (Aktif)</span>';
            } else if (u.status_verifikasi === 'pending') {
                statusContainer.innerHTML = '<span class="px-2 py-0.5 bg-amber-50 text-amber-800 border border-amber-300 rounded-full text-xs font-semibold">Pending (Menunggu)</span>';
            } else {
                statusContainer.innerHTML = '<span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-semibold">Rejected (Ditolak)</span>';
            }

            document.getElementById('detail_created_at').textContent = u.created_at_formatted || '-';
            openModal('modalDetailUser');
        } catch (e) {
            console.error('Failed to parse user data for detail', e);
        }
    }

    function openResetPasswordModal(id, name) {
        document.getElementById('formResetPassword').action = '/admin/users/' + id + '/reset-password';
        document.getElementById('reset_user_name').textContent = name;
        document.getElementById('reset_password').value = '';
        document.getElementById('reset_password_confirmation').value = '';
        const msg = document.getElementById('resetPasswordMatchMsg');
        if (msg) msg.style.display = 'none';
        openModal('modalResetPassword');
    }

    // 4. PASSWORD VISIBILITY & VALIDATION
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" stroke-width="2"/></svg>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>`;
        }
    }

    function validatePasswordMatch() {
        const pass = document.getElementById('add_password');
        const confirmPass = document.getElementById('add_password_confirmation');
        const msg = document.getElementById('passwordMatchMsg');
        if (!pass || !confirmPass || !msg) return true;

        const p1 = pass.value;
        const p2 = confirmPass.value;

        if (!p1 && !p2) {
            msg.style.display = 'none';
            return true;
        }

        if (p1.length > 0 && p1.length < 6) {
            msg.style.display = 'block';
            msg.className = 'text-xs font-semibold block text-rose-600';
            msg.textContent = 'Password minimal 6 karakter.';
            return false;
        }

        if (p2.length > 0) {
            if (p1 === p2) {
                msg.style.display = 'block';
                msg.className = 'text-xs font-semibold block text-emerald-600';
                msg.textContent = 'Konfirmasi password cocok.';
                return true;
            } else {
                msg.style.display = 'block';
                msg.className = 'text-xs font-semibold block text-rose-600';
                msg.textContent = 'Konfirmasi password tidak cocok.';
                return false;
            }
        }
        msg.style.display = 'none';
        return false;
    }

    function validatePasswordSubmit(e) {
        const pass = document.getElementById('add_password');
        const confirmPass = document.getElementById('add_password_confirmation');
        if (pass && confirmPass) {
            if (pass.value.length < 6) {
                alert('Password minimal 6 karakter.');
                pass.focus();
                e.preventDefault();
                return false;
            }
            if (pass.value !== confirmPass.value) {
                alert('Konfirmasi password tidak cocok!');
                confirmPass.focus();
                e.preventDefault();
                return false;
            }
        }
        return true;
    }

<<<<<<< HEAD
    function resetTambahUserForm() {
        const searchGuru = document.getElementById('searchGuruPicker');
        if (searchGuru) searchGuru.value = '';
        const selectGuru = document.getElementById('selectGuruPicker');
        if (selectGuru) selectGuru.value = '';

        const searchSiswa = document.getElementById('searchSiswaPicker');
        if (searchSiswa) searchSiswa.value = '';
        const selectSiswa = document.getElementById('selectSiswaPicker');
        if (selectSiswa) selectSiswa.value = '';

        filterGuruPicker('');
        filterSiswaPicker('');

        const idSiswaInput = document.getElementById('add_id_siswa');
        if (idSiswaInput) idSiswaInput.value = '';

        const nipInput = document.getElementById('add_nip');
        if (nipInput) {
            nipInput.value = '';
            nipInput.readOnly = false;
            nipInput.style.backgroundColor = '#ffffff';
        }
        const usernameInput = document.getElementById('add_username');
        if (usernameInput) usernameInput.value = '';
        
        const nameInput = document.getElementById('add_name');
        if (nameInput) {
            nameInput.value = '';
            nameInput.readOnly = false;
            nameInput.style.backgroundColor = '#ffffff';
        }
        
        const emailInput = document.getElementById('add_email');
        if (emailInput) emailInput.value = '';
        
        const hpInput = document.getElementById('add_no_hp');
        if (hpInput) hpInput.value = '';
        
        const jkSelect = document.getElementById('add_jenis_kelamin');
        if (jkSelect) {
            jkSelect.value = '';
            jkSelect.style.pointerEvents = 'auto';
            jkSelect.style.backgroundColor = '#ffffff';
        }
        
        const roleSelect = document.getElementById('add_role');
        if (roleSelect) {
            roleSelect.value = 'guru';
            roleSelect.style.pointerEvents = 'auto';
            roleSelect.style.backgroundColor = '#ffffff';
        }

        handleRoleChange('guru');

        const guruLockBanner = document.getElementById('guruLockBanner');
        if (guruLockBanner) guruLockBanner.style.display = 'none';
        const siswaLockBanner = document.getElementById('siswaLockBanner');
        if (siswaLockBanner) siswaLockBanner.style.display = 'none';

        const passInput = document.getElementById('add_password');
        if (passInput) {
            passInput.value = '';
            passInput.type = 'password';
        }
        const confirmPassInput = document.getElementById('add_password_confirmation');
        if (confirmPassInput) {
            confirmPassInput.value = '';
            confirmPassInput.type = 'password';
        }

        const toggleBtns = document.querySelectorAll('#modalTambahUser .password-toggle-btn i');
        toggleBtns.forEach(icon => {
            icon.className = 'fa-solid fa-eye';
        });

        const msg = document.getElementById('passwordMatchMsg');
        if (msg) msg.style.display = 'none';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function toggleFilterPanel() {
        document.getElementById('filterPanel').classList.toggle('show');
    }

    function openDetailModalFromEl(el) {
        const raw = el.getAttribute('data-user');
        if (!raw) return;
        try {
            const user = typeof raw === 'string' ? JSON.parse(raw) : raw;
            openDetailModal(user);
        } catch(e) {
            console.error('Error parsing user data:', e);
        }
    }

    function openEditModalFromEl(el) {
        const raw = el.getAttribute('data-user');
        if (!raw) return;
        try {
            const user = typeof raw === 'string' ? JSON.parse(raw) : raw;
            openEditModal(user);
        } catch(e) {
            console.error('Error parsing user data:', e);
        }
    }

    function handleEditRoleChange(role) {
        const editNipGroup = document.getElementById('editNipGroup');
        const editNipLabel = document.getElementById('edit_nip_label');
        const editNipInput = document.getElementById('edit_nip');
        const editUsernameLabel = document.getElementById('edit_username_label');
        const editUsernameInput = document.getElementById('edit_username');

        if (role === 'piket' || role === 'satpam') {
            if (editNipGroup) editNipGroup.style.display = 'none';
            if (editNipInput) {
                editNipInput.required = false;
                editNipInput.value = '';
            }
            if (editUsernameLabel) {
                editUsernameLabel.innerHTML = 'Username Petugas * <span style="color:#ef4444;">(Wajib)</span>';
            }
            if (editUsernameInput) {
                editUsernameInput.required = true;
                editUsernameInput.placeholder = role === 'piket' ? 'Contoh: piket' : 'Contoh: Satpam';
            }
        } else if (role === 'orang_tua') {
            if (editNipGroup) editNipGroup.style.display = 'block';
            if (editNipLabel) editNipLabel.innerText = 'NISN * (10 Digit)';
            if (editNipInput) {
                editNipInput.required = true;
                editNipInput.placeholder = 'Masukkan 10 digit NISN';
                editNipInput.setAttribute('maxlength', '10');
                editNipInput.setAttribute('minlength', '10');
                if (editNipInput.value) {
                    editNipInput.value = editNipInput.value.replace(/[^0-9]/g, '').slice(0, 10);
                }
            }
            if (editUsernameLabel) editUsernameLabel.innerText = 'Username (Opsional)';
            if (editUsernameInput) {
                editUsernameInput.required = false;
                editUsernameInput.placeholder = 'username.ortu';
            }
        } else {
            if (editNipGroup) editNipGroup.style.display = 'block';
            if (editNipLabel) editNipLabel.innerText = 'NIP * (18 Digit)';
            if (editNipInput) {
                editNipInput.required = true;
                editNipInput.placeholder = '198001012005011000';
                editNipInput.setAttribute('maxlength', '18');
                editNipInput.setAttribute('minlength', '18');
            }
            if (editUsernameLabel) editUsernameLabel.innerText = 'Username (Opsional)';
            if (editUsernameInput) {
                editUsernameInput.required = false;
                editUsernameInput.placeholder = 'username.guru';
            }
        }
    }

    function handleEditNipInput(input) {
        const roleSelect = document.getElementById('edit_role');
        const role = roleSelect ? roleSelect.value : '';
        if (role === 'orang_tua') {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
        } else {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 18);
        }
    }

    function openEditModal(user) {
        document.getElementById('formEditUser').action = '/admin/verifikasi-guru/' + user.id + '/update-role';
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_nip').value = user.nip || '';
        document.getElementById('edit_username').value = user.username || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role').value = user.role || 'guru';
        document.getElementById('edit_status').value = user.status_verifikasi || 'verified';
        document.getElementById('edit_is_active').value = (user.is_active !== false && user.is_active !== 0 && user.is_active !== '0') ? '1' : '0';
        
        let jkVal = (user.guru && user.guru.jenis_kelamin) ? user.guru.jenis_kelamin : (user.jenis_kelamin || '');
        let noHpVal = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '');
        
        if (document.getElementById('edit_jk')) document.getElementById('edit_jk').value = jkVal;
        if (document.getElementById('edit_no_hp')) document.getElementById('edit_no_hp').value = noHpVal;

        if (document.getElementById('edit_password')) document.getElementById('edit_password').value = '';
        if (document.getElementById('edit_password_confirmation')) document.getElementById('edit_password_confirmation').value = '';

        handleEditRoleChange(user.role || 'guru');
        openModal('modalEditUser');
    }

    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    function openResetPasswordModal(userId, userName) {
        document.getElementById('formResetPassword').action = '/admin/users/' + userId + '/reset-password';
        document.getElementById('reset_user_name').innerText = userName;

        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');

        if (pass) {
            pass.value = '';
            pass.type = 'password';
        }
        if (confirmPass) {
            confirmPass.value = '';
            confirmPass.type = 'password';
        }
        if (msg) {
            msg.style.display = 'none';
        }
        const toggleBtns = document.querySelectorAll('#modalResetPassword .password-toggle-btn i');
        toggleBtns.forEach(icon => {
            icon.className = 'fa-solid fa-eye';
        });

        openModal('modalResetPassword');
    }

=======
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    function validateResetPasswordMatch() {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');
        if (!pass || !confirmPass || !msg) return true;

        const p1 = pass.value;
        const p2 = confirmPass.value;

        if (!p1 && !p2) {
            msg.style.display = 'none';
            return true;
        }

        if (p1.length > 0 && p1.length < 6) {
            msg.style.display = 'block';
            msg.className = 'text-xs font-semibold block text-rose-600';
            msg.textContent = 'Password minimal 6 karakter.';
            return false;
        }

        if (p2.length > 0) {
            if (p1 === p2) {
                msg.style.display = 'block';
                msg.className = 'text-xs font-semibold block text-emerald-600';
                msg.textContent = 'Konfirmasi password cocok.';
                return true;
            } else {
                msg.style.display = 'block';
                msg.className = 'text-xs font-semibold block text-rose-600';
                msg.textContent = 'Konfirmasi password tidak cocok.';
                return false;
            }
        }
        msg.style.display = 'none';
        return false;
    }

    function validateResetPasswordSubmit(e) {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        if (pass && confirmPass) {
            if (pass.value.length < 6) {
                alert('Password minimal 6 karakter.');
                pass.focus();
                e.preventDefault();
                return false;
            }
            if (pass.value !== confirmPass.value) {
                alert('Konfirmasi password tidak cocok!');
                confirmPass.focus();
                e.preventDefault();
                return false;
            }
        }
        return true;
    }

<<<<<<< HEAD
    function openDetailModal(user) {
        document.getElementById('detail_name').innerText = user.name || '-';

        const isOrtu = user.role === 'orang_tua';
        const isPetugas = user.role === 'piket' || user.role === 'satpam';
        const nipLabel = document.getElementById('detail_nip_label');
        const nipRow = document.getElementById('detail_nip_row');
        if (nipLabel) {
            nipLabel.innerText = isOrtu ? 'NISN:' : 'NIP:';
        }
        if (nipRow) {
            nipRow.style.display = isPetugas ? 'none' : '';
        }

        document.getElementById('detail_nip').innerText = user.nip || '-';
        document.getElementById('detail_username').innerText = user.username || '-';
        document.getElementById('detail_email').innerText = user.email || '-';
        document.getElementById('detail_role').innerText = user.role ? user.role.toUpperCase() : '-';
        document.getElementById('detail_status').innerText = user.status_verifikasi ? user.status_verifikasi.toUpperCase() : '-';
        
        const isActive = (user.is_active !== false && user.is_active !== 0 && user.is_active !== '0');
        document.getElementById('detail_is_active').innerHTML = isActive
            ? '<span style="color:#16a34a; font-weight:700;"><i class="fa-solid fa-circle-check"></i> Aktif (ON)</span>'
            : '<span style="color:#ef4444; font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> Nonaktif (OFF)</span>';

        document.getElementById('detail_created_at').innerText = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : '-';

        let jkText = '-';
        if (user.guru && user.guru.jenis_kelamin) {
            jkText = user.guru.jenis_kelamin === 'L' ? 'Laki-laki' : (user.guru.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        } else if (user.jenis_kelamin) {
            jkText = user.jenis_kelamin === 'L' ? 'Laki-laki' : (user.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        }
        let noHpText = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '-');
        if (document.getElementById('detail_no_hp')) document.getElementById('detail_no_hp').innerText = noHpText;
        if (document.getElementById('detail_jk')) document.getElementById('detail_jk').innerText = jkText;

        const siswaRow = document.getElementById('detail_siswa_row');
        const siswaText = document.getElementById('detail_siswa_text');
        if (user.role === 'orang_tua' && user.siswa) {
            if (siswaRow) siswaRow.style.display = '';
            if (siswaText) {
                const kelasNama = (user.siswa.kelas && user.siswa.kelas.nama_kelas) ? user.siswa.kelas.nama_kelas : '-';
                siswaText.innerText = user.siswa.nama_siswa + ' (NISN: ' + user.siswa.nisn + ') - Kelas: ' + kelasNama;
            }
        } else {
            if (siswaRow) siswaRow.style.display = 'none';
        }

        openModal('modalDetailUser');
    }

    function filterGuruPicker(query) {
        const select = document.getElementById('selectGuruPicker');
        const badge = document.getElementById('guruMatchCount');
        if (!select) return;

        const q = query.trim().toLowerCase();
        let count = 0;

        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            if (!opt.value) {
                // Default option ("Ketik NIP Manual...") is always visible
                opt.hidden = false;
                opt.style.display = '';
                continue;
            }

            const nip = (opt.getAttribute('data-nip') || '').toLowerCase();
            const nama = (opt.getAttribute('data-nama') || '').toLowerCase();
            const text = (opt.text || '').toLowerCase();

            if (q === '' || nip.includes(q) || nama.includes(q) || text.includes(q)) {
                opt.hidden = false;
                opt.style.display = '';
                count++;
            } else {
                opt.hidden = true;
                opt.style.display = 'none';
            }
        }

        if (badge) {
            if (q === '') {
                badge.innerText = '';
            } else {
                badge.innerText = count > 0 ? count + ' guru cocok' : 'Tidak ditemukan';
            }
        }
    }

    function autoFillGuruData(select) {
        const option = select.options[select.selectedIndex];
        const lockBanner = document.getElementById('guruLockBanner');

=======
    // 5. ROLE & PICKER INTERACTIONS
    function handleRoleChange(role) {
        const guruPicker = document.getElementById('guruPickerContainer');
        const siswaPicker = document.getElementById('siswaPickerContainer');
        const nipLabel = document.getElementById('nipLabel');
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        const nipInput = document.getElementById('add_nip');

        if (role === 'orang_tua') {
            if (guruPicker) guruPicker.style.display = 'none';
            if (siswaPicker) siswaPicker.style.display = 'block';
            if (nipLabel) nipLabel.textContent = 'NISN * (10 Digit)';
            if (nipInput) {
                nipInput.placeholder = '0081234567';
                nipInput.maxLength = 10;
                nipInput.minLength = 10;
            }
        } else {
            if (guruPicker) guruPicker.style.display = 'block';
            if (siswaPicker) siswaPicker.style.display = 'none';
            if (nipLabel) nipLabel.textContent = 'NIP * (18 Digit)';
            if (nipInput) {
                nipInput.placeholder = '198001012005011000';
                nipInput.maxLength = 18;
                nipInput.minLength = 5;
            }
        }
    }

    function handleEditRoleChange(role) {
        const nipLabel = document.getElementById('edit_nip_label');
        const nipInput = document.getElementById('edit_nip');
        if (role === 'orang_tua') {
            if (nipLabel) nipLabel.textContent = 'NISN * (10 Digit)';
            if (nipInput) {
                nipInput.maxLength = 10;
                nipInput.minLength = 10;
            }
        } else {
            if (nipLabel) nipLabel.textContent = 'NIP * (18 Digit)';
            if (nipInput) {
                nipInput.maxLength = 18;
                nipInput.minLength = 5;
            }
        }
    }

    function handleNipInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function handleEditNipInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function autoFillGuruData(selectEl) {
        const selected = selectEl.options[selectEl.selectedIndex];
        if (!selected || !selected.value) {
            unlockTambahUserForm();
            return;
        }

        const nip = selected.getAttribute('data-nip');
        const nama = selected.getAttribute('data-nama');
        const jk = selected.getAttribute('data-jk');
        const hp = selected.getAttribute('data-hp');
        const isWali = selected.getAttribute('data-is-wali');

        document.getElementById('add_nip').value = nip || '';
        document.getElementById('add_name').value = nama || '';
        document.getElementById('add_jenis_kelamin').value = jk || '';
        document.getElementById('add_no_hp').value = hp || '';

        // Auto username suggestion
        const cleanName = nama.toLowerCase().replace(/[^a-z0-9]/g, '.').replace(/\.+/g, '.').replace(/^\.|\.$/g, '');
        document.getElementById('add_username').value = cleanName ? 'guru.' + cleanName.split('.')[0] + nip.slice(-2) : '';

        // Suggest role
        const roleSelect = document.getElementById('add_role');
<<<<<<< HEAD
        const role = roleSelect ? roleSelect.value : '';
        if (role === 'orang_tua') {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
        } else {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 18);
        }
    }

    function handleRoleChange(role) {
        const guruContainer = document.getElementById('guruPickerContainer');
        const siswaContainer = document.getElementById('siswaPickerContainer');
        const batchOrtuContainer = document.getElementById('batchOrtuContainer');
        const nipGroup = document.getElementById('nipGroup');
        const nipLabel = document.getElementById('nipLabel');
        const nipInput = document.getElementById('add_nip');
        const usernameLabel = document.getElementById('usernameLabel');
        const usernameInput = document.getElementById('add_username');
        const idSiswaInput = document.getElementById('add_id_siswa');
        const siswaLockBanner = document.getElementById('siswaLockBanner');
        const guruLockBanner = document.getElementById('guruLockBanner');

        if (role === 'piket' || role === 'satpam') {
            if (guruContainer) guruContainer.style.display = 'none';
            if (siswaContainer) siswaContainer.style.display = 'none';
            if (batchOrtuContainer) batchOrtuContainer.style.display = 'none';
            if (siswaLockBanner) siswaLockBanner.style.display = 'none';
            if (guruLockBanner) guruLockBanner.style.display = 'none';

            if (nipGroup) nipGroup.style.display = 'none';
            if (nipInput) {
                nipInput.required = false;
                nipInput.value = '';
            }

            if (usernameLabel) {
                usernameLabel.innerHTML = 'Username Petugas * <span style="color:#ef4444;">(Wajib - Tanpa NIP)</span>';
            }
            if (usernameInput) {
                usernameInput.required = true;
                usernameInput.placeholder = role === 'piket' ? 'Contoh: piket' : 'Contoh: Satpam';
            }
            if (idSiswaInput) idSiswaInput.value = '';
        } else if (role === 'orang_tua') {
            if (guruContainer) guruContainer.style.display = 'none';
            if (siswaContainer) siswaContainer.style.display = 'block';
            if (batchOrtuContainer) batchOrtuContainer.style.display = 'block';
            if (guruLockBanner) guruLockBanner.style.display = 'none';

            if (nipGroup) nipGroup.style.display = 'block';
            if (nipLabel) nipLabel.innerText = 'NISN * (10 Digit)';
            if (nipInput) {
                nipInput.required = true;
                nipInput.placeholder = 'Contoh: 0002024001';
                nipInput.setAttribute('maxlength', '10');
                nipInput.setAttribute('minlength', '10');
            }

            if (usernameLabel) usernameLabel.innerText = 'Username (Opsional)';
            if (usernameInput) {
                usernameInput.required = false;
                usernameInput.placeholder = 'username.ortu';
            }
        } else {
            if (guruContainer) guruContainer.style.display = 'block';
            if (siswaContainer) siswaContainer.style.display = 'none';
            if (batchOrtuContainer) batchOrtuContainer.style.display = 'none';
            if (siswaLockBanner) siswaLockBanner.style.display = 'none';

            if (nipGroup) nipGroup.style.display = 'block';
            if (nipLabel) nipLabel.innerText = 'NIP * (18 Digit)';
            if (nipInput) {
                nipInput.required = true;
                nipInput.placeholder = '198001012005011000';
                nipInput.setAttribute('maxlength', '30');
                nipInput.setAttribute('minlength', '18');
            }

            if (usernameLabel) usernameLabel.innerText = 'Username (Opsional)';
            if (usernameInput) {
                usernameInput.required = false;
                usernameInput.placeholder = 'username.guru';
            }
            if (idSiswaInput) idSiswaInput.value = '';
        }
    }

    function filterSiswaPicker(query) {
        const select = document.getElementById('selectSiswaPicker');
        const badge = document.getElementById('siswaMatchCount');
        if (!select) return;

        const q = query.trim().toLowerCase();
        let count = 0;

        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            if (!opt.value) {
                opt.hidden = false;
                opt.style.display = '';
                continue;
            }

            const nisn = (opt.getAttribute('data-nisn') || '').toLowerCase();
            const nama = (opt.getAttribute('data-nama') || '').toLowerCase();
            const text = (opt.text || '').toLowerCase();

            if (q === '' || nisn.includes(q) || nama.includes(q) || text.includes(q)) {
                opt.hidden = false;
                opt.style.display = '';
                count++;
=======
        if (roleSelect) {
            if (isWali === '1') {
                roleSelect.value = 'wali_kelas';
            } else {
                roleSelect.value = 'guru';
            }
        }

        // Show lock banner
        const lockBanner = document.getElementById('guruLockBanner');
        if (lockBanner) lockBanner.style.display = 'flex';
    }

    function autoFillSiswaData(selectEl) {
        const selected = selectEl.options[selectEl.selectedIndex];
        if (!selected || !selected.value) {
            unlockTambahUserForm();
            return;
        }

        const idSiswa = selected.getAttribute('data-id-siswa');
        const nisn = selected.getAttribute('data-nisn');
        const nama = selected.getAttribute('data-nama');
        const jk = selected.getAttribute('data-jk');

        document.getElementById('add_id_siswa').value = idSiswa || '';
        document.getElementById('add_nip').value = nisn || '';
        document.getElementById('add_name').value = 'Wali dari ' + nama;
        document.getElementById('add_jenis_kelamin').value = jk || '';
        document.getElementById('add_username').value = 'ortu.' + nisn;
        document.getElementById('add_password').value = nisn;
        document.getElementById('add_password_confirmation').value = nisn;

        const lockBanner = document.getElementById('siswaLockBanner');
        if (lockBanner) lockBanner.style.display = 'flex';
    }

    function filterGuruPicker(keyword) {
        const select = document.getElementById('selectGuruPicker');
        if (!select) return;
        const kw = keyword.toLowerCase().trim();
        let matchCount = 0;

        for (let i = 1; i < select.options.length; i++) {
            const opt = select.options[i];
            const text = opt.text.toLowerCase();
            if (!kw || text.includes(kw)) {
                opt.style.display = '';
                matchCount++;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            } else {
                opt.style.display = 'none';
            }
        }

        const counter = document.getElementById('guruMatchCount');
        if (counter) {
            counter.textContent = kw ? `(${matchCount} guru cocok)` : '';
        }
    }

    function filterSiswaPicker(keyword) {
        const select = document.getElementById('selectSiswaPicker');
        if (!select) return;
        const kw = keyword.toLowerCase().trim();
        let matchCount = 0;

        for (let i = 1; i < select.options.length; i++) {
            const opt = select.options[i];
            const text = opt.text.toLowerCase();
            if (!kw || text.includes(kw)) {
                opt.style.display = '';
                matchCount++;
            } else {
                opt.style.display = 'none';
            }
        }

<<<<<<< HEAD
        // Siswa dipilih dari Data Master Siswa
        const idSiswa = option.getAttribute('data-id-siswa') || '';
        const nisn = option.getAttribute('data-nisn') || '';
        const nama = option.getAttribute('data-nama') || '';
        const jk = option.getAttribute('data-jk') || 'L';
        const tglLahir = option.getAttribute('data-tanggal-lahir') || '';
        const defaultPassword = tglLahir ? tglLahir : 'ortu123';

        if (idSiswaInput) idSiswaInput.value = idSiswa;
        if (nipInput) nipInput.value = nisn;
        if (nameInput) nameInput.value = 'Orang Tua - ' + nama;
        if (jkSelect) jkSelect.value = jk || 'L';
        if (usernameInput) usernameInput.value = 'ortu.' + nisn;
        if (passInput) passInput.value = defaultPassword;
        if (passConfirmInput) passConfirmInput.value = defaultPassword;

        // KUNCI pengisian data agar tidak dapat diubah manual selagi siswa dipilih
        inputsToLock.forEach(el => {
            if (el) {
                el.readOnly = true;
                el.style.backgroundColor = '#f1f5f9';
                el.style.cursor = 'not-allowed';
            }
        });

        if (jkSelect) {
            jkSelect.style.pointerEvents = 'none';
            jkSelect.style.backgroundColor = '#f1f5f9';
            jkSelect.style.cursor = 'not-allowed';
            jkSelect.setAttribute('tabindex', '-1');
=======
        const counter = document.getElementById('siswaMatchCount');
        if (counter) {
            counter.textContent = kw ? `(${matchCount} siswa cocok)` : '';
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        }
    }

    function unlockTambahUserForm() {
        const sBanner = document.getElementById('siswaLockBanner');
        if (sBanner) sBanner.style.display = 'none';
        const gBanner = document.getElementById('guruLockBanner');
        if (gBanner) gBanner.style.display = 'none';
    }

    function resetTambahUserForm() {
        const searchG = document.getElementById('searchGuruPicker');
        if (searchG) searchG.value = '';
        const selectG = document.getElementById('selectGuruPicker');
        if (selectG) selectG.value = '';

        const searchS = document.getElementById('searchSiswaPicker');
        if (searchS) searchS.value = '';
        const selectS = document.getElementById('selectSiswaPicker');
        if (selectS) selectS.value = '';

        filterGuruPicker('');
        filterSiswaPicker('');

        document.getElementById('add_id_siswa').value = '';
        document.getElementById('add_nip').value = '';
        document.getElementById('add_username').value = '';
        document.getElementById('add_name').value = '';
        document.getElementById('add_jenis_kelamin').value = '';
        document.getElementById('add_no_hp').value = '';
        document.getElementById('add_email').value = '';
        document.getElementById('add_password').value = '';
        document.getElementById('add_password_confirmation').value = '';
        
        const msg = document.getElementById('passwordMatchMsg');
        if (msg) msg.style.display = 'none';

        unlockTambahUserForm();
    }

    function confirmGenerateAllOrangTua() {
        const totalSiswa = {{ count($siswaList) }};
        const pesan = `Buat Akun Orang Tua untuk Seluruh Data Siswa (${totalSiswa} siswa)?\n\n` +
            `• Sistem akan otomatis membuat akun role Orang Tua untuk setiap siswa yang belum memiliki akun.\n` +
            `• Password: Menggunakan Tanggal Lahir Siswa (atau default: 'ortu123' jika tanggal lahir belum ada).\n` +
            `• Siswa yang sudah memiliki akun Orang Tua akan dilewati secara aman (tidak duplikat).\n\n` +
            `Klik OK untuk melanjutkan proses pembuatan massal.`;

        if (confirm(pesan)) {
            const btn = document.getElementById('btnBatchOrtu');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses Akun Ortu...';
                btn.style.opacity = '0.75';
                btn.style.cursor = 'not-allowed';
            }
            document.getElementById('formGenerateAllOrangTua').submit();
        }
    }

    function toggleSelectAllUsers(master) {
        const checkboxes = document.querySelectorAll('.user-select-checkbox:not(:disabled)');
        checkboxes.forEach(cb => {
            cb.checked = master.checked;
        });
        updateBulkDeleteState();
    }

    function updateBulkDeleteState() {
        const checkboxes = document.querySelectorAll('.user-select-checkbox:not(:disabled)');
        const checked = document.querySelectorAll('.user-select-checkbox:checked');
        const master = document.getElementById('selectAllUsers');
        const btn = document.getElementById('btnBulkDeleteUsers');
        const countBadge = document.getElementById('bulkDeleteCount');

        if (countBadge) countBadge.innerText = checked.length;

        if (master) {
            master.checked = checkboxes.length > 0 && checked.length === checkboxes.length;
            master.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
        }

        if (btn) {
            if (checked.length > 0) {
                btn.disabled = false;
                btn.classList.remove('is-disabled');
            } else {
                btn.disabled = true;
                btn.classList.add('is-disabled');
            }
        }
    }

    function confirmBulkDeleteUsers() {
        const checked = document.querySelectorAll('.user-select-checkbox:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu akun pengguna untuk dihapus.');
            return;
        }

        const count = checked.length;
        const pesan = `Apakah Anda yakin ingin memindahkan ${count} akun pengguna terpilih ke Tempat Sampah?\n\n` +
            `• Akun yang dihapus akan masuk ke status Tempat Sampah (Soft Delete).\n` +
            `• Anda dapat memulihkannya kembali kapan saja melalui menu 'Lihat Sampah Pengguna'.\n\n` +
            `Klik OK untuk melanjutkan penghapusan.`;

        if (confirm(pesan)) {
            const btn = document.getElementById('btnBulkDeleteUsers');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Menghapus...</span>';
            }
            document.getElementById('formBulkDeleteUsers').submit();
        }
    }

    let toastTimeout = null;
    function showRealtimeToast(message, isSuccess = true) {
        const toast = document.getElementById('realtimeToast');
        const toastMsg = document.getElementById('realtimeToastMsg');
        const toastIcon = document.getElementById('realtimeToastIcon');

        if (!toast || !toastMsg) return;

        toastMsg.innerText = message;
        if (isSuccess) {
            toast.className = 'realtime-toast show toast-success';
            if (toastIcon) {
                toastIcon.className = 'fa-solid fa-circle-check';
                toastIcon.style.color = '#22c55e';
            }
        } else {
            toast.className = 'realtime-toast show toast-error';
            if (toastIcon) {
                toastIcon.className = 'fa-solid fa-circle-exclamation';
                toastIcon.style.color = '#ef4444';
            }
        }

        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }

    async function handleUserToggle(checkbox, userId, userName) {
        const isChecked = checkbox.checked;
        const label = document.getElementById('status-label-' + userId);
        const originalChecked = !isChecked;

        // Visual feedback immediately
        if (label) {
            label.innerText = isChecked ? 'Aktif' : 'Nonaktif';
            label.className = 'user-status-label ' + (isChecked ? 'status-on' : 'status-off');
        }

        checkbox.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                : '{{ csrf_token() }}';

            const response = await fetch(`/admin/users/${userId}/toggle-active`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    is_active: isChecked ? 1 : 0
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                checkbox.checked = data.is_active;
                if (label) {
                    label.innerText = data.is_active ? 'Aktif' : 'Nonaktif';
                    label.className = 'user-status-label ' + (data.is_active ? 'status-on' : 'status-off');
                }
                showRealtimeToast(data.message || `Status akun '${userName}' berhasil diubah menjadi ${data.is_active ? 'Aktif (ON)' : 'Nonaktif (OFF)'}.`, true);
            } else {
                checkbox.checked = originalChecked;
                if (label) {
                    label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                    label.className = 'user-status-label ' + (originalChecked ? 'status-on' : 'status-off');
                }
                showRealtimeToast(data.message || 'Gagal mengubah status akun pengguna.', false);
            }
        } catch (error) {
            console.error('Error toggling user status:', error);
            checkbox.checked = originalChecked;
            if (label) {
                label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                label.className = 'user-status-label ' + (originalChecked ? 'status-on' : 'status-off');
            }
            showRealtimeToast('Terjadi kesalahan koneksi saat mengubah status akun.', false);
        } finally {
            checkbox.disabled = false;
        }
    }
</script>
@endsection
