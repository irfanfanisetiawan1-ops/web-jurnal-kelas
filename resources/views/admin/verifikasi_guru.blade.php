@extends('layouts.admin')

@section('title', 'Master Data - Pengguna — EduJournal')

@section('styles')
<style>
    /* Header Top Bar Styling */
    .page-header-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .page-title-group p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .header-user-badge {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #faf3e0;
        padding: 10px 18px;
        border-radius: 20px;
        border: 1px solid #f0e4c8;
    }

    .header-date-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }

    .header-date-info i {
        font-size: 16px;
        color: #3b82f6;
    }

    .header-welcome {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .header-avatar-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background: #334155;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    /* Top Cards Grid */
    .role-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .role-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 95px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .role-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .role-card.active {
        border: 2px solid #4f46e5 !important;
        background: #eff6ff !important;
    }

    /* Filter Panel Drawer */
    .filter-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        display: none;
        animation: filterSlide 0.2s ease-out;
    }

    .filter-panel.show {
        display: block;
    }

    @keyframes filterSlide {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .role-card .role-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    .role-card .role-count {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Controls Bar: Search, + Tambah Pengguna, Filter */
    .controls-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        max-width: 420px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border-radius: 25px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 14px;
        outline: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: all 0.2s;
    }

    .search-input-wrapper input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .action-buttons-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-tambah-user {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        padding: 10px 22px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }

    .btn-tambah-user:hover {
        background: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
    }

    .btn-filter-toggle {
        background: #e2d9c8;
        color: #1e293b;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-filter-toggle:hover {
        background: #d4c8b2;
    }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-trash:hover {
        background: #fde68a;
        color: #78350f;
    }

    .btn-trash .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    /* Filter Drawer Panel */
    .filter-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        display: none;
    }

    .filter-panel.show {
        display: block;
    }

    /* Main Table Container */
    .users-table-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .custom-users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-users-table thead tr {
        background: #2b3655;
        color: #ffffff;
    }

    .custom-users-table th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 700;
        text-align: left;
        letter-spacing: 0.3px;
    }

    .custom-users-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        background: #fdfbf7;
    }

    .custom-users-table tbody tr:nth-child(even) td {
        background: #ffffff;
    }

    .custom-users-table tbody tr:hover td {
        background: #f1f5f9;
    }

    /* Password Badge Simple Styling */
    .password-simple-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }

    /* Role Badges */
    .role-badge {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pill-super {
        background: #fdba74;
        color: #9a3412;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
        text-transform: uppercase;
    }

    .pill-pending {
        background: #fef08a;
        color: #854d0e;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
    }

    /* Action Buttons in Table with Clear Labels */
    .table-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .btn-action-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        line-height: 1.2;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-action-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .btn-action-view {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-action-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    .btn-action-edit {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    .btn-action-edit:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    .btn-action-key {
        background: #f3e8ff;
        color: #6b21a8;
        border-color: #e9d5ff;
    }
    .btn-action-key:hover {
        background: #7e22ce;
        color: #ffffff;
        border-color: #7e22ce;
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .btn-action-approve {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }
    .btn-action-approve:hover {
        background: #059669;
        color: #ffffff;
        border-color: #059669;
    }

    .btn-action-reject {
        background: #ffe4e6;
        color: #9f1239;
        border-color: #fecdd3;
    }
    .btn-action-reject:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    /* Action Legend Bar */
    .action-legend-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        font-size: 12px;
        color: #64748b;
        flex-wrap: wrap;
    }

    .action-legend-bar .legend-title {
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-legend-bar .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    /* Pagination Footer & Custom Pagination Links Fix */
    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        font-size: 13px;
        color: #64748b;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Fix Laravel Default Tailwind Pagination Giant Arrow Issue */
    .table-footer nav {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
    }

    .table-footer svg {
        width: 1rem !important;
        height: 1rem !important;
        display: inline-block !important;
    }

    .table-footer nav div:first-child {
        display: none !important;
    }

    .table-footer nav span[aria-current="page"] > span {
        background: #252b42 !important;
        color: #ffffff !important;
        border-color: #252b42 !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        display: inline-block !important;
    }

    .table-footer nav a,
    .table-footer nav span[aria-disabled="true"] > span {
        padding: 6px 12px !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff !important;
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .table-footer nav a:hover {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }

    /* Modal Backdrop */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
    }

    .modal-backdrop.show {
        display: flex !important;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalSlide 0.2s ease-out;
    }

    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        background: #2b3655;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 700;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.8;
    }

    .modal-close:hover { opacity: 1; }

    .modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #4f46e5;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #4f46e5;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .role-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .role-cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<!-- Header Top Bar -->
<div class="page-header-container">
    <div class="page-title-group">
        <h1>Master Data — Pengguna</h1>
        <p>Kelola data akun pengguna, verifikasi pendaftaran guru, dan atur hak akses role sistem</p>
    </div>
</div>

<!-- Stat Cards Top Row (Clickable Role Filtering) -->
<div class="role-cards-grid">
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'tu'])) }}" 
       class="role-card {{ request('role') == 'tu' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Admin / TU">
        <div class="role-title">Admin / TU</div>
        <div class="role-count">{{ $countAdmin }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'piket'])) }}" 
       class="role-card {{ request('role') == 'piket' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Guru Piket">
        <div class="role-title">Guru Piket</div>
        <div class="role-count">{{ $countGuruPiket }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'guru'])) }}" 
       class="role-card {{ request('role') == 'guru' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Guru Mapel">
        <div class="role-title">Guru Mapel</div>
        <div class="role-count">{{ $countGuruMapel }}</div>
    </a>
    <a href="{{ route('admin.verifikasi-guru', array_merge(request()->except(['role', 'page']), ['role' => 'wali_kelas'])) }}" 
       class="role-card {{ request('role') == 'wali_kelas' ? 'active' : '' }}" style="text-decoration:none;" title="Klik untuk filter akun Wali Kelas">
        <div class="role-title">Wali Kelas</div>
        <div class="role-count">{{ $countWaliKelas }}</div>
    </a>
