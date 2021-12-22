<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Redirect;
use Symfony\Component\Console\Input\Input;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login
    public function showLoginForm(){
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout(); // log the user out of our application
        return redirect()->route('login');
    }
    
    public function resend_verification(Request $request) {
        if ( $request->email && filter_var( $request->email , FILTER_VALIDATE_EMAIL ) ) {
            $user = User::where('email', '=', $request->email)->first();
            if ( $user ) {
                if ( $user->hasVerifiedEmail() ) {
                    return redirect()->route('login');
                }
                $user->sendEmailVerificationNotification();
            }
            return redirect()->route('login')->with(['success' => "Sent if email existed in our database, Check your Email"]);
        } else {
            return redirect()->route('login')->with(['error' => "Email is not Valid"]);
        }
    }

    // Login
    public function doLogin(LoginRequest $request){
        $remember_me = $request->has('remember_me') ? true : false;
        $userdata = array(
            'email'     => $request->email,
            'password'  => $request->password
        );

        // attempt to do the login
        if (Auth::attempt($userdata, $remember_me)) {
            if ( ! Auth::user()->hasVerifiedEmail() ) {
                Auth::logout();
                $resend_url = "/login/resendVerification?email=" . $userdata["email"];
                $error = "Email Not Verified yet, Check Your Email <a href=\"$resend_url\">Resend again</a>";
                return redirect()->route('login')->with(['error' => $error]);
            }
            return redirect()->route('dashboard-ecommerce');
        }
        return redirect()->route('login')->with(['error' => __('data.Login Failed')]);
    }
    
    public function socialite_redirect($service)
    {
        $supported = ['google','twitter','facebook'];
        if ( in_array($service, $supported) ) {
            return Socialite::driver($service)->redirect();
        }
        return redirect(route('home'));
    }

    public function socialite_callback($service)
    {
        $supported = ['google','twitter','facebook'];
        if ( in_array($service, $supported) ) {
            $data = Socialite::driver($service)->stateless()->user();
            if ($data && isset($data->email)) {
                $user = User::where('email', '=', $data->email)->first();
                if ( $user ) { // user exists
                    Auth::login($user);
                    return redirect()->route('dashboard-ecommerce');
                } else { // create user
                    $user = new User();
                    $user->name = $data->name;
                    $user->email = $data->email;
                    $user->avatar = $data->avatar_original;
                    $user->provider = $service; // google, facebook, twitter
                    $user->provider_id = $data->id;
                    $user->roles_name = [];
                    $user->status = 1;
                    $user->save();
                    Auth::login($user);
                    return redirect()->route('dashboard-ecommerce');

                }
            }
        }

    }

}
