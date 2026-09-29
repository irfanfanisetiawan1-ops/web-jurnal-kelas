<?php

namespace App\Http\Controllers;

use App\Models\LaporanTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaporAdminTuController extends Controller
{
    /**
     * Tampilkan halaman formulir Lapor Admin TU.
     */
    public function index(Request $request)
    {
        $selectedRole = $request->query('role', '');
        $selectedKategori = $request->query('kategori', '');

        // Kategori Kendala Master
        $kategoriList = [
            'Permintaan Pembuatan Akun Baru'     => 'Permintaan Pembuatan Akun Baru (User Baru)',
            'Lupa Kata Sandi / Reset Password'   => 'Lupa Kata Sandi / Reset Password Akun',
            'Akun Terkunci / Gagal Login'        => 'Akun Terkunci / Gagal Masuk Sistem',
            'Perubahan Data Profil'              => 'Koreksi / Perubahan Data Profil Pengguna',
            'Kendala Jadwal & Presensi'          => 'Kendala Jadwal Pelajaran / Presensi / Jurnal',
            'Kendala Teknis / Error Sistem'      => 'Kendala Teknis / Error Sistem Lainnya',
        ];

        // Daftar 9 Role Pengguna
        $roleList = [
            'guru'            => 'Guru Mengajar',
            'wali_kelas'      => 'Wali Kelas',
            'guru_piket'      => 'Guru Piket',
            'waka_kesiswaan'  => 'Waka Kesiswaan',
            'waka_kurikulum'  => 'Waka Kurikulum',
            'waka_sdm'        => 'Waka SDM',
            'kepala_sekolah'  => 'Kepala Sekolah',
            'satpam'          => 'Satpam Gerbang',
            'orang_tua'       => 'Orang Tua',
        ];

        return view('auth.lapor_admin_tu', compact('kategoriList', 'roleList', 'selectedRole', 'selectedKategori'));
    }

    /**
     * Simpan data pengaduan / permohonan ke database.
     */
    public function store(Request $request)
    {
        $nipRoles = ['guru', 'wali_kelas', 'waka_kesiswaan', 'waka_kurikulum', 'waka_sdm', 'kepala_sekolah'];

        $validator = Validator::make($request->all(), [
            'nama_pelapor'     => 'required|string|min:3|max:150',
            'role_pelapor'     => 'required|string|in:guru,wali_kelas,guru_piket,waka_kesiswaan,waka_kurikulum,waka_sdm,kepala_sekolah,satpam,orang_tua',
            'nomor_identitas'  => [
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request, $nipRoles) {
                    if ($value !== null && $value !== '') {
                        if (in_array($request->role_pelapor, $nipRoles)) {
                            if (!preg_match('/^[0-9]{18}$/', $value)) {
                                $fail('Data NIP harus 18 digit angka.');
                            }
                        } elseif ($request->role_pelapor === 'orang_tua') {
                            if (!preg_match('/^[0-9]{10}$/', $value)) {
                                $fail('Data NISN harus 10 digit angka.');
                            }
                        }
                    }
                }
            ],
            'no_wa'            => ['required', 'string', 'regex:/^(\+62|62|08)[0-9]{8,14}$/'],
            'email'            => 'nullable|email|max:150',
            'kategori_kendala' => 'required|string|max:100',
            'judul_laporan'    => 'required|string|min:5|max:255',
            'deskripsi_kendala'=> 'required|string|min:10|max:3000',
            'lampiran'         => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120', // maks 5MB
        ], [
            'nama_pelapor.required'     => 'Nama lengkap pelapor wajib diisi.',
            'nama_pelapor.min'          => 'Nama lengkap minimal 3 karakter.',
            'role_pelapor.required'     => 'Silakan pilih peran / status Anda di sekolah.',
            'role_pelapor.in'           => 'Pilihan peran / status tidak valid.',
            'no_wa.required'            => 'Nomor WhatsApp aktif wajib diisi.',
            'no_wa.regex'               => 'Format nomor WhatsApp tidak valid (contoh: 081234567890 atau 6281234567890).',
            'email.email'               => 'Format email tidak valid.',
            'kategori_kendala.required' => 'Pilih jenis kendala / masalah yang dialami.',
            'judul_laporan.required'    => 'Judul laporan wajib diisi.',
            'judul_laporan.min'         => 'Judul laporan minimal 5 karakter.',
            'deskripsi_kendala.required'=> 'Rincian kendala wajib dijelaskan.',
            'deskripsi_kendala.min'     => 'Rincian kendala minimal 10 karakter.',
            'lampiran.max'              => 'Ukuran foto/berkas maksimal 5 MB.',
            'lampiran.mimes'            => 'Format foto/berkas harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali isian formulir Anda.');
        }

        // Upload lampiran langsung ke public/uploads/laporan_tu
        $lampiranName = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/laporan_tu');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0777, true);
            }
            $file->move($destPath, $filename);
            $lampiranName = $filename;
        }

        // Generate kode tiket unik
        $ticketCode = LaporanTu::generateTicketCode();

        // Normalisasi nomor WhatsApp
        $noWa = preg_replace('/[^0-9]/', '', (string)$request->no_wa);
        if (str_starts_with($noWa, '0')) {
            $noWa = '62' . substr($noWa, 1);
        }

        $laporan = LaporanTu::create([
            'ticket_code'       => $ticketCode,
            'nama_pelapor'      => trim($request->nama_pelapor),
            'role_pelapor'      => $request->role_pelapor,
            'nomor_identitas'   => trim($request->nomor_identitas) ?: null,
            'no_wa'             => $noWa,
            'email'             => trim($request->email) ?: null,
            'kategori_kendala'  => $request->kategori_kendala,
            'judul_laporan'     => trim($request->judul_laporan),
            'deskripsi_kendala' => trim($request->deskripsi_kendala),
            'lampiran'          => $lampiranName,
            'status'            => 'pending',
            'ip_address'        => $request->ip(),
            'user_agent'        => $request->userAgent(),
        ]);

        return redirect()->route('lapor.admin-tu.success', ['ticket_code' => $ticketCode])
            ->with('success', 'Laporan Anda berhasil dikirim ke Administrator Tata Usaha!');
    }

    /**
     * Halaman sukses kirim laporan.
     */
    public function success($ticket_code)
    {
        $laporan = LaporanTu::where('ticket_code', $ticket_code)->firstOrFail();
        return view('auth.lapor_admin_tu_sukses', compact('laporan'));
    }

    /**
     * Cek status laporan berdasarkan tiket / nomor WA / NIP.
     */
    public function cekStatus(Request $request)
    {
        $keyword = trim($request->query('keyword', ''));
        $results = collect();

        if ($keyword !== '') {
            $cleanWa = preg_replace('/[^0-9]/', '', $keyword);
            if (str_starts_with($cleanWa, '0')) {
                $cleanWaVariant = '62' . substr($cleanWa, 1);
            } else {
                $cleanWaVariant = $cleanWa;
            }

            $results = LaporanTu::where('ticket_code', $keyword)
                ->orWhere('no_wa', $keyword)
                ->orWhere('no_wa', $cleanWaVariant)
                ->orWhere('nomor_identitas', $keyword)
                ->latest()
                ->take(5)
                ->get();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'count'   => $results->count(),
                'data'    => $results->map(function ($item) {
                    return [
                        'ticket_code'       => $item->ticket_code,
                        'nama_pelapor'      => $item->nama_pelapor,
                        'role_label'        => $item->role_label,
                        'kategori_kendala'  => $item->kategori_kendala,
                        'judul_laporan'     => $item->judul_laporan,
                        'lampiran_url'      => $item->lampiran_url,
                        'is_image'          => $item->is_image_lampiran,
                        'status'            => $item->status,
                        'status_badge'      => $item->status_badge,
                        'tanggapan_admin'   => $item->tanggapan_admin,
                        'responded_at'      => $item->responded_at ? $item->responded_at->format('d/m/Y H:i') : null,
                        'created_at'        => $item->created_at->format('d/m/Y H:i'),
                    ];
                }),
            ]);
        }

        return view('auth.lapor_admin_tu_cek', compact('results', 'keyword'));
    }
}
