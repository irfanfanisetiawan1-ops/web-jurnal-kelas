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
        flex-wrap: wrap;
        gap: 12px;
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

    /* Stat Cards Grid (4 Kolom) */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-rose   { background: #ffe4e6; color: #e11d48; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-gold   { background: #fef3c7; color: #d97706; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
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

    .filter-input:focus {
        border-color: #384972;
        box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.1);
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

    .btn-mark-all-read {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2);
    }

    .btn-mark-all-read:hover {
        background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
    }

    .btn-trash-pink {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-trash-pink:hover {
        background: #ffe4e6;
        color: #9f1239;
    }

    /* Floating Batch Toolbar */
    .floating-batch-bar {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(120px);
        background: #0f172a;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 999;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .floating-batch-bar.show {
        transform: translateX(-50%) translateY(0);
    }

    /* Badges Status Baca / Baru vs Sudah Dibaca */
    .badge-unread-glow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(255, 65, 108, 0.35);
        animation: badgePulse 2s infinite;
    }

    .pulse-dot {
        width: 7px;
        height: 7px;
        background: #ffffff;
        border-radius: 50%;
        display: inline-block;
        animation: pulseScale 1.5s infinite;
    }

    @keyframes badgePulse {
        0%, 100% { box-shadow: 0 2px 8px rgba(255, 65, 108, 0.35); }
        50% { box-shadow: 0 3px 14px rgba(255, 65, 108, 0.6); }
    }

    @keyframes pulseScale {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.35); opacity: 0.7; }
    }

    .badge-read-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 20px;
    }

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
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .announcement-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    /* Unread Card Highlight Accent */
    .announcement-card.is-unread {
        background: #ffffff;
        border-color: #fecdd3;
        box-shadow: 0 4px 18px rgba(225, 29, 72, 0.05);
    }

    .announcement-card.is-read-done {
        background: #fcfdfd;
        border-color: #e2e8f0;
        opacity: 0.96;
    }

    .card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        gap: 8px;
        flex-wrap: wrap;
    }

    .card-badges-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .card-badges-right {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .category-badge {
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        background: #e0e7ff;
        color: #3730a3;
    }

    .category-badge-telat {
        font-size: 11px;
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
        gap: 8px;
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
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        background: #384972;
        color: #ffffff;
    }

    .btn-read-toggle {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }

    .btn-read-toggle:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-read-toggle.is-unread-action {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }

    .btn-read-toggle.is-unread-action:hover {
        background: #d1fae5;
    }

    .btn-read-toggle.is-read-action {
        background: #f1f5f9;
        color: #64748b;
        border-color: #cbd5e1;
    }

    .btn-read-toggle.is-read-action:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    /* Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
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
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }

    /* Toast Notification */
    #pengumumanToast {
        display: none;
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #1e293b;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 9999;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
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

    <!-- 1. Stat Cards Grid (4 Kolom Lengkap dengan Indikator Baca) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Pengumuman</span>
                    <span class="stat-val" id="statTotalVal">{{ $stats['totalPengumuman'] }} Data</span>
                </div>
            </div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #f43f5e;">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-rose">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Baru (Belum Dibaca)</span>
                    <span class="stat-val" id="statUnreadVal" style="color: #e11d48;">{{ $stats['totalUnread'] }} Baru</span>
                </div>
            </div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #059669;">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Sudah Dibaca</span>
                    <span class="stat-val" id="statReadVal" style="color: #059669;">{{ $stats['totalRead'] }} Selesai</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-gold">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Aktif</span>
                    <span class="stat-val" id="statAktifVal">{{ $stats['pengumumanAktif'] }} Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 12px; font-size: 13.5px; font-weight: 700;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- 2. Filter Bar & Aksi Massal -->
    <div class="filter-card">
        <form action="{{ route('guru.pengumuman') }}" method="GET" class="filter-grid">
            <div style="flex: 1.5; min-width: 180px;">
                <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari Judul / Isi / Kategori..." style="width: 100%;">
            </div>

            <div>
                <select name="read_status" class="filter-input" style="font-weight: 700; color: #0f172a;">
                    <option value="">Status Baca: Semua</option>
                    <option value="unread" {{ $readStatusFilter === 'unread' ? 'selected' : '' }}>🔴 Baru (Belum Dibaca)</option>
                    <option value="read" {{ $readStatusFilter === 'read' ? 'selected' : '' }}>🟢 Sudah Dibaca</option>
                </select>
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
                    <option value="">Status: Semua</option>
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

            <!-- Tombol Tandai Semua Sudah Dibaca -->
            <button type="button" class="btn-mark-all-read" onclick="markAllAsRead()" title="Tandai semua pengumuman yang tampil sebagai sudah dibaca">
                <i class="fa-solid fa-check-double"></i> Tandai Semua Sudah Dibaca
            </button>

            <!-- Aksi Sampah di Sebelah Kanan -->
            <div style="margin-left: auto; display: inline-flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <!-- Tombol Sampah -->
                <a href="{{ route('guru.pengumuman.trash') }}" class="btn-trash-pink" style="padding: 10px 16px; border-radius: 10px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount ?? 0 }})
                </a>
            </div>
        </form>
    </div>

    <!-- Form Tersembunyi untuk Batch Delete -->
    <form id="formBatchDeletePengumuman" action="{{ route('guru.pengumuman.destroy-batch') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <div id="batchDeleteInputsContainer"></div>
    </form>

    <!-- Sub-bar Checkbox Pilih Semua -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px; background: #ffffff; padding: 12px 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <label style="font-size: 13px; font-weight: 800; color: #334155; cursor: pointer; display: flex; align-items: center; gap: 8px; margin: 0;">
            <input type="checkbox" id="selectAllPengumumanCheckboxes" style="width: 17px; height: 17px; cursor: pointer;">
            Pilih Semua Pengumuman / Pemberitahuan
        </label>
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
                $isRead = in_array($row->id_pengumuman, $readAnnouncementIds);
            @endphp

            @if($isTelat)
                <!-- Tampilan Khusus: Pemberitahuan Siswa Telat (Dari Guru Piket) -->
                <div class="announcement-card {{ $isRead ? 'is-read-done' : 'is-unread' }}" id="card-pengumuman-{{ $row->id_pengumuman }}" style="background: #fffdf5; border-left: 5px solid #f59e0b; border: 1px solid #fef3c7; border-left-width: 5px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.08);">
                    <div>
                        <div class="card-top">
                            <div class="card-badges-left">
                                <input type="checkbox" value="{{ $row->id_pengumuman }}" class="item-checkbox-pengumuman" style="width: 17px; height: 17px; cursor: pointer;" onchange="updateBatchPengumumanState()">
                                <span class="category-badge-telat">
                                    <i class="fa-solid fa-user-clock"></i> Siswa Telat
                                </span>
                            </div>

                            <div class="card-badges-right">
                                <!-- Indikator Status Baca: Baru vs Sudah Dibaca -->
                                <div id="badge-read-wrapper-{{ $row->id_pengumuman }}">
                                    @if(!$isRead)
                                        <span class="badge-unread-glow" title="Pengumuman baru yang belum Anda baca">
                                            <span class="pulse-dot"></span>
                                            <i class="fa-solid fa-sparkles"></i> BARU
                                        </span>
                                    @else
                                        <span class="badge-read-status" title="Anda sudah membaca pengumuman ini">
                                            <i class="fa-solid fa-circle-check"></i> Sudah Dibaca
                                        </span>
                                    @endif
                                </div>

                                <span class="status-badge-aktif" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                    <i class="fa-solid fa-clock"></i> Telat
                                </span>
                            </div>
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

                    <div class="card-footer" style="border-top-color: #fef3c7;">
                        <div class="author-info">
                            <div class="author-avatar" style="background: #d97706;"><i class="fa-solid fa-user-shield"></i></div>
                            <span class="author-name" style="color: #92400e;">Guru Piket Sekolah</span>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <!-- Tombol Toggle Baca / Belum Baca -->
                            <button type="button" 
                                    id="btn-toggle-read-{{ $row->id_pengumuman }}"
                                    class="btn-read-toggle {{ $isRead ? 'is-read-action' : 'is-unread-action' }}" 
                                    onclick="toggleReadStatus({{ $row->id_pengumuman }})" 
                                    title="{{ $isRead ? 'Tandai sebagai Belum Dibaca (Baru)' : 'Tandai sebagai Sudah Dibaca' }}">
                                <i class="{{ $isRead ? 'fa-regular fa-envelope' : 'fa-solid fa-envelope-open' }}"></i>
                            </button>

                            <button type="button" class="btn-detail" style="background: #fef3c7; color: #b45309; border-color: #fde68a;" onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "Guru Piket Sekolah", "{{ $tanggalFormated }}", {{ $row->id_pengumuman }})'>
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
                <div class="announcement-card {{ $isRead ? 'is-read-done' : 'is-unread' }}" id="card-pengumuman-{{ $row->id_pengumuman }}" style="border-left: 5px solid {{ $isRead ? '#94a3b8' : '#384972' }};">
                    <div>
                        <div class="card-top">
                            <div class="card-badges-left">
                                <input type="checkbox" value="{{ $row->id_pengumuman }}" class="item-checkbox-pengumuman" style="width: 17px; height: 17px; cursor: pointer;" onchange="updateBatchPengumumanState()">
                                <span class="category-badge">{{ $row->kategori ?? 'Umum' }}</span>
                            </div>

                            <div class="card-badges-right">
                                <!-- Indikator Status Baca: Baru vs Sudah Dibaca -->
                                <div id="badge-read-wrapper-{{ $row->id_pengumuman }}">
                                    @if(!$isRead)
                                        <span class="badge-unread-glow" title="Pengumuman baru yang belum Anda baca">
                                            <span class="pulse-dot"></span>
                                            <i class="fa-solid fa-sparkles"></i> BARU
                                        </span>
                                    @else
                                        <span class="badge-read-status" title="Anda sudah membaca pengumuman ini">
                                            <i class="fa-solid fa-circle-check"></i> Sudah Dibaca
                                        </span>
                                    @endif
                                </div>

                                <span class="{{ $stClass }}">{{ $stTeks }}</span>
                            </div>
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

                    <div class="card-footer">
                        <div class="author-info">
                            <div class="author-avatar">{{ strtoupper(substr($pembuatNama, 0, 1)) }}</div>
                            <span class="author-name">{{ $pembuatNama }}</span>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <!-- Tombol Toggle Baca / Belum Baca -->
                            <button type="button" 
                                    id="btn-toggle-read-{{ $row->id_pengumuman }}"
                                    class="btn-read-toggle {{ $isRead ? 'is-read-action' : 'is-unread-action' }}" 
                                    onclick="toggleReadStatus({{ $row->id_pengumuman }})" 
                                    title="{{ $isRead ? 'Tandai sebagai Belum Dibaca (Baru)' : 'Tandai sebagai Sudah Dibaca' }}">
                                <i class="{{ $isRead ? 'fa-regular fa-envelope' : 'fa-solid fa-envelope-open' }}"></i>
                            </button>

                            <button type="button" class="btn-detail" onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "{{ addslashes($pembuatNama) }}", "{{ $tanggalFormated }}", {{ $row->id_pengumuman }})'>
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
            <div style="grid-column: 1 / -1; background: #ffffff; border-radius: 16px; padding: 48px 24px; text-align: center; color: #94a3b8; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-bullhorn" style="font-size: 40px; margin-bottom: 14px; color: #cbd5e1;"></i>
                <p style="font-size: 15px; font-weight: 700; color: #64748b; margin: 0 0 6px 0;">Belum ada pengumuman sekolah atau pemberitahuan siswa telat.</p>
                <p style="font-size: 13px; color: #94a3b8; margin: 0;">Pengumuman resmi dari Waka Kurikulum dan laporan keterlambatan dari Guru Piket akan muncul di halaman ini.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Detail Pengumuman -->
