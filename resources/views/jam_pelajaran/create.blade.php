@extends('layouts.admin')

@section('title', 'Tambah Jam Pelajaran Baru — EDU JOURNAL')

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

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tambah Jam Pelajaran</h1>
            <p>Atur jam ke-, waktu mulai, dan waktu selesai sesi pelajaran</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('jam-pelajaran.index') }}"><i class="fa-regular fa-clock"></i> Master Jam Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Jam Pelajaran</span>
    </div>

    @if($errors->any())
        <div style="background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            <div style="display:flex; align-items:flex-start; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px; margin-top:2px;"></i>
                <div>
                    <strong style="font-weight:800;">Pengisian data belum sesuai kriteria:</strong>
                    <ul style="margin: 4px 0 0 18px; padding:0;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="create-card">
        <div class="create-header-row">
            <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Form Tambah Data Jam Pelajaran Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan sesi waktu belajar baru ke sistem.</p>
        </div>

        <form id="formTambahJam" action="{{ route('jam-pelajaran.store') }}" method="POST" onsubmit="return validateJamForm(event)">
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <label for="jam_ke">Label Jam <span style="color:#ef4444;">*</span></label>
                    <select id="jam_ke" name="jam_ke" class="form-control {{ $errors->has('jam_ke') || $errors->has('jam_ke_resolved') ? 'is-invalid' : '' }}" onchange="toggleCustomJamInput(this)" required>
                        <option value="" disabled {{ old('jam_ke') ? '' : 'selected' }}>-- Pilih Label Jam Pelajaran --</option>
                        @foreach(['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'] as $labelOpt)
                            <option value="{{ $labelOpt }}" {{ old('jam_ke') == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                        @endforeach
                        <option value="custom" {{ old('jam_ke') == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                    </select>

                    <div id="customJamKeWrapper" style="display: {{ old('jam_ke') == 'custom' ? 'block' : 'none' }}; margin-top: 8px;">
                        <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ old('jam_ke_custom') }}" class="form-control" placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                    </div>

                    @error('jam_ke')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    @error('jam_ke_resolved')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jam_mulai">Waktu Mulai <span style="color:#ef4444;">*</span></label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}"
                        class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}" required>
                    @error('jam_mulai')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jam_selesai">Waktu Selesai <span style="color:#ef4444;">*</span></label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '07:45') }}"
                        class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}" required>
                    @error('jam_selesai')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top: -4px;">
                <label for="keterangan">Keterangan / Catatan</label>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" class="form-control" placeholder="Contoh: Pembelajaran Reguler / Sholat Dzuhur">
            </div>

            <div class="form-actions">
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jam Pelajaran
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleCustomJamInput(selectElem) {
            const customWrapper = document.getElementById('customJamKeWrapper');
            const customInput = document.getElementById('jam_ke_custom');
            if (selectElem.value === 'custom') {
                customWrapper.style.display = 'block';
                customInput.setAttribute('required', 'required');
                customInput.focus();
            } else {
                customWrapper.style.display = 'none';
                customInput.removeAttribute('required');
                customInput.value = '';
            }
        }

        function validateJamForm(e) {
            const selectElem = document.getElementById('jam_ke');
            const jamKeVal = selectElem.value;
            const customVal = document.getElementById('jam_ke_custom').value.trim();
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;

            let errors = [];
            if (!jamKeVal) {
                errors.push('Label Jam wajib dipilih!');
            } else if (jamKeVal === 'custom' && !customVal) {
                errors.push('Label Jam khusus wajib diisi!');
            }

            if (!jamMulai) {
                errors.push('Waktu Mulai wajib diisi!');
            }

            if (!jamSelesai) {
                errors.push('Waktu Selesai wajib diisi!');
            }

            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                errors.push('Waktu Selesai (' + jamSelesai + ') harus lebih akhir daripada Waktu Mulai (' + jamMulai + ')!');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!jamKeVal) selectElem.focus();
                else if (jamKeVal === 'custom' && !customVal) document.getElementById('jam_ke_custom').focus();
                else if (jamMulai && jamSelesai && jamSelesai <= jamMulai) document.getElementById('jam_selesai').focus();
                return false;
            }
            return true;
        }
    </script>

@endsection
