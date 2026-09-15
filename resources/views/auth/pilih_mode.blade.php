<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Mode Masuk Sistem — EDU JOURNAL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eff6ff;
            --primary-border: #bfdbfe;
            --emerald: #059669;
            --emerald-light: #ecfdf5;
            --emerald-border: #a7f3d0;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.04) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.03) 0px, transparent 50%),
                linear-gradient(to right, rgba(226, 232, 240, 0.45) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.45) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 36px 36px, 36px 36px;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Topbar Header ─── */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.03);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--primary-border);
            flex-shrink: 0;
        }

        .brand-logo {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .brand-text h2 {
            font-size: 16.5px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: -0.02em;
            line-height: 1.15;
        }

        .brand-text span {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.01em;
        }

        .topbar-center-pill {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 9px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
        }

        .topbar-center-pill .pill-divider {
            color: var(--border-hover);
        }

        .topbar-right-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 11px;
            background: #ffffff;
            padding: 4px 10px 4px 4px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
        }

        .user-avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            object-fit: cover;
            border: 1.5px solid #ffffff;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            flex-shrink: 0;
        }

        .user-text-box {
            text-align: right;
            display: flex;
            flex-direction: column;
        }

        .user-text-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-text-role {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            line-height: 1.2;
            margin-top: 1px;
        }

        .btn-logout-icon {
            color: var(--text-muted);
            background: #f8fafc;
            border: 1px solid var(--border-color);
            cursor: pointer;
            font-size: 15px;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout-icon:hover {
            color: #dc2626;
            background: #fee2e2;
            border-color: #fca5a5;
            transform: scale(1.03);
        }

        /* ─── Page Container ─── */
        .page-container {
            max-width: 1080px;
            width: 100%;
            margin: 0 auto;
            padding: 36px 24px 32px 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ─── Header Title Box ─── */
        .header-title-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .badge-system-notice {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid var(--primary-border);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.05);
        }

        .header-title-box h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.03em;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .header-title-box p {
            font-size: 14px;
            color: var(--text-muted);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.55;
            font-weight: 500;
        }

        /* ─── Cards Grid ─── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 26px;
            margin-bottom: 22px;
        }

        .mode-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafcff 100%);
            border: 2px solid #2563eb;
            border-radius: 20px;
            padding: 26px 26px 24px 26px;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 0 6px 22px rgba(37, 99, 235, 0.07);
            cursor: pointer;
        }

        .mode-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 38px rgba(37, 99, 235, 0.14);
            border-color: #1d4ed8;
        }

        .mode-card.card-piket-active {
            border: 2px solid #2563eb;
            box-shadow: 0 6px 22px rgba(37, 99, 235, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #fafcff 100%);
        }

        .mode-card.card-piket-active:hover {
            border-color: #1d4ed8;
            box-shadow: 0 16px 38px rgba(37, 99, 235, 0.16);
        }

        .card-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-pill-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4.5px 11px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-blue {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
        }

        .badge-green {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid var(--emerald-border);
        }

        .badge-active-now {
            font-size: 11px;
            font-weight: 800;
            color: #059669;
            background: #d1fae5;
            padding: 3.5px 9px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                box-shadow: 0 0 0 7px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .label-workspace {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-light);
            background: #f1f5f9;
            padding: 3.5px 9px;
            border-radius: 6px;
        }

        .card-identity {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 16px;
        }

        .card-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }

        .icon-blue-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
        }

        .icon-green-box {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #059669;
            border: 1.5px solid #a7f3d0;
        }

        .card-title-group h3 {
            font-size: 19px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 3px;
        }

        .card-title-group p {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
            line-height: 1.4;
        }

        /* ─── Context Info Chips ─── */
        .context-chips-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 16px;
            padding: 9px 11px;
            background: #f8fafc;
            border: 1px dashed var(--border-color);
            border-radius: 10px;
        }

        .context-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-secondary);
            background: #ffffff;
            border: 1px solid var(--border-color);
            padding: 3px 8px;
            border-radius: 6px;
        }

        .context-chip i {
            color: var(--primary);
            font-size: 11px;
        }

        .context-chip.chip-green i {
            color: var(--emerald);
        }

        .card-features-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 22px;
            flex: 1;
        }

        .card-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12.8px;
            color: var(--text-secondary);
            font-weight: 600;
            line-height: 1.42;
        }

        .card-features-list li i {
            font-size: 13.5px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .icon-check-blue {
            color: #2563eb;
        }

        .icon-check-green {
            color: #059669;
        }

        /* ─── Action Buttons ─── */
        .btn-mode-select {
            width: 100%;
            padding: 13.5px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            border: 1px solid #1d4ed8;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: inherit;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.22);
        }

        .btn-mode-select:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            transform: translateY(-1.5px);
            color: #ffffff;
        }

        .btn-mode-guru,
        .btn-mode-piket {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: 1px solid #1d4ed8;
        }

        .mode-card.card-piket-active .btn-mode-piket {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: 1px solid #1d4ed8;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.22);
        }

        .mode-card.card-piket-active .btn-mode-piket:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            transform: translateY(-1.5px);
            color: #ffffff;
        }

        /* ─── Co-Officers Team Accordion Preview ─── */
        .co-officers-box {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            flex-wrap: wrap;
        }

        .co-officers-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .co-officers-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .co-officers-text {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
        }

        .co-officers-names {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
            line-height: 1.4;
        }

        .co-officers-avatars {
            display: flex;
            align-items: center;
        }

        .co-officer-pill {
            font-size: 11px;
            font-weight: 700;
            background: #ecfdf5;
            color: #047857;
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid var(--emerald-border);
            white-space: nowrap;
        }

        /* ─── Bottom Info & Preferences Card ─── */
        .bottom-card-info {
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 18px 24px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }

        .checkbox-row input[type="checkbox"] {
            width: 17px;
            height: 17px;
            accent-color: var(--primary);
            cursor: pointer;
            border-radius: 4px;
        }

        .tip-navigation {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
            line-height: 1.45;
            padding-top: 6px;
            border-top: 1px dashed var(--border-color);
        }

        .tip-navigation i {
            color: var(--primary);
            font-size: 14px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* ─── Footer ─── */
        .page-footer {
            text-align: center;
            padding: 20px 16px;
            font-size: 11.5px;
            color: var(--text-light);
            font-weight: 600;
            margin-top: auto;
        }

        @media (max-width: 820px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
            .topbar {
                padding: 12px 16px;
                flex-wrap: wrap;
            }
            .topbar-center-pill {
                order: 3;
                width: 100%;
                justify-content: center;
                margin-top: 4px;
            }
            .page-container {
                padding: 20px 14px;
            }
            .header-title-box h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <!-- Topbar Header -->
    <header class="topbar">
        <div class="brand-section">
            <div class="brand-logo-box">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="Logo EDU JOURNAL" class="brand-logo" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-graduation-cap\' style=\'font-size:20px; color:#2563eb;\'></i>';">
            </div>
            <div class="brand-text">
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi &amp; Manajemen Pembelajaran</span>
            </div>
        </div>

        <div class="topbar-center-pill">
            <i class="fa-regular fa-calendar-days" style="color:#2563eb;"></i>
            <span>{{ $tanggalStr }}</span>
            <span class="pill-divider">|</span>
            <i class="fa-solid fa-graduation-cap" style="color:#64748b; font-size:11px;"></i>
            <span>T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} {{ $activeTahunAjaran->semester ?? 'Ganjil' }}</span>
        </div>

        <div class="topbar-right-user">
            <div class="user-profile-badge">
                @if($guruUser->foto && file_exists(public_path('uploads/profile_photos/' . $guruUser->foto)))
                    <img src="{{ asset('uploads/profile_photos/' . $guruUser->foto) }}" alt="Foto Profil" class="user-avatar-circle">
                @else
                    <div class="user-avatar-circle">
                        {{ strtoupper(substr($guruUser->name, 0, 2)) }}
                    </div>
                @endif
                <div class="user-text-box">
                    <div class="user-text-name">{{ $guruUser->name }}</div>
                    <div class="user-text-role">
                        @if($isWaliKelas && $namaKelasWali)
                            Wali Kelas {{ $namaKelasWali }}
                        @else
                            {{ $guruUser->role_label }}
                        @endif
                        &bull; NIP. {{ $guruUser->nip ?? '-' }}
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout-icon" title="Keluar dari Akun (Logout)">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container Content -->
    <main class="page-container">
        
        <!-- Header Page Title -->
        <div class="header-title-box">
            <h1>Pilih Mode Masuk Sistem</h1>
            <p>
                Sistem mendeteksi Anda memiliki tugas pengajaran sekaligus ditugaskan sebagai <strong>Guru Piket Sekolah</strong> oleh Waka Kurikulum hari ini. Silakan pilih ruang kerja yang ingin Anda akses terlebih dahulu.
            </p>
        </div>

        <!-- 2 Mode Cards Grid -->
        <div class="cards-grid">
            
            <!-- Card 1: Guru Mengajar & Wali -->
            <div class="mode-card" onclick="document.getElementById('formModeGuru').submit()">
                <div class="card-top-row">
                    <span class="badge-pill-soft badge-blue">
                        <i class="fa-solid fa-circle" style="font-size:6.5px;"></i> Tugas Pokok &amp; Mengajar
                    </span>
                    <span class="label-workspace">Ruang Kerja Utama</span>
                </div>

                <div class="card-identity">
                    <div class="card-icon-box icon-blue-box">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div class="card-title-group">
                        <h3>Guru Mengajar &amp; Wali</h3>
                        <p>Mode Pengajaran Akademik, Jurnal KBM &amp; Administrasi Kelas</p>
                    </div>
                </div>

                <!-- Context Chips -->
                <div class="context-chips-row">
                    <div class="context-chip" title="Mata Pelajaran yang Diampu">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <span>{{ $namaMapel ?? 'Mata Pelajaran' }}</span>
                    </div>
                    @if($isWaliKelas && $namaKelasWali)
                    <div class="context-chip" title="Perwalian Kelas">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Wali: {{ $namaKelasWali }}</span>
                    </div>
                    @endif
                    <div class="context-chip" title="Jadwal Mengajar Hari Ini">
                        <i class="fa-regular fa-clock"></i>
                        <span>
                            @if(isset($totalKelasHariIni) && $totalKelasHariIni > 0)
                                {{ $totalKelasHariIni }} Kelas ({{ $totalJpHariIni }} JP) Hari Ini
                            @else
                                Tidak Ada Jam KBM Hari Ini
                            @endif
                        </span>
                    </div>
                </div>

                <ul class="card-features-list">
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-blue"></i>
                        <span>Kelola Jurnal Harian KBM, materi pokok &amp; presensi siswa per jam</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-blue"></i>
                        <span>Rekapitulasi perwalian kelas, absensi berkala &amp; catatan khusus siswa</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-blue"></i>
                        <span>Agenda asesmen, capaian materi &amp; input evaluasi penilaian</span>
                    </li>
                </ul>

                <form action="{{ route('auth.switch-mode') }}" method="POST" id="formModeGuru" onclick="event.stopPropagation()">
                    @csrf
                    <input type="hidden" name="mode" value="guru">
                    <input type="hidden" name="remember" class="inputRememberMirror" value="0">
                    <button type="submit" class="btn-mode-select btn-mode-guru">
                        <span>Masuk sebagai Guru Mengajar</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Card 2: Guru Piket Sekolah (Aktif Hari Ini) -->
            <div class="mode-card card-piket-active" onclick="document.getElementById('formModePiket').submit()">
                <div class="card-top-row">
                    <span class="badge-pill-soft badge-green">
                        <i class="fa-solid fa-circle" style="font-size:6.5px;"></i> {{ $slotInfo['badge_text'] ?? 'Terjadwal Hari Ini' }}
                    </span>
                    <span class="badge-active-now">
                        <span class="pulse-dot"></span>
                        <span>Aktif Sekarang</span>
                    </span>
                </div>

                <div class="card-identity">
                    <div class="card-icon-box icon-green-box">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="card-title-group">
                        <h3>Guru Piket Sekolah</h3>
                        <p>Penegakan Ketertiban, Inval Kelas &amp; Operasional Harian</p>
                    </div>
                </div>

                <!-- Context Chips -->
                <div class="context-chips-row">
                    <div class="context-chip chip-green" title="Slot Penugasan Piket">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>{{ $slotInfo['slot_label'] ?? 'Piket' }} (Slot {{ $slotInfo['slot_ke'] ?? 1 }})</span>
                    </div>
                    <div class="context-chip chip-green" title="Sesi Waktu">
                        <i class="fa-regular fa-clock"></i>
                        <span>Sesi {{ $slotInfo['sesi'] ?? 'Pagi' }}: {{ $slotInfo['waktu_label'] ?? '07.00 - 15.00 WIB' }}</span>
                    </div>
                    <div class="context-chip chip-green" title="Total Petugas Piket Hari Ini">
                        <i class="fa-solid fa-users"></i>
                        <span>{{ $totalPetugasPiket ?? 1 }} Petugas Terjadwal</span>
                    </div>
                </div>

                <ul class="card-features-list">
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-green"></i>
                        <span>Monitoring pengisian jurnal KBM harian seluruh kelas secara real-time</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-green"></i>
                        <span>Pencatatan izin siswa, dispensasi, izin guru &amp; plot guru pengganti (inval)</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check-green"></i>
                        <span>Buku tamu sekolah, keterlambatan siswa &amp; catatan kejadian khusus</span>
                    </li>
                </ul>

                <form action="{{ route('auth.switch-mode') }}" method="POST" id="formModePiket" onclick="event.stopPropagation()">
                    @csrf
                    <input type="hidden" name="mode" value="piket">
                    <input type="hidden" name="remember" class="inputRememberMirror" value="0">
                    <button type="submit" class="btn-mode-select btn-mode-piket">
                        <span>Masuk sebagai Guru Piket</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>

        <!-- Rekan Petugas Piket Info Box (Jika Ada) -->
        @if(isset($rekanPiketHariIni) && $rekanPiketHariIni->count() > 0)
        <div class="co-officers-box">
            <div class="co-officers-left">
                <div class="co-officers-icon">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div>
                    <div class="co-officers-text">Tim Rekan Piket Hari Ini ({{ $rekanPiketHariIni->count() }} Guru Lainnya Bertugas Bersama)</div>
                    <div class="co-officers-names">
                        @foreach($rekanPiketHariIni as $r)
                            <strong>{{ $r->guru->nama_guru ?? 'Guru' }}</strong> ({{ $r->slot_ke <= 4 ? 'Pagi - Slot ' . $r->slot_ke : 'Siang - Slot ' . $r->slot_ke }})@if(!$loop->last), @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="co-officers-avatars">
                <span class="co-officer-pill">
                    <i class="fa-solid fa-check-double" style="color:#059669; margin-right:4px;"></i> Terjadwal Waka Kurikulum
                </span>
            </div>
        </div>
        @endif

        <!-- Bottom Tip & Preferences -->
        <div class="bottom-card-info">
            <label class="checkbox-row" for="cbRemember">
                <input type="checkbox" id="cbRemember" onchange="toggleRemember(this)">
                <span>Ingat preferensi saya untuk sesi hari ini <span style="font-weight:500; color:#64748b;">(dapat dialihkan kapan saja via sakelar peran di dashboard)</span></span>
            </label>

            <div class="tip-navigation">
                <i class="fa-solid fa-circle-info"></i>
                <span><strong>Kemudahan Sakelar Peran:</strong> Anda tidak perlu <em>logout</em> untuk berganti peran. Gunakan tombol sakelar peran instan di bagian atas header dashboard untuk berpindah antara ruang kerja <strong>Guru Mengajar</strong> dan <strong>Guru Piket</strong> kapan pun dibutuhkan.</span>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="page-footer">
        &copy; {{ date('Y') }} EDU JOURNAL &bull; Sistem Informasi Presensi &amp; Manajemen Pembelajaran Digital
    </footer>

    <script>
        function toggleRemember(cb) {
            const val = cb.checked ? '1' : '0';
            document.querySelectorAll('.inputRememberMirror').forEach(inp => {
                inp.value = val;
            });
        }
    </script>
</body>
</html>
