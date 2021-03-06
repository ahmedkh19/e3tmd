<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccountRequest;
use App\Models\Bid;
use App\Models\PasswordEncryption;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Notifications\SendMessageNotificationToUser;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use DB;
use DataTables;
use Illuminate\Support\Str;
class ProductsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
//        $products = Product::select('id','slug','price', 'created_at')->paginate(15);
//        return view('content.products.index', compact('products'));
        return view('content.products.index');
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {

            if (auth()->user()->hasRole(['Owner', 'Products-Editor'])) {
                $products = Product::orderBy('id','DESC')->get();
            } else
            $products = Product::orderBy('id','DESC')->where('user_id' , auth()->id())->get();
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('products.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Edit") . '</a> <a href="'. route('products.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Delete") . '</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }
    
    public function bid_confirm($id,Request $request)
    {
        $bid = Bid::find($id);
        
        if ( \Auth::check() ) {

            if ( $bid ) {
            
                $product = Product::where("id","=",$bid->product_id)
                    ->where("pricing_method","=","Auction")
                    ->first();
                if ($product) {

                    $author = $product->user_id;
                    
                    if ( \Auth::user()->id === $author ) {
                        if ($bid->win_status) {
                            if ( !$product->isSold ) {
                                $product->isSold = true;
                                $product->save();
                                return redirect()->back()->with('bid_success','???? ?????????? ?????????? ??????????');
                            } else {
                                return redirect()->back()->with('bid_error','?????? ???????????? ???? ???????? ???? ???????? ?????????????? ????????');
                            }
                        } else {
                            return redirect()->back()->with('bid_error','?????? ???????? ?????????? ????????');
                        }
                    } else {
                        return redirect()->back()->with('bid_error','???????? ?????? ???????? ?????????????? ???????? ??????????');
                    }

                } else {
                    return redirect()->back()->with('bid_error','???????? ???? ?????? ?????????? ???????????? ?????????? ???????? ??????????');
                }

            } else {
                return redirect()->back()->with('bid_error','???????? ???? ?????? ?????????? ?????? ??????????');
            }

        } else {
            return redirect()->back()->with('bid_error','???????? ?????????? ???????????? ????????');
        }
    }
    
    public function bid_cancel($id,Request $request)
    {
        $bid = Bid::find($id);
        
        if ( \Auth::check() ) {

            if ( $bid ) {
            
                $product = Product::where("id","=",$bid->product_id)
                    ->where("pricing_method","=","Auction")
                    ->first();
                if ($product) {

                    $author = $product->user_id;
                    
                    if ( \Auth::user()->id === $author ) {
                        if ($bid->win_status) {
                            if ( !$product->isSold ) {
                                $bid->win_status = false;
                                $bid->save();
                                return redirect()->back()->with('bid_success','???? ?????????? ???????????? ??????????');
                            } else {
                                return redirect()->back()->with('bid_error','?????? ???????????? ???? ???????? ???? ???????? ?????????????? ????????');
                            }
                        } else {
                            return redirect()->back()->with('bid_error','?????? ???????? ?????????? ????????');
                        }
                    } else {
                        return redirect()->back()->with('bid_error','???????? ?????? ???????? ?????????????? ???????? ??????????');
                    }

                } else {
                    return redirect()->back()->with('bid_error','???????? ???? ?????? ?????????? ???????????? ?????????? ???????? ??????????');
                }

            } else {
                return redirect()->back()->with('bid_error','???????? ???? ?????? ?????????? ?????? ??????????');
            }

        } else {
            return redirect()->back()->with('bid_error','???????? ?????????? ???????????? ????????');
        }

    }

    public function bids_ajax($id,Request $request)
    {
        if ($request->ajax()) {

            $win = false;

            $bids = Bid::orderBy('bid_amount', 'desc')->where('product_id', '=', $id)->get();

            foreach($bids as $bid) {
                if ($bid->win_status) {
                    $win = $bid->id;
                }
            }

            return Datatables::of($bids)
                ->addIndexColumn()
                ->addColumn('action', function($row) use ($win, $id) {

                    $accept = '<a href="' . route('products-bid_accept', $row->id) . '" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Accept") . '</a>';
                    
                    $cancel = '<a onclick="return confirm(\'Cancel ?\')" href="' . route('products-bid_cancel', $row->id) . '" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">Cancel</a>';
                    
                    $confirm = '<a onclick="return confirm(\'Are you sure? this account will be sold you cant change this\')" href="' . route('products-bid_confirm', $row->id) . '" class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">Confirm</a>';

                    $not_accepted = '<a class="btn btn-outline-secondary btn-min-width box-shadow-3 mr-1 mb-1">Not Accepted</a>';
                    
                    $accepted = '<a class="btn btn-outline-secondary btn-min-width box-shadow-3 mr-1 mb-1">Accepted</a>';
                    
                    $confirm_cancel = Product::where("id","=",$id)->where("pricing_method","=","Auction")->first();
                    
                    if ( $confirm_cancel && $confirm_cancel->isSold ) {
                        $confirm = $cancel = '';
                    }
                    
                    if ( $win ) {
                        if ( $win == $row->id ) {
                            return $accepted . $confirm . $cancel;
                        } else {
                            return $not_accepted;
                        }
                    } else {
                        return $accept;
                    }

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function bid_accept($id,Request $request)
    {

        $win = false;

        $bid = Bid::find($id);
        
        if ( $bid ) {

            $product = Product::where("id","=",$bid->product_id)
                ->where("pricing_method","=","Auction")
                ->first();
            
            if ( $product ) {

                $author = $product->user_id;

                if ( \Auth::check() && \Auth::user()->id === $author ) {

                    foreach (Bid::where("product_id","=",$product->id)->get() as $item) {
                        if ($item->win_status) {
                            $win = true;
                        }
                    }
                
                    if ( $win ) {
                    
                        return redirect()->back()->with('bid_error','???????? ???? ???????? ?????? ??????');
                    
                    } else {

                        $bid->win_status = true;
                        $product->price = $bid->bid_amount;
                        $bid->update();
                        $product->update();
                        $conv = new ConversationsController();
                        return redirect()->route('chat.show', $conv->create2($bid->product_id, $bid->user_id , $product->user_id))->with('success', __('data.Accepted successfully'));

                    }

                } else {
                    return redirect()->back()->with('bid_error', '?????? ?????? ???????? ?????????????? ???????? ??????????');
                }

            } else {
               return redirect()->back()->with('bid_error', '???????? ?????? ???????????? ?????? ??????????');
            }

        } else {
            return redirect()->back()->with('bid_error', '???????? ?????? ?????????? ?????? ????????');
        }

//      $now = time();
//      $datediff = $now - $bid->win_date;
//      if (empty($bid->win_date) || round($datediff / (60 * 60 * 24))) {
//          $bid->win_status = true;
//          ->win_date = time();
//      } else {
//          return '???????? ???? ???????? 24 ????????';
//      }

    }

    public function create()
    {
        $categories = Category::where("is_active",'1')->parent()->get();
        return view('content.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    
        //validation
        $request->validate([
            'name' => 'required|max:100',
            'short_description' => 'nullable|max:150',
            'description' => 'required|max:500',
            'categories' => 'required',
            'main_image' => 'required|image|mimes:jpg,png,jpeg',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png',
            'pricing_method' => 'required|in:Fixed,Auction',
            'price' => 'required_if:pricing_method,Fixed|nullable|numeric',
            'start_bid_amount' => 'required_if:pricing_method,Auction|numeric|nullable',
            'auction_start' => 'required_if:pricing_method,Auction|nullable|date',
            'auction_end' => 'required_if:pricing_method,Auction|nullable|date',
            'plan' => 'required|in:Basic,Paid',
            'account_email' => 'required_with:account_password,account_confirm_password,account_username,account_email_website|nullable|email',
            'account_email_website' => 'required_with:account_password,account_confirm_password,account_email,account_username|nullable|url',
            'account_username' => 'required_with:account_password,account_confirm_password,account_email,account_email_website|nullable',
            'account_password' => 'required_with:account_username,account_confirm_password,account_email,account_email_website|nullable',
            'account_confirm_password' => 'required_with:account_username,account_password,account_email,account_email_website|nullable|same:account_password',
        ]);

        try {
           // return $request;
            DB::beginTransaction();

            $product = new Product();
            $product->user_id = auth()->user()->id;
            // Featured image //
            if ($request->main_image) {
                $product->main_image = uploadImage('products', $request->main_image);
            }
            // Featured image //

            //save translations
            $product->name = $request->name;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            
            // Pricing Method //
            $pricing_method = $request->pricing_method;
            $price = $request->price;
            $product->pricing_method = $pricing_method;
            $plan = $request->plan;
            $Commission = Setting::getCommission();
            $ad_fixed_price = Setting::getAdFixedPrice();
            $ad_auction_price = Setting::getAdAuctionPrice();
            
            $os = '';
            $os .= $request->os && is_array($request->os) && in_array('p',$request->os)  ? 'p': '';
            $os .= $request->os && is_array($request->os) && in_array('x',$request->os)  ? 'x': '';
            $os .= $request->os && is_array($request->os) && in_array('s',$request->os)  ? 's': '';
            if (!$os) {
                // no choice
                $os .= 'o';
            }
            /**
             * p  = playstation
             * x  = xbox
             * s  = Smartphone
             * o  = Other
             * 
             * example : px => means pleastation and xbox
             * NOTE: order is important
             * 
             */

            $product->os = $os;

            //Fixed price
            if ($pricing_method === 'Fixed' && $plan === 'Basic') {
                $product->commission = $Commission;
                $product->price = $price;
            } else if ($pricing_method === 'Fixed' && $plan === 'Paid') {
                if ( !BalanceDeduction(auth()->user()->id, $ad_fixed_price)) {
                    return Redirect()->back()->with('error', __('data.You do not have enough credit to add the account, please add credit to be able to complete the process'));
                }
                $product->price = $price;
                $product->isPaid = 1;

            } //Auction
            else if ($pricing_method === 'Auction' && $plan === 'Paid') {
                $product->start_bid_amount = $request->start_bid_amount;
                $product->auction_start = $request->auction_start;
                $product->auction_end = $request->auction_end;
                if ( !BalanceDeduction(auth()->user()->id, $ad_auction_price)) {
                    return Redirect()->back()->with('error', __('data.You do not have enough credit to add the account, please add credit to be able to complete the process'));
                }
                $product->isPaid = 1;
            } else {
                return redirect()->back()->with(['error', __('data.An error occurred, please try again later')]);
            }
            $EncryptionClass = new PasswordEncryption();
            // Account information //
            $product->account_email = $request->account_email;
            $product->account_password = $request->account_password ? $EncryptionClass->encryptAES($request->account_password, env('AES_ENCRYPTION_KEY')) : '';
            $product->account_username = $request->account_username;
            $product->account_email_website = $request->account_email_website;

            // Account information //

            $product->save();

            if (Config('app.locale') == 'en') {
                $locale = 'ar';
            } else {
                $locale = 'en';
            }
            try {
                DB::table('product_translations')->insert([
                    'locale' => $locale,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'short_description' => $product->short_description
                ]);
            } catch (\Exception $ex){
                return redirect()->back()->with(['error', __('data.An error occurred, please try again later')]);
            }

            //save product categories

            $product->categories()->attach($request->categories);
            $product->categories()->attach($request->sub_categories);
            // images //
            if ($request->images) {
                $img_data = uploadImages('products', $request->images);
                foreach ($img_data as $name) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'name' => $name
                    ]);
                }
            }
            // images //


            DB::commit();
            return redirect()->back()->with(['success' => __('data.Added successfully')]);
        } catch(\Exception $ex){
            return redirect()->back()->with(['error', __('data.An error occurred, please try again later')]);

        }

    }

    public function edit($id)
    {
        //get specific categories and its translations
        $categories = Category::where("is_active",'1')->parent()->get();
        $product = Product::find($id);
        if ($product->user_id != auth()->id() && !auth()->user()->hasRole(['Owner', 'Products-Editor']))
            return redirect()->route('products.index')->with(['error' => __('data.This account is unavailable')]);

        if (!$categories || !$product)
            return redirect()->back()->with(['error' => __('data.This account is unavailable')]);

        return view('content.products.edit', compact('categories') , compact('product'));

    }


    public function update($id, Request $request)
    {

        //validation
        $request->validate([
            'name' => 'required|max:100',
            'short_description' => 'nullable|max:150',
            'description' => 'required|max:500',
            'categories' => 'required',
            'main_image' => 'nullable|image|mimes:jpg,png,jpeg',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png',
            'price' => 'nullable|numeric',
            'start_bid_amount' => 'numeric|nullable',
            'auction_start' => 'nullable|date',
            'auction_end' => 'nullable|date',
            'account_email' => 'nullable|email',
            'account_email_website' => 'nullable|url',
            'account_confirm_password' => 'nullable|same:account_password',
        ]);

        try {
            $product = Product::find($id);
            if (!$product)
                return redirect()->back()->with(['error' => __('data.This account is unavailable')]);

           //  return $request;
            DB::beginTransaction();

            //save translations
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            
            DB::table("product_categories")->where("product_id","=",$product->id)->delete();
            
            // Featured image //
            if ($request->main_image) {
                deleteImage('products', $product->main_image);
                $product->main_image = uploadImage('products', $request->main_image);
            }
            // Featured image //

            $os = '';
            $os .= $request->os && is_array($request->os) && in_array('p',$request->os)  ? 'p': '';
            $os .= $request->os && is_array($request->os) && in_array('x',$request->os)  ? 'x': '';
            $os .= $request->os && is_array($request->os) && in_array('s',$request->os)  ? 's': '';
            if (!$os) {
                // no choice
                $os .= 'o';
            }
            /**
             * p  = playstation
             * x  = xbox
             * s  = Smartphone
             * o  = Other
             * 
             * example : px => means pleastation and xbox
             * NOTE: order is important
             * 
             */

            $product->os = $os;

            // images //
            $keep_images = [];
            
            if ($request->keep_images) {
                foreach($request->keep_images as $pimage) {
                    $keep_images[] = $pimage;
                }
            }

            foreach ( ProductImage::where("product_id","=",$product->id)->whereNotIn("name",$keep_images)->get() as $dimage ) {
                deleteImage("products",$dimage->name);
            }

            ProductImage::where("product_id","=",$product->id)
                ->whereNotIn("name",$keep_images)
                ->delete();

            if ($request->images) {

                $img_data = uploadImages('products', $request->images);
                foreach ($img_data as $name) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'name' => $name
                    ]);
                }
            }
            // images //

            $product->categories()->attach($request->categories);
            $product->categories()->attach($request->sub_categories);

            $EncryptionClass = new PasswordEncryption();
            // Account information //
            $product->account_email = $request->account_email;
            if (!empty($request->account_password))
            $product->account_password = $EncryptionClass->encryptAES($request->account_password, env('AES_ENCRYPTION_KEY'));
            $product->account_username = $request->account_username;
            $product->account_email_website = $request->account_email_website;


            // Pricing Method //
            if (!empty($product->price) && !empty($request->price)) {
            $product->price = $request->price;
            }
            if (!empty($product->start_bid_amount) && !empty($request->start_bid_amount)) {
            $product->start_bid_amount = $request->start_bid_amount;
            }
            if (!empty($product->auction_start) && !empty($request->auction_start)) {
            $product->auction_start = $request->auction_start;
            }
            if (!empty($product->auction_end) && !empty($request->auction_end)) {
            $product->auction_end = $request->auction_end;
            }

            // Account information //
            $product->update();

            DB::commit();
            return redirect()->back()->with(['success' => __('data.Updated successfully')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
        }

    }


    public function destroy($id)
    {

        try {
            $product = Product::find($id);
            if ($product->user_id != auth()->id())
                return redirect()->route('products.index')->with(['error' => __('data.This account is unavailable')]);

            if ($product):
                $product->delete(); // delete first before return
                return redirect()->route('products.index')->with(['success' => '???? ?????????? ??????????']);
            else:
                return redirect()->route('products.index')->with(['error' => '?????? ???????????? ?????? ??????????']);
            endif;
        } catch (\Exception $ex) {
            return redirect()->route('products.index')->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
        }

    }

}
