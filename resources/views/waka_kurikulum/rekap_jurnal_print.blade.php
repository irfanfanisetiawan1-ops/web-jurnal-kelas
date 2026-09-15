<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Jurnal Mengajar — Waka Kurikulum SMKN 1 Boyolangu</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 11px; color: #000; margin: 20px; }
        .kop { text-align: center; border-bottom: 2px double #000; padding-bottom: 8px; margin-bottom: 12px; }
        .kop h2 { margin: 0; font-size: 15px; font-weight: bold; }
        .kop h3 { margin: 2px 0; font-size: 13px; font-weight: bold; }
        .kop p { margin: 1px 0; font-size: 10.5px; }
        .title-box { text-align: center; margin-bottom: 14px; }
        .title-box h4 { margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.03em; }
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 11px; }
        .meta-table td { padding: 3px 0; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 10.5px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 7px; text-align: left; vertical-align: top; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .ttd-box { margin-top: 30px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .ttd { text-align: center; width: 220px; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        .btn-print { background: #2563eb; color: #fff; padding: 8px 16px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; background: #f8fafc; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
        <div><strong>Pratinjau Cetak Laporan Rekap Jurnal KBM Kurikulum</strong> — Dokumen Resmi Siap Dicetak / Simpan PDF.</div>
        <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak Sekarang</button>
    </div>

    <div class="kop">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h3>DINAS PENDIDIKAN — CABANG DINAS PENDIDIKAN WILAYAH TULUNGAGUNG</h3>
        <h2>SMK NEGERI 1 BOYOLANGU</h2>
        <p>Jl. Ki Mangunsarkoro VI/3 Telp. (0355) 323041 Boyolangu - Tulungagung</p>
    </div>

    <div class="title-box">
        <h4>LAPORAN REKAPITULASI JURNAL MENGAJAR KBM GURU</h4>
        <div style="font-size: 11px; color: #333; margin-top: 2px;">PORTAL WAKIL KEPALA SEKOLAH BIDANG KURIKULUM &amp; AKADEMIK — T.A. 2026/2027</div>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Waktu Cetak</strong></td>
            <td style="width: 35%;">: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }} WIB</td>
            <td style="width: 15%;"><strong>Total Data Sesi</strong></td>
            <td style="width: 35%;">: {{ $jurnals->count() }} Sesi KBM</td>
        </tr>
        <tr>
            <td><strong>Dicetak Oleh</strong></td>
            <td>: {{ $waka->nama_guru ?? 'Hardini Indahing Budi, S.E., M.Pd.' }} (NIP. {{ $waka->nip ?? '-' }})</td>
            <td><strong>Jabatan / Role</strong></td>
            <td>: Waka Kurikulum SMKN 1 Boyolangu</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 75px;">Tanggal &amp; Jam</th>
                <th style="width: 60px;">Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
                <th>Materi Pembelajaran</th>
                <th style="width: 65px;">Kondisi</th>
                <th>Ketidakhadiran Siswa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $j)
                @php
                    $absenList = $j->detailKetidakhadiran->map(function($d) {
                        return ($d->siswa->nama_siswa ?? 'Siswa') . ' (' . strtoupper($d->status ?? 'A') . ')';
                    })->implode(', ');
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">
                        <strong>{{ $j->tanggal ? date('d/m/Y', strtotime($j->tanggal)) : '-' }}</strong><br>
                        <small>Jam {{ $j->jadwal->jam_mulai_ke ?? '-' }}-{{ $j->jadwal->jam_selesai_ke ?? '-' }}</small>
                    </td>
                    <td style="text-align: center; font-weight: bold; color: #1e3a8a;">{{ $j->jadwal->kelas->nama_kelas ?? ($j->kelas->nama_kelas ?? '-') }}</td>
                    <td>{{ $j->jadwal->mapel->nama_mapel ?? ($j->mapel->nama_mapel ?? '-') }}</td>
                    <td>
                        <strong>{{ $j->jadwal->guru->nama_guru ?? ($j->guru->nama_guru ?? '-') }}</strong>
                        @if($j->guruPengganti)
                            <br><small style="color: #059669; font-weight: bold;">(Pengganti: {{ $j->guruPengganti->nama_guru }})</small>
                        @endif
                    </td>
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
            <p>Mengetahui,<br>Kepala SMKN 1 Boyolangu,</p>
            <br><br><br>
            <p><strong>__________________________</strong><br>NIP. -</p>
        </div>
        <div class="ttd">
            <p>Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}<br>Waka Kurikulum,</p>
            <br><br><br>
            <p><strong>{{ $waka->nama_guru ?? 'Hardini Indahing Budi, S.E., M.Pd.' }}</strong><br>NIP. {{ $waka->nip ?? '.....................................' }}</p>
        </div>
    </div>
</body>
</html>
