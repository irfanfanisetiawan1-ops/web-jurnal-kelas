<?php

$guruIzinBlade = <<<'BLADE'
@extends('layouts.kepala_sekolah')

@section('title', 'Guru Izin Tidak Hadir — Jurnal SMEA')

@section('styles')
<style>
    .guru-izin-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    .page-header-box {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .page-header-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .page-header-sub {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }

    .filter-card {
        background: #ffffff;
        padding: 18px 20px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .filter-input {
        padding: 9px 13px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        background: #ffffff;
        transition: border-color 0.2s;
    }

    .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-filter {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter:hover {
        background: #233152;
        color: #ffffff;
    }

    .btn-reset {
        background: #e2e8f0;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 9px 15px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-reset:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .btn-trash {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 15px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-trash:hover {
        background: #fecaca;
        color: #7f1d1d;
    }

    .btn-bulk-delete {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        opacity: 0.5;
        pointer-events: none;
    }

    .btn-bulk-delete.active {
        opacity: 1;
        pointer-events: auto;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-bulk-delete.active:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .custom-table thead tr {
        background: #f8fafc;
        border-bottom: 1.5px solid #cbd5e1;
        color: #475569;
    }

    .custom-table th {
        padding: 14px 16px;
        font-weight: 800;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 15px 16px;
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
        padding: 6px 13px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-action-detail:hover {
        background: #bae6fd;
        color: #0284c7;
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #991b1b;
        border: none;
        padding: 6px 13px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-action-delete:hover {
        background: #fecaca;
        color: #7f1d1d;
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
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-box {
        background: #ffffff;
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        border-radius: 18px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        border: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    .modal-body {
        padding: 22px 24px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .detail-label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .detail-val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
</style>
@endsection

@section('content')
<div class="guru-izin-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 14px 18px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px 18px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 18px;"></i>
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
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Tempat Sampah ({{ $trashCount ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <div class="filter-card">
        <form method="GET" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="filter-grid">
            
            <!-- Cari Nama / NIP / Alasan -->
            <div style="flex: 2 1 200px; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari Guru, NIP, Alasan, Materi..." class="filter-input" style="width: 100%; padding-left: 36px;">
            </div>

            <!-- Dropdown Kategori -->
            <div style="flex: 1 1 140px;">
                <select name="kategori" class="filter-input" style="width: 100%;">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Sakit" {{ ($kategori ?? '') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ ($kategori ?? '') == 'Izin' ? 'selected' : '' }}>Izin Kepentingan</option>
                    <option value="Cuti" {{ ($kategori ?? '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Dinas Luar" {{ ($kategori ?? '') == 'Dinas Luar' ? 'selected' : '' }}>Tugas Dinas Luar</option>
                </select>
            </div>

            <!-- Dropdown Status Berlaku -->
            <div style="flex: 1 1 150px;">
                <select name="status_berlaku" class="filter-input" style="width: 100%;">
                    <option value="">-- Semua Status Berlaku --</option>
                    <option value="Berlangsung" {{ ($statusBerlaku ?? '') == 'Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="Selesai" {{ ($statusBerlaku ?? '') == 'Selesai' ? 'selected' : '' }}>Sudah Selesai</option>
                    <option value="Mendatang" {{ ($statusBerlaku ?? '') == 'Mendatang' ? 'selected' : '' }}>Waktu Mendatang</option>
                </select>
            </div>

            <!-- Filter Date -->
            <div style="flex: 1 1 135px;">
                <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-input" style="width: 100%;">
            </div>

            <!-- Dropdown Status Guru Pengganti -->
            <div style="flex: 1 1 160px;">
                <select name="status_pengganti" class="filter-input" style="width: 100%;">
                    <option value="">-- Status Pengganti --</option>
                    <option value="ditugaskan" {{ ($statusPengganti ?? '') == 'ditugaskan' ? 'selected' : '' }}>Sudah Ditugaskan</option>
                    <option value="belum" {{ ($statusPengganti ?? '') == 'belum' ? 'selected' : '' }}>Belum Ditugaskan</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
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
                            <th style="width: 38px; text-align: center;">
                                <input type="checkbox" id="selectAllIzin" style="cursor: pointer; width: 16px; height: 16px; accent-color: #ef4444;">
                            </th>
                            <th style="width: 45px;">NO</th>
                            <th>GURU TIDAK HADIR</th>
                            <th>TANGGAL & KATEGORI</th>
                            <th>ALASAN & TITIPAN MATERI</th>
                            <th>STATUS PERSETUJUAN</th>
                            <th>PENUGASAN PENGGANTI</th>
                            <th>STATUS BERLAKU</th>
                            <th style="text-align: center; width: 150px;">AKSI</th>
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
                                $substituteName = $izin->nama_guru_pengganti ?? ($izin->guruPenggantiUser->nama_lengkap ?? null);
                                $hasSubstitute = !empty($izin->id_guru_pengganti) || !empty($substituteName);

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
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $izin->id_guru_izin }}" class="check-izin" style="cursor: pointer; width: 16px; height: 16px; accent-color: #ef4444;" onchange="updateBulkDeleteState()">
                                </td>
                                <td style="font-weight: 700; color: #64748b;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 11px;">
                                        <div style="width: 38px; height: 38px; border-radius: 50%; background: #e2e8f0; color: #334155; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                                {{ $namaGuru }}
                                            </div>
                                            <div style="font-size: 11.5px; color: #64748b; font-weight: 600; margin-top: 1px;">
                                                NIP: {{ $nipGuru }} • <span style="color: #475569;">{{ $mapelGuru }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 13px;">
                                        {{ $tglMulai }} @if($tglSelesai !== $tglMulai) <span style="color: #64748b; font-weight: 500;">s/d</span> {{ $tglSelesai }} @endif
                                    </div>
                                    <div style="margin-top: 4px; display: flex; gap: 6px; align-items: center;">
                                        <span style="background: {{ $katBg }}; color: {{ $katColor }}; font-size: 11px; font-weight: 800; padding: 2px 9px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid {{ $katIcon }}"></i> {{ $kategori }}
                                        </span>
                                        <span style="font-size: 11px; color: #64748b; font-weight: 700;">({{ $durasi }} Hari)</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b; font-size: 13px; max-width: 260px; line-height: 1.4;">
                                        {{ $izin->alasan }}
                                    </div>
                                    @if($hasTitipan)
                                        <div style="margin-top: 4px;">
                                            <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 8px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-file-signature"></i> Ada Titipan Materi / Tugas
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <div>
                                            <span style="background: {{ $stWaka === 'approved' ? '#dcfce7' : ($stWaka === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stWaka === 'approved' ? '#15803d' : ($stWaka === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid {{ $stWaka === 'approved' ? 'fa-circle-check' : ($stWaka === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Waka: {{ $stWaka === 'approved' ? 'Disetujui' : ($stWaka === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span style="background: {{ $stKepsek === 'approved' ? '#dcfce7' : ($stKepsek === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stKepsek === 'approved' ? '#15803d' : ($stKepsek === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid {{ $stKepsek === 'approved' ? 'fa-circle-check' : ($stKepsek === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Kepsek: {{ $stKepsek === 'approved' ? 'Disetujui' : ($stKepsek === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($hasSubstitute)
                                        <div>
                                            <span style="background: #dcfce7; color: #166534; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                            </span>
                                            @if($substituteName)
                                                <div style="font-size: 11.5px; color: #475569; font-weight: 600; margin-top: 3px;">
                                                    {{ $substituteName }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span style="background: #fef3c7; color: #b45309; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Belum Ada Pengganti
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span style="background: {{ $berlakuBg }}; color: {{ $berlakuColor }}; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid {{ $berlakuIcon }}"></i> {{ $berlakuTeks }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <button type="button" class="btn-action-detail" onclick='openDetailModal(@json($detailPayload))'>
                                            <i class="fa-regular fa-eye"></i> Detail
                                        </button>

                                        <button type="button" class="btn-action-delete" onclick="confirmSingleDelete({{ $izin->id_guru_izin }}, '{{ addslashes($namaGuru) }}')">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 45px; color: #64748b; font-weight: 600;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
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
                <h3 id="modalDetailTitle" style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                    Detail Guru Izin Tidak Hadir
                </h3>
                <div id="modalDetailSub" style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    NIP: - • Mapel: -
                </div>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: #e2e8f0; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #475569; cursor: pointer;">
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
                <div id="modalDetailAlasan" style="font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.5; margin-top: 4px;">-</div>
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
                <div style="font-size: 13px; color: #1e293b; margin-top: 4px;">
                    <strong>Materi:</strong> <span id="modalDetailMateri">-</span>
                </div>
                <div style="font-size: 13px; color: #1e293b; margin-top: 4px;">
                    <strong>Tugas:</strong> <span id="modalDetailTugas">-</span>
                </div>
                <div id="modalDownloadFileBox" style="margin-top: 8px; display: none;">
                    <a id="modalDownloadFileLink" href="#" target="_blank" style="background: #16a34a; color: #ffffff; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-download"></i> Unduh Berkas Tugas (<span id="modalDetailFileName"></span>)
                    </a>
                </div>
            </div>

            <!-- Persetujuan Waka & Kepsek -->
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Persetujuan Waka Kurikulum</div>
                    <div id="modalDetailWaka" class="detail-val">-</div>
                    <div id="modalCatatanWaka" style="font-size: 12px; color: #64748b; margin-top: 4px;"></div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Persetujuan Kepala Sekolah</div>
                    <div id="modalDetailKepsek" class="detail-val">-</div>
                    <div id="modalCatatanKepsek" style="font-size: 12px; color: #64748b; margin-top: 4px;"></div>
                </div>
            </div>

            <!-- Foto Bukti / Surat Izin -->
            <div style="text-align: center; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div class="detail-label" style="margin-bottom: 8px; text-align: left;">
                    <i class="fa-regular fa-image"></i> Foto Bukti / Surat Keterangan Izin
                </div>
                <div style="position: relative; display: inline-block; max-width: 100%;">
                    <a id="modalDetailImgLink" href="#" target="_blank" title="Klik untuk memperbesar / membuka foto di tab baru">
                        <img id="modalDetailImg" src="" alt="Bukti Surat Izin" style="max-width: 100%; max-height: 320px; border-radius: 10px; object-fit: contain; border: 1px solid #cbd5e1; background: #ffffff; cursor: pointer; transition: transform 0.2s;">
                    </a>
                </div>
                <div style="font-size: 11.5px; color: #64748b; margin-top: 6px;">
                    <i class="fa-solid fa-circle-info"></i> Klik foto untuk melihat gambar ukuran penuh di tab baru.
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button type="button" onclick="closeDetailModal()" style="background: #384972; color: #ffffff; border: none; padding: 9px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">
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

file_put_contents('c:/laragon/www/web-jurnal-kelas/resources/views/kepala_sekolah/guru_izin_tidak_hadir.blade.php', $guruIzinBlade);
echo "Updated kepala_sekolah/guru_izin_tidak_hadir.blade.php successfully!\n";

$trashBlade = <<<'BLADE'
@extends('layouts.kepala_sekolah')

@section('title', 'Tempat Sampah Guru Izin — Jurnal SMEA')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    .page-header-box {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border-left: 5px solid #ef4444;
        border-top: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .page-header-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-sub {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }

    .btn-back {
        background: #e2e8f0;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-back:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .btn-empty-trash {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-empty-trash:hover {
        background: #fca5a5;
        color: #7f1d1d;
    }

    .btn-batch-restore {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        opacity: 0.5;
        pointer-events: none;
    }

    .btn-batch-restore.active {
        opacity: 1;
        pointer-events: auto;
        box-shadow: 0 4px 12px rgba(22, 101, 52, 0.15);
    }

    .table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .custom-table thead tr {
        background: #f8fafc;
        border-bottom: 1.5px solid #cbd5e1;
        color: #475569;
    }

    .custom-table th {
        padding: 14px 16px;
        font-weight: 800;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .custom-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .btn-restore {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-restore:hover { background: #bbf7d0; color: #14532d; }

    .btn-force {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-force:hover { background: #fca5a5; color: #7f1d1d; }
</style>
@endsection

@section('content')
<div class="trash-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 14px 18px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px 18px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="page-header-box">
        <div>
            <h1 class="page-header-title">
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Tempat Sampah Guru Izin
            </h1>
            <div class="page-header-sub">
                Kelola data izin guru yang telah dihapus. Anda dapat memulihkan kembali atau menghapusnya secara permanen.
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Utama
            </a>

            @if($guruIzinList->isNotEmpty())
                <button type="button" id="btnBatchRestore" class="btn-batch-restore" onclick="confirmBatchRestore()">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih (<span id="selectedTrashCount">0</span>)
                </button>

                <form action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh tempat sampah secara permanen? Data tidak dapat dikembalikan lagi.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-empty-trash">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="table-card">
        <form id="batchRestoreForm" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.batch-restore') }}" method="POST">
            @csrf
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 38px; text-align: center;">
                                <input type="checkbox" id="selectAllTrash" style="cursor: pointer; width: 16px; height: 16px; accent-color: #16a34a;">
                            </th>
                            <th style="width: 45px;">NO</th>
                            <th>GURU</th>
                            <th>TANGGAL & KATEGORI</th>
                            <th>ALASAN</th>
                            <th>DIHAPUS PADA</th>
                            <th style="text-align: center; width: 220px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $index => $item)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id_guru_izin }}" class="check-trash" style="cursor: pointer; width: 16px; height: 16px; accent-color: #16a34a;" onchange="updateTrashSelectState()">
                                </td>
                                <td style="font-weight: 700; color: #64748b;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <strong>{{ $item->guru->nama_guru ?? 'Guru' }}</strong>
                                    <div style="font-size: 11.5px; color: #64748b;">NIP: {{ $item->guru->nip ?? '-' }}</div>
                                </td>
                                <td>
                                    <div>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') : '-' }} s/d {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}</div>
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $item->kategori_izin ?? 'Izin' }} ({{ $item->durasi_hari ?? 1 }} Hari)</div>
                                </td>
                                <td>
                                    <div style="font-size: 12.5px; color: #334155;">{{ $item->alasan }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 12.5px; font-weight: 600; color: #64748b;">
                                        {{ $item->deleted_at ? $item->deleted_at->format('d-m-Y H:i') : '-' }}
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <button type="button" class="btn-restore" onclick="restoreSingle({{ $item->id_guru_izin }})">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>

                                        <button type="button" class="btn-force" onclick="forceDeleteSingle({{ $item->id_guru_izin }}, '{{ addslashes($item->guru->nama_guru ?? 'Guru') }}')">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 45px; color: #94a3b8;">
                                    <i class="fa-solid fa-trash-arrow-up" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                    Tempat sampah kosong. Tidak ada data guru izin yang dihapus sementara.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</div>

<!-- Single Action Forms (Hidden) -->
<form id="singleRestoreForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="singleForceDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    const selectAllTrash = document.getElementById('selectAllTrash');
    const trashCheckboxes = document.querySelectorAll('.check-trash');
    const btnBatchRestore = document.getElementById('btnBatchRestore');
    const selectedTrashCount = document.getElementById('selectedTrashCount');

    if (selectAllTrash) {
        selectAllTrash.addEventListener('change', function() {
            trashCheckboxes.forEach(cb => {
                cb.checked = selectAllTrash.checked;
            });
            updateTrashSelectState();
        });
    }

    function updateTrashSelectState() {
        const checkedCount = document.querySelectorAll('.check-trash:checked').length;
        if (selectedTrashCount) selectedTrashCount.innerText = checkedCount;

        if (btnBatchRestore) {
            if (checkedCount > 0) {
                btnBatchRestore.classList.add('active');
            } else {
                btnBatchRestore.classList.remove('active');
            }
        }

        if (selectAllTrash) {
            selectAllTrash.checked = (checkedCount === trashCheckboxes.length && trashCheckboxes.length > 0);
        }
    }

    function confirmBatchRestore() {
        const checkedCount = document.querySelectorAll('.check-trash:checked').length;
        if (checkedCount === 0) {
            alert('Silakan pilih minimal 1 data yang ingin dipulihkan.');
            return;
        }

        if (confirm(`Pulihkan ${checkedCount} data guru izin terpilih kembali ke daftar aktif?`)) {
            document.getElementById('batchRestoreForm').submit();
        }
    }

    function restoreSingle(id) {
        if (confirm('Pulihkan data guru izin ini?')) {
            const form = document.getElementById('singleRestoreForm');
            form.action = "{{ url('/kepala-sekolah/guru-izin-tidak-hadir') }}/" + id + "/restore";
            form.submit();
        }
    }

    function forceDeleteSingle(id, nama) {
        if (confirm(`HAPUS PERMANEN izin guru "${nama}"? Tindakan ini tidak dapat dibatalkan.`)) {
            const form = document.getElementById('singleForceDeleteForm');
            form.action = "{{ url('/kepala-sekolah/guru-izin-tidak-hadir') }}/" + id + "/force";
            form.submit();
        }
    }
</script>
@endsection
BLADE;

file_put_contents('c:/laragon/www/web-jurnal-kelas/resources/views/kepala_sekolah/guru_izin_trash.blade.php', $trashBlade);
echo "Updated kepala_sekolah/guru_izin_trash.blade.php successfully!\n";
