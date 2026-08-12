@extends('layouts.admin')

@section('title', 'Jurnal Piket — EduJournal')
@section('header_title', 'Kelola Jurnal Guru Piket')
@section('header_subtitle', 'Pencatatan aktivitas, pemantauan suasana sekolah, dan kejadian harian')

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
            <a href="{{ route('jurnal-piket.create') }}" class="btn-create">
                <i class="fa-solid fa-plus"></i> Tambah Jurnal Piket
            </a>
            <a href="{{ route('jurnal-piket.trash') }}" class="btn-trash-view">
                <i class="fa-solid fa-trash-can"></i> Lihat Sampah Jurnal Piket
            </a>
        </div>
    </div>

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Piket</th>
                        <th>Petugas Piket</th>
                        <th>Status Suasana</th>
                        <th>Catatan / Kejadian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $jp)
                        <tr>
                            <td><strong>{{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}</strong></td>
                            <td><code>{{ $jp->jam_piket }}</code></td>
                            <td><strong>{{ $jp->nama_petugas_piket }}</strong></td>
                            <td>
                                @if($jp->status_suasana == 'Kondusif')
                                    <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">Kondusif</span>
                                @else
                                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">{{ $jp->status_suasana }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($jp->catatan_kejadian, 40) }}</td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('jurnal-piket.edit', $jp->id_jurnal_piket) }}" class="btn-icon btn-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('jurnal-piket.destroy', $jp->id_jurnal_piket) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Hapus entri piket ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 32px;">
                                Belum ada entri jurnal piket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
