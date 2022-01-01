<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - return owner and vendors orders
  public static function getOrders()
  {
    $user_id = Auth::user()->id;
    $products = Product::where("user_id",$user_id)->select('created_at')->get();
    $count_products = count($products);
    $day1 = $day2 = $day3 = $day4 = $day5 = $day6 = $day7 = 0;
    foreach ( $products as $product ) {
        if ( substr($product->created_at,0,10) == date("Y-m-d") ) {
            $day7 = $day7+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-1 days")) ) {
            $day6 = $day6+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-2 days")) ) {
            $day5 = $day5+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-3 days")) ) {
            $day4 = $day4+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-4 days")) ) {
            $day3 = $day3+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-5 days")) ) {
            $day2 = $day2+1;
        } else if ( substr($product->created_at,0,10) == date('d',strtotime("-6 days")) ) {
            $day1 = $day1+1;
        }
    }
    $products_week = array($day1,$day2,$day3,$day4,$day5,$day6,$day7);
    return array($count_products,$products_week);
  }

  public static function Revenue() {
    $user_id = Auth::user()->id;
    $this_month = date("Y-m");
    $transactions_this_month = Transaction::where("vendor_id",$user_id)
        ->where("created_at","LIKE","$this_month%")
        ->select('created_at', 'total_vendor')
        ->get();
    $last_month = date("Y-m",strtotime("-1 months"));
    $transactions_last_month = Transaction::where("vendor_id",$user_id)
        ->where("created_at","LIKE","$last_month%")
        ->select('created_at', 'total_vendor')
        ->get();
    
    $revenue_this_month = 0;
    $revenue_this_month_data = array(0,0,0,0,0,0,0,0);
    $revenue_last_month = 0;
    $revenue_last_month_data = array(0,0,0,0,0,0,0,0);
    foreach ($transactions_this_month as $transaction) {
        $revenue_this_month += $transaction["total_vendor"];
        if ( in_array( substr($transaction["created_at"],8,2), array("01","02","03","04") ) ) {
            $revenue_this_month_data[0] = $revenue_this_month_data[0] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("05","06","07","08") ) ) {
            $revenue_this_month_data[1] = $revenue_this_month_data[1] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("09","10","11","12") ) ) {
            $revenue_this_month_data[2] = $revenue_this_month_data[2] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("13","14","15","16") ) ) {
            $revenue_this_month_data[3] = $revenue_this_month_data[3] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("17","18","19","20") ) ) {
            $revenue_this_month_data[4] = $revenue_this_month_data[4] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("21","22","23","24") ) ) {
            $revenue_this_month_data[5] = $revenue_this_month_data[5] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("25","26","27","28") ) ) {
            $revenue_this_month_data[6] = $revenue_this_month_data[6] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("29","30","31") ) ) {
            $revenue_this_month_data[7] = $revenue_this_month_data[7] + $transaction["total_vendor"];
        }
    }
    foreach ($transactions_last_month as $transaction) {
        $revenue_last_month += $transaction["total_vendor"];
        if ( in_array( substr($transaction["created_at"],8,2), array("01","02","03","04") ) ) {
            $revenue_last_month_data[0] = $revenue_last_month_data[0] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("05","06","07","08") ) ) {
            $revenue_last_month_data[1] = $revenue_last_month_data[1] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("09","10","11","12") ) ) {
            $revenue_last_month_data[2] = $revenue_last_month_data[2] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("13","14","15","16") ) ) {
            $revenue_last_month_data[3] = $revenue_last_month_data[3] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("17","18","19","20") ) ) {
            $revenue_last_month_data[4] = $revenue_last_month_data[4] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("21","22","23","24") ) ) {
            $revenue_last_month_data[5] = $revenue_last_month_data[5] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("25","26","27","28") ) ) {
            $revenue_last_month_data[6] = $revenue_last_month_data[6] + $transaction["total_vendor"];
        } else if ( in_array( substr($transaction["created_at"],8,2), array("29","30","31") ) ) {
            $revenue_last_month_data[7] = $revenue_last_month_data[7] + $transaction["total_vendor"];
        }
    }
    
    $getallRevenue = Transaction::where("vendor_id",$user_id)->select('total_vendor')->get();
    $allRevenue = 0;
    foreach($getallRevenue as $getoneRevenue) {
        $allRevenue += $getoneRevenue["total_vendor"];
    }
    
    return array($revenue_this_month,$revenue_last_month,$revenue_this_month_data,$revenue_last_month_data,$allRevenue);
  }
  
  public static function sales() {
    $user_id = Auth::user()->id;
    $this_month = date("Y-m");
    return Product::where("user_id",$user_id)
        ->where('isSold', "=", "1")
        ->count();
  }

}
