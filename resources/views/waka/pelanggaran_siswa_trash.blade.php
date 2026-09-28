@extends('layouts.waka')

@section('title', 'Kotak Sampah Pelanggaran Siswa — Jurnal SMEA')

@section('styles')
<style>
    .trash-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .trash-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .trash-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .trash-title-box p {
        font-size: 13.5px;
        color: #64748b;
        margin: 4px 0 0;
    }

    .trash-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-trash-action {
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-back-pelanggaran {
        background: #e2e8f0;
        color: #334155;
    }
    .btn-back-pelanggaran:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .btn-empty-all-trash {
        background: #dc2626;
        color: #ffffff;
    }
    .btn-empty-all-trash:hover {
        background: #b91c1c;
    }

    .trash-card-wrapper {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
    }

    .mobile-trash-wrapper {
        display: none;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        border: none;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .trash-container {
            gap: 14px;
        }

        .trash-header-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .trash-title-box h1 {
            font-size: 20px !important;
        }

        .trash-title-box p {
            font-size: 12px !important;
        }

        .trash-header-actions {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .trash-header-actions .btn-trash-action,
        .trash-header-actions form {
            width: 100% !important;
        }

        .trash-header-actions form button {
            width: 100% !important;
            justify-content: center !important;
        }

        .btn-back-pelanggaran {
            justify-content: center !important;
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        .desktop-trash-table-wrapper {
            display: none !important;
        }

        .mobile-trash-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            padding: 12px !important;
            background: #f8fafc !important;
        }

        .mobile-trash-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .m-trash-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .m-trash-name {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            line-height: 1.25;
        }

        .m-trash-nis {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
        }

        .m-trash-meta-box {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .m-trash-action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 2px;
        }

        .m-btn-trash-action {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        .m-btn-restore {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .m-btn-restore:active {
            background: #16a34a;
            color: #ffffff;
        }

        .m-btn-force-delete {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .m-btn-force-delete:active {
            background: #dc2626;
            color: #ffffff;
        }

        .custom-pagination-bar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            text-align: center !important;
        }

        .pagination-info {
            font-size: 12px !important;
            color: #64748b !important;
            text-align: center !important;
        }

        .pagination-list {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
        }

        .pagination-list .page-link {
            min-width: 32px !important;
            height: 32px !important;
            padding: 0 6px !important;
            font-size: 12px !important;
            border-radius: 8px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="trash-container">

    <div class="trash-header-row">
        <div class="trash-title-box">
            <h1>Kotak Sampah Pelanggaran Siswa</h1>
            <p>Pulihkan atau hapus permanen data pelanggaran siswa yang telah dihapus.</p>
        </div>

        <div class="trash-header-actions">
            <a href="{{ route('waka.pelanggaran-siswa') }}" class="btn-trash-action btn-back-pelanggaran">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pelanggaran
            </a>

            @if($trashedPelanggarans->total() > 0)
                <form action="{{ route('waka.pelanggaran-siswa.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Seluruh data di kotak sampah akan dihapus secara PERMANEN! Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-trash-action btn-empty-all-trash">
                        <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="trash-card-wrapper">
        <!-- Desktop Table View -->
        <div class="desktop-trash-table-wrapper" style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Nama Siswa</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Kelas</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Jenis Pelanggaran</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Tanggal Dihapus</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedPelanggarans as $tp)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:16px 18px;">
                                <strong>{{ $tp->siswa->nama_siswa ?? '-' }}</strong>
                                <div style="font-size:12px; color:#64748b;">NIS: {{ $tp->siswa->nis ?? '-' }}</div>
                            </td>
                            <td style="padding:16px 18px;">{{ $tp->kelas->nama_kelas ?? ($tp->siswa->kelas->nama_kelas ?? '-') }}</td>
                            <td style="padding:16px 18px;">
                                <span style="font-size:11px; font-weight:800; padding:2px 6px; border-radius:4px; background:#fee2e2; color:#991b1b;">{{ $tp->kategori_pelanggaran }}</span>
                                <span style="font-weight:600; color:#0f172a;">{{ $tp->jenis_pelanggaran }}</span>
                            </td>
                            <td style="padding:16px 18px; font-size:13px; color:#64748b;">{{ $tp->deleted_at ? $tp->deleted_at->format('d/m/Y H:i') : '-' }}</td>
                            <td style="padding:16px 18px; text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('waka.pelanggaran-siswa.restore', $tp->id_pelanggaran) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-icon" style="background:#dcfce7; color:#15803d; border:1px solid #bbf7d0;" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('waka.pelanggaran-siswa.force-delete', $tp->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus data pelanggaran ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon" style="background:#fee2e2; color:#dc2626; border:1px solid #fecaca;" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#94a3b8;">
                                Kotak sampah pelanggaran siswa kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Trashed Cards View -->
        <div class="mobile-trash-wrapper">
            @forelse($trashedPelanggarans as $tp)
                <div class="mobile-trash-card">
                    <div class="m-trash-header">
                        <div>
                            <h4 class="m-trash-name">{{ $tp->siswa->nama_siswa ?? '-' }}</h4>
                            <div class="m-trash-nis">NIS: {{ $tp->siswa->nis ?? '-' }} &bull; {{ $tp->kelas->nama_kelas ?? ($tp->siswa->kelas->nama_kelas ?? '-') }}</div>
                        </div>
                        <span style="font-size:11px; font-weight:800; padding:3px 8px; border-radius:6px; background:#fee2e2; color:#991b1b; text-transform:uppercase;">
                            {{ $tp->kategori_pelanggaran }}
                        </span>
                    </div>

                    <div style="font-size:13px; font-weight:700; color:#0f172a;">
                        {{ $tp->jenis_pelanggaran }}
                    </div>

                    <div class="m-trash-meta-box">
                        <div style="color:#64748b;">
                            <i class="fa-regular fa-calendar-xmark"></i> Dihapus: <strong>{{ $tp->deleted_at ? $tp->deleted_at->format('d/m/Y H:i') : '-' }}</strong>
                        </div>
                    </div>

                    <div class="m-trash-action-grid">
                        <form action="{{ route('waka.pelanggaran-siswa.restore', $tp->id_pelanggaran) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="m-btn-trash-action m-btn-restore">
                                <i class="fa-solid fa-rotate-left"></i> Pulihkan
                            </button>
                        </form>
                        <form action="{{ route('waka.pelanggaran-siswa.force-delete', $tp->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus data pelanggaran ini secara permanen?')" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="m-btn-trash-action m-btn-force-delete">
                                <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:36px 16px; color:#94a3b8; background:#ffffff; border-radius:12px; border:1.5px dashed #cbd5e1;">
                    Kotak sampah pelanggaran siswa kosong.
                </div>
            @endforelse
        </div>

        <!-- Table Footer -->
        <div style="padding:16px 20px; background:#ffffff; border-top:1px solid #f1f5f9;">
            {{ $trashedPelanggarans->links('partials.custom-pagination') }}
        </div>
    </div>

</div>
@endsection