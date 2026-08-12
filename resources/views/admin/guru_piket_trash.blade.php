@extends('layouts.admin')

@section('title', 'Tempat Sampah Guru Piket — Jurnal ESEMKITA')

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
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('admin.guru-piket') }}"><i class="fa-solid fa-clipboard-user"></i> Guru Piket</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Guru Piket</span>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-success">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

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
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ $u->name }}</strong>
                                <div style="font-size:12px; color:#64748b;">Email: {{ $u->email ?? '-' }}</div>
                            </td>
                            <td>
                                <span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $u->nip }}</span>
                                <div style="font-size:12px; color:#64748b;">User: {{ $u->username ?? '-' }}</div>
                            </td>
                            <td>{{ $u->deleted_at ? \Carbon\Carbon::parse($u->deleted_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
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
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
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
