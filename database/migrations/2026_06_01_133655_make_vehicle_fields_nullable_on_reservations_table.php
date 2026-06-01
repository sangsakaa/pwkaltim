<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable()->change();
            $table->string('vehicle_name')->nullable()->change();
            $table->string('vehicle_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable(false)->change();
            $table->string('vehicle_name')->nullable(false)->change();
            $table->string('vehicle_number')->nullable(false)->change();
        });
    }
};
