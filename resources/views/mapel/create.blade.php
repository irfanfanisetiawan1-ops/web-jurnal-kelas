@extends('layouts.admin')

@section('title', 'Tambah Mapel Baru — EDU JOURNAL')

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

    .btn-auto-gen {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    .btn-auto-gen:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        color: #1d4ed8;
    }
    .field-feedback {
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .field-feedback.is-valid { color: #16a34a; }
    .field-feedback.is-invalid { color: #dc2626; }
    .field-feedback.is-warning { color: #d97706; }

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
            <h1>Tambah Mata Pelajaran</h1>
            <p>Input data mata pelajaran baru dalam sistem kurikulum</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('mapel.index') }}"><i class="fa-solid fa-book"></i> Master Mapel</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Mapel</span>
    </div>

    <div class="create-card">
        <div class="create-header-row">
            <h2>Form Tambah Data Mapel Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan mata pelajaran baru ke sistem dengan validasi otomatis.</p>
        </div>

        <form action="{{ route('mapel.store') }}" method="POST" onsubmit="return validateCreateForm(event)">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}"
                        class="form-control {{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}" placeholder="Contoh: Bahasa Inggris, Matematika" required
                        maxlength="100" autocomplete="off" oninput="handleNamaInput(this.value)">
                    <div id="namaFeedback" class="field-feedback"></div>
                    @error('nama_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label for="kode_mapel" style="margin-bottom:0;">Kode Mapel <span style="color:#ef4444;">*</span></label>
                        <button type="button" class="btn-auto-gen" onclick="triggerGenKode()" title="Generate otomatis kode mapel">
                            Generate Otomatis
                        </button>
                    </div>
                    <input type="text" id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel') }}"
                        class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}" placeholder="Contoh: BIG-01, MAT-01" required
                        maxlength="15" autocomplete="off" style="text-transform:uppercase; font-family:monospace; font-weight:700; letter-spacing:0.5px;"
                        oninput="handleKodeInput(this.value)">
                    <div id="kodeFeedback" class="field-feedback"></div>
                    @error('kode_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('mapel.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save" id="btnSubmit">
                    Simpan Data Mapel
                </button>
            </div>
        </form>
    </div>

<script>
    const existingMapels = @json($existingMapelsList ?? []);
    let userEditedKode = false;

    const knownMapelPrefixes = {
        'BAHASA INDONESIA': 'BIN', 'BAHASA INGGRIS': 'BIG', 'BAHASA JAWA': 'BJAW', 'BAHASA JEPANG': 'BJEP',
        'BAHASA JERMAN': 'BJER', 'BAHASA ARAB': 'BARB', 'BAHASA MANDARIN': 'BMND', 'MATEMATIKA': 'MAT',
        'PENDIDIKAN AGAMA ISLAM': 'PAI', 'PENDIDIKAN AGAMA KRISTEN': 'PAK', 'PENDIDIKAN AGAMA KATOLIK': 'PKAT',
        'PENDIDIKAN AGAMA HINDU': 'PAH', 'PENDIDIKAN AGAMA BUDDHA': 'PAB', 'PENDIDIKAN AGAMA KHONGHUCU': 'PAKH',
        'PENDIDIKAN PANCASILA': 'PPKN', 'PENDIDIKAN KEWARGANEGARAAN': 'PKN', 'PENDIDIKAN JASMANI': 'PJOK',
        'PENJASKES': 'PJOK', 'SENI BUDAYA': 'SEN', 'SENI RUPA': 'SRUP', 'SENI MUSIK': 'SMUS', 'SENI TARI': 'STAR',
        'SENI TEATER': 'STEA', 'SEJARAH': 'SEJ', 'INFORMATIKA': 'INF', 'BIMBINGAN KONSELING': 'BK',
        'PROJEK ILMU PENGETAHUAN ALAM DAN SOSIAL': 'IPAS', 'ILMU PENGETAHUAN ALAM': 'IPA', 'ILMU PENGETAHUAN SOSIAL': 'IPS',
        'KODING DAN KECERDASAN ARTIFISIAL': 'KDK', 'KREATIVITAS, INOVASI, DAN KEWIRAUSAHAAN': 'PKK', 'KONSENTRASI KEAHLIAN': 'KKA'
    };

    function calcKode(nama) {
        if (!nama || !nama.trim()) return '';
        const cleanName = nama.trim().toUpperCase();
        let prefix = null;
        for (const [key, code] of Object.entries(knownMapelPrefixes)) {
            if (cleanName.includes(key)) { prefix = code; break; }
        }
        if (!prefix) {
            const words = cleanName.split(/[\s,\-_]+/);
            if (words.length >= 2) {
                let acronym = '';
                const stopWords = ['DAN', 'YANG', 'UNTUK', 'DI', 'KE', 'DARI', 'BUDI', 'PEKERTI', 'KELAS', 'TINGKAT'];
                for (const w of words) {
                    if (!stopWords.includes(w) && w.length > 0) acronym += w.charAt(0);
                }
                prefix = (acronym.length >= 2 && acronym.length <= 6) ? acronym : words[0].substring(0, 3);
            } else {
                const alphanumeric = cleanName.replace(/[^A-Z0-9]/g, '');
                prefix = alphanumeric.substring(0, Math.min(4, alphanumeric.length));
            }
        }
        prefix = (prefix || 'MPL').replace(/[^A-Z0-9]/g, '');
        const usedCodes = existingMapels.map(m => (m.kode || '').toUpperCase());
        let index = 1, candidate = '';
        do {
            candidate = prefix + '-' + String(index).padStart(2, '0');
            index++;
        } while (usedCodes.includes(candidate) && index < 1000);
        return candidate;
    }

    function handleNamaInput(val) {
        val = (val || '').trim();
        const namaInput = document.getElementById('nama_mapel');
        const kodeInput = document.getElementById('kode_mapel');
        const feedback = document.getElementById('namaFeedback');

        if (!val) {
            feedback.innerHTML = '';
            namaInput.classList.remove('is-invalid');
        } else {
            const dup = existingMapels.find(m => m.nama_lower === val.toLowerCase());
            if (dup) {
                namaInput.classList.add('is-invalid');
                feedback.className = dup.is_trash ? 'field-feedback is-warning' : 'field-feedback is-invalid';
                feedback.innerHTML = `Nama mapel sudah terdaftar (${dup.kode}).`;
            } else {
                namaInput.classList.remove('is-invalid');
                feedback.className = 'field-feedback is-valid';
                feedback.innerHTML = `Nama mapel valid &amp; tersedia.`;
            }
        }

        if (!userEditedKode && val) {
            const code = calcKode(val);
            kodeInput.value = code;
            handleKodeInput(code, false);
        }
    }

    function triggerGenKode() {
        const nama = document.getElementById('nama_mapel').value;
        const code = calcKode(nama || 'Mapel');
        const kodeInput = document.getElementById('kode_mapel');
        kodeInput.value = code;
        userEditedKode = false;
        handleKodeInput(code, false);
    }

    function handleKodeInput(val, isManual = true) {
        if (isManual) userEditedKode = true;
        val = (val || '').trim().toUpperCase();
        const kodeInput = document.getElementById('kode_mapel');
        const feedback = document.getElementById('kodeFeedback');
        kodeInput.value = val;

        if (!val) {
            feedback.innerHTML = '';
            kodeInput.classList.remove('is-invalid');
            return;
        }

        if (!/^[A-Z0-9\-_]+$/.test(val)) {
            kodeInput.classList.add('is-invalid');
            feedback.className = 'field-feedback is-invalid';
            feedback.innerHTML = `Format kode tidak valid.`;
            return;
        }

        const dup = existingMapels.find(m => m.kode === val);
        if (dup) {
            kodeInput.classList.add('is-invalid');
            feedback.className = dup.is_trash ? 'field-feedback is-warning' : 'field-feedback is-invalid';
            feedback.innerHTML = `Kode sudah dipakai oleh "${dup.nama}".`;
        } else {
            kodeInput.classList.remove('is-invalid');
            feedback.className = 'field-feedback is-valid';
            feedback.innerHTML = `Kode mapel valid &amp; tersedia.`;
        }
    }

    function validateCreateForm(e) {
        const nama = document.getElementById('nama_mapel').value.trim();
        const kode = document.getElementById('kode_mapel').value.trim().toUpperCase();

        let errors = [];
        if (!nama) errors.push('Nama Mata Pelajaran wajib diisi!');
        if (existingMapels.find(m => m.nama_lower === nama.toLowerCase())) errors.push(`Nama Mata Pelajaran "${nama}" sudah terdaftar!`);
        if (kode && existingMapels.find(m => m.kode === kode)) errors.push(`Kode Mapel "${kode}" sudah digunakan!`);

        if (errors.length > 0) {
            e.preventDefault();
            alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
            return false;
        }

        const btn = document.getElementById('btnSubmit');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
            btn.style.opacity = '0.75';
            btn.style.pointerEvents = 'none';
        }
        return true;
    }
</script>
@endsection
