<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['governorate_name','city_name'];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function getGovernorateNameAttribute()
    {
        return $this->governorate ? $this->governorate->name_ar : null;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getCityNameAttribute()
    {
        return $this->city ? $this->city->name_ar : null;
    }
}
