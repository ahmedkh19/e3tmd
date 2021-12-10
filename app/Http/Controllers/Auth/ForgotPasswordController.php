<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;



class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    public function showLinkRequestForm( Request $request ) {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));


      return redirect()->route('login')
      ->with("from_forgot_password","اذا كان هناك حساب ممثال لما تم ادخاله فقد ارسلنا اليك رسالة باعادة تعيين كلمة السر");

    }
}
