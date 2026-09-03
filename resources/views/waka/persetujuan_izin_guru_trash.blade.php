@extends('layouts.waka')

@section('title', 'Sampah Izin Guru — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .btn-act { padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 11px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; }
    .btn-restore { background: #10b981; color: #ffffff; }
    .btn-restore:hover { background: #059669; }
    .btn-delete-perm { background: #ef4444; color: #ffffff; }
    .btn-delete-perm:hover { background: #dc2626; }
    .btn-back { background: #64748b; color: #ffffff; }
    .btn-back:hover { background: #475569; }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA > Persetujuan Izin > <span>Sampah Izin Guru</span></div>
            <h1 class="page-title"><i class="fa-solid fa-trash-can" style="color: #d97706;"></i> Sampah Data Izin Tidak Masuk Guru</h1>
        </div>
        <div>
            <a href="{{ route('waka.persetujuan-izin') }}" class="btn-act btn-back" style="padding: 9px 16px; font-size: 13px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Persetujuan Izin
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin-bottom: 20px; border: 1px solid #a7f3d0;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin-bottom: 20px; border: 1px solid #fca5a5;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="submitBatchAction('restore')" class="btn-act btn-restore" style="padding: 8px 14px; font-size: 12px;">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
                </button>
            </div>
            @if(count($guruIzinList) > 0)
                <form action="{{ route('waka.guru-izin.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH izin guru? Tindakan ini tidak dapat dibatalkan!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-act btn-delete-perm" style="padding: 8px 14px; font-size: 12px;">
                        <i class="fa-solid fa-trash-can"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>

        <form id="formBatchTrashGuru" method="POST" action="">
            @csrf
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllGuruTrash" onclick="toggleSelectAllGuruTrash(this)" style="cursor: pointer;">
                            </th>
                            <th>Nama Guru</th>
                            <th>Tanggal Izin</th>
                            <th>Alasan</th>
                            <th>Tanggal Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $gi)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $gi->id_guru_izin }}" class="cb-guru-trash" style="cursor: pointer;">
                                </td>
                                <td style="font-weight: 700;">{{ $gi->guru->nama_guru ?? 'Guru' }}</td>
                                <td>{{ $gi->tanggal_mulai }} s/d {{ $gi->tanggal_selesai }}</td>
                                <td>{{ $gi->alasan }}</td>
                                <td style="color: #64748b; font-size: 12px;">{{ $gi->deleted_at ? $gi->deleted_at->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <form action="{{ route('waka.guru-izin.restore', $gi->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-act btn-restore" title="Pulihkan Data"><i class="fa-solid fa-rotate-left"></i> Pulihkan</button>
                                        </form>
                                        <form action="{{ route('waka.guru-izin.force-delete', $gi->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus PERMANEN data izin guru ini? Data tidak dapat dikembalikan!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-act btn-delete-perm" title="Hapus Permanen"><i class="fa-solid fa-ban"></i> Permanen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    <i class="fa-solid fa-trash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                    Tidak ada data izin guru di dalam sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
    function toggleSelectAllGuruTrash(master) {
        const checkboxes = document.querySelectorAll('.cb-guru-trash');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    function submitBatchAction(actionType) {
        const checked = document.querySelectorAll('.cb-guru-trash:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data yang ingin diproses!');
            return;
        }

        const form = document.getElementById('formBatchTrashGuru');
        if (actionType === 'restore') {
            if (confirm('Pulihkan ' + checked.length + ' data izin guru yang dipilih?')) {
                form.action = "{{ route('waka.guru-izin.batch-restore') }}";
                form.submit();
            }
        }
    }
    </script>
@endsection
