@extends('layouts.waka')

@section('title', 'Jadwal Mengajar Guru — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA > <span>Jadwal Mengajar</span></div>
            <h1 class="page-title">Jadwal Mengajar Seluruh Guru</h1>
        </div>
    </div>

    <div class="card-panel">
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        <tr>
                            <td style="font-weight: 700;">{{ $j->hari }}</td>
                            <td>{{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }}</td>
                            <td style="font-weight: 800;">{{ $j->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                            <td><span style="font-weight: 700; color: #2563eb;">{{ $j->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada jadwal mengajar terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
