@extends('layouts.admin')

@section('title', 'Detail Jam Pelajaran — ' . $jamPelajaran->jam_ke)

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text a {
        color: #3b5490;
        text-decoration: none;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .detail-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .avatar-large {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, #3b5490, #2563eb);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    .profile-info h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .time-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0e7ff;
        color: #3730a3;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 800;
        font-family: monospace;
        border: 1px solid #c7d2fe;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        border-radius: 14px;
    }

    .info-item .label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
    }

    .info-item .value {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .btn-act {
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-act-back {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .btn-act-back:hover { background: #e2e8f0; }

    .btn-act-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-act-edit:hover { background: #d97706; color: #ffffff; }

    .btn-act-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-act-delete:hover { background: #e11d48; color: #ffffff; }

    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Badges & Search in Jadwal Section */
    .jadwal-filter-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .jadwal-search-wrap {
        position: relative;
        flex: 1;
        min-width: 240px;
    }
    .jadwal-search-wrap .form-control {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        padding: 10px 16px 10px 38px !important;
        border-radius: 12px;
        font-size: 13.5px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .jadwal-search-wrap .form-control:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .search-icon-inside {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13.5px;
        pointer-events: none;
        z-index: 2;
    }

    .badge-hari {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 800;
        color: #0f172a;
    }
    .badge-jam {
        background: #e0e7ff;
        color: #3730a3;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        font-family: monospace;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .badge-kelas {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 800;
        color: #1e293b;
    }
    .badge-ruangan {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        color: #475569;
    }

    .mobile-label-text,
    .mobile-pagination-wrapper {
        display: none;
    }

    @media (max-width: 768px) {
        .page-header-container {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            line-height: 1.25 !important;
        }
        .page-title-group p { font-size: 13px !important; }

        .detail-card {
            padding: 18px 14px !important;
            border-radius: 14px !important;
            margin-bottom: 18px !important;
        }

        .profile-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 14px !important;
            padding-bottom: 18px !important;
            margin-bottom: 18px !important;
        }

        .profile-info h1 {
            font-size: 20px !important;
        }

        .info-grid {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .action-row {
            flex-direction: column !important;
            width: 100% !important;
            gap: 10px !important;
            margin-top: 18px !important;
            padding-top: 16px !important;
        }

        .action-row .btn-act,
        .action-row form,
        .action-row form .btn-act {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        /* Mobile Responsive Transform: Table to Cards */
        .jadwal-table-wrapper {
            border: none !important;
            overflow-x: visible !important;
        }

        .jadwal-table-custom {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .jadwal-table-custom thead {
            display: none !important;
        }

        .jadwal-table-custom tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card {
            display: grid !important;
            grid-template-columns: auto 1fr auto !important;
            gap: 8px 10px !important;
            padding: 14px 16px !important;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card.mobile-hidden {
            display: none !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-sizing: border-box !important;
        }

        /* Row 1: Hari, Kelas, Ruangan */
        .jadwal-table-custom tbody tr.jadwal-row-card .col-hari {
            grid-column: 1 !important;
            grid-row: 1 !important;
            align-self: center !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-hari .badge-hari {
            background: #f1f5f9 !important;
            color: #1e293b !important;
            padding: 3px 9px !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 11.5px !important;
            font-weight: 800 !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card .col-kelas {
            grid-column: 2 !important;
            grid-row: 1 !important;
            align-self: center !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-kelas .badge-kelas {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            padding: 3px 10px !important;
            border-radius: 8px !important;
            border: 1px solid #bfdbfe !important;
            font-size: 12px !important;
            font-weight: 800 !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card .col-ruangan {
            grid-column: 3 !important;
            grid-row: 1 !important;
            justify-self: end !important;
            align-self: center !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-ruangan .badge-ruangan {
            background: #f8fafc !important;
            color: #475569 !important;
            padding: 3px 9px !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
        }

        /* Row 2: Mata Pelajaran (Title) */
        .jadwal-table-custom tbody tr.jadwal-row-card .col-mapel {
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            padding: 2px 0 !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-mapel strong {
            font-size: 15px !important;
            color: #0f172a !important;
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
            font-weight: 800 !important;
            line-height: 1.35 !important;
        }

        /* Row 3: Guru Pengampu */
        .jadwal-table-custom tbody tr.jadwal-row-card .col-guru {
            grid-column: 1 / -1 !important;
            grid-row: 3 !important;
            font-size: 12.5px !important;
            color: #475569 !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-guru .guru-wrap {
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
            font-weight: 600 !important;
        }

        /* Row 4: Rentang Jam Badge */
        .jadwal-table-custom tbody tr.jadwal-row-card .col-jam {
            grid-column: 1 / -1 !important;
            grid-row: 4 !important;
            margin-top: 2px !important;
        }
        .jadwal-table-custom tbody tr.jadwal-row-card .col-jam .badge-jam {
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 7px 12px !important;
            font-size: 12px !important;
            justify-content: flex-start !important;
            border-radius: 10px !important;
            border: 1px solid #c7d2fe !important;
            background: #eef2ff !important;
            color: #3730a3 !important;
        }

        /* Mobile Pagination */
        .mobile-pagination-wrapper {
            display: block !important;
            margin-top: 18px !important;
            padding-top: 14px !important;
            border-top: 1px solid #f1f5f9 !important;
            width: 100% !important;
        }

        .mobile-pagination-wrapper .custom-pagination-bar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            text-align: center !important;
            width: 100% !important;
        }

        .mobile-pagination-wrapper .pagination-info {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #64748b !important;
        }

        .mobile-pagination-wrapper .pagination-list {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: flex-start !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            gap: 5px !important;
            padding: 4px 6px !important;
            margin: 0 auto !important;
            max-width: 100% !important;
            scrollbar-width: thin !important;
            box-sizing: border-box !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item {
            display: inline-flex !important;
            flex-shrink: 0 !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #334155 !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
            transition: all 0.15s ease !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item.active .page-link {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }

        .mobile-pagination-wrapper .pagination-list .page-item.disabled .page-link {
            background: #f8fafc !important;
            color: #cbd5e1 !important;
            border-color: #e2e8f0 !important;
            cursor: not-allowed !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .jadwal-table-custom tbody tr.jadwal-row-card {
            padding: 12px 10px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Detail Jam Pelajaran</h1>
            <p>Rincian alokasi waktu dan urutan sesi jam pelajaran</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('jam-pelajaran.index') }}"><i class="fa-regular fa-clock"></i> Master Jam Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Sesi Jam</span>
    </div>

    <div class="detail-card">
        <div class="profile-header">
            <div class="avatar-large"><i class="fa-regular fa-clock"></i></div>
            <div class="profile-info">
                <h1>{{ $jamPelajaran->jam_ke }}</h1>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:6px;">
                    @if($jamPelajaran->waktu_senin_kamis !== '-')
                        <span class="time-pill" style="background:#f1f5f9; color:#1e293b; border-color:#cbd5e1;">
                            <i class="fa-solid fa-calendar-days"></i> Senin-Kamis: {{ $jamPelajaran->waktu_senin_kamis }} WIB (35m)
                        </span>
                    @endif
                    <span class="time-pill" style="background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe;">
                        <i class="fa-solid fa-calendar-days"></i> Jumat: {{ $jamPelajaran->waktu_jumat }} WIB
                    </span>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">Label Sesi Jam</div>
                <div class="value" style="font-weight:800; color:#0f172a;">{{ $jamPelajaran->jam_ke }}</div>
            </div>

            <div class="info-item">
                <div class="label">Waktu Senin - Kamis</div>
                <div class="value" style="font-family:monospace; color:#1e293b; font-weight:800;">{{ $jamPelajaran->waktu_senin_kamis }} WIB</div>
            </div>

            <div class="info-item">
                <div class="label">Waktu Hari Jumat</div>
                <div class="value" style="font-family:monospace; color:#2563eb; font-weight:800;">{{ $jamPelajaran->waktu_jumat }} WIB</div>
            </div>

            <div class="info-item">
                <div class="label">Keterangan / Catatan Sesi</div>
                <div class="value">{{ $jamPelajaran->keterangan ?? 'Pembelajaran Reguler' }}</div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('jam-pelajaran.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Jam
            </a>
            <a href="{{ route('jam-pelajaran.edit', $jamPelajaran->id_jam) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Sesi Jam
            </a>
            <form action="{{ route('jam-pelajaran.destroy', $jamPelajaran->id_jam) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jam pelajaran {{ addslashes($jamPelajaran->jam_ke) }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Jam
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Jadwal yang Berlangsung pada Jam Ini -->
    <div class="detail-card" id="jadwalDetailCard">
        @php
            $activeJadwals = $jadwals ?? ($jamPelajaran->jadwals_active ?? collect());
        @endphp
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
            <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin:0; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <i class="fa-solid fa-calendar-days" style="color:#2563eb;"></i>
                <span>Jadwal Pelajaran Terdaftar <span style="white-space:nowrap;">(<span id="totalJadwalCount">{{ count($activeJadwals) }}</span>)</span></span>
            </h2>
        </div>

        @if(count($activeJadwals) > 0)
            <div class="jadwal-filter-container">
                <div class="jadwal-search-wrap">
                    <i class="fa-solid fa-magnifying-glass search-icon-inside"></i>
                    <input type="text" id="searchJadwal" class="form-control" placeholder="Cari hari, kelas, mapel, guru, atau ruangan..." oninput="filterJadwalTable(this.value)">
                </div>
            </div>
        @endif

        <div class="table-responsive jadwal-table-wrapper">
            <table class="table-custom jadwal-table-custom" id="tableJadwalDetail">
                <thead>
                    <tr>
                        <th style="width:100px;">HARI</th>
                        <th style="width:230px;">RENTANG JAM</th>
                        <th style="width:120px;">KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>GURU PENGAMPU</th>
                        <th style="width:120px;">RUANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeJadwals as $j)
                        <tr class="jadwal-row-card"
                            data-search="{{ strtolower(($j->hari ?? '') . ' ' . ($j->kelas->nama_kelas ?? '') . ' ' . ($j->mapel->nama_mapel ?? '') . ' ' . ($j->guru->nama_guru ?? '') . ' ' . ($j->ruangan->nama_ruangan ?? '') . ' ' . ($j->jam_range_formatted ?? '')) }}">
                            <td class="col-hari">
                                <span class="badge-hari"><i class="fa-regular fa-calendar"></i> {{ $j->hari ?? '-' }}</span>
                            </td>
                            <td class="col-jam">
                                <span class="badge-jam"><i class="fa-regular fa-clock"></i> {{ $j->jam_range_formatted }}</span>
                            </td>
                            <td class="col-kelas">
                                <span class="badge-kelas"><i class="fa-solid fa-chalkboard-user"></i> {{ $j->kelas->nama_kelas ?? '-' }}</span>
                            </td>
                            <td class="col-mapel">
                                <strong><i class="fa-solid fa-book-open" style="color:#2563eb; margin-right:4px;"></i>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                            </td>
                            <td class="col-guru">
                                <div class="guru-wrap">
                                    <i class="fa-solid fa-user-tie" style="color:#64748b;"></i>
                                    <span>{{ $j->guru->nama_guru ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="col-ruangan">
                                <span class="badge-ruangan"><i class="fa-solid fa-door-open"></i> {{ $j->ruangan->nama_ruangan ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyJadwalRow">
                            <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8;">
                                <i class="fa-regular fa-calendar-xmark" style="font-size:28px; margin-bottom:8px; display:block;"></i>
                                Belum ada jadwal kelas yang terdaftar pada sesi jam ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Pagination Container -->
        @if(count($activeJadwals) > 0)
            <div id="jadwalMobilePaginationContainer" class="mobile-pagination-wrapper">
                <div class="custom-pagination-bar">
                    <div class="pagination-info" id="jadwalMobilePaginationInfo">
                        Menampilkan <strong style="color: #0f172a;">1</strong> – <strong style="color: #0f172a;">{{ min(8, count($activeJadwals)) }}</strong> dari <strong style="color: #0f172a;">{{ number_format(count($activeJadwals), 0, ',', '.') }}</strong> Data
                    </div>
                    <ul class="pagination-list" id="jadwalMobilePaginationList">
                        <!-- Dynamic via JS -->
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <script>
        let currentJadwalMobilePage = 1;
        const jadwalItemsPerPage = 8;

        function isMobileScreen() {
            return window.matchMedia('(max-width: 768px)').matches;
        }

        function filterJadwalTable(query) {
            const allRows = document.querySelectorAll('#tableJadwalDetail tbody tr.jadwal-row-card');
            const q = (query || '').trim().toLowerCase();
            let matchCount = 0;

            allRows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                const match = q === '' || searchData.includes(q);
                if (match) {
                    row.dataset.searchMatch = 'true';
                    matchCount++;
                } else {
                    row.dataset.searchMatch = 'false';
                }
            });

            const countEl = document.getElementById('totalJadwalCount');
            if (countEl) {
                countEl.textContent = matchCount;
            }

            if (!isMobileScreen()) {
                allRows.forEach(row => {
                    row.style.display = row.dataset.searchMatch === 'true' ? '' : 'none';
                });
            } else {
                renderMobileJadwalPage(1);
            }
        }

        function goToMobileJadwalPage(page) {
            renderMobileJadwalPage(page);
            const card = document.getElementById('jadwalDetailCard');
            if (card) {
                card.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function renderMobileJadwalPage(page = 1) {
            const allRows = Array.from(document.querySelectorAll('#tableJadwalDetail tbody tr.jadwal-row-card'));
            const matchedRows = allRows.filter(r => r.dataset.searchMatch !== 'false');
            const infoEl = document.getElementById('jadwalMobilePaginationInfo');
            const listEl = document.getElementById('jadwalMobilePaginationList');
            const paginationContainer = document.getElementById('jadwalMobilePaginationContainer');

            if (!isMobileScreen()) {
                allRows.forEach(row => {
                    row.classList.remove('mobile-hidden');
                    row.style.display = row.dataset.searchMatch === 'false' ? 'none' : '';
                });
                if (listEl) listEl.innerHTML = '';
                return;
            }

            const totalItems = matchedRows.length;
            const totalPages = Math.ceil(totalItems / jadwalItemsPerPage) || 1;

            if (page < 1) page = 1;
            if (page > totalPages) page = totalPages;
            currentJadwalMobilePage = page;

            const startIdx = (page - 1) * jadwalItemsPerPage;
            const endIdx = startIdx + jadwalItemsPerPage;

            allRows.forEach(row => {
                row.classList.add('mobile-hidden');
                row.style.setProperty('display', 'none', 'important');
            });

            matchedRows.forEach((row, i) => {
                if (i >= startIdx && i < endIdx) {
                    row.classList.remove('mobile-hidden');
                    row.style.removeProperty('display');
                }
            });

            const startNum = totalItems === 0 ? 0 : startIdx + 1;
            const endNum = Math.min(endIdx, totalItems);

            if (infoEl) {
                infoEl.innerHTML = `Menampilkan <strong style="color: #0f172a;">${startNum}</strong> – <strong style="color: #0f172a;">${endNum}</strong> dari <strong style="color: #0f172a;">${totalItems.toLocaleString('id-ID')}</strong> Data`;
            }

            if (paginationContainer) {
                paginationContainer.style.display = totalItems > 0 ? 'block' : 'none';
            }

            if (listEl) {
                renderMobileJadwalPaginationButtons(listEl, totalPages, currentJadwalMobilePage);
            }
        }

        function renderMobileJadwalPaginationButtons(listEl, totalPages, page) {
            if (totalPages <= 1) {
                listEl.innerHTML = '';
                return;
            }

            let html = '';

            // Tombol Sebelumnya («)
            if (page === 1) {
                html += `<li class="page-item disabled"><span class="page-link">&laquo;</span></li>`;
            } else {
                html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${page - 1})" rel="prev">&laquo;</a></li>`;
            }

            if (totalPages <= 8) {
                for (let i = 1; i <= totalPages; i++) {
                    if (i === page) {
                        html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                    } else {
                        html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${i})">${i}</a></li>`;
                    }
                }
            } else {
                if (page <= 5) {
                    for (let i = 1; i <= 8; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${i})">${i}</a></li>`;
                        }
                    }
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${totalPages})">${totalPages}</a></li>`;
                } else if (page > totalPages - 5) {
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(1)">1</a></li>`;
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    for (let i = totalPages - 7; i <= totalPages; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${i})">${i}</a></li>`;
                        }
                    }
                } else {
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(1)">1</a></li>`;
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    for (let i = page - 2; i <= page + 2; i++) {
                        if (i === page) {
                            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${i})">${i}</a></li>`;
                        }
                    }
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${totalPages})">${totalPages}</a></li>`;
                }
            }

            // Tombol Selanjutnya (»)
            if (page === totalPages) {
                html += `<li class="page-item disabled"><span class="page-link">&raquo;</span></li>`;
            } else {
                html += `<li class="page-item"><a href="javascript:void(0)" class="page-link" onclick="goToMobileJadwalPage(${page + 1})" rel="next">&raquo;</a></li>`;
            }

            listEl.innerHTML = html;
        }

        document.addEventListener("DOMContentLoaded", function() {
            renderMobileJadwalPage(1);

            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    renderMobileJadwalPage(currentJadwalMobilePage);
                }, 150);
            });
        });
    </script>
@endsection
