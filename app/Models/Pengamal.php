<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengamal extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'pengamal';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('pengamal');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class,
            'provinsi',
            'code'
        );
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(
            Regency::class,
            'kabupaten',
            'code'
        );
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(
            District::class,
            'kecamatan',
            'code'
        );
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(
            Village::class,
            'desa',
            'code'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DEFAULT RELATIONS
    |--------------------------------------------------------------------------
    */
    public static function relations(): array
    {
        return [
            'province',
            'regency',
            'district',
            'village',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Auto eager load wilayah
     */
    public function scopeWithWilayah(
        Builder $query
    ): Builder {
        return $query->with(
            self::relations()
        );
    }

    /**
     * Filter berdasarkan role user
     */
    public function scopeByUserRole(
        Builder $query,
        $user
    ): Builder {
        return match (true) {

            $user->hasRole('superAdmin')
            => $query,

            $user->hasRole('admin-provinsi')
            => $query->where(
                'provinsi',
                $user->code
            ),

            $user->hasRole('admin-kabupaten')
            => $query->where(
                'kabupaten',
                $user->code
            ),

            $user->hasRole('admin-kecamatan')
            => $query->where(
                'kecamatan',
                $user->code
            ),

            $user->hasRole('admin-desa')
            => $query->where(
                'desa',
                $user->code
            ),

            default => $query,
        };
    }

    /**
     * Search reusable
     */
    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {
        return $query->when(
            filled($search),
            function ($q) use ($search) {

                $q->where(function ($sub) use ($search) {

                    $sub->where(
                        'nama_lengkap',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'nik',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'no_hp',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'alamat',
                            'like',
                            "%{$search}%"
                        );
                });
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Umur otomatis
     */
    protected function umur(): Attribute
    {
        return Attribute::make(
            get: fn() =>
            $this->tanggal_lahir?->age
        );
    }

    /**
     * Nama wilayah lengkap
     */
    protected function wilayah(): Attribute
    {
        return Attribute::make(
            get: fn() =>
            $this->village?->name
                ?? $this->district?->name
                ?? $this->regency?->name
                ?? $this->province?->name
                ?? '-'
        );
    }

    /**
     * URL foto otomatis
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->foto
                ? asset('storage/' . $this->foto)
                : asset('image/default-user.png')
        );
    }
}
