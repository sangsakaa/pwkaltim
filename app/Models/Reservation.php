<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $fillable = [
        'ketua_rombongan',
        'reservation_number',
        'reservation_code',
        'type',
        'regency_id',
        'district_id',
        'village_id',
        'address',
        'vehicle_type',
        'vehicle_name',
        'vehicle_number',
        'total_father',
        'total_mother',
        'total_teenager',
        'total_child',
        'total_participant',
        'status',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function scans(): HasMany
    {
        return $this->hasMany(ReservationScan::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}
