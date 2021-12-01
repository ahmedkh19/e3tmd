<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request, $slug)
    {
        $product = Product::where("slug","=",$slug)->first();

        if ( $product ) {

            if ( ViewController::check_view($request->ip(), $product->id) ) {
                // not exsits in views table
                $product->viewed = $product->viewed + 1;
                $product->save();
            }

            $product_images = ProductImage::where('product_id','=',$product->id)->get();

            /************/
            $author_others = Product::where("user_id","=",$product->user_id)
                ->where("id","!=",$product->id)
                ->limit(9)
                ->get();
            /************/

            /************/
            $highest_bid = DB::table("bids")
                ->where("product_id","=",$product->id)
                ->max('bid_amount');
            /************/

            /************/
            $id_in = [];
            $cat_in = [];
            foreach($product->categories as $cat) { // get categories of the current account
                $cat_in[] = $cat->id;
            }
            foreach(DB::table("product_categories")->whereIn("category_id",$cat_in)->get() as $row) {
                // get ID's of accounts with the same categories
                $id_in[] = $row->product_id;
            }
            $similar_posts = Product::where("id","!=",$product->id)
                ->whereIn("id",$id_in)
                ->limit(9)
                ->get();
            /************/

            $author = User::where('id','=',$product->user_id)->first();

            if ($product->status == 1)
            return view('front.product')
                ->with("product",$product)
                ->with("product_images", $product_images)
                ->with("similar_posts", $similar_posts)
                ->with("author_others", $author_others)
                ->with("highest_bid", $highest_bid)
                ->with("author", $author);
            else return abort(404);
        } else {
            return abort(404);
        }
    }

}
