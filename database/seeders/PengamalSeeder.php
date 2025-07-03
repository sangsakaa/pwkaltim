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
                '64.01' => [ // Kab. Paser
                    '64.01.01' => ['64.01.07.2004', '64.01.07.2005', '64.01.07.2006'],
                    '64.01.02' => ['64.01.02.2001', '64.01.02.2002'],
                    '64.01.03' => ['64.01.03.3001', '64.01.03.3002'],
                    '64.01.04' => ['64.01.04.4001', '64.01.04.4002'],
                    '64.01.05' => ['64.01.05.5001', '64.01.05.5002'],
                    '64.01.06' => ['64.01.06.6001', '64.01.06.6002'],
                    '64.01.07' => ['64.01.07.7001', '64.01.07.7002'],
                    '64.01.08' => ['64.01.08.8001', '64.01.08.8002', '64.01.08.1001'],
                    '64.01.09' => ['64.01.09.9001', '64.01.09.9002'],
                    '64.01.10' => ['64.01.10.10001', '64.01.10.10002'],
                ],
            ],
        ];

        for ($i = 0; $i < 100; $i++) {
            // NIK unik 16 digit
            do {
                $nik = $faker->numerify('################');
            } while (in_array($nik, $usedNiks));
            $usedNiks[] = $nik;

            // Pilih wilayah berjenjang
            $provinsiId = array_rand($wilayah);
            $kabupatenList = $wilayah[$provinsiId];

            $kabupatenId = array_rand($kabupatenList);
            $kecamatanList = $kabupatenList[$kabupatenId];

            $kecamatanId = array_rand($kecamatanList);
            $desaList = $kecamatanList[$kecamatanId];

            $desaId = $faker->randomElement($desaList);

            // Simpan ke database
            Pengamal::create([
                'nik' => $nik,
                'nama_lengkap' => $faker->name,
                'tanggal_lahir' => $faker->date('Y-m-d'),
                'tempat_lahir' => $faker->city,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'agama' => 'Islam',
                'provinsi' => $provinsiId,
                'kabupaten' => $kabupatenId,
                'kecamatan' => $kecamatanId,
                'desa' => $desaId,
                'rt' => $faker->numerify('0#'),
                'rw' => $faker->numerify('0#'),
                'no_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'email' => $faker->unique()->safeEmail,
                'foto' => null,
            ]);
        }
    }
}