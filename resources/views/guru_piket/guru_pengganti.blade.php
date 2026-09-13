@extends('layouts.guru')

@section('title', 'Guru Pengganti — Guru Piket')
@section('header_title', 'Guru Pengganti')

@section('styles')
<style>
    /* Root Page Layout */
    .guru-pengganti-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }

    /* Common Card Styles */
    .gp-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03);
    }

    /* 2. Form Card Header */
    .gp-form-header {
        display: flex;
        align-items: center;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .gp-form-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .gp-header-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .gp-form-header-titles h2 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.25;
    }

    .gp-form-header-titles p {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
        margin-bottom: 0;
    }

    /* Form Fields & Controls */
    .gp-form-grid {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .gp-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .gp-grid-3col {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    /* Two Visual Accent Columns for Absent Teacher vs Substitute Teacher */
    .gp-section-tidak-hadir {
        background: linear-gradient(135deg, rgba(239, 246, 255, 0.65) 0%, rgba(248, 250, 252, 0.4) 100%);
        border: 1px solid #dbeafe;
        border-left: 4px solid #2563eb;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .gp-section-tidak-hadir:hover {
        border-color: #bfdbfe;
        box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.06);
    }

    .gp-section-pengganti {
        background: linear-gradient(135deg, rgba(236, 253, 245, 0.65) 0%, rgba(248, 250, 252, 0.4) 100%);
        border: 1px solid #bbf7d0;
        border-left: 4px solid #10b981;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .gp-section-pengganti:hover {
        border-color: #86efac;
        box-shadow: 0 4px 15px -3px rgba(16, 185, 129, 0.06);
    }

    .gp-field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        position: relative;
    }

    .gp-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .gp-label i {
        font-size: 13px;
    }

    .gp-label .req {
        color: #ef4444;
        font-weight: 800;
    }

    .gp-input-text,
    .gp-select,
    .gp-textarea {
        width: 100%;
        padding: 9px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
        font-weight: 600;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .gp-input-text:focus,
    .gp-select:focus,
    .gp-textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: #ffffff;
    }

    .gp-input-search-inner {
        position: relative;
        margin-bottom: 4px;
    }

    .gp-input-search-inner i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }

    .gp-input-search-inner input {
        width: 100%;
        padding: 8px 12px 8px 32px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 11.5px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .gp-input-search-inner input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .gp-btn-toggle-options-blue {
        background: #eff6ff;
        color: #2563eb;
        border: 1px dashed #93c5fd;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
        align-self: flex-start;
        transition: all 0.2s ease;
    }
    .gp-btn-toggle-options-blue:hover {
        background: #dbeafe;
        border-color: #60a5fa;
    }

    .gp-btn-toggle-options-green {
        background: #ecfdf5;
        color: #059669;
        border: 1px dashed #a7f3d0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
        align-self: flex-start;
        transition: all 0.2s ease;
    }
    .gp-btn-toggle-options-green:hover {
        background: #d1fae5;
        border-color: #6ee7b7;
    }

    /* Modern Sehari Penuh Toggle Container */
    .gp-toggle-container {
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
    }

    .gp-toggle-container.is-active {
        background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
        border-color: #3b82f6;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12);
    }

    .gp-toggle-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .gp-toggle-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .gp-toggle-container.is-active .gp-toggle-icon {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }

    .gp-toggle-text strong {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #1e40af;
    }

    .gp-toggle-text span {
        font-size: 11.5px;
        font-weight: 500;
        color: #3b82f6;
    }

    /* Switch Component with clear active state */
    .modern-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
        flex-shrink: 0;
    }

    .modern-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .modern-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 34px;
    }

    .modern-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: #ffffff;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .modern-switch input:checked + .modern-slider {
        background-color: #2563eb !important;
        box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);
    }

    .modern-switch input:checked + .modern-slider:before {
        transform: translateX(22px);
    }

    /* Date Day Badge Pill */
    .gp-date-badge {
        font-size: 11.5px;
        font-weight: 700;
        color: #2563eb;
        background: #f0f7ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 4px 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        width: fit-content;
    }

    /* Custom File Input Container */
    .gp-file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #ffffff;
        padding: 4px 8px;
        transition: border-color 0.2s ease;
    }

    .gp-file-input-wrapper:hover {
        border-color: #93c5fd;
    }

    .gp-file-input-wrapper input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .gp-file-btn {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        pointer-events: none;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .gp-file-name {
        margin-left: 10px;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Form Actions */
    .gp-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    /* Enhanced Reset Form Button (Amber/Yellow Outline Style) */
    .gp-btn-reset {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .gp-btn-reset:hover {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
        transform: translateY(-1px);
    }

    .gp-btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .gp-btn-submit:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    /* 3. 3 Stat Cards Grid - GRADIENT CARDS STYLE */
    .gp-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        width: 100%;
    }

    .gp-stat-gradient-card {
        border-radius: 20px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .gp-stat-gradient-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.06);
    }

    /* Stat Themes */
    .card-theme-blue {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eff6ff 100%);
        border: 1px solid rgba(219, 234, 254, 0.75);
    }
    .text-theme-blue { color: #2563eb; }
    .wave-theme-blue { color: #bfdbfe; opacity: 0.75; }

    .card-theme-amber {
        background: linear-gradient(135deg, #ffffff 0%, #fffcf7 50%, #fff7ed 100%);
        border: 1px solid rgba(254, 215, 170, 0.75);
    }
    .text-theme-amber { color: #d97706; }
    .wave-theme-amber { color: #fed7aa; opacity: 0.75; }

    .card-theme-emerald {
        background: linear-gradient(135deg, #ffffff 0%, #f9fdfa 50%, #f0fdf4 100%);
        border: 1px solid rgba(167, 243, 208, 0.75);
    }
    .text-theme-emerald { color: #059669; }
    .wave-theme-emerald { color: #bbf7d0; opacity: 0.75; }

    .gp-stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 2;
    }

    /* Circular Solid Colored Icon Box */
    .gp-stat-circle-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .circle-icon-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
    }

    .circle-icon-amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.28);
    }

    .circle-icon-emerald {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.28);
    }

    .gp-stat-details {
        display: flex;
        flex-direction: column;
    }

    .gp-stat-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .gp-stat-value-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .gp-stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .gp-stat-unit {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .gp-stat-subtext {
        font-size: 10.5px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 2px;
    }

    .gp-stat-link {
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        position: relative;
        z-index: 2;
        padding: 4px 8px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .gp-stat-link:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: translateX(2px);
    }

    /* Decorative Corner Elements (Sparkles) */
    .stat-corner-elem {
        position: absolute;
        top: 12px;
        right: 14px;
        z-index: 2;
        pointer-events: none;
    }

    /* Decorative Bottom-Right Wave */
    .stat-card-wave {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 100px;
        height: 52px;
        pointer-events: none;
        z-index: 1;
    }

    /* 4. Table Card & Filters */
    .gp-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03);
    }

    .gp-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .gp-table-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .gp-table-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f3e8ff;
        color: #9333ea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .gp-table-title-group h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .gp-btn-trash-pill {
        background: #fee2e2;
        color: #ef4444;
        border: 1px solid #fecaca;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .gp-btn-trash-pill:hover {
        background: #fca5a5;
        color: #991b1b;
    }

    /* Two-Row Filter Toolbar */
    .gp-filter-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 18px;
    }

    .gp-filter-row-1,
    .gp-filter-row-2 {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .gp-filter-search-box {
        flex: 1.5;
        min-width: 220px;
        position: relative;
    }

    .gp-filter-search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .gp-filter-search-box input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
    }

    .gp-filter-search-box input:focus {
        border-color: #2563eb;
    }

    .gp-filter-date-box {
        flex: 1;
        min-width: 140px;
    }

    .gp-filter-date-box input {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
    }

    .gp-filter-select-box {
        flex: 1;
        min-width: 160px;
    }

    .gp-filter-select-box select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        color: #334155;
        font-weight: 600;
    }

    .gp-btn-filter-dark {
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: background 0.2s ease;
    }

    .gp-btn-filter-dark:hover {
        background: #0f172a;
    }

    /* Filter Reset Button (Amber Outline Style) */
    .gp-btn-filter-reset {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .gp-btn-filter-reset:hover {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }

    .gp-btn-bulk-delete {
        background: #fee2e2;
        color: #ef4444;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        opacity: 0.5;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    /* Table Styling */
    .gp-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
    }

    .gp-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }

    .gp-table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .gp-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .gp-table tbody tr:hover td {
        background: #fbfcfe;
    }

    /* Distinct Status Badges */
    .gp-status-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .gp-status-aktif {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .gp-status-aktif .gp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
    }

    .gp-status-selesai {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .gp-status-selesai .gp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #64748b;
    }

    .gp-status-dibatalkan {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }
    .gp-status-dibatalkan .gp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f43f5e;
    }

    /* Action Buttons */
    .gp-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .gp-action-btn:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .gp-action-edit:hover {
        background: #d97706 !important;
        border-color: #d97706 !important;
    }

    .gp-action-delete:hover {
        background: #ef4444 !important;
        border-color: #ef4444 !important;
    }

    /* Empty State */
    .gp-empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .gp-empty-state i {
        font-size: 38px;
        color: #93c5fd;
        margin-bottom: 10px;
        display: block;
    }

    .gp-empty-state p {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    /* Table Footer & Pagination */
    .gp-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .gp-pagination-info {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .gp-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .gp-page-btn {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        border-radius: 7px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .gp-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Modal Overlay & Card */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-content-custom {
        background: #ffffff;
        width: 100%;
        max-width: 640px;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .modal-title-custom {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Alerts */
    .gp-alert {
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .gp-alert-success {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .gp-alert-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }

    /* Input Error & Validation */
    .input-error-border {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .field-error-text {
        font-size: 11.5px;
        color: #dc2626;
        font-weight: 700;
        margin-top: 3px;
    }

    @media (max-width: 992px) {
        .gp-grid-2col, .gp-grid-3col { grid-template-columns: 1fr; }
        .gp-stat-grid { grid-template-columns: 1fr; }
        .gp-filter-row-1, .gp-filter-row-2 { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')
<div class="guru-pengganti-wrapper">

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="gp-alert gp-alert-success">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="gp-alert gp-alert-danger">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
            <div>
                <strong>Terdapat kesalahan atau kendala penugasan:</strong>
                <ul style="margin-top: 4px; padding-left: 20px; margin-bottom: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- 2. Form Penugasan Guru Pengganti (Card Atas) -->
    <div class="gp-card">
        <div class="gp-form-header">
            <div class="gp-form-header-left">
                <div class="gp-header-icon-box">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="gp-form-header-titles">
                    <h2>Tambah Guru Pengganti</h2>
                    <p>Lengkapi data guru pengganti sesuai kebutuhan.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('piket.guru-pengganti.store') }}" method="POST" enctype="multipart/form-data" id="formDirectPenugasan">
            @csrf
            <input type="hidden" name="id_jadwal" id="input_id_jadwal" value="{{ old('id_jadwal') }}">
            
            <div class="gp-form-grid">
                
                <!-- ROW 1: Guru Tidak Hadir & Guru Pengganti (Visual Accents per Section) -->
                <div class="gp-grid-2col">
                    
                    <!-- Left Section: Guru Tidak Hadir (Blue Border & Tint) -->
                    <div class="gp-section-tidak-hadir">
                        <label class="gp-label" style="color: #1e3a8a;">
                            <i class="fa-solid fa-user-xmark" style="color: #2563eb;"></i>
                            <span>Guru Tidak Hadir (Izin / Sakit) <span class="req">*</span></span>
                        </label>
                        
                        <div class="gp-input-search-inner">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search_guru_tidak_hadir" placeholder="Cari Nama / NIP Guru Tidak Hadir..." onkeyup="filterSelectOptions('select_guru_tidak_hadir', this.value)">
                        </div>

                        <select name="id_guru_tidak_hadir" id="select_guru_tidak_hadir" data-old-val="{{ old('id_guru_tidak_hadir', $selectedGuruTidakHadirId ?? '') }}" class="gp-select @error('id_guru_tidak_hadir') input-error-border @enderror" required onchange="onGuruTidakHadirChanged(this)">
                            <option value="">- Pilih Guru Tidak Hadir (Tersedia Data Guru Izin/Sakit) -</option>
                            <optgroup label="✅ Guru Izin Tidak Hadir (Disetujui Waka & Kepala Sekolah)">
                                @forelse($guruTidakHadirOptions as $iz)
                                    @if($iz->guru)
                                        @php
                                            $isSelected = (old('id_guru_tidak_hadir') == $iz->id_guru) || (isset($selectedGuruTidakHadirId) && ($selectedGuruTidakHadirId == $iz->id_guru || $selectedGuruTidakHadirId == $iz->id_guru_izin));
                                        @endphp
                                        <option value="{{ $iz->id_guru }}" data-id-izin="{{ $iz->id_guru_izin }}" data-materi="{{ $iz->materi_dititipkan ?? '' }}" data-tugas="{{ $iz->tugas_dititipkan ?? '' }}" {{ $isSelected ? 'selected' : '' }}>
                                            ✅ {{ $iz->guru->nama_guru }} (NIP: {{ $iz->guru->nip ?? '-' }}) [Disetujui Waka & Kepsek | {{ $iz->alasan }} - {{ $iz->durasi_formatted }}]
                                        </option>
                                    @endif
                                @empty
                                    <option value="" disabled>-- Tidak Ada Guru Izin Tidak Hadir yang Disetujui Saat Ini --</option>
                                @endforelse
                            </optgroup>
                        </select>

                        <button type="button" id="btnToggleGuruTidakHadirLainnya" class="gp-btn-toggle-options-blue" onclick="toggleGuruTidakHadirLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>

                        <!-- Dynamic schedule chips container for absent teacher -->
                        <div id="wrapper_jadwal_pilihan" style="display: none; margin-top: 6px; background: #ffffff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px; font-size: 12px; color: #1e3a8a; box-shadow: 0 2px 6px rgba(37,99,235,0.06);">
                            <strong><i class="fa-solid fa-list-check" style="color: #2563eb;"></i> Sesi Jadwal Mengajar Guru Ini Hari Ini (Klik untuk Otomatis Mengisi):</strong>
                            <div id="jadwal_pilihan_list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;"></div>
                        </div>

                        @error('id_guru_tidak_hadir')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Right Section: Guru Pengganti (Green/Emerald Border & Tint) -->
                    <div class="gp-section-pengganti">
                        <label class="gp-label" style="color: #065f46;">
                            <i class="fa-solid fa-user-check" style="color: #059669;"></i>
                            <span>Guru Pengganti (Prioritas Guru Piket) <span class="req">*</span></span>
                        </label>

                        <div class="gp-input-search-inner">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search_guru_pengganti" placeholder="Cari Nama / NIP Guru Pengganti..." onkeyup="filterSelectOptions('select_guru_pengganti', this.value)">
                        </div>

                        <select name="id_guru_pengganti" id="select_guru_pengganti" data-old-val="{{ old('id_guru_pengganti') }}" class="gp-select @error('id_guru_pengganti') input-error-border @enderror" required>
                            <option value="">- Pilih Guru Pengganti -</option>
                            <optgroup label="📌 Guru Piket Hari Ini (Tampil Utama)">
                                @foreach($guruList as $g)
                                    @if(!empty($g->is_piket_today))
                                        <option value="{{ $g->id_guru }}" {{ old('id_guru_pengganti') == $g->id_guru ? 'selected' : '' }}>
                                            [Guru Piket] {{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }})
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>

                        <button type="button" id="btnToggleGuruLainnya" class="gp-btn-toggle-options-green" onclick="toggleGuruMengajarLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>

                        @error('id_guru_pengganti')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- ROW 2: OPSI PENUGASAN SEHARI PENUH (Modern Responsive Toggle Switch) -->
                <div class="gp-toggle-container {{ old('sehari_penuh') ? 'is-active' : '' }}">
                    <div class="gp-toggle-info">
                        <div class="gp-toggle-icon">
                            <i class="fa-solid fa-calendar-week"></i>
                        </div>
                        <div class="gp-toggle-text">
                            <strong>Guru Tidak Hadir Sehari Penuh</strong>
                            <span>(Otomatis Tambahkan Semua Jam Pelajaran & Kelas Hari Ini)</span>
                        </div>
                    </div>

                    <label class="modern-switch">
                        <input type="checkbox" name="sehari_penuh" id="check_sehari_penuh" value="1" {{ old('sehari_penuh') ? 'checked' : '' }} onchange="toggleSehariPenuh(this)">
                        <span class="modern-slider"></span>
                    </label>
                </div>

                <div id="preview_sehari_penuh_box" style="display: none; background: #ffffff; padding: 14px; border-radius: 12px; border: 1px solid #93c5fd; color: #1e3a8a; font-size: 12px; box-shadow: 0 2px 8px rgba(37,99,235,0.06);">
                    <i class="fa-solid fa-spinner fa-spin"></i> Memuat jadwal guru tidak hadir...
                </div>

                <!-- ROW 3: Tanggal Penugasan, Jam Pelajaran (Master TU), dan Kelas -->
                <div class="gp-grid-3col">
                    
                    <!-- Tanggal Penugasan -->
                    <div class="gp-field-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-calendar" style="color: #2563eb;"></i>
                            <span>Tanggal Penugasan <span class="req">*</span></span>
                        </label>
                        <input type="date" name="tanggal" id="input_tanggal_penugasan" value="{{ old('tanggal', $todayDate) }}" class="gp-input-text @error('tanggal') input-error-border @enderror" required onchange="onTanggalPenugasanChanged()">
                        
                        <div id="label_hari_penugasan" class="gp-date-badge">
                            <i class="fa-regular fa-calendar-check"></i> Hari: <span id="text_nama_hari">-</span>
                        </div>

                        <div id="label_warning_past_date" style="font-size: 11.5px; font-weight: 800; color: #dc2626; margin-top: 4px; display: none;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Tanggal yang dipilih telah berlalu! Penugasan tidak dapat disimpan.
                        </div>

                        @error('tanggal')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jam Pelajaran (Master TU) -->
                    <div class="gp-field-group" id="wrapper_jam_pelajaran">
                        <label class="gp-label">
                            <i class="fa-regular fa-clock" style="color: #2563eb;"></i>
                            <span>Jam Pelajaran (Master TU) <span class="req">*</span></span>
                        </label>
                        <select name="jam_pelajaran" id="select_jam_pelajaran" data-old-val="{{ old('jam_pelajaran') }}" class="gp-select @error('jam_pelajaran') input-error-border @enderror" required>
                            <option value="">-- Pilih Jam Pelajaran (Master TU) --</option>
                        </select>

                        <!-- Search Jam Pelajaran -->
                        <div class="gp-input-search-inner" style="margin-top: 4px; margin-bottom: 0;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search_jam_pelajaran" placeholder="Cari Sesuai Jam Pelajaran (misal: 1, 7-8, 10:15)..." onkeyup="filterSelectOptions('select_jam_pelajaran', this.value)">
                        </div>

                        @error('jam_pelajaran')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div class="gp-field-group" id="wrapper_kelas">
                        <label class="gp-label">
                            <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i>
                            <span>Kelas <span class="req">*</span></span>
                        </label>
                        <select name="id_kelas" id="select_kelas" class="gp-select @error('id_kelas') input-error-border @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- ROW 4: Titipan Materi Pembelajaran (Opsional) -->
                <div class="gp-field-group">
                    <label class="gp-label">
                        <i class="fa-regular fa-bookmark" style="color: #2563eb;"></i>
                        <span>Titipan Materi Pembelajaran <span style="color: #64748b; font-weight: 500;">(Opsional)</span></span>
                    </label>
                    <textarea name="materi_dititipkan" id="materi_dititipkan_field" rows="2" placeholder="Tuliskan pokok bahasan / materi yang dititipkan oleh guru utama..." class="gp-textarea" style="resize: vertical;">{{ old('materi_dititipkan') }}</textarea>
                </div>

                <!-- ROW 5: Titipan Tugas / Instruksi Kelas (Opsional) -->
                <div class="gp-field-group">
                    <label class="gp-label">
                        <i class="fa-regular fa-clipboard" style="color: #2563eb;"></i>
                        <span>Titipan Tugas / Instruksi Kelas <span style="color: #64748b; font-weight: 500;">(Opsional)</span></span>
                    </label>
                    <textarea name="tugas_dititipkan" id="tugas_dititipkan_field" rows="2" placeholder="Tuliskan instruksi tugas atau soal latihan untuk siswa di kelas..." class="gp-textarea" style="resize: vertical;">{{ old('tugas_dititipkan') }}</textarea>
                </div>

                <!-- ROW 6: Upload File Tugas (Opsional) & Catatan Tambahan Piket -->
                <div class="gp-grid-2col">
                    
                    <div class="gp-field-group">
                        <label class="gp-label">
                            <i class="fa-solid fa-paperclip" style="color: #2563eb;"></i>
                            <span>Upload File Tugas <span style="color: #64748b; font-weight: 500;">(Opsional)</span></span>
                        </label>
                        <div class="gp-file-input-wrapper">
                            <input type="file" name="file_tugas" id="input_file_tugas" class="@error('file_tugas') input-error-border @enderror" onchange="updateFileNameDisplay(this)">
                            <button type="button" class="gp-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Pilih File
                            </button>
                            <span class="gp-file-name" id="fileNameDisplay">Tidak ada file yang dipilih</span>
                        </div>
                        @error('file_tugas')
                            <div class="field-error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="gp-field-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-comment-dots" style="color: #2563eb;"></i>
                            <span>Catatan Tambahan Piket</span>
                        </label>
                        <input type="text" name="catatan" id="input_catatan" value="{{ old('catatan') }}" placeholder="Keterangan penugasan..." class="gp-input-text">
                    </div>

                </div>

            </div>

            <!-- Form Actions -->
            <div class="gp-form-actions">
                <button type="button" class="gp-btn-reset" onclick="resetFormDirectPenugasan()">
                    <i class="fa-solid fa-arrows-rotate"></i> Reset Form
                </button>
                <button type="submit" class="gp-btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Simpan Penugasan Guru Pengganti
                </button>
            </div>
        </form>
    </div>

    <!-- 3. Grid 3 Kartu Statistik (Gaya Gradient Card Dinamis & Hidup) -->
    <div class="gp-stat-grid">
        
        <!-- Card 1: Guru Tidak Hadir (Blue Theme) -->
        <div class="gp-stat-gradient-card card-theme-blue">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon circle-icon-blue">
                    <i class="fa-solid fa-location-dot" style="font-size: 18px;"></i>
                </div>
                <div class="gp-stat-details">
                    <span class="gp-stat-label text-theme-blue">Guru Tidak Hadir</span>
                    <div class="gp-stat-value-wrap">
                        <span class="gp-stat-value">{{ $stats['guruTidakHadir'] }}</span>
                        <span class="gp-stat-unit">Guru</span>
                    </div>
                    <span class="gp-stat-subtext">Terdata izin / sakit hari ini</span>
                </div>
            </div>
            <a href="#" onclick="openModalStatGuruTidakHadir(); return false;" class="gp-stat-link text-theme-blue">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>

            <!-- Corner Sparkle Deco -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #60a5fa;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 2: Guru Pengganti (Amber/Yellow Theme) -->
        <div class="gp-stat-gradient-card card-theme-amber">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon circle-icon-amber">
                    <i class="fa-solid fa-user-group" style="font-size: 17px;"></i>
                </div>
                <div class="gp-stat-details">
                    <span class="gp-stat-label text-theme-amber">Guru Pengganti</span>
                    <div class="gp-stat-value-wrap">
                        <span class="gp-stat-value">{{ $stats['guruPengganti'] }}</span>
                        <span class="gp-stat-unit">Guru</span>
                    </div>
                    <span class="gp-stat-subtext">Bertugas piket & pengganti</span>
                </div>
            </div>
            <a href="#" onclick="openModalStatGuruPengganti(); return false;" class="gp-stat-link text-theme-amber">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>

            <!-- Corner Sparkle Deco -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #fbbf24;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-amber" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 3: Penugasan Aktif (Emerald/Green Theme) -->
        <div class="gp-stat-gradient-card card-theme-emerald">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon circle-icon-emerald">
                    <i class="fa-solid fa-calendar-check" style="font-size: 18px;"></i>
                </div>
                <div class="gp-stat-details">
                    <span class="gp-stat-label text-theme-emerald">Penugasan Aktif</span>
                    <div class="gp-stat-value-wrap">
                        <span class="gp-stat-value">{{ $stats['penugasanAktif'] }}</span>
                        <span class="gp-stat-unit">Penugasan</span>
                    </div>
                    <span class="gp-stat-subtext">Sesi jam berjalan hari ini</span>
                </div>
            </div>
            <a href="{{ route('piket.guru-pengganti', ['status' => 'aktif']) }}" class="gp-stat-link text-theme-emerald">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>

            <!-- Corner Sparkle Deco -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #34d399;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>

            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

    </div>

    <!-- 4. Table Card "Daftar Penugasan Guru Pengganti" -->
    <div class="gp-table-card" id="penugasanTable">
        
        <div class="gp-table-header">
            <div class="gp-table-title-group">
                <div class="gp-table-icon-box">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <h3>Daftar Penugasan Guru Pengganti</h3>
            </div>
            
            <button type="button" onclick="openTrashModal()" class="gp-btn-trash-pill">
                <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashCount }})
            </button>
        </div>

        <!-- Filter & Search Section (2 Rows) -->
        <form action="{{ route('piket.guru-pengganti') }}" method="GET" class="gp-filter-container">
            
            <!-- Row 1 Filters -->
            <div class="gp-filter-row-1">
                <div class="gp-filter-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari Guru / Mapel / Kelas...">
                </div>

                <div class="gp-filter-date-box">
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" title="Filter Tanggal">
                </div>

                <div class="gp-filter-select-box">
                    <select name="id_kelas">
                        <option value="">Kelas: Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-filter-select-box">
                    <select name="id_mapel">
                        <option value="">Mata Pelajaran: Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2 Filters & Actions -->
            <div class="gp-filter-row-2">
                <div class="gp-filter-select-box" style="max-width: 220px;">
                    <select name="status">
                        <option value="">Status: Semua Status</option>
                        <option value="aktif" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $statusFilter === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <button type="submit" class="gp-btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <!-- Filter Reset Button (Amber Outline Style) -->
                <a href="{{ route('piket.guru-pengganti') }}" class="gp-btn-filter-reset">
                    <i class="fa-solid fa-arrows-rotate"></i> Reset
                </a>

                <!-- Contextual Bulk Delete Button -->
                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="gp-btn-bulk-delete" title="Hapus Data Terpilih">
                    <i class="fa-regular fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>

        </form>

        <!-- Main Penugasan Table -->
        <div class="gp-table-wrapper">
            <table class="gp-table">
                <thead>
                    <tr>
                        <th style="width: 42px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer; accent-color: #2563eb;">
                        </th>
                        <th>Tanggal</th>
                        <th>Guru Tidak Hadir</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam</th>
                        <th>Guru Pengganti</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penugasans as $row)
                        @php
                            $tgl = isset($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $tglFormatted = $tgl ? $tgl->format('d/m/Y') : '-';
                            
                            $stTeks = strtolower($row->status_teks ?? ($row->status ?? 'aktif'));
                            $stClass = 'gp-status-aktif';
                            if ($stTeks === 'selesai') $stClass = 'gp-status-selesai';
                            if ($stTeks === 'dibatalkan') $stClass = 'gp-status-dibatalkan';

                            $guruTidakHadirNama = $row->guru_tidak_hadir_nama ?? ($row->guruTidakHadir->nama_guru ?? 'Guru Tidak Hadir');
                            $guruPenggantiNama  = $row->guru_pengganti_nama ?? ($row->guruPengganti->nama_guru ?? 'Guru Pengganti');
                            $kelasNama          = $row->kelas_nama ?? ($row->kelas->nama_kelas ?? '-');
                            $mapelNama          = $row->mapel_nama ?? ($row->guruTidakHadir->mapel->nama_mapel ?? '-');
                            $jamStr             = $row->jam ?? ($row->jam_pelajaran ?? '-');

                            $jsonData = [
                                'id_penugasan'         => $row->id_penugasan ?? null,
                                'tanggal'              => $row->tanggal ?? '',
                                'id_guru_tidak_hadir'  => $row->id_guru_tidak_hadir ?? null,
                                'guru_tidak_hadir_nama'=> $guruTidakHadirNama,
                                'id_guru_pengganti'    => $row->id_guru_pengganti ?? null,
                                'guru_pengganti_nama'  => $guruPenggantiNama,
                                'id_kelas'             => $row->id_kelas ?? null,
                                'kelas_nama'           => $kelasNama,
                                'mapel_nama'           => $mapelNama,
                                'jam_pelajaran'        => $jamStr,
                                'status'               => $stTeks,
                                'materi_dititipkan'    => $row->materi_dititipkan ?? '',
                                'tugas_dititipkan'     => $row->tugas_dititipkan ?? '',
                                'file_tugas'           => $row->file_tugas ?? '',
                                'catatan'              => $row->catatan ?? '',
                            ];
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="guru-pengganti-checkbox" value="{{ $row->id_penugasan }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer; accent-color: #2563eb;">
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #0f172a;">{{ $tglFormatted }}</span>
                            </td>
                            <td>
                                <strong style="color: #1e293b;">{{ $guruTidakHadirNama }}</strong>
                            </td>
                            <td>
                                <span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px; color: #334155;">{{ $kelasNama }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #0f172a;">{{ $mapelNama }}</span>
                            </td>
                            <td>{{ $jamStr }}</td>
                            <td>
                                <strong style="color: #2563eb;">{{ $guruPenggantiNama }}</strong>
                            </td>
                            <td>
                                <span class="gp-status-badge {{ $stClass }}">
                                    <span class="gp-status-dot"></span>
                                    {{ ucfirst($stTeks) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <!-- Detail -->
                                    <button type="button" class="gp-action-btn" onclick='showDetailModalComplete(@json($jsonData))' title="Lihat Detail Lengkap">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    @if(isset($row->id_penugasan) && is_numeric($row->id_penugasan))
                                        <!-- Edit -->
                                        <button type="button" class="gp-action-btn gp-action-edit" onclick='openEditModal(@json($jsonData))' title="Edit Penugasan">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- Delete / Pindah ke Sampah -->
                                        <form action="{{ route('piket.guru-pengganti.destroy', $row->id_penugasan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Pindahkan penugasan ini ke Sampah?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="gp-action-btn gp-action-delete" style="color: #ef4444;" title="Pindahkan ke Sampah">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="gp-empty-state">
                                    <i class="fa-regular fa-file-lines"></i>
                                    <p>Belum ada penugasan guru pengganti ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="gp-table-footer">
            <div class="gp-pagination-info">
                Menampilkan {{ count($penugasans) > 0 ? 1 : 0 }} - {{ count($penugasans) }} dari {{ count($penugasans) }} data
            </div>

            <div class="gp-pagination">
                <a href="#" class="gp-page-btn">&laquo;</a>
                <a href="#" class="gp-page-btn">&lsaquo;</a>
                <a href="#" class="gp-page-btn active">1</a>
                <a href="#" class="gp-page-btn">&rsaquo;</a>
                <a href="#" class="gp-page-btn">&raquo;</a>
            </div>
        </div>

    </div>

</div>

<!-- Modal 1: Detail Lengkap Penugasan Guru Pengganti -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h4 class="modal-title-custom"><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Lengkap Penugasan Guru Pengganti</h4>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
            <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">GURU TIDAK HADIR</strong> <div id="detailGuruUtama" style="color: #991b1b; font-weight: 800; font-size: 13.5px;"></div></div>
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">GURU PENGGANTI</strong> <div id="detailGuruPengganti" style="color: #2563eb; font-weight: 800; font-size: 13.5px;"></div></div>
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">TANGGAL & HARI</strong> <div id="detailTanggal" style="font-weight: 600;"></div></div>
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">STATUS PENUGASAN</strong> <div id="detailStatus"></div></div>
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">KELAS</strong> <div id="detailKelas" style="font-weight: 700;"></div></div>
                <div><strong style="color: #64748b; font-size: 11.5px; display: block;">MATA PELAJARAN</strong> <div id="detailMapel" style="font-weight: 700;"></div></div>
                <div style="grid-column: span 2;"><strong style="color: #64748b; font-size: 11.5px; display: block;">JAM PELAJARAN</strong> <div id="detailJam" style="font-weight: 700; color: #1e40af;"></div></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-regular fa-bookmark" style="color: #2563eb;"></i> Materi Pembelajaran Dititipkan:</label>
                <div id="detailMateri" style="background: #fff; border: 1px solid #cbd5e1; padding: 10px 12px; border-radius: 8px; color: #1e293b; white-space: pre-line;"></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-regular fa-clipboard" style="color: #2563eb;"></i> Tugas / Instruksi Kelas Dititipkan:</label>
                <div id="detailTugas" style="background: #fff; border: 1px solid #cbd5e1; padding: 10px 12px; border-radius: 8px; color: #1e293b; white-space: pre-line;"></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-solid fa-paperclip" style="color: #2563eb;"></i> File Tugas Dititipkan:</label>
                <div id="detailFileTugasBox" style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px;"></div>
            </div>

            <div>
                <label style="font-weight: 700; color: #334155; display: block; margin-bottom: 4px;"><i class="fa-regular fa-comment-dots" style="color: #2563eb;"></i> Catatan Tambahan Piket:</label>
                <div id="detailCatatan" style="background: #fff; border: 1px solid #cbd5e1; padding: 8px 12px; border-radius: 8px; color: #475569;"></div>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <button type="button" onclick="closeDetailModal()" class="gp-btn-submit" style="padding: 8px 20px;">Tutup Detail</button>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Penugasan Guru Pengganti -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content-custom" style="max-width: 680px;">
        <div class="modal-header-custom">
            <h4 class="modal-title-custom"><i class="fa-solid fa-pen-to-square" style="color: #d97706;"></i> Edit Penugasan Guru Pengganti</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form id="formEditPenugasan" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_jadwal" id="edit_input_id_jadwal">

            <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
                
                <!-- Row 1 Edit -->
                <div class="gp-grid-2col">
                    <div class="gp-field-group">
                        <label class="gp-label">Guru Tidak Hadir (Izin / Sakit) <span class="req">*</span></label>
                        <div class="gp-input-search-inner">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="edit_search_guru_tidak_hadir" placeholder="Cari Guru Tidak Hadir..." onkeyup="filterSelectOptions('edit_select_guru_tidak_hadir', this.value)">
                        </div>
                        <select name="id_guru_tidak_hadir" id="edit_select_guru_tidak_hadir" class="gp-select" required onchange="onEditGuruTidakHadirChanged(this)">
                            <option value="">-- Pilih Guru Tidak Hadir --</option>
                            <optgroup label="⚠️ Guru Terdata Izin / Sakit Saat Ini">
                                @foreach($guruTidakHadirOptions as $iz)
                                    @if($iz->guru)
                                        <option value="{{ $iz->id_guru }}" data-materi="{{ $iz->materi_dititipkan ?? '' }}" data-tugas="{{ $iz->tugas_dititipkan ?? '' }}">
                                            ⚠️ {{ $iz->guru->nama_guru }} (NIP: {{ $iz->guru->nip ?? '-' }}) (Izin: {{ $iz->alasan }} | {{ $iz->durasi_formatted }})
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                        <button type="button" id="edit_btnToggleGuruTidakHadirLainnya" class="gp-btn-toggle-options-blue" onclick="toggleEditGuruTidakHadirLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>
                    </div>

                    <div class="gp-field-group">
                        <label class="gp-label">Guru Pengganti (Prioritas Guru Piket) <span class="req">*</span></label>
                        <div class="gp-input-search-inner">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="edit_search_guru_pengganti" placeholder="Cari Guru Pengganti..." onkeyup="filterSelectOptions('edit_select_guru_pengganti', this.value)">
                        </div>
                        <select name="id_guru_pengganti" id="edit_select_guru_pengganti" class="gp-select" required>
                            <option value="">-- Pilih Guru Pengganti --</option>
                            <optgroup label="📌 Guru Piket Hari Ini (Tampil Utama)">
                                @foreach($guruList as $g)
                                    @if(!empty($g->is_piket_today))
                                        <option value="{{ $g->id_guru }}">[Guru Piket] {{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }})</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                        <button type="button" id="edit_btnToggleGuruLainnya" class="gp-btn-toggle-options-green" onclick="toggleEditGuruMengajarLainnya()">
                            <i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya
                        </button>
                    </div>
                </div>

                <!-- Sesi jadwal mengajar edit chips -->
                <div id="edit_wrapper_jadwal_pilihan" style="display: none; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; font-size: 12px; color: #166534;">
                    <strong><i class="fa-solid fa-list-check" style="color: #15803d;"></i> Sesi Jadwal Mengajar Guru Ini (Klik untuk Otomatis Mengisi):</strong>
                    <div id="edit_jadwal_pilihan_list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;"></div>
                </div>

                <!-- Row 2 Edit -->
                <div class="gp-grid-2col">
                    <div class="gp-field-group">
                        <label class="gp-label">Tanggal Penugasan <span class="req">*</span></label>
                        <input type="date" name="tanggal" id="edit_input_tanggal" class="gp-input-text" required onchange="onEditTanggalPenugasanChanged()">
                        <div id="edit_label_hari_penugasan" class="gp-date-badge">
                            <i class="fa-regular fa-calendar-check"></i> Hari: <span id="edit_text_nama_hari">-</span>
                        </div>
                    </div>

                    <div class="gp-field-group">
                        <label class="gp-label">Status Penugasan <span class="req">*</span></label>
                        <select name="status" id="edit_select_status" class="gp-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <!-- Row 3 Edit -->
                <div class="gp-grid-2col">
                    <div class="gp-field-group">
                        <label class="gp-label">Jam Pelajaran (Master TU) <span class="req">*</span></label>
                        <select name="jam_pelajaran" id="edit_select_jam_pelajaran" class="gp-select" required>
                            <option value="">-- Pilih Jam Pelajaran (Master TU) --</option>
                        </select>
                        <div class="gp-input-search-inner" style="margin-top: 4px; margin-bottom: 0;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="edit_search_jam_pelajaran" placeholder="Cari Sesi Jam Pelajaran..." onkeyup="filterSelectOptions('edit_select_jam_pelajaran', this.value)">
                        </div>
                    </div>

                    <div class="gp-field-group">
                        <label class="gp-label">Kelas <span class="req">*</span></label>
                        <select name="id_kelas" id="edit_select_kelas" class="gp-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="gp-field-group">
                    <label class="gp-label"><i class="fa-regular fa-bookmark"></i> Titipan Materi Pembelajaran (Opsional)</label>
                    <textarea name="materi_dititipkan" id="edit_textarea_materi" rows="2" class="gp-textarea" style="resize: vertical;"></textarea>
                </div>

                <div class="gp-field-group">
                    <label class="gp-label"><i class="fa-regular fa-clipboard"></i> Titipan Tugas / Instruksi Kelas (Opsional)</label>
                    <textarea name="tugas_dititipkan" id="edit_textarea_tugas" rows="2" class="gp-textarea" style="resize: vertical;"></textarea>
                </div>

                <div class="gp-field-group">
                    <label class="gp-label"><i class="fa-solid fa-paperclip"></i> Upload File Tugas Baru (Opsional - Menggantikan File Lama)</label>
                    <input type="file" name="file_tugas" class="gp-input-text">
                    <div id="edit_current_file_info" style="font-size: 11.5px; color: #2563eb; margin-top: 4px;"></div>
                </div>

                <div class="gp-field-group">
                    <label class="gp-label"><i class="fa-regular fa-comment-dots"></i> Catatan Tambahan Piket</label>
                    <input type="text" name="catatan" id="edit_input_catatan" class="gp-input-text">
                </div>

            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditModal()" class="gp-btn-reset">Batal</button>
                <button type="submit" class="gp-btn-submit" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Edit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Fitur Sampah (Trash Soft Delete) -->
<div id="trashModal" class="modal-overlay">
    <div class="modal-content-custom" style="max-width: 820px;">
        <div class="modal-header-custom">
            <h4 class="modal-title-custom" style="color: #991b1b;"><i class="fa-regular fa-trash-can"></i> Sampah Penugasan Guru Pengganti</h4>
            <button type="button" onclick="closeTrashModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        @if($trashCount > 0)
            <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                <form action="{{ route('piket.guru-pengganti.empty-trash') }}" method="POST" onsubmit="return confirm('Kosongkan SELURUH sampah secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #ef4444; color: #fff; border: none; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer;">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            </div>
        @endif

        <div style="overflow-x: auto; max-height: 400px; border: 1px solid #f1f5f9; border-radius: 12px;">
            <table class="gp-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Guru Tidak Hadir</th>
                        <th>Guru Pengganti</th>
                        <th>Kelas & Jam</th>
                        <th>Dihapus Pada</th>
                        <th style="text-align: center;">Aksi Sampah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashPenugasans as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $t->guruTidakHadir->nama_guru ?? '-' }}</td>
                            <td>{{ $t->guruPengganti->nama_guru ?? '-' }}</td>
                            <td>{{ $t->kelas->nama_kelas ?? '-' }} ({{ $t->jam_pelajaran }})</td>
                            <td><span style="font-size: 11.5px; color: #94a3b8;">{{ $t->deleted_at->format('d M Y H:i') }}</span></td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <form action="{{ route('piket.guru-pengganti.restore', $t->id_penugasan) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('piket.guru-pengganti.force-delete', $t->id_penugasan) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada data penugasan di dalam Sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeTrashModal()" class="gp-btn-submit" style="padding: 8px 20px;">Tutup Sampah</button>
        </div>
    </div>
</div>

<!-- Modal 4: Stat Card 1 - Detail Guru Tidak Hadir -->
<div id="modalStatGuruTidakHadir" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h4 class="modal-title-custom"><i class="fa-solid fa-location-dot" style="color: #2563eb;"></i> Daftar Guru Tidak Hadir (Izin / Sakit)</h4>
            <button type="button" onclick="closeModalStatGuruTidakHadir()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 380px; overflow-y: auto;">
            @forelse($guruTidakHadirOptions as $iz)
                @if($iz->guru)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                        <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">{{ $iz->guru->nama_guru }}</div>
                        <div style="font-size: 12px; color: #2563eb; font-weight: 700; margin-top: 2px;">
                            Alasan: {{ $iz->alasan }} | Durasi: {{ $iz->durasi_formatted }}
                        </div>
                        @if($iz->materi_dititipkan)
                            <div style="font-size: 12px; color: #475569; margin-top: 4px; background: #fff; padding: 6px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <strong>Titipan Materi:</strong> {{ $iz->materi_dititipkan }}
                            </div>
                        @endif
                    </div>
                @endif
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px;">Seluruh guru mengajar hadir penuh hari ini.</div>
            @endforelse
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeModalStatGuruTidakHadir()" class="gp-btn-submit" style="padding: 8px 20px;">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal 5: Stat Card 2 - Detail Guru Pengganti Assigned -->
<div id="modalStatGuruPengganti" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h4 class="modal-title-custom"><i class="fa-solid fa-user-group" style="color: #d97706;"></i> Ringkasan Guru Pengganti Bertugas</h4>
            <button type="button" onclick="closeModalStatGuruPengganti()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 380px; overflow-y: auto;">
            @forelse($penugasans as $row)
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong style="color: #92400e; font-size: 13.5px;">Guru Pengganti: {{ $row->guru_pengganti_nama ?? ($row->guruPengganti->nama_guru ?? 'Pengganti') }}</strong>
                        <span class="gp-status-badge gp-status-aktif">
                            <span class="gp-status-dot"></span>
                            {{ ucfirst($row->status ?? 'aktif') }}
                        </span>
                    </div>
                    <div style="font-size: 12px; color: #78350f; margin-top: 4px;">
                        Menggantikan: {{ $row->guru_tidak_hadir_nama ?? ($row->guruTidakHadir->nama_guru ?? '-') }} | Kelas: {{ $row->kelas_nama ?? ($row->kelas->nama_kelas ?? '-') }} | Jam: {{ $row->jam ?? ($row->jam_pelajaran ?? '-') }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada penugasan guru pengganti aktif hari ini.</div>
            @endforelse
        </div>

        <div style="margin-top: 18px; text-align: right;">
            <button type="button" onclick="closeModalStatGuruPengganti()" class="gp-btn-submit" style="padding: 8px 20px;">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal 6: Konfirmasi Hapus Massal Penugasan Guru Pengganti -->
<div id="bulkDeleteModal" class="modal-overlay">
    <div class="modal-content-custom" style="max-width: 440px; padding: 0; overflow: hidden;">
        <div style="padding: 16px 22px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #ffffff;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" onclick="closeBulkDeleteModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="text-align: center; padding: 24px;">
            <div style="width: 54px; height: 54px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; color: #ef4444; font-size: 24px;">
                <i class="fa-regular fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13px; color: #64748b; font-weight: 500; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> penugasan guru pengganti yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="gp-btn-reset" style="padding: 9px 18px;">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" style="padding: 9px 20px; font-size: 12.5px; font-weight: 800; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; cursor: pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Hapus Massal Penugasan Guru Pengganti -->
<form id="bulkDeleteForm" action="{{ route('piket.guru-pengganti.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<script>
    // Data Master Jam Pelajaran dari Laravel
    const jamPelajaranMaster = @json($jamPelajaranList ?? []);
    const todayDateStr = "{{ $todayDate }}";

    // Data Master Seluruh Guru Mengajar dari Role TU
    const allGuruListMaster = [
        @foreach($guruList as $g)
            { id_guru: "{{ $g->id_guru }}", nama_guru: "{{ addslashes($g->nama_guru) }}", nip: "{{ addslashes($g->nip ?? '-') }}", mapel: "{{ addslashes($g->mapel->nama_mapel ?? 'Guru') }}" },
        @endforeach
    ];

    // Data Guru Mengajar Lainnya untuk Toggle Guru Pengganti
    const guruMengajarLainnyaList = [
        @foreach($guruList as $g)
            @if(empty($g->is_piket_today))
                { id_guru: "{{ $g->id_guru }}", nama_guru: "{{ addslashes($g->nama_guru) }}", nip: "{{ addslashes($g->nip ?? '-') }}", mapel: "{{ addslashes($g->mapel->nama_mapel ?? 'Guru') }}" },
            @endif
        @endforeach
    ];

    function updateFileNameDisplay(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = input.files[0].name;
            display.style.color = '#2563eb';
            display.style.fontWeight = '700';
        } else {
            display.textContent = 'Tidak ada file yang dipilih';
            display.style.color = '#64748b';
            display.style.fontWeight = '500';
        }
    }

    // Handler Utama Perubahan Tanggal Penugasan
    function onTanggalPenugasanChanged() {
        updateNamaHariLabel();
        updateJamOptionsByDate();
        validateTanggalPenugasan();
        fetchJadwalGuruTidakHadirList();

        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh && chkSehariPenuh.checked) {
            fetchJadwalSehariPenuhPreview();
        }
    }

    function resetFormDirectPenugasan() {
        const form = document.getElementById('formDirectPenugasan');
        if (form) form.reset();

        const inputJadwal = document.getElementById('input_id_jadwal');
        if (inputJadwal) inputJadwal.value = '';

        const inputTanggal = document.getElementById('input_tanggal_penugasan');
        if (inputTanggal) inputTanggal.value = todayDateStr;

        const selTidakHadir = document.getElementById('select_guru_tidak_hadir');
        if (selTidakHadir) selTidakHadir.value = '';

        const selPengganti = document.getElementById('select_guru_pengganti');
        if (selPengganti) selPengganti.value = '';

        const selKelas = document.getElementById('select_kelas');
        if (selKelas) selKelas.value = '';

        const selJam = document.getElementById('select_jam_pelajaran');
        if (selJam) selJam.value = '';

        const materiField = document.getElementById('materi_dititipkan_field');
        if (materiField) materiField.value = '';

        const tugasField = document.getElementById('tugas_dititipkan_field');
        if (tugasField) tugasField.value = '';

        const catatanField = document.getElementById('input_catatan');
        if (catatanField) catatanField.value = '';

        const fileInput = document.getElementById('input_file_tugas');
        if (fileInput) {
            fileInput.value = '';
            updateFileNameDisplay(fileInput);
        }

        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh) {
            chkSehariPenuh.checked = false;
            toggleSehariPenuh(chkSehariPenuh);
        }

        const wrapperJadwal = document.getElementById('wrapper_jadwal_pilihan');
        if (wrapperJadwal) wrapperJadwal.style.display = 'none';

        const listContainer = document.getElementById('jadwal_pilihan_list');
        if (listContainer) listContainer.innerHTML = '';

        document.querySelectorAll('.input-error-border').forEach(el => el.classList.remove('input-error-border'));

        onTanggalPenugasanChanged();
    }

    // Tampilkan Nama Hari Bahasa Indonesia
    function updateNamaHariLabel() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const labelHari = document.getElementById('text_nama_hari');
        if (!dateInput || !labelHari) return;

        const val = dateInput.value;
        if (!val) {
            labelHari.innerText = '-';
            return;
        }

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const monthsIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = daysIndo[dateObj.getDay()];
        const dayNum = dateObj.getDate();
        const monthName = monthsIndo[dateObj.getMonth()];
        const yearNum = dateObj.getFullYear();

        labelHari.innerHTML = `<strong>${dayName}</strong>, ${dayNum} ${monthName} ${yearNum}`;
    }

    // Validasi Tanggal
    function validateTanggalPenugasan() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const warningPast = document.getElementById('label_warning_past_date');
        if (!dateInput) return;

        const selectedDate = dateInput.value;
        if (!selectedDate) return;

        if (selectedDate < todayDateStr) {
            if (warningPast) warningPast.style.display = 'block';
            dateInput.classList.add('input-error-border');
        } else {
            if (warningPast) warningPast.style.display = 'none';
            dateInput.classList.remove('input-error-border');
        }
    }

    // Dynamic Generator Multi-Jam
    function generateMultiJamOptions(isJumat) {
        const multiPairs = [
            [1,2], [2,3], [3,4], [4,5], [5,6], [6,7], [7,8], [8,9], [9,10], [10,11], [11,12], [12,13],
            [1,3], [2,4], [3,5], [4,6], [5,7], [6,8], [7,9], [8,10], [9,11], [10,12], [11,13],
            [1,4], [2,5], [3,6], [4,7], [5,8], [6,9], [7,10], [8,11], [9,12], [10,13],
            [1,5], [2,6], [3,7], [4,8], [5,9], [6,10], [7,11], [8,12], [9,13],
            [1,6], [1,7], [2,7], [2,8], [3,8], [3,9], [4,9], [4,10], [5,10], [5,11], [5,13], [6,11], [6,12], [6,13], [7,12], [7,13], [8,13]
        ];

        let results = [];

        multiPairs.forEach(p => {
            const start = p[0];
            const end = p[1];

            const mung = jamPelajaranMaster.find(j => j.id_jam == start || j.jam_ke == `Jam Ke-${start}`);
            const sel  = jamPelajaranMaster.find(j => j.id_jam == end || j.jam_ke == `Jam Ke-${end}`);

            let startTime = '';
            let endTime = '';

            if (isJumat) {
                if (mung && mung.jam_mulai_jumat) startTime = mung.jam_mulai_jumat.substring(0, 5);
                if (sel && sel.jam_selesai_jumat) endTime = sel.jam_selesai_jumat.substring(0, 5);

                if (!endTime) {
                    for (let k = end - 1; k >= start; k--) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_selesai_jumat) {
                            endTime = sub.jam_selesai_jumat.substring(0, 5);
                            break;
                        }
                    }
                }
            } else {
                if (mung && mung.jam_mulai) startTime = mung.jam_mulai.substring(0, 5);
                if (sel && sel.jam_selesai) endTime = sel.jam_selesai.substring(0, 5);

                if (!endTime) {
                    for (let k = end - 1; k >= start; k--) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_selesai) {
                            endTime = sub.jam_selesai.substring(0, 5);
                            break;
                        }
                    }
                    if (!endTime) endTime = '15:00';
                }
                if (!startTime) {
                    for (let k = start + 1; k <= end; k++) {
                        let sub = jamPelajaranMaster.find(j => j.id_jam == k || j.jam_ke == `Jam Ke-${k}`);
                        if (sub && sub.jam_mulai) {
                            startTime = sub.jam_mulai.substring(0, 5);
                            break;
                        }
                    }
                    if (!startTime) startTime = '07:00';
                }
            }

            if (startTime && endTime) {
                results.push(`Jam Ke-${start} - ${end} (${startTime} - ${endTime} WIB)`);
            } else if (startTime) {
                results.push(`Jam Ke-${start} - ${end} (${startTime} WIB)`);
            } else {
                results.push(`Jam Ke-${start} - ${end}`);
            }
        });

        return results;
    }

    // Update Opsi Jam Pelajaran Berdasarkan Tanggal (Hari Biasa / Jumat)
    function updateJamOptionsByDate() {
        const dateInput = document.getElementById('input_tanggal_penugasan');
        const jamSelect = document.getElementById('select_jam_pelajaran');
        if (!dateInput || !jamSelect) return;

        const val = dateInput.value;
        if (!val) return;

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const day = dateObj.getDay();
        const isJumat = (day === 5);

        const oldSelected = jamSelect.getAttribute('data-old-val') || jamSelect.value;
        jamSelect.innerHTML = '<option value="">-- Pilih Jam Pelajaran (Master TU) --</option>';

        const grpSingle = document.createElement('optgroup');
        grpSingle.label = isJumat ? 'Satu Sesi Jam Pelajaran (Master TU - Khusus Hari Jumat)' : 'Satu Sesi Jam Pelajaran (Master TU - Senin s/d Kamis)';

        jamPelajaranMaster.forEach(item => {
            let timeStr = '';
            if (isJumat) {
                if (item.jam_mulai_jumat && item.jam_selesai_jumat) {
                    timeStr = `${item.jam_mulai_jumat.substring(0,5)} - ${item.jam_selesai_jumat.substring(0,5)} WIB`;
                }
            } else {
                if (item.jam_mulai && item.jam_selesai) {
                    timeStr = `${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} WIB`;
                }
            }

            if (timeStr) {
                const optVal = `${item.jam_ke} (${timeStr})`;
                const opt = document.createElement('option');
                opt.value = optVal;
                opt.textContent = `${item.jam_ke} (${timeStr}) — ${item.keterangan || 'Sesi Pembelajaran'}`;
                if (oldSelected === optVal) opt.selected = true;
                grpSingle.appendChild(opt);
            }
        });

        jamSelect.appendChild(grpSingle);

        const grpMulti = document.createElement('optgroup');
        grpMulti.label = isJumat ? 'Rentang Multi-Jam Pembelajaran Lengkap (Khusus Hari Jumat)' : 'Rentang Multi-Jam Pembelajaran Lengkap (Senin s/d Kamis)';

        let multiOptions = generateMultiJamOptions(isJumat);

        multiOptions.forEach(optVal => {
            const opt = document.createElement('option');
            opt.value = optVal;
            opt.textContent = optVal;
            if (oldSelected === optVal) opt.selected = true;
            grpMulti.appendChild(opt);
        });

        jamSelect.appendChild(grpMulti);
    }

    // Toggle Sehari Penuh Feature with clear active visual state
    function toggleSehariPenuh(chk) {
        const selectJam   = document.getElementById('select_jam_pelajaran');
        const selectKelas = document.getElementById('select_kelas');
        const previewBox  = document.getElementById('preview_sehari_penuh_box');
        const toggleContainer = document.querySelector('.gp-toggle-container');

        if (chk.checked) {
            if (toggleContainer) toggleContainer.classList.add('is-active');
            if (selectJam) {
                selectJam.disabled = true;
                selectJam.removeAttribute('required');
                selectJam.style.background = '#f1f5f9';
            }
            if (selectKelas) {
                selectKelas.disabled = true;
                selectKelas.removeAttribute('required');
                selectKelas.style.background = '#f1f5f9';
            }
            if (previewBox) {
                previewBox.style.display = 'block';
                fetchJadwalSehariPenuhPreview();
            }
        } else {
            if (toggleContainer) toggleContainer.classList.remove('is-active');
            if (selectJam) {
                selectJam.disabled = false;
                selectJam.setAttribute('required', 'required');
                selectJam.style.background = '#ffffff';
            }
            if (selectKelas) {
                selectKelas.disabled = false;
                selectKelas.setAttribute('required', 'required');
                selectKelas.style.background = '#ffffff';
            }
            if (previewBox) {
                previewBox.style.display = 'none';
                previewBox.innerHTML = '';
            }
        }
    }

    // Handler Perubahan Guru Tidak Hadir
    function onGuruTidakHadirChanged(selectElem) {
        autoFillMateriFromIzin(selectElem);
        fetchJadwalGuruTidakHadirList();

        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh && chkSehariPenuh.checked) {
            fetchJadwalSehariPenuhPreview();
        }
    }

    // Fetch List Jadwal Guru Tidak Hadir untuk Chip Pilihan Cepat
    function fetchJadwalGuruTidakHadirList() {
        const selectGuruHadir = document.getElementById('select_guru_tidak_hadir');
        const inputTanggal   = document.getElementById('input_tanggal_penugasan');
        const wrapperJadwal  = document.getElementById('wrapper_jadwal_pilihan');
        const listContainer  = document.getElementById('jadwal_pilihan_list');

        if (!selectGuruHadir || !inputTanggal || !wrapperJadwal || !listContainer) return;

        const idGuru  = selectGuruHadir.value;
        const tanggal = inputTanggal.value;

        if (!idGuru) {
            wrapperJadwal.style.display = 'none';
            listContainer.innerHTML = '';
            return;
        }

        fetch(`{{ route('piket.guru-pengganti.jadwal-guru') }}?id_guru=${idGuru}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.jadwals && data.jadwals.length > 0) {
                    let html = '';
                    data.jadwals.forEach(j => {
                        html += `<button type="button" class="btn-schedule-chip" onclick='applyScheduleChoice(${j.id_jadwal}, ${j.id_kelas}, "${j.jam_pelajaran}")' style="background: #ffffff; border: 1px solid #93c5fd; color: #1e40af; padding: 5px 10px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 11.5px; transition: all 0.2s ease;">
                            <i class="fa-solid fa-clock" style="color: #2563eb;"></i> ${j.nama_kelas} (${j.nama_mapel}) — ${j.jam_pelajaran}
                        </button>`;
                    });
                    listContainer.innerHTML = html;
                    wrapperJadwal.style.display = 'block';
                } else {
                    wrapperJadwal.style.display = 'block';
                    listContainer.innerHTML = `<span style="color: #dc2626; font-style: italic;"><i class="fa-solid fa-circle-info"></i> Guru ini tidak memiliki jadwal mengajar pada hari ${data.hari || ''} (${tanggal}).</span>`;
                }
            })
            .catch(err => {
                wrapperJadwal.style.display = 'none';
            });
    }

    // Terapkan Sesi Jadwal yang Dipilih
    function applyScheduleChoice(idJadwal, idKelas, jamPelajaran) {
        const inputJadwal = document.getElementById('input_id_jadwal');
        if (inputJadwal) inputJadwal.value = idJadwal;
        
        const selectKelas = document.getElementById('select_kelas');
        if (selectKelas) selectKelas.value = idKelas;

        const selectJam = document.getElementById('select_jam_pelajaran');
        if (selectJam) {
            let found = Array.from(selectJam.options).some(opt => opt.value === jamPelajaran);
            if (!found) {
                const opt = document.createElement('option');
                opt.value = jamPelajaran;
                opt.textContent = jamPelajaran;
                selectJam.appendChild(opt);
            }
            selectJam.value = jamPelajaran;
        }

        document.querySelectorAll('.btn-schedule-chip').forEach(btn => {
            btn.style.background = '#ffffff';
            btn.style.borderColor = '#93c5fd';
            btn.style.color = '#1e40af';
        });
        if (event && event.currentTarget) {
            event.currentTarget.style.background = '#eff6ff';
            event.currentTarget.style.borderColor = '#2563eb';
            event.currentTarget.style.color = '#1d4ed8';
        }
    }

    // Fetch Preview Jadwal Sehari Penuh via AJAX
    function fetchJadwalSehariPenuhPreview() {
        const selectGuruHadir = document.getElementById('select_guru_tidak_hadir');
        const inputTanggal   = document.getElementById('input_tanggal_penugasan');
        const previewBox     = document.getElementById('preview_sehari_penuh_box');

        if (!selectGuruHadir || !inputTanggal || !previewBox) return;

        const idGuru  = selectGuruHadir.value;
        const tanggal = inputTanggal.value;

        if (!idGuru) {
            previewBox.innerHTML = '<span style="color: #dc2626;"><i class="fa-solid fa-circle-exclamation"></i> Silakan pilih Guru Tidak Hadir terlebih dahulu!</span>';
            return;
        }

        previewBox.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat jadwal mengajar guru pada tanggal tersebut...';

        fetch(`{{ route('piket.guru-pengganti.jadwal-guru') }}?id_guru=${idGuru}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.jadwals && data.jadwals.length > 0) {
                    let html = `<strong><i class="fa-solid fa-check-circle" style="color: #16a34a;"></i> Ditemukan ${data.total_sesi} Sesi Mengajar pada Hari ${data.hari}:</strong><ul style="margin: 6px 0 0 20px; padding: 0;">`;
                    data.jadwals.forEach(j => {
                        html += `<li><strong>${j.nama_kelas}</strong> | ${j.nama_mapel} — <span style="color: #2563eb; font-weight:700;">${j.jam_pelajaran}</span></li>`;
                    });
                    html += `</ul><div style="font-size: 11px; color: #475569; margin-top: 6px; font-style: italic;">*Semua sesi jadwal di atas akan otomatis dibuatkan penugasan guru pengganti sekaligus saat form disimpan. Jam & Kelas dikunci selama mode ini aktif.</div>`;
                    previewBox.innerHTML = html;
                } else {
                    previewBox.innerHTML = `<span style="color: #dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Guru ini tidak memiliki jadwal mengajar pada hari ${data.hari || ''} (${tanggal}). Penugasan sehari penuh tidak dapat diterapkan.</span>`;
                }
            })
            .catch(err => {
                previewBox.innerHTML = '<span style="color: #dc2626;"><i class="fa-solid fa-circle-exclamation"></i> Gagal memuat jadwal mengajar.</span>';
            });
    }

    // Live Filter Dropdown Options
    function filterSelectOptions(selectId, keyword) {
        const selectElem = document.getElementById(selectId);
        if (!selectElem) return;

        const term = (keyword || '').toLowerCase().trim();

        if (term.length >= 1) {
            if (selectId === 'select_guru_tidak_hadir') toggleGuruTidakHadirLainnya(true);
            if (selectId === 'select_guru_pengganti') toggleGuruMengajarLainnya();
            if (selectId === 'edit_select_guru_tidak_hadir') toggleEditGuruTidakHadirLainnya(true);
            if (selectId === 'edit_select_guru_pengganti') toggleEditGuruMengajarLainnya(true);
        }

        const options = selectElem.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) {
                opt.style.display = '';
                return;
            }

            const text = opt.textContent.toLowerCase();
            if (term === '' || text.includes(term)) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });

        const optgroups = selectElem.querySelectorAll('optgroup');
        optgroups.forEach(grp => {
            const visibleOpts = Array.from(grp.querySelectorAll('option')).filter(o => o.style.display !== 'none');
            if (term === '' || visibleOpts.length > 0) {
                grp.style.display = '';
            } else {
                grp.style.display = 'none';
            }
        });
    }

    // Toggle Guru Tidak Hadir Lainnya (Add Form)
    let isGuruTidakHadirLainnyaVisible = false;
    function toggleGuruTidakHadirLainnya(forceShow = false) {
        const selectElem = document.getElementById('select_guru_tidak_hadir');
        const btn = document.getElementById('btnToggleGuruTidakHadirLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isGuruTidakHadirLainnyaVisible) {
            if (document.getElementById('optgroup_guru_tidak_hadir_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'optgroup_guru_tidak_hadir_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya (Seluruh Data Guru TU)';

            allGuruListMaster.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                const oldVal = selectElem.getAttribute('data-old-val');
                if (oldVal && oldVal == g.id_guru) opt.selected = true;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isGuruTidakHadirLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('optgroup_guru_tidak_hadir_lainnya_dynamic');
            if (grp) grp.remove();
            isGuruTidakHadirLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#eff6ff';
            btn.style.borderColor = '#93c5fd';
        }
    }

    // Toggle Guru Mengajar Lainnya (Guru Pengganti - Add Form)
    let isGuruLainnyaVisible = false;
    function toggleGuruMengajarLainnya() {
        const selectElem = document.getElementById('select_guru_pengganti');
        const btn = document.getElementById('btnToggleGuruLainnya');
        if (!selectElem || !btn) return;

        if (!isGuruLainnyaVisible) {
            const grp = document.createElement('optgroup');
            grp.id = 'optgroup_guru_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya';

            guruMengajarLainnyaList.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                const oldVal = selectElem.getAttribute('data-old-val');
                if (oldVal && oldVal == g.id_guru) opt.selected = true;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isGuruLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('optgroup_guru_lainnya_dynamic');
            if (grp) grp.remove();
            isGuruLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#059669';
            btn.style.background = '#ecfdf5';
            btn.style.borderColor = '#a7f3d0';
        }
    }

    // Modal Detail Lengkap Penugasan
    function showDetailModalComplete(data) {
        document.getElementById('detailGuruUtama').innerText = data.guru_tidak_hadir_nama || '-';
        document.getElementById('detailGuruPengganti').innerText = data.guru_pengganti_nama || '-';
        
        let tglFormatted = data.tanggal;
        if (data.tanggal) {
            const p = data.tanggal.split('-');
            if (p.length === 3) tglFormatted = `${p[2]}/${p[1]}/${p[0]}`;
        }
        document.getElementById('detailTanggal').innerText = tglFormatted;

        const st = (data.status || 'aktif').toLowerCase();
        let stBadge = '<span class="gp-status-badge gp-status-aktif"><span class="gp-status-dot"></span>Aktif</span>';
        if (st === 'selesai') stBadge = '<span class="gp-status-badge gp-status-selesai"><span class="gp-status-dot"></span>Selesai</span>';
        if (st === 'dibatalkan') stBadge = '<span class="gp-status-badge gp-status-dibatalkan"><span class="gp-status-dot"></span>Dibatalkan</span>';
        document.getElementById('detailStatus').innerHTML = stBadge;

        document.getElementById('detailKelas').innerText = data.kelas_nama || '-';
        document.getElementById('detailMapel').innerText = data.mapel_nama || '-';
        document.getElementById('detailJam').innerText   = data.jam_pelajaran || '-';
        
        document.getElementById('detailMateri').innerText = data.materi_dititipkan || 'Materi Reguler/Sesuai Kurikulum';
        document.getElementById('detailTugas').innerText  = data.tugas_dititipkan || 'Latihan Soal & Presensi Siswa';
        document.getElementById('detailCatatan').innerText = data.catatan || 'Keterangan penugasan normal';

        const fileBox = document.getElementById('detailFileTugasBox');
        if (data.file_tugas) {
            const fileUrl = `{{ asset('uploads/tugas_pengganti') }}/${data.file_tugas}`;
            fileBox.innerHTML = `<a href="${fileUrl}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #2563eb; font-weight: 800; text-decoration: none; background: #eff6ff; padding: 8px 14px; border-radius: 8px; border: 1px solid #bfdbfe;">
                <i class="fa-solid fa-file-arrow-down" style="font-size: 16px;"></i> Unduh / Lihat File Tugas (${data.file_tugas})
            </a>`;
        } else {
            fileBox.innerHTML = '<span style="color: #94a3b8; font-style: italic;">Tidak ada file tugas diunggah (Opsional).</span>';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Modal Edit Penugasan
    function openEditModal(data) {
        if (!data || !data.id_penugasan) return;

        const form = document.getElementById('formEditPenugasan');
        form.action = `{{ url('/guru-piket/guru-pengganti') }}/${data.id_penugasan}`;

        const inputJadwal = document.getElementById('edit_input_id_jadwal');
        if (inputJadwal) inputJadwal.value = data.id_jadwal || '';

        const inputTanggal = document.getElementById('edit_input_tanggal');
        if (inputTanggal) inputTanggal.value = data.tanggal || '';

        const selStatus = document.getElementById('edit_select_status');
        if (selStatus) selStatus.value = (data.status || 'aktif').toLowerCase();
        
        const selTidakHadir = document.getElementById('edit_select_guru_tidak_hadir');
        if (selTidakHadir && data.id_guru_tidak_hadir) {
            let existsInIzin = Array.from(selTidakHadir.options).some(o => o.value == data.id_guru_tidak_hadir);
            if (!existsInIzin) {
                toggleEditGuruTidakHadirLainnya(true);
            }
            selTidakHadir.value = data.id_guru_tidak_hadir;
        }

        const selPengganti = document.getElementById('edit_select_guru_pengganti');
        if (selPengganti && data.id_guru_pengganti) {
            let existsInPiket = Array.from(selPengganti.options).some(o => o.value == data.id_guru_pengganti);
            if (!existsInPiket) {
                toggleEditGuruMengajarLainnya(true);
            }
            selPengganti.value = data.id_guru_pengganti;
        }

        const selKelas = document.getElementById('edit_select_kelas');
        if (selKelas && data.id_kelas) selKelas.value = data.id_kelas;
        
        const textMateri = document.getElementById('edit_textarea_materi');
        if (textMateri) textMateri.value = data.materi_dititipkan || '';

        const textTugas = document.getElementById('edit_textarea_tugas');
        if (textTugas) textTugas.value = data.tugas_dititipkan || '';

        const inputCatatan = document.getElementById('edit_input_catatan');
        if (inputCatatan) inputCatatan.value = data.catatan || '';

        const fileInfo = document.getElementById('edit_current_file_info');
        if (data.file_tugas) {
            fileInfo.innerHTML = `<i class="fa-solid fa-paperclip"></i> File tugas saat ini: <strong>${data.file_tugas}</strong>`;
        } else {
            fileInfo.innerText = '';
        }

        onEditTanggalPenugasanChanged(data.jam_pelajaran);

        document.getElementById('editModal').style.display = 'flex';
    }

    let isEditGuruTidakHadirLainnyaVisible = false;
    function toggleEditGuruTidakHadirLainnya(forceShow = false) {
        const selectElem = document.getElementById('edit_select_guru_tidak_hadir');
        const btn = document.getElementById('edit_btnToggleGuruTidakHadirLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isEditGuruTidakHadirLainnyaVisible) {
            if (document.getElementById('edit_optgroup_guru_tidak_hadir_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'edit_optgroup_guru_tidak_hadir_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya (Seluruh Data Guru TU)';

            allGuruListMaster.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isEditGuruTidakHadirLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('edit_optgroup_guru_tidak_hadir_lainnya_dynamic');
            if (grp) grp.remove();
            isEditGuruTidakHadirLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#2563eb';
            btn.style.background = '#eff6ff';
            btn.style.borderColor = '#93c5fd';
        }
    }

    let isEditGuruLainnyaVisible = false;
    function toggleEditGuruMengajarLainnya(forceShow = false) {
        const selectElem = document.getElementById('edit_select_guru_pengganti');
        const btn = document.getElementById('edit_btnToggleGuruLainnya');
        if (!selectElem || !btn) return;

        if (forceShow || !isEditGuruLainnyaVisible) {
            if (document.getElementById('edit_optgroup_guru_lainnya_dynamic')) return;

            const grp = document.createElement('optgroup');
            grp.id = 'edit_optgroup_guru_lainnya_dynamic';
            grp.label = 'Guru Mengajar Lainnya';

            guruMengajarLainnyaList.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.id_guru;
                opt.textContent = `${g.nama_guru} (NIP: ${g.nip || '-'}) (${g.mapel})`;
                grp.appendChild(opt);
            });

            selectElem.appendChild(grp);
            isEditGuruLainnyaVisible = true;
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Sembunyikan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fca5a5';
        } else {
            const grp = document.getElementById('edit_optgroup_guru_lainnya_dynamic');
            if (grp) grp.remove();
            isEditGuruLainnyaVisible = false;
            btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Tampilkan Pilihan Guru Mengajar Lainnya';
            btn.style.color = '#059669';
            btn.style.background = '#ecfdf5';
            btn.style.borderColor = '#a7f3d0';
        }
    }

    function onEditTanggalPenugasanChanged(targetJamVal = null) {
        updateEditNamaHariLabel();
        updateEditJamOptionsByDate(targetJamVal);
        fetchEditJadwalGuruTidakHadirList();
    }

    function updateEditNamaHariLabel() {
        const dateInput = document.getElementById('edit_input_tanggal');
        const labelHari = document.getElementById('edit_text_nama_hari');
        if (!dateInput || !labelHari) return;

        const val = dateInput.value;
        if (!val) {
            labelHari.innerText = '-';
            return;
        }

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const monthsIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = daysIndo[dateObj.getDay()];
        const dayNum = dateObj.getDate();
        const monthName = monthsIndo[dateObj.getMonth()];
        const yearNum = dateObj.getFullYear();

        labelHari.innerHTML = `<strong>${dayName}</strong>, ${dayNum} ${monthName} ${yearNum}`;
    }

    function updateEditJamOptionsByDate(targetJamVal = null) {
        const dateInput = document.getElementById('edit_input_tanggal');
        const jamSelect = document.getElementById('edit_select_jam_pelajaran');
        if (!dateInput || !jamSelect) return;

        const val = dateInput.value;
        if (!val) return;

        const dateParts = val.split('-');
        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
        const day = dateObj.getDay();
        const isJumat = (day === 5);

        const currentSelected = targetJamVal || jamSelect.value;
        jamSelect.innerHTML = '<option value="">-- Pilih Jam Pelajaran (Master TU) --</option>';

        const grpSingle = document.createElement('optgroup');
        grpSingle.label = isJumat ? 'Satu Sesi Jam Pelajaran (Master TU - Khusus Hari Jumat)' : 'Satu Sesi Jam Pelajaran (Master TU - Senin s/d Kamis)';

        jamPelajaranMaster.forEach(item => {
            let timeStr = '';
            if (isJumat) {
                if (item.jam_mulai_jumat && item.jam_selesai_jumat) {
                    timeStr = `${item.jam_mulai_jumat.substring(0,5)} - ${item.jam_selesai_jumat.substring(0,5)} WIB`;
                }
            } else {
                if (item.jam_mulai && item.jam_selesai) {
                    timeStr = `${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} WIB`;
                }
            }

            if (timeStr) {
                const optVal = `${item.jam_ke} (${timeStr})`;
                const opt = document.createElement('option');
                opt.value = optVal;
                opt.textContent = `${item.jam_ke} (${timeStr}) — ${item.keterangan || 'Sesi Pembelajaran'}`;
                if (currentSelected === optVal) opt.selected = true;
                grpSingle.appendChild(opt);
            }
        });

        jamSelect.appendChild(grpSingle);

        const grpMulti = document.createElement('optgroup');
        grpMulti.label = isJumat ? 'Rentang Multi-Jam Pembelajaran Lengkap (Khusus Hari Jumat)' : 'Rentang Multi-Jam Pembelajaran Lengkap (Senin s/d Kamis)';

        let multiOptions = generateMultiJamOptions(isJumat);

        multiOptions.forEach(optVal => {
            const opt = document.createElement('option');
            opt.value = optVal;
            opt.textContent = optVal;
            if (currentSelected === optVal) opt.selected = true;
            grpMulti.appendChild(opt);
        });

        jamSelect.appendChild(grpMulti);

        if (currentSelected) {
            let exists = Array.from(jamSelect.options).some(o => o.value === currentSelected);
            if (!exists) {
                const opt = document.createElement('option');
                opt.value = currentSelected;
                opt.textContent = currentSelected;
                opt.selected = true;
                jamSelect.appendChild(opt);
            } else {
                jamSelect.value = currentSelected;
            }
        }
    }

    function onEditGuruTidakHadirChanged(selectElem) {
        fetchEditJadwalGuruTidakHadirList();
    }

    function fetchEditJadwalGuruTidakHadirList() {
        const selectGuruHadir = document.getElementById('edit_select_guru_tidak_hadir');
        const inputTanggal   = document.getElementById('edit_input_tanggal');
        const wrapperJadwal  = document.getElementById('edit_wrapper_jadwal_pilihan');
        const listContainer  = document.getElementById('edit_jadwal_pilihan_list');

        if (!selectGuruHadir || !inputTanggal || !wrapperJadwal || !listContainer) return;

        const idGuru  = selectGuruHadir.value;
        const tanggal = inputTanggal.value;

        if (!idGuru) {
            wrapperJadwal.style.display = 'none';
            listContainer.innerHTML = '';
            return;
        }

        fetch(`{{ route('piket.guru-pengganti.jadwal-guru') }}?id_guru=${idGuru}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.jadwals && data.jadwals.length > 0) {
                    let html = '';
                    data.jadwals.forEach(j => {
                        html += `<button type="button" class="btn-edit-schedule-chip" onclick='applyEditScheduleChoice(${j.id_jadwal}, ${j.id_kelas}, "${j.jam_pelajaran}")' style="background: #ffffff; border: 1px solid #86efac; color: #14532d; padding: 5px 10px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 11.5px; transition: all 0.2s ease;">
                            <i class="fa-solid fa-clock" style="color: #16a34a;"></i> ${j.nama_kelas} (${j.nama_mapel}) — ${j.jam_pelajaran}
                        </button>`;
                    });
                    listContainer.innerHTML = html;
                    wrapperJadwal.style.display = 'block';
                } else {
                    wrapperJadwal.style.display = 'block';
                    listContainer.innerHTML = `<span style="color: #dc2626; font-style: italic;"><i class="fa-solid fa-info-circle"></i> Guru ini tidak memiliki jadwal mengajar pada hari ${data.hari || ''} (${tanggal}).</span>`;
                }
            })
            .catch(err => {
                wrapperJadwal.style.display = 'none';
            });
    }

    function applyEditScheduleChoice(idJadwal, idKelas, jamPelajaran) {
        const inputJadwal = document.getElementById('edit_input_id_jadwal');
        if (inputJadwal) inputJadwal.value = idJadwal;

        const selectKelas = document.getElementById('edit_select_kelas');
        if (selectKelas) selectKelas.value = idKelas;

        const selectJam = document.getElementById('edit_select_jam_pelajaran');
        if (selectJam) {
            let found = Array.from(selectJam.options).some(opt => opt.value === jamPelajaran);
            if (!found) {
                const opt = document.createElement('option');
                opt.value = jamPelajaran;
                opt.textContent = jamPelajaran;
                selectJam.appendChild(opt);
            }
            selectJam.value = jamPelajaran;
        }

        document.querySelectorAll('.btn-edit-schedule-chip').forEach(btn => {
            btn.style.background = '#ffffff';
            btn.style.borderColor = '#86efac';
            btn.style.color = '#14532d';
        });
        if (event && event.currentTarget) {
            event.currentTarget.style.background = '#dcfce7';
            event.currentTarget.style.borderColor = '#22c55e';
            event.currentTarget.style.color = '#15803d';
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Modal Trash (Sampah)
    function openTrashModal() {
        document.getElementById('trashModal').style.display = 'flex';
    }
    function closeTrashModal() {
        document.getElementById('trashModal').style.display = 'none';
    }

    // Modal Detail Stats
    function openModalStatGuruTidakHadir() {
        document.getElementById('modalStatGuruTidakHadir').style.display = 'flex';
    }
    function closeModalStatGuruTidakHadir() {
        document.getElementById('modalStatGuruTidakHadir').style.display = 'none';
    }

    function openModalStatGuruPengganti() {
        document.getElementById('modalStatGuruPengganti').style.display = 'flex';
    }
    function closeModalStatGuruPengganti() {
        document.getElementById('modalStatGuruPengganti').style.display = 'none';
    }

    // Auto-fill materi & tugas dari GuruIzin
    function autoFillMateriFromIzin(selectElem) {
        const selectedOpt = selectElem.options[selectElem.selectedIndex];
        if (selectedOpt) {
            const materi = selectedOpt.getAttribute('data-materi');
            const tugas = selectedOpt.getAttribute('data-tugas');
            const materiField = document.getElementById('materi_dititipkan_field');
            const tugasField = document.getElementById('tugas_dititipkan_field');

            if (materi && materiField && !materiField.value) {
                materiField.value = materi;
            }
            if (tugas && tugasField && !tugasField.value) {
                tugasField.value = tugas;
            }
        }
    }

    // Client-side validations
    document.addEventListener('DOMContentLoaded', function() {
        onTanggalPenugasanChanged();

        const chkSehariPenuh = document.getElementById('check_sehari_penuh');
        if (chkSehariPenuh && chkSehariPenuh.checked) {
            const toggleContainer = document.querySelector('.gp-toggle-container');
            if (toggleContainer) toggleContainer.classList.add('is-active');
        }

        const selectPengganti = document.getElementById('select_guru_pengganti');
        if (selectPengganti) {
            const oldVal = selectPengganti.getAttribute('data-old-val');
            if (oldVal) {
                const isPiket = Array.from(selectPengganti.options).some(o => o.value == oldVal);
                if (!isPiket) {
                    toggleGuruMengajarLainnya();
                }
            }
        }

        const selectTidakHadir = document.getElementById('select_guru_tidak_hadir');
        if (selectTidakHadir) {
            const oldValHadir = selectTidakHadir.getAttribute('data-old-val');
            if (oldValHadir) {
                const isIzin = Array.from(selectTidakHadir.options).some(o => o.value == oldValHadir);
                if (!isIzin) {
                    toggleGuruTidakHadirLainnya(true);
                }
            }
        }

        const form = document.getElementById('formDirectPenugasan');
        const inputTanggal = document.getElementById('input_tanggal_penugasan');
        const selTidakHadir = document.getElementById('select_guru_tidak_hadir');
        const selPengganti = document.getElementById('select_guru_pengganti');

        if (form && selTidakHadir && selPengganti) {
            form.addEventListener('submit', function(e) {
                const selectedDate = inputTanggal ? inputTanggal.value : '';
                if (selectedDate && selectedDate < todayDateStr) {
                    e.preventDefault();
                    alert('Validasi Gagal: Penugasan Guru Pengganti tidak dapat dibuat untuk tanggal yang sudah berlalu (sebelum hari ini)!');
                    inputTanggal.focus();
                    return false;
                }

                if (selTidakHadir.value && selPengganti.value && selTidakHadir.value === selPengganti.value) {
                    e.preventDefault();
                    alert('Validasi Gagal: Guru Pengganti tidak boleh sama dengan Guru yang Tidak Hadir!');
                    selPengganti.focus();
                    return false;
                }
            });
        }
    });

    // Checkbox & Hapus Massal Penugasan Guru Pengganti
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.guru-pengganti-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.guru-pengganti-checkbox');
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
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
                btnBulk.style.background = '#ef4444';
                btnBulk.style.color = '#ffffff';
                btnBulk.style.borderColor = '#ef4444';
            } else {
                btnBulk.style.opacity = '0.5';
                btnBulk.style.pointerEvents = 'none';
                btnBulk.style.background = '#fee2e2';
                btnBulk.style.color = '#ef4444';
                btnBulk.style.borderColor = '#fca5a5';
            }
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu penugasan guru pengganti yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').style.display = 'flex';
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').style.display = 'none';
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-pengganti-checkbox:checked');
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
