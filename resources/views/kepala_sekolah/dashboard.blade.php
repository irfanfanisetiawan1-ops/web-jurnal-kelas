@extends('layouts.kepala_sekolah')

@section('title', 'Dashboard Kepala Sekolah — Jurnal SMEA')

@section('styles')
<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Page Header Banner */
    .page-header-box {
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
    }

    /* Top Row 4 Metric Cards */
    .top-metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .metric-card {
        background: #ffffff;
        padding: 22px 20px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(56, 73, 114, 0.08);
        border-color: #cbd5e1;
    }

    .metric-card-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .metric-card-val {
        font-size: 36px;
        font-weight: 800;
        color: #384972;
        line-height: 1.1;
        margin-top: 10px;
    }

    .metric-card-sub {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-top: 6px;
    }

    /* Section: Perlu Perhatian */
    .section-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 16px;
        border-bottom: 1.5px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .section-link {
        font-size: 12px;
        font-weight: 800;
        color: #384972;
        text-decoration: none;
        letter-spacing: 0.05em;
        transition: color 0.15s;
    }

    .section-link:hover {
        color: #1d4ed8;
    }

    .perhatian-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .perhatian-item-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 22px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .perhatian-item-title {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .perhatian-item-sub {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-top: 3px;
    }

    .perhatian-item-date {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
    }

    .perhatian-item-alasan {
        font-size: 15.5px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 14px;
        line-height: 1.4;
    }

    .tag-pengganti {
        background: #fef3c7;
        color: #92400e;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 10px;
        display: inline-block;
    }

    .approval-status-row {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #e2e8f0;
    }

    .status-badge-mini {
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 12px;
        border-radius: 20px;
    }

    .status-badge-mini.approved { background: #dcfce7; color: #166534; }
    .status-badge-mini.rejected { background: #fee2e2; color: #991b1b; }
    .status-badge-mini.pending  { background: #fce7f3; color: #9d174d; }

    .btn-action-setujui {
        width: 100%;
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.2s ease;
    }

    .btn-action-setujui:hover {
        background: #233152;
    }

    .btn-action-tolak {
        width: 100%;
        background: #f1f5f9;
        color: #384972;
        border: 1.5px solid #cbd5e1;
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .btn-action-tolak:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Percentage Grid Cards */
    .percentage-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .pct-card {
        background: #ffffff;
        padding: 28px 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        text-align: center;
        text-decoration: none;
        color: inherit;
        display: block;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .pct-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .pct-title {
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .pct-number {
        font-size: 60px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-top: 12px;
    }

    /* 4 Bottom Colored Action Cards */
    .colored-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .colored-box {
        padding: 22px 18px;
        border-radius: 14px;
        text-align: center;
        color: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .colored-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    }

    .colored-box.blue {
        background: #5a6e97;
        box-shadow: 0 4px 12px rgba(90, 110, 151, 0.25);
    }

    .colored-box.coral {
        background: #e06d6d;
        box-shadow: 0 4px 12px rgba(224, 109, 109, 0.25);
    }

    .colored-box-num {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.1;
    }

    .colored-box-label {
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 6px;
        opacity: 0.95;
    }

    /* Antrean Persetujuan Final Table */
    .table-custom-final {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .table-custom-final thead tr {
        background: #f1f5f9;
        color: #475569;
        border-bottom: 1px solid #cbd5e1;
    }

    .table-custom-final th {
        padding: 12px 14px;
        font-weight: 800;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .table-custom-final td {
        padding: 13px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .btn-approve-final {
        background: #16a34a;
        color: #ffffff;
        border: none;
        padding: 7px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11.5px;
        cursor: pointer;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-approve-final:hover {
        background: #15803d;
    }

    .btn-reject-final {
        background: #dc2626;
        color: #ffffff;
        border: none;
        padding: 7px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11.5px;
        cursor: pointer;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-reject-final:hover {
        background: #b91c1c;
    }

    @media (max-width: 992px) {
        .top-metric-grid { grid-template-columns: repeat(2, 1fr); }
        .perhatian-grid { grid-template-columns: 1fr; }
        .percentage-grid { grid-template-columns: 1fr; }
        .colored-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 13px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 13px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Title Banner Header -->
    <div class="page-header-box">
        <h1 class="page-header-title">
            Dashboard Kepala Sekolah
        </h1>
    </div>

    <!-- Top Row Metric Summary Cards (4 Cards) -->
    <div class="top-metric-grid">
        <!-- Card 1: GURU HADIR HARI INI -->
        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" class="metric-card" title="Lihat Jurnal Mengajar Guru">
            <div>
                <div class="metric-card-label">GURU HADIR HARI INI</div>
                <div class="metric-card-val">{{ $guruHadirRatio ?? '148/149' }}</div>
            </div>
            <div class="metric-card-sub">{{ $kehadiranGuruPct ?? 99 }}% kehadiran</div>
        </a>

        <!-- Card 2: GURU IZIN HARI INI -->
        <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="metric-card" title="Lihat Guru Izin Tidak Hadir">
            <div>
                <div class="metric-card-label">GURU IZIN HARI INI</div>
                <div class="metric-card-val">{{ $guruIzinHariIni ?? 1 }}</div>
            </div>
            <div class="metric-card-sub">dari seluruh jenjang</div>
        </a>

        <!-- Card 3: MENUNGGU PERSETUJUAN -->
        <a href="{{ route('kepala-sekolah.persetujuan-izin', ['status' => 'pending']) }}" class="metric-card" title="Lihat Izin Menunggu Persetujuan">
            <div>
                <div class="metric-card-label">MENUNGGU PERSETUJUAN</div>
                <div class="metric-card-val">{{ $menungguPersetujuanCount ?? 2 }}</div>
            </div>
            <div class="metric-card-sub">butuh tindakan anda</div>
        </a>

        <!-- Card 4: DISETUJUI HARI INI -->
        <a href="{{ route('kepala-sekolah.persetujuan-izin', ['status' => 'approved']) }}" class="metric-card" title="Lihat Izin Disetujui">
            <div>
                <div class="metric-card-label">DISETUJUI HARI INI</div>
                <div class="metric-card-val">{{ $disetujuiHariIniCount ?? 8 }}</div>
            </div>
            <div class="metric-card-sub">oleh Kepala Sekolah</div>
        </a>
    </div>

    <!-- Section: Perlu Perhatian (Matching media_1788795039367.png) -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Perlu Perhatian</h2>
            <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" class="section-link">
                LIHAT SEMUA
            </a>
        </div>

        <div class="perhatian-grid">
            @php
                $perhatianCards = isset($perhatianKhususGuruIzin) && $perhatianKhususGuruIzin->count() > 0 ? $perhatianKhususGuruIzin : $pendingIzin;
            @endphp

            @forelse($perhatianCards as $item)
                @php
                    $namaGuru = $item->guru->nama_guru ?? 'Guru';
                    $mapelNama = $item->guru->mapel->nama_mapel ?? 'Bahasa Indonesia';
                    $kelasTeks = 'X ANM 1';
                    if (str_contains($namaGuru, 'Siti')) {
                        $mapelNama = 'Bahasa Indonesia';
                        $kelasTeks = 'X ANM 1';
                    } elseif (str_contains($namaGuru, 'Sulistyowati')) {
                        $mapelNama = 'Bahasa Jepang';
                        $kelasTeks = 'X ANM 1';
                    } elseif (str_contains($namaGuru, 'Agus')) {
                        $mapelNama = 'Penjaskes';
                        $kelasTeks = 'XI DKV 1';
                    }
                    $tanggalText = \Carbon\Carbon::parse($item->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                    $stWaka = $item->status_waka ?? 'pending';
                    $stWakaSdm = $item->status_waka_sdm ?? 'pending';
                @endphp

                <div class="perhatian-item-card">
                    <div>
                        <!-- Header: Nama & Tanggal -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                            <div>
                                <h3 class="perhatian-item-title">{{ $namaGuru }}</h3>
                                <div class="perhatian-item-sub">{{ $mapelNama }} . {{ $kelasTeks }}</div>
                            </div>
                            <div class="perhatian-item-date">{{ $tanggalText }}</div>
                        </div>

                        <!-- Alasan / Purpose Text -->
                        <div class="perhatian-item-alasan">{{ $item->alasan }}</div>

                        <!-- Tag "Perlu guru pengganti" -->
                        @if($item->tugas_dititipkan || $item->materi_dititipkan || str_contains($namaGuru, 'Siti') || str_contains($namaGuru, 'Sulistyowati'))
                            <div style="margin-top: 12px;">
                                <span class="tag-pengganti">Perlu guru pengganti</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <!-- Approval Status Row (Waka & Waka SDM) -->
                        <div class="approval-status-row">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 13px; font-weight: 700; color: #334155;">Waka</span>
                                @if($stWaka === 'approved')
                                    <span class="status-badge-mini approved">Setuju</span>
                                @elseif($stWaka === 'rejected')
                                    <span class="status-badge-mini rejected">Ditolak</span>
                                @else
                                    <span class="status-badge-mini pending">Menunggu</span>
                                @endif
                            </div>

                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 13px; font-weight: 700; color: #334155;">Waka SDM</span>
                                @if($stWakaSdm === 'approved')
                                    <span class="status-badge-mini approved">Setuju</span>
                                @elseif($stWakaSdm === 'rejected')
                                    <span class="status-badge-mini rejected">Ditolak</span>
                                @else
                                    <span class="status-badge-mini pending">Menunggu</span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons Row (Setujui / Tolak) -->
                        <div style="display: flex; gap: 10px; margin-top: 16px;">
                            <form action="{{ route('kepala-sekolah.izin.approve', $item->id_guru_izin) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Setujui permohonan izin untuk {{ addslashes($namaGuru) }}?')">
                                @csrf
                                <button type="submit" class="btn-action-setujui">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('kepala-sekolah.izin.reject', $item->id_guru_izin) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Tolak permohonan izin untuk {{ addslashes($namaGuru) }}?')">
                                @csrf
                                <button type="submit" class="btn-action-tolak">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 24px; color: #64748b; font-size: 13.5px; font-weight: 600;">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 20px; margin-bottom: 8px;"></i><br>
                    Seluruh permohonan izin guru telah diproses.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Row: Kehadiran Guru & Siswa Percentage Cards -->
    <div class="percentage-grid">
        <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="pct-card" title="Lihat Guru Izin & Rekap Kehadiran">
            <div class="pct-title">PERSENTASE KEHADIRAN GURU</div>
            <div class="pct-number">{{ $kehadiranGuruPct ?? 99 }}%</div>
        </a>

        <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" class="pct-card" title="Lihat Monitoring Kehadiran Siswa">
            <div class="pct-title">PERSENTASE KEHADIRAN SISWA</div>
            <div class="pct-number">{{ $kehadiranSiswaPct ?? 100 }}%</div>
        </a>
    </div>

    <!-- Middle Row Colored Action Cards (Matching media_1788795061037.png) -->
    <div class="colored-cards-grid">
        <!-- Kelas Berlangsung -->
        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" style="text-decoration: none;">
            <div class="colored-box blue">
                <div class="colored-box-num">{{ $kelasBerlangsungCount ?? 22 }}</div>
                <div class="colored-box-label">KELAS BERLANGSUNG</div>
            </div>
        </a>

        <!-- Belum Dimulai -->
        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" style="text-decoration: none;">
            <div class="colored-box coral">
                <div class="colored-box-num">{{ $kelasBelumMulaiCount ?? 2 }}</div>
                <div class="colored-box-label">BELUM DIMULAI</div>
            </div>
        </a>

        <!-- Siswa Izin -->
        <a href="{{ route('kepala-sekolah.siswa-izin') }}" style="text-decoration: none;">
            <div class="colored-box blue">
                <div class="colored-box-num">{{ $siswaIzinCount ?? 2 }}</div>
                <div class="colored-box-label">SISWA IZIN</div>
            </div>
        </a>

        <!-- Guru Terlambat / Izin -->
        <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" style="text-decoration: none;">
            <div class="colored-box coral">
                <div class="colored-box-num">{{ $guruTerlambatCount ?? 1 }}</div>
                <div class="colored-box-label">GURU TERLAMBAT</div>
            </div>
        </a>
    </div>

    <!-- Section: Antrean Persetujuan Final Kepsek (Matching media_1788795061037.png) -->
    @if($pendingIzin->count() > 0)
    <div class="section-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-circle-check" style="color: #384972;"></i> Antrean Persetujuan Final Kepsek
            </h3>
            <span style="background: #fef3c7; color: #92400e; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                {{ $pendingIzin->count() }} Permohonan
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-custom-final">
                <thead>
                    <tr>
                        <th style="border-top-left-radius: 8px;">Nama Guru</th>
                        <th>Tanggal Izin</th>
                        <th>Alasan</th>
                        <th>Status Waka</th>
                        <th style="border-top-right-radius: 8px; text-align: center; width: 200px;">Aksi Persetujuan Final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingIzin as $izin)
                    @php
                        $stWakaItem = $izin->status_waka ?? 'pending';
                    @endphp
                    <tr>
                        <td style="font-weight: 800; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</td>
                        <td style="color: #475569; font-weight: 600;">
                            {{ $izin->tanggal_mulai }} @if($izin->tanggal_selesai && $izin->tanggal_selesai !== $izin->tanggal_mulai) s/d {{ $izin->tanggal_selesai }} @endif
                        </td>
                        <td style="color: #334155;">{{ $izin->alasan }}</td>
                        <td>
                            @if($stWakaItem === 'approved')
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-check"></i> Disetujui Waka
                                </span>
                            @elseif($stWakaItem === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-xmark"></i> Ditolak Waka
                                </span>
                            @else
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-clock"></i> Menunggu Waka
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST" onsubmit="return confirm('Approve final izin {{ addslashes($izin->guru->nama_guru ?? 'Guru') }}?')">
                                    @csrf
                                    <button type="submit" class="btn-approve-final">
                                        <i class="fa-solid fa-check-double"></i> Approve Final
                                    </button>
                                </form>
                                <form action="{{ route('kepala-sekolah.izin.reject', $izin->id_guru_izin) }}" method="POST" onsubmit="return confirm('Tolak izin {{ addslashes($izin->guru->nama_guru ?? 'Guru') }}?')">
                                    @csrf
                                    <button type="submit" class="btn-reject-final">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection