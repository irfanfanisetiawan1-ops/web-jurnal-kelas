@extends('layouts.waka_kurikulum')

@section('title', 'Alokasi Jam Pelajaran — Waka Kurikulum')

@section('styles')
<style>
    .jam-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    /* Metric Cards Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        width: 100%;
    }

    .metric-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
    }
    .metric-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .metric-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .metric-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .metric-lbl {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }

    /* Filters & Action Bar */
    .filter-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        max-width: 420px;
    }

    .search-input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 13px;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
    }
    .search-input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .btn-action-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-action-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .btn-action-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-action-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Tabs Styling */
    .nav-tabs-custom {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 16px;
        padding-bottom: 0;
    }

    .tab-btn {
        background: transparent;
        border: none;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }

    .tab-btn:hover {
        color: #2563eb;
    }

    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }

    /* Table Wrapper Card */
    .table-wrapper-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .jam-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .jam-table th {
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .jam-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .jam-table tr:hover td { background: #f8fafc; }

    .badge-jam {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #dbeafe;
    }

    .badge-istirahat {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-pembiasaan {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit-sm {
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-edit-sm:hover {
        background: #0284c7;
        color: #ffffff;
    }

    /* Modal Edit Styling */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(3px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-box {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .modal-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .modal-close {
        background: transparent;
        border: none;
        font-size: 18px;
        color: #64748b;
        cursor: pointer;
    }
    .modal-body {
        padding: 20px;
    }
    .form-group {
        margin-bottom: 14px;
    }
    .form-group label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control-modal {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 13px;
        color: #0f172a;
        box-sizing: border-box;
    }
    .form-control-modal:focus {
        background: #ffffff;
        border-color: #2563eb;
        outline: none;
    }
    .modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="jam-container">

    {{-- Alert Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 12px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between;">
            <div><i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}</div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 16px;">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 12px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between;">
            <div><i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> {{ session('error') }}</div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 16px;">&times;</button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; Portal Kurikulum &gt; <span style="color: #2563eb;">Alokasi Jam Pelajaran</span>
            </div>
            <h1 class="page-main-title">Alokasi Jam Pelajaran KBM</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Struktur Sesi Waktu Pembelajaran &amp; Jadwal Rutin Harian</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('waka-kurikulum.jam-pelajaran.export') }}" class="btn-action-secondary">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('waka-kurikulum.jam-pelajaran.print') }}" target="_blank" class="btn-action-primary">
                <i class="fa-solid fa-print"></i> Cetak Jadwal
            </a>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon-box" style="background: #eff6ff; color: #2563eb;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="metric-val">{{ $totalJam }} Sesi</div>
                <div class="metric-lbl">Total Master Jam Pelajaran</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box" style="background: #f0fdf4; color: #166534;">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <div class="metric-val">{{ $totalSesiSeninKamis }} Jam KBM</div>
                <div class="metric-lbl">Senin–Kamis (40 / 35m)</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box" style="background: #faf5ff; color: #7e22ce;">
                <i class="fa-solid fa-mosque"></i>
            </div>
            <div>
                <div class="metric-val">{{ $totalSesiJumat }} Jam KBM</div>
                <div class="metric-lbl">Hari Jumat (30 / 25m)</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box" style="background: #fef3c7; color: #b45309;">
                <i class="fa-solid fa-mug-hot"></i>
            </div>
            <div>
                <div class="metric-val">2 Sesi</div>
                <div class="metric-lbl">Istirahat 1 &amp; ISHOMA / Jumat</div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Card --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('waka-kurikulum.jam-pelajaran') }}" class="search-form">
            <div style="position: relative; width: 100%;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="search-input" style="padding-left: 36px;" placeholder="Cari sesi jam, waktu, atau keterangan...">
            </div>
            <button type="submit" class="btn-action-primary" style="padding: 9px 14px;">Cari</button>
            @if(!empty($search))
                <a href="{{ route('waka-kurikulum.jam-pelajaran') }}" class="btn-action-secondary" style="padding: 9px 12px;" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
        <div style="font-size: 12.5px; color: #64748b; font-weight: 600;">
            <i class="fa-solid fa-circle-info" style="color: #2563eb; margin-right: 4px;"></i> Sinkron dengan Master Jam TU
        </div>
    </div>

    {{-- Main Content with Tabs --}}
    <div>
        <div class="nav-tabs-custom">
            <button class="tab-btn active" onclick="switchTab('semua', this)">
                <i class="fa-solid fa-list-ol"></i> Semua Sesi Jam
            </button>
            <button class="tab-btn" onclick="switchTab('senin-kamis', this)">
                <i class="fa-solid fa-calendar-week"></i> Senin – Kamis (10 Jam)
            </button>
            <button class="tab-btn" onclick="switchTab('jumat', this)">
                <i class="fa-solid fa-kaaba"></i> Hari Jumat (13 Jam)
            </button>
        </div>

        {{-- TAB 1: SEMUA SESI --}}
        <div id="tab-semua" class="tab-content">
            <div class="table-wrapper-card">
                <div style="padding: 14px 18px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; color: #0f172a;">Struktur Sesi Waktu Pembelajaran Lengkap</span>
                    <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">Alokasi KBM Resmi Boyolangu</span>
                </div>
                <div style="overflow-x: auto;">
                    <table class="jam-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">NO</th>
                                <th style="width: 130px;">LABEL SESI</th>
                                <th style="width: 170px;">WAKTU SENIN – KAMIS</th>
                                <th style="width: 170px;">WAKTU JUMAT</th>
                                <th>KETERANGAN / DOKUMEN ALOKASI</th>
                                <th style="width: 90px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jamList as $idx => $jam)
                                @php
                                    $labelFormatted = preg_match('/^Jam\s+Ke-/i', $jam->jam_ke) ? $jam->jam_ke : 'Jam Ke-' . $jam->jam_ke;
                                    $isIstirahat = (stripos($jam->keterangan, 'Istirahat') !== false || stripos($jam->keterangan, 'ISHOMA') !== false || stripos($jam->keterangan, 'Sholat') !== false);
                                    $isPembiasaan = (stripos($jam->keterangan, 'Apel') !== false || stripos($jam->keterangan, 'Pembiasaan') !== false || stripos($jam->keterangan, 'Upacara') !== false);
                                @endphp
                                <tr>
                                    <td style="font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                                    <td>
                                        <span class="badge-jam">{{ $labelFormatted }}</span>
                                    </td>
                                    <td style="font-weight: 700; color: #0f172a;">
                                        @if($jam->jam_mulai && $jam->jam_selesai)
                                            <i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 4px;"></i>
                                            {{ substr($jam->jam_mulai, 0, 5) }} – {{ substr($jam->jam_selesai, 0, 5) }} WIB
                                        @else
                                            <span style="color: #94a3b8; font-weight: 500;">-</span>
                                        @endif
                                    </td>
                                    <td style="font-weight: 700; color: #0f172a;">
                                        @if($jam->jam_mulai_jumat && $jam->jam_selesai_jumat)
                                            <i class="fa-regular fa-clock" style="color: #7e22ce; margin-right: 4px;"></i>
                                            {{ substr($jam->jam_mulai_jumat, 0, 5) }} – {{ substr($jam->jam_selesai_jumat, 0, 5) }} WIB
                                        @else
                                            <span style="color: #94a3b8; font-weight: 500;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isIstirahat)
                                            <span class="badge-istirahat">
                                                <i class="fa-solid fa-mug-hot"></i> {{ $jam->keterangan }}
                                            </span>
                                        @elseif($isPembiasaan)
                                            <span class="badge-pembiasaan">
                                                <i class="fa-solid fa-flag"></i> {{ $jam->keterangan }}
                                            </span>
                                        @else
                                            <span style="font-weight: 600; color: #334155;">
                                                {{ $jam->keterangan ?: 'Kegiatan Belajar Mengajar (KBM)' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn-edit-sm" onclick="openEditModal({{ json_encode($jam) }})">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 35px; color: #94a3b8;">
                                        Belum ada data alokasi jam pelajaran yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 2: SENIN - KAMIS --}}
        <div id="tab-senin-kamis" class="tab-content" style="display: none;">
            <div class="table-wrapper-card">
                <div style="padding: 14px 18px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; color: #0f172a;">Jadwal Alokasi KBM Senin – Kamis (10 Jam Pelajaran)</span>
                    <span style="font-size: 12.5px; color: #2563eb; font-weight: 700;">40 Menit (Jam 1–4) &amp; 35 Menit (Jam 5–10)</span>
                </div>
                <div style="overflow-x: auto;">
                    <table class="jam-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">NO</th>
                                <th style="width: 140px;">SESI JAM</th>
                                <th style="width: 160px;">WAKTU KBM</th>
                                <th style="width: 130px;">DURASI</th>
                                <th>KETERANGAN / STATUS ALOKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $noSK = 1; @endphp
                            @foreach($jamList as $jam)
                                @if($jam->jam_mulai && $jam->jam_selesai)
                                    @php
                                        $labelFormatted = preg_match('/^Jam\s+Ke-/i', $jam->jam_ke) ? $jam->jam_ke : 'Jam Ke-' . $jam->jam_ke;
                                        $m1 = \Carbon\Carbon::parse($jam->jam_mulai);
                                        $m2 = \Carbon\Carbon::parse($jam->jam_selesai);
                                        $durasi = $m1->diffInMinutes($m2);
                                        $isIstirahat = (stripos($jam->keterangan, 'Istirahat') !== false || stripos($jam->keterangan, 'ISHOMA') !== false);
                                    @endphp
                                    <tr>
                                        <td style="font-weight: 700; color: #64748b;">{{ $noSK++ }}</td>
                                        <td><span class="badge-jam">{{ $labelFormatted }}</span></td>
                                        <td style="font-weight: 700; color: #0f172a;">
                                            <i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 4px;"></i>
                                            {{ substr($jam->jam_mulai, 0, 5) }} – {{ substr($jam->jam_selesai, 0, 5) }} WIB
                                        </td>
                                        <td>
                                            <span style="background: #f1f5f9; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">
                                                {{ $durasi }} Menit
                                            </span>
                                        </td>
                                        <td>
                                            @if($isIstirahat)
                                                <span class="badge-istirahat"><i class="fa-solid fa-mug-hot"></i> {{ $jam->keterangan }}</span>
                                            @else
                                                <span style="font-weight: 600; color: #334155;">{{ $jam->keterangan ?: 'Sesi Pembelajaran KBM' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($jam->id_jam == 4)
                                        {{-- Insert visual break slot for Istirahat 1 --}}
                                        <tr style="background: #fffbeb;">
                                            <td style="text-align: center; font-weight: 700; color: #b45309;">-</td>
                                            <td><span class="badge-istirahat"><i class="fa-solid fa-mug-hot"></i> ISTIRAHAT 1</span></td>
                                            <td style="font-weight: 800; color: #b45309;">09:40 – 10:00 WIB</td>
                                            <td><span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">20 Menit</span></td>
                                            <td style="font-weight: 700; color: #92400e;">Istirahat Pagi Seluruh Siswa &amp; Guru</td>
                                        </tr>
                                    @elseif($jam->id_jam == 7)
                                        {{-- Insert visual break slot for ISHOMA --}}
                                        <tr style="background: #fffbeb;">
                                            <td style="text-align: center; font-weight: 700; color: #b45309;">-</td>
                                            <td><span class="badge-istirahat"><i class="fa-solid fa-utensils"></i> ISHOMA</span></td>
                                            <td style="font-weight: 800; color: #b45309;">11:45 – 13:15 WIB</td>
                                            <td><span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">90 Menit</span></td>
                                            <td style="font-weight: 700; color: #92400e;">Istirahat, Sholat Dhuhur Berjamaah &amp; Makan Siang</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 3: HARI JUMAT --}}
        <div id="tab-jumat" class="tab-content" style="display: none;">
            <div class="table-wrapper-card">
                <div style="padding: 14px 18px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; color: #0f172a;">Jadwal Alokasi KBM Hari Jumat (13 Jam Pelajaran)</span>
                    <span style="font-size: 12.5px; color: #7e22ce; font-weight: 700;">30 Menit (Jam 1–12) &amp; 35 Menit (Jam 13)</span>
                </div>
                <div style="overflow-x: auto;">
                    <table class="jam-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">NO</th>
                                <th style="width: 140px;">SESI JAM</th>
                                <th style="width: 160px;">WAKTU KBM</th>
                                <th style="width: 130px;">DURASI</th>
                                <th>KETERANGAN / STATUS ALOKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $noJum = 1; @endphp
                            @foreach($jamList as $jam)
                                @if($jam->jam_mulai_jumat && $jam->jam_selesai_jumat)
                                    @php
                                        $labelFormatted = preg_match('/^Jam\s+Ke-/i', $jam->jam_ke) ? $jam->jam_ke : 'Jam Ke-' . $jam->jam_ke;
                                        $m1 = \Carbon\Carbon::parse($jam->jam_mulai_jumat);
                                        $m2 = \Carbon\Carbon::parse($jam->jam_selesai_jumat);
                                        $durasi = $m1->diffInMinutes($m2);
                                        $isIstirahat = (stripos($jam->keterangan, 'Istirahat') !== false || stripos($jam->keterangan, 'ISHOMA') !== false || stripos($jam->keterangan, 'Sholat') !== false);
                                    @endphp
                                    <tr>
                                        <td style="font-weight: 700; color: #64748b;">{{ $noJum++ }}</td>
                                        <td>
                                            <span class="badge-jam" style="background: #faf5ff; color: #7e22ce; border-color: #f3e8ff;">
                                                {{ $labelFormatted }}
                                            </span>
                                        </td>
                                        <td style="font-weight: 700; color: #0f172a;">
                                            <i class="fa-regular fa-clock" style="color: #7e22ce; margin-right: 4px;"></i>
                                            {{ substr($jam->jam_mulai_jumat, 0, 5) }} – {{ substr($jam->jam_selesai_jumat, 0, 5) }} WIB
                                        </td>
                                        <td>
                                            <span style="background: #f1f5f9; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">
                                                {{ $durasi }} Menit
                                            </span>
                                        </td>
                                        <td>
                                            @if($isIstirahat)
                                                <span class="badge-istirahat"><i class="fa-solid fa-mug-hot"></i> {{ $jam->keterangan }}</span>
                                            @else
                                                <span style="font-weight: 600; color: #334155;">{{ $jam->keterangan ?: 'Sesi Pembelajaran KBM Jumat' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($jam->id_jam == 5)
                                        {{-- Insert visual break slot for Istirahat 1 Jumat --}}
                                        <tr style="background: #fffbeb;">
                                            <td style="text-align: center; font-weight: 700; color: #b45309;">-</td>
                                            <td><span class="badge-istirahat"><i class="fa-solid fa-mug-hot"></i> ISTIRAHAT 1</span></td>
                                            <td style="font-weight: 800; color: #b45309;">09:30 – 09:50 WIB</td>
                                            <td><span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">20 Menit</span></td>
                                            <td style="font-weight: 700; color: #92400e;">Istirahat Pagi Hari Jumat</td>
                                        </tr>
                                    @elseif($jam->id_jam == 8)
                                        {{-- Insert visual break slot for Sholat Jumat / ISHOMA --}}
                                        <tr style="background: #fffbeb;">
                                            <td style="text-align: center; font-weight: 700; color: #b45309;">-</td>
                                            <td><span class="badge-istirahat"><i class="fa-solid fa-mosque"></i> SHOLAT JUMAT / ISHOMA</span></td>
                                            <td style="font-weight: 800; color: #b45309;">11:20 – 13:00 WIB</td>
                                            <td><span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px;">100 Menit</span></td>
                                            <td style="font-weight: 700; color: #92400e;">Sholat Jumat Berjamaah, ISHOMA &amp; Keputrian</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL EDIT ALOKASI JAM --}}
<div id="modalEditJam" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-clock-rotate-left" style="color: #2563eb; margin-right: 6px;"></i> Edit Alokasi Jam Pelajaran</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="formEditJam" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Label Sesi Jam</label>
                    <input type="text" id="edit_jam_ke" class="form-control-modal" readonly style="background: #e2e8f0; font-weight: 700;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label>Waktu Mulai (Senin–Kamis)</label>
                        <input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control-modal">
                    </div>
                    <div class="form-group">
                        <label>Waktu Selesai (Senin–Kamis)</label>
                        <input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control-modal">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label>Waktu Mulai (Jumat)</label>
                        <input type="time" name="jam_mulai_jumat" id="edit_jam_mulai_jumat" class="form-control-modal">
                    </div>
                    <div class="form-group">
                        <label>Waktu Selesai (Jumat)</label>
                        <input type="time" name="jam_selesai_jumat" id="edit_jam_selesai_jumat" class="form-control-modal">
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan / Rincian Sesi</label>
                    <input type="text" name="keterangan" id="edit_keterangan" class="form-control-modal" placeholder="Contoh: Sesi Pembelajaran Pagi, Istirahat 1, dll">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-action-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function switchTab(tabName, btn) {
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        document.getElementById('tab-' + tabName).style.display = 'block';
        btn.classList.add('active');
    }

    function openEditModal(jam) {
        const form = document.getElementById('formEditJam');
        form.action = "{{ url('/waka-kurikulum/jam-pelajaran') }}/" + jam.id_jam;

        document.getElementById('edit_jam_ke').value = jam.jam_ke;
        document.getElementById('edit_jam_mulai').value = jam.jam_mulai ? jam.jam_mulai.substring(0, 5) : '';
        document.getElementById('edit_jam_selesai').value = jam.jam_selesai ? jam.jam_selesai.substring(0, 5) : '';
        document.getElementById('edit_jam_mulai_jumat').value = jam.jam_mulai_jumat ? jam.jam_mulai_jumat.substring(0, 5) : '';
        document.getElementById('edit_jam_selesai_jumat').value = jam.jam_selesai_jumat ? jam.jam_selesai_jumat.substring(0, 5) : '';
        document.getElementById('edit_keterangan').value = jam.keterangan || '';

        document.getElementById('modalEditJam').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('modalEditJam').classList.remove('active');
    }
</script>
@endsection
@endsection
