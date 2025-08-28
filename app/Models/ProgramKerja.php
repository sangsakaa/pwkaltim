<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $table = 'program_kerjas';

    protected $fillable = [
        'nomor',
        'uraian_kegiatan',
        'waktu_pelaksanaan',
        'sasaran',
        'target',
        'biaya',
        'penanggung_jawab',
    ];

    protected $casts = [
        'biaya' => 'integer',
    ];

    // Aksesori sederhana untuk format biaya (opsional)
    public function getBiayaRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }

    // Scope pencarian sederhana (opsional)
    public function scopeSearch($query, $term)
    {
        $term = "%{$term}%";
        return $query->where(function ($q) use ($term) {
            $q->where('nomor', 'like', $term)
                ->orWhere('uraian_kegiatan', 'like', $term)
                ->orWhere('sasaran', 'like', $term)
                ->orWhere('target', 'like', $term)
                ->orWhere('penanggung_jawab', 'like', $term);
        });
    }
}
