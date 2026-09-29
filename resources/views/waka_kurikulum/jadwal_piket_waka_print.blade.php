<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JADWAL PIKET WAKA BULAN {{ strtoupper($namaBulan) }} {{ $tahun }} — SMK NEGERI 1 BOYOLANGU</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            border-bottom: 2.5px solid #000000;
            padding-bottom: 8px;
            margin-bottom: 16px;
            text-align: center;
            line-height: 1.25;
        }

        .kop-surat .instansi-prov {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-surat .instansi-dinas {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-surat .nama-sekolah {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 2px 0;
        }

        .kop-surat .alamat-sekolah {
            font-size: 10px;
            color: #333333;
        }

        .title-box {
            text-align: center;
            margin-bottom: 16px;
        }

        .title-box h1 {
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .title-box p {
            font-size: 11.5px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #000000;
            padding: 7px 8px;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10.5px;
        }

        .text-center {
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            padding: 0 20px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            width: 240px;
        }

        .signature-box .date-line {
            margin-bottom: 55px;
        }

        .signature-box .name-line {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-box .nip-line {
            font-size: 10.5px;
        }

        .no-print-bar {
            background: #f1f5f9;
            padding: 10px 16px;
            border-bottom: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: inherit;
            margin-bottom: 15px;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-close {
            background: #64748b;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <strong>Cetak Jadwal Piket Waka — Bulan {{ $namaBulan }} {{ $tahun }}</strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
            <a href="javascript:window.close()" class="btn-close">Tutup</a>
        </div>
    </div>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <div class="instansi-prov">PEMERINTAH PROVINSI JAWA TIMUR</div>
        <div class="instansi-dinas">DINAS PENDIDIKAN</div>
        <div class="nama-sekolah">SMK NEGERI 1 BOYOLANGU</div>
        <div class="alamat-sekolah">Jl. Ki Mangunsarkoro VI/3 Tulungagung Telp./Fax. (0355) 321689</div>
        <div class="alamat-sekolah">Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.com</div>
    </div>

    <div class="title-box">
        <h1>DAFTAR PENUGASAN JADWAL PIKET WAKIL KEPALA SEKOLAH (PIKET WAKA)</h1>
        <p>BULAN {{ strtoupper($namaBulan) }} TAHUN {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px;">NO</th>
                <th style="width: 80px;">HARI</th>
                <th style="width: 140px;">TANGGAL</th>
                <th>NAMA GURU PIKET WAKA</th>
                <th style="width: 150px;">NIP</th>
                <th style="width: 140px;">CATATAN / TUGAS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($workDays as $idx => $wd)
                @php
                    $tgl = $wd['tanggal'];
                    $item = $jadwalList[$tgl] ?? null;
                    $namaGuru = $item && $item->guru ? $item->guru->nama_guru : '-';
                    $nip = $item && $item->guru ? ($item->guru->nip ?? '-') : '-';
                    $catatan = $item ? ($item->catatan ?? '-') : '-';
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center" style="font-weight: bold;">{{ $wd['hari'] }}</td>
                    <td class="text-center">{{ $wd['label'] }}</td>
                    <td style="font-weight: 600;">{{ $namaGuru }}</td>
                    <td class="text-center">{{ $nip }}</td>
                    <td>{{ $catatan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada jadwal piket waka yang diatur untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="date-line">
                Mengetahui,<br>
                Kepala SMK Negeri 1 Boyolangu
            </div>
            <div class="name-line">TRI SUTRISNO, S.Pd., M.M.</div>
            <div class="nip-line">NIP. 19680514 199412 1 003</div>
        </div>

        <div class="signature-box">
            <div class="date-line">
                Tulungagung, 01 {{ $namaBulan }} {{ $tahun }}<br>
                Waka Kurikulum
            </div>
            <div class="name-line">HARDINI INDAHING BUDI, S.E., M.Pd.</div>
            <div class="nip-line">NIP. 19740925 200801 2 011</div>
        </div>
    </div>

</body>
</html>
