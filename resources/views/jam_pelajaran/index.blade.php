@extends('layouts.admin')

@section('title', 'Master Jam Pelajaran — Jurnal ESEMKITA')

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
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-top-header p {
        font-size: 13px;
        color: #64748b;
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
    .btn-trash .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
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
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .btn-submit-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3b5490, #2563eb);
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    /* Filter & Reset Buttons */
    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Table Custom */
    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ffffff;
        padding: 14px 16px;
        text-align: left;
        background: #2b395b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    /* Action Buttons Container & Pills */
    .action-buttons {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 13px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }

    /* 1. Lihat (Detail) Button - Blue/Sky */
    .btn-view {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    /* 2. Edit Button - Amber/Yellow */
    .btn-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    /* 3. Hapus Button - Rose/Red */
    .btn-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-delete:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    .badge-time {
        background: #f1f5f9;
        color: #3b5490;
        font-weight: 800;
        font-family: monospace;
        font-size: 13.5px;
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-error {
        background: #fff1f2;
        color: #9f1239;
        border: 1px solid #fecdd3;
    }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <i class="fa-regular fa-clock"></i>
        <span>Master Jam Pelajaran</span>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-success">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-error">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-custom alert-error" id="errorAlertBox">
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
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Card 1: Form Tambah Jam Pelajaran Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Tambah Jam Pelajaran Baru</h2>
                <p>Masukkan rentang waktu dan label sesi pembelajaran baru.</p>
            </div>
            <a href="{{ route('jam-pelajaran.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Lihat Sampah Jam
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-count">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>

        <form id="formTambahJam" action="{{ route('jam-pelajaran.store') }}" method="POST" onsubmit="return validateJamForm(event)">
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <label for="jam_ke">Label Jam <span style="color:#ef4444;">*</span></label>
                    <select id="jam_ke" name="jam_ke" class="form-control @error('jam_ke') is-invalid @enderror @error('jam_ke_resolved') is-invalid @enderror" onchange="toggleCustomJamInput(this)" required>
                        <option value="" disabled {{ old('jam_ke') ? '' : 'selected' }}>-- Pilih Label Jam --</option>
                        @foreach(['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'] as $labelOpt)
                            <option value="{{ $labelOpt }}" {{ old('jam_ke') == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                        @endforeach
                        <option value="custom" {{ old('jam_ke') == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                    </select>

                    <div id="customJamKeWrapper" style="display: {{ old('jam_ke') == 'custom' ? 'block' : 'none' }}; margin-top: 8px;">
                        <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ old('jam_ke_custom') }}" class="form-control" placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                    </div>

                    @error('jam_ke')
                        <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                    @enderror
                    @error('jam_ke_resolved')
                        <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jam_mulai">Waktu Mulai <span style="color:#ef4444;">*</span></label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" class="form-control @error('jam_mulai') is-invalid @enderror" required>
                    @error('jam_mulai')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jam_selesai">Waktu Selesai <span style="color:#ef4444;">*</span></label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '07:45') }}" class="form-control @error('jam_selesai') is-invalid @enderror" required>
                    @error('jam_selesai')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top: -6px;">
                <label for="keterangan">Keterangan (Opsional)</label>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" class="form-control" placeholder="Contoh: Pembelajaran Reguler / Sholat Dzuhur">
            </div>

            <div class="btn-submit-container">
                <button type="submit" class="btn-submit">
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

    <!-- Card 2: Daftar Sesi Jam Pelajaran -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-regular fa-clock" style="color:#3b5490;"></i> Daftar Sesi Jam Pelajaran ({{ count($jamList) }})</h2>
                <p>Kelola seluruh sesi jam pelajaran dan rentang waktu belajar sekolah berdasarkan pedoman <strong>jam pelajaran.png</strong> SMKN 1 Boyolangu.</p>
            </div>

            <form action="{{ route('jam-pelajaran.index') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" class="form-control" style="width: 240px; padding-left:36px;" value="{{ $search ?? '' }}" placeholder="Cari Jam / Waktu / Keterangan..">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <!-- Info Box Ketentuan Waktu KBM dari jam pelajaran.png -->
        <div style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border:1px solid #cbd5e1; border-left:5px solid #2563eb; border-radius:14px; padding:16px 20px; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <i class="fa-solid fa-circle-info" style="color:#2563eb; font-size:18px;"></i>
                <strong style="color:#0f172a; font-size:14px;">Ketentuan Waktu KBM Resmi (SMKN 1 Boyolangu):</strong>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:12px; font-size:12.5px; color:#334155; line-height:1.5;">
                <div>
                    <strong><i class="fa-regular fa-calendar-days" style="color:#3b5490;"></i> Senin s.d. Kamis (1 Jam = 40 Menit):</strong><br>
                    • Jam ke-1 s/d 10 (07:00 - 15:00 WIB)<br>
                    • Istirahat I: 09:40 - 10:00 WIB | Istirahat II: 12:00 - 13:00 WIB<br>
                    • Hari Senin jam ke-1: Upacara / Apel Bendera
                </div>
                <div>
                    <strong><i class="fa-regular fa-calendar-days" style="color:#2563eb;"></i> Hari Jumat (1 Jam = 30 Menit):</strong><br>
                    • Jam ke-1 s/d 13 (07:00 - 15:30 WIB)<br>
                    • Istirahat I: 09:30 - 09:50 WIB | Istirahat II (ISHOMA): 11:20 - 13:00 WIB<br>
                    • Hari Jumat jam ke-1: Pembiasaan Hari Jumat<br>
                    • Kepulangan: Kelas XI jam ke-12 (15:00 WIB), Kelas X jam ke-13 (15:30 WIB)
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>JAM KE-</th>
                        <th>SENIN - KAMIS (40 MENIT)</th>
                        <th>HARI JUMAT (30 MENIT)</th>
                        <th>KETERANGAN</th>
                        <th style="text-align:center; min-width: 240px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jamList as $idx => $item)
                        <tr>
                            <td><strong>{{ $idx + 1 }}</strong></td>
                            <td><strong style="color:#0f172a; font-size:14px;">{{ $item->jam_ke }}</strong></td>
                            <td>
                                @if($item->waktu_senin_kamis !== '-')
                                    <span class="badge-time" style="background:#f1f5f9; color:#1e293b; border-color:#cbd5e1;">
                                        <i class="fa-regular fa-clock"></i> {{ $item->waktu_senin_kamis }} WIB
                                    </span>
                                @else
                                    <span style="color:#94a3b8; font-style:italic;">- (Selesai pkl 15:00)</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-time" style="background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe;">
                                    <i class="fa-regular fa-clock"></i> {{ $item->waktu_jumat }} WIB
                                </span>
                            </td>
                            <td>
                                @if($item->keterangan)
                                    <span style="background:#f8fafc; color:#334155; padding:6px 12px; border-radius:8px; font-weight:600; font-size:12.5px; display:inline-block; border:1px solid #e2e8f0;">
                                        {{ $item->keterangan }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8; font-style:italic;">-</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div class="action-buttons">
                                    <!-- 1. LIHAT DETAIL - Disebelah kiri Edit & Hapus -->
                                    <a href="{{ route('jam-pelajaran.show', $item->id_jam) }}" class="btn-action btn-view" title="Lihat Detail Sesi Jam">
                                        <i class="fa-solid fa-eye"></i> Lihat Detail
                                    </a>

                                    <!-- 2. EDIT - Disebelah kiri Hapus (Hanya bisa diedit saat tombol Edit diklik!) -->
                                    <a href="{{ route('jam-pelajaran.edit', $item->id_jam) }}" class="btn-action btn-edit" title="Edit Data Jam Pelajaran">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- 3. HAPUS - Paling kanan -->
                                    <form action="{{ route('jam-pelajaran.destroy', $item->id_jam) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($item->jam_ke) }} ke tempat sampah?')" title="Hapus Jam Pelajaran">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-regular fa-clock" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Belum ada data Master Jam Pelajaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
