@extends('layouts.guru')

@section('title', 'Tempat Sampah Surat Dispen — EDU JOURNAL')
@section('header_title', 'Tempat Sampah Surat Dispen')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-title-group h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title-group p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* Top Stats Card */
    .trash-stat-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 16px;
    }

    .stat-badge-group {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-trash {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #fef2f2;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-trash-text h3 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .stat-trash-text span {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    /* Actions */
    .btn-kembali {
        background: #f1f5f9;
        color: #475569;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-kembali:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-restore-all {
        background: #10b981;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }
    .btn-restore-all:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-empty-trash {
        background: #ef4444;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }
    .btn-empty-trash:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* Floating Batch Toolbar */
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

    /* Table Custom */
    .trash-table-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom thead th {
        background: #f8fafc;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 14px 16px;
        text-align: left;
        border-bottom: 2px solid #cbd5e1;
        letter-spacing: 0.5px;
    }

    .table-custom tbody td {
        padding: 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 5px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .btn-action-sm {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-restore-sm {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .btn-restore-sm:hover {
        background: #10b981;
        color: #ffffff;
    }

    .btn-force-sm {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .btn-force-sm:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Modal */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
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
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: modalScaleIn 0.2s ease;
    }
    @keyframes modalScaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <!-- Flash Alerts -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 13.5px;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #10b981;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #065f46; cursor: pointer;">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 13.5px;">
                <i class="fa-solid fa-circle-xmark" style="font-size: 18px; color: #ef4444;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #991b1b; cursor: pointer;">&times;</button>
        </div>
    @endif

    <!-- Header & Nav Back -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i>
                Tempat Sampah Surat Dispen Siswa
            </h1>
            <p>Kelola surat dispensasi yang telah dihapus sementara. Anda dapat memulihkan kembali atau menghapusnya secara permanen.</p>
        </div>

        <a href="{{ route('guru.surat-dispen') }}" class="btn-kembali">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Surat Dispen
        </a>
    </div>

    <!-- Stat Card & Global Actions -->
    <div class="trash-stat-box">
        <div class="stat-badge-group">
            <div class="stat-icon-trash">
                <i class="fa-solid fa-file-circle-xmark"></i>
            </div>
            <div class="stat-trash-text">
                <h3>{{ count($trashedDispen) }} Dokumen</h3>
                <span>Surat dispensasi siswa berada di tempat sampah</span>
            </div>
        </div>

        @if(count($trashedDispen) > 0)
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="openModalRestoreAll()" class="btn-restore-all">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Semua
                </button>
                <button type="button" onclick="openModalEmptyTrash()" class="btn-empty-trash">
                    <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                </button>
            </div>
        @endif
    </div>

    <!-- Table of Trashed Items -->
    <div class="trash-table-box">
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox" onchange="toggleSelectAll(this)">
                        </th>
                        <th style="width: 45px; text-align: center;">NO</th>
                        <th style="min-width: 140px;">KODE & TANGGAL</th>
                        <th style="min-width: 220px;">SISWA & KELAS</th>
                        <th style="min-width: 160px;">JAM & KEPERLUAN</th>
                        <th style="min-width: 140px;">DIHAPUS PADA</th>
                        <th style="width: 180px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedDispen as $idx => $d)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="custom-checkbox row-checkbox" value="{{ $d->id_siswa_dispen }}" onchange="updateBatchToolbar()">
                            </td>
                            <td style="text-align: center; color: #94a3b8; font-weight: 700;">
                                {{ $idx + 1 }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #2563eb; font-size: 13px;">{{ $d->kode_dispen }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    {{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                    {{ $d->siswa->nama_siswa ?? 'Siswa' }}
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    Kelas: <strong>{{ $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? '-') }}</strong> • NISN: {{ $d->siswa->nisn ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #334155; font-size: 13px;">
                                    <i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 4px;"></i>
                                    {{ substr($d->jam_keluar, 0, 5) }} - {{ substr($d->jam_kembali, 0, 5) }} WIB
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px; font-style: italic;">
                                    "{{ Str::limit($d->alasan, 35) }}"
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #ef4444; font-size: 12.5px;">
                                    {{ $d->deleted_at ? $d->deleted_at->translatedFormat('d M Y') : '-' }}
                                </div>
                                <div style="font-size: 11.5px; color: #94a3b8;">
                                    {{ $d->deleted_at ? $d->deleted_at->format('H:i') . ' WIB' : '' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <!-- Restore Button -->
                                    <form method="POST" action="{{ route('guru.surat-dispen.restore', $d->id_siswa_dispen) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action-sm btn-restore-sm" title="Pulihkan Surat Dispen">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <!-- Force Delete Button -->
                                    <button type="button" onclick="openModalForceDelete({{ $d->id_siswa_dispen }}, '{{ $d->kode_dispen }}', '{{ addslashes($d->siswa->nama_siswa ?? '') }}')" class="btn-action-sm btn-force-sm" title="Hapus Permanen">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size: 36px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                                Tempat sampah kosong. Tidak ada surat dispensasi yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Floating Batch Action Toolbar -->
<div id="floatingBatchBar" class="floating-batch-bar">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px;">0</span>
        <span>Surat Dispen Terpilih</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="submitBatchRestore()" style="background: #10b981; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
        </button>
        <button type="button" onclick="openModalBatchForceDelete()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
        </button>
        <button type="button" onclick="uncheckAll()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer;">
            Batal
        </button>
    </div>
</div>

<!-- Forms for Batch Actions -->
<form id="formBatchRestore" method="POST" action="{{ route('guru.surat-dispen.restore-batch') }}" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="inputBatchRestoreIds">
</form>

<form id="formBatchForceDelete" method="POST" action="{{ route('guru.surat-dispen.force-delete-batch') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="inputBatchForceDeleteIds">
</form>

<!-- Modal 1: Force Delete Single -->
<div id="modalForceDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Hapus Permanen Surat Dispen?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Surat dispen <strong id="modalForceKode" style="color: #0f172a;"></strong> milik <strong id="modalForceNama" style="color: #0f172a;"></strong> akan dihapus secara permanen beserta berkas fotonya dan tidak dapat dipulihkan kembali.
            </p>
            <form id="formSingleForceDelete" method="POST" action="">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="closeModalForceDelete()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Ya, Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Batch Force Delete -->
<div id="modalBatchForceDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Hapus Permanen Data Terpilih?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Anda akan menghapus <strong id="batchForceCountText" style="color: #ef4444;"></strong> surat dispensasi terpilih secara permanen dari sistem.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeModalBatchForceDelete()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                    Batal
                </button>
                <button type="button" onclick="submitBatchForceDelete()" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                    Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Restore All -->
<div id="modalRestoreAll" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Pulihkan Semua Surat Dispen?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Semua surat dispensasi di tempat sampah (<strong>{{ count($trashedDispen) }} data</strong>) akan dikembalikan ke daftar aktif.
            </p>
            <form method="POST" action="{{ route('guru.surat-dispen.restore-all') }}">
                @csrf
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="closeModalRestoreAll()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding: 10px 20px; background: #10b981; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Ya, Pulihkan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 4: Empty Trash -->
<div id="modalEmptyTrash" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-fire"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Kosongkan Seluruh Tempat Sampah?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Tindakan ini akan <strong>menghapus permanen seluruh surat dispensasi ({{ count($trashedDispen) }} data)</strong> di tempat sampah. Tindakan ini tidak dapat dibatalkan.
            </p>
            <form method="POST" action="{{ route('guru.surat-dispen.empty-trash') }}">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="closeModalEmptyTrash()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Ya, Kosongkan Sampah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateBatchToolbar();
    }

    function updateBatchToolbar() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        const count = checked.length;
        const bar = document.getElementById('floatingBatchBar');
        const badge = document.getElementById('selectedCountBadge');

        badge.innerText = count;

        if (count > 0) {
            bar.classList.add('show');
        } else {
            bar.classList.remove('show');
            const master = document.getElementById('selectAllCheckbox');
            if (master) master.checked = false;
        }
    }

    function uncheckAll() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllCheckbox');
        if (master) master.checked = false;
        updateBatchToolbar();
    }

    function getSelectedIds() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        return Array.from(checked).map(cb => cb.value);
    }

    function submitBatchRestore() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('inputBatchRestoreIds').value = ids.join(',');
        document.getElementById('formBatchRestore').submit();
    }

    function openModalBatchForceDelete() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('batchForceCountText').innerText = ids.length + ' data';
        document.getElementById('modalBatchForceDelete').style.display = 'flex';
    }
    function closeModalBatchForceDelete() {
        document.getElementById('modalBatchForceDelete').style.display = 'none';
    }
    function submitBatchForceDelete() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('inputBatchForceDeleteIds').value = ids.join(',');
        document.getElementById('formBatchForceDelete').submit();
    }

    function openModalForceDelete(id, kode, nama) {
        document.getElementById('modalForceKode').innerText = kode;
        document.getElementById('modalForceNama').innerText = nama;
        document.getElementById('formSingleForceDelete').action = '/guru-surat-dispen-trash/' + id + '/force';
        document.getElementById('modalForceDelete').style.display = 'flex';
    }
    function closeModalForceDelete() {
        document.getElementById('modalForceDelete').style.display = 'none';
    }

    function openModalRestoreAll() {
        document.getElementById('modalRestoreAll').style.display = 'flex';
    }
    function closeModalRestoreAll() {
        document.getElementById('modalRestoreAll').style.display = 'none';
    }

    function openModalEmptyTrash() {
        document.getElementById('modalEmptyTrash').style.display = 'flex';
    }
    function closeModalEmptyTrash() {
        document.getElementById('modalEmptyTrash').style.display = 'none';
    }
</script>
@endsection