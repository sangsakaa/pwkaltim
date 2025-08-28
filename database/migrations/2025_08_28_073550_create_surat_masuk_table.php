<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('asal_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima')->nullable();
            $table->string('perihal');
            $table->text('keterangan')->nullable();
            $table->string('file_surat')->nullable(); // simpan path file pdf/jpg
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
