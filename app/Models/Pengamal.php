<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengamal extends Model
{
 protected $table = 'pengamal';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'jenis_kelamin',
        'agama',
        // 'status_perkawinan',
        // 'pekerjaan',
        // 'kewarganegaraan',
    ];

    public $timestamps = false;
}
