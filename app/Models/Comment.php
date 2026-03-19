<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";
    protected $guarded = [];

    // نضيفهم دايمًا كـ attributes
    protected $appends = ['user_name', 'user_image'];
    protected $hidden = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // اسم اليوزر
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    // صورة اليوزر
    public function getUserImageAttribute()
    {
        return $this->user ? $this->user->image_url : null;
    }
}
