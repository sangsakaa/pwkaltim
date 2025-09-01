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
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('nomor_surat', 'like', "%{$term}%")
                    ->orWhere('asal_surat', 'like', "%{$term}%")
                    ->orWhere('perihal', 'like', "%{$term}%")
                    ->orWhere('keterangan', 'like', "%{$term}%");
            });
        }
        return $query;
    }
}
