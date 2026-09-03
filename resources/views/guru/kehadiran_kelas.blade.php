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
        transition: transform 0.15s ease;
    }

    .heat-box:hover {
        transform: scale(1.05);
    }

    .heat-box.heat-95 { background: #065f46; color: #ffffff; }
    .heat-box.heat-85 { background: #10b981; color: #ffffff; }
    .heat-box.heat-70 { background: #b45309; color: #ffffff; }
    .heat-box.heat-red { background: #dc2626; color: #ffffff; }
    .heat-box.holiday { background: #ffffff; color: #475569; border: 2px solid #cbd5e1; }

    .heatmap-legend-row {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        padding-top: 10px;
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
    .legend-indicator.ind-holiday { background: #ffffff; border: 1px solid #cbd5e1; }

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

        <a href="{{ route('pengaturan.index') }}" class="subnav-tab-item">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan Profil</span>
        </a>
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
                            <option value="">SEMUA BULAN</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                                </option>
                            @endfor
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
                <div class="student-card-box" data-name="{{ strtolower($card['siswa']->nama_siswa) }}" data-status="{{ strtolower($card['statusText']) }}">
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
                    <a href="?tab=rekap_kehadiran&bulan_selected={{ $prevBulan }}&tahun_selected={{ $prevTahun }}" class="month-nav-btn" title="Bulan Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                    <span class="month-nav-label">{{ $namaBulanTahun }}</span>
                    <a href="?tab=rekap_kehadiran&bulan_selected={{ $nextBulan }}&tahun_selected={{ $nextTahun }}" class="month-nav-btn" title="Bulan Berikutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
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
                    <div class="subtitle">naik 1% dari bulan lalu</div>
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
                    <div class="subtitle">4 siswa berbeda</div>
                </div>
            </div>

            <!-- Peta Kehadiran Kelas (Calendar Heatmap Grid 1-31 from Image 4) -->
            <div class="card-heatmap-box">
                <h3>Peta Kehadiran Kelas</h3>
                <p>Rata-rata kehadiran kelas per hari sekolah, {{ $namaBulanTahun }}</p>

                <div class="heatmap-grid">
                    @foreach($calendarHeatmap as $hm)
                        <div class="heat-box {{ $hm['type'] }}" title="Tanggal {{ $hm['day'] }} {{ $namaBulanTahun }}">
                            {{ $hm['day'] }}
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
                </div>
            </div>

            <!-- Rekap per siswa . [Bulan Tahun] Table -->
            <div class="card-table-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <h3 style="margin-bottom: 2px;">Rekap per siswa . {{ $namaBulanTahun }}</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600;">Akumulasi kehadiran sebulan</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px;">
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
                                <tr data-name="{{ strtolower($row['siswa']->nama_siswa) }}" data-status="{{ strtolower($row['statusText']) }}">
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
                                        {{ max(0, 20 - $row['total']) }}
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
                    <select class="select-custom" style="min-width: 150px; background: #ffffff;" onchange="location.href='?tab=laporan_bulanan&bulan_selected='+this.value">
                        <option value="7" {{ $bulanSelected == 7 ? 'selected' : '' }}>Juli 2026</option>
                        <option value="8" {{ $bulanSelected == 8 ? 'selected' : '' }}>Agustus 2026</option>
                        <option value="9" {{ $bulanSelected == 9 ? 'selected' : '' }}>September 2026</option>
                    </select>

                    <button type="button" class="btn-filter-dark" onclick="window.print()">
                        <i class="fa-solid fa-download"></i> Export
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
                    <div class="subtitle">naik 1% dari bulan lalu</div>
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
                    <div class="subtitle">kehadiran dibawah 70%</div>
                </div>
            </div>

            <!-- Middle Section 2 Column: Ringkasan & Perlu Perhatian -->
            <div class="grid-rekap-rincian">
                <!-- Left Column: Ringkasan kehadiran per siswa -->
                <div class="card-table-box">
                    <div style="margin-bottom: 16px;">
                        <h3>Ringkasan kehadiran per siswa</h3>
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600;">Seluruh siswa kelas {{ $namaKelas }}, {{ $namaBulanTahun }}</p>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table-custom">
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
                                    <tr>
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
                                        <td style="text-align: center; font-weight: 700; color: #10b981;">{{ max(0, 20 - $row['total']) }}</td>
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
                            <div class="rank-item">
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
                    <div class="subtitle">minggu ini</div>
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
                        <p style="font-size: 12.5px; color: #64748b; font-weight: 600;">Terbaru di atas</p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="text" id="surat_search_input" class="input-custom" placeholder="Cari nama siswa..." onkeyup="filterSuratTableJs()">

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
                        </select>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-custom" id="suratPengajuanTable">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th style="width: 130px; text-align: center;">JENIS KATEGORI</th>
                                <th style="width: 140px;">TANGGAL ABSEN</th>
                                <th style="width: 120px;">DIAJUKAN</th>
                                <th style="width: 160px;">LAMPIRAN / BUKTI</th>
                                <th style="width: 140px;">PETUGAS PIKET</th>
                                <th style="width: 120px; text-align: center;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratPengajuanList as $surat)
                                <tr data-name="{{ strtolower($surat['nama']) }}" data-jenis="{{ strtolower($surat['jenis']) }}" data-status="{{ strtolower($surat['status']) }}">
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                {{ $surat['initials'] }}
                                            </div>
                                            <div class="student-info">
                                                <div class="name">{{ $surat['nama'] }}</div>
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
                                            <span class="badge-kind-tan">{{ $surat['jenis'] }}</span>
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
                                            <span style="color: #64748b;">{{ $surat['lampiran'] }}</span>
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
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                                        Belum ada pengajuan surat izin atau sakit yang dicatat.
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
    <!-- TAB 6: PENGATURAN (EXACT MATCH IMAGE 7)                       -->
    <!-- ───────────────────────────────────────────────────────────── -->
    <div id="panel-pengaturan" class="tab-content-panel {{ $tab == 'pengaturan' ? 'active' : '' }}">

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Subheader Banner -->
            <div>
                <div style="font-size: 13px; font-weight: 800; color: #b45309; text-transform: uppercase;">
                    Akun &amp; Preferensi
                </div>
                <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin: 2px 0;">Pengaturan</h2>
                <p style="font-size: 13px; color: #64748b; font-weight: 600;">Kelola profil, notifikasi, dan preferensi kelas perwalian</p>
            </div>

            <!-- Settings Layout Grid (Left Menu + Right Cards - Image 7 Match) -->
            <div class="settings-layout-grid">
                <!-- Left Sub-Menu Navigation Card -->
                <div class="settings-sidebar-card">
                    <a class="settings-sub-item active" onclick="return false;">Profil</a>
                    <a class="settings-sub-item" onclick="return false;">Kelas perwalian</a>
                    <a class="settings-sub-item" onclick="return false;">Notifikasi</a>
                    <a class="settings-sub-item" onclick="return false;">Ambang batas alpa</a>
                    <a class="settings-sub-item" onclick="return false;">Keamanan akun</a>
                </div>

                <!-- Right Settings Content Cards -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Card 1: Profil -->
                    <div class="settings-card-section">
                        <div>
                            <h3>Profil</h3>
                            <p>Informasi ini tampil di header dashboard</p>
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
                    </div>

                    <!-- Card 2: Kelas perwalian -->
                    <div class="settings-card-section">
                        <div>
                            <h3>Kelas perwalian</h3>
                            <p>Kelas yang kamu pantau kehadirannya</p>
                        </div>

                        <div class="settings-field-row">
                            <label>Kelas</label>
                            <div class="readonly-field-tan">{{ $namaKelas }}</div>
                        </div>

                        <div class="settings-field-row">
                            <label>Tahun ajaran</label>
                            <div class="readonly-field-tan">{{ $tahunAjaranAktif }}</div>
                        </div>
                    </div>

                    <!-- Card 3: Notifikasi -->
                    <div class="settings-card-section">
                        <div>
                            <h3>Notifikasi</h3>
                            <p>Atur kapan kamu mau diingatkan</p>
                        </div>

                        <div class="settings-field-row" style="align-items: center;">
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Surat izin/sakit baru masuk</div>
                                <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi saat ada pengajuan menunggu verifikasi</div>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="slider-round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

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
            'surat_izin': 'Surat Izin / Sakit — {{ $namaKelas }}'
        };
        const subMap = {
            'dashboard': 'Rekapitulasi presensi & perkembangan siswa kelas {{ $namaKelas }} hari ini',
            'kelas_perwalian': 'Daftar dan data detail seluruh siswa perwalian',
            'rekap_kehadiran': 'Rekapitulasi presensi dan statistik kehadiran siswa',
            'laporan_bulanan': 'Ringkasan laporan bulanan kelas perwalian',
            'surat_izin': 'Pengajuan dan arsip surat izin / sakit siswa'
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
            const name = card.getAttribute('data-name');
            const status = card.getAttribute('data-status');

            const matchesQuery = !query || name.includes(query);
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

    function filterSuratTableJs() {
        const query = document.getElementById('surat_search_input').value.toLowerCase().trim();
        const jenisVal = document.getElementById('surat_jenis_filter').value.toLowerCase().trim();
        const statusVal = document.getElementById('surat_status_filter').value.toLowerCase().trim();

        const rows = document.querySelectorAll('#suratPengajuanTable tbody tr');
        rows.forEach(row => {
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
    }

    function showWaliFotoModal(imgUrl, title) {
        document.getElementById('waliModalFotoImg').src = imgUrl;
        document.getElementById('waliModalFotoTitle').textContent = title;
        document.getElementById('waliFotoModal').style.display = 'flex';
    }

    function closeWaliFotoModal(e) {
        if (!e || e.target.id === 'waliFotoModal' || e === 'closeBtn') {
            document.getElementById('waliFotoModal').style.display = 'none';
        }
    }
</script>

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
@endsection
