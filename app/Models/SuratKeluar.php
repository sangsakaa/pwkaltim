<?php

namespace App\Models;

use App\Models\SuratFile;
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
    public function files()
    {
        return $this->hasMany(SuratFile::class, 'surat_keluar_id');
    }
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%")
                    ->orWhere('kepada', 'like', "%{$keyword}%")
                    ->orWhere('penandatangan', 'like', "%{$keyword}%")
                    ->orWhere('tempat', 'like', "%{$keyword}%");
            });
        }

        return $query;
    }
}
