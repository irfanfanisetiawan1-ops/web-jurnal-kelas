@extends('layouts.guru')

@section('title', 'Jurnal Harian — EDU JOURNAL')
@section('header_title', 'Jurnal Harian Guru')

@section('styles')
<style>
    /* Top Alert Banner */
    .reminder-banner {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .reminder-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffe4e6;
        color: #e11d48;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .reminder-title {
        font-size: 14px;
        font-weight: 800;
        color: #9f1239;
    }

    .reminder-desc {
        font-size: 12.5px;
        color: #be123c;
        margin-top: 3px;
        line-height: 1.4;
    }

    /* Top Horizontal Scrollable Schedule Cards */
    .section-subtitle-head {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .horizontal-schedule-scroll {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 24px;
    }

    .schedule-card-item {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 16px;
        min-width: 220px;
        flex: 0 0 auto;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }

    .schedule-card-item:hover, .schedule-card-item.selected {
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        transform: translateY(-2px);
    }

    .schedule-card-item.selected {
        background: #eff6ff;
    }

    .schedule-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .schedule-card-meta {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 4px;
    }

    .schedule-card-status {
        margin-top: 10px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-active { color: #16a34a; }
    .status-pending { color: #64748b; }

    /* Bottom Widgets Grid (2 Cards Side-by-Side) */
    .jurnal-bottom-widgets-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 900px) {
        .jurnal-bottom-widgets-grid { grid-template-columns: 1fr; }
    }

    /* Main Form Card - Full Width */
    .form-jurnal-box {
        background: #ffffff;
        border-radius: 20px;
        border: 1.5px solid #cbd5e1;
        padding: 30px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        width: 100%;
        margin-bottom: 30px;
    }

    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }

    .input-field-custom {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: border 0.15s ease;
    }

    .input-field-custom:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Condition Radio Pills */
    .condition-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .condition-pill-label {
        padding: 8px 18px;
        border-radius: 20px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .condition-pill-input { display: none; }

    .condition-pill-input:checked + .condition-pill-label {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
        box-shadow: 0 3px 8px rgba(56, 73, 114, 0.2);
    }

    /* Student Attendance Status Radio Pills */
    .status-radio-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
        border: 1px solid transparent;
    }

    .status-radio-pill input[type="radio"] {
        margin: 0;
        cursor: pointer;
        accent-color: currentColor;
    }

    .status-radio-pill.pill-hadir {
        color: #15803d;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .status-radio-pill.pill-hadir:hover {
        background: #dcfce7;
    }

    .status-radio-pill.pill-sakit {
        color: #1d4ed8;
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .status-radio-pill.pill-sakit:hover {
        background: #dbeafe;
    }

    .status-radio-pill.pill-izin {
        color: #b45309;
        background: #fffbeb;
        border-color: #fde68a;
    }
    .status-radio-pill.pill-izin:hover {
        background: #fef3c7;
    }

    .status-radio-pill.pill-alpa {
        color: #b91c1c;
        background: #fef2f2;
        border-color: #fecaca;
    }
    .status-radio-pill.pill-alpa:hover {
        background: #fee2e2;
    }

    .status-radio-pill.pill-dispen {
        color: #7e22ce;
        background: #faf5ff;
        border-color: #e9d5ff;
    }
    .status-radio-pill.pill-dispen.locked {
        cursor: not-allowed;
    }

    /* Buttons */
    .form-actions-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-draft {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-submit-jurnal {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(56, 73, 114, 0.25);
    }

    .bottom-info-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 12.5px;
        font-weight: 700;
        padding: 12px 18px;
        border-radius: 10px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Readonly Schedule Info Grid (TU Master Data Connected) */
    .schedule-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 14px;
    }

    @media (max-width: 900px) {
        .schedule-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 520px) {
        .schedule-info-grid {
            grid-template-columns: 1fr;
        }
    }

    .input-readonly-field {
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        background: #e2e8f0;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        font-family: inherit;
        outline: none;
        cursor: not-allowed;
        box-sizing: border-box;
        transition: border 0.15s ease;
    }

    .input-readonly-wrapper {
        position: relative;
        width: 100%;
    }

    .input-readonly-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #0f172a;
        pointer-events: none;
        font-size: 15px;
    }

    /* Live Camera & Photo Upload Styling */
    .camera-upload-container {
        margin-top: 18px;
        margin-bottom: 20px;
    }

    .camera-box-placeholder {
        background: #e2e8f0;
        border: 2px dashed #94a3b8;
        border-radius: 16px;
        padding: 36px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 180px;
    }

    .camera-box-placeholder:hover {
        background: #cbd5e1;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12);
    }

    .camera-icon-circle {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: #ffffff;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .camera-box-placeholder:hover .camera-icon-circle {
        transform: scale(1.08);
        color: #2563eb;
    }

    .camera-viewfinder-wrapper {
        background: #0f172a;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        border: 2px solid #334155;
    }

    .camera-video-stream {
        width: 100%;
        max-height: 380px;
        display: block;
        object-fit: cover;
        background: #000000;
        transform: scaleX(1); /* will flip if user front camera */
    }

    .camera-live-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(225, 29, 72, 0.9);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ffffff;
        animation: blink 1s infinite alternate;
    }

    @keyframes blink {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0.3; transform: scale(0.8); }
    }

    .camera-controls-bar {
        position: absolute;
        bottom: 14px;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 0 16px;
        z-index: 5;
    }

    .btn-snap-photo {
        background: #2563eb;
        color: #ffffff;
        border: 4px solid rgba(255, 255, 255, 0.85);
        border-radius: 50px;
        padding: 12px 28px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 18px rgba(37, 99, 235, 0.6);
        transition: transform 0.15s ease, background 0.15s ease;
    }

    .btn-snap-photo:hover {
        background: #1d4ed8;
        transform: scale(1.05);
    }

    .btn-snap-photo:active {
        transform: scale(0.95);
    }

    .btn-camera-opt {
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        backdrop-filter: blur(6px);
        transition: all 0.15s ease;
    }

    .btn-camera-opt:hover {
        background: rgba(15, 23, 42, 0.95);
        transform: scale(1.08);
    }

    .camera-preview-container {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .camera-preview-img-wrapper {
        position: relative;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        background: #0f172a;
        text-align: center;
    }

    .camera-preview-img {
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        display: block;
    }

    .camera-preview-meta {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(4px);
    }

    .shutter-flash {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ffffff;
        opacity: 0;
        pointer-events: none;
        z-index: 10;
        transition: opacity 0.1s ease-out;
    }

    .shutter-flash.active {
        opacity: 0.9;
    }

    /* Right Widgets */
    .widget-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .history-item:last-child { border-bottom: none; }

    .history-class {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .history-date {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .badge-history-terisi {
        background: #84a98c;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .badge-history-belum {
        background: #cb997e;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .progress-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .progress-row:last-child { border-bottom: none; }

    .progress-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .progress-val {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }
</style>
@endsection

@section('content')

    <div style="margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
            Jurnal Harian
        </h1>
        <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
            Isi dan kelola jurnal harian Anda
        </p>
    </div>

    <!-- Alert Box: Pengingat Otomatis -->
    <div class="reminder-banner">
        <div class="reminder-icon">
            <i class="fa-solid fa-bell"></i>
        </div>
        <div>
            <div class="reminder-title">Pengingat Otomatis Sistem Jurnal Mengajar</div>
            <div class="reminder-desc">
                Jurnal hanya dapat diisi saat jam pelajaran berlangsung. Jika 5 menit sebelum jam mengajar berakhir jurnal belum diisi, pengingat otomatis akan ditampilkan pada layar Anda.
            </div>
        </div>
    </div>

    @php
        $urgentJadwal = ($selectedJadwal && $selectedJadwal->hampir_habis) ? $selectedJadwal : $jadwalsHariIni->first(fn($j) => $j->hampir_habis);
    @endphp

    @if($urgentJadwal && $urgentJadwal->hampir_habis)
        <div id="urgentReminderAlertBox" data-end-time="{{ $urgentJadwal->waktu_selesai_effective }}" style="background: #fff7ed; border: 2px solid #ea580c; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 6px 20px rgba(234, 88, 12, 0.2); transition: all 0.4s ease;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; animation: pulse 1.5s infinite;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 800; color: #9a3412;">Peringatan 5 Menit Terakhir!</div>
                    <div style="font-size: 13.5px; color: #c2410c; margin-top: 2px;">
                        Jam pelajaran <strong>{{ $urgentJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $urgentJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong><span id="urgentSisaMenitText">{{ $urgentJadwal->sisa_menit_selesai <= 1 ? 'kurang dari 1' : (int)$urgentJadwal->sisa_menit_selesai }}</span> menit lagi</strong> sebelum jam berakhir (Pukul {{ $urgentJadwal->waktu_selesai_effective }} WIB). Mohon segera lengkapi dan simpan Jurnal Mengajar Anda!
                    </div>
                </div>
            </div>
            @if($selectedJadwal && $selectedJadwal->id_jadwal != $urgentJadwal->id_jadwal)
                <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $urgentJadwal->id_jadwal]) }}" style="background: #ea580c; color: #ffffff; font-weight: 800; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-size: 12.5px; white-space: nowrap; box-shadow: 0 2px 8px rgba(234,88,12,0.3); display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Jadwal Ini
                </a>
            @endif
        </div>
        <style>
            @keyframes pulse {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0.4); }
                70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(234, 88, 12, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(234, 88, 12, 0); }
            }
        </style>
    @endif

    <!-- Horizontal Scroll: Jadwal Mengajar Hari Ini -->
    <div class="section-subtitle-head">Jadwal Mengajar Hari Ini</div>
    <div class="horizontal-schedule-scroll">
        @forelse($jadwalsHariIni as $j)
            @php
                $isSelected = ($selectedJadwal && $selectedJadwal->id_jadwal == $j->id_jadwal);
                $isDiisi = $j->isDiisiHariIni();
                $isBerlangsung = $j->is_sedang_berlangsung;
                $isHampir = $isBerlangsung && $j->hampir_habis;
                $isSelesai = $j->is_jam_sudah_selesai;
            @endphp
            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) }}" class="schedule-card-item {{ $isSelected ? 'selected' : '' }}">
                <div class="schedule-card-title">
                    {{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }} {{ $j->kelas->nama_kelas ?? '' }}
                    @if(!empty($j->is_guru_pengganti))
                        <span style="display: inline-block; font-size: 10px; font-weight: 800; background: #fef3c7; color: #b45309; padding: 2px 6px; border-radius: 6px; margin-left: 4px; border: 1px solid #fde68a;">
                            <i class="fa-solid fa-user-clock"></i> Pengganti
                        </span>
                    @endif
                </div>
                <div class="schedule-card-meta">
                    {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} · {{ $j->ruangan->nama_ruangan ?? 'Ruang 57' }}
                </div>
                <div class="schedule-card-status">
                    @if($isDiisi)
                        <span style="color: #16a34a; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Sudah Diisi</span>
                    @elseif($isHampir)
                        <span style="color: #dc2626; font-weight: 800; animation: pulse 1.5s infinite;"><i class="fa-solid fa-triangle-exclamation"></i> Segera Isi (Sisa {{ $j->sisa_menit_selesai }}m)</span>
                    @elseif($isBerlangsung)
                        <span style="color: #2563eb; font-weight: 700;"><i class="fa-solid fa-circle" style="font-size: 8px;"></i> Sedang Berlangsung</span>
                    @elseif($isSelesai)
                        <span style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-ban"></i> Waktu Habis</span>
                    @else
                        <span style="color: #64748b;"><i class="fa-regular fa-clock"></i> Belum Mulai</span>
                    @endif
                </div>
            </a>
        @empty
            <div style="font-size: 13px; color: #94a3b8;">Tidak ada jadwal mengajar hari ini.</div>
        @endforelse
    </div>

    <!-- Main Full-Width Form Card: Isi Jurnal Mengajar -->
    <div class="form-jurnal-box">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <span><i class="fa-solid fa-file-pen" style="color: #2563eb; margin-right: 8px;"></i> Isi Jurnal Mengajar: {{ $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</span>
            @if(isset($existingJurnal) && $existingJurnal)
                <span style="font-size: 11.5px; background: {{ $existingJurnal->is_draft ? '#e0f2fe' : '#dcfce7' }}; color: {{ $existingJurnal->is_draft ? '#0369a1' : '#15803d' }}; padding: 4px 12px; border-radius: 20px; font-weight: 800;">
                    {{ $existingJurnal->is_draft ? 'DRAFT TERSIMPAN' : 'JURNAL TERISI' }}
                </span>
            @endif
        </h2>

            @php
                $user = Auth::user();
                $isGuruPengganti = !empty($selectedJadwal->is_guru_pengganti);
                $isAdminPiket = ($user && ($user->isAdmin() || $user->isGuruPiket() || $isGuruPengganti));
                $isSubmittedFinal = (isset($existingJurnal) && $existingJurnal && !$existingJurnal->is_draft);
                $isDraft = (isset($existingJurnal) && $existingJurnal && $existingJurnal->is_draft);
                $isJamSelesai = $selectedJadwal ? $selectedJadwal->is_jam_sudah_selesai : false;
                $isJamStarted = $selectedJadwal ? $selectedJadwal->sudah_masuk_jam : false;
                $isSedangBerlangsung = $selectedJadwal ? $selectedJadwal->is_sedang_berlangsung : false;
                $isHampirHabis = $selectedJadwal ? $selectedJadwal->hampir_habis : false;

                // Inputs and actions can ONLY be modified when lesson is actively ongoing, or by Admin/Piket/Guru Pengganti
                $canEditInputs = $isAdminPiket || ($isSedangBerlangsung && (!$isSubmittedFinal || $isSedangBerlangsung));
                $canCancelSubmit = $isSubmittedFinal && ($isSedangBerlangsung || $isAdminPiket);
                $canSubmitOrUpdate = $isAdminPiket || $isSedangBerlangsung;
            @endphp

            @if($isGuruPengganti)
                <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1.5px solid #f59e0b; color: #92400e; padding: 16px 18px; border-radius: 14px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.08);">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="background: #f59e0b; color: #ffffff; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                <div style="font-size: 14.5px; font-weight: 800; color: #78350f;">
                                    📌 Penugasan Guru Pengganti (Menggantikan: {{ $selectedJadwal->guru_utama->nama_guru ?? ($selectedJadwal->guru->nama_guru ?? 'Guru Tidak Hadir') }})
                                </div>
                                <span style="font-size: 11px; font-weight: 800; background: #fde68a; color: #b45309; padding: 3px 9px; border-radius: 6px; border: 1px solid #fcd34d;">
                                    <i class="fa-solid fa-id-badge"></i> Guru Pengganti Aktif
                                </span>
                            </div>
                            <div style="font-size: 12.5px; color: #92400e; margin-top: 4px; line-height: 1.5;">
                                Anda ditugaskan oleh Guru Piket untuk menggantikan KBM di kelas <strong>{{ $selectedJadwal->kelas->nama_kelas ?? '-' }}</strong> pada jam ke-<strong>{{ $selectedJadwal->jam_range }}</strong> ({{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB).
                            </div>
                            @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan) || !empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan))
                                <div style="margin-top: 10px; padding: 10px 14px; background: rgba(255, 255, 255, 0.85); border: 1px dashed #f59e0b; border-radius: 10px; font-size: 12px; color: #78350f;">
                                    @if(!empty($selectedJadwal->penugasan_pengganti->materi_dititipkan))
                                        <div style="margin-bottom: 4px;">
                                            <i class="fa-solid fa-book-open" style="color: #d97706; margin-right: 4px;"></i> <strong>Materi Dititipkan:</strong> {{ $selectedJadwal->penugasan_pengganti->materi_dititipkan }}
                                        </div>
                                    @endif
                                    @if(!empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan))
                                        <div>
                                            <i class="fa-solid fa-list-check" style="color: #d97706; margin-right: 4px;"></i> <strong>Tugas Dititipkan:</strong> {{ $selectedJadwal->penugasan_pengganti->tugas_dititipkan }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($isAdminPiket)
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-user-shield" style="font-size: 18px; color: #2563eb;"></i>
                    <span>Mode Pengurus / Guru Piket: Anda memiliki wewenang untuk mengelola jurnal tanpa pembatasan jam pelajaran.</span>
                </div>
            @endif

            @if($isJamSelesai && !$isAdminPiket)
                @if($isSubmittedFinal)
                    <!-- Class Time Ended - Submitted Journal is Locked Final -->
                    <div style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <i class="fa-solid fa-lock" style="font-size: 24px; color: #64748b; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 14.5px; font-weight: 800; color: #1e293b;">Jurnal Terkunci Final (Jam Pelajaran Berakhir)</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #475569; line-height: 1.45;">
                                Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Data Jurnal Mengajar yang telah dikirim sudah <strong>terkunci final</strong> dan tidak dapat diubah atau dibatalkan lagi.
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Class Time Ended - NOT Filled - Locked and Closed -->
                    <div style="background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.08);">
                        <i class="fa-solid fa-ban" style="font-size: 26px; color: #dc2626; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 15px; font-weight: 800; color: #991b1b;">Waktu Pengisian Jurnal Telah Habis</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #b91c1c; line-height: 1.45;">
                                Jam pelajaran untuk jadwal <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mapel' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> telah berakhir pada pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>. Sesuai data alokasi jam KBM dan master jam pelajaran TU, pengisian jurnal tidak dapat dilakukan karena jam pelajaran guru tersebut telah selesai.
                            </div>
                        </div>
                    </div>
                @endif
            @elseif(!$isJamStarted && !$isAdminPiket)
                <!-- Class Time Not Started Yet -->
                <div style="background: #fff7ed; border: 1px solid #fdba74; color: #c2410c; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px;">
                    <i class="fa-solid fa-clock" style="font-size: 24px; color: #ea580c; flex-shrink: 0;"></i>
                    <div>
                        <div style="font-size: 14.5px; font-weight: 800; color: #9a3412;">Jam Pelajaran Belum Dimulai</div>
                        <div style="margin-top: 3px; font-size: 12.5px; color: #c2410c; line-height: 1.45;">
                            Fitur isi jurnal untuk jam pelajaran ini belum dapat diisi. Pengisian jurnal baru dibuka dan dapat diisi saat jam pelajaran guru berlangsung (Pukul <strong>{{ $selectedJadwal->waktu_mulai_effective ?? '00:00' }} - {{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>).
                        </div>
                    </div>
                </div>
            @elseif($isSedangBerlangsung)
                @if($isHampirHabis)
                    <!-- 5-Minute Pre-Expiry Warning Banner -->
                    <div style="background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; animation: pulse 1.5s infinite;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 26px; color: #dc2626; flex-shrink: 0;"></i>
                        <div>
                            <div style="font-size: 15px; font-weight: 800; color: #991b1b;">Peringatan: Sisa Waktu {{ $selectedJadwal->sisa_menit_selesai }} Menit Lagi!</div>
                            <div style="margin-top: 3px; font-size: 12.5px; color: #b91c1c; line-height: 1.45;">
                                Jam pelajaran akan berakhir pukul <strong>{{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>. Harap segera melengkapi materi dan absensi siswa lalu klik <strong>Simpan Jurnal</strong> sebelum waktu KBM habis dan fitur isi jurnal terkunci!
                            </div>
                        </div>
                    </div>
                @elseif($isSubmittedFinal)
                    <!-- Class Time Ongoing - Submitted Journal can be edited or cancelled -->
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 20px; color: #16a34a; flex-shrink: 0;"></i>
                        <span>Jurnal Mengajar telah dikirim. Selama jam pelajaran masih berlangsung (s/d Pukul <strong>{{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB</strong>), Anda masih dapat memperbarui isian atau membatalkan pengiriman jurnal.</span>
                    </div>
                @elseif($isDraft)
                    <!-- Draft Saved -->
                    <div style="background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-bookmark" style="font-size: 20px; color: #0284c7; flex-shrink: 0;"></i>
                        <span>Jurnal Mengajar saat ini tersimpan sebagai Draft. Silakan lengkapi isian di bawah ini lalu klik <strong>Simpan Jurnal</strong> untuk mengirim secara resmi.</span>
                    </div>
                @else
                    <!-- Ongoing fresh form -->
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-chalkboard-user" style="font-size: 20px; color: #2563eb; flex-shrink: 0;"></i>
                        <span>Jam pelajaran sedang berlangsung (<strong>{{ $selectedJadwal->waktu_mulai_effective }} - {{ $selectedJadwal->waktu_selesai_effective }} WIB</strong>). Silakan isi absensi kelas dan materi pembelajaran.</span>
                    </div>
                @endif
            @endif

            <form method="POST" action="{{ route('guru.jurnal-harian.store') }}">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal ?? 1 }}">

                @php
                    $valTanggal = $todayCarbon ? $todayCarbon->format('d/m/Y') : date('d/m/Y');
                    $valWaktu = ($selectedJadwal && $selectedJadwal->waktu_mulai_effective && $selectedJadwal->waktu_selesai_effective) 
                        ? str_replace(':', '.', $selectedJadwal->waktu_mulai_effective) . ' - ' . str_replace(':', '.', $selectedJadwal->waktu_selesai_effective) 
                        : '-';
                    $valJam = $selectedJadwal ? $selectedJadwal->jam_range : '-';
                    $valKelas = $selectedJadwal->kelas->nama_kelas ?? '-';
                    $valMapel = $selectedJadwal->mapel->nama_mapel ?? '-';
                @endphp

                <!-- Data Jadwal & Jam Pelajaran (Terhubung dengan Master Jadwal TU & Jam Pelajaran - Readonly) -->
                <div class="schedule-info-grid">
                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Tanggal</label>
                        <div class="input-readonly-wrapper">
                            <input type="text" class="input-readonly-field" value="{{ $valTanggal }}" readonly style="padding-right: 38px;">
                            <span class="input-readonly-icon"><i class="fa-regular fa-calendar-days"></i></span>
                        </div>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Waktu</label>
                        <input type="text" class="input-readonly-field" value="{{ $valWaktu }}" readonly>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Jam Pelajaran</label>
                        <input type="text" class="input-readonly-field" value="{{ $valJam }}" readonly>
                    </div>

                    <div class="form-group-custom" style="margin-bottom: 0;">
                        <label class="form-label-custom">Kelas</label>
                        <div class="input-readonly-wrapper">
                            <input type="text" class="input-readonly-field" value="{{ $valKelas }}" readonly style="padding-right: 34px;">
                            <span class="input-readonly-icon"><i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group-custom" style="margin-bottom: 18px;">
                    <label class="form-label-custom">Mata Pelajaran</label>
                    <input type="text" class="input-readonly-field" value="{{ $valMapel }}" readonly>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Materi yang diajarkan</label>
                        @php
                            $defaultMateri = $existingJurnal->materi ?? ($selectedJadwal->penugasan_pengganti->materi_dititipkan ?? '');
                        @endphp
                        <input type="text" name="materi" class="input-field-custom" placeholder="Contoh: Pembahasan Database & Query SQL" required value="{{ old('materi', $defaultMateri) }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Pertemuan ke-</label>
                        <input type="text" name="pertemuan_ke" class="input-field-custom" placeholder="Ke-1" value="{{ old('pertemuan_ke', $existingJurnal->pertemuan_ke ?? $autoPertemuanKe ?? 'Ke-1') }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Catatan kelas</label>
                    @php
                        $defaultCatatan = $existingJurnal->catatan ?? '';
                        if (empty($defaultCatatan) && !empty($selectedJadwal->penugasan_pengganti->tugas_dititipkan)) {
                            $defaultCatatan = 'Tugas yang dititipkan: ' . $selectedJadwal->penugasan_pengganti->tugas_dititipkan;
                        }
                    @endphp
                    <textarea name="catatan" rows="3" class="input-field-custom" placeholder="Catatan aktivitas pembelajaran atau respon siswa di kelas..." {{ !$canEditInputs ? 'disabled' : '' }}>{{ old('catatan', $defaultCatatan) }}</textarea>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Kondisi kelas</label>
                    @php
                        $curKondisi = old('kondisi_kelas', $existingJurnal->kondisi_kelas ?? 'Kondusif');
                    @endphp
                    <div class="condition-pills">
                        <input type="radio" name="kondisi_kelas" id="k1" value="Kondusif" class="condition-pill-input" {{ $curKondisi === 'Kondusif' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k1" class="condition-pill-label">Kondusif</label>

                        <input type="radio" name="kondisi_kelas" id="k2" value="Cukup ramai" class="condition-pill-input" {{ $curKondisi === 'Cukup ramai' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k2" class="condition-pill-label">Cukup ramai</label>

                        <input type="radio" name="kondisi_kelas" id="k3" value="Perlu Perhatian" class="condition-pill-input" {{ $curKondisi === 'Perlu Perhatian' ? 'checked' : '' }} {{ !$canEditInputs ? 'disabled' : '' }}>
                        <label for="k3" class="condition-pill-label">Perlu Perhatian</label>
                    </div>
                </div>

                <!-- Foto Kehadiran (Wajib Live) -->
                @php
                    $existingPhotoUrl = $existingJurnal->dokumentasi_url ?? null;
                @endphp
                <div class="camera-upload-container">
                    <label class="form-label-custom" style="font-size: 13.5px; font-weight: 800; color: #1e293b; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span>Foto Kehadiran (wajib live)</span>
                        @if($existingPhotoUrl)
                            <span style="font-size: 11px; font-weight: 700; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">
                                <i class="fa-solid fa-circle-check"></i> Foto Tersimpan
                            </span>
                        @else
                            <span style="font-size: 11px; font-weight: 700; color: #b91c1c; background: #fee2e2; padding: 2px 8px; border-radius: 6px;">
                                <i class="fa-solid fa-camera"></i> Live Kamera
                            </span>
                        @endif
                    </label>

                    <!-- Hidden Inputs for Form Submission -->
                    <input type="hidden" name="foto_kehadiran_kamera" id="inputFotoKehadiranKamera" value="">
                    <input type="hidden" name="hapus_dokumentasi" id="inputHapusDokumentasi" value="0">
                    <input type="file" id="fallbackDirectCameraInput" accept="image/*" capture="environment" style="display: none;" onchange="handleFallbackCameraFile(event)">
                    <canvas id="liveCameraCanvas" style="display: none;"></canvas>

                    <!-- State 1: Placeholder Click Box (Matches Screenshot) -->
                    <div id="cameraPlaceholderBox" class="camera-box-placeholder" onclick="{{ $canEditInputs ? 'startLiveCamera()' : '' }}" style="{{ $existingPhotoUrl ? 'display: none;' : '' }} {{ !$canEditInputs ? 'cursor: not-allowed; opacity: 0.7;' : '' }}">
                        <div class="camera-icon-circle">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <div style="font-size: 13.5px; font-weight: 800; color: #334155;">
                            {{ $canEditInputs ? 'Buka Kamera untuk Mengambil Foto Kehadiran' : 'Foto Kehadiran Belum Diunggah' }}
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: -6px;">
                            {{ $canEditInputs ? 'Klik untuk mengaktifkan akses kamera live (Wajib live kamera saat KBM)' : 'Pengisian foto hanya dapat dilakukan saat jam pelajaran berlangsung' }}
                        </div>
                    </div>

                    <!-- State 2: Live Viewfinder Camera Stream -->
                    <div id="cameraViewfinderBox" class="camera-viewfinder-wrapper" style="display: none;">
                        <div class="shutter-flash" id="cameraShutterFlash"></div>
                        <div class="camera-live-badge">
                            <span class="live-dot"></span> LIVE KAMERA
                        </div>

                        <video id="liveCameraVideo" autoplay playsinline class="camera-video-stream"></video>

                        <div class="camera-controls-bar">
                            <button type="button" class="btn-camera-opt" onclick="switchLiveCamera()" title="Ganti Kamera (Depan / Belakang)">
                                <i class="fa-solid fa-camera-rotate"></i>
                            </button>

                            <button type="button" class="btn-snap-photo" onclick="snapLivePhoto()" title="Jepret Foto Kehadiran">
                                <i class="fa-solid fa-circle-dot" style="font-size: 18px;"></i> Jepret Foto
                            </button>

                            <button type="button" class="btn-camera-opt" onclick="stopLiveCamera()" style="background: rgba(220, 38, 38, 0.85);" title="Batal / Tutup Kamera">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <!-- State 3: Captured Photo / Existing Photo Preview -->
                    <div id="cameraPreviewBox" class="camera-preview-container" style="{{ $existingPhotoUrl ? 'display: flex;' : 'display: none;' }}">
                        <div class="camera-preview-img-wrapper">
                            <img id="previewFotoKehadiranImg" src="{{ $existingPhotoUrl ?? '' }}" alt="Foto Kehadiran" class="camera-preview-img">
                            <div class="camera-preview-meta" id="previewFotoKehadiranMeta">
                                <i class="fa-solid fa-check-circle" style="color: #22c55e;"></i>
                                <span id="previewFotoKehadiranTimestamp">{{ $existingPhotoUrl ? 'Foto Kehadiran KBM Tersimpan' : 'Foto Baru Berhasil Dijepret' }}</span>
                            </div>
                        </div>

                        @if($canEditInputs)
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; margin-top: 4px;">
                                <button type="button" onclick="startLiveCamera()" class="btn-draft" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 12px; padding: 7px 14px; border-radius: 8px; font-weight: 700;">
                                    <i class="fa-solid fa-camera-rotate"></i> Ambil Ulang Foto Live
                                </button>
                                <button type="button" onclick="removeLivePhoto()" class="btn-draft" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; font-size: 12px; padding: 7px 14px; border-radius: 8px; font-weight: 700;">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Foto
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Presensi Ketidakhadiran Siswa (Full Height / Tanpa Pembatasan Scroll) -->
                <div style="margin-top: 28px; padding-top: 24px; border-top: 1px dashed #cbd5e1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label class="form-label-custom" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">
                                <i class="fa-solid fa-users-viewfinder" style="color: #2563eb; margin-right: 6px;"></i> Presensi Ketidakhadiran Siswa
                            </label>
                            <div style="font-size: 12px; color: #64748b; font-weight: 500;">
                                Tandai status <strong>Sakit</strong>, <strong>Izin</strong>, atau <strong>Alpa</strong> jika ada siswa yang tidak hadir. Siswa yang hadir tetap berstatus Hadir.
                            </div>
                        </div>
                        <!-- Control Bar: Reset Kehadiran Button -->
                        @if($canEditInputs)
                            <button type="button" onclick="resetAllAbsensiToHadir()" class="btn-draft" style="background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; font-size: 12.5px; padding: 8px 16px; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" title="Setel Ulang Semua Status Kehadiran Siswa ke Hadir (Default)">
                                <i class="fa-solid fa-rotate-left"></i> Reset Status Kehadiran
                            </button>
                        @endif
                    </div>

                    @php
                        $totalSiswaTelatDiKelas = count($siswaTelatMap ?? []);
                        $totalSiswaDispenDiKelas = count($dispenMap ?? []);
                    @endphp
                    @if($totalSiswaDispenDiKelas > 0)
                        <div style="background: #faf5ff; border: 1px solid #e9d5ff; color: #6b21a8; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-file-signature" style="color: #9333ea; font-size: 16px; flex-shrink: 0;"></i>
                            <span>Pemberitahuan Waka Kesiswaan & Guru Piket: Terdapat <strong>{{ $totalSiswaDispenDiKelas }} siswa dispensasi resmi disetujui</strong> pada hari ini. Status <em>Dispen</em> telah otomatis disematkan dan dikunci oleh sistem.</span>
                        </div>
                    @endif
                    @if($totalSiswaTelatDiKelas > 0)
                        <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-circle-exclamation" style="color: #d97706; font-size: 16px; flex-shrink: 0;"></i>
                            <span>Pemberitahuan Guru Piket: Terdapat <strong>{{ $totalSiswaTelatDiKelas }} siswa terlambat</strong> pada hari ini. Keterangan <em>(Siswa Tersebut Telat)</em> telah disematkan otomatis pada baris siswa terkait.</span>
                        </div>
                    @endif

                    <!-- Search Bar & Filter Controls -->
                    <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                            <input type="text" id="searchSiswaInput" placeholder="Cari nama atau NISN siswa di kelas ini..." onkeyup="filterSiswaTable()" class="input-field-custom" style="padding: 10px 14px 10px 40px; font-size: 13px; border-radius: 10px; background: #ffffff;">
                        </div>
                        <button type="button" onclick="resetSiswaSearch()" class="btn-draft" style="padding: 10px 16px; font-size: 12.5px; border-radius: 10px; font-weight: 700; background: #f8fafc; border: 1px solid #cbd5e1; color: #475569;" title="Reset Kata Kunci Pencarian">
                            <i class="fa-solid fa-xmark"></i> Reset Cari
                        </button>
                    </div>

                    <div style="border: 1.5px solid #cbd5e1; border-radius: 14px; background: #ffffff; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02); width: 100%;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;" id="tableAbsensiSiswa">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; letter-spacing: 0.5px;">
                                    <th style="padding: 14px 20px; background: #f8fafc; font-weight: 800;">Nama Siswa & Keterangan</th>
                                    <th style="padding: 14px 20px; text-align: right; background: #f8fafc; font-weight: 800;">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $sw)
                                    @php
                                        $swId = $sw->id_siswa;
                                        $hasLeave = isset($suratIzinMap[$swId]);
                                        $leaveType = $hasLeave ? $suratIzinMap[$swId]['jenis'] : null;
                                        $hasTelat = isset($siswaTelatMap[$swId]);
                                        $telatInfo = $hasTelat ? $siswaTelatMap[$swId] : null;
                                        $hasDispen = isset($dispenMap[$swId]);
                                        $dispenInfo = $hasDispen ? $dispenMap[$swId] : null;
                                        $currentStatus = $existingAbsensi[$swId] ?? ($hasDispen ? 'Dispen' : ($leaveType ?? 'Hadir'));
                                    @endphp
                                    <tr class="siswa-row-item" data-id="{{ $swId }}" data-nama="{{ strtolower($sw->nama_siswa) }}" data-nisn="{{ strtolower($sw->nisn ?? '') }}" data-has-dispen="{{ $hasDispen ? 'true' : 'false' }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease; {{ $hasDispen ? 'background: #faf5ff;' : ($hasTelat ? 'background: #fffdf5;' : '') }}">
                                        <td style="padding: 14px 20px; color: #0f172a; vertical-align: middle;">
                                            <div style="font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span>{{ $sw->nama_siswa }}</span>
                                                @if($hasDispen)
                                                    <span style="font-size: 11px; background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="Dispen Resmi Disetujui Waka Kesiswaan{{ $dispenInfo['jam'] }} &bull; Alasan: {{ $dispenInfo['alasan'] }}">
                                                        <i class="fa-solid fa-file-circle-check" style="color: #9333ea;"></i> (Dispen Disetujui Waka Kesiswaan{{ $dispenInfo['jam'] }})
                                                    </span>
                                                @endif
                                                @if($hasTelat)
                                                    <span style="font-size: 11px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 10px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;" title="Siswa Tersebut Telat (Jam {{ $telatInfo['jam_terlambat'] }} WIB) &bull; Alasan: {{ $telatInfo['alasan'] }}">
                                                        <i class="fa-solid fa-user-clock" style="color: #d97706;"></i> (Siswa Tersebut Telat - Jam {{ $telatInfo['jam_terlambat'] }} WIB)
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="font-size: 11.5px; color: #64748b; font-weight: normal; margin-top: 3px; display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
                                                <span>NISN: <strong>{{ $sw->nisn ?? '-' }}</strong></span>
                                                @if($hasDispen && !empty($dispenInfo['alasan']))
                                                    <span style="color: #6b21a8; font-weight: 600;">
                                                        &bull; Keperluan Dispen: <em>{{ Str::limit($dispenInfo['alasan'], 50) }}</em>
                                                    </span>
                                                @endif
                                                @if($hasLeave)
                                                    <span style="font-size: 10.5px; background: #e0f2fe; color: #0369a1; padding: 2px 7px; border-radius: 4px; font-weight: 700;">
                                                        <i class="fa-solid fa-file-medical"></i> {{ $leaveType }} Terverifikasi
                                                    </span>
                                                @endif
                                                @if($hasTelat && !empty($telatInfo['alasan']))
                                                    <span style="color: #92400e; font-weight: 600;">
                                                        &bull; Alasan Keterlambatan: <em>{{ Str::limit($telatInfo['alasan'], 45) }}</em>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 14px 20px; text-align: right; vertical-align: middle;">
                                            <div style="display: inline-flex; gap: 8px; font-size: 12px; font-weight: 700; flex-wrap: nowrap; justify-content: flex-end;">
                                                <label class="status-radio-pill pill-hadir" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Hadir')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                    <span>Hadir</span>
                                                </label>
                                                <label class="status-radio-pill pill-sakit" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Sakit')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                    <span>Sakit</span>
                                                </label>
                                                <label class="status-radio-pill pill-izin" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Izin')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                    <span>Izin</span>
                                                </label>
                                                <label class="status-radio-pill pill-alpa" style="{{ $hasDispen ? 'opacity: 0.35; cursor: not-allowed;' : '' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Alpa')" {{ (!$canEditInputs || $hasDispen) ? 'disabled' : '' }}>
                                                    <span>Alpa</span>
                                                </label>
                                                <label class="status-radio-pill pill-dispen locked" title="{{ $hasDispen ? 'Status Dispen Disetujui Waka Kesiswaan' : 'Opsi Dispen hanya dapat diisi otomatis oleh sistem jika ada persetujuan resmi dari Waka Kesiswaan' }}">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Dispen" {{ $currentStatus === 'Dispen' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Dispen')" {{ ($hasDispen && $canEditInputs) ? '' : 'disabled' }}>
                                                    <span>Dispen</span>
                                                    <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 2px;"></i>
                                                </label>
                                            </div>
                                            <div id="absence_input_wrap_{{ $swId }}">
                                                @if(in_array($currentStatus, ['Sakit', 'Izin', 'Alpa', 'Dispen']))
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][id_siswa]" value="{{ $swId }}">
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][keterangan]" value="{{ $currentStatus }}">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 24px; text-align: center; color: #94a3b8;">Daftar siswa di kelas ini tidak tersedia.</td>
                                    </tr>
                                @endforelse
                                <tr id="noSiswaMatchNotice" style="display: none;">
                                    <td colspan="2" style="padding: 24px; text-align: center; color: #64748b; font-size: 13px;">
                                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 6px; color: #94a3b8;"></i> Tidak ada siswa yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    function toggleAbsenceInput(idSiswa, status) {
                        const wrap = document.getElementById('absence_input_wrap_' + idSiswa);
                        if (!wrap) return;
                        if (status === 'Hadir') {
                            wrap.innerHTML = '';
                        } else {
                            wrap.innerHTML = '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][id_siswa]" value="' + idSiswa + '">' +
                                             '<input type="hidden" name="ketidakhadiran[' + idSiswa + '][keterangan]" value="' + status + '">';
                        }
                    }

                    function filterSiswaTable() {
                        const input = document.getElementById('searchSiswaInput');
                        if (!input) return;
                        const query = input.value.toLowerCase().trim();
                        const rows = document.querySelectorAll('.siswa-row-item');
                        let foundCount = 0;

                        rows.forEach(row => {
                            const name = row.getAttribute('data-nama') || '';
                            const nisn = row.getAttribute('data-nisn') || '';
                            if (name.includes(query) || nisn.includes(query)) {
                                row.style.display = '';
                                foundCount++;
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        const notice = document.getElementById('noSiswaMatchNotice');
                        if (notice) {
                            notice.style.display = (foundCount === 0 && rows.length > 0) ? '' : 'none';
                        }
                    }

                    function resetSiswaSearch() {
                        const input = document.getElementById('searchSiswaInput');
                        if (input) {
                            input.value = '';
                            filterSiswaTable();
                        }
                    }

                    function resetAllAbsensiToHadir() {
                        const rows = document.querySelectorAll('.siswa-row-item');
                        rows.forEach(row => {
                            const hasDispen = row.getAttribute('data-has-dispen') === 'true';
                            if (hasDispen) return; // Dispen resmi tidak boleh di-reset ke Hadir

                            const swId = row.getAttribute('data-id');
                            const hadirRadio = row.querySelector('input[type="radio"][value="Hadir"]');
                            if (hadirRadio && !hadirRadio.disabled) {
                                hadirRadio.checked = true;
                                toggleAbsenceInput(swId, 'Hadir');
                            }
                        });
                    }

                    /* === LIVE CAMERA SCRIPTS === */
                    let currentCameraStream = null;
                    let currentFacingMode = 'environment'; // default rear camera for classroom

                    async function startLiveCamera() {
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const preview = document.getElementById('cameraPreviewBox');
                        const video = document.getElementById('liveCameraVideo');

                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            triggerFallbackDirectCamera();
                            return;
                        }

                        try {
                            if (currentCameraStream) {
                                currentCameraStream.getTracks().forEach(track => track.stop());
                            }

                            const constraints = {
                                video: {
                                    facingMode: { ideal: currentFacingMode },
                                    width: { ideal: 1280 },
                                    height: { ideal: 720 }
                                },
                                audio: false
                            };

                            const stream = await navigator.mediaDevices.getUserMedia(constraints);
                            currentCameraStream = stream;
                            if (video) {
                                video.srcObject = stream;
                                await video.play();
                            }

                            if (placeholder) placeholder.style.display = 'none';
                            if (preview) preview.style.display = 'none';
                            if (viewfinder) viewfinder.style.display = 'block';

                            if (video) {
                                video.style.transform = (currentFacingMode === 'user') ? 'scaleX(-1)' : 'scaleX(1)';
                            }
                        } catch (err) {
                            console.warn('getUserMedia camera error / fallback to direct camera:', err);
                            triggerFallbackDirectCamera();
                        }
                    }

                    function stopLiveCamera() {
                        if (currentCameraStream) {
                            currentCameraStream.getTracks().forEach(track => track.stop());
                            currentCameraStream = null;
                        }
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const preview = document.getElementById('cameraPreviewBox');
                        const previewImg = document.getElementById('previewFotoKehadiranImg');

                        if (viewfinder) viewfinder.style.display = 'none';
                        if (previewImg && previewImg.src && previewImg.src !== '' && previewImg.src !== window.location.href) {
                            if (preview) preview.style.display = 'flex';
                            if (placeholder) placeholder.style.display = 'none';
                        } else {
                            if (placeholder) placeholder.style.display = 'flex';
                            if (preview) preview.style.display = 'none';
                        }
                    }

                    async function switchLiveCamera() {
                        currentFacingMode = (currentFacingMode === 'environment') ? 'user' : 'environment';
                        await startLiveCamera();
                    }

                    function snapLivePhoto() {
                        const video = document.getElementById('liveCameraVideo');
                        const canvas = document.getElementById('liveCameraCanvas');
                        const flash = document.getElementById('cameraShutterFlash');
                        const previewImg = document.getElementById('previewFotoKehadiranImg');
                        const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                        const inputHapus = document.getElementById('inputHapusDokumentasi');
                        const timestampSpan = document.getElementById('previewFotoKehadiranTimestamp');

                        if (!video || !canvas) return;

                        // Shutter flash effect
                        if (flash) {
                            flash.classList.add('active');
                            setTimeout(() => flash.classList.remove('active'), 180);
                        }

                        const width = video.videoWidth || 1280;
                        const height = video.videoHeight || 720;
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        if (currentFacingMode === 'user') {
                            ctx.translate(width, 0);
                            ctx.scale(-1, 1);
                        }
                        ctx.drawImage(video, 0, 0, width, height);

                        // Export high-quality JPEG Data URL
                        const photoDataUrl = canvas.toDataURL('image/jpeg', 0.88);

                        if (inputHidden) inputHidden.value = photoDataUrl;
                        if (inputHapus) inputHapus.value = '0';
                        if (previewImg) previewImg.src = photoDataUrl;

                        const now = new Date();
                        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if (timestampSpan) {
                            timestampSpan.textContent = `Foto Live Berhasil Dijepret (${timeStr} WIB)`;
                        }

                        // Stop video stream and show photo preview
                        if (currentCameraStream) {
                            currentCameraStream.getTracks().forEach(track => track.stop());
                            currentCameraStream = null;
                        }
                        const viewfinder = document.getElementById('cameraViewfinderBox');
                        const placeholder = document.getElementById('cameraPlaceholderBox');
                        const preview = document.getElementById('cameraPreviewBox');

                        if (viewfinder) viewfinder.style.display = 'none';
                        if (placeholder) placeholder.style.display = 'none';
                        if (preview) preview.style.display = 'flex';
                    }

                    function removeLivePhoto() {
                        if (confirm('Apakah Anda yakin ingin menghapus foto kehadiran ini?')) {
                            const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                            const inputHapus = document.getElementById('inputHapusDokumentasi');
                            const previewImg = document.getElementById('previewFotoKehadiranImg');
                            const preview = document.getElementById('cameraPreviewBox');
                            const placeholder = document.getElementById('cameraPlaceholderBox');

                            if (inputHidden) inputHidden.value = '';
                            if (inputHapus) inputHapus.value = '1';
                            if (previewImg) previewImg.src = '';
                            if (preview) preview.style.display = 'none';
                            if (placeholder) placeholder.style.display = 'flex';
                        }
                    }

                    function triggerFallbackDirectCamera() {
                        const fileInput = document.getElementById('fallbackDirectCameraInput');
                        if (fileInput) {
                            fileInput.click();
                        }
                    }

                    function handleFallbackCameraFile(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const photoDataUrl = e.target.result;
                            const inputHidden = document.getElementById('inputFotoKehadiranKamera');
                            const inputHapus = document.getElementById('inputHapusDokumentasi');
                            const previewImg = document.getElementById('previewFotoKehadiranImg');
                            const timestampSpan = document.getElementById('previewFotoKehadiranTimestamp');
                            const placeholder = document.getElementById('cameraPlaceholderBox');
                            const viewfinder = document.getElementById('cameraViewfinderBox');
                            const preview = document.getElementById('cameraPreviewBox');

                            if (inputHidden) inputHidden.value = photoDataUrl;
                            if (inputHapus) inputHapus.value = '0';
                            if (previewImg) previewImg.src = photoDataUrl;
                            
                            if (timestampSpan) {
                                timestampSpan.textContent = 'Foto Kamera Terunggah';
                            }

                            if (placeholder) placeholder.style.display = 'none';
                            if (viewfinder) viewfinder.style.display = 'none';
                            if (preview) preview.style.display = 'flex';
                        };
                        reader.readAsDataURL(file);
                    }
                </script>

                <div class="form-actions-row" style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                    @if($canCancelSubmit)
                        <!-- Batal Kirim Jurnal Button (Triggers standalone form outside main form) -->
                        <button type="button" onclick="confirmBatalKirimJurnal()" class="btn-draft" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; font-weight: 800; padding: 10px 18px; border-radius: 10px; cursor: pointer; transition: all 0.15s ease;" title="Batalkan pengiriman jurnal dan kembalikan ke status Belum Diisi (Hanya aktif selama jam pelajaran berlangsung)">
                            <i class="fa-solid fa-rotate-left"></i> Batal Kirim Jurnal
                        </button>
                    @endif

                    @if($canSubmitOrUpdate)
                        <button type="submit" name="action" value="draft" class="btn-draft">
                            <i class="fa-regular fa-bookmark"></i> Simpan Draft
                        </button>

                        <button type="submit" name="action" value="save" class="btn-submit-jurnal" style="background: #2563eb;">
                            <i class="fa-solid fa-paper-plane"></i> {{ $isSubmittedFinal ? 'Perbarui Jurnal' : 'Simpan Jurnal' }}
                        </button>
                    @elseif($isJamSelesai && !$isAdminPiket)
                        @if($isSubmittedFinal)
                            <!-- Submitted & Class Ended: Locked indicator shown -->
                            <div style="padding: 10px 18px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-lock" style="color: #64748b;"></i> Jurnal Terkunci Final (Jam Pelajaran Berakhir)
                            </div>
                        @else
                            <!-- Not Submitted & Class Ended: Disabled button -->
                            <button type="button" disabled style="padding: 10px 20px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; color: #991b1b; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran KBM telah berakhir. Pengisian jurnal telah ditutup.">
                                <i class="fa-solid fa-ban"></i> Pengisian Ditutup (Waktu Habis)
                            </button>
                        @endif
                    @elseif(!$isJamStarted && !$isAdminPiket)
                        <button type="button" disabled style="padding: 10px 20px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 10px; color: #94a3b8; font-size: 13px; font-weight: 800; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;" title="Jam pelajaran belum dimulai (Pukul {{ $selectedJadwal->waktu_mulai_effective ?? '' }} WIB)">
                            <i class="fa-solid fa-lock"></i> Belum Memasuki Jam Pelajaran
                        </button>
                    @endif
                </div>

                <div class="bottom-info-banner">
                    <i class="fa-solid fa-square-check" style="color: #16a34a;"></i>
                    <span>Jurnal hanya dapat diisi saat jam mengajar sedang berlangsung</span>
                </div>
            </form>

            <!-- Standalone Form for Batal Kirim Jurnal (Outside main form to prevent HTML nested form issue) -->
            @if(isset($selectedJadwal) && $selectedJadwal)
                <form id="formBatalKirimJurnal" method="POST" action="{{ route('guru.jurnal-harian.batal-kirim') }}" style="display: none;">
                    @csrf
                    <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal }}">
                </form>

                <script>
                    function confirmBatalKirimJurnal() {
                        if (confirm('Apakah Anda yakin ingin membatalkan pengiriman Jurnal Mengajar ini? Data pengiriman jurnal untuk jadwal ini akan dihapus total, formulir dikosongkan kembali, dan status mengajar kembali menjadi Belum Diisi.')) {
                            document.getElementById('formBatalKirimJurnal').submit();
                        }
                    }
                </script>
            @endif
        </div>

    <!-- Bottom Summary & Progress Widgets (2 Cards Side-by-Side) -->
    <div class="jurnal-bottom-widgets-grid">
        <!-- Widget 1: Riwayat Jurnal Hari Ini -->
        <div class="widget-box" style="border-top: 4px solid #2563eb; background: #ffffff; margin-bottom: 0;">
            <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-history" style="color: #2563eb; margin-right: 6px;"></i> Riwayat Jurnal Hari Ini</span>
                <span style="font-size: 11px; color: #64748b; font-weight: 600;">
                    {{ $todayCarbon->translatedFormat('d M Y') }}
                </span>
            </div>
            <div>
                @forelse($riwayatHariIni as $rItem)
                    @php
                        $jObj = $rItem->jadwal;
                    @endphp
                    <div class="history-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="history-class" style="font-size: 13px; font-weight: 800; color: #0f172a;">
                                {{ $jObj->kelas->nama_kelas ?? 'Kelas' }} — {{ $jObj->ruangan->nama_ruangan ?? 'Ruangan' }}
                            </div>
                            <div class="history-date" style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                {{ $jObj->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $jObj->waktu_mulai_effective }} - {{ $jObj->waktu_selesai_effective }})
                            </div>
                        </div>
                        @if($rItem->is_terisi)
                            @if($rItem->is_draft)
                                <span style="background: #e0f2fe; color: #0369a1; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">DRAFT</span>
                            @else
                                <span style="background: #dcfce7; color: #15803d; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">TERISI</span>
                            @endif
                        @else
                            <span style="background: #f8fafc; color: #94a3b8; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">BELUM</span>
                        @endif
                    </div>
                @empty
                    <div style="font-size: 12.5px; color: #94a3b8; padding: 14px 0; text-align: center;">Belum ada jadwal mengajar pada hari ini.</div>
                @endforelse
            </div>
        </div>

        <!-- Widget 2: Progres Bulanan -->
        <div class="widget-box" style="border-top: 4px solid #0284c7; background: #ffffff; margin-bottom: 0;">
            <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-chart-line" style="color: #0284c7; margin-right: 6px;"></i> Progres Bulanan</span>
                <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                    {{ $todayCarbon->translatedFormat('F Y') }}
                </span>
            </div>
            <div style="margin-top: 10px;">
                <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Jurnal Terisi</span>
                    <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $progresBulanan['terisi'] }} / {{ $progresBulanan['target'] }}</span>
                </div>

                @php
                    $pctBulanan = min(100, (int) round(($progresBulanan['terisi'] / max(1, $progresBulanan['target'])) * 100));
                @endphp
                <div style="width: 100%; height: 7px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin: 10px 0; border: 1px solid #e2e8f0;">
                    <div style="width: {{ $pctBulanan }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); border-radius: 6px; transition: width 0.3s ease;"></div>
                </div>

                <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Rata-rata per Minggu</span>
                    <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0284c7;">{{ $progresBulanan['rata_minggu'] }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Jurnal</span></span>
                </div>
            </div>
        </div>
    </div>

@endsection
