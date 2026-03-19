<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Log;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
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

        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "اضافة القسم" . ' '. $category->name_ar;
        $log->save();
        return back()->with('message', trans('main.inserted_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "تعديل القسم" . ' '. $category->name_ar;
        $log->save();
        return back()->with('message', trans('main.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  Category::findOrFail($id);
    
        $log = new Log();
        $log->username = auth()->guard('admin')->user()->name;
        $log->details = "حذف القسم" . ' '. $category->name_ar;
        $log->save();
        $category->delete();
        return back()->with('message', trans('main.deleted_successfully'));
    }
}
