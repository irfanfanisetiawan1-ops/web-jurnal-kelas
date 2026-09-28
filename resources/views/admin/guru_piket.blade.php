@extends('layouts.admin')

@section('title', 'Master Data Guru Piket — EDU JOURNAL')

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
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#0f2744',
              blue: '#1d4ed8',
              accent: '#2563eb',
              light: '#f1f5f9',
            }
          },
          boxShadow: {
            'elevated': '0 4px 20px -2px rgba(11, 28, 48, 0.05), 0 2px 6px -1px rgba(11, 28, 48, 0.03)',
            'floating': '0 12px 32px -4px rgba(11, 28, 48, 0.08), 0 4px 12px -2px rgba(11, 28, 48, 0.03)',
          }
        }
      }
    }
</script>

<style data-purpose="custom-scrollbars">
    /* Subtle custom scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f8fafc;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Modal Backdrop & Popup */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
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
        box-shadow: 0 20px 35px -8px rgba(11, 28, 48, 0.15);
        width: 100%;
        max-width: 32rem;
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalPop {
        from { transform: scale(0.96); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 800; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Manajemen Data <span style="color: #2563eb; font-weight: 800;">Guru Piket</span>
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 520px;">
        Kelola hak akses dan penugasan petugas piket harian sekolah.
    </p>
</div>
@endsection

@section('content')

<!-- Flash Messages -->
@if(session('success'))
    <div class="p-3.5 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="p-3.5 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
    </div>
@endif

<div class="space-y-5">
    <!-- BEGIN: FormCard (Tambah Guru Piket Baru / Locked State) -->
    <section class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100" data-purpose="form-tambah-guru-piket">
        <!-- Title & Indicator Row -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-2">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-[#0f2744]">Tambah Guru Piket Baru</h3>
                @if(count($guruPikets) > 0)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100/80 text-amber-800 border border-amber-200">
                        <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" fill-rule="evenodd"></path>
                        </svg>
                        FITUR TERKUNCI (Maks. 1 Akun Piket)
                    </span>
                @endif
            </div>

            <!-- Lihat Tong Sampah Button -->
            <a href="{{ route('admin.guru-piket.trash') }}" class="flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100/80 text-amber-700 border border-amber-200/60 rounded-xl text-xs font-bold transition-all shadow-2xs no-underline">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Lihat Tong Sampah</span>
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="ml-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>

        <p class="text-xs text-slate-400 mt-1 font-medium">Masukkan data petugas piket untuk pendaftaran hak akses piket harian. Akun juga tersimpan di Master Data Pengguna.</p>

        @if(count($guruPikets) > 0)
            <!-- Warning Alert Banner -->
            <div class="mt-4 p-4 rounded-xl bg-[#fffbeb] border border-amber-200/80 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-amber-900">Fitur Tambah Guru Piket Baru Dikunci</h4>
                    <p class="text-[11px] leading-relaxed text-amber-800 mt-0.5">
                        Sistem dirancang hanya menggunakan <strong class="font-bold">1 akun Guru Piket</strong>. Karena data akun Guru Piket saat ini masih terdaftar pada <strong class="font-bold">Daftar Petugas Piket Terdaftar</strong> di bawah, fitur Tambah Guru Piket Baru ini otomatis dikunci. Jika ingin menambah/mengganti akun baru, hapus data akun yang ada terlebih dahulu.
                    </p>
                </div>
            </div>
        @endif

        <!-- Client-side Validation Error Banner -->
        <div id="formErrorReasonBanner" class="hidden mt-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold shadow-xs">
            <div class="flex items-start gap-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <div class="flex-1">
                    <h4 class="font-bold text-rose-900 mb-1">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                    <ul id="formErrorReasonList" class="list-disc list-inside space-y-0.5 text-rose-800 text-[11px] font-medium"></ul>
                </div>
                <button type="button" onclick="document.getElementById('formErrorReasonBanner').classList.add('hidden')" class="text-rose-600 hover:text-rose-800 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
            </div>
        </div>

        <form id="formGuruPiket" action="{{ route('admin.guru-piket.store') }}" method="POST" novalidate>
            @csrf

            <!-- Form Fields Grid (5 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-5 {{ count($guruPikets) > 0 ? 'opacity-70 pointer-events-none' : '' }}">
                <!-- Field 1: NIP -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="text-[11px] font-bold text-slate-600">NIP (18 Digit) <span class="text-rose-500">*</span></label>
                        <span id="nipCounter" class="text-[10px] font-semibold text-rose-500 font-mono">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 placeholder-slate-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all {{ count($guruPikets) > 0 ? 'cursor-not-allowed' : '' }}"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    <p id="nipMsg" class="text-[10px] font-medium text-rose-500 mt-1">Wajib diisi tepat 18 digit angka.</p>
                    @error('nip')
                        <p class="text-[10px] font-medium text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Field 2: Nama Lengkap -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Nama Lengkap Petugas Piket <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 placeholder-slate-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all {{ count($guruPikets) > 0 ? 'cursor-not-allowed' : '' }}"
                        placeholder="Nama Lengkap Beserta Gelar"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    @error('name')
                        <p class="text-[10px] font-medium text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Field 3: Jenis Kelamin -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Jenis Kelamin</label>
                    <div class="relative">
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none {{ count($guruPikets) > 0 ? 'cursor-not-allowed' : '' }}"
                            {{ count($guruPikets) > 0 ? 'disabled' : '' }}>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Field 4: Nomor HP / WA -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Nomor HP / WhatsApp</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 placeholder-slate-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all {{ count($guruPikets) > 0 ? 'cursor-not-allowed' : '' }}"
                        placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }}>
                    @error('no_hp')
                        <p class="text-[10px] font-medium text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Field 5: Password Akun Login -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Password Akun Login <span class="text-rose-500">*</span></label>
                    <input type="password" id="password" name="password"
                        class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 placeholder-slate-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all {{ count($guruPikets) > 0 ? 'cursor-not-allowed' : '' }}"
                        placeholder="Minimal 6 karakter" minlength="6"
                        oninput="checkPasswordMinLength(this, 'passwordMsg');"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    <p id="passwordMsg" class="text-[10px] font-medium text-rose-500 mt-1">Wajib diisi minimal 6 karakter.</p>
                    @error('password')
                        <p class="text-[10px] font-medium text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Button Area -->
            <div class="mt-4 pt-2 flex justify-end">
                @if(count($guruPikets) > 0)
                    <button type="button" class="flex items-center gap-2 px-5 py-2.5 bg-slate-400/90 text-white rounded-xl text-xs font-bold shadow-sm cursor-not-allowed opacity-90 transition-all" disabled title="Fitur Tambah Guru Piket dikunci karena akun guru piket sudah terdaftar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Fitur Dikunci (Akun Guru Piket Sudah Ada)</span>
                    </button>
                @else
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Simpan Data Guru Piket</span>
                    </button>
                @endif
            </div>
        </form>
    </section>
    <!-- END: FormCard -->

    <!-- BEGIN: TableCard (Daftar Petugas Piket Terdaftar) -->
    <section class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100" data-purpose="tabel-daftar-guru-piket">
        <!-- Table Header & Filter Bar -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-black text-[#0f2744]">Daftar Petugas Piket Terdaftar <span class="font-semibold text-slate-500">({{ count($guruPikets) }})</span></h3>
                </div>
                <p class="text-xs text-slate-400 mt-1 font-medium">Kelola seluruh akun petugas piket yang aktif di sistem.</p>
            </div>

            <!-- Search and Action Form -->
            <form action="{{ route('admin.guru-piket') }}" method="GET" class="flex items-center gap-2 w-full lg:w-auto">
                <div class="relative flex-1 lg:w-72">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="w-full text-xs rounded-xl bg-slate-50/70 border-slate-200 text-slate-700 pl-8 pr-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder:text-slate-400"
                        placeholder="Cari nama / NIP / username...">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-[#1c355e] hover:bg-[#0f2744] text-white rounded-xl text-xs font-bold transition-all shadow-sm cursor-pointer whitespace-nowrap">
                    Cari
                </button>
                <a href="{{ route('admin.guru-piket') }}" class="px-4 py-2 bg-amber-400 hover:bg-amber-500 text-slate-900 rounded-xl text-xs font-bold transition-all shadow-sm no-underline whitespace-nowrap">
                    Reset
                </a>
            </form>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto rounded-xl border border-slate-100 mt-2">
            <table class="w-full text-left border-collapse" data-purpose="table-guru-piket" id="piketTable">
                <thead>
                    <tr class="bg-slate-50/90 text-slate-500 text-[11px] font-bold tracking-wider uppercase border-b border-slate-100">
                        <th class="py-3 px-4 w-12 text-center" scope="col">NO</th>
                        <th class="py-3 px-4" scope="col">NIP / USERNAME</th>
                        <th class="py-3 px-4" scope="col">NAMA PETUGAS PIKET</th>
                        <th class="py-3 px-4" scope="col">NO HP / WHATSAPP</th>
                        <th class="py-3 px-4 text-center w-36" scope="col">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs" id="piketTableBody">
                    @forelse($guruPikets as $index => $u)
                        <tr class="hover:bg-slate-50/70 transition-colors piket-data-row" onclick="openDetailModal({{ json_encode($u) }})" style="cursor: pointer;" title="Klik baris untuk melihat rincian detail akun">
                            <!-- Column 1: NO -->
                            <td class="py-4 px-4 text-center font-bold text-slate-600">{{ $index + 1 }}</td>

                            <!-- Column 2: NIP / USERNAME -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-bold text-blue-600 text-xs font-mono tracking-wide">{{ $u->nip ?: '-' }}</div>
                                <div class="text-[10px] text-slate-400 font-medium mt-0.5">User: {{ $u->username ?? '-' }}</div>
                            </td>

                            <!-- Column 3: NAMA PETUGAS PIKET -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $u->name }}</div>
                                <div class="text-[10px] text-slate-400 font-semibold mt-0.5">Role: Petugas Piket</div>
                            </td>

                            <!-- Column 4: NO HP / WHATSAPP -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @php
                                    $phone = optional($u->guru)->no_hp ?? ($u->no_hp ?? null);
                                @endphp
                                @if(!empty($phone))
                                    <span class="inline-flex items-center gap-1.5 text-slate-700 font-mono font-medium">
                                        <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                        <span>{{ $phone }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Column 5: AKSI -->
                            <td class="py-4 px-4 text-center" onclick="event.stopPropagation();">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    @if($u->status_verifikasi === 'pending')
                                        <form action="{{ route('admin.verifikasi-guru.approve', $u->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors cursor-pointer border-none" title="Setujui Akun Piket">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi-guru.reject', $u->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors cursor-pointer border-none" title="Tolak Akun Piket">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Button: Detail -->
                                        <button type="button" onclick="openDetailModal({{ json_encode($u) }})" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition cursor-pointer border-none" title="Lihat Detail Profil">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        <!-- Button: Edit -->
                                        <button type="button" onclick="openEditModal({{ json_encode($u) }})" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition cursor-pointer border-none" title="Edit Data & Hak Akses">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                </svg>
                                Belum ada data Guru Piket yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination / Footer Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 text-xs text-slate-400 font-medium">
            <p>Menampilkan <span class="font-bold text-slate-700" id="paginationRangeText">{{ count($guruPikets) > 0 ? '1 sampai ' . count($guruPikets) : '0' }}</span> dari <span class="font-bold text-slate-700">{{ count($guruPikets) }}</span> entri guru piket</p>
            <div class="flex items-center gap-1 self-end sm:self-auto" id="paginationControls">
                <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled>Sebelumnya</button>
                <button type="button" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-sm shadow-blue-300">1</button>
                <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled>Berikutnya</button>
            </div>
        </div>
    </section>
    <!-- END: TableCard -->
</div>

<!-- ─────────────────────────────────────────────────────────────────────────── -->
<!-- MODALS SECTION -->
<!-- ─────────────────────────────────────────────────────────────────────────── -->

<!-- Modal 1: Edit Data & Role -->
<div class="modal-backdrop-custom" id="modalEditUser">
    <div class="modal-box-custom">
        <div class="p-4 sm:p-5 bg-[#0f2744] text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <h3 class="text-sm font-bold">Ubah Data & Status Guru Piket</h3>
            </div>
            <button type="button" class="text-slate-300 hover:text-white cursor-pointer" onclick="closeModal('modalEditUser')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            <div class="p-5 space-y-3.5 max-h-[75vh] overflow-y-auto text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit_name" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">NIP (18 Digit) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" id="edit_nip" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono" maxlength="18" required>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="edit_jk" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono" placeholder="081234567890">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Role Hak Akses <span class="text-rose-500">*</span></label>
                        <select name="role" id="edit_role" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                            <option value="piket">Guru Piket</option>
                            <option value="guru">Guru Mapel</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="tu">Admin / TU (Tata Usaha)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Verifikasi <span class="text-rose-500">*</span></label>
                        <select name="status_verifikasi" id="edit_status" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                            <option value="verified">Verified (Disetujui)</option>
                            <option value="pending">Pending (Menunggu)</option>
                            <option value="rejected">Rejected (Ditolak)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition cursor-pointer" onclick="closeModal('modalEditUser')">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-xs transition cursor-pointer">Update Data Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Ubah Password -->
<div class="modal-backdrop-custom" id="modalResetPassword">
    <div class="modal-box-custom">
        <div class="p-4 sm:p-5 bg-purple-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <h3 class="text-sm font-bold">Ubah Sandi Guru Piket</h3>
            </div>
            <button type="button" class="text-purple-200 hover:text-white cursor-pointer" onclick="closeModal('modalResetPassword')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </button>
        </div>
        <form id="formResetPassword" method="POST" onsubmit="return validateResetPasswordSubmit(event)">
            @csrf
            <div class="p-5 space-y-3.5 text-xs">
                <p class="text-slate-600">
                    Anda akan mengubah password untuk akun: <strong id="reset_user_name" class="text-slate-900 font-bold"></strong>
                </p>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="reset_password" name="password" class="w-full text-xs rounded-xl border-slate-200 pr-10 focus:border-purple-500 focus:ring-1 focus:ring-purple-500" placeholder="Minimal 6 karakter" minlength="6" required oninput="validateResetPasswordMatch()">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer" onclick="togglePasswordVisibility('reset_password', this)" title="Tampilkan/Sembunyikan Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="reset_password_confirmation" name="password_confirmation" class="w-full text-xs rounded-xl border-slate-200 pr-10 focus:border-purple-500 focus:ring-1 focus:ring-purple-500" placeholder="Ulangi password baru" minlength="6" required oninput="validateResetPasswordMatch()">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer" onclick="togglePasswordVisibility('reset_password_confirmation', this)" title="Tampilkan/Sembunyikan Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                    </div>
                </div>

                <p id="resetPasswordMatchMsg" class="hidden text-[11px] font-semibold mt-1"></p>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition cursor-pointer" onclick="closeModal('modalResetPassword')">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-purple-600 hover:bg-purple-700 text-white shadow-xs transition cursor-pointer">Simpan Password Baru</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: View Detail (Modern & Interactive) -->
<div class="modal-backdrop-custom" id="modalDetailUser">
    <div class="modal-box-custom max-w-lg">
        <!-- Header Gradien Biru-Indigo -->
        <div class="p-5 bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl">badge</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-tight text-white" id="modalDetailTitle">Detail Petugas Piket</h3>
                    <p class="text-[11px] text-blue-200 mt-0.5">Informasi profil lengkap, status akun, dan hak akses piket</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalDetailUser')" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="p-5 space-y-4 max-h-[75vh] overflow-y-auto text-left">
            <!-- Headline Profil Card -->
            <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-base shrink-0 border-2 border-blue-200" id="detail_avatar">
                    GP
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-extrabold text-slate-800 truncate" id="detail_name">-</h4>
                    <div class="flex flex-wrap items-center gap-1.5 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10.5px] font-mono font-bold bg-blue-100/70 text-blue-800 border border-blue-200" id="detail_nip">-</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10.5px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200" id="detail_role">PETUGAS PIKET</span>
                        <span id="detail_status_badge" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Grid Informasi (Jenis Kelamin & Username) -->
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Kelamin</span>
                    <span class="text-xs font-bold text-slate-800" id="detail_jk">-</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Username Login</span>
                    <span class="text-xs font-mono font-bold text-blue-700 truncate block" id="detail_username">-</span>
                </div>
            </div>

            <!-- Grid Informasi (Email & Waktu Terdaftar) -->
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Email</span>
                    <span class="text-xs font-medium text-slate-700 truncate block" id="detail_email">-</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Terdaftar Sejak</span>
                    <span class="text-xs font-medium text-slate-700 truncate block" id="detail_created_at">-</span>
                </div>
            </div>

            <!-- Kontak No HP / WhatsApp -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-200/60 flex items-center justify-between">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nomor HP / WhatsApp</span>
                    <span class="text-xs font-mono font-bold text-slate-800" id="detail_no_hp">-</span>
                </div>
                <a id="detail_wa_link" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition no-underline">
                    <i class="fa-brands fa-whatsapp text-sm text-emerald-600"></i>
                    <span>Chat WA</span>
                </a>
            </div>
        </div>

        <!-- Footer Aksi Terpadu -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
            <!-- Tombol Hapus (Kiri) -->
            <button type="button" id="detail_btn_delete" onclick="triggerDeleteFromDetail()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Hapus Akun</span>
            </button>

            <!-- Aksi Kanan: Ubah Pass, Edit Data, Tutup -->
            <div class="flex items-center gap-2">
                <button type="button" id="detail_btn_pass" onclick="triggerResetPasswordFromDetail()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 transition cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Ubah Sandi</span>
                </button>
                <button type="button" id="detail_btn_edit" onclick="triggerEditFromDetail()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-amber-800 bg-amber-100/80 hover:bg-amber-200 border border-amber-300 transition cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Edit</span>
                </button>
                <button type="button" onclick="closeModal('modalDetailUser')" class="px-4 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Konfirmasi Hapus (Soft Delete) -->
<div class="modal-backdrop-custom" id="modalDeletePiket">
    <div class="modal-box-custom max-w-sm">
        <form id="formDeletePiket" method="POST">
            @csrf
            @method('DELETE')
            <div class="p-5 text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 mb-1">Hapus Akun Guru Piket</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Apakah Anda yakin ingin memindahkan akun <strong id="delete_user_name" class="text-rose-600 font-bold"></strong> ke Tempat Sampah?
                </p>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-center gap-2">
                <button type="button" class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition cursor-pointer" onclick="closeModal('modalDeletePiket')">Batal</button>
                <button type="submit" class="flex-1 py-2 px-3 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-xs transition cursor-pointer">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function updateNipCounter(input, targetLen = 18, msgId = 'nipMsg') {
        const counter = document.getElementById('nipCounter');
        const msgEle  = document.getElementById(msgId);
        const len     = input.value.length;

        if (counter) {
            counter.textContent = len + '/' + targetLen + ' digit';
            counter.className = (len === targetLen) 
                ? 'text-[10px] font-semibold text-emerald-600 font-mono' 
                : 'text-[10px] font-semibold text-rose-500 font-mono';
        }

        if (msgEle) {
            if (len === 0) {
                msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                msgEle.className = 'text-[10px] font-medium text-rose-500 mt-1';
            } else if (len < targetLen) {
                msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                msgEle.className = 'text-[10px] font-medium text-rose-500 mt-1';
            } else {
                msgEle.textContent = '✓ Format NIP ' + targetLen + ' digit angka sudah sesuai.';
                msgEle.className = 'text-[10px] font-medium text-emerald-600 mt-1';
            }
        }
    }

    function checkPasswordMinLength(input, msgId = 'passwordMsg') {
        const msgEle = document.getElementById(msgId);
        if (!msgEle) return;
        const len = input.value.length;
        if (len === 0) {
            msgEle.textContent = 'Wajib diisi minimal 6 karakter.';
            msgEle.className = 'text-[10px] font-medium text-rose-500 mt-1';
        } else if (len < 6) {
            msgEle.textContent = 'Password terlalu pendek, baru ' + len + ' karakter (minimal 6 karakter).';
            msgEle.className = 'text-[10px] font-medium text-rose-500 mt-1';
        } else {
            msgEle.textContent = '✓ Password memenuhi syarat (minimal 6 karakter).';
            msgEle.className = 'text-[10px] font-medium text-emerald-600 mt-1';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const nip = document.getElementById('nip');
        if (nip) updateNipCounter(nip, 18, 'nipMsg');

        const form = document.getElementById('formGuruPiket');
        if (form) {
            form.addEventListener('submit', function(e) {
                const errors = [];
                const nipVal  = document.getElementById('nip').value.trim();
                const namaVal = document.getElementById('name').value.trim();
                const passVal = document.getElementById('password').value;

                if (!nipVal) {
                    errors.push('NIP wajib diisi 18 digit angka.');
                } else if (nipVal.length !== 18) {
                    errors.push('NIP harus berisi tepat 18 digit angka (saat ini baru ' + nipVal.length + ' digit).');
                }

                if (!namaVal) {
                    errors.push('Nama Lengkap Petugas Piket wajib diisi.');
                }

                if (!passVal) {
                    errors.push('Password akun login wajib diisi minimal 6 karakter.');
                } else if (passVal.length < 6) {
                    errors.push('Password akun login minimal 6 karakter (saat ini baru ' + passVal.length + ' karakter).');
                }

                const banner = document.getElementById('formErrorReasonBanner');
                const list   = document.getElementById('formErrorReasonList');

                if (errors.length > 0) {
                    e.preventDefault();
                    list.innerHTML = '';
                    errors.forEach(function(err) {
                        const li = document.createElement('li');
                        li.textContent = err;
                        list.appendChild(li);
                    });
                    banner.classList.remove('hidden');
                    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    banner.classList.add('hidden');
                }
            });
        }

        // Setup pagination for table
        setupTablePagination();
    });

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('show');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('show');
    }

    // Close on outside click
    document.querySelectorAll('.modal-backdrop-custom').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
            }
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop-custom.show').forEach(m => m.classList.remove('show'));
        }
    });

    function openEditModal(user) {
        document.getElementById('formEditUser').action = '/admin/verifikasi-guru/' + user.id + '/update-role';
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_nip').value = user.nip || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role').value = user.role || 'piket';
        document.getElementById('edit_status').value = user.status_verifikasi || 'verified';
        
        let jkVal = (user.guru && user.guru.jenis_kelamin) ? user.guru.jenis_kelamin : (user.jenis_kelamin || '');
        let noHpVal = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '');
        
        if (document.getElementById('edit_jk')) document.getElementById('edit_jk').value = jkVal;
        if (document.getElementById('edit_no_hp')) document.getElementById('edit_no_hp').value = noHpVal;

        openModal('modalEditUser');
    }

    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>';
        }
    }

    function openResetPasswordModal(userId, userName) {
        document.getElementById('formResetPassword').action = '/admin/users/' + userId + '/reset-password';
        document.getElementById('reset_user_name').innerText = userName;

        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');

        if (pass) {
            pass.value = '';
            pass.type = 'password';
        }
        if (confirmPass) {
            confirmPass.value = '';
            confirmPass.type = 'password';
        }
        if (msg) {
            msg.className = 'hidden text-[11px] font-semibold mt-1';
            msg.innerText = '';
        }

        openModal('modalResetPassword');
    }

    function validateResetPasswordMatch() {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');

        if (!pass || !confirmPass || !msg) return true;

        const passVal = pass.value;
        const confirmVal = confirmPass.value;

        if (!passVal && !confirmVal) {
            msg.className = 'hidden text-[11px] font-semibold mt-1';
            return true;
        }

        if (passVal.length > 0 && passVal.length < 6) {
            msg.className = 'block text-[11px] font-semibold text-rose-500 mt-1';
            msg.innerHTML = 'Password minimal 6 karakter.';
            return false;
        }

        if (confirmVal.length > 0) {
            if (passVal === confirmVal) {
                msg.className = 'block text-[11px] font-semibold text-emerald-600 mt-1';
                msg.innerHTML = '✓ Konfirmasi password cocok.';
                return true;
            } else {
                msg.className = 'block text-[11px] font-semibold text-rose-500 mt-1';
                msg.innerHTML = 'Konfirmasi password baru tidak cocok.';
                return false;
            }
        } else {
            msg.className = 'hidden text-[11px] font-semibold mt-1';
            return false;
        }
    }

    function validateResetPasswordSubmit(event) {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');

        if (pass && confirmPass) {
            if (pass.value.length < 6) {
                alert('Password minimal 6 karakter.');
                pass.focus();
                event.preventDefault();
                return false;
            }
            if (pass.value !== confirmPass.value) {
                alert('Konfirmasi Password Baru tidak cocok dengan Password Baru! Harap periksa kembali.');
                confirmPass.focus();
                event.preventDefault();
                return false;
            }
        }
        return true;
    }

    let currentDetailUser = null;

    function openDetailModal(user) {
        currentDetailUser = user;

        const titleEl = document.getElementById('modalDetailTitle');
        if (titleEl) titleEl.innerText = user.name ? 'Detail - ' + user.name : 'Detail Petugas Piket';

        // Avatar Initials
        const words = (user.name || '').trim().split(' ');
        let initials = 'GP';
        if (words.length >= 2 && words[0] && words[1]) {
            initials = (words[0][0] + words[1][0]).toUpperCase();
        } else if (words.length === 1 && words[0].length > 0) {
            initials = words[0].substring(0, 2).toUpperCase();
        }
        const avatarEl = document.getElementById('detail_avatar');
        if (avatarEl) avatarEl.textContent = initials;

        document.getElementById('detail_name').innerText = user.name || '-';
        document.getElementById('detail_nip').innerText = user.nip || '-';
        document.getElementById('detail_username').innerText = user.username || '-';
        document.getElementById('detail_email').innerText = user.email || '-';
        document.getElementById('detail_role').innerText = user.role ? (user.role === 'piket' ? 'PETUGAS PIKET' : user.role.toUpperCase()) : 'PETUGAS PIKET';
        document.getElementById('detail_created_at').innerText = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) : '-';

        // Status Verifikasi Badge
        const statusBadgeEl = document.getElementById('detail_status_badge');
        if (statusBadgeEl) {
            const status = (user.status_verifikasi || 'verified').toLowerCase();
            if (status === 'verified') {
                statusBadgeEl.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
                statusBadgeEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi';
            } else if (status === 'pending') {
                statusBadgeEl.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-amber-50 text-amber-700 border border-amber-200';
                statusBadgeEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending';
            } else {
                statusBadgeEl.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-rose-50 text-rose-700 border border-rose-200';
                statusBadgeEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak';
            }
        }

        let jkText = '-';
        if (user.guru && user.guru.jenis_kelamin) {
            jkText = user.guru.jenis_kelamin === 'L' ? 'Laki-laki' : (user.guru.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        } else if (user.jenis_kelamin) {
            jkText = user.jenis_kelamin === 'L' ? 'Laki-laki' : (user.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        }
        let noHpText = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '-');

        if (document.getElementById('detail_jk')) document.getElementById('detail_jk').innerText = jkText;
        if (document.getElementById('detail_no_hp')) document.getElementById('detail_no_hp').innerText = noHpText;

        // WhatsApp Link
        const waLink = document.getElementById('detail_wa_link');
        if (waLink) {
            if (noHpText && noHpText !== '-') {
                let cleanPhone = noHpText.replace(/[^0-9]/g, '');
                if (cleanPhone.startsWith('0')) {
                    cleanPhone = '62' + cleanPhone.substring(1);
                }
                waLink.href = 'https://wa.me/' + cleanPhone;
                waLink.style.display = 'inline-flex';
            } else {
                waLink.style.display = 'none';
            }
        }

        // Hapus Button Visibility
        const deleteBtn = document.getElementById('detail_btn_delete');
        if (deleteBtn) {
            const currentAuthUserId = {{ Auth::id() ?? 0 }};
            if (user.id === currentAuthUserId) {
                deleteBtn.style.display = 'none';
            } else {
                deleteBtn.style.display = 'inline-flex';
            }
        }

        openModal('modalDetailUser');
    }

    function triggerDeleteFromDetail() {
        if (!currentDetailUser) return;
        closeModal('modalDetailUser');
        confirmDeletePiket(currentDetailUser.id, currentDetailUser.name);
    }

    function triggerResetPasswordFromDetail() {
        if (!currentDetailUser) return;
        closeModal('modalDetailUser');
        openResetPasswordModal(currentDetailUser.id, currentDetailUser.name);
    }

    function triggerEditFromDetail() {
        if (!currentDetailUser) return;
        closeModal('modalDetailUser');
        openEditModal(currentDetailUser);
    }

    function confirmDeletePiket(id, name) {
        document.getElementById('formDeletePiket').action = '/admin/guru-piket/' + id;
        document.getElementById('delete_user_name').innerText = name;
        openModal('modalDeletePiket');
    }

    /* Client-side Table Pagination */
    let currentTablePage = 1;
    const rowsPerPage = 8;

    function setupTablePagination() {
        const allRows = document.querySelectorAll('#piketTableBody tr.piket-data-row');
        const totalRows = allRows.length;
        const paginationControls = document.getElementById('paginationControls');
        const paginationRangeText = document.getElementById('paginationRangeText');

        if (!paginationControls) return;

        if (totalRows === 0) {
            paginationControls.innerHTML = '';
            if (paginationRangeText) paginationRangeText.textContent = '0 dari 0';
            return;
        }

        const totalPages = Math.ceil(totalRows / rowsPerPage);
        if (currentTablePage > totalPages) currentTablePage = totalPages;
        if (currentTablePage < 1) currentTablePage = 1;

        const startIdx = (currentTablePage - 1) * rowsPerPage;
        const endIdx = Math.min(startIdx + rowsPerPage, totalRows);

        allRows.forEach((row, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        if (paginationRangeText) {
            paginationRangeText.textContent = `${startIdx + 1} sampai ${endIdx}`;
        }

        let paginationHTML = '';
        if (currentTablePage > 1) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage - 1})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">Sebelumnya</button>`;
        } else {
            paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled>Sebelumnya</button>`;
        }

        for (let p = 1; p <= totalPages; p++) {
            if (p === currentTablePage) {
                paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-sm shadow-blue-300">${p}</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">${p}</button>`;
            }
        }

        if (currentTablePage < totalPages) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage + 1})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">Berikutnya</button>`;
        } else {
            paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled>Berikutnya</button>`;
        }

        paginationControls.innerHTML = paginationHTML;
    }

    function goToTablePage(page) {
        currentTablePage = page;
        setupTablePagination();
    }
</script>
@endsection
