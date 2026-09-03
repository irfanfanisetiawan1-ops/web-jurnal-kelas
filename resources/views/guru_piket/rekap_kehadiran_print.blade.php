<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Rekap Kehadiran Guru — SMKN 1 BOYOLANGU</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; padding: 30px; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header h3 { margin: 4px 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 0; font-size: 12px; }
        .meta { margin-bottom: 15px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
        table th { background: #f2f2f2; text-align: center; font-weight: bold; }
        .footer-sign { margin-top: 40px; float: right; text-align: center; width: 250px; font-size: 13px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #2b3957; color: #fff; border: none; border-radius: 6px; cursor: pointer;">Cetak Dokumen</button>
    </div>

    <div class="header">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h3>SMK NEGERI 1 BOYOLANGU</h3>
        <p>Jl. Ki Mangunsarkoro No. 1, Boyolangu, Tulungagung | Telp. (0355) 321746</p>
    </div>

    <h3 style="text-align: center; margin-bottom: 15px; text-transform: uppercase;">REKAPITULASI KEHADIRAN GURU PIKET HARI INI</h3>

    <div class="meta">
        <strong>Tanggal Pemantauan:</strong> {{ \Carbon\Carbon::parse($todayDate)->format('d F Y') }}<br>
        <strong>Dicetak Oleh:</strong> Petugas Piket Sekolah
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Guru</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Jam Mengajar</th>
                <th>Status Kehadiran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kehadiranList as $row)
                <tr>
                    <td style="text-align: center;">{{ $row->no }}</td>
                    <td>{{ $row->guru_nama }}</td>
                    <td>{{ $row->mapel_nama }}</td>
                    <td style="text-align: center;">{{ $row->kelas_nama }}</td>
                    <td style="text-align: center;">{{ $row->jam }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $row->status_teks }}</td>
                    <td>{{ $row->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-sign">
        Boyolangu, {{ \Carbon\Carbon::parse($todayDate)->format('d F Y') }}<br>
        Petugas Piket Harian,<br><br><br><br>
        <strong>( Siti Nurhaliza, S.Pd )</strong><br>
        NIP. 199003032015031003
    </div>

</body>
</html>
