@extends('layouts.orang_tua')

@section('title', 'Pengajuan Izin — Jurnal SMEA')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <!-- Top Page Header -->
    <div style="margin-bottom: 24px;">
        <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
            Jurnal SMEA &gt; <a href="{{ route('orang-tua.dashboard') }}" style="color: #475569; text-decoration: none;">Dashboard</a> &gt; <span style="color: #1e293b;">Pengajuan Izin</span>
        </div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
            <i class="fa-solid fa-file-signature" style="color: #384972; margin-right: 8px;"></i> Pengajuan Surat Izin Anak
        </h1>
        <p style="margin: 4px 0 0; color: #64748b; font-size: 13.5px;">Formulir permohonan izin (Sakit/Izin) yang terhubung langsung dengan pihak sekolah.</p>
    </div>

    @if($siswa)
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

        <!-- Form Pengajuan Izin -->
        <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                <i class="fa-solid fa-pen-to-square" style="color: #4a5e8c;"></i> Form Izin Baru
            </h3>

            <form action="{{ route('orang-tua.store-izin') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Nama Siswa</label>
                    <input type="text" value="{{ $siswa->nama_siswa }} ({{ $siswa->kelas->nama_kelas ?? '-' }})" readonly style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; color: #475569;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tanggal Izin <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; color: #0f172a;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Kategori Izin <span style="color: #ef4444;">*</span></label>
                    <select name="kategori" required style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; color: #0f172a;">
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin (Acara Keluarga / Kepentingan Lain)</option>
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Keterangan / Alasan <span style="color: #ef4444;">*</span></label>
                    <textarea name="keterangan" rows="3" required placeholder="Jelaskan alasan permohonan izin..." style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 500; color: #0f172a; font-family: inherit;"></textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Lampiran Foto Bukti (Surat Dokter/Ortu)</label>
                    <input type="file" name="foto_bukti" accept="image/*" style="width: 100%; font-size: 12.5px; color: #475569;">
                </div>

                <button type="submit" style="width: 100%; background: #384972; color: #ffffff; padding: 12px; border: none; border-radius: 12px; font-weight: 800; font-size: 14px; cursor: pointer; transition: background 0.2s ease;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Surat Izin
                </button>
            </form>
        </div>

        <!-- Riwayat Surat Izin -->
        <div style="background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                <i class="fa-solid fa-clock-rotate-left" style="color: #4a5e8c;"></i> Riwayat Surat Izin
            </h3>

            @forelse($suratIzinList as $surat)
                <div style="padding: 12px 14px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <span style="font-weight: 800; font-size: 13px; color: #0f172a;">{{ $surat->kategori }}</span>
                        <span style="font-size: 11.5px; font-weight: 700; color: #64748b;">{{ $surat->tanggal }}</span>
                    </div>
                    <p style="margin: 0; font-size: 12.5px; color: #334155;">{{ $surat->keterangan ?? 'Tanpa keterangan' }}</p>
                    @if($surat->foto_url)
                        <div style="margin-top: 8px;">
                            <a href="{{ $surat->foto_url }}" target="_blank" style="font-size: 11.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                                <i class="fa-solid fa-paperclip"></i> Lihat Foto Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div style="text-align: center; color: #64748b; padding: 30px 0; font-size: 13.5px;">
                    Belum ada riwayat permohonan surat izin.
                </div>
            @endforelse
        </div>

    </div>
    @endif

</div>
@endsection
