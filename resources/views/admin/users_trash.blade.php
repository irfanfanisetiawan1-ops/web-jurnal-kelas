@extends('layouts.admin')

@section('title', 'Tempat Sampah Pengguna — EduJournal Admin')

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

    .search-input-wrapper {
        position: relative;
        max-width: 380px;
        width: 100%;
        margin-bottom: 16px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        outline: none;
        transition: all 0.2s;
    }

    .search-input-wrapper input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

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

    .role-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }

    .role-badge-admin { background: #fed7aa; color: #9a3412; }
    .role-badge-guru { background: #e0f2fe; color: #0369a1; }
    .role-badge-piket { background: #fef08a; color: #854d0e; }
    .role-badge-wali { background: #dcfce7; color: #15803d; }

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
    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        font-size: 13px;
        color: #64748b;
        flex-wrap: wrap;
        gap: 12px;
    }
    .table-footer nav svg {
        width: 1rem !important;
        height: 1rem !important;
        display: inline-block !important;
    }
    .table-footer nav div:first-child { display: none !important; }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tong Sampah — Data Pengguna</h1>
            <p>Daftar akun pengguna yang dihapus sementara (soft delete)</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('admin.verifikasi-guru') }}"><i class="fa-solid fa-users"></i> Master Data — Pengguna</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Pengguna</span>
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

    @if(session('error'))
        <div class="alert-custom alert-error">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-trash-can" style="color:#d97706;"></i> Tempat Sampah Pengguna ({{ $trashedUsers->total() }})</h2>
                <p>Daftar akun pengguna yang dihapus sementara. Anda dapat memulihkan atau menghapus akun secara permanen.</p>
            </div>
            <a href="{{ route('admin.verifikasi-guru') }}" class="btn-back-main">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Pengguna
            </a>
        </div>

        <form action="{{ route('admin.users-trash') }}" method="GET" class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari di tempat sampah..." onchange="this.form.submit()">
        </form>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:50px;">NO</th>
                        <th>NAMA PENGGUNA</th>
                        <th>NIP / USERNAME / EMAIL</th>
                        <th>PERAN (ROLE)</th>
                        <th>WAKTU DIHAPUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedUsers as $index => $u)
                        <tr>
                            <td><strong>{{ $trashedUsers->firstItem() + $index }}</strong></td>
                            <td>
                                <strong style="color:#0f172a;">{{ $u->name }}</strong>
                            </td>
                            <td>
                                <div style="font-size:13px; font-weight:700; color:#3b5490;">NIP: {{ $u->nip ?? '-' }}</div>
                                <div style="font-size:12px; color:#64748b;">
                                    <code>{{ $u->username ?? '-' }}</code> | {{ $u->email ?? '-' }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleClass = match($u->role) {
                                        'tu', 'admin' => 'role-badge-admin',
                                        'guru' => 'role-badge-guru',
                                        'piket' => 'role-badge-piket',
                                        'wali_kelas' => 'role-badge-wali',
                                        default => '',
                                    };
                                @endphp
                                <span class="role-badge {{ $roleClass }}">
                                    {{ $u->getRoleLabelAttribute() }}
                                </span>
                            </td>
                            <td>{{ $u->deleted_at ? \Carbon\Carbon::parse($u->deleted_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('admin.users-trash.restore', $u->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" onclick="return confirm('Pulihkan akun pengguna {{ addslashes($u->name) }} ({{ addslashes($u->getRoleLabelAttribute()) }})?')" title="Pulihkan Akun">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users-trash.force-delete', $u->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-force-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus PERMANEN akun pengguna {{ addslashes($u->name) }} (NIP: {{ $u->nip ?? '-' }}, Role: {{ addslashes($u->getRoleLabelAttribute()) }})?\n\nTindakan ini bersifat permanen dan data tidak dapat dikembalikan!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-trash-arrow-up" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Tempat sampah kosong. Tidak ada data akun pengguna yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trashedUsers->hasPages())
            <div class="table-footer">
                <div>Menampilkan {{ $trashedUsers->firstItem() ?? 0 }} - {{ $trashedUsers->lastItem() ?? 0 }} dari {{ $trashedUsers->total() }} data sampah</div>
                <div>{{ $trashedUsers->links() }}</div>
            </div>
        @endif
    </div>

@endsection
