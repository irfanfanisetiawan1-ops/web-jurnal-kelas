@extends('layouts.guru')

@php
    $isPiket = Auth::check() && Auth::user()->isGuruPiket();
    $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
    $currentHourMin = $currentTime->format('H:i');
    $todayDateStr = $currentTime->toDateString();

    $daysId = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $monthsId = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $formattedDateStr = $daysId[$currentTime->dayOfWeek] . ', ' . $currentTime->day . ' ' . $monthsId[$currentTime->month] . ' ' . $currentTime->year;
@endphp

@section('title', $isPiket ? 'Dashboard Piket — EDU JOURNAL' : 'Beranda Guru — EDU JOURNAL')
@section('header_title', $isPiket ? 'Pantauan Kelas Real-time (' . $hariIni . ')' : 'Jadwal Mengajar Hari Ini (' . $hariIni . ')')

@section('styles')
<style>
    /* Dashboard Page Header Style (Matching Dashboard TU Example) */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-header-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-header-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .btn-header-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .btn-header-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 24px;
    }
    
    @media (max-width: 1100px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Stats Card Container */
    .stats-container {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 22px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .stats-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 18px;
    }

    .stats-header i {
        color: #2563eb;
        font-size: 18px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }

    .stat-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 6px;
    }

    .stat-sub {
        font-size: 11.5px;
        color: #475569;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Weekly Badges */
    .weekly-badges {
        display: flex;
        gap: 6px;
        margin-top: 8px;
    }

    .badge-week {
        flex: 1;
        text-align: center;
        background: #e2e8f0;
        color: #334155;
        font-size: 11px;
        font-weight: 800;
        padding: 6px 2px;
        border-radius: 6px;
    }

    .badge-week.active {
        background: #2563eb;
        color: #ffffff;
    }

    /* Schedule Card Main */
    .card-schedule {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .card-schedule h2 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 18px;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-schedule {
        width: 100%;
        border-collapse: collapse;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 14px 18px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-schedule td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .time-badge {
        font-size: 12px;
        color: #475569;
        font-weight: 600;
        margin-top: 4px;
    }

    .btn-jurnal {
        background: #2563eb;
        color: #ffffff;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12.5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        border: none;
    }

    .btn-jurnal:hover {
        background: #1d4ed8;
    }

    .btn-disabled {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-filled {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 7px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Right Sidebar Widget Cards */
    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-next-class {
        background: #384972;
        color: #ffffff;
        border: none;
    }

    .widget-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .widget-next-class .widget-header {
        color: #ffffff;
    }

    .next-class-box {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 14px;
        padding: 16px;
        backdrop-filter: blur(4px);
    }

    .next-class-title {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .next-class-time {
        font-size: 14px;
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 10px;
        border-radius: 6px;
    }

    .next-class-desc {
        font-size: 12.5px;
        color: #cbd5e1;
        margin-top: 8px;
        line-height: 1.4;
    }

    /* News & Announcements Widget */
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .news-item {
        padding: 12px 14px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }

    .news-item:hover {
        background: #f1f5f9;
    }

    .news-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    .news-date {
        font-size: 11px;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .warning-banner {
        background: #fff7ed;
        border: 1.5px solid #fdba74;
        color: #c2410c;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 4px 14px rgba(234, 88, 12, 0.12);
    }
</style>
@endsection

@section('content')

    <!-- Page Location Header (Keterangan Keberadaan Halaman) -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Dashboard Guru Mengajar</h1>
            <p>{{ $formattedDateStr }} &nbsp;•&nbsp; Ringkasan operasional &amp; jadwal mengajar hari ini</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('guru.export-rekap-csv') }}" class="btn-header-action btn-header-secondary">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor Rekap</span>
            </a>
            <a href="{{ route('guru.jurnal-harian') }}" class="btn-header-action btn-header-primary">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Isi Jurnal Harian</span>
            </a>
        </div>
    </div>

    <!-- Peringatan 5 Menit Sebelum Jam Pelajaran Berakhir -->
    @php
        $fiveMinWarning = false;
        $warningMapel = '';
        $warningKelas = '';
        $warningJamSelesai = '';
        $warningJadwalId = null;
        $sisaMenitWarning = 0;
    @endphp

    @foreach($jadwals as $checkJadwal)
        @php
            $wMulai   = $checkJadwal->waktu_mulai_effective;
            $wSelesai = $checkJadwal->waktu_selesai_effective;
            $sudahDiisi = $checkJadwal->isDiisiHariIni();
            
            try {
                $selesaiCarbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $todayDateStr . ' ' . $wSelesai, 'Asia/Jakarta');
                $mulaiCarbon   = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $todayDateStr . ' ' . $wMulai, 'Asia/Jakarta');
                
                if (!$sudahDiisi && $currentTime->gte($mulaiCarbon) && $currentTime->lte($selesaiCarbon)) {
                    $diffSecs = $currentTime->diffInSeconds($selesaiCarbon, false);
                    $diffMinutes = (int) ceil(max(0, $diffSecs) / 60);
                    if ($diffMinutes >= 0 && $diffMinutes <= 5) {
                        $fiveMinWarning = true;
                        $warningMapel = $checkJadwal->mapel->nama_mapel ?? 'Mata Pelajaran';
                        $warningKelas = $checkJadwal->kelas->nama_kelas ?? '-';
                        $warningJamSelesai = $wSelesai;
                        $warningJadwalId = $checkJadwal->id_jadwal;
                        $sisaMenitWarning = $diffMinutes;
                        break;
                    }
                }
            } catch (\Exception $e) {
                // Ignore parse exception if time format is invalid
            }
        @endphp
    @endforeach

    @if($fiveMinWarning)
        @php
            $guruNoHp = preg_replace('/[^0-9]/', '', Auth::user()->no_hp ?? (Auth::user()->guru->no_hp ?? '6281234567890'));
            if (empty($guruNoHp)) $guruNoHp = '6281234567890';
            $waMsg = "Peringatan Otomatis EDU JOURNAL: Jam pelajaran {$warningMapel} ({$warningKelas}) tersisa {$sisaMenitWarning} menit lagi (selesai pkl {$warningJamSelesai} WIB). Harap segera mengisi Jurnal Mengajar Anda.";
            $waUrl = "https://wa.me/" . $guruNoHp . "?text=" . rawurlencode($waMsg);
        @endphp
        <div class="warning-banner">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 800; color: #9a3412;">Peringatan Pengisian Jurnal Mengajar!</div>
                    <div style="font-size: 13.5px; color: #c2410c; margin-top: 2px;">
                        Jam pelajaran <strong>{{ $warningMapel }} ({{ $warningKelas }})</strong> tinggal <strong>{{ $sisaMenitWarning <= 1 ? 'kurang dari 1' : $sisaMenitWarning }} menit lagi</strong> berakhir (berakhir pkl {{ $warningJamSelesai }} WIB). Anda belum mengisi Jurnal Mengajar!
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ $waUrl }}" target="_blank" class="btn-jurnal" style="background: #16a34a; font-size: 12.5px; padding: 10px 14px; border-radius: 10px; white-space: nowrap; box-shadow: 0 3px 8px rgba(22, 163, 74, 0.3);">
                    <i class="fa-brands fa-whatsapp" style="font-size: 15px;"></i> Kirim WA Pengingat
                </a>
                <a href="{{ route('jurnal-mengajar.create', ['id_jadwal' => $warningJadwalId]) }}" class="btn-jurnal" style="background: #ea580c; font-size: 12.5px; padding: 10px 16px; border-radius: 10px; white-space: nowrap; box-shadow: 0 3px 8px rgba(234, 88, 12, 0.3);">
                    <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Sekarang
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const waUrl = @json($waUrl);
                const warningId = @json($warningJadwalId);
                const sessionKey = 'wa_auto_sent_jadwal_' + warningId;
                
                if (!sessionStorage.getItem(sessionKey)) {
                    sessionStorage.setItem(sessionKey, 'true');
                    window.open(waUrl, '_blank');
                }
            });
        </script>
    @endif

    <!-- Statistik Mengajar Hari Ini -->
    <div class="stats-container">
        <div class="stats-header">
            <i class="fa-solid fa-chart-column"></i>
            <span>Statistik Mengajar Hari Ini</span>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Jurnal Terisi</div>
                <div class="stat-value">{{ $stats['totalJurnalTerisi'] ?? '4/10' }}</div>
                <div class="stat-sub">Terverifikasi sistem</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Total Kelas Diajar</div>
                <div class="stat-value">{{ $stats['totalKelasDiajar'] ?? '4 Kelas' }}</div>
                <div class="stat-sub">Jadwal aktif hari ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Absensi Rata-rata Siswa</div>
                <div class="stat-value" style="color: #16a34a;">{{ $stats['absensiRataRata'] ?? '95%' }}</div>
                <div class="stat-sub">Tingkat kehadiran kelas</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Jurnal Terisi per Minggu</div>
                <div class="weekly-badges">
                    <span class="badge-week active">M1</span>
                    <span class="badge-week active">M2</span>
                    <span class="badge-week active">M3</span>
                    <span class="badge-week active">M4</span>
                    <span class="badge-week active">M5</span>
                </div>
                <div class="stat-sub" style="margin-top: 6px;">Status progres bulanan</div>
            </div>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="dashboard-grid">
        
        <!-- Left: Table Jadwal Mengajar Hari Ini -->
        <div class="card-schedule">
            <h2>
                <i class="fa-solid fa-calendar-check" style="color: #2563eb;"></i>
                Jadwal Mengajar Hari Ini ({{ $hariIni }})
            </h2>

            <div style="overflow-x: auto;">
                <table class="table-schedule">
                    <thead>
                        @if($isPiket)
                            <tr>
                                <th style="width: 150px;">JAM KE-</th>
                                <th style="width: 140px;">KELAS</th>
                                <th>GURU dan MAPEL</th>
                                <th style="width: 150px;">STATUS KELAS</th>
                                <th style="width: 150px;">DETAIL JURNAL</th>
                            </tr>
                        @else
                            <tr>
                                <th style="width: 160px;">JAM KE-</th>
                                <th style="width: 140px;">KELAS</th>
                                <th>MAPEL</th>
                                <th>RUANGAN</th>
                                <th style="width: 180px;">AKSI JURNAL</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @forelse($jadwals as $j)
                            @php
                                $waktuMulai   = $j->waktu_mulai_effective;
                                $waktuSelesai = $j->waktu_selesai_effective;
                                $sudahMasuk   = $j->sudah_masuk_jam;
                                $sudahDiisi   = $j->isDiisiHariIni();
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $j->jam_range }}</strong>
                                    <div class="time-badge">
                                        {{ $waktuMulai }} - {{ $waktuSelesai }} WIB
                                    </div>
                                </td>
                                <td><strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong></td>
                                
                                @if($isPiket)
                                    <td>
                                        <strong>{{ $j->guru->nama_guru ?? '-' }}</strong><br>
                                        <span style="color: #64748b; font-size: 13px;">{{ $j->mapel->nama_mapel ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if($j->isDiisiHariIni())
                                            <span class="badge-filled"><i class="fa-solid fa-circle-check"></i> Sudah Diisi</span>
                                        @else
                                            <a href="{{ route('jurnal-mengajar.create', ['id_jadwal' => $j->id_jadwal]) }}" class="btn-jurnal" style="font-size: 11.5px; padding: 6px 12px;">
                                                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal (Piket)
                                            </a>
                                        @endif
                                    </td>
                                    <td>-</td>
                                @else
                                    <td>
                                        <strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                        @if(!empty($j->is_guru_pengganti))
                                            <div style="font-size: 11px; font-weight: 800; color: #2563eb; margin-top: 2px;">
                                                ⭐ Penugasan Guru Pengganti (Menggantikan {{ $j->guru->nama_guru ?? 'Guru' }})
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td>
                                        @if($sudahDiisi)
                                            <span class="badge-filled">
                                                <i class="fa-solid fa-circle-check"></i> Sudah Diisi
                                            </span>
                                        @elseif($sudahMasuk || !empty($j->is_guru_pengganti))
                                            <a href="{{ route('jurnal-mengajar.create', ['id_jadwal' => $j->id_jadwal]) }}" class="btn-jurnal">
                                                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal
                                            </a>
                                        @else
                                            <span class="btn-disabled" title="Fitur isi jurnal baru aktif saat pas jam pelajaran dimulai (pkl {{ $waktuMulai }} WIB)">
                                                <i class="fa-solid fa-lock"></i> Belum Jam-nya
                                            </span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada jadwal mengajar untuk hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Jadwal Jam Berikutnya & Berita Sekolah -->
        <div>
            <!-- Card Jadwal Jam Berikutnya -->
            <div class="widget-card widget-next-class">
                <div class="widget-header">
                    <i class="fa-solid fa-clock"></i>
                    <span>Jadwal Jam Berikutnya</span>
                </div>
                @if($jadwalBerikutnya)
                    <div class="next-class-box">
                        <div class="next-class-title">
                            <span>{{ $jadwalBerikutnya->kelas->nama_kelas ?? 'XI RPL 1' }}</span>
                            <span class="next-class-time">{{ $jadwalBerikutnya->waktu_mulai_effective ?? '10:00' }} WIB</span>
                        </div>
                        <div class="next-class-desc">
                            Jam ke-{{ $jadwalBerikutnya->jam_range }} {{ $jadwalBerikutnya->mapel->nama_mapel ?? 'Konsentrasi Keahlian' }} — Harap isi jurnal tepat waktu setelah kelas selesai.
                        </div>
                        <div style="margin-top: 14px;">
                            <a href="{{ route('jurnal-mengajar.create', ['id_jadwal' => $jadwalBerikutnya->id_jadwal]) }}" class="btn-jurnal" style="background: #ffffff; color: #1e293b; width: 100%; justify-content: center;">
                                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Kelas Ini
                            </a>
                        </div>
                    </div>
                @else
                    <div class="next-class-box">
                        <div class="next-class-title">
                            <span>Tidak Ada Jam</span>
                        </div>
                        <div class="next-class-desc">
                            Seluruh jadwal jam mengajar hari ini telah selesai dilaksanakan.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Card Berita & Pengumuman Sekolah -->
            <div class="widget-card">
                <div class="widget-header" style="color: #0f172a;">
                    <i class="fa-solid fa-bullhorn" style="color: #2563eb;"></i>
                    <span>Berita & Pengumuman Sekolah</span>
                </div>
                <div class="news-list">
                    @forelse($pengumumanList as $p)
                        <div class="news-item">
                            <div class="news-title">{{ $p->judul }}</div>
                            <div class="news-date">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8;">Belum ada pengumuman baru.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($fiveMinWarning)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan Waktu Mengajar!',
            html: 'Jam pelajaran <b>{{ $warningMapel }} ({{ $warningKelas }})</b> tersisa <b>{{ $sisaMenitWarning == 0 ? "kurang dari 1" : $sisaMenitWarning }} menit lagi</b> berakhir (pkl {{ $warningJamSelesai }} WIB).<br><br><span style="color:#c2410c; font-size:13.5px; font-weight:700;">Anda belum mengisi Jurnal Mengajar. Harap segera isi jurnal!</span>',
            confirmButtonText: '<i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Sekarang',
            confirmButtonColor: '#ea580c',
            showCancelButton: true,
            cancelButtonText: 'Nanti Saja',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('jurnal-mengajar.create', ['id_jadwal' => $warningJadwalId]) }}";
            }
        });
    });
</script>
@endif
@endsection
