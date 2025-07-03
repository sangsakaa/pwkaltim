<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    // app/Models/District.php
    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_code', 'code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'district_code', 'code');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
