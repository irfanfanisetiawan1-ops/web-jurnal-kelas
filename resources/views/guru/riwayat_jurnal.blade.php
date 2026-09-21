@extends('layouts.guru')

@section('title', 'Riwayat Jurnal — EDU JOURNAL')
@section('header_title', 'Riwayat Jurnal Mengajar')

@section('styles')
<style>
    /* Color Variables & Base Styles */
    :root {
        --theme-blue: #2563eb;
        --theme-navy: #1e293b;
        --theme-slate: #384972;
        --bg-light-gray: #f8fafc;
        --border-color: #cbd5e1;
    }

    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 4px 0;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }

    /* Metric Summary Cards */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }
    }

    .metric-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 18px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }

    .metric-info h4 {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 6px 0;
    }

    .metric-info .metric-num {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .metric-icon-box {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .scope-pills {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .scope-pill-btn {
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        cursor: pointer;
    }

    .scope-pill-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .scope-pill-btn.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        align-items: flex-end;
    }

    .form-group-filter label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control-filter {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: all 0.15s ease;
    }

    .form-control-filter:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-action {
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.15s ease;
        height: 38px;
    }

    .btn-apply-filter {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-apply-filter:hover {
        background: #1d4ed8;
    }

    .btn-reset-filter {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        text-decoration: none;
    }

    .btn-reset-filter:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Floating Batch Action Toolbar */
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

    /* Main Table Card */
    .card-table {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 3px 12px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f1f5f9;
        padding: 14px 16px;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }

    .table-custom td {
        padding: 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    .table-custom tr.selected-row td {
        background: #f0f9ff;
    }

    /* Checkbox Styling */
    .custom-checkbox {
        width: 17px;
        height: 17px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    /* Badges */
    .badge-status-guru {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 8px;
        text-transform: uppercase;
    }

    .badge-status-hadir {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .badge-status-izin {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .badge-status-sakit {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-status-alpa {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .badge-presensi-siswa {
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-presensi-lengkap {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .badge-presensi-absen {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .btn-action-view {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 6px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .btn-action-view:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-action-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 6px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .btn-action-delete:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Modal Styling */
    .modal-backdrop-custom {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 20px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border: 1px solid #cbd5e1;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-radius: 20px 20px 0 0;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .detail-box-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 4px;
    }

    .detail-box-val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
</style>
@endsection

@section('content')

    <!-- Flash Notification -->
    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 700;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #15803d;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 700;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Page Header & Top Buttons -->
    <div class="page-header-row">
        <div>
            <h1 class="page-title">
                <i class="fa-solid fa-book-bookmark" style="color: #2563eb;"></i>
                Riwayat Jurnal Mengajar
            </h1>
            <p class="page-subtitle">
                Arsip dan dokumentasi pelaksanaan kegiatan belajar mengajar (KBM) serta rekap presensi kelas
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('guru.riwayat-jurnal.trash') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.15s ease;">
                <i class="fa-solid fa-trash-can" style="color: #dc2626;"></i> Sampah
                @if($trashedCount > 0)
                    <span style="background: #dc2626; color: #ffffff; padding: 2px 7px; border-radius: 10px; font-size: 11px;">{{ $trashedCount }}</span>
                @endif
            </a>
            <a href="{{ route('guru.jurnal-harian') }}" style="background: #2563eb; color: #ffffff; padding: 9px 18px; border-radius: 10px; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);">
                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Harian
            </a>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Jurnal</h4>
                <div class="metric-num">{{ $totalJurnalCount }}</div>
            </div>
            <div class="metric-icon-box" style="background: #eff6ff; color: #2563eb;">
                <i class="fa-solid fa-book-open"></i>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h4>Kehadiran Guru (Hadir)</h4>
                <div class="metric-num">{{ $hadirGuruCount }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">({{ $totalJurnalCount > 0 ? round(($hadirGuruCount / $totalJurnalCount) * 100, 1) : 0 }}%)</span></div>
            </div>
            <div class="metric-icon-box" style="background: #f0fdf4; color: #16a34a;">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h4>Jurnal Bulan Ini</h4>
                <div class="metric-num">{{ $jurnalBulanIniCount }}</div>
            </div>
            <div class="metric-icon-box" style="background: #fdf4ff; color: #a855f7;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h4>Item di Sampah</h4>
                <div class="metric-num">{{ $trashedCount }}</div>
            </div>
            <div class="metric-icon-box" style="background: #fef2f2; color: #dc2626;">
                <i class="fa-solid fa-trash-arrow-up"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="filter-card">
        @if($isWaliKelas && $kelasWali)
            @php $currentScope = request('scope', 'all'); @endphp
            <div class="scope-pills">
                <a href="{{ route('guru.riwayat-jurnal', array_merge(request()->except('scope'), ['scope' => 'all'])) }}" class="scope-pill-btn {{ $currentScope === 'all' ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Semua Jurnal Terkait
                </a>
                <a href="{{ route('guru.riwayat-jurnal', array_merge(request()->except('scope'), ['scope' => 'saya'])) }}" class="scope-pill-btn {{ $currentScope === 'saya' ? 'active' : '' }}">
                    <i class="fa-solid fa-person-chalkboard"></i> Jurnal Mengajar Saya
                </a>
                <a href="{{ route('guru.riwayat-jurnal', array_merge(request()->except('scope'), ['scope' => 'wali'])) }}" class="scope-pill-btn {{ $currentScope === 'wali' ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i> Jurnal Kelas Perwalian ({{ $kelasWali->nama_kelas }})
                </a>
            </div>
        @endif

        <form method="GET" action="{{ route('guru.riwayat-jurnal') }}">
            @if(request('scope'))
                <input type="hidden" name="scope" value="{{ request('scope') }}">
            @endif

            <div class="filter-grid">
                <!-- Search Keyword -->
                <div class="form-group-filter" style="grid-column: span 2;">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari Materi / Guru / Catatan:</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci pencarian..." class="form-control-filter">
                </div>

                <!-- Kelas Filter -->
                <div class="form-group-filter">
                    <label><i class="fa-solid fa-school"></i> Kelas:</label>
                    <select name="id_kelas" class="form-control-filter">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelases as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ request('id_kelas') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mapel Filter -->
                <div class="form-group-filter">
                    <label><i class="fa-solid fa-book"></i> Mata Pelajaran:</label>
                    <select name="id_mapel" class="form-control-filter">
                        <option value="">-- Semua Mapel --</option>
                        @foreach($mapels as $mpl)
                            <option value="{{ $mpl->id_mapel }}" {{ request('id_mapel') == $mpl->id_mapel ? 'selected' : '' }}>
                                {{ $mpl->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Guru Filter -->
                <div class="form-group-filter">
                    <label><i class="fa-solid fa-user-tag"></i> Status Guru:</label>
                    <select name="status_kehadiran" class="form-control-filter">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" {{ request('status_kehadiran') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ request('status_kehadiran') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ request('status_kehadiran') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Tanpa Keterangan" {{ request('status_kehadiran') == 'Tanpa Keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                    </select>
                </div>

                <!-- Tanggal Dari & Sampai -->
                <div class="form-group-filter">
                    <label><i class="fa-solid fa-calendar-day"></i> Dari Tanggal:</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-control-filter">
                </div>

                <div class="form-group-filter">
                    <label><i class="fa-solid fa-calendar-day"></i> Sampai Tanggal:</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control-filter">
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter-action btn-apply-filter" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-filter-action btn-reset-filter" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Table Card -->
    <div class="card-table">
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox" title="Pilih Semua">
                        </th>
                        <th style="width: 45px; text-align: center;">NO</th>
                        <th style="width: 130px;">TANGGAL & HARI</th>
                        <th style="width: 140px;">KELAS & RUANG</th>
                        <th style="width: 180px;">MAPEL & PERTEMUAN</th>
                        <th>MATERI PEMBELAJARAN</th>
                        <th style="width: 130px;">STATUS GURU</th>
                        <th style="width: 140px;">PRESENSI SISWA</th>
                        <th style="width: 90px; text-align: center;">LAMPIRAN</th>
                        <th style="width: 130px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $idx => $j)
                        @php
                            $carbonDate = \Carbon\Carbon::parse($j->tanggal);
                            $daysInIndo = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                            $namaHari = $daysInIndo[$carbonDate->format('l')] ?? '';
                            
                            $kelasNama = $j->jadwal && $j->jadwal->kelas ? $j->jadwal->kelas->nama_kelas : '-';
                            $ruangNama = $j->jadwal && $j->jadwal->ruangan ? $j->jadwal->ruangan->nama_ruangan : '';
                            $mapelNama = $j->jadwal && $j->jadwal->mapel ? $j->jadwal->mapel->nama_mapel : '-';
                            $guruNama  = $j->jadwal && $j->jadwal->guru ? $j->jadwal->guru->nama_guru : '-';
                            $penggantiNama = $j->guruPengganti ? $j->guruPengganti->nama_guru : null;
                            
                            $absenDetails = $j->detailKetidakhadiran;
                            $absenCount = $absenDetails->count();

                            // JSON encoded for modal detail
                            $detailPayload = [
                                'id_jurnal' => $j->id_jurnal,
                                'tanggal'   => $carbonDate->format('d F Y'),
                                'hari'      => $namaHari,
                                'kelas'     => $kelasNama,
                                'ruangan'   => $ruangNama ?: '-',
                                'mapel'     => $mapelNama,
                                'guru'      => $guruNama,
                                'guru_pengganti' => $penggantiNama,
                                'pertemuan_ke'   => $j->pertemuan_ke ?: '1',
                                'jam_ke'         => $j->jam_ke ?: '-',
                                'status_guru'    => $j->status_kehadiran_guru,
                                'kondisi_kelas'  => $j->kondisi_kelas ?: 'Kondusif',
                                'materi'         => $j->materi ?: '-',
                                'catatan'        => $j->catatan ?: '-',
                                'dokumentasi'    => $j->dokumentasi_url,
                                'absen_list'     => $absenDetails->map(function($d) {
                                    return [
                                        'nama'       => $d->siswa ? $d->siswa->nama_siswa : 'Siswa',
                                        'nisn'       => $d->siswa ? $d->siswa->nisn : '-',
                                        'keterangan' => $d->keterangan,
                                    ];
                                }),
                            ];
                        @endphp
                        <tr id="row_{{ $j->id_jurnal }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="row-checkbox custom-checkbox" value="{{ $j->id_jurnal }}" onchange="handleRowCheckboxChange(this)">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $idx + 1 }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $carbonDate->format('d/m/Y') }}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $namaHari }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #1e293b;">{{ $kelasNama }}</div>
                                @if($ruangNama)
                                    <div style="font-size: 11px; color: #0284c7; background: #e0f2fe; display: inline-block; padding: 1px 6px; border-radius: 4px; margin-top: 3px; font-weight: 700;">
                                        {{ $ruangNama }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $mapelNama }}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Pertemuan Ke-{{ $j->pertemuan_ke ?: '1' }}
                                </div>
                            </td>
                            <td>
                                <div style="line-height: 1.5; font-weight: 600; color: #1e293b; max-width: 320px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $j->materi }}">
                                    {{ $j->materi ?: '-' }}
                                </div>
                            </td>
                            <td>
                                @php $stGuru = $j->status_kehadiran_guru; @endphp
                                @if($stGuru === 'Hadir')
                                    <span class="badge-status-guru badge-status-hadir"><i class="fa-solid fa-check"></i> Hadir</span>
                                @elseif($stGuru === 'Izin')
                                    <span class="badge-status-guru badge-status-izin"><i class="fa-solid fa-envelope"></i> Izin</span>
                                @elseif($stGuru === 'Sakit')
                                    <span class="badge-status-guru badge-status-sakit"><i class="fa-solid fa-hospital"></i> Sakit</span>
                                @else
                                    <span class="badge-status-guru badge-status-alpa"><i class="fa-solid fa-circle-xmark"></i> {{ $stGuru }}</span>
                                @endif
                            </td>
                            <td>
                                @if($absenCount === 0)
                                    <span class="badge-presensi-siswa badge-presensi-lengkap">
                                        <i class="fa-solid fa-users"></i> Lengkap (100%)
                                    </span>
                                @else
                                    <span class="badge-presensi-siswa badge-presensi-absen" title="{{ $absenCount }} siswa tidak hadir">
                                        <i class="fa-solid fa-user-xmark"></i> {{ $absenCount }} Absen
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if($j->dokumentasi_url)
                                    <a href="{{ $j->dokumentasi_url }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;" title="Lihat Foto Lampiran">
                                        <i class="fa-solid fa-image"></i>
                                    </a>
                                @else
                                    <span style="color: #94a3b8;">-</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <button type="button" class="btn-action-view" onclick="showDetailModal({{ json_encode($detailPayload) }})" title="Lihat Detail Lengkap">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    <button type="button" class="btn-action-delete" onclick="openSingleDeleteModal({{ $j->id_jurnal }}, '{{ $carbonDate->format('d/m/Y') }}', '{{ $kelasNama }}', '{{ addslashes($mapelNama) }}')" title="Pindahkan ke Sampah">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 48px 20px;">
                                <div style="color: #94a3b8; margin-bottom: 12px;">
                                    <i class="fa-solid fa-book-open" style="font-size: 42px; color: #cbd5e1;"></i>
                                </div>
                                <div style="font-size: 16px; font-weight: 800; color: #334155;">Tidak Ada Riwayat Jurnal</div>
                                <div style="font-size: 13px; color: #64748b; margin-top: 4px; max-width: 400px; margin-left: auto; margin-right: auto;">
                                    Belum ada catatan jurnal mengajar yang sesuai dengan filter atau kata kunci pencarian Anda.
                                </div>
                                <div style="margin-top: 16px;">
                                    <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-filter-action btn-reset-filter" style="display: inline-flex;">
                                        <i class="fa-solid fa-rotate-left"></i> Bersihkan Filter
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal 1: Detail Jurnal Lengkap -->
    <div class="modal-backdrop-custom" id="modalDetailJurnal" onclick="if(event.target === this) closeDetailModal()">
        <div class="modal-box-custom">
            <div class="modal-header-custom">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 20px; color: #2563eb;"></i>
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Detail Riwayat Jurnal Mengajar</h3>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background: none; border: none; color: #64748b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <div class="detail-grid">
                    <div class="detail-box">
                        <div class="detail-box-label">Tanggal & Hari</div>
                        <div class="detail-box-val" id="detTanggalHari">-</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-label">Kelas & Ruangan</div>
                        <div class="detail-box-val" id="detKelasRuangan">-</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-label">Mata Pelajaran</div>
                        <div class="detail-box-val" id="detMapel">-</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-label">Pertemuan & Jam Ke</div>
                        <div class="detail-box-val" id="detPertemuanJam">-</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-label">Guru Pengajar</div>
                        <div class="detail-box-val" id="detGuru">-</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-label">Status Kehadiran & Kondisi Kelas</div>
                        <div class="detail-box-val" id="detStatusKondisi">-</div>
                    </div>
                </div>

                <!-- Materi Pembelajaran -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                    <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">
                        <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i> Materi yang Diajarkan
                    </div>
                    <div id="detMateri" style="font-size: 13.5px; color: #1e293b; line-height: 1.6; font-weight: 600;">-</div>
                </div>

                <!-- Catatan Kelas -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                    <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">
                        <i class="fa-solid fa-comment-dots" style="color: #2563eb;"></i> Catatan Kelas / Aktivitas Pembelajaran
                    </div>
                    <div id="detCatatan" style="font-size: 13px; color: #475569; line-height: 1.5;">-</div>
                </div>

                <!-- Foto Dokumentasi -->
                <div id="detDokumentasiWrapper" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                    <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 8px;">
                        <i class="fa-solid fa-camera" style="color: #2563eb;"></i> Foto Dokumentasi KBM
                    </div>
                    <div style="text-align: center;">
                        <img id="detDokumentasiImg" src="" alt="Dokumentasi KBM" style="max-width: 100%; max-height: 260px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: contain;">
                    </div>
                </div>

                <!-- Rekap Ketidakhadiran Siswa -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
                    <div style="font-size: 12.5px; font-weight: 800; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-user-xmark" style="color: #ea580c; margin-right: 6px;"></i> Rekap Ketidakhadiran Siswa</span>
                        <span id="detAbsenBadge" style="font-size: 11px; padding: 2px 8px; border-radius: 6px; font-weight: 700;">-</span>
                    </div>
                    <div id="detAbsenListContainer">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" onclick="closeDetailModal()" class="btn-filter-action btn-reset-filter">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Single Delete Confirmation -->
    <div class="modal-backdrop-custom" id="modalSingleDelete" onclick="if(event.target === this) closeSingleDeleteModal()">
        <div class="modal-box-custom" style="max-width: 460px;">
            <div class="modal-header-custom" style="background: #fef2f2; border-color: #fee2e2;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-trash-can" style="font-size: 18px; color: #dc2626;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #991b1b; margin: 0;">Pindahkan ke Sampah?</h3>
                </div>
                <button type="button" onclick="closeSingleDeleteModal()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px; line-height: 1.5;">
                    Apakah Anda yakin ingin menghapus data jurnal mengajar berikut ke <strong>Sampah</strong>?
                </p>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; font-size: 13px;">
                    <div><strong>Tanggal:</strong> <span id="delSingleTgl">-</span></div>
                    <div><strong>Kelas:</strong> <span id="delSingleKelas">-</span></div>
                    <div><strong>Mapel:</strong> <span id="delSingleMapel">-</span></div>
                </div>
                <p style="font-size: 12px; color: #64748b; margin-top: 12px; margin-bottom: 0;">
                    <i class="fa-solid fa-info-circle"></i> Data yang dipindahkan ke sampah masih dapat dipulihkan kembali sewaktu-waktu.
                </p>
            </div>
            <div class="modal-footer-custom">
                <form id="formSingleDelete" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeSingleDeleteModal()" class="btn-filter-action btn-reset-filter">
                        Batal
                    </button>
                    <button type="submit" class="btn-filter-action" style="background: #dc2626; color: #ffffff;">
                        <i class="fa-solid fa-trash-can"></i> Ya, Pindahkan ke Sampah
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 3: Batch Delete Confirmation -->
    <div class="modal-backdrop-custom" id="modalBatchDelete" onclick="if(event.target === this) closeBatchDeleteModal()">
        <div class="modal-box-custom" style="max-width: 480px;">
            <div class="modal-header-custom" style="background: #fef2f2; border-color: #fee2e2;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-trash-can" style="font-size: 18px; color: #dc2626;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #991b1b; margin: 0;">Hapus Banyak Data Terpilih?</h3>
                </div>
                <button type="button" onclick="closeBatchDeleteModal()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px; line-height: 1.5;">
                    Anda telah memilih <strong id="delBatchCountText" style="color: #dc2626;">0</strong> data jurnal mengajar. Apakah Anda yakin ingin memindahkan seluruh data terpilih ini ke <strong>Sampah</strong>?
                </p>
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 14px; font-size: 12.5px; color: #92400e;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 4px;"></i> Data akan dipindahkan secara aman (soft delete) dan dapat dipulihkan kapan saja melalui menu Sampah.
                </div>
            </div>
            <div class="modal-footer-custom">
                <form id="formBatchDelete" method="POST" action="{{ route('guru.riwayat-jurnal.destroy-batch') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="delBatchIdsInput" value="">
                    <button type="button" onclick="closeBatchDeleteModal()" class="btn-filter-action btn-reset-filter">
                        Batal
                    </button>
                    <button type="submit" class="btn-filter-action" style="background: #dc2626; color: #ffffff;">
                        <i class="fa-solid fa-trash-can"></i> Ya, Hapus Semua Terpilih
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Batch Action Toolbar -->
    <div id="floatingBatchBar" class="floating-batch-bar">
        <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <span id="selectedCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px; font-weight: 800;">0</span>
            <span>Jurnal Mengajar Terpilih</span>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" onclick="openBatchDeleteModal()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
            </button>
            <button type="button" onclick="uncheckAllRows()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
                Batal
            </button>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // 1. Checkbox Select All & Floating Batch Bar Logic
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const floatingBatchBar = document.getElementById('floatingBatchBar');
    const selectedCountBadge = document.getElementById('selectedCountBadge');

    function updateBatchBar() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;

        if (selectedCountBadge) {
            selectedCountBadge.textContent = count;
        }

        if (count > 0) {
            if (floatingBatchBar) floatingBatchBar.classList.add('show');
        } else {
            if (floatingBatchBar) floatingBatchBar.classList.remove('show');
        }

        // Update row highlight
        rowCheckboxes.forEach(cb => {
            const tr = document.getElementById('row_' + cb.value);
            if (tr) {
                if (cb.checked) tr.classList.add('selected-row');
                else tr.classList.remove('selected-row');
            }
        });

        // Update select all state
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (count === rowCheckboxes.length && rowCheckboxes.length > 0);
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            rowCheckboxes.forEach(cb => {
                cb.checked = isChecked;
            });
            updateBatchBar();
        });
    }

    function handleRowCheckboxChange(elem) {
        updateBatchBar();
    }

    function uncheckAllRows() {
        if (selectAllCheckbox) selectAllCheckbox.checked = false;
        rowCheckboxes.forEach(cb => cb.checked = false);
        updateBatchBar();
    }

    // 2. Detail Modal Logic
    const modalDetail = document.getElementById('modalDetailJurnal');

    function showDetailModal(data) {
        document.getElementById('detTanggalHari').textContent = data.hari + ', ' + data.tanggal;
        document.getElementById('detKelasRuangan').textContent = data.kelas + (data.ruangan !== '-' ? ' (Ruang ' + data.ruangan + ')' : '');
        document.getElementById('detMapel').textContent = data.mapel;
        document.getElementById('detPertemuanJam').textContent = 'Pertemuan Ke-' + data.pertemuan_ke + (data.jam_ke !== '-' ? ' • Jam Ke-' + data.jam_ke : '');
        
        let guruStr = data.guru;
        if (data.guru_pengganti) {
            guruStr += ' (Digantikan oleh: ' + data.guru_pengganti + ')';
        }
        document.getElementById('detGuru').textContent = guruStr;
        document.getElementById('detStatusKondisi').textContent = data.status_guru + ' • Kondisi: ' + data.kondisi_kelas;
        document.getElementById('detMateri').textContent = data.materi;
        document.getElementById('detCatatan').textContent = data.catatan;

        // Foto Dokumentasi
        const dokWrapper = document.getElementById('detDokumentasiWrapper');
        const dokImg = document.getElementById('detDokumentasiImg');
        if (data.dokumentasi) {
            dokImg.src = data.dokumentasi;
            dokWrapper.style.display = 'block';
        } else {
            dokImg.src = '';
            dokWrapper.style.display = 'none';
        }

        // Ketidakhadiran list
        const absenContainer = document.getElementById('detAbsenListContainer');
        const absenBadge = document.getElementById('detAbsenBadge');
        absenContainer.innerHTML = '';

        if (data.absen_list && data.absen_list.length > 0) {
            absenBadge.textContent = data.absen_list.length + ' Siswa Tidak Hadir';
            absenBadge.style.background = '#fef3c7';
            absenBadge.style.color = '#92400e';

            let tableHtml = '<table style="width: 100%; border-collapse: collapse; font-size: 12.5px;">';
            tableHtml += '<tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;"><th style="padding: 6px 10px; text-align: left;">Nama Siswa</th><th style="padding: 6px 10px; text-align: left;">NISN</th><th style="padding: 6px 10px; text-align: center;">Keterangan</th></tr>';

            data.absen_list.forEach(s => {
                let badgeClass = 'background: #e0f2fe; color: #0369a1;';
                if (s.keterangan === 'Sakit') badgeClass = 'background: #fef3c7; color: #92400e;';
                else if (s.keterangan === 'Alpa') badgeClass = 'background: #fee2e2; color: #991b1b;';
                else if (s.keterangan.includes('Dispen')) badgeClass = 'background: #f1f5f9; color: #334155;';

                tableHtml += '<tr style="border-bottom: 1px solid #f1f5f9;">' +
                    '<td style="padding: 8px 10px; font-weight: 700; color: #1e293b;">' + s.nama + '</td>' +
                    '<td style="padding: 8px 10px; color: #64748b;">' + (s.nisn || '-') + '</td>' +
                    '<td style="padding: 8px 10px; text-align: center;"><span style="font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 4px; ' + badgeClass + '">' + s.keterangan + '</span></td>' +
                '</tr>';
            });
            tableHtml += '</table>';
            absenContainer.innerHTML = tableHtml;
        } else {
            absenBadge.textContent = 'Semua Hadir (100%)';
            absenBadge.style.background = '#dcfce7';
            absenBadge.style.color = '#15803d';

            absenContainer.innerHTML = '<div style="font-size: 13px; color: #15803d; padding: 8px 0; display: flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-check"></i> Seluruh siswa di kelas ini hadir lengkap pada sesi pertemuan KBM ini.</div>';
        }

        modalDetail.style.display = 'flex';
    }

    function closeDetailModal() {
        modalDetail.style.display = 'none';
    }

    // 3. Single Delete Modal
    const modalSingleDelete = document.getElementById('modalSingleDelete');
    const formSingleDelete = document.getElementById('formSingleDelete');

    function openSingleDeleteModal(id, tanggal, kelas, mapel) {
        document.getElementById('delSingleTgl').textContent = tanggal;
        document.getElementById('delSingleKelas').textContent = kelas;
        document.getElementById('delSingleMapel').textContent = mapel;
        formSingleDelete.action = "{{ url('/guru-riwayat-jurnal') }}/" + id;
        modalSingleDelete.style.display = 'flex';
    }

    function closeSingleDeleteModal() {
        modalSingleDelete.style.display = 'none';
    }

    // 4. Batch Delete Modal
    const modalBatchDelete = document.getElementById('modalBatchDelete');

    function openBatchDeleteModal() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        document.getElementById('delBatchCountText').textContent = ids.length;
        document.getElementById('delBatchIdsInput').value = ids.join(',');
        modalBatchDelete.style.display = 'flex';
    }

    function closeBatchDeleteModal() {
        modalBatchDelete.style.display = 'none';
    }

    // Keyboard ESC listener to close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailModal();
            closeSingleDeleteModal();
            closeBatchDeleteModal();
        }
    });
</script>
@endsection

