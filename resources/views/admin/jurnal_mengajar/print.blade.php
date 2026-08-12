<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Mengajar — EduJournal</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th { background-color: #f2f2f2; padding: 8px; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; vertical-align: top; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #059669; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h2>LAPORAN JURNAL MENGAJAR GURU</h2>
        <p>Sistem Informasi Jurnal Kelas (EduJournal)</p>
        @if($tanggal)
            <p><strong>Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</strong></p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 12%;">Kelas</th>
                <th style="width: 18%;">Guru Pengampu</th>
                <th style="width: 16%;">Mata Pelajaran</th>
                <th>Materi Pembelajaran</th>
                <th style="width: 10%;">Status Guru</th>
                <th style="width: 14%;">Siswa Tidak Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $j)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $j->jadwal->guru->nama_guru ?? '-' }}</td>
                    <td>{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $j->materi }}</td>
                    <td style="text-align: center;">{{ $j->status_kehadiran_guru }}</td>
                    <td>
                        @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                            @foreach($j->detailKetidakhadiran as $d)
                                • {{ $d->siswa->nama_siswa ?? 'Siswa' }} ({{ $d->keterangan }})<br>
                            @endforeach
                        @else
                            Nihil
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data jurnal mengajar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div></div>
        <div class="signature">
            <p>Dicetak pada: {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>Kepala Sekolah / Admin</strong></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Auto trigger print option
        }
    </script>
</body>
</html>
