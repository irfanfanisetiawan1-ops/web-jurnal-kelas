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
        // 1. Expand Enum Role di tabel users
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket','waka','satpam','kepala_sekolah','orang_tua') NOT NULL DEFAULT 'guru'");

        // 2. Tambahkan kolom id_siswa pada users untuk role Orang Tua (jika belum ada)
        if (!Schema::hasColumn('users', 'id_siswa')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('id_siswa')->nullable()->after('id_guru');
            });
        }

        // 3. Buat Tabel guru_izin (Alur Izin Tidak Masuk Guru via Link Token)
        if (!Schema::hasTable('guru_izin')) {
            Schema::create('guru_izin', function (Blueprint $table) {
                $table->id('id_guru_izin');
                $table->integer('id_guru');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->text('alasan');
                $table->string('foto_surat')->nullable();
                $table->string('token_approval', 64)->unique();
                $table->enum('status_waka', ['pending', 'approved', 'rejected'])->default('pending');
                $table->enum('status_kepsek', ['pending', 'approved', 'rejected'])->default('pending');
                $table->enum('status_final', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('catatan_waka')->nullable();
                $table->text('catatan_kepsek')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // 4. Buat Tabel siswa_dispen (Dispen Siswa via Link Wali Kelas & Realtime Satpam)
        if (!Schema::hasTable('siswa_dispen')) {
            Schema::create('siswa_dispen', function (Blueprint $table) {
                $table->id('id_siswa_dispen');
                $table->integer('id_siswa');
                $table->integer('id_kelas')->nullable();
                $table->integer('id_jurnal_piket')->nullable();
                $table->string('kode_dispen', 20)->unique();
                $table->string('token_wali_kelas', 64)->unique();
                $table->date('tanggal');
                $table->string('jam_keluar', 20)->nullable();
                $table->string('jam_kembali', 20)->nullable();
                $table->text('alasan');
                $table->enum('status_wali_kelas', ['pending', 'approved', 'rejected'])->default('pending');
                $table->enum('status_satpam', ['belum_keluar', 'dizinkan_keluar', 'sudah_kembali', 'ditolak'])->default('belum_keluar');
                $table->timestamp('waktu_scan_satpam')->nullable();
                $table->text('catatan_satpam')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // 5. Buat Tabel siswa_surat_izin (Input Surat Izin oleh Guru Piket & Auto-Sync Presensi)
        if (!Schema::hasTable('siswa_surat_izin')) {
            Schema::create('siswa_surat_izin', function (Blueprint $table) {
                $table->id('id_surat_izin');
                $table->integer('id_siswa');
                $table->integer('id_kelas');
                $table->date('tanggal');
                $table->enum('kategori', ['Sakit', 'Izin', 'Dispen Luar Sekolah'])->default('Izin');
                $table->text('keterangan')->nullable();
                $table->string('foto_bukti')->nullable();
                $table->integer('id_petugas_piket')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_surat_izin');
        Schema::dropIfExists('siswa_dispen');
        Schema::dropIfExists('guru_izin');

        if (Schema::hasColumn('users', 'id_siswa')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id_siswa');
            });
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket') NOT NULL DEFAULT 'guru'");
    }
};
