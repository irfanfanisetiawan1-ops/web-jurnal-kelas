@extends('layouts.waka')

@section('title', 'Rekap Jurnal & Kehadiran — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .btn-export { background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA > <span>Rekap Jurnal</span></div>
            <h1 class="page-title">Rekap Jurnal Mengajar & Kehadiran</h1>
        </div>

        <a href="{{ route('waka.export-rekap') }}" class="btn-export">
            <i class="fa-solid fa-file-csv"></i> Download CSV
        </a>
    </div>

    <div class="card-panel">
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Guru Pengajar</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Materi Diajarkan</th>
                        <th>Kondisi Kelas</th>
                        <th>Pertemuan Ke</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnalList as $j)
                        <tr>
                            <td style="font-weight: 700;">{{ $j->tanggal }}</td>
                            <td style="font-weight: 800;">{{ $j->guru->nama_guru ?? '-' }}</td>
                            <td><span style="font-weight: 800; color: #2563eb;">{{ $j->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $j->materi ?? '-' }}</td>
                            <td>
                                <span style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 10px; font-weight: 700; font-size: 11px;">
                                    {{ $j->kondisi_kelas ?? 'Kondusif' }}
                                </span>
                            </td>
                            <td style="font-weight: 700;">{{ $j->pertemuan_ke ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada riwayat pengisian jurnal mengajar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $jurnalList->links() }}
        </div>
    </div>

@endsection
