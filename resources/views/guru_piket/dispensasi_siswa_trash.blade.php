@extends('layouts.guru')

@section('title', 'Sampah Dispensasi Siswa — EDU JOURNAL')

@section('styles')
<style>
    .page-header-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        border-left: 5px solid #ef4444;
    }

    .page-header-info h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-info p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }

    .table-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-back { background: #e2e8f0; color: #475569; }
    .btn-back:hover { background: #cbd5e1; color: #0f172a; }

    .btn-empty { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
    .btn-empty:hover { background: #dc2626; color: #ffffff; }

    .btn-restore { background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; }
    .btn-restore:hover { background: #10b981; color: #ffffff; }

    .btn-delete { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
    .btn-delete:hover { background: #dc2626; color: #ffffff; }
</style>
@endsection

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-header-box">
        <div class="page-header-info">
            <h1><i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Data Dispensasi Siswa</h1>
            <p>Daftar data permohonan dispensasi siswa yang telah dihapus sementara.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('piket.dispensasi-siswa') }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dispensasi Siswa
            </a>
            @if($dispenList->isNotEmpty())
                <form action="{{ route('piket.dispensasi-siswa.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH data dispensasi siswa ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-empty">
                        <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 700;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>KODE & SISWA</th>
                        <th>TANGGAL & JAM</th>
                        <th>ALASAN DISPEN</th>
                        <th>TANGGAL DIHAPUS</th>
                        <th style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenList as $d)
                        <tr>
                            <td>
                                <div style="font-family: monospace; font-weight: 800; color: #2563eb;">{{ $d->kode_dispen }}</div>
                                <div style="font-weight: 700; color: #0f172a;">{{ $d->siswa->nama_siswa ?? '-' }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">Kelas {{ $d->kelas->nama_kelas ?? '-' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #334155;">{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</div>
                                <div style="font-size: 12px; color: #d97706; font-weight: 700;">{{ $d->jam_keluar }} s/d {{ $d->jam_kembali }}</div>
                            </td>
                            <td>
                                <div style="color: #334155; font-weight: 600; font-size: 12px;">"{{ $d->alasan }}"</div>
                            </td>
                            <td>
                                <div style="color: #64748b; font-size: 12px; font-weight: 600;">
                                    <i class="fa-regular fa-clock"></i> {{ $d->deleted_at ? $d->deleted_at->format('d-m-Y H:i') : '-' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <form action="{{ route('piket.dispensasi-siswa.restore', $d->id_siswa_dispen) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-restore" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('piket.dispensasi-siswa.force-delete', $d->id_siswa_dispen) }}" method="POST" onsubmit="return confirm('Hapus permanen data ini? Data yang dihapus permanen tidak dapat dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-trash-slash fa-2x" style="color: #cbd5e1; margin-bottom: 8px;"></i><br>
                                Tempat Sampah Kosong. Tidak ada data dispensasi siswa yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
