@extends('layouts.kepala_sekolah')

@section('title', 'Laporan — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner (Persis Mockup UI media_1788189981451.png) -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
            Laporan
        </h1>
        <div style="font-size: 14px; font-weight: 600; color: #64748b;">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
        </div>
        <p style="margin: 12px 0 0 0; color: #64748b; font-size: 13.5px; font-weight: 500;">
            Laporan ini bersifat ringkasan, tanpa aksi
        </p>
    </div>

    <!-- Seksi 1: Tingkat Kehadiran Guru per Bulan (Bar Chart UI) -->
    <div style="background: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 24px 0;">
            Tingkat Kehadiran Guru per Bulan
        </h2>

        <!-- Bar Chart Container -->
        <div style="position: relative; width: 100%; height: 240px; display: flex; flex-direction: column; justify-content: space-between;">
            
            <!-- Grid Lines Y-Axis -->
            <div style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; display: flex; flex-direction: column; justify-content: space-between; pointer-events: none;">
                @foreach([100, 95, 90, 85, 80] as $tick)
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 12px; font-weight: 700; color: #64748b; width: 30px; text-align: right;">{{ $tick }}</span>
                    <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
                </div>
                @endforeach
            </div>

            <!-- Bars Area -->
            <div style="position: relative; z-index: 2; height: 180px; margin-left: 45px; margin-right: 15px; margin-top: 10px; display: flex; justify-content: space-around; align-items: flex-end;">
                @foreach($kehadiranBulanan as $item)
                    @php
                        // Scale 80% - 100% to bar height 0% - 100%
                        $min = 80;
                        $max = 100;
                        $val = max(80, min(100, $item['pct']));
                        $heightPct = (($val - $min) / ($max - $min)) * 100;
                        if ($heightPct < 5) $heightPct = 5;
                    @endphp
                    <div style="display: flex; flex-direction: column; align-items: center; width: 45px; height: 100%; justify-content: flex-end;">
                        <div title="{{ $item['bulan'] }}: {{ $item['pct'] }}%" style="width: 32px; height: {{ $heightPct }}%; background: #384972; border-top-left-radius: 4px; border-top-right-radius: 4px; transition: height 0.3s ease;"></div>
                        <div style="font-size: 13px; font-weight: 700; color: #334155; margin-top: 14px; text-align: center;">
                            {{ $item['bulan'] }}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Seksi 2: Rekap Izin Guru Bulan Ini (Tabel Card UI) -->
    <div style="background: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 20px 0;">
            Rekap Izin Guru Bulan Ini
        </h2>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #cbd5e1; color: #64748b;">
                        <th style="padding: 12px 16px 12px 0; font-weight: 700; font-size: 13px; text-transform: capitalize;">Guru</th>
                        <th style="padding: 12px 16px; font-weight: 700; font-size: 13px; text-transform: capitalize;">Mapel</th>
                        <th style="padding: 12px 0 12px 16px; font-weight: 700; font-size: 13px; text-transform: capitalize; text-align: right;">Jumlah Izin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapIzinGuru as $row)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 16px 16px 16px 0; font-weight: 800; color: #0f172a; font-size: 14.5px;">
                            {{ $row->nama_guru }}
                        </td>
                        <td style="padding: 16px; font-weight: 700; color: #1e293b; font-size: 14px;">
                            {{ $row->nama_mapel }}
                        </td>
                        <td style="padding: 16px 0 16px 16px; font-weight: 800; color: #0f172a; font-size: 15px; text-align: right;">
                            {{ $row->jumlah_izin }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 24px; color: #64748b;">
                            Tidak ada data rekap izin guru untuk bulan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
