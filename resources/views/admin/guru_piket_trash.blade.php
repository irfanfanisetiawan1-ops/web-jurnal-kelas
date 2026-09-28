@extends('layouts.admin')

@section('title', 'Tempat Sampah Guru Piket — EDU JOURNAL')

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
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .mobile-lbl {
        display: none;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
        text-decoration: none;
        box-sizing: border-box;
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
        .card {
            padding: 16px 14px;
            border-radius: 16px;
            margin-bottom: 16px;
        }

        .card-top-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .btn-back-main {
            width: 100%;
            justify-content: center;
        }

        .table-responsive {
            border: none !important;
            overflow-x: visible !important;
        }

        .table-custom {
            display: block !important;
            width: 100% !important;
        }

        .table-custom thead {
            display: none !important;
        }

        .table-custom tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        .table-custom tbody tr {
            display: flex !important;
            flex-direction: column !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            padding: 14px !important;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
            gap: 8px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-custom tbody tr td {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 !important;
            border: none !important;
            width: 100% !important;
            font-size: 13px !important;
        }

        .table-custom tbody tr td.td-no {
            display: none !important;
        }

        .table-custom tbody tr td.td-name {
            border-bottom: 1px solid #f1f5f9 !important;
            padding-bottom: 10px !important;
            margin-bottom: 2px !important;
            display: block !important;
        }

        .table-custom tbody tr td.td-actions {
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
            display: block !important;
            width: 100% !important;
        }

        .mobile-lbl {
            display: inline-block !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #64748b !important;
        }

        .trash-action-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .trash-action-group form {
            display: flex !important;
            width: 100% !important;
            margin: 0 !important;
        }

        .btn-act {
            width: 100% !important;
            justify-content: center !important;
            padding: 9px 8px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tong Sampah — Guru Piket</h1>
            <p>Daftar penugasan guru piket yang dihapus sementara (soft delete)</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('admin.guru-piket') }}"><i class="fa-solid fa-clipboard-user"></i> Guru Piket</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Guru Piket</span>
    </div>

    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-trash-can" style="color:#d97706;"></i> Tempat Sampah Guru Piket ({{ count($trashedPikets) }})</h2>
                <p>Daftar akun Guru Piket yang dihapus sementara. Anda dapat memulihkan atau menghapus permanen.</p>
            </div>
            <a href="{{ route('admin.guru-piket') }}" class="btn-back-main">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Guru Piket
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:50px;">NO</th>
                        <th>NAMA PETUGAS PIKET</th>
                        <th>NIP / USERNAME</th>
                        <th>WAKTU DIHAPUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedPikets as $index => $u)
                        <tr>
                            <td class="td-no"><strong>{{ $index + 1 }}</strong></td>
                            <td class="td-name">
                                <strong style="font-size:14px; color:#0f172a; display:block;">{{ $u->name }}</strong>
                                <div style="font-size:12px; color:#64748b; margin-top:2px;">Email: {{ $u->email ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="mobile-lbl">NIP / User:</span>
                                <div>
                                    <span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $u->nip }}</span>
                                    <span style="font-size:12px; color:#64748b; margin-left:4px;">({{ $u->username ?? '-' }})</span>
                                </div>
                            </td>
                            <td>
                                <span class="mobile-lbl">Dihapus Pada:</span>
                                <span style="font-size:12.5px; color:#64748b;">{{ $u->deleted_at ? \Carbon\Carbon::parse($u->deleted_at)->format('d/m/Y H:i') : '-' }}</span>
                            </td>
                            <td class="td-actions" style="text-align:center;">
                                <div class="trash-action-group" style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('admin.guru-piket.restore', $u->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" title="Pulihkan Guru Piket">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.guru-piket.force-delete', $u->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-force-delete" onclick="return confirm('Hapus PERMANEN Guru Piket {{ addslashes($u->name) }}? Data tidak dapat dikembalikan!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Tempat sampah kosong. Tidak ada data Guru Piket yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
