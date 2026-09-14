@extends('layouts.guru')

@section('title', 'Guru Izin Tidak Hadir — EDU JOURNAL')

@section('styles')
<style>
    /* Prevent page horizontal scrollbar */
    html, body {
        overflow-x: hidden !important;
        max-width: 100vw;
    }
    .main-wrapper, .content-body {
        overflow-x: hidden !important;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Container & Base Styles */
    .gith-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
        padding-bottom: 24px;
    }



    /* 4 Stat Cards */
    .gith-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .gith-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .gith-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .gith-stat-card {
        border-radius: 16px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .gith-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        border-color: #cbd5e1;
    }

    /* Card Themes: uniform subtle 1px border (#e2e8f0) across all 4 cards */
    .gith-stat-card.green {
        background: linear-gradient(135deg, rgba(236, 253, 245, 0.55) 0%, #ffffff 65%, rgba(209, 250, 229, 0.25) 100%);
        border: 1px solid #e2e8f0;
    }
    .gith-stat-card.purple {
        background: linear-gradient(135deg, rgba(245, 243, 255, 0.55) 0%, #ffffff 65%, rgba(237, 233, 254, 0.25) 100%);
        border: 1px solid #e2e8f0;
    }
    .gith-stat-card.pink {
        background: linear-gradient(135deg, rgba(255, 241, 242, 0.55) 0%, #ffffff 65%, rgba(255, 228, 230, 0.25) 100%);
        border: 1px solid #e2e8f0;
    }
    .gith-stat-card.amber {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.45) 0%, #ffffff 65%, rgba(254, 243, 199, 0.2) 100%);
        border: 1px solid #e2e8f0;
    }

    .gith-stat-left {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
    }

    .gith-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .gith-stat-icon.green {
        background: #ecfdf5;
        color: #10b981;
        border: 1px solid #a7f3d0;
    }
    .gith-stat-icon.purple {
        background: #f5f3ff;
        color: #8b5cf6;
        border: 1px solid #ddd6fe;
    }
    .gith-stat-icon.pink {
        background: #fff1f2;
        color: #f43f5e;
        border: 1px solid #fecdd3;
    }
    .gith-stat-icon.amber {
        background: #fffbeb;
        color: #f59e0b;
        border: 1px solid #fde68a;
    }

    .gith-stat-content h3 {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
        display: flex;
        align-items: baseline;
        gap: 4px;
    }
    .gith-stat-content h3 span.suffix {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    .gith-stat-content p {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        margin: 3px 0 0 0;
        white-space: nowrap;
    }

    /* Main Card Container */
    .gith-main-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 18px 20px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Filter Bar - Single Line Responsive Layout */
    .gith-filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        width: 100%;
        margin-bottom: 18px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        overflow-x: auto;
    }

    @media (max-width: 1150px) {
        .gith-filter-form {
            flex-wrap: wrap;
        }
    }

    .gith-search-wrap {
        flex: 1 1 180px;
        min-width: 150px;
        position: relative;
    }
    .gith-search-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }
    .gith-search-input {
        width: 100%;
        padding: 7px 12px 7px 32px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 12px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
        height: 36px;
    }
    .gith-search-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .gith-search-input::placeholder {
        color: #94a3b8;
        font-size: 11.5px;
    }

    .gith-select {
        padding: 6.5px 9px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 11.5px;
        color: #334155;
        outline: none;
        transition: all 0.2s ease;
        cursor: pointer;
        flex: 0 0 auto;
        height: 36px;
    }
    .gith-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .gith-date-input {
        padding: 6.5px 9px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 11.5px;
        color: #334155;
        outline: none;
        transition: all 0.2s ease;
        cursor: pointer;
        flex: 0 0 auto;
        height: 36px;
    }
    .gith-date-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .gith-btn-filter {
        background: #ffffff;
        color: #2563eb;
        border: 1.5px solid #3b82f6;
        padding: 6px 13px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        height: 36px;
        flex: 0 0 auto;
    }
    .gith-btn-filter:hover {
        background: #eff6ff;
        border-color: #2563eb;
    }

    .gith-btn-reset {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 6px 11px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        height: 36px;
        flex: 0 0 auto;
    }
    .gith-btn-reset:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Actions Toolbar (Bulk Delete, Trash & Primary Action) */
    .gith-actions-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .gith-toolbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .gith-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .gith-btn-bulk-delete {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 6.5px 12px;
        border-radius: 9px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        opacity: 0.5;
        pointer-events: none;
    }
    .gith-btn-bulk-delete.active {
        opacity: 1;
        pointer-events: auto;
    }
    .gith-btn-bulk-delete:hover {
        background: #ffe4e6;
        border-color: #fda4af;
        color: #be123c;
    }

    .gith-btn-trash {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 6.5px 12px;
        border-radius: 9px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .gith-btn-trash:hover {
        background: #ffe4e6;
        border-color: #fda4af;
        color: #be123c;
    }

    .gith-btn-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 6.5px 13px;
        border-radius: 9px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        transition: all 0.2s ease;
        white-space: nowrap;
        border: none;
    }
    .gith-btn-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Custom Data Table */
    .gith-table-wrap {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-sizing: border-box;
    }

    .gith-table-wrap::-webkit-scrollbar {
        height: 6px;
    }
    .gith-table-wrap::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }
    .gith-table-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .gith-table-wrap::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .gith-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        font-size: 11.5px;
        text-align: left;
    }

    .gith-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 9px 5px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .gith-table td {
        padding: 9px 5px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .gith-table tr:hover td {
        background: #f8fafc;
    }

    .gith-table tr.row-expired td {
        background: #fafafa;
        color: #64748b;
    }

    /* Avatar & Guru Name */
    .gith-guru-cell {
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .gith-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10.5px;
        flex-shrink: 0;
    }
    .gith-avatar.expired {
        background: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }
    .gith-guru-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 11.5px;
        line-height: 1.3;
        max-width: 110px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .gith-guru-nip {
        font-size: 10px;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* Badges */
    .gith-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 1.5px 5.5px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }
    .gith-badge.biasa {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #dbeafe;
    }
    .gith-badge.cuti {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .gith-badge.appr {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .gith-badge.assigned {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .gith-badge.pending {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #ffedd5;
    }
    .gith-badge.active-status {
        background: #10b981;
        color: #ffffff;
        border: 1px solid #059669;
    }
    .gith-badge.expired-status {
        background: #94a3b8;
        color: #ffffff;
        border: 1px solid #64748b;
    }

    /* Action Buttons in Row */
    .gith-action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .gith-btn-action {
        padding: 3.5px 5.5px;
        border-radius: 6px;
        font-size: 9.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 2.5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .gith-btn-action.assign {
        background: #2563eb;
        color: #ffffff;
    }
    .gith-btn-action.assign:hover {
        background: #1d4ed8;
        color: #ffffff;
    }
    .gith-btn-action.detail {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .gith-btn-action.detail:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .gith-btn-action.delete {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }
    .gith-btn-action.delete:hover {
        background: #fee2e2;
        color: #be123c;
    }

    /* Empty State */
    .gith-empty-state {
        text-align: center;
        padding: 55px 20px;
    }
    .gith-empty-illustration {
        width: 170px;
        height: 135px;
        margin: 0 auto 12px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gith-empty-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 12px;
    }
    .gith-empty-subtitle {
        font-size: 12px;
        color: #94a3b8;
        margin: 4px auto 0 auto;
        max-width: 440px;
        line-height: 1.5;
    }

    /* Table Footer & Pagination */
    .gith-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        margin-top: 8px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }
    .gith-pagination-info {
        font-size: 12px;
        color: #94a3b8;
    }

    .gith-pagination-boxes {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .gith-p-box {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
        font-weight: 700;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        transition: all 0.15s ease;
        user-select: none;
    }
    .gith-p-box.disabled {
        color: #cbd5e1;
        cursor: not-allowed;
        background: #f8fafc;
        border-color: #f1f5f9;
    }
    .gith-p-box.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Modal Overlay & Box */
    .gith-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        padding: 16px;
    }
    .gith-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .gith-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.96);
        transition: transform 0.2s ease;
    }
    .gith-modal-overlay.active .gith-modal-box {
        transform: scale(1);
    }
    .gith-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }
    .gith-modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .gith-modal-close {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 15px;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .gith-modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Mobile Responsive Additions (Strictly Hidden on Desktop) */
    .mobile-gith-stat-carousel-wrap,
    .mobile-gith-section {
        display: none !important;
    }

    @media (max-width: 768px) {
        .gp-desktop-table-card,
        .gp-desktop-stat-grid {
            display: none !important;
        }
        .mobile-gith-stat-carousel-wrap,
        .mobile-gith-section {
            display: flex !important;
        }
        .gith-container {
            padding-bottom: 24px;
        }
        .gith-modal-overlay {
            padding: 12px;
        }
        .gith-modal-box {
            padding: 16px 14px;
            border-radius: 18px;
            max-height: 92vh;
            width: 100%;
        }
        #modalDetailContent {
            gap: 10px !important;
        }

        /* Mobile Stat Cards Carousel */
        .mobile-gith-stat-carousel-wrap {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }
        .mobile-gith-stat-container {
            position: relative;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            touch-action: pan-y;
            background: transparent;
        }
        .mobile-gith-stat-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }
        .mobile-gith-stat-slide {
            flex: 0 0 100%;
            width: 100%;
            box-sizing: border-box;
        }
        .mobile-gith-stat-slide .gith-stat-card {
            width: 100%;
            margin: 0;
            border-radius: 18px;
            padding: 16px 18px;
            box-sizing: border-box;
        }
        .m-stat-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            transition: opacity 0.25s ease, transform 0.2s ease, visibility 0.25s ease;
        }
        .mobile-gith-stat-container:hover .m-stat-arrow,
        .mobile-gith-stat-container.is-hovered .m-stat-arrow {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
        }
        .m-stat-arrow:hover,
        .m-stat-arrow:active {
            color: #2563eb;
            background: #f8fafc;
            transform: translateY(-50%) scale(0.92);
        }
        .m-stat-prev { left: 8px; }
        .m-stat-next { right: 8px; }
        .mobile-gith-stat-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .m-stat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .m-stat-dot.active {
            width: 20px;
            height: 6px;
            border-radius: 9999px;
            background: #2563eb;
        }

        /* Mobile Section */
        .mobile-gith-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }
        .mobile-gith-filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mobile-gith-filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .m-card-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .m-btn-trash-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            color: #e11d48;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .m-btn-trash-pill:hover,
        .m-btn-trash-pill:active {
            background: #ffe4e6;
            border-color: #fda4af;
            color: #be123c;
        }
        .mobile-gith-search-row {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .m-search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .m-search-input-box {
            position: relative;
            flex: 1;
            min-width: 0;
        }
        .m-search-input-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }
        .m-search-input {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px 0 34px;
            font-size: 12.5px;
            color: #1e293b;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .m-search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .m-btn-filter-trigger {
            height: 38px;
            padding: 0 16px;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
            transition: background 0.15s ease;
            position: relative;
        }
        .m-btn-filter-trigger:hover,
        .m-btn-filter-trigger:active {
            background: #1d4ed8;
        }
        .m-filter-active-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34d399;
            border: 1.5px solid #ffffff;
            margin-left: 2px;
        }
        .mobile-gith-btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #2563eb;
            color: #ffffff;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        }

        /* Mobile Cards List */
        .mobile-gith-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        .mobile-gith-card-item {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: stretch;
            padding: 12px 14px 12px 10px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .mobile-gith-card-item.card-selesai {
            border-color: #e2e8f0;
            background: #fafafa;
        }
        .mobile-gith-card-item.card-aktif {
            border-color: #d1fae5;
            background: #fcfffd;
        }

        /* Tiered Date Column */
        .mobile-card-date-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            padding: 2px 10px 2px 4px;
            border-right: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .date-aktif .m-date-day {
            font-size: 18px;
            font-weight: 800;
            color: #065f46;
            line-height: 1.1;
            text-align: center;
        }
        .date-aktif .m-date-month {
            font-size: 10px;
            font-weight: 800;
            color: #059669;
            margin-top: 2px;
            text-transform: uppercase;
        }
        .date-aktif .m-date-year {
            font-size: 9.5px;
            font-weight: 600;
            color: #94a3b8;
        }
        .date-selesai .m-date-day {
            font-size: 18px;
            font-weight: 800;
            color: #475569;
            line-height: 1.1;
            text-align: center;
        }
        .date-selesai .m-date-month {
            font-size: 10px;
            font-weight: 800;
            color: #64748b;
            margin-top: 2px;
            text-transform: uppercase;
        }
        .date-selesai .m-date-year {
            font-size: 9.5px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* Right Content */
        .mobile-card-content {
            flex: 1;
            min-width: 0;
            padding-left: 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            justify-content: center;
        }
        .m-card-badges-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            flex-wrap: wrap;
        }
        .m-card-teacher-name {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
        }
        .m-card-sub-info {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
        }
        .m-card-reason-box {
            font-size: 11.5px;
            color: #334155;
            background: #f8fafc;
            padding: 5px 8px;
            border-radius: 6px;
            border: 1px solid #f1f5f9;
            line-height: 1.35;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .m-card-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
            padding-top: 6px;
            border-top: 1px dashed #f1f5f9;
        }
        .m-btn-detail-link {
            font-size: 12px;
            font-weight: 700;
            color: #2563eb;
            background: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: background 0.15s ease;
        }
        .m-btn-detail-link:hover {
            background: #eff6ff;
        }
        .m-btn-modal-delete {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .m-btn-modal-delete:hover {
            background: #ffe4e6;
            color: #be123c;
        }
        .mobile-pagination-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 14px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        }
        .m-filter-label {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .m-filter-select, .m-filter-input {
            width: 100%;
            height: 42px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px;
            font-size: 12.5px;
            color: #1e293b;
            outline: none;
            box-sizing: border-box;
        }
        .m-filter-select:focus, .m-filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
    }
</style>
@endsection

@section('content')
<div class="gith-container">

    <!-- Flash Alert Notifications -->
    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 11px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 12.5px;">
            <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; padding: 11px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 12.5px;">
            <i class="fa-solid fa-circle-exclamation" style="color: #f43f5e; font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif



    <!-- 4 Stat Cards (Desktop Grid) -->
    <div class="gith-stats-grid gp-desktop-stat-grid">
        <!-- Card 1: Total Izin Disetujui (Green) -->
        <div class="gith-stat-card green">
            <div class="gith-stat-left">
                <div class="gith-stat-icon green">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="gith-stat-content">
                    <h3>{{ $stats['totalApproved'] }} <span class="suffix">Guru</span></h3>
                    <p>Total Izin Disetujui</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Izin Tidak Hadir Hari Ini (Purple) -->
        <div class="gith-stat-card purple">
            <div class="gith-stat-left">
                <div class="gith-stat-icon purple">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                <div class="gith-stat-content">
                    <h3>{{ $stats['approvedHariIni'] }} <span class="suffix">Guru</span></h3>
                    <p>Izin Tidak Hadir Hari Ini</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Kategori Cuti (Pink/Rose) -->
        <div class="gith-stat-card pink">
            <div class="gith-stat-left">
                <div class="gith-stat-icon pink">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <div class="gith-stat-content">
                    <h3>{{ $stats['totalCutiApproved'] }} <span class="suffix">Pengajuan</span></h3>
                    <p>Kategori Cuti (> 3 Hari)</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Perlu Pengganti (Amber/Orange) -->
        <div class="gith-stat-card amber">
            <div class="gith-stat-left">
                <div class="gith-stat-icon amber">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <div class="gith-stat-content">
                    <h3>{{ $stats['perluPenugasanCount'] }} <span class="suffix">Perlu Pengganti</span></h3>
                    <p>Izin Aktif Belum Ada Pengganti</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Stat Cards Carousel (Mobile View) -->
    <div class="mobile-gith-stat-carousel-wrap">
        <div class="mobile-gith-stat-container" id="mobileStatContainer">
            <div class="mobile-gith-stat-track" id="mobileStatTrack">
                
                <!-- Slide 1: Total Izin Disetujui (Green) -->
                <div class="mobile-gith-stat-slide">
                    <div class="gith-stat-card green">
                        <div class="gith-stat-left">
                            <div class="gith-stat-icon green">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div class="gith-stat-content">
                                <h3>{{ $stats['totalApproved'] }} <span class="suffix">Guru</span></h3>
                                <p>Total Izin Disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Izin Tidak Hadir Hari Ini (Purple) -->
                <div class="mobile-gith-stat-slide">
                    <div class="gith-stat-card purple">
                        <div class="gith-stat-left">
                            <div class="gith-stat-icon purple">
                                <i class="fa-solid fa-eye-slash"></i>
                            </div>
                            <div class="gith-stat-content">
                                <h3>{{ $stats['approvedHariIni'] }} <span class="suffix">Guru</span></h3>
                                <p>Izin Tidak Hadir Hari Ini</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Kategori Cuti (Pink) -->
                <div class="mobile-gith-stat-slide">
                    <div class="gith-stat-card pink">
                        <div class="gith-stat-left">
                            <div class="gith-stat-icon pink">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <div class="gith-stat-content">
                                <h3>{{ $stats['totalCutiApproved'] }} <span class="suffix">Pengajuan</span></h3>
                                <p>Kategori Cuti (> 3 Hari)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Perlu Pengganti (Amber) -->
                <div class="mobile-gith-stat-slide">
                    <div class="gith-stat-card amber">
                        <div class="gith-stat-left">
                            <div class="gith-stat-icon amber">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <div class="gith-stat-content">
                                <h3>{{ $stats['perluPenugasanCount'] }} <span class="suffix">Perlu Pengganti</span></h3>
                                <p>Izin Aktif Belum Ada Pengganti</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Navigation Arrows -->
            <button type="button" class="m-stat-arrow m-stat-prev" id="statPrevBtn" onclick="prevStatSlide()" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-stat-arrow m-stat-next" id="statNextBtn" onclick="nextStatSlide()" aria-label="Selanjutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Dot Indicators (4 Dots) -->
        <div class="mobile-gith-stat-dots" id="mobileStatDots">
            <span class="m-stat-dot active" onclick="goToStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(3)"></span>
        </div>
    </div>

    <!-- Main White Card Container (Desktop View) -->
    <div class="gith-main-card gp-desktop-table-card">

        <!-- Filter Bar - Clean Single Line Layout -->
        <form action="{{ route('piket.guru-izin-tidak-hadir') }}" method="GET" class="gith-filter-form">
            <!-- Search Input -->
            <div class="gith-search-wrap">
                <i class="fa-solid fa-magnifying-glass gith-search-icon"></i>
                <input type="text" name="q" value="{{ $search }}" class="gith-search-input" placeholder="Cari Nama Guru, NIP, Alasan...">
            </div>

            <!-- Kategori Filter -->
            <select name="kategori" class="gith-select">
                <option value="">-- Kategori --</option>
                <option value="biasa" {{ $kategoriFilter == 'biasa' ? 'selected' : '' }}>Izin Biasa (≤ 3 Hari)</option>
                <option value="cuti" {{ $kategoriFilter == 'cuti' ? 'selected' : '' }}>Cuti (> 3 Hari)</option>
            </select>

            <!-- Status Berlaku Filter -->
            <select name="status_berlaku" class="gith-select">
                <option value="">-- Status Berlaku --</option>
                <option value="aktif" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                <option value="selesai" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'selesai' ? 'selected' : '' }}>⚪ Selesai</option>
            </select>

            <!-- Datepicker -->
            <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="gith-date-input" title="Filter Tanggal">

            <!-- Status Penugasan Filter -->
            <select name="status_penugasan" class="gith-select">
                <option value="">-- Status Guru Pengganti --</option>
                <option value="belum" {{ $statusPenugasanFilter == 'belum' ? 'selected' : '' }}>⚠️ Belum Ditugaskan</option>
                <option value="sudah" {{ $statusPenugasanFilter == 'sudah' ? 'selected' : '' }}>✅ Sudah Ditugaskan</option>
            </select>

            <!-- Buttons -->
            <button type="submit" class="gith-btn-filter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="gith-btn-reset">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </form>

        <!-- Actions Toolbar: Bulk Delete Contextual, Sampah, & Tambah Penugasan -->
        <div class="gith-actions-toolbar">
            <div class="gith-toolbar-left">
                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="gith-btn-bulk-delete">
                    <i class="fa-regular fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>

            <div class="gith-toolbar-right">
                <a href="{{ route('piket.guru-izin-tidak-hadir.trash') }}" class="gith-btn-trash">
                    <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>

                <a href="{{ route('piket.guru-pengganti') }}" class="gith-btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Tambah Penugasan Guru Pengganti
                </a>
            </div>
        </div>

        <!-- Main Data Table -->
        <div class="gith-table-wrap">
            <table class="gith-table">
                <thead>
                    <tr>
                        <th style="width: 28px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 14px; height: 14px; cursor: pointer;">
                        </th>
                        <th style="width: 28px; text-align: center;">NO</th>
                        <th style="min-width: 110px;">GURU TIDAK HADIR</th>
                        <th style="min-width: 95px;">TANGGAL & KATEGORI</th>
                        <th style="min-width: 115px;">ALASAN & TITIPAN</th>
                        <th style="min-width: 100px;">STATUS PERSETUJUAN</th>
                        <th style="min-width: 105px;">PENUGASAN PENGGANTI</th>
                        <th style="min-width: 55px;">STATUS</th>
                        <th style="text-align: center; min-width: 170px; width: 170px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinApprovedList as $index => $item)
                        <tr class="{{ $item->is_expired ? 'row-expired' : '' }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="guru-izin-checkbox" value="{{ $item->id_guru_izin }}" onchange="updateSelectedState()" style="width: 14px; height: 14px; cursor: pointer;">
                            </td>
                            <td style="text-align: center;"><strong style="color: #64748b;">{{ $index + 1 }}</strong></td>
                            <td>
                                <div class="gith-guru-cell">
                                    <div class="gith-avatar {{ $item->is_expired ? 'expired' : '' }}">
                                        {{ strtoupper(substr($item->guru->nama_guru ?? 'G', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="gith-guru-name">{{ $item->guru->nama_guru ?? 'Guru' }}</div>
                                        <div class="gith-guru-nip">NIP: {{ $item->guru->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 11.5px;">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                                    @if($item->tanggal_mulai !== $item->tanggal_selesai)
                                        <span style="color: #94a3b8; font-weight: 400;">s/d</span> {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}
                                    @endif
                                </div>
                                <div style="margin-top: 3px;">
                                    @if($item->kategori_izin === 'cuti')
                                        <span class="gith-badge cuti">
                                            <i class="fa-solid fa-umbrella-beach"></i> Cuti / Izin Khusus
                                        </span>
                                    @else
                                        <span class="gith-badge biasa">
                                            <i class="fa-solid fa-calendar-check"></i> Izin Biasa
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #334155; line-height: 1.35; font-size: 11.5px;">
                                    {{ Str::limit($item->alasan, 34) }}
                                </div>
                                @if($item->materi_dititipkan || $item->tugas_dititipkan)
                                    <div style="margin-top: 3px; font-size: 9.5px; color: #15803d; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-book-bookmark"></i> Ada Titipan Materi/Tugas
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    <span class="gith-badge appr">
                                        <i class="fa-solid fa-circle-check"></i> Waka: Disetujui
                                    </span>
                                    <span class="gith-badge appr">
                                        <i class="fa-solid fa-circle-check"></i> Kepsek: Disetujui
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($item->has_penugasan)
                                    <span class="gith-badge assigned">
                                        <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                    </span>
                                    <div style="font-size: 10px; color: #475569; margin-top: 2px; font-weight: 600;">
                                        Guru: {{ $item->penugasans_list->first()->guruPengganti->nama_guru ?? '-' }}
                                    </div>
                                @else
                                    <span class="gith-badge pending">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Belum Ditugaskan
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_expired)
                                    <span class="gith-badge expired-status">
                                        <i class="fa-solid fa-circle-check"></i> Selesai
                                    </span>
                                @else
                                    <span class="gith-badge active-status">
                                        <i class="fa-solid fa-circle-play"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center; min-width: 170px; width: 170px; white-space: nowrap;">
                                <div class="gith-action-group">
                                    @if(!$item->is_expired)
                                        <a href="{{ route('piket.guru-pengganti', ['id_guru_tidak_hadir' => $item->id_guru]) }}" class="gith-btn-action assign" title="Tugaskan Guru Pengganti">
                                            <i class="fa-solid fa-user-plus"></i> Tugaskan
                                        </a>
                                    @endif

                                    <button type="button" class="gith-btn-action detail" onclick="openDetailModal({{ json_encode($item) }})" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <form action="{{ route('piket.guru-izin-tidak-hadir.destroy', $item->id_guru_izin) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data guru izin ini ke sampah?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="gith-btn-action delete" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="gith-empty-state">
                                    <!-- Custom SVG Clipboard Illustration Matching Design Reference -->
                                    <div class="gith-empty-illustration">
                                        <svg width="150" height="130" viewBox="0 0 160 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <!-- Ambient soft circle background -->
                                            <ellipse cx="80" cy="85" rx="55" ry="38" fill="#f0f5fe" />
                                            <circle cx="120" cy="55" r="14" fill="#e0edfe" opacity="0.6" />
                                            <circle cx="42" cy="70" r="8" fill="#e8f2fe" opacity="0.8" />
                                            
                                            <!-- Clipboard Base -->
                                            <rect x="52" y="30" width="56" height="74" rx="8" fill="#ffffff" stroke="#93c5fd" stroke-width="2.2" />
                                            
                                            <!-- Clipboard Top Clip -->
                                            <rect x="68" y="24" width="24" height="10" rx="3" fill="#60a5fa" />
                                            <rect x="74" y="21" width="12" height="6" rx="2" fill="#bfdbfe" />
                                            
                                            <!-- Checklist / Paper Lines -->
                                            <line x1="62" y1="46" x2="88" y2="46" stroke="#93c5fd" stroke-width="2.2" stroke-linecap="round" />
                                            <line x1="62" y1="56" x2="82" y2="56" stroke="#93c5fd" stroke-width="2.2" stroke-linecap="round" />
                                            <line x1="62" y1="66" x2="74" y2="66" stroke="#bfdbfe" stroke-width="2.2" stroke-linecap="round" />
                                            <line x1="62" y1="76" x2="80" y2="76" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" />
                                            
                                            <!-- Green leaf sprout decorations -->
                                            <path d="M112 78 C115 72, 122 73, 124 77 C125 82, 118 85, 112 78 Z" fill="#86efac" />
                                            <path d="M116 82 C120 79, 125 83, 123 87 C120 90, 115 87, 116 82 Z" fill="#4ade80" />

                                            <!-- Cancellation / Prohibition Symbol (Red ⊘) -->
                                            <g transform="translate(94, 68)">
                                                <circle cx="16" cy="16" r="14" fill="#ffffff" stroke="#f43f5e" stroke-width="3" />
                                                <line x1="6" y1="6" x2="26" y2="26" stroke="#f43f5e" stroke-width="3" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="gith-empty-title">Belum Ada Data Guru Izin Tidak Hadir yang Disetujui</div>
                                    <div class="gith-empty-subtitle">Seluruh penugasan guru yang disetujui Waka & Kepala sekolah muncul otomatis di sini.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        <div class="gith-table-footer">
            <div class="gith-pagination-info">
                Menampilkan {{ $guruIzinApprovedList->count() > 0 ? 1 : 0 }} - {{ $guruIzinApprovedList->count() }} dari {{ $guruIzinApprovedList->count() }} data
            </div>

            <div class="gith-pagination-boxes">
                <span class="gith-p-box disabled" title="Awal">«</span>
                <span class="gith-p-box disabled" title="Sebelumnya">‹</span>
                <span class="gith-p-box active">1</span>
                <span class="gith-p-box disabled" title="Selanjutnya">›</span>
                <span class="gith-p-box disabled" title="Akhir">»</span>
            </div>
        </div>

    </div>

    <!-- Mobile Section (Filter Card + Cards List) -->
    <div class="mobile-gith-section">
        
        <!-- Filter Card Mobile -->
        <div class="mobile-gith-filter-card">
            <div class="mobile-gith-filter-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="m-card-icon-wrap">
                        <i class="fa-solid fa-clipboard-user"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Guru Izin Tidak Hadir</h2>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 1px;">
                            Total: {{ $guruIzinApprovedList->count() }} Guru Disetujui
                        </div>
                    </div>
                </div>
                <a href="{{ route('piket.guru-izin-tidak-hadir.trash') }}" class="m-btn-trash-pill" title="Lihat Data Sampah">
                    <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>
            </div>

            <!-- Search Bar + Filter Trigger Button -->
            <div class="mobile-gith-search-row">
                <form action="{{ route('piket.guru-izin-tidak-hadir') }}" method="GET" class="m-search-form">
                    @if($kategoriFilter)
                        <input type="hidden" name="kategori" value="{{ $kategoriFilter }}">
                    @endif
                    @if(isset($statusBerlakuFilter) && $statusBerlakuFilter)
                        <input type="hidden" name="status_berlaku" value="{{ $statusBerlakuFilter }}">
                    @endif
                    @if($tanggalFilter)
                        <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
                    @endif
                    @if($statusPenugasanFilter)
                        <input type="hidden" name="status_penugasan" value="{{ $statusPenugasanFilter }}">
                    @endif
                    <div class="m-search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari Guru / NIP / Alasan..." class="m-search-input">
                    </div>
                    <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()">
                        <i class="fa-solid fa-filter"></i> Filter
                        @if($kategoriFilter || (isset($statusBerlakuFilter) && $statusBerlakuFilter) || $tanggalFilter || $statusPenugasanFilter)
                            <span class="m-filter-active-dot"></span>
                        @endif
                    </button>
                </form>
            </div>

            <!-- Action: Tambah Penugasan Guru Pengganti -->
            <a href="{{ route('piket.guru-pengganti') }}" class="mobile-gith-btn-primary">
                <i class="fa-solid fa-user-plus"></i> Tambah Penugasan Guru Pengganti
            </a>
        </div>

        <!-- Cards List Mobile -->
        <div class="mobile-gith-cards-list">
            @forelse($guruIzinApprovedList as $item)
                @php
                    $startDate = \Carbon\Carbon::parse($item->tanggal_mulai);
                    $endDate = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai) : $startDate;
                    $isMultiDay = ($item->tanggal_selesai && $item->tanggal_mulai !== $item->tanggal_selesai);
                    
                    if (!$isMultiDay) {
                        $dayDisplay = $startDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } elseif ($startDate->format('m Y') === $endDate->format('m Y')) {
                        $dayDisplay = $startDate->format('d') . '-' . $endDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } else {
                        $dayDisplay = $startDate->format('d/m') . '-' . $endDate->format('d/m');
                        $monthDisplay = $startDate->format('Y');
                        $yearDisplay = '';
                    }

                    $dateThemeClass = $item->is_expired ? 'date-selesai' : 'date-aktif';
                    $cardThemeClass = $item->is_expired ? 'card-selesai' : 'card-aktif';
                @endphp

                <div class="mobile-gith-card-item {{ $cardThemeClass }}">
                    <!-- Left Tiered Date Column -->
                    <div class="mobile-card-date-col {{ $dateThemeClass }}">
                        <div class="m-date-day">{{ $dayDisplay }}</div>
                        <div class="m-date-month">{{ $monthDisplay }}</div>
                        @if($yearDisplay)
                            <div class="m-date-year">{{ $yearDisplay }}</div>
                        @endif
                    </div>

                    <!-- Right Card Content -->
                    <div class="mobile-card-content">
                        <!-- Badges Row -->
                        <div class="m-card-badges-row">
                            <div>
                                @if($item->kategori_izin === 'cuti')
                                    <span class="gith-badge cuti">
                                        <i class="fa-solid fa-umbrella-beach"></i> Cuti / Khusus
                                    </span>
                                @else
                                    <span class="gith-badge biasa">
                                        <i class="fa-solid fa-calendar-check"></i> Izin Biasa
                                    </span>
                                @endif
                            </div>
                            <div>
                                @if($item->is_expired)
                                    <span class="gith-badge expired-status">
                                        <i class="fa-solid fa-circle-check"></i> Selesai
                                    </span>
                                @else
                                    <span class="gith-badge active-status">
                                        <i class="fa-solid fa-circle-play"></i> Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Teacher Info -->
                        <div>
                            <div class="m-card-teacher-name">{{ $item->guru->nama_guru ?? 'Guru' }}</div>
                            <div class="m-card-sub-info">NIP: {{ $item->guru->nip ?? '-' }}</div>
                        </div>

                        <!-- Status Penugasan -->
                        <div>
                            @if($item->has_penugasan)
                                <span class="gith-badge assigned" style="font-size: 10px; padding: 2px 6px;">
                                    <i class="fa-solid fa-user-check"></i> Pengganti: {{ $item->penugasans_list->first()->guruPengganti->nama_guru ?? '-' }}
                                </span>
                            @else
                                <span class="gith-badge pending" style="font-size: 10px; padding: 2px 6px;">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Belum Ditugaskan
                                </span>
                            @endif
                        </div>

                        <!-- Reason Quote Box -->
                        <div class="m-card-reason-box">
                            "{{ Str::limit($item->alasan, 65) }}"
                        </div>
                        @if($item->materi_dititipkan || $item->tugas_dititipkan)
                            <div style="font-size: 10px; color: #15803d; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-book-bookmark"></i> Titipan Pembelajaran Terlampir
                            </div>
                        @endif

                        <!-- Footer Actions -->
                        <div class="m-card-footer-row">
                            <div>
                                @if(!$item->is_expired)
                                    <a href="{{ route('piket.guru-pengganti', ['id_guru_tidak_hadir' => $item->id_guru]) }}" class="gith-btn-action assign" style="padding: 4.5px 8px; font-size: 10.5px; text-decoration: none;">
                                        <i class="fa-solid fa-user-plus"></i> Tugaskan
                                    </a>
                                @endif
                            </div>
                            <button type="button" class="m-btn-detail-link" onclick="openDetailModal({{ json_encode($item) }})">
                                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="gith-main-card" style="text-align: center; padding: 36px 16px;">
                    <div class="gith-empty-state" style="padding: 10px 0;">
                        <div class="gith-empty-title">Belum Ada Data Guru Izin Tidak Hadir</div>
                        <div class="gith-empty-subtitle">Seluruh perizinan guru yang disetujui akan muncul di sini.</div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Mobile Pagination Card -->
        @if($guruIzinApprovedList->count() > 0)
            <div class="mobile-pagination-card">
                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                    Total: {{ $guruIzinApprovedList->count() }} Data
                </span>
                <span class="gith-p-box active" style="min-width: 28px; height: 28px;">1</span>
            </div>
        @endif

    </div>
</div>

<!-- Modal Detail Guru Izin Disetujui -->
<div id="modalDetailIzin" class="gith-modal-overlay">
    <div class="gith-modal-box">
        <div class="gith-modal-header">
            <h3><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Guru Izin Tidak Hadir</h3>
            <button class="gith-modal-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div id="modalDetailContent" style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
            <!-- Content Populated via JavaScript -->
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px; border-top: 1px solid #e2e8f0; padding-top: 14px; flex-wrap: wrap; gap: 8px;">
            <form id="formDeleteDetail" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data guru izin ini ke sampah?');" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-btn-modal-delete">
                    <i class="fa-regular fa-trash-can"></i> Pindahkan ke Sampah
                </button>
            </form>
            <div style="display: flex; gap: 8px; align-items: center;">
                <a id="dt_btn_assign" href="#" class="gith-btn-action assign" style="padding: 7px 12px; font-size: 11.5px; text-decoration: none; display: none;">
                    <i class="fa-solid fa-user-plus"></i> Tugaskan Pengganti
                </a>
                <button type="button" class="gith-btn-reset" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter Mobile Guru Izin Tidak Hadir -->
<div id="mobileFilterModal" class="gith-modal-overlay">
    <div class="gith-modal-box" style="max-width: 440px;">
        <div class="gith-modal-header">
            <h3><i class="fa-solid fa-filter" style="color: #2563eb;"></i> Filter Guru Izin Tidak Hadir</h3>
            <button type="button" class="gith-modal-close" onclick="closeMobileFilterModal()">&times;</button>
        </div>
        <form action="{{ route('piket.guru-izin-tidak-hadir') }}" method="GET">
            @if($search)
                <input type="hidden" name="q" value="{{ $search }}">
            @endif
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label class="m-filter-label"><i class="fa-solid fa-layer-group" style="color: #2563eb;"></i> Kategori Izin</label>
                    <select name="kategori" class="m-filter-select">
                        <option value="">-- Semua Kategori --</option>
                        <option value="biasa" {{ $kategoriFilter == 'biasa' ? 'selected' : '' }}>Izin Biasa (≤ 3 Hari)</option>
                        <option value="cuti" {{ $kategoriFilter == 'cuti' ? 'selected' : '' }}>Cuti (> 3 Hari)</option>
                    </select>
                </div>
                <div>
                    <label class="m-filter-label"><i class="fa-solid fa-circle-check" style="color: #2563eb;"></i> Status Masa Berlaku</label>
                    <select name="status_berlaku" class="m-filter-select">
                        <option value="">-- Semua Status Berlaku --</option>
                        <option value="aktif" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                        <option value="selesai" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'selesai' ? 'selected' : '' }}>⚪ Selesai</option>
                    </select>
                </div>
                <div>
                    <label class="m-filter-label"><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> Tanggal Izin</label>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="m-filter-input">
                </div>
                <div>
                    <label class="m-filter-label"><i class="fa-solid fa-user-gear" style="color: #2563eb;"></i> Status Guru Pengganti</label>
                    <select name="status_penugasan" class="m-filter-select">
                        <option value="">-- Semua Status Pengganti --</option>
                        <option value="belum" {{ $statusPenugasanFilter == 'belum' ? 'selected' : '' }}>⚠️ Belum Ditugaskan</option>
                        <option value="sudah" {{ $statusPenugasanFilter == 'sudah' ? 'selected' : '' }}>✅ Sudah Ditugaskan</option>
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="gith-btn-reset" style="text-decoration: none; justify-content: center; height: 42px; font-weight: 700;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="gith-btn-primary" style="justify-content: center; height: 42px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer;">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Form Hidden untuk Hapus Massal Guru Izin Tidak Hadir -->
<form id="bulkDeleteForm" action="{{ route('piket.guru-izin-tidak-hadir.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal Guru Izin Tidak Hadir -->
<div id="bulkDeleteModal" class="gith-modal-overlay">
    <div class="gith-modal-box" style="max-width: 440px; text-align: center; padding: 26px;">
        <div style="width: 58px; height: 58px; background: #fff1f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #f43f5e; font-size: 26px; border: 1px solid #fecdd3;">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">Pindahkan ke Sampah?</h3>
        <p style="font-size: 13px; color: #64748b; font-weight: 500; margin: 0 0 20px 0; line-height: 1.5;">
            Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #e11d48;">0</strong> data guru izin tidak hadir yang dipilih ke fitur Sampah?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" onclick="closeBulkDeleteModal()" class="gith-btn-reset" style="padding: 9px 18px;">
                Batal
            </button>
            <button type="button" onclick="executeBulkDelete()" style="padding: 9px 20px; font-size: 12.5px; font-weight: 700; background: #e11d48; color: #ffffff; border: none; border-radius: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStatSlide = 0;
    const totalStatSlides = 4;

    function updateStatCarousel() {
        const track = document.getElementById('mobileStatTrack');
        if (!track) return;
        track.style.transform = 'translateX(-' + (currentStatSlide * 100) + '%)';
        
        const dots = document.querySelectorAll('#mobileStatDots .m-stat-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentStatSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function nextStatSlide() {
        currentStatSlide = (currentStatSlide + 1) % totalStatSlides;
        updateStatCarousel();
    }

    function prevStatSlide() {
        currentStatSlide = (currentStatSlide - 1 + totalStatSlides) % totalStatSlides;
        updateStatCarousel();
    }

    function goToStatSlide(index) {
        currentStatSlide = index;
        updateStatCarousel();
    }

    function initStatCarousel() {
        const container = document.getElementById('mobileStatContainer');
        if (!container) return;

        let touchStartX = 0;
        let touchEndX = 0;

        container.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        container.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleStatSwipe();
        }, { passive: true });

        function handleStatSwipe() {
            const swipeThreshold = 40;
            if (touchEndX < touchStartX - swipeThreshold) {
                nextStatSlide();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                prevStatSlide();
            }
        }
    }

    function openMobileFilterModal() {
        const modal = document.getElementById('mobileFilterModal');
        if (modal) modal.classList.add('active');
    }

    function closeMobileFilterModal() {
        const modal = document.getElementById('mobileFilterModal');
        if (modal) modal.classList.remove('active');
    }

    function openDetailModal(item) {
        let statusMasaHtml = item.is_expired 
            ? `<span class="gith-badge expired-status"><i class="fa-solid fa-circle-check"></i> Selesai</span>`
            : `<span class="gith-badge active-status"><i class="fa-solid fa-circle-play"></i> Aktif</span>`;

        let contentHtml = `
            <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <div style="font-size: 15px; font-weight: 800; color: #0f172a;">${item.guru ? item.guru.nama_guru : 'Guru'}</div>
                    <div style="color: #64748b; font-weight: 600; font-size: 12px; margin-top: 2px;">NIP: ${item.guru ? (item.guru.nip || '-') : '-'}</div>
                </div>
                <div>${statusMasaHtml}</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="background: #f1f5f9; padding: 10px 12px; border-radius: 10px;">
                    <span style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Mulai Izin</span>
                    <div style="font-weight: 800; color: #0f172a; font-size: 13px; margin-top: 2px;">${item.tanggal_mulai}</div>
                </div>
                <div style="background: #f1f5f9; padding: 10px 12px; border-radius: 10px;">
                    <span style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Selesai Izin</span>
                    <div style="font-weight: 800; color: #0f172a; font-size: 13px; margin-top: 2px;">${item.tanggal_selesai}</div>
                </div>
            </div>

            <div>
                <strong style="color: #475569; font-size: 12px;">Alasan Izin / Sakit / Cuti:</strong>
                <div style="background: #ffffff; border: 1px solid #cbd5e1; padding: 10px 12px; border-radius: 10px; margin-top: 4px; color: #0f172a; font-weight: 600; line-height: 1.4;">
                    ${item.alasan || '-'}
                </div>
            </div>
        `;

        if (item.keterangan_khusus) {
            contentHtml += `
                <div>
                    <strong style="color: #475569; font-size: 12px;">Catatan Tambahan Piket:</strong>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 10px 12px; border-radius: 10px; margin-top: 4px; color: #92400e; font-weight: 600;">
                        ${item.keterangan_khusus}
                    </div>
                </div>
            `;
        }

        // PRATINJAU FOTO SURAT / DOKUMEN BUKTI CUTI
        if (item.foto_url) {
            contentHtml += `
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                    <strong style="color: #334155; display: block; margin-bottom: 6px; font-size: 12px;">
                        <i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Unggahan Foto Surat / Dokumen Bukti Izin / Cuti:
                    </strong>
                    <div style="text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px dashed #cbd5e1;">
                        <img src="${item.foto_url}" alt="Foto Surat Bukti Izin" style="max-width: 100%; max-height: 260px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); object-fit: contain;">
                        <div style="margin-top: 8px;">
                            <a href="${item.foto_url}" target="_blank" class="gith-btn-action detail" style="display: inline-flex; text-decoration: none;">
                                <i class="fa-solid fa-up-right-from-square"></i> Lihat Foto Ukuran Penuh
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            contentHtml += `
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; color: #64748b; font-size: 12px;">
                    <i class="fa-solid fa-circle-info" style="color: #94a3b8;"></i> Tidak ada unggahan foto surat / dokumen khusus untuk pengajuan ini.
                </div>
            `;
        }

        // FILE TUGAS DITITIPKAN
        if (item.file_tugas_url) {
            contentHtml += `
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <strong style="color: #1e40af; font-size: 12px;"><i class="fa-solid fa-file-arrow-down"></i> File Tugas Titipan Guru:</strong>
                        <div style="font-size: 11.5px; color: #1e3a8a; margin-top: 2px;">${item.file_tugas || 'Lampiran Tugas'}</div>
                    </div>
                    <a href="${item.file_tugas_url}" target="_blank" class="gith-btn-action assign" style="text-decoration: none;">
                        <i class="fa-solid fa-download"></i> Unduh File Tugas
                    </a>
                </div>
            `;
        }

        if (item.materi_dititipkan || item.tugas_dititipkan) {
            contentHtml += `
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 12px; border-radius: 10px;">
                    <strong style="color: #166534; font-size: 12px;"><i class="fa-solid fa-book"></i> Titipan Pembelajaran:</strong>
                    <div style="margin-top: 4px; color: #15803d; font-size: 12px; line-height: 1.4;">
                        <div><strong>Materi:</strong> ${item.materi_dititipkan || '-'}</div>
                        <div style="margin-top: 2px;"><strong>Tugas:</strong> ${item.tugas_dititipkan || '-'}</div>
                    </div>
                </div>
            `;
        }

        contentHtml += `
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 12px; border-radius: 10px;">
                <strong style="color: #334155; font-size: 12px;"><i class="fa-solid fa-shield-halved" style="color: #16a34a;"></i> Bukti Persetujuan Resmi:</strong>
                <div style="display: flex; gap: 8px; margin-top: 6px; flex-wrap: wrap;">
                    <span class="gith-badge appr">✓ Waka Kurikulum (Disetujui)</span>
                    <span class="gith-badge appr">✓ Kepala Sekolah (Disetujui)</span>
                </div>
            </div>
        `;

        // Update Option A delete form action
        const deleteForm = document.getElementById('formDeleteDetail');
        if (deleteForm) {
            deleteForm.action = "{{ route('piket.guru-izin-tidak-hadir.destroy', ':id') }}".replace(':id', item.id_guru_izin);
        }

        // Update Tugaskan Pengganti button
        const assignBtn = document.getElementById('dt_btn_assign');
        if (assignBtn) {
            if (!item.is_expired) {
                assignBtn.href = "{{ route('piket.guru-pengganti') }}?id_guru_tidak_hadir=" + item.id_guru;
                assignBtn.style.display = 'inline-flex';
            } else {
                assignBtn.style.display = 'none';
            }
        }

        document.getElementById('modalDetailContent').innerHTML = contentHtml;
        document.getElementById('modalDetailIzin').classList.add('active');
    }

    function closeDetailModal() {
        document.getElementById('modalDetailIzin').classList.remove('active');
    }

    // Fitur Checkbox & Hapus Massal Guru Izin Tidak Hadir
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.guru-izin-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.guru-izin-checkbox');
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
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
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu data guru izin yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').classList.add('active');
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').classList.remove('active');
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
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

    // Tutup modal jika klik overlay luar
    window.addEventListener('click', function(e) {
        const detailModal = document.getElementById('modalDetailIzin');
        const bulkModal = document.getElementById('bulkDeleteModal');
        const filterModal = document.getElementById('mobileFilterModal');
        if (e.target === detailModal) closeDetailModal();
        if (e.target === bulkModal) closeBulkDeleteModal();
        if (e.target === filterModal) closeMobileFilterModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        initStatCarousel();
    });
</script>
@endsection
