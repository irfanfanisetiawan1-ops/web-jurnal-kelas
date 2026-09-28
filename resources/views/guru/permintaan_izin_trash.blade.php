@extends('layouts.guru')

@section('title', 'Tempat Sampah Permintaan Izin Saya — EDU JOURNAL')

@section('styles')
<style>
    .page-title-box {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-box p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.01em;
    }

    /* Filter Bar Container Layout */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
    }

    .filter-input:focus {
        border-color: #384972;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #1e293b; }

    /* Floating Pop-up Batch Toolbar di Sampah */
    .floating-batch-bar {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(120px);
        background: #0f172a;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 999;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .floating-batch-bar.show {
        transform: translateX(-50%) translateY(0);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px 18px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .btn-action-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-restore {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }
    .btn-restore:hover {
        background: #bbf7d0;
        color: #14532d;
    }

    .btn-danger-custom {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }
    .btn-danger-custom:hover {
        background: #fca5a5;
        color: #7f1d1d;
    }

    /* Modal Styles */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: fadeInModal 0.2s ease;
    }

    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        background: #384972;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 { margin: 0; font-size: 16.5px; font-weight: 800; letter-spacing: -0.01em; }

    .modal-body {
        padding: 24px;
        text-align: center;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    /* Mobile Responsive Optimizations */
    @media (max-width: 768px) {
        .page-title-box {
            margin-bottom: 18px !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }

        .page-title-box h1 {
            font-size: 28px !important;
            line-height: 1.25 !important;
            font-weight: 800 !important;
        }

        .page-title-box p {
            font-size: 13px !important;
            margin-top: 6px !important;
        }

        .card-custom {
            border-radius: 14px !important;
            margin-bottom: 18px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .card-custom-header {
            padding: 14px 16px !important;
            gap: 8px !important;
        }

        .card-custom-header h2 {
            font-size: 15px !important;
        }

        .filter-bar-container {
            padding: 14px 14px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .filter-bar-container form {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .filter-bar-container form > div,
        .filter-bar-container form > a,
        .filter-bar-container form > button {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .filter-input {
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 13px !important;
            padding: 10px 12px !important;
        }

        .btn-filter-dark,
        .btn-reset-light {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
        }

        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-custom {
            min-width: 750px !important;
            width: 100% !important;
        }

        .table-custom th,
        .table-custom td {
            padding: 12px 14px !important;
        }

        .floating-batch-bar {
            width: calc(100% - 32px) !important;
            flex-direction: column !important;
            border-radius: 16px !important;
            padding: 14px !important;
            bottom: 16px !important;
            gap: 10px !important;
            box-sizing: border-box !important;
        }

        .floating-batch-bar > div {
            width: 100% !important;
            justify-content: space-between !important;
        }

        .modal-backdrop {
            padding: 12px !important;
        }

        .modal-card {
            border-radius: 14px !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .modal-header {
            padding: 14px 16px !important;
        }

        .modal-body {
            padding: 16px 14px !important;
            max-height: 72vh !important;
            box-sizing: border-box !important;
        }

        .modal-footer {
            padding: 12px 14px !important;
            flex-direction: column-reverse !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .modal-footer button,
        .modal-footer a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 10px 14px !important;
            box-sizing: border-box !important;
        }

        .desktop-trash-table-wrapper {
            display: none !important;
        }

        .mobile-trash-cards-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 12px 10px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    }

    /* Desktop vs Mobile Toggle for Trash */
    .desktop-trash-table-wrapper {
        display: block;
        width: 100%;
    }

    .mobile-trash-cards-wrapper {
        display: none;
    }

    .mobile-select-all-trash-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 4px;
    }

    .mobile-trash-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        overflow: hidden;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .mobile-trash-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .mobile-trash-header {
        padding: 12px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mobile-trash-body {
        padding: 14px;
    }

    .mobile-trash-footer {
        padding: 12px 14px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    @media (max-width: 480px) {
        .page-title-box h1 {
            font-size: 25px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="permintaan-izin-trash-page" style="width: 100%; max-width: 100%; min-width: 0; box-sizing: border-box; overflow-x: clip;">
<!-- Header Top Bar -->
<div class="page-title-box">
    <div>
        <h1>Tempat Sampah — Permintaan Izin Saya</h1>
        <p>Daftar riwayat pengajuan izin tidak hadir mengajar Anda yang dihapus sementara (soft delete)</p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('guru.permintaan-izin') }}" class="btn-action-link" style="padding: 10px 18px; background: #384972; color: #ffffff; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 13px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Permintaan Izin Saya
        </a>
    </div>
</div>

<div class="card-custom">
    <div class="card-custom-header">
        <h2>Daftar Data di Sampah ({{ $guruIzinList->count() }})</h2>
        @if($guruIzinList->isNotEmpty())
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button type="button" onclick="openRestoreAllModal()" class="btn-action-link btn-restore" style="padding: 8px 14px;">
                    <i class="fa-solid fa-rotate-left"></i> Pulihkan Semua Data
                </button>
                <button type="button" onclick="openEmptyTrashModal()" class="btn-action-link btn-danger-custom" style="padding: 8px 14px;">
                    <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                </button>
            </div>
        @endif
    </div>

    <!-- Filter Bar di Halaman Sampah -->
    <div class="filter-bar-container">
        <form action="{{ route('guru.permintaan-izin.trash') }}" method="GET">
            <div style="flex: 2; min-width: 220px;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Alasan, Materi di Sampah..." style="width: 100%;">
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" title="Filter Tanggal">
            </div>

            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>

            <a href="{{ route('guru.permintaan-izin.trash') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </form>
    </div>

    <div class="card-custom-body" style="padding: 0;">
        <!-- Desktop Trash Table View -->
        <div class="desktop-trash-table-wrapper">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllTrash" class="custom-checkbox" onchange="toggleSelectAllTrash(this)" title="Pilih Semua (Select All)">
                            </th>
                            <th>TANGGAL & KATEGORI</th>
                            <th>ALASAN & MATERI</th>
                            <th>LAMPIRAN DOKUMEN</th>
                            <th>DIHAPUS PADA</th>
                            <th style="text-align: center;">AKSI SIKLUS DATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $iz)
                        @php
                            $tglFormat = ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y')
                                : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y');
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="trash-checkbox custom-checkbox" value="{{ $iz->id_guru_izin }}" onchange="handleTrashCheckboxChange('{{ $iz->id_guru_izin }}')">
                            </td>
                            <td style="white-space: nowrap; font-weight: 600; color: #475569;">
                                <div style="font-weight: 700; color: #1e293b;">
                                    {{ $tglFormat }}
                                </div>
                                <div style="margin-top: 4px;">
                                    @if($iz->kategori_izin === 'cuti')
                                        <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                            Cuti (>3 Hari)
                                        </span>
                                    @else
                                        <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                            Izin Biasa
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="color: #334155; font-weight: 600;">{{ $iz->alasan }}</div>
                                @if($iz->materi_dititipkan)
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                        <i class="fa-solid fa-book"></i> Titipan: {{ $iz->materi_dititipkan }}
                                    </div>
                                @endif
                                @if($iz->keterangan_khusus)
                                    <div style="font-size: 11.5px; color: #c2410c; margin-top: 3px;">
                                        <i class="fa-solid fa-note-sticky"></i> Ket. Cuti: {{ $iz->keterangan_khusus }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                    @if($iz->foto_url)
                                        <a href="{{ $iz->foto_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 3px 8px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                                            <i class="fa-solid fa-image"></i> Foto Surat
                                        </a>
                                    @endif
                                    @if($iz->file_tugas_url)
                                        <a href="{{ $iz->file_tugas_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; padding: 3px 8px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                                            <i class="fa-solid fa-file-arrow-down"></i> File Tugas
                                        </a>
                                    @endif
                                    @if(!$iz->foto_url && !$iz->file_tugas_url)
                                        <span style="font-size: 12px; color: #94a3b8;">-</span>
                                    @endif
                                </div>
                            </td>
                            <td style="font-size: 12px; color: #64748b; font-weight: 600; white-space: nowrap;">
                                {{ $iz->deleted_at ? \Carbon\Carbon::parse($iz->deleted_at)->format('d-m-Y H:i') : '-' }}
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center; justify-content: center;">
                                    <button type="button" onclick="confirmSingleRestore({{ $iz->id_guru_izin }})" class="btn-action-link btn-restore" title="Pulihkan Data">
                                        <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                    </button>
                                    <button type="button" onclick="confirmSingleForceDelete({{ $iz->id_guru_izin }})" class="btn-action-link btn-danger-custom" title="Hapus Permanen">
                                        <i class="fa-solid fa-xmark"></i> Hapus Permanen
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 36px; color: #94a3b8; font-weight: 600;">
                                <i class="fa-solid fa-trash-can fa-2x mb-2" style="display: block; opacity: 0.5;"></i>
                                Tidak ada data izin di dalam Sampah Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Trash Cards View -->
        <div class="mobile-trash-cards-wrapper">
            @if($guruIzinList->isNotEmpty())
                <div class="mobile-select-all-trash-bar">
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #334155; cursor: pointer; margin: 0;">
                        <input type="checkbox" id="selectAllTrashMobile" class="custom-checkbox" onchange="toggleSelectAllTrash(this)" title="Pilih Semua Data Sampah">
                        <span>Pilih Semua Data Sampah</span>
                    </label>
                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">{{ $guruIzinList->count() }} Data</span>
                </div>
            @endif

            @forelse($guruIzinList as $iz)
            @php
                $tglFormat = ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                    ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y')
                    : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y');
            @endphp
            <div class="mobile-trash-card" id="trash_card_{{ $iz->id_guru_izin }}">
                <!-- Top Header -->
                <div class="mobile-trash-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" class="trash-checkbox custom-checkbox" value="{{ $iz->id_guru_izin }}" onchange="handleTrashCheckboxChange('{{ $iz->id_guru_izin }}')">
                        <div>
                            <div style="font-weight: 800; font-size: 14px; color: #0f172a;">
                                {{ $tglFormat }}
                            </div>
                            <div style="margin-top: 3px;">
                                @if($iz->kategori_izin === 'cuti')
                                    <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        Cuti (>3 Hari)
                                    </span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        Izin Biasa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: #64748b; font-weight: 600;">
                        <i class="fa-solid fa-clock"></i> {{ $iz->deleted_at ? \Carbon\Carbon::parse($iz->deleted_at)->format('d/m/Y H:i') : '-' }}
                    </div>
                </div>

                <!-- Body -->
                <div class="mobile-trash-body">
                    <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">
                        Alasan Permohonan Izin:
                    </div>
                    <div style="font-size: 13.5px; font-weight: 700; color: #1e293b; line-height: 1.45;">
                        {{ $iz->alasan }}
                    </div>
                    @if($iz->materi_dititipkan)
                        <div style="font-size: 12px; color: #334155; margin-top: 6px; background: #f8fafc; padding: 6px 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600;">
                            <i class="fa-solid fa-book" style="color: #384972;"></i> <strong>Titipan Materi:</strong> {{ $iz->materi_dititipkan }}
                        </div>
                    @endif
                    @if($iz->keterangan_khusus)
                        <div style="font-size: 12px; color: #c2410c; margin-top: 6px; background: #fff7ed; padding: 6px 10px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;">
                            <i class="fa-solid fa-note-sticky"></i> <strong>Ket. Khusus Cuti:</strong> {{ $iz->keterangan_khusus }}
                        </div>
                    @endif

                    <!-- Lampiran File -->
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                        @if($iz->foto_url)
                            <a href="{{ $iz->foto_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 4px 10px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                                <i class="fa-solid fa-image"></i> Foto Surat Bukti
                            </a>
                        @endif
                        @if($iz->file_tugas_url)
                            <a href="{{ $iz->file_tugas_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                                <i class="fa-solid fa-file-arrow-down"></i> File Tugas
                            </a>
                        @endif
                        @if(!$iz->foto_url && !$iz->file_tugas_url)
                            <span style="font-size: 12px; color: #94a3b8;"><i class="fa-solid fa-paperclip"></i> Tidak ada lampiran file</span>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="mobile-trash-footer">
                    <button type="button" onclick="confirmSingleRestore({{ $iz->id_guru_izin }})" class="btn-action-link btn-restore" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 9px 10px; font-size: 12px;">
                        <i class="fa-solid fa-rotate-left"></i> Pulihkan
                    </button>
                    <button type="button" onclick="confirmSingleForceDelete({{ $iz->id_guru_izin }})" class="btn-action-link btn-danger-custom" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 9px 10px; font-size: 12px;">
                        <i class="fa-solid fa-xmark"></i> Hapus Permanen
                    </button>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 36px 16px; color: #94a3b8; font-weight: 600; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px;">
                <i class="fa-solid fa-trash-can fa-2x mb-2" style="display: block; opacity: 0.5;"></i>
                Tidak ada data izin di dalam Sampah Anda.
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Floating Pop-up Batch Toolbar di Sampah -->
<div id="floatingTrashBatchBar" class="floating-batch-bar">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedTrashCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px; font-weight: 800;">0</span>
        <span>Data Sampah Terpilih</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="openBatchRestoreModal()" style="background: #10b981; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
        </button>
        <button type="button" onclick="openBatchForceDeleteModal()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-trash-can"></i> Hapus Permanen
        </button>
        <button type="button" onclick="uncheckAllTrash()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer;">
            Batal
        </button>
    </div>
</div>

<!-- Form Single Action (Hidden) -->
<form id="singleRestoreForm" action="" method="POST" style="display: none;">
    @csrf
</form>

<form id="singleForceDeleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Konfirmasi Pulihkan Satuan -->
<div id="singleRestoreModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #15803d;">
            <h3>Konfirmasi Pulihkan Data</h3>
            <button type="button" onclick="closeSingleRestoreModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body">
            <div style="width: 56px; height: 56px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Pulihkan Data Izin Ini?</h4>
            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                Data izin ini akan dikembalikan ke daftar aktif Permintaan Izin Saya.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeSingleRestoreModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
            <button type="button" onclick="submitSingleRestore()" class="btn-action-link btn-restore" style="padding: 10px 20px; font-size: 13px;">
                <i class="fa-solid fa-check"></i> Ya, Pulihkan Data
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Permanen Satuan -->
<div id="singleForceDeleteModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #dc2626;">
            <h3>Hapus Permanen</h3>
            <button type="button" onclick="closeSingleForceDeleteModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Hapus Data Ini Secara Permanen?</h4>
            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                PERINGATAN: File bukti foto dan dokumen tugas akan dihapus dari server. Data ini TIDAK DAPAT dipulihkan kembali!
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeSingleForceDeleteModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
            <button type="button" onclick="submitSingleForceDelete()" class="btn-action-link btn-danger-custom" style="padding: 10px 20px; font-size: 13px;">
                <i class="fa-solid fa-trash-can"></i> Ya, Hapus Permanen
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batch Restore -->
<div id="batchRestoreModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #15803d;">
            <h3>Pulihkan Data Terpilih</h3>
            <button type="button" onclick="closeBatchRestoreModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="batchRestoreForm" action="{{ route('guru.permintaan-izin.restore-batch') }}" method="POST">
            @csrf
            <input type="hidden" name="ids" id="batchRestoreIds">
            <div class="modal-body">
                <div style="width: 56px; height: 56px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Pulihkan <span id="batchRestoreModalCount">0</span> Data Terpilih?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    Semua data izin yang Anda centang akan dipulihkan ke daftar aktif Permintaan Izin Saya.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeBatchRestoreModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-link btn-restore" style="padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-check"></i> Ya, Pulihkan Semua Terpilih
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Batch Force Delete -->
<div id="batchForceDeleteModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #dc2626;">
            <h3>Hapus Permanen Data Terpilih</h3>
            <button type="button" onclick="closeBatchForceDeleteModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="batchForceDeleteForm" action="{{ route('guru.permintaan-izin.force-delete-batch') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="batchForceDeleteIds">
            <div class="modal-body">
                <div style="width: 56px; height: 56px; background: #fee2e2; color: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Hapus Permanen <span id="batchForceModalCount">0</span> Data Terpilih?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    PERINGATAN: Semua file dan lampiran untuk data terpilih akan dihapus permanen dari server. Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeBatchForceDeleteModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-link btn-danger-custom" style="padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-trash-can"></i> Ya, Hapus Terpilih Permanen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Pulihkan Semua -->
<div id="restoreAllModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #15803d;">
            <h3>Pulihkan Semua Data</h3>
            <button type="button" onclick="closeRestoreAllModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form action="{{ route('guru.permintaan-izin.restore-all') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div style="width: 56px; height: 56px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Pulihkan Seluruh Data di Sampah?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    Seluruh data izin yang berada di Sampah Anda akan dikembalikan ke daftar aktif Permintaan Izin Saya.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeRestoreAllModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-link btn-restore" style="padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-check"></i> Ya, Pulihkan Semua
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Kosongkan Sampah -->
<div id="emptyTrashModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header" style="background: #dc2626;">
            <h3>Kosongkan Sampah</h3>
            <button type="button" onclick="closeEmptyTrashModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form action="{{ route('guru.permintaan-izin.empty-trash') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div style="width: 56px; height: 56px; background: #fee2e2; color: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-dumpster"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Kosongkan Seluruh Data Sampah?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    PERINGATAN: Seluruh data izin di Sampah beserta file lampiran akan dihapus secara PERMANEN dari sistem. Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEmptyTrashModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-link btn-danger-custom" style="padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-dumpster"></i> Ya, Kosongkan Sampah
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    // Trash Checkbox & Floating Pop-up Batch Logic
    function toggleSelectAllTrash(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.trash-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        const selectAllDesktop = document.getElementById('selectAllTrash');
        const selectAllMobile = document.getElementById('selectAllTrashMobile');
        if (selectAllDesktop) selectAllDesktop.checked = masterCheckbox.checked;
        if (selectAllMobile) selectAllMobile.checked = masterCheckbox.checked;
        updateFloatingTrashBatchBar();
    }

    function handleTrashCheckboxChange(id) {
        if (id) {
            const matches = document.querySelectorAll('.trash-checkbox[value="' + id + '"]');
            const targetState = (window.event && window.event.target) ? window.event.target.checked : (matches[0] ? matches[0].checked : false);
            matches.forEach(cb => { cb.checked = targetState; });
        }
        
        const allIds = Array.from(new Set(Array.from(document.querySelectorAll('.trash-checkbox')).map(cb => cb.value)));
        const checkedIds = Array.from(new Set(Array.from(document.querySelectorAll('.trash-checkbox:checked')).map(cb => cb.value)));
        
        const isAllChecked = (allIds.length > 0 && checkedIds.length === allIds.length);
        const selectAllDesktop = document.getElementById('selectAllTrash');
        const selectAllMobile = document.getElementById('selectAllTrashMobile');
        if (selectAllDesktop) selectAllDesktop.checked = isAllChecked;
        if (selectAllMobile) selectAllMobile.checked = isAllChecked;
        
        updateFloatingTrashBatchBar();
    }

    function uncheckAllTrash() {
        const checkboxes = document.querySelectorAll('.trash-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = false;
        });
        const selectAllDesktop = document.getElementById('selectAllTrash');
        const selectAllMobile = document.getElementById('selectAllTrashMobile');
        if (selectAllDesktop) selectAllDesktop.checked = false;
        if (selectAllMobile) selectAllMobile.checked = false;
        updateFloatingTrashBatchBar();
    }

    function updateFloatingTrashBatchBar() {
        const checkedUnique = Array.from(new Set(Array.from(document.querySelectorAll('.trash-checkbox:checked')).map(cb => cb.value)));
        const count = checkedUnique.size !== undefined ? checkedUnique.size : checkedUnique.length;
        const bar = document.getElementById('floatingTrashBatchBar');
        const badge = document.getElementById('selectedTrashCountBadge');

        if (count > 0) {
            bar.classList.add('show');
            badge.innerText = count;
        } else {
            bar.classList.remove('show');
        }
    }

    // Batch Restore Modal
    function openBatchRestoreModal() {
        const checkedUnique = Array.from(new Set(Array.from(document.querySelectorAll('.trash-checkbox:checked')).map(cb => cb.value)));
        const count = checkedUnique.length;
        if (count === 0) {
            alert('Silakan pilih minimal 1 data yang ingin dipulihkan.');
            return;
        }
        document.getElementById('batchRestoreIds').value = checkedUnique.join(',');
        document.getElementById('batchRestoreModalCount').innerText = count;
        document.getElementById('batchRestoreModal').style.display = 'flex';
    }

    function closeBatchRestoreModal() {
        document.getElementById('batchRestoreModal').style.display = 'none';
    }

    // Batch Force Delete Modal
    function openBatchForceDeleteModal() {
        const checkedUnique = Array.from(new Set(Array.from(document.querySelectorAll('.trash-checkbox:checked')).map(cb => cb.value)));
        const count = checkedUnique.length;
        if (count === 0) {
            alert('Silakan pilih minimal 1 data yang ingin dihapus permanen.');
            return;
        }
        document.getElementById('batchForceDeleteIds').value = checkedUnique.join(',');
        document.getElementById('batchForceModalCount').innerText = count;
        document.getElementById('batchForceDeleteModal').style.display = 'flex';
    }

    function closeBatchForceDeleteModal() {
        document.getElementById('batchForceDeleteModal').style.display = 'none';
    }

    // Single Restore Modal
    let targetSingleRestoreId = null;
    function confirmSingleRestore(id) {
        targetSingleRestoreId = id;
        document.getElementById('singleRestoreModal').style.display = 'flex';
    }

    function closeSingleRestoreModal() {
        document.getElementById('singleRestoreModal').style.display = 'none';
        targetSingleRestoreId = null;
    }

    function submitSingleRestore() {
        if (targetSingleRestoreId) {
            const form = document.getElementById('singleRestoreForm');
            form.action = "{{ url('/guru-permintaan-izin-trash') }}/" + targetSingleRestoreId + "/restore";
            form.submit();
        }
    }

    // Single Force Delete Modal
    let targetSingleForceId = null;
    function confirmSingleForceDelete(id) {
        targetSingleForceId = id;
        document.getElementById('singleForceDeleteModal').style.display = 'flex';
    }

    function closeSingleForceDeleteModal() {
        document.getElementById('singleForceDeleteModal').style.display = 'none';
        targetSingleForceId = null;
    }

    function submitSingleForceDelete() {
        if (targetSingleForceId) {
            const form = document.getElementById('singleForceDeleteForm');
            form.action = "{{ url('/guru-permintaan-izin-trash') }}/" + targetSingleForceId + "/force";
            form.submit();
        }
    }

    // Restore All Modal
    function openRestoreAllModal() {
        document.getElementById('restoreAllModal').style.display = 'flex';
    }

    function closeRestoreAllModal() {
        document.getElementById('restoreAllModal').style.display = 'none';
    }

    // Empty Trash Modal
    function openEmptyTrashModal() {
        document.getElementById('emptyTrashModal').style.display = 'flex';
    }

    function closeEmptyTrashModal() {
        document.getElementById('emptyTrashModal').style.display = 'none';
    }
</script>
@endsection