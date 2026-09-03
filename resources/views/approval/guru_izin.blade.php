<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Izin Tidak Masuk Guru — EDU JOURNAL</title>
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
        .form-control { width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-family: inherit; margin-top: 0; box-sizing: border-box; font-size: 13.5px; background: #f8fafc; outline: none; transition: all 0.2s ease; }
        .form-control:focus { background: #ffffff; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .alert { padding: 14px; border-radius: 10px; margin-bottom: 18px; font-size: 13.5px; font-weight: 700; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-cuti { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-file-signature fa-2x"></i>
            <h2>Persetujuan Izin Tidak Masuk Guru</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #b6c5e3;">Verifikasi Otentikasi Pengajuan Izin dari Guru Piket</p>
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

            @if(($izin->kategori_izin === 'cuti') || ($izin->tanggal_mulai && $izin->tanggal_selesai && \Carbon\Carbon::parse($izin->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($izin->tanggal_selesai)) + 1 > 3))
                <div class="alert alert-cuti">
                    <i class="fa-solid fa-ribbon"></i> <strong>KATEGORI: CUTI / IZIN KHUSUS (> 3 HARI)</strong><br>
                    <span style="font-size: 12px; font-weight: 600; color: #ea580c;">
                        Pengajuan izin ini berlangsung lebih dari 3 hari. Mohon periksa Keterangan Khusus & Dokumen Bukti di bawah ini.
                    </span>
                </div>
            @endif

            <div class="info-group">
                <div class="info-label">Nama Guru Mengajar</div>
                <div class="info-value">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                @if($izin->guru && $izin->guru->nip)
                    <div style="font-size: 12px; color: #64748b; font-weight: 600;">NIP. {{ $izin->guru->nip }}</div>
                @endif
            </div>

            <div class="info-group">
                <div class="info-label">Tanggal Tidak Masuk & Durasi</div>
                <div class="info-value">
                    @if($izin->tanggal_mulai === $izin->tanggal_selesai || !$izin->tanggal_selesai)
                        {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') }} (1 Hari Full)
                    @else
                        {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-m-Y') }} ({{ $izin->durasi ?? 'Multi Hari' }})
                    @endif
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Alasan Izin Tidak Hadir</div>
                <div class="info-value" style="color: #0f172a; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 6px;">
                    "{{ $izin->alasan }}"
                </div>
            </div>

            @if($izin->keterangan_khusus)
            <div class="info-group">
                <div class="info-label" style="color: #c2410c;">KETERANGAN KHUSUS CUTI (> 3 HARI)</div>
                <div class="info-value" style="color: #9a3412; background: #fff7ed; padding: 10px 14px; border-radius: 8px; border: 1px solid #fed7aa; margin-top: 6px; font-weight: 600;">
                    <i class="fa-solid fa-note-sticky"></i> {{ $izin->keterangan_khusus }}
                </div>
            </div>
            @endif

            @if($izin->materi_dititipkan)
            <div class="info-group">
                <div class="info-label">Titipan Materi / Tugas Siswa</div>
                <div class="info-value" style="font-size: 13.5px; color: #334155;">{{ $izin->materi_dititipkan }}</div>
            </div>
            @endif

            @if($izin->foto_surat)
            <div class="info-group">
                <div class="info-label">Foto Surat Keterangan / Bukti Resmi</div>
                <div class="info-value" style="margin-top: 8px;">
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('uploads/guru_izin/' . $izin->foto_surat) }}" alt="Foto Dokumen Bukti" style="max-width: 100%; max-height: 240px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: contain;">
                    </div>
                    <a href="{{ asset('uploads/guru_izin/' . $izin->foto_surat) }}" target="_blank" style="color: #2563eb; text-decoration: none; font-size: 13px; font-weight: 700;">
                        <i class="fa-solid fa-up-right-from-square"></i> Buka Dokumen Surat Keterangan Ukuran Full
                    </a>
                </div>
            </div>
            @endif

            <!-- Kartu Status Resmi Berjenjang Saat Ini -->
            <div class="info-group">
                <div class="info-label">Status Persetujuan Berjenjang Resmi</div>
                
                <!-- Status Waka Kurikulum -->
                @if($izin->status_waka === 'approved')
                    <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> Waka Kurikulum telah <u>MENYETUJUI</u> pengajuan izin ini.
                        @if($izin->catatan_waka)
                            <div style="font-size: 12px; font-weight: 500; margin-top: 4px; color: #166534;"><i class="fa-solid fa-comment-dots"></i> Catatan Waka Kurikulum: "{{ $izin->catatan_waka }}"</div>
                        @endif
                    </div>
                @elseif($izin->status_waka === 'rejected')
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i> Waka Kurikulum telah <u>MENOLAK</u> pengajuan izin ini.
                        @if($izin->catatan_waka)
                            <div style="font-size: 12px; font-weight: 500; margin-top: 4px; color: #991b1b;"><i class="fa-solid fa-comment-dots"></i> Alasan Penolakan Waka Kurikulum: "{{ $izin->catatan_waka }}"</div>
                        @endif
                    </div>
                @else
                    <div style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: 10px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-clock"></i> Waka Kurikulum: Menunggu Persetujuan
                    </div>
                @endif

                <!-- Status Waka SDM -->
                @if($izin->status_waka_sdm === 'approved')
                    <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> Waka SDM telah <u>MENYETUJUI</u> pengajuan izin ini.
                    </div>
                @elseif($izin->status_waka_sdm === 'rejected')
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i> Waka SDM telah <u>MENOLAK</u> pengajuan izin ini.
                    </div>
                @else
                    <div style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: 10px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-clock"></i> Waka SDM: Menunggu Persetujuan
                    </div>
                @endif

                <!-- Status Kepsek -->
                @if($izin->status_kepsek === 'approved')
                    <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> Kepala Sekolah telah <u>MENYETUJUI</u> pengajuan izin ini.
                        @if($izin->catatan_kepsek)
                            <div style="font-size: 12px; font-weight: 500; margin-top: 4px; color: #166534;"><i class="fa-solid fa-comment-dots"></i> Catatan Kepsek: "{{ $izin->catatan_kepsek }}"</div>
                        @endif
                    </div>
                @elseif($izin->status_kepsek === 'rejected')
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 12px 16px; border-radius: 12px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i> Kepala Sekolah telah <u>MENOLAK</u> pengajuan izin ini.
                        @if($izin->catatan_kepsek)
                            <div style="font-size: 12px; font-weight: 500; margin-top: 4px; color: #991b1b;"><i class="fa-solid fa-comment-dots"></i> Alasan Penolakan Kepsek: "{{ $izin->catatan_kepsek }}"</div>
                        @endif
                    </div>
                @else
                    <div style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: 10px; margin-top: 8px; font-weight: 700; font-size: 13px;">
                        <i class="fa-solid fa-clock"></i> Kepala Sekolah: Menunggu Persetujuan
                    </div>
                @endif
            </div>

            @php
                $allProcessed = ($izin->status_waka !== 'pending' && $izin->status_waka_sdm !== 'pending' && $izin->status_kepsek !== 'pending') || ($izin->status_final === 'rejected');
            @endphp

            @if($allProcessed)
                <!-- Jika seluruh pihak telah memberikan keputusan, hilangkan tombol dan tampilkan banner terkunci -->
                <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 20px; text-align: center; color: #334155; font-weight: 800; margin-top: 20px;">
                    <i class="fa-solid fa-lock fa-2x" style="color: #64748b; margin-bottom: 8px;"></i><br>
                    PERSETUJUAN SELESAI PROSES<br>
                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">
                        Pengajuan izin guru tidak hadir mengajar ini telah selesai diproses secara penuh oleh Waka Kurikulum, Waka SDM, dan Kepala Sekolah.
                    </span>
                </div>
            @else
                <!-- Form Otentikasi NIP & Password + Tombol Setujui/Tolak -->
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

                <form action="{{ route('approval.guru-izin.process', $izin->token_approval) }}" method="POST" id="approvalForm">
                    @csrf
                    
                    <div style="margin-bottom: 18px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Pilih Peran / Jabatan Anda</label>
                        <select name="role_approver" id="roleApproverSelect" class="form-control" style="height: 46px;" required>
                            <option value="waka" {{ $izin->status_waka !== 'pending' ? 'disabled' : '' }}>
                                Waka Kurikulum @if($izin->status_waka !== 'pending') (Telah Merespon) @endif
                            </option>
                            <option value="waka_sdm" {{ $izin->status_waka_sdm !== 'pending' ? 'disabled' : '' }}>
                                Waka SDM @if($izin->status_waka_sdm !== 'pending') (Telah Merespon) @endif
                            </option>
                            <option value="kepala_sekolah" {{ $izin->status_kepsek !== 'pending' ? 'disabled' : '' }}>
                                Kepala Sekolah @if($izin->status_kepsek !== 'pending') (Telah Merespon) @endif
                            </option>
                        </select>
                    </div>

                    <!-- Input NIP dengan Counter 0/18 digit & Restriksi Strict 18 Digit Angka -->
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label class="info-label" style="margin-bottom: 0;">NIP <span style="color:#dc2626;">*</span></label>
                            <span id="nipDigitCounter" style="color: #2563eb; font-weight: 700; font-size: 12.5px; font-family: monospace;">0/18 digit</span>
                        </div>
                        <div style="position: relative;">
                            <i class="fa-regular fa-user" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;"></i>
                            <input type="text" name="nip_username" id="nipUsernameInput" class="form-control" placeholder="Masukkan 18 digit NIP Anda" value="{{ old('nip_username') }}" maxlength="18" inputmode="numeric" pattern="[0-9]*" oninput="updateNipCounter(this)" autocomplete="off" style="padding-left: 42px; height: 46px;" required>
                        </div>
                    </div>

                    <!-- Input Password dengan Ikon Gembok & Toggle Mata Show/Hide -->
                    <div style="margin-bottom: 20px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Password <span style="color:#dc2626;">*</span></label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-lock" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;"></i>
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password Anda" maxlength="100" style="padding-left: 42px; padding-right: 42px; height: 46px;" required>
                            <i id="togglePasswordIcon" class="fa-regular fa-eye" onclick="togglePasswordVisibility()" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px; cursor: pointer;" title="Tampilkan / Sembunyikan Password"></i>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="info-label" style="display: block; margin-bottom: 6px;">Catatan / Alasan Penolakan <span style="color:#dc2626;">(Wajib diisi jika Menolak)</span></label>
                        <textarea name="catatan" id="catatanInput" class="form-control" rows="3" placeholder="Tuliskan catatan persetujuan atau alasan jika menolak pengajuan izin guru ini...">{{ old('catatan') }}</textarea>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" name="action" value="approved" onclick="return confirmAction('approved')" class="btn btn-success" style="flex:1;">
                            <i class="fa-solid fa-circle-check"></i> Setujui Izin
                        </button>
                        <button type="submit" name="action" value="rejected" onclick="return confirmAction('rejected')" class="btn btn-danger" style="flex:1;">
                            <i class="fa-solid fa-circle-xmark"></i> Tolak Izin
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
    function updateNipCounter(input) {
        // Restriksi strict: hanya perbolehkan angka 0-9 dan maksimal 18 digit
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 18) {
            input.value = input.value.slice(0, 18);
        }
        
        const val = input.value;
        const counterEl = document.getElementById('nipDigitCounter');
        const len = val.length;
        
        counterEl.innerText = len + '/18 digit';
        if (len === 18) {
            counterEl.style.color = '#16a34a'; // Green when exactly 18 digits
        } else {
            counterEl.style.color = '#2563eb'; // Standard blue
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

    document.addEventListener('DOMContentLoaded', function() {
        const nipInput = document.getElementById('nipUsernameInput');
        if (nipInput && nipInput.value) {
            updateNipCounter(nipInput);
        }
    });

    function confirmAction(act) {
        const roleSelect = document.getElementById('roleApproverSelect');
        const selectedRoleText = roleSelect.options[roleSelect.selectedIndex].text;
        const nipInput = document.getElementById('nipUsernameInput').value.trim();
        const passwordInput = document.getElementById('passwordInput').value.trim();
        const catatanInput = document.getElementById('catatanInput').value.trim();

        if (!nipInput) {
            alert('Harap masukkan NIP Anda untuk verifikasi identitas!');
            document.getElementById('nipUsernameInput').focus();
            return false;
        }

        if (nipInput.length !== 18) {
            alert('Format NIP tidak valid! NIP PNS/ASN harus tepat 18 digit angka (Saat ini: ' + nipInput.length + ' digit).');
            document.getElementById('nipUsernameInput').focus();
            return false;
        }

        if (!passwordInput) {
            alert('Harap masukkan Password akun Anda untuk otentikasi!');
            document.getElementById('passwordInput').focus();
            return false;
        }

        if (act === 'rejected') {
            if (!catatanInput) {
                alert('Harap tuliskan penjelasan alasan penolakan pada kolom catatan sebelum menolak izin!');
                document.getElementById('catatanInput').focus();
                return false;
            }
            return confirm('Apakah Anda yakin ingin MENOLAK pengajuan izin guru ini sebagai ' + selectedRoleText + '?');
        } else {
            return confirm('Apakah Anda yakin ingin MENYETUJUI pengajuan izin guru ini sebagai ' + selectedRoleText + '?');
        }
    }
    </script>
</body>
</html>
