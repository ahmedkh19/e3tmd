<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBank;
use App\Models\Withdraw;
use App\Notifications\SendMessageNotificationToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use LaravelLocalization;
use DB;
use Spatie\Permission\Traits\HasRoles;

use App\Http\Controllers\MyFatoorah\SendPayment;
use DataTables;

class PaymentsController extends Controller
{
    use HasRoles;

    public function index()
    {
        return view('content.payments.index');
    }

    public function withdrawRequestsAjax(Request $request)
    {
        if (auth()->user()->hasPermissionTo('withdraw-list')) {

            if ($request->ajax()) {
                $withdraws = Withdraw::orderBy('id', 'DESC')
                    ->where('isRefunded', false)
                    ->where('isCompleted', false)
                ;
                return Datatables::of($withdraws)
                    ->addIndexColumn()
                    ->addColumn('username', function ($row) {
                        return User::find($row->vendor_id)->username;
                    })
                    ->addColumn('action', function ($row) {
                        $showDetails = '<a href="#" onclick="withdrawDetails('.$row->vendor_id.')" data-toggle="modal" data-target="#withdrawDetailsModel" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Show details") . '</a>';
                        $refund = '<a href="' . route('payments.withdrawRefund', $row->id) . '" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Refund") . '</a>';
                        $complete =  '<a href="' . route('payments.withdrawComplete', $row->id) . '" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Complete") . '</a>';
                        return $showDetails . $refund . $complete;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return false;
        } else {
            return 'failed';
        }

    }

    public function transactionsAjax(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasPermissionTo('product-create')) {
                $transactions = Transaction::orderBy('payment_id', 'DESC')->where('vendor_id', auth()->id());
                $vendor = true;
            } else {
                $vendor = false;
                $transactions = Transaction::orderBy('payment_id', 'DESC')->where('customer_id', auth()->id());
            }

            return Datatables::of($transactions)
                ->addColumn('product_name', function ($row) {
                    $product = Product::find($row->product_id);
                    return $product->name;
                })
                ->addColumn('amount', function ($row) use ($vendor) {
                    if ($vendor) {
                        return $row->total_vendor;
                    } else {
                        return $row->total;
                    }
                })
                ->make(true);
        }
        return false;
    }


    public function withdrawDetailsAjax($withdraw_id)
    {
        if (auth()->user()->hasPermissionTo('withdraw-edit')) {

            $withdraw = Withdraw::find($withdraw_id);
            $bank = UserBank::where('user_id', $withdraw->id)->first();
            return response()->json([
                'full_name' => $bank->full_name,
                'bank' => $bank->bank,
                'iban_number' => $bank->iban_number,
            ]);
        } else return false;
    }
    public function withdrawComplete( $id)
    {
        if (auth()->user()->hasPermissionTo('withdraw-edit')) {
            $withdraw = Withdraw::find($id);
            if ($withdraw) {
                try {
                    DB::beginTransaction();
                    $withdraw->isCompleted = true;
                    $withdraw->update();
                    $notification['message'] = __('data.Withdraw amount : ') . $withdraw->amount . currency('rs', false) . " , " . __('data.withdrawn successfully') . '.';
                    $notification['user_id'] = auth()->id();
                    $notification['link'] = route('payments.index');

                    $user = User::find($withdraw->vendor_id);
                    $user->notify(new SendMessageNotificationToUser($notification));

                    DB::commit();
                    return \redirect()->back()->with(['success' => __('data.Updated successfully')]);
                } catch (\Throwable $e) {
                    DB::rollBack();
                    return $e;
                }

            }
        }
    }

    public function withdrawRefund(Request $request, $id)
    {
        if (auth()->user()->hasPermissionTo('withdraw-delete')) {
            $withdraw = Withdraw::find($id);
            if ($withdraw) {
                try {
                    DB::beginTransaction();
                    $withdraw->isRefunded = true;
                    $withdraw->update();
                    AddBalance($withdraw->vendor_id, $withdraw->amount);
                    //Send a notification
                    $notification['message'] = __('data.Withdraw amount : ') . $withdraw->amount . currency('rs', false) . " , " . __('data.was refunded') . ' ' . __('data.please check the bank information then try again.') ;
                    $notification['user_id'] = auth()->id();
                    $notification['link'] = route('payments.index');

                    $user = User::find($withdraw->vendor_id);
                    $user->notify(new SendMessageNotificationToUser($notification));

                    DB::commit();
                    return \redirect()->back()->with(['success' => __('data.Updated successfully')]);
                } catch (\Throwable $e) {
                    DB::rollBack();
                    return $e;
                }

            }
        }  return \redirect()->back()->with(['error' => __('data.You do not have permission to do this action')]);

    }

    public function withdraw(Request $request)
    {
        $amount = $request->withdrawAmount;

        if (!$amount || Setting::getMinWithdrawAmount() > $amount) return \redirect()->back()->with(['error' => __('You have to request at least : ') . Setting::getMinWithdrawAmount() . currency('rs', false)]);

        if (!auth()->user()->hasPermissionTo('withdraw-edit')) return \redirect()->back();

        if ($amount <= auth()->user()->balance) {
            try {
                DB::beginTransaction();
                Withdraw::create([
                    'vendor_id' => auth()->id(),
                    'amount' => $amount,
                ]);
                BalanceDeduction(auth()->id(), $amount);
                DB::commit();
                //Send a notification
                $notification['message'] = __('data.There is a new withdraw request from : ') . auth()->user()->username . " , " . __('data.Withdraw amount : ') . $amount .  currency('rs', false) . '.';
                $notification['user_id'] = auth()->id();
                $notification['link'] = route('payments.index');

                $usersIn = User::permission('withdraw-edit')->get();

                foreach ($usersIn as $user) {
                    if ($user->id != $notification['user_id'])
                        $user->notify(new SendMessageNotificationToUser($notification));
                }

                return \redirect()->back();
            } catch (\Throwable $e) {
                DB::rollBack();
                return $e;
            }
        } else {
            return \redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

        }
    }


    public function send(Request $request)
    {
            $amount = $request->amount;

            if (!$amount || Setting::getMinAmount() > $amount) return \redirect()->back();

//            if (auth()->user()->can('withdraw-create')) return \redirect()->back();
            $postFields = [
                'NotificationOption' => 'Lnk',
                'InvoiceValue'       => $amount,
                'CustomerName'       => auth()->user()->name,
                "DisplayCurrencyIso" => "SAR",
                "Language" => LaravelLocalization::getCurrentLocale(),
                "CallBackUrl" => URL::to('/') . "/successPayment",
                "UserDefinedField" => auth()->id()
            ];
            $sendPayment = new SendPayment();
            $invoiceLink = $sendPayment->index($postFields);
          return Redirect::to($invoiceLink);
    }

    public function success(Request $request)
    {
        try {
            DB::beginTransaction();

            $sendPayment = new SendPayment();
            $status = $sendPayment->status($request->paymentId)[0];
            $amount = $sendPayment->status($request->paymentId)[1];
            $Payment = Payment::where('payment_id' , $request->paymentId)->first();
            if ($status === "Paid" && !$Payment) {
                Payment::create([
                   'user_id' => auth()->id(),
                   'payment_id' => $request->paymentId,
                   'amount' => $amount
                ]);
                AddBalance(auth()->id(),$amount );
                DB::commit();
                 return 'done';
              //  return \redirect()->route('dashboard-ecommerce');
            } else {
                DB::rollBack();
               return 'failed';
              // return \redirect()->route('dashboard-ecommerce');
            }
        }
        catch (\Throwable $e) {
            DB::rollBack();
            return $e;

        }
    }

}
