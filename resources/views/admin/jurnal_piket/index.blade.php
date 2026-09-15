@extends('layouts.admin')

@section('title', 'Akademik — Jurnal Piket Sekolah | EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter & Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', '"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
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

    /* Form enhancement */
    input[type="date"]::-webkit-calendar-picker-indicator {
      cursor: pointer;
      opacity: 0.6;
    }
    input[type="date"]::-webkit-calendar-picker-indicator:hover {
      opacity: 1;
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

    /* Clean up pagination text */
    nav[role="navigation"] p.text-sm {
        display: none;
    }
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 700; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Akademik — Jurnal Piket Sekolah
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 480px;">
        Monitoring catatan kegiatan piket harian, ketidakhadiran guru, dan pengawasan ketertiban sekolah
    </p>
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

    <!-- BEGIN: 4 Metric Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" data-purpose="metrics-summary">
        @php
            $pctKondusif = $totalPiket > 0 ? round(($kondusifCount / $totalPiket) * 100) : 0;
        @endphp

        <!-- Card 1: Total Entri Piket -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 p-2.5 rounded-2xl bg-indigo-50 border border-indigo-100/80 flex items-center justify-center text-indigo-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                    <path d="M9 12h6"></path>
                    <path d="M9 16h6"></path>
                    <path d="m9 8 2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalPiket) }} <span class="text-xs font-semibold text-slate-400">Entri</span></div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Entri Piket</div>
            </div>
        </div>

        <!-- Card 2: Kondisi Kondusif -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 p-2.5 rounded-2xl bg-emerald-50 border border-emerald-100/80 flex items-center justify-center text-emerald-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($kondusifCount) }} <span class="text-xs font-semibold text-emerald-600 font-medium">({{ $pctKondusif }}%)</span></div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Kondisi Kondusif</div>
            </div>
        </div>

        <!-- Card 3: Catatan Kejadian -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 p-2.5 rounded-2xl bg-rose-50 border border-rose-100/80 flex items-center justify-center text-rose-500 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                    <line x1="12" x2="12" y1="9" y2="13"></line>
                    <line x1="12" x2="12.01" y1="17" y2="17"></line>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($kejadianCount) }} <span class="text-xs font-semibold text-rose-500 font-medium">Kejadian</span></div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Catatan Kejadian</div>
            </div>
        </div>

        <!-- Card 4: Petugas Piket Hari Ini -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 p-2.5 rounded-2xl bg-amber-50 border border-amber-100/80 flex items-center justify-center text-amber-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M17 11l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($petugasHariIni) }} <span class="text-xs font-semibold text-slate-400">Petugas</span></div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Petugas Piket Hari Ini</div>
            </div>
        </div>
    </section>
    <!-- END: 4 Metric Cards -->

    <!-- BEGIN: Actions & Filter Bar Container -->
    <section class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-sm space-y-5" data-purpose="toolbar-and-filters">
        <!-- Top Row Action Buttons -->
        <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-slate-100">
            <!-- Left Primary & Secondary Actions -->
            <div class="flex items-center flex-wrap gap-2.5">
                <!-- 1. Catat Jurnal Piket -->
                <button onclick="openCreateModal()" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-700 active:scale-95 text-white shadow-sm shadow-blue-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" x2="12" y1="8" y2="16"></line>
                        <line x1="8" x2="16" y1="12" y2="12"></line>
                    </svg>
                    <span>Catat Jurnal Piket</span>
                </button>

                <!-- 2. Ekspor CSV -->
                <a href="{{ route('admin.jurnal-piket.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 active:scale-95 transition-all cursor-pointer no-underline">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M8 13h2"></path>
                        <path d="M8 17h2"></path>
                        <path d="M14 13h2"></path>
                        <path d="M14 17h2"></path>
                    </svg>
                    <span>Ekspor CSV</span>
                </a>

                <!-- 3. Cetak Laporan (PDF) - Neutral palette corrected from green -->
                <a href="{{ route('admin.jurnal-piket.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 active:scale-95 transition-all cursor-pointer no-underline">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect width="12" height="8" x="6" y="14"></rect>
                    </svg>
                    <span>Cetak Laporan (PDF)</span>
                </a>
            </div>

            <!-- Right Trash / Archive Action -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.jurnal-piket.trash') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 active:scale-95 transition-all cursor-pointer no-underline">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                    <span>Lihat Sampah Jurnal Piket</span>
                    <span class="w-5 h-5 bg-amber-600 text-white text-[11px] font-bold rounded-full inline-flex items-center justify-center ml-0.5">{{ $trashedCount ?? 0 }}</span>
                </a>
            </div>
        </div>

        <!-- Search & Filtering Form Controls -->
        <form action="{{ route('admin.jurnal-piket') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 pt-1">
            <!-- Search Field -->
            <div class="lg:col-span-4 space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="search-input">Cari Petugas / Catatan Kejadian</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </span>
                    <input class="w-full text-xs rounded-xl border-slate-200 pl-9 pr-3 py-2.5 bg-slate-50/50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 text-slate-700 placeholder:text-slate-400 transition" id="search-input" name="search" value="{{ $search }}" placeholder="Cari nama guru, NIP, atau kata kunci catatan..." type="text">
                </div>
            </div>

            <!-- Start Date -->
            <div class="lg:col-span-2 space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="start-date">Tanggal Mulai</label>
                <div class="relative">
                    <input class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" id="start-date" name="tanggal_mulai" value="{{ $tanggal_mulai ?? $tanggal }}" type="date">
                </div>
            </div>

            <!-- End Date -->
            <div class="lg:col-span-2 space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="end-date">Tanggal Selesai</label>
                <div class="relative">
                    <input class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" id="end-date" name="tanggal_selesai" value="{{ $tanggal_selesai }}" type="date">
                </div>
            </div>

            <!-- Status Suasana -->
            <div class="lg:col-span-2 space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="status-select">Status Suasana</label>
                <select class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" id="status-select" name="status_suasana">
                    <option value="">-- Semua Status --</option>
                    <option value="Kondusif" {{ $status_suasana == 'Kondusif' ? 'selected' : '' }}>Kondusif</option>
                    <option value="Ada Kejadian" {{ $status_suasana == 'Ada Kejadian' ? 'selected' : '' }}>Ada Kejadian</option>
                    <option value="Lainnya" {{ $status_suasana == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Action Filter & Reset Buttons -->
            <div class="lg:col-span-2 flex items-end gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    <span>Filter</span>
                </button>
                @if($search || $tanggal || $tanggal_mulai || $tanggal_selesai || $status_suasana)
                    <a href="{{ route('admin.jurnal-piket') }}" class="inline-flex items-center justify-center gap-1 py-2.5 px-3 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-xl transition-all cursor-pointer no-underline" title="Reset Filter">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                            <path d="M16 21h5v-5"></path>
                        </svg>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </section>
    <!-- END: Actions & Filter Bar Container -->

    <!-- BEGIN: Piket Data Table Section -->
    <section class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-sm space-y-5" data-purpose="piket-datatable-card">
        <!-- Title & Subtitle Header -->
        <div class="flex items-start justify-between flex-wrap gap-3 pb-2">
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                        <path d="M3 9h18"></path>
                        <path d="M3 15h18"></path>
                        <path d="M9 9v12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Rekap Jurnal Piket <span class="text-blue-600 font-semibold">({{ $jurnalsPiket->total() }} Entri)</span></h3>
                    <p class="text-xs text-slate-400 mt-0.5">Kelola, tinjau, dan unduh rekaman pengawasan harian sekolah secara terintegrasi.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                    Status Sinkronisasi Aktif
                </span>
            </div>
        </div>

        <!-- DataTable Wrapper with Horizontal Scroll (overflow-x-auto ensures NO CUTOFF on <= 1366px screens) -->
        <div class="overflow-x-auto border border-slate-200/80 rounded-xl">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/90 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-3 text-center w-12 shrink-0" scope="col">NO</th>
                        <th class="py-3.5 px-3 w-32 min-w-[110px]" scope="col">TANGGAL &amp; HARI</th>
                        <th class="py-3.5 px-3 w-28 min-w-[95px]" scope="col">JAM TUGAS</th>
                        <th class="py-3.5 px-3 min-w-[160px]" scope="col">PETUGAS GURU PIKET</th>
                        <th class="py-3.5 px-3 w-32 min-w-[110px] text-center" scope="col">KONDISI / SUASANA</th>
                        <th class="py-3.5 px-3 min-w-[200px]" scope="col">RINGKASAN CATATAN KEJADIAN</th>
                        <th class="py-3.5 px-3 text-center w-48 min-w-[175px]" scope="col">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($jurnalsPiket as $index => $jp)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-3 text-center font-bold text-slate-400">
                                {{ $jurnalsPiket->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-3">
                                <div class="font-bold text-slate-900 text-xs">{{ \Carbon\Carbon::parse($jp->tanggal)->format('d M Y') }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($jp->tanggal)->translatedFormat('l') }}</div>
                            </td>
                            <td class="py-3.5 px-3 font-semibold text-slate-600 font-mono">
                                {{ $jp->jam_piket }}
                            </td>
                            <td class="py-3.5 px-3">
                                <div class="font-bold text-slate-800">{{ $jp->nama_petugas_piket }}</div>
                                @if($jp->guru)
                                    <div class="text-[11px] text-blue-600 font-mono font-medium mt-0.5">NIP: {{ $jp->guru->nip ?? '-' }}</div>
                                @else
                                    <div class="text-[11px] text-slate-400 font-mono mt-0.5">Petugas Umum</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                @if($jp->status_suasana == 'Kondusif')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                                        </svg>
                                        Kondusif
                                    </span>
                                @elseif($jp->status_suasana == 'Ada Kejadian')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        Ada Kejadian
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        {{ $jp->status_suasana }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 text-slate-600 leading-relaxed max-w-sm">
                                <div class="line-clamp-2">
                                    {{ $jp->catatan_kejadian ?: 'Tidak ada catatan khusus.' }}
                                </div>
                            </td>
                            <!-- Action Buttons Column: Direct Inline, Non-wrapping, Never cut off -->
                            <td class="py-3.5 px-3 text-center">
                                <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                    <!-- 1. Detail -->
                                    <button onclick="openDetailModal({{ $jp->id_jurnal_piket }})" type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 transition-colors cursor-pointer" title="Lihat detail rincian piket dan catatan">
                                        <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Detail</span>
                                    </button>

                                    <!-- 2. Edit -->
                                    <button onclick="openEditModal({{ $jp->id_jurnal_piket }})" type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition-colors cursor-pointer" title="Ubah atau perbarui data piket">
                                        <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </button>

                                    <!-- 3. Hapus (DELETE form) -->
                                    <form action="{{ route('admin.jurnal-piket.destroy', $jp->id_jurnal_piket) }}" method="POST" onsubmit="return confirm('Pindahkan data jurnal piket petugas {{ addslashes($jp->nama_petugas_piket) }} (Tanggal: {{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}) ke Tempat Sampah?')" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition-colors cursor-pointer" title="Pindahkan data ini ke Tempat Sampah">
                                            <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">assignment_late</span>
                                <span class="font-bold text-sm text-slate-700 block">Tidak ada entri jurnal piket yang ditemukan</span>
                                <span class="text-xs text-slate-400 mt-1 block">Silakan sesuaikan kriteria pencarian atau tambahkan entri jurnal piket baru.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- DataTable Footer Pagination -->
        <div class="flex items-center justify-between flex-wrap gap-4 pt-3 text-xs text-slate-500" data-purpose="table-pagination">
            <div>
                Menampilkan <span class="font-semibold text-slate-800">{{ $jurnalsPiket->firstItem() ?? 0 }}</span> sampai <span class="font-semibold text-slate-800">{{ $jurnalsPiket->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-800">{{ $jurnalsPiket->total() }}</span> data jurnal piket
            </div>
            <div class="flex items-center gap-1.5">
                {{ $jurnalsPiket->links() }}
            </div>
        </div>
    </section>
    <!-- END: Piket Data Table Section -->

</div>

<!-- Modal 1: Catat Jurnal Piket Baru -->
<div class="modal-overlay" id="createModal">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl relative">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Catat Jurnal Piket Baru</h3>
            </div>
            <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeCreateModal()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.jurnal-piket.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="create_tanggal">Tanggal Piket <span class="text-rose-500">*</span></label>
                    <input type="date" id="create_tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="create_jam_piket">Jam Tugas Piket <span class="text-rose-500">*</span></label>
                    <input type="text" id="create_jam_piket" name="jam_piket" value="07:00 - 15:00" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required placeholder="Contoh: 07:00 - 15:00">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="create_id_guru">Pilih Guru Piket (Database)</label>
                    <select name="id_guru" id="create_id_guru" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" onchange="autoFillNamaGuru(this, 'create_nama_petugas_piket')">
                        <option value="">-- Pilih Guru Dari Database --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="create_nama_petugas_piket">Nama Petugas Piket <span class="text-rose-500">*</span></label>
                    <input type="text" id="create_nama_petugas_piket" name="nama_petugas_piket" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required placeholder="Nama lengkap petugas piket...">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="create_status_suasana">Kondisi / Suasana Sekolah <span class="text-rose-500">*</span></label>
                <select name="status_suasana" id="create_status_suasana" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                    <option value="Kondusif" selected>Kondusif (Aman &amp; Lancar)</option>
                    <option value="Ada Kejadian">Ada Kejadian / Insiden Khusus</option>
                    <option value="Lainnya">Lainnya / Catatan Khusus</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="create_catatan_kejadian">Rincian Catatan / Kejadian Hari Ini</label>
                <textarea id="create_catatan_kejadian" name="catatan_kejadian" rows="4" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" placeholder="Tuliskan catatan presensi, keterlambatan siswa/guru, penanganan kesehatan, atau kejadian penting lainnya..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-500/20 transition cursor-pointer flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/></svg>
                    <span>Simpan Jurnal Piket</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Edit Jurnal Piket -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl relative">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Edit Data Jurnal Piket</h3>
            </div>
            <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeEditModal()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="edit_tanggal">Tanggal Piket <span class="text-rose-500">*</span></label>
                    <input type="date" id="edit_tanggal" name="tanggal" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="edit_jam_piket">Jam Tugas Piket <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_jam_piket" name="jam_piket" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="edit_id_guru">Pilih Guru Piket</label>
                    <select name="id_guru" id="edit_id_guru" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" onchange="autoFillNamaGuru(this, 'edit_nama_petugas_piket')">
                        <option value="">-- Tanpa Guru Spesifik --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700" for="edit_nama_petugas_piket">Nama Petugas Piket <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_nama_petugas_piket" name="nama_petugas_piket" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="edit_status_suasana">Kondisi / Suasana Sekolah <span class="text-rose-500">*</span></label>
                <select name="status_suasana" id="edit_status_suasana" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition" required>
                    <option value="Kondusif">Kondusif (Aman &amp; Lancar)</option>
                    <option value="Ada Kejadian">Ada Kejadian / Insiden Khusus</option>
                    <option value="Lainnya">Lainnya / Catatan Khusus</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700" for="edit_catatan_kejadian">Rincian Catatan / Kejadian Hari Ini</label>
                <textarea id="edit_catatan_kejadian" name="catatan_kejadian" rows="4" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 focus:bg-white py-2.5 px-3 focus:border-brand-500 focus:ring-brand-500 text-slate-700 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-sm transition cursor-pointer flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/></svg>
                    <span>Perbarui Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Detail Kejadian / Jurnal Piket -->
<div class="modal-overlay" id="detailModal">
    <div class="modal-box bg-white border border-slate-200 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl relative">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="12" y1="16" x2="12" y2="12" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12.01" y2="8" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Rincian &amp; Keterangan Jurnal Piket</h3>
            </div>
            <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" onclick="closeDetailModal()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>

        <div id="detailModalContent" class="space-y-4">
            <div class="text-center py-8 text-slate-400">
                <svg class="w-8 h-8 animate-spin mx-auto mb-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <p class="text-xs font-medium">Memuat data rincian piket...</p>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 text-right mt-5">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Live clock and KBM status in top header widget
    function updateHeaderClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        
        const dateEl = document.getElementById('headerCurrentDate');
        const clockEl = document.getElementById('headerCurrentClock');
        if (dateEl) dateEl.textContent = `${dayName}, ${date} ${month} ${year}`;
        if (clockEl) clockEl.textContent = `${h}:${m}:${s} WIB`;

        // Dynamic KBM status estimation
        const totalMinutes = now.getHours() * 60 + now.getMinutes();
        const kbmStart = 7 * 60;        // 07:00
        const kbmEnd   = 15 * 60 + 30;  // 15:30
        
        const kbmStatus = document.getElementById('headerKbmStatus');
        const kbmDesc = document.getElementById('headerKbmDesc');
        if (kbmStatus && kbmDesc) {
            if (totalMinutes < kbmStart) {
                kbmStatus.textContent = 'Sebelum KBM';
                kbmDesc.textContent = 'Mulai 07:00 WIB';
            } else if (totalMinutes <= kbmEnd) {
                kbmStatus.textContent = 'KBM Berlangsung';
                kbmDesc.textContent = 'Hingga 15:30 WIB';
            } else {
                kbmStatus.textContent = 'KBM Selesai';
                kbmDesc.textContent = 'Selesai 15:30 WIB';
            }
        }
    }
    setInterval(updateHeaderClock, 1000);
    updateHeaderClock();

    // Modal Create Handlers
    function openCreateModal() {
        document.getElementById('createModal').classList.add('active');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.remove('active');
    }

    // Modal Edit Handlers
    function openEditModal(id) {
        fetch(`{{ url('/admin/jurnal-piket-admin') }}/${id}/detail`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const data = res.data;
                    document.getElementById('editForm').action = `{{ url('/admin/jurnal-piket-admin') }}/${id}/update`;
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_jam_piket').value = data.jam_piket;
                    document.getElementById('edit_id_guru').value = data.id_guru || '';
                    document.getElementById('edit_nama_petugas_piket').value = data.nama_petugas_piket;
                    document.getElementById('edit_status_suasana').value = data.status_suasana;
                    document.getElementById('edit_catatan_kejadian').value = data.catatan_kejadian !== 'Tidak ada catatan khusus.' ? data.catatan_kejadian : '';
                    
                    document.getElementById('editModal').classList.add('active');
                }
            })
            .catch(err => {
                alert('Gagal mengambil data jurnal piket.');
            });
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    // Modal Detail Handlers
    function openDetailModal(id) {
        document.getElementById('detailModal').classList.add('active');
        document.getElementById('detailModalContent').innerHTML = `
            <div class="text-center py-8 text-slate-400">
                <svg class="w-8 h-8 animate-spin mx-auto mb-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <p class="text-xs font-medium">Memuat data rincian piket...</p>
            </div>
        `;

        fetch(`{{ url('/admin/jurnal-piket-admin') }}/${id}/detail`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const d = res.data;
                    let badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    let statusIcon = '<svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>';
                    
                    if (d.status_suasana === 'Ada Kejadian') {
                        badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                        statusIcon = '<svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>';
                    } else if (d.status_suasana === 'Lainnya') {
                        badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                        statusIcon = '<svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>';
                    }

                    const html = `
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Piket</span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border ${badgeClass}">
                                    ${statusIcon}
                                    ${d.status_suasana}
                                </span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900">${d.tanggal_formatted}</h4>
                            <div class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><polyline points="12 6 12 12 16 14" stroke-width="2"></polyline></svg>
                                <span>Jam Tugas: <code class="bg-slate-200/70 text-slate-700 px-1.5 py-0.5 rounded font-mono font-semibold">${d.jam_piket}</code></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-2xs">
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Petugas Piket</div>
                                <div class="font-bold text-slate-800 text-sm mt-0.5">${d.nama_petugas_piket}</div>
                            </div>
                            <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-2xs">
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">NIP Guru</div>
                                <div class="font-bold text-blue-600 font-mono text-sm mt-0.5">${d.nip}</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Rincian Catatan / Kejadian:</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs text-slate-700 leading-relaxed whitespace-pre-line min-h-[70px]">
                                ${d.catatan_kejadian || 'Tidak ada catatan khusus.'}
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-400 bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2">
                            <span>Dicatat: <strong class="text-slate-600 font-semibold">${d.created_at_formatted}</strong></span>
                            <span>ID: <code class="font-mono text-slate-600">#${d.id_jurnal_piket}</code></span>
                        </div>
                    `;
                    document.getElementById('detailModalContent').innerHTML = html;
                }
            })
            .catch(err => {
                document.getElementById('detailModalContent').innerHTML = `
                    <div class="text-center py-6 text-rose-500 text-xs">
                        Gagal mengambil rincian data jurnal piket. Silakan muat ulang halaman.
                    </div>
                `;
            });
    }
    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    // Auto fill nama guru from select dropdown
    function autoFillNamaGuru(selectEl, targetId) {
        const selectedText = selectEl.options[selectEl.selectedIndex].text;
        if (selectEl.value && selectedText) {
            const namaClean = selectedText.split(' (NIP:')[0];
            document.getElementById(targetId).value = namaClean;
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        ['createModal', 'editModal', 'detailModal'].forEach(id => {
            const el = document.getElementById(id);
            if (el && e.target === el) {
                el.classList.remove('active');
            }
        });
    });

    // Update Academic Year text to match Semester Ganjil on topbar
    document.addEventListener('DOMContentLoaded', function() {
        const taSpan = document.querySelector('.ta-selector.academic-year span');
        if (taSpan) taSpan.textContent = 'T.A. 2025/2026 – Semester Ganjil';
    });
</script>
@endsection
