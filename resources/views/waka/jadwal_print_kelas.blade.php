<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas {{ $kelas->nama_kelas ?? '' }} — SMK Negeri 1 Boyolangu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; margin: 15px; }
        .kop { text-align: center; border-bottom: 2px double #000; padding-bottom: 8px; margin-bottom: 12px; }
        .kop h2 { margin: 0; font-size: 15px; font-weight: bold; }
        .kop h3 { margin: 2px 0; font-size: 13px; font-weight: bold; }
        .kop p { margin: 1px 0; font-size: 10.5px; }
        .title-box { text-align: center; margin-bottom: 12px; }
        .title-box h4 { margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .table-matrix { width: 100%; border-collapse: collapse; font-size: 10.5px; }
        .table-matrix th, .table-matrix td { border: 1px solid #000; padding: 5px 6px; text-align: center; vertical-align: middle; }
        .table-matrix th { background-color: #f2f2f2; font-weight: bold; }
        .cell-break { background-color: #fdf2d0; font-weight: bold; font-size: 10px; }
        .ttd-box { margin-top: 25px; display: flex; justify-content: space-between; font-size: 11px; }
        .ttd { text-align: center; width: 220px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; background: #f8fafc; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <div><strong>Pratinjau Cetak Jadwal Kelas: {{ $kelas->nama_kelas ?? '-' }}</strong></div>
        <button onclick="window.print()" style="background: #2563eb; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="kop">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h3>SMK NEGERI 1 BOYOLANGU — TULUNGAGUNG</h3>
        <p>Jl. Ki Mangunsarkoro VI/3 Telp. (0355) 323041 Boyolangu - Tulungagung</p>
    </div>

    <div class="title-box">
        <h4>JADWAL PELAJARAN KELAS: {{ $kelas->nama_kelas ?? '-' }} (TINGKAT {{ $kelas->tingkat ?? '-' }})</h4>
        <div>SEMESTER GANJIL TAHUN AJARAN 2026/2027</div>
    </div>

    @php
        $timesSeninKamis = [
            1 => '07.00 - 07.40',
            2 => '07.40 - 08.20',
            3 => '08.20 - 09.00',
            4 => '09.00 - 09.40',
            5 => '10.00 - 10.35',
            6 => '10.35 - 11.10',
            7 => '11.10 - 11.45',
            8 => '13.15 - 13.50',
            9 => '13.50 - 14.25',
            10 => '14.25 - 15.00',
        ];

        $timesJumat = [
            1 => '07.00 - 07.30',
            2 => '07.30 - 08.00',
            3 => '08.00 - 08.30',
            4 => '08.30 - 09.00',
            5 => '09.00 - 09.30',
            6 => '09.50 - 10.20',
            7 => '10.20 - 10.50',
            8 => '10.50 - 11.20',
            9 => '13.00 - 13.30',
            10 => '13.30 - 14.00',
            11 => '14.00 - 14.30',
            12 => '14.30 - 15.00',
            13 => '15.00 - 15.35',
        ];
    @endphp

    <table class="table-matrix">
        <thead>
            <tr>
                <th style="width: 35px;">Jam</th>
                <th style="width: 80px;">Waktu (Senin-Kamis)</th>
                <th>Senin</th>
                <th>Selasa</th>
                <th>Rabu</th>
                <th>Kamis</th>
                <th style="width: 80px;">Waktu (Jumat)</th>
                <th>Jumat</th>
            </tr>
        </thead>
        <tbody>
            @for($jam = 1; $jam <= $maxJam; $jam++)
                @if($jam === 5)
                    <tr>
                        <td colspan="8" class="cell-break">ISTIRAHAT 1 (09.40 - 10.00 WIB)</td>
                    </tr>
                @endif
                @if($jam === 8)
                    <tr>
                        <td colspan="8" class="cell-break">ISTIRAHAT 2 / ISHOMA (11.45 - 13.15 WIB)</td>
                    </tr>
                @endif

                <tr>
                    <td style="font-weight: bold; background: #f9f9f9;">{{ $jam }}</td>
                    <td style="background: #f9f9f9;">{{ $timesSeninKamis[$jam] ?? '-' }}</td>

                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis'] as $day)
                        @php $cell = $matriksData[$day][$jam] ?? null; @endphp
                        @if($cell)
                            <td>
                                <strong>{{ $cell->mapel->nama_mapel ?? '-' }}</strong><br>
                                <span style="font-size: 9.5px; color: #333;">{{ $cell->guru->nama_guru ?? '-' }}</span><br>
                                <span style="font-size: 9px; color: #666;">[{{ $cell->ruangan->nama_ruangan ?? 'Kelas' }}]</span>
                            </td>
                        @else
                            <td style="color: #999;">-</td>
                        @endif
                    @endforeach

                    <td style="background: #f9f9f9;">{{ $timesJumat[$jam] ?? '-' }}</td>

                    @php $cellJ = $matriksData['Jumat'][$jam] ?? null; @endphp
                    @if($jam === 1 && !$cellJ)
                        <td style="background: #e6ffed;">
                            <strong>Pembiasaan Jumat</strong><br>
                            <span style="font-size: 9.5px;">(Sholat Dhuha / Literasi)</span>
                        </td>
                    @elseif($cellJ)
                        <td>
                            <strong>{{ $cellJ->mapel->nama_mapel ?? '-' }}</strong><br>
                            <span style="font-size: 9.5px; color: #333;">{{ $cellJ->guru->nama_guru ?? '-' }}</span><br>
                            <span style="font-size: 9px; color: #666;">[{{ $cellJ->ruangan->nama_ruangan ?? 'Kelas' }}]</span>
                        </td>
                    @else
                        <td style="color: #999;">-</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="ttd-box">
        <div class="ttd">
            <p>Mengetahui,<br>Wali Kelas</p>
            <br><br><br>
            <p><strong>( .................................................. )</strong><br>NIP. ..............................................</p>
        </div>
        <div class="ttd">
            <p>Tulungagung, {{ now()->translatedFormat('d F Y') }}<br>Waka Kesiswaan,</p>
            <br><br><br>
            <p><strong>{{ $waka->nama_guru ?? 'Waka Kesiswaan' }}</strong><br>NIP. {{ $waka->nip ?? '.....................................' }}</p>
        </div>
    </div>
</body>
</html>