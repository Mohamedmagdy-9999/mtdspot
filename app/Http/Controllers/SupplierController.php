<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Log;
use App\Models\UserPurchaseDetail;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier.index',compact('suppliers'));
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
            'name' => 'required',
            'email' => 'required|email|unique:suppliers,email',
            'address' => 'required',
            'phone' => 'required|digits:11',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->password = Hash::make('123456789');
        $supplier->test = $request->email;
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('suppliers', $name);
            $supplier->image = $name;
        }
        $supplier->status = 0;
        $supplier->code = $request->code;
        $supplier->sheet_name = $request->sheet_name;
        $supplier->save();

        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "اضافة المورد" . ' '. $supplier->name;
        $log->save();
        return back()->with('message', trans('main.inserted_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|digits:11',
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'address' => 'required',
            
        ]);
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('suppliers', $name);
            
        }
        $supplier =  Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        if($request->password)
        {
            $supplier->password = Hash::make($request->password);
        }
        
        $supplier->test = $request->password;
        if(!empty($name))
        {
            $supplier->image = $name;
        }
        $supplier->status = $request->status;
        $supplier->code = $request->code;
        $supplier->sheet_name = $request->sheet_name;
        $supplier->save();
        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "تعديل بيانات المورد" . ' '. $supplier->name;
        $log->save();
        // return redirect()->route('admin.supplier.index')->with('message', trans('main.updated_successfully'));
        return back()->with('message', trans('main.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function supplier_order_products()
    {
        $orders = UserPurchaseDetail::where('supplier_id', auth('supplier')->id())->where('transefer', 'created')->latest()->get();
                                        
        return view('supplier.order.index',compact('orders'));
    }

    public function delivered(Request $request,$id)
    {
        $order = UserPurchaseDetail::findOrFail($id);
        $order->update([
            'transefer' => 'delivered',
        ]);
                                        
        return back()->with('message', 'تم التعديل بنجاح');
    }
}
