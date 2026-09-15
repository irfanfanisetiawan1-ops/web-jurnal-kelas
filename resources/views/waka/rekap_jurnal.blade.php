@extends('layouts.waka')

@section('title', 'Rekap Jurnal Mengajar — Waka Portal')

@section('styles')
<style>
    .rekap-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
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

    .header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-outline {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    /* 4 Stat Cards Row */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        width: 100%;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 0;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue   { background: #eff6ff; color: #2563eb; }
    .icon-emerald{ background: #ecfdf5; color: #059669; }
    .icon-purple { background: #f5f3ff; color: #7c3aed; }
    .icon-amber  { background: #fffbeb; color: #d97706; }

    .stat-info-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-count {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* Filter Panel */
    .filter-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filter-form-grid {
        display: grid;
        grid-template-columns: 2fr repeat(4, 1.2fr) auto auto;
        gap: 10px;
        align-items: center;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        font-family: inherit;
        background: #f8fafc;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
    }

    .filter-input:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .filter-select {
        width: 100%;
        padding: 9px 10px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        font-family: inherit;
        background: #f8fafc;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .btn-filter-submit {
        background: #1e293b;
        color: #ffffff;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-filter-reset {
        background: #f1f5f9;
        color: #64748b;
        padding: 9px 12px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Table Styles */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-action-bar {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 980px;
    }

    .rekap-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .rekap-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .rekap-table tr:hover td {
        background: #f8fafc;
    }

    .class-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        font-weight: 800;
        font-size: 12px;
    }

    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 6px;
        border-radius: 5px;
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-kondisi {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .kondisi-kondusif { background: #dcfce7; color: #15803d; }
    .kondisi-cukup    { background: #e0e7ff; color: #4338ca; }
    .kondisi-kurang   { background: #fef3c7; color: #b45309; }
    .kondisi-tidak    { background: #fee2e2; color: #b91c1c; }

    .badge-absen {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .badge-absen-nihil { background: #f1f5f9; color: #64748b; }
    .badge-absen-ada   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    .btn-row-action {
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #2563eb;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-row-action:hover {
        background: #eff6ff;
        border-color: #93c5fd;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 16px;
        max-width: 750px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }

    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
    }
    .modal-close-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .modal-body {
        padding: 20px 22px;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    .modal-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 16px;
    }

    .detail-item-box {
        background: #f8fafc;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .detail-item-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .detail-item-val {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 2px;
    }

    .absen-modal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        margin-top: 8px;
    }

    .absen-modal-table th {
        background: #f1f5f9;
        padding: 8px 10px;
        text-align: left;
        color: #475569;
        font-weight: 700;
        border: 1px solid #e2e8f0;
    }

    .absen-modal-table td {
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }

    @media (max-width: 1024px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .filter-form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 640px) {
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
        .filter-form-grid {
            grid-template-columns: 1fr;
        }
        .modal-detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="rekap-container">

    {{-- Page Header --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; <span style="color: #2563eb;">Rekap Jurnal Mengajar</span>
            </div>
            <h1 class="page-main-title">Rekap Jurnal Mengajar</h1>
            <p class="page-sub-title">Monitoring KBM Harian, Keterisian Materi, &amp; Rekap Ketidakhadiran Siswa SMKN 1 Boyolangu</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('waka.rekap-jurnal.print', request()->all()) }}" target="_blank" class="btn-action btn-outline">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </a>
            <a href="{{ route('waka.rekap-jurnal.export', request()->all()) }}" class="btn-action btn-primary">
                <i class="fa-solid fa-file-csv"></i> Download CSV
            </a>
        </div>
    </div>

    {{-- 4 Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Jurnal Terisi</span>
                <span class="stat-count">{{ number_format($stats['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Jurnal Hari Ini</span>
                <span class="stat-count">{{ $stats['today'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Sesi</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Kondisi Kondusif</span>
                <span class="stat-count">{{ $stats['kondusif_percentage'] ?? 100 }}%</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Siswa Absen</span>
                <span class="stat-count">{{ number_format($stats['total_absen'] ?? 0, 0, ',', '.') }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Data</span></span>
            </div>
        </div>
    </div>

    {{-- Search & Multi-Filter Panel --}}
    <div class="filter-panel">
        <form method="GET" action="{{ route('waka.rekap-jurnal') }}" class="filter-form-grid" id="filterForm">
            <div class="search-input-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari materi, guru, mapel, kelas..." class="filter-input">
            </div>

            <select name="periode" class="filter-select">
                <option value="all" {{ $periode === 'all' ? 'selected' : '' }}>Semua Periode</option>
                <option value="today" {{ $periode === 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="this_week" {{ $periode === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="this_month" {{ $periode === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
            </select>

            <select name="tingkat" class="filter-select">
                <option value="">-- Semua Tingkat --</option>
                @foreach(['X', 'XI', 'XII'] as $t)
                    <option value="{{ $t }}" {{ $tingkat === $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
                @endforeach
            </select>

            <select name="id_kelas" class="filter-select">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $idKelas == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <select name="id_guru" class="filter-select">
                <option value="">-- Semua Guru --</option>
                @foreach($guruList as $g)
                    <option value="{{ $g->id_guru }}" {{ $idGuru == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter-submit">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <a href="{{ route('waka.rekap-jurnal') }}" class="btn-filter-reset" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </form>
    </div>

    {{-- Main Data Table Card --}}
    <div class="table-card">
        <div class="table-action-bar">
            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                Riwayat Jurnal Mengajar Terisi
            </div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                Menampilkan <span style="color: #0f172a; font-weight: 800;">{{ $jurnalList->firstItem() ?? 0 }} - {{ $jurnalList->lastItem() ?? 0 }}</span> dari <span style="color: #0f172a; font-weight: 800;">{{ $jurnalList->total() }}</span> sesi KBM
            </div>
        </div>

        <div class="table-scroll-wrapper">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th style="width: 35px; text-align: center;">#</th>
                        <th style="width: 130px;">Tanggal &amp; Jam</th>
                        <th>Guru Pengajar</th>
                        <th>Kelas &amp; Ruang</th>
                        <th>Mata Pelajaran</th>
                        <th>Materi Pembelajaran</th>
                        <th>Kondisi</th>
                        <th>Presensi Siswa</th>
                        <th style="text-align: center; width: 90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnalList as $index => $j)
                        @php
                            $guruName = $j->guru->nama_guru ?? '-';
                            $guruInval = $j->guruPengganti ? $j->guruPengganti->nama_guru : null;
                            $absenCount = $j->detailKetidakhadiran->count();
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #94a3b8;">
                                {{ $jurnalList->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">
                                    {{ $j->tanggal ? \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') : '-' }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    {{ $j->jadwal->hari ?? '' }} (Jam ke-{{ $j->jadwal->jam_mulai_ke ?? '-' }} - {{ $j->jadwal->jam_selesai_ke ?? '-' }})
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #1e293b;">
                                    {{ $guruName }}
                                </div>
                                @if($guruInval)
                                    <div style="font-size: 11px; color: #7c3aed; font-weight: 700; margin-top: 2px;">
                                        <i class="fa-solid fa-user-tag"></i> Inval: {{ $guruInval }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span class="class-chip">
                                        <i class="fa-solid fa-graduation-cap"></i> {{ $j->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </div>
                                <div style="margin-top: 3px;">
                                    <span class="room-badge">
                                        <i class="fa-solid fa-door-open"></i> {{ $j->jadwal->ruangan->nama_ruangan ?? ($j->kelas->nama_kelas ?? 'R. Kelas') }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">
                                    {{ $j->mapel->nama_mapel ?? '-' }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Pertemuan Ke-{{ $j->pertemuan_ke ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="max-width: 250px; font-weight: 500; color: #334155; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $j->materi }}">
                                    {{ $j->materi ?: '-' }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $k = strtolower($j->kondisi_kelas ?? '');
                                    $kClass = 'kondisi-kondusif';
                                    if(str_contains($k, 'kurang')) $kClass = 'kondisi-kurang';
                                    elseif(str_contains($k, 'tidak')) $kClass = 'kondisi-tidak';
                                    elseif(str_contains($k, 'cukup')) $kClass = 'kondisi-cukup';
                                @endphp
                                <span class="badge-kondisi {{ $kClass }}">
                                    {{ $j->kondisi_kelas ?? 'Kondusif' }}
                                </span>
                            </td>
                            <td>
                                @if($absenCount > 0)
                                    <span class="badge-absen badge-absen-ada" title="Terdapat {{ $absenCount }} siswa tidak hadir">
                                        <i class="fa-solid fa-user-xmark"></i> {{ $absenCount }} Absen
                                    </span>
                                @else
                                    <span class="badge-absen badge-absen-nihil">
                                        <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Nihil
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-row-action" onclick="showDetailJurnal({{ $j->id_jurnal }})">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px 20px;">
                                <div style="color: #94a3b8; font-size: 32px; margin-bottom: 10px;">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                <div style="font-size: 15px; font-weight: 800; color: #475569;">Tidak ada data jurnal mengajar ditemukan</div>
                                <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Coba ubah kata kunci pencarian atau sesuaikan filter periode.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; background: #ffffff;">
            {{ $jurnalList->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

{{-- MODAL DETAIL JURNAL MENGAJAR --}}
<div class="modal-overlay" id="modalDetailJurnal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-book-open" style="color: #2563eb;"></i> Rincian Jurnal Mengajar</h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailJurnalModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body" id="detailJurnalBody">
            <div style="text-align: center; padding: 30px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px;"></i>
                <div style="margin-top: 8px; font-weight: 700;">Memuat rincian jurnal...</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailJurnalModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function showDetailJurnal(id) {
        const modal = document.getElementById('modalDetailJurnal');
        const body = document.getElementById('detailJurnalBody');
        modal.style.display = 'flex';
        body.innerHTML = `
            <div style="text-align: center; padding: 30px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px;"></i>
                <div style="margin-top: 8px; font-weight: 700;">Memuat rincian jurnal...</div>
            </div>
        `;

        fetch('/waka/rekap-jurnal/' + id)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const d = res.data;
                    let absensiHtml = '';
                    if (d.absensi && d.absensi.length > 0) {
                        absensiHtml = `
                            <table class="absen-modal-table">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th style="width: 120px;">NIS/NISN</th>
                                        <th>Nama Siswa</th>
                                        <th style="width: 100px;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${d.absensi.map((a, idx) => `
                                        <tr>
                                            <td>${idx + 1}</td>
                                            <td>${a.nis}</td>
                                            <td style="font-weight: 700;">${a.nama_siswa}</td>
                                            <td><span style="font-weight: 800; color: #dc2626;">${a.keterangan}</span></td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        `;
                    } else {
                        absensiHtml = `<div style="color: #059669; font-weight: 700; font-size: 13px; background: #ecfdf5; padding: 8px 12px; border-radius: 8px;"><i class="fa-solid fa-check-circle"></i> Seluruh siswa hadir lengkap (Nihil Absen).</div>`;
                    }

                    let dokHtml = '';
                    if (d.dokumentasi_url) {
                        dokHtml = `
                            <div style="margin-top: 14px;">
                                <div class="detail-item-label" style="margin-bottom: 6px;">Foto Dokumentasi Kegiatan KBM:</div>
                                <img src="${d.dokumentasi_url}" alt="Dokumentasi KBM" style="max-width: 100%; max-height: 250px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            </div>
                        `;
                    }

                    body.innerHTML = `
                        <div class="modal-detail-grid">
                            <div class="detail-item-box">
                                <div class="detail-item-label">Hari &amp; Tanggal KBM</div>
                                <div class="detail-item-val">${d.tanggal}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">${d.jam_pelajaran}</div>
                            </div>
                            <div class="detail-item-box">
                                <div class="detail-item-label">Kelas &amp; Ruangan</div>
                                <div class="detail-item-val">${d.kelas} (${d.tingkat})</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">Ruang: ${d.ruangan}</div>
                            </div>
                            <div class="detail-item-box">
                                <div class="detail-item-label">Guru Pengajar</div>
                                <div class="detail-item-val">${d.guru_pengajar}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">NIP: ${d.nip_guru || '-'}</div>
                                ${d.guru_pengganti ? `<div style="font-size: 11px; color: #7c3aed; font-weight: 700; margin-top: 2px;">Guru Inval: ${d.guru_pengganti}</div>` : ''}
                            </div>
                            <div class="detail-item-box">
                                <div class="detail-item-label">Mata Pelajaran &amp; Pertemuan</div>
                                <div class="detail-item-val">${d.mapel}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">Pertemuan Ke-${d.pertemuan_ke} (Kode: ${d.kode_mapel})</div>
                            </div>
                        </div>

                        <div class="detail-item-box" style="margin-bottom: 14px;">
                            <div class="detail-item-label">Materi Pembelajaran yang Diajarkan</div>
                            <div style="font-size: 13.5px; color: #1e293b; font-weight: 600; margin-top: 4px; line-height: 1.5;">${d.materi || '-'}</div>
                        </div>

                        <div class="modal-detail-grid" style="margin-bottom: 14px;">
                            <div class="detail-item-box">
                                <div class="detail-item-label">Kondisi Kelas</div>
                                <div class="detail-item-val" style="color: #2563eb;">${d.kondisi_kelas}</div>
                            </div>
                            <div class="detail-item-box">
                                <div class="detail-item-label">Catatan Tambahan Guru</div>
                                <div style="font-size: 12.5px; color: #334155; margin-top: 2px;">${d.catatan || '-'}</div>
                            </div>
                        </div>

                        <div>
                            <div class="detail-item-label" style="margin-bottom: 6px;">Daftar Siswa Tidak Hadir (Ketidakhadiran):</div>
                            ${absensiHtml}
                        </div>

                        ${dokHtml}
                    `;
                } else {
                    body.innerHTML = `<div style="color: #dc2626; padding: 20px; text-align: center;">Gagal memuat rincian jurnal.</div>`;
                }
            })
            .catch(err => {
                body.innerHTML = `<div style="color: #dc2626; padding: 20px; text-align: center;">Terjadi kesalahan koneksi saat memuat data.</div>`;
            });
    }

    function closeDetailJurnalModal() {
        document.getElementById('modalDetailJurnal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection