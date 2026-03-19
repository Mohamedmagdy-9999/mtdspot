<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\CheckPoint;
use App\Models\About;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Str;
use MTGofa\Paytabs\Facades\Paytabs;
use Illuminate\Support\Facades\DB;
use App\Imports\SupplierImport;
use App\Imports\ProductImport;
use App\Models\UserAddress;
use App\Models\UserPurchase;
use App\Models\UserPurchaseDetail;
use App\Models\City;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Stevebauman\Location\Facades\Location;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::all();
        $cats = Category::latest()->get();
        
        return view('website.index', compact('sliders','cats'));
    }

    public function single_category($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return view('website.products', compact('category'));
        }
    public function single_product($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // المنتجات المشابهة
        $similarProducts = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->inRandomOrder()   // اختيار عشوائي
                          ->take(4)           // عدد المنتجات اللي عايزها
                          ->get();

        return view('website.product_details', compact('product', 'similarProducts'));
    }


    public function about()
    {
        $about = About::first();
        return view('website.about', compact('about'));
    }

 


    public function create_account(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:8|confirmed',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'terms' => 'required',
            ],
            [
                'name.required' => 'Full name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'phone.required' => 'Phone number is required',
                'phone.unique' => 'Phone already exists',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
                'password.confirmed' => 'Passwords do not match',
                'terms.required' => 'You must agree to the terms',
            ]
        );

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('admin/users'), $imageName);
        }

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'test' => $request->password,
            'api_token' => \Str::random(60),
            'image' => $imageName,
           // 'device_id' => $request->device_id,
            'status' => 0,
        ]);

        return redirect()->route('login')->with('message', 'Account created successfully');
    }


    public function postLogin(Request $request)
    {
        $previous_url = $request->session()->pull('previous_url');

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) 
        {
            $user = auth()->user();
            if($user->status == 0)
            {
                return redirect()->intended($previous_url);
            }else{
                Auth::logout();
                return back()->with('message','Your Account Has Been Disabled.');
            }
            
                        
        }
  
        return back()->with('message','Oppes! You have entered invalid credentials');
    }



    public function user_logout(Request $request) 
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function contact_us()
    {
        $setting = Setting::first();
        return view('website.contact', compact('setting'));
    }

    public function profile()
    {
         $user = auth()->user();

        $addresses = UserAddress::where('user_id', $user->id)->latest()->get();
         $orders = UserPurchase::where('user_id', $user->id)->orderBy('created_at', 'desc')
                ->get();
              
                

        return view('website.profile', compact('user', 'addresses', 'orders'));
    }

     public function update_profile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->test = $request->password;
        }

        if ($request->hasFile('image')) {
            $img = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('admin/users'), $img);
            $user->image = $img;
        }

        $user->save();

        return back()->with('message', 'Profile updated successfully');
    }

    public function getCities($gov_id)
    {
        $cities = City::where('governorate_id', $gov_id)->get();
        return response()->json($cities);
    }

    public function addAddress(Request $request)
    {
        $validated = $request->validate([
            'governorate_id' => 'required',
            'city_id'        => 'required',
            'address'        => 'required|string|max:255',
            'building_no'    => 'required|string|max:50',
            'floor_no'       => 'required|string|max:50',
            'flat_no'        => 'required|string|max:50',
            'phone'          => 'nullable|string|max:20',
        ]);

        UserAddress::create([
            'user_id'        => auth()->id(),
            'governorate_id' => $validated['governorate_id'],
            'city_id'        => $validated['city_id'],
            'address'        => $validated['address'],
            'building_no'    => $validated['building_no'],
            'floor_no'       => $validated['floor_no'],
            'flat_no'        => $validated['flat_no'],
            'phone'          => $request->phone,
        ]);

        return back()->with('message', 'Address added successfully');
    }


    public function deleteAddress($id)
    {
        UserAddress::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('message', 'Address deleted');
    }
  

    


    public function log(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3|max:255',
            // 'captcha' => 'required|captcha',
        ]);
        $data = $request->only(['email', 'password']);

        
        if ($token = auth()->guard('admin')->attempt($data)) {

            return redirect()->route('admin.dashboard');
        }

        if ($token = auth()->guard('supplier')->attempt($data)) {

            return redirect()->route('supplier.dashboard');
        }

        return back()->with('error_message', 'Invalid password');
    }

    public function logout_admin()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('signin');

    }

    public function logout_supplier()
    {
        Auth::guard('supplier')->logout();

        return redirect()->route('signin');

    }



    public function payment(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $coupon = UserCoupon::where('user_id', auth()->user()->id)->where('status', 1)->where('type', 0)->first();
        $total = CartItem::where('cart_id', $cart->id)->where('type', 0)->sum('price');
        if($coupon)
        {
            $result = Paytabs::pay($total - $coupon->price, $user->id, $user->name .' ' . $user->last_name, $user->email, $user->phone, [
                'customer_details' => [
                    'country' => 'EG',
                    'state' => 'C'
                ]
            ]);
        }else{
            $result = Paytabs::pay($total, $user->id, $user->name .' ' . $user->last_name, $user->email, $user->phone, [
                'customer_details' => [
                    'country' => 'EG',
                    'state' => 'C'
                ]
            ]);
        }
        

         DB::beginTransaction();

            try {
                
                $order = new Order();
                $order->tran_ref = $result['tran_ref'];
                $order->redirect_url = $result['redirect_url'];
                $order->unique_id = $result['cart_id'];
                $order->user_id = auth()->user()->id;
                $order->save();

            
                DB::commit();

            

                return redirect()->to($result['redirect_url']); 
            } catch (\Exception $e) {
            
                DB::rollBack();

                
                return back();
            }
        


        
      
    //    $session =  session(['key' => $result['tran_ref']]);
        //return $result;
    }

   

    
   
    public function dashbaord()
    {
        
       
        return view('admin.index');
    }

    public function supplier_dashbaord()
    {
        
       
        return view('supplier.index');
    }

   
    public function supplierImportExcel(Request $request)
    {
        $path1 = $request->file('data')->store('temp');
        $path=storage_path('app').'/'.$path1;


            Excel::import(new SupplierImport(),$path);

            return redirect()->back()->with('message','تمت الاضافة بنجاح');

    }
   
    public function productImportExcel(Request $request)
    {
        $path1 = $request->file('data')->store('temp');
        $path=storage_path('app').'/'.$path1;


            Excel::import(new ProductImport(),$path);

            return redirect()->back()->with('message','تمت الاضافة بنجاح');

    }

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
        

                $user = auth()->user();
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
        
        
        
        $usercoupon = UserCoupon::where('user_id', auth()->user()->id)
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

    // إضافة للسلة
    public function addtocart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user(); // أو guard('api') حسب setup
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $request->product_id)
                        ->where('type',0)
                        ->first();

        if ($item) {
            $item->quantity += $request->quantity; // ممكن تستخدم $request->quantity فقط لو تريد استبدال الكمية
            $item->save();
            $message = 'تم تحديث الكمية بنجاح';
        } else {
            $item = new CartItem();
            $item->cart_id = $cart->id;
            $item->product_id = $request->product_id;
            $item->quantity = $request->quantity;
            $item->save();
            $message = 'تمت إضافة المنتج إلى السلة';
        }

        return response()->json(['status' => 200, 'message' => $message]);
    }

    // جلب عناصر السلة
    public function getCartItems()
    {
        $user = auth()->user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if(!$cart){
            return response()->json(['items' => []]);
        }

        $items = $cart->items->map(function($item){
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name_en,
                'product_image' => $item->product->clean_image_link_1,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ];
        });

        return response()->json(['items' => $items]);
    }

    // إزالة عنصر من السلة
    public function removeCartItem($id)
    {
        $item = CartItem::find($id);
        if($item){
            $item->delete();
            return response()->json(['status'=>200,'message'=>'تم حذف المنتج']);
        }
        return response()->json(['status'=>404,'message'=>'المنتج غير موجود']);
    }

    public function user_address()
    {
        $addresses = UserAddress::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $addresses
        ]);
    }


    public function add_address(Request $request)
    {
            $validated = $request->validate([
                'governorate_id' => 'required',
                'city_id'        => 'required',
                'address'        => 'required|string',
                'building_no'    => 'nullable|string',
                'floor_no'       => 'nullable|string',
                'flat_no'        => 'nullable|string',
                'phone'          => 'required|string',
            ]);

            $address = UserAddress::create([
                'user_id'        => auth()->id(),
                'governorate_id' => $validated['governorate_id'],
                'city_id'        => $validated['city_id'],
                'address'        => $validated['address'],
                'building_no'    => $validated['building_no'],
                'floor_no'       => $validated['floor_no'],
                'flat_no'        => $validated['flat_no'],
                'phone'          => $validated['phone'],
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Address added successfully',
                'data' => $address
            ]);
    }
    
   public function toggleFavorite(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401,
                'data' => [],
            ], 401);
        }

        $product = Product::findOrFail($request->product_id);

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
        $user = auth()->user();

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

}
