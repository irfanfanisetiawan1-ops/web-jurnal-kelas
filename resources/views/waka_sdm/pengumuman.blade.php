@extends('layouts.waka_sdm')

@section('title', 'Pengumuman SDM & Sekolah — Waka SDM')
@section('page-header', 'Pengumuman SDM & Sekolah')
@section('page-subheader', 'Informasi pengumuman penting, catatan kegiatan, dan instruksi harian kepegawaian untuk seluruh pendidik dan tenaga kependidikan')

@section('styles')
<style>
    .pengumuman-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: -12px;
        margin-bottom: 4px;
    }

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        margin-bottom: 18px;
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
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #2b3957;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-filter-dark:hover { background: #1e293b; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-add-pengumuman {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }
    .btn-add-pengumuman:hover { background: #059669; }

    .btn-trash-view {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-trash-view:hover {
        background: #ffe4e6;
        color: #be123c;
    }

    /* 3 Stat Cards Grid */
    .stat-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-gold   { background: #fef3c7; color: #d97706; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .stat-link {
        font-size: 12px;
        font-weight: 700;
        color: #2563eb;
        text-decoration: none;
    }
    .stat-link:hover { text-decoration: underline; }

    /* Card Panel Base */
    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    /* Table Design */
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
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-cat {
        background: #e2e8f0;
        color: #334155;
        font-size: 10.5px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 6px;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
        text-transform: capitalize;
    }
    .badge-status-aktif   { background: #d1fae5; color: #065f46; }
    .badge-status-selesai { background: #dbeafe; color: #1e40af; }
    .badge-status-arsip   { background: #f1f5f9; color: #475569; }

    .btn-act {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-act-view { background: #f1f5f9; color: #475569; }
    .btn-act-view:hover { background: #e2e8f0; color: #0f172a; }
    .btn-act-edit { background: #eff6ff; color: #2563eb; }
    .btn-act-edit:hover { background: #dbeafe; color: #1d4ed8; }
    .btn-act-del { background: #fef2f2; color: #ef4444; }
    .btn-act-del:hover { background: #fee2e2; color: #dc2626; }

    /* Modals Backdrop & Card */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 16px;
    }

    .modal-card-custom {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group-modal {
        margin-bottom: 16px;
    }
    .form-group-modal label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control-modal {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
    }
    .form-control-modal:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    @media (max-width: 768px) {
        .stat-grid-3 { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-container">
    <!-- 3 Stat Cards Grid -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Pengumuman</span>
                    <span class="stat-val">{{ $stats['totalPengumuman'] ?? 0 }} Data</span>
                </div>
            </div>
            <a href="{{ route('waka-sdm.pengumuman') }}" class="stat-link">Lihat Semua</a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Aktif</span>
                    <span class="stat-val">{{ $stats['pengumumanAktif'] ?? 0 }} Pengumuman</span>
                </div>
            </div>
            <a href="{{ route('waka-sdm.pengumuman', ['status' => 'aktif']) }}" class="stat-link">Lihat Detail</a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-gold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Selesai</span>
                    <span class="stat-val">{{ $stats['pengumumanSelesai'] ?? 0 }} Selesai</span>
                </div>
            </div>
            <a href="{{ route('waka-sdm.pengumuman', ['status' => 'selesai']) }}" class="stat-link">Lihat Detail</a>
        </div>
    </div>

    <!-- Card Main Panel -->
    <div class="card-panel">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i> Daftar Pengumuman Sekolah &amp; SDM
            </h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                <button type="button" class="btn-add-pengumuman" onclick="openModalAddPengumuman()">
                    <i class="fa-solid fa-plus"></i> Tambah Pengumuman
                </button>
                <button type="button" class="btn-trash-view" onclick="openModalTrashPengumuman()">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashCount ?? 0 }})
                </button>
            </div>
        </div>

        <!-- Filter Bar Form -->
        <div class="filter-bar-container">
            <form action="{{ route('waka-sdm.pengumuman') }}" method="GET">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari Judul / Pengumuman / Kategori..." class="filter-input" style="flex: 1; min-width: 220px;">
                
                <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">

                <select name="id_kelas" class="filter-input">
                    <option value="">Kelas: Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>

                <select name="kategori" class="filter-input">
                    <option value="">Kategori: Semua</option>
                    <option value="SDM / Kepegawaian" {{ $kategoriFilter == 'SDM / Kepegawaian' ? 'selected' : '' }}>SDM / Kepegawaian</option>
                    <option value="Umum" {{ $kategoriFilter == 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="Workshop" {{ $kategoriFilter == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Kurikulum" {{ $kategoriFilter == 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                    <option value="Perubahan Jadwal" {{ $kategoriFilter == 'Perubahan Jadwal' ? 'selected' : '' }}>Perubahan Jadwal</option>
                    <option value="Penugasan" {{ $kategoriFilter == 'Penugasan' ? 'selected' : '' }}>Penugasan</option>
                </select>

                <select name="status" class="filter-input">
                    <option value="">Status: Semua Status</option>
                    <option value="aktif" {{ $statusFilter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ $statusFilter == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="arsip" {{ $statusFilter == 'arsip' ? 'selected' : '' }}>Arsip</option>
                </select>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-sdm.pengumuman') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <!-- Table Data -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul &amp; Isi Pengumuman</th>
                        <th>Kelas Target</th>
                        <th>Jam Mengajar</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pembuat / Tanggal</th>
                        <th style="text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumanList as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div>
                                    <span class="badge-cat">{{ $p->kategori ?? 'Umum' }}</span>
                                    <strong style="font-size: 14px; color: #0f172a;">{{ $p->judul }}</strong>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                    {{ Str::limit($p->isi, 75) }}
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #475569;">
                                <i class="fa-solid fa-users" style="font-size: 11px; margin-right: 4px;"></i>
                                {{ $p->kelas ? $p->kelas->nama_kelas : 'Semua Kelas' }}
                            </td>
                            <td style="font-weight: 600; color: #475569;">
                                <i class="fa-regular fa-clock" style="font-size: 11px; margin-right: 4px;"></i>
                                {{ $p->jam_mengajar ?? '-' }}
                            </td>
                            <td>
                                @php $st = strtolower($p->status ?? 'aktif'); @endphp
                                <span class="badge-status badge-status-{{ $st }}">
                                    {{ ucfirst($st) }}
                                </span>
                            </td>
                            <td style="font-size: 12.5px; color: #475569;">
                                {{ $p->keterangan ?? '-' }}
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">{{ $p->pembuat ? $p->pembuat->nama_guru : ($p->penulis ?? 'Waka SDM') }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    {{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d M Y') : $p->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 4px; justify-content: center;">
                                    <button type="button" class="btn-act btn-act-view" onclick='openModalDetailPengumuman(@json($p))' title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-act btn-act-edit" onclick='openModalEditPengumuman(@json($p))' title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('waka-sdm.pengumuman.destroy', $p->id_pengumuman ?? $p->id) }}" method="POST" onsubmit="return confirm('Pindahkan pengumuman ini ke Sampah (Soft Delete)?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-act-del" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-inbox" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Belum ada data pengumuman yang sesuai dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PENGUMUMAN -->
<div id="modalAddPengumuman" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <form action="{{ route('waka-sdm.pengumuman.store') }}" method="POST">
            @csrf
            <div class="modal-header-custom">
                <h3><i class="fa-solid fa-circle-plus" style="color: #10b981;"></i> Tambah Pengumuman Baru</h3>
                <button type="button" onclick="closeModalAddPengumuman()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group-modal">
                    <label>Judul Pengumuman <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="judul" required placeholder="e.g. Rapat Koordinasi SDM Gaji & KBM" class="form-control-modal">
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Kategori <span style="color:#ef4444;">*</span></label>
                        <select name="kategori" required class="form-control-modal">
                            <option value="SDM / Kepegawaian">SDM / Kepegawaian</option>
                            <option value="Umum">Umum</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Penugasan">Penugasan</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Kelas Target <span style="color:#ef4444;">*</span></label>
                        <select name="id_kelas" class="form-control-modal">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Pilihan Jam / Waktu Mengajar <span style="color:#ef4444;">*</span></label>
                        <select name="jam_mengajar_select" id="add_jam_select" onchange="toggleAddCustomJam(this.value)" class="form-control-modal" required>
                            <option value="">-- Pilih Dari Jam Pelajaran --</option>
                            <option value="08.00 - 09.30">08.00 - 09.30</option>
                            <option value="09.30 - 10.30">09.30 - 10.30</option>
                            <option value="10.30 - 12.00">10.30 - 12.00</option>
                            <option value="12.30 - 14.00">12.30 - 14.00</option>
                            <option value="custom">Kustom / Lainnya...</option>
                        </select>
                        <input type="text" name="jam_mengajar_custom" id="add_jam_custom" placeholder="e.g. 07.30 - 15.00 WIB" class="form-control-modal" style="margin-top: 6px; display: none;">
                    </div>

                    <div class="form-group-modal">
                        <label>Status <span style="color:#ef4444;">*</span></label>
                        <select name="status" class="form-control-modal" required>
                            <option value="aktif">Aktif (Aktif Di Portal Guru &amp; Notifikasi)</option>
                            <option value="selesai">Selesai</option>
                            <option value="arsip">Arsip</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Tanggal Berlaku <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" value="{{ $todayDate }}" required class="form-control-modal">
                    </div>

                    <div class="form-group-modal">
                        <label>Keterangan / Catatan <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="keterangan" required placeholder="e.g. Rapat Wajib Pendidik / Oleh: Waka SDM" class="form-control-modal">
                    </div>
                </div>

                <div class="form-group-modal">
                    <label>Isi Pengumuman <span style="color:#ef4444;">*</span></label>
                    <textarea name="isi" rows="4" required placeholder="Tuliskan isi pengumuman secara lengkap..." class="form-control-modal"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" onclick="closeModalAddPengumuman()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-add-pengumuman"><i class="fa-solid fa-paper-plane"></i> Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGUMUMAN -->
<div id="modalEditPengumuman" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <form id="formEditPengumuman" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header-custom">
                <h3><i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> Edit Pengumuman</h3>
                <button type="button" onclick="closeModalEditPengumuman()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group-modal">
                    <label>Judul Pengumuman <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="judul" id="edit_judul" required class="form-control-modal">
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Kategori <span style="color:#ef4444;">*</span></label>
                        <select name="kategori" id="edit_kategori" required class="form-control-modal">
                            <option value="SDM / Kepegawaian">SDM / Kepegawaian</option>
                            <option value="Umum">Umum</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Penugasan">Penugasan</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Kelas Target <span style="color:#ef4444;">*</span></label>
                        <select name="id_kelas" id="edit_id_kelas" class="form-control-modal">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Pilihan Jam / Waktu Mengajar <span style="color:#ef4444;">*</span></label>
                        <select name="jam_mengajar_select" id="edit_jam_select" onchange="toggleEditCustomJam(this.value)" class="form-control-modal" required>
                            <option value="">-- Pilih Dari Jam Pelajaran --</option>
                            <option value="08.00 - 09.30">08.00 - 09.30</option>
                            <option value="09.30 - 10.30">09.30 - 10.30</option>
                            <option value="10.30 - 12.00">10.30 - 12.00</option>
                            <option value="12.30 - 14.00">12.30 - 14.00</option>
                            <option value="custom">Kustom / Lainnya...</option>
                        </select>
                        <input type="text" name="jam_mengajar_custom" id="edit_jam_custom" class="form-control-modal" style="margin-top: 6px; display: none;">
                    </div>

                    <div class="form-group-modal">
                        <label>Status <span style="color:#ef4444;">*</span></label>
                        <select name="status" id="edit_status" class="form-control-modal" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="arsip">Arsip</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Tanggal Berlaku <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" required class="form-control-modal">
                    </div>

                    <div class="form-group-modal">
                        <label>Keterangan / Catatan <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="keterangan" id="edit_keterangan" required class="form-control-modal">
                    </div>
                </div>

                <div class="form-group-modal">
                    <label>Isi Pengumuman <span style="color:#ef4444;">*</span></label>
                    <textarea name="isi" id="edit_isi" rows="4" required class="form-control-modal"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" onclick="closeModalEditPengumuman()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-filter-dark" style="background:#2563eb;"><i class="fa-solid fa-floppy-disk"></i> Update Pengumuman</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL PENGUMUMAN -->
<div id="modalDetailPengumuman" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Pengumuman Sekolah</h3>
            <button type="button" onclick="closeModalDetailPengumuman()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <div style="margin-bottom: 12px;">
                <span id="dt_kategori" class="badge-cat"></span>
                <span id="dt_status" class="badge-status"></span>
            </div>
            <h2 id="dt_judul" style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 12px;"></h2>
            
            <div style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #1e293b; line-height: 1.6; white-space: pre-line; margin-bottom: 16px;" id="dt_isi"></div>

            <div class="form-grid-2" style="font-size: 12.5px;">
                <div><strong>Kelas Target:</strong> <span id="dt_kelas"></span></div>
                <div><strong>Jam Mengajar:</strong> <span id="dt_jam"></span></div>
                <div><strong>Tanggal:</strong> <span id="dt_tanggal"></span></div>
                <div><strong>Penulis:</strong> <span id="dt_penulis"></span></div>
                <div style="grid-column: span 2;"><strong>Keterangan:</strong> <span id="dt_keterangan"></span></div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" onclick="closeModalDetailPengumuman()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL SAMPAH PENGUMUMAN -->
<div id="modalTrashPengumuman" class="modal-backdrop-custom">
    <div class="modal-card-custom" style="max-width: 700px;">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Pengumuman Sekolah</h3>
            <button type="button" onclick="closeModalTrashPengumuman()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 14px;">
                @if(count($trashPengumuman ?? []) > 0)
                    <form action="{{ route('waka-sdm.pengumuman.empty-trash') }}" method="POST" onsubmit="return confirm('MENGOSONGKAN SELURUH SAMPAH PENGUMUMAN? Data tidak dapat dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-trash-pink" style="padding: 7px 12px; font-size: 12px;">
                            <i class="fa-solid fa-trash"></i> Kosongkan Sampah
                        </button>
                    </form>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Judul Pengumuman</th>
                            <th>Kategori</th>
                            <th>Dihapus</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashPengumuman ?? [] as $tp)
                            <tr>
                                <td>
                                    <strong style="color: #0f172a;">{{ $tp->judul }}</strong>
                                    <div style="font-size: 11px; color: #64748b;">{{ Str::limit($tp->isi, 40) }}</div>
                                </td>
                                <td><span class="badge-cat">{{ $tp->kategori ?? 'Umum' }}</span></td>
                                <td style="font-size: 11.5px; color: #64748b;">{{ $tp->deleted_at ? $tp->deleted_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <form action="{{ route('waka-sdm.pengumuman.restore', $tp->id_pengumuman ?? $tp->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-act btn-act-view" title="Pulihkan"><i class="fa-solid fa-rotate-left" style="color:#10b981;"></i></button>
                                        </form>
                                        <form action="{{ route('waka-sdm.pengumuman.force-delete', $tp->id_pengumuman ?? $tp->id) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-act btn-act-del" title="Hapus Permanen"><i class="fa-solid fa-ban"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    Tidak ada data pengumuman di sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" onclick="closeModalTrashPengumuman()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleAddCustomJam(val) {
        const customInput = document.getElementById('add_jam_custom');
        if (val === 'custom') {
            customInput.style.display = 'block';
            customInput.required = true;
        } else {
            customInput.style.display = 'none';
            customInput.required = false;
        }
    }

    function toggleEditCustomJam(val) {
        const customInput = document.getElementById('edit_jam_custom');
        if (val === 'custom') {
            customInput.style.display = 'block';
            customInput.required = true;
        } else {
            customInput.style.display = 'none';
            customInput.required = false;
        }
    }

    function openModalAddPengumuman() {
        document.getElementById('modalAddPengumuman').style.display = 'flex';
    }
    function closeModalAddPengumuman() {
        document.getElementById('modalAddPengumuman').style.display = 'none';
    }

    function openModalEditPengumuman(data) {
        const id = data.id_pengumuman || data.id;
        document.getElementById('formEditPengumuman').action = "{{ url('waka-sdm/pengumuman') }}/" + id;
        document.getElementById('edit_judul').value = data.judul || '';
        document.getElementById('edit_kategori').value = data.kategori || 'SDM / Kepegawaian';
        document.getElementById('edit_id_kelas').value = data.id_kelas || '';
        document.getElementById('edit_status').value = (data.status || 'aktif').toLowerCase();
        document.getElementById('edit_tanggal').value = data.tanggal || '';
        document.getElementById('edit_keterangan').value = data.keterangan || '';
        document.getElementById('edit_isi').value = data.isi || '';

        const jamSelect = document.getElementById('edit_jam_select');
        const jamCustom = document.getElementById('edit_jam_custom');
        const knownJams = ["08.00 - 09.30", "09.30 - 10.30", "10.30 - 12.00", "12.30 - 14.00"];

        if (knownJams.includes(data.jam_mengajar)) {
            jamSelect.value = data.jam_mengajar;
            jamCustom.style.display = 'none';
            jamCustom.required = false;
        } else {
            jamSelect.value = 'custom';
            jamCustom.value = data.jam_mengajar || '';
            jamCustom.style.display = 'block';
            jamCustom.required = true;
        }

        document.getElementById('modalEditPengumuman').style.display = 'flex';
    }
    function closeModalEditPengumuman() {
        document.getElementById('modalEditPengumuman').style.display = 'none';
    }

    function openModalDetailPengumuman(data) {
        document.getElementById('dt_judul').innerText = data.judul || '-';
        document.getElementById('dt_kategori').innerText = data.kategori || 'Umum';
        document.getElementById('dt_status').innerText = (data.status || 'aktif').toUpperCase();
        document.getElementById('dt_status').className = 'badge-status badge-status-' + (data.status || 'aktif').toLowerCase();
        document.getElementById('dt_isi').innerText = data.isi || '-';
        document.getElementById('dt_kelas').innerText = data.kelas ? data.kelas.nama_kelas : 'Semua Kelas';
        document.getElementById('dt_jam').innerText = data.jam_mengajar || '-';
        document.getElementById('dt_tanggal').innerText = data.tanggal || '-';
        document.getElementById('dt_penulis').innerText = data.pembuat ? data.pembuat.nama_guru : (data.penulis || 'Waka SDM');
        document.getElementById('dt_keterangan').innerText = data.keterangan || '-';

        document.getElementById('modalDetailPengumuman').style.display = 'flex';
    }
    function closeModalDetailPengumuman() {
        document.getElementById('modalDetailPengumuman').style.display = 'none';
    }

    function openModalTrashPengumuman() {
        document.getElementById('modalTrashPengumuman').style.display = 'flex';
    }
    function closeModalTrashPengumuman() {
        document.getElementById('modalTrashPengumuman').style.display = 'none';
    }
</script>
@endsection
