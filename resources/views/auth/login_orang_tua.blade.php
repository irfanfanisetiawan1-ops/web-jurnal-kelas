<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Orang Tua — EDU JOURNAL</title>
    <meta name="description" content="Portal Akses Presensi & Jurnal Pembelajaran Khusus Orang Tua / Wali Murid EDU JOURNAL.">
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
            padding: 20px 16px;
        }

        /* ── Vector Background Wave Orbs & Edge Accents ── */
        .bg-waves {
            position: fixed;
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

        /* ── Main Container (Didekatkan di Desktop) ── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 980px;
            margin: auto;
            padding: 24px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(32px, 4vw, 56px);
        }

        /* ── Left Column: Text & 3D Artwork (Sedikit ke Kanan) ── */
        .brand-section {
            flex: 1;
            max-width: 470px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-title {
            font-size: clamp(30px, 3vw, 42px);
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
            font-size: clamp(14px, 1.15vw, 15.5px);
            color: #64748b;
            font-weight: 500;
            line-height: 1.55;
            margin-top: 12px;
            margin-bottom: 22px;
        }

        .illustration-container {
            width: 100%;
            max-width: 430px;
            position: relative;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration-img {
            width: 100%;
            max-height: 330px;
            height: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 20px 35px rgba(37, 99, 235, 0.12));
        }

        /* ── Right Column: Login Card (Sedikit ke Kiri) ── */
        .card-section {
            flex-shrink: 0;
            width: 100%;
            max-width: 430px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 26px;
            padding: 32px 30px 26px 30px;
            width: 100%;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.9);
            position: relative;
            transition: transform 0.3s ease;
        }

        .card-head {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-badge {
            width: 86px;
            height: 86px;
            margin: 0 auto 12px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .role-badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12.5px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid #bfdbfe;
        }

        .card-head h2 {
            font-size: 21px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.4px;
            margin-bottom: 5px;
        }

        .card-head p {
            font-size: 13px;
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

        .btn-back-login {
            margin-top: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            height: 46px;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            color: #334155;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-back-login:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        /* Kotak Keterangan TU & Fitur Lapor Admin TU */
        .tu-info-box {
            margin-top: 18px;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .tu-info-text {
            font-size: 12.5px;
            color: #475569;
            font-weight: 600;
            line-height: 1.4;
        }

        .tu-info-text strong {
            color: #1e293b;
        }

        .link-lapor-admin-tu {
            display: inline-block;
            color: #2563eb;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 2px 4px;
        }

        .link-lapor-admin-tu:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* ── Layar Laptop & Desktop Ringkas (Tinggi Terbatas / 1366x768 / Scaling 125%-150%) ── */
        @media (min-width: 993px) and (max-height: 820px) {
            body {
                padding: 10px 14px;
            }

            .login-wrapper {
                padding: 8px 16px;
                gap: 24px;
            }

            .welcome-title {
                font-size: 32px;
                line-height: 1.15;
            }

            .welcome-subtitle {
                font-size: 13.5px;
                margin-top: 6px;
                margin-bottom: 14px;
            }

            .illustration-container {
                max-width: 320px;
            }

            .illustration-img {
                max-height: 220px;
            }

            .card-section {
                max-width: 420px;
            }

            .login-card {
                padding: 18px 24px 16px 24px;
                border-radius: 20px;
            }

            .card-head {
                margin-bottom: 12px;
            }

            .logo-badge {
                width: 62px;
                height: 62px;
                margin-bottom: 6px;
            }

            .role-badge-tag {
                padding: 3px 10px;
                font-size: 11px;
                margin-bottom: 6px;
            }

            .card-head h2 {
                font-size: 18px;
                margin-bottom: 2px;
            }

            .card-head p {
                font-size: 12px;
                line-height: 1.35;
            }

            .alert {
                padding: 8px 12px;
                font-size: 12px;
                margin-bottom: 10px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .form-group label {
                font-size: 12px;
            }

            .char-counter {
                font-size: 11px;
            }

            .form-control {
                padding: 8px 12px 8px 38px;
                font-size: 13px;
                border-radius: 10px;
            }

            .input-icon {
                font-size: 13px;
                left: 12px;
            }

            .form-options {
                margin-top: 2px;
                margin-bottom: 10px;
            }

            .remember-row label, .forgot-link {
                font-size: 12px;
            }

            .btn-submit {
                height: 40px;
                font-size: 13px;
                border-radius: 10px;
            }

            .btn-back-login {
                height: 36px;
                font-size: 12px;
                margin-top: 8px;
                border-radius: 10px;
            }

            .tu-info-box {
                margin-top: 8px;
                padding: 6px 10px;
                gap: 2px;
                border-radius: 10px;
            }

            .tu-info-text {
                font-size: 11px;
            }

            .link-lapor-admin-tu {
                font-size: 11.5px;
            }
        }

        /* ── Laptop Layar Sedang (993px - 1150px) ── */
        @media (min-width: 993px) and (max-width: 1150px) {
            .login-wrapper {
                gap: 32px;
                padding: 20px 16px;
            }
            .brand-section {
                max-width: 440px;
            }
            .card-section {
                max-width: 420px;
            }
            .welcome-title {
                font-size: 34px;
            }
            .illustration-container {
                max-width: 360px;
            }
        }

        /* ── Layar Tablet (Portrait: 641px - 992px) ── */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                justify-content: center;
                gap: 24px;
                padding: 24px 16px;
            }

            .brand-section {
                max-width: 500px;
                width: 100%;
                text-align: center;
                align-items: center;
            }

            .welcome-title {
                font-size: 32px;
                line-height: 1.2;
            }

            .welcome-subtitle {
                font-size: 14.5px;
                margin-top: 6px;
                margin-bottom: 14px;
            }

            .illustration-container {
                max-width: 260px;
                margin: 0 auto;
            }

            .illustration-img {
                max-height: 180px;
            }

            .card-section {
                max-width: 480px;
                width: 100%;
            }

            .login-card {
                padding: 30px 28px 24px;
                border-radius: 24px;
            }
        }

        /* ── Layar Smartphone / HP (Lebar <= 640px) ── */
        @media (max-width: 640px) {
            body {
                padding: 12px 10px;
                align-items: flex-start;
            }

            .login-wrapper {
                padding: 8px 4px;
                gap: 14px;
                width: 100%;
            }

            .brand-section {
                max-width: 100%;
                text-align: center;
                align-items: center;
                padding: 0 4px;
            }

            .welcome-title {
                font-size: 23px;
                line-height: 1.25;
                letter-spacing: -0.5px;
            }

            .welcome-title br {
                display: none;
            }

            .welcome-title .text-dark::after {
                content: ' ';
            }

            .welcome-subtitle {
                font-size: 13px;
                margin-top: 6px;
                margin-bottom: 4px;
                line-height: 1.45;
            }

            .welcome-subtitle br {
                display: none;
            }

            .welcome-subtitle::after {
                content: '';
            }

            /* Di HP, tampilkan ilustrasi 3D laptop/buku/tanaman secara proporsional dan rapi */
            .illustration-container {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                max-width: 210px;
                margin: 4px auto 12px auto;
            }

            .illustration-img {
                width: 100%;
                max-height: 145px;
                height: auto;
                object-fit: contain;
                filter: drop-shadow(0 10px 20px rgba(37, 99, 235, 0.14));
            }

            .card-section {
                width: 100%;
                max-width: 100%;
            }

            .login-card {
                padding: 24px 18px 20px;
                border-radius: 20px;
                box-shadow: 0 12px 35px -10px rgba(37, 99, 235, 0.12), 0 4px 15px -5px rgba(0, 0, 0, 0.04);
            }

            .logo-badge {
                width: 64px;
                height: 64px;
                margin-bottom: 10px;
            }

            .role-badge-tag {
                padding: 4px 12px;
                font-size: 11.5px;
                margin-bottom: 8px;
            }

            .card-head {
                margin-bottom: 16px;
            }

            .card-head h2 {
                font-size: 19px;
                margin-bottom: 4px;
            }

            .card-head p {
                font-size: 12.5px;
            }

            .alert {
                padding: 10px 12px;
                font-size: 12px;
                margin-bottom: 14px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .form-group label {
                font-size: 12.5px;
            }

            .form-control {
                height: 46px;
                padding: 11px 14px 11px 40px;
                font-size: 15px; /* Nyaman dan mencegah auto-zoom di browser HP */
                border-radius: 11px;
            }

            .input-icon {
                left: 13px;
                font-size: 13px;
            }

            .toggle-pass {
                right: 6px;
                min-width: 42px;
                min-height: 42px;
                font-size: 15px;
            }

            .form-options {
                margin-bottom: 16px;
            }

            .remember-row label {
                font-size: 12px;
            }

            .forgot-link {
                font-size: 12px;
            }

            .btn-submit {
                height: 46px;
                font-size: 13.5px;
                border-radius: 11px;
            }

            .btn-back-login {
                height: 42px;
                font-size: 12.5px;
                margin-top: 10px;
                border-radius: 11px;
            }

            .tu-info-box {
                margin-top: 14px;
                padding: 10px 12px;
                border-radius: 11px;
            }

            .tu-info-text {
                font-size: 11.5px;
            }

            .link-lapor-admin-tu {
                font-size: 12px;
            }

            /* Optimasi orbs background untuk performa mulus di HP */
            .bg-gradient-edge-topleft {
                width: 240px;
                height: 240px;
                top: -60px;
                left: -60px;
                filter: blur(30px);
            }

            .bg-gradient-edge-bottomright {
                width: 260px;
                height: 260px;
                bottom: -60px;
                right: -60px;
                filter: blur(35px);
            }

            .dot-pattern-top, .dot-pattern-right, .dot-pattern-left {
                opacity: 0.2;
                transform: scale(0.7);
            }
        }

        /* ── Layar HP Kecil (Lebar <= 380px, misal iPhone SE / Layar Ringkas) ── */
        @media (max-width: 380px) {
            body {
                padding: 8px 4px;
            }

            .login-wrapper {
                padding: 6px 2px;
                gap: 10px;
            }

            .welcome-title {
                font-size: 20px;
            }

            .welcome-subtitle {
                font-size: 12px;
            }

            .illustration-container {
                max-width: 170px;
                margin: 2px auto 8px auto;
            }

            .illustration-img {
                max-height: 110px;
            }

            .login-card {
                padding: 18px 14px 16px;
                border-radius: 16px;
            }

            .logo-badge {
                width: 56px;
                height: 56px;
                margin-bottom: 8px;
            }

            .card-head h2 {
                font-size: 17px;
            }

            .card-head p {
                font-size: 11.5px;
            }

            .form-options {
                flex-wrap: wrap;
                gap: 6px;
            }

            .form-control {
                font-size: 14px;
                padding: 10px 12px 10px 36px;
            }

            .btn-submit {
                height: 44px;
                font-size: 13px;
            }

            .btn-back-login {
                height: 40px;
                font-size: 12px;
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
            <span class="text-blue">Orang Tua / Wali!</span>
        </h1>
        
        <p class="welcome-subtitle">
            Portal pantauan presensi &amp; jurnal pembelajaran<br>anak Anda secara praktis dan real-time.
        </p>

        <div class="illustration-container">
            <img src="{{ asset('images/gambar_laptop_buku_tumbuhan.png') }}" alt="Ilustrasi EDU JOURNAL" class="illustration-img">
        </div>
    </div>

    {{-- ══ Sisi Kanan: Kartu Login Orang Tua ══ --}}
    <div class="card-section">
        <div class="login-card">

            {{-- Head Logo & Titles --}}
            <div class="card-head">
                <div class="logo-badge">
                    <img src="{{ asset('images/logo_jurnal_baru.png') }}" alt="EDU JOURNAL Logo">
                </div>
                <h2>Masuk Akun Orang Tua</h2>
                <p>Masukkan NISN (anak Anda) dan kata sandi<br>untuk mengakses portal presensi.</p>
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

            {{-- Form Login Orang Tua --}}
            <form action="{{ route('login.orang-tua.post') }}" method="POST" id="loginOrangTuaForm">
                @csrf

                {{-- NISN Input --}}
                <div class="form-group">
                    <div class="label-row">
                        <label for="nisn">NISN <span class="required">*</span></label>
                        <span id="nisnCounter" class="char-counter">0/10 digit</span>
                    </div>
                    <div class="input-wrap">
                        <i class="fa-solid fa-id-card input-icon"></i>
                        <input
                            type="text"
                            id="nisn"
                            name="nisn"
                            class="form-control"
                            value="{{ old('nisn') }}"
                            placeholder="Masukkan 10 digit NISN Anda"
                            maxlength="10"
                            minlength="10"
                            pattern="[0-9]{10}"
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateNisnCounter(this);"
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
                            placeholder="Masukkan password akun Orang Tua"
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
                    <span class="forgot-link" onclick="alert('Silakan hubungi Administrator Tata Usaha (TU) sekolah untuk mereset password akun Orang Tua Anda.')">
                        Lupa password?
                    </span>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    MASUK SEBAGAI ORANG TUA
                </button>

                {{-- Link Kembali ke Login Staf / Guru --}}
                <a href="{{ route('login') }}" class="btn-back-login">
                    <i class="fa-solid fa-arrow-left" style="color:#2563eb;"></i>
                    Kembali ke Login Staf / Guru
                </a>
            </form>

            {{-- Keterangan TU & Fitur Lapor Admin TU --}}
            <div class="tu-info-box">
                <div class="tu-info-text">
                    Pembuatan akun pengguna dikelola oleh <strong>Administrator Tata Usaha</strong>
                </div>
                <a href="{{ route('lapor.admin-tu', ['role' => 'orang_tua']) }}" class="link-lapor-admin-tu">
                    Lapor Admin TU
                </a>
            </div>

        </div>
    </div>

</div>

<script>
    function updateNisnCounter(input) {
        const counter = document.getElementById('nisnCounter');
        if (!counter) return;
        const len = input.value.length;
        counter.textContent = len + '/10 digit';
        if (len === 10) {
            counter.style.color = '#16a34a';
        } else {
            counter.style.color = '#2563eb';
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

    document.getElementById('loginOrangTuaForm')?.addEventListener('submit', function (e) {
        const nisn = document.getElementById('nisn').value.trim();
        const password = document.getElementById('password').value.trim();

        if (nisn.length !== 10 || !/^\d{10}$/.test(nisn)) {
            e.preventDefault();
            alert('NISN harus diisi tepat 10 digit angka!');
            return false;
        }

        if (!password) {
            e.preventDefault();
            alert('Password wajib diisi!');
            return false;
        }

        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memverifikasi NISN...';
            btn.disabled = true;
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const nisnInput = document.getElementById('nisn');
        if (nisnInput) {
            updateNisnCounter(nisnInput);
        }
    });
</script>

</body>
</html>
