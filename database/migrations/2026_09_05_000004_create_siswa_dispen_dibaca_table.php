<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('siswa_dispen_dibaca')) {
            Schema::create('siswa_dispen_dibaca', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('id_siswa_dispen');
                $table->timestamps();

                $table->unique(['user_id', 'id_siswa_dispen']);
                $table->index('user_id');
                $table->index('id_siswa_dispen');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_dispen_dibaca');
    }
};
