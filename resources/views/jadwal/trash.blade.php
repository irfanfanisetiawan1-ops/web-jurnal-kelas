@extends('layouts.admin')

@section('title', 'Tempat Sampah Jadwal Pelajaran — Jurnal ESEMKITA')

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
    .card-top-header p {
        font-size: 13px;
        color: #64748b;
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
        gap: 6px;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12.5px;
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
        border-color: #16a34a;
    }

    .btn-force-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-force-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13.5px;
        font-weight: 600;
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('jadwal.index') }}"><i class="fa-solid fa-calendar-days"></i> Manajemen Jadwal Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tempat Sampah Jadwal</span>
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
        <div class="alert-custom alert-danger">
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
                <h2><i class="fa-solid fa-trash-can" style="color:#d97706;"></i> Tempat Sampah Jadwal ({{ count($jadwals) }})</h2>
                <p>Daftar jadwal pelajaran yang dihapus sementara. Anda dapat memulihkan atau menghapus permanen.</p>
            </div>
            <a href="{{ route('jadwal.index') }}" class="btn-back-main">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Jadwal
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>HARI & JAM</th>
                        <th>KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>GURU PENGAMPU</th>
                        <th>RUANGAN</th>
                        <th>WAKTU DIHAPUS</th>
                        <th style="text-align:center; min-width: 220px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $index => $item)
                        <tr>
                            <td style="font-weight:700; color:#64748b;">{{ $index + 1 }}</td>
                            <td>
                                <strong style="color:#0f172a;">{{ $item->hari }}</strong><br>
                                <small style="color:#3b5490; font-weight:700;">Jam ke-{{ $item->jam_range }} ({{ $item->waktu_range }})</small>
                            </td>
                            <td><strong style="color:#0f172a;">{{ $item->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                            <td>
                                <strong>{{ $item->guru->nama_guru ?? '-' }}</strong><br>
                                <small style="color:#64748b;">NIP: {{ $item->guru->nip ?? '-' }}</small>
                            </td>
                            <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                            <td>{{ $item->deleted_at ? \Carbon\Carbon::parse($item->deleted_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('jadwal.restore', $item->id_jadwal) }}" method="POST" style="display:inline-block;" id="restoreForm-{{ $item->id_jadwal }}">
                                        @csrf
                                        <button type="button" class="btn-act btn-restore" onclick="confirmRestore('restoreForm-{{ $item->id_jadwal }}', '{{ addslashes(($item->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($item->mapel->nama_mapel ?? 'Mapel') . ' (' . $item->hari . ')') }}')" title="Pulihkan Jadwal">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('jadwal.force-delete', $item->id_jadwal) }}" method="POST" style="display:inline-block;" id="forceDeleteForm-{{ $item->id_jadwal }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-act btn-force-delete" onclick="confirmForceDelete('forceDeleteForm-{{ $item->id_jadwal }}', '{{ addslashes(($item->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($item->mapel->nama_mapel ?? 'Mapel') . ' (' . $item->hari . ')') }}')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px 20px; color:#94a3b8;">
                                <i class="fa-solid fa-trash-can" style="font-size:36px; margin-bottom:10px; display:block; color:#cbd5e1;"></i>
                                <strong style="font-size:15px; color:#475569; display:block; margin-bottom:4px;">Tempat sampah kosong</strong>
                                <span>Tidak ada data jadwal pelajaran yang dihapus.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmRestore(formId, name) {
        Swal.fire({
            title: 'Konfirmasi Pulihkan Data',
            text: `Apakah Anda yakin ingin memulihkan data jadwal "${name}" dari Tempat Sampah?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Pulihkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    function confirmForceDelete(formId, name) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: `Data jadwal "${name}" akan dihapus selamanya dari database dan TIDAK DAPAT DITEMUKAN LAGI!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection
