@extends($layout)

@section('title', 'Pengaturan Profil & Akun — EDU JOURNAL')
@section('header_title', 'Pengaturan')

@section('styles')
<style>
    .settings-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .settings-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #cbd5e1;
        overflow: hidden;
    }

    .settings-header {
        padding: 24px 28px;
        background: linear-gradient(135deg, #1e293b 0%, #384972 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .settings-header-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ffffff;
    }

    .settings-header h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 2px;
        color: #ffffff;
    }

    .settings-header p {
        font-size: 13px;
        color: #cbd5e1;
        font-weight: 600;
    }

    .settings-nav {
        display: flex;
        background: #f8fafc;
        border-bottom: 1px solid #cbd5e1;
        padding: 0 20px;
        gap: 8px;
        overflow-x: auto;
    }

    .tab-btn {
        padding: 14px 20px;
        font-size: 13.5px;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-family: inherit;
        white-space: nowrap;
    }

    .tab-btn:hover {
        color: #0f172a;
    }

    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: #ffffff;
        font-weight: 800;
    }

    .settings-body {
        padding: 28px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .form-control {
        width: 100%;
        padding: 11px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        font-weight: 600;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control.is-invalid {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .form-control[readonly], .form-control[disabled] {
        background: #f1f5f9;
        color: #475569;
        cursor: not-allowed;
        font-weight: 700;
    }

    .readonly-field-tan {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        width: 100%;
    }

    .password-input-wrapper {
        position: relative;
        width: 100%;
    }

    .password-input-wrapper input {
        padding-right: 42px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 14px;
        padding: 4px;
        transition: color 0.2s ease;
    }

    .password-toggle-btn:hover {
        color: #1e293b;
    }

    .btn-submit {
        background: #2563eb;
        color: #ffffff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-submit:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid #bfdbfe;
    }

    .alert-banner-box {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 20px;
        color: #991b1b;
        font-size: 13px;
        line-height: 1.5;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    /* iOS Style Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-round {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 34px;
    }

    .slider-round:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider-round {
        background-color: #10b981;
    }

    input:checked + .slider-round:before {
        transform: translateX(22px);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
    }
</style>
@endsection

@section('content')

<<<<<<< HEAD
=======
@if(isset($user) && method_exists($user, 'isGuruPiket') && $user->isGuruPiket())
    @include('guru_piket.pengaturan')
@else
<!-- Header Top Bar -->
<div class="page-header-container">
    <div class="page-title-group">
        <h1>Pengaturan Akun & Sistem</h1>
        <p>Kelola profil pribadi, keamanan password, serta preferensi aplikasi EDU JOURNAL</p>
    </div>
</div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
@php
    $errorsBag = $errors ?? session('errors') ?? new \Illuminate\Support\ViewErrorBag;
    $hasSecErr = $errorsBag->has('current_password') || $errorsBag->has('password') || $errorsBag->has('password_confirmation');
    $activeTabReq = request('tab');
    $isSecurityActive = session('active_tab') === 'security' || $activeTabReq === 'security' || $hasSecErr;
    $isPrefActive = session('active_tab') === 'preferences' || $activeTabReq === 'preferences';
    $isSystemActive = session('active_tab') === 'system' || $activeTabReq === 'system';
    $isProfileActive = !$isSecurityActive && !$isPrefActive && !$isSystemActive;
@endphp

<div class="settings-container">
    <div class="settings-card">
        <!-- Header Banner (Image 8 & 9 Match) -->
        <div class="settings-header">
            <div class="settings-header-icon">
                <i class="fa-solid fa-gear"></i>
            </div>
            <div>
                <h2>Pengaturan Akun &amp; Sistem</h2>
                <p>Kelola profil pribadi, keamanan password, serta preferensi aplikasi EDU JOURNAL</p>
            </div>
        </div>

        <!-- Top Navigation Subnav (Image 8 & 9 Match) -->
        <div class="settings-nav">
            <button type="button" class="tab-btn {{ $isProfileActive ? 'active' : '' }}" onclick="switchTab('profileTab', this)">
                <i class="fa-solid fa-user-gear"></i> Profil Saya
            </button>

            <button type="button" class="tab-btn {{ $isSecurityActive ? 'active' : '' }}" onclick="switchTab('securityTab', this)">
                <i class="fa-solid fa-shield-halved"></i> Keamanan
            </button>

            <button type="button" class="tab-btn {{ $isPrefActive ? 'active' : '' }}" onclick="switchTab('preferencesTab', this)">
                <i class="fa-solid fa-sliders"></i> 
                @if($user->isAdmin() || $user->isTu()) Preferensi &amp; Notifikasi TU
                @elseif($user->isKepalaSekolah()) Preferensi &amp; Manajerial Kepsek
                @elseif($user->isWakaSdm()) Preferensi &amp; Manajerial Waka SDM
                @elseif($user->isWakaKesiswaan()) Preferensi &amp; Manajerial Waka Kesiswaan
                @elseif($user->isWaka()) Preferensi &amp; Manajerial Waka Kurikulum
                @elseif($user->isSatpam()) Preferensi &amp; Notifikasi Satpam
                @elseif($user->isGuruPiket()) Preferensi &amp; Tugas Piket
                @elseif($user->isWaliKelas() || $kelasWali) Preferensi &amp; Wali Kelas
                @elseif($user->isOrangTua()) Preferensi &amp; Notifikasi Orang Tua
                @else Preferensi &amp; Notifikasi Guru @endif
            </button>

            @if($user->isAdmin())
            <button type="button" class="tab-btn {{ $isSystemActive ? 'active' : '' }}" onclick="switchTab('systemTab', this)">
                <i class="fa-solid fa-screwdriver-wrench"></i> Pengaturan Sistem &amp; CS
            </button>
            @endif
        </div>

        <div class="settings-body">

            @if(session('success'))
                <div class="alert-banner-box" style="background: #ecfdf5; border-color: #6ee7b7; color: #065f46;">
                    <div style="font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert-banner-box">
                    <div style="font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i> Terdapat kesalahan pada pengisian data:
                    </div>
                    <ul style="margin-left: 20px; margin-top: 4px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ───────────────────────────────────────────────────────── -->
            <!-- TAB 1: PROFIL SAYA (EXACT MATCH IMAGE 8)                  -->
            <!-- ───────────────────────────────────────────────────────── -->
            <div id="profileTab" class="tab-content {{ $isProfileActive ? 'active' : '' }}">
                <div id="profileJsAlert" class="alert-banner-box" style="display: none;"></div>

                <form action="{{ route('pengaturan.update-profile') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateProfileForm(event)">
                    @csrf

                    <!-- Section Upload Foto Profil (Image 8 Match) -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 800; color: #1e293b; margin-bottom: 12px;">
                            <i class="fa-regular fa-image" style="color: #4f46e5; margin-right: 6px;"></i> Foto Profil Akun
                        </label>
                        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                            <div id="profilePhotoPreview" style="width: 84px; height: 84px; border-radius: 50%; background: #cbd5e1; border: 3px solid #6366f1; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; color: #ffffff; flex-shrink: 0; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);">
                                @if($user->foto_url)
                                    <img id="previewImg" src="{{ $user->foto_url }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <span id="initialSpan" style="display: none;">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                @else
                                    <span id="initialSpan">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                    <img id="previewImg" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                @endif
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                    <label for="fotoInput" style="margin: 0; padding: 9px 18px; font-size: 13px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; background: #3b82f6; color: #ffffff; transition: background 0.2s ease;">
                                        <i class="fa-solid fa-camera"></i> Pilih Foto Profil Baru
                                    </label>
                                    <input type="file" id="fotoInput" name="foto" accept="image/*" style="display: none;" onchange="previewSelectedPhoto(this)">

                                    @if($user->foto)
                                        <label style="margin: 0; display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #ef4444; cursor: pointer; font-weight: 700; background: #fee2e2; padding: 8px 14px; border-radius: 10px; border: 1px solid #fca5a5;">
                                            <input type="checkbox" name="remove_photo" value="1" id="removePhotoCheck" onchange="toggleRemovePhoto(this)">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Foto
                                        </label>
                                    @endif
                                </div>
                                <span style="font-size: 12px; color: #64748b; font-weight: 600;">Ukuran file maksimal <strong>2 MB</strong>. Format gambar yang diperbolehkan: <strong>JPG, JPEG, PNG, WEBP, GIF</strong>.</span>
                            </div>
                        </div>
                        @error('foto')
                            <span class="error-feedback" style="display: block; margin-top: 10px;"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Fields Grid (Image 8 Match) -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Role / Jabatan</label>
                            <div>
                                <span class="badge-role">
                                    <i class="fa-solid fa-user-check"></i>
                                    @if($user->isAdmin() || $user->isTu()) {{ $user->role_label }}
                                    @elseif($user->isKepalaSekolah()) Kepala Sekolah / Pimpinan Lembaga
                                    @elseif($user->isWakaSdm()) Waka SDM (Kepegawaian)
                                    @elseif($user->isWakaKesiswaan()) Waka Kesiswaan
                                    @elseif($user->isWaka()) Waka Kurikulum
                                    @elseif($user->isSatpam()) Satpam Gerbang / Petugas Keamanan
                                    @elseif($user->isGuruPiket()) Petugas Piket Harian
                                    @elseif($user->isWaliKelas() || $kelasWali) Wali Kelas ({{ $kelasWali->nama_kelas ?? 'Perwalian' }})
                                    @elseif($user->isOrangTua()) Orang Tua / Wali Murid
                                    @else Guru Mengajar
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ $user->isOrangTua() ? 'NISN / Username' : 'NIP / Username' }}</label>
                            <input type="text" class="form-control" value="{{ $user->nip ?? ($guru->nip ?? ($user->username ?? '-')) }}" readonly title="{{ $user->isOrangTua() ? 'NISN/Username tidak dapat diubah secara langsung' : 'NIP/Username tidak dapat diubah secara langsung' }}">
                        </div>

                        <div class="form-group full-width">
                            <label for="name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="email@sekolah.sch.id">
                            @error('email')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp">Nomor HP / WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp ?? ($guru->no_hp ?? '')) }}" placeholder="081234567890">
                            @error('no_hp')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? '')) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? '')) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        @if($user->isAdmin() || $user->isTu())
                            <div class="form-group">
                                <label>Unit Kerja / Divisi</label>
                                <input type="text" class="form-control" value="Tata Usaha & Administrasi Sekolah" readonly title="Unit kerja administratif">
                            </div>

                            <div class="form-group">
                                <label>Hak Akses Sistem</label>
                                <input type="text" class="form-control" value="{{ $user->role_label }} — Pengelola Sistem & Operasional" readonly title="Hak Akses Sistem">
                            </div>
                        @elseif($user->isKepalaSekolah())
                            <div class="form-group">
                                <label>Jabatan Kedinasan</label>
                                <input type="text" class="form-control" value="Kepala Sekolah / Penanggung Jawab Satuan Pendidikan" readonly title="Jabatan Pimpinan">
                            </div>

                            <div class="form-group">
                                <label>Wewenang Akses</label>
                                <input type="text" class="form-control" value="Persetujuan Final Izin, Monitoring Jurnal & Executive Reporting" readonly title="Wewenang Pimpinan">
                            </div>
                        @elseif($user->isWakaSdm())
                            <div class="form-group">
                                <label>Jabatan Kedinasan</label>
                                <input type="text" class="form-control" value="Wakil Kepala Sekolah (Waka SDM &amp; Kepegawaian)" readonly title="Jabatan Kedinasan Waka SDM">
                            </div>

                            <div class="form-group">
                                <label>Mata Pelajaran Diampu</label>
                                <input type="text" class="form-control" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Non-Spesifik / Waka SDM' }}" readonly title="Mapel diampu sesuai data master sekolah">
                            </div>

                            <div class="form-group full-width">
                                <label>Wewenang &amp; Cakupan Operasional Waka SDM</label>
                                <input type="text" class="form-control" value="Persetujuan Izin Guru/Pendidik (Tahap 1), Kehadiran &amp; KBM Guru, Direktori SDM, dan Pengumuman SDM" readonly title="Wewenang Akses Waka SDM">
                            </div>
                        @elseif($user->isWakaKesiswaan())
                            <div class="form-group">
                                <label>Jabatan Kedinasan</label>
                                <input type="text" class="form-control" value="Wakil Kepala Sekolah (Waka Kesiswaan)" readonly title="Jabatan Kedinasan Waka Kesiswaan">
                            </div>

                            <div class="form-group">
                                <label>Mata Pelajaran Diampu</label>
                                <input type="text" class="form-control" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Non-Spesifik / Waka Kesiswaan' }}" readonly title="Mapel diampu sesuai data master sekolah">
                            </div>

                            <div class="form-group full-width">
                                <label>Wewenang &amp; Cakupan Operasional Waka Kesiswaan</label>
                                <input type="text" class="form-control" value="Persetujuan Dispensasi &amp; Izin Siswa, Presensi Siswa, Pelanggaran Siswa, dan Pengumuman Kesiswaan" readonly title="Wewenang Akses Waka Kesiswaan">
                            </div>
                        @elseif($user->isWaka())
                            <div class="form-group">
                                <label>Jabatan Kedinasan</label>
                                <input type="text" class="form-control" value="Wakil Kepala Sekolah (Waka Kurikulum)" readonly title="Jabatan Kedinasan Waka Kurikulum">
                            </div>

                            <div class="form-group">
                                <label>Mata Pelajaran Diampu</label>
                                <input type="text" class="form-control" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Konsentrasi BD' }}" readonly title="Mapel diampu sesuai data master sekolah">
                            </div>

                            <div class="form-group full-width">
                                <label>Wewenang &amp; Cakupan Operasional Waka Kurikulum</label>
                                <input type="text" class="form-control" value="Persetujuan Izin Guru (Tahap 1), Monitoring Rekap Jurnal Kelas, Master Jadwal, dan Broadcast Pengumuman" readonly title="Wewenang Akses Waka Kurikulum">
                            </div>
                        @elseif($user->isSatpam())
                            <div class="form-group">
                                <label>Pos Penugasan / Divisi</label>
                                <input type="text" class="form-control" value="Pos Satpam Gerbang Utama Sekolah" readonly title="Unit Kerja Satpam">
                            </div>

                            <div class="form-group">
                                <label>Hak Akses &amp; Wewenang Sistem</label>
                                <input type="text" class="form-control" value="Validasi Gate, Scan Barcode Dispen &amp; Monitoring Log Keamanan" readonly title="Hak Akses Satpam">
                            </div>
                        @elseif($user->isGuruPiket())
                            <div class="form-group">
                                <label>Mata Pelajaran Diampu</label>
                                <input type="text" class="form-control" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Petugas Piket / Non-Mapel' }}" readonly title="Mapel diampu sesuai data master sekolah">
                            </div>

                            <div class="form-group">
                                <label>Status Wali Kelas</label>
                                <input type="text" class="form-control" value="{{ $kelasWali ? 'Wali Kelas ' . $kelasWali->nama_kelas : 'Bukan Wali Kelas (Petugas Piket Harian)' }}" readonly title="Status Wali Kelas">
                            </div>

                            <div class="form-group full-width">
                                <label>Cakupan Operasional Piket</label>
                                <input type="text" class="form-control" value="Monitoring Presensi Kelas, Penugasan Guru Pengganti, Rekap Kehadiran Guru & Izin Siswa" readonly title="Cakupan Operasional Piket">
                            </div>
                        @elseif($user->isOrangTua())
                            @php
                                $siswaConnected = $siswaOrangTua ?? ($user->siswa ?? \App\Models\Siswa::withoutGlobalScopes()->where('id_siswa', $user->id_siswa)->orWhere('nisn', $user->nip)->first());
                            @endphp
                            <div class="form-group">
                                <label>Status Akun &amp; Role</label>
                                <input type="text" class="form-control" value="Orang Tua / Wali Murid (Terverifikasi)" readonly title="Role Akun Orang Tua">
                            </div>

                            <div class="form-group">
                                <label>Siswa / Anak Terhubung</label>
                                <input type="text" class="form-control" value="{{ $siswaConnected ? $siswaConnected->nama_siswa . ' (NISN: ' . $siswaConnected->nisn . ')' : 'Siswa Terhubung' }}" readonly title="Data Siswa Terhubung">
                            </div>

                            @if($siswaConnected && $siswaConnected->kelas)
                            <div class="form-group">
                                <label>Kelas &amp; Jurusan Anak</label>
                                <input type="text" class="form-control" value="Kelas {{ $siswaConnected->kelas->nama_kelas }} — {{ $siswaConnected->kelas->jurusan ? $siswaConnected->kelas->jurusan->nama_jurusan : '-' }}" readonly title="Kelas Siswa">
                            </div>

                            <div class="form-group">
                                <label>Wali Kelas Anak</label>
                                <input type="text" class="form-control" value="{{ $siswaConnected->kelas->waliKelas ? $siswaConnected->kelas->waliKelas->nama_guru . ' (NIP: ' . ($siswaConnected->kelas->waliKelas->nip ?? '-') . ')' : 'Belum Ditentukan' }}" readonly title="Wali Kelas Siswa">
                            </div>
                            @endif
                        @else
                            <div class="form-group">
                                <label>Mata Pelajaran Diampu</label>
                                <input type="text" class="form-control" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Belum Diatur' }}" readonly title="Mapel diampu sesuai data master sekolah">
                            </div>

                            <div class="form-group">
                                <label>Wali Kelas</label>
                                <input type="text" class="form-control" value="{{ $kelasWali ? 'Wali Kelas ' . $kelasWali->nama_kelas : 'Bukan Wali Kelas (Guru Mapel)' }}" readonly title="Status Wali Kelas">
                            </div>
                        @endif
                    </div>

                    <div style="margin-top: 24px; text-align: right;">
                        <button type="submit" class="btn-submit" style="background: #3b82f6;">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- ───────────────────────────────────────────────────────── -->
            <!-- TAB 2: KEAMANAN / GANTI PASSWORD                         -->
            <!-- ───────────────────────────────────────────────────────── -->
            <div id="securityTab" class="tab-content {{ $isSecurityActive ? 'active' : '' }}">
                <div id="securityJsAlert" class="alert-banner-box" style="display: none;"></div>

                <form action="{{ route('pengaturan.update-password') }}" method="POST" onsubmit="return validateSecurityForm(event)">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="current_password">Password Saat Ini <span style="color: #ef4444;">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama Anda">
                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('current_password', this)" title="Tampilkan/Sembunyikan Password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru <span style="color: #ef4444;">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter">
                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password', this)" title="Tampilkan/Sembunyikan Password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru <span style="color: #ef4444;">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password baru">
                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation', this)" title="Tampilkan/Sembunyikan Password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 24px; text-align: right;">
                        <button type="submit" class="btn-submit" style="background: #10b981;">
                            <i class="fa-solid fa-key"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- ───────────────────────────────────────────────────────── -->
            <!-- TAB 3: PREFERENSI & NOTIFIKASI                            -->
            <!-- ───────────────────────────────────────────────────────── -->
            <div id="preferencesTab" class="tab-content {{ $isPrefActive ? 'active' : '' }}">
                @if($user->isAdmin() || $user->isTu())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Notifikasi Administrasi & Operasional TU -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi Administrasi &amp; Operasional TU</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan notifikasi otomatis untuk mendukung tugas tata usaha sekolah</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pemberitahuan Verifikasi Izin Guru &amp; Siswa</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima notifikasi saat ada pengajuan izin/sakit/dispensasi baru yang membutuhkan verifikasi TU</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="tu_notif_izin" value="1" {{ ($systemSettings['notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Monitoring Jurnal Belum Didaftarkan</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Peringatan otomatis jika ada kelas yang belum diisi jurnal mengajar harian oleh guru</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="tu_notif_jurnal_kosong" value="1" {{ ($systemSettings['notif_jurnal_kosong'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Sistem &amp; Layanan Bantuan CS</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi pemberitahuan jika terdapat tiket bantuan / laporan kendala teknis dari pengguna</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="tu_notif_sistem" value="1" {{ ($systemSettings['notif_sistem'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Preferensi Kerja & Tampilan Admin TU -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Kerja &amp; Tampilan Data</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Sesuaikan konfigurasi tampilan dan perilaku default sistem untuk Admin TU</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Data Default Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah baris data master yang ditampilkan pada tabel (Siswa, Guru, Jurnal)</div>
                                        </div>
                                        <div style="width: 180px;">
                                            <select name="tu_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Konfirmasi Dialog Sebelum Menghapus Data</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Tampilkan pop-up peringatan konfirmasi sebelum menghapus data master sekolah</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="tu_confirm_delete" value="1" {{ ($systemSettings['confirm_delete'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Laporan</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format file default saat mencetak / mengekspor laporan rekap kehadiran &amp; jurnal</div>
                                        </div>
                                        <div style="width: 180px;">
                                            <select name="tu_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #2563eb;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Admin TU
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isKepalaSekolah())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Status & Ringkasan Manajerial Sekolah -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Status &amp; Ringkasan Manajerial Sekolah</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Ringkasan indikator utama pengawasan dan kinerja operasional sekolah</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Kedudukan Pimpinan</label>
                                        <div class="readonly-field-tan" style="color: #4f46e5; font-weight: 800;"><i class="fa-solid fa-user-tie"></i> Kepala Sekolah / Penanggung Jawab Utama</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Tanggal Monitoring</label>
                                        <div class="readonly-field-tan">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Integrasi Laporan</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-chart-line"></i> Dashboard Eksekutif Tersinkronisasi Realtime</div>
                                    </div>

                                    @if($kepsekData)
                                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $kepsekData['total_guru'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Total Guru &amp; SDM</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $kepsekData['total_siswa'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Total Peserta Didik</div>
                                        </div>
                                        <div style="background: #fffbebfb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #d97706;">{{ $kepsekData['izin_pending_kepsek'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #92400e; margin-top: 2px;">Pending Persetujuan</div>
                                        </div>
                                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #7e22ce;">{{ $kepsekData['jurnal_harian_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #6b21a8; margin-top: 2px;">Jurnal Pembelajaran</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi & Alerts Manajerial Kepsek -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi &amp; Peringatan Eksekutif</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelola notifikasi instan untuk mendukung keputusan pimpinan sekolah</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pemberitahuan Persetujuan Final Izin Guru</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi instan saat terdapat pengajuan izin/sakit guru yang telah disetujui Waka dan membutuhkan persetujuan akhir Kepsek</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="kepsek_notif_izin" value="1" {{ ($systemSettings['kepsek_notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Laporan Eksekutif Ringkasan Harian Sekolah</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Kirimkan ringkasan harian keterlaksanaan KBM, kehadiran guru, dan ketidakhadiran siswa setiap sore</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="kepsek_notif_laporan_harian" value="1" {{ ($systemSettings['kepsek_notif_laporan_harian'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Evaluasi Keterlaksanaan Pembelajaran</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Peringatan jika prosentase keterisian jurnal harian sekolah berada di bawah target yang ditentukan</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="kepsek_notif_evaluasi_pembelajaran" value="1" {{ ($systemSettings['kepsek_notif_evaluasi_pembelajaran'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Operasional & Tampilan Data Eksekutif -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Operasional &amp; Tampilan Data</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan mode alur persetujuan dan format ekspor laporan manajerial</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Mode Persetujuan Izin Guru</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Metode persetujuan akhir pengajuan izin/sakit guru sekolah</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="kepsek_mode_approval" class="form-control">
                                                <option value="manual" {{ ($systemSettings['kepsek_mode_approval'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Verifikasi Manual Kepala Sekolah</option>
                                                <option value="auto_waka_recom" {{ ($systemSettings['kepsek_mode_approval'] ?? 'manual') == 'auto_waka_recom' ? 'selected' : '' }}>Setujui Otomatis jika Disetujui Waka</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Laporan Manajerial</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format dokumen saat mencetak laporan eksekutif dan rekapitulasi sekolah</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="kepsek_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['kepsek_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['kepsek_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Data Default Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah baris data yang ditampilkan pada tabel monitoring eksekutif</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="kepsek_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['kepsek_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['kepsek_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['kepsek_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['kepsek_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #4f46e5;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Kepala Sekolah
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isWaka() || $user->isWakaSdm() || $user->isWakaKesiswaan())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Status & Ringkasan Manajerial Waka -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Status &amp; Ringkasan Manajerial @if($user->isWakaSdm()) Waka SDM @elseif($user->isWakaKesiswaan()) Waka Kesiswaan @else Waka Kurikulum @endif</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Ringkasan indikator utama pengawasan @if($user->isWakaSdm()) SDM &amp; Kepegawaian Pendidik @elseif($user->isWakaKesiswaan()) Kedisiplinan &amp; Perizinan Siswa @else Kurikulum, Jadwal, &amp; KBM Pembelajaran @endif</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Kedudukan / Jabatan</label>
                                        <div class="readonly-field-tan" style="color: #4f46e5; font-weight: 800;"><i class="fa-solid fa-user-gear"></i> @if($user->isWakaSdm()) Wakil Kepala Sekolah (Waka SDM &amp; Kepegawaian) @elseif($user->isWakaKesiswaan()) Wakil Kepala Sekolah (Waka Kesiswaan) @else Wakil Kepala Sekolah (Waka Kurikulum) @endif</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Tanggal Monitoring</label>
                                        <div class="readonly-field-tan">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Integrasi Sistem</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-link"></i> Terhubung ke Kepala Sekolah, Guru Piket &amp; Admin TU</div>
                                    </div>

                                    @if($wakaData)
                                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $wakaData['total_guru'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Total Guru &amp; SDM</div>
                                        </div>
                                        <div style="background: #fffbebfb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #d97706;">{{ $wakaData['izin_pending'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #92400e; margin-top: 2px;">Izin Guru Pending</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $wakaData['dispen_pending'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Dispen Siswa Pending</div>
                                        </div>
                                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #7e22ce;">{{ $wakaData['jurnal_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #6b21a8; margin-top: 2px;">Jurnal Diisi Hari Ini</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi & Alerts Manajerial Waka -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi &amp; Peringatan Manajerial @if($user->isWakaSdm()) Waka SDM @elseif($user->isWakaKesiswaan()) Waka Kesiswaan @else Waka Kurikulum @endif</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelola pemberitahuan instan untuk memantau aktivitas KBM dan perizinan sekolah</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pemberitahuan Pengajuan Izin Guru &amp; Dispensasi Siswa</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi realtime saat terdapat pengajuan izin/sakit guru atau dispensasi siswa yang membutuhkan verifikasi Waka</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="waka_notif_izin" value="1" {{ ($systemSettings['waka_notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Monitoring Jurnal Harian Belum Didaftarkan</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Peringatan otomatis jika ada jam mengajar kelas yang belum diisi jurnalnya oleh guru bersangkutan</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="waka_notif_jurnal_kosong" value="1" {{ ($systemSettings['waka_notif_jurnal_kosong'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Broadcast Pengumuman Sekolah</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi konfirmasi saat pengumuman baru berhasil dipublikasikan ke guru &amp; siswa</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="waka_notif_pengumuman" value="1" {{ ($systemSettings['waka_notif_pengumuman'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Operasional & Tampilan Data Waka -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Operasional &amp; Tampilan Data</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan mode alur verifikasi izin dan format ekspor laporan rekapitulasi</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Mode Persetujuan Izin Waka</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Metode peninjauan permohonan izin/sakit guru &amp; dispensasi siswa</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="waka_mode_approval" class="form-control">
                                                <option value="manual" {{ ($systemSettings['waka_mode_approval'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Verifikasi Manual Waka</option>
                                                <option value="auto_valid" {{ ($systemSettings['waka_mode_approval'] ?? 'manual') == 'auto_valid' ? 'selected' : '' }}>Verifikasi Otomatis dengan Lampiran Valid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Rekapitulasi Waka</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format berkas saat mencetak / mengekspor rekapitulasi jurnal mengajar &amp; kehadiran</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="waka_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['waka_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['waka_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                                <option value="csv" {{ ($systemSettings['waka_export_format'] ?? 'pdf') == 'csv' ? 'selected' : '' }}>File CSV Data (.csv)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Data Default Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah baris data yang ditampilkan pada tabel monitoring Waka</div>
                                        </div>
                                        <div style="width: 240px;">
                                            <select name="waka_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['waka_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['waka_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['waka_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['waka_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #4f46e5;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi @if($user->isWakaSdm()) Waka SDM @elseif($user->isWakaKesiswaan()) Waka Kesiswaan @else Waka Kurikulum @endif
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isSatpam())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Informasi Satpam -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Status &amp; Informasi Satpam Gerbang</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Detail penugasan operasional keamanan dan validasi gerbang sekolah</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Pos Penugasan</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-shield-halved"></i> Pos Satpam Gerbang Utama Sekolah</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Integrasi Sistem</label>
                                        <div class="readonly-field-tan" style="color: #059669; font-weight: 800;"><i class="fa-solid fa-qrcode"></i> QR Scanner real-time terhubung ke Waka &amp; Guru Piket</div>
                                    </div>

                                    @if($satpamData)
                                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $satpamData['dispen_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Dispen Disetujui Hari Ini</div>
                                        </div>
                                        <div style="background: #fffbebfb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #d97706;">{{ $satpamData['menunggu_validasi'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #92400e; margin-top: 2px;">Menunggu Scan Gate</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $satpamData['dizinkan_keluar'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Diizinkan Keluar</div>
                                        </div>
                                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #7e22ce;">{{ $satpamData['sudah_kembali'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #6b21a8; margin-top: 2px;">Telah Kembali ke Sekolah</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Pengaturan Notifikasi & Scanner -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Notifikasi &amp; Scanner Barcode</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan notifikasi dan perilaku pemindaian barcode dispen di gerbang</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Dispensasi Siswa Baru</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima notifikasi saat ada siswa dispen yang baru disetujui Waka</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="satpam_notif_dispensasi" value="1" {{ ($systemSettings['satpam_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Suara Beep Penanda Scan Berhasil</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Bunyikan suara beeping saat barcode siswa berhasil dipindai</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="satpam_beep_scan" value="1" {{ ($systemSettings['satpam_beep_scan'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Auto-Refresh Live Data Antrean Scanner</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pembaruan otomatis data siswa dispen yang disetujui secara real-time tanpa muat ulang halaman</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="satpam_auto_refresh" value="1" {{ ($systemSettings['satpam_auto_refresh'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Baris Data Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah data log aktivitas yang ditampilkan per halaman</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="satpam_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['satpam_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['satpam_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['satpam_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['satpam_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #2563eb;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Satpam
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isGuruPiket())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Informasi & Status Guru Piket -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Status &amp; Informasi Petugas Piket</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Detail penugasan dan ringkasan operasional piket harian</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Status Petugas</label>
                                        <div class="readonly-field-tan" style="color: #059669; font-weight: 800;"><i class="fa-solid fa-circle-check"></i> Aktif - Petugas Piket Harian Sekolah</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Tanggal Piket Harian</label>
                                        <div class="readonly-field-tan">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Cakupan Tugas</label>
                                        <div class="readonly-field-tan">Monitoring Jurnal, Penugasan Guru Pengganti, Rekap Kehadiran, Verifikasi Izin</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Integrasi Sistem</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-link"></i> Terhubung &amp; Tersinkronisasi Realtime</div>
                                    </div>

                                    @if($piketData)
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $piketData['total_jurnal_piket'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Jurnal Harian Masuk</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $piketData['penugasan_aktif'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Guru Pengganti Aktif</div>
                                        </div>
                                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #b91c1c;">{{ $piketData['guru_tidak_hadir'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #991b1b; margin-top: 2px;">Guru Tidak Hadir Hari Ini</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi & Alerts Guru Piket -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi &amp; Peringatan Instan Piket</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelola pemberitahuan instan untuk mendukung tugas harian piket</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Guru Tidak Hadir Realtime</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima notifikasi otomatis saat ada guru mengajukan izin/sakit hari ini</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="piket_notif_guru_izin" value="1" {{ ($systemSettings['piket_notif_guru_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Monitoring Jurnal Belum Didaftarkan</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Ingatkan kelas yang belum terisi jurnal mengajar setelah jam pelajaran selesai</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="piket_notif_jurnal_kosong" value="1" {{ ($systemSettings['piket_notif_jurnal_kosong'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pemberitahuan Dispensasi &amp; Surat Izin Siswa</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi instan saat terdapat siswa mengajukan surat izin / dispensasi meninggalkan kelas</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="piket_notif_dispensasi" value="1" {{ ($systemSettings['piket_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Laporan Ringkasan Harian Piket</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Kirimkan ringkasan harian kehadiran &amp; penugasan guru pengganti setiap sore</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="piket_notif_ringkasan" value="1" {{ ($systemSettings['piket_notif_ringkasan'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Kerja Operasional Piket -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Operasional Penugasan Piket</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan mode alur penugasan dan cetak dokumen untuk Guru Piket</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Mode Penugasan Guru Pengganti</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Metode penentuan guru pengganti saat ada guru berhalangan hadir</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="piket_mode_guru_pengganti" class="form-control">
                                                <option value="manual" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Pilih Manual oleh Piket</option>
                                                <option value="rekomendasi" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? 'manual') == 'rekomendasi' ? 'selected' : '' }}>Saran Otomatis (Rumpun Mapel)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Cetak Rekap Piket</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format dokumen saat mencetak laporan rekap kehadiran &amp; jurnal piket</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="piket_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['piket_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['piket_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Data Default Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah baris data yang ditampilkan pada tabel rekap dan jurnal piket</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="piket_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #10b981;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Guru Piket
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isWaliKelas() || $kelasWali)
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Informasi & Ringkasan Perwalian -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Status &amp; Informasi Wali Kelas</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Detail perwalian dan ringkasan operasional siswa kelas Anda</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Kelas Perwalian</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-user-shield"></i> {{ $waliData['nama_kelas'] ?? ($kelasWali ? $kelasWali->nama_kelas : 'Belum Ditugaskan') }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Jurusan &amp; Ruangan</label>
                                        <div class="readonly-field-tan">{{ $waliData['jurusan'] ?? '-' }} — Ruangan {{ $waliData['ruangan'] ?? '-' }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Tahun Ajaran / Semester</label>
                                        <div class="readonly-field-tan">{{ $systemSettings['tahun_ajaran_aktif'] ?? '2026/2027' }} — Semester {{ $systemSettings['semester_aktif'] ?? 'Ganjil' }}</div>
                                    </div>

                                    @if($waliData)
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $waliData['total_siswa'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Total Siswa Perwalian</div>
                                        </div>
                                        <div style="background: #fffbebfb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #d97706;">{{ $waliData['dispen_pending'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #92400e; margin-top: 2px;">Dispensasi Pending</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $waliData['surat_izin_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Surat Izin Hari Ini</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi Presensi & Approval Wali Kelas -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi Presensi &amp; Verification Wali Kelas</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan notifikasi pemberitahuan presensi dan surat izin siswa kelas Anda</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Surat Izin/Sakit Siswa Baru</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima pemberitahuan instan saat ada pengajuan surat izin/sakit siswa di kelas perwalian</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="wali_notif_izin" value="1" {{ ($systemSettings['wali_notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Pengajuan Dispensasi Siswa</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi saat ada siswa perwalian mengajukan surat dispensasi meninggalkan kelas</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="wali_notif_dispensasi" value="1" {{ ($systemSettings['wali_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Alert Rekap Harian Kehadiran Kelas</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Peringatan otomatis jika ada siswa perwalian tidak hadir/tanpa keterangan pada hari ini</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="wali_notif_rekap_harian" value="1" {{ ($systemSettings['wali_notif_rekap_harian'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Operasional & Tampilan Data Wali Kelas -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Operasional &amp; Tampilan Data</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Pengaturan mode alur kerja dan cetak berkas presensi perwalian</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Mode Persetujuan Dispensasi</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Metode konfirmasi perizinan dispensasi siswa kelas perwalian</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="wali_mode_dispen" class="form-control">
                                                <option value="manual" {{ ($systemSettings['wali_mode_dispen'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Konfirmasi Manual Wali Kelas</option>
                                                <option value="auto_bukti" {{ ($systemSettings['wali_mode_dispen'] ?? 'manual') == 'auto_bukti' ? 'selected' : '' }}>Setujui Otomatis (Jika Ada Surat)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Rekap Kelas</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format berkas default saat mengunduh laporan rekapitulasi kehadiran perwalian</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="wali_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['wali_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['wali_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Data Default Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah baris siswa yang ditampilkan pada tabel kelas perwalian</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="wali_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['wali_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['wali_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['wali_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['wali_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #4f46e5;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Wali Kelas
                                </button>
                            </div>

                        </div>
                    </form>
                @elseif($user->isOrangTua())
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Data Putra / Putri & Ringkasan Presensi -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Data Putra / Putri &amp; Status Akademik</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Detail data siswa yang dipantau dari akun Orang Tua Anda serta ringkasan presensi bulan berjalan</p>

                                @php
                                    $siswaOrtu = $siswaOrangTua ?? ($user->siswa ?? \App\Models\Siswa::withoutGlobalScopes()->where('id_siswa', $user->id_siswa)->orWhere('nisn', $user->nip)->first());
                                    $waliGuru = $siswaOrtu && $siswaOrtu->kelas && $siswaOrtu->kelas->waliKelas ? $siswaOrtu->kelas->waliKelas : null;
                                @endphp

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Nama Siswa</label>
                                        <div class="readonly-field-tan" style="color: #2563eb; font-weight: 800;"><i class="fa-solid fa-graduation-cap"></i> {{ $siswaOrtu ? $siswaOrtu->nama_siswa : 'Belum Terhubung' }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">NISN &amp; NIS</label>
                                        <div class="readonly-field-tan">{{ $siswaOrtu ? 'NISN: ' . $siswaOrtu->nisn . ($siswaOrtu->nis ? ' | NIS: ' . $siswaOrtu->nis : '') : ($user->nip ?? '-') }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Kelas &amp; Jurusan</label>
                                        <div class="readonly-field-tan">{{ $siswaOrtu && $siswaOrtu->kelas ? 'Kelas ' . $siswaOrtu->kelas->nama_kelas . ($siswaOrtu->kelas->jurusan ? ' — ' . $siswaOrtu->kelas->jurusan->nama_jurusan : '') : 'Belum Ditentukan' }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Wali Kelas</label>
                                        <div class="readonly-field-tan">{{ $waliGuru ? $waliGuru->nama_guru . ' (NIP: ' . ($waliGuru->nip ?? '-') . ')' : 'Belum Ditentukan' }}</div>
                                    </div>

                                    @if(isset($ortuMetrics))
                                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 8px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $ortuMetrics['persen_hadir'] ?? 100 }}%</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Tingkat Kehadiran</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $ortuMetrics['hadir'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Hadir Bulan Ini</div>
                                        </div>
                                        <div style="background: #fefce8; border: 1px solid #fef08a; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #a16207;">{{ ($ortuMetrics['sakit'] ?? 0) + ($ortuMetrics['izin'] ?? 0) }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #854d0e; margin-top: 2px;">Sakit &amp; Izin</div>
                                        </div>
                                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #b91c1c;">{{ $ortuMetrics['alfa'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #991b1b; margin-top: 2px;">Tanpa Keterangan</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi & Peringatan Orang Tua -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi &amp; Peringatan Orang Tua</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelola pemberitahuan aktivitas presensi dan perkembangan sekolah putra/putri Anda</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Kehadiran &amp; Absensi Harian</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima notifikasi pemberitahuan saat status presensi harian putra/putri Anda dicatat oleh sekolah</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="ortu_notif_kehadiran" value="1" {{ ($systemSettings['ortu_notif_kehadiran'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pemberitahuan Status Izin &amp; Dispensasi</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pemberitahuan langsung saat pengajuan surat izin atau dispensasi putra/putri Anda diproses oleh sekolah</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="ortu_notif_izin" value="1" {{ ($systemSettings['ortu_notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Laporan Rekapitulasi Presensi Bulanan</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Terima rangkuman rekapitulasi kehadiran dan keterlambatan putra/putri Anda di akhir bulan</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="ortu_notif_laporan" value="1" {{ ($systemSettings['ortu_notif_laporan'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Broadcast Pengumuman Sekolah</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pemberitahuan informasi penting, jadwal libur, dan edaran resmi dari pihak sekolah</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="ortu_notif_pengumuman" value="1" {{ ($systemSettings['ortu_notif_pengumuman'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Tampilan & Ekspor Laporan -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Unduhan Laporan</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Format berkas default saat mengunduh rekap presensi dan surat permohonan izin</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Rekap Presensi</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pilih format berkas default saat mencetak laporan kehadiran putra/putri Anda</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="ortu_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['ortu_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF (.pdf)</option>
                                                <option value="excel" {{ ($systemSettings['ortu_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Hotline Bantuan & Kontak Cepat Sekolah -->
                            <div style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%); border-radius: 16px; border: 1px solid #bfdbfe; padding: 24px;">
                                <h3 style="font-size: 17px; font-weight: 800; color: #1e3a8a; margin-bottom: 2px;">
                                    <i class="fa-solid fa-headset" style="margin-right: 6px; color: #2563eb;"></i> Layanan Bantuan &amp; Hotline Sekolah
                                </h3>
                                <p style="font-size: 12.5px; color: #475569; font-weight: 600; margin-bottom: 16px;">Hubungi Wali Kelas atau Customer Service sekolah jika ada kendala terkait presensi dan pembelajaran anak</p>

                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px;">
                                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Wali Kelas</div>
                                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $waliGuru ? $waliGuru->nama_guru : 'Belum Ditugaskan' }}</div>
                                            @if($waliGuru && !empty($waliGuru->no_hp))
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waliGuru->no_hp) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; color: #059669; font-weight: 700; text-decoration: none; margin-top: 2px;">
                                                    <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div style="flex: 1; overflow: hidden;">
                                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Hotline CS Sekolah</div>
                                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;">{{ $systemSettings['cs_whatsapp'] ?? '081234567890' }}</div>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $systemSettings['cs_whatsapp'] ?? '6281234567890') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; color: #2563eb; font-weight: 700; text-decoration: none; margin-top: 2px;">
                                                <i class="fa-brands fa-whatsapp"></i> Hubungi CS
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #2563eb;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Orang Tua
                                </button>
                            </div>

                        </div>
                    </form>
                @else
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Card 1: Informasi Mengajar & Perwalian -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Informasi Mengajar &amp; Perwalian</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Detail bidang studi pengajaran dan perwalian kelas Anda</p>

                                <div style="display: flex; flex-direction: column; gap: 14px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Mata Pelajaran</label>
                                        <div class="readonly-field-tan">{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Belum Diatur' }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Kelas Perwalian</label>
                                        <div class="readonly-field-tan">{{ $kelasWali ? 'Wali Kelas ' . $kelasWali->nama_kelas : 'Bukan Wali Kelas (Guru Mapel)' }}</div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <label style="font-size: 13.5px; font-weight: 700; color: #1e293b; width: 180px; flex-shrink: 0;">Tahun Ajaran / Semester</label>
                                        <div class="readonly-field-tan">{{ $systemSettings['tahun_ajaran_aktif'] ?? '2026/2027' }} — Semester {{ $systemSettings['semester_aktif'] ?? 'Ganjil' }}</div>
                                    </div>

                                    @if($guruDataMetrics)
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 6px;">
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #1d4ed8;">{{ $guruDataMetrics['jurnal_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #1e40af; margin-top: 2px;">Jurnal Diisi Hari Ini</div>
                                        </div>
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #15803d;">{{ $guruDataMetrics['total_jadwal_today'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #166534; margin-top: 2px;">Jadwal Mengajar Hari Ini</div>
                                        </div>
                                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 22px; font-weight: 800; color: #7e22ce;">{{ $guruDataMetrics['jurnal_month'] ?? 0 }}</div>
                                            <div style="font-size: 11.5px; font-weight: 700; color: #6b21a8; margin-top: 2px;">Total Jurnal Bulan Ini</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2: Notifikasi Presensi & Pengajuan Guru -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Notifikasi Presensi &amp; Pengajuan</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Kelola peringatan dan pemberitahuan aktivitas presensi kelas Anda</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Surat Izin/Sakit Siswa Baru</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Notifikasi saat ada pengajuan izin siswa di kelas Anda yang membutuhkan perhatian</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="guru_notif_izin" value="1" {{ ($systemSettings['guru_notif_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Pengingat Pengisian Jurnal Mengajar</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pengingat otomatis untuk melengkapi jurnal mengajar harian sebelum jam mengajar berakhir</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="guru_notif_jurnal" value="1" {{ ($systemSettings['guru_notif_jurnal'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Notifikasi Dispensasi Siswa</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pemberitahuan instan saat ada siswa di kelas Anda yang sedang dalam tugas dispensasi sekolah</div>
                                        </div>
                                        <div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="guru_notif_dispensasi" value="1" {{ ($systemSettings['guru_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider-round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Preferensi Kerja & Tampilan Data Guru -->
                            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 24px;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Preferensi Tampilan &amp; Ekspor</h3>
                                <p style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 16px;">Sesuaikan konfigurasi tampilan data dan cetak laporan presensi</p>

                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Jumlah Baris Data Per Halaman</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Jumlah data siswa dan jurnal yang ditampilkan pada tabel kelas</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="guru_data_per_page" class="form-control">
                                                <option value="10" {{ ($systemSettings['guru_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                                                <option value="25" {{ ($systemSettings['guru_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                                                <option value="50" {{ ($systemSettings['guru_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                                                <option value="100" {{ ($systemSettings['guru_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                        <div style="flex: 1;">
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Format Default Ekspor Jurnal &amp; Rekap</div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Format berkas default saat mengunduh / mencetak rekapitulasi jurnal mengajar</div>
                                        </div>
                                        <div style="width: 220px;">
                                            <select name="guru_export_format" class="form-control">
                                                <option value="pdf" {{ ($systemSettings['guru_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                                                <option value="excel" {{ ($systemSettings['guru_export_format'] ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn-submit" style="background: #2563eb;">
                                    <i class="fa-solid fa-sliders"></i> Simpan Preferensi Guru
                                </button>
                            </div>

                        </div>
                    </form>
                @endif
            </div>

            @if($user->isAdmin())
            <!-- ───────────────────────────────────────────────────────── -->
            <!-- TAB 4: PENGATURAN SISTEM & CS (KHUSUS ADMIN/TU)           -->
            <!-- ───────────────────────────────────────────────────────── -->
            <div id="systemTab" class="tab-content {{ $isSystemActive ? 'active' : '' }}">
                <form action="{{ route('pengaturan.update-system') }}" method="POST">
                    @csrf
                    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:14px 18px; margin-bottom:20px; color:#1e40af; font-size:13px;">
                        <i class="fa-solid fa-circle-info"></i> <strong>Modul Administrator:</strong> Pengaturan di bawah ini mempengaruhi informasi kontak Hotline CS dan parameter akademik di seluruh portal aplikasi.
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="app_name">Nama Aplikasi</label>
                            <input type="text" id="app_name" name="app_name" class="form-control" value="{{ old('app_name', $systemSettings['app_name']) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="tahun_ajaran_aktif">Tahun Ajaran Aktif</label>
                            <input type="text" id="tahun_ajaran_aktif" name="tahun_ajaran_aktif" class="form-control" value="{{ old('tahun_ajaran_aktif', $systemSettings['tahun_ajaran_aktif']) }}" required placeholder="Contoh: 2026/2027">
                        </div>

                        <div class="form-group">
                            <label for="semester_aktif">Semester Aktif</label>
                            <select id="semester_aktif" name="semester_aktif" class="form-control" required>
                                <option value="Ganjil" {{ $systemSettings['semester_aktif'] == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ $systemSettings['semester_aktif'] == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cs_whatsapp">Nomor WhatsApp CS (Hotline)</label>
                            <input type="text" id="cs_whatsapp" name="cs_whatsapp" class="form-control" value="{{ old('cs_whatsapp', $systemSettings['cs_whatsapp']) }}" required placeholder="Format: 6281234567890">
                        </div>

                        <div class="form-group">
                            <label for="cs_email">Email Customer Service</label>
                            <input type="email" id="cs_email" name="cs_email" class="form-control" value="{{ old('cs_email', $systemSettings['cs_email']) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cs_jam_kerja">Jam Operasional CS</label>
                            <input type="text" id="cs_jam_kerja" name="cs_jam_kerja" class="form-control" value="{{ old('cs_jam_kerja', $systemSettings['cs_jam_kerja']) }}" required placeholder="Contoh: Senin - Jumat (07:00 - 15:30 WIB)">
                        </div>
                    </div>

                    <div style="margin-top: 24px; text-align: right;">
                        <button type="submit" class="btn-submit" style="background:#4f46e5;">
                            <i class="fa-solid fa-sliders"></i> Simpan Pengaturan Sistem
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(button => button.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function validateProfileForm(e) {
        let isValid = true;
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('no_hp');
        const errBox = document.getElementById('profileJsAlert');
        
        errBox.style.display = 'none';
        errBox.innerHTML = '';
        
        let messages = [];

        if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
            isValid = false;
            nameInput.classList.add('is-invalid');
            messages.push('Nama Lengkap wajib diisi (minimal 3 karakter).');
        } else {
            nameInput.classList.remove('is-invalid');
        }

        if (emailInput.value.trim()) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value.trim())) {
                isValid = false;
                emailInput.classList.add('is-invalid');
                messages.push('Format Alamat Email tidak valid.');
            } else {
                emailInput.classList.remove('is-invalid');
            }
        }

        if (!isValid) {
            e.preventDefault();
            errBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <strong>Gagal Memperbarui Profil:</strong><ul style="margin-left:20px; margin-top:4px;">' + messages.map(m => `<li>${m}</li>`).join('') + '</ul>';
            errBox.style.display = 'block';
            errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    function validateSecurityForm(e) {
        let isValid = true;
        const curPass = document.getElementById('current_password');
        const newPass = document.getElementById('password');
        const confirmPass = document.getElementById('password_confirmation');
        const errBox = document.getElementById('securityJsAlert');

        errBox.style.display = 'none';
        errBox.innerHTML = '';

        let messages = [];

        if (!curPass.value) {
            isValid = false;
            curPass.classList.add('is-invalid');
            messages.push('Password Saat Ini wajib diisi.');
        } else {
            curPass.classList.remove('is-invalid');
        }

        if (!newPass.value) {
            isValid = false;
            newPass.classList.add('is-invalid');
            messages.push('Password Baru wajib diisi.');
        } else if (newPass.value.length < 6) {
            isValid = false;
            newPass.classList.add('is-invalid');
            messages.push('Password Baru minimal 6 karakter.');
        } else {
            newPass.classList.remove('is-invalid');
        }

        if (!confirmPass.value) {
            isValid = false;
            confirmPass.classList.add('is-invalid');
            messages.push('Konfirmasi Password Baru wajib diisi.');
        } else if (confirmPass.value !== newPass.value) {
            isValid = false;
            confirmPass.classList.add('is-invalid');
            messages.push('Konfirmasi Password Baru tidak cocok dengan Password Baru.');
        } else {
            confirmPass.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            errBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> <strong>Gagal Perbarui Password:</strong><ul style="margin-left:20px; margin-top:4px;">' + messages.map(m => `<li>${m}</li>`).join('') + '</ul>';
            errBox.style.display = 'block';
            errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    function previewSelectedPhoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal ukuran foto profil adalah 2 MB.');
                input.value = '';
                return;
            }

            const removeCheck = document.getElementById('removePhotoCheck');
            if (removeCheck) removeCheck.checked = false;

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('previewImg');
                const initialSpan = document.getElementById('initialSpan');
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                if (initialSpan) {
                    initialSpan.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    }

    function toggleRemovePhoto(checkbox) {
        const fotoInput = document.getElementById('fotoInput');
        const previewImg = document.getElementById('previewImg');
        const initialSpan = document.getElementById('initialSpan');

        if (checkbox.checked) {
            if (fotoInput) fotoInput.value = '';
            if (previewImg) previewImg.style.display = 'none';
            if (initialSpan) initialSpan.style.display = 'block';
        } else {
            const origSrc = "{{ $user->foto_url ?? '' }}";
            if (origSrc && previewImg) {
                previewImg.src = origSrc;
                previewImg.style.display = 'block';
                if (initialSpan) initialSpan.style.display = 'none';
            }
        }
    }
</script>
@endsection
