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
        if (!Schema::hasColumn('kelas', 'id_ruangan')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->integer('id_ruangan')->nullable()->after('wali_kelas');
            });
        }

        // Room name mapping to populate id_ruangan
        $classRoomMapping = [
            'X TKI 1' => 'Lab. KI 1',
            'X TKI 2' => 'R 10',
            'X RPL 1' => 'R 57',
            'X RPL 2' => 'R 58',
            'X TKJ 1' => 'R 32',
            'X TKJ 2' => 'R 33',
            'X BD 1'  => 'R 23',
            'X BD 2'  => 'R 24',
            'X BD 3'  => 'R 25',
            'X MP 1'  => 'R 11',
            'X MP 2'  => 'R 12',
            'X MP 3'  => 'R 13',
            'X MP 4'  => 'R 14',
            'X AK 1'  => 'R 1',
            'X AK 2'  => 'R 2',
            'X AK 3'  => 'R 3',
            'X AK 4'  => 'R 4',
            'X ULW'   => 'R 22',
            'X DKV 1' => 'R 15',
            'X DKV 2' => 'R 16',
            'X PSPT 1'=> 'R 55',
            'X PSPT 2'=> 'R 56',
            'X AN 1'  => 'R 31',
            'X AN 2'  => 'R 60',
            'XI TKI 1'=> 'R 65',
            'XI TKI 2'=> 'R 66',
            'XI RPL 1'=> 'R 57',
            'XI RPL 2'=> 'R 58',
            'XI TKJ 1'=> 'Lab. TKJ 1',
            'XI TKJ 2'=> 'R 34',
            'XI BD 1' => 'R 26',
            'XI BD 2' => 'R 61',
            'XI BD 3' => 'Lab. BD Depan',
            'XI MP 1' => 'R 6',
            'XI MP 2' => 'R 7',
            'XI MP 3' => 'R 8',
            'XI MP 4' => 'R 9',
            'XI AK 1' => 'R 5',
            'XI AK 2' => 'R 62',
            'XI AK 3' => 'R 63',
            'XI AK 4' => 'R 64',
            'XI ULW'  => 'Lab. UPW 2 (Ticketing)',
            'XI DKV 1'=> 'R 17',
            'XI DKV 2'=> 'R 18',
            'XI PSPT 1'=> 'R 40',
            'XI PSPT 2'=> 'R 41',
            'XI AN 1' => 'R 59',
            'XI AN 2' => 'R 59',
        ];

        foreach ($classRoomMapping as $className => $roomName) {
            $ruangan = DB::table('ruangan')->where('nama_ruangan', $roomName)->first();
            if ($ruangan) {
                DB::table('kelas')
                    ->where('nama_kelas', $className)
                    ->update(['id_ruangan' => $ruangan->id_ruangan]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kelas', 'id_ruangan')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->dropColumn('id_ruangan');
            });
        }
    }
};
