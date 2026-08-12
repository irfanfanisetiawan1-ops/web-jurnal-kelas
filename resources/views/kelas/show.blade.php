@extends('layouts.admin')

@section('title', 'Detail Kelas — ' . $kelas->nama_kelas)

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

    /* Table Siswa */
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

    <div class="breadcrumb-text">
        <a href="{{ route('kelas.index') }}"><i class="fa-solid fa-school"></i> Data Kelas</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Kelas</span>
    </div>

    <div class="detail-card">
        <div class="profile-header">
            <div class="avatar-large"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="profile-info">
                <h1>Kelas {{ $kelas->nama_kelas }}</h1>
                <span class="kelas-pill">
                    <i class="fa-solid fa-layer-group"></i> {{ $kelas->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">Nama Rombongan Belajar</div>
                <div class="value">{{ $kelas->nama_kelas }}</div>
            </div>

            <div class="info-item">
                <div class="label">Jurusan</div>
                <div class="value" style="color:#3b5490;">{{ $kelas->jurusan->nama_jurusan ?? '-' }} ({{ $kelas->jurusan->kode_jurusan ?? '-' }})</div>
            </div>

            <div class="info-item">
                <div class="label">Ruangan Kelas Utama</div>
                <div class="value" style="color:#0284c7;">
                    @if($kelas->ruangan)
                        <i class="fa-solid fa-door-open"></i> {{ $kelas->ruangan->nama_ruangan }} <span style="font-size:12px; color:#64748b; font-weight:600;">({{ $kelas->ruangan->jenis_ruangan }})</span>
                    @else
                        <span style="color:#94a3b8; font-style:italic;">Belum diatur</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="label">Wali Kelas</div>
                <div class="value">
                    @if($kelas->waliKelas)
                        {{ $kelas->waliKelas->nama_guru }} <span style="font-size:12px; color:#64748b; font-weight:600;">(NIP: {{ $kelas->waliKelas->nip }})</span>
                    @else
                        <span style="color:#94a3b8; font-style:italic;">Belum ditentukan</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="label">Jumlah Siswa Terdaftar</div>
                <div class="value" style="color:#2563eb;">{{ isset($kelas->siswas) ? count($kelas->siswas) : ($kelas->jumlah_siswa ?? 0) }} Siswa</div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('kelas.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kelas
            </a>
            <a href="{{ route('kelas.edit', $kelas->id_kelas) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Kelas
            </a>
            <form action="{{ route('kelas.destroy', $kelas->id_kelas) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas {{ addslashes($kelas->nama_kelas) }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Kelas
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Siswa Terdaftar di Kelas Ini -->
    <div class="detail-card">
        <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-users" style="color:#2563eb;"></i> Daftar Siswa Terdaftar ({{ isset($kelas->siswas) ? count($kelas->siswas) : 0 }})
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>NAMA SISWA</th>
                        <th>JENIS KELAMIN</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($kelas->siswas) && count($kelas->siswas) > 0)
                        @foreach($kelas->siswas as $idx => $s)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td><strong>{{ $s->nis ?? '-' }}</strong></td>
                                <td><span style="font-family:monospace; color:#3b5490; font-weight:700;">{{ $s->nisn }}</span></td>
                                <td><strong>{{ $s->nama_siswa }}</strong></td>
                                <td>
                                    @if($s->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($s->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('siswa.show', $s->id_siswa) }}" class="btn-act btn-act-back" style="padding:5px 12px; font-size:12px;">
                                        <i class="fa-solid fa-eye"></i> Detail Siswa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8;">
                                Belum ada siswa yang terdaftar pada kelas ini.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
