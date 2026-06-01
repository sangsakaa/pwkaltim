<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_scans', function (Blueprint $table) {
            $table->id();

            // relasi reservasi
            $table->unsignedBigInteger('reservation_id');

            // id panitia (sementara tanpa FK)
            $table->unsignedBigInteger('scanned_by')
                ->nullable();

            $table->timestamp('scan_time');

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            // FK reservation
            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_scans');
    }
};
