<?php

use App\Models\PasswordEncryption;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Notifications\SendMessageNotificationToUser;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\UserController;
use App\Mail\Contact;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Get child categories for the parent
 * ID = The parent id
 */

Route::get('sub_categories/{id}', function($ids) {
    $array = [];
    $ids = explode(",", $ids);
    foreach ($ids as $id) {
        $x = (new App\Models\Category)->getSubCategories($id);
        foreach ($x as $y) {
            unset($y->created_at);
            unset($y->updated_at);
            unset($y->is_active);
            $array[] = $y;
        }
    }
    return $array;
    return (new App\Models\Category)->getSubCategories($ids[0]);
});

/*
 * USER SEARCH AUTH
 */
Route::group(['middleware' => ['auth']], function () {

    Route::get('/search-users/{search}', function ($search) {
        return User::select('id', 'username', 'email')
            ->where('username', 'LIKE', "$search%")->get();
    });

});

/*
 * Create Payment API
 * Status *
 * 200 : Payment Success
 * 300 : Balance is not enough
 * 500 : Undefined error
 */
Route::get('create_payment/{customer_id},{vendor_id},{product_id},{total}', function($customer_id , $vendor_id , $product_id , $total) {
    try {
        $EncryptionClass = new PasswordEncryption();
        // Decrypt
        $customer_id = $EncryptionClass->decryptAES($customer_id, env('AES_ENCRYPTION_KEY'));
        $vendor_id = $EncryptionClass->decryptAES($vendor_id, env('AES_ENCRYPTION_KEY'));
        $product_id = $EncryptionClass->decryptAES($product_id, env('AES_ENCRYPTION_KEY'));
        $total = $EncryptionClass->decryptAES($total, env('AES_ENCRYPTION_KEY'));

        if ( Product::find($product_id) && User::find($vendor_id) ) {
            $payment = new Transaction();
            $payment->customer_id = $customer_id;
            $payment->vendor_id = $vendor_id;
            $payment->product_id = $product_id;
            $payment->total = $total;
            //Get Commission
            $commission = Setting::getCommission();
            $commission /= 100;
            $total_vendor = (float) ($total - ($total * $commission) );
            $payment->total_vendor = $total_vendor;
            //Optional

            $product = Product::find($product_id);
            $product->isSold = true;
            $product->update();
            if ( $payment->save() ) {
                if (BalanceDeduction($customer_id, $total)) {
                    $notification['message'] =  __('data.Congratulations, your account has been purchased') . '(' . $product->slug . ') .' . __('data.Total price') . $total_vendor;
                    $notification['user_id'] = $vendor_id;
                    $notification['link'] = '';
                    $user = User::find($vendor_id);
                    $user->notify(new SendMessageNotificationToUser($notification));
                    return Response::json(['status' => 200, 'error' => false], 200);
                } else {
                    return Response::json(['status' => 300, 'error' => true], 300);
                }
            } else {
                return Response::json(['status' => 500, 'error' => true], 500);
            }
        } else return Response::json(['status' => 500, 'error' => true], 500);
    } catch(\Exception $ex) {
        return Response::json(['status' => 500, 'error' => true], 500);
    }


});

Route::post('get_accounts', [ShopController::class, 'get_accounts']);

Route::post('get_user_accounts', [UserController::class, 'paginate_accounts']);

Route::middleware('throttle:1,1440' /* one in a day */)->post('/contact', function( Request $request ) {

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:100',
        'email' => 'required|email',
        'subject' => 'required|max:100',
        'message' => 'required|max:100',
    ]);
    
    if ($validator->fails()) {
        return response()->json(['error' => $validator->messages()], 200);
    }

    $to = 'test@gmail.com';
    
    Mail::to($to)->send(new Contact($request->all()));
    
    return response()->json(['response' => "sent"], 200);

})->name('contact_us');
