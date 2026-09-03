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
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
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

    @if(session('success'))
        <div class="alert-custom alert-success">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

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
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
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
                        <tr>
                            <td style="text-align:center;">
                                <input type="checkbox" name="ids[]" class="siswa-checkbox" value="{{ $s->id_siswa }}" style="width:17px; height:17px; cursor:pointer;" onchange="updateBulkButtonsState()">
                            </td>
                            <td><strong>{{ $s->nis ?? '-' }}</strong></td>
                            <td><span style="font-family:monospace; color:#3b5490;">{{ $s->nisn }}</span></td>
                            <td><strong>{{ $s->nama_siswa }}</strong></td>
                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $s->deleted_at ? \Carbon\Carbon::parse($s->deleted_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:6px; flex-wrap:wrap; justify-content:center;">
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
        const checkedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
        const totalCount = document.querySelectorAll('.siswa-checkbox').length;
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (totalCount > 0 && checkedCount === totalCount);
        }

        const btnForceDelete = document.getElementById('btnBulkForceDelete');
        const btnMoveToAlumni = document.getElementById('btnBulkMoveToAlumni');
        const selectedCountText = document.getElementById('selectedCountText');

        if (checkedCount > 0) {
            btnForceDelete.disabled = false;
            btnMoveToAlumni.disabled = false;
            btnForceDelete.querySelector('.count-badge').textContent = checkedCount;
            btnMoveToAlumni.querySelector('.count-badge').textContent = checkedCount;
            selectedCountText.innerHTML = `Terpilih <strong>${checkedCount}</strong> dari ${totalCount} data siswa:`;
        } else {
            btnForceDelete.disabled = true;
            btnMoveToAlumni.disabled = true;
            btnForceDelete.querySelector('.count-badge').textContent = '0';
            btnMoveToAlumni.querySelector('.count-badge').textContent = '0';
            selectedCountText.textContent = 'Pilih data siswa di bawah ini untuk aksi massal:';
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
