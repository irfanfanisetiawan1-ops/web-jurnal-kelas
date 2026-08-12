@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru — Jurnal ESEMKITA')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text a {
        color: #3b5490;
        text-decoration: none;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .create-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .create-header-row {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .create-header-row h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .create-header-row p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 18px;
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
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .error-msg {
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-save {
        background: linear-gradient(135deg, #2563eb, #3b5490);
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('siswa.index') }}"><i class="fa-solid fa-graduation-cap"></i> Data Siswa</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Siswa</span>
    </div>

    <div class="create-card">
        <div class="create-header-row">
            <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;"></i> Form Tambah Data Siswa Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan data siswa baru ke sistem.</p>
        </div>

        <!-- Alert Banner Alasan Gagal Simpan (JS Generated) -->
        <div id="formErrorReasonBanner" class="alert-custom alert-error" style="display: none; margin-bottom: 20px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:22px; color:#dc2626; flex-shrink:0; margin-top:2px;"></i>
                <div>
                    <h4 style="font-size:15px; font-weight:800; margin:0 0 4px 0; color:#9f1239;">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                    <ul id="formErrorReasonList" style="margin: 4px 0 0 18px; padding: 0; font-size: 13.5px; color: #881337; line-height: 1.6;"></ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('formErrorReasonBanner').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="formSiswaCreate" action="{{ route('siswa.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nis" style="margin-bottom: 0;">NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span></label>
                        <span id="nisCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                        class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 2122100001" maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisCounter', 10, 'nisMsg');"
                        required>
                    <small id="nisMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 10 digit angka.</small>
                    @error('nis')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nisn" style="margin-bottom: 0;">NISN <span style="color:#ef4444;">*</span></label>
                        <span id="nisnCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                        class="form-control {{ $errors->has('nisn') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 0051234567" maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisnCounter', 10, 'nisnMsg');"
                        required>
                    <small id="nisnMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 10 digit angka.</small>
                    @error('nisn')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}"
                        class="form-control {{ $errors->has('nama_siswa') ? 'is-invalid' : '' }}"
                        placeholder="Nama Lengkap Siswa" required>
                    @error('nama_siswa')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control {{ $errors->has('id_kelas') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelass as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kota_lahir">Kota Lahir</label>
                    <input type="text" id="kota_lahir" name="kota_lahir" value="{{ old('kota_lahir') }}" class="form-control" placeholder="Tempat Lahir">
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="alamat_lengkap">Alamat Lengkap</label>
                    <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap Siswa">{{ old('alamat_lengkap') }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('siswa.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateDigitCounter(input, counterId, targetLen, msgId) {
            const counter = document.getElementById(counterId);
            const msgEle  = document.getElementById(msgId);
            const len     = input.value.length;

            if (counter) {
                counter.textContent = len + '/' + targetLen + ' digit';
                counter.style.color = (len === targetLen) ? '#10b981' : '#ef4444';
            }

            if (msgEle) {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                    msgEle.style.color = '#ef4444';
                } else if (len < targetLen) {
                    msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                    msgEle.style.color = '#ef4444';
                } else {
                    msgEle.textContent = '✓ Format ' + targetLen + ' digit angka sudah sesuai.';
                    msgEle.style.color = '#10b981';
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nis  = document.getElementById('nis');
            const nisn = document.getElementById('nisn');
            if (nis)  updateDigitCounter(nis, 'nisCounter', 10, 'nisMsg');
            if (nisn) updateDigitCounter(nisn, 'nisnCounter', 10, 'nisnMsg');

            const form = document.getElementById('formSiswaCreate');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    const nisVal  = document.getElementById('nis').value.trim();
                    const nisnVal = document.getElementById('nisn').value.trim();
                    const namaVal = document.getElementById('nama_siswa').value.trim();
                    const jkVal   = document.getElementById('jenis_kelamin').value;
                    const klsVal  = document.getElementById('id_kelas').value;

                    if (!nisVal) {
                        errors.push('NIS wajib diisi 10 digit angka.');
                    } else if (nisVal.length !== 10) {
                        errors.push('NIS harus berisi tepat 10 digit angka (saat ini baru ' + nisVal.length + ' digit).');
                    }

                    if (!nisnVal) {
                        errors.push('NISN wajib diisi 10 digit angka.');
                    } else if (nisnVal.length !== 10) {
                        errors.push('NISN harus berisi tepat 10 digit angka (saat ini baru ' + nisnVal.length + ' digit).');
                    }

                    if (!namaVal) {
                        errors.push('Nama Lengkap Siswa wajib diisi.');
                    }

                    if (!jkVal) {
                        errors.push('Jenis Kelamin wajib dipilih (Laki-laki / Perempuan).');
                    }

                    if (!klsVal) {
                        errors.push('Kelas bimbingan siswa wajib dipilih.');
                    }

                    const banner = document.getElementById('formErrorReasonBanner');
                    const list   = document.getElementById('formErrorReasonList');

                    if (errors.length > 0) {
                        e.preventDefault();
                        list.innerHTML = '';
                        errors.forEach(function(err) {
                            const li = document.createElement('li');
                            li.textContent = err;
                            list.appendChild(li);
                        });
                        banner.style.display = 'flex';
                        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        banner.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
