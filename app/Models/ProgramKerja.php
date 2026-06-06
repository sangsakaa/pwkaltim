<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $table = 'program_kerjas';

    protected $fillable = [
        'periode_tahunan_id',
        'nomor',
        'uraian_kegiatan',
        'waktu_pelaksanaan',
        'target',
        'sasaran',
        'biaya',
        'penanggung_jawab',

        'realisasi_kegiatan',
        'realisasi_target',
        'anggaran_realisasi',
        'progress',
        'status_realisasi',
        'tanggal_selesai',
    ];

    protected $casts = [
        'biaya' => 'integer',
        'anggaran_realisasi' => 'integer',
        'progress' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getBiayaRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya ?? 0, 0, ',', '.');
    }

    public function getAnggaranRealisasiRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->anggaran_realisasi ?? 0, 0, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH SCOPE
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nomor', 'like', "%{$keyword}%")
                ->orWhere('uraian_kegiatan', 'like', "%{$keyword}%")
                ->orWhere('sasaran', 'like', "%{$keyword}%")
                ->orWhere('target', 'like', "%{$keyword}%")
                ->orWhere('penanggung_jawab', 'like', "%{$keyword}%");
        });
    }
    public function getTanggalSelesaiFormattedAttribute()
    {
        return $this->tanggal_selesai
            ? $this->tanggal_selesai->format('Y-m-d')
            : null;
    }
    public function periodeTahunan()
    {
        return $this->belongsTo(
            PeriodeTahunan::class,
            'periode_tahunan_id'
        );
    }
}
