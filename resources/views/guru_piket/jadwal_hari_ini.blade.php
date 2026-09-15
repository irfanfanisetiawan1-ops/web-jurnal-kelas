@extends('layouts.guru')

@section('title', 'Jadwal Hari Ini — Guru Piket')
@section('header_title', 'Jadwal Hari Ini')

@section('styles')
<style>
<<<<<<< HEAD
    /* Main Layout & Colors (Abu-abu, Biru, Putih, Abu-abu Muda Cerah) */
    .jadwal-hari-ini-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 4px;
    }

    .page-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-group p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        font-weight: 600;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
=======
    /* ─── Global Scoped Styles untuk Jadwal Hari Ini ─── */
    .jadwal-page-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    /* ─── 1. Top 4 Stat Cards (Tanpa Chevron / Panah) ─── */
    .jadwal-stats-grid {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    @media (max-width: 1024px) {
        .jadwal-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .jadwal-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .jadwal-stat-card {
        background: #ffffff;
<<<<<<< HEAD
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .stat-icon-wrapper {
=======
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .jadwal-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    /* Gradient subtle tint di bagian bawah kartu */
    .jadwal-stat-card.blue {
        background: linear-gradient(180deg, #ffffff 0%, #f0f7ff 100%);
    }
    .jadwal-stat-card.green {
        background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    }
    .jadwal-stat-card.orange {
        background: linear-gradient(180deg, #ffffff 0%, #fffbf0 100%);
    }
    .jadwal-stat-card.purple {
        background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
    }

    .jadwal-stat-icon {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

<<<<<<< HEAD
    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-slate  { background: #f1f5f9; color: #475569; }
=======
    .jadwal-stat-icon.blue   { background: #dbeafe; color: #2563eb; }
    .jadwal-stat-icon.green  { background: #d1fae5; color: #059669; }
    .jadwal-stat-icon.orange { background: #ffedd5; color: #ea580c; }
    .jadwal-stat-icon.purple { background: #ede9fe; color: #7c3aed; }
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

    .jadwal-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .jadwal-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
<<<<<<< HEAD
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .stat-subtext {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 3px;
    }

    /* Main Grid Layout: Left Schedule List + Right Widgets */
    .main-grid-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 22px;
        align-items: start;
    }

    /* Left Schedule Panel */
    .schedule-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .panel-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .panel-title-custom {
=======
        letter-spacing: -0.01em;
    }

    .jadwal-stat-number {
        font-size: 26px;
        font-weight: 850;
        color: #1e293b;
        line-height: 1.15;
        margin: 3px 0 1px 0;
        letter-spacing: -0.02em;
    }

    .jadwal-stat-sub {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* ─── 2. Container Card Universal ─── */
    .jadwal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .jadwal-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
    }

    .jadwal-card-title {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16.5px;
        font-weight: 800;
<<<<<<< HEAD
        color: #0f172a;
    }

    /* Filter Form Styling */
    .filter-box-compact {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
    }

    .filter-grid-compact {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-ctrl {
        flex: 1;
        min-width: 140px;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
=======
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .jadwal-card-title i {
        color: #2b3957;
        font-size: 18px;
    }

    .btn-header-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 6px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-header-pill:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    /* ─── 3. Filter Bar (Daftar Jadwal Hari Ini) ─── */
    .jadwal-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        border-radius: 14px;
    }

    .jadwal-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .jadwal-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        font-size: 13px;
        pointer-events: none;
    }

    .jadwal-filter-input {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 36px;
        font-size: 13px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
<<<<<<< HEAD
    }

    .filter-ctrl:focus {
=======
        height: 40px;
    }

    .jadwal-filter-input:focus {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

<<<<<<< HEAD
    .btn-filter-dark {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-filter-dark:hover {
        background: #1e293b;
    }

    .btn-reset-light {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-reset-light:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Schedule Card List */
    .schedule-card-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
=======
    .jadwal-filter-select {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 36px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        min-width: 170px;
        height: 40px;
    }

    .jadwal-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .jadwal-btn-filter {
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 9px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .jadwal-btn-filter:hover {
        background: #0f172a;
    }

    .jadwal-btn-reset {
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
        height: 40px;
        transition: all 0.2s ease;
    }

    .jadwal-btn-reset:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* ─── 4. List Item Jadwal Pelajaran ─── */
    .schedule-items-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .schedule-item-row {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
<<<<<<< HEAD
        padding: 15px 18px;
=======
        padding: 16px 20px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
<<<<<<< HEAD
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
=======
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .schedule-item-row:hover {
        transform: translateY(-2px);
<<<<<<< HEAD
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
=======
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    /* Accent Border-Left Berwarna */
    .schedule-item-row.accent-green {
        border-left: 4.5px solid #10b981;
    }
    .schedule-item-row.accent-orange {
        border-left: 4.5px solid #f59e0b;
    }
    .schedule-item-row.accent-purple {
        border-left: 4.5px solid #8b5cf6;
    }
    .schedule-item-row.accent-blue {
        border-left: 4.5px solid #3b82f6;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .schedule-time-box {
        display: flex;
        flex-direction: column;
<<<<<<< HEAD
        min-width: 105px;
        flex-shrink: 0;
    }

    .time-badge-jam {
        font-size: 11px;
        font-weight: 800;
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        padding: 2px 7px;
        border-radius: 6px;
        display: inline-block;
        width: fit-content;
        margin-bottom: 3px;
    }

    .time-clock-range {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
=======
        min-width: 90px;
        flex-shrink: 0;
    }

    .schedule-time-start {
        font-size: 16px;
        font-weight: 850;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .schedule-time-end {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-top: 1px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .schedule-info-box {
        display: flex;
        flex-direction: column;
        flex: 1;
<<<<<<< HEAD
        padding: 0 10px;
=======
        min-width: 0;
        padding: 0 8px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .schedule-subject {
        font-size: 15px;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.01em;
    }

    .schedule-class-room {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .schedule-teacher {
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .schedule-teacher i {
        color: #64748b;
        font-size: 11.5px;
    }

    .schedule-right-status {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .schedule-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .schedule-status-badge .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }

    .schedule-status-badge.badge-green {
        background: #dcfce7;
        color: #15803d;
    }
    .schedule-status-badge.badge-green .status-dot {
        background: #16a34a;
    }

    .schedule-status-badge.badge-orange {
        background: #fef3c7;
        color: #b45309;
    }
    .schedule-status-badge.badge-orange .status-dot {
        background: #d97706;
    }

    .schedule-status-badge.badge-purple {
        background: #ede9fe;
        color: #6d28d9;
    }
    .schedule-status-badge.badge-purple .status-dot {
        background: #7c3aed;
    }

    .schedule-status-badge.badge-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .schedule-status-badge.badge-blue .status-dot {
        background: #2563eb;
    }

    .schedule-chevron {
        color: #94a3b8;
        font-size: 13px;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .schedule-item-row:hover .schedule-chevron {
        color: #2563eb;
        transform: translateX(2px);
    }

    /* Tombol Tautan Bawah "Lihat Semua Jadwal" */
    .jadwal-bottom-link-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        text-align: center;
        transition: all 0.2s ease;
        margin-top: 4px;
    }

    .jadwal-bottom-link-box:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .jadwal-see-all-link {
        font-size: 13.5px;
        font-weight: 750;
        color: #2563eb;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.2s ease;
    }

    .jadwal-see-all-link:hover {
        gap: 12px;
        color: #1d4ed8;
    }

    /* ─── 5. Tabel "Ringkasan per Kelas" ─── */
    .ringkasan-table-container {
        overflow-x: auto;
        margin-top: 4px;
    }

    .ringkasan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13.5px;
    }

    .ringkasan-table thead tr {
        background: #fff7ed; /* Warm peach / cream */
    }

    .ringkasan-table th {
        padding: 12px 16px;
        font-weight: 750;
        color: #475569;
        text-align: center;
        border: none;
        font-size: 12.5px;
    }

    .ringkasan-table th:first-child {
        text-align: left;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        padding-left: 20px;
    }

    .ringkasan-table th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding-right: 20px;
    }

    .ringkasan-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        text-align: center;
        font-weight: 600;
        color: #334155;
    }

    .ringkasan-table td:first-child {
        text-align: left;
        font-weight: 800;
<<<<<<< HEAD
        color: #0f172a;
        line-height: 1.3;
=======
        color: #1e293b;
        padding-left: 20px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .ringkasan-table td:last-child {
        padding-right: 20px;
    }

    .ringkasan-table tr:last-child td {
        border-bottom: none;
    }

    .dot-indicator {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        margin-right: 6px;
        vertical-align: middle;
    }

    .val-sedang { color: #059669; font-weight: 750; }
    .val-selesai { color: #2563eb; font-weight: 750; }
    .val-belum { color: #7c3aed; font-weight: 750; }

    /* ─── 6. Card "Informasi Guru Pengganti Hari Ini" ─── */
    .gp-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .gp-info-grid {
            grid-template-columns: 1fr;
        }
    }

    .gp-info-card {
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .gp-info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .gp-card-red {
        background: linear-gradient(180deg, #fffafa 0%, #ffffff 100%);
        border: 1px solid #fecaca;
    }
    .gp-card-red:hover {
        border-color: #fca5a5;
    }

    .gp-card-blue {
        background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
        border: 1px solid #bfdbfe;
    }
    .gp-card-blue:hover {
        border-color: #93c5fd;
    }

    .gp-info-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .gp-info-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .gp-icon-red { background: #fee2e2; color: #ef4444; }
    .gp-icon-blue { background: #dbeafe; color: #2563eb; }

    .gp-info-title {
        font-size: 14.5px;
        font-weight: 850;
        letter-spacing: -0.01em;
    }

    .gp-card-red .gp-info-title { color: #dc2626; }
    .gp-card-blue .gp-info-title { color: #2563eb; }

    .gp-info-subtext {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

<<<<<<< HEAD
    .teacher-name-box {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .schedule-status-box {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Badges Status KBM */
    .badge-status-kbm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-sedang-berlangsung {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
    }

    .badge-sudah-selesai {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .badge-belum-dimulai {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-jurnal-terisi {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #16a34a;
        box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
        animation: pulseAnimation 1.6s infinite;
    }

    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    /* Right Column Widgets */
    .right-widgets-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .widget-panel-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .widget-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
=======
    .gp-info-chevron {
        color: #cbd5e1;
        font-size: 14px;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .gp-info-card:hover .gp-info-chevron {
        transform: translateX(3px);
    }

    .gp-card-red:hover .gp-info-chevron { color: #dc2626; }
    .gp-card-blue:hover .gp-info-chevron { color: #2563eb; }

    /* ─── 7. Bottom Alert Banner ─── */
    .jadwal-bottom-banner {
        background: linear-gradient(90deg, #eff6ff 0%, #f0fdf4 100%);
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .jadwal-bottom-left {
        display: flex;
        align-items: center;
<<<<<<< HEAD
        gap: 8px;
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .class-summary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
    }

    .class-summary-table th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        padding: 10px 10px;
        text-align: center;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .class-summary-table th:first-child { text-align: left; border-left: 1px solid #e2e8f0; border-radius: 8px 0 0 8px; }
    .class-summary-table th:last-child { border-right: 1px solid #e2e8f0; border-radius: 0 8px 8px 0; }

    .class-summary-table td {
        padding: 10px 10px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        color: #334155;
        text-align: center;
    }

    .class-summary-table tr:hover td {
        background: #f8fafc;
    }

    .class-summary-table td:first-child { text-align: left; font-weight: 800; color: #0f172a; }

    .val-sedang { color: #16a34a; }
    .val-selesai { color: #475569; }
    .val-belum { color: #2563eb; }

    /* Info Guru Pengganti Widget Items */
    .info-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .info-item-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateX(2px);
    }

    .info-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-item-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-icon-red { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .info-icon-blue { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
=======
        gap: 14px;
        z-index: 2;
    }

    .jadwal-bottom-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2563eb;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .jadwal-bottom-text {
        font-size: 13.5px;
        font-weight: 650;
        color: #1e40af;
        letter-spacing: -0.01em;
    }
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

    .jadwal-bottom-decor {
        display: flex;
        align-items: center;
        gap: 8px;
        opacity: 0.85;
        z-index: 1;
    }

    /* ─── 8. Modal Detail Jadwal ─── */
    .jadwal-modal-backdrop {
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

    .jadwal-modal-backdrop.active {
        display: flex;
    }

    .jadwal-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: jadwalModalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes jadwalModalIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .jadwal-modal-header {
        background: #1e293b;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .jadwal-modal-title {
        font-size: 15px;
        font-weight: 800;
<<<<<<< HEAD
        color: #0f172a;
    }

    .info-item-subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    .alert-banner-custom {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-styled {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        border-radius: 20px 20px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Custom Pagination Styling */
    .custom-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .page-nav-btn, .page-num-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .page-nav-btn:hover, .page-num-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .page-num-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .page-nav-btn.disabled {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #e2e8f0;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .page-num-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 38px;
        color: #94a3b8;
        font-weight: 700;
        font-size: 14px;
    }

    /* Force constraint on any stray SVG icons in page */
    .schedule-panel svg,
    .jadwal-hari-ini-container svg {
        max-width: 24px !important;
        max-height: 24px !important;
=======
        display: flex;
        align-items: center;
        gap: 10px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    .jadwal-modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 4px;
        line-height: 1;
    }

    .jadwal-modal-close:hover {
        color: #ffffff;
    }

    .jadwal-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .jadwal-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .jadwal-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .jadwal-detail-label {
        font-weight: 650;
        color: #64748b;
    }

    .jadwal-detail-val {
        font-weight: 800;
        color: #1e293b;
        text-align: right;
    }

    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .mobile-page-topbar,
    .mobile-jadwal-stat-carousel-wrap,
    .mobile-jadwal-section,
    #mobileJadwalFilterModal {
        display: none !important;
    }

    @media (max-width: 768px) {
<<<<<<< HEAD
        .stat-grid-4 { grid-template-columns: 1fr; }
        .filter-grid-compact { flex-direction: column; align-items: stretch; }
        .schedule-item-card { flex-direction: column; align-items: flex-start; }
        .schedule-status-box { align-items: flex-start; width: 100%; }
=======
        .jadwal-desktop-stats,
        .jadwal-desktop-card {
            display: none !important;
        }

        .mobile-page-topbar,
        .mobile-jadwal-stat-carousel-wrap,
        .mobile-jadwal-section {
            display: flex !important;
        }

        #mobileJadwalFilterModal.active {
            display: flex !important;
        }

        .jadwal-page-container {
            padding-bottom: 28px;
            gap: 14px;
        }

        /* Topbar */
        .mobile-page-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 16px;
            margin-bottom: 2px;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.04);
        }

        .mobile-back-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 15px;
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
            font-size: 16px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .mobile-topbar-sub {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-badge-date-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Carousel Stat */
        .mobile-jadwal-stat-carousel-wrap {
            position: relative;
            width: 100%;
            flex-direction: column;
            gap: 10px;
        }

        .mobile-jadwal-stat-viewport {
            width: 100%;
            overflow: hidden;
            border-radius: 18px;
            touch-action: pan-y;
        }

        .mobile-jadwal-stat-track {
            display: flex;
            transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }

        .mobile-jadwal-stat-slide {
            min-width: 100%;
            flex-shrink: 0;
            box-sizing: border-box;
        }

        .mobile-jadwal-stat-dots {
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

        /* Mobile Schedule Section */
        .mobile-jadwal-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .mobile-jadwal-filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .m-search-input {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 12px 0 34px !important;
            font-size: 12.5px;
            color: #1e293b;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
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

        /* Mobile Schedule Cards List */
        .mobile-jadwal-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .mobile-jadwal-card-item {
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
        }

        .mobile-jadwal-card-item.accent-green {
            border-left-color: #10b981;
        }
        .mobile-jadwal-card-item.accent-orange {
            border-left-color: #f59e0b;
        }
        .mobile-jadwal-card-item.accent-purple {
            border-left-color: #8b5cf6;
        }
        .mobile-jadwal-card-item.accent-blue {
            border-left-color: #3b82f6;
        }

        .m-jadwal-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .m-jadwal-title-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .m-jadwal-mapel-name {
            font-size: 14.5px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-jadwal-meta-sub {
            font-size: 11.5px;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .m-jadwal-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .m-jadwal-info-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .m-jadwal-info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.02em;
        }

        .m-jadwal-info-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-jadwal-action-row {
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

        /* Ringkasan Kelas Horizontal Scroll on Mobile */
        .mobile-ringkasan-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 6px;
            scrollbar-width: thin;
        }

        .mobile-ringkasan-pill {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 14px;
            min-width: 140px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            gap: 4px;
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
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }
</style>
@endsection

@section('content')
<<<<<<< HEAD

@php
    $cDate = \Carbon\Carbon::parse($tanggalFilter);
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $dateTitleFormatted = $hariFilter . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
@endphp

<div class="jadwal-hari-ini-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jadwal Pelajaran Hari Ini</h1>
            <p>{{ $dateTitleFormatted }} &nbsp;•&nbsp; Monitoring seluruh sesi KBM dan pemetaan ruang kelas</p>
        </div>

        <div>
            <a href="{{ route('piket.jurnal-mengajar', ['tanggal' => $tanggalFilter]) }}" class="btn-filter-dark" style="text-decoration: none; padding: 10px 18px; border-radius: 12px; font-size: 13px;">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>Lihat Jurnal Mengajar</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards Dinamis dari Database) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-val">{{ $stats['totalJadwal'] }} Sesi</span>
                <span class="stat-subtext">Jadwal hari {{ $hariFilter }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sedang Berlangsung</span>
                <span class="stat-val">{{ $stats['sedangBerlangsung'] }} Sesi</span>
                <span class="stat-subtext">KBM aktif sekarang</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-amber">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Sudah Selesai</span>
                <span class="stat-val">{{ $stats['sudahSelesai'] }} Sesi</span>
                <span class="stat-subtext">Jam pelajaran terlewati</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-slate">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Dimulai</span>
                <span class="stat-val">{{ $stats['belumDimulai'] }} Sesi</span>
                <span class="stat-subtext">Jadwal sesi mendatang</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Grid Layout (2 Columns: Left Schedule List + Right Widgets) -->
    <div class="main-grid-layout">

        <!-- Left Panel: Daftar Jadwal Hari Ini -->
        <div class="schedule-panel">
            <div class="panel-header-custom">
                <div class="panel-title-custom">
                    <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i>
                    <span>Daftar Sesi Jadwal ({{ $hariFilter }})</span>
                    <span style="font-size: 12px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 12px; font-weight: 700;">
                        {{ $jadwals->total() }} Sesi
                    </span>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="filter-box-compact">
                <form action="{{ route('piket.jadwal') }}" method="GET" class="filter-grid-compact">
                    <div>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-ctrl" title="Filter Tanggal KBM" onchange="this.form.submit()">
                    </div>

                    <div>
                        <select name="id_kelas" class="filter-ctrl" onchange="this.form.submit()">
                            <option value="">🎓 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_mapel" class="filter-ctrl" onchange="this.form.submit()">
                            <option value="">📖 Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="flex: 1.5; min-width: 160px;">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari guru / mapel / kelas..." class="filter-ctrl" style="width: 100%;">
                    </div>

                    <button type="submit" class="btn-filter-dark">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    @if($idKelasFilter || $idMapelFilter || $idGuruFilter || $search || $tanggalFilter !== \Carbon\Carbon::now('Asia/Jakarta')->toDateString())
                        <a href="{{ route('piket.jadwal') }}" class="btn-reset-light">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Schedule Card List -->
            <div class="schedule-card-list">
                @forelse($jadwals as $row)
                    @php
                        $mulaiEffective = $row->waktu_mulai_effective;
                        $selesaiEffective = $row->waktu_selesai_effective;
                        $jamRange = $row->jam_range;
                        
                        // Perhitungan status sesi
                        if ($isPast) {
                            $statusKbm = 'selesai';
                        } elseif ($isFuture) {
                            $statusKbm = 'belum';
                        } else {
                            if ($currentTimeStr >= $selesaiEffective) {
                                $statusKbm = 'selesai';
                            } elseif ($currentTimeStr >= $mulaiEffective) {
                                $statusKbm = 'berlangsung';
                            } else {
                                $statusKbm = 'belum';
                            }
                        }

                        $hasJurnal = $row->jurnalMengajars->isNotEmpty();
                        $penugasanPengganti = $penugasanMap->get($row->id_jadwal);
                    @endphp

                    <div class="schedule-item-card">
                        <!-- Waktu KBM -->
                        <div class="schedule-time-box">
                            <span class="time-badge-jam">Jam Ke-{{ $jamRange }}</span>
                            <span class="time-clock-range">{{ $mulaiEffective }} - {{ $selesaiEffective }}</span>
                            <span style="font-size: 10px; color: #94a3b8; font-weight: 700;">WIB • {{ $row->jumlah_jp }} JP</span>
                        </div>

                        <!-- Informasi Mata Pelajaran & Kelas -->
                        <div class="schedule-info-box">
                            <span class="subject-title">{{ $row->mapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
                            <div class="class-room-info">
                                <span><i class="fa-solid fa-graduation-cap" style="color: #2563eb;"></i> {{ $row->kelas->nama_kelas ?? 'Kelas' }}</span>
                                <span>&bull;</span>
                                <span><i class="fa-solid fa-location-dot" style="color: #64748b;"></i> {{ $row->ruangan->nama_ruangan ?? 'Ruang Kelas' }}</span>
                            </div>

                            <div class="teacher-name-box">
                                @if($penugasanPengganti && $penugasanPengganti->guruPengganti)
                                    <span style="color: #0f172a; font-weight: 700;"><i class="fa-solid fa-user-shield" style="color: #d97706;"></i> {{ $penugasanPengganti->guruPengganti->nama_guru }}</span>
                                    <span style="font-size: 10.5px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 1px 6px; border-radius: 4px; font-weight: 700;">Guru Pengganti</span>
                                    <span style="font-size: 10.5px; color: #94a3b8;">(Utama: {{ $row->guru->nama_guru ?? '-' }})</span>
                                @else
                                    <span><i class="fa-solid fa-chalkboard-user" style="color: #475569;"></i> {{ $row->guru->nama_guru ?? 'Guru Pengampu' }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status KBM & Jurnal -->
                        <div class="schedule-status-box">
                            @if($statusKbm === 'berlangsung')
                                <span class="badge-status-kbm badge-sedang-berlangsung">
                                    <span class="pulse-dot"></span>
                                    Sedang Berlangsung
                                </span>
                            @elseif($statusKbm === 'selesai')
                                <span class="badge-status-kbm badge-sudah-selesai">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Sudah Selesai
                                </span>
                            @else
                                <span class="badge-status-kbm badge-belum-dimulai">
                                    <i class="fa-solid fa-clock"></i>
                                    Belum Dimulai
                                </span>
                            @endif

                            @if($hasJurnal)
                                <span class="badge-jurnal-terisi">
                                    <i class="fa-solid fa-file-circle-check"></i> Jurnal Terisi
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 40px 20px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                        Tidak ada sesi jadwal pelajaran yang sesuai dengan kriteria filter hari {{ $hariFilter }}.
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            @if ($jadwals->hasPages())
                <div class="custom-pagination-wrapper">
                    {{-- Previous Page Link --}}
                    @if ($jadwals->onFirstPage())
                        <span class="page-nav-btn disabled" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $jadwals->previousPageUrl() }}" class="page-nav-btn" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif

                    {{-- First Page & Leading Ellipsis --}}
                    @php
                        $start = max(1, $jadwals->currentPage() - 2);
                        $end = min($jadwals->lastPage(), $jadwals->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $jadwals->url(1) }}" class="page-num-btn">1</a>
                        @if ($start > 2)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $jadwals->currentPage())
                            <span class="page-num-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $jadwals->url($page) }}" class="page-num-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Trailing Ellipsis & Last Page --}}
                    @if ($end < $jadwals->lastPage())
                        @if ($end < $jadwals->lastPage() - 1)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                        <a href="{{ $jadwals->url($jadwals->lastPage()) }}" class="page-num-btn">{{ $jadwals->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($jadwals->hasMorePages())
                        <a href="{{ $jadwals->nextPageUrl() }}" class="page-nav-btn" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span class="page-nav-btn disabled" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
                <div style="text-align: center; font-size: 12px; color: #64748b; margin-top: 8px; font-weight: 600;">
                    Menampilkan {{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }} dari {{ $jadwals->total() }} jadwal
                </div>
            @endif
        </div>

        <!-- Right Column Widgets -->
        <div class="right-widgets-col">

            <!-- Right Widget 1: Ringkasan per Kelas -->
            <div class="widget-panel-box">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-users-viewfinder" style="color: #2563eb;"></i>
                        <span>Ringkasan per Kelas</span>
                    </div>
                    <button type="button" onclick="openClassSummaryModal()" class="btn-reset-light" style="padding: 4px 10px; font-size: 11px;">
                        Lihat Semua ({{ count($ringkasanPerKelas) }})
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table class="class-summary-table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Total</th>
                                <th>Sedang</th>
                                <th>Selesai</th>
                                <th>Belum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ringkasanPerKelas->take(6) as $rk)
                                <tr>
                                    <td>{{ $rk->nama_kelas }}</td>
                                    <td>{{ $rk->total }}</td>
                                    <td class="val-sedang">{{ $rk->sedang }}</td>
                                    <td class="val-selesai">{{ $rk->selesai }}</td>
                                    <td class="val-belum">{{ $rk->belum }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada data kelas aktif hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Widget 2: Informasi Guru Tidak Hadir & Pengganti Hari Ini -->
            <div class="widget-panel-box">
                <div class="widget-panel-header">
                    <div class="widget-panel-title">
                        <i class="fa-solid fa-user-gear" style="color: #2563eb;"></i>
                        <span>Informasi Guru Piket Hari Ini</span>
                    </div>
                    <a href="{{ route('piket.guru-pengganti') }}" class="btn-reset-light" style="padding: 4px 10px; font-size: 11px;">
                        Kelola
                    </a>
                </div>

                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="info-item-card">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-red">
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #dc2626;">{{ $guruTidakHadirCount }} Guru Izin / Tidak Hadir</div>
                            <div class="info-item-subtext">Lihat daftar surat izin guru hari ini</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 12px;"></i>
                </a>

                <a href="{{ route('piket.guru-pengganti') }}" class="info-item-card" style="margin-bottom: 0;">
                    <div class="info-item-left">
                        <div class="info-item-icon info-icon-blue">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                        <div>
                            <div class="info-item-title" style="color: #2563eb;">{{ $guruPenggantiCount }} Penugasan Guru Pengganti</div>
                            <div class="info-item-subtext">Kelola penugasan guru pengganti aktif</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 12px;"></i>
                </a>
            </div>

            <!-- Right Widget 3: Quick Alert Note -->
            <div class="alert-banner-custom">
                <i class="fa-solid fa-circle-info" style="color: #2563eb; font-size: 16px; flex-shrink: 0;"></i>
                <span>Alokasi jam KBM mengacu pada Master Jam Pelajaran TU (10 JP Senin–Kamis / 13 JP Jumat).</span>
            </div>

=======
@php
    // Perhitungan Real Data untuk Widget Guru Pengganti
    $todayDateStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();

    $realGuruTidakHadir = \App\Models\GuruIzin::whereDate('tanggal_mulai', '<=', $todayDateStr)
        ->whereDate('tanggal_selesai', '>=', $todayDateStr)
        ->count();
    if ($realGuruTidakHadir === 0) {
        $realGuruTidakHadir = \App\Models\GuruIzin::count();
    }
    if ($realGuruTidakHadir === 0) {
        $realGuruTidakHadir = 2; // Demo Fallback
    }

    $realPenugasanPengganti = \App\Models\PenugasanGuruPengganti::whereDate('tanggal', $todayDateStr)
        ->distinct('id_guru_pengganti')
        ->count('id_guru_pengganti');
    if ($realPenugasanPengganti === 0) {
        $realPenugasanPengganti = \App\Models\PenugasanGuruPengganti::count();
    }
    if ($realPenugasanPengganti === 0) {
        $realPenugasanPengganti = 2; // Demo Fallback
    }
@endphp

<div class="jadwal-page-container">

    <!-- ─── MOBILE TOPBAR (TITLE + DATE PILL) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Jadwal Hari Ini</h1>
            <span class="mobile-topbar-sub">Jadwal pelajaran & status KBM hari ini</span>
        </div>
        <div class="mobile-topbar-right">
            <span class="m-badge-date-pill">
                <i class="fa-regular fa-calendar"></i>
                <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d M') }}</span>
            </span>
        </div>
    </div>

    <!-- ─── MOBILE 4-STAT CAROUSEL (SWIPEABLE + 4 DOT INDICATORS) ─── -->
    <div class="mobile-jadwal-stat-carousel-wrap">
        <div class="mobile-jadwal-stat-viewport" id="mobileJadwalStatViewport">
            <div class="mobile-jadwal-stat-track" id="mobileJadwalStatTrack">
                <!-- Slide 1: Total Jadwal -->
                <div class="mobile-jadwal-stat-slide">
                    <div class="jadwal-stat-card blue" style="margin: 0;">
                        <div class="jadwal-stat-icon blue">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div class="jadwal-stat-info">
                            <span class="jadwal-stat-title">Total Jadwal</span>
                            <span class="jadwal-stat-number">{{ $stats['totalJadwal'] ?? 24 }}</span>
                            <span class="jadwal-stat-sub">semua jadwal KBM hari ini</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Sedang Berlangsung -->
                <div class="mobile-jadwal-stat-slide">
                    <div class="jadwal-stat-card green" style="margin: 0;">
                        <div class="jadwal-stat-icon green">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="jadwal-stat-info">
                            <span class="jadwal-stat-title">Sedang Berlangsung</span>
                            <span class="jadwal-stat-number">{{ $stats['sedangBerlangsung'] ?? 6 }}</span>
                            <span class="jadwal-stat-sub">jadwal aktif sekarang</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Sudah Selesai -->
                <div class="mobile-jadwal-stat-slide">
                    <div class="jadwal-stat-card orange" style="margin: 0;">
                        <div class="jadwal-stat-icon orange">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="jadwal-stat-info">
                            <span class="jadwal-stat-title">Sudah Selesai</span>
                            <span class="jadwal-stat-number">{{ $stats['sudahSelesai'] ?? 10 }}</span>
                            <span class="jadwal-stat-sub">jadwal telah selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Belum Dimulai -->
                <div class="mobile-jadwal-stat-slide">
                    <div class="jadwal-stat-card purple" style="margin: 0;">
                        <div class="jadwal-stat-icon purple">
                            <i class="fa-solid fa-hourglass-start"></i>
                        </div>
                        <div class="jadwal-stat-info">
                            <span class="jadwal-stat-title">Belum Dimulai</span>
                            <span class="jadwal-stat-number">{{ $stats['belumDimulai'] ?? 8 }}</span>
                            <span class="jadwal-stat-sub">jadwal jam mendatang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Dots -->
        <div class="mobile-jadwal-stat-dots" id="mobileJadwalStatDots">
            <span class="m-stat-dot active" onclick="goToJadwalStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToJadwalStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToJadwalStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToJadwalStatSlide(3)"></span>
        </div>
    </div>

    <!-- ─── TOP 4 STAT CARDS DESKTOP ─── -->
    <div class="jadwal-desktop-stats">
        <div class="jadwal-stats-grid">
            <!-- Card 1: Total Jadwal -->
            <div class="jadwal-stat-card blue">
                <div class="jadwal-stat-icon blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="jadwal-stat-info">
                    <span class="jadwal-stat-title">Total Jadwal</span>
                    <span class="jadwal-stat-number">{{ $stats['totalJadwal'] ?? 24 }}</span>
                    <span class="jadwal-stat-sub">jadwal hari ini</span>
                </div>
            </div>

            <!-- Card 2: Sedang Berlangsung -->
            <div class="jadwal-stat-card green">
                <div class="jadwal-stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="jadwal-stat-info">
                    <span class="jadwal-stat-title">Sedang Berlangsung</span>
                    <span class="jadwal-stat-number">{{ $stats['sedangBerlangsung'] ?? 6 }}</span>
                    <span class="jadwal-stat-sub">jadwal sekarang</span>
                </div>
            </div>

            <!-- Card 3: Sudah Selesai -->
            <div class="jadwal-stat-card orange">
                <div class="jadwal-stat-icon orange">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="jadwal-stat-info">
                    <span class="jadwal-stat-title">Sudah Selesai</span>
                    <span class="jadwal-stat-number">{{ $stats['sudahSelesai'] ?? 10 }}</span>
                    <span class="jadwal-stat-sub">jadwal selesai</span>
                </div>
            </div>

            <!-- Card 4: Belum Dimulai -->
            <div class="jadwal-stat-card purple">
                <div class="jadwal-stat-icon purple">
                    <i class="fa-solid fa-hourglass-start"></i>
                </div>
                <div class="jadwal-stat-info">
                    <span class="jadwal-stat-title">Belum Dimulai</span>
                    <span class="jadwal-stat-number">{{ $stats['belumDimulai'] ?? 8 }}</span>
                    <span class="jadwal-stat-sub">jadwal mendatang</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── DESKTOP CARDS CONTAINER ─── -->
    <div class="jadwal-desktop-card">
    <!-- ─── 2. CARD "DAFTAR JADWAL HARI INI" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Daftar Jadwal Hari Ini</span>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <form action="{{ route('piket.jadwal') }}" method="GET" class="jadwal-filter-form">
            <!-- Filter Tanggal -->
            <div class="jadwal-input-wrapper">
                <i class="fa-regular fa-clock jadwal-input-icon"></i>
                <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="jadwal-filter-input" title="Filter Tanggal">
            </div>

            <!-- Filter Kelas -->
            <div class="jadwal-input-wrapper">
                <i class="fa-solid fa-graduation-cap jadwal-input-icon"></i>
                <select name="id_kelas" class="jadwal-filter-select">
                    <option value="">Kelas: Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($idKelasFilter == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Mapel -->
            <div class="jadwal-input-wrapper">
                <i class="fa-solid fa-book-bookmark jadwal-input-icon"></i>
                <select name="id_mapel" class="jadwal-filter-select">
                    <option value="">Mapel: Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <button type="submit" class="jadwal-btn-filter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <!-- Tombol Reset -->
            <a href="{{ route('piket.jadwal') }}" class="jadwal-btn-reset">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </form>

        <!-- List Item Jadwal -->
        <div class="schedule-items-list">
            @forelse($jadwals as $index => $row)
                @php
                    $times = explode('-', $row->jam_pelajaran_format ?? ($row->jam_range_formatted ?? '07.00 - 08.30'));
                    $tStart = trim($times[0] ?? '07.00');
                    $tEnd = trim($times[1] ?? '08.30');

                    $mapelName = $row->mapel_nama ?? ($row->mapel->nama_mapel ?? 'Mata Pelajaran');
                    $kelasName = $row->kelas_nama ?? ($row->kelas->nama_kelas ?? 'Kelas XI RPL 1');
                    $ruanganName = $row->ruangan_nama ?? ($row->ruangan->nama_ruangan ?? 'Ruang 57');
                    $guruName = $row->guru_nama ?? ($row->guru->nama_guru ?? 'Guru Pengampu');

                    // Status & Visual Accents
                    $stTeks = $row->status_teks ?? ($loop->iteration <= 2 ? 'Sedang Berlangsung' : 'Belum Dimulai');
                    $accentClass = 'accent-green';
                    $badgeClass = 'badge-green';

                    if ($stTeks === 'Belum Dimulai') {
                        if ($loop->iteration === 3) {
                            $accentClass = 'accent-orange';
                            $badgeClass = 'badge-orange';
                        } else {
                            $accentClass = 'accent-purple';
                            $badgeClass = 'badge-purple';
                        }
                    } elseif ($stTeks === 'Sudah Selesai') {
                        $accentClass = 'accent-blue';
                        $badgeClass = 'badge-blue';
                    }
                @endphp
                <div class="schedule-item-row {{ $accentClass }}"
                     onclick="openJadwalDetailModal('{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($ruanganName) }}', '{{ addslashes($guruName) }}', '{{ $tStart }} - {{ $tEnd }}', '{{ $stTeks }}', '{{ $badgeClass }}')">
                    
                    <!-- Left: Time -->
                    <div class="schedule-left-time">
                        <span class="schedule-time-start">{{ $tStart }}</span>
                        <span class="schedule-time-end">- {{ $tEnd }}</span>
                    </div>

                    <!-- Middle: Details -->
                    <div class="schedule-mid-details">
                        <div class="schedule-subject">{{ $mapelName }}</div>
                        <div class="schedule-class-room">
                            <span>{{ $kelasName }}</span>
                            <span>&bull;</span>
                            <span>{{ $ruanganName }}</span>
                        </div>
                        <div class="schedule-teacher">
                            <i class="fa-regular fa-user"></i>
                            <span>{{ $guruName }}</span>
                        </div>
                    </div>

                    <!-- Right: Status Badge & Interactive Chevron -->
                    <div class="schedule-right-status">
                        <span class="schedule-status-badge {{ $badgeClass }}">
                            <span class="status-dot"></span>
                            <span>{{ $stTeks }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right schedule-chevron" title="Klik untuk lihat detail"></i>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 36px 20px; font-weight: 600;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                    Tidak ada jadwal pelajaran yang cocok dengan filter yang dipilih.
                </div>
            @endforelse
        </div>

        <!-- Tombol Tautan Bawah "Lihat Semua Jadwal" -->
        <div class="jadwal-bottom-link-box">
            <a href="{{ route('piket.jadwal') }}" class="jadwal-see-all-link">
                <span>Lihat Semua Jadwal</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
    </div>

<<<<<<< HEAD
</div>

<!-- Modal Dialog: Seluruh Ringkasan per Kelas -->
<div id="modalClassSummary" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-users-viewfinder" style="font-size: 18px;"></i>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Ringkasan Jadwal Seluruh Kelas ({{ $hariFilter }})</h3>
            </div>
            <button type="button" onclick="closeClassSummaryModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px;">
            <table class="class-summary-table">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Total Jadwal</th>
                        <th>Sedang</th>
                        <th>Selesai</th>
                        <th>Belum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ringkasanPerKelas as $rk)
                        <tr>
                            <td>{{ $rk->nama_kelas }}</td>
                            <td>{{ $rk->total }}</td>
                            <td class="val-sedang">{{ $rk->sedang }}</td>
                            <td class="val-selesai">{{ $rk->selesai }}</td>
                            <td class="val-belum">{{ $rk->belum }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
=======
    <!-- ─── 3. CARD "RINGKASAN PER KELAS" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-id-badge"></i>
                <span>Ringkasan per Kelas</span>
            </div>
            <a href="{{ route('piket.jadwal') }}" class="btn-header-pill">
                <span>Lihat Semua</span>
            </a>
        </div>

        <div class="ringkasan-table-container">
            <table class="ringkasan-table">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th><span class="dot-indicator" style="background: #94a3b8;"></span>Total Jadwal</th>
                        <th><span class="dot-indicator" style="background: #10b981;"></span>Sedang</th>
                        <th><span class="dot-indicator" style="background: #f59e0b;"></span>Selesai</th>
                        <th><span class="dot-indicator" style="background: #8b5cf6;"></span>Belum Dimulai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ringkasanPerKelas as $rk)
                        <tr>
                            <td>{{ $rk->nama_kelas }}</td>
                            <td>{{ $rk->total }}</td>
                            <td class="val-sedang">{{ $rk->sedang }}</td>
                            <td class="val-selesai">{{ $rk->selesai }}</td>
                            <td class="val-belum">{{ $rk->belum }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">
                                Belum ada data ringkasan kelas hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ─── 4. CARD "INFORMASI GURU PENGGANTI HARI INI" (FULL WIDTH) ─── -->
    <div class="jadwal-card">
        <div class="jadwal-card-header">
            <div class="jadwal-card-title">
                <i class="fa-solid fa-user-gear"></i>
                <span>Informasi Guru Pengganti Hari Ini</span>
            </div>
            <a href="{{ route('piket.guru-pengganti') }}" class="btn-header-pill">
                <span>Lihat Semua</span>
            </a>
        </div>

        <div class="gp-info-grid">
            <!-- Box 1: Guru Tidak Hadir -->
            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-red" title="Klik untuk membuka Guru Pengganti">
                <div class="gp-info-left">
                    <div class="gp-info-icon gp-icon-red">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div>
                        <div class="gp-info-title">{{ $realGuruTidakHadir }} Guru Tidak Hadir</div>
                        <div class="gp-info-subtext">Lihat detail di menu Guru Pengganti</div>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right gp-info-chevron"></i>
            </a>

            <!-- Box 2: Penugasan Guru Pengganti -->
            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-blue" title="Klik untuk membuka Guru Pengganti">
                <div class="gp-info-left">
                    <div class="gp-info-icon gp-icon-blue">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <div>
                        <div class="gp-info-title">{{ $realPenugasanPengganti }} Penugasan Guru Pengganti</div>
                        <div class="gp-info-subtext">Lihat detail di menu Guru Pengganti</div>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right gp-info-chevron"></i>
            </a>
        </div>
    </div>

    <!-- ─── 5. BOTTOM ALERT BANNER ─── -->
    <div class="jadwal-bottom-banner">
        <div class="jadwal-bottom-left">
            <div class="jadwal-bottom-icon">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <span class="jadwal-bottom-text">
                Jadwal dapat berubah sewaktu-waktu. Pastikan untuk selalu memantau informasi terbaru.
            </span>
        </div>
        <div class="jadwal-bottom-decor d-none d-md-flex">
            <!-- Decorative calendar & clock illustration badge -->
            <div style="background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(191, 219, 254, 0.8); border-radius: 12px; padding: 6px 14px; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.05);">
                <i class="fa-solid fa-calendar-check" style="color: #2563eb; font-size: 15px;"></i>
                <span style="font-size: 11.5px; font-weight: 750; color: #1e40af;">Real-Time Data KBM</span>
            </div>
        </div>
    </div>
    </div> <!-- ─── END DESKTOP CARDS CONTAINER ─── -->

    <!-- ─── MOBILE SCHEDULE & SUMMARY SECTION (MOBILE ONLY) ─── -->
    <div class="mobile-jadwal-section">
        <!-- Filter & Search Bar Mobile -->
        <div class="mobile-jadwal-filter-bar">
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                <input type="text" id="mobileJadwalSearchInput" placeholder="Cari mapel / guru / ruang..." class="m-search-input" onkeyup="filterMobileJadwalList(this.value)">
            </div>
            <button type="button" class="m-btn-filter-trigger" onclick="openMobileJadwalFilterModal()" title="Filter Data">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter</span>
                @if($idKelasFilter || $idMapelFilter || ($tanggalFilter && $tanggalFilter !== $todayDateStr))
                    <span class="m-filter-active-dot"></span>
                @endif
            </button>
        </div>

        @if($idKelasFilter || $idMapelFilter || ($tanggalFilter && $tanggalFilter !== $todayDateStr))
            <div style="display: flex; align-items: center; justify-content: space-between; background: #eff6ff; border: 1px solid #bfdbfe; padding: 8px 12px; border-radius: 10px; font-size: 12px; color: #1e40af;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-filter fa-sm"></i>
                    <span>Filter aktif: <strong>{{ $idKelasFilter ? 'Kelas terpilih ' : '' }}{{ $idMapelFilter ? 'Mapel terpilih ' : '' }}{{ $tanggalFilter !== $todayDateStr ? $tanggalFilter : '' }}</strong></span>
                </div>
                <a href="{{ route('piket.jadwal') }}" style="color: #ef4444; font-weight: 700; text-decoration: none; font-size: 11px;">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            </div>
        @endif

        <!-- List Item Jadwal Cards (Design System) -->
        <div class="mobile-jadwal-cards-list" id="mobileJadwalCardsList">
            @forelse($jadwals as $index => $row)
                @php
                    $times = explode('-', $row->jam_pelajaran_format ?? ($row->jam_range_formatted ?? '07.00 - 08.30'));
                    $tStart = trim($times[0] ?? '07.00');
                    $tEnd = trim($times[1] ?? '08.30');

                    $mapelName = $row->mapel_nama ?? ($row->mapel->nama_mapel ?? 'Mata Pelajaran');
                    $kelasName = $row->kelas_nama ?? ($row->kelas->nama_kelas ?? 'Kelas XI RPL 1');
                    $ruanganName = $row->ruangan_nama ?? ($row->ruangan->nama_ruangan ?? 'Ruang 57');
                    $guruName = $row->guru_nama ?? ($row->guru->nama_guru ?? 'Guru Pengampu');

                    $stTeks = $row->status_teks ?? ($loop->iteration <= 2 ? 'Sedang Berlangsung' : 'Belum Dimulai');
                    $accentClass = 'accent-green';
                    $badgeClass = 'badge-green';

                    if ($stTeks === 'Belum Dimulai') {
                        if ($loop->iteration === 3) {
                            $accentClass = 'accent-orange';
                            $badgeClass = 'badge-orange';
                        } else {
                            $accentClass = 'accent-purple';
                            $badgeClass = 'badge-purple';
                        }
                    } elseif ($stTeks === 'Sudah Selesai') {
                        $accentClass = 'accent-blue';
                        $badgeClass = 'badge-blue';
                    }
                @endphp
                <div class="mobile-jadwal-card-item {{ $accentClass }}" data-search="{{ strtolower($mapelName . ' ' . $kelasName . ' ' . $ruanganName . ' ' . $guruName) }}">
                    <!-- Header: Icon + Title + Status Badge -->
                    <div class="m-jadwal-header-row">
                        <div class="m-jadwal-title-box">
                            <div class="m-card-icon-wrap">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <div style="min-width: 0;">
                                <div class="m-jadwal-mapel-name">{{ $mapelName }}</div>
                                <div class="m-jadwal-meta-sub">
                                    <span>{{ $kelasName }}</span>
                                    <span>•</span>
                                    <span>{{ $ruanganName }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="schedule-status-badge {{ $badgeClass }}">
                            <span class="status-dot"></span>
                            <span>{{ $stTeks }}</span>
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="m-jadwal-info-grid">
                        <div class="m-jadwal-info-cell">
                            <span class="m-jadwal-info-label">Waktu KBM</span>
                            <span class="m-jadwal-info-val">
                                <i class="fa-regular fa-clock" style="color: #2563eb; font-size: 11px;"></i>
                                {{ $tStart }} - {{ $tEnd }} WIB
                            </span>
                        </div>
                        <div class="m-jadwal-info-cell">
                            <span class="m-jadwal-info-label">Guru Pengampu</span>
                            <span class="m-jadwal-info-val" title="{{ $guruName }}">
                                <i class="fa-regular fa-user" style="color: #64748b; font-size: 11px;"></i>
                                {{ $guruName }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Row with "Lihat Detail >" -->
                    <div class="m-jadwal-action-row">
                        <button type="button"
                                onclick="openJadwalDetailModal('{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($ruanganName) }}', '{{ addslashes($guruName) }}', '{{ $tStart }} - {{ $tEnd }}', '{{ $stTeks }}', '{{ $badgeClass }}')"
                                class="m-btn-detail-link">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 36px 20px; text-align: center;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fa-regular fa-calendar-xmark"></i>
                    </div>
                    <h3 style="font-size: 14px; font-weight: 800; color: #1e3a8a; margin: 0 0 6px 0;">Tidak Ada Jadwal Hari Ini</h3>
                    <p style="font-size: 12px; color: #64748b; margin: 0; line-height: 1.5;">Tidak ada jadwal pelajaran yang cocok dengan tanggal atau filter yang dipilih.</p>
                </div>
            @endforelse
        </div>

        <!-- Ringkasan per Kelas Mobile (Horizontal Scroll) -->
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 14px 16px; margin-top: 4px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 13px;">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                    <h3 style="font-size: 14px; font-weight: 800; color: #1e3a8a; margin: 0;">Ringkasan per Kelas</h3>
                </div>
                <span style="font-size: 11px; font-weight: 700; color: #64748b;">Geser &rarr;</span>
            </div>

            <div class="mobile-ringkasan-scroll">
                @foreach($ringkasanPerKelas as $rk)
                    <div class="mobile-ringkasan-pill">
                        <div style="font-size: 13px; font-weight: 800; color: #1e3a8a;">{{ $rk->nama_kelas }}</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #64748b; margin-top: 2px;">
                            <span>Total KBM:</span>
                            <strong style="color: #1e293b;">{{ $rk->total }}</strong>
                        </div>
                        <div style="display: flex; gap: 8px; font-size: 10.5px; font-weight: 700; margin-top: 4px; padding-top: 4px; border-top: 1px dashed #f1f5f9;">
                            <span class="val-sedang"><i class="fa-solid fa-play fa-2xs"></i> {{ $rk->sedang }}</span>
                            <span class="val-selesai"><i class="fa-solid fa-check fa-2xs"></i> {{ $rk->selesai }}</span>
                            <span class="val-belum"><i class="fa-solid fa-clock fa-2xs"></i> {{ $rk->belum }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Link Guru Pengganti Mobile -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 4px;">
            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-red" style="padding: 12px 14px; border-radius: 14px;">
                <div class="gp-info-left" style="gap: 10px;">
                    <div class="gp-info-icon gp-icon-red" style="width: 34px; height: 34px; font-size: 14px;">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div>
                        <div class="gp-info-title" style="font-size: 13px;">{{ $realGuruTidakHadir }} Izin</div>
                        <div class="gp-info-subtext" style="font-size: 10.5px;">Guru Tidak Hadir</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('piket.guru-pengganti') }}" class="gp-info-card gp-card-blue" style="padding: 12px 14px; border-radius: 14px;">
                <div class="gp-info-left" style="gap: 10px;">
                    <div class="gp-info-icon gp-icon-blue" style="width: 34px; height: 34px; font-size: 14px;">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <div>
                        <div class="gp-info-title" style="font-size: 13px;">{{ $realPenugasanPengganti }} Pengganti</div>
                        <div class="gp-info-subtext" style="font-size: 10.5px;">Penugasan Aktif</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- ─── 6. MODAL DETAIL JADWAL PELAJARAN (INTERAKTIF) ─── -->
<div id="jadwalDetailModal" class="jadwal-modal-backdrop" onclick="closeJadwalDetailModal(event)">
    <div class="jadwal-modal-box" onclick="event.stopPropagation()">
        <div class="jadwal-modal-header">
            <div class="jadwal-modal-title">
                <i class="fa-solid fa-circle-info" style="color: #38bdf8;"></i>
                <span>Detail Jadwal Pelajaran</span>
            </div>
            <button type="button" class="jadwal-modal-close" onclick="closeJadwalDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="jadwal-modal-body">
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Mata Pelajaran</span>
                <span id="modalMapel" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Kelas</span>
                <span id="modalKelas" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Ruang Kelas</span>
                <span id="modalRuang" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Guru Pengampu</span>
                <span id="modalGuru" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Waktu Pelaksanaan</span>
                <span id="modalWaktu" class="jadwal-detail-val">-</span>
            </div>
            <div class="jadwal-detail-row">
                <span class="jadwal-detail-label">Status Pembelajaran</span>
                <span id="modalStatusBadge" class="schedule-status-badge badge-green">
                    <span class="status-dot"></span>
                    <span id="modalStatusText">Sedang Berlangsung</span>
                </span>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" class="jadwal-btn-filter" style="background: #2563eb;" onclick="closeJadwalDetailModal()">
                    <i class="fa-solid fa-check"></i> Tutup
                </button>
            </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
    </div>
</div>

<<<<<<< HEAD
=======
<!-- ─── MODAL FILTER JADWAL MOBILE (BOTTOM SHEET) ─── -->
<div id="mobileJadwalFilterModal" class="mobile-filter-modal-wrap">
    <div class="mobile-filter-sheet">
        <div class="mobile-filter-sheet-header">
            <h3 class="mobile-filter-sheet-title">
                <i class="fa-solid fa-sliders" style="color: #2563eb;"></i> Filter Jadwal Hari Ini
            </h3>
            <button type="button" class="mobile-filter-sheet-close" onclick="closeMobileJadwalFilterModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('piket.jadwal') }}" method="GET" style="margin: 0;">
            <div class="mobile-filter-sheet-body">
                <div class="form-group-custom" style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Filter Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="m-search-input" style="padding-left: 14px !important; height: 42px;">
                </div>

                <div class="form-group-custom" style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Filter Kelas</label>
                    <select name="id_kelas" class="m-search-input" style="padding-left: 14px !important; height: 42px;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ ($idKelasFilter == $k->id_kelas) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom" style="display: flex; flex-direction: column; gap: 4px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Filter Mata Pelajaran</label>
                    <select name="id_mapel" class="m-search-input" style="padding-left: 14px !important; height: 42px;">
                        <option value="">Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mobile-filter-actions-row">
                    <a href="{{ route('piket.jadwal') }}" class="jadwal-btn-reset" style="justify-content: center; height: 42px; text-decoration: none;">
                        Reset
                    </a>
                    <button type="submit" class="jadwal-btn-filter" style="justify-content: center; height: 42px; background: #2563eb;">
                        <i class="fa-solid fa-check"></i> Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openJadwalDetailModal(mapel, kelas, ruang, guru, waktu, statusTeks, badgeClass) {
        document.getElementById('modalMapel').textContent = mapel;
        document.getElementById('modalKelas').textContent = kelas;
        document.getElementById('modalRuang').textContent = ruang;
        document.getElementById('modalGuru').textContent = guru;
        document.getElementById('modalWaktu').textContent = waktu;
        
        const badgeEl = document.getElementById('modalStatusBadge');
        badgeEl.className = 'schedule-status-badge ' + badgeClass;
        document.getElementById('modalStatusText').textContent = statusTeks;

        document.getElementById('jadwalDetailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeJadwalDetailModal(event) {
        if (!event || event.target === document.getElementById('jadwalDetailModal') || event.currentTarget.classList.contains('jadwal-modal-close') || event.target.closest('.jadwal-btn-filter')) {
            document.getElementById('jadwalDetailModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeJadwalDetailModal();
        }
    });

    // ─── MOBILE CAROUSEL & FILTER JS ───
    let currentJadwalSlide = 0;
    const totalJadwalSlides = 4;

    function goToJadwalStatSlide(idx) {
        currentJadwalSlide = idx;
        const track = document.getElementById('mobileJadwalStatTrack');
        const dots = document.querySelectorAll('#mobileJadwalStatDots .m-stat-dot');
        if (track) {
            track.style.transform = `translateX(-${currentJadwalSlide * 100}%)`;
        }
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentJadwalSlide);
        });
    }

    function initJadwalStatCarousel() {
        const track = document.getElementById('mobileJadwalStatTrack');
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
                if (diffX < 0 && currentJadwalSlide < totalJadwalSlides - 1) {
                    goToJadwalStatSlide(currentJadwalSlide + 1);
                } else if (diffX > 0 && currentJadwalSlide > 0) {
                    goToJadwalStatSlide(currentJadwalSlide - 1);
                }
            }
            isSwiping = false;
        });
    }

    function openMobileJadwalFilterModal() {
        const m = document.getElementById('mobileJadwalFilterModal');
        if (m) {
            m.classList.add('active');
            m.style.display = 'flex';
        }
    }

    function closeMobileJadwalFilterModal() {
        const m = document.getElementById('mobileJadwalFilterModal');
        if (m) {
            m.classList.remove('active');
            m.style.display = 'none';
        }
    }

    function filterMobileJadwalList(query) {
        const q = query.toLowerCase().trim();
        const cards = document.querySelectorAll('#mobileJadwalCardsList .mobile-jadwal-card-item');
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
        initJadwalStatCarousel();
    });
</script>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
@endsection

@section('scripts')
<script>
    function openClassSummaryModal() {
        document.getElementById('modalClassSummary').style.display = 'flex';
    }
    function closeClassSummaryModal() {
        document.getElementById('modalClassSummary').style.display = 'none';
    }
    window.onclick = function(e) {
        var modal = document.getElementById('modalClassSummary');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
@endsection