<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at', 'updated_at', 'image','text'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('sliders/' . $this->image);
        }
        return null;
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'slider_products');
    }
}
