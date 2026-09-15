@extends('layouts.guru')

@section('title', 'Presensi Siswa — EDU JOURNAL')
@section('header_title', 'Presensi Siswa')

@section('styles')
<style>
    .presensi-grid {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .presensi-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Top Selector Toolbar */
    .selector-bar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .selector-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .select-custom {
        padding: 9px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        cursor: pointer;
        transition: border 0.15s ease, background 0.15s ease;
    }

    .select-custom:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    /* Action bar above student list */
    .action-toolbar {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .search-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .search-input-wrapper i.search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13.5px;
    }

    .input-search-siswa {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: all 0.15s ease;
    }

    .input-search-siswa:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-reset-search {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-reset-search:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-set-hadir {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        padding: 9px 16px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-set-hadir:hover {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Filter pills */
    .filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .pill-item {
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        user-select: none;
    }

    .pill-item:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .pill-item.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
    }

    .pill-badge {
        background: rgba(0,0,0,0.08);
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 11px;
    }

    .pill-item.active .pill-badge {
        background: rgba(255,255,255,0.25);
    }

    /* Main Presensi Box */
    .main-presensi-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .btn-simpan-top {
        background: #2563eb;
        color: #ffffff;
        padding: 9px 22px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13.5px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
        transition: background 0.15s ease, transform 0.1s ease;
    }

    .btn-simpan-top:hover {
        background: #1d4ed8;
    }

    .btn-simpan-top:active {
        transform: scale(0.98);
    }

    .student-card-item {
        background: #fdfbf7;
        border: 1px solid #f3ebe0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.15s ease;
    }

    .student-card-item:hover {
        border-color: #e2d9cc;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .avatar-initial {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #d6ccc2;
        color: #1e293b;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .student-nisn {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Badges for Surat Izin & Dispen */
    .badge-cross-system {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        margin-top: 4px;
    }

    .badge-izin-system {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .badge-dispen-system {
        background: #f3e8ff;
        color: #6b21a8;
        border: 1px solid #e9d5ff;
    }

    .badge-telat-system {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .badge-status-tag {
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tag-hadir {
        background: #dcfce7;
        color: #15803d;
    }

    .tag-sakit {
        background: #fef3c7;
        color: #92400e;
    }

    .tag-izin {
        background: #e0f2fe;
        color: #0369a1;
    }

    .tag-alpa {
        background: #fee2e2;
        color: #991b1b;
    }

    .tag-dispen {
        background: #f1f5f9;
        color: #334155;
    }

    /* SIAD Radio Buttons */
    .siad-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }

    .siad-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .siad-btn:hover {
        border-color: #94a3b8;
        background: #f8fafc;
    }

    .siad-input { display: none; }

    /* Active colors matching mockup */
    .siad-input-s:checked + .siad-btn-s { background: #a37c00; color: #ffffff; border-color: #a37c00; box-shadow: 0 2px 6px rgba(163, 124, 0, 0.35); }
    .siad-input-i:checked + .siad-btn-i { background: #3b9ab2; color: #ffffff; border-color: #3b9ab2; box-shadow: 0 2px 6px rgba(59, 154, 178, 0.35); }
    .siad-input-a:checked + .siad-btn-a { background: #780000; color: #ffffff; border-color: #780000; box-shadow: 0 2px 6px rgba(120, 0, 0, 0.35); }
    .siad-input-d:checked + .siad-btn-d { background: #4a5568; color: #ffffff; border-color: #4a5568; box-shadow: 0 2px 6px rgba(74, 85, 104, 0.35); }

    /* Widgets */
    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .summary-row:last-child { border-bottom: none; }

    .summary-label {
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-val {
        font-weight: 800;
        color: #0f172a;
        font-size: 15px;
    }

    .dot-bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endsection

@section('content')

    <!-- Flash Notification -->
    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 700;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #15803d;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Top Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-user-check" style="color: #2563eb;"></i>
                Presensi Siswa
            </h1>
            <p style="font-size: 13.5px; color: #64748b; margin-top: 4px;">
                {{ $subJudul }}
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <button type="button" onclick="document.getElementById('formPresensi').submit()" class="btn-simpan-top">
                <i class="fa-solid fa-check"></i> Simpan
            </button>
        </div>
    </div>

    <!-- Filter & Schedule Selector Bar -->
    <div class="selector-bar">
        <form id="filterForm" method="GET" action="{{ route('guru.absensi-siswa') }}" style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 16px;">
            <div class="selector-group">
                <label for="selectJadwal" style="font-size: 13px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i> Jadwal / Kelas:
                </label>
                <select name="id_jadwal" id="selectJadwal" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                    @if($jadwals->isNotEmpty())
                        <optgroup label="Jadwal Mengajar">
                            @foreach($jadwals as $j)
                                @php
                                    $mulai = $j->jamMulai ? substr($j->jamMulai->jam_mulai, 0, 5) : '';
                                    $selesai = $j->jamSelesai ? substr($j->jamSelesai->jam_selesai, 0, 5) : '';
                                    $jamLabel = ($mulai && $selesai) ? "({$mulai} - {$selesai})" : '';
                                    $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal && !$isModeWali);
                                @endphp
                                <option value="{{ $j->id_jadwal }}" {{ $isSelected ? 'selected' : '' }}>
                                    [{{ $j->hari }}] {{ $j->mapel->nama_mapel ?? 'Mapel' }} – {{ $j->kelas->nama_kelas ?? 'Kelas' }} {{ $jamLabel }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($isWaliKelas && $kelasWali)
                        <optgroup label="Kelas Perwalian (Wali Kelas)">
                            <option value="wali" {{ $isModeWali ? 'selected' : '' }}>
                                [Wali Kelas] Presensi Harian Kelas {{ $kelasWali->nama_kelas }}
                            </option>
                        </optgroup>
                    @endif
                </select>
            </div>

            <div class="selector-group">
                <label for="inputTanggal" style="font-size: 13px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-clock" style="color: #2563eb;"></i> Tanggal:
                </label>
                <input type="date" name="tanggal" id="inputTanggal" value="{{ $targetDate }}" class="select-custom" onchange="document.getElementById('filterForm').submit()">
                
                @if($existingJurnal)
                    <span style="font-size: 11.5px; font-weight: 800; background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 8px; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-circle-check"></i> Sudah Terisi
                    </span>
                @else
                    <span style="font-size: 11.5px; font-weight: 800; background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 8px; border: 1px solid #fde68a; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-clock-rotate-left"></i> Belum Diisi
                    </span>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Presensi Grid -->
    <div class="presensi-grid">
        
        <!-- Left: List of Students for Attendance -->
        <div class="main-presensi-box">
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    Daftar Presensi Kehadiran Siswa
                </h2>
                <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
                    Total: <strong style="color: #0f172a;">{{ $siswas->count() }}</strong> Siswa
                </span>
            </div>

            <!-- Action Toolbar: Search, Reset & Filter Pills -->
            <div class="action-toolbar">
                <div class="search-row">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="inputCariSiswa" placeholder="Cari nama siswa atau NISN..." class="input-search-siswa">
                    </div>
                    <button type="button" id="btnResetSearch" class="btn-reset-search" title="Bersihkan Pencarian">
                        <i class="fa-solid fa-xmark"></i> Reset
                    </button>
                    <button type="button" id="btnSetSemuaHadir" class="btn-set-hadir" title="Tandai seluruh siswa sebagai Hadir">
                        <i class="fa-solid fa-check-double"></i> Set Semua Hadir
                    </button>
                </div>

                <div class="filter-pills">
                    <div class="pill-item active" data-filter="all">
                        Semua <span class="pill-badge" id="pillCountSemua">{{ $ringkasanPresensi['total'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="hadir">
                        Hadir <span class="pill-badge" id="pillCountHadir">{{ $ringkasanPresensi['hadir'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="sakit">
                        Sakit <span class="pill-badge" id="pillCountSakit">{{ $ringkasanPresensi['sakit'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="izin">
                        Izin <span class="pill-badge" id="pillCountIzin">{{ $ringkasanPresensi['izin'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="alpa">
                        Alpa <span class="pill-badge" id="pillCountAlpa">{{ $ringkasanPresensi['alpa'] }}</span>
                    </div>
                    <div class="pill-item" data-filter="dispen">
                        Dispen <span class="pill-badge" id="pillCountDispen">{{ $ringkasanPresensi['dispen'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Attendance Form -->
            <form id="formPresensi" method="POST" action="{{ route('guru.absensi-siswa.store') }}">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{ $isModeWali ? 'wali' : ($selectedJadwal ? $selectedJadwal->id_jadwal : '') }}">
                <input type="hidden" name="id_kelas" value="{{ $idKelasSelected }}">
                <input type="hidden" name="tanggal" value="{{ $targetDate }}">

                <div id="studentCardsContainer">
                    @forelse($siswas as $idx => $s)
                        @php
                            $nameArr = explode(' ', trim($s->nama_siswa));
                            $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                            $currStatus = $s->status_presensi ?? '';
                        @endphp
                        <div class="student-card-item" data-id="{{ $s->id_siswa }}" data-nama="{{ strtolower($s->nama_siswa) }}" data-nisn="{{ $s->nisn }}" data-status="{{ $currStatus ? strtolower($currStatus) : 'hadir' }}">
                            <div class="student-info">
                                <div class="avatar-initial">{{ $initials }}</div>
                                <div style="min-width: 0;">
                                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        <div class="student-name" title="{{ $s->nama_siswa }}">{{ $s->nama_siswa }}</div>
                                        <span class="badge-status-tag tag-{{ $currStatus ? strtolower($currStatus) : 'hadir' }}" id="statusBadge_{{ $s->id_siswa }}">
                                            {{ $currStatus ? $currStatus : 'Hadir' }}
                                        </span>
                                    </div>
                                    <div class="student-nisn">NISN {{ $s->nisn ?? '-' }}</div>

                                    <!-- Cross-system badges -->
                                    @if($s->surat_izin_info)
                                        <div class="badge-cross-system badge-izin-system" title="Alasan: {{ $s->surat_izin_info['keterangan'] }} ({{ $s->surat_izin_info['rentang'] }})">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                            <span><strong>Surat {{ $s->surat_izin_info['kategori'] ?? $s->surat_izin_info['jenis'] }}</strong> ({{ $s->surat_izin_info['source'] }}): {{ Str::limit($s->surat_izin_info['keterangan'], 35) }} &bull; <span style="font-weight: 600; opacity: 0.85;">{{ $s->surat_izin_info['rentang'] }}</span></span>
                                        </div>
                                    @endif

                                    @if($s->dispen_info)
                                        <div class="badge-cross-system badge-dispen-system" title="Keperluan: {{ $s->dispen_info['alasan'] }}">
                                            <i class="fa-solid fa-id-card-clip"></i>
                                            <span><strong>Dispen Disetujui:</strong> {{ Str::limit($s->dispen_info['alasan'], 35) }}{{ $s->dispen_info['jam'] }}</span>
                                        </div>
                                    @endif

                                    @if($s->telat_info)
                                        <div class="badge-cross-system badge-telat-system" title="Terlambat Pukul {{ $s->telat_info['jam_terlambat'] }} WIB (Alasan: {{ $s->telat_info['alasan'] }})">
                                            <i class="fa-solid fa-user-clock" style="color: #d97706;"></i>
                                            <span><strong>(Siswa Tersebut Telat):</strong> Jam {{ $s->telat_info['jam_terlambat'] }} WIB &bull; {{ Str::limit($s->telat_info['alasan'], 35) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- SIAD Radio Options (Toggleable) -->
                            <div class="siad-buttons">
                                <div title="Sakit">
                                    <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="s_{{ $s->id_siswa }}" value="Sakit" class="siad-input siad-input-s" {{ $currStatus === 'Sakit' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Sakit' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                    <label for="s_{{ $s->id_siswa }}" class="siad-btn siad-btn-s" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">S</label>
                                </div>

                                <div title="Izin">
                                    <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="i_{{ $s->id_siswa }}" value="Izin" class="siad-input siad-input-i" {{ $currStatus === 'Izin' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Izin' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                    <label for="i_{{ $s->id_siswa }}" class="siad-btn siad-btn-i" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">I</label>
                                </div>

                                <div title="Alpa / Tanpa Keterangan">
                                    <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="a_{{ $s->id_siswa }}" value="Alpa" class="siad-input siad-input-a" {{ $currStatus === 'Alpa' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Alpa' ? 'true' : 'false' }}" {{ $s->dispen_info ? 'disabled' : '' }}>
                                    <label for="a_{{ $s->id_siswa }}" class="siad-btn siad-btn-a" style="{{ $s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">A</label>
                                </div>

                                <div title="{{ $s->dispen_info ? 'Dispensasi Resmi Disetujui Waka Kesiswaan' : 'Opsi Dispen dikunci (hanya dapat diisi otomatis jika disetujui Waka Kesiswaan)' }}">
                                    <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="d_{{ $s->id_siswa }}" value="Dispen" class="siad-input siad-input-d" {{ $currStatus === 'Dispen' ? 'checked' : '' }} data-checked="{{ $currStatus === 'Dispen' ? 'true' : 'false' }}" {{ !$s->dispen_info ? 'disabled' : '' }}>
                                    <label for="d_{{ $s->id_siswa }}" class="siad-btn siad-btn-d" style="{{ !$s->dispen_info ? 'opacity: 0.4; cursor: not-allowed;' : '' }}">D</label>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                            <i class="fa-solid fa-users-slash" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px;"></i>
                            <div style="font-size: 15px; font-weight: 700; color: #334155;">Tidak ada data siswa</div>
                            <div style="font-size: 13px;">Belum ada siswa terdaftar di kelas ini.</div>
                        </div>
                    @endforelse
                </div>

                <div id="noMatchMessage" style="display: none; text-align: center; padding: 36px 20px; color: #64748b; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; margin-top: 10px;">
                    <i class="fa-solid fa-user-xmark" style="font-size: 28px; color: #94a3b8; margin-bottom: 10px;"></i>
                    <div style="font-weight: 700; font-size: 14px; color: #334155;">Tidak ada siswa yang sesuai</div>
                    <div style="font-size: 12.5px; margin-top: 4px;">Periksa kembali kata kunci pencarian atau ganti filter status.</div>
                </div>
            </form>
        </div>

        <!-- Right Side Widgets -->
        <div>
            <!-- Ringkasan Presensi -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Ringkasan Presensi</span>
                    <span style="font-size: 11px; background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 6px; font-weight: 700;">Live Realtime</span>
                </div>
                <div>
                    <div class="summary-row">
                        <span class="summary-label">Jumlah siswa</span>
                        <span class="summary-val" id="counterTotal">{{ $ringkasanPresensi['total'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #16a34a;"></span> Hadir</span>
                        <span class="summary-val" id="counterHadir" style="color: #16a34a;">{{ $ringkasanPresensi['hadir'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #a37c00;"></span> Sakit</span>
                        <span class="summary-val" id="counterSakit">{{ $ringkasanPresensi['sakit'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #3b9ab2;"></span> Izin</span>
                        <span class="summary-val" id="counterIzin">{{ $ringkasanPresensi['izin'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #780000;"></span> Alpa</span>
                        <span class="summary-val" id="counterAlpa">{{ $ringkasanPresensi['alpa'] ?? 0 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #4a5568;"></span> Dispen</span>
                        <span class="summary-val" id="counterDispen">{{ $ringkasanPresensi['dispen'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Absensi Rendah -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Riwayat Absensi Rendah</span>
                    <span style="font-size: 11px; color: #64748b; font-weight: 600;">1–2x Bulan Ini</span>
                </div>
                <div>
                    @forelse($absensiRendah as $ar)
                        <div style="margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f8fafc;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">{{ $ar->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $ar->keterangan }}</div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8; font-style: italic;">
                            Tidak ada catatan absensi rendah bulan ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Absensi Tinggi -->
            <div class="widget-card">
                <div class="widget-title">
                    <span>Riwayat Absensi Tinggi</span>
                    <span style="font-size: 11px; color: #dc2626; font-weight: 700;">≥ 3x Bulan Ini</span>
                </div>
                <div>
                    @forelse($absensiTinggi as $at)
                        <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #991b1b;">{{ $at->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $at->keterangan }}</div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: #94a3b8; font-style: italic;">
                            Tidak ada catatan absensi tinggi bulan ini (semua tertib).
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentCards = document.querySelectorAll('.student-card-item');
    const inputCari = document.getElementById('inputCariSiswa');
    const btnResetSearch = document.getElementById('btnResetSearch');
    const btnSetSemuaHadir = document.getElementById('btnSetSemuaHadir');
    const filterPills = document.querySelectorAll('.pill-item');
    const noMatchMessage = document.getElementById('noMatchMessage');

    let currentFilter = 'all';

    // 1. Recalculate counters and badges
    function updatePresensiUI() {
        let total = studentCards.length;
        let sakit = 0, izin = 0, alpa = 0, dispen = 0;

        studentCards.forEach(card => {
            const id = card.dataset.id;
            const radios = card.querySelectorAll('input[type="radio"]');
            let checkedRadio = null;

            radios.forEach(r => {
                if (r.checked) checkedRadio = r;
            });

            const badge = document.getElementById('statusBadge_' + id);
            let status = 'hadir';

            if (checkedRadio) {
                const val = checkedRadio.value;
                if (val === 'Sakit') { sakit++; status = 'sakit'; }
                else if (val === 'Izin') { izin++; status = 'izin'; }
                else if (val === 'Alpa') { alpa++; status = 'alpa'; }
                else if (val === 'Dispen') { dispen++; status = 'dispen'; }

                if (badge) {
                    badge.className = 'badge-status-tag tag-' + status;
                    badge.textContent = val;
                }
            } else {
                if (badge) {
                    badge.className = 'badge-status-tag tag-hadir';
                    badge.textContent = 'Hadir';
                }
            }

            card.dataset.status = status;
        });

        let hadir = Math.max(0, total - (sakit + izin + alpa + dispen));

        // Update right sidebar
        document.getElementById('counterTotal').textContent = total;
        document.getElementById('counterHadir').textContent = hadir;
        document.getElementById('counterSakit').textContent = sakit;
        document.getElementById('counterIzin').textContent = izin;
        document.getElementById('counterAlpa').textContent = alpa;
        document.getElementById('counterDispen').textContent = dispen;

        // Update filter pills
        document.getElementById('pillCountSemua').textContent = total;
        document.getElementById('pillCountHadir').textContent = hadir;
        document.getElementById('pillCountSakit').textContent = sakit;
        document.getElementById('pillCountIzin').textContent = izin;
        document.getElementById('pillCountAlpa').textContent = alpa;
        document.getElementById('pillCountDispen').textContent = dispen;

        filterRows();
    }

    // 2. Filter & Search logic
    function filterRows() {
        const query = (inputCari.value || '').trim().toLowerCase();
        let visibleCount = 0;

        studentCards.forEach(card => {
            const nama = card.dataset.nama || '';
            const nisn = card.dataset.nisn || '';
            const status = card.dataset.status || 'hadir';

            const matchesSearch = query === '' || nama.includes(query) || nisn.includes(query);
            const matchesFilter = (currentFilter === 'all') || (status === currentFilter);

            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noMatchMessage) {
            noMatchMessage.style.display = (visibleCount === 0 && studentCards.length > 0) ? 'block' : 'none';
        }
    }

    // 3. Radio Toggle Mechanism
    document.querySelectorAll('.siad-input').forEach(radio => {
        radio.addEventListener('click', function(e) {
            const isCurrentlyChecked = this.dataset.checked === 'true';
            const groupName = this.name;

            // Clear dataset.checked for all radios in this student card
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                r.dataset.checked = 'false';
            });

            if (isCurrentlyChecked) {
                // Toggle off -> Hadir
                this.checked = false;
                this.dataset.checked = 'false';
            } else {
                // Check this one
                this.checked = true;
                this.dataset.checked = 'true';
            }

            updatePresensiUI();
        });
    });

    // 4. Search input event
    inputCari.addEventListener('input', filterRows);

    // 5. Reset search
    btnResetSearch.addEventListener('click', function() {
        inputCari.value = '';
        filterRows();
        inputCari.focus();
    });

    // 6. Set Semua Hadir Button
    btnSetSemuaHadir.addEventListener('click', function() {
        document.querySelectorAll('.siad-input').forEach(radio => {
            radio.checked = false;
            radio.dataset.checked = 'false';
        });
        updatePresensiUI();
    });

    // 7. Filter Pills Click
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterRows();
        });
    });

    // Initial calculation on load
    updatePresensiUI();
});
</script>
@endsection
