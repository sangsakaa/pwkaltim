<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramKerja;

class ProgramKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor' => '001/PK/2025',
                'uraian_kegiatan' => 'Rapat koordinasi awal tahun',
                'waktu_pelaksanaan' => 'bulanan',
                'sasaran' => 'Pengurus',
                'target' => 'Meningkatkan koordinasi pengurus',
                'biaya' => 500000,
                'penanggung_jawab' => 'Ketua',
            ],
            [
                'nomor' => '002/PK/2025',
                'uraian_kegiatan' => 'Pelatihan kepemimpinan siswa',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa kelas X dan XI',
                'target' => 'Meningkatkan keterampilan kepemimpinan',
                'biaya' => 2000000,
                'penanggung_jawab' => 'Wakil Ketua',
            ],
            [
                'nomor' => '003/PK/2025',
                'uraian_kegiatan' => 'Evaluasi program kerja triwulanan',
                'waktu_pelaksanaan' => 'triwulan',
                'sasaran' => 'Pengurus & anggota',
                'target' => 'Meningkatkan efektivitas kegiatan',
                'biaya' => 750000,
                'penanggung_jawab' => 'Sekretaris',
            ],
            [
                'nomor' => '004/PK/2025',
                'uraian_kegiatan' => 'Kegiatan bakti sosial akhir tahun',
                'waktu_pelaksanaan' => 'tahunan',
                'sasaran' => 'Masyarakat sekitar',
                'target' => 'Meningkatkan kepedulian sosial',
                'biaya' => 3000000,
                'penanggung_jawab' => 'Bendahara',
            ],
            [
                'nomor' => '005/PK/2025',
                'uraian_kegiatan' => 'Workshop kewirausahaan',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa kelas XII',
                'target' => 'Membekali siswa dengan keterampilan usaha',
                'biaya' => 2500000,
                'penanggung_jawab' => 'Koordinator Kegiatan',
            ],
            [
                'nomor' => '006/PK/2025',
                'uraian_kegiatan' => 'Rapat bulanan pengurus',
                'waktu_pelaksanaan' => 'bulanan',
                'sasaran' => 'Pengurus',
                'target' => 'Meningkatkan komunikasi antar pengurus',
                'biaya' => 400000,
                'penanggung_jawab' => 'Ketua',
            ],
            [
                'nomor' => '007/PK/2025',
                'uraian_kegiatan' => 'Pelatihan IT dasar',
                'waktu_pelaksanaan' => 'triwulan',
                'sasaran' => 'Siswa kelas X',
                'target' => 'Menguasai keterampilan komputer dasar',
                'biaya' => 1500000,
                'penanggung_jawab' => 'Bidang IT',
            ],
            [
                'nomor' => '008/PK/2025',
                'uraian_kegiatan' => 'Kunjungan industri',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa kelas XI',
                'target' => 'Menambah wawasan dunia kerja',
                'biaya' => 5000000,
                'penanggung_jawab' => 'Wakil Ketua',
            ],
            [
                'nomor' => '009/PK/2025',
                'uraian_kegiatan' => 'Pengajian rutin',
                'waktu_pelaksanaan' => 'bulanan',
                'sasaran' => 'Siswa & guru',
                'target' => 'Meningkatkan iman dan taqwa',
                'biaya' => 600000,
                'penanggung_jawab' => 'Bidang Keagamaan',
            ],
            [
                'nomor' => '010/PK/2025',
                'uraian_kegiatan' => 'Lomba olahraga antar kelas',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa kelas X-XII',
                'target' => 'Meningkatkan sportivitas dan kebugaran',
                'biaya' => 3500000,
                'penanggung_jawab' => 'Bidang Olahraga',
            ],
            [
                'nomor' => '011/PK/2025',
                'uraian_kegiatan' => 'Pameran karya seni siswa',
                'waktu_pelaksanaan' => 'tahunan',
                'sasaran' => 'Siswa & masyarakat',
                'target' => 'Mengapresiasi karya seni siswa',
                'biaya' => 4000000,
                'penanggung_jawab' => 'Bidang Seni',
            ],
            [
                'nomor' => '012/PK/2025',
                'uraian_kegiatan' => 'Bimbingan karir',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa kelas XII',
                'target' => 'Mempersiapkan siswa menghadapi dunia kerja',
                'biaya' => 2000000,
                'penanggung_jawab' => 'BK',
            ],
            [
                'nomor' => '013/PK/2025',
                'uraian_kegiatan' => 'Rapat evaluasi tengah tahun',
                'waktu_pelaksanaan' => 'triwulan',
                'sasaran' => 'Pengurus',
                'target' => 'Evaluasi kegiatan semester pertama',
                'biaya' => 700000,
                'penanggung_jawab' => 'Sekretaris',
            ],
            [
                'nomor' => '014/PK/2025',
                'uraian_kegiatan' => 'Donor darah',
                'waktu_pelaksanaan' => 'tahunan',
                'sasaran' => 'Siswa & masyarakat',
                'target' => 'Meningkatkan kepedulian sosial',
                'biaya' => 2500000,
                'penanggung_jawab' => 'Bidang Kesehatan',
            ],
            [
                'nomor' => '015/PK/2025',
                'uraian_kegiatan' => 'Pelatihan jurnalistik',
                'waktu_pelaksanaan' => 'triwulan',
                'sasaran' => 'Siswa kelas XI',
                'target' => 'Meningkatkan keterampilan menulis berita',
                'biaya' => 1200000,
                'penanggung_jawab' => 'Bidang Humas',
            ],
            [
                'nomor' => '016/PK/2025',
                'uraian_kegiatan' => 'Pentas seni akhir semester',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Siswa & orang tua',
                'target' => 'Menunjukkan kreativitas siswa',
                'biaya' => 3000000,
                'penanggung_jawab' => 'Bidang Seni',
            ],
            [
                'nomor' => '017/PK/2025',
                'uraian_kegiatan' => 'Perkemahan Sabtu Minggu',
                'waktu_pelaksanaan' => 'semester',
                'sasaran' => 'Pramuka',
                'target' => 'Meningkatkan kemandirian',
                'biaya' => 2800000,
                'penanggung_jawab' => 'Pembina Pramuka',
            ],
            [
                'nomor' => '018/PK/2025',
                'uraian_kegiatan' => 'Pelatihan multimedia',
                'waktu_pelaksanaan' => 'triwulan',
                'sasaran' => 'Siswa kelas XI',
                'target' => 'Menguasai desain grafis & video editing',
                'biaya' => 3500000,
                'penanggung_jawab' => 'Bidang IT',
            ],
            [
                'nomor' => '019/PK/2025',
                'uraian_kegiatan' => 'Family gathering',
                'waktu_pelaksanaan' => 'tahunan',
                'sasaran' => 'Guru & siswa',
                'target' => 'Meningkatkan keakraban dan kekompakan',
                'biaya' => 6000000,
                'penanggung_jawab' => 'Ketua',
            ],
            [
                'nomor' => '020/PK/2025',
                'uraian_kegiatan' => 'Rapat penutupan akhir tahun',
                'waktu_pelaksanaan' => 'tahunan',
                'sasaran' => 'Pengurus',
                'target' => 'Menutup kegiatan dan evaluasi akhir',
                'biaya' => 1000000,
                'penanggung_jawab' => 'Sekretaris',
            ],
        ];

        foreach ($data as $item) {
            ProgramKerja::create($item);
        }
    }
}
