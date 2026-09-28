<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Jurnal Mengajar Guru — SMKN 1 Boyolangu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 10mm 12mm 10mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 10px;
            font-size: 10.5pt;
            line-height: 1.25;
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
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 14px;
            position: relative;
        }

        .kop-logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 65px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            width: 100%;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 12pt;
            font-weight: normal;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 15pt;
            font-weight: bold;
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 9pt;
            font-family: Arial, sans-serif;
        }

        .doc-title {
            text-align: center;
            margin-bottom: 12px;
        }

        .doc-title h3 {
            margin: 0;
            font-size: 12.5pt;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 16px;
        }

        .rekap-table th, .rekap-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
        }

        .rekap-table th {
            background-color: #f1f5f9;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            page-break-inside: avoid;
            font-size: 10pt;
        }

        .signature-box {
            width: 280px;
            text-align: center;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
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
            <strong><i class="fa-solid fa-print"></i> Mode Cetak Dokumen Jurnal Mengajar Guru</strong>
            <span style="opacity: 0.8; margin-left: 10px;">Total: {{ $jurnals->count() }} Data Sesi</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close">Tutup</button>
        </div>
    </div>

    <div class="kop-surat">
        <img src="{{ asset('assets/images/logo_smk.png') }}" alt="Logo SMK" class="kop-logo" onerror="this.style.display='none'">
        <div class="kop-text">
            <h3>PEMERINTAH PROVINSI JAWA TIMUR</h3>
            <h3>DINAS PENDIDIKAN</h3>
            <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 1 BOYOLANGU</h2>
            <p>Jalan Ki Mangunsarkoro Gg. VI/3 Tulungagung 66233 | Telp. (0355) 321854</p>
            <p>Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.co.id</p>
        </div>
    </div>

    <div class="doc-title">
        <h3>LAPORAN DAFTAR JURNAL MENGAJAR GURU</h3>
        <div style="font-size: 9.5pt; font-family: Arial, sans-serif; margin-top: 2px;">
            Tahun Ajaran 2026/2027 — Semester Ganjil &nbsp;|&nbsp; Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <table class="rekap-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 70px;">Tanggal</th>
                <th style="width: 60px;">Jam KBM</th>
                <th style="width: 65px;">Kelas</th>
                <th style="width: 60px;">Ruang</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengampu / Pengganti</th>
                <th>Materi Pembelajaran</th>
                <th style="width: 35px;">Ptm</th>
                <th style="width: 65px;">Status</th>
                <th style="width: 85px;">Verif Piket</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $idx => $j)
                @php
                    $namaGuru = $j->jadwal->guru->nama_guru ?? ($j->guru->nama_guru ?? '-');
                    if ($j->id_guru_pengganti && $j->guruPengganti) {
                        $namaGuru .= ' (Diganti: ' . $j->guruPengganti->nama_guru . ')';
                    }
                    $pertemuanClean = preg_replace('/^ke[-_\s]*/i', '', trim($j->pertemuan_ke ?? '1'));
                    $verif = $j->verifikasiPiket;
                    $isVerif = ($verif && $verif->status === 'terverifikasi');
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $j->jam_ke ?: ($j->jadwal->jam_range ?? '-') }}</td>
                    <td class="text-center"><strong>{{ $j->jadwal->kelas->nama_kelas ?? ($j->kelas->nama_kelas ?? '-') }}</strong></td>
                    <td class="text-center">{{ $j->jadwal->ruangan->nama_ruangan ?? 'R.Kelas' }}</td>
                    <td><strong>{{ $j->jadwal->mapel->nama_mapel ?? ($j->mapel->nama_mapel ?? '-') }}</strong></td>
                    <td>{{ $namaGuru }}</td>
                    <td>{{ $j->materi ?: '-' }}</td>
                    <td class="text-center">Ke-{{ $pertemuanClean ?: 1 }}</td>
                    <td class="text-center">
                        <span style="font-weight: bold; color: {{ $j->status_kehadiran_guru === 'Hadir' ? '#15803d' : '#b91c1c' }};">
                            {{ $j->id_guru_pengganti ? 'Digantikan' : ($j->status_kehadiran_guru ?? 'Terlaksana') }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($isVerif)
                            <span style="color: #15803d; font-weight: bold; font-size: 8pt;"><i class="fa-solid fa-check"></i> Terverifikasi</span>
                        @else
                            <span style="color: #64748b; font-size: 8pt;">Belum Verif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding: 20px; color: #64748b;">
                        Tidak ada data jurnal mengajar yang sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div>Kepala SMKN 1 Boyolangu</div>
            <div class="signature-space"></div>
            <div class="signature-name">Trisno Wibowo, S.Pd., M.M.</div>
            <div>NIP. 198101152003121003</div>
        </div>

        <div class="signature-box">
            <div>Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
            <div>Petugas Pengawas / Waka Kurikulum,</div>
            <div class="signature-space"></div>
            <div class="signature-name">................................................</div>
            <div>NIP. ................................................</div>
        </div>
    </div>

</body>
</html>