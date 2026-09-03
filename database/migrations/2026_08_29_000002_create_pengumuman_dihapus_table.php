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
        if (!Schema::hasTable('pengumuman_dihapus')) {
            Schema::create('pengumuman_dihapus', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_pengumuman');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('id_pengumuman')->references('id_pengumuman')->on('pengumuman')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unique(['id_pengumuman', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman_dihapus');
    }
};
