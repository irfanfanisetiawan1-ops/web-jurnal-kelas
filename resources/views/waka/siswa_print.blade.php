<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Siswa — SMKN 1 Boyolangu</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 20mm 15mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.3;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex: 1;
            padding: 0 15px;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-text p {
            margin: 2px 0 0;
            font-size: 9.5pt;
            font-style: italic;
        }

        .doc-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .doc-title h3 {
            margin: 0;
            font-size: 13pt;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .doc-title p {
            margin: 4px 0 0;
            font-size: 10pt;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }

        /* Tanda Tangan */
        .ttd-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .ttd-box {
            text-align: center;
            width: 250px;
        }

        .ttd-space {
            height: 65px;
        }

        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen / Simpan PDF</button>
    </div>

    <!-- Kop Surat SMKN 1 Boyolangu -->
    <div class="kop-surat">
        <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" class="kop-logo" alt="Logo Sekolah" onerror="this.style.display='none'">
        <div class="kop-text">
            <h3>PEMERINTAH PROVINSI JAWA TIMUR</h3>
            <h3>DINAS PENDIDIKAN</h3>
            <h2>SMK NEGERI 1 BOYOLANGU</h2>
            <p>Jl. Ki Mangunsarkoro VI/3, Telp. (0355) 323041, Boyolangu, Tulungagung 66233</p>
            <p>Website: www.smkn1boyolangu.sch.id | Email: info@smkn1boyolangu.sch.id</p>
        </div>
    </div>

    <div class="doc-title">
        <h3>DAFTAR INDUK DATA SISWA AKTIF</h3>
        <p>Tahun Ajaran 2026/2027 — Semester Ganjil</p>
        @if($selectedKelas)
            <p style="font-weight:bold;">Kelas: {{ $selectedKelas->nama_kelas }} ({{ $selectedKelas->jurusan->nama_jurusan ?? '' }})</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 90px;">NISN</th>
                <th style="width: 80px;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 40px;">JK</th>
                <th style="width: 90px;">Kelas</th>
                <th>Tempat, Tanggal Lahir</th>
                <th style="width: 60px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $idx => $s)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center" style="font-family:monospace;">{{ $s->nisn }}</td>
                    <td class="text-center">{{ $s->nis ?? '-' }}</td>
                    <td><strong>{{ $s->nama_siswa }}</strong></td>
                    <td class="text-center">{{ $s->jenis_kelamin }}</td>
                    <td class="text-center">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->kota_lahir ? ($s->kota_lahir . ', ') : '' }}{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ ($s->is_active ?? 1) ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Boyolangu, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p>Waka Bidang Kesiswaan,</p>
            <div class="ttd-space"></div>
            <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $waka->nama_guru ?? 'Fajar Luthfianto, S.Pd' }}</p>
            <p style="margin: 2px 0 0;">NIP. {{ $waka->nip ?? '19850315 201001 1 012' }}</p>
        </div>
    </div>

</body>
</html>