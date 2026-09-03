<?php

namespace App\Http\Controllers;

use App\Models\JurnalPiket;
use App\Models\Guru;
use App\Models\GuruIzin;
use App\Models\SiswaDispen;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JurnalPiketController extends Controller
{
    /**
     * [READ] Tampilkan daftar jurnal piket aktif
     */
    public function index()
    {
        $jurnals = JurnalPiket::with('guru')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_jurnal_piket', 'desc')
            ->get();

        $guruIzinList = GuruIzin::with('guru')
            ->orderBy('created_at', 'desc')
            ->get();

        $siswaDispenList = SiswaDispen::with(['siswa', 'kelas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $trashedCount = JurnalPiket::onlyTrashed()->count();
        $guruList = Guru::orderBy('nama_guru')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $siswaList = Siswa::with('kelas')->orderBy('nama_siswa')->get();

        return view('jurnal_piket.index', compact(
            'jurnals', 'guruIzinList', 'siswaDispenList', 'trashedCount',
            'guruList', 'kelasList', 'siswaList'
        ));
    }

    /**
     * [CREATE] Tampilkan form tambah jurnal piket
     */
    public function create()
    {
        $guruList      = Guru::orderBy('nama_guru')->get();
        $statusOptions = ['Kondusif', 'Ada Kejadian', 'Lainnya'];

        return view('jurnal_piket.create', compact('guruList', 'statusOptions'));
    }

    /**
     * [STORE] Simpan jurnal piket baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'             => 'required|date',
            'id_guru'             => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket'  => 'required|string|max:100',
            'jam_piket'           => 'required|string|max:50',
            'catatan_kejadian'    => 'nullable|string',
            'status_suasana'      => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ]);

        JurnalPiket::create([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $request->nama_petugas_piket,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('jurnal-piket.index')
                         ->with('success', 'Data jurnal piket berhasil ditambahkan!');
    }

    /**
     * Guru Piket Input Izin Guru Tidak Masuk -> Generate Link Waka & Kepsek
     */
    public function storeGuruIzin(Request $request)
    {
        $request->validate([
            'id_guru'           => 'required|integer',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date',
            'alasan'            => 'required|string',
            'materi_dititipkan' => 'nullable|string',
            'tugas_dititipkan'  => 'nullable|string',
            'file_tugas'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip|max:10000',
            'foto_surat'        => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto_surat')) {
            $file = $request->file('foto_surat');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/guru_izin'), $fotoName);
        }

        $fileName = null;
        if ($request->hasFile('file_tugas')) {
            $fileTugas = $request->file('file_tugas');
            $fileName = time() . '_tugas_' . Str::random(8) . '.' . $fileTugas->getClientOriginalExtension();
            $fileTugas->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        $token = Str::random(40);

        $izin = GuruIzin::create([
            'id_guru'           => $request->id_guru,
            'tanggal_mulai'     => $request->tanggal_mulai,
            'tanggal_selesai'   => $request->tanggal_selesai,
            'alasan'            => $request->alasan,
            'materi_dititipkan' => $request->materi_dititipkan,
            'tugas_dititipkan'  => $request->tugas_dititipkan,
            'file_tugas'        => $fileName,
            'foto_surat'        => $fotoName,
            'token_approval'    => $token,
            'status_waka'       => 'pending',
            'status_kepsek'     => 'pending',
            'status_final'      => 'pending',
        ]);

        $approvalUrl = url("/approval/guru-izin/{$token}");

        return redirect()->route('jurnal-piket.index')->with([
            'success'      => 'Pengajuan izin guru berhasil dibuat beserta titipan materi/tugas! Kirimkan link berikut ke Waka dan Kepala Sekolah.',
            'approval_url' => $approvalUrl,
        ]);
    }

    /**
     * Guru Piket Input Izin Dispen Siswa -> Generate Link Wali Kelas
     */
    public function storeSiswaDispen(Request $request)
    {
        $request->validate([
            'id_siswa'    => 'required|integer',
            'tanggal'     => 'required|date',
            'jam_keluar'  => 'nullable|string',
            'jam_kembali' => 'nullable|string',
            'alasan'      => 'required|string',
        ]);

        $siswa = Siswa::findOrFail($request->id_siswa);
        $kode  = 'DSP-' . strtoupper(Str::random(6));
        $token = Str::random(40);

        $dispen = SiswaDispen::create([
            'id_siswa'          => $siswa->id_siswa,
            'id_kelas'          => $siswa->id_kelas,
            'kode_dispen'       => $kode,
            'token_wali_kelas'  => $token,
            'tanggal'           => $request->tanggal,
            'jam_keluar'        => $request->jam_keluar,
            'jam_kembali'       => $request->jam_kembali,
            'alasan'            => $request->alasan,
            'status_wali_kelas' => 'pending',
            'status_satpam'     => 'belum_keluar',
        ]);

        $dispenUrl = url("/approval/dispen/{$token}");

        return redirect()->route('jurnal-piket.index')->with([
            'success'    => 'Permohonan dispen siswa berhasil dibuat (Kode: ' . $kode . ')! Kirimkan link persetujuan ke Wali Kelas.',
            'dispen_url' => $dispenUrl,
        ]);
    }

    public function show($id)
    {
        $jurnal = JurnalPiket::with('guru')->findOrFail($id);
        return view('jurnal_piket.show', compact('jurnal'));
    }

    public function edit($id)
    {
        $jurnal        = JurnalPiket::with('guru')->findOrFail($id);
        $guruList      = Guru::orderBy('nama_guru')->get();
        $statusOptions = ['Kondusif', 'Ada Kejadian', 'Lainnya'];

        return view('jurnal_piket.edit', compact('jurnal', 'guruList', 'statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = JurnalPiket::findOrFail($id);

        $request->validate([
            'tanggal'             => 'required|date',
            'id_guru'             => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket'  => 'required|string|max:100',
            'jam_piket'           => 'required|string|max:50',
            'catatan_kejadian'    => 'nullable|string',
            'status_suasana'      => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ]);

        $jurnal->update([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $request->nama_petugas_piket,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('jurnal-piket.index')
                         ->with('success', 'Data jurnal piket berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jurnal = JurnalPiket::findOrFail($id);
        $info   = $jurnal->nama_petugas_piket . ' (' . $jurnal->tanggal . ')';
        $jurnal->delete();

        return redirect()->route('jurnal-piket.index')
                         ->with('success', "Jurnal piket \"$info\" dipindahkan ke Sampah.");
    }

    public function trash()
    {
        $jurnals = JurnalPiket::onlyTrashed()
            ->with('guru')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('jurnal_piket.trash', compact('jurnals'));
    }

    public function restore($id)
    {
        $jurnal = JurnalPiket::onlyTrashed()->findOrFail($id);
        $jurnal->restore();

        return redirect()->route('jurnal-piket.trash')
                         ->with('success', "Jurnal piket \"{$jurnal->nama_petugas_piket}\" berhasil dipulihkan!");
    }

    public function forceDelete($id)
    {
        $jurnal = JurnalPiket::onlyTrashed()->findOrFail($id);
        $nama   = $jurnal->nama_petugas_piket;
        $jurnal->forceDelete();

        return redirect()->route('jurnal-piket.trash')
                         ->with('success', "Jurnal piket \"$nama\" telah dihapus permanen.");
    }
}