</div>

@if($countPending > 0)
    <div class="alert alert-error" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a;">
        <i class="fa-solid fa-bell"></i>
        <span>Terdapat <strong>{{ $countPending }} akun baru</strong> yang menunggu verifikasi persetujuan dari Anda (Admin TU).</span>
    </div>
@endif

<!-- Controls Bar: Search & Action Buttons -->
<div class="controls-bar">
    <form action="{{ route('admin.verifikasi-guru') }}" method="GET" class="search-input-wrapper">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pengguna...." onchange="this.form.submit()">
        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    </form>

    <div class="action-buttons-group">
        <button type="button" class="btn-tambah-user" onclick="openModal('modalTambahUser')">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Pengguna</span>
        </button>

        <button type="button" class="btn-filter-toggle" onclick="toggleFilterPanel()">
            <span>Filter</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>

        <a href="{{ route('admin.users-trash') }}" class="btn-trash" title="Lihat Tempat Sampah Pengguna">
            <i class="fa-solid fa-trash-can"></i>
            <span>Lihat Sampah Pengguna</span>
            <span class="badge-count">{{ $trashedCount ?? 0 }}</span>
        </a>
    </div>
</div>

<!-- Filter Panel Drawer -->
<div class="filter-panel" id="filterPanel">
    <form action="{{ route('admin.verifikasi-guru') }}" method="GET" style="display:flex; gap:16px; flex-wrap:wrap; align-items:flex-end;">
        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
        
        <div style="flex:1; min-width:180px;">
            <label style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:4px; display:block;">Filter Role</label>
            <select name="role" class="form-control">
                <option value="">-- Semua Role --</option>
                <option value="tu" {{ request('role') == 'tu' ? 'selected' : '' }}>Admin / TU</option>
                <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru Mapel</option>
                <option value="piket" {{ request('role') == 'piket' ? 'selected' : '' }}>Guru Piket</option>
                <option value="wali_kelas" {{ request('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
            </select>
        </div>

        <div style="flex:1; min-width:180px;">
            <label style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:4px; display:block;">Status Verifikasi</label>
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified (Disetujui)</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
            </select>
        </div>

        <button type="submit" class="btn-primary" style="padding:10px 18px;">Terapkan Filter</button>
        <a href="{{ route('admin.verifikasi-guru') }}" class="btn-secondary" style="text-decoration:none; padding:10px 18px;">Reset</a>
    </form>
</div>

<!-- Table Data Pengguna -->
<div class="users-table-container">
    <div style="overflow-x: auto;">
        <table class="custom-users-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Dibuat Pada</th>
                    <th style="width: 340px; min-width: 320px; white-space: nowrap; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $u)
                    <tr data-user="{{ json_encode($u) }}" onclick="openDetailModalFromEl(this)" style="cursor: pointer;" title="Klik baris data ini untuk melihat rincian detail akun {{ $u->name }}">
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $u->name }}</div>
                            <div style="font-size: 12px; color: #64748b;">
                                NIP: {{ $u->nip ?? '-' }} | Username: {{ $u->username ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="password-simple-badge" title="Password terenkripsi (Bcrypt)">
                                <i class="fa-solid fa-lock" style="font-size:11px; color:#4f46e5;"></i>
                                <span>Terenkripsi</span>
                            </div>
                        </td>
                        <td>
                            <div class="role-badge">
                                <span>
                                    @if(in_array($u->role, ['admin', 'tu'])) Admin
                                    @elseif($u->role === 'piket') Guru Piket
                                    @elseif($u->role === 'wali_kelas') Wali Kelas
                                    @else Guru
                                    @endif
                                </span>
                                @if(in_array($u->role, ['admin', 'tu']))
                                    <span class="pill-super">Super</span>
                                @endif
                                @if($u->status_verifikasi === 'pending')
                                    <span class="pill-pending">Pending</span>
                                @endif
                            </div>
                        </td>
                        <td style="font-size: 13px; color: #475569;">
                            {{ $u->created_at ? $u->created_at->format('d/m/Y') : '11/02/2026' }}
                        </td>
                        <td style="white-space: nowrap;" onclick="event.stopPropagation();">
                            <div class="table-actions" style="justify-content: center;">
                                @if($u->status_verifikasi === 'pending')
                                    <form action="{{ route('admin.verifikasi-guru.approve', $u->id) }}" method="POST" style="display:inline-flex; flex-shrink:0; margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-action-badge btn-action-approve" title="Setujui: Mengonfirmasi dan mengaktifkan pendaftaran akun">
                                            <i class="fa-solid fa-circle-check"></i> <span>Setujui</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.verifikasi-guru.reject', $u->id) }}" method="POST" style="display:inline-flex; flex-shrink:0; margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-action-badge btn-action-reject" title="Tolak: Menolak pendaftaran akun guru ini">
                                            <i class="fa-solid fa-circle-xmark"></i> <span>Tolak</span>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn-action-badge btn-action-view" data-user="{{ json_encode($u) }}" onclick="openDetailModalFromEl(this)" title="Lihat Detail: Menampilkan rincian lengkap data profil & akun pengguna">
                                        <i class="fa-solid fa-eye"></i> <span>Detail</span>
                                    </button>

                                    <button type="button" class="btn-action-badge btn-action-edit" data-user="{{ json_encode($u) }}" onclick="openEditModalFromEl(this)" title="Edit Role: Mengubah NIP, nama, email, role hak akses & status akun">
                                        <i class="fa-solid fa-pen-to-square"></i> <span>Edit</span>
                                    </button>

                                    <button type="button" class="btn-action-badge btn-action-key" onclick="openResetPasswordModal({{ $u->id }}, '{{ addslashes($u->name) }}')" title="Reset Password: Mereset password akun ini dengan password baru">
                                        <i class="fa-solid fa-key"></i> <span>Reset Pass</span>
                                    </button>

                                    @if($u->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Pindahkan akun {{ addslashes($u->name) }} ({{ addslashes($u->getRoleLabelAttribute()) }}) ke Tempat Sampah?')" style="display:inline-flex; flex-shrink:0; margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-badge btn-action-delete" title="Hapus Akun: Memindahkan akun pengguna ini ke Tempat Sampah">
                                                <i class="fa-solid fa-trash-can"></i> <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fa-solid fa-user-slash" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                            Tidak ada data pengguna yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="table-footer">
        <div>
            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>


<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODALS SECTION -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->

<!-- Modal 1: Tambah Pengguna Baru -->
<div class="modal-backdrop" id="modalTambahUser">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-plus" style="margin-right:8px;"></i> Buat Akun Pengguna Baru (Admin TU)</h3>
            <button class="modal-close" onclick="closeModal('modalTambahUser')">&times;</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validatePasswordSubmit(event)">
            @csrf
            <div class="modal-body">
                <div class="alert alert-info" style="background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:10px 14px; border-radius:10px; font-size:12.5px; margin-bottom:16px;">
                    <i class="fa-solid fa-circle-info"></i> <strong>Persyaratan NIP & Role:</strong> Pengguna harus sudah terdaftar terlebih dahulu pada Master Data Guru. Khusus role <em>Wali Kelas</em>, NIP harus sudah ditugaskan pada Daftar Wali Kelas.
                </div>

                {{-- Master Data Guru Quick Picker --}}
                <div class="form-group" style="background:#f8fafc; padding:14px; border-radius:12px; border:1px dashed #cbd5e1; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label style="font-weight:700; color:#334155; margin-bottom:0;">
                            <i class="fa-solid fa-users-line" style="color:#4f46e5; margin-right:4px;"></i> Pilih dari Data Master Guru
                        </label>
                        <span id="guruMatchCount" style="font-size:11px; font-weight:700; color:#4f46e5;"></span>
                    </div>

                    {{-- Fitur Cari Berdasarkan NIP atau Nama --}}
                    <div style="position:relative; margin-bottom:8px;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="text" id="searchGuruPicker" class="form-control" 
                               placeholder="Cari NIP / Nama Guru..." 
                               oninput="filterGuruPicker(this.value)"
                               style="padding-left:36px; font-size:13px; background:#ffffff; border-color:#cbd5e1;">
                    </div>

                    <select id="selectGuruPicker" class="form-control" onchange="autoFillGuruData(this)">
                        <option value="">-- Ketik NIP Manual atau Pilih dari Master Guru --</option>
                        @foreach($guruList as $g)
                            @php
                                $hasUser = !empty($g->user);
                                $isWali = $g->kelasWali->isNotEmpty();
                                $waliKelasName = $isWali ? $g->kelasWali->first()->nama_kelas : '';
                            @endphp
                            <option value="{{ $g->nip }}"
                                    data-id-guru="{{ $g->id_guru }}"
                                    data-nip="{{ $g->nip }}"
                                    data-nama="{{ $g->nama_guru }}"
                                    data-jk="{{ $g->jenis_kelamin }}"
                                    data-hp="{{ $g->no_hp }}"
                                    data-is-wali="{{ $isWali ? '1' : '0' }}"
                                    data-kelas-wali="{{ $waliKelasName }}"
                                    data-has-account="{{ $hasUser ? '1' : '0' }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip }}) {{ $isWali ? '[Wali Kelas ' . $waliKelasName . ']' : '' }} {{ $hasUser ? '[Sudah Ada Akun]' : '[Belum Ada Akun]' }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color:#64748b; font-size:11px; margin-top:6px; display:block;">Pilih guru di atas untuk otomatis pengisian NIP, Nama, Jenis Kelamin, dan Role.</small>
                </div>

                {{-- Banner Informasi Data Terkunci dari Master Guru --}}
                <div id="guruLockBanner" style="display:none; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:10px 14px; border-radius:10px; font-size:12px; margin-bottom:16px;">
                    <i class="fa-solid fa-lock" style="color:#2563eb; margin-right:4px;"></i> 
                    <strong>Data Terisi Otomatis &amp; Terkunci:</strong> Data NIP, Nama, Jenis Kelamin, HP, dan Role dikunci karena dipilih dari Data Master Guru. Untuk mengedit manual, pilih <em>'-- Ketik NIP Manual atau Pilih dari Master Guru --'</em> pada pilihan di atas.
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>NIP * (18 Digit)</label>
                        <input type="text" name="nip" id="add_nip" class="form-control" placeholder="198001012005011000"
                               maxlength="18" minlength="18" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18);" required>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Username (Opsional)</label>
                        <input type="text" name="username" id="add_username" class="form-control" placeholder="username.guru">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" id="add_name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd" required>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="add_jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Nomor HP / WA</label>
                        <input type="text" name="no_hp" id="add_no_hp" class="form-control" placeholder="081234567890"
                               maxlength="15" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email (Opsional)</label>
                    <input type="email" name="email" id="add_email" class="form-control" placeholder="user@sekolah.sch.id">
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Role Hak Akses *</label>
                        <select name="role" id="add_role" class="form-control" required>
                            <option value="guru">Guru Mapel</option>
                            <option value="piket">Guru Piket</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="tu">Admin / TU (Tata Usaha)</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Status Verifikasi *</label>
                        <select name="status_verifikasi" class="form-control" required>
                            <option value="verified">Verified (Disetujui)</option>
                            <option value="pending">Pending (Menunggu)</option>
                        </select>
                    </div>
                </div>

                {{-- Password & Konfirmasi Password --}}
                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Password Akun *</label>
                        <input type="password" name="password" id="add_password" class="form-control" 
                               placeholder="Minimal 6 karakter" minlength="6" required oninput="validatePasswordMatch()">
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" id="add_password_confirmation" class="form-control" 
                               placeholder="Ulangi password" minlength="6" required oninput="validatePasswordMatch()">
                    </div>
                </div>
                <small id="passwordMatchMsg" style="display:none; font-size:12px; font-weight:600; margin-top:-6px; margin-bottom:12px;"></small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="resetTambahUserForm()" style="background:#fbbf24; color:#78350f;"><i class="fa-solid fa-rotate-left"></i> Reset Form</button>
                <button type="button" class="btn-secondary" onclick="closeModal('modalTambahUser')">Batal</button>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Simpan & Buat Akun</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal 2: Edit Hak Akses & Role -->
<div class="modal-backdrop" id="modalEditUser">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-pen" style="margin-right:8px;"></i> Ubah Hak Akses & Profile</h3>
            <button class="modal-close" onclick="closeModal('modalEditUser')">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>NIP * (18 Digit)</label>
                        <input type="text" name="nip" id="edit_nip" class="form-control"
                               maxlength="18" minlength="18" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18);" required>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="edit_jk" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Nomor HP / WA</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="form-control" placeholder="081234567890"
                               maxlength="15" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div class="form-group" style="flex:1;">
                        <label>Role Hak Akses *</label>
                        <select name="role" id="edit_role" class="form-control" required>
                            <option value="tu">Admin / TU (Tata Usaha)</option>
                            <option value="admin">Administrator (Super)</option>
                            <option value="guru">Guru Mapel</option>
                            <option value="piket">Guru Piket</option>
                            <option value="wali_kelas">Wali Kelas</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Status Verifikasi *</label>
                        <select name="status_verifikasi" id="edit_status" class="form-control" required>
                            <option value="verified">Verified (Aktif)</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected (Ditolak)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalEditUser')">Batal</button>
                <button type="submit" class="btn-primary">Update Data Akun</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal 3: Reset Password -->
<div class="modal-backdrop" id="modalResetPassword">
    <div class="modal-box">
        <div class="modal-header" style="background:#4c1d95;">
            <h3><i class="fa-solid fa-key" style="margin-right:8px;"></i> Reset Sandi Pengguna</h3>
            <button class="modal-close" onclick="closeModal('modalResetPassword')">&times;</button>
        </div>
        <form id="formResetPassword" method="POST">
            @csrf
            <div class="modal-body">
                <p style="font-size:14px; color:#475569; margin-bottom:16px;">
                    Anda akan mereset password untuk akun: <strong id="reset_user_name" style="color:#0f172a;"></strong>
                </p>

                <div class="form-group">
                    <label>Password Baru *</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" minlength="6" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" minlength="6" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalResetPassword')">Batal</button>
                <button type="submit" class="btn-primary" style="background:#7c3aed;">Simpan Password Baru</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal 4: View Detail -->
<div class="modal-backdrop" id="modalDetailUser">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-id-card" style="margin-right:8px;"></i> Detail Akun Pengguna</h3>
            <button class="modal-close" onclick="closeModal('modalDetailUser')">&times;</button>
        </div>
        <div class="modal-body">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nama Lengkap:</td><td id="detail_name" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">NIP:</td><td id="detail_nip" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Jenis Kelamin:</td><td id="detail_jk" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nomor HP / WA:</td><td id="detail_no_hp" style="font-weight:700; color:#0f172a;"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Username:</td><td id="detail_username"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Email:</td><td id="detail_email"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Role:</td><td id="detail_role"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Status Verifikasi:</td><td id="detail_status"></td></tr>
                <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Dibuat Pada:</td><td id="detail_created_at"></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('modalDetailUser')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        if (id === 'modalTambahUser') {
            const searchInput = document.getElementById('searchGuruPicker');
            if (searchInput) searchInput.value = '';
            filterGuruPicker('');
            const selectPicker = document.getElementById('selectGuruPicker');
            if (selectPicker) {
                selectPicker.value = '';
                autoFillGuruData(selectPicker);
            }
            const pass = document.getElementById('add_password');
            const confirmPass = document.getElementById('add_password_confirmation');
            const msg = document.getElementById('passwordMatchMsg');
            if (pass) pass.value = '';
            if (confirmPass) confirmPass.value = '';
            if (msg) msg.style.display = 'none';
        }
    }

    function validatePasswordMatch() {
        const pass = document.getElementById('add_password');
        const confirmPass = document.getElementById('add_password_confirmation');
        const msg = document.getElementById('passwordMatchMsg');
        
        if (!pass || !confirmPass || !msg) return true;

        const passVal = pass.value;
        const confirmVal = confirmPass.value;

        if (!passVal && !confirmVal) {
            msg.style.display = 'none';
            return true;
        }

        if (passVal.length > 0 && passVal.length < 6) {
            msg.style.display = 'block';
            msg.style.color = '#ef4444';
            msg.innerHTML = '<i class="fa-solid fa-circle-xmark" style="margin-right:4px;"></i> Password minimal 6 karakter.';
            return false;
        }

        if (confirmVal.length > 0) {
            if (passVal === confirmVal) {
                msg.style.display = 'block';
                msg.style.color = '#10b981';
                msg.innerHTML = '<i class="fa-solid fa-circle-check" style="margin-right:4px;"></i> Konfirmasi password cocok.';
                return true;
            } else {
                msg.style.display = 'block';
                msg.style.color = '#ef4444';
                msg.innerHTML = '<i class="fa-solid fa-circle-xmark" style="margin-right:4px;"></i> Konfirmasi password tidak cocok.';
                return false;
            }
        } else {
            msg.style.display = 'none';
            return false;
        }
    }

    function validatePasswordSubmit(event) {
        const pass = document.getElementById('add_password');
        const confirmPass = document.getElementById('add_password_confirmation');

        if (pass && confirmPass) {
            if (pass.value.length < 6) {
                alert('Password minimal 6 karakter.');
                pass.focus();
                event.preventDefault();
                return false;
            }
            if (pass.value !== confirmPass.value) {
                alert('Konfirmasi password tidak cocok! Harap pastikan kedua input password sama.');
                confirmPass.focus();
                event.preventDefault();
                return false;
            }
        }
        return true;
    }

    function resetTambahUserForm() {
        const searchInput = document.getElementById('searchGuruPicker');
        if (searchInput) {
            searchInput.value = '';
            filterGuruPicker('');
        }
        const selectPicker = document.getElementById('selectGuruPicker');
        if (selectPicker) {
            selectPicker.value = '';
            autoFillGuruData(selectPicker);
        }
        const nipInput = document.getElementById('add_nip');
        if (nipInput) nipInput.value = '';
        const usernameInput = document.getElementById('add_username');
        if (usernameInput) usernameInput.value = '';
        const nameInput = document.getElementById('add_name');
        if (nameInput) nameInput.value = '';
        const emailInput = document.getElementById('add_email');
        if (emailInput) emailInput.value = '';
        const hpInput = document.getElementById('add_no_hp');
        if (hpInput) hpInput.value = '';
        const jkSelect = document.getElementById('add_jenis_kelamin');
        if (jkSelect) jkSelect.value = '';
        const roleSelect = document.getElementById('add_role');
        if (roleSelect) roleSelect.value = 'guru';
        const passInput = document.getElementById('add_password');
        if (passInput) passInput.value = '';
        const confirmPassInput = document.getElementById('add_password_confirmation');
        if (confirmPassInput) confirmPassInput.value = '';
        const msg = document.getElementById('passwordMatchMsg');
        if (msg) msg.style.display = 'none';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function toggleFilterPanel() {
        document.getElementById('filterPanel').classList.toggle('show');
    }

    function openDetailModalFromEl(el) {
        const raw = el.getAttribute('data-user');
        if (!raw) return;
        try {
            const user = typeof raw === 'string' ? JSON.parse(raw) : raw;
            openDetailModal(user);
        } catch(e) {
            console.error('Error parsing user data:', e);
        }
    }

    function openEditModalFromEl(el) {
        const raw = el.getAttribute('data-user');
        if (!raw) return;
        try {
            const user = typeof raw === 'string' ? JSON.parse(raw) : raw;
            openEditModal(user);
        } catch(e) {
            console.error('Error parsing user data:', e);
        }
    }

    function openEditModal(user) {
        document.getElementById('formEditUser').action = '/admin/verifikasi-guru/' + user.id + '/update-role';
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_nip').value = user.nip || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role').value = user.role || 'guru';
        document.getElementById('edit_status').value = user.status_verifikasi || 'verified';
        
        let jkVal = (user.guru && user.guru.jenis_kelamin) ? user.guru.jenis_kelamin : (user.jenis_kelamin || '');
        let noHpVal = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '');
        
        if (document.getElementById('edit_jk')) document.getElementById('edit_jk').value = jkVal;
        if (document.getElementById('edit_no_hp')) document.getElementById('edit_no_hp').value = noHpVal;

        openModal('modalEditUser');
    }

    function openResetPasswordModal(userId, userName) {
        document.getElementById('formResetPassword').action = '/admin/users/' + userId + '/reset-password';
        document.getElementById('reset_user_name').innerText = userName;
        openModal('modalResetPassword');
    }

    function openDetailModal(user) {
        document.getElementById('detail_name').innerText = user.name || '-';
        document.getElementById('detail_nip').innerText = user.nip || '-';
        document.getElementById('detail_username').innerText = user.username || '-';
        document.getElementById('detail_email').innerText = user.email || '-';
        document.getElementById('detail_role').innerText = user.role ? user.role.toUpperCase() : '-';
        document.getElementById('detail_status').innerText = user.status_verifikasi ? user.status_verifikasi.toUpperCase() : '-';
        document.getElementById('detail_created_at').innerText = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : '-';

        let jkText = '-';
        if (user.guru && user.guru.jenis_kelamin) {
            jkText = user.guru.jenis_kelamin === 'L' ? 'Laki-laki' : (user.guru.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        } else if (user.jenis_kelamin) {
            jkText = user.jenis_kelamin === 'L' ? 'Laki-laki' : (user.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        }
        let noHpText = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '-');

        if (document.getElementById('detail_jk')) document.getElementById('detail_jk').innerText = jkText;
        if (document.getElementById('detail_no_hp')) document.getElementById('detail_no_hp').innerText = noHpText;

        openModal('modalDetailUser');
    }

    function filterGuruPicker(query) {
        const select = document.getElementById('selectGuruPicker');
        const badge = document.getElementById('guruMatchCount');
        if (!select) return;

        const q = query.trim().toLowerCase();
        let count = 0;

        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            if (!opt.value) {
                // Default option ("Ketik NIP Manual...") is always visible
                opt.hidden = false;
                opt.style.display = '';
                continue;
            }

            const nip = (opt.getAttribute('data-nip') || '').toLowerCase();
            const nama = (opt.getAttribute('data-nama') || '').toLowerCase();
            const text = (opt.text || '').toLowerCase();

            if (q === '' || nip.includes(q) || nama.includes(q) || text.includes(q)) {
                opt.hidden = false;
                opt.style.display = '';
                count++;
            } else {
                opt.hidden = true;
                opt.style.display = 'none';
            }
        }

        if (badge) {
            if (q === '') {
                badge.innerText = '';
            } else {
                badge.innerText = count > 0 ? count + ' guru cocok' : 'Tidak ditemukan';
            }
        }
    }

    function autoFillGuruData(select) {
        const option = select.options[select.selectedIndex];
        const lockBanner = document.getElementById('guruLockBanner');

        const nipInput = document.getElementById('add_nip');
        const nameInput = document.getElementById('add_name');
        const jkSelect = document.getElementById('add_jenis_kelamin');
        const hpInput = document.getElementById('add_no_hp');
        const roleSelect = document.getElementById('add_role');

        const textInputs = [nipInput, nameInput, hpInput];

        if (!option || !option.value) {
            // "Ketik NIP Manual atau Pilih dari Master Guru" option selected (value is empty)
            // UNLOCK fields to make them editable again
            textInputs.forEach(el => {
                if (el) {
                    el.readOnly = false;
                    el.style.backgroundColor = '#ffffff';
                    el.style.cursor = 'default';
                }
            });

            if (jkSelect) {
                jkSelect.style.pointerEvents = 'auto';
                jkSelect.style.backgroundColor = '#ffffff';
                jkSelect.style.cursor = 'default';
                jkSelect.removeAttribute('tabindex');
            }

            if (roleSelect) {
                roleSelect.style.pointerEvents = 'auto';
                roleSelect.style.backgroundColor = '#ffffff';
                roleSelect.style.cursor = 'default';
                roleSelect.removeAttribute('tabindex');
            }

            if (lockBanner) lockBanner.style.display = 'none';
            return;
        }

        // A teacher was chosen from Data Master Guru
        const nip = option.getAttribute('data-nip') || '';
        const nama = option.getAttribute('data-nama') || '';
        const jk = option.getAttribute('data-jk') || '';
        const hp = option.getAttribute('data-hp') || '';
        const isWali = option.getAttribute('data-is-wali') === '1';

        if (nipInput) nipInput.value = nip;
        if (nameInput) nameInput.value = nama;
        if (jkSelect) jkSelect.value = jk;
        if (hpInput) hpInput.value = hp;
        if (roleSelect) roleSelect.value = isWali ? 'wali_kelas' : 'guru';

        // LOCK fields so they cannot be edited
        textInputs.forEach(el => {
            if (el) {
                el.readOnly = true;
                el.style.backgroundColor = '#f1f5f9';
                el.style.cursor = 'not-allowed';
            }
        });

        if (jkSelect) {
            jkSelect.style.pointerEvents = 'none';
            jkSelect.style.backgroundColor = '#f1f5f9';
            jkSelect.style.cursor = 'not-allowed';
            jkSelect.setAttribute('tabindex', '-1');
        }

        if (roleSelect) {
            roleSelect.style.pointerEvents = 'none';
            roleSelect.style.backgroundColor = '#f1f5f9';
            roleSelect.style.cursor = 'not-allowed';
            roleSelect.setAttribute('tabindex', '-1');
        }

        if (lockBanner) lockBanner.style.display = 'block';
    }
</script>
@endsection
