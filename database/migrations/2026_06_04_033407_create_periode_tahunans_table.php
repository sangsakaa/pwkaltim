<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_tahunans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_periode');
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');

            $table->boolean('is_active')->default(false);

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_tahunans');
    }
};
