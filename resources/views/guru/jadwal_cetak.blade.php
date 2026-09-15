<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titleDoc }} — T.A. 2026/2027</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 12mm 15mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            background: #f8fafc;
            margin: 0;
            padding: 20px;
            font-size: 11pt;
            line-height: 1.4;
        }

        .paper {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            box-sizing: border-box;
        }

        /* Kop Surat Resmi SMKN 1 Boyolangu */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .kop-logo {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        .kop-header {
            flex: 1;
            text-align: center;
            line-height: 1.25;
        }

        .kop-header h2 {
            font-size: 13pt;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .kop-header h1 {
            font-size: 16pt;
            font-weight: 800;
            margin: 2px 0;
            letter-spacing: 1px;
        }

        .kop-header p {
            font-size: 9.5pt;
            margin: 2px 0;
            font-style: italic;
        }

        .kop-line {
            border: none;
            border-top: 3px double #000000;
            margin: 10px 0 16px 0;
        }

        /* Title Document */
        .doc-title {
            text-align: center;
            margin-bottom: 16px;
        }

        .doc-title h3 {
            font-size: 13pt;
            font-weight: 800;
            margin: 0;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .doc-title p {
            font-size: 10.5pt;
            margin: 4px 0 0 0;
            font-weight: 600;
        }

        /* Info Metadata Table */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10.5pt;
        }

        .meta-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .meta-label {
            font-weight: 700;
            width: 140px;
        }

        /* Table Data Schedule */
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        .schedule-table th, .schedule-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .schedule-table th {
            background-color: #f1f5f9;
            font-weight: 800;
            text-align: center;
            font-size: 9.5pt;
            text-transform: uppercase;
        }

        .day-header {
            background-color: #e2e8f0 !important;
            font-weight: 800;
            font-size: 10.5pt;
            padding: 6px 10px;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .sig-box {
            width: 250px;
            text-align: center;
            font-size: 10.5pt;
            line-height: 1.3;
        }

        .sig-space {
            height: 60px;
        }

        .sig-name {
            font-weight: 800;
            text-decoration: underline;
        }

        /* No Print Toolbar */
        .no-print-toolbar {
            max-width: 800px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .paper {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print-toolbar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Toolbar Atas (Tidak ikut tercetak) -->
    <div class="no-print-toolbar">
        <a href="{{ route('guru.jadwal', ['tab' => $tab]) }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Jadwal
        </a>
        <div style="font-weight: 700; color: #1e293b; font-size: 14px;">
            Pratinjau Cetak Jadwal
        </div>
        <button type="button" onclick="window.print()" class="btn-print">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- Lembar Kertas Dokumen Resmi -->
    <div class="paper">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ asset('img/smk_logo.png') }}" alt="Logo SMKN 1 Boyolangu" class="kop-logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg';">
            <div class="kop-header">
                <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
                <h2>DINAS PENDIDIKAN</h2>
                <h1>SMK NEGERI 1 BOYOLANGU</h1>
                <p>Jl. Ki Mangunsarkoro VI/3 Telp. (0355) 321746 Fax. (0355) 327774 Boyolangu, Tulungagung 66233</p>
                <p>Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.co.id</p>
            </div>
        </div>
        <hr class="kop-line">

        <!-- Judul Dokumen -->
        <div class="doc-title">
            <h3>{{ $titleDoc }}</h3>
            <p>TAHUN PELAJARAN 2026/2027 — SEMESTER GANJIL</p>
        </div>

        <!-- Info Metadata -->
        <table class="meta-table">
            <tr>
                @if($tab === 'perwalian' && $kelasWali)
                    <td class="meta-label">Kelas Perwalian</td>
                    <td>: <strong>{{ $kelasWali->nama_kelas }}</strong> (Jurusan: {{ $kelasWali->jurusan->nama_jurusan ?? '-' }})</td>
                    <td class="meta-label">Wali Kelas</td>
                    <td>: {{ $guru->nama_guru ?? $user->name }} (NIP: {{ $user->nip ?? '-' }})</td>
                @else
                    <td class="meta-label">Nama Guru</td>
                    <td>: <strong>{{ $guru->nama_guru ?? $user->name }}</strong></td>
                    <td class="meta-label">Total Beban Mengajar</td>
                    <td>: <strong>{{ $totalJp }} Jam Pelajaran (JP) / Minggu</strong></td>
                @endif
            </tr>
            <tr>
                <td class="meta-label">NIP / Identitas</td>
                <td>: {{ $user->nip ?? ($guru->nip ?? '-') }}</td>
                <td class="meta-label">Status Alokasi</td>
                <td>: KBM Efektif Semester Ganjil 2026/2027</td>
            </tr>
        </table>

        <!-- Tabel Jadwal -->
        <table class="schedule-table">
            <thead>
                <tr>
                    <th style="width: 35px;">No</th>
                    <th style="width: 120px;">Jam & Waktu (WIB)</th>
                    <th style="width: 45px;">Alokasi</th>
                    @if($tab !== 'perwalian')
                        <th style="width: 90px;">Kelas</th>
                    @endif
                    <th>Mata Pelajaran</th>
                    @if($tab === 'perwalian')
                        <th>Guru Pengampu</th>
                    @endif
                    <th style="width: 100px;">Ruangan</th>
                </tr>
            </thead>
            <tbody>
                @php $noUrut = 1; @endphp
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayName)
                    @php
                        $dayJadwals = $jadwalsByDay[$dayName] ?? collect();
                    @endphp
                    <tr>
                        <td colspan="6" class="day-header">
                            <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> <strong>HARI {{ strtoupper($dayName) }}</strong>
                            <span style="font-size: 9pt; font-weight: normal; margin-left: 8px;">({{ $dayJadwals->count() }} sesi KBM • {{ $dayJadwals->sum('jumlah_jp') }} JP)</span>
                        </td>
                    </tr>
                    @forelse($dayJadwals as $j)
                        <tr>
                            <td style="text-align: center;">{{ $noUrut++ }}</td>
                            <td>
                                <strong>{{ $j->jam_range }}</strong>
                                <div style="font-size: 8.5pt; color: #334155;">{{ $j->waktu_range }}</div>
                            </td>
                            <td style="text-align: center; font-weight: 700;">
                                {{ $j->jumlah_jp }} JP
                            </td>
                            @if($tab !== 'perwalian')
                                <td style="text-align: center; font-weight: 700;">
                                    {{ $j->kelas->nama_kelas ?? '-' }}
                                </td>
                            @endif
                            <td>
                                <strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                            </td>
                            @if($tab === 'perwalian')
                                <td>
                                    {{ $j->guru->nama_guru ?? '-' }}
                                </td>
                            @endif
                            <td style="text-align: center;">
                                {{ $j->ruangan->nama_ruangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; font-style: italic; color: #64748b; padding: 8px;">
                                Tidak ada jadwal mengajar pada hari {{ $dayName }}.
                            </td>
                        </tr>
                    @endforelse
                @endforeach
            </tbody>
        </table>

        <!-- Tanda Tangan Resmi -->
        <div class="signature-section">
            <div class="sig-box">
                <div>Mengetahui,</div>
                <div>Kepala SMK Negeri 1 Boyolangu</div>
                <div class="sig-space"></div>
                <div class="sig-name">TRISNO WIBOWO, S.Pd., M.M.</div>
                <div>Pembina Utama Muda / IVc</div>
                <div>NIP. 19810115 200312 1 003</div>
            </div>
            <div class="sig-box">
                <div>Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
                <div>{{ ($tab === 'perwalian' && $kelasWali) ? 'Wali Kelas ' . $kelasWali->nama_kelas : 'Guru Mata Pelajaran' }}</div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $guru->nama_guru ?? $user->name }}</div>
                <div>NIP. {{ $user->nip ?? ($guru->nip ?? '-') }}</div>
            </div>
        </div>
    </div>

</body>
</html>