<div id="guruDetailPengumumanModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-bullhorn" style="color: #384972;"></i> Detail Informasi Pengumuman
            </h4>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span id="detailKategori" style="font-size: 11px; background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 6px; font-weight: 800;"></span>
                <span id="detailStatus"></span>
                <span id="detailReadBadge" style="margin-left: auto;"></span>
            </div>

            <h3 id="detailJudul" style="font-size: 18px; font-weight: 800; color: #1e293b; margin-top: 4px; margin-bottom: 4px; line-height: 1.3;"></h3>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px;">
                <div><strong style="color: #64748b;">Kelas Target:</strong> <span id="detailKelas" style="color: #0f172a; font-weight: 700;"></span></div>
                <div><strong style="color: #64748b;">Jam Mengajar:</strong> <span id="detailJam" style="color: #0f172a; font-weight: 700;"></span></div>
                <div><strong style="color: #64748b;">Pembuat:</strong> <span id="detailPembuat" style="color: #0f172a; font-weight: 700;"></span></div>
                <div><strong style="color: #64748b;">Tanggal:</strong> <span id="detailTanggal" style="color: #0f172a; font-weight: 700;"></span></div>
                <div style="grid-column: span 2;"><strong style="color: #64748b;">Keterangan:</strong> <span id="detailKeterangan" style="color: #0f172a; font-weight: 700;"></span></div>
            </div>

            <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 16px; font-size: 13.5px; line-height: 1.6; color: #334155; white-space: pre-line; max-height: 250px; overflow-y: auto;" id="detailIsi">
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div id="modalFooterToggleRead">
                <!-- Diisi via JS untuk toggle langsung dari dalam modal -->
            </div>
            <button type="button" onclick="closeDetailModal()" class="btn-detail" style="padding: 9px 24px; font-size: 13px;">Tutup</button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="pengumumanToast">
    <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 18px;"></i>
    <span id="toastMessage">Pemberitahuan berhasil diperbarui</span>
