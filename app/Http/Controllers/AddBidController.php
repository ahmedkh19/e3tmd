<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AddBidController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::check()) {

            $userid = Auth::user()->id;
            $product_id = intval($request->product_id);
            $product = Product::where('id','=',$product_id)
                ->where('pricing_method','=','Auction')
                ->first();
            $bidamount = floatval($request->amount);
            
            if ( $userid && $bidamount && $product ) {
            
                if ( Auth::user()->roles_name[0] != "Member" ) {
                    return redirect()->back()->with('bid_message', 'عذرا لا يمكن اتمام الطلب يرجي فتح حساب عضو والتواصل مع البائعين');
                }

                if ( $product->isSold ) {
                    return redirect()->back()->with('bid_message', 'هذا الحساب تم بيعه');
                }

                if ( date("Y-m-d H:i:s") >= $product->auction_end ) {
                    return redirect()->back()->with('bid_message', 'عفوا تم انتهاء المزاد');
                }
            
                if ( $userid == $product->user_id ) {
                    return redirect()->back()->with('bid_message', 'لا يمكن اضافة سعر لنفسك');
                }

                $price = $product->start_bid_amount;
                $highest_bid = DB::table('bids')
                    ->where("product_id","=",$product_id)
                    ->max('bid_amount');
                
                $highest_price = $highest_bid ? $highest_bid: $price;
                
                if ( $bidamount > $highest_price ) {

                    Bid::create([
                        'product_id' => $product_id,
                        'user_id' => $userid,
                        'bid_amount' => $bidamount,
                    ]);

                    return redirect()->back()->with('bid_message', 'تمت الاضافة بنجاح');
                }
                
                return redirect()->back()->with('bid_message', 'يجب اضافة سعر اعلي');

            }

            return redirect()->back()->with('bid_message', '!عفوا بيانات غير صالحة');

        } else {
            return redirect()->back()->with('bid_message', 'يجب تسجيل الدخول اولا');
        }

    }
}
