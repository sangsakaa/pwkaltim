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
            '64' => [ // Provinsi Kalimantan Timur
                '64.01' => [ // Kabupaten Paser
                    '64.01.01' => [ // Kecamatan atau wilayah lebih kecil
                        '64.01.07.2004',
                        '64.01.07.2005',
                        '64.01.07.2006',
                    ],
                ],
                '64.72' => [ // Kabupaten Paser
                    '64.72.01' => [ // Kecamatan atau wilayah lebih kecil
                        '64.72.07.2004',
                        '64.72.07.2005',
                        '64.72.07.2006',
                    ],
                ],
                '64.74' => [ // Kabupaten Paser
                    '64.74.01' => [ // Kecamatan atau wilayah lebih kecil
                        '64.74.07.2004',
                        '64.74.07.2005',
                        '64.74.07.2006',
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