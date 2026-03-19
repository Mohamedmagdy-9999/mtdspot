<?php

namespace App\Http\Controllers;

use App\Models\UserPurchase;
use Illuminate\Http\Request;
use App\Models\UserPurchaseDetail;
class UserPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = UserPurchase::latest()->get();
        return view('admin.order.index',compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPurchase  $userPurchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = UserPurchase::findOrFail($id);
        return view('admin.order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPurchase  $userPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPurchase $userPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPurchase  $userPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPurchase $userPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPurchase  $userPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPurchase $userPurchase)
    {
        //
    }

    public function start_order(Request $request, $id)
    {
        $order = UserPurchase::findOrFail($id);

        $order->update([
            'order_status' => 'processing',
        ]);

        foreach ($order->details as $detail) {
            $detail->update([
                'transefer' => 'created'
            ]);
        }

        return back()->with('message', 'تم البدأ بنجاح');
    }

}
