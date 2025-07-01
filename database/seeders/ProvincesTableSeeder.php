<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dari API
        $response = Http::get('https://wilayah.id/api/provinces.json');

        if ($response->successful()) {
            $provinces = $response->json('data');

            foreach ($provinces as $province) {
                DB::table('provinces')->updateOrInsert(
                    ['code' => $province['code']],
                    [
                        'name' => $province['name'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } else {
            $this->command->error('Gagal mengambil data dari API.');
        }
    }
}
