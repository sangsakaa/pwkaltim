<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->foreignId('periode_tahunan_id')
                ->nullable()
                ->after('id')
                ->constrained('periode_tahunans')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropForeign(['periode_tahunan_id']);
            $table->dropColumn('periode_tahunan_id');
        });
    }
};
