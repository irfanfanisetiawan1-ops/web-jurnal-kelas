@extends('layouts.guru')

@section('title', 'Jurnal Mengajar Guru — Guru Piket')
@section('header_title', 'Jurnal Mengajar Guru')

@section('styles')
<style>
    /* Main Layout & Colors (Kombinasi Abu-abu, Biru, Putih, Abu-abu Muda Cerah) */
    .jurnal-mengajar-container {
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

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-header-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .btn-header-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-header-navy {
        background: #2b3957;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(43, 57, 87, 0.25);
    }
    .btn-header-navy:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-header-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .btn-header-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* 4 Stat Cards Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card {
        background: #ffffff;
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
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-slate  { background: #f1f5f9; color: #384972; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
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

    /* Verification & Signature Status Banner (Modern Card: Gray, Blue, White, Light Gray) */
    .verification-banner-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
    }

    .verification-verified {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #16a34a;
    }

    .verification-ready {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #2563eb;
    }

    .verification-locked {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #94a3b8;
    }

    .verification-future {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #cbd5e1;
    }

    .verif-left-content {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .verif-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .verif-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .btn-signature-action {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 11px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-signature-action:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }

    .btn-signature-locked {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #cbd5e1;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Filter Form Styling */
    .filter-bar-container {
        margin-bottom: 22px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .filter-grid-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-input-text {
        flex: 1.6;
        min-width: 220px;
        position: relative;
    }

    .filter-input-text input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-input-text input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-input-text i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-select {
        flex: 1;
        min-width: 150px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-submit {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease, transform 0.15s ease;
    }

    .btn-filter-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
    }

    .btn-filter-reset {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-filter-reset:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Custom Table Styling (Clean Slate Header) */
    .custom-jurnal-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-jurnal-table th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        padding: 13px 14px;
        text-align: left;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .custom-jurnal-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; border-left: 1px solid #e2e8f0; }
    .custom-jurnal-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; border-right: 1px solid #e2e8f0; }

    .custom-jurnal-table td {
        padding: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-jurnal-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .date-cell {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .date-day {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .date-month {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .badge-status-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-terlaksana {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .badge-belum-terlaksana {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .badge-verif-yes {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-verif-no {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action-icon:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    /* Modal Overlay & Box */
    .custom-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .custom-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        animation: modalPop 0.2s ease-out;
    }

    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.96); }
        100% { opacity: 1; transform: scale(1); }
    }

    .modal-header-styled {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-radius: 20px 20px 0 0;
    }

    .modal-body-styled {
        padding: 24px;
    }

    .modal-footer-styled {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Signature Canvas Area */
    .signature-pad-wrapper {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        position: relative;
        touch-action: none;
        overflow: hidden;
    }

    .signature-canvas {
        width: 100%;
        height: 180px;
        display: block;
        cursor: crosshair;
    }

    .signature-placeholder-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
        font-weight: 600;
        text-align: center;
    }

    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-grid { grid-template-columns: 1fr; }
        .verification-banner-box { flex-direction: column; align-items: flex-start; }
        .verif-actions { width: 100%; justify-content: flex-start; }
    }
</style>
@endsection

@section('content')

@php
    $daysMapIndo = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu'
    ];
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    if (!empty($tanggalFilter)) {
        $cFilter = \Carbon\Carbon::parse($tanggalFilter);
        $filterDayIndo = $daysMapIndo[$cFilter->format('l')] ?? $cFilter->format('l');
        $filterDateFormatted = $filterDayIndo . ', ' . $cFilter->day . ' ' . $monthsMapIndo[$cFilter->month] . ' ' . $cFilter->year;
    } else {
        $filterDateFormatted = 'Semua Tanggal';
    }

    $cSig = \Carbon\Carbon::parse($dateForSignature);
    $sigDayIndo = $daysMapIndo[$cSig->format('l')] ?? 'Senin';
    $sigDateFormatted = $sigDayIndo . ', ' . $cSig->day . ' ' . $monthsMapIndo[$cSig->month] . ' ' . $cSig->year;
@endphp

<div class="jurnal-mengajar-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jurnal Mengajar Guru</h1>
            <p>Monitoring, evaluasi, dan pengesahan tanda tangan jurnal mengajar harian guru</p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-navy">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekap Harian</span>
            </a>
            <a href="{{ route('piket.jurnal-mengajar.export', request()->query()) }}" class="btn-header-action btn-header-secondary">
                <i class="fa-solid fa-download"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards) Dinamis dari Database -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Pertemuan</span>
                <span class="stat-val">{{ $stats['totalPertemuan'] }} Pertemuan</span>
                <span class="stat-subtext">{{ !empty($tanggalFilter) ? 'Pada ' . \Carbon\Carbon::parse($tanggalFilter)->translatedFormat('d M Y') : 'Seluruh periode terpilih' }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Terlaksana</span>
                <span class="stat-val">{{ $stats['terlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">KBM guru hadir / pengganti</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-amber">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Terlaksana</span>
                <span class="stat-val">{{ $stats['belumTerlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">{{ $stats['pctBelum'] }}% dari total sesi</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-slate">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Aktif</span>
                <span class="stat-val">{{ $stats['guruAktif'] }} Guru</span>
                <span class="stat-subtext">Mengajar pada filter ini</span>
            </div>
        </div>
    </div>

    <!-- 2. CARD STATUS TANDA TANGAN & VERIFIKASI GURU PIKET HARIAN (Ringkas & Harmonis) -->
    @if($verifikasiHariIni)
        <!-- Kondisi 1: Jurnal Sudah Ditandatangani & Diverifikasi Resmi -->
        <div class="verification-banner-box verification-verified">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jurnal Mengajar Tanggal {{ $sigDateFormatted }}
                        </span>
                        <span style="background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-circle-check"></i> Terverifikasi
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 3px; font-weight: 500;">
                        Divalidasi oleh <strong>{{ $verifikasiHariIni->nama_guru_piket }}</strong> pada {{ \Carbon\Carbon::parse($verifikasiHariIni->waktu_verifikasi)->format('d/m/Y H:i') }} WIB ({{ $verifikasiHariIni->total_jurnal_diverifikasi }} jurnal sah).
                        @if($verifikasiHariIni->catatan)
                            <span style="color: #64748b; font-style: italic;">• Catatan: "{{ $verifikasiHariIni->catatan }}"</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" onclick="showSignaturePreviewModal()" class="btn-header-action btn-header-navy" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-eye"></i>
                    <span>Lihat TTD</span>
                </button>
                <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-primary" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Ber-TTD</span>
                </a>
                <form action="{{ route('piket.jurnal-mengajar.batal-tanda-tangan') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tanda tangan verifikasi untuk tanggal ini? Anda dapat menandatangani ulang kembali setelahnya.')" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $dateForSignature }}">
                    <button type="submit" style="background: #ffffff; color: #dc2626; border: 1px solid #fecaca; padding: 8px 13px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fa-solid fa-rotate-left"></i> Batal TTD
                    </button>
                </form>
            </div>
        </div>

    @elseif($isJamSekolahSelesai)
        <!-- Kondisi 2: Jam KBM Selesai & Siap Ditandatangani Guru Piket -->
        <div class="verification-banner-box verification-ready">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                    <i class="fa-solid fa-signature"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jurnal Mengajar Tanggal {{ $sigDateFormatted }}
                        </span>
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-pen-fancy"></i> Siap Ditandatangani
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 3px; font-weight: 500;">
                        KBM telah selesai (Pukul {{ $jamSelesaiSekolah }} WIB). Silakan periksa data KBM lalu bubuhkan tanda tangan verifikasi harian.
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" onclick="openSignatureModal()" class="btn-signature-action" style="padding: 9px 18px; font-size: 13px;">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span>Tanda Tangani Jurnal Harian</span>
                </button>
                <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-navy" style="padding: 9px 16px; font-size: 13px;">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Rekap</span>
                </a>
            </div>
        </div>

    @elseif($isTodayDate)
        <!-- Kondisi 3: KBM Masih Berlangsung Hari Ini -->
        <div class="verification-banner-box verification-locked">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jam Pembelajaran KBM Masih Berlangsung
                        </span>
                        <span style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-lock"></i> Belum Dibuka
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px; font-weight: 500;">
                        Tanda tangan verifikasi dibuka setelah jam pembelajaran berakhir (Pukul <strong>{{ $jamSelesaiSekolah }} WIB</strong>).
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" class="btn-signature-locked" style="padding: 9px 16px; font-size: 12.5px;" disabled title="Tanda tangan baru aktif setelah jam KBM sekolah berakhir pukul {{ $jamSelesaiSekolah }} WIB">
                    <i class="fa-solid fa-lock"></i> Dibuka Pukul {{ $jamSelesaiSekolah }} WIB
                </button>
            </div>
        </div>

    @else
        <!-- Kondisi 4: Tanggal Depan -->
        <div class="verification-banner-box verification-future">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #475569;">
                            Tanggal Pembelajaran Mendatang
                        </span>
                        <span style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-regular fa-calendar"></i> Belum Berlangsung
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px; font-weight: 500;">
                        Tanda tangan verifikasi hanya tersedia untuk tanggal yang telah selesai KBM.
                    </div>
                </div>
            </div>
            <div class="verif-actions">
                <button type="button" class="btn-signature-locked" style="padding: 9px 16px; font-size: 12.5px;" disabled>
                    <i class="fa-regular fa-calendar-xmark"></i> Belum Berlangsung
                </button>
            </div>
        </div>
    @endif

    <!-- 3. Main Table Panel: Daftar Jurnal Mengajar -->
    <div class="main-table-panel">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-book-open-reader" style="color: #2563eb;"></i>
                <span>Daftar Jurnal Mengajar Guru</span>
                <span style="font-size: 12.5px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 10px; border-radius: 20px; font-weight: 800;">
                    Total: {{ $jurnals->total() }} Sesi
                </span>
            </div>

            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                Menampilkan tanggal: <strong style="color: #0f172a;">{{ $filterDateFormatted }}</strong>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.jurnal-mengajar') }}" method="GET">
                <div class="filter-grid-row">
                    <div class="filter-input-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari Mata Pelajaran / Guru / Kelas...">
                    </div>

                    <div>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-select" title="Filter Tanggal Spesifik">
                    </div>

                    <div>
                        <select name="id_guru" class="filter-select">
                            <option value="">👤 Semua Guru</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_kelas" class="filter-select">
                            <option value="">🏫 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_mapel" class="filter-select">
                            <option value="">📖 Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="status" class="filter-select">
                            <option value="">Status KBM</option>
                            <option value="terlaksana" {{ $statusFilter === 'terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                            <option value="belum" {{ $statusFilter === 'belum' ? 'selected' : '' }}>Belum Terlaksana</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter-submit">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Data Jurnal -->
        <div style="overflow-x: auto;">
            <table class="custom-jurnal-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th style="width: 115px;">Kelas &amp; Ruang</th>
                        <th>Guru Pengampu</th>
                        <th>Materi Pembelajaran</th>
                        <th style="width: 85px;">Pertemuan</th>
                        <th style="width: 110px; text-align: center;">Status KBM</th>
                        <th style="width: 125px; text-align: center;">Verifikasi Piket</th>
                        <th style="width: 85px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $row)
                        @php
                            $tgl = $row->tanggal ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $tgl ? $tgl->format('d') : '-';
                            $monthStr = $tgl ? strtoupper($tgl->translatedFormat('M Y')) : '-';
                            
                            $isTerlaksana = ($row->status_kehadiran_guru ?? 'Hadir') === 'Hadir';
                            $verifRecord = $row->verifikasiPiket;
                            $isVerified = ($verifRecord && $verifRecord->status === 'terverifikasi');
                        @endphp
                        <tr>
                            <td>
                                <div class="date-cell">
                                    <span class="date-day">{{ $dayStr }}</span>
                                    <span class="date-month">{{ $monthStr }}</span>
                                </div>
                            </td>

                            <td>
                                <strong style="color: #0f172a; font-size: 13.5px;">{{ $row->jadwal->mapel->nama_mapel ?? ($row->mapel_nama ?? '-') }}</strong>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Jam ke-{{ $row->jadwal->jam_range ?? ($row->jam_ke ?? '-') }} &bull; {{ $row->jadwal->waktu_mulai_effective ?? '07:00' }} - {{ $row->jadwal->waktu_selesai_effective ?? '08:20' }} WIB
                                </div>
                            </td>

                            <td>
                                <strong style="color: #1e293b;">{{ $row->jadwal->kelas->nama_kelas ?? ($row->kelas_nama ?? '-') }}</strong>
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                    <i class="fa-solid fa-location-dot" style="font-size: 10px; color: #3b82f6;"></i> {{ $row->jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                                </div>
                            </td>

                            <td>
                                @if($row->id_guru_pengganti && $row->guruPengganti)
                                    <strong style="color: #0f172a;">{{ $row->guruPengganti->nama_guru }}</strong>
                                    <div style="font-size: 10.5px; color: #2563eb; font-weight: 700; margin-top: 1px;">
                                        <i class="fa-solid fa-user-shield"></i> Guru Pengganti
                                    </div>
                                    <div style="font-size: 10px; color: #64748b;">(Guru Utama: {{ $row->jadwal->guru->nama_guru ?? '-' }})</div>
                                @else
                                    <strong style="color: #0f172a;">{{ $row->jadwal->guru->nama_guru ?? ($row->guru_nama ?? '-') }}</strong>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 1px;">
                                        NIP: {{ $row->jadwal->guru->nip ?? '-' }}
                                    </div>
                                @endif
                            </td>

                            <td style="max-width: 260px;">
                                <div style="font-weight: 600; color: #1e293b; line-height: 1.35;">
                                    {{ Str::limit($row->materi ?? '-', 75) }}
                                </div>
                                @if($row->kondisi_kelas)
                                    <span style="font-size: 10.5px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 1px 6px; border-radius: 4px; display: inline-block; margin-top: 3px;">
                                        Kondisi: {{ $row->kondisi_kelas }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span style="font-weight: 800; color: #0f172a;">{{ $row->pertemuan_ke ?? 'Ke-1' }}</span>
                                <div style="font-size: 11px; color: #64748b;">
                                    {{ $row->jadwal->jumlah_jp ?? 2 }} JP
                                </div>
                            </td>

                            <td style="text-align: center;">
                                <span class="badge-status-pill {{ $isTerlaksana ? 'badge-terlaksana' : 'badge-belum-terlaksana' }}">
                                    <i class="fa-solid {{ $isTerlaksana ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                    {{ $isTerlaksana ? 'Terlaksana' : 'Belum' }}
                                </span>
                            </td>

                            <td style="text-align: center;">
                                @if($isVerified)
                                    <span class="badge-status-pill badge-verif-yes" title="Diverifikasi oleh: {{ $verifRecord->nama_guru_piket }}">
                                        <i class="fa-solid fa-signature"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="badge-status-pill badge-verif-no">
                                        <i class="fa-solid fa-hourglass-half"></i> Menunggu TTD
                                    </span>
                                @endif
                            </td>

                            <td style="text-align: center;">
                                <button type="button" class="btn-action-icon" onclick="openJurnalDetailModal({{ $row->id_jurnal }})" title="Lihat Detail Lengkap Jurnal & Presensi">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #94a3b8; padding: 45px 20px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 38px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                Tidak ada data jurnal mengajar yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                Menampilkan {{ $jurnals->firstItem() ?? 0 }} - {{ $jurnals->lastItem() ?? 0 }} dari {{ $jurnals->total() }} data jurnal
            </div>
            <div>
                {{ $jurnals->links() }}
            </div>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL 1: TANDA TANGAN GURU PIKET HARIAN (CANVAS SIGNATURE PAD INTERAKTIF) -->
<!-- ========================================================================= -->
<div id="signatureModal" class="custom-modal-backdrop">
    <div class="custom-modal-box">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 17px;">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Tanda Tangan Pengesahan Guru Piket</h3>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">Pengesahan resmi seluruh jurnal mengajar pada tanggal terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeSignatureModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('piket.jurnal-mengajar.tanda-tangan') }}" method="POST" id="formSignaturePiket" onsubmit="return validateSignatureSubmit()">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $dateForSignature }}">
            <input type="hidden" name="tanda_tangan" id="inputTandaTanganBase64">

            <div class="modal-body-styled">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; font-size: 12.5px; color: #1e40af; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 18px; flex-shrink: 0;"></i>
                    <span>Tanda tangan ini berlaku untuk <strong>seluruh {{ $stats['totalPertemuan'] }} Jurnal Mengajar</strong> yang terkirim pada hari <strong>{{ $sigDateFormatted }}</strong>.</span>
                </div>

                <!-- 1. Pilihan Guru Piket yang Menandatangani -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Pilih Guru Piket yang Menandatangani <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="id_guru" id="selectGuruPiketTtd" required style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #0f172a; outline: none; background: #fff;">
                        <option value="">-- Pilih Guru Piket --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($defaultGuruPiket && $defaultGuruPiket->id_guru == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }} {{ $g->nip ? '(NIP: ' . $g->nip . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Interactive Signature Pad Canvas -->
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <label style="font-size: 13px; font-weight: 700; color: #1e293b;">
                            Bubuhkan Tanda Tangan Digital <span style="color: #dc2626;">*</span>
                        </label>
                        <button type="button" onclick="clearSignatureCanvas()" style="background: none; border: none; font-size: 12px; color: #dc2626; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-rotate-left"></i> Bersihkan
                        </button>
                    </div>

                    <div class="signature-pad-wrapper" id="sigPadWrapper">
                        <canvas id="sigCanvas" class="signature-canvas"></canvas>
                        <div class="signature-placeholder-text" id="sigPlaceholder">
                            <i class="fa-solid fa-signature"></i> Gambar tanda tangan Anda di sini menggunakan mouse / sentuhan jari
                        </div>
                    </div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        Goreskan pena tanda tangan secara langsung di dalam kotak di atas.
                    </div>
                </div>

                <!-- 3. Catatan Evaluasi Pembelajaran Hari Ini -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Catatan Evaluasi KBM Guru Piket (Opsional)
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: KBM terlaksana tertib, kelas XI RPL 1 didampingi guru pengganti karena guru pengampu izin dinas luar..." style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; box-sizing: border-box; resize: vertical; font-family: inherit; color: #1e293b;"></textarea>
                </div>

                <!-- 4. Checkbox Pernyataan Keabsahan Dokumen -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 12.5px; color: #334155; line-height: 1.4;">
                        <input type="checkbox" id="checkPernyataanSah" required style="margin-top: 2px; cursor: pointer;">
                        <span>Dengan ini saya menyatakan sebagai <strong>Guru Piket</strong> telah memeriksa, memvalidasi, dan memastikan kebenaran seluruh laporan Jurnal Mengajar pada tanggal ini sebagai dokumen administrasi sekolah resmi.</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer-styled">
                <button type="button" onclick="closeSignatureModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">Batal</button>
                <button type="submit" class="btn-signature-action">
                    <i class="fa-solid fa-check"></i> Simpan &amp; Sahkan Tanda Tangan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: DETAIL LENGKAP JURNAL MENGAJAR (AJAX COMPREHENSIVE VIEW)        -->
<!-- ========================================================================= -->
<div id="jurnalDetailModal" class="custom-modal-backdrop">
    <div class="custom-modal-box" style="max-width: 720px;">
        <div class="modal-header-styled">
            <div>
                <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;" id="mdMapelKelas">-</h3>
                <p style="margin: 0; font-size: 12px; color: #64748b;" id="mdTanggalJam">-</p>
            </div>
            <button type="button" onclick="closeJurnalDetailModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div class="modal-body-styled" id="mdLoadingState" style="text-align: center; padding: 40px;">
            <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 32px; color: #2563eb;"></i>
            <div style="margin-top: 10px; font-size: 13px; color: #64748b; font-weight: 600;">Memuat data lengkap jurnal mengajar...</div>
        </div>

        <div class="modal-body-styled" id="mdContentState" style="display: none;">
            
            <!-- Grid Data KBM -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">GURU PENGAMPU</div>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mdGuru">-</div>
                    <div style="font-size: 11px; color: #64748b;" id="mdNipGuru">NIP: -</div>
                    <div id="mdBadgeGuruPengganti" style="display: none; margin-top: 4px;">
                        <span style="font-size: 10.5px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 2px 6px; border-radius: 4px; font-weight: 700;">
                            <i class="fa-solid fa-user-shield"></i> Guru Pengganti: <span id="mdNamaPengganti">-</span>
                        </span>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">ALOKASI WAKTU &amp; KELAS</div>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mdAlokasi">-</div>
                    <div style="font-size: 11px; color: #64748b;" id="mdRuangan">Ruangan: -</div>
                    <div style="margin-top: 4px;">
                        <span id="mdBadgeStatusKbm" class="badge-status-pill badge-terlaksana">Terlaksana</span>
                    </div>
                </div>
            </div>

            <!-- Materi & Catatan Pembelajaran -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px; background: #ffffff;">
                <div style="margin-bottom: 10px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Materi yang Diajarkan:</div>
                    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin-top: 2px;" id="mdMateri">-</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748b;">KONDISI KELAS:</div>
                        <div style="font-size: 13px; font-weight: 700; color: #1e293b;" id="mdKondisiKelas">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748b;">CATATAN GURU:</div>
                        <div style="font-size: 12.5px; color: #334155;" id="mdCatatanGuru">-</div>
                    </div>
                </div>
            </div>

            <!-- Foto Kehadiran Live Kamera -->
            <div id="mdFotoWrap" style="margin-bottom: 18px; display: none;">
                <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                    <i class="fa-solid fa-camera" style="color: #2563eb;"></i> Foto Kehadiran KBM (Live Kamera)
                </div>
                <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px; background: #f8fafc; text-align: center;">
                    <img id="mdFotoImg" src="" alt="Foto Kehadiran" style="max-height: 220px; max-width: 100%; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <!-- Presensi Siswa -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px; background: #ffffff;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <div style="font-size: 13px; font-weight: 800; color: #0f172a;">
                        <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi Kehadiran Siswa
                    </div>
                    <div style="font-size: 12px; color: #64748b; font-weight: 600;" id="mdTotalSiswaTeks">
                        Total: 0 Siswa
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 12px;">
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #166534; font-weight: 700;">HADIR</div>
                        <div style="font-size: 18px; font-weight: 800; color: #15803d;" id="mdHadirCount">0</div>
                    </div>
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #1e40af; font-weight: 700;">SAKIT</div>
                        <div style="font-size: 18px; font-weight: 800; color: #2563eb;" id="mdSakitCount">0</div>
                    </div>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #92400e; font-weight: 700;">IZIN</div>
                        <div style="font-size: 18px; font-weight: 800; color: #d97706;" id="mdIzinCount">0</div>
                    </div>
                    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #991b1b; font-weight: 700;">ALPA</div>
                        <div style="font-size: 18px; font-weight: 800; color: #dc2626;" id="mdAlpaCount">0</div>
                    </div>
                </div>

                <div id="mdDaftarAbsenWrap" style="display: none;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Daftar Siswa Tidak Hadir:</div>
                    <div style="max-height: 120px; overflow-y: auto; border: 1px solid #f1f5f9; border-radius: 8px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <tbody id="mdDaftarAbsenTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Verifikasi & Tanda Tangan Guru Piket -->
            <div style="border: 1.5px solid #86efac; background: #f0fdf4; border-radius: 12px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 16px;" id="mdVerifSectionYes">
                <div>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 800; color: #166534;">
                        <i class="fa-solid fa-circle-check"></i> Jurnal Terverifikasi &amp; Ditandatangani Guru Piket
                    </div>
                    <div style="font-size: 12px; color: #15803d; margin-top: 2px;" id="mdVerifGuruPiketTeks">
                        Oleh: -
                    </div>
                    <div style="font-size: 11px; color: #475569; margin-top: 1px;" id="mdVerifWaktuTeks">
                        Waktu: -
                    </div>
                </div>
                <div id="mdVerifTtdThumbWrap" style="text-align: right;">
                    <img id="mdVerifTtdImg" src="" alt="Tanda Tangan Piket" style="max-height: 55px; max-width: 140px; border: 1px solid #bbf7d0; background: #fff; border-radius: 6px; padding: 3px;">
                </div>
            </div>

            <div style="border: 1px solid #cbd5e1; background: #f8fafc; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px;" id="mdVerifSectionNo">
                <i class="fa-solid fa-hourglass-half" style="font-size: 20px; color: #94a3b8;"></i>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: #334155;">Belum Ditandatangani Guru Piket</div>
                    <div style="font-size: 11.5px; color: #64748b;">Pengesahan tanda tangan harian dilakukan oleh Guru Piket setelah seluruh jam KBM hari ini selesai.</div>
                </div>
            </div>

        </div>

        <div class="modal-footer-styled">
            <button type="button" onclick="closeJurnalDetailModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 3: PREVIEW TANDA TANGAN GURU PIKET                                 -->
<!-- ========================================================================= -->
@if($verifikasiHariIni)
<div id="previewSigModal" class="custom-modal-backdrop">
    <div class="custom-modal-box" style="max-width: 480px;">
        <div class="modal-header-styled">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Tanda Tangan Guru Piket Resmi</h3>
            <button type="button" onclick="closeSignaturePreviewModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body-styled" style="text-align: center;">
            <div style="border: 2px dashed #bbf7d0; background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
                <img src="{{ $verifikasiHariIni->tanda_tangan }}" alt="Tanda Tangan Guru Piket" style="max-height: 120px; max-width: 100%;">
            </div>
            <div style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $verifikasiHariIni->nama_guru_piket }}</div>
            <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">NIP: {{ $verifikasiHariIni->nip_guru_piket ?? '-' }}</div>
            <div style="font-size: 11.5px; color: #166534; background: #dcfce7; display: inline-block; padding: 3px 10px; border-radius: 20px; font-weight: 700; margin-top: 8px;">
                Diverifikasi pada: {{ \Carbon\Carbon::parse($verifikasiHariIni->waktu_verifikasi)->translatedFormat('l, d F Y H:i') }} WIB
            </div>
            @if($verifikasiHariIni->catatan)
                <div style="margin-top: 14px; font-size: 12.5px; color: #334155; background: #f1f5f9; padding: 10px; border-radius: 8px; text-align: left;">
                    <strong>Catatan Evaluasi:</strong><br>
                    {{ $verifikasiHariIni->catatan }}
                </div>
            @endif
        </div>
        <div class="modal-footer-styled">
            <button type="button" onclick="closeSignaturePreviewModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>
@endif

<!-- ========================================================================= -->
<!-- JAVASCRIPT: SIGNATURE CANVAS & MODAL SCRIPTS                             -->
<!-- ========================================================================= -->
<script>
    /* === 1. SIGNATURE PAD CANVAS LOGIC === */
    let canvas = null;
    let ctx = null;
    let isDrawing = false;
    let hasDrawn = false;
    let lastX = 0;
    let lastY = 0;

    function initSignaturePad() {
        canvas = document.getElementById('sigCanvas');
        if (!canvas) return;
        ctx = canvas.getContext('2d');

        // Set proper internal canvas resolution based on display size
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width * 2;
        canvas.height = rect.height * 2;
        ctx.scale(2, 2);

        ctx.strokeStyle = '#1e3a8a';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Mouse Event Listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        // Touch Event Listeners
        canvas.addEventListener('touchstart', handleTouchStart, { passive: false });
        canvas.addEventListener('touchmove', handleTouchMove, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);
    }

    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

    function startDrawing(e) {
        isDrawing = true;
        const pos = getMousePos(e);
        lastX = pos.x;
        lastY = pos.y;
        document.getElementById('sigPlaceholder').style.display = 'none';
    }

    function draw(e) {
        if (!isDrawing) return;
        const pos = getMousePos(e);

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();

        lastX = pos.x;
        lastY = pos.y;
        hasDrawn = true;
    }

    function stopDrawing() {
        isDrawing = false;
    }

    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        lastX = touch.clientX - rect.left;
        lastY = touch.clientY - rect.top;
        isDrawing = true;
        document.getElementById('sigPlaceholder').style.display = 'none';
    }

    function handleTouchMove(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        const x = touch.clientX - rect.left;
        const y = touch.clientY - rect.top;

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();

        lastX = x;
        lastY = y;
        hasDrawn = true;
    }

    function clearSignatureCanvas() {
        if (!canvas || !ctx) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawn = false;
        document.getElementById('sigPlaceholder').style.display = 'block';
        document.getElementById('inputTandaTanganBase64').value = '';
    }

    function openSignatureModal() {
        document.getElementById('signatureModal').style.display = 'flex';
        setTimeout(() => {
            initSignaturePad();
        }, 150);
    }

    function closeSignatureModal() {
        document.getElementById('signatureModal').style.display = 'none';
        clearSignatureCanvas();
    }

    function validateSignatureSubmit() {
        if (!hasDrawn) {
            alert('Silakan bubuhkan goresan tanda tangan digital Anda di dalam kotak canvas.');
            return false;
        }

        const selGuru = document.getElementById('selectGuruPiketTtd').value;
        if (!selGuru) {
            alert('Silakan pilih nama Guru Piket yang bertugas menandatangani.');
            return false;
        }

        const chkSah = document.getElementById('checkPernyataanSah').checked;
        if (!chkSah) {
            alert('Silakan centang persetujuan pernyataan keabsahan dokumen jurnal.');
            return false;
        }

        // Export canvas image to base64
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('inputTandaTanganBase64').value = dataUrl;
        return true;
    }

    function showSignaturePreviewModal() {
        const modal = document.getElementById('previewSigModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeSignaturePreviewModal() {
        const modal = document.getElementById('previewSigModal');
        if (modal) modal.style.display = 'none';
    }

    /* === 2. AJAX DETAIL MODAL LOGIC === */
    function openJurnalDetailModal(idJurnal) {
        const modal = document.getElementById('jurnalDetailModal');
        const loading = document.getElementById('mdLoadingState');
        const content = document.getElementById('mdContentState');

        modal.style.display = 'flex';
        loading.style.display = 'block';
        content.style.display = 'none';

        fetch(`/guru-piket/jurnal-mengajar/detail/${idJurnal}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert('Gagal mengambil data detail jurnal.');
                    closeJurnalDetailModal();
                    return;
                }

                const d = res.data;

                // Header
                document.getElementById('mdMapelKelas').textContent = `${d.mapel} (${d.kelas})`;
                document.getElementById('mdTanggalJam').textContent = `${d.hari}, ${d.tanggal_formatted} • Jam ke-${d.jam_ke} (${d.waktu_kbm})`;

                // Guru
                document.getElementById('mdGuru').textContent = d.guru;
                document.getElementById('mdNipGuru').textContent = `NIP: ${d.nip_guru}`;

                const badgePengganti = document.getElementById('mdBadgeGuruPengganti');
                if (d.is_guru_pengganti && d.guru_pengganti) {
                    badgePengganti.style.display = 'block';
                    document.getElementById('mdNamaPengganti').textContent = d.guru_pengganti;
                } else {
                    badgePengganti.style.display = 'none';
                }

                // Waktu & Ruang
                document.getElementById('mdAlokasi').textContent = `${d.jumlah_jp} (${d.waktu_kbm})`;
                document.getElementById('mdRuangan').textContent = `Ruangan: ${d.ruangan}`;

                const badgeStatus = document.getElementById('mdBadgeStatusKbm');
                badgeStatus.textContent = d.status_kehadiran_guru;
                badgeStatus.className = 'badge-status-pill ' + (d.status_kehadiran_guru === 'Hadir' ? 'badge-terlaksana' : 'badge-belum-terlaksana');

                // Materi & Kondisi
                document.getElementById('mdMateri').textContent = d.materi || '-';
                document.getElementById('mdKondisiKelas').textContent = d.kondisi_kelas || 'Kondusif';
                document.getElementById('mdCatatanGuru').textContent = d.catatan || 'Tidak ada catatan tambahan.';

                // Foto Dokumentasi
                const fotoWrap = document.getElementById('mdFotoWrap');
                const fotoImg = document.getElementById('mdFotoImg');
                if (d.dokumentasi_url) {
                    fotoImg.src = d.dokumentasi_url;
                    fotoWrap.style.display = 'block';
                } else {
                    fotoWrap.style.display = 'none';
                }

                // Presensi Siswa
                document.getElementById('mdTotalSiswaTeks').textContent = `Total: ${d.total_siswa} Siswa`;
                document.getElementById('mdHadirCount').textContent = d.hadir_count;
                document.getElementById('mdSakitCount').textContent = d.sakit_count;
                document.getElementById('mdIzinCount').textContent = d.izin_count;
                document.getElementById('mdAlpaCount').textContent = d.alpa_count;

                // Daftar Siswa Absen
                const absenWrap = document.getElementById('mdDaftarAbsenWrap');
                const absenTbody = document.getElementById('mdDaftarAbsenTable');
                absenTbody.innerHTML = '';

                if (d.daftar_absen && d.daftar_absen.length > 0) {
                    absenWrap.style.display = 'block';
                    d.daftar_absen.forEach((item, idx) => {
                        const tr = document.createElement('tr');
                        tr.style.borderBottom = '1px solid #f1f5f9';
                        tr.innerHTML = `
                            <td style="padding: 6px 10px; width: 24px; color: #64748b;">${idx + 1}.</td>
                            <td style="padding: 6px 10px; font-weight: 700; color: #0f172a;">${item.nama_siswa}</td>
                            <td style="padding: 6px 10px; color: #64748b;">NISN: ${item.nisn}</td>
                            <td style="padding: 6px 10px; text-align: right;">
                                <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 4px; ${item.keterangan === 'Sakit' ? 'background: #eff6ff; color: #2563eb;' : (item.keterangan === 'Izin' ? 'background: #fffbeb; color: #d97706;' : 'background: #fef2f2; color: #dc2626;')}">
                                    ${item.keterangan}
                                </span>
                            </td>
                        `;
                        absenTbody.appendChild(tr);
                    });
                } else {
                    absenWrap.style.display = 'none';
                }

                // Verifikasi Piket
                const vYes = document.getElementById('mdVerifSectionYes');
                const vNo = document.getElementById('mdVerifSectionNo');

                if (d.verifikasi_piket && d.verifikasi_piket.is_verified) {
                    vYes.style.display = 'flex';
                    vNo.style.display = 'none';
                    document.getElementById('mdVerifGuruPiketTeks').textContent = `Oleh: ${d.verifikasi_piket.nama_guru_piket} (NIP: ${d.verifikasi_piket.nip_guru_piket})`;
                    document.getElementById('mdVerifWaktuTeks').textContent = `Waktu Verifikasi: ${d.verifikasi_piket.waktu_verifikasi}`;
                    document.getElementById('mdVerifTtdImg').src = d.verifikasi_piket.tanda_tangan;
                } else {
                    vYes.style.display = 'none';
                    vNo.style.display = 'flex';
                }

                loading.style.display = 'none';
                content.style.display = 'block';
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memuat data jurnal.');
                closeJurnalDetailModal();
            });
    }

    function closeJurnalDetailModal() {
        document.getElementById('jurnalDetailModal').style.display = 'none';
    }

    // Close modals on backdrop click
    window.onclick = function(e) {
        const sigModal = document.getElementById('signatureModal');
        const detModal = document.getElementById('jurnalDetailModal');
        const prevModal = document.getElementById('previewSigModal');

        if (e.target === sigModal) closeSignatureModal();
        if (e.target === detModal) closeJurnalDetailModal();
        if (e.target === prevModal) closeSignaturePreviewModal();
    };
</script>
@endsection