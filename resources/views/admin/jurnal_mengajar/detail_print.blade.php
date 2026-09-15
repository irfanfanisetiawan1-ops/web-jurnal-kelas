<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurnal Mengajar — {{ $jurnal->jadwal->guru->nama_guru ?? 'Guru' }} ({{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }})</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #0f172a;
            padding: 30px;
            font-size: 13px;
        }

        .header-print {
            border-bottom: 3px double #0f172a;
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-brand h1 {
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .header-brand p {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-status {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
        }
        .badge-hadir { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-absen { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 25px;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 18px;
        }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }

        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 10px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
        }

        .content-box {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .table-custom th {
            background: #1e293b;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
        }

        .table-custom td {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .foto-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .foto-container img {
            max-width: 450px;
            max-height: 300px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
        }

        .sig-box {
            text-align: center;
            width: 220px;
        }

        .sig-space {
            height: 70px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:700; cursor:pointer;">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="background:#64748b; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:700; cursor:pointer; margin-left:8px;">
            Tutup
        </button>
    </div>

    <div class="header-print">
        <div class="header-brand" style="display: flex; align-items: center; gap: 14px;">
            <img src="{{ asset('images/logo_jurnal_baru.png') }}" alt="EDU JOURNAL Logo" style="width: 95px; height: 95px; object-fit: contain;">
            <div>
                <h1>Jurnal Mengajar EDU JOURNAL</h1>
                <p>Bukti Pelaksanaan Kegiatan Pembelajaran dan Presensi Kelas</p>
            </div>
        </div>
        <div>
            @if($jurnal->status_kehadiran_guru === 'Hadir')
                <span class="badge-status badge-hadir">GURU HADIR</span>
            @else
                <span class="badge-status badge-absen">{{ strtoupper($jurnal->status_kehadiran_guru) }}</span>
            @endif
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-label">Tanggal Pembelajaran</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y') }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Guru Pengajar</div>
            <div class="info-value">{{ $jurnal->jadwal->guru->nama_guru ?? '-' }} (NIP: {{ $jurnal->jadwal->guru->nip ?? '-' }})</div>
        </div>
        <div class="info-card">
            <div class="info-label">Mata Pelajaran</div>
            <div class="info-value">{{ $jurnal->jadwal->mapel->nama_mapel ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Kelas & Ruangan</div>
            <div class="info-value">{{ $jurnal->jadwal->kelas->nama_kelas ?? '-' }} — Ruang {{ $jurnal->jadwal->ruangan->nama_ruangan ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Jam Ke- / Alokasi Waktu</div>
            <div class="info-value">Jam Ke-{{ $jurnal->jadwal->jam_range ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Waktu Pencatatan</div>
            <div class="info-value">{{ $jurnal->dicatat_pada ? \Carbon\Carbon::parse($jurnal->dicatat_pada)->format('d/m/Y H:i') . ' WIB' : '-' }}</div>
        </div>
    </div>

    <div class="section-title">Materi Pembelajaran</div>
    <div class="content-box">
        {{ $jurnal->materi ?? 'Tidak ada materi yang dicatat.' }}
    </div>

    <div class="section-title">Catatan Pembelajaran / Kejadian Kelas</div>
    <div class="content-box">
        {{ $jurnal->catatan ?? 'Tidak ada catatan tambahan.' }}
    </div>

    <div class="section-title">Daftar Ketidakhadiran Siswa</div>
    <table class="table-custom">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Siswa</th>
                <th>NISN / NIS</th>
                <th style="width: 120px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if($jurnal->detailKetidakhadiran && $jurnal->detailKetidakhadiran->count() > 0)
                @foreach($jurnal->detailKetidakhadiran as $idx => $d)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td><strong>{{ $d->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                        <td>{{ $d->siswa->nisn ?? $d->siswa->nis ?? '-' }}</td>
                        <td>
                            <strong style="color: {{ $d->keterangan == 'Sakit' ? '#d97706' : ($d->keterangan == 'Izin' ? '#2563eb' : '#dc2626') }};">
                                {{ strtoupper($d->keterangan) }}
                            </strong>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center; color: #166534; font-weight: 700; padding: 15px;">
                        Semua siswa hadir (Nihil ketidakhadiran).
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($jurnal->dokumentasi_url)
        <div class="section-title">Foto Bukti Dokumentasi</div>
        <div class="foto-container">
            <img src="{{ $jurnal->dokumentasi_url }}" alt="Foto Dokumentasi">
        </div>
    @endif

    <div class="signature-section">
        <div class="sig-box">
            <div>Mengetahui,</div>
            <div>Kepala Sekolah / Kurikulum</div>
            <div class="sig-space"></div>
            <div><strong>_________________________</strong></div>
            <div>NIP. ........................................</div>
        </div>
        <div class="sig-box">
            <div>Guru Pengajar,</div>
            <div class="sig-space"></div>
            <div><strong>{{ $jurnal->jadwal->guru->nama_guru ?? 'Guru Pengajar' }}</strong></div>
            <div>NIP. {{ $jurnal->jadwal->guru->nip ?? '........................................' }}</div>
        </div>
    </div>

</body>
</html>
