@extends('layouts.waka_sdm')

@section('title', 'Direktori SDM & Pendidik — Waka SDM')
@section('page-header', 'Direktori SDM & Pendidik')
@section('page-subheader', 'Master data pendidik, status kepegawaian, kontak WhatsApp, dan informasi tugas kedinasan')

@section('styles')
<style>
    :root {
        --slate-dark: #1e293b;
        --slate-medium: #334155;
        --slate-light: #475569;
        --slate-muted: #64748b;
        --gray-bg: #f8fafc;
        --gray-surface: #f1f5f9;
        --gray-border: #e2e8f0;
        --gray-border-subtle: #cbd5e1;
        --primary-blue: #2563eb;
        --primary-blue-dark: #1d4ed8;
    }

    .direktori-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 30px;
    }

    /* Page Header Action Bar */
    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .page-title-group h1 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-group p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-outline {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .btn-action-solid {
        background: #2b3957;
        border: 1px solid #2b3957;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        box-shadow: 0 4px 10px rgba(43, 57, 87, 0.15);
    }

    .btn-action-solid:hover {
        background: #1e293b;
        border-color: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* 4 Stat Cards Grid */
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
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .stat-icon-indigo { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .stat-icon-pink   { background: #fdf2f8; color: #db2777; border: 1px solid #fbcfe8; }
    .stat-icon-green  { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 8.5px 13px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12.5px;
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
        padding: 8.5px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #2b3957;
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
        background: #f1f5f9;
        color: #475569;
        padding: 8.5px 14px;
        border-radius: 10px;
        font-size: 12.5px;
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
    .btn-reset-light:hover { background: #e2e8f0; color: #0f172a; }

    /* Card Panel Base */
    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
    }

    /* Table Design */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 13px 14px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px;
        font-size: 12.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: #f8fafc;
    }

    .user-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.25);
    }

    .badge-role {
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 10.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .badge-role-guru           { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-role-wali_kelas     { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-role-waka           { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-role-waka_sdm       { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
    .badge-role-admin          { background: #fff1f2; color: #b91c1c; border: 1px solid #fecdd3; }
    .badge-role-tu             { background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; }
    .badge-role-kepala_sekolah { background: #ecfdf5; color: #15803d; border: 1px solid #86efac; }
    .badge-role-piket          { background: #fefce8; color: #a16207; border: 1px solid #fef08a; }

    .btn-wa {
        background: #25d366;
        color: #ffffff !important;
        padding: 4px 9px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(37, 211, 102, 0.3);
    }
    .btn-wa:hover {
        background: #128c7e;
        transform: translateY(-1px);
    }

    .btn-act-view {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
        cursor: pointer;
        font-size: 12.5px;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-act-view:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
        transform: translateY(-1px);
    }

    /* Modals Backdrop & Card */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }

    .modal-card-custom {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 20px 20px 0 0;
    }

    .modal-header-custom h3 {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-custom {
        padding: 22px 24px;
    }

    .modal-footer-custom {
        padding: 14px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        border-radius: 0 0 20px 20px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media (max-width: 900px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="direktori-container">

    <!-- Top Action Header -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Direktori Data Pendidik &amp; SDM</h1>
            <p><i class="fa-solid fa-users-gear" style="color: #2563eb;"></i> Master data pendidik, status kepegawaian, kontak WhatsApp, dan informasi tugas kedinasan</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('waka-sdm.data-guru.export', request()->query()) }}" class="btn-action-outline">
                <i class="fa-solid fa-file-csv" style="color: #16a34a;"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('waka-sdm.data-guru.print', request()->query()) }}" target="_blank" class="btn-action-solid">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Direktori</span>
            </a>
        </div>
    </div>

    <!-- 4 Stat Cards Grid -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Pendidik &amp; SDM</span>
                    <span class="stat-val">{{ $stats['totalGuru'] ?? 0 }} Guru</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-indigo">
                    <i class="fa-solid fa-person"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Guru Laki-Laki</span>
                    <span class="stat-val">{{ $stats['totalLaki'] ?? 0 }} Guru</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-pink">
                    <i class="fa-solid fa-person-dress"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Guru Perempuan</span>
                    <span class="stat-val">{{ $stats['totalPerempuan'] ?? 0 }} Guru</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Akun Terverifikasi</span>
                    <span class="stat-val">{{ $stats['totalAkun'] ?? 0 }} Akun</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Main Panel -->
    <div class="card-panel">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-address-book" style="color: #2563eb;"></i> Direktori Data Pendidik &amp; Kepegawaian
            </h2>
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                Total: {{ $guruList->total() }} Pendidik Terdata
            </div>
        </div>

        <!-- Filter Bar Form -->
        <div class="filter-bar-container">
            <form action="{{ route('waka-sdm.data-guru') }}" method="GET">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama, NIP, HP, atau Email..." class="filter-input" style="flex: 1.5; min-width: 200px;">
                
                <select name="jenis_kelamin" class="filter-input">
                    <option value="">Gender: Semua</option>
                    <option value="L" {{ $jkFilter == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jkFilter == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>

                <select name="id_mapel" class="filter-input" style="max-width: 180px;">
                    <option value="">Mapel: Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ $mapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>

                <select name="role" class="filter-input" style="max-width: 160px;">
                    <option value="">Peran: Semua Role</option>
                    <option value="guru" {{ $roleFilter == 'guru' ? 'selected' : '' }}>Guru Mengajar</option>
                    <option value="wali_kelas" {{ $roleFilter == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="piket" {{ $roleFilter == 'piket' ? 'selected' : '' }}>Guru Piket</option>
                    <option value="waka" {{ $roleFilter == 'waka' ? 'selected' : '' }}>Waka Kurikulum</option>
                    <option value="waka_sdm" {{ $roleFilter == 'waka_sdm' ? 'selected' : '' }}>Waka SDM</option>
                    <option value="tu" {{ $roleFilter == 'tu' ? 'selected' : '' }}>Tata Usaha (TU)</option>
                    <option value="admin" {{ $roleFilter == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="kepala_sekolah" {{ $roleFilter == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>

                <select name="status" class="filter-input" style="max-width: 160px;">
                    <option value="">Status: Semua</option>
                    <option value="has_account" {{ $statusFilter == 'has_account' ? 'selected' : '' }}>Memiliki Akun</option>
                    <option value="no_account" {{ $statusFilter == 'no_account' ? 'selected' : '' }}>Belum Ada Akun</option>
                    <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $statusFilter == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-sdm.data-guru') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <!-- Table Data -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 45px; text-align: center;">No</th>
                        <th style="width: 28%;">Nama Pendidik &amp; SDM</th>
                        <th style="width: 18%;">NIP</th>
                        <th style="width: 7%; text-align: center;">L/P</th>
                        <th style="width: 18%;">Kontak &amp; WhatsApp</th>
                        <th style="width: 13%;">Peran Sistem</th>
                        <th style="width: 16%;">Mapel / Wali Kelas</th>
                        <th style="text-align: center; width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruList as $index => $guru)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $guruList->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-circle">
                                        {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="font-size: 13.5px; color: #0f172a;">{{ $guru->nama_guru }}</strong>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 1px;">
                                            <i class="fa-regular fa-envelope" style="font-size: 11px;"></i> {{ $guru->email ?? ($guru->user ? $guru->user->email : '-') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #334155; font-size: 12.5px;">{{ $guru->nip }}</td>
                            <td style="text-align: center;">
                                @if($guru->jenis_kelamin === 'L')
                                    <span style="color: #2563eb; font-weight: 700;" title="Laki-laki"><i class="fa-solid fa-mars"></i> L</span>
                                @elseif($guru->jenis_kelamin === 'P')
                                    <span style="color: #db2777; font-weight: 700;" title="Perempuan"><i class="fa-solid fa-venus"></i> P</span>
                                @else
                                    <span style="color: #94a3b8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-weight: 600; color: #334155;">{{ $guru->no_hp ?? '-' }}</span>
                                    @if(!empty($guru->no_hp))
                                        @php
                                            $cleanHp = preg_replace('/[^0-9]/', '', $guru->no_hp);
                                            if(str_starts_with($cleanHp, '0')) {
                                                $cleanHp = '62' . substr($cleanHp, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanHp }}?text=Halo%20{{ urlencode($guru->nama_guru) }}" target="_blank" class="btn-wa" title="Kirim Pesan WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i> Chat
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($guru->user)
                                    @php $r = strtolower($guru->user->role ?? 'guru'); @endphp
                                    <span class="badge-role badge-role-{{ $r }}">
                                        {{ $guru->user->role_label }}
                                    </span>
                                @else
                                    <span class="badge-role" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">
                                        Master Guru
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong style="color: #1e293b; font-size: 12.5px;">{{ $guru->mapel ? $guru->mapel->nama_mapel : 'Guru Mata Pelajaran' }}</strong>
                                </div>
                                @if($guru->kelasWali && $guru->kelasWali->count() > 0)
                                    <div style="font-size: 11px; color: #16a34a; font-weight: 700; margin-top: 2px;">
                                        <i class="fa-solid fa-user-shield"></i> Wali: {{ $guru->kelasWali->pluck('nama_kelas')->join(', ') }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $jadwalSummary = $guru->jadwals ? $guru->jadwals->map(function($j) {
                                        return [
                                            'hari' => $j->hari,
                                            'kelas' => $j->kelas ? $j->kelas->nama_kelas : '-',
                                            'mapel' => $j->mapel ? $j->mapel->nama_mapel : '-',
                                            'jam' => ($j->jamMulai ? $j->jamMulai->pukul : '-') . ' s/d ' . ($j->jamSelesai ? $j->jamSelesai->pukul : '-'),
                                        ];
                                    }) : [];

                                    $guruDetailData = [
                                        'nama_guru' => $guru->nama_guru,
                                        'nip' => $guru->nip,
                                        'jenis_kelamin' => $guru->jenis_kelamin,
                                        'no_hp' => $guru->no_hp,
                                        'email' => $guru->email ?? ($guru->user ? $guru->user->email : null),
                                        'role_label' => $guru->user ? $guru->user->role_label : 'Master Guru',
                                        'mapel' => $guru->mapel ? $guru->mapel->nama_mapel : 'Guru Mata Pelajaran',
                                        'wali_kelas' => $guru->kelasWali ? $guru->kelasWali->pluck('nama_kelas')->join(', ') : null,
                                        'is_active' => $guru->is_active ?? true,
                                        'jadwals' => $jadwalSummary,
                                    ];
                                @endphp
                                <div style="display: flex; justify-content: center;">
                                    <button type="button" class="btn-act-view" onclick='openModalDetailGuru(@json($guruDetailData))' title="Lihat Detail Profil SDM">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-id-badge" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Belum ada data pendidik yang sesuai dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guruList->hasPages())
            <div style="margin-top: 18px;">
                {{ $guruList->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>
</div>

<!-- MODAL DETAIL GURU LENGKAP -->
<div id="modalDetailGuru" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-address-card"></i> Detail Profil Pendidik &amp; SDM</h3>
            <button type="button" onclick="closeModalDetailGuru()" style="background:none; border:none; color:#ffffff; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <!-- Profil Card Header -->
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 18px; background: #f8fafc; padding: 16px; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div class="user-avatar-circle" style="width: 52px; height: 52px; font-size: 20px;" id="dt_avatar">
                    G
                </div>
                <div>
                    <h2 id="dt_nama" style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;"></h2>
                    <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                        NIP: <strong id="dt_nip" style="color: #334155;"></strong>
                    </div>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="form-grid-2" style="font-size: 12.5px; background: #ffffff; border: 1px solid #f1f5f9; padding: 14px; border-radius: 12px; margin-bottom: 16px;">
                <div><strong style="color: #64748b;">Jenis Kelamin:</strong> <div id="dt_jk" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
                <div><strong style="color: #64748b;">No HP / WhatsApp:</strong> <div id="dt_hp" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
                <div><strong style="color: #64748b;">Email Sistem:</strong> <div id="dt_email" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
                <div><strong style="color: #64748b;">Peran Sistem:</strong> <div id="dt_role" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
                <div><strong style="color: #64748b;">Mata Pelajaran:</strong> <div id="dt_mapel" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
                <div><strong style="color: #64748b;">Tugas Wali Kelas:</strong> <div id="dt_wali" style="font-weight: 700; color: #0f172a; margin-top: 2px;"></div></div>
            </div>

            <!-- Jadwal Mengajar Terjadwal -->
            <div>
                <div style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                    <i class="fa-solid fa-calendar-days" style="color: #2563eb; margin-right: 4px;"></i> Jadwal Mengajar Terjadwal:
                </div>
                <div id="dt_jadwal_box" style="max-height: 160px; overflow-y: auto; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px;">
                    <!-- Populated via JS -->
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <a id="dt_wa_link" href="#" target="_blank" class="btn-wa" style="display: none; padding: 7px 14px; font-size: 12.5px;">
                <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
            </a>
            <button type="button" onclick="closeModalDetailGuru()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalDetailGuru(data) {
        document.getElementById('dt_avatar').innerText = (data.nama_guru || 'G').substring(0, 1).toUpperCase();
        document.getElementById('dt_nama').innerText = data.nama_guru || '-';
        document.getElementById('dt_nip').innerText = data.nip || '-';
        document.getElementById('dt_jk').innerText = data.jenis_kelamin === 'L' ? 'Laki-laki' : (data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        document.getElementById('dt_hp').innerText = data.no_hp || '-';
        document.getElementById('dt_email').innerText = data.email || '-';
        document.getElementById('dt_role').innerText = data.role_label || 'Master Guru';
        document.getElementById('dt_mapel').innerText = data.mapel || 'Guru Mata Pelajaran';
        document.getElementById('dt_wali').innerText = data.wali_kelas || 'Bukan Wali Kelas';

        // Direct WhatsApp Link
        const waLink = document.getElementById('dt_wa_link');
        if (data.no_hp) {
            let cleanHp = data.no_hp.replace(/[^0-9]/g, '');
            if (cleanHp.startsWith('0')) {
                cleanHp = '62' + cleanHp.substring(1);
            }
            waLink.href = 'https://wa.me/' + cleanHp + '?text=Halo%20' + encodeURIComponent(data.nama_guru);
            waLink.style.display = 'inline-flex';
        } else {
            waLink.style.display = 'none';
        }

        // Jadwal Box
        const jadwalBox = document.getElementById('dt_jadwal_box');
        if (data.jadwals && data.jadwals.length > 0) {
            let html = '<table style="width: 100%; font-size: 11.5px; border-collapse: collapse;">';
            html += '<thead><tr style="color: #64748b; border-bottom: 1px solid #e2e8f0; text-align: left;"><th style="padding: 4px;">Hari</th><th style="padding: 4px;">Kelas</th><th style="padding: 4px;">Mapel</th><th style="padding: 4px;">Jam</th></tr></thead><tbody>';
            data.jadwals.forEach(j => {
                html += '<tr style="border-bottom: 1px solid #f1f5f9;">';
                html += '<td style="padding: 5px 4px; font-weight: 700; color: #1e293b;">' + j.hari + '</td>';
                html += '<td style="padding: 5px 4px; color: #2563eb; font-weight: 600;">' + j.kelas + '</td>';
                html += '<td style="padding: 5px 4px; color: #334155;">' + j.mapel + '</td>';
                html += '<td style="padding: 5px 4px; color: #64748b;">' + j.jam + '</td>';
                html += '</tr>';
            });
            html += '</tbody></table>';
            jadwalBox.innerHTML = html;
        } else {
            jadwalBox.innerHTML = '<div style="color: #94a3b8; font-size: 12px; text-align: center; padding: 10px;">Belum ada jadwal KBM terjadwal untuk pendidik ini.</div>';
        }

        document.getElementById('modalDetailGuru').style.display = 'flex';
    }

    function closeModalDetailGuru() {
        document.getElementById('modalDetailGuru').style.display = 'none';
    }

    // Close on backdrop click & ESC key
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop-custom')) {
            e.target.style.display = 'none';
        }
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop-custom').forEach(m => m.style.display = 'none');
        }
    });
</script>
@endsection
