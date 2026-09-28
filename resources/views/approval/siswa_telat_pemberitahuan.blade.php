<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Siswa Terlambat — EDU JOURNAL</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #cbd3e0; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); width: 100%; max-width: 580px; overflow: hidden; border: 1px solid #cbd5e1; }
        .card-header { background: #384972; color: #ffffff; padding: 24px; text-align: center; }
        .card-header h2 { margin: 8px 0 0 0; font-size: 20px; font-weight: 800; }
        .card-body { padding: 24px; }
        .info-group { margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; }
        .info-label { font-size: 11.5px; color: #475569; font-weight: 800; text-transform: uppercase; letter-spacing: 0.03em; }
        .info-value { font-size: 15px; color: #1e293b; font-weight: 700; margin-top: 4px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 10px; font-weight: 800; border: none; cursor: pointer; text-decoration: none; font-size: 14px; transition: all 0.2s ease; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; }
        .badge-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .badge-info { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        @media print {
            body { background: #ffffff !important; padding: 0 !important; }
            .card { box-shadow: none !important; border: 1px solid #000 !important; max-width: 100% !important; margin: 0 auto !important; }
            .btn, .no-print { display: none !important; }
            .card-header { background: #1e293b !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    @php
        $siswaObj  = $telat->siswa;
        $namaSiswa = $siswaObj->nama_siswa ?? 'Siswa';
        $nisSiswa  = $siswaObj->nis ?? '-';
        $nisnSiswa = $siswaObj->nisn ?? '-';
        $namaKelas = $telat->kelas->nama_kelas ?? ($siswaObj->kelas->nama_kelas ?? '-');
        $jkSiswa   = $siswaObj ? $siswaObj->jenis_kelamin_teks : '-';

        $guruObj   = $telat->guruMengajar;
        $namaGuru  = $guruObj->nama_guru ?? 'Guru Mengajar';
        $nipGuru   = $guruObj->nip ?? '-';
        $mapelNama = $guruObj->mapel->nama_mapel ?? '-';

        $tglFmt    = \Carbon\Carbon::parse($telat->tanggal)->translatedFormat('d F Y');
        $jamTeks   = $telat->jam_terlambat . ' WIB';

        $petugasNama = $telat->guruPiket->name ?? 'Petugas Guru Piket';
        $petugasNip  = $telat->guruPiket->nip ?? ($telat->guruPiket->username ?? '-');
    @endphp

    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
            <h2>Pemberitahuan Siswa Terlambat</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #b6c5e3;">EDU JOURNAL — Portal Presensi Digital</p>
        </div>
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
                <span class="badge badge-warning">
                    <i class="fa-solid fa-clock"></i> Terlambat: {{ $jamTeks }}
                </span>
                <span class="badge badge-success">
                    <i class="fa-solid fa-circle-check"></i> Status: Dicatat Piket
                </span>
            </div>

            <div class="info-group">
                <div class="info-label">Identitas Siswa</div>
                <div class="info-value">{{ $namaSiswa }}</div>
                <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    NIS: {{ $nisSiswa }} &bull; NISN: {{ $nisnSiswa }} &bull; Kelas: <strong>{{ $namaKelas }}</strong> &bull; ({{ $jkSiswa }})
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Guru Mengajar di Kelas Saat Ini (Target)</div>
                <div class="info-value" style="font-size: 14px;">{{ $namaGuru }}</div>
                <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                    Mapel: <strong>{{ $mapelNama }}</strong>
                    @if($nipGuru && $nipGuru !== '-')
                        &bull; NIP: {{ $nipGuru }}
                    @endif
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Tanggal &amp; Jam Kedatangan</div>
                <div class="info-value">
                    <i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i> {{ $tglFmt }}
                    <span style="font-size: 13px; color: #b45309; font-weight: 800; margin-left: 6px;">({{ $jamTeks }})</span>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Alasan Keterlambatan</div>
                <div class="info-value" style="font-size: 14px; line-height: 1.4; color: #334155;">
                    {{ $telat->alasan ?: '-' }}
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Tindakan / Hukuman Piket</div>
                <div class="info-value" style="font-size: 14px; line-height: 1.4; color: #991b1b; background: #fff1f2; padding: 6px 10px; border-radius: 8px; border: 1px solid #fecdd3; margin-top: 6px;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 4px;"></i>
                    {{ $telat->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Guru Piket' }}
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Petugas Guru Piket Penginput</div>
                <div class="info-value" style="font-size: 14px;">{{ $petugasNama }}</div>
                <div style="font-size: 12px; color: #64748b; font-weight: 600;">NIP: {{ $petugasNip }}</div>
            </div>

            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; margin-top: 18px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-circle-info" style="font-size: 20px; color: #2563eb; flex-shrink: 0;"></i>
                <div style="font-size: 12px; color: #1e40af; font-weight: 600; line-height: 1.4;">
                    Pemberitahuan telah tercatat otomatis di sistem web dan Halaman Pengumuman Guru Mengajar. Bapak/Ibu Guru Mengajar dapat menyesuaikan status kehadiran siswa pada Jurnal Mengajar kelas.
                </div>
            </div>

            <div class="no-print" style="margin-top: 20px;">
                <button type="button" onclick="window.print()" class="btn" style="width: 100%; background: #384972; color: #ffffff;">
                    <i class="fa-solid fa-print"></i> Cetak Bukti Keterlambatan
                </button>
            </div>
        </div>
    </div>
</body>
</html>
