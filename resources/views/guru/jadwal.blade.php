@extends('layouts.guru')

@section('title', 'Jadwal Mengajar — EDU JOURNAL')
@section('header_title', 'Jadwal Mengajar Guru')

@section('styles')
<style>
    .jadwal-container-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1150px) {
        .jadwal-container-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Context Switcher Tabs (Jadwal Saya vs Jadwal Kelas Perwalian) */
    .context-tab-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 4px;
    }

    .context-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 12px 12px 0 0;
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -6px;
    }

    .context-tab-btn:hover {
        color: #1e293b;
        background: #f8fafc;
    }

    .context-tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: #eff6ff;
    }

    /* Day Pills Selector */
    .day-selector-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .day-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 8px 18px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        color: #475569;
        transition: all 0.2s ease;
        min-width: 82px;
    }

    .day-pill .day-name {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .day-pill .day-num {
        font-size: 17px;
        font-weight: 800;
        margin-top: 2px;
    }

    .day-pill.active {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.25);
    }

    .day-pill:hover:not(.active) {
        background: #f1f5f9;
        color: #1e293b;
        transform: translateY(-1px);
    }

    /* Filter & Search Bar */
    .filter-action-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .search-filter-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        max-width: 480px;
    }

    .input-search-jadwal {
        width: 100%;
        padding: 9px 14px 9px 36px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        background: #ffffff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="%2394a3b8" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0s208 93.1 208 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>') no-repeat 12px center;
        background-size: 14px 14px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .input-search-jadwal:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .select-status-filter {
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #334155;
        background: #ffffff;
        font-weight: 600;
        outline: none;
        cursor: pointer;
    }

    .btn-toolbar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-toolbar-white {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .btn-toolbar-white:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-toolbar-primary {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .btn-toolbar-primary:hover {
        background: #1d4ed8;
    }

    /* Table Container */
    .card-jadwal-table {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .table-schedule {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 10px 14px;
        text-align: left;
        letter-spacing: 0.5px;
    }

    .table-schedule tr.row-jadwal {
        border-radius: 12px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .table-schedule tr.row-jadwal:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table-schedule tr.row-jadwal td {
        padding: 14px 16px;
        font-size: 13px;
        vertical-align: middle;
    }

    .table-schedule tr.row-jadwal td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .table-schedule tr.row-jadwal td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Status Row Styling */
    .row-selesai {
        background: #f0fdf4;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .row-berlangsung {
        background: #fffbeb;
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }

    .row-belum {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .row-future {
        background: #f8fafc;
        color: #334155;
        border-left: 4px solid #94a3b8;
    }

    .row-guru-pengganti {
        background: #faf5ff;
        color: #6b21a8;
        border-left: 4px solid #a855f7;
    }

    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 0.2px;
    }

    .badge-status-selesai { background: #bbf7d0; color: #166534; }
    .badge-status-berlangsung { 
        background: #d97706; 
        color: #ffffff; 
        animation: pulseOrange 2s infinite;
    }
    .badge-status-belum { background: #fee2e2; color: #991b1b; }
    .badge-status-future { background: #e2e8f0; color: #475569; }
    .badge-status-pengganti { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }

    @keyframes pulseOrange {
        0% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(217, 119, 6, 0); }
        100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
    }

    /* Action Buttons in Rows */
    .btn-action-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: all 0.15s ease;
        cursor: pointer;
    }

    .btn-jurnal-isi { background: #2563eb; color: #ffffff; }
    .btn-jurnal-isi:hover { background: #1d4ed8; }

    .btn-jurnal-terisi { background: #ffffff; color: #166534; border: 1px solid #bbf7d0; }
    .btn-jurnal-terisi:hover { background: #dcfce7; }

    .btn-jurnal-belum { background: #e2e8f0; color: #64748b; border: 1px solid #cbd5e1; cursor: not-allowed; }

    .btn-modal-detail {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-modal-detail:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Matriks Timetable Grid Styling (aSc Timetables format) */
    .matrix-timetable {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .matrix-timetable th, .matrix-timetable td {
        border: 1px solid #cbd5e1;
        padding: 8px;
        vertical-align: top;
    }

    .matrix-timetable th {
        background: #f8fafc;
        font-weight: 800;
        text-align: center;
        color: #1e293b;
        font-size: 11px;
        text-transform: uppercase;
    }

    .matrix-cell-card {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 6px 8px;
        margin-bottom: 4px;
        font-size: 11.5px;
        line-height: 1.35;
        transition: transform 0.15s ease;
    }

    .matrix-cell-card:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Widgets */
    .widget-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
    }

    /* Modal Overlay & Card */
    .custom-modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .custom-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        animation: modalPop 0.2s ease-out;
    }

    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
        70% { transform: scale(1.03); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .modal-header-styled {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body-styled {
        padding: 24px;
    }

    .modal-footer-styled {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')

    <!-- Header & Subtitle -->
    <div style="margin-bottom: 20px; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i>
                Jadwal Mengajar
            </h1>
            <p style="font-size: 13.5px; color: #64748b; margin-top: 4px;">
                {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                @if($hariFilter === 'semua')
                    &nbsp;•&nbsp; <span style="font-weight: 700; color: #384972;">Jadwal Lengkap Mingguan (Senin – Jumat)</span>
                @elseif(isset($dayDates[$hariFilter]))
                    &nbsp;•&nbsp; <span style="font-weight: 700; color: #384972;">Jadwal Hari {{ $dayDates[$hariFilter]['day_name'] }} ({{ $dayDates[$hariFilter]['formatted'] }})</span>
                @endif
            </p>
        </div>

        <!-- Global Action Buttons: Cetak & Export -->
        <div style="display: flex; align-items: center; gap: 8px;">
            <a href="{{ route('guru.jadwal.print', ['tab' => $activeTab]) }}" target="_blank" class="btn-toolbar btn-toolbar-white" title="Cetak Lembar Resmi Jadwal">
                <i class="fa-solid fa-print" style="color: #2563eb;"></i> Cetak Jadwal
            </a>
            <a href="{{ route('guru.jadwal.export', ['tab' => $activeTab]) }}" class="btn-toolbar btn-toolbar-white" title="Ekspor ke format CSV/Excel">
                <i class="fa-solid fa-file-excel" style="color: #16a34a;"></i> Ekspor CSV
            </a>
            <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $hariFilter, 'tampilan' => ($viewMode === 'matriks' ? 'tabel' : 'matriks')]) }}" class="btn-toolbar {{ $viewMode === 'matriks' ? 'btn-toolbar-primary' : 'btn-toolbar-white' }}" title="Beralih Mode Tampilan">
                <i class="fa-solid {{ $viewMode === 'matriks' ? 'fa-table-list' : 'fa-table-cells' }}"></i> {{ $viewMode === 'matriks' ? 'Tampilan Tabel' : 'Matriks Mingguan' }}
            </a>
        </div>
    </div>

    <!-- Dual Context Tab Switcher (Khusus Wali Kelas) -->
    @if(isset($isWaliKelas) && $isWaliKelas && !empty($kelasWali))
        <div class="context-tab-bar">
            <a href="{{ route('guru.jadwal', ['tab' => 'saya', 'hari' => $hariFilter, 'tampilan' => $viewMode]) }}" class="context-tab-btn {{ $activeTab === 'saya' ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Jadwal Mengajar Saya
            </a>
            <a href="{{ route('guru.jadwal', ['tab' => 'perwalian', 'hari' => $hariFilter, 'tampilan' => $viewMode]) }}" class="context-tab-btn {{ $activeTab === 'perwalian' ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i> Jadwal KBM Kelas Perwalian ({{ $kelasWali->nama_kelas }})
            </a>
        </div>
    @endif

    <!-- Day Pills Navigation Bar (Kalender Otomatis Menyesuaikan Hari & Tanggal) -->
    <div class="day-selector-bar">
        <!-- Pill Semua Hari -->
        <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => 'semua', 'tampilan' => $viewMode]) }}" class="day-pill {{ $hariFilter === 'semua' ? 'active' : '' }}" title="Tampilkan Semua Jadwal Mingguan">
            <span class="day-name">SEMUA</span>
            <span class="day-num"><i class="fa-solid fa-calendar-week" style="font-size: 15px;"></i></span>
        </a>

        @foreach($dayDates as $key => $d)
            <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $key, 'tampilan' => $viewMode]) }}" class="day-pill {{ $hariFilter === $key ? 'active' : '' }}" title="{{ $d['full'] }}">
                <span class="day-name">{{ $d['name'] }}</span>
                <span class="day-num">{{ $d['num'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-action-toolbar">
        <form method="GET" action="{{ route('guru.jadwal') }}" class="search-filter-box">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="hidden" name="hari" value="{{ $hariFilter }}">
            <input type="hidden" name="tampilan" value="{{ $viewMode }}">
            
            <input type="text" name="q" id="inputSearchJadwal" value="{{ $searchQuery }}" class="input-search-jadwal" placeholder="Cari kelas, mata pelajaran, atau ruangan..." onkeyup="filterTableLive()">
            
            <select name="status_kbm" id="selectStatusKbm" class="select-status-filter" onchange="this.form.submit()">
                <option value="semua" {{ $statusFilter === 'semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>Selesai / Terisi</option>
                <option value="berlangsung" {{ $statusFilter === 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                <option value="belum_mulai" {{ $statusFilter === 'belum_mulai' ? 'selected' : '' }}>Belum Dimulai</option>
                <option value="terlewat" {{ $statusFilter === 'terlewat' ? 'selected' : '' }}>Belum Diisi / Terlewat</option>
            </select>
        </form>

        <div style="font-size: 12.5px; color: #64748b; font-weight: 600;">
            Menampilkan <strong>{{ $jadwals->count() }}</strong> Sesi KBM
            @if($activeTab === 'perwalian')
                di Kelas <strong>{{ $kelasWali->nama_kelas ?? '-' }}</strong>
            @else
                untuk <strong>{{ Auth::user()->name }}</strong>
            @endif
        </div>
    </div>

    @php
        $userAuth = Auth::user();
        $currentGuruId = $userAuth ? ($userAuth->id_guru ?? (optional($userAuth->guru)->id_guru ?? null)) : null;
        if (!$currentGuruId && $userAuth && $userAuth->nip) {
            $findCurrentGuru = \App\Models\Guru::where('nip', $userAuth->nip)->first();
            if ($findCurrentGuru) {
                $currentGuruId = $findCurrentGuru->id_guru;
            }
        }

        // Peringatan 5 menit hanya aktif untuk jadwal mengajar yang diampu user login sendiri
        $urgentJadwal = $jadwals->first(function($j) use ($currentGuruId) {
            $isOwner = ($currentGuruId && $j->id_guru == $currentGuruId) || !empty($j->is_guru_pengganti);
            return $isOwner && $j->hampir_habis;
        });
    @endphp

    @if($urgentJadwal)
        <div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 6px 18px rgba(239,68,68,0.15); animation: pulse 1.5s infinite;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 46px; height: 46px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 800; color: #991b1b;">Peringatan 5 Menit Terakhir: Jam Pelajaran Segera Habis!</div>
                    <div style="font-size: 13px; color: #b91c1c; margin-top: 2px;">
                        Jam pelajaran <strong>{{ $urgentJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $urgentJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong>{{ $urgentJadwal->sisa_menit_selesai }} menit lagi</strong> (berakhir pukul {{ $urgentJadwal->waktu_selesai_effective }} WIB) dan jurnal belum diisi. Segera isi jurnal sekarang sebelum waktu KBM habis dan fitur isi jurnal terkunci!
                    </div>
                </div>
            </div>
            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $urgentJadwal->id_jadwal]) }}" style="background: #dc2626; color: #ffffff; font-weight: 800; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-size: 13px; white-space: nowrap; box-shadow: 0 2px 8px rgba(220,38,38,0.3); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square"></i> Isi Sekarang
            </a>
        </div>
    @endif

    <!-- Grid Layout Container -->
    <div class="jadwal-container-grid">
        
        <!-- Left Column: Schedule Data (Table or Matrix Grid) -->
        <div>
            @if($viewMode === 'matriks')
                <!-- Mode Tampilan Matriks Mingguan (Timetable aSc Style) -->
                <div class="card-jadwal-table">
                    <div style="margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">
                            <i class="fa-solid fa-table-cells" style="color: #2563eb; margin-right: 6px;"></i> Matriks Jadwal Mingguan
                        </div>
                        <div style="font-size: 11.5px; color: #64748b;">
                            Format Matriks Mingguan SMKN 1 Boyolangu
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="matrix-timetable">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Jam Ke</th>
                                    <th style="width: 90px;">Senin–Kamis</th>
                                    <th style="width: 80px;">Jumat</th>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayCol)
                                        <th style="min-width: 140px;">{{ $dayCol }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($masterJamList as $jam)
                                    <tr>
                                        <td style="text-align: center; font-weight: 800; background: #f8fafc;">
                                            {{ $jam->jam_ke }}
                                        </td>
                                        <td style="text-align: center; font-size: 11px; color: #475569; background: #f8fafc;">
                                            {{ $jam->jam_mulai ? substr($jam->jam_mulai, 0, 5) . ' - ' . substr($jam->jam_selesai, 0, 5) : '-' }}
                                        </td>
                                        <td style="text-align: center; font-size: 11px; color: #475569; background: #f8fafc;">
                                            {{ $jam->jam_mulai_jumat ? substr($jam->jam_mulai_jumat, 0, 5) . ' - ' . substr($jam->jam_selesai_jumat, 0, 5) : '-' }}
                                        </td>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayCol)
                                            @php
                                                $matchingJadwals = ($jadwalsMatrixByDay[$dayCol] ?? collect())->filter(function($j) use ($jam) {
                                                    return $j->id_jam_mulai <= $jam->id_jam && $j->id_jam_selesai >= $jam->id_jam;
                                                });
                                            @endphp
                                            <td>
                                                @forelse($matchingJadwals as $mJ)
                                                    <div class="matrix-cell-card" style="border-left: 3px solid #2563eb;">
                                                        <strong style="color: #1e3a8a;">{{ $mJ->kelas->nama_kelas ?? '-' }}</strong>
                                                        <div style="font-weight: 700; color: #0f172a; margin-top: 1px;">{{ $mJ->mapel->nama_mapel ?? '-' }}</div>
                                                        @if($activeTab === 'perwalian')
                                                            <div style="font-size: 10px; color: #475569;">Guru: {{ $mJ->guru->nama_guru ?? '-' }}</div>
                                                        @endif
                                                        <div style="font-size: 10px; color: #64748b; margin-top: 2px;">
                                                            <i class="fa-solid fa-location-dot" style="font-size: 9px;"></i> {{ $mJ->ruangan->nama_ruangan ?? '-' }}
                                                        </div>
                                                    </div>
                                                @empty
                                                    <span style="color: #cbd5e1; font-size: 11px;">-</span>
                                                @endforelse
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Mode Tampilan Tabel Standar & Interaktif -->
                <div class="card-jadwal-table">
                    <div style="overflow-x: auto;">
                        <table class="table-schedule" id="tableJadwalMengajar">
                            <thead>
                                <tr>
                                    <th style="width: 135px;">JAM & SESI KBM</th>
                                    <th>{{ $activeTab === 'perwalian' ? 'MAPEL & GURU PENGAMPU' : 'NAMA / KELAS' }}</th>
                                    <th>{{ $activeTab === 'perwalian' ? 'ALOKASI KELAS' : 'MATA PELAJARAN' }}</th>
                                    <th style="width: 120px;">RUANG</th>
                                    <th style="width: 140px; text-align: center;">STATUS</th>
                                    <th style="width: 160px; text-align: right;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $j)
                                    @php
                                        $hKey = strtolower(trim($j->hari));
                                        $targetDateRow = ($hariFilter !== 'semua' && isset($dayDates[$hKey]))
                                            ? $dayDates[$hKey]['date']
                                            : ($dayDates[$hKey]['date'] ?? \Carbon\Carbon::now('Asia/Jakarta')->toDateString());
                                        
                                        $isTargetToday = ($dayDates[$hKey]['is_today'] ?? false);
                                        $isPast = ($targetDateRow < \Carbon\Carbon::now('Asia/Jakarta')->toDateString());
                                        $isFuture = ($targetDateRow > \Carbon\Carbon::now('Asia/Jakarta')->toDateString());

                                        $jurnalRecord = $j->getJurnalPadaTanggal($targetDateRow);
                                        $sudahDiisi = ($jurnalRecord !== null);
                                        $isSedangBerlangsung = $isTargetToday && $j->is_sedang_berlangsung;
                                        $isHampirHabis = $isSedangBerlangsung && $j->hampir_habis;
                                        $isJamSelesai = $isPast || ($isTargetToday && $j->is_jam_sudah_selesai);

                                        // Cek kepemilikan sesi mengajar ini:
                                        $isOwnerGuru = ($currentGuruId && $j->id_guru == $currentGuruId) || !empty($j->is_guru_pengganti);

                                        // Default status & button
                                        $rowClass = 'row-future';
                                        $statusBadge = '<span class="badge-status badge-status-future"><i class="fa-regular fa-clock"></i> Belum Dimulai</span>';
                                        $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-belum" disabled title="Jadwal KBM belum dimulai"><i class="fa-solid fa-lock"></i> Belum Mulai</button>';

                                        if ($sudahDiisi) {
                                            $rowClass = 'row-selesai';
                                            $statusBadge = '<span class="badge-status badge-status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</span>';
                                            $actionBtn = '<button type="button" onclick="showJurnalDetailModal(' . $jurnalRecord->id_jurnal . ')" class="btn-action-jurnal btn-jurnal-terisi" title="Lihat detail jurnal KBM yang telah diisi"><i class="fa-solid fa-eye"></i> Lihat Jurnal</button>';
                                        } elseif ($activeTab === 'perwalian' && !$isOwnerGuru) {
                                            // Mode Pantau Kelas Perwalian (Diampu oleh Guru Mapel Lain)
                                            if ($isSedangBerlangsung) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status badge-status-berlangsung"><i class="fa-solid fa-signal"></i> Berlangsung</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; cursor: default;" title="KBM sedang berlangsung dan diampu oleh ' . e($j->guru->nama_guru ?? 'Guru Pengampu') . '"><i class="fa-solid fa-chalkboard-user"></i> Diampu Guru</button>';
                                            } elseif ($isJamSelesai) {
                                                $rowClass = 'row-belum';
                                                $statusBadge = '<span class="badge-status" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;"><i class="fa-solid fa-clock-rotate-left"></i> Belum Diisi</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal" disabled style="background: #f8fafc; color: #94a3b8; border: 1px solid #cbd5e1; cursor: not-allowed;" title="Guru pengampu belum/tidak mengisi jurnal pada sesi ini"><i class="fa-solid fa-circle-exclamation"></i> Belum Diisi Guru</button>';
                                            } else {
                                                $rowClass = 'row-future';
                                                $statusBadge = '<span class="badge-status badge-status-future"><i class="fa-regular fa-clock"></i> Belum Dimulai</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-belum" disabled title="Jadwal KBM belum dimulai"><i class="fa-solid fa-lock"></i> Belum Mulai</button>';
                                            }
                                        } else {
                                            // Mode Guru Pengampu Sendiri (Tab Saya atau Guru Pengampu di Kelas Perwalian)
                                            if ($isHampirHabis) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-weight: 800; animation: pulse 1.5s infinite;"><i class="fa-solid fa-triangle-exclamation"></i> Sisa ' . $j->sisa_menit_selesai . ' Menit</span>';
                                                $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal, 'tanggal' => $targetDateRow]) . '" class="btn-action-jurnal" style="background: #dc2626; color: #ffffff; font-weight: 800; box-shadow: 0 2px 8px rgba(220,38,38,0.35); animation: pulse 1.5s infinite;" title="Segera isi jurnal sebelum jam KBM selesai!"><i class="fa-solid fa-bell"></i> Segera Isi</a>';
                                            } elseif ($isSedangBerlangsung) {
                                                $rowClass = 'row-berlangsung';
                                                $statusBadge = '<span class="badge-status badge-status-berlangsung"><i class="fa-solid fa-signal"></i> Berlangsung</span>';
                                                $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal, 'tanggal' => $targetDateRow]) . '" class="btn-action-jurnal btn-jurnal-isi" title="Jam KBM sedang berlangsung. Klik untuk mengisi jurnal."><i class="fa-solid fa-pen-to-square"></i> Isi Jurnal</a>';
                                            } elseif ($isJamSelesai) {
                                                $rowClass = 'row-belum';
                                                $statusBadge = '<span class="badge-status" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;"><i class="fa-solid fa-ban"></i> Waktu Habis</span>';
                                                $actionBtn = '<button type="button" class="btn-action-jurnal" disabled style="background: #f1f5f9; color: #94a3b8; border: 1px solid #cbd5e1; cursor: not-allowed; opacity: 0.85;" title="Waktu jam pelajaran telah berakhir (Pukul ' . $j->waktu_selesai_effective . ' WIB). Pengisian jurnal telah ditutup."><i class="fa-solid fa-lock"></i> Waktu Habis</button>';
                                            }
                                        }

                                        if (!empty($j->is_guru_pengganti)) {
                                            $rowClass = 'row-guru-pengganti';
                                            $statusBadge = '<span class="badge-status badge-status-pengganti"><i class="fa-solid fa-user-shield"></i> Guru Pengganti</span>';
                                        }
                                    @endphp

                                    <tr class="row-jadwal {{ $rowClass }}" data-search="{{ strtolower($j->kelas->nama_kelas ?? '') }} {{ strtolower($j->mapel->nama_mapel ?? '') }} {{ strtolower($j->guru->nama_guru ?? '') }} {{ strtolower($j->ruangan->nama_ruangan ?? '') }}">
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <strong>{{ $j->jam_range }}</strong>
                                                <span style="font-size: 10px; background: rgba(0,0,0,0.06); padding: 2px 6px; border-radius: 6px; font-weight: 800;">
                                                    {{ $j->jumlah_jp }} JP
                                                </span>
                                            </div>
                                            <div style="font-size: 11.5px; opacity: 0.85; margin-top: 2px;">
                                                {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} WIB
                                            </div>
                                            @if($hariFilter === 'semua')
                                                <div style="font-size: 10.5px; font-weight: 800; color: #2563eb; margin-top: 2px;">
                                                    {{ $j->hari }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            @if($activeTab === 'perwalian')
                                                <strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                                <div style="font-size: 11.5px; opacity: 0.85; margin-top: 2px;">
                                                    <i class="fa-solid fa-user-tie" style="font-size: 10px;"></i> {{ $j->guru->nama_guru ?? 'Guru Mapel' }}
                                                </div>
                                            @else
                                                <strong style="font-size: 14px; color: #0f172a;">{{ $j->kelas->nama_kelas ?? '-' }}</strong>
                                                <div style="font-size: 11.5px; opacity: 0.85; margin-top: 2px;">
                                                    {{ $j->guru->nama_guru ?? Auth::user()->name }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            @if($activeTab === 'perwalian')
                                                <span style="font-weight: 700; color: #1e293b;">{{ $j->kelas->nama_kelas ?? '-' }}</span>
                                                <div style="font-size: 11px; color: #64748b;">Kelas Perwalian</div>
                                            @else
                                                <strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                                <div style="font-size: 11px; color: #64748b;">{{ $j->mapel->kode_mapel ?? 'Kurikulum Merdeka' }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-location-dot" style="color: #64748b; font-size: 11px;"></i>
                                                <strong>{{ $j->ruangan->nama_ruangan ?? '-' }}</strong>
                                            </div>
                                        </td>

                                        <td style="text-align: center;">
                                            {!! $statusBadge !!}
                                        </td>

                                        <td style="text-align: right;">
                                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                                {!! $actionBtn !!}
                                                <button type="button" onclick="showJadwalModal({{ $j->id_jadwal }}, '{{ $j->kelas->nama_kelas ?? '-' }}', '{{ $j->mapel->nama_mapel ?? '-' }}', '{{ $j->guru->nama_guru ?? '-' }}', '{{ $j->ruangan->nama_ruangan ?? '-' }}', '{{ $j->hari }}', '{{ $j->jam_range }}', '{{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} WIB', '{{ $j->jumlah_jp }} JP', {{ $isOwnerGuru ? 'true' : 'false' }})" class="btn-modal-detail" title="Detail Jadwal">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 36px;">
                                            <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                            Tidak ada jadwal mengajar pada {{ $hariFilter === 'semua' ? 'seluruh hari' : 'hari ' . ($dayDates[$hariFilter]['day_name'] ?? ucfirst($hariFilter)) }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Sidebar Widgets -->
        <div>
            @if($activeTab === 'perwalian' && isset($isWaliKelas) && $isWaliKelas && !empty($kelasWali))
                <!-- ================= WIDGETS TAB PERWALIAN ================= -->
                
                <!-- Widget 1: Progres Jurnal KBM Kelas Perwalian -->
                <div class="widget-box" style="border-top: 4px solid #2563eb;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-chart-pie" style="color: #2563eb; margin-right: 6px;"></i> Progres Jurnal Kelas</span>
                        <span style="font-size: 11px; background: #dcfce7; color: #15803d; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                            {{ $statsProgres['persen'] ?? 0 }}%
                        </span>
                    </div>
                    <div style="margin-top: 12px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                            <span>Status Terisi</span>
                            <span style="color: #0f172a;">{{ $statsProgres['terisi'] ?? 0 }} / {{ $statsProgres['total'] ?? 0 }} Sesi KBM</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                            <div style="width: {{ $statsProgres['persen'] ?? 0 }}%; height: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 6px; transition: width 0.3s ease;"></div>
                        </div>

                        <!-- Shortcut Action Buttons Khusus Wali Kelas -->
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 10px; border-radius: 10px; font-weight: 800; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                                <i class="fa-solid fa-users-viewfinder"></i> Rekap Presensi Kelas Perwalian
                            </a>
                            <a href="{{ route('guru.surat-izin.trash') }}" class="btn-action-jurnal" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; width: 100%; justify-content: center; padding: 9px; border-radius: 10px; font-weight: 700;">
                                <i class="fa-solid fa-envelope-open-text" style="color: #2563eb;"></i> Kelola Surat Izin Siswa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Widget 2: Status Kehadiran Siswa Perwalian Hari Ini -->
                @if(!empty($dataWaliKelas))
                    <div class="widget-box" style="border-top: 4px solid #10b981;">
                        <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-solid fa-users-rectangle" style="color: #10b981; margin-right: 6px;"></i> Presensi Siswa ({{ $dataWaliKelas['hariNama'] ?? 'Hari Ini' }})</span>
                            <span style="font-size: 10px; background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 6px; font-weight: 800;">KELAS {{ $dataWaliKelas['kelas']->nama_kelas }}</span>
                        </div>
                        <div style="margin-top: 10px;">
                            <div style="font-size: 12px; color: #475569; margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span>Total Siswa: <strong>{{ $dataWaliKelas['totalSiswa'] ?? 0 }}</strong></span>
                                <span>Tercatat: <strong>{{ $dataWaliKelas['jurnalTerisi'] ?? 0 }} Mapel</strong></span>
                            </div>
                            
                            <!-- 4 Grid Badge Hadir / Sakit / Izin / Alpa -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 12px;">
                                <div style="background: #dcfce7; padding: 6px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                    <div style="font-size: 10px; font-weight: 800; color: #166534;">HADIR</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #15803d;">{{ $dataWaliKelas['totalHadir'] ?? 0 }}</div>
                                </div>
                                <div style="background: #fef9c3; padding: 6px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                    <div style="font-size: 10px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #a16207;">{{ $dataWaliKelas['rekapAbsensi']['sakit'] ?? 0 }}</div>
                                </div>
                                <div style="background: #e0f2fe; padding: 6px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                    <div style="font-size: 10px; font-weight: 800; color: #075985;">IZIN</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0369a1;">{{ $dataWaliKelas['rekapAbsensi']['izin'] ?? 0 }}</div>
                                </div>
                                <div style="background: #fee2e2; padding: 6px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                    <div style="font-size: 10px; font-weight: 800; color: #991b1b;">ALPA</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #b91c1c;">{{ $dataWaliKelas['rekapAbsensi']['alpa'] ?? 0 }}</div>
                                </div>
                            </div>

                            <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-action-jurnal" style="background: #ffffff; color: #166534; border: 1px solid #bbf7d0; width: 100%; justify-content: center; padding: 8px; border-radius: 8px; font-weight: 700;">
                                <i class="fa-solid fa-clipboard-user"></i> Lihat Detail Ketidakhadiran
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Widget 3: Beban Mengajar Pribadi Guru -->
                <div class="widget-box" style="border-top: 4px solid #0284c7;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-briefcase" style="color: #0284c7; margin-right: 6px;"></i> Beban Mengajar Saya</span>
                        <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                            {{ $statsBeban['totalJpSeminggu'] ?? 0 }} JP / MINGGU
                        </span>
                    </div>
                    <div style="margin-top: 10px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; margin-bottom: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; text-align: center;">
                            <div style="border-right: 1px solid #e2e8f0;">
                                <div style="font-size: 10px; color: #64748b; font-weight: 700; text-transform: uppercase;">Jam Hari Ini</div>
                                <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalJpHariIni'] ?? 0 }} JP</div>
                            </div>
                            <div>
                                <div style="font-size: 10px; color: #15803d; font-weight: 700; text-transform: uppercase;">JP Terlaksana</div>
                                <div style="font-size: 16px; font-weight: 800; color: #166534; margin-top: 2px;">{{ $statsBeban['totalJpTerisiHariIni'] ?? 0 }} JP</div>
                            </div>
                        </div>
                        <a href="{{ route('guru.jadwal', ['tab' => 'saya']) }}" class="btn-action-jurnal" style="background: #0284c7; color: #ffffff; width: 100%; justify-content: center; padding: 8px; border-radius: 8px; font-weight: 700;">
                            <i class="fa-solid fa-chalkboard-user"></i> Beralih ke Jadwal Mengajar Saya
                        </a>
                    </div>
                </div>

            @else
                <!-- ================= WIDGETS TAB JADWAL SAYA ================= -->
                
                <!-- Widget 1: Progres Jurnal Mengajar Saya -->
                <div class="widget-box" style="border-top: 4px solid #2563eb;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-chart-pie" style="color: #2563eb; margin-right: 6px;"></i> Progres Jurnal Saya ({{ $hariFilter === 'semua' ? 'Mingguan' : ($dayDates[$hariFilter]['day_name'] ?? ucfirst($hariFilter)) }})</span>
                        <span style="font-size: 11px; background: #dcfce7; color: #15803d; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                            {{ $statsProgres['persen'] ?? 0 }}%
                        </span>
                    </div>
                    <div style="margin-top: 12px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                            <span>Status Terisi</span>
                            <span style="color: #0f172a;">{{ $statsProgres['terisi'] ?? 0 }} / {{ $statsProgres['total'] ?? 0 }} Kelas</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                            <div style="width: {{ $statsProgres['persen'] ?? 0 }}%; height: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 6px; transition: width 0.3s ease;"></div>
                        </div>

                        <!-- Shortcut Action Buttons -->
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <a href="{{ route('guru.jurnal-harian') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 10px; border-radius: 10px; font-weight: 800; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Harian
                            </a>
                            <a href="{{ route('guru.absensi-siswa') }}" class="btn-action-jurnal" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; width: 100%; justify-content: center; padding: 9px; border-radius: 10px; font-weight: 700;">
                                <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi Siswa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Widget 2: Beban Mengajar (JP) -->
                <div class="widget-box" style="border-top: 4px solid #0284c7;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-briefcase" style="color: #0284c7; margin-right: 6px;"></i> Beban Mengajar (JP)</span>
                        <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                            {{ $statsBeban['totalJpSeminggu'] ?? 0 }} JP / MINGGU
                        </span>
                    </div>
                    <div style="margin-top: 12px;">
                        <!-- Ringkasan Jam Hari Ini vs Terlaksana -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; margin-bottom: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: center;">
                            <div style="border-right: 1px solid #e2e8f0;">
                                <div style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Jam Hari Ini</div>
                                <div style="font-size: 19px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalJpHariIni'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">JP</span></div>
                            </div>
                            <div>
                                <div style="font-size: 10.5px; color: #15803d; font-weight: 700; text-transform: uppercase;">JP Terlaksana</div>
                                <div style="font-size: 19px; font-weight: 800; color: #166534; margin-top: 2px;">{{ $statsBeban['totalJpTerisiHariIni'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #15803d;">JP</span></div>
                            </div>
                        </div>

                        <!-- Breakdown Beban Mengajar Per Hari -->
                        <div style="font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-regular fa-calendar-days" style="color: #0284c7;"></i> Sebaran JP Minggu Ini</span>
                            <span style="font-size: 11px; font-weight: 600; color: #64748b;">Senin – Jumat</span>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px;">
                            @php
                                $daysMap = ['senin' => 'SEN', 'selasa' => 'SEL', 'rabu' => 'RAB', 'kamis' => 'KAM', 'jumat' => 'JUM'];
                            @endphp
                            @foreach($daysMap as $hKey => $hShort)
                                @php
                                    $jpVal = $statsBeban['jpHarian'][$hKey] ?? 0;
                                    $isCurrent = strtolower($hariFilter) === $hKey;
                                @endphp
                                <a href="{{ route('guru.jadwal', ['tab' => $activeTab, 'hari' => $hKey, 'tampilan' => $viewMode]) }}" style="text-decoration: none;">
                                    <div style="padding: 7px 3px; border-radius: 10px; text-align: center; border: 1px solid {{ $isCurrent ? '#0284c7' : '#cbd5e1' }}; background: {{ $isCurrent ? '#0284c7' : ($jpVal > 0 ? '#f0f9ff' : '#f8fafc') }}; color: {{ $isCurrent ? '#ffffff' : ($jpVal > 0 ? '#0369a1' : '#94a3b8') }}; transition: all 0.15s ease;">
                                        <div style="font-size: 10px; font-weight: 800;">{{ $hShort }}</div>
                                        <div style="font-size: 13px; font-weight: 800; margin-top: 1px;">{{ $jpVal }}<span style="font-size: 9px; font-weight: 600;"> JP</span></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Widget 3: Kontekstual Role (Wali Kelas / Guru Mengajar) -->
                @if(isset($isWaliKelas) && $isWaliKelas && !empty($dataWaliKelas))
                    <!-- Card Khusus Role Wali Kelas -->
                    <div class="widget-box" style="border-top: 4px solid #2563eb;">
                        <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-solid fa-graduation-cap" style="color: #2563eb; margin-right: 6px;"></i> Kelas Wali: {{ $dataWaliKelas['kelas']->nama_kelas ?? 'Wali Kelas' }}</span>
                            <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 6px; font-weight: 800;">WALI KELAS</span>
                        </div>
                        <div style="margin-top: 10px;">
                            <div style="font-size: 12px; color: #475569; margin-bottom: 10px;">
                                <strong>Total Siswa:</strong> {{ $dataWaliKelas['totalSiswa'] ?? 0 }} Siswa | <strong>Jurnal Terisi ({{ $dataWaliKelas['hariNama'] ?? 'Hari Ini' }}):</strong> {{ $dataWaliKelas['jurnalTerisi'] ?? 0 }} Mapel
                            </div>
                            <!-- Status Kehadiran Kelas Wali Hari Ini -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 12px;">
                                <div style="background: #dcfce7; padding: 6px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                    <div style="font-size: 10px; font-weight: 800; color: #166534;">HADIR</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #15803d;">{{ $dataWaliKelas['totalHadir'] ?? 0 }}</div>
                                </div>
                                <div style="background: #fef9c3; padding: 6px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                    <div style="font-size: 10px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #a16207;">{{ $dataWaliKelas['rekapAbsensi']['sakit'] ?? 0 }}</div>
                                </div>
                                <div style="background: #e0f2fe; padding: 6px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                    <div style="font-size: 10px; font-weight: 800; color: #075985;">IZIN</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0369a1;">{{ $dataWaliKelas['rekapAbsensi']['izin'] ?? 0 }}</div>
                                </div>
                                <div style="background: #fee2e2; padding: 6px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                    <div style="font-size: 10px; font-weight: 800; color: #991b1b;">ALPA</div>
                                    <div style="font-size: 14px; font-weight: 800; color: #b91c1c;">{{ $dataWaliKelas['rekapAbsensi']['alpa'] ?? 0 }}</div>
                                </div>
                            </div>

                            <a href="{{ route('guru.jadwal', ['tab' => 'perwalian']) }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 9px; border-radius: 10px; font-weight: 700;">
                                <i class="fa-solid fa-graduation-cap"></i> Pantau Jadwal KBM Kelas Perwalian
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Card Ringkasan Kelas Ampuhan (Guru Mengajar Regular) -->
                    <div class="widget-box" style="border-top: 4px solid #384972;">
                        <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-solid fa-chalkboard-user" style="color: #384972; margin-right: 6px;"></i> Ringkasan Mengajar</span>
                            <span style="font-size: 10px; background: #f1f5f9; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 800;">GURU</span>
                        </div>
                        <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px;">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 10px; text-align: center;">
                                <div style="font-size: 10.5px; font-weight: 700; color: #475569; text-transform: uppercase;">Total Kelas</div>
                                <div style="font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalKelasDiajar'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Kelas</span></div>
                            </div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 10px; text-align: center;">
                                <div style="font-size: 10.5px; font-weight: 700; color: #475569; text-transform: uppercase;">Mata Pelajaran</div>
                                <div style="font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalMapelDiajar'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Mapel</span></div>
                            </div>
                        </div>
                        <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-action-jurnal" style="background: #384972; color: #ffffff; width: 100%; justify-content: center; padding: 9px; border-radius: 10px; font-weight: 700;">
                            <i class="fa-solid fa-book-open"></i> Lihat Riwayat Jurnal
                        </a>
                    </div>
                @endif
            @endif
        </div>

    </div>

    <!-- Modal 1: Detail Jadwal Pelajaran -->
    <div id="modalDetailJadwal" class="custom-modal-backdrop">
        <div class="custom-modal-box">
            <div class="modal-header-styled">
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-calendar-day" style="color: #2563eb;"></i> Detail Jadwal KBM
                </div>
                <button type="button" onclick="closeModal('modalDetailJadwal')" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-styled">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <span id="modalKelasName" style="font-size: 18px; font-weight: 800; color: #0f172a;">-</span>
                        <span id="modalAlokasiJp" style="font-size: 12px; background: #dbeafe; color: #1d4ed8; padding: 3px 10px; border-radius: 8px; font-weight: 800;">- JP</span>
                    </div>
                    <div id="modalMapelName" style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">-</div>
                    <div style="font-size: 12.5px; color: #64748b; display: flex; align-items: center; gap: 14px;">
                        <span><i class="fa-solid fa-user-tie" style="margin-right: 4px;"></i> <span id="modalGuruName">-</span></span>
                        <span><i class="fa-solid fa-location-dot" style="margin-right: 4px;"></i> <span id="modalRuangName">-</span></span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                    <div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Hari & Jam Pelajaran</div>
                        <div id="modalHariJam" style="font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                    </div>
                    <div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Waktu Efektif KBM</div>
                        <div id="modalWaktuEfektif" style="font-weight: 800; color: #0f172a; margin-top: 2px;">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-styled">
                <button type="button" onclick="closeModal('modalDetailJadwal')" class="btn-toolbar btn-toolbar-white">
                    Tutup
                </button>
                <a id="modalBtnIsiJurnal" href="{{ route('guru.jurnal-harian') }}" class="btn-toolbar btn-toolbar-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Jurnal Harian
                </a>
            </div>
        </div>
    </div>

    <!-- Modal 2: Quick View Jurnal Terisi -->
    <div id="modalDetailJurnal" class="custom-modal-backdrop">
        <div class="custom-modal-box" style="max-width: 620px;">
            <div class="modal-header-styled">
                <div style="font-size: 16px; font-weight: 800; color: #166534; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-check" style="color: #22c55e;"></i> Detail Jurnal Mengajar
                </div>
                <button type="button" onclick="closeModal('modalDetailJurnal')" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-styled" id="modalJurnalContent">
                <div style="text-align: center; padding: 24px; color: #64748b;">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 24px; color: #2563eb;"></i>
                    <div style="margin-top: 8px; font-weight: 600;">Memuat data jurnal...</div>
                </div>
            </div>
            <div class="modal-footer-styled">
                <button type="button" onclick="closeModal('modalDetailJurnal')" class="btn-toolbar btn-toolbar-white">
                    Tutup
                </button>
                <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-toolbar btn-toolbar-primary">
                    <i class="fa-solid fa-book-open"></i> Riwayat Lengkap
                </a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Live Client-side Filter Table
    function filterTableLive() {
        const input = document.getElementById('inputSearchJadwal').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tableJadwalMengajar tbody tr.row-jadwal');
        
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Handlers
    function showJadwalModal(id, kelas, mapel, guru, ruang, hari, jamRange, waktuRange, alokasi, isOwner = false) {
        document.getElementById('modalKelasName').innerText = kelas;
        document.getElementById('modalMapelName').innerText = mapel;
        document.getElementById('modalGuruName').innerText = guru;
        document.getElementById('modalRuangName').innerText = ruang;
        document.getElementById('modalHariJam').innerText = hari + ' (' + jamRange + ')';
        document.getElementById('modalWaktuEfektif').innerText = waktuRange;
        document.getElementById('modalAlokasiJp').innerText = alokasi;
        
        const btnIsi = document.getElementById('modalBtnIsiJurnal');
        if (btnIsi) {
            if (isOwner) {
                btnIsi.style.display = 'inline-flex';
                btnIsi.href = "{{ route('guru.jurnal-harian') }}?id_jadwal=" + id;
            } else {
                btnIsi.style.display = 'none';
            }
        }

        document.getElementById('modalDetailJadwal').style.display = 'flex';
    }

    function showJurnalDetailModal(idJurnal) {
        const modal = document.getElementById('modalDetailJurnal');
        const content = document.getElementById('modalJurnalContent');
        modal.style.display = 'flex';
        content.innerHTML = `
            <div style="text-align: center; padding: 24px; color: #64748b;">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 24px; color: #2563eb;"></i>
                <div style="margin-top: 8px; font-weight: 600;">Memuat rincian jurnal mengajar...</div>
            </div>
        `;

        fetch(`{{ url('/guru-jurnal-detail') }}/${idJurnal}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success || !res.data) {
                    content.innerHTML = `
                        <div style="text-align: center; color: #991b1b; padding: 16px;">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; margin-bottom: 6px;"></i>
                            <div>Gagal memuat rincian jurnal mengajar.</div>
                        </div>
                    `;
                    return;
                }

                const d = res.data;
                const stats = d.statistik_kehadiran || { total_siswa: 0, hadir: 0, sakit: 0, izin: 0, alpa: 0 };
                const absenItems = d.daftar_absen || [];

                let absenTableHtml = '';
                if (absenItems.length > 0) {
                    const rows = absenItems.map(a => `
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 6px 8px; font-weight: 600; color: #1e293b;">
                                ${a.nama_siswa} <span style="font-size: 10px; color: #94a3b8;">(${a.nisn})</span>
                            </td>
                            <td style="padding: 6px 8px; text-align: right;">
                                <span style="font-weight: 800; font-size: 10.5px; padding: 2px 8px; border-radius: 4px; ${a.keterangan === 'Sakit' ? 'background: #fef9c3; color: #854d0e;' : (a.keterangan === 'Alpa' ? 'background: #fee2e2; color: #991b1b;' : 'background: #e0f2fe; color: #0369a1;')}">${a.keterangan}</span>
                            </td>
                        </tr>
                    `).join('');

                    absenTableHtml = `
                        <div style="margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 8px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 6px;">Daftar Siswa Tidak Hadir:</div>
                            <table style="width: 100%; font-size: 11.5px; border-collapse: collapse;">
                                <thead>
                                    <tr style="text-align: left; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        <th style="padding: 4px 8px;">Nama Siswa</th>
                                        <th style="padding: 4px 8px; text-align: right;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>
                    `;
                } else {
                    absenTableHtml = `
                        <div style="font-size: 11.5px; color: #166534; font-weight: 600; text-align: center; padding: 6px 0; background: #f0fdf4; border-radius: 8px; margin-top: 8px;">
                            <i class="fa-solid fa-check-double"></i> Seluruh siswa hadir dalam pembelajaran ini.
                        </div>
                    `;
                }

                content.innerHTML = `
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px; margin-bottom: 14px;">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 8px;">
                            <div>
                                <div style="font-size: 16px; font-weight: 800; color: #0f172a;">${d.mapel}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    <span style="font-weight: 700; color: #334155;">${d.kelas}</span> &bull; 
                                    <span>${d.ruangan}</span> &bull; 
                                    <span>${d.hari}, ${d.tanggal_formatted}</span>
                                </div>
                            </div>
                            <span style="background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; white-space: nowrap; border: 1px solid #bbf7d0;">
                                <i class="fa-solid fa-circle-check"></i> TERISI
                            </span>
                        </div>
                        
                        <div style="font-size: 12px; color: #475569; display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; padding-top: 8px; border-top: 1px dashed #cbd5e1;">
                            <div><i class="fa-solid fa-user-tie" style="color: #2563eb; margin-right: 4px;"></i> <strong>Guru:</strong> ${d.guru} ${d.is_guru_pengganti ? `(Pengganti: ${d.guru_pengganti})` : ''}</div>
                            <div><i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 4px;"></i> <strong>Jam:</strong> ${d.jam_ke} (${d.waktu_kbm})</div>
                            <div><i class="fa-solid fa-layer-group" style="color: #2563eb; margin-right: 4px;"></i> <strong>Pertemuan:</strong> Ke-${d.pertemuan_ke}</div>
                        </div>
                    </div>

                    <!-- Materi & Catatan -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; margin-bottom: 14px;">
                        <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Materi Pembelajaran</div>
                        <div style="font-size: 13px; font-weight: 600; color: #1e293b; line-height: 1.4;">${d.materi || '-'}</div>
                        
                        <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-top: 10px; margin-bottom: 4px;">Catatan / Evaluasi KBM</div>
                        <div style="font-size: 12px; color: #475569; line-height: 1.4;">${d.catatan || 'Tidak ada catatan.'}</div>
                    </div>

                    <!-- Rekap Presensi Siswa -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                        <div style="font-size: 12.5px; font-weight: 800; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa-solid fa-users" style="color: #2563eb; margin-right: 6px;"></i> Presensi Siswa (${stats.total_siswa} Siswa)</span>
                            <span style="font-size: 11.5px; color: #166534; font-weight: 800;">Hadir: ${stats.hadir} Siswa</span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 8px;">
                            <div style="background: #dcfce7; padding: 6px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                <div style="font-size: 10px; font-weight: 800; color: #166534;">HADIR</div>
                                <div style="font-size: 13px; font-weight: 800; color: #15803d;">${stats.hadir}</div>
                            </div>
                            <div style="background: #fef9c3; padding: 6px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                <div style="font-size: 10px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                <div style="font-size: 13px; font-weight: 800; color: #a16207;">${stats.sakit}</div>
                            </div>
                            <div style="background: #e0f2fe; padding: 6px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                <div style="font-size: 10px; font-weight: 800; color: #075985;">IZIN</div>
                                <div style="font-size: 13px; font-weight: 800; color: #0369a1;">${stats.izin}</div>
                            </div>
                            <div style="background: #fee2e2; padding: 6px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                <div style="font-size: 10px; font-weight: 800; color: #991b1b;">ALPA</div>
                                <div style="font-size: 13px; font-weight: 800; color: #b91c1c;">${stats.alpa}</div>
                            </div>
                        </div>
                        
                        ${absenTableHtml}
                    </div>
                `;
            })
            .catch(() => {
                content.innerHTML = `
                    <div style="text-align: center; color: #991b1b; padding: 16px;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; margin-bottom: 6px;"></i>
                        <div>Gagal memuat rincian jurnal mengajar.</div>
                    </div>
                `;
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Close on backdrop click
    window.addEventListener('click', function(e) {
        ['modalDetailJadwal', 'modalDetailJurnal'].forEach(id => {
            const el = document.getElementById(id);
            if (el && e.target === el) {
                el.style.display = 'none';
            }
        });
    });
</script>
@endsection
