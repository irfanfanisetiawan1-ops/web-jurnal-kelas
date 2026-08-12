<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('jurusan')) {
            Schema::create('jurusan', function (Blueprint $table) {
                $table->integer('id_jurusan')->autoIncrement();
                $table->string('kode_jurusan', 20)->unique();
                $table->string('nama_jurusan', 100);
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
