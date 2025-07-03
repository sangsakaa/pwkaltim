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
        Schema::table('pengamal', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('status_perkawinan'); // sesuaikan 'nama' dengan kolom terakhir sebelumnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengamal', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan']);
        });
    }
};
