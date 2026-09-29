@extends('layouts.admin')

@section('title', 'Tempat Sampah Jurnal Mengajar — EDU JOURNAL')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 13.5px;
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
    .breadcrumb-text a:hover {
        text-decoration: underline;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card-trash {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-top-header p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    .btn-back-main {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }
    .btn-back-main:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Filter & Search Bar */
    .filter-section-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 38px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .search-input-wrapper input:focus {
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13.5px;
    }

    .filter-control-date, .filter-select {
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
    }

    .btn-filter-submit {
        background: #384972;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-filter-submit:hover { background: #2b395a; }

    .btn-filter-reset {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Batch Action Toolbar */
    .batch-toolbar {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 12px 18px;
        margin-bottom: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .batch-left {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .batch-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-batch-restore {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-batch-restore:hover { background: #059669; }

    .btn-batch-force {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-batch-force:hover { background: #dc2626; }

    .btn-empty-trash {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-empty-trash:hover { background: #fecaca; }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .table-trash {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
    }

    .table-trash th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 13px 14px;
        text-align: left;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-trash td {
        padding: 13px 14px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-trash tbody tr:hover {
        background: #f8fafc;
    }

    .custom-checkbox {
        width: 17px;
        height: 17px;
        accent-color: #384972;
        cursor: pointer;
    }

    .btn-row-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-restore-single {
        background: #d1fae5;
        color: #065f46;
    }
    .btn-restore-single:hover {
        background: #a7f3d0;
        color: #064e3b;
    }

    .btn-force-single {
        background: #fee2e2;
        color: #991b1b;
    }
    .btn-force-single:hover {
        background: #fecaca;
        color: #7f1d1d;
    }

    .pagination-bar {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Desktop helper states */
    .trash-card-header-line { display: none; }
    .desktop-only-date { display: block; }
    .desktop-only-kelas { display: table-cell; }
    .mobile-only-kelas { display: none; }
    .filter-trash-selects-grid { display: contents; }
    .filter-trash-btn-group { display: contents; }

    /* ════════════════════════════════════════════════════════════════
       RESPONSIVE MOBILE (HP) STYLES (Screen <= 768px)
       ════════════════════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .breadcrumb-text {
            font-size: 12px;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .card-trash {
            padding: 16px 14px;
            border-radius: 18px;
            margin-bottom: 18px;
        }

        .card-top-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 16px;
        }

        .card-top-header h2 {
            font-size: 18px;
        }

        .card-top-header p {
            font-size: 12px;
            line-height: 1.4;
        }

        .btn-back-main {
            width: 100%;
            justify-content: center;
            padding: 10px;
            box-sizing: border-box;
            font-size: 12.5px;
        }

        /* Filter Section Bar */
        .filter-section-bar {
            padding: 14px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .search-input-wrapper {
            width: 100%;
            min-width: 100%;
        }

        .filter-control-date {
            width: 100%;
            box-sizing: border-box;
        }

        .filter-trash-selects-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
        }

        .filter-trash-selects-grid select {
            width: 100%;
            box-sizing: border-box;
        }

        .filter-trash-btn-group {
            display: flex !important;
            gap: 8px;
            width: 100%;
        }

        .btn-filter-submit,
        .btn-filter-reset {
            flex: 1;
            justify-content: center;
            padding: 10px;
            border-radius: 12px;
            font-size: 13px;
            box-sizing: border-box;
        }

        /* Batch Toolbar */
        .batch-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .batch-left {
            justify-content: space-between;
            width: 100%;
        }

        .batch-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-batch-restore,
        .btn-batch-force,
        .btn-empty-trash {
            width: 100%;
            justify-content: center;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Table Trash into Mobile Cards */
        .table-responsive {
            overflow: visible;
            border: none;
        }

        .table-trash {
            display: block;
            width: 100%;
        }

        .table-trash thead {
            display: none !important;
        }

        .table-trash tbody {
            display: block;
            width: 100%;
        }

        .trash-row-card {
            display: flex !important;
            flex-direction: column;
            gap: 8px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            position: relative;
        }

        .trash-row-card td {
            display: block;
            padding: 0;
            border: none;
        }

        .trash-card-header-line {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .trash-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .desktop-only-date {
            display: none !important;
        }

        .desktop-only-kelas {
            display: none !important;
        }

        .mobile-only-kelas {
            display: inline-flex !important;
        }

        .trash-date-text {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
        }

        .trash-date-text small {
            color: #64748b;
            font-weight: 600;
            font-size: 12px;
        }

        .badge-kelas-trash {
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 800;
            font-size: 11.5px;
            padding: 3px 9px;
            border-radius: 8px;
            border: 1px solid #bfdbfe;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .trash-guru-wrapper {
            margin-top: 2px;
        }

        .trash-guru-name {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .trash-mapel-pill {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            font-size: 11.5px;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .trash-materi-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12.5px;
            line-height: 1.45;
        }

        .trash-materi-title {
            color: #0f172a;
            font-weight: 600;
        }

        .trash-catatan-text {
            margin-top: 4px;
            padding-top: 4px;
            border-top: 1px dashed #e2e8f0;
            color: #64748b;
        }

        .trash-deleted-badge {
            background: #fee2e2;
            color: #991b1b;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            border: 1px solid #fca5a5;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .trash-action-group {
            display: flex !important;
            gap: 8px;
            width: 100%;
            margin-top: 4px;
            padding-top: 8px;
            border-top: 1px solid #f1f5f9;
        }

        .trash-action-group form {
            flex: 1 !important;
            margin: 0 !important;
        }

        .trash-action-group .btn-row-action {
            width: 100%;
            height: 38px;
            justify-content: center;
            font-size: 12.5px;
            box-sizing: border-box;
        }

        .trash-empty-row td {
            display: block !important;
            width: 100%;
            box-sizing: border-box;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 14px;
            padding: 30px 14px !important;
            text-align: center;
        }

        /* Pagination */
        .custom-pagination-bar {
            flex-direction: column !important;
            gap: 12px !important;
            align-items: center !important;
            text-align: center !important;
        }

        .custom-pagination-bar .pagination-info {
            font-size: 12px !important;
            text-align: center !important;
        }

        .custom-pagination-bar .pagination-list {
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .custom-pagination-bar .page-link {
            padding: 6px 12px !important;
            font-size: 13px !important;
            min-width: 34px !important;
            height: 34px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    }

    @media (max-width: 420px) {
        .filter-trash-selects-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-text">
        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.jurnal-mengajar') }}">Jurnal Mengajar</a>
        <span>/</span>
        <span>Tempat Sampah</span>
    </div>

    <div class="card-trash">
        <div class="card-top-header">
            <div>
                <h2>
                    <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i>
                    Kotak Sampah Jurnal Mengajar
                </h2>
                <p>Kelola data jurnal mengajar yang telah dihapus sementara (Soft Delete). Anda dapat memulihkan data atau menghapusnya secara permanen.</p>
            </div>

            <a href="{{ route('admin.jurnal-mengajar') }}" class="btn-back-main">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Jurnal Mengajar</span>
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <form action="{{ route('admin.jurnal-mengajar.trash') }}" method="GET" class="filter-section-bar">
            <div class="search-input-wrapper">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari materi, catatan, guru, atau mapel...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-control-date" title="Filter Tanggal Mengajar">

            <div class="filter-trash-selects-grid">
                <select name="id_guru" class="filter-select">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}" {{ ($idGuru == $g->id_guru) ? 'selected' : '' }}>
                            {{ $g->nama_guru }}
                        </option>
                    @endforeach
                </select>

                <select name="id_kelas" class="filter-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($idKelas == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-trash-btn-group">
                <button type="submit" class="btn-filter-submit">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                @if(!empty($search) || !empty($tanggal) || !empty($idGuru) || !empty($idKelas))
                    <a href="{{ route('admin.jurnal-mengajar.trash') }}" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Batch Toolbar -->
        <div class="batch-toolbar">
            <div class="batch-left">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none;">
                    <input type="checkbox" id="selectAllTrash" class="custom-checkbox" onchange="toggleSelectAll(this)">
                    <span>Pilih Semua Data</span>
                </label>
                <span id="selectedCountText" style="color: #3b5490; font-weight: 800; display: none;">(0 data dipilih)</span>
            </div>

            <div class="batch-actions">
                <button type="button" class="btn-batch-restore" id="btnBatchRestore" onclick="submitBatchRestore()" style="display: none;">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Pulihkan Terpilih</span>
                </button>

                <button type="button" class="btn-batch-force" id="btnBatchForce" onclick="submitBatchForce()" style="display: none;">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Hapus Permanen Terpilih</span>
                </button>

                @if($trashedCount > 0)
                    <form action="{{ route('admin.jurnal-mengajar.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin MENGOSONGKAN SELURUH kotak sampah jurnal mengajar? Semua data di sampah akan dihapus PERMANEN dan tidak dapat dipulihkan!')" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-empty-trash" title="Hapus semua data di tempat sampah">
                            <i class="fa-solid fa-fire"></i>
                            <span>Kosongkan Kotak Sampah ({{ $trashedCount }})</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Hidden Forms for Batch Operations -->
        <form id="formBatchRestore" action="{{ route('admin.jurnal-mengajar.restore-batch') }}" method="POST" style="display: none;">
            @csrf
            <div id="batchRestoreInputs"></div>
        </form>

        <form id="formBatchForce" action="{{ route('admin.jurnal-mengajar.force-delete-batch') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <div id="batchForceInputs"></div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table-trash">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">#</th>
                        <th style="width: 100px;">TANGGAL</th>
                        <th>GURU & MAPEL</th>
                        <th style="width: 90px;">KELAS</th>
                        <th>MATERI / CATATAN</th>
                        <th style="width: 140px;">DIHAPUS PADA</th>
                        <th style="width: 160px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedJurnals as $j)
                        <tr class="trash-row-card">
                            <td class="trash-col-checkbox" style="text-align: center;">
                                <input type="checkbox" class="custom-checkbox trash-item-checkbox" value="{{ $j->id_jurnal }}" onchange="handleItemCheck()">
                            </td>
                            <td class="trash-col-tanggal">
                                <div class="trash-card-header-line">
                                    <div class="trash-header-left">
                                        <span class="trash-date-text">
                                            <i class="fa-regular fa-calendar" style="color: #384972; margin-right: 4px;"></i>
                                            <strong>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</strong>
                                            <small>({{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l') }})</small>
                                        </span>
                                    </div>
                                    <span class="badge-kelas-trash mobile-only-kelas">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        {{ $j->jadwal->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </div>
                                <div class="desktop-only-date">
                                    <strong>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</strong><br>
                                    <small style="color: #64748b;">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l') }}</small>
                                </div>
                            </td>
                            <td class="trash-col-guru">
                                <div class="trash-guru-wrapper">
                                    <div class="trash-guru-name">
                                        <i class="fa-solid fa-chalkboard-user" style="color: #384972;"></i>
                                        <strong>{{ $j->jadwal->guru->nama_guru ?? '-' }}</strong>
                                    </div>
                                    <div class="trash-mapel-pill">
                                        <i class="fa-solid fa-book-open"></i>
                                        {{ $j->jadwal->mapel->nama_mapel ?? '-' }}
                                    </div>
                                </div>
                            </td>
                            <td class="trash-col-kelas desktop-only-kelas">
                                <strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong>
                            </td>
                            <td class="trash-col-materi">
                                <div class="trash-materi-box">
                                    <div class="trash-materi-title">
                                        <i class="fa-solid fa-pen-nib" style="color: #384972; margin-right: 4px;"></i>
                                        <strong>Materi:</strong> {{ Str::limit($j->materi, 50) }}
                                    </div>
                                    @if($j->catatan)
                                        <div class="trash-catatan-text">
                                            <i class="fa-regular fa-comment-dots" style="color: #64748b; margin-right: 4px;"></i>
                                            <small><strong>Catatan:</strong> {{ Str::limit($j->catatan, 35) }}</small>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="trash-col-dihapus">
                                <div class="trash-deleted-badge">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>Dihapus: {{ $j->deleted_at ? \Carbon\Carbon::parse($j->deleted_at)->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </td>
                            <td class="trash-col-aksi">
                                <div class="trash-action-group">
                                    <!-- Restore Single Form -->
                                    <form action="{{ route('admin.jurnal-mengajar.restore', $j->id_jurnal) }}" method="POST" style="margin: 0; flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn-row-action btn-restore-single" title="Pulihkan jurnal ini">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            <span>Pulihkan</span>
                                        </button>
                                    </form>

                                    <!-- Force Delete Single Form -->
                                    <form action="{{ route('admin.jurnal-mengajar.force-delete', $j->id_jurnal) }}" method="POST" onsubmit="return confirm('Hapus permanen jurnal {{ addslashes($j->jadwal->guru->nama_guru ?? '') }} (Tanggal: {{ $j->tanggal }})? Tindakan ini tidak dapat dibatalkan!')" style="margin: 0; flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-row-action btn-force-single" title="Hapus permanen jurnal ini">
                                            <i class="fa-solid fa-xmark"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="trash-empty-row">
                            <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                                <i class="fa-regular fa-trash-can" style="font-size: 32px; margin-bottom: 10px; display: block; color: #94a3b8;"></i>
                                Kotak sampah jurnal mengajar kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($trashedJurnals->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #ffffff;">
                {{ $trashedJurnals->withQueryString()->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>

@endsection

@section('scripts')
<script>
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.trash-item-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBatchButtons();
    }

    function handleItemCheck() {
        const checkboxes = document.querySelectorAll('.trash-item-checkbox');
        const master = document.getElementById('selectAllTrash');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        if (master) {
            master.checked = allChecked && checkboxes.length > 0;
        }
        updateBatchButtons();
    }

    function updateBatchButtons() {
        const checkedItems = document.querySelectorAll('.trash-item-checkbox:checked');
        const count = checkedItems.length;
        const btnRestore = document.getElementById('btnBatchRestore');
        const btnForce = document.getElementById('btnBatchForce');
        const countText = document.getElementById('selectedCountText');

        if (count > 0) {
            btnRestore.style.display = 'inline-flex';
            btnForce.style.display = 'inline-flex';
            countText.style.display = 'inline-block';
            countText.textContent = `(${count} data dipilih)`;
        } else {
            btnRestore.style.display = 'none';
            btnForce.style.display = 'none';
            countText.style.display = 'none';
        }
    }

    function submitBatchRestore() {
        const checkedItems = document.querySelectorAll('.trash-item-checkbox:checked');
        if (checkedItems.length === 0) return;

        if (!confirm(`Apakah Anda yakin ingin memulihkan ${checkedItems.length} data jurnal mengajar terpilih?`)) {
            return;
        }

        const container = document.getElementById('batchRestoreInputs');
        container.innerHTML = '';
        checkedItems.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('formBatchRestore').submit();
    }

    function submitBatchForce() {
        const checkedItems = document.querySelectorAll('.trash-item-checkbox:checked');
        if (checkedItems.length === 0) return;

        if (!confirm(`PERINGATAN: Apakah Anda yakin ingin MENGHAPUS PERMANEN ${checkedItems.length} data jurnal mengajar terpilih? Tindakan ini tidak dapat dibatalkan!`)) {
            return;
        }

        const container = document.getElementById('batchForceInputs');
        container.innerHTML = '';
        checkedItems.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('formBatchForce').submit();
    }
</script>
@endsection
