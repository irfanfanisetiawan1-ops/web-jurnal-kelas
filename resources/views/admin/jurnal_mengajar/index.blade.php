@extends('layouts.admin')

@section('title', 'Akademik - Jurnal Mengajar — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter & Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', '-apple-system', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              900: '#1e293b',
              navy: '#0f2744'
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

<style data-purpose="custom-scrollbars">
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Modal Backdrop & Animation */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-box {
        animation: modalFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96) translateY(6px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .alpa-page-btn {
        min-width: 28px;
        height: 28px;
        padding: 0 6px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
    }
    .alpa-page-btn:hover:not(:disabled) {
        background: #f1f5f9;
        color: #0f172a;
    }
    .alpa-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.3);
    }
    .alpa-page-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title text-base font-extrabold text-slate-900 tracking-tight leading-none m-0 p-0">
        Akademik — Jurnal Mengajar
    </h1>
</div>
@endsection

@section('content')

<div class="space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="flex items-center justify-between gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                    </svg>
                </span>
                <span class="flex-1">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center justify-between gap-3 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center shrink-0 text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"/>
                    </svg>
                </span>
                <span class="flex-1">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
    @endif

    <!-- BEGIN: Card 1 - Laporan Guru Alpa (Collapsible) -->
    <section class="bg-white border border-rose-200/80 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4" data-purpose="laporan-guru-alpa">
        <!-- Section Header Summary Row -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-3 border-b border-slate-100">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                    <span class="material-symbols-outlined text-2xl">warning</span>
                </div>
                <div>
                    <div class="flex items-center flex-wrap gap-2">
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Laporan Guru Alpa</h3>
                        <span class="text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200">
                            {{ \Carbon\Carbon::parse($targetTanggal ?? now())->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        @if($guruAlpaList->count() > 0)
                            <span class="font-bold text-rose-600">{{ $guruAlpaList->count() }} pendidik</span> belum mengisi jurnal mengajar pada jam KBM yang telah terjadwal.
                        @else
                            <span class="font-semibold text-emerald-600">Semua guru mengajar telah mengisi jurnal</span> pada tanggal ini.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="flex items-center flex-wrap gap-2 self-start md:self-auto">
                <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" class="flex items-center gap-2">
                    <input type="date" name="tanggal" value="{{ $targetTanggal ?? \Carbon\Carbon::today()->toDateString() }}" class="text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:ring-blue-500 focus:border-blue-500 shadow-2xs" title="Pilih Tanggal Laporan Alpa">
                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-2xs transition-all cursor-pointer">
                        Filter
                    </button>
                    <a href="{{ route('admin.jurnal-mengajar') }}" class="px-3.5 py-2 text-xs font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 border border-amber-200 rounded-xl shadow-2xs transition-all cursor-pointer no-underline">
                        Hari Ini
                    </a>
                </form>
            </div>
        </div>

        <!-- Table Content Wrapper (Always Visible) -->
        <div id="alpaTableWrapper" class="space-y-4 pt-1">
            <!-- Table Container -->
            <div class="overflow-x-auto rounded-xl border border-slate-200/80 shadow-2xs">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-4 py-3 w-20 text-center">JAM</th>
                            <th class="px-4 py-3">GURU &amp; MATA PELAJARAN</th>
                            <th class="px-4 py-3 w-36">KELAS</th>
                            <th class="px-4 py-3 text-center w-64">STATUS KBM</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="tbodyGuruAlpa">
                        @forelse($guruAlpaList as $alpa)
                            <tr class="hover:bg-slate-50/60 transition-colors alpa-row">
                                <td class="px-4 py-3 text-center font-bold text-slate-700 bg-slate-50/40">
                                    {{ $alpa->jam_range ?? ($alpa->id_jam_mulai ? ($alpa->id_jam_mulai . ' - ' . $alpa->id_jam_selesai) : '-') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-slate-900">{{ $alpa->guru->nama_guru ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $alpa->mapel->nama_mapel ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-800">
                                    {{ $alpa->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block px-3 py-1 text-xs font-bold text-rose-700 bg-rose-50 border border-rose-200 rounded-full tracking-wide whitespace-nowrap">
                                        TIDAK MENGISI JURNAL (ALPA)
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-emerald-700 font-semibold bg-emerald-50/40">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-emerald-600 text-[20px]">check_circle</span>
                                        <span>Semua guru mengajar telah mengisi jurnal pada tanggal ini!</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Alpa Table Pagination Footer -->
            @if($guruAlpaList->count() > 0)
                <div class="flex items-center justify-between flex-wrap gap-2 pt-1 text-xs text-slate-500" id="alpaPaginationWrapper">
                    <div>
                        Menampilkan <span class="font-semibold text-slate-800" id="alpaShowingCount">{{ min(5, $guruAlpaList->count()) }}</span> dari <span class="font-semibold text-slate-800">{{ $guruAlpaList->count() }}</span> guru yang belum mengisi jurnal
                    </div>
                    <div class="inline-flex items-center gap-1 bg-slate-50 border border-slate-200 rounded-xl p-1 text-xs shadow-2xs">
                        <button type="button" class="alpa-page-btn" id="alpaPrevBtn" title="Halaman Sebelumnya">&lt;</button>
                        <div id="alpaPageNumbers" class="inline-flex items-center gap-1"></div>
                        <button type="button" class="alpa-page-btn" id="alpaNextBtn" title="Halaman Selanjutnya">&gt;</button>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- END: Card 1 - Laporan Guru Alpa -->

    <!-- BEGIN: 4 Metric Cards (Clickable Filter) -->
    @php
        $currStatus = request('status');
    @endphp
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" data-purpose="kbm-filter-and-metrics">
        <!-- Card 1: Total Pertemuan -->
        <a href="{{ route('admin.jurnal-mengajar', request()->except('status', 'page')) }}" 
           class="bg-white border {{ empty($currStatus) ? 'border-indigo-400 ring-2 ring-indigo-500/20 bg-indigo-50/20' : 'border-slate-200/80 hover:border-indigo-300' }} rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all no-underline group cursor-pointer"
           title="Klik untuk tampilkan semua pertemuan (Reset filter status)">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 group-hover:bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 transition-colors">
                <span class="material-symbols-outlined text-2xl">menu_book</span>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pertemuan</div>
                <div class="text-xl font-black text-slate-900 mt-0.5 leading-tight">
                    {{ $totalPertemuan }} <span class="text-xs font-semibold text-slate-400 font-normal">Pertemuan</span>
                </div>
                @if(empty($currStatus))
                    <div class="text-[10.5px] text-indigo-600 font-bold mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span> Filter Aktif (Semua)
                    </div>
                @endif
            </div>
        </a>

        <!-- Card 2: Terlaksana -->
        <a href="{{ route('admin.jurnal-mengajar', array_merge(request()->query(), ['status' => 'Terlaksana', 'page' => 1])) }}" 
           class="bg-white border {{ $currStatus === 'Terlaksana' ? 'border-emerald-400 ring-2 ring-emerald-500/20 bg-emerald-50/20' : 'border-slate-200/80 hover:border-emerald-300' }} rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all no-underline group cursor-pointer"
           title="Klik untuk filter hanya pertemuan Terlaksana (Hadir)">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 group-hover:bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0 transition-colors">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Terlaksana</div>
                <div class="text-xl font-black text-slate-900 mt-0.5 leading-tight">
                    {{ $terlaksanaCount }} <span class="text-xs font-semibold text-slate-400 font-normal">Pertemuan</span>
                </div>
                @if($currStatus === 'Terlaksana')
                    <div class="text-[10.5px] text-emerald-600 font-bold mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Filter Aktif (Hadir)
                    </div>
                @endif
            </div>
        </a>

        <!-- Card 3: Belum Terlaksana -->
        <a href="{{ route('admin.jurnal-mengajar', array_merge(request()->query(), ['status' => 'Belum Terlaksana', 'page' => 1])) }}" 
           class="bg-white border {{ $currStatus === 'Belum Terlaksana' ? 'border-amber-400 ring-2 ring-amber-500/20 bg-amber-50/20' : 'border-slate-200/80 hover:border-amber-300' }} rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all no-underline group cursor-pointer"
           title="Klik untuk filter pertemuan Belum Terlaksana (Izin/Sakit/Alpa)">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center text-amber-600 shrink-0 transition-colors">
                <span class="material-symbols-outlined text-2xl">pending_actions</span>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Terlaksana</div>
                <div class="text-xl font-black text-slate-900 mt-0.5 leading-tight">
                    {{ $belumTerlaksanaCount }} <span class="text-xs font-semibold text-slate-400 font-normal">Pertemuan</span>
                </div>
                @if($currStatus === 'Belum Terlaksana')
                    <div class="text-[10.5px] text-amber-600 font-bold mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Filter Aktif (Izin/Sakit/Alpa)
                    </div>
                @endif
            </div>
        </a>

        <!-- Card 4: Guru Aktif Mengajar (Statis Informatif) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center gap-4 shadow-sm cursor-default" title="Jumlah guru unik yang aktif mengajar">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                <span class="material-symbols-outlined text-2xl">person</span>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guru Aktif Mengajar</div>
                <div class="text-xl font-black text-slate-900 mt-0.5 leading-tight">
                    {{ $guruAktifCount }} <span class="text-xs font-semibold text-slate-400 font-normal">Guru</span>
                </div>
            </div>
        </div>
    </section>
    <!-- END: 4 Metric Cards -->

    <!-- BEGIN: MainSavedJournalSection - Daftar Jurnal Tersimpan -->
    <section class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-5 sm:p-6 space-y-5" data-purpose="jurnal-tersimpan-table-card">
        <!-- Title, Counter & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-100">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                    <span class="material-symbols-outlined text-2xl">menu_book</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span>Daftar Jurnal Tersimpan</span>
                        <span class="text-xs font-extrabold text-blue-700 bg-blue-50 border border-blue-200/80 px-2.5 py-0.5 rounded-full">({{ $jurnals->total() }})</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Verifikasi dan pantau riwayat materi serta kehadiran KBM guru per pertemuan.</p>
                </div>
            </div>

            <!-- Header Action Buttons (Export Rekap uses consistent project palette, NOT green) -->
            <div class="flex items-center flex-wrap gap-2.5">
                <!-- 1. Export Rekap Button -->
                <a href="{{ route('admin.jurnal-mengajar.export', request()->query()) }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-2xs transition-all cursor-pointer no-underline hover:border-slate-300"
                   title="Export Rekap Jurnal Mengajar ke Excel">
                    <span class="material-symbols-outlined text-[17px] text-slate-500">file_download</span>
                    <span>Export Rekap</span>
                </a>

                <!-- 2. Tambah Jurnal Button -->
                <button type="button" onclick="openCreateModal()" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-2xs transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[17px]">post_add</span>
                    <span>Tambah Jurnal</span>
                </button>
            </div>
        </div>

        <!-- Filter & Search Toolbar (Search flex-1, dropdowns follow, Cari & Reset grouped right) -->
        <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" class="w-full flex flex-wrap items-center gap-2.5 pt-1">
            <!-- Search Input: flex-1 min-w-[200px] -->
            <div class="relative flex-1 min-w-[180px]">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       class="w-full text-xs rounded-xl border-slate-200 pl-9 pr-3 py-2 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 text-slate-700 placeholder:text-slate-400" 
                       placeholder="Cari Materi / Guru / Mapel...">
            </div>

            <!-- Date Selector -->
            <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" 
                   class="text-xs rounded-xl border-slate-200 py-2 px-2.5 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50" 
                   title="Filter Tanggal Pertemuan">

            <!-- Guru Select -->
            <select name="id_guru" class="text-xs rounded-xl border-slate-200 py-2 px-2 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 max-w-[145px]">
                <option value="">Semua Guru</option>
                @foreach($guruList as $g)
                    <option value="{{ $g->id_guru }}" {{ ($idGuru == $g->id_guru) ? 'selected' : '' }}>
                        {{ $g->nama_guru }}
                    </option>
                @endforeach
            </select>

            <!-- Kelas Select -->
            <select name="id_kelas" class="text-xs rounded-xl border-slate-200 py-2 px-2 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 max-w-[125px]">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ ($idKelas == $k->id_kelas) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <!-- Mapel Select -->
            <select name="id_mapel" class="text-xs rounded-xl border-slate-200 py-2 px-2 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 max-w-[135px]">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $m)
                    <option value="{{ $m->id_mapel }}" {{ ($idMapel == $m->id_mapel) ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>

            <!-- Status Select -->
            <select name="status" class="text-xs rounded-xl border-slate-200 py-2 px-2 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 max-w-[135px]">
                <option value="">Semua Status</option>
                <option value="Terlaksana" {{ ($status == 'Terlaksana') ? 'selected' : '' }}>Terlaksana (Hadir)</option>
                <option value="Belum Terlaksana" {{ ($status == 'Belum Terlaksana') ? 'selected' : '' }}>Belum Terlaksana (Izin/Sakit/Alpa)</option>
            </select>

            <!-- Buttons Group: Cari and Reset kept together on the right -->
            <div class="flex items-center gap-2 ml-auto shrink-0">
                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-2xs cursor-pointer">
                    <span class="material-symbols-outlined text-[15px]">search</span>
                    <span>Cari</span>
                </button>

                @if(!empty($search) || !empty($tanggal) || !empty($idGuru) || !empty($idKelas) || !empty($idMapel) || !empty($status))
                    <a href="{{ route('admin.jurnal-mengajar') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 transition-all cursor-pointer no-underline" title="Reset semua filter">
                        <span class="material-symbols-outlined text-[15px]">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Main DataTable Container (overflow-x-auto ensures nothing is cut off on <=1366px screens) -->
        <div class="overflow-x-auto border border-slate-200/80 rounded-xl shadow-2xs">
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-slate-50/90 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-2.5 whitespace-nowrap w-[90px]">TANGGAL</th>
                        <th class="py-3 px-2.5 whitespace-nowrap min-w-[140px]">GURU &amp; MAPEL</th>
                        <th class="py-3 px-2.5 whitespace-nowrap w-[75px]">KELAS</th>
                        <th class="py-3 px-2.5 whitespace-nowrap w-[80px]">STATUS</th>
                        <th class="py-3 px-2.5 whitespace-nowrap min-w-[180px] max-w-[260px]">MATERI / CATATAN PEMBELAJARAN</th>
                        <th class="py-3 px-2.5 whitespace-nowrap w-[105px]">SISWA TIDAK HADIR</th>
                        <th class="py-3 px-2.5 text-center whitespace-nowrap w-[185px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($jurnals as $j)
                        @php
                            $isHadir = ($j->status_kehadiran_guru === 'Hadir');
                            $guruName = $j->jadwal->guru->nama_guru ?? '-';
                            $mapelName = $j->jadwal->mapel->nama_mapel ?? '-';
                            $kelasName = $j->jadwal->kelas->nama_kelas ?? '-';
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- 1. Tanggal -->
                            <td class="py-3 px-2.5 font-semibold text-slate-800 whitespace-nowrap text-[11.5px]">
                                {{ \Carbon\Carbon::parse($j->tanggal)->format('Y-m-d') }}
                            </td>

                            <!-- 2. Guru & Mapel -->
                            <td class="py-3 px-2.5">
                                <div class="font-bold text-slate-900 leading-tight">{{ $guruName }}</div>
                                <div class="text-[11px] text-slate-500">{{ $mapelName }}</div>
                            </td>

                            <!-- 3. Kelas -->
                            <td class="py-3 px-2.5 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $kelasName }}
                            </td>

                            <!-- 4. Status (Hadir text-only green, other statuses colored pill) -->
                            <td class="py-3 px-2.5 whitespace-nowrap">
                                @if($isHadir)
                                    <span class="text-emerald-600 font-bold whitespace-nowrap flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Hadir</span>
                                    </span>
                                @elseif($j->status_kehadiran_guru === 'Izin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Izin
                                    </span>
                                @elseif($j->status_kehadiran_guru === 'Sakit')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                        Sakit
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ $j->status_kehadiran_guru }}
                                    </span>
                                @endif
                            </td>
<<<<<<< HEAD
                            <td>
                                @if($j->dokumentasi_url)
                                    <img src="{{ $j->dokumentasi_url }}" class="photo-thumb-box" alt="Bukti Foto">
                                @else
                                    <div class="photo-thumb-box" title="Foto tidak diupload"></div>
                                @endif
=======

                            <!-- 5. Materi & Catatan (Merged with Photo Preview Icon & 1-line truncation with native title tooltip) -->
                            <td class="py-3 px-2.5">
                                <div class="flex items-center gap-2">
                                    @if($j->dokumentasi)
                                        <button type="button" 
                                                onclick="previewImage('{{ asset('storage/' . $j->dokumentasi) }}', 'Bukti Foto {{ addslashes($guruName) }} - {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}')" 
                                                class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 hover:border-blue-400 shrink-0 flex items-center justify-center text-slate-400 hover:text-blue-600 transition overflow-hidden shadow-2xs cursor-pointer group" 
                                                title="Klik untuk pratinjau bukti foto">
                                            <img src="{{ asset('storage/' . $j->dokumentasi) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="Foto">
                                        </button>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="font-semibold text-slate-800 truncate max-w-[200px]" title="{{ $j->materi }}">
                                            {{ $j->materi }}
                                        </div>
                                        @if($j->catatan)
                                            <div class="text-[10.5px] text-slate-500 truncate max-w-[200px]" title="{{ $j->catatan }}">
                                                {{ $j->catatan }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                            </td>

                            <!-- 6. Siswa Tidak Hadir -->
                            <td class="py-3 px-2.5">
                                @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                                    <div class="space-y-0.5 max-w-[120px]">
                                        @foreach($j->detailKetidakhadiran as $d)
                                            <span class="text-rose-600 font-bold block whitespace-nowrap text-[10.5px]">
                                                {{ $d->siswa->nama_siswa ?? 'Siswa' }} ({{ strtolower($d->keterangan) }})
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-emerald-600 font-semibold whitespace-nowrap">nihil</span>
                                @endif
                            </td>

                            <!-- 7. Aksi (Inline Visible Action Buttons: Lihat, Cetak, Hapus - No 3-Dots Dropdown!) -->
                            <td class="py-3 px-2.5 text-center">
                                <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                    <!-- 1. LIHAT (Detail) -->
                                    <button type="button" onclick="openDetailModal({{ $j->id_jurnal }})" 
                                            class="inline-flex items-center gap-1 bg-cyan-50 hover:bg-cyan-100 text-cyan-800 border border-cyan-200/80 px-2 py-1 rounded-lg text-xs font-semibold transition-colors cursor-pointer" 
                                            title="Lihat Detail Jurnal">
                                        <span class="material-symbols-outlined text-[13px] text-cyan-600">visibility</span>
                                        <span>Lihat</span>
                                    </button>

                                    <!-- 2. CETAK PDF -->
                                    <a href="{{ route('admin.jurnal-mengajar.print-detail', $j->id_jurnal) }}" target="_blank" 
                                       class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 px-2 py-1 rounded-lg text-xs font-semibold transition-colors no-underline cursor-pointer" 
                                       title="Cetak / Unduh PDF">
                                        <span class="material-symbols-outlined text-[13px] text-emerald-600">print</span>
                                        <span>Cetak</span>
                                    </a>

                                    <!-- 3. HAPUS -->
                                    <form action="{{ route('admin.jurnal-mengajar.destroy', $j->id_jurnal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 px-2 py-1 rounded-lg text-xs font-semibold transition-colors cursor-pointer" 
                                                title="Hapus Jurnal">
                                            <span class="material-symbols-outlined text-[13px] text-rose-600">delete</span>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">folder_open</span>
                                <span class="font-medium text-xs">Tidak ada data jurnal tersimpan yang ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- DataTable Footer Pagination (Styling identical to Master Data Siswa / Kelas) -->
        <div class="flex items-center justify-between flex-wrap gap-4 pt-2 text-xs text-slate-500">
            <div>
                Menampilkan <span class="font-semibold text-slate-800">{{ $jurnals->firstItem() ?? 0 }} - {{ $jurnals->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-800">{{ $jurnals->total() }}</span> data jurnal
            </div>
            <div>
                {{ $jurnals->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
    <!-- END: MainSavedJournalSection -->

</div>

<!-- Modal 1: Detail Jurnal Popup -->
<div class="modal-overlay" id="detailModal">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-xl relative">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">menu_book</span>
                </div>
                <h3 class="text-base font-bold text-slate-900">Detail Jurnal Mengajar</h3>
            </div>
            <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeDetailModal()">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <div id="modalDetailContent">
            <div class="text-center py-10 text-slate-500">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 text-blue-600"></i>
                <p class="text-xs">Memuat detail jurnal...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Tambah Jurnal Mengajar Baru -->
<div class="modal-overlay" id="createModal">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-xl relative">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">post_add</span>
                </div>
                <h3 class="text-base font-bold text-slate-900">Tambah Jurnal Mengajar Baru</h3>
            </div>
            <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeCreateModal()">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form action="{{ route('admin.jurnal-mengajar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Pilih Jadwal Pelajaran *</label>
                <select name="id_jadwal" class="w-full text-xs rounded-xl border-slate-200 py-2.5 px-3 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50" required>
                    <option value="">-- Pilih Jadwal (Guru, Mapel, Kelas) --</option>
                    @foreach($jadwalList as $jadwal)
                        <option value="{{ $jadwal->id_jadwal }}">
                            {{ $jadwal->hari }} | {{ $jadwal->kelas->nama_kelas ?? '-' }} - {{ $jadwal->mapel->nama_mapel ?? '-' }} ({{ $jadwal->guru->nama_guru ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Mengajar *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-xl border-slate-200 py-2.5 px-3 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50" required>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Kehadiran Guru *</label>
                    <select name="status_kehadiran_guru" class="w-full text-xs rounded-xl border-slate-200 py-2.5 px-3 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50" required>
                        <option value="Hadir" selected>Hadir (Terlaksana)</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Tanpa Keterangan">Tanpa Keterangan (Alpa)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Materi Pembelajaran *</label>
                <textarea name="materi" rows="3" class="w-full text-xs rounded-xl border-slate-200 py-2.5 px-3 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 font-sans" placeholder="Tuliskan materi pembelajaran yang disampaikan..." required></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Catatan Pembelajaran / Kejadian <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <textarea name="catatan" rows="2" class="w-full text-xs rounded-xl border-slate-200 py-2.5 px-3 text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50/50 font-sans" placeholder="Tuliskan catatan kejadian kelas jika ada..."></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Upload Foto Dokumentasi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <input type="file" name="dokumentasi" accept="image/*" class="w-full text-xs text-slate-600 rounded-xl border border-slate-200 py-2 px-3 bg-slate-50/50 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer" onclick="closeCreateModal()">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-2xs transition cursor-pointer">
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Foto Dokumentasi Lightbox Preview -->
<div class="modal-overlay" id="imagePreviewModal" onclick="closeImagePreview()">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-4 shadow-2xl relative" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
            <h4 class="text-xs font-bold text-slate-800" id="imagePreviewTitle">Bukti Foto Dokumentasi</h4>
            <button type="button" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeImagePreview()">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <div class="rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center max-h-[70vh]">
            <img id="previewModalImg" src="" alt="Pratinjau Foto" class="max-w-full max-h-[70vh] object-contain">
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ── Image Preview Lightbox ────────────────────────────────────
    function previewImage(url, title) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('previewModalImg');
        const titleEl = document.getElementById('imagePreviewTitle');

        if (modal && img) {
            img.src = url;
            if (titleEl && title) titleEl.textContent = title;
            modal.classList.add('active');
        }
    }

    function closeImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        if (modal) modal.classList.remove('active');
    }

    // ── Detail Modal AJAX ─────────────────────────────────────────
    function openDetailModal(idJurnal) {
        const modal = document.getElementById('detailModal');
        const container = document.getElementById('modalDetailContent');

        modal.classList.add('active');
        container.innerHTML = `
            <div class="text-center py-10 text-slate-500">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 text-blue-600"></i>
                <p class="text-xs">Memuat detail jurnal...</p>
            </div>
        `;

        fetch(`{{ url('/admin/jurnal-mengajar-admin/detail') }}/${idJurnal}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const d = res.data;
                let absensiHtml = '';
                if (d.absensi_siswa && d.absensi_siswa.length > 0) {
                    absensiHtml = d.absensi_siswa.map((s, idx) => `
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-3 py-2 border-b border-slate-100 text-center">${idx + 1}</td>
                            <td class="px-3 py-2 border-b border-slate-100 font-bold text-slate-800">${s.nama_siswa}</td>
                            <td class="px-3 py-2 border-b border-slate-100 text-slate-500">${s.nis}</td>
                            <td class="px-3 py-2 border-b border-slate-100 font-bold text-rose-600">${s.keterangan}</td>
                        </tr>
                    `).join('');
                } else {
                    absensiHtml = `<tr><td colspan="4" class="text-center text-emerald-700 font-bold py-3 bg-emerald-50/40">Semua siswa hadir (Nihil)</td></tr>`;
                }

                let photoHtml = '';
                if (d.dokumentasi_url) {
                    photoHtml = `
                        <div class="mt-4 text-center">
                            <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">FOTO BUKTI DOKUMENTASI</span>
                            <img src="${d.dokumentasi_url}" class="max-w-full max-h-56 rounded-xl border border-slate-200 mx-auto object-cover shadow-2xs">
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">TANGGAL</span>
                            <strong class="text-xs text-slate-800">${d.tanggal}</strong>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">STATUS GURU</span>
                            <strong class="text-xs ${d.status_kehadiran_guru === 'Hadir' ? 'text-emerald-700' : 'text-rose-700'}">${d.status_kehadiran_guru}</strong>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">GURU PENGAJAR</span>
                            <strong class="text-xs text-slate-800">${d.guru}</strong>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">MATA PELAJARAN</span>
                            <strong class="text-xs text-slate-800">${d.mapel}</strong>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">KELAS & RUANGAN</span>
                            <strong class="text-xs text-slate-800">${d.kelas} — Ruang ${d.ruangan}</strong>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">JAM KE-</span>
                            <strong class="text-xs text-slate-800">Jam Ke-${d.jam_ke}</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1">MATERI PEMBELAJARAN</span>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-800 leading-relaxed">${d.materi}</div>
                    </div>

                    <div class="mb-3">
                        <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1">CATATAN PEMBELAJARAN</span>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-600 leading-relaxed">${d.catatan || '<span class="text-slate-400 italic">Tidak ada catatan khusus.</span>'}</div>
                    </div>

                    <div class="mb-3">
                        <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">DAFTAR SISWA TIDAK HADIR</span>
                        <div class="border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-100/80 text-[10.5px] font-bold text-slate-500 uppercase tracking-wider">
                                        <th class="px-3 py-2 w-10 text-center">NO</th>
                                        <th class="px-3 py-2">NAMA SISWA</th>
                                        <th class="px-3 py-2 w-28">NISN</th>
                                        <th class="px-3 py-2 w-28">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>${absensiHtml}</tbody>
                            </table>
                        </div>
                    </div>

                    ${photoHtml}

                    <div class="flex justify-end gap-2 pt-4 mt-4 border-t border-slate-100">
                        <a href="{{ url('/admin/jurnal-mengajar-admin/print-detail') }}/${d.id_jurnal}" target="_blank" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-2xs no-underline">
                            <span class="material-symbols-outlined text-[16px]">print</span>
                            <span>Cetak PDF / Detail</span>
                        </a>
                    </div>
                `;
            }
        })
        .catch(err => {
            container.innerHTML = `<p class="text-rose-600 text-center py-6 text-xs font-semibold">Gagal memuat detail jurnal. Silakan coba kembali.</p>`;
        });
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        if (modal) modal.classList.remove('active');
    }

    // ── Create Modal ──────────────────────────────────────────────
    function openCreateModal() {
        const modal = document.getElementById('createModal');
        if (modal) modal.classList.add('active');
    }

    function closeCreateModal() {
        const modal = document.getElementById('createModal');
        if (modal) modal.classList.remove('active');
    }

    // Close modal on Escape key press
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDetailModal();
            closeCreateModal();
            closeImagePreview();
        }
    });

    // ── Pagination for Laporan Guru Alpa Table ─────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 5;
        const rows = document.querySelectorAll('#tbodyGuruAlpa tr.alpa-row');
        const totalRows = rows.length;
        const paginationWrapper = document.getElementById('alpaPaginationWrapper');
        const pageNumbersContainer = document.getElementById('alpaPageNumbers');
        const prevBtn = document.getElementById('alpaPrevBtn');
        const nextBtn = document.getElementById('alpaNextBtn');
        const showingCountEl = document.getElementById('alpaShowingCount');

        if (!paginationWrapper || totalRows === 0) return;

        if (totalRows <= rowsPerPage) {
            paginationWrapper.style.display = 'none';
            return;
        }

        paginationWrapper.style.display = 'flex';
        let currentPage = 1;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            if (showingCountEl) {
                showingCountEl.textContent = Math.min(end, totalRows) - start;
            }

            renderPageNumbers();
            if (prevBtn) prevBtn.disabled = (currentPage === 1);
            if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
        }

        function renderPageNumbers() {
            if (!pageNumbersContainer) return;
            pageNumbersContainer.innerHTML = '';

            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'alpa-page-btn' + (i === currentPage ? ' active' : '');
                btn.textContent = i;
                btn.addEventListener('click', function () {
                    showPage(i);
                });
                pageNumbersContainer.appendChild(btn);
            }
        }

        if (prevBtn) {
            prevBtn.onclick = function () {
                if (currentPage > 1) showPage(currentPage - 1);
            };
        }

        if (nextBtn) {
            nextBtn.onclick = function () {
                if (currentPage < totalPages) showPage(currentPage + 1);
            };
        }

        showPage(1);
    });
</script>
@endsection