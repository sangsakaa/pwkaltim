<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $fillable = [
        'nomor',
        'nama',
        'hari',
        'tanggal_hijriyah',
        'tanggal_masehi',
        'pukul',
        'tempat',
        'alamat',
        'keperluan',
        'keterangan',
        'kota',
        'tanggal_surat_hijriyah',
        'tanggal_surat_masehi',
        'penandatangan',
    ];
}
