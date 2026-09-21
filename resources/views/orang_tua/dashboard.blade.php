@extends('layouts.orang_tua')

@section('title', 'Dashboard Orang Tua — Jurnal SMEA')

@section('styles')
<style>
    /* Color Palette: Abu-abu, Putih, Abu-abu Muda Cerah */
    :root {
        --color-slate-dark: #1e293b;
        --color-slate-medium: #475569;
        --color-slate-light: #64748b;
        --color-grey-bg: #cbd3e0;
        --color-grey-card: #ffffff;
        --color-grey-border: #e2e8f0;
        --color-grey-soft: #f8fafc;
        --color-navy-brand: #384972;
        --color-navy-hover: #4a5e8c;
    }

    .dashboard-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 4px;
    }
    .page-breadcrumb {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-breadcrumb a {
        color: #384972;
        text-decoration: none;
    }
    .page-breadcrumb span {
        color: #0f172a;
        font-weight: 800;
    }
    .page-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }
    .page-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 600;
    }

    /* General Card Component */
    .custom-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .custom-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }

    /* Student Profile Hero Card */
    .student-hero-card {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        background: #ffffff;
        border-radius: 20px;
        padding: 24px 28px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    .student-avatar-box {
        width: 96px;
        height: 96px;
        background: #e2e8f0;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #cbd5e1;
    }
    .student-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .student-name {
        margin: 0 0 6px 0;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .student-meta {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .student-meta strong {
        color: #0f172a;
        font-weight: 700;
    }
    .badge-pill-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .badge-status-aktif {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-wali-kelas {
        background: #384972;
        color: #ffffff;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .badge-wali-kelas:hover {
        background: #4a5e8c;
    }
    .badge-jurusan {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* 5 Summary Statistics Cards (Image 1 Referensi) */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }
    @media (max-width: 1100px) {
        .stat-cards-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 768px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 480px) {
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card-item {
        border-radius: 18px;
        padding: 18px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .stat-card-item .card-label {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .stat-card-item .card-number {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .stat-card-item .card-unit {
        font-size: 13px;
        font-weight: 700;
        margin-top: 2px;
    }

    /* Card Themes */
    .card-theme-hadir {
        background: #bbf7d0;
        border: 1.5px solid #86efac;
        color: #14532d;
    }
    .card-theme-izin {
        background: #94a3b8;
        border: 1.5px solid #64748b;
        color: #0f172a;
    }
    .card-theme-izin .card-label, .card-theme-izin .card-unit {
        color: #1e293b;
    }
    .card-theme-sakit {
        background: #fed7aa;
        border: 1.5px solid #fdba74;
        color: #9a3412;
    }
    .card-theme-alpha {
        background: #fca5a5;
        border: 1.5px solid #f87171;
        color: #7f1d1d;
    }
    .card-theme-today {
        background: #bbf7d0;
        border: 1.5px solid #86efac;
        color: #14532d;
    }

    /* Middle Row: Status Terkini & Aktivitas Izin (Image 2 Referensi) */
    .middle-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    @media (max-width: 860px) {
        .middle-grid {
            grid-template-columns: 1fr;
        }
    }

    .card-section-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .status-terkini-box {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .status-icon-circle {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }
    .status-info-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .status-info-subtext {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }

    .btn-ajukan-izin {
        background: #384972;
        color: #ffffff;
        padding: 10px 22px;
        border-radius: 14px;
        font-size: 12.5px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.25);
        transition: all 0.2s ease;
    }
    .btn-ajukan-izin:hover {
        background: #4a5e8c;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(56, 73, 114, 0.35);
    }

    /* Table Component (Laporan Kehadiran - Image 1 Referensi) */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        text-align: left;
    }
    .custom-table thead tr th {
        background: #e2e8f0;
        color: #1e293b;
        font-size: 14px;
        font-weight: 800;
        padding: 12px 18px;
        border: none;
    }
    .custom-table thead tr th:first-child {
        border-radius: 12px 0 0 12px;
    }
    .custom-table thead tr th:last-child {
        border-radius: 0 12px 12px 0;
    }
    .custom-table tbody tr td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
        font-weight: 600;
        vertical-align: middle;
    }
    .custom-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Attendance Pill Badges */
    .status-badge-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 800;
        min-width: 90px;
        border: 1px solid transparent;
    }
    .status-badge-pill.pill-hadir {
        background: #86efac;
        color: #14532d;
        border-color: #4ade80;
    }
    .status-badge-pill.pill-sakit {
        background: #fcd34d;
        color: #78350f;
        border-color: #fbbf24;
    }
    .status-badge-pill.pill-izin {
        background: #94a3b8;
        color: #0f172a;
        border-color: #64748b;
    }
    .status-badge-pill.pill-alpa {
        background: #fca5a5;
        color: #7f1d1d;
        border-color: #f87171;
    }
    .status-badge-pill.pill-dispen {
        background: #93c5fd;
        color: #1e3a8a;
        border-color: #60a5fa;
    }

    /* Modal Backdrop & Dialog */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 22px;
        width: 100%;
        max-width: 540px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        animation: modalScaleIn 0.25s ease forwards;
    }
    @keyframes modalScaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-header {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-header h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }
    .modal-close-btn {
        background: #e2e8f0;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #475569;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .modal-close-btn:hover {
        background: #cbd5e1;
        color: #0f172a;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        background: #ffffff;
        border-color: #384972;
        box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.12);
    }

    /* Jadwal KBM Timeline */
    .schedule-item-card {
        background: #f8fafc;
        border-radius: 14px;
        padding: 14px 18px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.2s ease;
    }
    .schedule-item-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
</style>
@endsection

@section('content')
@php
    $currentUser = $user ?? Auth::user();
@endphp

<div class="dashboard-wrapper">

    <!-- Top Breadcrumb & Page Title -->
    <div class="page-header">
        <div class="page-breadcrumb">
            <a href="{{ route('orang-tua.dashboard') }}">Jurnal SMEA</a> &gt; <span>Dashboard Orang Tua</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 class="page-title">Dashboard Orang Tua</h1>
                <p class="page-subtitle">
                    {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY') }} &nbsp;•&nbsp; Ringkasan operasional sekolah & kehadiran anak hari ini
                </p>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <button type="button" class="btn-ajukan-izin" onclick="openModalAjukanIzin()">
                    <i class="fa-solid fa-plus"></i> Ajukan Izin Baru
                </button>
            </div>
        </div>
    </div>

    @if($siswa)
    <!-- 1. Student Information Hero Card (Image 2 Referensi) -->
    <div class="student-hero-card">
        <div class="student-avatar-box">
            @if($currentUser && $currentUser->foto_url)
                <img src="{{ $currentUser->foto_url }}" alt="{{ $siswa->nama_siswa }}">
            @else
                <i class="fa-solid fa-user-graduate" style="font-size: 44px; color: #64748b;"></i>
            @endif
        </div>

        <div style="flex: 1; min-width: 260px;">
            <h2 class="student-name">{{ $siswa->nama_siswa }}</h2>
            <div class="student-meta">
                <span>Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? 'XI RPL 1' }}</strong></span>
                <span>•</span>
                <span>NISN: <strong>{{ $siswa->nisn ?? '-' }}</strong></span>
                @if($siswa->nis)
                    <span>•</span>
                    <span>NIS: <strong>{{ $siswa->nis }}</strong></span>
                @endif
                <span>•</span>
                <span>Jurusan: <strong>{{ $siswa->kelas->jurusan->nama_jurusan ?? ($siswa->kelas->jurusan->kode_jurusan ?? 'Rekayasa Perangkat Lunak') }}</strong></span>
            </div>

            <div class="badge-pill-group">
                <span class="badge-status-aktif">
                    <i class="fa-solid fa-circle-check"></i> Status Aktif
                </span>

                <button type="button" class="badge-wali-kelas" onclick="openModalWaliKelas()" title="Klik untuk melihat kontak Wali Kelas">
                    <i class="fa-solid fa-user-tie"></i> Wali Kelas: {{ $siswa->kelas->waliKelas->nama_guru ?? 'Sulistyowati, SS' }}
                </button>

                <span class="badge-jurusan">
                    <i class="fa-solid fa-graduation-cap"></i> T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - {{ $activeTahunAjaran->semester ?? 'Ganjil' }}
                </span>
            </div>
        </div>
    </div>

    <!-- 2. 5 Summary Stat Cards (Image 1 Referensi: Hadir, Izin, Sakit, Alpha, Status Hari Ini) -->
    <div class="stat-cards-grid">
        <!-- Hadir -->
        <div class="stat-card-item card-theme-hadir">
            <span class="card-label">Hadir</span>
            <span class="card-number">{{ $statsSummary['hadir_hari'] }}</span>
            <span class="card-unit">Hari</span>
        </div>

        <!-- Izin -->
        <div class="stat-card-item card-theme-izin">
            <span class="card-label">Izin</span>
            <span class="card-number">{{ $statsSummary['izin_hari'] }}</span>
            <span class="card-unit">Hari</span>
        </div>

        <!-- Sakit -->
        <div class="stat-card-item card-theme-sakit">
            <span class="card-label">Sakit</span>
            <span class="card-number">{{ $statsSummary['sakit_hari'] }}</span>
            <span class="card-unit">Hari</span>
        </div>

        <!-- Alpha -->
        <div class="stat-card-item card-theme-alpha">
            <span class="card-label">Alpha</span>
            <span class="card-number">{{ $statsSummary['alpha_hari'] }}</span>
            <span class="card-unit">Hari</span>
        </div>

        <!-- Status Hari Ini -->
        <div class="stat-card-item card-theme-today">
            <span class="card-label">Status Hari Ini</span>
            <span class="card-number" style="font-size: 26px; padding: 4px 0;">{{ $statsSummary['status_hari_ini'] }}</span>
            <span class="card-unit" style="font-size: 11.5px; opacity: 0.9;">Real-time</span>
        </div>
    </div>

    <!-- 3. Middle Grid Row: Status Kehadiran Terkini & Aktivitas Izin / Keluar (Image 2 Referensi) -->
    <div class="middle-grid">
        <!-- Card 1: Status Kehadiran Terkini -->
        <div class="custom-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div class="card-section-title">
                    <span>STATUS KEHADIRAN TERKINI</span>
                    <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #166534; background: #dcfce7; padding: 4px 10px; border-radius: 12px;">
                        <span style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
                        Live Update
                    </span>
                </div>

                <div class="status-terkini-box" style="margin-top: 12px;">
                    <div class="status-icon-circle" style="background: {{ $statusHariIni['badge_bg'] ?? '#dcfce7' }}; color: {{ $statusHariIni['badge_text'] ?? '#14532d' }};">
                        <i class="fa-solid {{ $statusHariIni['icon'] ?? 'fa-school' }}"></i>
                    </div>
                    <div>
                        <div class="status-info-title">{{ $statusHariIni['status'] ?? 'Di Sekolah' }}</div>
                        <div class="status-info-subtext">{{ $statusHariIni['subtext'] ?? 'Sampai Sekolah: 06.40 WIB' }}</div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-size: 12px; color: #64748b; font-weight: 600;">
                <span>Lokasi: SMK SMEA</span>
                <span>Pukul: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }} WIB</span>
            </div>
        </div>

        <!-- Card 2: Aktivitas Izin / Keluar -->
        <div class="custom-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div class="card-section-title">
                    <span>AKTIVITAS IZIN / KELUAR</span>
                </div>

                <div style="margin: 14px 0 18px 0;">
                    @if($aktivitasIzinAktif)
                        <div style="background: #e0f2fe; padding: 14px 18px; border-radius: 14px; border: 1px solid #bae6fd; text-align: left;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="font-weight: 800; color: #0369a1; font-size: 14px;">{{ $aktivitasIzinAktif['tipe'] }}</div>
                                <span style="font-size: 11px; font-weight: 800; background: #0284c7; color: #ffffff; padding: 2px 8px; border-radius: 10px;">
                                    {{ $aktivitasIzinAktif['status'] }}
                                </span>
                            </div>
                            <div style="font-size: 12.5px; color: #334155; margin-top: 4px; font-weight: 600;">
                                {{ $aktivitasIzinAktif['detail'] }}
                            </div>
                        </div>
                    @else
                        <div style="text-align: center; padding: 12px 0;">
                            <p style="font-size: 15px; font-weight: 700; color: #475569; margin: 0 0 6px 0;">
                                Tidak ada izin aktif saat ini.
                            </p>
                            <span style="font-size: 12.5px; color: #94a3b8; font-weight: 500;">
                                Anak hadir penuh mengikuti pembelajaran di kelas.
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div style="text-align: center; margin-top: 10px;">
                <button type="button" class="btn-ajukan-izin" style="width: 100%; justify-content: center;" onclick="openModalAjukanIzin()">
                    <i class="fa-solid fa-plus"></i> AJUKAN IZIN BARU
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Jadwal Pelajaran (KBM) Anak Hari Ini -->
    <div class="custom-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-calendar-day" style="color: #384972; margin-right: 8px;"></i>
                    JADWAL KBM ANAK HARI INI ({{ Str::upper(\Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd')) }})
                </h3>
                <p style="font-size: 13px; color: #64748b; margin: 0; font-weight: 600;">
                    Daftar mata pelajaran yang dipelajari anak Anda hari ini di kelas {{ $siswa->kelas->nama_kelas ?? 'XI RPL 1' }}
                </p>
            </div>
            <span style="font-size: 12px; font-weight: 700; color: #384972; background: #e2e8f0; padding: 6px 14px; border-radius: 12px;">
                Total: {{ $jadwalHariIni->count() }} Mata Pelajaran
            </span>
        </div>

        @if($jadwalHariIni->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($jadwalHariIni as $idx => $jdw)
                    @php
                        $jamMulai = $jdw->jamMulai->jam_ke ?? ($jdw->id_jam_mulai ? 'Jam ' . $jdw->id_jam_mulai : 'Jam 1');
                        $jamSelesai = $jdw->jamSelesai->jam_ke ?? ($jdw->id_jam_selesai ? 'Jam ' . $jdw->id_jam_selesai : $jamMulai);
                        
                        $tMulai = $jdw->jamMulai->jam_mulai ?? '07:00';
                        $tSelesai = $jdw->jamSelesai->jam_selesai ?? '08:30';
                        $waktuDisplay = substr($tMulai, 0, 5) . ' - ' . substr($tSelesai, 0, 5);
                        
                        $hasJurnal = !empty($jdw->jurnal_today);
                        $jurnalItem = $jdw->jurnal_today ?? null;
                    @endphp
                    <div class="schedule-item-card" style="cursor: pointer;" onclick="openModalDetailKbm('{{ addslashes($jdw->mapel->nama_mapel ?? 'Mata Pelajaran') }}', '{{ addslashes($jdw->guru->nama_guru ?? 'Guru Mapel') }}', '{{ $jamMulai }} - {{ $jamSelesai }} ({{ $waktuDisplay }} WIB)', '{{ addslashes($jdw->ruangan->nama_ruangan ?? 'Ruang Kelas') }}', '{{ addslashes($jurnalItem->materi ?? 'Belum ada materi pembelajaran yang diinput oleh guru.') }}', '{{ $hasJurnal ? 'KBM Terlaksana' : 'Terjadwal' }}', '{{ addslashes($jurnalItem->catatan ?? '-') }}', '{{ $jurnalItem->dokumentasi_url ?? '' }}')" title="Klik untuk melihat detail pembelajaran">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="background: #384972; color: #ffffff; width: 44px; height: 44px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; flex-shrink: 0;">
                                <span>{{ $idx + 1 }}</span>
                            </div>

                            <div>
                                <div style="font-size: 15px; font-weight: 800; color: #0f172a;">
                                    {{ $jdw->mapel->nama_mapel ?? 'Mata Pelajaran' }}
                                </div>
                                <div style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                    <i class="fa-solid fa-chalkboard-user" style="font-size: 11px; margin-right: 4px;"></i> {{ $jdw->guru->nama_guru ?? 'Guru Mapel' }}
                                    &nbsp;•&nbsp;
                                    <i class="fa-solid fa-door-open" style="font-size: 11px; margin-right: 4px;"></i> {{ $jdw->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px; text-align: right;">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #1e293b;">
                                    {{ $jamMulai }} - {{ $jamSelesai }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                                    {{ $waktuDisplay }} WIB
                                </div>
                            </div>

                            @if($hasJurnal)
                                <span style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 6px 12px; border-radius: 10px; font-size: 11.5px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-circle-check"></i> KBM Terlaksana
                                </span>
                            @else
                                <span style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 10px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-regular fa-clock"></i> Terjadwal
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: #f8fafc; border-radius: 14px; padding: 24px; text-align: center; color: #64748b; font-size: 13.5px; font-weight: 600; border: 1px dashed #cbd5e1;">
                <i class="fa-solid fa-mug-hot fa-2x" style="color: #94a3b8; margin-bottom: 8px; display: block;"></i>
                Tidak ada kegiatan jam pelajaran / KBM terjadwal untuk hari ini (Libur / Weekend).
            </div>
        @endif
    </div>

    <!-- 5. Laporan Kehadiran (Image 1 Referensi) -->
    <div class="custom-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                    Laporan Kehadiran
                </h2>
                <p style="margin: 0; color: #64748b; font-size: 13.5px; font-weight: 600;">
                    Informasi kehadiran Anak.
                </p>
            </div>

            <!-- Filter Bulan / Tahun -->
            <form method="GET" action="{{ route('orang-tua.dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
                <select name="bulan" class="form-select" style="min-width: 145px; padding: 7px 14px; font-size: 13px; font-weight: 700;" onchange="this.form.submit()">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $filterBulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="form-select" style="min-width: 90px; padding: 7px 12px; font-size: 13px; font-weight: 700;" onchange="this.form.submit()">
                    <option value="2026" {{ $filterTahun == 2026 ? 'selected' : '' }}>2026</option>
                    <option value="2027" {{ $filterTahun == 2027 ? 'selected' : '' }}>2027</option>
                </select>
            </form>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Tanggal</th>
                        <th style="width: 20%;">Kehadiran</th>
                        <th style="width: 55%;">Keterangan & Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanKehadiranHarian as $item)
                        @php
                            $pillClass = 'pill-hadir';
                            $statusLower = strtolower($item['status']);
                            if (str_contains($statusLower, 'sakit')) $pillClass = 'pill-sakit';
                            elseif (str_contains($statusLower, 'izin')) $pillClass = 'pill-izin';
                            elseif (str_contains($statusLower, 'alpa') || str_contains($statusLower, 'alpha')) $pillClass = 'pill-alpa';
                            elseif (str_contains($statusLower, 'dispen')) $pillClass = 'pill-dispen';
                        @endphp
                        <tr>
                            <td style="font-weight: 700; color: #0f172a;">
                                {{ $item['tanggal'] }}
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                                    {{ $item['hari'] }}
                                </div>
                            </td>
                            <td>
                                <span class="status-badge-pill {{ $pillClass }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td style="color: #475569; font-size: 13px;">
                                {{ $item['keterangan'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 28px; color: #64748b;">
                                Belum ada catatan laporan kehadiran untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 6. Bottom Full-Width Card: Ringkasan Kehadiran Bulan Ini (Grafik Batang) -->
    <div class="custom-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 15px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
                RINGKASAN KEHADIRAN BULAN {{ $rekapBulan['nama_bulan'] }}
            </div>
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 6px 14px; border-radius: 10px;">
                Total Pertemuan: {{ $rekapBulan['total'] }} Jurnal
            </div>
        </div>

        <!-- Bar Chart Visualization -->
        <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 190px; padding: 0 20px; border-bottom: 2px solid #e2e8f0; position: relative;">
            
            <!-- Hadir Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 12px; font-weight: 800; color: #384972;">{{ $rekapBulan['hadir'] }} ({{ $rekapBulan['persen_hadir'] }}%)</div>
                <div style="width: 100%; max-width: 64px; height: {{ max(16, $rekapBulan['persen_hadir']) }}%; background: #384972; border-radius: 10px 10px 0 0; transition: height 0.5s ease; box-shadow: 0 4px 10px rgba(56, 73, 114, 0.2);"></div>
            </div>

            <!-- Sakit Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 12px; font-weight: 800; color: #d97706;">{{ $rekapBulan['sakit'] }}</div>
                <div style="width: 100%; max-width: 64px; height: {{ max(8, $rekapBulan['persen_sakit'] > 0 ? $rekapBulan['persen_sakit'] : ($rekapBulan['sakit'] > 0 ? 15 : 4)) }}%; background: #f59e0b; border-radius: 10px 10px 0 0; transition: height 0.5s ease;"></div>
            </div>

            <!-- Izin Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 12px; font-weight: 800; color: #166534;">{{ $rekapBulan['izin'] }}</div>
                <div style="width: 100%; max-width: 64px; height: {{ max(8, $rekapBulan['persen_izin'] > 0 ? $rekapBulan['persen_izin'] : ($rekapBulan['izin'] > 0 ? 15 : 4)) }}%; background: #86efac; border-radius: 10px 10px 0 0; transition: height 0.5s ease;"></div>
            </div>

            <!-- Alfa Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 12px; font-weight: 800; color: #dc2626;">{{ $rekapBulan['alfa'] }}</div>
                <div style="width: 100%; max-width: 64px; height: {{ max(8, $rekapBulan['persen_alfa'] > 0 ? $rekapBulan['persen_alfa'] : ($rekapBulan['alfa'] > 0 ? 15 : 4)) }}%; background: #fca5a5; border-radius: 10px 10px 0 0; transition: height 0.5s ease;"></div>
            </div>
        </div>

        <!-- Chart Labels -->
        <div style="display: flex; justify-content: space-around; margin-top: 14px; text-align: center;">
            <div style="width: 80px; font-size: 13px; font-weight: 800; color: #384972;">HADIR</div>
            <div style="width: 80px; font-size: 13px; font-weight: 800; color: #d97706;">SAKIT</div>
            <div style="width: 80px; font-size: 13px; font-weight: 800; color: #166534;">IZIN</div>
            <div style="width: 80px; font-size: 13px; font-weight: 800; color: #dc2626;">ALFA</div>
        </div>
    </div>

    <!-- 7. Riwayat Surat Izin & Dispensasi Terkini -->
    <div class="middle-grid">
        <!-- Riwayat Surat Izin -->
        <div class="custom-card">
            <div class="card-section-title">
                <span>RIWAYAT SURAT IZIN TERAKHIR</span>
                <a href="{{ route('orang-tua.izin') }}" style="font-size: 12px; color: #384972; font-weight: 700; text-decoration: none;">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($suratIzinList->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($suratIzinList as $si)
                        <div style="background: #f8fafc; border-radius: 12px; padding: 12px 14px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                    Izin: {{ $si->kategori }} ({{ $si->durasi_hari ?? 1 }} Hari)
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    {{ \Carbon\Carbon::parse($si->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                    @if($si->keterangan)
                                        &nbsp;•&nbsp; {{ Str::limit($si->keterangan, 30) }}
                                    @endif
                                </div>
                            </div>

                            <span style="background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px;">
                                {{ $si->status ?? 'Terverifikasi' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="font-size: 13px; color: #64748b; text-align: center; margin: 20px 0;">
                    Belum ada riwayat permohonan surat izin.
                </p>
            @endif
        </div>

        <!-- Riwayat Dispensasi -->
        <div class="custom-card">
            <div class="card-section-title">
                <span>RIWAYAT DISPENSASI TERAKHIR</span>
            </div>

            @if($dispenList->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($dispenList as $dp)
                        <div style="background: #f8fafc; border-radius: 12px; padding: 12px 14px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                    Dispen: {{ $dp->alasan }}
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    {{ \Carbon\Carbon::parse($dp->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} ({{ $dp->jam_keluar }} - {{ $dp->jam_kembali }})
                                </div>
                            </div>

                            <span style="background: #dbeafe; color: #1e40af; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px;">
                                Disetujui
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="font-size: 13px; color: #64748b; text-align: center; margin: 20px 0;">
                    Belum ada riwayat dispensasi keluar sekolah.
                </p>
            @endif
        </div>
    </div>

    @else
    <!-- Unlinked State Card -->
    <div style="background: #ffffff; border-radius: 20px; padding: 48px 24px; text-align: center; color: #64748b; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0;">
        <i class="fa-solid fa-triangle-exclamation fa-3x" style="color: #d97706; margin-bottom: 16px;"></i>
        <h2 style="margin: 0 0 8px 0; color: #1e293b; font-size: 20px;">Akun Orang Tua belum terhubung ke data siswa</h2>
        <p style="margin: 0; font-size: 14px;">Silakan hubungi Administrator TU untuk menghubungkan akun ini dengan NISN anak Anda.</p>
    </div>
    @endif

</div>

<!-- MODAL: AJUKAN IZIN CEPAT DARI DASHBOARD -->
<div id="modalAjukanIzin" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-signature" style="color: #384972; margin-right: 8px;"></i> Ajukan Surat Izin Baru</h3>
            <button type="button" class="modal-close-btn" onclick="closeModalAjukanIzin()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('orang-tua.store-izin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="source" value="dashboard">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Kategori Izin <span style="color:#ef4444;">*</span></label>
                    <select name="kategori" class="form-select" required>
                        <option value="Sakit">Sakit (Ada surat dokter / keterangan orang tua)</option>
                        <option value="Izin">Izin (Ada keperluan keluarga / mendesak)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" class="form-input" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-input" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Alasan Izin <span style="color:#ef4444;">*</span></label>
                    <textarea name="keterangan" rows="3" class="form-textarea" placeholder="Tuliskan alasan izin anak Anda secara jelas..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload Foto Bukti / Surat Dokter (Opsional)</label>
                    <input type="file" name="foto_bukti" class="form-input" accept="image/*">
                    <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">Format: JPG, PNG, WEBP (Maksimal 5MB)</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ajukan-izin" style="background: #e2e8f0; color: #334155; box-shadow: none;" onclick="closeModalAjukanIzin()">Batal</button>
                <button type="submit" class="btn-ajukan-izin"><i class="fa-solid fa-paper-plane"></i> Kirim Permohonan Izin</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: INFORMASI WALI KELAS -->
<div id="modalWaliKelas" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-tie" style="color: #384972; margin-right: 8px;"></i> Kontak Wali Kelas</h3>
            <button type="button" class="modal-close-btn" onclick="closeModalWaliKelas()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <div style="width: 72px; height: 72px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 32px; color: #384972;">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>

            <h4 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                {{ $siswa->kelas->waliKelas->nama_guru ?? 'Sulistyowati, SS' }}
            </h4>
            <p style="font-size: 13px; color: #64748b; font-weight: 600; margin: 0 0 18px 0;">
                Wali Kelas {{ $siswa->kelas->nama_kelas ?? 'XI RPL 1' }} &bull; NIP: {{ $siswa->kelas->wali_kelas ?? '-' }}
            </p>

            <div style="background: #f8fafc; border-radius: 14px; padding: 16px; border: 1px solid #e2e8f0; text-align: left; display: flex; flex-direction: column; gap: 10px;">
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px;">
                    <span style="color: #64748b; font-weight: 600;"><i class="fa-brands fa-whatsapp" style="color: #22c55e; margin-right: 6px;"></i> WhatsApp / No HP:</span>
                    <strong style="color: #0f172a;">{{ $siswa->kelas->waliKelas->no_hp ?? '0812-3456-7890' }}</strong>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px;">
                    <span style="color: #64748b; font-weight: 600;"><i class="fa-solid fa-school" style="color: #384972; margin-right: 6px;"></i> Ruang Kelas:</span>
                    <strong style="color: #0f172a;">{{ $siswa->kelas->ruangan->nama_ruangan ?? 'R. 204' }}</strong>
                </div>
            </div>

            @php
                $waNumber = preg_replace('/\D/', '', $siswa->kelas->waliKelas->no_hp ?? '6281234567890');
                if (str_starts_with($waNumber, '0')) {
                    $waNumber = '62' . substr($waNumber, 1);
                }
            @endphp

            <div style="margin-top: 20px;">
                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20Bapak/Ibu%20Wali%20Kelas%20{{ urlencode($siswa->kelas->nama_kelas ?? '') }}%2C%20saya%20orang%20tua%20dari%20{{ urlencode($siswa->nama_siswa ?? '') }}" target="_blank" class="btn-ajukan-izin" style="background: #16a34a; width: 100%; justify-content: center; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);">
                    <i class="fa-brands fa-whatsapp fa-lg"></i> Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: DETAIL JURNAL KBM -->
<div id="modalDetailKbm" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-book-open" style="color: #384972; margin-right: 8px;"></i> Detail Pembelajaran KBM</h3>
            <button type="button" class="modal-close-btn" onclick="closeModalDetailKbm()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div style="background: #f8fafc; border-radius: 14px; padding: 18px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span id="modalKbmStatus" style="font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 8px;">-</span>
                    <span id="modalKbmJam" style="font-size: 12px; font-weight: 700; color: #64748b;">-</span>
                </div>
                <h4 id="modalKbmMapel" style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">-</h4>
                <div style="font-size: 13px; color: #475569; font-weight: 600;">
                    <i class="fa-solid fa-chalkboard-user" style="color: #384972; margin-right: 4px;"></i> <span id="modalKbmGuru">-</span>
                    &nbsp;•&nbsp;
                    <i class="fa-solid fa-door-open" style="color: #384972; margin-right: 4px;"></i> <span id="modalKbmRuangan">-</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-size: 13px; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-pen-nib" style="color:#384972; margin-right:6px;"></i> Materi Pelajaran yang Diajarkan:</label>
                <div id="modalKbmMateri" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; font-size: 13.5px; color: #1e293b; line-height: 1.5; font-weight: 600;">
                    -
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" style="font-size: 13px; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-clipboard" style="color:#384972; margin-right:6px;"></i> Catatan Guru:</label>
                <div id="modalKbmCatatan" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px; font-size: 13px; color: #475569;">
                    -
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-ajukan-izin" style="background: #384972; color: #ffffff;" onclick="closeModalDetailKbm()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModalAjukanIzin() {
        document.getElementById('modalAjukanIzin').classList.add('active');
    }
    function closeModalAjukanIzin() {
        document.getElementById('modalAjukanIzin').classList.remove('active');
    }

    function openModalWaliKelas() {
        document.getElementById('modalWaliKelas').classList.add('active');
    }
    function closeModalWaliKelas() {
        document.getElementById('modalWaliKelas').classList.remove('active');
    }

    function openModalDetailKbm(mapel, guru, jam, ruangan, materi, status, catatan, foto) {
        document.getElementById('modalKbmMapel').innerText = mapel;
        document.getElementById('modalKbmGuru').innerText = guru;
        document.getElementById('modalKbmJam').innerText = jam;
        document.getElementById('modalKbmRuangan').innerText = ruangan;
        document.getElementById('modalKbmMateri').innerText = materi || 'Belum ada materi pembelajaran yang diinput oleh guru.';
        document.getElementById('modalKbmCatatan').innerText = catatan || 'Tidak ada catatan tambahan.';

        const statusElem = document.getElementById('modalKbmStatus');
        statusElem.innerText = status;
        if (status === 'KBM Terlaksana') {
            statusElem.style.background = '#dcfce7';
            statusElem.style.color = '#166534';
            statusElem.style.border = '1px solid #bbf7d0';
        } else {
            statusElem.style.background = '#f1f5f9';
            statusElem.style.color = '#475569';
            statusElem.style.border = '1px solid #cbd5e1';
        }

        document.getElementById('modalDetailKbm').classList.add('active');
    }
    function closeModalDetailKbm() {
        document.getElementById('modalDetailKbm').classList.remove('active');
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        const modalIzin = document.getElementById('modalAjukanIzin');
        const modalWali = document.getElementById('modalWaliKelas');
        const modalKbm = document.getElementById('modalDetailKbm');
        if (e.target === modalIzin) closeModalAjukanIzin();
        if (e.target === modalWali) closeModalWaliKelas();
        if (e.target === modalKbm) closeModalDetailKbm();
    });
</script>
@endsection
