<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Surat Izin Siswa — EDU JOURNAL</title>
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
        .btn-portal { background: #2563eb; color: white; }
        .btn-portal:hover { background: #1d4ed8; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; }
        .badge-sakit { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-izin { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-dispen { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
        .badge-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .photo-box { text-align: center; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px; margin-top: 8px; }
        .photo-box img { max-width: 100%; max-height: 340px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.2s ease; }
        .photo-box img:hover { transform: scale(1.02); }

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
        $namaSiswa = $surat->siswa->nama_siswa ?? 'Siswa';
        $nisSiswa  = $surat->siswa->nis ?? '-';
        $namaKelas = $surat->kelas->nama_kelas ?? ($surat->siswa->kelas->nama_kelas ?? '-');
        $waliKelas = $surat->kelas->waliKelas ?? ($surat->siswa->kelas->waliKelas ?? null);
        $waliNama  = $waliKelas->nama_guru ?? '-';
        $waliNip   = $waliKelas->nip ?? '-';

        $tglMulaiFmt   = \Carbon\Carbon::parse($surat->tanggal)->format('d/m/Y');
        $tglSelesaiFmt = $surat->tanggal_selesai ? \Carbon\Carbon::parse($surat->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
        $rentangFmt    = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
        $durasiText    = ($surat->durasi_hari > 0 ? $surat->durasi_hari : 1) . ' Hari';

        $badgeClass = match($surat->kategori) {
            'Sakit' => 'badge-sakit',
            'Izin'  => 'badge-izin',
            default => 'badge-dispen',
        };

        $petugasNama = $surat->petugasPiket->name ?? 'Petugas Guru Piket';
        $petugasNip  = $surat->petugasPiket->nip ?? ($surat->petugasPiket->username ?? '-');
    @endphp

    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-envelope-open-text fa-2x"></i>
            <h2>Pemberitahuan Surat Izin Siswa</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #b6c5e3;">EDU JOURNAL — Portal Presensi Digital</p>
        </div>
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
                <span class="badge {{ $badgeClass }}">
                    @if($surat->kategori == 'Sakit')
                        <i class="fa-solid fa-notes-medical"></i> Sakit
                    @elseif($surat->kategori == 'Izin')
                        <i class="fa-solid fa-envelope"></i> Izin
                    @else
                        <i class="fa-solid fa-award"></i> Dispen Luar Sekolah
                    @endif
                </span>
                <span class="badge badge-success">
                    <i class="fa-solid fa-circle-check"></i> Status: {{ $surat->status ?? 'Terverifikasi' }}
                </span>
            </div>

            <div class="info-group">
                <div class="info-label">Identitas Siswa</div>
                <div class="info-value">{{ $namaSiswa }}</div>
                <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    NIS: {{ $nisSiswa }} &bull; Kelas: <strong>{{ $namaKelas }}</strong>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Wali Kelas</div>
                <div class="info-value" style="font-size: 14px;">{{ $waliNama }}</div>
                @if($waliNip && $waliNip !== '-')
                    <div style="font-size: 12px; color: #64748b; font-weight: 600;">NIP: {{ $waliNip }}</div>
                @endif
            </div>

            <div class="info-group">
                <div class="info-label">Tanggal &amp; Durasi Izin</div>
                <div class="info-value">
                    <i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i> {{ $rentangFmt }}
                    <span style="font-size: 13px; color: #059669; font-weight: 800; margin-left: 6px;">({{ $durasiText }})</span>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Keterangan / Alasan</div>
                <div class="info-value" style="font-size: 14px; line-height: 1.4; color: #334155;">
                    {{ $surat->keterangan ?: '-' }}
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Petugas Guru Piket Penginput</div>
                <div class="info-value" style="font-size: 14px;">{{ $petugasNama }}</div>
                <div style="font-size: 12px; color: #64748b; font-weight: 600;">NIP: {{ $petugasNip }}</div>
            </div>

            @if($surat->foto_url)
                <div class="info-group">
                    <div class="info-label">Dokumen / Bukti Foto Surat</div>
                    <div class="photo-box">
                        <a href="{{ $surat->foto_url }}" target="_blank" title="Klik untuk membuka ukuran penuh">
                            <img src="{{ $surat->foto_url }}" alt="Bukti Surat Izin {{ $namaSiswa }}">
                        </a>
                        <div style="font-size: 11px; color: #64748b; margin-top: 6px;">
                            <i class="fa-solid fa-magnifying-glass-plus"></i> Klik gambar untuk melihat ukuran penuh
                        </div>
                    </div>
                </div>
            @endif

            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; margin-top: 18px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-circle-info" style="font-size: 20px; color: #2563eb; flex-shrink: 0;"></i>
                <div style="font-size: 12px; color: #1e40af; font-weight: 600; line-height: 1.4;">
                    Data presensi kelas telah otomatis disesuaikan secara real-time di Jurnal Mengajar. Wali Kelas dapat memantau rekapan kehadiran secara berkala.
                </div>
            </div>

            <div class="no-print" style="margin-top: 20px;">
                <button type="button" onclick="window.print()" class="btn" style="width: 100%; background: #384972; color: #ffffff;">
                    <i class="fa-solid fa-print"></i> Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</body>
</html>
