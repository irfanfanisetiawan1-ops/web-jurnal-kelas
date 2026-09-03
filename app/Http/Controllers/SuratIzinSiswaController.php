<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaSuratIzin;
use App\Models\Siswa;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SuratIzinSiswaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa'   => 'required|integer',
            'id_kelas'   => 'required|integer',
            'tanggal'    => 'required|date',
            'kategori'   => 'required|in:Sakit,Izin,Dispen Luar Sekolah',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/surat_izin_siswa'), $fotoName);
        }

        $surat = SiswaSuratIzin::create([
            'id_siswa'         => $request->id_siswa,
            'id_kelas'         => $request->id_kelas,
            'tanggal'          => $request->tanggal,
            'kategori'         => $request->kategori,
            'keterangan'       => $request->keterangan,
            'foto_bukti'       => $fotoName,
            'id_petugas_piket' => auth()->id(),
        ]);

        $jurnals = JurnalMengajar::whereDate('tanggal', $request->tanggal)
            ->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            })->get();

        foreach ($jurnals as $jurnal) {
            JurnalDetailKetidakhadiran::updateOrCreate(
                [
                    'id_jurnal' => $jurnal->id_jurnal,
                    'id_siswa'  => $request->id_siswa,
                ],
                [
                    'keterangan' => $request->kategori . ' (Di-input Guru Piket)',
                ]
            );
        }

        return redirect()->back()->with('success', 'Surat Izin Siswa berhasil di-input oleh Guru Piket! Presensi kelas telah otomatis diperbarui (Auto-Sync).');
    }
}
