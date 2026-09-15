@extends('layouts.admin')

@section('title', 'Master Data Jam Pelajaran — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0f7ff',
              100: '#e0effe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              900: '#1e3a8a',
            },
            tableHeader: '#1e293b',
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
    .modal-backdrop-custom {
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
    .modal-backdrop-custom.show {
        display: flex;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 1.25rem;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title text-base font-extrabold text-slate-900 tracking-tight leading-none m-0 p-0">
        Master Data Jam Pelajaran
    </h1>
</div>
@endsection

@section('content')

<div class="space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-2xs" id="errorAlertBox">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <div>
                        <strong class="font-extrabold text-rose-900 block mb-1">Pengisian data belum sesuai kriteria:</strong>
                        <ul class="list-disc pl-4 space-y-0.5 font-medium text-rose-700">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('errorAlertBox').remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- BEGIN: Card 1 - Tambah Jam Pelajaran Baru -->
    <section class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm" data-purpose="form-tambah-jam">
        <!-- Form Header and Trash Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-slate-100">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-blue-500/20 ring-4 ring-blue-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <polyline points="12 7 12 12 15 15"></polyline>
                        <line x1="12" y1="3" x2="12" y2="1"></line>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Tambah Jam Pelajaran Baru</h2>
                    <p class="text-xs text-slate-500">Masukkan rentang waktu resmi KBM (Senin–Kamis &amp; Jumat) serta label sesi pembelajaran baru.</p>
                </div>
            </div>
<<<<<<< HEAD
=======
            <a href="{{ route('jam-pelajaran.trash') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200/80 hover:bg-amber-100 transition-colors shadow-2xs no-underline">
                <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M3 6h18m-2 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
                <span>Lihat Sampah Jam</span>
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-500 text-white leading-none">{{ $trashedCount }}</span>
                @endif
            </a>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>

        <form id="formTambahJam" action="{{ route('jam-pelajaran.store') }}" method="POST" onsubmit="return validateJamForm(event)" class="mt-5 space-y-5">
            @csrf

            <!-- Row 1: Session Label Selector and Active Day Checkboxes -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-end">
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="jam_ke" class="block text-xs font-bold text-slate-700">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-blue-100/70 text-blue-700 mr-1.5 align-middle">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </span>
                            <span class="align-middle">1. Label Jam &amp; Sesi Pembelajaran</span> <span class="text-rose-500">*</span>
                        </label>
                        <span id="auto_fill_badge" class="hidden inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Auto-fill aktif
                        </span>
                    </div>

                    <div class="relative">
                        <select id="jam_ke" name="jam_ke" onchange="handleJamKeChange(this)" required
                            class="w-full text-xs sm:text-sm bg-slate-50/50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('jam_ke') border-rose-400 @enderror @error('jam_ke_resolved') border-rose-400 @enderror">
                            <option value="" disabled {{ old('jam_ke') ? '' : 'selected' }}>-- Pilih Label Jam Sesi --</option>
                            @foreach(['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'] as $labelOpt)
                                <option value="{{ $labelOpt }}" {{ old('jam_ke') == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                            @endforeach
                            <option value="custom" {{ old('jam_ke') == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                        </select>
                    </div>

                    <div id="customJamKeWrapper" style="display: {{ old('jam_ke') == 'custom' ? 'block' : 'none' }};" class="mt-2">
                        <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ old('jam_ke_custom') }}"
                            class="w-full text-xs sm:text-sm bg-slate-50/50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                            placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                    </div>

                    @error('jam_ke')
                        <small class="text-rose-500 font-semibold block mt-1 text-[11px]">{{ $message }}</small>
                    @enderror
                    @error('jam_ke_resolved')
                        <small class="text-rose-500 font-semibold block mt-1 text-[11px]">{{ $message }}</small>
                    @enderror
                </div>

                <div class="lg:col-span-4 bg-slate-50/70 p-3 rounded-xl border border-slate-200/60">
                    <span class="block text-[11px] font-semibold text-slate-500 mb-2">Hari Berlaku Sesi Ini:</span>
                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-700">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="chk_senin_kamis" checked onchange="toggleSeninKamisFields(this.checked)"
                                class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span>Senin – Kamis</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="chk_jumat" checked onchange="toggleJumatFields(this.checked)"
                                class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span>Hari Jumat</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Row 2: Dual Day-Time Settings Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Left Card: Senin - Kamis -->
                <div id="box_senin_kamis" class="border border-blue-200/80 bg-blue-50/20 rounded-xl p-4 transition-all hover:border-blue-300">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                            <span class="w-6 h-6 rounded-lg bg-blue-100/80 flex items-center justify-center text-blue-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            <span>Waktu Senin – Kamis</span>
                        </div>
                        <span id="durasi_senin_kamis_badge" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 border border-blue-200 shadow-2xs">35 Menit</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="jam_mulai" class="block text-[11px] font-medium text-slate-600 mb-1">Waktu Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" onchange="calculateDurations()"
                                class="w-full text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none @error('jam_mulai') border-rose-400 @enderror">
                            @error('jam_mulai')
                                <small class="text-rose-500 font-semibold block mt-1 text-[10px]">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="jam_selesai" class="block text-[11px] font-medium text-slate-600 mb-1">Waktu Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '07:35') }}" onchange="calculateDurations()"
                                class="w-full text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none @error('jam_selesai') border-rose-400 @enderror">
                            @error('jam_selesai')
                                <small class="text-rose-500 font-semibold block mt-1 text-[10px]">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <p id="senin_kamis_note" class="text-[11px] italic text-slate-500">* Kosongkan jika hari Senin-Kamis tidak ada sesi pembelajaran ini.</p>
                </div>

                <!-- Right Card: Hari Jumat -->
                <div id="box_jumat" class="border border-blue-200/80 bg-blue-50/20 rounded-xl p-4 transition-all hover:border-blue-300">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                            <span class="w-6 h-6 rounded-lg bg-blue-100/80 flex items-center justify-center text-blue-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            <span>Waktu Hari Jumat</span>
                        </div>
                        <span id="durasi_jumat_badge" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 border border-blue-200 shadow-2xs">30 Menit</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="jam_mulai_jumat" class="block text-[11px] font-medium text-slate-600 mb-1">Waktu Mulai Jumat</label>
                            <input type="time" id="jam_mulai_jumat" name="jam_mulai_jumat" value="{{ old('jam_mulai_jumat', '07:00') }}" onchange="calculateDurations()"
                                class="w-full text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none @error('jam_mulai_jumat') border-rose-400 @enderror">
                            @error('jam_mulai_jumat')
                                <small class="text-rose-500 font-semibold block mt-1 text-[10px]">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="jam_selesai_jumat" class="block text-[11px] font-medium text-slate-600 mb-1">Waktu Selesai Jumat</label>
                            <input type="time" id="jam_selesai_jumat" name="jam_selesai_jumat" value="{{ old('jam_selesai_jumat', '07:30') }}" onchange="calculateDurations()"
                                class="w-full text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none @error('jam_selesai_jumat') border-rose-400 @enderror">
                            @error('jam_selesai_jumat')
                                <small class="text-rose-500 font-semibold block mt-1 text-[10px]">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <p id="jumat_note" class="text-[11px] italic text-blue-600 font-medium">* Sesuai alokasi resmi hari Jumat SMKN 1 Boyolangu.</p>
                </div>
            </div>

            <!-- Row 3: Session Notes with Quick-Select Badges -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="keterangan" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="16" y2="12"></line>
                            <line x1="4" y1="18" x2="12" y2="18"></line>
                        </svg>
                        <span>Keterangan Sesi Pembelajaran (Opsional)</span>
                    </label>
                    <span class="text-[11px] text-slate-400">Pilih templat cepat di bawah ini untuk auto-fill:</span>
                </div>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}"
                    class="w-full text-xs bg-slate-50/50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all mb-2"
                    placeholder="Contoh: Pembelajaran Reguler / Upacara / Sholat Dzuhur">
                
                <!-- Quick Chips / Badges -->
                <div class="flex flex-wrap items-center gap-2 pt-1" data-purpose="quick-fill-chips">
                    <button type="button" onclick="setKeterangan('Upacara / Apel (Senin) | Pembiasaan (Jumat)')"
                        class="px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 text-[11px] font-medium text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-colors cursor-pointer">
                        Upacara / Apel (Senin)
                    </button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Pagi')"
                        class="px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 text-[11px] font-medium text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-colors cursor-pointer">
                        Sesi Pembelajaran Pagi
                    </button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Siang')"
                        class="px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 text-[11px] font-medium text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-colors cursor-pointer">
                        Sesi Pembelajaran Siang
                    </button>
                    <button type="button" onclick="setKeterangan('Istirahat 1 (20 Menit)')"
                        class="px-2.5 py-1 rounded-lg border border-amber-300 bg-amber-100/70 text-[11px] font-semibold text-amber-800 hover:bg-amber-200/80 transition-colors cursor-pointer">
                        Istirahat 1
                    </button>
                    <button type="button" onclick="setKeterangan('Istirahat 2 (ISHOMA / Sholat Jumat)')"
                        class="px-2.5 py-1 rounded-lg border border-amber-300 bg-amber-100/70 text-[11px] font-semibold text-amber-800 hover:bg-amber-200/80 transition-colors cursor-pointer">
                        Istirahat 2 (ISHOMA)
                    </button>
                </div>
            </div>

