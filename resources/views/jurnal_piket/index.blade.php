@extends('layouts.admin')

@section('title', 'Jurnal Piket — EduJournal')
@section('header_title', 'Kelola Jurnal Guru Piket')
@section('header_subtitle', 'Pencatatan aktivitas, pengajuan izin guru/dispen, dan digitalisasi surat izin siswa')

@section('styles')
<style>
    .action-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .btn-create { background: #4f46e5; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border:none; cursor:pointer; }
    .btn-trash-view { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .table-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 24px; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b; background: #f8fafc; padding: 14px 18px; font-weight: 700; text-align: left; }
    .custom-table td { padding: 14px 18px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #334155; vertical-align: middle; }
    .btn-icon { padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; border: none; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-edit { background: #e0e7ff; color: #3730a3; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .form-box { background: #ffffff; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 24px; }
    .form-box h3 { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; margin-top: 4px; box-sizing: border-box; }
</style>
@endsection

@section('content')

    <!-- Link Generated Alerts -->
    @if(session('approval_url'))
        <div style="background: #e0f2fe; color: #0369a1; padding: 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px;">
            <i class="fa-solid fa-link fa-lg"></i> <strong>Link Persetujuan Waka & Kepsek Berhasil Dibuat:</strong><br>
            <input type="text" readonly value="{{ session('approval_url') }}" class="form-control" style="margin-top: 8px; background: #fff; font-weight: 700; color: #0284c7;" onclick="this.select(); document.execCommand('copy'); alert('Link berhasil disalin!');">
            <span style="font-size: 12px; color: #0284c7; display: block; margin-top: 4px;">*Klik pada kotak di atas untuk menyalin link dan kirimkan ke Waka / Kepala Sekolah via WhatsApp.</span>
        </div>
    @endif

    @if(session('dispen_url'))
        <div style="background: #fef3c7; color: #92400e; padding: 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px;">
            <i class="fa-solid fa-link fa-lg"></i> <strong>Link Persetujuan Wali Kelas Dispen Berhasil Dibuat:</strong><br>
            <input type="text" readonly value="{{ session('dispen_url') }}" class="form-control" style="margin-top: 8px; background: #fff; font-weight: 700; color: #b45309;" onclick="this.select(); document.execCommand('copy'); alert('Link berhasil disalin!');">
            <span style="font-size: 12px; color: #b45309; display: block; margin-top: 4px;">*Klik untuk menyalin dan kirim ke Wali Kelas. Setelah Wali Kelas klik Setuju, Satpam otomatis mendapat notifikasi.</span>
        </div>
    @endif

    <div class="action-header">
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('jurnal-piket.create') }}" class="btn-create" style="background: #384972;">
                <i class="fa-solid fa-plus"></i> Tambah Jurnal Piket Harian
            </a>
            <button onclick="toggleBox('boxGuruIzin')" class="btn-create" style="background: #2563eb;">
                <i class="fa-solid fa-user-clock"></i> Input Guru Izin (Kirim Link Waka/Kepsek)
            </button>
            <button onclick="toggleBox('boxSiswaDispen')" class="btn-create" style="background: #d97706;">
                <i class="fa-solid fa-id-card"></i> Input Dispen Siswa (Kirim Link Wali)
            </button>
            <button onclick="toggleBox('boxSuratIzinSiswa')" class="btn-create" style="background: #16a34a;">
                <i class="fa-solid fa-file-arrow-up"></i> Input Surat Izin Siswa (Auto-Sync)
            </button>
            <a href="{{ route('jurnal-piket.trash') }}" class="btn-trash-view">
                <i class="fa-solid fa-trash-can"></i> Sampah
            </a>
        </div>
    </div>

    <!-- Form 1: Input Izin Guru Tidak Masuk -->
    <div id="boxGuruIzin" class="form-box" style="display: none;">
        <h3><i class="fa-solid fa-user-clock" style="color: #2563eb;"></i> Form Izin Tidak Masuk Guru (Pengiriman Link Waka & Kepsek)</h3>
        <form action="{{ route('jurnal-piket.store-guru-izin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Guru yang Izin</label>
                    <select name="id_guru" class="form-control" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700;">Alasan Izin Tidak Masuk</label>
                <textarea name="alasan" class="form-control" rows="2" placeholder="Tuliskan alasan izin..." required></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #2563eb;"><i class="fa-solid fa-book-open"></i> Titipan Materi Pembelajaran (Opsional)</label>
                    <textarea name="materi_dititipkan" class="form-control" rows="2" placeholder="Materi yang dititipkan untuk diselesaikan siswa..."></textarea>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #2563eb;"><i class="fa-solid fa-tasks"></i> Titipan Tugas / Instruksi (Opsional)</label>
                    <textarea name="tugas_dititipkan" class="form-control" rows="2" placeholder="Instruksi tugas / latihan soal untuk kelas..."></textarea>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Upload File Tugas / Modul (Opsional)</label>
                    <input type="file" name="file_tugas" class="form-control">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Upload Foto Surat / Bukti (Opsional)</label>
                    <input type="file" name="foto_surat" class="form-control" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn-create" style="background: #2563eb;">
                <i class="fa-solid fa-paper-plane"></i> Simpan & Generate Link Persetujuan Waka/Kepsek
            </button>
        </form>
    </div>

    <!-- Form 2: Input Dispen Siswa -->
    <div id="boxSiswaDispen" class="form-box" style="display: none;">
        <h3><i class="fa-solid fa-id-card" style="color: #d97706;"></i> Form Permohonan Dispen Siswa (Kirim Link Wali Kelas -> Sync Realtime Satpam)</h3>
        <form action="{{ route('jurnal-piket.store-siswa-dispen') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Pilih Siswa</label>
                    <select name="id_siswa" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }} (Kelas: {{ $s->kelas->nama_kelas ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Jam Keluar</label>
                    <input type="time" name="jam_keluar" class="form-control" value="09:00">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Jam Kembali</label>
                    <input type="time" name="jam_kembali" class="form-control" value="12:00">
                </div>
            </div>
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700;">Alasan Dispen / Keperluan Keluar Sekolah</label>
                <textarea name="alasan" class="form-control" rows="2" placeholder="Tuliskan keperluan dispen..." required></textarea>
            </div>
            <button type="submit" class="btn-create" style="background: #d97706;">
                <i class="fa-solid fa-share-nodes"></i> Simpan & Kirim Link ke Wali Kelas
            </button>
        </form>
    </div>

    <!-- Form 3: Digitalisasi Surat Izin Siswa (Sakit, Izin, Dispen Luar Sekolah) -->
    <div id="boxSuratIzinSiswa" class="form-box" style="display: none;">
        <h3><i class="fa-solid fa-file-arrow-up" style="color: #16a34a;"></i> Digitalisasi Surat Izin Siswa (Auto-Sync Presensi Kelas)</h3>
        <p style="font-size: 12px; color: #64748b; margin-top: -8px; margin-bottom: 14px;">
            Mengatasi kendala surat fisik terlambat sampai kelas. Data yang diinputkan oleh Guru Piket akan <strong>LANGSUNG MENGABSEN AUTOMATIS</strong> siswa tersebut pada presensi jurnal mengajar & rekap Wali Kelas.
        </p>
        <form action="{{ route('surat-izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Pilih Siswa</label>
                    <select name="id_siswa" id="selectSiswaSurat" class="form-control" onchange="updateKelasSelect()" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_siswa }}" data-kelas="{{ $s->id_kelas }}">{{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Kelas</label>
                    <select name="id_kelas" id="selectKelasSurat" class="form-control" required>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Tanggal Surat</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700;">Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700;">Keterangan / Catatan Tambahan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Berobat ke RS / Dispen Lomba Pramuka Kabupaten">
            </div>
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700;">Foto Bukti Surat (Kamera / File Image)</label>
                <input type="file" name="foto_bukti" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn-create" style="background: #16a34a;">
                <i class="fa-solid fa-sync"></i> Simpan & Auto-Sync Presensi Kelas
            </button>
        </form>
    </div>

    <!-- Tabel Jurnal Piket Utama -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Piket</th>
                        <th>Petugas Piket</th>
                        <th>Status Suasana</th>
                        <th>Catatan / Kejadian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $jp)
                        <tr>
                            <td><strong>{{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}</strong></td>
                            <td><code>{{ $jp->jam_piket }}</code></td>
                            <td><strong>{{ $jp->nama_petugas_piket }}</strong></td>
                            <td>
                                @if($jp->status_suasana == 'Kondusif')
                                    <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">Kondusif</span>
                                @else
                                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">{{ $jp->status_suasana }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($jp->catatan_kejadian, 40) }}</td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('jurnal-piket.edit', $jp->id_jurnal_piket) }}" class="btn-icon btn-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('jurnal-piket.destroy', $jp->id_jurnal_piket) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Hapus entri piket ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 32px;">
                                Belum ada entri jurnal piket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<script>
function toggleBox(id) {
    const box = document.getElementById(id);
    if (box.style.display === 'none' || box.style.display === '') {
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}

function updateKelasSelect() {
    const selectSiswa = document.getElementById('selectSiswaSurat');
    const selectedOption = selectSiswa.options[selectSiswa.selectedIndex];
    const kelasId = selectedOption.getAttribute('data-kelas');
    if (kelasId) {
        document.getElementById('selectKelasSurat').value = kelasId;
    }
}
</script>
@endsection