</div>

<!-- Floating Batch Action Toolbar -->
<div id="floatingBatchBar" class="floating-batch-bar">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px; font-weight: 800;">0</span>
        <span>Pengumuman Terpilih</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="confirmBatchDeletePengumuman()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
        </button>
        <button type="button" onclick="uncheckAllPengumuman()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
            Batal
        </button>
    </div>
</div>

<!-- Modal Batch Delete Confirmation -->
<div id="modalBatchDeletePengumuman" class="modal-overlay">
    <div class="modal-content" style="max-width: 460px; text-align: center; padding: 28px 24px;">
        <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Hapus Pengumuman Terpilih ke Sampah?</h3>
        <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
            Anda akan memindahkan <strong id="modalBatchPengumumanCount" style="color: #ef4444;">0</strong> pengumuman terpilih ke Tempat Sampah dan dapat dipulihkan kapan saja.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" onclick="closeBatchDeletePengumumanModal()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                Batal
            </button>
            <button type="button" onclick="submitBatchDeletePengumuman()" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                Ya, Hapus Terpilih
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

    $(document).ready(function() {
        $('#selectAllPengumumanCheckboxes').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox-pengumuman').prop('checked', isChecked);
            updateBatchPengumumanState();
        });
    });

    function showToast(message, isSuccess = true) {
        const toast = $('#pengumumanToast');
        const icon = toast.find('i');
        $('#toastMessage').text(message);
        
        if (isSuccess) {
            icon.attr('class', 'fa-solid fa-circle-check').css('color', '#10b981');
        } else {
            icon.attr('class', 'fa-solid fa-circle-exclamation').css('color', '#ef4444');
        }

        toast.stop(true, true).fadeIn(200).delay(3000).fadeOut(300);
    }

    function updateBatchPengumumanState() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox-pengumuman').length;
        const bar = $('#floatingBatchBar');
        const badge = $('#selectedCountBadge');

        badge.text(count);

        if (totalItems > 0 && count === totalItems) {
            $('#selectAllPengumumanCheckboxes').prop('checked', true);
        } else {
            $('#selectAllPengumumanCheckboxes').prop('checked', false);
        }

        if (count > 0) {
            bar.addClass('show');
        } else {
            bar.removeClass('show');
        }
    }

    function uncheckAllPengumuman() {
        $('.item-checkbox-pengumuman').prop('checked', false);
        $('#selectAllPengumumanCheckboxes').prop('checked', false);
        updateBatchPengumumanState();
    }

    function confirmBatchDeletePengumuman() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const count = checkedItems.length;

        if (count === 0) {
            showToast('Silakan centang minimal satu pengumuman yang ingin dihapus.', false);
            return;
        }

        $('#modalBatchPengumumanCount').text(count);
        $('#modalBatchDeletePengumuman').css('display', 'flex');
    }

    function closeBatchDeletePengumumanModal() {
        $('#modalBatchDeletePengumuman').css('display', 'none');
    }

    function submitBatchDeletePengumuman() {
        const checkedItems = $('.item-checkbox-pengumuman:checked');
        const container = $('#batchDeleteInputsContainer');
        container.empty();
        checkedItems.each(function() {
            container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
        });
        $('#formBatchDeletePengumuman').submit();
    }

    /**
     * Update UI Card State (Read vs Unread)
     */
    function updateCardReadUI(id, isRead) {
        const card = $('#card-pengumuman-' + id);
        const badgeWrapper = $('#badge-read-wrapper-' + id);
        const toggleBtn = $('#btn-toggle-read-' + id);

        if (isRead) {
            // Card becomes marked as read
            card.removeClass('is-unread').addClass('is-read-done');
            badgeWrapper.html(`
                <span class="badge-read-status" title="Anda sudah membaca pengumuman ini">
                    <i class="fa-solid fa-circle-check"></i> Sudah Dibaca
                </span>
            `);
            toggleBtn.removeClass('is-unread-action').addClass('is-read-action')
                     .attr('title', 'Tandai sebagai Belum Dibaca (Baru)')
                     .html('<i class="fa-regular fa-envelope"></i>');
        } else {
            // Card becomes marked as unread
            card.removeClass('is-read-done').addClass('is-unread');
            badgeWrapper.html(`
                <span class="badge-unread-glow" title="Pengumuman baru yang belum Anda baca">
                    <span class="pulse-dot"></span>
                    <i class="fa-solid fa-sparkles"></i> BARU
                </span>
            `);
            toggleBtn.removeClass('is-read-action').addClass('is-unread-action')
                     .attr('title', 'Tandai sebagai Sudah Dibaca')
                     .html('<i class="fa-solid fa-envelope-open"></i>');
        }
    }

    /**
     * Recalculate local stats counters based on DOM
     */
    function refreshStatsFromDOM() {
        const totalCards = $('.announcement-card').length;
        const unreadCards = $('.badge-unread-glow').length;
        const readCards = $('.badge-read-status').length;

        $('#statUnreadVal').text(unreadCards + ' Baru');
        $('#statReadVal').text(readCards + ' Selesai');

        // Update sidebar unread badge live
        const sidebarBadge = $('#sidebarPengumumanUnreadBadge');
        if (sidebarBadge.length) {
            sidebarBadge.text(unreadCards);
            if (unreadCards > 0) {
                sidebarBadge.css('display', 'inline-flex');
            } else {
                sidebarBadge.css('display', 'none');
            }
        }
    }

    /**
     * Toggle Read/Unread Status via AJAX
     */
    function toggleReadStatus(id) {
        $.ajax({
            url: '/guru-pengumuman/' + id + '/toggle-read',
            type: 'POST',
            data: {
                _token: csrfToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCardReadUI(id, response.is_read);
                    refreshStatsFromDOM();
                    showToast(response.message);

                    // If modal is open for this item, update modal badge
                    if ($('#guruDetailPengumumanModal').is(':visible')) {
                        updateModalReadBadge(response.is_read);
                    }
                }
            },
            error: function() {
                showToast('Gagal mengubah status baca. Silakan coba lagi.', false);
            }
        });
    }

    /**
     * Mark single announcement as Read (Automatically triggered when viewing details)
     */
    function markAsReadSilent(id) {
        $.ajax({
            url: '/guru-pengumuman/' + id + '/mark-read',
            type: 'POST',
            data: {
                _token: csrfToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCardReadUI(id, true);
                    refreshStatsFromDOM();
                    updateModalReadBadge(true);
                }
            }
        });
    }

    /**
     * Mark All announcements as Read via AJAX
     */
    function markAllAsRead() {
        if (!confirm('Tandai semua pengumuman sebagai sudah dibaca?')) return;

        $.ajax({
            url: '{{ route("guru.pengumuman.mark-all-read") }}',
            type: 'POST',
            data: {
                _token: csrfToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.announcement-card').each(function() {
                        const cardId = $(this).attr('id');
                        if (cardId) {
                            const id = cardId.replace('card-pengumuman-', '');
                            updateCardReadUI(id, true);
                        }
                    });
                    refreshStatsFromDOM();
                    showToast(response.message || 'Semua pengumuman berhasil ditandai sudah dibaca.');
                }
            },
            error: function() {
                showToast('Gagal memproses permintaan.', false);
            }
        });
    }

    function updateModalReadBadge(isRead) {
        if (isRead) {
            $('#detailReadBadge').html(`
                <span class="badge-read-status" style="font-size: 11.5px; padding: 4px 10px;">
                    <i class="fa-solid fa-circle-check"></i> Sudah Dibaca
                </span>
            `);
        } else {
            $('#detailReadBadge').html(`
                <span class="badge-unread-glow" style="font-size: 11.5px; padding: 4px 10px;">
                    <span class="pulse-dot"></span>
                    <i class="fa-solid fa-sparkles"></i> BARU / BELUM DIBACA
                </span>
            `);
        }
    }

    function openDetailModal(data, kelasNama, pembuatNama, tanggalFormated, idPengumuman) {
        document.getElementById('detailJudul').innerText = data.judul || '-';
        document.getElementById('detailKategori').innerText = data.kategori || 'Umum';
        document.getElementById('detailStatus').innerHTML = '<span class="status-badge-' + (data.status ? data.status.toLowerCase() : 'aktif') + '">' + (data.status ? data.status.toUpperCase() : 'AKTIF') + '</span>';
        document.getElementById('detailKelas').innerText = kelasNama;
        document.getElementById('detailJam').innerText = data.jam_mengajar || '-';
        document.getElementById('detailPembuat').innerText = pembuatNama;
        document.getElementById('detailTanggal').innerText = tanggalFormated;
        document.getElementById('detailKeterangan').innerText = data.keterangan || '-';
        document.getElementById('detailIsi').innerText = data.isi || '-';

        // Check current read status
        const isCurrentlyRead = $('#card-pengumuman-' + idPengumuman).hasClass('is-read-done');
        updateModalReadBadge(true); // Since opening detail marks it read

        // Footer button to toggle
        $('#modalFooterToggleRead').html(`
            <button type="button" class="btn-read-toggle is-read-action" onclick="toggleReadStatus(${idPengumuman})" style="padding: 8px 14px; font-size: 12.5px;">
                <i class="fa-regular fa-envelope"></i> Ubah Status Jadi Belum Dibaca
            </button>
        `);

        // Trigger mark as read automatically upon opening detail
        if (idPengumuman) {
            markAsReadSilent(idPengumuman);
        }

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
