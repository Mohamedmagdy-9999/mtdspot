<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\Slider;
use App\Models\UserPurchase;
use App\Models\UserPurchaseDetail;
use Str;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use App\Models\UserCoupon;
use App\Models\UserAddress;
use Illuminate\Validation\ValidationException;
use App\Mail\VerifyChangesMail;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Governorate;
use App\Models\About;
use App\Models\Term;
use App\Models\Notification;
use App\Models\Admin;
class AdminApiController extends Controller
{
   

    public function setting()
    {
        $setting = Setting::where('id', 1)->first();
        return response()->json(['setting' =>$setting]);
    }

    public function update_setting(Request $request, $id)
    {
       
            if ($file = $request->file('logo')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('admin/setting', $name);
            
            }
            $setting = Setting::where('id', $id)->first();

            $setting->name = $request->name;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->facebook = $request->facebook;
            $setting->twitter = $request->twitter;
            $setting->instagram = $request->instagram;
            $setting->telegram = $request->telegram;
            $setting->policy = $request->policy;
            $setting->sales_terms = $request->sales_terms;
            $setting->keyword = $request->keyword;
            if (!empty($name)) {
                $setting->logo = $name;
            }
            $setting->save();
            return response()->json([
               'message' => 'Setting Updated successfully',
                'status' => 200,
                'data' => [],
                
            ], 200);
            
        
    }

   public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = Admin::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401,
                'data' => [],
            ], 401);
        }

        $user->api_token = \Str::random(60);
        $user->save();

        return response()->json([
            'message' => 'User Login successfully',
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    
  

}
