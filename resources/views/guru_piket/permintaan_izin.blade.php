@extends('layouts.guru')

@section('title', 'Permintaan Izin Guru — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Teacher Select (NIP / Nama) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        margin-bottom: 4px;
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

    /* Style Override Select2 agar menyatu dengan UI modern */
    .select2-container--default .select2-selection--single {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        height: 44px;
        padding: 6px 8px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b;
        font-size: 13.5px;
        font-weight: 600;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }

    .btn-create-link {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 11px 22px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-create-link:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    /* Filter Bar Container Layout */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-input {
        padding: 9px 12px;
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

    /* Table Custom */
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
    
    .badge-cuti { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-biasa { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* Action Buttons */
    .btn-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 13px;
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
        max-width: 580px;
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
    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Permintaan Izin Guru</h1>
            <p>Verifikasi dan persetujuan pengajuan izin ketidakhadiran guru harian</p>
        </div>
    </div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>

    @if(session('approval_url'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 800; color: #065f46;">
                    <i class="fa-brands fa-whatsapp"></i> Link Persetujuan Otomatis Siap Kirim
                </h4>
                <p style="margin: 0; font-size: 12.5px; color: #047857;">
                    Klik tombol Kirim WhatsApp atau Salin Link di bawah untuk meneruskan ke Waka & Kepsek:
                </p>
                <div style="margin-top: 8px; background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #a7f3d0; font-family: monospace; font-size: 12px; color: #0f172a; word-break: break-all; user-select: all;">
                    {{ session('approval_url') }}
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                @if(session('wa_url'))
                    <a href="{{ session('wa_url') }}" target="_blank" class="btn-create-link" style="background: #25d366; color: #ffffff;">
                        <i class="fa-brands fa-whatsapp"></i> Kirim WhatsApp
                    </a>
                @endif
                <button type="button" class="btn-action-btn btn-action-copy" onclick="copyToClipboard('{{ session('approval_url') }}')" style="padding: 10px 16px;">
                    <i class="fa-regular fa-copy"></i> Salin Link
                </button>
            </div>
        </div>
    </div>
    @endif
@endif

@if($errors->any())
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-weight: 700;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
    </div>
@endif

<!-- Banner Permintaan Izin Guru Mengajar Baru -->
@if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
    <div style="background: #fffbe6; border: 2px solid #ffe58f; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(250, 173, 20, 0.15);">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="background: #faad14; color: #fff; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                    <i class="fa-solid fa-bell-ring"></i>
                </span>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #873800;">
                        Ada <span id="pendingCountText">{{ $pendingRequests->count() }}</span> Permintaan Izin Guru Mengajar Baru yang Belum Diproses!
                    </h3>
                    <p style="margin: 2px 0 0 0; font-size: 12.5px; color: #d48806; font-weight: 600;">
                        Guru Mengajar mengirimkan data izin melalui sistem web. Klik "Isi Otomatis ke Form & Proses" untuk mengecek, mengvalidasi, dan mengisikan data izin ke sistem.
                    </p>
                </div>
            </div>
            <span style="background: #ffffff; border: 1px solid #ffe58f; color: #d48806; font-size: 12px; font-weight: 800; padding: 6px 14px; border-radius: 20px;">
                <i class="fa-solid fa-hourglass-start"></i> Menunggu Verifikasi Piket
            </span>
        </div>

        <!-- Filter & Search Bar untuk Notifikasi Permintaan Izin Baru -->
        <div style="background: #ffffff; border: 1px solid #ffd591; border-radius: 12px; padding: 10px 14px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 240px; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #d48806; font-size: 13px;"></i>
                <input type="text" id="searchPendingInput" onkeyup="filterPendingRequests()" placeholder="Cari Nama Guru Pengaju, NIP, Alasan, Titipan..." style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid #ffe58f; border-radius: 8px; font-size: 12.5px; font-weight: 600; color: #1e293b; outline: none; background: #fffbe6;">
            </div>
            <button type="button" onclick="resetPendingFilter()" style="padding: 8px 14px; font-size: 12px; font-weight: 700; background: #fff1b8; color: #873800; border: 1px solid #ffe58f; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
                <i class="fa-solid fa-rotate-left"></i> Reset Cari
            </button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;" id="pendingRequestsContainer">
            @foreach($pendingRequests as $pReq)
                <div class="pending-request-card" style="background: #ffffff; border: 1px solid #ffd591; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="font-size: 14px; font-weight: 800; color: #1e293b;">
                            <i class="fa-solid fa-user-circle" style="color: #2563eb;"></i> {{ $pReq->guru->nama_guru ?? 'Guru' }} @if($pReq->guru->nip ?? null) <span style="font-size: 12px; color: #64748b; font-weight: 600;">(NIP. {{ $pReq->guru->nip }})</span> @endif
                        </div>
                        <div style="font-size: 12.5px; color: #475569; margin-top: 4px;">
                            <strong>Kategori & Tanggal:</strong> 
                            <span class="badge-biasa" style="padding: 2px 8px; font-size: 11px;">{{ ucfirst($pReq->kategori_izin) }}</span>
                            ({{ \Carbon\Carbon::parse($pReq->tanggal_mulai)->format('d-m-Y') }} @if($pReq->tanggal_selesai && $pReq->tanggal_selesai !== $pReq->tanggal_mulai) s/d {{ \Carbon\Carbon::parse($pReq->tanggal_selesai)->format('d-m-Y') }} @endif)
                        </div>
                        <div style="font-size: 12.5px; color: #334155; margin-top: 4px;">
                            <strong>Alasan:</strong> "{{ $pReq->alasan }}"
                            @if($pReq->materi_dititipkan) | <strong>Titipan Materi:</strong> {{ $pReq->materi_dititipkan }} @endif
                        </div>
                    </div>
                    <div>
                        <button type="button" onclick="isiOtomatisForm({{ json_encode($pReq) }})" class="btn-create-link" style="padding: 9px 18px; font-size: 12.5px; background: #faad14; border-color: #d48806; box-shadow: 0 4px 10px rgba(250, 173, 20, 0.3);">
                            <i class="fa-solid fa-square-check"></i> Isi Otomatis ke Form & Proses
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Form Buat Permintaan Izin -->
<div class="card-custom">
    <div class="card-custom-header">
        <h2>Buat Permintaan Izin / Cuti Guru</h2>
    </div>
    <div class="card-custom-body">
        <form action="{{ route('piket.permintaan-izin.store') }}" method="POST" enctype="multipart/form-data" id="formBuatIzin">
            @csrf
            <input type="hidden" name="id_guru_izin_pengajuan" id="id_guru_izin_pengajuan" value="">

            <div id="infoIsiOtomatis" style="display: none; background: #e0f2fe; border: 1px solid #7dd3fc; color: #0369a1; padding: 12px 16px; border-radius: 10px; margin-bottom: 18px; font-size: 13px; font-weight: 700;">
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 18px;">
                <div>
                    <label class="form-label-custom">Guru yang meminta izin</label>
                    <small style="color: #2563eb; font-weight: 700; display: block; margin-bottom: 6px;">
                        <i class="fa-solid fa-circle-info"></i> Fitur Cari: Ketik Nama atau NIP Guru pada kotak pilihan di bawah ini untuk mencari data guru mengajar.
                    </small>
                    <select name="id_guru" id="selectGuruSearch" class="form-control-custom" required style="width: 100%;">
                        <option value="">Pilih guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
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
                <textarea name="alasan" class="form-control-custom" rows="2" placeholder="Tuliskan alasan umum tidak dapat mengajar..." required></textarea>
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

            <!-- Opsi Titipan & Lampiran Surat -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                </div>
                <div>
                    <label class="form-label-custom" id="labelFotoSurat">Upload Foto Surat / Bukti Izin <span style="color: #dc2626;">*Wajib Diunggah</span></label>
                    <input type="file" name="foto_surat" id="inputFotoSurat" class="form-control-custom" accept="image/*" required>
                </div>
            </div>

            <!-- Upload File Tugas -->
            <div style="margin-bottom: 24px;">
                <label class="form-label-custom">Upload File Tugas (Opsional)</label>
                <input type="file" name="file_tugas" id="inputFileTugas" class="form-control-custom">
            </div>

            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn-create-link">
                    <i class="fa-solid fa-link"></i> Buat Link Persetujuan
                </button>
                <button type="button" onclick="resetFormBuatIzin()" class="btn-reset-light" style="padding: 11px 22px; font-size: 13.5px; border-radius: 10px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Status Permintaan Izin -->
<div class="card-custom">
    <div class="card-custom-header" style="display: flex; align-items: center; justify-content: space-between; border-bottom: none;">
        <h2>Status Permintaan Izin</h2>
        <span style="font-size: 12px; color: #64748b; font-weight: 700;">Total: {{ $guruIzinList->count() }} Pengajuan</span>
    </div>

    <!-- Filter & Search Bar + Reset + Sampah (Sejajar di Atas Tabel) -->
    <div class="filter-bar-container">
        <form action="{{ route('piket.permintaan-izin') }}" method="GET">
            <div style="flex: 2; min-width: 220px;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Nama Guru, NIP, Alasan..." style="width: 100%;">
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

            <a href="{{ route('piket.permintaan-izin') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>

            <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" style="background: #ef4444; color: #ffffff; padding: 9px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap; width: auto; height: auto;" title="Hapus Data Terpilih">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>

            <a href="{{ route('piket.permintaan-izin.trash') }}" class="btn-trash-pink" style="margin-left: auto;">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
            </a>
        </form>
    </div>

    <div class="card-custom-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th>GURU</th>
                        <th>TANGGAL & KATEGORI</th>
                        <th>ALASAN</th>
                        <th>STATUS WAKA</th>
                        <th>STATUS WAKA SDM</th>
                        <th>STATUS KEPSEK</th>
                        <th>STATUS FINAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $iz)
                    @php
                        $tokenUrl = url("/approval/guru-izin/{$iz->token_approval}");
                        $isCutiRow = ($iz->kategori_izin === 'cuti') || ($iz->tanggal_mulai && $iz->tanggal_selesai && \Carbon\Carbon::parse($iz->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($iz->tanggal_selesai)) + 1 > 3);

                        $waTextTable = rawurlencode("Assalamu'alaikum Wr. Wb. Bapak/Ibu Waka & Kepala Sekolah,\n\n"
                            . "Berikut pengajuan " . ($isCutiRow ? "CUTI / IZIN KHUSUS (> 3 HARI)" : "IZIN TIDAK HADIR") . " mengajar:\n"
                            . "• Guru: " . ($iz->guru->nama_guru ?? 'Guru') . "\n"
                            . "• Tanggal: " . ($iz->tanggal_mulai ?? '-') . "\n"
                            . "• Alasan: " . $iz->alasan . "\n\n"
                            . "Mohon dapat meninjau dan memilih persetujuan pada link berikut:\n\n"
                            . $tokenUrl . "\n\n"
                            . "Terima kasih.");
                        $waUrlTable = "https://api.whatsapp.com/send?text=" . $waTextTable;

                        $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                        $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                        $detailData = [
                            'id_guru_izin' => $iz->id_guru_izin,
                            'nama_guru' => $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                            'nip' => $iz->guru->nip ?? '-',
                            'tanggal' => ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y'),
                            'durasi' => $iz->durasi ?? '1 Hari Full',
                            'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                            'is_cuti' => $isCutiRow,
                            'alasan' => $iz->alasan,
                            'keterangan_khusus' => $iz->keterangan_khusus ?? '-',
                            'materi' => $iz->materi_dititipkan ?? '-',
                            'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                            'file_tugas_url' => $iz->file_tugas_url,
                            'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                            'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                            'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                            'catatan_waka' => $iz->catatan_waka ?? '-',
                            'catatan_kepsek' => $iz->catatan_kepsek ?? '-',
                            'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                            'link' => $tokenUrl,
                        ];

                        $editData = [
                            'id_guru_izin' => $iz->id_guru_izin,
                            'id_guru' => $iz->id_guru,
                            'tanggal_mulai' => $iz->tanggal_mulai,
                            'tanggal_selesai' => $iz->tanggal_selesai,
                            'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                            'alasan' => $iz->alasan,
                            'keterangan_khusus' => $iz->keterangan_khusus,
                            'materi_dititipkan' => $iz->materi_dititipkan,
                            'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                            'file_tugas_url' => $iz->file_tugas_url,
                        ];
                    @endphp
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" class="permintaan-izin-checkbox" value="{{ $iz->id_guru_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                {{ $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}
                            </div>
                            @if($iz->guru && $iz->guru->nip)
                                <div style="font-size: 11px; color: #64748b;">NIP. {{ $iz->guru->nip }}</div>
                            @endif
                        </td>
                        <td style="white-space: nowrap; font-weight: 600; color: #475569;">
                            <div>
                                @if($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                    {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y') }}
                                @endif
                            </div>
                            <div style="margin-top: 4px;">
                                @if($isCutiRow)
                                    <span class="status-badge badge-cuti"><i class="fa-solid fa-ribbon"></i> Cuti (>3 Hari)</span>
                                @else
                                    <span class="status-badge badge-biasa">Izin Biasa</span>
                                @endif
                            </div>
                        </td>
                        <td style="max-width: 230px;">
                            <div style="color: #334155; font-weight: 500;">{{ $iz->alasan }}</div>
                            @if($isCutiRow && $iz->keterangan_khusus)
                                <div style="font-size: 11px; color: #c2410c; margin-top: 4px; background: #fff7ed; padding: 4px 8px; border-radius: 6px; border: 1px solid #fed7aa;">
                                    <i class="fa-solid fa-note-sticky"></i> <strong>Ket. Cuti:</strong> {{ $iz->keterangan_khusus }}
                                </div>
                            @endif
                            @if($iz->status_waka === 'rejected' && $iz->catatan_waka)
                                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">
                                    <i class="fa-solid fa-circle-exclamation"></i> <strong>Penolakan Waka:</strong> {{ $iz->catatan_waka }}
                                </div>
                            @endif
                            @if($iz->status_kepsek === 'rejected' && $iz->catatan_kepsek)
                                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">
                                    <i class="fa-solid fa-circle-exclamation"></i> <strong>Penolakan Kepsek:</strong> {{ $iz->catatan_kepsek }}
                                </div>
                            @endif
                        </td>
                        <!-- Status Waka Kurikulum -->
                        <td>
                            @if($iz->status_waka === 'approved')
                                <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_waka === 'rejected')
                                <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
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
                            <!-- Urutan Tombol: Kirim WA | Salin Link | Detail | Edit | Hapus (Sebelah kanan Edit) -->
                            <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                <a href="{{ $waUrlTable }}" target="_blank" class="btn-action-btn btn-action-wa" title="Kirim Link via WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                </a>
                                <button type="button" class="btn-action-btn btn-action-copy" onclick="copyToClipboard('{{ $tokenUrl }}')" title="Salin Link Persetujuan Otomatis">
                                    <i class="fa-regular fa-copy"></i> Salin Link
                                </button>
                                <button type="button" class="btn-action-btn btn-action-detail" onclick='openDetailModal({{ json_encode($detailData) }})' title="Lihat Rincian Detail">
                                    <i class="fa-regular fa-eye"></i> Detail
                                </button>
                                <button type="button" class="btn-action-btn btn-action-edit" onclick='openEditModal({{ json_encode($editData) }})' title="Edit Data Izin">
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </button>
                                <form action="{{ route('piket.permintaan-izin.destroy', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Pindahkan data izin guru ini ke Sampah?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-btn btn-action-delete" title="Pindahkan ke Sampah">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 32px; color: #94a3b8; font-weight: 600;">
                            Belum ada data permintaan izin guru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Lihat Detail (Sintaks DOM Murni Tanpa Masalah Injeksi Template Blade) -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-circle-info"></i> Detail Permintaan Izin Guru</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="dt_cuti_badge_container" style="display: none; margin-bottom: 14px; background: #fff7ed; border: 1px solid #fed7aa; padding: 10px 14px; border-radius: 10px; color: #c2410c; font-weight: 800; font-size: 13px;">
                <i class="fa-solid fa-ribbon"></i> KATEGORI: CUTI / IZIN KHUSUS (> 3 HARI)
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">NAMA GURU MENGAJAR</div>
                <div id="dt_nama_guru" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 2px;"></div>
                <div id="dt_nip" style="font-size: 12px; color: #64748b;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">TANGGAL & DURASI IZIN</div>
                <div id="dt_tanggal_durasi" style="font-size: 14px; font-weight: 700; color: #334155; margin-top: 2px;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">ALASAN UNTUK TIDAK HADIR</div>
                <div id="dt_alasan" style="font-size: 13.5px; color: #1e293b; margin-top: 4px; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;"></div>
            </div>

            <div id="dt_keterangan_khusus_container" style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; display: none;">
                <div style="font-size: 11px; font-weight: 800; color: #c2410c; text-transform: uppercase;">KETERANGAN KHUSUS CUTI (> 3 HARI)</div>
                <div id="dt_keterangan_khusus" style="font-size: 13.5px; color: #9a3412; margin-top: 4px; background: #fff7ed; padding: 10px 14px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">TITIPAN MATERI / TUGAS SISWA</div>
                <div id="dt_materi" style="font-size: 13.5px; color: #334155; margin-top: 2px;"></div>
            </div>

            <div id="dt_foto_container" style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; display: none;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">FOTO SURAT KETERANGAN / LAMPIRAN BUKTI</div>
                <div style="margin-bottom: 8px; text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <img id="dt_foto_img" src="" alt="Foto Surat Keterangan" style="max-width: 100%; max-height: 220px; border-radius: 8px; object-fit: contain;">
                </div>
                <div>
                    <a id="dt_foto_link" href="" target="_blank" style="color: #2563eb; font-size: 13px; font-weight: 700; text-decoration: none;">
                        <i class="fa-solid fa-up-right-from-square"></i> Lihat Lampiran Surat Foto Ukuran Penuh (Full Size)
                    </a>
                </div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">STATUS PERSETUJUAN BERJENJANG</div>
                <div style="font-size: 13px; color: #334155; margin-bottom: 4px;">
                    <strong>Waka Kurikulum:</strong> <span id="dt_status_waka"></span>
                </div>
                <div style="font-size: 13px; color: #334155; margin-bottom: 4px;">
                    <strong>Waka SDM:</strong> <span id="dt_status_waka_sdm"></span>
                </div>
                <div style="font-size: 13px; color: #334155;">
                    <strong>Kepsek:</strong> <span id="dt_status_kepsek"></span>
                </div>
            </div>

            <div style="background: #f1f5f9; padding: 12px; border-radius: 10px; font-size: 12px; word-break: break-all; border: 1px solid #e2e8f0;">
                <strong style="color: #475569;">Link Persetujuan Publik (Teks Informasi):</strong><br>
                <span id="dt_link_display" style="font-family: monospace; color: #1e293b; font-weight: 700; display: inline-block; margin-top: 4px; user-select: all;"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action-btn btn-action-detail" onclick="closeDetailModal()" style="padding: 8px 18px;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit Data Permintaan Izin -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-regular fa-pen-to-square"></i> Edit Permintaan Izin Guru</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Guru Mengajar</label>
                    <select name="id_guru" id="edit_id_guru" class="form-control-custom" required style="width: 100%;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="edit_kategori_izin" class="form-control-custom" onchange="checkEditDurationCategory()">
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label-custom">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="checkEditDurationCategory()">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Alasan Izin</label>
                    <textarea name="alasan" id="edit_alasan" class="form-control-custom" rows="2" required></textarea>
                </div>

                <div id="editKeteranganKhususContainer" style="display: none; margin-bottom: 16px; background: #fff7ed; padding: 14px; border-radius: 10px; border: 1px solid #fed7aa;">
                    <label class="form-label-custom" style="color: #c2410c;">
                        <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                    </label>
                    <textarea name="keterangan_khusus" id="edit_keterangan_khusus" class="form-control-custom" rows="3" placeholder="Tuliskan keterangan khusus Cuti..."></textarea>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" id="edit_materi_dititipkan" class="form-control-custom">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom" id="editLabelFotoSurat">Upload Foto Surat / Bukti Izin Baru <span style="color: #dc2626;">*Wajib Diunggah</span></label>
                    <input type="file" name="foto_surat" id="edit_foto_surat" class="form-control-custom" accept="image/*">
                    
                    <!-- Pratinjau Foto Bukti Terlampir -->
                    <div id="edit_piket_foto_preview_container" style="display: none; margin-top: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 14px;">
                        <small style="font-size: 11.5px; font-weight: 800; color: #1e40af; text-transform: uppercase; display: block; margin-bottom: 6px;">
                            <i class="fa-solid fa-image"></i> Foto Surat / Bukti Terlampir Saat Ini:
                        </small>
                        <a id="edit_piket_foto_link" href="#" target="_blank">
                            <img id="edit_piket_foto_img" src="" alt="Pratinjau Foto" style="max-height: 130px; border-radius: 8px; border: 1px solid #93c5fd; object-fit: contain; display: block;">
                        </a>
                    </div>
                </div>

                <!-- Upload File Tugas Baru -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Upload File Tugas Baru (Opsional)</label>
                    <input type="file" name="file_tugas" id="edit_piket_file_tugas" class="form-control-custom">

                    <div id="edit_piket_file_preview_container" style="display: none; margin-top: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px;">
                        <small style="font-size: 12px; color: #1e293b; font-weight: 700;">
                            <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Saat Ini: <a id="edit_piket_file_link" href="#" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action-btn btn-action-detail" onclick="closeEditModal()">
                    Batal
                </button>
                <button type="submit" class="btn-create-link" style="padding: 9px 18px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Select2 & Helper Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#selectGuruSearch').select2({
        placeholder: "Cari NIP atau Nama Guru...",
        allowClear: true
    });
});

/**
 * Cek Durasi & Kategori Izin (Biasa vs Cuti > 3 Hari) untuk Form Buat Izin
 */
function checkDurationCategory() {
    const tglMulai = document.getElementById('inputTglMulai').value;
    let tglSelesai = document.getElementById('inputTglSelesai').value;
    const kategori = document.getElementById('selectKategoriIzin').value;

    if (tglMulai && tglSelesai && tglSelesai < tglMulai) {
        alert('Peringatan: Tanggal Selesai Izin (' + tglSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tglMulai + ')!');
        document.getElementById('inputTglSelesai').value = tglMulai;
        tglSelesai = tglMulai;
    }

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const container = document.getElementById('keteranganKhususContainer');
    const inputKet = document.getElementById('inputKeteranganKhusus');
    const banner = document.getElementById('bannerCutiWarning');
    const labelFoto = document.getElementById('labelFotoSurat');
    const inputFoto = document.getElementById('inputFotoSurat');

    const hasAutoFillPhoto = document.getElementById('previewFotoAutoFill') && document.getElementById('previewFotoAutoFill').style.display !== 'none';

    if (isCuti) {
        document.getElementById('selectKategoriIzin').value = 'cuti';
        container.style.display = 'block';
        banner.style.display = 'block';
        inputKet.setAttribute('required', 'required');

        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti <span style="color: #10b981; font-weight: 700;">(Foto Guru Mengajar Terlampir)</span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti <span style="color: #dc2626;">*Wajib Diunggah</span>';
        }
    } else {
        container.style.display = 'none';
        banner.style.display = 'none';
        inputKet.removeAttribute('required');
        
        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin <span style="color: #10b981; font-weight: 700;">(Foto Guru Mengajar Terlampir)</span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin <span style="color: #dc2626;">*Wajib Diunggah</span>';
        }
    }
}

/**
 * Cek Durasi & Kategori Izin untuk Form Edit
 */
function checkEditDurationCategory() {
    const tglMulai = document.getElementById('edit_tanggal_mulai').value;
    let tglSelesai = document.getElementById('edit_tanggal_selesai').value || tglMulai;
    const kategori = document.getElementById('edit_kategori_izin').value;

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const container = document.getElementById('editKeteranganKhususContainer');
    const inputKet = document.getElementById('edit_keterangan_khusus');
    const labelFoto = document.getElementById('editLabelFotoSurat');
    const inputFoto = document.getElementById('edit_foto_surat');
    const hasFotoPreview = document.getElementById('edit_piket_foto_preview_container') && document.getElementById('edit_piket_foto_preview_container').style.display !== 'none';

    if (hasFotoPreview) {
        if (inputFoto) inputFoto.removeAttribute('required');
    } else {
        if (inputFoto) inputFoto.setAttribute('required', 'required');
    }

    if (isCuti) {
        document.getElementById('edit_kategori_izin').value = 'cuti';
        container.style.display = 'block';
        inputKet.setAttribute('required', 'required');
        if (labelFoto) {
            labelFoto.innerHTML = hasFotoPreview 
                ? 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                : 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #dc2626;">*Wajib Diunggah</span>';
        }
    } else {
        container.style.display = 'none';
        inputKet.removeAttribute('required');
        if (labelFoto) {
            labelFoto.innerHTML = hasFotoPreview 
                ? 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                : 'Upload Foto Surat / Bukti Izin Baru <span style="color: #dc2626;">*Wajib Diunggah</span>';
        }
    }
}

/**
 * Robust Fallback Copy to Clipboard (100% Berfungsi di HTTP / Non-HTTPS tanpa Prompt Dialog)
 */
function copyToClipboard(text) {
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
            alert('Link approval persetujuan berhasil disalin ke clipboard!');
        } else {
            prompt('Salin link persetujuan berikut secara manual:', text);
        }
    } catch (err) {
        prompt('Salin link persetujuan berikut secara manual:', text);
    }

    document.body.removeChild(tempTextArea);
}

/**
 * Tampilkan Modal Detail (DOM Murni)
 */
function openDetailModal(data) {
    document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
    document.getElementById('dt_nip').innerText = 'NIP. ' + (data.nip || '-');
    document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari Full') + ')';
    document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
    document.getElementById('dt_materi').innerText = data.materi || '-';
    document.getElementById('dt_status_waka').innerText = (data.status_waka || 'Pending') + ' (Catatan: ' + (data.catatan_waka || '-') + ')';
    document.getElementById('dt_status_waka_sdm').innerText = (data.status_waka_sdm || 'Pending');
    document.getElementById('dt_status_kepsek').innerText = (data.status_kepsek || 'Pending') + ' (Catatan: ' + (data.catatan_kepsek || '-') + ')';
    document.getElementById('dt_link_display').innerText = data.link || '-';

    const cutiBadge = document.getElementById('dt_cuti_badge_container');
    const ketKhususContainer = document.getElementById('dt_keterangan_khusus_container');

    if (data.is_cuti || data.kategori_izin === 'cuti') {
        cutiBadge.style.display = 'block';
        if (data.keterangan_khusus && data.keterangan_khusus !== '-') {
            document.getElementById('dt_keterangan_khusus').innerText = data.keterangan_khusus;
            ketKhususContainer.style.display = 'block';
        } else {
            ketKhususContainer.style.display = 'none';
        }
    } else {
        cutiBadge.style.display = 'none';
        ketKhususContainer.style.display = 'none';
    }

    let fotoContainer = document.getElementById('dt_foto_container');
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

/**
 * Tampilkan Modal Edit Data Izin
 */
function openEditModal(data) {
    document.getElementById('editForm').action = "{{ url('/guru-piket/permintaan-izin') }}/" + data.id_guru_izin;
    document.getElementById('edit_id_guru').value = data.id_guru;
    
    if (window.jQuery && $.fn.select2) {
        $('#edit_id_guru').trigger('change');
    }

    document.getElementById('edit_kategori_izin').value = data.kategori_izin || 'biasa';
    document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
    document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || data.tanggal_mulai;
    document.getElementById('edit_alasan').value = data.alasan;
    document.getElementById('edit_keterangan_khusus').value = data.keterangan_khusus || '';
    document.getElementById('edit_materi_dititipkan').value = data.materi_dititipkan || '';

    // Pratinjau Foto di Edit Modal Piket
    const fotoPreviewContainer = document.getElementById('edit_piket_foto_preview_container');
    const editFotoInput = document.getElementById('edit_foto_surat');
    const editLabelFoto = document.getElementById('editLabelFotoSurat');

    if (data.foto_url) {
        document.getElementById('edit_piket_foto_img').src = data.foto_url;
        document.getElementById('edit_piket_foto_link').href = data.foto_url;
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'block';
        if (editFotoInput) editFotoInput.removeAttribute('required');
        if (editLabelFoto) editLabelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>';
    } else {
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'none';
        if (editFotoInput) editFotoInput.setAttribute('required', 'required');
        if (editLabelFoto) editLabelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin Baru <span style="color: #dc2626;">*Wajib Diunggah</span>';
    }

    checkEditDurationCategory();
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

/**
 * Isi Otomatis Form Buat Permintaan Izin dari Data Pengajuan Guru Mengajar
 */
function isiOtomatisForm(pReq) {
    document.getElementById('id_guru_izin_pengajuan').value = pReq.id_guru_izin;
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val(pReq.id_guru).trigger('change');
    } else {
        document.getElementById('selectGuruSearch').value = pReq.id_guru;
    }
    
    document.getElementById('inputTglMulai').value = pReq.tanggal_mulai;
    document.getElementById('inputTglSelesai').value = pReq.tanggal_selesai || pReq.tanggal_mulai;
    
    document.getElementById('selectKategoriIzin').value = pReq.kategori_izin || 'biasa';

    if (document.getElementsByName('alasan')[0]) {
        document.getElementsByName('alasan')[0].value = pReq.alasan || '';
    }
    if (document.getElementById('inputKeteranganKhusus') && pReq.keterangan_khusus) {
        document.getElementById('inputKeteranganKhusus').value = pReq.keterangan_khusus;
    }
    if (document.getElementsByName('materi_dititipkan')[0]) {
        document.getElementsByName('materi_dititipkan')[0].value = pReq.materi_dititipkan || '';
    }

    // Auto Fill Pratinjau Foto Surat / Bukti Izin
    const inputFoto = document.getElementById('inputFotoSurat');
    let previewBox = document.getElementById('previewFotoAutoFill');
    if (pReq.foto_surat) {
        const fotoUrl = "{{ asset('uploads/guru_izin') }}/" + pReq.foto_surat;
        if (!previewBox) {
            previewBox = document.createElement('div');
            previewBox.id = 'previewFotoAutoFill';
            previewBox.style.cssText = 'margin-top: 10px; background: #eff6ff; border: 1.5px solid #93c5fd; border-radius: 12px; padding: 12px 16px;';
            inputFoto.parentNode.appendChild(previewBox);
        }
        previewBox.style.display = 'block';
        previewBox.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                <span style="font-size: 12px; font-weight: 800; color: #1e40af; text-transform: uppercase;">
                    <i class="fa-solid fa-image"></i> Foto Bukti dari Guru Mengajar Terlampir:
                </span>
                <a href="${fotoUrl}" target="_blank" style="font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: underline;">
                    Lihat Ukuran Penuh
                </a>
            </div>
            <a href="${fotoUrl}" target="_blank">
                <img src="${fotoUrl}" alt="Foto Bukti Guru Mengajar" style="max-height: 160px; border-radius: 8px; border: 1px solid #cbd5e1; object-fit: contain; display: block; background: #ffffff; padding: 4px;">
            </a>
            <small style="color: #0369a1; font-weight: 600; display: block; margin-top: 6px; font-size: 11.5px;">
                <i class="fa-solid fa-circle-check"></i> Foto terisi otomatis dari pengajuan Guru Mengajar (${pReq.guru ? pReq.guru.nama_guru : 'Guru'}). Anda tidak perlu mengunggah ulang foto kecuali ingin menggantinya.
            </small>
        `;
        if (inputFoto) inputFoto.removeAttribute('required');
    } else {
        if (previewBox) {
            previewBox.style.display = 'none';
            previewBox.innerHTML = '';
        }
    }

    // Auto Fill File Tugas
    const inputFileTugas = document.getElementById('inputFileTugas');
    let filePreviewBox = document.getElementById('previewFileTugasAutoFill');
    if (pReq.file_tugas || pReq.file_tugas_url) {
        const fileUrl = pReq.file_tugas_url || ("{{ asset('uploads/tugas_pengganti') }}/" + pReq.file_tugas);
        if (inputFileTugas) {
            if (!filePreviewBox) {
                filePreviewBox = document.createElement('div');
                filePreviewBox.id = 'previewFileTugasAutoFill';
                filePreviewBox.style.cssText = 'margin-top: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px;';
                inputFileTugas.parentNode.appendChild(filePreviewBox);
            }
            filePreviewBox.style.display = 'block';
            filePreviewBox.innerHTML = `
                <small style="font-size: 12px; color: #1e293b; font-weight: 700;">
                    <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Terlampir dari Guru Mengajar: <a href="${fileUrl}" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                </small>
            `;
        }
    } else {
        if (filePreviewBox) {
            filePreviewBox.style.display = 'none';
            filePreviewBox.innerHTML = '';
        }
    }

    checkDurationCategory();

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'block';
        infoBox.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Data pengajuan dari Guru Mengajar (' + (pReq.guru ? pReq.guru.nama_guru : 'Guru') + ') telah diisikan secara otomatis ke form. Silakan periksa kembali dan klik "Buat Link Persetujuan" untuk memvalidasi dan mengirimkan link ke Waka & Kepsek.';
    }

    document.getElementById('formBuatIzin').scrollIntoView({ behavior: 'smooth' });
}

/**
 * Filter pencarian real-time untuk banner notifikasi pengajuan baru
 */
function filterPendingRequests() {
    const input = document.getElementById('searchPendingInput');
    if (!input) return;
    const query = input.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.pending-request-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countSpan = document.getElementById('pendingCountText');
    if (countSpan) {
        countSpan.innerText = visibleCount;
    }
}

function resetPendingFilter() {
    const input = document.getElementById('searchPendingInput');
    if (input) {
        input.value = '';
        filterPendingRequests();
    }
}

/**
 * Reset seluruh isian form Buat Permintaan Izin / Cuti Guru
 */
function resetFormBuatIzin() {
    const form = document.getElementById('formBuatIzin');
    if (form) {
        form.reset();
    }
    
    document.getElementById('id_guru_izin_pengajuan').value = '';
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val('').trigger('change');
    } else if (document.getElementById('selectGuruSearch')) {
        document.getElementById('selectGuruSearch').value = '';
    }

    const todayStr = "{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}";
    document.getElementById('inputTglMulai').value = todayStr;
    document.getElementById('inputTglSelesai').value = todayStr;
    document.getElementById('selectKategoriIzin').value = 'biasa';

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'none';
        infoBox.innerHTML = '';
    }

    const previewBox = document.getElementById('previewFotoAutoFill');
    if (previewBox) {
        previewBox.style.display = 'none';
        previewBox.innerHTML = '';
    }

    const filePreviewBox = document.getElementById('previewFileTugasAutoFill');
    if (filePreviewBox) {
        filePreviewBox.style.display = 'none';
        filePreviewBox.innerHTML = '';
    }

    checkDurationCategory();
}

// Fitur Checkbox & Hapus Massal Permintaan Izin Guru
function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateSelectedState();
}

function updateSelectedState() {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
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
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan pilih minimal satu data permintaan izin yang mau dihapus.');
        return;
    }

    document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

function executeBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
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

<!-- Form Hidden untuk Hapus Massal Permintaan Izin Guru -->
<form id="bulkDeleteForm" action="{{ route('piket.permintaan-izin.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal Permintaan Izin Guru -->
<div id="bulkDeleteModal" class="modal-backdrop" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 9999; padding: 20px;">
    <div class="modal-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
        <div class="modal-header" style="padding: 18px 24px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <button type="button" onclick="closeBulkDeleteModal()" style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 28px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data permintaan izin guru yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="btn-reset-light" style="padding: 10px 20px; font-size: 13px; font-weight: 700;">
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
