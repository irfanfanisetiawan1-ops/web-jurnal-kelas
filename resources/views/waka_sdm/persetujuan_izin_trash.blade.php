@extends('layouts.waka_sdm')

@section('title', 'Sampah Persetujuan Izin Guru — Waka SDM')
@section('page-header', 'Sampah Izin Guru')
@section('page-subheader', 'Kelola, pulihkan, atau hapus permanen riwayat permohonan izin guru yang telah dihapus sementara')

@section('styles')
<style>
    :root {
        --slate-dark: #1e293b;
        --slate-medium: #334155;
        --slate-light: #475569;
        --slate-muted: #64748b;
        --gray-bg: #f8fafc;
        --gray-surface: #f1f5f9;
        --gray-border: #e2e8f0;
        --primary-blue: #2563eb;
    }

    .trash-action-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
    }

    .main-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 0;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 13px 14px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 13px 14px;
        font-size: 12.5px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-action {
        padding: 7px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
        line-height: 1.2;
    }

    .btn-back {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-back:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-restore {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .btn-restore:hover {
        background: #d1fae5;
        color: #047857;
        transform: translateY(-1px);
    }

    .btn-delete-perm {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }
    .btn-delete-perm:hover {
        background: #ffe4e6;
        color: #be123c;
        transform: translateY(-1px);
    }

    .badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 10.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-slate { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
    .badge-amber { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
</style>
@endsection

@section('content')
<!-- Action Bar -->
<div class="trash-action-bar">
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="btn-action btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Persetujuan Izin
        </a>
        <button type="button" id="btnBatchRestore" onclick="submitBatchRestore()" class="btn-action btn-restore" disabled style="opacity: 0.6; cursor: not-allowed;">
            <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih (<span id="selectedTrashCount">0</span>)
        </button>
    </div>

    @if(count($guruIzinList) > 0)
        <div>
            <form action="{{ route('waka-sdm.izin.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH izin guru? Data yang dihapus permanen TIDAK DAPAT dikembalikan!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action btn-delete-perm">
                    <i class="fa-solid fa-dumpster-fire"></i> Kosongkan Seluruh Sampah
                </button>
            </form>
        </div>
    @endif
</div>

<!-- Main Table Card -->
<div class="main-table-card">
    <form id="formBatchTrashGuru" method="POST" action="">
        @csrf
        <div style="width: 100%;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;">
                            <input type="checkbox" id="selectAllGuruTrash" onclick="toggleSelectAllGuruTrash(this)" style="cursor: pointer; width: 15px; height: 15px;">
                        </th>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th style="width: 25%;">Nama Pendidik & Mapel / NIP</th>
                        <th style="width: 22%;">Tanggal Izin & Kategori</th>
                        <th style="width: 23%;">Alasan & Waktu Dihapus</th>
                        <th style="width: 20%; text-align: center;">Aksi Pemulihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $index => $gi)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" name="ids[]" value="{{ $gi->id_guru_izin }}" class="cb-guru-trash" onchange="updateTrashBatchButton()" style="cursor: pointer; width: 15px; height: 15px;">
                            </td>
                            <td style="text-align: center; color: #64748b; font-weight: 700;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <strong style="color: #0f172a; font-size: 13px;">{{ $gi->guru->nama_guru ?? 'Guru' }}</strong>
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                    NIP: {{ $gi->guru->nip ?? '-' }}
                                    @if(optional($gi->guru)->mapel)
                                        • {{ $gi->guru->mapel->nama_mapel }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    <i class="fa-solid fa-calendar-day" style="color: #94a3b8; font-size: 11px; margin-right: 3px;"></i>
                                    {{ $gi->tanggal_formatted }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px; margin-top: 4px;">
                                    <span class="badge badge-slate" style="text-transform: uppercase;">{{ $gi->kategori_izin ?? 'biasa' }}</span>
                                    <span style="font-size: 11px; color: #64748b;">{{ $gi->durasi_formatted }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ Str::limit($gi->alasan, 45) }}</div>
                                <div style="font-size: 11px; color: #64748b; margin-top: 3px;">
                                    <i class="fa-regular fa-clock" style="margin-right: 3px;"></i>
                                    Dihapus: {{ $gi->deleted_at ? $gi->deleted_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 6px; justify-content: center;">
                                    <form action="{{ route('waka-sdm.izin.restore', $gi->id_guru_izin) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-restore" title="Pulihkan Pengajuan Izin">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>
                                    <form action="{{ route('waka-sdm.izin.force-delete', $gi->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus PERMANEN pengajuan izin guru ini? Data tidak dapat dipulihkan lagi!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete-perm" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i> Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 45px; color: #94a3b8;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                                Tidak ada data pengajuan izin guru di dalam tong sampah.
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
    updateTrashBatchButton();
}

function updateTrashBatchButton() {
    const checked = document.querySelectorAll('.cb-guru-trash:checked');
    const btn = document.getElementById('btnBatchRestore');
    const countLabel = document.getElementById('selectedTrashCount');

    countLabel.innerText = checked.length;
    if (checked.length > 0) {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
    } else {
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btn.style.cursor = 'not-allowed';
    }
}

function submitBatchRestore() {
    const checked = document.querySelectorAll('.cb-guru-trash:checked');
    if (checked.length === 0) {
        alert('Silakan pilih minimal satu data yang ingin dipulihkan!');
        return;
    }

    if (confirm('Pulihkan ' + checked.length + ' data izin guru yang dipilih dari sampah?')) {
        const form = document.getElementById('formBatchTrashGuru');
        form.action = "{{ route('waka-sdm.izin.batch-restore') }}";
        form.submit();
    }
}
</script>
@endsection