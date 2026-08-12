@extends('layouts.admin')

@section('title', 'Tambah Guru Baru — Jurnal ESEMKITA')

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
        <a href="{{ route('guru.index') }}"><i class="fa-solid fa-user-tie"></i> Data Guru</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Guru</span>
    </div>

    <div class="create-card">
        <div class="create-header-row">
            <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;"></i> Form Tambah Data Guru Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan data pegawai/guru baru ke sistem.</p>
        </div>

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

        <form id="formGuruCreate" action="{{ route('guru.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP (Nomor Induk Pegawai) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this);" required>
                    <small id="nipMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 18 digit angka.</small>
                    @error('nip')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_guru">Nama Lengkap Guru / Pegawai <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}"
                        class="form-control {{ $errors->has('nama_guru') ? 'is-invalid' : '' }}" placeholder="Masukkan Nama Lengkap" required>
                    @error('nama_guru')
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
                    <label for="no_hp">Nomor HP / WA</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    @error('no_hp')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_mapel">Mata Pelajaran Utama</label>
                    <select id="id_mapel" name="id_mapel" class="form-control">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Role Akun Login</label>
                    <select id="role" name="role" class="form-control">
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="tu" {{ old('role') == 'tu' ? 'selected' : '' }}>TU (Tata Usaha)</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="password">Password Akun (Opsional)</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Biarkan kosong jika tidak membuat akun login (jika diisi, minimal 6 karakter)"
                        oninput="checkPasswordMinLength(this, 'passwordMsg');">
                    <small id="passwordMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#64748b;">Opsional. Jika diisi, password wajib minimal 6 karakter.</small>
                    @error('password')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('guru.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Guru
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateNipCounter(input) {
            const counter = document.getElementById('nipCounter');
            const msgEle  = document.getElementById('nipMsg');
            const len     = input.value.length;

            if (counter) {
                counter.textContent = len + '/18 digit';
                counter.style.color = (len === 18) ? '#10b981' : '#ef4444';
            }

            if (msgEle) {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi tepat 18 digit angka.';
                    msgEle.style.color = '#ef4444';
                } else if (len < 18) {
                    msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (18 - len) + ' digit lagi).';
                    msgEle.style.color = '#ef4444';
                } else {
                    msgEle.textContent = '✓ Format NIP 18 digit angka sudah sesuai.';
                    msgEle.style.color = '#10b981';
                }
            }
        }

        function checkPasswordMinLength(input, msgId) {
            const msgEle = document.getElementById(msgId);
            if (!msgEle) return;
            const len = input.value.length;
            if (len > 0 && len < 6) {
                msgEle.textContent = 'Password terlalu pendek, baru ' + len + ' karakter (minimal 6 karakter).';
                msgEle.style.color = '#ef4444';
            } else if (len >= 6) {
                msgEle.textContent = '✓ Password memenuhi syarat (minimal 6 karakter).';
                msgEle.style.color = '#10b981';
            } else {
                msgEle.textContent = 'Opsional. Jika diisi, password wajib minimal 6 karakter.';
                msgEle.style.color = '#64748b';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nip = document.getElementById('nip');
            if (nip) updateNipCounter(nip);

            const form = document.getElementById('formGuruCreate');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    const nipVal  = document.getElementById('nip').value.trim();
                    const namaVal = document.getElementById('nama_guru').value.trim();
                    const jkVal   = document.getElementById('jenis_kelamin').value;
                    const passVal = document.getElementById('password').value;

                    if (!nipVal) {
                        errors.push('NIP wajib diisi 18 digit angka.');
                    } else if (nipVal.length !== 18) {
                        errors.push('NIP harus berisi tepat 18 digit angka (saat ini baru ' + nipVal.length + ' digit).');
                    }

                    if (!namaVal) {
                        errors.push('Nama Lengkap Guru / Pegawai wajib diisi.');
                    }

                    if (!jkVal) {
                        errors.push('Jenis Kelamin wajib dipilih (Laki-laki / Perempuan).');
                    }

                    if (passVal.length > 0 && passVal.length < 6) {
                        errors.push('Password akun minimal 6 karakter (saat ini baru ' + passVal.length + ' karakter).');
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
