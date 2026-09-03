@extends('layouts.admin')

@section('title', 'Tambah Kelas Baru — EDU JOURNAL')

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

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Tambah Kelas Baru</h1>
            <p>Buat rombongan belajar baru untuk tahun ajaran aktif</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('kelas.index') }}"><i class="fa-solid fa-school"></i> Data Kelas</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Kelas</span>
    </div>

    <div class="create-card">
        <div class="create-header-row">
            <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Form Tambah Data Kelas Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan rombongan belajar baru ke sistem.</p>
        </div>

        <form id="formTambahKelasCreate" action="{{ route('kelas.store') }}" method="POST" onsubmit="return validateKelasFormCreate(event)">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}"
                        class="form-control {{ $errors->has('nama_kelas') ? 'is-invalid' : '' }}" placeholder="Contoh: X RPL 1" required>
                    @error('nama_kelas')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_jurusan">Jurusan <span style="color:#ef4444;">*</span></label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control {{ $errors->has('id_jurusan') ? 'is-invalid' : '' }}" onchange="toggleCustomJurusan(this)" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}" {{ old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }} ({{ $j->kode_jurusan ?? '-' }})
                            </option>
                        @endforeach
                        <option value="custom" {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'selected' : '' }} style="font-weight:700; color:#2563eb;">+ Ketik Jurusan Baru (Custom)...</option>
                    </select>
                    @error('id_jurusan')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" id="custom_jurusan_wrapper" style="display: {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'block' : 'none' }}; grid-column: 1 / -1;">
                    <label for="nama_jurusan_custom" style="color:#2563eb;">Nama Jurusan Baru (Custom) <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_jurusan_custom" name="nama_jurusan_custom" value="{{ old('nama_jurusan_custom') }}" class="form-control {{ $errors->has('nama_jurusan_custom') ? 'is-invalid' : '' }}" placeholder="Contoh: Rekayasa Otomasi Industri">
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Jurusan baru ini akan tersimpan permanen di database dan muncul di daftar pilihan jurusan.</small>
                    @error('nama_jurusan_custom')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_siswa">Jumlah Siswa (Kapasitas / Estimasi) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="jumlah_siswa" name="jumlah_siswa" value="{{ old('jumlah_siswa', 30) }}" class="form-control" min="0" placeholder="30" required>
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Batas maksimal penambahan data siswa untuk kelas ini.</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('kelas.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Kelas
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleCustomJurusan(selectEle) {
            const wrapper = document.getElementById('custom_jurusan_wrapper');
            const customInput = document.getElementById('nama_jurusan_custom');
            if (selectEle.value === 'custom') {
                wrapper.style.display = 'block';
                if (customInput) customInput.focus();
            } else {
                wrapper.style.display = 'none';
                if (customInput) customInput.value = '';
            }
        }

        function validateKelasFormCreate(e) {
            const namaKelas = document.getElementById('nama_kelas').value.trim();
            const idJurusan = document.getElementById('id_jurusan').value;
            const namaJurusanCustom = document.getElementById('nama_jurusan_custom') ? document.getElementById('nama_jurusan_custom').value.trim() : '';
            const jumlahSiswa = document.getElementById('jumlah_siswa').value;

            let errors = [];
            if (!namaKelas) {
                errors.push('Nama Kelas wajib diisi dan tidak boleh hanya berupa spasi!');
            } else if (namaKelas.length > 20) {
                errors.push('Nama Kelas maksimal 20 karakter!');
            }

            if (!idJurusan) {
                errors.push('Jurusan wajib dipilih atau diisi!');
            } else if (idJurusan === 'custom' && !namaJurusanCustom) {
                errors.push('Nama Jurusan Baru (Custom) wajib diisi!');
            }

            if (jumlahSiswa === '' || parseInt(jumlahSiswa) < 0) {
                errors.push('Jumlah Siswa (Kapasitas / Estimasi) wajib diisi dan tidak boleh kurang dari 0!');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!namaKelas) {
                    document.getElementById('nama_kelas').focus();
                } else if (!idJurusan) {
                    document.getElementById('id_jurusan').focus();
                } else if (idJurusan === 'custom' && !namaJurusanCustom) {
                    document.getElementById('nama_jurusan_custom').focus();
                }
                return false;
            }
            return true;
        }
    </script>
@endsection
