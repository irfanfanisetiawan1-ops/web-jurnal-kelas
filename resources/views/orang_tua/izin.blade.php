@extends('layouts.orang_tua')

@section('title', 'Pengajuan Izin — Jurnal SMEA')

@section('styles')
<style>
    .izin-page-container {
        max-width: 1050px;
        margin: 0 auto;
        padding-bottom: 40px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-box {
        margin-bottom: 0;
    }

    .page-breadcrumb {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .page-breadcrumb a {
        color: #475569;
        text-decoration: none;
    }
    .page-breadcrumb span {
        color: #1e293b;
        font-weight: 800;
    }

    .page-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 600;
    }

    .alert-error-box {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #9f1239;
        padding: 16px 18px;
        border-radius: 14px;
        font-size: 13.5px;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.08);
    }

    .izin-grid-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        align-items: start;
        width: 100%;
    }

    .card-izin-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
    }

    .card-header-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 18px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-grid-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }

    .form-group-item {
        margin-bottom: 16px;
    }

    .form-label-custom {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-input-custom {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
        font-family: inherit;
    }
    .form-input-custom:focus {
        border-color: #384972;
        box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.1);
    }

    .btn-submit-izin {
        width: 100%;
        background: #384972;
        color: #ffffff;
        padding: 12px 18px;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(56, 73, 114, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-submit-izin:hover {
        background: #2b395b;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(56, 73, 114, 0.35);
    }

    .riwayat-card-item {
        padding: 14px 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .riwayat-card-item:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
    }

    .riwayat-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .riwayat-desc-text {
        margin: 0 0 10px 0;
        font-size: 13px;
        color: #334155;
        line-height: 1.4;
        font-weight: 500;
        word-break: break-word;
    }

    .riwayat-footer-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px dashed #e2e8f0;
        padding-top: 8px;
        margin-top: 4px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .btn-view-detail {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        padding: 6px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-view-detail:hover {
        background: #bae6fd;
        color: #0284c7;
    }

    /* Modal Styling */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        z-index: 999999;
        backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-card-dialog {
        background: #ffffff;
        border-radius: 20px;
        max-width: 580px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        border: 1px solid #e2e8f0;
        animation: modalPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
    }

    .modal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }

    @keyframes modalPopIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* MOBILE RESPONSIVENESS */
    @media (max-width: 768px) {
        .izin-page-container {
            gap: 16px;
            width: 100%;
            overflow-x: hidden;
            padding-bottom: 24px;
        }

        .page-title {
            font-size: 20px;
            gap: 8px;
        }

        .page-subtitle {
            font-size: 12.5px;
            line-height: 1.4;
        }

        .izin-grid-layout {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .card-izin-box {
            padding: 16px 14px;
            border-radius: 16px;
        }

        .card-header-title {
            font-size: 15px;
            margin-bottom: 14px;
            padding-bottom: 10px;
        }

        .date-grid-inputs {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 14px;
        }

        .form-group-item {
            margin-bottom: 14px;
        }

        .form-label-custom {
            font-size: 12.5px;
            margin-bottom: 4px;
        }

        .form-input-custom {
            font-size: 12.5px;
            padding: 9px 12px;
        }

        .btn-submit-izin {
            padding: 11px 16px;
            font-size: 13.5px;
            border-radius: 10px;
        }

        .riwayat-card-item {
            padding: 12px 12px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .riwayat-desc-text {
            font-size: 12.5px;
        }

        .modal-card-dialog {
            border-radius: 16px;
            max-height: 88vh;
        }

        .modal-info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }

    @media (max-width: 420px) {
        .date-grid-inputs {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="izin-page-container">

    <!-- Top Page Header -->
    <div class="page-header-box">
        <div class="page-breadcrumb">
            Jurnal SMEA &gt; <a href="{{ route('orang-tua.dashboard') }}">Dashboard Orang Tua</a> &gt; <span>Pengajuan Izin</span>
        </div>
        <h1 class="page-title">
            <i class="fa-solid fa-file-signature" style="color: #384972;"></i> Pengajuan Surat Izin Anak
        </h1>
        <p class="page-subtitle">
            Formulir permohonan izin (Sakit/Izin) yang terhubung langsung dengan sistem presensi dan guru piket sekolah.
        </p>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="alert-error-box">
            <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 6px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 18px; color: #e11d48; margin-top: 2px;"></i>
                <strong style="font-size: 14px;">Gagal Mengajukan Surat Izin:</strong>
            </div>
            <ul style="margin: 0 0 0 28px; padding: 0; font-weight: 600; line-height: 1.5;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($siswa)
    <div class="izin-grid-layout">

        <!-- Form Pengajuan Izin -->
        <div class="card-izin-box">
            <div class="card-header-title">
                <div class="card-title-left">
                    <i class="fa-solid fa-pen-to-square" style="color: #4a5e8c;"></i> Form Izin Baru
                </div>
            </div>

            <form id="formIzinOrangTua" action="{{ route('orang-tua.store-izin') }}" method="POST" enctype="multipart/form-data" onsubmit="return handleFormSubmit(event)">
                @csrf

                <!-- Nama Siswa -->
                <div class="form-group-item">
                    <label class="form-label-custom">Nama Siswa</label>
                    <div style="position: relative;">
                        <input type="text" value="{{ $siswa->nama_siswa }} ({{ $siswa->kelas->nama_kelas ?? '-' }})" readonly class="form-input-custom" style="background: #f8fafc; padding-left: 36px; font-weight: 700; color: #334155;">
                        <i class="fa-solid fa-user-graduate" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 14px;"></i>
                    </div>
                </div>

                <!-- Grid Tanggal (Mulai & Selesai) -->
                <div class="date-grid-inputs">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="form-label-custom">
                            Tanggal Mulai <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal_mulai" 
                               name="tanggal" 
                               value="{{ old('tanggal', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               required 
                               onchange="validateTanggalIzin()" 
                               oninput="validateTanggalIzin()"
                               class="form-input-custom">
                    </div>

                    <!-- Tanggal Selesai (Opsional) -->
                    <div>
                        <label class="form-label-custom">
                            Tanggal Selesai <span style="font-size: 11px; color: #64748b; font-weight: 500;">(Opsional)</span>
                        </label>
                        <input type="date" 
                               id="tanggal_selesai" 
                               name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai') }}" 
                               min="{{ date('Y-m-d') }}" 
                               onchange="validateTanggalIzin()"
                               class="form-input-custom">
                    </div>
                </div>

                <!-- Alert Validation Message for Past Date -->
                <div id="tanggalErrorBanner" style="display: none; background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; margin-bottom: 16px;">
                    <i class="fa-solid fa-triangle-exclamation" style="color: #e11d48; margin-right: 6px;"></i>
                    <span id="tanggalErrorText">Tanggal izin tidak boleh memilih tanggal yang telah berlalu!</span>
                </div>

                <!-- Kategori Izin -->
                <div class="form-group-item">
                    <label class="form-label-custom">Kategori Izin <span style="color: #ef4444;">*</span></label>
                    <select name="kategori" required class="form-input-custom" style="font-weight: 700;">
                        <option value="Sakit" {{ old('kategori') == 'Sakit' ? 'selected' : '' }}>Sakit (Dengan / Tanpa Surat Dokter)</option>
                        <option value="Izin" {{ old('kategori') == 'Izin' ? 'selected' : '' }}>Izin (Acara Keluarga / Kepentingan Lain)</option>
                    </select>
                </div>

                <!-- Keterangan / Alasan -->
                <div class="form-group-item">
                    <label class="form-label-custom">Keterangan / Alasan <span style="color: #ef4444;">*</span></label>
                    <textarea name="keterangan" rows="3" required placeholder="Jelaskan alasan permohonan izin anak secara jelas..." class="form-input-custom" style="font-weight: 500; resize: vertical;">{{ old('keterangan') }}</textarea>
                </div>

                <!-- Lampiran Foto Bukti -->
                <div style="margin-bottom: 22px;">
                    <label class="form-label-custom">
                        Lampiran Foto Bukti <span style="font-size: 11.5px; color: #64748b; font-weight: 500;">(Surat Dokter/Surat Ortu - JPG, PNG, WEBP Maks 5MB)</span>
                    </label>
                    <input type="file" 
                           id="input_foto_bukti"
                           name="foto_bukti" 
                           accept="image/jpeg,image/png,image/jpg,image/webp" 
                           onchange="previewFotoUpload(this)"
                           style="width: 100%; font-size: 12.5px; color: #475569; padding: 8px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; cursor: pointer; box-sizing: border-box;">
                    
                    <!-- Preview Container -->
                    <div id="previewFotoBox" style="display: none; margin-top: 10px; position: relative;">
                        <img id="previewFotoImg" src="" alt="Preview Bukti" style="max-height: 140px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: cover;">
                        <button type="button" onclick="cancelFotoUpload()" style="position: absolute; top: 4px; left: 140px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 11px; display: flex; align-items: center; justify-content: center;" title="Hapus foto"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>

                <button type="submit" id="btnSubmitIzin" class="btn-submit-izin">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Surat Izin
                </button>
            </form>
        </div>

        <!-- Riwayat Surat Izin -->
        <div class="card-izin-box">
            <div class="card-header-title">
                <div class="card-title-left">
                    <i class="fa-solid fa-clock-rotate-left" style="color: #4a5e8c;"></i> Riwayat Surat Izin
                </div>
                <span style="font-size: 12px; font-weight: 800; background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px;">
                    {{ count($suratIzinList) }} Permohonan
                </span>
            </div>

            @forelse($suratIzinList as $surat)
                @php
                    $isSakit = ($surat->kategori == 'Sakit');
                    $kategoriBg = $isSakit ? '#fef3c7' : '#e0f2fe';
                    $kategoriText = $isSakit ? '#92400e' : '#0369a1';
                    
                    $status = $surat->status ?? 'Terverifikasi';
                    $statusBg = '#dcfce7';
                    $statusText = '#15803d';
                    if ($status == 'Menunggu') {
                        $statusBg = '#fef9c3';
                        $statusText = '#a16207';
                    } elseif ($status == 'Ditolak') {
                        $statusBg = '#ffe4e6';
                        $statusText = '#be123c';
                    }

                    $detailPayload = [
                        'id'              => $surat->id_surat_izin,
                        'siswa_nama'      => $siswa->nama_siswa,
                        'siswa_kelas'     => $siswa->kelas->nama_kelas ?? '-',
                        'siswa_nisn'      => $siswa->nisn ?? '-',
                        'kategori'        => $surat->kategori,
                        'status'          => $status,
                        'tanggal'         => $surat->tanggal,
                        'tanggal_selesai' => $surat->tanggal_selesai,
                        'rentang_text'    => $surat->rentang_tanggal_text,
                        'durasi_text'     => $surat->durasi_text,
                        'keterangan'      => $surat->keterangan ?? 'Tanpa keterangan',
                        'foto_url'        => $surat->foto_url,
                        'created_at'      => $surat->created_at ? $surat->created_at->isoFormat('D MMMM YYYY, HH:mm') . ' WIB' : '-',
                        'petugas'         => $surat->petugasPiket->name ?? 'Sistem Sekolah (Otomatis)'
                    ];
                @endphp

                <div class="riwayat-card-item">
                    <div class="riwayat-header-flex">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-weight: 800; font-size: 12px; background: {{ $kategoriBg }}; color: {{ $kategoriText }}; padding: 3px 10px; border-radius: 8px;">
                                {{ $surat->kategori }}
                            </span>
                            <span style="font-weight: 800; font-size: 11px; background: {{ $statusBg }}; color: {{ $statusText }}; padding: 3px 9px; border-radius: 20px;">
                                <i class="fa-solid fa-shield-check"></i> {{ $status }}
                            </span>
                        </div>
                        <span style="font-size: 11.5px; font-weight: 700; color: #64748b;">
                            <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ $surat->rentang_tanggal_text }}
                        </span>
                    </div>

                    <p class="riwayat-desc-text">
                        {{ \Illuminate\Support\Str::limit($surat->keterangan ?? 'Tanpa keterangan', 90) }}
                    </p>

                    <div class="riwayat-footer-flex">
                        <span style="font-size: 11px; font-weight: 600; color: #94a3b8;">
                            @if($surat->foto_url)
                                <i class="fa-solid fa-paperclip" style="color: #2563eb;"></i> Ada Lampiran Foto
                            @else
                                <i class="fa-regular fa-file" style="color: #94a3b8;"></i> Tanpa Lampiran
                            @endif
                        </span>

                        <button type="button" 
                                onclick='openDetailSuratModal(@json($detailPayload))'
                                class="btn-view-detail">
                            <i class="fa-solid fa-eye"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #64748b; padding: 40px 20px; font-size: 13.5px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                    <i class="fa-solid fa-inbox" style="font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                    Belum ada riwayat permohonan surat izin.
                </div>
            @endforelse
        </div>

    </div>
    @endif

</div>

<!-- Modal Pop-Up Detail Surat Izin -->
<div id="modalDetailSuratIzin" class="modal-backdrop-custom">
    
    <div class="modal-card-dialog">
        
        <!-- Modal Header -->
        <div style="padding: 18px 22px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 20px 20px 0 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: #384972; border-radius: 10px; color: white; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #0f172a;" id="modalTitleKategori">
                        Detail Surat Izin
                    </h3>
                    <span style="font-size: 11.5px; color: #64748b; font-weight: 600;" id="modalSubTitleText">
                        Informasi lengkap surat izin anak
                    </span>
                </div>
            </div>
            <button type="button" onclick="closeDetailSuratModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #64748b; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: all 0.15s ease;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 20px;">
            
            <!-- Badges Bar -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <div>
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; display: block; margin-bottom: 2px;">KATEGORI IZIN</span>
                    <span id="modalBadgeKategori" style="font-size: 12.5px; font-weight: 800; padding: 3px 12px; border-radius: 8px; display: inline-block;">-</span>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; display: block; margin-bottom: 2px;">STATUS PERSETUJUAN</span>
                    <span id="modalBadgeStatus" style="font-size: 11.5px; font-weight: 800; padding: 3px 12px; border-radius: 20px; display: inline-block;">-</span>
                </div>
            </div>

            <!-- Details Table / Info Grid -->
            <div class="modal-info-grid">
                <div style="background: #f8fafc; padding: 10px 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">NAMA SISWA</span>
                    <div style="font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px; word-break: break-word;" id="modalNamaSiswa">-</div>
                </div>

                <div style="background: #f8fafc; padding: 10px 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">KELAS / NISN</span>
                    <div style="font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="modalKelasNisn">-</div>
                </div>

                <div style="background: #f8fafc; padding: 10px 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">RENTANG TANGGAL</span>
                    <div style="font-size: 13px; font-weight: 800; color: #2563eb; margin-top: 2px;" id="modalRentangTanggal">-</div>
                </div>

                <div style="background: #f8fafc; padding: 10px 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">WAKTU PENGAJUAN</span>
                    <div style="font-size: 12px; font-weight: 700; color: #475569; margin-top: 2px;" id="modalWaktuPengajuan">-</div>
                </div>
            </div>

            <!-- Full Keterangan -->
            <div style="margin-bottom: 16px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #334155; display: block; margin-bottom: 6px;">KETERANGAN / ALASAN PERMOHONAN:</span>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 12px 14px; border-radius: 10px; font-size: 13px; color: #0f172a; line-height: 1.5; font-weight: 500; white-space: pre-wrap; word-break: break-word;" id="modalKeterangan">
                    -
                </div>
            </div>

            <!-- Lampiran Foto Bukti Section -->
            <div>
                <span style="font-size: 11.5px; font-weight: 800; color: #334155; display: block; margin-bottom: 6px;">
                    <i class="fa-solid fa-paperclip" style="color: #2563eb;"></i> LAMPIRAN FOTO BUKTI:
                </span>

                <!-- Display Photo when available -->
                <div id="modalFotoContainer" style="display: none; text-align: center; background: #0f172a; padding: 12px; border-radius: 12px; border: 1px solid #334155;">
                    <img id="modalFotoImg" src="" alt="Foto Bukti" style="max-width: 100%; max-height: 280px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.5);">
                    
                    <div style="margin-top: 10px; display: flex; justify-content: center;">
                        <a id="modalFotoBtnLink" href="" target="_blank" style="background: #2563eb; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 3px 10px rgba(37, 99, 235, 0.3);">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Foto Ukuran Penuh
                        </a>
                    </div>
                </div>

                <!-- Display Fallback when no photo -->
                <div id="modalNoFotoFallback" style="display: none; text-align: center; padding: 20px; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; color: #94a3b8; font-size: 12.5px; font-weight: 600;">
                    <i class="fa-solid fa-image-slash" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 6px;"></i>
                    Surat izin ini dikirim tanpa lampiran foto bukti.
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div style="padding: 14px 20px; border-top: 1px solid #f1f5f9; background: #f8fafc; border-radius: 0 0 20px 20px; text-align: right;">
            <button type="button" onclick="closeDetailSuratModal()" style="background: #384972; color: #ffffff; border: none; padding: 9px 20px; border-radius: 8px; font-weight: 800; font-size: 12.5px; cursor: pointer; width: 100%; max-width: 120px;">
                Tutup
            </button>
        </div>

    </div>

</div>

<script>
    const todayStr = "{{ date('Y-m-d') }}";

    function validateTanggalIzin() {
        const tglMulaiInput = document.getElementById('tanggal_mulai');
        const tglSelesaiInput = document.getElementById('tanggal_selesai');
        const errorBanner = document.getElementById('tanggalErrorBanner');
        const errorText = document.getElementById('tanggalErrorText');
        const submitBtn = document.getElementById('btnSubmitIzin');

        if (!tglMulaiInput) return true;

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput ? tglSelesaiInput.value : '';

        // Reset state
        errorBanner.style.display = 'none';
        tglMulaiInput.style.borderColor = '#cbd5e1';
        if (tglSelesaiInput) tglSelesaiInput.style.borderColor = '#cbd5e1';
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }

        // 1. Cek Tanggal Mulai < Hari Ini
        if (valMulai && valMulai < todayStr) {
            errorBanner.style.display = 'block';
            errorText.textContent = '⚠️ Tanggal mulai izin tidak boleh memilih tanggal yang telah berlalu! (Hari ini: ' + todayStr + ')';
            tglMulaiInput.style.borderColor = '#ef4444';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                submitBtn.style.cursor = 'not-allowed';
            }
            return false;
        }

        // 2. Cek Tanggal Selesai < Tanggal Mulai
        if (valSelesai && valMulai && valSelesai < valMulai) {
            errorBanner.style.display = 'block';
            errorText.textContent = '⚠️ Tanggal selesai izin tidak boleh sebelum tanggal mulai izin!';
            if (tglSelesaiInput) tglSelesaiInput.style.borderColor = '#ef4444';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                submitBtn.style.cursor = 'not-allowed';
            }
            return false;
        }

        return true;
    }

    function handleFormSubmit(event) {
        if (!validateTanggalIzin()) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    function previewFotoUpload(input) {
        const previewBox = document.getElementById('previewFotoBox');
        const previewImg = document.getElementById('previewFotoImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewBox.style.display = 'none';
        }
    }

    function cancelFotoUpload() {
        const input = document.getElementById('input_foto_bukti');
        const previewBox = document.getElementById('previewFotoBox');
        if (input) input.value = '';
        if (previewBox) previewBox.style.display = 'none';
    }

    function openDetailSuratModal(data) {
        document.getElementById('modalTitleKategori').textContent = 'Detail Surat Izin — ' + data.kategori;
        document.getElementById('modalNamaSiswa').textContent = data.siswa_nama;
        document.getElementById('modalKelasNisn').textContent = data.siswa_kelas + ' (NISN: ' + data.siswa_nisn + ')';
        document.getElementById('modalRentangTanggal').textContent = data.rentang_text;
        document.getElementById('modalWaktuPengajuan').textContent = data.created_at;
        document.getElementById('modalKeterangan').textContent = data.keterangan;

        // Kategori Badge
        const badgeKat = document.getElementById('modalBadgeKategori');
        if (data.kategori === 'Sakit') {
            badgeKat.textContent = 'Sakit';
            badgeKat.style.background = '#fef3c7';
            badgeKat.style.color = '#92400e';
        } else {
            badgeKat.textContent = 'Izin';
            badgeKat.style.background = '#e0f2fe';
            badgeKat.style.color = '#0369a1';
        }

        // Status Badge
        const badgeStat = document.getElementById('modalBadgeStatus');
        badgeStat.textContent = data.status;
        if (data.status === 'Terverifikasi') {
            badgeStat.style.background = '#dcfce7';
            badgeStat.style.color = '#15803d';
        } else if (data.status === 'Menunggu') {
            badgeStat.style.background = '#fef9c3';
            badgeStat.style.color = '#a16207';
        } else {
            badgeStat.style.background = '#ffe4e6';
            badgeStat.style.color = '#be123c';
        }

        // Foto Bukti
        const fotoContainer = document.getElementById('modalFotoContainer');
        const noFotoFallback = document.getElementById('modalNoFotoFallback');
        const fotoImg = document.getElementById('modalFotoImg');
        const fotoBtnLink = document.getElementById('modalFotoBtnLink');

        if (data.foto_url && data.foto_url.trim() !== '') {
            fotoImg.src = data.foto_url;
            fotoBtnLink.href = data.foto_url;
            fotoContainer.style.display = 'block';
            noFotoFallback.style.display = 'none';
        } else {
            fotoContainer.style.display = 'none';
            noFotoFallback.style.display = 'block';
        }

        const modal = document.getElementById('modalDetailSuratIzin');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDetailSuratModal() {
        const modal = document.getElementById('modalDetailSuratIzin');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close Modal on backdrop click or ESC key
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalDetailSuratIzin');
        if (e.target === modal) {
            closeDetailSuratModal();
        }
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailSuratModal();
        }
    });
</script>
@endsection
