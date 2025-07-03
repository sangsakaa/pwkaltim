<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    // app/Models/Province.php
    public function regencies()
    {
        return $this->hasMany(Regency::class, 'province_code', 'code');
    }
    // app/Models/Province.php

    public function users()
    {
        return $this->hasMany(User::class, 'code', 'code');
    }
}
