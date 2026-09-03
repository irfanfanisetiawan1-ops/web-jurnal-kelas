@extends('layouts.guru')

@section('title', 'Isi Jurnal & Presensi Guru Pengganti — EDU JOURNAL')
@section('header_title', 'Jurnal & Presensi Guru Pengganti')

@section('styles')
<style>
    .page-header-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 16px;
        padding: 24px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    }
    .page-header-card h1 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -0.02em;
    }
    .page-header-card p {
        font-size: 13.5px;
        color: #cbd5e1;
        margin-bottom: 0;
    }

    .nav-tabs-custom {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .nav-tab-item {
        padding: 10px 18px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .nav-tab-item:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .nav-tab-item.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .detail-assignment-box {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .assignment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }
    .assignment-info-item {
        background: #f8fafc;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
    }
    .assignment-info-item .label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .assignment-info-item .value {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .time-gate-banner {
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .time-gate-locked {
        background: #fffbebf0;
        border: 1px solid #fde68a;
        color: #92400e;
    }
    .time-gate-open {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }
    .time-gate-urgent {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        animation: pulse 2s infinite;
    }
    .time-gate-completed {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
    }

    .form-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .form-section-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
    }

    .table-siswa {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 12px;
    }
    .table-siswa th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 12px 14px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-siswa td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        vertical-align: middle;
    }
    .radio-group-attendance {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .radio-option {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: background 0.2s ease;
    }
    .radio-option:hover {
        background: #f1f5f9;
    }

    .btn-quick-fill {
        padding: 6px 12px;
        background: #e2e8f0;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-quick-fill:hover {
        background: #cbd5e1;
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Isi Jurnal & Presensi Pengganti</h1>
            <p>Pengisian presensi siswa dan jurnal kelas untuk penugasan guru pengganti aktif hari ini</p>
        </div>
    </div>
<div class="page-header-card">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
            <h1><i class="fa-solid fa-file-pen" style="color:#f59e0b;"></i> Jurnal & Presensi Guru Pengganti</h1>
            <p>Formulir pengisian materi pembelajaran dan kehadiran siswa bagi Guru Piket yang ditugaskan sebagai Guru Pengganti aktif hari ini.</p>
        </div>
        <div>
            <span style="background:rgba(255,255,255,0.15); padding:8px 16px; border-radius:20px; font-size:12.5px; font-weight:700;">
                <i class="fa-solid fa-calendar-day"></i> {{ date('d F Y', strtotime($todayDate)) }}
            </span>
        </div>
    </div>
</div>

@if($activePenugasans->isEmpty())
    <div class="card" style="background:#ffffff; padding:40px; text-align:center; border-radius:16px; border:1px solid #e2e8f0;">
        <i class="fa-solid fa-folder-open" style="font-size:48px; color:#cbd5e1; margin-bottom:16px;"></i>
        <h3 style="font-weight:800; color:#1e293b; margin-bottom:8px;">Tidak Ada Penugasan Guru Pengganti Aktif</h3>
        <p style="color:#64748b; font-size:14px; max-width:500px; margin:0 auto 20px;">
            Anda tidak sedang ditugaskan sebagai Guru Pengganti pada hari ini. Jika ada guru yang berhalangan hadir, penugasan dapat dikelola melalui menu <strong>Guru Pengganti</strong>.
        </p>
        <a href="{{ route('piket.guru-pengganti') }}" class="btn" style="background:#2563eb; color:#fff; font-weight:700; padding:10px 20px; border-radius:10px; text-decoration:none; display:inline-block;">
            <i class="fa-solid fa-user-plus"></i> Kelola Penugasan Guru Pengganti
        </a>
    </div>
@else

    {{-- Tabs Pemilihan Penugasan --}}
    @if($activePenugasans->count() > 1)
        <div class="nav-tabs-custom">
            @foreach($activePenugasans as $pTab)
                <a href="{{ route('piket.isi-jurnal-pengganti', ['id_penugasan' => $pTab->id_penugasan]) }}" 
                   class="nav-tab-item {{ ($selectedPenugasan && $selectedPenugasan->id_penugasan == $pTab->id_penugasan) ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>{{ $pTab->kelas->nama_kelas ?? 'Kelas' }} — {{ $pTab->jadwal->mapel->nama_mapel ?? ($pTab->guruTidakHadir->mapel->nama_mapel ?? 'Mapel') }}</span>
                    @if($pTab->is_diisi_hari_ini)
                        <i class="fa-solid fa-circle-check" style="color:#22c55e;"></i>
                    @elseif($pTab->hampir_habis)
                        <i class="fa-solid fa-bell fa-bounce" style="color:#ef4444;"></i>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    @if($selectedPenugasan)
        {{-- Detail Informasi Penugasan --}}
        <div class="detail-assignment-box">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                <h3 style="font-size:16px; font-weight:800; color:#0f172a; margin:0;">
                    <i class="fa-solid fa-circle-info" style="color:#2563eb;"></i> Informasi Penugasan Kelas
                </h3>
                <div>
                    @if($selectedPenugasan->is_diisi_hari_ini)
                        <span class="badge" style="background:#dcfce7; color:#15803d; font-size:12px; font-weight:800; padding:6px 12px; border-radius:20px;">
                            <i class="fa-solid fa-circle-check"></i> Jurnal Sudah Diisi
                        </span>
                    @elseif($selectedPenugasan->hampir_habis)
                        <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size:12px; font-weight:800; padding:6px 12px; border-radius:20px;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Sisa {{ max($selectedPenugasan->sisa_menit_selesai, 0) }} Menit Lagi
                        </span>
                    @elseif(!$selectedPenugasan->sudah_masuk_jam)
                        <span class="badge" style="background:#fef3c7; color:#b45309; font-size:12px; font-weight:800; padding:6px 12px; border-radius:20px;">
                            <i class="fa-solid fa-clock"></i> Belum Masuk Jam Pelajaran
                        </span>
                    @else
                        <span class="badge" style="background:#e0e7ff; color:#3730a3; font-size:12px; font-weight:800; padding:6px 12px; border-radius:20px;">
                            <i class="fa-solid fa-play"></i> Jam Pelajaran Berlangsung
                        </span>
                    @endif
                </div>
            </div>

            <div class="assignment-grid">
                <div class="assignment-info-item">
                    <div class="label">Guru Tidak Hadir</div>
                    <div class="value" style="color:#dc2626;">{{ $selectedPenugasan->guruTidakHadir->nama_guru ?? 'Guru Mengajar' }}</div>
                </div>

                <div class="assignment-info-item">
                    <div class="label">Kelas & Mata Pelajaran</div>
                    <div class="value">{{ $selectedPenugasan->kelas->nama_kelas ?? 'Kelas' }} — {{ $selectedPenugasan->jadwal->mapel->nama_mapel ?? ($selectedPenugasan->guruTidakHadir->mapel->nama_mapel ?? 'Mapel') }}</div>
                </div>

                <div class="assignment-info-item">
                    <div class="label">Jam Pelajaran & Jadwal</div>
                    <div class="value" style="color:#2563eb;">{{ $selectedPenugasan->jam_pelajaran ?? 'Sesi Pembelajaran' }}</div>
                </div>

                <div class="assignment-info-item">
                    <div class="label">Guru Pengganti (Bertugas)</div>
                    <div class="value" style="color:#16a34a;">{{ $selectedPenugasan->guruPengganti->nama_guru ?? Auth::user()->name }}</div>
                </div>
            </div>

            @if($selectedPenugasan->materi_dititipkan || $selectedPenugasan->tugas_dititipkan)
                <div style="margin-top:16px; padding:14px; background:#f8fafc; border-radius:10px; border-left:4px solid #2563eb;">
                    <div style="font-size:12px; font-weight:800; color:#3b82f6; text-transform:uppercase; margin-bottom:4px;">
                        <i class="fa-solid fa-note-sticky"></i> Titipan Materi & Tugas dari Guru Asli:
                    </div>
                    @if($selectedPenugasan->materi_dititipkan)
                        <div style="font-size:13px; color:#334155; margin-bottom:4px;"><strong>Materi:</strong> {{ $selectedPenugasan->materi_dititipkan }}</div>
                    @endif
                    @if($selectedPenugasan->tugas_dititipkan)
                        <div style="font-size:13px; color:#334155;"><strong>Tugas:</strong> {{ $selectedPenugasan->tugas_dititipkan }}</div>
                    @endif
                    @if($selectedPenugasan->file_tugas)
                        <div style="margin-top:8px;">
                            <a href="{{ asset('uploads/tugas_pengganti/' . $selectedPenugasan->file_tugas) }}" target="_blank" style="font-size:12px; font-weight:700; color:#2563eb; text-decoration:underline;">
                                <i class="fa-solid fa-paperclip"></i> Unduh Lampiran Tugas
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Banner Status Time-Gating & Notifikasi --}}
        @if(!$selectedPenugasan->sudah_masuk_jam)
            <div class="time-gate-banner time-gate-locked">
                <div style="display:flex; align-items:center; gap:14px;">
                    <i class="fa-solid fa-lock" style="font-size:24px; color:#d97706;"></i>
                    <div>
                        <div style="font-size:14px; font-weight:800; color:#92400e;">Fitur Pengisian Terkunci (Belum Memasuki Jam Pelajaran)</div>
                        <div style="font-size:12.5px; font-weight:600; color:#b45309; margin-top:2px;">
                            Sesuai aturan sistem, Jurnal Mengajar dan Presensi Siswa hanya dapat diisi pada saat pas jam pelajaran berlangsung (Dimulai pukul <strong>{{ $selectedPenugasan->waktu_mulai_effective }} WIB</strong>).
                        </div>
                    </div>
                </div>
                <span class="badge" style="background:#fef3c7; color:#92400e; font-weight:800; padding:8px 14px; border-radius:8px; white-space:nowrap;">
                    Dimulai pkl {{ $selectedPenugasan->waktu_mulai_effective }}
                </span>
            </div>
        @elseif($selectedPenugasan->hampir_habis)
            <div class="time-gate-banner time-gate-urgent">
                <div style="display:flex; align-items:center; gap:14px;">
                    <i class="fa-solid fa-bell fa-bounce" style="font-size:24px; color:#dc2626;"></i>
                    <div>
                        <div style="font-size:14px; font-weight:800; color:#991b1b;">🚨 PERINGATAN WAKTU: Tinggal {{ max($selectedPenugasan->sisa_menit_selesai, 0) }} Menit Lagi!</div>
                        <div style="font-size:12.5px; font-weight:600; color:#b91c1c; margin-top:2px;">
                            Jam pelajaran untuk kelas ini akan berakhir pukul <strong>{{ $selectedPenugasan->waktu_selesai_effective }} WIB</strong> dan Jurnal belum diisi. Segera lengkapi jurnal dan presensi siswa sekarang!
                        </div>
                    </div>
                </div>
            </div>
        @elseif($selectedPenugasan->is_diisi_hari_ini)
            <div class="time-gate-banner time-gate-completed">
                <div style="display:flex; align-items:center; gap:14px;">
                    <i class="fa-solid fa-circle-check" style="font-size:24px; color:#2563eb;"></i>
                    <div>
                        <div style="font-size:14px; font-weight:800; color:#1e40af;">Jurnal Mengajar & Presensi Telah Berhasil Disimpan</div>
                        <div style="font-size:12.5px; font-weight:600; color:#1d4ed8; margin-top:2px;">
                            Data pengisian Anda sebagai Guru Pengganti telah tercatat dan tersinkronisasi dengan sistem Guru Piket & Wali Kelas. Anda dapat memperbarui isian jika diperlukan.
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="time-gate-banner time-gate-open">
                <div style="display:flex; align-items:center; gap:14px;">
                    <i class="fa-solid fa-folder-open" style="font-size:24px; color:#16a34a;"></i>
                    <div>
                        <div style="font-size:14px; font-weight:800; color:#15803d;">Jam Pelajaran Sedang Berlangsung — Silakan Isi Jurnal</div>
                        <div style="font-size:12.5px; font-weight:600; color:#166534; margin-top:2px;">
                            Fitur pengisian jurnal dan presensi siswa aktif (Selesai pukul <strong>{{ $selectedPenugasan->waktu_selesai_effective }} WIB</strong>).
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Pengisian Jurnal & Presensi --}}
        <form action="{{ route('piket.isi-jurnal-pengganti.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_penugasan" value="{{ $selectedPenugasan->id_penugasan }}">

            {{-- Card 1: Form Jurnal Harian Mengajar --}}
            <div class="form-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-book" style="color:#2563eb;"></i>
                    <span>1. Pengisian Jurnal Mengajar (Materi & Evaluasi Pembelajaran)</span>
                </div>

                <fieldset @if(!$selectedPenugasan->sudah_masuk_jam) disabled @endif style="border:none; padding:0; margin:0;">
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; margin-bottom:16px;">
                        <div>
                            <label style="font-size:13px; font-weight:700; color:#334155; margin-bottom:6px; display:block;">
                                Pertemuan Ke- <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="pertemuan_ke" class="form-control" 
                                   value="{{ old('pertemuan_ke', $jurnalExisting->pertemuan_ke ?? 'Ke-1') }}" 
                                   placeholder="Contoh: Ke-8" required
                                   style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #cbd5e1; font-size:13.5px;">
                        </div>

                        <div>
                            <label style="font-size:13px; font-weight:700; color:#334155; margin-bottom:6px; display:block;">
                                Kondisi Kelas <span style="color:#dc2626;">*</span>
                            </label>
                            <select name="kondisi_kelas" class="form-select" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid #cbd5e1; font-size:13.5px;">
                                <option value="Kondusif" {{ old('kondisi_kelas', $jurnalExisting->kondisi_kelas ?? 'Kondusif') == 'Kondusif' ? 'selected' : '' }}>Kondusif & Tertib</option>
                                <option value="Kurang Kondusif" {{ old('kondisi_kelas', $jurnalExisting->kondisi_kelas ?? '') == 'Kurang Kondusif' ? 'selected' : '' }}>Kurang Kondusif</option>
                                <option value="Ramai" {{ old('kondisi_kelas', $jurnalExisting->kondisi_kelas ?? '') == 'Ramai' ? 'selected' : '' }}>Ramai / Perlu Pendampingan Extra</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px; font-weight:700; color:#334155; margin-bottom:6px; display:block;">
                            Materi Pembelajaran yang Disampaikan <span style="color:#dc2626;">*</span>
                        </label>
                        <textarea name="materi" rows="3" class="form-control" 
                                  placeholder="Isikan topik/materi pelajaran yang disampaikan atau tugas yang dikerjakan siswa..." 
                                  required style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid #cbd5e1; font-size:13.5px;">{{ old('materi', $jurnalExisting->materi ?? $selectedPenugasan->materi_dititipkan) }}</textarea>
                    </div>

                    <div>
                        <label style="font-size:13px; font-weight:700; color:#334155; margin-bottom:6px; display:block;">
                            Catatan Tambahan Guru Piket / Pengganti
                        </label>
                        <textarea name="catatan" rows="2" class="form-control" 
                                  placeholder="Catatan pelaksanaan pembelajaran, kedisiplinan, atau catatan kendala di kelas..." 
                                  style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid #cbd5e1; font-size:13.5px;">{{ old('catatan', $jurnalExisting->catatan ?? $selectedPenugasan->catatan) }}</textarea>
                    </div>
                </fieldset>
            </div>

            {{-- Card 2: Form Presensi Siswa --}}
            <div class="form-card">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                    <div class="form-section-title" style="margin-bottom:0; border-bottom:none; padding-bottom:0;">
                        <i class="fa-solid fa-users-check" style="color:#16a34a;"></i>
                        <span>2. Presensi Kehadiran Siswa ({{ $selectedPenugasan->kelas->nama_kelas ?? 'Kelas' }})</span>
                    </div>

                    @if($selectedPenugasan->sudah_masuk_jam)
                        <div>
                            <button type="button" class="btn-quick-fill" onclick="markAllHadir()">
                                <i class="fa-solid fa-check-double" style="color:#16a34a;"></i> Tandai Semua Hadir
                            </button>
                        </div>
                    @endif
                </div>

                <fieldset @if(!$selectedPenugasan->sudah_masuk_jam) disabled @endif style="border:none; padding:0; margin:0;">
                    <div style="overflow-x:auto;">
                        <table class="table-siswa">
                            <thead>
                                <tr>
                                    <th style="width:50px; text-align:center;">No</th>
                                    <th style="width:130px;">NIS / NISN</th>
                                    <th>Nama Siswa</th>
                                    <th style="width:80px; text-align:center;">L/P</th>
                                    <th style="width:340px;">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $idx => $siswa)
                                    @php
                                        // Cari status terdaftar di ketidakhadiran jika ada
                                        $statusExisting = 'Hadir';
                                        if ($jurnalExisting && $jurnalExisting->detailKetidakhadiran) {
                                            $det = $jurnalExisting->detailKetidakhadiran->firstWhere('id_siswa', $siswa->id_siswa);
                                            if ($det) {
                                                $statusExisting = $det->keterangan ?? 'Izin';
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td style="text-align:center; font-weight:700; color:#64748b;">{{ $idx + 1 }}</td>
                                        <td style="font-family:monospace; font-weight:700; color:#475569;">{{ $siswa->nis ?? $siswa->nisn }}</td>
                                        <td style="font-weight:700; color:#0f172a;">{{ $siswa->nama_siswa }}</td>
                                        <td style="text-align:center;">
                                            <span style="padding:2px 8px; border-radius:6px; font-size:11px; font-weight:800; background:{{ $siswa->jenis_kelamin == 'L' ? '#e0f2fe' : '#fce7f3' }}; color:{{ $siswa->jenis_kelamin == 'L' ? '#0369a1' : '#be185d' }};">
                                                {{ $siswa->jenis_kelamin }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="radio-group-attendance">
                                                <label class="radio-option" style="color:#16a34a;">
                                                    <input type="radio" name="absensi[{{ $siswa->id_siswa }}]" value="Hadir" 
                                                           class="radio-hadir" {{ $statusExisting == 'Hadir' ? 'checked' : '' }}> Hadir
                                                </label>
                                                <label class="radio-option" style="color:#d97706;">
                                                    <input type="radio" name="absensi[{{ $siswa->id_siswa }}]" value="Sakit" 
                                                           {{ $statusExisting == 'Sakit' ? 'checked' : '' }}> Sakit
                                                </label>
                                                <label class="radio-option" style="color:#2563eb;">
                                                    <input type="radio" name="absensi[{{ $siswa->id_siswa }}]" value="Izin" 
                                                           {{ $statusExisting == 'Izin' ? 'checked' : '' }}> Izin
                                                </label>
                                                <label class="radio-option" style="color:#dc2626;">
                                                    <input type="radio" name="absensi[{{ $siswa->id_siswa }}]" value="Alpa" 
                                                           {{ $statusExisting == 'Alpa' ? 'checked' : '' }}> Alpa
                                                </label>
                                                <label class="radio-option" style="color:#9333ea;">
                                                    <input type="radio" name="absensi[{{ $siswa->id_siswa }}]" value="Dispen" 
                                                           {{ $statusExisting == 'Dispen' ? 'checked' : '' }}> Dispen
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center; padding:20px; color:#64748b;">
                                            Belum ada data siswa terdaftar untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>

            {{-- Action Submit Button --}}
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <a href="{{ route('piket.dashboard') }}" class="btn" style="padding:12px 24px; background:#e2e8f0; color:#334155; font-weight:700; border-radius:12px; text-decoration:none;">
                    Batal
                </a>
                <button type="submit" class="btn" 
                        @if(!$selectedPenugasan->sudah_masuk_jam) disabled @endif
                        style="padding:12px 28px; background:{{ $selectedPenugasan->sudah_masuk_jam ? '#2563eb' : '#94a3b8' }}; color:#ffffff; font-weight:800; border-radius:12px; border:none; cursor:{{ $selectedPenugasan->sudah_masuk_jam ? 'pointer' : 'not-allowed' }}; box-shadow:0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-paper-plane"></i> Simpan Jurnal & Presensi Pengganti
                </button>
            </div>
        </form>
    @endif

@endif
@endsection

@section('scripts')
<script>
    function markAllHadir() {
        const radios = document.querySelectorAll('.radio-hadir');
        radios.forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endsection
