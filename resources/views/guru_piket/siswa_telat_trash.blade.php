@extends('layouts.guru')

@section('title', 'Sampah Siswa Telat — EDU JOURNAL')

@section('styles')
<style>
    .siswa-telat-trash-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

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
        width: 100%;
        box-sizing: border-box;
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
        font-weight: 600;
    }

    .header-actions-wrapper {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .table-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .desktop-table-container {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-sizing: border-box;
    }

    .custom-table {
        width: 100%;
        min-width: 850px;
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
        white-space: nowrap;
    }

    .custom-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .custom-table tr:hover {
        background-color: #f8fafc;
    }

    .btn-action-sm {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
        box-sizing: border-box;
        transition: all 0.15s ease;
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
        box-sizing: border-box;
        transition: all 0.15s ease;
    }
    .btn-back-light:hover { background: #e2e8f0; color: #0f172a; }

    /* Mobile Trash Cards List */
    .mobile-trash-card-list {
        display: none;
        flex-direction: column;
        gap: 12px;
        padding: 14px;
        box-sizing: border-box;
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
        box-sizing: border-box;
    }

    .mobile-trash-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .mobile-trash-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 4px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 8px;
    }

    /* Responsive Media Queries */
    @media (max-width: 768px) {
        .page-header-box {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 16px 14px !important;
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
        }

        .header-actions-wrapper {
            width: 100% !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .header-actions-wrapper a,
        .header-actions-wrapper form,
        .header-actions-wrapper button {
            width: 100% !important;
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
            padding: 14px 12px !important;
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

    @media (max-width: 480px) {
        .page-header-info h1 {
            font-size: 26px !important;
        }

        .mobile-trash-card-actions {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')
<div class="siswa-telat-trash-container">

    <!-- Header Box -->
    <div class="page-header-box">
        <div class="page-header-info">
            <h1>
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Sampah Data Siswa Telat
            </h1>
            <p>Daftar riwayat data siswa telat yang dihapus sementara (Soft Delete)</p>
        </div>
        <div class="header-actions-wrapper">
            <a href="{{ route('piket.siswa-telat') }}" class="btn-back-light">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Siswa Telat
            </a>

            @if($trashedList->count() > 0)
                <form action="{{ route('piket.siswa-telat.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda YAKIN ingin mengosongkan SELURUH sampah data Siswa Telat ini? Data tidak dapat dikembalikan lagi.');" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action-sm btn-force-delete" style="padding: 9px 16px; border-radius: 10px; width: 100%;">
                        <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <!-- DESKTOP TABLE CONTAINER -->
        <div class="desktop-table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Dihapus Pada</th>
                        <th>Data Siswa</th>
                        <th>Guru Mengajar Target</th>
                        <th>Waktu & Tanggal Terlambat</th>
                        <th>Alasan & Hukuman</th>
                        <th style="text-align: center; width: 180px;">Aksi Pulihkan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedList as $index => $row)
                        @php
                            $siswaObj = $row->siswa;
                            $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                            $guruObj  = $row->guruMengajar;
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
                                <div style="font-weight: 800; color: #0f172a;">
                                    {{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}
                                </div>
                                <div style="font-size: 12px; color: #64748b;">
                                    Kelas: {{ $kelasObj->nama_kelas ?? '-' }} • NIS: {{ $siswaObj->nis ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    {{ $guruObj->nama_guru ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700;">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size: 11.5px; color: #d97706; font-weight: 800;">
                                    Jam {{ $row->jam_terlambat }} WIB
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $row->alasan }}</div>
                                @if($row->tindakan_hukuman)
                                    <div style="font-size: 11.5px; color: #991b1b;">
                                        Hukuman: {{ $row->tindakan_hukuman }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <form action="{{ route('piket.siswa-telat.restore', $row->id_siswa_telat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-sm btn-restore" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('piket.siswa-telat.force-delete', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Hapus permanen data ini? Data tidak akan bisa dikembalikan.');">
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
                                <p style="font-weight: 700; margin: 0; color: #64748b;">Sampah Siswa Telat kosong.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE TRASH CARDS LIST -->
        <div class="mobile-trash-card-list">
            @forelse($trashedList as $index => $row)
                @php
                    $siswaObj = $row->siswa;
                    $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                    $guruObj  = $row->guruMengajar;
                @endphp
                <div class="mobile-trash-card">
                    <div class="mobile-trash-card-header">
                        <span style="font-weight: 800; font-size: 12px; color: #64748b;">#{{ $trashedList->firstItem() + $index }}</span>
                        <div style="font-size: 11px; color: #ef4444; font-weight: 700; background: #fee2e2; padding: 2px 8px; border-radius: 6px; border: 1px solid #fca5a5;">
                            <i class="fa-solid fa-trash-can"></i> {{ \Carbon\Carbon::parse($row->deleted_at)->translatedFormat('d M Y H:i') }}
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="font-weight: 800; color: #0f172a; font-size: 14.5px;">
                            {{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}
                        </div>
                        <div style="font-size: 11.5px; color: #64748b;">
                            Kelas: {{ $kelasObj->nama_kelas ?? '-' }} • NIS: {{ $siswaObj->nis ?? '-' }}
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 10px; padding: 10px 12px; display: flex; flex-direction: column; gap: 6px; border: 1px solid #f1f5f9; font-size: 12px;">
                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Guru Mengajar Target:</span>
                            <strong style="color: #1e293b;">
                                <i class="fa-solid fa-user-tie" style="color: #475569; margin-right: 4px;"></i>
                                {{ $guruObj->nama_guru ?? '-' }}
                            </strong>
                        </div>

                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Waktu Terlambat:</span>
                            <strong style="color: #0f172a;">
                                {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                            </strong>
                            <span style="color: #d97706; font-weight: 800; margin-left: 4px;">(Jam {{ $row->jam_terlambat }} WIB)</span>
                        </div>

                        <div>
                            <span style="color: #64748b; font-size: 10.5px; font-weight: 700; display: block; text-transform: uppercase;">Alasan:</span>
                            <span style="font-weight: 600; color: #1e293b;">{{ $row->alasan }}</span>
                        </div>

                        @if($row->tindakan_hukuman)
                            <div style="font-size: 11.5px; color: #991b1b; background: #fff1f2; padding: 4px 8px; border-radius: 6px; border: 1px solid #fecdd3;">
                                <strong>Hukuman:</strong> {{ $row->tindakan_hukuman }}
                            </div>
                        @endif
                    </div>

                    <div class="mobile-trash-card-actions">
                        <form action="{{ route('piket.siswa-telat.restore', $row->id_siswa_telat) }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn-action-sm btn-restore" style="width: 100%;" title="Pulihkan Data">
                                <i class="fa-solid fa-rotate-left"></i> Restore
                            </button>
                        </form>

                        <form action="{{ route('piket.siswa-telat.force-delete', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Hapus permanen data ini? Data tidak akan bisa dikembalikan.');" style="width: 100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-sm btn-force-delete" style="width: 100%;" title="Hapus Permanen">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 32px 16px; background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; color: #94a3b8;">
                    <i class="fa-solid fa-trash-can" style="font-size: 36px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                    <p style="font-weight: 700; font-size: 13.5px; margin: 0; color: #64748b;">Sampah Siswa Telat kosong.</p>
                </div>
            @endforelse
        </div>

        @if($trashedList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0;">
                {{ $trashedList->withQueryString()->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>

</div>
@endsection
