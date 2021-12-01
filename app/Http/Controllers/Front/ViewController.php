<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public static function check_view($ip, $product_id)
    {
        $query = DB::table('views')
            ->where('ip','=',$ip)
            ->where('product_id','=',$product_id)
            ->first();

        if ($query) {
            return false; // exists don't do anything
        }

        DB::table('views')->insert([
            'ip' => $ip,
            'product_id' => $product_id
        ]);
        return true; // yes you can increase
    }

}
