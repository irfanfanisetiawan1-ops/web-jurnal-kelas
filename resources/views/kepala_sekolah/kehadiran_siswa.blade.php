@extends('layouts.kepala_sekolah')

@section('title', 'Kehadiran Siswa — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 6px;">
            DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin: 0 4px;"></i> <span style="color: #1e293b; font-weight: 700;">Kehadiran Siswa</span>
        </div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
            <i class="fa-solid fa-users" style="color: #384972; margin-right: 8px;"></i> Kehadiran Siswa Per Kelas & Rekapitulasi Presensi
        </h1>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13px; font-weight: 500;">
            Ringkasan data ketidakhadiran dan kehadiran siswa di seluruh kelas.
        </p>
    </div>

    <!-- Cards Stats Kehadiran Siswa -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div style="background: #ffffff; padding: 20px; border-radius: 14px; border: 1px solid #e2e8f0;">
            <div style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Total Seluruh Siswa</div>
            <div style="font-size: 32px; font-weight: 800; color: #384972; margin-top: 4px;">{{ $totalSiswa }}</div>
        </div>
        <div style="background: #ffffff; padding: 20px; border-radius: 14px; border: 1px solid #e2e8f0;">
            <div style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Rata-rata Tingkat Kehadiran</div>
            <div style="font-size: 32px; font-weight: 800; color: #16a34a; margin-top: 4px;">98%</div>
        </div>
        <div style="background: #ffffff; padding: 20px; border-radius: 14px; border: 1px solid #e2e8f0;">
            <div style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Siswa Izin / Sakit Today</div>
            <div style="font-size: 32px; font-weight: 800; color: #d97706; margin-top: 4px;">{{ $suratIzinList->count() }}</div>
        </div>
    </div>

    <!-- Table Rincian Per Kelas -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
            <i class="fa-solid fa-school" style="color: #384972;"></i> Data Rincian Siswa Per Rombel Kelas
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 1px solid #cbd5e1;">
                        <th style="padding: 12px;">No</th>
                        <th style="padding: 12px;">Nama Rombel Kelas</th>
                        <th style="padding: 12px;">Wali Kelas</th>
                        <th style="padding: 12px;">Jumlah Siswa</th>
                        <th style="padding: 12px;">Persentase Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelasList as $index => $k)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 700; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="padding: 12px; font-weight: 800; color: #0f172a;">{{ $k->nama_kelas }}</td>
                        <td style="padding: 12px; color: #475569;">{{ $k->waliKelasUser->name ?? ($k->wali_kelas ?? '-') }}</td>
                        <td style="padding: 12px; font-weight: 700; color: #384972;">{{ $k->siswa_count }} Siswa</td>
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                                    <div style="background: #16a34a; height: 100%; width: 98%;"></div>
                                </div>
                                <span style="font-weight: 800; color: #16a34a; font-size: 12px;">98%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">Belum ada data kelas terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
