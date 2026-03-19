<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Log;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupon.index',compact('coupons'));
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
            'code' => 'required',
            'end_date' => 'required|date|after_or_equal:today',
            'value' => 'required',
           
        ]);

       
            $exist = Coupon::where('code',$request->code)->where('end_date',$request->end_date)->first();
            if($exist)
            {
                return back()->with('error', 'هذا الكود موجود من قبل');
            }else{
                $coupon = new Coupon();
                $coupon->code = $request->code;
                $coupon->value = $request->value;
                $coupon->end_date = $request->end_date;
                $coupon->save();

                $log = new Log();
                $log->username = auth()->guard('admin')->user()->name;
                $log->details = "اضافة كوبون" .' '. $coupon->code;
                $log->save();
            }
            

            return back()->with('message', trans('main.inserted_successfully'));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'end_date' => 'required|date|after_or_equal:today',
            'value' => 'required',
           
        ]);

       
            $exist = Coupon::where('code',$request->code)->where('end_date',$request->end_date)->first();
            if($exist)
            {
                return back()->with('error', 'هذا الكود موجود من قبل');
            }else{
                $coupon =  Coupon::findOrFail($id);
                $coupon->code = $request->code;
                $coupon->value = $request->value;
                $coupon->end_date = $request->end_date;
                $coupon->save();

                $log = new Log();
                $log->username = auth()->guard('admin')->user()->name;
                $log->details = "تعديل كوبون" .' '. $coupon->code;
                $log->save();
            }
                return redirect()->route('admin.coupon.index')->with('message', trans('main.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon =  Coupon::findOrFail($id);
        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "حذف كوبون" .' '. $coupon->code;
        $log->save();
        $coupon->delete();
        return back()->with('message', trans('main.deleted_successfully'));
    }
}
