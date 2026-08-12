<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruangan — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

        /* Top Banner */
        .bg-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #14b8a6 100%);
            z-index: 0;
        }

        .container {
            max-width: 680px;
            margin: 0 auto;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        /* Back Link */
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

        /* Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        .form-icon {
            width: 46px; height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 14px -3px rgba(13, 148, 136, 0.35);
        }
        .form-title h2 { font-size: 20px; font-weight: 800; color: #0f172a; }
        .form-title p { font-size: 13px; color: #64748b; margin-top: 2px; }

        /* Form Inputs */
        .form-group {
            margin-bottom: 22px;
        }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }
        .form-label span { color: #ef4444; }

        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            outline: none;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .form-input:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        }
        .form-input.is-invalid {
            border-color: #ef4444;
        }

        .error-message {
            font-size: 12px;
            color: #ef4444;
            font-weight: 600;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Radio Option Grid */
        .jenis-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        @media (max-width: 480px) {
            .jenis-grid { grid-template-columns: 1fr; }
        }
        .jenis-option {
            position: relative;
        }
        .jenis-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }
        .jenis-card {
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #ffffff;
        }
        .jenis-card:hover {
            border-color: #0d9488;
            background: #f0fdfa;
        }
        .jenis-option input[type="radio"]:checked + .jenis-card {
            border-color: #0d9488;
            background: #ccfbf1;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
        }
        .jenis-badge-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #475569;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        .jenis-option input[type="radio"]:checked + .jenis-card .jenis-badge-icon {
            background: #0d9488;
            color: #ffffff;
        }
        .jenis-label-text {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Submit Buttons */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        .btn-cancel {
            padding: 11px 22px;
            font-size: 13.5px;
            font-weight: 700;
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-cancel:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .btn-submit {
            padding: 11px 24px;
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 16px -2px rgba(13, 148, 136, 0.35);
            transition: all 0.2s ease;
            font-family: inherit;
        }
        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -2px rgba(13, 148, 136, 0.45);
        }

        /* Modal Overlay */
        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(4px);
            z-index: 900;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease forwards;
        }
        .modal-bg.active { display: flex; }
        .modal-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
            text-align: center;
            transform: scale(0.95);
            animation: scaleUp 0.2s ease forwards;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleUp { to { transform: scale(1); } }

        .modal-icon-wrap {
            width: 56px; height: 56px;
            background: #ccfbf1;
            color: #0d9488;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .modal-card h3 { font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .modal-card p { font-size: 13.5px; color: #64748b; margin-bottom: 20px; line-height: 1.5; }

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            text-align: left;
            font-size: 13px;
            margin-bottom: 24px;
        }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .summary-item:last-child { margin-bottom: 0; }
        .summary-label { color: #64748b; font-weight: 600; }
        .summary-val { color: #0f172a; font-weight: 700; }

        .modal-actions { display: flex; gap: 12px; }
        .btn-modal-cancel {
            flex: 1;
            padding: 11px;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
        }
        .btn-modal-confirm {
            flex: 1;
            padding: 11px;
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <!-- Back Link -->
    <a href="{{ route('ruangan.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Data Ruangan
    </a>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div class="form-title">
                <h2>Edit Data Ruangan</h2>
                <p>Perbarui informasi ruangan "{{ $ruangan->nama_ruangan }}" di bawah ini</p>
            </div>
        </div>

        <form id="editRuanganForm" action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST" onsubmit="event.preventDefault(); showConfirmEditModal();">
            @csrf
            @method('PUT')

            <!-- Nama Ruangan -->
            <div class="form-group">
                <label for="nama_ruangan" class="form-label">
                    Nama Ruangan <span>*</span>
                </label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <input type="text" 
                           id="nama_ruangan" 
                           name="nama_ruangan" 
                           class="form-input @error('nama_ruangan') is-invalid @enderror" 
                           placeholder="Contoh: Lab Komputer 1" 
                           value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" 
                           required>
                </div>
                @error('nama_ruangan')
                    <div class="error-message">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Jenis Ruangan -->
            <div class="form-group">
                <label class="form-label">
                    Jenis Ruangan <span>*</span>
                </label>
                <div class="jenis-grid">
                    @foreach($jenisOptions as $option)
                        <label class="jenis-option">
                            <input type="radio" 
                                   name="jenis_ruangan" 
                                   value="{{ $option }}" 
                                   {{ old('jenis_ruangan', $ruangan->jenis_ruangan) == $option ? 'checked' : '' }}>
                            <div class="jenis-card">
                                <div class="jenis-badge-icon">
                                    @if($option == 'Kelas Biasa')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    @elseif($option == 'Lab')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    @elseif($option == 'Ruang Praktik')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                    @else
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                    @endif
                                </div>
                                <span class="jenis-label-text">{{ $option }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('jenis_ruangan')
                    <div class="error-message">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('ruangan.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Ruangan
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Modal Konfirmasi Edit -->
<div class="modal-bg" id="confirmEditModal">
    <div class="modal-card">
        <div class="modal-icon-wrap">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h3>Simpan Perubahan Ruangan?</h3>
        <p>Apakah Anda yakin ingin memperbarui data ruangan ini di database?</p>
        
        <div class="summary-box">
            <div class="summary-item">
                <span class="summary-label">Nama Ruangan:</span>
                <span class="summary-val" id="summaryNama"></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Jenis Ruangan:</span>
                <span class="summary-val" id="summaryJenis"></span>
            </div>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeConfirmEditModal()">Batal</button>
            <button type="button" class="btn-modal-confirm" onclick="submitEditForm()">Ya, Perbarui Data</button>
        </div>
    </div>
</div>

<script>
    function showConfirmEditModal() {
        const namaInput = document.getElementById('nama_ruangan').value.trim();
        const jenisRadio = document.querySelector('input[name="jenis_ruangan"]:checked');
        const jenisVal = jenisRadio ? jenisRadio.value : '';

        if (!namaInput) {
            document.getElementById('nama_ruangan').reportValidity();
            return;
        }

        document.getElementById('summaryNama').textContent = namaInput;
        document.getElementById('summaryJenis').textContent = jenisVal;
        document.getElementById('confirmEditModal').classList.add('active');
    }

    function closeConfirmEditModal() {
        document.getElementById('confirmEditModal').classList.remove('active');
    }

    function submitEditForm() {
        document.getElementById('editRuanganForm').submit();
    }

    document.getElementById('confirmEditModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmEditModal();
    });
</script>

</body>
</html>
