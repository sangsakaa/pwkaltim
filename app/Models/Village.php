<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    //
    // app/Models/Village.php
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
