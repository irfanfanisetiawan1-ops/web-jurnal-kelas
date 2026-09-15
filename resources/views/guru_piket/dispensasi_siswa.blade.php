@extends('layouts.guru')

@section('title', 'Dispensasi Siswa — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Student & Waka Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .guru-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
        width: 100%;
    }

    .header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }

    .card-custom-body {
        padding: 24px;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Tombol Simpan Navy Modern Konsisten (Sesuai Gambar media_1788625196097.png) */
    .btn-submit-navy, .btn-submit-custom {
        background: #2b3957;
        color: #ffffff;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(43, 57, 87, 0.25);
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-submit-navy:hover, .btn-submit-custom:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(30, 41, 59, 0.35);
    }

    /* Tombol Reset Form Abu-abu Muda (Sesuai Gambar media_1788624975339.png) */
    .btn-reset-light {
        background: #e2e8f0;
        color: #334155;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-reset-light:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-approved { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .badge-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .badge-pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

    .action-btn {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .action-btn-wa { background: #25d366; color: #ffffff; }
    .action-btn-wa:hover { background: #1da851; color: #ffffff; }
    .action-btn-copy { background: #3b82f6; color: #ffffff; }
    .action-btn-copy:hover { background: #2563eb; color: #ffffff; }
    .action-btn-barcode { background: #64748b; color: #ffffff; border: 1px solid #475569; }
    .action-btn-barcode:hover { background: #475569; color: #ffffff; border-color: #334155; }
    .action-btn-edit { background: #f59e0b; color: #ffffff; }
    .action-btn-edit:hover { background: #d97706; color: #ffffff; }
    .action-btn-delete { background: #ef4444; color: #ffffff; }
    .action-btn-delete:hover { background: #dc2626; color: #ffffff; }

    /* Modal Styling */
    .modal-backdrop-custom {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center;
        z-index: 9999; padding: 20px;
    }
    .modal-card {
        background: #ffffff; border-radius: 16px; width: 100%; max-width: 580px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;
    }
    .modal-header { padding: 18px 24px; background: #384972; color: #ffffff; display: flex; align-items: center; justify-content: space-between; }
    .modal-body { padding: 24px; max-height: 80vh; overflow-y: auto; }
    @keyframes pulseRed {
        0% { opacity: 1; transform: scale(1); }
        100% { opacity: 0.3; transform: scale(0.85); }
    }
</style>
@endsection

@section('content')
<div class="guru-izin-container">
    
    <!-- Top Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-id-card-clip" style="color: #2563eb;"></i> Dispensasi Siswa</h1>
            <p>Input data permohonan izin dispensasi siswa oleh Guru Piket & verifikasi persetujuan Waka Kesiswaan</p>
        </div>
    </div>

    <!-- Alert Error Validation -->
    @if($errors->any())
        <div class="card-custom" style="border-left: 5px solid #ef4444; background: #fef2f2;">
            <div class="card-custom-body" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #991b1b; font-weight: 700; font-size: 13.5px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 20px;"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert Banner Generated Link Waka -->
    @if(session('success'))
        <div class="card-custom" style="border-left: 5px solid #10b981; background: #ecfdf5;">
            <div class="card-custom-body" style="padding: 18px 24px;">
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 24px; color: #10b981; margin-top: 2px;"></i>
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 4px 0; font-size: 15px; font-weight: 800; color: #065f46;">{{ session('success') }}</h4>
                        @if(session('approval_url'))
                            <p style="margin: 4px 0 10px 0; font-size: 13px; color: #047857; font-weight: 600;">
                                Link Persetujuan Waka Kesiswaan telah berhasil dibuat. Silakan kirimkan link di bawah kepada Waka Kesiswaan untuk verifikasi NIP & Password:
                            </p>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <input type="text" id="successApprovalUrlInput" value="{{ session('approval_url') }}" readonly class="form-control-custom" style="flex: 1; background: #ffffff; border-color: #a7f3d0; font-family: monospace; font-weight: 700; color: #065f46;">
                                <button type="button" onclick="copyLink(`{{ session('approval_url') }}`)" class="action-btn action-btn-copy" style="padding: 10px 16px; font-size: 12.5px;">
                                    <i class="fa-solid fa-copy"></i> Salin Link
                                </button>
                                @if(session('wa_waka_url'))
                                    <a href="{{ session('wa_waka_url') }}" target="_blank" class="action-btn action-btn-wa" style="padding: 10px 16px; font-size: 12.5px;">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA ke Waka Kesiswaan ({{ session('waka_nama') ?? 'Waka Kesiswaan' }})
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Input Dispensasi Siswa -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2><i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> Form Input Permohonan Dispensasi Siswa</h2>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Manual check & input oleh Guru Piket</span>
        </div>
        <div class="card-custom-body">
            <form id="formDispensasiSiswa" action="{{ route('piket.dispensasi-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden Inputs from Surat Dispen Pop-up Modal -->
                <input type="hidden" name="id_guru_piket_select" id="hiddenIdGuruPiket">
                <input type="hidden" name="nama_guru_piket" id="hiddenNamaGuruPiket">
                <input type="hidden" name="nip_guru_piket" id="hiddenNipGuruPiket">
                <input type="hidden" name="ttd_siswa_data" id="hiddenTtdSiswaData">
                <input type="hidden" name="ttd_guru_piket_data" id="hiddenTtdGuruPiketData">
                <input type="hidden" name="kode_dispen" id="hiddenKodeDispen">

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 18px;">
                    
                    <!-- Select Siswa -->
                    <div>
                        <label class="form-label-custom">Pilih Siswa Mengajukan Dispen <span style="color: #dc2626;">*</span></label>
                        <select name="id_siswa" id="selectSiswa" class="form-control-custom select2-search" required style="width: 100%;">
                            <option value="">-- Cari Nama Siswa / NISN / Kelas --</option>
                            @foreach($siswaList as $s)
                                @php
                                    $namaJurusan = $s->kelas->jurusan->nama_jurusan ?? ($s->kelas->nama_jurusan ?? 'Manajemen Perkantoran dan Layanan Bisnis');
                                @endphp
                                <option value="{{ $s->id_siswa }}" 
                                        data-nama="{{ $s->nama_siswa }}" 
                                        data-nisn="{{ $s->nisn ?? ($s->nis ?? '-') }}" 
                                        data-kelas="{{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }}"
                                        data-jurusan="{{ $namaJurusan }}"
                                        {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} - NISN: {{ $s->nisn ?? '-' }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Waka Kesiswaan Tujuan (Role Waka Kesiswaan) -->
                    <div>
                        <label class="form-label-custom">Pilih Waka Kesiswaan Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
                        <select name="id_user_waka" id="selectWaka" class="form-control-custom select2-search" required style="width: 100%;">
                            <option value="">-- Pilih Waka Kesiswaan (Nama, NIP, No HP) --</option>
                            @foreach($wakaList as $w)
                                <option value="{{ $w->id }}" {{ old('id_user_waka') == $w->id ? 'selected' : '' }}>
                                    {{ $w->name }} @if($w->nip) (NIP: {{ $w->nip }}) @endif @if($w->no_hp) - HP: {{ $w->no_hp }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 18px;">
                    <!-- Tanggal -->
                    <div>
                        <label class="form-label-custom">Tanggal Dispensasi <span style="color: #dc2626;">*</span></label>
                        <input type="date" name="tanggal" id="inputTanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control-custom" required>
                    </div>

                    <!-- Jam Keluar -->
                    <div>
                        <label class="form-label-custom">Rencana Jam Keluar <span style="color: #dc2626;">*</span></label>
                        <input type="time" name="jam_keluar" id="jamKeluarInput" value="{{ old('jam_keluar', '08:00') }}" class="form-control-custom" required>
                    </div>

                    <!-- Jam Kembali -->
                    <div>
                        <label class="form-label-custom">Rencana Jam Kembali <span style="color: #dc2626;">*</span></label>
                        <input type="time" name="jam_kembali" id="jamKembaliInput" value="{{ old('jam_kembali', '11:30') }}" class="form-control-custom" required>
                    </div>
                </div>

                <!-- Alasan Dispensasi -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label-custom">Alasan / Keperluan Dispensasi <span style="color: #dc2626;">*</span></label>
                    <textarea name="alasan" id="inputAlasan" rows="3" class="form-control-custom" placeholder="Tuliskan alasan lengkap siswa izin keluar sekolah (misal: Mengikuti Lomba OSN Tingkat Kabupaten, Berobat, Urusan Keluarga)..." required>{{ old('alasan') }}</textarea>
                </div>

                <!-- Tempat / Lokasi Kegiatan -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label-custom">Tempat / Lokasi Kegiatan Dispensasi <span style="color: #64748b; font-weight: 500;">(Opsional)</span></label>
                    <input type="text" name="tempat" id="inputTempat" class="form-control-custom" placeholder="Misal: Aula Dinas Pendidikan Kabupaten Tulungagung / Lapangan Olahraga / Rumah Sakit" value="{{ old('tempat') }}">
                </div>

                <!-- Input Hidden Foto Siswa Live Base64 dari Kamera (Wajib Live) -->
                <input type="hidden" name="foto_siswa_live" id="inputFotoSiswaLive" value="">

                <!-- Fitur Ambil Foto Siswa (wajib live) Sesuai media_1788699849946.png -->
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom" style="font-size: 13.5px; font-weight: 800; color: #1e293b; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span>Ambil Foto Siswa (wajib live) <span style="color: #dc2626;">*</span></span>
                        <span id="badgeFotoLiveStatus" style="display: none; font-size: 11.5px; font-weight: 700; color: #166534; background: #dcfce7; border: 1px solid #86efac; padding: 2px 8px; border-radius: 6px;">
                            <i class="fa-solid fa-circle-check"></i> Foto Live Terpasang
                        </span>
                    </label>

                    <div id="boxTriggerCamera" onclick="openLiveCameraModal()" style="width: 100%; min-height: 125px; background: #e5e7eb; border: 1.5px dashed #9ca3af; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; padding: 18px; box-sizing: border-box; position: relative;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#3b82f6';" onmouseout="if(!document.getElementById('inputFotoSiswaLive').value){ this.style.background='#e5e7eb'; this.style.borderColor='#9ca3af'; }">
                        
                        <!-- State Belum Ada Foto (Icon Kamera Besar Sesuai media_1788699849946.png) -->
                        <div id="cameraEmptyState" style="text-align: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 58px; height: 58px; margin: 0 auto; display: block;">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                            <div style="font-size: 13px; font-weight: 700; color: #334155; margin-top: 8px;">
                                Klik di sini untuk membuka kamera &amp; ambil foto siswa secara live
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                Wajib jepret langsung dari kamera perangkat (bukan file lokal) &bull; Otomatis terhubung ke Satpam &amp; WhatsApp
                            </div>
                        </div>

                        <!-- State Sudah Ada Foto Terjepret -->
                        <div id="cameraFilledState" style="display: none; width: 100%; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap;">
                            <img id="previewFotoSiswaLive" src="" alt="Foto Siswa Live" style="max-height: 140px; max-width: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #2563eb; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                            <div style="text-align: left;">
                                <div style="font-size: 13.5px; font-weight: 800; color: #166534; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-circle-check" style="font-size: 16px; color: #16a34a;"></i> Foto Siswa Berhasil Diambil Secara Live
                                </div>
                                <div style="font-size: 11.5px; color: #475569; margin: 4px 0 12px 0; font-weight: 600;">
                                    Foto siap tersimpan &amp; akan otomatis terkirim ke Portal Satpam saat Waka Kesiswaan menyetujui.
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <button type="button" onclick="event.stopPropagation(); openLiveCameraModal();" class="action-btn" style="background: #2563eb; color: #ffffff; padding: 7px 16px; font-size: 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-camera-rotate"></i> Foto Ulang
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); hapusFotoSiswaLive();" class="action-btn" style="background: #ef4444; color: #ffffff; padding: 7px 16px; font-size: 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Upload Foto (Surat Dispen & Kartu Identitas / Pelajar) -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div>
                        <label class="form-label-custom">
                            <i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Upload Foto Surat Dispensasi Resmi <span style="color: #64748b; font-weight: 500;">(Opsional)</span>
                        </label>
                        <input type="file" name="foto_surat_dispen" accept="image/*" class="form-control-custom" style="background: #ffffff;">
                        <span style="font-size: 11px; color: #64748b;">Format: JPG, PNG, WEBP (Max 4MB)</span>
                    </div>

                    <div>
                        <label class="form-label-custom">
                            <i class="fa-solid fa-address-card" style="color: #10b981;"></i> Upload Foto Kartu Identitas Siswa / Kartu Pelajar <span style="color: #2563eb; font-weight: 700;">(Sangat Disarankan)</span>
                        </label>
                        <input type="file" name="foto_kartu_identitas" accept="image/*" class="form-control-custom" style="background: #ffffff;">
                        <span style="font-size: 11px; color: #64748b;">Foto Kartu Pelajar untuk verifikasi Satpam di pintu gerbang sekolah.</span>
                    </div>
                </div>

                <!-- Action Buttons: Reset Form (Kiri) & Simpan Data (Kanan) -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                    <button type="button" onclick="resetFormDispensasiSiswa()" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Form</span>
                    </button>

                    <button type="button" onclick="openModalSuratDispenInput()" class="btn-submit-navy">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Simpan Data &amp; Buat Link Persetujuan Waka Kesiswaan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Daftar Siswa Dispensasi -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2><i class="fa-solid fa-table-list" style="color: #2563eb;"></i> Daftar Data Siswa Dispensasi (Total: {{ $totalPengajuan }})</h2>
        </div>

        <!-- Filter Bar -->
        <div style="padding: 16px 24px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <form action="{{ route('piket.dispensasi-siswa') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama Siswa, NISN, Kode..." class="form-control-custom" style="width: 240px; background: #ffffff;">
                <select name="status" class="form-control-custom" style="width: 200px; background: #ffffff;">
                    <option value="">-- Semua Status Waka Kesiswaan --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Waka Kesiswaan</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Waka Kesiswaan</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak Waka Kesiswaan</option>
                </select>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control-custom" style="width: 160px; background: #ffffff;">
                <button type="submit" class="action-btn action-btn-copy" style="padding: 9px 16px;"><i class="fa-solid fa-filter"></i> Filter</button>
                <a href="{{ route('piket.dispensasi-siswa') }}" class="action-btn" style="background: #e2e8f0; color: #475569; padding: 9px 16px;"><i class="fa-solid fa-rotate"></i> Reset</a>
                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="action-btn" style="background: #dc2626; color: #ffffff; padding: 9px 16px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap; width: auto; height: auto;" title="Hapus Data Terpilih">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
                <a href="{{ route('piket.dispensasi-siswa.trash') }}" class="action-btn" style="background: #ef4444; color: #ffffff; padding: 9px 16px; font-weight: 700; text-decoration: none; margin-left: auto;" title="Lihat Data Terhapus di Sampah">
                    <i class="fa-solid fa-trash-can"></i> Sampah
                    @php
                        $trashCount = \App\Models\SiswaDispen::onlyTrashed()->count();
                    @endphp
                    @if($trashCount > 0)
                        <span style="background: #ffffff; color: #ef4444; font-size: 11px; padding: 1px 6px; border-radius: 10px; font-weight: 800; margin-left: 4px;">{{ $trashCount }}</span>
                    @endif
                </a>
            </form>
        </div>

        <div class="card-custom-body" style="padding: 0; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #334155; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 14px 18px; width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th style="padding: 14px 18px; font-weight: 800;">KODE & SISWA</th>
                        <th style="padding: 14px 18px; font-weight: 800;">TANGGAL & JAM</th>
                        <th style="padding: 14px 18px; font-weight: 800;">ALASAN DISPEN</th>
                        <th style="padding: 14px 18px; font-weight: 800;">FOTO SISWA / IDENTITAS / SURAT</th>
                        <th style="padding: 14px 18px; font-weight: 800;">WAKA KESISWAAN</th>
                        <th style="padding: 14px 18px; font-weight: 800;">STATUS WAKA KESISWAAN</th>
                        <th style="padding: 14px 18px; font-weight: 800; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenList as $d)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 14px 18px; text-align: center;">
                                <input type="checkbox" class="dispen-checkbox" value="{{ $d->id_siswa_dispen }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            </td>
                            <td style="padding: 14px 18px;">
                                <div style="font-family: monospace; font-weight: 800; color: #2563eb;">{{ $d->kode_dispen }}</div>
                                <div style="font-weight: 700; color: #0f172a; margin-top: 2px;">{{ $d->siswa->nama_siswa ?? '-' }}</div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">Kelas {{ $d->kelas->nama_kelas ?? '-' }}</div>
                            </td>
                            <td style="padding: 14px 18px;">
                                <div style="font-weight: 700; color: #334155;"><i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i> {{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</div>
                                <div style="font-size: 12px; color: #d97706; font-weight: 700; margin-top: 2px;">
                                    <i class="fa-regular fa-clock"></i> {{ $d->jam_keluar ?? '00:00' }} s/d {{ $d->jam_kembali ?? '00:00' }}
                                </div>
                            </td>
                            <td style="padding: 14px 18px; max-width: 200px;">
                                <div style="color: #334155; font-weight: 600; background: #f8fafc; padding: 6px 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 12px;">
                                    "{{ $d->alasan }}"
                                </div>
                            </td>
                            <td style="padding: 14px 18px;">
                                <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                    @if($d->foto_siswa_live)
                                        <a href="{{ asset($d->foto_siswa_live) }}" target="_blank" title="Lihat Foto Live Siswa (Kamera Pos Piket)">
                                            <div style="position: relative; display: inline-block;">
                                                <img src="{{ asset($d->foto_siswa_live) }}" style="width: 42px; height: 42px; object-fit: cover; border-radius: 8px; border: 2px solid #2563eb; box-shadow: 0 2px 6px rgba(37,99,235,0.25);">
                                                <span style="position: absolute; bottom: -3px; right: -3px; background: #2563eb; color: #fff; font-size: 7.5px; padding: 1px 3px; border-radius: 3px; font-weight: 800; line-height: 1;"><i class="fa-solid fa-camera"></i> LIVE</span>
                                            </div>
                                        </a>
                                    @endif
                                    @if($d->foto_kartu_identitas)
                                        <a href="{{ asset($d->foto_kartu_identitas) }}" target="_blank" title="Lihat Foto Kartu Pelajar">
                                            <img src="{{ asset($d->foto_kartu_identitas) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                        </a>
                                    @endif
                                    @if($d->foto_surat_dispen)
                                        <a href="{{ asset($d->foto_surat_dispen) }}" target="_blank" title="Lihat Foto Surat Dispensasi">
                                            <img src="{{ asset($d->foto_surat_dispen) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #10b981;">
                                        </a>
                                    @endif
                                    @if(!$d->foto_siswa_live && !$d->foto_kartu_identitas && !$d->foto_surat_dispen)
                                        <span style="font-size: 11.5px; color: #94a3b8; font-style: italic;">Tanpa Foto</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 14px 18px;">
                                <div style="font-weight: 700; color: #1e293b;">{{ $d->nama_waka ?? ($d->wakaUser->name ?? '-') }}</div>
                                @if($d->nip_waka)
                                    <div style="font-size: 11px; color: #64748b;">NIP. {{ $d->nip_waka }}</div>
                                @endif
                            </td>
                            <td style="padding: 14px 18px;">
                                @if($d->status_waka === 'approved')
                                    <span class="badge-status badge-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                                @elseif($d->status_waka === 'rejected')
                                    <span class="badge-status badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                @else
                                    <span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                @endif
                            </td>
                            <td style="padding: 14px 18px; text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    @php
                                        $appUrl = url("/approval/dispen/{$d->token_wali_kelas}");
                                        $hpWaka = $d->no_hp_waka ?? ($d->wakaUser->no_hp ?? null);
                                        $waWakaLink = null;
                                        if ($hpWaka) {
                                            $hpFmt = preg_replace('/[^0-9]/', '', $hpWaka);
                                            if (str_starts_with($hpFmt, '0')) $hpFmt = '62' . substr($hpFmt, 1);
                                             $msgWa = "*PERMOHONAN PERSETUJUAN DISPENSASI SISWA*\n"
                                                . "Halo Bapak/Ibu Waka Kesiswaan,\nAda permohonan dispensasi siswa (Kode: {$d->kode_dispen}, Siswa: " . ($d->siswa->nama_siswa ?? '-') . ").\nMohon verifikasi di link berikut:\n{$appUrl}";
                                            $waWakaLink = "https://api.whatsapp.com/send?phone={$hpFmt}&text=" . urlencode($msgWa);
                                        }
                                    @endphp

                                    @if($waWakaLink && $d->status_waka === 'pending')
                                        <a href="{{ $waWakaLink }}" target="_blank" class="action-btn action-btn-wa" title="Kirim WA ke Waka Kesiswaan">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif

                                    <button type="button" onclick="copyLink(`{{ $appUrl }}`)" class="action-btn action-btn-copy" title="Salin Link Approval Waka Kesiswaan">
                                        <i class="fa-solid fa-link"></i> Link
                                    </button>

                                    <button type="button" onclick="showDetailModal({{ json_encode($d) }})" class="action-btn" style="background: #384972; color: #fff;" title="Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    @if($d->status_waka === 'approved')
                                        <button type="button" onclick="showBarcodeModal({{ json_encode($d) }})" class="action-btn action-btn-barcode" title="Lihat Barcode Dispen (Sekali Pakai)">
                                            <i class="fa-solid fa-qrcode"></i> Barcode
                                        </button>
                                    @endif

                                    @if($d->status_waka === 'pending')
                                        <button type="button" onclick="showEditModal({{ json_encode($d) }})" class="action-btn action-btn-edit" title="Edit Data Dispensasi">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    @endif

                                    <form action="{{ route('piket.dispensasi-siswa.destroy', $d->id_siswa_dispen) }}" method="POST" style="display: inline;" onsubmit="return confirm('Pindahkan data dispensasi siswa ini ke Sampah?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete" title="Pindahkan ke Sampah">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 30px; text-align: center; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-folder-open fa-2x" style="color: #94a3b8; margin-bottom: 8px;"></i><br>
                                Belum ada data permohonan dispensasi siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dispenList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0;">
                {{ $dispenList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Live Camera Capture (Wajib Live dari Kamera Perangkat) -->
<div id="liveCameraModal" class="modal-backdrop-custom" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(8px); z-index: 100000; align-items: center; justify-content: center; padding: 16px;">
    <div class="modal-card" style="max-width: 580px; width: 100%; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); border: 1px solid #334155;">
        <!-- Header -->
        <div class="modal-header" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #ffffff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #334155;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #2563eb; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(37,99,235,0.4);">
                    <i class="fa-solid fa-camera fa-lg" style="color: #ffffff;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; letter-spacing: -0.01em;">Ambil Foto Siswa Secara Live</h3>
                    <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Wajib live menggunakan kamera aktif (webcam/kamera HP)</span>
                </div>
            </div>
            <button type="button" onclick="closeLiveCameraModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; font-size: 20px; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" title="Tutup Kamera">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body" style="padding: 24px; text-align: center; background: #0b1120;">
            <!-- Alert / Error Camera -->
            <div id="cameraErrorAlert" style="display: none; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 16px; text-align: left;">
                <i class="fa-solid fa-triangle-exclamation"></i> <span id="cameraErrorMessage">Akses kamera gagal dibuka. Pastikan izin kamera telah diberikan di browser Anda.</span>
            </div>

            <!-- Viewport Container Kamera -->
            <div style="position: relative; width: 100%; aspect-ratio: 4/3; max-height: 380px; background: #000000; border-radius: 14px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: inset 0 0 25px rgba(0,0,0,0.8); border: 2px solid #1e293b;">
                <!-- Live Video Feed -->
                <video id="liveCameraVideo" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                
                <!-- Captured Snapshot Canvas (Hidden) -->
                <canvas id="liveCameraCanvas" style="display: none;"></canvas>

                <!-- Captured Image Preview (Shown after snap) -->
                <img id="liveCameraSnapshotPreview" src="" alt="Hasil Jepretan Siswa" style="display: none; width: 100%; height: 100%; object-fit: cover;">

                <!-- Framing Guide saat video aktif -->
                <div id="cameraFaceGuide" style="position: absolute; width: 180px; height: 230px; border: 2.5px dashed rgba(255,255,255,0.85); border-radius: 50%; pointer-events: none; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.35);">
                    <div style="position: absolute; bottom: -28px; width: 100%; text-align: center; color: #ffffff; font-size: 11px; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.9); letter-spacing: 0.3px;">
                        POSISI WAJAH SISWA
                    </div>
                </div>

                <!-- Status Badge Live -->
                <div id="cameraLiveBadge" style="position: absolute; top: 12px; left: 12px; background: rgba(220, 38, 38, 0.9); color: #ffffff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.4);">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff; display: inline-block; animation: pulseRed 1s infinite alternate;"></span> LIVE KAMERA
                </div>
            </div>

            <!-- Controls Area -->
            <div style="margin-top: 20px;">
                <!-- State 1: Streaming (Sebelum Jepret) -->
                <div id="cameraStreamControls" style="display: flex; gap: 12px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="switchCameraFacing()" id="btnSwitchCam" class="action-btn" style="background: #1e293b; color: #e2e8f0; border: 1px solid #334155; padding: 12px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer;" title="Putar Kamera Depan / Belakang">
                        <i class="fa-solid fa-camera-rotate"></i> Putar Kamera
                    </button>
                    <button type="button" onclick="takeSnapshotLive()" class="btn-submit-navy" style="padding: 13px 32px; font-size: 14.5px; background: #2563eb; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 16px rgba(37,99,235,0.4);">
                        <i class="fa-solid fa-camera"></i> Jepret Foto Siswa
                    </button>
                </div>

                <!-- State 2: Post-Snap (Setelah Jepret) -->
                <div id="cameraPreviewControls" style="display: none; gap: 12px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="retakeLiveSnapshot()" class="action-btn" style="background: #1e293b; color: #f1f5f9; border: 1px solid #475569; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-rotate-left"></i> Foto Ulang (Retake)
                    </button>
                    <button type="button" onclick="confirmLiveSnapshot()" class="btn-submit-navy" style="background: #16a34a; padding: 13px 28px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 4px 16px rgba(22,163,74,0.4);">
                        <i class="fa-solid fa-check"></i> Gunakan Foto Ini &amp; Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Dispensasi -->
<div id="detailModal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-id-card"></i> Detail Dispensasi Siswa</h3>
            <i class="fa-solid fa-xmark" onclick="closeDetailModal()" style="cursor: pointer; font-size: 18px;"></i>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Dynamic Content populated via JS -->
        </div>
    </div>
</div>

<!-- Modal Edit Dispensasi -->
<div id="editModal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header" style="background: #f59e0b;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-pen-to-square"></i> Edit Data Dispensasi Siswa</h3>
            <i class="fa-solid fa-xmark" onclick="closeEditModal()" style="cursor: pointer; font-size: 18px;"></i>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data" onsubmit="return validateTimeInput(this);">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Pilih Waka Kesiswaan Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
                    <select name="id_user_waka" id="editWaka" class="form-control-custom" required>
                        @foreach($wakaList as $w)
                            <option value="{{ $w->id }}">
                                {{ $w->name }} @if($w->nip) (NIP: {{ $w->nip }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                    <div>
                        <label class="form-label-custom">Tanggal <span style="color: #dc2626;">*</span></label>
                        <input type="date" name="tanggal" id="editTanggal" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Keluar <span style="color: #dc2626;">*</span></label>
                        <input type="time" name="jam_keluar" id="editJamKeluar" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Kembali <span style="color: #dc2626;">*</span></label>
                        <input type="time" name="jam_kembali" id="editJamKembali" class="form-control-custom" required>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Alasan Dispensasi <span style="color: #dc2626;">*</span></label>
                    <textarea name="alasan" id="editAlasan" rows="3" class="form-control-custom" required></textarea>
                </div>

                <!-- Foto Siswa Live Edit -->
                <input type="hidden" name="foto_siswa_live" id="editFotoSiswaLive" value="">
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Foto Siswa (Live Kamera)</label>
                    <div style="display: flex; gap: 12px; align-items: center; background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <img id="editPreviewFotoSiswaLive" src="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid #2563eb; display: none;">
                        <span id="editNoFotoText" style="font-size: 12px; color: #94a3b8; font-style: italic;">Belum ada foto live</span>
                        <button type="button" onclick="openLiveCameraModal('editFotoSiswaLive', 'editPreviewFotoSiswaLive')" class="action-btn" style="background: #2563eb; color: #ffffff; font-size: 11.5px; padding: 7px 12px; margin-left: auto; border-radius: 8px; cursor: pointer;">
                            <i class="fa-solid fa-camera"></i> Buka Kamera &amp; Foto Ulang
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="form-label-custom">Ganti Foto Surat Dispensasi Resmi (Opsional)</label>
                    <input type="file" name="foto_surat_dispen" accept="image/*" class="form-control-custom">
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Ganti Foto Kartu Identitas Siswa / Pelajar (Opsional)</label>
                    <input type="file" name="foto_kartu_identitas" accept="image/*" class="form-control-custom">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeEditModal()" class="action-btn" style="background: #e2e8f0; color: #475569;">Batal</button>
                    <button type="submit" class="action-btn action-btn-edit" style="padding: 10px 20px;"><i class="fa-solid fa-check"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Barcode Single-Use Dispensasi -->
<div id="barcodeModal" class="modal-backdrop-custom">
    <div class="modal-card">
        <div class="modal-header" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); color: #ffffff;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-qrcode"></i> Barcode Dispen Siswa (Sekali Pakai)</h3>
            <i class="fa-solid fa-xmark" onclick="closeBarcodeModal()" style="cursor: pointer; font-size: 18px;"></i>
        </div>
        <div class="modal-body" style="text-align: center;">
            <div id="barcodeModalContent">
                <!-- Dynamic Content populated via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-Up Lembar Surat Dispensasi Siswa (Format media_1788623102688.png) -->
<div id="modalSuratDispenInput" class="modal-backdrop-custom" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
    <div class="modal-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 740px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); position: relative; padding: 36px 42px; font-family: 'Times New Roman', Times, serif; color: #000000; box-sizing: border-box; max-height: 90vh; overflow-y: auto;">
        
        <button type="button" onclick="closeModalSuratDispenInput()" style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; font-size: 20px; color: #475569; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Tutup">&times;</button>

        <!-- Kop Surat Resmi SMKN 1 Boyolangu -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <img src="{{ asset('images/logo_sekolah.jpeg') }}" style="width: 80px; height: auto; object-fit: contain;" onerror="this.src='{{ asset('logo_sekolah.jpeg') }}'">
            <div style="flex: 1; text-align: center; line-height: 1.25;">
                <div style="font-size: 13.5px; font-weight: 700; letter-spacing: 0.5px;">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div style="font-size: 18px; font-weight: 900; letter-spacing: 1px; margin-top: 2px;">SMK NEGERI 1 BOYOLANGU</div>
                <div style="font-size: 12px; font-weight: 800; letter-spacing: 0.5px;">SEKOLAH KEJURUAN NEGERI UNGGULAN</div>
                <div style="font-size: 10.5px; margin-top: 3px; color: #1e293b;">Jl. Ki Mangunsarkoro VI/3, Beji, Kecamatan Boyolangu<br>Kabupaten Tulungagung, Jawa Timur 66233</div>
                <div style="font-size: 10px; color: #334155; margin-top: 2px;">Telp. (0355) 323021 / 323024 | Website: https://smkn1boyolangu.sch.id/</div>
                <div style="font-size: 10.5px; font-weight: 700;">NPSN: 20537286</div>
            </div>
            <div style="width: 80px;"></div>
        </div>

        <!-- Double Divider Line -->
        <div style="border-top: 3px solid #000000; border-bottom: 1px solid #000000; height: 3px; margin: 10px 0 18px 0;"></div>

        <!-- Judul Surat -->
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 14pt; font-weight: 900; text-decoration: underline; letter-spacing: 0.5px;">SURAT DISPENSASI SISWA</div>
            <div style="font-size: 11pt; margin-top: 4px;">Nomor: 421.3/<span id="suratKodeDispenSpan">DSP-...</span>/SMKN1.BYL/{{ date('Y') }}</div>
        </div>

        <!-- Tujuan / Kepada Yth -->
        <div style="font-size: 11.5pt; line-height: 1.5; margin-bottom: 12px;">
            Kepada Yth.<br>
            Bapak/Ibu Guru Piket<br>
            SMK Negeri 1 Boyolangu<br>
            di tempat
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; text-align: justify; margin-bottom: 10px;">
            Dengan hormat,<br>
            Berdasarkan permohonan izin dari orang tua/wali siswa dan sehubungan dengan keperluan kegiatan yang tidak dapat ditinggalkan, maka dengan ini kami mohon agar siswa berikut diberikan dispensasi (izin tidak mengikuti kegiatan pembelajaran) pada waktu yang telah ditentukan.
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; margin-bottom: 4px;">
            Adapun data siswa yang mengajukan dispensasi adalah sebagai berikut:
        </div>

        <!-- Tabel Data Siswa & Pasfoto Siswa Live -->
        <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 12px;">
            <table style="flex: 1; border-collapse: collapse; font-size: 11.5pt; padding-left: 10px;">
                <tr>
                    <td style="width: 170px; padding: 2.5px 0;">Nama</td>
                    <td style="width: 15px; text-align: center;">:</td>
                    <td style="font-weight: 700; text-transform: uppercase;" id="suratNamaSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">NISN</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratNisnSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">Kelas</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratKelasSiswaSpan">-</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0;">Program Keahlian</td>
                    <td style="text-align: center;">:</td>
                    <td id="suratJurusanSiswaSpan">-</td>
                </tr>
            </table>

            <div id="suratFotoLiveContainer" style="text-align: center; border: 1.5px solid #334155; padding: 4px; border-radius: 6px; background: #f8fafc; width: 85px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <img id="suratFotoLiveImg" src="" alt="Foto Siswa Live" style="width: 77px; height: 98px; object-fit: cover; border-radius: 4px; display: block;">
                <span style="font-size: 7.5pt; font-family: sans-serif; font-weight: 800; color: #1e3a8a; margin-top: 3px; display: block; letter-spacing: 0.5px;">LIVE FOTO</span>
            </div>
        </div>

        <div style="font-size: 11.5pt; line-height: 1.55; margin-bottom: 4px;">
            Untuk diberikan dispensasi agar tidak mengikuti proses kegiatan belajar mengajar di sekolah selama kegiatan berlangsung, dengan keterangan sebagai berikut:
        </div>

        <!-- Tabel Keterangan -->
        <table style="width: 100%; border-collapse: collapse; font-size: 11.5pt; margin-bottom: 14px; padding-left: 10px;">
            <tr>
                <td style="width: 170px; padding: 2.5px 0;">Hari / Tanggal</td>
                <td style="width: 15px; text-align: center;">:</td>
                <td id="suratHariTanggalSpan">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Pukul</td>
                <td style="text-align: center;">:</td>
                <td id="suratPukulSpan">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Keperluan</td>
                <td style="text-align: center;">:</td>
                <td id="suratKeperluanSpan" style="font-weight: 700;">-</td>
            </tr>
            <tr>
                <td style="padding: 2.5px 0;">Tempat</td>
                <td style="text-align: center;">:</td>
                <td id="suratTempatSpan">-</td>
            </tr>
        </table>

        <div style="font-size: 11.5pt; line-height: 1.55; text-align: justify; margin-bottom: 16px;">
            Demikian surat dispensasi ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </div>

        <!-- Tanggal Surat -->
        <div style="text-align: right; font-size: 11.5pt; margin-bottom: 8px;">
            Boyolangu, <span id="suratTanggalCetakSpan">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</span>
        </div>

        <!-- 2 Kolom Tanda Tangan: Guru Piket (Kiri) & Siswa (Kanan) - WAJIB DIISI -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; text-align: center; margin-top: 10px;">
            <!-- Left: Guru Piket -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="font-size: 11.5pt;">Hormat kami,</div>
                <div style="font-size: 11.5pt; font-weight: 700; margin-bottom: 4px;">Guru Piket</div>
                
                <!-- Dropdown Guru Piket dari TU Master Data dengan Fitur Cari & Reset Cari -->
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; text-align: left; width: 100%; margin-bottom: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label style="font-size: 11px; font-weight: 700; color: #334155;">
                            Pilih Guru Piket Bertugas: <span style="color: #dc2626;">*</span>
                        </label>
                        <span id="guruPiketSearchCount" style="font-size: 10.5px; color: #64748b; font-weight: 600;">(149 Guru)</span>
                    </div>

                    <!-- Input Fitur Cari Data Guru & Tombol Reset Cari -->
                    <div style="display: flex; gap: 6px; margin-bottom: 6px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #94a3b8;"></i>
                            <input type="text" id="modalSearchGuruPiketInput" placeholder="Ketik cari nama guru / NIP..." 
                                oninput="filterGuruPiketOptions(this.value)" 
                                style="width: 100%; padding: 6px 10px 6px 28px; font-size: 11.5px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s ease;">
                        </div>
                        <button type="button" onclick="resetSearchGuruPiket()" title="Reset Pencarian Guru" 
                            style="background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; transition: all 0.15s ease;">
                            <i class="fa-solid fa-rotate-left"></i> Reset Cari
                        </button>
                    </div>

                    <!-- Dropdown Select Guru Piket -->
                    <select id="modalSelectGuruPiket" class="form-control-custom" style="font-size: 12px; padding: 7px 10px; background: #f8fafc; width: 100%;" onchange="updateGuruPiketDisplay()">
                        <option value="">-- Pilih Guru Piket (Nama & NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" data-nama="{{ $g->nama_guru }}" data-nip="{{ $g->nip ?: '-' }}" {{ (Auth::check() && Auth::user()->nip == $g->nip) ? 'selected' : '' }}>
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Canvas TTD Guru Piket -->
                <div id="wrapperCanvasPiket" style="border: 2px dashed #94a3b8; border-radius: 8px; background: #ffffff; height: 110px; position: relative; cursor: crosshair; touch-action: none; width: 100%; box-sizing: border-box; transition: all 0.2s ease;">
                    <canvas id="modalCanvasPiket" style="width: 100%; height: 100%; display: block; border-radius: 6px;"></canvas>
                    <div id="modalHintPiket" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 11px; font-weight: 600; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i class="fa-solid fa-pen-nib" style="margin-right: 5px; color: #2563eb;"></i> Guru Piket tanda tangan di sini (sentuh / mouse)
                    </div>
                </div>

                <div style="margin-top: 6px;">
                    <div style="font-weight: 800; text-decoration: underline; font-size: 11.5pt;" id="suratNamaGuruPiketDisplay">Pilih Guru Piket</div>
                    <div style="font-size: 11pt; color: #1e293b;" id="suratNipGuruPiketDisplay">NIP. -</div>
                </div>
            </div>

            <!-- Right: Siswa -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="font-size: 11.5pt;">Yang mengajukan izin,</div>
                <div style="font-size: 11.5pt; font-weight: 700; margin-bottom: 4px;">Siswa</div>
                
                <!-- Spacer to balance dropdown & search box on left -->
                <div style="height: 74px;"></div>

                <!-- Canvas TTD Siswa -->
                <div id="wrapperCanvasSiswa" style="border: 2px dashed #94a3b8; border-radius: 8px; background: #ffffff; height: 110px; position: relative; cursor: crosshair; touch-action: none; width: 100%; box-sizing: border-box; transition: all 0.2s ease;">
                    <canvas id="modalCanvasSiswa" style="width: 100%; height: 100%; display: block; border-radius: 6px;"></canvas>
                    <div id="modalHintSiswa" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 11px; font-weight: 600; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i class="fa-solid fa-pen-nib" style="margin-right: 5px; color: #2563eb;"></i> Siswa tanda tangan di sini (sentuh / mouse)
                    </div>
                </div>

                <div style="margin-top: 6px;">
                    <div style="font-weight: 800; text-decoration: underline; font-size: 11.5pt;" id="suratNamaSiswaDisplay">-</div>
                    <div style="font-size: 11pt; color: #1e293b;" id="suratNisnSiswaDisplay">NISN. -</div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Bawah Modal -->
        <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; font-family: 'Plus Jakarta Sans', sans-serif;">
            <button type="button" onclick="closeModalSuratDispenInput()" class="action-btn" style="background: #e2e8f0; color: #334155; padding: 10px 18px; font-size: 13px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali / Batal
            </button>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="button" onclick="resetInputSignatures()" class="action-btn" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; padding: 10px 18px; font-size: 13px; font-weight: 700; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Tanda Tangan
                </button>

                <button type="button" onclick="submitFinalDispensasiForm()" class="btn-submit-navy" style="padding: 11px 24px; font-size: 13.5px; border-radius: 12px;">
                    <i class="fa-solid fa-link"></i> Simpan Data &amp; Buat Link Persetujuan Waka Kesiswaan
                </button>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-search').select2({
        placeholder: "Search / Pilih Data",
        allowClear: true
    });
    initGuruPiketOptionsCache();
});

// ─── Live Camera Capture System (Wajib Live dari Perangkat) ───────────────────
let currentCameraStream = null;
let currentFacingMode = 'user'; // 'user' (depan/webcam) atau 'environment' (belakang)
let currentCapturedBase64 = null;
let currentCameraTargetInput = 'inputFotoSiswaLive';
let currentCameraTargetPreview = 'previewFotoSiswaLive';

async function openLiveCameraModal(targetInputId = 'inputFotoSiswaLive', targetPreviewId = 'previewFotoSiswaLive') {
    currentCameraTargetInput = targetInputId;
    currentCameraTargetPreview = targetPreviewId;
    const modal = document.getElementById('liveCameraModal');
    if (!modal) return;
    
    modal.style.display = 'flex';
    document.getElementById('cameraErrorAlert').style.display = 'none';
    
    // Reset state tampilan modal
    document.getElementById('liveCameraVideo').style.display = 'block';
    document.getElementById('liveCameraSnapshotPreview').style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'block';
    document.getElementById('cameraLiveBadge').style.display = 'flex';
    document.getElementById('cameraStreamControls').style.display = 'flex';
    document.getElementById('cameraPreviewControls').style.display = 'none';
    
    await startCameraStream(currentFacingMode);
}

async function startCameraStream(facingMode) {
    stopCurrentCameraStream();
    
    try {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Browser atau perangkat ini tidak mendukung akses kamera secara langsung (getUserMedia tidak tersedia atau bukan koneksi HTTPS / Localhost).');
        }
        
        const constraints = {
            video: {
                facingMode: facingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: false
        };
        
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        currentCameraStream = stream;
        const video = document.getElementById('liveCameraVideo');
        video.srcObject = stream;
        await video.play();
    } catch (err) {
        console.error('Kamera Error:', err);
        const errAlert = document.getElementById('cameraErrorAlert');
        const errMsg = document.getElementById('cameraErrorMessage');
        let text = 'Gagal mengakses kamera perangkat: ' + (err.message || err.name);
        if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
            text = 'Akses izin kamera ditolak oleh browser. Silakan klik ikon gembok di sebelah kiri address bar URL browser Anda, pilih Izinkan (Allow) Akses Kamera, lalu coba buka kembali.';
        } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
            text = 'Tidak ditemukan perangkat kamera (webcam) yang aktif di komputer/laptop atau HP ini.';
        }
        errMsg.textContent = text;
        errAlert.style.display = 'block';
    }
}

function stopCurrentCameraStream() {
    if (currentCameraStream) {
        currentCameraStream.getTracks().forEach(track => track.stop());
        currentCameraStream = null;
    }
    const video = document.getElementById('liveCameraVideo');
    if (video) video.srcObject = null;
}

function closeLiveCameraModal() {
    stopCurrentCameraStream();
    const modal = document.getElementById('liveCameraModal');
    if (modal) modal.style.display = 'none';
}

async function switchCameraFacing() {
    currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
    await startCameraStream(currentFacingMode);
}

function takeSnapshotLive() {
    const video = document.getElementById('liveCameraVideo');
    const canvas = document.getElementById('liveCameraCanvas');
    if (!video || !video.videoWidth) {
        alert('Kamera belum siap atau streaming belum aktif. Silakan tunggu 1 detik lalu coba kembali.');
        return;
    }
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    
    // Jika mirror facing user
    if (currentFacingMode === 'user') {
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
    }
    
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    currentCapturedBase64 = canvas.toDataURL('image/jpeg', 0.9);
    
    // Tampilkan preview hasil jepretan
    const previewImg = document.getElementById('liveCameraSnapshotPreview');
    previewImg.src = currentCapturedBase64;
    previewImg.style.display = 'block';
    video.style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'none';
    document.getElementById('cameraLiveBadge').style.display = 'none';
    
    document.getElementById('cameraStreamControls').style.display = 'none';
    document.getElementById('cameraPreviewControls').style.display = 'flex';
}

function retakeLiveSnapshot() {
    currentCapturedBase64 = null;
    document.getElementById('liveCameraVideo').style.display = 'block';
    document.getElementById('liveCameraSnapshotPreview').style.display = 'none';
    document.getElementById('cameraFaceGuide').style.display = 'block';
    document.getElementById('cameraLiveBadge').style.display = 'flex';
    
    document.getElementById('cameraStreamControls').style.display = 'flex';
    document.getElementById('cameraPreviewControls').style.display = 'none';
}

function confirmLiveSnapshot() {
    if (!currentCapturedBase64) return;
    
    const targetInput = document.getElementById(currentCameraTargetInput);
    if (targetInput) targetInput.value = currentCapturedBase64;
    
    const targetPreview = document.getElementById(currentCameraTargetPreview);
    if (targetPreview) {
        targetPreview.src = currentCapturedBase64;
        targetPreview.style.display = 'block';
    }
    
    if (currentCameraTargetInput === 'inputFotoSiswaLive') {
        document.getElementById('cameraEmptyState').style.display = 'none';
        document.getElementById('cameraFilledState').style.display = 'flex';
        document.getElementById('badgeFotoLiveStatus').style.display = 'inline-flex';
        
        const box = document.getElementById('boxTriggerCamera');
        if (box) {
            box.style.background = '#f0fdf4';
            box.style.borderColor = '#16a34a';
            box.style.borderStyle = 'solid';
            box.style.boxShadow = 'none';
        }
    } else if (currentCameraTargetInput === 'editFotoSiswaLive') {
        const noFoto = document.getElementById('editNoFotoText');
        if (noFoto) noFoto.style.display = 'none';
    }
    
    closeLiveCameraModal();
}

function hapusFotoSiswaLive() {
    document.getElementById('inputFotoSiswaLive').value = '';
    document.getElementById('previewFotoSiswaLive').src = '';
    document.getElementById('cameraEmptyState').style.display = 'block';
    document.getElementById('cameraFilledState').style.display = 'none';
    document.getElementById('badgeFotoLiveStatus').style.display = 'none';
    
    const box = document.getElementById('boxTriggerCamera');
    if (box) {
        box.style.background = '#e5e7eb';
        box.style.borderColor = '#9ca3af';
        box.style.borderStyle = 'dashed';
    }
}

// Signature Pad Utility State
const padState = {};

function initSignaturePad(canvasId, hintId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    // Adjust canvas resolution to element width
    const rect = canvas.parentElement.getBoundingClientRect();
    canvas.width = rect.width || 320;
    canvas.height = 110;

    const ctx = canvas.getContext('2d');
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.strokeStyle = '#0f172a';

    let isDrawing = false;
    padState[canvasId] = { hasDrawn: false };

    function getPos(e) {
        const r = canvas.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: (clientX - r.left) * (canvas.width / r.width),
            y: (clientY - r.top) * (canvas.height / r.height)
        };
    }

    function start(e) {
        isDrawing = true;
        padState[canvasId].hasDrawn = true;
        const hint = document.getElementById(hintId);
        if (hint) hint.style.display = 'none';

        // Feedback visual saat mulai tanda tangan (border hijau)
        if (canvas.parentElement) {
            canvas.parentElement.style.borderColor = '#16a34a';
            canvas.parentElement.style.backgroundColor = '#f0fdf4';
        }

        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        if (e.cancelable && e.type.startsWith('touch')) e.preventDefault();
    }

    function move(e) {
        if (!isDrawing) return;
        const pos = getPos(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        if (e.cancelable && e.type.startsWith('touch')) e.preventDefault();
    }

    function stop() {
        if (isDrawing) {
            isDrawing = false;
        }
    }

    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', stop);

    canvas.addEventListener('touchstart', start, { passive: false });
    canvas.addEventListener('touchmove', move, { passive: false });
    window.addEventListener('touchend', stop);
}

function clearSignaturePad(canvasId, hintId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (padState[canvasId]) padState[canvasId].hasDrawn = false;
    const hint = document.getElementById(hintId);
    if (hint) hint.style.display = 'flex';
    if (canvas.parentElement) {
        canvas.parentElement.style.borderColor = '#94a3b8';
        canvas.parentElement.style.backgroundColor = '#ffffff';
    }
}

function resetInputSignatures() {
    clearSignaturePad('modalCanvasPiket', 'modalHintPiket');
    clearSignaturePad('modalCanvasSiswa', 'modalHintSiswa');
}

function formatTanggalIndo(dateStr) {
    if (!dateStr) return '-';
    const parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    const year = parts[0];
    const month = parseInt(parts[1], 10);
    const day = parseInt(parts[2], 10);
    
    const d = new Date(year, month - 1, day);
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    const hariNama = days[d.getDay()];
    const blnNama = months[month - 1];
    
    return `${hariNama}, ${day < 10 ? '0' + day : day} ${blnNama} ${year}`;
}

function formatHariIniIndo() {
    const d = new Date();
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const day = d.getDate();
    return `${day < 10 ? '0' + day : day} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

function generateRandomCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let res = '';
    for (let i = 0; i < 4; i++) {
        res += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    return `DSP-${y}${m}${d}-${res}`;
}

// Data Cache untuk Pencarian Guru Piket di Lembar Surat Dispen
let allGuruPiketData = [];

function initGuruPiketOptionsCache() {
    const select = document.getElementById('modalSelectGuruPiket');
    if (!select || allGuruPiketData.length > 0) return;

    allGuruPiketData = [];
    for (let i = 1; i < select.options.length; i++) {
        const opt = select.options[i];
        allGuruPiketData.push({
            value: opt.value,
            text: opt.textContent.trim(),
            nama: opt.getAttribute('data-nama') || '',
            nip: opt.getAttribute('data-nip') || '-',
            selected: opt.selected
        });
    }
}

function filterGuruPiketOptions(query) {
    initGuruPiketOptionsCache();
    const select = document.getElementById('modalSelectGuruPiket');
    const countEl = document.getElementById('guruPiketSearchCount');
    if (!select) return;

    const term = (query || '').toLowerCase().trim();
    const currentVal = select.value;

    // Bersihkan semua opsi kecuali placeholder awal
    while (select.options.length > 1) {
        select.remove(1);
    }

    let matchCount = 0;
    allGuruPiketData.forEach(item => {
        const match = !term ||
            item.text.toLowerCase().includes(term) ||
            item.nama.toLowerCase().includes(term) ||
            item.nip.toLowerCase().includes(term);

        if (match) {
            matchCount++;
            const opt = document.createElement('option');
            opt.value = item.value;
            opt.textContent = item.text;
            opt.setAttribute('data-nama', item.nama);
            opt.setAttribute('data-nip', item.nip);
            if (item.value === currentVal) {
                opt.selected = true;
            }
            select.appendChild(opt);
        }
    });

    if (countEl) {
        if (!term) {
            countEl.textContent = `(${allGuruPiketData.length} Guru)`;
            countEl.style.color = '#64748b';
        } else {
            countEl.textContent = `(${matchCount} ditemukan)`;
            countEl.style.color = matchCount > 0 ? '#166534' : '#dc2626';
        }
    }

    // Jika hanya cocok tepat 1 guru, otomatis pilihkan
    if (term && matchCount === 1) {
        select.selectedIndex = 1;
        updateGuruPiketDisplay();
    } else {
        updateGuruPiketDisplay();
    }
}

function resetSearchGuruPiket() {
    const searchInput = document.getElementById('modalSearchGuruPiketInput');
    if (searchInput) {
        searchInput.value = '';
    }
    filterGuruPiketOptions('');
}

function updateGuruPiketDisplay() {
    const sel = document.getElementById('modalSelectGuruPiket');
    if (sel && sel.selectedIndex > 0) {
        const opt = sel.options[sel.selectedIndex];
        document.getElementById('suratNamaGuruPiketDisplay').innerText = opt.getAttribute('data-nama') || '-';
        document.getElementById('suratNipGuruPiketDisplay').innerText = 'NIP. ' + (opt.getAttribute('data-nip') || '-');
    } else {
        document.getElementById('suratNamaGuruPiketDisplay').innerText = 'Pilih Guru Piket';
        document.getElementById('suratNipGuruPiketDisplay').innerText = 'NIP. -';
    }
}

/**
 * Reset Seluruh Pengisian Form Input Permohonan Dispensasi Siswa
 */
function resetFormDispensasiSiswa() {
    const form = document.getElementById('formDispensasiSiswa');
    if (form) {
        form.reset();
    }

    // Reset Select2 Siswa & Waka
    if (window.jQuery && $.fn.select2) {
        $('#selectSiswa').val('').trigger('change');
        $('#selectWaka').val('').trigger('change');
    }

    // Kembalikan default tanggal hari ini & jam standar
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    const todayStr = `${y}-${m}-${d}`;

    const inputTgl = document.getElementById('inputTanggal');
    if (inputTgl) inputTgl.value = todayStr;

    const jamKeluar = document.getElementById('jamKeluarInput');
    if (jamKeluar) jamKeluar.value = '08:00';

    const jamKembali = document.getElementById('jamKembaliInput');
    if (jamKembali) jamKembali.value = '11:30';

    const inputAlasan = document.getElementById('inputAlasan');
    if (inputAlasan) inputAlasan.value = '';

    const inputTempat = document.getElementById('inputTempat');
    if (inputTempat) inputTempat.value = '';

    // Reset Hidden Inputs
    document.getElementById('hiddenIdGuruPiket').value = '';
    document.getElementById('hiddenNamaGuruPiket').value = '';
    document.getElementById('hiddenNipGuruPiket').value = '';
    document.getElementById('hiddenTtdSiswaData').value = '';
    document.getElementById('hiddenTtdGuruPiketData').value = '';
    document.getElementById('hiddenKodeDispen').value = '';

    // Bersihkan file upload inputs
    if (form) {
        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(fi => fi.value = '');
    }

    // Reset modal signatures & search filter
    resetInputSignatures();
    resetSearchGuruPiket();
    hapusFotoSiswaLive();

    // Reset selected guru piket di modal
    const selPiket = document.getElementById('modalSelectGuruPiket');
    if (selPiket) {
        selPiket.selectedIndex = 0;
        updateGuruPiketDisplay();
    }
}

function openModalSuratDispenInput() {
    const selectSiswa = document.getElementById('selectSiswa');
    if (!selectSiswa.value) {
        alert('Silakan pilih Siswa yang mengajukan permohonan dispensasi terlebih dahulu!');
        $(selectSiswa).select2('open');
        return;
    }

    const selectWaka = document.getElementById('selectWaka');
    if (!selectWaka.value) {
        alert('Silakan pilih Waka Kesiswaan tujuan untuk persetujuan permohonan dispensasi!');
        $(selectWaka).select2('open');
        return;
    }

    const tgl = document.getElementById('inputTanggal').value;
    if (!tgl) {
        alert('Silakan tentukan Tanggal Dispensasi!');
        document.getElementById('inputTanggal').focus();
        return;
    }

    const jamKeluar = document.getElementById('jamKeluarInput').value;
    const jamKembali = document.getElementById('jamKembaliInput').value;
    if (!jamKeluar || !jamKembali) {
        alert('Silakan isi Rencana Jam Keluar dan Jam Kembali!');
        return;
    }

    if (jamKembali <= jamKeluar) {
        alert('Validasi Gagal!\n\nRencana Jam Kembali (' + jamKembali + ') harus lebih akhir daripada Rencana Jam Keluar (' + jamKeluar + ').');
        return;
    }

    const alasan = document.getElementById('inputAlasan').value.trim();
    if (!alasan) {
        alert('Silakan tuliskan Alasan / Keperluan dispensasi siswa!');
        document.getElementById('inputAlasan').focus();
        return;
    }

    // Validasi Wajib Foto Siswa Live dari Kamera Perangkat
    const fotoLive = document.getElementById('inputFotoSiswaLive').value;
    if (!fotoLive) {
        alert('Foto Siswa (Wajib Live) belum diambil!\n\nSilakan klik kotak "Ambil Foto Siswa (wajib live)" untuk membuka kamera dan memfoto langsung siswa yang izin dispensasi.');
        const triggerBox = document.getElementById('boxTriggerCamera');
        if (triggerBox) {
            triggerBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            triggerBox.style.borderColor = '#ef4444';
            triggerBox.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.25)';
        }
        return;
    }

    const tempat = document.getElementById('inputTempat').value.trim() || 'Aula Dinas Pendidikan Kabupaten Tulungagung';

    // Ambil Data Siswa dari opsi terpilih
    const opt = selectSiswa.options[selectSiswa.selectedIndex];
    const namaSiswa = opt.getAttribute('data-nama') || opt.text;
    const nisnSiswa = opt.getAttribute('data-nisn') || '-';
    const kelasSiswa = opt.getAttribute('data-kelas') || '-';
    const jurusanSiswa = opt.getAttribute('data-jurusan') || 'Manajemen Perkantoran dan Layanan Bisnis';

    // Kode Dispen
    let kode = document.getElementById('hiddenKodeDispen').value;
    if (!kode) {
        kode = generateRandomCode();
        document.getElementById('hiddenKodeDispen').value = kode;
    }

    // Isi Nilai ke Lembar Surat
    document.getElementById('suratKodeDispenSpan').innerText = kode;
    document.getElementById('suratNamaSiswaSpan').innerText = namaSiswa;
    document.getElementById('suratNisnSiswaSpan').innerText = nisnSiswa;
    document.getElementById('suratKelasSiswaSpan').innerText = kelasSiswa;
    document.getElementById('suratJurusanSiswaSpan').innerText = jurusanSiswa;
    document.getElementById('suratHariTanggalSpan').innerText = formatTanggalIndo(tgl);
    document.getElementById('suratPukulSpan').innerText = jamKeluar + ' WIB s.d. ' + jamKembali + ' WIB';
    document.getElementById('suratKeperluanSpan').innerText = alasan;
    document.getElementById('suratTempatSpan').innerText = tempat;

    // Tanda Tangan Siswa Info
    document.getElementById('suratNamaSiswaDisplay').innerText = namaSiswa;
    document.getElementById('suratNisnSiswaDisplay').innerText = 'NISN. ' + nisnSiswa;
    document.getElementById('suratTanggalCetakSpan').innerText = formatHariIniIndo();

    // Pasang Foto Siswa Live di Lembar Surat
    const containerFotoLive = document.getElementById('suratFotoLiveContainer');
    const imgFotoLive = document.getElementById('suratFotoLiveImg');
    if (fotoLive) {
        if (imgFotoLive) imgFotoLive.src = fotoLive;
        if (containerFotoLive) containerFotoLive.style.display = 'block';
    } else {
        if (containerFotoLive) containerFotoLive.style.display = 'none';
    }

    // Update Guru Piket & Inisialisasi Fitur Cari
    initGuruPiketOptionsCache();
    resetSearchGuruPiket();
    updateGuruPiketDisplay();

    // Tampilkan Modal
    document.getElementById('modalSuratDispenInput').style.display = 'flex';

    // Inisialisasi Canvas TTD
    setTimeout(() => {
        initSignaturePad('modalCanvasPiket', 'modalHintPiket');
        initSignaturePad('modalCanvasSiswa', 'modalHintSiswa');
    }, 150);
}

function closeModalSuratDispenInput() {
    document.getElementById('modalSuratDispenInput').style.display = 'none';
}

function submitFinalDispensasiForm() {
    const sel = document.getElementById('modalSelectGuruPiket');
    if (!sel || !sel.value) {
        alert('Validasi Gagal!\n\nSilakan pilih Guru Piket yang bertugas pada surat dispensasi ini!');
        if (sel) sel.focus();
        return;
    }

    // 1. Validasi Wajib Tanda Tangan Guru Piket
    const cPiket = document.getElementById('modalCanvasPiket');
    const piketHasDrawn = (cPiket && padState['modalCanvasPiket'] && padState['modalCanvasPiket'].hasDrawn);
    if (!piketHasDrawn) {
        const wrapPiket = document.getElementById('wrapperCanvasPiket');
        if (wrapPiket) {
            wrapPiket.style.borderColor = '#dc2626';
            wrapPiket.style.backgroundColor = '#fef2f2';
        }
        alert('Validasi Gagal!\n\nTanda tangan Guru Piket WAJIB diisi.\nSilakan Guru Piket melakukan tanda tangan pada kolom yang disediakan terlebih dahulu.');
        return;
    }

    // 2. Validasi Wajib Tanda Tangan Siswa
    const cSiswa = document.getElementById('modalCanvasSiswa');
    const siswaHasDrawn = (cSiswa && padState['modalCanvasSiswa'] && padState['modalCanvasSiswa'].hasDrawn);
    if (!siswaHasDrawn) {
        const wrapSiswa = document.getElementById('wrapperCanvasSiswa');
        if (wrapSiswa) {
            wrapSiswa.style.borderColor = '#dc2626';
            wrapSiswa.style.backgroundColor = '#fef2f2';
        }
        alert('Validasi Gagal!\n\nTanda tangan Siswa WAJIB diisi.\nSilakan Siswa yang mengajukan dispensasi melakukan tanda tangan pada kolom yang disediakan terlebih dahulu.');
        return;
    }

    const opt = sel.options[sel.selectedIndex];
    document.getElementById('hiddenIdGuruPiket').value = sel.value;
    document.getElementById('hiddenNamaGuruPiket').value = opt.getAttribute('data-nama') || '';
    document.getElementById('hiddenNipGuruPiket').value = opt.getAttribute('data-nip') || '-';

    // Simpan tanda tangan jika telah digambar
    document.getElementById('hiddenTtdSiswaData').value = cSiswa.toDataURL('image/png');
    document.getElementById('hiddenTtdGuruPiketData').value = cPiket.toDataURL('image/png');

    // Submit form permohonan
    document.getElementById('formDispensasiSiswa').submit();
}

function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Link Persetujuan Waka Kesiswaan berhasil disalin ke clipboard!\n\n' + url);
        }).catch(function(err) {
            fallbackCopyTextToClipboard(url);
        });
    } else {
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        alert('Link Persetujuan Waka Kesiswaan berhasil disalin ke clipboard!\n\n' + text);
    } catch (err) {
        alert('Gagal menyalin link. Silakan salin secara manual: ' + text);
    }
    document.body.removeChild(textArea);
}

function showDetailModal(data) {
    const siswaNama = data.siswa ? data.siswa.nama_siswa : '-';
    const kelasNama = data.kelas ? data.kelas.nama_kelas : '-';
    const wakaNama  = data.nama_waka ? data.nama_waka : (data.waka_user ? data.waka_user.name : '-');
    const nipWaka   = data.nip_waka ? data.nip_waka : '-';
    const appUrl    = `{{ url('/approval/dispen') }}/${data.token_wali_kelas}`;

    let statusBadge = '<span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu Waka Kesiswaan</span>';
    if (data.status_waka === 'approved') {
        statusBadge = '<span class="badge-status badge-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka Kesiswaan</span>';
    } else if (data.status_waka === 'rejected') {
        statusBadge = '<span class="badge-status badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka Kesiswaan</span>';
    }

    let notesHtml = '';
    if (data.status_waka === 'rejected') {
        notesHtml = `
            <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 10px; margin-top: 12px;">
                <div style="font-weight: 800; color: #991b1b; font-size: 12px; text-transform: uppercase;">Alasan Penolakan Waka Kesiswaan:</div>
                <div style="font-weight: 600; color: #7f1d1d; margin-top: 4px; font-size: 13.5px;">"${data.catatan_waka || 'Tanpa Alasan'}"</div>
            </div>
        `;
    }

    let fotoSiswaLiveHtml = '';
    if (data.foto_siswa_live) {
        fotoSiswaLiveHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11.5px; color: #2563eb; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">
                    <i class="fa-solid fa-camera"></i> Foto Siswa (Live Kamera Saat Izin Dispensasi)
                </div>
                <a href="{{ asset('') }}${data.foto_siswa_live}" target="_blank" title="Klik untuk perbesar Foto Live Siswa">
                    <img src="{{ asset('') }}${data.foto_siswa_live}" style="width: 100%; max-height: 240px; object-fit: contain; background: #eff6ff; border-radius: 10px; border: 2px solid #3b82f6; box-shadow: 0 4px 10px rgba(37,99,235,0.15);">
                </a>
                <div style="font-size: 11px; color: #166534; font-weight: 700; margin-top: 4px;">
                    <i class="fa-solid fa-circle-check"></i> Foto siswa diambil live di pos Guru Piket untuk dicocokkan Satpam di pintu gerbang.
                </div>
            </div>
        `;
    }

    let fotoKartuHtml = '';
    if (data.foto_kartu_identitas) {
        fotoKartuHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Foto Kartu Identitas Siswa / Pelajar</div>
                <a href="{{ asset('') }}${data.foto_kartu_identitas}" target="_blank">
                    <img src="{{ asset('') }}${data.foto_kartu_identitas}" style="width: 100%; max-height: 220px; object-fit: contain; background: #f8fafc; border-radius: 10px; border: 1px solid #cbd5e1;">
                </a>
            </div>
        `;
    }

    let fotoSuratHtml = '';
    if (data.foto_surat_dispen) {
        fotoSuratHtml = `
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Foto Surat Dispensasi Resmi</div>
                <a href="{{ asset('') }}${data.foto_surat_dispen}" target="_blank">
                    <img src="{{ asset('') }}${data.foto_surat_dispen}" style="width: 100%; max-height: 220px; object-fit: contain; background: #f8fafc; border-radius: 10px; border: 1px solid #cbd5e1;">
                </a>
            </div>
        `;
    }

    const html = `
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Kode Dispensasi</div>
            <div style="font-size: 18px; font-family: monospace; font-weight: 800; color: #2563eb;">${data.kode_dispen}</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Nama Siswa / Kelas</div>
            <div style="font-size: 15px; font-weight: 700; color: #0f172a;">${siswaNama} (${kelasNama})</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Tanggal & Rencana Jam</div>
            <div style="font-size: 14px; font-weight: 700; color: #334155;">${data.tanggal} (${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'})</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Alasan Dispensasi</div>
            <div style="font-size: 13.5px; background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600;">"${data.alasan}"</div>
        </div>
        ${fotoSiswaLiveHtml}
        ${fotoKartuHtml}
        ${fotoSuratHtml}
        ${data.ttd_siswa || data.ttd_guru_piket ? `
            <div style="margin-bottom: 14px; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">Tanda Tangan Digital</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: center;">
                    <div style="background: #ffffff; padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TTD Siswa</div>
                        ${data.ttd_siswa ? `<img src="{{ asset('') }}${data.ttd_siswa}" style="max-height: 60px; max-width: 100%; object-fit: contain;">` : '<span style="font-size: 11px; color: #94a3b8; font-style: italic;">Belum TTD</span>'}
                        <div style="font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px;">${siswaNama}</div>
                    </div>
                    <div style="background: #ffffff; padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TTD Guru Piket</div>
                        ${data.ttd_guru_piket ? `<img src="{{ asset('') }}${data.ttd_guru_piket}" style="max-height: 60px; max-width: 100%; object-fit: contain;">` : '<span style="font-size: 11px; color: #94a3b8; font-style: italic;">Belum TTD</span>'}
                        <div style="font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px;">${data.nama_guru_piket || 'Guru Piket'}</div>
                    </div>
                </div>
            </div>
        ` : ''}
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Waka Kesiswaan Tujuan</div>
            <div style="font-size: 14px; font-weight: 700; color: #1e293b;">${wakaNama} (NIP: ${nipWaka})</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Status Persetujuan Waka Kesiswaan</div>
            ${statusBadge}
        </div>
        ${notesHtml}
        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">
        <div>
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Link Approval Waka Kesiswaan</div>
            <div style="display: flex; gap: 8px;">
                <input type="text" value="${appUrl}" readonly class="form-control-custom" style="font-family: monospace; font-size: 12px;">
                <button type="button" onclick="copyLink('${appUrl}')" class="action-btn action-btn-copy"><i class="fa-solid fa-copy"></i> Salin Link</button>
            </div>
        </div>
    `;

    document.getElementById('modalDetailContent').innerHTML = html;
    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function showEditModal(data) {
    const actionUrl = `{{ url('/guru-piket/dispensasi-siswa') }}/${data.id_siswa_dispen}`;
    document.getElementById('editForm').action = actionUrl;

    document.getElementById('editWaka').value = data.id_user_waka;
    document.getElementById('editTanggal').value = data.tanggal;
    document.getElementById('editJamKeluar').value = data.jam_keluar ? data.jam_keluar.replace('.', ':') : '08:00';
    document.getElementById('editJamKembali').value = data.jam_kembali ? data.jam_kembali.replace('.', ':') : '11:30';
    document.getElementById('editAlasan').value = data.alasan;

    // Reset dan inisialisasi foto live siswa di modal edit
    document.getElementById('editFotoSiswaLive').value = '';
    const editImg = document.getElementById('editPreviewFotoSiswaLive');
    const noFotoText = document.getElementById('editNoFotoText');
    if (data.foto_siswa_live) {
        editImg.src = `{{ asset('') }}${data.foto_siswa_live}`;
        editImg.style.display = 'block';
        if (noFotoText) noFotoText.style.display = 'none';
    } else {
        editImg.src = '';
        editImg.style.display = 'none';
        if (noFotoText) noFotoText.style.display = 'inline';
    }

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function showBarcodeModal(data) {
    const siswaNama = data.siswa ? data.siswa.nama_siswa : '-';
    const kelasNama = data.kelas ? data.kelas.nama_kelas : '-';
    const qrUrl     = `https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=${encodeURIComponent(data.kode_dispen)}`;

    let statusBadge = '';
    if (data.status_satpam === 'belum_keluar') {
        statusBadge = `
            <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 8px 16px; border-radius: 20px; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> BARCODE AKTIF (Sekali Pakai)
            </div>
        `;
    } else {
        statusBadge = `
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 8px 16px; border-radius: 20px; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-lock" style="color: #dc2626;"></i> BARCODE SUDAH TERPAKAI / KADALUARSA
            </div>
        `;
    }

    let fotoKartuHtml = '';
    if (data.foto_kartu_identitas) {
        fotoKartuHtml = `
            <div style="margin-top: 14px; padding: 10px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;"><i class="fa-solid fa-address-card" style="color: #10b981;"></i> Foto Kartu Identitas / Pelajar:</div>
                <img src="{{ asset('') }}${data.foto_kartu_identitas}" style="max-height: 140px; border-radius: 6px; border: 1px solid #cbd5e1;">
            </div>
        `;
    }

    const html = `
        <div style="margin-bottom: 12px;">
            ${statusBadge}
        </div>

        <div style="font-size: 20px; font-family: monospace; font-weight: 800; color: #2563eb; margin-bottom: 4px;">${data.kode_dispen}</div>
        <div style="font-size: 16px; font-weight: 800; color: #0f172a;">${siswaNama}</div>
        <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelas ${kelasNama} | ${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'}</div>

        <div style="background: #ffffff; padding: 16px; border-radius: 16px; border: 2px dashed #2563eb; display: inline-block; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);">
            <img src="${qrUrl}" alt="QR Code Barcode Dispen" style="width: 210px; height: 210px; display: block;">
        </div>

        ${fotoKartuHtml}

        <div style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 12px 16px; border-radius: 10px; margin-top: 16px; text-align: left; font-size: 12px; color: #334155; font-weight: 600;">
            <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> <strong>Instruksi Alur Sistem:</strong><br>
            Siswa dapat mengambil foto Barcode ini. Saat berada di depan pintu gerbang sekolah, tunjukkan foto Barcode ini & Kartu Pelajar kepada Satpam untuk discan & divalidasi keluar.
        </div>
    `;

    document.getElementById('barcodeModalContent').innerHTML = html;
    document.getElementById('barcodeModal').style.display = 'flex';
}

function closeBarcodeModal() {
    document.getElementById('barcodeModal').style.display = 'none';
}

function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.dispen-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateSelectedState();
}

function updateSelectedState() {
    const checkboxes = document.querySelectorAll('.dispen-checkbox');
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:checked');
    const btnBulk = document.getElementById('btnBulkDelete');
    const selectedCountSpan = document.getElementById('selectedCount');
    const selectAllCb = document.getElementById('selectAllCheckbox');

    const count = checkedBoxes.length;
    if (selectedCountSpan) selectedCountSpan.textContent = count;

    if (selectAllCb && checkboxes.length > 0) {
        selectAllCb.checked = (checkboxes.length === count);
    }

    if (btnBulk) {
        if (count > 0) {
            btnBulk.style.opacity = '1';
            btnBulk.style.pointerEvents = 'auto';
        } else {
            btnBulk.style.opacity = '0.5';
            btnBulk.style.pointerEvents = 'none';
        }
    }
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan pilih minimal satu data dispensasi yang mau dihapus.');
        return;
    }

    document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

function executeBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.dispen-checkbox:checked');
    const container = document.getElementById('bulkDeleteInputsContainer');
    container.innerHTML = '';

    checkedBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });

    document.getElementById('bulkDeleteForm').submit();
}
</script>

<!-- Form Hidden untuk Hapus Massal -->
<form id="bulkDeleteForm" action="{{ route('piket.dispensasi-siswa.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal -->
<div id="bulkDeleteModal" class="modal-backdrop-custom">
    <div class="modal-card" style="max-width: 450px;">
        <div class="modal-header" style="background: #ef4444; color: #ffffff;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <i class="fa-solid fa-xmark" onclick="closeBulkDeleteModal()" style="cursor: pointer; font-size: 18px;"></i>
        </div>
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 28px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data dispensasi siswa yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" style="background: #e2e8f0; color: #475569; padding: 10px 20px; font-size: 13px; font-weight: 700; border: none; border-radius: 8px; cursor: pointer;">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" style="padding: 10px 24px; font-size: 13px; font-weight: 800; background: #ef4444; color: #ffffff; border: none; border-radius: 8px; cursor: pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
