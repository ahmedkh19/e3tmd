<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        return view('front.store')
            ->with('best_deals', $this->best_deals())
            ->with('new_products', $this->new_products())
            ->with('bids_products', $this->bids_products());
    }
    
    public function new_products()
    {
        /**
         * get products order by new orders
         * 
         * @return array
         */

        $x = [];
        
        $count = Product::where('pricing_method','=','fixed')->count();
        
        $x['pages'] = ceil($count / 5);

        $products = Product::limit(5)
            ->where('pricing_method','=','fixed')
            ->get();

        $x['products'] = $products;
        return $x;     
    }

    public function bids_products()
    {
        /**
         * get products order by new orders and paginate pages
         * 
         * @return array
         */

        $x = [];
        
        $count = Product::where('pricing_method','=','auction')->count();

        $x['pages'] = ceil($count / 5);

        $products = Product::limit(5)
            ->where('pricing_method','=','auction')
            ->get();

        $x['products'] = $products;
        return $x;    
    }

    public function get_accounts(Request $request)
    {
    
        if ($request->locale == 'ar') {
            \App::setLocale('ar');
        }

        $type = $request->input("type");
        
        $page = $request->input("page") ? $request->input("page") : 1 ;
        
        $skip = (intval($page) * 5) - 5;
      
        $data = [];
        
        if ( $type == 'new' ) {

            $query = Product::where('pricing_method','=','fixed');

            /******* search filter *******/
            if ($request->input("search")) {
                $xarray = []; // ID's of posts with matched search
                $xquery = DB::table('product_translations')->where("name","LIKE", "%" . $request->input("search") . "%")->get();
                foreach($xquery as $IDS) {
                    $xarray[] = $IDS->product_id;
                }
                $query = $query->whereIn('id',$xarray);
            }
            /******* !search filter *******/

            /******* price filter *******/
            if ($request->input("price_order")) {
            
                if ($request->input("price_order") == 'asc') {
                    $query = $query->orderBy('price', 'asc');
                } else if ($request->input("price_order") == 'desc') {
                    $query = $query->orderBy('price', 'desc');
                }
                
            }
            
            if ($request->input("min_price")) {
                $query = $query->where('price', ">=", $request->input("min_price"));
            }
            if ($request->input("max_price")) {
                $query = $query->where('price', "<=", $request->input("max_price"));
            }
            /******* !price filter *******/
            
            /******* categories filter *******/
            if ($request->input("categories") && is_array($request->input("categories"))) {
                $xarray = []; // ID's of posts with matched category
                $yarray = []; // clean the request to check if its number or not
                foreach($request->input("categories") as $num) {
                    if (intval($num)) {
                        $yarray[] = $num;
                    }
                }
                $xquery = DB::table('product_categories')->whereIn("category_id",$yarray)->get();
                foreach($xquery as $IDS) {
                    $xarray[] = $IDS->product_id;
                }
                $query = $query->whereIn('id',$xarray);
            }
            /******* !categories filter *******/
            
            /******* PLATFORM filter *******/
            if ($request->input("os") && is_array($request->input("os"))) {
                $os = '';
                foreach($request->input("os") as $item) {
                    $os .= $item;
                }
                if ( $os && $os != 'pxso' /* NOT ALL */  ) {

                    if (!Str::contains($os,'p')) {
                        $query = $query->where('os',"NOT LIKE","%p%");
                    }
                    if (!Str::contains($os,'x')) {
                        $query = $query->where('os',"NOT LIKE","%x%");
                    }
                    if (!Str::contains($os,'s')) {
                        $query = $query->where('os',"NOT LIKE","%s%");
                    }
                    if (!Str::contains($os,'o')) {
                        $query = $query->where('os',"!=","o");
                    }
                }

            }
            if (!$request->input("os")) {
                $query = $query->limit(0);
            }
            /******* !PLATFORM filter *******/

            $data['pages'] = ceil($query->count() / 5);

            $query = $query->skip($skip)
                ->limit(5)->get();

            $products = [];
            
            foreach ($query as $product) {
                $hold = [];

                $hold['name'] = $product['name'];
                $hold['slug'] = $product['slug'];
                $hold['main_image'] = $product['main_image'];
                $hold['price'] = $product['price'] . currency( $product['currency'],false);
                $hold['viewed'] = $product['viewed'];
                $hold['os'] = '';
                if ($product->os) {
                    if(Str::contains($product->os,'x')) {
                        $hold['os'] .= '<i class="fab fa-xbox"></i> ';
                    }
                    if(Str::contains($product->os,'p')) {
                        $hold['os'] .= '<i class="fab fa-playstation"></i> ';
                    }
                    if(Str::contains($product->os,'s')) {
                        $hold['os'] .= '<i class="fa fa-mobile"></i> ';
                    }
                }
                $hold['categories'] = '';
                foreach($product['categories'] as $category) {
                    $hold['categories'] .= ', ' . $category->name;
                }
                if ($hold['categories']) {
                    $hold['categories'] = substr($hold['categories'],2);
                }

                $products[] = $hold;
            }

            $data['products'] = $products;

        } else if ($type == "bid") {

            $query = Product::where('pricing_method','=','auction');

            /******* search filter *******/
            if ($request->input("search")) {
                $xarray = []; // ID's of posts with matched search
                $xquery = DB::table('product_translations')->where("name","LIKE", "%" . $request->input("search") . "%")->get();
                foreach($xquery as $IDS) {
                    $xarray[] = $IDS->product_id;
                }
                $query = $query->whereIn('id',$xarray);
            }
            /******* !search filter *******/

            /******* price filter *******/
            if ($request->input("price_order")) {

                if ($request->input("price_order") == 'asc') {
                    $query = $query->orderBy('start_bid_amount', 'asc');
                } else if ($request->input("price_order") == 'desc') {
                    $query = $query->orderBy('start_bid_amount', 'desc');
                }

            }

            if ($request->input("min_price")) {
                $query = $query->where('start_bid_amount', ">=", $request->input("min_price"));
            }
            if ($request->input("max_price")) {
                $query = $query->where('start_bid_amount', "<=", $request->input("max_price"));
            }
            /******* !price filter *******/
            
            /******* categories filter *******/
            if ($request->input("categories") && is_array($request->input("categories"))) {
                $xarray = []; // ID's of posts with matched category
                $yarray = []; // clean the request to check if its number or not
                foreach($request->input("categories") as $num) {
                    if (intval($num)) {
                        $yarray[] = $num;
                    }
                }
                $xquery = DB::table('product_categories')->whereIn("category_id",$yarray)->get();
                foreach($xquery as $IDS) {
                    $xarray[] = $IDS->product_id;
                }
                $query = $query->whereIn('id',$xarray);
            }
            /******* !categories filter *******/

            /******* PLATFORM filter *******/
            if ($request->input("os") && is_array($request->input("os"))) {
                $os = '';
                foreach($request->input("os") as $item) {
                    $os .= $item;
                }
                if ( $os && $os != 'pxso' /* NOT ALL */  ) {

                    if (!Str::contains($os,'p')) {
                        $query = $query->where('os',"NOT LIKE","%p%");
                    }
                    if (!Str::contains($os,'x')) {
                        $query = $query->where('os',"NOT LIKE","%x%");
                    }
                    if (!Str::contains($os,'s')) {
                        $query = $query->where('os',"NOT LIKE","%s%");
                    }
                    if (!Str::contains($os,'o')) {
                        $query = $query->where('os',"!=","o");
                    }
                }

            }
            if (!$request->input("os")) {
                $query = $query->limit(0);
            }
            /******* !PLATFORM filter *******/

            $data['pages'] = ceil($query->count() / 5);

            $query = $query->skip($skip)
                ->limit(5)->get();

            $products = [];

            foreach ($query as $product) {
                $hold = [];

                $hold['name'] = $product['name'];
                $hold['slug'] = $product['slug'];
                $hold['main_image'] = $product['main_image'];
                $hold['start_bid_amount'] = $product['start_bid_amount'] . currency( $product['currency'],false);
                $hold['auction_start'] = substr(str_replace("T"," ",$product['auction_start']),0,16);
                $hold['auction_end'] = substr(str_replace("T"," ",$product['auction_end']),0,16);
                $hold['os'] = '';
                if ($product->os) {
                    if(Str::contains($product->os,'x')) {
                        $hold['os'] .= '<i class="fab fa-xbox"></i> ';
                    }
                    if(Str::contains($product->os,'p')) {
                        $hold['os'] .= '<i class="fab fa-playstation"></i> ';
                    }
                    if(Str::contains($product->os,'s')) {
                        $hold['os'] .= '<i class="fa fa-mobile"></i> ';
                    }
                }
                $hold['categories'] = '';
                foreach($product['categories'] as $category) {
                    $hold['categories'] .= ', ' . $category->name;
                }
                if ($hold['categories']) {
                    $hold['categories'] = substr($hold['categories'],2);
                }

                $products[] = $hold;
            }

            $data['products'] = $products;

        }

        return $data;

    }
    
    public function best_deals()
    {
        return Product::where('isPaid','=','1')->limit(15)->get();
    }

}
