<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $guarded=[];

     protected $appends = ['images_urls', 'category_name', 'supplier_name', 'colors_names','is_favorite','ratings_summary','average_rating','clean_image_link_1','clean_image_link_2','clean_image_link_3','clean_image_link_4'];


    protected $hidden = ['category_id', 'supplier_id', 'images','created_at','updated_at','category','supplier','colors'];

    public function getImagesUrlsAttribute()
    {
        if (!$this->images) {
            return [];
        }

        $images = explode(',', $this->images);

        return array_map(function ($img) {
            return asset('products/' . $img);
        }, $images);
    }

    public function getCleanImageLink1Attribute()
    {
        if (!$this->image_link_1) {
            return "";
        }

        // لو فيه <img src="">
        if (preg_match('/src="([^"]+)"/', $this->image_link_1, $matches)) {
            return $matches[1];
        }

        return $this->image_link_1;
    }
    
    
    public function getCleanImageLink2Attribute()
    {
        if (!$this->image_link_2) {
            return "";
        }

        // لو فيه <img src="">
        if (preg_match('/src="([^"]+)"/', $this->image_link_2, $matches)) {
            return $matches[1];
        }

        return $this->image_link_2;
    }
    
    public function getCleanImageLink3Attribute()
    {
        if (!$this->image_link_3) {
            return "";
        }

        // لو فيه <img src="">
        if (preg_match('/src="([^"]+)"/', $this->image_link_3, $matches)) {
            return $matches[1];
        }

        return $this->image_link_3;
    }
    
    public function getCleanImageLink4Attribute()
    {
        if (!$this->image_link_4) {
            return "";
        }

        // لو فيه <img src="">
        if (preg_match('/src="([^"]+)"/', $this->image_link_4, $matches)) {
            return $matches[1];
        }

        return $this->image_link_4;
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name_ar : null;
    }

    // اسم المورد فقط
    public function getSupplierNameAttribute()
    {
        return $this->supplier ? $this->supplier->name : null;
    }

    // أسماء الألوان فقط
    public function getColorsNamesAttribute()
    {
        return $this->colors->pluck('color')->toArray();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getIsFavoriteAttribute()
    {
        $user = auth('api')->user(); // أو حسب الجارد بتاعك
        if (!$user) {
            return false;
        }
        return $user->favorites()->where('product_id', $this->id)->exists();
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class)->where('comment','!=',null);
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNotNull('comment');
    }

    public function getRatingsSummaryAttribute()
    {
        // مثال: [1 => 2, 2 => 0, 3 => 1, 4 => 5, 5 => 10]
        $summary = [];
        for ($i = 1; $i <= 5; $i++) {
            $summary[$i] = $this->comments()->where('rate', $i)->count();
        }
        return $summary;
    }

    public function getAverageRatingAttribute()
    {
        return round($this->comments()->avg('rate'), 1); // متوسط التقييم
    }
}
