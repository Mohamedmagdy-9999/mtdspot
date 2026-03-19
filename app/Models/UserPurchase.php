<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
    use HasFactory;
     protected $guarded  = [];

     protected $appends = ['delivery_date'];
     protected $hidden = ['address'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function details()
    {
        return $this->hasMany(UserPurchaseDetail::class,'user_purchase_id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class,'user_address_id');
    }

    public function getDeliveryDateAttribute()
    {
        // ✅ تأكد من وجود علاقة العنوان والمدينة
        return optional(optional($this->address)->city)->delivery_days;
    }
}
