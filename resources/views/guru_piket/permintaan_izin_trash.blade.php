@extends('layouts.guru')

@section('title', 'Sampah Permintaan Izin Guru — EDU JOURNAL')

@section('styles')
<style>
    .page-title-box {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-box p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px 18px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .btn-action-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #f1f5f9;
        color: #3b82f6;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-action-link:hover {
        background: #e2e8f0;
    }

    .btn-restore {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .btn-restore:hover {
        background: #bbf7d0;
    }

    .btn-danger-custom {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }

    .btn-danger-custom:hover {
        background: #fca5a5;
    }
</style>
@endsection

@section('content')
    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tong Sampah — Permintaan Izin Guru</h1>
            <p>Daftar riwayat pengajuan izin guru yang dihapus sementara (soft delete)</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('piket.permintaan-izin') }}" class="btn-action-link" style="padding: 10px 18px; background: #384972; color: #ffffff; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 13px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Permintaan Izin
            </a>
        </div>
    </div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="card-custom">
    <div class="card-custom-header">
        <h2>Daftar Data di Sampah ({{ $guruIzinList->count() }})</h2>
        @if($guruIzinList->isNotEmpty())
            <form action="{{ route('piket.permintaan-izin.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan SELURUH data sampah izin secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action-link btn-danger-custom" style="padding: 8px 14px;">
                    <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                </button>
            </form>
        @endif
    </div>
    <div class="card-custom-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>GURU</th>
                        <th>TANGGAL IZIN</th>
                        <th>ALASAN</th>
                        <th>DIHAPUS PADA</th>
                        <th>AKSI SIKLUS DATA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $iz)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                {{ $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}
                            </div>
                            @if($iz->guru && $iz->guru->nip)
                                <div style="font-size: 11px; color: #64748b;">NIP. {{ $iz->guru->nip }}</div>
                            @endif
                        </td>
                        <td style="white-space: nowrap; font-weight: 600; color: #475569;">
                            @if($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y') }}
                            @endif
                        </td>
                        <td>
                            <div style="color: #334155; font-weight: 500;">{{ $iz->alasan }}</div>
                        </td>
                        <td style="font-size: 12px; color: #64748b; font-weight: 600;">
                            {{ $iz->deleted_at ? \Carbon\Carbon::parse($iz->deleted_at)->format('d-m-Y H:i') : '-' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <form action="{{ route('piket.permintaan-izin.restore', $iz->id_guru_izin) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-link btn-restore" title="Pulihkan Data">
                                        <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('piket.permintaan-izin.force-delete', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus PERMANEN data ini? Data tidak dapat dikembalikan.');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-link btn-danger-custom" title="Hapus Permanen">
                                        <i class="fa-solid fa-xmark"></i> Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 36px; color: #94a3b8; font-weight: 600;">
                            <i class="fa-solid fa-trash-can fa-2x mb-2" style="display: block; opacity: 0.5;"></i>
                            Tidak ada data izin guru di dalam Sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
