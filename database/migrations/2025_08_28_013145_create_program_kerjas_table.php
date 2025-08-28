<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->text('uraian_kegiatan');
            $table->enum('waktu_pelaksanaan', ['bulanan', 'triwulan', 'semester', 'tahunan']);
            $table->string('sasaran');
            $table->string('target');
            $table->unsignedBigInteger('biaya')->default(0);
            $table->string('penanggung_jawab');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerjas');
    }
};
