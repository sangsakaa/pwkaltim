<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class RegenciesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kode provinsi dari tabel provinces
        $provinces = DB::table('provinces')->pluck('code');

        foreach ($provinces as $provinceCode) {
            $url = "https://wilayah.id/api/regencies/{$provinceCode}.json";
            $response = Http::get($url);

            if ($response->successful()) {
                $regencies = $response->json('data');

                foreach ($regencies as $regency) {
                    DB::table('regencies')->updateOrInsert(
                        ['code' => $regency['code']],
                        [
                            'name' => $regency['name'],
                            'province_code' => $provinceCode,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $this->command->info("Imported regencies for province: $provinceCode");
            } else {
                $this->command->error("Failed to fetch regencies for province: $provinceCode");
            }
        }
    }
}
