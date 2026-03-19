<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\Log;
class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::latest()->get();
        return view('admin.color.index', compact('colors'));
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
            'name' => 'required|unique:colors,name',
            'color' => 'required',
           
        ]);

       
            $color = new Color();
            $color->name = $request->name;
            $color->color = $request->color;
            $color->save();

            $log = new Log();
            $log->username = auth()->guard('admin')->user()->name;
            $log->details = "اضافة لون" .' '. $color->name;
            $log->save();

            return back()->with('message', trans('main.inserted_successfully'));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:colors,name,' . $id,
            'color' => 'required',
           
        ]);

       
            $color = Color::findOrFail($id);
            $color->name = $request->name;
            $color->color = $request->color;
            $color->save();

            $log = new Log();
            $log->username = auth()->guard('admin')->user()->name;
            $log->details = "تعديل لون" .' '. $color->name;
            $log->save();

            return back()->with('message', trans('main.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $color = Color::findOrFail($id);
           
            $log = new Log();
            $log->username = auth()->user()->name;
            $log->details = "حذف لون" .' '. $color->name;
            $log->save();
            $color->delete();
            return back()->with('message', trans('main.deleted_successfully'));
    }
}
