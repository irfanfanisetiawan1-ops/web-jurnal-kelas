<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — EDU JOURNAL</title>
    <meta name="description" content="Sistem Presensi & Jurnal Pembelajaran Digital EDU JOURNAL — Portal Akses Guru dan Tenaga Kependidikan.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary:       #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --text-dark:     #0f172a;
            --text-card-head:#1e293b;
            --text-muted:    #64748b;
            --text-label:    #334155;
            --bg-body:       #eef4ff;
            --border-color:  #cbd5e1;
            --input-bg:      #f8fafc;
            --card-shadow:   0 20px 50px -10px rgba(37, 99, 235, 0.1), 0 10px 30px -15px rgba(0, 0, 0, 0.04);
        }

        html, body {
            min-height: 100%;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            min-height: 100dvh;
            position: relative;
            background: linear-gradient(135deg, #f0f5ff 0%, #e4edff 50%, #eef4ff 100%);
        }

        /* ── Vector Background Wave Orbs & Edge Accents ── */
        .bg-waves {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .bg-gradient-edge-topleft {
            position: absolute;
            top: -120px;
            left: -120px;
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.3) 0%, rgba(147, 197, 253, 0.15) 50%, transparent 70%);
            border-radius: 50%;
            filter: blur(45px);
        }

        .bg-gradient-edge-bottomright {
            position: absolute;
            bottom: -140px;
            right: -140px;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(129, 140, 248, 0.28) 0%, rgba(165, 243, 252, 0.22) 50%, transparent 70%);
            border-radius: 50%;
            filter: blur(55px);
        }

        .bg-wave-left {
            position: absolute;
            top: -6%;
            left: -8%;
            width: 55vw;
            height: 65vh;
            background: radial-gradient(circle, rgba(191, 219, 254, 0.45) 0%, rgba(224, 231, 255, 0.15) 60%, transparent 80%);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            filter: blur(40px);
        }

        .bg-wave-right {
            position: absolute;
            bottom: -10%;
            right: -8%;
            width: 60vw;
            height: 70vh;
            background: radial-gradient(circle, rgba(191, 219, 254, 0.4) 0%, rgba(219, 234, 254, 0.2) 50%, transparent 75%);
            border-radius: 60% 40% 30% 70% / 50% 30% 70% 50%;
            filter: blur(50px);
        }

        /* Faint Dot Matrix Grid Patterns */
        .dot-pattern-top {
            position: absolute;
            top: 40px;
            left: 45%;
            width: 120px;
            height: 80px;
            background-image: radial-gradient(#93c5fd 2px, transparent 2px);
            background-size: 14px 14px;
            opacity: 0.45;
            pointer-events: none;
        }

        .dot-pattern-right {
            position: absolute;
            top: 30px;
            right: 20px;
            width: 100px;
            height: 100px;
            background-image: radial-gradient(#93c5fd 2px, transparent 2px);
            background-size: 14px 14px;
            opacity: 0.4;
            pointer-events: none;
        }

        .dot-pattern-left {
            position: absolute;
            bottom: 40px;
            left: 20px;
            width: 100px;
            height: 100px;
            background-image: radial-gradient(#93c5fd 2px, transparent 2px);
            background-size: 14px 14px;
            opacity: 0.35;
            pointer-events: none;
        }

        /* ── Main Container ── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 48px;
        }

        /* ── Left Column: Text & 3D Artwork ── */
        .brand-section {
            flex: 1;
            max-width: 540px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-title {
            font-size: 44px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.8px;
        }

        .welcome-title .text-dark {
            color: #0f172a;
        }

        .welcome-title .text-blue {
            color: #2563eb;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: #64748b;
            font-weight: 500;
            line-height: 1.55;
            margin-top: 14px;
            margin-bottom: 36px;
        }

        /* 3D Scene Composition */
        .illustration-container {
            width: 100%;
            max-width: 520px;
            position: relative;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 20px 35px rgba(37, 99, 235, 0.12));
        }

        /* ── Right Column: Login Card ── */
        .card-section {
            flex-shrink: 0;
            width: 100%;
            max-width: 460px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 38px 36px 32px 36px;
            width: 100%;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.9);
            position: relative;
            transition: transform 0.3s ease;
        }

        /* Header logo */
        .card-head {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-badge {
            width: 100px;
            height: 100px;
            margin: 0 auto 14px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-head h2 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.4px;
            margin-bottom: 6px;
        }

        .card-head p {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 400;
            line-height: 1.45;
        }

        /* Alerts */
        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 12.5px;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            line-height: 1.45;
        }
        .alert i { margin-top: 2px; flex-shrink: 0; font-size: 15px; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }

        /* Form Controls */
        .form-group {
            margin-bottom: 18px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-label);
        }

        .form-group label span.required {
            color: #ef4444;
        }

        .char-counter {
            font-size: 12px;
            font-weight: 600;
            color: #2563eb;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px 12px 42px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        .input-wrap:focus-within .input-icon {
            color: #2563eb;
        }

        /* Password toggle button */
        .toggle-pass {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 15px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: color 0.2s;
            outline: none;
        }

        .toggle-pass:hover {
            color: #2563eb;
        }

        /* Remember & Forgot options row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
            margin-bottom: 22px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .remember-row input[type="checkbox"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid #cbd5e1;
            border-radius: 5px;
            background: #ffffff;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .remember-row input[type="checkbox"]:checked {
            background: #2563eb;
            border-color: #2563eb;
        }

        .remember-row input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 10px;
            color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .remember-row label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -4px rgba(37, 99, 235, 0.5);
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
        }

        /* Subtle Divider Between Primary and Role Portals */
        .role-portal-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 18px 0 12px;
        }

        .role-portal-divider::before,
        .role-portal-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .role-portal-divider span {
            padding: 0 12px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Secondary Role Login Buttons - Aesthetic, Indah & Modern */
        .btn-secondary-role {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 46px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: 0.2px;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            position: relative;
            cursor: pointer;
        }

        .btn-secondary-role:active {
            transform: scale(0.985);
        }

        /* Tombol 1: Masuk sebagai Orang Tua (Kombinasi Putih, Abu-Abu Muda Cerah & Grey Elegan) */
        .btn-role-ortu {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 60%, #f1f5f9 100%);
            border: 1.5px solid #cbd5e1;
            color: #334155;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        .btn-role-ortu:hover {
            background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
            border-color: #3b82f6;
            color: #1d4ed8;
            transform: translateY(-1.5px);
            box-shadow: 0 6px 16px -2px rgba(37, 99, 235, 0.12), inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        /* Tombol 2: Masuk sebagai Guru Piket / Satpam (Kombinasi Putih, Biru Muda Cerah Segar & Royal Blue) */
        .btn-role-petugas {
            margin-top: 10px;
            background: linear-gradient(180deg, #ffffff 0%, #eff6ff 60%, #e0edff 100%);
            border: 1.5px solid #bfdbfe;
            color: #1d4ed8;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .btn-role-petugas:hover {
            background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
            border-color: #2563eb;
            color: #1e40af;
            transform: translateY(-1.5px);
            box-shadow: 0 6px 18px -2px rgba(37, 99, 235, 0.18), inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        /* Notice / Announcement Callout Box */
        .announcement-box {
            margin-top: 20px;
            padding: 16px;
            background: #eff6ff;
            border-radius: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .announcement-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #3b82f6;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .announcement-body {
            flex: 1;
        }

        .announcement-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 4px;
        }

        .announcement-text {
            font-size: 12px;
            color: #475569;
            line-height: 1.5;
        }

        .announcement-text strong {
            color: #1e293b;
            font-weight: 700;
        }

        /* Security Badge Footer below Card */
        .security-footer {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        .security-footer i {
            color: #2563eb;
            font-size: 13px;
        }

        /* ── Responsive Viewports ── */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                justify-content: center;
                gap: 36px;
                padding: 32px 20px;
            }

            .brand-section {
                max-width: 100%;
                text-align: center;
                align-items: center;
            }

            .welcome-title {
                font-size: 34px;
            }

            .welcome-subtitle {
                margin-bottom: 24px;
            }

            .illustration-container {
                max-width: 380px;
            }
        }

        @media (max-width: 576px) {
            .login-wrapper {
                padding: 20px 16px;
            }

            .welcome-title {
                font-size: 28px;
            }

            .welcome-subtitle {
                font-size: 14px;
            }

            .login-card {
                padding: 26px 20px;
                border-radius: 22px;
            }

            .card-head h2 {
                font-size: 20px;
            }

            .card-head p {
                font-size: 12.5px;
            }

            .illustration-container {
                max-width: 280px;
            }
        }
    </style>
</head>
<body>

{{-- Background Fluid & Gradient Edge Elements --}}
<div class="bg-waves">
    <div class="bg-gradient-edge-topleft"></div>
    <div class="bg-gradient-edge-bottomright"></div>
    <div class="bg-wave-left"></div>
    <div class="bg-wave-right"></div>
    <div class="dot-pattern-top"></div>
    <div class="dot-pattern-right"></div>
    <div class="dot-pattern-left"></div>
</div>

<div class="login-wrapper">

    {{-- ══ Sisi Kiri: Branding & Vektor Ilustrasi 3D ══ --}}
    <div class="brand-section">
        <h1 class="welcome-title">
            <span class="text-dark">Selamat Datang</span><br>
            <span class="text-blue">Kembali!</span>
        </h1>
        
        <p class="welcome-subtitle">
            Login untuk mengakses jurnal kelas<br>dengan mudah dan cepat.
        </p>

        {{-- 3D Composition Image: Laptop + Stack of Books + Potted Plant --}}
        <div class="illustration-container">
            <img src="{{ asset('images/gambar_laptop_buku_tumbuhan.png') }}" alt="Ilustrasi EDU JOURNAL" class="illustration-img">
        </div>
    </div>

    {{-- ══ Sisi Kanan: Kartu Login ══ --}}
    <div class="card-section">
        <div class="login-card">

            {{-- Head Logo & Titles --}}
            <div class="card-head">
                <div class="logo-badge">
                    <img src="{{ asset('images/logo_jurnal_baru.png') }}" alt="EDU JOURNAL Logo">
                </div>
                <h2>Masuk ke Akun Anda</h2>
                <p>Masukkan NIP dan kata sandi Anda<br>untuk mengakses portal jurnal.</p>
            </div>

            {{-- Flash Alert Messages --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Login Form --}}
            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                {{-- NIP Input --}}
                <div class="form-group">
                    <div class="label-row">
                        <label for="nip">NIP <span class="required">*</span></label>
                        <span id="nipCounter" class="char-counter">0/18 digit</span>
                    </div>
                    <div class="input-wrap">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input
                            type="text"
                            id="nip"
                            name="nip"
                            class="form-control"
                            value="{{ old('nip') }}"
                            placeholder="Masukkan 18 digit NIP Anda"
                            maxlength="18"
                            minlength="18"
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this);"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>
                </div>

                {{-- Password Input --}}
                <div class="form-group">
                    <div class="label-row">
                        <label for="password">Password <span class="required">*</span></label>
                    </div>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Tampilkan atau sembunyikan password">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Options Row: Remember Me & Forgot Password --}}
                <div class="form-options">
                    <div class="remember-row">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <span class="forgot-link" onclick="alert('Silakan hubungi Administrator Tata Usaha (TU) untuk mereset password Anda.')">
                        Lupa password?
                    </span>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    MASUK
                </button>

                {{-- Divider Portal Lain --}}
                <div class="role-portal-divider">
                    <span>atau akses portal lain</span>
                </div>

                {{-- Tombol Pindah ke Login Orang Tua --}}
                <a href="{{ route('login.orang-tua') }}" class="btn-secondary-role btn-role-ortu">
                    Masuk sebagai Orang Tua
                </a>

                {{-- Tombol Pindah ke Login Guru Piket / Satpam --}}
                <a href="{{ route('login.petugas') }}" class="btn-secondary-role btn-role-petugas">
                    Masuk sebagai Guru Piket / Satpam
                </a>
            </form>

            {{-- Announcement Callout Box --}}
            <div class="announcement-box">
                <div class="announcement-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="announcement-body">
                    <div class="announcement-title">Pengumuman Akun Pengguna</div>
                    <div class="announcement-text">
                        Seluruh pembuatan dan verifikasi akun pengguna dikelola oleh <strong>Administrator Tata Usaha (TU)</strong>. Silakan hubungi pihak TU untuk pendaftaran akun Anda.
                    </div>
                </div>
            </div>

        </div>

        {{-- Security Footer below card --}}
        <div class="security-footer">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Sistem aman & terproteksi. Data Anda dijaga kerahasiannya.</span>
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
            counter.style.color = '#16a34a'; // Green when complete
        } else {
            counter.style.color = '#2563eb'; // Blue default
        }
    }

    function togglePassword() {
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    document.getElementById('loginForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memverifikasi...';
            btn.disabled = true;
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const nipInput = document.getElementById('nip');
        if (nipInput) {
            updateNipCounter(nipInput);
        }
    });
</script>

</body>
</html>
