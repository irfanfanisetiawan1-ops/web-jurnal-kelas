<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Mengajar — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 50px;
        }

        .bg-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #4f46e5 100%);
            z-index: 0;
        }
        .bg-banner::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-banner::after {
            content: '';
            position: absolute;
            bottom: 20px; left: 10%;
            width: 180px; height: 180px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .header-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px 28px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(255, 255, 255, 0.8);
            flex-wrap: wrap;
            gap: 16px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.35);
        }
        .header-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
        .header-title p { font-size: 13px; color: #64748b; margin-top: 2px; font-weight: 500; }

        .btn-trash {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s ease;
        }
        .btn-trash:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .trash-count {
            background: #ef4444;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 20px;
            line-height: 1;
        }

        .btn-add {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 16px -2px rgba(99, 102, 241, 0.35);
            transition: all 0.2s ease;
        }
        .btn-add:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -2px rgba(99, 102, 241, 0.45);
        }

        .main-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        .card-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .card-header-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: #e0e7ff;
            color: #4f46e5;
            display: flex; align-items: center; justify-content: center;
        }
        .card-header-info h2 { font-size: 18px; font-weight: 800; color: #0f172a; }
        .card-header-info p { font-size: 13px; color: #64748b; margin-top: 1px; }

        .count-pill {
            background: #e0e7ff;
            color: #3730a3;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Toast Auto-Dismiss Style */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            pointer-events: none;
        }
        .toast-card {
            background: #ffffff;
            border-left: 4px solid #10b981;
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.12), 0 4px 6px -2px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 700;
            color: #065f46;
            pointer-events: all;
            position: relative;
            overflow: hidden;
            animation: toastIn .35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            min-width: 320px;
            max-width: 440px;
        }
        .toast-card.hiding { animation: toastOut .4s ease forwards; }
        .toast-close-btn {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .toast-close-btn:hover { color: #0f172a; background: #f1f5f9; }

        .toast-progress-bar {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            background: #10b981;
            animation: progressBar 3.5s linear forwards;
        }

        @keyframes toastIn { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(110%); } }
        @keyframes progressBar { from { width: 100%; } to { width: 0%; } }

        .toolbar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }
        .search-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            max-width: 540px;
        }
        .search-box {
            position: relative;
            flex: 1;
        }
        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            font-size: 13.5px;
            font-family: inherit;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            outline: none;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .search-box input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .search-box svg {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .filter-select {
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            background: #ffffff;
            color: #334155;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .filter-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .nav-modules {
            display: flex;
            gap: 6px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
        }
        .nav-mod-btn {
            text-decoration: none;
            padding: 7px 14px;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 8px;
            color: #64748b;
            transition: all 0.15s ease;
        }
        .nav-mod-btn:hover { color: #0f172a; }
        .nav-mod-btn.active {
            background: #ffffff;
            color: #4f46e5;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            text-align: left;
        }
        thead {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            padding: 14px 18px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            padding: 16px 18px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tbody tr {
            transition: background-color 0.15s ease;
        }
        tbody tr:hover {
            background-color: #f8fafc;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Kehadiran Guru Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
        }
        .status-Hadir { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-Izin  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .status-Sakit { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-Tanpa-Keterangan { background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; }

        /* Ketidakhadiran Pill */
        .absence-pill {
            background: #f1f5f9;
            color: #475569;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .absence-pill.has-absent {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }

        /* Action Buttons with Text (Detail, Edit, Hapus) */
        .action-flex {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-act {
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
            border: 1px solid transparent;
            font-family: inherit;
            line-height: 1;
        }

        .btn-act-detail {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .btn-act-detail:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-act-edit {
            background: #fffbeb;
            color: #d97706;
            border-color: #fef08a;
        }
        .btn-act-edit:hover {
            background: #fef3c7;
            color: #b45309;
        }

        .btn-act-delete {
            background: #fff1f2;
            color: #e11d48;
            border-color: #fecdd3;
        }
        .btn-act-delete:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: #64748b;
        }
        .empty-state svg { margin-bottom: 12px; color: #cbd5e1; }
        .empty-state h3 { font-size: 16px; font-weight: 700; color: #334155; margin-bottom: 4px; }
        .empty-state p { font-size: 13px; }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <!-- Toast Notification (Auto-Dismiss 3.5 Detik) -->
    @if(session('success'))
    <div class="toast-container" id="toastContainer">
        <div class="toast-card" id="toastCard">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>{{ session('success') }}</span>
            <button type="button" class="toast-close-btn" onclick="dismissToast()" title="Tutup">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="toast-progress-bar"></div>
        </div>
    </div>
    @endif

    <!-- Header Navigation Card -->
    <div class="header-card">
        <div class="header-left">
            <div class="header-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="14" y2="10"/></svg>
            </div>
            <div class="header-title">
                <h1>Jurnal Mengajar</h1>
                <p>Kelola pencatatan aktivitas pembelajaran, materi, dan keandalan mengajar guru</p>
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('jurnal-mengajar.trash') }}" class="btn-trash" title="Lihat Jurnal Terhapus">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                Sampah
                @if($trashedCount > 0)
                    <span class="trash-count">{{ $trashedCount }}</span>
                @endif
            </a>
            <a href="{{ route('jurnal-mengajar.create') }}" class="btn-add">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Jurnal Mengajar
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="main-card">

        <div class="card-header-row">
            <div class="card-header-left">
                <div class="card-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div class="card-header-info">
                    <h2>Daftar Jurnal Mengajar</h2>
                    <p>Menampilkan rekapitulasi seluruh kegiatan mengajar</p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <span class="count-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Total: {{ count($jurnals) }} Jurnal
                </span>

                <!-- Navigation Tabs -->
                <div class="nav-modules">
                    <a href="{{ route('siswa.index') }}" class="nav-mod-btn">Siswa</a>
                    <a href="{{ route('guru.index') }}" class="nav-mod-btn">Guru</a>
                    <a href="{{ route('kelas.index') }}" class="nav-mod-btn">Kelas</a>
                    <a href="{{ route('mapel.index') }}" class="nav-mod-btn">Mapel</a>
                    <a href="{{ route('ruangan.index') }}" class="nav-mod-btn">Ruangan</a>
                    <a href="{{ route('jadwal.index') }}" class="nav-mod-btn">Jadwal</a>
                    <a href="{{ route('jurnal-mengajar.index') }}" class="nav-mod-btn active">Jurnal</a>
                </div>
            </div>
        </div>

        <!-- Toolbar Filter & Search -->
        <div class="toolbar-row">
            <div class="search-group">
                <div class="search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" placeholder="Cari tanggal, kelas, guru, mapel, materi..." onkeyup="filterTable()">
                </div>
                <select id="statusFilter" class="filter-select" onchange="filterTable()">
                    <option value="">Semua Status Guru</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <table id="jurnalTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>TANGGAL & HARI</th>
                        <th>KELAS & MAPEL</th>
                        <th>GURU PENGAMPU</th>
                        <th>STATUS GURU</th>
                        <th>MATERI PEMBELAJARAN</th>
                        <th>KETIDAKHADIRAN SISWA</th>
                        <th style="width: 230px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $index => $item)
                        @php
                            $statusClass = str_replace(' ', '-', $item->status_kehadiran_guru);
                            $absenceCount = $item->detailKetidakhadiran->count();
                        @endphp
                        <tr data-status="{{ $item->status_kehadiran_guru }}">
                            <td style="font-weight: 700; color: #94a3b8;">{{ $index + 1 }}</td>
                            <td>
                                <strong style="color: #0f172a;">{{ $item->tanggal_formatted }}</strong>
                                <br>
                                <small style="color: #64748b; font-weight: 600;">
                                    {{ $item->jadwal->hari ?? '' }} ({{ $item->jadwal->jam_mulai_formatted ?? '' }} - {{ $item->jadwal->jam_selesai_formatted ?? '' }})
                                </small>
                            </td>
                            <td>
                                <strong style="color: #4f46e5; background: #e0e7ff; padding: 2px 8px; border-radius: 6px; font-size: 12px; display: inline-block; margin-bottom: 3px;">
                                    {{ $item->jadwal->kelas->nama_kelas ?? 'N/A' }}
                                </strong>
                                <br>
                                <span style="font-weight: 700; color: #334155;">{{ $item->jadwal->mapel->nama_mapel ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:28px; height:28px; border-radius:50%; background:#e0e7ff; color:#4f46e5; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:11px;">
                                        {{ strtoupper(substr($item->jadwal->guru->nama_guru ?? 'G', 0, 1)) }}
                                    </div>
                                    <span style="font-weight: 600;">{{ $item->jadwal->guru->nama_guru ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $statusClass }}">
                                    @if($item->status_kehadiran_guru == 'Hadir')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    @elseif($item->status_kehadiran_guru == 'Izin')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    @elseif($item->status_kehadiran_guru == 'Sakit')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                    @else
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    @endif
                                    {{ $item->status_kehadiran_guru }}
                                </span>
                            </td>
                            <td>
                                <div style="max-width: 250px; font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->materi }}">
                                    {{ $item->materi }}
                                </div>
                                @if($item->catatan)
                                    <small style="color: #64748b; font-style: italic; display: block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="Catatan: {{ $item->catatan }}">
                                        Catatan: {{ $item->catatan }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($absenceCount > 0)
                                    <span class="absence-pill has-absent" title="{{ $absenceCount }} siswa tidak hadir">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/></svg>
                                        {{ $absenceCount }} Siswa Absen
                                    </span>
                                @else
                                    <span class="absence-pill" style="color: #10b981; background: #ecfdf5; border: 1px solid #a7f3d0;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Nihil (Hadir Semua)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-flex">
                                    <a href="{{ route('jurnal-mengajar.show', $item->id_jurnal) }}" class="btn-act btn-act-detail" title="Detail Jurnal">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('jurnal-mengajar.edit', $item->id_jurnal) }}" class="btn-act btn-act-edit" title="Edit Jurnal">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('jurnal-mengajar.destroy', $item->id_jurnal) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-act btn-act-delete" title="Hapus Jurnal" onclick="confirmDelete(this.form, '{{ $item->jadwal->kelas->nama_kelas ?? 'Jurnal' }} - {{ $item->tanggal_formatted }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    <h3>Belum ada data jurnal mengajar</h3>
                                    <p>Klik tombol <strong>"Catat Jurnal Mengajar"</strong> untuk menginput data jurnal baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    // Toast Auto-Dismiss Logic
    let toastTimer;
    const toastCard = document.getElementById('toastCard');
    const toastContainer = document.getElementById('toastContainer');
    
    if (toastCard) {
        toastTimer = setTimeout(() => {
            dismissToast();
        }, 3500);
    }

    function dismissToast() {
        if (!toastCard) return;
        clearTimeout(toastTimer);
        toastCard.classList.add('hiding');
        setTimeout(() => {
            if (toastContainer) toastContainer.remove();
        }, 400);
    }

    // Filter Function
    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const statusSelect = document.getElementById('statusFilter').value;
        const table = document.getElementById('jurnalTable');
        const trs = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let i = 0; i < trs.length; i++) {
            const tr = trs[i];
            if (tr.getElementsByTagName('td').length <= 1) continue;

            const textContent = tr.innerText.toLowerCase();
            const rowStatus = tr.getAttribute('data-status');

            const matchesSearch = textContent.includes(input);
            const matchesStatus = !statusSelect || rowStatus === statusSelect;

            if (matchesSearch && matchesStatus) {
                tr.style.display = '';
            } else {
                tr.style.display = 'none';
            }
        }
    }

    // SweetAlert2 Hapus Konfirmasi
    function confirmDelete(form, name) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin memindahkan jurnal "${name}" ke Tempat Sampah?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

</body>
</html>
