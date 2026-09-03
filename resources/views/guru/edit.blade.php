@extends('layouts.admin')

@section('title', 'Edit Guru — ' . $guru->nama_guru)

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
            <h1>Edit Data Guru</h1>
            <p>Perbarui informasi profil, NIP, dan kepegawaian guru</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('guru.index') }}"><i class="fa-solid fa-user-tie"></i> Data Guru</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Guru</span>
    </div>

    <div class="edit-card">
        <div class="edit-header-row">
            <div>
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Guru</h2>
                <p>Sedang mengedit data: <strong style="color:#0f172a;">{{ $guru->nama_guru }}</strong> (NIP: {{ $guru->nip }})</p>
            </div>
            <a href="{{ route('guru.show', $guru->id_guru) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form id="editForm" action="{{ route('guru.update', $guru->id_guru) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP (Nomor Induk Pegawai) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #64748b;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}"
                        class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this);" required>
                    @error('nip')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_guru">Nama Lengkap Guru / Pegawai <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}"
                        class="form-control {{ $errors->has('nama_guru') ? 'is-invalid' : '' }}" required>
                    @error('nama_guru')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP / WA <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}"
                        class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 081234567890" maxlength="15" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);" required>
                    @error('no_hp')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="id_mapel">Mata Pelajaran Utama</label>
                    <select id="id_mapel" name="id_mapel" class="form-control">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel', $guru->id_mapel) == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('guru.index') }}" class="btn-cancel">
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
            <p>Apakah Anda yakin ingin memperbarui data guru <strong style="color:#0f172a;">{{ $guru->nama_guru }}</strong>?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeConfirmModal()">Periksa Lagi</button>
                <button type="button" class="btn-m-confirm" onclick="submitForm()">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <script>
        function updateNipCounter(input) {
            const counter = document.getElementById('nipCounter');
            if (!counter) return;
            const len = input.value.length;
            counter.textContent = len + '/18 digit';
            if (len === 18) {
                counter.style.color = '#10b981';
            } else {
                counter.style.color = '#ef4444';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nipInput = document.getElementById('nip');
            if (nipInput) updateNipCounter(nipInput);
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
