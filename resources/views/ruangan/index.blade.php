@extends('layouts.admin')

@section('title', 'Ruangan — EduJournal Admin')
@section('header_title', 'Kelola Ruangan Pembelajaran')
@section('header_subtitle', 'Manajemen gedung, kelas biasa, laboratorium, dan ruang praktik')

@section('styles')
<style>
    .action-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .btn-create { background: #4f46e5; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-trash-view { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .table-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b; background: #f8fafc; padding: 14px 18px; font-weight: 700; text-align: left; }
    .custom-table td { padding: 14px 18px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #334155; vertical-align: middle; }
    .btn-icon { padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; border: none; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-edit { background: #e0e7ff; color: #3730a3; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
</style>
@endsection

@section('content')

    <div class="action-header">
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('ruangan.create') }}" class="btn-create">
                <i class="fa-solid fa-plus"></i> Tambah Data Ruangan
            </a>
            <a href="{{ route('ruangan.trash') }}" class="btn-trash-view">
                <i class="fa-solid fa-trash-can"></i> Lihat Sampah Ruangan
            </a>
        </div>
    </div>

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama Ruangan</th>
                        <th>Jenis Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruangans as $r)
                        <tr>
                            <td><strong>{{ $r->nama_ruangan }}</strong></td>
                            <td>
                                <span style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    {{ $r->jenis_ruangan }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('ruangan.edit', $r->id_ruangan) }}" class="btn-icon btn-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('ruangan.destroy', $r->id_ruangan) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Pindahkan {{ $r->nama_ruangan }} ke sampah?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #94a3b8; padding: 32px;">
                                Belum ada data ruangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
