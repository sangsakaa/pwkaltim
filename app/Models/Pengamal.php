<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Pengamal extends Model
{
 protected $table = 'pengamal';


    // Pastikan kolom deleted_at tersedia di database
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'jenis_kelamin',
        'agama',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'rt',
        'rw',
        'no_hp',
        'alamat',
        'foto',
        'email',
        'status_perkawinan',
        'pekerjaan',
        // 'kewarganegaraan',
    ];


    // app/Models/Pengamal.php

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinsi', 'code');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'kabupaten', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'kecamatan', 'code');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'desa', 'code');
    }


    public $timestamps = false;
}
