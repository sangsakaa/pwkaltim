<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->string('reservation_number')->unique();
            $table->string('reservation_code')->unique();

            $table->enum('type', [
                'personal',
                'group'
            ]);

            // TANPA FK dulu
            $table->string('regency_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('village_id')->nullable();

            $table->text('address')->nullable();

            $table->enum('vehicle_type', [
                'pribadi',
                'sewa'
            ]);

            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_number')->nullable();

            $table->integer('total_father')->default(0);
            $table->integer('total_mother')->default(0);
            $table->integer('total_teenager')->default(0);
            $table->integer('total_child')->default(0);
            $table->integer('total_participant')->default(0);

            $table->enum('status', [
                'pending',
                'checked_in'
            ])->default('pending');

            $table->timestamp('checked_in_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
