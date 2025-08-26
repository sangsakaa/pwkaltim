<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'lampiran',
        'perihal',
        'kepada',
        'tempat',
        'tanggal_hijriah',
        'tanggal_masehi',
        'isi_surat',
        'penandatangan',
    ];
}
