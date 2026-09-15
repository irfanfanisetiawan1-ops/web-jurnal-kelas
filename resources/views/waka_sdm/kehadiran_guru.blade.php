@extends('layouts.waka_sdm')

@section('title', 'Kehadiran & KBM Guru — Waka SDM')
@section('page-header', 'Kehadiran Pendidik & Monitoring KBM')
@section('page-subheader', 'Pantau keaktifan mengajar harian, guru izin, penugasan guru pengganti, dan rekapitulasi kehadiran SDM')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    :root {
        --color-navy: #2b3957;
        --color-navy-dark: #1e293b;
        --color-blue: #2563eb;
        --color-blue-light: #eff6ff;
        --color-bg-light: #f8fafc;
        --color-border: #e2e8f0;
        --color-text-main: #0f172a;
        --color-text-muted: #64748b;
    }

    .kehadiran-container {
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
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
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

    .stat-icon-green  { background: #dcfce7; color: #16a34a; }
    .stat-icon-orange { background: #ffedd5; color: #ea580c; }
    .stat-icon-indigo { background: #e0e7ff; color: #4338ca; }
    .stat-icon-purple { background: #f3e8ff; color: #7e22ce; }
    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }

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
        margin: 2px 0;
    }

    .stat-subtext {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* Tab Switcher */
    .tab-nav-container {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #e2e8f0;
        padding: 5px;
        border-radius: 14px;
        width: fit-content;
    }

    .tab-btn {
        background: transparent;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .tab-btn.active {
        background: #ffffff;
        color: #2b3957;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
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
        padding: 9px 18px;
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
        background: #f1f5f9;
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
    .btn-reset-light:hover { background: #e2e8f0; color: #0f172a; }

    /* Card Panel Base */
    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
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
        padding: 13px 15px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px 15px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-status-hadir      { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .badge-status-izin       { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-status-tidak-hadir{ background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
    .badge-status-digantikan { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-status-pending    { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-status-disetujui  { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }

    .btn-wa {
        background: #25d366;
        color: #ffffff;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background 0.15s ease;
    }
    .btn-wa:hover { background: #1eb857; color: #ffffff; }

    .btn-act {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        cursor: pointer;
        font-size: 13px;
        color: #475569;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-act:hover { background: #2b3957; color: #ffffff; border-color: #2b3957; }

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
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 18px 18px 0 0;
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
        border-radius: 0 0 18px 18px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    /* Charts Grid */
    .charts-grid-2 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
    }

    @media (max-width: 1024px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .charts-grid-2 { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

@php
    $cDate = \Carbon\Carbon::parse($tanggal);
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $dateTitleFormatted = $hariTeks . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
@endphp

<div class="kehadiran-container">

    <!-- Top Action Header -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Monitoring Kehadiran &amp; KBM Guru</h1>
            <p><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> {{ $dateTitleFormatted }} &nbsp;•&nbsp; Pantau pelaksanaan jadwal mengajar, guru izin, dan pengganti (inval)</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('waka-sdm.kehadiran-guru.export', request()->query()) }}" class="btn-action-outline">
                <i class="fa-solid fa-file-csv" style="color: #16a34a;"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('waka-sdm.kehadiran-guru.print', request()->query()) }}" target="_blank" class="btn-action-solid">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekapitulasi</span>
            </a>
        </div>
    </div>

    <!-- 4 Stat Cards Grid -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Hadir Mengajar</span>
                <span class="stat-val">{{ $dailyStats['guruHadirCount'] ?? 0 }} Guru</span>
                <span class="stat-subtext">{{ $dailyStats['sesiHadir'] ?? 0 }} sesi KBM aktif</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Izin / Dinas</span>
                <span class="stat-val">{{ $dailyStats['guruIzinCount'] ?? 0 }} Guru</span>
                <span class="stat-subtext">{{ $dailyStats['sesiIzin'] ?? 0 }} sesi izin</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-indigo">
                <i class="fa-solid fa-people-arrows"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Pengganti (Inval)</span>
                <span class="stat-val">{{ $dailyStats['guruPenggantiCount'] ?? 0 }} Penugasan</span>
                <span class="stat-subtext">Diisi guru piket/inval</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-purple">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Jurnal KBM Terisi</span>
                <span class="stat-val">{{ $dailyStats['jurnalTerisiCount'] ?? 0 }} / {{ $dailyStats['totalSesi'] ?? 0 }} Sesi</span>
                <span class="stat-subtext">Keterisian: {{ $dailyStats['persenKBM'] ?? 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- Tab Switcher Navigation -->
    <div class="tab-nav-container">
        <a href="{{ route('waka-sdm.kehadiran-guru', array_merge(request()->query(), ['tab' => 'harian'])) }}" class="tab-btn {{ $tab === 'harian' ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-day"></i>
            <span>Monitoring Presensi Harian ({{ $sesiList->total() }} Sesi)</span>
        </a>
        <a href="{{ route('waka-sdm.kehadiran-guru', array_merge(request()->query(), ['tab' => 'bulanan'])) }}" class="tab-btn {{ $tab === 'bulanan' ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Rekapitulasi &amp; Tren Bulanan SDM</span>
        </a>
    </div>

    @if($tab === 'harian')
        <!-- TAB 1: MONITORING HARIAN -->
        
        <!-- Filter Bar Form -->
        <div class="filter-bar-container">
            <form action="{{ route('waka-sdm.kehadiran-guru') }}" method="GET">
                <input type="hidden" name="tab" value="harian">

                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari nama guru, mapel, materi, kelas..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="filter-input" title="Pilih Tanggal Pemantauan">
                </div>

                <div>
                    <select name="status" class="filter-input">
                        <option value="">🔘 Semua Status Kehadiran</option>
                        <option value="hadir" {{ $statusFilter == 'hadir' ? 'selected' : '' }}>🟢 Hadir</option>
                        <option value="izin" {{ $statusFilter == 'izin' ? 'selected' : '' }}>🟡 Izin</option>
                        <option value="tidak_hadir" {{ $statusFilter == 'tidak_hadir' ? 'selected' : '' }}>🔴 Tidak Hadir</option>
                        <option value="digantikan" {{ $statusFilter == 'digantikan' ? 'selected' : '' }}>🔵 Digantikan</option>
                    </select>
                </div>

                <div>
                    <select name="id_guru" class="filter-input" style="max-width: 180px;">
                        <option value="">👥 Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input" style="max-width: 170px;">
                        <option value="">📖 Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_kelas" class="filter-input" style="max-width: 150px;">
                        <option value="">🏫 Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-sdm.kehadiran-guru', ['tab' => 'harian']) }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <!-- Card 1: Monitoring Sesi KBM & Presensi Guru Terjadwal -->
        <div class="card-panel">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i>
                    Sesi Jadwal KBM &amp; Presensi Pendidik ({{ $hariTeks }}, {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
                </h2>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                    Total: {{ $sesiList->total() }} Sesi Terjadwal
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">No</th>
                            <th>Nama Guru Pengampu</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas &amp; Ruang</th>
                            <th>Jam Mengajar</th>
                            <th>Status Kehadiran</th>
                            <th>Guru Pengganti (Inval)</th>
                            <th>Materi / Catatan KBM</th>
                            <th style="text-align: center; width: 60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sesiList as $idx => $r)
                            <tr>
                                <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $sesiList->firstItem() + $idx }}</td>
                                <td>
                                    <strong style="font-size: 13.5px; color: #0f172a; display: block;">{{ $r->guru_nama }}</strong>
                                    <span style="font-size: 11.5px; color: #64748b;">NIP: {{ $r->guru_nip }}</span>
                                    @if($r->guru_hp)
                                        @php
                                            $cleanHp = preg_replace('/[^0-9]/', '', $r->guru_hp);
                                            if(str_starts_with($cleanHp, '0')) $cleanHp = '62' . substr($cleanHp, 1);
                                        @endphp
                                        <div style="margin-top: 3px;">
                                            <a href="https://wa.me/{{ $cleanHp }}?text=Halo%20{{ urlencode($r->guru_nama) }}" target="_blank" class="btn-wa">
                                                <i class="fa-brands fa-whatsapp"></i> WA
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: #1e293b;">{{ $r->mapel_nama }}</strong>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">{{ $r->kelas_nama }}</div>
                                    <div style="font-size: 12px; color: #64748b;">{{ $r->ruangan_nama }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #2563eb;">{{ $r->jam_ke }}</div>
                                    <div style="font-size: 11.5px; color: #64748b;">{{ $r->jam }}</div>
                                </td>
                                <td>
                                    @if($r->status_key === 'hadir')
                                        <span class="badge-status badge-status-hadir"><i class="fa-solid fa-circle-check"></i> {{ $r->status_teks }}</span>
                                    @elseif($r->status_key === 'izin')
                                        <span class="badge-status badge-status-izin"><i class="fa-solid fa-clock"></i> {{ $r->status_teks }}</span>
                                    @elseif($r->status_key === 'tidak_hadir')
                                        <span class="badge-status badge-status-tidak-hadir"><i class="fa-solid fa-circle-xmark"></i> {{ $r->status_teks }}</span>
                                    @elseif($r->status_key === 'digantikan')
                                        <span class="badge-status badge-status-digantikan"><i class="fa-solid fa-arrows-rotate"></i> {{ $r->status_teks }}</span>
                                    @else
                                        <span class="badge-status badge-status-hadir">{{ $r->status_teks }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->guru_pengganti_nama)
                                        <strong style="color: #1d4ed8; font-size: 13px;">{{ $r->guru_pengganti_nama }}</strong>
                                        <div style="font-size: 11px; color: #64748b;">Guru Inval Piket</div>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #334155;">{{ Str::limit($r->materi ?? '-', 45) }}</div>
                                    @if($r->keterangan !== '-')
                                        <div style="font-size: 11.5px; color: #64748b;">{{ Str::limit($r->keterangan, 35) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; justify-content: center;">
                                        <button type="button" class="btn-act" onclick='openModalDetailSesi(@json($r))' title="Lihat Detail Sesi">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; color: #94a3b8; padding: 35px;">
                                    <i class="fa-solid fa-calendar-xmark" style="font-size: 36px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                    Tidak ada jadwal KBM yang sesuai dengan kriteria filter pada tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sesiList->hasPages())
                {{ $sesiList->links('partials.custom-pagination') }}
            @endif
        </div>

        <!-- Card 2: Guru Izin / Tidak Hadir Terdata -->
        <div class="card-panel">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-large-slash" style="color: #ea580c;"></i>
                Daftar Pendidik Izin / Tidak Hadir ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
            </h2>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">No</th>
                            <th>Nama Pendidik</th>
                            <th>NIP</th>
                            <th>Periode Izin</th>
                            <th>Kategori &amp; Alasan</th>
                            <th>Status Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzin as $idx => $iz)
                            <tr>
                                <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                                <td>
                                    <strong style="font-size: 13.5px; color: #0f172a;">{{ $iz->guru->nama_guru ?? '-' }}</strong>
                                    @if($iz->guru && !empty($iz->guru->no_hp))
                                        @php
                                            $cleanHp = preg_replace('/[^0-9]/', '', $iz->guru->no_hp);
                                            if(str_starts_with($cleanHp, '0')) $cleanHp = '62' . substr($cleanHp, 1);
                                        @endphp
                                        <div style="margin-top: 3px;">
                                            <a href="https://wa.me/{{ $cleanHp }}?text=Halo%20{{ urlencode($iz->guru->nama_guru) }}" target="_blank" class="btn-wa">
                                                <i class="fa-brands fa-whatsapp"></i> Chat WA
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td style="font-weight: 600; color: #475569;">{{ $iz->guru->nip ?? '-' }}</td>
                                <td style="font-weight: 600; color: #334155;">
                                    {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d M Y') }}
                                    @if($iz->tanggal_mulai !== $iz->tanggal_selesai)
                                        s/d {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $alasanClean = trim(preg_replace('/^biasa:\s*/i', '', $iz->alasan ?? ''));
                                        $isSakit = str_contains(strtolower($iz->kategori_izin . ' ' . $alasanClean), 'sakit');
                                        $isCuti  = str_contains(strtolower($iz->kategori_izin . ' ' . $alasanClean), 'cuti');
                                        $isDinas = str_contains(strtolower($alasanClean), 'dinas') || str_contains(strtolower($alasanClean), 'workshop') || str_contains(strtolower($alasanClean), 'tugas');
                                        
                                        $katLabel = 'Izin';
                                        $badgeBg = '#fef3c7'; $badgeColor = '#b45309';
                                        if ($isCuti) {
                                            $katLabel = 'Cuti';
                                            $badgeBg = '#f3e8ff'; $badgeColor = '#7e22ce';
                                        } elseif ($isDinas) {
                                            $katLabel = 'Tugas Dinas';
                                            $badgeBg = '#e0e7ff'; $badgeColor = '#4338ca';
                                        } elseif ($isSakit) {
                                            $katLabel = 'Sakit';
                                            $badgeBg = '#fee2e2'; $badgeColor = '#dc2626';
                                        }
                                    @endphp
                                    <span style="font-weight: 800; font-size: 11.5px; padding: 2px 8px; border-radius: 6px; background: {{ $badgeBg }}; color: {{ $badgeColor }}; display: inline-block; margin-bottom: 2px;">
                                        {{ $katLabel }}
                                    </span>
                                    <div style="font-size: 12px; color: #475569; font-weight: 600;">{{ Str::limit($alasanClean ?: '-', 50) }}</div>
                                </td>
                                <td>
                                    @if($iz->status_waka_sdm === 'approved' || $iz->status === 'disetujui' || $iz->status_final === 'approved')
                                        <span class="badge-status badge-status-disetujui"><i class="fa-solid fa-check-double"></i> Resmi Disetujui</span>
                                    @else
                                        <span class="badge-status badge-status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Approval</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 25px;">
                                    Tidak ada data guru izin / tidak hadir pada tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card 3: Penugasan Guru Pengganti (Inval) -->
        @if(count($guruPengganti ?? []) > 0)
            <div class="card-panel">
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-people-arrows" style="color: #4338ca;"></i>
                    Penugasan Guru Pengganti / Inval ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
                </h2>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th style="width: 45px; text-align: center;">No</th>
                                <th>Guru Tidak Hadir</th>
                                <th>Guru Pengganti</th>
                                <th>Kelas &amp; Mapel</th>
                                <th>Jam Ke</th>
                                <th>Status Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guruPengganti as $idx => $gp)
                                <tr>
                                    <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                                    <td><strong style="color: #dc2626;">{{ $gp->guruUtama->nama_guru ?? '-' }}</strong></td>
                                    <td><strong style="color: #16a34a;">{{ $gp->guruPengganti->nama_guru ?? '-' }}</strong></td>
                                    <td>
                                        <div><strong>{{ $gp->jadwal->kelas->nama_kelas ?? '-' }}</strong></div>
                                        <div style="font-size: 12px; color: #64748b;">{{ $gp->jadwal->mapel->nama_mapel ?? '-' }}</div>
                                    </td>
                                    <td style="font-weight: 700; color: #334155;">Jam Ke-{{ $gp->jadwal->jam_ke ?? ($gp->jadwal->id_jam_mulai ?? '-') }}</td>
                                    <td><span class="badge-status badge-status-hadir"><i class="fa-solid fa-briefcase"></i> Bertugas</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    @else
        <!-- TAB 2: REKAPITULASI & TREN BULANAN SDM -->

        <!-- Filter Bar Form Bulanan -->
        <div class="filter-bar-container">
            <form action="{{ route('waka-sdm.kehadiran-guru') }}" method="GET">
                <input type="hidden" name="tab" value="bulanan">

                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari nama guru..." style="width: 100%;">
                </div>

                <div>
                    <select name="bulan" class="filter-input">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $monthsMapIndo[$m] }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <select name="tahun" class="filter-input">
                        @for($y = Carbon\Carbon::now()->year - 1; $y <= Carbon\Carbon::now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input" style="max-width: 180px;">
                        <option value="">📖 Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-sdm.kehadiran-guru', ['tab' => 'bulanan']) }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <!-- Monthly Charts Grid -->
        <div class="charts-grid-2">
            <!-- Chart 1: Tren 6 Bulan -->
            <div class="card-panel">
                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-line" style="color: #2563eb;"></i>
                    Tren Keterisian Jurnal Mengajar &amp; Izin (6 Bulan Terakhir)
                </h3>
                <div style="height: 250px;">
                    <canvas id="chartTrendBulanan"></canvas>
                </div>
            </div>

            <!-- Chart 2: Komposisi Status -->
            <div class="card-panel">
                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-pie" style="color: #ea580c;"></i>
                    Rasio Kehadiran ({{ $namaBulan }})
                </h3>
                <div style="height: 250px; display: flex; align-items: center; justify-content: center;">
                    <canvas id="chartRasioStatus"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Matrix Rekapitulasi per Guru -->
        <div class="card-panel">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-address-book" style="color: #2563eb;"></i>
                    Rekapitulasi Kehadiran &amp; Kinerja Pendidik (Periode: {{ $namaBulan }})
                </h2>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                    Total: {{ count($guruMatrix) }} Pendidik
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">No</th>
                            <th>Nama Pendidik</th>
                            <th>NIP</th>
                            <th>Mata Pelajaran</th>
                            <th style="text-align: center;">Jurnal Terisi (Hadir)</th>
                            <th style="text-align: center;">Izin / Cuti</th>
                            <th style="text-align: center;">Sakit / Tidak Hadir</th>
                            <th style="text-align: center;">Persentase (%)</th>
                            <th style="text-align: center;">Predikat Kinerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruMatrix as $idx => $gm)
                            <tr>
                                <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                                <td>
                                    <strong style="font-size: 13.5px; color: #0f172a;">{{ $gm->guru->nama_guru }}</strong>
                                </td>
                                <td style="font-size: 12px; color: #64748b;">{{ $gm->guru->nip ?? '-' }}</td>
                                <td>{{ $gm->guru->mapel->nama_mapel ?? '-' }}</td>
                                <td style="text-align: center; font-weight: 800; color: #16a34a;">{{ $gm->total_jurnal }} Sesi</td>
                                <td style="text-align: center; font-weight: 700; color: #d97706;">{{ $gm->total_izin }} Kali</td>
                                <td style="text-align: center; font-weight: 700; color: #dc2626;">{{ $gm->total_sakit }} Kali</td>
                                <td style="text-align: center;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <div style="flex: 1; max-width: 60px; height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $gm->persen_hadir }}%; background: {{ $gm->badge_color }};"></div>
                                        </div>
                                        <span style="font-weight: 800; font-size: 12.5px; color: #0f172a;">{{ $gm->persen_hadir }}%</span>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 800; background: {{ $gm->badge_color }}15; color: {{ $gm->badge_color }}; border: 1px solid {{ $gm->badge_color }}40;">
                                        {{ $gm->predikat }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    Tidak ada data rekapitulasi pendidik yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<!-- MODAL DETAIL SESI KBM -->
<div id="modalDetailSesi" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-book-bookmark"></i> Detail Sesi Pembelajaran &amp; KBM</h3>
            <button type="button" onclick="closeModalDetailSesi()" style="background:none; border:none; color:#ffffff; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <div style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
                <div style="font-size: 11px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Materi / Pembahasan</div>
                <div id="m_materi" style="font-size: 14.5px; font-weight: 800; color: #0f172a; margin-top: 4px;"></div>
            </div>

            <div class="form-grid-2" style="font-size: 13px; line-height: 1.8;">
                <div><strong style="color: #64748b;">Guru Pengampu:</strong> <br><span id="m_guru" style="font-weight: 700; color: #0f172a;"></span></div>
                <div><strong style="color: #64748b;">Mata Pelajaran:</strong> <br><span id="m_mapel" style="font-weight: 700; color: #0f172a;"></span></div>
                <div><strong style="color: #64748b;">Kelas &amp; Ruangan:</strong> <br><span id="m_kelas" style="font-weight: 700; color: #0f172a;"></span> (<span id="m_ruangan"></span>)</div>
                <div><strong style="color: #64748b;">Sesi &amp; Waktu:</strong> <br><span id="m_jam" style="font-weight: 700; color: #0f172a;"></span></div>
                <div><strong style="color: #64748b;">Status Kehadiran:</strong> <br><span id="m_status" style="font-weight: 700;"></span></div>
                <div><strong style="color: #64748b;">Guru Pengganti:</strong> <br><span id="m_inval" style="font-weight: 700; color: #1d4ed8;"></span></div>
                <div style="grid-column: span 2;"><strong style="color: #64748b;">Keterangan / Catatan:</strong> <br><span id="m_keterangan" style="color: #334155;"></span></div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" onclick="closeModalDetailSesi()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModalDetailSesi(data) {
        document.getElementById('m_materi').innerText = data.materi || '-';
        document.getElementById('m_guru').innerText = data.guru_nama || '-';
        document.getElementById('m_mapel').innerText = data.mapel_nama || '-';
        document.getElementById('m_kelas').innerText = data.kelas_nama || '-';
        document.getElementById('m_ruangan').innerText = data.ruangan_nama || '-';
        document.getElementById('m_jam').innerText = data.jam_ke + ' (' + data.jam + ')';
        document.getElementById('m_status').innerText = data.status_teks || '-';
        document.getElementById('m_inval').innerText = data.guru_pengganti_nama || 'Tidak Ada (Pengampu Utama)';
        document.getElementById('m_keterangan').innerText = data.keterangan || '-';

        document.getElementById('modalDetailSesi').style.display = 'flex';
    }

    function closeModalDetailSesi() {
        document.getElementById('modalDetailSesi').style.display = 'none';
    }

    @if($tab === 'bulanan')
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Trend 6 Bulan
        const ctxTrend = document.getElementById('chartTrendBulanan');
        if (ctxTrend) {
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: 'Jurnal Hadir',
                            data: @json($trendHadir),
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        },
                        {
                            label: 'Guru Izin/Cuti',
                            data: @json($trendIzin),
                            borderColor: '#ea580c',
                            backgroundColor: 'rgba(234, 88, 12, 0.05)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointBackgroundColor: '#ea580c',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    }
                }
            });
        }

        // Chart 2: Donut Rasio Kehadiran
        const ctxRasio = document.getElementById('chartRasioStatus');
        if (ctxRasio) {
            const had = {{ $monthlyStats['totalHadir'] ?? 0 }};
            const izn = {{ $monthlyStats['totalIzin'] ?? 0 }};
            const skt = {{ $monthlyStats['totalSakit'] ?? 0 }};

            new Chart(ctxRasio, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir Mengajar', 'Izin / Dinas', 'Sakit / Tidak Hadir'],
                    datasets: [{
                        data: [had > 0 || izn > 0 || skt > 0 ? had : 1, izn, skt],
                        backgroundColor: ['#16a34a', '#d97706', '#dc2626'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' }, boxWidth: 12 } }
                    }
                }
            });
        }
    });
    @endif
</script>
@endsection
