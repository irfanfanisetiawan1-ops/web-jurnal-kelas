@extends('layouts.guru')

@section('title', 'Jurnal Harian — EDU JOURNAL')
@section('header_title', 'Jurnal Harian Guru')

@section('styles')
<style>
    /* Top Alert Banner */
    .reminder-banner {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .reminder-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffe4e6;
        color: #e11d48;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .reminder-title {
        font-size: 14px;
        font-weight: 800;
        color: #9f1239;
    }

    .reminder-desc {
        font-size: 12.5px;
        color: #be123c;
        margin-top: 3px;
        line-height: 1.4;
    }

    /* Top Horizontal Scrollable Schedule Cards */
    .section-subtitle-head {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .horizontal-schedule-scroll {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 24px;
    }

    .schedule-card-item {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 16px;
        min-width: 220px;
        flex: 0 0 auto;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }

    .schedule-card-item:hover, .schedule-card-item.selected {
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        transform: translateY(-2px);
    }

    .schedule-card-item.selected {
        background: #eff6ff;
    }

    .schedule-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .schedule-card-meta {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 4px;
    }

    .schedule-card-status {
        margin-top: 10px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-active { color: #16a34a; }
    .status-pending { color: #64748b; }

    /* Bottom Widgets Grid (2 Cards Side-by-Side) */
    .jurnal-bottom-widgets-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 900px) {
        .jurnal-bottom-widgets-grid { grid-template-columns: 1fr; }
    }

    /* Main Form Card - Full Width */
    .form-jurnal-box {
        background: #ffffff;
        border-radius: 20px;
        border: 1.5px solid #cbd5e1;
        padding: 30px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        width: 100%;
        margin-bottom: 30px;
    }

    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }

    .input-field-custom {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: border 0.15s ease;
    }

    .input-field-custom:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Condition Radio Pills */
    .condition-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .condition-pill-label {
        padding: 8px 18px;
        border-radius: 20px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .condition-pill-input { display: none; }

    .condition-pill-input:checked + .condition-pill-label {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
        box-shadow: 0 3px 8px rgba(56, 73, 114, 0.2);
    }

    /* Student Attendance Status Radio Pills */
    .status-radio-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
        border: 1px solid transparent;
    }

    .status-radio-pill input[type="radio"] {
        margin: 0;
        cursor: pointer;
        accent-color: currentColor;
    }

    .status-radio-pill.pill-hadir {
        color: #15803d;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .status-radio-pill.pill-hadir:hover {
        background: #dcfce7;
    }

    .status-radio-pill.pill-sakit {
        color: #1d4ed8;
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .status-radio-pill.pill-sakit:hover {
        background: #dbeafe;
    }

    .status-radio-pill.pill-izin {
        color: #b45309;
        background: #fffbeb;
        border-color: #fde68a;
    }
    .status-radio-pill.pill-izin:hover {
        background: #fef3c7;
    }

    .status-radio-pill.pill-alpa {
        color: #b91c1c;
        background: #fef2f2;
        border-color: #fecaca;
    }
    .status-radio-pill.pill-alpa:hover {
        background: #fee2e2;
    }

    .status-radio-pill.pill-dispen {
        color: #7e22ce;
        background: #faf5ff;
        border-color: #e9d5ff;
    }
    .status-radio-pill.pill-dispen.locked {
        cursor: not-allowed;
    }

    .status-radio-pill.locked-active {
        font-weight: 800;
        cursor: not-allowed !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
    .status-radio-pill.pill-sakit.locked-active {
        background: #dbeafe;
        border-color: #3b82f6;
        color: #1d4ed8;
    }
    .status-radio-pill.pill-izin.locked-active {
        background: #fef9c3;
        border-color: #eab308;
        color: #a16207;
    }
    .status-radio-pill.pill-alpa.locked-active {
        background: #fee2e2;
        border-color: #ef4444;
        color: #dc2626;
    }
    .status-radio-pill.pill-dispen.locked-active {
        background: #f3e8ff;
        border-color: #9333ea;
        color: #7e22ce;
    }

    /* Button Catatan Presensi (Sebelah Kanan Dispen) */
    .btn-catatan-presensi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        position: relative;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-catatan-presensi:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    }
    .btn-catatan-presensi:active {
        transform: translateY(0);
    }
    .btn-catatan-presensi.has-catatan {
        background: #eef2ff;
        border-color: #6366f1;
        color: #4338ca;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.15);
    }
    .btn-catatan-presensi.has-catatan:hover {
        background: #e0e7ff;
        border-color: #4f46e5;
        color: #3730a3;
    }
    .catatan-indicator-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #4f46e5;
        color: #ffffff;
        font-size: 8.5px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        margin-left: 2px;
    }

    /* Catatan Preview Box in Student Table Row */
    .catatan-preview-box {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        color: #3730a3;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        max-width: 100%;
        word-break: break-word;
    }

    /* Modal Catatan Presensi */
    .modal-catatan-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        box-sizing: border-box;
        animation: fadeInModal 0.2s ease-out;
    }
    @keyframes fadeInModal {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .modal-catatan-card {
        background: #ffffff;
        border-radius: 18px;
        max-width: 520px;
        width: 100%;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        animation: slideUpModal 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes slideUpModal {
        from { transform: translateY(18px) scale(0.98); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    .modal-catatan-header {
        padding: 18px 22px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-catatan-title {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .modal-catatan-close {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .modal-catatan-close:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .modal-catatan-body {
        padding: 20px 22px;
        overflow-y: auto;
        max-height: 75vh;
    }
    .modal-catatan-footer {
        padding: 16px 22px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .quick-chip-tag {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        cursor: pointer;
        transition: all 0.15s ease;
        font-weight: 600;
        user-select: none;
    }
    .quick-chip-tag:hover {
        background: #e2e8f0;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* Buttons */
    .form-actions-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-draft {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-submit-jurnal {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(56, 73, 114, 0.25);
    }

    .bottom-info-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 12.5px;
        font-weight: 700;
        padding: 12px 18px;
        border-radius: 10px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Readonly Schedule Info Grid (TU Master Data Connected) */
    .schedule-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 14px;
    }

    @media (max-width: 900px) {
        .schedule-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 520px) {
        .schedule-info-grid {
            grid-template-columns: 1fr;
        }
    }

    .input-readonly-field {
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        background: #e2e8f0;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        font-family: inherit;
        outline: none;
        cursor: not-allowed;
        box-sizing: border-box;
        transition: border 0.15s ease;
    }

    .input-readonly-wrapper {
        position: relative;
        width: 100%;
    }

    .input-readonly-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #0f172a;
        pointer-events: none;
        font-size: 15px;
    }

    /* Live Camera & Photo Upload Styling */
    .camera-upload-container {
        margin-top: 18px;
        margin-bottom: 20px;
    }

    .camera-box-placeholder {
        background: #e2e8f0;
        border: 2px dashed #94a3b8;
        border-radius: 16px;
        padding: 36px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 180px;
    }

    .camera-box-placeholder:hover {
        background: #cbd5e1;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12);
    }

    .camera-icon-circle {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: #ffffff;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .camera-box-placeholder:hover .camera-icon-circle {
        transform: scale(1.08);
        color: #2563eb;
    }

    .camera-viewfinder-wrapper {
        background: #0f172a;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        border: 2px solid #334155;
    }

    .camera-video-stream {
        width: 100%;
        max-height: 380px;
        display: block;
        object-fit: cover;
        background: #000000;
        transform: scaleX(1); /* will flip if user front camera */
    }

    .camera-live-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(225, 29, 72, 0.9);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ffffff;
        animation: blink 1s infinite alternate;
    }

    @keyframes blink {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0.3; transform: scale(0.8); }
    }

    .camera-controls-bar {
        position: absolute;
        bottom: 14px;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 0 16px;
        z-index: 5;
    }

    .btn-snap-photo {
        background: #2563eb;
        color: #ffffff;
        border: 4px solid rgba(255, 255, 255, 0.85);
        border-radius: 50px;
        padding: 12px 28px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 18px rgba(37, 99, 235, 0.6);
        transition: transform 0.15s ease, background 0.15s ease;
    }

    .btn-snap-photo:hover {
        background: #1d4ed8;
        transform: scale(1.05);
    }

    .btn-snap-photo:active {
        transform: scale(0.95);
    }

    .btn-camera-opt {
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        backdrop-filter: blur(6px);
        transition: all 0.15s ease;
    }

    .btn-camera-opt:hover {
        background: rgba(15, 23, 42, 0.95);
        transform: scale(1.08);
    }

    .camera-preview-container {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .camera-preview-img-wrapper {
        position: relative;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        background: #0f172a;
        text-align: center;
    }

    .camera-preview-img {
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        display: block;
    }

    .camera-preview-meta {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(4px);
    }

    .shutter-flash {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ffffff;
        opacity: 0;
        pointer-events: none;
        z-index: 10;
        transition: opacity 0.1s ease-out;
    }

    .shutter-flash.active {
        opacity: 0.9;
    }

    /* Right Widgets */
    .widget-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .history-item:last-child { border-bottom: none; }

    .history-class {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .history-date {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .badge-history-terisi {
        background: #84a98c;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .badge-history-belum {
        background: #cb997e;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .progress-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .progress-row:last-child { border-bottom: none; }

    .progress-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    /* Mobile Responsive Overrides */
    .page-header-jurnal {
        margin-bottom: 20px;
    }

    .page-title-jurnal {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .page-subtitle-jurnal {
        font-size: 13.5px;
        color: #64748b;
        margin-top: 2px;
        margin-bottom: 0;
    }

    .context-tab-bar-jurnal {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 4px;
    }

    .context-tab-btn-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 12px 12px 0 0;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
        border-bottom: 3px solid transparent;
        color: #64748b;
        margin-bottom: -6px;
    }

    .context-tab-btn-jurnal.active {
        border-bottom-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }

    .wali-banner-info {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: #ffffff;
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .wali-filter-toolbar {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 14px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .wali-metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .empty-schedule-box {
        text-align: center;
        padding: 48px 24px;
        border: 1.5px dashed #cbd5e1;
        background: #ffffff;
        border-radius: 20px;
        margin-bottom: 24px;
    }

    .empty-schedule-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .empty-schedule-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .empty-schedule-desc {
        font-size: 13.5px;
        color: #64748b;
        max-width: 560px;
        margin: 0 auto 24px auto;
        line-height: 1.5;
    }

    .empty-schedule-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .form-materi-grid {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 16px;
    }

    .table-absensi-scroll {
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        background: #ffffff;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        width: 100%;
        box-sizing: border-box;
    }

    .wali-schedule-desktop-table,
    .wali-absen-desktop-table {
        display: block;
    }

    .wali-schedule-mobile-cards,
    .wali-absen-mobile-cards {
        display: none;
    }

    @media (max-width: 768px) {
        .wali-schedule-desktop-table,
        .wali-absen-desktop-table {
            display: none !important;
        }

        .wali-schedule-mobile-cards,
        .wali-absen-mobile-cards {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        .page-title-jurnal {
            font-size: 28px !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
        }

        .page-subtitle-jurnal {
            font-size: 12.5px !important;
            line-height: 1.4 !important;
        }

        .context-tab-bar-jurnal {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 6px !important;
            border-bottom: none !important;
            padding-bottom: 0 !important;
        }

        .context-tab-btn-jurnal {
            border-radius: 10px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 10px 14px !important;
            justify-content: center !important;
            margin-bottom: 0 !important;
            font-size: 13px !important;
        }

        .context-tab-btn-jurnal.active {
            border: 1px solid #2563eb !important;
            background: #eff6ff !important;
        }

        .reminder-banner {
            flex-direction: column !important;
            padding: 14px 16px !important;
            gap: 10px !important;
            border-radius: 14px !important;
        }

        .reminder-icon {
            width: 36px !important;
            height: 36px !important;
            font-size: 16px !important;
        }

        #urgentReminderAlertBox {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 14px 16px !important;
            gap: 12px !important;
        }

        #urgentReminderAlertBox a {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            height: 40px !important;
        }

        .wali-banner-info {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 18px 16px !important;
            gap: 16px !important;
            border-radius: 16px !important;
        }

        .wali-banner-info a {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            height: 40px !important;
        }

        .wali-filter-toolbar {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 14px 12px !important;
            gap: 12px !important;
        }

        .wali-filter-toolbar form {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
        }

        .wali-filter-toolbar form input[type="date"] {
            width: 100% !important;
            box-sizing: border-box !important;
            height: 40px !important;
        }

        .wali-metrics-grid {
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
        }

        .empty-schedule-box {
            padding: 28px 16px !important;
            border-radius: 16px !important;
        }

        .empty-schedule-actions {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .empty-schedule-actions a,
        .empty-schedule-actions button {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            height: 42px !important;
            font-size: 13px !important;
        }

        .form-jurnal-box {
            padding: 18px 14px !important;
            border-radius: 16px !important;
            margin-bottom: 20px !important;
        }

        .form-materi-grid {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .camera-box-placeholder {
            padding: 24px 14px !important;
            min-height: 150px !important;
        }

        .camera-icon-circle {
            width: 60px !important;
            height: 60px !important;
            font-size: 26px !important;
        }

        .camera-controls-bar {
            gap: 10px !important;
            padding: 0 10px !important;
            bottom: 10px !important;
        }

        .btn-snap-photo {
            padding: 10px 18px !important;
            font-size: 12.5px !important;
        }

        .btn-camera-opt {
            width: 38px !important;
            height: 38px !important;
            font-size: 14px !important;
        }

        .form-actions-row {
            flex-direction: column-reverse !important;
            align-items: stretch !important;
            gap: 10px !important;
        }

        .form-actions-row button,
        .form-actions-row a {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            height: 42px !important;
            font-size: 13px !important;
        }

        .widget-box {
            padding: 16px 14px !important;
            border-radius: 16px !important;
        }

        .modal-catatan-card {
            width: calc(100% - 16px) !important;
            max-width: 100% !important;
            border-radius: 16px !important;
            margin: 8px auto !important;
        }

        .modal-catatan-header {
            padding: 14px 16px !important;
        }

        .modal-catatan-body {
            padding: 16px 14px !important;
        }

        .modal-catatan-footer {
            padding: 12px 16px !important;
            flex-direction: column-reverse !important;
            gap: 8px !important;
        }

        .modal-catatan-footer button {
            width: 100% !important;
            justify-content: center !important;
            height: 40px !important;
            box-sizing: border-box !important;
        }

        .modal-catatan-footer > div {
            width: 100% !important;
            flex-direction: column-reverse !important;
            gap: 8px !important;
            margin-left: 0 !important;
        }

        #modalDetailJurnal {
            padding: 12px !important;
        }

        #modalDetailJurnal > div,
        .modal-detail-card {
            width: 100% !important;
            max-width: 100% !important;
            border-radius: 16px !important;
            margin: 0 auto !important;
            max-height: 92vh !important;
        }

        .modal-detail-header {
            padding: 14px 16px !important;
        }

        .modal-detail-body {
            padding: 16px 14px !important;
        }

        .modal-detail-footer {
            padding: 12px 16px !important;
        }

        .modal-detail-footer button {
            width: 100% !important;
            justify-content: center !important;
            height: 40px !important;
            box-sizing: border-box !important;
        }

        .modal-detail-stat-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
        }

        .section-card-title-wali {
            font-size: 16px !important;
            line-height: 1.35 !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-jurnal {
            font-size: 25px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
        }

        .wali-metrics-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 8px !important;
        }

        .section-card-title-wali {
            font-size: 15px !important;
        }
    }
</style>
@endsection

@section('content')

    <div class="page-header-jurnal">
        <h1 class="page-title-jurnal">
            <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
            Jurnal Harian
        </h1>
        <p class="page-subtitle-jurnal">
            Isi dan kelola jurnal harian Anda
        </p>
    </div>

    {{-- Tab Switcher: Jurnal Mengajar Saya vs Monitoring Jurnal Kelas Perwalian (Untuk Wali Kelas) --}}
    @if(isset($isWaliKelas) && $isWaliKelas && isset($kelasWali) && $kelasWali)
        <div class="context-tab-bar-jurnal">
            <a href="{{ route('guru.jurnal-harian', ['tab' => 'saya', 'tanggal' => $todayDate]) }}" class="context-tab-btn-jurnal {{ ($activeTab ?? 'saya') === 'saya' ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Jurnal Mengajar Saya
            </a>
            <a href="{{ route('guru.jurnal-harian', ['tab' => 'perwalian', 'tanggal' => $todayDate]) }}" class="context-tab-btn-jurnal {{ ($activeTab ?? 'saya') === 'perwalian' ? 'active' : '' }}">
                <i class="fa-solid fa-people-roof"></i> Monitoring Jurnal Kelas Perwalian ({{ $kelasWali->nama_kelas }})
                @if(isset($rekapPerwalianHariIni['total_kbm']) && $rekapPerwalianHariIni['total_kbm'] > 0)
                    <span style="font-size: 11px; padding: 2px 8px; border-radius: 12px; background: {{ $rekapPerwalianHariIni['terisi'] === $rekapPerwalianHariIni['total_kbm'] ? '#dcfce7' : '#dbeafe' }}; color: {{ $rekapPerwalianHariIni['terisi'] === $rekapPerwalianHariIni['total_kbm'] ? '#15803d' : '#1e40af' }}; font-weight: 800;">
                        {{ $rekapPerwalianHariIni['terisi'] }}/{{ $rekapPerwalianHariIni['total_kbm'] }} Terisi
                    </span>
                @endif
            </a>
        </div>
    @endif

    @if(($activeTab ?? 'saya') === 'perwalian' && isset($isWaliKelas) && $isWaliKelas && isset($kelasWali) && $kelasWali)
        {{-- ========================================== --}}
        {{-- TAMPILAN MONITORING KELAS PERWALIAN        --}}
        {{-- ========================================== --}}
        <!-- Banner Info Kelas Perwalian -->
        <div class="wali-banner-info">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span style="background: rgba(255, 255, 255, 0.2); color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i class="fa-solid fa-id-badge"></i> Ruang Kerja Wali Kelas
                    </span>
                    <span style="background: rgba(255, 255, 255, 0.2); color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">
                        <i class="fa-solid fa-calendar-day"></i> {{ $hariIni }}, {{ $todayCarbon->translatedFormat('d F Y') }}
                    </span>
                </div>
                <h2 style="font-size: 22px; font-weight: 800; margin: 10px 0 4px 0; color: #ffffff;">
                    Monitoring Jurnal KBM Kelas {{ $kelasWali->nama_kelas }}
                </h2>
                <div style="font-size: 13.5px; opacity: 0.95; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                    <span><i class="fa-solid fa-graduation-cap"></i> Jurusan: <strong>{{ $kelasWali->jurusan->nama_jurusan ?? '-' }}</strong></span>
                    <span><i class="fa-solid fa-door-open"></i> Ruangan: <strong>{{ $kelasWali->ruangan->nama_ruangan ?? 'Ruang Kelas' }}</strong></span>
                    <span><i class="fa-solid fa-users"></i> Total Siswa: <strong>{{ $rekapPerwalianHariIni['total_siswa'] }} Siswa</strong></span>
                </div>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <a href="{{ route('guru.absensi-siswa', ['tab' => 'perwalian', 'tanggal' => $todayDate]) }}" style="background: #ffffff; color: #1e3a8a; font-weight: 800; font-size: 13px; padding: 10px 18px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-user-check"></i> Presensi Siswa
                </a>
                <a href="{{ route('guru.kehadiran-kelas') }}" style="background: rgba(255, 255, 255, 0.15); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); font-weight: 800; font-size: 13px; padding: 10px 18px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-pie"></i> Rekap & Perkembangan
                </a>
            </div>
        </div>

        <!-- Toolbar Filter Tanggal KBM Perwalian -->
        <div class="wali-filter-toolbar">
            <form id="filterTglPerwalianForm" method="GET" action="{{ route('guru.jurnal-harian') }}" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin: 0;">
                <input type="hidden" name="tab" value="perwalian">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label for="inputTanggalPerwalian" style="font-size: 13px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-calendar-day" style="color: #2563eb;"></i> Pilih Tanggal:
                    </label>
                    <input type="date" id="inputTanggalPerwalian" name="tanggal" value="{{ $todayDate }}" onchange="document.getElementById('filterTglPerwalianForm').submit()" style="border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 7px 12px; font-size: 13px; font-weight: 700; color: #0f172a; outline: none; background: #f8fafc; cursor: pointer;">
                </div>
                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    @php
                        $actualToday = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                        $yesterday = \Carbon\Carbon::parse($todayDate)->subDay()->toDateString();
                        $tomorrow = \Carbon\Carbon::parse($todayDate)->addDay()->toDateString();
                    @endphp
                    @if($todayDate !== $actualToday)
                        <a href="{{ route('guru.jurnal-harian', ['tab' => 'perwalian', 'tanggal' => $actualToday]) }}" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-rotate-left"></i> Hari Ini
                        </a>
                    @endif
                    <a href="{{ route('guru.jurnal-harian', ['tab' => 'perwalian', 'tanggal' => $yesterday]) }}" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-chevron-left"></i> Hari Sebelumnya
                    </a>
                    <a href="{{ route('guru.jurnal-harian', ['tab' => 'perwalian', 'tanggal' => $tomorrow]) }}" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        Hari Berikutnya <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </form>
            <div style="font-size: 12.5px; color: #64748b; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i>
                <span>Menampilkan jadwal & jurnal hari <strong>{{ $hariIni }}, {{ $todayCarbon->translatedFormat('d F Y') }}</strong></span>
            </div>
        </div>

        <!-- 4 Metric Cards Row -->
        <div class="wali-metrics-grid">
            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 16px; padding: 18px 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.02);">
                <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total KBM Hari {{ $hariIni }}</div>
                <div style="font-size: 24px; font-weight: 900; color: #0f172a; margin-top: 6px;">{{ $rekapPerwalianHariIni['total_kbm'] }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Mata Pelajaran</span></div>
                <div style="font-size: 11.5px; color: #2563eb; font-weight: 700; margin-top: 4px;"><i class="fa-solid fa-calendar-check"></i> Jadwal Aktif Hari {{ $hariIni }}</div>
            </div>

            <div style="background: #ffffff; border: 1.5px solid #bbf7d0; border-radius: 16px; padding: 18px 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.02);">
                <div style="font-size: 12px; font-weight: 700; color: #15803d; text-transform: uppercase;">Jurnal Terisi</div>
                <div style="font-size: 24px; font-weight: 900; color: #16a34a; margin-top: 6px;">{{ $rekapPerwalianHariIni['terisi'] }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">KBM Selesai</span></div>
                <div style="font-size: 11.5px; color: #15803d; font-weight: 700; margin-top: 4px;">
                    @if($rekapPerwalianHariIni['draft'] > 0)
                        <span style="color: #0369a1;"><i class="fa-regular fa-bookmark"></i> +{{ $rekapPerwalianHariIni['draft'] }} Masih Draft</span>
                    @else
                        <i class="fa-solid fa-circle-check"></i> Data Tersimpan Resmi
                    @endif
                </div>
            </div>

            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 16px; padding: 18px 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.02);">
                <div style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Jurnal Belum Terisi</div>
                <div style="font-size: 24px; font-weight: 900; color: {{ $rekapPerwalianHariIni['belum'] > 0 ? '#ea580c' : '#10b981' }}; margin-top: 6px;">
                    {{ $rekapPerwalianHariIni['belum'] }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Mata Pelajaran</span>
                </div>
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; margin-top: 4px;">
                    <i class="fa-regular fa-clock"></i> Belum Mengisi / Berjalan
                </div>
            </div>

            <div style="background: #ffffff; border: 1.5px solid #fed7aa; border-radius: 16px; padding: 18px 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.02);">
                <div style="font-size: 12px; font-weight: 700; color: #c2410c; text-transform: uppercase;">Ketidakhadiran Siswa</div>
                <div style="font-size: 24px; font-weight: 900; color: #c2410c; margin-top: 6px;">
                    {{ count($siswaAbsenPerwalianHariIni) }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">Siswa Absen</span>
                </div>
                <div style="font-size: 11px; color: #475569; font-weight: 700; margin-top: 4px; display: flex; gap: 6px; flex-wrap: wrap;">
                    <span style="color: #1d4ed8;">S: {{ $rekapPerwalianHariIni['siswa_sakit'] }}</span> &bull;
                    <span style="color: #b45309;">I: {{ $rekapPerwalianHariIni['siswa_izin'] }}</span> &bull;
                    <span style="color: #b91c1c;">A: {{ $rekapPerwalianHariIni['siswa_alpa'] }}</span> &bull;
                    <span style="color: #7e22ce;">D: {{ $rekapPerwalianHariIni['siswa_dispen'] }}</span>
                    @if($rekapPerwalianHariIni['siswa_telat'] > 0)
                        &bull; <span style="color: #ea580c;">Telat: {{ $rekapPerwalianHariIni['siswa_telat'] }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Jadwal & Status Jurnal KBM Kelas Perwalian -->
        <div class="form-jurnal-box" style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 class="section-card-title-wali" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-list-check" style="color: #2563eb;"></i> Jadwal & Jurnal KBM Kelas {{ $kelasWali->nama_kelas }} ({{ $hariIni }}, {{ $todayCarbon->translatedFormat('d M Y') }})
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0;">
                        Daftar seluruh sesi pembelajaran yang berlangsung di kelas perwalian Anda beserta status pengisian jurnal oleh guru pengajar.
                    </p>
                </div>
            </div>

            <!-- Desktop Table View: Jadwal & Jurnal KBM Kelas Perwalian -->
            <div class="wali-schedule-desktop-table" style="border: 1.5px solid #cbd5e1; border-radius: 14px; overflow-x: auto; -webkit-overflow-scrolling: touch; background: #ffffff; width: 100%; box-sizing: border-box;">
                <table style="width: 100%; min-width: 720px; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1.5px solid #cbd5e1; text-align: left; color: #475569; font-size: 12px; text-transform: uppercase;">
                            <th style="padding: 14px 18px; font-weight: 800;">Jam & Waktu</th>
                            <th style="padding: 14px 18px; font-weight: 800;">Mata Pelajaran</th>
                            <th style="padding: 14px 18px; font-weight: 800;">Guru Pengajar</th>
                            <th style="padding: 14px 18px; font-weight: 800;">Status Jurnal</th>
                            <th style="padding: 14px 18px; font-weight: 800;">Materi & Pertemuan</th>
                            <th style="padding: 14px 18px; font-weight: 800; text-align: center;">Presensi Siswa</th>
                            <th style="padding: 14px 18px; font-weight: 800; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalsKelasPerwalianHariIni as $jItem)
                            @php
                                $jEntry = $jurnalsKelasPerwalianMap[$jItem->id_jadwal] ?? null;
                                $isTerisi = ($jEntry !== null);
                                $isDraftPerwalian = ($jEntry && $jEntry->is_draft);
                                $isBerlangsungPerwalian = $jItem->is_sedang_berlangsung;
                                $isSelesaiPerwalian = $jItem->is_jam_sudah_selesai;

                                $totalAbsenItem = $jEntry ? $jEntry->detailKetidakhadiran->count() : 0;
                                $hadirCountItem = max(0, $rekapPerwalianHariIni['total_siswa'] - $totalAbsenItem);
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                                <td style="padding: 14px 18px; vertical-align: middle;">
                                    <div style="font-weight: 800; color: #0f172a;">Jam Ke-{{ $jItem->jam_range }}</div>
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $jItem->waktu_mulai_effective }} - {{ $jItem->waktu_selesai_effective }} WIB</div>
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle;">
                                    <div style="font-weight: 800; color: #1e293b; font-size: 13.5px;">{{ $jItem->mapel->nama_mapel ?? 'Mata Pelajaran' }}</div>
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">Ruangan: {{ $jItem->ruangan->nama_ruangan ?? '-' }}</div>
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle;">
                                    <div style="font-weight: 700; color: #0f172a;">{{ $jItem->guru->nama_guru ?? 'Guru Mengajar' }}</div>
                                    @if(!empty($jItem->penugasan_pengganti_aktif))
                                        <div style="margin-top: 3px;">
                                            <span style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                                <i class="fa-solid fa-user-clock"></i> Diganti: {{ $jItem->penugasan_pengganti_aktif->guruPengganti->nama_guru ?? 'Guru Pengganti' }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle;">
                                    @if($isTerisi)
                                        @if($isDraftPerwalian)
                                            <span style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa-regular fa-bookmark"></i> Draft Tersimpan
                                            </span>
                                        @else
                                            <span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-circle-check"></i> Sudah Diisi
                                            </span>
                                        @endif
                                    @elseif($isBerlangsungPerwalian)
                                        <span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-circle" style="font-size: 8px;"></i> Sedang Berlangsung
                                        </span>
                                    @elseif($isSelesaiPerwalian)
                                        <span style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-ban"></i> Belum Diisi (Selesai)
                                        </span>
                                    @else
                                        <span style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fa-regular fa-clock"></i> Belum Mulai
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle;">
                                    @if($jEntry)
                                        <div style="font-weight: 700; color: #0f172a;">{{ $jEntry->materi }}</div>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            {{ $jEntry->pertemuan_ke ?? 'Ke-1' }} &bull; Kondisi: <strong>{{ $jEntry->kondisi_kelas ?? 'Kondusif' }}</strong>
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-style: italic;">Materi belum diinput</span>
                                    @endif
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle; text-align: center;">
                                    @if($jEntry)
                                        <div style="display: inline-flex; gap: 6px; font-size: 11px; font-weight: 800;">
                                            <span style="background: #dcfce7; color: #15803d; padding: 2px 7px; border-radius: 6px;" title="Siswa Hadir">H: {{ $hadirCountItem }}</span>
                                            @if($totalAbsenItem > 0)
                                                <span style="background: #fee2e2; color: #b91c1c; padding: 2px 7px; border-radius: 6px;" title="Siswa Tidak Hadir">Absen: {{ $totalAbsenItem }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td style="padding: 14px 18px; vertical-align: middle; text-align: right;">
                                    @if($jEntry)
                                        <button type="button" onclick="openDetailJurnalModal({{ $jEntry->id_jurnal }})" class="btn-submit-jurnal" style="background: #2563eb; font-size: 12px; padding: 7px 14px; border-radius: 8px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-eye"></i> Lihat Detail
                                        </button>
                                    @else
                                        <span style="font-size: 12px; color: #94a3b8;">Menunggu Guru</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 24px; text-align: center; color: #94a3b8;">
                                    Tidak ada jadwal KBM yang tercatat untuk kelas {{ $kelasWali->nama_kelas }} pada hari {{ $hariIni }} ({{ $todayCarbon->translatedFormat('d F Y') }}).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards View: Jadwal & Jurnal KBM Kelas Perwalian -->
            <div class="wali-schedule-mobile-cards">
                @forelse($jadwalsKelasPerwalianHariIni as $jItem)
                    @php
                        $jEntry = $jurnalsKelasPerwalianMap[$jItem->id_jadwal] ?? null;
                        $isTerisi = ($jEntry !== null);
                        $isDraftPerwalian = ($jEntry && $jEntry->is_draft);
                        $isBerlangsungPerwalian = $jItem->is_sedang_berlangsung;
                        $isSelesaiPerwalian = $jItem->is_jam_sudah_selesai;

                        $totalAbsenItem = $jEntry ? $jEntry->detailKetidakhadiran->count() : 0;
                        $hadirCountItem = max(0, $rekapPerwalianHariIni['total_siswa'] - $totalAbsenItem);
                    @endphp
                    <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 14px; padding: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
                            <span style="background: #f1f5f9; color: #1e293b; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 8px; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-regular fa-clock" style="color: #2563eb;"></i> Jam Ke-{{ $jItem->jam_range }} ({{ $jItem->waktu_mulai_effective }} - {{ $jItem->waktu_selesai_effective }} WIB)
                            </span>
                            @if($isTerisi)
                                @if($isDraftPerwalian)
                                    <span style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-regular fa-bookmark"></i> Draft
                                    </span>
                                @else
                                    <span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-check"></i> Sudah Diisi
                                    </span>
                                @endif
                            @elseif($isBerlangsungPerwalian)
                                <span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-circle" style="font-size: 8px;"></i> Berlangsung
                                </span>
                            @elseif($isSelesaiPerwalian)
                                <span style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-ban"></i> Belum Diisi
                                </span>
                            @else
                                <span style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-regular fa-clock"></i> Belum Mulai
                                </span>
                            @endif
                        </div>

                        <div>
                            <div style="font-size: 14.5px; font-weight: 800; color: #0f172a;">{{ $jItem->mapel->nama_mapel ?? 'Mata Pelajaran' }}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                <i class="fa-solid fa-door-open" style="color: #94a3b8;"></i> Ruangan: <strong>{{ $jItem->ruangan->nama_ruangan ?? '-' }}</strong>
                            </div>
                            <div style="font-size: 12px; color: #334155; margin-top: 4px; font-weight: 700;">
                                <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i> {{ $jItem->guru->nama_guru ?? 'Guru Mengajar' }}
                            </div>
                            @if(!empty($jItem->penugasan_pengganti_aktif))
                                <div style="margin-top: 4px;">
                                    <span style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px; display: inline-block;">
                                        <i class="fa-solid fa-user-clock"></i> Diganti: {{ $jItem->penugasan_pengganti_aktif->guruPengganti->nama_guru ?? 'Guru Pengganti' }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; font-size: 12px;">
                            @if($jEntry)
                                <div style="font-weight: 800; color: #0f172a; margin-bottom: 3px;">
                                    <i class="fa-solid fa-book-open" style="color: #2563eb; margin-right: 4px;"></i> {{ $jEntry->materi }}
                                </div>
                                <div style="color: #64748b; font-size: 11.5px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <span>{{ $jEntry->pertemuan_ke ?? 'Ke-1' }}</span>
                                    <span>&bull;</span>
                                    <span>Kondisi: <strong>{{ $jEntry->kondisi_kelas ?? 'Kondusif' }}</strong></span>
                                </div>
                            @else
                                <div style="color: #94a3b8; font-style: italic;">
                                    <i class="fa-regular fa-clock" style="margin-right: 4px;"></i> Materi belum diinput oleh guru pengajar
                                </div>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-top: 6px; border-top: 1px solid #f1f5f9;">
                            <div>
                                @if($jEntry)
                                    <div style="display: inline-flex; gap: 6px; font-size: 11px; font-weight: 800;">
                                        <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 6px;" title="Siswa Hadir">H: {{ $hadirCountItem }}</span>
                                        @if($totalAbsenItem > 0)
                                            <span style="background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 6px;" title="Siswa Tidak Hadir">Absen: {{ $totalAbsenItem }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Presensi: -</span>
                                @endif
                            </div>
                            <div>
                                @if($jEntry)
                                    <button type="button" onclick="openDetailJurnalModal({{ $jEntry->id_jurnal }})" class="btn-submit-jurnal" style="background: #2563eb; font-size: 11.5px; padding: 6px 12px; border-radius: 8px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                @else
                                    <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Menunggu Guru</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 20px; text-align: center; color: #94a3b8; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; font-size: 13px;">
                        Tidak ada jadwal KBM yang tercatat untuk kelas {{ $kelasWali->nama_kelas }} pada hari {{ $hariIni }}.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Rekap Siswa Tidak Hadir di Kelas Perwalian -->
        @if(count($siswaAbsenPerwalianHariIni) > 0)
            <div class="form-jurnal-box" style="margin-bottom: 24px;">
                <h3 class="section-card-title-wali" style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-user-xmark" style="color: #ef4444;"></i> Rekap Ketidakhadiran Siswa Kelas {{ $kelasWali->nama_kelas }} ({{ $hariIni }}, {{ $todayCarbon->translatedFormat('d M Y') }})
                </h3>
                <!-- Desktop Table View: Siswa Tidak Hadir -->
                <div class="wali-absen-desktop-table" style="border: 1.5px solid #cbd5e1; border-radius: 14px; overflow-x: auto; -webkit-overflow-scrolling: touch; background: #ffffff; width: 100%; box-sizing: border-box;">
                    <table style="width: 100%; min-width: 600px; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #cbd5e1; text-align: left; color: #475569; font-size: 12px; text-transform: uppercase;">
                                <th style="padding: 12px 18px; font-weight: 800;">Nama Siswa</th>
                                <th style="padding: 12px 18px; font-weight: 800;">NISN</th>
                                <th style="padding: 12px 18px; font-weight: 800;">Status Kehadiran</th>
                                <th style="padding: 12px 18px; font-weight: 800;">Dicatat Pada Mapel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaAbsenPerwalianHariIni as $swId => $sAbsen)
                                @php
                                    $stVal = strtolower(trim($sAbsen['status']));
                                    if (str_contains($stVal, 'sakit')) {
                                        $bgSt = '#dbeafe'; $colorSt = '#1d4ed8'; $borderSt = '#bfdbfe';
                                    } elseif (str_contains($stVal, 'izin')) {
                                        $bgSt = '#fef9c3'; $colorSt = '#a16207'; $borderSt = '#fde047';
                                    } elseif (str_contains($stVal, 'dispen')) {
                                        $bgSt = '#f3e8ff'; $colorSt = '#7e22ce'; $borderSt = '#d8b4fe';
                                    } elseif (str_contains($stVal, 'telat') || str_contains($stVal, 'terlambat')) {
                                        $bgSt = '#ffedd5'; $colorSt = '#c2410c'; $borderSt = '#fed7aa';
                                    } else {
                                        $bgSt = '#fee2e2'; $colorSt = '#dc2626'; $borderSt = '#fca5a5';
                                    }
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px 18px; font-weight: 800; color: #0f172a;">{{ $sAbsen['nama'] }}</td>
                                    <td style="padding: 12px 18px; color: #64748b;">{{ $sAbsen['nisn'] }}</td>
                                    <td style="padding: 12px 18px;">
                                        <span style="background: {{ $bgSt }}; color: {{ $colorSt }}; border: 1px solid {{ $borderSt }}; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                            {{ $sAbsen['status'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 18px; color: #475569;">
                                        {{ implode(', ', $sAbsen['mapel_list']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View: Siswa Tidak Hadir -->
                <div class="wali-absen-mobile-cards">
                    @foreach($siswaAbsenPerwalianHariIni as $swId => $sAbsen)
                        @php
                            $stVal = strtolower(trim($sAbsen['status']));
                            if (str_contains($stVal, 'sakit')) {
                                $bgSt = '#dbeafe'; $colorSt = '#1d4ed8'; $borderSt = '#bfdbfe';
                            } elseif (str_contains($stVal, 'izin')) {
                                $bgSt = '#fef9c3'; $colorSt = '#a16207'; $borderSt = '#fde047';
                            } elseif (str_contains($stVal, 'dispen')) {
                                $bgSt = '#f3e8ff'; $colorSt = '#7e22ce'; $borderSt = '#d8b4fe';
                            } elseif (str_contains($stVal, 'telat') || str_contains($stVal, 'terlambat')) {
                                $bgSt = '#ffedd5'; $colorSt = '#c2410c'; $borderSt = '#fed7aa';
                            } else {
                                $bgSt = '#fee2e2'; $colorSt = '#dc2626'; $borderSt = '#fca5a5';
                            }
                        @endphp
                        <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <div style="font-weight: 800; font-size: 13.5px; color: #0f172a;">{{ $sAbsen['nama'] }}</div>
                                <span style="background: {{ $bgSt }}; color: {{ $colorSt }}; border: 1px solid {{ $borderSt }}; font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 6px;">
                                    {{ $sAbsen['status'] }}
                                </span>
                            </div>
                            <div style="font-size: 11.5px; color: #64748b;">
                                NISN: <strong style="color: #334155;">{{ $sAbsen['nisn'] }}</strong>
                            </div>
                            <div style="font-size: 12px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 10px; margin-top: 2px;">
                                <i class="fa-solid fa-book" style="color: #64748b; margin-right: 4px;"></i> Dicatat Pada: <strong>{{ implode(', ', $sAbsen['mapel_list']) }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @else
        {{-- ========================================== --}}
        {{-- TAMPILAN JURNAL MENGAJAR GURU (TAB 'SAYA')  --}}
        {{-- ========================================== --}}
        @if($jadwalsHariIni->isNotEmpty())
        <!-- Alert Box: Pengingat Otomatis -->
        <div class="reminder-banner">
            <div class="reminder-icon">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <div class="reminder-title">Pengingat Otomatis Sistem Jurnal Mengajar</div>
                <div class="reminder-desc">
                    Jurnal hanya dapat diisi saat jam pelajaran berlangsung. Jika 5 menit sebelum jam mengajar berakhir jurnal belum diisi, pengingat otomatis akan ditampilkan pada layar Anda.
                </div>
            </div>
        </div>
        @endif

        @php
            $urgentJadwal = ($selectedJadwal && $selectedJadwal->hampir_habis) ? $selectedJadwal : $jadwalsHariIni->first(fn($j) => $j->hampir_habis);
        @endphp

    @if($urgentJadwal && $urgentJadwal->hampir_habis)
        <div id="urgentReminderAlertBox" data-end-time="{{ $urgentJadwal->waktu_selesai_effective }}" style="background: #fff7ed; border: 2px solid #ea580c; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 6px 20px rgba(234, 88, 12, 0.2); transition: all 0.4s ease;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; animation: pulse 1.5s infinite;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 800; color: #9a3412;">Peringatan 5 Menit Terakhir!</div>
                    <div style="font-size: 13.5px; color: #c2410c; margin-top: 2px;">
                        Jam pelajaran <strong>{{ $urgentJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $urgentJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong><span id="urgentSisaMenitText">{{ $urgentJadwal->sisa_menit_selesai <= 1 ? 'kurang dari 1' : (int)$urgentJadwal->sisa_menit_selesai }}</span> menit lagi</strong> sebelum jam berakhir (Pukul {{ $urgentJadwal->waktu_selesai_effective }} WIB). Mohon segera lengkapi dan simpan Jurnal Mengajar Anda!
                    </div>
                </div>
            </div>
            @if($selectedJadwal && $selectedJadwal->id_jadwal != $urgentJadwal->id_jadwal)
                <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $urgentJadwal->id_jadwal]) }}" style="background: #ea580c; color: #ffffff; font-weight: 800; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-size: 12.5px; white-space: nowrap; box-shadow: 0 2px 8px rgba(234,88,12,0.3); display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Jadwal Ini
                </a>
            @endif
        </div>
        <style>
            @keyframes pulse {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0.4); }
                70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(234, 88, 12, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0); }
            }
        </style>
    @endif

    <!-- Horizontal Scroll: Jadwal Mengajar Hari Ini -->
    <div class="section-subtitle-head">Jadwal Mengajar Hari Ini</div>
    <div class="horizontal-schedule-scroll">
        @forelse($jadwalsHariIni as $j)
            @php
                $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal);
                $isDiisi = $j->isDiisiHariIni();
                $isBerlangsung = $j->is_sedang_berlangsung;
                $isHampir = $isBerlangsung && $j->hampir_habis;
                $isSelesai = $j->is_jam_sudah_selesai;
                $isJadwalIzin = !empty($j->is_guru_izin_hari_ini) && empty($j->is_guru_pengganti);
            @endphp
            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) }}" class="schedule-card-item {{ $isSelected ? 'selected' : '' }}">
                <div class="schedule-card-title">
                    {{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }} {{ $j->kelas->nama_kelas ?? '' }}
                    @if(!empty($j->is_guru_pengganti))
                        <span style="display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #b45309; padding: 2px 6px; border-radius: 6px; margin-left: 4px; border: 1px solid #fde68a;">
                            <i class="fa-solid fa-user-clock"></i> Pengganti
                        </span>
                    @elseif($isJadwalIzin)
                        <span style="display: inline-block; font-size: 10px; font-weight: 800; background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 6px; margin-left: 4px; border: 1px solid #fca5a5;">
                            <i class="fa-solid fa-umbrella-beach"></i> Izin
                        </span>
                    @endif
                </div>
                <div class="schedule-card-meta">
                    {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} · {{ $j->ruangan->nama_ruangan ?? 'Ruang 57' }}
                </div>
                <div class="schedule-card-status">
                    @if($isDiisi)
                        <span style="color: #16a34a; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Sudah Diisi</span>
                    @elseif($isJadwalIzin)
                        @if(!empty($j->penugasan_pengganti_aktif))
                            <span style="color: #2563eb; font-weight: 700;"><i class="fa-solid fa-user-check"></i> Ada Pengganti</span>
                        @else
                            <span style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-lock"></i> Izin (Terkunci)</span>
                        @endif
                    @elseif($isHampir)
                        <span style="color: #dc2626; font-weight: 800; animation: pulse 1.5s infinite;"><i class="fa-solid fa-triangle-exclamation"></i> Segera Isi (Sisa {{ $j->sisa_menit_selesai }}m)</span>
                    @elseif($isBerlangsung)
                        <span style="color: #2563eb; font-weight: 700;"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Sedang Berlangsung</span>
                    @elseif($isSelesai)
                        <span style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-ban"></i> Waktu Habis</span>
                    @else
                        <span style="color: #64748b;"><i class="fa-regular fa-clock"></i> Belum Mulai</span>
                    @endif
                </div>
            </a>
        @empty
            <div style="font-size: 13px; color: #94a3b8;">Tidak ada jadwal mengajar hari ini.</div>
        @endforelse
    </div>

    <!-- Main Full-Width Form Card: Isi Jurnal Mengajar -->
    @if($selectedJadwal)
    <div class="form-jurnal-box">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <span><i class="fa-solid fa-file-pen" style="color: #2563eb; margin-right: 8px;"></i> Isi Jurnal Mengajar: {{ $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</span>
            @if(isset($existingJurnal) && $existingJurnal)
                <span style="font-size: 11.5px; background: {{ $existingJurnal->is_draft ? '#e0f2fe' : '#dcfce7' }}; color: {{ $existingJurnal->is_draft ? '#0369a1' : '#15803d' }}; padding: 4px 12px; border-radius: 20px; font-weight: 800;">
                    {{ $existingJurnal->is_draft ? 'DRAFT TERSIMPAN' : 'JURNAL TERISI' }}
                </span>
            @endif
        </h2>

            @php
                $user = Auth::user();
                $isGuruPengganti = !empty($selectedJadwal->is_guru_pengganti);
                $isAdminPiket = ($user && ($user->isAdmin() || $user->isGuruPiket() || $isGuruPengganti));
                $isSubmittedFinal = (isset($existingJurnal) && $existingJurnal && !$existingJurnal->is_draft);
                $isDraft = (isset($existingJurnal) && $existingJurnal && $existingJurnal->is_draft);
                $isJamSelesai = $selectedJadwal ? $selectedJadwal->is_jam_sudah_selesai : false;
                $isJamStarted = $selectedJadwal ? $selectedJadwal->sudah_masuk_jam : false;
                $isSedangBerlangsung = $selectedJadwal ? $selectedJadwal->is_sedang_berlangsung : false;
                $isHampirHabis = $selectedJadwal ? $selectedJadwal->hampir_habis : false;

                // Inputs and actions can ONLY be modified when lesson is actively ongoing, or by Admin/Piket/Guru Pengganti
                if (!empty($isGuruIzinTidakHadir)) {
                    $canEditInputs = false;
                    $canCancelSubmit = false;
                    $canSubmitOrUpdate = false;
                } else {
                    $canEditInputs = $isAdminPiket || ($isSedangBerlangsung && (!$isSubmittedFinal || $isSedangBerlangsung));
                    $canCancelSubmit = $isSubmittedFinal && ($isSedangBerlangsung || $isAdminPiket);
                    $canSubmitOrUpdate = $isAdminPiket || $isSedangBerlangsung;
                }
            @endphp

            @if(!empty($isGuruIzinTidakHadir))
                <!-- Banner Khusus Guru Sedang Izin Tidak Hadir Resmi Disetujui Pimpinan -->
                <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1.5px solid #ef4444; color: #991b1b; padding: 18px 22px; border-radius: 14px; margin-bottom: 24px; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.08);">
                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                        <div style="background: #ef4444; color: #ffffff; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.35);">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                <div style="font-size: 15px; font-weight: 800; color: #7f1d1d;">
                                    🚫 Akses Pengisian Jurnal Dinonaktifkan: Terdaftar Izin Tidak Hadir Resmi
                                </div>
                                <span style="font-size: 11px; font-weight: 800; background: #fecaca; color: #991b1b; padding: 3px 10px; border-radius: 6px; border: 1px solid #f87171;">
                                    <i class="fa-solid fa-shield-check"></i> Disetujui Pimpinan
                                </span>
                            </div>
                            <div style="font-size: 13px; color: #991b1b; margin-top: 6px; line-height: 1.5;">
                                Anda terdaftar dalam status <strong>Izin Tidak Hadir Resmi ({{ ucfirst($guruIzinRecord->kategori_izin ?? 'Izin') }})</strong> untuk tanggal hari ini ({{ \Carbon\Carbon::parse($todayCarbon->toDateString())->format('d/m/Y') }}). Sesuai alur sistem, Anda tidak dapat mengisi Jurnal Mengajar saat izin tidak hadir berlangsung.
                            </div>
                            @if(!empty($penugasanPenggantiAktif))
                                <div style="margin-top: 10px; padding: 10px 14px; background: #ffffff; border: 1px solid #fca5a5; border-radius: 10px; font-size: 12.5px; color: #7f1d1d; font-weight: 600; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                    <div>
                                        <i class="fa-solid fa-user-check" style="color: #16a34a; margin-right: 5px;"></i>
                                        Jurnal KBM kelas ini telah dialihkan kepada Guru Pengganti: <strong>{{ $penugasanPenggantiAktif->guruPengganti->nama_guru ?? 'Guru Pengganti' }}</strong>
                                    </div>
                                    <span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 10.5px; padding: 2px 8px; border-radius: 20px; font-weight: 700;">Ditugaskan</span>
                                </div>
                            @else
                                <div style="margin-top: 10px; padding: 10px 14px; background: #ffffff; border: 1px solid #fca5a5; border-radius: 10px; font-size: 12.5px; color: #7f1d1d; font-weight: 600;">
                                    <i class="fa-solid fa-clock" style="color: #d97706; margin-right: 5px;"></i>
                                    Pengisian jurnal KBM kelas ini akan diisi oleh Guru Pengganti yang ditugaskan oleh Petugas Piket.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($isGuruPengganti)
                <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1.5px solid #f59e0b; color: #92400e; padding: 16px 18px; border-radius: 14px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.08);">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="background: #f59e0b; color: #ffffff; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                <div style="font-size: 14.5px; font-weight: 800; color: #78350f;">
                                    📌 Penugasan Guru Pengganti (Menggantikan: {{ $selectedJadwal->guru_utama->nama_guru ?? ($selectedJadwal->guru->nama_guru ?? 'Guru Tidak Hadir') }})
                                </div>
                                <span style="font-size: 11px; font-weight: 800; background: #fde68a; color: #b45309; padding: 3px 9px; border-radius: 6px; border: 1px solid #fcd34d;">
                                    <i class="fa-solid fa-id-badge"></i> Guru Pengganti Aktif
                                </span>
                            </div>
                            <div style="font-size: 12.5px; color: #92400e; margin-top: 4px; line-height: 1.5;">
                                Anda ditugaskan oleh Guru Piket untuk menggantikan KBM di kelas <strong>{{ $selectedJadwal->kelas->nama_kelas ?? '-' }}</strong> pada jam ke-<strong>{{ $selectedJadwal->jam_range }}</strong> ({{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB).
                            </div>
                            @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan) || !empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan))
                                <div style="margin-top: 10px; padding: 10px 14px; background: rgba(255, 255, 255, 0.85); border: 1px dashed #f59e0b; border-radius: 10px; font-size: 12px; color: #78350f;">
                                    @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan))
                                        <div style="margin-bottom: 4px;">
                                            <i class="fa-solid fa-book-open" style="color: #d97706; margin-right: 4px;"></i> <strong>Materi Dititipkan:</strong> {{ $selectedJadwal->penugasan_pengganti->materi_dititipkan }}
                                        </div>
                                    @endif
                                    @if(!empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan))
                                        <div>
                                            <i class="fa-solid fa-list-check" style="color: #d97706; margin-right: 4px;"></i> <strong>Tugas Dititipkan:</strong> {{ $selectedJadwal->penugasan_pengganti->tugas_dititipkan }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($isAdminPiket)
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-user-shield" style="font-size: 18px; color: #2563eb;"></i>
                    <span>Mode Pengurus / Guru Piket: Anda memiliki wewenang untuk mengelola jurnal tanpa pembatasan jam pelajaran.</span>
                </div>
            @endif

            @if($isJamSelesai && !$isAdminPiket)
                @if($isSubmittedFinal)
                    <!-- Class Time Ended - Submitted Journal is Locked Final -->
                    <div style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <i class="fa-solid fa-lock" style="font-size: 24px; color: #64748b; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 14.5px; font-weight: 800; color: #1e293b;">Jurnal Terkunci Final (Jam Pelajaran Berakhir)</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #475569; line-height: 1.45;">
                                Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Data Jurnal Mengajar yang telah dikirim sudah <strong>terkunci final</strong> dan tidak dapat diubah atau dibatalkan lagi.
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Class Time Ended - NOT Filled - Locked and Closed -->
                    <div style="background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.08);">
                        <i class="fa-solid fa-ban" style="font-size: 26px; color: #dc2626; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 15px; font-weight: 800; color: #991b1b;">Waktu Pengisian Jurnal Telah Habis</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #b91c1c; line-height: 1.45;">
                                Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Sesuai data alokasi jam KBM dan master jam pelajaran TU, pengisian jurnal tidak dapat dilakukan karena jam pelajaran guru tersebut telah selesai.
                            </div>
                        </div>
                    </div>
                @endif
            @elseif(!$isJamStarted && !$isAdminPiket)
                <!-- Class Time Not Started Yet -->
                <div style="background: #fff7ed; border: 1px solid #fdba74; color: #c2410c; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px;">
                    <i class="fa-solid fa-clock" style="font-size: 24px; color: #ea580c; flex-shrink: 0;"></i>
                    <div>
                        <div style="font-size: 14.5px; font-weight: 800; color: #9a3412;">Jam Pelajaran Belum Dimulai</div>
                        <div style="margin-top: 3px; font-size: 12.5px; color: #c2410c; line-height: 1.45;">
                            Fitur isi jurnal untuk jam pelajaran ini belum dapat diisi. Pengisian jurnal baru dibuka dan dapat diisi saat jam pelajaran guru berlangsung (Pukul <strong>{{ $selectedJadwal->waktu_mulai_effective ?? '00:00' }} - {{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>).
                        </div>
                    </div>
                </div>
            @elseif($isSedangBerlangsung)
                @if($isHampirHabis)
                    <!-- 5-Minute Pre-Expiry Warning Banner -->
                    <div style="background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; animation: pulse 1.5s infinite;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 26px; color: #dc2626; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 15px; font-weight: 800; color: #991b1b;">Peringatan: Sisa Waktu {{ $selectedJadwal->sisa_menit_selesai }} Menit Lagi!</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #b91c1c; line-height: 1.45;">
                                Jam pelajaran akan berakhir pukul <strong>{{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>. Harap segera melengkapi materi dan absensi siswa lalu klik <strong>Simpan Jurnal</strong> sebelum waktu KBM habis dan fitur isi jurnal terkunci!
                            </div>
                        </div>
                    </div>
                @elseif($isSubmittedFinal)
                    <!-- Class Time Ongoing - Submitted Journal can be edited or cancelled -->
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 20px; color: #16a34a; flex-shrink: 0;"></i>
                        <span>Jurnal Mengajar telah dikirim. Selama jam pelajaran masih berlangsung (s/d Pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>), Anda masih dapat memperbarui isian atau membatalkan pengiriman jurnal.</span>
                    </div>
                @elseif($isDraft)
                    <!-- Draft Saved -->
                    <div style="background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-bookmark" style="font-size: 20px; color: #0284c7; flex-shrink: 0;"></i>
                        <span>Jurnal Mengajar saat ini tersimpan sebagai Draft. Silakan lengkapi isian di bawah ini lalu klik <strong>Simpan Jurnal</strong> untuk mengirim secara resmi.</span>
                    </div>
                @else
                    <!-- Ongoing fresh form -->
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-chalkboard-user" style="font-size: 20px; color: #2563eb; flex-shrink: 0;"></i>
                        <span>Jam pelajaran sedang berlangsung (<strong>{{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>). Silakan isi absensi kelas dan materi pembelajaran.</span>
                    </div>
                @endif
            @endif

            <form method="POST" action="{{ route('guru.jurnal-harian.store') }}">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal ?? 1 }}">
                <input type="hidden" name="tanggal" value="{{ $todayDate ?? date('Y-m-d') }}">

                @php
                    $valTanggal = $todayCarbon ? $todayCarbon->format('d/m/Y') : date('d/m/Y');
                    $valWaktu = ($selectedJadwal && $selectedJadwal->waktu_mulai_effective && $selectedJadwal->waktu_selesai_effective) 
                        ? str_replace(':', '.', $selectedJadwal->waktu_mulai_effective) . ' - ' . str_replace(':', '.', $selectedJadwal->waktu_selesai_effective) 
                        : '-';
                    $valJam = $selectedJadwal ? $selectedJadwal->jam_range : '-';
                    $valKelas = $selectedJadwal->kelas->nama_kelas ?? '-';
                    $valMapel = $selectedJadwal->mapel->nama_mapel ?? '-';
                @endphp

                <!-- Data Jadwal & Jam Pelajaran (Terhubung dengan Master Jadwal TU & Jam Pelajaran - Readonly) -->
                <div class="schedule-info-grid">
                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Tanggal</label>
                        <div class="input-readonly-wrapper">
                            <input type="text" class="input-readonly-field" value="{{ $valTanggal }}" readonly style="padding-right: 38px;">
                            <span class="input-readonly-icon"><i class="fa-regular fa-calendar-days"></i></span>
                        </div>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Waktu</label>
                        <input type="text" class="input-readonly-field" value="{{ $valWaktu }}" readonly>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Jam Pelajaran</label>
                        <input type="text" class="input-readonly-field" value="{{ $valJam }}" readonly>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Kelas</label>
                        <div class="input-readonly-wrapper">
                            <input type="text" class="input-readonly-field" value="{{ $valKelas }}" readonly style="padding-right: 34px;">
                            <span class="input-readonly-icon"><i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group-custom" style="margin-bottom: 18px;">
                    <label class="form-label-custom">Mata Pelajaran</label>
                    <input type="text" class="input-readonly-field" value="{{ $valMapel }}" readonly>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px;" class="form-materi-grid">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Materi yang diajarkan</label>
                        @php
                            $defaultMateri = $existingJurnal->materi ?? ($selectedJadwal->penugasan_pengganti->materi_dititipkan ?? '');
                        @endphp
                        <input type="text" name="materi" class="input-field-custom" placeholder="Contoh: Pembahasan Database & Query SQL" required value="{{ old('materi', $defaultMateri) }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Pertemuan ke-</label>
                        <input type="text" name="pertemuan_ke" class="input-field-custom" placeholder="Ke-1" value="{{ old('pertemuan_ke', $existingJurnal->pertemuan_ke ?? $autoPertemuanKe ?? 'Ke-1') }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Catatan kelas</label>
                    @php
                        $defaultCatatan = $existingJurnal->catatan ?? '';
                        if (empty($defaultCatatan) && !empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan)) {
                            $defaultCatatan = 'Tugas yang dititipkan: ' . $selectedJadwal->penugasan_pengganti->tugas_dititipkan;
                        }
                    @endphp
                    <textarea name="catatan" rows="3" class="input-field-custom" placeholder="Catatan aktivitas pembelajaran atau respon siswa di kelas..." {{ !$canEditInputs ? 'disabled' : '' }}>{{ old('catatan', $defaultCatatan) }}</textarea>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Kondisi kelas</label>
                    @php
                        $curKondisi = old('kondisi_kelas', $existingJurnal->kondisi_kelas ?? 'Kondusif');
                    @endphp
                    <div class="condition-pills">
                        <input type="radio" name="kondisi_kelas" id="k1" value="Kondusif" class="condition-pill-input" {{ $curKondisi === 'Kondusif' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k1" class="condition-pill-label">Kondusif</label>

                        <input type="radio" name="kondisi_kelas" id="k2" value="Cukup ramai" class="condition-pill-input" {{ $curKondisi === 'Cukup ramai' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k2" class="condition-pill-label">Cukup ramai</label>

                        <input type="radio" name="kondisi_kelas" id="k3" value="Perlu Perhatian" class="condition-pill-input" {{ $curKondisi === 'Perlu Perhatian' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k3" class="condition-pill-label">Perlu Perhatian</label>
                    </div>
                </div>

                <!-- Foto Kehadiran (Wajib Live) -->
                @php
                    $existingPhotoUrl = $existingJurnal->dokumentasi_url ?? null;
                @endphp
                <div class="camera-upload-container">
                    <label class="form-label-custom" style="font-size: 13.5px; font-weight: 800; color: #1e293b; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span>Foto Kehadiran (wajib live)</span>
                        @if($existingPhotoUrl)
                            <span style="font-size: 11px; font-weight: 700; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">
                                <i class="fa-solid fa-circle-check"></i> Foto Tersimpan
                            </span>
                        @else
                            <span style="font-size: 11px; font-weight: 700; color: #b91c1c; background: #fee2e2; padding: 2px 8px; border-radius: 6px;">
                                <i class="fa-solid fa-camera"></i> Live Kamera
                            </span>
                        @endif
                    </label>

                    <!-- Hidden Inputs for Form Submission -->
                    <input type="hidden" name="foto_kehadiran_kamera" id="inputFotoKehadiranKamera" value="">
                    <input type="hidden" name="hapus_dokumentasi" id="inputHapusDokumentasi" value="0">
                    <input type="file" id="fallbackDirectCameraInput" accept="image/*" capture="environment" style="display: none;" onchange="handleFallbackCameraFile(event)">
                    <canvas id="liveCameraCanvas" style="display: none;"></canvas>

                    <!-- State 1: Placeholder Click Box (Matches Screenshot) -->
                    <div id="cameraPlaceholderBox" class="camera-box-placeholder" onclick="{{ $canEditInputs ? 'startLiveCamera()' : '' }}" style="{{ $existingPhotoUrl ? 'display: none;' : '' }} {{ !$canEditInputs ? 'cursor: not-allowed; opacity: 0.7;' : '' }}">
                        <div class="camera-icon-circle">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <div style="font-size: 13.5px; font-weight: 800; color: #334155;">
                            {{ $canEditInputs ? 'Buka Kamera untuk Mengambil Foto Kehadiran' : 'Foto Kehadiran Belum Diunggah' }}
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: -6px;">
                            {{ $canEditInputs ? 'Klik untuk mengaktifkan akses kamera live (Wajib live kamera saat KBM)' : 'Pengisian foto hanya dapat dilakukan saat jam pelajaran berlangsung' }}
                        </div>
                    </div>

                    <!-- State 2: Live Viewfinder Camera Stream -->
                    <div id="cameraViewfinderBox" class="camera-viewfinder-wrapper" style="display: none;">
                        <div class="shutter-flash" id="cameraShutterFlash"></div>
                        <div class="camera-live-badge">
                            <span class="live-dot"></span> LIVE KAMERA
                        </div>

                        <video id="liveCameraVideo" autoplay playsinline class="camera-video-stream"></video>

                        <div class="camera-controls-bar">
                            <button type="button" class="btn-camera-opt" onclick="switchLiveCamera()" title="Ganti Kamera (Depan / Belakang)">
                                <i class="fa-solid fa-camera-rotate"></i>
                            </button>

                            <button type="button" class="btn-snap-photo" onclick="snapLivePhoto()" title="Jepret Foto Kehadiran">
                                <i class="fa-solid fa-circle-dot" style="font-size: 18px;"></i> Jepret Foto
                            </button>

                            <button type="button" class="btn-camera-opt" onclick="stopLiveCamera()" style="background: rgba(220, 38, 38, 0.85);" title="Batal / Tutup Kamera">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <!-- State 3: Captured Photo / Existing Photo Preview -->
                    <div id="cameraPreviewBox" class="camera-preview-container" style="{{ $existingPhotoUrl ? 'display: flex;' : 'display: none;' }}">
                        <div class="camera-preview-img-wrapper">
                            <img id="previewFotoKehadiranImg" src="{{ $existingPhotoUrl ?? '' }}" alt="Foto Kehadiran" class="camera-preview-img">
                            <div class="camera-preview-meta" id="previewFotoKehadiranMeta">
                                <i class="fa-solid fa-check-circle" style="color: #22c55e;"></i>
                                <span id="previewFotoKehadiranTimestamp">{{ $existingPhotoUrl ? 'Foto Kehadiran KBM Tersimpan' : 'Foto Baru Berhasil Dijepret' }}</span>
                            </div>
                        </div>

                        @if($canEditInputs)
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; margin-top: 4px;">
                                <button type="button" onclick="startLiveCamera()" class="btn-draft" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 12px; padding: 7px 14px; border-radius: 8px; font-weight: 700;">
                                    <i class="fa-solid fa-camera-rotate"></i> Ambil Ulang Foto Live
                                </button>
                                <button type="button" onclick="removeLivePhoto()" class="btn-draft" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; font-size: 12px; padding: 7px 14px; border-radius: 8px; font-weight: 700;">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Foto
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Presensi Ketidakhadiran Siswa (Full Height / Tanpa Pembatasan Scroll) -->
                <div style="margin-top: 28px; padding-top: 24px; border-top: 1px dashed #cbd5e1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label class="form-label-custom" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">
                                <i class="fa-solid fa-users-viewfinder" style="color: #2563eb; margin-right: 6px;"></i> Presensi Ketidakhadiran Siswa
                            </label>
                            <div style="font-size: 12px; color: #64748b; font-weight: 500;">
                                Tandai status <strong>Sakit</strong>, <strong>Izin</strong>, atau <strong>Alpa</strong> jika ada siswa yang tidak hadir. Siswa yang hadir tetap berstatus Hadir.
                            </div>
                        </div>
                        <!-- Control Bar: Reset Kehadiran Button -->
                        @if($canEditInputs)
                            <button type="button" onclick="resetAllAbsensiToHadir()" class="btn-draft" style="background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; font-size: 12.5px; padding: 8px 16px; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" title="Setel Ulang Semua Status Kehadiran Siswa ke Hadir (Default)">
                                <i class="fa-solid fa-rotate-left"></i> Reset Status Kehadiran
                            </button>
                        @endif
                    </div>

                    @php
                        $totalSiswaTelatDiKelas = count($siswaTelatMap ?? []);
                        $totalSiswaDispenDiKelas = count(array_filter($lockedAbsensiMap ?? [], fn($x) => $x['status'] === 'Dispen'));
                        $totalSiswaSakitDiKelas = count(array_filter($lockedAbsensiMap ?? [], fn($x) => $x['status'] === 'Sakit'));
                        $totalSiswaIzinDiKelas = count(array_filter($lockedAbsensiMap ?? [], fn($x) => $x['status'] === 'Izin'));
                    @endphp
                    @if($totalSiswaDispenDiKelas > 0)
                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; color: #6b21a8; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-file-signature" style="color: #9333ea; font-size: 16px; flex-shrink: 0;"></i>
                            <span>Pemberitahuan Waka Kesiswaan & Guru Piket: Terdapat <strong>{{ $totalSiswaDispenDiKelas }} siswa dispensasi resmi</strong> pada jam pelajaran ini. Status <em>Dispen</em> telah otomatis disematkan dan dikunci oleh sistem (tidak bisa diedit guru).</span>
                        </div>
                    @endif
                    @if(($totalSiswaSakitDiKelas + $totalSiswaIzinDiKelas) > 0)
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-file-medical" style="color: #2563eb; font-size: 16px; flex-shrink: 0;"></i>
                            <span>Pemberitahuan Guru Piket: Terdapat <strong>{{ ($totalSiswaSakitDiKelas + $totalSiswaIzinDiKelas) }} siswa berhalangan hadir</strong> (Sakit: {{ $totalSiswaSakitDiKelas }}, Izin: {{ $totalSiswaIzinDiKelas }}) dalam Surat Izin Siswa. Status telah otomatis terisi dan dikunci oleh sistem (tidak bisa diedit guru).</span>
                        </div>
                    @endif
                    @if($totalSiswaTelatDiKelas > 0)
                        <div style="background: #fff7ed; border: 1px solid #fed7aa; color: #c2410c; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-circle-exclamation" style="color: #ea580c; font-size: 16px; flex-shrink: 0;"></i>
                            <span>Pemberitahuan Guru Piket: Terdapat <strong>{{ $totalSiswaTelatDiKelas }} siswa terlambat</strong> pada hari ini. Keterangan <em>(Siswa Tersebut Telat)</em> telah disematkan otomatis pada baris siswa terkait.</span>
                        </div>
                    @endif

                    <!-- Search Bar & Filter Controls -->
                    <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                            <input type="text" id="searchSiswaInput" placeholder="Cari nama atau NISN siswa di kelas ini..." onkeyup="filterSiswaTable()" class="input-field-custom" style="padding: 10px 14px 10px 40px; font-size: 13px; border-radius: 10px; background: #ffffff;">
                        </div>
                        <button type="button" onclick="resetSiswaSearch()" class="btn-draft" style="padding: 10px 16px; font-size: 12.5px; border-radius: 10px; font-weight: 700; background: #f8fafc; border: 1px solid #cbd5e1; color: #475569;" title="Reset Kata Kunci Pencarian">
                            <i class="fa-solid fa-xmark"></i> Reset Cari
                        </button>
                    </div>

                    <div style="border: 1.5px solid #cbd5e1; border-radius: 14px; background: #ffffff; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: 0 2px 8px rgba(0,0,0,0.02); width: 100%;">
                        <table style="width: 100%; min-width: 680px; border-collapse: collapse; font-size: 13.5px;" id="tableAbsensiSiswa">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; letter-spacing: 0.5px;">
                                    <th style="padding: 14px 20px; background: #f8fafc; font-weight: 800;">Nama Siswa & Keterangan</th>
                                    <th style="padding: 14px 20px; text-align: right; background: #f8fafc; font-weight: 800;">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $sw)
                                    @php
                                        $swId = $sw->id_siswa;
                                        $lockedInfo = $lockedAbsensiMap[$swId] ?? null;
                                        $isLocked = !empty($lockedInfo);
                                        $lockedStatus = $isLocked ? $lockedInfo['status'] : null;

                                        $hasTelat = isset($siswaTelatMap[$swId]);
                                        $telatInfo = $hasTelat ? $siswaTelatMap[$swId] : null;

                                        if ($isLocked) {
                                            $currentStatus = $lockedStatus;
                                        } else {
                                            $currentStatus = $existingAbsensi[$swId] ?? 'Hadir';
                                            if ($currentStatus === 'Dispen') {
                                                $currentStatus = 'Hadir'; // Dispen tidak bisa diisi manual guru
                                            }
                                        }
                                        $currentCatatan = $existingCatatan[$swId] ?? '';
                                    @endphp
                                    <tr class="siswa-row-item" data-id="{{ $swId }}" data-nama="{{ strtolower($sw->nama_siswa) }}" data-nisn="{{ strtolower($sw->nisn ?? '') }}" data-locked="{{ $isLocked ? 'true' : 'false' }}" data-locked-status="{{ $lockedStatus ?? '' }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease; {{ $isLocked && $lockedStatus === 'Dispen' ? 'background: #faf5ff;' : ($isLocked && $lockedStatus === 'Sakit' ? 'background: #eff6ff;' : ($isLocked && $lockedStatus === 'Izin' ? 'background: #fefce8;' : ($hasTelat ? 'background: #fff7ed;' : ''))) }}">
                                        <td style="padding: 14px 20px; color: #0f172a; vertical-align: middle;">
                                            <div style="font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span>{{ $sw->nama_siswa }}</span>

                                                @if($isLocked)
                                                    @if($lockedStatus === 'Sakit')
                                                        <span style="font-size: 11px; background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="{{ $lockedInfo['badge_title'] }} &bull; Alasan: {{ $lockedInfo['alasan'] }}">
                                                            <i class="fa-solid fa-lock" style="color: #2563eb; font-size: 10px;"></i>
                                                            <i class="fa-solid fa-file-medical" style="color: #2563eb;"></i>
                                                            <span>Sakit Terverifikasi (Guru Piket)</span>
                                                        </span>
                                                    @elseif($lockedStatus === 'Izin')
                                                        <span style="font-size: 11px; background: #fef9c3; color: #a16207; border: 1px solid #fde047; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="{{ $lockedInfo['badge_title'] }} &bull; Alasan: {{ $lockedInfo['alasan'] }}">
                                                            <i class="fa-solid fa-lock" style="color: #ca8a04; font-size: 10px;"></i>
                                                            <i class="fa-solid fa-envelope-open-text" style="color: #ca8a04;"></i>
                                                            <span>Izin Terverifikasi (Guru Piket)</span>
                                                        </span>
                                                    @elseif($lockedStatus === 'Dispen')
                                                        <span style="font-size: 11px; background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="{{ $lockedInfo['badge_title'] }} &bull; Alasan: {{ $lockedInfo['alasan'] }}">
                                                            <i class="fa-solid fa-lock" style="color: #9333ea; font-size: 10px;"></i>
                                                            <i class="fa-solid fa-file-circle-check" style="color: #9333ea;"></i>
                                                            <span>{{ $lockedInfo['source'] === 'surat_izin' ? 'Dispen Luar Sekolah (Guru Piket)' : 'Dispen Disetujui Waka Kesiswaan' . $lockedInfo['jam'] }}</span>
                                                        </span>
                                                    @endif
                                                @endif

                                                @if($hasTelat)
                                                    <span style="font-size: 11px; background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="Siswa Tersebut Telat (Jam {{ $telatInfo['jam_terlambat'] }} WIB) &bull; Alasan: {{ $telatInfo['alasan'] }}">
                                                        <i class="fa-solid fa-user-clock" style="color: #ea580c;"></i> (Siswa Tersebut Telat - Jam {{ $telatInfo['jam_terlambat'] }} WIB)
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="font-size: 11.5px; color: #64748b; font-weight: normal; margin-top: 3px; display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
                                                <span>NISN: <strong>{{ $sw->nisn ?? '-' }}</strong></span>
                                                @if($isLocked && !empty($lockedInfo['alasan']))
                                                    <span style="color: {{ $lockedStatus === 'Dispen' ? '#7e22ce' : ($lockedStatus === 'Sakit' ? '#1d4ed8' : '#a16207') }}; font-weight: 600;">
                                                        &bull; Keterangan: <em>{{ Str::limit($lockedInfo['alasan'], 50) }}</em>
                                                    </span>
                                                @endif
                                                @if($isLocked && !empty($lockedInfo['rentang']))
                                                    <span style="font-size: 10.5px; background: #f1f5f9; color: #475569; padding: 1px 6px; border-radius: 4px; font-weight: 600;">
                                                        {{ $lockedInfo['rentang'] }}
                                                    </span>
                                                @endif
                                                @if($hasTelat && !empty($telatInfo['alasan']))
                                                    <span style="color: #c2410c; font-weight: 600;">
                                                        &bull; Alasan Keterlambatan: <em>{{ Str::limit($telatInfo['alasan'], 45) }}</em>
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Catatan / Keterangan Siswa Preview --}}
                                            <div id="catatan_preview_{{ $swId }}" class="catatan-preview-box" style="{{ !empty($currentCatatan) ? 'display: inline-flex;' : 'display: none;' }}">
                                                <i class="fa-regular fa-note-sticky" style="color: #4f46e5;"></i>
                                                <span>Keterangan: <strong id="catatan_text_{{ $swId }}">{{ $currentCatatan }}</strong></span>
                                            </div>
                                        </td>
                                        <td style="padding: 14px 20px; text-align: right; vertical-align: middle;">
                                            <div style="display: inline-flex; gap: 8px; font-size: 12px; font-weight: 700; flex-wrap: nowrap; justify-content: flex-end; align-items: center;">
                                                {{-- Pill Hadir --}}
                                                <label class="status-radio-pill pill-hadir" style="{{ ($isLocked || !$canEditInputs) ? 'opacity: 0.35; cursor: not-allowed; pointer-events: none;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Hadir')" {{ ($isLocked || !$canEditInputs) ? 'disabled' : '' }}>
                                                    <span>Hadir</span>
                                                </label>

                                                {{-- Pill Sakit --}}
                                                <label class="status-radio-pill pill-sakit {{ ($isLocked && $lockedStatus === 'Sakit') ? 'locked-active' : '' }}" style="{{ ($isLocked && $lockedStatus !== 'Sakit') ? 'opacity: 0.35; cursor: not-allowed; pointer-events: none;' : (($isLocked && $lockedStatus === 'Sakit') ? 'cursor: not-allowed;' : '') }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Sakit')" {{ ($isLocked || !$canEditInputs) ? 'disabled' : '' }}>
                                                    <span>Sakit</span>
                                                    @if($isLocked && $lockedStatus === 'Sakit')
                                                        <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 3px;" title="Terkunci: Data Sakit resmi dari Guru Piket"></i>
                                                    @endif
                                                </label>

                                                {{-- Pill Izin --}}
                                                <label class="status-radio-pill pill-izin {{ ($isLocked && $lockedStatus === 'Izin') ? 'locked-active' : '' }}" style="{{ ($isLocked && $lockedStatus !== 'Izin') ? 'opacity: 0.35; cursor: not-allowed; pointer-events: none;' : (($isLocked && $lockedStatus === 'Izin') ? 'cursor: not-allowed;' : '') }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Izin')" {{ ($isLocked || !$canEditInputs) ? 'disabled' : '' }}>
                                                    <span>Izin</span>
                                                    @if($isLocked && $lockedStatus === 'Izin')
                                                        <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 3px;" title="Terkunci: Data Izin resmi dari Guru Piket"></i>
                                                    @endif
                                                </label>

                                                {{-- Pill Alpa --}}
                                                <label class="status-radio-pill pill-alpa" style="{{ ($isLocked || !$canEditInputs) ? 'opacity: 0.35; cursor: not-allowed; pointer-events: none;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Alpa')" {{ ($isLocked || !$canEditInputs) ? 'disabled' : '' }}>
                                                    <span>Alpa</span>
                                                </label>

                                                {{-- Pill Dispen (Terkunci untuk guru, hanya aktif jika memiliki persetujuan resmi) --}}
                                                <label class="status-radio-pill pill-dispen locked {{ ($isLocked && $lockedStatus === 'Dispen') ? 'locked-active' : '' }}" style="{{ ($isLocked && $lockedStatus === 'Dispen') ? 'cursor: not-allowed;' : 'opacity: 0.4; cursor: not-allowed;' }}" title="{{ ($isLocked && $lockedStatus === 'Dispen') ? ($lockedInfo['badge_title'] ?? 'Dispensasi Resmi') : 'Opsi Dispen terisi otomatis dari Dispensasi Waka Kesiswaan atau Dispen Luar Sekolah Guru Piket (Fitur Dispen tidak bisa diisi guru)' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Dispen" {{ $currentStatus === 'Dispen' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Dispen')" disabled>
                                                    <span>Dispen</span>
                                                    <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 2px;"></i>
                                                </label>

                                                {{-- Tombol Keterangan Presensi Siswa (Tepat di sebelah kanan Dispen) --}}
                                                <button type="button" 
                                                        class="btn-catatan-presensi {{ !empty($currentCatatan) ? 'has-catatan' : '' }}" 
                                                        id="btn_catatan_{{ $swId }}" 
                                                        onclick="openModalCatatanSiswa({{ $swId }}, '{{ addslashes($sw->nama_siswa) }}', '{{ $sw->nisn ?? '-' }}', '{{ $isLocked ? $lockedStatus : '' }}')" 
                                                        title="{{ !empty($currentCatatan) ? 'Keterangan: ' . e($currentCatatan) : 'Tambah Keterangan Presensi Siswa' }}"
                                                        {{ !$canEditInputs ? 'disabled' : '' }}>
                                                    <i class="fa-regular fa-note-sticky"></i>
                                                    <span>Keterangan</span>
                                                    <span class="catatan-indicator-badge" id="badge_catatan_{{ $swId }}" style="{{ !empty($currentCatatan) ? 'display: inline-flex;' : 'display: none;' }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </span>
                                                </button>
                                            </div>
                                            <div id="absence_input_wrap_{{ $swId }}">
                                                @if(in_array($currentStatus, ['Sakit', 'Izin', 'Alpa', 'Dispen']))
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][id_siswa]" value="{{ $swId }}">
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][keterangan]" value="{{ $currentStatus }}">
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][catatan]" value="{{ $currentCatatan }}" id="hidden_catatan_item_{{ $swId }}">
                                                @endif
                                            </div>
                                            <input type="hidden" name="catatan_siswa[{{ $swId }}]" id="global_catatan_{{ $swId }}" value="{{ $currentCatatan }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 24px; text-align: center; color: #94a3b8;">Daftar siswa di kelas ini tidak tersedia.</td>
                                    </tr>
                                @endforelse
                                <tr id="noSiswaMatchNotice" style="display: none;">
                                    <td colspan="2" style="padding: 24px; text-align: center; color: #64748b; font-size: 13px;">
                                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 6px; color: #94a3b8;"></i> Tidak ada siswa yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    function escapeHtmlAttr(str) {
                        if (!str) return '';
                        return String(str)
                            .replace(/&/g, '&amp;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&#39;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;');
                    }

                    function toggleAbsenceInput(idSiswa, status) {
                        const wrap = document.getElementById('absence_input_wrap_' + idSiswa);
                        const globalCat = document.getElementById('global_catatan_' + idSiswa);
                        const curCat = (window.siswaCatatanMap && typeof window.siswaCatatanMap[idSiswa] !== 'undefined')
                            ? window.siswaCatatanMap[idSiswa]
                            : (globalCat ? globalCat.value : '');

                        if (!wrap) return;
                        if (status === 'Hadir') {
                            wrap.innerHTML = '';
                        } else {
                            wrap.innerHTML = '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][id_siswa]" value="' + idSiswa + '">' +
                                             '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][keterangan]" value="' + status + '">' +
                                             '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][catatan]" value="' + escapeHtmlAttr(curCat) + '" id="hidden_catatan_item_' + idSiswa + '">';
                        }
                    }

                    function filterSiswaTable() {
                        const input = document.getElementById('searchSiswaInput');
                        if (!input) return;
                        const query = input.value.toLowerCase().trim();
                        const rows = document.querySelectorAll('.siswa-row-item');
                        let foundCount = 0;

                        rows.forEach(row => {
                            const name = row.getAttribute('data-nama') || '';
                            const nisn = row.getAttribute('data-nisn') || '';
                            if (name.includes(query) || nisn.includes(query)) {
                                row.style.display = '';
                                foundCount++;
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        const notice = document.getElementById('noSiswaMatchNotice');
                        if (notice) {
                            notice.style.display = (foundCount === 0 && rows.length > 0) ? '' : 'none';
                        }
                    }

                    function resetSiswaSearch() {
                        const input = document.getElementById('searchSiswaInput');
                        if (input) {
                            input.value = '';
                            filterSiswaTable();
                        }
                    }

                    function resetAllAbsensiToHadir() {
                        const rows = document.querySelectorAll('.siswa-row-item');
                        rows.forEach(row => {
                            const isLocked = row.getAttribute('data-locked') === 'true';
                            if (isLocked) return; // Status resmi Sakit, Izin, atau Dispen TIDAK BOLEH di-reset!

                            const swId = row.getAttribute('data-id');
                            const hadirRadio = row.querySelector('input[type="radio"][value="Hadir"]');
                            if (hadirRadio && !hadirRadio.disabled) {
                                hadirRadio.checked = true;
                                toggleAbsenceInput(swId, 'Hadir');
                            }
                        });
                    }

                    /* === LIVE CAMERA SCRIPTS === */
                    let currentCameraStream = null;
                    let currentFacingMode = 'environment'; // default rear camera for classroom

                    async function startLiveCamera() {
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const preview = document.getElementById('cameraPreviewBox');
                        const video = document.getElementById('liveCameraVideo');

                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            triggerFallbackDirectCamera();
                            return;
                        }

                        try {
                            if (currentCameraStream) {
                                currentCameraStream.getTracks().forEach(track => track.stop());
                            }

                            const constraints = {
                                video: {
                                    facingMode: { ideal: currentFacingMode },
                                    width: { ideal: 1280 },
                                    height: { ideal: 720 }
                                },
                                audio: false
                            };

                            const stream = await navigator.mediaDevices.getUserMedia(constraints);
                            currentCameraStream = stream;
                            if (video) {
                                video.srcObject = stream;
                                await video.play();
                            }

                            if (placeholder) placeholder.style.display = 'none';
                            if (preview) preview.style.display = 'none';
                            if (viewfinder) viewfinder.style.display = 'block';

                            if (video) {
                                video.style.transform = (currentFacingMode === 'user') ? 'scaleX(-1)' : 'scaleX(1)';
                            }
                        } catch (err) {
                            console.warn('getUserMedia camera error / fallback to direct camera:', err);
                            triggerFallbackDirectCamera();
                        }
                    }

                    function stopLiveCamera() {
                        if (currentCameraStream) {
                            currentCameraStream.getTracks().forEach(track => track.stop());
                            currentCameraStream = null;
                        }
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const preview = document.getElementById('cameraPreviewBox');
                        const previewImg = document.getElementById('previewFotoKehadiranImg');

                        if (viewfinder) viewfinder.style.display = 'none';
                        if (previewImg && previewImg.src && previewImg.src !== '' && previewImg.src !== window.location.href) {
                            if (preview) preview.style.display = 'flex';
                            if (placeholder) placeholder.style.display = 'none';
                        } else {
                            if (placeholder) placeholder.style.display = 'flex';
                            if (preview) preview.style.display = 'none';
                        }
                    }

                    async function switchLiveCamera() {
                        currentFacingMode = (currentFacingMode === 'environment') ? 'user' : 'environment';
                        await startLiveCamera();
                    }

                    function snapLivePhoto() {
                        const video = document.getElementById('liveCameraVideo');
                        const canvas = document.getElementById('liveCameraCanvas');
                        const flash = document.getElementById('cameraShutterFlash');
                        const previewImg = document.getElementById('previewFotoKehadiranImg');
                        const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                        const inputHapus = document.getElementById('inputHapusDokumentasi');
                        const timestampSpan = document.getElementById('previewFotoKehadiranTimestamp');

                        if (!video || !canvas) return;

                        // Shutter flash effect
                        if (flash) {
                            flash.classList.add('active');
                            setTimeout(() => flash.classList.remove('active'), 180);
                        }

                        const width = video.videoWidth || 1280;
                        const height = video.videoHeight || 720;
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        if (currentFacingMode === 'user') {
                            ctx.translate(width, 0);
                            ctx.scale(-1, 1);
                        }
                        ctx.drawImage(video, 0, 0, width, height);

                        // Export high-quality JPEG Data URL
                        const photoDataUrl = canvas.toDataURL('image/jpeg', 0.88);

                        if (inputHidden) inputHidden.value = photoDataUrl;
                        if (inputHapus) inputHapus.value = '0';
                        if (previewImg) previewImg.src = photoDataUrl;

                        const now = new Date();
                        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if (timestampSpan) {
                            timestampSpan.textContent = `Foto Live Berhasil Dijepret (${timeStr} WIB)`;
                        }

                        // Stop video stream and show photo preview
                        if (currentCameraStream) {
                            currentCameraStream.getTracks().forEach(track => track.stop());
                            currentCameraStream = null;
                        }
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const preview = document.getElementById('cameraPreviewBox');

                        if (viewfinder) viewfinder.style.display = 'none';
                        if (placeholder) placeholder.style.display = 'none';
                        if (preview) preview.style.display = 'flex';
                    }

                    function removeLivePhoto() {
                        if (confirm('Apakah Anda yakin ingin menghapus foto kehadiran ini?')) {
                            const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                            const inputHapus = document.getElementById('inputHapusDokumentasi');
                            const previewImg = document.getElementById('previewFotoKehadiranImg');
                            const preview = document.getElementById('cameraPreviewBox');
                            const placeholder = document.getElementById('cameraPlaceholderBox');

                            if (inputHidden) inputHidden.value = '';
                            if (inputHapus) inputHapus.value = '1';
                            if (previewImg) previewImg.src = '';
                            if (preview) preview.style.display = 'none';
                            if (placeholder) placeholder.style.display = 'flex';
                        }
                    }

                    function triggerFallbackDirectCamera() {
                        const fileInput = document.getElementById('fallbackDirectCameraInput');
                        if (fileInput) {
                            fileInput.click();
                        }
                    }

                    function handleFallbackCameraFile(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const photoDataUrl = e.target.result;
                            const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                            const inputHapus = document.getElementById('inputHapusDokumentasi');
                            const previewImg = document.getElementById('previewFotoKehadiranImg');
                            const timestampSpan = document.getElementById('previewFotoKehadiranTimestamp');
                            const placeholder = document.getElementById('cameraPlaceholderBox');
                            const viewfinder = document.getElementById('cameraViewfinderBox');
                            const preview = document.getElementById('cameraPreviewBox');

                            if (inputHidden) inputHidden.value = photoDataUrl;
                            if (inputHapus) inputHapus.value = '0';
                            if (previewImg) previewImg.src = photoDataUrl;
                            
                            if (timestampSpan) {
                                timestampSpan.textContent = 'Foto Kamera Terunggah';
                            }

                            if (placeholder) placeholder.style.display = 'none';
                            if (viewfinder) viewfinder.style.display = 'none';
                            if (preview) preview.style.display = 'flex';
                        };
                        reader.readAsDataURL(file);
                    }
                </script>

                <div class="form-actions-row" style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                    @if(!empty($isGuruIzinTidakHadir))
                        <div style="padding: 10px 18px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; color: #991b1b; font-size: 13px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-ban" style="color: #dc2626;"></i> Pengisian Dinonaktifkan (Sedang Izin Tidak Hadir Resmi)
                        </div>
                    @else
                        @if($canCancelSubmit)
                            <!-- Batal Kirim Jurnal Button (Triggers standalone form outside main form) -->
                            <button type="button" onclick="confirmBatalKirimJurnal()" class="btn-draft" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; font-weight: 800; padding: 10px 18px; border-radius: 10px; cursor: pointer; transition: all 0.15s ease;" title="Batalkan pengiriman jurnal dan kembalikan ke status Belum Diisi (Hanya aktif selama jam pelajaran berlangsung)">
                                <i class="fa-solid fa-rotate-left"></i> Batal Kirim Jurnal
                            </button>
                        @endif

                        @if($canSubmitOrUpdate)
                            <button type="submit" name="action" value="draft" class="btn-draft">
                                <i class="fa-regular fa-bookmark"></i> Simpan Draft
                            </button>

                            <button type="submit" name="action" value="save" class="btn-submit-jurnal" style="background: #2563eb;">
                                <i class="fa-solid fa-paper-plane"></i> {{ $isSubmittedFinal ? 'Perbarui Jurnal' : 'Simpan Jurnal' }}
                            </button>
                        @elseif($isJamSelesai && !$isAdminPiket)
                            @if($isSubmittedFinal)
                                <!-- Submitted & Class Ended: Locked indicator shown -->
                                <div style="padding: 10px 18px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-lock" style="color: #64748b;"></i> Jurnal Terkunci Final (Jam Pelajaran Berakhir)
                                </div>
                            @else
                                <!-- Not Submitted & Class Ended: Disabled button -->
                                <button type="button" disabled style="padding: 10px 20px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; color: #991b1b; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran KBM telah berakhir. Pengisian jurnal telah ditutup.">
                                    <i class="fa-solid fa-ban"></i> Pengisian Ditutup (Waktu Habis)
                                </button>
                            @endif
                        @elseif(!$isJamStarted && !$isAdminPiket)
                            <button type="button" disabled style="padding: 10px 20px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 10px; color: #94a3b8; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran belum dimulai (Pukul {{ $selectedJadwal->waktu_mulai_effective ?? '' }} WIB)">
                                <i class="fa-solid fa-lock"></i> Belum Memasuki Jam Pelajaran
                            </button>
                        @endif
                    @endif
                </div>

                <div class="bottom-info-banner">
                    <i class="fa-solid fa-square-check" style="color: #16a34a;"></i>
                    <span>Jurnal hanya dapat diisi saat jam mengajar sedang berlangsung</span>
                </div>
            </form>

            <!-- Standalone Form for Batal Kirim Jurnal (Outside main form to prevent HTML nested form issue) -->
            @if(isset($selectedJadwal) && $selectedJadwal)
                <form id="formBatalKirimJurnal" method="POST" action="{{ route('guru.jurnal-harian.batal-kirim') }}" style="display: none;">
                    @csrf
                    <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal }}">
                </form>

                <script>
                    function confirmBatalKirimJurnal() {
                        if (confirm('Apakah Anda yakin ingin membatalkan pengiriman Jurnal Mengajar ini? Data pengiriman jurnal untuk jadwal ini akan dihapus total, formulir dikosongkan kembali, dan status mengajar kembali menjadi Belum Diisi.')) {
                            document.getElementById('formBatalKirimJurnal').submit();
                        }
                    }
                </script>
            @endif
        </div>
    @else
        <div class="empty-schedule-box">
            <div class="empty-schedule-icon">
                <i class="fa-solid fa-calendar-xmark"></i>
            </div>
            <h3 class="empty-schedule-title">
                Tidak Ada Jadwal Mengajar Hari Ini ({{ $hariIni }})
            </h3>
            <p class="empty-schedule-desc">
                @if(isset($isWaliKelas) && $isWaliKelas && isset($kelasWali) && $kelasWali)
                    Anda terdaftar sebagai <strong>Wali Kelas {{ $kelasWali->nama_kelas }}</strong>. Anda dapat mengelola presensi siswa perwalian atau memantau rekap kehadiran kelas melalui menu di bawah ini.
                @else
                    Anda tidak memiliki jadwal mengajar tatap muka KBM yang terjadwal pada hari ini.
                @endif
            </p>
            <div class="empty-schedule-actions">
                <a href="{{ isset($isWaliKelas) && $isWaliKelas && isset($kelasWali) && $kelasWali ? route('guru.absensi-siswa', ['tab' => 'perwalian', 'tanggal' => $todayDate]) : route('guru.absensi-siswa') }}" class="btn-submit-jurnal" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; background: #2563eb;">
                    <i class="fa-solid fa-user-check"></i> Presensi Siswa
                </a>
                <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-draft" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-pie"></i> Presensi & Perkembangan Kelas
                </a>
                <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-draft" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Jurnal
                </a>
            </div>
        </div>
    @endif

    <!-- Bottom Summary & Progress Widgets (2 Cards Side-by-Side) -->
    <div class="jurnal-bottom-widgets-grid">
        <!-- Widget 1: Riwayat Jurnal Hari Ini -->
        <div class="widget-box" style="border-top: 4px solid #2563eb; background: #ffffff; margin-bottom: 0;">
            <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-history" style="color: #2563eb; margin-right: 6px;"></i> Riwayat Jurnal Hari Ini</span>
                <span style="font-size: 11px; color: #64748b; font-weight: 600;">
                    {{ $todayCarbon->translatedFormat('d M Y') }}
                </span>
            </div>
            <div>
                @forelse($riwayatHariIni as $rItem)
                    @php
                        $jObj = $rItem->jadwal;
                    @endphp
                    <div class="history-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="history-class" style="font-size: 13px; font-weight: 800; color: #0f172a;">
                                {{ $jObj->kelas->nama_kelas ?? 'Kelas' }} — {{ $jObj->ruangan->nama_ruangan ?? 'Ruangan' }}
                            </div>
                            <div class="history-date" style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                {{ $jObj->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $jObj->waktu_mulai_effective }} - {{ $jObj->waktu_selesai_effective }})
                            </div>
                        </div>
                        @if($rItem->is_terisi && $rItem->jurnal)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                @if($rItem->is_draft)
                                    <span style="background: #e0f2fe; color: #0369a1; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">DRAFT</span>
                                @else
                                    <span style="background: #dcfce7; color: #15803d; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">TERISI</span>
                                @endif
                                <button type="button" onclick="openDetailJurnalModal({{ $rItem->jurnal->id_jurnal }})" style="border: 1px solid #bfdbfe; background: #eff6ff; color: #2563eb; padding: 2px 7px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;" title="Lihat Detail Jurnal">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        @else
                            <span style="background: #f8fafc; color: #94a3b8; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">BELUM</span>
                        @endif
                    </div>
                @empty
                    <div style="font-size: 12.5px; color: #94a3b8; padding: 14px 0; text-align: center;">Belum ada jadwal mengajar pada hari ini.</div>
                @endforelse
            </div>
        </div>

        <!-- Widget 2: Progres Bulanan -->
        <div class="widget-box" style="border-top: 4px solid #0284c7; background: #ffffff; margin-bottom: 0;">
            <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-chart-line" style="color: #0284c7; margin-right: 6px;"></i> Progres Bulanan</span>
                <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                    {{ $todayCarbon->translatedFormat('F Y') }}
                </span>
            </div>
            <div style="margin-top: 10px;">
                <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Jurnal Terisi</span>
                    <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $progresBulanan['terisi'] }} / {{ $progresBulanan['target'] }}</span>
                </div>

                @php
                    $pctBulanan = min(100, (int) round(($progresBulanan['terisi'] / max(1, $progresBulanan['target'])) * 100));
                @endphp
                <div style="width: 100%; height: 7px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin: 10px 0; border: 1px solid #e2e8f0;">
                    <div style="width: {{ $pctBulanan }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); border-radius: 6px; transition: width 0.3s ease;"></div>
                </div>

                <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Rata-rata per Minggu</span>
                    <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0284c7;">{{ $progresBulanan['rata_minggu'] }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Jurnal</span></span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- MODAL POP-UP KETERANGAN PRESENSI SISWA     --}}
    {{-- ========================================== --}}
    <div id="modalCatatanSiswa" class="modal-catatan-backdrop" onclick="handleModalBackdropClick(event)">
        <div class="modal-catatan-card" role="dialog" aria-modal="true" aria-labelledby="modalCatatanTitle">
            <!-- Modal Header -->
            <div class="modal-catatan-header">
                <div class="modal-catatan-title" id="modalCatatanTitle">
                    <i class="fa-solid fa-file-pen" style="color: #4f46e5;"></i>
                    <span>Keterangan Presensi Siswa</span>
                </div>
                <button type="button" class="modal-catatan-close" onclick="closeModalCatatanSiswa()" title="Tutup Modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-catatan-body">
                <!-- Info Siswa -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <div style="font-weight: 800; font-size: 14.5px; color: #0f172a;" id="mdlSiswaNama">-</div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">NISN: <strong id="mdlSiswaNisn" style="color: #334155;">-</strong></div>
                    </div>
                    <div>
                        <span id="mdlSiswaCurrentStatusBadge" style="font-size: 11.5px; font-weight: 800; padding: 4px 11px; border-radius: 6px; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">
                            Hadir
                        </span>
                    </div>
                </div>

                <!-- Status Terkunci Alert (Jika ada) -->
                <div id="mdlStatusLockedAlert" style="display: none; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; margin-bottom: 14px;">
                    <i class="fa-solid fa-lock" style="margin-right: 6px; color: #2563eb;"></i>
                    <span id="mdlStatusLockedText">Status ketidakhadiran telah dikunci resmi oleh Guru Piket / Waka Kesiswaan. Anda tetap dapat menambahkan catatan / keterangan presensi.</span>
                </div>

                <!-- Pilihan Status Ketidakhadiran (Hanya jika siswa tidak terkunci) -->
                <div id="mdlStatusChoiceWrap" style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12.5px; font-weight: 800; color: #334155; margin-bottom: 6px;">
                        Status Kehadiran Siswa:
                    </label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <label class="status-radio-pill pill-sakit" style="padding: 6px 12px;">
                            <input type="radio" name="mdl_status_radio" value="Sakit" id="mdl_radio_sakit">
                            <span>Sakit</span>
                        </label>
                        <label class="status-radio-pill pill-izin" style="padding: 6px 12px;">
                            <input type="radio" name="mdl_status_radio" value="Izin" id="mdl_radio_izin">
                            <span>Izin</span>
                        </label>
                        <label class="status-radio-pill pill-alpa" style="padding: 6px 12px;">
                            <input type="radio" name="mdl_status_radio" value="Alpa" id="mdl_radio_alpa">
                            <span>Alpa</span>
                        </label>
                        <label class="status-radio-pill pill-hadir" style="padding: 6px 12px;">
                            <input type="radio" name="mdl_status_radio" value="Hadir" id="mdl_radio_hadir">
                            <span>Hadir</span>
                        </label>
                    </div>
                </div>

                <!-- Input Textarea Catatan / Keterangan -->
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="mdlCatatanText" style="font-size: 12.5px; font-weight: 800; color: #334155;">
                            Catatan / Keterangan Presensi:
                        </label>
                        <span style="font-size: 11px; color: #94a3b8;" id="mdlCharCount">0 / 250</span>
                    </div>
                    <textarea id="mdlCatatanText" 
                              rows="4" 
                              maxlength="250"
                              placeholder="Masukkan catatan atau alasan ketidakhadiran siswa (misal: Sakit demam tinggi, izin acara keluarga di luar kota, dsb)..." 
                              style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 10px 12px; font-size: 13px; font-family: inherit; line-height: 1.5; resize: vertical; box-sizing: border-box; outline: none; transition: border-color 0.15s ease;"
                              onfocus="this.style.borderColor='#4f46e5';"
                              onblur="this.style.borderColor='#cbd5e1';"
                              oninput="updateMdlCharCount()"></textarea>
                </div>

                <!-- Quick Chip Templates -->
                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color: #6366f1; margin-right: 4px;"></i> Pilih Cepat Keterangan:
                    </label>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <button type="button" class="quick-chip-tag" onclick="quickAppendCatatan('Ada surat dokter / keterangan sakit')">+ Surat Dokter</button>
                        <button type="button" class="quick-chip-tag" onclick="quickAppendCatatan('Izin urusan keluarga penting')">+ Izin Keluarga</button>
                        <button type="button" class="quick-chip-tag" onclick="quickAppendCatatan('Tanpa surat keterangan')">+ Tanpa Surat</button>
                        <button type="button" class="quick-chip-tag" onclick="quickAppendCatatan('Mewakili lomba sekolah')">+ Mewakili Lomba</button>
                        <button type="button" class="quick-chip-tag" onclick="quickAppendCatatan('Pulang awal karena kurang sehat')">+ Pulang Sakit</button>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-catatan-footer">
                <button type="button" id="btnMdlHapusCatatan" onclick="hapusModalCatatan()" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; font-size: 12px; font-weight: 800; padding: 8px 14px; border-radius: 8px; cursor: pointer; display: none; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-trash-can"></i> Hapus Keterangan
                </button>
                <div style="display: flex; gap: 8px; margin-left: auto;">
                    <button type="button" onclick="closeModalCatatanSiswa()" style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; font-size: 12.5px; font-weight: 700; padding: 8px 16px; border-radius: 8px; cursor: pointer;">
                        Batal
                    </button>
                    <button type="button" onclick="simpanModalCatatan()" style="background: #4f46e5; color: #ffffff; border: 1px solid #4338ca; font-size: 12.5px; font-weight: 800; padding: 8px 18px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);">
                        <i class="fa-solid fa-check"></i> Simpan Keterangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL DETAIL JURNAL KBM LENGKAP            --}}
    {{-- ========================================== --}}
    <div id="modalDetailJurnal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
        <div class="modal-detail-card" style="background: #ffffff; border-radius: 20px; max-width: 720px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0,0,0,0.25); border: 1px solid #e2e8f0; animation: modalPop 0.2s ease;">
            <!-- Modal Header -->
            <div class="modal-detail-header" style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <h3 id="mdlMapelKelas" style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0; word-break: break-word; line-height: 1.3;">Detail Jurnal Pembelajaran</h3>
                        <div id="mdlWaktuJam" style="font-size: 11.5px; color: #64748b; margin-top: 3px; line-height: 1.4; word-break: break-word;">Memuat data...</div>
                    </div>
                </div>
                <button type="button" onclick="closeDetailJurnalModal()" style="background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 15px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.15s ease;" onmouseover="this.style.background='#e2e8f0'; this.style.color='#0f172a';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b';">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-detail-body" style="padding: 24px;">
                <div id="mdlLoading" style="text-align: center; padding: 40px; color: #64748b;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: #2563eb;"></i>
                    <div style="margin-top: 12px; font-weight: 700; font-size: 13.5px;">Memuat detail jurnal KBM...</div>
                </div>

                <div id="mdlContent" style="display: none;">
                    <!-- Grid Info Utama -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 18px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Guru Pengajar</div>
                            <div id="mdlGuru" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 4px; word-break: break-word;">-</div>
                        </div>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Pertemuan & Kondisi</div>
                            <div id="mdlPertemuanKondisi" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 4px; word-break: break-word;">-</div>
                        </div>
                    </div>

                    <!-- Materi -->
                    <div style="margin-bottom: 18px;">
                        <label style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Materi yang Diajarkan</label>
                        <div id="mdlMateri" style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; font-size: 13.5px; font-weight: 800; color: #1e293b; word-break: break-word; line-height: 1.45;">-</div>
                    </div>

                    <!-- Catatan Kelas -->
                    <div style="margin-bottom: 18px;">
                        <label style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Catatan Pembelajaran / Respon Siswa</label>
                        <div id="mdlCatatan" style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; font-size: 13px; color: #334155; line-height: 1.5; word-break: break-word;">-</div>
                    </div>

                    <!-- Foto Dokumentasi KBM -->
                    <div id="mdlFotoWrap" style="margin-bottom: 22px;">
                        <label style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Foto Dokumentasi Kehadiran KBM</label>
                        <div style="border-radius: 14px; overflow: hidden; border: 1.5px solid #cbd5e1; background: #0f172a; text-align: center; box-shadow: 0 4px 14px rgba(0,0,0,0.1);">
                            <img id="mdlFotoImg" src="" alt="Foto Dokumentasi" style="max-height: 340px; width: 100%; object-fit: contain; display: block;">
                        </div>
                    </div>

                    <!-- Rekap Presensi Siswa -->
                    <div>
                        <div class="modal-detail-stat-header" style="margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                            <span style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase;">
                                <i class="fa-solid fa-users" style="color: #2563eb; margin-right: 4px;"></i> Daftar Ketidakhadiran Siswa
                            </span>
                            <div id="mdlStatAbsen" style="display: flex; align-items: center; flex-wrap: wrap; gap: 4px 6px;">
                                <!-- populated by JS -->
                            </div>
                        </div>
                        <div id="mdlDaftarAbsen" style="border: 1.5px solid #cbd5e1; border-radius: 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; background: #ffffff; width: 100%; box-sizing: border-box;">
                            <!-- populated by JS -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-detail-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; background: #f8fafc; border-radius: 0 0 20px 20px;">
                <button type="button" onclick="closeDetailJurnalModal()" class="btn-draft" style="padding: 9px 20px; border-radius: 10px; font-size: 13px; font-weight: 800; cursor: pointer; background: #ffffff; border: 1px solid #cbd5e1;">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openDetailJurnalModal(id) {
            const modal = document.getElementById('modalDetailJurnal');
            const loading = document.getElementById('mdlLoading');
            const content = document.getElementById('mdlContent');
            if (!modal) return;

            modal.style.display = 'flex';
            loading.style.display = 'block';
            content.style.display = 'none';

            fetch('/guru-jurnal-detail/' + id)
                .then(res => res.json())
                .then(res => {
                    if (res.success && res.data) {
                        const d = res.data;
                        document.getElementById('mdlMapelKelas').textContent = d.mapel + ' (' + d.kelas + ')';
                        document.getElementById('mdlWaktuJam').textContent = d.hari + ', ' + d.tanggal_formatted + ' • Jam Ke-' + d.jam_ke + ' (' + d.waktu_kbm + ') • ' + d.ruangan;
                        document.getElementById('mdlGuru').textContent = d.guru_nama + (d.guru_pengganti ? ' (Diganti: ' + d.guru_pengganti + ')' : '');
                        document.getElementById('mdlPertemuanKondisi').textContent = (d.pertemuan_ke || 'Ke-1') + ' • Kondisi: ' + (d.kondisi_kelas || 'Kondusif');
                        document.getElementById('mdlMateri').textContent = d.materi || '-';
                        document.getElementById('mdlCatatan').textContent = d.catatan || 'Tidak ada catatan pembelajaran khusus.';

                        const fotoWrap = document.getElementById('mdlFotoWrap');
                        const fotoImg = document.getElementById('mdlFotoImg');
                        if (d.dokumentasi_url) {
                            fotoImg.src = d.dokumentasi_url;
                            fotoWrap.style.display = 'block';
                        } else {
                            fotoWrap.style.display = 'none';
                        }

                        let statHtml = '<span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; padding: 2px 7px; border-radius: 6px; font-weight: 800; font-size: 10.5px;">Hadir: ' + d.hadirCount + '</span>';
                        if (d.sakitCount > 0) {
                            statHtml += '<span style="background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 2px 7px; border-radius: 6px; font-weight: 800; font-size: 10.5px;">Sakit: ' + d.sakitCount + '</span>';
                        }
                        if (d.izinCount > 0) {
                            statHtml += '<span style="background: #fef9c3; color: #a16207; border: 1px solid #fde047; padding: 2px 7px; border-radius: 6px; font-weight: 800; font-size: 10.5px;">Izin: ' + d.izinCount + '</span>';
                        }
                        if (d.alpaCount > 0) {
                            statHtml += '<span style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 2px 7px; border-radius: 6px; font-weight: 800; font-size: 10.5px;">Alpa: ' + d.alpaCount + '</span>';
                        }
                        if (d.dispenCount > 0) {
                            statHtml += '<span style="background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; padding: 2px 7px; border-radius: 6px; font-weight: 800; font-size: 10.5px;">Dispen: ' + d.dispenCount + '</span>';
                        }
                        document.getElementById('mdlStatAbsen').innerHTML = statHtml;

                        const absenContainer = document.getElementById('mdlDaftarAbsen');
                        if (d.absenList && d.absenList.length > 0) {
                            let html = '<table style="width: 100%; border-collapse: collapse; font-size: 12px; table-layout: auto;">';
                            html += '<tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b; font-size: 11px;"><th style="padding: 9px 12px; font-weight: 800;">Nama Siswa</th><th style="padding: 9px 12px; font-weight: 800;">NISN</th><th style="padding: 9px 12px; font-weight: 800; text-align: right;">Status</th></tr>';
                            d.absenList.forEach(s => {
                                let bg = '#fee2e2';
                                let cl = '#dc2626';
                                let bd = '#fca5a5';
                                const st = (s.keterangan || '').toLowerCase();
                                if (st.includes('sakit')) {
                                    bg = '#dbeafe'; cl = '#1d4ed8'; bd = '#bfdbfe';
                                } else if (st.includes('izin')) {
                                    bg = '#fef9c3'; cl = '#a16207'; bd = '#fde047';
                                } else if (st.includes('dispen')) {
                                    bg = '#f3e8ff'; cl = '#7e22ce'; bd = '#d8b4fe';
                                } else if (st.includes('telat') || st.includes('terlambat')) {
                                    bg = '#ffedd5'; cl = '#c2410c'; bd = '#fed7aa';
                                } else if (st.includes('hadir')) {
                                    bg = '#dcfce7'; cl = '#15803d'; bd = '#bbf7d0';
                                }

                                html += '<tr style="border-bottom: 1px solid #f1f5f9;">';
                                const catatanHtml = s.catatan ? '<div style="font-size: 11px; color: #475569; font-weight: normal; margin-top: 3px; word-break: break-word;"><i class="fa-regular fa-note-sticky" style="color: #6366f1; margin-right: 4px;"></i><em>' + s.catatan + '</em></div>' : '';
                                html += '<td style="padding: 9px 12px; font-weight: 700; color: #0f172a; word-break: break-word;">' + s.nama_siswa + catatanHtml + '</td>';
                                html += '<td style="padding: 9px 12px; color: #64748b; white-space: nowrap;">' + (s.nisn || '-') + '</td>';
                                html += '<td style="padding: 9px 12px; text-align: right; white-space: nowrap;"><span style="background:' + bg + '; color:' + cl + '; border: 1px solid ' + bd + '; font-weight: 800; padding: 2px 8px; border-radius: 6px; font-size: 10.5px; display: inline-flex; align-items: center; gap: 4px;">' + s.keterangan + '</span></td>';
                                html += '</tr>';
                            });
                            html += '</table>';
                            absenContainer.innerHTML = html;
                        } else {
                            absenContainer.innerHTML = '<div style="padding: 16px; text-align: center; color: #16a34a; font-weight: 700; font-size: 12.5px; background: #f0fdf4;"><i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> Seluruh siswa berstatus Hadir lengkap pada sesi KBM ini.</div>';
                        }

                        loading.style.display = 'none';
                        content.style.display = 'block';
                    } else {
                        loading.innerHTML = '<div style="color: #dc2626; font-weight: 700;">Gagal memuat detail jurnal.</div>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    loading.innerHTML = '<div style="color: #dc2626; font-weight: 700;">Terjadi kesalahan saat memuat data.</div>';
                });
        }

        function closeDetailJurnalModal() {
            const modal = document.getElementById('modalDetailJurnal');
            if (modal) modal.style.display = 'none';
        }

        /* === KETERANGAN / CATATAN PRESENSI SISWA SCRIPTS === */
        window.siswaCatatanMap = @json($existingCatatan ?? []);
        let activeModalSiswaId = null;
        let activeModalIsLocked = false;
        let activeModalLockedStatus = null;

        function openModalCatatanSiswa(swId, namaSiswa, nisn, lockedStatus) {
            activeModalSiswaId = swId;
            activeModalIsLocked = (lockedStatus && String(lockedStatus).trim() !== '');
            activeModalLockedStatus = lockedStatus || null;

            // Set info nama & nisn
            const nameEl = document.getElementById('mdlSiswaNama');
            const nisnEl = document.getElementById('mdlSiswaNisn');
            if (nameEl) nameEl.textContent = namaSiswa;
            if (nisnEl) nisnEl.textContent = nisn || '-';

            // Dapatkan status saat ini di baris tabel
            let currentStatus = 'Hadir';
            const checkedRadio = document.querySelector('input[name="siswa_status_' + swId + '"]:checked');
            if (checkedRadio) {
                currentStatus = checkedRadio.value;
            } else if (activeModalIsLocked) {
                currentStatus = activeModalLockedStatus;
            }

            // Tampilkan badge status saat ini
            const badgeEl = document.getElementById('mdlSiswaCurrentStatusBadge');
            if (badgeEl) {
                badgeEl.textContent = currentStatus;
                let bg = '#dcfce7', cl = '#15803d', bd = '#bbf7d0';
                if (currentStatus === 'Sakit') {
                    bg = '#dbeafe'; cl = '#1d4ed8'; bd = '#bfdbfe';
                } else if (currentStatus === 'Izin') {
                    bg = '#fef9c3'; cl = '#a16207'; bd = '#fde047';
                } else if (currentStatus === 'Alpa') {
                    bg = '#fee2e2'; cl = '#dc2626'; bd = '#fecaca';
                } else if (currentStatus === 'Dispen') {
                    bg = '#f3e8ff'; cl = '#7e22ce'; bd = '#d8b4fe';
                }
                badgeEl.style.background = bg;
                badgeEl.style.color = cl;
                badgeEl.style.borderColor = bd;
            }

            // Atur pilihan status atau info terkunci
            const lockedAlert = document.getElementById('mdlStatusLockedAlert');
            const lockedText = document.getElementById('mdlStatusLockedText');
            const choiceWrap = document.getElementById('mdlStatusChoiceWrap');

            if (activeModalIsLocked) {
                if (lockedAlert) lockedAlert.style.display = 'block';
                if (lockedText) {
                    lockedText.textContent = 'Status ketidakhadiran telah dikunci resmi (' + activeModalLockedStatus + ') oleh Guru Piket / Waka Kesiswaan. Anda tetap dapat menambahkan atau memperbarui catatan presensi.';
                }
                if (choiceWrap) choiceWrap.style.display = 'none';
            } else {
                if (lockedAlert) lockedAlert.style.display = 'none';
                if (choiceWrap) choiceWrap.style.display = 'block';

                // Check radio status yang sesuai di modal
                const modalRadio = document.querySelector('input[name="mdl_status_radio"][value="' + currentStatus + '"]');
                if (modalRadio) {
                    modalRadio.checked = true;
                } else {
                    const hadirRadio = document.getElementById('mdl_radio_hadir');
                    if (hadirRadio) hadirRadio.checked = true;
                }
            }

            // Isi nilai textarea catatan yang tersimpan
            const textarea = document.getElementById('mdlCatatanText');
            const globalInput = document.getElementById('global_catatan_' + swId);
            const savedCatatan = (window.siswaCatatanMap && typeof window.siswaCatatanMap[swId] !== 'undefined')
                ? window.siswaCatatanMap[swId]
                : (globalInput ? globalInput.value : '');

            if (textarea) {
                textarea.value = savedCatatan || '';
            }
            updateMdlCharCount();

            // Tampilkan / sembunyikan tombol Hapus Catatan
            const btnHapus = document.getElementById('btnMdlHapusCatatan');
            if (btnHapus) {
                btnHapus.style.display = (savedCatatan && savedCatatan.trim().length > 0) ? 'inline-flex' : 'none';
            }

            // Tampilkan modal
            const modal = document.getElementById('modalCatatanSiswa');
            if (modal) {
                modal.style.display = 'flex';
                setTimeout(() => {
                    if (textarea) {
                        textarea.focus();
                        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                    }
                }, 100);
            }
        }

        function closeModalCatatanSiswa() {
            const modal = document.getElementById('modalCatatanSiswa');
            if (modal) modal.style.display = 'none';
            activeModalSiswaId = null;
            activeModalIsLocked = false;
            activeModalLockedStatus = null;
        }

        function handleModalBackdropClick(e) {
            if (e.target.id === 'modalCatatanSiswa') {
                closeModalCatatanSiswa();
            }
        }

        function updateMdlCharCount() {
            const textarea = document.getElementById('mdlCatatanText');
            const countEl = document.getElementById('mdlCharCount');
            if (textarea && countEl) {
                const len = textarea.value.length;
                countEl.textContent = len + ' / 250';
                if (len >= 240) {
                    countEl.style.color = '#dc2626';
                    countEl.style.fontWeight = 'bold';
                } else {
                    countEl.style.color = '#94a3b8';
                    countEl.style.fontWeight = 'normal';
                }
            }
        }

        function quickAppendCatatan(text) {
            const textarea = document.getElementById('mdlCatatanText');
            if (!textarea) return;
            const curVal = textarea.value.trim();
            if (curVal.length === 0) {
                textarea.value = text;
            } else {
                if (curVal.includes(text)) return; // hindari duplikasi
                const combined = curVal + ', ' + text;
                if (combined.length <= 250) {
                    textarea.value = combined;
                }
            }
            updateMdlCharCount();
            textarea.focus();
        }

        function simpanModalCatatan() {
            if (!activeModalSiswaId) {
                closeModalCatatanSiswa();
                return;
            }

            const swId = activeModalSiswaId;
            const textarea = document.getElementById('mdlCatatanText');
            const noteText = textarea ? textarea.value.trim() : '';

            // Simpan ke memori state
            if (!window.siswaCatatanMap) window.siswaCatatanMap = {};
            window.siswaCatatanMap[swId] = noteText;

            // Simpan ke hidden input global
            const globalInput = document.getElementById('global_catatan_' + swId);
            if (globalInput) globalInput.value = noteText;

            // Dapatkan status presensi
            let selectedStatus = 'Hadir';
            if (activeModalIsLocked) {
                selectedStatus = activeModalLockedStatus;
            } else {
                const checkedRadio = document.querySelector('input[name="mdl_status_radio"]:checked');
                if (checkedRadio) {
                    selectedStatus = checkedRadio.value;
                }
                // Sinkronkan radio baris tabel
                const tableRowRadio = document.querySelector('input[name="siswa_status_' + swId + '"][value="' + selectedStatus + '"]');
                if (tableRowRadio) {
                    tableRowRadio.checked = true;
                }
            }

            // Perbarui container input absensi
            toggleAbsenceInput(swId, selectedStatus);

            // Perbarui tombol Keterangan (indikator aktif & badge)
            const btnCatatan = document.getElementById('btn_catatan_' + swId);
            const badgeCatatan = document.getElementById('badge_catatan_' + swId);
            if (btnCatatan) {
                if (noteText.length > 0) {
                    btnCatatan.classList.add('has-catatan');
                    btnCatatan.title = 'Keterangan: ' + noteText;
                    if (badgeCatatan) badgeCatatan.style.display = 'inline-flex';
                } else {
                    btnCatatan.classList.remove('has-catatan');
                    btnCatatan.title = 'Tambah Keterangan Presensi Siswa';
                    if (badgeCatatan) badgeCatatan.style.display = 'none';
                }
            }

            // Perbarui preview box di baris siswa
            const previewBox = document.getElementById('catatan_preview_' + swId);
            const previewText = document.getElementById('catatan_text_' + swId);
            if (previewBox && previewText) {
                if (noteText.length > 0) {
                    previewText.textContent = noteText;
                    previewBox.style.display = 'inline-flex';
                } else {
                    previewBox.style.display = 'none';
                }
            }

            closeModalCatatanSiswa();
        }

        function hapusModalCatatan() {
            const textarea = document.getElementById('mdlCatatanText');
            if (textarea) textarea.value = '';
            simpanModalCatatan();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDetailJurnalModal();
                closeModalCatatanSiswa();
            }
        });
    </script>

@endsection
