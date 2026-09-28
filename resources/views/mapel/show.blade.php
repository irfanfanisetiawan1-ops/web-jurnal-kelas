@extends('layouts.admin')

@section('title', 'Detail Mapel — ' . $mapel->nama_mapel)

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

    .detail-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .avatar-large {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, #d97706, #f59e0b);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        box-shadow: 0 6px 16px rgba(217, 119, 6, 0.25);
    }

    .profile-info h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .kode-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        color: #b45309;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #fde68a;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        border-radius: 14px;
    }

    .info-item .label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
    }

    .info-item .value {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .btn-act {
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-act-back {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .btn-act-back:hover { background: #e2e8f0; }

    .btn-act-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-act-edit:hover { background: #d97706; color: #ffffff; }

    .btn-act-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-act-delete:hover { background: #e11d48; color: #ffffff; }

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

    .mobile-no-badge,
    .mobile-label-text {
        display: none;
    }

    .badge-gender {
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-gender-l {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .badge-gender-p {
        background: #fce7f3;
        color: #be185d;
        border: 1px solid #fbcfe8;
    }

    /* ========================================================
       MOBILE RESPONSIVE STYLES (KHUSUS MOBILE HP <= 768px & <= 480px)
       Tampilan Desktop/Laptop Tetap 100% Sesuai & Tidak Terganggu
       ======================================================== */
    @media (max-width: 768px) {
        .page-header-container {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            line-height: 1.25 !important;
        }

        .page-title-group p {
            font-size: 13px !important;
        }

        .breadcrumb-text {
            font-size: 12.5px !important;
            margin-bottom: 16px !important;
        }

        .detail-card {
            padding: 16px 14px !important;
            border-radius: 14px !important;
            margin-bottom: 18px !important;
            box-sizing: border-box !important;
            width: 100% !important;
            overflow: hidden !important;
        }

        .profile-header {
            gap: 14px !important;
            padding-bottom: 16px !important;
            margin-bottom: 16px !important;
            align-items: flex-start !important;
        }

        .avatar-large {
            width: 56px !important;
            height: 56px !important;
            font-size: 22px !important;
            border-radius: 14px !important;
        }

        .profile-info h1 {
            font-size: 20px !important;
            margin-bottom: 4px !important;
        }

        .kode-pill {
            font-size: 12px !important;
            padding: 3px 10px !important;
        }

        .info-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        .info-item {
            padding: 12px 14px !important;
            border-radius: 12px !important;
        }

        .info-item .label {
            font-size: 10.5px !important;
            margin-bottom: 4px !important;
        }

        .info-item .value {
            font-size: 14px !important;
        }

        .action-row {
            flex-direction: column !important;
            width: 100% !important;
            gap: 10px !important;
            padding-top: 16px !important;
            margin-top: 16px !important;
        }

        .action-row a.btn-act,
        .action-row form,
        .action-row form button.btn-act {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            text-align: center !important;
            margin: 0 !important;
        }

        /* Transform Tabel Guru Pengampu ke Mobile Card (Bebas Geser & Tidak Kepotong) */
        .table-responsive {
            border: none !important;
            overflow-x: hidden !important;
            width: 100% !important;
        }

        .table-custom {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .table-custom thead {
            display: none !important;
        }

        .table-custom tbody {
            display: block !important;
            width: 100% !important;
        }

        .table-custom tbody tr.guru-row-card {
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            padding: 14px !important;
            margin-bottom: 12px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow: hidden !important;
        }

        .table-custom tbody tr.guru-row-card:last-child {
            margin-bottom: 0 !important;
        }

        .table-custom tbody tr.guru-row-card td {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-sizing: border-box !important;
        }

        .table-custom tbody tr.guru-row-card .col-no {
            display: none !important;
        }

        .table-custom tbody tr.guru-row-card .col-nama {
            order: 1 !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
        }

        .table-custom tbody tr.guru-row-card .col-nama strong {
            font-size: 15px !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            word-break: normal !important;
            overflow-wrap: normal !important;
            white-space: normal !important;
        }

        .table-custom tbody tr.guru-row-card .col-gender {
            order: 2 !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            margin-top: 1px !important;
            margin-bottom: 2px !important;
        }

        .table-custom tbody tr.guru-row-card .col-nip {
            order: 3 !important;
            width: 100% !important;
            background: #f8fafc !important;
            padding: 8px 12px !important;
            border-radius: 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 12.5px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            box-sizing: border-box !important;
        }

        .table-custom tbody tr.guru-row-card .col-hp {
            order: 4 !important;
            width: 100% !important;
            background: #f8fafc !important;
            padding: 8px 12px !important;
            border-radius: 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 12.5px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            box-sizing: border-box !important;
        }

        .table-custom tbody tr.guru-row-card .col-aksi {
            order: 5 !important;
            width: 100% !important;
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
            display: block !important;
            box-sizing: border-box !important;
        }

        .table-custom tbody tr.guru-row-card .col-aksi .btn-act {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px 16px !important;
            font-size: 13px !important;
            border-radius: 10px !important;
            box-sizing: border-box !important;
        }

        .mobile-no-badge {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #f1f5f9 !important;
            color: #475569 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 2px 7px !important;
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
            flex-shrink: 0 !important;
        }

        .mobile-label-text {
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-weight: 700 !important;
            color: #64748b !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .table-custom tbody tr.guru-row-card {
            padding: 12px 10px !important;
        }

        .table-custom tbody tr.guru-row-card .col-nip,
        .table-custom tbody tr.guru-row-card .col-hp {
            font-size: 12px !important;
            padding: 7px 10px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Detail Mata Pelajaran</h1>
            <p>Rincian data kurikulum dan informasi mata pelajaran</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('mapel.index') }}"><i class="fa-solid fa-book"></i> Master Mapel</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Mapel</span>
    </div>

    <div class="detail-card">
        <div class="profile-header">
            <div class="avatar-large"><i class="fa-solid fa-book-open"></i></div>
            <div class="profile-info">
                <h1>{{ $mapel->nama_mapel }}</h1>
                <span class="kode-pill">
                    <i class="fa-solid fa-barcode"></i> Kode Mapel: {{ $mapel->kode_mapel }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">Nama Mata Pelajaran</div>
                <div class="value">{{ $mapel->nama_mapel }}</div>
            </div>

            <div class="info-item">
                <div class="label">Kode Mapel</div>
                <div class="value" style="font-family:monospace; color:#d97706;">{{ $mapel->kode_mapel }}</div>
            </div>

            <div class="info-item">
                <div class="label">Jumlah Guru Pengampu</div>
                <div class="value" style="color:#be185d;">{{ $mapel->gurus_count ?? count($mapel->gurus) }} Guru</div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('mapel.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Mapel
            </a>
            <a href="{{ route('mapel.edit', $mapel->id_mapel) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Mapel
            </a>
            <form action="{{ route('mapel.destroy', $mapel->id_mapel) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus mapel {{ addslashes($mapel->nama_mapel) }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Mapel
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Guru Pengampu Mapel Ini -->
    <div class="detail-card">
        <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-users" style="color:#2563eb;"></i> Daftar Guru Pengampu ({{ count($mapel->gurus) }})
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">NO</th>
                        <th>NIP</th>
                        <th>NAMA GURU</th>
                        <th>JENIS KELAMIN</th>
                        <th>NOMOR HP</th>
                        <th style="text-align:center; width: 140px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel->gurus as $idx => $g)
                        <tr class="guru-row-card">
                            <td class="col-no" style="text-align: center;">{{ $idx + 1 }}</td>
                            <td class="col-nip">
                                <span class="mobile-label-text"><i class="fa-solid fa-id-card" style="font-size:11px;"></i> NIP:</span>
                                <span style="font-family:monospace; color:#3b5490; font-weight:700;">{{ $g->nip }}</span>
                            </td>
                            <td class="col-nama">
                                <span class="mobile-no-badge">#{{ $idx + 1 }}</span>
                                <strong>{{ $g->nama_guru }}</strong>
                            </td>
                            <td class="col-gender">
                                @if($g->jenis_kelamin == 'L')
                                    <span class="badge-gender badge-gender-l"><i class="fa-solid fa-mars"></i> Laki-laki</span>
                                @elseif($g->jenis_kelamin == 'P')
                                    <span class="badge-gender badge-gender-p"><i class="fa-solid fa-venus"></i> Perempuan</span>
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td class="col-hp">
                                <span class="mobile-label-text"><i class="fa-solid fa-phone" style="font-size:11px;"></i> HP:</span>
                                <span style="color:#0f172a; font-weight:600;">{{ $g->no_hp ?? '-' }}</span>
                            </td>
                            <td class="col-aksi" style="text-align:center;">
                                <a href="{{ route('guru.show', $g->id_guru) }}" class="btn-act btn-act-back" style="padding:6px 14px; font-size:12.5px;">
                                    <i class="fa-solid fa-eye"></i> Detail Guru
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8;">
                                Belum ada guru yang mengampu mata pelajaran ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
