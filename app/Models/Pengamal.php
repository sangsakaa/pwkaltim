<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengamal extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'pengamal';

    /**
     * Soft delete column
     */
    protected $dates = [
        'deleted_at',
        'tanggal_lahir',
        'created_at',
        'updated_at',
    ];

    /**
     * Mass assignment
     */
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'agama',

        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',

        'rt',
        'rw',
        'alamat',

        'no_hp',
        'email',

        'status_perkawinan',
        'pekerjaan',

        'foto',
    ];

    /**
     * Cast attribute
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('pengamal');
    }

    /**
     * Relasi wilayah
     */
    public function province()
    {
        return $this->belongsTo(
            Province::class,
            'provinsi',
            'code'
        );
    }

    public function regency()
    {
        return $this->belongsTo(
            Regency::class,
            'kabupaten',
            'code'
        );
    }

    public function district()
    {
        return $this->belongsTo(
            District::class,
            'kecamatan',
            'code'
        );
    }

    public function village()
    {
        return $this->belongsTo(
            Village::class,
            'desa',
            'code'
        );
    }

    /**
     * Scope filter berdasarkan role user
     */
    public function scopeByUserRole($query, $user)
    {
        if ($user->hasRole('superAdmin')) {
            return $query;
        }

        if ($user->hasRole('admin-provinsi')) {
            return $query->where(
                'provinsi',
                $user->code
            );
        }

        if ($user->hasRole('admin-kabupaten')) {
            return $query->where(
                'kabupaten',
                $user->code
            );
        }

        if ($user->hasRole('admin-kecamatan')) {
            return $query->where(
                'kecamatan',
                $user->code
            );
        }

        if ($user->hasRole('admin-desa')) {
            return $query->where(
                'desa',
                $user->code
            );
        }

        return $query;
    }

    /**
     * Accessor umur
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }
}
