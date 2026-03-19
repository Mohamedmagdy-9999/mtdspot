<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\SliderProduct;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
            
    //         'image' => 'required',
    //     ]);

    //    $slider = new Slider();
     
    //    if ($file = $request->file('image')) {
    //         $name = time() . $file->getClientOriginalName();
    //         $file->move('sliders', $name);
    //         $slider->image = $name;
    //     }
    //    $slider->save();

    //     $log = new Log();
    //     $log->username = auth()->guard('admin')->user()->name;
    //     $log->details = "اضافة شريط صور" ;
    //     $log->save();
    //     SliderProduct;
    //     return back()->with('message', trans('main.inserted_successfully'));
    // }

    public function store(Request $request)
    {
        // $request->validate([
            
        //     'image'     => 'required|image|mimes:jpg,jpeg,png,webp',
        // ]);

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
        $log->username = auth()->guard('admin')->user()->name;
        $log->details  = "اضافة شريط صور";
        $log->save();

        return back()->with('message', trans('main.inserted_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "تعديل شريط صور" ;
        $log->save();
        return back()->with('message', trans('main.inserted_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
       $slider = Slider::findOrFail($id);
        

        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "حذف شريط صور" ;
        $log->save();
        $slider->delete();
        return back()->with('message', trans('main.deleted_successfully'));
    }
}
