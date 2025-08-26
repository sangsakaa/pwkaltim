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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('lampiran')->nullable();
            $table->string('perihal');
            $table->string('kepada');
            $table->string('tempat');
            $table->date('tanggal_hijriah')->nullable();
            $table->date('tanggal_masehi')->nullable();
            $table->text('isi_surat');
            $table->string('penandatangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
