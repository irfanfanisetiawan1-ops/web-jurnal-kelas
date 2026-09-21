<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Kehadiran Siswa — SMKN 1 Boyolangu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 12mm 15mm 12mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 10px;
            font-size: 10.5pt;
            line-height: 1.3;
        }

        .no-print-bar {
            background: #1e293b;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-close {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            margin-bottom: 18px;
            padding-bottom: 8px;
        }

        .kop-table td {
            vertical-align: middle;
            text-align: center;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
        }

        .kop-text h4 {
            margin: 0;
            font-size: 13pt;
            font-weight: normal;
            letter-spacing: 0.5px;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16pt;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .kop-text p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            font-style: italic;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            margin: 15px 0 12px 0;
        }

        .doc-title h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-title p {
            margin: 4px 0 0 0;
            font-size: 10.5pt;
        }

        /* Meta Info Grid */
        .meta-box {
            width: 100%;
            margin-bottom: 16px;
            font-size: 10pt;
            border-collapse: collapse;
        }

        .meta-box td {
            padding: 3px 0;
            vertical-align: top;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 9pt;
        }

        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 5px 6px;
            vertical-align: middle;
        }

        .data-table th {
            background-color: #f1f5f9 !important;
            font-weight: bold;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
            font-size: 10.5pt;
        }

        .ttd-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Non-print action bar -->
    <div class="no-print-bar">
        <div>
            <strong><i class="fa-solid fa-print"></i> Mode Cetak Rekapitulasi Presensi Kehadiran Siswa</strong>
            <div style="font-size: 11.5px; opacity: 0.8; margin-top: 2px;">
                Dokumen Resmi Kepala Sekolah — Format Siap Cetak A4 / PDF
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close"><i class="fa-solid fa-times"></i> Tutup</button>
        </div>
    </div>

    <!-- Kop Surat Resmi SMKN 1 Boyolangu -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo" style="width: 15%;">
                <img src="{{ asset('images/logo-jatim.png') }}" alt="Logo Jatim" style="max-height: 75px;" onerror="this.style.display='none'">
            </td>
            <td class="kop-text" style="width: 70%;">
                <h4>PEMERINTAH PROVINSI JAWA TIMUR</h4>
                <h3>DINAS PENDIDIKAN</h3>
                <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 1 BOYOLANGU</h2>
                <p>Jl. Ki Mangunsarkoro Gg. SMKN 1 Telp. (0355) 323048 Fax. (0355) 323048 Tulungagung 66233<br>
                Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.com</p>
            </td>
            <td class="kop-logo" style="width: 15%;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMEA" style="max-height: 75px;" onerror="this.style.display='none'">
            </td>
        </tr>
    </table>

    <!-- Judul Dokumen -->
    <div class="doc-title">
        <h3>REKAPITULASI PRESENSI & KEHADIRAN SISWA PER KELAS</h3>
        <p>
            Tanggal: <strong>{{ \Carbon\Carbon::parse($filterTanggal)->translatedFormat('l, d F Y') }}</strong>
        </p>
    </div>

    <!-- Meta Info -->
    <table class="meta-box">
        <tr>
            <td style="width: 20%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 30%;">: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y - H:i') }} WIB</td>
            <td style="width: 25%;"><strong>Total Siswa Terdaftar</strong></td>
            <td style="width: 25%;">: {{ $totalSiswaReal }} Siswa</td>
        </tr>
        <tr>
            <td><strong>Rata-rata Kehadiran</strong></td>
            <td>: <strong>{{ $avgPersentase }}%</strong></td>
            <td><strong>Siswa Tidak Hadir</strong></td>
            <td>: {{ $grandTotalAbsen }} Siswa</td>
        </tr>
    </table>

    @if(count($kelasStats) == 1 && !empty(reset($kelasStats)['siswas']))
        @php $singleKelas = reset($kelasStats); @endphp
        <!-- Tampilan Cetak Khusus Per Kelas Tunggal -->
        <div style="background: #f8fafc; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 14px;">
            <strong>Kelas:</strong> {{ $singleKelas['nama_kelas'] }} &nbsp;|&nbsp;
            <strong>Jurusan:</strong> {{ $singleKelas['jurusan'] }} &nbsp;|&nbsp;
            <strong>Wali Kelas:</strong> {{ $singleKelas['wali_kelas'] }} (NIP: {{ $singleKelas['nip_wali_kelas'] }}) &nbsp;|&nbsp;
            <strong>Kehadiran:</strong> {{ $singleKelas['persentase'] }}% (H: {{ $singleKelas['hadir'] }}, S: {{ $singleKelas['sakit'] }}, I: {{ $singleKelas['izin'] }}, A: {{ $singleKelas['alpa'] }})
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Nama Lengkap Siswa</th>
                    <th style="width: 18%;">NISN</th>
                    <th style="width: 8%;">L/P</th>
                    <th style="width: 14%;">Status Presensi</th>
                    <th style="width: 25%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($singleKelas['siswas'] as $sidx => $st)
                    <tr>
                        <td style="text-align: center;">{{ $sidx + 1 }}</td>
                        <td><strong>{{ $st['nama_siswa'] }}</strong></td>
                        <td>{{ $st['nisn'] }}</td>
                        <td style="text-align: center;">{{ $st['jenis_kelamin'] }}</td>
                        <td style="text-align: center; font-weight: bold; {{ $st['status_kehadiran'] != 'HADIR' ? 'color: #991b1b;' : 'color: #166534;' }}">
                            {{ $st['status_kehadiran'] }}
                        </td>
                        <td style="font-size: 8.5pt;">{{ $st['keterangan'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- Table Data Rekap Semua Kelas -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 18%;">Nama Rombel Kelas</th>
                    <th style="width: 16%;">Jurusan</th>
                    <th style="width: 22%;">Wali Kelas</th>
                    <th style="width: 8%;">Total</th>
                    <th style="width: 7%;">Hadir</th>
                    <th style="width: 5%;">S</th>
                    <th style="width: 5%;">I</th>
                    <th style="width: 5%;">A</th>
                    <th style="width: 10%;">% Hadir</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($kelasStats as $st)
                    <tr>
                        <td style="text-align: center;">{{ $no++ }}</td>
                        <td><strong>{{ $st['nama_kelas'] }}</strong></td>
                        <td>{{ $st['jurusan'] }}</td>
                        <td style="font-size: 8.5pt;">{{ $st['wali_kelas'] }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $st['total_siswa'] }}</td>
                        <td style="text-align: center; color: #166534; font-weight: bold;">{{ $st['hadir'] }}</td>
                        <td style="text-align: center;">{{ $st['sakit'] }}</td>
                        <td style="text-align: center;">{{ $st['izin'] }}</td>
                        <td style="text-align: center; {{ $st['alpa'] > 0 ? 'color: #991b1b; font-weight: bold;' : '' }}">{{ $st['alpa'] }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $st['persentase'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f8fafc; font-weight: bold;">
                    <td colspan="4" style="text-align: right; padding-right: 10px;">TOTAL KESELURUHAN:</td>
                    <td style="text-align: center;">{{ $totalSiswaReal }}</td>
                    <td style="text-align: center; color: #166534;">{{ $grandTotalHadir }}</td>
                    <td style="text-align: center;">{{ array_sum(array_column($kelasStats, 'sakit')) }}</td>
                    <td style="text-align: center;">{{ array_sum(array_column($kelasStats, 'izin')) }}</td>
                    <td style="text-align: center;">{{ array_sum(array_column($kelasStats, 'alpa')) }}</td>
                    <td style="text-align: center; color: #166534;">{{ $avgPersentase }}%</td>
                </tr>
            </tfoot>
        </table>
    @endif

    <!-- Lembar Tanda Tangan -->
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Koordinator Guru Piket Harian<br><br><br><br><br>
                <strong><u>......................................................</u></strong><br>
                NIP. .................................................
            </td>
            <td>
                Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}<br>
                Kepala SMKN 1 Boyolangu<br><br><br><br><br>
                <strong><u>ARIK EKO LESTARI, S.Pd</u></strong><br>
                NIP. 19780512 200501 1 008
            </td>
        </tr>
    </table>

</body>
</html>