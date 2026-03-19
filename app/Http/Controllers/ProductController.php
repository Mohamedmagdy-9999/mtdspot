<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Color;
use App\Models\Category;
use App\Models\ProductColor;
use App\Models\Supplier;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
             'name_ar' => 'required',
             'name_en' => 'required',
             'desc_ar' => 'required',
             'desc_en' => 'required',
             'code' => 'required',
             'price' => 'required',
             'supplier_price' => 'required',
             'category_id' => 'required',
             'supplier_id' => 'required',
             'variants' => 'nullable|array',
             'variants.*.color_id' => 'nullable|exists:colors,id',
             'images' => 'required',
         ]);
     
         
            $product =  new Product();
            $product->name_ar = $request->name_ar;
            $product->name_en = $request->name_en;
            $product->desc_ar = $request->desc_ar;
            $product->desc_en = $request->desc_en;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->code = $request->code;
            $product->supplier_price = $request->supplier_price;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->warranty_period = $request->warranty_period;
            if($request->file('images'))
            {
                $images = '';
                foreach ($request->file('images') as $image) {
                    $name3 = $image->getClientOriginalName();
                    $image->move('products', $name3);
                    $images .= $name3 .',';
                    $product->images = rtrim($images, ',');
                }
            }
            $product->image_link_1 = $request->image_link_1;
            $product->image_link_1 = $request->image_link_1;
            $product->image_link_1 = $request->image_link_1;
            $product->image_link_1 = $request->image_link_1;
            $product->save();
     
             foreach ($request->variants as $variantData) {
				$variant = new ProductColor();
				$variant->product_id = $product->id;
				$variant->color_id = $variantData['color_id'];
				$variant->save();
			}

     
                $log = new Log();
                $log->username = auth()->guard('admin')->user()->name;
                $log->details = "اضافة منتج" .' '. $product->name;
                $log->save();
             return redirect()->route('admin.product.index')->with('message', trans('main.inserted_successfully'));
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::latest()->get();
        $suppliers = Supplier::latest()->get();
        $colors = Color::latest()->get();
        return view('admin.product.edit',compact('product','categories','suppliers','colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'code' => 'required',
            'price' => 'required',
            'supplier_price' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            
            'images.*' => 'nullable|image',
        ]);

        $product->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'code' => $request->code,
            'supplier_price' => $request->supplier_price,
            'price' => $request->price,
            'discount' => $request->discount,
            'warranty_period' => $request->warranty_period,
            'image_link_1' => $request->image_link_1,
            'image_link_1' => $request->image_link_1,
            'image_link_1' => $request->image_link_1,
            'image_link_1' => $request->image_link_1,
        ]);

        // لو في صور جديدة
        if ($request->hasFile('images')) {
            $images = '';
            foreach ($request->file('images') as $image) {
                $name3 = $image->getClientOriginalName();
                $image->move('products', $name3);
                $images .= $name3 . ',';
            }
            $product->images = rtrim($images, ',');
            
        }
        $product->save();

        // حذف الألوان القديمة
        ProductColor::where('product_id', $product->id)->delete();

        // حفظ الألوان الجديدة
        if ($request->variants) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['color_id'])) {
                    ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' => $variant['color_id']
                    ]);
                }
            }
        }

        // سجل العمليات
        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "تحديث منتج " . $product->name;
        $log->save();

        return redirect()->back()->with('message', trans('main.updated_successfully'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
