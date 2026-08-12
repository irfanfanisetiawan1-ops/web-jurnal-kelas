@extends($layout)

@section('title', 'Pengaturan — Jurnal ESEMKITA')
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
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .settings-header {
        padding: 24px 28px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
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
    }

    .settings-header p {
        font-size: 13px;
        color: #cbd5e1;
    }

    .settings-nav {
        display: flex;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 0 20px;
        gap: 8px;
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
    }

    .tab-btn:hover {
        color: #1e293b;
    }

    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: #ffffff;
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
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control.is-invalid {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
    }

    .form-control[readonly], .form-control[disabled] {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
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
        display: inline-block;
        padding: 4px 10px;
        background: #e2e8f0;
        color: #334155;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
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
@php
    $isSecurityActive = session('active_tab') === 'security' || $errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation');
    $isSystemActive = session('active_tab') === 'system';
    $isProfileActive = !$isSecurityActive && !$isSystemActive;
@endphp

<div class="settings-container">
    <div class="settings-card">
        <div class="settings-header">
            <div class="settings-header-icon">
                <i class="fa-solid fa-gear"></i>
            </div>
            <div>
                <h2>Pengaturan Akun & Sistem</h2>
                <p>Kelola profil pribadi, keamanan password, serta preferensi aplikasi Jurnal ESEMKITA</p>
            </div>
        </div>

        <div class="settings-nav">
            <button type="button" class="tab-btn {{ $isProfileActive ? 'active' : '' }}" onclick="switchTab('profileTab', this)">
                <i class="fa-solid fa-user-gear"></i> Profil Saya
            </button>
            <button type="button" class="tab-btn {{ $isSecurityActive ? 'active' : '' }}" onclick="switchTab('securityTab', this)">
                <i class="fa-solid fa-shield-halved"></i> Keamanan
            </button>
            @if($user->isAdmin())
            <button type="button" class="tab-btn {{ $isSystemActive ? 'active' : '' }}" onclick="switchTab('systemTab', this)">
                <i class="fa-solid fa-sliders"></i> Pengaturan Sistem & CS
            </button>
            @endif
        </div>

        <div class="settings-body">

            @if($errors->any())
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

            <!-- Tab 1: Profil Saya -->
            <div id="profileTab" class="tab-content {{ $isProfileActive ? 'active' : '' }}">
                <div id="profileJsAlert" class="alert-banner-box" style="display: none;"></div>

                <form action="{{ route('pengaturan.update-profile') }}" method="POST" onsubmit="return validateProfileForm(event)">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Role / Jabatan</label>
                            <div>
                                <span class="badge-role"><i class="fa-solid fa-user-tag"></i> {{ $user->role_label }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>NIP / Username</label>
                            <input type="text" class="form-control" value="{{ $user->nip ?? $user->username }}" readonly title="NIP/Username tidak dapat diubah secara langsung">
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
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="contoh@esemkita.sch.id">
                            @error('email')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp">Nomor HP / WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}" placeholder="081234567890">
                            @error('no_hp')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="error-feedback"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 24px; text-align: right;">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab 2: Keamanan (Ganti Password) -->
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
                        <button type="submit" class="btn-submit" style="background:#059669;">
                            <i class="fa-solid fa-key"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            @if($user->isAdmin())
            <!-- Tab 3: Pengaturan Sistem & CS Hotline (Khusus Admin/TU) -->
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
                            <input type="text" id="tahun_ajaran_aktif" name="tahun_ajaran_aktif" class="form-control" value="{{ old('tahun_ajaran_aktif', $systemSettings['tahun_ajaran_aktif']) }}" required placeholder="Contoh: 2025/2026">
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
                            <span style="font-size:11px; color:#64748b;">Gunakan format nomor internasional tanpa spasi (misal: 6281234567890)</span>
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

        if (phoneInput.value.trim()) {
            const phonePattern = /^[0-9\-\+\s\(\)]{8,20}$/;
            if (!phonePattern.test(phoneInput.value.trim())) {
                isValid = false;
                phoneInput.classList.add('is-invalid');
                messages.push('Format Nomor HP / WhatsApp tidak valid (hanya angka/simbol telepon, 8-20 digit).');
            } else {
                phoneInput.classList.remove('is-invalid');
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
</script>
@endsection
