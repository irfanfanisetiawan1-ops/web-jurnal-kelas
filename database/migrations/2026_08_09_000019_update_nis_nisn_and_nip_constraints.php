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
        // 1. Format existing NIS & NISN data to 10 digits
        $siswas = DB::table('siswa')->get();
        foreach ($siswas as $index => $s) {
            $paddedNisn = str_pad(preg_replace('/[^0-9]/', '', $s->nisn), 10, '0', STR_PAD_LEFT);
            if (strlen($paddedNisn) > 10) {
                $paddedNisn = substr($paddedNisn, 0, 10);
            }
            
            $rawNis = $s->nis ? preg_replace('/[^0-9]/', '', $s->nis) : '';
            if (empty($rawNis)) {
                $rawNis = (2122100001 + $index);
            }
            $paddedNis = str_pad($rawNis, 10, '0', STR_PAD_LEFT);
            if (strlen($paddedNis) > 10) {
                $paddedNis = substr($paddedNis, 0, 10);
            }

            DB::table('siswa')->where('id_siswa', $s->id_siswa)->update([
                'nis'  => $paddedNis,
                'nisn' => $paddedNisn,
            ]);
        }

        // 2. Modify columns to varchar(10)
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nis', 10)->change();
            $table->string('nisn', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nis', 20)->nullable()->change();
            $table->string('nisn', 20)->change();
        });
    }
};
