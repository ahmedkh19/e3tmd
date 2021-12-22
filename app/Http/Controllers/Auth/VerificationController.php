<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function verify(Request $request)
    {
        if ( ! $request->route("id") || ! $request->route("hash") || ! $request->input("expires") ) {
            return redirect()->route('login')->with(['error' => "Virification URL not valid!"]);
        }
        
        $id = $request->route("id");
        $hash = $request->route("hash");
        $expires = $request->input("expires");
        $signature = $request->input("signature"); // already validated!
        $find_user = User::find($id);
        
        if ( now()->timestamp > $expires ) {
            return redirect()->route('login')->with(['error' => "Expired!"]);
        }
        
        if ( ! $find_user ) {
            return redirect()->route('login')->with(['error' => "Virification URL not valid!"]);
        }
        
        if ( ! hash_equals((string) $hash, sha1($find_user->getEmailForVerification())) ) {
            return redirect()->route('login')->with(['error' => "Virification URL not valid!"]);
        }
        
        if ( $find_user->hasVerifiedEmail() ) {
            return redirect()->route('login');
        }
        
        $find_user->markEmailAsVerified();
        return redirect()->route('login')->with(['success' => "Verified!"]);

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:3,1')->only('verify', 'resend');
    }
}
