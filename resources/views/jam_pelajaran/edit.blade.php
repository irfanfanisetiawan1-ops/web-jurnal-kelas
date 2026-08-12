@extends('layouts.admin')

@section('title', 'Edit Jam Pelajaran — ' . $jamPelajaran->jam_ke)

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
        <a href="{{ route('jam-pelajaran.index') }}"><i class="fa-regular fa-clock"></i> Master Jam Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Jam Pelajaran</span>
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
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Jam Pelajaran</h2>
                <p>Sedang mengedit sesi: <strong style="color:#0f172a;">{{ $jamPelajaran->jam_ke }}</strong></p>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:8px; font-size:12px;">
                    @if($jamPelajaran->waktu_senin_kamis !== '-')
                        <span style="background:#f1f5f9; color:#1e293b; border:1px solid #cbd5e1; padding:3px 10px; border-radius:8px; font-weight:700;">
                            <i class="fa-regular fa-clock"></i> Senin-Kamis: {{ $jamPelajaran->waktu_senin_kamis }} WIB (40m)
                        </span>
                    @endif
                    <span style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; padding:3px 10px; border-radius:8px; font-weight:700;">
                        <i class="fa-regular fa-clock"></i> Jumat: {{ $jamPelajaran->waktu_jumat }} WIB (30m)
                    </span>
                </div>
            </div>
            <a href="{{ route('jam-pelajaran.show', $jamPelajaran->id_jam) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form id="editForm" action="{{ route('jam-pelajaran.update', $jamPelajaran->id_jam) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $options = ['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'];
                $rawVal = old('jam_ke', $jamPelajaran->jam_ke);
                $matchedVal = $rawVal;
                if (!in_array($matchedVal, $options) && preg_match('/^(Jam Ke-\d+|Istirahat\s*\d*|Upacara\s*Bendera|Pembiasaan\s*Hari\s*Jumat)/i', $rawVal, $m)) {
                    $candidate = trim($m[1]);
                    foreach ($options as $opt) {
                        if (strtolower($opt) === strtolower($candidate)) {
                            $matchedVal = $opt;
                            break;
                        }
                    }
                }
                $isCustom = !in_array($matchedVal, $options) || old('jam_ke') === 'custom';
                $selectedOption = $isCustom ? 'custom' : $matchedVal;
                $customInputVal = old('jam_ke_custom', $rawVal);
            @endphp

            <!-- Input Label Jam -->
            <div class="form-group" style="margin-bottom:24px;">
                <label for="jam_ke">Label Jam Pelajaran <span style="color:#ef4444;">*</span></label>
                <select id="jam_ke" name="jam_ke" class="form-control {{ $errors->has('jam_ke') || $errors->has('jam_ke_resolved') ? 'is-invalid' : '' }}" onchange="toggleCustomJamInput(this)" required>
                    <option value="" disabled>-- Pilih Label Jam Pelajaran --</option>
                    @foreach($options as $labelOpt)
                        <option value="{{ $labelOpt }}" {{ $selectedOption == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                    @endforeach
                    <option value="custom" {{ $selectedOption == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                </select>

                <div id="customJamKeWrapper" style="display: {{ $isCustom ? 'block' : 'none' }}; margin-top: 8px;">
                    <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ $customInputVal }}" class="form-control" placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                </div>

                @error('jam_ke')
                    <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
                @error('jam_ke_resolved')
                    <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Grid 2 Kolom: Waktu Senin-Kamis & Waktu Jumat -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:20px;">
                <!-- Section Waktu Senin - Kamis -->
                <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:14px; padding:18px;">
                    <strong style="font-size:13.5px; color:#1e293b; display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                        <i class="fa-regular fa-calendar-days" style="color:#3b5490;"></i> Waktu Senin - Kamis (1 Jam = 40 Menit)
                    </strong>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai" style="font-size:12px;">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jamPelajaran->jam_mulai ? substr($jamPelajaran->jam_mulai, 0, 5) : '') }}"
                                class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai" style="font-size:12px;">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jamPelajaran->jam_selesai ? substr($jamPelajaran->jam_selesai, 0, 5) : '') }}"
                                class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}">
                        </div>
                    </div>
                    <small style="color:#64748b; font-size:11px; display:block; margin-top:8px;">* Kosongkan jika hari Senin-Kamis pembelajaran telah selesai (misal Jam 11-13).</small>
                </div>

                <!-- Section Waktu Hari Jumat -->
                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:14px; padding:18px;">
                    <strong style="font-size:13.5px; color:#1d4ed8; display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                        <i class="fa-regular fa-calendar-days" style="color:#2563eb;"></i> Waktu Hari Jumat (1 Jam = 30 Menit) <span style="color:#ef4444;">*</span>
                    </strong>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai_jumat" style="font-size:12px; color:#1e40af;">Jam Mulai Jumat *</label>
                            <input type="time" id="jam_mulai_jumat" name="jam_mulai_jumat" value="{{ old('jam_mulai_jumat', $jamPelajaran->jam_mulai_jumat ? substr($jamPelajaran->jam_mulai_jumat, 0, 5) : '07:00') }}"
                                class="form-control {{ $errors->has('jam_mulai_jumat') ? 'is-invalid' : '' }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai_jumat" style="font-size:12px; color:#1e40af;">Jam Selesai Jumat *</label>
                            <input type="time" id="jam_selesai_jumat" name="jam_selesai_jumat" value="{{ old('jam_selesai_jumat', $jamPelajaran->jam_selesai_jumat ? substr($jamPelajaran->jam_selesai_jumat, 0, 5) : '07:30') }}"
                                class="form-control {{ $errors->has('jam_selesai_jumat') ? 'is-invalid' : '' }}" required>
                        </div>
                    </div>
                    <small style="color:#2563eb; font-size:11px; display:block; margin-top:8px;">* Waktu mengajar resmi hari Jumat sesuai pedoman jam pelajaran.png.</small>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan / Catatan Sesi</label>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $jamPelajaran->keterangan) }}" class="form-control" placeholder="Contoh: Pembelajaran Reguler / Upacara Bendera">
            </div>

            <div class="form-actions">
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-cancel">
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
            <p>Apakah Anda yakin ingin memperbarui data jam pelajaran <strong style="color:#0f172a;" id="confirmJamKeLabel">{{ $jamPelajaran->jam_ke }}</strong>?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeConfirmModal()">Periksa Lagi</button>
                <button type="button" class="btn-m-confirm" onclick="submitForm()">Ya, Simpan</button>
            </div>
        </div>
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
            }
        }

        function openConfirmModal() {
            const form = document.getElementById('editForm');
            const selectElem = document.getElementById('jam_ke');
            const jamKeVal = selectElem.value;
            const customVal = document.getElementById('jam_ke_custom').value.trim();
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;
            const jamMulaiJumat = document.getElementById('jam_mulai_jumat').value;
            const jamSelesaiJumat = document.getElementById('jam_selesai_jumat').value;

            let errors = [];
            if (!jamKeVal) {
                errors.push('Label Jam wajib dipilih!');
            } else if (jamKeVal === 'custom' && !customVal) {
                errors.push('Label Jam khusus wajib diisi!');
            }

            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                errors.push('Waktu Selesai Senin-Kamis (' + jamSelesai + ') harus lebih akhir daripada Waktu Mulai (' + jamMulai + ')!');
            }

            if (!jamMulaiJumat) {
                errors.push('Waktu Mulai Hari Jumat wajib diisi!');
            }

            if (!jamSelesaiJumat) {
                errors.push('Waktu Selesai Hari Jumat wajib diisi!');
            }

            if (jamMulaiJumat && jamSelesaiJumat && jamSelesaiJumat <= jamMulaiJumat) {
                errors.push('Waktu Selesai Hari Jumat (' + jamSelesaiJumat + ') harus lebih akhir daripada Waktu Mulai Hari Jumat (' + jamMulaiJumat + ')!');
            }

            if (errors.length > 0) {
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!jamKeVal) selectElem.focus();
                else if (jamKeVal === 'custom' && !customVal) document.getElementById('jam_ke_custom').focus();
                else if (jamMulaiJumat && jamSelesaiJumat && jamSelesaiJumat <= jamMulaiJumat) document.getElementById('jam_selesai_jumat').focus();
                return;
            }

            const activeLabel = jamKeVal === 'custom' ? customVal : jamKeVal;
            document.getElementById('confirmJamKeLabel').textContent = activeLabel;

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
