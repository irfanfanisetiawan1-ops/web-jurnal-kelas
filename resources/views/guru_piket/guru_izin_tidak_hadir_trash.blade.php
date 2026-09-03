@extends('layouts.guru')

@section('title', 'Sampah Guru Izin Tidak Hadir — EDU JOURNAL')

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
        padding: 16px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .btn-restore {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-restore:hover { background: #bbf7d0; color: #14532d; }

    .btn-force {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-force:hover { background: #fca5a5; color: #7f1d1d; }
</style>
@endsection

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success" style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="page-header-box">
        <div class="page-header-info">
            <h1><i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Guru Izin Tidak Hadir</h1>
            <p>Kelola data guru izin yang telah dihapus sementara. Anda dapat memulihkan atau menghapus secara permanen.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="btn-reset-light">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Utama
            </a>
            @if($guruIzinList->isNotEmpty())
                <form action="{{ route('piket.guru-izin-tidak-hadir.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh data sampah ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-force">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>GURU</th>
                        <th>TANGGAL & ALASAN</th>
                        <th>DIHAPUS PADA</th>
                        <th style="text-align: center; width: 220px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $index => $item)
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ $item->guru->nama_guru ?? 'Guru' }}</strong>
                                <div style="font-size: 11.5px; color: #64748b;">NIP: {{ $item->guru->nip ?? '-' }}</div>
                            </td>
                            <td>
                                <div>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $item->alasan }}</div>
                            </td>
                            <td>
                                {{ $item->deleted_at ? $item->deleted_at->format('d-m-Y H:i') : '-' }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <form action="{{ route('piket.guru-izin-tidak-hadir.restore', $item->id_guru_izin) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-restore">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('piket.guru-izin-tidak-hadir.force-delete', $item->id_guru_izin) }}" method="POST" onsubmit="return confirm('Hapus permanen data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-force">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-trash" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                Tempat sampah kosong. Tidak ada data guru izin yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
