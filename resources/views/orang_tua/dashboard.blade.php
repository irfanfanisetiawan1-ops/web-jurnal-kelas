@extends('layouts.orang_tua')

@section('title', 'Dashboard Orang Tua — Jurnal SMEA')

@section('content')
@php
    $currentUser = $user ?? Auth::user();
@endphp
<div class="dashboard-container" style="max-width: 1200px; margin: 0 auto;">

    <!-- Top Page Header & Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
            Jurnal SMEA &gt; <span style="color: #1e293b;">Dashboard Orang Tua</span>
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
            Dashboard Orang Tua
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 13.5px; font-weight: 600;">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM YYYY') }} &nbsp;•&nbsp; Ringkasan operasional sekolah hari ini
        </p>
    </div>

    @if($siswa)
    <!-- Student Information Card -->
    <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; margin-bottom: 24px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
        
        <!-- Profile Picture Box -->
        <div style="width: 100px; height: 100px; background: #cbd5e1; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; border: 2px solid #e2e8f0;">
            @if($currentUser && $currentUser->foto_url)
                <img src="{{ $currentUser->foto_url }}" alt="{{ $siswa->nama_siswa }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fa-solid fa-user-graduate" style="font-size: 42px; color: #64748b;"></i>
            @endif
        </div>

        <!-- Student Details -->
        <div style="flex: 1; min-width: 260px;">
            <h2 style="margin: 0 0 6px 0; font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: 0.5px; text-transform: uppercase;">
                {{ $siswa->nama_siswa }}
            </h2>
            <div style="font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 14px;">
                Kelas: <strong style="color: #0f172a;">{{ $siswa->kelas->nama_kelas ?? 'XI RPL 1' }}</strong> &nbsp;|&nbsp; 
                NISN: <strong style="color: #0f172a;">{{ $siswa->nisn ?? '0082075177' }}</strong>
            </div>

            <!-- Status Badges -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="background: #4ade80; color: #14532d; padding: 6px 16px; border-radius: 20px; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(74, 222, 128, 0.2);">
                    <i class="fa-solid fa-circle-check" style="font-size: 11px;"></i> Status Aktif
                </span>

                <span style="background: #50618a; color: #ffffff; padding: 6px 18px; border-radius: 20px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(80, 97, 138, 0.2);">
                    Wali Kelas: {{ $siswa->kelas->waliKelas->nama_guru ?? 'Sulistyowati, SS' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Middle Grid Row: Status Kehadiran Terkini & Aktivitas Izin / Keluar -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px; margin-bottom: 24px;">

        <!-- Card 1: Status Kehadiran Terkini -->
        <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between;">
            <div style="font-size: 14px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 20px;">
                STATUS KEHADIRAN TERKINI
            </div>

            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 10px;">
                <div style="width: 68px; height: 68px; background: {{ $statusHariIni['badge_bg'] ?? '#bbf7d0' }}; border-radius: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-solid {{ $statusHariIni['icon'] ?? 'fa-school' }}" style="font-size: 32px; color: {{ $statusHariIni['badge_text'] ?? '#166534' }};"></i>
                </div>
                <div>
                    <div style="font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.2;">
                        {{ $statusHariIni['status'] ?? 'Di Sekolah' }}
                    </div>
                    <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-top: 4px;">
                        {{ $statusHariIni['subtext'] ?? 'Sampai Sekolah: 06.40' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Aktivitas Izin / Keluar -->
        <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between; align-items: center; text-align: center;">
            <div style="font-size: 14px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; width: 100%; text-align: left; margin-bottom: 16px;">
                AKTIVITAS IZIN / KELUAR
            </div>

            <div style="margin: 10px 0 20px 0;">
                @if($aktivitasIzinAktif)
                    <div style="background: #e0f2fe; padding: 12px 18px; border-radius: 12px; border: 1px solid #bae6fd; text-align: left;">
                        <div style="font-weight: 800; color: #0369a1; font-size: 14px;">{{ $aktivitasIzinAktif['tipe'] }}</div>
                        <div style="font-size: 12.5px; color: #334155; margin-top: 2px;">{{ $aktivitasIzinAktif['detail'] }}</div>
                    </div>
                @else
                    <p style="font-size: 16px; font-weight: 700; color: #334155; margin: 0;">
                        Tidak ada izin aktif saat ini.
                    </p>
                @endif
            </div>

            <div>
                <a href="{{ route('orang-tua.izin') }}" style="background: #4a5e8c; color: #ffffff; padding: 10px 24px; border-radius: 20px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(74, 94, 140, 0.3); transition: all 0.2s ease;">
                    <i class="fa-solid fa-plus"></i> AJUKAN IZIN BARU
                </a>
            </div>
        </div>

    </div>

    <!-- Bottom Full-Width Card: Ringkasan Kehadiran Bulan Ini -->
    <div style="background: #ffffff; border-radius: 18px; padding: 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 15px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
                RINGKASAN KEHADIRAN BULAN {{ $rekapBulan['nama_bulan'] ?? 'AGUSTUS' }}
            </div>
            <div style="font-size: 12.5px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 6px 14px; border-radius: 10px;">
                Total Pertemuan: {{ $rekapBulan['total'] ?? 21 }} Jurnal
            </div>
        </div>

        <!-- Bar Chart Visualization -->
        <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 180px; padding: 0 20px; border-bottom: 2px solid #e2e8f0; position: relative;">
            
            <!-- Hadir Bar -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; width: 80px; height: 100%; justify-content: flex-end;">
                <div style="font-size: 11.5px; font-weight: 800; color: #384972;">{{ $rekapBulan['hadir'] ?? 20 }}</div>
                <div style="width: 100%; max-width: 60px; height: {{ max(15, $rekapBulan['persen_hadir'] ?? 95) }}%; background: #384972; border-radius: 8px 8px 0 0; transition: height 0.5s ease; box-shadow: 0 4px 10px rgba(56, 73, 114, 0.2);"></div>
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

        <!-- Chart Labels -->
        <div style="display: flex; justify-content: space-around; margin-top: 14px; text-align: center;">
            <div style="width: 80px; font-size: 12.5px; font-weight: 800; color: #384972;">HADIR</div>
            <div style="width: 80px; font-size: 12.5px; font-weight: 800; color: #d97706;">SAKIT</div>
            <div style="width: 80px; font-size: 12.5px; font-weight: 800; color: #166534;">IZIN</div>
            <div style="width: 80px; font-size: 12.5px; font-weight: 800; color: #dc2626;">ALFA</div>
        </div>

    </div>

    @else
    <!-- Unlinked State Card -->
    <div style="background: #ffffff; border-radius: 18px; padding: 40px 24px; text-align: center; color: #64748b; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0;">
        <i class="fa-solid fa-triangle-exclamation fa-3x" style="color: #d97706; margin-bottom: 16px;"></i>
        <h2 style="margin: 0 0 8px 0; color: #1e293b; font-size: 20px;">Akun Orang Tua belum terhubung ke data siswa</h2>
        <p style="margin: 0; font-size: 14px;">Silakan hubungi Administrator TU untuk menghubungkan akun ini dengan NISN anak Anda.</p>
    </div>
    @endif

</div>
@endsection
