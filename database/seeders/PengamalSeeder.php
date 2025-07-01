<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengamal;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PengamalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $usedNiks = [];

        for ($i = 0; $i < 100; $i++) {
            // Pastikan NIK unik
            do {
                $nik = $faker->numerify('################'); // 16 digit
            } while (in_array($nik, $usedNiks));
            $usedNiks[] = $nik;

            Pengamal::create([
                'nik' => $nik,
                'nama_lengkap' => $faker->name,
                'tanggal_lahir' => $faker->optional()->date('Y-m-d'),
                'tempat_lahir' => $faker->optional()->city,
                'jenis_kelamin' => $faker->optional()->randomElement(['L', 'P']),
                'agama' => $faker->optional()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']),
            ]);
        }
    }
}
