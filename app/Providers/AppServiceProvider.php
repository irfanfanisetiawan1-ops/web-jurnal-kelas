<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\TahunAjaran;

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
            if (Schema::hasTable('siswa_surat_izin')) {
                if (!Schema::hasColumn('siswa_surat_izin', 'tanggal_selesai')) {
                    DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN tanggal_selesai DATE NULL AFTER tanggal");
                }
                if (!Schema::hasColumn('siswa_surat_izin', 'durasi_hari')) {
                    DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN durasi_hari INT NOT NULL DEFAULT 1 AFTER tanggal_selesai");
                }
                if (!Schema::hasColumn('siswa_surat_izin', 'status')) {
                    DB::statement("ALTER TABLE siswa_surat_izin ADD COLUMN status ENUM('Menunggu','Terverifikasi','Ditolak') NOT NULL DEFAULT 'Terverifikasi' AFTER id_petugas_piket");
                }
            }
        } catch (\Throwable $e) {
            // Log or ignore schema auto-sync if DB not ready
        }

        try {
            View::composer('*', function ($view) {
                static $activeTahunAjaran = null;
                if ($activeTahunAjaran === null) {
                    try {
                        if (Schema::hasTable('tahun_ajaran')) {
                            $activeTahunAjaran = TahunAjaran::getActive();
                        }
                    } catch (\Throwable $e) {
                        $activeTahunAjaran = null;
                    }
                }
                $view->with('activeTahunAjaran', $activeTahunAjaran);
            });

            View::composer(['layouts.waka', 'waka.*'], function ($view) {
                try {
                    if (Schema::hasTable('siswa_dispen')) {
                        $pendingCount = \App\Models\SiswaDispen::where(function($q) {
                            $q->where('status_waka', 'pending')->orWhereNull('status_waka');
                        })->count();
                        $view->with('wakaPendingDispenCount', $pendingCount);
                    }
                } catch (\Throwable $e) {
                    $view->with('wakaPendingDispenCount', 0);
                }
            });

            View::composer(['layouts.waka_sdm', 'waka_sdm.*'], function ($view) {
                try {
                    if (Schema::hasTable('guru_izin')) {
                        $pendingCount = \App\Models\GuruIzin::where(function($q) {
                            $q->where('status_waka_sdm', 'pending')->orWhereNull('status_waka_sdm');
                        })->count();
                        $view->with('wakaSdmPendingIzinCount', $pendingCount);
                    }
                } catch (\Throwable $e) {
                    $view->with('wakaSdmPendingIzinCount', 0);
                }
            });

            View::composer(['layouts.waka_kurikulum', 'waka_kurikulum.*'], function ($view) {
                try {
                    if (Schema::hasTable('guru_izin')) {
                        $pendingCount = \App\Models\GuruIzin::where(function($q) {
                            $q->where('status_waka', 'pending')->orWhereNull('status_waka');
                        })->count();
                        $view->with('wakaKurikulumPendingIzinCount', $pendingCount);
                    }
                } catch (\Throwable $e) {
                    $view->with('wakaKurikulumPendingIzinCount', 0);
                }
            });
        } catch (\Throwable $e) {
            // Ignore
        }
    }
}
