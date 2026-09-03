<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('siswa_surat_izin')) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('siswa_surat_izin', 'tanggal_selesai')) {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN tanggal_selesai DATE NULL AFTER tanggal");
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('siswa_surat_izin', 'durasi_hari')) {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN durasi_hari INT NOT NULL DEFAULT 1 AFTER tanggal_selesai");
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('siswa_surat_izin', 'status')) {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN status ENUM('Menunggu','Terverifikasi','Ditolak') NOT NULL DEFAULT 'Terverifikasi' AFTER id_petugas_piket");
                }
            }
        } catch (\Throwable $e) {
            // Log or ignore schema auto-sync if DB not ready
        }
    }
}
