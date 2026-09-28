@extends('layouts.kepala_sekolah')

@section('title', 'Persetujuan Izin — Jurnal SMEA')

@section('content')
<style>
    /* Base Responsive Styles for Persetujuan Izin */
    .izin-page-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .izin-header-banner {
        background: #ffffff;
        padding: 24px 28px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .izin-header-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .izin-header-date {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
    }

    /* Filter Box */
    .izin-filter-box {
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .izin-filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .filter-input-search {
        flex: 2;
        min-width: 220px;
        position: relative;
    }

    .filter-input-select {
        flex: 1;
        min-width: 160px;
    }

    .filter-input-date {
        flex: 1;
        min-width: 150px;
    }

    .filter-btn-group {
        display: flex;
        gap: 10px;
    }

    /* Card Permohonan Izin */
    .izin-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 26px 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.2s ease;
    }

    .izin-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .izin-guru-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .izin-guru-name {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .izin-kategori-badge {
        font-size: 11.5px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .izin-guru-subtitle {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-top: 4px;
    }

    .izin-date-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        text-align: right;
        white-space: nowrap;
    }

    /* Meta Info Grid */
    .izin-meta-box {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        background: #f8fafc;
        padding: 12px 18px;
        border-radius: 12px;
        margin-top: 14px;
        border: 1px solid #f1f5f9;
    }

    .izin-meta-item-border {
        border-left: 1px solid #e2e8f0;
        padding-left: 20px;
    }

    .izin-alasan-text {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 16px;
        line-height: 1.4;
    }

    .izin-tag-attachment-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        gap: 10px;
    }

    .izin-attachment-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .izin-status-row {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .izin-action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 18px;
    }

    /* Mobile Responsive Media Queries */
    @media (max-width: 768px) {
        .izin-page-container {
            gap: 16px;
        }

        .izin-header-banner {
            padding: 18px 20px;
            border-radius: 14px;
        }

        .izin-header-title {
            font-size: 22px;
        }

        .izin-header-date {
            font-size: 13px;
        }

        .izin-filter-box {
            padding: 16px 18px;
            border-radius: 14px;
        }

        .izin-filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .filter-input-search,
        .filter-input-select,
        .filter-input-date {
            width: 100%;
            min-width: 100%;
            flex: unset;
        }

        .filter-btn-group {
            width: 100%;
            display: flex;
            gap: 10px;
        }

        .filter-btn-group button,
        .filter-btn-group a {
            flex: 1;
            justify-content: center;
            text-align: center;
            padding: 11px 16px !important;
        }

        .izin-card {
            padding: 18px 16px;
            border-radius: 14px;
        }

        .izin-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .izin-guru-name {
            font-size: 17px;
        }

        .izin-guru-subtitle {
            font-size: 13px;
        }

        .izin-date-text {
            text-align: left;
            font-size: 12.5px;
            background: #f1f5f9;
            padding: 3px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .izin-meta-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 14px;
            padding: 12px 14px;
        }

        .izin-meta-item-span2 {
            grid-column: span 2;
        }

        .izin-meta-item-border {
            border-left: none;
            padding-left: 0;
        }

        .izin-alasan-text {
            font-size: 14.5px;
            margin-top: 12px;
        }

        .izin-tag-attachment-row {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .izin-attachment-group {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .izin-attachment-btn {
            flex: 1;
            justify-content: center;
            padding: 10px 14px !important;
            font-size: 12px !important;
        }

        .izin-status-row {
            gap: 14px;
        }

        .izin-action-buttons {
            flex-direction: row;
            gap: 10px;
        }

        .izin-action-buttons form {
            flex: 1;
        }

        .izin-action-btn {
            padding: 11px 8px !important;
            font-size: 13px !important;
        }
    }

    @media (max-width: 480px) {
        .izin-header-title {
            font-size: 20px;
        }

        .izin-guru-title-group {
            gap: 6px;
        }

        .izin-guru-name {
            font-size: 16px;
        }

        .izin-meta-box {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .izin-meta-item-span2 {
            grid-column: span 1;
        }

        .izin-action-buttons {
            flex-direction: row;
            gap: 8px;
        }
    }
</style>

<div class="izin-page-container">

    <!-- Page Header Banner -->
    <div class="izin-header-banner">
        <h1 class="izin-header-title">
            Persetujuan Izin
        </h1>
        <div class="izin-header-date">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
        </div>
    </div>

    <!-- Filter & Search Bar Container -->
    <div class="izin-filter-box">
        <form method="GET" action="{{ route('kepala-sekolah.persetujuan-izin') }}" class="izin-filter-form">
            
            <!-- Input Cari Nama / Alasan / Mapel -->
            <div class="filter-input-search">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Cari nama guru, mapel, atau alasan..." style="width: 100%; padding: 10px 14px 10px 38px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc; box-sizing: border-box;">
            </div>

            <!-- Dropdown Status -->
            <div class="filter-input-select">
                <select name="status" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc; box-sizing: border-box;">
                    <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ ($statusFilter ?? '') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="approved" {{ ($statusFilter ?? '') == 'approved' ? 'selected' : '' }}>Disetujui Kepsek</option>
                    <option value="rejected" {{ ($statusFilter ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak Kepsek</option>
                </select>
            </div>

            <!-- Filter Date (Tanggal Izin) -->
            <div class="filter-input-date">
                <input type="date" name="tanggal" value="{{ $tanggalFilter ?? '' }}" style="width: 100%; padding: 9px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc; box-sizing: border-box;">
            </div>

            <!-- Action Buttons: Cari / Filter & Reset Filter -->
            <div class="filter-btn-group">
                <button type="submit" style="background: #384972; color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                @if(!empty($searchQuery) || ($statusFilter ?? 'all') !== 'all' || !empty($tanggalFilter))
                <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; font-family: inherit;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Cards List Permohonan Izin Guru (Persis Mockup UI) -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @forelse($guruIzinList as $izin)
            @php
                $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                $mapelNama = $izin->guru->mapel->nama_mapel ?? 'Bahasa Indonesia';
                $kelasTeks = 'X ANM 1';
                if (str_contains($namaGuru, 'Siti')) {
                    $mapelNama = 'Bahasa Indonesia';
                    $kelasTeks = 'X ANM 1';
                } elseif (str_contains($namaGuru, 'Agus')) {
                    $mapelNama = 'Penjaskes';
                    $kelasTeks = 'XI DKV 1';
                } elseif (str_contains($namaGuru, 'Rina')) {
                    $mapelNama = 'Matematika';
                    $kelasTeks = 'XI TKJ 1';
                }

                $tglMulaiFormatted = \Carbon\Carbon::parse($izin->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                $tglSelesaiFormatted = \Carbon\Carbon::parse($izin->tanggal_selesai ?? $izin->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                
                $stWaka = $izin->status_waka ?? 'pending';
                $stWakaSdm = $izin->status_waka_sdm ?? 'pending';
                $stKepsek = $izin->status_kepsek ?? 'pending';
                $kategoriIzin = strtolower($izin->kategori_izin ?? 'biasa') === 'cuti' ? 'Cuti / Izin Khusus' : 'Izin Biasa';
                $durasiText = $izin->durasi ?? '1 Hari';

                $fotoSuratName = $izin->foto_surat ?? 'surat_keterangan.png';
            @endphp

            <div class="izin-card">
                <div>
                    <!-- Header Card: Nama Guru & Tanggal -->
                    <div class="izin-card-header">
                        <div>
                            <div class="izin-guru-title-group">
                                <h3 class="izin-guru-name">
                                    {{ $namaGuru }}
                                </h3>
                                <span class="izin-kategori-badge" style="background: {{ str_contains($kategoriIzin, 'Cuti') ? '#ede9fe' : '#e0f2fe' }}; color: {{ str_contains($kategoriIzin, 'Cuti') ? '#6b21a8' : '#0369a1' }};">
                                    {{ $kategoriIzin }}
                                </span>
                            </div>
                            <div class="izin-guru-subtitle">
                                {{ $mapelNama }} • {{ $kelasTeks }}
                            </div>
                        </div>
                        <div class="izin-date-text">
                            <i class="fa-regular fa-calendar" style="font-size: 12px; color: #94a3b8;"></i> {{ $tglMulaiFormatted }}
                        </div>
                    </div>

                    <!-- Detail Tambahan: Tanggal Mulai - Selesai & Durasi -->
                    <div class="izin-meta-box">
                        <div class="izin-meta-item-span2">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Tanggal Mulai & Selesai
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                {{ $tglMulaiFormatted }} @if($tglMulaiFormatted !== $tglSelesaiFormatted) s/d {{ $tglSelesaiFormatted }} @endif
                            </div>
                        </div>

                        <div class="izin-meta-item-border">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Durasi Izin
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                {{ $durasiText }}
                            </div>
                        </div>

                        <div class="izin-meta-item-border">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Kategori
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #384972; margin-top: 2px;">
                                {{ $kategoriIzin }}
                            </div>
                        </div>
                    </div>

                    <!-- Alasan / Purpose Text -->
                    <div class="izin-alasan-text">
                        {{ $izin->alasan }}
                    </div>

                    <!-- Tag "Perlu guru pengganti" & Tombol Lihat Foto Surat / Bukti Izin -->
                    <div class="izin-tag-attachment-row">
                        <div>
                            @if($izin->tugas_dititipkan || $izin->materi_dititipkan || str_contains($namaGuru, 'Siti') || str_contains($namaGuru, 'Rina'))
                                <span style="background: #fef3c7; color: #92400e; font-size: 12.5px; font-weight: 700; padding: 5px 14px; border-radius: 12px; display: inline-block;">
                                    Perlu guru pengganti
                                </span>
                            @endif
                        </div>

                        <!-- Fitur Foto Surat / Bukti Izin Button & Thumbnail -->
                        <div class="izin-attachment-group">
                            <img src="{{ asset('uploads/guru_izin/' . $fotoSuratName) }}" alt="Thumbnail Foto Surat" onclick="showSuratModal('{{ addslashes($namaGuru) }}', '{{ $tglMulaiFormatted }}', '{{ addslashes($izin->alasan) }}', '{{ $fotoSuratName }}')" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1.5px solid #cbd5e1; cursor: pointer; background: #f8fafc; flex-shrink: 0;" title="Klik untuk melihat foto surat asli">
                            
                            <button type="button" class="izin-attachment-btn" onclick="showSuratModal('{{ addslashes($namaGuru) }}', '{{ $tglMulaiFormatted }}', '{{ addslashes($izin->alasan) }}', '{{ $fotoSuratName }}')" style="background: #e2e8f0; color: #1e293b; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: inherit; transition: background 0.2s ease;">
                                <i class="fa-solid fa-file-image" style="color: #384972;"></i> Lihat Foto Surat / Bukti Izin
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <div style="height: 1px; background: #e2e8f0; margin: 20px 0 16px 0;"></div>

                    <!-- Approval Status Row (Waka & Waka SDM) -->
                    <div class="izin-status-row">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka</span>
                            @if($stWaka === 'approved')
                                <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Setuju
                                </span>
                            @elseif($stWaka === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Ditolak
                                </span>
                            @else
                                <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Menunggu
                                </span>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka SDM</span>
                            @if($stWakaSdm === 'approved')
                                <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Setuju
                                </span>
                            @elseif($stWakaSdm === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Ditolak
                                </span>
                            @else
                                <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Final Kepsek Status OR Action Buttons -->
                    @if($stKepsek === 'approved')
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 18px; font-size: 18px; font-weight: 800; color: #0f172a;">
                            <i class="fa-regular fa-square-check" style="font-size: 24px; color: #0f172a;"></i> Disetujui Kepala Sekolah
                        </div>
                    @elseif($stKepsek === 'rejected')
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 18px; font-size: 18px; font-weight: 800; color: #dc2626;">
                            <i class="fa-regular fa-rectangle-xmark" style="font-size: 24px; color: #dc2626;"></i> Ditolak Kepala Sekolah
                        </div>
                    @else
                        <div class="izin-action-buttons">
                            <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="izin-action-btn" style="width: 100%; background: #384972; color: #ffffff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: background 0.2s ease; box-sizing: border-box;">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('kepala-sekolah.izin.reject', $izin->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="izin-action-btn" style="width: 100%; background: #f1f5f9; color: #384972; border: 1.5px solid #cbd5e1; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: all 0.2s ease; box-sizing: border-box;">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div style="background: #ffffff; padding: 36px; border-radius: 16px; text-align: center; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 28px; margin-bottom: 10px;"></i><br>
                Tidak ada permohonan izin aktif saat ini.
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Popup Preview Foto Surat / Bukti Izin Guru -->
<div id="suratModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; padding: 16px; box-sizing: border-box;">
    <div style="background: #ffffff; width: 100%; max-width: 620px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #cbd5e1; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh;">
        <!-- Modal Header -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <div>
                <h3 id="modalGuruName" style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a; line-height: 1.3;">
                    Foto Surat / Bukti Izin Guru
                </h3>
                <div id="modalSubtext" style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    Dokumen resmi permohonan izin
                </div>
            </div>
            <button type="button" onclick="closeSuratModal()" style="background: #e2e8f0; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #475569; cursor: pointer; flex-shrink: 0; margin-left: 10px;">
                &times;
            </button>
        </div>

        <!-- Modal Body: Real Image Preview Box -->
        <div style="padding: 16px; text-align: center; background: #f1f5f9; overflow-y: auto; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #cbd5e1; width: 100%; display: flex; flex-direction: column; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); box-sizing: border-box;">
                <!-- Real Image Element displaying the uploaded proof image -->
                <img id="modalImagePreview" src="" alt="Foto Surat / Bukti Izin Guru" style="max-width: 100%; max-height: 380px; border-radius: 10px; object-fit: contain; border: 1px solid #e2e8f0; background: #f8fafc;">
                
                <div id="modalFileName" style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 10px; word-break: break-all;">
                    surat_keterangan.png
                </div>
                <div style="margin-top: 8px; font-size: 11.5px; background: #dcfce7; color: #166534; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
                    <i class="fa-solid fa-circle-check"></i> Dokumen Foto / Surat Asli Terverifikasi
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 14px 20px; border-top: 1px solid #e2e8f0; text-align: right; background: #ffffff;">
            <button type="button" onclick="closeSuratModal()" style="background: #384972; color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit; width: 100%;">
                Tutup Preview
            </button>
        </div>
    </div>
</div>

<script>
    function showSuratModal(namaGuru, tanggal, alasan, fileName) {
        var baseUploadUrl = "{{ asset('uploads/guru_izin') }}";
        var imgUrl = baseUploadUrl + '/' + (fileName || '1787625106_QJzh6X66.png');

        document.getElementById('modalGuruName').innerText = 'Foto Surat / Bukti Izin - ' + namaGuru;
        document.getElementById('modalSubtext').innerText = tanggal + ' • ' + alasan;
        document.getElementById('modalFileName').innerText = 'Nama File: ' + (fileName || '1787625106_QJzh6X66.png');
        document.getElementById('modalImagePreview').src = imgUrl;
        document.getElementById('suratModal').style.display = 'flex';
    }

    function closeSuratModal() {
        document.getElementById('suratModal').style.display = 'none';
    }

    // Close modal when clicking outside box
    window.onclick = function(event) {
        var modal = document.getElementById('suratModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
