<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeTahunan extends Model
{
    protected $fillable = [
        'nama_periode',
        'tahun_mulai',
        'tahun_selesai',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function programKerjas()
    {
        return $this->hasMany(ProgramKerja::class);
    }
    public function periodeTahunan()
    {
        return $this->belongsTo(PeriodeTahunan::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