<<<<<<< HEAD
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-reset">Reset</a>
                <a href="{{ route('jam-pelajaran.trash') }}" class="btn-trash" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;" title="Lihat Data Jam Pelajaran di Tempat Sampah">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih sesi jam pelajaran dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
=======
            <!-- Form Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-3">
                <button type="button" onclick="resetJamForm()"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white shadow-xs transition-all cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8"></path>
                        <path d="M3 3v5h5"></path>
                    </svg>
                    <span>Reset Form</span>
                </button>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white shadow-sm hover:shadow transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span>Simpan Jam Pelajaran</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                </button>
            </div>
        </form>
    </section>
    <!-- END: Card 1 -->

    <!-- BEGIN: Card 2 - Daftar Sesi Jam Pelajaran -->
    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden" data-purpose="table-master-jam">
        <!-- Table Section Header & Search Toolbar -->
        <div class="p-6 border-b border-slate-100 space-y-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200/80">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"></circle>
                            <polyline points="12 6 12 12 15 15"></polyline>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Sesi Jam Pelajaran ({{ count($jamList) }})</h2>
                </div>
                <p class="text-xs text-slate-500">
                    Kelola seluruh sesi jam pelajaran dan rentang waktu belajar sekolah berdasarkan pedoman <span class="font-medium text-slate-700">jam pelajaran.png</span> SMKN 1 Boyolangu.
                </p>
            </div>

            <!-- Search & Filter Controls -->
            <form action="{{ route('jam-pelajaran.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <div class="flex flex-1 items-center gap-2 max-w-lg">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="w-full text-xs bg-slate-50 border border-slate-300 rounded-xl pl-9 pr-3 py-2 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                            placeholder="Cari Jam / Waktu / Keterangan..">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-xl transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Cari</span>
                    </button>
                    <a href="{{ route('jam-pelajaran.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition-colors shadow-2xs no-underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                        </svg>
                        <span>Reset</span>
                    </a>
                </div>
            </form>

            <!-- Contextual Bulk Actions Toolbar (Only visible when 1+ rows selected) -->
            <div id="bulkActionsToolbar" class="hidden p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
                <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                        </svg>
                    </span>
                    <span>
                        <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> sesi jam pelajaran dipilih
                    </span>
                    <span class="text-rose-300 mx-1">|</span>
                    <button type="button" onclick="deselectAllJamPelajaran()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
                        Batalkan pilihan
                    </button>
                </div>

                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-xs cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Hapus Terpilih</span>
                </button>
            </div>

            <!-- Banner Ketentuan Waktu KBM Resmi -->
            <div class="bg-blue-50/70 border border-blue-200 text-slate-800 rounded-2xl p-5 shadow-xs" data-purpose="kbm-rules-banner">
                <div class="flex items-center gap-2 text-sm font-bold text-blue-950 mb-3">
                    <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-serif">i</div>
                    <h3>Ketentuan Waktu KBM Resmi (Sesuai Pedoman jam_pelajaran.png):</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-slate-700">
                    <!-- Left Column: Senin s.d. Kamis -->
                    <div class="space-y-1.5">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Senin s.d. Kamis:</span>
                        </div>
                        <ul class="space-y-1 pl-5 list-disc text-slate-600">
                            <li>Jam ke-1 s/d 4 (40 Menit/JP), Jam ke-5 s/d 10 (35 Menit/JP) (07:00 - 15:00 WIB)</li>
                            <li><strong class="text-slate-800">Istirahat 1:</strong> 09:40 - 10:00 WIB (20 Menit)</li>
                            <li><strong class="text-slate-800">Istirahat 2 (ISHOMA):</strong> 11:45 - 13:15 WIB (90 Menit)</li>
                            <li>Hari Senin jam ke-1: Upacara / Apel Bendera</li>
                        </ul>
                    </div>
                    <!-- Right Column: Hari Jumat -->
                    <div class="space-y-1.5">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Hari Jumat:</span>
                        </div>
                        <ul class="space-y-1 pl-5 list-disc text-slate-600">
                            <li>Jam ke-1 s/d 13 (30 Menit/JP) (07:00 - 15:30 WIB)</li>
                            <li><strong class="text-slate-800">Istirahat 1:</strong> 09:30 - 09:50 WIB (20 Menit)</li>
                            <li><strong class="text-slate-800">Istirahat 2 (Jumatan / ISHOMA):</strong> 11:20 - 13:00 WIB (100 Menit)</li>
                            <li>Hari Jumat jam ke-1: Pembiasaan Hari Jumat</li>
                            <li><strong class="text-slate-800">Kepulangan:</strong> Kelas XI jam ke-12 (15:00 WIB), Kelas X jam ke-13 (15:30 WIB)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Data Table -->
        <form id="formBulkDelete" action="{{ route('jam-pelajaran.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 uppercase text-[11px] font-semibold tracking-wider">
                            <th class="py-3.5 pl-6 pr-3 w-10 text-center">
                                <input type="checkbox" id="selectAllJamPelajaran"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                    title="Pilih Semua (Select All)">
                            </th>
                            <th class="py-3.5 px-4 text-center w-12 text-slate-800">NO</th>
                            <th class="py-3.5 px-4 w-28 text-slate-800 whitespace-nowrap">JAM KE-</th>
                            <th class="py-3.5 px-4 min-w-[170px] text-slate-800 whitespace-nowrap">SENIN - KAMIS</th>
                            <th class="py-3.5 px-4 min-w-[170px] text-slate-800 whitespace-nowrap">HARI JUMAT</th>
                            <th class="py-3.5 px-4 min-w-[260px] text-slate-800">KETERANGAN</th>
                            <th class="py-3.5 px-6 text-center min-w-[240px] text-slate-800 whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="jamTableBody" class="divide-y divide-slate-100 text-slate-700">
                        @forelse($jamList as $idx => $item)
                            <tr class="jam-row hover:bg-slate-50/80 transition-colors" data-row-index="{{ $idx }}">
                                <td class="py-3.5 pl-6 pr-3 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id_jam }}"
                                        class="jam-select-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                        onchange="updateBulkDeleteState()">
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">{{ $idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">{{ $item->jam_ke }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($item->waktu_senin_kamis !== '-')
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-[11px] font-semibold text-slate-800">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>{{ $item->waktu_senin_kamis }} WIB</span>
                                        </div>
                                    @else
                                        <span class="text-xs italic text-slate-400 font-medium">- (Selesai pkl 15:00)</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($item->waktu_jumat !== '-')
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-200 text-[11px] font-semibold text-blue-800">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>{{ $item->waktu_jumat }} WIB</span>
                                        </div>
                                    @else
                                        <span class="text-xs italic text-slate-400 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($item->keterangan)
                                        <span class="inline-block px-3 py-1 bg-slate-100/80 rounded-lg text-slate-700 font-medium text-[11px]">
                                            {{ $item->keterangan }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- 1. LIHAT DETAIL -->
                                        <a href="{{ route('jam-pelajaran.show', $item->id_jam) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-medium bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 transition-colors no-underline"
                                            title="Lihat Detail Sesi Jam">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Lihat Detail</span>
                                        </a>

                                        <!-- 2. EDIT -->
                                        <a href="{{ route('jam-pelajaran.edit', $item->id_jam) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-medium bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 transition-colors no-underline"
                                            title="Edit Data Jam Pelajaran">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <!-- 3. HAPUS -->
                                        <button type="button"
                                            onclick="confirmSingleDelete('{{ $item->id_jam }}', '{{ addslashes($item->jam_ke) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-medium bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors cursor-pointer"
                                            title="Hapus Jam Pelajaran">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <polyline points="12 6 12 12 15 15"></polyline>
                                        </svg>
                                        <p class="text-sm font-semibold text-slate-600">Belum ada data Master Jam Pelajaran</p>
                                        <p class="text-xs text-slate-400">Tambahkan sesi baru menggunakan form di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Table Pagination and Entry Counter Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-600">
            <div class="font-medium">
                Menampilkan <span id="showingStart" class="font-bold text-slate-900">{{ count($jamList) > 0 ? 1 : 0 }}</span> - <span id="showingEnd" class="font-bold text-slate-900">{{ count($jamList) }}</span> dari <span class="font-bold text-slate-900">{{ count($jamList) }}</span> entri jam pelajaran
            </div>
            <div id="paginationNav" class="flex items-center gap-1">
                <button id="btnPrevPage" onclick="changePage(currentPage - 1)" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 font-medium cursor-not-allowed transition" disabled type="button">
                    Sebelumnya
                </button>
                <div id="paginationPageNumbers" class="flex items-center gap-1">
                    <button class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold shadow-2xs" type="button">
                        1
                    </button>
                </div>
                <button id="btnNextPage" onclick="changePage(currentPage + 1)" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 font-medium cursor-not-allowed transition" disabled type="button">
                    Selanjutnya
                </button>
            </div>
        </div>
    </section>
    <!-- END: Card 2 -->

</div>

<!-- Modal Confirm Single Delete -->
<div class="modal-backdrop-custom" id="modalConfirmSingleDelete">
    <div class="modal-box-custom p-6">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 text-center mb-2">Hapus Sesi Jam Pelajaran</h3>
        <p class="text-xs text-slate-500 text-center mb-6 leading-relaxed">
            Apakah Anda yakin ingin memindahkan <strong id="singleDeleteJamKeText" class="text-rose-600"></strong> ke Tempat Sampah? Data dapat dipulihkan kembali dari menu Sampah.
        </p>
        <div class="flex items-center gap-3">
            <button type="button" onclick="closeSingleDeleteModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer">
                Batal
            </button>
            <form id="singleDeleteFormAction" action="" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors shadow-sm shadow-rose-500/30 cursor-pointer">
                    Ya, Pindahkan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirm Bulk Delete -->
<div class="modal-backdrop-custom" id="modalConfirmBulkDelete">
    <div class="modal-box-custom p-6">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 text-center mb-2">Konfirmasi Hapus Terpilih</h3>
        <p class="text-xs text-slate-500 text-center mb-6 leading-relaxed">
            Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" class="text-rose-600">0 data sesi jam pelajaran</strong> yang dicentang ke Tempat Sampah?
        </p>
        <div class="flex items-center gap-3">
            <button type="button" onclick="closeBulkDeleteModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitBulkDelete()" class="flex-1 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors shadow-sm shadow-rose-500/30 cursor-pointer">
                Ya, Hapus Data
            </button>
        </div>
    </div>
</div>

<script data-purpose="jam-pelajaran-interactivity">
    // Presets Definition
    const jamPresets = {
        'Jam Ke-1': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara / Apel (Senin) | Pembiasaan (Jumat)' },
        'Jam Ke-2': { startSK: '07:40', endSK: '08:20', startFri: '07:30', endFri: '08:00', ket: 'Sesi Pembelajaran Pagi' },
        'Jam Ke-3': { startSK: '08:20', endSK: '09:00', startFri: '08:00', endFri: '08:30', ket: 'Sesi Pembelajaran Pagi' },
        'Jam Ke-4': { startSK: '09:00', endSK: '09:40', startFri: '08:30', endFri: '09:00', ket: 'Sesi Pembelajaran (Sebelum Istirahat 1 Senin-Kamis)' },
        'Istirahat 1': { startSK: '09:40', endSK: '10:00', startFri: '09:30', endFri: '09:50', ket: 'Istirahat 1 (20 Menit)' },
        'Jam Ke-5': { startSK: '10:00', endSK: '10:35', startFri: '09:00', endFri: '09:30', ket: 'Sesi Pembelajaran (Setelah Istirahat 1 Senin-Kamis / Sebelum Istirahat 1 Jumat)' },
        'Jam Ke-6': { startSK: '10:35', endSK: '11:10', startFri: '09:50', endFri: '10:20', ket: 'Sesi Pembelajaran Siang (Setelah Istirahat 1 Jumat)' },
        'Jam Ke-7': { startSK: '11:10', endSK: '11:45', startFri: '10:20', endFri: '10:50', ket: 'Sesi Pembelajaran Siang (Sebelum Istirahat 2 Senin-Kamis)' },
        'Istirahat 2': { startSK: '11:45', endSK: '13:15', startFri: '11:20', endFri: '13:00', ket: 'Istirahat 2 (ISHOMA / Sholat Jumat)' },
        'Jam Ke-8': { startSK: '13:15', endSK: '13:50', startFri: '10:50', endFri: '11:20', ket: 'Sesi Pembelajaran (Setelah ISHOMA Senin-Kamis / Sebelum Jumatan Jumat)' },
        'Jam Ke-9': { startSK: '13:50', endSK: '14:25', startFri: '13:00', endFri: '13:30', ket: 'Sesi Pembelajaran Sore (Setelah ISHOMA Jumat)' },
        'Jam Ke-10': { startSK: '14:25', endSK: '15:00', startFri: '13:30', endFri: '14:00', ket: 'Sesi Pembelajaran (Senin-Kamis Pulang pkl 15:00)' },
        'Jam Ke-11': { startSK: '', endSK: '', startFri: '14:00', endFri: '14:30', ket: 'Sesi Pembelajaran Khusus Jumat' },
        'Jam Ke-12': { startSK: '', endSK: '', startFri: '14:30', endFri: '15:00', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas XI Pulang pkl 15:00)' },
        'Jam Ke-13': { startSK: '', endSK: '', startFri: '15:00', endFri: '15:30', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas X Pulang pkl 15:30)' },
        'Upacara Bendera': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara Bendera Hari Senin' },
        'Pembiasaan Hari Jumat': { startSK: '', endSK: '', startFri: '07:00', endFri: '07:30', ket: 'Pembiasaan & Kedisiplinan Hari Jumat' },
    };

    function handleJamKeChange(selectElem) {
        const label = selectElem.value;
        const customWrapper = document.getElementById('customJamKeWrapper');
        const customInput = document.getElementById('jam_ke_custom');
        const autoBadge = document.getElementById('auto_fill_badge');

        if (label === 'custom') {
            customWrapper.style.display = 'block';
            customInput.setAttribute('required', 'required');
            customInput.focus();
            if (autoBadge) autoBadge.classList.add('hidden');
        } else {
            customWrapper.style.display = 'none';
            customInput.removeAttribute('required');
            customInput.value = '';

            // Apply Preset Auto-Fill if available
            if (jamPresets[label]) {
                const preset = jamPresets[label];
                
                // Senin-Kamis
                const chkSK = document.getElementById('chk_senin_kamis');
                if (preset.startSK && preset.endSK) {
                    chkSK.checked = true;
                    toggleSeninKamisFields(true);
                    document.getElementById('jam_mulai').value = preset.startSK;
                    document.getElementById('jam_selesai').value = preset.endSK;
                } else {
                    chkSK.checked = false;
                    toggleSeninKamisFields(false);
                }

                // Jumat
                const chkFri = document.getElementById('chk_jumat');
                if (preset.startFri && preset.endFri) {
                    chkFri.checked = true;
                    toggleJumatFields(true);
                    document.getElementById('jam_mulai_jumat').value = preset.startFri;
                    document.getElementById('jam_selesai_jumat').value = preset.endFri;
                } else {
                    chkFri.checked = false;
                    toggleJumatFields(false);
                }

                // Keterangan
                if (preset.ket) {
                    document.getElementById('keterangan').value = preset.ket;
                }

                calculateDurations();
                if (autoBadge) autoBadge.classList.remove('hidden');
            }
        }
    }

    function toggleSeninKamisFields(enabled) {
        const box = document.getElementById('box_senin_kamis');
        const inStart = document.getElementById('jam_mulai');
        const inEnd = document.getElementById('jam_selesai');

        if (enabled) {
            box.style.opacity = '1';
            box.style.pointerEvents = 'auto';
            inStart.disabled = false;
            inEnd.disabled = false;
        } else {
            box.style.opacity = '0.45';
            box.style.pointerEvents = 'none';
            inStart.disabled = true;
            inEnd.disabled = true;
            inStart.value = '';
            inEnd.value = '';
        }
        calculateDurations();
    }

    function toggleJumatFields(enabled) {
        const box = document.getElementById('box_jumat');
        const inStart = document.getElementById('jam_mulai_jumat');
        const inEnd = document.getElementById('jam_selesai_jumat');

        if (enabled) {
            box.style.opacity = '1';
            box.style.pointerEvents = 'auto';
            inStart.disabled = false;
            inEnd.disabled = false;
        } else {
            box.style.opacity = '0.45';
            box.style.pointerEvents = 'none';
            inStart.disabled = true;
            inEnd.disabled = true;
            inStart.value = '';
            inEnd.value = '';
        }
        calculateDurations();
    }

    function setKeterangan(text) {
        const input = document.getElementById('keterangan');
        if (input) input.value = text;
    }

    function timeToMinutes(t) {
        if (!t) return 0;
        const parts = t.split(':');
        if (parts.length < 2) return 0;
        return (parseInt(parts[0], 10) * 60) + parseInt(parts[1], 10);
    }

    function calculateDurations() {
        // Senin-Kamis
        const inStartSK = document.getElementById('jam_mulai');
        const inEndSK = document.getElementById('jam_selesai');
        const badgeSK = document.getElementById('durasi_senin_kamis_badge');

        if (inStartSK && inEndSK && inStartSK.value && inEndSK.value && inEndSK.value > inStartSK.value) {
            const diff = timeToMinutes(inEndSK.value) - timeToMinutes(inStartSK.value);
            if (diff > 0) {
                badgeSK.textContent = diff + ' Menit';
                badgeSK.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 border border-blue-200 shadow-2xs';
            } else {
                badgeSK.textContent = '-';
                badgeSK.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 shadow-2xs';
            }
        } else {
            badgeSK.textContent = '-';
            badgeSK.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 shadow-2xs';
        }

        // Jumat
        const inStartFri = document.getElementById('jam_mulai_jumat');
        const inEndFri = document.getElementById('jam_selesai_jumat');
        const badgeFri = document.getElementById('durasi_jumat_badge');

        if (inStartFri && inEndFri && inStartFri.value && inEndFri.value && inEndFri.value > inStartFri.value) {
            const diff = timeToMinutes(inEndFri.value) - timeToMinutes(inStartFri.value);
            if (diff > 0) {
                badgeFri.textContent = diff + ' Menit';
                badgeFri.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 border border-blue-200 shadow-2xs';
            } else {
                badgeFri.textContent = '-';
                badgeFri.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 shadow-2xs';
            }
        } else {
            badgeFri.textContent = '-';
            badgeFri.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 shadow-2xs';
        }
    }

    function resetJamForm() {
        const form = document.getElementById('formTambahJam');
        if (form) {
            form.reset();
            const customWrapper = document.getElementById('customJamKeWrapper');
            if (customWrapper) customWrapper.style.display = 'none';
            const autoBadge = document.getElementById('auto_fill_badge');
            if (autoBadge) autoBadge.classList.add('hidden');
            toggleSeninKamisFields(true);
            toggleJumatFields(true);
            calculateDurations();
        }
    }

    function validateJamForm(e) {
        const selectElem = document.getElementById('jam_ke');
        const jamKeVal = selectElem.value;
        const customVal = document.getElementById('jam_ke_custom').value.trim();
        const chkSK = document.getElementById('chk_senin_kamis').checked;
        const chkFri = document.getElementById('chk_jumat').checked;

        const jamMulai = document.getElementById('jam_mulai').value;
        const jamSelesai = document.getElementById('jam_selesai').value;
        const jamMulaiJumat = document.getElementById('jam_mulai_jumat').value;
        const jamSelesaiJumat = document.getElementById('jam_selesai_jumat').value;

        let errors = [];
        if (!jamKeVal) {
            errors.push('Label Jam Sesi wajib dipilih!');
        } else if (jamKeVal === 'custom' && !customVal) {
            errors.push('Label Jam Khusus wajib diisi!');
        }

        if (!chkSK && !chkFri) {
            errors.push('Pilih minimal satu kategori hari (Senin-Kamis atau Hari Jumat) yang berlaku untuk sesi ini!');
        }

        if (chkSK) {
            if (!jamMulai) errors.push('Waktu Mulai Senin-Kamis wajib diisi!');
            if (!jamSelesai) errors.push('Waktu Selesai Senin-Kamis wajib diisi!');
            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                errors.push('Waktu Selesai Senin-Kamis (' + jamSelesai + ') harus lebih akhir daripada Waktu Mulai (' + jamMulai + ')!');
            }
        }

        if (chkFri) {
            if (!jamMulaiJumat) errors.push('Waktu Mulai Hari Jumat wajib diisi!');
            if (!jamSelesaiJumat) errors.push('Waktu Selesai Hari Jumat wajib diisi!');
            if (jamMulaiJumat && jamSelesaiJumat && jamSelesaiJumat <= jamMulaiJumat) {
                errors.push('Waktu Selesai Hari Jumat (' + jamSelesaiJumat + ') harus lebih akhir daripada Waktu Mulai Hari Jumat (' + jamMulaiJumat + ')!');
            }
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert('⚠️ PERINGATAN VALIDASI DATA JAM PELAJARAN:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
            return false;
        }
        return true;
    }

    // Contextual Toolbar & Bulk Action Helpers
    function updateBulkDeleteState() {
        const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
        const totalBoxes   = document.querySelectorAll('.jam-select-checkbox');
        const count        = checkedBoxes.length;
        const countSpan    = document.getElementById('bulkDeleteCount');
        const selectAll    = document.getElementById('selectAllJamPelajaran');
        const toolbar      = document.getElementById('bulkActionsToolbar');

        if (countSpan) countSpan.textContent = count;

        if (selectAll && totalBoxes.length > 0) {
            selectAll.checked = (checkedBoxes.length === totalBoxes.length);
        }

        if (toolbar) {
            if (count > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
            } else {
                toolbar.classList.remove('flex');
                toolbar.classList.add('hidden');
            }
        }
    }

    function deselectAllJamPelajaran() {
        const checkboxes = document.querySelectorAll('.jam-select-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllJamPelajaran');
        if (selectAll) selectAll.checked = false;
        updateBulkDeleteState();
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data sesi jam pelajaran yang ingin dihapus dengan mencentang kotak centang.');
            return;
        }

        const modalCountText = document.getElementById('modalBulkCountText');
        if (modalCountText) {
            modalCountText.textContent = count + ' data sesi jam pelajaran';
        }

        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) {
            modal.classList.add('show');
        }
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) modal.classList.remove('show');
    }

    function submitBulkDelete() {
        document.getElementById('formBulkDelete').submit();
    }

    // Single Delete Modal
    function confirmSingleDelete(id, name) {
        const nameText = document.getElementById('singleDeleteJamKeText');
        if (nameText) nameText.textContent = name;

        const formAction = document.getElementById('singleDeleteFormAction');
        if (formAction) {
            formAction.action = "{{ url('jam-pelajaran') }}/" + id;
        }

        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) modal.classList.add('show');
    }

    function closeSingleDeleteModal() {
        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) modal.classList.remove('show');
    }

    // Client-side pagination logic
    let currentPage = 1;
    const itemsPerPage = 15;

    function initPagination() {
        const rows = document.querySelectorAll('#jamTableBody tr.jam-row');
        const totalItems = rows.length;
        if (totalItems === 0) return;

        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (totalPages <= 1) {
            // Only 1 page, hide or disable prev/next
            document.getElementById('btnPrevPage').disabled = true;
            document.getElementById('btnNextPage').disabled = true;
            return;
        }

        renderPage(1);
    }

    function renderPage(page) {
        const rows = document.querySelectorAll('#jamTableBody tr.jam-row');
        const totalItems = rows.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        const startIdx = (page - 1) * itemsPerPage;
        const endIdx = Math.min(startIdx + itemsPerPage, totalItems);

        rows.forEach((row, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update indicators
        const startElem = document.getElementById('showingStart');
        const endElem = document.getElementById('showingEnd');
        if (startElem) startElem.textContent = startIdx + 1;
        if (endElem) endElem.textContent = endIdx;

        // Update Prev / Next buttons
        const btnPrev = document.getElementById('btnPrevPage');
        const btnNext = document.getElementById('btnNextPage');
        if (btnPrev) {
            btnPrev.disabled = (currentPage === 1);
            if (btnPrev.disabled) {
                btnPrev.className = "px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 font-medium cursor-not-allowed transition";
            } else {
                btnPrev.className = "px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition";
            }
        }
        if (btnNext) {
            btnNext.disabled = (currentPage === totalPages);
            if (btnNext.disabled) {
                btnNext.className = "px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 font-medium cursor-not-allowed transition";
            } else {
                btnNext.className = "px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium cursor-pointer transition";
            }
        }

        // Render page number buttons
        const pageNumbersContainer = document.getElementById('paginationPageNumbers');
        if (pageNumbersContainer) {
            let html = '';
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += `<button type="button" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold shadow-2xs cursor-default">${i}</button>`;
                } else {
                    html += `<button type="button" onclick="changePage(${i})" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-medium transition cursor-pointer">${i}</button>`;
                }
            }
            pageNumbersContainer.innerHTML = html;
        }
    }

    function changePage(page) {
        renderPage(page);
    }

    // Page Load Initialization
    document.addEventListener('DOMContentLoaded', function() {
        calculateDurations();
        initPagination();

        const selectAll = document.getElementById('selectAllJamPelajaran');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.jam-select-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteState();
            });
        }

        // Backdrop click to close modals
        ['modalConfirmBulkDelete', 'modalConfirmSingleDelete'].forEach(id => {
            const modal = document.getElementById(id);
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) this.classList.remove('show');
                });
            }
        });
    });
</script>

@endsection