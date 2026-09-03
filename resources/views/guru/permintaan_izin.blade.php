@extends('layouts.guru')

@section('title', 'Permintaan Izin Saya — EDU JOURNAL')

@section('styles')
<style>
    .page-title-box {
        margin-bottom: 24px;
    }

    .page-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-box p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
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
        padding: 11px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-create-link {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 26px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-create-link:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    /* Filter Bar Container Layout (Matching Piket Layout) */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
    }

    .filter-input:focus {
        border-color: #2563eb;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #1e293b; }

    .btn-trash-pink {
        background: #fce7f3;
        color: #db2777;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #fbcfe8;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        margin-left: auto;
    }
    .btn-trash-pink:hover { background: #fbcfe8; color: #be185d; }

    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px 18px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-badge.disetujui, .status-badge.approved { background: #dcfce7; color: #15803d; }
    .status-badge.menunggu, .status-badge.pending { background: #fef3c7; color: #b45309; }
    .status-badge.ditolak, .status-badge.rejected { background: #fee2e2; color: #b91c1c; }
    .status-badge.diproses { background: #e0f2fe; color: #0369a1; }

    .piket-notif-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 8px;
        font-size: 12.5px;
        color: #166534;
    }

    .piket-pending-box {
        background: #fffbe6;
        border: 1px solid #ffe58f;
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 8px;
        font-size: 12.5px;
        color: #873800;
    }

    /* Action Buttons (Matching Piket Role) */
    .btn-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-action-wa { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
    .btn-action-wa:hover { background: #bbf7d0; color: #14532d; }

    .btn-action-copy { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .btn-action-copy:hover { background: #dbeafe; }

    .btn-action-detail { background: #f8fafc; color: #475569; border-color: #cbd5e1; }
    .btn-action-detail:hover { background: #e2e8f0; color: #0f172a; }

    .btn-action-edit { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .btn-action-edit:hover { background: #fde68a; color: #92400e; }

    .btn-action-delete { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
    .btn-action-delete:hover { background: #fca5a5; color: #991b1b; }

    /* Modal Backdrop & Card */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 680px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: fadeInModal 0.2s ease;
    }

    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        background: #384972;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 { margin: 0; font-size: 17px; font-weight: 800; }

    .modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="page-title-box">
    <h1>Permintaan Izin Saya</h1>
    <p>Pengisian data izin tidak hadir mengajar untuk diverifikasi, diisikan, dan dikirimkan oleh Guru Piket ke Waka & Kepala Sekolah</p>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.12);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="background: #10b981; color: #fff; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #065f46;">
                        {{ session('success') }}
                    </h3>
                    <p style="margin: 2px 0 0 0; font-size: 13px; color: #047857; font-weight: 600;">
                        Data izin telah otomatis terkirim ke sistem Guru Piket dan siap diverifikasi & diisikan oleh Guru Piket.
                    </p>
                </div>
            </div>
        </div>

        @if(session('piket_link'))
            <div style="background: #ffffff; border: 1px solid #6ee7b7; border-radius: 12px; padding: 16px 20px; margin-top: 10px;">
                <label style="font-size: 12px; font-weight: 800; color: #065f46; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">
                    <i class="fa-solid fa-link"></i> Link Akses Halaman Guru Piket (Otomatis Terbuat):
                </label>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <input type="text" id="piketAccessUrlInput" value="{{ session('piket_link') }}" readonly style="flex: 1; min-width: 260px; padding: 11px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13.5px; color: #0f172a; font-weight: 700; font-family: monospace;">
                    
                    <button type="button" onclick="copyPiketLinkDirect('{{ session('piket_link') }}')" style="padding: 11px 18px; font-size: 13px; border-radius: 10px; font-weight: 700; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-copy"></i> Salin Link
                    </button>

                    @if(session('wa_url'))
                        <a href="{{ session('wa_url') }}" target="_blank" style="padding: 11px 20px; font-size: 13px; border-radius: 10px; font-weight: 700; background: #25d366; color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);">
                            <i class="fa-brands fa-whatsapp" style="font-size: 17px;"></i> Kirim Link ke WhatsApp Guru Piket
                        </a>
                    @endif
                </div>
                <small style="color: #047857; font-weight: 600; display: block; margin-top: 10px; font-size: 12px;">
                    <i class="fa-solid fa-circle-info"></i> Tautan di atas dapat Anda bagikan ke WhatsApp Guru Piket agar Guru Piket langsung masuk ke akun Guru Piket dan memvalidasi data izin Anda.
                </small>
            </div>
        @endif
    </div>
@endif

@if($errors->any())
    <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 700;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
    </div>
@endif

<!-- Form Buat Permintaan Izin -->
<div class="card-custom">
    <div class="card-custom-header">
        <h2>Buat Permintaan Izin / Cuti Guru</h2>
    </div>
    <div class="card-custom-body">
        <form id="formIzinGuru" action="{{ route('guru.permintaan-izin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 18px;">
                <div>
                    <label class="form-label-custom">Guru yang meminta izin</label>
                    <small style="color: #2563eb; font-weight: 700; display: block; margin-bottom: 6px;">
                        <i class="fa-solid fa-circle-info"></i> Fitur Cari: Ketik Nama atau NIP Guru pada kotak pilihan di bawah ini untuk mencari data guru mengajar.
                    </small>

                    @if($guru)
                        <input type="hidden" name="id_guru" value="{{ $guru->id_guru }}">
                        <input type="text" class="form-control-custom" value="[NIP. {{ $guru->nip ?? '-' }}] {{ $guru->nama_guru }}" readonly style="background: #f1f5f9; font-weight: 700; color: #1e293b;">
                    @else
                        <select name="id_guru" class="form-control-custom" required style="width: 100%;">
                            <option value="">Pilih NIP atau Nama Guru...</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">
                                    @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div>
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="selectKategoriIzin" class="form-control-custom" onchange="checkDurationCategory()" required>
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 18px;">
                <div>
                    <label class="form-label-custom">Tanggal Mulai Izin</label>
                    <input type="date" name="tanggal_mulai" id="inputTglMulai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()" required>
                </div>
                <div>
                    <label class="form-label-custom">Tanggal Selesai Izin</label>
                    <input type="date" name="tanggal_selesai" id="inputTglSelesai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()">
                </div>
            </div>

            <!-- Banner Notifikasi Cuti (> 3 Hari) -->
            <div id="bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; color: #c2410c; font-size: 13px; font-weight: 700;">
                <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Keterangan Khusus & mengunggah Dokumen Bukti Resmi Cuti!
            </div>

            <div style="margin-bottom: 18px;">
                <label class="form-label-custom">Alasan Umum Izin</label>
                <textarea name="alasan" id="alasan" class="form-control-custom" rows="3" placeholder="Tuliskan alasan umum tidak dapat mengajar..." required></textarea>
            </div>

            <!-- Container Keterangan Khusus Cuti (Wajib jika > 3 Hari / Kategori Cuti) -->
            <div id="keteranganKhususContainer" style="display: none; margin-bottom: 18px; background: #fff7ed; padding: 16px; border-radius: 12px; border: 1px solid #fed7aa;">
                <label class="form-label-custom" style="color: #c2410c; font-size: 13px;">
                    <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti / Izin Khusus (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                </label>
                <small style="color: #ea580c; display: block; margin-bottom: 8px;">
                    Tuliskan rincian penjelasan mengapa permohonan izin dilakukan lebih dari 3 hari (Cuti) agar Waka & Kepsek mengetahui dengan tepat alasannya.
                </small>
                <textarea name="keterangan_khusus" id="inputKeteranganKhusus" class="form-control-custom" rows="3" placeholder="Tuliskan penjelasan khusus permohonan Cuti / Izin Khusus..."></textarea>
            </div>

            <!-- Opsi Titipan & Lampiran Surat (Sama Seperti Form Piket) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" id="materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                </div>
                <div>
                    <label class="form-label-custom" id="labelFotoSurat">Upload Foto Surat / Bukti Izin <span style="color: #dc2626;">*Wajib Diunggah</span></label>
                    <input type="file" name="foto_surat" id="inputFotoSurat" class="form-control-custom" accept="image/*" required>
                </div>
            </div>

            <!-- Opsi File Tugas & Tujuan Guru Piket WA -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <div>
                    <label class="form-label-custom">Upload File Tugas (Opsional)</label>
                    <input type="file" name="file_tugas" class="form-control-custom">
                </div>
                <div>
                    <label class="form-label-custom">Tujuan Guru Piket Penerima WhatsApp (Opsional)</label>
                    <select name="wa_target_phone" id="wa_target_phone" class="form-control-custom">
                        <option value="">-- Pilih Guru Piket atau Petugas Piket --</option>
                        @foreach($piketUsers as $pu)
                            <option value="{{ $pu->no_hp ?? '' }}">{{ $pu->name }} (Role: {{ $pu->role_label }}) @if($pu->no_hp) - {{ $pu->no_hp }} @endif</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-create-link">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Permintaan Izin ke Guru Piket
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Riwayat & Status Permintaan Izin Saya -->
<div class="card-custom">
    <div class="card-custom-header" style="border-bottom: none;">
        <h2><i class="fa-solid fa-list-check" style="color: #2563eb; margin-right: 8px;"></i> Status Permintaan Izin Saya</h2>
        <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Total {{ $myIzinList->count() }} Pengajuan</span>
    </div>

    <!-- Filter & Search Bar + Reset + Sampah (Sejajar di Atas Tabel, Matching Piket Role) -->
    <div class="filter-bar-container">
        <form action="{{ route('guru.permintaan-izin') }}" method="GET">
            <div style="flex: 2; min-width: 220px;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Alasan, Titipan Materi..." style="width: 100%;">
            </div>

            <div>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" title="Filter Tanggal">
            </div>

            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>

            <a href="{{ route('guru.permintaan-izin') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>

            <a href="{{ route('guru.permintaan-izin.trash') }}" class="btn-trash-pink">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
            </a>
        </form>
    </div>

    <div class="card-custom-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>TANGGAL & KATEGORI</th>
                        <th>ALASAN & MATERI</th>
                        <th>STATUS PROSES PIKET</th>
                        <th>STATUS WAKA</th>
                        <th>STATUS WAKA SDM</th>
                        <th>STATUS KEPSEK</th>
                        <th>STATUS FINAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myIzinList as $iz)
                    @php
                        $piketAccessUrl = url('/guru-piket/permintaan-izin');
                        $tglFormat = ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                            ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y')
                            : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y');
                        
                        $waText = "*PERMINTAAN IZIN GURU MENGAJAR*\n"
                            . "----------------------------------\n"
                            . "*Pengaju:* " . ($iz->guru->nama_guru ?? Auth::user()->name) . " (NIP. " . ($iz->guru->nip ?? Auth::user()->nip ?? '-') . ")\n"
                            . "*Kategori:* " . ucfirst($iz->kategori_izin) . "\n"
                            . "*Tanggal:* " . $tglFormat . "\n"
                            . "*Alasan:* " . $iz->alasan . "\n"
                            . ($iz->materi_dititipkan ? "*Titipan Materi:* " . $iz->materi_dititipkan . "\n" : "")
                            . "----------------------------------\n"
                            . "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin melalui sistem Web EDU JOURNAL pada tautan berikut:\n"
                            . $piketAccessUrl;

                        $waSendUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($waText);

                        $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                        $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                        $detailData = [
                            'id_guru_izin' => $iz->id_guru_izin,
                            'id_guru' => $iz->id_guru,
                            'nama_guru' => $iz->guru->nama_guru ?? Auth::user()->name,
                            'nip' => $iz->guru->nip ?? Auth::user()->nip ?? '-',
                            'tanggal' => $tglFormat,
                            'tanggal_mulai' => $iz->tanggal_mulai,
                            'tanggal_selesai' => $iz->tanggal_selesai,
                            'durasi' => $iz->durasi,
                            'kategori_izin' => $iz->kategori_izin,
                            'alasan' => $iz->alasan,
                            'keterangan_khusus' => $iz->keterangan_khusus,
                            'materi' => $iz->materi_dititipkan,
                            'foto_url' => $iz->foto_url,
                            'file_tugas_url' => $iz->file_tugas_url,
                            'status_piket' => $iz->status_piket,
                            'nama_guru_piket' => $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Piket'),
                            'nip_guru_piket' => $iz->nip_guru_piket ?? ($iz->guruPiket->nip ?? '-'),
                            'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                            'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                            'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                            'catatan_waka' => $iz->catatan_waka,
                            'catatan_kepsek' => $iz->catatan_kepsek,
                            'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                            'piket_url' => $piketAccessUrl,
                        ];
                    @endphp
                    <tr>
                        <td style="white-space: nowrap;">
                            <div style="font-weight: 700; color: #1e293b;">
                                {{ $tglFormat }}
                            </div>
                            <div style="margin-top: 4px;">
                                @if($iz->kategori_izin === 'cuti')
                                    <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                        <i class="fa-solid fa-user-clock"></i> Cuti (>3 Hari)
                                    </span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                        Izin Biasa
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div style="color: #1e293b; font-weight: 600;">{{ $iz->alasan }}</div>
                            @if($iz->materi_dititipkan)
                                <div style="font-size: 11.5px; color: #475569; margin-top: 3px;">
                                    <i class="fa-solid fa-book"></i> Titipan: {{ $iz->materi_dititipkan }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($iz->status_piket === 'pending')
                                <span class="status-badge pending">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Menunggu Diproses Guru Piket
                                </span>
                                <div class="piket-pending-box">
                                    <i class="fa-solid fa-circle-info"></i> Menunggu Guru Piket memvalidasi & mengisikan data ke sistem.
                                </div>
                            @else
                                <span class="status-badge disetujui">
                                    <i class="fa-solid fa-circle-check"></i> Sudah Diisikan Guru Piket
                                </span>
                                <div class="piket-notif-box">
                                    <i class="fa-solid fa-user-shield"></i> Data izin telah diisikan & dikirim ke Waka/Kepsek oleh Guru Piket: <strong>{{ $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Piket') }}</strong> @if($iz->nip_guru_piket || ($iz->guruPiket->nip ?? null)) (NIP. {{ $iz->nip_guru_piket ?? $iz->guruPiket->nip }}) @endif.
                                </div>
                            @endif
                        </td>
                        <!-- Status Waka Kurikulum -->
                        <td>
                            @if($iz->status_waka === 'approved')
                                <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_waka === 'rejected')
                                <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                @if($iz->catatan_waka)
                                    <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">Ket: {{ $iz->catatan_waka }}</div>
                                @endif
                            @else
                                <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                        </td>
                        <!-- Status Waka SDM -->
                        <td>
                            @if($iz->status_waka_sdm === 'approved')
                                <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_waka_sdm === 'rejected')
                                <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                            @else
                                <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                        </td>
                        <!-- Status Kepsek -->
                        <td>
                            @if($iz->status_kepsek === 'approved')
                                <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_kepsek === 'rejected')
                                <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                @if($iz->catatan_kepsek)
                                    <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">Ket: {{ $iz->catatan_kepsek }}</div>
                                @endif
                            @else
                                <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                        </td>
                        <!-- Status Final -->
                        <td>
                            @if($isRejectedRow)
                                <span class="status-badge ditolak"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                            @elseif($isApprovedFullRow)
                                <span class="status-badge disetujui"><i class="fa-solid fa-circle-check"></i> Disetujui Full</span>
                            @else
                                <span class="status-badge menunggu"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ $waSendUrl }}" target="_blank" class="btn-action-btn btn-action-wa" title="Kirim Link ke WA Guru Piket">
                                    <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                </a>

                                <button type="button" onclick="copyPiketLinkDirect('{{ $piketAccessUrl }}')" class="btn-action-btn btn-action-copy" title="Salin Link Guru Piket">
                                    <i class="fa-solid fa-copy"></i> Salin Link
                                </button>

                                <button type="button" onclick="openDetailModal({{ json_encode($detailData) }})" class="btn-action-btn btn-action-detail" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                <button type="button" onclick="openEditModal({{ json_encode($detailData) }})" class="btn-action-btn btn-action-edit" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <form action="{{ route('guru.permintaan-izin.destroy', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data permohonan izin ini? Data yang dihapus akan dipindahkan ke Sampah dan notifikasi di Guru Piket akan otomatis terhapus/hilang.');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-btn btn-action-delete" title="Hapus ke Sampah">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 36px; color: #94a3b8; font-weight: 600;">
                            <i class="fa-solid fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                            Belum ada data permintaan izin tidak hadir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Permintaan Izin -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-invoice" style="margin-right: 8px;"></i> Detail Permintaan Izin Saya</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; border-radius: 12px; margin-bottom: 16px;">
                <div style="font-size: 14px; font-weight: 800; color: #0f172a;" id="dt_nama_guru">-</div>
                <div style="font-size: 12px; color: #64748b;" id="dt_nip">-</div>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 13px; color: #334155;">
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; width: 140px; color: #64748b;">Tanggal Izin:</td>
                    <td style="padding: 8px 0; font-weight: 700; color: #0f172a;" id="dt_tanggal_durasi">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Alasan Umum:</td>
                    <td style="padding: 8px 0;" id="dt_alasan">-</td>
                </tr>
                <tr id="dt_keterangan_khusus_container" style="display: none;">
                    <td style="padding: 8px 0; font-weight: 700; color: #c2410c;">Keterangan Cuti:</td>
                    <td style="padding: 8px 0; color: #c2410c; font-weight: 600;" id="dt_keterangan_khusus">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Titipan Materi:</td>
                    <td style="padding: 8px 0;" id="dt_materi">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Guru Piket:</td>
                    <td style="padding: 8px 0; font-weight: 700;" id="dt_status_piket">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Kepsek:</td>
                    <td style="padding: 8px 0;" id="dt_status_kepsek">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Waka:</td>
                    <td style="padding: 8px 0;" id="dt_status_waka">-</td>
                </tr>
            </table>

            <div id="dt_foto_container" style="display: none; margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 14px;">
                <label style="font-weight: 700; font-size: 12.5px; color: #475569; display: block; margin-bottom: 8px;">Dokumen / Foto Surat Bukti:</label>
                <a id="dt_foto_link" href="#" target="_blank">
                    <img id="dt_foto_img" src="" alt="Foto Surat Bukti" style="max-width: 100%; max-height: 200px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: contain;">
                </a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDetailModal()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit Permintaan Izin (Struktur Identik Presisi dengan Form Utama) -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 680px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="margin-right: 8px;"></i> Edit Permintaan Izin Saya</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="editForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <!-- Guru yang Meminta Izin (Readonly) -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Guru yang meminta izin</label>
                    <input type="text" id="edit_nama_guru" class="form-control-custom" readonly style="background: #f1f5f9; font-weight: 700; color: #1e293b;">
                </div>

                <!-- Kategori Izin -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="edit_kategori_izin" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>

                <!-- Tanggal Mulai & Selesai (Berdampingan Presisi) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label-custom">Tanggal Mulai Izin</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Tanggal Selesai Izin</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="checkEditDurationCategory()">
                    </div>
                </div>

                <!-- Banner Notifikasi Cuti (> 3 Hari) -->
                <div id="edit_bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; color: #c2410c; font-size: 13px; font-weight: 700;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Keterangan Khusus & mengunggah Dokumen Bukti Resmi Cuti!
                </div>

                <!-- Alasan Umum Izin -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Alasan Umum Izin</label>
                    <textarea name="alasan" id="edit_alasan" class="form-control-custom" rows="2" placeholder="Tuliskan alasan umum..." required></textarea>
                </div>

                <!-- Container Keterangan Khusus Cuti -->
                <div id="edit_keteranganKhususContainer" style="display: none; margin-bottom: 16px; background: #fff7ed; padding: 16px; border-radius: 12px; border: 1px solid #fed7aa;">
                    <label class="form-label-custom" style="color: #c2410c; font-size: 13px;">
                        <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti / Izin Khusus (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                    </label>
                    <small style="color: #ea580c; display: block; margin-bottom: 8px;">
                        Tuliskan rincian penjelasan mengapa permohonan izin dilakukan lebih dari 3 hari (Cuti) agar Waka & Kepsek mengetahui dengan tepat alasannya.
                    </small>
                    <textarea name="keterangan_khusus" id="edit_keterangan_khusus" class="form-control-custom" rows="2" placeholder="Tuliskan penjelasan khusus permohonan Cuti / Izin Khusus..."></textarea>
                </div>

                <!-- Opsi Titipan & Upload Foto Surat (Berdampingan Presisi) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                        <input type="text" name="materi_dititipkan" id="edit_materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                    </div>
                    <div>
                        <label class="form-label-custom" id="edit_labelFotoSurat">Upload Foto Surat / Bukti Izin Baru <span style="color: #dc2626;">*Wajib Diunggah</span></label>
                        <input type="file" name="foto_surat" id="edit_inputFotoSurat" class="form-control-custom" accept="image/*">
                        
                        <!-- Pratinjau Foto Bukti Terlampir -->
                        <div id="edit_foto_preview_container" style="display: none; margin-top: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 14px;">
                            <small style="font-size: 11.5px; font-weight: 800; color: #1e40af; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                <i class="fa-solid fa-image"></i> Foto Surat / Bukti Terlampir Saat Ini:
                            </small>
                            <a id="edit_foto_link" href="#" target="_blank">
                                <img id="edit_foto_img" src="" alt="Pratinjau Foto" style="max-height: 130px; border-radius: 8px; border: 1px solid #93c5fd; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upload File Tugas -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Upload File Tugas Baru (Opsional)</label>
                    <input type="file" name="file_tugas" class="form-control-custom">

                    <div id="edit_file_preview_container" style="display: none; margin-top: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px;">
                        <small style="font-size: 12px; color: #1e293b; font-weight: 700;">
                            <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Saat Ini: <a id="edit_file_link" href="#" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-create-link">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function checkDurationCategory() {
        const tMulai = document.getElementById('inputTglMulai').value;
        let tSelesai = document.getElementById('inputTglSelesai').value;
        const selectKat = document.getElementById('selectKategoriIzin');
        const bannerWarning = document.getElementById('bannerCutiWarning');
        const containerKhusus = document.getElementById('keteranganKhususContainer');
        const inputKhusus = document.getElementById('inputKeteranganKhusus');
        const labelFoto = document.getElementById('labelFotoSurat');
        const inputFoto = document.getElementById('inputFotoSurat');

        if (tMulai && tSelesai && tSelesai < tMulai) {
            alert('Peringatan: Tanggal Selesai Izin (' + tSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tMulai + ')!');
            document.getElementById('inputTglSelesai').value = tMulai;
            tSelesai = tMulai;
        }

        let diffDays = 1;
        if (tMulai && tSelesai) {
            const d1 = new Date(tMulai);
            const d2 = new Date(tSelesai);
            const diffTime = Math.abs(d2 - d1);
            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }

        if (inputFoto) {
            inputFoto.setAttribute('required', 'required');
        }

        if (diffDays > 3 || selectKat.value === 'cuti') {
            selectKat.value = 'cuti';
            bannerWarning.style.display = 'block';
            containerKhusus.style.display = 'block';
            inputKhusus.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti <span style="color: #dc2626;">*Wajib Diunggah</span>';
        } else {
            bannerWarning.style.display = 'none';
            containerKhusus.style.display = 'none';
            inputKhusus.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin <span style="color: #dc2626;">*Wajib Diunggah</span>';
        }
    }

    function checkEditDurationCategory() {
        const tMulai = document.getElementById('edit_tanggal_mulai').value;
        let tSelesai = document.getElementById('edit_tanggal_selesai').value || tMulai;
        const selectKat = document.getElementById('edit_kategori_izin');
        const bannerWarning = document.getElementById('edit_bannerCutiWarning');
        const containerKhusus = document.getElementById('edit_keteranganKhususContainer');
        const inputKhusus = document.getElementById('edit_keterangan_khusus');
        const labelFoto = document.getElementById('edit_labelFotoSurat');
        const inputFoto = document.getElementById('edit_inputFotoSurat');

        if (tMulai && tSelesai && tSelesai < tMulai) {
            alert('Peringatan: Tanggal Selesai Izin (' + tSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tMulai + ')!');
            document.getElementById('edit_tanggal_selesai').value = tMulai;
            tSelesai = tMulai;
        }

        let diffDays = 1;
        if (tMulai && tSelesai) {
            const d1 = new Date(tMulai);
            const d2 = new Date(tSelesai);
            const diffTime = Math.abs(d2 - d1);
            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }

        const hasFotoPreview = document.getElementById('edit_foto_preview_container') && document.getElementById('edit_foto_preview_container').style.display !== 'none';

        if (diffDays > 3 || selectKat.value === 'cuti') {
            selectKat.value = 'cuti';
            if (bannerWarning) bannerWarning.style.display = 'block';
            if (containerKhusus) containerKhusus.style.display = 'block';
            if (inputKhusus) inputKhusus.setAttribute('required', 'required');
            if (labelFoto) {
                labelFoto.innerHTML = hasFotoPreview 
                    ? 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                    : 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #dc2626;">*Wajib Diunggah</span>';
            }
        } else {
            if (bannerWarning) bannerWarning.style.display = 'none';
            if (containerKhusus) containerKhusus.style.display = 'none';
            if (inputKhusus) inputKhusus.removeAttribute('required');
            if (labelFoto) {
                labelFoto.innerHTML = hasFotoPreview 
                    ? 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                    : 'Upload Foto Surat / Bukti Izin Baru <span style="color: #dc2626;">*Wajib Diunggah</span>';
            }
        }
    }

    function copyPiketLinkDirect(text) {
        let tempTextArea = document.createElement("textarea");
        tempTextArea.value = text;
        tempTextArea.style.position = "fixed";
        tempTextArea.style.left = "-9999px";
        tempTextArea.style.top = "-9999px";
        document.body.appendChild(tempTextArea);
        tempTextArea.focus();
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999);

        try {
            let successful = document.execCommand('copy');
            if (successful) {
                alert('Link Akses Masuk Halaman Guru Piket berhasil disalin ke clipboard!');
            } else {
                prompt('Salin link berikut secara manual:', text);
            }
        } catch (err) {
            prompt('Salin link berikut secara manual:', text);
        }

        document.body.removeChild(tempTextArea);
    }

    function openDetailModal(data) {
        document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
        document.getElementById('dt_nip').innerText = 'NIP. ' + (data.nip || '-');
        document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari Full') + ')';
        document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
        document.getElementById('dt_materi').innerText = data.materi || '-';
        
        if (data.status_piket === 'pending') {
            document.getElementById('dt_status_piket').innerHTML = '<span style="color: #b45309;">⌛ Menunggu Diproses Guru Piket</span>';
        } else {
            document.getElementById('dt_status_piket').innerHTML = '<span style="color: #15803d;">✅ Sudah Diisikan oleh ' + (data.nama_guru_piket || 'Guru Piket') + ' (NIP. ' + (data.nip_guru_piket || '-') + ')</span>';
        }

        document.getElementById('dt_status_kepsek').innerText = (data.status_kepsek || 'Pending') + (data.catatan_kepsek ? ' (Ket: ' + data.catatan_kepsek + ')' : '');
        document.getElementById('dt_status_waka').innerText = (data.status_waka || 'Pending') + (data.catatan_waka ? ' (Ket: ' + data.catatan_waka + ')' : '');

        const ketKhususContainer = document.getElementById('dt_keterangan_khusus_container');
        if (data.kategori_izin === 'cuti' && data.keterangan_khusus) {
            document.getElementById('dt_keterangan_khusus').innerText = data.keterangan_khusus;
            ketKhususContainer.style.display = 'table-row';
        } else {
            ketKhususContainer.style.display = 'none';
        }

        const fotoContainer = document.getElementById('dt_foto_container');
        if (data.foto_url) {
            document.getElementById('dt_foto_img').src = data.foto_url;
            document.getElementById('dt_foto_link').href = data.foto_url;
            fotoContainer.style.display = 'block';
        } else {
            fotoContainer.style.display = 'none';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function openEditModal(data) {
        document.getElementById('editForm').action = "{{ url('/guru-permintaan-izin') }}/" + data.id_guru_izin;
        document.getElementById('edit_nama_guru').value = '[NIP. ' + (data.nip || '-') + '] ' + (data.nama_guru || 'Guru Mengajar');
        document.getElementById('edit_kategori_izin').value = data.kategori_izin || 'biasa';
        document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
        document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || data.tanggal_mulai;
        document.getElementById('edit_alasan').value = data.alasan;
        document.getElementById('edit_keterangan_khusus').value = data.keterangan_khusus || '';
        document.getElementById('edit_materi_dititipkan').value = data.materi || '';

        // Handle foto preview
        const fotoPreviewContainer = document.getElementById('edit_foto_preview_container');
        if (data.foto_url) {
            document.getElementById('edit_foto_img').src = data.foto_url;
            document.getElementById('edit_foto_link').href = data.foto_url;
            fotoPreviewContainer.style.display = 'block';
        } else {
            fotoPreviewContainer.style.display = 'none';
        }

        // Handle file tugas preview
        const filePreviewContainer = document.getElementById('edit_file_preview_container');
        if (data.file_tugas_url) {
            document.getElementById('edit_file_link').href = data.file_tugas_url;
            filePreviewContainer.style.display = 'block';
        } else {
            filePreviewContainer.style.display = 'none';
        }

        checkEditDurationCategory();
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkDurationCategory();

        const mainForm = document.getElementById('formIzinGuru');
        if (mainForm) {
            mainForm.addEventListener('submit', function(e) {
                const tMulai = document.getElementById('inputTglMulai').value;
                const tSelesai = document.getElementById('inputTglSelesai').value;
                if (tMulai && tSelesai && tSelesai < tMulai) {
                    e.preventDefault();
                    alert('Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.');
                    return false;
                }
            });
        }

        const editForm = document.getElementById('editForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const tMulai = document.getElementById('edit_tanggal_mulai').value;
                const tSelesai = document.getElementById('edit_tanggal_selesai').value;
                if (tMulai && tSelesai && tSelesai < tMulai) {
                    e.preventDefault();
                    alert('Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.');
                    return false;
                }
            });
        }
    });
</script>
@endsection
