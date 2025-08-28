<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'asal_surat',
        'tanggal_surat',
        'tanggal_terima',
        'perihal',
        'keterangan',
        'file_surat',
    ];
}
