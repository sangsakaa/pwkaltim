<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = [
        'name',
        'short_code',
        'node_code',
        'prov_code',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($departemen) {
            // Buat short_code dari huruf depan tiap kata
            $departemen->short_code = strtoupper(
                collect(explode(' ', $departemen->name))
                    ->map(fn($word) => Str::substr($word, 0, 1))
                    ->implode('')
            );

            // Ambil prov_code dari user login
            $departemen->prov_code = auth()->user()->code ?? '0000';

            // Generate node_code = prov_code + 4 digit random/urut
            $lastId = self::max('id') + 1;
            $departemen->node_code = $departemen->prov_code . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        });
    }
}
