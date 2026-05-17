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
use App\Models\Log;
class AdminApiController extends Controller
{
   
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

    public function about_us()
    {
        $about = About::first();
        return response()->json(['about' =>$about]);
    }

    public function update_about_us(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable',
            'text' => 'required',
        ]);

        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('about', $name);
        
        }

        $about = About::where('id', $id)->first();
        if (!empty($name)) {
            $about->image = $name;
        }
        $about->text = $request->text;
        $about->save();
         return response()->json([
               'message' => 'About Us Updated successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function sliders()
    {
        $sliders = Slider::latest()->get();
        return response()->json(['sliders' =>$sliders]);
    }

    public function add_slider(Request $request)
    {


        $slider = new Slider();

        // صورة
        if ($file = $request->file('image')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('sliders'), $name);
            $slider->image = $name;
        }

        // باقي البيانات
        $slider->name_ar  = $request->name_ar;
        $slider->name_en  = $request->name_en;
        $slider->desc_ar  = $request->desc_ar;
        $slider->desc_en  = $request->desc_en;
        $slider->price    = $request->price;
        $slider->discount = $request->discount;
        $slider->save();

        // ربط المنتجات
        $slider->products()->sync($request->product_id);

        // Log
        $log = new Log();
        $log->username = auth('api_admins')->user()->name;
        $log->details  = "اضافة شريط صور";
        $log->save();

        return response()->json([
               'message' => 'Slider Store successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function slider_single($id)
    {
        $slider = Slider::findOrFail($id);
         return response()->json(['slider' =>$slider]);
        
    }

     public function update_slider(Request $request,$id)
    {
        
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('sliders', $name);
            
        }
       $slider = Slider::findOrFail($id);
        if(!empty($name))
        {
            $slider->image = $name;
        }
       
       $slider->save();

        $log = new Log();
        $log->username = auth('api_admins')->user()->name;
        $log->details = "تعديل شريط صور" ;
        $log->save();
        return response()->json([
               'message' => 'Slider Updated successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function delete_slider($id)
    {
        
       $slider = Slider::findOrFail($id);
        

        $log = new Log();
        $log->username = auth('api_admins')->user()->name;
        $log->details = "حذف شريط صور" ;
        $log->save();
        $slider->delete();
        return response()->json([
               'message' => 'Slider Deleted successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function users()
    {
        $users = User::latest()->get();
        return response()->json(['users' =>$users]);
    }

    public function suspend_user(Request $request,$id)
    {
        
       
       $user = User::findOrFail($id);
       $user->update([
        'status' =>1,
       ]);
        
       
        return response()->json([
               'message' => 'User Suspend successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function unsuspend_user(Request $request,$id)
    {
        
       
       $user = User::findOrFail($id);
       $user->update([
        'status' =>0,
       ]);
        
       
        return response()->json([
               'message' => 'User Unsuspend successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        return response()->json(['categories' =>$categories]);
    }

    public function add_category(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'image' => 'nullable',
        ]);

       $category = new Category();
       $category->name_ar = $request->name_ar;
       $category->name_en = $request->name_en;
       if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('categories', $name);
            $category->image = $name;
        }
        $category->save();

       
        return response()->json([
               'message' => 'Category Added successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function single_category($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['category' =>$category]);
    }

    public function update_category(Request $request,$id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('categories', $name);
            
        }
       $category =  Category::findOrFail($id);
       $category->name_ar = $request->name_ar;
       $category->name_en = $request->name_en;
       if(!empty($name))
       {
        $category->image = $name;
       }
       $category->save();

        $log = new Log();
        $log->username = auth('api_admins')->user()->name;
        $log->details = "تعديل القسم" . ' '. $category->name_ar;
        $log->save();
        return response()->json([
               'message' => 'Category Updated successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }

    public function delete_category($id)
    {
        $category =  Category::findOrFail($id);
    
        $log = new Log();
        $log->username = auth('api_admins')->user()->name;
        $log->details = "حذف القسم" . ' '. $category->name_ar;
        $log->save();
        $category->delete();
        return response()->json([
               'message' => 'Category Deleted successfully',
                'status' => 200,
                'data' => [],
                
         ], 200);
    }
    


  

}
