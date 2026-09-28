@extends('layouts.kepala_sekolah')

@section('title', 'Siswa Sedang Izin — Jurnal SMEA')

@section('content')
<style>
    /* Responsive Styling for Siswa Izin Page (Kepala Sekolah) */
    .page-container-izin {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding-bottom: 40px;
    }

    .header-banner-izin {
        background: #ffffff;
        padding: 24px 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .header-actions-izin {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .kpi-grid-izin {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .kpi-card-item {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .filter-card-izin {
        background: #ffffff;
        padding: 18px 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-section-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-header-toolbar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .filter-pill-container {
        display: flex;
        gap: 6px;
        background: #f8fafc;
        padding: 4px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-width: 100%;
    }

    .filter-pill-container::-webkit-scrollbar {
        height: 3px;
    }

    .filter-pill-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Desktop table wrappers vs Mobile cards */
    .desktop-table-wrapper {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .mobile-cards-list {
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    .mobile-data-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .mobile-data-card:active {
        background: #f8fafc;
    }

    .mobile-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        border-bottom: 1px dashed #f1f5f9;
        padding-bottom: 10px;
    }

    .mobile-card-body {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13px;
    }

    .mobile-card-row {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
    }

    .mobile-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }

    /* Media Queries for Tablet & Mobile */
    @media (max-width: 1024px) {
        .kpi-grid-izin {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-container-izin {
            gap: 16px;
        }

        .header-banner-izin {
            padding: 16px 18px;
            border-radius: 14px;
        }

        .header-banner-izin h1 {
            font-size: 18px !important;
        }

        .header-banner-izin p {
            font-size: 12.5px !important;
        }

        .header-actions-izin {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 8px;
        }

        .header-actions-izin button,
        .header-actions-izin a {
            justify-content: center;
            font-size: 12px !important;
            padding: 9px 10px !important;
        }

        .kpi-grid-izin {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .kpi-card-item {
            padding: 14px;
            border-radius: 12px;
        }

        .kpi-card-item .kpi-title {
            font-size: 10.5px !important;
        }

        .kpi-card-item .kpi-value {
            font-size: 20px !important;
        }

        .kpi-card-item .kpi-desc {
            font-size: 10px !important;
        }

        .kpi-card-item .kpi-icon {
            width: 38px !important;
            height: 38px !important;
            font-size: 16px !important;
            border-radius: 10px !important;
        }

        .filter-card-izin {
            padding: 16px;
            border-radius: 14px;
        }

        .filter-form-grid {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }

        .filter-form-inputs {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .filter-form-inputs > div {
            width: 100% !important;
            min-width: unset !important;
        }

        .filter-form-inputs input[type="date"],
        .filter-form-inputs select {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .filter-form-buttons {
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px !important;
        }

        .filter-form-buttons button,
        .filter-form-buttons a {
            justify-content: center !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-section-card {
            padding: 16px;
            border-radius: 14px;
        }

        .table-header-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .table-header-toolbar h3 {
            font-size: 15px !important;
            justify-content: space-between;
            width: 100%;
        }

        .table-toolbar-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            width: 100%;
        }

        .table-search-box {
            width: 100% !important;
        }

        /* Hide desktop tables, show mobile cards */
        .desktop-table-wrapper {
            display: none !important;
        }

        .mobile-cards-list {
            display: flex !important;
        }

        /* Responsive Modal adjustments */
        .modal-body-grid {
            grid-template-columns: 1fr !important;
        }

        .modal-content-container {
            max-width: 95vw !important;
            margin: 10px !important;
            border-radius: 14px !important;
        }

        .modal-header-responsive {
            padding: 14px 18px !important;
        }

        .modal-body-responsive {
            padding: 16px !important;
            gap: 14px !important;
        }
    }

    @media (max-width: 480px) {
        .header-actions-izin {
            grid-template-columns: 1fr;
        }

        .kpi-grid-izin {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .kpi-card-item {
            padding: 12px 10px;
        }

        .kpi-card-item .kpi-value {
            font-size: 18px !important;
        }

        .kpi-card-item .kpi-icon {
            display: none !important;
        }
    }
</style>

<div class="page-container-izin">

    <!-- 1. Page Header Banner -->
    <div class="header-banner-izin">
        <div>
            <div style="font-size: 12.5px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i> <span style="color: #1e293b; font-weight: 800;">siswa yang sedang izin</span>
            </div>
            <h1 style="font-size: 23px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px; letter-spacing: -0.01em;">
                <i class="fa-solid fa-id-card" style="color: #384972;"></i> Daftar Siswa Yang Sedang Izin & Dispensasi Active
            </h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 13.5px; font-weight: 500;">
                Pemantauan langsung seluruh permohonan izin sakit, izin keperluan pribadi, dan dispensasi luar sekolah.
            </p>
        </div>

        <!-- Action Header Buttons -->
        <div class="header-actions-izin">
            <button type="button" onclick="openModalCetak()" style="background: #384972; color: #ffffff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(56, 73, 114, 0.25); transition: all 0.2s;">
                <i class="fa-solid fa-print"></i> Cetak Rekap Izin
            </button>
            <button type="button" onclick="openModalExport()" style="background: #10b981; color: #ffffff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25); transition: all 0.2s;">
                <i class="fa-solid fa-file-excel"></i> Export CSV
            </button>
            <a href="{{ route('kepala-sekolah.siswa-izin') }}" title="Muat Ulang Halaman" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>

    <!-- 2. KPI Executive Stat Cards -->
    <div class="kpi-grid-izin">
        <!-- Card 1: Total Dispen Hari Ini -->
        <div class="kpi-card-item">
            <div>
                <div class="kpi-title" style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TOTAL DISPENSASI</div>
                <div class="kpi-value" style="font-size: 26px; font-weight: 900; color: #0f172a;">{{ count($dispenSiswa) }}</div>
                <div class="kpi-desc" style="font-size: 11.5px; color: #384972; font-weight: 600; margin-top: 4px;">Dispensasi Keluar Gerbang</div>
            </div>
            <div class="kpi-icon" style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; color: #3730a3; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
            </div>
        </div>

        <!-- Card 2: Siswa Sedang Di Luar -->
        <div class="kpi-card-item">
            <div>
                <div class="kpi-title" style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">SEDANG DI LUAR</div>
                <div class="kpi-value" style="font-size: 26px; font-weight: 900; color: #d97706;">
                    {{ $dispenSiswa->where('status_satpam', 'dizinkan_keluar')->count() }}
                </div>
                <div class="kpi-desc" style="font-size: 11.5px; color: #d97706; font-weight: 600; margin-top: 4px;">Disetujui Satpam & Belum Kembali</div>
            </div>
            <div class="kpi-icon" style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-door-open"></i>
            </div>
        </div>

        <!-- Card 3: Sudah Kembali -->
        <div class="kpi-card-item">
            <div>
                <div class="kpi-title" style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">SUDAH KEMBALI</div>
                <div class="kpi-value" style="font-size: 26px; font-weight: 900; color: #16a34a;">
                    {{ $dispenSiswa->where('status_satpam', 'sudah_kembali')->count() }}
                </div>
                <div class="kpi-desc" style="font-size: 11.5px; color: #16a34a; font-weight: 600; margin-top: 4px;">Selesai Dispensasi Masuk Kelas</div>
            </div>
            <div class="kpi-icon" style="width: 48px; height: 48px; border-radius: 12px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Card 4: Surat Izin Tidak Masuk -->
        <div class="kpi-card-item">
            <div>
                <div class="kpi-title" style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">SURAT IZIN TIDAK MASUK</div>
                <div class="kpi-value" style="font-size: 26px; font-weight: 900; color: #2563eb;">{{ count($suratIzinSiswa) }}</div>
                <div class="kpi-desc" style="font-size: 11.5px; color: #2563eb; font-weight: 600; margin-top: 4px;">Izin Sakit / Keperluan Pribadi</div>
            </div>
            <div class="kpi-icon" style="width: 48px; height: 48px; border-radius: 12px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
        </div>
    </div>

    <!-- 3. Global Filter & Search Toolbar -->
    <div class="filter-card-izin">
        <form method="GET" action="{{ route('kepala-sekolah.siswa-izin') }}" id="filterFormGlobal" class="filter-form-grid" style="display: flex; flex-wrap: wrap; align-items: center; gap: 14px; justify-content: space-between;">
            <div class="filter-form-inputs" style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; flex: 1;">
                <!-- Filter Tanggal -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-calendar-day" style="color: #384972;"></i> Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc;">
                </div>

                <!-- Filter Kelas -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-chalkboard-user" style="color: #384972;"></i> Kelas:</label>
                    <select name="id_kelas" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; min-width: 140px;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ request('id_kelas') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Input -->
                <div style="position: relative; flex: 1; min-width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" name="q" id="globalSearchInput" value="{{ request('q') }}" placeholder="Cari nama siswa, NISN, alasan..." style="width: 100%; padding: 8px 32px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; box-sizing: border-box;">
                    @if(request('q'))
                        <button type="button" onclick="clearGlobalSearch()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 12px;">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Buttons: Terapkan & Reset Filter -->
            <div class="filter-form-buttons" style="display: flex; align-items: center; gap: 8px;">
                <button type="submit" style="background: #384972; color: #ffffff; border: none; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                <a href="{{ route('kepala-sekolah.siswa-izin') }}" title="Reset Semua Filter & Pencarian" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>

    <!-- 4. Table 1: Siswa Dispensasi Keluar Gerbang Sekolah -->
    <div class="table-section-card">
        <div class="table-header-toolbar">
            <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-building-flag" style="color: #384972;"></i> Siswa Dispensasi Keluar Gerbang Sekolah
                <span style="background: #e0e7ff; color: #3730a3; font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                    {{ count($dispenSiswa) }} Data
                </span>
            </h3>

            <!-- Quick Table 1 Filter Pills & Search -->
            <div class="table-toolbar-controls" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="filter-pill-container">
                    <button type="button" onclick="filterDispenTable('all')" class="dispen-filter-btn active" data-filter="all" style="border: none; background: #384972; color: #fff; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Semua</button>
                    <button type="button" onclick="filterDispenTable('dizinkan_keluar')" class="dispen-filter-btn" data-filter="dizinkan_keluar" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Sedang di Luar</button>
                    <button type="button" onclick="filterDispenTable('sudah_kembali')" class="dispen-filter-btn" data-filter="sudah_kembali" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Sudah Kembali</button>
                    <button type="button" onclick="filterDispenTable('belum_keluar')" class="dispen-filter-btn" data-filter="belum_keluar" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Belum Keluar</button>
                </div>

                <div class="table-search-box" style="position: relative; width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="liveSearchDispen" onkeyup="searchDispenRows()" placeholder="Cari di tabel dispen..." style="width: 100%; padding: 6px 28px 6px 28px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; color: #1e293b; background: #f8fafc; box-sizing: border-box;">
                    <button type="button" onclick="clearSearchDispen()" id="btnResetSearchDispen" style="display: none; position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 11px;">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="desktop-table-wrapper">
            <table id="tableDispen" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; width: 50px;">No</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Keperluan / Alasan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jam Izin</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Persetujuan Satpam</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenSiswa as $idx => $d)
                        @php
                            $namaSiswa = $d->siswa->nama_siswa ?? 'Siswa';
                            $nisnSiswa = $d->siswa->nisn ?? '-';
                            $namaKelas = $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? 'X AK 4');
                            
                            $jamTeks = '-';
                            if ($d->created_at) {
                                $jamTeks = $d->created_at->format('H:i') . ' WIB';
                            } elseif ($d->jam_keluar) {
                                $jamTeks = $d->jam_keluar . ' WIB';
                            }

                            $stSatpam = strtolower($d->status_satpam ?? 'belum_keluar');
                            $satpamBg = '#dcfce7';
                            $satpamColor = '#166534';
                            $satpamTeks = 'Dizinkan keluar';

                            if ($stSatpam === 'belum_keluar') {
                                $satpamBg = '#f1f5f9';
                                $satpamColor = '#475569';
                                $satpamTeks = 'Belum keluar';
                            } elseif ($stSatpam === 'dizinkan_keluar') {
                                $satpamBg = '#dcfce7';
                                $satpamColor = '#166534';
                                $satpamTeks = 'Dizinkan keluar';
                            } elseif ($stSatpam === 'sudah_kembali') {
                                $satpamBg = '#dbeafe';
                                $satpamColor = '#1e40af';
                                $satpamTeks = 'Sudah kembali';
                            } elseif ($stSatpam === 'ditolak') {
                                $satpamBg = '#fee2e2';
                                $satpamColor = '#991b1b';
                                $satpamTeks = 'Ditolak satpam';
                            }

                            // Prepare detail JSON for modal with full photo URLs
                            $detailJson = json_encode([
                                'id' => $d->id_siswa_dispen,
                                'nama' => $namaSiswa,
                                'nisn' => $nisnSiswa,
                                'kelas' => $namaKelas,
                                'tanggal' => $d->tanggal ? \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y') : '-',
                                'jam_keluar' => $d->jam_keluar ? $d->jam_keluar . ' WIB' : ($d->created_at ? $d->created_at->format('H:i') . ' WIB' : '-'),
                                'jam_kembali' => $d->jam_kembali ? $d->jam_kembali . ' WIB' : '-',
                                'alasan' => $d->alasan ?? '-',
                                'tempat' => $d->tempat ?? '-',
                                'kode_dispen' => $d->kode_dispen ?? 'DSP-' . str_pad($d->id_siswa_dispen, 5, '0', STR_PAD_LEFT),
                                'guru_piket' => $d->nama_guru_piket ?? ($d->guruPiketUser->nama ?? 'Guru Piket'),
                                'nip_guru_piket' => $d->nip_guru_piket ?? '-',
                                'status_waka' => $d->status_waka ?? 'approved',
                                'catatan_waka' => $d->catatan_waka ?? '-',
                                'status_satpam' => $satpamTeks,
                                'status_satpam_raw' => $stSatpam,
                                'waktu_scan_satpam' => $d->waktu_scan_satpam ?? ($d->waktu_satpam ?? '-'),
                                'catatan_satpam' => $d->catatan_satpam ?? '-',
                                'foto_surat' => $d->foto_surat_url,
                                'foto_kartu' => $d->foto_kartu_url,
                                'foto_live' => $d->foto_siswa_live_url,
                                'ttd_siswa' => $d->ttd_siswa_url,
                                'ttd_piket' => $d->ttd_piket_url,
                            ]);
                        @endphp
                        <tr class="dispen-row" data-status="{{ $stSatpam }}" style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;">
                            <td style="padding: 16px; color: #64748b; font-weight: 700; text-align: center;">{{ $idx + 1 }}</td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $namaSiswa }}</div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                    NISN: {{ $nisnSiswa }}
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: #eef2ff; color: #384972; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 12px; border: 1px solid #c7d2fe;">
                                    {{ $namaKelas }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: #334155; font-weight: 600;">
                                <div>{{ $d->alasan }}</div>
                                @if($d->tempat)
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                        <i class="fa-solid fa-location-dot" style="color: #384972;"></i> {{ $d->tempat }}
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 16px; color: #475569; font-weight: 700;">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-regular fa-clock" style="color: #384972;"></i> {{ $jamTeks }}
                                </div>
                                @if($d->jam_kembali)
                                    <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                        Kembali: {{ $d->jam_kembali }} WIB
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: {{ $satpamBg }}; color: {{ $satpamColor }}; padding: 5px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                    {{ $satpamTeks }}
                                </span>
                                @if($d->waktu_scan_satpam)
                                    <div style="font-size: 11px; color: #64748b; margin-top: 3px; font-weight: 600;">
                                        {{ $d->waktu_scan_satpam }}
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <button type="button" onclick='showDetailDispen({!! $detailJson !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2); transition: all 0.2s;">
                                    <i class="fa-solid fa-eye"></i> Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-folder-open" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                Tidak ada data siswa dispensasi keluar sekolah yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards List View (Dispensasi) -->
        <div class="mobile-cards-list mobile-dispen-cards-list">
            @forelse($dispenSiswa as $idx => $d)
                @php
                    $namaSiswa = $d->siswa->nama_siswa ?? 'Siswa';
                    $nisnSiswa = $d->siswa->nisn ?? '-';
                    $namaKelas = $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? 'X AK 4');
                    
                    $jamTeks = '-';
                    if ($d->created_at) {
                        $jamTeks = $d->created_at->format('H:i') . ' WIB';
                    } elseif ($d->jam_keluar) {
                        $jamTeks = $d->jam_keluar . ' WIB';
                    }

                    $stSatpam = strtolower($d->status_satpam ?? 'belum_keluar');
                    $satpamBg = '#dcfce7';
                    $satpamColor = '#166534';
                    $satpamTeks = 'Dizinkan keluar';

                    if ($stSatpam === 'belum_keluar') {
                        $satpamBg = '#f1f5f9';
                        $satpamColor = '#475569';
                        $satpamTeks = 'Belum keluar';
                    } elseif ($stSatpam === 'dizinkan_keluar') {
                        $satpamBg = '#dcfce7';
                        $satpamColor = '#166534';
                        $satpamTeks = 'Dizinkan keluar';
                    } elseif ($stSatpam === 'sudah_kembali') {
                        $satpamBg = '#dbeafe';
                        $satpamColor = '#1e40af';
                        $satpamTeks = 'Sudah kembali';
                    } elseif ($stSatpam === 'ditolak') {
                        $satpamBg = '#fee2e2';
                        $satpamColor = '#991b1b';
                        $satpamTeks = 'Ditolak satpam';
                    }

                    $detailJson = json_encode([
                        'id' => $d->id_siswa_dispen,
                        'nama' => $namaSiswa,
                        'nisn' => $nisnSiswa,
                        'kelas' => $namaKelas,
                        'tanggal' => $d->tanggal ? \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y') : '-',
                        'jam_keluar' => $d->jam_keluar ? $d->jam_keluar . ' WIB' : ($d->created_at ? $d->created_at->format('H:i') . ' WIB' : '-'),
                        'jam_kembali' => $d->jam_kembali ? $d->jam_kembali . ' WIB' : '-',
                        'alasan' => $d->alasan ?? '-',
                        'tempat' => $d->tempat ?? '-',
                        'kode_dispen' => $d->kode_dispen ?? 'DSP-' . str_pad($d->id_siswa_dispen, 5, '0', STR_PAD_LEFT),
                        'guru_piket' => $d->nama_guru_piket ?? ($d->guruPiketUser->nama ?? 'Guru Piket'),
                        'nip_guru_piket' => $d->nip_guru_piket ?? '-',
                        'status_waka' => $d->status_waka ?? 'approved',
                        'catatan_waka' => $d->catatan_waka ?? '-',
                        'status_satpam' => $satpamTeks,
                        'status_satpam_raw' => $stSatpam,
                        'waktu_scan_satpam' => $d->waktu_scan_satpam ?? ($d->waktu_satpam ?? '-'),
                        'catatan_satpam' => $d->catatan_satpam ?? '-',
                        'foto_surat' => $d->foto_surat_url,
                        'foto_kartu' => $d->foto_kartu_url,
                        'foto_live' => $d->foto_siswa_live_url,
                        'ttd_siswa' => $d->ttd_siswa_url,
                        'ttd_piket' => $d->ttd_piket_url,
                    ]);
                @endphp
                <div class="mobile-data-card mobile-dispen-card" data-status="{{ $stSatpam }}">
                    <div class="mobile-card-top">
                        <div>
                            <div style="font-weight: 800; color: #0f172a; font-size: 15px;">{{ $namaSiswa }}</div>
                            <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                NISN: {{ $nisnSiswa }}
                            </div>
                        </div>
                        <span style="background: #eef2ff; color: #384972; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 12px; border: 1px solid #c7d2fe;">
                            {{ $namaKelas }}
                        </span>
                    </div>

                    <div class="mobile-card-body">
                        <div class="mobile-card-row">
                            <i class="fa-solid fa-note-sticky" style="color: #384972; width: 16px;"></i>
                            <div style="flex: 1; font-weight: 600; color: #1e293b;">
                                {{ $d->alasan }}
                                @if($d->tempat)
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                        <i class="fa-solid fa-location-dot" style="color: #384972;"></i> {{ $d->tempat }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mobile-card-row">
                            <i class="fa-regular fa-clock" style="color: #384972; width: 16px;"></i>
                            <div style="font-weight: 700; color: #334155;">
                                <span>Izin: {{ $jamTeks }}</span>
                                @if($d->jam_kembali)
                                    <span style="color: #64748b; font-size: 11.5px; margin-left: 6px;">(Kembali: {{ $d->jam_kembali }} WIB)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mobile-card-footer">
                        <div>
                            <span style="background: {{ $satpamBg }}; color: {{ $satpamColor }}; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                {{ $satpamTeks }}
                            </span>
                        </div>
                        <button type="button" onclick='showDetailDispen({!! $detailJson !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);">
                            <i class="fa-solid fa-eye"></i> Detail
                        </button>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 26px 16px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; color: #64748b; font-weight: 600; font-size: 13px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 26px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                    Tidak ada data siswa dispensasi keluar yang sesuai dengan filter.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 5. Table 2: Siswa Izin Tidak Masuk Sekolah (Sakit / Izin) -->
    <div class="table-section-card">
        <div class="table-header-toolbar">
            <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-notes-medical" style="color: #384972;"></i> Siswa Izin Tidak Masuk Sekolah (Sakit / Izin)
                <span style="background: #dbeafe; color: #1e40af; font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                    {{ count($suratIzinSiswa) }} Data
                </span>
            </h3>

            <!-- Quick Table 2 Filter Pills & Search -->
            <div class="table-toolbar-controls" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="filter-pill-container">
                    <button type="button" onclick="filterSuratIzinTable('all')" class="surat-filter-btn active" data-filter="all" style="border: none; background: #384972; color: #fff; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Semua</button>
                    <button type="button" onclick="filterSuratIzinTable('sakit')" class="surat-filter-btn" data-filter="sakit" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Sakit</button>
                    <button type="button" onclick="filterSuratIzinTable('izin')" class="surat-filter-btn" data-filter="izin" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Izin</button>
                    <button type="button" onclick="filterSuratIzinTable('dispen')" class="surat-filter-btn" data-filter="dispen" style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Dispensasi</button>
                </div>

                <div class="table-search-box" style="position: relative; width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="liveSearchSuratIzin" onkeyup="searchSuratIzinRows()" placeholder="Cari di tabel surat..." style="width: 100%; padding: 6px 28px 6px 28px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; color: #1e293b; background: #f8fafc; box-sizing: border-box;">
                    <button type="button" onclick="clearSearchSuratIzin()" id="btnResetSearchSuratIzin" style="display: none; position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 11px;">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="desktop-table-wrapper">
            <table id="tableSuratIzin" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; width: 50px;">No</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jenis Keterangan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Tanggal Izin</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Alasan Permohonan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratIzinSiswa as $idx => $s)
                        @php
                            $namaSiswaIzin = $s->siswa->nama_siswa ?? 'Siswa';
                            $nisnSiswaIzin = $s->siswa->nisn ?? '-';
                            $namaKelasIzin = $s->kelas->nama_kelas ?? ($s->siswa->kelas->nama_kelas ?? 'X AK 1');
                            $rawKategori = strtolower($s->kategori ?? 'izin');
                            $ketTeks = strtoupper($s->kategori ?? 'IZIN');

                            // Badge color
                            $katBg = '#fef3c7';
                            $katColor = '#92400e';
                            if (str_contains($rawKategori, 'sakit')) {
                                $katBg = '#fee2e2';
                                $katColor = '#991b1b';
                            } elseif (str_contains($rawKategori, 'dispen')) {
                                $katBg = '#e0e7ff';
                                $katColor = '#3730a3';
                            }

                            $startDate = \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y');
                            $endDate = $s->tanggal_selesai ? \Carbon\Carbon::parse($s->tanggal_selesai)->format('d/m/Y') : $startDate;
                            $durasi = ($s->durasi_hari > 0) ? $s->durasi_hari : 1;
                            $dateDisplay = ($startDate === $endDate) ? $startDate : "$startDate s/d $endDate";

                            $detailSuratJson = json_encode([
                                'id' => $s->id_surat_izin,
                                'nama' => $namaSiswaIzin,
                                'nisn' => $nisnSiswaIzin,
                                'kelas' => $namaKelasIzin,
                                'kategori' => $ketTeks,
                                'tanggal_mulai' => $startDate,
                                'tanggal_selesai' => $endDate,
                                'durasi' => $durasi . ' Hari',
                                'keterangan' => $s->keterangan ?? $s->alasan ?? 'Izin berhalangan hadir',
                                'status' => $s->status ?? 'Terverifikasi',
                                'petugas' => $s->petugasPiket->nama ?? ($s->petugasPiket->nama_guru ?? 'Guru Piket'),
                                'foto_url' => $s->foto_url,
                            ]);
                        @endphp
                        <tr class="surat-row" data-kategori="{{ $rawKategori }}" style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;">
                            <td style="padding: 16px; color: #64748b; font-weight: 700; text-align: center;">{{ $idx + 1 }}</td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $namaSiswaIzin }}</div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                    NISN: {{ $nisnSiswaIzin }}
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: #eef2ff; color: #384972; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 12px; border: 1px solid #c7d2fe;">
                                    {{ $namaKelasIzin }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: {{ $katBg }}; color: {{ $katColor }}; padding: 5px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                    {{ $ketTeks }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: #475569; font-weight: 700;">
                                <div>{{ $dateDisplay }}</div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                    Durasi: {{ $durasi }} Hari
                                </div>
                            </td>
                            <td style="padding: 16px; color: #334155; font-weight: 600;">
                                {{ $s->keterangan ?? $s->alasan ?? 'Izin keperluan pribadi' }}
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <button type="button" onclick='showDetailSuratIzin({!! $detailSuratJson !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2); transition: all 0.2s;">
                                    <i class="fa-solid fa-eye"></i> Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-folder-open" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                Belum ada data surat izin tidak masuk sekolah hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards List View (Surat Izin) -->
        <div class="mobile-cards-list mobile-surat-cards-list">
            @forelse($suratIzinSiswa as $idx => $s)
                @php
                    $namaSiswaIzin = $s->siswa->nama_siswa ?? 'Siswa';
                    $nisnSiswaIzin = $s->siswa->nisn ?? '-';
                    $namaKelasIzin = $s->kelas->nama_kelas ?? ($s->siswa->kelas->nama_kelas ?? 'X AK 1');
                    $rawKategori = strtolower($s->kategori ?? 'izin');
                    $ketTeks = strtoupper($s->kategori ?? 'IZIN');

                    $katBg = '#fef3c7';
                    $katColor = '#92400e';
                    if (str_contains($rawKategori, 'sakit')) {
                        $katBg = '#fee2e2';
                        $katColor = '#991b1b';
                    } elseif (str_contains($rawKategori, 'dispen')) {
                        $katBg = '#e0e7ff';
                        $katColor = '#3730a3';
                    }

                    $startDate = \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y');
                    $endDate = $s->tanggal_selesai ? \Carbon\Carbon::parse($s->tanggal_selesai)->format('d/m/Y') : $startDate;
                    $durasi = ($s->durasi_hari > 0) ? $s->durasi_hari : 1;
                    $dateDisplay = ($startDate === $endDate) ? $startDate : "$startDate s/d $endDate";

                    $detailSuratJson = json_encode([
                        'id' => $s->id_surat_izin,
                        'nama' => $namaSiswaIzin,
                        'nisn' => $nisnSiswaIzin,
                        'kelas' => $namaKelasIzin,
                        'kategori' => $ketTeks,
                        'tanggal_mulai' => $startDate,
                        'tanggal_selesai' => $endDate,
                        'durasi' => $durasi . ' Hari',
                        'keterangan' => $s->keterangan ?? $s->alasan ?? 'Izin berhalangan hadir',
                        'status' => $s->status ?? 'Terverifikasi',
                        'petugas' => $s->petugasPiket->nama ?? ($s->petugasPiket->nama_guru ?? 'Guru Piket'),
                        'foto_url' => $s->foto_url,
                    ]);
                @endphp
                <div class="mobile-data-card mobile-surat-card" data-kategori="{{ $rawKategori }}">
                    <div class="mobile-card-top">
                        <div>
                            <div style="font-weight: 800; color: #0f172a; font-size: 15px;">{{ $namaSiswaIzin }}</div>
                            <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                NISN: {{ $nisnSiswaIzin }}
                            </div>
                        </div>
                        <span style="background: #eef2ff; color: #384972; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 12px; border: 1px solid #c7d2fe;">
                            {{ $namaKelasIzin }}
                        </span>
                    </div>

                    <div class="mobile-card-body">
                        <div class="mobile-card-row">
                            <i class="fa-solid fa-calendar-days" style="color: #384972; width: 16px;"></i>
                            <div style="font-weight: 700; color: #334155;">
                                <span>{{ $dateDisplay }}</span>
                                <span style="color: #2563eb; font-size: 11.5px; margin-left: 6px;">({{ $durasi }} Hari)</span>
                            </div>
                        </div>

                        <div class="mobile-card-row">
                            <i class="fa-solid fa-align-left" style="color: #384972; width: 16px;"></i>
                            <div style="flex: 1; font-weight: 600; color: #1e293b;">
                                {{ $s->keterangan ?? $s->alasan ?? 'Izin keperluan pribadi' }}
                            </div>
                        </div>
                    </div>

                    <div class="mobile-card-footer">
                        <div>
                            <span style="background: {{ $katBg }}; color: {{ $katColor }}; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                {{ $ketTeks }}
                            </span>
                        </div>
                        <button type="button" onclick='showDetailSuratIzin({!! $detailSuratJson !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);">
                            <i class="fa-solid fa-eye"></i> Detail
                        </button>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 26px 16px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; color: #64748b; font-weight: 600; font-size: 13px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 26px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                    Belum ada data surat izin tidak masuk sekolah hari ini.
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL 1: DETAIL DISPENSASI KELUAR GERBANG SEKOLAH (LENGKAP FOTO & TTD)   -->
<!-- ========================================================================= -->
<div id="modalDetailDispen" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 14px;">
    <div class="modal-content-container" style="background: #ffffff; width: 100%; max-width: 680px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; max-height: 92vh;">
        
        <!-- Modal Header -->
        <div class="modal-header-responsive" style="background: linear-gradient(135deg, #1e293b, #384972); padding: 20px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <div>
                <div style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; font-weight: 700;">
                    DETAIL DISPENSASI KELUAR GERBANG SEKOLAH
                </div>
                <h3 id="mdDispenNama" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 800; color: #ffffff;">
                    Nama Siswa
                </h3>
            </div>
            <button onclick="closeModal('modalDetailDispen')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body-responsive" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px; font-size: 13.5px;">
            
            <!-- Student Header Box -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Identitas Siswa</div>
                    <div id="mdDispenSub" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;">NISN: - | Kelas: -</div>
                </div>
                <span id="mdDispenKode" style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 12px; font-family: monospace;">
                    DSP-00000
                </span>
            </div>

            <!-- Detail Grid -->
            <div class="modal-body-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 700;">Tanggal Dispensasi</div>
                    <div id="mdDispenTanggal" style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 3px;">-</div>
                </div>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 700;">Rentang Waktu Izin</div>
                    <div id="mdDispenJam" style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 3px;">-</div>
                </div>
            </div>

            <!-- Reason & Destination -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; margin-bottom: 4px;">Keperluan / Alasan Izin</div>
                <div id="mdDispenAlasan" style="font-size: 13.5px; font-weight: 700; color: #1e293b; line-height: 1.4;">-</div>
                <div id="mdDispenTempatBox" style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #e2e8f0; font-size: 12.5px; color: #475569;">
                    <i class="fa-solid fa-location-dot" style="color: #384972;"></i> <strong>Tempat / Tujuan:</strong> <span id="mdDispenTempat">-</span>
                </div>
            </div>

            <!-- Workflow Validations -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 12px; color: #384972; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-signature"></i> Verifikasi & Pemindaian Gerbang
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Guru Piket -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; gap: 8px;">
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">Petugas Guru Piket:</div>
                            <div id="mdDispenPiket" style="color: #64748b;">-</div>
                        </div>
                        <span style="background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 800; white-space: nowrap;">Telah Disetujui</span>
                    </div>

                    <!-- Satpam -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; gap: 8px;">
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">Pemeriksaan Satpam Gerbang:</div>
                            <div id="mdDispenSatpamKet" style="color: #64748b; font-size: 11.5px;">-</div>
                        </div>
                        <span id="mdDispenSatpamBadge" style="background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 800; white-space: nowrap;">
                            -
                        </span>
                    </div>
                </div>
            </div>

            <!-- Lampiran Berkas, Kartu & Tanda Tangan (FOTO LENGKAP & DAPAT DI-ZOOM) -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 12px; color: #384972; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-images"></i> Lampiran Berkas, Kartu & Tanda Tangan
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px;">
                    <!-- Foto Surat Dispensasi -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; text-align: center; background: #f8fafc;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 6px;">Foto Surat Dispensasi</div>
                        <div id="mdDispenSuratBox" style="min-height: 110px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px dashed #cbd5e1; border-radius: 6px; overflow: hidden; cursor: pointer;">
                            <img id="mdDispenFotoSurat" src="" alt="Surat Dispensasi" style="max-height: 110px; max-width: 100%; object-fit: contain;" onclick="openLightbox(this.src, 'Surat Dispensasi')">
                            <span id="mdDispenFotoSuratEmpty" style="font-size: 11px; color: #94a3b8; display: none;">Tidak ada file</span>
                        </div>
                    </div>

                    <!-- Foto Kartu Identitas / Pelajar -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; text-align: center; background: #f8fafc;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 6px;">Foto Kartu Pelajar</div>
                        <div id="mdDispenKartuBox" style="min-height: 110px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px dashed #cbd5e1; border-radius: 6px; overflow: hidden; cursor: pointer;">
                            <img id="mdDispenFotoKartu" src="" alt="Kartu Pelajar" style="max-height: 110px; max-width: 100%; object-fit: contain;" onclick="openLightbox(this.src, 'Kartu Identitas Pelajar')">
                            <span id="mdDispenFotoKartuEmpty" style="font-size: 11px; color: #94a3b8; display: none;">Tidak ada file</span>
                        </div>
                    </div>

                    <!-- Tanda Tangan Siswa & Piket -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; text-align: center; background: #f8fafc;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 6px;">Tanda Tangan Digital</div>
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <div id="mdDispenTtdSiswaBox" style="width: 50%; min-height: 60px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px;">
                                <img id="mdDispenTtdSiswa" src="" alt="TTD Siswa" style="max-height: 45px; max-width: 100%;" onclick="openLightbox(this.src, 'TTD Siswa')">
                                <span style="font-size: 9.5px; color: #64748b; font-weight: 700;">TTD Siswa</span>
                            </div>
                            <div id="mdDispenTtdPiketBox" style="width: 50%; min-height: 60px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px;">
                                <img id="mdDispenTtdPiket" src="" alt="TTD Piket" style="max-height: 45px; max-width: 100%;" onclick="openLightbox(this.src, 'TTD Guru Piket')">
                                <span style="font-size: 9.5px; color: #64748b; font-weight: 700;">TTD Piket</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="font-size: 11px; color: #94a3b8; margin-top: 8px; text-align: center;">
                    <i class="fa-solid fa-magnifying-glass-plus"></i> Klik gambar berkas atau tanda tangan di atas untuk melihat resolusi penuh / zoom
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div style="background: #f8fafc; padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button onclick="closeModal('modalDetailDispen')" style="background: #384972; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: DETAIL SURAT IZIN TIDAK MASUK (LENGKAP FOTO DOKTER/ORTU)        -->
<!-- ========================================================================= -->
<div id="modalDetailSuratIzin" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 14px;">
    <div class="modal-content-container" style="background: #ffffff; width: 100%; max-width: 680px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; max-height: 92vh;">
        
        <!-- Modal Header -->
        <div class="modal-header-responsive" style="background: linear-gradient(135deg, #1e293b, #384972); padding: 20px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <div>
                <div style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; font-weight: 700;">
                    DETAIL SURAT PERMOHONAN IZIN SISWA
                </div>
                <h3 id="mdSuratNama" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 800; color: #ffffff;">
                    Nama Siswa
                </h3>
            </div>
            <button onclick="closeModal('modalDetailSuratIzin')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body-responsive" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px; font-size: 13.5px;">
            
            <!-- Student Header Box -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Identitas Siswa</div>
                    <div id="mdSuratSub" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;">NISN: - | Kelas: -</div>
                </div>
                <span id="mdSuratKategoriBadge" style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 12px;">
                    SAKIT
                </span>
            </div>

            <!-- Dates Grid -->
            <div class="modal-body-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 700;">Rentang Waktu Izin</div>
                    <div id="mdSuratRentang" style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 3px;">-</div>
                </div>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 700;">Durasi Ketidakhadiran</div>
                    <div id="mdSuratDurasi" style="font-size: 13.5px; font-weight: 800; color: #2563eb; margin-top: 3px;">- Hari</div>
                </div>
            </div>

            <!-- Reason Description -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; margin-bottom: 4px;">Alasan Permohonan / Diagnosa Dokter</div>
                <div id="mdSuratAlasan" style="font-size: 13.5px; font-weight: 700; color: #1e293b; line-height: 1.4;">-</div>
            </div>

            <!-- Status Verifikasi -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 12px; color: #384972; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-circle-check"></i> Status Verifikasi Surat
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; gap: 8px;">
                    <div>
                        <div style="font-weight: 700; color: #1e293b;">Petugas Piket Pemeriksa:</div>
                        <div id="mdSuratPetugas" style="color: #64748b;">-</div>
                    </div>
                    <span id="mdSuratStatusBadge" style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 800; white-space: nowrap;">
                        Terverifikasi
                    </span>
                </div>
            </div>

            <!-- Lampiran Foto Surat Dokter / Orang Tua -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                <div style="font-size: 12px; color: #384972; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-file-medical"></i> Bukti Lampiran Surat (Dokter / Orang Tua)
                </div>
                
                <div id="mdSuratFotoBox" style="min-height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px; cursor: pointer;">
                    <img id="mdSuratFoto" src="" alt="Surat Keterangan" style="max-height: 240px; max-width: 100%; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onclick="openLightbox(this.src, 'Surat Keterangan Dokter / Orang Tua')">
                    <span id="mdSuratFotoEmpty" style="font-size: 12px; color: #94a3b8; display: none;">Tidak ada foto lampiran surat</span>
                    <div id="mdSuratFotoHint" style="font-size: 11px; color: #64748b; margin-top: 8px; font-weight: 600;">
                        <i class="fa-solid fa-magnifying-glass-plus"></i> Klik pada gambar untuk memperbesar resolusi penuh
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div style="background: #f8fafc; padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button onclick="closeModal('modalDetailSuratIzin')" style="background: #384972; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 3: LIGHTBOX IMAGE VIEWER                                           -->
<!-- ========================================================================= -->
<div id="modalImageLightbox" style="display: none; position: fixed; inset: 0; z-index: 10000; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(6px); align-items: center; justify-content: center; padding: 16px;">
    <div style="position: relative; max-width: 92vw; max-height: 90vh; display: flex; flex-direction: column; align-items: center;">
        <div style="position: absolute; top: -45px; right: 0; display: flex; gap: 10px;">
            <a id="lightboxDownloadBtn" href="" target="_blank" download style="background: rgba(255,255,255,0.2); color: #fff; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Asli
            </a>
            <button onclick="closeModal('modalImageLightbox')" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <img id="lightboxImg" src="" alt="Pratinjau Foto" style="max-width: 88vw; max-height: 75vh; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); object-fit: contain;">
        <div id="lightboxCaption" style="color: #fff; font-size: 13.5px; font-weight: 700; margin-top: 12px; text-align: center;">
            Pratinjau Berkas
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 4: CETAK REKAP IZIN SISWA                                          -->
<!-- ========================================================================= -->
<div id="modalCetakIzin" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 14px;">
    <div class="modal-content-container" style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
        <div class="modal-header-responsive" style="background: #384972; padding: 18px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-print"></i> Cetak Rekap Izin Siswa
            </h3>
            <button onclick="closeModal('modalCetakIzin')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px; font-size: 13.5px; display: flex; flex-direction: column; gap: 14px;">
            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Jenis Dokumen:</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="printType" value="all" checked>
                        <span><strong>Semua Rekap</strong> (Dispensasi & Surat Izin)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="printType" value="dispen">
                        <span><strong>Dispensasi Keluar Saja</strong></span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="printType" value="surat_izin">
                        <span><strong>Surat Izin (Sakit / Izin) Saja</strong></span>
                    </label>
                </div>
            </div>

            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Tanggal Rekap:</label>
                <input type="date" id="printTanggal" value="{{ request('tanggal') ?? date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
            </div>
        </div>
        <div style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="closeModal('modalCetakIzin')" style="background: #e2e8f0; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Batal
            </button>
            <button onclick="executePrintIzin()" style="background: #384972; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i> Buka Lembar Cetak
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 5: EXPORT REKAP CSV                                                -->
<!-- ========================================================================= -->
<div id="modalExportIzin" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 14px;">
    <div class="modal-content-container" style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
        <div class="modal-header-responsive" style="background: #10b981; padding: 18px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-excel"></i> Export Rekap Data CSV
            </h3>
            <button onclick="closeModal('modalExportIzin')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px; font-size: 13.5px; display: flex; flex-direction: column; gap: 14px;">
            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Data yang Diexport:</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="exportType" value="csv_all" checked>
                        <span><strong>Semua Data Rekap</strong> (Dispensasi & Surat Izin)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="exportType" value="csv_dispen">
                        <span><strong>Data Siswa Dispensasi Gerbang Saja</strong></span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="radio" name="exportType" value="csv_surat_izin">
                        <span><strong>Data Siswa Surat Izin Saja</strong></span>
                    </label>
                </div>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="closeModal('modalExportIzin')" style="background: #e2e8f0; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Batal
            </button>
            <button onclick="executeExportIzin()" style="background: #10b981; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-download"></i> Unduh File CSV
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT INTERACTIONS                                                  -->
<!-- ========================================================================= -->
<script>
function openModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'flex';
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'none';
}

// Lightbox Image Viewer
function openLightbox(imgSrc, caption) {
    if (!imgSrc) return;
    const modal = document.getElementById('modalImageLightbox');
    const img = document.getElementById('lightboxImg');
    const cap = document.getElementById('lightboxCaption');
    const dBtn = document.getElementById('lightboxDownloadBtn');
    
    img.src = imgSrc;
    cap.textContent = caption || 'Pratinjau Foto Bukti';
    dBtn.href = imgSrc;
    modal.style.display = 'flex';
}

// Close modals on backdrop click
window.addEventListener('click', function(e) {
    ['modalDetailDispen', 'modalDetailSuratIzin', 'modalCetakIzin', 'modalExportIzin', 'modalImageLightbox'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Clear Global Search
function clearGlobalSearch() {
    const input = document.getElementById('globalSearchInput');
    if (input) {
        input.value = '';
        document.getElementById('filterFormGlobal').submit();
    }
}

// Show Detail Dispensasi Modal
function showDetailDispen(data) {
    document.getElementById('mdDispenNama').textContent = data.nama || 'Siswa';
    document.getElementById('mdDispenSub').textContent = `NISN: ${data.nisn || '-'} | Kelas: ${data.kelas || '-'}`;
    document.getElementById('mdDispenKode').textContent = data.kode_dispen || 'DSP-0000';
    document.getElementById('mdDispenTanggal').textContent = data.tanggal || '-';
    document.getElementById('mdDispenJam').textContent = `${data.jam_keluar || '-'} s/d ${data.jam_kembali || '-'}`;
    document.getElementById('mdDispenAlasan').textContent = data.alasan || '-';
    
    if (data.tempat && data.tempat !== '-') {
        document.getElementById('mdDispenTempatBox').style.display = 'block';
        document.getElementById('mdDispenTempat').textContent = data.tempat;
    } else {
        document.getElementById('mdDispenTempatBox').style.display = 'none';
    }

    document.getElementById('mdDispenPiket').textContent = data.guru_piket || 'Guru Piket';

    const satpamBadge = document.getElementById('mdDispenSatpamBadge');
    satpamBadge.textContent = data.status_satpam || '-';
    if (data.status_satpam_raw === 'dizinkan_keluar') {
        satpamBadge.style.background = '#dcfce7';
        satpamBadge.style.color = '#166534';
    } else if (data.status_satpam_raw === 'sudah_kembali') {
        satpamBadge.style.background = '#dbeafe';
        satpamBadge.style.color = '#1e40af';
    } else if (data.status_satpam_raw === 'ditolak') {
        satpamBadge.style.background = '#fee2e2';
        satpamBadge.style.color = '#991b1b';
    } else {
        satpamBadge.style.background = '#f1f5f9';
        satpamBadge.style.color = '#475569';
    }

    let satpamInfo = '';
    if (data.waktu_scan_satpam && data.waktu_scan_satpam !== '-') {
        satpamInfo += `Waktu scan: ${data.waktu_scan_satpam}`;
    }
    if (data.catatan_satpam && data.catatan_satpam !== '-') {
        satpamInfo += (satpamInfo ? ' | ' : '') + `Catatan: ${data.catatan_satpam}`;
    }
    document.getElementById('mdDispenSatpamKet').textContent = satpamInfo || 'Belum ada catatan pemindaian satpam gerbang.';

    // Foto Surat
    const imgSurat = document.getElementById('mdDispenFotoSurat');
    const emptySurat = document.getElementById('mdDispenFotoSuratEmpty');
    if (data.foto_surat) {
        imgSurat.src = data.foto_surat;
        imgSurat.style.display = 'block';
        emptySurat.style.display = 'none';
    } else {
        imgSurat.style.display = 'none';
        emptySurat.style.display = 'block';
    }

    // Foto Kartu
    const imgKartu = document.getElementById('mdDispenFotoKartu');
    const emptyKartu = document.getElementById('mdDispenFotoKartuEmpty');
    if (data.foto_kartu) {
        imgKartu.src = data.foto_kartu;
        imgKartu.style.display = 'block';
        emptyKartu.style.display = 'none';
    } else {
        imgKartu.style.display = 'none';
        emptyKartu.style.display = 'block';
    }

    // TTD Siswa
    const imgTtdSiswa = document.getElementById('mdDispenTtdSiswa');
    if (data.ttd_siswa) {
        imgTtdSiswa.src = data.ttd_siswa;
        imgTtdSiswa.style.display = 'block';
    } else {
        imgTtdSiswa.style.display = 'none';
    }

    // TTD Piket
    const imgTtdPiket = document.getElementById('mdDispenTtdPiket');
    if (data.ttd_piket) {
        imgTtdPiket.src = data.ttd_piket;
        imgTtdPiket.style.display = 'block';
    } else {
        imgTtdPiket.style.display = 'none';
    }

    openModal('modalDetailDispen');
}

// Show Detail Surat Izin Modal
function showDetailSuratIzin(data) {
    document.getElementById('mdSuratNama').textContent = data.nama || 'Siswa';
    document.getElementById('mdSuratSub').textContent = `NISN: ${data.nisn || '-'} | Kelas: ${data.kelas || '-'}`;
    
    const katBadge = document.getElementById('mdSuratKategoriBadge');
    katBadge.textContent = data.kategori || 'IZIN';
    if (data.kategori.includes('SAKIT')) {
        katBadge.style.background = '#fee2e2';
        katBadge.style.color = '#991b1b';
    } else if (data.kategori.includes('DISPEN')) {
        katBadge.style.background = '#e0e7ff';
        katBadge.style.color = '#3730a3';
    } else {
        katBadge.style.background = '#fef3c7';
        katBadge.style.color = '#92400e';
    }

    document.getElementById('mdSuratRentang').textContent = `${data.tanggal_mulai} s/d ${data.tanggal_selesai}`;
    document.getElementById('mdSuratDurasi').textContent = data.durasi || '1 Hari';
    document.getElementById('mdSuratAlasan').textContent = data.keterangan || '-';
    document.getElementById('mdSuratPetugas').textContent = data.petugas || 'Guru Piket';
    document.getElementById('mdSuratStatusBadge').textContent = data.status || 'Terverifikasi';

    // Foto Bukti Surat
    const imgSurat = document.getElementById('mdSuratFoto');
    const emptySurat = document.getElementById('mdSuratFotoEmpty');
    const hintSurat = document.getElementById('mdSuratFotoHint');
    if (data.foto_url) {
        imgSurat.src = data.foto_url;
        imgSurat.style.display = 'block';
        emptySurat.style.display = 'none';
        hintSurat.style.display = 'block';
    } else {
        imgSurat.style.display = 'none';
        emptySurat.style.display = 'block';
        hintSurat.style.display = 'none';
    }

    openModal('modalDetailSuratIzin');
}

// Table 1 Quick Filter Pills (filters desktop rows and mobile cards)
function filterDispenTable(status) {
    document.querySelectorAll('.dispen-filter-btn').forEach(btn => {
        if (btn.getAttribute('data-filter') === status) {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = '#64748b';
        }
    });

    const rows = document.querySelectorAll('#tableDispen .dispen-row, .mobile-dispen-card');
    rows.forEach(r => {
        const rowStatus = r.getAttribute('data-status');
        if (status === 'all' || rowStatus === status) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });
}

// Table 1 Live Search (searches desktop rows and mobile cards)
function searchDispenRows() {
    const input = document.getElementById('liveSearchDispen').value.toLowerCase();
    const btnReset = document.getElementById('btnResetSearchDispen');
    if (btnReset) {
        btnReset.style.display = input.length > 0 ? 'block' : 'none';
    }

    const rows = document.querySelectorAll('#tableDispen .dispen-row, .mobile-dispen-card');
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        if (text.includes(input)) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });
}

function clearSearchDispen() {
    const input = document.getElementById('liveSearchDispen');
    input.value = '';
    searchDispenRows();
}

// Table 2 Quick Filter Pills (filters desktop rows and mobile cards)
function filterSuratIzinTable(kategori) {
    document.querySelectorAll('.surat-filter-btn').forEach(btn => {
        if (btn.getAttribute('data-filter') === kategori) {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = '#64748b';
        }
    });

    const rows = document.querySelectorAll('#tableSuratIzin .surat-row, .mobile-surat-card');
    rows.forEach(r => {
        const rowKat = r.getAttribute('data-kategori') || '';
        if (kategori === 'all' || rowKat.includes(kategori)) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });
}

// Table 2 Live Search (searches desktop rows and mobile cards)
function searchSuratIzinRows() {
    const input = document.getElementById('liveSearchSuratIzin').value.toLowerCase();
    const btnReset = document.getElementById('btnResetSearchSuratIzin');
    if (btnReset) {
        btnReset.style.display = input.length > 0 ? 'block' : 'none';
    }

    const rows = document.querySelectorAll('#tableSuratIzin .surat-row, .mobile-surat-card');
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        if (text.includes(input)) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });
}

function clearSearchSuratIzin() {
    const input = document.getElementById('liveSearchSuratIzin');
    input.value = '';
    searchSuratIzinRows();
}

// Open Cetak Modal
function openModalCetak() {
    openModal('modalCetakIzin');
}

// Open Export Modal
function openModalExport() {
    openModal('modalExportIzin');
}

// Execute Print
function executePrintIzin() {
    const type = document.querySelector('input[name="printType"]:checked').value;
    const tgl = document.getElementById('printTanggal').value;
    const url = `{{ route('kepala-sekolah.siswa-izin') }}?print=${type}&tanggal=${tgl}`;
    window.open(url, '_blank');
    closeModal('modalCetakIzin');
}

// Execute Export CSV
function executeExportIzin() {
    const type = document.querySelector('input[name="exportType"]:checked').value;
    const url = `{{ route('kepala-sekolah.siswa-izin') }}?export=${type}`;
    window.location.href = url;
    closeModal('modalExportIzin');
}
</script>
@endsection