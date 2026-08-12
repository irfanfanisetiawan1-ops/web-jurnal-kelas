@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Pelajaran — Jurnal ESEMKITA')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 14px;
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
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .form-control.input-error {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .form-hint {
        font-size: 11.5px;
        color: #94a3b8;
        font-style: italic;
        font-weight: 500;
        margin-top: 4px;
        display: block;
    }

    .form-hint-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
    }

    .btn-submit {
        background: #3b5490;
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-submit:hover { background: #2e4375; }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 600;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Table & Action Buttons */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 12px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 15px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }
    .btn-lihat {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-lihat:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    .btn-edit-act {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit-act:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    .btn-hapus-act {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-hapus-act:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
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

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 90%;
        max-width: 560px;
        padding: 28px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        Jurnal ESEMKITA > <span>Manajemen Jadwal Pelajaran</span>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card 1: Tambah Jadwal -->
    <div class="card">
        <h2>Tambah Jadwal Pelajaran</h2>

            <div class="form-hint-box" style="background:#eff6ff; border-color:#bfdbfe; color:#1e40af;">
                <i class="fa-solid fa-circle-info" style="color: #2563eb; margin-right: 6px;"></i>
                <strong style="color: #1e3a8a;">Pedoman Jam Pelajaran Official (SMKN 1 Boyolangu):</strong>
                <span style="display:block; margin-top:4px;">
                    • <strong>Senin s.d. Kamis (40 Menit/Jam):</strong> Jam Ke-1 s/d 10 (07:00 - 15:00 WIB).<br>
                    • <strong>Hari Jumat (30 Menit/Jam):</strong> Jam Ke-1 s/d 13 (07:00 - 15:30 WIB).<br>
                    <em>Label jam di bawah akan otomatis menyesuaikan alokasi waktu resmi berdasarkan Hari yang Anda pilih.</em>
                </span>
            </div>

            <div class="form-grid-3">
                <!-- Hari -->
                <div class="form-group">
                    <label for="hari">Hari <span style="color:#ef4444;">*</span></label>
                    <select id="hari" name="hari" class="form-control @error('hari') input-error @enderror" onchange="updateJamOptionsByHari()">
                        <option value="" disabled {{ old('hari') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Hari --</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    </select>
                    <span class="form-hint">Contoh saran: Senin / Jumat</span>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control @error('id_kelas') input-error @enderror">
                        <option value="" disabled {{ old('id_kelas') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: X RPL 1 / XI TKJ 2</span>
                </div>

                <!-- Guru Pengampu (NIP & Filtered Verified) -->
                <div class="form-group">
                    <label for="id_guru">Guru Pengampu <span style="color:#ef4444;">*</span></label>
                    <select id="id_guru" name="id_guru" class="form-control @error('id_guru') input-error @enderror">
                        <option value="" disabled {{ old('id_guru') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Guru (Terverifikasi) --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama_guru }} — NIP. {{ $g->nip ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Budi Santoso — NIP. 19820315...</span>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group">
                    <label for="id_mapel">Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <select id="id_mapel" name="id_mapel" class="form-control @error('id_mapel') input-error @enderror">
                        <option value="" disabled {{ old('id_mapel') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Mapel --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Matematika / Pemrograman Web</span>
                </div>

                <!-- Ruangan -->
                <div class="form-group">
                    <label for="id_ruangan">Ruangan <span style="color:#ef4444;">*</span></label>
                    <select id="id_ruangan" name="id_ruangan" class="form-control @error('id_ruangan') input-error @enderror">
                        <option value="" disabled {{ old('id_ruangan') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Ruangan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan') == $r->id_ruangan ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Lab. RPL 1 / Ruang Teori 04</span>
                </div>

                <!-- Jam Mulai -->
                <div class="form-group">
                    <label for="id_jam_mulai">Jam Mulai (ke-) <span style="color:#ef4444;">*</span></label>
                    <select id="id_jam_mulai" name="id_jam_mulai" class="form-control @error('id_jam_mulai') input-error @enderror">
                        <option value="" disabled {{ old('id_jam_mulai') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Jam Mulai --</option>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_mulai') == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Contoh saran: Jam Ke-1 (07:00 WIB)</span>
                </div>
            </div>

            <div class="form-group" style="max-width: 32%;">
                <label for="id_jam_selesai">Jam Selesai (ke-) <span style="color:#ef4444;">*</span></label>
                <select id="id_jam_selesai" name="id_jam_selesai" class="form-control @error('id_jam_selesai') input-error @enderror">
                    <option value="" disabled {{ old('id_jam_selesai') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Jam Selesai --</option>
                    @foreach($jamPelajarans as $jp)
                        <option value="{{ $jp->id_jam }}" {{ old('id_jam_selesai') == $jp->id_jam ? 'selected' : '' }}
                            data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                            data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                            data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                            {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                        </option>
                    @endforeach
                </select>
                <span class="form-hint">Contoh saran: Jam Ke-3 (09:00 WIB)</span>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal
            </button>
        </form>
    </div>

    <!-- Card 2: Daftar Jadwal -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
            <h2 style="margin:0;">Daftar Jadwal Pelajaran ({{ $jadwals->total() }})</h2>
            <a href="{{ route('jadwal.trash') }}" class="btn-trash" title="Lihat Tempat Sampah Jadwal">
                <i class="fa-solid fa-trash-can"></i> Lihat Sampah Jadwal ({{ $trashedCount ?? 0 }})
            </a>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('jadwal.index') }}" style="display:grid; grid-template-columns: 1fr 1.5fr 2fr auto; gap:12px; margin-bottom:20px; background:#f8fafc; padding:16px; border-radius:14px; border:1px solid #e2e8f0; align-items:end;">
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Filter Hari</label>
                <select name="hari" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Filter Kelas</label>
                <select name="id_kelas" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas (48 Rombel) --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">Cari Guru / Mapel / Ruangan</label>
                <input type="text" name="search" class="form-control" placeholder="Ketik kata kunci pencarian..." value="{{ request('search') }}">
            </div>
            <div style="display:flex; gap:6px;">
                <button type="submit" class="btn-submit" style="margin:0; padding:10px 16px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                @if(request('hari') || request('id_kelas') || request('search'))
                    <a href="{{ route('jadwal.index') }}" class="btn-aksi" style="background:#cbd5e1; color:#334155; padding:10px 14px;">Reset</a>
                @endif
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>HARI</th>
                        <th>JAM PELAJARAN</th>
                        <th>KELAS</th>
                        <th>GURU (NIP)</th>
                        <th>MAPEL</th>
                        <th>RUANGAN</th>
                        <th style="min-width: 210px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        <tr>
                            <td><strong>{{ $j->hari }}</strong></td>
                            <td>
                                <strong>Jam ke-{{ $j->jam_range }}</strong><br>
                                <small style="color:#3b5490; font-weight:700;">{{ $j->waktu_range }}</small>
                            </td>
                            <td><strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td>
                                <strong>{{ $j->guru->nama_guru ?? '-' }}</strong><br>
                                <small style="color:#64748b;">NIP: {{ $j->guru->nip ?? '-' }}</small>
                            </td>
                            <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:6px; flex-wrap:nowrap;">
                                    <!-- 1. LIHAT DETAIL - Mengarah langsung ke Halaman Detail (Persis Data Kelas) -->
                                    <a href="{{ route('jadwal.show', $j->id_jadwal) }}" class="btn-aksi btn-lihat" title="Lihat Detail Jadwal Pelajaran">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>

                                    <!-- 2. EDIT -->
                                    <a href="{{ route('jadwal.edit', $j->id_jadwal) }}" class="btn-aksi btn-edit-act" title="Edit Jadwal">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- 3. HAPUS -->
                                    <form action="{{ route('jadwal.destroy', $j->id_jadwal) }}" method="POST" style="display:inline-block;" id="delForm-{{ $j->id_jadwal }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-aksi btn-hapus-act" onclick="confirmDelete('delForm-{{ $j->id_jadwal }}')" title="Hapus Jadwal">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:30px; color:#94a3b8;">
                                Belum ada data Jadwal Pelajaran yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $jadwals->links() }}
        </div>
    </div>

    <!-- Modal Detail Jadwal Quick View -->
    <div id="modalDetailJadwal" class="modal-overlay">
        <div class="modal-card">
            <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:16px; border-bottom:1px solid #f1f5f9; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg, #2563eb, #3b82f6); color:#ffffff; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow:0 4px 12px rgba(37,99,235,0.25);">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 style="margin:0; font-size:17px; font-weight:800; color:#0f172a;" id="modalTitle">Detail Jadwal Pelajaran</h3>
                        <span style="font-size:12px; color:#64748b;" id="modalSubTitle">Informasi alokasi jadwal KBM</span>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background:none; border:none; font-size:22px; color:#64748b; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div id="modalBody" style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <!-- Content Injected via JavaScript -->
            </div>

            <div style="margin-top:24px; padding-top:16px; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; gap:8px;">
                    <a id="modalFullLink" href="#" class="btn-aksi btn-lihat" style="padding:9px 16px; font-size:12.5px; border-radius:10px;">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i> Halaman Detail Penuh
                    </a>
                    <a id="modalEditLink" href="#" class="btn-aksi btn-edit-act" style="padding:9px 16px; font-size:12.5px; border-radius:10px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background:#e2e8f0; color:#475569; padding:9px 18px; border-radius:10px; font-weight:700; border:none; cursor:pointer; font-size:13px;">Tutup</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateJamOptionsByHari() {
        const hariElem = document.getElementById('hari');
        if (!hariElem) return;
        const hariVal = hariElem.value;
        const isJumat = hariVal === 'Jumat';

        ['id_jam_mulai', 'id_jam_selesai'].forEach(selectId => {
            const selectElem = document.getElementById(selectId);
            if (!selectElem) return;

            Array.from(selectElem.options).forEach(opt => {
                if (!opt.value) return; // Skip placeholder
                const textJumat = opt.getAttribute('data-jumat');
                const textSeninKamis = opt.getAttribute('data-senin-kamis');
                const hasSeninKamis = opt.getAttribute('data-has-senin-kamis') === '1';

                if (isJumat) {
                    opt.textContent = textJumat || opt.textContent;
                    opt.disabled = false;
                } else {
                    opt.textContent = textSeninKamis || opt.textContent;
                    if (!hasSeninKamis) {
                        opt.disabled = true;
                        opt.textContent = (textSeninKamis || opt.textContent) + ' (Khusus Jumat)';
                        if (opt.selected) {
                            selectElem.value = '';
                        }
                    } else {
                        opt.disabled = false;
                    }
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateJamOptionsByHari();

        const form = document.getElementById('formTambahJadwal');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset error state
                const formControls = form.querySelectorAll('.form-control');
                formControls.forEach(c => c.classList.remove('input-error'));

                const hari         = document.getElementById('hari').value;
                const idKelas      = document.getElementById('id_kelas').value;
                const idGuru       = document.getElementById('id_guru').value;
                const idMapel      = document.getElementById('id_mapel').value;
                const idRuangan    = document.getElementById('id_ruangan').value;
                const idJamMulai   = document.getElementById('id_jam_mulai').value;
                const idJamSelesai = document.getElementById('id_jam_selesai').value;

                let missing = [];
                if (!hari) { missing.push('Hari'); document.getElementById('hari').classList.add('input-error'); }
                if (!idKelas) { missing.push('Kelas'); document.getElementById('id_kelas').classList.add('input-error'); }
                if (!idGuru) { missing.push('Guru Pengampu'); document.getElementById('id_guru').classList.add('input-error'); }
                if (!idMapel) { missing.push('Mata Pelajaran'); document.getElementById('id_mapel').classList.add('input-error'); }
                if (!idRuangan) { missing.push('Ruangan'); document.getElementById('id_ruangan').classList.add('input-error'); }
                if (!idJamMulai) { missing.push('Jam Mulai'); document.getElementById('id_jam_mulai').classList.add('input-error'); }
                if (!idJamSelesai) { missing.push('Jam Selesai'); document.getElementById('id_jam_selesai').classList.add('input-error'); }

                if (missing.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulir Belum Lengkap!',
                        html: 'Silakan lengkapi data yang belum diisi berikut:<br><br><strong style="color:#dc2626;">' + missing.join(', ') + '</strong>',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                if (parseInt(idJamSelesai) < parseInt(idJamMulai)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Pelajaran Tidak Sesuai!',
                        text: 'Jam Selesai tidak boleh lebih kecil dari Jam Mulai.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                if (hari !== 'Jumat' && (parseInt(idJamMulai) > 10 || parseInt(idJamSelesai) > 10)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Batas Jam Pelajaran Terlampaui!',
                        text: 'Untuk hari ' + hari + ', jam pelajaran maksimal adalah Jam Ke-10 (07:00 - 15:00 WIB). Jam Ke-11 s/d 13 hanya berlaku pada hari Jumat.',
                        confirmButtonColor: '#3b5490'
                    });
                    return false;
                }

                // If valid, ask confirmation
                Swal.fire({
                    title: 'Konfirmasi Simpan Jadwal',
                    text: 'Apakah Anda yakin ingin menambahkan data jadwal pelajaran ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b5490',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Simpan Jadwal!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });

    function openDetailModal(data) {
        document.getElementById('modalTitle').innerText = 'Detail Jadwal #' + data.id;
        document.getElementById('modalSubTitle').innerText = data.hari + ' | ' + data.jam;

        const dayColors = {
            'Senin': { bg: '#eff6ff', text: '#1d4ed8', border: '#bfdbfe' },
            'Selasa': { bg: '#fdf4ff', text: '#a21caf', border: '#f5d0fe' },
            'Rabu': { bg: '#ecfdf5', text: '#047857', border: '#a7f3d0' },
            'Kamis': { bg: '#fff7ed', text: '#c2410c', border: '#ffedd5' },
            'Jumat': { bg: '#f0fdf4', text: '#15803d', border: '#bbf7d0' }
        };
        const dayStyle = dayColors[data.hari] || { bg: '#f1f5f9', text: '#334155', border: '#cbd5e1' };

        const body = document.getElementById('modalBody');
        body.innerHTML = `
            <div style="background:${dayStyle.bg}; padding:14px; border-radius:12px; border:1px solid ${dayStyle.border}; grid-column:span 2;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <small style="color:${dayStyle.text}; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;">HARI & JAM KBM</small>
                        <div style="font-weight:800; font-size:16px; color:#0f172a; margin-top:2px;">${data.hari} — ${data.jam}</div>
                    </div>
                    <span style="background:${dayStyle.text}; color:#ffffff; font-weight:800; padding:4px 12px; border-radius:10px; font-size:12px;">${data.hari}</span>
                </div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-graduation-cap"></i> KELAS TARGET</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.kelas}</div>
                <div style="font-size:12px; color:#475569; margin-top:3px; font-weight:600;"><i class="fa-solid fa-user-tie"></i> Wali: ${data.wali_kelas}</div>
                ${data.jurusan && data.jurusan !== '-' ? `<div style="font-size:11.5px; color:#64748b; margin-top:2px;">Jurusan: ${data.jurusan}</div>` : ''}
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-book-bookmark"></i> MATA PELAJARAN</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.mapel}</div>
                <div style="font-size:12px; color:#2563eb; font-weight:700; margin-top:3px; font-family:monospace;">Kode: ${data.kode_mapel}</div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0; grid-column:span 2;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-chalkboard-user"></i> GURU PENGAMPU</small>
                        <div style="font-weight:800; font-size:15.5px; color:#0f172a; margin-top:4px;">${data.guru}</div>
                        <div style="font-size:12.5px; color:#475569; font-weight:600; margin-top:3px;">
                            <span style="margin-right:12px;"><i class="fa-solid fa-id-card"></i> NIP: ${data.nip}</span>
                            ${data.no_hp && data.no_hp !== '-' ? `<span><i class="fa-solid fa-phone"></i> ${data.no_hp}</span>` : ''}
                        </div>
                    </div>
                    ${data.id_guru ? `
                        <a href="/guru/${data.id_guru}" target="_blank" style="background:#e0f2fe; color:#0369a1; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                            Profil Guru <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    ` : ''}
                </div>
            </div>

            <div style="background:#f8fafc; padding:14px; border-radius:12px; border:1px solid #e2e8f0; grid-column:span 2;">
                <small style="color:#64748b; font-weight:800; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;"><i class="fa-solid fa-door-open"></i> LOKASI RUANGAN</small>
                <div style="font-weight:800; font-size:15px; color:#0f172a; margin-top:4px;">${data.ruangan}</div>
                <div style="font-size:12px; color:#64748b; margin-top:2px;">Jenis Ruangan: ${data.jenis_ruangan}</div>
            </div>
        `;

        document.getElementById('modalFullLink').setAttribute('href', data.url_show);
        document.getElementById('modalEditLink').setAttribute('href', data.url_edit);
        document.getElementById('modalDetailJadwal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailJadwal').style.display = 'none';
    }

    function confirmDelete(formId) {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: 'Data jadwal pelajaran ini akan dipindahkan ke Tempat Sampah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection
