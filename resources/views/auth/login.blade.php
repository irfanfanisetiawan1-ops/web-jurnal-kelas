<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — JURNAL ESEMKITA</title>
    <meta name="description" content="Sistem Presensi & Jurnal Pembelajaran Digital SMK ESEMKITA — Portal Akses Guru dan Tenaga Kependidikan.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

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
            color: var(--text-main);
            position: relative;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* ── Page Layout ─────────────────────────────────── */
        .login-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
            min-height: 100dvh;
            position: relative;
            z-index: 10;
        }

        /* ── Left Branding Panel ───────────────────────── */
        .brand-panel {
            width: 420px;
            flex-shrink: 0;
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.95));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 44px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .brand-logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            margin-bottom: 24px;
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.4);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 600;
            color: #a5f3fc;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .brand-title {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.8px;
            margin-bottom: 12px;
        }
        .brand-title span {
            background: linear-gradient(135deg, #a5f3fc, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-desc {
            font-size: 14px;
            line-height: 1.6;
            color: #94a3b8;
            font-weight: 400;
            margin-bottom: 28px;
        }

        /* Feature Highlight Cards */
        .feature-cards {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 2;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .feature-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }
        .feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .feature-text {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            font-size: 12px;
            color: #64748b;
        }

        /* ── Right Form Panel ─────────────────────────── */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            position: relative;
            overflow-y: auto;
        }

        /* ── Synchronized Glass Card Container ──────────────────────────── */
        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 32px 32px;
            width: 100%;
            max-width: 440px;
            margin: auto; /* Flexbox margin auto prevents top clipping */
            position: relative;
            z-index: 2;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.5),
                0 0 35px rgba(99, 102, 241, 0.15);
            animation: cardAppear 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            overflow: hidden;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .card-head {
            text-align: center;
            margin-bottom: 22px;
        }

        .card-head .icon-badge {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            color: #ffffff;
            margin-bottom: 12px;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            transition: transform 0.3s ease;
        }

        .login-card:hover .card-head .icon-badge {
            transform: scale(1.05);
        }

        .card-head h2 {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.4px;
            margin-bottom: 6px;
        }
        .card-head p {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
            line-height: 1.45;
        }

        /* ── Alert Styles ─────────────────────────────── */
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
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert i { margin-top: 2px; flex-shrink: 0; font-size: 15px; }
        .alert-danger  { background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; }
        .alert-success { background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); color: #6ee7b7; }

        /* ── Form Inputs ─────────────────────────────── */
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
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
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-control::placeholder { color: #475569; }
        .form-control:focus {
            border-color: var(--input-focus);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        .input-wrap:focus-within .input-icon {
            color: #38bdf8;
        }

        /* Password toggle button */
        .toggle-pass {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            font-size: 14px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
            outline: none;
        }
        .toggle-pass:hover {
            color: #38bdf8;
            background: rgba(99, 102, 241, 0.1);
        }

        /* Remember & Forgot options row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            width: 17px;
            height: 17px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(15, 23, 42, 0.6);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }
        .remember-row input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
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
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 12.5px;
            color: #38bdf8;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
        }
        .forgot-link:hover {
            color: #7dd3fc;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 13.5px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 24px -4px rgba(99, 102, 241, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -2px rgba(99, 102, 241, 0.6);
            background: linear-gradient(135deg, #4f46e5 0%, #0891b2 100%);
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

        /* Registration CTA Box */
        .register-cta-box {
            margin-top: 20px;
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

        .btn-cta-register {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #a5f3fc;
            font-weight: 700;
            text-decoration: none;
            padding: 5px 16px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 100px;
            transition: all 0.2s ease;
        }

        .btn-cta-register:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        /* ── Responsive Viewports ─────────────────────── */
        @media (max-width: 900px) {
            .brand-panel {
                width: 350px;
                padding: 36px 28px;
            }

            .login-card {
                padding: 28px 24px;
            }
        }

        @media (max-width: 820px) {
            .login-wrapper {
                flex-direction: column;
                min-height: 100vh;
            }

            .brand-panel {
                width: 100%;
                padding: 32px 24px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .feature-cards {
                display: none;
            }

            .brand-desc {
                margin-bottom: 0;
            }

            .form-panel {
                padding: 24px 16px;
            }

            .login-card {
                padding: 28px 20px;
                max-width: 100%;
            }
        }

        @media (max-width: 580px) {
            .brand-panel {
                padding: 24px 16px;
            }

            .brand-logo-icon {
                width: 48px;
                height: 48px;
                font-size: 22px;
                border-radius: 14px;
                margin-bottom: 16px;
            }

            .brand-title {
                font-size: 26px;
                margin-bottom: 8px;
            }

            .brand-desc {
                font-size: 12.5px;
            }

            .form-panel {
                padding: 20px 12px;
            }

            .login-card {
                padding: 24px 16px;
                border-radius: 18px;
            }

            .card-head {
                margin-bottom: 18px;
            }

            .card-head .icon-badge {
                width: 48px;
                height: 48px;
                font-size: 20px;
                border-radius: 14px;
                margin-bottom: 10px;
            }

            .card-head h2 {
                font-size: 19px;
            }

            .card-head p {
                font-size: 12.5px;
            }

            .form-control {
                padding: 10.5px 14px 10.5px 38px;
                font-size: 13px;
            }

            .input-icon {
                left: 12px;
                font-size: 13px;
            }

            .btn-submit {
                padding: 12px;
                font-size: 13.5px;
            }
        }
    </style>
</head>
<body>

<div class="bg-glow-1"></div>
<div class="bg-glow-2"></div>

<div class="login-wrapper">

    {{-- ══ Left Panel: Branding & Highlights ══ --}}
    <div class="brand-panel">
        <div class="brand-content">
            <div class="brand-logo-icon">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            
            <div class="brand-badge">
                <i class="fa-solid fa-bolt"></i> Official Portal
            </div>

            <h1 class="brand-title">JURNAL<br><span>ESEMKITA</span></h1>
            
            <p class="brand-desc">
                Sistem Presensi & Management Jurnal Pembelajaran Digital SMK ESEMKITA. Presisi, Akurat, dan Terintegrasi.
            </p>
        </div>

        {{-- Feature Highlights --}}
        <div class="feature-cards">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div class="feature-text">Pencatatan Jurnal Real-time</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="feature-text">Presensi Siswa & Kelas Binaan</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div class="feature-text">Rekapitulasi Laporan Otomatis</div>
            </div>
        </div>

        <div class="brand-footer">
            &copy; {{ date('Y') }} SMK ESEMKITA. All rights reserved.
        </div>
    </div>

    {{-- ══ Right Panel: Form ══ --}}
    <div class="form-panel">
        <div class="login-card">

            {{-- Card Header --}}
            <div class="card-head">
                <div class="icon-badge">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </div>
                <h2>Selamat Datang Kembali</h2>
                <p>Masukkan NIP dan kata sandi Anda untuk mengakses portal</p>
            </div>

            {{-- Alert Messages --}}
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
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP <span style="color:var(--danger)">*</span></label>
                        <span id="nipCounter" style="font-size: 11px; font-weight: 700; color: #94a3b8;">0/18 digit</span>
                    </div>
                    <div class="input-wrap">
                        <i class="fa-solid fa-id-card input-icon"></i>
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
                    <label for="password">Password <span style="color:var(--danger)">*</span></label>
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

                {{-- Options Row --}}
                <div class="form-options">
                    <div class="remember-row">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <span class="forgot-link" onclick="alert('Silakan hubungi Administrator Tata Usaha untuk mereset password Anda.')">
                        Lupa password?
                    </span>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    MASUK
                </button>
            </form>

            {{-- Admin TU Notice Box --}}
            <div class="register-cta-box" style="gap:4px;">
                <span style="font-weight:700; color:#38bdf8; font-size:12.5px;"><i class="fa-solid fa-circle-info" style="margin-right:6px;"></i> Pengumuman Akun Pengguna</span>
                <span style="font-size:11.5px; color:#94a3b8; line-height:1.45; max-width:360px; margin:0 auto; display:block;">
                    Seluruh pembuatan dan verifikasi akun pengguna dikelola oleh <strong>Administrator Tata Usaha (TU)</strong>. Silakan hubungi pihak TU untuk pendaftaran akun Anda.
                </span>
            </div>

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

    // Toggle password visibility
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Submit loading state
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memverifikasi...';
        btn.disabled = true;
    });

    // Numerical-only input for NIP
    document.getElementById('nip').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

</body>
</html>
