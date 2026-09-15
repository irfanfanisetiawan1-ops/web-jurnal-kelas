@extends('layouts.kepala_sekolah')

@section('title', 'Jurnal Mengajar Guru — Jurnal SMEA')
@section('header_title', 'Jurnal Mengajar Guru')

@section('styles')
<style>
    .jurnal-kepsek-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 30px;
    }

    /* Main Card Container */
    .card-jurnal-main {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Card Top Bar Header */
    .card-top-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 4px;
    }

    .title-left-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .icon-header-box {
        color: #2563eb;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid #dbeafe;
    }

    .title-header-text {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .badge-total-sesi {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-top {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 12px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-action-export {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }

    .btn-action-export:hover {
        background: #166534;
        color: #ffffff;
        border-color: #166534;
        box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
    }

    .btn-action-print {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .btn-action-print:hover {
        background: #1d4ed8;
        color: #ffffff;
        border-color: #1d4ed8;
        box-shadow: 0 4px 12px rgba(29, 78, 216, 0.2);
    }

    .btn-action-harian {
        background: #2b3957;
        color: #ffffff;
        border-color: #1e293b;
    }

    .btn-action-harian:hover {
        background: #1e293b;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(43, 57, 87, 0.3);
    }

    /* Filter Form Grid */
    .filter-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 18px;
    }

    .filter-grid-row-1 {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .filter-grid-row-2 {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-box {
        position: relative;
        flex: 1.8;
        min-width: 240px;
    }

    .search-input-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-box input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .search-input-box input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-select-item {
        flex: 1;
        min-width: 160px;
    }

    .filter-select-item select, .filter-select-item input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .filter-select-item select:focus, .filter-select-item input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-action {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-filter-action:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-reset-action {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-reset-action:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Table Custom */
    .table-container-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-jurnal-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .table-jurnal-custom thead {
        background: #2b3957;
        color: #ffffff;
    }

    .table-jurnal-custom thead th {
        padding: 14px 16px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #1e293b;
        white-space: nowrap;
    }

    .table-jurnal-custom tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }

    .table-jurnal-custom tbody tr:hover {
        background-color: #f8fafc;
    }

    .table-jurnal-custom tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: #334155;
    }

    /* Date display block */
    .date-display-block {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-big-day {
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
    }

    .date-month-year {
        display: flex;
        flex-direction: column;
        font-size: 10.5px;
        font-weight: 800;
        color: #64748b;
        line-height: 1.2;
    }

    .subject-title-bold {
        font-size: 14px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 2px;
    }

    .subject-time-sub {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    .class-title-bold {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .room-sub-tag {
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .teacher-name-bold {
        font-size: 13.5px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .teacher-nip-sub {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
    }

    .materi-title-bold {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        max-width: 240px;
        line-height: 1.4;
    }

    .badge-kondisi-tag {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 700;
        display: inline-block;
    }

    .pertemuan-val-bold {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .pertemuan-jp-sub {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
    }

    /* Badges */
    .badge-kbm-terlaksana {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-kbm-izin {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-kbm-tidak-hadir {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-kbm-digantikan {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .badge-verif-terverifikasi {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .badge-verif-terverifikasi:hover {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .badge-verif-belum {
        background: #f8fafc;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-eye-action {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-eye-action:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    /* Pagination */
    .custom-pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-num-btn, .page-nav-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        transition: all 0.15s ease;
    }

    .page-num-btn:hover, .page-nav-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    .page-num-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .page-nav-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Modal Overlay & Card */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 88vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-styled {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        border-radius: 20px 20px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modal-body-styled {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-grid-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .detail-item-box {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .detail-item-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }

    .detail-item-val {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .presensi-table-mini {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        margin-top: 6px;
    }

    .presensi-table-mini th {
        background: #f1f5f9;
        padding: 8px 10px;
        font-weight: 700;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .presensi-table-mini td {
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
    }

    /* Date selection list in modal */
    .date-pick-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        transition: all 0.2s ease;
    }

    .date-pick-item-card:hover {
        border-color: #2563eb;
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
    }

    .date-badge-pill {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
    }

    @media (max-width: 992px) {
        .card-top-header { flex-direction: column; align-items: flex-start; }
        .filter-grid-row-1, .filter-grid-row-2 { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')

@php
    $selectedTanggal = request('tanggal');
    $dateLabelFormatted = 'Semua Tanggal';
    if ($selectedTanggal) {
        $cDate = \Carbon\Carbon::parse($selectedTanggal)->locale('id');
        $hariIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $monthsMapIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $hariName = $hariIndo[$cDate->format('l')] ?? 'Senin';
        $dateLabelFormatted = $hariName . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
    }
@endphp

<div class="jurnal-kepsek-container">

    <!-- Card Main Wrapper -->
    <div class="card-jurnal-main">

        <!-- Card Top Bar Header with Export & Print Actions -->
        <div class="card-top-header">
            <div class="title-left-group">
                <div class="icon-header-box">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <div>
                    <h1 class="title-header-text">Daftar Jurnal Mengajar Guru</h1>
                    <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                        Menampilkan tanggal: <strong style="color: #0f172a;">{{ $dateLabelFormatted }}</strong>
                    </div>
                </div>
                <span class="badge-total-sesi">Total: {{ $jurnals->total() }} Sesi</span>
            </div>

            <!-- Action Buttons: Export CSV, Print Dokumen, Cetak Rekap Harian -->
            <div class="header-actions-group">
                <a href="{{ route('kepala-sekolah.jurnal-pembelajaran.export', request()->query()) }}" class="btn-action-top btn-action-export" title="Ekspor daftar jurnal mengajar yang difilter ke file CSV/Excel">
                    <i class="fa-solid fa-file-excel"></i> Ekspor CSV
                </a>

                <a href="{{ route('kepala-sekolah.jurnal-pembelajaran.print', request()->query()) }}" target="_blank" class="btn-action-top btn-action-print" title="Cetak daftar jurnal mengajar sesuai filter">
                    <i class="fa-solid fa-print"></i> Cetak Daftar
                </a>

                <button type="button" onclick="openSelectDatePrintModal()" class="btn-action-top btn-action-harian" title="Pilih tanggal pelaksanaan KBM untuk mencetak Rekapitulasi Jurnal Harian">
                    <i class="fa-solid fa-file-signature"></i> Cetak Rekap Harian
                </button>
            </div>
        </div>

        <!-- Filter Form Grid -->
        <div class="filter-section-card">
            <form method="GET" action="{{ route('kepala-sekolah.jurnal-pembelajaran') }}">
                <!-- Row 1: Search, Tanggal, Guru, Kelas -->
                <div class="filter-grid-row-1">
                    <div class="search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Mata Pelajaran / Guru / Kelas / Materi...">
                    </div>

                    <div class="filter-select-item" style="max-width: 170px;">
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" title="Pilih Tanggal">
                    </div>

                    <div class="filter-select-item">
                        <select name="id_guru">
                            <option value="">👥 Semua Guru</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}" {{ request('id_guru') == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-select-item">
                        <select name="id_kelas">
                            <option value="">🏫 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 2: Mapel, Status KBM, Filter Button, Reset Button -->
                <div class="filter-grid-row-2">
                    <div class="filter-select-item" style="flex: 1.5;">
                        <select name="id_mapel">
                            <option value="">📖 Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ request('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-select-item" style="max-width: 180px;">
                        <select name="status_kbm">
                            <option value="">Status KBM</option>
                            <option value="terlaksana" {{ request('status_kbm') == 'terlaksana' ? 'selected' : '' }}>🟢 Terlaksana</option>
                            <option value="izin" {{ request('status_kbm') == 'izin' ? 'selected' : '' }}>🟡 Izin</option>
                            <option value="tidak_hadir" {{ request('status_kbm') == 'tidak_hadir' ? 'selected' : '' }}>🔴 Tidak Hadir</option>
                            <option value="digantikan" {{ request('status_kbm') == 'digantikan' ? 'selected' : '' }}>🔵 Digantikan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter-action">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    @if(request()->hasAny(['q', 'tanggal', 'id_guru', 'id_kelas', 'id_mapel', 'status_kbm']))
                        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" class="btn-reset-action">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Responsive -->
        <div class="table-container-responsive">
            <table class="table-jurnal-custom">
                <thead>
                    <tr>
                        <th style="width: 90px;">TANGGAL</th>
                        <th>MATA PELAJARAN</th>
                        <th>KELAS & RUANG</th>
                        <th>GURU PENGAMPU</th>
                        <th>MATERI PEMBELAJARAN</th>
                        <th style="text-align: center; width: 90px;">PERTEMUAN</th>
                        <th style="text-align: center; width: 120px;">STATUS KBM</th>
                        <th style="text-align: center; width: 140px;">VERIFIKASI PIKET</th>
                        <th style="text-align: center; width: 60px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                    @php
                        $tglObj = \Carbon\Carbon::parse($j->tanggal);
                        $dayNum = $tglObj->format('d');
                        $monthStr = strtoupper($tglObj->format('M'));
                        $yearStr = $tglObj->format('Y');

                        $namaGuru = $j->jadwal->guru->nama_guru ?? ($j->guru->nama_guru ?? '-');
                        $nipGuru = $j->jadwal->guru->nip ?? ($j->guru->nip ?? '-');
                        $namaKelas = $j->jadwal->kelas->nama_kelas ?? ($j->kelas->nama_kelas ?? '-');
                        $namaRuangan = $j->jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas';
                        $namaMapel = $j->jadwal->mapel->nama_mapel ?? ($j->mapel->nama_mapel ?? '-');

                        // Format jam & sesi
                        $jamMulaiStr = $j->jadwal->waktu_mulai_effective ?? '07:00';
                        $jamSelesaiStr = $j->jadwal->waktu_selesai_effective ?? '15:00';
                        $jamText = substr($jamMulaiStr, 0, 5) . ' - ' . substr($jamSelesaiStr, 0, 5) . ' WIB';
                        $sesiText = $j->jam_ke ?: ('Jam ke-' . ($j->jadwal->id_jam_mulai ?? 1) . ($j->jadwal->id_jam_selesai && $j->jadwal->id_jam_selesai != $j->jadwal->id_jam_mulai ? ' - ' . $j->jadwal->id_jam_selesai : ''));

                        // Status KBM
                        $stKehadiran = $j->status_kehadiran_guru ?? 'Hadir';
                        $isDigantikan = $j->id_guru_pengganti && $j->guruPengganti;

                        // Perhitungan JP (Durasi Sesi)
                        $mulaiId = $j->jadwal->id_jam_mulai ?? 1;
                        $selesaiId = $j->jadwal->id_jam_selesai ?? $mulaiId;
                        $totalJp = max(1, ($selesaiId - $mulaiId + 1));

                        // Clean Pertemuan (remove redundant 'ke-' or 'Ke-')
                        $pertemuanClean = preg_replace('/^ke[-_\s]*/i', '', trim($j->pertemuan_ke ?? '1'));

                        // Verifikasi Piket
                        $verif = $j->verifikasiPiket;
                        $isVerified = $verif && $verif->status === 'terverifikasi';
                    @endphp
                    <tr>
                        <!-- 1. TANGGAL -->
                        <td>
                            <div class="date-display-block">
                                <span class="date-big-day">{{ $dayNum }}</span>
                                <div class="date-month-year">
                                    <span>{{ $monthStr }}</span>
                                    <span>{{ $yearStr }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- 2. MATA PELAJARAN -->
                        <td>
                            <div class="subject-title-bold">{{ $namaMapel }}</div>
                            <div class="subject-time-sub">{{ $sesiText }} &bull; {{ $jamText }}</div>
                        </td>

                        <!-- 3. KELAS & RUANG -->
                        <td>
                            <div class="class-title-bold">{{ $namaKelas }}</div>
                            <div class="room-sub-tag">
                                <i class="fa-solid fa-location-dot"></i> {{ $namaRuangan }}
                            </div>
                        </td>

                        <!-- 4. GURU PENGAMPU -->
                        <td>
                            <div class="teacher-name-bold">{{ $namaGuru }}</div>
                            <div class="teacher-nip-sub">NIP: {{ $nipGuru }}</div>
                            @if($isDigantikan)
                                <div style="margin-top: 3px;">
                                    <span style="font-size: 10px; background: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px; font-weight: 700;">
                                        Pengganti: {{ $j->guruPengganti->nama_guru }}
                                    </span>
                                </div>
                            @endif
                        </td>

                        <!-- 5. MATERI PEMBELAJARAN -->
                        <td>
                            <div class="materi-title-bold">{{ $j->materi ?: 'Pembelajaran KBM Sesuai Silabus' }}</div>
                            <span class="badge-kondisi-tag">Kondisi: {{ $j->kondisi_kelas ?: 'Kondusif' }}</span>
                        </td>

                        <!-- 6. PERTEMUAN -->
                        <td style="text-align: center;">
                            <div class="pertemuan-val-bold">Ke-{{ $pertemuanClean ?: 1 }}</div>
                            <div class="pertemuan-jp-sub">{{ $totalJp }} JP</div>
                        </td>

                        <!-- 7. STATUS KBM -->
                        <td style="text-align: center;">
                            @if($isDigantikan)
                                <span class="badge-kbm-digantikan">
                                    <i class="fa-solid fa-arrows-rotate"></i> Digantikan
                                </span>
                            @elseif($stKehadiran === 'Hadir')
                                <span class="badge-kbm-terlaksana">
                                    <i class="fa-solid fa-circle-check"></i> Terlaksana
                                </span>
                            @elseif($stKehadiran === 'Izin')
                                <span class="badge-kbm-izin">
                                    <i class="fa-solid fa-clock"></i> Izin
                                </span>
                            @else
                                <span class="badge-kbm-tidak-hadir">
                                    <i class="fa-solid fa-circle-xmark"></i> {{ $stKehadiran }}
                                </span>
                            @endif
                        </td>

                        <!-- 8. VERIFIKASI PIKET (Tanda Tangan & Konfirmasi) -->
                        <td style="text-align: center;">
                            @if($isVerified)
                                <button type="button" class="badge-verif-terverifikasi" onclick="openVerifModal({{ json_encode($verif) }}, '{{ $j->tanggal }}')" title="Klik untuk melihat Tanda Tangan Guru Piket">
                                    <i class="fa-solid fa-signature"></i> Terverifikasi
                                </button>
                            @else
                                <span class="badge-verif-belum" title="Jurnal belum ditandatangani oleh Guru Piket harian">
                                    <i class="fa-solid fa-clock"></i> Belum Verif
                                </span>
                            @endif
                        </td>

                        <!-- 9. AKSI (Detail Modal) -->
                        <td style="text-align: center;">
                            <button type="button" class="btn-eye-action" onclick="openDetailModal({{ json_encode($j) }}, '{{ addslashes($namaGuru) }}', '{{ addslashes($nipGuru) }}', '{{ addslashes($namaKelas) }}', '{{ addslashes($namaRuangan) }}', '{{ addslashes($namaMapel) }}', '{{ addslashes($sesiText) }}', '{{ addslashes($jamText) }}', '{{ $totalJp }} JP', 'Ke-{{ $pertemuanClean ?: 1 }}', {{ json_encode($verif) }})" title="Lihat Detail Jurnal Lengkap">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 36px 20px; color: #94a3b8;">
                            <i class="fa-regular fa-folder-open" style="font-size: 36px; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                            Belum ada data jurnal mengajar guru yang sesuai dengan kriteria filter tanggal atau pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 8px;">
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                Menampilkan {{ $jurnals->firstItem() ?? 0 }} - {{ $jurnals->lastItem() ?? 0 }} dari {{ $jurnals->total() }} data jurnal
            </div>

            @if ($jurnals->hasPages())
                <div class="custom-pagination-wrapper" style="margin-top: 0;">
                    @if ($jurnals->onFirstPage())
                        <span class="page-nav-btn disabled" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $jurnals->previousPageUrl() }}" class="page-nav-btn" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif

                    @php
                        $start = max(1, $jurnals->currentPage() - 2);
                        $end = min($jurnals->lastPage(), $jurnals->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $jurnals->url(1) }}" class="page-num-btn">1</a>
                        @if ($start > 2)
                            <span class="page-nav-btn disabled">&hellip;</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $jurnals->currentPage())
                            <span class="page-num-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $jurnals->url($page) }}" class="page-num-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $jurnals->lastPage())
                        @if ($end < $jurnals->lastPage() - 1)
                            <span class="page-nav-btn disabled">&hellip;</span>
                        @endif
                        <a href="{{ $jurnals->url($jurnals->lastPage()) }}" class="page-num-btn">{{ $jurnals->lastPage() }}</a>
                    @endif

                    @if ($jurnals->hasMorePages())
                        <a href="{{ $jurnals->nextPageUrl() }}" class="page-nav-btn" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span class="page-nav-btn disabled" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>

<!-- MODAL 1: PILIH TANGGAL CETAK REKAP HARIAN -->
<div id="modalSelectDatePrint" class="modal-overlay">
    <div class="modal-card" style="max-width: 640px;">
        <div class="modal-header-styled" style="background: #2b3957;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-calendar-days" style="font-size: 18px;"></i>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Pilih Tanggal Cetak Rekap Harian</h3>
                </div>
            </div>
            <button type="button" onclick="closeSelectDatePrintModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-styled">
            <div style="font-size: 13px; color: #64748b; line-height: 1.5;">
                Pilih salah satu tanggal pelaksanaan KBM berikut yang tercatat pada <strong>Daftar Jurnal Mengajar Guru</strong> untuk mencetak dokumen rekapitulasi harian lengkap dengan tanda tangan pengesahan Guru Piket & Kepala Sekolah.
            </div>

            <!-- Custom Date Picker Form for direct custom print -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <div style="font-size: 12.5px; font-weight: 700; color: #334155;">
                    <i class="fa-regular fa-calendar-plus" style="color: #2563eb; margin-right: 4px;"></i> Atau Pilih Tanggal Lain:
                </div>
                <div style="display: flex; align-items: center; gap: 8px; flex: 1; max-width: 320px; justify-content: flex-end;">
                    <input type="date" id="customPrintDateInput" value="{{ date('Y-m-d') }}" style="padding: 7px 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; font-family: inherit;">
                    <button type="button" onclick="printCustomSelectedDate()" style="background: #2563eb; color: #ffffff; border: none; padding: 8px 14px; border-radius: 10px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                </div>
            </div>

            <!-- List of available dates in Jurnal Mengajar -->
            <div style="display: flex; flex-direction: column; gap: 10px; max-height: 380px; overflow-y: auto; padding-right: 4px;">
                @forelse($availableDates as $ad)
                    @php
                        $tglCarbon = \Carbon\Carbon::parse($ad->tanggal)->locale('id');
                        $hariIndo = [
                            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
                        ];
                        $monthsMap = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $hariTeks = $hariIndo[$tglCarbon->format('l')] ?? 'Senin';
                        $formattedTgl = $hariTeks . ', ' . $tglCarbon->day . ' ' . $monthsMap[$tglCarbon->month] . ' ' . $tglCarbon->year;
                    @endphp
                    <div class="date-pick-item-card">
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $formattedTgl }}</span>
                                <span class="date-badge-pill">{{ $ad->total_sesi }} Sesi KBM</span>
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; display: flex; align-items: center; gap: 8px;">
                                @if($ad->is_verified)
                                    <span style="color: #166534; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-check"></i> Terverifikasi Piket ({{ $ad->nama_guru_piket }})
                                    </span>
                                @else
                                    <span style="color: #b45309; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-clock"></i> Belum Diverifikasi Guru Piket
                                    </span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran.cetak-harian', ['tanggal' => $ad->tanggal]) }}" target="_blank" style="background: #2b3957; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 10px; font-size: 12.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; transition: all 0.2s ease;">
                            <i class="fa-solid fa-print"></i> Cetak Rekap
                        </a>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px; color: #94a3b8;">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                        Belum ada data tanggal jurnal mengajar yang tersimpan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: DETAIL JURNAL MENGAJAR GURU (LENGKAP RINCI) -->
<div id="modalDetailJurnal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-book-bookmark" style="font-size: 18px;"></i>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Rincian Detail Jurnal Mengajar</h3>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-styled">
            <!-- Grid Info Header -->
            <div class="detail-grid-card">
                <div class="detail-item-box">
                    <span class="detail-item-label">Mata Pelajaran:</span>
                    <span class="detail-item-val" id="mdlMapel" style="color: #2563eb;">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Tanggal Pembelajaran:</span>
                    <span class="detail-item-val" id="mdlTanggal">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Kelas & Ruangan:</span>
                    <span class="detail-item-val" id="mdlKelasRuang">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Sesi & Jam Pelajaran:</span>
                    <span class="detail-item-val" id="mdlJam">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Guru Pengajar:</span>
                    <span class="detail-item-val" id="mdlGuru">-</span>
                    <span style="font-size: 11px; color: #64748b;" id="mdlNip">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Pertemuan & Alokasi JP:</span>
                    <span class="detail-item-val" id="mdlPertemuan">-</span>
                </div>
            </div>

            <!-- Guru Pengganti Box (if any) -->
            <div id="mdlGuruPenggantiBox" style="display: none; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px;">
                <div style="font-size: 11px; font-weight: 800; color: #1e40af; text-transform: uppercase;">
                    <i class="fa-solid fa-arrows-rotate"></i> Guru Pengganti (Tugas Inval)
                </div>
                <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mdlGuruPenggantiNama">-</div>
            </div>

            <!-- Materi Pembelajaran -->
            <div>
                <div class="detail-item-label" style="margin-bottom: 4px;">Materi Pembelajaran:</div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; font-size: 13.5px; font-weight: 600; color: #1e293b; line-height: 1.5;" id="mdlMateri">
                    -
                </div>
            </div>

            <!-- Catatan KBM & Kondisi Kelas -->
            <div>
                <div class="detail-item-label" style="margin-bottom: 4px;">Catatan KBM & Kondisi Kelas:</div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; font-size: 13px; color: #475569;" id="mdlCatatan">
                    -
                </div>
            </div>

            <!-- Presensi Siswa & Daftar Ketidakhadiran -->
            <div>
                <div class="detail-item-label" style="margin-bottom: 4px;">Presensi Siswa / Ketidakhadiran:</div>
                <div id="mdlPresensiBox" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                    <div id="mdlPresensiEmpty" style="color: #166534; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-circle-check"></i> Seluruh siswa hadir lengkap pada sesi pembelajaran ini (Nihil).
                    </div>
                    <div id="mdlPresensiListContainer" style="display: none; overflow-x: auto;">
                        <table class="presensi-table-mini">
                            <thead>
                                <tr>
                                    <th style="width: 30px; text-align: center;">No</th>
                                    <th>Nama Siswa</th>
                                    <th style="width: 90px; text-align: center;">Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="mdlPresensiTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Foto Dokumentasi KBM -->
            <div id="mdlDokumentasiBox" style="display: none; flex-direction: column; gap: 6px;">
                <span class="detail-item-label">Foto Dokumentasi KBM:</span>
                <div style="text-align: center; background: #f8fafc; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <img id="mdlFotoImg" src="" alt="Foto KBM" style="max-width: 100%; max-height: 240px; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <!-- Verifikasi & TTD Guru Piket Box inside Detail Modal -->
            <div id="mdlVerifDetailBox" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 14px; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 12px; font-weight: 800; color: #1e3a8a; text-transform: uppercase;">
                        <i class="fa-solid fa-signature"></i> Verifikasi Pengesahan Guru Piket
                    </span>
                    <span id="mdlVerifBadge" style="font-size: 11px; font-weight: 800; padding: 2px 10px; border-radius: 12px;">-</span>
                </div>
                <div id="mdlVerifContent">
                    <div style="font-size: 12.5px; color: #334155; margin-bottom: 4px;" id="mdlVerifPetugas">-</div>
                    <div style="font-size: 11px; color: #64748b; margin-bottom: 8px;" id="mdlVerifWaktu">-</div>
                    <div id="mdlVerifTtdWrapper" style="text-align: center; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; display: none;">
                        <img id="mdlVerifTtdImg" src="" alt="Tanda Tangan Piket" style="max-height: 70px; max-width: 180px; object-fit: contain;">
                    </div>
                </div>
            </div>

            <!-- Full Detail Page Link -->
            <div style="display: flex; justify-content: flex-end; margin-top: 4px;">
                <a id="mdlFullPageBtn" href="#" style="background: #2563eb; color: #ffffff; text-decoration: none; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;">
                    Lihat Halaman Detail Lengkap <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 3: BUKTI VERIFIKASI & TANDA TANGAN GURU PIKET -->
<div id="modalVerifPiket" class="modal-overlay">
    <div class="modal-card" style="max-width: 540px;">
        <div class="modal-header-styled" style="background: #1e3a8a;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-signature" style="font-size: 18px;"></i>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Bukti Pengesahan & Tanda Tangan Guru Piket</h3>
            </div>
            <button type="button" onclick="closeVerifModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-styled">
            <div class="detail-grid-card" style="grid-template-columns: 1fr;">
                <div class="detail-item-box">
                    <span class="detail-item-label">Tanggal Pelaksanaan KBM:</span>
                    <span class="detail-item-val" id="verifTanggal">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Petugas Guru Piket Pengesah:</span>
                    <span class="detail-item-val" id="verifNamaGuru" style="color: #1e3a8a;">-</span>
                    <span style="font-size: 11px; color: #64748b;" id="verifNipGuru">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Waktu Verifikasi:</span>
                    <span class="detail-item-val" id="verifWaktu" style="font-size: 12.5px; color: #475569;">-</span>
                </div>
                <div class="detail-item-box">
                    <span class="detail-item-label">Catatan Pengawasan:</span>
                    <span class="detail-item-val" id="verifCatatan" style="font-size: 13px; font-weight: 600; color: #334155;">-</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 4px;">
                <span class="detail-item-label">Tanda Tangan Digital Guru Piket:</span>
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 16px; text-align: center; min-height: 110px; display: flex; align-items: center; justify-content: center;">
                    <img id="verifTtdImg" src="" alt="Tanda Tangan Digital" style="max-height: 90px; max-width: 220px; object-fit: contain;">
                </div>
                <div style="font-size: 11px; color: #166534; font-weight: 700; text-align: center; margin-top: 4px;">
                    <i class="fa-solid fa-circle-check"></i> Dokumen jurnal harian telah diverifikasi dan disahkan oleh Petugas Piket Sekolah
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openSelectDatePrintModal() {
        document.getElementById('modalSelectDatePrint').style.display = 'flex';
    }

    function closeSelectDatePrintModal() {
        document.getElementById('modalSelectDatePrint').style.display = 'none';
    }

    function printCustomSelectedDate() {
        var inputVal = document.getElementById('customPrintDateInput').value;
        if (!inputVal) {
            alert('Silakan pilih tanggal terlebih dahulu.');
            return;
        }
        var url = "{{ route('kepala-sekolah.jurnal-pembelajaran.cetak-harian') }}?tanggal=" + encodeURIComponent(inputVal);
        window.open(url, '_blank');
        closeSelectDatePrintModal();
    }

    function openDetailModal(jurnal, guru, nip, kelas, ruang, mapel, sesi, jam, jpText, ptmText, verif) {
        document.getElementById('mdlTanggal').textContent = jurnal.tanggal || '-';
        document.getElementById('mdlMapel').textContent = mapel || '-';
        document.getElementById('mdlKelasRuang').textContent = kelas + ' (' + ruang + ')';
        document.getElementById('mdlGuru').textContent = guru || '-';
        document.getElementById('mdlNip').textContent = nip ? ('NIP. ' + nip) : '-';
        document.getElementById('mdlJam').textContent = sesi + ' • ' + jam;
        document.getElementById('mdlPertemuan').textContent = ptmText + ' (' + jpText + ')';
        document.getElementById('mdlMateri').textContent = jurnal.materi || 'Pembelajaran KBM sesuai silabus.';
        document.getElementById('mdlCatatan').textContent = (jurnal.catatan || 'KBM berlangsung tertib dan lancar') + ' [Kondisi: ' + (jurnal.kondisi_kelas || 'Kondusif') + ']';

        // Guru Pengganti
        var gpBox = document.getElementById('mdlGuruPenggantiBox');
        if (jurnal.id_guru_pengganti && jurnal.guru_pengganti) {
            document.getElementById('mdlGuruPenggantiNama').textContent = jurnal.guru_pengganti.nama_guru + ' (NIP. ' + (jurnal.guru_pengganti.nip || '-') + ')';
            gpBox.style.display = 'block';
        } else {
            gpBox.style.display = 'none';
        }

        // Presensi
        var presEmpty = document.getElementById('mdlPresensiEmpty');
        var presListContainer = document.getElementById('mdlPresensiListContainer');
        var presTbody = document.getElementById('mdlPresensiTableBody');
        presTbody.innerHTML = '';

        if (jurnal.detail_ketidakhadiran && jurnal.detail_ketidakhadiran.length > 0) {
            presEmpty.style.display = 'none';
            presListContainer.style.display = 'block';
            jurnal.detail_ketidakhadiran.forEach(function(item, idx) {
                var namaSiswa = item.siswa ? item.siswa.nama_siswa : ('Siswa #' + item.id_siswa);
                var status = item.keterangan || item.status || 'Absen';
                var catatan = item.catatan || item.keterangan || '-';

                var badgeClass = 'background: #fee2e2; color: #dc2626;';
                if (status === 'Sakit') badgeClass = 'background: #fef3c7; color: #b45309;';
                if (status === 'Izin') badgeClass = 'background: #eff6ff; color: #1d4ed8;';
                if (status === 'Dispensasi') badgeClass = 'background: #f3e8ff; color: #7e22ce;';

                var row = '<tr>' +
                    '<td style="text-align: center; font-weight: bold;">' + (idx + 1) + '</td>' +
                    '<td style="font-weight: 700; color: #0f172a;">' + namaSiswa + '</td>' +
                    '<td style="text-align: center;"><span style="padding: 2px 8px; border-radius: 8px; font-size: 11px; font-weight: 800; ' + badgeClass + '">' + status + '</span></td>' +
                    '<td style="color: #64748b;">' + catatan + '</td>' +
                    '</tr>';
                presTbody.innerHTML += row;
            });
        } else {
            presEmpty.style.display = 'flex';
            presListContainer.style.display = 'none';
        }

        // Foto Dokumentasi
        var docBox = document.getElementById('mdlDokumentasiBox');
        var fotoImg = document.getElementById('mdlFotoImg');
        if (jurnal.dokumentasi_url) {
            fotoImg.src = jurnal.dokumentasi_url;
            docBox.style.display = 'flex';
        } else {
            docBox.style.display = 'none';
        }

        // Verifikasi Piket Box
        var verifBadge = document.getElementById('mdlVerifBadge');
        var verifPetugas = document.getElementById('mdlVerifPetugas');
        var verifWaktu = document.getElementById('mdlVerifWaktu');
        var ttdWrap = document.getElementById('mdlVerifTtdWrapper');
        var ttdImg = document.getElementById('mdlVerifTtdImg');

        if (verif && verif.status === 'terverifikasi') {
            verifBadge.textContent = 'Terverifikasi';
            verifBadge.style.background = '#dcfce7';
            verifBadge.style.color = '#166534';
            verifPetugas.innerHTML = 'Petugas Guru Piket: <strong>' + (verif.nama_guru_piket || (verif.guru ? verif.guru.nama_guru : 'Petugas Piket')) + '</strong>';
            verifWaktu.textContent = 'Diverifikasi pada: ' + (verif.waktu_verifikasi ? new Date(verif.waktu_verifikasi).toLocaleString('id-ID') : (verif.created_at || '-'));
            
            if (verif.tanda_tangan) {
                ttdImg.src = verif.tanda_tangan;
                ttdWrap.style.display = 'block';
            } else {
                ttdWrap.style.display = 'none';
            }
        } else {
            verifBadge.textContent = 'Belum Verif';
            verifBadge.style.background = '#f1f5f9';
            verifBadge.style.color = '#64748b';
            verifPetugas.innerHTML = 'Status: <em>Belum ditandatangani oleh Guru Piket harian</em>';
            verifWaktu.textContent = '-';
            ttdWrap.style.display = 'none';
        }

        // Link Full Page
        var fullBtn = document.getElementById('mdlFullPageBtn');
        fullBtn.href = '/kepala-sekolah/jurnal-pembelajaran/' + jurnal.id_jurnal;

        document.getElementById('modalDetailJurnal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailJurnal').style.display = 'none';
    }

    function openVerifModal(verif, tanggal) {
        document.getElementById('verifTanggal').textContent = tanggal || '-';
        document.getElementById('verifNamaGuru').textContent = verif.nama_guru_piket || (verif.guru ? verif.guru.nama_guru : 'Petugas Piket');
        document.getElementById('verifNipGuru').textContent = verif.nip_guru_piket ? ('NIP. ' + verif.nip_guru_piket) : (verif.guru && verif.guru.nip ? ('NIP. ' + verif.guru.nip) : '-');
        document.getElementById('verifWaktu').textContent = verif.waktu_verifikasi ? new Date(verif.waktu_verifikasi).toLocaleString('id-ID') : (verif.created_at || '-');
        document.getElementById('verifCatatan').textContent = verif.catatan || 'Seluruh sesi KBM telah diperiksa, divalidasi, dan disahkan oleh petugas piket.';

        var ttdImg = document.getElementById('verifTtdImg');
        if (verif.tanda_tangan) {
            ttdImg.src = verif.tanda_tangan;
            ttdImg.style.display = 'inline-block';
        } else {
            ttdImg.style.display = 'none';
        }

        document.getElementById('modalVerifPiket').style.display = 'flex';
    }

    function closeVerifModal() {
        document.getElementById('modalVerifPiket').style.display = 'none';
    }

    window.onclick = function(e) {
        var mdlDate = document.getElementById('modalSelectDatePrint');
        var mdlDetail = document.getElementById('modalDetailJurnal');
        var mdlVerif = document.getElementById('modalVerifPiket');
        if (e.target === mdlDate) {
            mdlDate.style.display = 'none';
        }
        if (e.target === mdlDetail) {
            mdlDetail.style.display = 'none';
        }
        if (e.target === mdlVerif) {
            mdlVerif.style.display = 'none';
        }
    };
</script>
@endsection