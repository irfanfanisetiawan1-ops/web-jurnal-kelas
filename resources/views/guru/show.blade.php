@extends('layouts.admin')

@section('title', 'Detail Guru — ' . $guru->nama_guru)

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
        background: linear-gradient(135deg, #059669, #10b981);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
    }

    .profile-info h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .nip-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #047857;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #a7f3d0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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

    .badge-jk {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l { background: #e0f2fe; color: #0369a1; }
    .badge-jk-p { background: #fce7f3; color: #be185d; }

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
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('guru.index') }}"><i class="fa-solid fa-user-tie"></i> Data Guru</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Guru</span>
    </div>

    <div class="detail-card">
        <div class="profile-header">
            @php
                $words = explode(' ', trim($guru->nama_guru));
                $initials = count($words) >= 2
                    ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                    : strtoupper(substr($words[0], 0, 2));
            @endphp
            <div class="avatar-large">{{ $initials }}</div>
            <div class="profile-info">
                <h1>{{ $guru->nama_guru }}</h1>
                <span class="nip-pill">
                    <i class="fa-solid fa-id-card"></i> NIP: {{ $guru->nip }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">NIP (Nomor Induk Pegawai)</div>
                <div class="value" style="font-family:monospace; color:#059669;">{{ $guru->nip }}</div>
            </div>

            <div class="info-item">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $guru->nama_guru }}</div>
            </div>

            <div class="info-item">
                <div class="label">Jenis Kelamin</div>
                <div class="value">
                    @if($guru->jenis_kelamin == 'L')
                        <span class="badge-jk badge-jk-l"><i class="fa-solid fa-mars"></i> Laki-laki</span>
                    @elseif($guru->jenis_kelamin == 'P')
                        <span class="badge-jk badge-jk-p"><i class="fa-solid fa-venus"></i> Perempuan</span>
                    @else
                        <span style="color:#94a3b8;">-</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="label">Mata Pelajaran Utama</div>
                <div class="value" style="color:#3b5490;">{{ $guru->mapel->nama_mapel ?? '-' }}</div>
            </div>

            <div class="info-item">
                <div class="label">Nomor HP / WA</div>
                <div class="value">{{ $guru->no_hp ?? '-' }}</div>
            </div>

            <div class="info-item">
                <div class="label">Role System / Akun</div>
                <div class="value">
                    @if(isset($guru->user) && $guru->user->isAdmin())
                        <span style="background:#fef3c7; color:#b45309; font-weight:800; padding:4px 10px; border-radius:8px; font-size:12px;">TU (TATA USAHA)</span>
                    @else
                        <span style="background:#e0e7ff; color:#3730a3; font-weight:800; padding:4px 10px; border-radius:8px; font-size:12px;">GURU / STAF</span>
                    @endif
                </div>
            </div>

            <div class="info-item" style="grid-column: 1 / -1;">
                <div class="label">Wali Kelas Dari</div>
                <div class="value">
                    @if(isset($guru->kelasWali) && count($guru->kelasWali) > 0)
                        @foreach($guru->kelasWali as $kw)
                            <span style="background:#f1f5f9; color:#334155; font-weight:700; padding:4px 10px; border-radius:8px; font-size:13px; margin-right:6px;">{{ $kw->nama_kelas }}</span>
                        @endforeach
                    @else
                        <span style="color:#94a3b8;">Tidak mengampu kelas sebagai Wali Kelas</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('guru.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Guru
            </a>
            <a href="{{ route('guru.edit', $guru->id_guru) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Guru
            </a>
            <form action="{{ route('guru.destroy', $guru->id_guru) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data guru {{ addslashes($guru->nama_guru) }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Guru
                </button>
            </form>
        </div>
    </div>

@endsection
