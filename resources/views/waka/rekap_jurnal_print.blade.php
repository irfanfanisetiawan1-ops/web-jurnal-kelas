<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Jurnal Mengajar — SMK Negeri 1 Boyolangu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11.5px; color: #000; margin: 20px; }
        .kop { text-align: center; border-bottom: 2px double #000; padding-bottom: 8px; margin-bottom: 12px; }
        .kop h2 { margin: 0; font-size: 15px; font-weight: bold; }
        .kop h3 { margin: 2px 0; font-size: 13px; font-weight: bold; }
        .kop p { margin: 1px 0; font-size: 10.5px; }
        .title-box { text-align: center; margin-bottom: 12px; }
        .title-box h4 { margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 11px; }
        .meta-table td { padding: 2px 0; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 10.5px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 5px 6px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .ttd-box { margin-top: 25px; display: flex; justify-content: flex-end; }
        .ttd { text-align: center; width: 220px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; background: #f8fafc; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <div><strong>Pratinjau Cetak Laporan Rekap Jurnal Mengajar</strong> — Siap dicetak atau disimpan sebagai PDF.</div>
        <button onclick="window.print()" style="background: #2563eb; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="kop">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h3>DINAS PENDIDIKAN — CABANG DINAS PENDIDIKAN WILAYAH TULUNGAGUNG</h3>
        <h2>SMK NEGERI 1 BOYOLANGU</h2>
        <p>Jl. Ki Mangunsarkoro VI/3 Telp. (0355) 323041 Boyolangu - Tulungagung</p>
    </div>

    <div class="title-box">
        <h4>LAPORAN REKAPITULASI JURNAL MENGAJAR GURU</h4>
        <div>SEMESTER GANJIL TAHUN AJARAN 2026/2027</div>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Waktu Cetak</strong></td>
            <td style="width: 35%;">: {{ now()->translatedFormat('l, d F Y H:i') }} WIB</td>
            <td style="width: 15%;"><strong>Total Data Sesi</strong></td>
            <td style="width: 35%;">: {{ $jurnals->count() }} Sesi KBM</td>
        </tr>
        <tr>
            <td><strong>Dicetak Oleh</strong></td>
            <td>: {{ $waka->nama_guru ?? 'Waka Kesiswaan' }} (NIP. {{ $waka->nip ?? '-' }})</td>
            <td><strong>Kondisi Data</strong></td>
            <td>: Sesuai filter pencarian aktif</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 70px;">Tanggal</th>
                <th>Guru Pengajar</th>
                <th style="width: 70px;">Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Materi Pembelajaran</th>
                <th style="width: 70px;">Kondisi</th>
                <th style="width: 110px;">Ketidakhadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $j)
                @php
                    $absenList = $j->detailKetidakhadiran->map(function($d) {
                        return ($d->siswa->nama_siswa ?? 'Siswa') . ' (' . ($d->keterangan ?? '-') . ')';
                    })->implode(', ');
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $j->tanggal ? date('d/m/Y', strtotime($j->tanggal)) : '-' }}</td>
                    <td>
                        <strong>{{ $j->guru->nama_guru ?? '-' }}</strong>
                        @if($j->guruPengganti)
                            <br><small style="color: #666;">(Inval: {{ $j->guruPengganti->nama_guru }})</small>
                        @endif
                    </td>
                    <td style="text-align: center; font-weight: bold;">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $j->mapel->nama_mapel ?? '-' }} (Ke-{{ $j->pertemuan_ke ?? '-' }})</td>
                    <td>{{ $j->materi ?: '-' }}</td>
                    <td style="text-align: center;">{{ $j->kondisi_kelas ?? 'Kondusif' }}</td>
                    <td>{{ $absenList ?: 'Nihil' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada riwayat jurnal mengajar ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-box">
        <div class="ttd">
            <p>Tulungagung, {{ now()->translatedFormat('d F Y') }}<br>Waka Kesiswaan,</p>
            <br><br><br>
            <p><strong>{{ $waka->nama_guru ?? 'Waka Kesiswaan' }}</strong><br>NIP. {{ $waka->nip ?? '.....................................' }}</p>
        </div>
    </div>
</body>
</html>