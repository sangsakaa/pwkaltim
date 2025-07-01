<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DistrictsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kode regency dari tabel regencies
        $regencies = DB::table('regencies')->pluck('code');

        foreach ($regencies as $regencyCode) {
            $url = "https://wilayah.id/api/districts/{$regencyCode}.json";
            $response = Http::get($url);

            if ($response->successful()) {
                $districts = $response->json('data');

                foreach ($districts as $district) {
                    DB::table('districts')->updateOrInsert(
                        ['code' => $district['code']],
                        [
                            'name' => $district['name'],
                            'regency_code' => $regencyCode,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $this->command->info("Imported districts for regency: $regencyCode");
            } else {
                $this->command->error("Failed to fetch districts for regency: $regencyCode");
            }
        }
    }
}
