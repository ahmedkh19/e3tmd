<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendMessageNotificationToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SendNotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:send_notification-send', ['only' => ['sendNotification','store']]);
    }

    public function sendNotification()
    {
        $users = User::where('status', 1)->get();
        return view('content.notifications.send', compact('users'));
    }

    public function store(Request $request)
    {

        try {
            //Get the user string value and change it to an array
            $users = explode(',',$request->final_users);
            array_pop($users);
            //
            $request->validate([
                'message' => 'required',
            ]);
            $notification['message'] = $request->message;
            $notification['link'] = $request->link;
            $notification['user_id'] = '1';
            foreach ($users as $user) {
                $user = User::find($user);
                $user->notify( new SendMessageNotificationToUser($notification) );
            }
            return redirect()->back()->with(['success' => __('data.Send successfully')]);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
        }

    }

}
