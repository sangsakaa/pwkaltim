<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratFile extends Model
{
    use HasFactory;
    protected $table = 'surat_files';

    protected $fillable = [
        'surat_keluar_id',
        'nama_file',
        'path_file',
        'tipe_file',
    ];

    /**
     * Relasi ke surat keluar
     */
    public function surat()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }
}
