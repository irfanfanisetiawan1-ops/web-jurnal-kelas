@extends('layouts.waka')

@section('title', 'Kotak Sampah Data Siswa — Waka Kesiswaan')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        width: 100%;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-outline {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .btn-outline:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-danger {
        background: #dc2626;
        color: #ffffff;
    }
    .btn-danger:hover {
        background: #b91c1c;
    }

    .main-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .siswa-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .siswa-table th {
        background: #fff1f2;
        border-bottom: 2px solid #fecdd3;
        padding: 14px 18px;
        font-size: 12.5px;
        font-weight: 800;
        color: #9f1239;
        white-space: nowrap;
    }

    .siswa-table td {
        padding: 14px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .siswa-table tr:hover td {
        background: #fff5f5;
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <div class="page-header-box">
        <div>
            <div style="margin-bottom: 6px;">
                <a href="{{ route('waka.siswa') }}" style="color: #64748b; font-weight: 700; text-decoration: none; font-size: 13px;">
                    &larr; Kembali ke Data Siswa
                </a>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #991b1b; margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-trash-can"></i> Kotak Sampah Data Siswa
            </h1>
            <p style="font-size: 13px; color: #64748b; margin: 3px 0 0 0;">
                Kelola data siswa yang telah dihapus sementara (Soft Deleted). Anda dapat memulihkan atau menghapusnya secara permanen.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('waka.siswa') }}" class="btn-action btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            @if($trashedSiswas->total() > 0)
                <form method="POST" action="{{ route('waka.siswa.empty-trash') }}" onsubmit="return confirm('Kosongkan SELURUH kotak sampah siswa? Tindakan ini bersifat PERMANEN!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-danger">
                        <i class="fa-solid fa-dumpster-fire"></i> Kosongkan Seluruh Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="background:#ecfdf5; border:1.5px solid #a7f3d0; color:#065f46; padding:14px 18px; border-radius:14px; font-size:13.5px; font-weight:700;">
            <i class="fa-solid fa-circle-check" style="color:#10b981;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="main-card">
        <div class="table-scroll-wrapper">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 130px;">NISN</th>
                        <th style="width: 120px;">NIS</th>
                        <th>Nama Siswa</th>
                        <th style="width: 130px;">Kelas Terakhir</th>
                        <th style="width: 100px;">JK</th>
                        <th style="width: 160px;">Tanggal Dihapus</th>
                        <th style="width: 180px; text-align: center;">Aksi Pemulihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedSiswas as $idx => $s)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $trashedSiswas->firstItem() + $idx }}
                            </td>
                            <td><span style="font-family:monospace; font-weight:700; color:#991b1b;">{{ $s->nisn }}</span></td>
                            <td>{{ $s->nis ?? '-' }}</td>
                            <td><strong>{{ $s->nama_siswa }}</strong></td>
                            <td><span style="background:#fee2e2; color:#991b1b; padding:3px 8px; border-radius:6px; font-weight:700; font-size:12px;">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td><span style="font-size:12.5px; color:#64748b;">{{ \Carbon\Carbon::parse($s->deleted_at)->translatedFormat('d F Y, H:i') }}</span></td>
                            <td style="text-align: center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <!-- Restore -->
                                    <form method="POST" action="{{ route('waka.siswa.restore', $s->id_siswa) }}">
                                        @csrf
                                        <button type="submit" class="btn-action" style="background:#ecfdf5; color:#059669; padding:6px 12px; font-size:12px;" title="Pulihkan Data Siswa">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <!-- Force Delete -->
                                    <form method="POST" action="{{ route('waka.siswa.force-delete', $s->id_siswa) }}" onsubmit="return confirm('Hapus PERMANEN data siswa {{ addslashes($s->nama_siswa) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action" style="background:#fee2e2; color:#dc2626; padding:6px 12px; font-size:12px;" title="Hapus Permanen">
                                            <i class="fa-solid fa-xmark"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <i class="fa-solid fa-trash-can" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #64748b;">Kotak Sampah Kosong</h4>
                                <p style="margin: 4px 0 0; font-size: 13px;">Tidak ada data siswa yang sedang dihapus sementara.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; background: #f8fafc; border-top: 1.5px solid #f1f5f9;">
            {{ $trashedSiswas->links('partials.custom-pagination') }}
        </div>
    </div>

</div>
@endsection