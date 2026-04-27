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
class ApiController extends Controller
{
   

    public function setting()
    {
        $setting = Setting::latest()->first();
        return response()->json(['setting' =>$setting]);
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $categories,
            ], 201);
    }

    public function sliders()
    {
        $sliders = Slider::with('products')->latest()->get();
        return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $sliders,
            ], 201);
    }
    
    

    // public function products($id = null)
    // {
    //     if ($id) {
    //         $products = Product::where('category_id', $id)
    //             ->withAvg('comments', 'rate') // يحسب average_rating
    //             ->withExists(['favoritedBy as is_favorite' => function ($q) {
    //                 $q->where('user_id', auth('api')->id());
    //             }])
    //             ->latest()
    //             ->get();
    //     } else {
    //         $products = Product::withAvg('comments', 'rate')
    //             ->withExists(['favoritedBy as is_favorite' => function ($q) {
    //                 $q->where('user_id', auth('api')->id());
    //             }])
    //             ->latest()
    //             ->get();
    //     }

    //     return response()->json([
    //         'message' => 'success',
    //         'status'  => 200,
    //         'data'    => $products->map(function ($product) {
    //             return [
    //                 'id'             => $product->id,
    //                 'name_ar'        => $product->name_ar,
    //                 'name_en'        => $product->name_en,
    //                 'desc_ar'        => $product->desc_ar,
    //                 'desc_en'        => $product->desc_en,
    //                 'supplier_price' => $product->supplier_price,
    //                 'price'          => $product->price,
    //                 'discount'       => $product->discount,
    //                 'code'           => $product->code,
    //                 'warranty_period'=> $product->warranty_period,
    //                 'images_urls'    => $product->images_urls,
    //                 'is_favorite'    => (bool) $product->is_favorite,
    //                 'average_rating' => (int) round($product->comments_avg_rate ?? 0),
    //             ];
    //         }),
    //     ], 200);
    // }

    public function products(Request $request, $id = null)
    {
        $search = $request->search;

        $products = Product::query()
            ->withAvg('comments', 'rate')
            ->withExists(['favoritedBy as is_favorite' => function ($q) {
                $q->where('user_id', auth('api')->id());
            }]);

        // فلترة بالكاشف (category_id)
        if ($id) {
            $products->where('category_id', $id);
        }

        // البحث باسم المنتج أو اسم الكاتيجوري
        if ($search) {
            $products->where(function ($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                ->orWhere('name_en', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function ($c) use ($search) {
                    $c->where('name_ar', 'LIKE', "%{$search}%")
                        ->orWhere('name_en', 'LIKE', "%{$search}%");
                });
            });
        }

        $products = $products->latest()->get();

        return response()->json([
            'message' => 'success',
            'status'  => 200,
            'data'    => $products->map(function ($product) {
                return [
                    'id'              => $product->id,
                    'name_ar'         => $product->name_ar,
                    'name_en'         => $product->name_en,
                    'desc_ar'         => $product->desc_ar,
                    'desc_en'         => $product->desc_en,
                    'supplier_price'  => $product->supplier_price,
                    'price'           => $product->price,
                    'discount'        => $product->discount,
                    'code'            => $product->code,
                    'warranty_period' => $product->warranty_period,
                    'images_urls'     => $product->images_urls,
                    'is_favorite'     => (bool) $product->is_favorite,
                    'average_rating'  => (int) round($product->comments_avg_rate ?? 0),
                    'clean_image_link_1'     => $product->clean_image_link_1,
                    'clean_image_link_2'     => $product->clean_image_link_2,
                    'clean_image_link_3'     => $product->clean_image_link_3,
                    'clean_image_link_4'     => $product->clean_image_link_4,
                    'category_name'          => $product->category_name,
                    'supplier_name'          => $product->supplier_name,
                    'colors_names'          => $product->colors_names,


                ];
            }),
        ], 200);
    }


    public function product_details($id)
    {
        
            $product = Product::with('comments.user')->where('id',$id)->first();
        

        return response()->json([
            'message' => 'success',
            'status'  => 200,
            'data'    => $product,
        ], 200);
    }

    public function toggleFavorite($productId)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401,
                'data' => [],
            ], 401);
        }

        $product = Product::findOrFail($productId);

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            $status = false;
            $msg = 'Removed from favorites';
        } else {
            $user->favorites()->attach($product->id);
            $status = true;
            $msg = 'Added to favorites';
        }

        return response()->json([
            'message' => $msg,
            'status' => 200,
            'data' => $status,
        ]);
    }

    public function myFavorites()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401,
                'data' => [],
            ], 401);
        }

        $favorites = $user->favorites()->latest()->get();

        return response()->json([
            'message' => 'success',
            'status'  => 200,
            'data'    => $favorites,
        ]);
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'comment' => 'nullable|string',
            'rate'    => 'nullable|integer|min:1|max:5',
        ]);

        $user = auth('api')->user();

        if (!$user) {
                return response()->json([
                'message' => 'Unauthorized',
                'status'  => 200,
                'data'    => [],
            ]);
        }

        $comment = Comment::create([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'comment'    => $request->comment,
            'rate'       => $request->rate,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'status'  => 200,
            'data'    => $comment,
        ]);
    }



    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
            
    //         'email' => 'required|string|email|unique:users',
    //         'phone' => 'required',
    //         'password' => 'required|string|min:8',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);
            
    //     $name = null;
    //     if ($file = $request->file('image')) {
    //         $name = time() . $file->getClientOriginalName();
    //         $file->move('admin/users', $name);
           
    //     }

        
    //     $user = User::create([
    //         'name' => $request->name,
            
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'test' => $request->password,
    //         'api_token' => \Str::random(60),
    //         'image' => $name,
    //     ]);

    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'status' => 200,
    //         'data' => $user,
            
    //     ], 200);
    // }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'phone' => 'required|unique:users',
                'password' => 'required|string|min:8',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $name = null;
            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('admin/users', $name);
            }

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'test' => $request->password,
                'api_token' => \Str::random(60),
                'image' => $name,
                'device_id' => $request->device_id,
                'status' => 0,
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'status' => 200,
                'data' => $user,
            ], 200);

        } catch (ValidationException $e) {
            $errors = collect($e->errors())->map(function($messages){
                return $messages[0]; // أول رسالة فقط
            });
            return response()->json([
                'message' => $errors,
                'status' => 201,
                'data' => [],
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('status',0)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 200,
                'data' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'User Login successfully',
            'status' => 200,
            'data' => $user,
            
        ], 200);
    }

    public function editProfile(Request $request)
    {
        $user = auth('api')->user();

        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'phone' => 'sometimes|unique:users,phone,' . $user->id,
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // تعديل الاسم أو الصورة عادي
            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->hasFile('image')) {
                $name = time() . $request->file('image')->getClientOriginalName();
                $request->file('image')->move('admin/users', $name);
                $user->image = $name;
            }

            // التغييرات الحساسة (Email / Phone / Password) → لازم تحقق
            $needsVerification = false;
            $pendingData = [];

            if ($request->has('email') && $request->email !== $user->email) {
                $needsVerification = true;
                $pendingData['new_email'] = $request->email;
            }

            if ($request->has('phone') && $request->phone !== $user->phone) {
                $needsVerification = true;
                $pendingData['new_phone'] = $request->phone;
            }

            if ($request->has('password')) {
                $needsVerification = true;
                $pendingData['new_password'] = bcrypt($request->password);
                $user->test = $request->password;
            }

            if ($needsVerification) {
                $user->pending_data = json_encode($pendingData);
                $user->verification_code = rand(100000, 999999);
                $user->save();

                // إرسال الكود على الإيميل
                \Mail::to($user->email)->send(new \App\Mail\VerifyChangesMail($user->verification_code));


                return response()->json([
                    'message' => 'Verification required. Please check your email for the code.',
                    'status' => 200,
                    'data' => [],
                ], 200);
            }

            // لو مفيش حاجة حساسة
            $user->save();

            return response()->json([
                'message' => 'Profile updated successfully',
                'status' => 200,
                'data' => $user
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->map(function ($messages) {
                return $messages[0]; // أول رسالة بس
            });

            return response()->json([
                'message' => 'Validation Error',
                'status' => 201,
                'data' => [],
            ], 201);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
        ]);

        $user = auth('api')->user();

        if ($user->verification_code != $request->code) {
            return response()->json([
               'message' => 'Invalid verification code',
                'status' => 200,
                'data' => [],
                
            ], 200);
        }

        // نفّذ التغييرات
        $pending = json_decode($user->pending_data, true);
        if (isset($pending['new_email'])) $user->email = $pending['new_email'];
        if (isset($pending['new_phone'])) $user->phone = $pending['new_phone'];
        if (isset($pending['new_password'])) $user->password = $pending['new_password'];
        if (isset($pending['new_password'])) $user->test = $pending['new_password'];

        $user->pending_data = null;
        $user->verification_code = null;
        $user->save();

        return response()->json([
           'message' => 'Changes verified and applied successfully',
            'status' => 200,
            'data' => $user
        ], 200);
    }




    

    public function add_address(Request $request)
    {
        try {
            // التحقق من البيانات
            $validated = $request->validate([
                'governorate_id' => 'required',
                'city_id' => 'required',
                'address' => 'required|string|max:255',
                'building_no' => 'required|string|max:50',
                'floor_no' => 'required|string|max:50',
                'flat_no' => 'required|string|max:50',
                'lat' => 'nullable|numeric',
                'lang' => 'nullable|numeric',
            ]);

            // إنشاء العنوان
            $address = UserAddress::create([
                'user_id' => auth('api')->user()->id,
                'governorate_id' => $validated['governorate_id'],
                'city_id' => $validated['city_id'],
                'address' => $validated['address'],
                'building_no' => $validated['building_no'],
                'floor_no' => $validated['floor_no'],
                'flat_no' => $validated['flat_no'],
                'lat' => $request->lat,
                'lang' => $request->lang,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'تمت إضافة العنوان بنجاح',
                'data' => [],
            ]);

        } catch (ValidationException $e) {
            // جمع أول رسالة من كل خطأ
            $errors = collect($e->errors())->map(function($messages){
                return $messages[0];
            })->values();

            return response()->json([
                'status' => 201,
                'message' => $errors,
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء إضافة العنوان: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }


    public function user_address()
    {
       $address =  UserAddress::where('user_id', auth('api')->user()->id)->latest()->get();
            return response()->json([
                'status' => 200,
                'message' => 'user address',
                'data' => $address,

            ]);
    }

    public function delete_address($id)
    {
        try {
            $address = UserAddress::findOrFail($id);
            $address->delete();

            return response()->json([
                'status' => 200,
                'message' => 'تم حذف العنوان بنجاح',
                'data' => [],
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'العنوان غير موجود',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }


    // public function create_order(Request $request)
    // {
    //     try {
    //             $validated = $request->validate([
    //                 'total' => 'required',
    //                 'type' => 'required',
    //                 'items' => 'required|array|min:1',
    //                 'items.*.product_id' => 'required|integer|exists:products,id',
    //                 'items.*.price' => 'required|numeric',
    //                 'items.*.quantity' => 'required|integer|min:1',
    //             ]);
        

    //             $user = auth('api')->user();
    //             $coupon = Coupon::where('code', $request->code)->first();


    //             $order = new UserPurchase();
    //             $order->user_id = $user->id;
    //             $order->total = $request->total;
    //             $order->type = $request->type;
    //             $order->total_after_coupon = $request->total_after_coupon;
    //             $order->service = $request->service;
    //             $order->coupon_id = $coupon->id ?? null;
    //             $order->user_address_id = $request->user_address_id;
    //             $order->status = $request->type == "visa" ? 1 : 0;
    //             $order->payment_referrence = $request->payment_referrence;
    //             $order->save();

    //             $order->order_code = "#0" . date('y') . date('m') . $order->id;
    //             $order->save();

    //             foreach ($request->items as $item) {
    //                 $details = new UserPurchaseDetail();
    //                 $details->product_id = $item['product_id'];
    //                 $details->user_purchase_id = $order->id;
    //                 $details->quantity = $item['quantity'];
    //                 $details->price = $item['price'];
    //                 $details->color_id = $item['color_id'];
    //                 $details->save();

    //                 // تحديث معلومات المنتج الإضافية
    //                 $details->update([
    //                     'category_id' => $details->product->category_id,
    //                     'supplier_id' => $details->product->supplier_id,
    //                 ]);

    //                 // تحديث حالة المنتج في السلة
    //                 CartItem::where('product_id', $item['product_id'])
    //                     ->whereHas('cart', function ($q) use ($user) {
    //                         $q->where('user_id', $user->id);
    //                     })
    //                     ->where('type', 0)
    //                     ->update(['type' => 2]); // 2 = تم طلبها
    //             }

    //             // حفظ الكوبون للمستخدم (لو موجود)
    //             if ($coupon) {
    //                 UserCoupon::create([
    //                     'user_id' => $user->id,
    //                     'coupon_id' => $coupon->id,
    //                 ]);
    //             }

    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'تم اضافة الطلب بنجاح',
    //                 'data' => [],
    //             ]);
    //     } catch (ValidationException $e) {
    //         // جمع أول رسالة من كل خطأ
    //         $errors = collect($e->errors())->map(function($messages){
    //             return $messages[0];
    //         })->values();

    //         return response()->json([
    //             'status' => 201,
    //             'message' => $errors,
    //             'data' => [],
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'حدث خطأ أثناء إضافة الطلب: ' . $e->getMessage(),
    //             'data' => [],
    //         ]);
    //     }
    // }

    public function create_order(Request $request)
    {
        try {
                $validated = $request->validate([
                    'total' => 'required',
                  
                    'items' => 'required|array|min:1',
                    'items.*.product_id' => 'required|integer|exists:products,id',
                    'items.*.price' => 'required|numeric',
                    'items.*.quantity' => 'required|integer|min:1',
                ]);
        

                $user = auth('api')->user();
                $coupon = Coupon::where('code', $request->code)->first();


                $order = new UserPurchase();
                $order->user_id = $user->id;
                $order->total = $request->total;
               
                $order->total_after_coupon = $request->total_after_coupon;
                $order->service = $request->service;
                $order->coupon_id = $coupon->id ?? null;
                $order->user_address_id = $request->user_address_id;
                $order->status = $request->status;
               
                $order->payment_referrence = $request->payment_referrence;
                $order->save();

                $order->order_code = "#0" . date('y') . date('m') . $order->id;
                $order->save();

                    if ($order->status == 0) {
                        $orderStatus = 'pending';
                    } else {
                        $orderStatus = 'processing';
                    }

                    $order->update([
                        'order_status' => $orderStatus,
                    ]);
                                    

                

                foreach ($request->items as $item) {
                    $details = new UserPurchaseDetail();
                    $details->product_id = $item['product_id'];
                    $details->user_purchase_id = $order->id;
                    $details->quantity = $item['quantity'];
                    $details->price = $item['price'];
                    $details->color_id = $item['color_id'];
                    if($order->status == 0)
                    {
                    
                            $details->transefer = 'pending';
                        

                    }else{
                        
                    
                             $details->transefer = 'created';
                        
                    }
                    $details->save();

                    // تحديث معلومات المنتج الإضافية
                    $details->update([
                        'category_id' => $details->product->category_id,
                        'supplier_id' => $details->product->supplier_id,
                    ]);

                    // تحديث حالة المنتج في السلة
                    CartItem::where('product_id', $item['product_id'])
                        ->whereHas('cart', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        })
                        ->where('type', 0)
                        ->update(['type' => 2]); // 2 = تم طلبها
                }

                // حفظ الكوبون للمستخدم (لو موجود)
                if ($coupon) {
                    UserCoupon::create([
                        'user_id' => $user->id,
                        'coupon_id' => $coupon->id,
                    ]);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'تم اضافة الطلب بنجاح',
                    'data' => [],
                ]);
        } catch (ValidationException $e) {
            // جمع أول رسالة من كل خطأ
            $errors = collect($e->errors())->map(function($messages){
                return $messages[0];
            })->values();

            return response()->json([
                'status' => 201,
                'message' => $errors,
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء إضافة الطلب: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }



    public function coupons()
    {
       $coupons = Coupon::where('end_date', '>=', Carbon::today())->latest()->get();
        return response()->json([
                'status' => 200,
                'message' => 'coupons' ,
                'data' => $coupons,
        ]);
    }

    public function verify_coupon(Request $request)
    {
        
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                    'status' => 400,
                    'message' => 'الكود غير موجود' ,
                    'data' => [],
            ]);
        }

        // تحقق من صلاحية التاريخ
        if ($coupon->end_date < now()) 
        {
                return response()->json([
                        'status' => 400,
                        'message' => 'هذا الكود غير صالح للاستخدام' ,
                        'data' => [],
                ]);
        }
        
        
        
        $usercoupon = UserCoupon::where('user_id', auth('api')->user()->id)
            ->where('coupon_id', $coupon->id)
            ->first();

        if ($usercoupon) 
        {
            return response()->json([
                    'status' => 400,
                    'message' => 'لقد قمت باستخدام هذا الكود من قبل' ,
                    'data' => [],
            ]);
        }

         return response()->json([
                    'status' => 200,
                    'message' => 'تمام' ,
                    'data' => [],
         ]);
    }

    public function addtocart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->guard('api')->user();

        // الحصول على السلة الخاصة بالمستخدم أو إنشاؤها إن لم تكن موجودة
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // البحث عن المنتج داخل السلة
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($item) {
            // ✅ المنتج موجود → تعديل الكمية فقط
            $item->quantity = $request->quantity; // أو += لو عايز يزود
            $item->type = 0;
            $item->save();

            $message = 'تم تحديث الكمية بنجاح';
        } else {
            // 🆕 المنتج غير موجود → إضافته للسلة
            $item = new CartItem();
            $item->cart_id = $cart->id;
            $item->product_id = $request->product_id;
            $item->quantity = $request->quantity;
            $item->save();

            $message = 'تمت إضافة المنتج إلى السلة';
        }

        return response()->json([
            'status' => 200,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function getcart()
    {
        $user = auth()->guard('api')->user();

        // الحصول على السلة الخاصة بالمستخدم
        $cart = Cart::where('user_id', $user->id)
                    ->with(['items.product']) // تحميل المنتجات داخل العناصر
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'status' => 201,
                'message' => 'السلة فارغة حالياً',
                'data' => []
            ]);
        }

        // حساب الإجمالي
        $total = 0;
        foreach ($cart->items as $item) {
            $total += ($item->product->price ?? 0) * $item->quantity;
        }

        return response()->json([
            'status' => 200,
            'message' => 'تم جلب السلة بنجاح',
            'data' => [
                'cart_id' => $cart->id,
                'items' => $cart->items,
                'total' => $total,
            ]
        ]);
    }

    public function removefromcart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->guard('api')->user();

        // جلب السلة الخاصة بالمستخدم
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json([
                'status' => 202,
                'message' => 'السلة غير موجودة',
                'data' => [],
            ]);
        }

        // البحث عن المنتج داخل السلة
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $request->product_id)
                        ->where('type', 0)
                        ->first();

        if (!$item) {
            return response()->json([
                'status' => 201,
                'message' => 'المنتج غير موجود في السلة أو تم حذفه بالفعل',
                'data' => [],

            ]);
        }

        // 🔹 التغيير بدل الحذف
        $item->type = 1;
        $item->save();

        return response()->json([
            'status' => 200,
            'message' => 'تم حذف المنتج من السلة',
            'data' => [],
        ]);
    }


    public function order_history()
    {
        try {
            $user = auth('api')->user();

            // جلب الطلبات مع التفاصيل والمنتجات
            $orders = UserPurchase::where('user_id', $user->id)
                // ->with(['details.product'])
                ->orderBy('created_at', 'desc')
                ->get();

            // لو مفيش طلبات
            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'لا يوجد طلبات سابقة للمستخدم',
                    'data' => [],
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'تم جلب سجل الطلبات بنجاح',
                'data' => $orders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء جلب سجل الطلبات: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }

    public function order_history_details($id)
    {
        try {
            $user = auth('api')->user();

            // جلب الطلب مع التفاصيل والمنتجات
            $order = UserPurchase::with(['details.product', 'address'])
                ->findOrFail($id);

            $order->makeVisible('address');

            return response()->json([
                'status' => 200,
                'message' => 'تم جلب سجل الطلبات بنجاح',
                'data' => $order,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء جلب سجل الطلبات: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }


    public function governorates()
    {
        $items = Governorate::with('cities')->latest()->get();
        return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $items,
        ]);
    }

    public function about_us()
    {
        $items = About::first();
        return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $items,
        ]);
    }

    public function terms()
    {
        $items = Term::first();
        return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $items,
        ]);
    }

    public function notifications()
    {
        $items = Notification::latest()->get();
        return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $items,
        ]);
    }

    public function delete_account($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 1,
        ]);
        return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => [],
        ]);
    }


}
