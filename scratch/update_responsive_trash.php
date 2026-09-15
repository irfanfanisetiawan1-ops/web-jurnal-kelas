<?php

$trashBlade = <<<'BLADE'
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
        box-sizing: border-box;
    }

    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-sizing: border-box;
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

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600; font-size: 12.5px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 10px; font-weight: 600; font-size: 12.5px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="page-header-box">
        <div>
            <h1 class="page-header-title">
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Tempat Sampah Guru Izin
            </h1>
            <div class="page-header-sub">
                Kelola data izin guru yang telah dihapus. Anda dapat memulihkan kembali atau menghapusnya secara permanen.
            </div>
        </div>
        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Utama
            </a>

            @if($guruIzinList->isNotEmpty())
                <button type="button" id="btnBatchRestore" class="btn-batch-restore" onclick="confirmBatchRestore()">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih (<span id="selectedTrashCount">0</span>)
                </button>

                <form action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh tempat sampah secara permanen? Data tidak dapat dikembalikan lagi.');">
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
            <div class="table-responsive">
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
            trashCheckboxes.forEach(cb => {
                cb.checked = selectAllTrash.checked;
            });
            updateTrashSelectState();
        });
    }

    function updateTrashSelectState() {
        const checkedCount = document.querySelectorAll('.check-trash:checked').length;
        if (selectedTrashCount) selectedTrashCount.innerText = checkedCount;

        if (btnBatchRestore) {
            if (checkedCount > 0) {
                btnBatchRestore.classList.add('active');
            } else {
                btnBatchRestore.classList.remove('active');
            }
        }

        if (selectAllTrash) {
            selectAllTrash.checked = (checkedCount === trashCheckboxes.length && trashCheckboxes.length > 0);
        }
    }

    function confirmBatchRestore() {
        const checkedCount = document.querySelectorAll('.check-trash:checked').length;
        if (checkedCount === 0) {
            alert('Silakan pilih minimal 1 data yang ingin dipulihkan.');
            return;
        }

        if (confirm(`Pulihkan ${checkedCount} data guru izin terpilih kembali ke daftar aktif?`)) {
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
BLADE;

file_put_contents('c:/laragon/www/web-jurnal-kelas/resources/views/kepala_sekolah/guru_izin_trash.blade.php', $trashBlade);
echo "Updated kepala_sekolah/guru_izin_trash.blade.php with responsive fitting successfully!\n";
