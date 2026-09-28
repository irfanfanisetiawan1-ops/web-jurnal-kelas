<?php

$bladeContent = <<<'BLADE'
@extends('layouts.kepala_sekolah')

@section('title', 'Kehadiran Guru — Jurnal SMEA')

@section('styles')
<style>
    .kehadiran-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Page Header Banner */
    .page-header-box {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-header-sub {
        margin: 0;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Metric Summary Cards Grid (4 Cards) */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        width: 100%;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon.green  { background: #dcfce7; color: #16a34a; }
    .stat-icon.purple { background: #f3e8ff; color: #9333ea; }
    .stat-icon.amber  { background: #fef3c7; color: #d97706; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-info .stat-label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-info .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .stat-info .stat-desc {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Filter Toolbar Card */
    .filter-card {
        background: #ffffff;
        padding: 16px 20px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        width: 100%;
    }

    .filter-input {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        background: #ffffff;
        height: 38px;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.12);
    }

    .btn-filter {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 0 16px;
        height: 38px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-filter:hover {
        background: #233152;
    }

    .btn-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 0 14px;
        height: 38px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12.5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Guru Izin Cards List (Matching media_1788793366793.png) */
    .cards-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
    }

    .guru-card {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: box-shadow 0.2s ease;
    }

    .guru-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-profile {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .profile-avatar-box {
        width: 54px;
        height: 54px;
        background: #8fa0c4;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 10.5px;
        text-align: center;
        line-height: 1.2;
        padding: 4px;
        flex-shrink: 0;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .profile-name {
        font-size: 16.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .profile-sub {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .status-pill {
        font-weight: 800;
        font-size: 12.5px;
        padding: 6px 18px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pill.pending  { background: #fef08a; color: #713f12; }
    .status-pill.approved { background: #86efac; color: #14532d; }
    .status-pill.rejected { background: #fca5a5; color: #7f1d1d; }

    .card-divider {
        border-bottom: 1.5px solid #f1f5f9;
    }

    .card-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .detail-header-label {
        font-size: 11px;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-header-value {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 4px;
    }

    .alasan-box {
        background: #f1f5f9;
        padding: 12px 18px;
        border-radius: 12px;
        margin-top: 6px;
        color: #475569;
        font-weight: 600;
        font-size: 13.5px;
        line-height: 1.45;
    }

    .card-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
        flex-wrap: wrap;
    }

    .btn-card-reject {
        background: #dc2626;
        color: #ffffff;
        padding: 8px 24px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-card-reject:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    .btn-card-approve {
        background: #1d4ed8;
        color: #ffffff;
        padding: 8px 24px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-card-approve:hover {
        background: #1e40af;
        transform: translateY(-1px);
    }

    .btn-card-detail {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 7px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-card-detail:hover {
        background: #dbeafe;
    }

    /* Master Rekap Table Card */
    .table-panel-card {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        margin-top: 8px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .table-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-panel-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }

    .custom-table thead tr {
        background: #f8fafc;
        border-bottom: 1.5px solid #cbd5e1;
        color: #475569;
    }

    .custom-table th {
        padding: 12px 14px;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .custom-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-box {
        background: #ffffff;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        border: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    .modal-body {
        padding: 18px 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }
</style>
@endsection

@section('content')
<div class="kehadiran-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 13px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 13px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header Banner (Persis Mockup media_1788793366793.png) -->
    <div class="page-header-box">
        <div>
            <h1 class="page-header-title">Kehadiran Guru</h1>
            <p class="page-header-sub">
                Daftar permohonan izin aktif Guru dan Siswa
            </p>
        </div>

        <div style="width: 44px; height: 44px; background: #f1f5f9; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 18px; cursor: pointer;" title="Notifikasi Persetujuan ({{ $pendingApprovalCount ?? 0 }})">
            <i class="fa-regular fa-bell"></i>
        </div>
    </div>

    <!-- 4 Stat Summary Cards -->
    <div class="stat-grid-4">
        <!-- Card 1: Total Guru -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">TOTAL GURU</div>
                <div class="stat-val">{{ $totalGuru ?? 127 }}</div>
                <div class="stat-desc">Pendidik terdaftar</div>
            </div>
        </div>

        <!-- Card 2: Hadir / Mengajar -->
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">HADIR / MENGAJAR</div>
                <div class="stat-val">{{ $guruHadirCount ?? 0 }}/{{ $totalGuru ?? 127 }}</div>
                <div class="stat-desc">{{ $kehadiranPct ?? 0 }}% keaktifan KBM</div>
            </div>
        </div>

        <!-- Card 3: Guru Izin / Cuti -->
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">GURU IZIN / CUTI</div>
                <div class="stat-val">{{ $guruIzinCount ?? 0 }}</div>
                <div class="stat-desc">Izin terkonfirmasi hari ini</div>
            </div>
        </div>

        <!-- Card 4: Menunggu Persetujuan -->
        <div class="stat-card">
            <div class="stat-icon amber">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">MENUNGGU KEPSEK</div>
                <div class="stat-val">{{ $pendingApprovalCount ?? 0 }}</div>
                <div class="stat-desc">Perlu persetujuan</div>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian Toolbar -->
    <div class="filter-card">
        <form method="GET" action="{{ route('kepala-sekolah.kehadiran-guru') }}" class="filter-grid">
            
            <!-- Cari Nama / NIP / Alasan -->
            <div style="flex: 2 1 200px; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Cari Guru, NIP, Alasan, Mapel..." class="filter-input" style="width: 100%; padding-left: 34px;">
            </div>

            <!-- Dropdown Status Persetujuan -->
            <div style="flex: 1 1 140px;">
                <select name="status" class="filter-input" style="width: 100%;">
                    <option value="all">-- Semua Status --</option>
                    <option value="pending" {{ ($statusFilter ?? 'all') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="approved" {{ ($statusFilter ?? 'all') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ ($statusFilter ?? 'all') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Dropdown Kategori Izin -->
            <div style="flex: 1 1 140px;">
                <select name="kategori" class="filter-input" style="width: 100%;">
                    <option value="all">-- Semua Kategori --</option>
                    <option value="biasa" {{ ($kategoriFilter ?? 'all') == 'biasa' ? 'selected' : '' }}>Izin Biasa</option>
                    <option value="cuti" {{ ($kategoriFilter ?? 'all') == 'cuti' ? 'selected' : '' }}>Cuti / Izin Khusus</option>
                    <option value="sakit" {{ ($kategoriFilter ?? 'all') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="dinas" {{ ($kategoriFilter ?? 'all') == 'dinas' ? 'selected' : '' }}>Tugas Dinas Luar</option>
                </select>
            </div>

            <!-- Filter Date -->
            <div style="flex: 1 1 130px;">
                <input type="date" name="tanggal" value="{{ $tanggal ?? date('Y-m-d') }}" class="filter-input" style="width: 100%;">
            </div>

            <!-- Buttons: Filter & Reset -->
            <div style="display: flex; gap: 8px; align-items: center; margin-left: auto;">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                <a href="{{ route('kepala-sekolah.kehadiran-guru') }}" class="btn-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>

        </form>
    </div>

    <!-- Cards List Permohonan Izin Guru (Persis Mockup UI media_1788793366793.png) -->
    <div class="cards-list">
        @forelse($guruIzinList as $izin)
            @php
                $namaGuru = $izin->guru->nama_guru ?? 'Wiwik Yuniarsih, S.Pd';
                $nipGuru = $izin->guru->nip ?? '-';
                $mapelGuru = $izin->guru->mapel->nama_mapel ?? 'Pendidikan Pancasila';
                $initials = strtoupper(substr($namaGuru, 0, 2));

                $tglFormatted = $izin->tanggal_mulai ? \Carbon\Carbon::parse($izin->tanggal_mulai)->translatedFormat('d – F – Y') : '-';
                $durasiText = $izin->durasi_formatted_real ?? ($izin->durasi ?: '1 Hari');
                $hasTitipan = !empty($izin->tugas_dititipkan) || !empty($izin->materi_dititipkan) || !empty($izin->file_tugas);
                $substituteName = $izin->nama_guru_pengganti ?? ($izin->guruPiket->nama_guru ?? null);
            @endphp
            <div class="guru-card">
                
                <!-- Top Header Card: Profil Guru & Status Pill -->
                <div class="card-top">
                    <div class="card-profile">
                        <div class="profile-avatar-box">
                            PROFIL GURUNYA
                        </div>
                        <div>
                            <div class="profile-name">
                                {{ $namaGuru }}
                            </div>
                            <div class="profile-sub">
                                Guru – {{ $mapelGuru }} @if($nipGuru !== '-') • <span style="color: #94a3b8;">NIP: {{ $nipGuru }}</span> @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status Pill Badge -->
                    <div>
                        @if($izin->status_kepsek == 'approved')
                            <span class="status-pill approved">
                                <i class="fa-solid fa-circle-check"></i> Disetujui
                            </span>
                        @elseif($izin->status_kepsek == 'rejected')
                            <span class="status-pill rejected">
                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                            </span>
                        @else
                            <span class="status-pill pending">
                                <i class="fa-solid fa-clock"></i> Menunggu Persetujuan
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-divider"></div>

                <!-- Details Grid: Tanggal & Durasi -->
                <div class="card-details-grid">
                    <div>
                        <div class="detail-header-label">
                            TANGGAL
                        </div>
                        <div class="detail-header-value">
                            {{ $tglFormatted }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-header-label">
                            DURASI
                        </div>
                        <div class="detail-header-value">
                            {{ $durasiText }}
                        </div>
                    </div>
                </div>

                <!-- Alasan Block -->
                <div>
                    <div class="detail-header-label">
                        ALASAN
                    </div>
                    <div class="alasan-box">
                        {{ $izin->alasan }}
                    </div>
                </div>

                <!-- Extra info if titipan / pengganti -->
                @if($hasTitipan || $substituteName || $izin->foto_surat)
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-top: 2px;">
                        @if($hasTitipan)
                            <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; padding: 3px 9px; border-radius: 8px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-file-signature"></i> Ada Titipan Tugas / Materi
                            </span>
                        @endif

                        @if($substituteName)
                            <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 3px 9px; border-radius: 8px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-user-tag"></i> Pengganti: {{ $substituteName }}
                            </span>
                        @endif

                        <button type="button" class="btn-card-detail" onclick="showFotoModal('{{ $namaGuru }}', '{{ $izin->foto_url_resolved }}', '{{ addslashes($izin->alasan) }}')">
                            <i class="fa-regular fa-image"></i> Lihat Bukti Surat
                        </button>
                    </div>
                @endif

                <!-- Action Buttons: Tolak / Setujui -->
                @if($izin->status_kepsek == 'pending')
                    <div class="card-actions">
                        <button type="button" class="btn-card-reject" onclick="openRejectModal({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')">
                            Tolak
                        </button>

                        <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST" style="display: inline;" onsubmit="return confirm('Setujui izin untuk {{ addslashes($namaGuru) }}?')">
                            @csrf
                            <button type="submit" class="btn-card-approve">
                                Setujui
                            </button>
                        </form>
                    </div>
                @else
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 2px;">
                        @if($izin->catatan_kepsek)
                            <div style="font-size: 12px; color: #64748b; font-style: italic;">
                                Catatan: {{ $izin->catatan_kepsek }}
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        @empty
            <div style="background: #ffffff; padding: 36px; border-radius: 16px; text-align: center; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                <i class="fa-regular fa-calendar-check" style="font-size: 36px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                Tidak ada permohonan izin guru yang cocok dengan kriteria filter saat ini.
            </div>
        @endforelse
    </div>

    <!-- Master Table Kehadiran & Jurnal Harian Seluruh Guru -->
    <div class="table-panel-card">
        <div class="table-panel-header">
            <h3 class="table-panel-title">
                <i class="fa-solid fa-list-check" style="color: #384972;"></i> Rekapitulasi Presensi & Pengisian Jurnal Guru
            </h3>

            <form method="GET" action="{{ route('kepala-sekolah.kehadiran-guru') }}" style="display: flex; gap: 8px; align-items: center;">
                <span style="font-size: 12.5px; font-weight: 700; color: #475569;">Tanggal:</span>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="filter-input" style="height: 34px; padding: 4px 10px;">
                <button type="submit" class="btn-filter" style="height: 34px; padding: 0 12px;">
                    Lihat
                </button>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th style="width: 140px;">NIP</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th style="width: 180px;">Status Mengajar</th>
                        <th>Keterangan Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruList as $index => $g)
                        @php
                            $jurnal = $jurnalHariIni->get($g->id_guru);
                            $izin = $izinHariIni->get($g->id_guru);
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $index + 1 }}</td>
                            <td style="color: #475569; font-weight: 600;">{{ $g->nip ?? '-' }}</td>
                            <td style="font-weight: 800; color: #0f172a;">{{ $g->nama_guru }}</td>
                            <td style="color: #334155;">{{ $g->mapel->nama_mapel ?? '-' }}</td>
                            <td>
                                @if($jurnal)
                                    <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-check"></i> Sudah Mengisi Jurnal
                                    </span>
                                @elseif($izin)
                                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-user-xmark"></i> Izin ({{ $izin->kategori_izin ?? 'Izin' }})
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-clock"></i> Belum Ada Jurnal Today
                                    </span>
                                @endif
                            </td>
                            <td style="color: #64748b; font-size: 12px;">
                                @if($jurnal)
                                    <strong>Kelas:</strong> {{ $jurnal->kelas->nama_kelas ?? '-' }} • <strong>Materi:</strong> {{ $jurnal->materi }}
                                @elseif($izin)
                                    <strong>Alasan:</strong> {{ $izin->alasan }}
                                @else
                                    Terjadwal Mengajar
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: #64748b;">Belum ada data guru terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Reject Modal Popup -->
<div id="rejectModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #991b1b;">
                Tolak Permohonan Izin Guru
            </h3>
            <button type="button" onclick="closeRejectModal()" style="background: #e2e8f0; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p id="rejectModalText" style="margin: 0; font-size: 13.5px; color: #1e293b; font-weight: 600;"></p>
                <div>
                    <label style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase;">Catatan / Alasan Penolakan</label>
                    <textarea name="catatan" rows="3" placeholder="Masukkan alasan penolakan izin guru ini..." style="width: 100%; margin-top: 6px; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px; outline: none;" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeRejectModal()" style="background: #e2e8f0; color: #334155; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer;">Batal</button>
                <button type="submit" style="background: #dc2626; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">Tolak Izin</button>
            </div>
        </form>
    </div>
</div>

<!-- Foto Surat Modal Popup -->
<div id="fotoModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="fotoModalTitle" style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">
                Bukti Surat Izin Guru
            </h3>
            <button type="button" onclick="closeFotoModal()" style="background: #e2e8f0; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <p id="fotoModalAlasan" style="font-size: 13px; color: #475569; font-weight: 600; margin: 0 0 10px 0;"></p>
            <a id="fotoModalLink" href="#" target="_blank" title="Klik untuk memperbesar gambar di tab baru">
                <img id="fotoModalImg" src="" alt="Bukti Surat Izin" style="max-width: 100%; max-height: 380px; border-radius: 10px; object-fit: contain; border: 1px solid #cbd5e1; background: #f8fafc; cursor: pointer;">
            </a>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 6px;">
                <i class="fa-solid fa-circle-info"></i> Klik gambar untuk membuka ukuran penuh di tab baru.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeFotoModal()" style="background: #384972; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openRejectModal(id, nama) {
        document.getElementById('rejectModalText').innerText = 'Apakah Anda yakin ingin menolak permohonan izin dari "' + nama + '"?';
        document.getElementById('rejectForm').action = "{{ url('/kepala-sekolah/izin') }}/" + id + "/reject";
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function showFotoModal(nama, imgUrl, alasan) {
        document.getElementById('fotoModalTitle').innerText = 'Bukti Surat Izin - ' + nama;
        document.getElementById('fotoModalAlasan').innerText = 'Alasan: ' + alasan;
        document.getElementById('fotoModalImg').src = imgUrl;
        document.getElementById('fotoModalLink').href = imgUrl;
        document.getElementById('fotoModal').style.display = 'flex';
    }

    function closeFotoModal() {
        document.getElementById('fotoModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('rejectModal')) {
            closeRejectModal();
        }
        if (event.target == document.getElementById('fotoModal')) {
            closeFotoModal();
        }
    }
</script>
@endsection
BLADE;

file_put_contents('c:/laragon/www/web-jurnal-kelas/resources/views/kepala_sekolah/kehadiran_guru.blade.php', $bladeContent);
echo "Updated kepala_sekolah/kehadiran_guru.blade.php successfully!\n";
