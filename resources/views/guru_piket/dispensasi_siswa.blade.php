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

    .btn-submit-custom {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-submit-custom:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-1px);
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
</style>
@endsection

@section('content')
<div class="guru-izin-container">
    
    <!-- Top Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-id-card-clip" style="color: #2563eb;"></i> Dispensasi Siswa</h1>
            <p>Input data permohonan izin dispensasi siswa oleh Guru Piket & verifikasi persetujuan Waka</p>
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
                                Link Persetujuan Waka telah berhasil dibuat. Silakan kirimkan link di bawah kepada Waka untuk verifikasi NIP & Password:
                            </p>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <input type="text" id="successApprovalUrlInput" value="{{ session('approval_url') }}" readonly class="form-control-custom" style="flex: 1; background: #ffffff; border-color: #a7f3d0; font-family: monospace; font-weight: 700; color: #065f46;">
                                <button type="button" onclick="copyLink(`{{ session('approval_url') }}`)" class="action-btn action-btn-copy" style="padding: 10px 16px; font-size: 12.5px;">
                                    <i class="fa-solid fa-copy"></i> Salin Link
                                </button>
                                @if(session('wa_waka_url'))
                                    <a href="{{ session('wa_waka_url') }}" target="_blank" class="action-btn action-btn-wa" style="padding: 10px 16px; font-size: 12.5px;">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim WA ke Waka ({{ session('waka_nama') ?? 'Waka' }})
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
            <form action="{{ route('piket.dispensasi-siswa.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateTimeInput(this);">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 18px;">
                    
                    <!-- Select Siswa -->
                    <div>
                        <label class="form-label-custom">Pilih Siswa Mengajukan Dispen <span style="color: #dc2626;">*</span></label>
                        <select name="id_siswa" id="selectSiswa" class="form-control-custom select2-search" required style="width: 100%;">
                            <option value="">-- Cari Nama Siswa / NISN / Kelas --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->id_siswa }}" {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} - NISN: {{ $s->nisn ?? '-' }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Waka Tujuan (Hanya Akun Role Waka) -->
                    <div>
                        <label class="form-label-custom">Pilih Waka Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
                        <select name="id_user_waka" id="selectWaka" class="form-control-custom select2-search" required style="width: 100%;">
                            <option value="">-- Pilih Waka (Nama, NIP, No HP) --</option>
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
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control-custom" required>
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
                    <textarea name="alasan" rows="3" class="form-control-custom" placeholder="Tuliskan alasan lengkap siswa izin keluar sekolah (misal: Lomba OSN, Berobat, Urusan Keluarga)..." required>{{ old('alasan') }}</textarea>
                </div>

                <!-- Section Upload Foto (Surat Dispen & Kartu Identitas / Pelajar) -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 20px; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
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

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-submit-custom">
                        <i class="fa-solid fa-link"></i> Simpan Data & Buat Link Persetujuan Waka
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
                <select name="status" class="form-control-custom" style="width: 180px; background: #ffffff;">
                    <option value="">-- Semua Status Waka --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Waka</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Waka</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak Waka</option>
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
                        <th style="padding: 14px 18px; font-weight: 800;">FOTO IDENTITAS / SURAT</th>
                        <th style="padding: 14px 18px; font-weight: 800;">WAKA TUJUAN</th>
                        <th style="padding: 14px 18px; font-weight: 800;">STATUS WAKA</th>
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
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    @if($d->foto_kartu_identitas)
                                        <a href="{{ asset($d->foto_kartu_identitas) }}" target="_blank" title="Lihat Foto Kartu Pelajar">
                                            <img src="{{ asset($d->foto_kartu_identitas) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                        </a>
                                    @endif
                                    @if($d->foto_surat_dispen)
                                        <a href="{{ asset($d->foto_surat_dispen) }}" target="_blank" title="Lihat Foto Surat Dispensasi">
                                            <img src="{{ asset($d->foto_surat_dispen) }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #2563eb;">
                                        </a>
                                    @endif
                                    @if(!$d->foto_kartu_identitas && !$d->foto_surat_dispen)
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
                                                . "Halo Bapak/Ibu Waka,\nAda permohonan dispensasi siswa (Kode: {$d->kode_dispen}, Siswa: " . ($d->siswa->nama_siswa ?? '-') . ").\nMohon verifikasi di link berikut:\n{$appUrl}";
                                            $waWakaLink = "https://api.whatsapp.com/send?phone={$hpFmt}&text=" . urlencode($msgWa);
                                        }
                                    @endphp

                                    @if($waWakaLink && $d->status_waka === 'pending')
                                        <a href="{{ $waWakaLink }}" target="_blank" class="action-btn action-btn-wa" title="Kirim WA ke Waka">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif

                                    <button type="button" onclick="copyLink(`{{ $appUrl }}`)" class="action-btn action-btn-copy" title="Salin Link Approval Waka">
                                        <i class="fa-solid fa-link"></i> Link
                                    </button>

                                    <button type="button" onclick="showDetailModal({{ json_encode($d) }})" class="action-btn" style="background: #384972; color: #fff;" title="Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    @if($d->status_waka === 'approved')
                                        <button type="button" onclick="showBarcodeModal({{ json_encode($d) }})" class="action-btn" style="background: #7c3aed; color: #ffffff;" title="Lihat Barcode Dispen (Sekali Pakai)">
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
                    <label class="form-label-custom">Pilih Waka Tujuan (Persetujuan) <span style="color: #dc2626;">*</span></label>
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
        <div class="modal-header" style="background: #7c3aed;">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-search').select2({
        placeholder: "Search / Pilih Data",
        allowClear: true
    });
});

