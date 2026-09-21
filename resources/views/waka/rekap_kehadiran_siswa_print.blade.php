<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Siswa — {{ $selectedDate }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            font-size: 11pt;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Kop Surat Resmi */
        .kop-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            font-size: 14pt;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-text h3 {
            font-size: 16pt;
            font-weight: 800;
            margin: 2px 0;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-text p {
            font-size: 8.5pt;
            color: #475569;
            margin: 2px 0;
        }

        /* Document Title */
        .doc-title-box {
            text-align: center;
            margin-bottom: 16px;
        }

        .doc-title-box h1 {
            font-size: 13pt;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-title-box p {
            font-size: 9.5pt;
            color: #475569;
            margin: 4px 0 0 0;
            font-weight: 600;
        }

        /* Summary Stats Cards for Print */
        .summary-stats-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .stat-mini-card {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 12px;
            text-align: center;
            background: #f8fafc;
        }

        .stat-mini-card .label {
            font-size: 8pt;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        .stat-mini-card .num {
            font-size: 13pt;
            font-weight: 800;
            color: #0f172a;
            margin: 2px 0;
        }

        .stat-mini-card .pct {
            font-size: 7.5pt;
            font-weight: 700;
        }

        /* Print Table */
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

        .badge-print {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: 800;
            text-transform: uppercase;
        }

        .badge-print-hadir { background: #dcfce7; color: #15803d; }
        .badge-print-izin  { background: #fef3c7; color: #b45309; }
        .badge-print-sakit { background: #ffe4e6; color: #e11d48; }
        .badge-print-alpa  { background: #fee2e2; color: #b91c1c; }

        /* Signature Block */
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

        .signature-box .place-date {
            font-size: 9pt;
            color: #475569;
            margin-bottom: 4px;
        }

        .signature-box .role-title {
            font-size: 9.5pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 60px;
        }

        .signature-box .officer-name {
            font-size: 10pt;
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        .signature-box .officer-nip {
            font-size: 8.5pt;
            color: #475569;
            margin-top: 2px;
        }

        /* Action bar for screen only */
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

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print-bar">
        <div>
            <i class="fa-solid fa-file-pdf" style="margin-right: 8px; color: #60a5fa;"></i>
            <strong>Pratinjau Cetak Rekap Kehadiran Siswa</strong> — {{ $formattedDateIndo }}
        </div>
        <button class="btn-print-action" onclick="window.print()">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="kop-header">
        <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="Logo Sekolah" class="kop-logo">
        <div class="kop-text">
            <h2>Pemerintah Provinsi Jawa Timur • Dinas Pendidikan</h2>
            <h3>SMK EKONOMI & BISNIS (SMEA)</h3>
            <p>Jalan Pendidikan No. 45, Kota Probolinggo • Telepon: (0335) 421234 • Email: info@smk-smea.sch.id</p>
        </div>
    </div>

    <!-- Judul Dokumen -->
    <div class="doc-title-box">
        <h1>LAPORAN REKAPITULASI KEHADIRAN SISWA</h1>
        <p>Hari/Tanggal: <strong>{{ $formattedDateIndo }}</strong> @if($selectedKelas) | Kelas: <strong>{{ $selectedKelas->nama_kelas }}</strong> @endif</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="summary-stats-box">
        <div class="stat-mini-card">
            <div class="label">Total Siswa</div>
            <div class="num">{{ number_format($totalSiswa, 0, ',', '.') }}</div>
            <div class="pct" style="color: #64748b;">Terdaftar</div>
        </div>
        <div class="stat-mini-card">
            <div class="label">Hadir</div>
            <div class="num" style="color: #16a34a;">{{ number_format($countHadir, 0, ',', '.') }}</div>
            <div class="pct" style="color: #16a34a;">{{ $totalSiswa > 0 ? round(($countHadir / $totalSiswa) * 100, 1) : 0 }}%</div>
        </div>
        <div class="stat-mini-card">
            <div class="label">Izin / Sakit</div>
            <div class="num" style="color: #ea580c;">{{ number_format($countIzin + $countSakit, 0, ',', '.') }}</div>
            <div class="pct" style="color: #ea580c;">{{ $totalSiswa > 0 ? round((($countIzin + $countSakit) / $totalSiswa) * 100, 1) : 0 }}%</div>
        </div>
        <div class="stat-mini-card">
            <div class="label">Tidak Hadir / Alpa</div>
            <div class="num" style="color: #dc2626;">{{ number_format($countAlpa, 0, ',', '.') }}</div>
            <div class="pct" style="color: #dc2626;">{{ $totalSiswa > 0 ? round(($countAlpa / $totalSiswa) * 100, 1) : 0 }}%</div>
        </div>
    </div>

    <!-- Tabel Data Rekap -->
    <table class="print-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 70px;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 80px;">Kelas</th>
                <th style="width: 45px;">Hadir</th>
                <th style="width: 45px;">Izin</th>
                <th style="width: 45px;">Sakit</th>
                <th style="width: 45px;">Alpa</th>
                <th style="width: 70px;">Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($processedSiswas as $index => $siswa)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $siswa->nis }}</td>
                    <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                    <td class="text-center">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center">{{ $siswa->is_hadir ? 'V' : '-' }}</td>
                    <td class="text-center">{{ $siswa->is_izin ? 'V' : '-' }}</td>
                    <td class="text-center">{{ $siswa->is_sakit ? 'V' : '-' }}</td>
                    <td class="text-center">{{ $siswa->is_alpa ? 'V' : '-' }}</td>
                    <td class="text-center">
                        @if($siswa->kehadiran_status === 'Hadir')
                            <span class="badge-print badge-print-hadir">Hadir</span>
                        @elseif($siswa->kehadiran_status === 'Izin')
                            <span class="badge-print badge-print-izin">Izin</span>
                        @elseif($siswa->kehadiran_status === 'Sakit')
                            <span class="badge-print badge-print-sakit">Sakit</span>
                        @else
                            <span class="badge-print badge-print-alpa">Alpa</span>
                        @endif
                    </td>
                    <td>{{ $siswa->keterangan_kehadiran }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 20px;">Data presensi siswa tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Waka Kesiswaan -->
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