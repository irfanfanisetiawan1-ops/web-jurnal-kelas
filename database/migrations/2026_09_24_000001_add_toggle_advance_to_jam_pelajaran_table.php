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
        if (Schema::hasTable('jam_pelajaran')) {
            Schema::table('jam_pelajaran', function (Blueprint $table) {
                if (!Schema::hasColumn('jam_pelajaran', 'jam_mulai_default')) {
                    $table->time('jam_mulai_default')->nullable()->after('jam_selesai');
                }
                if (!Schema::hasColumn('jam_pelajaran', 'jam_selesai_default')) {
                    $table->time('jam_selesai_default')->nullable()->after('jam_mulai_default');
                }
                if (!Schema::hasColumn('jam_pelajaran', 'is_active_senin_kamis')) {
                    $table->boolean('is_active_senin_kamis')->default(true)->after('jam_selesai_default');
                }
                if (!Schema::hasColumn('jam_pelajaran', 'jam_mulai_jumat_default')) {
                    $table->time('jam_mulai_jumat_default')->nullable()->after('jam_selesai_jumat');
                }
                if (!Schema::hasColumn('jam_pelajaran', 'jam_selesai_jumat_default')) {
                    $table->time('jam_selesai_jumat_default')->nullable()->after('jam_mulai_jumat_default');
                }
                if (!Schema::hasColumn('jam_pelajaran', 'is_active_jumat')) {
                    $table->boolean('is_active_jumat')->default(true)->after('jam_selesai_jumat_default');
                }
            });

            // Inisialisasi data default dari jam_mulai & jam_selesai yang ada
            DB::statement("UPDATE jam_pelajaran SET 
                jam_mulai_default = jam_mulai,
                jam_selesai_default = jam_selesai,
                is_active_senin_kamis = CASE WHEN jam_mulai IS NOT NULL THEN 1 ELSE 0 END,
                jam_mulai_jumat_default = jam_mulai_jumat,
                jam_selesai_jumat_default = jam_selesai_jumat,
                is_active_jumat = CASE WHEN jam_mulai_jumat IS NOT NULL THEN 1 ELSE 0 END
                WHERE jam_mulai_default IS NULL OR jam_mulai_jumat_default IS NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('jam_pelajaran')) {
            Schema::table('jam_pelajaran', function (Blueprint $table) {
                $columns = [
                    'is_active_senin_kamis',
                    'jam_mulai_default',
                    'jam_selesai_default',
                    'is_active_jumat',
                    'jam_mulai_jumat_default',
                    'jam_selesai_jumat_default',
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('jam_pelajaran', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
