<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;


class SupplierImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {

            
            $supplier =  Supplier::updateOrCreate(
            [
                'sheet_name' => $row['sheet_name'],
            ],[
                'code' => $row['code'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'address' => $row['address'],
                'password' => Hash::make('123456789'),
                'status' => 0,
            ]
            );
       

        }

    }
}
