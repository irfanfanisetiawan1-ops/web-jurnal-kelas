<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Dispensasi Siswa — {{ $dispen->kode_dispen }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 20mm 15mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            background: #f1f5f9;
            margin: 0;
            padding: 24px;
            font-size: 11.5pt;
            line-height: 1.5;
        }

        .paper {
            max-width: 720px;
            margin: 0 auto;
            background: #ffffff;
            padding: 36px 44px;
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
            width: 82px;
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
            font-size: 17pt;
            font-weight: 900;
            margin: 2px 0;
            letter-spacing: 1px;
        }

        .kop-header h3 {
            font-size: 11.5pt;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .kop-header p {
            font-size: 9.5pt;
            margin: 3px 0 0 0;
            color: #1e293b;
        }

        .kop-header .telp-web {
            font-size: 8.5pt;
            color: #334155;
            margin-top: 2px;
        }

        .kop-header .npsn {
            font-size: 9.5pt;
            font-weight: 700;
            margin-top: 2px;
        }

        /* Double border separator */
        .kop-divider {
            border-top: 3px solid #000000;
            border-bottom: 1px solid #000000;
            height: 3px;
            margin: 10px 0 20px 0;
        }

        .title-block {
            text-align: center;
            margin-bottom: 22px;
        }

        .title-block h4 {
            font-size: 13.5pt;
            font-weight: 900;
            text-decoration: underline;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .title-block .nomor {
            font-size: 11pt;
            font-weight: 500;
            margin: 0;
        }

        .recipient-block {
            font-size: 11.5pt;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .content-text {
            text-align: justify;
            margin-bottom: 12px;
            font-size: 11.5pt;
            line-height: 1.55;
        }

        .data-table {
            width: 100%;
            margin: 6px 0 14px 0;
            border-collapse: collapse;
            font-size: 11.5pt;
        }

        .data-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .data-table td.label-col {
            width: 170px;
        }

        .data-table td.colon {
            width: 15px;
            text-align: center;
        }

        .data-table td.val-col {
            font-weight: 400;
        }

        .data-table td.val-col-bold {
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Signatures Section */
        .date-right {
            text-align: right;
            margin-bottom: 8px;
            font-size: 11.5pt;
        }

        .signatures-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 10px;
            text-align: center;
            page-break-inside: avoid;
        }

        .sig-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .sig-role {
            font-size: 11.5pt;
            margin-bottom: 2px;
        }

        .sig-role-sub {
            font-size: 11.5pt;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .sig-canvas-wrap {
            height: 95px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
            width: 100%;
        }

        .sig-canvas-wrap img {
            max-height: 90px;
            max-width: 180px;
            object-fit: contain;
        }

        .sig-name {
            font-size: 11.5pt;
            font-weight: 800;
            text-decoration: underline;
            margin-top: 4px;
        }

        .sig-id {
            font-size: 11pt;
            color: #1e293b;
        }

        /* Floating Action Bar for Web View */
        .no-print-bar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 999;
            background: rgba(15, 23, 42, 0.9);
            padding: 10px 16px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .no-print-bar button {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .no-print-bar button:hover {
            background: #1d4ed8;
        }

        .no-print-bar a {
            background: #475569;
            color: #ffffff;
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .no-print-bar a:hover {
            background: #334155;
        }

        @media print {
            .no-print-bar { display: none !important; }
            body { padding: 0; background: #ffffff; }
            .paper { box-shadow: none; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

<div class="paper">
    <!-- Kop Surat Resmi SMKN 1 Boyolangu -->
    <div class="kop-surat">
        <img src="{{ asset('images/logo_sekolah.jpeg') }}" class="kop-logo" onerror="this.src='{{ asset('logo_sekolah.jpeg') }}'">
        <div class="kop-header">
            <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
            <h1>SMK NEGERI 1 BOYOLANGU</h1>
            <h3>SEKOLAH KEJURUAN NEGERI UNGGULAN</h3>
            <p>Jl. Ki Mangunsarkoro VI/3, Beji, Kecamatan Boyolangu<br>Kabupaten Tulungagung, Jawa Timur 66233</p>
            <div class="telp-web">Telp. (0355) 323021 / 323024 | Website: https://smkn1boyolangu.sch.id/</div>
            <div class="npsn">NPSN: 20537286</div>
        </div>
        <div style="width: 82px;"></div><!-- Balance Spacer -->
    </div>

    <div class="kop-divider"></div>

    <!-- Judul Surat -->
    <div class="title-block">
        <h4>SURAT DISPENSASI SISWA</h4>
        <div class="nomor">Nomor: 421.3/{{ $dispen->kode_dispen }}/SMKN1.BYL/{{ \Carbon\Carbon::parse($dispen->tanggal)->format('Y') }}</div>
    </div>

    <!-- Tujuan / Kepada Yth -->
    <div class="recipient-block">
        Kepada Yth.<br>
        Bapak/Ibu Guru Piket<br>
        SMK Negeri 1 Boyolangu<br>
        di tempat
    </div>

    <div class="content-text">
        Dengan hormat,<br>
        Berdasarkan permohonan izin dari orang tua/wali siswa dan sehubungan dengan keperluan kegiatan yang tidak dapat ditinggalkan, maka dengan ini kami mohon agar siswa berikut diberikan dispensasi (izin tidak mengikuti kegiatan pembelajaran) pada waktu yang telah ditentukan.
    </div>

    <div class="content-text" style="margin-bottom: 4px;">
        Adapun data siswa yang mengajukan dispensasi adalah sebagai berikut:
    </div>

    <!-- Data Siswa & Foto Siswa Live -->
    <div style="display: flex; gap: 18px; align-items: flex-start;">
        <table class="data-table" style="flex: 1; padding-left: 10px;">
            <tr>
                <td class="label-col">Nama</td>
                <td class="colon">:</td>
                <td class="val-col-bold">{{ $dispen->siswa->nama_siswa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">NISN</td>
                <td class="colon">:</td>
                <td class="val-col">{{ $dispen->siswa->nisn ?? ($dispen->siswa->nis ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label-col">Kelas</td>
                <td class="colon">:</td>
                <td class="val-col">{{ $dispen->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Program Keahlian</td>
                <td class="colon">:</td>
                <td class="val-col">{{ $dispen->kelas->jurusan->nama_jurusan ?? ($dispen->siswa->kelas->jurusan->nama_jurusan ?? ($dispen->kelas->nama_jurusan ?? 'Manajemen Perkantoran dan Layanan Bisnis')) }}</td>
            </tr>
        </table>

        @if($dispen->foto_siswa_live)
        <div style="text-align: center; border: 1.5px solid #000000; padding: 4px; border-radius: 4px; width: 85px; flex-shrink: 0; background: #ffffff;">
            <img src="{{ asset($dispen->foto_siswa_live) }}" alt="Foto Siswa Live" style="width: 77px; height: 98px; object-fit: cover; border-radius: 2px; display: block;">
            <span style="font-size: 7.5pt; font-family: sans-serif; font-weight: 800; color: #000000; margin-top: 2px; display: block;">LIVE FOTO</span>
        </div>
        @endif
    </div>

    <div class="content-text" style="margin-bottom: 4px;">
        Untuk diberikan dispensasi agar tidak mengikuti proses kegiatan belajar mengajar di sekolah selama kegiatan berlangsung, dengan keterangan sebagai berikut:
    </div>

    <!-- Keterangan Dispensasi -->
    <table class="data-table" style="padding-left: 10px;">
        <tr>
            <td class="label-col">Hari / Tanggal</td>
            <td class="colon">:</td>
            <td class="val-col">{{ $hariIndo }}, {{ $tanggalIndo }}</td>
        </tr>
        <tr>
            <td class="label-col">Pukul</td>
            <td class="colon">:</td>
            <td class="val-col">{{ $dispen->jam_keluar ?? '08.00' }} WIB s.d. {{ $dispen->jam_kembali ?? '11.30' }} WIB</td>
        </tr>
        <tr>
            <td class="label-col">Keperluan</td>
            <td class="colon">:</td>
            <td class="val-col">{{ $dispen->alasan }}</td>
        </tr>
        <tr>
            <td class="label-col">Tempat</td>
            <td class="colon">:</td>
            <td class="val-col">{{ $dispen->tempat ?? 'Aula Dinas Pendidikan Kabupaten Tulungagung' }}</td>
        </tr>
    </table>

    <div class="content-text" style="margin-bottom: 20px;">
        Demikian surat dispensasi ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
    </div>

    <!-- Tanggal & Tanda Tangan -->
    <div class="date-right">
        Boyolangu, {{ $tanggalIndo }}
    </div>

    <div class="signatures-grid">
        <!-- 1. Guru Piket -->
        <div class="sig-col">
            <div class="sig-role">Hormat kami,</div>
            <div class="sig-role-sub">Guru Piket</div>
            <div class="sig-canvas-wrap">
                @if($dispen->ttd_guru_piket && file_exists(public_path($dispen->ttd_guru_piket)))
                    <img src="{{ asset($dispen->ttd_guru_piket) }}" alt="TTD Guru Piket">
                @else
                    <div style="font-family: 'Brush Script MT', cursive; font-size: 24pt; color: #1e293b;">
                        {{ $dispen->nama_guru_piket ?? 'Guru Piket' }}
                    </div>
                @endif
            </div>
            <div>
                <div class="sig-name">{{ $dispen->nama_guru_piket ?? 'Guru Piket' }}</div>
                <div class="sig-id">NIP. {{ $dispen->nip_guru_piket ?: '-' }}</div>
            </div>
        </div>

        <!-- 2. Siswa -->
        <div class="sig-col">
            <div class="sig-role">Yang mengajukan izin,</div>
            <div class="sig-role-sub">Siswa</div>
            <div class="sig-canvas-wrap">
                @if($dispen->ttd_siswa && file_exists(public_path($dispen->ttd_siswa)))
                    <img src="{{ asset($dispen->ttd_siswa) }}" alt="TTD Siswa">
                @else
                    <div style="font-family: 'Brush Script MT', cursive; font-size: 24pt; color: #1e293b;">
                        {{ $dispen->siswa->nama_siswa ?? 'Siswa' }}
                    </div>
                @endif
            </div>
            <div>
                <div class="sig-name">{{ $dispen->siswa->nama_siswa ?? 'Siswa' }}</div>
                <div class="sig-id">NISN. {{ $dispen->siswa->nisn ?? ($dispen->siswa->nis ?? '-') }}</div>
            </div>
        </div>
    </div>

    @if($dispen->status_waka === 'approved')
        <div style="margin-top: 24px; padding: 10px 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 10pt; color: #166534; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fa-solid fa-circle-check" style="color: #16a34a; margin-right: 6px;"></i>
                <strong>Telah Diverifikasi & Disetujui Waka Kesiswaan:</strong> {{ $dispen->nama_waka ?? 'Waka Kesiswaan' }}
                @if($dispen->nip_waka) (NIP: {{ $dispen->nip_waka }}) @endif
            </div>
            <div style="font-size: 9pt; color: #15803d;">
                {{ $dispen->waktu_approval_waka ? \Carbon\Carbon::parse($dispen->waktu_approval_waka)->translatedFormat('d M Y H:i') : 'Resmi Disetujui' }}
            </div>
        </div>
    @endif
</div>

<!-- Floating Action Bar for Web View -->
<div class="no-print-bar">
    <button type="button" onclick="window.print()">
        <i class="fa-solid fa-print"></i> Cetak Dokumen
    </button>
    <a href="javascript:window.close()">
        <i class="fa-solid fa-xmark"></i> Tutup
    </a>
</div>

</body>
</html>
