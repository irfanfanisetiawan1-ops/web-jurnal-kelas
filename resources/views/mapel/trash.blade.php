@extends('layouts.admin')

@section('title', 'Tempat Sampah Mapel — EDU JOURNAL')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text a {
        color: #3b5490;
        text-decoration: none;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-back-main {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }
    .btn-back-main:hover { background: #e2e8f0; }

    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }

    .btn-restore {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .btn-restore:hover {
        background: #16a34a;
        color: #ffffff;
    }

    .btn-force-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-force-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    @media (max-width: 768px) {
        .page-header-container {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            line-height: 1.25 !important;
        }
        .page-title-group p { font-size: 13px !important; }

        .card {
            padding: 16px 14px !important;
            border-radius: 14px !important;
        }

        .card-top-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }

        .btn-back-main {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 11px 16px !important;
        }

        .table-responsive {
            border: none !important;
        }

        .table-custom {
            display: block !important;
            width: 100% !important;
        }

        .table-custom thead {
            display: none !important;
        }

        .table-custom tbody {
            display: block !important;
            width: 100% !important;
        }

        .table-custom tbody tr.trash-row-card {
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            gap: 8px 10px !important;
            padding: 14px 16px !important;
            margin-bottom: 12px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .table-custom tbody tr.trash-row-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
        }

        .table-custom tbody tr.trash-row-card .col-nama {
            grid-column: 1 !important;
            grid-row: 1 !important;
            text-align: left !important;
        }

        .table-custom tbody tr.trash-row-card .col-waktu {
            grid-column: 2 !important;
            grid-row: 1 !important;
            text-align: right !important;
            font-size: 11.5px !important;
            color: #64748b !important;
            align-self: center !important;
        }

        .table-custom tbody tr.trash-row-card .col-kode {
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            background: #f8fafc !important;
            padding: 8px 12px !important;
            border-radius: 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 12.5px !important;
        }

        .table-custom tbody tr.trash-row-card .col-aksi {
            grid-column: 1 / -1 !important;
            grid-row: 3 !important;
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
        }

        .table-custom tbody tr.trash-row-card .col-aksi .action-btn-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .table-custom tbody tr.trash-row-card .col-aksi .action-btn-group form {
            width: 100% !important;
            display: block !important;
        }

        .table-custom tbody tr.trash-row-card .col-aksi .action-btn-group .btn-act {
            width: 100% !important;
            justify-content: center !important;
            padding: 9px 8px !important;
            box-sizing: border-box !important;
            border-radius: 10px !important;
            font-size: 12.5px !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .table-custom tbody tr.trash-row-card .col-aksi .action-btn-group {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tong Sampah — Mata Pelajaran</h1>
            <p>Daftar mata pelajaran yang dihapus sementara (soft delete)</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('mapel.index') }}"><i class="fa-solid fa-book"></i> Master Mapel</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Mapel</span>
    </div>

    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-trash-can" style="color:#d97706;"></i> Tempat Sampah Mapel ({{ count($mapels) }})</h2>
                <p>Daftar mata pelajaran yang dihapus sementara. Anda dapat memulihkan atau menghapus permanen.</p>
            </div>
            <a href="{{ route('mapel.index') }}" class="btn-back-main">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Mapel
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>KODE MAPEL</th>
                        <th>NAMA MAPEL</th>
                        <th>WAKTU DIHAPUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $m)
                        <tr class="trash-row-card">
                            <td class="col-kode">
                                <div style="display:inline-flex; align-items:center; gap:6px;">
                                    <span style="font-size:11px; font-weight:700; color:#64748b;">KODE:</span>
                                    <span style="font-family:monospace; color:#3b5490; font-weight:700;">{{ $m->kode_mapel }}</span>
                                </div>
                            </td>
                            <td class="col-nama"><strong style="color:#0f172a; font-size:14px;">{{ $m->nama_mapel }}</strong></td>
                            <td class="col-waktu">{{ $m->deleted_at ? \Carbon\Carbon::parse($m->deleted_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td class="col-aksi" style="text-align:center;">
                                <div class="action-btn-group" style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('mapel.restore', $m->id_mapel) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" title="Pulihkan Mapel">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('mapel.force-delete', $m->id_mapel) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-force-delete" onclick="return confirm('Hapus PERMANEN mapel {{ addslashes($m->nama_mapel) }}? Data tidak bisa dikembalikan lagi!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Tempat sampah kosong. Tidak ada data mapel yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
