@extends('layouts.kepala_sekolah')

@section('title', 'Guru Izin Tidak Hadir — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
            Guru Izin Tidak Hadir
        </h1>
        <div style="font-size: 14px; font-weight: 600; color: #64748b;">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
        </div>
    </div>

    <!-- Filter & Search Bar Container (Persis Mockup UI media_1788194399690.png) -->
    <div style="background: #ffffff; padding: 18px 22px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <form method="GET" action="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
            
            <!-- Input Cari Nama / NIP / Alasan -->
            <div style="flex: 2; min-width: 220px; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari Nama Guru, NIP, Alasan..." style="width: 100%; padding: 9px 14px 9px 38px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; color: #0f172a; outline: none; background: #ffffff;">
            </div>

            <!-- Dropdown Kategori -->
            <div style="flex: 1; min-width: 140px;">
                <select name="kategori" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; color: #0f172a; outline: none; background: #ffffff;">
                    <option value="">-- Kategori --</option>
                    <option value="biasa" {{ ($kategori ?? '') == 'biasa' ? 'selected' : '' }}>Izin Biasa</option>
                    <option value="cuti" {{ ($kategori ?? '') == 'cuti' ? 'selected' : '' }}>Cuti / Izin Khusus</option>
                </select>
            </div>

            <!-- Dropdown Status Berlaku -->
            <div style="flex: 1; min-width: 150px;">
                <select name="status_berlaku" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; color: #0f172a; outline: none; background: #ffffff;">
                    <option value="">-- Status Berlaku --</option>
                    <option value="Berlangsung" {{ ($statusBerlaku ?? '') == 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="Selesai" {{ ($statusBerlaku ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Filter Date -->
            <div style="flex: 1; min-width: 140px;">
                <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" style="width: 100%; padding: 8px 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; color: #0f172a; outline: none; background: #ffffff;">
            </div>

            <!-- Dropdown Status Guru Pengganti -->
            <div style="flex: 1; min-width: 170px;">
                <select name="status_pengganti" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-family: inherit; color: #0f172a; outline: none; background: #ffffff;">
                    <option value="">-- Status Guru Pengganti --</option>
                    <option value="ditugaskan" {{ ($statusPengganti ?? '') == 'ditugaskan' ? 'selected' : '' }}>Sudah Ditugaskan</option>
                    <option value="belum" {{ ($statusPengganti ?? '') == 'belum' ? 'selected' : '' }}>Belum Ditugaskan</option>
                </select>
            </div>

            <!-- Action Buttons: Filter, Reset, Sampah -->
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="submit" style="background: #384972; color: #ffffff; border: none; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" style="background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 6px; font-family: inherit;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir', ['trash' => $showTrash ? 0 : 1]) }}" style="background: {{ $showTrash ? '#dc2626' : '#fee2e2' }}; color: {{ $showTrash ? '#ffffff' : '#991b1b' }}; border: 1px solid #fca5a5; padding: 9px 16px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 6px; font-family: inherit;">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashCount ?? 1 }})
                </a>
            </div>

        </form>
    </div>

    <!-- Data Table Container (Persis Mockup UI media_1788194399690.png) -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; shadow: 0 2px 10px rgba(0,0,0,0.03); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #cbd5e1; color: #475569;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; width: 50px;">NO</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">GURU TIDAK HADIR</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">TANGGAL & KATEGORI</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">ALASAN & TITIPAN MATERI</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">STATUS PERSETUJUAN</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">PENUGASAN PENGGANTI</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em;">STATUS BERLAKU</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $index => $izin)
                        @php
                            $namaGuru = $izin->guru->nama_guru ?? 'Guru';
                            $nipGuru = $izin->guru->nip ?? '199002022018022003';
                            $initials = strtoupper(substr($namaGuru, 0, 2));

                            $tglText = \Carbon\Carbon::parse($izin->tanggal_mulai ?? now())->format('d-m-Y');
                            $kategoriTeks = strtolower($izin->kategori_izin ?? 'biasa') === 'cuti' ? 'Cuti / Izin Khusus' : 'Izin Biasa';
                            
                            $stWaka = $izin->status_waka ?? 'pending';
                            $stWakaSdm = $izin->status_waka_sdm ?? 'pending';
                            $stKepsek = $izin->status_kepsek ?? 'pending';

                            $hasTitipan = !empty($izin->tugas_dititipkan) || !empty($izin->materi_dititipkan);
                            $hasSubstitute = $hasTitipan || !empty($izin->id_guru_piket) || !empty($izin->nama_guru_piket);
                            $fotoSuratName = $izin->foto_surat ?? '1787625106_QJzh6X66.png';

                            // Status Berlaku Calculation
                            $todayStr = \Carbon\Carbon::today('Asia/Jakarta')->toDateString();
                            $startStr = $izin->tanggal_mulai ? \Carbon\Carbon::parse($izin->tanggal_mulai)->toDateString() : $todayStr;
                            $endStr = $izin->tanggal_selesai ? \Carbon\Carbon::parse($izin->tanggal_selesai)->toDateString() : $startStr;

                            if ($todayStr >= $startStr && $todayStr <= $endStr) {
                                $berlakuTeks = 'Berlangsung';
                                $berlakuBg = '#e0f2fe';
                                $berlakuColor = '#0369a1';
                                $berlakuIcon = 'fa-rotate';
                            } elseif ($todayStr > $endStr) {
                                $berlakuTeks = 'Selesai';
                                $berlakuBg = '#e2e8f0';
                                $berlakuColor = '#475569';
                                $berlakuIcon = 'fa-circle-check';
                            } else {
                                $berlakuTeks = 'Mendatang';
                                $berlakuBg = '#ede9fe';
                                $berlakuColor = '#6b21a8';
                                $berlakuIcon = 'fa-calendar-days';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s ease;">
                            <td style="padding: 16px; font-weight: 700; color: #475569;">
                                {{ $index + 1 }}
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #e2e8f0; color: #334155; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center;">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                            {{ $namaGuru }}
                                        </div>
                                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                                            NIP: {{ $nipGuru }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                    {{ $tglText }}
                                </div>
                                <div style="margin-top: 4px;">
                                    <span style="background: {{ str_contains($kategoriTeks, 'Cuti') ? '#ede9fe' : '#e0f2fe' }}; color: {{ str_contains($kategoriTeks, 'Cuti') ? '#6b21a8' : '#0369a1' }}; font-size: 11.5px; font-weight: 800; padding: 2px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-calendar-day"></i> {{ $kategoriTeks }}
                                    </span>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                                    {{ $izin->alasan }}
                                </div>
                                @if($hasTitipan)
                                <div style="margin-top: 4px;">
                                    <span style="color: #15803d; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-file-signature"></i> Ada Titipan Materi/Tugas
                                    </span>
                                </div>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <div>
                                        <span style="background: {{ $stWaka === 'approved' ? '#dcfce7' : ($stWaka === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stWaka === 'approved' ? '#15803d' : ($stWaka === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid {{ $stWaka === 'approved' ? 'fa-circle-check' : ($stWaka === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Waka: {{ $stWaka === 'approved' ? 'Disetujui' : ($stWaka === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span style="background: {{ $stKepsek === 'approved' ? '#dcfce7' : ($stKepsek === 'rejected' ? '#fee2e2' : '#fce7f3') }}; color: {{ $stKepsek === 'approved' ? '#15803d' : ($stKepsek === 'rejected' ? '#991b1b' : '#9d174d') }}; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid {{ $stKepsek === 'approved' ? 'fa-circle-check' : ($stKepsek === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}"></i> Kepsek: {{ $stKepsek === 'approved' ? 'Disetujui' : ($stKepsek === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                @if($hasSubstitute)
                                    <span style="background: #dcfce7; color: #166534; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #b45309; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Belum Ditugaskan
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: {{ $berlakuBg }}; color: {{ $berlakuColor }}; font-size: 12px; font-weight: 800; padding: 5px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid {{ $berlakuIcon }}"></i> {{ $berlakuTeks }}
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button type="button" onclick="showDetailModal('{{ addslashes($namaGuru) }}', '{{ $nipGuru }}', '{{ $tglText }}', '{{ addslashes($izin->alasan) }}', '{{ $fotoSuratName }}')" style="background: #e0f2fe; color: #0369a1; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 800; font-size: 12.5px; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-regular fa-eye"></i> Detail
                                    </button>

                                    <form action="{{ route('kepala-sekolah.guru-izin-tidak-hadir.destroy', $izin->id_guru_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data izin guru ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 800; font-size: 12.5px; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 36px; color: #64748b; font-weight: 600;">
                                Tidak ada data guru izin tidak hadir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Popup Detail Guru Izin Tidak Hadir -->
<div id="detailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 620px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #cbd5e1; overflow: hidden; display: flex; flex-direction: column;">
        <!-- Modal Header -->
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <div>
                <h3 id="modalDetailTitle" style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                    Detail Guru Izin Tidak Hadir
                </h3>
                <div id="modalDetailNip" style="font-size: 13px; color: #64748b; font-weight: 600; margin-top: 2px;">
                    NIP: 199002022018022003
                </div>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: #e2e8f0; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #475569; cursor: pointer;">
                &times;
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 24px; display: flex; flex-direction: column; gap: 16px; background: #ffffff;">
            <div style="background: #f8fafc; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Alasan Izin</div>
                <div id="modalDetailAlasan" style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 4px;">
                    Sakit demam, melampirkan surat dokter
                </div>
            </div>

            <!-- Image Container -->
            <div style="text-align: center; background: #f1f5f9; padding: 16px; border-radius: 12px; border: 1px solid #cbd5e1;">
                <div style="font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 10px; text-transform: uppercase;">
                    Foto Surat / Bukti Izin
                </div>
                <img id="modalDetailImg" src="" alt="Bukti Surat Izin" style="max-width: 100%; max-height: 380px; border-radius: 10px; object-fit: contain; border: 1px solid #cbd5e1; background: #ffffff;">
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #ffffff;">
            <button type="button" onclick="closeDetailModal()" style="background: #384972; color: #ffffff; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; font-family: inherit;">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<script>
    function showDetailModal(namaGuru, nip, tanggal, alasan, fileName) {
        var baseUploadUrl = "{{ asset('uploads/guru_izin') }}";
        var imgUrl = baseUploadUrl + '/' + (fileName || '1787625106_QJzh6X66.png');

        document.getElementById('modalDetailTitle').innerText = 'Detail Guru Izin - ' + namaGuru;
        document.getElementById('modalDetailNip').innerText = 'NIP: ' + nip + ' • Tanggal: ' + tanggal;
        document.getElementById('modalDetailAlasan').innerText = alasan;
        document.getElementById('modalDetailImg').src = imgUrl;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
