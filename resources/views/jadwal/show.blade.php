@extends('layouts.admin')

@section('title', 'Detail Jadwal Pelajaran — ' . ($jadwal->kelas->nama_kelas ?? 'Kelas'))

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
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.25);
    }

    .profile-info h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .kelas-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0e7ff;
        color: #3730a3;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #c7d2fe;
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

    /* Table Component */
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
            <h1>Detail Jadwal Pelajaran</h1>
            <p>Informasi rincian sesi jadwal mengajar dan kelas terpilih</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('jadwal.index') }}"><i class="fa-solid fa-calendar-days"></i> Data Jadwal Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Jadwal</span>
    </div>

    <!-- Top Card: Header & Grid Info (Exact Match with Halaman Kelas) -->
    <div class="detail-card">
        <div class="profile-header">
            <div class="avatar-large"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="profile-info">
                <h1>Jadwal Pelajaran Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }}</h1>
                <span class="kelas-pill">
                    <i class="fa-solid fa-book-bookmark"></i> {{ $jadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">Hari & Jam Pelajaran</div>
                <div class="value" style="color:#2563eb;">{{ $jadwal->hari }} (Jam ke-{{ $jadwal->jam_range }})</div>
                <div style="font-size:12.5px; color:#64748b; margin-top:2px; font-weight:600;">Waktu: {{ $jadwal->waktu_range }}</div>
            </div>

            <div class="info-item">
                <div class="label">Rombongan Belajar</div>
                <div class="value">{{ $jadwal->kelas->nama_kelas ?? '-' }}</div>
                <div style="font-size:12.5px; color:#3b5490; margin-top:2px; font-weight:600;">Jurusan: {{ $jadwal->kelas->jurusan->nama_jurusan ?? '-' }}</div>
            </div>

            <div class="info-item">
                <div class="label">Wali Kelas</div>
                <div class="value">
                    @if($jadwal->kelas && $jadwal->kelas->waliKelas)
                        {{ $jadwal->kelas->waliKelas->nama_guru }} <span style="font-size:12px; color:#64748b; font-weight:600;">(NIP: {{ $jadwal->kelas->waliKelas->nip }})</span>
                    @else
                        <span style="color:#94a3b8; font-style:italic;">Belum ditentukan</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="label">Lokasi Ruangan</div>
                <div class="value">{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</div>
                <div style="font-size:12.5px; color:#64748b; margin-top:2px; font-weight:600;">Jenis: {{ $jadwal->ruangan->jenis_ruangan ?? '-' }}</div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('jadwal.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Jadwal
            </a>
            <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Jadwal
            </a>
            <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline-block;" id="formDeleteJadwal">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data jadwal kelas {{ addslashes($jadwal->kelas->nama_kelas ?? 'ini') }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Jadwal
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Card: Detail Komponen Alokasi KBM & Guru Pengampu -->
    <div class="detail-card">
        <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-chalkboard-user" style="color:#2563eb;"></i> Komponen Alokasi KBM & Guru Pengampu
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>KOMPONEN JADWAL</th>
                        <th>INFORMASI RINCIAN</th>
                        <th style="text-align:center;">AKSI / TAUTAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Guru Pengampu</strong></td>
                        <td>
                            <strong>{{ $jadwal->guru->nama_guru ?? '-' }}</strong><br>
                            <span style="font-size:12px; color:#64748b; font-family:monospace;">NIP: {{ $jadwal->guru->nip ?? '-' }}</span>
                            @if(isset($jadwal->guru->no_hp) && $jadwal->guru->no_hp !== '-')
                                <span style="font-size:12px; color:#64748b; margin-left:12px;"><i class="fa-solid fa-phone"></i> {{ $jadwal->guru->no_hp }}</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if(isset($jadwal->guru))
                                <a href="{{ route('guru.show', $jadwal->guru->id_guru) }}" class="btn-act btn-act-back" style="padding:5px 12px; font-size:12px;">
                                    <i class="fa-solid fa-user-tie"></i> Lihat Profil Guru
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Mata Pelajaran</strong></td>
                        <td>
                            <strong>{{ $jadwal->mapel->nama_mapel ?? '-' }}</strong><br>
                            <span style="font-size:12px; color:#2563eb; font-family:monospace; font-weight:700;">Kode: {{ $jadwal->mapel->kode_mapel ?? '-' }}</span>
                        </td>
                        <td style="text-align:center;">
                            @if(isset($jadwal->mapel))
                                <a href="{{ route('mapel.show', $jadwal->mapel->id_mapel) }}" class="btn-act btn-act-back" style="padding:5px 12px; font-size:12px;">
                                    <i class="fa-solid fa-book"></i> Lihat Detail Mapel
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jam Operasional KBM</strong></td>
                        <td>
                            <strong>Hari {{ $jadwal->hari }}</strong> — Jam ke-{{ $jadwal->jam_range }}<br>
                            <span style="font-size:12px; color:#3b5490; font-weight:700;">Waktu: {{ $jadwal->waktu_range }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span style="background:#ecfdf5; color:#047857; font-weight:800; padding:4px 12px; border-radius:10px; font-size:12px; border:1px solid #a7f3d0;">
                                Jam Regular KBM
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ruangan Pelaksanaan</strong></td>
                        <td>
                            <strong>{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</strong><br>
                            <span style="font-size:12px; color:#64748b;">Jenis Ruangan: {{ $jadwal->ruangan->jenis_ruangan ?? '-' }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span style="background:#e0f2fe; color:#0369a1; font-weight:800; padding:4px 12px; border-radius:10px; font-size:12px; border:1px solid #bae6fd;">
                                Valid & Ready
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
