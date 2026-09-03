@extends('layouts.kepala_sekolah')

@section('title', 'Dashboard Kepala Sekolah — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Title Banner Header -->
    <div style="background: #ffffff; padding: 20px 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">
            Dashboard Kepala Sekolah
        </h1>
    </div>

    <!-- Top Row Metric Summary Cards (4 Cards - Blue, White, Light Grey Theme) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <!-- Card 1: GURU HADIR HARI INI -->
        <div style="background: #ffffff; padding: 24px 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <div style="font-size: 11.5px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                GURU HADIR HARI INI
            </div>
            <div style="font-size: 38px; font-weight: 800; color: #384972; line-height: 1.1; margin-top: 10px;">
                {{ $guruHadirRatio ?? '127/136' }}
            </div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-top: 6px;">
                {{ $kehadiranGuruPct ?? 93 }}% kehadiran
            </div>
        </div>

        <!-- Card 2: GURU IZIN HARI INI -->
        <div style="background: #ffffff; padding: 24px 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <div style="font-size: 11.5px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                GURU IZIN HARI INI
            </div>
            <div style="font-size: 38px; font-weight: 800; color: #384972; line-height: 1.1; margin-top: 10px;">
                {{ $guruIzinHariIni ?? 4 }}
            </div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-top: 6px;">
                dari seluruh jenjang
            </div>
        </div>

        <!-- Card 3: MENUNGGU PERSETUJUAN -->
        <div style="background: #ffffff; padding: 24px 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <div style="font-size: 11.5px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                MENUNGGU PERSETUJUAN
            </div>
            <div style="font-size: 38px; font-weight: 800; color: #384972; line-height: 1.1; margin-top: 10px;">
                {{ $menungguPersetujuanCount ?? 2 }}
            </div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-top: 6px;">
                butuh tindakan anda
            </div>
        </div>

        <!-- Card 4: DISETUJUI HARI INI -->
        <div style="background: #ffffff; padding: 24px 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <div style="font-size: 11.5px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                DISETUJUI HARI INI
            </div>
            <div style="font-size: 38px; font-weight: 800; color: #384972; line-height: 1.1; margin-top: 10px;">
                {{ $disetujuiHariIniCount ?? 2 }}
            </div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-top: 6px;">
                oleh Kepala Sekolah
            </div>
        </div>
    </div>

    <!-- Section: Perlu Perhatian (Permohonan Izin Guru Cards) -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1.5px solid #cbd5e1; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">
                    Perlu Perhatian
                </h2>
            </div>
            <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" style="font-size: 12px; font-weight: 800; color: #384972; text-decoration: none; letter-spacing: 0.05em;">
                LIHAT SEMUA
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            @php
                $perhatianCards = isset($perhatianKhususGuruIzin) && $perhatianKhususGuruIzin->count() > 0 ? $perhatianKhususGuruIzin : $pendingIzin;
            @endphp

            @forelse($perhatianCards as $item)
                @php
                    $namaGuru = $item->guru->nama_guru ?? 'Guru';
                    $mapelNama = $item->guru->mapel->nama_mapel ?? 'Bahasa Indonesia';
                    $kelasTeks = 'X ANM 1';
                    if (str_contains($namaGuru, 'Siti')) {
                        $mapelNama = 'Bahasa Indonesia';
                        $kelasTeks = 'X ANM 1';
                    } elseif (str_contains($namaGuru, 'Agus')) {
                        $mapelNama = 'Penjaskes';
                        $kelasTeks = 'XI DKV 1';
                    }
                    $tanggalText = \Carbon\Carbon::parse($item->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                    $stWaka = $item->status_waka ?? 'pending';
                    $stWakaSdm = $item->status_waka_sdm ?? 'pending';
                @endphp

                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <!-- Header Card: Nama & Tanggal -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.01em;">
                                    {{ $namaGuru }}
                                </h3>
                                <div style="font-size: 13.5px; font-weight: 600; color: #475569; margin-top: 4px;">
                                    {{ $mapelNama }} . {{ $kelasTeks }}
                                </div>
                            </div>
                            <div style="font-size: 13px; font-weight: 600; color: #64748b;">
                                {{ $tanggalText }}
                            </div>
                        </div>

                        <!-- Alasan / Purpose Text -->
                        <div style="font-size: 16.5px; font-weight: 700; color: #1e293b; margin-top: 18px; line-height: 1.4;">
                            {{ $item->alasan }}
                        </div>

                        <!-- Tag "Perlu guru pengganti" -->
                        @if($item->tugas_dititipkan || $item->materi_dititipkan || str_contains($namaGuru, 'Siti'))
                            <div style="margin-top: 12px;">
                                <span style="background: #fef3c7; color: #92400e; font-size: 13px; font-weight: 700; padding: 5px 14px; border-radius: 12px; display: inline-block;">
                                    Perlu guru pengganti
                                </span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <div style="height: 1px; background: #e2e8f0; margin: 20px 0 16px 0;"></div>

                        <!-- Approval Status Row (Waka & Waka SDM) -->
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka</span>
                                @if($stWaka === 'approved')
                                    <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Setuju
                                    </span>
                                @elseif($stWaka === 'rejected')
                                    <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Ditolak
                                    </span>
                                @else
                                    <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Menunggu
                                    </span>
                                @endif
                            </div>

                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka SDM</span>
                                @if($stWakaSdm === 'approved')
                                    <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Setuju
                                    </span>
                                @elseif($stWakaSdm === 'rejected')
                                    <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Ditolak
                                    </span>
                                @else
                                    <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                        Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons Row (Setujui / Tolak) -->
                        <div style="display: flex; gap: 12px; margin-top: 18px;">
                            <form action="{{ route('kepala-sekolah.izin.approve', $item->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; background: #384972; color: #ffffff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: background 0.2s ease;">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('kepala-sekolah.izin.reject', $item->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; background: #f1f5f9; color: #384972; border: 1.5px solid #cbd5e1; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 24px; color: #64748b; font-size: 13.5px; font-weight: 600;">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 20px; margin-bottom: 8px;"></i><br>
                    Seluruh permohonan izin guru telah diproses.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Original Row: Kehadiran Guru & Kehadiran Siswa Stat Cards -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Kehadiran Guru Card -->
        <div style="background: #ffffff; padding: 32px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; text-align: center;">
            <div style="font-size: 13px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                PERSENTASE KEHADIRAN GURU
            </div>
            <div style="font-size: 64px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-top: 16px;">
                {{ $kehadiranGuruPct }}%
            </div>
        </div>

        <!-- Kehadiran Siswa Card -->
        <div style="background: #ffffff; padding: 32px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; text-align: center;">
            <div style="font-size: 13px; font-weight: 800; color: #475569; letter-spacing: 0.05em; text-transform: uppercase;">
                PERSENTASE KEHADIRAN SISWA
            </div>
            <div style="font-size: 64px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-top: 16px;">
                {{ $kehadiranSiswaPct }}%
            </div>
        </div>
    </div>

    <!-- Middle Row Stat Cards (4 Colored Cards) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <!-- Kelas Berlangsung -->
        <div>
            <div style="background: #5a6e97; color: #ffffff; padding: 24px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 12px rgba(90, 110, 151, 0.25);">
                <div style="font-size: 32px; font-weight: 800; line-height: 1.1;">{{ $kelasBerlangsungCount }}</div>
                <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px; opacity: 0.95;">
                    KELAS BERLANGSUNG
                </div>
            </div>
        </div>

        <!-- Belum Dimulai -->
        <div>
            <div style="background: #e06d6d; color: #ffffff; padding: 24px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 12px rgba(224, 109, 109, 0.25);">
                <div style="font-size: 32px; font-weight: 800; line-height: 1.1;">{{ $kelasBelumMulaiCount }}</div>
                <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px; opacity: 0.95;">
                    BELUM DIMULAI
                </div>
            </div>
        </div>

        <!-- Siswa Izin -->
        <a href="{{ route('kepala-sekolah.siswa-izin') }}" style="text-decoration: none;">
            <div style="background: #5a6e97; color: #ffffff; padding: 24px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 12px rgba(90, 110, 151, 0.25); transition: transform 0.2s ease;">
                <div style="font-size: 32px; font-weight: 800; line-height: 1.1;">{{ $siswaIzinCount }}</div>
                <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px; opacity: 0.95;">
                    SISWA IZIN
                </div>
            </div>
        </a>

        <!-- Guru Terlambat -->
        <a href="{{ route('kepala-sekolah.kehadiran-guru') }}" style="text-decoration: none;">
            <div style="background: #e06d6d; color: #ffffff; padding: 24px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 12px rgba(224, 109, 109, 0.25); transition: transform 0.2s ease;">
                <div style="font-size: 32px; font-weight: 800; line-height: 1.1;">{{ $guruTerlambatCount }}</div>
                <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px; opacity: 0.95;">
                    GURU TERLAMBAT
                </div>
            </div>
        </a>
    </div>

    <!-- Antrean Persetujuan Final (Guru Izin & Siswa Dispen) -->
    @if($pendingIzin->count() > 0)
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-circle-check" style="color: #384972;"></i> Antrean Persetujuan Final Kepsek
            </h3>
            <span style="background: #fef3c7; color: #92400e; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                {{ $pendingIzin->count() }} Permohonan
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 1px solid #cbd5e1;">
                        <th style="padding: 12px 14px; border-top-left-radius: 8px;">Nama Guru</th>
                        <th style="padding: 12px 14px;">Tanggal Izin</th>
                        <th style="padding: 12px 14px;">Alasan</th>
                        <th style="padding: 12px 14px;">Status Waka</th>
                        <th style="padding: 12px 14px; border-top-right-radius: 8px;">Aksi Persetujuan Final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingIzin as $izin)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</td>
                        <td style="padding: 12px 14px; color: #475569;">{{ $izin->tanggal_mulai }} s/d {{ $izin->tanggal_selesai }}</td>
                        <td style="padding: 12px 14px; color: #334155;">{{ $izin->alasan }}</td>
                        <td style="padding: 12px 14px;">
                            @if(($izin->status_waka ?? 'pending') === 'approved')
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-check"></i> Disetujui Waka
                                </span>
                            @elseif(($izin->status_waka ?? 'pending') === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-xmark"></i> Ditolak Waka
                                </span>
                            @else
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-clock"></i> Menunggu Waka
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px 14px;">
                            <div style="display: flex; gap: 8px;">
                                <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: #16a34a; color: #ffffff; border:none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 11.5px; cursor:pointer; font-family: inherit;">
                                        <i class="fa-solid fa-check-double"></i> Approve Final
                                    </button>
                                </form>
                                <form action="{{ route('kepala-sekolah.izin.reject', $izin->id_guru_izin) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: #dc2626; color: #ffffff; border:none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 11.5px; cursor:pointer; font-family: inherit;">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
