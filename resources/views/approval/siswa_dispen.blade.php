<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Dispensasi Siswa — EDU JOURNAL</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #cbd3e0; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); width: 100%; max-width: 580px; overflow: hidden; border: 1px solid #cbd5e1; }
        .card-header { background: #384972; color: #ffffff; padding: 24px; text-align: center; }
        .card-header h2 { margin: 8px 0 0 0; font-size: 20px; font-weight: 800; }
        .card-body { padding: 24px; }
        .info-group { margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; }
        .info-label { font-size: 11.5px; color: #475569; font-weight: 800; text-transform: uppercase; letter-spacing: 0.03em; }
        .info-value { font-size: 15px; color: #1e293b; font-weight: 700; margin-top: 4px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 10px; font-weight: 800; border: none; cursor: pointer; text-decoration: none; font-size: 14px; transition: all 0.2s ease; }
        .btn-success { background: #16a34a; color: white; }
        .btn-success:hover { background: #15803d; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-wa { background: #25d366; color: white; font-weight: 800; text-decoration: none; }
        .btn-wa:hover { background: #1da851; color: white; }
        .btn-copy { background: #3b82f6; color: white; font-weight: 700; }
        .btn-copy:hover { background: #2563eb; }
        .form-control { width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-family: inherit; margin-top: 0; box-sizing: border-box; font-size: 13.5px; background: #f8fafc; outline: none; transition: all 0.2s ease; }
        .form-control:focus { background: #ffffff; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .alert { padding: 14px; border-radius: 10px; margin-bottom: 18px; font-size: 13.5px; font-weight: 700; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        @media print {
            body { background: #ffffff !important; padding: 0 !important; }
            .card { box-shadow: none !important; border: 1px solid #000 !important; max-width: 100% !important; margin: 0 auto !important; }
            .btn, .form-control, #approvalDispenForm, .alert, .btn-wa, .btn-copy, #togglePasswordIcon, #nipDigitCounter { display: none !important; }
            .card-header { background: #1e293b !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-id-card-clip fa-2x"></i>
            <h2>Persetujuan Dispensasi Siswa</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #b6c5e3;">Verifikasi Otentikasi Pengajuan Dispensasi dari Guru Piket</p>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="info-group">
                <div class="info-label">Kode Dispensasi</div>
                <div class="info-value" style="color: #2563eb; font-size: 18px; font-family: monospace; font-weight: 800;">{{ $dispen->kode_dispen }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Nama Siswa / Kelas</div>
                <div class="info-value">{{ $dispen->siswa->nama_siswa ?? '-' }} ({{ $dispen->kelas->nama_kelas ?? '-' }})</div>
                @if($dispen->siswa && $dispen->siswa->nisn)
                    <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">NISN: {{ $dispen->siswa->nisn }}</div>
                @endif
            </div>

            <div class="info-group">
                <div class="info-label">Tanggal & Rencana Jam Dispensasi</div>
                <div class="info-value">
                    <i class="fa-regular fa-calendar-days" style="color: #2563eb;"></i> {{ \Carbon\Carbon::parse($dispen->tanggal)->format('d-m-Y') }} &nbsp;|&nbsp; 
                    <i class="fa-regular fa-clock" style="color: #d97706;"></i> {{ $dispen->jam_keluar ?? '00:00' }} s/d {{ $dispen->jam_kembali ?? '00:00' }}
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Alasan / Keperluan Dispensasi</div>
                <div class="info-value" style="color: #0f172a; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 6px;">
                    "{{ $dispen->alasan }}"
                </div>
            </div>

            @if($dispen->foto_siswa_live)
            <div class="info-group">
                <div class="info-label"><i class="fa-solid fa-camera" style="color: #2563eb;"></i> Foto Siswa (Live Kamera Saat Pengajuan Dispen)</div>
                <div style="margin-top: 8px; text-align: center; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                    <a href="{{ asset($dispen->foto_siswa_live) }}" target="_blank" title="Klik untuk perbesar foto siswa">
                        <img src="{{ asset($dispen->foto_siswa_live) }}" style="max-width: 100%; max-height: 240px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="Foto Siswa Live">
                    </a>
                    <div style="font-size: 11.5px; color: #166534; margin-top: 6px; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Foto siswa diambil langsung secara live oleh Guru Piket untuk dicocokkan Satpam di pos gerbang.</div>
                </div>
            </div>
            @endif

            @if($dispen->foto_kartu_identitas)
            <div class="info-group">
                <div class="info-label"><i class="fa-solid fa-address-card" style="color: #10b981;"></i> Foto Kartu Identitas Siswa / Kartu Pelajar</div>
                <div style="margin-top: 8px; text-align: center; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                    <a href="{{ asset($dispen->foto_kartu_identitas) }}" target="_blank">
                        <img src="{{ asset($dispen->foto_kartu_identitas) }}" style="max-width: 100%; max-height: 240px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="Kartu Identitas Siswa">
                    </a>
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 6px; font-weight: 600;">*Satpam dapat mencocokkan fisik kartu ini di pintu gerbang sekolah.</div>
                </div>
            </div>
            @endif

            @if($dispen->foto_surat_dispen)
            <div class="info-group">
                <div class="info-label"><i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Foto Surat Dispensasi Resmi</div>
                <div style="margin-top: 8px; text-align: center; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                    <a href="{{ asset($dispen->foto_surat_dispen) }}" target="_blank">
                        <img src="{{ asset($dispen->foto_surat_dispen) }}" style="max-width: 100%; max-height: 240px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="Surat Dispensasi Resmi">
                    </a>
                </div>
            </div>
            @endif

            @if($dispen->ttd_siswa || $dispen->ttd_guru_piket)
            <div class="info-group">
                <div class="info-label"><i class="fa-solid fa-signature" style="color: #2563eb;"></i> Tanda Tangan Digital Pengajuan</div>
                <div style="margin-top: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: center;">
                    <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Tanda Tangan Siswa</div>
                        @if($dispen->ttd_siswa)
                            <img src="{{ asset($dispen->ttd_siswa) }}" style="max-height: 70px; max-width: 100%; object-fit: contain;">
                        @else
                            <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Tidak ada TTD</span>
                        @endif
                        <div style="font-size: 12px; font-weight: 800; color: #0f172a; margin-top: 6px;">{{ $dispen->siswa->nama_siswa ?? '-' }}</div>
                    </div>
                    <div style="background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Tanda Tangan Guru Piket</div>
                        @if($dispen->ttd_guru_piket)
                            <img src="{{ asset($dispen->ttd_guru_piket) }}" style="max-height: 70px; max-width: 100%; object-fit: contain;">
                        @else
                            <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Tidak ada TTD</span>
                        @endif
                        <div style="font-size: 12px; font-weight: 800; color: #0f172a; margin-top: 6px;">{{ $dispen->nama_guru_piket ?? 'Guru Piket' }}</div>
                    </div>
                </div>
            </div>
            @endif

            @if($dispen->nama_waka)
            <div class="info-group">
                <div class="info-label">Waka Kesiswaan Tujuan Pengajuan</div>
                <div class="info-value">{{ $dispen->nama_waka }} @if($dispen->nip_waka) <span style="font-size: 12px; color: #64748b;">(NIP: {{ $dispen->nip_waka }})</span> @endif</div>
            </div>
            @endif

            @if($dispen->nama_guru_piket)
            <div class="info-group">
                <div class="info-label">Petugas Guru Piket Penginput</div>
                <div class="info-value" style="font-size: 13.5px; color: #475569;"><i class="fa-solid fa-user-shield"></i> {{ $dispen->nama_guru_piket }}</div>
            </div>
            @endif

            <div class="info-group">
                <div class="info-label">Status Persetujuan Waka Kesiswaan</div>
                <div class="info-value">
                    @if($dispen->status_waka === 'approved')
                        <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 12px 16px; border-radius: 12px; font-weight: 700; font-size: 13.5px;">
                            <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> Waka Kesiswaan telah <u>MENYETUJUI</u> permohonan dispensasi siswa ini.
                            @if($dispen->catatan_waka)
                                <div style="font-size: 12.5px; font-weight: 500; margin-top: 4px; color: #166534;"><i class="fa-solid fa-comment-dots"></i> Catatan Waka Kesiswaan: "{{ $dispen->catatan_waka }}"</div>
                            @endif
                        </div>
                    @elseif($dispen->status_waka === 'rejected')
                        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 12px 16px; border-radius: 12px; font-weight: 700; font-size: 13.5px;">
                            <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i> Waka Kesiswaan telah <u>MENOLAK</u> permohonan dispensasi siswa ini.
                            @if($dispen->catatan_waka)
                                <div style="font-size: 12.5px; font-weight: 500; margin-top: 4px; color: #991b1b;"><i class="fa-solid fa-comment-dots"></i> Alasan Penolakan Waka Kesiswaan: "{{ $dispen->catatan_waka }}"</div>
                            @endif
                        </div>
                    @else
                        <div style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px;">
                            <i class="fa-solid fa-clock"></i> Status: Menunggu Persetujuan Waka Kesiswaan
                        </div>
                    @endif
                </div>
            </div>

            @if($dispen->status_waka !== 'pending')
                <!-- Tombol Otomatis WhatsApp jika disetujui -->
                @if($dispen->status_waka === 'approved')
                    @php
                        $namaSiswa = $dispen->siswa->nama_siswa ?? 'Siswa';
                        $namaKelas = $dispen->kelas->nama_kelas ?? '-';
                        $jamRange  = ($dispen->jam_keluar ?? '00:00') . ' s/d ' . ($dispen->jam_kembali ?? '00:00');
                        $tglIndo   = \Carbon\Carbon::parse($dispen->tanggal)->format('d-m-Y');
                        $namaWaka  = $dispen->nama_waka ?: (isset($dispen->waka_user) ? $dispen->waka_user->name : 'Waka Kesiswaan');

                        $linkFotoSiswa = $dispen->foto_siswa_live ? asset($dispen->foto_siswa_live) : null;
                        $linkKartu = $dispen->foto_kartu_identitas ? asset($dispen->foto_kartu_identitas) : null;
                        $linkSurat = $dispen->foto_surat_dispen ? asset($dispen->foto_surat_dispen) : null;
                        $linkDispenPage = url('/approval/dispen/' . $dispen->token_wali_kelas);

                        $defaultPesan = "OFFICIAL NOTIFIKASI DISPENSASI SISWA (EDU JOURNAL)\n"
                            . "===============================================\n\n"
                            . "Memberitahukan bahwa permohonan dispensasi siswa berikut telah DISETUJUI oleh Waka Kesiswaan ({$namaWaka}):\n\n"
                            . "* Kode Dispen: {$dispen->kode_dispen}\n"
                            . "* Nama Siswa: {$namaSiswa}\n"
                            . "* Kelas: {$namaKelas}\n"
                            . "* Tanggal & Jam: {$tglIndo} ({$jamRange})\n"
                            . "* Alasan Dispen: {$dispen->alasan}\n";

                        if ($linkFotoSiswa) {
                            $defaultPesan .= "* Lihat Foto Siswa (Live Kamera): {$linkFotoSiswa}\n";
                        }
                        if ($linkKartu) {
                            $defaultPesan .= "* Lihat Foto Kartu Pelajar: {$linkKartu}\n";
                        }
                        if ($linkSurat) {
                            $defaultPesan .= "* Lihat Surat Dispen Resmi: {$linkSurat}\n";
                        }

                        $defaultPesan .= "\n* Link Verifikasi Detail: {$linkDispenPage}\n\n"
                            . "STATUS: TERVERIFIKASI & DISETUJUI WAKA KESISWAAN.\n"
                            . "Petugas Satpam dapat mencocokkan fisik & wajah Siswa serta Kartu Pelajar dengan foto live terlampir, lalu membiarkan siswa keluar sekolah.";

                        $satpamUser = \App\Models\User::where('role', 'satpam')->first();
                        $hpSatpam = $satpamUser && $satpamUser->no_hp ? preg_replace('/[^0-9]/', '', $satpamUser->no_hp) : '';
                        if (str_starts_with($hpSatpam, '0')) {
                            $hpSatpam = '62' . substr($hpSatpam, 1);
                        }

                        $pesanWa = session('pesan_wa_satpam') ?? $defaultPesan;
                        $defaultWaUrl = !empty($hpSatpam) 
                            ? "https://api.whatsapp.com/send?phone={$hpSatpam}&text=" . urlencode($pesanWa)
                            : "https://api.whatsapp.com/send?text=" . urlencode($pesanWa);
                        $waUrl = session('wa_satpam_url') ?? $defaultWaUrl;
                    @endphp

                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 18px; margin-top: 16px;">
                        <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 800; color: #166534; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-brands fa-whatsapp" style="font-size: 18px; color: #25d366;"></i> Link Otomatis Notifikasi WhatsApp Satpam
                        </h4>
                        <p style="font-size: 12.5px; color: #15803d; margin: 0 0 14px 0; font-weight: 600;">
                            Waka Kesiswaan dapat mengeklik tombol di bawah untuk langsung terhubung ke WhatsApp dan mengirimkan verifikasi dispensasi siswa ke Petugas Satpam.
                        </p>
                        
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ $waUrl }}" target="_blank" class="btn btn-wa" style="flex: 1; min-width: 200px;">
                                <i class="fa-brands fa-whatsapp fa-lg"></i> Kirim Notifikasi ke Satpam via WhatsApp
                            </a>
                            <button type="button" onclick="copyDispenLink(`{{ url('/approval/dispen/' . $dispen->token_wali_kelas) }}`)" class="btn btn-copy">
                                <i class="fa-solid fa-copy"></i> Salin Link Verifikasi
                            </button>
                            <button type="button" onclick="window.print()" class="btn" style="background: #475569; color: #ffffff;">
                                <i class="fa-solid fa-print"></i> Cetak Bukti Dispen
                            </button>
                        </div>
                    </div>


                @endif

                <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px; text-align: center; color: #334155; font-weight: 800; margin-top: 20px;">
                    <i class="fa-solid fa-lock fa-2x" style="color: #64748b; margin-bottom: 8px;"></i><br>
                    PERSETUJUAN SELESAI PROSES<br>
                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">
                        Permohonan dispensasi siswa ini telah selesai diproses oleh Waka Kesiswaan.
                    </span>
                </div>
            @else
                <!-- Form Otentikasi NIP & Password Waka Kesiswaan -->
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

                <form action="{{ route('approval.siswa-dispen.process', $dispen->token_wali_kelas) }}" method="POST" id="approvalDispenForm">
                    @csrf

                    <div style="margin-bottom: 16px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Jabatan / Akses Otentikasi</label>
                        <input type="text" class="form-control" value="Wakil Kepala Sekolah Bidang Kesiswaan (Waka Kesiswaan)" readonly style="background: #e2e8f0; font-weight: 700; color: #334155;">
                    </div>

                    <!-- Input NIP dengan Counter 0/18 digit -->
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label class="info-label" style="margin-bottom: 0;">NIP Waka Kesiswaan <span style="color:#dc2626;">*</span></label>
                            <span id="nipDigitCounter" style="color: #2563eb; font-weight: 700; font-size: 12.5px; font-family: monospace;">0/18 digit</span>
                        </div>
                        <div style="position: relative;">
                            <i class="fa-regular fa-user" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;"></i>
                            <input type="text" name="nip_username" id="nipUsernameInput" class="form-control" placeholder="Masukkan 18 digit NIP Waka Kesiswaan Anda" value="{{ old('nip_username') }}" maxlength="30" inputmode="numeric" oninput="updateNipCounter(this)" autocomplete="off" style="padding-left: 42px; height: 46px;" required>
                        </div>
                    </div>

                    <!-- Input Password Waka Kesiswaan dengan Toggle Show/Hide -->
                    <div style="margin-bottom: 20px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Password Waka Kesiswaan <span style="color:#dc2626;">*</span></label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-lock" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;"></i>
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password akun Waka Kesiswaan Anda" maxlength="100" style="padding-left: 42px; padding-right: 42px; height: 46px;" required>
                            <i id="togglePasswordIcon" class="fa-regular fa-eye" onclick="togglePasswordVisibility()" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px; cursor: pointer;" title="Tampilkan / Sembunyikan Password"></i>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Catatan / Alasan Penolakan <span style="color:#dc2626;">(Wajib diisi jika Menolak)</span></label>
                        <textarea name="catatan" id="catatanInput" class="form-control" rows="3" placeholder="Tuliskan catatan persetujuan atau alasan penolakan jika tidak menyetujui dispensasi siswa ini...">{{ old('catatan') }}</textarea>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" name="action" value="approved" onclick="return confirmAction('approved')" class="btn btn-success" style="flex:1;">
                            <i class="fa-solid fa-circle-check"></i> Setujui Dispensasi
                        </button>
                        <button type="submit" name="action" value="rejected" onclick="return confirmAction('rejected')" class="btn btn-danger" style="flex:1;">
                            <i class="fa-solid fa-circle-xmark"></i> Tolak Dispensasi
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
    function updateNipCounter(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 18) {
            input.value = input.value.slice(0, 18);
        }
        
        const val = input.value;
        const counterEl = document.getElementById('nipDigitCounter');
        const len = val.length;
        
        counterEl.innerText = len + '/18 digit';
        if (len === 18) {
            counterEl.style.color = '#16a34a';
        } else {
            counterEl.style.color = '#2563eb';
        }
    }

    function togglePasswordVisibility() {
        const passInput = document.getElementById('passwordInput');
        const icon = document.getElementById('togglePasswordIcon');
        
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function confirmAction(actionType) {
        const nipVal = document.getElementById('nipUsernameInput').value.trim();
        const passVal = document.getElementById('passwordInput').value.trim();
        const catatanVal = document.getElementById('catatanInput').value.trim();

        if (!nipVal) {
            alert('Mohon masukkan NIP Waka Kesiswaan Anda untuk otentikasi.');
            document.getElementById('nipUsernameInput').focus();
            return false;
        }

        if (nipVal.length !== 18) {
            alert('NIP PNS/ASN Waka Kesiswaan harus terdiri dari tepat 18 digit angka! Saat ini: ' + nipVal.length + ' digit.');
            document.getElementById('nipUsernameInput').focus();
            return false;
        }

        if (!passVal) {
            alert('Mohon masukkan Password akun Waka Kesiswaan Anda.');
            document.getElementById('passwordInput').focus();
            return false;
        }

        if (actionType === 'rejected' && !catatanVal) {
            alert('PERHATIAN: Alasan penolakan WAJIB diisi jika Anda memilih untuk MENOLAK permohonan dispensasi siswa ini.');
            document.getElementById('catatanInput').focus();
            return false;
        }

        const msg = actionType === 'approved' 
            ? 'Apakah Anda yakin ingin MENYETUJUI permohonan dispensasi siswa ini?\nStatus akan otomatis diteruskan ke Portal Satpam.' 
            : 'Apakah Anda yakin ingin MENOLAK permohonan dispensasi siswa ini?\nAlasan penolakan akan dikirimkan ke Halaman Guru Piket.';

        return confirm(msg);
    }

    function copyDispenLink(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Link Verifikasi Dispensasi Siswa berhasil disalin ke clipboard!\n\n' + url);
            }).catch(function() {
                fallbackCopy(url);
            });
        } else {
            fallbackCopy(url);
        }
    }

    function fallbackCopy(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            alert('Link Verifikasi Dispensasi Siswa berhasil disalin ke clipboard!\n\n' + text);
        } catch (err) {
            alert('Gagal menyalin link: ' + err);
        }
        document.body.removeChild(textArea);
    }
    </script>
</body>
</html>
