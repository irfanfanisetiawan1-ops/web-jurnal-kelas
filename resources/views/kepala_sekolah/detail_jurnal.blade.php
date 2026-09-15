@extends('layouts.kepala_sekolah')

@section('title', 'Detail Jurnal Mengajar Guru — Jurnal SMEA')
@section('header_title', 'Detail Jurnal Mengajar')

@section('styles')
<style>
    .detail-jurnal-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 30px;
    }

    .detail-card-main {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .top-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 20px;
    }

    .header-info-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .header-breadcrumb {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back-detail {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-back-detail:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .btn-print-detail {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .btn-print-detail:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .grid-info-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .info-box-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-val-primary {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .info-val-sub {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .content-box-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .content-box-title {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
    }

    .table-absensi-styled {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin-top: 8px;
    }

    .table-absensi-styled th {
        background: #f1f5f9;
        padding: 10px 14px;
        font-weight: 800;
        color: #334155;
        border: 1px solid #e2e8f0;
        text-align: left;
    }

    .table-absensi-styled td {
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .signature-card-box {
        background: #f8fafc;
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .signature-badge-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
</style>
@endsection

@section('content')

@php
    $namaGuru = $jurnal->jadwal->guru->nama_guru ?? ($jurnal->guru->nama_guru ?? '-');
    $nipGuru = $jurnal->jadwal->guru->nip ?? ($jurnal->guru->nip ?? '-');
    $namaKelas = $jurnal->jadwal->kelas->nama_kelas ?? ($jurnal->kelas->nama_kelas ?? '-');
    $namaRuangan = $jurnal->jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas';
    $namaMapel = $jurnal->jadwal->mapel->nama_mapel ?? ($jurnal->mapel->nama_mapel ?? '-');

    $jamMulaiStr = $jurnal->jadwal->waktu_mulai_effective ?? '07:00';
    $jamSelesaiStr = $jurnal->jadwal->waktu_selesai_effective ?? '15:00';
    $jamText = substr($jamMulaiStr, 0, 5) . ' - ' . substr($jamSelesaiStr, 0, 5) . ' WIB';
    $sesiText = $jurnal->jam_ke ?: ('Jam ke-' . ($jurnal->jadwal->id_jam_mulai ?? 1) . ($jurnal->jadwal->id_jam_selesai && $jurnal->jadwal->id_jam_selesai != $jurnal->jadwal->id_jam_mulai ? ' - ' . $jurnal->jadwal->id_jam_selesai : ''));

    $pertemuanClean = preg_replace('/^ke[-_\s]*/i', '', trim($jurnal->pertemuan_ke ?? '1'));
    $verif = $jurnal->verifikasiPiket;
    $isVerified = $verif && $verif->status === 'terverifikasi';
@endphp

<div class="detail-jurnal-container">

    <div class="detail-card-main">

        <!-- Top Header Bar -->
        <div class="top-header-bar">
            <div>
                <div class="header-breadcrumb">
                    <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" style="color: #64748b; text-decoration: none;">Jurnal Mengajar Guru</a>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin: 0 6px;"></i>
                    <span style="color: #0f172a; font-weight: 700;">Detail Sesi #{{ $jurnal->id_jurnal }}</span>
                </div>
                <h1 class="header-info-title">{{ $namaMapel }} — {{ $namaKelas }}</h1>
            </div>

            <div class="header-actions">
                <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" class="btn-action-detail btn-back-detail">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <a href="{{ route('kepala-sekolah.jurnal-pembelajaran.cetak-harian', ['tanggal' => $jurnal->tanggal]) }}" target="_blank" class="btn-action-detail btn-print-detail">
                    <i class="fa-solid fa-print"></i> Cetak Rekap Harian (+ TTD Piket)
                </a>
            </div>
        </div>

        <!-- Grid Informasi KBM -->
        <div class="grid-info-section">
            <div class="info-box-item">
                <span class="info-label"><i class="fa-regular fa-calendar"></i> Tanggal Pembelajaran</span>
                <span class="info-val-primary">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}</span>
                <span class="info-val-sub">{{ $sesiText }} &bull; {{ $jamText }}</span>
            </div>

            <div class="info-box-item">
                <span class="info-label"><i class="fa-solid fa-graduation-cap"></i> Kelas & Ruangan</span>
                <span class="info-val-primary" style="color: #2563eb;">{{ $namaKelas }}</span>
                <span class="info-val-sub"><i class="fa-solid fa-location-dot"></i> {{ $namaRuangan }}</span>
            </div>

            <div class="info-box-item">
                <span class="info-label"><i class="fa-solid fa-chalkboard-user"></i> Guru Pengampu</span>
                <span class="info-val-primary">{{ $namaGuru }}</span>
                <span class="info-val-sub">NIP. {{ $nipGuru }}</span>
                @if($jurnal->id_guru_pengganti && $jurnal->guruPengganti)
                    <div style="margin-top: 4px;">
                        <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 11px;">
                            Guru Pengganti: {{ $jurnal->guruPengganti->nama_guru }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="info-box-item">
                <span class="info-label"><i class="fa-solid fa-list-check"></i> Pertemuan & Status KBM</span>
                <span class="info-val-primary">Pertemuan Ke-{{ $pertemuanClean ?: 1 }}</span>
                <span class="info-val-sub">
                    Status: 
                    @if($jurnal->status_kehadiran_guru === 'Hadir')
                        <strong style="color: #166534;">Terlaksana (Hadir)</strong>
                    @elseif($jurnal->status_kehadiran_guru === 'Izin')
                        <strong style="color: #92400e;">Izin</strong>
                    @else
                        <strong style="color: #991b1b;">{{ $jurnal->status_kehadiran_guru ?? 'Tidak Hadir' }}</strong>
                    @endif
                </span>
            </div>
        </div>

        <!-- Materi Pembelajaran -->
        <div class="content-box-card">
            <div class="content-box-title">
                <i class="fa-solid fa-book-open" style="color: #2563eb;"></i> Materi Pembelajaran
            </div>
            <div style="font-size: 14.5px; font-weight: 600; color: #1e293b; line-height: 1.6; background: #ffffff; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                {{ $jurnal->materi ?: 'Pembelajaran KBM terlaksana sesuai rencana silabus kurikulum.' }}
            </div>
        </div>

        <!-- Catatan KBM & Kondisi Kelas -->
        <div class="content-box-card">
            <div class="content-box-title">
                <i class="fa-solid fa-comment-dots" style="color: #475569;"></i> Catatan Guru & Kondisi Kelas
            </div>
            <div style="font-size: 13.5px; color: #334155; background: #ffffff; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0;">
                {{ $jurnal->catatan ?: 'Pembelajaran terlaksana dengan tertib, lancar dan kondusif.' }}
                <div style="margin-top: 6px; font-size: 12px; color: #64748b; font-weight: 700;">
                    Kondisi Kelas: <span style="color: #0f172a;">{{ $jurnal->kondisi_kelas ?: 'Kondusif' }}</span>
                </div>
            </div>
        </div>

        <!-- Presensi Siswa / Ketidakhadiran -->
        <div class="content-box-card">
            <div class="content-box-title">
                <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi Siswa & Laporan Ketidakhadiran
            </div>
            <div style="background: #ffffff; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                @if($jurnal->detailKetidakhadiran && $jurnal->detailKetidakhadiran->count() > 0)
                    <div style="font-size: 13px; font-weight: 700; color: #dc2626; margin-bottom: 8px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Terdapat {{ $jurnal->detailKetidakhadiran->count() }} siswa tidak hadir / keterangan khusus:
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="table-absensi-styled">
                            <thead>
                                <tr>
                                    <th style="width: 35px; text-align: center;">No</th>
                                    <th>Nama Siswa</th>
                                    <th style="width: 120px; text-align: center;">Status</th>
                                    <th>Keterangan / Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jurnal->detailKetidakhadiran as $idx => $det)
                                    @php
                                        $st = $det->keterangan ?: ($det->status ?? 'Absen');
                                    @endphp
                                    <tr>
                                        <td style="text-align: center; font-weight: bold;">{{ $idx + 1 }}</td>
                                        <td style="font-weight: 700; color: #0f172a;">{{ $det->siswa->nama_siswa ?? ('Siswa #' . $det->id_siswa) }}</td>
                                        <td style="text-align: center;">
                                            <span style="padding: 3px 10px; border-radius: 10px; font-size: 11.5px; font-weight: 800; background: #fee2e2; color: #dc2626;">
                                                {{ $st }}
                                            </span>
                                        </td>
                                        <td style="color: #64748b;">{{ $det->catatan ?: ($det->keterangan ?: '-') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="color: #166534; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i> Seluruh siswa hadir lengkap pada sesi pembelajaran ini (Nihil Absen).
                    </div>
                @endif
            </div>
        </div>

        <!-- Foto Dokumentasi KBM -->
        @if($jurnal->dokumentasi_url)
        <div class="content-box-card">
            <div class="content-box-title">
                <i class="fa-solid fa-camera" style="color: #2563eb;"></i> Foto Dokumentasi KBM
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; text-align: center;">
                <a href="{{ $jurnal->dokumentasi_url }}" target="_blank">
                    <img src="{{ $jurnal->dokumentasi_url }}" alt="Foto Dokumentasi KBM" style="max-width: 100%; max-height: 380px; border-radius: 10px; object-fit: contain; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                </a>
                <div style="font-size: 11.5px; color: #64748b; margin-top: 8px;">
                    <i class="fa-solid fa-magnifying-glass-plus"></i> Klik foto untuk memperbesar ukuran asli
                </div>
            </div>
        </div>
        @endif

        <!-- Box Bukti Verifikasi & Tanda Tangan Guru Piket -->
        <div class="signature-card-box">
            <div style="display: flex; flex-direction: column; gap: 6px; max-width: 460px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 14px; font-weight: 800; color: #1e3a8a;">
                        <i class="fa-solid fa-signature"></i> PENGESAHAN GURU PIKET
                    </span>
                    @if($isVerified)
                        <span class="signature-badge-success"><i class="fa-solid fa-circle-check"></i> Terverifikasi Resmi</span>
                    @else
                        <span style="background: #f1f5f9; color: #64748b; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">Menunggu Tanda Tangan Piket</span>
                    @endif
                </div>

                @if($isVerified)
                    <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-top: 4px;">
                        Petugas Guru Piket: {{ $verif->nama_guru_piket ?: ($verif->guru->nama_guru ?? 'Petugas Piket') }}
                    </div>
                    <div style="font-size: 12px; color: #64748b;">
                        NIP. {{ $verif->nip_guru_piket ?: ($verif->guru->nip ?? '-') }} &bull; Waktu: {{ \Carbon\Carbon::parse($verif->waktu_verifikasi)->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                    <div style="font-size: 12.5px; color: #334155; font-style: italic; margin-top: 4px;">
                        "{{ $verif->catatan ?: 'Seluruh sesi KBM telah diverifikasi dan disahkan oleh Petugas Guru Piket.' }}"
                    </div>
                @else
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 4px;">
                        Jurnal harian pada tanggal ini belum diverifikasi dan ditandatangani oleh Petugas Guru Piket sekolah.
                    </div>
                @endif
            </div>

            @if($isVerified && $verif->tanda_tangan)
                <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 12px 20px; text-align: center;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Tanda Tangan Digital Guru Piket</span>
                    <img src="{{ $verif->tanda_tangan }}" alt="Tanda Tangan Piket" style="max-height: 75px; max-width: 180px; object-fit: contain;">
                </div>
            @endif
        </div>

    </div>

</div>
@endsection