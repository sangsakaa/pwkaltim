<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {

            // hapus unique index lama
            $table->dropUnique('program_kerjas_nomor_unique');
        });

        Schema::table('program_kerjas', function (Blueprint $table) {

            // ubah tipe data
            $table->integer('nomor')->change();
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {

            $table->string('nomor')->change();
            $table->unique('nomor');
        });
    }
};
