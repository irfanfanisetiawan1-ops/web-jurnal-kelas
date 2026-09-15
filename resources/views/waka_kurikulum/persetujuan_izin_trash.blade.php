@extends('layouts.waka_kurikulum')

@section('title', 'Kotak Sampah Persetujuan Izin — EDU JOURNAL')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .trash-header-box {
        background: #ffffff;
        padding: 20px 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .trash-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .trash-subtitle {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin: 4px 0 0 0;
    }

    .trash-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
    }

    .batch-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 14px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 11px 12px;
        font-weight: 800;
        color: #475569;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    .btn-action-restore {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-family: inherit;
    }

    .btn-action-restore:hover {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-action-force {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-family: inherit;
    }

    .btn-action-force:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-back-link {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: inherit;
    }

    .btn-back-link:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-empty-trash {
        background: #dc2626;
        color: #ffffff;
        border: none;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: inherit;
    }

    .btn-empty-trash:hover {
        background: #b91c1c;
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 18px; color: #ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Box -->
    <div class="trash-header-box">
        <div>
            <h1 class="trash-title">
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i>
                <span>Kotak Sampah Data Izin Guru</span>
            </h1>
            <p class="trash-subtitle">
                Data permohonan izin guru yang telah dihapus sementara. Anda dapat memulihkan (restore) data kembali ke antrean atau menghapusnya secara permanen.
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('waka-kurikulum.persetujuan-izin') }}" class="btn-back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Persetujuan Izin
            </a>

            @if($trashedList->total() > 0)
                <form action="{{ route('waka-kurikulum.izin.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin mengosongkan seluruh kotak sampah perizinan secara permanen? Data yang dihapus tidak dapat dipulihkan kembali.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-empty-trash">
                        <i class="fa-solid fa-trash-can-arrow-up"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Trash Card Table -->
    <div class="trash-card">
        @if($trashedList->isEmpty())
            <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: #f1f5f9; color: #64748b; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 12px;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Kotak Sampah Kosong</h3>
                <p style="font-size: 13px; color: #64748b; margin: 0;">Tidak ada data permohonan izin guru yang berada di kotak sampah.</p>
            </div>
        @else
            <form action="{{ route('waka-kurikulum.izin.batch-restore') }}" method="POST">
                @csrf
                <div class="batch-strip">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; color: #334155; cursor: pointer;">
                        <input type="checkbox" id="selectAllTrash" onchange="toggleTrashSelectAll(this)" style="width: 16px; height: 16px; accent-color: #2563eb; cursor: pointer;">
                        <span>Pilih Semua Data di Halaman Ini</span>
                    </label>

                    <button type="submit" class="btn-action-restore" onclick="return confirm('Pulihkan seluruh data izin guru yang dipilih?')">
                        <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 32px; text-align: center;">#</th>
                                <th>Guru yang Mengajukan</th>
                                <th>Tanggal Izin</th>
                                <th>Alasan</th>
                                <th>Dihapus Pada</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedList as $izin)
                                @php
                                    $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                                    $tglMulai = Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
                                    $tglSelesai = $izin->tanggal_selesai ? Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') : $tglMulai;
                                @endphp
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="trash-check" style="width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer;">
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 13px;">{{ $namaGuru }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">
                                            {{ $tglMulai }}
                                            @if($tglSelesai !== $tglMulai)
                                                <span style="color: #64748b;">s/d</span> {{ $tglSelesai }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 12.5px; color: #334155; max-width: 250px;">{{ $izin->alasan ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size: 12px; color: #64748b;">
                                            {{ $izin->deleted_at ? Carbon\Carbon::parse($izin->deleted_at)->format('d/m/Y H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; gap: 6px;">
                                            <form action="{{ route('waka-kurikulum.izin.restore', $izin->id_guru_izin) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-action-restore" title="Pulihkan Data">
                                                    <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                                </button>
                                            </form>

                                            <form action="{{ route('waka-kurikulum.izin.force-delete', $izin->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus permanen izin {{ addslashes($namaGuru) }}? Data tidak bisa dipulihkan kembali.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-force" title="Hapus Permanen">
                                                    <i class="fa-solid fa-ban"></i> Hapus Permanen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 16px;">
                    {{ $trashedList->links() }}
                </div>
            </form>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    function toggleTrashSelectAll(master) {
        document.querySelectorAll('.trash-check').forEach(cb => cb.checked = master.checked);
    }
</script>
@endsection
