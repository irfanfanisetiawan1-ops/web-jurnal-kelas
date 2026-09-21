<?php

$bladeContent = <<<'BLADE'
@extends('layouts.kepala_sekolah')

@section('title', 'Guru Izin Tidak Hadir — Jurnal SMEA')

@section('styles')
<style>
    /* Container Page Fitting - Prevent Horizontal Page Overflow */
    .guru-izin-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Page Header Box */
    .page-header-box {
        background: #ffffff;
        padding: 18px 22px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-header-sub {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
    }

    /* Filter Toolbar Card */
    .filter-card {
        background: #ffffff;
        padding: 14px 18px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-input {
        padding: 7px 11px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        background: #ffffff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        box-sizing: border-box;
        height: 36px;
    }

    .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.12);
    }

    .filter-search-box {
        flex: 1.8 1 180px;
        min-width: 150px;
        position: relative;
    }

    .filter-search-box i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-search-box input {
        width: 100%;
        padding-left: 32px;
    }

    .filter-select {
        flex: 1 1 125px;
        min-width: 115px;
        cursor: pointer;
    }

    .filter-date {
        flex: 1 1 120px;
        min-width: 110px;
    }

    .filter-actions-group {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .btn-filter {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 0 14px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-filter:hover {
        background: #233152;
        color: #ffffff;
    }

    .btn-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 0 12px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-trash {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 0 13px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-trash:hover {
        background: #fecaca;
        color: #7f1d1d;
    }

    .btn-bulk-delete {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 0 13px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        opacity: 0.45;
        pointer-events: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-bulk-delete.active {
        opacity: 1;
        pointer-events: auto;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }

    .btn-bulk-delete.active:hover {
        background: #dc2626;
    }

    /* Table Container & Table Styling */
    .table-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-sizing: border-box;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
        table-layout: auto;
    }

    .custom-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #cbd5e1;
        color: #475569;
    }

    .custom-table th {
        padding: 11px 12px;
        font-weight: 800;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    .btn-action-detail {
        background: #e0f2fe;
        color: #0369a1;
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 11.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        white-space: nowrap;
    }

    .btn-action-detail:hover {
        background: #bae6fd;
        color: #0284c7;
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #991b1b;
        border: none;
        padding: 5px 8px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 11.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        transition: all 0.15s ease;
        white-space: nowrap;
    }

    .btn-action-delete:hover {
        background: #fecaca;
        color: #7f1d1d;
    }

    /* Modal Overlay & Styling */
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
        max-width: 650px;
        max-height: 90vh;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        border: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97); }
        to { opacity: 1; transform: scale(1); }
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

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .detail-label {
        font-size: 10.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 3px;
    }

    .detail-val {
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
    }

    /* Custom Scrollbar for Table */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="guru-izin-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600; font-size: 12.5px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 10px; font-weight: 600; font-size: 12.5px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header Banner -->
    <div class="page-header-box">
        <div>
            <h1 class="page-header-title">Guru Izin Tidak Hadir</h1>
            <div class="page-header-sub">
                {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }} • Monitoring Rekap & Bukti Izin Guru
            </div>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Tempat Sampah ({{ $trashCount ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <div class="filter-card">
        <form method="GET" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="filter-grid">
            
            <!-- Cari Nama / NIP / Alasan -->
            <div class="filter-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari Guru, NIP, Alasan, Materi..." class="filter-input">
            </div>

            <!-- Dropdown Kategori -->
            <div class="filter-select">
                <select name="kategori" class="filter-input" style="width: 100%;">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Sakit" {{ ($kategori ?? '') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ ($kategori ?? '') == 'Izin' ? 'selected' : '' }}>Izin Kepentingan</option>
                    <option value="Cuti" {{ ($kategori ?? '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Dinas Luar" {{ ($kategori ?? '') == 'Dinas Luar' ? 'selected' : '' }}>Tugas Dinas Luar</option>
                </select>
            </div>

            <!-- Dropdown Status Berlaku -->
            <div class="filter-select">
                <select name="status_berlaku" class="filter-input" style="width: 100%;">
                    <option value="">-- Status Berlaku --</option>
                    <option value="Berlangsung" {{ ($statusBerlaku ?? '') == 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="Selesai" {{ ($statusBerlaku ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Mendatang" {{ ($statusBerlaku ?? '') == 'Mendatang' ? 'selected' : '' }}>Mendatang</option>
                </select>
            </div>

            <!-- Filter Date -->
            <div class="filter-date">
                <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-input" style="width: 100%;">
            </div>

            <!-- Dropdown Status Guru Pengganti -->
            <div class="filter-select">
                <select name="status_pengganti" class="filter-input" style="width: 100%;">
                    <option value="">-- Status Pengganti --</option>
                    <option value="ditugaskan" {{ ($statusPengganti ?? '') == 'ditugaskan' ? 'selected' : '' }}>Sudah Ditugaskan</option>
                    <option value="belum" {{ ($statusPengganti ?? '') == 'belum' ? 'selected' : '' }}>Belum Ditugaskan</option>
                </select>
            </div>

            <!-- Action Buttons Group -->
            <div class="filter-actions-group">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="btn-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <!-- Tombol Hapus Terpilih -->
                <button type="button" id="btnBulkDelete" class="btn-bulk-delete" onclick="confirmBulkDelete()">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>

        </form>
    </div>

    <!-- Data Table Container -->
    <div class="table-card">
        <form id="bulkDeleteForm" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.bulk-delete') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center; padding-left: 14px;">
                                <input type="checkbox" id="selectAllIzin" style="cursor: pointer; width: 15px; height: 15px; accent-color: #ef4444;">
                            </th>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th style="min-width: 180px;">GURU TIDAK HADIR</th>
                            <th style="min-width: 140px;">TANGGAL & KATEGORI</th>
                            <th style="min-width: 170px;">ALASAN & TITIPAN MATERI</th>
                            <th style="min-width: 140px;">STATUS PERSETUJUAN</th>
                            <th style="min-width: 130px;">PENUGASAN PENGGANTI</th>
                            <th style="min-width: 110px;">STATUS BERLAKU</th>
                            <th style="text-align: center; width: 120px; padding-right: 14px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $index => $izin)
                            @php
                                $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                $nipGuru = $izin->guru->nip ?? '-';
                                $mapelGuru = $izin->guru->mapel->nama_mapel ?? 'Semua Mapel';
                                $initials = strtoupper(substr($namaGuru, 0, 2));

                                $tglMulai = $izin->tanggal_mulai ? \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') : '-';
                                $tglSelesai = $izin->tanggal_selesai ? \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-m-Y') : $tglMulai;
                                $durasi = $izin->durasi_hari ?? 1;

                                $kategori = $izin->kategori_izin ?? 'Izin';
                                $katLower = strtolower($kategori);
                                if (str_contains($katLower, 'sakit')) {
                                    $katBg = '#fee2e2'; $katColor = '#991b1b'; $katIcon = 'fa-bed-pulse';
                                } elseif (str_contains($katLower, 'cuti')) {
                                    $katBg = '#ede9fe'; $katColor = '#6b21a8'; $katIcon = 'fa-calendar-day';
                                } elseif (str_contains($katLower, 'dinas')) {
                                    $katBg = '#fef3c7'; $katColor = '#b45309'; $katIcon = 'fa-briefcase';
                                } else {
                                    $katBg = '#e0f2fe'; $katColor = '#0369a1'; $katIcon = 'fa-envelope-open-text';
                                }

                                $stWaka = $izin->status_waka ?? 'pending';
                                $stKepsek = $izin->status_kepsek ?? 'pending';

                                $hasTitipan = !empty($izin->tugas_dititipkan) || !empty($izin->materi_dititipkan) || !empty($izin->file_tugas);
                                $substituteName = $izin->nama_guru_pengganti ?? ($izin->guruPiket->nama_guru ?? null);
                                $hasSubstitute = !empty($izin->id_guru_pengganti) || !empty($izin->id_guru_piket) || !empty($substituteName);

                                // Status Berlaku Calculation
                                $todayStr = \Carbon\Carbon::today('Asia/Jakarta')->toDateString();
                                $startStr = $izin->tanggal_mulai ? \Carbon\Carbon::parse($izin->tanggal_mulai)->toDateString() : $todayStr;
                                $endStr = $izin->tanggal_selesai ? \Carbon\Carbon::parse($izin->tanggal_selesai)->toDateString() : $startStr;

                                if ($todayStr >= $startStr && $todayStr <= $endStr) {
                                    $berlakuTeks = 'Berlangsung';
                                    $berlakuBg = '#dcfce7';
                                    $berlakuColor = '#15803d';
                                    $berlakuIcon = 'fa-rotate fa-spin';
                                } elseif ($todayStr > $endStr) {
                                    $berlakuTeks = 'Selesai';
                                    $berlakuBg = '#f1f5f9';
                                    $berlakuColor = '#475569';
                                    $berlakuIcon = 'fa-circle-check';
                                } else {
                                    $berlakuTeks = 'Mendatang';
                                    $berlakuBg = '#ede9fe';
                                    $berlakuColor = '#6b21a8';
                                    $berlakuIcon = 'fa-calendar-days';
                                }

                                $fotoSuratName = $izin->foto_surat;
                                $fileTugasName = $izin->file_tugas;

                                // Detail Payload (JSON Safe)
                                $detailPayload = [
                                    'id' => $izin->id_guru_izin,
                                    'nama' => $namaGuru,
                                    'nip' => $nipGuru,
                                    'mapel' => $mapelGuru,
                                    'kategori' => $kategori,
                                    'tgl_mulai' => $tglMulai,
                                    'tgl_selesai' => $tglSelesai,
                                    'durasi' => $durasi . ' Hari',
                                    'alasan' => $izin->alasan ?? '-',
                                    'materi' => $izin->materi_dititipkan ?? '-',
                                    'tugas' => $izin->tugas_dititipkan ?? '-',
                                    'file_tugas' => $fileTugasName ? asset('uploads/guru_izin_tugas/' . $fileTugasName) : null,
                                    'file_tugas_name' => $fileTugasName,
                                    'pengganti' => $hasSubstitute ? ($substituteName ?: 'Sudah Ditugaskan') : 'Belum Ada Pengganti',
                                    'has_pengganti' => $hasSubstitute,
                                    'status_waka' => $stWaka,
                                    'catatan_waka' => $izin->catatan_waka ?? '-',
                                    'status_kepsek' => $stKepsek,
                                    'catatan_kepsek' => $izin->catatan_kepsek ?? '-',
                                    'status_berlaku' => $berlakuTeks,
                                    'foto_surat' => $fotoSuratName ? asset('uploads/guru_izin/' . $fotoSuratName) : asset('uploads/guru_izin/1787625106_QJzh6X66.png'),
                                    'has_foto' => !empty($fotoSuratName)
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center; padding-left: 14px;">
                                    <input type="checkbox" name="ids[]" value="{{ $izin->id_guru_izin }}" class="check-izin" style="cursor: pointer; width: 15px; height: 15px; accent-color: #ef4444;" onchange="updateBulkDeleteState()">
                                </td>
                                <td style="font-weight: 700; color: #64748b; text-align: center;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 9px;">
                                        <div style="width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; color: #334155; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: #0f172a; font-size: 12.5px;">
                                                {{ $namaGuru }}
                                            </div>
                                            <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 1px;">
                                                NIP: {{ $nipGuru }} • <span style="color: #475569;">{{ $mapelGuru }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 12px;">
                                        {{ $tglMulai }} @if($tglSelesai !== $tglMulai) <span style="color: #64748b; font-weight: 500;">s/d</span> {{ $tglSelesai }} @endif
                                    </div>
                                    <div style="margin-top: 3px; display: flex; gap: 5px; align-items: center;">
                                        <span style="background: {{ $katBg }}; color: {{ $katColor }}; font-size: 10.5px; font-weight: 800; padding: 1.5px 7px; border-radius: 10px; display: inline-flex; align-items: center; gap: 3px;">
                                            <i class="fa-solid {{ $katIcon }}"></i> {{ $kategori }}
                                        </span>
                                        <span style="font-size: 10.5px; color: #64748b; font-weight: 700;">({{ $durasi }} Hari)</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b; font-size: 12px; line-height: 1.35; max-width: 220px;">
                                        {{ $izin->alasan }}
                                    </div>
                                    @if($hasTitipan)
                                        <div style="margin-top: 3px;">
                                            <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 10.5px; font-weight: 700; padding: 1.5px 7px; border-radius: 6px; display: inline-flex; align-items: center; gap: 3px;">
                                                <i class="fa-solid fa-file-signature"></i> Ada Titipan Materi / Tugas
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 3px;">
                                        <div>
                                            <span style="background: {{ $stWaka === 'approved' ? '#dcfce7' : ($stWaka === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stWaka === 'approved' ? '#15803d' : ($stWaka === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 3px;">
                                                <i class="fa-solid {{ $stWaka === 'approved' ? 'fa-circle-check' : ($stWaka === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Waka: {{ $stWaka === 'approved' ? 'Disetujui' : ($stWaka === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span style="background: {{ $stKepsek === 'approved' ? '#dcfce7' : ($stKepsek === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stKepsek === 'approved' ? '#15803d' : ($stKepsek === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 3px;">
                                                <i class="fa-solid {{ $stKepsek === 'approved' ? 'fa-circle-check' : ($stKepsek === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Kepsek: {{ $stKepsek === 'approved' ? 'Disetujui' : ($stKepsek === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($hasSubstitute)
                                        <div>
                                            <span style="background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                            </span>
                                            @if($substituteName)
                                                <div style="font-size: 11px; color: #475569; font-weight: 600; margin-top: 2px;">
                                                    {{ $substituteName }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span style="background: #fef3c7; color: #b45309; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Belum Ada Pengganti
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span style="background: {{ $berlakuBg }}; color: {{ $berlakuColor }}; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid {{ $berlakuIcon }}"></i> {{ $berlakuTeks }}
                                    </span>
                                </td>
                                <td style="text-align: center; padding-right: 14px;">
                                    <div style="display: flex; gap: 5px; justify-content: center; align-items: center;">
                                        <button type="button" class="btn-action-detail" onclick='openDetailModal(@json($detailPayload))'>
                                            <i class="fa-regular fa-eye"></i> Detail
                                        </button>

                                        <button type="button" class="btn-action-delete" title="Hapus ke tempat sampah" onclick="confirmSingleDelete({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 36px; color: #64748b; font-weight: 600;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                                    Tidak ada data guru izin tidak hadir yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</div>

<!-- Single Delete Form (Hidden) -->
<form id="singleDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Popup Detail Guru Izin -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-box">
        <!-- Header -->
        <div class="modal-header">
            <div>
                <h3 id="modalDetailTitle" style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">
                    Detail Guru Izin Tidak Hadir
                </h3>
                <div id="modalDetailSub" style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    NIP: - • Mapel: -
                </div>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: #e2e8f0; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #475569; cursor: pointer;">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div class="modal-body">
            
            <!-- Grid Informasi Dasar -->
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Kategori Izin</div>
                    <div id="modalDetailKategori" class="detail-val">-</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Rentang Tanggal & Durasi</div>
                    <div id="modalDetailTanggal" class="detail-val">-</div>
                </div>
            </div>

            <!-- Alasan Izin -->
            <div class="detail-box">
                <div class="detail-label">Alasan Ketidakhadiran</div>
                <div id="modalDetailAlasan" style="font-size: 13.5px; font-weight: 600; color: #1e293b; line-height: 1.45; margin-top: 3px;">-</div>
            </div>

            <!-- Status Penugasan & Pengganti -->
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Guru Pengganti</div>
                    <div id="modalDetailPengganti" class="detail-val">-</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Status Berlaku</div>
                    <div id="modalDetailBerlaku" class="detail-val">-</div>
                </div>
            </div>

            <!-- Titipan Materi & Tugas -->
            <div id="modalTitipanSection" class="detail-box" style="background: #f0fdf4; border-color: #bbf7d0;">
                <div class="detail-label" style="color: #166534;">Titipan Materi & Penugasan Siswa</div>
                <div style="font-size: 12.5px; color: #1e293b; margin-top: 3px;">
                    <strong>Materi:</strong> <span id="modalDetailMateri">-</span>
                </div>
                <div style="font-size: 12.5px; color: #1e293b; margin-top: 3px;">
                    <strong>Tugas:</strong> <span id="modalDetailTugas">-</span>
                </div>
                <div id="modalDownloadFileBox" style="margin-top: 8px; display: none;">
                    <a id="modalDownloadFileLink" href="#" target="_blank" style="background: #16a34a; color: #ffffff; padding: 5px 11px; border-radius: 6px; font-size: 11.5px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-download"></i> Unduh Berkas Tugas (<span id="modalDetailFileName"></span>)
                    </a>
                </div>
            </div>

            <!-- Persetujuan Waka & Kepsek -->
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Persetujuan Waka Kurikulum</div>
                    <div id="modalDetailWaka" class="detail-val">-</div>
                    <div id="modalCatatanWaka" style="font-size: 11.5px; color: #64748b; margin-top: 3px;"></div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Persetujuan Kepala Sekolah</div>
                    <div id="modalDetailKepsek" class="detail-val">-</div>
                    <div id="modalCatatanKepsek" style="font-size: 11.5px; color: #64748b; margin-top: 3px;"></div>
                </div>
            </div>

            <!-- Foto Bukti / Surat Izin -->
            <div style="text-align: center; background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div class="detail-label" style="margin-bottom: 6px; text-align: left;">
                    <i class="fa-regular fa-image"></i> Foto Bukti / Surat Keterangan Izin
                </div>
                <div style="position: relative; display: inline-block; max-width: 100%;">
                    <a id="modalDetailImgLink" href="#" target="_blank" title="Klik untuk memperbesar / membuka foto di tab baru">
                        <img id="modalDetailImg" src="" alt="Bukti Surat Izin" style="max-width: 100%; max-height: 280px; border-radius: 8px; object-fit: contain; border: 1px solid #cbd5e1; background: #ffffff; cursor: pointer; transition: transform 0.2s;">
                    </a>
                </div>
                <div style="font-size: 11px; color: #64748b; margin-top: 5px;">
                    <i class="fa-solid fa-circle-info"></i> Klik foto untuk membuka gambar ukuran penuh di tab baru.
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button type="button" onclick="closeDetailModal()" style="background: #384972; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; font-family: inherit;">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<script>
    // Master Select All logic
    const selectAllCheckbox = document.getElementById('selectAllIzin');
    const itemCheckboxes = document.querySelectorAll('.check-izin');
    const btnBulkDelete = document.getElementById('btnBulkDelete');
    const selectedCountSpan = document.getElementById('selectedCount');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateBulkDeleteState();
        });
    }

    function updateBulkDeleteState() {
        const checkedCount = document.querySelectorAll('.check-izin:checked').length;
        if (selectedCountSpan) selectedCountSpan.innerText = checkedCount;

        if (checkedCount > 0) {
            btnBulkDelete.classList.add('active');
        } else {
            btnBulkDelete.classList.remove('active');
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (checkedCount === itemCheckboxes.length && itemCheckboxes.length > 0);
        }
    }

    function confirmBulkDelete() {
        const checkedCount = document.querySelectorAll('.check-izin:checked').length;
        if (checkedCount === 0) {
            alert('Silakan pilih minimal 1 data guru izin terlebih dahulu.');
            return;
        }

        if (confirm(`Apakah Anda yakin ingin memindahkan ${checkedCount} data guru izin terpilih ke tempat sampah?`)) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    function confirmSingleDelete(id, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus izin untuk "${nama}" ke tempat sampah?`)) {
            const form = document.getElementById('singleDeleteForm');
            form.action = "{{ url('/kepala-sekolah/guru-izin-tidak-hadir') }}/" + id;
            form.submit();
        }
    }

    function openDetailModal(data) {
        document.getElementById('modalDetailTitle').innerText = 'Detail Guru Izin - ' + data.nama;
        document.getElementById('modalDetailSub').innerText = 'NIP: ' + data.nip + ' • Mapel: ' + data.mapel;
        document.getElementById('modalDetailKategori').innerText = data.kategori;
        document.getElementById('modalDetailTanggal').innerText = data.tgl_mulai + (data.tgl_selesai !== data.tgl_mulai ? ' s/d ' + data.tgl_selesai : '') + ' (' + data.durasi + ')';
        document.getElementById('modalDetailAlasan').innerText = data.alasan;
        document.getElementById('modalDetailPengganti').innerText = data.pengganti;
        document.getElementById('modalDetailBerlaku').innerText = data.status_berlaku;

        // Titipan materi / tugas
        document.getElementById('modalDetailMateri').innerText = data.materi;
        document.getElementById('modalDetailTugas').innerText = data.tugas;

        const downloadBox = document.getElementById('modalDownloadFileBox');
        if (data.file_tugas) {
            downloadBox.style.display = 'block';
            document.getElementById('modalDownloadFileLink').href = data.file_tugas;
            document.getElementById('modalDetailFileName').innerText = data.file_tugas_name || 'Download File';
        } else {
            downloadBox.style.display = 'none';
        }

        // Persetujuan
        document.getElementById('modalDetailWaka').innerText = data.status_waka === 'approved' ? 'Disetujui' : (data.status_waka === 'rejected' ? 'Ditolak' : 'Menunggu');
        document.getElementById('modalCatatanWaka').innerText = data.catatan_waka !== '-' ? 'Catatan: ' + data.catatan_waka : '';

        document.getElementById('modalDetailKepsek').innerText = data.status_kepsek === 'approved' ? 'Disetujui' : (data.status_kepsek === 'rejected' ? 'Ditolak' : 'Menunggu');
        document.getElementById('modalCatatanKepsek').innerText = data.catatan_kepsek !== '-' ? 'Catatan: ' + data.catatan_kepsek : '';

        // Foto Bukti
        const imgEl = document.getElementById('modalDetailImg');
        const imgLink = document.getElementById('modalDetailImgLink');
        imgEl.src = data.foto_surat;
        imgLink.href = data.foto_surat;

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
BLADE;

file_put_contents('c:/laragon/www/web-jurnal-kelas/resources/views/kepala_sekolah/guru_izin_tidak_hadir.blade.php', $bladeContent);
echo "Updated kepala_sekolah/guru_izin_tidak_hadir.blade.php with responsive fitting successfully!\n";
