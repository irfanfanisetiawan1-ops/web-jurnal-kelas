<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jurnal Mengajar — EduJournal</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        .print-actions { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn-print { padding: 10px 20px; background: #059669; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-close { padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; font-size: 12px; }
        .table-responsive-print { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 650px; }
        table, th, td { border: 1px solid #000; }
        th { background-color: #f2f2f2; padding: 8px; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; vertical-align: top; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        @media (max-width: 768px) {
            body { margin: 12px; font-size: 11.5px; }
            .print-actions { width: 100%; }
            .btn-print, .btn-close { flex: 1; }
            .header h2 { font-size: 16px; }
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .table-responsive-print { overflow: visible !important; }
            table { min-width: 100% !important; }
        }
    </style>
</head>
<body>

    <div class="no-print print-actions">
        <button onclick="window.print()" class="btn-print">
            Cetak Laporan
        </button>
        <button onclick="window.close()" class="btn-close">
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

    <div class="table-responsive-print">
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
    </div>

    <div class="footer">
        <div></div>
        <div class="signature">
            <p>Dicetak pada: {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>Kepala Sekolah / Admin</strong></p>
        </div>
    </div>

</body>
</html>
