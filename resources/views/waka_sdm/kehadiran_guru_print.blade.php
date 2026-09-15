<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Monitoring Kehadiran Guru & KBM — Waka SDM</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; padding: 25px 35px; color: #000; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 18px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; font-weight: bold; }
        .header h3 { margin: 3px 0; font-size: 14px; text-transform: uppercase; font-weight: bold; }
        .header p { margin: 0; font-size: 11px; }
        .title-doc { text-align: center; margin: 15px 0; font-size: 13.5px; text-transform: uppercase; font-weight: bold; text-decoration: underline; }
        .meta-table { width: 100%; border: none; margin-bottom: 15px; font-size: 11.5px; }
        .meta-table td { padding: 3px 0; border: none; }
        
        .stat-summary-boxes {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 10px;
        }
        .stat-box {
            flex: 1;
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
            font-size: 11px;
        }
        .stat-box strong { font-size: 13px; display: block; margin-top: 3px; }

        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10.5px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 5px 6px; text-align: left; }
        table.data-table th { background: #f2f2f2; text-align: center; font-weight: bold; }

        .footer-sign-container {
            margin-top: 35px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .footer-sign-box {
            width: 250px;
            text-align: center;
            font-size: 11.5px;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 18px; background: #2b3957; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen Laporan
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="header">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h2>DINAS PENDIDIKAN</h2>
        <h3>SMK NEGERI 1 BOYOLANGU</h3>
        <p>Jl. Ki Mangunsarkoro No. 1, Boyolangu, Kab. Tulungagung, Jawa Timur 66233 | Telp. (0355) 321746 | Email: smkn1boyolangu@yahoo.co.id</p>
    </div>

    <div class="title-doc">
        LAPORAN MONITORING KEHADIRAN PENDIDIK & PELAKSANAAN KBM
    </div>

    @php
        $cDate = \Carbon\Carbon::parse($tanggal);
        $monthsMapIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $dateFormatted = $hariTeks . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
    @endphp

    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Hari / Tanggal</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 45%;">{{ $dateFormatted }}</td>
            <td style="width: 15%;"><strong>Waka SDM</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 18%;">{{ $wakaSdmNama }}</td>
        </tr>
        <tr>
            <td><strong>Semester / T.A.</strong></td>
            <td>:</td>
            <td>Genap (2026/2027)</td>
            <td><strong>Waktu Cetak</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</td>
        </tr>
    </table>

    <div class="stat-summary-boxes">
        <div class="stat-box">
            Total Sesi Terjadwal
            <strong>{{ $dailyStats['totalSesi'] ?? count($allSesiRows) }} Sesi</strong>
        </div>
        <div class="stat-box">
            Hadir Terlaksana
            <strong>{{ $dailyStats['sesiHadir'] ?? 0 }} Sesi</strong>
        </div>
        <div class="stat-box">
            Izin / Tugas Dinas
            <strong>{{ $dailyStats['sesiIzin'] ?? 0 }} Sesi</strong>
        </div>
        <div class="stat-box">
            Sakit / Tidak Hadir
            <strong>{{ $dailyStats['sesiTidakHadir'] ?? 0 }} Sesi</strong>
        </div>
        <div class="stat-box">
            Guru Pengganti (Inval)
            <strong>{{ $dailyStats['sesiDigantikan'] ?? 0 }} Sesi</strong>
        </div>
        <div class="stat-box">
            Keterisian Jurnal KBM
            <strong>{{ $dailyStats['persenKBM'] ?? 0 }}%</strong>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Guru Pengampu</th>
                <th>NIP</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Ruangan</th>
                <th>Jam Ke</th>
                <th>Waktu</th>
                <th>Status Kehadiran</th>
                <th>Guru Pengganti (Inval)</th>
                <th>Materi / Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allSesiRows as $idx => $r)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $r->guru_nama }}</strong></td>
                    <td style="font-size: 10px;">{{ $r->guru_nip }}</td>
                    <td>{{ $r->mapel_nama }}</td>
                    <td>{{ $r->kelas_nama }}</td>
                    <td>{{ $r->ruangan_nama }}</td>
                    <td style="text-align: center;">{{ $r->jam_ke }}</td>
                    <td style="font-size: 10px; white-space: nowrap;">{{ $r->jam }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $r->status_teks }}</td>
                    <td>{{ $r->guru_pengganti_nama ?? '-' }}</td>
                    <td style="font-size: 10px;">{{ $r->materi . ($r->keterangan !== '-' ? ' (' . $r->keterangan . ')' : '') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center; padding: 15px;">Tidak ada sesi jadwal pembelajaran pada tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-sign-container">
        <div class="footer-sign-box">
            <p>Mengetahui,<br>Kepala SMK Negeri 1 Boyolangu</p>
            <br><br><br>
            <p style="text-decoration: underline; font-weight: bold; margin-bottom: 2px;">Drs. H. Mulyadi, M.Pd</p>
            <p style="margin: 0;">NIP. 19680512 199412 1 002</p>
        </div>

        <div class="footer-sign-box">
            <p>Boyolangu, {{ $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year }}<br>Waka Bidang SDM &amp; Kepegawaian</p>
            <br><br><br>
            <p style="text-decoration: underline; font-weight: bold; margin-bottom: 2px;">{{ $wakaSdmNama }}</p>
            <p style="margin: 0;">NIP. {{ $wakaSdmNip }}</p>
        </div>
    </div>

</body>
</html>
