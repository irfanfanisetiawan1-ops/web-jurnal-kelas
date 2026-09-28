@extends('layouts.kepala_sekolah')

@section('title', 'Tempat Sampah Guru Izin — Jurnal SMEA')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .page-header-box {
        background: #ffffff;
        padding: 18px 22px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border-left: 5px solid #ef4444;
        border-top: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
        line-height: 1.2;
    }

    .page-header-sub {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 3px;
    }

    .trash-header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-back {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 0 14px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-empty-trash {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 0 14px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-empty-trash:hover {
        background: #fca5a5;
        color: #7f1d1d;
    }

    .btn-batch-restore {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 0 14px;
        height: 36px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
        opacity: 0.45;
        pointer-events: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-batch-restore.active {
        opacity: 1;
        pointer-events: auto;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.15);
    }

    .table-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Desktop Table View */
    .desktop-trash-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
        table-layout: auto;
    }

    .custom-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #cbd5e1;
        color: #475569;
    }

    .custom-table th {
        padding: 11px 12px;
        font-weight: 800;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .btn-restore {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-restore:hover { background: #bbf7d0; color: #14532d; }

    .btn-force {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-force:hover { background: #fca5a5; color: #7f1d1d; }

    /* Mobile Cards Wrapper (Hidden on Desktop) */
    .mobile-trash-cards-wrapper {
        display: none;
    }

    .mobile-trash-card {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-sizing: border-box;
        transition: background 0.15s ease;
    }

    .mobile-trash-card:last-child {
        border-bottom: none;
    }

    .mobile-trash-card:hover {
        background: #f8fafc;
    }

    /* Mobile Responsive Rules */
    @media (max-width: 768px) {
        .trash-container {
            gap: 14px;
        }

        .page-header-box {
            padding: 16px 18px;
            border-radius: 14px;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .page-header-title {
            font-size: 20px;
        }

        .page-header-sub {
            font-size: 12px;
        }

        .trash-header-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-back,
        .btn-batch-restore,
        .btn-empty-trash {
            width: 100%;
            height: 38px;
            justify-content: center;
            font-size: 12.5px;
            box-sizing: border-box;
        }

        .trash-header-actions form {
            width: 100%;
        }

        /* Switch Desktop Table to Mobile Cards (Zero Horizontal Scroll!) */
        .desktop-trash-table-wrapper {
            display: none !important;
        }

        .mobile-trash-cards-wrapper {
            display: flex !important;
            flex-direction: column;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .page-header-title {
            font-size: 18px;
        }
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <div class="page-header-box">
        <div>
            <h1 class="page-header-title">
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Tempat Sampah Guru Izin
            </h1>
            <div class="page-header-sub">
                Kelola data izin guru yang telah dihapus. Anda dapat memulihkan kembali atau menghapusnya secara permanen.
            </div>
        </div>
        <div class="trash-header-actions">
            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Utama
            </a>

            @if($guruIzinList->isNotEmpty())
                <button type="button" id="btnBatchRestore" class="btn-batch-restore" onclick="confirmBatchRestore()">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih (<span id="selectedTrashCount">0</span>)
                </button>

                <form action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh tempat sampah secara permanen? Data tidak dapat dikembalikan lagi.');" style="margin: 0; padding: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-empty-trash">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="table-card">
        <form id="batchRestoreForm" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.batch-restore') }}" method="POST">
            @csrf

            <!-- A. DESKTOP VIEW: TABEL STANDAR -->
            <div class="desktop-trash-table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center; padding-left: 14px;">
                                <input type="checkbox" id="selectAllTrash" style="cursor: pointer; width: 15px; height: 15px; accent-color: #16a34a;">
                            </th>
                            <th style="width: 35px; text-align: center;">NO</th>
                            <th style="min-width: 180px;">GURU</th>
                            <th style="min-width: 140px;">TANGGAL & KATEGORI</th>
                            <th style="min-width: 180px;">ALASAN</th>
                            <th style="min-width: 120px;">DIHAPUS PADA</th>
                            <th style="text-align: center; width: 190px; padding-right: 14px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $index => $item)
                            <tr>
                                <td style="text-align: center; padding-left: 14px;">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id_guru_izin }}" class="check-trash" style="cursor: pointer; width: 15px; height: 15px; accent-color: #16a34a;" onchange="updateTrashSelectState()">
                                </td>
                                <td style="font-weight: 700; color: #64748b; text-align: center;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <strong>{{ $item->guru->nama_guru ?? 'Guru' }}</strong>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 1px;">NIP: {{ $item->guru->nip ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') : '-' }} s/d {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}</div>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ $item->kategori_izin ?? 'Izin' }} ({{ $item->durasi_hari ?? 1 }} Hari)</div>
                                </td>
                                <td>
                                    <div style="font-size: 12px; color: #334155; line-height: 1.35;">{{ $item->alasan }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                                        {{ $item->deleted_at ? $item->deleted_at->format('d-m-Y H:i') : '-' }}
                                    </div>
                                </td>
                                <td style="text-align: center; padding-right: 14px;">
                                    <div style="display: flex; gap: 5px; justify-content: center; align-items: center;">
                                        <button type="button" class="btn-restore" onclick="restoreSingle({{ $item->id_guru_izin }})">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>

                                        <button type="button" class="btn-force" onclick="forceDeleteSingle({{ $item->id_guru_izin }}, '{{ addslashes($item->guru->nama_guru ?? 'Guru') }}')">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 36px; color: #94a3b8;">
                                    <i class="fa-solid fa-trash-arrow-up" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                                    Tempat sampah kosong. Tidak ada data guru izin yang dihapus sementara.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- B. MOBILE VIEW: KARTU RESPONSIF (ZERO HORIZONTAL SCROLL) -->
            <div class="mobile-trash-cards-wrapper">
                @forelse($guruIzinList as $index => $item)
                    <div class="mobile-trash-card">
                        <!-- Top Header: Checkbox + No + Dihapus Pada -->
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" name="ids[]" value="{{ $item->id_guru_izin }}" class="check-trash" style="cursor: pointer; width: 17px; height: 17px; accent-color: #16a34a;" onchange="updateTrashSelectState()">
                                <span style="background: #e2e8f0; color: #334155; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                    #{{ $index + 1 }}
                                </span>
                            </div>
                            <span style="font-size: 11px; color: #64748b; font-weight: 600;">
                                <i class="fa-regular fa-clock"></i> {{ $item->deleted_at ? $item->deleted_at->format('d-m-Y H:i') : '-' }}
                            </span>
                        </div>

                        <!-- Info Guru -->
                        <div style="margin-top: 2px;">
                            <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                {{ $item->guru->nama_guru ?? 'Guru' }}
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; font-weight: 600; margin-top: 1px;">
                                NIP: {{ $item->guru->nip ?? '-' }}
                            </div>
                        </div>

                        <!-- Tanggal & Kategori Box -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px;">
                            <div>
                                <div style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Rentang Izin</div>
                                <div style="font-weight: 800; color: #0f172a; font-size: 12.5px; margin-top: 1px;">
                                    {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') : '-' }} s/d {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}
                                </div>
                            </div>
                            <span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 10px;">
                                {{ $item->kategori_izin ?? 'Izin' }} ({{ $item->durasi_hari ?? 1 }} Hari)
                            </span>
                        </div>

                        <!-- Alasan -->
                        <div style="font-size: 13px; color: #1e293b; font-weight: 600; line-height: 1.4;">
                            <span style="color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Alasan:</span>
                            {{ $item->alasan }}
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 8px; margin-top: 6px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                            <button type="button" class="btn-restore" onclick="restoreSingle({{ $item->id_guru_izin }})" style="flex: 1; justify-content: center; padding: 9px 12px; font-size: 12px;">
                                <i class="fa-solid fa-rotate-left"></i> Pulihkan
                            </button>

                            <button type="button" class="btn-force" onclick="forceDeleteSingle({{ $item->id_guru_izin }}, '{{ addslashes($item->guru->nama_guru ?? 'Guru') }}')" style="flex: 1; justify-content: center; padding: 9px 12px; font-size: 12px;">
                                <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                            </button>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 36px 16px; color: #94a3b8;">
                        <i class="fa-solid fa-trash-arrow-up" style="font-size: 32px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                        Tempat sampah kosong. Tidak ada data guru izin yang dihapus sementara.
                    </div>
                @endforelse
            </div>

        </form>
    </div>

</div>

<!-- Single Action Forms (Hidden) -->
<form id="singleRestoreForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="singleForceDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    const selectAllTrash = document.getElementById('selectAllTrash');
    const trashCheckboxes = document.querySelectorAll('.check-trash');
    const btnBatchRestore = document.getElementById('btnBatchRestore');
    const selectedTrashCount = document.getElementById('selectedTrashCount');

    if (selectAllTrash) {
        selectAllTrash.addEventListener('change', function() {
            const allBoxes = document.querySelectorAll('.check-trash');
            allBoxes.forEach(cb => {
                cb.checked = selectAllTrash.checked;
            });
            updateTrashSelectState();
        });
    }

    function updateTrashSelectState() {
        const checkedBoxes = document.querySelectorAll('.check-trash:checked');
        const checkedCount = checkedBoxes.length;
        if (selectedTrashCount) selectedTrashCount.innerText = checkedCount;

        if (btnBatchRestore) {
            if (checkedCount > 0) {
                btnBatchRestore.classList.add('active');
            } else {
                btnBatchRestore.classList.remove('active');
            }
        }

        const allBoxes = document.querySelectorAll('.check-trash');
        if (selectAllTrash) {
            selectAllTrash.checked = (checkedCount === allBoxes.length && allBoxes.length > 0);
        }
    }

    function confirmBatchRestore() {
        const checkedCount = document.querySelectorAll('.check-trash:checked').length;
        if (checkedCount === 0) {
            alert('Silakan pilih minimal 1 data yang ingin dipulihkan.');
            return;
        }

        if (confirm(`Pulihkan data guru izin terpilih kembali ke daftar aktif?`)) {
            document.getElementById('batchRestoreForm').submit();
        }
    }

    function restoreSingle(id) {
        if (confirm('Pulihkan data guru izin ini?')) {
            const form = document.getElementById('singleRestoreForm');
            form.action = "{{ url('/kepala-sekolah/guru-izin-tidak-hadir') }}/" + id + "/restore";
            form.submit();
        }
    }

    function forceDeleteSingle(id, nama) {
        if (confirm(`HAPUS PERMANEN izin guru "${nama}"? Tindakan ini tidak dapat dibatalkan.`)) {
            const form = document.getElementById('singleForceDeleteForm');
            form.action = "{{ url('/kepala-sekolah/guru-izin-tidak-hadir') }}/" + id + "/force";
            form.submit();
        }
    }
</script>
@endsection