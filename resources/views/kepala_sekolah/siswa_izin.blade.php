@extends('layouts.kepala_sekolah')

@section('title', 'Siswa Sedang Izin — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner (Persis Mockup UI media_1788195430655.png) -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="font-size: 12.5px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
            DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i> <span style="color: #1e293b; font-weight: 800;">siswa yang sedang izin</span>
        </div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px; letter-spacing: -0.01em;">
            <i class="fa-solid fa-id-card" style="color: #384972;"></i> Daftar Siswa Yang Sedang Izin & Dispensasi Active
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 13.5px; font-weight: 500;">
            Pemantauan langsung seluruh permohonan izin sakit, izin keperluan pribadi, dan dispensasi luar sekolah.
        </p>
    </div>

    <!-- Table 1: Siswa Dispensasi Keluar Gerbang Sekolah (Persis Mockup UI media_1788195430655.png) -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0 0 18px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-building-flag" style="color: #384972;"></i> Siswa Dispensasi Keluar Gerbang Sekolah
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Keperluan / Alasan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jam Izin</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Persetujuan Satpam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenSiswa as $d)
                        @php
                            $namaSiswa = $d->siswa->nama_siswa ?? 'Siswa';
                            $namaKelas = $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? 'X AK 4');
                            
                            $jamTeks = '-';
                            if ($d->created_at) {
                                $jamTeks = $d->created_at->format('H:i') . ' WIB';
                            } elseif ($d->jam_keluar) {
                                $jamTeks = $d->jam_keluar . ' WIB';
                            }

                            $stSatpam = strtolower($d->status_satpam ?? 'dizinkan_keluar');
                            $satpamBg = '#dcfce7';
                            $satpamColor = '#166534';
                            $satpamTeks = 'Dizinkan keluar';

                            if ($stSatpam === 'belum_keluar') {
                                $satpamBg = '#dcfce7';
                                $satpamColor = '#166534';
                                $satpamTeks = 'Belum keluar';
                            } elseif ($stSatpam === 'sudah_kembali') {
                                $satpamBg = '#dcfce7';
                                $satpamColor = '#166534';
                                $satpamTeks = 'Sudah kembali';
                            } elseif ($stSatpam === 'ditolak') {
                                $satpamBg = '#fee2e2';
                                $satpamColor = '#991b1b';
                                $satpamTeks = 'Ditolak satpam';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 16px; font-weight: 800; color: #0f172a;">{{ $namaSiswa }}</td>
                            <td style="padding: 16px; font-weight: 700; color: #384972;">{{ $namaKelas }}</td>
                            <td style="padding: 16px; color: #334155; font-weight: 600;">{{ $d->alasan }}</td>
                            <td style="padding: 16px; color: #475569; font-weight: 600;">{{ $jamTeks }}</td>
                            <td style="padding: 16px;">
                                <span style="background: {{ $satpamBg }}; color: {{ $satpamColor }}; padding: 5px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                    {{ $satpamTeks }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: #64748b; font-weight: 600;">
                                Tidak ada siswa yang sedang dispensasi keluar sekolah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Siswa Izin Tidak Masuk Sekolah (Sakit / Izin) (Persis Mockup UI media_1788195537532.png) -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0 0 18px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-notes-medical" style="color: #384972;"></i> Siswa Izin Tidak Masuk Sekolah (Sakit / Izin)
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jenis Keterangan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Tanggal Izin</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Alasan Permohonan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratIzinSiswa as $s)
                        @php
                            $namaSiswaIzin = $s->siswa->nama_siswa ?? 'Irfan Fani Setiawan';
                            $ketTeks = strtoupper($s->kategori ?? $s->keterangan ?? 'ADAA');
                        @endphp
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 16px; font-weight: 800; color: #0f172a;">{{ $namaSiswaIzin }}</td>
                            <td style="padding: 16px;">
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 14px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-block;">
                                    {{ $ketTeks }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: #475569; font-weight: 700;">{{ $s->tanggal }}</td>
                            <td style="padding: 16px; color: #334155; font-weight: 600;">{{ $s->alasan ?? $s->keterangan ?? 'Izin keperluan keluarga' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 24px; color: #64748b; font-weight: 600;">
                                Belum ada data surat izin tidak masuk sekolah hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
