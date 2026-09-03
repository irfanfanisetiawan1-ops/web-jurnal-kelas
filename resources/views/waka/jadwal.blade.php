@extends('layouts.waka')

@section('title', 'Kelola Jadwal Pelajaran — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); }
    .filter-row { display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap; }
    .select-custom { padding: 9px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA > <span>Master Jadwal</span></div>
            <h1 class="page-title">Jadwal Pelajaran Sekolah</h1>
        </div>
        <a href="{{ route('jadwal.create') }}" style="background: #2563eb; color: #ffffff; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i> Tambah Jadwal Baru
        </a>
    </div>

    <div class="card-panel">
        <form method="GET" action="{{ route('waka.jadwal') }}" class="filter-row">
            <select name="hari" class="select-custom" onchange="this.form.submit()">
                <option value="">-- Semua Hari --</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                    <option value="{{ $h }}" {{ $hariFilter === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>

            <select name="id_kelas" class="select-custom" onchange="this.form.submit()">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $kelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </form>

        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Pelajaran</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        <tr>
                            <td style="font-weight: 700;">{{ $j->hari }}</td>
                            <td>{{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }}</td>
                            <td><span style="font-weight: 800;">{{ $j->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #94a3b8;">Tidak ada jadwal pelajaran ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
