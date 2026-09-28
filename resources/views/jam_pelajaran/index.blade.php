@extends('layouts.admin')

@section('title', 'Master Jam Pelajaran — EDU JOURNAL')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-top-header p {
        font-size: 13px;
        color: #64748b;
    }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 12px;
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

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .btn-submit-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3b5490, #2563eb);
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    /* Filter & Reset Buttons */
    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Table Custom */
    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ffffff;
        padding: 14px 16px;
        text-align: left;
        background: #2b395b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    /* Action Buttons Container & Pills */
    .action-buttons {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 13px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }

    /* 1. Lihat (Detail) Button - Blue/Sky */
    .btn-view {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    /* 2. Edit Button - Amber/Yellow */
    .btn-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    /* 3. Hapus Button - Rose/Red */
    .btn-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-delete:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    .badge-time {
        background: #f1f5f9;
        color: #3b5490;
        font-weight: 800;
        font-family: monospace;
        font-size: 13.5px;
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* ========================================================
       SWITCH SAKELAR ON/OFF (SESUAI GAMBAR DOKUMENTASI RESMI)
       ======================================================== */
    .jam-switch-control {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .switch-toggle-custom {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
        cursor: pointer;
        margin: 0;
        user-select: none;
    }

    .switch-toggle-custom input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 9999px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .switch-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .switch-toggle-custom input:checked + .switch-slider {
        background-color: #22c55e; /* Hijau Segar sesuai gambar sakelar user */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12);
    }

    .switch-toggle-custom input:focus + .switch-slider {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
    }

    .switch-toggle-custom input:checked + .switch-slider:before {
        transform: translateX(20px);
    }

    .switch-toggle-custom input:disabled + .switch-slider {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Badge Maju (Shifted forward) */
    .badge-maju-pill {
        background: #fef3c7;
        color: #b45309;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #fde68a;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        animation: pulseShift 2s infinite ease-in-out;
    }

    @keyframes pulseShift {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .badge-time-shifted {
        border-color: #f59e0b !important;
        background: #fffbeb !important;
        color: #b45309 !important;
    }

    .badge-time-inactive {
        background: #f1f5f9 !important;
        color: #94a3b8 !important;
        border-color: #e2e8f0 !important;
        font-style: italic;
    }

    /* Reset Schedule Button */
    .btn-reset-schedule {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.15);
    }
    .btn-reset-schedule:hover {
        background: #10b981;
        color: #ffffff;
        border-color: #059669;
    }

    /* Set Hari Libur Button */
    .btn-set-holiday {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(225, 29, 72, 0.12);
        position: relative;
    }
    .btn-set-holiday:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #be123c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
    }
    .btn-set-holiday .badge-holiday-count {
        background: #e11d48;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 20px;
        margin-left: 2px;
        transition: all 0.2s ease;
    }
    .btn-set-holiday:hover .badge-holiday-count {
        background: #ffffff;
        color: #e11d48;
    }

    /* Holiday Alert Banner on Main Page */
    .holiday-alert-banner {
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1.5px solid #fecdd3;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(225, 29, 72, 0.08);
        animation: fadeInSlide 0.3s ease;
    }
    .holiday-alert-left {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }
    .holiday-alert-icon {
        width: 48px;
        height: 48px;
        background: #ffe4e6;
        border: 1.5px solid #fda4af;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #e11d48;
        flex-shrink: 0;
    }
    .holiday-alert-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        color: #be123c;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 3px;
    }
    .holiday-alert-badge .pulse-indicator {
        width: 8px;
        height: 8px;
        background: #e11d48;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 rgba(225, 29, 72, 0.7);
        animation: pulseRed 1.8s infinite;
    }
    @keyframes pulseRed {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(225, 29, 72, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0); }
    }
    .holiday-alert-title {
        font-size: 15px;
        font-weight: 800;
        color: #881337;
        margin: 0 0 4px 0;
    }
    .holiday-alert-desc {
        font-size: 13px;
        color: #4c0519;
        margin: 0;
        line-height: 1.45;
    }
    .btn-banner-manage-holiday {
        background: #ffffff;
        color: #be123c;
        border: 1.5px solid #fecdd3;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(190, 18, 60, 0.08);
    }
    .btn-banner-manage-holiday:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #be123c;
        transform: translateY(-1px);
    }

    /* Modal Backdrop & Dialog */
    .holiday-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }
    .holiday-modal-dialog {
        background: #ffffff;
        width: 100%;
        max-width: 980px;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        animation: modalScaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes modalScaleIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .holiday-modal-header {
        padding: 18px 24px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .holiday-header-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .holiday-header-icon {
        width: 44px;
        height: 44px;
        background: #ffe4e6;
        color: #e11d48;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .holiday-modal-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .holiday-modal-subtitle {
        font-size: 12.5px;
        color: #64748b;
        margin: 2px 0 0 0;
    }
    .holiday-btn-close {
        background: transparent;
        border: none;
        font-size: 26px;
        line-height: 1;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    .holiday-btn-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .holiday-modal-body {
        padding: 22px 24px;
        overflow-y: auto;
        flex: 1;
        background: #f8fafc;
    }
    .holiday-modal-footer {
        padding: 14px 24px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .btn-holiday-close-footer {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-holiday-close-footer:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    /* Notice Box */
    .holiday-notice-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
    }
    .holiday-notice-box .notice-icon {
        font-size: 18px;
        color: #2563eb;
        margin-top: 2px;
    }
    .holiday-notice-box .notice-text {
        font-size: 12.5px;
        color: #1e40af;
        line-height: 1.45;
    }

    /* Live Holiday Status Bar in Modal */
    .holiday-status-today-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .status-indicator-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
    }
    .status-indicator-badge.status-libur {
        background: #ffe4e6;
        color: #be123c;
        border: 1px solid #fecdd3;
    }
    .status-indicator-badge.status-efektif {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .status-info-date {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    /* Card Box in Modal */
    .holiday-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .holiday-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .card-header-icon {
        width: 34px;
        height: 34px;
        background: #fee2e2;
        color: #dc2626;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }
    .holiday-card-header .card-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .holiday-card-header .card-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 1px 0 0 0;
    }

    /* Counter Pills */
    .holiday-counter-pills {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pill-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .pill-total {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .pill-active {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    /* Input Row */
    .holiday-rows-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .holiday-input-row {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 12px 14px;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    .holiday-input-row:hover {
        border-color: #cbd5e1;
        background: #ffffff;
    }
    .row-num-badge {
        font-size: 12px;
        font-weight: 800;
        color: #64748b;
        background: #e2e8f0;
        padding: 8px 10px;
        border-radius: 8px;
        align-self: center;
    }
    .form-group-field {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .field-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #334155;
    }
    .required-star {
        color: #e11d48;
    }
    .holiday-input {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }
    .holiday-input:focus {
        border-color: #e11d48;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }
    .btn-remove-row {
        background: #fee2e2;
        color: #ef4444;
        border: 1px solid #fecaca;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-remove-row:hover:not(:disabled) {
        background: #ef4444;
        color: #ffffff;
    }
    .btn-remove-row:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Form Controls */
    .holiday-form-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .btn-add-holiday-row {
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px dashed #93c5fd;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .btn-add-holiday-row:hover {
        background: #dbeafe;
        border-color: #3b82f6;
    }
    .form-actions-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-holiday-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-holiday-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .btn-holiday-submit {
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.25);
    }
    .btn-holiday-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    /* Holiday Table */
    .holiday-table-container {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-top: 10px;
    }
    .holiday-table {
        width: 100%;
        border-collapse: collapse;
    }
    .holiday-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .holiday-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #1e293b;
        vertical-align: middle;
    }
    .holiday-table tr:hover td {
        background: #f8fafc;
    }
    .row-ongoing-holiday td {
        background: #fff1f2 !important;
    }
    .badge-durasi {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .badge-status-holiday {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-holiday-active {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .badge-holiday-inactive {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
    }
    .badge-ongoing-pulse {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        margin-top: 3px;
    }
    .holiday-action-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-h-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }
    .btn-h-deactivate {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    .btn-h-deactivate:hover {
        background: #fde68a;
    }
    .btn-h-activate {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .btn-h-activate:hover {
        background: #bbf7d0;
    }
    .btn-h-delete {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fecaca;
    }
    .btn-h-delete:hover {
        background: #ef4444;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        /* Modal Backdrop & Dialog */
        .holiday-modal-backdrop {
            padding: 10px !important;
            align-items: flex-start !important;
            padding-top: 16px !important;
            padding-bottom: 16px !important;
            z-index: 100000 !important;
        }

        .holiday-modal-dialog {
            border-radius: 16px !important;
            max-height: 92vh !important;
            width: 100% !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
        }

        .holiday-modal-header {
            padding: 14px 16px !important;
            gap: 10px !important;
        }

        .holiday-header-title-wrap {
            gap: 10px !important;
        }

        .holiday-header-icon {
            width: 38px !important;
            height: 38px !important;
            font-size: 17px !important;
            border-radius: 10px !important;
            flex-shrink: 0 !important;
        }

        .holiday-modal-title {
            font-size: 15px !important;
            line-height: 1.3 !important;
        }

        .holiday-modal-subtitle {
            font-size: 11.5px !important;
            line-height: 1.3 !important;
        }

        .holiday-modal-body {
            padding: 14px 12px !important;
        }

        .holiday-status-today-bar {
            padding: 10px 12px !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
        }

        .holiday-status-today-bar .status-indicator-badge {
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 12px !important;
        }

        .holiday-card-box {
            padding: 14px 12px !important;
            border-radius: 14px !important;
        }

        .holiday-card-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }

        .holiday-card-header .card-title {
            font-size: 14px !important;
        }

        .holiday-card-header .card-subtitle {
            font-size: 11.5px !important;
        }

        .holiday-counter-pills {
            width: 100% !important;
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
        }

        /* Form Batch Input Row on Mobile */
        .holiday-input-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            padding: 12px !important;
            border-radius: 12px !important;
        }

        .holiday-input-row .row-num-badge {
            align-self: flex-start !important;
            font-size: 11.5px !important;
            padding: 4px 8px !important;
        }

        .holiday-input-row .form-group-field {
            width: 100% !important;
            flex: none !important;
        }

        .holiday-input-row .row-actions {
            width: 100% !important;
            margin-top: 2px !important;
        }

        .holiday-input-row .row-actions label {
            display: none !important;
        }

        .holiday-input-row .btn-remove-row {
            width: 100% !important;
            height: 36px !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .holiday-form-controls {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
        }

        .btn-add-holiday-row {
            width: 100% !important;
            justify-content: center !important;
            padding: 11px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .form-actions-right {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .btn-holiday-reset,
        .btn-holiday-submit {
            width: 100% !important;
            justify-content: center !important;
            padding: 11px 10px !important;
            font-size: 12.5px !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        /* Responsive Transform: Holiday Table to Mobile Cards */
        .holiday-table-container {
            border: none !important;
            overflow-x: visible !important;
            margin-top: 12px !important;
        }

        .holiday-table {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .holiday-table thead {
            display: none !important;
        }

        .holiday-table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        .holiday-table tbody tr.holiday-row-card {
            display: grid !important;
            grid-template-columns: auto 1fr auto !important;
            gap: 8px 10px !important;
            padding: 14px 14px !important;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .holiday-table tbody tr.holiday-row-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-sizing: border-box !important;
        }

        /* Col No & Keterangan & Durasi */
        .holiday-table tbody tr.holiday-row-card .col-h-no {
            grid-column: 1 !important;
            grid-row: 1 !important;
            align-self: flex-start !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-no .badge-h-no {
            background: #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 800 !important;
            font-size: 11.5px !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
            display: inline-block !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-keterangan {
            grid-column: 2 !important;
            grid-row: 1 !important;
            align-self: center !important;
            text-align: left !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-keterangan .h-keterangan-title {
            font-weight: 800 !important;
            color: #0f172a !important;
            font-size: 14px !important;
            line-height: 1.35 !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-durasi {
            grid-column: 3 !important;
            grid-row: 1 !important;
            justify-self: end !important;
            align-self: flex-start !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-durasi .badge-durasi {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            border: 1px solid #bfdbfe !important;
            padding: 3px 9px !important;
            border-radius: 6px !important;
            font-size: 11.5px !important;
            font-weight: 800 !important;
            white-space: nowrap !important;
            display: inline-block !important;
        }

        /* Col Periode */
        .holiday-table tbody tr.holiday-row-card .col-h-periode {
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            background: #f8fafc !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 10px !important;
            padding: 8px 12px !important;
            margin-top: 2px !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-periode .h-periode-wrap {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            font-size: 12.5px !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-periode .h-periode-dates {
            font-size: 11.5px !important;
            color: #64748b !important;
            margin-top: 2px !important;
            font-family: monospace !important;
        }

        /* Col Status */
        .holiday-table tbody tr.holiday-row-card .col-h-status {
            grid-column: 1 / -1 !important;
            grid-row: 3 !important;
            text-align: left !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-status .badge-status-holiday {
            font-size: 11.5px !important;
            padding: 4px 10px !important;
        }

        /* Col Aksi */
        .holiday-table tbody tr.holiday-row-card .col-h-aksi {
            grid-column: 1 / -1 !important;
            grid-row: 4 !important;
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
            width: 100% !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-aksi .holiday-action-group {
            display: flex !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-aksi .holiday-action-group .btn-h-action {
            flex: 1 !important;
            justify-content: center !important;
            padding: 9px 12px !important;
            border-radius: 10px !important;
            font-size: 12.5px !important;
            box-sizing: border-box !important;
        }

        .holiday-table tbody tr.holiday-row-card .col-h-aksi .holiday-action-group .btn-h-delete {
            flex: 0 0 44px !important;
            justify-content: center !important;
            padding: 9px !important;
        }

        .holiday-modal-footer {
            flex-direction: column !important;
            gap: 12px !important;
            text-align: center !important;
            padding: 14px 16px !important;
        }

        .btn-holiday-close-footer {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 16px !important;
        }

        .holiday-alert-banner {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            padding: 14px 14px !important;
        }

        .holiday-alert-left {
            flex-direction: row !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }

        .btn-banner-manage-holiday {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }
    }

    /* Floating Toast Notification */
    .jam-toast-box {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }
    .jam-toast-item {
        pointer-events: auto;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 20px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        font-size: 13.5px;
        font-weight: 600;
        min-width: 280px;
        max-width: 420px;
        animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .jam-toast-item.toast-success {
        border-left: 5px solid #22c55e;
    }
    .jam-toast-item.toast-error {
        border-left: 5px solid #ef4444;
    }
    @keyframes toastSlideIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-error {
        background: #fff1f2;
        color: #9f1239;
        border: 1px solid #fecdd3;
    }

    /* Modal Overlay */
    .modal-bg {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 99999 !important;
        align-items: center;
        justify-content: center;
        padding: 16px;
        box-sizing: border-box;
    }
    .modal-bg.active { display: flex; }
    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    .modal-icon-wrap {
        width: 52px;
        height: 52px;
        background: #ffe4e6;
        color: #be123c;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }
    .modal-box h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
    .modal-box p { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 12px; }
    .btn-m-cancel {
        flex: 1;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
    }
    .btn-m-confirm {
        flex: 1;
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: #ffffff;
        border: none;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
    }

    .form-control.search-input-control,
    .search-input-control {
        padding-left: 38px !important;
    }
    .search-icon-inside {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
        z-index: 2;
    }

    /* ========================================================
       MOBILE RESPONSIVE STYLES (KHUSUS MOBILE HP <= 768px & <= 480px)
       Tampilan Desktop/Laptop Tetap 100% Sesuai & Tidak Terganggu
       ======================================================== */
    .mobile-select-all-bar,
    .mobile-label-text,
    .mobile-label-inline,
    .mobile-badge-no,
    .mobile-pagination-wrapper {
        display: none;
    }

    @media (max-width: 768px) {
        .page-header-container {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            line-height: 1.25 !important;
        }

        .page-title-group p {
            font-size: 13px !important;
        }

        .breadcrumb-text {
            font-size: 12.5px !important;
            margin-bottom: 16px !important;
        }

        .card {
            padding: 16px 14px !important;
            border-radius: 14px !important;
            margin-bottom: 18px !important;
        }

        .card-top-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }

        .card-top-header h2 {
            font-size: 16px !important;
            line-height: 1.4 !important;
        }

        .card-top-header p {
            font-size: 12.5px !important;
        }

        /* Card 1: Form Tambah Jam Pelajaran */
        .form-section-label-grid {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }

        .form-grid-times {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }

        .btn-submit-container {
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 10px !important;
            margin-top: 16px !important;
        }

        .btn-submit-container .btn-reset-form,
        .btn-submit-container .btn-submit {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 16px !important;
            font-size: 13.5px !important;
        }

        /* Card 2: Filter & Search */
        .jam-filter-form {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 14px 12px !important;
            gap: 10px !important;
        }

        .jam-filter-search-box {
            width: 100% !important;
            flex: none !important;
        }

        .jam-filter-search-box .form-control {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .jam-filter-buttons {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
            margin-left: 0 !important;
        }

        .jam-filter-buttons .btn-filter,
        .jam-filter-buttons .btn-reset {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 8px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        .jam-filter-buttons .btn-reset-schedule {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .jam-filter-buttons .btn-set-holiday {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .jam-filter-buttons .btn-trash {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .jam-filter-buttons .btn-delete {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        /* Info Box Ketentuan KBM */
        .jam-info-box-grid {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }

        /* Mobile Select All Bar */
        .mobile-select-all-bar {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 10px 14px !important;
            margin-bottom: 12px !important;
        }

        .mobile-select-all-bar label {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            cursor: pointer !important;
            margin-bottom: 0 !important;
        }

        .mobile-select-all-bar input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            accent-color: #e11d48 !important;
            cursor: pointer !important;
        }

        /* Transform Table into Mobile Cards */
        .jam-table-custom {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .jam-table-custom thead {
            display: none !important;
        }

        .jam-table-custom tbody {
            display: block !important;
            width: 100% !important;
        }

        .jam-table-custom tbody tr.jam-row-card {
            display: grid !important;
            grid-template-columns: 28px 1fr auto !important;
            gap: 8px 10px !important;
            padding: 14px 16px !important;
            margin-bottom: 12px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .jam-table-custom tbody tr.jam-row-card:last-child {
            margin-bottom: 0 !important;
        }

        .jam-table-custom tbody tr.jam-row-card.mobile-page-hidden {
            display: none !important;
        }

        .jam-table-custom tbody tr.jam-row-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-sizing: border-box !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-checkbox {
            grid-column: 1 !important;
            align-self: center !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-checkbox input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-jam {
            grid-column: 2 !important;
            align-self: center !important;
            text-align: left !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-jam strong {
            font-size: 15px !important;
            color: #0f172a !important;
            font-weight: 800 !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-no {
            grid-column: 3 !important;
            justify-self: end !important;
            align-self: center !important;
            text-align: right !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-no .no-text {
            font-size: 11.5px !important;
            font-weight: 800 !important;
            background: #f1f5f9 !important;
            color: #475569 !important;
            padding: 3px 8px !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            display: inline-block !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-sk {
            grid-column: 1 / -1 !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-jumat {
            grid-column: 1 / -1 !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-ket {
            grid-column: 1 / -1 !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-ket.col-ket-empty {
            display: none !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-aksi {
            grid-column: 1 / -1 !important;
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
            width: 100% !important;
            display: block !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-aksi .action-buttons {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-aksi .action-buttons .btn-view {
            grid-column: 1 / -1 !important;
        }

        .jam-table-custom tbody tr.jam-row-card .col-aksi .action-buttons .btn-action {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 9px 8px !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            border-radius: 10px !important;
            margin: 0 !important;
            text-decoration: none !important;
        }

        .mobile-label-text {
            display: inline !important;
            font-weight: 700 !important;
            color: #64748b !important;
            margin-right: 4px !important;
            font-size: 12px !important;
        }

        .mobile-time-wrapper {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            width: 100% !important;
        }

        .mobile-time-wrapper .badge-time {
            font-size: 12.5px !important;
            padding: 4px 10px !important;
        }

        /* Mobile Pagination Styling */
        .mobile-pagination-wrapper {
            display: block !important;
            margin-top: 18px !important;
            padding-top: 14px !important;
            border-top: 1px solid #f1f5f9 !important;
            width: 100% !important;
        }

        .mobile-pagination-wrapper .custom-pagination-bar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            text-align: center !important;
            width: 100% !important;
        }

        .mobile-pagination-wrapper .pagination-info {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #64748b !important;
        }

        .mobile-pagination-wrapper .pagination-list {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: flex-start !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            gap: 5px !important;
            padding: 4px 6px !important;
            margin: 0 auto !important;
            max-width: 100% !important;
            scrollbar-width: thin !important;
            box-sizing: border-box !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item {
            display: inline-flex !important;
            flex-shrink: 0 !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #334155 !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
            transition: all 0.15s ease !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item.active .page-link {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item.disabled .page-link {
            background: #f8fafc !important;
            color: #cbd5e1 !important;
            border-color: #e2e8f0 !important;
            cursor: not-allowed !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .card {
            padding: 14px 12px !important;
        }

        .jam-filter-buttons {
            grid-template-columns: 1fr !important;
        }

        .jam-table-custom tbody tr.jam-row-card {
            padding: 12px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Master Data — Jam Pelajaran</h1>
            <p>Kelola alokasi durasi jam pelajaran harian, waktu istirahat, dan urutan JP</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-regular fa-clock"></i>
        <span>Master Jam Pelajaran</span>
    </div>

    @if($errors->any())
        <div class="alert-custom alert-error" id="errorAlertBox">
            <div style="display:flex; align-items:flex-start; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px; margin-top:2px;"></i>
                <div>
                    <strong style="font-weight:800;">Pengisian data belum sesuai kriteria:</strong>
                    <ul style="margin: 4px 0 0 18px; padding:0;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Card 1: Form Tambah Jam Pelajaran Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Tambah Jam Pelajaran Baru</h2>
                <p>Masukkan rentang waktu resmi KBM (Senin-Kamis & Jumat) serta label sesi pembelajaran baru.</p>
            </div>
        </div>

        <form id="formTambahJam" action="{{ route('jam-pelajaran.store') }}" method="POST" onsubmit="return validateJamForm(event)">
            @csrf

            <!-- SECTION 1: Label Jam & Custom Input -->
            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:14px; padding:16px; margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                    <label for="jam_ke" style="font-size:14px; font-weight:800; color:#0f172a; margin:0;">
                        <i class="fa-solid fa-tag" style="color:#2563eb;"></i> 1. Label Jam & Sesi Pembelajaran <span style="color:#ef4444;">*</span>
                    </label>
                    <span id="auto_fill_badge" class="badge-time" style="display:none; background:#e0f2fe; color:#0369a1; border-color:#bae6fd; font-size:12px; font-weight:700;">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Data Ter-autofill Otomatis
                    </span>
                </div>

                <div class="form-section-label-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <select id="jam_ke" name="jam_ke" class="form-control @error('jam_ke') is-invalid @enderror @error('jam_ke_resolved') is-invalid @enderror" onchange="handleJamKeChange(this)" required>
                            <option value="" disabled {{ old('jam_ke') ? '' : 'selected' }}>-- Pilih Label Jam Sesi --</option>
                            @foreach(['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'] as $labelOpt)
                                <option value="{{ $labelOpt }}" {{ old('jam_ke') == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                            @endforeach
                            <option value="custom" {{ old('jam_ke') == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                        </select>

                        <div id="customJamKeWrapper" style="display: {{ old('jam_ke') == 'custom' ? 'block' : 'none' }}; margin-top: 8px;">
                            <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ old('jam_ke_custom') }}" class="form-control" placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                        </div>

                        @error('jam_ke')
                            <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                        @enderror
                        @error('jam_ke_resolved')
                            <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Hari Berlaku Sesi Ini:</label>
                        <div style="display:flex; align-items:center; gap:16px; margin-top:6px;">
                            <label style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#3b5490; cursor:pointer;">
                                <input type="checkbox" id="chk_senin_kamis" checked onchange="toggleSeninKamisFields(this.checked)" style="width:16px; height:16px; accent-color:#3b5490;">
                                <span>Senin – Kamis</span>
                            </label>
                            <label style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#2563eb; cursor:pointer;">
                                <input type="checkbox" id="chk_jumat" checked onchange="toggleJumatFields(this.checked)" style="width:16px; height:16px; accent-color:#2563eb;">
                                <span>Hari Jumat</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Grid Waktu Senin-Kamis & Waktu Jumat -->
            <div class="form-grid-times" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:18px; margin-bottom:18px;">
                
                <!-- Box Senin - Kamis -->
                <div id="box_senin_kamis" style="background:#ffffff; border:1.5px solid #3b5490; border-radius:14px; padding:16px; transition:all 0.2s ease;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #e2e8f0;">
                        <span style="font-size:13.5px; font-weight:800; color:#3b5490; display:flex; align-items:center; gap:6px;">
                            <i class="fa-regular fa-calendar-days"></i> Waktu Senin – Kamis
                        </span>
                        <span id="durasi_senin_kamis_badge" style="font-size:11.5px; font-weight:800; background:#f1f5f9; color:#3b5490; padding:2px 8px; border-radius:12px; border:1px solid #cbd5e1;">-</span>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai" style="font-size:12px; font-weight:700;">Waktu Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" class="form-control @error('jam_mulai') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_mulai')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai" style="font-size:12px; font-weight:700;">Waktu Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '07:35') }}" class="form-control @error('jam_selesai') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_selesai')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <small id="senin_kamis_note" style="display:block; margin-top:8px; font-size:11.5px; color:#64748b; font-style:italic;">* Kosongkan jika hari Senin-Kamis tidak ada sesi pembelajaran ini.</small>
                </div>

                <!-- Box Hari Jumat -->
                <div id="box_jumat" style="background:#ffffff; border:1.5px solid #2563eb; border-radius:14px; padding:16px; transition:all 0.2s ease;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #e2e8f0;">
                        <span style="font-size:13.5px; font-weight:800; color:#2563eb; display:flex; align-items:center; gap:6px;">
                            <i class="fa-regular fa-calendar-days"></i> Waktu Hari Jumat
                        </span>
                        <span id="durasi_jumat_badge" style="font-size:11.5px; font-weight:800; background:#e0f2fe; color:#0284c7; padding:2px 8px; border-radius:12px; border:1px solid #bae6fd;">-</span>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai_jumat" style="font-size:12px; font-weight:700; color:#1e40af;">Waktu Mulai Jumat</label>
                            <input type="time" id="jam_mulai_jumat" name="jam_mulai_jumat" value="{{ old('jam_mulai_jumat', '07:00') }}" class="form-control @error('jam_mulai_jumat') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_mulai_jumat')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai_jumat" style="font-size:12px; font-weight:700; color:#1e40af;">Waktu Selesai Jumat</label>
                            <input type="time" id="jam_selesai_jumat" name="jam_selesai_jumat" value="{{ old('jam_selesai_jumat', '07:30') }}" class="form-control @error('jam_selesai_jumat') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_selesai_jumat')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <small id="jumat_note" style="display:block; margin-top:8px; font-size:11.5px; color:#2563eb; font-style:italic;">* Sesuai alokasi resmi hari Jumat SMKN 1 Boyolangu.</small>
                </div>

            </div>

            <!-- SECTION 3: Keterangan & Quick Preset Pills -->
            <div class="form-group" style="margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; flex-wrap:wrap; gap:8px;">
                    <label for="keterangan" style="margin-bottom:0;"><i class="fa-solid fa-align-left"></i> Keterangan Sesi Pembelajaran (Opsional)</label>
                    <span style="font-size:11.5px; color:#64748b; font-weight:600;">Pilih templat cepat di bawah ini untuk auto-fill:</span>
                </div>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" class="form-control" placeholder="Contoh: Pembelajaran Reguler / Upacara / Sholat Dzuhur">
                
                <!-- Quick Preset Pills -->
                <div style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                    <button type="button" onclick="setKeterangan('Upacara / Apel (Senin) | Pembiasaan (Jumat)')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Upacara / Apel (Senin)</button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Pagi')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Sesi Pembelajaran Pagi</button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Siang')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Sesi Pembelajaran Siang</button>
                    <button type="button" onclick="setKeterangan('Istirahat 1 (20 Menit)')" style="font-size:11px; font-weight:700; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:4px 10px; border-radius:8px; cursor:pointer;">Istirahat 1</button>
                    <button type="button" onclick="setKeterangan('Istirahat 2 (ISHOMA / Sholat Jumat)')" style="font-size:11px; font-weight:700; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:4px 10px; border-radius:8px; cursor:pointer;">Istirahat 2 (ISHOMA)</button>
                </div>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="document.getElementById('formTambahJam').reset(); if(typeof calculateDurations==='function') calculateDurations();" class="btn-reset-form" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;" title="Kosongkan Isian Form">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jam Pelajaran
                </button>
            </div>
        </form>
    </div>

    <script>
        const jamPresets = {
            'Jam Ke-1': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara / Apel (Senin) | Pembiasaan (Jumat)' },
            'Jam Ke-2': { startSK: '07:40', endSK: '08:20', startFri: '07:30', endFri: '08:00', ket: 'Sesi Pembelajaran Pagi' },
            'Jam Ke-3': { startSK: '08:20', endSK: '09:00', startFri: '08:00', endFri: '08:30', ket: 'Sesi Pembelajaran Pagi' },
            'Jam Ke-4': { startSK: '09:00', endSK: '09:40', startFri: '08:30', endFri: '09:00', ket: 'Sesi Pembelajaran (Sebelum Istirahat 1 Senin-Kamis)' },
            'Istirahat 1': { startSK: '09:40', endSK: '10:00', startFri: '09:30', endFri: '09:50', ket: 'Istirahat 1 (20 Menit)' },
            'Jam Ke-5': { startSK: '10:00', endSK: '10:35', startFri: '09:00', endFri: '09:30', ket: 'Sesi Pembelajaran (Setelah Istirahat 1 Senin-Kamis / Sebelum Istirahat 1 Jumat)' },
            'Jam Ke-6': { startSK: '10:35', endSK: '11:10', startFri: '09:50', endFri: '10:20', ket: 'Sesi Pembelajaran Siang (Setelah Istirahat 1 Jumat)' },
            'Jam Ke-7': { startSK: '11:10', endSK: '11:45', startFri: '10:20', endFri: '10:50', ket: 'Sesi Pembelajaran Siang (Sebelum Istirahat 2 Senin-Kamis)' },
            'Istirahat 2': { startSK: '11:45', endSK: '13:15', startFri: '11:20', endFri: '13:00', ket: 'Istirahat 2 (ISHOMA / Sholat Jumat)' },
            'Jam Ke-8': { startSK: '13:15', endSK: '13:50', startFri: '10:50', endFri: '11:20', ket: 'Sesi Pembelajaran (Setelah ISHOMA Senin-Kamis / Sebelum Jumatan Jumat)' },
            'Jam Ke-9': { startSK: '13:50', endSK: '14:25', startFri: '13:00', endFri: '13:30', ket: 'Sesi Pembelajaran Sore (Setelah ISHOMA Jumat)' },
            'Jam Ke-10': { startSK: '14:25', endSK: '15:00', startFri: '13:30', endFri: '14:00', ket: 'Sesi Pembelajaran (Senin-Kamis Pulang pkl 15:00)' },
            'Jam Ke-11': { startSK: '', endSK: '', startFri: '14:00', endFri: '14:30', ket: 'Sesi Pembelajaran Khusus Jumat' },
            'Jam Ke-12': { startSK: '', endSK: '', startFri: '14:30', endFri: '15:00', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas XI Pulang pkl 15:00)' },
            'Jam Ke-13': { startSK: '', endSK: '', startFri: '15:00', endFri: '15:30', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas X Pulang pkl 15:30)' },
            'Upacara Bendera': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara Bendera Hari Senin' },
            'Pembiasaan Hari Jumat': { startSK: '', endSK: '', startFri: '07:00', endFri: '07:30', ket: 'Pembiasaan & Kedisiplinan Hari Jumat' },
        };

        function handleJamKeChange(selectElem) {
            const label = selectElem.value;
            const customWrapper = document.getElementById('customJamKeWrapper');
            const customInput = document.getElementById('jam_ke_custom');
            const autoBadge = document.getElementById('auto_fill_badge');

            if (label === 'custom') {
                customWrapper.style.display = 'block';
                customInput.setAttribute('required', 'required');
                customInput.focus();
                autoBadge.style.display = 'none';
            } else {
                customWrapper.style.display = 'none';
                customInput.removeAttribute('required');
                customInput.value = '';

                // Apply Preset Auto-Fill
                if (jamPresets[label]) {
                    const preset = jamPresets[label];
                    
                    // Senin-Kamis
                    const chkSK = document.getElementById('chk_senin_kamis');
                    if (preset.startSK && preset.endSK) {
                        chkSK.checked = true;
                        toggleSeninKamisFields(true);
                        document.getElementById('jam_mulai').value = preset.startSK;
                        document.getElementById('jam_selesai').value = preset.endSK;
                    } else {
                        chkSK.checked = false;
                        toggleSeninKamisFields(false);
                    }

                    // Jumat
                    const chkFri = document.getElementById('chk_jumat');
                    if (preset.startFri && preset.endFri) {
                        chkFri.checked = true;
                        toggleJumatFields(true);
                        document.getElementById('jam_mulai_jumat').value = preset.startFri;
                        document.getElementById('jam_selesai_jumat').value = preset.endFri;
                    } else {
                        chkFri.checked = false;
                        toggleJumatFields(false);
                    }

                    // Keterangan
                    if (preset.ket) {
                        document.getElementById('keterangan').value = preset.ket;
                    }

                    calculateDurations();
                    autoBadge.style.display = 'inline-flex';
                }
            }
        }

        function toggleSeninKamisFields(enabled) {
            const box = document.getElementById('box_senin_kamis');
            const inStart = document.getElementById('jam_mulai');
            const inEnd = document.getElementById('jam_selesai');

            if (enabled) {
                box.style.opacity = '1';
                box.style.pointerEvents = 'auto';
                inStart.disabled = false;
                inEnd.disabled = false;
            } else {
                box.style.opacity = '0.45';
                box.style.pointerEvents = 'none';
                inStart.disabled = true;
                inEnd.disabled = true;
                inStart.value = '';
                inEnd.value = '';
            }
            calculateDurations();
        }

        function toggleJumatFields(enabled) {
            const box = document.getElementById('box_jumat');
            const inStart = document.getElementById('jam_mulai_jumat');
            const inEnd = document.getElementById('jam_selesai_jumat');

            if (enabled) {
                box.style.opacity = '1';
                box.style.pointerEvents = 'auto';
                inStart.disabled = false;
                inEnd.disabled = false;
            } else {
                box.style.opacity = '0.45';
                box.style.pointerEvents = 'none';
                inStart.disabled = true;
                inEnd.disabled = true;
                inStart.value = '';
                inEnd.value = '';
            }
            calculateDurations();
        }

        function setKeterangan(text) {
            document.getElementById('keterangan').value = text;
        }

        function timeToMinutes(t) {
            if (!t) return 0;
            const [h, m] = t.split(':').map(Number);
            return (h * 60) + m;
        }

        function calculateDurations() {
            // Senin-Kamis
            const skMulai = document.getElementById('jam_mulai').value;
            const skSelesai = document.getElementById('jam_selesai').value;
            const badgeSK = document.getElementById('durasi_senin_kamis_badge');
            
            if (skMulai && skSelesai && skSelesai > skMulai) {
                const diff = timeToMinutes(skSelesai) - timeToMinutes(skMulai);
                badgeSK.textContent = diff + ' Menit';
                badgeSK.style.background = '#e0f2fe';
                badgeSK.style.color = '#0369a1';
            } else {
                badgeSK.textContent = '-';
                badgeSK.style.background = '#f1f5f9';
                badgeSK.style.color = '#64748b';
            }

            // Jumat
            const friMulai = document.getElementById('jam_mulai_jumat').value;
            const friSelesai = document.getElementById('jam_selesai_jumat').value;
            const badgeFri = document.getElementById('durasi_jumat_badge');

            if (friMulai && friSelesai && friSelesai > friMulai) {
                const diff = timeToMinutes(friSelesai) - timeToMinutes(friMulai);
                badgeFri.textContent = diff + ' Menit';
                badgeFri.style.background = '#e0f2fe';
                badgeFri.style.color = '#0369a1';
            } else {
                badgeFri.textContent = '-';
                badgeFri.style.background = '#f1f5f9';
                badgeFri.style.color = '#64748b';
            }
        }

        function validateJamForm(e) {
            const selectElem = document.getElementById('jam_ke');
            const jamKeVal = selectElem.value;
            const customVal = document.getElementById('jam_ke_custom').value.trim();
            const chkSK = document.getElementById('chk_senin_kamis').checked;
            const chkFri = document.getElementById('chk_jumat').checked;

            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;
            const jamMulaiJumat = document.getElementById('jam_mulai_jumat').value;
            const jamSelesaiJumat = document.getElementById('jam_selesai_jumat').value;

            let errors = [];
            if (!jamKeVal) {
                errors.push('Label Jam Sesi wajib dipilih!');
            } else if (jamKeVal === 'custom' && !customVal) {
                errors.push('Label Jam Khusus wajib diisi!');
            }

            if (!chkSK && !chkFri) {
                errors.push('Pilih minimal satu kategori hari (Senin-Kamis atau Hari Jumat) yang berlaku untuk sesi ini!');
            }

            if (chkSK) {
                if (!jamMulai) errors.push('Waktu Mulai Senin-Kamis wajib diisi!');
                if (!jamSelesai) errors.push('Waktu Selesai Senin-Kamis wajib diisi!');
                if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                    errors.push('Waktu Selesai Senin-Kamis (' + jamSelesai + ') harus lebih akhir daripada Waktu Mulai (' + jamMulai + ')!');
                }
            }

            if (chkFri) {
                if (!jamMulaiJumat) errors.push('Waktu Mulai Hari Jumat wajib diisi!');
                if (!jamSelesaiJumat) errors.push('Waktu Selesai Hari Jumat wajib diisi!');
                if (jamMulaiJumat && jamSelesaiJumat && jamSelesaiJumat <= jamMulaiJumat) {
                    errors.push('Waktu Selesai Hari Jumat (' + jamSelesaiJumat + ') harus lebih akhir daripada Waktu Mulai Hari Jumat (' + jamMulaiJumat + ')!');
                }
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ PERINGATAN VALIDASI DATA JAM PELAJARAN:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                return false;
            }
            return true;
        }

        // Initialize duration calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateDurations();
        });
    </script>

    <!-- Card 2: Daftar Sesi Jam Pelajaran -->
    <div class="card" id="daftarJamCard">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-regular fa-clock" style="color:#3b5490;"></i> Daftar Sesi Jam Pelajaran ({{ count($jamList) }})</h2>
            </div>
        </div>

        {{-- Banner Pemberitahuan Status Libur Aktif --}}
        @if(isset($holidayInfoToday) && $holidayInfoToday['is_holiday'])
            <div class="holiday-alert-banner">
                <div class="holiday-alert-left">
                    <div class="holiday-alert-icon">
                        <i class="fa-solid fa-umbrella-beach"></i>
                    </div>
                    <div>
                        <div class="holiday-alert-badge">
                            <span class="pulse-indicator"></span> STATUS SISTEM: HARI LIBUR SEKOLAH AKTIF
                        </div>
                        <h4 class="holiday-alert-title" style="margin-bottom:0;">{{ $holidayInfoToday['title'] }}: {{ $holidayInfoToday['keterangan'] }}</h4>
                    </div>
                </div>
                <div class="holiday-alert-actions">
                    <button type="button" class="btn-banner-manage-holiday" onclick="openHolidayModal()">
                        <i class="fa-solid fa-calendar-days"></i> Kelola Hari Libur
                    </button>
                </div>
            </div>
        @endif

        <form action="{{ route('jam-pelajaran.index') }}" method="GET" class="jam-filter-form" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #cbd5e1;">
            <div class="jam-filter-search-box" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative; width:100%;">
                    <i class="fa-solid fa-magnifying-glass search-icon-inside" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; z-index:2;"></i>
                    <input type="text" name="search" class="form-control search-input-control" style="width: 240px; padding-left:38px !important; background:#ffffff;" value="{{ $search ?? '' }}" placeholder="Cari Jam / Waktu / Keterangan..">
                </div>
            </div>

            <div class="jam-filter-buttons" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-reset">Reset</a>
                <button type="button" class="btn-reset-schedule" onclick="confirmResetSchedule()" title="Kembalikan semua jam pelajaran ke jadwal normal/standar resmi sekolah">
                    <i class="fa-solid fa-rotate-left"></i> Reset Jadwal Normal
                </button>
                <button type="button" class="btn-set-holiday" onclick="openHolidayModal()" title="Jadwalkan Hari Libur Sekolah (Tanggal Merah, Cuti, Libur Semester)">
                    <i class="fa-solid fa-calendar-xmark"></i> Set Hari Libur
                    @if(isset($hariLiburList) && $hariLiburList->where('is_active', true)->count() > 0)
                        <span class="badge-holiday-count">{{ $hariLiburList->where('is_active', true)->count() }}</span>
                    @endif
                </button>
                <a href="{{ route('jam-pelajaran.trash') }}" class="btn-trash" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;" title="Lihat Data Jam Pelajaran di Tempat Sampah">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih sesi jam pelajaran dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                </button>
            </div>
        </form>

        <!-- Mobile Select All Bar -->
        <div class="mobile-select-all-bar">
            <label for="selectAllJamPelajaranMobile">
                <input type="checkbox" id="selectAllJamPelajaranMobile">
                <span>Pilih Semua Sesi Jam Terdaftar</span>
            </label>
            <span style="font-size: 12px; font-weight: 700; color: #64748b;">
                Total: {{ count($jamList) }} Sesi
            </span>
        </div>

        <form id="formBulkDelete" action="{{ route('jam-pelajaran.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive jam-table-wrapper">
                <table class="table-custom jam-table-custom" id="tableDaftarJam">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllJamPelajaran" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th style="width: 50px;">NO</th>
                            <th>JAM KE-</th>
                            <th>SENIN - KAMIS</th>
                            <th>HARI JUMAT</th>
                            <th>KETERANGAN</th>
                            <th style="text-align:center; min-width: 240px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jamList as $idx => $item)
                            <tr class="jam-row-card">
                                <td class="col-checkbox" style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id_jam }}" class="jam-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td class="col-no"><strong class="no-text">{{ $idx + 1 }}</strong></td>
                                <td class="col-jam"><strong style="color:#0f172a; font-size:14px;">{{ $item->jam_ke }}</strong></td>
                                <td class="col-sk" id="sk-cell-{{ $item->id_jam }}">
                                    <div class="mobile-time-wrapper">
                                        <span class="mobile-label-text"><i class="fa-regular fa-calendar-days"></i> Senin – Kamis:</span>
                                        @if($item->jam_mulai_default && $item->jam_selesai_default)
                                            @php
                                                $isHolidayActiveToday = ($holidayInfoToday['is_holiday'] ?? false);
                                            @endphp
                                            <div class="jam-switch-control">
                                                <label class="switch-toggle-custom" title="{{ $isHolidayActiveToday ? 'Otomatis Nonaktif (Mati): Hari ini merupakan ' . ($holidayInfoToday['title'] ?? 'Libur Sekolah') . ' (' . ($holidayInfoToday['keterangan'] ?? '') . ')' : 'Sakelar On/Off: Nonaktifkan untuk memajukan jam pelajaran berikutnya pada hari Senin-Kamis' }}">
                                                    <input type="checkbox" class="toggle-jam-sk" data-id="{{ $item->id_jam }}" data-day="senin_kamis" {{ (!$isHolidayActiveToday && $item->is_active_senin_kamis) ? 'checked' : '' }} {{ $isHolidayActiveToday ? 'disabled' : '' }} onchange="handleToggleJam(this)">
                                                    <span class="switch-slider"></span>
                                                </label>
                                                <div class="jam-time-badge-wrap" id="sk-badge-wrap-{{ $item->id_jam }}">
                                                    @if($isHolidayActiveToday)
                                                        <span class="badge-time badge-time-inactive" style="background:#fff1f2; color:#e11d48; border-color:#fecdd3;" title="Otomatis Nonaktif karena {{ $holidayInfoToday['title'] ?? 'Libur' }} ({{ $holidayInfoToday['keterangan'] ?? '' }})">
                                                            <i class="fa-solid fa-power-off"></i> Nonaktif (Libur)
                                                        </span>
                                                    @elseif($item->is_active_senin_kamis && $item->waktu_senin_kamis !== '-')
                                                        <span class="badge-time {{ $item->is_shifted_senin_kamis ? 'badge-time-shifted' : '' }}" style="background:{{ $item->is_shifted_senin_kamis ? '#fffbeb' : '#f1f5f9' }}; color:{{ $item->is_shifted_senin_kamis ? '#b45309' : '#1e293b' }}; border-color:{{ $item->is_shifted_senin_kamis ? '#f59e0b' : '#cbd5e1' }};">
                                                            <i class="fa-regular fa-clock"></i> {{ $item->waktu_senin_kamis }} WIB
                                                        </span>
                                                        @if($item->is_shifted_senin_kamis)
                                                            <span class="badge-maju-pill" title="Maju dari jadwal normal {{ $item->waktu_senin_kamis_default }}"><i class="fa-solid fa-forward-step"></i> Maju</span>
                                                        @endif
                                                    @else
                                                        <span class="badge-time badge-time-inactive">
                                                            <i class="fa-solid fa-power-off"></i> Nonaktif
                                                        </span>
                                                        <span class="badge-maju-pill" style="background:#f1f5f9; color:#64748b; border-color:#cbd5e1;"><i class="fa-solid fa-angles-right"></i> Maju 1 JP</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span style="color:#94a3b8; font-style:italic; font-size:12px;">- (Selesai pkl 15:00)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="col-jumat" id="jumat-cell-{{ $item->id_jam }}">
                                    <div class="mobile-time-wrapper">
                                        <span class="mobile-label-text"><i class="fa-regular fa-calendar-days" style="color:#2563eb;"></i> Hari Jumat:</span>
                                        @if($item->jam_mulai_jumat_default && $item->jam_selesai_jumat_default)
                                            @php
                                                $isHolidayActiveToday = ($holidayInfoToday['is_holiday'] ?? false);
                                            @endphp
                                            <div class="jam-switch-control">
                                                <label class="switch-toggle-custom" title="{{ $isHolidayActiveToday ? 'Otomatis Nonaktif (Mati): Hari ini merupakan ' . ($holidayInfoToday['title'] ?? 'Libur Sekolah') . ' (' . ($holidayInfoToday['keterangan'] ?? '') . ')' : 'Sakelar On/Off: Nonaktifkan untuk memajukan jam pelajaran berikutnya pada hari Jumat' }}">
                                                    <input type="checkbox" class="toggle-jam-jumat" data-id="{{ $item->id_jam }}" data-day="jumat" {{ (!$isHolidayActiveToday && $item->is_active_jumat) ? 'checked' : '' }} {{ $isHolidayActiveToday ? 'disabled' : '' }} onchange="handleToggleJam(this)">
                                                    <span class="switch-slider"></span>
                                                </label>
                                                <div class="jam-time-badge-wrap" id="jumat-badge-wrap-{{ $item->id_jam }}">
                                                    @if($isHolidayActiveToday)
                                                        <span class="badge-time badge-time-inactive" style="background:#fff1f2; color:#e11d48; border-color:#fecdd3;" title="Otomatis Nonaktif karena {{ $holidayInfoToday['title'] ?? 'Libur' }} ({{ $holidayInfoToday['keterangan'] ?? '' }})">
                                                            <i class="fa-solid fa-power-off"></i> Nonaktif (Libur)
                                                        </span>
                                                    @elseif($item->is_active_jumat && $item->waktu_jumat !== '-')
                                                        <span class="badge-time {{ $item->is_shifted_jumat ? 'badge-time-shifted' : '' }}" style="background:{{ $item->is_shifted_jumat ? '#fffbeb' : '#eff6ff' }}; color:{{ $item->is_shifted_jumat ? '#b45309' : '#1d4ed8' }}; border-color:{{ $item->is_shifted_jumat ? '#f59e0b' : '#bfdbfe' }};">
                                                            <i class="fa-regular fa-clock"></i> {{ $item->waktu_jumat }} WIB
                                                        </span>
                                                        @if($item->is_shifted_jumat)
                                                            <span class="badge-maju-pill" title="Maju dari jadwal normal {{ $item->waktu_jumat_default }}"><i class="fa-solid fa-forward-step"></i> Maju</span>
                                                        @endif
                                                    @else
                                                        <span class="badge-time badge-time-inactive">
                                                            <i class="fa-solid fa-power-off"></i> Nonaktif
                                                        </span>
                                                        <span class="badge-maju-pill" style="background:#f1f5f9; color:#64748b; border-color:#cbd5e1;"><i class="fa-solid fa-angles-right"></i> Maju 1 JP</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span style="color:#94a3b8; font-style:italic; font-size:12px;">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="col-ket {{ empty($item->keterangan) ? 'col-ket-empty' : '' }}">
                                    @if($item->keterangan)
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <span class="mobile-label-text"><i class="fa-solid fa-align-left"></i> Ket:</span>
                                            <span style="background:#f8fafc; color:#334155; padding:6px 12px; border-radius:8px; font-weight:600; font-size:12.5px; display:inline-block; border:1px solid #e2e8f0;">
                                                {{ $item->keterangan }}
                                            </span>
                                        </div>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">-</span>
                                    @endif
                                </td>
                                <td class="col-aksi" style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT DETAIL - Disebelah kiri Edit & Hapus -->
                                        <a href="{{ route('jam-pelajaran.show', $item->id_jam) }}" class="btn-action btn-view" title="Lihat Detail Sesi Jam">
                                            <i class="fa-solid fa-eye"></i> Lihat Detail
                                        </a>

                                        <!-- 2. EDIT - Disebelah kiri Hapus (Hanya bisa diedit saat tombol Edit diklik!) -->
                                        <a href="{{ route('jam-pelajaran.edit', $item->id_jam) }}" class="btn-action btn-edit" title="Edit Data Jam Pelajaran">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="if(confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($item->jam_ke) }} ke tempat sampah?')) { document.getElementById('singleDeleteForm-{{ $item->id_jam }}').submit(); }" title="Hapus Jam Pelajaran">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-regular fa-clock" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Master Jam Pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Mobile Pagination Container -->
        @if(count($jamList) > 0)
            <div id="jamMobilePaginationContainer" class="mobile-pagination-wrapper">
                <div class="custom-pagination-bar">
                    <div class="pagination-info" id="jamMobilePaginationInfo">
                        Menampilkan <strong style="color: #0f172a;">1</strong> – <strong style="color: #0f172a;">{{ min(8, count($jamList)) }}</strong> dari <strong style="color: #0f172a;">{{ number_format(count($jamList), 0, ',', '.') }}</strong> Data
                    </div>
                    <ul class="pagination-list" id="jamMobilePaginationList">
                        <!-- Dynamic via JS -->
                    </ul>
                </div>
            </div>
        @endif

        @foreach($jamList as $item)
            <form id="singleDeleteForm-{{ $item->id_jam }}" action="{{ route('jam-pelajaran.destroy', $item->id_jam) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    </div>

    <!-- Modal Confirm Bulk Delete -->
    <div class="modal-bg" id="modalConfirmBulkDelete">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3>Konfirmasi Hapus Terpilih</h3>
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 data sesi jam pelajaran</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        let currentJamMobilePage = 1;
        const jamItemsPerPage = 8;

        function isMobileJamScreen() {
            return window.matchMedia('(max-width: 768px)').matches;
        }

        function goToMobileJamPage(page) {
            renderMobileJamPage(page);
            const card = document.getElementById('daftarJamCard');
            if (card) {
                card.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function renderMobileJamPage(page = 1) {
            const rows = document.querySelectorAll('#tableDaftarJam tbody tr.jam-row-card');
            const infoEl = document.getElementById('jamMobilePaginationInfo');
            const listEl = document.getElementById('jamMobilePaginationList');

            if (!isMobileJamScreen()) {
                rows.forEach(row => {
                    row.classList.remove('mobile-page-hidden');
                    row.style.removeProperty('display');
                });
                if (listEl) listEl.innerHTML = '';
                return;
            }

            const totalItems = rows.length;
            const totalPages = Math.ceil(totalItems / jamItemsPerPage) || 1;

            if (page < 1) page = 1;
            if (page > totalPages) page = totalPages;
            currentJamMobilePage = page;

            const startIdx = (page - 1) * jamItemsPerPage;
            const endIdx = startIdx + jamItemsPerPage;

            rows.forEach((row, i) => {
                if (i >= startIdx && i < endIdx) {
                    row.classList.remove('mobile-page-hidden');
                    row.style.removeProperty('display');
                } else {
                    row.classList.add('mobile-page-hidden');
                    row.style.setProperty('display', 'none', 'important');
                }
            });

            const startNum = totalItems === 0 ? 0 : startIdx + 1;
            const endNum = Math.min(endIdx, totalItems);

            if (infoEl) {
                infoEl.innerHTML = `Menampilkan <strong style="color: #0f172a;">${startNum}</strong> – <strong style="color: #0f172a;">${endNum}</strong> dari <strong style="color: #0f172a;">${totalItems.toLocaleString('id-ID')}</strong> Data`;
            }

            if (listEl) {
                renderMobileJamPaginationButtons(listEl, totalPages, currentJamMobilePage);
            }
        }

        function renderMobileJamPaginationButtons(listEl, totalPages, page) {
            if (totalPages <= 1) {
                listEl.innerHTML = '';
                return;
            }

            let html = '';

            if (page === 1) {
                html += `<li class="page-item disabled"><span class="page-link">&laquo;</span></li>`;
            } else {
                html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${page - 1})" rel="prev">&laquo;</a></li>`;
            }

            if (totalPages <= 8) {
                for (let i = 1; i <= totalPages; i++) {
                    if (i === page) {
                        html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                    } else {
                        html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${i})">${i}</a></li>`;
                    }
                }
            } else {
                if (page <= 5) {
                    for (let i = 1; i <= 8; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${i})">${i}</a></li>`;
                        }
                    }
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${totalPages})">${totalPages}</a></li>`;
                } else if (page > totalPages - 5) {
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(1)">1</a></li>`;
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    for (let i = totalPages - 7; i <= totalPages; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${i})">${i}</a></li>`;
                        }
                    }
                } else {
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(1)">1</a></li>`;
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    for (let i = page - 2; i <= page + 2; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${i})">${i}</a></li>`;
                        }
                    }
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${totalPages})">${totalPages}</a></li>`;
                }
            }

            if (page === totalPages) {
                html += `<li class="page-item disabled"><span class="page-link">&raquo;</span></li>`;
            } else {
                html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJamPage(${page + 1})" rel="next">&raquo;</a></li>`;
            }

            listEl.innerHTML = html;
        }

        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.jam-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllJamPelajaran');
            const selectAllMobile = document.getElementById('selectAllJamPelajaranMobile');

            if (countSpan) countSpan.textContent = count;

            if (selectAll && totalBoxes.length > 0) {
                selectAll.checked = (checkedBoxes.length === totalBoxes.length);
            }
            if (selectAllMobile && totalBoxes.length > 0) {
                selectAllMobile.checked = (checkedBoxes.length === totalBoxes.length);
            }

            if (btnBulkDelete) {
                if (count > 0) {
                    btnBulkDelete.disabled = false;
                    btnBulkDelete.style.opacity = '1';
                    btnBulkDelete.style.cursor = 'pointer';
                } else {
                    btnBulkDelete.disabled = true;
                    btnBulkDelete.style.opacity = '0.5';
                    btnBulkDelete.style.cursor = 'not-allowed';
                }
            }
        }

        function confirmBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
            const count = checkedBoxes.length;

            if (count === 0) {
                alert('Silakan pilih minimal 1 data sesi jam pelajaran yang ingin dihapus dengan mencentang kotak centang (checkbox).');
                return;
            }

            const modalCountText = document.getElementById('modalBulkCountText');
            if (modalCountText) {
                modalCountText.textContent = count + ' data sesi jam pelajaran';
            }

            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) {
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data sesi jam pelajaran yang dipilih ke Tempat Sampah?`)) {
                    document.getElementById('formBulkDelete').submit();
                }
            }
        }

        function closeBulkDeleteModal() {
            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) modal.classList.remove('active');
        }

        function submitBulkDelete() {
            document.getElementById('formBulkDelete').submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const selectAll = document.getElementById('selectAllJamPelajaran');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.jam-select-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkDeleteState();
                });
            }

            const selectAllMobile = document.getElementById('selectAllJamPelajaranMobile');
            if (selectAllMobile) {
                selectAllMobile.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.jam-select-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAllMobile.checked);
                    updateBulkDeleteState();
                });
            }

            const modalBulk = document.getElementById('modalConfirmBulkDelete');
            if (modalBulk) {
                modalBulk.addEventListener('click', function(e) {
                    if (e.target === this) closeBulkDeleteModal();
                });
            }

            // Inisialisasi Mobile Pagination
            renderMobileJamPage(1);

            let jamResizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(jamResizeTimer);
                jamResizeTimer = setTimeout(function() {
                    renderMobileJamPage(currentJamMobilePage);
                }, 150);
            });
        });

        /* ========================================================
           LOGIKA TOGGLE SAKELAR & RESET MAJU JAM PELAJARAN
           ======================================================== */
        function handleToggleJam(inputElem) {
            const idJam   = inputElem.getAttribute('data-id');
            const dayType = inputElem.getAttribute('data-day');
            const isActive = inputElem.checked ? 1 : 0;

            inputElem.disabled = true;

            fetch('{{ route("jam-pelajaran.toggle-active") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id_jam: idJam,
                    day_type: dayType,
                    is_active: isActive
                })
            })
            .then(res => res.json())
            .then(data => {
                inputElem.disabled = false;
                if (data.success) {
                    updateTableScheduleDOM(data.data);
                    showToastNotification(data.message, 'success');
                } else {
                    inputElem.checked = !inputElem.checked;
                    showToastNotification(data.message || 'Gagal mengubah status jam pelajaran.', 'error');
                }
            })
            .catch(err => {
                inputElem.disabled = false;
                inputElem.checked = !inputElem.checked;
                console.error(err);
                showToastNotification('Terjadi kesalahan sambungan server saat mengubah sakelar.', 'error');
            });
        }

        function updateTableScheduleDOM(dataList) {
            if (!Array.isArray(dataList)) return;

            dataList.forEach(item => {
                // 1. Update Senin-Kamis
                const skWrap = document.getElementById(`sk-badge-wrap-${item.id_jam}`);
                const skInput = document.querySelector(`.toggle-jam-sk[data-id="${item.id_jam}"]`);
                if (skInput) {
                    skInput.checked = !!item.is_active_senin_kamis;
                }
                if (skWrap) {
                    if (item.is_active_senin_kamis && item.waktu_senin_kamis && item.waktu_senin_kamis !== '-') {
                        const shiftedClass = item.is_shifted_senin_kamis ? 'badge-time-shifted' : '';
                        const bgCol = item.is_shifted_senin_kamis ? '#fffbeb' : '#f1f5f9';
                        const textCol = item.is_shifted_senin_kamis ? '#b45309' : '#1e293b';
                        const borderCol = item.is_shifted_senin_kamis ? '#f59e0b' : '#cbd5e1';
                        const majuBadge = item.is_shifted_senin_kamis ? `<span class="badge-maju-pill" title="Jam pelajaran maju"><i class="fa-solid fa-forward-step"></i> Maju</span>` : '';
                        
                        skWrap.innerHTML = `
                            <span class="badge-time ${shiftedClass}" style="background:${bgCol}; color:${textCol}; border-color:${borderCol};">
                                <i class="fa-regular fa-clock"></i> ${item.waktu_senin_kamis} WIB
                            </span>
                            ${majuBadge}
                        `;
                    } else {
                        skWrap.innerHTML = `
                            <span class="badge-time badge-time-inactive">
                                <i class="fa-solid fa-power-off"></i> Nonaktif
                            </span>
                            <span class="badge-maju-pill" style="background:#f1f5f9; color:#64748b; border-color:#cbd5e1;"><i class="fa-solid fa-angles-right"></i> Maju 1 JP</span>
                        `;
                    }
                }

                // 2. Update Jumat
                const jumatWrap = document.getElementById(`jumat-badge-wrap-${item.id_jam}`);
                const jumatInput = document.querySelector(`.toggle-jam-jumat[data-id="${item.id_jam}"]`);
                if (jumatInput) {
                    jumatInput.checked = !!item.is_active_jumat;
                }
                if (jumatWrap) {
                    if (item.is_active_jumat && item.waktu_jumat && item.waktu_jumat !== '-') {
                        const shiftedClass = item.is_shifted_jumat ? 'badge-time-shifted' : '';
                        const bgCol = item.is_shifted_jumat ? '#fffbeb' : '#eff6ff';
                        const textCol = item.is_shifted_jumat ? '#b45309' : '#1d4ed8';
                        const borderCol = item.is_shifted_jumat ? '#f59e0b' : '#bfdbfe';
                        const majuBadge = item.is_shifted_jumat ? `<span class="badge-maju-pill" title="Jam pelajaran maju"><i class="fa-solid fa-forward-step"></i> Maju</span>` : '';
                        
                        jumatWrap.innerHTML = `
                            <span class="badge-time ${shiftedClass}" style="background:${bgCol}; color:${textCol}; border-color:${borderCol};">
                                <i class="fa-regular fa-clock"></i> ${item.waktu_jumat} WIB
                            </span>
                            ${majuBadge}
                        `;
                    } else {
                        jumatWrap.innerHTML = `
                            <span class="badge-time badge-time-inactive">
                                <i class="fa-solid fa-power-off"></i> Nonaktif
                            </span>
                            <span class="badge-maju-pill" style="background:#f1f5f9; color:#64748b; border-color:#cbd5e1;"><i class="fa-solid fa-angles-right"></i> Maju 1 JP</span>
                        `;
                    }
                }
            });
        }

        function confirmResetSchedule() {
            if (confirm('Apakah Anda yakin ingin mengembalikan seluruh jadwal jam pelajaran ke jadwal normal/standar resmi sekolah?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("jam-pelajaran.reset-default") }}';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function showToastNotification(message, type = 'success') {
            let container = document.getElementById('jamToastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'jamToastContainer';
                container.className = 'jam-toast-box';
                document.body.appendChild(container);
            }

            const item = document.createElement('div');
            item.className = `jam-toast-item toast-${type}`;
            const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
            const iconColor = type === 'success' ? '#22c55e' : '#ef4444';
            item.innerHTML = `
                <i class="fa-solid ${icon}" style="color:${iconColor}; font-size:18px;"></i>
                <div style="flex:1;">${message}</div>
            `;
            container.appendChild(item);

            setTimeout(() => {
                item.style.transition = 'all 0.4s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateY(15px)';
                setTimeout(() => item.remove(), 400);
            }, 3500);
        }

        // ==========================================
        // FITUR SET HARI LIBUR SEKOLAH (ADMIN TU)
        // ==========================================
        let holidayRowIndex = 1;

        function openHolidayModal() {
            const backdrop = document.getElementById('holidayModalBackdrop');
            if (backdrop) {
                backdrop.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeHolidayModal() {
            const backdrop = document.getElementById('holidayModalBackdrop');
            if (backdrop) {
                backdrop.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        function handleBackdropClick(e) {
            if (e.target && e.target.id === 'holidayModalBackdrop') {
                closeHolidayModal();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const backdrop = document.getElementById('holidayModalBackdrop');
                if (backdrop && backdrop.style.display === 'flex') {
                    closeHolidayModal();
                }
            }
        });

        function handleDateChange(input) {
            const row = input.closest('.holiday-input-row');
            if (!row) return;

            const startInput = row.querySelector('.input-tgl-mulai');
            const endInput   = row.querySelector('.input-tgl-selesai');

            if (startInput && startInput.value) {
                endInput.min = startInput.value;
                if (endInput.value && endInput.value < startInput.value) {
                    endInput.value = startInput.value;
                }
            }
        }

        function addHolidayRow() {
            const container = document.getElementById('holidayRowsContainer');
            const rows = container.querySelectorAll('.holiday-input-row');
            const newIdx = holidayRowIndex++;

            const newRow = document.createElement('div');
            newRow.className = 'holiday-input-row';
            newRow.dataset.rowIndex = newIdx;
            newRow.innerHTML = `
                <div class="row-num-badge">#${rows.length + 1}</div>
                <div class="form-group-field" style="flex: 1.2;">
                    <label class="field-label">Tanggal Mulai <span class="required-star">*</span></label>
                    <input type="date" name="holidays[${newIdx}][tanggal_mulai]" class="holiday-input input-tgl-mulai" required onchange="handleDateChange(this)">
                </div>
                <div class="form-group-field" style="flex: 1.2;">
                    <label class="field-label">Tanggal Selesai <span class="required-star">*</span></label>
                    <input type="date" name="holidays[${newIdx}][tanggal_selesai]" class="holiday-input input-tgl-selesai" required onchange="handleDateChange(this)">
                </div>
                <div class="form-group-field" style="flex: 2.2;">
                    <label class="field-label">Keterangan / Nama Libur <span class="required-star">*</span></label>
                    <input type="text" name="holidays[${newIdx}][keterangan]" class="holiday-input input-keterangan" placeholder="Contoh: Cuti Bersama / Libur KBM" required maxlength="255">
                </div>
                <div class="row-actions">
                    <label class="field-label" style="visibility:hidden;">Hapus</label>
                    <button type="button" class="btn-remove-row" onclick="removeHolidayRow(this)" title="Hapus Baris Ini">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            `;

            container.appendChild(newRow);
            updateRowBadgesAndButtons();
        }

        function removeHolidayRow(btn) {
            const row = btn.closest('.holiday-input-row');
            const container = document.getElementById('holidayRowsContainer');
            if (container.querySelectorAll('.holiday-input-row').length > 1) {
                row.remove();
                updateRowBadgesAndButtons();
            }
        }

        function updateRowBadgesAndButtons() {
            const container = document.getElementById('holidayRowsContainer');
            const rows = container.querySelectorAll('.holiday-input-row');
            rows.forEach((r, i) => {
                const badge = r.querySelector('.row-num-badge');
                if (badge) badge.textContent = `#${i + 1}`;
                const removeBtn = r.querySelector('.btn-remove-row');
                if (removeBtn) {
                    removeBtn.disabled = (rows.length === 1);
                }
            });
        }

        function resetHolidayForm() {
            const container = document.getElementById('holidayRowsContainer');
            const rows = container.querySelectorAll('.holiday-input-row');
            for (let i = 1; i < rows.length; i++) {
                rows[i].remove();
            }
            updateRowBadgesAndButtons();
        }

        async function handleHolidayBatchSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('formStoreHolidayBatch');
            const btnSubmit = document.getElementById('btnSubmitHolidayBatch');
            const originalBtnHtml = btnSubmit.innerHTML;

            // Client-side validation
            const rows = form.querySelectorAll('.holiday-input-row');
            const errors = [];

            rows.forEach((r, idx) => {
                const start = r.querySelector('.input-tgl-mulai').value;
                const end   = r.querySelector('.input-tgl-selesai').value;
                const ket   = r.querySelector('.input-keterangan').value.trim();
                const num   = idx + 1;

                if (!start) errors.push(`Baris #${num}: Tanggal mulai wajib diisi.`);
                if (!end) errors.push(`Baris #${num}: Tanggal selesai wajib diisi.`);
                if (start && end && end < start) {
                    errors.push(`Baris #${num}: Tanggal selesai tidak boleh lebih awal dari tanggal mulai.`);
                }
                if (!ket) errors.push(`Baris #${num}: Keterangan hari libur wajib diisi.`);
            });

            if (errors.length > 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Input Libur',
                        html: `<div style="text-align:left; font-size:13px; color:#991b1b;">${errors.map(e => `• ${e}`).join('<br>')}</div>`,
                        confirmButtonColor: '#f59e0b'
                    });
                } else {
                    alert('⚠️ PERINGATAN VALIDASI HARI LIBUR:\n\n' + errors.join('\n'));
                }
                return;
            }

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...`;

            try {
                const formData = new FormData(form);
                const response = await fetch('{{ route("jam-pelajaran.hari-libur.store-batch") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const res = await response.json();

                if (response.ok && res.success) {
                    form.reset();
                    resetHolidayForm();
                    if (res.data) {
                        renderHolidayTable(res.data.holidays, res.data.today_info);
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Disimpan!',
                            text: res.message || 'Jadwal hari libur berhasil disimpan.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        showToastNotification(res.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    const errMsg = res.message || (res.errors ? Object.values(res.errors).flat().join('\n') : 'Gagal menyimpan jadwal libur.');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            text: errMsg,
                            confirmButtonColor: '#ef4444'
                        });
                    } else {
                        alert('⚠️ GAGAL MENYIMPAN:\n\n' + errMsg);
                    }
                }
            } catch (err) {
                console.error(err);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Sistem / Jaringan',
                        text: 'Terjadi kesalahan saat menghubungi server untuk menyimpan data.',
                        confirmButtonColor: '#ef4444'
                    });
                } else {
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalBtnHtml;
            }
        }

        async function toggleHolidayStatus(id, targetStatus) {
            const isActivating = targetStatus === true || targetStatus === 1 || targetStatus === 'true';
            const title = isActivating ? 'Aktifkan Kembali Hari Libur?' : 'Batalkan Hari Libur?';
            const htmlText = isActivating
                ? 'Jadwal hari libur ini akan <b>diaktifkan kembali</b>. Sistem KBM & Jurnal Mengajar pada rentang tanggal tersebut akan diliburkan secara otomatis.'
                : 'Status hari libur ini akan <b>dibatalkan (dinonaktifkan)</b>. Sistem KBM & Jurnal Mengajar pada rentang tanggal tersebut akan kembali normal.';
            const confirmBtnText = isActivating ? '<i class="fa-solid fa-check"></i> Ya, Aktifkan Libur' : '<i class="fa-solid fa-ban"></i> Ya, Batalkan Libur';
            const confirmBtnColor = isActivating ? '#10b981' : '#f59e0b';

            if (typeof Swal !== 'undefined') {
                const result = await Swal.fire({
                    title: title,
                    html: `<div style="font-size:13.5px; color:#334155; line-height:1.5;">${htmlText}</div>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: confirmBtnColor,
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Batal',
                    reverseButtons: false
                });

                if (!result.isConfirmed) {
                    return;
                }
            } else {
                const actionText = isActivating ? 'mengaktifkan kembali' : 'menonaktifkan (membatalkan)';
                if (!confirm(`Apakah Anda yakin ingin ${actionText} jadwal hari libur ini?`)) {
                    return;
                }
            }

            try {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Memproses Status Libur...',
                        html: 'Sedang memperbarui status hari libur sekolah...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                const response = await fetch(`{{ url('/jam-pelajaran/hari-libur') }}/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const res = await response.json();
                if (response.ok && res.success) {
                    if (res.data) {
                        renderHolidayTable(res.data.holidays, res.data.today_info);
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Berhasil Diperbarui',
                            text: res.message || 'Status jadwal libur berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        showToastNotification(res.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const errorMsg = res.message || 'Terjadi kesalahan saat memproses perubahan status.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengubah Status',
                            text: errorMsg,
                            confirmButtonColor: '#ef4444'
                        });
                    } else {
                        alert('Gagal mengubah status: ' + errorMsg);
                    }
                }
            } catch (err) {
                console.error(err);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Jaringan',
                        text: 'Terjadi kesalahan saat menghubungi server untuk mengubah status libur.',
                        confirmButtonColor: '#ef4444'
                    });
                } else {
                    alert('Terjadi kesalahan jaringan saat mengubah status libur.');
                }
            }
        }

        async function deleteHoliday(id, name) {
            const rowElem = document.getElementById(`holiday-row-${id}`);
            const cleanName = name || (rowElem ? rowElem.querySelector('.h-keterangan-title')?.textContent?.trim() : '') || 'Hari Libur';

            if (typeof Swal !== 'undefined') {
                const result = await Swal.fire({
                    title: 'Hapus Jadwal Hari Libur?',
                    html: `<div style="font-size:13.5px; color:#334155; line-height:1.5;">Apakah Anda yakin ingin menghapus jadwal libur <b>"${escapeHtml(cleanName)}"</b>?<br><small style="color:#ef4444; font-weight:600;">Data yang dihapus akan dikeluarkan secara permanen dari daftar libur sekolah.</small></div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Ya, Hapus Libur',
                    cancelButtonText: 'Batal',
                    reverseButtons: false
                });

                if (!result.isConfirmed) {
                    return;
                }
            } else {
                if (!confirm(`Apakah Anda yakin ingin menghapus jadwal libur "${cleanName}"?\nData yang dihapus akan dikeluarkan dari daftar libur sekolah.`)) {
                    return;
                }
            }

            try {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Menghapus Jadwal Libur...',
                        html: 'Sedang menghapus data dari sistem...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                const response = await fetch(`{{ url('/jam-pelajaran/hari-libur') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const res = await response.json();
                if (response.ok && res.success) {
                    if (rowElem) rowElem.remove();
                    if (res.data) {
                        renderHolidayTable(res.data.holidays, res.data.today_info);
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Dihapus',
                            text: res.message || 'Jadwal libur berhasil dihapus dari sistem.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        showToastNotification(res.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const errorMsg = res.message || 'Terjadi kesalahan saat menghapus data libur.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus Libur',
                            text: errorMsg,
                            confirmButtonColor: '#ef4444'
                        });
                    } else {
                        alert('Gagal menghapus libur: ' + errorMsg);
                    }
                }
            } catch (err) {
                console.error(err);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Jaringan',
                        text: 'Terjadi kesalahan saat menghubungi server untuk menghapus libur.',
                        confirmButtonColor: '#ef4444'
                    });
                } else {
                    alert('Terjadi kesalahan jaringan saat menghapus libur.');
                }
            }
        }

        function renderHolidayTable(holidays, todayInfo) {
            const tbody = document.getElementById('holidayTableBody');
            const badgeTotal = document.getElementById('badgeTotalLibur');
            const badgeActive = document.getElementById('badgeActiveLibur');
            if (!tbody) return;

            if (!holidays || holidays.length === 0) {
                tbody.innerHTML = `
                    <tr id="rowHolidayEmpty">
                        <td colspan="6" style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                            <i class="fa-solid fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            <strong style="color: #64748b; font-size: 14px;">Belum ada jadwal hari libur tambahan</strong>
                            <p style="margin: 4px 0 0 0; font-size: 12.5px;">Hari Sabtu dan Minggu tetap secara permanen menjadi libur akhir pekan.</p>
                        </td>
                    </tr>
                `;
                if (badgeTotal) badgeTotal.textContent = 'Total: 0 Libur';
                if (badgeActive) badgeActive.textContent = '0 Aktif';
                return;
            }

            let activeCount = 0;
            let html = '';
            holidays.forEach((h, idx) => {
                if (h.is_active) activeCount++;
                const ongoingClass = h.is_currently_ongoing ? 'row-ongoing-holiday' : '';
                const ongoingPulse = h.is_currently_ongoing ? `
                    <span class="badge-ongoing-pulse">
                        <i class="fa-solid fa-circle-dot"></i> Sedang Berlangsung Hari Ini
                    </span>
                ` : '';

                const statusBadge = h.is_active ? `
                    <span class="badge-status-holiday badge-holiday-active" title="Libur ini aktif berlaku dalam sistem">
                        <i class="fa-solid fa-circle-check"></i> Aktif Berlaku
                    </span>
                ` : `
                    <span class="badge-status-holiday badge-holiday-inactive" title="Libur ini sedang dinonaktifkan/dibatalkan">
                        <i class="fa-solid fa-circle-xmark"></i> Dibatalkan
                    </span>
                `;

                const actionButtons = h.is_active ? `
                    <button type="button" class="btn-h-action btn-h-deactivate" onclick="toggleHolidayStatus(${h.id}, false)" title="Nonaktifkan (Batalkan libur ini)">
                        <i class="fa-solid fa-ban"></i> Batalkan
                    </button>
                ` : `
                    <button type="button" class="btn-h-action btn-h-activate" onclick="toggleHolidayStatus(${h.id}, true)" title="Aktifkan kembali hari libur ini">
                        <i class="fa-solid fa-check"></i> Aktifkan
                    </button>
                `;

                const startFormatted = h.tanggal_mulai ? h.tanggal_mulai.split('-').reverse().join('/') : '';
                const endFormatted   = h.tanggal_selesai ? h.tanggal_selesai.split('-').reverse().join('/') : '';

                html += `
                    <tr id="holiday-row-${h.id}" class="holiday-row-card ${ongoingClass}">
                        <td class="col-h-no" style="text-align: center; font-weight:700;">
                            <span class="badge-h-no">#${idx + 1}</span>
                        </td>
                        <td class="col-h-keterangan">
                            <div class="h-keterangan-title">${escapeHtml(h.keterangan)}</div>
                            ${ongoingPulse}
                        </td>
                        <td class="col-h-periode">
                            <div class="h-periode-wrap">
                                <i class="fa-regular fa-calendar-days" style="color: #6366f1;"></i>
                                <span>${h.rentang_formatted}</span>
                            </div>
                            <div class="h-periode-dates">
                                ${startFormatted} &ndash; ${endFormatted}
                            </div>
                        </td>
                        <td class="col-h-durasi" style="text-align: center;">
                            <span class="badge-durasi">${h.durasi_hari} Hari</span>
                        </td>
                        <td class="col-h-status" style="text-align: center;" id="holiday-status-cell-${h.id}">
                            ${statusBadge}
                        </td>
                        <td class="col-h-aksi" style="text-align: center;">
                            <div class="holiday-action-group">
                                ${actionButtons}
                                <button type="button" class="btn-h-action btn-h-delete" onclick="deleteHoliday(${h.id}, '${escapeJs(h.keterangan)}')" title="Hapus jadwal libur ini">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
            if (badgeTotal) badgeTotal.textContent = `Total: ${holidays.length} Libur`;
            if (badgeActive) badgeActive.textContent = `${activeCount} Aktif`;
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function escapeJs(text) {
            if (!text) return '';
            return text.replace(/'/g, "\\'");
        }
    </script>

    <!-- Floating Toast Container -->
    <div class="jam-toast-box" id="jamToastContainer"></div>

    <!-- MODAL SET HARI LIBUR SEKOLAH -->
    <div class="holiday-modal-backdrop" id="holidayModalBackdrop" style="display:none;" onclick="handleBackdropClick(event)">
        <div class="holiday-modal-dialog" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="holiday-modal-header">
                <div class="holiday-header-title-wrap">
                    <div class="holiday-header-icon">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div>
                        <h3 class="holiday-modal-title">Kelola & Set Hari Libur Sekolah</h3>
                        <p class="holiday-modal-subtitle">Jadwalkan tanggal merah nasional, cuti bersama, atau hari libur khusus KBM sekolah</p>
                    </div>
                </div>
                <button type="button" class="holiday-btn-close" onclick="closeHolidayModal()" title="Tutup Modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="holiday-modal-body">
                <!-- Current Holiday Status Today -->
                <div class="holiday-status-today-bar" id="holidayStatusTodayBar">
                    @if(isset($holidayInfoToday) && $holidayInfoToday['is_holiday'])
                        <div class="status-indicator-badge status-libur">
                            <i class="fa-solid fa-circle-dot"></i>
                            <span>Status Hari Ini: <strong>LIBUR ({{ $holidayInfoToday['keterangan'] }})</strong></span>
                        </div>
                    @else
                        <div class="status-indicator-badge status-efektif">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Status Hari Ini: <strong>KBM Berlangsung Efektif</strong></span>
                        </div>
                    @endif
                    <div class="status-info-date">
                        <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                <!-- Card 1: Form Input Banyak Sekaligus (Batch) -->
                <div class="holiday-card-box">
                    <div class="holiday-card-header">
                        <div class="card-header-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                        <div>
                            <h4 class="card-title">Tambah Jadwal Hari Libur Baru</h4>
                            <p class="card-subtitle">Input satu atau beberapa rentang tanggal libur sekaligus untuk disimpan dalam satu kali simpan</p>
                        </div>
                    </div>

                    <form id="formStoreHolidayBatch" onsubmit="handleHolidayBatchSubmit(event)">
                        @csrf
                        <div class="holiday-rows-wrapper" id="holidayRowsContainer">
                            <!-- Dynamic Row 1 -->
                            <div class="holiday-input-row" data-row-index="0">
                                <div class="row-num-badge">#1</div>
                                <div class="form-group-field" style="flex: 1.2;">
                                    <label class="field-label">Tanggal Mulai <span class="required-star">*</span></label>
                                    <input type="date" name="holidays[0][tanggal_mulai]" class="holiday-input input-tgl-mulai" required onchange="handleDateChange(this)">
                                </div>
                                <div class="form-group-field" style="flex: 1.2;">
                                    <label class="field-label">Tanggal Selesai <span class="required-star">*</span></label>
                                    <input type="date" name="holidays[0][tanggal_selesai]" class="holiday-input input-tgl-selesai" required onchange="handleDateChange(this)">
                                </div>
                                <div class="form-group-field" style="flex: 2.2;">
                                    <label class="field-label">Keterangan / Nama Libur <span class="required-star">*</span></label>
                                    <input type="text" name="holidays[0][keterangan]" class="holiday-input input-keterangan" placeholder="Contoh: Libur Hari Raya Idul Fitri / Cuti Bersama" required maxlength="255">
                                </div>
                                <div class="row-actions">
                                    <label class="field-label" style="visibility:hidden;">Hapus</label>
                                    <button type="button" class="btn-remove-row" onclick="removeHolidayRow(this)" title="Hapus Baris Ini" disabled>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Row Controls: Add Row & Quick Actions -->
                        <div class="holiday-form-controls">
                            <button type="button" class="btn-add-holiday-row" onclick="addHolidayRow()">
                                <i class="fa-solid fa-plus-circle"></i> Tambah Baris Libur Lainnya
                            </button>
                            <div class="form-actions-right">
                                <button type="reset" class="btn-holiday-reset" onclick="resetHolidayForm()">
                                    <i class="fa-solid fa-rotate-left"></i> Reset Input
                                </button>
                                <button type="submit" class="btn-holiday-submit" id="btnSubmitHolidayBatch">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Hari Libur
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Card 2: Daftar Hari Libur yang Sudah Ditetapkan -->
                <div class="holiday-card-box" style="margin-top: 24px;">
                    <div class="holiday-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="card-header-icon" style="background:#e0e7ff; color:#4338ca;"><i class="fa-solid fa-calendar-check"></i></div>
                            <div>
                                <h4 class="card-title">Daftar Jadwal Hari Libur Sekolah Terdaftar</h4>
                                <p class="card-subtitle">Kelola status aktif/batal serta hapus jadwal libur yang tidak lagi berlaku</p>
                            </div>
                        </div>
                        <div class="holiday-counter-pills">
                            <span class="pill-badge pill-total" id="badgeTotalLibur">Total: {{ count($hariLiburList ?? []) }} Libur</span>
                            <span class="pill-badge pill-active" id="badgeActiveLibur">{{ isset($hariLiburList) ? $hariLiburList->where('is_active', true)->count() : 0 }} Aktif</span>
                        </div>
                    </div>

                    <div class="holiday-table-container">
                        <table class="holiday-table" id="tableHariLibur">
                            <thead>
                                <tr>
                                    <th style="width: 45px; text-align: center;">NO</th>
                                    <th>KETERANGAN / HARI LIBUR</th>
                                    <th>PERIODE TANGGAL</th>
                                    <th style="width: 90px; text-align: center;">DURASI</th>
                                    <th style="width: 140px; text-align: center;">STATUS</th>
                                    <th style="width: 170px; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="holidayTableBody">
                                @forelse($hariLiburList ?? [] as $hIdx => $h)
                                    <tr id="holiday-row-{{ $h->id }}" class="holiday-row-card {{ $h->is_currently_ongoing ? 'row-ongoing-holiday' : '' }}">
                                        <td class="col-h-no" style="text-align: center; font-weight:700;">
                                            <span class="badge-h-no">#{{ $hIdx + 1 }}</span>
                                        </td>
                                        <td class="col-h-keterangan">
                                            <div class="h-keterangan-title">{{ $h->keterangan }}</div>
                                            @if($h->is_currently_ongoing)
                                                <span class="badge-ongoing-pulse">
                                                    <i class="fa-solid fa-circle-dot"></i> Sedang Berlangsung Hari Ini
                                                </span>
                                            @endif
                                        </td>
                                        <td class="col-h-periode">
                                            <div class="h-periode-wrap">
                                                <i class="fa-regular fa-calendar-days" style="color: #6366f1;"></i>
                                                <span>{{ $h->rentang_formatted }}</span>
                                            </div>
                                            <div class="h-periode-dates">
                                                {{ \Carbon\Carbon::parse($h->tanggal_mulai)->format('d/m/Y') }} &ndash; {{ \Carbon\Carbon::parse($h->tanggal_selesai)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="col-h-durasi" style="text-align: center;">
                                            <span class="badge-durasi">{{ $h->durasi_hari }} Hari</span>
                                        </td>
                                        <td class="col-h-status" style="text-align: center;" id="holiday-status-cell-{{ $h->id }}">
                                            @if($h->is_active)
                                                <span class="badge-status-holiday badge-holiday-active" title="Libur ini aktif berlaku dalam sistem">
                                                    <i class="fa-solid fa-circle-check"></i> Aktif Berlaku
                                                </span>
                                            @else
                                                <span class="badge-status-holiday badge-holiday-inactive" title="Libur ini sedang dinonaktifkan/dibatalkan">
                                                    <i class="fa-solid fa-circle-xmark"></i> Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="col-h-aksi" style="text-align: center;">
                                            <div class="holiday-action-group">
                                                @if($h->is_active)
                                                    <button type="button" class="btn-h-action btn-h-deactivate" onclick="toggleHolidayStatus({{ $h->id }}, false)" title="Nonaktifkan (Batalkan libur ini)">
                                                        <i class="fa-solid fa-ban"></i> Batalkan
                                                    </button>
                                                @else
                                                    <button type="button" class="btn-h-action btn-h-activate" onclick="toggleHolidayStatus({{ $h->id }}, true)" title="Aktifkan kembali hari libur ini">
                                                        <i class="fa-solid fa-check"></i> Aktifkan
                                                    </button>
                                                @endif
                                                <button type="button" class="btn-h-action btn-h-delete" onclick="deleteHoliday({{ $h->id }}, '{{ addslashes(htmlspecialchars($h->keterangan, ENT_QUOTES, 'UTF-8')) }}')" title="Hapus jadwal libur ini">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="rowHolidayEmpty">
                                        <td colspan="6" style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                                            <i class="fa-solid fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                            <strong style="color: #64748b; font-size: 14px;">Belum ada jadwal hari libur tambahan</strong>
                                            <p style="margin: 4px 0 0 0; font-size: 12.5px;">Hari Sabtu dan Minggu tetap secara permanen menjadi libur akhir pekan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="holiday-modal-footer">
                <span style="font-size: 12.5px; color: #64748b;">
                    <i class="fa-solid fa-shield-halved" style="color: #3b82f6;"></i> Perubahan status hari libur langsung disinkronkan ke seluruh sistem KBM & Jurnal Mengajar.
                </span>
                <button type="button" class="btn-holiday-close-footer" onclick="closeHolidayModal()">Tutup</button>
            </div>
        </div>
    </div>
@endsection
