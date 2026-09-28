@extends('layouts.admin')

@section('title', 'Edit Siswa — ' . $siswa->nama_siswa)

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

    .edit-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .edit-header-row {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .edit-header-row h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .edit-header-row p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 18px;
        min-width: 0;
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
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
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

    .btn-update {
        background: linear-gradient(135deg, #d97706, #f59e0b);
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
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        transition: all 0.2s ease;
    }
    .btn-update:hover {
        opacity: 0.92;
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

    /* Modal Overlay */
    .modal-bg {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-bg.active { display: flex; }
    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    .modal-icon-wrap {
        width: 52px;
        height: 52px;
        background: #fef3c7;
        color: #d97706;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }
    .modal-box h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
    .modal-box p { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 12px; }
    .btn-m-cancel {
        flex: 1;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
    }
    .btn-m-confirm {
        flex: 1;
        background: linear-gradient(135deg, #d97706, #f59e0b);
        color: #ffffff;
        border: none;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Edit Data Siswa</h1>
            <p>Perbarui informasi profil, kelas, dan status data siswa</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('siswa.index') }}"><i class="fa-solid fa-graduation-cap"></i> Data Siswa</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Siswa</span>
    </div>

    <div class="edit-card">
        <div class="edit-header-row">
            <div>
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Siswa</h2>
                <p>Sedang mengedit data: <strong style="color:#0f172a;">{{ $siswa->nama_siswa }}</strong> (NISN: {{ $siswa->nisn }})</p>
            </div>
            <a href="{{ route('siswa.show', $siswa->id_siswa) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form id="editForm" action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nis" style="margin-bottom: 0;">NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span></label>
                        <span id="nisCounter" style="font-size: 12px; font-weight: 700; color: #64748b;">0/10 digit</span>
                    </div>
                    <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}"
                        class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 123 atau 2122100001" maxlength="10" minlength="3" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisCounter', true);"
                        required>
                    @error('nis')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nisn" style="margin-bottom: 0;">NISN <span style="color:#ef4444;">*</span></label>
                        <span id="nisnCounter" style="font-size: 12px; font-weight: 700; color: #64748b;">0/10 digit</span>
                    </div>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                        placeholder="Contoh: 0051234567"
                        class="form-control {{ $errors->has('nisn') ? 'is-invalid' : '' }}"
                        maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisnCounter');"
                        required>
                    @error('nisn')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                        class="form-control {{ $errors->has('nama_siswa') ? 'is-invalid' : '' }}" required>
                    @error('nama_siswa')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
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
                            <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas', $siswa->id_kelas) == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kota_lahir">Kota Lahir <span style="color:#64748b; font-size:11px; font-weight:600;">(Opsional)</span></label>
                    <input type="text" id="kota_lahir" name="kota_lahir" value="{{ old('kota_lahir', $siswa->kota_lahir) }}"
                        class="form-control {{ $errors->has('kota_lahir') ? 'is-invalid' : '' }}"
                        placeholder="Kota/Tempat Lahir (boleh dikosongkan)">
                    <small style="font-size:11.5px; color:#94a3b8; margin-top:3px; display:block;"><i class="fa-solid fa-circle-info"></i> Opsional — boleh tidak diisi jika belum diketahui.</small>
                    @error('kota_lahir')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span style="color:#ef4444;">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                        class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" required>
                    @error('tanggal_lahir')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="alamat_lengkap">Alamat Lengkap <span style="color:#64748b; font-size:11px; font-weight:600;">(Opsional)</span></label>
                    <textarea id="alamat_lengkap" name="alamat_lengkap"
                        class="form-control {{ $errors->has('alamat_lengkap') ? 'is-invalid' : '' }}"
                        rows="3" placeholder="Masukkan Alamat Lengkap Siswa (boleh dikosongkan)">{{ old('alamat_lengkap', $siswa->alamat_lengkap) }}</textarea>
                    <small style="font-size:11.5px; color:#94a3b8; margin-top:3px; display:block;"><i class="fa-solid fa-circle-info"></i> Opsional — boleh tidak diisi jika belum diketahui.</small>
                    @error('alamat_lengkap')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('siswa.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="button" class="btn-update" onclick="openConfirmModal()">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Confirm -->
    <div class="modal-bg" id="modalConfirm">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <h3>Simpan Perubahan?</h3>
            <p>Apakah Anda yakin ingin memperbarui data siswa <strong style="color:#0f172a;">{{ $siswa->nama_siswa }}</strong>?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeConfirmModal()">Periksa Lagi</button>
                <button type="button" class="btn-m-confirm" onclick="submitForm()">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <script>
        function updateDigitCounter(input, counterId, isNis = false) {
            const counter = document.getElementById(counterId);
            if (!counter) return;
            const len = input.value.length;
            counter.textContent = len + '/10 digit';
            if (isNis) {
                // NIS valid: 3-10 digit
                counter.style.color = (len >= 3 && len <= 10) ? '#10b981' : '#ef4444';
            } else {
                counter.style.color = (len === 10) ? '#10b981' : '#ef4444';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nisInput = document.getElementById('nis');
            const nisnInput = document.getElementById('nisn');
            if (nisInput) updateDigitCounter(nisInput, 'nisCounter', true);
            if (nisnInput) updateDigitCounter(nisnInput, 'nisnCounter');
        });

        function openConfirmModal() {
            const form = document.getElementById('editForm');
            if (!form.checkValidity()) { form.reportValidity(); return; }
            document.getElementById('modalConfirm').classList.add('active');
        }

        function closeConfirmModal() {
            document.getElementById('modalConfirm').classList.remove('active');
        }

        function submitForm() {
            document.getElementById('editForm').submit();
        }

        document.getElementById('modalConfirm').addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });
    </script>

@endsection
