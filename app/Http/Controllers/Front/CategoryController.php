<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request, $categoryslug)
    {
        $id_in = [];

        $query = Category::where('slug','=',$categoryslug)->get();

        if (!count($query)) {
            return view('front.category')
                ->with("error_category", "this category does not exists")
                ->with("categoryname", $categoryslug);
        }
        
        $categoryname = $query[0]->name;

        $query = DB::table("product_categories")->where('category_id','=',$query[0]->id)->get();
        
        if (!count($query)) {
            return view('front.category')
                ->with("error_category", "No results found")
                ->with("categoryname", $categoryslug);
        }

        $results = [];
        
        foreach ( $query as $product ) {
            $id_in[] = $product->product_id;
        }

        $page = intval($request->page) && $request->page > 0 ? intval($request->page): 1;
        
        $skip = ($page * 12) - 12;
        
        $query = Product::whereIn("id",$id_in)->skip($skip)->limit(12)->get();
        
        foreach($query as $account) {
                $x = '';
                foreach($account->categories as $category) {
                    $x .= ', ' . $category->name;
                }
                if ($x) {
                    $x = substr($x,2);
                }
                $account->categories = $x;
                $results[] = $account;
        }

        $pagenate = Product::whereIn("id",$id_in)->count();

        $pagenate = ceil($pagenate/12);
        
        return view('front.category')
            ->with("categoryname",$categoryname)
            ->with("categoryslug",$categoryslug)
            ->with("error_category", false)
            ->with("pagenate", $pagenate)
            ->with("page", intval($request->page))
            ->with("results", $results);

    }

}
