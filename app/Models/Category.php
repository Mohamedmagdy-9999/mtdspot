<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
     protected $guarded=[];

    protected $hidden = ['created_at', 'updated_at', 'image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('categories/' . $this->image);
        }
        return null;
    }

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }
}
