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
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->text('realisasi_kegiatan')->nullable();
            $table->string('realisasi_target')->nullable();
            $table->bigInteger('anggaran_realisasi')->default(0);
            $table->enum('status_realisasi', ['belum', 'proses', 'selesai'])->default('belum');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('tahun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            //
        });
    }
};
