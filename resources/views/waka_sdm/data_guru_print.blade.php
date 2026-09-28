<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Direktori Pendidik & SDM — Waka SDM</title>
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
            Cetak Dokumen Direktori
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
        BUKU DIREKTORI DATA PENDIDIK &amp; TENAGA KEPENDIDIKAN
    </div>

    @php
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $monthsMapIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 45%;">{{ $now->day . ' ' . $monthsMapIndo[$now->month] . ' ' . $now->year }}</td>
            <td style="width: 15%;"><strong>Waka SDM</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 18%;">{{ $wakaSdmNama }}</td>
        </tr>
        <tr>
            <td><strong>Semester / T.A.</strong></td>
            <td>:</td>
            <td>Genap (2026/2027)</td>
            <td><strong>Total Pendidik</strong></td>
            <td>:</td>
            <td>{{ $totalGuru }} Guru Terdaftar</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Pendidik &amp; SDM</th>
                <th>NIP</th>
                <th style="width: 35px; text-align: center;">L/P</th>
                <th>No. HP / WhatsApp</th>
                <th>Email Akun</th>
                <th>Mata Pelajaran</th>
                <th>Peran Sistem</th>
                <th>Tugas Wali Kelas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guruList as $idx => $g)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $g->nama_guru }}</strong></td>
                    <td style="font-size: 10px;">{{ $g->nip ?? '-' }}</td>
                    <td style="text-align: center;">{{ $g->jenis_kelamin ?? '-' }}</td>
                    <td>{{ $g->no_hp ?? '-' }}</td>
                    <td style="font-size: 10px;">{{ $g->email ?? ($g->user ? $g->user->email : '-') }}</td>
                    <td>{{ $g->mapel ? $g->mapel->nama_mapel : 'Guru Mapel' }}</td>
                    <td>{{ $g->user ? $g->user->role_label : 'Master Guru' }}</td>
                    <td>{{ $g->kelasWali && $g->kelasWali->count() > 0 ? $g->kelasWali->pluck('nama_kelas')->join(', ') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 15px;">Tidak ada data pendidik yang terdaftar.</td>
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
            <p>Boyolangu, {{ $now->day . ' ' . $monthsMapIndo[$now->month] . ' ' . $now->year }}<br>Waka Bidang SDM &amp; Kepegawaian</p>
            <br><br><br>
            <p style="text-decoration: underline; font-weight: bold; margin-bottom: 2px;">{{ $wakaSdmNama }}</p>
            <p style="margin: 0;">NIP. {{ $wakaSdmNip }}</p>
        </div>
    </div>

</body>
</html>
