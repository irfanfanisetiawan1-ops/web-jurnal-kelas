@extends('layouts.guru')

@section('title', 'Presensi & Perkembangan Siswa Kelas Binaan — Jurnal ESEMKITA')
@section('header_title', 'Presensi & Perkembangan Siswa Kelas: ' . $namaKelas)

@section('styles')
<style>
    .card-filter-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-filter-box h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-controls-row {
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-custom label {
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
    }

    .select-custom {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        min-width: 180px;
    }

    .btn-filter-dark {
        background: #1e293b;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-reset-gray {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    /* Grid 2 Column for Bottom Cards */
    .grid-rekap-rincian {
        display: grid;
        grid-template-columns: 38% 60%;
        gap: 2%;
    }

    .card-rekap-siswa {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-rekap-siswa h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .card-rincian-absen {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-rincian-absen h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .table-rekap {
        width: 100%;
        border-collapse: collapse;
    }

    .table-rekap th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 10px 12px;
        text-align: left;
        background: #cbd5e1;
        border-bottom: 1px solid #94a3b8;
    }

    .table-rekap td {
        padding: 10px 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-rincian {
        width: 100%;
        border-collapse: collapse;
    }

    .table-rincian th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 10px 12px;
        text-align: left;
        background: #cbd5e1;
        border-bottom: 1px solid #94a3b8;
    }

    .table-rincian td {
        padding: 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    @media (max-width: 992px) {
        .grid-rekap-rincian {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

    <!-- Top Card: Filter Pencarian -->
    <div class="card-filter-box">
        <h3>FILTER PENCARIAN</h3>

        <form action="{{ route('guru.kehadiran-kelas') }}" method="GET" class="filter-controls-row">
            <div class="form-group-custom">
                <label for="alasan">ALASAN/KETERANGAN</label>
                <select id="alasan" name="alasan" class="select-custom">
                    <option value="">SEMUA KETERANGAN</option>
                    <option value="Sakit" {{ $alasan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ $alasan == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Alpa" {{ $alasan == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                </select>
            </div>

            <div class="form-group-custom">
                <label for="bulan">BULAN</label>
                <select id="bulan" name="bulan" class="select-custom">
                    <option value="">SEMUA BULAN</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-filter-dark">FILTER</button>
                <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-reset-gray">RESET</a>
            </div>
        </form>
    </div>

    <!-- Bottom Grid: Rekapitulasi & Rincian -->
    <div class="grid-rekap-rincian">
        <!-- Card Left: Rekapitulasi Siswa -->
        <div class="card-rekap-siswa">
            <h3>Rekapitulasi Siswa</h3>

            <div style="overflow-x: auto;">
                <table class="table-rekap">
                    <thead>
                        <tr>
                            <th>SISWA</th>
                            <th style="width: 35px; text-align: center;">S</th>
                            <th style="width: 35px; text-align: center;">I</th>
                            <th style="width: 35px; text-align: center;">A</th>
                            <th style="width: 45px; text-align: center;">TOT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapSiswa as $row)
                            <tr>
                                <td><strong>{{ $row['siswa']->nama_siswa }}</strong></td>
                                <td style="text-align: center;">{{ $row['sakit'] }}</td>
                                <td style="text-align: center;">{{ $row['izin'] }}</td>
                                <td style="text-align: center;">{{ $row['alpa'] }}</td>
                                <td style="text-align: center;"><strong>{{ $row['total'] }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">
                                    Belum ada data siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Right: Rincian Ketidak Hadiran -->
        <div class="card-rincian-absen">
            <h3>Rincian Ketidak Hadiran ({{ count($rincianAbsen) }})</h3>

            <div style="overflow-x: auto;">
                <table class="table-rincian">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Keterangan</th>
                            <th>Pada Mapel</th>
                            <th>Guru Pengajar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rincianAbsen as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->jurnal->tanggal ?? now())->format('Y-m-d') }}</td>
                                <td><strong>{{ $item->siswa->nama_siswa ?? '-' }}</strong></td>
                                <td><span style="color:#dc2626; font-weight:700;">{{ $item->keterangan }}</span></td>
                                <td>{{ $item->jurnal->jadwal->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $item->jurnal->jadwal->guru->nama_guru ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    Tidak ada data ketidakhadiran siswa yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
