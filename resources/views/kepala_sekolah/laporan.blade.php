@extends('layouts.kepala_sekolah')

@section('title', 'Laporan Eksekutif & Evaluasi KBM — Jurnal SMEA')
@section('header_title', 'Laporan')

@section('styles')
<style>
    .laporan-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding-bottom: 40px;
    }

    /* Main Card */
    .card-laporan-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    /* Top Header Bar */
    .top-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .title-left-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .icon-header-box {
        color: #2563eb;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        border: 1px solid #dbeafe;
    }

    .title-header-text {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .subtitle-header-text {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-top {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-action-export {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }

    .btn-action-export:hover {
        background: #166534;
        color: #ffffff;
        border-color: #166534;
        box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
    }

    .btn-action-print {
        background: #2b3957;
        color: #ffffff;
        border-color: #1e293b;
    }

    .btn-action-print:hover {
        background: #1e293b;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(43, 57, 87, 0.3);
    }

    /* Main Filter Form Card */
    .filter-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
    }

    .filter-grid-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select-item {
        flex: 1;
        min-width: 150px;
    }

    .filter-select-item select, .filter-select-item input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .filter-select-item select:focus, .filter-select-item input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-action {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-filter-action:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-reset-action {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-reset-action:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Executive KPI Grid (5 Cards) */
    .kpi-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .kpi-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .kpi-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .kpi-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .kpi-title-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .kpi-icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .kpi-number-val {
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .kpi-subtext-info {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Monthly Chart Container */
    .chart-container-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .chart-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .chart-title-text {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-bars-wrapper {
        position: relative;
        height: 200px;
        display: flex;
        align-items: flex-end;
        padding-bottom: 28px;
        padding-top: 20px;
    }

    .chart-grid-lines {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
    }

    .chart-grid-tick {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
    }

    .chart-grid-line {
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .chart-bars-area {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        padding-left: 45px;
        gap: 12px;
    }

    .chart-bar-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        flex: 1;
        max-width: 60px;
        position: relative;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .chart-bar-column:hover {
        transform: translateY(-3px);
    }

    .chart-bar-value-pill {
        font-size: 11.5px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 6px;
        white-space: nowrap;
        background: #eff6ff;
        padding: 2px 6px;
        border-radius: 6px;
        border: 1px solid #dbeafe;
    }

    .chart-bar-value-pill.pill-active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .chart-bar-value-pill.pill-empty {
        background: #f1f5f9;
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    .chart-bar-fill {
        width: 100%;
        background: #2b3957;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease;
        min-height: 4px;
    }

    .chart-bar-fill.fill-active {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
    }

    .chart-bar-fill.fill-empty {
        background: #f1f5f9;
        border: 1px dashed #cbd5e1;
        border-bottom: none;
        min-height: 4px;
    }

    .chart-bar-column:hover .chart-bar-fill:not(.fill-active):not(.fill-empty) {
        background: #2563eb;
    }

    .chart-bar-label {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-top: 10px;
        text-align: center;
        white-space: nowrap;
    }

    .chart-bar-label.label-active {
        color: #2563eb;
        font-weight: 800;
    }

    .chart-info-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 12px;
    }

    /* Tab Navigation Styles */
    .laporan-tab-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 4px;
        overflow-x: auto;
    }

    .laporan-tab-btn {
        background: transparent;
        border: none;
        padding: 10px 18px;
        border-radius: 12px 12px 0 0;
        font-size: 13.5px;
        font-weight: 800;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.2s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -6px;
    }

    .laporan-tab-btn:hover {
        color: #2563eb;
        background: #f8fafc;
    }

    .laporan-tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: #eff6ff;
    }

    .tab-content-pane {
        display: none;
        flex-direction: column;
        gap: 16px;
        animation: fadeIn 0.2s ease;
    }

    .tab-content-pane.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Tab Quick Toolbar (Search & Filter per Tab) */
    .tab-quick-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 16px;
    }

    .tab-toolbar-left {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tab-toolbar-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .table-search-input {
        padding: 8px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 12.5px;
        outline: none;
        background: #ffffff;
        color: #334155;
        font-family: inherit;
        min-width: 220px;
        transition: all 0.2s ease;
    }

    .table-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .table-filter-select {
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 12.5px;
        outline: none;
        background: #ffffff;
        color: #334155;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .table-filter-select:focus {
        border-color: #2563eb;
    }

    /* Table Styles */
    .table-container-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-laporan-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .table-laporan-custom thead {
        background: #2b3957;
        color: #ffffff;
    }

    .table-laporan-custom thead th {
        padding: 13px 16px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #1e293b;
        white-space: nowrap;
    }

    .table-laporan-custom tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }

    .table-laporan-custom tbody tr:hover {
        background-color: #f8fafc;
    }

    .table-laporan-custom tbody td {
        padding: 13px 16px;
        vertical-align: middle;
        color: #334155;
    }

    .badge-status-eval {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-eval-sangat-baik {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .badge-eval-baik {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-eval-cukup {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    /* Action Buttons in Table */
    .btn-eye-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-eye-action:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    /* Student absence breakdown cards */
    .absen-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
    }

    .absen-summary-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .absen-summary-val {
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .absen-summary-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
    }

    /* Modal Base Styles */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .custom-modal-dialog {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 860px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        border: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        animation: modalScaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalScaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .custom-modal-header {
        background: #2b3957;
        color: #ffffff;
        padding: 20px 24px;
        border-top-left-radius: 19px;
        border-top-right-radius: 19px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .custom-modal-title {
        font-size: 17px;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .custom-modal-close-btn {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .custom-modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .custom-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        color: #334155;
    }

    .modal-profile-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .modal-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px;
    }

    .modal-stat-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .modal-section-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
    }

    .table-modal-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .table-modal-custom thead {
        background: #f1f5f9;
    }

    .table-modal-custom th {
        padding: 10px 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        font-size: 11px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-modal-custom td {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom-left-radius: 19px;
        border-bottom-right-radius: 19px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-modal-close {
        background: #64748b;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-modal-close:hover {
        background: #475569;
    }
</style>
@endsection

@section('content')

@php
    $bulanNamaIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $selectedBulan = request('bulan');
    $selectedTahun = request('tahun', '2026');
    $periodeLabel = $selectedBulan && isset($bulanNamaIndo[$selectedBulan]) ? ($bulanNamaIndo[$selectedBulan] . ' ' . $selectedTahun) : ("Semester Ganjil " . $selectedTahun . " / Semua Bulan");
@endphp

<div class="laporan-container">

    <!-- Card Main Wrapper -->
    <div class="card-laporan-box">

        <!-- Top Header Bar with Export & Print Actions -->
        <div class="top-header-bar">
            <div class="title-left-group">
                <div class="icon-header-box">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div>
                    <h1 class="title-header-text">Laporan Eksekutif & Evaluasi KBM</h1>
                    <div class="subtitle-header-text">
                        Periode Evaluasi: <strong style="color: #0f172a;">{{ $periodeLabel }}</strong> &bull; Dicatat real-time dari sistem Jurnal SMEA
                    </div>
                </div>
            </div>

            <!-- Action Buttons: Export CSV & Print Laporan -->
            <div class="header-actions-group">
                <a href="{{ route('kepala-sekolah.laporan.export', request()->query()) }}" class="btn-action-top btn-action-export" title="Ekspor rekapitulasi laporan ke file CSV / Excel">
                    <i class="fa-solid fa-file-excel"></i> Ekspor CSV
                </a>

                <a href="{{ route('kepala-sekolah.laporan.print', request()->query()) }}" target="_blank" class="btn-action-top btn-action-print" title="Cetak Dokumen Laporan Lengkap resmi berstandar SMKN 1 Boyolangu">
                    <i class="fa-solid fa-print"></i> Cetak Dokumen Laporan
                </a>
            </div>
        </div>

        <!-- Filter Form Toolbar -->
        <div class="filter-section-card">
            <form method="GET" action="{{ route('kepala-sekolah.laporan') }}">
                <div class="filter-grid-row">
                    <!-- Bulan -->
                    <div class="filter-select-item" style="max-width: 170px;">
                        <select name="bulan">
                            <option value="">🗓️ Semua Bulan</option>
                            @foreach($bulanNamaIndo as $num => $nama)
                                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun -->
                    <div class="filter-select-item" style="max-width: 130px;">
                        <select name="tahun">
                            <option value="2026" {{ request('tahun', '2026') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ request('tahun') == '2027' ? 'selected' : '' }}>2027</option>
                            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="filter-select-item" style="max-width: 180px;">
                        <select name="semester">
                            <option value="all" {{ request('semester') == 'all' ? 'selected' : '' }}>T.A. 2026/2027 (Semua)</option>
                            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Semester Ganjil (Jul-Des)</option>
                            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Semester Genap (Jan-Jun)</option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="filter-select-item">
                        <select name="id_kelas">
                            <option value="">🏫 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mapel -->
                    <div class="filter-select-item">
                        <select name="id_mapel">
                            <option value="">📖 Semua Mata Pelajaran</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ request('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="filter-select-item" style="min-width: 180px;">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="🔍 Cari Guru, Materi, Kelas...">
                    </div>

                    <button type="submit" class="btn-filter-action">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    @if(request()->hasAny(['bulan', 'tahun', 'semester', 'id_kelas', 'id_mapel', 'q']))
                        <a href="{{ route('kepala-sekolah.laporan') }}" class="btn-reset-action">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Executive KPI Cards Grid (5 Metrics) -->
        <div class="kpi-cards-grid">
            <!-- 1. Tingkat Kehadiran Guru -->
            <div class="kpi-stat-card" style="border-top: 4px solid #2563eb;">
                <div class="kpi-card-top">
                    <span class="kpi-title-label">Kehadiran Guru</span>
                    <div class="kpi-icon-wrapper" style="background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                </div>
                <div class="kpi-number-val" style="color: #2563eb;">
                    {{ $kehadiranGuruPct }}%
                </div>
                <div class="kpi-subtext-info">
                    Tingkat kehadiran guru aktif sekolah
                </div>
            </div>

            <!-- 2. Izin & Tidak Hadir Guru -->
            <div class="kpi-stat-card" style="border-top: 4px solid #f59e0b;">
                <div class="kpi-card-top">
                    <span class="kpi-title-label">Izin & Tidak Hadir</span>
                    <div class="kpi-icon-wrapper" style="background: #fef3c7; color: #b45309;">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>
                <div class="kpi-number-val" style="color: #b45309;">
                    {{ $totalIzinGuru }}
                </div>
                <div class="kpi-subtext-info">
                    Surat izin resmi guru tercatat
                </div>
            </div>

            <!-- 3. Realisasi Sesi Jurnal KBM -->
            <div class="kpi-stat-card" style="border-top: 4px solid #10b981;">
                <div class="kpi-card-top">
                    <span class="kpi-title-label">Realisasi Sesi KBM</span>
                    <div class="kpi-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                        <i class="fa-solid fa-book-journal-whills"></i>
                    </div>
                </div>
                <div class="kpi-number-val" style="color: #059669;">
                    {{ $totalSesiJurnal }} Sesi
                </div>
                <div class="kpi-subtext-info">
                    {{ $sesiHadir }} sesi terlaksana hadir ({{ $keterlaksanaanKbmPct }}%)
                </div>
            </div>

            <!-- 4. Tingkat Kehadiran Siswa -->
            <div class="kpi-stat-card" style="border-top: 4px solid #8b5cf6;">
                <div class="kpi-card-top">
                    <span class="kpi-title-label">Kehadiran Siswa</span>
                    <div class="kpi-icon-wrapper" style="background: #f5f3ff; color: #7c3aed;">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
                <div class="kpi-number-val" style="color: #7c3aed;">
                    {{ $kehadiranSiswaPct }}%
                </div>
                <div class="kpi-subtext-info">
                    {{ $totalKetidakhadiranSiswa }} catatan absen pada sesi KBM
                </div>
            </div>

            <!-- 5. Verifikasi Pengesahan Piket -->
            <div class="kpi-stat-card" style="border-top: 4px solid #0284c7;">
                <div class="kpi-card-top">
                    <span class="kpi-title-label">Verifikasi Piket</span>
                    <div class="kpi-icon-wrapper" style="background: #f0f9ff; color: #0284c7;">
                        <i class="fa-solid fa-signature"></i>
                    </div>
                </div>
                <div class="kpi-number-val" style="color: #0284c7;">
                    {{ $sesiTerverifikasiPiket }} Sesi
                </div>
                <div class="kpi-subtext-info">
                    Disahkan dengan TTD digital Guru Piket
                </div>
            </div>
        </div>

        <!-- Section 1: Visualisasi Grafik Tingkat Kehadiran Guru per Bulan -->
        <div class="chart-container-box">
            <div class="chart-header-row">
                <div>
                    <h2 class="chart-title-text">
                        <i class="fa-solid fa-chart-simple" style="color: #2563eb;"></i>
                        Tingkat Kehadiran Guru per Bulan ({{ request('semester') === 'genap' ? 'Semester Genap' : 'Semester Ganjil' }} {{ request('tahun', '2026') }}/{{ (int)request('tahun', '2026') + 1 }})
                    </h2>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                        Grafik persentase kehadiran guru dihitung real-time berdasarkan data keterlaksanaan sesi KBM & pengajuan izin resmi guru
                    </div>
                </div>
                <div style="font-size: 12px; color: #64748b; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #166534;"></span> Target Sekolah: <strong style="color: #166534;">≥ 95.0%</strong>
                    </span>
                </div>
            </div>

            <div class="chart-bars-wrapper">
                <!-- Grid Lines Y-Axis (0% to 100%) -->
                <div class="chart-grid-lines">
                    @foreach([100, 75, 50, 25, 0] as $tick)
                    <div class="chart-grid-tick">
                        <span style="width: 38px; text-align: right;">{{ $tick }}%</span>
                        <div class="chart-grid-line"></div>
                    </div>
                    @endforeach
                </div>

                <!-- Bars Area -->
                <div class="chart-bars-area">
                    @foreach($kehadiranBulanan as $item)
                        @php
                            $queryParams = array_merge(request()->query(), [
                                'bulan' => ($selectedBulan == $item['num']) ? null : $item['num']
                            ]);
                            $urlToggleMonth = route('kepala-sekolah.laporan', array_filter($queryParams, fn($v) => !is_null($v) && $v !== ''));
                            
                            $heightPct = $item['has_data'] ? max(6, min(100, $item['pct'])) : 4;
                            $tooltipText = $item['has_data'] 
                                ? ($item['bulan'] . ' ' . $selectedTahun . ": Kehadiran Guru " . $item['pct'] . "% (" . $item['sesi_hadir'] . "/" . $item['total_jurnal'] . " Sesi KBM Terlaksana, " . $item['total_izin'] . " Surat Izin Guru)")
                                : ($item['bulan'] . ' ' . $selectedTahun . ": Belum ada catatan sesi KBM / izin guru");
                        @endphp

                        <a href="{{ $urlToggleMonth }}" class="chart-bar-column" title="{{ $tooltipText }}">
                            <span class="chart-bar-value-pill {{ $item['is_active'] ? 'pill-active' : (!$item['has_data'] ? 'pill-empty' : '') }}">
                                {{ $item['has_data'] ? $item['pct'].'%' : '-' }}
                            </span>
                            
                            <div class="chart-bar-fill {{ $item['is_active'] ? 'fill-active' : (!$item['has_data'] ? 'fill-empty' : '') }}" style="height: {{ $heightPct }}%;"></div>
                            
                            <div class="chart-bar-label {{ $item['is_active'] ? 'label-active' : '' }}">
                                {{ $item['bulan'] }}
                                @if($item['is_active'])
                                    <span style="font-size: 10px; color: #2563eb; display: block;">(Terpilih)</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Footer Info Banner for Chart -->
            <div class="chart-info-footer">
                <div style="color: #475569; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i>
                    @if($selectedBulan && isset($bulanNamaIndo[$selectedBulan]))
                        <span>Menampilkan filter bulan khusus: <strong style="color: #2563eb;">{{ $bulanNamaIndo[$selectedBulan] }} {{ $selectedTahun }}</strong>. Klik kembali bar grafik atau pilih "Semua Bulan" untuk menampilkan seluruh tren semester.</span>
                    @else
                        <span>Tips: Klik pada salah satu batang bulan di atas untuk memfilter rekapitulasi data secara instan pada bulan tersebut.</span>
                    @endif
                </div>

                @if($selectedBulan)
                    <a href="{{ route('kepala-sekolah.laporan', array_merge(request()->except('bulan'))) }}" style="color: #dc2626; font-weight: 700; text-decoration: none; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-xmark"></i> Hapus Filter Bulan
                    </a>
                @endif
            </div>
        </div>

        <!-- Navigation Tabs for Detailed Reports -->
        <div class="laporan-tab-nav">
            <button type="button" class="laporan-tab-btn active" onclick="switchLaporanTab('tabGuru', this)">
                <i class="fa-solid fa-chalkboard-user"></i> Rekap Kehadiran Guru (<span id="countGuruBadge">{{ count($rekapGuruList) }}</span>)
            </button>
            <button type="button" class="laporan-tab-btn" onclick="switchLaporanTab('tabKelas', this)">
                <i class="fa-solid fa-graduation-cap"></i> Rekap KBM per Kelas (<span id="countKelasBadge">{{ count($rekapKelasList) }}</span>)
            </button>
            <button type="button" class="laporan-tab-btn" onclick="switchLaporanTab('tabIzin', this)">
                <i class="fa-solid fa-envelope-open-text"></i> Rekap Surat Izin Guru (<span id="countIzinBadge">{{ count($allFilteredGuruIzin) }}</span>)
            </button>
            <button type="button" class="laporan-tab-btn" onclick="switchLaporanTab('tabSiswa', this)">
                <i class="fa-solid fa-users"></i> Rekap Presensi Siswa (<span id="countSiswaBadge">{{ count($daftarSiswaAbsenList) }}</span>)
            </button>
        </div>

        <!-- TAB 1: REKAP KEHADIRAN GURU -->
        <div id="tabGuru" class="tab-content-pane active">
            <!-- Quick Toolbar for Tab 1 -->
            <div class="tab-quick-toolbar">
                <div class="tab-toolbar-left">
                    <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i>
                    <span>Daftar kehadiran & performa mengajar guru. Klik <strong>Detail</strong> untuk melihat riwayat sesi & izin.</span>
                </div>
                <div class="tab-toolbar-right">
                    <input type="text" id="searchGuruInput" onkeyup="filterTableGuru()" placeholder="🔍 Cari nama guru, NIP, mapel..." class="table-search-input">
                    <select id="filterGuruEvaluasi" onchange="filterTableGuru()" class="table-filter-select">
                        <option value="">Semua Status Evaluasi</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Perlu Evaluasi">Perlu Evaluasi</option>
                    </select>
                </div>
            </div>

            <div class="table-container-responsive">
                <table class="table-laporan-custom" id="tableRekapGuru">
                    <thead>
                        <tr>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th>NAMA GURU</th>
                            <th>MATA PELAJARAN</th>
                            <th style="text-align: center; width: 100px;">TOTAL SESI</th>
                            <th style="text-align: center; width: 85px;">HADIR</th>
                            <th style="text-align: center; width: 85px;">IZIN</th>
                            <th style="text-align: center; width: 95px;">DIGANTIKAN</th>
                            <th style="text-align: center; width: 140px;">STATUS EVALUASI</th>
                            <th style="text-align: center; width: 90px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapGuruList as $idx => $rg)
                        <tr class="row-guru-item" data-nama="{{ strtolower($rg->nama_guru) }}" data-nip="{{ strtolower($rg->nip) }}" data-mapel="{{ strtolower($rg->nama_mapel) }}" data-evaluasi="{{ $rg->evaluasi }}">
                            <td style="text-align: center; font-weight: 700; color: #64748b;" class="guru-row-no">{{ $idx + 1 }}</td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $rg->nama_guru }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">NIP: {{ $rg->nip }}</div>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #2563eb;">{{ $rg->nama_mapel }}</span>
                            </td>
                            <td style="text-align: center; font-weight: 800; color: #0f172a;">{{ $rg->total_sesi }} Sesi</td>
                            <td style="text-align: center; font-weight: 800; color: #166534;">{{ $rg->hadir }}</td>
                            <td style="text-align: center; font-weight: 800; color: #b45309;">{{ $rg->izin }}</td>
                            <td style="text-align: center; font-weight: 800; color: #1e40af;">{{ $rg->digantikan }}</td>
                            <td style="text-align: center;">
                                @if($rg->evaluasi === 'Sangat Baik')
                                    <span class="badge-status-eval badge-eval-sangat-baik"><i class="fa-solid fa-circle-check"></i> Sangat Baik</span>
                                @elseif($rg->evaluasi === 'Baik')
                                    <span class="badge-status-eval badge-eval-baik"><i class="fa-solid fa-check"></i> Baik</span>
                                @else
                                    <span class="badge-status-eval badge-eval-cukup"><i class="fa-solid fa-triangle-exclamation"></i> Perlu Evaluasi</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-eye-action" onclick="openModalDetailGuru({{ json_encode($rg) }})" title="Lihat Rincian Sesi KBM & Izin Guru">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyGuruRow">
                            <td colspan="9" style="text-align: center; padding: 28px; color: #94a3b8;">
                                Tidak ada data rekapitulasi guru untuk kriteria filter ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 2: REKAP KBM PER KELAS -->
        <div id="tabKelas" class="tab-content-pane">
            <!-- Quick Toolbar for Tab 2 -->
            <div class="tab-quick-toolbar">
                <div class="tab-toolbar-left">
                    <i class="fa-solid fa-graduation-cap" style="color: #2563eb;"></i>
                    <span>Keterlaksanaan KBM rombel kelas. Klik <strong>Detail</strong> untuk melihat daftar jurnal & siswa absen.</span>
                </div>
                <div class="tab-toolbar-right">
                    <input type="text" id="searchKelasInput" onkeyup="filterTableKelas()" placeholder="🔍 Cari nama kelas..." class="table-search-input">
                    <select id="filterKelasAbsen" onchange="filterTableKelas()" class="table-filter-select">
                        <option value="">Semua Kondisi Siswa</option>
                        <option value="absen">Ada Siswa Tidak Hadir</option>
                        <option value="nihil">Kehadiran Lengkap (Nihil)</option>
                    </select>
                </div>
            </div>

            <div class="table-container-responsive">
                <table class="table-laporan-custom" id="tableRekapKelas">
                    <thead>
                        <tr>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th>KELAS</th>
                            <th style="text-align: center; width: 150px;">TOTAL JURNAL KBM</th>
                            <th style="text-align: center; width: 180px;">VERIFIKASI PIKET</th>
                            <th style="text-align: center; width: 170px;">SISWA TIDAK HADIR</th>
                            <th style="text-align: center; width: 90px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapKelasList as $idx => $rk)
                        <tr class="row-kelas-item" data-nama="{{ strtolower($rk->nama_kelas) }}" data-absen="{{ $rk->siswa_absen > 0 ? 'absen' : 'nihil' }}">
                            <td style="text-align: center; font-weight: 700; color: #64748b;" class="kelas-row-no">{{ $idx + 1 }}</td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $rk->nama_kelas }}</div>
                            </td>
                            <td style="text-align: center; font-weight: 800; color: #0f172a;">{{ $rk->total_jurnal }} Sesi</td>
                            <td style="text-align: center;">
                                <span style="color: #166534; font-weight: 800;">
                                    {{ $rk->terverifikasi }} / {{ $rk->total_jurnal }} Sesi
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @if($rk->siswa_absen > 0)
                                    <span style="background: #fee2e2; color: #dc2626; padding: 3px 10px; border-radius: 10px; font-weight: 800; font-size: 12px;">
                                        {{ $rk->siswa_absen }} Siswa
                                    </span>
                                @else
                                    <span style="color: #166534; font-weight: 700; font-size: 12px;">
                                        <i class="fa-solid fa-circle-check"></i> Lengkap (Nihil)
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-eye-action" onclick="openModalDetailKelas({{ json_encode($rk) }})" title="Lihat Rincian Sesi & Siswa Absen Kelas">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyKelasRow">
                            <td colspan="6" style="text-align: center; padding: 28px; color: #94a3b8;">
                                Tidak ada data jurnal kelas pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: REKAP SURAT IZIN GURU -->
        <div id="tabIzin" class="tab-content-pane">
            <!-- Quick Toolbar for Tab 3 -->
            <div class="tab-quick-toolbar">
                <div class="tab-toolbar-left">
                    <i class="fa-solid fa-envelope-open-text" style="color: #2563eb;"></i>
                    <span>Daftar surat izin resmi guru. Klik <strong>Detail</strong> untuk melihat permohonan lengkap & bukti surat.</span>
                </div>
                <div class="tab-toolbar-right">
                    <input type="text" id="searchIzinInput" onkeyup="filterTableIzin()" placeholder="🔍 Cari guru, NIP, mapel, alasan..." class="table-search-input">
                    <select id="filterIzinStatus" onchange="filterTableIzin()" class="table-filter-select">
                        <option value="">Semua Status Persetujuan</option>
                        <option value="approved">Disetujui</option>
                        <option value="pending">Menunggu</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="table-container-responsive">
                <table class="table-laporan-custom" id="tableRekapIzin">
                    <thead>
                        <tr>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th>NAMA GURU</th>
                            <th>MATA PELAJARAN</th>
                            <th>KATEGORI IZIN</th>
                            <th>TANGGAL BERLAKU</th>
                            <th>ALASAN / KETERANGAN</th>
                            <th style="text-align: center; width: 140px;">STATUS PERSETUJUAN</th>
                            <th style="text-align: center; width: 90px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allFilteredGuruIzin as $idx => $gi)
                        <tr class="row-izin-item" data-nama="{{ strtolower($gi->guru->nama_guru ?? '') }}" data-nip="{{ strtolower($gi->guru->nip ?? '') }}" data-mapel="{{ strtolower($gi->guru->mapel->nama_mapel ?? '') }}" data-alasan="{{ strtolower($gi->alasan ?? '') }}" data-status="{{ $gi->status_kepsek ?? 'pending' }}">
                            <td style="text-align: center; font-weight: 700; color: #64748b;" class="izin-row-no">{{ $idx + 1 }}</td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $gi->guru->nama_guru ?? 'Guru' }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">NIP: {{ $gi->guru->nip ?? '-' }}</div>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #2563eb;">{{ $gi->guru->mapel->nama_mapel ?? '-' }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 800; color: #334155;">{{ $gi->kategori_izin ?: ($gi->kategori ?? 'Izin') }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; font-size: 12.5px;">{{ \Carbon\Carbon::parse($gi->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($gi->tanggal_selesai)->format('d/m/Y') }}</div>
                            </td>
                            <td style="color: #475569; font-size: 12.5px;">
                                {{ $gi->alasan ?: '-' }}
                            </td>
                            <td style="text-align: center;">
                                @if($gi->status_kepsek === 'approved')
                                    <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-check"></i> Disetujui
                                    </span>
                                @elseif($gi->status_kepsek === 'rejected')
                                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-clock"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-eye-action" onclick="openModalDetailIzin({{ json_encode($gi) }})" title="Lihat Rincian Surat Izin & Bukti Dokumen">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyIzinRow">
                            <td colspan="8" style="text-align: center; padding: 28px; color: #94a3b8;">
                                Tidak ada data pengajuan izin guru pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 4: REKAP PRESENSI SISWA -->
        <div id="tabSiswa" class="tab-content-pane">
            <!-- Summary KPI Boxes for Absences -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 16px;">
                <div style="font-size: 14px; font-weight: 800; color: #1e293b; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-users-viewfinder" style="color: #2563eb;"></i> Ringkasan Ketidakhadiran Siswa per Kategori (Periode Terpilih)
                    </span>
                    <span style="font-size: 12px; color: #64748b; font-weight: 700;">
                        Total: <strong>{{ count($daftarSiswaAbsenList) }} Catatan Absen Siswa</strong>
                    </span>
                </div>
                <div class="absen-summary-grid">
                    <div class="absen-summary-box">
                        <span class="absen-summary-val" style="color: #b45309;">{{ $kategoriAbsensiSiswa['Sakit'] }}</span>
                        <span class="absen-summary-label">Sakit</span>
                    </div>
                    <div class="absen-summary-box">
                        <span class="absen-summary-val" style="color: #1d4ed8;">{{ $kategoriAbsensiSiswa['Izin'] }}</span>
                        <span class="absen-summary-label">Izin</span>
                    </div>
                    <div class="absen-summary-box">
                        <span class="absen-summary-val" style="color: #7e22ce;">{{ $kategoriAbsensiSiswa['Dispensasi'] }}</span>
                        <span class="absen-summary-label">Dispensasi</span>
                    </div>
                    <div class="absen-summary-box">
                        <span class="absen-summary-val" style="color: #dc2626;">{{ $kategoriAbsensiSiswa['Alpa'] }}</span>
                        <span class="absen-summary-label">Alpa / Tanpa Keterangan</span>
                    </div>
                </div>
            </div>

            <!-- Quick Toolbar for Tab 4 -->
            <div class="tab-quick-toolbar">
                <div class="tab-toolbar-left">
                    <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                    <span>Daftar Rincian Siswa Tidak Hadir Pada Sesi KBM. Klik <strong>Detail</strong> untuk melihat konteks sesi KBM.</span>
                </div>
                <div class="tab-toolbar-right">
                    <input type="text" id="filterSiswaInput" onkeyup="filterTableSiswa()" placeholder="🔍 Cari siswa, NISN, kelas, mapel..." class="table-search-input">
                    <select id="filterSiswaStatus" onchange="filterTableSiswa()" class="table-filter-select">
                        <option value="">Semua Keterangan</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Dispensasi">Dispensasi</option>
                        <option value="Alpa">Alpa</option>
                    </select>
                </div>
            </div>

            <div class="table-container-responsive">
                <table class="table-laporan-custom" id="tableSiswaAbsen">
                    <thead>
                        <tr>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th>NAMA SISWA</th>
                            <th>NISN</th>
                            <th>KELAS</th>
                            <th>TANGGAL & JAM</th>
                            <th style="text-align: center; width: 110px;">STATUS</th>
                            <th>MATA PELAJARAN / GURU</th>
                            <th style="text-align: center; width: 90px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarSiswaAbsenList as $idx => $sa)
                        <tr class="row-siswa-item" data-nama="{{ strtolower($sa->nama_siswa) }}" data-nisn="{{ strtolower($sa->nisn) }}" data-kelas="{{ strtolower($sa->nama_kelas) }}" data-mapel="{{ strtolower($sa->nama_mapel) }}" data-guru="{{ strtolower($sa->nama_guru) }}" data-status="{{ $sa->status }}">
                            <td style="text-align: center; font-weight: 700; color: #64748b;" class="siswa-row-no">{{ $idx + 1 }}</td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $sa->nama_siswa }}</div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-size: 12px; color: #64748b; font-weight: 600;">{{ $sa->nisn }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 800; color: #2563eb;">{{ $sa->nama_kelas }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; font-size: 12.5px; color: #1e293b;">{{ $sa->tanggal }}</div>
                                <div style="font-size: 11px; color: #64748b;">Jam Ke: {{ $sa->jam_ke }}</div>
                            </td>
                            <td style="text-align: center;">
                                @if($sa->status === 'Sakit')
                                    <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">
                                        Sakit
                                    </span>
                                @elseif($sa->status === 'Dispensasi')
                                    <span style="background: #f5f3ff; color: #6b21a8; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">
                                        Dispensasi
                                    </span>
                                @elseif($sa->status === 'Alpa')
                                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">
                                        Alpa
                                    </span>
                                @else
                                    <span style="background: #eff6ff; color: #1e40af; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">
                                        Izin
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 12.5px;">{{ $sa->nama_mapel }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $sa->nama_guru }}</div>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-eye-action" onclick="openModalDetailSiswa({{ json_encode($sa) }})" title="Lihat Rincian Ketidakhadiran Siswa">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptySiswaRow">
                            <td colspan="8" style="text-align: center; padding: 28px; color: #94a3b8;">
                                Tidak ada catatan ketidakhadiran siswa pada sesi KBM periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="font-size: 12.5px; color: #64748b; margin-top: 6px;">
                Untuk melihat daftar izin harian siswa atau rekapitulasi presensi global, Anda juga dapat membuka menu <a href="{{ route('kepala-sekolah.siswa-izin') }}" style="color: #2563eb; font-weight: 700; text-decoration: none;">Siswa yang Sedang Izin</a> dan <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" style="color: #2563eb; font-weight: 700; text-decoration: none;">Kehadiran Siswa</a>.
            </div>
        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- MODAL 1: DETAIL REKAP GURU -->
<!-- ======================================================== -->
<div id="modalDetailGuru" class="custom-modal-overlay">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <div class="custom-modal-title">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Detail Evaluasi KBM Guru</span>
            </div>
            <button type="button" class="custom-modal-close-btn" onclick="closeModal('modalDetailGuru')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <!-- Profil Guru -->
            <div class="modal-profile-card">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <div id="modalGuruNama" style="font-size: 16px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="modalGuruNip" style="font-size: 12px; color: #64748b; font-weight: 600;">NIP: -</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div id="modalGuruMapel" style="font-size: 13px; font-weight: 800; color: #2563eb;">-</div>
                    <div id="modalGuruBadgeEvaluasi" style="margin-top: 4px;">-</div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="modal-stats-row">
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">TOTAL SESI</span>
                    <strong id="modalGuruTotalSesi" style="font-size: 16px; color: #0f172a;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">HADIR MENGAJAR</span>
                    <strong id="modalGuruHadir" style="font-size: 16px; color: #166534;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">IZIN RESMI</span>
                    <strong id="modalGuruIzin" style="font-size: 16px; color: #b45309;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">DIGANTIKAN</span>
                    <strong id="modalGuruDigantikan" style="font-size: 16px; color: #1e40af;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">KEHADIRAN (%)</span>
                    <strong id="modalGuruPersentase" style="font-size: 16px; color: #2563eb;">-%</strong>
                </div>
            </div>

            <!-- Section Sesi Mengajar KBM -->
            <div>
                <div class="modal-section-title">
                    <i class="fa-solid fa-calendar-check" style="color: #2563eb;"></i> Riwayat Sesi KBM Mengajar
                </div>
                <div class="table-container-responsive" style="margin-top: 8px; max-height: 200px; overflow-y: auto;">
                    <table class="table-modal-custom">
                        <thead>
                            <tr>
                                <th>TANGGAL & JAM</th>
                                <th>KELAS</th>
                                <th>MATERI PEMBELAJARAN</th>
                                <th>STATUS</th>
                                <th>VERIFIKASI PIKET</th>
                            </tr>
                        </thead>
                        <tbody id="modalGuruTableSesiBody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section Izin Guru -->
            <div>
                <div class="modal-section-title">
                    <i class="fa-solid fa-file-signature" style="color: #f59e0b;"></i> Riwayat Pengajuan Izin Guru
                </div>
                <div class="table-container-responsive" style="margin-top: 8px; max-height: 160px; overflow-y: auto;">
                    <table class="table-modal-custom">
                        <thead>
                            <tr>
                                <th>KATEGORI</th>
                                <th>TANGGAL BERLAKU</th>
                                <th>DURASI</th>
                                <th>ALASAN</th>
                                <th>STATUS KEPSEK</th>
                            </tr>
                        </thead>
                        <tbody id="modalGuruTableIzinBody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeModal('modalDetailGuru')">Tutup</button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: DETAIL REKAP KELAS -->
<!-- ======================================================== -->
<div id="modalDetailKelas" class="custom-modal-overlay">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <div class="custom-modal-title">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Detail Keterlaksanaan KBM Kelas</span>
            </div>
            <button type="button" class="custom-modal-close-btn" onclick="closeModal('modalDetailKelas')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <!-- Profil Kelas -->
            <div class="modal-profile-card">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fa-solid fa-chalkboard"></i>
                    </div>
                    <div>
                        <div id="modalKelasNama" style="font-size: 17px; font-weight: 800; color: #0f172a;">-</div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">Rombongan Belajar SMKN 1 Boyolangu</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">KETERLAKSANAAN KBM</div>
                    <div id="modalKelasPersentase" style="font-size: 18px; font-weight: 900; color: #166534;">-%</div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="modal-stats-row">
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">TOTAL JURNAL KBM</span>
                    <strong id="modalKelasTotalJurnal" style="font-size: 16px; color: #0f172a;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">TERVERIFIKASI PIKET</span>
                    <strong id="modalKelasVerifikasi" style="font-size: 16px; color: #166534;">-</strong>
                </div>
                <div class="modal-stat-pill">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">SISWA TIDAK HADIR</span>
                    <strong id="modalKelasSiswaAbsen" style="font-size: 16px; color: #dc2626;">-</strong>
                </div>
            </div>

            <!-- Section Jurnal KBM Kelas -->
            <div>
                <div class="modal-section-title">
                    <i class="fa-solid fa-book-bookmark" style="color: #2563eb;"></i> Daftar Sesi Jurnal KBM di Kelas Ini
                </div>
                <div class="table-container-responsive" style="margin-top: 8px; max-height: 200px; overflow-y: auto;">
                    <table class="table-modal-custom">
                        <thead>
                            <tr>
                                <th>TANGGAL & JAM</th>
                                <th>MATA PELAJARAN</th>
                                <th>GURU PENGAMPU</th>
                                <th>MATERI</th>
                                <th>STATUS PIKET</th>
                            </tr>
                        </thead>
                        <tbody id="modalKelasTableJurnalBody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section Siswa Absen Kelas -->
            <div>
                <div class="modal-section-title">
                    <i class="fa-solid fa-user-xmark" style="color: #dc2626;"></i> Rincian Ketidakhadiran Siswa di Kelas Ini
                </div>
                <div class="table-container-responsive" style="margin-top: 8px; max-height: 160px; overflow-y: auto;">
                    <table class="table-modal-custom">
                        <thead>
                            <tr>
                                <th>NAMA SISWA</th>
                                <th>NISN</th>
                                <th>TANGGAL & JAM</th>
                                <th>KETERANGAN</th>
                                <th>MAPEL</th>
                            </tr>
                        </thead>
                        <tbody id="modalKelasTableAbsenBody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeModal('modalDetailKelas')">Tutup</button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: DETAIL SURAT IZIN GURU -->
<!-- ======================================================== -->
<div id="modalDetailIzin" class="custom-modal-overlay">
    <div class="custom-modal-dialog" style="max-width: 720px;">
        <div class="custom-modal-header">
            <div class="custom-modal-title">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span>Detail Permohonan Izin Guru</span>
            </div>
            <button type="button" class="custom-modal-close-btn" onclick="closeModal('modalDetailIzin')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <!-- Profil Pemohon -->
            <div class="modal-profile-card">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 46px; height: 46px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div>
                        <div id="modalIzinNamaGuru" style="font-size: 16px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="modalIzinNipGuru" style="font-size: 12px; color: #64748b; font-weight: 600;">NIP: -</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div id="modalIzinMapel" style="font-size: 13px; font-weight: 800; color: #2563eb;">-</div>
                    <div id="modalIzinStatusBadge" style="margin-top: 4px;">-</div>
                </div>
            </div>

            <!-- Detail Information Fields -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">KATEGORI IZIN</div>
                    <div id="modalIzinKategori" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">TANGGAL & DURASI</div>
                    <div id="modalIzinTanggal" style="font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b;">ALASAN / KETERANGAN PENGAJUAN</div>
                <div id="modalIzinAlasan" style="font-size: 13.5px; color: #1e293b; font-weight: 600; margin-top: 4px; line-height: 1.5;">-</div>
            </div>

            <div id="modalIzinCatatanBox" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 700; color: #1d4ed8;">CATATAN KEPALA SEKOLAH</div>
                <div id="modalIzinCatatanKepsek" style="font-size: 13px; color: #1e3a8a; font-weight: 600; margin-top: 4px;">-</div>
            </div>

            <div id="modalIzinFotoContainer" style="display: none; flex-direction: column; gap: 6px;">
                <div style="font-size: 12px; font-weight: 800; color: #334155;">Foto Dokumen / Surat Izin Pendukung:</div>
                <div style="text-align: center; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px; background: #f8fafc;">
                    <img id="modalIzinFotoImg" src="" alt="Surat Izin" style="max-height: 250px; max-width: 100%; border-radius: 8px; object-fit: contain;">
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeModal('modalDetailIzin')">Tutup</button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 4: DETAIL PRESENSI SISWA -->
<!-- ======================================================== -->
<div id="modalDetailSiswa" class="custom-modal-overlay">
    <div class="custom-modal-dialog" style="max-width: 680px;">
        <div class="custom-modal-header">
            <div class="custom-modal-title">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Detail Ketidakhadiran Siswa</span>
            </div>
            <button type="button" class="custom-modal-close-btn" onclick="closeModal('modalDetailSiswa')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <!-- Profil Siswa -->
            <div class="modal-profile-card">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 46px; height: 46px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div id="modalSiswaNama" style="font-size: 16px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="modalSiswaNisn" style="font-size: 12px; color: #64748b; font-weight: 600;">NISN: -</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div id="modalSiswaKelas" style="font-size: 14px; font-weight: 800; color: #2563eb;">-</div>
                    <div id="modalSiswaStatusBadge" style="margin-top: 4px;">-</div>
                </div>
            </div>

            <!-- Detail Sesi KBM -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">TANGGAL & WAKTU SESI</div>
                    <div id="modalSiswaTanggal" style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                    <div id="modalSiswaJam" style="font-size: 11.5px; color: #64748b; margin-top: 1px;">-</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">MATA PELAJARAN & GURU</div>
                    <div id="modalSiswaMapel" style="font-size: 13.5px; font-weight: 800; color: #2563eb; margin-top: 2px;">-</div>
                    <div id="modalSiswaGuru" style="font-size: 11.5px; color: #475569; margin-top: 1px;">-</div>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b;">MATERI PEMBELAJARAN PADA SESI INI</div>
                <div id="modalSiswaMateri" style="font-size: 13.5px; color: #1e293b; font-weight: 600; margin-top: 4px;">-</div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b;">KONDISI KELAS & CATATAN SESI</div>
                <div id="modalSiswaCatatan" style="font-size: 13px; color: #475569; margin-top: 4px;">-</div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeModal('modalDetailSiswa')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Tab Switching Function
    function switchLaporanTab(tabId, btn) {
        var buttons = document.querySelectorAll('.laporan-tab-btn');
        buttons.forEach(function(b) { b.classList.remove('active'); });

        var panes = document.querySelectorAll('.tab-content-pane');
        panes.forEach(function(p) { p.classList.remove('active'); });

        btn.classList.add('active');
        var targetPane = document.getElementById(tabId);
        if (targetPane) {
            targetPane.classList.add('active');
        }
    }

    // Modal Control Functions
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Close on overlay click
    window.onclick = function(event) {
        if (event.target.classList.contains('custom-modal-overlay')) {
            event.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    };

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.custom-modal-overlay').forEach(function(modal) {
                modal.style.display = 'none';
            });
            document.body.style.overflow = 'auto';
        }
    });

    // 1. OPEN DETAIL GURU MODAL
    function openModalDetailGuru(guru) {
        document.getElementById('modalGuruNama').textContent = guru.nama_guru || '-';
        document.getElementById('modalGuruNip').textContent = 'NIP: ' + (guru.nip || '-');
        document.getElementById('modalGuruMapel').textContent = guru.nama_mapel || '-';

        // Badge Evaluasi
        var badgeHtml = '';
        if (guru.evaluasi === 'Sangat Baik') {
            badgeHtml = '<span class="badge-status-eval badge-eval-sangat-baik"><i class="fa-solid fa-circle-check"></i> Sangat Baik</span>';
        } else if (guru.evaluasi === 'Baik') {
            badgeHtml = '<span class="badge-status-eval badge-eval-baik"><i class="fa-solid fa-check"></i> Baik</span>';
        } else {
            badgeHtml = '<span class="badge-status-eval badge-eval-cukup"><i class="fa-solid fa-triangle-exclamation"></i> Perlu Evaluasi</span>';
        }
        document.getElementById('modalGuruBadgeEvaluasi').innerHTML = badgeHtml;

        // Stats
        document.getElementById('modalGuruTotalSesi').textContent = (guru.total_sesi || 0) + ' Sesi';
        document.getElementById('modalGuruHadir').textContent = (guru.hadir || 0) + ' Sesi';
        document.getElementById('modalGuruIzin').textContent = (guru.izin || 0) + ' Kali';
        document.getElementById('modalGuruDigantikan').textContent = (guru.digantikan || 0) + ' Sesi';
        document.getElementById('modalGuruPersentase').textContent = (guru.persentase || 0) + '%';

        // Table Sesi List
        var sesiBody = document.getElementById('modalGuruTableSesiBody');
        sesiBody.innerHTML = '';
        if (guru.sesi_list && guru.sesi_list.length > 0) {
            guru.sesi_list.forEach(function(s) {
                var verifBadge = s.is_verified
                    ? '<span style="color: #166534; font-weight: 800; font-size: 11px;"><i class="fa-solid fa-circle-check"></i> Disahkan (' + (s.nama_guru_piket || 'Piket') + ')</span>'
                    : '<span style="color: #94a3b8; font-size: 11px;"><i class="fa-solid fa-clock"></i> Belum Verif</span>';

                var row = document.createElement('tr');
                row.innerHTML = '<td><strong>' + s.tanggal + '</strong><br><span style="font-size: 11px; color: #64748b;">Jam ' + s.jam_ke + '</span></td>' +
                                '<td><strong style="color: #2563eb;">' + s.nama_kelas + '</strong></td>' +
                                '<td>' + s.materi + '</td>' +
                                '<td><span style="font-weight: 700; color: ' + (s.status_kehadiran === 'Hadir' ? '#166534' : '#b45309') + ';">' + s.status_kehadiran + '</span></td>' +
                                '<td>' + verifBadge + '</td>';
                sesiBody.appendChild(row);
            });
        } else {
            sesiBody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 16px;">Tidak ada sesi KBM tercatat pada periode ini.</td></tr>';
        }

        // Table Izin List
        var izinBody = document.getElementById('modalGuruTableIzinBody');
        izinBody.innerHTML = '';
        if (guru.izin_list && guru.izin_list.length > 0) {
            guru.izin_list.forEach(function(iz) {
                var statusKepsek = iz.status_kepsek === 'approved'
                    ? '<span style="color: #166534; font-weight: 800; font-size: 11px;"><i class="fa-solid fa-check"></i> Disetujui</span>'
                    : (iz.status_kepsek === 'rejected'
                        ? '<span style="color: #dc2626; font-weight: 800; font-size: 11px;"><i class="fa-solid fa-xmark"></i> Ditolak</span>'
                        : '<span style="color: #b45309; font-weight: 800; font-size: 11px;"><i class="fa-solid fa-clock"></i> Menunggu</span>');

                var row = document.createElement('tr');
                row.innerHTML = '<td><strong>' + iz.kategori_izin + '</strong></td>' +
                                '<td>' + iz.tanggal_mulai + ' s/d ' + iz.tanggal_selesai + '</td>' +
                                '<td>' + iz.durasi + '</td>' +
                                '<td>' + iz.alasan + '</td>' +
                                '<td>' + statusKepsek + '</td>';
                izinBody.appendChild(row);
            });
        } else {
            izinBody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 16px;">Tidak ada permohonan izin tercatat pada periode ini.</td></tr>';
        }

        openModal('modalDetailGuru');
    }

    // 2. OPEN DETAIL KELAS MODAL
    function openModalDetailKelas(kelas) {
        document.getElementById('modalKelasNama').textContent = kelas.nama_kelas || '-';
        document.getElementById('modalKelasPersentase').textContent = (kelas.persentase_kbm || 0) + '%';
        document.getElementById('modalKelasTotalJurnal').textContent = (kelas.total_jurnal || 0) + ' Sesi';
        document.getElementById('modalKelasVerifikasi').textContent = (kelas.terverifikasi || 0) + ' / ' + (kelas.total_jurnal || 0) + ' Sesi';
        document.getElementById('modalKelasSiswaAbsen').textContent = (kelas.siswa_absen || 0) + ' Siswa';

        // Table Jurnal List
        var jurnalBody = document.getElementById('modalKelasTableJurnalBody');
        jurnalBody.innerHTML = '';
        if (kelas.jurnal_list && kelas.jurnal_list.length > 0) {
            kelas.jurnal_list.forEach(function(j) {
                var verifBadge = j.is_verified
                    ? '<span style="color: #166534; font-weight: 800; font-size: 11px;"><i class="fa-solid fa-circle-check"></i> Disahkan (' + (j.nama_guru_piket || 'Piket') + ')</span>'
                    : '<span style="color: #94a3b8; font-size: 11px;"><i class="fa-solid fa-clock"></i> Belum Verif</span>';

                var row = document.createElement('tr');
                row.innerHTML = '<td><strong>' + j.tanggal + '</strong><br><span style="font-size: 11px; color: #64748b;">Jam ' + j.jam_ke + '</span></td>' +
                                '<td><strong style="color: #2563eb;">' + j.nama_mapel + '</strong></td>' +
                                '<td>' + j.nama_guru + '</td>' +
                                '<td>' + j.materi + '</td>' +
                                '<td>' + verifBadge + '</td>';
                jurnalBody.appendChild(row);
            });
        } else {
            jurnalBody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 16px;">Tidak ada sesi KBM tercatat.</td></tr>';
        }

        // Table Absen List
        var absenBody = document.getElementById('modalKelasTableAbsenBody');
        absenBody.innerHTML = '';
        if (kelas.absen_list && kelas.absen_list.length > 0) {
            kelas.absen_list.forEach(function(ab) {
                var row = document.createElement('tr');
                row.innerHTML = '<td><strong>' + ab.nama_siswa + '</strong></td>' +
                                '<td style="font-family: monospace; color: #64748b;">' + ab.nisn + '</td>' +
                                '<td>' + ab.tanggal + ' (Jam ' + ab.jam_ke + ')</td>' +
                                '<td><span style="font-weight: 800; color: #dc2626;">' + ab.keterangan + '</span></td>' +
                                '<td>' + ab.nama_mapel + '</td>';
                absenBody.appendChild(row);
            });
        } else {
            absenBody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #166534; font-weight: 700; padding: 16px;"><i class="fa-solid fa-circle-check"></i> Kehadiran siswa lengkap (Nihil tidak hadir).</td></tr>';
        }

        openModal('modalDetailKelas');
    }

    // 3. OPEN DETAIL IZIN MODAL
    function openModalDetailIzin(gi) {
        var guruName = (gi.guru && gi.guru.nama_guru) ? gi.guru.nama_guru : 'Guru';
        var guruNip = (gi.guru && gi.guru.nip) ? gi.guru.nip : '-';
        var guruMapel = (gi.guru && gi.guru.mapel && gi.guru.mapel.nama_mapel) ? gi.guru.mapel.nama_mapel : '-';

        document.getElementById('modalIzinNamaGuru').textContent = guruName;
        document.getElementById('modalIzinNipGuru').textContent = 'NIP: ' + guruNip;
        document.getElementById('modalIzinMapel').textContent = guruMapel;
        document.getElementById('modalIzinKategori').textContent = gi.kategori_izin || gi.kategori || 'Izin';

        var tglMulai = gi.tanggal_mulai ? new Date(gi.tanggal_mulai).toLocaleDateString('id-ID') : '-';
        var tglSelesai = gi.tanggal_selesai ? new Date(gi.tanggal_selesai).toLocaleDateString('id-ID') : '-';
        document.getElementById('modalIzinTanggal').textContent = tglMulai + ' s/d ' + tglSelesai + ' (' + (gi.durasi || '1 Hari') + ')';

        document.getElementById('modalIzinAlasan').textContent = gi.alasan || '-';

        // Status Badge
        var statusBadge = '';
        if (gi.status_kepsek === 'approved') {
            statusBadge = '<span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px;"><i class="fa-solid fa-check"></i> Disetujui</span>';
        } else if (gi.status_kepsek === 'rejected') {
            statusBadge = '<span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px;"><i class="fa-solid fa-xmark"></i> Ditolak</span>';
        } else {
            statusBadge = '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px;"><i class="fa-solid fa-clock"></i> Menunggu</span>';
        }
        document.getElementById('modalIzinStatusBadge').innerHTML = statusBadge;

        // Catatan Kepsek
        var catatanBox = document.getElementById('modalIzinCatatanBox');
        if (gi.catatan_kepsek) {
            catatanBox.style.display = 'block';
            document.getElementById('modalIzinCatatanKepsek').textContent = gi.catatan_kepsek;
        } else {
            catatanBox.style.display = 'none';
        }

        // Foto preview
        var fotoContainer = document.getElementById('modalIzinFotoContainer');
        var fotoImg = document.getElementById('modalIzinFotoImg');
        if (gi.foto_url) {
            fotoContainer.style.display = 'flex';
            fotoImg.src = gi.foto_url;
        } else {
            fotoContainer.style.display = 'none';
        }

        openModal('modalDetailIzin');
    }

    // 4. OPEN DETAIL SISWA ABSEN MODAL
    function openModalDetailSiswa(sa) {
        document.getElementById('modalSiswaNama').textContent = sa.nama_siswa || '-';
        document.getElementById('modalSiswaNisn').textContent = 'NISN: ' + (sa.nisn || '-');
        document.getElementById('modalSiswaKelas').textContent = sa.nama_kelas || '-';

        var statusBadge = '';
        if (sa.status === 'Sakit') {
            statusBadge = '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">Sakit</span>';
        } else if (sa.status === 'Dispensasi') {
            statusBadge = '<span style="background: #f5f3ff; color: #6b21a8; padding: 4px 12px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">Dispensasi</span>';
        } else if (sa.status === 'Alpa') {
            statusBadge = '<span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">Alpa</span>';
        } else {
            statusBadge = '<span style="background: #eff6ff; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">Izin</span>';
        }
        document.getElementById('modalSiswaStatusBadge').innerHTML = statusBadge;

        document.getElementById('modalSiswaTanggal').textContent = sa.tanggal || '-';
        document.getElementById('modalSiswaJam').textContent = 'Jam Ke: ' + (sa.jam_ke || '-');
        document.getElementById('modalSiswaMapel').textContent = sa.nama_mapel || '-';
        document.getElementById('modalSiswaGuru').textContent = 'Guru Pengampu: ' + (sa.nama_guru || '-');
        document.getElementById('modalSiswaMateri').textContent = sa.materi || '-';
        document.getElementById('modalSiswaCatatan').textContent = 'Kondisi Kelas: ' + (sa.kondisi_kelas || 'Kondusif') + ' | Catatan: ' + (sa.catatan || '-');

        openModal('modalDetailSiswa');
    }

    // ==========================================
    // INSTANT LIVE SEARCH & FILTER FOR ALL TABS
    // ==========================================

    // Tab 1: Live Filter Guru
    function filterTableGuru() {
        var search = document.getElementById("searchGuruInput").value.toLowerCase();
        var evaluasi = document.getElementById("filterGuruEvaluasi").value;
        var rows = document.querySelectorAll("#tableRekapGuru tbody tr.row-guru-item");
        var visibleCount = 0;

        rows.forEach(function(row) {
            var nama = row.getAttribute("data-nama") || "";
            var nip = row.getAttribute("data-nip") || "";
            var mapel = row.getAttribute("data-mapel") || "";
            var rowEval = row.getAttribute("data-evaluasi") || "";

            var matchesSearch = (nama.indexOf(search) > -1 || nip.indexOf(search) > -1 || mapel.indexOf(search) > -1);
            var matchesEval = (evaluasi === "" || rowEval === evaluasi);

            if (matchesSearch && matchesEval) {
                row.style.display = "";
                visibleCount++;
                var noCell = row.querySelector(".guru-row-no");
                if (noCell) noCell.textContent = visibleCount;
            } else {
                row.style.display = "none";
            }
        });

        var countBadge = document.getElementById("countGuruBadge");
        if (countBadge) countBadge.textContent = visibleCount;
    }

    // Tab 2: Live Filter Kelas
    function filterTableKelas() {
        var search = document.getElementById("searchKelasInput").value.toLowerCase();
        var absenFilter = document.getElementById("filterKelasAbsen").value;
        var rows = document.querySelectorAll("#tableRekapKelas tbody tr.row-kelas-item");
        var visibleCount = 0;

        rows.forEach(function(row) {
            var nama = row.getAttribute("data-nama") || "";
            var rowAbsen = row.getAttribute("data-absen") || "";

            var matchesSearch = (nama.indexOf(search) > -1);
            var matchesAbsen = (absenFilter === "" || rowAbsen === absenFilter);

            if (matchesSearch && matchesAbsen) {
                row.style.display = "";
                visibleCount++;
                var noCell = row.querySelector(".kelas-row-no");
                if (noCell) noCell.textContent = visibleCount;
            } else {
                row.style.display = "none";
            }
        });

        var countBadge = document.getElementById("countKelasBadge");
        if (countBadge) countBadge.textContent = visibleCount;
    }

    // Tab 3: Live Filter Izin
    function filterTableIzin() {
        var search = document.getElementById("searchIzinInput").value.toLowerCase();
        var statusFilter = document.getElementById("filterIzinStatus").value;
        var rows = document.querySelectorAll("#tableRekapIzin tbody tr.row-izin-item");
        var visibleCount = 0;

        rows.forEach(function(row) {
            var nama = row.getAttribute("data-nama") || "";
            var nip = row.getAttribute("data-nip") || "";
            var mapel = row.getAttribute("data-mapel") || "";
            var alasan = row.getAttribute("data-alasan") || "";
            var rowStatus = row.getAttribute("data-status") || "";

            var matchesSearch = (nama.indexOf(search) > -1 || nip.indexOf(search) > -1 || mapel.indexOf(search) > -1 || alasan.indexOf(search) > -1);
            var matchesStatus = (statusFilter === "" || rowStatus === statusFilter);

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
                visibleCount++;
                var noCell = row.querySelector(".izin-row-no");
                if (noCell) noCell.textContent = visibleCount;
            } else {
                row.style.display = "none";
            }
        });

        var countBadge = document.getElementById("countIzinBadge");
        if (countBadge) countBadge.textContent = visibleCount;
    }

    // Tab 4: Live Filter Siswa Absen
    function filterTableSiswa() {
        var search = document.getElementById("filterSiswaInput").value.toLowerCase();
        var statusFilter = document.getElementById("filterSiswaStatus").value;
        var rows = document.querySelectorAll("#tableSiswaAbsen tbody tr.row-siswa-item");
        var visibleCount = 0;

        rows.forEach(function(row) {
            var nama = row.getAttribute("data-nama") || "";
            var nisn = row.getAttribute("data-nisn") || "";
            var kelas = row.getAttribute("data-kelas") || "";
            var mapel = row.getAttribute("data-mapel") || "";
            var guru = row.getAttribute("data-guru") || "";
            var rowStatus = row.getAttribute("data-status") || "";

            var matchesSearch = (nama.indexOf(search) > -1 || nisn.indexOf(search) > -1 || kelas.indexOf(search) > -1 || mapel.indexOf(search) > -1 || guru.indexOf(search) > -1);
            var matchesStatus = (statusFilter === "" || rowStatus === statusFilter);

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
                visibleCount++;
                var noCell = row.querySelector(".siswa-row-no");
                if (noCell) noCell.textContent = visibleCount;
            } else {
                row.style.display = "none";
            }
        });

        var countBadge = document.getElementById("countSiswaBadge");
        if (countBadge) countBadge.textContent = visibleCount;
    }
</script>
@endsection