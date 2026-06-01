<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'reservations',
            function (Blueprint $table) {

                $table->enum('status', [
                    'pending',
                    'checked_in',
                    'no_show'
                ])
                    ->default('pending')
                    ->change();

                $table->timestamp(
                    'marked_no_show_at'
                )->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'reservations',
            function (Blueprint $table) {

                $table->enum('status', [
                    'pending',
                    'checked_in'
                ])
                    ->default('pending')
                    ->change();

                $table->dropColumn(
                    'marked_no_show_at'
                );
            }
        );
    }
};
