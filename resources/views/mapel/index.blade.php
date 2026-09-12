@extends('layouts.admin')

@section('title', 'Master Data Mata Pelajaran — EDU JOURNAL')

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
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
              950: '#0f2744',
            }
          },
          boxShadow: {
            'card-subtle': '0 2px 10px 0 rgba(15, 23, 42, 0.04)',
            'floating': '0 10px 30px -5px rgba(22, 34, 51, 0.08), 0 4px 12px -2px rgba(22, 34, 51, 0.04)',
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

    /* Detail Modal Specific Styling */
    .detail-modal-box {
        max-width: 980px;
        width: 100%;
        max-height: 90vh;
        border-radius: 1.25rem;
        background: #ffffff;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title text-base font-extrabold text-slate-900 tracking-tight leading-none m-0 p-0">
        Master Data Mata Pelajaran
    </h1>
</div>
@endsection

@section('content')

<div class="space-y-6">

    <!-- Flash Notification Messages -->
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
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-start justify-between shadow-2xs">
            <div class="flex items-start gap-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <div>
                    <strong class="block font-bold mb-1">Pengisian data belum sesuai kriteria:</strong>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-700 font-normal">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    <!-- 1. CARD: Form Tambah Mata Pelajaran Baru -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-card-subtle p-5">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Tambah Mata Pelajaran Baru</h2>
                    <p class="text-xs text-slate-500">Input kurikulum mata pelajaran baru ke semester yang sedang aktif</p>
                </div>
            </div>
        </div>

        <form id="formTambahMapel" action="{{ route('mapel.store') }}" method="POST" onsubmit="return validateMapelForm(event)" class="mt-4 grid grid-cols-1 md:grid-cols-12 gap-3.5 items-end">
            @csrf
            
            <!-- Kode Mapel -->
            <div class="md:col-span-3">
                <div class="flex justify-between items-center mb-1">
                    <label class="text-xs font-semibold text-slate-700" for="kode_mapel">
                        Kode Mapel <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[10px] text-slate-400 font-medium">Maks. 15</span>
                </div>
                <input type="text" id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel') }}" maxlength="15"
                    class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2.5 text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 font-mono uppercase transition-all @error('kode_mapel') border-rose-400 bg-rose-50/50 @enderror"
                    placeholder="e.g. BAH-02" required>
                @error('kode_mapel')
                    <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Mata Pelajaran -->
            <div class="md:col-span-6">
                <label class="block text-xs font-semibold text-slate-700 mb-1" for="nama_mapel">
                    Nama Mata Pelajaran <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}" maxlength="100"
                    class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/60 px-3.5 py-2.5 text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all @error('nama_mapel') border-rose-400 bg-rose-50/50 @enderror"
                    placeholder="Masukkan nama lengkap mata pelajaran..." required>
                @error('nama_mapel')
                    <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-xl shadow-sm shadow-blue-500/30 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8l-4-4H8zm0 0v4a1 1 0 001 1h6a1 1 0 001-1V4M9 20v-6a1 1 0 011-1h4a1 1 0 011 1v6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Simpan Mapel</span>
                </button>
                <button type="reset" class="p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl border border-slate-200 transition-colors cursor-pointer" title="Reset Form Input">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. CARD: Tabel Master Data Mata Pelajaran -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-card-subtle overflow-hidden space-y-4">
        
        <!-- Search & Action Toolbar -->
        <div class="p-4 md:p-5 flex flex-col md:flex-row gap-3 items-center justify-between border-b border-slate-100">
            <!-- Search Form -->
            <form action="{{ route('mapel.index') }}" method="GET" class="relative w-full md:w-96 flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <input type="text" name="search" id="inputSearchMapel" value="{{ $search ?? '' }}"
                    class="w-full text-xs pl-10 pr-12 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-slate-700 placeholder-slate-400 transition-all"
                    placeholder="Cari nama atau kode mapel (e.g. BAH-02, DKV)...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-slate-200/60 rounded border border-slate-300/80">⌘K</kbd>
                </div>
            </form>

            <!-- Buttons: Cari, Reset, Sampah Mapel -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end flex-wrap">
                <button type="button" onclick="document.querySelector('form[action=\"{{ route('mapel.index') }}\"]').submit()" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-xl shadow-xs shadow-blue-500/20 transition-all cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"></path>
                    </svg>
                    <span>Cari</span>
                </button>

                <a href="{{ route('mapel.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors no-underline">
                    Reset
                </a>

                <a href="{{ route('mapel.trash') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 rounded-xl text-xs font-semibold shadow-2xs transition-colors shrink-0 no-underline">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Lihat Sampah Mapel</span>
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="ml-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">{{ $trashedCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Contextual Selection & Bulk Action Toolbar (Active only when 1+ checkboxes are checked) -->
        <div class="px-5">
            <div id="bulkActionsToolbar" class="hidden p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
                <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                        </svg>
                    </span>
                    <span>
                        <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> data mapel dipilih
                    </span>
                    <span class="text-rose-300 mx-1">|</span>
                    <button type="button" onclick="deselectAllMapel()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
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
        </div>

        <!-- Bulk Delete Form & Main Table -->
        <form id="formBulkDelete" action="{{ route('mapel.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-700 uppercase text-[11px] font-semibold tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">
                                <input type="checkbox" id="selectAllMapel" class="rounded border-slate-300 bg-white text-blue-600 focus:ring-0 focus:ring-offset-0 cursor-pointer" title="Pilih Semua (Select All)">
                            </th>
                            <th class="py-3.5 px-3 text-slate-600 font-semibold w-14">No</th>
                            <th class="py-3.5 px-4 text-slate-700">Kode Mapel</th>
                            <th class="py-3.5 px-6 text-slate-700">Nama Mata Pelajaran</th>
                            <th class="py-3.5 px-6 text-center text-slate-700">Guru Pengampu</th>
                            <th class="py-3.5 px-4 text-center text-slate-700">Status</th>
                            <th class="py-3.5 px-6 text-center text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal" id="mapelTableBody">
                        @forelse($mapels as $index => $m)
                            @php
                                $gurusCount = $m->gurus_count ?? count($m->gurus);
                                $bgColors = ['bg-indigo-500', 'bg-amber-500', 'bg-emerald-500', 'bg-sky-500', 'bg-rose-500', 'bg-purple-500'];
                                
                                $gurusData = $m->gurus->map(function($g) {
                                    return [
                                        'id_guru' => $g->id_guru,
                                        'nama_guru' => $g->nama_guru,
                                        'nip' => $g->nip ?? '-',
                                        'show_url' => route('guru.show', $g->id_guru),
                                    ];
                                });

                                $mapelPayload = [
                                    'id' => $m->id_mapel,
                                    'kode' => $m->kode_mapel,
                                    'nama' => $m->nama_mapel,
                                    'gurus_count' => $gurusCount,
                                    'edit_url' => route('mapel.edit', $m->id_mapel),
                                    'detail_url' => route('mapel.show', $m->id_mapel),
                                    'gurus' => $gurusData->values()->all(),
                                ];
                            @endphp
                            <tr class="hover:bg-blue-50/40 transition-colors mapel-row" data-index="{{ $index }}" data-id="{{ $m->id_mapel }}">
                                <td class="py-4 px-4 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $m->id_mapel }}" class="mapel-select-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" onchange="updateBulkDeleteState()">
                                </td>
                                <td class="py-4 px-3 text-slate-500 font-mono text-xs">{{ sprintf('%02d', $index + 1) }}</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-blue-50 text-blue-700 border border-blue-200/80">
                                        {{ $m->kode_mapel ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-900 text-sm">
                                    {{ $m->nama_mapel }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        @if($gurusCount > 0)
                                            <div class="flex -space-x-2 overflow-hidden">
                                                @foreach($m->gurus->take(3) as $gIdx => $g)
                                                    @php
                                                        $initials = collect(explode(' ', $g->nama_guru))->map(fn($w) => mb_substr($w, 0, 1))->take(2)->implode('');
                                                        $color = $bgColors[$gIdx % count($bgColors)];
                                                    @endphp
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $color }} text-white text-[10px] font-bold ring-2 ring-white" title="{{ $g->nama_guru }}">
                                                        {{ strtoupper($initials) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 font-semibold rounded-full text-[11px]">
                                                {{ $gurusCount }} Guru
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-400 font-medium rounded-full text-[11px]">
                                                0 Guru
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- 1. LIHAT DETAIL: Triggers Detail Modal dynamically -->
                                        <button type="button" onclick="showMapelDetail(this)"
                                            data-mapel="{{ json_encode($mapelPayload) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg border border-blue-200 text-xs transition-colors cursor-pointer"
                                            title="Lihat Detail Mapel & Guru Pengampu">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Lihat Detail</span>
                                        </button>

                                        <!-- 2. EDIT BUTTON -->
                                        <a href="{{ route('mapel.edit', $m->id_mapel) }}" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors inline-flex items-center justify-center" title="Edit Mapel">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                        </a>

                                        <!-- 3. HAPUS BUTTON -->
                                        <button type="button" onclick="confirmSingleDelete({{ $m->id_mapel }}, '{{ addslashes($m->nama_mapel) }}')" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer inline-flex items-center justify-center" title="Hapus Mapel">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                    <p class="font-bold text-slate-600 text-sm">Tidak ada data Mata Pelajaran ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Silakan gunakan form di atas untuk menambahkan data baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination & Rows Count Footer -->
        <div class="p-4 md:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-3 text-slate-500">
                <span>
                    Menampilkan <strong id="showingRange" class="text-slate-800 font-bold">1 - {{ count($mapels) > 0 ? min(10, count($mapels)) : 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ count($mapels) }}</strong> mata pelajaran
                </span>
                <span class="text-slate-300">|</span>
                <div class="flex items-center gap-1.5">
                    <span>Tampilkan:</span>
                    <select id="perPageSelect" onchange="changePerPage(this.value)" class="text-xs py-1 px-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-700 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                        <option value="10" selected>10 per halaman</option>
                        <option value="25">25 per halaman</option>
                        <option value="50">50 per halaman</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Pagination Buttons -->
            <div class="flex items-center space-x-1" id="paginationControls">
                <!-- Populated via JavaScript -->
            </div>
        </div>

    </div>

</div>

<!-- Hidden Delete Forms for Each Row -->
@foreach($mapels as $m)
    <form id="singleDeleteForm-{{ $m->id_mapel }}" action="{{ route('mapel.destroy', $m->id_mapel) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<!-- ========================================================================= -->
<!-- 3. MODAL: Detail Mapel (HIDDEN BY DEFAULT, Opens only on "Lihat Detail") -->
<!-- ========================================================================= -->
<div class="modal-backdrop-custom" id="detail-mapel-modal" onclick="handleDetailBackdropClick(event)">
    <div class="detail-modal-box">
        <!-- Top Navbar in Detail Modal -->
        <div class="p-4 md:p-5 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeDetailModal()" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 shadow-2xs transition-colors cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Kembali ke Daftar Mapel</span>
                </button>
                <span class="text-xs text-slate-400 font-mono">/</span>
                <span class="text-xs font-semibold text-slate-600">Detail Mapel</span>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" id="modalBtnDelete" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-semibold rounded-xl transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Hapus Mapel</span>
                </button>
                
                <a href="#" id="modalBtnEdit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors no-underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Edit Data Mapel</span>
                </a>

                <button type="button" onclick="closeDetailModal()" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 rounded-xl transition-colors ml-1 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body Scrollable -->
        <div class="overflow-y-auto p-5 md:p-6 space-y-5">
            
            <!-- Subject Overview Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 md:p-6 shadow-xs">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Diajarkan
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/80">
                        Kurikulum Merdeka / Nasional
                    </span>
                </div>

                <!-- Main Subject Title & Code -->
                <div class="flex flex-wrap items-baseline gap-3">
                    <h2 id="modalNamaMapel" class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">-</h2>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-semibold text-slate-400">KODE:</span>
                        <span id="modalKodeMapel" class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            -
                        </span>
                    </div>
                </div>

                <!-- Subject Metadata Line -->
                <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-4 md:gap-6 text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Total Pengampu: <strong id="modalTotalPengampu" class="text-slate-900">0 Guru Terdata</strong></span>
                    </div>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Status: <strong class="text-emerald-700">Aktif Digunakan</strong></span>
                    </div>
                </div>
            </div>

            <!-- Section: Daftar Guru Pengampu Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-4 md:p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Daftar Guru Pengampu</h3>
                            <span id="modalBadgeGurusCount" class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">0 Guru</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar tenaga pendidik yang mengampu mata pelajaran ini.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a id="modalDetailLengkapLink" href="#" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors no-underline">
                            <i class="fa-solid fa-up-right-and-down-left-from-center text-slate-500"></i>
                            <span>Halaman Detail Lengkap &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Table Guru Pengampu -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-600 uppercase text-[10px] font-bold tracking-wider border-b border-slate-100">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Guru & Identitas</th>
                                <th class="py-3 px-4">NIP</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="modalGurusTableBody" class="divide-y divide-slate-100">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 4. MODAL: Konfirmasi Hapus Single                                         -->
<!-- ========================================================================= -->
<div class="modal-backdrop-custom" id="modalConfirmSingleDelete">
    <div class="modal-box-custom p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-900 mb-1">Konfirmasi Hapus Mapel</h3>
        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
            Apakah Anda yakin ingin memindahkan mata pelajaran <strong id="singleDeleteMapelName" class="text-slate-900 font-bold"></strong> ke Tempat Sampah?
        </p>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="closeSingleDeleteModal()" class="flex-1 px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-xs font-bold hover:bg-slate-100 transition cursor-pointer">
                Batal
            </button>
            <button type="button" id="btnConfirmSingleDelete" class="flex-1 px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold hover:bg-rose-700 transition shadow-xs cursor-pointer">
                Ya, Hapus Data
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 5. MODAL: Konfirmasi Hapus Terpilih (Bulk Delete)                         -->
<!-- ========================================================================= -->
<div class="modal-backdrop-custom" id="modalConfirmBulkDelete">
    <div class="modal-box-custom p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-900 mb-1">Konfirmasi Hapus Terpilih</h3>
        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
            Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" class="text-rose-600 font-bold">0 data mapel</strong> yang dicentang ke Tempat Sampah?
        </p>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="closeBulkDeleteModal()" class="flex-1 px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-xs font-bold hover:bg-slate-100 transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitBulkDelete()" class="flex-1 px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold hover:bg-rose-700 transition shadow-xs cursor-pointer">
                Ya, Hapus Terpilih
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 6. JAVASCRIPT: Interactivity, Validation, Contextual Toolbar & Pagination -->
<!-- ========================================================================= -->
<script>
    // Form Validation for Tambah Mapel
    function validateMapelForm(e) {
        const kode = document.getElementById('kode_mapel').value.trim();
        const nama = document.getElementById('nama_mapel').value.trim();
        let errors = [];

        if (!kode) {
            errors.push('Kode Mapel wajib diisi!');
        } else if (kode.length > 15) {
            errors.push('Kode Mapel maksimal 15 karakter!');
        }

        if (!nama) {
            errors.push('Nama Mata Pelajaran wajib diisi!');
        } else if (nama.length > 100) {
            errors.push('Nama Mata Pelajaran maksimal 100 karakter!');
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
            if (!kode) document.getElementById('kode_mapel').focus();
            else if (!nama) document.getElementById('nama_mapel').focus();
            return false;
        }
        return true;
    }

    // Contextual Toolbar & Checkboxes
    function updateBulkDeleteState() {
        const visibleRows = Array.from(document.querySelectorAll('.mapel-row')).filter(r => r.style.display !== 'none');
        const visibleCheckboxes = visibleRows.map(r => r.querySelector('.mapel-select-checkbox')).filter(Boolean);
        const checkedBoxes = visibleCheckboxes.filter(cb => cb.checked);
        const count = checkedBoxes.length;

        const toolbar = document.getElementById('bulkActionsToolbar');
        const countSpan = document.getElementById('bulkDeleteCount');
        const selectAll = document.getElementById('selectAllMapel');

        if (countSpan) countSpan.textContent = count;

        if (selectAll) {
            selectAll.checked = (visibleCheckboxes.length > 0 && count === visibleCheckboxes.length);
        }

        if (toolbar) {
            if (count > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
            } else {
                toolbar.classList.add('hidden');
                toolbar.classList.remove('flex');
            }
        }
    }

    function deselectAllMapel() {
        document.querySelectorAll('.mapel-select-checkbox').forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllMapel');
        if (selectAll) selectAll.checked = false;
        updateBulkDeleteState();
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.mapel-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data mapel yang ingin dihapus dengan mencentang kotak centang (checkbox).');
            return;
        }

        const modalCountText = document.getElementById('modalBulkCountText');
        if (modalCountText) {
            modalCountText.textContent = count + ' data mapel';
        }

        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) modal.classList.add('show');
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) modal.classList.remove('show');
    }

    function submitBulkDelete() {
        document.getElementById('formBulkDelete').submit();
    }

    // Single Delete Modal
    let pendingDeleteId = null;
    function confirmSingleDelete(id, name) {
        pendingDeleteId = id;
        document.getElementById('singleDeleteMapelName').textContent = `"${name}"`;
        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) modal.classList.add('show');
    }

    function closeSingleDeleteModal() {
        pendingDeleteId = null;
        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) modal.classList.remove('show');
    }

    document.getElementById('btnConfirmSingleDelete').addEventListener('click', function() {
        if (pendingDeleteId) {
            const form = document.getElementById('singleDeleteForm-' + pendingDeleteId);
            if (form) form.submit();
        }
    });

    // Detail Modal Handlers
    const detailModal = document.getElementById('detail-mapel-modal');

    function openDetailModal() {
        if (detailModal) {
            detailModal.classList.add('show');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeDetailModal() {
        if (detailModal) {
            detailModal.classList.remove('show');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function handleDetailBackdropClick(event) {
        if (event.target === detailModal) {
            closeDetailModal();
        }
    }

    function showMapelDetail(buttonEl) {
        try {
            const data = JSON.parse(buttonEl.getAttribute('data-mapel'));
            
            document.getElementById('modalNamaMapel').textContent = data.nama || '-';
            document.getElementById('modalKodeMapel').textContent = data.kode || '-';
            document.getElementById('modalTotalPengampu').textContent = (data.gurus_count || 0) + ' Guru Terdata';
            document.getElementById('modalBadgeGurusCount').textContent = (data.gurus_count || 0) + ' Guru';
            
            const btnEdit = document.getElementById('modalBtnEdit');
            if (btnEdit && data.edit_url) btnEdit.href = data.edit_url;

            const btnDetailLengkap = document.getElementById('modalDetailLengkapLink');
            if (btnDetailLengkap && data.detail_url) btnDetailLengkap.href = data.detail_url;

            const btnDelete = document.getElementById('modalBtnDelete');
            if (btnDelete) {
                btnDelete.onclick = function() {
                    confirmSingleDelete(data.id, data.nama);
                };
            }

            const tbody = document.getElementById('modalGurusTableBody');
            tbody.innerHTML = '';

            if (data.gurus && data.gurus.length > 0) {
                const bgColors = ['bg-indigo-100 text-indigo-700', 'bg-amber-100 text-amber-700', 'bg-emerald-100 text-emerald-700', 'bg-sky-100 text-sky-700', 'bg-rose-100 text-rose-700', 'bg-purple-100 text-purple-700'];
                
                data.gurus.forEach((g, idx) => {
                    const initials = g.nama_guru.split(' ').map(w => w[0]).filter(Boolean).slice(0, 2).join('').toUpperCase() || 'GU';
                    const colorClass = bgColors[idx % bgColors.length];
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-slate-50/80 transition-colors';
                    tr.innerHTML = `
                        <td class="py-3.5 px-4 text-center text-slate-400 font-mono">${idx + 1}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full ${colorClass} font-bold flex items-center justify-center text-xs shrink-0">${initials}</div>
                                <div>
                                    <p class="font-bold text-slate-900 text-xs">${g.nama_guru}</p>
                                    <p class="text-[11px] text-slate-400">Guru Pengampu</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <p class="font-mono text-slate-700 text-xs">${g.nip || '-'}</p>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Aktif Mengajar
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <a href="${g.show_url}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-[11px] transition-colors no-underline" title="Lihat Profil Guru">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                <span>Profil</span>
                            </a>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-circle-info mb-1.5 text-base text-slate-300 block"></i>
                        Belum ada data guru pengampu yang terdaftar untuk mata pelajaran ini.
                    </td>
                `;
                tbody.appendChild(tr);
            }

            openDetailModal();
        } catch (err) {
            console.error('Error showing mapel detail:', err);
        }
    }

    // Client-side Pagination
    let currentPage = 1;
    let rowsPerPage = 10;

    function renderPagination() {
        const rows = Array.from(document.querySelectorAll('.mapel-row'));
        const totalRows = rows.length;
        const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(totalRows / rowsPerPage);

        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        rows.forEach((row, idx) => {
            if (rowsPerPage === 'all') {
                row.style.display = '';
            } else {
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                if (idx >= start && idx < end) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // Update range display text
        const showingRange = document.getElementById('showingRange');
        if (showingRange) {
            if (totalRows === 0) {
                showingRange.textContent = '0';
            } else if (rowsPerPage === 'all') {
                showingRange.textContent = `1 - ${totalRows}`;
            } else {
                const start = (currentPage - 1) * rowsPerPage + 1;
                const end = Math.min(currentPage * rowsPerPage, totalRows);
                showingRange.textContent = `${start} - ${end}`;
            }
        }

        // Render pagination buttons
        const controls = document.getElementById('paginationControls');
        if (!controls) return;
        controls.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = `p-1.5 rounded-lg border border-slate-200 ${currentPage === 1 ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 cursor-pointer'} transition-colors`;
        prevBtn.disabled = (currentPage === 1);
        prevBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>`;
        prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderPagination(); updateBulkDeleteState(); } };
        controls.appendChild(prevBtn);

        // Page numbers
        for (let p = 1; p <= totalPages; p++) {
            if (totalPages > 7) {
                if (p > 1 && p < currentPage - 1 && p === 2) {
                    const dots = document.createElement('span');
                    dots.className = 'px-1 text-slate-400';
                    dots.textContent = '...';
                    controls.appendChild(dots);
                    continue;
                }
                if (p > currentPage + 1 && p < totalPages && p === totalPages - 1) {
                    const dots = document.createElement('span');
                    dots.className = 'px-1 text-slate-400';
                    dots.textContent = '...';
                    controls.appendChild(dots);
                    continue;
                }
                if (p !== 1 && p !== totalPages && (p < currentPage - 1 || p > currentPage + 1)) {
                    continue;
                }
            }

            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.className = `w-7 h-7 rounded-lg text-xs font-semibold flex items-center justify-center transition-colors cursor-pointer ${p === currentPage ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100'}`;
            pageBtn.textContent = p;
            pageBtn.onclick = () => { currentPage = p; renderPagination(); updateBulkDeleteState(); };
            controls.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = `p-1.5 rounded-lg border border-slate-200 ${currentPage === totalPages ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 cursor-pointer'} transition-colors`;
        nextBtn.disabled = (currentPage === totalPages);
        nextBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>`;
        nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderPagination(); updateBulkDeleteState(); } };
        controls.appendChild(nextBtn);
    }

    function changePerPage(val) {
        rowsPerPage = val === 'all' ? 'all' : parseInt(val, 10);
        currentPage = 1;
        renderPagination();
        updateBulkDeleteState();
    }

    // Keyboard Shortcuts (Cmd/Ctrl + K to focus search, Esc to close modals)
    document.addEventListener('keydown', function(event) {
        if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
            event.preventDefault();
            const searchInput = document.getElementById('inputSearchMapel');
            if (searchInput) searchInput.focus();
        }

        if (event.key === 'Escape') {
            closeDetailModal();
            closeSingleDeleteModal();
            closeBulkDeleteModal();
        }
    });

    // DOM Ready Initializations
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkbox handler
        const selectAll = document.getElementById('selectAllMapel');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const visibleRows = Array.from(document.querySelectorAll('.mapel-row')).filter(r => r.style.display !== 'none');
                visibleRows.forEach(row => {
                    const cb = row.querySelector('.mapel-select-checkbox');
                    if (cb) cb.checked = selectAll.checked;
                });
                updateBulkDeleteState();
            });
        }

        // Initialize client-side pagination
        renderPagination();
        updateBulkDeleteState();

        // Close confirmation modals on backdrop click
        const singleModal = document.getElementById('modalConfirmSingleDelete');
        if (singleModal) {
            singleModal.addEventListener('click', function(e) {
                if (e.target === this) closeSingleDeleteModal();
            });
        }

        const bulkModal = document.getElementById('modalConfirmBulkDelete');
        if (bulkModal) {
            bulkModal.addEventListener('click', function(e) {
                if (e.target === this) closeBulkDeleteModal();
            });
        }
    });
</script>

@endsection
