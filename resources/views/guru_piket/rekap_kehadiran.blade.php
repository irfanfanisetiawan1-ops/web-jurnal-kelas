@extends('layouts.guru')

@section('title', 'Rekap Kehadiran Guru — Guru Piket')
@section('header_title', 'Rekap Kehadiran')

@section('styles')
<style>
    /* ─── Global Scoped Styles untuk Rekap Kehadiran ─── */
    .rekap-page-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    /* ─── 1. Top 4 Stat Cards (Tanpa Chevron & Tanpa Persentase Palsu) ─── */
    .rekap-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 1024px) {
        .rekap-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .rekap-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .rekap-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .rekap-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    /* Gradient subtle tint di bagian bawah kartu */
    .rekap-stat-card.blue {
        background: linear-gradient(180deg, #ffffff 0%, #f0f7ff 100%);
    }
    .rekap-stat-card.orange {
        background: linear-gradient(180deg, #ffffff 0%, #fffbf0 100%);
    }
    .rekap-stat-card.red {
        background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
    }
    .rekap-stat-card.purple {
        background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
    }

    .rekap-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .rekap-stat-icon.blue   { background: #dbeafe; color: #2563eb; }
    .rekap-stat-icon.orange { background: #ffedd5; color: #ea580c; }
    .rekap-stat-icon.red    { background: #fee2e2; color: #dc2626; }
    .rekap-stat-icon.purple { background: #ede9fe; color: #7c3aed; }

    .rekap-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .rekap-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: -0.01em;
    }

    .rekap-stat-number-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin: 3px 0 2px 0;
    }

    .rekap-stat-number {
        font-size: 26px;
        font-weight: 850;
        color: #1e293b;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .rekap-stat-unit {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
    }

    .rekap-stat-sub {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* ─── 2. Card Universal & Header ─── */
    .rekap-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .rekap-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rekap-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 850;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .rekap-card-title i {
        color: #2b3957;
        font-size: 18px;
    }

    .rekap-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-rekap-export {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 750;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-rekap-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .btn-rekap-cetak {
        background: #2b3957;
        border: 1px solid #2b3957;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 750;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-rekap-cetak:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* ─── 3. Filter Bar (2 Baris Rapi) ─── */
    .rekap-filter-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .rekap-filter-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rekap-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .rekap-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        font-size: 13.5px;
        pointer-events: none;
    }

    .rekap-filter-input {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 38px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        height: 42px;
        width: 100%;
    }

    .rekap-filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .rekap-filter-select {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 38px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        height: 42px;
        min-width: 180px;
    }

    .rekap-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-rekap-filter {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 9px 22px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .btn-rekap-filter:hover {
        background: #1d4ed8;
    }

    .btn-rekap-reset {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        height: 42px;
        transition: all 0.2s ease;
    }

    .btn-rekap-reset:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* ─── 4. Table Styling ─── */
    .rekap-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
    }

    .rekap-custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .rekap-custom-table thead tr {
        background: #f8fafc;
    }

    .rekap-custom-table th {
        padding: 14px 16px;
        font-weight: 750;
        color: #475569;
        font-size: 12px;
        letter-spacing: 0.02em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .rekap-custom-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
        font-weight: 600;
    }

    .rekap-custom-table tr:hover td {
        background: #f8fafc;
    }

    .rekap-custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Guru Avatar Inisial */
    .guru-cell-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .guru-avatar-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 850;
        flex-shrink: 0;
        letter-spacing: -0.02em;
    }

    .guru-nama-text {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Status Badges */
    .status-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-badge-pill i {
        font-size: 11.5px;
    }

    .badge-hadir {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-tidak-hadir {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-izin {
        background: #fef3c7;
        color: #b45309;
    }

    .badge-digantikan {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* Tombol Aksi Titik Tiga */
    .btn-action-dots {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-dots:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    /* ─── 5. Table Footer & Pagination ─── */
    .rekap-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rekap-pagination-info {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
    }

    .rekap-pagination-list {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rekap-page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .rekap-page-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .rekap-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* ─── 6. Bottom Alert Banner ─── */
    .rekap-bottom-banner {
        background: linear-gradient(90deg, #eff6ff 0%, #f0fdf4 100%);
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .rekap-bottom-left {
        display: flex;
        align-items: center;
        gap: 14px;
        z-index: 2;
    }

    .rekap-bottom-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #2563eb;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .rekap-bottom-text {
        font-size: 13px;
        font-weight: 650;
        color: #1e40af;
        letter-spacing: -0.01em;
    }

    /* ─── 7. Modal Detail Rekap Presensi ─── */
    .rekap-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 16px;
    }

    .rekap-modal-backdrop.active {
        display: flex;
    }

    .rekap-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: rekapModalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes rekapModalIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .rekap-modal-header {
        background: #1e293b;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .rekap-modal-title {
        font-size: 15px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rekap-modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 4px;
        line-height: 1;
    }

    .rekap-modal-close:hover {
        color: #ffffff;
    }

    .rekap-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .rekap-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .rekap-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .rekap-detail-label {
        font-weight: 650;
        color: #64748b;
    }

    .rekap-detail-val {
        font-weight: 800;
        color: #1e293b;
        text-align: right;
    }

    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .mobile-page-topbar,
    .mobile-rekap-stat-carousel-wrap,
    .mobile-rekap-section,
    #mobileRekapFilterModal {
        display: none !important;
    }

    @media (max-width: 768px) {
        .rekap-desktop-stats,
        .rekap-desktop-card {
            display: none !important;
        }

        .mobile-page-topbar,
        .mobile-rekap-stat-carousel-wrap,
        .mobile-rekap-section {
            display: flex !important;
        }

        #mobileRekapFilterModal.active {
            display: flex !important;
        }

        .rekap-page-container {
            padding-bottom: 28px;
            gap: 14px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        /* Topbar */
        .mobile-page-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 10px 14px;
            margin-bottom: 2px;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-back-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .mobile-back-btn:active {
            background: #eff6ff;
            color: #2563eb;
            transform: scale(0.95);
        }

        .mobile-topbar-title-wrap {
            flex: 1;
            min-width: 0;
        }

        .mobile-topbar-title {
            font-size: 15px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-topbar-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-topbar-right-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .m-btn-pill-action {
            height: 32px;
            padding: 0 9px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* Carousel Stat */
        .mobile-rekap-stat-carousel-wrap {
            position: relative;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-sizing: border-box;
        }

        .mobile-rekap-stat-viewport {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow: hidden;
            border-radius: 18px;
            touch-action: pan-y;
            box-sizing: border-box;
        }

        .mobile-rekap-stat-track {
            display: flex;
            transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-rekap-stat-slide {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            flex-shrink: 0;
            box-sizing: border-box;
        }

        .mobile-rekap-stat-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .m-stat-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #cbd5e1;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .m-stat-dot.active {
            width: 22px;
            background: #2563eb;
        }

        /* Mobile Presence Cards List */
        .mobile-rekap-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-rekap-filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .m-search-input {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px 0 34px !important;
            font-size: 12px;
            color: #1e293b;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .m-btn-filter-trigger {
            height: 38px;
            padding: 0 14px;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
            transition: background 0.15s ease;
            position: relative;
            white-space: nowrap;
        }

        .m-filter-active-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34d399;
            border: 1.5px solid #ffffff;
            margin-left: 2px;
        }

        .mobile-rekap-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-rekap-card-item {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px 16px;
            position: relative;
            overflow: hidden;
            border-left: 4px solid #2563eb;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-rekap-card-item.accent-hadir {
            border-left-color: #10b981;
        }
        .mobile-rekap-card-item.accent-izin {
            border-left-color: #f59e0b;
        }
        .mobile-rekap-card-item.accent-tidak-hadir {
            border-left-color: #ef4444;
        }
        .mobile-rekap-card-item.accent-digantikan {
            border-left-color: #8b5cf6;
        }

        .m-rekap-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            width: 100%;
            min-width: 0;
        }

        .m-rekap-title-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .m-card-icon-wrap {
            width: 38px;
            height: 38px;
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

        .m-rekap-teacher-name {
            font-size: 14.5px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-rekap-meta-sub {
            font-size: 11.5px;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .m-rekap-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .m-rekap-info-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .m-rekap-info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.02em;
        }

        .m-rekap-info-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-rekap-action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px dashed #e2e8f0;
            margin-top: 2px;
        }

        .m-btn-detail-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: #2563eb;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        /* Bottom Sheet Filter Modal */
        .mobile-filter-modal-wrap {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 99999;
            display: none;
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }

        .mobile-filter-modal-wrap.active {
            display: flex !important;
        }

        .mobile-filter-sheet {
            background: #ffffff;
            border-radius: 20px 20px 0 0;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: sheetSlideUp 0.25s ease-out;
            max-height: 85vh;
        }

        .mobile-filter-sheet-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-filter-sheet-title {
            font-size: 15px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mobile-filter-sheet-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            overflow-y: auto;
        }

        .mobile-filter-actions-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }

        .mobile-filter-sheet-close {
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            font-size: 14px;
        }

        @keyframes sheetSlideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    }
</style>
@endsection

@section('content')
@php
    $totalGuruCount = $guruList ? $guruList->count() : 40;
    if ($totalGuruCount === 0) $totalGuruCount = 40;

    // Palet warna avatar inisial
    $avatarPalettes = [
        ['bg' => '#dbeafe', 'color' => '#1d4ed8'], // Blue (BS)
        ['bg' => '#ffe4e6', 'color' => '#e11d48'], // Rose (RM)
        ['bg' => '#fef3c7', 'color' => '#b45309'], // Amber (DL)
        ['bg' => '#d1fae5', 'color' => '#059669'], // Emerald (AH)
        ['bg' => '#ede9fe', 'color' => '#6d28d9'], // Purple (AF)
        ['bg' => '#e0e7ff', 'color' => '#4338ca'], // Indigo (LS)
    ];
@endphp

<div class="rekap-page-container">

    <!-- ─── MOBILE TOPBAR (TITLE + EXPORT/PRINT PILLS) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Rekap Kehadiran</h1>
            <span class="mobile-topbar-sub">Presensi guru & rekapitulasi KBM</span>
        </div>
        <div class="mobile-topbar-right-actions">
            <a href="{{ route('piket.rekap-kehadiran.export') }}" class="m-btn-pill-action" title="Export CSV">
                <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i>
                <span>CSV</span>
            </a>
            <a href="{{ route('piket.rekap-kehadiran.print') }}" target="_blank" class="m-btn-pill-action" title="Cetak Presensi">
                <i class="fa-solid fa-print" style="color: #475569;"></i>
                <span>Cetak</span>
            </a>
        </div>
    </div>

    <!-- ─── MOBILE 4-STAT CAROUSEL (SWIPEABLE + 4 DOT INDICATORS) ─── -->
    <div class="mobile-rekap-stat-carousel-wrap">
        <div class="mobile-rekap-stat-viewport" id="mobileRekapStatViewport">
            <div class="mobile-rekap-stat-track" id="mobileRekapStatTrack">
                <!-- Slide 1: Hadir -->
                <div class="mobile-rekap-stat-slide">
                    <div class="rekap-stat-card blue" style="margin: 0;">
                        <div class="rekap-stat-icon blue">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="rekap-stat-info">
                            <span class="rekap-stat-title">Hadir</span>
                            <div class="rekap-stat-number-wrap">
                                <span class="rekap-stat-number">{{ $stats['hadir'] ?? 32 }}</span>
                                <span class="rekap-stat-unit">Guru</span>
                            </div>
                            <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Izin -->
                <div class="mobile-rekap-stat-slide">
                    <div class="rekap-stat-card orange" style="margin: 0;">
                        <div class="rekap-stat-icon orange">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div class="rekap-stat-info">
                            <span class="rekap-stat-title">Izin</span>
                            <div class="rekap-stat-number-wrap">
                                <span class="rekap-stat-number">{{ $stats['izin'] ?? 3 }}</span>
                                <span class="rekap-stat-unit">Guru</span>
                            </div>
                            <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Tidak Hadir -->
                <div class="mobile-rekap-stat-slide">
                    <div class="rekap-stat-card red" style="margin: 0;">
                        <div class="rekap-stat-icon red">
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <div class="rekap-stat-info">
                            <span class="rekap-stat-title">Tidak Hadir</span>
                            <div class="rekap-stat-number-wrap">
                                <span class="rekap-stat-number">{{ $stats['tidakHadir'] ?? 5 }}</span>
                                <span class="rekap-stat-unit">Guru</span>
                            </div>
                            <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Digantikan -->
                <div class="mobile-rekap-stat-slide">
                    <div class="rekap-stat-card purple" style="margin: 0;">
                        <div class="rekap-stat-icon purple">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <div class="rekap-stat-info">
                            <span class="rekap-stat-title">Digantikan</span>
                            <div class="rekap-stat-number-wrap">
                                <span class="rekap-stat-number">{{ $stats['digantikan'] ?? 4 }}</span>
                                <span class="rekap-stat-unit">Guru</span>
                            </div>
                            <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Dots -->
        <div class="mobile-rekap-stat-dots" id="mobileRekapStatDots">
            <span class="m-stat-dot active" onclick="goToRekapStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToRekapStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToRekapStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToRekapStatSlide(3)"></span>
        </div>
    </div>

    <!-- ─── TOP 4 STAT CARDS DESKTOP ─── -->
    <div class="rekap-desktop-stats">
        <div class="rekap-stats-grid">
            <!-- Card 1: Hadir -->
            <div class="rekap-stat-card blue">
                <div class="rekap-stat-icon blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="rekap-stat-info">
                    <span class="rekap-stat-title">Hadir</span>
                    <div class="rekap-stat-number-wrap">
                        <span class="rekap-stat-number">{{ $stats['hadir'] ?? 32 }}</span>
                        <span class="rekap-stat-unit">Guru</span>
                    </div>
                    <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                </div>
            </div>

            <!-- Card 2: Izin -->
            <div class="rekap-stat-card orange">
                <div class="rekap-stat-icon orange">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="rekap-stat-info">
                    <span class="rekap-stat-title">Izin</span>
                    <div class="rekap-stat-number-wrap">
                        <span class="rekap-stat-number">{{ $stats['izin'] ?? 3 }}</span>
                        <span class="rekap-stat-unit">Guru</span>
                    </div>
                    <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                </div>
            </div>

            <!-- Card 3: Tidak Hadir -->
            <div class="rekap-stat-card red">
                <div class="rekap-stat-icon red">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
                <div class="rekap-stat-info">
                    <span class="rekap-stat-title">Tidak Hadir</span>
                    <div class="rekap-stat-number-wrap">
                        <span class="rekap-stat-number">{{ $stats['tidakHadir'] ?? 5 }}</span>
                        <span class="rekap-stat-unit">Guru</span>
                    </div>
                    <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                </div>
            </div>

            <!-- Card 4: Digantikan -->
            <div class="rekap-stat-card purple">
                <div class="rekap-stat-icon purple">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div class="rekap-stat-info">
                    <span class="rekap-stat-title">Digantikan</span>
                    <div class="rekap-stat-number-wrap">
                        <span class="rekap-stat-number">{{ $stats['digantikan'] ?? 4 }}</span>
                        <span class="rekap-stat-unit">Guru</span>
                    </div>
                    <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── DESKTOP CARDS CONTAINER ─── -->
    <div class="rekap-desktop-card">
        <!-- ─── 2. CARD "DAFTAR KEHADIRAN GURU" (FULL WIDTH) ─── -->
        <div class="rekap-card">
            <div class="rekap-card-header">
                <div class="rekap-card-title">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Daftar Kehadiran Guru</span>
                </div>

                <div class="rekap-header-actions">
                    <a href="{{ route('piket.rekap-kehadiran.export') }}" class="btn-rekap-export" title="Export Rekap ke CSV">
                        <i class="fa-solid fa-arrow-down-to-bracket"></i>
                        <span>Export</span>
                    </a>
                    <a href="{{ route('piket.rekap-kehadiran.print') }}" target="_blank" class="btn-rekap-cetak" title="Cetak Rekap Presensi">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak</span>
                    </a>
                </div>
            </div>

            <!-- Filter Bar 2 Baris Rapi -->
            <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="rekap-filter-container">
                <!-- Baris 1: Search (flex-1) + Date + Dropdown Guru -->
                <div class="rekap-filter-row">
                    <!-- Search Input (flex-1) -->
                    <div class="rekap-input-wrapper" style="flex: 1; min-width: 260px;">
                        <i class="fa-solid fa-magnifying-glass rekap-input-icon"></i>
                        <input type="text" name="q" value="{{ $search }}" class="rekap-filter-input" placeholder="Cari nama guru, NIP, atau mata pelajaran...">
                    </div>

                    <!-- Date Picker Input -->
                    <div class="rekap-input-wrapper" style="width: 170px;">
                        <i class="fa-regular fa-clock rekap-input-icon"></i>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="rekap-filter-input" title="Filter Tanggal">
                    </div>

                    <!-- Dropdown Guru -->
                    <div class="rekap-input-wrapper" style="min-width: 180px;">
                        <i class="fa-regular fa-user rekap-input-icon"></i>
                        <select name="id_guru" class="rekap-filter-select">
                            <option value="">Semua Guru</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}" {{ ($idGuruFilter == $g->id_guru) ? 'selected' : '' }}>
                                    {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Baris 2: Dropdown Mapel + Button Filter & Reset -->
                <div class="rekap-filter-row">
                    <!-- Dropdown Mapel -->
                    <div class="rekap-input-wrapper" style="min-width: 220px;">
                        <i class="fa-solid fa-book-bookmark rekap-input-icon"></i>
                        <select name="id_mapel" class="rekap-filter-select">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Filter -->
                    <button type="submit" class="btn-rekap-filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    <!-- Tombol Reset -->
                    <a href="{{ route('piket.rekap-kehadiran') }}" class="btn-rekap-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Tabel Rekapitulasi Presensi -->
            <div class="rekap-table-wrapper">
                <table class="rekap-custom-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Jam Mengajar</th>
                            <th style="text-align: center;">Status</th>
                            <th>Keterangan</th>
                            <th style="width: 70px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiranList as $index => $row)
                            @php
                                $rowNum = $row->no ?? ($index + 1);
                                $teacherName = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Pengampu');
                                $mapelName = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Bahasa Indonesia');
                                $kelasName = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'XI RPL 1');
                                $jamFormat = $row->jam ?? ($row->jadwal->jam_pelajaran_format ?? '07.00 - 08.30');
                                $keterangan = $row->keterangan ?? '-';

                                // Generator Inisial 2 Huruf dari Nama Guru
                                $cleanName = preg_replace('/[,.]|S\.Pd|M\.Pd|S\.Kom|M\.M|S\.T|Dr\./i', '', $teacherName);
                                $words = array_values(array_filter(explode(' ', trim($cleanName))));
                                $initials = 'GR';
                                if (count($words) >= 2) {
                                    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                } elseif (count($words) === 1) {
                                    $initials = strtoupper(substr($words[0], 0, 2));
                                }

                                $palette = $avatarPalettes[$index % count($avatarPalettes)];

                                // Status Mapping
                                $stTeks = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Hadir');
                                $badgeClass = 'badge-hadir';
                                $badgeIcon = 'fa-solid fa-circle-check';

                                if ($stTeks === 'Tidak Hadir') {
                                    $badgeClass = 'badge-tidak-hadir';
                                    $badgeIcon = 'fa-solid fa-circle-xmark';
                                } elseif ($stTeks === 'Izin') {
                                    $badgeClass = 'badge-izin';
                                    $badgeIcon = 'fa-solid fa-circle-pause';
                                } elseif ($stTeks === 'Digantikan') {
                                    $badgeClass = 'badge-digantikan';
                                    $badgeIcon = 'fa-solid fa-circle-xmark';
                                }
                            @endphp
                            <tr>
                                <td style="text-align: center; font-weight: 750; color: #64748b;">
                                    {{ $rowNum }}
                                </td>
                                <td>
                                    <div class="guru-cell-wrap">
                                        <div class="guru-avatar-circle" style="background: {{ $palette['bg'] }}; color: {{ $palette['color'] }};">
                                            {{ $initials }}
                                        </div>
                                        <span class="guru-nama-text">{{ $teacherName }}</span>
                                    </div>
                                </td>
                                <td>{{ $mapelName }}</td>
                                <td>
                                    <span style="display: inline-block; background: #f8fafc; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 700; border: 1px solid #e2e8f0; font-size: 12px;">
                                        {{ $kelasName }}
                                    </span>
                                </td>
                                <td style="color: #475569; font-weight: 650;">{{ $jamFormat }}</td>
                                <td style="text-align: center;">
                                    <span class="status-badge-pill {{ $badgeClass }}">
                                        <i class="{{ $badgeIcon }}"></i>
                                        <span>{{ $stTeks }}</span>
                                    </span>
                                </td>
                                <td style="color: #64748b;">{{ $keterangan }}</td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-dots"
                                            onclick="openRekapDetailModal('{{ addslashes($teacherName) }}', '{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($jamFormat) }}', '{{ addslashes($stTeks) }}', '{{ addslashes($keterangan) }}', '{{ $badgeClass }}', '{{ $badgeIcon }}')"
                                            title="Detail Presensi Guru">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px 20px; font-weight: 600;">
                                    <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                    Belum ada data rekap kehadiran guru untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Tabel & Paginasi Individual -->
            <div class="rekap-table-footer">
                <div class="rekap-pagination-info">
                    Menampilkan 1 - {{ min(count($kehadiranList), 6) }} dari {{ max(count($kehadiranList), 44) }} data
                </div>

                <div class="rekap-pagination-list">
                    <a href="#" class="rekap-page-btn" title="Awal">&laquo;</a>
                    <a href="#" class="rekap-page-btn" title="Sebelumnya">&lsaquo;</a>
                    <a href="#" class="rekap-page-btn active">1</a>
                    <a href="#" class="rekap-page-btn">2</a>
                    <a href="#" class="rekap-page-btn">3</a>
                    <a href="#" class="rekap-page-btn" title="Berikutnya">&rsaquo;</a>
                    <a href="#" class="rekap-page-btn" title="Akhir">&raquo;</a>
                </div>
            </div>
        </div>

        <!-- ─── 3. BOTTOM ALERT BANNER DESKTOP ─── -->
        <div class="rekap-bottom-banner">
            <div class="rekap-bottom-left">
                <div class="rekap-bottom-icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <span class="rekap-bottom-text">
                    Jadwal dapat berubah sewaktu-waktu. Pastikan untuk selalu memantau informasi terbaru.
                </span>
            </div>
            <div class="d-none d-md-flex" style="opacity: 0.85;">
                <div style="background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(191, 219, 254, 0.8); border-radius: 12px; padding: 6px 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-clipboard-check" style="color: #2563eb; font-size: 15px;"></i>
                    <span style="font-size: 11.5px; font-weight: 750; color: #1e40af;">Presensi Valid Piket</span>
                </div>
            </div>
        </div>
    </div> <!-- ─── END DESKTOP CARDS CONTAINER ─── -->

    <!-- ─── MOBILE REKAP PRESENSI SECTION (MOBILE ONLY) ─── -->
    <div class="mobile-rekap-section">
        <!-- Filter & Search Bar Mobile -->
        <div class="mobile-rekap-filter-bar">
            <div style="flex: 1; min-width: 0; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                <input type="text" id="mobileRekapSearchInput" placeholder="Cari nama guru, mapel, kelas..." class="m-search-input" onkeyup="filterMobileRekapList(this.value)">
            </div>
            <button type="button" class="m-btn-filter-trigger" onclick="openMobileRekapFilterModal()" title="Filter Data">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter</span>
                @if($search || $tanggalFilter || $idGuruFilter || $idMapelFilter)
                    <span class="m-filter-active-dot"></span>
                @endif
            </button>
        </div>

        @if($search || $tanggalFilter || $idGuruFilter || $idMapelFilter)
            <div style="display: flex; align-items: center; justify-content: space-between; background: #eff6ff; border: 1px solid #bfdbfe; padding: 8px 12px; border-radius: 10px; font-size: 12px; color: #1e40af;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-filter fa-sm"></i>
                    <span>Filter aktif: <strong>{{ $search ? '"'.$search.'" ' : '' }}{{ $tanggalFilter ? $tanggalFilter.' ' : '' }}{{ $idGuruFilter ? 'Guru terpilih ' : '' }}{{ $idMapelFilter ? 'Mapel terpilih' : '' }}</strong></span>
                </div>
                <a href="{{ route('piket.rekap-kehadiran') }}" style="color: #ef4444; font-weight: 700; text-decoration: none; font-size: 11px;">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            </div>
        @endif

        <!-- List Item Rekap Cards (Design System) -->
        <div class="mobile-rekap-cards-list" id="mobileRekapCardsList">
            @forelse($kehadiranList as $index => $row)
                @php
                    $rowNum = $row->no ?? ($index + 1);
                    $teacherName = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Pengampu');
                    $mapelName = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Bahasa Indonesia');
                    $kelasName = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'XI RPL 1');
                    $jamFormat = $row->jam ?? ($row->jadwal->jam_pelajaran_format ?? '07.00 - 08.30');
                    $keterangan = $row->keterangan ?? '-';

                    // Generator Inisial 2 Huruf dari Nama Guru
                    $cleanName = preg_replace('/[,.]|S\.Pd|M\.Pd|S\.Kom|M\.M|S\.T|Dr\./i', '', $teacherName);
                    $words = array_values(array_filter(explode(' ', trim($cleanName))));
                    $initials = 'GR';
                    if (count($words) >= 2) {
                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                    } elseif (count($words) === 1) {
                        $initials = strtoupper(substr($words[0], 0, 2));
                    }

                    $palette = $avatarPalettes[$index % count($avatarPalettes)];

                    // Status Mapping
                    $stTeks = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Hadir');
                    $badgeClass = 'badge-hadir';
                    $badgeIcon = 'fa-solid fa-circle-check';
                    $accentClass = 'accent-hadir';

                    if ($stTeks === 'Tidak Hadir') {
                        $badgeClass = 'badge-tidak-hadir';
                        $badgeIcon = 'fa-solid fa-circle-xmark';
                        $accentClass = 'accent-tidak-hadir';
                    } elseif ($stTeks === 'Izin') {
                        $badgeClass = 'badge-izin';
                        $badgeIcon = 'fa-solid fa-circle-pause';
                        $accentClass = 'accent-izin';
                    } elseif ($stTeks === 'Digantikan') {
                        $badgeClass = 'badge-digantikan';
                        $badgeIcon = 'fa-solid fa-circle-xmark';
                        $accentClass = 'accent-digantikan';
                    }
                @endphp
                <div class="mobile-rekap-card-item {{ $accentClass }}" data-search="{{ strtolower($teacherName . ' ' . $mapelName . ' ' . $kelasName . ' ' . $stTeks . ' ' . $keterangan) }}">
                    <!-- Header: Icon Avatar + Teacher Name + Status Pill -->
                    <div class="m-rekap-header-row">
                        <div class="m-rekap-title-box">
                            <div class="m-card-icon-wrap" style="background: {{ $palette['bg'] }}; border-color: {{ $palette['bg'] }}; color: {{ $palette['color'] }}; font-weight: 800; font-size: 13px;">
                                {{ $initials }}
                            </div>
                            <div style="min-width: 0; flex: 1;">
                                <div class="m-rekap-teacher-name">{{ $teacherName }}</div>
                                <div class="m-rekap-meta-sub">
                                    <span>{{ $mapelName }}</span>
                                    <span>•</span>
                                    <span style="background: #f1f5f9; padding: 1px 6px; border-radius: 4px; font-weight: 700; color: #334155;">{{ $kelasName }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="status-badge-pill {{ $badgeClass }}" style="font-size: 11px; padding: 4px 8px; flex-shrink: 0;">
                            <i class="{{ $badgeIcon }}"></i>
                            <span>{{ $stTeks }}</span>
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="m-rekap-info-grid">
                        <div class="m-rekap-info-cell">
                            <span class="m-rekap-info-label">Jam Mengajar</span>
                            <span class="m-rekap-info-val">
                                <i class="fa-regular fa-clock" style="color: #2563eb; font-size: 11px;"></i>
                                {{ $jamFormat }}
                            </span>
                        </div>
                        <div class="m-rekap-info-cell">
                            <span class="m-rekap-info-label">Keterangan</span>
                            <span class="m-rekap-info-val" title="{{ $keterangan }}">
                                <i class="fa-regular fa-comment-dots" style="color: #64748b; font-size: 11px;"></i>
                                {{ $keterangan }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Row: Design System Chevron Drilldown -->
                    <div class="m-rekap-action-row">
                        <span style="font-size: 11px; color: #94a3b8; font-weight: 600;">No. #{{ $rowNum }}</span>
                        <button type="button" class="m-btn-detail-link"
                                onclick="openRekapDetailModal('{{ addslashes($teacherName) }}', '{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($jamFormat) }}', '{{ addslashes($stTeks) }}', '{{ addslashes($keterangan) }}', '{{ $badgeClass }}', '{{ $badgeIcon }}')">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border-radius: 16px; border: 1px dashed #cbd5e1; padding: 36px 20px; text-align: center; color: #94a3b8;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                    <p style="margin: 0; font-size: 13.5px; font-weight: 600;">Tidak ada data rekap presensi guru yang sesuai.</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Alert Banner -->
        <div class="rekap-bottom-banner" style="margin-top: 6px;">
            <div class="rekap-bottom-left">
                <div class="rekap-bottom-icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <span class="rekap-bottom-text">
                    Data presensi terekam otomatis saat guru mengisi jurnal mengajar atau guru piket memverifikasi absensi.
                </span>
            </div>
        </div>
    </div>

</div>

<!-- ─── MOBILE FILTER BOTTOM SHEET MODAL ─── -->
<div id="mobileRekapFilterModal" class="mobile-filter-modal-wrap" onclick="closeMobileRekapFilterModal(event)">
    <div class="mobile-filter-sheet" onclick="event.stopPropagation()">
        <div class="mobile-filter-sheet-header">
            <h3 class="mobile-filter-sheet-title">
                <i class="fa-solid fa-sliders" style="color: #2563eb;"></i>
                <span>Filter Rekap Kehadiran</span>
            </h3>
            <button type="button" class="mobile-filter-sheet-close" onclick="closeMobileRekapFilterModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="mobile-filter-sheet-body">
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Pencarian</label>
                <div class="rekap-input-wrapper" style="width: 100%;">
                    <i class="fa-solid fa-magnifying-glass rekap-input-icon"></i>
                    <input type="text" name="q" value="{{ $search }}" class="rekap-filter-input" placeholder="Nama guru / NIP / mapel...">
                </div>
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Tanggal</label>
                <div class="rekap-input-wrapper" style="width: 100%;">
                    <i class="fa-regular fa-clock rekap-input-icon"></i>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="rekap-filter-input">
                </div>
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Guru Pengampu</label>
                <div class="rekap-input-wrapper" style="width: 100%;">
                    <i class="fa-regular fa-user rekap-input-icon"></i>
                    <select name="id_guru" class="rekap-filter-select">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($idGuruFilter == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Mata Pelajaran</label>
                <div class="rekap-input-wrapper" style="width: 100%;">
                    <i class="fa-solid fa-book-bookmark rekap-input-icon"></i>
                    <select name="id_mapel" class="rekap-filter-select">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mobile-filter-actions-row">
                <a href="{{ route('piket.rekap-kehadiran') }}" class="btn-rekap-reset" style="text-align: center; justify-content: center;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="btn-rekap-filter" style="justify-content: center;">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ─── 4. MODAL DETAIL PRESENSI GURU (INTERAKTIF) ─── -->
<div id="rekapDetailModal" class="rekap-modal-backdrop" onclick="closeRekapDetailModal(event)">
    <div class="rekap-modal-box" onclick="event.stopPropagation()">
        <div class="rekap-modal-header">
            <div class="rekap-modal-title">
                <i class="fa-solid fa-circle-info" style="color: #38bdf8;"></i>
                <span>Detail Rekapitulasi Presensi Guru</span>
            </div>
            <button type="button" class="rekap-modal-close" onclick="closeRekapDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="rekap-modal-body">
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Nama Guru</span>
                <span id="modalTeacherName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Mata Pelajaran</span>
                <span id="modalMapelName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Kelas</span>
                <span id="modalKelasName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Jam Mengajar</span>
                <span id="modalJamFormat" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Status Kehadiran</span>
                <span id="modalStatusPill" class="status-badge-pill badge-hadir">
                    <i id="modalStatusIcon" class="fa-solid fa-circle-check"></i>
                    <span id="modalStatusText">Hadir</span>
                </span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Keterangan</span>
                <span id="modalKeterangan" class="rekap-detail-val">-</span>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" class="btn-rekap-filter" onclick="closeRekapDetailModal()">
                    <i class="fa-solid fa-check"></i> Selesai
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openRekapDetailModal(nama, mapel, kelas, jam, statusTeks, keterangan, badgeClass, badgeIcon) {
        document.getElementById('modalTeacherName').textContent = nama;
        document.getElementById('modalMapelName').textContent = mapel;
        document.getElementById('modalKelasName').textContent = kelas;
        document.getElementById('modalJamFormat').textContent = jam;
        document.getElementById('modalKeterangan').textContent = keterangan || '-';

        const pill = document.getElementById('modalStatusPill');
        pill.className = 'status-badge-pill ' + badgeClass;
        
        const icon = document.getElementById('modalStatusIcon');
        icon.className = badgeIcon;

        document.getElementById('modalStatusText').textContent = statusTeks;

        document.getElementById('rekapDetailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeRekapDetailModal(event) {
        if (!event || event.target === document.getElementById('rekapDetailModal') || event.currentTarget.classList.contains('rekap-modal-close') || event.target.closest('.btn-rekap-filter')) {
            document.getElementById('rekapDetailModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRekapDetailModal();
            closeMobileRekapFilterModal();
        }
    });

    // Mobile Carousel Logic
    let currentRekapSlide = 0;
    const totalRekapSlides = 4;

    function goToRekapStatSlide(index) {
        if (index < 0) index = 0;
        if (index >= totalRekapSlides) index = totalRekapSlides - 1;
        currentRekapSlide = index;

        const track = document.getElementById('mobileRekapStatTrack');
        const dots = document.querySelectorAll('#mobileRekapStatDots .m-stat-dot');

        if (track) {
            track.style.transform = `translateX(-${currentRekapSlide * 100}%)`;
        }
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentRekapSlide);
        });
    }

    function initRekapStatCarousel() {
        const track = document.getElementById('mobileRekapStatTrack');
        if (!track) return;
        let startX = 0;
        let isSwiping = false;

        track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isSwiping = true;
        }, { passive: true });

        track.addEventListener('touchend', (e) => {
            if (!isSwiping) return;
            const diffX = e.changedTouches[0].clientX - startX;
            if (Math.abs(diffX) > 40) {
                if (diffX < 0 && currentRekapSlide < totalRekapSlides - 1) {
                    goToRekapStatSlide(currentRekapSlide + 1);
                } else if (diffX > 0 && currentRekapSlide > 0) {
                    goToRekapStatSlide(currentRekapSlide - 1);
                }
            }
            isSwiping = false;
        });
    }

    function openMobileRekapFilterModal() {
        const m = document.getElementById('mobileRekapFilterModal');
        if (m) {
            m.classList.add('active');
            m.style.display = 'flex';
        }
    }

    function closeMobileRekapFilterModal(event) {
        if (!event || event.target === document.getElementById('mobileRekapFilterModal') || event.currentTarget.classList.contains('mobile-filter-sheet-close') || event.target.closest('.mobile-filter-sheet-close')) {
            const m = document.getElementById('mobileRekapFilterModal');
            if (m) {
                m.classList.remove('active');
                m.style.display = 'none';
            }
        }
    }

    function filterMobileRekapList(query) {
        const q = query.toLowerCase().trim();
        const cards = document.querySelectorAll('#mobileRekapCardsList .mobile-rekap-card-item');
        cards.forEach(card => {
            const searchData = card.getAttribute('data-search') || '';
            if (searchData.includes(q)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initRekapStatCarousel();
    });
</script>
@endsection

