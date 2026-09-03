@extends('layouts.kepala_sekolah')

@section('title', 'Kehadiran Guru — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner (Persis Mockup media_1787329513206.png) -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; letter-spacing: -0.02em;">
                Kehadiran Guru
            </h1>
            <p style="margin: 0; color: #64748b; font-size: 13.5px; font-weight: 600;">
                Daftar permohonan izin aktif Guru dan Siswa
            </p>
        </div>

        <div style="width: 44px; height: 44px; background: #f1f5f9; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 18px; cursor: pointer;" title="Notifikasi">
            <i class="fa-regular fa-bell"></i>
        </div>
    </div>

    <!-- Cards List Permohonan Izin Guru (Persis Mockup UI) -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($guruIzinList as $izin)
        <div style="background: #ffffff; padding: 24px 28px; border-radius: 18px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Top Header Card: Profil Guru & Status Pill -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: #8fa0c4; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-weight: 800; font-size: 10px; text-align: center; line-height: 1.2; padding: 4px;">
                        @if($izin->guru && $izin->guru->nama_guru)
                            PROFIL GURUNYA
                        @else
                            AVATAR
                        @endif
                    </div>
                    <div>
                        <div style="font-size: 17px; font-weight: 800; color: #0f172a;">
                            {{ $izin->guru->nama_guru ?? 'Wiwik Yuniarsih, S.Pd' }}
                        </div>
                        <div style="font-size: 13.5px; color: #64748b; font-weight: 600; margin-top: 2px;">
                            Guru - {{ $izin->guru->mapel->nama_mapel ?? 'Pendidikan Pancasila' }}
                        </div>
                    </div>
                </div>

                <!-- Status Pill Badge -->
                <div>
                    @if($izin->status_kepsek == 'approved')
                        <span style="background: #86efac; color: #14532d; font-weight: 800; font-size: 13px; padding: 6px 20px; border-radius: 20px; display: inline-block;">
                            Disetujui
                        </span>
                    @elseif($izin->status_kepsek == 'rejected')
                        <span style="background: #fca5a5; color: #7f1d1d; font-weight: 800; font-size: 13px; padding: 6px 20px; border-radius: 20px; display: inline-block;">
                            Ditolak
                        </span>
                    @else
                        <span style="background: #fef08a; color: #713f12; font-weight: 800; font-size: 13px; padding: 6px 20px; border-radius: 20px; display: inline-block;">
                            Menunggu Persetujuan
                        </span>
                    @endif
                </div>
            </div>

            <div style="border-bottom: 1.5px solid #f1f5f9;"></div>

            <!-- Details Grid: Tanggal & Durasi -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div>
                    <div style="font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em;">
                        TANGGAL
                    </div>
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                        {{ $izin->tanggal_formatted }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em;">
                        DURASI
                    </div>
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                        {{ $izin->durasi_formatted }}
                    </div>
                </div>
            </div>

            <!-- Alasan Block -->
            <div>
                <div style="font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em;">
                    ALASAN
                </div>
                <div style="background: #f1f5f9; padding: 12px 18px; border-radius: 12px; margin-top: 6px; color: #475569; font-weight: 600; font-size: 14px;">
                    {{ $izin->alasan }}
                </div>
            </div>

            <!-- Action Buttons (Bottom Right for Pending Items) -->
            @if($izin->status_kepsek == 'pending')
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 4px;">
                <form action="{{ route('kepala-sekolah.izin.reject', $izin->id_guru_izin) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: #dc2626; color: #ffffff; padding: 8px 24px; border-radius: 20px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; font-family: inherit;">
                        Tolak
                    </button>
                </form>

                <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: #1d4ed8; color: #ffffff; padding: 8px 24px; border-radius: 20px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; font-family: inherit;">
                        Setujui
                    </button>
                </form>
            </div>
            @endif

        </div>
        @empty
        <div style="background: #ffffff; padding: 32px; border-radius: 16px; text-align: center; color: #64748b; font-weight: 600;">
            Tidak ada permohonan izin aktif saat ini.
        </div>
        @endforelse
    </div>

    <!-- Master Table Kehadiran & Jurnal Harian Seluruh Guru -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 18px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; margin-top: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-list-check" style="color: #384972;"></i> Rekapitulasi Presensi & Pengisian Jurnal Guru
            </h3>

            <form method="GET" action="{{ route('kepala-sekolah.kehadiran-guru') }}" style="display: flex; gap: 10px;">
                <input type="date" name="tanggal" value="{{ $tanggal }}" style="padding: 8px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; font-family: inherit;">
                <button type="submit" style="background: #384972; color: #fff; border: none; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; font-family: inherit;">
                    Filter
                </button>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 1px solid #cbd5e1;">
                        <th style="padding: 12px;">No</th>
                        <th style="padding: 12px;">NIP</th>
                        <th style="padding: 12px;">Nama Guru</th>
                        <th style="padding: 12px;">Mata Pelajaran</th>
                        <th style="padding: 12px;">Status Mengajar</th>
                        <th style="padding: 12px;">Keterangan Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruList as $index => $g)
                    @php
                        $jurnal = $jurnalHariIni->get($g->id_guru);
                        $izin = $izinHariIni->get($g->id_guru);
                    @endphp
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 700; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="padding: 12px; color: #475569;">{{ $g->nip ?? '-' }}</td>
                        <td style="padding: 12px; font-weight: 700; color: #0f172a;">{{ $g->nama_guru }}</td>
                        <td style="padding: 12px; color: #334155;">{{ $g->mapel->nama_mapel ?? '-' }}</td>
                        <td style="padding: 12px;">
                            @if($jurnal)
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-circle-check"></i> Sudah Mengisi Jurnal
                                </span>
                            @elseif($izin)
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-user-xmark"></i> Izin ({{ $izin->alasan }})
                                </span>
                            @else
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                    <i class="fa-solid fa-clock"></i> Belum Ada Jurnal Today
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px; color: #64748b; font-size: 12.5px;">
                            @if($jurnal)
                                Materi: {{ $jurnal->materi }}
                            @elseif($izin)
                                Surat Izin Terverifikasi
                            @else
                                Terjadwal Mengajar
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">Belum ada data guru terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
