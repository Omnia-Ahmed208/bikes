<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsPrice extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
