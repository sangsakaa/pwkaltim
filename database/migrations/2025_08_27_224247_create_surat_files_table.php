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
        Schema::create('surat_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keluar_id')
                ->constrained('surat_keluar')
                ->onDelete('cascade'); // kalau surat dihapus, file ikut terhapus
            $table->string('nama_file')->nullable(); // opsional: nama custom untuk file
            $table->string('path_file');             // lokasi file di storage
            $table->string('tipe_file')->nullable(); // contoh: pdf, jpg, png
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_files');
    }
};
