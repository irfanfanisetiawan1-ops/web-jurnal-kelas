<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Pelajaran — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 50px;
        }

        .bg-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #4f46e5 100%);
            z-index: 0;
        }

        .container {
            max-width: 780px;
            margin: 0 auto;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
            transition: opacity 0.15s ease;
        }
        .back-link:hover { opacity: 0.85; }

        .card {
            background: #ffffff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(79, 70, 229, 0.35);
        }
        .card-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
        .card-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }
        label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            outline: none;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        input:focus, select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .input-error {
            border-color: #ef4444 !important;
        }
        .error-message {
            font-size: 12px;
            color: #ef4444;
            font-weight: 600;
            margin-top: 2px;
        }

        .btn-group {
            margin-top: 32px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        .btn-cancel {
            padding: 12px 22px;
            font-size: 13.5px;
            font-weight: 700;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }

        .btn-submit {
            padding: 12px 26px;
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 16px -2px rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -2px rgba(79, 70, 229, 0.45);
        }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <a href="{{ route('jadwal.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Data Jadwal
    </a>

    <div class="card">
        <div class="card-header">
            <div class="card-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/></svg>
            </div>
            <div class="card-title">
                <h1>Tambah Jadwal Pelajaran</h1>
                <p>Isi formulir berikut untuk menambahkan jadwal mengajar baru ke database</p>
            </div>
        </div>

        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 14px; padding: 14px 18px; margin-bottom: 24px; font-size: 12.5px; color: #64748b; line-height: 1.5;">
            <strong style="color: #1e293b;">💡 Petunjuk Contoh Pengisian Data:</strong>
            Teks petunjuk berwarna samar (*faint*) di bawah setiap kolom memberikan contoh format isian. Pilihan guru menampilkan seluruh daftar guru terdaftar & terverifikasi beserta NIP resminya.
        </div>

        <form action="{{ route('jadwal.store') }}" method="POST" id="createForm" novalidate>
            @csrf

            <div class="form-grid">
                
                <!-- Hari -->
                <div class="form-group">
                    <label for="hari">Hari <span class="required">*</span></label>
                    <select name="hari" id="hari" class="@error('hari') input-error @enderror" onchange="updateJamOptionsByHari()">
                        <option value="" disabled {{ old('hari') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Hari --</option>
                        @foreach($hariOptions as $h)
                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: Senin / Jumat</span>
                    @error('hari')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="id_kelas">Kelas <span class="required">*</span></label>
                    <select name="id_kelas" id="id_kelas" class="@error('id_kelas') input-error @enderror">
                        <option value="" disabled {{ old('id_kelas') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: X RPL 1 / XI TKJ 2</span>
                    @error('id_kelas')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jam Mulai -->
                <div class="form-group">
                    <label for="id_jam_mulai">Jam Mulai (ke-) <span class="required">*</span></label>
                    <select name="id_jam_mulai" id="id_jam_mulai" class="@error('id_jam_mulai') input-error @enderror">
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
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: Jam ke-1</span>
                    @error('id_jam_mulai')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jam Selesai -->
                <div class="form-group">
                    <label for="id_jam_selesai">Jam Selesai (ke-) <span class="required">*</span></label>
                    <select name="id_jam_selesai" id="id_jam_selesai" class="@error('id_jam_selesai') input-error @enderror">
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
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: Jam ke-3</span>
                    @error('id_jam_selesai')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group full-width">
                    <label for="id_mapel">Mata Pelajaran <span class="required">*</span></label>
                    <select name="id_mapel" id="id_mapel" class="@error('id_mapel') input-error @enderror">
                        <option value="" disabled {{ old('id_mapel') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->kode_mapel }} - {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: M001 - Pemrograman Web</span>
                    @error('id_mapel')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Guru Pengampu -->
                <div class="form-group full-width">
                    <label for="id_guru">Guru Pengampu <span class="required">*</span></label>
                    <select name="id_guru" id="id_guru" class="@error('id_guru') input-error @enderror">
                        <option value="" disabled {{ old('id_guru') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Guru (Terverifikasi) --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama_guru }} — NIP. {{ $g->nip ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: Budi Santoso, S.Pd. — NIP. 198203152010011002</span>
                    @error('id_guru')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ruangan -->
                <div class="form-group full-width">
                    <label for="id_ruangan">Ruangan <span class="required">*</span></label>
                    <select name="id_ruangan" id="id_ruangan" class="@error('id_ruangan') input-error @enderror">
                        <option value="" disabled {{ old('id_ruangan') ? '' : 'selected' }} style="color:#94a3b8;">-- Pilih Ruangan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id_ruangan }}" {{ old('id_ruangan') == $r->id_ruangan ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }} ({{ $r->jenis_ruangan }})
                            </option>
                        @endforeach
                    </select>
                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin-top: 3px;">Contoh saran: Lab. RPL 1 (Laboratorium)</span>
                    @error('id_ruangan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="btn-group">
                <a href="{{ route('jadwal.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Jadwal
                </button>
            </div>
        </form>

    </div>

</div>

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

        const form = document.getElementById('createForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous input errors
                const inputs = form.querySelectorAll('select, input');
                inputs.forEach(i => i.classList.remove('input-error'));

                let missingFields = [];
                const hari         = document.getElementById('hari').value;
                const idKelas      = document.getElementById('id_kelas').value;
                const idGuru       = document.getElementById('id_guru').value;
                const idMapel      = document.getElementById('id_mapel').value;
                const idRuangan    = document.getElementById('id_ruangan').value;
                const idJamMulai   = document.getElementById('id_jam_mulai').value;
                const idJamSelesai = document.getElementById('id_jam_selesai').value;

                if (!hari) { missingFields.push('Hari'); document.getElementById('hari').classList.add('input-error'); }
                if (!idKelas) { missingFields.push('Kelas'); document.getElementById('id_kelas').classList.add('input-error'); }
                if (!idGuru) { missingFields.push('Guru Pengampu'); document.getElementById('id_guru').classList.add('input-error'); }
                if (!idMapel) { missingFields.push('Mata Pelajaran'); document.getElementById('id_mapel').classList.add('input-error'); }
                if (!idRuangan) { missingFields.push('Ruangan'); document.getElementById('id_ruangan').classList.add('input-error'); }
                if (!idJamMulai) { missingFields.push('Jam Mulai'); document.getElementById('id_jam_mulai').classList.add('input-error'); }
                if (!idJamSelesai) { missingFields.push('Jam Selesai'); document.getElementById('id_jam_selesai').classList.add('input-error'); }

                if (missingFields.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulir Belum Lengkap!',
                        html: 'Silakan isi kolom wajib berikut sebelum menyimpan:<br><br><strong style="color:#ef4444;">' + missingFields.join(', ') + '</strong>',
                        confirmButtonColor: '#4f46e5'
                    });
                    return false;
                }

                if (parseInt(idJamSelesai) < parseInt(idJamMulai)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Jam Pelajaran Tidak Sesuai!',
                        text: 'Jam Selesai tidak boleh lebih kecil dari Jam Mulai.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return false;
                }

                if (hari !== 'Jumat' && (parseInt(idJamMulai) > 10 || parseInt(idJamSelesai) > 10)) {
                    document.getElementById('id_jam_selesai').classList.add('input-error');
                    Swal.fire({
                        icon: 'error',
                        title: 'Batas Jam Pelajaran Terlampaui!',
                        text: 'Untuk hari ' + hari + ', jam pelajaran maksimal adalah Jam Ke-10 (07:00 - 15:00 WIB). Jam Ke-11 s/d 13 hanya berlaku pada hari Jumat.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return false;
                }

                Swal.fire({
                    title: 'Konfirmasi Tambah Data',
                    text: 'Apakah Anda yakin ingin menambahkan data jadwal pelajaran baru ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Simpan!',
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
</script>

</body>
</html>
