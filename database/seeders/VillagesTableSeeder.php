<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VillagesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kode kecamatan dari tabel districts
        $districts = DB::table('districts')->pluck('code');

        foreach ($districts as $districtCode) {
            $url = "https://wilayah.id/api/villages/{$districtCode}.json";
            $response = Http::get($url);

            if ($response->successful()) {
                $villages = $response->json('data');

                foreach ($villages as $village) {
                    DB::table('villages')->updateOrInsert(
                        ['code' => $village['code']],
                        [
                            'name' => $village['name'],
                            'district_code' => $districtCode,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $this->command->info("Imported villages for district: $districtCode");
            } else {
                $this->command->error("Failed to fetch villages for district: $districtCode");
            }
        }
    }
}
