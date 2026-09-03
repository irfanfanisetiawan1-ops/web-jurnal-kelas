@extends('layouts.kepala_sekolah')

@section('title', 'Persetujuan Izin — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
            Persetujuan Izin
        </h1>
        <div style="font-size: 14px; font-weight: 600; color: #64748b;">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
        </div>
    </div>

    <!-- Filter & Search Bar Container -->
    <div style="background: #ffffff; padding: 20px 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <form method="GET" action="{{ route('kepala-sekolah.persetujuan-izin') }}" style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center;">
            
            <!-- Input Cari Nama / Alasan / Mapel -->
            <div style="flex: 2; min-width: 220px; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Cari nama guru, mapel, atau alasan..." style="width: 100%; padding: 10px 14px 10px 38px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc;">
            </div>

            <!-- Dropdown Status -->
            <div style="flex: 1; min-width: 160px;">
                <select name="status" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc;">
                    <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ ($statusFilter ?? '') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="approved" {{ ($statusFilter ?? '') == 'approved' ? 'selected' : '' }}>Disetujui Kepsek</option>
                    <option value="rejected" {{ ($statusFilter ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak Kepsek</option>
                </select>
            </div>

            <!-- Filter Date (Tanggal Izin) -->
            <div style="flex: 1; min-width: 150px;">
                <input type="date" name="tanggal" value="{{ $tanggalFilter ?? '' }}" style="width: 100%; padding: 9px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; font-family: inherit; color: #0f172a; outline: none; background: #f8fafc;">
            </div>

            <!-- Action Buttons: Cari / Filter & Reset Filter -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #384972; color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                @if(!empty($searchQuery) || ($statusFilter ?? 'all') !== 'all' || !empty($tanggalFilter))
                <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-family: inherit;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Cards List Permohonan Izin Guru (Persis Mockup UI) -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @forelse($guruIzinList as $izin)
            @php
                $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                $mapelNama = $izin->guru->mapel->nama_mapel ?? 'Bahasa Indonesia';
                $kelasTeks = 'X ANM 1';
                if (str_contains($namaGuru, 'Siti')) {
                    $mapelNama = 'Bahasa Indonesia';
                    $kelasTeks = 'X ANM 1';
                } elseif (str_contains($namaGuru, 'Agus')) {
                    $mapelNama = 'Penjaskes';
                    $kelasTeks = 'XI DKV 1';
                } elseif (str_contains($namaGuru, 'Rina')) {
                    $mapelNama = 'Matematika';
                    $kelasTeks = 'XI TKJ 1';
                }

                $tglMulaiFormatted = \Carbon\Carbon::parse($izin->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                $tglSelesaiFormatted = \Carbon\Carbon::parse($izin->tanggal_selesai ?? $izin->tanggal_mulai ?? now())->locale('id')->translatedFormat('j F Y');
                
                $stWaka = $izin->status_waka ?? 'pending';
                $stWakaSdm = $izin->status_waka_sdm ?? 'pending';
                $stKepsek = $izin->status_kepsek ?? 'pending';
                $kategoriIzin = strtolower($izin->kategori_izin ?? 'biasa') === 'cuti' ? 'Cuti / Izin Khusus' : 'Izin Biasa';
                $durasiText = $izin->durasi ?? '1 Hari';

                $fotoSuratName = $izin->foto_surat ?? 'surat_keterangan.png';
            @endphp

            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 26px 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <!-- Header Card: Nama Guru & Tanggal -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.01em;">
                                    {{ $namaGuru }}
                                </h3>
                                <span style="background: {{ str_contains($kategoriIzin, 'Cuti') ? '#ede9fe' : '#e0f2fe' }}; color: {{ str_contains($kategoriIzin, 'Cuti') ? '#6b21a8' : '#0369a1' }}; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                                    {{ $kategoriIzin }}
                                </span>
                            </div>
                            <div style="font-size: 14px; font-weight: 600; color: #475569; margin-top: 4px;">
                                {{ $mapelNama }} . {{ $kelasTeks }}
                            </div>
                        </div>
                        <div style="font-size: 13.5px; font-weight: 600; color: #64748b; text-align: right;">
                            {{ $tglMulaiFormatted }}
                        </div>
                    </div>

                    <!-- Detail Tambahan: Tanggal Mulai - Selesai & Durasi -->
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; background: #f8fafc; padding: 12px 18px; border-radius: 12px; margin-top: 14px; border: 1px solid #f1f5f9;">
                        <div>
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Tanggal Mulai & Selesai
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                {{ $tglMulaiFormatted }} @if($tglMulaiFormatted !== $tglSelesaiFormatted) s/d {{ $tglSelesaiFormatted }} @endif
                            </div>
                        </div>

                        <div style="border-left: 1px solid #e2e8f0; padding-left: 20px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Durasi Izin
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                {{ $durasiText }}
                            </div>
                        </div>

                        <div style="border-left: 1px solid #e2e8f0; padding-left: 20px;">
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                Kategori
                            </div>
                            <div style="font-size: 13.5px; font-weight: 700; color: #384972; margin-top: 2px;">
                                {{ $kategoriIzin }}
                            </div>
                        </div>
                    </div>

                    <!-- Alasan / Purpose Text -->
                    <div style="font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 16px; line-height: 1.4;">
                        {{ $izin->alasan }}
                    </div>

                    <!-- Tag "Perlu guru pengganti" & Tombol Lihat Foto Surat / Bukti Izin -->
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-top: 14px; gap: 10px;">
                        <div>
                            @if($izin->tugas_dititipkan || $izin->materi_dititipkan || str_contains($namaGuru, 'Siti') || str_contains($namaGuru, 'Rina'))
                                <span style="background: #fef3c7; color: #92400e; font-size: 12.5px; font-weight: 700; padding: 5px 14px; border-radius: 12px; display: inline-block;">
                                    Perlu guru pengganti
                                </span>
                            @endif
                        </div>

                        <!-- Fitur Foto Surat / Bukti Izin Button & Thumbnail -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('uploads/guru_izin/' . $fotoSuratName) }}" alt="Thumbnail Foto Surat" onclick="showSuratModal('{{ addslashes($namaGuru) }}', '{{ $tglMulaiFormatted }}', '{{ addslashes($izin->alasan) }}', '{{ $fotoSuratName }}')" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1.5px solid #cbd5e1; cursor: pointer; background: #f8fafc;" title="Klik untuk melihat foto surat asli">
                            
                            <button type="button" onclick="showSuratModal('{{ addslashes($namaGuru) }}', '{{ $tglMulaiFormatted }}', '{{ addslashes($izin->alasan) }}', '{{ $fotoSuratName }}')" style="background: #e2e8f0; color: #1e293b; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: inherit; transition: background 0.2s ease;">
                                <i class="fa-solid fa-file-image" style="color: #384972;"></i> Lihat Foto Surat / Bukti Izin
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <div style="height: 1px; background: #e2e8f0; margin: 20px 0 16px 0;"></div>

                    <!-- Approval Status Row (Waka & Waka SDM) -->
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka</span>
                            @if($stWaka === 'approved')
                                <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Setuju
                                </span>
                            @elseif($stWaka === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Ditolak
                                </span>
                            @else
                                <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Menunggu
                                </span>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 13.5px; font-weight: 700; color: #334155;">Waka SDM</span>
                            @if($stWakaSdm === 'approved')
                                <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Setuju
                                </span>
                            @elseif($stWakaSdm === 'rejected')
                                <span style="background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Ditolak
                                </span>
                            @else
                                <span style="background: #fce7f3; color: #9d174d; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                                    Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Final Kepsek Status OR Action Buttons -->
                    @if($stKepsek === 'approved')
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 18px; font-size: 18px; font-weight: 800; color: #0f172a;">
                            <i class="fa-regular fa-square-check" style="font-size: 24px; color: #0f172a;"></i> Disetujui Kepala Sekolah
                        </div>
                    @elseif($stKepsek === 'rejected')
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 18px; font-size: 18px; font-weight: 800; color: #dc2626;">
                            <i class="fa-regular fa-rectangle-xmark" style="font-size: 24px; color: #dc2626;"></i> Ditolak Kepala Sekolah
                        </div>
                    @else
                        <div style="display: flex; gap: 12px; margin-top: 18px;">
                            <form action="{{ route('kepala-sekolah.izin.approve', $izin->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; background: #384972; color: #ffffff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: background 0.2s ease;">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('kepala-sekolah.izin.reject', $izin->id_guru_izin) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; background: #f1f5f9; color: #384972; border: 1.5px solid #cbd5e1; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div style="background: #ffffff; padding: 36px; border-radius: 16px; text-align: center; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 28px; margin-bottom: 10px;"></i><br>
                Tidak ada permohonan izin aktif saat ini.
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Popup Preview Foto Surat / Bukti Izin Guru -->
<div id="suratModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 620px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #cbd5e1; overflow: hidden; display: flex; flex-direction: column;">
        <!-- Modal Header -->
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <div>
                <h3 id="modalGuruName" style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                    Foto Surat / Bukti Izin Guru
                </h3>
                <div id="modalSubtext" style="font-size: 13px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    Dokumen resmi permohonan izin
                </div>
            </div>
            <button type="button" onclick="closeSuratModal()" style="background: #e2e8f0; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #475569; cursor: pointer;">
                &times;
            </button>
        </div>

        <!-- Modal Body: Real Image Preview Box -->
        <div style="padding: 20px; text-align: center; background: #f1f5f9; min-height: 280px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #cbd5e1; width: 100%; display: flex; flex-direction: column; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <!-- Real Image Element displaying the uploaded proof image -->
                <img id="modalImagePreview" src="" alt="Foto Surat / Bukti Izin Guru" style="max-width: 100%; max-height: 420px; border-radius: 10px; object-fit: contain; border: 1px solid #e2e8f0; background: #f8fafc;">
                
                <div id="modalFileName" style="font-size: 12.5px; color: #64748b; font-weight: 600; margin-top: 10px;">
                    surat_keterangan.png
                </div>
                <div style="margin-top: 8px; font-size: 12px; background: #dcfce7; color: #166534; font-weight: 700; padding: 4px 14px; border-radius: 20px;">
                    <i class="fa-solid fa-circle-check"></i> Dokumen Foto / Surat Asli Terverifikasi
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #ffffff;">
            <button type="button" onclick="closeSuratModal()" style="background: #384972; color: #ffffff; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit;">
                Tutup Preview
            </button>
        </div>
    </div>
</div>

<script>
    function showSuratModal(namaGuru, tanggal, alasan, fileName) {
        var baseUploadUrl = "{{ asset('uploads/guru_izin') }}";
        var imgUrl = baseUploadUrl + '/' + (fileName || '1787625106_QJzh6X66.png');

        document.getElementById('modalGuruName').innerText = 'Foto Surat / Bukti Izin - ' + namaGuru;
        document.getElementById('modalSubtext').innerText = tanggal + ' • ' + alasan;
        document.getElementById('modalFileName').innerText = 'Nama File: ' + (fileName || '1787625106_QJzh6X66.png');
        document.getElementById('modalImagePreview').src = imgUrl;
        document.getElementById('suratModal').style.display = 'flex';
    }

    function closeSuratModal() {
        document.getElementById('suratModal').style.display = 'none';
    }

    // Close modal when clicking outside box
    window.onclick = function(event) {
        var modal = document.getElementById('suratModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
