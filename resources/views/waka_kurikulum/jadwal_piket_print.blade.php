<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JADWAL PIKET KBM BULAN {{ strtoupper($namaBulan) }} {{ $tahun }} — SMK NEGERI 1 BOYOLANGU</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 6px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 11px;
            font-weight: bold;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10.5px;
        }

        th, td {
            border: 1px solid #000000;
            padding: 6px 6px;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .slot-cell {
            line-height: 1.35;
        }

        /* Tanda Tangan */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding: 0 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-box .date-line {
            margin-bottom: 55px;
        }

        .signature-box .name-line {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-box .nip-line {
            font-size: 10px;
            margin-top: 2px;
        }

        .no-print {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 9999;
            display: flex;
            gap: 8px;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .btn-close {
            background: #64748b;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Cetak Dokumen</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    <div class="header">
        <h1>JADWAL PIKET KBM BULAN {{ strtoupper($namaBulan) }} {{ $tahun }}</h1>
        <h2>SMK NEGERI 1 BOYOLANGU TAHUN PELAJARAN 2026 - 2027</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 35px;">No</th>
                <th rowspan="2" style="width: 140px;">Hari / Tanggal</th>
                <th colspan="3">PETUGAS PIKET KBM PAGI<br>( 07.00 s.d 11.00 )</th>
                <th style="width: 160px;">KOORDINATOR PIKET KBM PAGI<br>( 07.00 s.d 11.00 )</th>
                <th colspan="3">PETUGAS PIKET KBM SIANG<br>( 11.00 s.d 15.00 )</th>
                <th style="width: 160px;">KOORDINATOR PIKET KBM SIANG<br>( 11.00 s.d 15.00 )</th>
            </tr>
            <tr>
                <th style="width: 130px;">Petugas 1</th>
                <th style="width: 130px;">Petugas 2</th>
                <th style="width: 130px;">Petugas 3</th>
                <th>Koordinator Pagi</th>
                <th style="width: 130px;">Petugas 4</th>
                <th style="width: 130px;">Petugas 5</th>
                <th style="width: 130px;">Petugas 6</th>
                <th>Koordinator Siang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($workDays as $idx => $wd)
                @php
                    $tgl = $wd['tanggal'];
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><strong>{{ $wd['hari'] }}</strong>, {{ $wd['label'] }}</td>
                    
                    <!-- Pagi (Slot 1, 2, 3) -->
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][1]['nama_guru'] ?? '-' }}</td>
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][2]['nama_guru'] ?? '-' }}</td>
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][3]['nama_guru'] ?? '-' }}</td>

                    <!-- Koordinator Pagi (Slot 4) -->
                    <td class="slot-cell"><strong>{{ $jadwalMatrix[$tgl][4]['nama_guru'] ?? '-' }}</strong></td>

                    <!-- Siang (Slot 5, 6, 7) -->
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][5]['nama_guru'] ?? '-' }}</td>
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][6]['nama_guru'] ?? '-' }}</td>
                    <td class="slot-cell">{{ $jadwalMatrix[$tgl][7]['nama_guru'] ?? '-' }}</td>

                    <!-- Koordinator Siang (Slot 8) -->
                    <td class="slot-cell"><strong>{{ $jadwalMatrix[$tgl][8]['nama_guru'] ?? '-' }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Data jadwal piket tidak tersedia untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="date-line">Mengetahui,<br>Kepala SMK Negeri 1 Boyolangu</div>
            <div class="name-line">TRISNO WIBOWO, S.Pd., M.M.</div>
            <div class="nip-line">NIP. 19700318 199703 1 005</div>
        </div>

        <div class="signature-box">
            <div class="date-line">Boyolangu, {{ date('d') }} {{ $namaBulan }} {{ $tahun }}<br>Waka Kurikulum</div>
            <div class="name-line">HARDINI INDAHING BUDI, S.E., M.Pd.</div>
            <div class="nip-line">NIP. 19730521 200801 2 006</div>
        </div>
    </div>

</body>
</html>
