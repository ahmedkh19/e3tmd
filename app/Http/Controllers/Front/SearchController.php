<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductTranslation;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->search ? $request->search: '';
        $type = in_array($request->type, ['users','accounts']) ? $request->type: '';

        if (!$search) {
            return view("front.search")
                ->with("error_search", "Please type something in the search")
                ->with("search", $search);
        }
        if (!$type) {
            return view("front.search")
                ->with("error_search","Please choose type")
                ->with("search", $search);
        }

        $return = [];
        $page = intval($request->page) && $request->page > 0 ? intval($request->page): 1;
        $skip = ($page * 12) - 12;

        if ($type == 'users') {

            $query = User::where('name','LIKE',"%$search%")->skip($skip)->limit(12)->get();

            $pagenate = User::where('name','LIKE',"%$search%")->count();

            foreach ( $query as $user ) {
                $return[] = $user;
            }

        } else {

            $id_in = [];

            $first_query = ProductTranslation::where('name','LIKE',"%$search%")->get();

            foreach($first_query as $product) {
                $id_in[] = $product->product_id;
            }

            $query = Product::whereIn("id",$id_in)->skip($skip)->limit(12)->get();

            $pagenate = Product::whereIn("id",$id_in)->count();

            foreach ( $query as $account ) {
                $x = '';
                foreach($account->categories as $category) {
                    $x .= ', ' . $category->name;
                }
                if ($x) {
                    $x = substr($x,2);
                }
                $account->categories = $x;
                $return[] = $account;
            }

        }

        $pagenate = ceil($pagenate/12);

        return view("front.search")
            ->with("results", $return)
            ->with("pagenate", $pagenate)
            ->with("page", $page)
            ->with("error_search",false)
            ->with("type",$type)
            ->with("search", $search);
    }

}
