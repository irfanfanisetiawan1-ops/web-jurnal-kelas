@extends('layouts.admin')

@section('title', 'Edit Kelas — ' . $kelas->nama_kelas)

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
            <h1>Edit Data Kelas</h1>
            <p>Perbarui nama kelas, tingkat, jurusan, dan informasi rombel</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('kelas.index') }}"><i class="fa-solid fa-school"></i> Data Kelas</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Kelas</span>
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

    <div class="edit-card">
        <div class="edit-header-row">
            <div>
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Kelas</h2>
                <p>Sedang mengedit rombongan belajar: <strong style="color:#0f172a;">{{ $kelas->nama_kelas }}</strong></p>
            </div>
            <a href="{{ route('kelas.show', $kelas->id_kelas) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form id="editForm" action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                        class="form-control {{ $errors->has('nama_kelas') ? 'is-invalid' : '' }}" required>
                    @error('nama_kelas')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_jurusan">Jurusan <span style="color:#ef4444;">*</span></label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control {{ $errors->has('id_jurusan') ? 'is-invalid' : '' }}" onchange="toggleCustomJurusan(this)" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}" {{ old('id_jurusan', $kelas->id_jurusan) == $j->id_jurusan ? 'selected' : '' }}>
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
                    <label for="wali_kelas">Wali Kelas</label>
                    <select id="wali_kelas" name="wali_kelas" class="form-control">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($gurus as $g)
                            @php
                                $isAssignedToOther = isset($assignedWali[$g->nip]) && $kelas->wali_kelas !== $g->nip;
                                $isAssignedToCurrent = ($kelas->wali_kelas === $g->nip);
                                $assignedClassName = isset($assignedWali[$g->nip]) ? $assignedWali[$g->nip] : null;
                            @endphp
                            <option value="{{ $g->nip }}"
                                {{ old('wali_kelas', $kelas->wali_kelas) == $g->nip ? 'selected' : '' }}
                                {{ $isAssignedToOther ? 'disabled' : '' }}
                                style="{{ $isAssignedToOther ? 'color: #94a3b8; background-color: #f1f5f9;' : '' }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip }})@if($isAssignedToCurrent) — [Wali Kelas Saat Ini]@elseif($isAssignedToOther) — [Sudah jadi Wali Kelas: {{ $assignedClassName }}] (Tidak dapat dipilih)@endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_ruangan">Ruangan Kelas Utama</label>
                    <select id="id_ruangan" name="id_ruangan" class="form-control">
                        <option value="">-- Pilih Ruangan Kelas --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan', $kelas->id_ruangan) == $r->id_ruangan ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }} ({{ $r->jenis_ruangan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah_siswa">Jumlah Siswa (Kapasitas / Estimasi) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="jumlah_siswa" name="jumlah_siswa" value="{{ old('jumlah_siswa', $kelas->jumlah_siswa) }}" class="form-control" min="0" required>
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Ubah nilai kapasitas ini jika ingin menambah/mengurangi batas kuota siswa di kelas ini.</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('kelas.index') }}" class="btn-cancel">
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
            <p>Apakah Anda yakin ingin memperbarui data kelas <strong style="color:#0f172a;">{{ $kelas->nama_kelas }}</strong>?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeConfirmModal()">Periksa Lagi</button>
                <button type="button" class="btn-m-confirm" onclick="submitForm()">Ya, Simpan</button>
            </div>
        </div>
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

        function openConfirmModal() {
            const form = document.getElementById('editForm');
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
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!namaKelas) {
                    document.getElementById('nama_kelas').focus();
                } else if (!idJurusan) {
                    document.getElementById('id_jurusan').focus();
                } else if (idJurusan === 'custom' && !namaJurusanCustom) {
                    document.getElementById('nama_jurusan_custom').focus();
                }
                return;
            }

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
