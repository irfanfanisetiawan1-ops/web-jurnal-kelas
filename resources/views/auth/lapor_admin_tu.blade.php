<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Admin TU — EDU JOURNAL</title>
    <meta name="description" content="Layanan Pengaduan & Bantuan Akun Administrator Tata Usaha (TU) EDU JOURNAL.">
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
            --primary-subtle:#dbeafe;
            --text-dark:     #0f172a;
            --text-body:     #334155;
            --text-muted:    #64748b;
            --text-label:    #1e293b;
            --bg-page:       #f8fafc;
            --bg-card:       #ffffff;
            --border-color:  #e2e8f0;
            --input-bg:      #ffffff;
            --card-shadow:   0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.03);
        }

        html, body {
            min-height: 100%;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-body);
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #eff6ff 100%);
            position: relative;
        }

        /* Top Header Navbar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .brand-text h1 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .btn-header-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: #ffffff;
            color: var(--text-body);
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
        }

        .btn-header-back:hover {
            background: #f1f5f9;
            color: var(--primary);
            border-color: #93c5fd;
        }

        /* Main Container */
        .main-container {
            max-width: 900px;
            width: 100%;
            margin: 24px auto 40px;
            padding: 0 18px;
            flex: 1;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 18px;
            padding: 22px 26px;
            color: #ffffff;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -8px rgba(15, 23, 42, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.35) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-text {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(37, 99, 235, 0.25);
            border: 1px solid rgba(147, 197, 253, 0.3);
            color: #bfdbfe;
            padding: 3px 10px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.03em;
        }

        .hero-title {
            font-size: 21px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.4;
            max-width: 600px;
        }

        .hero-icon-box {
            position: relative;
            z-index: 2;
            width: 58px;
            height: 58px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #60a5fa;
            flex-shrink: 0;
        }

        /* Nav Tabs Switcher */
        .tab-switcher {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #e2e8f0;
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .tab-btn {
            flex: 1;
            padding: 9px 14px;
            border-radius: 9px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-family: inherit;
        }

        .tab-btn.active {
            background: #ffffff;
            color: var(--primary);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* Form Card */
        .card-panel {
            background: var(--bg-card);
            border-radius: 18px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            padding: 28px 30px;
            position: relative;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-number {
            width: 26px;
            height: 26px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12.5px;
            font-weight: 800;
        }

        .section-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 18px;
            margin-bottom: 20px;
        }

        .col-full {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-label);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-label .req {
            color: #ef4444;
            margin-left: 2px;
        }

        .form-label .optional {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 13.5px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control {
            width: 100%;
            height: 44px;
            padding: 9px 14px 9px 40px;
            background: var(--input-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 11px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-select {
            width: 100%;
            height: 44px;
            padding: 9px 14px 9px 40px;
            background: var(--input-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 11px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-select:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-textarea {
            width: 100%;
            min-height: 110px;
            padding: 11px 14px;
            background: var(--input-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 11px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
            resize: vertical;
            line-height: 1.45;
            transition: all 0.2s ease;
        }

        .form-textarea:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-helper {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            display: flex;
            justify-content: space-between;
        }

        /* 9 Roles Grid */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px;
            margin-top: 4px;
        }

        .role-radio-item input[type="radio"] {
            display: none;
        }

        .role-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1.5px solid var(--border-color);
            border-radius: 11px;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .role-card:hover {
            border-color: #93c5fd;
            background: #ffffff;
        }

        .role-radio-item input[type="radio"]:checked + .role-card {
            border-color: var(--primary);
            background: var(--primary-light);
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
        }

        .role-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12.5px;
            color: var(--text-label);
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .role-radio-item input[type="radio"]:checked + .role-card .role-icon {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .role-title {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-label);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .role-radio-item input[type="radio"]:checked + .role-card .role-title {
            color: var(--primary);
            font-weight: 800;
        }

        /* File Upload Box & Preview */
        .file-dropzone {
            border: 2px dashed #cbd5e1;
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .file-dropzone:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .file-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .dropzone-icon {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .dropzone-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .dropzone-subtitle {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .file-selected-card {
            display: none;
            margin-top: 12px;
            background: #ffffff;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 10px 14px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .file-info-left {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .file-thumb-preview {
            width: 38px;
            height: 38px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            display: none;
        }

        .file-name-text {
            font-size: 12.5px;
            font-weight: 700;
            color: #065f46;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Action Buttons */
        .form-action-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 14px;
        }

        .btn-submit-report {
            flex: 2;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px -2px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-submit-report:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -3px rgba(37, 99, 235, 0.45);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }

        .btn-submit-report:active {
            transform: translateY(0);
        }

        .btn-reset-form {
            flex: 1;
            height: 48px;
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-reset-form:hover {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .btn-reset-form:active {
            background: #cbd5e1;
        }

        /* Alert Feedback */
        .alert-box {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 16px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Check Status Panel */
        .check-status-panel {
            display: none;
        }

        .check-search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .check-search-input {
            flex: 1;
            height: 44px;
            padding: 8px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            outline: none;
        }

        .check-search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .check-search-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search-status {
            padding: 0 20px;
            height: 44px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-search-status:hover {
            background: var(--primary-hover);
        }

        .btn-reset-status {
            padding: 0 16px;
            height: 44px;
            background: #f1f5f9;
            color: #475569;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-reset-status:hover {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .status-result-card {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 18px;
            margin-top: 14px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-progress { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
        .status-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: var(--text-muted);
        }

        @media (max-width: 820px) {
            .role-grid { grid-template-columns: repeat(2, 1fr); }
            .form-grid { grid-template-columns: 1fr; }
            .card-panel { padding: 22px 18px; }
            .hero-icon-box { display: none; }
            .check-search-box { flex-direction: column; }
            .check-search-actions { width: 100%; }
            .btn-search-status, .btn-reset-status { flex: 1; justify-content: center; }
        }

        @media (max-width: 540px) {
            .role-grid { grid-template-columns: 1fr; }
            .form-action-row { flex-direction: column-reverse; }
            .btn-submit-report, .btn-reset-form { width: 100%; flex: unset; }
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <header class="top-navbar">
        <a href="{{ route('login') }}" class="brand-group">
            <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="Logo EDU JOURNAL" class="brand-logo">
            <div class="brand-text">
                <h1>EDU JOURNAL</h1>
                <span>Layanan Lapor Admin TU</span>
            </div>
        </a>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-header-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Login</span>
            </a>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Hero Banner (Singkat & Ringkas) -->
        <div class="hero-banner">
            <div class="hero-text">
                <div class="hero-badge">
                    <i class="fa-solid fa-headset"></i> Layanan Bantuan Akun & Sistem
                </div>
                <h2 class="hero-title">Lapor Administrator Tata Usaha</h2>
                <p class="hero-subtitle">
                    Sampaikan permohonan akun baru, lupa kata sandi, atau kendala sistem. Laporan Anda akan ditindaklanjuti oleh Administrator TU sekolah.
                </p>
            </div>
            <div class="hero-icon-box">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>

        <!-- Tab Switcher -->
        <div class="tab-switcher">
            <button type="button" class="tab-btn active" id="tabFormBtn" onclick="switchTab('form')">
                <i class="fa-solid fa-file-pen"></i>
                <span>Formulir Laporan</span>
            </button>
            <button type="button" class="tab-btn" id="tabStatusBtn" onclick="switchTab('status')">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cek Status Laporan</span>
            </button>
        </div>

        <!-- Alert Error Messages -->
        @if($errors->any())
        <div class="alert-box alert-danger">
            <i class="fa-solid fa-circle-exclamation" style="font-size:16px; margin-top:2px;"></i>
            <div>
                <strong>Periksa kembali isian formulir:</strong>
                <ul style="margin-left: 16px; margin-top: 2px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-box alert-danger">
            <i class="fa-solid fa-circle-exclamation" style="font-size:16px;"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        <!-- Panel 1: Formulir Lapor Admin TU -->
        <div class="card-panel" id="formPanel">
            <form action="{{ route('lapor.admin-tu.store') }}" method="POST" enctype="multipart/form-data" id="laporForm">
                @csrf

                <!-- Bagian 1: Identitas Pelapor -->
                <div class="section-header">
                    <div class="section-number">1</div>
                    <div class="section-title">Identitas Pelapor</div>
                </div>

                <!-- Pilihan 9 Role Pengguna -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">
                        <span>Pilih Peran / Status Anda di Sekolah <span class="req">*</span></span>
                    </label>
                    <div class="role-grid">
                        @php
                            $currentRole = old('role_pelapor', $selectedRole ?: 'guru');
                            $roleIcons = [
                                'guru'            => 'fa-chalkboard-user',
                                'wali_kelas'      => 'fa-id-card-clip',
                                'guru_piket'      => 'fa-clipboard-user',
                                'waka_kesiswaan'  => 'fa-user-graduate',
                                'waka_kurikulum'  => 'fa-book-open-reader',
                                'waka_sdm'        => 'fa-user-tie',
                                'kepala_sekolah'  => 'fa-user-shield',
                                'satpam'          => 'fa-shield-halved',
                                'orang_tua'       => 'fa-users',
                            ];
                        @endphp
                        @foreach($roleList as $key => $label)
                        <label class="role-radio-item">
                            <input type="radio" name="role_pelapor" value="{{ $key }}" {{ $currentRole == $key ? 'checked' : '' }} onchange="onRoleChanged('{{ $key }}')">
                            <div class="role-card">
                                <div class="role-icon">
                                    <i class="fa-solid {{ $roleIcons[$key] ?? 'fa-user' }}"></i>
                                </div>
                                <span class="role-title">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama_pelapor" class="form-label">
                            <span>Nama Lengkap <span class="req">*</span></span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input type="text" id="nama_pelapor" name="nama_pelapor" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('nama_pelapor') }}" required autocomplete="name">
                        </div>
                    </div>

                    <!-- Nomor Identitas (NIP / Username / NISN) -->
                    <div class="form-group">
                        <label for="nomor_identitas" class="form-label">
                            <span id="labelIdentitas">NIP</span>
                            <span class="optional" id="identitasOptionalBadge">(Jika ada)</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-id-badge input-icon" id="identitasIcon"></i>
                            <input type="text" id="nomor_identitas" name="nomor_identitas" class="form-control" placeholder="Contoh: 198507232010011002 (18 digit)" value="{{ old('nomor_identitas') }}" maxlength="18" inputmode="numeric" oninput="onIdentitasInput(this)">
                        </div>
                        <div class="input-helper">
                            <span id="helperIdentitas">Data NIP harus 18 digit angka.</span>
                            <span id="identitasCounter" style="font-weight: 700; color: #64748b;">0/18 digit</span>
                        </div>
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div class="form-group">
                        <label for="no_wa" class="form-label">
                            <span>Nomor WhatsApp Aktif <span class="req">*</span></span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-brands fa-whatsapp input-icon" style="color: #22c55e;"></i>
                            <input type="tel" id="no_wa" name="no_wa" class="form-control" placeholder="Contoh: 081234567890" value="{{ old('no_wa') }}" required autocomplete="tel">
                        </div>
                        <div class="input-helper">
                            <span>Admin TU akan mengonfirmasi atau menindaklanjuti via WA ini.</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <span>Email</span>
                            <span class="optional">(Opsional)</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: nama@email.com" value="{{ old('email') }}" autocomplete="email">
                        </div>
                    </div>
                </div>

                <!-- Bagian 2: Rincian Kendala & Permohonan -->
                <div class="section-header" style="margin-top: 8px;">
                    <div class="section-number">2</div>
                    <div class="section-title">Rincian Kendala</div>
                </div>

                <div class="form-grid">
                    <!-- Kategori Kendala -->
                    <div class="form-group col-full">
                        <label for="kategori_kendala" class="form-label">
                            <span>Kategori Kendala / Masalah <span class="req">*</span></span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-list-check input-icon"></i>
                            <select id="kategori_kendala" name="kategori_kendala" class="form-select" required>
                                <option value="" disabled {{ !old('kategori_kendala', $selectedKategori) ? 'selected' : '' }}>-- Pilih Jenis Kendala --</option>
                                @foreach($kategoriList as $val => $txt)
                                    <option value="{{ $val }}" {{ old('kategori_kendala', $selectedKategori) == $val ? 'selected' : '' }}>
                                        {{ $txt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Judul Laporan -->
                    <div class="form-group col-full">
                        <label for="judul_laporan" class="form-label">
                            <span>Judul Laporan / Subjek <span class="req">*</span></span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-heading input-icon"></i>
                            <input type="text" id="judul_laporan" name="judul_laporan" class="form-control" placeholder="Contoh: Permohonan Akun Guru Baru / Lupa Kata Sandi" value="{{ old('judul_laporan') }}" required>
                        </div>
                    </div>

                    <!-- Keterangan Lengkap -->
                    <div class="form-group col-full">
                        <label for="deskripsi_kendala" class="form-label">
                            <span>Rincian & Keterangan Lengkap <span class="req">*</span></span>
                        </label>
                        <textarea id="deskripsi_kendala" name="deskripsi_kendala" class="form-textarea" placeholder="Jelaskan secara singkat dan jelas kendala atau data akun Anda." required minlength="10" oninput="updateCharCount(this)">{{ old('deskripsi_kendala') }}</textarea>
                        <div class="input-helper">
                            <span>Jelaskan informasi yang dibutuhkan Admin TU.</span>
                            <span id="charCounter">0 / 3000 karakter</span>
                        </div>
                    </div>

                    <!-- Lampiran File / Screenshot -->
                    <div class="form-group col-full">
                        <label class="form-label">
                            <span>Foto Bukti / Tangkapan Layar Kendala</span>
                            <span class="optional">(Opsional, Maks. 5MB)</span>
                        </label>
                        <div class="file-dropzone" onclick="document.getElementById('lampiranInput').click()">
                            <input type="file" id="lampiranInput" name="lampiran" accept="image/*,.pdf,.doc,.docx" onchange="previewSelectedFile(this)">
                            <div class="dropzone-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="dropzone-title">Klik atau seret foto bukti / tangkapan layar di sini</div>
                            <div class="dropzone-subtitle">Mendukung format PNG, JPG, JPEG, WEBP, PDF (Maksimal 5 MB)</div>
                        </div>

                        <!-- Card Preview Bukti Terpilih -->
                        <div class="file-selected-card" id="filePreviewCard">
                            <div class="file-info-left">
                                <img src="#" alt="Preview" class="file-thumb-preview" id="imageThumbPreview">
                                <i class="fa-solid fa-file-lines" id="genericFileIcon" style="font-size:24px; color:#2563eb;"></i>
                                <div>
                                    <div class="file-name-text" id="fileNameText"></div>
                                    <span style="font-size: 11px; color: #16a34a; font-weight:600;"><i class="fa-solid fa-check"></i> Siap diunggah</span>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelectedFile(event)" style="background:transparent; border:none; color:#ef4444; font-size:16px; cursor:pointer;" title="Hapus berkas">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions: Kirim & Reset -->
                <div class="form-action-row">
                    <button type="button" class="btn-reset-form" onclick="resetLaporForm()" title="Kosongkan seluruh isian formulir">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Formulir</span>
                    </button>
                    <button type="submit" class="btn-submit-report" id="btnSubmit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Laporan ke Admin TU</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Panel 2: Cek Status Laporan / Tiket -->
        <div class="card-panel check-status-panel" id="statusPanel">
            <div class="section-header">
                <div class="section-number"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="section-title">Pengecekan Status Laporan</div>
            </div>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                Masukkan <strong>Nomor Tiket</strong> (contoh: <code>LAP-20260915-XXXXX</code>) atau <strong>Nomor WhatsApp</strong> yang Anda gunakan saat melapor.
            </p>

            <div class="check-search-box">
                <input type="text" id="statusSearchInput" class="check-search-input" placeholder="Masukkan Nomor Tiket atau No. WhatsApp Anda..." onkeypress="if(event.key==='Enter'){ searchStatus(); }">
                <div class="check-search-actions">
                    <button type="button" class="btn-search-status" onclick="searchStatus()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari</span>
                    </button>
                    <button type="button" class="btn-reset-status" onclick="resetSearchStatus()" title="Reset pencarian status">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <!-- Tempat Hasil Pencarian AJAX -->
            <div id="statusResultContainer"></div>
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            Pembuatan akun pengguna dikelola oleh <strong>Administrator Tata Usaha</strong> &bull; EDU JOURNAL
        </div>

    </main>

    <script>
        const NIP_ROLES = ['guru', 'wali_kelas', 'waka_kesiswaan', 'waka_kurikulum', 'waka_sdm', 'kepala_sekolah'];
        const USERNAME_ROLES = ['guru_piket', 'satpam'];

        function switchTab(tab) {
            const formPanel = document.getElementById('formPanel');
            const statusPanel = document.getElementById('statusPanel');
            const tabFormBtn = document.getElementById('tabFormBtn');
            const tabStatusBtn = document.getElementById('tabStatusBtn');

            if (tab === 'form') {
                formPanel.style.display = 'block';
                statusPanel.style.display = 'none';
                tabFormBtn.classList.add('active');
                tabStatusBtn.classList.remove('active');
            } else {
                formPanel.style.display = 'none';
                statusPanel.style.display = 'block';
                tabFormBtn.classList.remove('active');
                tabStatusBtn.classList.add('active');
            }
        }

        function getActiveRole() {
            const checked = document.querySelector('input[name="role_pelapor"]:checked');
            return checked ? checked.value : 'guru';
        }

        function onRoleChanged(role) {
            const label = document.getElementById('labelIdentitas');
            const helper = document.getElementById('helperIdentitas');
            const input = document.getElementById('nomor_identitas');
            const counter = document.getElementById('identitasCounter');
            const optBadge = document.getElementById('identitasOptionalBadge');

            if (NIP_ROLES.includes(role)) {
                label.textContent = 'NIP';
                input.placeholder = 'Contoh: 198507232010011002 (18 digit)';
                helper.textContent = 'Data NIP harus 18 digit angka.';
                input.setAttribute('maxlength', '18');
                input.setAttribute('inputmode', 'numeric');
                if (counter) {
                    counter.style.display = 'inline';
                    updateIdentitasCounter(input.value, 18);
                }
            } else if (role === 'orang_tua') {
                label.textContent = 'NISN Putra / Putri Anda';
                input.placeholder = 'Contoh: 0081234567 (10 digit)';
                helper.textContent = 'Data NISN harus 10 digit angka.';
                input.setAttribute('maxlength', '10');
                input.setAttribute('inputmode', 'numeric');
                if (counter) {
                    counter.style.display = 'inline';
                    updateIdentitasCounter(input.value, 10);
                }
            } else if (USERNAME_ROLES.includes(role)) {
                label.textContent = 'Username';
                input.placeholder = 'Contoh: piket1 / satpam_gerbang';
                helper.textContent = 'Masukkan username akun Anda.';
                input.removeAttribute('maxlength');
                input.setAttribute('inputmode', 'text');
                if (counter) {
                    counter.style.display = 'none';
                }
            } else {
                label.textContent = 'Nomor Identitas';
                input.placeholder = 'Nomor identitas resmi';
                helper.textContent = 'Isi dengan nomor identitas Anda.';
                input.removeAttribute('maxlength');
                input.setAttribute('inputmode', 'text');
                if (counter) {
                    counter.style.display = 'none';
                }
            }
        }

        function onIdentitasInput(input) {
            const role = getActiveRole();
            if (NIP_ROLES.includes(role)) {
                input.value = input.value.replace(/[^0-9]/g, '');
                updateIdentitasCounter(input.value, 18);
            } else if (role === 'orang_tua') {
                input.value = input.value.replace(/[^0-9]/g, '');
                updateIdentitasCounter(input.value, 10);
            }
        }

        function updateIdentitasCounter(val, targetLen) {
            const counter = document.getElementById('identitasCounter');
            if (!counter) return;
            const len = (val || '').length;
            counter.textContent = `${len}/${targetLen} digit`;
            if (len === targetLen) {
                counter.style.color = '#16a34a'; // hijau jika tepat
            } else if (len > 0) {
                counter.style.color = '#d97706'; // oranye jika kurang
            } else {
                counter.style.color = '#64748b'; // abu-abu jika kosong
            }
        }

        function updateCharCount(textarea) {
            const counter = document.getElementById('charCounter');
            if (counter) {
                counter.textContent = textarea.value.length + ' / 3000 karakter';
            }
        }

        function previewSelectedFile(input) {
            const card = document.getElementById('filePreviewCard');
            const text = document.getElementById('fileNameText');
            const img = document.getElementById('imageThumbPreview');
            const genericIcon = document.getElementById('genericFileIcon');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                text.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                        genericIcon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    img.style.display = 'none';
                    genericIcon.style.display = 'block';
                }

                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        }

        function clearSelectedFile(e) {
            if (e) e.stopPropagation();
            const input = document.getElementById('lampiranInput');
            if (input) input.value = '';
            const card = document.getElementById('filePreviewCard');
            if (card) card.style.display = 'none';
        }

        function resetLaporForm() {
            const form = document.getElementById('laporForm');
            if (!form) return;

            // Reset seluruh field formulir
            form.reset();

            // Set role kembali ke Guru Mengajar (default)
            const defaultRole = document.querySelector('input[name="role_pelapor"][value="guru"]');
            if (defaultRole) {
                defaultRole.checked = true;
            }

            // Hapus file terpilih & preview
            clearSelectedFile();

            // Reset hitungan karakter textarea
            const desc = document.getElementById('deskripsi_kendala');
            if (desc) updateCharCount(desc);

            // Sinkronkan kembali identitas input ke mode NIP (guru)
            onRoleChanged('guru');
            const identitasInput = document.getElementById('nomor_identitas');
            if (identitasInput) {
                identitasInput.value = '';
                updateIdentitasCounter('', 18);
            }

            // Arahkan fokus ke nama pelapor
            const namaInput = document.getElementById('nama_pelapor');
            if (namaInput) namaInput.focus();
        }

        function resetSearchStatus() {
            const searchInput = document.getElementById('statusSearchInput');
            const resultContainer = document.getElementById('statusResultContainer');

            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
            }
            if (resultContainer) {
                resultContainer.innerHTML = '';
            }
        }

        function searchStatus() {
            const keyword = document.getElementById('statusSearchInput').value.trim();
            const container = document.getElementById('statusResultContainer');

            if (!keyword) {
                alert('Silakan masukkan nomor tiket atau nomor WhatsApp.');
                return;
            }

            container.innerHTML = '<div style="text-align:center; padding:24px; color:#64748b;"><i class="fa-solid fa-spinner fa-spin" style="font-size:22px;"></i><p style="margin-top:6px; font-weight:600; font-size:13px;">Mencari data laporan...</p></div>';

            fetch(`{{ route('lapor.admin-tu.cek-status') }}?keyword=${encodeURIComponent(keyword)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(res => {
                if (!res.data || res.data.length === 0) {
                    container.innerHTML = `
                        <div class="status-result-card" style="text-align:center; padding:24px;">
                            <i class="fa-solid fa-circle-info" style="font-size:28px; color:#94a3b8; margin-bottom:6px;"></i>
                            <h4 style="font-size:14.5px; font-weight:800; color:#0f172a;">Laporan Tidak Ditemukan</h4>
                            <p style="font-size:12.5px; color:#64748b; margin-top:2px;">Tidak ditemukan data dengan kata kunci "<strong>${keyword}</strong>". Pastikan nomor tiket atau nomor WhatsApp sudah tepat.</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div style="display:flex; flex-direction:column; gap:12px; margin-top:8px;">';
                res.data.forEach(item => {
                    html += `
                        <div class="status-result-card">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px; margin-bottom:10px; border-bottom:1px solid #e2e8f0; padding-bottom:8px;">
                                <div>
                                    <span style="font-size:11px; font-weight:800; color:#2563eb; background:#eff6ff; padding:2px 7px; border-radius:5px; font-family:monospace;">${item.ticket_code}</span>
                                    <h4 style="font-size:14px; font-weight:800; color:#0f172a; margin-top:4px;">${item.judul_laporan}</h4>
                                    <span style="font-size:11.5px; color:#64748b; font-weight:600;">Pelapor: ${item.nama_pelapor} (${item.role_label}) &bull; ${item.created_at}</span>
                                </div>
                                <div>${item.status_badge}</div>
                            </div>
                            <div style="font-size:12.5px; color:#334155; margin-bottom:8px;">
                                <strong>Kategori:</strong> ${item.kategori_kendala}
                            </div>
                            ${item.lampiran_url ? `
                                <div style="margin-bottom:8px;">
                                    <a href="${item.lampiran_url}" target="_blank" style="font-size:12px; color:#2563eb; font-weight:700; text-decoration:underline;">
                                        <i class="fa-solid fa-image"></i> Lihat Foto Bukti / Lampiran
                                    </a>
                                </div>
                            ` : ''}
                            ${item.tanggapan_admin ? `
                                <div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:9px; padding:10px 12px; margin-top:8px;">
                                    <div style="font-size:11.5px; font-weight:800; color:#065f46; display:flex; align-items:center; gap:5px; margin-bottom:3px;">
                                        <i class="fa-solid fa-reply"></i> Tanggapan Admin TU:
                                        ${item.responded_at ? `<span style="font-weight:500; font-size:10.5px; color:#047857;">(${item.responded_at})</span>` : ''}
                                    </div>
                                    <div style="font-size:12.5px; color:#064e3b; line-height:1.4;">${item.tanggapan_admin}</div>
                                </div>
                            ` : `
                                <div style="background:#f1f5f9; border-radius:7px; padding:7px 10px; font-size:11.5px; color:#64748b; margin-top:6px;">
                                    <i class="fa-solid fa-clock"></i> Laporan sedang dalam antrean peninjauan Administrator Tata Usaha.
                                </div>
                            `}
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            })
            .catch(err => {
                container.innerHTML = '<div class="alert-box alert-danger">Gagal memuat status laporan. Silakan coba lagi.</div>';
            });
        }

        // Form Submit Validation for 18-digit NIP
        document.getElementById('laporForm').addEventListener('submit', function(e) {
            const role = getActiveRole();
            const identitas = document.getElementById('nomor_identitas').value.trim();

            if (identitas !== '') {
                if (NIP_ROLES.includes(role)) {
                    if (identitas.length !== 18 || !/^[0-9]{18}$/.test(identitas)) {
                        e.preventDefault();
                        alert('Data NIP harus 18 digit angka (saat ini: ' + identitas.length + ' digit). Silakan lengkapi atau periksa kembali.');
                        document.getElementById('nomor_identitas').focus();
                        return false;
                    }
                } else if (role === 'orang_tua') {
                    if (identitas.length !== 10 || !/^[0-9]{10}$/.test(identitas)) {
                        e.preventDefault();
                        alert('Data NISN harus 10 digit angka (saat ini: ' + identitas.length + ' digit). Silakan lengkapi atau periksa kembali.');
                        document.getElementById('nomor_identitas').focus();
                        return false;
                    }
                }
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            const desc = document.getElementById('deskripsi_kendala');
            if (desc) updateCharCount(desc);

            const initialRole = getActiveRole();
            onRoleChanged(initialRole);

            const identitasInput = document.getElementById('nomor_identitas');
            if (identitasInput && identitasInput.value) {
                onIdentitasInput(identitasInput);
            }
        });
    </script>
</body>
</html>

