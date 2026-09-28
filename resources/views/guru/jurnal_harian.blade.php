@extends('layouts.guru')

@section('title', 'Jurnal Harian — EDU JOURNAL')
@section('header_title', 'Jurnal Harian Guru')

@section('styles')
<style>
    /* =========================================================
       PAGE WRAPPER & MODERN DESIGN SYSTEM
       ========================================================= */
    .jurnal-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    /* Page Header */
    .jurnal-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .jurnal-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .jurnal-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        flex-shrink: 0;
    }

    .jurnal-header-text h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px 0;
        letter-spacing: -0.02em;
    }

    .jurnal-header-text p {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin: 0;
    }

    /* =========================================================
       TOP REMINDER BANNER (SOFT GRADIENT)
       ========================================================= */
    .reminder-banner-modern {
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 50%, #e0f2fe 100%);
        border: 1px solid rgba(186, 230, 253, 0.9);
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 8px -2px rgba(37, 99, 235, 0.04);
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        box-sizing: border-box;
        min-height: unset;
    }

    .reminder-icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.25);
    }

    .reminder-title-text {
        font-size: 13px;
        font-weight: 800;
        color: #1e3a8a;
        line-height: 1.2;
        margin: 0;
        padding: 0;
    }

    .reminder-desc-text {
        font-size: 11.5px;
        color: #2563eb;
        margin: 2px 0 0 0;
        padding: 0;
        line-height: 1.35;
        font-weight: 500;
        letter-spacing: -0.01em;
    }

    /* 5-Minute Pre-Expiry Alert Box */
    .urgent-banner-modern {
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 45%, #fef2f2 100%);
        border: 1.5px solid #fb923c;
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        box-shadow: 0 3px 10px rgba(234, 88, 12, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        box-sizing: border-box;
        min-height: unset;
    }

    .urgent-icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(234, 88, 12, 0.25);
        animation: pulse-orange 1.5s infinite;
    }

    @keyframes pulse-orange {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0.4); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(234, 88, 12, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0); }
    }

    .btn-urgent-pill {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        color: #ffffff;
        font-weight: 800;
        padding: 10px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 12.5px;
        white-space: nowrap;
        box-shadow: 0 3px 10px rgba(234, 88, 12, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-urgent-pill:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(234, 88, 12, 0.4);
        color: #ffffff;
    }

    /* =========================================================
       SCHEDULE SESSIONS HORIZONTAL SCROLL CARDS
       ========================================================= */
    .section-subtitle-head {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .horizontal-schedule-scroll {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 12px;
        margin-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .horizontal-schedule-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .horizontal-schedule-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 6px;
    }

    .schedule-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        min-width: 235px;
        flex: 0 0 auto;
        text-decoration: none;
        color: inherit;
        transition: border-color 0.2s ease, background-color 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        box-sizing: border-box;
    }

    .schedule-card-item:hover {
        border-color: #cbd5e1;
    }

    .schedule-card-item.selected {
        background: #f8faff;
        border: 1.5px solid #3b82f6;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .schedule-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .schedule-card-meta {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
        font-weight: 500;
    }

    .schedule-card-status {
        margin-top: 12px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* =========================================================
       MAIN FORM CARD - MODERN FULL WIDTH
       ========================================================= */
    .form-jurnal-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
        width: 100%;
        margin-bottom: 24px;
        box-sizing: border-box;
    }

    @media (max-width: 640px) {
        .form-jurnal-box {
            padding: 16px;
            border-radius: 14px;
        }
    }

    .form-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-box-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-box-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        border: 1px solid #bfdbfe;
    }

    .form-box-title-text {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.01em;
        line-height: 1.25;
        margin: 0;
    }

    /* Notice / Alert Box Inside Main Form */
    .form-notice-box {
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-sizing: border-box;
        min-height: unset;
    }
    .form-notice-icon {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .form-notice-content {
        flex: 1;
        min-width: 0;
    }
    .form-notice-title {
        font-size: 13px;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
        padding: 0;
    }
    .form-notice-desc {
        margin: 2px 0 0 0;
        padding: 0;
        font-size: 11.5px;
        line-height: 1.35;
        letter-spacing: -0.01em;
    }

    .form-group-custom {
        margin-bottom: 16px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 6px;
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
        transition: all 0.2s ease;
    }

    .input-field-custom:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Readonly Schedule Info Tiles */
    .schedule-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 16px;
    }

    @media (max-width: 900px) {
        .schedule-info-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 520px) {
        .schedule-info-grid { grid-template-columns: 1fr; }
    }

    .input-readonly-field {
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        font-family: inherit;
        outline: none;
        cursor: not-allowed;
        box-sizing: border-box;
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
        color: #64748b;
        pointer-events: none;
        font-size: 14px;
    }

    /* Modern Segmented Control for Class Condition */
    .condition-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .condition-pill-label {
        padding: 9px 20px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .condition-pill-label:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .condition-pill-input { display: none; }

    /* Thematic active states */
    #k1:checked + .condition-pill-label {
        background: #f0fdf4;
        color: #166534;
        border-color: #86efac;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.15);
    }
    #k2:checked + .condition-pill-label {
        background: #fffbeb;
        color: #92400e;
        border-color: #fde68a;
        box-shadow: 0 2px 8px rgba(217, 119, 6, 0.15);
    }
    #k3:checked + .condition-pill-label {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15);
    }

    /* =========================================================
       LIVE CAMERA & PHOTO UPLOAD STYLING
       ========================================================= */
    .camera-upload-container {
        margin-top: 20px;
        margin-bottom: 22px;
    }

    .camera-box-placeholder {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px dashed #94a3b8;
        border-radius: 18px;
        padding: 34px 20px;
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
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.12);
    }

    .camera-icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        transition: transform 0.2s ease;
    }

    .camera-box-placeholder:hover .camera-icon-circle {
        transform: scale(1.08);
    }

    .camera-viewfinder-wrapper {
        background: #0f172a;
        border-radius: 18px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 26px rgba(0, 0, 0, 0.25);
        border: 2px solid #334155;
    }

    .camera-video-stream {
        width: 100%;
        max-height: 380px;
        display: block;
        object-fit: cover;
        background: #000000;
        transform: scaleX(1);
    }

    .camera-live-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(225, 29, 72, 0.92);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
        backdrop-filter: blur(6px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
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
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        border: 4px solid rgba(255, 255, 255, 0.9);
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
        transform: scale(1.05);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .camera-preview-img-wrapper {
        position: relative;
        width: 100%;
        border-radius: 14px;
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
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 7px;
        backdrop-filter: blur(6px);
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
    .shutter-flash.active { opacity: 0.9; }

    /* =========================================================
       STUDENT ATTENDANCE TABLE & RADIO PILLS
       ========================================================= */
    .attendance-table-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        width: 100%;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .attendance-table thead tr {
        background: #f8fafc;
        text-align: left;
        font-size: 12px;
        color: #475569;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        letter-spacing: 0.5px;
    }

    .attendance-table th {
        padding: 14px 20px;
        font-weight: 800;
    }

    .attendance-table td {
        padding: 14px 20px;
        vertical-align: middle;
    }

    .attendance-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }

    .attendance-table tbody tr:hover {
        background: #f8fafc;
    }

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
    .status-radio-pill.pill-hadir:hover { background: #dcfce7; }

    .status-radio-pill.pill-sakit {
        color: #1d4ed8;
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .status-radio-pill.pill-sakit:hover { background: #dbeafe; }

    .status-radio-pill.pill-izin {
        color: #b45309;
        background: #fffbeb;
        border-color: #fde68a;
    }
    .status-radio-pill.pill-izin:hover { background: #fef3c7; }

    .status-radio-pill.pill-alpa {
        color: #b91c1c;
        background: #fef2f2;
        border-color: #fecaca;
    }
    .status-radio-pill.pill-alpa:hover { background: #fee2e2; }

    .status-radio-pill.pill-dispen {
        color: #7e22ce;
        background: #faf5ff;
        border-color: #e9d5ff;
    }
    .status-radio-pill.pill-dispen.locked {
        cursor: not-allowed;
    }

    /* Buttons */
    .form-actions-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }

    .btn-draft {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-draft:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-submit-jurnal {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-submit-jurnal:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
    }

    .bottom-info-banner {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 12.5px;
        font-weight: 700;
        padding: 12px 18px;
        border-radius: 12px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* =========================================================
       BOTTOM WIDGETS (GRADIENT CARDS + SOLID ICONS + NO CHEVRONS)
       ========================================================= */
    .jurnal-bottom-widgets-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 4px;
        margin-bottom: 24px;
    }

    @media (max-width: 900px) {
        .jurnal-bottom-widgets-grid { grid-template-columns: 1fr; }
    }

    .widget-gradient-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .widget-gradient-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    .card-theme-blue {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .card-theme-purple {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .stat-circle-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .icon-solid-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .icon-solid-purple {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
    }

    .widget-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 2;
        margin-bottom: 14px;
    }

    .widget-header-title-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .widget-title-text {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .widget-subtitle-text {
        font-size: 11.5px;
        color: #64748b;
        margin: 2px 0 0 0;
        font-weight: 500;
    }

    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        position: relative;
        z-index: 2;
    }
    .history-item:last-child { border-bottom: none; }

    .history-class {
        font-size: 12.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .history-date {
        font-size: 11px;
        color: #64748b;
        margin-top: 1px;
    }

    .progress-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        position: relative;
        z-index: 2;
    }
    .progress-row:last-child { border-bottom: none; }
</style>
@endsection

@section('content')

<div class="jurnal-page-wrapper">

    <!-- Alert Box: Pengingat Otomatis Sistem Jurnal Mengajar -->
    <div class="reminder-banner-modern">
        <div class="reminder-icon-circle">
            <i class="fa-solid fa-bell"></i>
        </div>
        <div style="position: relative; z-index: 2;">
            <div class="reminder-title-text">Pengingat Otomatis Sistem Jurnal Mengajar</div>
            <div class="reminder-desc-text">
                Jurnal hanya dapat diisi saat jam pelajaran berlangsung. Jika 5 menit sebelum jam mengajar berakhir jurnal belum diisi, pengingat otomatis akan ditampilkan pada layar Anda.
            </div>
        </div>
    </div>

    @php
        $urgentJadwal = ($selectedJadwal && $selectedJadwal->hampir_habis) ? $selectedJadwal : $jadwalsHariIni->first(fn($j) => $j->hampir_habis);
    @endphp

    @if($urgentJadwal && $urgentJadwal->hampir_habis)
        <!-- Urgent 5-Minute Warning Banner -->
        <div id="urgentReminderAlertBox" class="urgent-banner-modern" data-end-time="{{ $urgentJadwal->waktu_selesai_effective }}">
            <div style="display: flex; align-items: center; gap: 8px; position: relative; z-index: 2;">
                <div class="urgent-icon-circle">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #9a3412; line-height: 1.2; margin: 0; padding: 0;">Peringatan 5 Menit Terakhir!</div>
                    <div style="font-size: 12px; color: #c2410c; margin: 2px 0 0 0; padding: 0; line-height: 1.4;">
                        Jam pelajaran <strong>{{ $urgentJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $urgentJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong><span id="urgentSisaMenitText">{{ $urgentJadwal->sisa_menit_selesai <= 1 ? 'kurang dari 1' : (int)$urgentJadwal->sisa_menit_selesai }}</span> menit lagi</strong> sebelum jam berakhir (Pukul {{ $urgentJadwal->waktu_selesai_effective }} WIB). Mohon segera lengkapi dan simpan Jurnal Mengajar Anda!
                    </div>
                </div>
            </div>
            @if($selectedJadwal && $selectedJadwal->id_jadwal != $urgentJadwal->id_jadwal)
                <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $urgentJadwal->id_jadwal]) }}" class="btn-urgent-pill" style="position: relative; z-index: 2;">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Jadwal Ini
                </a>
            @endif
        </div>
    @endif

    <!-- Horizontal Scroll: Jadwal Mengajar Hari Ini -->
    <div>
        <div class="section-subtitle-head">
            <i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i>
            <span>Jadwal Mengajar Hari Ini</span>
            <span style="font-size: 11px; background: #eff6ff; color: #2563eb; padding: 2px 8px; border-radius: 8px; font-weight: 800; border: 1px solid #bfdbfe; margin-left: 4px;">
                {{ count($jadwalsHariIni) }} Sesi
            </span>
        </div>
        <div class="horizontal-schedule-scroll">
            @forelse($jadwalsHariIni as $j)
                @php
                    $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal);
                    $isDiisi = $j->isDiisiHariIni();
                    $isBerlangsung = $j->is_sedang_berlangsung;
                    $isHampir = $isBerlangsung && $j->hampir_habis;
                    $isSelesai = $j->is_jam_sudah_selesai;
                @endphp
                <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) }}" class="schedule-card-item {{ $isSelected ? 'selected' : '' }}">
                    <div>
                        <div class="schedule-card-title">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }} {{ $j->kelas->nama_kelas ?? '' }}
                            </span>
                            <div style="display: flex; align-items: center; gap: 5px; flex-shrink: 0;">
                                @if(!empty($j->is_guru_pengganti))
                                    <span style="display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #b45309; padding: 2px 6px; border-radius: 6px; border: 1px solid #fde68a;">
                                        <i class="fa-solid fa-user-clock"></i> Pengganti
                                    </span>
                                @endif
                                @if($isSelected)
                                    <span style="font-size: 10px; font-weight: 800; background: #eff6ff; color: #2563eb; padding: 2px 7px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-check"></i> Dipilih
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="schedule-card-meta">
                            {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} &bull; {{ $j->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                        </div>
                    </div>
                    <div class="schedule-card-status">
                        @if($isDiisi)
                            <span style="color: #16a34a; font-weight: 800;"><i class="fa-solid fa-circle-check"></i> Sudah Diisi</span>
                        @elseif($isHampir)
                            <span style="color: #dc2626; font-weight: 800; animation: pulse-orange 1.5s infinite;"><i class="fa-solid fa-triangle-exclamation"></i> Segera Isi (Sisa {{ $j->sisa_menit_selesai }}m)</span>
                        @elseif($isBerlangsung)
                            <span style="color: #16a34a; font-weight: 800;"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Sedang Berlangsung</span>
                        @elseif($isSelesai)
                            <span style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-ban"></i> Waktu Habis</span>
                        @else
                            <span style="color: #64748b;"><i class="fa-regular fa-clock"></i> Belum Mulai</span>
                        @endif
                    </div>
                </a>
            @empty
                <div style="font-size: 13px; color: #94a3b8; padding: 12px 0;">Tidak ada jadwal mengajar hari ini.</div>
            @endforelse
        </div>
    </div>

    <!-- Main Full-Width Form Card: Isi Jurnal Mengajar -->
    <div class="form-jurnal-box">
        <div class="form-box-header">
            <div class="form-box-title-wrap">
                <div class="form-box-icon">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <div>
                    <h2 class="form-box-title-text">Isi Jurnal Mengajar: {{ $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</h2>
                    <p style="font-size: 12.5px; color: #64748b; margin: 2px 0 0 0; font-weight: 500;">
                        Lengkapi materi KBM, kondisi kelas, dokumentasi kehadiran, dan presensi siswa
                    </p>
                </div>
            </div>

            @if(isset($existingJurnal) && $existingJurnal)
                <span style="font-size: 11.5px; background: {{ $existingJurnal->is_draft ? '#e0f2fe' : '#dcfce7' }}; color: {{ $existingJurnal->is_draft ? '#0369a1' : '#15803d' }}; border: 1px solid {{ $existingJurnal->is_draft ? '#bae6fd' : '#bbf7d0' }}; padding: 5px 14px; border-radius: 20px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid {{ $existingJurnal->is_draft ? 'fa-bookmark' : 'fa-circle-check' }}"></i>
                    {{ $existingJurnal->is_draft ? 'DRAFT TERSIMPAN' : 'JURNAL TERISI' }}
                </span>
            @endif
        </div>

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
            $canEditInputs = $isAdminPiket || ($isSedangBerlangsung && (!$isSubmittedFinal || $isSedangBerlangsung));
            $canCancelSubmit = $isSubmittedFinal && ($isSedangBerlangsung || $isAdminPiket);
            $canSubmitOrUpdate = $isAdminPiket || $isSedangBerlangsung;
        @endphp

        @if($isGuruPengganti)
            <div class="form-notice-box" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #f59e0b; color: #92400e; align-items: flex-start; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.05);">
                <div class="form-notice-icon" style="background: #f59e0b; color: #ffffff; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.25);">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 6px;">
                        <div class="form-notice-title" style="color: #78350f;">
                            📌 Penugasan Guru Pengganti (Menggantikan: {{ $selectedJadwal->guru_utama->nama_guru ?? ($selectedJadwal->guru->nama_guru ?? 'Guru Tidak Hadir') }})
                        </div>
                        <span style="font-size: 10.5px; font-weight: 800; background: #fde68a; color: #b45309; padding: 2px 8px; border-radius: 6px; border: 1px solid #fcd34d;">
                            <i class="fa-solid fa-id-badge"></i> Guru Pengganti Aktif
                        </span>
                    </div>
                    <div class="form-notice-desc" style="color: #92400e;">
                        Anda ditugaskan oleh Guru Piket untuk menggantikan KBM di kelas <strong>{{ $selectedJadwal->kelas->nama_kelas ?? '-' }}</strong> pada jam ke-<strong>{{ $selectedJadwal->jam_range }}</strong> ({{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB).
                    </div>
                    @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan) || !empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan))
                        <div style="margin-top: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.85); border: 1px dashed #f59e0b; border-radius: 8px; font-size: 11.5px; color: #78350f;">
                            @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan))
                                <div style="margin-bottom: 3px;">
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
        @elseif($isAdminPiket)
            <div class="form-notice-box" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; color: #1e40af;">
                <div class="form-notice-icon" style="background: #dbeafe; color: #2563eb; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="form-notice-content">
                    <div class="form-notice-title" style="color: #1e3a8a;">Mode Pengurus / Guru Piket</div>
                    <div class="form-notice-desc" style="color: #1e40af;">Anda memiliki wewenang penuh untuk mengelola jurnal tanpa pembatasan jam pelajaran.</div>
                </div>
            </div>
        @endif

        @if($isJamSelesai && !$isAdminPiket)
            @if($isSubmittedFinal)
                <!-- Class Time Ended - Submitted Journal is Locked Final -->
                <div class="form-notice-box" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div class="form-notice-icon" style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #1e293b;">Jurnal Terkunci Final (Jam Pelajaran Berakhir)</div>
                        <div class="form-notice-desc" style="color: #64748b;">
                            Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Data Jurnal Mengajar yang telah dikirim sudah <strong>terkunci final</strong> dan tidak dapat diubah atau dibatalkan lagi.
                        </div>
                    </div>
                </div>
            @else
                <!-- Class Time Ended - NOT Filled - Soft Rose Alert Box -->
                <div class="form-notice-box" style="background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); border: 1px solid #fecdd3; color: #9f1239; box-shadow: 0 2px 6px rgba(225, 29, 72, 0.03);">
                    <div class="form-notice-icon" style="background: #ffe4e6; color: #e11d48; border: 1px solid #fecdd3;">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #9f1239;">Waktu Pengisian Jurnal Telah Habis</div>
                        <div class="form-notice-desc" style="color: #be123c;">
                            Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Sesuai data alokasi jam KBM dan master jam pelajaran TU, pengisian jurnal tidak dapat dilakukan karena jam pelajaran guru tersebut telah selesai.
                        </div>
                    </div>
                </div>
            @endif
        @elseif(!$isJamStarted && !$isAdminPiket)
            <!-- Class Time Not Started Yet -->
            <div class="form-notice-box" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; color: #92400e;">
                <div class="form-notice-icon" style="background: #fef3c7; color: #d97706; border: 1px solid #fde68a;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="form-notice-content">
                    <div class="form-notice-title" style="color: #78350f;">Jam Pelajaran Belum Dimulai</div>
                    <div class="form-notice-desc" style="color: #92400e;">
                        Fitur isi jurnal untuk jam pelajaran ini belum dapat diisi. Pengisian jurnal baru dibuka dan dapat diisi saat jam pelajaran guru berlangsung (Pukul <strong>{{ $selectedJadwal->waktu_mulai_effective ?? '00:00' }} - {{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>).
                    </div>
                </div>
            </div>
        @elseif($isSedangBerlangsung)
            @if($isHampirHabis)
                <!-- 5-Minute Pre-Expiry Warning Inside Form -->
                <div class="form-notice-box" style="background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 100%); border: 1.5px solid #fca5a5; color: #991b1b; animation: pulse-orange 1.5s infinite;">
                    <div class="form-notice-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #991b1b;">Peringatan: Sisa Waktu {{ $selectedJadwal->sisa_menit_selesai }} Menit Lagi!</div>
                        <div class="form-notice-desc" style="color: #b91c1c;">
                            Jam pelajaran akan berakhir pukul <strong>{{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>. Harap segera melengkapi materi dan absensi siswa lalu klik <strong>Simpan Jurnal</strong> sebelum waktu KBM habis dan fitur isi jurnal terkunci!
                        </div>
                    </div>
                </div>
            @elseif($isSubmittedFinal)
                <!-- Class Time Ongoing - Submitted Journal can be edited or cancelled -->
                <div class="form-notice-box" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; color: #166534;">
                    <div class="form-notice-icon" style="background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #14532d;">Jurnal Mengajar Terkirim</div>
                        <div class="form-notice-desc" style="color: #166534;">Selama jam pelajaran masih berlangsung (s/d Pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>), Anda masih dapat memperbarui isian atau membatalkan pengiriman jurnal.</div>
                    </div>
                </div>
            @elseif($isDraft)
                <!-- Draft Saved -->
                <div class="form-notice-box" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd; color: #0369a1;">
                    <div class="form-notice-icon" style="background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">
                        <i class="fa-solid fa-bookmark"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #0369a1;">Tersimpan Sebagai Draft</div>
                        <div class="form-notice-desc" style="color: #0284c7;">Jurnal Mengajar saat ini tersimpan sebagai Draft. Silakan lengkapi isian di bawah ini lalu klik <strong>Simpan Jurnal</strong> untuk mengirim secara resmi.</div>
                    </div>
                </div>
            @else
                <!-- Ongoing fresh form -->
                <div class="form-notice-box" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; color: #1e40af;">
                    <div class="form-notice-icon" style="background: #dbeafe; color: #2563eb; border: 1px solid #bfdbfe;">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div class="form-notice-content">
                        <div class="form-notice-title" style="color: #1e3a8a;">KBM Sedang Berlangsung</div>
                        <div class="form-notice-desc" style="color: #1e40af;">Jam pelajaran sedang berlangsung (<strong>{{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>). Silakan isi absensi kelas dan materi pembelajaran.</div>
                    </div>
                </div>
            @endif
        @endif

        <form method="POST" action="{{ route('guru.jurnal-harian.store') }}">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal ?? 1 }}">

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

            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px;">
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
                    <label for="k1" class="condition-pill-label">
                        <i class="fa-solid fa-circle-check" style="font-size: 12px;"></i> Kondusif
                    </label>

                    <input type="radio" name="kondisi_kelas" id="k2" value="Cukup ramai" class="condition-pill-input" {{ $curKondisi === 'Cukup ramai' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                    <label for="k2" class="condition-pill-label">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 12px;"></i> Cukup ramai
                    </label>

                    <input type="radio" name="kondisi_kelas" id="k3" value="Perlu Perhatian" class="condition-pill-input" {{ $curKondisi === 'Perlu Perhatian' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                    <label for="k3" class="condition-pill-label">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 12px;"></i> Perlu Perhatian
                    </label>
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
                        <span style="font-size: 11px; font-weight: 800; color: #15803d; background: #dcfce7; border: 1px solid #bbf7d0; padding: 3px 9px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-circle-check"></i> Foto Tersimpan
                        </span>
                    @else
                        <span style="font-size: 11px; font-weight: 800; color: #b91c1c; background: #fee2e2; border: 1px solid #fecdd3; padding: 3px 9px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-camera"></i> Live Kamera
                        </span>
                    @endif
                </label>

                <!-- Hidden Inputs for Form Submission -->
                <input type="hidden" name="foto_kehadiran_kamera" id="inputFotoKehadiranKamera" value="">
                <input type="hidden" name="hapus_dokumentasi" id="inputHapusDokumentasi" value="0">
                <input type="file" id="fallbackDirectCameraInput" accept="image/*" capture="environment" style="display: none;" onchange="handleFallbackCameraFile(event)">
                <canvas id="liveCameraCanvas" style="display: none;"></canvas>

                <!-- State 1: Placeholder Click Box -->
                <div id="cameraPlaceholderBox" class="camera-box-placeholder" onclick="{{ $canEditInputs ? 'startLiveCamera()' : '' }}" style="{{ $existingPhotoUrl ? 'display: none;' : '' }} {{ !$canEditInputs ? 'cursor: not-allowed; opacity: 0.7;' : '' }}">
                    <div class="camera-icon-circle">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <div style="font-size: 14px; font-weight: 800; color: #1e293b;">
                        {{ $canEditInputs ? 'Buka Kamera untuk Mengambil Foto Kehadiran' : 'Foto Kehadiran Belum Diunggah' }}
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: -4px;">
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
                        <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; margin-top: 4px; flex-wrap: wrap;">
                            <button type="button" onclick="startLiveCamera()" class="btn-draft" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 12px; padding: 8px 14px; border-radius: 10px; font-weight: 700;">
                                <i class="fa-solid fa-camera-rotate"></i> Ambil Ulang Foto Live
                            </button>
                            <button type="button" onclick="removeLivePhoto()" class="btn-draft" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; font-size: 12px; padding: 8px 14px; border-radius: 10px; font-weight: 700;">
                                <i class="fa-solid fa-trash-can"></i> Hapus Foto
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Presensi Ketidakhadiran Siswa -->
            <div style="margin-top: 30px; padding-top: 24px; border-top: 1px dashed #cbd5e1;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
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
                        <button type="button" onclick="resetAllAbsensiToHadir()" class="btn-draft" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 12.5px; padding: 8px 16px; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" title="Setel Ulang Semua Status Kehadiran Siswa ke Hadir (Default)">
                            <i class="fa-solid fa-rotate-left"></i> Reset Status Kehadiran
                        </button>
                    @endif
                </div>

                @php
                    $totalSiswaTelatDiKelas = count($siswaTelatMap ?? []);
                    $totalSiswaDispenDiKelas = count($dispenMap ?? []);
                @endphp
                @if($totalSiswaDispenDiKelas > 0)
                    <div style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border: 1px solid #e9d5ff; color: #6b21a8; padding: 12px 16px; border-radius: 14px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-file-signature" style="color: #9333ea; font-size: 18px; flex-shrink: 0;"></i>
                        <span>Pemberitahuan Waka Kesiswaan & Guru Piket: Terdapat <strong>{{ $totalSiswaDispenDiKelas }} siswa dispensasi resmi disetujui</strong> pada hari ini. Status <em>Dispen</em> telah otomatis disematkan dan dikunci oleh sistem.</span>
                    </div>
                @endif
                @if($totalSiswaTelatDiKelas > 0)
                    <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; color: #92400e; padding: 12px 16px; border-radius: 14px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-circle-exclamation" style="color: #d97706; font-size: 18px; flex-shrink: 0;"></i>
                        <span>Pemberitahuan Guru Piket: Terdapat <strong>{{ $totalSiswaTelatDiKelas }} siswa terlambat</strong> pada hari ini. Keterangan <em>(Siswa Tersebut Telat)</em> telah disematkan otomatis pada baris siswa terkait.</span>
                    </div>
                @endif

                <!-- Search Bar & Filter Controls -->
                <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                    <div style="position: relative; flex: 1;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                        <input type="text" id="searchSiswaInput" placeholder="Cari nama atau NISN siswa di kelas ini..." onkeyup="filterSiswaTable()" class="input-field-custom" style="padding: 10px 14px 10px 40px; font-size: 13px; border-radius: 10px; background: #ffffff;">
                    </div>
                    <button type="button" onclick="resetSiswaSearch()" class="btn-draft" style="padding: 10px 16px; font-size: 12.5px; border-radius: 10px; font-weight: 700;" title="Reset Kata Kunci Pencarian">
                        <i class="fa-solid fa-xmark"></i> Reset Cari
                    </button>
                </div>

                <div class="attendance-table-card">
                    <table class="attendance-table" id="tableAbsensiSiswa">
                        <thead>
                            <tr>
                                <th style="padding: 14px 20px;">Nama Siswa & Keterangan</th>
                                <th style="padding: 14px 20px; text-align: right;">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $sw)
                                @php
                                    $swId = $sw->id_siswa;
                                    $hasLeave = isset($suratIzinMap[$swId]);
                                    $leaveType = $hasLeave ? $suratIzinMap[$swId]['jenis'] : null;
                                    $hasTelat = isset($siswaTelatMap[$swId]);
                                    $telatInfo = $hasTelat ? $siswaTelatMap[$swId] : null;
                                    $hasDispen = isset($dispenMap[$swId]);
                                    $dispenInfo = $hasDispen ? $dispenMap[$swId] : null;
                                    $currentStatus = $existingAbsensi[$swId] ?? ($hasDispen ? 'Dispen' : ($leaveType ?? 'Hadir'));
                                @endphp
                                <tr class="siswa-row-item" data-id="{{ $swId }}" data-nama="{{ strtolower($sw->nama_siswa) }}" data-nisn="{{ strtolower($sw->nisn ?? '') }}" data-has-dispen="{{ $hasDispen ? 'true' : 'false' }}" style="{{ $hasDispen ? 'background: #faf5ff;' : ($hasTelat ? 'background: #fffdf5;' : '') }}">
                                    <td style="padding: 14px 20px; color: #0f172a; vertical-align: middle;">
                                        <div style="font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                            <span>{{ $sw->nama_siswa }}</span>
                                            @if($hasDispen)
                                                <span style="font-size: 11px; background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="Dispen Resmi Disetujui Waka Kesiswaan{{ $dispenInfo['jam'] }} &bull; Alasan: {{ $dispenInfo['alasan'] }}">
                                                    <i class="fa-solid fa-file-circle-check" style="color: #9333ea;"></i> (Dispen Disetujui Waka Kesiswaan{{ $dispenInfo['jam'] }})
                                                </span>
                                            @endif
                                            @if($hasTelat)
                                                <span style="font-size: 11px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="Siswa Tersebut Telat (Jam {{ $telatInfo['jam_terlambat'] }} WIB) &bull; Alasan: {{ $telatInfo['alasan'] }}">
                                                    <i class="fa-solid fa-user-clock" style="color: #d97706;"></i> (Siswa Tersebut Telat - Jam {{ $telatInfo['jam_terlambat'] }} WIB)
                                                </span>
                                            @endif
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b; font-weight: normal; margin-top: 3px; display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
                                            <span>NISN: <strong>{{ $sw->nisn ?? '-' }}</strong></span>
                                            @if($hasDispen && !empty($dispenInfo['alasan']))
                                                <span style="color: #6b21a8; font-weight: 600;">
                                                    &bull; Keperluan Dispen: <em>{{ Str::limit($dispenInfo['alasan'], 50) }}</em>
                                                </span>
                                            @endif
                                            @if($hasLeave)
                                                <span style="font-size: 10.5px; background: #e0f2fe; color: #0369a1; padding: 2px 7px; border-radius: 4px; font-weight: 700;">
                                                    <i class="fa-solid fa-file-medical"></i> {{ $leaveType }} Terverifikasi
                                                </span>
                                            @endif
                                            @if($hasTelat && !empty($telatInfo['alasan']))
                                                <span style="color: #92400e; font-weight: 600;">
                                                    &bull; Alasan Keterlambatan: <em>{{ Str::limit($telatInfo['alasan'], 45) }}</em>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 14px 20px; text-align: right; vertical-align: middle;">
                                        <div style="display: inline-flex; gap: 8px; font-size: 12px; font-weight: 700; flex-wrap: nowrap; justify-content: flex-end;">
                                            <label class="status-radio-pill pill-hadir" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                <input type="radio" name="siswa_status_{{ $swId }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Hadir')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                <span>Hadir</span>
                                            </label>
                                            <label class="status-radio-pill pill-sakit" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                <input type="radio" name="siswa_status_{{ $swId }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Sakit')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                <span>Sakit</span>
                                            </label>
                                            <label class="status-radio-pill pill-izin" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                <input type="radio" name="siswa_status_{{ $swId }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Izin')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                <span>Izin</span>
                                            </label>
                                            <label class="status-radio-pill pill-alpa" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                <input type="radio" name="siswa_status_{{ $swId }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Alpa')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                <span>Alpa</span>
                                            </label>
                                            <label class="status-radio-pill pill-dispen locked" title="{{ $hasDispen ? 'Status Dispen Disetujui Waka Kesiswaan' : 'Opsi Dispen hanya dapat diisi otomatis oleh sistem jika ada persetujuan resmi dari Waka Kesiswaan' }}">
                                                <input type="radio" name="siswa_status_{{ $swId }}" value="Dispen" {{ $currentStatus === 'Dispen' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Dispen')" {{ ($hasDispen && $canEditInputs) ? '' : 'disabled' }}>
                                                <span>Dispen</span>
                                                <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 2px;"></i>
                                            </label>
                                        </div>
                                        <div id="absence_input_wrap_{{ $swId }}">
                                            @if(in_array($currentStatus, ['Sakit', 'Izin', 'Alpa', 'Dispen']))
                                                <input type="hidden" name="ketidakhadiran[{{ $swId }}][id_siswa]" value="{{ $swId }}">
                                                <input type="hidden" name="ketidakhadiran[{{ $swId }}][keterangan]" value="{{ $currentStatus }}">
                                            @endif
                                        </div>
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
                function toggleAbsenceInput(idSiswa, status) {
                    const wrap = document.getElementById('absence_input_wrap_' + idSiswa);
                    if (!wrap) return;
                    if (status === 'Hadir') {
                        wrap.innerHTML = '';
                    } else {
                        wrap.innerHTML = '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][id_siswa]" value="' + idSiswa + '">' +
                                         '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][keterangan]" value="' + status + '">';
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
                        const hasDispen = row.getAttribute('data-has-dispen') === 'true';
                        if (hasDispen) return; // Dispen resmi tidak boleh di-reset ke Hadir

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

            <div class="form-actions-row">
                @if($canCancelSubmit)
                    <!-- Batal Kirim Jurnal Button (Triggers standalone form outside main form) -->
                    <button type="button" onclick="confirmBatalKirimJurnal()" class="btn-draft" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; font-weight: 800; padding: 10px 18px; border-radius: 12px; cursor: pointer; transition: all 0.15s ease;" title="Batalkan pengiriman jurnal dan kembalikan ke status Belum Diisi (Hanya aktif selama jam pelajaran berlangsung)">
                        <i class="fa-solid fa-rotate-left"></i> Batal Kirim Jurnal
                    </button>
                @endif

                @if($canSubmitOrUpdate)
                    <button type="submit" name="action" value="draft" class="btn-draft">
                        <i class="fa-regular fa-bookmark"></i> Simpan Draft
                    </button>

                    <button type="submit" name="action" value="save" class="btn-submit-jurnal">
                        <i class="fa-solid fa-paper-plane"></i> {{ $isSubmittedFinal ? 'Perbarui Jurnal' : 'Simpan Jurnal' }}
                    </button>
                @elseif($isJamSelesai && !$isAdminPiket)
                    @if($isSubmittedFinal)
                        <!-- Submitted & Class Ended: Locked indicator shown -->
                        <div style="padding: 10px 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; color: #475569; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-lock" style="color: #64748b;"></i> Jurnal Terkunci Final (Jam Pelajaran Berakhir)
                        </div>
                    @else
                        <!-- Not Submitted & Class Ended: Disabled button with soft rose styling -->
                        <button type="button" disabled style="padding: 10px 20px; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; color: #be123c; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran KBM telah berakhir. Pengisian jurnal telah ditutup.">
                            <i class="fa-solid fa-ban"></i> Pengisian Ditutup (Waktu Habis)
                        </button>
                    @endif
                @elseif(!$isJamStarted && !$isAdminPiket)
                    <button type="button" disabled style="padding: 10px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; color: #94a3b8; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran belum dimulai (Pukul {{ $selectedJadwal->waktu_mulai_effective ?? '' }} WIB)">
                        <i class="fa-solid fa-lock"></i> Belum Memasuki Jam Pelajaran
                    </button>
                @endif
            </div>

            <div class="bottom-info-banner">
                <i class="fa-solid fa-shield-halved" style="color: #16a34a; font-size: 15px;"></i>
                <span>Jurnal hanya dapat diisi saat jam mengajar sedang berlangsung sesuai data alokasi master TU</span>
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

    <!-- Bottom Summary & Progress Widgets (2 Gradient Cards Side-by-Side - NO CHEVRON ARROWS) -->
    <div class="jurnal-bottom-widgets-grid">
        <!-- Widget 1: Riwayat Jurnal Hari Ini (Card Theme Blue) -->
        <div class="widget-gradient-card card-theme-blue">
            <div>
                <div class="widget-header-row">
                    <div class="widget-header-title-box">
                        <div class="stat-circle-icon icon-solid-blue">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h3 class="widget-title-text">Riwayat Jurnal Hari Ini</h3>
                            <p class="widget-subtitle-text">{{ $todayCarbon->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <span style="font-size: 11px; background: #eff6ff; color: #2563eb; padding: 2.5px 9px; border-radius: 20px; font-weight: 700; border: 1px solid #dbeafe;">
                        {{ count($riwayatHariIni) }} Sesi
                    </span>
                </div>

                <div style="margin-top: 4px;">
                    @forelse($riwayatHariIni as $rItem)
                        @php
                            $jObj = $rItem->jadwal;
                        @endphp
                        <div class="history-item">
                            <div>
                                <div class="history-class">
                                    {{ $jObj->kelas->nama_kelas ?? 'Kelas' }} &bull; {{ $jObj->ruangan->nama_ruangan ?? 'Ruangan' }}
                                </div>
                                <div class="history-date">
                                    {{ $jObj->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $jObj->waktu_mulai_effective }} - {{ $jObj->waktu_selesai_effective }})
                                </div>
                            </div>
                            @if($rItem->is_terisi)
                                @if($rItem->is_draft)
                                    <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 700; padding: 2.5px 8px; border-radius: 6px;">DRAFT</span>
                                @else
                                    <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 11px; font-weight: 700; padding: 2.5px 8px; border-radius: 6px;">TERISI</span>
                                @endif
                            @else
                                <span style="background: #f3f4f6; color: #4b5563; font-size: 11px; font-weight: 700; padding: 2.5px 8px; border-radius: 6px; border: 1px solid #e5e7eb;">BELUM</span>
                            @endif
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8; padding: 14px 0; text-align: center;">Belum ada jadwal mengajar pada hari ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Widget 2: Progres Bulanan (Card Theme Purple) -->
        <div class="widget-gradient-card card-theme-purple">
            <div>
                <div class="widget-header-row">
                    <div class="widget-header-title-box">
                        <div class="stat-circle-icon icon-solid-purple">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <div>
                            <h3 class="widget-title-text">Progres Bulanan</h3>
                            <p class="widget-subtitle-text">{{ $todayCarbon->translatedFormat('F Y') }}</p>
                        </div>
                    </div>
                    @php
                        $pctBulanan = min(100, (int) round(($progresBulanan['terisi'] / max(1, $progresBulanan['target'])) * 100));
                    @endphp
                    <span style="font-size: 11px; background: #faf5ff; color: #7c3aed; padding: 2.5px 9px; border-radius: 20px; font-weight: 700; border: 1px solid #ede9fe;">
                        {{ $pctBulanan }}%
                    </span>
                </div>

                <div style="margin-top: 4px;">
                    <div class="progress-row">
                        <span style="font-size: 13px; font-weight: 600; color: #64748b;">Jurnal Terisi</span>
                        <span style="font-size: 15px; font-weight: 800; color: #0f172a;">{{ $progresBulanan['terisi'] }} / {{ $progresBulanan['target'] }}</span>
                    </div>

                    <div style="width: 100%; height: 7px; background: #f1f5f9; border-radius: 9999px; overflow: hidden; margin: 10px 0; border: 1px solid #e2e8f0;">
                        <div style="width: {{ $pctBulanan }}%; height: 100%; background: linear-gradient(90deg, #8B5CF6, #A78BFA); border-radius: 9999px; transition: width 0.3s ease;"></div>
                    </div>

                    <div class="progress-row">
                        <span style="font-size: 13px; font-weight: 600; color: #64748b;">Rata-rata per Minggu</span>
                        <span style="font-size: 15px; font-weight: 800; color: #7c3aed;">{{ $progresBulanan['rata_minggu'] }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Jurnal</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
