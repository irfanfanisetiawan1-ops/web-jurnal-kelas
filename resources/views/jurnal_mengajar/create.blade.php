<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Jurnal Mengajar — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 50px;
        }

        .bg-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #4f46e5 100%);
            z-index: 0;
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
            transition: opacity 0.15s ease;
        }
        .back-link:hover { opacity: 0.85; }

        .card {
            background: #ffffff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(79, 70, 229, 0.35);
        }
        .card-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
        .card-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }
        label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        input[type="text"], input[type="date"], select, textarea {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            outline: none;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        textarea {
            resize: vertical;
            min-height: 90px;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .input-error {
            border-color: #ef4444 !important;
        }
        .error-message {
            font-size: 12px;
            color: #ef4444;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Section Title */
        .section-divider {
            margin: 28px 0 16px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .section-divider h3 {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-divider p {
            font-size: 12.5px;
            color: #64748b;
        }

        /* Table Presensi Siswa */
        .absence-table-wrap {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 10px;
            background: #ffffff;
        }
        .absence-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        .absence-table th {
            background: #f8fafc;
            padding: 12px 16px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        .absence-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .absence-table tr:last-child td {
            border-bottom: none;
        }

        .status-radio-group {
            display: flex;
            gap: 12px;
        }
        .status-radio-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            transition: all 0.15s ease;
        }
        .status-radio-label:hover {
            background: #f1f5f9;
        }
        .status-radio-label input[type="radio"] {
            accent-color: #4f46e5;
            cursor: pointer;
        }

        .btn-group {
            margin-top: 32px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        .btn-cancel {
            padding: 12px 22px;
            font-size: 13.5px;
            font-weight: 700;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }

        .btn-submit {
            padding: 12px 26px;
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 16px -2px rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -2px rgba(79, 70, 229, 0.45);
        }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <a href="{{ route('jurnal-mengajar.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Jurnal Mengajar
    </a>

    <div class="card">
        <div class="card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="card-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="12" y1="8" x2="12" y2="14"/><line x1="9" y1="11" x2="15" y2="11"/></svg>
                </div>
                <div class="card-title">
                    <h1>Catat Jurnal Mengajar</h1>
                    <p>Isi formulir berikut untuk mencatat aktivitas mengajar & presensi siswa ke database</p>
                </div>
            </div>
            @include('partials.live-clock')
        </div>

        <form action="{{ route('jurnal-mengajar.store') }}" method="POST" id="createForm">
            @csrf

            @if(isset($penugasanPengganti) && $penugasanPengganti)
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 16px; padding: 18px; margin-bottom: 24px; color: #1e3a8a; font-size: 13.5px; box-shadow: 0 4px 12px rgba(37,99,235,0.06);">
                    <div style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 15px; margin-bottom: 6px; color: #1d4ed8;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <span>Penugasan Guru Pengganti / Piket Aktif</span>
                    </div>
                    <p style="margin-bottom: 8px; color: #1e40af;">Anda bertugas mengisi kelas ini menggantikan <strong>{{ $penugasanPengganti->guruTidakHadir->nama_guru ?? 'Guru Utama' }}</strong> yang berhalangan hadir.</p>
                    
                    @if($penugasanPengganti->materi_dititipkan)
                        <div style="background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid #dbeafe; margin-top: 8px;">
                            <strong style="color: #1e293b;">📚 Materi Dititipkan:</strong> {{ $penugasanPengganti->materi_dititipkan }}
                        </div>
                    @endif
                    @if($penugasanPengganti->tugas_dititipkan)
                        <div style="background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid #dbeafe; margin-top: 8px;">
                            <strong style="color: #1e293b;">📝 Tugas / Instruksi Dititipkan:</strong> {{ $penugasanPengganti->tugas_dititipkan }}
                        </div>
                    @endif
                    @if($penugasanPengganti->file_tugas)
                        <div style="margin-top: 10px;">
                            <a href="{{ asset('uploads/tugas_pengganti/' . $penugasanPengganti->file_tugas) }}" target="_blank" style="color: #2563eb; font-weight: 800; text-decoration: underline; display: inline-flex; align-items: center; gap: 6px;">
                                📥 Unduh Lampiran File Tugas Dititipkan
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="form-grid">
                
                <!-- Pilih Jadwal -->
                <div class="form-group full-width">
                    <label for="id_jadwal">Jadwal Pelajaran <span class="required">*</span></label>
                    <select name="id_jadwal" id="id_jadwal" class="@error('id_jadwal') input-error @enderror" required onchange="loadSiswaByJadwal(this.value)">
                        <option value="" disabled {{ (old('id_jadwal') || isset($selectedJadwal)) ? '' : 'selected' }}>-- Pilih Jadwal Pelajaran --</option>
                        @foreach($jadwals as $j)
                            @php
                                $isSelected = (old('id_jadwal') == $j->id_jadwal) || (isset($selectedJadwal) && $selectedJadwal->id_jadwal == $j->id_jadwal);
                            @endphp
                            <option value="{{ $j->id_jadwal }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $j->hari }} ({{ $j->jam_mulai_formatted }} - {{ $j->jam_selesai_formatted }}) — {{ $j->kelas->nama_kelas ?? 'Kelas' }} | {{ $j->mapel->nama_mapel ?? 'Mapel' }} ({{ $j->guru->nama_guru ?? 'Guru' }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_jadwal')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal">Tanggal Mengajar <span class="required">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $todayDate ?? date('Y-m-d')) }}" class="@error('tanggal') input-error @enderror" required>
                    @error('tanggal')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Kehadiran Guru -->
                <div class="form-group">
                    <label for="status_kehadiran_guru">Status Kehadiran Guru <span class="required">*</span></label>
                    <select name="status_kehadiran_guru" id="status_kehadiran_guru" class="@error('status_kehadiran_guru') input-error @enderror" required>
                        @foreach($statusOptions as $st)
                            <option value="{{ $st }}" {{ old('status_kehadiran_guru', 'Hadir') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    @error('status_kehadiran_guru')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Materi Pembelajaran -->
                <div class="form-group full-width">
                    <label for="materi">Materi Pembelajaran <span class="required">*</span></label>
                    <textarea name="materi" id="materi" placeholder="Tuliskan pokok pembahasan / materi yang diajarkan..." class="@error('materi') input-error @enderror" required>{{ old('materi', isset($penugasanPengganti) ? ($penugasanPengganti->materi_dititipkan ?? '') : '') }}</textarea>
                    @error('materi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Catatan / Remarks -->
                <div class="form-group full-width">
                    <label for="catatan">Catatan / Keterangan Lainnya <small style="color: #64748b; font-weight: normal;">(Opsional)</small></label>
                    <textarea name="catatan" id="catatan" placeholder="Catatan kondisi kelas, keaktifan siswa, atau kejadian penting..." class="@error('catatan') input-error @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Ketidakhadiran Siswa Section -->
            <div class="section-divider">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Presensi & Ketidakhadiran Siswa
                </h3>
                <p>Tandai siswa yang Sakit, Izin, atau Alpa (jika ada)</p>
            </div>

            <div id="siswaPresensiContainer">
                <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 14px; padding: 24px; text-align: center; color: #64748b;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 6px; color: #94a3b8;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p style="font-size: 13.5px; font-weight: 600;">Silakan pilih <strong>Jadwal Pelajaran</strong> terlebih dahulu untuk menampilkan daftar siswa kelas.</p>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('jurnal-mengajar.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Jurnal Mengajar
                </button>
            </div>
        </form>

    </div>

</div>

<script>
    function loadSiswaByJadwal(jadwalId) {
        if (!jadwalId) return;

        const container = document.getElementById('siswaPresensiContainer');
        const tglInput = document.getElementById('tanggal');
        const tglVal = tglInput ? tglInput.value : '';

        container.innerHTML = `
            <div style="text-align:center; padding:20px; color:#6366f1;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="spin" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="10"/></svg>
                <p style="font-size:13px; font-weight:700; margin-top:8px;">Memuat data siswa & sinkronisasi surat izin...</p>
            </div>
            <style>@keyframes spin { 100% { transform: rotate(360deg); } }</style>
        `;

        fetch(`{{ url('jurnal-mengajar/api/siswa-by-jadwal') }}/${jadwalId}?tanggal=${encodeURIComponent(tglVal)}`)
            .then(res => res.json())
            .then(data => {
                if (!data.siswas || data.siswas.length === 0) {
                    container.innerHTML = `
                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 14px; padding: 18px; text-align: center; color: #b45309;">
                            <p style="font-size: 13.5px; font-weight: 700;">Tidak ada data siswa terdaftar di kelas ini (${data.kelas || '-'}).</p>
                        </div>
                    `;
                    return;
                }

                let html = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size:13px; font-weight:700; color:#334155;">Daftar Siswa Kelas: <strong>${data.kelas}</strong> (${data.siswas.length} Siswa)</span>
                        <small style="color:#64748b;">Default: Hadir (Auto-Sync Surat Izin Guru Piket Aktif)</small>
                    </div>
                    <div class="absence-table-wrap">
                        <table class="absence-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">NO</th>
                                    <th>NISN</th>
                                    <th>NAMA SISWA</th>
                                    <th style="text-align: right;">STATUS PRESENSI</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                data.siswas.forEach((siswa, idx) => {
                    const defStatus = siswa.default_status || 'Hadir';
                    const isAuto = siswa.is_auto_izin;
                    const ketIzin = siswa.keterangan_izin;

                    html += `
                        <tr style="${isAuto ? 'background: #fcfaff;' : ''}">
                            <td style="font-weight:700; color:#94a3b8;">${idx + 1}</td>
                            <td style="font-weight:600; color:#64748b;">${siswa.nisn}</td>
                            <td style="font-weight:700; color:#0f172a;">
                                <div>${siswa.nama_siswa}</div>
                                ${isAuto ? `<div style="font-size: 11px; color: #7c3aed; font-weight: 700; margin-top: 2px;"><i class="fa-solid fa-circle-check"></i> ${ketIzin}</div>` : ''}
                            </td>
                            <td style="text-align: right;">
                                <div class="status-radio-group" style="justify-content: flex-end;">
                                    <label class="status-radio-label">
                                        <input type="radio" name="siswa_status_${siswa.id_siswa}" value="Hadir" ${defStatus === 'Hadir' ? 'checked' : ''} onchange="toggleKetidakhadiranInput(${idx}, ${siswa.id_siswa}, 'Hadir')">
                                        <span style="color:#15803d;">Hadir</span>
                                    </label>
                                    <label class="status-radio-label">
                                        <input type="radio" name="siswa_status_${siswa.id_siswa}" value="Sakit" ${defStatus === 'Sakit' ? 'checked' : ''} onchange="toggleKetidakhadiranInput(${idx}, ${siswa.id_siswa}, 'Sakit')">
                                        <span style="color:#1d4ed8;">Sakit</span>
                                    </label>
                                    <label class="status-radio-label">
                                        <input type="radio" name="siswa_status_${siswa.id_siswa}" value="Izin" ${defStatus === 'Izin' ? 'checked' : ''} onchange="toggleKetidakhadiranInput(${idx}, ${siswa.id_siswa}, 'Izin')">
                                        <span style="color:#d97706;">Izin</span>
                                    </label>
                                    <label class="status-radio-label">
                                        <input type="radio" name="siswa_status_${siswa.id_siswa}" value="Alpa" ${defStatus === 'Alpa' ? 'checked' : ''} onchange="toggleKetidakhadiranInput(${idx}, ${siswa.id_siswa}, 'Alpa')">
                                        <span style="color:#e11d48;">Alpa</span>
                                    </label>
                                </div>
                                <div id="input_wrap_${siswa.id_siswa}">
                                    ${defStatus !== 'Hadir' ? `
                                        <input type="hidden" name="ketidakhadiran[${siswa.id_siswa}][id_siswa]" value="${siswa.id_siswa}">
                                        <input type="hidden" name="ketidakhadiran[${siswa.id_siswa}][keterangan]" value="${defStatus}">
                                    ` : ''}
                                </div>
                            </td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                container.innerHTML = html;
            })
            .catch(err => {
                container.innerHTML = `
                    <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 14px; padding: 18px; text-align: center; color: #e11d48;">
                        <p style="font-size: 13.5px; font-weight: 700;">Gagal memuat data siswa. Pastikan server terhubung.</p>
                    </div>
                `;
            });
    }

    function toggleKetidakhadiranInput(idx, idSiswa, status) {
        const wrap = document.getElementById(`input_wrap_${idSiswa}`);
        if (!wrap) return;

        if (status === 'Hadir') {
            wrap.innerHTML = '';
        } else {
            wrap.innerHTML = `
                <input type="hidden" name="ketidakhadiran[${idSiswa}][id_siswa]" value="${idSiswa}">
                <input type="hidden" name="ketidakhadiran[${idSiswa}][keterangan]" value="${status}">
            `;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialJadwalId = document.getElementById('id_jadwal').value;
        if (initialJadwalId) {
            loadSiswaByJadwal(initialJadwalId);
        }

        const tglInput = document.getElementById('tanggal');
        if (tglInput) {
            tglInput.addEventListener('change', function() {
                const jId = document.getElementById('id_jadwal').value;
                if (jId) {
                    loadSiswaByJadwal(jId);
                }
            });
        }

        const form = document.getElementById('createForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Tambah Jurnal',
                    text: 'Apakah Anda yakin ingin menyimpan data jurnal mengajar ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
</script>

</body>
</html>
