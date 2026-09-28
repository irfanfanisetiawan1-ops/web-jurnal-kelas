@extends('layouts.waka')

@section('title', 'Sampah Dispen Siswa — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.25; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 700px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .btn-act { padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 11px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; justify-content: center; }
    .btn-restore { background: #10b981; color: #ffffff; }
    .btn-restore:hover { background: #059669; }
    .btn-delete-perm { background: #ef4444; color: #ffffff; }
    .btn-delete-perm:hover { background: #dc2626; }
    .btn-back { background: #64748b; color: #ffffff; }
    .btn-back:hover { background: #475569; }

    .trash-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        gap: 10px;
    }

    .desktop-trash-table {
        display: block;
    }

    .mobile-trash-cards {
        display: none;
    }

    @media (max-width: 768px) {
        .page-header-row {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 16px;
        }

        .page-title {
            font-size: 19px !important;
        }

        .btn-back {
            width: 100% !important;
            padding: 9px 14px !important;
            font-size: 12.5px !important;
        }

        .card-panel {
            padding: 14px 12px !important;
            border-radius: 14px !important;
        }

        .trash-action-bar {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .trash-action-bar .btn-act,
        .trash-action-bar form,
        .trash-action-bar form button {
            width: 100% !important;
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        .desktop-trash-table {
            display: none !important;
        }

        .mobile-trash-cards {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }

        .mobile-trash-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-trash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .mobile-trash-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 4px;
            padding-top: 8px;
            border-top: 1px solid #f1f5f9;
        }

        .mobile-trash-actions form,
        .mobile-trash-actions button {
            width: 100% !important;
        }
    }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA &gt; Persetujuan Izin &gt; <span>Sampah Dispen Siswa</span></div>
            <h1 class="page-title"><i class="fa-solid fa-trash-can" style="color: #d97706;"></i> Sampah Data Permohonan Dispen Siswa</h1>
        </div>
        <div>
            <a href="{{ route('waka.persetujuan-izin') }}" class="btn-act btn-back" style="padding: 9px 16px; font-size: 13px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Persetujuan Izin
            </a>
        </div>
    </div>

    <div class="card-panel">
        <div class="trash-action-bar">
            <div>
                <button type="button" onclick="submitBatchActionDispen('restore')" class="btn-act btn-restore" style="padding: 8px 14px; font-size: 12px;">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
                </button>
            </div>
            @if(count($siswaDispenList) > 0)
                <form action="{{ route('waka.siswa-dispen.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH dispen siswa? Tindakan ini tidak dapat dibatalkan!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-act btn-delete-perm" style="padding: 8px 14px; font-size: 12px;">
                        <i class="fa-solid fa-trash-can"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>

        <form id="formBatchTrashDispen" method="POST" action="">
            @csrf

            <!-- Desktop View Table -->
            <div class="desktop-trash-table" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 12px; border: 1px solid #e2e8f0;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllDispenTrash" onclick="toggleSelectAllDispenTrash(this)" style="cursor: pointer;">
                            </th>
                            <th>Kode Dispen</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Tanggal Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaDispenList as $sd)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $sd->id_siswa_dispen }}" class="cb-dispen-trash" style="cursor: pointer;">
                                </td>
                                <td style="font-weight: 800; color: #2563eb; font-family: monospace;">{{ $sd->kode_dispen }}</td>
                                <td style="font-weight: 700;">{{ $sd->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $sd->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $sd->tanggal }}</td>
                                <td>{{ Str::limit($sd->alasan ?? '-', 35) }}</td>
                                <td style="color: #64748b; font-size: 12px;">{{ $sd->deleted_at ? $sd->deleted_at->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <form action="{{ route('waka.siswa-dispen.restore', $sd->id_siswa_dispen) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-act btn-restore" title="Pulihkan Data"><i class="fa-solid fa-rotate-left"></i> Pulihkan</button>
                                        </form>
                                        <form action="{{ route('waka.siswa-dispen.force-delete', $sd->id_siswa_dispen) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus PERMANEN data dispen siswa ini? Data tidak dapat dikembalikan!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-act btn-delete-perm" title="Hapus Permanen"><i class="fa-solid fa-ban"></i> Permanen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    <i class="fa-solid fa-trash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                    Tidak ada data dispen siswa di dalam sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View Cards -->
            <div class="mobile-trash-cards">
                @if(count($siswaDispenList) > 0)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 6px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; color: #475569; cursor: pointer; margin: 0;">
                            <input type="checkbox" id="selectAllDispenTrashMobile" onclick="toggleSelectAllDispenTrash(this)" style="width: 17px; height: 17px; cursor: pointer;">
                            <span>Pilih Semua</span>
                        </label>
                        <span style="font-size: 11.5px; color: #64748b; font-weight: 700;">{{ count($siswaDispenList) }} Data</span>
                    </div>
                @endif

                @forelse($siswaDispenList as $sd)
                    <div class="mobile-trash-card">
                        <div class="mobile-trash-header">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" name="ids[]" value="{{ $sd->id_siswa_dispen }}" class="cb-dispen-trash" style="width: 17px; height: 17px; cursor: pointer;">
                                <span style="font-family: monospace; font-weight: 800; color: #2563eb; font-size: 11.5px;">{{ $sd->kode_dispen }}</span>
                            </div>
                            <span style="font-size: 11px; color: #64748b;">{{ $sd->deleted_at ? $sd->deleted_at->format('d-m-Y H:i') : '-' }}</span>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 14px; color: #0f172a;">{{ $sd->siswa->nama_siswa ?? '-' }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                Kelas: <strong>{{ $sd->kelas->nama_kelas ?? '-' }}</strong> • Tanggal: {{ $sd->tanggal }}
                            </div>
                        </div>
                        <div style="background: #f8fafc; border-left: 3px solid #f59e0b; padding: 6px 10px; border-radius: 6px; font-size: 11.5px; color: #334155;">
                            {{ $sd->alasan ?? '-' }}
                        </div>
                        <div class="mobile-trash-actions">
                            <form action="{{ route('waka.siswa-dispen.restore', $sd->id_siswa_dispen) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-act btn-restore" style="padding: 7px 10px; font-size: 11.5px;"><i class="fa-solid fa-rotate-left"></i> Pulihkan</button>
                            </form>
                            <form action="{{ route('waka.siswa-dispen.force-delete', $sd->id_siswa_dispen) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus PERMANEN data dispen siswa ini? Data tidak dapat dikembalikan!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-act btn-delete-perm" style="padding: 7px 10px; font-size: 11.5px;"><i class="fa-solid fa-ban"></i> Permanen</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 25px; color: #94a3b8; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <i class="fa-solid fa-trash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                        Tidak ada data dispen siswa di dalam sampah.
                    </div>
                @endforelse
            </div>
        </form>
    </div>

    <script>
    function toggleSelectAllDispenTrash(master) {
        const checkboxes = document.querySelectorAll('.cb-dispen-trash');
        checkboxes.forEach(cb => cb.checked = master.checked);
        const m1 = document.getElementById('selectAllDispenTrash');
        const m2 = document.getElementById('selectAllDispenTrashMobile');
        if (m1) m1.checked = master.checked;
        if (m2) m2.checked = master.checked;
    }

    function submitBatchActionDispen(actionType) {
        const checked = document.querySelectorAll('.cb-dispen-trash:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data yang ingin diproses!');
            return;
        }

        const uniqueIds = new Set();
        checked.forEach(cb => uniqueIds.add(cb.value));

        const form = document.getElementById('formBatchTrashDispen');
        if (actionType === 'restore') {
            if (confirm('Pulihkan ' + uniqueIds.size + ' data dispen siswa yang dipilih?')) {
                form.action = "{{ route('waka.siswa-dispen.batch-restore') }}";
                form.submit();
            }
        }
    }
    </script>
@endsection
