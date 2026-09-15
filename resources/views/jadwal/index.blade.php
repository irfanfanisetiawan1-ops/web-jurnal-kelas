@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran — EDU JOURNAL')

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
              50: '#eff6ff',
              100: '#dbeafe',
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
        max-width: 460px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }

    .custom-select {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 0.75rem center;
      background-repeat: no-repeat;
      background-size: 1.25em 1.25em;
      padding-right: 2.5rem;
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title text-base font-extrabold text-slate-900 tracking-tight leading-none m-0 p-0">
        Jadwal Pelajaran
    </h1>
</div>
@endsection

@section('content')

<div class="space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold shadow-2xs">
            <span class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                </svg>
            </span>
            <div class="flex-1">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs font-semibold shadow-2xs">
            <span class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center shrink-0 text-rose-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
                    <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"/>
                </svg>
            </span>
            <div class="flex-1">{{ session('error') }}</div>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs font-semibold shadow-2xs space-y-1">
            <div class="flex items-center gap-2 text-rose-900 font-bold mb-1">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span>Terdapat Kesalahan Pengisian Formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Top Tab Navigation Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-1.5 flex items-center gap-1.5 shadow-2xs overflow-x-auto">
        <!-- Tab 1: Tambah Jadwal Secara Manual -->
        <button type="button" onclick="switchTab('manual')" id="btn-tab-manual" class="tab-button-nav flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all bg-blue-50 text-blue-600 border border-blue-200/80 shadow-2xs whitespace-nowrap cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
            <span>Tambah Jadwal Secara Manual</span>
        </button>

        <!-- Tab 2: Tambah Jadwal Baru via Import File -->
        <button type="button" onclick="switchTab('import')" id="btn-tab-import" class="tab-button-nav flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all border border-transparent whitespace-nowrap cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
            <span>Tambah Jadwal Baru via Import File</span>
        </button>

        <!-- Tab 3: Tambah Cepat & Banyak (Per Kelas) -->
        <button type="button" onclick="switchTab('batch')" id="btn-tab-batch" class="tab-button-nav flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all border border-transparent whitespace-nowrap cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
            <span>Tambah Cepat &amp; Banyak (Per Kelas)</span>
        </button>
    </div>

    <!-- TAB 1 CONTENT: Form Manual Input -->
    <div id="panel-tab-manual" class="tab-content-panel bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
        <div class="mb-5">
            <h2 class="text-base font-bold text-slate-900">Tambah Jadwal Pelajaran Secara Manual</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir di bawah ini untuk menambahkan satu jadwal pengajaran spesifik.</p>
        </div>

        <form action="{{ route('jadwal.store') }}" method="POST" id="formTambahJadwal">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <!-- Hari -->
                <div>
                    <label for="hari" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Hari <span class="text-rose-500">*</span>
                    </label>
                    <select id="hari" name="hari" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('hari') border-rose-400 @enderror" onchange="updateJamOptionsByHari()">
                        <option value="" disabled {{ old('hari') ? '' : 'selected' }}>-- Pilih Hari --</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Senin / Jumat</span>
                    @error('hari')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kelas -->
                <div>
                    <label for="id_kelas" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_kelas" name="id_kelas" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_kelas') border-rose-400 @enderror">
                        <option value="" disabled {{ old('id_kelas') ? '' : 'selected' }}>-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: X RPL 1 / XI TKJ 2</span>
                    @error('id_kelas')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Guru Pengampu -->
                <div>
                    <label for="id_guru" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Guru Pengampu <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_guru" name="id_guru" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_guru') border-rose-400 @enderror">
                        <option value="" disabled {{ old('id_guru') ? '' : 'selected' }}>-- Pilih Guru (Terverifikasi) --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama_guru }} — NIP. {{ $g->nip ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Budi Santoso — NIP. 19820315...</span>
                    @error('id_guru')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label for="id_mapel" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_mapel" name="id_mapel" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_mapel') border-rose-400 @enderror">
                        <option value="" disabled {{ old('id_mapel') ? '' : 'selected' }}>-- Pilih Mapel --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Matematika / Pemrograman Web</span>
                    @error('id_mapel')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Ruangan -->
                <div>
                    <label for="id_ruangan" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Ruangan <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_ruangan" name="id_ruangan" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_ruangan') border-rose-400 @enderror" onchange="toggleCustomRuangan(this)">
                        <option value="" disabled {{ old('id_ruangan') ? '' : 'selected' }}>-- Pilih Ruangan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan') == $r->id_ruangan ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                        <option value="custom" {{ (old('id_ruangan') == 'custom' || old('nama_ruangan_custom')) ? 'selected' : '' }} class="font-bold text-blue-600">+ Ketik Ruangan Baru (Custom)...</option>
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Lab. RPL 1 / Ruang Teori 04</span>
                    @error('id_ruangan')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror

                    <!-- Custom Ruangan Box -->
                    <div id="custom_ruangan_wrapper" style="display: {{ (old('id_ruangan') == 'custom' || old('nama_ruangan_custom')) ? 'block' : 'none' }};" class="mt-2.5 p-3 bg-blue-50/50 border border-blue-200 rounded-xl">
                        <label for="nama_ruangan_custom" class="block text-xs font-bold text-blue-700 mb-1">
                            Nama Ruangan Baru (Custom) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_ruangan_custom" name="nama_ruangan_custom" value="{{ old('nama_ruangan_custom') }}" class="w-full text-xs bg-white border border-blue-300 rounded-lg px-3 py-2 text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: Ruang Teori 05 / Lab. AI">
                        <small class="text-[11px] text-slate-500 block mt-1">Ruangan baru ini akan tersimpan permanen di database.</small>
                        @error('nama_ruangan_custom')
                            <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Jam Mulai -->
                <div>
                    <label for="id_jam_mulai" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Jam Mulai (ke-) <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_jam_mulai" name="id_jam_mulai" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_jam_mulai') border-rose-400 @enderror">
                        <option value="" disabled {{ old('id_jam_mulai') ? '' : 'selected' }}>-- Pilih Jam Mulai --</option>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_mulai') == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Jam Ke-1 (07:00 WIB)</span>
                    @error('id_jam_mulai')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jam Selesai -->
                <div>
                    <label for="id_jam_selesai" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Jam Selesai (ke-) <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_jam_selesai" name="id_jam_selesai" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('id_jam_selesai') border-rose-400 @enderror">
                        <option value="" disabled {{ old('id_jam_selesai') ? '' : 'selected' }}>-- Pilih Jam Selesai --</option>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_selesai') == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                    <span class="text-[11px] text-slate-400 italic mt-1 block">Contoh saran: Jam Ke-3 (09:00 WIB)</span>
                    @error('id_jam_selesai')
                        <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons (Bottom Right) -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="resetTambahJadwalForm()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Reset Form</span>
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Simpan Jadwal</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2 CONTENT: Form Import File (Excel / CSV) -->
    <div id="panel-tab-import" class="tab-content-panel hidden bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-5 sm:p-6 space-y-6">
        <!-- Header Section with Emerald Accent & Template Action -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="flex items-start gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-base font-bold text-slate-900">Tambah Jadwal Pelajaran Baru via Import File (Excel)</h2>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 rounded-full border border-emerald-200">Microsoft Excel</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Unggah file Microsoft Excel (.xlsx, .xls, atau .csv) berisi matriks jadwal pengajaran untuk impor otomatis.</p>
                </div>
            </div>
            <a href="{{ route('jadwal.download-template') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition-all shrink-0 self-start md:self-auto cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Download Template Excel (.xlsx)</span>
            </a>
        </div>

        <!-- Instructions Alert Box in Emerald Theme -->
        <div class="bg-emerald-50/80 border border-emerald-200 rounded-xl p-4 flex gap-3 text-xs text-emerald-900 leading-relaxed shadow-2xs">
            <div class="p-1 bg-emerald-100/70 rounded-lg text-emerald-700 shrink-0 h-fit mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="space-y-1">
                <h4 class="font-bold text-emerald-900">Petunjuk Penggunaan Fitur Import Excel Jadwal:</h4>
                <p class="text-[11px] text-emerald-800/90 leading-normal">
                    1. Unduh template resmi Excel dengan menekan tombol <strong>Download Template Excel (.xlsx)</strong> di pojok kanan atas.<br>
                    2. Isi matriks pengajaran sesuai susunan kolom: <strong>Hari, Kelas, Guru Pengampu (NIP), Mata Pelajaran, Ruangan, Jam Mulai (Ke-), Jam Selesai (Ke-)</strong>.<br>
                    3. Pilih file Excel yang telah terisi, tentukan <strong>Filter Kelas Target</strong> (opsional) atau biarkan sistem membaca otomatis seluruh rombel.<br>
                    4. Tentukan <strong>Mode Masukkan Data</strong> (Ganti / Timpa atau Tambahkan), lalu klik <strong>Proses &amp; Baca File Excel</strong>.
                </p>
            </div>
        </div>

        <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
        <div id="excelProcessAlert" class="hidden mb-4 p-4 rounded-xl border text-xs bg-rose-50 border-rose-200 text-rose-800">
            <div class="flex items-start gap-3">
                <i id="excelAlertIcon" class="fa-solid fa-circle-check text-xl shrink-0 mt-0.5 text-emerald-600"></i>
                <div class="flex-1">
                    <h4 id="excelAlertTitle" class="font-bold text-sm"></h4>
                    <p id="excelAlertMsg" class="mt-1 leading-relaxed text-xs"></p>
                    <ul id="excelAlertDetails" class="mt-2 list-disc list-inside space-y-0.5 text-[11.5px] pl-2 hidden"></ul>
                </div>
                <button type="button" onclick="document.getElementById('excelProcessAlert').classList.add('hidden')" class="cursor-pointer text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="importFileLoading" class="hidden text-center p-6 bg-emerald-50 border border-emerald-200 rounded-xl mb-4">
            <i class="fa-solid fa-spinner fa-spin text-2xl text-emerald-600"></i>
            <p id="importFileLoadingMsg" class="mt-2 text-emerald-800 font-bold text-xs">Sedang membaca file...</p>
        </div>

        <!-- Import Options Form Grid with Emerald Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- File Upload Input Card -->
            <div class="bg-slate-50 border border-emerald-200/90 rounded-xl p-4 shadow-2xs hover:border-emerald-300 transition-colors">
                <label class="block text-xs font-semibold text-slate-800 mb-2 flex items-center justify-between">
                    <span>Pilih File Data Jadwal <span class="text-rose-500 font-bold">*</span></span>
                    <span class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider">Excel / CSV</span>
                </label>
                <div class="flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden p-1 shadow-xs focus-within:border-emerald-500 focus-within:ring-1 focus-within:ring-emerald-500">
                    <label for="excel_file_input" class="bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs font-semibold px-3 py-1.5 rounded cursor-pointer transition shrink-0">
                        Pilih File
                        <input type="file" id="excel_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="hidden" onchange="onFileSelected(this)">
                    </label>
                    <span id="selectedFileNameDisplay" class="text-xs text-slate-400 ml-3 truncate flex-1">Tidak ada file yang dipilih</span>
                </div>
                <p id="importFileTypeHint" class="text-[10px] text-slate-400 mt-2">Format didukung: <span class="font-medium text-slate-600">.xlsx, .xls, .csv</span> (Ukuran maks: 10MB)</p>
            </div>

            <!-- Target Class Filter -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 shadow-2xs">
                <label for="excel_target_kelas" class="block text-xs font-semibold text-slate-800 mb-2 flex items-center justify-between">
                    <span>Pilih Kelas Target (Opsional)</span>
                    <span class="text-[10px] text-slate-400 font-normal">{{ count($kelases) }} Rombel</span>
                </label>
                <select id="excel_target_kelas" onchange="syncTargetKelasToBatch(this.value)" class="custom-select w-full rounded-lg border-slate-300 py-2 px-3 text-xs bg-white text-slate-700 font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-2xs outline-none">
                    <option value="">-- Baca Semua Kelas dari File --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-2">Jika dipilih, sistem hanya mengimpor data jadwal untuk kelas tersebut.</p>
            </div>

            <!-- Insertion Mode Selection -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 shadow-2xs">
                <label for="excel_import_mode" class="block text-xs font-semibold text-slate-800 mb-2">
                    Mode Masukkan Data
                </label>
                <select id="excel_import_mode" class="custom-select w-full rounded-lg border-emerald-300 text-xs text-emerald-800 font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 py-2 px-3 bg-emerald-50/50 shadow-2xs outline-none">
                    <option value="replace" selected>Ganti / Timpa Seluruh Baris Tabel</option>
                    <option value="append">Tambahkan ke Baris Tabel yang Ada</option>
                </select>
                <p class="text-[10px] text-slate-400 mt-2">Pilih apakah data file baru menggantikan atau menambah baris jadwal.</p>
            </div>
        </div>

        <!-- Action Footer in Emerald Theme -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100/80 border border-slate-200/90 rounded-lg text-xs text-slate-600 font-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Status Validasi: <strong id="importStatusText" class="text-slate-800 font-semibold">Siap membaca dokumen</strong></span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="clearExcelFileInput()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset File Excel</span>
                </button>
                <button type="button" id="btnProcessExcel" onclick="processImportFile()" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <span>Proses &amp; Baca File Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- TAB 3 CONTENT: Tambah Cepat & Banyak (Per Kelas) -->
    <div id="panel-tab-batch" class="tab-content-panel hidden bg-white rounded-2xl border border-blue-300 shadow-2xs p-5 sm:p-6">
        <div class="mb-5">
            <h2 class="text-base font-bold text-slate-900">Tambah Jadwal Pelajaran Secara Cepat dan Banyak (Per Kelas)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pilih kelas target &amp; hari utama, buat template slot jadwal otomatis, lalu isi guru, mapel, dan ruangan sekaligus.</p>
        </div>

        <form action="{{ route('jadwal.store-batch') }}" method="POST" id="formBatchJadwal">
            @csrf

            <!-- Target Header Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50/80 border border-slate-200 rounded-xl mb-4">
                <div>
                    <label for="batch_id_kelas" class="block text-xs font-bold text-slate-900 mb-1.5">
                        Pilih Kelas Target <span class="text-rose-500">*</span>
                    </label>
                    <select id="batch_id_kelas" name="id_kelas" class="w-full text-xs bg-white border border-blue-300 rounded-xl px-3.5 py-2.5 text-blue-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        <option value="" disabled selected style="color:#94a3b8;">-- Pilih Kelas (misal: X RPL 1) --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="batch_hari_utama" class="block text-xs font-bold text-slate-900 mb-1.5">
                        Pilih Hari Utama <span class="text-rose-500">*</span>
                    </label>
                    <select id="batch_hari_utama" class="w-full text-xs bg-white border border-blue-300 rounded-xl px-3.5 py-2.5 text-blue-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" onchange="applyHariUtamaToAllRows()">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>
            </div>

            <!-- Quick Action Toolbar -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <button type="button" onclick="generateBatchSlots(10)" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><polyline points="12 6 12 12 16 14" stroke-width="2"/></svg>
                    <span>Generasi Slot Jam Ke-1 s/d 10 (Senin-Kamis)</span>
                </button>
                <button type="button" onclick="generateBatchSlots(13)" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><polyline points="12 6 12 12 16 14" stroke-width="2"/></svg>
                    <span>Generasi Slot Jam Ke-1 s/d 13 (Jumat)</span>
                </button>
                <button type="button" onclick="addBatchRow()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-600 hover:bg-slate-700 text-white font-bold text-xs shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19" stroke-width="2"/><line x1="5" y1="12" x2="19" y2="12" stroke-width="2"/></svg>
                    <span>Tambah Baris Manual</span>
                </button>
                <button type="button" onclick="clearBatchRows()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-2xs transition cursor-pointer ml-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <span>Kosongkan Tabel</span>
                </button>
            </div>

            <!-- Table of Batch Schedule Rows -->
            <div class="overflow-x-auto border border-slate-200 rounded-xl mb-4">
                <table class="w-full text-left text-xs min-w-[960px]">
                    <thead class="bg-slate-100 text-slate-600 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="p-3 text-center w-12">NO</th>
                            <th class="p-3 w-28">HARI</th>
                            <th class="p-3 w-36">JAM MULAI (KE-)</th>
                            <th class="p-3 w-36">JAM SELESAI (KE-)</th>
                            <th class="p-3">GURU PENGAMPU <span class="text-rose-500">*</span></th>
                            <th class="p-3">MATA PELAJARAN <span class="text-rose-500">*</span></th>
                            <th class="p-3 min-w-[170px]">RUANGAN <span class="text-rose-500">*</span></th>
                            <th class="p-3 text-center w-24">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="batchTableBody" class="divide-y divide-slate-100">
                        <!-- Dynamic Rows Injected via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Batch Summary & Footer Actions -->
            <div class="flex flex-wrap items-center justify-between gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="text-xs text-slate-600 font-semibold">
                    Total Baris Siap Disimpan: <strong id="batchRowCount" class="text-sm font-extrabold text-slate-900">0</strong> baris
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="resetBatchAll()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2 cursor-pointer" title="Reset Guru, Mapel, dan Ruangan seluruh baris">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        <span>Reset untuk Semua</span>
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        <span>Simpan Jadwal</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- CARD 2: Daftar Jadwal Pelajaran -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6" data-purpose="schedule-table-card">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100 mb-5">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900">Daftar Jadwal Pelajaran</h2>
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                        {{ $jadwals->total() }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Database jadwal operasional kelas semester berjalan</p>
            </div>

            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <a href="{{ route('jadwal.trash') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 rounded-xl text-xs font-bold transition shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Lihat Sampah Jadwal ({{ $trashedCount ?? 0 }})</span>
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('jadwal.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl mb-4 items-end">
            <!-- Filter Hari -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Filter Hari</label>
                <select name="hari" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" onchange="this.form.submit()">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Kelas -->
            <div class="lg:col-span-4">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Filter Kelas</label>
                <select name="id_kelas" class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas ({{ $kelases->count() }} Rombel) --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Cari Guru / Mapel / Ruangan -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Cari Guru / Mapel / Ruangan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian..." class="w-full text-xs bg-white border border-slate-300 rounded-xl px-3 py-2 text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none placeholder:text-slate-400">
            </div>

            <!-- Buttons: Cari & Reset -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Cari</span>
                </button>
                <a href="{{ route('jadwal.index') }}" class="inline-flex items-center justify-center p-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                </a>
            </div>
        </form>

        <!-- Contextual Selection & Bulk Action Toolbar (Active only when 1+ checkboxes are checked) -->
        <div id="bulkActionsToolbar" class="hidden mb-4 p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
            <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                    </svg>
                </span>
                <span>
                    <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> data jadwal dipilih
                </span>
                <span class="text-rose-300 mx-1">|</span>
                <button type="button" onclick="deselectAllJadwal()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
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

        <!-- Data Table Container -->
        <form id="formBulkDelete" action="{{ route('jadwal.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs min-w-[900px]" id="jadwalMainTable">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="p-3.5 text-center w-10">
                                <input type="checkbox" id="selectAllJadwal" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" onclick="toggleSelectAllJadwal(this)" title="Pilih Semua (Select All)">
                            </th>
                            <th class="p-3.5 w-24">HARI</th>
                            <th class="p-3.5 w-36">JAM PELAJARAN</th>
                            <th class="p-3.5 w-28">KELAS</th>
                            <th class="p-3.5">GURU (NIP)</th>
                            <th class="p-3.5">MAPEL</th>
                            <th class="p-3.5 w-28 text-center">RUANGAN</th>
                            <th class="p-3.5 text-center w-52 min-w-[210px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($jadwals as $j)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-3.5 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $j->id_jadwal }}" class="jadwal-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" onchange="updateSelectedCount()">
                                </td>
                                <td class="p-3.5 font-bold text-slate-900">
                                    {{ $j->hari }}
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-900">Jam ke-{{ $j->jam_range }}</div>
                                    <span class="text-blue-600 font-semibold text-[11px] block mt-0.5">{{ $j->waktu_range }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-slate-900">
                                    {{ $j->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-900">{{ $j->guru->nama_guru ?? '-' }}</div>
                                    <span class="text-slate-400 text-[11px] block mt-0.5">NIP: {{ $j->guru->nip ?? '-' }}</span>
                                </td>
                                <td class="p-3.5 font-medium text-slate-800">
                                    {{ $j->mapel->nama_mapel ?? '-' }}
                                </td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-semibold text-xs inline-block text-center min-w-[54px]">
                                        {{ $j->ruangan->nama_ruangan ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-center whitespace-nowrap min-w-[210px]">
                                    <div class="inline-flex items-center gap-1.5 justify-center">
                                        <!-- 1. LIHAT DETAIL -->
                                        <a href="{{ route('jadwal.show', $j->id_jadwal) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/80 text-xs font-bold transition shadow-2xs" title="Lihat Detail Jadwal">
                                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Lihat</span>
                                        </a>

                                        <!-- 2. EDIT -->
                                        <a href="{{ route('jadwal.edit', $j->id_jadwal) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 text-xs font-bold transition shadow-2xs" title="Edit Jadwal">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <!-- 3. HAPUS -->
                                        <button type="button" onclick="confirmDelete('delForm-{{ $j->id_jadwal }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 text-xs font-bold transition shadow-2xs cursor-pointer" title="Hapus Jadwal">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-400">
                                    Belum ada data Jadwal Pelajaran yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Separate individual delete forms outside table form to prevent form nesting -->
        @foreach($jadwals as $j)
            <form action="{{ route('jadwal.destroy', $j->id_jadwal) }}" method="POST" style="display:none;" id="delForm-{{ $j->id_jadwal }}">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <!-- Pagination -->
        <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
            <div>
                Showing <span class="font-bold text-slate-800">{{ $jadwals->firstItem() ?? 0 }}</span> to <span class="font-bold text-slate-800">{{ $jadwals->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-800">{{ $jadwals->total() }}</span> results
            </div>
            <div>
                {{ $jadwals->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Modal Konfirmasi Hapus Tunggal -->
<div id="modalConfirmSingleDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Hapus Data Jadwal?</h3>
        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
            Data jadwal pelajaran ini akan dipindahkan ke Tempat Sampah dan dapat dipulihkan kapan saja melalui menu Sampah.
        </p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeSingleDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                Batal
            </button>
            <button type="button" id="btnConfirmSingleDeleteAction" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Terpilih / Massal -->
<div id="modalConfirmBulkDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Hapus Jadwal Terpilih?</h3>
        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
            Anda akan memindahkan <strong id="modalBulkCount" class="text-rose-600">0</strong> data jadwal terpilih ke Tempat Sampah. Anda yakin?
        </p>
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeBulkDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitBulkDelete()" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition cursor-pointer">
                Ya, Hapus Semua
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Library SheetJS untuk membaca file Excel (.xlsx, .xls, .csv) di Sisi Client -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<!-- Library PDF.js untuk membaca file PDF di Sisi Client -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<!-- Library mammoth.js untuk membaca file Word (.docx) di Sisi Client -->
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    // Setup PDF.js worker
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    /* =========================================================================
       TAB SWITCHING LOGIC
       ========================================================================= */
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.tab-button-nav').forEach(b => {
            b.classList.remove('bg-blue-50', 'text-blue-600', 'border-blue-200/80', 'font-bold', 'shadow-2xs');
            b.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-50', 'font-semibold', 'border-transparent');
        });

        const activePanel = document.getElementById('panel-tab-' + tabId);
        const activeBtn = document.getElementById('btn-tab-' + tabId);
        if (activePanel) activePanel.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.classList.add('bg-blue-50', 'text-blue-600', 'border-blue-200/80', 'font-bold', 'shadow-2xs');
            activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-50', 'border-transparent');
        }
    }

    /* =========================================================================
       UPDATE JAM OPTIONS BY HARI (SENIN-KAMIS vs JUMAT)
       ========================================================================= */
    function updateJamOptionsByHari() {
        const hariElem = document.getElementById('hari');
        if (!hariElem) return;
        const hariVal = hariElem.value;
        const isJumat = hariVal === 'Jumat';

        ['id_jam_mulai', 'id_jam_selesai'].forEach(selectId => {
            const selectElem = document.getElementById(selectId);
            if (!selectElem) return;

            Array.from(selectElem.options).forEach(opt => {
                if (!opt.value) return; // Skip placeholder
                const textJumat = opt.getAttribute('data-jumat');
                const textSeninKamis = opt.getAttribute('data-senin-kamis');
                const hasSeninKamis = opt.getAttribute('data-has-senin-kamis') === '1';

                if (isJumat) {
                    opt.textContent = textJumat || opt.textContent;
                    opt.disabled = false;
                } else {
                    opt.textContent = textSeninKamis || opt.textContent;
                    if (!hasSeninKamis) {
                        opt.disabled = true;
                        opt.textContent = (textSeninKamis || opt.textContent) + ' (Khusus Jumat)';
                        if (opt.selected) {
                            selectElem.value = '';
                        }
                    } else {
                        opt.disabled = false;
                    }
                }
            });
        });
    }

    function toggleCustomRuangan(selectEle) {
        const wrapper = document.getElementById('custom_ruangan_wrapper');
        const customInput = document.getElementById('nama_ruangan_custom');
        if (selectEle && selectEle.value === 'custom') {
            if (wrapper) wrapper.style.display = 'block';
            if (customInput) customInput.focus();
        } else {
            if (wrapper) wrapper.style.display = 'none';
            if (customInput) customInput.value = '';
        }
    }

    function resetTambahJadwalForm() {
        const form = document.getElementById('formTambahJadwal');
        if (form) {
            form.reset();
            const ruanganSelect = document.getElementById('id_ruangan');
            if (ruanganSelect) {
                toggleCustomRuangan(ruanganSelect);
            }
            updateJamOptionsByHari();
        }
    }

    /* =========================================================================
       MODAL CONFIRMATION HANDLERS (SINGLE & BULK DELETE)
       ========================================================================= */
    let activeSingleDeleteFormId = null;

    function confirmDelete(formId) {
        activeSingleDeleteFormId = formId;
        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) {
            modal.classList.add('show');
            const confirmBtn = document.getElementById('btnConfirmSingleDeleteAction');
            if (confirmBtn) {
                confirmBtn.onclick = function() {
                    if (activeSingleDeleteFormId) {
                        document.getElementById(activeSingleDeleteFormId).submit();
                    }
                };
            }
        } else {
            if (confirm('Data jadwal ini akan dipindahkan ke Tempat Sampah. Lanjutkan?')) {
                document.getElementById(formId).submit();
            }
        }
    }

    function closeSingleDeleteModal() {
        activeSingleDeleteFormId = null;
        const modal = document.getElementById('modalConfirmSingleDelete');
        if (modal) modal.classList.remove('show');
    }

    function confirmBulkDelete() {
        const checked = document.querySelectorAll('.jadwal-checkbox:checked');
        if (checked.length === 0) return;

        const countSpan = document.getElementById('modalBulkCount');
        if (countSpan) countSpan.textContent = checked.length;

        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) {
            modal.classList.add('show');
        } else {
            if (confirm(`Hapus ${checked.length} data jadwal terpilih ke Tempat Sampah?`)) {
                submitBulkDelete();
            }
        }
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) modal.classList.remove('show');
    }

    function submitBulkDelete() {
        const form = document.getElementById('formBulkDelete');
        if (form) form.submit();
    }

    /* =========================================================================
       CHECKBOXES & CONTEXTUAL TOOLBAR LOGIC
       ========================================================================= */
    function toggleSelectAllJadwal(master) {
        const checkboxes = document.querySelectorAll('.jadwal-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateSelectedCount();
    }

    function deselectAllJadwal() {
        const master = document.getElementById('selectAllJadwal');
        if (master) master.checked = false;
        const checkboxes = document.querySelectorAll('.jadwal-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.jadwal-checkbox:checked');
        const count = checkedBoxes.length;
        const totalBoxes = document.querySelectorAll('.jadwal-checkbox');
        const toolbar = document.getElementById('bulkActionsToolbar');
        const countSpan = document.getElementById('bulkDeleteCount');
        const master = document.getElementById('selectAllJadwal');

        if (countSpan) countSpan.textContent = count;

        if (toolbar) {
            if (count > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
            } else {
                toolbar.classList.add('hidden');
                toolbar.classList.remove('flex');
            }
        }

        if (master && totalBoxes.length > 0) {
            master.checked = (count === totalBoxes.length);
        }
    }

    /* =========================================================================
       SCRIPT FITUR: TAMBAH JADWAL PELAJARAN SECARA CEPAT DAN BANYAK (PER KELAS)
       ========================================================================= */
    const batchGurus = {!! json_encode($gurus) !!};
    const batchMapels = {!! json_encode($mapels) !!};
    const batchRuangans = {!! json_encode($ruangans) !!};
    const batchJamPelajarans = {!! json_encode($jamPelajarans) !!};
    const batchKelases = {!! json_encode($kelases) !!};

    let batchRowCounter = 0;

    function renderEmptyBatchState() {
        const tbody = document.getElementById('batchTableBody');
        if (!tbody) return;
        if (tbody.children.length === 0) {
            tbody.innerHTML = `
                <tr id="emptyBatchRow">
                    <td colspan="8" class="text-center p-8 text-slate-400 font-medium">
                        <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        Belum ada baris jadwal. Klik <strong>Generasi Slot Jam Ke-1 s/d 10 (atau 13)</strong> di atas atau <strong>+ Tambah Baris Manual</strong> untuk mulai mengisi.
                    </td>
                </tr>
            `;
        }
        updateBatchRowCount();
    }

    function updateBatchRowCount() {
        const tbody = document.getElementById('batchTableBody');
        const counterElem = document.getElementById('batchRowCount');
        if (!tbody) return;
        
        let count = tbody.querySelectorAll('tr.batch-data-row').length;
        if (counterElem) counterElem.textContent = count;
    }

    function generateBatchSlots(maxSlots) {
        clearBatchRows(false);
        const hariUtama = document.getElementById('batch_hari_utama')?.value || 'Senin';
        for (let i = 1; i <= maxSlots; i++) {
            addBatchRow(hariUtama, i, i);
        }
    }

    function addBatchRow(defaultHari = null, defaultJamMulai = 1, defaultJamSelesai = 1, initialData = {}) {
        const tbody = document.getElementById('batchTableBody');
        const emptyRow = document.getElementById('emptyBatchRow');
        if (emptyRow) emptyRow.remove();

        const hariVal = defaultHari || document.getElementById('batch_hari_utama')?.value || 'Senin';
        const rowIndex = batchRowCounter++;

        let formatJamSimple = (jamKe) => {
            if (!jamKe) return 'Jam ke-1';
            let str = String(jamKe).trim();
            str = str.replace(/^Jam\s*Ke-/i, '');
            return 'Jam ke-' + str;
        };

        const guruIdVal = initialData.id_guru || '';
        const mapelIdVal = initialData.id_mapel || '';
        const ruanganIdVal = initialData.id_ruangan || '';
        const customRuanganVal = initialData.nama_ruangan_custom || '';

        // Options HTML
        let hariOptionsHtml = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'].map(h => 
            `<option value="${h}" ${h === hariVal ? 'selected' : ''}>${h}</option>`
        ).join('');

        let jamMulaiOptionsHtml = batchJamPelajarans.map(j => 
            `<option value="${j.id_jam}" ${j.id_jam == defaultJamMulai ? 'selected' : ''}>${formatJamSimple(j.jam_ke)}</option>`
        ).join('');

        let jamSelesaiOptionsHtml = batchJamPelajarans.map(j => 
            `<option value="${j.id_jam}" ${j.id_jam == defaultJamSelesai ? 'selected' : ''}>${formatJamSimple(j.jam_ke)}</option>`
        ).join('');

        let guruOptionsHtml = `<option value="" disabled ${!guruIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Guru --</option>` +
            batchGurus.map(g => `<option value="${g.id_guru}" ${g.id_guru == guruIdVal ? 'selected' : ''}>${g.nama_guru} — NIP. ${g.nip || '-'}</option>`).join('');

        let mapelOptionsHtml = `<option value="" disabled ${!mapelIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Mapel --</option>` +
            batchMapels.map(m => `<option value="${m.id_mapel}" ${m.id_mapel == mapelIdVal ? 'selected' : ''}>${m.nama_mapel}</option>`).join('');

        let ruanganOptionsHtml = `<option value="" disabled ${!ruanganIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Ruangan --</option>` +
            batchRuangans.map(r => `<option value="${r.id_ruangan}" ${r.id_ruangan == ruanganIdVal ? 'selected' : ''}>${r.nama_ruangan}</option>`).join('') +
            `<option value="custom" ${ruanganIdVal === 'custom' ? 'selected' : ''} class="font-bold text-blue-600">+ Custom...</option>`;

        const tr = document.createElement('tr');
        tr.className = 'batch-data-row hover:bg-slate-50 transition-colors';
        tr.id = `batchRow-${rowIndex}`;
        tr.innerHTML = `
            <td class="p-2.5 text-center font-bold text-slate-500 row-number">1</td>
            <td class="p-2">
                <select name="items[${rowIndex}][hari]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-hari focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    ${hariOptionsHtml}
                </select>
            </td>
            <td class="p-2">
                <select name="items[${rowIndex}][id_jam_mulai]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-jam-mulai focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    ${jamMulaiOptionsHtml}
                </select>
            </td>
            <td class="p-2">
                <select name="items[${rowIndex}][id_jam_selesai]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-jam-selesai focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    ${jamSelesaiOptionsHtml}
                </select>
            </td>
            <td class="p-2">
                <select name="items[${rowIndex}][id_guru]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-guru focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    ${guruOptionsHtml}
                </select>
            </td>
            <td class="p-2">
                <select name="items[${rowIndex}][id_mapel]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-mapel focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    ${mapelOptionsHtml}
                </select>
            </td>
            <td class="p-2">
                <select name="items[${rowIndex}][id_ruangan]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 bg-white batch-field-ruangan focus:border-blue-500 focus:ring-1 focus:ring-blue-500" onchange="toggleBatchCustomRuangan(this, ${rowIndex})">
                    ${ruanganOptionsHtml}
                </select>
                <div id="batch_custom_ruangan_wrapper_${rowIndex}" style="display:${ruanganIdVal === 'custom' ? 'block' : 'none'};" class="mt-1.5">
                    <input type="text" name="items[${rowIndex}][nama_ruangan_custom]" value="${customRuanganVal}" class="w-full text-xs rounded-lg border-blue-300 py-1 px-2 bg-blue-50/50 batch-field-ruangan-custom placeholder:text-slate-400" placeholder="Ketik nama ruangan baru...">
                </div>
            </td>
            <td class="p-2 text-center">
                <div class="inline-flex items-center gap-1">
                    <button type="button" class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 transition cursor-pointer" onclick="resetBatchRow(this)" title="Reset isian baris ini">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </button>
                    <button type="button" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition cursor-pointer" onclick="removeBatchRow(this)" title="Hapus baris ini">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
        reindexBatchRowNumbers();
    }

    function toggleBatchCustomRuangan(selectEle, rowIndex) {
        const wrapper = document.getElementById(`batch_custom_ruangan_wrapper_${rowIndex}`);
        if (selectEle && selectEle.value === 'custom') {
            if (wrapper) wrapper.style.display = 'block';
        } else {
            if (wrapper) wrapper.style.display = 'none';
        }
    }

    function resetBatchRow(btn) {
        const tr = btn.closest('tr');
        if (!tr) return;

        const guruSelect = tr.querySelector('.batch-field-guru');
        const mapelSelect = tr.querySelector('.batch-field-mapel');
        const ruanganSelect = tr.querySelector('.batch-field-ruangan');
        const customWrapper = tr.querySelector('[id^="batch_custom_ruangan_wrapper_"]');
        const customInput = tr.querySelector('.batch-field-ruangan-custom');

        if (guruSelect) guruSelect.value = '';
        if (mapelSelect) mapelSelect.value = '';
        if (ruanganSelect) ruanganSelect.value = '';
        if (customInput) customInput.value = '';
        if (customWrapper) customWrapper.style.display = 'none';
    }

    function resetBatchAll() {
        const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');
        if (rows.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tabel Belum Berisi Data!',
                text: 'Belum ada baris tabel pengisian data yang dapat di-reset.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        Swal.fire({
            title: 'Reset Pengisian Semua Baris?',
            text: 'Seluruh data pengisian Guru, Mapel, dan Ruangan pada semua baris tabel akan dikosongkan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Reset Semua!',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
                rows.forEach(row => {
                    const guruSelect = row.querySelector('.batch-field-guru');
                    const mapelSelect = row.querySelector('.batch-field-mapel');
                    const ruanganSelect = row.querySelector('.batch-field-ruangan');
                    const customWrapper = row.querySelector('[id^="batch_custom_ruangan_wrapper_"]');
                    const customInput = row.querySelector('.batch-field-ruangan-custom');

                    if (guruSelect) guruSelect.value = '';
                    if (mapelSelect) mapelSelect.value = '';
                    if (ruanganSelect) ruanganSelect.value = '';
                    if (customInput) customInput.value = '';
                    if (customWrapper) customWrapper.style.display = 'none';
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Di-reset!',
                    text: 'Data pengisian pada seluruh baris tabel telah dikosongkan.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    function removeBatchRow(btn) {
        const tr = btn.closest('tr');
        if (tr) {
            tr.remove();
            reindexBatchRowNumbers();
            renderEmptyBatchState();
        }
    }

    function clearBatchRows(confirmAlert = true) {
        if (confirmAlert) {
            const tbody = document.getElementById('batchTableBody');
            if (tbody && tbody.querySelectorAll('tr.batch-data-row').length > 0) {
                Swal.fire({
                    title: 'Kosongkan Tabel Batch?',
                    text: 'Seluruh baris isian pada tabel akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Kosongkan!',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) {
                        doClearBatchTable();
                    }
                });
                return;
            }
        }
        doClearBatchTable();
    }

    function doClearBatchTable() {
        const tbody = document.getElementById('batchTableBody');
        if (tbody) {
            tbody.innerHTML = '';
            renderEmptyBatchState();
        }
    }

    function reindexBatchRowNumbers() {
        const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');
        rows.forEach((row, idx) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) numCell.textContent = idx + 1;
        });
        updateBatchRowCount();
    }

    function applyHariUtamaToAllRows() {
        const hariVal = document.getElementById('batch_hari_utama')?.value;
        if (!hariVal) return;
        const hariSelects = document.querySelectorAll('#batchTableBody .batch-field-hari');
        hariSelects.forEach(s => s.value = hariVal);
    }

    /* =========================================================================
       IMPORT MULTI-FORMAT (PDF, WORD, EXCEL, CSV)
       ========================================================================= */
    function syncTargetKelasToBatch(val) {
        const batchSelect = document.getElementById('batch_id_kelas');
        if (batchSelect && val) {
            batchSelect.value = val;
        }
    }

    function onFileSelected(input) {
        const hint = document.getElementById('importFileTypeHint');
        const nameDisplay = document.getElementById('selectedFileNameDisplay');
        const statusText = document.getElementById('importStatusText');

        if (!input || !input.files || input.files.length === 0) {
            if (nameDisplay) {
                nameDisplay.textContent = 'Tidak ada file yang dipilih';
                nameDisplay.className = 'text-xs text-slate-400 ml-3 truncate flex-1';
            }
            if (statusText) statusText.textContent = 'Siap membaca dokumen';
            return;
        }

        const file = input.files[0];
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024*1024)).toFixed(2);
        const sizeFormatted = sizeMB < 1 ? sizeKB + ' KB' : sizeMB + ' MB';
        let typeLabel = '';
        let typeColor = '#64748b';

        if (ext === 'pdf') {
            typeLabel = '📄 PDF Document'; typeColor = '#dc2626';
        } else if (ext === 'docx' || ext === 'doc') {
            typeLabel = '📝 Microsoft Word'; typeColor = '#1e40af';
        } else if (ext === 'xlsx' || ext === 'xls') {
            typeLabel = '📊 Microsoft Excel'; typeColor = '#15803d';
        } else if (ext === 'csv') {
            typeLabel = '📋 CSV File'; typeColor = '#0369a1';
        }

        if (nameDisplay) {
            nameDisplay.textContent = file.name;
            nameDisplay.className = 'text-xs text-slate-800 font-semibold ml-3 truncate flex-1';
        }

        if (statusText) {
            statusText.textContent = `File siap diproses (${file.name} — ${sizeFormatted})`;
        }

        if (hint) {
            hint.innerHTML = `<span style="color:${typeColor}; font-weight:700;">${typeLabel}</span> — Ukuran: <strong>${sizeFormatted}</strong>`;
        }
    }

    function clearExcelFileInput() {
        const input = document.getElementById('excel_file_input');
        if (input) input.value = '';

        const nameDisplay = document.getElementById('selectedFileNameDisplay');
        if (nameDisplay) {
            nameDisplay.textContent = 'Tidak ada file yang dipilih';
            nameDisplay.className = 'text-xs text-slate-400 ml-3 truncate flex-1';
        }

        const statusText = document.getElementById('importStatusText');
        if (statusText) statusText.textContent = 'Siap membaca dokumen';

        const excelTargetSelect = document.getElementById('excel_target_kelas');
        if (excelTargetSelect) excelTargetSelect.value = '';

        const excelModeSelect = document.getElementById('excel_import_mode');
        if (excelModeSelect) excelModeSelect.value = 'replace';

        const alertDiv = document.getElementById('excelProcessAlert');
        if (alertDiv) alertDiv.classList.add('hidden');

        const hint = document.getElementById('importFileTypeHint');
        if (hint) hint.innerHTML = 'Format didukung: <span class="font-medium text-slate-600">.xlsx, .xls, .csv</span> (Ukuran maks: 10MB)';
    }

    function showExcelAlert(type, title, message, details = []) {
        const alertDiv = document.getElementById('excelProcessAlert');
        const alertIcon = document.getElementById('excelAlertIcon');
        const alertTitle = document.getElementById('excelAlertTitle');
        const alertMsg = document.getElementById('excelAlertMsg');
        const alertDetails = document.getElementById('excelAlertDetails');

        if (!alertDiv || !alertTitle || !alertMsg) return;

        if (type === 'success') {
            alertDiv.className = 'mb-4 p-4 rounded-xl border text-xs bg-emerald-50 border-emerald-200 text-emerald-800';
            alertIcon.className = 'fa-solid fa-circle-check text-xl shrink-0 mt-0.5 text-emerald-600';
            alertTitle.className = 'font-bold text-sm text-emerald-900';
        } else if (type === 'warning') {
            alertDiv.className = 'mb-4 p-4 rounded-xl border text-xs bg-amber-50 border-amber-200 text-amber-800';
            alertIcon.className = 'fa-solid fa-triangle-exclamation text-xl shrink-0 mt-0.5 text-amber-600';
            alertTitle.className = 'font-bold text-sm text-amber-900';
        } else {
            alertDiv.className = 'mb-4 p-4 rounded-xl border text-xs bg-rose-50 border-rose-200 text-rose-800';
            alertIcon.className = 'fa-solid fa-circle-exclamation text-xl shrink-0 mt-0.5 text-rose-600';
            alertTitle.className = 'font-bold text-sm text-rose-900';
        }

        alertTitle.textContent = title;
        alertMsg.innerHTML = message;

        if (details && details.length > 0) {
            alertDetails.innerHTML = '';
            details.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                alertDetails.appendChild(li);
            });
            alertDetails.classList.remove('hidden');
        } else {
            alertDetails.classList.add('hidden');
        }

        alertDiv.classList.remove('hidden');
    }

    function showImportLoading(msg) {
        const el = document.getElementById('importFileLoading');
        const msgEl = document.getElementById('importFileLoadingMsg');
        if (el) el.classList.remove('hidden');
        if (msgEl && msg) msgEl.textContent = msg;
        const btn = document.getElementById('btnProcessExcel');
        if (btn) { btn.disabled = true; btn.style.opacity = '0.6'; }
    }

    function hideImportLoading() {
        const el = document.getElementById('importFileLoading');
        if (el) el.classList.add('hidden');
        const btn = document.getElementById('btnProcessExcel');
        if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
    }

    function cleanStr(s) {
        return String(s || '').toLowerCase().trim().replace(/[^a-z0-9]/g, '');
    }

    function processImportFile() {
        const fileInput = document.getElementById('excel_file_input');
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            showExcelAlert('warning', 'File Belum Dipilih!', 'Silakan pilih file jadwal pelajaran (PDF, Word, Excel, atau CSV) terlebih dahulu sebelum menekan tombol Proses.');
            return;
        }

        const file = fileInput.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();
        const maxSize = 10 * 1024 * 1024; // 10MB

        if (file.size > maxSize) {
            showExcelAlert('error', 'Ukuran File Terlalu Besar!', `Ukuran file (${(file.size / (1024*1024)).toFixed(2)} MB) melebihi batas maksimum 10MB.`);
            return;
        }

        if (ext === 'pdf') {
            processPdfFile(file, fileName);
        } else if (ext === 'docx') {
            processDocxFile(file, fileName);
        } else if (ext === 'doc') {
            processDocFile(file, fileName);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelCsvFile(file, fileName, ext);
        } else {
            showExcelAlert('error', 'Format File Tidak Didukung!', `Format file <strong>.${ext}</strong> tidak didukung. Silakan gunakan file PDF, Word, Excel, atau CSV.`);
        }
    }

    async function processPdfFile(file, fileName) {
        if (typeof pdfjsLib === 'undefined') {
            showExcelAlert('error', 'Library PDF.js Belum Siap!', 'Sistem sedang memuat pustaka pembaca PDF. Silakan muat ulang halaman jika masalah berlanjut.');
            return;
        }

        showImportLoading('Sedang membaca file PDF, mohon tunggu...');
        document.getElementById('excelProcessAlert')?.classList.add('hidden');

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            let allText = '';
            const totalPages = pdf.numPages;

            for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                showImportLoading(`Sedang membaca file PDF... Halaman ${pageNum}/${totalPages}`);
                const page = await pdf.getPage(pageNum);
                const textContent = await page.getTextContent();

                let pageItems = textContent.items.map(item => ({
                    text: item.str,
                    x: Math.round(item.transform[4]),
                    y: Math.round(item.transform[5]),
                    width: Math.round(item.width),
                    height: Math.round(item.height)
                }));

                pageItems.sort((a, b) => b.y - a.y || a.x - b.x);

                let rows = [];
                let currentRow = [];
                let lastY = null;
                const yTolerance = 8;

                for (const item of pageItems) {
                    if (lastY === null || Math.abs(item.y - lastY) <= yTolerance) {
                        currentRow.push(item);
                    } else {
                        if (currentRow.length > 0) rows.push(currentRow);
                        currentRow = [item];
                    }
                    lastY = item.y;
                }
                if (currentRow.length > 0) rows.push(currentRow);

                for (const row of rows) {
                    const lineText = row.map(i => i.text).join(' ').trim();
                    if (lineText) allText += lineText + '\n';
                }
                allText += '\n--- HALAMAN ' + pageNum + ' ---\n';
            }

            hideImportLoading();
            const schedules = parseTextSchedule(allText, fileName);
            applyParsedSchedules(schedules, fileName, 'PDF');

        } catch (err) {
            hideImportLoading();
            console.error('PDF Error:', err);
            showExcelAlert('error', 'Gagal Membaca File PDF!', `Terjadi kesalahan saat membaca file PDF: <strong>${err.message}</strong>.`);
        }
    }

    async function processDocxFile(file, fileName) {
        if (typeof mammoth === 'undefined') {
            showExcelAlert('error', 'Library mammoth.js Belum Siap!', 'Sistem sedang memuat pustaka pembaca Word. Silakan muat ulang halaman jika masalah berlanjut.');
            return;
        }

        showImportLoading('Sedang membaca file Word (.docx), mohon tunggu...');
        document.getElementById('excelProcessAlert')?.classList.add('hidden');

        try {
            const arrayBuffer = await file.arrayBuffer();
            const result = await mammoth.extractRawText({ arrayBuffer });
            const rawText = result.value || '';

            hideImportLoading();

            if (!rawText.trim()) {
                showExcelAlert('error', 'Dokumen Word Kosong!', 'Dokumen Word yang dipilih tidak memiliki konten teks yang dapat dibaca.');
                return;
            }

            const schedules = parseTextSchedule(rawText, fileName);
            applyParsedSchedules(schedules, fileName, 'Word');

        } catch (err) {
            hideImportLoading();
            console.error('Word Error:', err);
            showExcelAlert('error', 'Gagal Membaca File Word!', `Terjadi kesalahan: <strong>${err.message}</strong>.`);
        }
    }

    function processDocFile(file, fileName) {
        showImportLoading('Sedang membaca file Word (.doc), mohon tunggu...');
        document.getElementById('excelProcessAlert')?.classList.add('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const arrayBuffer = e.target.result;
                const uint8 = new Uint8Array(arrayBuffer);
                let rawText = '';

                for (let i = 0; i < uint8.length; i++) {
                    const code = uint8[i];
                    if (code >= 32 && code <= 126) {
                        rawText += String.fromCharCode(code);
                    } else if (code === 10 || code === 13) {
                        rawText += '\n';
                    }
                }

                rawText = rawText.replace(/[^\x20-\x7E\n\r\u00C0-\u024F]/g, ' ')
                                 .replace(/ {3,}/g, ' ')
                                 .replace(/\n{3,}/g, '\n\n');

                hideImportLoading();

                if (!rawText.trim() || rawText.trim().length < 50) {
                    showExcelAlert('warning', 'File .doc Mungkin Tidak Terbaca Optimal!',
                        'Format .doc (Word 97-2003) memiliki keterbatasan dalam pembacaan teks. Untuk hasil terbaik, simpan ulang file sebagai .docx atau PDF.');
                }

                const schedules = parseTextSchedule(rawText, fileName);
                applyParsedSchedules(schedules, fileName, 'Word (.doc)');

            } catch (err) {
                hideImportLoading();
                console.error('DOC Error:', err);
                showExcelAlert('error', 'Gagal Membaca File .doc!', `Terjadi kesalahan saat membaca file .doc.`);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function processExcelCsvFile(file, fileName, ext) {
        if (typeof XLSX === 'undefined') {
            showExcelAlert('error', 'Library XLSX Belum Siap!', 'Sistem sedang memuat pustaka pembaca Excel. Silakan muat ulang halaman jika masalah berlanjut.');
            return;
        }

        showImportLoading(`Sedang membaca file ${ext.toUpperCase()}, mohon tunggu...`);
        document.getElementById('excelProcessAlert')?.classList.add('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                const rawRowsF = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false, defval: '' });
                const rawRowsR = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: true, cellDates: true, defval: '' });

                if (!rawRowsF || rawRowsF.length === 0) {
                    hideImportLoading();
                    showExcelAlert('error', 'File Kosong!', 'File yang Anda pilih tidak memiliki baris data.');
                    return;
                }

                let headerRowIndex = -1;
                let colIndices = { hari: -1, jam_mulai: -1, jam_selesai: -1, guru: -1, mapel: -1, ruangan: -1, kelas: -1 };

                for (let i = 0; i < Math.min(rawRowsF.length, 20); i++) {
                    const row = rawRowsF[i];
                    if (!row || !Array.isArray(row)) continue;

                    let tempMap = { hari: -1, jam_mulai: -1, jam_selesai: -1, guru: -1, mapel: -1, ruangan: -1, kelas: -1 };

                    row.forEach((cell, colIdx) => {
                        const txt = cleanStr(cell);
                        if (!txt) return;

                        if (txt === 'hari' || txt.includes('day') || txt.includes('hari')) {
                            tempMap.hari = colIdx;
                        } else if (txt.includes('jammulaike') || txt.includes('jammulai') || txt.includes('jamawal') || txt.includes('startjam') || (txt.includes('jam') && txt.includes('mulai'))) {
                            tempMap.jam_mulai = colIdx;
                        } else if (txt.includes('jamselesaike') || txt.includes('jamselesai') || txt.includes('jamakhir') || txt.includes('endjam') || (txt.includes('jam') && txt.includes('selesai'))) {
                            tempMap.jam_selesai = colIdx;
                        } else if (txt.includes('guru') || txt.includes('gurupengampu') || txt.includes('namaguru') || txt === 'nip' || txt.includes('pengampu')) {
                            tempMap.guru = colIdx;
                        } else if (txt.includes('mapel') || txt.includes('matapelajaran') || txt.includes('namamapel') || txt.includes('subject') || txt.includes('pelajaran')) {
                            tempMap.mapel = colIdx;
                        } else if (txt.includes('ruang') || txt.includes('ruangan') || txt.includes('room') || txt.includes('namaruangan')) {
                            tempMap.ruangan = colIdx;
                        } else if (txt.includes('kelas') || txt.includes('namakelas') || txt.includes('targetkelas') || txt === 'class') {
                            tempMap.kelas = colIdx;
                        }
                    });

                    let matchedKeys = 0;
                    if (tempMap.hari !== -1) matchedKeys++;
                    if (tempMap.guru !== -1) matchedKeys++;
                    if (tempMap.mapel !== -1) matchedKeys++;

                    if (matchedKeys >= 1) {
                        headerRowIndex = i;
                        colIndices = tempMap;
                        break;
                    }
                }

                if (headerRowIndex === -1) {
                    const sampleRow = rawRowsF[0] || [];
                    const firstCellClean = cleanStr(sampleRow[0]);
                    if (firstCellClean === 'no' || firstCellClean === '1' || firstCellClean === 'no1') {
                        colIndices = { hari: 1, jam_mulai: 2, jam_selesai: 3, guru: 4, mapel: 5, ruangan: 6, kelas: 7 };
                        headerRowIndex = 0;
                    } else {
                        colIndices = { hari: 0, jam_mulai: 1, jam_selesai: 2, guru: 3, mapel: 4, ruangan: 5, kelas: 6 };
                        headerRowIndex = -1;
                    }
                }

                const parsedSchedules = [];
                const warnings = [];

                for (let i = headerRowIndex + 1; i < rawRowsF.length; i++) {
                    const rowF = rawRowsF[i];
                    const rowR = rawRowsR[i];
                    if (!rowF || rowF.length === 0) continue;

                    const isEmptyRow = rowF.every(cell => String(cell || '').trim() === '');
                    if (isEmptyRow) continue;

                    let hariRaw       = colIndices.hari !== -1 ? String(rowF[colIndices.hari] || rowR?.[colIndices.hari] || '').trim() : '';
                    let jamMulaiRaw   = colIndices.jam_mulai !== -1 ? String(rowF[colIndices.jam_mulai] || rowR?.[colIndices.jam_mulai] || '').trim() : '';
                    let jamSelesaiRaw = colIndices.jam_selesai !== -1 ? String(rowF[colIndices.jam_selesai] || rowR?.[colIndices.jam_selesai] || '').trim() : '';
                    let guruRaw       = colIndices.guru !== -1 ? String(rowF[colIndices.guru] || rowR?.[colIndices.guru] || '').trim() : '';
                    let mapelRaw      = colIndices.mapel !== -1 ? String(rowF[colIndices.mapel] || rowR?.[colIndices.mapel] || '').trim() : '';
                    let ruanganRaw    = colIndices.ruangan !== -1 ? String(rowF[colIndices.ruangan] || rowR?.[colIndices.ruangan] || '').trim() : '';
                    let kelasRaw      = colIndices.kelas !== -1 ? String(rowF[colIndices.kelas] || rowR?.[colIndices.kelas] || '').trim() : '';

                    if (!hariRaw && !guruRaw && !mapelRaw) continue;

                    const parsed = buildScheduleItem(hariRaw, jamMulaiRaw, jamSelesaiRaw, guruRaw, mapelRaw, ruanganRaw, kelasRaw, i+1, warnings);
                    if (parsed) parsedSchedules.push(parsed);
                }

                hideImportLoading();

                if (parsedSchedules.length === 0) {
                    showExcelAlert('error', 'Tidak Ada Data Jadwal Valid!',
                        `File ${ext.toUpperCase()} tidak mengandung data jadwal yang dapat dibaca. Pastikan kolom memiliki header: HARI, JAM MULAI, JAM SELESAI, GURU, MAPEL, RUANGAN.`);
                    return;
                }

                applyParsedSchedules(parsedSchedules, fileName, ext.toUpperCase());

            } catch(err) {
                hideImportLoading();
                console.error('Excel/CSV Error:', err);
                showExcelAlert('error', `Gagal Membaca File ${ext.toUpperCase()}!`, 'Terjadi kesalahan saat membaca file: ' + err.message);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function parseTextSchedule(rawText, fileName) {
        const schedules = [];
        const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 0);

        const hariPattern = /\b(senin|selasa|rabu|kamis|jumat|monday|tuesday|wednesday|thursday|friday)\b/i;
        const kelasPattern = /\b(x|xi|xii|10|11|12)\s*(tki|tkj|rpl|tkr|tsm|tav|tbsm|mm|ak|adm|dpib|bdp|otkp|aphp|agribisnis|kimia|teknik)\s*(\d+)\b/i;
        const jamPattern = /jam\s*(ke)?[-\s]?(\d+)\s*(s\/d|sd|[-–]|sampai|hingga)?\s*(\d+)?/i;

        const blocks = rawText.split(/\n{2,}|---\s*HALAMAN/);
        let hariContext = '';
        let kelasContext = '';

        for (const block of blocks) {
            const blockLines = block.split('\n').map(l => l.trim()).filter(l => l.length > 1);
            if (blockLines.length === 0) continue;

            for (const bl of blockLines) {
                const hm = bl.match(hariPattern);
                if (hm && bl.length < 25) {
                    const h = hm[1].toLowerCase();
                    if (h.includes('senin')) hariContext = 'Senin';
                    else if (h.includes('selasa')) hariContext = 'Selasa';
                    else if (h.includes('rabu')) hariContext = 'Rabu';
                    else if (h.includes('kamis')) hariContext = 'Kamis';
                    else if (h.includes('jumat')) hariContext = 'Jumat';
                }
                const km = bl.match(kelasPattern);
                if (km) {
                    kelasContext = km[0].replace(/\s+/g, ' ').toUpperCase();
                }
            }

            let jamMulaiCtx = 0, jamSelesaiCtx = 0;
            for (const bl of blockLines) {
                const jm = bl.match(jamPattern);
                if (jm) {
                    jamMulaiCtx = parseInt(jm[2] || '1');
                    jamSelesaiCtx = jm[4] ? parseInt(jm[4]) : jamMulaiCtx;
                    break;
                }
                const rangeMatch = bl.match(/(\d{1,2})\s*[-–s\/d]+\s*(\d{1,2})/);
                if (rangeMatch && parseInt(rangeMatch[1]) >= 1 && parseInt(rangeMatch[1]) <= 13) {
                    jamMulaiCtx = parseInt(rangeMatch[1]);
                    jamSelesaiCtx = parseInt(rangeMatch[2]);
                    break;
                }
            }

            let foundGuru = null, foundMapel = null, foundRuangan = null;

            for (const bl of blockLines) {
                if (bl.match(/^(\d{1,2})\s*[-–]\s*(\d{1,2})$/) && bl.length < 10) continue;
                if (bl.match(hariPattern) && bl.length < 20) continue;

                if (!foundGuru) {
                    const gMatch = batchGurus.find(g => {
                        const nameParts = g.nama_guru.split(/[\s,]+/).filter(p => p.length > 3);
                        return nameParts.some(part => bl.toLowerCase().includes(part.toLowerCase()));
                    });
                    if (gMatch) { foundGuru = gMatch; continue; }
                }

                if (!foundMapel) {
                    const mMatch = batchMapels.find(m => {
                        const nameClean = cleanStr(m.nama_mapel);
                        const blClean = cleanStr(bl);
                        return blClean.includes(nameClean) || nameClean.includes(blClean) ||
                               (blClean.length > 4 && nameClean.length > 4 && (
                                   bl.toLowerCase().includes(m.nama_mapel.toLowerCase().slice(0,6)) ||
                                   m.nama_mapel.toLowerCase().includes(bl.toLowerCase().slice(0,6))
                               ));
                    });
                    if (mMatch) { foundMapel = mMatch; continue; }
                }

                if (!foundRuangan) {
                    const rMatch = batchRuangans.find(r => {
                        const nameClean = cleanStr(r.nama_ruangan);
                        const blClean = cleanStr(bl);
                        return blClean.includes(nameClean) || nameClean.includes(blClean) ||
                               bl.toLowerCase().includes(r.nama_ruangan.toLowerCase().slice(0,5));
                    });
                    if (rMatch) { foundRuangan = rMatch; }
                }
            }

            if (foundGuru && foundMapel && hariContext && jamMulaiCtx > 0) {
                const selectedTargetKelasEl = document.getElementById('excel_target_kelas');
                const selectedTargetKelasId = selectedTargetKelasEl ? selectedTargetKelasEl.value : '';

                let matchedKelasId = '';
                if (kelasContext && batchKelases) {
                    const kMatch = batchKelases.find(k => {
                        return cleanStr(k.nama_kelas).includes(cleanStr(kelasContext)) ||
                               cleanStr(kelasContext).includes(cleanStr(k.nama_kelas));
                    });
                    if (kMatch) matchedKelasId = kMatch.id_kelas;
                }

                if (!selectedTargetKelasId || !matchedKelasId || String(selectedTargetKelasId) === String(matchedKelasId)) {
                    let ruanganId = foundRuangan ? foundRuangan.id_ruangan : 'custom';
                    let ruanganCustom = !foundRuangan ? (blockLines.find(bl =>
                        bl.length > 2 && !bl.match(hariPattern) && !bl.match(/^\d/) &&
                        !batchGurus.find(g => bl.toLowerCase().includes(g.nama_guru.toLowerCase().slice(0,5))) &&
                        !batchMapels.find(m => bl.toLowerCase().includes(m.nama_mapel.toLowerCase().slice(0,5)))
                    ) || '') : '';

                    schedules.push({
                        hari: hariContext || 'Senin',
                        id_jam_mulai: Math.max(1, Math.min(13, jamMulaiCtx)),
                        id_jam_selesai: Math.max(1, Math.min(13, Math.max(jamMulaiCtx, jamSelesaiCtx))),
                        id_guru: foundGuru.id_guru,
                        id_mapel: foundMapel.id_mapel,
                        id_ruangan: ruanganId,
                        nama_ruangan_custom: ruanganCustom,
                        kelas_name: kelasContext,
                        matched_kelas_id: matchedKelasId
                    });
                }
            }
        }

        return schedules;
    }

    function buildScheduleItem(hariRaw, jamMulaiRaw, jamSelesaiRaw, guruRaw, mapelRaw, ruanganRaw, kelasRaw, rowNum, warnings) {
        let hariClean = cleanStr(hariRaw);
        let hariVal = 'Senin';
        if (hariClean.includes('senin') || hariClean.includes('mon')) hariVal = 'Senin';
        else if (hariClean.includes('selasa') || hariClean.includes('tue')) hariVal = 'Selasa';
        else if (hariClean.includes('rabu') || hariClean.includes('wed')) hariVal = 'Rabu';
        else if (hariClean.includes('kamis') || hariClean.includes('thu')) hariVal = 'Kamis';
        else if (hariClean.includes('jumat') || hariClean.includes('fri')) hariVal = 'Jumat';

        let parseJamNum = (rawStr, defaultVal = 1) => {
            if (!rawStr) return defaultVal;
            let numMatch = String(rawStr).match(/\d+/);
            return numMatch ? parseInt(numMatch[0]) : defaultVal;
        };

        let jamMulaiVal = parseJamNum(jamMulaiRaw, 1);
        let jamSelesaiVal = parseJamNum(jamSelesaiRaw, jamMulaiVal);

        if (jamMulaiRaw.includes('-') || jamMulaiRaw.includes('s/d') || jamMulaiRaw.includes('sd')) {
            let matches = jamMulaiRaw.match(/\d+/g);
            if (matches && matches.length >= 2) {
                jamMulaiVal = parseInt(matches[0]);
                jamSelesaiVal = parseInt(matches[1]);
            }
        }

        jamMulaiVal = Math.max(1, Math.min(13, jamMulaiVal));
        jamSelesaiVal = Math.max(jamMulaiVal, Math.min(13, jamSelesaiVal));

        let matchedGuruId = '';
        if (guruRaw) {
            let guruRawClean = cleanStr(guruRaw);
            let guruNipNum = guruRaw.replace(/[^0-9]/g, '');
            let gMatch = batchGurus.find(g => {
                if (guruNipNum && g.nip && g.nip.replace(/[^0-9]/g, '') === guruNipNum) return true;
                let gNameClean = cleanStr(g.nama_guru);
                return gNameClean.includes(guruRawClean) || guruRawClean.includes(gNameClean);
            });
            if (gMatch) matchedGuruId = gMatch.id_guru;
            else warnings.push(`Baris ke-${rowNum}: Guru "${guruRaw}" tidak ditemukan di database.`);
        }

        let matchedMapelId = '';
        if (mapelRaw) {
            let mapelRawClean = cleanStr(mapelRaw);
            let mMatch = batchMapels.find(m => {
                let mNameClean = cleanStr(m.nama_mapel);
                return mNameClean.includes(mapelRawClean) || mapelRawClean.includes(mNameClean);
            });
            if (mMatch) matchedMapelId = mMatch.id_mapel;
            else warnings.push(`Baris ke-${rowNum}: Mata Pelajaran "${mapelRaw}" tidak ditemukan di database.`);
        }

        let matchedRuanganId = '';
        let customRuanganName = '';
        if (ruanganRaw) {
            let ruanganRawClean = cleanStr(ruanganRaw);
            let rMatch = batchRuangans.find(r => {
                let rNameClean = cleanStr(r.nama_ruangan);
                return rNameClean.includes(ruanganRawClean) || ruanganRawClean.includes(rNameClean);
            });
            if (rMatch) {
                matchedRuanganId = rMatch.id_ruangan;
            } else {
                matchedRuanganId = 'custom';
                customRuanganName = ruanganRaw;
            }
        }

        return {
            hari: hariVal,
            id_jam_mulai: jamMulaiVal,
            id_jam_selesai: jamSelesaiVal,
            id_guru: matchedGuruId,
            id_mapel: matchedMapelId,
            id_ruangan: matchedRuanganId,
            nama_ruangan_custom: customRuanganName,
            kelas_name: kelasRaw
        };
    }

    function applyParsedSchedules(parsedSchedules, fileName, fileTypeLabel) {
        const warnings = [];

        if (!parsedSchedules || parsedSchedules.length === 0) {
            showExcelAlert('error', 'Tidak Ada Data Jadwal Ditemukan!',
                `Sistem tidak dapat menemukan data jadwal dari file <strong>${fileTypeLabel}</strong>. ` +
                `Pastikan file memiliki kolom: HARI, JAM MULAI, JAM SELESAI, GURU, MAPEL, RUANGAN.`);
            return;
        }

        const mode = document.getElementById('excel_import_mode').value;
        const tbody = document.getElementById('batchTableBody');

        let existingRows = tbody.querySelectorAll('tr.batch-data-row');
        let isAllExistingEmpty = true;
        existingRows.forEach(tr => {
            const guruVal = tr.querySelector('.batch-field-guru')?.value;
            const mapelVal = tr.querySelector('.batch-field-mapel')?.value;
            const ruanganVal = tr.querySelector('.batch-field-ruangan')?.value;
            if (guruVal || mapelVal || ruanganVal) isAllExistingEmpty = false;
        });

        if (mode === 'replace' || mode === 'overwrite' || isAllExistingEmpty) {
            tbody.innerHTML = '';
            batchRowCounter = 0;
        }

        const selectedTargetKelasEl = document.getElementById('excel_target_kelas');
        const selectedTargetKelasId = selectedTargetKelasEl ? selectedTargetKelasEl.value : '';

        let filteredSchedules = parsedSchedules;
        if (selectedTargetKelasId) {
            filteredSchedules = parsedSchedules.filter(item => {
                if (item.matched_kelas_id) return String(item.matched_kelas_id) === String(selectedTargetKelasId);
                if (item.kelas_name && batchKelases) {
                    const selectedKelas = batchKelases.find(k => String(k.id_kelas) === String(selectedTargetKelasId));
                    if (selectedKelas) {
                        return cleanStr(item.kelas_name).includes(cleanStr(selectedKelas.nama_kelas)) ||
                               cleanStr(selectedKelas.nama_kelas).includes(cleanStr(item.kelas_name));
                    }
                }
                return true;
            });

            if (filteredSchedules.length === 0) {
                warnings.push(`Tidak ada data jadwal untuk kelas yang dipilih. Seluruh ${parsedSchedules.length} baris dimasukkan.`);
                filteredSchedules = parsedSchedules;
            }
        }

        filteredSchedules.forEach(item => {
            addBatchRow(item.hari, item.id_jam_mulai, item.id_jam_selesai, item);
        });

        let targetKelasInfo = '';
        if (selectedTargetKelasId) {
            const batchKelasSelect = document.getElementById('batch_id_kelas');
            if (batchKelasSelect) {
                batchKelasSelect.value = selectedTargetKelasId;
                targetKelasInfo = batchKelasSelect.options[batchKelasSelect.selectedIndex]?.text || '';
            }
        }

        let guruMatched = filteredSchedules.filter(s => s.id_guru).length;
        let mapelMatched = filteredSchedules.filter(s => s.id_mapel).length;

        const msg = `Berhasil membaca <strong>${filteredSchedules.length} data jadwal pelajaran</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya ke tabel batch di bawah.<br>`
                  + `<small class="block mt-1 text-[11px] text-slate-500">`
                  + `Guru cocok: ${guruMatched}/${filteredSchedules.length} | Mapel cocok: ${mapelMatched}/${filteredSchedules.length}`
                  + `</small>`;

        showExcelAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg, warnings);

        // Auto-switch to batch tab so user can review & save
        switchTab('batch');
        const formBatch = document.getElementById('formBatchJadwal');
        if (formBatch) formBatch.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    /* =========================================================================
       DOM INITIALIZATION
       ========================================================================= */
    document.addEventListener('DOMContentLoaded', function() {
        updateJamOptionsByHari();
        renderEmptyBatchState();
        updateSelectedCount();

        @if(isset($errors) && ($errors->has('items') || $errors->has('items.*')))
            switchTab('batch');
        @endif

        if (window.location.hash === '#tab-import') switchTab('import');
        else if (window.location.hash === '#tab-batch') switchTab('batch');

        // Form manual validation
        const formManual = document.getElementById('formTambahJadwal');
        if (formManual) {
            formManual.addEventListener('submit', function(e) {
                const hari         = document.getElementById('hari')?.value;
                const idKelas      = document.getElementById('id_kelas')?.value;
                const idGuru       = document.getElementById('id_guru')?.value;
                const idMapel      = document.getElementById('id_mapel')?.value;
                const idRuangan    = document.getElementById('id_ruangan')?.value;
                const idJamMulai   = document.getElementById('id_jam_mulai')?.value;
                const idJamSelesai = document.getElementById('id_jam_selesai')?.value;

                let missing = [];
                if (!hari) missing.push('Hari');
                if (!idKelas) missing.push('Kelas');
                if (!idGuru) missing.push('Guru Pengampu');
                if (!idMapel) missing.push('Mata Pelajaran');
                if (!idRuangan) missing.push('Ruangan');
                if (!idJamMulai) missing.push('Jam Mulai');
                if (!idJamSelesai) missing.push('Jam Selesai');

                if (missing.length > 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulir Belum Lengkap!',
                        html: 'Silakan lengkapi data yang belum diisi berikut:<br><br><strong class="text-rose-600">' + missing.join(', ') + '</strong>',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }

                if (parseInt(idJamSelesai) < parseInt(idJamMulai)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Pelajaran Tidak Sesuai!',
                        text: 'Jam Selesai tidak boleh lebih kecil dari Jam Mulai.',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }

                if (hari !== 'Jumat' && (parseInt(idJamMulai) > 10 || parseInt(idJamSelesai) > 10)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Batas Jam Pelajaran Terlampaui!',
                        text: 'Untuk hari ' + hari + ', jam pelajaran maksimal adalah Jam Ke-10. Jam Ke-11 s/d 13 hanya berlaku pada hari Jumat.',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }
            });
        }

        // Form batch validation
        const formBatch = document.getElementById('formBatchJadwal');
        if (formBatch) {
            formBatch.addEventListener('submit', function(e) {
                const idKelas = document.getElementById('batch_id_kelas')?.value;
                const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');

                if (!idKelas) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Kelas Target Belum Dipilih!',
                        text: 'Silakan pilih Kelas Target terlebih dahulu sebelum menyimpan.',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }

                if (rows.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Tabel Masih Kosong!',
                        text: 'Silakan klik "Generasi Slot Jam" atau "+ Tambah Baris Manual" untuk menambah data jadwal.',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }

                let missingErrors = [];
                let logicErrors = [];

                rows.forEach((row, idx) => {
                    const rowNum = idx + 1;
                    const hari = row.querySelector('.batch-field-hari')?.value;
                    const jamMulai = parseInt(row.querySelector('.batch-field-jam-mulai')?.value || '0');
                    const jamSelesai = parseInt(row.querySelector('.batch-field-jam-selesai')?.value || '0');
                    const guru = row.querySelector('.batch-field-guru')?.value;
                    const mapel = row.querySelector('.batch-field-mapel')?.value;
                    const ruangan = row.querySelector('.batch-field-ruangan')?.value;
                    const customRuangan = row.querySelector('.batch-field-ruangan-custom')?.value.trim();

                    if (!guru || !mapel || !ruangan) {
                        missingErrors.push(`Baris ke-${rowNum}: Guru, Mapel, atau Ruangan belum dipilih.`);
                    }

                    if (ruangan === 'custom' && !customRuangan) {
                        missingErrors.push(`Baris ke-${rowNum}: Nama Ruangan Custom wajib diisi.`);
                    }

                    if (jamSelesai < jamMulai) {
                        logicErrors.push(`Baris ke-${rowNum}: Jam Selesai (Ke-${jamSelesai}) lebih kecil dari Jam Mulai (Ke-${jamMulai}).`);
                    }

                    if (['Senin', 'Selasa', 'Rabu', 'Kamis'].includes(hari) && (jamMulai > 10 || jamSelesai > 10)) {
                        logicErrors.push(`Baris ke-${rowNum}: Jam ke-${jamSelesai} melebihi batas Jam Ke-10 untuk hari ${hari}.`);
                    }
                });

                if (missingErrors.length > 0 || logicErrors.length > 0) {
                    e.preventDefault();
                    const allErrList = [...missingErrors, ...logicErrors];
                    Swal.fire({
                        icon: 'error',
                        title: 'Terdapat Isian Belum Lengkap!',
                        html: '<div class="text-left max-h-48 overflow-y-auto text-xs text-rose-600"><ul class="list-disc list-inside space-y-0.5">' + 
                              allErrList.map(err => `<li>${err}</li>`).join('') + 
                              '</ul></div>',
                        confirmButtonColor: '#2563eb'
                    });
                    return false;
                }
            });
        }
    });
</script>
@endsection
