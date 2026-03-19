<?php

namespace App\Imports;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */




    public function collection(Collection $rows)
    {
      foreach($rows as $row)
      {
        $supplier = Supplier::where('name', $row['supplier'])->first();
        $category = Category::where('name_en', $row['category'])->first();
         $product =  Product::create(
                           
                            [
                                'name_en' => $row['name_en'],
                                'name_ar' => $row['name_ar'],
                                'supplier_id' => $supplier->id ?? null,
                                'category_id' => $category->id ?? null,
                                'desc_ar' => $row['desc_ar'],
                                'desc_en' => $row['desc_en'],
                                'supplier_price' => $row['supplier_price'],
                                'price' => $row['price'],
                                'stock' => $row['stock'],
                                'color_family' => $row['color_family'],
                                'light_bulb_type' => $row['light_bulb_type'],
                                'main_material' => $row['main_material'],
                             
                                'note' => $row['note'],
                                'manufacturer_txt' =>$row['manufacturer_txt'],
   
                                'package_content_ar' => $row['package_content_ar'],
                                'product_measures' => $row['product_measures'],
                                'product_weight' => $row['product_weight'],
                                'short_description' => $row['short_description'],
                                'short_description_ar' => $row['short_description_ar'],
                                'image_link_1' => $row['image_link_1'],
                                'image_link_2' => $row['image_link_2'],
                                'image_link_3' => $row['image_link_3'],
                                'image_link_4' => $row['image_link_4'],
        
                            ]);
       
    }
}










}

         
           
          
               
         