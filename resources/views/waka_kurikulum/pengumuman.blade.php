@extends('layouts.waka_kurikulum')

@section('title', 'Pengumuman Kurikulum & Akademik — EDU JOURNAL')

@section('styles')
<style>
    /* ─── Main Container ─── */
    .pengumuman-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ─── Page Header ─── */
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-breadcrumb {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }

    .page-breadcrumb a:hover {
        color: #2563eb;
    }

    .page-main-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    /* ─── 4 Primary Stat Cards ─── */
    .stat-cards-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .stat-box-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
        text-decoration: none;
        color: inherit;
    }

    .stat-box-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }

    .stat-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-circle-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .icon-circle-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .icon-circle-gray   { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
    .icon-circle-orange { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }

    .stat-content {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .stat-label-text {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 1px;
    }

    .stat-number-text {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .stat-subtext {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* ─── Filter Bar Card ─── */
    .filter-card-panel {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
    }

    .filter-form-grid {
        display: grid;
        grid-template-columns: 200px 170px 1fr auto;
        gap: 12px;
        align-items: end;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .form-label-filter {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }

    .input-filter {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .input-filter:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* ─── Buttons ─── */
    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        line-height: 1.2;
        font-family: inherit;
    }

    .btn-action-primary {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .btn-action-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-action-secondary {
        background: #f8fafc;
        color: #334155;
        border-color: #cbd5e1;
    }

    .btn-action-secondary:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-action-danger {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .btn-action-danger:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-action-edit {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .btn-action-edit:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-action-detail {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
    }

    .btn-action-detail:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* ─── Announcement Cards Grid ─── */
    .announcement-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 16px;
    }

    .announcement-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 18px 20px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }

    .card-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    /* ─── Category Badges ─── */
    .badge-category {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .cat-kurikulum      { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .cat-asesmen        { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .cat-jadwal         { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
    .cat-rapat          { background: #f0fdfa; color: #0d9488; border: 1px solid #99f6e4; }
    .cat-workshop       { background: #ecfeff; color: #0891b2; border: 1px solid #a5f3fc; }
    .cat-siswa-telat    { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .cat-umum           { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    /* ─── Status Badges ─── */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .badge-status-aktif   { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-status-selesai { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

    .card-title-text {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        margin: 0 0 6px 0;
        cursor: pointer;
        transition: color 0.15s;
    }

    .card-title-text:hover {
        color: #2563eb;
    }

    .card-snippet-text {
        font-size: 12.5px;
        color: #475569;
        line-height: 1.55;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        font-size: 11.5px;
        color: #64748b;
        flex-wrap: wrap;
        gap: 8px;
    }

    .meta-info-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* ─── Modals ─── */
    .modal-overlay-custom {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(3px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-overlay-custom.show {
        display: flex;
    }

    .modal-dialog-custom {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: modalSlideUp 0.2s ease-out;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    .modal-dialog-custom.modal-lg {
        max-width: 720px;
    }

    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(15px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 2px;
        line-height: 1;
        transition: color 0.2s;
    }

    .modal-close-btn:hover {
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .modal-footer-custom {
        padding: 12px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .form-label-custom {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
    }

    .form-input-custom, .form-textarea-custom, .form-select-custom {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        font-family: inherit;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-input-custom:focus, .form-textarea-custom:focus, .form-select-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .stat-cards-row { grid-template-columns: repeat(2, 1fr); }
        .filter-form-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 640px) {
        .stat-cards-row { grid-template-columns: 1fr; }
        .filter-form-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 18px; color: #ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header-box">
        <div>
            <div class="page-breadcrumb">
                <a href="{{ route('waka-kurikulum.dashboard') }}">EDU JOURNAL</a>
                <span>&gt;</span>
                <a href="{{ route('waka-kurikulum.dashboard') }}">Portal Kurikulum</a>
                <span>&gt;</span>
                <span style="color: #2563eb;">Pengumuman Kurikulum &amp; Akademik</span>
            </div>
            <h1 class="page-main-title">Pengumuman Kurikulum &amp; Akademik</h1>
            <p class="page-sub-title">Publikasi agenda KBM, jadwal supervisi, asesmen, informasi kurikulum, dan pengumuman kedinasan sekolah.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <button type="button" class="btn-table-action btn-action-secondary" onclick="openTrashModal()">
                <i class="fa-solid fa-trash-can"></i>
                <span>Kotak Sampah</span>
                @if($trashedCount > 0)
                    <span style="background: #ef4444; color: #ffffff; padding: 1px 6px; border-radius: 10px; font-size: 10px; font-weight: 800;">{{ $trashedCount }}</span>
                @endif
            </button>
            <button type="button" class="btn-table-action btn-action-primary" onclick="openTambahModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Buat Pengumuman</span>
            </button>
        </div>
    </div>

    <!-- 4 Primary Stat Cards Row (Gray, White, Light Gray Theme) -->
    <div class="stat-cards-row">
        <!-- Card 1: Total Pengumuman -->
        <div class="stat-box-card">
            <div class="stat-icon-circle icon-circle-blue">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Total Pengumuman</span>
                <span class="stat-number-text">{{ number_format($totalCount, 0, ',', '.') }}</span>
                <span class="stat-subtext">Seluruh Publikasi Informasi</span>
            </div>
        </div>

        <!-- Card 2: Pengumuman Aktif -->
        <div class="stat-box-card">
            <div class="stat-icon-circle icon-circle-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Pengumuman Aktif</span>
                <span class="stat-number-text" style="color: #16a34a;">{{ number_format($activeCount, 0, ',', '.') }}</span>
                <span class="stat-subtext" style="color: #16a34a;">Sedang Ditayangkan</span>
            </div>
        </div>

        <!-- Card 3: Pengumuman Selesai -->
        <div class="stat-box-card">
            <div class="stat-icon-circle icon-circle-gray">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Pengumuman Selesai</span>
                <span class="stat-number-text" style="color: #64748b;">{{ number_format($selesaiCount, 0, ',', '.') }}</span>
                <span class="stat-subtext">Arsip Agenda Terlaksana</span>
            </div>
        </div>

        <!-- Card 4: Kotak Sampah -->
        <a href="javascript:void(0)" onclick="openTrashModal()" class="stat-box-card" title="Buka Kotak Sampah">
            <div class="stat-icon-circle icon-circle-orange">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Kotak Sampah</span>
                <span class="stat-number-text" style="color: {{ $trashedCount > 0 ? '#ea580c' : '#0f172a' }};">{{ number_format($trashedCount, 0, ',', '.') }}</span>
                <span class="stat-subtext">Pengumuman Terhapus</span>
            </div>
        </a>
    </div>

    <!-- Filter & Search Bar Panel -->
    <div class="filter-card-panel">
        <form method="GET" action="{{ route('waka-kurikulum.pengumuman') }}" class="filter-form-grid">
            <div class="form-group-filter">
                <label class="form-label-filter">Kategori Pengumuman</label>
                <select name="kategori" class="input-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach(['Kurikulum', 'Asesmen', 'Perubahan Jadwal', 'Rapat', 'Workshop', 'Umum'] as $kat)
                        <option value="{{ $kat }}" {{ ($kategori === $kat) ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label class="form-label-filter">Status Penayangan</label>
                <select name="status" class="input-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ ($status === 'aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ ($status === 'selesai') ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group-filter">
                <label class="form-label-filter">Pencarian Judul / Isi</label>
                <input type="text" name="search" value="{{ $search }}" class="input-filter" placeholder="Ketik kata kunci judul atau isi pengumuman...">
            </div>

            <div style="display: flex; gap: 6px;">
                <button type="submit" class="btn-table-action btn-action-primary" style="height: 38px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-kurikulum.pengumuman') }}" class="btn-table-action btn-action-secondary" style="height: 38px;" title="Reset Filter">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Announcement Cards Grid -->
    @if($pengumumanList->isEmpty())
        <div style="text-align: center; padding: 48px 20px; background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; color: #94a3b8;">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: #f8fafc; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 12px; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <h4 style="font-size: 15px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Tidak Ada Pengumuman Ditemukan</h4>
            <p style="font-size: 12.5px; color: #64748b; margin: 0 0 16px 0;">Belum ada pengumuman yang sesuai dengan filter atau kata kunci yang dipilih.</p>
            <button type="button" class="btn-table-action btn-action-primary" onclick="openTambahModal()">
                <i class="fa-solid fa-plus"></i> Buat Pengumuman Baru
            </button>
        </div>
    @else
        <div class="announcement-grid">
            @foreach($pengumumanList as $p)
                @php
                    $cat = strtolower($p->kategori ?? 'umum');
                    $catClass = 'cat-umum';
                    if (str_contains($cat, 'kurikulum')) { $catClass = 'cat-kurikulum'; }
                    elseif (str_contains($cat, 'asesmen') || str_contains($cat, 'ujian')) { $catClass = 'cat-asesmen'; }
                    elseif (str_contains($cat, 'jadwal')) { $catClass = 'cat-jadwal'; }
                    elseif (str_contains($cat, 'rapat')) { $catClass = 'cat-rapat'; }
                    elseif (str_contains($cat, 'workshop') || str_contains($cat, 'pelatihan')) { $catClass = 'cat-workshop'; }
                @endphp
                <div class="announcement-card">
                    <div>
                        <div class="card-top-row">
                            <span class="badge-category {{ $catClass }}">
                                <i class="fa-solid fa-tag" style="font-size: 9.5px;"></i>
                                <span>{{ $p->kategori ?? 'Umum' }}</span>
                            </span>
                            <span class="badge-status {{ $p->status === 'aktif' ? 'badge-status-aktif' : 'badge-status-selesai' }}">
                                <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                <span>{{ strtoupper($p->status) }}</span>
                            </span>
                        </div>

                        <h3 class="card-title-text" onclick="openDetailModal({{ $p->id_pengumuman }})" title="Klik untuk membaca selengkapnya" style="margin-top: 10px;">
                            {{ $p->judul }}
                        </h3>

                        <p class="card-snippet-text">
                            {{ $p->isi }}
                        </p>
                    </div>

                    <div class="card-footer-meta">
                        <div class="meta-info-left">
                            <span class="meta-item" title="Tanggal Efektif Pengumuman">
                                <i class="fa-solid fa-calendar-days" style="color: #94a3b8;"></i>
                                <span>{{ Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</span>
                            </span>
                            <span class="meta-item" title="Penulis / Pembuat Pengumuman">
                                <i class="fa-solid fa-user-pen" style="color: #94a3b8;"></i>
                                <span>{{ $p->pembuat->nama_guru ?? ($p->keterangan ?? 'Waka Kurikulum') }}</span>
                            </span>
                        </div>

                        <div style="display: flex; align-items: center; gap: 6px;">
                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $p->id_pengumuman }})" title="Lihat Rincian Pengumuman" style="padding: 5px 9px;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button type="button" class="btn-table-action btn-action-edit" onclick="openEditModal({{ json_encode($p) }})" title="Edit Pengumuman" style="padding: 5px 9px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('waka-kurikulum.pengumuman.destroy', $p->id_pengumuman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan pengumuman ini ke kotak sampah?')" style="display: inline; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-table-action btn-action-danger" title="Pindahkan ke Kotak Sampah" style="padding: 5px 9px;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Custom Pagination -->
        <div style="margin-top: 14px;">
            {{ $pengumumanList->links('partials.custom-pagination') }}
        </div>
    @endif

</div>

<!-- ========================================================================= -->
<!-- 1. MODAL TAMBAH PENGUMUMAN                                               -->
<!-- ========================================================================= -->
<div class="modal-overlay-custom" id="modalTambah">
    <div class="modal-dialog-custom">
        <form action="{{ route('waka-kurikulum.pengumuman.store') }}" method="POST">
            @csrf
            <div class="modal-header-custom">
                <h3>
                    <i class="fa-solid fa-bullhorn" style="color: #2563eb;"></i>
                    <span>Publikasikan Pengumuman Baru</span>
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalTambah')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group-custom">
                    <label class="form-label-custom">Judul Pengumuman <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="judul" class="form-input-custom" placeholder="Contoh: Jadwal Pelaksanaan Asesmen Sumatif Akhir Semester" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Kategori Pengumuman <span style="color: #ef4444;">*</span></label>
                        <select name="kategori" class="form-select-custom" required>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Asesmen">Asesmen</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Tanggal Efektif <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" class="form-input-custom" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Status Penayangan</label>
                        <select name="status" class="form-select-custom" required>
                            <option value="aktif">Aktif (Ditayangkan)</option>
                            <option value="selesai">Selesai (Arsip)</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Keterangan / Target Sasaran</label>
                        <input type="text" name="keterangan" class="form-input-custom" placeholder="Contoh: Seluruh Guru & Tendik" value="Waka Kurikulum">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Isi Lengkap Pengumuman &amp; Instruksi <span style="color: #ef4444;">*</span></label>
                    <textarea name="isi" class="form-textarea-custom" rows="6" placeholder="Tuliskan isi instruksi atau detail pengumuman kurikulum secara jelas dan lengkap..." required></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-table-action btn-action-secondary" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-primary">
                    <i class="fa-solid fa-paper-plane"></i> Publikasikan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 2. MODAL EDIT PENGUMUMAN                                                 -->
<!-- ========================================================================= -->
<div class="modal-overlay-custom" id="modalEdit">
    <div class="modal-dialog-custom">
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header-custom">
                <h3>
                    <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
                    <span>Edit Pengumuman Kurikulum</span>
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalEdit')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <div class="form-group-custom">
                    <label class="form-label-custom">Judul Pengumuman <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="judul" id="edit_judul" class="form-input-custom" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Kategori Pengumuman</label>
                        <select name="kategori" id="edit_kategori" class="form-select-custom" required>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Asesmen">Asesmen</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Tanggal Efektif</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-input-custom" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Status</label>
                        <select name="status" id="edit_status" class="form-select-custom" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Keterangan / Target Sasaran</label>
                        <input type="text" name="keterangan" id="edit_keterangan" class="form-input-custom">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Isi Pengumuman <span style="color: #ef4444;">*</span></label>
                    <textarea name="isi" id="edit_isi" class="form-textarea-custom" rows="6" required></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-table-action btn-action-secondary" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 3. MODAL DETAIL PENGUMUMAN (AJAX)                                        -->
<!-- ========================================================================= -->
<div class="modal-overlay-custom" id="modalDetail">
    <div class="modal-dialog-custom modal-lg">
        <div class="modal-header-custom">
            <h3>
                <i class="fa-solid fa-file-lines" style="color: #2563eb;"></i>
                <span>Rincian Informasi Pengumuman</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div class="modal-body-custom" id="detailPengumumanBody">
            <div style="text-align: center; padding: 24px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 22px; color: #2563eb;"></i>
                <p style="margin-top: 8px; font-weight: 600; font-size: 12.5px;">Memuat rincian pengumuman kurikulum...</p>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-table-action btn-action-secondary" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 4. MODAL KOTAK SAMPAH (TRASH MANAGEMENT)                                 -->
<!-- ========================================================================= -->
<div class="modal-overlay-custom" id="modalTrash">
    <div class="modal-dialog-custom modal-lg">
        <div class="modal-header-custom">
            <h3>
                <i class="fa-solid fa-trash-can" style="color: #ea580c;"></i>
                <span>Kotak Sampah Pengumuman Kurikulum</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalTrash')">&times;</button>
        </div>
        <div class="modal-body-custom">
            @if($trashedList->isEmpty())
                <div style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-trash-arrow-up" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px;"></i>
                    <h4 style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 0 0 2px 0;">Kotak Sampah Kosong</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Tidak ada pengumuman yang berada di kotak sampah saat ini.</p>
                </div>
            @else
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #fff7ed; border-radius: 8px; border: 1px solid #ffedd5; margin-bottom: 8px;">
                    <div style="font-size: 12px; font-weight: 700; color: #9a3412;">
                        Terdapat {{ $trashedList->count() }} pengumuman di kotak sampah.
                    </div>
                    <form action="{{ route('waka-kurikulum.pengumuman.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS PERMANEN seluruh pengumuman di kotak sampah? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-table-action btn-action-danger" style="padding: 5px 10px; font-size: 11.5px;">
                            <i class="fa-solid fa-dumpster-fire"></i> Kosongkan Kotak Sampah
                        </button>
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">
                                <th style="padding: 8px 10px; color: #475569;">Judul Pengumuman</th>
                                <th style="padding: 8px 10px; color: #475569;">Kategori</th>
                                <th style="padding: 8px 10px; color: #475569;">Tanggal Hapus</th>
                                <th style="padding: 8px 10px; text-align: center; color: #475569;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedList as $t)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 8px 10px; font-weight: 700; color: #0f172a; max-width: 260px;">
                                        {{ $t->judul }}
                                    </td>
                                    <td style="padding: 8px 10px;">
                                        <span class="badge-category cat-umum" style="font-size: 10px; padding: 2px 6px;">{{ $t->kategori ?? 'Umum' }}</span>
                                    </td>
                                    <td style="padding: 8px 10px; color: #64748b;">
                                        {{ $t->deleted_at ? $t->deleted_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td style="padding: 8px 10px; text-align: center;">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <form action="{{ route('waka-kurikulum.pengumuman.restore', $t->id_pengumuman) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-table-action btn-action-primary" style="padding: 4px 8px; font-size: 11px;" title="Pulihkan Pengumuman">
                                                    <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                                </button>
                                            </form>
                                            <form action="{{ route('waka-kurikulum.pengumuman.force-delete', $t->id_pengumuman) }}" method="POST" onsubmit="return confirm('Hapus permanen pengumuman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-table-action btn-action-danger" style="padding: 4px 8px; font-size: 11px;" title="Hapus Permanen">
                                                    <i class="fa-solid fa-fire"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-table-action btn-action-secondary" onclick="closeModal('modalTrash')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Modal Control Functions
    function openModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.add('show');
    }

    function closeModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.remove('show');
    }

    function openTambahModal() {
        openModal('modalTambah');
    }

    function openTrashModal() {
        openModal('modalTrash');
    }

    function openEditModal(item) {
        document.getElementById('editForm').action = '{{ url("/waka-kurikulum/pengumuman") }}/' + item.id_pengumuman;
        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_kategori').value = item.kategori || 'Kurikulum';
        document.getElementById('edit_tanggal').value = item.tanggal ? item.tanggal.substring(0, 10) : '';
        document.getElementById('edit_status').value = item.status || 'aktif';
        document.getElementById('edit_keterangan').value = item.keterangan || '';
        document.getElementById('edit_isi').value = item.isi || '';
        openModal('modalEdit');
    }

    function openDetailModal(id) {
        openModal('modalDetail');
        const container = document.getElementById('detailPengumumanBody');
        container.innerHTML = `
            <div style="text-align: center; padding: 24px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 22px; color: #2563eb;"></i>
                <p style="margin-top: 8px; font-weight: 600; font-size: 12.5px;">Memuat rincian pengumuman kurikulum...</p>
            </div>
        `;

        fetch('{{ url("/waka-kurikulum/pengumuman") }}/' + id + '/detail-json')
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    container.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 16px; font-size: 12.5px;">Gagal memuat rincian pengumuman.</div>`;
                    return;
                }

                const d = res.data;
                let readsHtml = '';
                if (d.reads_users && d.reads_users.length > 0) {
                    readsHtml = `
                        <div style="margin-top: 14px; padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <div style="font-size: 11.5px; font-weight: 800; color: #334155; margin-bottom: 6px;">
                                <i class="fa-solid fa-users" style="color: #2563eb;"></i> Riwayat Pembaca Pengumuman (${d.total_dibaca} orang):
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; max-height: 100px; overflow-y: auto;">
                                ${d.reads_users.map(u => `
                                    <span style="font-size: 11px; background: #ffffff; border: 1px solid #cbd5e1; padding: 2px 8px; border-radius: 6px; color: #334155;">
                                        ${u.user_name} <small style="color: #94a3b8;">(${u.read_at})</small>
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap;">
                        <span class="badge-category cat-kurikulum">
                            <i class="fa-solid fa-tag"></i> ${d.kategori}
                        </span>
                        <span class="badge-status ${d.status === 'aktif' ? 'badge-status-aktif' : 'badge-status-selesai'}">
                            ${d.status.toUpperCase()}
                        </span>
                    </div>

                    <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 6px 0 2px 0; line-height: 1.35;">
                        ${d.judul}
                    </h2>

                    <div style="display: flex; align-items: center; gap: 16px; font-size: 12px; color: #64748b; flex-wrap: wrap; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0;">
                        <span><i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i> Tanggal: <strong>${d.tanggal}</strong></span>
                        <span><i class="fa-solid fa-user-pen" style="color: #2563eb;"></i> Oleh: <strong>${d.pembuat_nama}</strong></span>
                        ${d.keterangan && d.keterangan !== '-' ? `<span><i class="fa-solid fa-bullseye" style="color: #2563eb;"></i> Target: <strong>${d.keterangan}</strong></span>` : ''}
                    </div>

                    <div style="font-size: 13.5px; color: #1e293b; line-height: 1.7; white-space: pre-line; padding: 10px 0;">
                        ${d.isi}
                    </div>

                    ${readsHtml}
                `;
            })
            .catch(err => {
                container.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 16px; font-size: 12.5px;">Terjadi kesalahan saat memuat rincian pengumuman.</div>`;
            });
    }

    // Close on backdrop click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay-custom')) {
            e.target.classList.remove('show');
        }
    });
</script>
@endsection
