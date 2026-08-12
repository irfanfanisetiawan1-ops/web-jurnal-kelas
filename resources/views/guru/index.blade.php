@extends('layouts.admin')

@section('title', 'Data Guru — Jurnal ESEMKITA')

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

    .badge-role {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-role-tu {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .badge-role-guru {
        background: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    .badge-jk {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l { background: #e0f2fe; color: #0369a1; }
    .badge-jk-p { background: #fce7f3; color: #be185d; }

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
        <i class="fa-solid fa-user-tie"></i>
        <span>Data Guru</span>
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

    <!-- Card 1: Form Tambah Guru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;"></i> Tambah Guru</h2>
                <p>Masukkan detail data guru untuk pendaftaran baru.</p>
            </div>
            <a href="{{ route('guru.trash') }}" class="btn-trash">
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

        <form id="formGuruIndex" action="{{ route('guru.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP (18 Digit) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="form-control @error('nip') is-invalid @enderror"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');"
                        required>
                    <small id="nipMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 18 digit angka.</small>
                    @error('nip')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_guru">Nama Lengkap Guru <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" class="form-control @error('nama_guru') is-invalid @enderror" placeholder="Masukkan Nama Lengkap" required>
                    @error('nama_guru')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('jenis_kelamin')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP / WA</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    @error('no_hp')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
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
            </div>

            <div class="btn-submit-container">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Guru
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Data Guru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-users" style="color:#3b5490;"></i> Data Guru ({{ count($gurus) }})</h2>
                <p>Kelola seluruh informasi tenaga pengajar sekolah.</p>
            </div>

            <form action="{{ route('guru.index') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" class="form-control" style="width: 220px; padding-left:36px;" value="{{ $search }}" placeholder="Cari Nama / NIP...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <select name="id_mapel" class="form-control" style="width: 160px;">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ $id_mapel == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('guru.index') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>NAMA GURU / PEGAWAI</th>
                        <th>JK</th>
                        <th>ROLE</th>
                        <th>NO HP</th>
                        <th>MAPEL UTAMA</th>
                        <th style="text-align:center; min-width: 220px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $g)
                        <tr>
                            <td><span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $g->nip }}</span></td>
                            <td><strong>{{ $g->nama_guru }}</strong></td>
                            <td>
                                @if($g->jenis_kelamin == 'L')
                                    <span class="badge-jk badge-jk-l">Laki-laki</span>
                                @elseif($g->jenis_kelamin == 'P')
                                    <span class="badge-jk badge-jk-p">Perempuan</span>
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($g->user) && $g->user->isAdmin())
                                    <span class="badge-role badge-role-tu">TU</span>
                                @else
                                    <span class="badge-role badge-role-guru">GURU</span>
                                @endif
                            </td>
                            <td>{{ $g->no_hp ?? '-' }}</td>
                            <td>{{ $g->mapel->nama_mapel ?? '-' }}</td>
                            <td style="text-align:center;">
                                <div class="action-buttons">
                                    <!-- 1. LIHAT (Detail) - Disebelah kiri Edit & Hapus -->
                                    <a href="{{ route('guru.show', $g->id_guru) }}" class="btn-action btn-view" title="Lihat Detail Guru">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>

                                    <!-- 2. EDIT - Disebelah kiri Hapus -->
                                    <a href="{{ route('guru.edit', $g->id_guru) }}" class="btn-action btn-edit" title="Edit Data Guru">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- 3. HAPUS - Paling kanan -->
                                    <form action="{{ route('guru.destroy', $g->id_guru) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($g->nama_guru) }} ke Tempat Sampah?')" title="Hapus Guru">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Belum ada data Guru & Pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateNipCounter(input, targetLen = 18, msgId = 'nipMsg') {
            const counter = document.getElementById('nipCounter');
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
                    msgEle.textContent = '✓ Format NIP ' + targetLen + ' digit angka sudah sesuai.';
                    msgEle.style.color = '#10b981';
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nip = document.getElementById('nip');
            if (nip) updateNipCounter(nip, 18, 'nipMsg');

            const form = document.getElementById('formGuruIndex');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    const nipVal  = document.getElementById('nip').value.trim();
                    const namaVal = document.getElementById('nama_guru').value.trim();
                    const jkVal   = document.getElementById('jenis_kelamin').value;

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
