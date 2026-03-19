<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPurchaseDetail extends Model
{
    use HasFactory;

    protected $guarded  = [];

    protected $hidden = ['product','color'];
    protected $appends = ['product_name','product_images_url','color_name','product_code','product_stock'];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name_ar : null;
    }

    public function getProductCodeAttribute()
    {
        return $this->product ? $this->product->light_bulb_type : null;
    }

    public function getProductStockAttribute()
    {
        return $this->product ? $this->product->stock : null;
    }

     public function color()
    {
        return $this->belongsTo(Color::class,'color_id');
    }

    public function getColorNameAttribute()
    {
        return $this->color ? $this->color->name : null;
    }

    public function getProductImagesUrlAttribute()
    {
        return $this->product ? $this->product->images_urls : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function userPurchase()
    {
        return $this->belongsTo(UserPurchase::class, 'user_purchase_id');
    }
}
