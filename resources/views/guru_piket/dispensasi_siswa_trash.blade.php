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

    .desktop-table-container {
        display: block;
    }

    .mobile-trash-card-list {
        display: none;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header-box {
            padding: 18px 16px !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 14px !important;
        }

        .page-header-info h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
            letter-spacing: -0.02em !important;
        }

        .page-header-info p {
            font-size: 13px !important;
        }

        .page-header-box .header-actions-trash {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .page-header-box .header-actions-trash a,
        .page-header-box .header-actions-trash form,
        .page-header-box .header-actions-trash button {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .desktop-table-container {
            display: none !important;
        }

        .mobile-trash-card-list {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 12px !important;
        }

        .trash-card-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .trash-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 8px;
        }

        .trash-card-code {
            font-family: monospace;
            font-weight: 800;
            color: #2563eb;
            font-size: 12.5px;
        }

        .trash-card-body {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 12.5px;
        }

        .trash-card-actions {
            display: flex;
            gap: 8px;
            margin-top: 6px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
        }

        .trash-card-actions form {
            flex: 1;
        }

        .trash-card-actions button {
            width: 100% !important;
            justify-content: center !important;
        }
    }

    @media (max-width: 480px) {
        .page-header-info h1 {
            font-size: 26px !important;
        }
    }
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
        <div class="header-actions-trash" style="display: flex; gap: 10px; flex-wrap: wrap;">
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


    <!-- Table Card -->
    <div class="table-card">
        <!-- Desktop Table View -->
        <div class="desktop-table-container" style="overflow-x: auto;">
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

        <!-- Mobile Card List View -->
        <div class="mobile-trash-card-list">
            @forelse($dispenList as $d)
                <div class="trash-card-item">
                    <div class="trash-card-header">
                        <span class="trash-card-code">{{ $d->kode_dispen }}</span>
                        <span style="color: #64748b; font-size: 11px; font-weight: 600;">
                            <i class="fa-regular fa-clock"></i> {{ $d->deleted_at ? $d->deleted_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>
                    <div class="trash-card-body">
                        <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $d->siswa->nama_siswa ?? '-' }}</div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">Kelas: <span style="color: #1e293b; font-weight: 700;">{{ $d->kelas->nama_kelas ?? '-' }}</span></div>
                        <div style="font-size: 12px; color: #334155; font-weight: 600;">
                            <i class="fa-regular fa-calendar" style="color: #64748b;"></i> {{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}
                            <span style="margin: 0 4px; color: #cbd5e1;">|</span>
                            <span style="color: #d97706; font-weight: 700;">{{ $d->jam_keluar }} - {{ $d->jam_kembali }}</span>
                        </div>
                        <div style="font-size: 12px; color: #475569; background: #f8fafc; padding: 6px 10px; border-radius: 6px; border-left: 3px solid #cbd5e1;">
                            "{{ $d->alasan }}"
                        </div>
                    </div>
                    <div class="trash-card-actions">
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
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 30px 16px; text-align: center; color: #64748b; font-weight: 600;">
                    <i class="fa-solid fa-trash-slash fa-2x" style="color: #cbd5e1; margin-bottom: 8px;"></i><br>
                    Tempat Sampah Kosong. Tidak ada data dispensasi siswa yang dihapus.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
