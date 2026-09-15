<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran — SMK Negeri 1 Boyolangu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        .kop { text-align: center; border-bottom: 2px double #000; padding-bottom: 10px; margin-bottom: 15px; }
        .kop h2 { margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .kop h3 { margin: 2px 0; font-size: 14px; font-weight: bold; }
        .kop p { margin: 2px 0; font-size: 11px; }
        .meta-info { margin-bottom: 15px; font-size: 12px; }
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .meta-table td { padding: 3px 0; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 11.5px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .ttd-box { margin-top: 30px; display: flex; justify-content: flex-end; }
        .ttd { text-align: center; width: 220px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; background: #f8fafc; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <div><strong>Pratinjau Cetak Master Jadwal</strong> — Siap dicetak atau disimpan sebagai PDF.</div>
        <button onclick="window.print()" style="background: #2563eb; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="kop">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h3>DINAS PENDIDIKAN — CABANG DINAS PENDIDIKAN WILAYAH TULUNGAGUNG</h3>
        <h2>SMK NEGERI 1 BOYOLANGU</h2>
        <p>Jl. Ki Mangunsarkoro VI/3 Telp. (0355) 323041 Boyolangu - Tulungagung</p>
    </div>

    <div class="meta-info">
        <h4 style="text-align: center; margin: 0 0 10px 0; text-transform: uppercase; font-size: 14px;">DAFTAR JADWAL PELAJARAN KBM SEMESTER GANJIL 2026/2027</h4>
        <table class="meta-table">
            <tr>
                <td style="width: 15%;"><strong>Dicetak Oleh</strong></td>
                <td style="width: 35%;">: {{ $waka->nama_guru ?? 'Waka Kesiswaan' }}</td>
                <td style="width: 15%;"><strong>Waktu Cetak</strong></td>
                <td style="width: 35%;">: {{ now()->translatedFormat('l, d F Y H:i') }} WIB</td>
            </tr>
            @if($hariFilter || $tingkatFilter || $kelasFilter || $guruFilter)
            <tr>
                <td><strong>Filter Aktif</strong></td>
                <td colspan="3">: 
                    {{ $hariFilter ? "Hari: $hariFilter | " : "" }}
                    {{ $tingkatFilter ? "Tingkat: $tingkatFilter | " : "" }}
                    {{ $kelasFilter ? "ID Kelas: $kelasFilter | " : "" }}
                    {{ $guruFilter ? "ID Guru: $guruFilter" : "" }}
                </td>
            </tr>
            @endif
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 60px;">Hari</th>
                <th style="width: 70px;">Jam Ke</th>
                <th style="width: 100px;">Waktu KBM</th>
                <th style="width: 90px;">Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
                <th style="width: 80px;">Ruang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $index => $j)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $j->hari }}</td>
                    <td style="text-align: center;">{{ $j->jam_mulai_ke }} - {{ $j->jam_selesai_ke }}</td>
                    <td style="text-align: center;">{{ substr($j->waktu_mulai_effective, 0, 5) }} - {{ substr($j->waktu_selesai_effective, 0, 5) }}</td>
                    <td style="font-weight: bold; text-align: center;">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                    <td style="text-align: center;">{{ $j->ruangan->nama_ruangan ?? ($j->kelas->nama_kelas ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data jadwal pelajaran</td>
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