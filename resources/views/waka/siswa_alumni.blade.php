@extends('layouts.waka')

@section('title', 'Data Siswa Alumni — Waka Kesiswaan')

@section('styles')
<style>
    .alumni-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        width: 100%;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-outline {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .btn-outline:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .main-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .siswa-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .siswa-table th {
        background: #f0f9ff;
        border-bottom: 2px solid #bae6fd;
        padding: 14px 18px;
        font-size: 12.5px;
        font-weight: 800;
        color: #0369a1;
        white-space: nowrap;
    }

    .siswa-table td {
        padding: 14px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .siswa-table tr:hover td {
        background: #f0f9ff;
    }
</style>
@endsection

@section('content')
<div class="alumni-container">

    <div class="page-header-box">
        <div>
            <div style="margin-bottom: 6px;">
                <a href="{{ route('waka.siswa') }}" style="color: #64748b; font-weight: 700; text-decoration: none; font-size: 13px;">
                    &larr; Kembali ke Data Siswa
                </a>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0369a1; margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-user-graduate"></i> Data Siswa Alumni
            </h1>
            <p style="font-size: 13px; color: #64748b; margin: 3px 0 0 0;">
                Daftar siswa yang telah lulus atau berstatus alumni di SMK Negeri 1 Boyolangu.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('waka.siswa') }}" class="btn-action btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Siswa
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#ecfdf5; border:1.5px solid #a7f3d0; color:#065f46; padding:14px 18px; border-radius:14px; font-size:13.5px; font-weight:700;">
            <i class="fa-solid fa-circle-check" style="color:#10b981;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="main-card">
        <div class="table-scroll-wrapper">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 130px;">NISN</th>
                        <th style="width: 120px;">NIS</th>
                        <th>Nama Siswa</th>
                        <th style="width: 130px;">Kelas Terakhir</th>
                        <th style="width: 100px;">Jurusan</th>
                        <th style="width: 100px;">JK</th>
                        <th style="width: 160px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $idx => $s)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $siswas->firstItem() + $idx }}
                            </td>
                            <td><span style="font-family:monospace; font-weight:700; color:#0369a1;">{{ $s->nisn }}</span></td>
                            <td>{{ $s->nis ?? '-' }}</td>
                            <td><strong>{{ $s->nama_siswa }}</strong></td>
                            <td><span style="background:#e0f2fe; color:#0369a1; padding:3px 8px; border-radius:6px; font-weight:700; font-size:12px;">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $s->kelas->jurusan->kode_jurusan ?? ($s->kelas->nama_kelas ?? '-') }}</td>
                            <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td style="text-align: center;">
                                <form method="POST" action="{{ route('waka.siswa.restore-from-alumni', $s->id_siswa) }}">
                                    @csrf
                                    <button type="submit" class="btn-action" style="background:#ecfdf5; color:#059669; padding:6px 12px; font-size:12px;" title="Kembalikan menjadi Siswa Aktif">
                                        <i class="fa-solid fa-user-check"></i> Kembalikan ke Siswa Aktif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <i class="fa-solid fa-user-graduate" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #64748b;">Belum Ada Data Alumni</h4>
                                <p style="margin: 4px 0 0; font-size: 13px;">Siswa yang dipindahkan ke status alumni akan tercatat di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; background: #f8fafc; border-top: 1.5px solid #f1f5f9;">
            {{ $siswas->links('partials.custom-pagination') }}
        </div>
    </div>

</div>
@endsection