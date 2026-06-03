<?php

namespace App\Exports;

use App\Models\Pengamal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengamalExport implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection(): Collection
    {
        return Pengamal::query()
            ->with([
                'province',
                'regency',
                'district',
                'village'
            ])
            ->byUserRole($this->user)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_lengkap'       => $item->nama_lengkap,
                    // 'nik'                => $item->nik,
                    'jenis_kelamin'      => $item->jenis_kelamin,
                    // 'tempat_lahir'       => $item->tempat_lahir,
                    // 'tanggal_lahir'      => $item->tanggal_lahir,
                    // 'agama'              => $item->agama,
                    // 'no_hp'              => $item->no_hp,
                    'alamat'             => $item->alamat,

                    // tambahan wilayah
                    'provinsi'           => $item->province?->name,
                    'kabupaten'          => $item->regency?->name,
                    'kecamatan'          => $item->district?->name,
                    'desa'               => $item->village?->name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            // 'NIK',
            'Jenis Kelamin',
            // 'Tempat Lahir',
            // 'Tanggal Lahir',
            // 'Agama',
            // 'No HP',
            'Alamat',

            // wilayah
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'Desa',
        ];
    }
}
