@extends('layouts.waka_sdm')

@section('title', 'Sampah Persetujuan Izin Guru — Waka SDM')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .btn-act { padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: all 0.2s; }
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
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Waka SDM > Persetujuan Izin > <span style="color: #ea580c;">Sampah Izin Guru</span></div>
            <h1 class="page-title"><i class="fa-solid fa-trash-can" style="color: #ea580c;"></i> Sampah Data Izin Tidak Masuk / Cuti Guru</h1>
        </div>
        <div>
            <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="btn-act btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Persetujuan Izin
            </a>
        </div>
    </div>

    <div class="card-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="submitBatchAction('restore')" class="btn-act btn-restore">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
                </button>
            </div>
            @if(count($guruIzinList) > 0)
                <form action="{{ route('waka-sdm.izin.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH izin guru? Data yang dihapus permanen tidak dapat dikembalikan!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-act btn-delete-perm">
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
                                <input type="checkbox" id="selectAllGuruTrash" onclick="toggleSelectAllGuruTrash(this)" style="cursor: pointer; width: 16px; height: 16px;">
                            </th>
                            <th>Nama Guru / NIP</th>
                            <th>Tanggal Izin</th>
                            <th>Kategori / Alasan</th>
                            <th>Tanggal Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $gi)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $gi->id_guru_izin }}" class="cb-guru-trash" style="cursor: pointer; width: 16px; height: 16px;">
                                </td>
                                <td>
                                    <strong style="color: #0f172a;">{{ $gi->guru->nama_guru ?? 'Guru' }}</strong>
                                    <div style="font-size: 11px; color: #64748b;">NIP: {{ $gi->guru->nip ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 700;">{{ $gi->tanggal_formatted }}</div>
                                    <span style="font-size: 11px; color: #64748b;">{{ $gi->durasi_formatted }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #2563eb;">{{ $gi->kategori_izin ?? 'Izin' }}</div>
                                    <div style="font-size: 12px; color: #475569;">{{ Str::limit($gi->alasan, 40) }}</div>
                                </td>
                                <td style="color: #64748b; font-size: 12px; font-weight: 600;">
                                    <i class="fa-regular fa-clock" style="margin-right: 4px;"></i>
                                    {{ $gi->deleted_at ? $gi->deleted_at->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <form action="{{ route('waka-sdm.izin.restore', $gi->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-act btn-restore" title="Pulihkan Data"><i class="fa-solid fa-rotate-left"></i> Pulihkan</button>
                                        </form>
                                        <form action="{{ route('waka-sdm.izin.force-delete', $gi->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus PERMANEN data izin guru ini? Data tidak dapat dikembalikan!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-act btn-delete-perm" title="Hapus Permanen"><i class="fa-solid fa-ban"></i> Permanen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa-solid fa-trash-arrow-up" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                    Tidak ada data izin guru di dalam sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
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
            form.action = "{{ route('waka-sdm.izin.batch-restore') }}";
            form.submit();
        }
    }
}
</script>
@endsection