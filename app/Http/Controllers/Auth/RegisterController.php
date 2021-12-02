<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'username' => 'required|string|alpha_dash|max:255|unique:users,username',
                'mobile' => 'required|unique:users,mobile|phone:country',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ],
            [
                'name.required'    => __('data.The name is required'),
                'email.unique'      => __('data.Sorry, This Email Address Is Already Used By Another User. Please Try With Different One, Thank You'),
                'password.required' => __('data.Password Is Required For Your Information Safety, Thank You'),
                'mobile.required' => __('data.Please Provide Your phone number For Better Communication, Thank You'),
                'mobile.unique' => __('data.Sorry, This Phone Number Is Already Used By Another User. Please Try With Different One, Thank You'),
            ]
        );
        // return $request;
        try {
            $Role = 'Member';
            $user = New User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->status = 1; // Active
            $user->mobile = $request->mobile; // Active
            $user->roles_name = [$Role];
            $user->save();


            $user->assignRole($Role);
            return redirect()->route('login')
                ->with('success', 'User created successfully');
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with('error', __('data.An error occurred, please try again later:' . $ex));
        }
    }


    // Register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
