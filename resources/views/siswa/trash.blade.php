@extends('layouts.admin')

@section('title', 'Tempat Sampah Siswa — EDU JOURNAL')

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

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
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
        font-size: 20px;
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
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-back-main {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .btn-back-main:hover { background: #e2e8f0; }

    .btn-alumni-link {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .btn-alumni-link:hover {
        background: #bae6fd;
        color: #0284c7;
    }
    .btn-alumni-link .badge-count {
        background: #0284c7;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    /* Bulk Action Bar */
    .bulk-action-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .bulk-info {
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .bulk-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-bulk {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-bulk-danger {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-bulk-danger:hover:not(:disabled) {
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }
    .btn-bulk-danger:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-bulk-alumni {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .btn-bulk-alumni:hover:not(:disabled) {
        background: #16a34a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    }
    .btn-bulk-alumni:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
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
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-kelas {
        background: #f1f5f9;
        color: #334155;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-block;
        border: 1px solid #e2e8f0;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-restore {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .btn-restore:hover {
        background: #16a34a;
        color: #ffffff;
    }

    .btn-to-alumni {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-to-alumni:hover {
        background: #0284c7;
        color: #ffffff;
    }

    .btn-force-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-force-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .mobile-only {
        display: none !important;
    }

    @media (max-width: 768px) {
        .page-header-container {
            margin-bottom: 14px !important;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            line-height: 1.25 !important;
        }

        .page-title-group p {
            font-size: 13px !important;
            line-height: 1.45 !important;
        }

        .breadcrumb-text {
            font-size: 13px !important;
            margin-bottom: 14px !important;
            flex-wrap: wrap !important;
        }

        .card {
            padding: 16px !important;
            border-radius: 16px !important;
            margin-bottom: 16px !important;
        }

        .card-top-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .card-top-header h2 {
            font-size: 19px !important;
            font-weight: 800 !important;
            letter-spacing: -0.3px !important;
        }

        .card-top-header p {
            font-size: 12.5px !important;
            line-height: 1.4 !important;
        }

        .header-actions-group {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .btn-header-action {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 16px !important;
            font-size: 13px !important;
        }

        .bulk-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            padding: 14px !important;
        }

        .bulk-buttons {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .btn-bulk {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 14px !important;
            font-size: 12.5px !important;
        }

        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: block !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
            background: transparent !important;
        }

        .table-custom {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .table-custom thead {
            display: none !important;
        }

        .table-custom tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        .table-custom tbody tr.trash-siswa-card {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            background: #ffffff !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 16px !important;
            padding: 14px 16px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) !important;
            width: 100% !important;
            box-sizing: border-box !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }

        .table-custom tbody tr.trash-siswa-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
        }

        .trash-card-header {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 10px !important;
        }

        .trash-card-title-group {
            display: flex !important;
            align-items: flex-start !important;
            gap: 10px !important;
            min-width: 0 !important;
            flex: 1 !important;
        }

        .trash-user-name {
            font-size: 14.5px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.35 !important;
            word-break: normal !important;
        }

        .trash-card-meta {
            background: #f8fafc !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 10px !important;
            padding: 8px 12px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
            font-size: 12px !important;
        }

        .trash-card-time {
            font-size: 11.5px !important;
            color: #64748b !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .trash-card-actions {
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 6px !important;
            width: 100% !important;
        }

        .trash-card-actions form {
            display: flex !important;
            width: 100% !important;
            margin: 0 !important;
        }

        .trash-card-actions .btn-act {
            width: 100% !important;
            justify-content: center !important;
            padding: 9px 4px !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            border-radius: 10px !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        /* Empty state */
        .table-custom tbody tr:not(.trash-siswa-card) {
            display: block !important;
            width: 100% !important;
            background: #ffffff !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 16px !important;
            padding: 24px !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        .table-custom tbody tr:not(.trash-siswa-card) td {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .card-top-header h2 {
            font-size: 18px !important;
        }

        .table-custom tbody tr.trash-siswa-card {
            padding: 12px 14px !important;
        }

        .trash-card-actions {
            grid-template-columns: 1fr 1fr !important;
        }

        .trash-card-actions .action-btn-force-wrap {
            grid-column: 1 / -1 !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tong Sampah — Data Siswa</h1>
            <p>Daftar data siswa yang telah dihapus sementara (soft delete)</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('siswa.index') }}"><i class="fa-solid fa-graduation-cap"></i> Data Siswa</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Siswa</span>
    </div>

    @if($errors->any())
        <div class="alert-custom alert-error">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size:18px;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-trash-can" style="color:#d97706;"></i> Tempat Sampah Siswa ({{ count($siswas) }})</h2>
                <p>Daftar siswa yang dihapus sementara. Anda dapat memulihkan, memindahkan ke Alumni, atau menghapus permanen.</p>
            </div>
            <div class="header-actions-group">
                <a href="{{ route('siswa.alumni') }}" class="btn-header-action btn-alumni-link">
                    <i class="fa-solid fa-user-graduate"></i> Data Siswa Alumni
                    @if(isset($alumniCount) && $alumniCount > 0)
                        <span class="badge-count">{{ $alumniCount }}</span>
                    @endif
                </a>
                <a href="{{ route('siswa.index') }}" class="btn-header-action btn-back-main">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Siswa
                </a>
            </div>
        </div>

        @if(count($siswas) > 0)
            <!-- Bulk Action Bar -->
            <div class="bulk-action-bar">
                <div class="bulk-info">
                    <i class="fa-solid fa-list-check" style="color:#3b5490;"></i>
                    <span id="selectedCountText">Pilih data siswa di bawah ini untuk aksi massal:</span>
                </div>
                <div class="bulk-buttons">
                    <button type="button" id="btnBulkMoveToAlumni" class="btn-bulk btn-bulk-alumni" disabled onclick="submitBulkMoveToAlumni()">
                        <i class="fa-solid fa-user-graduate"></i> Tambahkan ke Data Siswa Alumni (<span class="count-badge">0</span>)
                    </button>

                    <button type="button" id="btnBulkForceDelete" class="btn-bulk btn-bulk-danger" disabled onclick="submitBulkForceDelete()">
                        <i class="fa-solid fa-skull"></i> Hapus Permanen (<span class="count-badge">0</span>)
                    </button>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:40px; text-align:center;">
                            <input type="checkbox" id="selectAllCheckbox" style="width:17px; height:17px; cursor:pointer;" onclick="toggleSelectAll(this)" title="Pilih Semua / Deselect All">
                        </th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>NAMA SISWA</th>
                        <th>KELAS</th>
                        <th>WAKTU DIHAPUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $s)
                        <tr class="trash-siswa-card">
                            <!-- Desktop Checkbox / Mobile Header -->
                            <td class="col-checkbox">
                                <div class="desktop-only" style="text-align:center;">
                                    <input type="checkbox" name="ids[]" class="siswa-checkbox" value="{{ $s->id_siswa }}" style="width:17px; height:17px; cursor:pointer;" onchange="updateBulkButtonsState()">
                                </div>
                                <div class="mobile-only trash-card-header">
                                    <div class="trash-card-title-group">
                                        <input type="checkbox" name="ids[]" class="siswa-checkbox" value="{{ $s->id_siswa }}" style="width:18px; height:18px; cursor:pointer; accent-color:#e11d48; margin-top:2px; flex-shrink:0;" onchange="updateBulkButtonsState()">
                                        <strong class="trash-user-name">{{ $s->nama_siswa }}</strong>
                                    </div>
                                    <span class="badge-kelas" style="flex-shrink:0;">
                                        {{ $s->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Desktop NIS -->
                            <td class="col-nis desktop-only">
                                <strong>{{ $s->nis ?? '-' }}</strong>
                            </td>

                            <!-- NISN & Meta -->
                            <td class="col-meta">
                                <div class="desktop-only">
                                    <span style="font-family:monospace; color:#3b5490;">{{ $s->nisn }}</span>
                                </div>
                                <div class="mobile-only trash-card-meta">
                                    <div style="font-size:12.5px; font-weight:700; color:#3b5490;">
                                        <i class="fa-solid fa-id-card" style="margin-right:4px;"></i> NIS: {{ $s->nis ?? '-' }} | NISN: {{ $s->nisn }}
                                    </div>
                                </div>
                            </td>

                            <!-- Desktop Nama -->
                            <td class="col-nama desktop-only">
                                <strong>{{ $s->nama_siswa }}</strong>
                            </td>

                            <!-- Desktop Kelas -->
                            <td class="col-kelas desktop-only">
                                {{ $s->kelas->nama_kelas ?? '-' }}
                            </td>

                            <!-- Waktu Dihapus -->
                            <td class="col-waktu">
                                <div class="desktop-only">
                                    {{ $s->deleted_at ? \Carbon\Carbon::parse($s->deleted_at)->format('d/m/Y H:i') : '-' }}
                                </div>
                                <div class="mobile-only trash-card-time">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Dihapus: <strong>{{ $s->deleted_at ? \Carbon\Carbon::parse($s->deleted_at)->format('d/m/Y H:i') : '-' }}</strong>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="col-aksi" style="text-align:center;">
                                <div class="desktop-only" style="display:inline-flex; gap:6px; flex-wrap:wrap; justify-content:center;">
                                    <form action="{{ route('siswa.restore', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" title="Pulihkan Siswa Kembali ke Data Siswa Aktif">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.move-to-alumni', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-to-alumni" onclick="return confirm('Pindahkan siswa {{ addslashes($s->nama_siswa) }} ke Data Siswa Alumni?')" title="Pindahkan ke Data Siswa Alumni">
                                            <i class="fa-solid fa-user-graduate"></i> Ke Alumni
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.force-delete', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-force-delete" onclick="return confirm('Hapus PERMANEN siswa {{ addslashes($s->nama_siswa) }}? Data tidak bisa dikembalikan lagi!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>

                                <div class="mobile-only trash-card-actions">
                                    <form action="{{ route('siswa.restore', $s->id_siswa) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" title="Pulihkan Siswa Kembali ke Data Siswa Aktif">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.move-to-alumni', $s->id_siswa) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-act btn-to-alumni" onclick="return confirm('Pindahkan siswa {{ addslashes($s->nama_siswa) }} ke Data Siswa Alumni?')" title="Pindahkan ke Data Siswa Alumni">
                                            <i class="fa-solid fa-user-graduate"></i> Ke Alumni
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.force-delete', $s->id_siswa) }}" method="POST" class="action-btn-force-wrap">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-force-delete" onclick="return confirm('Hapus PERMANEN siswa {{ addslashes($s->nama_siswa) }}? Data tidak bisa dikembalikan lagi!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Tempat sampah kosong. Tidak ada data siswa yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hidden Form Bulk Force Delete -->
    <form id="bulkForceDeleteForm" action="{{ route('siswa.force-delete-batch') }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
        <div id="bulkForceDeleteInputs"></div>
    </form>

    <!-- Hidden Form Bulk Move To Alumni -->
    <form id="bulkMoveToAlumniForm" action="{{ route('siswa.move-to-alumni-batch') }}" method="POST" style="display:none;">
        @csrf
        <div id="bulkMoveToAlumniInputs"></div>
    </form>

@endsection

@section('scripts')
<script>
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.siswa-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBulkButtonsState();
    }

    function updateBulkButtonsState() {
        const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
        const checkedCount = checkedBoxes.length;
        const totalCount = document.querySelectorAll('.siswa-checkbox').length;
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (totalCount > 0 && checkedCount === totalCount);
        }

        const btnForceDelete = document.getElementById('btnBulkForceDelete');
        const btnMoveToAlumni = document.getElementById('btnBulkMoveToAlumni');
        const selectedCountText = document.getElementById('selectedCountText');

        if (btnForceDelete && btnMoveToAlumni) {
            if (checkedCount > 0) {
                btnForceDelete.disabled = false;
                btnMoveToAlumni.disabled = false;
                btnForceDelete.querySelector('.count-badge').textContent = checkedCount;
                btnMoveToAlumni.querySelector('.count-badge').textContent = checkedCount;
                if (selectedCountText) {
                    selectedCountText.innerHTML = `Terpilih <strong>${checkedCount}</strong> dari ${totalCount} data siswa:`;
                }
            } else {
                btnForceDelete.disabled = true;
                btnMoveToAlumni.disabled = true;
                btnForceDelete.querySelector('.count-badge').textContent = '0';
                btnMoveToAlumni.querySelector('.count-badge').textContent = '0';
                if (selectedCountText) {
                    selectedCountText.textContent = 'Pilih data siswa di bawah ini untuk aksi massal:';
                }
            }
        }
    }

    function submitBulkForceDelete() {
        const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) return;

        if (confirm(`APAKAH ANDA YAKIN INGIN MENGHAPUS PERMANEN ${count} DATA SISWA YANG DIPILIH?\n\nPerhatian: Data yang dihapus secara permanen TIDAK BISA DIKEMBALIKAN lagi!`)) {
            const inputsContainer = document.getElementById('bulkForceDeleteInputs');
            inputsContainer.innerHTML = '';
            checkedBoxes.forEach(cb => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ids[]';
                hiddenInput.value = cb.value;
                inputsContainer.appendChild(hiddenInput);
            });
            document.getElementById('bulkForceDeleteForm').submit();
        }
    }

    function submitBulkMoveToAlumni() {
        const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) return;

        if (confirm(`Pindahkan ${count} data siswa terpilih ke Data Siswa Alumni?`)) {
            const inputsContainer = document.getElementById('bulkMoveToAlumniInputs');
            inputsContainer.innerHTML = '';
            checkedBoxes.forEach(cb => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ids[]';
                hiddenInput.value = cb.value;
                inputsContainer.appendChild(hiddenInput);
            });
            document.getElementById('bulkMoveToAlumniForm').submit();
        }
    }
</script>
@endsection
