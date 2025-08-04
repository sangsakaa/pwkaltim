<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    protected $table = 'sessions'; // tabel yang digunakan

    public $timestamps = false; // sessions tidak pakai created_at/updated_at

    protected $primaryKey = 'id'; // kolom primary key, biasanya `id` atau `session_id`
    public $incrementing = false; // session_id bukan auto increment

    protected $keyType = 'string'; // jika pakai string (misal UUID)

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    // Relasi ke model User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
