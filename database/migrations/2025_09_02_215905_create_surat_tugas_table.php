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
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('nama');
            $table->string('hari');
            $table->date('tanggal_hijriyah')->nullable();
            $table->date('tanggal_masehi');
            $table->string('pukul');
            $table->string('tempat');
            $table->string('alamat');
            $table->string('keperluan');
            $table->text('keterangan')->nullable();
            $table->string('kota');
            $table->date('tanggal_surat_hijriyah')->nullable();
            $table->date('tanggal_surat_masehi');
            $table->string('penandatangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};
