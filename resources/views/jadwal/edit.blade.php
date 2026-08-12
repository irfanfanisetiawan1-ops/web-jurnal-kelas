@extends('layouts.admin')

@section('title', 'Edit Jadwal Pelajaran #' . $jadwal->id_jadwal . ' — Jurnal ESEMKITA')

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
        margin: 0;
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

    .form-control.input-error {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
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
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('jadwal.index') }}"><i class="fa-solid fa-calendar-days"></i> Data Jadwal Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Edit Data Jadwal</span>
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
                <h2><i class="fa-solid fa-pen-to-square" style="color:#d97706;"></i> Form Edit Data Jadwal Pelajaran</h2>
                <p>Sedang mengedit jadwal: <strong style="color:#0f172a;">#{{ $jadwal->id_jadwal }} — {{ $jadwal->kelas->nama_kelas ?? '' }} ({{ $jadwal->hari }})</strong></p>
            </div>
            <a href="{{ route('jadwal.show', $jadwal->id_jadwal) }}" class="btn-cancel" style="padding:8px 16px; font-size:13px;">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>

        <form action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                
                <!-- Hari -->
                <div class="form-group">
                    <label for="hari">Hari Pelaksanaan <span style="color:#ef4444;">*</span></label>
                    <select name="hari" id="hari" class="form-control @error('hari') input-error @enderror" onchange="updateJamOptionsByHari()" required>
                        @foreach($hariOptions as $h)
                            <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="id_kelas">Kelas Target <span style="color:#ef4444;">*</span></label>
                    <select name="id_kelas" id="id_kelas" class="form-control @error('id_kelas') input-error @enderror" required>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas', $jadwal->id_kelas) == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jam Mulai -->
                <div class="form-group">
                    <label for="id_jam_mulai">Jam Mulai (ke-) <span style="color:#ef4444;">*</span></label>
                    <select name="id_jam_mulai" id="id_jam_mulai" class="form-control @error('id_jam_mulai') input-error @enderror" required>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_mulai', $jadwal->id_jam_mulai) == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jam Selesai -->
                <div class="form-group">
                    <label for="id_jam_selesai">Jam Selesai (ke-) <span style="color:#ef4444;">*</span></label>
                    <select name="id_jam_selesai" id="id_jam_selesai" class="form-control @error('id_jam_selesai') input-error @enderror" required>
                        @foreach($jamPelajarans as $jp)
                            <option value="{{ $jp->id_jam }}" {{ old('id_jam_selesai', $jadwal->id_jam_selesai) == $jp->id_jam ? 'selected' : '' }}
                                data-senin-kamis="{{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Selesai 15:00' }})"
                                data-jumat="{{ $jp->jam_ke }} ({{ $jp->waktu_jumat !== '-' ? $jp->waktu_jumat . ' WIB' : 'Tidak Ada' }})"
                                data-has-senin-kamis="{{ $jp->jam_mulai ? '1' : '0' }}">
                                {{ $jp->jam_ke }} ({{ $jp->waktu_senin_kamis !== '-' ? $jp->waktu_senin_kamis . ' WIB' : 'Khusus Jumat' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="id_mapel">Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <select name="id_mapel" id="id_mapel" class="form-control @error('id_mapel') input-error @enderror" required>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel', $jadwal->id_mapel) == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->kode_mapel }} — {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Guru Pengampu -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="id_guru">Guru Pengampu <span style="color:#ef4444;">*</span></label>
                    <select name="id_guru" id="id_guru" class="form-control @error('id_guru') input-error @enderror" required>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru', $jadwal->id_guru) == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama_guru }} — NIP. {{ $g->nip ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ruangan -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="id_ruangan">Ruangan <span style="color:#ef4444;">*</span></label>
                    <select name="id_ruangan" id="id_ruangan" class="form-control @error('id_ruangan') input-error @enderror" required>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan', $jadwal->id_ruangan) == $r->id_ruangan ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }} ({{ $r->jenis_ruangan }})
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('jadwal.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-update">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
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

        const form = document.getElementById('editForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const hari         = document.getElementById('hari').value;
                const idJamMulai   = document.getElementById('id_jam_mulai').value;
                const idJamSelesai = document.getElementById('id_jam_selesai').value;

                if (parseInt(idJamSelesai) < parseInt(idJamMulai)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Pelajaran Tidak Sesuai!',
                        text: 'Jam Selesai tidak boleh lebih kecil dari Jam Mulai.',
                        confirmButtonColor: '#d97706'
                    });
                    return false;
                }

                if (hari !== 'Jumat' && (parseInt(idJamMulai) > 10 || parseInt(idJamSelesai) > 10)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Batas Jam Pelajaran Terlampaui!',
                        text: 'Untuk hari ' + hari + ', jam pelajaran maksimal adalah Jam Ke-10 (07:00 - 15:00 WIB). Jam Ke-11 s/d 13 hanya berlaku pada hari Jumat.',
                        confirmButtonColor: '#d97706'
                    });
                    return false;
                }
            });
        }
    });
</script>
@endsection