function validateTimeInput(form) {
    const jamKeluar = form.querySelector('[name="jam_keluar"]').value;
    const jamKembali = form.querySelector('[name="jam_kembali"]').value;

    if (jamKeluar && jamKembali) {
        if (jamKembali <= jamKeluar) {
            alert('Validasi Gagal!\n\nRencana Jam Kembali (' + jamKembali + ') harus lebih akhir daripada Rencana Jam Keluar (' + jamKeluar + ').');
            return false;
        }
    }
    return true;
}

function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Link Persetujuan Waka berhasil disalin ke clipboard!\n\n' + url);
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
        alert('Link Persetujuan Waka berhasil disalin ke clipboard!\n\n' + text);
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

    let statusBadge = '<span class="badge-status badge-pending"><i class="fa-solid fa-clock"></i> Menunggu Waka</span>';
    if (data.status_waka === 'approved') {
        statusBadge = '<span class="badge-status badge-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka</span>';
    } else if (data.status_waka === 'rejected') {
        statusBadge = '<span class="badge-status badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka</span>';
    }

    let notesHtml = '';
    if (data.status_waka === 'rejected') {
        notesHtml = `
            <div style="background: #fee2e2; border: 1px solid #fca5a5; padding: 12px; border-radius: 10px; margin-top: 12px;">
                <div style="font-weight: 800; color: #991b1b; font-size: 12px; text-transform: uppercase;">Alasan Penolakan Waka:</div>
                <div style="font-weight: 600; color: #7f1d1d; margin-top: 4px; font-size: 13.5px;">"${data.catatan_waka || 'Tanpa Alasan'}"</div>
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
        ${fotoKartuHtml}
        ${fotoSuratHtml}
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase;">Waka Tujuan</div>
            <div style="font-size: 14px; font-weight: 700; color: #1e293b;">${wakaNama} (NIP: ${nipWaka})</div>
        </div>
        <div style="margin-bottom: 14px;">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Status Persetujuan Waka</div>
            ${statusBadge}
        </div>
        ${notesHtml}
        <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">
        <div>
            <div style="font-size: 11.5px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Link Approval Waka</div>
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

        <div style="font-size: 20px; font-family: monospace; font-weight: 800; color: #7c3aed; margin-bottom: 4px;">${data.kode_dispen}</div>
        <div style="font-size: 16px; font-weight: 800; color: #0f172a;">${siswaNama}</div>
        <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelas ${kelasNama} | ${data.jam_keluar || '00:00'} s/d ${data.jam_kembali || '00:00'}</div>

        <div style="background: #ffffff; padding: 16px; border-radius: 16px; border: 2px dashed #7c3aed; display: inline-block; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.15);">
            <img src="${qrUrl}" alt="QR Code Barcode Dispen" style="width: 210px; height: 210px; display: block;">
        </div>

        ${fotoKartuHtml}

        <div style="background: #f3e8ff; border: 1px solid #d8b4fe; padding: 12px 16px; border-radius: 10px; margin-top: 16px; text-align: left; font-size: 12px; color: #6b21a8; font-weight: 600;">
            <i class="fa-solid fa-circle-info"></i> <strong>Instruksi Alur Sistem:</strong><br>
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
