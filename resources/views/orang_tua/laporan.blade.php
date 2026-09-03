@extends('layouts.orang_tua')

@section('title', 'Laporan Kehadiran — Jurnal SMEA')

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">

    <!-- Top Page Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; <a href="{{ route('orang-tua.dashboard') }}" style="color: #475569; text-decoration: none;">Dashboard</a> &gt; <span style="color: #1e293b;">Laporan</span>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa-solid fa-chart-column" style="color: #384972; margin-right: 8px;"></i> Laporan Kehadiran Akademik & Log Datang-Pulang
            </h1>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 13.5px;">Pemantauan rekapitulasi ringkasan presensi bulanan dan rincian jam datang &amp; pulang anak.</p>
        </div>

        <button onclick="window.print()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 10px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>

    @if($siswa)
    <!-- Ringkasan Kehadiran Bulan Ini Card -->
    <div style="background: #ffffff; border-radius: 18px; padding: 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 15px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
                RINGKASAN KEHADIRAN BULAN {{ $rekapBulan['nama_bulan'] ?? 'AGUSTUS' }}
            </div>
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 6px 14px; border-radius: 10px;">
                Total Pertemuan: {{ $rekapBulan['total'] ?? 21 }} Jurnal
            </div>
        </div>

        <!-- Bar Chart Visualization -->
        <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 160px; padding: 0 20px; border-bottom: 2px solid #e2e8f0; position: relative;">
            <!-- Hadir Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 11.5px; font-weight: 800; color: #384972;">{{ $rekapBulan['hadir'] ?? 20 }}</div>
                <div style="width: 100%; max-width: 60px; height: {{ max(15, $rekapBulan['persen_hadir'] ?? 95) }}%; background: #384972; border-radius: 8px 8px 0 0; transition: height 0.5s ease;"></div>
            </div>
            <!-- Sakit Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 11.5px; font-weight: 800; color: #d97706;">{{ $rekapBulan['sakit'] ?? 1 }}</div>
                <div style="width: 100%; max-width: 60px; height: {{ max(8, $rekapBulan['persen_sakit'] ?? 10) }}%; background: #f59e0b; border-radius: 8px 8px 0 0; transition: height 0.5s ease;"></div>
            </div>
            <!-- Izin Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 11.5px; font-weight: 800; color: #166534;">{{ $rekapBulan['izin'] ?? 0 }}</div>
                <div style="width: 100%; max-width: 60px; height: {{ max(8, $rekapBulan['persen_izin'] ?? 5) }}%; background: #86efac; border-radius: 8px 8px 0 0; transition: height 0.5s ease;"></div>
            </div>
            <!-- Alfa Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 11.5px; font-weight: 800; color: #dc2626;">{{ $rekapBulan['alfa'] ?? 0 }}</div>
                <div style="width: 100%; max-width: 60px; height: {{ max(8, $rekapBulan['persen_alfa'] ?? 5) }}%; background: #fca5a5; border-radius: 8px 8px 0 0; transition: height 0.5s ease;"></div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-around; margin-top: 12px; text-align: center;">
            <div style="width: 80px; font-size: 12px; font-weight: 800; color: #384972;">HADIR</div>
            <div style="width: 80px; font-size: 12px; font-weight: 800; color: #d97706;">SAKIT</div>
            <div style="width: 80px; font-size: 12px; font-weight: 800; color: #166534;">IZIN</div>
            <div style="width: 80px; font-size: 12px; font-weight: 800; color: #dc2626;">ALFA</div>
        </div>
    </div>

    <!-- Section Log Datang & Pulang Siswa -->
    <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-clock-rotate-left" style="color: #4a5e8c;"></i> Riwayat Presensi Datang - Pulang Sekolah
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 2px solid #cbd5e1;">
                        <th style="padding: 12px 14px;">Tanggal Hari</th>
                        <th style="padding: 12px 14px;">Jam Datang Sekolah</th>
                        <th style="padding: 12px 14px;">Jam Pulang / Status Gerbang</th>
                        <th style="padding: 12px 14px;">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logDatangPulang as $log)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">{{ $log['tanggal'] }}</td>
                        <td style="padding: 12px 14px; font-weight: 700; color: #166534;">
                            <i class="fa-solid fa-right-to-bracket"></i> {{ $log['jam_datang'] }}
                        </td>
                        <td style="padding: 12px 14px; font-weight: 700; color: #2563eb;">
                            <i class="fa-solid fa-right-from-bracket"></i> {{ $log['jam_pulang'] }}
                        </td>
                        <td style="padding: 12px 14px;">
                            <span style="{{ $log['badge_style'] }} padding: 4px 12px; border-radius: 12px; font-weight: 800; font-size: 11.5px;">
                                {{ $log['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 24px; color: #64748b;">Belum ada log catatan datang-pulang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section Detail Presensi Per Mapel -->
    <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 18px;">
            <i class="fa-solid fa-book-open" style="color: #4a5e8c;"></i> Riwayat Presensi Per Mata Pelajaran
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 2px solid #cbd5e1;">
                        <th style="padding: 12px 14px;">Tanggal</th>
                        <th style="padding: 12px 14px;">Mata Pelajaran</th>
                        <th style="padding: 12px 14px;">Guru Pengajar</th>
                        <th style="padding: 12px 14px;">Status Kehadiran</th>
                        <th style="padding: 12px 14px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensiList as $p)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 14px; font-weight: 600;">{{ $p->jurnalMengajar->tanggal ?? '-' }}</td>
                        <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">{{ $p->jurnalMengajar->mapel->nama_mapel ?? '-' }}</td>
                        <td style="padding: 12px 14px; color: #475569;">{{ $p->jurnalMengajar->guru->nama_guru ?? '-' }}</td>
                        <td style="padding: 12px 14px;">
                            @if($p->keterangan === 'Hadir')
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">Hadir</span>
                            @elseif($p->keterangan === 'Sakit')
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">Sakit</span>
                            @elseif($p->keterangan === 'Izin')
                                <span style="background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">Izin</span>
                            @else
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">Alpa</span>
                            @endif
                        </td>
                        <td style="padding: 12px 14px; color: #64748b;">{{ $p->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 24px; color: #64748b;">
                            Belum ada catatan ketidakhadiran jurnal.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
