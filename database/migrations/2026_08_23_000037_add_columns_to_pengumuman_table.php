<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('pengumuman')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                if (!Schema::hasColumn('pengumuman', 'id_kelas')) {
                    $table->unsignedBigInteger('id_kelas')->nullable()->after('kategori');
                }
                if (!Schema::hasColumn('pengumuman', 'jam_mengajar')) {
                    $table->string('jam_mengajar', 100)->nullable()->after('id_kelas');
                }
                if (!Schema::hasColumn('pengumuman', 'status')) {
                    $table->string('status', 50)->default('aktif')->after('jam_mengajar');
                }
                if (!Schema::hasColumn('pengumuman', 'keterangan')) {
                    $table->string('keterangan')->nullable()->after('status');
                }
                if (!Schema::hasColumn('pengumuman', 'id_guru')) {
                    $table->unsignedBigInteger('id_guru')->nullable()->after('keterangan');
                }
            });

            // Seed default pengumuman if table has 0 rows or missing sample data
            if (DB::table('pengumuman')->count() === 0) {
                DB::table('pengumuman')->insert([
                    [
                        'judul' => 'Rapat Evaluasi Akhir Semester Genap',
                        'isi' => 'Rapat evaluasi untuk membahas hasil belajar dan kegiatan semester genap bagi seluruh staf pengajar.',
                        'kategori' => 'Rapat',
                        'id_kelas' => null,
                        'jam_mengajar' => '07.00 - 08.30',
                        'status' => 'aktif',
                        'keterangan' => '-',
                        'id_guru' => 1,
                        'tanggal' => '2026-06-05',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'judul' => 'Workshop Kurikulum Merdeka',
                        'isi' => 'Workshop pengembangan kurikulum merdeka bagi seluruh guru produktif dan adaptif normatif.',
                        'kategori' => 'Workshop',
                        'id_kelas' => null,
                        'jam_mengajar' => '08.00 - 09.30',
                        'status' => 'aktif',
                        'keterangan' => 'Sakit',
                        'id_guru' => 2,
                        'tanggal' => '2026-06-05',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'judul' => 'Pengumpulan RPP Semester Genap',
                        'isi' => 'Pengumpulan RPP untuk Semester Genap paling lambat tanggal 10 Juni 2026 di Sekretariat Kurikulum.',
                        'kategori' => 'Kurikulum',
                        'id_kelas' => null,
                        'jam_mengajar' => '10.30 - 12.00',
                        'status' => 'aktif',
                        'keterangan' => 'Urusan Keluarga',
                        'id_guru' => 1,
                        'tanggal' => '2026-06-05',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'judul' => 'Perubahan Jadwal Mengajar',
                        'isi' => 'Terjadi perubahan jadwal mengajar untuk beberapa mata pelajaran kejuruan.',
                        'kategori' => 'Perubahan Jadwal',
                        'id_kelas' => null,
                        'jam_mengajar' => '09.30 - 10.30',
                        'status' => 'selesai',
                        'keterangan' => 'Oleh: Bagas P.',
                        'id_guru' => 3,
                        'tanggal' => '2026-06-04',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'judul' => 'Pengumuman Penerima Tugas Tambahan',
                        'isi' => 'Daftar guru yang mendapatkan tugas tambahan semester genap dan pembimbing ekstrakurikuler.',
                        'kategori' => 'Penugasan',
                        'id_kelas' => null,
                        'jam_mengajar' => '12.30 - 14.00',
                        'status' => 'selesai',
                        'keterangan' => '-',
                        'id_guru' => 1,
                        'tanggal' => '2026-06-04',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'judul' => 'Sosialisasi Tata Tertib Sekolah',
                        'isi' => 'Sosialisasi tata tertib sekolah bagi seluruh guru, wali kelas, dan staf kependidikan.',
                        'kategori' => 'Umum',
                        'id_kelas' => null,
                        'jam_mengajar' => '07.00 - 08.30',
                        'status' => 'selesai',
                        'keterangan' => '-',
                        'id_guru' => 2,
                        'tanggal' => '2026-06-03',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pengumuman')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('pengumuman', 'id_kelas')) $columns[] = 'id_kelas';
                if (Schema::hasColumn('pengumuman', 'jam_mengajar')) $columns[] = 'jam_mengajar';
                if (Schema::hasColumn('pengumuman', 'status')) $columns[] = 'status';
                if (Schema::hasColumn('pengumuman', 'keterangan')) $columns[] = 'keterangan';
                if (Schema::hasColumn('pengumuman', 'id_guru')) $columns[] = 'id_guru';
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
