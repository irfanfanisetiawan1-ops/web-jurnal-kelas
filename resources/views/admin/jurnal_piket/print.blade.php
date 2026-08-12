<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Jurnal Guru Piket — EduJournal</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; margin: 30px; line-height: 1.4; }
        
        .no-print { margin-bottom: 20px; text-align: right; }
        .btn-print { padding: 8px 18px; background: #059669; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-family: Arial, sans-serif; font-size: 13px; }
        .btn-close { padding: 8px 18px; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-left: 8px; font-family: Arial, sans-serif; font-size: 13px; }

        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .header h3 { margin: 4px 0 0 0; font-size: 14pt; font-weight: bold; }
        .header p { margin: 4px 0 0 0; font-size: 10pt; font-style: italic; }

        .meta-info { margin-bottom: 16px; font-size: 11pt; }
        .meta-info table { width: 100%; border: none; margin: 0; }
        .meta-info td { padding: 2px 0; border: none; }

        table.content-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11pt; }
        table.content-table th, table.content-table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; }
        table.content-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; font-size: 10pt; text-transform: uppercase; }

        .badge-suasana { font-weight: bold; text-align: center; display: block; }
        
        .footer-signatures { margin-top: 40px; width: 100%; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .sig-box { text-align: center; width: 230px; font-size: 11pt; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
        <button onclick="window.close()" class="btn-close">
            Tutup
        </button>
    </div>

    <div class="header">
        <h2>PEMERINTAH KABUPATEN / PROVINSI</h2>
        <h3>DINAS PENDIDIKAN DAN KEBUDAYAAN — SMKN 1 ESEMKITA</h3>
        <p>Jl. Pendidikan No. 45, Telp. (021) 555-0123, Email: info@esemkita.sch.id</p>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <h4 style="margin:0; font-size: 13pt; text-decoration: underline; font-weight: bold;">LAPORAN REKAPITULASI JURNAL GURU PIKET</h4>
        <div style="font-size: 11pt; margin-top: 4px;">
            @if(isset($tanggal_mulai) && isset($tanggal_selesai) && $tanggal_mulai && $tanggal_selesai)
                Periode: <strong>{{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}</strong>
            @elseif(isset($tanggal) && $tanggal)
                Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong>
            @else
                Periode: <strong>Semua Tanggal</strong>
            @endif
        </div>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 14%;">TANGGAL</th>
                <th style="width: 13%;">JAM PIKET</th>
                <th style="width: 25%;">PETUGAS GURU PIKET</th>
                <th style="width: 14%;">SUASANA</th>
                <th>CATATAN KEJADIAN & PENANGANAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnalsPiket as $index => $jp)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}</td>
                    <td style="text-align: center;">{{ $jp->jam_piket }}</td>
                    <td>
                        <strong>{{ $jp->nama_petugas_piket }}</strong>
                        @if($jp->guru && $jp->guru->nip)
                            <br><small style="color:#555;">NIP: {{ $jp->guru->nip }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <strong>{{ $jp->status_suasana }}</strong>
                    </td>
                    <td>{{ $jp->catatan_kejadian ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada catatan jurnal piket pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-signatures">
        <div class="sig-box">
            <p>Mengetahui,<br>Kepala Sekolah / Penanggung Jawab</p>
            <br><br><br><br>
            <p><strong>________________________</strong><br>NIP. -</p>
        </div>

        <div class="sig-box">
            <p>Kota, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Koordinator Piket / Admin TU</p>
            <br><br><br><br>
            <p><strong>{{ Auth::user()->name ?? 'Admin Tata Usaha' }}</strong><br>NIP. {{ Auth::user()->nip ?? '-' }}</p>
        </div>
    </div>

</body>
</html>
