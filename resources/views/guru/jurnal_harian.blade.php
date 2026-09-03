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

    /* Layout Grid */
    .jurnal-form-grid {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .jurnal-form-grid { grid-template-columns: 1fr; }
    }

    /* Main Form Card */
    .form-jurnal-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 6px;
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

    /* Buttons */
    .form-actions-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 24px;
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
        padding: 10px 16px;
        border-radius: 10px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
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

    @if(isset($selectedJadwal) && $selectedJadwal && $selectedJadwal->hampir_habis)
        <div style="background: #fff7ed; border: 2px solid #ea580c; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 6px 20px rgba(234, 88, 12, 0.2);">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; animation: pulse 1.5s infinite;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 800; color: #9a3412;">Peringatan 5 Menit Terakhir!</div>
                    <div style="font-size: 13.5px; color: #c2410c; margin-top: 2px;">
                        Jam pelajaran <strong>{{ $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</strong> tersisa <strong>{{ $selectedJadwal->sisa_menit_selesai <= 1 ? 'kurang dari 1' : (int)$selectedJadwal->sisa_menit_selesai }} menit lagi</strong> sebelum jam berakhir (pkl {{ $selectedJadwal->waktu_selesai_effective }} WIB). Mohon segera lengkapi dan simpan Jurnal Mengajar Anda!
                    </div>
                </div>
            </div>
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
                $isMasuk = $j->sudah_masuk_jam;
            @endphp
            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) }}" class="schedule-card-item {{ $isSelected ? 'selected' : '' }}">
                <div class="schedule-card-title">{{ $j->mapel->nama_mapel ?? 'Mata Pelajaran' }} {{ $j->kelas->nama_kelas ?? '' }}</div>
                <div class="schedule-card-meta">
                    {{ $j->waktu_mulai_effective }} - {{ $j->waktu_selesai_effective }} · {{ $j->ruangan->nama_ruangan ?? 'Ruang 57' }}
                </div>
                <div class="schedule-card-status {{ $isMasuk ? 'status-active' : 'status-pending' }}">
                    @if($j->isDiisiHariIni())
                        <span style="color: #16a34a;"><i class="fa-solid fa-circle-check"></i> Sudah Diisi</span>
                    @elseif($isMasuk)
                        <i class="fa-solid fa-circle"></i> Sedang berlangsung
                    @else
                        <i class="fa-regular fa-clock"></i> Belum mulai
                    @endif
                </div>
            </a>
        @empty
            <div style="font-size: 13px; color: #94a3b8;">Tidak ada jadwal mengajar hari ini.</div>
        @endforelse
    </div>

    <!-- Main Grid Content -->
    <div class="jurnal-form-grid">
        
        <!-- Left: Form Isi Jurnal Mengajar -->
        <div class="form-jurnal-box">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-file-pen" style="color: #2563eb; margin-right: 6px;"></i> Isi Jurnal Mengajar: {{ $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran' }} ({{ $selectedJadwal->kelas->nama_kelas ?? '' }})</span>
                @if(isset($existingJurnal) && $existingJurnal)
                    <span style="font-size: 11px; background: {{ $existingJurnal->is_draft ? '#e0f2fe' : '#dcfce7' }}; color: {{ $existingJurnal->is_draft ? '#0369a1' : '#15803d' }}; padding: 3px 10px; border-radius: 20px; font-weight: 800;">
                        {{ $existingJurnal->is_draft ? 'DRAFT TERSIMPAN' : 'JURNAL TERISI' }}
                    </span>
                @endif
            </h2>

            @php
                $user = Auth::user();
                $isAdminPiket = ($user && ($user->isAdmin() || $user->isGuruPiket()));
                $isSubmittedFinal = (isset($existingJurnal) && $existingJurnal && !$existingJurnal->is_draft);
                $isJamSelesai = $selectedJadwal ? $selectedJadwal->is_jam_sudah_selesai : false;
                $isJamStarted = $selectedJadwal ? $selectedJadwal->sudah_masuk_jam : false;

                // Inputs editable condition: time started AND (not submitted final OR class not ended OR Admin/Piket)
                $canEditInputs = ($isJamStarted || $isAdminPiket) && (!$isSubmittedFinal || !$isJamSelesai || $isAdminPiket);

                // Can cancel submission: Submitted final AND class NOT ended AND (time started OR Admin/Piket)
                $canCancelSubmit = $isSubmittedFinal && !$isJamSelesai && ($isJamStarted || $isAdminPiket);

                // Can submit/update journal: time started AND (not submitted final OR class NOT ended OR Admin/Piket)
                $canSubmitOrUpdate = ($isJamStarted || $isAdminPiket) && (!$isSubmittedFinal || !$isJamSelesai || $isAdminPiket);
            @endphp

            @if($isSubmittedFinal && $isJamSelesai && !$isAdminPiket)
                <!-- Class Time Ended - Submitted Journal is Locked Final -->
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-lock" style="font-size: 20px; color: #64748b;"></i>
                    <span>Jam pelajaran untuk jadwal ini telah berakhir (Pukul {{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB). Data Jurnal Mengajar yang telah dikirim sudah <strong>terkunci final</strong> dan tidak dapat diubah atau dibatalkan lagi.</span>
                </div>
            @elseif($isSubmittedFinal)
                <!-- Class Time Ongoing - Submitted Journal can be edited or cancelled -->
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 20px; color: #16a34a;"></i>
                    <span>Jurnal Mengajar telah dikirim. Selama jam pelajaran masih berlangsung (s/d Pukul {{ $selectedJadwal->waktu_selesai_effective ?? '00:00' }} WIB), Anda dapat memperbarui isian atau membatalkan pengiriman jurnal.</span>
                </div>
            @elseif(isset($existingJurnal) && $existingJurnal && $existingJurnal->is_draft)
                <!-- Draft Saved -->
                <div style="background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-bookmark" style="font-size: 20px; color: #0284c7;"></i>
                    <span>Jurnal Mengajar saat ini tersimpan sebagai Draft. Silakan lengkapi isian di bawah ini lalu klik <strong>Simpan Jurnal</strong> untuk mengirim secara resmi.</span>
                </div>
            @elseif(!$isJamStarted && !$isAdminPiket)
                <!-- Class Time Not Started Yet -->
                <div style="background: #fff7ed; border: 1px solid #fdba74; color: #c2410c; padding: 14px 18px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-clock" style="font-size: 20px; color: #ea580c;"></i>
                    <span>Fitur isi jurnal untuk jam pelajaran ini belum aktif. Pengisian jurnal baru bisa dilakukan saat jam pelajaran dimulai (Pukul {{ $selectedJadwal->waktu_mulai_effective ?? '00:00' }} WIB).</span>
                </div>
            @endif

            <form method="POST" action="{{ route('guru.jurnal-harian.store') }}">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{ $selectedJadwal->id_jadwal ?? 1 }}">

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Materi yang diajarkan</label>
                        <input type="text" name="materi" class="input-field-custom" placeholder="Contoh: Pembahasan Database & Query SQL" required value="{{ old('materi', $existingJurnal->materi ?? '') }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Pertemuan ke-</label>
                        <input type="text" name="pertemuan_ke" class="input-field-custom" placeholder="Ke-1" value="{{ old('pertemuan_ke', $existingJurnal->pertemuan_ke ?? $autoPertemuanKe ?? 'Ke-1') }}" {{ !$canEditInputs ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Catatan kelas</label>
                    <textarea name="catatan" rows="3" class="input-field-custom" placeholder="Catatan aktivitas pembelajaran atau respon siswa di kelas..." {{ !$canEditInputs ? 'disabled' : '' }}>{{ old('catatan', $existingJurnal->catatan ?? '') }}</textarea>
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

                <!-- Presensi Ketidakhadiran Siswa -->
                <div style="margin-top: 24px; padding-top: 20px; border-top: 1px dashed #cbd5e1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                        <label class="form-label-custom" style="font-size: 14px; color: #1e293b; margin-bottom: 0;">
                            <i class="fa-solid fa-users-viewfinder" style="color: #2563eb; margin-right: 6px;"></i> Presensi Ketidakhadiran Siswa
                            <small style="color: #64748b; font-weight: normal; margin-left: 4px;">(Tandai Sakit/Izin/Alpa jika ada)</small>
                        </label>
                        <!-- Control Bar: Reset Kehadiran Button -->
                        @if($canEditInputs)
                            <button type="button" onclick="resetAllAbsensiToHadir()" class="btn-action-jurnal" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 12px; padding: 6px 12px; border-radius: 8px; font-weight: 700; cursor: pointer;" title="Setel Ulang Semua Status Kehadiran Siswa ke Hadir (Default)">
                                <i class="fa-solid fa-rotate-left"></i> Reset Status Kehadiran
                            </button>
                        @endif
                    </div>

                    <!-- Search Bar & Filter Controls -->
                    <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                            <input type="text" id="searchSiswaInput" placeholder="Cari nama atau NISN siswa di kelas ini..." onkeyup="filterSiswaTable()" class="input-field-custom" style="padding: 8px 12px 8px 34px; font-size: 12.5px; border-radius: 8px; background: #ffffff;">
                        </div>
                        <button type="button" onclick="resetSiswaSearch()" class="btn-draft" style="padding: 8px 14px; font-size: 12px; border-radius: 8px; font-weight: 700; background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569;" title="Reset Kata Kunci Pencarian">
                            <i class="fa-solid fa-xmark"></i> Reset Cari
                        </button>
                    </div>

                    <div style="max-height: 280px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 12px; background: #ffffff;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;" id="tableAbsensiSiswa">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left; font-size: 11px; color: #475569; text-transform: uppercase; border-bottom: 1px solid #cbd5e1; position: sticky; top: 0; z-index: 2;">
                                    <th style="padding: 10px 14px; background: #f8fafc;">Nama Siswa</th>
                                    <th style="padding: 10px 14px; text-align: right; background: #f8fafc;">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $sw)
                                    @php
                                        $swId = $sw->id_siswa;
                                        $hasLeave = isset($suratIzinMap[$swId]);
                                        $leaveType = $hasLeave ? $suratIzinMap[$swId]['jenis'] : null;
                                        $currentStatus = $existingAbsensi[$swId] ?? ($leaveType ?? 'Hadir');
                                    @endphp
                                    <tr class="siswa-row-item" data-id="{{ $swId }}" data-nama="{{ strtolower($sw->nama_siswa) }}" data-nisn="{{ strtolower($sw->nisn ?? '') }}" style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 10px 14px; color: #0f172a;">
                                            <div style="font-weight: 700;">{{ $sw->nama_siswa }}</div>
                                            <div style="font-size: 11px; color: #64748b; font-weight: normal; margin-top: 1px;">
                                                NISN: {{ $sw->nisn ?? '-' }}
                                                @if($hasLeave)
                                                    <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 1px 6px; border-radius: 4px; font-weight: 700; margin-left: 4px;">
                                                        <i class="fa-solid fa-file-medical"></i> {{ $leaveType }} Terverifikasi
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 10px 14px; text-align: right;">
                                            <div style="display: inline-flex; gap: 10px; font-size: 12px; font-weight: 700;">
                                                <label style="cursor: pointer; color: #16a34a;">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Hadir')" {{ !$canEditInputs ? 'disabled' : '' }}> Hadir
                                                </label>
                                                <label style="cursor: pointer; color: #2563eb;">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Sakit')" {{ !$canEditInputs ? 'disabled' : '' }}> Sakit
                                                </label>
                                                <label style="cursor: pointer; color: #d97706;">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Izin')" {{ !$canEditInputs ? 'disabled' : '' }}> Izin
                                                </label>
                                                <label style="cursor: pointer; color: #dc2626;">
                                                    <input type="radio" name="siswa_status_{{ $swId }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} onchange="toggleAbsenceInput({{ $swId }}, 'Alpa')" {{ !$canEditInputs ? 'disabled' : '' }}> Alpa
                                                </label>
                                            </div>
                                            <div id="absence_input_wrap_{{ $swId }}">
                                                @if(in_array($currentStatus, ['Sakit', 'Izin', 'Alpa']))
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][id_siswa]" value="{{ $swId }}">
                                                    <input type="hidden" name="ketidakhadiran[{{ $swId }}][keterangan]" value="{{ $currentStatus }}">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 14px; text-align: center; color: #94a3b8;">Daftar siswa di kelas ini tidak tersedia.</td>
                                    </tr>
                                @endforelse
                                <tr id="noSiswaMatchNotice" style="display: none;">
                                    <td colspan="2" style="padding: 16px; text-align: center; color: #64748b; font-size: 12.5px;">
                                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 4px; color: #94a3b8;"></i> Tidak ada siswa yang cocok dengan pencarian.
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
                            const swId = row.getAttribute('data-id');
                            const hadirRadio = row.querySelector('input[type="radio"][value="Hadir"]');
                            if (hadirRadio && !hadirRadio.disabled) {
                                hadirRadio.checked = true;
                                toggleAbsenceInput(swId, 'Hadir');
                            }
                        });
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
                    @elseif($isSubmittedFinal && $isJamSelesai && !$isAdminPiket)
                        <!-- Submitted & Class Ended: Buttons disappear, locked indicator shown -->
                        <div style="padding: 9px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-lock" style="color: #94a3b8;"></i> Jurnal Terkunci (Jam Pelajaran Berakhir)
                        </div>
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

        <!-- Right: Side Widgets -->
        <div>
            <!-- Widget 1: Riwayat Jurnal Hari Ini -->
            <div class="widget-box" style="border-top: 4px solid #2563eb; background: #ffffff;">
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
                        <div class="history-item" style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
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
            <div class="widget-box" style="border-top: 4px solid #0284c7; background: #ffffff;">
                <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa-solid fa-chart-line" style="color: #0284c7; margin-right: 6px;"></i> Progres Bulanan</span>
                    <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-weight: 800;">
                        {{ $todayCarbon->translatedFormat('F Y') }}
                    </span>
                </div>
                <div style="margin-top: 10px;">
                    <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Jurnal Terisi</span>
                        <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $progresBulanan['terisi'] }} / {{ $progresBulanan['target'] }}</span>
                    </div>

                    @php
                        $pctBulanan = min(100, (int) round(($progresBulanan['terisi'] / max(1, $progresBulanan['target'])) * 100));
                    @endphp
                    <div style="width: 100%; height: 7px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin: 10px 0; border: 1px solid #e2e8f0;">
                        <div style="width: {{ $pctBulanan }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); border-radius: 6px; transition: width 0.3s ease;"></div>
                    </div>

                    <div class="progress-row" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                        <span class="progress-label" style="font-size: 13px; font-weight: 700; color: #475569;">Rata-rata per Minggu</span>
                        <span class="progress-val" style="font-size: 16px; font-weight: 800; color: #0284c7;">{{ $progresBulanan['rata_minggu'] }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Jurnal</span></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

@endsection
