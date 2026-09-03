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
                        <th>NO</th>
                        <th>NIP</th>
                        <th>NAMA GURU</th>
                        <th>JENIS KELAMIN</th>
                        <th>NOMOR HP</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel->gurus as $idx => $g)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><span style="font-family:monospace; color:#3b5490; font-weight:700;">{{ $g->nip }}</span></td>
                            <td><strong>{{ $g->nama_guru }}</strong></td>
                            <td>
                                @if($g->jenis_kelamin == 'L')
                                    Laki-laki
                                @elseif($g->jenis_kelamin == 'P')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $g->no_hp ?? '-' }}</td>
                            <td style="text-align:center;">
                                <a href="{{ route('guru.show', $g->id_guru) }}" class="btn-act btn-act-back" style="padding:5px 12px; font-size:12px;">
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
