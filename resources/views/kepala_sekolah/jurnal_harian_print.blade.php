<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Jurnal Mengajar Harian — {{ $hariTeks }}, {{ $tglCarbon->translatedFormat('d F Y') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 14mm 10mm 14mm 10mm;
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

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
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

        .meta-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 10px;
            font-size: 9.5pt;
            font-family: Arial, sans-serif;
        }

        .meta-info-grid table td {
            padding: 2px 6px 2px 0;
        }

        /* Table Style */
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

        /* Tanda Tangan Block */
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

        .signature-img {
            max-height: 70px;
            max-width: 180px;
            margin: 4px auto;
            display: block;
        }

        .signature-space {
            height: 70px;
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
            <strong><i class="fa-solid fa-print"></i> Cetak Rekapitulasi Jurnal Mengajar Harian (Disahkan Guru Piket)</strong>
            <span style="opacity: 0.8; margin-left: 10px;">{{ $hariTeks }}, {{ $tglCarbon->translatedFormat('d F Y') }}</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close">Tutup</button>
        </div>
    </div>

    <!-- Kop Surat Resmi -->
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
        <h3>REKAPITULASI JURNAL MENGAJAR HARIAN</h3>
        <div style="font-size: 9.5pt; font-family: Arial, sans-serif; margin-top: 2px;">
            Hari: <strong>{{ $hariTeks }}</strong> &nbsp;|&nbsp; Tanggal: <strong>{{ $tglCarbon->translatedFormat('d F Y') }}</strong>
        </div>
    </div>

    <div class="meta-info-grid">
        <table>
            <tr>
                <td style="width: 140px;">Tahun Ajaran / Semester</td>
                <td>: 2026/2027 — Ganjil</td>
            </tr>
            <tr>
                <td>Petugas Guru Piket</td>
                <td>: <strong>{{ $verifikasi ? ($verifikasi->nama_guru_piket ?: ($verifikasi->guru->nama_guru ?? 'Petugas Guru Piket')) : 'Petugas Guru Piket SMKN 1 Boyolangu' }}</strong></td>
            </tr>
        </table>
        <table style="text-align: right;">
            <tr>
                <td>Status Verifikasi</td>
                <td>: {!! $verifikasi && $verifikasi->status === 'terverifikasi' ? '<span style="color: #15803d; font-weight: bold;">[ TERVERIFIKASI & TTD RESMI ]</span>' : '<span style="color: #b45309; font-weight: bold;">[ BELUM DIVERIFIKASI ]</span>' !!}</td>
            </tr>
            <tr>
                <td>Total KBM Terlaksana</td>
                <td>: <strong>{{ $jurnals->count() }} Sesi Kelas</strong></td>
            </tr>
        </table>
    </div>

    <!-- Tabel KBM -->
    <table class="rekap-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 65px;">Jam Ke</th>
                <th style="width: 80px;">Waktu</th>
                <th style="width: 70px;">Kelas</th>
                <th style="width: 65px;">Ruang</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengampu / Pengganti</th>
                <th>Materi Pembelajaran</th>
                <th style="width: 65px;">Kehadiran</th>
                <th style="width: 65px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $idx => $j)
                @php
                    $guruTeks = $j->jadwal->guru->nama_guru ?? ($j->guru->nama_guru ?? '-');
                    if ($j->id_guru_pengganti && $j->guruPengganti) {
                        $guruTeks .= ' (Diganti: ' . $j->guruPengganti->nama_guru . ')';
                    }
                    $absenCount = $j->detailKetidakhadiran ? $j->detailKetidakhadiran->count() : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center"><strong>{{ $j->jam_ke ?: ($j->jadwal->jam_range ?? '-') }}</strong></td>
                    <td class="text-center">{{ $j->jadwal->waktu_mulai_effective ?? '07:00' }} - {{ $j->jadwal->waktu_selesai_effective ?? '08:20' }}</td>
                    <td class="text-center"><strong>{{ $j->jadwal->kelas->nama_kelas ?? ($j->kelas->nama_kelas ?? '-') }}</strong></td>
                    <td class="text-center">{{ $j->jadwal->ruangan->nama_ruangan ?? 'R.Kelas' }}</td>
                    <td><strong>{{ $j->jadwal->mapel->nama_mapel ?? ($j->mapel->nama_mapel ?? '-') }}</strong></td>
                    <td>{{ $guruTeks }}</td>
                    <td>{{ $j->materi ?? '-' }}</td>
                    <td class="text-center">
                        @if($absenCount > 0)
                            <span style="color: #b91c1c; font-weight: bold;">{{ $absenCount }} Absen</span>
                        @else
                            <span style="color: #15803d;">Lengkap</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span style="font-weight: bold; color: {{ $j->status_kehadiran_guru === 'Hadir' ? '#15803d' : '#b91c1c' }};">
                            {{ $j->id_guru_pengganti ? 'Digantikan' : ($j->status_kehadiran_guru ?? 'Terlaksana') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 20px; color: #64748b;">
                        Tidak ada laporan Jurnal Mengajar yang tersimpan pada tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Block -->
    <div class="signature-container">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div>Kepala SMKN 1 Boyolangu</div>
            <div class="signature-space"></div>
            <div class="signature-name">Trisno Wibowo, S.Pd., M.M.</div>
            <div>NIP. 198101152003121003</div>
        </div>

        <div class="signature-box">
            <div>Tulungagung, {{ $tglCarbon->translatedFormat('d F Y') }}</div>
            <div>Petugas Guru Piket Pengesah,</div>
            
            @if($verifikasi && $verifikasi->tanda_tangan)
                <img src="{{ $verifikasi->tanda_tangan }}" alt="Tanda Tangan Guru Piket" class="signature-img">
            @else
                <div class="signature-space" style="display: flex; align-items: center; justify-content: center; color: #94a3b8; font-style: italic; font-size: 8.5pt;">
                    (Belum Ditandatangani)
                </div>
            @endif

            <div class="signature-name">{{ $verifikasi ? ($verifikasi->nama_guru_piket ?: ($verifikasi->guru->nama_guru ?? '................................................')) : '................................................' }}</div>
            <div>NIP. {{ $verifikasi ? ($verifikasi->nip_guru_piket ?: ($verifikasi->guru->nip ?? '................................................')) : '................................................' }}</div>
            @if($verifikasi && $verifikasi->waktu_verifikasi)
                <div style="font-size: 8pt; color: #475569; margin-top: 2px;">
                    Diverifikasi: {{ \Carbon\Carbon::parse($verifikasi->waktu_verifikasi)->format('d/m/Y H:i') }} WIB
                </div>
            @endif
        </div>
    </div>

</body>
</html>