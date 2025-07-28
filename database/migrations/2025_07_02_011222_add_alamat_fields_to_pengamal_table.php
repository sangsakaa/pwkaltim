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
            $table->string('rt', 100)->nullable()->after('desa');
            $table->string('rw', 100)->nullable()->after('rt');
            $table->string('alamat', 100)->nullable()->after('rw');
            $table->string('no_hp', 100)->nullable()->after('alamat');
            $table->string('email', 100)->nullable()->after('no_hp');
            $table->string('status_perkawinan', 100)->nullable()->after('email');
            $table->string('foto', 100)->nullable()->after('status_perkawinan');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('pengamal', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'alamat', 'np_hp', 'email', 'status_perkawinan', 'foto']);
        });
    }
};
