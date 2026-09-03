@extends('layouts.guru')

@section('title', 'Akademik - Jurnal Mengajar — Guru Piket')
@section('header_title', 'Akademik - Jurnal Mengajar')

@section('styles')
<style>
    .jurnal-mengajar-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: -12px;
        margin-bottom: 4px;
    }

    /* Top Search & Filter Bar */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1.5;
        min-width: 220px;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }

    .filter-item {
        flex: 1;
        min-width: 140px;
        position: relative;
    }

    .filter-item select, .filter-item input {
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
    }

    .btn-filter-action {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .btn-filter-action:hover {
        background: #1e293b;
    }

    /* 4 Stat Cards Grid */
    .stat-grid {
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-orange { background: #ffedd5; color: #ea580c; }
    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-subtext {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .btn-export {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    /* Custom Table Styling */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-jurnal-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-jurnal-table th {
        background: #dfd8c8;
        color: #1e293b;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #d1c9b6;
        border-bottom: 1px solid #d1c9b6;
    }

    .custom-jurnal-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .custom-jurnal-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; }

    .custom-jurnal-table td {
        padding: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .date-cell {
        display: flex;
        flex-direction: flex;
        gap: 6px;
        align-items: center;
    }

    .date-day {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .date-month {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .badge-terlaksana {
        background: #d1fae5;
        color: #065f46;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-belum-terlaksana {
        background: #fee2e2;
        color: #991b1b;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .action-btns {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action-icon:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    /* Table Footer & Pagination */
    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .page-btn.active {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-grid { grid-template-columns: 1fr; }
        .filter-grid { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')
<div class="jurnal-mengajar-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jurnal Mengajar Guru</h1>
            <p>Monitoring dan pengawasan pengisian jurnal mengajar harian guru</p>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards) -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-purple">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Pertemuan</span>
                <span class="stat-val">{{ $stats['totalPertemuan'] }} Pertemuan</span>
                <span class="stat-subtext">Seluruh pertemuan pada periode ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Terlaksana</span>
                <span class="stat-val">{{ $stats['terlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">Seluruh pertemuan pada periode ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Terlaksana</span>
                <span class="stat-val">{{ $stats['belumTerlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">{{ $stats['pctBelum'] }}% dari total pertemuan</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Aktif</span>
                <span class="stat-val">{{ $stats['guruAktif'] }} Guru</span>
                <span class="stat-subtext">Mengajar pada periode ini</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Table Card (Daftar Jurnal Mengajar) -->
    <div class="main-table-panel">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-book-open" style="color: #2b3957;"></i>
                <span>Daftar Jurnal Mengajar</span>
            </div>

            <a href="{{ route('piket.jurnal-mengajar.export') }}" class="btn-export">
                <i class="fa-solid fa-download"></i> Export
            </a>
        </div>

        <!-- Filter & Search Bar (Di Atas Tabel) -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.jurnal-mengajar') }}" method="GET">
                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari Mata Pelajaran / Guru / Kelas..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="filter-input" title="Filter Tanggal">
                </div>

                <div>
                    <select name="id_guru" class="filter-input">
                        <option value="">👤 Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_kelas" class="filter-input">
                        <option value="">🏫 Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input">
                        <option value="">📖 Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-container">
            <table class="custom-jurnal-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Materi</th>
                        <th>Pertemuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $row)
                        @php
                            $tgl = isset($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $row->tanggal_formatted_day ?? ($tgl ? $tgl->format('d') : '05');
                            $monthStr = $row->tanggal_formatted_month ?? ($tgl ? strtoupper($tgl->format('M Y')) : 'JUN 2026');
                            $isTerlaksana = ($row->status_teks ?? ($row->status_kehadiran_guru ?? 'Hadir')) !== 'Belum Terlaksana';
                        @endphp
                        <tr>
                            <td>
                                <div class="date-cell">
                                    <span class="date-day">{{ $dayStr }}</span>
                                    <span class="date-month">{{ $monthStr }}</span>
                                </div>
                            </td>
                            <td><strong>{{ $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Matematika') }}</strong></td>
                            <td>{{ $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'X RPL 1') }}</td>
                            <td>{{ $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Mengajar') }}</td>
                            <td style="max-width: 250px;">{{ $row->materi ?? 'Persamaan Linear Satu Variabel' }}</td>
                            <td>{{ $row->pertemuan_ke ?? '12 / 36' }}</td>
                            <td>
                                <span class="{{ $isTerlaksana ? 'badge-terlaksana' : 'badge-belum-terlaksana' }}">
                                    {{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-action-icon" onclick="openDetailModal('{{ $row->id_jurnal ?? 1 }}', '{{ $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru') }}', '{{ $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Mapel') }}', '{{ $row->materi ?? 'Materi' }}')" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-action-icon" title="Opsi Lainnya">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada data jurnal mengajar ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan 1 - {{ min(count($jurnals), 5) }} dari {{ $stats['totalPertemuan'] }} data
            </div>

            <div class="custom-pagination">
                <a href="#" class="page-btn">&lt;&lt;</a>
                <a href="#" class="page-btn">&lt;</a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <a href="#" class="page-btn">&gt;</a>
                <a href="#" class="page-btn">&gt;&gt;</a>
            </div>
        </div>
    </div>

</div>

<!-- Modal Detail Jurnal -->
<div id="detailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); z-index: 999; align-items: center; justify-content: center;">
    <div style="background: #ffffff; width: 90%; max-width: 500px; border-radius: 16px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
            <h4 style="font-size: 16px; font-weight: 800; color: #1e293b;">Detail Jurnal Mengajar</h4>
            <button onclick="closeDetailModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: #334155;">
            <div><strong>Guru:</strong> <span id="modalGuru">-</span></div>
            <div><strong>Mata Pelajaran:</strong> <span id="modalMapel">-</span></div>
            <div><strong>Materi:</strong> <p id="modalMateri" style="margin-top: 4px; color: #475569; font-weight: 600;">-</p></div>
            <div><strong>Status Presensi:</strong> <span class="badge-terlaksana">Terlaksana (Tersinkronisasi)</span></div>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <button onclick="closeDetailModal()" class="btn-filter-action" style="padding: 8px 18px; font-size: 12px;">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openDetailModal(id, guru, mapel, materi) {
        document.getElementById('modalGuru').textContent = guru;
        document.getElementById('modalMapel').textContent = mapel;
        document.getElementById('modalMateri').textContent = materi;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
</script>
@endsection
