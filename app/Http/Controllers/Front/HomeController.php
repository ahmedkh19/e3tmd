<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $accounts = [];

        $query = Product::where("isPaid","=","1")->limit(15)->get();

        foreach ($query as $product) {
            $accounts[] = $product;
        }

        return view('front.home')
            ->with("accounts", $accounts);

    }
}
