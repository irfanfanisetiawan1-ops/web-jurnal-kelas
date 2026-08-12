@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa — Jurnal ESEMKITA')

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
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
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
        box-shadow: 0 3px 8px rgba(2, 132, 199, 0.25);
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
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.25);
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
        box-shadow: 0 3px 8px rgba(225, 29, 72, 0.25);
    }

    .badge-jk {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-jk-p {
        background: #fce7f3;
        color: #be185d;
    }

    .badge-kelas {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
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
        <i class="fa-solid fa-graduation-cap"></i>
        <span>Manajemen Data Siswa</span>
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

    <!-- Card 1: Form Tambah Siswa Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;"></i> Tambah Siswa Baru</h2>
                <p>Masukkan detail data siswa untuk pendaftaran siswa baru.</p>
            </div>
            <a href="{{ route('siswa.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Lihat Tong Sampah
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-count">{{ $trashedCount }}</span>
                @endif
            </a>
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

        <form id="formSiswaIndex" action="{{ route('siswa.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nis" style="margin-bottom: 0;">NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span></label>
                        <span id="nisCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                        class="form-control @error('nis') is-invalid @enderror"
                        placeholder="Contoh: 2122100001" maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisCounter', 10, 'nisMsg');"
                        required>
                    <small id="nisMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 10 digit angka.</small>
                    @error('nis')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nisn" style="margin-bottom: 0;">NISN <span style="color:#ef4444;">*</span></label>
                        <span id="nisnCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                        class="form-control @error('nisn') is-invalid @enderror"
                        placeholder="Contoh: 0051234567" maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisnCounter', 10, 'nisnMsg');"
                        required>
                    <small id="nisnMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 10 digit angka.</small>
                    @error('nisn')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Lengkap Siswa" required>
                    @error('nama_siswa')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control @error('id_kelas') is-invalid @enderror" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelass as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
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
                    <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control" rows="2" placeholder="Masukkan Alamat Lengkap Siswa">{{ old('alamat_lengkap') }}</textarea>
                </div>
            </div>

            <div class="btn-submit-container">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Data Siswa -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-users" style="color:#3b5490;"></i> Daftar Data Siswa ({{ count($siswas) }})</h2>
                <p>Kelola dan pantau seluruh data siswa yang terdaftar dalam sistem.</p>
            </div>

            <form action="{{ route('siswa.index') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" value="{{ $search }}" class="form-control" style="width:240px; padding-left:36px;" placeholder="Cari Siswa / NIS / NISN...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('siswa.index') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>NAMA SISWA</th>
                        <th>JK</th>
                        <th>KELAS</th>
                        <th>TEMPAT & TGL LAHIR</th>
                        <th>ALAMAT</th>
                        <th style="text-align:center; min-width: 220px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $s)
                        <tr>
                            <td><strong>{{ $s->nis ?? '-' }}</strong></td>
                            <td><span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $s->nisn }}</span></td>
                            <td><strong>{{ $s->nama_siswa }}</strong></td>
                            <td>
                                @if($s->jenis_kelamin == 'L')
                                    <span class="badge-jk badge-jk-l">Laki-laki</span>
                                @elseif($s->jenis_kelamin == 'P')
                                    <span class="badge-jk badge-jk-p">Perempuan</span>
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td><span class="badge-kelas">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>
                                @if($s->kota_lahir || $s->tanggal_lahir)
                                    {{ $s->kota_lahir ?? '' }}{{ $s->kota_lahir && $s->tanggal_lahir ? ', ' : '' }}{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '' }}
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td>{{ $s->alamat_lengkap ? \Illuminate\Support\Str::limit($s->alamat_lengkap, 35) : '-' }}</td>
                            <td style="text-align:center;">
                                <div class="action-buttons">
                                    <!-- 1. LIHAT (Detail) - Disebelah kiri Edit & Hapus -->
                                    <a href="{{ route('siswa.show', $s->id_siswa) }}" class="btn-action btn-view" title="Lihat Detail Siswa">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>

                                    <!-- 2. EDIT - Disebelah kiri Hapus -->
                                    <a href="{{ route('siswa.edit', $s->id_siswa) }}" class="btn-action btn-edit" title="Edit Data Siswa">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- 3. HAPUS - Paling kanan -->
                                    <form action="{{ route('siswa.destroy', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($s->nama_siswa) }} ke tempat sampah?')" title="Hapus Siswa">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Belum ada data Siswa yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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

            const form = document.getElementById('formSiswaIndex');
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
