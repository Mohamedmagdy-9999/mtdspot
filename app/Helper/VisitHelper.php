<?php

namespace App\Helper;

use App\Models\Visits;

class VisitHelper
{
    public static function store($ip_address, $free_book_id, $free_book_name)
    {
        $view = Visits::where(['ip_address'=>$ip_address,'free_book_id' =>$free_book_id, 'free_book_name' =>$free_book_name])->first();

        if (!$view) {
            $data = [
                'free_book_id'=>$free_book_id,
                'free_book_name'=>$free_book_name,
                'ip_address'=> $ip_address,
                'views' => 1
            ];
            Visits::create($data);
        } else {
            $data = [
                'views' => $view->views +1,
            ];

            
            $view->update($data);
        }
    }
}
