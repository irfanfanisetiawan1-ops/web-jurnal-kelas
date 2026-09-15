@extends('layouts.waka_kurikulum')

@section('title', 'Kotak Sampah Jadwal Pelajaran — Waka Kurikulum')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-action-bar {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 800px;
    }

    .jadwal-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .jadwal-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary { background: #2563eb; color: #ffffff; }
    .btn-emerald { background: #059669; color: #ffffff; }
    .btn-danger  { background: #dc2626; color: #ffffff; }
    .btn-outline { background: #ffffff; color: #334155; border: 1px solid #cbd5e1; }
</style>
@endsection

@section('content')
<div class="trash-container">
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                <a href="{{ route('waka-kurikulum.jadwal') }}" style="color: #64748b; text-decoration: none;">&larr; Kembali ke Jadwal Pelajaran</a>
            </div>
            <h1 class="page-main-title"><i class="fa-solid fa-trash-can" style="color: #dc2626;"></i> Kotak Sampah Jadwal Pelajaran</h1>
            <p style="font-size: 13px; color: #64748b; margin-top: 2px;">Daftar jadwal pelajaran yang telah dihapus sementara (Soft Deleted)</p>
        </div>

        <div style="display: flex; gap: 8px;">
            <a href="{{ route('waka-kurikulum.jadwal') }}" class="btn-action btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            @if(count($trashedJadwals) > 0)
            <form method="POST" action="{{ route('waka-kurikulum.jadwal.empty-trash') }}" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh kotak sampah? Jadwal akan dihapus PERMANEN.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action btn-danger">
                    <i class="fa-solid fa-trash-can-arrow-up"></i> Kosongkan Sampah
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="table-card">
        <div class="table-action-bar">
            <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                Total Terhapus: {{ $trashedJadwals->total() }} Data
            </div>
            <div style="font-size: 12px; color: #64748b;">
                Data dapat dipulihkan kapan saja atau dihapus secara permanen.
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Pelajaran</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Waktu Dihapus</th>
                        <th style="text-align: center; width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedJadwals as $j)
                        <tr>
                            <td style="font-weight: 800;">{{ $j->hari }}</td>
                            <td>
                                Jam ke-{{ $j->jam_mulai_ke }} - {{ $j->jam_selesai_ke }}
                                <div style="font-size: 11px; color: #64748b;">{{ substr($j->waktu_mulai_effective,0,5) }} - {{ substr($j->waktu_selesai_effective,0,5) }} WIB</div>
                            </td>
                            <td><span style="font-weight: 800; color: #2563eb;">{{ $j->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>
                                <div style="font-weight: 700;">{{ $j->mapel->nama_mapel ?? '-' }}</div>
                            </td>
                            <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                            <td style="font-size: 12px; color: #64748b;">
                                {{ $j->deleted_at ? $j->deleted_at->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <form method="POST" action="{{ route('waka-kurikulum.jadwal.restore', $j->id_jadwal) }}">
                                        @csrf
                                        <button type="submit" class="btn-action btn-emerald" style="padding: 5px 10px; font-size: 12px;" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('waka-kurikulum.jadwal.force-delete', $j->id_jadwal) }}" onsubmit="return confirm('Hapus PERMANEN jadwal ini? Tindakan tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger" style="padding: 5px 10px; font-size: 12px;" title="Hapus Permanen">
                                            <i class="fa-solid fa-xmark"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 8px;"></i>
                                <div style="font-weight: 700; color: #475569;">Kotak sampah kosong</div>
                                <div style="font-size: 12px;">Tidak ada jadwal pelajaran yang dihapus.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; background: #ffffff;">
            {{ $trashedJadwals->links('partials.custom-pagination') }}
        </div>
    </div>
</div>
@endsection
