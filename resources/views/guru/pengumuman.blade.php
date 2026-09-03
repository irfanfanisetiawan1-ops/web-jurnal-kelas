@extends('layouts.guru')

@section('title', 'Informasi Pengumuman — Portal Guru')
@section('header_title', 'Pengumuman')

@section('styles')
<style>
    .pengumuman-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .page-title-group h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .page-title-group p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* Stat Cards Grid */
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
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-input {
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter-dark:hover { background: #2b3957; }

    .btn-reset-light {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-reset-light:hover { background: #e2e8f0; color: #0f172a; }

    /* Announcement Cards Grid */
    .announcement-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 18px;
    }

    .announcement-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .announcement-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .category-badge {
        font-size: 11.5px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        background: #e0e7ff;
        color: #3730a3;
    }

    .category-badge-telat {
        font-size: 11.5px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge-aktif {
        background: #d1fae5;
        color: #065f46;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 12px;
    }

    .status-badge-selesai {
        background: #dbeafe;
        color: #1e40af;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 12px;
    }

    .card-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .card-content {
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 10px 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 14px;
    }

    .card-meta div i {
        color: #384972;
        margin-right: 4px;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        margin-top: auto;
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .author-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #384972;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
    }

    .author-name {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
    }

    .btn-detail {
        background: #f1f5f9;
        color: #384972;
        border: 1px solid #cbd5e1;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        background: #384972;
        color: #ffffff;
    }

    /* Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .modal-content {
        background: #ffffff;
        width: 100%;
        max-width: 650px;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    @media (max-width: 992px) {
        .stat-grid-3 { grid-template-columns: 1fr; }
        .announcement-cards-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Pengumuman Sekolah dan Siswa Telat</h1>
            <p>Informasi pengumuman penting, catatan kegiatan, dan pemberitahuan siswa terlambat dari Guru Piket & Waka Kurikulum</p>
        </div>
    </div>

    <!-- 1. Stat Cards Grid -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Pengumuman</span>
                    <span class="stat-val">{{ $stats['totalPengumuman'] }} Data</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Aktif</span>
                    <span class="stat-val">{{ $stats['pengumumanAktif'] }} Pengumuman</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-gold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Selesai</span>
                    <span class="stat-val">{{ $stats['pengumumanSelesai'] }} Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 700;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- 2. Filter Bar -->
    <div class="filter-card">
        <form action="{{ route('guru.pengumuman') }}" method="GET" class="filter-grid">
            <div style="flex: 1.5; min-width: 200px;">
                <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari Judul / Isi / Kategori..." style="width: 100%;">
            </div>

            <div>
                <select name="kategori" class="filter-input">
                    <option value="">Kategori: Semua</option>
                    <option value="Rapat" {{ $kategoriFilter === 'Rapat' ? 'selected' : '' }}>Rapat</option>
                    <option value="Workshop" {{ $kategoriFilter === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Kurikulum" {{ $kategoriFilter === 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                    <option value="Perubahan Jadwal" {{ $kategoriFilter === 'Perubahan Jadwal' ? 'selected' : '' }}>Perubahan Jadwal</option>
                    <option value="Penugasan" {{ $kategoriFilter === 'Penugasan' ? 'selected' : '' }}>Penugasan</option>
                    <option value="Siswa Telat" {{ $kategoriFilter === 'Siswa Telat' ? 'selected' : '' }}>Siswa Telat</option>
                    <option value="Umum" {{ $kategoriFilter === 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>

            <div>
                <select name="status" class="filter-input">
                    <option value="">Status: Semua Status</option>
                    <option value="aktif" {{ strtolower($statusFilter) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ strtolower($statusFilter) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">
            </div>

            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

            <a href="{{ route('guru.pengumuman') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>

            <!-- Tombol Hapus Terpilih (Batch Delete) -->
            <button type="button" id="btnBatchDeletePengumuman" class="btn-trash-pink" onclick="confirmBatchDeletePengumuman()" style="opacity: 0.5; cursor: not-allowed; padding: 0 16px; border-radius: 12px; font-weight: 700; font-size: 13px;" disabled>
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCountPengumuman">0</span>)
            </button>

            <a href="{{ route('guru.pengumuman.trash') }}" class="btn-trash-pink" style="margin-left: auto; padding: 0 16px; border-radius: 12px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount ?? 0 }})
            </a>
        </form>
    </div>

    <!-- Form Tersembunyi untuk Batch Delete -->
    <form id="formBatchDeletePengumuman" action="{{ route('guru.pengumuman.destroy-batch') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <div id="batchDeleteInputsContainer"></div>
    </form>

    <!-- Sub-bar Checkbox Pilih Semua -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; background: #ffffff; padding: 12px 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <label style="font-size: 13px; font-weight: 800; color: #334155; cursor: pointer; display: flex; align-items: center; gap: 8px; margin: 0;">
            <input type="checkbox" id="selectAllPengumumanCheckboxes" style="width: 17px; height: 17px; cursor: pointer;">
            Pilih Semua Pengumuman / Pemberitahuan
        </label>
        <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
            Total: {{ $pengumumanList->count() }} Data Tampil
        </span>
    </div>

    <!-- 3. Announcement Cards Grid -->
    <div class="announcement-cards-grid">
        @forelse($pengumumanList as $row)
            @php
                $stTeks = ucfirst($row->status ?? 'aktif');
                $stClass = strtolower($row->status) === 'selesai' ? 'status-badge-selesai' : 'status-badge-aktif';
                $isTelat = strtolower($row->kategori ?? '') === 'siswa telat';
                $kelasNama = $row->kelas->nama_kelas ?? ($row->id_kelas ? 'Kelas #'.$row->id_kelas : 'Semua Kelas');
                $pembuatNama = $row->pembuat->nama_guru ?? ($isTelat ? 'Guru Piket' : 'Waka Kurikulum');
                $tanggalFormated = \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y');
            @endphp

            @if($isTelat)
                <!-- Tampilan Khusus: Pemberitahuan Siswa Telat (Dari Guru Piket) -->
                <div class="announcement-card" style="background: #fffdf5; border-left: 5px solid #f59e0b; border: 1px solid #fef3c7; border-left-width: 5px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.08);">
                    <div>
                        <div class="card-top" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" value="{{ $row->id_pengumuman }}" class="item-checkbox-pengumuman" style="width: 17px; height: 17px; cursor: pointer;" onchange="updateBatchPengumumanState()">
                                <span class="category-badge-telat">
                                    <i class="fa-solid fa-user-clock"></i> Pemberitahuan Siswa Telat
                                </span>
                            </div>
                            <span class="status-badge-aktif" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                <i class="fa-solid fa-clock"></i> Siswa Telat
                            </span>
                        </div>

                        <h3 class="card-title" style="color: #b45309; font-size: 15px; font-weight: 800; margin-top: 10px;">
                            <i class="fa-solid fa-bell" style="color: #f59e0b; margin-right: 4px;"></i> {{ $row->judul }}
                        </h3>

                        <div style="background: #ffffff; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; font-size: 12.5px; color: #334155; line-height: 1.5; white-space: pre-line; max-height: 110px; overflow-y: auto;">
                            {{ $row->isi }}
                        </div>

                        <div class="card-meta" style="background: #fffbeb; border-color: #fef3c7;">
                            <div><i class="fa-solid fa-users" style="color: #d97706;"></i> {{ $kelasNama }}</div>
                            <div><i class="fa-regular fa-calendar" style="color: #d97706;"></i> {{ $tanggalFormated }}</div>
                            <div style="grid-column: 1 / -1;"><i class="fa-solid fa-user-shield" style="color: #d97706;"></i> {{ $row->keterangan ?? 'Laporan dari Guru Piket' }}</div>
                        </div>
                    </div>

                    <div class="card-footer" style="border-top-color: #fef3c7; display: flex; align-items: center; justify-content: space-between;">
                        <div class="author-info">
                            <div class="author-avatar" style="background: #d97706;"><i class="fa-solid fa-user-shield"></i></div>
                            <span class="author-name" style="color: #92400e;">Guru Piket Sekolah</span>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <button type="button" class="btn-detail" style="background: #fef3c7; color: #b45309; border-color: #fde68a;" onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "Guru Piket Sekolah", "{{ $tanggalFormated }}")'>
                                <i class="fa-solid fa-eye"></i> Detail
                            </button>

                            <form action="{{ route('guru.pengumuman.destroy', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan pemberitahuan ini ke Sampah?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-detail" style="background: #fee2e2; color: #991b1b; border-color: #fca5a5; padding: 6px 10px;" title="Pindahkan ke Sampah">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Tampilan Standar: Pengumuman Sekolah Resmi (Dari Waka / Kurikulum) -->
                <div class="announcement-card" style="border-left: 5px solid #384972;">
                    <div>
                        <div class="card-top" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" value="{{ $row->id_pengumuman }}" class="item-checkbox-pengumuman" style="width: 17px; height: 17px; cursor: pointer;" onchange="updateBatchPengumumanState()">
                                <span class="category-badge">{{ $row->kategori ?? 'Umum' }}</span>
                            </div>
                            <span class="{{ $stClass }}">{{ $stTeks }}</span>
                        </div>

                        <h3 class="card-title" style="margin-top: 10px;">{{ $row->judul }}</h3>
                        <p class="card-content">{{ $row->isi }}</p>

                        <div class="card-meta">
                            <div><i class="fa-solid fa-users"></i> {{ $kelasNama }}</div>
                            <div><i class="fa-regular fa-clock"></i> {{ $row->jam_mengajar ?? '-' }}</div>
                            <div><i class="fa-regular fa-calendar"></i> {{ $tanggalFormated }}</div>
                            <div><i class="fa-solid fa-circle-info"></i> {{ $row->keterangan ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="card-footer" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="author-info">
                            <div class="author-avatar">{{ strtoupper(substr($pembuatNama, 0, 1)) }}</div>
                            <span class="author-name">{{ $pembuatNama }}</span>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <button type="button" class="btn-detail" onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "{{ addslashes($pembuatNama) }}", "{{ $tanggalFormated }}")'>
                                <i class="fa-solid fa-eye"></i> Detail
                            </button>

                            <form action="{{ route('guru.pengumuman.destroy', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan pengumuman ini ke Sampah?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-detail" style="background: #fee2e2; color: #991b1b; border-color: #fca5a5; padding: 6px 10px;" title="Pindahkan ke Sampah">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div style="grid-column: 1 / -1; background: #ffffff; border-radius: 16px; padding: 36px; text-align: center; color: #94a3b8; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-bullhorn" style="font-size: 36px; margin-bottom: 12px; color: #cbd5e1;"></i>
                <p style="font-size: 14px; font-weight: 700; color: #64748b; margin: 0;">Belum ada pengumuman sekolah atau pemberitahuan siswa telat.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Detail Pengumuman -->
<div id="guruDetailPengumumanModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa-solid fa-bullhorn" style="color: #384972;"></i> Detail Pengumuman Sekolah & Pemberitahuan Siswa Telat
            </h4>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div>
                <span id="detailKategori" style="font-size: 11px; background: #e0e7ff; color: #3730a3; padding: 3px 8px; border-radius: 6px; font-weight: 800;"></span>
                <span id="detailStatus" style="margin-left: 6px;"></span>
                <h3 id="detailJudul" style="font-size: 18px; font-weight: 800; color: #1e293b; margin-top: 8px; margin-bottom: 4px;"></h3>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px;">
                <div><strong>Kelas Target:</strong> <span id="detailKelas"></span></div>
                <div><strong>Jam Mengajar:</strong> <span id="detailJam"></span></div>
                <div><strong>Pembuat:</strong> <span id="detailPembuat"></span></div>
                <div><strong>Tanggal:</strong> <span id="detailTanggal"></span></div>
                <div style="grid-column: span 2;"><strong>Keterangan:</strong> <span id="detailKeterangan"></span></div>
            </div>

            <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 16px; font-size: 13.5px; line-height: 1.6; color: #334155; white-space: pre-line;" id="detailIsi">
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeDetailModal()" class="btn-detail" style="padding: 8px 20px;">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#selectAllPengumumanCheckboxes').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox-pengumuman').prop('checked', isChecked);
            updateBatchPengumumanState();
        });
    });

    function updateBatchPengumumanState() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox-pengumuman').length;

        $('#selectedCountPengumuman').text(count);

        if (totalItems > 0 && count === totalItems) {
            $('#selectAllPengumumanCheckboxes').prop('checked', true);
        } else {
            $('#selectAllPengumumanCheckboxes').prop('checked', false);
        }

        const btn = $('#btnBatchDeletePengumuman');
        if (count > 0) {
            btn.prop('disabled', false)
               .css({ opacity: 1, cursor: 'pointer', background: '#fee2e2', color: '#991b1b', border: '1px solid #fca5a5' });
        } else {
            btn.prop('disabled', true)
               .css({ opacity: 0.5, cursor: 'not-allowed' });
        }
    }

    function confirmBatchDeletePengumuman() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;

        if (count === 0) {
            alert('Silakan centang minimal satu pengumuman / pemberitahuan yang ingin dihapus.');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + count + ' pengumuman / pemberitahuan terpilih ke Sampah?')) {
            const container = $('#batchDeleteInputsContainer');
            container.empty();
            checkedItems.each(function() {
                container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
            });
            $('#formBatchDeletePengumuman').submit();
        }
    }

    function openDetailModal(data, kelasNama, pembuatNama, tanggalFormated) {
        document.getElementById('detailJudul').innerText = data.judul || '-';
        document.getElementById('detailKategori').innerText = data.kategori || 'Umum';
        document.getElementById('detailStatus').innerHTML = '<span class="status-badge-' + (data.status ? data.status.toLowerCase() : 'aktif') + '">' + (data.status ? data.status.toUpperCase() : 'AKTIF') + '</span>';
        document.getElementById('detailKelas').innerText = kelasNama;
        document.getElementById('detailJam').innerText = data.jam_mengajar || '-';
        document.getElementById('detailPembuat').innerText = pembuatNama;
        document.getElementById('detailTanggal').innerText = tanggalFormated;
        document.getElementById('detailKeterangan').innerText = data.keterangan || '-';
        document.getElementById('detailIsi').innerText = data.isi || '-';

        document.getElementById('guruDetailPengumumanModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('guruDetailPengumumanModal').style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('guruDetailPengumumanModal');
        if (event.target === modal) closeDetailModal();
    }
</script>
@endsection
