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
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.2;
    }

    .page-header-info p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }

    .header-trash-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

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
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }
    .btn-restore:hover { background: #bbf7d0; color: #14532d; }

    .btn-force {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }
    .btn-force:hover { background: #fca5a5; color: #7f1d1d; }

    /* Mobile Trash Card List */
    .mobile-trash-card-list {
        display: none;
        flex-direction: column;
        gap: 12px;
        padding: 12px;
    }

    .mobile-trash-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .mobile-trash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .mobile-trash-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 4px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 10px;
    }

    .mobile-trash-actions form {
        width: 100%;
        margin: 0;
    }

    .mobile-trash-actions .btn-restore,
    .mobile-trash-actions .btn-force {
        width: 100%;
        justify-content: center;
        padding: 9px 12px;
        font-size: 12px;
    }

    /* Responsive Queries */
    @media (max-width: 768px) {
        .page-header-box {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 16px !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .page-header-info h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.5px !important;
            line-height: 1.2 !important;
        }

        .page-header-info p {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        .header-trash-actions {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .header-trash-actions a,
        .header-trash-actions form,
        .header-trash-actions button {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }

        .header-trash-actions .btn-reset-light,
        .header-trash-actions .btn-force {
            padding: 10px 14px !important;
            font-size: 12.5px !important;
        }

        .desktop-table-container {
            display: none !important;
        }

        .mobile-trash-card-list {
            display: flex !important;
        }
    }

    @media (min-width: 769px) {
        .desktop-table-container {
            display: block !important;
        }
        .mobile-trash-card-list {
            display: none !important;
        }
    }

    @media (max-width: 420px) {
        .page-header-info h1 {
            font-size: 26px !important;
        }
        .mobile-trash-actions {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid" style="padding: 0;">

    <div class="page-header-box">
        <div class="page-header-info">
            <h1><i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Guru Izin Tidak Hadir</h1>
            <p>Kelola data guru izin yang telah dihapus sementara. Anda dapat memulihkan atau menghapus secara permanen.</p>
        </div>
        <div class="header-trash-actions">
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
        <!-- DESKTOP TABLE -->
        <div class="desktop-table-container">
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

        <!-- MOBILE CARD LIST -->
        <div class="mobile-trash-card-list">
            @forelse($guruIzinList as $index => $item)
                <div class="mobile-trash-card">
                    <div class="mobile-trash-header">
                        <div>
                            <span style="font-size: 11px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 2px 6px; border-radius: 6px;">#{{ $index + 1 }}</span>
                            <strong style="font-size: 13px; color: #0f172a; margin-left: 6px;">{{ $item->guru->nama_guru ?? 'Guru' }}</strong>
                        </div>
                        <span style="font-size: 10.5px; color: #ef4444; font-weight: 700; background: #fee2e2; padding: 2px 7px; border-radius: 6px;">
                            <i class="fa-solid fa-trash-can"></i> Terhapus
                        </span>
                    </div>

                    <div style="font-size: 11.5px; color: #64748b;">
                        NIP: <strong>{{ $item->guru->nip ?? '-' }}</strong>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 9px 12px; font-size: 12px;">
                        <div style="font-weight: 700; color: #0f172a; margin-bottom: 3px;">
                            <i class="fa-regular fa-calendar" style="color: #2563eb;"></i> {{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}
                        </div>
                        <div style="color: #475569;">
                            {{ $item->alasan }}
                        </div>
                    </div>

                    <div style="font-size: 11px; color: #94a3b8; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-regular fa-clock"></i> Dihapus: {{ $item->deleted_at ? $item->deleted_at->format('d-m-Y H:i') : '-' }}
                    </div>

                    <div class="mobile-trash-actions">
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
                </div>
            @empty
                <div style="text-align: center; padding: 40px 16px; color: #94a3b8;">
                    <i class="fa-solid fa-trash" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                    Tempat sampah kosong. Tidak ada data guru izin yang dihapus.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
