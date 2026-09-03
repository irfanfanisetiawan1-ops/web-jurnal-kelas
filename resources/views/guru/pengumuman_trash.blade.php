@extends('layouts.guru')

@section('title', 'Sampah Pengumuman — EDU JOURNAL')

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
        color: #334155;
        vertical-align: middle;
    }

    .btn-action-sm {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-restore { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .btn-restore:hover { background: #a7f3d0; }

    .btn-force-delete { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .btn-force-delete:hover { background: #fca5a5; }

    .btn-back-light {
        background: #f1f5f9;
        color: #475569;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
</style>
@endsection

@section('content')
<div style="width: 100%;">

    <!-- Header Box -->
    <div class="page-header-box">
        <div class="page-header-info">
            <h1>
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Pengumuman Sekolah & Siswa Telat
            </h1>
            <p>Daftar riwayat pengumuman dan pemberitahuan siswa telat yang dihapus sementara (Soft Delete)</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('guru.pengumuman') }}" class="btn-back-light">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pengumuman
            </a>

            @if($trashedList->count() > 0)
                <form action="{{ route('guru.pengumuman.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda YAKIN ingin mengosongkan SELURUH sampah pengumuman ini? Data tidak dapat dikembalikan lagi.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action-sm btn-force-delete" style="padding: 9px 16px; border-radius: 10px;">
                        <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 700;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Dihapus Pada</th>
                        <th>Kategori & Judul</th>
                        <th>Isi Ringkas</th>
                        <th>Target Kelas / Guru</th>
                        <th>Pengirim</th>
                        <th style="text-align: center; width: 180px;">Aksi Pulihkan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedList as $index => $row)
                        @php
                            $isTelat = strtolower($row->kategori ?? '') === 'siswa telat';
                            $kelasNama = $row->kelas->nama_kelas ?? ($row->id_kelas ? 'Kelas #'.$row->id_kelas : 'Semua Kelas');
                            $pembuatNama = $row->pembuat->nama_guru ?? ($isTelat ? 'Guru Piket Sekolah' : 'Waka Kurikulum');
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $trashedList->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-size: 12px; color: #ef4444; font-weight: 700;">
                                    {{ \Carbon\Carbon::parse($row->deleted_at)->translatedFormat('d M Y H:i') }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    @if($isTelat)
                                        <span style="font-size: 11px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                                            <i class="fa-solid fa-user-clock"></i> Siswa Telat
                                        </span>
                                    @else
                                        <span style="font-size: 11px; background: #e0e7ff; color: #3730a3; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                                            {{ $row->kategori ?? 'Umum' }}
                                        </span>
                                    @endif
                                </div>
                                <div style="font-weight: 800; color: #0f172a; margin-top: 4px;">
                                    {{ $row->judul }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12.5px; color: #475569; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $row->isi }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    <i class="fa-solid fa-users" style="color: #384972;"></i> {{ $kelasNama }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #475569;">
                                    {{ $pembuatNama }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <form action="{{ route('guru.pengumuman.restore', $row->id_pengumuman) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-sm btn-restore" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('guru.pengumuman.force-delete', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Hapus permanen pengumuman ini? Data tidak akan bisa dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-sm btn-force-delete" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-trash-can" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                <p style="font-weight: 700; margin: 0; color: #64748b;">Sampah Pengumuman & Notifikasi kosong.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trashedList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0;">
                {{ $trashedList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
