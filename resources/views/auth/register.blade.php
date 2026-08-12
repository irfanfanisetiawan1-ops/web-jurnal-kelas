<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Guru — Jurnal ESEMKITA</title>
    <meta name="description" content="Daftarkan NIP, identitas, dan data diri Anda untuk mendapatkan akses ke Sistem Jurnal ESEMKITA.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary:       #6366f1;
            --primary-hover: #4f46e5;
            --accent:        #06b6d4;
            --accent-hover:  #0891b2;
            --bg-body:       #0f172a;
            --card-bg:       rgba(30, 41, 59, 0.88);
            --card-border:   rgba(255, 255, 255, 0.12);
            --input-bg:      rgba(15, 23, 42, 0.7);
            --input-border:  rgba(255, 255, 255, 0.12);
            --input-focus:   #6366f1;
            --text-main:     #f8fafc;
            --text-muted:    #94a3b8;
            --text-sub:      #cbd5e1;
            --success:       #10b981;
            --danger:        #ef4444;
        }

        html, body {
            min-height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(circle at 12% 15%, rgba(99, 102, 241, 0.22) 0%, transparent 45%),
                radial-gradient(circle at 88% 85%, rgba(6, 182, 212, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, #1e293b 0%, #0f172a 100%);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 32px 16px;
            color: var(--text-main);
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glowing Background Orbs */
        .bg-glow-1 {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            position: relative;
            z-index: 10;
        }

        .register-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.5),
                0 0 35px rgba(99, 102, 241, 0.15);
            position: relative;
            overflow: hidden;
            animation: cardAppear 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo-wrapper {
            display: inline-flex;
            position: relative;
            margin-bottom: 12px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 26px;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            transition: transform 0.3s ease;
        }

        .register-card:hover .brand-logo {
            transform: scale(1.05);
        }

        .brand-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-header p {
            color: var(--text-muted);
            font-size: 13.5px;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Notice banner */
        .notice-banner {
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 12.5px;
            color: #a5f3fc;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 22px;
            line-height: 1.45;
        }

        .notice-banner i {
            margin-top: 2px;
            font-size: 16px;
            color: #818cf8;
            flex-shrink: 0;
        }

        /* Error Alert */
        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 12.5px;
            margin-bottom: 22px;
            line-height: 1.45;
        }

        .alert-error ul {
            padding-left: 18px;
            margin: 0;
        }

        .alert-error li {
            margin-bottom: 4px;
        }

        .alert-error li:last-child {
            margin-bottom: 0;
        }

        /* Form Layout */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            color: #e2e8f0;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group label .required-asterisk {
            color: #ef4444;
            margin-left: 2px;
        }

        .optional-badge {
            font-size: 11px;
            color: #64748b;
            font-weight: 400;
            margin-left: 4px;
        }

        /* Input Wrapper with Left Icon & Right Toggle */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #64748b;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            padding: 11.5px 16px 11.5px 42px;
            font-size: 13.5px;
            font-family: inherit;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #475569;
        }

        .form-control:focus {
            border-color: var(--input-focus);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .input-wrapper:focus-within .input-icon-left {
            color: #38bdf8;
        }

        /* Password toggle button */
        .btn-toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease, background 0.2s ease;
            outline: none;
        }

        .btn-toggle-password:hover {
            color: #38bdf8;
            background: rgba(99, 102, 241, 0.1);
        }

        .form-control.has-toggle {
            padding-right: 42px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            cursor: pointer;
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
            padding: 10px;
        }

        /* Gender Radio Card Options */
        .gender-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .gender-card-option {
            position: relative;
        }

        .gender-card-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .gender-card-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 11px 14px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .gender-card-label .gender-icon {
            font-size: 16px;
            color: #64748b;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .gender-card-label span {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-sub);
            transition: color 0.2s ease;
        }

        .gender-card-option input[type="radio"]:checked + .gender-card-label {
            background: rgba(99, 102, 241, 0.18);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .gender-card-option input[type="radio"]:checked + .gender-card-label .gender-icon {
            color: #38bdf8;
            transform: scale(1.15);
        }

        .gender-card-option input[type="radio"]:checked + .gender-card-label span {
            color: #ffffff;
        }

        .gender-card-label:hover {
            border-color: rgba(99, 102, 241, 0.5);
            background: rgba(15, 23, 42, 0.85);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            margin-top: 12px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px -4px rgba(99, 102, 241, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #0891b2 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -2px rgba(99, 102, 241, 0.6);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
        }

        /* CTA Back Box */
        .login-cta-box {
            margin-top: 22px;
            padding: 14px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .btn-cta-login {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #a5f3fc;
            font-weight: 700;
            text-decoration: none;
            padding: 6px 18px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 100px;
            transition: all 0.2s ease;
        }

        .btn-cta-login:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        /* ── Responsive Viewports ─────────────────────── */
        @media (max-width: 640px) {
            body {
                padding: 20px 12px;
            }

            .register-card {
                padding: 26px 20px;
                border-radius: 20px;
            }

            .grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .brand-header {
                margin-bottom: 18px;
            }

            .brand-logo {
                width: 50px;
                height: 50px;
                font-size: 22px;
                border-radius: 14px;
            }

            .brand-header h1 {
                font-size: 20px;
            }

            .brand-header p {
                font-size: 12.5px;
            }

            .notice-banner {
                padding: 10px 12px;
                font-size: 11.5px;
            }

            .form-control {
                padding: 10.5px 14px 10.5px 38px;
                font-size: 13px;
            }

            .btn-submit {
                padding: 12.5px;
                font-size: 13.5px;
            }
        }
    </style>
</head>
<body>

<div class="bg-glow-1"></div>
<div class="bg-glow-2"></div>

<div class="register-container">
    <div class="register-card">

        <div class="brand-header">
            <div class="brand-logo-wrapper">
                <div class="brand-logo">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <h1>Pendaftaran Akun Guru</h1>
            <p>Lengkapi data diri Anda untuk membuat akun di Sistem ESEMKITA</p>
        </div>

        <div class="notice-banner">
            <i class="fa-solid fa-circle-info"></i>
            <span>Setelah mendaftar, akun Anda akan diverifikasi oleh <strong>Administrator TU</strong> sebelum dapat digunakan untuk masuk.</span>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" id="registerForm">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label for="name">Nama Lengkap & Gelar <span class="required-asterisk">*</span></label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon-left"></i>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Contoh: Rina Marlina, S.Pd"
                           required autofocus>
                </div>
            </div>

            {{-- NIP & Jenis Kelamin --}}
            <div class="grid-2">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP <span class="required-asterisk">*</span></label>
                        <span id="nipCounter" style="font-size: 11px; font-weight: 700; color: #94a3b8;">0/18 digit</span>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-id-card input-icon-left"></i>
                        <input type="text" id="nip" name="nip" class="form-control"
                               value="{{ old('nip') }}" placeholder="18 digit NIP"
                               maxlength="18" minlength="18" inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this);"
                               required>
                    </div>
                </div>

                {{-- Input Jenis Kelamin --}}
                <div class="form-group">
                    <label>Jenis Kelamin <span class="required-asterisk">*</span></label>
                    <div class="gender-group">
                        <div class="gender-card-option">
                            <input type="radio" id="jk_l" name="jenis_kelamin" value="L"
                                   {{ old('jenis_kelamin', 'L') == 'L' ? 'checked' : '' }} required>
                            <label for="jk_l" class="gender-card-label">
                                <i class="fa-solid fa-mars gender-icon"></i>
                                <span>Laki-laki</span>
                            </label>
                        </div>
                        <div class="gender-card-option">
                            <input type="radio" id="jk_p" name="jenis_kelamin" value="P"
                                   {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                            <label for="jk_p" class="gender-card-label">
                                <i class="fa-solid fa-venus gender-icon"></i>
                                <span>Perempuan</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nomor HP & Peran --}}
            <div class="grid-2">
                <div class="form-group">
                    <label for="no_hp">Nomor HP / WA <span class="optional-badge">(opsional)</span></label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-phone input-icon-left"></i>
                        <input type="tel" id="no_hp" name="no_hp" class="form-control"
                               value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890"
                               maxlength="20">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Peran <span class="required-asterisk">*</span></label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user-shield input-icon-left"></i>
                        <select id="role" name="role" class="form-control" required>
                            <option value="guru"       {{ old('role') == 'guru'       ? 'selected' : '' }}>Guru Pengajar</option>
                            <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="piket"      {{ old('role') == 'piket'      ? 'selected' : '' }}>Petugas Piket</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email <span class="optional-badge">(opsional)</span></label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon-left"></i>
                    <input type="email" id="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="rina@sekolah.sch.id">
                </div>
            </div>

            {{-- Password & Konfirmasi Password --}}
            <div class="grid-2">
                <div class="form-group">
                    <label for="password">Password <span class="required-asterisk">*</span></label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <input type="password" id="password" name="password" class="form-control has-toggle"
                               placeholder="Min. 6 karakter" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password', 'toggleIcon1')" title="Tampilkan/Sembunyikan Password">
                            <i class="fa-solid fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="required-asterisk">*</span></label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control has-toggle" placeholder="Ulangi password" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password_confirmation', 'toggleIcon2')" title="Tampilkan/Sembunyikan Konfirmasi Password">
                            <i class="fa-solid fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fa-solid fa-user-plus"></i>
                DAFTAR AKUN BARU
            </button>
        </form>

        <div class="login-cta-box">
            <span>Sudah memiliki akun terdaftar?</span>
            <a href="{{ route('login') }}" class="btn-cta-login">
                <span>Masuk Ke Akun</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </div>
</div>

<script>
    function updateNipCounter(input) {
        const counter = document.getElementById('nipCounter');
        if (!counter) return;
        const len = input.value.length;
        counter.textContent = len + '/18 digit';
        if (len === 18) {
            counter.style.color = '#34d399';
        } else {
            counter.style.color = '#ef4444';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const nipInput = document.getElementById('nip');
        if (nipInput) updateNipCounter(nipInput);
    });

    // Only digits for NIP & No HP input
    document.getElementById('nip').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('no_hp').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });

    // Toggle Password Visibility (Eye Icon)
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

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

    // Loading state on submit
    document.getElementById('registerForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> MENDAFTAR...';
        btn.disabled = true;
    });
</script>

</body>
</html>
