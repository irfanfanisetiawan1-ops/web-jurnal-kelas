@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Pelajaran — EDU JOURNAL')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .form-control.input-error {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .form-hint {
        font-size: 11.5px;
        color: #94a3b8;
        font-style: italic;
        font-weight: 500;
        margin-top: 4px;
        display: block;
    }

    .form-hint-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
    }

    .btn-submit {
        background: #3b5490;
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-submit:hover { background: #2e4375; }

    .btn-reset-form {
        background: #fbbf24;
        color: #78350f;
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
        transition: all 0.2s ease;
    }
    .btn-reset-form:hover {
        background: #f59e0b;
        color: #78350f;
    }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 600;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Table & Action Buttons */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 12px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 15px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }
    .btn-lihat {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-lihat:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    .btn-edit-act {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit-act:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    .btn-hapus-act {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-hapus-act:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-trash:hover {
        background: #fde68a;
        color: #78350f;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 90%;
        max-width: 560px;
        padding: 28px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jadwal Pelajaran</h1>
            <p>Kelola penjadwalan mata pelajaran, ruang kelas, dan guru pengajar harian</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        EDU JOURNAL > <span>Manajemen Jadwal Pelajaran</span>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card 1: Tambah Jadwal secara Manual -->
    <div class="card">
        <h2>Tambah Jadwal Pelajaran Secara Manual</h2>

        <form action="{{ route('jadwal.store') }}" method="POST" id="formTambahJadwal">
            @csrf



            <div class="form-grid-3">
                <!-- Hari -->
                <div class="form-group">
                    <label for="hari">Hari <span style="color:#ef4444;">*</span></label>
                    <select id="hari" name="hari" class="form-control @error('hari') input-error @enderror" onchange="updateJamOptionsByHari()">
                        <option value="" disabled {{ old('hari') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Hari --</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    </select>
                    <span class="form-hint">Contoh saran: Senin / Jumat</span>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control @error('id_kelas') input-error @enderror">
                        <option value="" disabled {{ old('id_kelas') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: X RPL 1 / XI TKJ 2</span>
                </div>

                <!-- Guru Pengampu (NIP & Filtered Verified) -->
                <div class="form-group">
                    <label for="id_guru">Guru Pengampu <span style="color:#ef4444;">*</span></label>
                    <select id="id_guru" name="id_guru" class="form-control @error('id_guru') input-error @enderror">
                        <option value="" disabled {{ old('id_guru') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Guru (Terverifikasi) --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama_guru }} — NIP. {{ $g->nip ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Budi Santoso — NIP. 19820315...</span>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group">
                    <label for="id_mapel">Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <select id="id_mapel" name="id_mapel" class="form-control @error('id_mapel') input-error @enderror">
                        <option value="" disabled {{ old('id_mapel') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Mapel --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Matematika / Pemrograman Web</span>
                </div>

                <!-- Ruangan -->
                <div class="form-group">
                    <label for="id_ruangan">Ruangan <span style="color:#ef4444;">*</span></label>
                    <select id="id_ruangan" name="id_ruangan" class="form-control @error('id_ruangan') input-error @enderror" onchange="toggleCustomRuangan(this)">
                        <option value="" disabled {{ old('id_ruangan') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Ruangan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan') == $r->id_ruangan ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                        <option value="custom" {{ (old('id_ruangan') == 'custom' || old('nama_ruangan_custom')) ? 'selected' : '' }} style="font-weight:700; color:#2563eb;">+ Ketik Ruangan Baru (Custom)...</option>
                    </select>
                    <span class="form-hint">Contoh saran: Lab. RPL 1 / Ruang Teori 04</span>
                </div>

                <div class="form-group" id="custom_ruangan_wrapper" style="display: {{ (old('id_ruangan') == 'custom' || old('nama_ruangan_custom')) ? 'block' : 'none' }};">
                    <label for="nama_ruangan_custom" style="color:#2563eb;">Nama Ruangan Baru (Custom) <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_ruangan_custom" name="nama_ruangan_custom" value="{{ old('nama_ruangan_custom') }}" class="form-control @error('nama_ruangan_custom') input-error @enderror" placeholder="Contoh: Ruang Teori 05 / Lab. AI">
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Ruangan baru ini akan tersimpan permanen di database dan muncul di seluruh pilihan ruangan sistem.</small>
                    @error('nama_ruangan_custom')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Jam Mulai -->
                <div class="form-group">
                    <label for="id_jam_mulai">Jam Mulai (ke-) <span style="color:#ef4444;">*</span></label>
                    <select id="id_jam_mulai" name="id_jam_mulai" class="form-control @error('id_jam_mulai') input-error @enderror">
                        <option value="" disabled {{ old('id_jam_mulai') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Jam Mulai --</option>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_mulai') == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Jam Ke-1 (07:00 WIB)</span>
                </div>
            </div>

            <div class="form-group" style="max-width: 32%;">
                <label for="id_jam_selesai">Jam Selesai (ke-) <span style="color:#ef4444;">*</span></label>
                <select id="id_jam_selesai" name="id_jam_selesai" class="form-control @error('id_jam_selesai') input-error @enderror">
                    <option value="" disabled {{ old('id_jam_selesai') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Jam Selesai --</option>
                    @foreach($jamPelajarans as $jp)
                        <option value="{{ $jp->id_jam }}" {{ old('id_jam_selesai') == $jp->id_jam ? 'selected' : '' }}
                            data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                            data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                            data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                            {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                        </option>
                    @endforeach
                </select>
                <span class="form-hint">Contoh saran: Jam Ke-3 (09:00 WIB)</span>
            </div>

            <div style="display:flex; justify-content:flex-end; align-items:center; gap:12px; margin-top:16px;">
                <button type="button" class="btn-reset-form" onclick="resetTambahJadwalForm()" title="Kosongkan Isian Form" style="margin:0;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

    <!-- Card 1.25: Fitur Tambah Jadwal Pelajaran Baru via Import File (Multi-Format) -->
    <div class="card" style="border-top: 4px solid #0d9488; background: #ffffff; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.08); border-radius: 16px;">
        <div style="padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; margin-bottom: 18px;">
            <h2 style="font-size: 19px; font-weight: 800; color: #0f172a; margin:0;">
                Tambah Jadwal Pelajaran Baru via Import File
            </h2>
        </div>



        <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
        <div id="excelProcessAlert" class="alert-danger" style="display: none; margin-bottom: 20px; padding:14px 18px; border-radius:12px;">
            <div style="display:flex; align-items:flex-start; gap:12px; width: 100%;">
                <i id="excelAlertIcon" class="fa-solid fa-circle-check" style="font-size:22px; flex-shrink:0; margin-top:2px;"></i>
                <div style="flex: 1;">
                    <h4 id="excelAlertTitle" style="font-size:15px; font-weight:800; margin:0 0 4px 0;"></h4>
                    <p id="excelAlertMsg" style="margin:0; font-size:13.5px; line-height:1.5;"></p>
                    <ul id="excelAlertDetails" style="margin: 6px 0 0 18px; padding: 0; font-size: 12.5px; line-height: 1.5; display: none;"></ul>
                </div>
                <button type="button" onclick="document.getElementById('excelProcessAlert').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="importFileLoading" style="display:none; text-align:center; padding:20px; background:#f0fdfa; border-radius:12px; border:1px solid #99f6e4; margin-bottom:16px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:28px; color:#0d9488;"></i>
            <p id="importFileLoadingMsg" style="margin:10px 0 0; color:#0f766e; font-weight:700; font-size:14px;">Sedang membaca file...</p>
        </div>

        <!-- Form Import Controls Container -->
        <div class="form-grid-3" style="align-items: flex-end; background: #f8fafc; padding: 20px; border-radius: 14px; border: 1px dashed #cbd5e1;">
            <!-- 1. Pilih File -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_file_input" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Pilih File Jadwal <span style="color:#ef4444;">*</span>
                </label>
                <input type="file" id="excel_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="form-control" style="padding: 9px; background: #ffffff; cursor: pointer; border-color: #94a3b8;" onchange="onFileSelected(this)">
                <small id="importFileTypeHint" style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)
                </small>
            </div>

            <!-- 2. Pilih Kelas Target (Opsional) -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_target_kelas" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Filter Kelas Target (Opsional)
                </label>
                <select id="excel_target_kelas" onchange="syncTargetKelasToBatch(this.value)" class="form-control" style="background: #ffffff; border-color: #0284c7; font-weight: 600; color: #0369a1;">
                    <option value="">-- Baca Semua Kelas dari File --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Jika dipilih, hanya data kelas tersebut yang dimasukkan.
                </small>
            </div>

            <!-- 3. Mode Masukkan Data -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_import_mode" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Mode Masukkan Data
                </label>
                <select id="excel_import_mode" class="form-control" style="background: #ffffff; border-color: #8b5cf6; font-weight: 600; color: #6d28d9;">
                    <option value="replace">Ganti / Timpa Seluruh Baris Tabel</option>
                    <option value="append">Tambahkan ke Baris Tabel yang Ada</option>
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Pilih apakah data file menggantikan atau menambahkan baris.
                </small>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="button" onclick="clearExcelFileInput()" class="btn-reset-form" style="padding: 10px 20px; border-radius: 10px; background: #fbbf24; color: #78350f; border: 1px solid #fde68a; font-weight: 700; margin:0;">
                <i class="fa-solid fa-rotate-left"></i> Reset File
            </button>
            <button type="button" id="btnProcessExcel" onclick="processImportFile()" class="btn-submit" style="background: #3b5490; padding: 11px 24px; border-radius: 10px; font-size: 13.5px; font-weight: 700; margin:0;">
                <i class="fa-solid fa-file-import"></i> Proses &amp; Baca File
            </button>
        </div>
    </div>

    <!-- Card Baru: Tambah Jadwal Pelajaran Secara Cepat dan Banyak (Per Kelas) -->
    <div class="card" style="border: 2px solid #3b82f6; background: #ffffff;">
        <div style="margin-bottom:16px;">
            <h2 style="margin:0; color:#0f172a;">
                Tambah Jadwal Pelajaran Secara Cepat dan Banyak (Per Kelas)
            </h2>
        </div>

        <form action="{{ route('jadwal.store-batch') }}" method="POST" id="formBatchJadwal">
            @csrf



            <!-- Target Header Selection -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; margin-bottom:20px; background:#f8fafc; padding:18px; border-radius:14px; border:1px solid #e2e8f0;">
                <div class="form-group" style="margin-bottom:0;">
                    <label for="batch_id_kelas" style="color:#0f172a; font-weight:800; font-size:13.5px;">
                        Pilih Kelas Target <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="batch_id_kelas" name="id_kelas" class="form-control" style="background:#ffffff; border-color:#93c5fd; font-weight:700; color:#1e3a8a;">
                        <option value="" disabled selected style="color:#94a3b8;">-- Pilih Kelas (misal: X RPL 1) --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label for="batch_hari_utama" style="color:#0f172a; font-weight:800; font-size:13.5px;">
                        Pilih Hari Utama <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="batch_hari_utama" class="form-control" style="background:#ffffff; border-color:#93c5fd; font-weight:700; color:#1e3a8a;" onchange="applyHariUtamaToAllRows()">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>
            </div>

            <!-- Quick Action Toolbar -->
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px;">
                <button type="button" onclick="generateBatchSlots(10)" class="btn-submit" style="background:#64748b; margin:0; font-size:12.5px; padding:9px 16px;">
                    <i class="fa-solid fa-clock"></i> Generasi Slot Jam Ke-1 s/d 10 (Senin-Kamis)
                </button>
                <button type="button" onclick="generateBatchSlots(13)" class="btn-submit" style="background:#64748b; margin:0; font-size:12.5px; padding:9px 16px;">
                    <i class="fa-solid fa-clock"></i> Generasi Slot Jam Ke-1 s/d 13 (Jumat)
                </button>
                <button type="button" onclick="addBatchRow()" class="btn-submit" style="background:#64748b; margin:0; font-size:12.5px; padding:9px 16px;">
                    <i class="fa-solid fa-plus"></i> Tambah Baris Manual
                </button>
                <button type="button" onclick="clearBatchRows()" class="btn-reset-form" style="margin:0; font-size:12.5px; padding:9px 16px;">
                    <i class="fa-solid fa-trash-can"></i> Kosongkan Tabel
                </button>
            </div>

            <!-- Table of Batch Schedule Rows -->
            <div style="overflow-x: auto; border:1px solid #e2e8f0; border-radius:14px; margin-bottom:20px; background:#ffffff;">
                <table class="table-custom" style="margin-top:0;">
                    <thead>
                        <tr style="background:#f1f5f9;">
                            <th style="width: 45px; text-align:center;">NO</th>
                            <th style="width: 110px;">HARI</th>
                            <th style="width: 135px;">JAM MULAI (KE-)</th>
                            <th style="width: 135px;">JAM SELESAI (KE-)</th>
                            <th>GURU PENGAMPU <span style="color:#ef4444;">*</span></th>
                            <th>MATA PELAJARAN <span style="color:#ef4444;">*</span></th>
                            <th style="min-width:170px;">RUANGAN <span style="color:#ef4444;">*</span></th>
                            <th style="width: 100px; text-align:center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="batchTableBody">
                        <!-- Dynamic Rows Injected via JavaScript -->
                    </tbody>
                </table>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; background:#f8fafc; padding:16px; border-radius:14px; border:1px solid #e2e8f0;">
                <div style="font-size:13px; color:#475569; font-weight:600;">
                    Total Baris Siap Disimpan: <strong id="batchRowCount" style="color:#0f172a; font-size:15px;">0</strong> baris
                </div>
                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <button type="button" onclick="resetBatchAll()" class="btn-reset-form" style="margin:0; padding:12px 22px; font-size:13.5px; border-radius:12px;" title="Reset Kelas, Hari, dan Seluruh Baris Tabel Batch">
                        <i class="fa-solid fa-rotate-left"></i> Reset untuk Semua
                    </button>
                    <button type="submit" class="btn-submit" style="background:#3b5490; padding:11px 24px; font-size:13.5px; margin:0; border-radius:10px; font-weight:700;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Jadwal -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
            <h2 style="margin:0;">Daftar Jadwal Pelajaran ({{ $jadwals->total() }})</h2>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <!-- Tombol Hapus Pilihan Massal -->
                <button type="button" id="btnDeleteSelected" class="btn-aksi btn-hapus-act" style="padding:9px 18px; font-size:13px; border-radius:12px; opacity:0.55; cursor:not-allowed;" disabled onclick="confirmBulkDelete()" title="Hapus Data Jadwal Pilihan (Soft Delete)">
                    <i class="fa-solid fa-trash-can"></i> Hapus Selected (<span id="selectedDeleteCount">0</span>)
                </button>

                <a href="{{ route('jadwal.trash') }}" class="btn-trash" title="Lihat Tempat Sampah Jadwal">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah Jadwal ({{ $trashedCount ?? 0 }})
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('jadwal.index') }}" style="display:grid; grid-template-columns: 1fr 1.5fr 2fr auto; gap:12px; margin-bottom:20px; background:#f8fafc; padding:16px; border-radius:14px; border:1px solid #e2e8f0; align-items:end;">
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Filter Hari</label>
                <select name="hari" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Filter Kelas</label>
                <select name="id_kelas" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas (48 Rombel) --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Cari Guru / Mapel / Ruangan</label>
                <input type="text" name="search" class="form-control" placeholder="Ketik kata kunci pencarian..." value="{{ request('search') }}">
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" class="btn-submit" style="margin:0; padding:10px 16px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <a href="{{ route('jadwal.index') }}" class="btn-reset-form" style="margin:0; padding:10px 16px; border-radius:10px; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;" title="Reset Filter Hari, Kelas, dan Kata Kunci Pencarian">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
        </form>

        <!-- Form Massal Hapus Selected -->
        <form id="formBulkDelete" action="{{ route('jadwal.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align:center;">
                                <input type="checkbox" id="selectAllJadwal" style="width:16px; height:16px; cursor:pointer;" onclick="toggleSelectAllJadwal(this)" title="Pilih Semua di Halaman Ini">
                            </th>
                            <th>HARI</th>
                            <th>JAM PELAJARAN</th>
                            <th>KELAS</th>
                            <th>GURU (NIP)</th>
                            <th>MAPEL</th>
                            <th>RUANGAN</th>
                            <th style="min-width: 210px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $j)
                            <tr>
                                <td style="text-align:center;">
                                    <input type="checkbox" name="ids[]" value="{{ $j->id_jadwal }}" class="jadwal-checkbox" style="width:16px; height:16px; cursor:pointer;" onchange="updateSelectedCount()">
                                </td>
                                <td><strong>{{ $j->hari }}</strong></td>
                                <td>
                                    <strong>Jam ke-{{ $j->jam_range }}</strong><br>
                                    <small style="color:#3b5490; font-weight:700;">{{ $j->waktu_range }}</small>
                                </td>
                                <td><strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong></td>
                                <td>
                                    <strong>{{ $j->guru->nama_guru ?? '-' }}</strong><br>
                                    <small style="color:#64748b;">NIP: {{ $j->guru->nip ?? '-' }}</small>
                                </td>
                                <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>
                                    <div style="display:flex; gap:6px; flex-wrap:nowrap;">
                                        <!-- 1. LIHAT DETAIL -->
                                        <a href="{{ route('jadwal.show', $j->id_jadwal) }}" class="btn-aksi btn-lihat" title="Lihat Detail Jadwal Pelajaran">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>

                                        <!-- 2. EDIT -->
                                        <a href="{{ route('jadwal.edit', $j->id_jadwal) }}" class="btn-aksi btn-edit-act" title="Edit Jadwal">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS -->
                                        <button type="button" class="btn-aksi btn-hapus-act" onclick="confirmDelete('delForm-{{ $j->id_jadwal }}')" title="Hapus Jadwal">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center; padding:30px; color:#94a3b8;">
                                    Belum ada data Jadwal Pelajaran yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Separate individual delete forms outside table form to prevent form nesting -->
        @foreach($jadwals as $j)
            <form action="{{ route('jadwal.destroy', $j->id_jadwal) }}" method="POST" style="display:none;" id="delForm-{{ $j->id_jadwal }}">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <div style="margin-top: 20px;">
            {{ $jadwals->links() }}
        </div>
    </div>

    <!-- Modal Detail Jadwal Quick View -->
    <div id="modalDetailJadwal" class="modal-overlay">
        <div class="modal-card">
            <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:16px; border-bottom:1px solid #f1f5f9; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg, #2563eb, #3b82f6); color:#ffffff; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow:0 4px 12px rgba(37,99,235,0.25);">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 style="margin:0; font-size:17px; font-weight:800; color:#0f172a;" id="modalTitle">Detail Jadwal Pelajaran</h3>
                        <span style="font-size:12px; color:#64748b;" id="modalSubTitle">Informasi alokasi jadwal KBM</span>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background:none; border:none; font-size:22px; color:#64748b; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div id="modalBody" style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <!-- Content Injected via JavaScript -->
            </div>

            <div style="margin-top:24px; padding-top:16px; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; gap:8px;">
                    <a id="modalFullLink" href="#" class="btn-aksi btn-lihat" style="padding:9px 16px; font-size:12.5px; border-radius:10px;">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i> Halaman Detail Penuh
                    </a>
                    <a id="modalEditLink" href="#" class="btn-aksi btn-edit-act" style="padding:9px 16px; font-size:12.5px; border-radius:10px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background:#e2e8f0; color:#475569; padding:9px 18px; border-radius:10px; font-weight:700; border:none; cursor:pointer; font-size:13px;">Tutup</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateJamOptionsByHari() {
        const hariElem = document.getElementById('hari');
        if (!hariElem) return;
        const hariVal = hariElem.value;
        const isJumat = hariVal === 'Jumat';

        ['id_jam_mulai', 'id_jam_selesai'].forEach(selectId => {
            const selectElem = document.getElementById(selectId);
            if (!selectElem) return;

            Array.from(selectElem.options).forEach(opt => {
                if (!opt.value) return; // Skip placeholder
                const textJumat = opt.getAttribute('data-jumat');
                const textSeninKamis = opt.getAttribute('data-senin-kamis');
                const hasSeninKamis = opt.getAttribute('data-has-senin-kamis') === '1';

                if (isJumat) {
                    opt.textContent = textJumat || opt.textContent;
                    opt.disabled = false;
                } else {
                    opt.textContent = textSeninKamis || opt.textContent;
                    if (!hasSeninKamis) {
                        opt.disabled = true;
                        opt.textContent = (textSeninKamis || opt.textContent) + ' (Khusus Jumat)';
                        if (opt.selected) {
                            selectElem.value = '';
                        }
                    } else {
                        opt.disabled = false;
                    }
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateJamOptionsByHari();

        const form = document.getElementById('formTambahJadwal');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset error state
                const formControls = form.querySelectorAll('.form-control');
                formControls.forEach(c => c.classList.remove('input-error'));

                const hari         = document.getElementById('hari').value;
                const idKelas      = document.getElementById('id_kelas').value;
                const idGuru       = document.getElementById('id_guru').value;
                const idMapel      = document.getElementById('id_mapel').value;
                const idRuangan    = document.getElementById('id_ruangan').value;
                const idJamMulai   = document.getElementById('id_jam_mulai').value;
                const idJamSelesai = document.getElementById('id_jam_selesai').value;

                let missing = [];
                if (!hari) { missing.push('Hari'); document.getElementById('hari').classList.add('input-error'); }
                if (!idKelas) { missing.push('Kelas'); document.getElementById('id_kelas').classList.add('input-error'); }
                if (!idGuru) { missing.push('Guru Pengampu'); document.getElementById('id_guru').classList.add('input-error'); }
                if (!idMapel) { missing.push('Mata Pelajaran'); document.getElementById('id_mapel').classList.add('input-error'); }
                if (!idRuangan) { missing.push('Ruangan'); document.getElementById('id_ruangan').classList.add('input-error'); }
                if (!idJamMulai) { missing.push('Jam Mulai'); document.getElementById('id_jam_mulai').classList.add('input-error'); }
                if (!idJamSelesai) { missing.push('Jam Selesai'); document.getElementById('id_jam_selesai').classList.add('input-error'); }

                if (missing.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulir Belum Lengkap!',
                        html: 'Silakan lengkapi data yang belum diisi berikut:<br><br><strong style="color:#dc2626;">' + missing.join(', ') + '</strong>',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                if (parseInt(idJamSelesai) < parseInt(idJamMulai)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Pelajaran Tidak Sesuai!',
                        text: 'Jam Selesai tidak boleh lebih kecil dari Jam Mulai.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                if (hari !== 'Jumat' && (parseInt(idJamMulai) > 10 || parseInt(idJamSelesai) > 10)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Batas Jam Pelajaran Terlampaui!',
                        text: 'Untuk hari ' + hari + ', jam pelajaran maksimal adalah Jam Ke-10 (07:00 - 15:00 WIB). Jam Ke-11 s/d 13 hanya berlaku pada hari Jumat.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                // If valid, ask confirmation
                Swal.fire({
                    title: 'Konfirmasi Simpan Jadwal',
                    text: 'Apakah Anda yakin ingin menambahkan data jadwal pelajaran ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b5490',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Simpan Jadwal!',
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

    function openDetailModal(data) {
        document.getElementById('modalTitle').innerText = 'Detail Jadwal #' + data.id;
        document.getElementById('modalSubTitle').innerText = data.hari + ' | ' + data.jam;

        const dayColors = {
            'Senin': { bg: '#eff6ff', text: '#1d4ed8', border: '#bfdbfe' },
            'Selasa': { bg: '#fdf4ff', text: '#a21caf', border: '#f5d0fe' },
            'Rabu': { bg: '#ecfdf5', text: '#047857', border: '#a7f3d0' },
            'Kamis': { bg: '#fff7ed', text: '#c2410c', border: '#ffedd5' },
            'Jumat': { bg: '#f0fdf4', text: '#15803d', border: '#bbf7d0' }
        };
        const dayStyle = dayColors[data.hari] || { bg: '#f1f5f9', text: '#334155', border: '#cbd5e1' };

        const body = document.getElementById('modalBody');
        body.innerHTML = `
            <div style="background:${dayStyle.bg}; padding:14px; border-radius:12px; border:1px solid ${dayStyle.border}; grid-column:span 2;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <small style="color:${dayStyle.text}; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;">HARI & JAM KBM</small>
                        <div style="font-weight:800; font-size:16px; color:#0f172a; margin-top:2px;">${data.hari} — ${data.jam}</div>
                    </div>
                    <span style="background:${dayStyle.text}; color:#ffffff; font-weight:800; padding:4px 12px; border-radius:10px; font-size:12px;">${data.hari}</span>
                </div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-graduation-cap"></i> KELAS TARGET</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.kelas}</div>
                <div style="font-size:12px; color:#475569; margin-top:3px; font-weight:600;"><i class="fa-solid fa-user-tie"></i> Wali: ${data.wali_kelas}</div>
                ${data.jurusan && data.jurusan !== '-' ? `<div style="font-size:11.5px; color:#64748b; margin-top:2px;">Jurusan: ${data.jurusan}</div>` : ''}
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-book-bookmark"></i> MATA PELAJARAN</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.mapel}</div>
                <div style="font-size:12px; color:#2563eb; font-weight:700; margin-top:3px; font-family:monospace;">Kode: ${data.kode_mapel}</div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0; grid-column:span 2;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-chalkboard-user"></i> GURU PENGAMPU</small>
                        <div style="font-weight:800; font-size:15.5px; color:#0f172a; margin-top:4px;">${data.guru}</div>
                        <div style="font-size:12.5px; color:#475569; font-weight:600; margin-top:3px;">
                            <span style="margin-right:12px;"><i class="fa-solid fa-id-card"></i> NIP: ${data.nip}</span>
                            ${data.no_hp && data.no_hp !== '-' ? `<span><i class="fa-solid fa-phone"></i> ${data.no_hp}</span>` : ''}
                        </div>
                    </div>
                    ${data.id_guru ? `
                        <a href="/guru/${data.id_guru}" target="_blank" style="background:#e0f2fe; color:#0369a1; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                            Profil Guru <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    ` : ''}
                </div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0; grid-column:span 2;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-door-open"></i> LOKASI RUANGAN</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.ruangan}</div>
                <div style="font-size:12px; color:#64748b; margin-top:2px;">Jenis Ruangan: ${data.jenis_ruangan}</div>
            </div>
        `;

        document.getElementById('modalFullLink').setAttribute('href', data.url_show);
        document.getElementById('modalEditLink').setAttribute('href', data.url_edit);
        document.getElementById('modalDetailJadwal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailJadwal').style.display = 'none';
    }

    function toggleCustomRuangan(selectEle) {
        const wrapper = document.getElementById('custom_ruangan_wrapper');
        const customInput = document.getElementById('nama_ruangan_custom');
        if (selectEle && selectEle.value === 'custom') {
            if (wrapper) wrapper.style.display = 'block';
            if (customInput) customInput.focus();
        } else {
            if (wrapper) wrapper.style.display = 'none';
            if (customInput) customInput.value = '';
        }
    }

    function resetTambahJadwalForm() {
        const form = document.getElementById('formTambahJadwal');
        if (form) {
            form.reset();
            const ruanganSelect = document.getElementById('id_ruangan');
            if (ruanganSelect) {
                toggleCustomRuangan(ruanganSelect);
            }
            if (typeof updateJamOptionsByHari === 'function') {
                updateJamOptionsByHari();
            }
        }
    }

    function confirmDelete(formId) {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: 'Data jadwal pelajaran ini akan dipindahkan ke Tempat Sampah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    /* =========================================================================
       SCRIPT FITUR: TAMBAH JADWAL PELAJARAN SECARA CEPAT DAN BANYAK (PER KELAS)
       ========================================================================= */
    const batchGurus = @json($gurus);
    const batchMapels = @json($mapels);
    const batchRuangans = @json($ruangans);
    const batchJamPelajarans = @json($jamPelajarans);
    const batchKelases = @json($kelases);

    let batchRowCounter = 0;

    function renderEmptyBatchState() {
        const tbody = document.getElementById('batchTableBody');
        if (!tbody) return;
        if (tbody.children.length === 0) {
            tbody.innerHTML = `
                <tr id="emptyBatchRow">
                    <td colspan="8" style="text-align:center; padding:30px; color:#94a3b8; font-weight:600;">
                        <i class="fa-solid fa-list-check" style="font-size:24px; margin-bottom:8px; display:block; color:#cbd5e1;"></i>
                        Belum ada baris jadwal. Klik <strong>Generasi Slot Jam Ke-1 s/d 10 (atau 13)</strong> di atas atau <strong>+ Tambah Baris Manual</strong> untuk mulai mengisi.
                    </td>
                </tr>
            `;
        }
        updateBatchRowCount();
    }

    function updateBatchRowCount() {
        const tbody = document.getElementById('batchTableBody');
        const counterElem = document.getElementById('batchRowCount');
        if (!tbody) return;
        
        let count = tbody.querySelectorAll('tr.batch-data-row').length;
        if (counterElem) counterElem.textContent = count;
    }

    function generateBatchSlots(maxSlots) {
        clearBatchRows(false);
        const hariUtama = document.getElementById('batch_hari_utama')?.value || 'Senin';
        for (let i = 1; i <= maxSlots; i++) {
            addBatchRow(hariUtama, i, i);
        }
    }

    function addBatchRow(defaultHari = null, defaultJamMulai = 1, defaultJamSelesai = 1, initialData = {}) {
        const tbody = document.getElementById('batchTableBody');
        const emptyRow = document.getElementById('emptyBatchRow');
        if (emptyRow) emptyRow.remove();

        const hariVal = defaultHari || document.getElementById('batch_hari_utama')?.value || 'Senin';
        const rowIndex = batchRowCounter++;

        let formatJamSimple = (jamKe) => {
            if (!jamKe) return 'Jam ke-1';
            let str = String(jamKe).trim();
            str = str.replace(/^Jam\s*Ke-/i, '');
            return 'Jam ke-' + str;
        };

        const guruIdVal = initialData.id_guru || '';
        const mapelIdVal = initialData.id_mapel || '';
        const ruanganIdVal = initialData.id_ruangan || '';
        const customRuanganVal = initialData.nama_ruangan_custom || '';

        // Options HTML
        let hariOptionsHtml = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'].map(h => 
            `<option value="${h}" ${h === hariVal ? 'selected' : ''}>${h}</option>`
        ).join('');

        let jamMulaiOptionsHtml = batchJamPelajarans.map(j => 
            `<option value="${j.id_jam}" ${j.id_jam == defaultJamMulai ? 'selected' : ''}>${formatJamSimple(j.jam_ke)}</option>`
        ).join('');

        let jamSelesaiOptionsHtml = batchJamPelajarans.map(j => 
            `<option value="${j.id_jam}" ${j.id_jam == defaultJamSelesai ? 'selected' : ''}>${formatJamSimple(j.jam_ke)}</option>`
        ).join('');

        let guruOptionsHtml = `<option value="" disabled ${!guruIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Guru --</option>` +
            batchGurus.map(g => `<option value="${g.id_guru}" ${g.id_guru == guruIdVal ? 'selected' : ''}>${g.nama_guru} — NIP. ${g.nip || '-'}</option>`).join('');

        let mapelOptionsHtml = `<option value="" disabled ${!mapelIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Mapel --</option>` +
            batchMapels.map(m => `<option value="${m.id_mapel}" ${m.id_mapel == mapelIdVal ? 'selected' : ''}>${m.nama_mapel}</option>`).join('');

        let ruanganOptionsHtml = `<option value="" disabled ${!ruanganIdVal ? 'selected' : ''} style="color:#94a3b8;">-- Pilih Ruangan --</option>` +
            batchRuangans.map(r => `<option value="${r.id_ruangan}" ${r.id_ruangan == ruanganIdVal ? 'selected' : ''}>${r.nama_ruangan}</option>`).join('') +
            `<option value="custom" ${ruanganIdVal === 'custom' ? 'selected' : ''} style="font-weight:700; color:#2563eb;">+ Custom...</option>`;

        const tr = document.createElement('tr');
        tr.className = 'batch-data-row';
        tr.id = `batchRow-${rowIndex}`;
        tr.innerHTML = `
            <td style="text-align:center; font-weight:800; color:#64748b;" class="row-number">1</td>
            <td>
                <select name="items[${rowIndex}][hari]" class="form-control batch-field-hari" style="padding:6px 8px; font-size:12.5px;">
                    ${hariOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][id_jam_mulai]" class="form-control batch-field-jam-mulai" style="padding:6px 8px; font-size:12.5px;">
                    ${jamMulaiOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][id_jam_selesai]" class="form-control batch-field-jam-selesai" style="padding:6px 8px; font-size:12.5px;">
                    ${jamSelesaiOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][id_guru]" class="form-control batch-field-guru" style="padding:6px 8px; font-size:12.5px;">
                    ${guruOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][id_mapel]" class="form-control batch-field-mapel" style="padding:6px 8px; font-size:12.5px;">
                    ${mapelOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][id_ruangan]" class="form-control batch-field-ruangan" style="padding:6px 8px; font-size:12.5px;" onchange="toggleBatchCustomRuangan(this, ${rowIndex})">
                    ${ruanganOptionsHtml}
                </select>
                <div id="batch_custom_ruangan_wrapper_${rowIndex}" style="display:${ruanganIdVal === 'custom' ? 'block' : 'none'}; margin-top:4px;">
                    <input type="text" name="items[${rowIndex}][nama_ruangan_custom]" value="${customRuanganVal}" class="form-control batch-field-ruangan-custom" placeholder="Ketik nama ruangan baru..." style="padding:5px 8px; font-size:12px; border-color:#3b82f6;">
                </div>
            </td>
            <td style="text-align:center;">
                <div style="display:flex; gap:4px; justify-content:center; align-items:center;">
                    <button type="button" class="btn-aksi btn-edit-act" style="padding:5px 8px; font-size:11.5px; border-radius:8px; margin:0;" onclick="resetBatchRow(this)" title="Reset isian baris ini">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <button type="button" class="btn-aksi btn-hapus-act" style="padding:5px 8px; font-size:11.5px; border-radius:8px; margin:0;" onclick="removeBatchRow(this)" title="Hapus baris ini">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
        reindexBatchRowNumbers();
    }

    function toggleBatchCustomRuangan(selectEle, rowIndex) {
        const wrapper = document.getElementById(`batch_custom_ruangan_wrapper_${rowIndex}`);
        if (selectEle && selectEle.value === 'custom') {
            if (wrapper) wrapper.style.display = 'block';
        } else {
            if (wrapper) wrapper.style.display = 'none';
        }
    }

    function resetBatchRow(btn) {
        const tr = btn.closest('tr');
        if (!tr) return;

        const guruSelect = tr.querySelector('.batch-field-guru');
        const mapelSelect = tr.querySelector('.batch-field-mapel');
        const ruanganSelect = tr.querySelector('.batch-field-ruangan');
        const customWrapper = tr.querySelector('[id^="batch_custom_ruangan_wrapper_"]');
        const customInput = tr.querySelector('.batch-field-ruangan-custom');

        if (guruSelect) guruSelect.value = '';
        if (mapelSelect) mapelSelect.value = '';
        if (ruanganSelect) ruanganSelect.value = '';
        if (customInput) customInput.value = '';
        if (customWrapper) customWrapper.style.display = 'none';
    }

    function resetBatchAll() {
        const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');
        if (rows.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tabel Belum Berisi Data!',
                text: 'Belum ada baris tabel pengisian data yang dapat di-reset.',
                confirmButtonColor: '#3b5490'
            });
            return;
        }

        Swal.fire({
            title: 'Reset Pengisian Semua Baris Tabel?',
            text: 'Seluruh data pengisian Guru, Mapel, dan Ruangan pada semua baris tabel akan dikosongkan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#fbbf24',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Reset Semua Baris!',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
                rows.forEach(row => {
                    const guruSelect = row.querySelector('.batch-field-guru');
                    const mapelSelect = row.querySelector('.batch-field-mapel');
                    const ruanganSelect = row.querySelector('.batch-field-ruangan');
                    const customWrapper = row.querySelector('[id^="batch_custom_ruangan_wrapper_"]');
                    const customInput = row.querySelector('.batch-field-ruangan-custom');

                    if (guruSelect) guruSelect.value = '';
                    if (mapelSelect) mapelSelect.value = '';
                    if (ruanganSelect) ruanganSelect.value = '';
                    if (customInput) customInput.value = '';
                    if (customWrapper) customWrapper.style.display = 'none';
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Seluruh Pengisian Berhasil Di-reset!',
                    text: 'Data pengisian pada seluruh baris tabel telah dikosongkan.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    function removeBatchRow(btn) {
        const tr = btn.closest('tr');
        if (tr) {
            tr.remove();
            reindexBatchRowNumbers();
            renderEmptyBatchState();
        }
    }

    function clearBatchRows(confirmAlert = true) {
        if (confirmAlert) {
            const tbody = document.getElementById('batchTableBody');
            if (tbody && tbody.querySelectorAll('tr.batch-data-row').length > 0) {
                Swal.fire({
                    title: 'Kosongkan Tabel Batch?',
                    text: 'Seluruh baris isian pada tabel akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Kosongkan!',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) {
                        doClearBatchTable();
                    }
                });
                return;
            }
        }
        doClearBatchTable();
    }

    function doClearBatchTable() {
        const tbody = document.getElementById('batchTableBody');
        if (tbody) {
            tbody.innerHTML = '';
            renderEmptyBatchState();
        }
    }

    function reindexBatchRowNumbers() {
        const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');
        rows.forEach((row, idx) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) numCell.textContent = idx + 1;
        });
        updateBatchRowCount();
    }

    function applyHariUtamaToAllRows() {
        const hariVal = document.getElementById('batch_hari_utama')?.value;
        if (!hariVal) return;
        const hariSelects = document.querySelectorAll('#batchTableBody .batch-field-hari');
        hariSelects.forEach(s => s.value = hariVal);
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderEmptyBatchState();

        const formBatch = document.getElementById('formBatchJadwal');
        if (formBatch) {
            formBatch.addEventListener('submit', function(e) {
                e.preventDefault();

                const idKelas = document.getElementById('batch_id_kelas')?.value;
                const rows = document.querySelectorAll('#batchTableBody tr.batch-data-row');

                if (!idKelas) {
                    document.getElementById('batch_id_kelas')?.classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Kelas Target Belum Dipilih!',
                        text: 'Silakan pilih Kelas Target terlebih dahulu sebelum menyimpan.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                if (rows.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tabel Masih Kosong!',
                        text: 'Silakan klik "Generasi Slot Jam" atau "+ Tambah Baris Manual" untuk menambah data jadwal.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                let missingErrors = [];
                let logicErrors = [];

                rows.forEach((row, idx) => {
                    const rowNum = idx + 1;
                    const hari = row.querySelector('.batch-field-hari')?.value;
                    const jamMulai = parseInt(row.querySelector('.batch-field-jam-mulai')?.value || '0');
                    const jamSelesai = parseInt(row.querySelector('.batch-field-jam-selesai')?.value || '0');
                    const guru = row.querySelector('.batch-field-guru')?.value;
                    const mapel = row.querySelector('.batch-field-mapel')?.value;
                    const ruangan = row.querySelector('.batch-field-ruangan')?.value;
                    const customRuangan = row.querySelector('.batch-field-ruangan-custom')?.value.trim();

                    if (!guru || !mapel || !ruangan) {
                        missingErrors.push(`Baris ke-${rowNum}: Guru, Mapel, atau Ruangan belum dipilih.`);
                    }

                    if (ruangan === 'custom' && !customRuangan) {
                        missingErrors.push(`Baris ke-${rowNum}: Nama Ruangan Custom wajib diisi.`);
                    }

                    if (jamSelesai < jamMulai) {
                        logicErrors.push(`Baris ke-${rowNum}: Jam Selesai (Ke-${jamSelesai}) lebih kecil dari Jam Mulai (Ke-${jamMulai}).`);
                    }

                    if (['Senin', 'Selasa', 'Rabu', 'Kamis'].includes(hari) && (jamMulai > 10 || jamSelesai > 10)) {
                        logicErrors.push(`Baris ke-${rowNum}: Jam ke-${jamSelesai} melebihi batas Jam Ke-10 untuk hari ${hari}.`);
                    }
                });

                if (missingErrors.length > 0 || logicErrors.length > 0) {
                    const allErrList = [...missingErrors, ...logicErrors];
                    Swal.fire({
                        icon: 'error',
                        title: 'Terdapat Isian Belum Lengkap / Tidak Valid!',
                        html: '<div style="text-align:left; max-height:200px; overflow-y:auto; font-size:12.5px; color:#dc2626;"><ul style="padding-left:18px; margin:0;">' + 
                              allErrList.map(e => `<li>${e}</li>`).join('') + 
                              '</ul></div>',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                const selectKelas = document.getElementById('batch_id_kelas');
                const namaKelasText = selectKelas?.options[selectKelas.selectedIndex]?.text || 'Kelas Target';

                Swal.fire({
                    title: 'Konfirmasi Simpan Massal',
                    html: `Apakah Anda yakin ingin menyimpan <strong>${rows.length} data jadwal sekaligus</strong> untuk <strong>${namaKelasText}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Simpan Semua!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((res) => {
                    if (res.isConfirmed) {
                        formBatch.submit();
                    }
                });
            });
        }
    });

    /* =========================================================================
       SCRIPT FITUR: HAPUS PILIHAN / BULK SOFT DELETE DAFTAR JADWAL
       ========================================================================= */
    function toggleSelectAllJadwal(master) {
        const checkboxes = document.querySelectorAll('.jadwal-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.jadwal-checkbox:checked');
        const count = checkboxes.length;
        const btn = document.getElementById('btnDeleteSelected');
        const countSpan = document.getElementById('selectedDeleteCount');
        const master = document.getElementById('selectAllJadwal');

        if (countSpan) countSpan.textContent = count;

        if (btn) {
            if (count > 0) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.style.boxShadow = '0 3px 8px rgba(225,29,72,0.25)';
            } else {
                btn.disabled = true;
                btn.style.opacity = '0.55';
                btn.style.cursor = 'not-allowed';
                btn.style.boxShadow = 'none';
            }
        }

        const totalCheckboxes = document.querySelectorAll('.jadwal-checkbox');
        if (master && totalCheckboxes.length > 0) {
            master.checked = (checkboxes.length === totalCheckboxes.length);
        }
    }

    function confirmBulkDelete() {
        const checked = document.querySelectorAll('.jadwal-checkbox:checked');
        if (checked.length === 0) return;

        Swal.fire({
            title: `Hapus ${checked.length} Data Jadwal Pilihan?`,
            text: `Seluruh data jadwal yang dicentang (${checked.length} data) akan dipindahkan ke Tempat Sampah (Soft Delete).`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, Hapus ${checked.length} Data!`,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formBulkDelete').submit();
            }
        });
    }
</script>

<!-- Library SheetJS untuk membaca file Excel (.xlsx, .xls, .csv) di Sisi Client -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<!-- Library PDF.js untuk membaca file PDF di Sisi Client -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<!-- Library mammoth.js untuk membaca file Word (.docx) di Sisi Client -->
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    // Setup PDF.js worker
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    function syncTargetKelasToBatch(val) {
        const batchSelect = document.getElementById('batch_id_kelas');
        if (batchSelect && val) {
            batchSelect.value = val;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const batchSelect = document.getElementById('batch_id_kelas');
        if (batchSelect) {
            batchSelect.addEventListener('change', function() {
                const excelTargetSelect = document.getElementById('excel_target_kelas');
                if (excelTargetSelect && this.value) {
                    excelTargetSelect.value = this.value;
                }
            });
        }
    });

    // Tampilkan info tipe file yang dipilih
    function onFileSelected(input) {
        const hint = document.getElementById('importFileTypeHint');
        if (!input || !input.files || input.files.length === 0) return;
        const file = input.files[0];
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024*1024)).toFixed(2);
        let typeLabel = '';
        let typeColor = '#64748b';

        if (ext === 'pdf') {
            typeLabel = '📄 PDF Document'; typeColor = '#dc2626';
        } else if (ext === 'docx' || ext === 'doc') {
            typeLabel = '📝 Microsoft Word'; typeColor = '#1e40af';
        } else if (ext === 'xlsx' || ext === 'xls') {
            typeLabel = '📊 Microsoft Excel'; typeColor = '#15803d';
        } else if (ext === 'csv') {
            typeLabel = '📋 CSV File'; typeColor = '#0369a1';
        }

        if (hint) {
            hint.innerHTML = `<span style="color:${typeColor}; font-weight:700;">${typeLabel}</span> — Ukuran: <strong>${sizeMB < 1 ? sizeKB + ' KB' : sizeMB + ' MB'}</strong>`;
        }
    }

    function clearExcelFileInput() {
        const input = document.getElementById('excel_file_input');
        if (input) input.value = '';

        const excelTargetSelect = document.getElementById('excel_target_kelas');
        if (excelTargetSelect) excelTargetSelect.value = '';

        const excelModeSelect = document.getElementById('excel_import_mode');
        if (excelModeSelect) excelModeSelect.value = 'replace';

        const alertDiv = document.getElementById('excelProcessAlert');
        if (alertDiv) alertDiv.style.display = 'none';

        const hint = document.getElementById('importFileTypeHint');
        if (hint) hint.innerHTML = 'Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)';
    }

    function showExcelAlert(type, title, message, details = []) {
        const alertDiv = document.getElementById('excelProcessAlert');
        const alertIcon = document.getElementById('excelAlertIcon');
        const alertTitle = document.getElementById('excelAlertTitle');
        const alertMsg = document.getElementById('excelAlertMsg');
        const alertDetails = document.getElementById('excelAlertDetails');

        if (!alertDiv || !alertTitle || !alertMsg) return;

        if (type === 'success') {
            alertDiv.className = 'alert-success';
            alertDiv.style.background = '#f0fdfa';
            alertDiv.style.borderColor = '#99f6e4';
            alertDiv.style.color = '#115e59';
            alertIcon.className = 'fa-solid fa-circle-check';
            alertIcon.style.color = '#0d9488';
            alertTitle.style.color = '#0f766e';
        } else if (type === 'warning') {
            alertDiv.className = 'alert-danger';
            alertDiv.style.background = '#fffbeb';
            alertDiv.style.borderColor = '#fde68a';
            alertDiv.style.color = '#92400e';
            alertIcon.className = 'fa-solid fa-triangle-exclamation';
            alertIcon.style.color = '#f59e0b';
            alertTitle.style.color = '#78350f';
        } else {
            alertDiv.className = 'alert-danger';
            alertDiv.style.background = '#fef2f2';
            alertDiv.style.borderColor = '#fca5a5';
            alertDiv.style.color = '#991b1b';
            alertIcon.className = 'fa-solid fa-circle-exclamation';
            alertIcon.style.color = '#dc2626';
            alertTitle.style.color = '#7f1d1d';
        }

        alertTitle.textContent = title;
        alertMsg.innerHTML = message;

        if (details && details.length > 0) {
            alertDetails.innerHTML = '';
            details.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                alertDetails.appendChild(li);
            });
            alertDetails.style.display = 'block';
        } else {
            alertDetails.style.display = 'none';
        }

        alertDiv.style.display = 'flex';
    }

    function showImportLoading(msg) {
        const el = document.getElementById('importFileLoading');
        const msgEl = document.getElementById('importFileLoadingMsg');
        if (el) el.style.display = 'block';
        if (msgEl && msg) msgEl.textContent = msg;
        const btn = document.getElementById('btnProcessExcel');
        if (btn) { btn.disabled = true; btn.style.opacity = '0.6'; }
    }

    function hideImportLoading() {
        const el = document.getElementById('importFileLoading');
        if (el) el.style.display = 'none';
        const btn = document.getElementById('btnProcessExcel');
        if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
    }

    function cleanStr(s) {
        return String(s || '').toLowerCase().trim().replace(/[^a-z0-9]/g, '');
    }

    // =========================================================================
    // MAIN ENTRY POINT: Deteksi tipe file dan proses sesuai format
    // =========================================================================
    function processImportFile() {
        const fileInput = document.getElementById('excel_file_input');
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            showExcelAlert('warning', 'File Belum Dipilih!', 'Silakan pilih file jadwal pelajaran (PDF, Word, Excel, atau CSV) terlebih dahulu sebelum menekan tombol Proses.');
            return;
        }

        const file = fileInput.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();
        const maxSize = 10 * 1024 * 1024; // 10MB

        if (file.size > maxSize) {
            showExcelAlert('error', 'Ukuran File Terlalu Besar!', `Ukuran file (${(file.size / (1024*1024)).toFixed(2)} MB) melebihi batas maksimum 10MB. Silakan kompres atau pisahkan file terlebih dahulu.`);
            return;
        }

        if (ext === 'pdf') {
            processPdfFile(file, fileName);
        } else if (ext === 'docx') {
            processDocxFile(file, fileName);
        } else if (ext === 'doc') {
            processDocFile(file, fileName);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelCsvFile(file, fileName, ext);
        } else {
            showExcelAlert('error', 'Format File Tidak Didukung!', `Format file <strong>.${ext}</strong> tidak didukung. Silakan gunakan file PDF (.pdf), Word (.docx/.doc), Excel (.xlsx/.xls), atau CSV (.csv).`);
        }
    }

    // =========================================================================
    // PROSES FILE PDF
    // =========================================================================
    async function processPdfFile(file, fileName) {
        if (typeof pdfjsLib === 'undefined') {
            showExcelAlert('error', 'Library PDF.js Belum Siap!', 'Sistem sedang memuat pustaka pembaca PDF. Silakan muat ulang halaman (F5) jika masalah berlanjut.');
            return;
        }

        showImportLoading('Sedang membaca file PDF, mohon tunggu...');
        document.getElementById('excelProcessAlert').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            let allText = '';
            const totalPages = pdf.numPages;

            for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                showImportLoading(`Sedang membaca file PDF... Halaman ${pageNum}/${totalPages}`);
                const page = await pdf.getPage(pageNum);
                const textContent = await page.getTextContent();

                // Ambil teks dengan posisi untuk mendeteksi tabel
                let pageItems = textContent.items.map(item => ({
                    text: item.str,
                    x: Math.round(item.transform[4]),
                    y: Math.round(item.transform[5]),
                    width: Math.round(item.width),
                    height: Math.round(item.height)
                }));

                // Urutkan berdasarkan posisi Y (baris) lalu X (kolom)
                pageItems.sort((a, b) => b.y - a.y || a.x - b.x);

                // Kelompokkan berdasarkan baris (toleransi 8px)
                let rows = [];
                let currentRow = [];
                let lastY = null;
                const yTolerance = 8;

                for (const item of pageItems) {
                    if (lastY === null || Math.abs(item.y - lastY) <= yTolerance) {
                        currentRow.push(item);
                    } else {
                        if (currentRow.length > 0) rows.push(currentRow);
                        currentRow = [item];
                    }
                    lastY = item.y;
                }
                if (currentRow.length > 0) rows.push(currentRow);

                // Gabungkan menjadi teks per baris
                for (const row of rows) {
                    const lineText = row.map(i => i.text).join(' ').trim();
                    if (lineText) allText += lineText + '\n';
                }
                allText += '\n--- HALAMAN ' + pageNum + ' ---\n';
            }

            hideImportLoading();
            const schedules = parseTextSchedule(allText, fileName);
            applyParsedSchedules(schedules, fileName, 'PDF');

        } catch (err) {
            hideImportLoading();
            console.error('PDF Error:', err);
            showExcelAlert('error', 'Gagal Membaca File PDF!', `Terjadi kesalahan saat membaca file PDF: <strong>${err.message}</strong>. Pastikan file PDF Anda bukan PDF scan (gambar) — sistem hanya bisa membaca PDF berbasis teks.`);
        }
    }

    // =========================================================================
    // PROSES FILE WORD (.docx)
    // =========================================================================
    async function processDocxFile(file, fileName) {
        if (typeof mammoth === 'undefined') {
            showExcelAlert('error', 'Library mammoth.js Belum Siap!', 'Sistem sedang memuat pustaka pembaca Word. Silakan muat ulang halaman (F5) jika masalah berlanjut.');
            return;
        }

        showImportLoading('Sedang membaca file Word (.docx), mohon tunggu...');
        document.getElementById('excelProcessAlert').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            // Ekstrak sebagai text plain (lebih mudah untuk parsing jadwal)
            const result = await mammoth.extractRawText({ arrayBuffer });
            const rawText = result.value || '';

            hideImportLoading();

            if (!rawText.trim()) {
                showExcelAlert('error', 'Dokumen Word Kosong!', 'Dokumen Word yang dipilih tidak memiliki konten teks yang dapat dibaca. Pastikan file Word tidak terlindungi password.');
                return;
            }

            const schedules = parseTextSchedule(rawText, fileName);
            applyParsedSchedules(schedules, fileName, 'Word');

        } catch (err) {
            hideImportLoading();
            console.error('Word Error:', err);
            showExcelAlert('error', 'Gagal Membaca File Word!', `Terjadi kesalahan saat membaca file Word: <strong>${err.message}</strong>. Pastikan file menggunakan format .docx (Word 2007 ke atas) dan tidak terlindungi password.`);
        }
    }

    // =========================================================================
    // PROSES FILE WORD (.doc) — Legacy format, fallback ke raw text extract
    // =========================================================================
    function processDocFile(file, fileName) {
        showImportLoading('Sedang membaca file Word (.doc), mohon tunggu...');
        document.getElementById('excelProcessAlert').style.display = 'none';

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                // Untuk .doc (format binary lama), coba ekstrak teks mentah
                const arrayBuffer = e.target.result;
                const uint8 = new Uint8Array(arrayBuffer);
                let rawText = '';

                // Ekstrak teks ASCII dari binary DOC
                for (let i = 0; i < uint8.length; i++) {
                    const code = uint8[i];
                    if (code >= 32 && code <= 126) {
                        rawText += String.fromCharCode(code);
                    } else if (code === 10 || code === 13) {
                        rawText += '\n';
                    }
                }

                // Filter karakter yang bermanfaat
                rawText = rawText.replace(/[^\x20-\x7E\n\r\u00C0-\u024F]/g, ' ')
                                 .replace(/ {3,}/g, ' ')
                                 .replace(/\n{3,}/g, '\n\n');

                hideImportLoading();

                if (!rawText.trim() || rawText.trim().length < 50) {
                    showExcelAlert('warning', 'File .doc Mungkin Tidak Terbaca Optimal!',
                        'Format .doc (Word 97-2003) memiliki keterbatasan dalam pembacaan teks. Untuk hasil terbaik, simpan ulang file sebagai <strong>.docx</strong> atau <strong>PDF</strong> lalu coba import kembali. ' +
                        'Sistem akan mencoba membaca data yang ada...');
                }

                const schedules = parseTextSchedule(rawText, fileName);
                applyParsedSchedules(schedules, fileName, 'Word (.doc)');

            } catch (err) {
                hideImportLoading();
                console.error('DOC Error:', err);
                showExcelAlert('error', 'Gagal Membaca File .doc!',
                    `Terjadi kesalahan saat membaca file .doc. <br>Rekomendasi: Simpan ulang file sebagai <strong>.docx</strong> (Word 2007 ke atas) atau <strong>PDF</strong> lalu coba lagi.`);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    // =========================================================================
    // PROSES FILE EXCEL / CSV
    // =========================================================================
    function processExcelCsvFile(file, fileName, ext) {
        if (typeof XLSX === 'undefined') {
            showExcelAlert('error', 'Library XLSX Belum Siap!', 'Sistem sedang memuat pustaka pembaca Excel. Silakan muat ulang halaman jika masalah berlanjut.');
            return;
        }

        showImportLoading(`Sedang membaca file ${ext.toUpperCase()}, mohon tunggu...`);
        document.getElementById('excelProcessAlert').style.display = 'none';

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                const rawRowsF = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false, defval: '' });
                const rawRowsR = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: true, cellDates: true, defval: '' });

                if (!rawRowsF || rawRowsF.length === 0) {
                    hideImportLoading();
                    showExcelAlert('error', 'File Kosong!', 'File yang Anda pilih tidak memiliki baris data.');
                    return;
                }

                let headerRowIndex = -1;
                let colIndices = { hari: -1, jam_mulai: -1, jam_selesai: -1, guru: -1, mapel: -1, ruangan: -1, kelas: -1 };

                // Inspect first 20 rows to find header
                for (let i = 0; i < Math.min(rawRowsF.length, 20); i++) {
                    const row = rawRowsF[i];
                    if (!row || !Array.isArray(row)) continue;

                    let tempMap = { hari: -1, jam_mulai: -1, jam_selesai: -1, guru: -1, mapel: -1, ruangan: -1, kelas: -1 };

                    row.forEach((cell, colIdx) => {
                        const txt = cleanStr(cell);
                        if (!txt) return;

                        if (txt === 'hari' || txt.includes('day') || txt.includes('hari')) {
                            tempMap.hari = colIdx;
                        } else if (txt.includes('jammulaike') || txt.includes('jammulai') || txt.includes('jamawal') || txt.includes('startjam') || (txt.includes('jam') && txt.includes('mulai'))) {
                            tempMap.jam_mulai = colIdx;
                        } else if (txt.includes('jamselesaike') || txt.includes('jamselesai') || txt.includes('jamakhir') || txt.includes('endjam') || (txt.includes('jam') && txt.includes('selesai'))) {
                            tempMap.jam_selesai = colIdx;
                        } else if (txt.includes('guru') || txt.includes('gurupengampu') || txt.includes('namaguru') || txt === 'nip' || txt.includes('pengampu')) {
                            tempMap.guru = colIdx;
                        } else if (txt.includes('mapel') || txt.includes('matapelajaran') || txt.includes('namamapel') || txt.includes('subject') || txt.includes('pelajaran')) {
                            tempMap.mapel = colIdx;
                        } else if (txt.includes('ruang') || txt.includes('ruangan') || txt.includes('room') || txt.includes('namaruangan')) {
                            tempMap.ruangan = colIdx;
                        } else if (txt.includes('kelas') || txt.includes('namakelas') || txt.includes('targetkelas') || txt === 'class') {
                            tempMap.kelas = colIdx;
                        }
                    });

                    let matchedKeys = 0;
                    if (tempMap.hari !== -1) matchedKeys++;
                    if (tempMap.guru !== -1) matchedKeys++;
                    if (tempMap.mapel !== -1) matchedKeys++;

                    if (matchedKeys >= 1) {
                        headerRowIndex = i;
                        colIndices = tempMap;
                        break;
                    }
                }

                // Fallback column indexing
                if (headerRowIndex === -1) {
                    const sampleRow = rawRowsF[0] || [];
                    const firstCellClean = cleanStr(sampleRow[0]);
                    if (firstCellClean === 'no' || firstCellClean === '1' || firstCellClean === 'no1') {
                        colIndices = { hari: 1, jam_mulai: 2, jam_selesai: 3, guru: 4, mapel: 5, ruangan: 6, kelas: 7 };
                        headerRowIndex = 0;
                    } else {
                        colIndices = { hari: 0, jam_mulai: 1, jam_selesai: 2, guru: 3, mapel: 4, ruangan: 5, kelas: 6 };
                        headerRowIndex = -1;
                    }
                }

                const parsedSchedules = [];
                const warnings = [];

                for (let i = headerRowIndex + 1; i < rawRowsF.length; i++) {
                    const rowF = rawRowsF[i];
                    const rowR = rawRowsR[i];
                    if (!rowF || rowF.length === 0) continue;

                    const isEmptyRow = rowF.every(cell => String(cell || '').trim() === '');
                    if (isEmptyRow) continue;

                    let hariRaw       = colIndices.hari !== -1 ? String(rowF[colIndices.hari] || rowR?.[colIndices.hari] || '').trim() : '';
                    let jamMulaiRaw   = colIndices.jam_mulai !== -1 ? String(rowF[colIndices.jam_mulai] || rowR?.[colIndices.jam_mulai] || '').trim() : '';
                    let jamSelesaiRaw = colIndices.jam_selesai !== -1 ? String(rowF[colIndices.jam_selesai] || rowR?.[colIndices.jam_selesai] || '').trim() : '';
                    let guruRaw       = colIndices.guru !== -1 ? String(rowF[colIndices.guru] || rowR?.[colIndices.guru] || '').trim() : '';
                    let mapelRaw      = colIndices.mapel !== -1 ? String(rowF[colIndices.mapel] || rowR?.[colIndices.mapel] || '').trim() : '';
                    let ruanganRaw    = colIndices.ruangan !== -1 ? String(rowF[colIndices.ruangan] || rowR?.[colIndices.ruangan] || '').trim() : '';
                    let kelasRaw      = colIndices.kelas !== -1 ? String(rowF[colIndices.kelas] || rowR?.[colIndices.kelas] || '').trim() : '';

                    if (!hariRaw && !guruRaw && !mapelRaw) continue;

                    const parsed = buildScheduleItem(hariRaw, jamMulaiRaw, jamSelesaiRaw, guruRaw, mapelRaw, ruanganRaw, kelasRaw, i+1, warnings);
                    if (parsed) parsedSchedules.push(parsed);
                }

                hideImportLoading();

                if (parsedSchedules.length === 0) {
                    showExcelAlert('error', 'Tidak Ada Data Jadwal Valid!',
                        `File ${ext.toUpperCase()} yang Anda masukkan tidak mengandung data jadwal yang dapat dibaca. ` +
                        `Pastikan file memiliki kolom: HARI, JAM MULAI, JAM SELESAI, GURU, MATA PELAJARAN, RUANGAN.`);
                    return;
                }

                applyParsedSchedules(parsedSchedules, fileName, ext.toUpperCase());

            } catch(err) {
                hideImportLoading();
                console.error('Excel/CSV Error:', err);
                showExcelAlert('error', `Gagal Membaca File ${ext.toUpperCase()}!`, 'Terjadi kesalahan saat membaca file: ' + err.message);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    // =========================================================================
    // PARSE TEKS MENTAH (PDF / WORD) → Daftar Jadwal
    // Parser cerdas untuk format jadwal sekolah seperti "JADWAL KELAS SEMESTER GANJIL"
    // =========================================================================
    function parseTextSchedule(rawText, fileName) {
        const schedules = [];
        const warnings = [];
        const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 0);

        const hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        const hariPattern = /\b(senin|selasa|rabu|kamis|jumat|monday|tuesday|wednesday|thursday|friday)\b/i;
        const kelasPattern = /\b(x|xi|xii|10|11|12)\s*(tki|tkj|rpl|tkr|tsm|tav|tbsm|mm|ak|adm|dpib|bdp|otkp|aphp|agribisnis|kimia|teknik)\s*(\d+)\b/i;
        const jamPattern = /jam\s*(ke)?[-\s]?(\d+)\s*(s\/d|sd|[-–]|sampai|hingga)?\s*(\d+)?/i;
        const jamNumPattern = /^(\d{1,2})$/;

        // Coba deteksi format tabel dengan blok per kelas
        // Format: KELAS X TKI 1 → baris-baris jadwal → ...
        let currentKelas = '';
        let currentHari = '';
        let currentJamMulai = 0;
        let currentJamSelesai = 0;
        let lineIdx = 0;

        // Strategi 1: Parsing baris per baris dengan konteks
        while (lineIdx < lines.length) {
            const line = lines[lineIdx];
            const lineClean = cleanStr(line);

            // Deteksi nama kelas
            const kelasMatch = line.match(kelasPattern);
            if (kelasMatch) {
                currentKelas = kelasMatch[0].replace(/\s+/g, ' ').toUpperCase();
                // Normalize: ubah angka jadi huruf romawi
                currentKelas = currentKelas.replace(/^10\s/, 'X ').replace(/^11\s/, 'XI ').replace(/^12\s/, 'XII ');
                lineIdx++;
                continue;
            }

            // Deteksi hari
            const hariMatch = line.match(hariPattern);
            if (hariMatch && line.length < 20) {
                const h = hariMatch[1].toLowerCase();
                if (h.includes('senin') || h.includes('mon')) currentHari = 'Senin';
                else if (h.includes('selasa') || h.includes('tue')) currentHari = 'Selasa';
                else if (h.includes('rabu') || h.includes('wed')) currentHari = 'Rabu';
                else if (h.includes('kamis') || h.includes('thu')) currentHari = 'Kamis';
                else if (h.includes('jumat') || h.includes('fri')) currentHari = 'Jumat';
                lineIdx++;
                continue;
            }

            lineIdx++;
        }

        // Strategi 2: Parsing blok teks (lebih fleksibel untuk PDF jadwal sekolah)
        // Cari blok yang mengandung minimal: nama guru + nama mapel + jam/hari
        const fullText = rawText;

        // Cari semua nama guru dari database
        const guruNamesInText = [];
        for (const g of batchGurus) {
            const nameParts = g.nama_guru.split(/[\s,]+/).filter(p => p.length > 3);
            for (const part of nameParts) {
                if (fullText.toLowerCase().includes(part.toLowerCase())) {
                    guruNamesInText.push(g);
                    break;
                }
            }
        }

        // Strategi 3: Parsing paragraf/blok dengan pola jadwal
        // Format umum jadwal sekolah: RUANGAN \n MATA_PELAJARAN \n NAMA_GURU
        const blocks = fullText.split(/\n{2,}|---\s*HALAMAN/);
        let hariContext = '';
        let kelasContext = '';

        for (const block of blocks) {
            const blockLines = block.split('\n').map(l => l.trim()).filter(l => l.length > 1);
            if (blockLines.length === 0) continue;

            // Deteksi konteks hari dalam blok ini
            for (const bl of blockLines) {
                const hm = bl.match(hariPattern);
                if (hm && bl.length < 25) {
                    const h = hm[1].toLowerCase();
                    if (h.includes('senin')) hariContext = 'Senin';
                    else if (h.includes('selasa')) hariContext = 'Selasa';
                    else if (h.includes('rabu')) hariContext = 'Rabu';
                    else if (h.includes('kamis')) hariContext = 'Kamis';
                    else if (h.includes('jumat')) hariContext = 'Jumat';
                }
                // Deteksi konteks kelas dalam blok ini
                const km = bl.match(kelasPattern);
                if (km) {
                    kelasContext = km[0].replace(/\s+/g, ' ').toUpperCase();
                }
            }

            // Deteksi jam dari blok
            let jamMulaiCtx = 0, jamSelesaiCtx = 0;
            for (const bl of blockLines) {
                const jm = bl.match(jamPattern);
                if (jm) {
                    jamMulaiCtx = parseInt(jm[2] || '1');
                    jamSelesaiCtx = jm[4] ? parseInt(jm[4]) : jamMulaiCtx;
                    break;
                }
                // Pola: "1 - 3" atau "1 s/d 3" atau just "ke-1 ke-3"
                const rangeMatch = bl.match(/(\d{1,2})\s*[-–s\/d]+\s*(\d{1,2})/);
                if (rangeMatch && parseInt(rangeMatch[1]) >= 1 && parseInt(rangeMatch[1]) <= 13) {
                    jamMulaiCtx = parseInt(rangeMatch[1]);
                    jamSelesaiCtx = parseInt(rangeMatch[2]);
                    break;
                }
            }

            // Cari pasangan (guru + mapel) dalam blok
            let foundGuru = null, foundMapel = null, foundRuangan = null;

            for (const bl of blockLines) {
                // Skip baris yang hanya berisi jam/hari/kelas
                if (bl.match(/^(\d{1,2})\s*[-–]\s*(\d{1,2})$/) && bl.length < 10) continue;
                if (bl.match(hariPattern) && bl.length < 20) continue;

                // Cek apakah baris ini adalah nama guru
                if (!foundGuru) {
                    const gMatch = batchGurus.find(g => {
                        const nameParts = g.nama_guru.split(/[\s,]+/).filter(p => p.length > 3);
                        return nameParts.some(part => bl.toLowerCase().includes(part.toLowerCase()));
                    });
                    if (gMatch) { foundGuru = gMatch; continue; }
                }

                // Cek apakah baris ini adalah nama mapel
                if (!foundMapel) {
                    const mMatch = batchMapels.find(m => {
                        const nameClean = cleanStr(m.nama_mapel);
                        const blClean = cleanStr(bl);
                        return blClean.includes(nameClean) || nameClean.includes(blClean) ||
                               (blClean.length > 4 && nameClean.length > 4 && (
                                   bl.toLowerCase().includes(m.nama_mapel.toLowerCase().slice(0,6)) ||
                                   m.nama_mapel.toLowerCase().includes(bl.toLowerCase().slice(0,6))
                               ));
                    });
                    if (mMatch) { foundMapel = mMatch; continue; }
                }

                // Cek apakah baris ini adalah nama ruangan
                if (!foundRuangan) {
                    const rMatch = batchRuangans.find(r => {
                        const nameClean = cleanStr(r.nama_ruangan);
                        const blClean = cleanStr(bl);
                        return blClean.includes(nameClean) || nameClean.includes(blClean) ||
                               bl.toLowerCase().includes(r.nama_ruangan.toLowerCase().slice(0,5));
                    });
                    if (rMatch) { foundRuangan = rMatch; }
                }
            }

            // Jika kita menemukan minimal guru dan mapel, buat jadwal
            if (foundGuru && foundMapel && hariContext && jamMulaiCtx > 0) {
                // Filter berdasarkan kelas target jika dipilih
                const selectedTargetKelasEl = document.getElementById('excel_target_kelas');
                const selectedTargetKelasId = selectedTargetKelasEl ? selectedTargetKelasEl.value : '';

                // Cari id_kelas berdasarkan kelasContext
                let matchedKelasId = '';
                if (kelasContext && batchKelases) {
                    const kMatch = batchKelases.find(k => {
                        return cleanStr(k.nama_kelas).includes(cleanStr(kelasContext)) ||
                               cleanStr(kelasContext).includes(cleanStr(k.nama_kelas));
                    });
                    if (kMatch) matchedKelasId = kMatch.id_kelas;
                }

                // Filter kelas jika ada filter
                if (selectedTargetKelasId && matchedKelasId && String(selectedTargetKelasId) !== String(matchedKelasId)) {
                    // Skip, bukan kelas yang dipilih
                } else {
                    let ruanganId = foundRuangan ? foundRuangan.id_ruangan : 'custom';
                    let ruanganCustom = !foundRuangan ? (blockLines.find(bl =>
                        bl.length > 2 && !bl.match(hariPattern) && !bl.match(/^\d/) &&
                        !batchGurus.find(g => bl.toLowerCase().includes(g.nama_guru.toLowerCase().slice(0,5))) &&
                        !batchMapels.find(m => bl.toLowerCase().includes(m.nama_mapel.toLowerCase().slice(0,5)))
                    ) || '') : '';

                    schedules.push({
                        hari: hariContext || 'Senin',
                        id_jam_mulai: Math.max(1, Math.min(13, jamMulaiCtx)),
                        id_jam_selesai: Math.max(1, Math.min(13, Math.max(jamMulaiCtx, jamSelesaiCtx))),
                        id_guru: foundGuru.id_guru,
                        id_mapel: foundMapel.id_mapel,
                        id_ruangan: ruanganId,
                        nama_ruangan_custom: ruanganCustom,
                        kelas_name: kelasContext,
                        matched_kelas_id: matchedKelasId
                    });
                }
            }
        }

        // Jika tidak ada jadwal ditemukan, coba parsing lebih agresif
        if (schedules.length === 0) {
            // Parsing line-by-line dengan pattern matching sederhana
            let currentHariCtx = 'Senin';
            let currentKelasCtx = '';
            let currentJam = 1;

            for (let li = 0; li < lines.length; li++) {
                const line = lines[li];

                const hm = line.match(hariPattern);
                if (hm && line.length < 25) {
                    const h = hm[1].toLowerCase();
                    if (h.includes('senin')) currentHariCtx = 'Senin';
                    else if (h.includes('selasa')) currentHariCtx = 'Selasa';
                    else if (h.includes('rabu')) currentHariCtx = 'Rabu';
                    else if (h.includes('kamis')) currentHariCtx = 'Kamis';
                    else if (h.includes('jumat')) currentHariCtx = 'Jumat';
                    continue;
                }

                const km = line.match(kelasPattern);
                if (km) {
                    currentKelasCtx = km[0].replace(/\s+/g, ' ').toUpperCase();
                    continue;
                }

                // Cek kombinasi 2-3 baris berikutnya untuk pola (ruangan, mapel, guru) atau (mapel, guru)
                const nextLines = lines.slice(li, li + 4);
                let foundG = null, foundM = null, foundR = null;
                let jamM = currentJam, jamS = currentJam;

                for (const nl of nextLines) {
                    const jmr = nl.match(/(\d{1,2})\s*[-–s\/d]+\s*(\d{1,2})/);
                    if (jmr && parseInt(jmr[1]) >= 1 && parseInt(jmr[1]) <= 13) {
                        jamM = parseInt(jmr[1]);
                        jamS = parseInt(jmr[2]);
                    }

                    if (!foundG) {
                        const gM = batchGurus.find(g => {
                            const parts = g.nama_guru.split(/[\s,]+/).filter(p => p.length > 3);
                            return parts.some(p => nl.toLowerCase().includes(p.toLowerCase()));
                        });
                        if (gM) foundG = gM;
                    }
                    if (!foundM) {
                        const mM = batchMapels.find(m => {
                            const nameClean = m.nama_mapel.toLowerCase();
                            const nlClean = nl.toLowerCase();
                            return nlClean.includes(nameClean.slice(0, Math.min(8, nameClean.length))) ||
                                   nameClean.includes(nlClean.slice(0, Math.min(8, nlClean.length)));
                        });
                        if (mM) foundM = mM;
                    }
                    if (!foundR) {
                        const rM = batchRuangans.find(r => nl.toLowerCase().includes(r.nama_ruangan.toLowerCase().slice(0, 4)));
                        if (rM) foundR = rM;
                    }
                }

                if (foundG && foundM) {
                    schedules.push({
                        hari: currentHariCtx,
                        id_jam_mulai: Math.max(1, Math.min(13, jamM)),
                        id_jam_selesai: Math.max(1, Math.min(13, Math.max(jamM, jamS))),
                        id_guru: foundG.id_guru,
                        id_mapel: foundM.id_mapel,
                        id_ruangan: foundR ? foundR.id_ruangan : 'custom',
                        nama_ruangan_custom: foundR ? '' : (nextLines.find(nl =>
                            nl.length > 2 && !batchGurus.find(g => nl.toLowerCase().includes(g.nama_guru.toLowerCase().slice(0,5))) &&
                            !batchMapels.find(m => nl.toLowerCase().includes(m.nama_mapel.toLowerCase().slice(0,5)))
                        ) || ''),
                        kelas_name: currentKelasCtx,
                        matched_kelas_id: ''
                    });
                    li += 2; // Skip beberapa baris yang sudah dipakai
                }
            }
        }

        return schedules;
    }

    // =========================================================================
    // BUILD SCHEDULE ITEM — untuk Excel/CSV row
    // =========================================================================
    function buildScheduleItem(hariRaw, jamMulaiRaw, jamSelesaiRaw, guruRaw, mapelRaw, ruanganRaw, kelasRaw, rowNum, warnings) {
        // Parse Hari
        let hariClean = cleanStr(hariRaw);
        let hariVal = 'Senin';
        if (hariClean.includes('senin') || hariClean.includes('mon')) hariVal = 'Senin';
        else if (hariClean.includes('selasa') || hariClean.includes('tue')) hariVal = 'Selasa';
        else if (hariClean.includes('rabu') || hariClean.includes('wed')) hariVal = 'Rabu';
        else if (hariClean.includes('kamis') || hariClean.includes('thu')) hariVal = 'Kamis';
        else if (hariClean.includes('jumat') || hariClean.includes('fri')) hariVal = 'Jumat';

        // Parse Jam Mulai & Jam Selesai
        let parseJamNum = (rawStr, defaultVal = 1) => {
            if (!rawStr) return defaultVal;
            let numMatch = String(rawStr).match(/\d+/);
            return numMatch ? parseInt(numMatch[0]) : defaultVal;
        };

        let jamMulaiVal = parseJamNum(jamMulaiRaw, 1);
        let jamSelesaiVal = parseJamNum(jamSelesaiRaw, jamMulaiVal);

        if (jamMulaiRaw.includes('-') || jamMulaiRaw.includes('s/d') || jamMulaiRaw.includes('sd')) {
            let matches = jamMulaiRaw.match(/\d+/g);
            if (matches && matches.length >= 2) {
                jamMulaiVal = parseInt(matches[0]);
                jamSelesaiVal = parseInt(matches[1]);
            }
        }

        jamMulaiVal = Math.max(1, Math.min(13, jamMulaiVal));
        jamSelesaiVal = Math.max(jamMulaiVal, Math.min(13, jamSelesaiVal));

        // Match Guru
        let matchedGuruId = '';
        if (guruRaw) {
            let guruRawClean = cleanStr(guruRaw);
            let guruNipNum = guruRaw.replace(/[^0-9]/g, '');
            let gMatch = batchGurus.find(g => {
                if (guruNipNum && g.nip && g.nip.replace(/[^0-9]/g, '') === guruNipNum) return true;
                let gNameClean = cleanStr(g.nama_guru);
                return gNameClean.includes(guruRawClean) || guruRawClean.includes(gNameClean);
            });
            if (gMatch) {
                matchedGuruId = gMatch.id_guru;
            } else {
                warnings.push(`Baris ke-${rowNum}: Guru "${guruRaw}" tidak ditemukan di database Master Guru.`);
            }
        }

        // Match Mapel
        let matchedMapelId = '';
        if (mapelRaw) {
            let mapelRawClean = cleanStr(mapelRaw);
            let mMatch = batchMapels.find(m => {
                let mNameClean = cleanStr(m.nama_mapel);
                return mNameClean.includes(mapelRawClean) || mapelRawClean.includes(mNameClean);
            });
            if (mMatch) {
                matchedMapelId = mMatch.id_mapel;
            } else {
                warnings.push(`Baris ke-${rowNum}: Mata Pelajaran "${mapelRaw}" tidak ditemukan di database Master Mapel.`);
            }
        }

        // Match Ruangan
        let matchedRuanganId = '';
        let customRuanganName = '';
        if (ruanganRaw) {
            let ruanganRawClean = cleanStr(ruanganRaw);
            let rMatch = batchRuangans.find(r => {
                let rNameClean = cleanStr(r.nama_ruangan);
                return rNameClean.includes(ruanganRawClean) || ruanganRawClean.includes(rNameClean);
            });
            if (rMatch) {
                matchedRuanganId = rMatch.id_ruangan;
            } else {
                matchedRuanganId = 'custom';
                customRuanganName = ruanganRaw;
            }
        }

        return {
            hari: hariVal,
            id_jam_mulai: jamMulaiVal,
            id_jam_selesai: jamSelesaiVal,
            id_guru: matchedGuruId,
            id_mapel: matchedMapelId,
            id_ruangan: matchedRuanganId,
            nama_ruangan_custom: customRuanganName,
            kelas_name: kelasRaw
        };
    }

    // =========================================================================
    // APPLY PARSED SCHEDULES — Masukkan data ke form batch
    // =========================================================================
    function applyParsedSchedules(parsedSchedules, fileName, fileTypeLabel) {
        const warnings = [];

        if (!parsedSchedules || parsedSchedules.length === 0) {
            showExcelAlert('error', 'Tidak Ada Data Jadwal Ditemukan!',
                `Sistem tidak dapat menemukan data jadwal dari file <strong>${fileTypeLabel}</strong> yang Anda unggah. ` +
                `<br><br>Kemungkinan penyebab:` +
                `<ul style="margin:6px 0 0 18px; font-size:12.5px;">` +
                `<li>File PDF adalah hasil scan (gambar) bukan PDF berbasis teks</li>` +
                `<li>Format jadwal dalam file tidak standar atau sangat berbeda dari format yang dikenali sistem</li>` +
                `<li>Nama guru, mata pelajaran, atau ruangan di file belum terdaftar di database sistem</li>` +
                `<li>Untuk Excel/CSV: kolom tidak memiliki header yang dikenali (HARI, GURU, MAPEL, dll.)</li>` +
                `</ul>` +
                `<br><strong>Saran:</strong> Masukkan jadwal secara manual menggunakan form "Tambah Jadwal Pelajaran Secara Cepat dan Banyak" di bawah.`
            );
            return;
        }

        const mode = document.getElementById('excel_import_mode').value;
        const tbody = document.getElementById('batchTableBody');

        // Check if existing rows in batch table are empty
        let existingRows = tbody.querySelectorAll('tr.batch-data-row');
        let isAllExistingEmpty = true;
        existingRows.forEach(tr => {
            const guruVal = tr.querySelector('.batch-field-guru')?.value;
            const mapelVal = tr.querySelector('.batch-field-mapel')?.value;
            const ruanganVal = tr.querySelector('.batch-field-ruangan')?.value;
            if (guruVal || mapelVal || ruanganVal) {
                isAllExistingEmpty = false;
            }
        });

        if (mode === 'replace' || isAllExistingEmpty) {
            tbody.innerHTML = '';
            batchRowCounter = 0;
        }

        // Filter by selected class if applicable
        const selectedTargetKelasEl = document.getElementById('excel_target_kelas');
        const selectedTargetKelasId = selectedTargetKelasEl ? selectedTargetKelasEl.value : '';

        let filteredSchedules = parsedSchedules;
        if (selectedTargetKelasId) {
            // Filter hanya kelas yang dipilih
            filteredSchedules = parsedSchedules.filter(item => {
                if (item.matched_kelas_id) {
                    return String(item.matched_kelas_id) === String(selectedTargetKelasId);
                }
                // Jika tidak ada matched_kelas_id, coba cocokkan via nama kelas
                if (item.kelas_name && batchKelases) {
                    const selectedKelas = batchKelases.find(k => String(k.id_kelas) === String(selectedTargetKelasId));
                    if (selectedKelas) {
                        return cleanStr(item.kelas_name).includes(cleanStr(selectedKelas.nama_kelas)) ||
                               cleanStr(selectedKelas.nama_kelas).includes(cleanStr(item.kelas_name));
                    }
                }
                return true; // Jika tidak ada info kelas, sertakan semua
            });

            if (filteredSchedules.length === 0) {
                warnings.push(`Tidak ada data jadwal untuk kelas yang dipilih ditemukan dari file. Semua ${parsedSchedules.length} baris dari file dimasukkan.`);
                filteredSchedules = parsedSchedules;
            }
        }

        filteredSchedules.forEach(item => {
            addBatchRow(item.hari, item.id_jam_mulai, item.id_jam_selesai, item);
        });

        // Target Class Auto-Matching
        let targetKelasInfo = '';
        if (selectedTargetKelasId) {
            const batchKelasSelect = document.getElementById('batch_id_kelas');
            if (batchKelasSelect) {
                batchKelasSelect.value = selectedTargetKelasId;
                targetKelasInfo = batchKelasSelect.options[batchKelasSelect.selectedIndex]?.text || '';
            }
        } else {
            // Auto-detect kelas dari data
            let excelKelasVal = '';
            let excelKelasId = '';
            for (let item of filteredSchedules) {
                if (item.matched_kelas_id) {
                    excelKelasId = item.matched_kelas_id;
                    break;
                }
                if (item.kelas_name) {
                    excelKelasVal = item.kelas_name;
                    break;
                }
            }

            const batchKelasSelect = document.getElementById('batch_id_kelas');
            if (excelKelasId && batchKelasSelect) {
                batchKelasSelect.value = excelKelasId;
                targetKelasInfo = batchKelasSelect.options[batchKelasSelect.selectedIndex]?.text || '';
                if (selectedTargetKelasEl) selectedTargetKelasEl.value = excelKelasId;
            } else if (excelKelasVal && batchKelases && batchKelasSelect) {
                const options = Array.from(batchKelasSelect.options);
                const matchedOpt = options.find(opt => {
                    const optClean = cleanStr(opt.text);
                    const targetClean = cleanStr(excelKelasVal);
                    return optClean.includes(targetClean) || targetClean.includes(optClean);
                });
                if (matchedOpt) {
                    batchKelasSelect.value = matchedOpt.value;
                    targetKelasInfo = matchedOpt.text;
                    if (selectedTargetKelasEl) selectedTargetKelasEl.value = matchedOpt.value;
                }
            }
        }

        // Hitung statistik
        let guruMatched = filteredSchedules.filter(s => s.id_guru).length;
        let mapelMatched = filteredSchedules.filter(s => s.id_mapel).length;
        let ruanganCustom = filteredSchedules.filter(s => s.id_ruangan === 'custom').length;

        let modeLabel = (mode === 'replace' || isAllExistingEmpty)
            ? 'Menggantikan/Menimpa isi tabel'
            : 'Menambahkan ke akhir baris tabel yang ada';

        // Build warning dari data yang tidak cocok
        if (guruMatched < filteredSchedules.length) {
            warnings.push(`${filteredSchedules.length - guruMatched} baris tidak dapat mencocokkan nama guru di database — perlu dipilih manual.`);
        }
        if (mapelMatched < filteredSchedules.length) {
            warnings.push(`${filteredSchedules.length - mapelMatched} baris tidak dapat mencocokkan mata pelajaran di database — perlu dipilih manual.`);
        }
        if (ruanganCustom > 0) {
            warnings.push(`${ruanganCustom} ruangan tidak ditemukan di database — akan dibuat sebagai ruangan baru (custom) saat disimpan.`);
        }

        const msg = `Berhasil membaca <strong>${filteredSchedules.length} data jadwal pelajaran</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya otomatis ke tabel di bawah.<br>`
                  + `<small style="display:block; margin-top:5px; font-size:12px;">`
                  + `<strong>Mode:</strong> ${modeLabel}`
                  + (targetKelasInfo ? ` | <strong>Kelas Terdeteksi:</strong> ${targetKelasInfo}` : '')
                  + ` | <strong>Guru cocok:</strong> ${guruMatched}/${filteredSchedules.length}`
                  + ` | <strong>Mapel cocok:</strong> ${mapelMatched}/${filteredSchedules.length}`
                  + `</small>`;

        showExcelAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg, warnings);

        const formBatch = document.getElementById('formBatchJadwal');
        if (formBatch) {
            formBatch.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Alias untuk backward compatibility
    function processExcelFile() { processImportFile(); }
</script>
@endsection
