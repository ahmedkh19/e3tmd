<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserComments;
use App\Models\Product;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index($username)
    {
        $user = User::where("username","=",$username)->first();
        if ($user) {
            if ($user->avatar) {
                $user->avatar = URL('/uploads/images/avatars/'. $user->avatar );
            } else {
                $user->avatar = URL('/uploads/images/avatars/user.jpg');
            }
            if ($user->cover) {
                $user->background_url = URL('/uploads/images/avatars/'. $user->cover );
            } else {
                $user->background_url = asset('front/assets/img/bg/bg_a.jpg');
            }
            $user->information = UserInformation::where("user_id","=",$user->id)->first();
            
            $comments = UserComments::where("to","=",$user->id)->limit(20)->get();
            
            $cancomment = true;
            if (!\Auth::check()) {
                $cancomment = false;
            }
            if ($cancomment && \Auth::user()->id == $user->id) {
                $cancomment = false;
            }
            if ($cancomment && UserComments::where("commenter_id","=",\Auth::user()->id)->where("to","=",$user->id)->first()) {
                $cancomment = false;
            }
            
            $accounts_count = Product::where("user_id","=",$user->id)->count();
            
            $accounts = Product::where("user_id","=",$user->id)->limit(10)->get();

            return view("front.user")
                ->with("user",$user)
                ->with("cancomment", $cancomment)
                ->with("accounts", $accounts)
                ->with("accounts_count", $accounts_count)
                ->with("comments",$comments);
        } else {
            return abort(404);
        }
    }
    
    public function comment(Request $request, $userid)
    {
        if (\Auth::check()) {
            if (!User::where("id","=",$userid)->first()) {
                return \Redirect::back()->with(['error_comment' => 'this user does not exsists']);
            }
            if (\Auth::user()->id == $userid) {
                return \Redirect::back()->with(['error_comment' => 'You cant comment to yourself']);
            }
            if (UserComments::where("commenter_id","=",\Auth::user()->id)->where("to","=",$userid)->first()) {
                return \Redirect::back()->with(['error_comment' => 'Sorry, You Commented Before']);
            }
            if (!$request->message) {
                return \Redirect::back()->with(['error_comment' => 'Bad Comment']);
            }
            UserComments::create([
                'to' => $userid,
                'comment' => $request->message,
                'commenter_id' => \Auth::user()->id,
            ]);
            return \Redirect::back()->with(['success_comment' => 'Comment Added']);
        } else {
            return \Redirect::back()->with(['error_comment' => 'You must login first']);
        }
    }

    public function paginate_accounts(Request $request)
    {   
        if ($request->locale == 'ar') {
            \App::setLocale('ar');
        }
        $data = [];
        if ($request->user && intval($request->clicked) && User::where("username","=",$request->user)->first() ) {
            $user = User::where("username","=",$request->user)->first();
            $query = Product::where("user_id","=",$user->id)->skip(($request->clicked*10)-10)->limit(10)->get();
            foreach ($query as $account) {
                $hold = [];
                $hold['name'] = $account->name;
                $hold['main_image'] = $account->main_image;
                $hold['slug'] = $account->slug;
                $hold['os'] = '';
                if ($account->os) {
                    if(Str::contains($account->os,'x')) {
                        $hold['os'] .= '<i class="fab fa-xbox"></i>';
                    }
                    if(Str::contains($account->os,'p')) {
                        $hold['os'] .= '<i class="fab fa-playstation"></i>';
                    }
                    if(Str::contains($account->os,'s')) {
                        $hold['os'] .= '<i class="fa fa-mobile"></i>';
                    }
                }
                $hold['viewed'] = $account->viewed;
                $hold['price'] = $account->price ? $account->price . currency( $account->currency,false): $account->start_bid_amount . currency( $account->currency,false);
                $hold['auction_end'] = $account->auction_end ? substr(str_replace("T"," ",$account->auction_end),0,16): false;
                $hold['categories'] = '';
                foreach ($account->categories as $category) {
                    $hold['categories'] .= ', ' . $category->name;
                }
                if ($hold['categories']) {
                    $hold['categories'] = substr($hold['categories'],2);
                }
                $data[] = $hold;
            }
        }
        return $data;
    }
}
