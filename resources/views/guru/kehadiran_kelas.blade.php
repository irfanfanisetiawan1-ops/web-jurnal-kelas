@extends('layouts.guru')

@section('title', 'Presensi & Perkembangan Siswa Kelas: ' . $namaKelas . ' — EDU JOURNAL')
@section('header_title', 'Presensi & Perkembangan Siswa Kelas: ' . $namaKelas)

@section('styles')
<style>
    /* Dashboard Page Header Style (Matching Dashboard TU Example) */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dash-wali-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Sub-Navigation Tabs Bar */
    .subnav-tabs-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        padding: 8px 12px;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .subnav-tab-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background: transparent;
        font-family: inherit;
        white-space: nowrap;
    }

    .subnav-tab-item i {
        font-size: 14px;
    }

    .subnav-tab-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .subnav-tab-item.active {
        background: #384972;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(56, 73, 114, 0.25);
    }

    /* Sub-header Banner */
    .wali-header-banner {
        background: linear-gradient(135deg, #1e293b 0%, #384972 100%);
        border-radius: 18px;
        padding: 22px 28px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(30, 41, 59, 0.12);
    }

    .wali-header-banner h2 {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
        color: #ffffff;
        text-transform: uppercase;
    }

    .wali-header-banner p {
        font-size: 13px;
        color: #cbd5e1;
        font-weight: 600;
    }

    .badge-class-pill {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #ffffff;
    }

    /* Top Summary Stat Cards Grid */
    .stats-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.06);
    }

    .stat-card-item.dark-blue {
        background: #2b3859;
        color: #ffffff;
        border-color: #1e293b;
    }

    .stat-card-item.tan-bg {
        background: #f8fafc;
        color: #0f172a;
        border: 1px solid #cbd5e1;
        border-top: 3px solid #3b82f6;
    }

    .stat-card-item .title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 8px;
    }

    .stat-card-item.dark-blue .title { color: #cbd5e1; }
    .stat-card-item.tan-bg .title { color: #2563eb; }

    .stat-card-item .number {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 6px;
        color: #0f172a;
    }

    .stat-card-item.dark-blue .number { color: #ffffff; }
    .stat-card-item.tan-bg .number { color: #0f172a; }

    .stat-card-item .subtitle {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-card-item.dark-blue .subtitle { color: #94a3b8; }
    .stat-card-item.tan-bg .subtitle { color: #64748b; }

    /* Middle Row: Kehadiran Mingguan & Kode Absensi */
    .grid-chart-legend {
        display: grid;
        grid-template-columns: 60% 38%;
        gap: 2%;
    }

    .card-chart-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .card-chart-box h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .card-chart-box p {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 20px;
    }

    .bars-container {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 140px;
        padding-top: 10px;
    }

    .bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 60px;
        gap: 6px;
    }

    .bar-val {
        font-size: 12px;
        font-weight: 800;
        color: #1e293b;
    }

    .bar-track {
        width: 36px;
        height: 100px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
    }

    .bar-fill {
        width: 100%;
        background: linear-gradient(180deg, #3b82f6 0%, #1e3a8a 100%);
        border-radius: 6px 6px 0 0;
        transition: height 0.5s ease;
    }

    .bar-label {
        font-size: 11px;
        font-weight: 700;
        color: #475569;
    }

    /* Card Kode Absensi */
    .card-kode-legend {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .card-kode-legend h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .card-kode-legend p {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 16px;
    }

    .legend-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .legend-left {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .dot-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .dot-hadir { background: #10b981; }
    .dot-sakit { background: #b45309; }
    .dot-izin { background: #475569; }
    .dot-alpa { background: #ef4444; }

    .code-badge {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
    }

    /* Filter Pencarian Card */
    .card-filter-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-filter-box h3 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-controls-row {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-custom label {
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
    }

    .input-custom, .select-custom {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        min-width: 170px;
        font-family: inherit;
    }

    .btn-filter-dark {
        background: #1e293b;
        color: #ffffff;
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-dark:hover {
        background: #334155;
    }

    .btn-reset-gray {
        background: #f1f5f9;
        color: #475569;
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-reset-gray:hover {
        background: #e2e8f0;
    }

    /* Bottom Grid: Rekap & Rincian */
    .grid-rekap-rincian {
        display: grid;
        grid-template-columns: 60% 38%;
        gap: 2%;
    }

    .card-table-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-table-box h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    /* Tables */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 10px 12px;
        text-align: left;
        background: #cbd5e1;
        border-bottom: 1px solid #94a3b8;
    }

    .table-custom td {
        padding: 10px 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Day Badges */
    .day-badge {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
        color: #ffffff;
    }
    .day-badge.bg-h { background: #10b981; }
    .day-badge.bg-s { background: #b45309; }
    .day-badge.bg-i { background: #475569; }
    .day-badge.bg-a { background: #ef4444; }

    /* Student Profile Cell */
    .student-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #64748b;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        flex-shrink: 0;
    }

    .student-info .name {
        font-weight: 700;
        color: #0f172a;
        font-size: 13px;
        line-height: 1.2;
    }

    .student-info .nis {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
    }

    /* Status Pills */
    .status-pill {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-block;
        white-space: nowrap;
    }

    .status-pill.success {
        background: #d1fae5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .status-pill.warning {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .status-pill.danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }

    .status-pill.pink-badge {
        background: #fecdd3;
        color: #9f1239;
        border: 1px solid #fda4af;
    }

    .badge-kind-tan {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
    }

    /* STYLES FOR TAB 2: KELAS PERWALIAN */
    .perwalian-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .perwalian-title-area .count-badge {
        font-size: 14px;
        font-weight: 800;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .perwalian-title-area h2 {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.02em;
        margin: 2px 0;
    }

    .perwalian-title-area p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    .perwalian-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .perwalian-search-input {
        background: #2b3859;
        color: #ffffff;
        border: 1px solid #1e293b;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        outline: none;
        min-width: 220px;
    }

    .perwalian-search-input::placeholder {
        color: #94a3b8;
    }

    .perwalian-select-filter {
        background: #2b3859;
        color: #ffffff;
        border: 1px solid #1e293b;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        outline: none;
        cursor: pointer;
    }

    .student-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .student-card-box {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .student-card-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }

    .student-card-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #64748b;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        flex-shrink: 0;
    }

    .student-card-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .student-card-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .student-card-nis {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .student-card-pills {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pill-percent {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    /* STYLES FOR TAB 3: REKAP KEHADIRAN (CALENDAR HEATMAP) */
    .month-nav-box {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        padding: 6px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .month-nav-btn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #334155;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .month-nav-btn:hover {
        background: #384972;
        color: #ffffff;
    }

    .month-nav-label {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        min-width: 120px;
        text-align: center;
    }

    .card-heatmap-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-heatmap-box h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .card-heatmap-box p {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .heatmap-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .heat-box {
        aspect-ratio: 1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        cursor: pointer;
        position: relative;
        user-select: none;
    }

    .heat-box:hover {
        transform: scale(1.08);
        box-shadow: 0 8px 18px rgba(0,0,0,0.14);
        z-index: 10;
    }

    .heat-box.heat-95 { background: #065f46; color: #ffffff; }
    .heat-box.heat-85 { background: #10b981; color: #ffffff; }
    .heat-box.heat-70 { background: #b45309; color: #ffffff; }
    .heat-box.heat-red { background: #dc2626; color: #ffffff; }
    .heat-box.holiday { background: #ffffff; color: #475569; border: 2px solid #cbd5e1; }
    .heat-box.heat-future { background: #e2e8f0; color: #94a3b8; border: 1.5px dashed #cbd5e1; box-shadow: none; }

    .heat-box.is-today {
        outline: 3px solid #2563eb !important;
        outline-offset: 2px;
        box-shadow: 0 0 14px rgba(37,99,235,0.45);
        font-weight: 900;
    }

    .heat-box.is-today .today-badge-marker {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 8px;
        font-weight: 800;
        background: #2563eb;
        color: #ffffff;
        padding: 1px 5px;
        border-radius: 6px;
        letter-spacing: 0.3px;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        pointer-events: none;
    }

    .heatmap-legend-row {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
    }

    .legend-indicator {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 4px;
        vertical-align: middle;
        margin-right: 6px;
    }

    .legend-indicator.ind-95 { background: #065f46; }
    .legend-indicator.ind-85 { background: #10b981; }
    .legend-indicator.ind-70 { background: #b45309; }
    .legend-indicator.ind-red { background: #dc2626; }
    .legend-indicator.ind-holiday { background: #ffffff; border: 1.5px solid #cbd5e1; }
    .legend-indicator.ind-future { background: #e2e8f0; border: 1.5px dashed #cbd5e1; }
    .legend-indicator.ind-today { background: #ffffff; border: 2px solid #2563eb; outline: 1px solid #2563eb; }

    /* STYLES FOR TAB 4: LAPORAN BULANAN */
    .perlu-perhatian-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .perlu-perhatian-card h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .perlu-perhatian-card p {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .rank-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .rank-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .rank-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rank-num {
        font-size: 16px;
        font-weight: 800;
        color: #475569;
        width: 20px;
        text-align: center;
    }

    .rank-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #64748b;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .rank-info .r-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .rank-info .r-sub {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
    }

    .rank-badge {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
    }

    .catatan-wali-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .catatan-wali-box h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .catatan-wali-box p {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .catatan-content-area {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        font-size: 13.5px;
        color: #1e293b;
        font-weight: 600;
        line-height: 1.6;
    }

    /* STYLES FOR TAB 6: PENGATURAN (IMAGE 7 MATCH) */
    .settings-layout-grid {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 20px;
    }

    .settings-sidebar-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        gap: 6px;
        height: fit-content;
    }

    .settings-sub-item {
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
    }

    .settings-sub-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .settings-sub-item.active {
        background: #384972;
        color: #ffffff;
        font-weight: 800;
    }

    .settings-card-section {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .settings-card-section h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .settings-card-section p {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .settings-field-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .settings-field-row label {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        width: 140px;
        flex-shrink: 0;
    }

    .readonly-field-tan {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        width: 100%;
    }

    /* iOS Style Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-round {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 34px;
    }

    .slider-round:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider-round {
        background-color: #10b981;
    }

    input:checked + .slider-round:before {
        transform: translateX(22px);
    }

    .tab-content-panel {
        display: none;
    }

    .tab-content-panel.active {
        display: block;
    }

    @media (max-width: 1100px) {
        .heatmap-grid { grid-template-columns: repeat(8, 1fr); }
        .student-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .stats-summary-grid { grid-template-columns: repeat(3, 1fr); }
        .grid-chart-legend { grid-template-columns: 1fr; }
        .grid-rekap-rincian { grid-template-columns: 1fr; }
        .settings-layout-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .heatmap-grid { grid-template-columns: repeat(6, 1fr); }
        .student-cards-grid { grid-template-columns: 1fr; }
        .stats-summary-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endsection

@section('content')

@php
    $nowWali = \Carbon\Carbon::now('Asia/Jakarta');
    $daysId = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $monthsId = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $formattedDateWali = $daysId[$nowWali->dayOfWeek] . ', ' . $nowWali->day . ' ' . $monthsId[$nowWali->month] . ' ' . $nowWali->year;
@endphp

<div class="dash-wali-container">

    <!-- Page Location Header (Keterangan Keberadaan Halaman - Dashboard TU Style) -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1 id="waliHeaderTitle">
                @if($tab == 'kelas_perwalian')
                    Kelas Perwalian — {{ $namaKelas }}
                @elseif($tab == 'rekap_kehadiran')
                    Rekap Kehadiran Siswa — {{ $namaKelas }}
                @elseif($tab == 'laporan_bulanan')
                    Laporan Bulanan Presensi — {{ $namaKelas }}
                @elseif($tab == 'surat_izin')
                    Surat Izin / Sakit — {{ $namaKelas }}
                @else
                    Dashboard Wali Kelas — {{ $namaKelas }}
                @endif
            </h1>
            <p id="waliHeaderSubtitle">
                {{ $formattedDateWali }} &nbsp;•&nbsp;
                <span id="waliSubText">
                @if($tab == 'kelas_perwalian')
                    Daftar dan data detail seluruh siswa perwalian
                @elseif($tab == 'rekap_kehadiran')
                    Rekapitulasi presensi dan statistik kehadiran siswa
                @elseif($tab == 'laporan_bulanan')
                    Ringkasan laporan bulanan kelas perwalian
                @elseif($tab == 'surat_izin')
                    Pengajuan dan arsip surat izin / sakit siswa
                @else
                    Rekapitulasi presensi &amp; perkembangan siswa kelas {{ $namaKelas }} hari ini
                @endif
                </span>
            </p>
        </div>

        <div class="header-actions-group">
            <span class="badge-class-pill" style="background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; padding: 9px 18px; border-radius: 14px; font-size: 13px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <i class="fa-solid fa-graduation-cap" style="color: #2563eb;"></i> KELAS PERWALIAN : <strong>{{ $namaKelas }}</strong>
            </span>
        </div>
    </div>

    <!-- Sub-Navigation Tabs Bar -->
    <div class="subnav-tabs-bar">
        <button type="button" class="subnav-tab-item {{ $tab == 'dashboard' ? 'active' : '' }}" onclick="switchWaliTab('dashboard')">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'kelas_perwalian' ? 'active' : '' }}" onclick="switchWaliTab('kelas_perwalian')">
            <i class="fa-solid fa-users"></i>
            <span>Kelas Perwalian</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'rekap_kehadiran' ? 'active' : '' }}" onclick="switchWaliTab('rekap_kehadiran')">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Rekap Kehadiran</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'laporan_bulanan' ? 'active' : '' }}" onclick="switchWaliTab('laporan_bulanan')">
            <i class="fa-solid fa-file-invoice"></i>
            <span>Laporan Bulanan</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'surat_izin' ? 'active' : '' }}" onclick="switchWaliTab('surat_izin')">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>Surat Izin / Sakit</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'surat_dispen' ? 'active' : '' }}" onclick="switchWaliTab('surat_dispen')">
            <i class="fa-solid fa-file-signature"></i>
            <span>Surat Dispen Siswa</span>
        </button>

        <button type="button" class="subnav-tab-item {{ $tab == 'pengaturan' ? 'active' : '' }}" onclick="switchWaliTab('pengaturan')">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan Profil</span>
        </button>
    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 1: DASHBOARD (STAT CARDS, BARS, FILTER, QUICK REKAP)      -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-dashboard" class="tab-content-panel {{ $tab == 'dashboard' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- 5 Top Summary Stat Cards Grid (From Image 2) -->
            <div class="stats-summary-grid">
                <!-- Card 1: Total Siswa -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Total siswa</div>
                        <div class="number">{{ $totalSiswa }}</div>
                    </div>
                    <div class="subtitle">di kelas {{ $namaKelas }}</div>
                </div>

                <!-- Card 2: Hadir Hari Ini (Navy Blue) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Hadir hari ini</div>
                        <div class="number">{{ $hadirHariIni }}</div>
                    </div>
                    <div class="subtitle">{{ $persenHadirHariIni }}% dari total siswa</div>
                </div>

                <!-- Card 3: Sakit -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Sakit</div>
                        <div class="number">{{ $sakitHariIni }}</div>
                    </div>
                    <div class="subtitle">dengan surat dokter</div>
                </div>

                <!-- Card 4: Izin (Tan / Light Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Izin</div>
                        <div class="number">{{ $izinHariIni }}</div>
                    </div>
                    <div class="subtitle">acara keluarga / izin</div>
                </div>

                <!-- Card 5: Alpa (Dark Slate/Navy) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Alpa</div>
                        <div class="number">{{ $alpaHariIni }}</div>
                    </div>
                    <div class="subtitle">belum ada keterangan</div>
                </div>
            </div>

            <!-- Middle Row: Kehadiran Mingguan Chart & Kode Absensi Legend (From Image 2) -->
            <div class="grid-chart-legend">
                <!-- Card Left: Persentase Kehadiran Mingguan -->
                <div class="card-chart-box">
                    <h3>Persentase Kehadiran Mingguan</h3>
                    <p>Rata-rata tingkat kehadiran siswa, 4 minggu terakhir</p>

                    <div class="bars-container">
                        @foreach($persentaseMingguan as $key => $bar)
                            <div class="bar-col">
                                <div class="bar-val">{{ $bar['persen'] }}%</div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="height: {{ $bar['persen'] }}%;"></div>
                                </div>
                                <div class="bar-label">{{ $bar['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Card Right: Keterangan Kode Absensi -->
                <div class="card-kode-legend">
                    <h3>Keterangan Kode Absensi</h3>
                    <p>Status kehadiran harian</p>

                    <div class="legend-list">
                        <div class="legend-item">
                            <div class="legend-left">
                                <div class="dot-indicator dot-hadir"></div>
                                <span>Hadir</span>
                            </div>
                            <span class="code-badge">H</span>
                        </div>

                        <div class="legend-item">
                            <div class="legend-left">
                                <div class="dot-indicator dot-sakit"></div>
                                <span>Sakit</span>
                            </div>
                            <span class="code-badge">S</span>
                        </div>

                        <div class="legend-item">
                            <div class="legend-left">
                                <div class="dot-indicator dot-izin"></div>
                                <span>Izin</span>
                            </div>
                            <span class="code-badge">I</span>
                        </div>

                        <div class="legend-item">
                            <div class="legend-left">
                                <div class="dot-indicator dot-alpa"></div>
                                <span>Alpa</span>
                            </div>
                            <span class="code-badge">A</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Card: Filter Pencarian & Switching Kelas -->
            <div class="card-filter-box">
                <h3>FILTER PENCARIAN & KELAS PERWALIAN</h3>

                <form action="{{ route('guru.kehadiran-kelas') }}" method="GET" class="filter-controls-row">
                    <input type="hidden" name="tab" value="dashboard">
                    <!-- Pilihan Kelas -->
                    <div class="form-group-custom">
                        <label for="id_kelas">KELAS</label>
                        <select id="id_kelas" name="id_kelas" class="select-custom" onchange="this.form.submit()">
                            @foreach($kelases as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasSelected == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} {{ $k->wali_kelas ? '(Perwalian)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Alasan / Keterangan -->
                    <div class="form-group-custom">
                        <label for="alasan">ALASAN/KETERANGAN</label>
                        <select id="alasan" name="alasan" class="select-custom">
                            <option value="">SEMUA KETERANGAN</option>
                            <option value="Sakit" {{ $alasan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Izin" {{ $alasan == 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Alpa" {{ $alasan == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </div>

                    <!-- Filter Bulan -->
                    <div class="form-group-custom">
                        <label for="bulan">BULAN</label>
                        <select id="bulan" name="bulan" class="select-custom">
                            <option value="" {{ empty($bulan) ? 'selected' : '' }}>SEMUA BULAN</option>
                            @php
                                $daftarBulanIndo = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                            @endphp
                            @foreach($daftarBulanIndo as $mNum => $mName)
                                <option value="{{ $mNum }}" {{ (string)$bulan === (string)$mNum ? 'selected' : '' }}>
                                    {{ $mName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search nama siswa -->
                    <div class="form-group-custom">
                        <label for="q">CARI SISWA</label>
                        <input type="text" id="q" name="q" value="{{ $search }}" class="input-custom" placeholder="Cari nama siswa / NIS...">
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-filter-dark">
                            <i class="fa-solid fa-filter"></i> FILTER
                        </button>
                        <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-reset-gray">
                            <i class="fa-solid fa-rotate-left"></i> RESET
                        </a>
                    </div>
                </form>
            </div>

            <!-- Rekap Kehadiran Siswa (Full Width) -->
            <div class="card-table-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Rekap Kehadiran Siswa</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Akumulasi status &amp; persentase kehadiran peserta didik</p>
                    </div>
                    <span class="badge-class-pill" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; font-size: 11px;">
                        {{ count($rekapSiswa) }} SISWA
                    </span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th style="width: 70px; text-align: center; color: #b45309;" title="Sakit">SAKIT</th>
                                <th style="width: 70px; text-align: center; color: #0284c7;" title="Izin">IZIN</th>
                                <th style="width: 70px; text-align: center; color: #ef4444;" title="Alpa">ALPA</th>
                                <th style="width: 90px; text-align: center;" title="Total Tidak Hadir">TOTAL</th>
                                <th style="width: 110px; text-align: center;" title="Persentase Kehadiran">% HADIR</th>
                                <th style="width: 140px; text-align: center;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapSiswa as $row)
                                <tr style="cursor: pointer;" onclick="showSiswaDetailModal({{ $row['siswa']->id_siswa }})" title="Klik untuk melihat detail profil &amp; riwayat siswa">
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($row['siswa']->nama_siswa, 0, 2)) }}
                                            </div>
                                            <div class="student-info">
                                                <div class="name">{{ $row['siswa']->nama_siswa }}</div>
                                                <div class="nis">NIS {{ $row['siswa']->nis ?? '240' . $row['siswa']->id_siswa }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: {{ $row['sakit'] > 0 ? '#b45309' : '#94a3b8' }};">
                                        @if($row['sakit'] > 0)
                                            <span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 12px;">{{ $row['sakit'] }}</span>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: {{ $row['izin'] > 0 ? '#0284c7' : '#94a3b8' }};">
                                        @if($row['izin'] > 0)
                                            <span class="badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 12px;">{{ $row['izin'] }}</span>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: {{ $row['alpa'] > 0 ? '#ef4444' : '#94a3b8' }};">
                                        @if($row['alpa'] > 0)
                                            <span class="badge" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 12px;">{{ $row['alpa'] }}</span>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td style="text-align: center; font-weight: 800; color: {{ $row['total'] > 0 ? '#0f172a' : '#94a3b8' }}; font-size: 13.5px;">
                                        {{ $row['total'] }}
                                    </td>
                                    <td style="text-align: center; font-weight: 800; font-size: 13.5px; color: {{ $row['kehadiran'] >= 95 ? '#16a34a' : ($row['kehadiran'] >= 85 ? '#2563eb' : '#dc2626') }};">
                                        {{ $row['kehadiran'] }}%
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="status-pill {{ $row['statusClass'] }}">
                                            {{ $row['statusText'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                                        Tidak ada data siswa ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 2: KELAS PERWALIAN (STUDENT CARDS GRID - MATCH IMAGE 3)    -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-kelas_perwalian" class="tab-content-panel {{ $tab == 'kelas_perwalian' ? 'active' : '' }}">

        <div class="perwalian-header-row">
            <div class="perwalian-title-area">
                <div class="count-badge">{{ count($studentCards) }} SISWA</div>
                <h2>Kelas Perwalian . {{ $namaKelas }}</h2>
                <p>Profil singkat &amp; status kehadiran terkini tiap siswa</p>
            </div>

            <div class="perwalian-controls">
                <input type="text" id="card_search" class="perwalian-search-input" placeholder="Cari nama siswa..." value="{{ $search }}" onkeyup="filterCardsByJs()">
                <select id="status_filter_sel" class="perwalian-select-filter" onchange="filterCardsByJs()">
                    <option value="">Semua status</option>
                    <option value="Baik" {{ $statusFilter == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Perlu pantau" {{ $statusFilter == 'Perlu pantau' ? 'selected' : '' }}>Perlu pantau</option>
                    <option value="Perlu tindak lanjut" {{ $statusFilter == 'Perlu tindak lanjut' ? 'selected' : '' }}>Perlu tindak lanjut</option>
                </select>
            </div>
        </div>

        <!-- 3-Column Responsive Grid of Student Cards -->
        <div class="student-cards-grid" id="cardsGridContainer">
            @forelse($studentCards as $card)
                <div class="student-card-box" style="cursor: pointer;" onclick="showSiswaDetailModal({{ $card['siswa']->id_siswa }})" data-name="{{ strtolower($card['siswa']->nama_siswa) }}" data-nis="{{ strtolower($card['siswa']->nis ?? '') }}" data-status="{{ strtolower($card['statusText']) }}" title="Klik untuk melihat detail profil siswa">
                    <div class="student-card-avatar">
                        {{ $card['initials'] }}
                    </div>
                    <div class="student-card-details">
                        <div class="student-card-name">{{ $card['siswa']->nama_siswa }}</div>
                        <div class="student-card-nis">NIS {{ $card['siswa']->nis }}</div>
                        <div class="student-card-pills">
                            <span class="pill-percent">{{ $card['persen'] }}% Hadir</span>
                            <span class="status-pill {{ $card['statusClass'] }}">
                                {{ $card['statusText'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 40px; background: #ffffff; border-radius: 16px;">
                    Belum ada siswa terdaftar di kelas perwalian ini.
                </div>
            @endforelse
        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 3: REKAP KEHADIRAN (CALENDAR HEATMAP 1-31 - MATCH IMAGE 4) -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-rekap_kehadiran" class="tab-content-panel {{ $tab == 'rekap_kehadiran' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Subheader & Month Selector -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #2563eb; text-transform: uppercase;">
                        KELAS PERWALIAN . {{ $namaKelas }}
                    </div>
                    <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Rekap Kehadiran</h2>
                    <p style="font-size: 13px; color: #64748b; font-weight: 600;">Riwayat kehadiran harian siswa per bulan</p>
                </div>

                <!-- Month Navigation Controller -->
                <div class="month-nav-box">
                    <a href="?tab=rekap_kehadiran&amp;id_kelas={{ $idKelasSelected }}&amp;bulan_selected={{ $prevBulan }}-{{ $prevTahun }}" class="month-nav-btn" title="Bulan Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                    <span class="month-nav-label">{{ $namaBulanTahun }}</span>
                    @if(!empty($canGoNextMonth))
                        <a href="?tab=rekap_kehadiran&amp;id_kelas={{ $idKelasSelected }}&amp;bulan_selected={{ $nextBulan }}-{{ $nextTahun }}" class="month-nav-btn" title="Bulan Berikutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="month-nav-btn" style="opacity: 0.35; cursor: not-allowed;" title="Bulan berikutnya belum dilalui">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- 4 Monthly Stat Cards Grid (From Image 4) -->
            <div class="stats-summary-grid" style="grid-template-columns: repeat(4, 1fr);">
                <!-- Card 1: Rata-rata Hadir (Tan / Light Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Rata-rata hadir</div>
                        <div class="number">{{ $rataRataHadirBulan }}%</div>
                    </div>
                    <div class="subtitle">kehadiran kelas bulan ini</div>
                </div>

                <!-- Card 2: Total Sakit (Dark Navy) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Total sakit</div>
                        <div class="number">{{ $totalSakitBulan }}</div>
                    </div>
                    <div class="subtitle">kejadian bulan ini</div>
                </div>

                <!-- Card 3: Total Izin (White) -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Total izin</div>
                        <div class="number">{{ $totalIzinBulan }}</div>
                    </div>
                    <div class="subtitle">kejadian bulan ini</div>
                </div>

                <!-- Card 4: Total Alpa (Tan / Light Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Total alpa</div>
                        <div class="number">{{ $totalAlpaBulan }}</div>
                    </div>
                    <div class="subtitle">kejadian tanpa keterangan</div>
                </div>
            </div>

            <!-- Peta Kehadiran Kelas (Calendar Heatmap Grid 1-31 from Image 4) -->
            <div class="card-heatmap-box">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Peta Kehadiran Kelas</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Rata-rata kehadiran kelas per hari sekolah, {{ $namaBulanTahun }} • <em>Klik pada kotak tanggal untuk melihat detail presensi & KBM</em></p>
                    </div>
                </div>

                <div class="heatmap-grid" style="margin-top: 18px;">
                    @foreach($calendarHeatmap as $hm)
                        @php
                            $tooltipText = 'Tanggal ' . $hm['day'] . ' ' . $namaBulanTahun;
                            if ($hm['is_today']) {
                                $tooltipText .= ' (HARI INI)';
                            }
                            if ($hm['is_weekend']) {
                                $tooltipText .= ' - Libur Akhir Pekan (Klik untuk lihat info)';
                            } elseif ($hm['is_future']) {
                                $tooltipText .= ' - Belum Dilalui (Klik untuk lihat info KBM)';
                            } else {
                                $tooltipText .= ' - ' . $hm['rate'] . '% Hadir (Klik untuk rincian presensi & KBM)';
                            }
                        @endphp
                        <div class="heat-box {{ $hm['type'] }} {{ $hm['is_today'] ? 'is-today' : '' }}" 
                             title="{{ $tooltipText }}"
                             onclick="showPetaDetailModal('{{ $hm['date'] }}', '{{ $hm['day'] }}', '{{ $namaKelas }}', {{ $idKelasSelected }})">
                            {{ $hm['day'] }}
                            @if($hm['is_today'])
                                <span class="today-badge-marker">HARI INI</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Legend Row -->
                <div class="heatmap-legend-row">
                    <div><span class="legend-indicator ind-95"></span> &ge;95% hadir</div>
                    <div><span class="legend-indicator ind-85"></span> 85-94% hadir</div>
                    <div><span class="legend-indicator ind-70"></span> 70-84% hadir</div>
                    <div><span class="legend-indicator ind-red"></span> &lt;70% hadir</div>
                    <div><span class="legend-indicator ind-holiday"></span> Libur/akhir pekan</div>
                    <div><span class="legend-indicator ind-future"></span> Belum dilalui</div>
                    <div><span class="legend-indicator ind-today"></span> Hari ini</div>
                </div>
            </div>

            <!-- Rekap per siswa . [Bulan Tahun] Table -->
            <div class="card-table-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Rekap per siswa . {{ $namaBulanTahun }}</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Akumulasi kehadiran sebulan</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <input type="text" id="rekap_table_search" class="input-custom" placeholder="Cari nama siswa..." onkeyup="filterRekapTableJs()">
                        <select id="rekap_table_status" class="select-custom" onchange="filterRekapTableJs()">
                            <option value="">Semua status</option>
                            <option value="Baik">Baik</option>
                            <option value="Perlu pantau">Perlu pantau</option>
                            <option value="Perlu tindak lanjut">Perlu tindak lanjut</option>
                        </select>
                        <a href="{{ route('guru.export-rekap-csv', ['id_kelas' => $idKelasSelected, 'bulan' => $bulanSelected, 'tahun' => $tahunSelected]) }}" class="btn-reset-gray">
                            <i class="fa-solid fa-download"></i> Unduh CSV
                        </a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-custom" id="rekapStudentTable">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th style="width: 70px; text-align: center;">Hadir</th>
                                <th style="width: 70px; text-align: center;">Sakit</th>
                                <th style="width: 70px; text-align: center;">Izin</th>
                                <th style="width: 70px; text-align: center;">Alpa</th>
                                <th style="width: 100px; text-align: center;">KEHADIRAN</th>
                                <th style="width: 110px; text-align: center;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapSiswa as $row)
                                <tr data-name="{{ strtolower($row['siswa']->nama_siswa) }}" data-status="{{ strtolower($row['statusText']) }}" style="cursor: pointer;" onclick="showSiswaDetailModal({{ $row['siswa']->id_siswa }})">
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($row['siswa']->nama_siswa, 0, 2)) }}
                                            </div>
                                            <div class="student-info">
                                                <div class="name">{{ $row['siswa']->nama_siswa }}</div>
                                                <div class="nis">NIS {{ $row['siswa']->nis ?? '240' . $row['siswa']->id_siswa }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #10b981;">
                                        {{ max(0, $hariEfektif - $row['total']) }}
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #b45309;">
                                        {{ $row['sakit'] }}
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #475569;">
                                        {{ $row['izin'] }}
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: {{ $row['alpa'] > 0 ? '#ef4444' : 'inherit' }};">
                                        {{ $row['alpa'] }}
                                    </td>
                                    <td style="text-align: center; font-weight: 800; color: #1e293b;">
                                        {{ $row['kehadiran'] }}%
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="status-pill {{ $row['statusClass'] }}">
                                            {{ $row['statusText'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                                        Tidak ditemukan data rekapitulasi siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 4: LAPORAN BULANAN (EXACT MATCH IMAGE 5)                   -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-laporan_bulanan" class="tab-content-panel {{ $tab == 'laporan_bulanan' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Subheader & Controls -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #2563eb; text-transform: uppercase;">
                        KELAS PERWALIAN . {{ $namaKelas }}
                    </div>
                    <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Laporan Bulanan</h2>
                    <p style="font-size: 13px; color: #64748b; font-weight: 600;">
                        {{ $namaBulanTahun }} . Dicetak {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }} oleh {{ Auth::user()->name }}
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <select class="select-custom" style="min-width: 170px; background: #ffffff;" onchange="location.href='?tab=laporan_bulanan&amp;id_kelas={{ $idKelasSelected }}&amp;bulan_selected='+this.value">
                        @foreach($availableMonthYears as $amy)
                            <option value="{{ $amy['val'] }}" {{ $amy['is_selected'] ? 'selected' : '' }}>
                                {{ $amy['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button" class="btn-filter-dark" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Cetak / Export
                    </button>
                </div>
            </div>

            <!-- 4 Monthly Summary Stat Cards (Image 5 Match) -->
            <div class="stats-summary-grid" style="grid-template-columns: repeat(4, 1fr);">
                <!-- Card 1: Rata-rata Kehadiran (Tan / Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Rata-rata kehadiran</div>
                        <div class="number">{{ $rataRataHadirBulan }}%</div>
                    </div>
                    <div class="subtitle">persentase kehadiran kelas</div>
                </div>

                <!-- Card 2: Hari Efektif (Dark Navy) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Hari efektif</div>
                        <div class="number">{{ $hariEfektif }}</div>
                    </div>
                    <div class="subtitle">hari sekolah bulan ini</div>
                </div>

                <!-- Card 3: Total Ketidakhadiran (White) -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Total ketidakhadiran</div>
                        <div class="number">{{ $totalKetidakhadiranBulan }}</div>
                    </div>
                    <div class="subtitle">sakit + izin + alpa</div>
                </div>

                <!-- Card 4: Siswa Perlu Tindak Lanjut (Tan / Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Siswa perlu tindak lanjut</div>
                        <div class="number">{{ $siswaPerluTindakLanjutCount }}</div>
                    </div>
                    <div class="subtitle">kehadiran dibawah 75% / alpa</div>
                </div>
            </div>

            <!-- Middle Section 2 Column: Ringkasan & Perlu Perhatian -->
            <div class="grid-rekap-rincian">
                <!-- Left Column: Ringkasan kehadiran per siswa -->
                <div class="card-table-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
                        <div>
                            <h3 style="margin-bottom: 2px;">Ringkasan kehadiran per siswa</h3>
                            <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Seluruh siswa kelas {{ $namaKelas }}, {{ $namaBulanTahun }}</p>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <input type="text" id="laporan_table_search" class="input-custom" placeholder="Cari nama / NIS..." onkeyup="filterLaporanTableJs()" style="min-width: 170px;">
                            <select id="laporan_table_status" class="select-custom" onchange="filterLaporanTableJs()" style="min-width: 140px;">
                                <option value="">Semua status</option>
                                <option value="Baik">Baik</option>
                                <option value="Perlu pantau">Perlu pantau</option>
                                <option value="Perlu tindak lanjut">Perlu tindak lanjut</option>
                            </select>
                            <button type="button" class="btn-reset-gray" onclick="resetLaporanTableJs()" title="Reset pencarian &amp; filter">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table-custom" id="laporanStudentTable">
                            <thead>
                                <tr>
                                    <th>SISWA</th>
                                    <th style="width: 45px; text-align: center;">H</th>
                                    <th style="width: 45px; text-align: center;">S</th>
                                    <th style="width: 45px; text-align: center;">I</th>
                                    <th style="width: 45px; text-align: center;">A</th>
                                    <th style="width: 60px; text-align: center;">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekapSiswa as $row)
                                    <tr data-name="{{ strtolower($row['siswa']->nama_siswa) }} {{ strtolower($row['siswa']->nis ?? '') }}" data-status="{{ strtolower($row['statusText']) }}" style="cursor: pointer;" onclick="showSiswaDetailModal({{ $row['siswa']->id_siswa }})" title="Klik untuk lihat detail siswa {{ $row['siswa']->nama_siswa }}">
                                        <td>
                                            <div class="student-cell">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($row['siswa']->nama_siswa, 0, 2)) }}
                                                </div>
                                                <div class="student-info">
                                                    <div class="name">{{ $row['siswa']->nama_siswa }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-weight: 700; color: #10b981;">{{ max(0, $hariEfektif - $row['total']) }}</td>
                                        <td style="text-align: center; font-weight: 700; color: #b45309;">{{ $row['sakit'] }}</td>
                                        <td style="text-align: center; font-weight: 700; color: #475569;">{{ $row['izin'] }}</td>
                                        <td style="text-align: center; font-weight: 700; color: {{ $row['alpa'] > 0 ? '#ef4444' : 'inherit' }};">{{ $row['alpa'] }}</td>
                                        <td style="text-align: center; font-weight: 800; color: #1e293b;">{{ $row['kehadiran'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Column: Perlu Perhatian Ranked List (Image 5 Match) -->
                <div class="perlu-perhatian-card">
                    <h3>Perlu perhatian</h3>
                    <p>Kehadiran terendah bulan ini</p>

                    <div class="rank-list">
                        @foreach($perluPerhatianList as $item)
                            <div class="rank-item" style="cursor: pointer;" onclick="showSiswaDetailModal({{ $item['id_siswa'] }})" title="Klik untuk lihat detail siswa {{ $item['nama'] }}">
                                <div class="rank-left">
                                    <span class="rank-num">{{ $item['rank'] }}</span>
                                    <div class="rank-avatar">{{ $item['initials'] }}</div>
                                    <div class="rank-info">
                                        <div class="r-name">{{ $item['nama'] }}</div>
                                        <div class="r-sub">{{ $item['subtext'] }}</div>
                                    </div>
                                </div>
                                <span class="rank-badge">{{ $item['persen'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Catatan Wali Kelas Evaluation Box (Image 5 Match) -->
            <div class="catatan-wali-box">
                <h3>Catatan Wali Kelas</h3>
                <p>Ringkasan untuk kepala sekolah / orang tua</p>

                <div class="catatan-content-area">
                    {{ $catatanWaliKelasDefault }}
                </div>
            </div>

        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 5: SURAT IZIN / SAKIT (EXACT MATCH IMAGE 6)               -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-surat_izin" class="tab-content-panel {{ $tab == 'surat_izin' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Subheader Banner -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #2563eb; text-transform: uppercase;">
                        KELAS PERWALIAN . {{ $namaKelas }}
                    </div>
                    <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Surat Izin &amp; Sakit</h2>
                    <p style="font-size: 13px; color: #64748b; font-weight: 600;">Pengajuan dari siswa / orang tua yg masuk</p>
                </div>
            </div>

            <!-- 3 Stat Cards Grid (Image 6 Match) -->
            <div class="stats-summary-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Card 1: Menunggu verifikasi (Tan / Gold) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Menunggu verifikasi</div>
                        <div class="number">{{ $menungguVerifikasiCount }}</div>
                    </div>
                    <div class="subtitle">perlu ditinjau</div>
                </div>

                <!-- Card 2: Terverifikasi (Dark Navy) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Terverifikasi</div>
                        <div class="number">{{ $terverifikasiCount }}</div>
                    </div>
                    <div class="subtitle">resmi terdaftar</div>
                </div>

                <!-- Card 3: Tanpa keterangan (White) -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Tanpa keterangan</div>
                        <div class="number">{{ $tanpaKeteranganCount }}</div>
                    </div>
                    <div class="subtitle">belum ada surat masuk</div>
                </div>
            </div>

            <!-- Daftar Pengajuan Table Box (Image 6 Match) -->
            <div class="card-table-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Daftar Pengajuan</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Terbaru di atas</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="surat_search_input" class="input-custom" placeholder="Cari nama siswa..." onkeyup="filterSuratTableJs()" style="min-width: 180px;">

                        <select id="surat_jenis_filter" class="select-custom" onchange="filterSuratTableJs()">
                            <option value="">Semua jenis</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                        </select>

                        <select id="surat_status_filter" class="select-custom" onchange="filterSuratTableJs()">
                            <option value="">Semua status</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>

                        <!-- Button Hapus Terpilih -->
                        <button type="button" id="btnBulkDeleteSurat" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 12px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; opacity: 0.5;" onclick="submitBulkDeleteSurat()" disabled>
                            <i class="fa-solid fa-trash"></i> Hapus Terpilih (<span id="suratSelectedCount">0</span>)
                        </button>

                        <!-- Button Sampah -->
                        <button type="button" id="btnOpenSuratTrash" style="background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; padding: 8px 14px; border-radius: 12px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" onclick="openSuratTrashModal()">
                            <i class="fa-solid fa-trash-can"></i> Sampah @if($suratIzinTrashCount > 0)<span style="background: #dc2626; color: #ffffff; padding: 2px 7px; border-radius: 10px; font-size: 11px;">{{ $suratIzinTrashCount }}</span>@endif
                        </button>
                    </div>
                </div>

                <form id="bulkDeleteSuratForm" action="{{ route('guru.surat-izin.destroy-batch') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div id="bulkDeleteSuratInputs"></div>
                </form>

                <div style="overflow-x: auto;">
                    <table class="table-custom" id="suratPengajuanTable">
                        <thead>
                            <tr>
                                <th style="width: 38px; text-align: center;">
                                    <input type="checkbox" id="selectAllSurat" onchange="toggleSelectAllSurat(this)" style="cursor: pointer; width: 16px; height: 16px;">
                                </th>
                                <th style="width: 45px; text-align: center;">NO</th>
                                <th>SISWA</th>
                                <th style="width: 140px; text-align: center;">JENIS KATEGORI</th>
                                <th style="width: 160px;">TANGGAL ABSEN</th>
                                <th style="width: 115px;">DIAJUKAN</th>
                                <th style="width: 160px;">LAMPIRAN / BUKTI</th>
                                <th style="width: 140px;">PETUGAS PIKET</th>
                                <th style="width: 115px; text-align: center;">STATUS</th>
                                <th style="width: 90px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratPengajuanList as $surat)
                                <tr data-name="{{ strtolower($surat['nama']) }}" data-jenis="{{ strtolower($surat['jenis']) }}" data-status="{{ strtolower($surat['status']) }}" data-keterangan="{{ strtolower($surat['keterangan']) }}">
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="surat-row-checkbox" value="{{ $surat['id_surat_izin'] }}" onchange="updateSuratSelectedCount()" style="cursor: pointer; width: 16px; height: 16px;">
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 12px;">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                {{ $surat['initials'] }}
                                            </div>
                                            <div class="student-info">
                                                <div class="name">{{ $surat['nama'] }}</div>
                                                <div class="nis">NIS: {{ $surat['nis'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($surat['jenis'] == 'Dispen Luar Sekolah')
                                            <span class="badge" style="background: #f3e8ff; color: #6d28d9; border: 1px solid #ddd6fe; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                                                <i class="fa-solid fa-award"></i> Dispen Luar
                                            </span>
                                        @elseif($surat['jenis'] == 'Sakit')
                                            <span class="badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                                                <i class="fa-solid fa-notes-medical"></i> Sakit
                                            </span>
                                        @else
                                            <span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                                                <i class="fa-solid fa-envelope-open-text"></i> Izin
                                            </span>
                                        @endif
                                    </td>
                                    <td style="font-weight: 700; font-size: 12.5px;">{{ $surat['tgl_absen'] }}</td>
                                    <td style="font-size: 12.5px; color: #475569;">{{ $surat['diajukan'] }}</td>
                                    <td style="font-size: 12.5px; color: #1e293b; font-weight: 600;">
                                        @if(!empty($surat['foto_url']))
                                            <button type="button" class="btn-action-icon btn-preview" style="background: #f3e8ff; color: #7c3aed; padding: 4px 10px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;" onclick="showWaliFotoModal('{{ $surat['foto_url'] }}', '{{ $surat['nama'] }} - {{ $surat['jenis'] }}')">
                                                <i class="fa-solid fa-image"></i> Lihat Foto Surat
                                            </button>
                                        @else
                                            <span style="color: #64748b; font-size: 12px;">{{ $surat['lampiran'] }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 12px; color: #475569; font-weight: 600;">
                                        {{ $surat['petugas'] ?? 'Guru Piket' }}
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="status-pill {{ $surat['statusClass'] }}">
                                            {{ $surat['status'] }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            <button type="button" class="btn-action-icon" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;" onclick="showWaliSuratDetailModal({{ $surat['id_surat_izin'] }})" title="Lihat Detail Lengkap">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;" onclick="confirmDeleteSingleSurat({{ $surat['id_surat_izin'] }}, '{{ addslashes($surat['nama']) }}')" title="Pindahkan ke Sampah">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center; color: #94a3b8; padding: 30px;">
                                        Belum ada pengajuan surat izin atau sakit yang dicatat untuk kelas perwalian ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 6: SURAT DISPEN SISWA (DISPENSASI KELAS PERWALIAN)        -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-surat_dispen" class="tab-content-panel {{ $tab == 'surat_dispen' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Subheader Banner -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #2563eb; text-transform: uppercase;">
                        KELAS PERWALIAN • {{ $namaKelas }}
                    </div>
                    <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Surat Dispensasi Siswa</h2>
                    <p style="font-size: 13px; color: #64748b; font-weight: 600;">Monitoring izin meninggalkan KBM / kegiatan luar sekolah</p>
                </div>
            </div>

            <!-- 3 Stat Cards Grid (From User Screenshot) -->
            <div class="stats-summary-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Card 1: Total Dispensasi -->
                <div class="stat-card-item">
                    <div>
                        <div class="title">Total Dispensasi</div>
                        <div class="number">{{ $dispenTotalCount ?? $dispenList->count() }}</div>
                    </div>
                    <div class="subtitle">di kelas {{ $namaKelas }}</div>
                </div>

                <!-- Card 2: Disetujui Waka / Piket (Dark Navy) -->
                <div class="stat-card-item dark-blue">
                    <div>
                        <div class="title">Disetujui Waka / Piket</div>
                        <div class="number">{{ $dispenDisetujuiCount ?? $dispenList->where('status_waka', 'approved')->count() }}</div>
                    </div>
                    <div class="subtitle">resmi terverifikasi</div>
                </div>

                <!-- Card 3: Menunggu Persetujuan (Tan) -->
                <div class="stat-card-item tan-bg">
                    <div>
                        <div class="title">Menunggu Persetujuan</div>
                        <div class="number">{{ $dispenMenungguCount ?? $dispenList->where('status_waka', 'pending')->count() }}</div>
                    </div>
                    <div class="subtitle">proses verifikasi</div>
                </div>
            </div>

            <!-- Daftar Dispensasi Table Box -->
            <div class="card-table-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Daftar Surat Dispensasi Siswa</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 0;">Riwayat dispensasi siswa kelas perwalian</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="dispen_search_input" class="input-custom" placeholder="Cari nama siswa..." onkeyup="filterDispenTableJs()" style="min-width: 180px;">

                        <select id="dispen_status_filter" class="select-custom" onchange="filterDispenTableJs()">
                            <option value="">Semua status</option>
                            <option value="approved">Disetujui</option>
                            <option value="pending">Menunggu</option>
                            <option value="rejected">Ditolak</option>
                        </select>

                        <!-- Button Hapus Terpilih -->
                        <button type="button" id="btnBulkDeleteDispen" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 12px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; opacity: 0.5;" onclick="submitBulkDeleteDispen()" disabled>
                            <i class="fa-solid fa-trash"></i> Hapus Terpilih (<span id="dispenSelectedCount">0</span>)
                        </button>

                        <!-- Button Sampah -->
                        <button type="button" id="btnOpenDispenTrash" style="background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; padding: 8px 14px; border-radius: 12px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" onclick="openDispenTrashModal()">
                            <i class="fa-solid fa-trash-can"></i> Sampah @if(($dispenTrashCount ?? 0) > 0)<span style="background: #dc2626; color: #ffffff; padding: 2px 7px; border-radius: 10px; font-size: 11px;">{{ $dispenTrashCount }}</span>@endif
                        </button>
                    </div>
                </div>

                <form id="bulkDeleteDispenForm" action="{{ route('guru.surat-dispen.destroy-batch') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div id="bulkDeleteDispenInputs"></div>
                </form>

                <div style="overflow-x: auto;">
                    <table class="table-custom" id="dispenTable">
                        <thead>
                            <tr>
                                <th style="width: 38px; text-align: center;">
                                    <input type="checkbox" id="selectAllDispen" onchange="toggleSelectAllDispen(this)" style="cursor: pointer; width: 16px; height: 16px;">
                                </th>
                                <th style="width: 45px; text-align: center;">NO</th>
                                <th>SISWA</th>
                                <th style="width: 170px;">KATEGORI</th>
                                <th style="width: 150px;">TANGGAL &amp; JAM</th>
                                <th>ALASAN DISPENSASI</th>
                                <th style="width: 130px; text-align: center;">STATUS WAKA</th>
                                <th style="width: 130px; text-align: center;">STATUS SATPAM</th>
                                <th style="width: 90px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dispenList as $disp)
                                <tr data-name="{{ strtolower($disp->siswa->nama_siswa ?? '') }}" data-status="{{ strtolower($disp->status_waka) }}" data-kategori="{{ strtolower($disp->tempat ?? '') }}" data-alasan="{{ strtolower($disp->alasan ?? '') }}">
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="dispen-row-checkbox" value="{{ $disp->id_siswa_dispen }}" onchange="updateDispenSelectedCount()" style="cursor: pointer; width: 16px; height: 16px;">
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 12px;">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($disp->siswa->nama_siswa ?? 'S', 0, 2)) }}
                                            </div>
                                            <div class="student-info">
                                                <div class="name">{{ $disp->siswa->nama_siswa ?? 'Siswa' }}</div>
                                                <div class="nis">NIS: {{ $disp->siswa->nis ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #f3e8ff; color: #6d28d9; border: 1px solid #ddd6fe; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                                            <i class="fa-solid fa-location-dot" style="font-size: 10px; margin-right: 2px;"></i> {{ $disp->tempat ?? 'Kegiatan Sekolah' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 12.5px; font-weight: 700; color: #1e293b;">
                                        {{ \Carbon\Carbon::parse($disp->tanggal)->translatedFormat('d M Y') }}
                                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">
                                            {{ substr($disp->jam_keluar ?? '07:00', 0, 5) }} - {{ substr($disp->jam_kembali ?? '15:00', 0, 5) }} WIB
                                        </div>
                                    </td>
                                    <td style="font-size: 12.5px; color: #334155;">
                                        {{ $disp->alasan ?? '-' }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if($disp->status_waka == 'approved')
                                            <span class="status-pill success">Disetujui</span>
                                        @elseif($disp->status_waka == 'rejected')
                                            <span class="status-pill danger">Ditolak</span>
                                        @else
                                            <span class="status-pill warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($disp->status_satpam == 'sudah_keluar')
                                            <span class="status-pill warning" style="background: #fef3c7; color: #b45309; border-color: #fde68a;">
                                                <i class="fa-solid fa-person-walking-arrow-right"></i> Keluar
                                            </span>
                                        @elseif($disp->status_satpam == 'sudah_kembali')
                                            <span class="status-pill success">
                                                <i class="fa-solid fa-house-chimney"></i> Kembali
                                            </span>
                                        @else
                                            <span class="status-pill" style="background: #f1f5f9; color: #475569; border-color: #cbd5e1;">Belum Keluar</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            <button type="button" class="btn-action-icon" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;" onclick="showWaliDispenDetailModal({{ $disp->id_siswa_dispen }})" title="Lihat Detail Lengkap">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;" onclick="confirmDeleteSingleDispen({{ $disp->id_siswa_dispen }}, '{{ addslashes($disp->siswa->nama_siswa ?? 'Siswa') }}')" title="Pindahkan ke Sampah">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; color: #94a3b8; padding: 30px;">
                                        Belum ada surat dispensasi yang dicatat untuk kelas perwalian ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- ───────────────────────────────────────────────────────────── -->
    <!-- TAB 7: PENGATURAN (EXACT MATCH IMAGE 7)                       -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-pengaturan" class="tab-content-panel {{ $tab == 'pengaturan' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Session Notifications Alert Banner -->
            @if(session('success'))
                <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #047857; padding: 12px 18px; border-radius: 14px; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i> {{ session('success') }}
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 18px; border-radius: 14px; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 16px;"></i> {{ $errors->first() }}
                </div>
            @endif

            <!-- Subheader Banner -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #b45309; text-transform: uppercase;">
                        Akun &amp; Preferensi
                    </div>
                    <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Pengaturan</h2>
                    <p style="font-size: 13px; color: #64748b; font-weight: 600;">Kelola profil, notifikasi, dan preferensi kelas perwalian</p>
                </div>
                <div>
                    <button type="button" class="btn-filter-dark" style="display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; padding: 10px 18px; border-radius: 12px; font-family: inherit;" onclick="openWaliEditProfilModal()">
                        <i class="fa-solid fa-user-gear"></i> EDIT PROFIL &amp; GANTI PASSWORD
                    </button>
                </div>
            </div>

            <!-- Toast Notification Container for Settings Feedback -->
            <div id="waliToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 99999; display: flex; flex-direction: column; gap: 10px;"></div>

            <!-- Settings Layout Grid (Left Menu + Right Cards - Image 7 Match) -->
            <div class="settings-layout-grid">
                <!-- Left Sub-Menu Navigation Card -->
                <div class="settings-sidebar-card">
                    <a class="settings-sub-item active" id="nav-setting-profil" onclick="scrollSettingSection('setting-profil', this)">Profil</a>
                    <a class="settings-sub-item" id="nav-setting-kelas" onclick="scrollSettingSection('setting-kelas', this)">Kelas perwalian</a>
                    <a class="settings-sub-item" id="nav-setting-notifikasi" onclick="scrollSettingSection('setting-notifikasi', this)">Notifikasi</a>
                    <a class="settings-sub-item" id="nav-setting-ambang-batas" onclick="scrollSettingSection('setting-ambang-batas', this)">Ambang batas alpa</a>
                    <a class="settings-sub-item" id="nav-setting-keamanan" onclick="scrollSettingSection('setting-keamanan', this)">Keamanan akun</a>
                </div>

                <!-- Right Settings Content Cards -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Card 1: Profil -->
                    <div id="setting-profil" class="settings-card-section">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3>Profil</h3>
                                <p style="margin-bottom: 0;">Informasi ini tampil di header dashboard</p>
                            </div>
                            <button type="button" class="btn-reset-gray" style="font-size: 12px; padding: 6px 14px; display: inline-flex; align-items: center; gap: 6px;" onclick="openWaliEditProfilModal()">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                        </div>

                        <div class="settings-field-row">
                            <label>Nama Lengkap</label>
                            <div class="readonly-field-tan">{{ $guruNama }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>NIP</label>
                            <div class="readonly-field-tan">{{ $guruNip }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>Email</label>
                            <div class="readonly-field-tan">{{ $guruEmail }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>No. HP / WhatsApp</label>
                            <div class="readonly-field-tan">{{ $guruNoHp }}</div>
                        </div>
                    </div>

                    <!-- Card 2: Kelas perwalian -->
                    <div id="setting-kelas" class="settings-card-section">
                        <div>
                            <h3>Kelas perwalian</h3>
                            <p style="margin-bottom: 0;">Kelas yang kamu pantau kehadirannya</p>
                        </div>

                        <div class="settings-field-row">
                            <label>Kelas</label>
                            <div class="readonly-field-tan">{{ $namaKelas }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>Jumlah Siswa</label>
                            <div class="readonly-field-tan">{{ $totalSiswa }} Siswa Terdaftar</div>
                        </div>

                        <div class="settings-field-row">
                            <label>Wali Kelas</label>
                            <div class="readonly-field-tan">{{ $guruNama }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>Tahun ajaran</label>
                            <div class="readonly-field-tan">{{ $tahunAjaranAktif }}</div>
                        </div>
                    </div>

                    <!-- Card 3: Notifikasi -->
                    <div id="setting-notifikasi" class="settings-card-section">
                        <div>
                            <h3>Notifikasi</h3>
                            <p style="margin-bottom: 0;">Atur kapan kamu mau diingatkan</p>
                        </div>

                        <div class="settings-field-row" style="align-items: center;">
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Surat izin/sakit baru masuk</div>
                                <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi saat ada pengajuan menunggu verifikasi</div>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="toggle_notif_surat" checked onchange="saveNotificationPref('Surat izin/sakit baru masuk', this.checked)">
                                    <span class="slider-round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="settings-field-row" style="align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Rekapitulasi presensi harian kelas</div>
                                <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pemberitahuan rangkuman presensi harian kelas perwalian</div>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="toggle_notif_rekap" checked onchange="saveNotificationPref('Rekapitulasi presensi harian', this.checked)">
                                    <span class="slider-round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="settings-field-row" style="align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pengajuan dispensasi siswa disetujui</div>
                                <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pemberitahuan saat siswa kelas perwalian mendapat izin dispensasi</div>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="toggle_notif_dispen" checked onchange="saveNotificationPref('Pengajuan dispensasi siswa', this.checked)">
                                    <span class="slider-round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Ambang batas alpa -->
                    <div id="setting-ambang-batas" class="settings-card-section">
                        <div>
                            <h3>Ambang batas alpa &amp; Kategori Pantau</h3>
                            <p style="margin-bottom: 0;">Tentukan batas ketidakhadiran untuk pengelompokan siswa perlu tindak lanjut</p>
                        </div>

                        <div class="settings-field-row">
                            <label style="width: 200px;">Batas Maksimal Alpa Bulanan</label>
                            <select id="sel_batas_alpa" class="select-custom" style="width: 100%; background: #ffffff;">
                                <option value="2">2x Alpa per Bulan</option>
                                <option value="3" selected>3x Alpa per Bulan (Rekomendasi Default)</option>
                                <option value="5">5x Alpa per Bulan</option>
                            </select>
                        </div>

                        <div class="settings-field-row">
                            <label style="width: 200px;">Batas Persentase Kehadiran Minimum</label>
                            <select id="sel_batas_persen" class="select-custom" style="width: 100%; background: #ffffff;">
                                <option value="75" selected>75% Minimum Kehadiran (Standar Kelulusan)</option>
                                <option value="80">80% Minimum Kehadiran</option>
                                <option value="85">85% Minimum Kehadiran</option>
                            </select>
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 6px;">
                            <button type="button" class="btn-filter-dark" onclick="saveAmbangBatasPref()">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Preferensi Ambang Batas
                            </button>
                        </div>
                    </div>

                    <!-- Card 5: Keamanan akun -->
                    <div id="setting-keamanan" class="settings-card-section">
                        <div>
                            <h3>Keamanan akun</h3>
                            <p style="margin-bottom: 0;">Kelola kata sandi akun untuk menjaga keamanan akses portal</p>
                        </div>

                        <form action="{{ route('pengaturan.update-password') }}" method="POST" id="formKeamananPassword">
                            @csrf
                            <div style="display: flex; flex-direction: column; gap: 14px;">
                                <div class="settings-field-row">
                                    <label style="width: 180px;">Password Saat Ini</label>
                                    <input type="password" name="current_password" class="input-custom" placeholder="Masukkan password lama..." required style="width: 100%;">
                                </div>

                                <div class="settings-field-row">
                                    <label style="width: 180px;">Password Baru</label>
                                    <input type="password" name="password" class="input-custom" placeholder="Minimal 6 karakter..." required style="width: 100%;">
                                </div>

                                <div class="settings-field-row">
                                    <label style="width: 180px;">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="input-custom" placeholder="Ketik ulang password baru..." required style="width: 100%;">
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; flex-wrap: wrap; gap: 10px;">
                                    <div style="font-size: 12px; color: #10b981; font-weight: 700;">
                                        <i class="fa-solid fa-shield-halved"></i> Status Keamanan: Terenkripsi Bcrypt
                                    </div>
                                    <button type="submit" class="btn-filter-dark">
                                        <i class="fa-solid fa-key"></i> Perbarui Password Akun
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- ───────────────────────────────────────────────────────────── -->
<!-- MODAL: DETAIL LENGKAP PROFIL & PRESENSI SISWA                 -->
<!-- ───────────────────────────────────────────────────────────── -->
<div id="siswaDetailModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeSiswaDetailModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="modalSiswaAvatar" style="width: 44px; height: 44px; border-radius: 50%; background: #384972; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px;">
                    S
                </div>
                <div>
                    <h3 id="modalSiswaNama" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Nama Siswa</h3>
                    <p id="modalSiswaNis" style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">NIS: - | Kelas: {{ $namaKelas }}</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeSiswaDetailModal('closeBtn')">&times;</button>
        </div>
        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
            <!-- 4 Quick Stats -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kehadiran</div>
                    <div id="modalStatPersen" style="font-size: 20px; font-weight: 800; color: #2563eb;">100%</div>
                </div>
                <div style="background: #fef3c7; border: 1px solid #fde68a; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase;">Sakit</div>
                    <div id="modalStatSakit" style="font-size: 20px; font-weight: 800; color: #b45309;">0</div>
                </div>
                <div style="background: #e0f2fe; border: 1px solid #bae6fd; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase;">Izin</div>
                    <div id="modalStatIzin" style="font-size: 20px; font-weight: 800; color: #0369a1;">0</div>
                </div>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #b91c1c; text-transform: uppercase;">Alpa</div>
                    <div id="modalStatAlpa" style="font-size: 20px; font-weight: 800; color: #b91c1c;">0</div>
                </div>
            </div>

            <!-- Bio Details -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 10px;">
                <div style="font-size: 13px; font-weight: 800; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                    <i class="fa-solid fa-id-card" style="color: #3b82f6;"></i> Informasi Pribadi &amp; Kontak Wali
                </div>
                <div style="display: grid; grid-template-columns: 140px 1fr; gap: 6px; font-size: 12.5px;">
                    <div style="color: #64748b; font-weight: 600;">NISN:</div>
                    <div id="modalBioNisn" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Jenis Kelamin:</div>
                    <div id="modalBioJk" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Tempat, Tgl Lahir:</div>
                    <div id="modalBioTtl" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Orang Tua / Wali:</div>
                    <div id="modalBioWali" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">No. HP Wali:</div>
                    <div id="modalBioHp" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Alamat:</div>
                    <div id="modalBioAlamat" style="font-weight: 700; color: #0f172a;">-</div>
                </div>
            </div>

            <!-- Riwayat Catatan Presensi -->
            <div>
                <div style="font-size: 13px; font-weight: 800; color: #1e293b; margin-bottom: 8px;">
                    <i class="fa-solid fa-clock-rotate-left" style="color: #f59e0b;"></i> Riwayat Ketidakhadiran &amp; Jurnal
                </div>
                <div id="modalRiwayatContainer" style="max-height: 180px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <!-- Injected by JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Bukti Surat (Wali Kelas View) -->
<div id="waliFotoModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeWaliFotoModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <h3 id="waliModalFotoTitle" style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Foto Bukti Fisik Surat Izin</h3>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer;" onclick="closeWaliFotoModal('closeBtn')">&times;</button>
        </div>
        <div class="modal-body" style="padding: 24px; text-align: center;">
            <img id="waliModalFotoImg" src="" alt="Foto Bukti Surat Izin Siswa" style="max-width: 100%; max-height: 70vh; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    </div>
</div>

<!-- Modal Detail Presensi & Jurnal Harian (Peta Kehadiran Kelas) -->
<div id="modalPetaDetail" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closePetaDetailModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="petaModalDateIcon" style="width: 44px; height: 44px; border-radius: 12px; background: #384972; color: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 800;">
                    <span id="petaModalDayNum" style="font-size: 16px; line-height: 1;">12</span>
                    <span id="petaModalMonthShort" style="font-size: 9px; text-transform: uppercase;">SEP</span>
                </div>
                <div>
                    <h3 id="petaModalTitle" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Detail Presensi Harian</h3>
                    <p id="petaModalSubtitle" style="font-size: 12.5px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">Kelas {{ $namaKelas }}</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 16px;" onclick="closePetaDetailModal('closeBtn')">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 18px;">
            <!-- Status Badge / Alert Banner if weekend / future / today -->
            <div id="petaModalAlertBanner" style="display: none; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600;"></div>

            <!-- 4 Mini Stat Cards -->
            <div id="petaModalStatsGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">Kehadiran</div>
                    <div id="petaModalRate" style="font-size: 20px; font-weight: 800; color: #047857;">100%</div>
                    <div id="petaModalHadirSub" style="font-size: 10.5px; color: #065f46; font-weight: 600;">32 Hadir</div>
                </div>
                <div style="background: #fef3c7; border: 1px solid #fde68a; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase;">Sakit</div>
                    <div id="petaModalSakit" style="font-size: 20px; font-weight: 800; color: #b45309;">0</div>
                    <div style="font-size: 10.5px; color: #92400e; font-weight: 600;">siswa</div>
                </div>
                <div style="background: #e0f2fe; border: 1px solid #bae6fd; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase;">Izin / Dispen</div>
                    <div id="petaModalIzin" style="font-size: 20px; font-weight: 800; color: #0369a1;">0</div>
                    <div style="font-size: 10.5px; color: #075985; font-weight: 600;">siswa</div>
                </div>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #b91c1c; text-transform: uppercase;">Alpa</div>
                    <div id="petaModalAlpa" style="font-size: 20px; font-weight: 800; color: #b91c1c;">0</div>
                    <div style="font-size: 10.5px; color: #991b1b; font-weight: 600;">siswa</div>
                </div>
            </div>

            <!-- Daftar Siswa Tidak Hadir -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="font-size: 13px; font-weight: 800; color: #1e293b;">
                        <i class="fa-solid fa-user-xmark" style="color: #ef4444;"></i> Siswa Tidak Hadir / Izin / Dispen
                    </div>
                    <span id="petaModalAbsenCountBadge" style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: #f1f5f9; color: #475569;">0 Siswa</span>
                </div>
                <div id="petaModalAbsenContainer" style="max-height: 180px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <!-- Injected by JS -->
                </div>
            </div>

            <!-- Daftar Jurnal KBM yang Berlangsung -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="font-size: 13px; font-weight: 800; color: #1e293b;">
                        <i class="fa-solid fa-book-open-reader" style="color: #3b82f6;"></i> Jurnal Kegiatan Belajar Mengajar (KBM)
                    </div>
                    <span id="petaModalJurnalCountBadge" style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: #eff6ff; color: #1e40af;">0 Sesi</span>
                </div>
                <div id="petaModalJurnalContainer" style="max-height: 180px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <!-- Injected by JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil Wali Kelas -->
<div id="waliEditProfilModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeWaliEditProfilModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 560px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Edit Profil Wali Kelas</h3>
                    <p style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">Perbarui informasi diri &amp; kontak akun Anda</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeWaliEditProfilModal('closeBtn')">&times;</button>
        </div>

        <form action="{{ route('pengaturan.update-profile') }}" method="POST" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            @csrf
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Nama Lengkap &amp; Gelar</label>
                <input type="text" name="name" class="input-custom" value="{{ $guruNama }}" required style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">NIP (Nomor Induk Pegawai)</label>
                <input type="text" class="input-custom" value="{{ $guruNip }}" readonly style="width: 100%; background: #f8fafc; color: #64748b; cursor: not-allowed;">
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 4px;">NIP adalah identitas resmi dan tidak dapat diubah sendiri.</div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Alamat Email Active</label>
                <input type="email" name="email" class="input-custom" value="{{ $guruEmail }}" placeholder="contoh@domain.com" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">No. HP / WhatsApp</label>
                <input type="text" name="no_hp" class="input-custom" value="{{ $guruNoHp }}" placeholder="08xxxxxxxxxx" style="width: 100%;">
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-size: 12.5px; color: #475569; display: flex; align-items: center; justify-content: space-between;">
                <span><strong>Kelas Perwalian:</strong> {{ $namaKelas }}</span>
                <span><strong>Tahun Ajaran:</strong> {{ $tahunAjaranAktif }}</span>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="button" class="btn-reset-gray" style="padding: 10px 18px;" onclick="closeWaliEditProfilModal('closeBtn')">Batal</button>
                <button type="submit" class="btn-filter-dark" style="padding: 10px 20px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Lengkap Surat Izin Siswa (Wali Kelas View) -->
<div id="waliSuratDetailModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeWaliSuratDetailModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="detailSuratAvatar" style="width: 44px; height: 44px; border-radius: 50%; background: #384972; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px;">
                    S
                </div>
                <div>
                    <h3 id="detailSuratNama" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Nama Siswa</h3>
                    <p id="detailSuratSub" style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">NIS: - | Kelas: {{ $namaKelas }}</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeWaliSuratDetailModal('closeBtn')">&times;</button>
        </div>

        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Jenis Kategori</div>
                    <div id="detailSuratKategori" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Status Pengajuan</div>
                    <div id="detailSuratStatus" style="font-size: 15px; font-weight: 800; color: #059669; margin-top: 2px;">-</div>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 10px; font-size: 12.5px;">
                <div style="display: grid; grid-template-columns: 140px 1fr; gap: 6px;">
                    <div style="color: #64748b; font-weight: 600;">Tanggal Izin:</div>
                    <div id="detailSuratRentang" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Durasi:</div>
                    <div id="detailSuratDurasi" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Waktu Pengajuan:</div>
                    <div id="detailSuratDiajukan" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Petugas Verifikator:</div>
                    <div id="detailSuratPetugas" style="font-weight: 700; color: #0f172a;">-</div>
                </div>

                <div style="border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 4px;">
                    <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Keterangan / Alasan:</div>
                    <div id="detailSuratKeterangan" style="font-size: 13px; color: #1e293b; background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-weight: 600; line-height: 1.5;">-</div>
                </div>
            </div>

            <!-- Lampiran Preview Section -->
            <div id="detailSuratFotoSection" style="display: none; text-align: center; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px;">
                <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px; text-align: left;"><i class="fa-solid fa-paperclip"></i> Foto Bukti Fisik / Surat Keterangan:</div>
                <img id="detailSuratFotoImg" src="" alt="Bukti Surat" style="max-width: 100%; max-height: 250px; border-radius: 10px; object-fit: contain; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer;" onclick="showWaliFotoModal(this.src, 'Bukti Surat Izin Siswa')">
            </div>
        </div>

        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" class="btn-reset-gray" onclick="closeWaliSuratDetailModal('closeBtn')">Tutup Detail</button>
        </div>
    </div>
</div>

<!-- Modal Manajemen Sampah Surat Izin Siswa (Wali Kelas) -->
<div id="waliSuratIzinTrashModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeSuratTrashModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 780px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Sampah Surat Izin &amp; Sakit Siswa</h3>
                    <p style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">Daftar surat izin kelas {{ $namaKelas }} yang telah dihapus sementara (Soft Deleted)</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeSuratTrashModal('closeBtn')">&times;</button>
        </div>

        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            @if($suratIzinTrashList->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa-solid fa-trash-can-arrow-up" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1;"></i>
                    <h4 style="font-size: 16px; font-weight: 700; color: #475569; margin: 0;">Sampah Masih Kosong</h4>
                    <p style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Tidak ada data surat izin siswa yang berada di dalam sampah.</p>
                </div>
            @else
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; flex-wrap: wrap; gap: 8px;">
                    <span style="font-size: 13px; font-weight: 700; color: #475569;">Total: <strong>{{ $suratIzinTrashList->count() }} Data Sampah</strong></span>
                    <div style="display: flex; gap: 8px;">
                        <form action="{{ route('guru.surat-izin.restore-all') }}" method="POST" onsubmit="return confirm('Pulihkan SEMUA data surat izin di sampah kelas ini?');">
                            @csrf
                            <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                            <button type="submit" class="btn-action-icon" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-rotate-left"></i> Pulihkan Semua
                            </button>
                        </form>
                        <form action="{{ route('guru.surat-izin.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Kosongkan SELURUH sampah secara permanen? Data yang terhapus tidak dapat dikembalikan!');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                            <button type="submit" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                            </button>
                        </form>
                    </div>
                </div>

                <div style="overflow-x: auto; max-height: 380px;">
                    <table class="table-custom" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th style="width: 110px; text-align: center;">KATEGORI</th>
                                <th style="width: 140px;">TANGGAL</th>
                                <th style="width: 120px;">DIHAPUS</th>
                                <th style="width: 130px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratIzinTrashList as $tr)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13px;">{{ $tr->siswa->nama_siswa ?? 'Siswa' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIS: {{ $tr->siswa->nis ?? '-' }}</div>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 8px;">
                                            {{ $tr->kategori }}
                                        </span>
                                    </td>
                                    <td style="font-size: 12px; font-weight: 600;">
                                        {{ $tr->rentang_tanggal_text }}
                                    </td>
                                    <td style="font-size: 11.5px; color: #64748b;">
                                        {{ $tr->deleted_at ? $tr->deleted_at->translatedFormat('d M, H:i') : '-' }}
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            <form action="{{ route('guru.surat-izin.restore', $tr->id_surat_izin) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action-icon" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Pulihkan Data">
                                                    <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                                </button>
                                            </form>
                                            <form action="{{ route('guru.surat-izin.force-delete', $tr->id_surat_izin) }}" method="POST" onsubmit="return confirm('Hapus permanen surat izin ini? File bukti dan data akan dihapus selamanya!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Hapus Permanen">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" class="btn-reset-gray" onclick="closeSuratTrashModal('closeBtn')">Tutup Sampah</button>
        </div>
    </div>
<!-- Hidden Single Delete Form Surat Izin -->
<form id="waliSuratDeleteSingleForm" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Detail Lengkap Surat Dispensasi Siswa (Wali Kelas View) -->
<div id="waliDispenDetailModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeWaliDispenDetailModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="detailDispenAvatar" style="width: 44px; height: 44px; border-radius: 50%; background: #384972; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px;">
                    S
                </div>
                <div>
                    <h3 id="detailDispenNama" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Nama Siswa</h3>
                    <p id="detailDispenSub" style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">NIS: - | Kelas: {{ $namaKelas }}</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeWaliDispenDetailModal('closeBtn')">&times;</button>
        </div>

        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            <!-- 3 Mini Info Cards -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; text-align: center;">
                    <div style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kode Dispen</div>
                    <div id="detailDispenKode" style="font-size: 13px; font-weight: 800; color: #2563eb; margin-top: 2px;">-</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; text-align: center;">
                    <div style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Status Waka</div>
                    <div id="detailDispenStatusWaka" style="font-size: 13px; font-weight: 800; color: #059669; margin-top: 2px;">-</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; text-align: center;">
                    <div style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Status Gerbang</div>
                    <div id="detailDispenStatusSatpam" style="font-size: 13px; font-weight: 800; color: #475569; margin-top: 2px;">-</div>
                </div>
            </div>

            <!-- Details Information Box -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 10px; font-size: 12.5px;">
                <div style="display: grid; grid-template-columns: 140px 1fr; gap: 6px;">
                    <div style="color: #64748b; font-weight: 600;">Tanggal:</div>
                    <div id="detailDispenTanggal" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Jam Dispensasi:</div>
                    <div id="detailDispenRentangJam" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Lokasi / Kegiatan:</div>
                    <div id="detailDispenTempat" style="font-weight: 700; color: #6d28d9;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Guru Piket:</div>
                    <div id="detailDispenPetugas" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Waka Kesiswaan:</div>
                    <div id="detailDispenWaka" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Waktu Approval:</div>
                    <div id="detailDispenWaktuApproval" style="font-weight: 700; color: #0f172a;">-</div>

                    <div style="color: #64748b; font-weight: 600;">Monitoring Satpam:</div>
                    <div id="detailDispenSatpamKet" style="font-weight: 700; color: #0f172a;">-</div>
                </div>

                <div style="border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 4px;">
                    <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Alasan / Keperluan Dispensasi:</div>
                    <div id="detailDispenAlasan" style="font-size: 13px; color: #1e293b; background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-weight: 600; line-height: 1.5;">-</div>
                </div>
            </div>

            <!-- Dokumentasi & Bukti Foto Grid -->
            <div id="detailDispenPhotosGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div id="detailDispenFotoLiveCard" style="display: none; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px; text-align: center; background: #ffffff;">
                    <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px;"><i class="fa-solid fa-camera"></i> Foto Live Siswa</div>
                    <img id="detailDispenFotoLiveImg" src="" alt="Foto Live" style="width: 100%; height: 130px; object-fit: cover; border-radius: 8px; cursor: pointer;" onclick="showWaliFotoModal(this.src, 'Foto Live Siswa Dispensasi')">
                </div>

                <div id="detailDispenFotoSuratCard" style="display: none; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px; text-align: center; background: #ffffff;">
                    <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px;"><i class="fa-solid fa-file-lines"></i> Surat Dispensasi</div>
                    <img id="detailDispenFotoSuratImg" src="" alt="Foto Surat" style="width: 100%; height: 130px; object-fit: cover; border-radius: 8px; cursor: pointer;" onclick="showWaliFotoModal(this.src, 'Surat Dispensasi')">
                </div>

                <div id="detailDispenFotoKartuCard" style="display: none; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px; text-align: center; background: #ffffff;">
                    <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px;"><i class="fa-solid fa-id-card"></i> Kartu Pelajar</div>
                    <img id="detailDispenFotoKartuImg" src="" alt="Kartu Pelajar" style="width: 100%; height: 130px; object-fit: cover; border-radius: 8px; cursor: pointer;" onclick="showWaliFotoModal(this.src, 'Kartu Pelajar Siswa')">
                </div>
            </div>
        </div>

        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <a id="btnCetakDispenOfficial" href="#" target="_blank" class="btn-filter-dark" style="padding: 8px 16px; font-size: 12.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i> Cetak Surat Resmi
            </a>
            <button type="button" class="btn-reset-gray" onclick="closeWaliDispenDetailModal('closeBtn')">Tutup Detail</button>
        </div>
    </div>
</div>

<!-- Modal Manajemen Sampah Surat Dispensasi Siswa (Wali Kelas) -->
<div id="waliDispenTrashModal" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeDispenTrashModal(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 20px; max-width: 820px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;">Sampah Surat Dispensasi Siswa</h3>
                    <p style="font-size: 12px; color: #64748b; font-weight: 600; margin: 2px 0 0 0;">Daftar surat dispensasi kelas {{ $namaKelas }} yang telah dihapus sementara (Soft Deleted)</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; font-size: 18px;" onclick="closeDispenTrashModal('closeBtn')">&times;</button>
        </div>

        <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            @if(($dispenTrashList ?? collect())->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa-solid fa-trash-can-arrow-up" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1;"></i>
                    <h4 style="font-size: 16px; font-weight: 700; color: #475569; margin: 0;">Sampah Masih Kosong</h4>
                    <p style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Tidak ada data surat dispensasi yang berada di dalam sampah.</p>
                </div>
            @else
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; flex-wrap: wrap; gap: 8px;">
                    <span style="font-size: 13px; font-weight: 700; color: #475569;">Total: <strong>{{ $dispenTrashList->count() }} Data Sampah</strong></span>
                    <div style="display: flex; gap: 8px;">
                        <form action="{{ route('guru.surat-dispen.restore-all') }}" method="POST" onsubmit="return confirm('Pulihkan SEMUA data surat dispensasi di sampah kelas ini?');">
                            @csrf
                            <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                            <button type="submit" class="btn-action-icon" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-rotate-left"></i> Pulihkan Semua
                            </button>
                        </form>
                        <form action="{{ route('guru.surat-dispen.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Kosongkan SELURUH sampah dispensasi secara permanen? Data yang terhapus tidak dapat dikembalikan!');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                            <button type="submit" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                            </button>
                        </form>
                    </div>
                </div>

                <div style="overflow-x: auto; max-height: 380px;">
                    <table class="table-custom" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th style="width: 130px;">TEMPAT / KATEGORI</th>
                                <th style="width: 140px;">TANGGAL &amp; JAM</th>
                                <th style="width: 120px;">DIHAPUS</th>
                                <th style="width: 140px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dispenTrashList as $trd)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13px;">{{ $trd->siswa->nama_siswa ?? 'Siswa' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIS: {{ $trd->siswa->nis ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 8px;">
                                            {{ $trd->tempat ?? 'Kegiatan Sekolah' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 12px; font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($trd->tanggal)->translatedFormat('d M Y') }}
                                        <div style="font-size: 11px; color: #64748b;">{{ substr($trd->jam_keluar ?? '07:00', 0, 5) }} - {{ substr($trd->jam_kembali ?? '15:00', 0, 5) }}</div>
                                    </td>
                                    <td style="font-size: 11.5px; color: #64748b;">
                                        {{ $trd->deleted_at ? $trd->deleted_at->translatedFormat('d M, H:i') : '-' }}
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            <form action="{{ route('guru.surat-dispen.restore', $trd->id_siswa_dispen) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action-icon" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Pulihkan Data">
                                                    <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                                </button>
                                            </form>
                                            <form action="{{ route('guru.surat-dispen.force-delete', $trd->id_siswa_dispen) }}" method="POST" onsubmit="return confirm('Hapus permanen surat dispensasi ini? Seluruh berkas dan data akan dihapus selamanya!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Hapus Permanen">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" class="btn-reset-gray" onclick="closeDispenTrashModal('closeBtn')">Tutup Sampah</button>
        </div>
    </div>
</div>

<!-- Hidden Single Delete Form Surat Dispensasi -->
<form id="waliDispenDeleteSingleForm" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    function switchWaliTab(tabName) {
        // Update subnav buttons active state
        document.querySelectorAll('.subnav-tab-item').forEach(btn => {
            btn.classList.remove('active');
        });
        if (event && event.currentTarget) {
            event.currentTarget.classList.add('active');
        }

        // Hide all panels
        document.querySelectorAll('.tab-content-panel').forEach(panel => {
            panel.classList.remove('active');
        });

        // Show target panel
        const targetPanel = document.getElementById('panel-' + tabName);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }

        // Dynamic Header Title & Subtitle update
        const titleMap = {
            'dashboard': 'Dashboard Wali Kelas — {{ $namaKelas }}',
            'kelas_perwalian': 'Kelas Perwalian — {{ $namaKelas }}',
            'rekap_kehadiran': 'Rekap Kehadiran Siswa — {{ $namaKelas }}',
            'laporan_bulanan': 'Laporan Bulanan Presensi — {{ $namaKelas }}',
            'surat_izin': 'Surat Izin / Sakit — {{ $namaKelas }}',
            'surat_dispen': 'Surat Dispensasi Siswa — {{ $namaKelas }}',
            'pengaturan': 'Pengaturan Profil & Kelas — {{ $namaKelas }}'
        };
        const subMap = {
            'dashboard': 'Rekapitulasi presensi & perkembangan siswa kelas {{ $namaKelas }} hari ini',
            'kelas_perwalian': 'Daftar dan data detail seluruh siswa perwalian',
            'rekap_kehadiran': 'Rekapitulasi presensi dan statistik kehadiran siswa',
            'laporan_bulanan': 'Ringkasan laporan bulanan kelas perwalian',
            'surat_izin': 'Pengajuan dan arsip surat izin / sakit siswa',
            'surat_dispen': 'Monitoring izin meninggalkan KBM / kegiatan luar sekolah',
            'pengaturan': 'Kelola profil, notifikasi, dan preferensi kelas perwalian'
        };

        if (titleMap[tabName]) {
            const hTitle = document.getElementById('waliHeaderTitle');
            const subTxt = document.getElementById('waliSubText');
            if (hTitle) hTitle.innerText = titleMap[tabName];
            if (subTxt) subTxt.innerText = subMap[tabName];
        }

        // Update URL search param silently
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
    }

    function filterCardsByJs() {
        const query = document.getElementById('card_search').value.toLowerCase().trim();
        const statusVal = document.getElementById('status_filter_sel').value.toLowerCase().trim();

        const cards = document.querySelectorAll('#cardsGridContainer .student-card-box');
        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const nis = card.getAttribute('data-nis') || '';
            const status = card.getAttribute('data-status') || '';

            const matchesQuery = !query || name.includes(query) || nis.includes(query);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesStatus) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function filterRekapTableJs() {
        const query = document.getElementById('rekap_table_search').value.toLowerCase().trim();
        const statusVal = document.getElementById('rekap_table_status').value.toLowerCase().trim();

        const rows = document.querySelectorAll('#rekapStudentTable tbody tr');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const status = row.getAttribute('data-status') || '';

            const matchesQuery = !query || name.includes(query);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function filterLaporanTableJs() {
        const queryVal = document.getElementById('laporan_table_search') ? document.getElementById('laporan_table_search').value.toLowerCase().trim() : '';
        const statusVal = document.getElementById('laporan_table_status') ? document.getElementById('laporan_table_status').value.toLowerCase().trim() : '';

        const rows = document.querySelectorAll('#laporanStudentTable tbody tr');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const status = row.getAttribute('data-status') || '';

            const matchesQuery = !queryVal || name.includes(queryVal);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetLaporanTableJs() {
        const sInput = document.getElementById('laporan_table_search');
        const sSel = document.getElementById('laporan_table_status');
        if (sInput) sInput.value = '';
        if (sSel) sSel.value = '';
        filterLaporanTableJs();
    }

    function filterSuratTableJs() {
        const query = document.getElementById('surat_search_input') ? document.getElementById('surat_search_input').value.toLowerCase().trim() : '';
        const jenisVal = document.getElementById('surat_jenis_filter') ? document.getElementById('surat_jenis_filter').value.toLowerCase().trim() : '';
        const statusVal = document.getElementById('surat_status_filter') ? document.getElementById('surat_status_filter').value.toLowerCase().trim() : '';

        const rows = document.querySelectorAll('#suratPengajuanTable tbody tr');
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            const name = row.getAttribute('data-name') || '';
            const jenis = row.getAttribute('data-jenis') || '';
            const status = row.getAttribute('data-status') || '';

            const matchesQuery = !query || name.includes(query);
            const matchesJenis = !jenisVal || jenisVal === 'semua jenis' || jenis.includes(jenisVal);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesJenis && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateSuratSelectedCount();
    }

    function toggleSelectAllSurat(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.surat-row-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = masterCheckbox.checked;
            }
        });
        updateSuratSelectedCount();
    }

    function updateSuratSelectedCount() {
        const checkboxes = document.querySelectorAll('.surat-row-checkbox:checked');
        const count = checkboxes.length;
        const countEl = document.getElementById('suratSelectedCount');
        const btnBulk = document.getElementById('btnBulkDeleteSurat');
        const master = document.getElementById('selectAllSurat');

        if (countEl) countEl.innerText = count;
        if (btnBulk) {
            if (count > 0) {
                btnBulk.removeAttribute('disabled');
                btnBulk.style.opacity = '1';
                btnBulk.style.cursor = 'pointer';
            } else {
                btnBulk.setAttribute('disabled', 'disabled');
                btnBulk.style.opacity = '0.5';
                btnBulk.style.cursor = 'not-allowed';
            }
        }

        const visibleBoxes = Array.from(document.querySelectorAll('.surat-row-checkbox')).filter(cb => {
            const row = cb.closest('tr');
            return row && row.style.display !== 'none';
        });
        if (master && visibleBoxes.length > 0) {
            master.checked = visibleBoxes.every(cb => cb.checked);
        } else if (master) {
            master.checked = false;
        }
    }

    function submitBulkDeleteSurat() {
        const checkedBoxes = document.querySelectorAll('.surat-row-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal 1 data surat izin terlebih dahulu.');
            return;
        }
        if (!confirm('Pindahkan ' + checkedBoxes.length + ' data surat izin terpilih ke Sampah?')) {
            return;
        }

        const container = document.getElementById('bulkDeleteSuratInputs');
        if (!container) return;
        container.innerHTML = '';

        checkedBoxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('bulkDeleteSuratForm').submit();
    }

    function confirmDeleteSingleSurat(id, nama) {
        if (confirm('Pindahkan surat izin untuk ' + nama + ' ke Sampah?')) {
            const form = document.getElementById('waliSuratDeleteSingleForm');
            if (form) {
                form.action = '{{ url("/guru-surat-izin") }}/' + id;
                form.submit();
            }
        }
    }

    function showWaliSuratDetailModal(id) {
        document.getElementById('detailSuratNama').innerText = 'Memuat...';
        document.getElementById('detailSuratSub').innerText = 'Mengambil data dari server...';
        document.getElementById('detailSuratKategori').innerText = '-';
        document.getElementById('detailSuratStatus').innerText = '-';
        document.getElementById('detailSuratRentang').innerText = '-';
        document.getElementById('detailSuratDurasi').innerText = '-';
        document.getElementById('detailSuratDiajukan').innerText = '-';
        document.getElementById('detailSuratPetugas').innerText = '-';
        document.getElementById('detailSuratKeterangan').innerText = 'Memuat alasan...';
        document.getElementById('detailSuratFotoSection').style.display = 'none';
        document.getElementById('waliSuratDetailModal').style.display = 'flex';

        fetch('{{ url("/guru-surat-izin-detail") }}/' + id)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Gagal mengambil detail surat izin');
                    return;
                }
                const d = res.data;
                document.getElementById('detailSuratNama').innerText = d.nama_siswa;
                document.getElementById('detailSuratSub').innerText = 'NIS: ' + (d.nis || '-') + ' | Kelas: ' + (d.nama_kelas || '-');
                document.getElementById('detailSuratAvatar').innerText = (d.nama_siswa || 'S').substring(0, 2).toUpperCase();
                document.getElementById('detailSuratKategori').innerText = d.kategori || d.jenis_surat_text || d.jenis_surat || '-';
                
                const statusEl = document.getElementById('detailSuratStatus');
                statusEl.innerText = d.status || 'Terverifikasi';
                if (d.status === 'Terverifikasi') {
                    statusEl.style.color = '#059669';
                } else if (d.status === 'Ditolak') {
                    statusEl.style.color = '#dc2626';
                } else {
                    statusEl.style.color = '#d97706';
                }

                document.getElementById('detailSuratRentang').innerText = d.rentang_tanggal || (d.tanggal_mulai + (d.tanggal_selesai && d.tanggal_selesai !== d.tanggal_mulai ? ' s/d ' + d.tanggal_selesai : ''));
                document.getElementById('detailSuratDurasi').innerText = d.durasi_hari || ((d.tanggal_mulai === d.tanggal_selesai || !d.tanggal_selesai) ? '1 Hari (' + d.tanggal_mulai + ')' : (d.tanggal_mulai + ' s/d ' + d.tanggal_selesai));
                document.getElementById('detailSuratDiajukan').innerText = d.diajukan_pada || d.created_at || '-';
                document.getElementById('detailSuratPetugas').innerText = d.petugas || d.pemberi_izin || 'Guru Piket';
                document.getElementById('detailSuratKeterangan').innerText = d.keterangan || d.alasan || '-';

                const fotoUrl = d.foto_url || d.file_surat_url;
                if ((d.has_foto || d.has_file) && fotoUrl) {
                    document.getElementById('detailSuratFotoImg').src = fotoUrl;
                    document.getElementById('detailSuratFotoSection').style.display = 'block';
                } else {
                    document.getElementById('detailSuratFotoSection').style.display = 'none';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memuat detail surat izin.');
            });
    }

    function closeWaliSuratDetailModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliSuratDetailModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliSuratDetailModal').style.display = 'none';
        }
    }

    function openSuratTrashModal() {
        document.getElementById('waliSuratIzinTrashModal').style.display = 'flex';
    }

    function closeSuratTrashModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliSuratIzinTrashModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliSuratIzinTrashModal').style.display = 'none';
        }
    }

    function filterDispenTableJs() {
        const query = document.getElementById('dispen_search_input').value.toLowerCase().trim();
        const statusVal = document.getElementById('dispen_status_filter').value.toLowerCase().trim();

        const rows = document.querySelectorAll('#dispenTable tbody tr');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const status = row.getAttribute('data-status') || '';

            const matchesQuery = !query || name.includes(query);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function showWaliFotoModal(imgUrl, title) {
        document.getElementById('waliModalFotoImg').src = imgUrl;
        document.getElementById('waliModalFotoTitle').textContent = title;
        document.getElementById('waliFotoModal').style.display = 'flex';
    }

    function closeWaliFotoModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliFotoModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliFotoModal').style.display = 'none';
        }
    }

    function showSiswaDetailModal(idSiswa) {
        fetch('{{ url("/guru-siswa-detail") }}/' + idSiswa)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Gagal memuat detail siswa');
                    return;
                }
                const d = res.data;
                document.getElementById('modalSiswaNama').innerText = d.nama_siswa;
                document.getElementById('modalSiswaNis').innerText = 'NIS: ' + (d.nis || '-') + ' | Kelas: ' + d.nama_kelas;
                document.getElementById('modalSiswaAvatar').innerText = (d.nama_siswa || 'S').substring(0, 2).toUpperCase();

                document.getElementById('modalStatPersen').innerText = d.persen_hadir + '%';
                document.getElementById('modalStatSakit').innerText = d.sakit;
                document.getElementById('modalStatIzin').innerText = d.izin;
                document.getElementById('modalStatAlpa').innerText = d.alpa;

                document.getElementById('modalBioNisn').innerText = d.nisn || '-';
                document.getElementById('modalBioJk').innerText = d.jenis_kelamin || '-';
                document.getElementById('modalBioTtl').innerText = (d.tempat_lahir || '-') + ', ' + (d.tanggal_lahir || '-');
                document.getElementById('modalBioWali').innerText = d.nama_wali || '-';
                document.getElementById('modalBioHp').innerText = d.no_hp_wali || '-';
                document.getElementById('modalBioAlamat').innerText = d.alamat || '-';

                const rContainer = document.getElementById('modalRiwayatContainer');
                let rHtml = '';

                // Riwayat Ketidakhadiran
                if (d.riwayat_absen && d.riwayat_absen.length > 0) {
                    rHtml += '<div style="font-size: 12px; font-weight: 800; color: #1e293b; padding: 8px 12px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;"><i class="fa-solid fa-user-xmark" style="color: #ef4444;"></i> Riwayat Ketidakhadiran</div>';
                    rHtml += '<table class="table-custom" style="width: 100%;"><thead><tr><th>Tanggal</th><th>Mapel</th><th>Keterangan</th><th>Catatan</th></tr></thead><tbody>';
                    d.riwayat_absen.forEach(r => {
                        rHtml += `<tr>
                            <td style="font-size: 12px; font-weight: 700;">${r.tanggal}</td>
                            <td style="font-size: 12px;">${r.mapel}</td>
                            <td style="font-size: 12px;"><span class="status-pill ${r.keterangan === 'Sakit' ? 'warning' : (r.keterangan === 'Izin' ? 'success' : 'danger')}">${r.keterangan}</span></td>
                            <td style="font-size: 11.5px; color: #64748b;">${r.catatan}</td>
                        </tr>`;
                    });
                    rHtml += '</tbody></table>';
                }

                // Riwayat Surat Izin / Sakit
                if (d.riwayat_surat && d.riwayat_surat.length > 0) {
                    rHtml += '<div style="font-size: 12px; font-weight: 800; color: #1e293b; padding: 8px 12px; background: #fffbeb; border-bottom: 1px solid #fde68a; margin-top: 4px;"><i class="fa-solid fa-envelope-open-text" style="color: #b45309;"></i> Riwayat Surat Izin / Sakit</div>';
                    rHtml += '<table class="table-custom" style="width: 100%;"><thead><tr><th>Kategori</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>';
                    d.riwayat_surat.forEach(s => {
                        const statusCls = s.status === 'Terverifikasi' ? 'success' : (s.status === 'Ditolak' ? 'danger' : 'warning');
                        rHtml += `<tr>
                            <td style="font-size: 12px; font-weight: 700;">${s.kategori}</td>
                            <td style="font-size: 12px;">${s.tanggal}</td>
                            <td style="font-size: 12px;"><span class="status-pill ${statusCls}">${s.status}</span></td>
                        </tr>`;
                    });
                    rHtml += '</tbody></table>';
                }

                // Riwayat Dispensasi
                if (d.riwayat_dispen && d.riwayat_dispen.length > 0) {
                    rHtml += '<div style="font-size: 12px; font-weight: 800; color: #1e293b; padding: 8px 12px; background: #f3e8ff; border-bottom: 1px solid #ddd6fe; margin-top: 4px;"><i class="fa-solid fa-door-open" style="color: #7c3aed;"></i> Riwayat Dispensasi</div>';
                    rHtml += '<table class="table-custom" style="width: 100%;"><thead><tr><th>Kategori</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>';
                    d.riwayat_dispen.forEach(dp => {
                        const dpCls = dp.status === 'Disetujui' ? 'success' : 'warning';
                        rHtml += `<tr>
                            <td style="font-size: 12px; font-weight: 700;">${dp.kategori}</td>
                            <td style="font-size: 12px;">${dp.tanggal}</td>
                            <td style="font-size: 12px;"><span class="status-pill ${dpCls}">${dp.status}</span></td>
                        </tr>`;
                    });
                    rHtml += '</tbody></table>';
                }

                if (!rHtml) {
                    rHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;">Tidak ada riwayat ketidakhadiran, surat izin, atau dispensasi tercatat. Kehadiran siswa 100% prima.</div>';
                }

                rContainer.innerHTML = rHtml;

                document.getElementById('siswaDetailModal').style.display = 'flex';
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memuat data siswa.');
            });
    }

    function closeSiswaDetailModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'siswaDetailModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('siswaDetailModal').style.display = 'none';
        }
    }

    function showPetaDetailModal(dateStr, dayNum, namaKelas, idKelas) {
        document.getElementById('petaModalDayNum').innerText = dayNum;
        const dateObj = new Date(dateStr);
        const monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
        document.getElementById('petaModalMonthShort').innerText = monthNames[dateObj.getMonth()] || 'BLN';

        document.getElementById('petaModalTitle').innerText = 'Detail Presensi Harian';
        document.getElementById('petaModalSubtitle').innerText = 'Memuat data ' + namaKelas + '...';
        document.getElementById('petaModalAlertBanner').style.display = 'none';
        document.getElementById('petaModalAbsenContainer').innerHTML = '<div style="padding: 20px; text-align: center; color: #64748b; font-size: 12.5px;"><i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Memuat data presensi harian...</div>';
        document.getElementById('petaModalJurnalContainer').innerHTML = '<div style="padding: 20px; text-align: center; color: #64748b; font-size: 12.5px;"><i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Memuat data jurnal KBM...</div>';
        document.getElementById('modalPetaDetail').style.display = 'flex';

        fetch('{{ route("guru.kehadiran-harian-detail-json") }}?id_kelas=' + idKelas + '&tanggal=' + dateStr)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Gagal memuat detail kehadiran');
                    return;
                }
                const d = res.data;
                document.getElementById('petaModalSubtitle').innerText = d.nama_kelas + ' • ' + d.tanggal_formatted;
                
                // Alert banner for weekend, future, or today
                const banner = document.getElementById('petaModalAlertBanner');
                if (d.is_weekend) {
                    banner.style.display = 'block';
                    banner.style.background = '#f1f5f9';
                    banner.style.color = '#475569';
                    banner.style.border = '1px solid #cbd5e1';
                    banner.innerHTML = '<i class="fa-solid fa-calendar-xmark" style="color: #64748b; margin-right: 6px;"></i> <strong>Libur Akhir Pekan:</strong> Tidak ada kegiatan belajar mengajar (KBM) efektif pada hari ini.';
                } else if (d.is_future) {
                    banner.style.display = 'block';
                    banner.style.background = '#f8fafc';
                    banner.style.color = '#334155';
                    banner.style.border = '1.5px dashed #94a3b8';
                    banner.innerHTML = '<i class="fa-solid fa-clock" style="color: #3b82f6; margin-right: 6px;"></i> <strong>Tanggal Belum Dilalui:</strong> Hari KBM ini belum berlangsung. Presensi dan jurnal akan tercatat saat KBM dilaksanakan.';
                } else if (d.is_today) {
                    banner.style.display = 'block';
                    banner.style.background = '#eff6ff';
                    banner.style.color = '#1e40af';
                    banner.style.border = '1px solid #bfdbfe';
                    banner.innerHTML = '<i class="fa-solid fa-calendar-check" style="color: #2563eb; margin-right: 6px;"></i> <strong>Hari Ini (' + d.tanggal_formatted + '):</strong> Data presensi dan jurnal mengajar terkini kelas ' + d.nama_kelas + '.';
                } else {
                    banner.style.display = 'none';
                }

                // Stats Cards
                if (d.is_future || d.is_weekend) {
                    document.getElementById('petaModalRate').innerText = '-';
                    document.getElementById('petaModalHadirSub').innerText = d.total_siswa + ' Total Siswa';
                } else {
                    document.getElementById('petaModalRate').innerText = d.rate_persen + '%';
                    document.getElementById('petaModalHadirSub').innerText = d.hadir + ' dari ' + d.total_siswa + ' Hadir';
                }
                document.getElementById('petaModalSakit').innerText = d.sakit;
                document.getElementById('petaModalIzin').innerText = d.izin + (d.dispen > 0 ? ' (' + d.dispen + ' Dispen)' : '');
                document.getElementById('petaModalAlpa').innerText = d.alpa;

                document.getElementById('petaModalAbsenCountBadge').innerText = (d.daftar_tidak_hadir ? d.daftar_tidak_hadir.length : 0) + ' Siswa';
                document.getElementById('petaModalJurnalCountBadge').innerText = (d.daftar_jurnal ? d.daftar_jurnal.length : 0) + ' Sesi KBM';

                // Daftar Siswa Tidak Hadir
                let aHtml = '';
                if (d.daftar_tidak_hadir && d.daftar_tidak_hadir.length > 0) {
                    aHtml += '<table class="table-custom" style="width: 100%;"><thead><tr><th>NIS & Nama Siswa</th><th>Status</th><th>Keterangan / Mapel</th><th>Catatan</th></tr></thead><tbody>';
                    d.daftar_tidak_hadir.forEach(item => {
                        aHtml += `<tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 12.5px;">${item.nama_siswa}</div>
                                <div style="font-size: 11px; color: #64748b;">NIS: ${item.nis}</div>
                            </td>
                            <td><span class="status-pill ${item.badge_class}">${item.keterangan}</span></td>
                            <td style="font-size: 12px; color: #334155;">
                                <div style="font-weight: 600;">${item.sumber}</div>
                                <div style="font-size: 11px; color: #64748b;">${item.guru}</div>
                            </td>
                            <td style="font-size: 11.5px; color: #64748b;">${item.catatan}</td>
                        </tr>`;
                    });
                    aHtml += '</tbody></table>';
                } else {
                    if (d.is_weekend) {
                        aHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;"><i class="fa-solid fa-mug-hot" style="margin-right: 4px;"></i> Akhir pekan / libur sekolah, tidak ada data ketidakhadiran.</div>';
                    } else if (d.is_future) {
                        aHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;"><i class="fa-solid fa-calendar-day" style="margin-right: 4px;"></i> Hari ini belum berlangsung, belum ada data ketidakhadiran.</div>';
                    } else {
                        aHtml = '<div style="padding: 20px; text-align: center; color: #059669; font-weight: 700; font-size: 12.5px;"><i class="fa-solid fa-circle-check" style="color: #10b981; margin-right: 4px;"></i> Luar biasa! Seluruh ' + d.total_siswa + ' siswa hadir lengkap pada tanggal ini.</div>';
                    }
                }
                document.getElementById('petaModalAbsenContainer').innerHTML = aHtml;

                // Daftar Jurnal KBM
                let jHtml = '';
                if (d.daftar_jurnal && d.daftar_jurnal.length > 0) {
                    jHtml += '<table class="table-custom" style="width: 100%;"><thead><tr><th>Jam & Mapel</th><th>Guru Pengajar</th><th>Materi / Pembahasan</th><th>Status Guru</th></tr></thead><tbody>';
                    d.daftar_jurnal.forEach(j => {
                        jHtml += `<tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 12.5px;">${j.mapel}</div>
                                <div style="font-size: 11px; color: #2563eb; font-weight: 600;">${j.jam}</div>
                            </td>
                            <td style="font-size: 12px; font-weight: 600; color: #334155;">${j.guru}</td>
                            <td style="font-size: 12px; color: #475569;">${j.materi}</td>
                            <td><span class="status-pill ${j.status_badge}">${j.status_guru}</span></td>
                        </tr>`;
                    });
                    jHtml += '</tbody></table>';
                } else {
                    if (d.is_weekend) {
                        jHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;">Tidak ada jadwal kegiatan belajar mengajar di hari libur.</div>';
                    } else if (d.is_future) {
                        jHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;">Jurnal mengajar akan diisi oleh guru pengampu saat jam pelajaran tiba.</div>';
                    } else {
                        jHtml = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12.5px;">Belum ada entri jurnal mengajar yang diinput untuk hari ini.</div>';
                    }
                }
                document.getElementById('petaModalJurnalContainer').innerHTML = jHtml;
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat mengambil detail kehadiran.');
            });
    }

    function closePetaDetailModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'modalPetaDetail' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('modalPetaDetail').style.display = 'none';
        }
    }

    function openWaliEditProfilModal() {
        document.getElementById('waliEditProfilModal').style.display = 'flex';
    }

    function closeWaliEditProfilModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliEditProfilModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliEditProfilModal').style.display = 'none';
        }
    }

    function scrollSettingSection(sectionId, el) {
        document.querySelectorAll('.settings-sub-item').forEach(item => item.classList.remove('active'));
        if (el) el.classList.add('active');
        const target = document.getElementById(sectionId);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function saveNotificationPref(title, checked) {
        showWaliToast('Preferensi "' + title + '" berhasil ' + (checked ? 'diaktifkan' : 'dinonaktifkan') + '.', 'success');
    }

    function saveAmbangBatasPref() {
        showWaliToast('Preferensi ambang batas alpa & minimum kehadiran berhasil disimpan.', 'success');
    }

    function showWaliToast(message, type) {
        const container = document.getElementById('waliToastContainer');
        if (!container) return;
        const toast = document.createElement('div');
        const bg = type === 'success' ? '#047857' : '#1e293b';
        toast.style.cssText = `background: ${bg}; color: #ffffff; padding: 12px 18px; border-radius: 12px; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.3s ease;`;
        toast.innerHTML = `<i class="fa-solid fa-circle-check" style="font-size: 15px;"></i> <span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.style.opacity = '1', 50);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ── DISPEN FILTER & ACTIONS (TAB 6) ──
    function filterDispenTableJs() {
        const query = document.getElementById('dispen_search_input') ? document.getElementById('dispen_search_input').value.toLowerCase().trim() : '';
        const statusVal = document.getElementById('dispen_status_filter') ? document.getElementById('dispen_status_filter').value.toLowerCase().trim() : '';

        const rows = document.querySelectorAll('#dispenTable tbody tr');
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            const name = row.getAttribute('data-name') || '';
            const status = row.getAttribute('data-status') || '';
            const kategori = row.getAttribute('data-kategori') || '';
            const alasan = row.getAttribute('data-alasan') || '';

            const matchesQuery = !query || name.includes(query) || kategori.includes(query) || alasan.includes(query);
            const matchesStatus = !statusVal || statusVal === 'semua status' || status.includes(statusVal);

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateDispenSelectedCount();
    }

    function toggleSelectAllDispen(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.dispen-row-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = masterCheckbox.checked;
            }
        });
        updateDispenSelectedCount();
    }

    function updateDispenSelectedCount() {
        const checkboxes = document.querySelectorAll('.dispen-row-checkbox:checked');
        const count = checkboxes.length;
        const countEl = document.getElementById('dispenSelectedCount');
        const btnBulk = document.getElementById('btnBulkDeleteDispen');
        const master = document.getElementById('selectAllDispen');

        if (countEl) countEl.innerText = count;
        if (btnBulk) {
            if (count > 0) {
                btnBulk.removeAttribute('disabled');
                btnBulk.style.opacity = '1';
                btnBulk.style.cursor = 'pointer';
            } else {
                btnBulk.setAttribute('disabled', 'disabled');
                btnBulk.style.opacity = '0.5';
                btnBulk.style.cursor = 'not-allowed';
            }
        }

        const visibleBoxes = Array.from(document.querySelectorAll('.dispen-row-checkbox')).filter(cb => {
            const row = cb.closest('tr');
            return row && row.style.display !== 'none';
        });
        if (master && visibleBoxes.length > 0) {
            master.checked = visibleBoxes.every(cb => cb.checked);
        } else if (master) {
            master.checked = false;
        }
    }

    function submitBulkDeleteDispen() {
        const checkedBoxes = document.querySelectorAll('.dispen-row-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal 1 data surat dispensasi terlebih dahulu.');
            return;
        }
        if (!confirm('Pindahkan ' + checkedBoxes.length + ' data surat dispensasi terpilih ke Sampah?')) {
            return;
        }

        const container = document.getElementById('bulkDeleteDispenInputs');
        if (!container) return;
        container.innerHTML = '';

        checkedBoxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('bulkDeleteDispenForm').submit();
    }

    function confirmDeleteSingleDispen(id, nama) {
        if (confirm('Pindahkan surat dispensasi untuk ' + nama + ' ke Sampah?')) {
            const form = document.getElementById('waliDispenDeleteSingleForm');
            if (form) {
                form.action = '{{ url("/guru-surat-dispen") }}/' + id;
                form.submit();
            }
        }
    }

    function showWaliDispenDetailModal(id) {
        document.getElementById('detailDispenNama').innerText = 'Memuat...';
        document.getElementById('detailDispenSub').innerText = 'Mengambil data dari server...';
        document.getElementById('detailDispenKode').innerText = '-';
        document.getElementById('detailDispenStatusWaka').innerText = '-';
        document.getElementById('detailDispenStatusSatpam').innerText = '-';
        document.getElementById('detailDispenTanggal').innerText = '-';
        document.getElementById('detailDispenRentangJam').innerText = '-';
        document.getElementById('detailDispenTempat').innerText = '-';
        document.getElementById('detailDispenPetugas').innerText = '-';
        document.getElementById('detailDispenWaka').innerText = '-';
        document.getElementById('detailDispenWaktuApproval').innerText = '-';
        document.getElementById('detailDispenSatpamKet').innerText = '-';
        document.getElementById('detailDispenAlasan').innerText = 'Memuat alasan...';
        document.getElementById('detailDispenFotoLiveCard').style.display = 'none';
        document.getElementById('detailDispenFotoSuratCard').style.display = 'none';
        document.getElementById('detailDispenFotoKartuCard').style.display = 'none';
        
        const btnCetak = document.getElementById('btnCetakDispenOfficial');
        if (btnCetak) btnCetak.href = '{{ url("/guru-surat-dispen") }}/' + id + '/cetak';

        document.getElementById('waliDispenDetailModal').style.display = 'flex';

        fetch('{{ url("/guru-surat-dispen-detail") }}/' + id)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Gagal mengambil detail surat dispensasi');
                    return;
                }
                const d = res.data;
                document.getElementById('detailDispenNama').innerText = d.nama_siswa;
                document.getElementById('detailDispenSub').innerText = 'NIS: ' + (d.nis || '-') + ' | Kelas: ' + (d.nama_kelas || '-');
                document.getElementById('detailDispenAvatar').innerText = (d.nama_siswa || 'S').substring(0, 2).toUpperCase();
                document.getElementById('detailDispenKode').innerText = d.kode_dispen || '-';
                
                const wakaEl = document.getElementById('detailDispenStatusWaka');
                wakaEl.innerText = d.status_waka_label || d.status_waka;
                if (d.status_waka === 'approved') {
                    wakaEl.style.color = '#059669';
                } else if (d.status_waka === 'rejected') {
                    wakaEl.style.color = '#dc2626';
                } else {
                    wakaEl.style.color = '#d97706';
                }

                const satpamEl = document.getElementById('detailDispenStatusSatpam');
                satpamEl.innerText = d.status_satpam_label || d.status_satpam;
                if (d.status_satpam === 'sudah_kembali') {
                    satpamEl.style.color = '#059669';
                } else if (d.status_satpam === 'sudah_keluar') {
                    satpamEl.style.color = '#d97706';
                } else {
                    satpamEl.style.color = '#475569';
                }

                document.getElementById('detailDispenTanggal').innerText = d.tanggal || '-';
                document.getElementById('detailDispenRentangJam').innerText = d.rentang_jam || '-';
                document.getElementById('detailDispenTempat').innerText = d.tempat || '-';
                document.getElementById('detailDispenPetugas').innerText = (d.nama_guru_piket || 'Guru Piket') + (d.nip_guru_piket && d.nip_guru_piket !== '-' ? ' (' + d.nip_guru_piket + ')' : '');
                document.getElementById('detailDispenWaka').innerText = (d.nama_waka || 'Waka Kesiswaan') + (d.nip_waka && d.nip_waka !== '-' ? ' (' + d.nip_waka + ')' : '');
                document.getElementById('detailDispenWaktuApproval').innerText = d.waktu_approval_waka || (d.status_waka === 'approved' ? 'Terverifikasi' : 'Menunggu');
                document.getElementById('detailDispenSatpamKet').innerText = d.status_satpam_label + (d.waktu_scan_satpam && d.waktu_scan_satpam !== '-' ? ' • ' + d.waktu_scan_satpam : '');
                document.getElementById('detailDispenAlasan').innerText = d.alasan || '-';

                // Photos
                if (d.foto_siswa_live_url) {
                    document.getElementById('detailDispenFotoLiveImg').src = d.foto_siswa_live_url;
                    document.getElementById('detailDispenFotoLiveCard').style.display = 'block';
                }
                if (d.foto_surat_url) {
                    document.getElementById('detailDispenFotoSuratImg').src = d.foto_surat_url;
                    document.getElementById('detailDispenFotoSuratCard').style.display = 'block';
                }
                if (d.foto_kartu_url) {
                    document.getElementById('detailDispenFotoKartuImg').src = d.foto_kartu_url;
                    document.getElementById('detailDispenFotoKartuCard').style.display = 'block';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memuat detail surat dispensasi.');
            });
    }

    function closeWaliDispenDetailModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliDispenDetailModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliDispenDetailModal').style.display = 'none';
        }
    }

    function openDispenTrashModal() {
        document.getElementById('waliDispenTrashModal').style.display = 'flex';
    }

    function closeDispenTrashModal(e) {
        if (!e || e === 'closeBtn' || (e && e.target && (e.target.id === 'waliDispenTrashModal' || e.target.closest('.btn-close-modal')))) {
            document.getElementById('waliDispenTrashModal').style.display = 'none';
        }
    }

    // Global listener to close active modals on Escape key press
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeWaliFotoModal('closeBtn');
            closeSiswaDetailModal('closeBtn');
            closePetaDetailModal('closeBtn');
            closeWaliEditProfilModal('closeBtn');
            closeWaliSuratDetailModal('closeBtn');
            closeSuratTrashModal('closeBtn');
            closeWaliDispenDetailModal('closeBtn');
            closeDispenTrashModal('closeBtn');
        }
    });
</script>

