<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\City;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = City::latest()->get();
        return view('admin.city.index',compact('items'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'shipping_price' => 'required',
            'delivery_days' => 'required',
            'governorate_id' => 'required',

        ]);

       $item = new City();
       $item->name_ar = $request->name_ar;
       $item->name_en = $request->name_en;
       $item->governorate_id = $request->governorate_id;
       $item->shipping_price = $request->shipping_price;
       $item->delivery_days = $request->delivery_days;
      
       $item->save();

        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "اضافة المدينة" . ' '. $item->name_ar;
        $log->save();
        return back()->with('message', trans('main.inserted_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function show(Governorate $governorate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $item = City::findOrFail($id);
        return view('admin.city.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
             'shipping_price' => 'required',
            'delivery_days' => 'required',
            'governorate_id' => 'required',
        ]);

        
      $item =  City::findOrFail($id);
      $item->name_ar = $request->name_ar;
       $item->name_en = $request->name_en;
       $item->governorate_id = $request->governorate_id;
       $item->shipping_price = $request->shipping_price;
       $item->delivery_days = $request->delivery_days;
       
      $item->save();

        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "تعديل المدينة" . ' '.$item->name_ar;
        $log->save();
        return back()->with('message', trans('main.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item =  City::findOrFail($id);
    
        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "حذف المدينة" . ' '. $item->name_ar;
        $log->save();
        return back()->with('message', trans('main.deleted_successfully'));
    }
}
