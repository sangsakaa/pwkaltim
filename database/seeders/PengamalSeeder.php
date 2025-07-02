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

        // Struktur wilayah berjenjang
        $wilayah = [
            '64' => [ // Kalimantan Timur
                '64.01' => [
                    '64.01.01' => [
                        '64.01.07.2004',
                        '64.01.07.2005',
                        '64.01.07.2006'
                    ],
                    '64.01.02' => [
                        '64.01.02.2001',
                        '64.01.02.2002',
                    ],
                    '64.01.03' => [
                        '64.01.03.3001',
                        '64.01.03.3002',
                    ],
                    '64.01.04' => [
                        '64.01.04.4001',
                        '64.01.04.4002',
                    ],
                    '64.01.05' => [
                        '64.01.05.5001',
                        '64.01.05.5002',
                    ],
                    '64.01.06' => [
                        '64.01.06.6001',
                        '64.01.06.6002',
                    ],
                    '64.01.07' => [
                        '64.01.07.7001',
                        '64.01.07.7002',
                    ],
                    '64.01.08' => [
                        '64.01.08.8001',
                        '64.01.08.8002',
                        '64.01.08.1001'
                    ],
                    '64.01.09' => [
                        '64.01.09.9001',
                        '64.01.09.9002',
                    ],
                    '64.01.10' => [
                        '64.01.10.10001',
                        '64.01.10.10002',
                    ],
                ],
            ],
        ];


        for ($i = 0; $i < 100; $i++) {
            // NIK unik 16 digit
            do {
                $nik = $faker->numerify('################');
            } while (in_array($nik, $usedNiks));
            $usedNiks[] = $nik;

            // Pilih kode wilayah secara berjenjang
            $provinsi = $faker->randomElement(array_keys($wilayah));
            $kabupaten = $faker->randomElement(array_keys($wilayah[$provinsi]));
            $kecamatan = $faker->randomElement(array_keys($wilayah[$provinsi][$kabupaten]));
            $desa = $faker->randomElement($wilayah[$provinsi][$kabupaten][$kecamatan]);

            Pengamal::create([
                'nik' => $nik,
                'nama_lengkap' => $faker->name,
                'tanggal_lahir' => $faker->optional()->date('Y-m-d'),
                'tempat_lahir' => $faker->optional()->city,
                'jenis_kelamin' => $faker->optional()->randomElement(['L', 'P']),
                'agama' => $faker->optional()->randomElement(['Islam']),
                'provinsi' => $provinsi,
                'kabupaten' => $kabupaten,
                'kecamatan' => $kecamatan,
                'desa' => $desa,
                'rt' => $faker->optional()->numerify('0#'),
                'rw' => $faker->optional()->numerify('0#'),
                'no_hp' => $faker->optional()->phoneNumber,
                'alamat' => $faker->optional()->address,
                'email' => $faker->optional()->safeEmail,
                'foto' => null, // Biarkan kosong jika tidak menggunakan file
            ]);
        }
    }
}