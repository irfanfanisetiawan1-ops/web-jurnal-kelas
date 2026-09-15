<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pelanggaran Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            font-size: 10.5pt;
        }

        .kop-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-logo { width: 65px; height: 65px; object-fit: contain; }
        .kop-text { text-align: center; }
        .kop-text h2 { font-size: 13pt; font-weight: 800; margin: 0; text-transform: uppercase; }
        .kop-text h3 { font-size: 15pt; font-weight: 800; margin: 2px 0; color: #2563eb; text-transform: uppercase; }
        .kop-text p { font-size: 8.5pt; color: #475569; margin: 2px 0; }

        .doc-title-box { text-align: center; margin-bottom: 16px; }
        .doc-title-box h1 { font-size: 13pt; font-weight: 800; margin: 0; text-transform: uppercase; }
        .doc-title-box p { font-size: 9pt; color: #475569; margin: 4px 0 0 0; }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .print-table th {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 8.5pt;
            font-weight: 800;
            text-align: center;
            color: #1e293b;
            text-transform: uppercase;
        }

        .print-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 8px;
            font-size: 8.5pt;
            color: #0f172a;
            vertical-align: middle;
        }

        .text-center { text-align: center; }

        .signature-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-box .place-date { font-size: 9pt; color: #475569; margin-bottom: 4px; }
        .signature-box .role-title { font-size: 9.5pt; font-weight: 700; color: #0f172a; margin-bottom: 60px; }
        .signature-box .officer-name { font-size: 10pt; font-weight: 800; text-decoration: underline; color: #0f172a; }
        .signature-box .officer-nip { font-size: 8.5pt; color: #475569; margin-top: 2px; }

        .no-print-bar {
            background: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-print-action {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        @media print {
            .no-print-bar { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <i class="fa-solid fa-file-pdf" style="margin-right: 8px; color: #60a5fa;"></i>
            <strong>Pratinjau Cetak Laporan Pelanggaran Siswa</strong> — {{ $formattedDateIndo }}
        </div>
        <button class="btn-print-action" onclick="window.print()">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <div class="kop-header">
        <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="Logo Sekolah" class="kop-logo">
        <div class="kop-text">
            <h2>Pemerintah Provinsi Jawa Timur • Dinas Pendidikan</h2>
            <h3>SMK EKONOMI & BISNIS (SMEA)</h3>
            <p>Jalan Pendidikan No. 45, Kota Probolinggo • Telepon: (0335) 421234 • Email: info@smk-smea.sch.id</p>
        </div>
    </div>

    <div class="doc-title-box">
        <h1>LAPORAN REKAPITULASI PELANGGARAN TATA TERTIB SISWA</h1>
        <p>Tanggal Laporan: <strong>{{ $formattedDateIndo }}</strong> @if($selectedKelas) | Kelas: <strong>{{ $selectedKelas->nama_kelas }}</strong> @endif</p>
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 70px;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 80px;">Kelas</th>
                <th style="width: 70px;">Kategori</th>
                <th>Jenis Pelanggaran</th>
                <th style="width: 45px;">Poin</th>
                <th style="width: 75px;">Tanggal</th>
                <th>Alasan</th>
                <th>Tindakan / Sanksi</th>
                <th style="width: 65px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $idx => $row)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $row->siswa->nis ?? '-' }}</td>
                    <td><strong>{{ $row->siswa->nama_siswa ?? '-' }}</strong></td>
                    <td class="text-center">{{ $row->kelas->nama_kelas ?? ($row->siswa->kelas->nama_kelas ?? '-') }}</td>
                    <td class="text-center">{{ $row->kategori_pelanggaran }}</td>
                    <td>{{ $row->jenis_pelanggaran }}</td>
                    <td class="text-center">{{ $row->poin_pelanggaran }}</td>
                    <td class="text-center">{{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $row->alasan ?? '-' }}</td>
                    <td>{{ $row->tindakan_sanksi ?? '-' }}</td>
                    <td class="text-center">{{ $row->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding: 20px;">Tidak ada data pelanggaran siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="place-date">Probolinggo, {{ $formattedDateIndo }}</div>
            <div class="role-title">Wakil Kepala Sekolah Bidang Kesiswaan</div>
            <div class="officer-name">{{ $waka->nama_guru ?? 'Fajar Luthfianto, S.Pd' }}</div>
            <div class="officer-nip">NIP. {{ $waka->nip ?? '19850315 201001 1 012' }}</div>
        </div>
    </div>

</body>
</html>