@extends('layouts.guru')

@section('title', 'Sampah Riwayat Jurnal — EDU JOURNAL')
@section('header_title', 'Sampah Riwayat Jurnal')

@section('styles')
<style>
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

    /* Batch Selection Bar */
    .batch-bar {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 16px;
        display: none;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .batch-info {
        font-size: 13.5px;
        font-weight: 800;
        color: #991b1b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

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
        background: #fff1f2;
    }

    .custom-checkbox {
        width: 17px;
        height: 17px;
        accent-color: #dc2626;
        cursor: pointer;
    }

    .btn-action-restore {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .btn-action-restore:hover {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-action-force {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .btn-action-force:hover {
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
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border: 1px solid #cbd5e1;
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body-custom {
        padding: 22px;
    }

    .modal-footer-custom {
        padding: 16px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
    }

    .btn-modal-cancel {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-modal-danger {
        background: #dc2626;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-modal-success {
        background: #16a34a;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
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
                <i class="fa-solid fa-trash-can" style="color: #dc2626;"></i>
                Sampah Riwayat Jurnal
            </h1>
            <p class="page-subtitle">
                Data jurnal mengajar yang telah dipindahkan ke tempat sampah (dapat dipulihkan atau dihapus permanen)
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('guru.riwayat-jurnal') }}" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
            </a>

            @if($trashedJurnals->isNotEmpty())
                <button type="button" onclick="openRestoreAllModal()" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 9px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Semua
                </button>
                <button type="button" onclick="openEmptyTrashModal()" style="background: #dc2626; color: #ffffff; border: none; padding: 9px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                </button>
            @endif
        </div>
    </div>

    <!-- Batch Selection Toolbar -->
    <div class="batch-bar" id="batchBar">
        <div class="batch-info">
            <i class="fa-solid fa-circle-check"></i>
            <span><strong id="batchCount">0</strong> data sampah dipilih</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <button type="button" class="btn-action-restore" onclick="submitBatchRestore()">
                <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
            </button>
            <button type="button" class="btn-action-force" onclick="openBatchForceDeleteModal()">
                <i class="fa-solid fa-triangle-exclamation"></i> Hapus Permanen Terpilih
            </button>
            <button type="button" class="btn-modal-cancel" onclick="uncheckAllRows()" style="padding: 6px 10px; font-size: 12px;">
                <i class="fa-solid fa-xmark"></i> Batal
            </button>
        </div>
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
                        <th style="width: 130px;">WAKTU DIHAPUS</th>
                        <th style="width: 120px;">TANGGAL KBM</th>
                        <th style="width: 130px;">KELAS</th>
                        <th style="width: 160px;">MAPEL</th>
                        <th>MATERI PEMBELAJARAN</th>
                        <th style="width: 110px;">STATUS GURU</th>
                        <th style="width: 190px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedJurnals as $idx => $j)
                        @php
                            $carbonTgl = \Carbon\Carbon::parse($j->tanggal);
                            $carbonDeleted = \Carbon\Carbon::parse($j->deleted_at);
                            $kelasNama = $j->jadwal && $j->jadwal->kelas ? $j->jadwal->kelas->nama_kelas : '-';
                            $mapelNama = $j->jadwal && $j->jadwal->mapel ? $j->jadwal->mapel->nama_mapel : '-';
                        @endphp
                        <tr id="row_{{ $j->id_jurnal }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="row-checkbox custom-checkbox" value="{{ $j->id_jurnal }}" onchange="handleRowCheckboxChange(this)">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $idx + 1 }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #dc2626;">{{ $carbonDeleted->format('d/m/Y') }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">{{ $carbonDeleted->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $carbonTgl->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <strong style="color: #1e293b;">{{ $kelasNama }}</strong>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $mapelNama }}</div>
                                <div style="font-size: 11px; color: #64748b;">Pertemuan Ke-{{ $j->pertemuan_ke ?: '1' }}</div>
                            </td>
                            <td>
                                <div style="line-height: 1.5; font-weight: 600; color: #475569; max-width: 320px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $j->materi ?: '-' }}
                                </div>
                            </td>
                            <td>
                                <span style="font-size: 11.5px; font-weight: 800; padding: 2px 8px; border-radius: 6px; background: #f1f5f9; color: #334155;">
                                    {{ $j->status_kehadiran_guru }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <form method="POST" action="{{ route('guru.riwayat-jurnal.restore', $j->id_jurnal) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action-restore" title="Pulihkan data jurnal ini">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>
                                    <button type="button" class="btn-action-force" onclick="openSingleForceDeleteModal({{ $j->id_jurnal }}, '{{ $carbonTgl->format('d/m/Y') }}', '{{ $kelasNama }}', '{{ addslashes($mapelNama) }}')" title="Hapus permanen data ini">
                                        <i class="fa-solid fa-trash"></i> Hapus Permanen
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 48px 20px;">
                                <div style="color: #94a3b8; margin-bottom: 12px;">
                                    <i class="fa-solid fa-trash-can-arrow-up" style="font-size: 42px; color: #cbd5e1;"></i>
                                </div>
                                <div style="font-size: 16px; font-weight: 800; color: #334155;">Tempat Sampah Kosong</div>
                                <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
                                    Tidak ada data jurnal mengajar di dalam tempat sampah saat ini.
                                </div>
                                <div style="margin-top: 16px;">
                                    <a href="{{ route('guru.riwayat-jurnal') }}" style="background: #2563eb; color: #ffffff; padding: 8px 18px; border-radius: 10px; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Jurnal
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hidden Forms for Batch Operations -->
    <form id="formBatchRestore" method="POST" action="{{ route('guru.riwayat-jurnal.restore-batch') }}" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="batchRestoreIds">
    </form>

    <form id="formRestoreAll" method="POST" action="{{ route('guru.riwayat-jurnal.restore-all') }}" style="display: none;">
        @csrf
    </form>

    <form id="formEmptyTrash" method="POST" action="{{ route('guru.riwayat-jurnal.empty-trash') }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Modal 1: Single Force Delete -->
    <div class="modal-backdrop-custom" id="modalSingleForce" onclick="if(event.target === this) closeSingleForceModal()">
        <div class="modal-box-custom">
            <div class="modal-header-custom" style="background: #fef2f2;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #991b1b; margin: 0;">Hapus Permanen?</h3>
                </div>
                <button type="button" onclick="closeSingleForceModal()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px; line-height: 1.5;">
                    Data jurnal mengajar berikut akan dihapus secara <strong>PERMANEN</strong> dari database beserta seluruh catatan presensi terkait. Tindakan ini <strong>tidak dapat dibatalkan</strong>!
                </p>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; font-size: 13px;">
                    <div><strong>Tanggal KBM:</strong> <span id="forceSingleTgl">-</span></div>
                    <div><strong>Kelas:</strong> <span id="forceSingleKelas">-</span></div>
                    <div><strong>Mapel:</strong> <span id="forceSingleMapel">-</span></div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <form id="formSingleForce" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeSingleForceModal()" class="btn-modal-cancel">Batal</button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa-solid fa-trash-can"></i> Ya, Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Batch Force Delete -->
    <div class="modal-backdrop-custom" id="modalBatchForce" onclick="if(event.target === this) closeBatchForceModal()">
        <div class="modal-box-custom">
            <div class="modal-header-custom" style="background: #fef2f2;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #991b1b; margin: 0;">Hapus Permanen Terpilih?</h3>
                </div>
                <button type="button" onclick="closeBatchForceModal()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px; line-height: 1.5;">
                    Anda akan menghapus <strong id="forceBatchCountText" style="color: #dc2626;">0</strong> data jurnal secara <strong>PERMANEN</strong>. Data yang dihapus tidak akan bisa dikembalikan lagi!
                </p>
            </div>
            <div class="modal-footer-custom">
                <form id="formBatchForce" method="POST" action="{{ route('guru.riwayat-jurnal.force-delete-batch') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="forceBatchIdsInput" value="">
                    <button type="button" onclick="closeBatchForceModal()" class="btn-modal-cancel">Batal</button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa-solid fa-trash-can"></i> Ya, Hapus Permanen Semua
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 3: Restore All Confirmation -->
    <div class="modal-backdrop-custom" id="modalRestoreAll" onclick="if(event.target === this) closeRestoreAllModal()">
        <div class="modal-box-custom">
            <div class="modal-header-custom" style="background: #f0fdf4;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-rotate-left" style="font-size: 18px; color: #16a34a;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #15803d; margin: 0;">Pulihkan Seluruh Sampah?</h3>
                </div>
                <button type="button" onclick="closeRestoreAllModal()" style="background: none; border: none; color: #15803d; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 0; line-height: 1.5;">
                    Seluruh data jurnal mengajar di tempat sampah akan dipulihkan dan dikembalikan ke daftar riwayat aktif. Lanjutkan?
                </p>
            </div>
            <div class="modal-footer-custom">
                <button type="button" onclick="closeRestoreAllModal()" class="btn-modal-cancel">Batal</button>
                <button type="button" onclick="document.getElementById('formRestoreAll').submit()" class="btn-modal-success">
                    <i class="fa-solid fa-rotate-left"></i> Ya, Pulihkan Semua
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 4: Empty Trash Confirmation -->
    <div class="modal-backdrop-custom" id="modalEmptyTrash" onclick="if(event.target === this) closeEmptyTrashModal()">
        <div class="modal-box-custom">
            <div class="modal-header-custom" style="background: #fef2f2;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-dumpster" style="font-size: 18px; color: #dc2626;"></i>
                    <h3 style="font-size: 15px; font-weight: 800; color: #991b1b; margin: 0;">Kosongkan Tempat Sampah?</h3>
                </div>
                <button type="button" onclick="closeEmptyTrashModal()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 0; line-height: 1.5;">
                    Seluruh data jurnal di dalam tempat sampah akan dihapus secara <strong>PERMANEN</strong> dan tidak dapat dipulihkan kembali. Anda yakin?
                </p>
            </div>
            <div class="modal-footer-custom">
                <button type="button" onclick="closeEmptyTrashModal()" class="btn-modal-cancel">Batal</button>
                <button type="button" onclick="document.getElementById('formEmptyTrash').submit()" class="btn-modal-danger">
                    <i class="fa-solid fa-dumpster"></i> Ya, Kosongkan Sekarang
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const batchBar = document.getElementById('batchBar');
    const batchCount = document.getElementById('batchCount');

    function updateBatchBar() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;

        if (count > 0) {
            batchBar.style.display = 'flex';
            batchCount.textContent = count;
        } else {
            batchBar.style.display = 'none';
            batchCount.textContent = 0;
        }

        rowCheckboxes.forEach(cb => {
            const tr = document.getElementById('row_' + cb.value);
            if (tr) {
                if (cb.checked) tr.classList.add('selected-row');
                else tr.classList.remove('selected-row');
            }
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (count === rowCheckboxes.length && rowCheckboxes.length > 0);
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            rowCheckboxes.forEach(cb => cb.checked = isChecked);
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

    function submitBatchRestore() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        document.getElementById('batchRestoreIds').value = ids.join(',');
        document.getElementById('formBatchRestore').submit();
    }

    // Modal Single Force Delete
    const modalSingleForce = document.getElementById('modalSingleForce');
    const formSingleForce = document.getElementById('formSingleForce');

    function openSingleForceDeleteModal(id, tanggal, kelas, mapel) {
        document.getElementById('forceSingleTgl').textContent = tanggal;
        document.getElementById('forceSingleKelas').textContent = kelas;
        document.getElementById('forceSingleMapel').textContent = mapel;
        formSingleForce.action = "{{ url('/guru-riwayat-jurnal-trash') }}/" + id + "/force";
        modalSingleForce.style.display = 'flex';
    }

    function closeSingleForceModal() {
        modalSingleForce.style.display = 'none';
    }

    // Modal Batch Force Delete
    const modalBatchForce = document.getElementById('modalBatchForce');

    function openBatchForceDeleteModal() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        document.getElementById('forceBatchCountText').textContent = ids.length;
        document.getElementById('forceBatchIdsInput').value = ids.join(',');
        modalBatchForce.style.display = 'flex';
    }

    function closeBatchForceModal() {
        modalBatchForce.style.display = 'none';
    }

    // Modal Restore All
    const modalRestoreAll = document.getElementById('modalRestoreAll');
    function openRestoreAllModal() { modalRestoreAll.style.display = 'flex'; }
    function closeRestoreAllModal() { modalRestoreAll.style.display = 'none'; }

    // Modal Empty Trash
    const modalEmptyTrash = document.getElementById('modalEmptyTrash');
    function openEmptyTrashModal() { modalEmptyTrash.style.display = 'flex'; }
    function closeEmptyTrashModal() { modalEmptyTrash.style.display = 'none'; }

    // Escape listener
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSingleForceModal();
            closeBatchForceModal();
            closeRestoreAllModal();
            closeEmptyTrashModal();
        }
    });
</script>
@endsection