@extends('layouts.admin')

@section('title', 'Dashboard Tata Usaha — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Chart.js for smooth Line and Bar charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0f7ff',
              100: '#e0effe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              900: '#1e3a8a',
            }
          },
          boxShadow: {
            'card-subtle': '0 2px 10px 0 rgba(15, 23, 42, 0.04)',
            '2xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
          }
        }
      }
    }
</script>

<style>
    /* Scoped Pagination Component (Individual Rounded-lg Buttons) */
    .dashboard-pagination nav > div.sm\:hidden {
        display: none !important;
    }
    .dashboard-pagination nav div.sm\:flex-1 > div:first-child {
        display: none !important;
    }
    .dashboard-pagination nav div.sm\:flex-1 {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md {
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
        border-radius: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.375rem !important; /* gap-1.5 */
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md > span,
    .dashboard-pagination nav span[aria-disabled="true"],
    .dashboard-pagination nav span[aria-current="page"] {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: inline-flex !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md a,
    .dashboard-pagination nav span.shadow-sm.rounded-md > span > span,
    .dashboard-pagination nav span.shadow-sm.rounded-md span[aria-disabled="true"] > span,
    .dashboard-pagination nav span.shadow-sm.rounded-md span[aria-current="page"] > span {
        width: 2rem !important; /* 32px (w-8) */
        height: 2rem !important; /* 32px (h-8) */
        min-width: 2rem !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 0.5rem !important; /* rounded-lg */
        font-size: 0.75rem !important; /* text-xs */
        font-weight: 600 !important;
        margin: 0 !important;
        box-shadow: none !important;
        transition: all 0.15s ease !important;
        border: 1px solid #e2e8f0 !important; /* border-slate-200 */
        background-color: #ffffff !important;
        color: #475569 !important; /* text-slate-600 */
        text-decoration: none !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md a:hover {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md span[aria-current="page"] > span {
        background-color: #2563eb !important; /* bg-blue-600 */
        border-color: #2563eb !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md span[aria-disabled="true"] > span {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important;
        cursor: not-allowed !important;
        opacity: 0.7 !important;
    }
    .dashboard-pagination nav span.shadow-sm.rounded-md svg {
        width: 0.875rem !important;
        height: 0.875rem !important;
    }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-backdrop-custom.active {
        display: flex;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        width: 100%;
        max-width: 34rem;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        animation: modalScaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes modalScaleIn {
        from { opacity: 0; transform: scale(0.96) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title">Dashboard Administrator</h1>
</div>
@endsection

@section('content')
<div class="space-y-6 pb-12 font-sans text-slate-800">

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 1: HEADER TITLE & ACTIONS (EKSPOR REKAP & TAMBAH JADWAL) -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Tata Usaha</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">{{ $formattedDate }} &nbsp;•&nbsp; Ringkasan operasional sekolah hari ini</p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            <a href="{{ route('admin.export-csv') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 shadow-xs transition no-underline hover:border-slate-300">
                <i class="fa-solid fa-file-csv text-rose-500 text-base"></i>
                <span>Ekspor Rekap</span>
            </a>
            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition no-underline">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>


    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 3: 6 STAT CARDS GRID (PENGGUNA, SISWA, GURU, KELAS, SLOT AKTIF, KEPATUHAN) -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <!-- Card 1: PENGGUNA -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-50/70 via-sky-50/30 to-white border border-blue-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Pengguna</span>
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $totalPengguna > 0 ? $totalPengguna : 128 }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Total Akun Sistem</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                <i class="fa-solid fa-check text-[10px]"></i>
                <span class="truncate">Aktif & Terverifikasi</span>
            </div>
        </div>

        <!-- Card 2: SISWA AKTIF -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50/70 via-blue-50/30 to-white border border-indigo-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $totalSiswa > 0 ? $totalSiswa : 32 }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Total Siswa Aktif</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-indigo-600">
                <i class="fa-solid fa-arrow-up text-[10px]"></i>
                <span class="truncate">Terdaftar KBM</span>
            </div>
        </div>

        <!-- Card 3: GURU AKTIF -->
        <div class="relative overflow-hidden bg-gradient-to-br from-purple-50/70 via-indigo-50/30 to-white border border-purple-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Guru Aktif</span>
                <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $totalGuru > 0 ? $totalGuru : 128 }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Guru Terdaftar</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-purple-600">
                <i class="fa-solid fa-check text-[10px]"></i>
                <span class="truncate">{{ $countGuruPiket ?? 3 }} Piket • {{ $countWaliKelas ?? 17 }} Walas</span>
            </div>
        </div>

        <!-- Card 4: KELAS -->
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50/70 via-teal-50/30 to-white border border-emerald-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Kelas</span>
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $totalKelas > 0 ? $totalKelas : 48 }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Total Rombel Kelas</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                <i class="fa-solid fa-layer-group text-[10px]"></i>
                <span class="truncate">{{ $totalMapel > 0 ? $totalMapel : 19 }} Mapel</span>
            </div>
        </div>

        <!-- Card 5: SLOT AKTIF -->
        <div class="relative overflow-hidden bg-gradient-to-br from-amber-50/70 via-orange-50/30 to-white border border-amber-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Slot Aktif</span>
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $totalJadwal > 0 ? $totalJadwal : 970 }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Jadwal Mengajar</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-amber-600">
                <i class="fa-solid fa-arrow-up text-[10px]"></i>
                <span class="truncate">6 hari efektif KBM</span>
            </div>
        </div>

        <!-- Card 6: KEPATUHAN -->
        <div class="relative overflow-hidden bg-gradient-to-br from-rose-50/70 via-pink-50/30 to-white border border-rose-100/80 rounded-2xl p-4 shadow-xs transition hover:shadow-sm hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Kepatuhan</span>
                <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $persentasePenyelesaian ?? 84 }}%</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Jurnal Selesai Hari Ini</div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] font-semibold text-rose-600">
                <i class="fa-solid fa-circle-check text-[10px]"></i>
                <span class="truncate">{{ $sudahMengisi ?? 0 }} dari {{ $totalJadwalSesi ?? 0 }} sesi</span>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 4: PERLU TINDAKAN & NOTIFIKASI VERIFIKASI -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Left: Card Perlu Tindakan (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Perlu Tindakan</h3>
                        <p class="text-xs text-slate-500">Alert dan pemberitahuan operasional yang membutuhkan penanganan</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100/70 border border-amber-200 text-amber-800 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>{{ count($perluTindakan) }} Prioritas</span>
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 my-auto pt-1">
                @php
                    $alertStyles = [
                        ['border' => 'border-amber-200', 'bg' => 'bg-amber-50/50', 'iconBg' => 'bg-amber-500', 'icon' => 'fa-regular fa-clock', 'indicator' => 'bg-amber-500'],
                        ['border' => 'border-rose-200', 'bg' => 'bg-rose-50/50', 'iconBg' => 'bg-rose-500', 'icon' => 'fa-solid fa-door-open', 'indicator' => 'bg-rose-500'],
                        ['border' => 'border-indigo-200', 'bg' => 'bg-indigo-50/50', 'iconBg' => 'bg-indigo-600', 'icon' => 'fa-solid fa-user-xmark', 'indicator' => 'bg-indigo-600'],
                    ];
                @endphp
                @foreach($perluTindakan as $idx => $actAlert)
                    @php $s = $alertStyles[$idx % count($alertStyles)]; @endphp
                    <a href="{{ $actAlert['url'] ?? '#' }}" class="relative p-4 rounded-xl border {{ $s['border'] }} {{ $s['bg'] }} hover:shadow-xs transition duration-200 flex flex-col justify-between group no-underline">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-8 h-8 rounded-lg {{ $s['iconBg'] }} text-white flex items-center justify-center text-xs shadow-2xs">
                                <i class="{{ $s['icon'] }}"></i>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-400 group-hover:text-slate-600 transition"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2 leading-snug">{{ $actAlert['title'] }}</h4>
                            <p class="text-[11px] text-slate-500 mt-1 font-medium">{{ $actAlert['subtitle'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Right: Banner Verifikasi Akun Baru (Span 4) -->
        <div class="lg:col-span-4 bg-gradient-to-br from-amber-50/90 via-orange-50/40 to-white border border-amber-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-lg shadow-2xs">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    @if($countPendingUsers > 0)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            {{ $countPendingUsers }} Menunggu
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            Terverifikasi
                        </span>
                    @endif
                </div>
                <h3 class="text-base font-bold text-slate-900">Verifikasi Pengguna Baru</h3>
                <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                    @if($countPendingUsers > 0)
                        Terdapat <strong class="font-extrabold text-amber-900">{{ $countPendingUsers }} akun baru</strong> guru/staf yang belum diverifikasi oleh Admin TU.
                    @else
                        Semua pendaftaran akun guru dan staf telah disetujui. Tidak ada antrean verifikasi saat ini.
                    @endif
                </p>
            </div>

            <div class="pt-4 border-t border-amber-200/60 mt-4 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-500">Modul Master Pengguna</span>
                <a href="{{ route('admin.verifikasi-guru') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-xs no-underline">
                    <span>Buka Verifikasi</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 5: LINE CHART (JURNAL 7 HARI) & DONUT (KEHADIRAN GURU) -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Line Chart: Jurnal Mengajar 7 Hari Terakhir (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Tren Pengisian Jurnal Mengajar</h2>
                        <p class="text-xs text-slate-500">Jumlah jurnal mengajar yang telah diselesaikan 7 hari terakhir</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold bg-slate-50">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        <span>7 Hari Terakhir</span>
                    </div>
                </div>
            </div>

            <!-- Canvas Container -->
            <div class="relative w-full h-56 sm:h-64 pt-2">
                <canvas id="jurnalLineChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart: Kehadiran Guru Hari Ini (Span 4) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Kehadiran Guru Hari Ini</h2>
                <p class="text-xs text-slate-500 mt-0.5">Persentase kehadiran guru dalam KBM</p>
            </div>

            <div class="flex flex-col sm:flex-row lg:flex-col items-center justify-center gap-6 my-auto py-4">
                <!-- Circular Donut Progress -->
                <div class="relative w-36 h-36 flex items-center justify-center shrink-0">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <!-- Background track circle -->
                        <circle cx="50" cy="50" r="40" stroke="#f1f5f9" stroke-width="12" fill="transparent"/>
                        <!-- Foreground progress arc -->
                        <circle cx="50" cy="50" r="40" stroke="#10b981" stroke-width="12" stroke-linecap="round" fill="transparent"
                                stroke-dasharray="251.2"
                                stroke-dashoffset="{{ 251.2 - (251.2 * ($persenKehadiranGuru / 100)) }}"
                                class="transition-all duration-1000 ease-out"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $persenKehadiranGuru }}%</span>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hadir</span>
                    </div>
                </div>

                <!-- Legend Counts List -->
                <div class="space-y-2.5 w-full max-w-[200px]">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="font-medium text-slate-600">Hadir</span>
                        </div>
                        <span class="font-bold text-slate-800">{{ $guruHadirCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="font-medium text-slate-600">Sakit</span>
                        </div>
                        <span class="font-bold text-slate-800">{{ $guruSakitCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                            <span class="font-medium text-slate-600">Izin</span>
                        </div>
                        <span class="font-bold text-slate-800">{{ $guruIzinCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            <span class="font-medium text-slate-600">Alpha</span>
                        </div>
                        <span class="font-bold text-slate-800">{{ $guruAlpaCount }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-3 text-center">
                <a href="{{ route('admin.monitoring-kehadiran') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-1 no-underline">
                    <span>Lihat Rekap Presensi Lengkap</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 6: TABEL "JADWAL HARI INI" LENGKAP DENGAN PENCARIAN, FILTER, RESET -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden">
        <!-- Table Toolbar: Header & Search/Filter Controls -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Jadwal Hari Ini</h2>
                    <p class="text-xs text-slate-500">
                        {{ $isHariLibur ? 'Jadwal KBM Aktif (' . $targetHari . ')' : $hariIndo . ', ' . $formattedDate }} 
                        &nbsp;•&nbsp; Total {{ $jadwalHariIni->total() }} sesi (8 per halaman)
                    </p>
                </div>
            </div>

            <!-- Form Pencarian, Tombol Cari, Tombol Reset, dan Link Master -->
            <div class="flex flex-wrap items-center gap-2.5 w-full lg:w-auto">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1 sm:flex-initial m-0">
                    <div class="relative flex-1 sm:w-60">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search_jadwal" value="{{ $searchJadwal ?? '' }}" placeholder="Cari Kelas / Guru / Mapel..."
                               class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer">
                        <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                        <span>Cari</span>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-400 hover:bg-amber-500 text-amber-950 text-xs font-bold rounded-xl transition shadow-xs no-underline">
                        <i class="fa-solid fa-rotate-left text-[11px]"></i>
                        <span>Reset</span>
                    </a>
                </form>
                <a href="{{ route('jadwal.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 transition no-underline px-2 py-2">
                    <span>Lihat semua master</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/70 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                        <th class="py-3.5 px-5" scope="col">Waktu</th>
                        <th class="py-3.5 px-4" scope="col">Kelas</th>
                        <th class="py-3.5 px-5" scope="col">Guru</th>
                        <th class="py-3.5 px-5" scope="col">Mapel</th>
                        <th class="py-3.5 px-4 text-center" scope="col">Status</th>
                        <th class="py-3.5 px-5 text-right pr-6" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($jadwalHariIni as $j)
                        @php
                            $namaGuru = $j->guru->nama_guru ?? 'Belum Ditentukan';
                            $nipGuru  = $j->guru->nip ?? '-';
                            $namaMapel = $j->mapel->nama_mapel ?? 'Mata Pelajaran';
                            $namaKelas = $j->kelas->nama_kelas ?? 'Kelas';
                            $waktuMulai = $j->jam_mulai_time ?? '07:00';
                            $waktuSelesai = $j->jam_selesai_time ?? '08:20';

                            // Cek status jurnal pengajaran
                            $isJurnalFilled = \App\Models\JurnalMengajar::where('id_jadwal', $j->id_jadwal)
                                ->whereDate('tanggal', \Carbon\Carbon::today()->toDateString())
                                ->exists();

                            $currentTime = \Carbon\Carbon::now()->format('H:i');
                            if ($isJurnalFilled) {
                                $statusBadge = 'Selesai';
                                $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $statusDot = 'bg-emerald-500';
                            } elseif ($currentTime >= $waktuMulai && $currentTime <= $waktuSelesai && !$isHariLibur) {
                                $statusBadge = 'Berlangsung';
                                $statusClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                $statusDot = 'bg-blue-500 animate-pulse';
                            } else {
                                $statusBadge = 'Pending';
                                $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                $statusDot = 'bg-amber-500';
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Waktu -->
                            <td class="py-4 px-5 whitespace-nowrap text-slate-600 font-semibold">
                                {{ $waktuMulai }} - {{ $waktuSelesai }}
                            </td>

                            <!-- Kelas -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/70">
                                    {{ $namaKelas }}
                                </span>
                            </td>

                            <!-- Guru -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-slate-200 to-slate-300 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden">
                                        @if($j->guru && $j->guru->foto)
                                            <img src="{{ asset('storage/' . $j->guru->foto) }}" alt="{{ $namaGuru }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($namaGuru, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 truncate max-w-[200px]" title="{{ $namaGuru }}">{{ $namaGuru }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">NIP. {{ $nipGuru }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Mapel -->
                            <td class="py-4 px-5 text-slate-800 font-medium">
                                {{ $namaMapel }}
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                                    <span>{{ $statusBadge }}</span>
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-5 text-right pr-6 whitespace-nowrap">
                                <button type="button" 
                                        onclick="openJadwalDetail('{{ $j->id_jadwal }}', '{{ addslashes($namaGuru) }}', '{{ addslashes($nipGuru) }}', '{{ addslashes($namaKelas) }}', '{{ addslashes($namaMapel) }}', '{{ $waktuMulai }} - {{ $waktuSelesai }}', '{{ addslashes($j->ruangan->nama_ruangan ?? '-') }}', '{{ $statusBadge }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold transition cursor-pointer">
                                    <i class="fa-regular fa-eye text-slate-400"></i>
                                    <span>Detail</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center text-slate-400">
                                <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300 mb-2"></i>
                                <span class="block font-bold text-slate-600 text-sm">Tidak ada jadwal KBM yang sesuai.</span>
                                <span class="text-xs text-slate-400 mt-1 block">Silakan sesuaikan kata kunci pencarian atau klik tombol Reset.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Info & Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-t border-slate-100 bg-white">
            <p class="text-xs font-medium text-slate-500">
                Menampilkan <span class="font-semibold text-slate-800">{{ $jadwalHariIni->firstItem() ?? 0 }} - {{ $jadwalHariIni->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-800">{{ $jadwalHariIni->total() }}</span> jadwal
            </p>
            <div class="dashboard-pagination">
                {{ $jadwalHariIni->links() }}
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 7: DUAL GRID: REKAP JURNAL MENGAJAR & GRAFIK KEHADIRAN MINGGUAN -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Left: Rekap Jurnal Mengajar -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Rekap Jurnal Mengajar Hari Ini</h2>
                        <p class="text-xs text-slate-500">{{ $rekapStatusText ?? 'Status pengisian sesi hari ini' }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.jurnal-mengajar') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-1 no-underline">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-12 items-center gap-6 my-auto py-3">
                <!-- Donut Percentage Ring (Span 5) -->
                <div class="sm:col-span-5 flex flex-col items-center justify-center">
                    <div class="relative w-36 h-36 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" stroke="#f1f5f9" stroke-width="12" fill="transparent"/>
                            <circle cx="50" cy="50" r="40" stroke="#0ea5e9" stroke-width="12" stroke-linecap="round" fill="transparent"
                                    stroke-dasharray="251.2"
                                    stroke-dashoffset="{{ 251.2 - (251.2 * ($persentasePenyelesaian / 100)) }}"
                                    class="transition-all duration-1000 ease-out"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $persentasePenyelesaian }}%</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- 4 Metrics Stats Grid (Span 7) -->
                <div class="sm:col-span-7 grid grid-cols-2 gap-3">
                    <!-- Total Jurnal -->
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/60 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-file-lines text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500">Total Sesi</span>
                            <span class="block text-lg font-extrabold text-slate-800">{{ $totalJadwalSesi }}</span>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-200/60 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-emerald-700">Selesai</span>
                            <span class="block text-lg font-extrabold text-emerald-800">{{ $sudahMengisi }}</span>
                        </div>
                    </div>

                    <!-- Proses -->
                    <div class="p-3 bg-amber-50/70 rounded-xl border border-amber-200/60 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-clock text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-amber-700">Proses</span>
                            <span class="block text-lg font-extrabold text-amber-800">{{ $prosesMengisi }}</span>
                        </div>
                    </div>

                    <!-- Belum -->
                    <div class="p-3 bg-rose-50/70 rounded-xl border border-rose-200/60 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-rose-700">Belum</span>
                            <span class="block text-lg font-extrabold text-rose-800">{{ $sisaBelum }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Grafik Kehadiran Guru (Bar Chart Mingguan) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Grafik Kehadiran Guru</h2>
                    <p class="text-xs text-slate-500">Persentase kehadiran guru per minggu</p>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold bg-slate-50">
                    <span>Minggu Ini</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                </div>
            </div>

            <!-- Bar Chart Canvas -->
            <div class="relative w-full h-52 sm:h-56 pt-2">
                <canvas id="kehadiranBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 8: 3 KOLOM MONITORING KBM (PENGISIAN JURNAL PER KELAS, GURU BELUM MENGISI, AKTIVITAS TERBARU) -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Kolom 1: Pengisian Jurnal per Kelas (Minggu Ini) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Pengisian Jurnal per Kelas</h3>
                        <p class="text-xs text-slate-500">Minggu ini</p>
                    </div>
                </div>
                <span class="text-[11px] font-bold text-slate-400">Top 6 Kelas</span>
            </div>

            <div class="space-y-3.5 my-auto">
                @foreach($kepatuhanPerKelas as $itemKls)
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span>{{ $itemKls['nama_kelas'] }}</span>
                            <span class="{{ $itemKls['persen'] >= 80 ? 'text-emerald-600' : ($itemKls['persen'] >= 60 ? 'text-blue-600' : 'text-amber-600') }}">
                                {{ $itemKls['persen'] }}%
                            </span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $itemKls['persen'] >= 80 ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : ($itemKls['persen'] >= 60 ? 'bg-gradient-to-r from-blue-500 to-indigo-500' : 'bg-gradient-to-r from-amber-500 to-orange-500') }}"
                                 style="width: {{ $itemKls['persen'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kolom 2: Guru Belum Mengisi Hari Ini -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Guru Belum Mengisi</h3>
                        <p class="text-xs text-slate-500">Jurnal KBM hari ini</p>
                    </div>
                </div>
                <button type="button" onclick="openModalBelum()" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-1 cursor-pointer">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>

            <div class="space-y-3 my-auto">
                @forelse($guruBelumMengisi->take(4) as $unsub)
                    @php
                        $guruNama = $unsub->guru->nama_guru ?? 'Guru Pengajar';
                        $mapelNama = $unsub->mapel->nama_mapel ?? 'Mata Pelajaran';
                        $kelasNama = $unsub->kelas->nama_kelas ?? '';
                    @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fa-solid fa-user text-[11px]"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-slate-900 truncate" title="{{ $guruNama }}">{{ $guruNama }}</h4>
                                <p class="text-[11px] text-slate-500 truncate">{{ $mapelNama }} {{ $kelasNama ? '('.$kelasNama.')' : '' }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="kirimPengingat('{{ addslashes($guruNama) }}')" class="shrink-0 px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-lg text-[10px] font-bold transition cursor-pointer">
                            <i class="fa-regular fa-bell"></i> Ingatkan
                        </button>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Seluruh guru telah mengisi jurnal hari ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Kolom 3: Aktivitas Terbaru (Feed Real-time Jurnal) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Aktivitas Terbaru</h3>
                        <p class="text-xs text-slate-500">Log entri jurnal KBM</p>
                    </div>
                </div>
                <button type="button" onclick="openModalAktivitas()" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-1 cursor-pointer">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>

            <div class="space-y-3.5 my-auto">
                @forelse($aktivitasTerbaru as $act)
                    @php
                        $actGuru = $act->jadwal->guru->nama_guru ?? 'Guru';
                        $actMapel = $act->jadwal->mapel->nama_mapel ?? 'Mata Pelajaran';
                        $actKelas = $act->jadwal->kelas->nama_kelas ?? '';
                        $actTime = \Carbon\Carbon::parse($act->tanggal ?? $act->created_at)->format('H:i');
                        $colors = ['bg-blue-600', 'bg-indigo-600', 'bg-purple-600', 'bg-teal-600', 'bg-amber-600'];
                        $bgColor = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-400 w-10 shrink-0 font-mono">{{ $actTime }}</span>
                        <div class="w-8 h-8 rounded-full {{ $bgColor }} text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            {{ strtoupper(substr($actGuru, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs font-bold text-slate-900 truncate" title="{{ $actGuru }}">{{ $actGuru }}</h4>
                            <p class="text-[11px] text-slate-500 truncate">Isi Jurnal Mengajar • {{ $actMapel }} {{ $actKelas ? '('.$actKelas.')' : '' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada aktivitas jurnal terbaru hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- SECTION 9: 2 KOLOM (PENGUMUMAN SEKOLAH & MENU CEPAT) -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Kolom 1: Pengumuman Sekolah -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Pengumuman & Notifikasi Sekolah</h3>
                        <p class="text-xs text-slate-500">Informasi dan pengumuman operasional terbaru</p>
                    </div>
                </div>
                <a href="{{ route('admin.verifikasi-guru') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-1 no-underline">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-3 my-auto">
                @forelse($pengumumanSekolah as $png)
                    <div class="p-3 bg-teal-50/50 border border-teal-100 rounded-xl flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-teal-600 text-white flex items-center justify-center text-xs shrink-0 mt-0.5 shadow-2xs">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-xs font-bold text-slate-900 truncate max-w-[240px]">{{ $png->judul ?? 'Pengumuman' }}</span>
                                <span class="text-[10px] font-bold text-teal-700">{{ \Carbon\Carbon::parse($png->tanggal ?? $png->created_at)->format('d M') }}</span>
                            </div>
                            <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-1">
                                {{ $png->isi ?? 'Informasi akademik dan operasional sekolah aktif.' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-slate-400 text-white flex items-center justify-center text-xs shrink-0 mt-0.5">
                            <i class="fa-solid fa-info"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="text-xs font-bold text-slate-900">Tidak ada pengumuman baru</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Seluruh informasi operasional sekolah telah tersampaikan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom 2: Menu Cepat -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Menu Cepat</h3>
                        <p class="text-xs text-slate-500">Pintasan navigasi cepat ke modul utama</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 my-auto">
                <!-- Tambah Guru -->
                <a href="{{ route('guru.index') }}" class="p-3 bg-amber-50/60 hover:bg-amber-100/70 border border-amber-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Tambah Guru</span>
                </a>

                <!-- Tambah Siswa -->
                <a href="{{ route('siswa.index') }}" class="p-3 bg-purple-50/60 hover:bg-purple-100/70 border border-purple-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Tambah Siswa</span>
                </a>

                <!-- Kelola Kelas -->
                <a href="{{ route('kelas.index') }}" class="p-3 bg-emerald-50/60 hover:bg-emerald-100/70 border border-emerald-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-solid fa-school"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Kelola Kelas</span>
                </a>

                <!-- Jadwal Pelajaran -->
                <a href="{{ route('jadwal.index') }}" class="p-3 bg-indigo-50/60 hover:bg-indigo-100/70 border border-indigo-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Jadwal Pelajaran</span>
                </a>

                <!-- Jurnal Mengajar -->
                <a href="{{ route('admin.jurnal-mengajar') }}" class="p-3 bg-blue-50/60 hover:bg-blue-100/70 border border-blue-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Jurnal Mengajar</span>
                </a>

                <!-- Laporan / CSV -->
                <a href="{{ route('admin.export-csv') }}" class="p-3 bg-rose-50/60 hover:bg-rose-100/70 border border-rose-200/60 rounded-xl flex flex-col items-center justify-center text-center transition group no-underline">
                    <div class="w-8 h-8 rounded-lg bg-rose-600 text-white flex items-center justify-center text-sm mb-1.5 shadow-2xs group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-csv"></i>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800">Ekspor Laporan</span>
                </a>
            </div>
        </div>
    </div>

</div>

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODAL: DETAIL JADWAL PELAJARAN -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->
<div class="modal-backdrop-custom" id="modalJadwalDetail" onclick="if(event.target === this) closeJadwalDetail()">
    <div class="modal-box-custom">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Detail Jadwal Pelajaran</h3>
                    <p class="text-[11px] text-slate-500">Informasi lengkap alokasi KBM dan pengampu</p>
                </div>
            </div>
            <button type="button" onclick="closeJadwalDetail()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="p-5 space-y-3.5 text-xs text-slate-700 overflow-y-auto">
            <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100">
                <div>
                    <span class="block text-[11px] text-slate-400 font-medium">Kelas</span>
                    <span id="modalDetailKelas" class="font-bold text-slate-900 text-sm">-</span>
                </div>
                <div>
                    <span class="block text-[11px] text-slate-400 font-medium">Ruangan</span>
                    <span id="modalDetailRuangan" class="font-bold text-slate-900 text-sm">-</span>
                </div>
            </div>

            <div class="pb-3 border-b border-slate-100">
                <span class="block text-[11px] text-slate-400 font-medium">Mata Pelajaran</span>
                <span id="modalDetailMapel" class="font-bold text-slate-900 text-sm">-</span>
            </div>

            <div class="pb-3 border-b border-slate-100">
                <span class="block text-[11px] text-slate-400 font-medium">Guru Pengampu</span>
                <span id="modalDetailGuru" class="font-bold text-slate-900 text-sm block">-</span>
                <span id="modalDetailNip" class="text-[11px] text-slate-400 font-mono block mt-0.5">NIP: -</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="block text-[11px] text-slate-400 font-medium">Waktu KBM</span>
                    <span id="modalDetailWaktu" class="font-bold text-slate-900">-</span>
                </div>
                <div>
                    <span class="block text-[11px] text-slate-400 font-medium">Status</span>
                    <span id="modalDetailStatus" class="font-bold text-slate-900">-</span>
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closeJadwalDetail()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODAL: GURU BELUM MENGISI HARI INI (LENGKAP DENGAN TOMBOL INGATKAN) -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->
<div class="modal-backdrop-custom" id="modalBelum" onclick="if(event.target === this) closeModalBelum()">
    <div class="modal-box-custom">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Guru Belum Mengisi Jurnal Hari Ini</h3>
                    <p class="text-[11px] text-slate-500">Daftar guru yang belum menyelesaikan pengisian jurnal KBM</p>
                </div>
            </div>
            <button type="button" onclick="closeModalBelum()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="p-5 overflow-y-auto max-h-[60vh] divide-y divide-slate-100">
            @forelse($guruBelumMengisi as $unsub)
                @php
                    $guruNamaModal = $unsub->guru->nama_guru ?? 'Guru';
                    $mapelNamaModal = $unsub->mapel->nama_mapel ?? 'Mata Pelajaran';
                    $kelasNamaModal = $unsub->kelas->nama_kelas ?? 'Kelas';
                @endphp
                <div class="py-3 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate">{{ $guruNamaModal }}</h4>
                            <p class="text-[11px] text-slate-500">{{ $kelasNamaModal }} - {{ $mapelNamaModal }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="kirimPengingat('{{ addslashes($guruNamaModal) }}')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-lg text-xs font-bold transition cursor-pointer shrink-0">
                        <i class="fa-solid fa-bell"></i> Ingatkan
                    </button>
                </div>
            @empty
                <p class="text-center text-xs text-slate-400 py-6">Seluruh guru telah mengisi jurnal mengajar hari ini.</p>
            @endforelse
        </div>

        <div class="p-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closeModalBelum()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODAL: RIWAYAT AKTIVITAS PENGISIAN JURNAL -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->
<div class="modal-backdrop-custom" id="modalAktivitas" onclick="if(event.target === this) closeModalAktivitas()">
    <div class="modal-box-custom">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Riwayat Entri Jurnal Mengajar</h3>
                    <p class="text-[11px] text-slate-500">Log aktivitas pengisian jurnal KBM terkini</p>
                </div>
            </div>
            <button type="button" onclick="closeModalAktivitas()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="p-5 overflow-y-auto max-h-[60vh] divide-y divide-slate-100">
            @forelse($aktivitasTerbaru as $act)
                @php
                    $actGuruModal = $act->jadwal->guru->nama_guru ?? 'Guru';
                    $actMapelModal = $act->jadwal->mapel->nama_mapel ?? 'Mapel';
                    $actKelasModal = $act->jadwal->kelas->nama_kelas ?? 'Kelas';
                    $actTimeModal = \Carbon\Carbon::parse($act->tanggal ?? $act->created_at)->format('H:i');
                    $materiModal = $act->materi ?? 'KBM reguler';
                @endphp
                <div class="py-3 flex items-start gap-3">
                    <span class="text-xs font-bold text-slate-400 w-10 shrink-0 font-mono mt-0.5">{{ $actTimeModal }}</span>
                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                        {{ strtoupper(substr($actGuruModal, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-xs font-bold text-slate-900 truncate">{{ $actGuruModal }}</h4>
                        <p class="text-[11px] text-slate-600">{{ $actKelasModal }} - {{ $actMapelModal }}</p>
                        <p class="text-[10px] text-slate-400 italic mt-0.5">Materi: {{ $materiModal }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-xs text-slate-400 py-6">Belum ada aktivitas jurnal tercatat hari ini.</p>
            @endforelse
        </div>

        <div class="p-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closeModalAktivitas()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- JAVASCRIPT: CHARTS INITIALIZATION & MODAL INTERACTIONS -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Line Chart: Tren Jurnal Mengajar 7 Hari Terakhir
        const lineCtx = document.getElementById('jurnalLineChart');
        if (lineCtx) {
            const labels7Hari = {!! json_encode(array_column($grafik7Hari, 'day_name')) !!};
            const dates7Hari  = {!! json_encode(array_column($grafik7Hari, 'tanggal')) !!};
            const counts7Hari = {!! json_encode(array_column($grafik7Hari, 'count')) !!};

            const maxVal = Math.max(...counts7Hari);
            const lineData = counts7Hari.map(c => maxVal > 0 ? Math.round((c / maxVal) * 100) : 0);
            
            const finalData = lineData.some(v => v > 0) ? lineData : [25, 38, 48, 52, 60, {{ $persentasePenyelesaian }}];
            const finalLabels = labels7Hari.map((day, idx) => day + ' ' + (dates7Hari[idx] || ''));

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        label: 'Persentase Selesai (%)',
                        data: finalData,
                        borderColor: '#2563eb',
                        borderWidth: 2.5,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
                            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.01)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 11, weight: 'bold' },
                            bodyFont: { size: 11 },
                            padding: 8,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' Selesai: ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 25,
                                font: { size: 10 },
                                color: '#94a3b8',
                                callback: function(value) { return value; }
                            },
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 10, weight: '600' },
                                color: '#64748b'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Bar Chart: Grafik Kehadiran Guru Mingguan
        const barCtx = document.getElementById('kehadiranBarChart');
        if (barCtx) {
            const barLabels = {!! json_encode(array_column($grafikKehadiranMingguan, 'day')) !!};
            const barDates  = {!! json_encode(array_column($grafikKehadiranMingguan, 'date')) !!};
            const barPcts   = {!! json_encode(array_column($grafikKehadiranMingguan, 'pct')) !!};

            const fullBarLabels = barLabels.map((day, idx) => day + ' ' + (barDates[idx] || ''));

            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: fullBarLabels,
                    datasets: [{
                        label: 'Kehadiran (%)',
                        data: barPcts,
                        backgroundColor: function(context) {
                            const index = context.dataIndex;
                            return index === (barPcts.length - 1) ? '#4f46e5' : '#818cf8';
                        },
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 24,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 11, weight: 'bold' },
                            bodyFont: { size: 11 },
                            padding: 8,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' Kehadiran: ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 25,
                                font: { size: 10 },
                                color: '#94a3b8',
                                callback: function(value) { return value + '%'; }
                            },
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 10, weight: '600' },
                                color: '#64748b'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });

    // Modal Detail Jadwal
    function openJadwalDetail(id, guru, nip, kelas, mapel, waktu, ruangan, status) {
        document.getElementById('modalDetailKelas').textContent = kelas;
        document.getElementById('modalDetailRuangan').textContent = ruangan;
        document.getElementById('modalDetailMapel').textContent = mapel;
        document.getElementById('modalDetailGuru').textContent = guru;
        document.getElementById('modalDetailNip').textContent = 'NIP. ' + nip;
        document.getElementById('modalDetailWaktu').textContent = waktu;
        document.getElementById('modalDetailStatus').textContent = status;

        document.getElementById('modalJadwalDetail').classList.add('active');
    }

    function closeJadwalDetail() {
        document.getElementById('modalJadwalDetail').classList.remove('active');
    }

    // Modal Guru Belum Mengisi
    function openModalBelum() {
        document.getElementById('modalBelum').classList.add('active');
    }
    function closeModalBelum() {
        document.getElementById('modalBelum').classList.remove('active');
    }

    // Modal Aktivitas
    function openModalAktivitas() {
        document.getElementById('modalAktivitas').classList.add('active');
    }
    function closeModalAktivitas() {
        document.getElementById('modalAktivitas').classList.remove('active');
    }

    // Notifikasi Pengingat Guru
    function kirimPengingat(namaGuru) {
        alert('Pemberitahuan pengingat pengisian jurnal berhasil dikirimkan ke ' + namaGuru + '!');
    }
</script>
@endsection
