@extends('layouts.admin')

@section('title', 'Edit Mapel — ' . $mapel->nama_mapel)

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

    <div class="breadcrumb-text">
        <a href="{{ route('mapel.index') }}"><i class="fa-solid fa-book"></i> Master Mapel</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Mapel</span>
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
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Mapel</h2>
                <p>Sedang mengedit mata pelajaran: <strong style="color:#0f172a;">{{ $mapel->nama_mapel }}</strong></p>
            </div>
            <a href="{{ route('mapel.show', $mapel->id_mapel) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form id="editForm" action="{{ route('mapel.update', $mapel->id_mapel) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="kode_mapel">Kode Mapel <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}"
                        class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}" required>
                    @error('kode_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}"
                        class="form-control {{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}" required>
                    @error('nama_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('mapel.index') }}" class="btn-cancel">
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
            <p>Apakah Anda yakin ingin memperbarui data mata pelajaran <strong style="color:#0f172a;">{{ $mapel->nama_mapel }}</strong>?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeConfirmModal()">Periksa Lagi</button>
                <button type="button" class="btn-m-confirm" onclick="submitForm()">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <script>
        function openConfirmModal() {
            const form = document.getElementById('editForm');
            const kodeMapel = document.getElementById('kode_mapel').value.trim();
            const namaMapel = document.getElementById('nama_mapel').value.trim();

            let errors = [];
            if (!kodeMapel) {
                errors.push('Kode Mapel wajib diisi!');
            } else if (kodeMapel.length > 15) {
                errors.push('Kode Mapel maksimal 15 karakter!');
            }

            if (!namaMapel) {
                errors.push('Nama Mapel wajib diisi!');
            } else if (namaMapel.length > 100) {
                errors.push('Nama Mapel maksimal 100 karakter!');
            }

            if (errors.length > 0) {
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!kodeMapel) document.getElementById('kode_mapel').focus();
                else if (!namaMapel) document.getElementById('nama_mapel').focus();
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
