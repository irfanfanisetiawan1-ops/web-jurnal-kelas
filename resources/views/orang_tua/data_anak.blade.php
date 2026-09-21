@extends('layouts.orang_tua')

@section('title', 'Data Anak — Jurnal SMEA')

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

    .data-anak-container {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Header & Breadcrumb */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
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

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn-action-primary {
        background: #384972;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(56, 73, 114, 0.25);
    }
    .btn-action-primary:hover {
        background: #2b395b;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.35);
    }

    .btn-action-secondary {
        background: #ffffff;
        color: #475569;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-action-secondary:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* Student Hero Card */
    .hero-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 28px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: #384972;
    }

    .hero-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        color: #384972;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        flex-shrink: 0;
    }

    .hero-info {
        flex: 1;
        min-width: 260px;
    }

    .hero-name {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .hero-status-badge {
        font-size: 11.5px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .badge-active {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .hero-meta-item i {
        color: #384972;
    }

    .hero-chips {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .hero-chip {
        background: #f1f5f9;
        color: #334155;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .hero-chip i {
        color: #64748b;
    }

    /* Grid Layout */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    @media (max-width: 992px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Detail Card */
    .detail-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .card-title-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #384972;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .card-title-text {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* Info Table List */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #f1f5f9;
    }
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        min-width: 140px;
    }

    .info-value {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        text-align: right;
        word-break: break-word;
    }

    .wali-wa-btn {
        background: #25d366;
        color: #ffffff;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
    }
    .wali-wa-btn:hover {
        background: #1eb857;
        color: #ffffff;
    }

    /* Stat Cards within Detail Card */
    .mini-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 4px;
    }

    .mini-stat-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mini-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .icon-izin { background: #e0f2fe; color: #0369a1; }
    .icon-dispen { background: #fef3c7; color: #b45309; }

    .mini-stat-val {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .mini-stat-lbl {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
    }

    /* Quick Action Buttons inside Card */
    .card-actions-wrapper {
        display: flex;
        gap: 10px;
        margin-top: 6px;
    }

    .card-btn-action {
        flex: 1;
        padding: 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        transition: all 0.2s ease;
    }
    .card-btn-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* PRINT STYLES */
    @media print {
        body {
            background: #ffffff !important;
            color: #000000 !important;
            font-family: Arial, sans-serif !important;
        }

        .sidebar, .top-header, .page-header, .header-actions, .card-actions-wrapper, .btn-action-primary, .btn-action-secondary {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .data-anak-container {
            max-width: 100% !important;
            gap: 16px !important;
        }

        .hero-card, .detail-card {
            box-shadow: none !important;
            border: 1px solid #94a3b8 !important;
            border-radius: 8px !important;
            padding: 16px !important;
            break-inside: avoid;
        }

        .details-grid {
            grid-template-columns: 1fr 1fr !important;
            gap: 16px !important;
        }

        .print-header-only {
            display: block !important;
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .print-header-only h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .print-header-only p {
            margin: 2px 0 0 0;
            font-size: 12px;
            color: #475569;
        }
    }

    .print-header-only {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="data-anak-container">

    <!-- Header khusus cetak -->
    <div class="print-header-only">
        <h2>SMK NEGERI 1 KOTA PROBOLINGGO</h2>
        <p>KARTU IDENTITAS DAN DATA INDUK SISWA — JURNAL MENGAJAR SMEA</p>
    </div>

    <!-- Page Header (Web Mode) -->
    <div class="page-header">
        <div>
            <div class="page-breadcrumb">
                <a href="{{ route('orang-tua.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard Orang Tua</a>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                <span>Data Anak</span>
            </div>
            <h1 class="page-title">Data Anak</h1>
            <p class="page-subtitle">Informasi Rinci dan Lengkap Biodata, Akademik, Wali Kelas & Akun Orang Tua Siswa</p>
        </div>
        <div class="header-actions">
            <button onclick="window.print()" class="btn-action-primary">
                <i class="fa-solid fa-print"></i> Cetak Kartu Data Siswa
            </button>
            <a href="{{ route('orang-tua.dashboard') }}" class="btn-action-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(!$siswa)
        <div class="custom-card" style="text-align: center; padding: 40px;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
            <h3 style="margin: 0 0 8px 0; color: #1e293b; font-weight: 800;">Data Anak Belum Terhubung</h3>
            <p style="color: #64748b; max-width: 500px; margin: 0 auto 20px auto;">
                Akun Orang Tua Anda belum terhubung secara otomatis dengan data siswa. Silakan hubungi bagian Tata Usaha (TU) sekolah untuk memverifikasi NISN / NIP wali.
            </p>
            <a href="{{ route('orang-tua.dashboard') }}" class="btn-action-primary">
                <i class="fa-solid fa-house"></i> Kembali ke Dashboard
            </a>
        </div>
    @else

        <!-- Hero Card Profil Siswa -->
        <div class="hero-card">
            <div class="hero-avatar">
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="hero-info">
                <div class="hero-name">
                    <span>{{ $siswa->nama_siswa }}</span>
                    @if($siswa->isActive())
                        <span class="hero-status-badge badge-active"><i class="fa-solid fa-circle-check"></i> Siswa Aktif</span>
                    @else
                        <span class="hero-status-badge badge-inactive"><i class="fa-solid fa-circle-xmark"></i> Non-Aktif</span>
                    @endif
                </div>

                <div class="hero-meta">
                    <div class="hero-meta-item">
                        <i class="fa-solid fa-id-card"></i>
                        <span>NISN: <strong>{{ $siswa->nisn ?? '-' }}</strong></span>
                    </div>
                    <div class="hero-meta-item">
                        <i class="fa-solid fa-hashtag"></i>
                        <span>NIS: <strong>{{ $siswa->nis ?? '-' }}</strong></span>
                    </div>
                    <div class="hero-meta-item">
                        <i class="fa-solid fa-venus-mars"></i>
                        <span>Jenis Kelamin: <strong>{{ $siswa->jenis_kelamin_teks }}</strong></span>
                    </div>
                </div>

                <div class="hero-chips">
                    <div class="hero-chip">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></span>
                    </div>
                    <div class="hero-chip">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Jurusan: <strong>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</strong></span>
                    </div>
                    <div class="hero-chip">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Wali Kelas: <strong>{{ $siswa->kelas->waliKelas->nama_guru ?? '-' }}</strong></span>
                    </div>
                    <div class="hero-chip">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>TA: <strong>{{ $activeTahunAjaran->tahun_ajaran }} ({{ $activeTahunAjaran->semester }})</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Grid (2 Column) -->
        <div class="details-grid">

            <!-- Card 1: Biodata Pribadi -->
            <div class="detail-card">
                <div class="card-header-flex">
                    <div class="card-title-box">
                        <div class="card-title-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="card-title-text">Biodata Pribadi Siswa</h3>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 8px;">Master Siswa</span>
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value">{{ $siswa->nama_siswa }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NISN</span>
                        <span class="info-value">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NIS</span>
                        <span class="info-value">{{ $siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $siswa->jenis_kelamin_teks }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tempat Lahir</span>
                        <span class="info-value">{{ $siswa->kota_lahir ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Lahir</span>
                        <span class="info-value">{{ $tglLahirFormatted }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Usia Siswa</span>
                        <span class="info-value">{{ $usiaSiswa }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat Lengkap</span>
                        <span class="info-value" style="max-width: 240px;">{{ $siswa->alamat_lengkap ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Siswa</span>
                        <span class="info-value" style="color: #15803d; font-weight: 800;">
                            <i class="fa-solid fa-circle-check"></i> Active Student (SMK Negeri 1)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Informasi Akademik & Kelas -->
            <div class="detail-card">
                <div class="card-header-flex">
                    <div class="card-title-box">
                        <div class="card-title-icon">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <h3 class="card-title-text">Informasi Akademik & Rombel</h3>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 8px;">KBM & Rombel</span>
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Rombongan Belajar (Kelas)</span>
                        <span class="info-value" style="color: #384972; font-size: 15px; font-weight: 800;">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Program / Jurusan</span>
                        <span class="info-value">{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kode Jurusan</span>
                        <span class="info-value">{{ $siswa->kelas->jurusan->kode_jurusan ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Wali Kelas</span>
                        <span class="info-value">
                            <div>{{ $siswa->kelas->waliKelas->nama_guru ?? '-' }}</div>
                            @if(!empty($siswa->kelas->waliKelas->no_hp))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->kelas->waliKelas->no_hp) }}" target="_blank" class="wali-wa-btn">
                                    <i class="fa-brands fa-whatsapp"></i> Chat Wali Kelas
                                </a>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NIP Wali Kelas</span>
                        <span class="info-value">{{ $siswa->kelas->waliKelas->nip ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tahun Ajaran Aktif</span>
                        <span class="info-value">{{ $activeTahunAjaran->tahun_ajaran }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Semester Aktif</span>
                        <span class="info-value">{{ $activeTahunAjaran->semester }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Informasi Akun Orang Tua -->
            <div class="detail-card">
                <div class="card-header-flex">
                    <div class="card-title-box">
                        <div class="card-title-icon">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <h3 class="card-title-text">Akun Orang Tua / Wali</h3>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; color: #15803d; background: #dcfce7; padding: 4px 10px; border-radius: 8px;">Terverifikasi</span>
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Nama Akun Ortu</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Username / NISN Login</span>
                        <span class="info-value">{{ $user->username }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email Terdaftar</span>
                        <span class="info-value">{{ $user->email ?? 'Belum Diatur' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Role Pengguna</span>
                        <span class="info-value">Orang Tua / Wali Murid</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Koneksi Siswa</span>
                        <span class="info-value" style="color: #0284c7; font-weight: 800;">
                            <i class="fa-solid fa-link"></i> Terhubung dengan {{ $siswa->nama_siswa }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Sistem Akses</span>
                        <span class="info-value">Pantau Presensi & Perizinan Realtime</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Rekap Surat & Perizinan Siswa -->
            <div class="detail-card">
                <div class="card-header-flex">
                    <div class="card-title-box">
                        <div class="card-title-icon">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <h3 class="card-title-text">Rekap Perizinan & Fitur Cepat</h3>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; color: #0369a1; background: #e0f2fe; padding: 4px 10px; border-radius: 8px;">Aktivitas Ortu</span>
                </div>

                <div class="mini-stat-grid">
                    <div class="mini-stat-box">
                        <div class="mini-stat-icon icon-izin">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <div class="mini-stat-val">{{ $totalSuratIzinTotal }}</div>
                            <div class="mini-stat-lbl">Surat Izin Diajukan</div>
                        </div>
                    </div>

                    <div class="mini-stat-box">
                        <div class="mini-stat-icon icon-dispen">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </div>
                        <div>
                            <div class="mini-stat-val">{{ $totalDispenTotal }}</div>
                            <div class="mini-stat-lbl">Dispensasi Diajukan</div>
                        </div>
                    </div>
                </div>

                <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
                    Orang tua dapat mengajukan Surat Izin Sakit/Izin Kehadiran atau Dispensasi Kegiatan secara online yang akan diverifikasi oleh Wali Kelas dan Guru Piket.
                </div>

                <div class="card-actions-wrapper">
                    <a href="{{ route('orang-tua.izin') }}" class="card-btn-action">
                        <i class="fa-solid fa-plus-circle" style="color: #0284c7;"></i> Surat Izin Baru
                    </a>
                    <a href="{{ route('orang-tua.laporan') }}" class="card-btn-action">
                        <i class="fa-solid fa-clipboard-user" style="color: #384972;"></i> Laporan Kehadiran
                    </a>
                </div>
            </div>

        </div>

    @endif
</div>
@endsection
