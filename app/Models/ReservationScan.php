<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationScan extends Model
{
    protected $fillable = [
        'reservation_id',
        'scanned_by',
        'scan_time',
        'notes',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(
            Reservation::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'scanned_by'
        );
    }
}
