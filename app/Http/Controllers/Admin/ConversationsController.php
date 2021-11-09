<?php

namespace App\Http\Controllers\Admin;

use App\Events\Conversations\ConversationUpdated;
use App\Events\Conversations\UserAdded;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\PasswordEncryption;
use App\Models\Product;
use App\Models\User;
use App\Notifications\SendMessageNotificationToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConversationsController extends Controller
{
    public function index(Request $request)
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'chat-application',
        ];

        $conversations = $request->user()->conversations;
        return view('/content/chat/index', [
            'pageConfigs' => $pageConfigs
        ], compact('conversations'));
    }

    public function show(Conversation $conversation, Request $request)
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'chat-application',
        ];

        $this->authorize('show', $conversation);
        $conversations = $request->user()->conversations;

        return view('/content/chat/show', [
            'pageConfigs' => $pageConfigs
        ], compact(['conversations', 'conversation']));
    }

    // Soon
    public function create($product_id)
    {
        $EncryptionClass = new PasswordEncryption();
        $product_id = $EncryptionClass->decryptAES($product_id, env('AES_ENCRYPTION_KEY'));
        if (!$product_id) return false;
        $product = Product::find($product_id);
        if (!$product) return false;
        $user_id = auth()->id();
        $to_id = $product->user_id; // to user
        if ($user_id == $to_id) return false;
       $conversation_2 = Conversation::where('user_id' , $user_id)->where('product_id', $product_id)->first();
        if ($conversation_2) {
            return redirect()->route('chat.show', $conversation_2);
        }
        $name = $product->name;
        if (empty($name)) $name = 'test';
        if (strlen($name) > 25) {
           $name = mb_substr($product->name, 0, 25, 'utf-8') . "...";
        }
        $conversation = Conversation::create([
            "name" => $name,
            'uuid' => Str::uuid(),
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);

        $conversation->users()->sync([$to_id, $user_id]);

        return redirect()->route('chat.show', $conversation);
    }

    public function confirmAccountData($id)
    {

        try {
                $conversation = Conversation::find($id);
                $product = Product::find($conversation->product->id);
                if (!$product || !$conversation)
                    return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
                $conversation->isAccountConfirmed = true;
                $conversation->update();

                //Send a notification
                $notification['message'] = __('data.The Middleman has confirmed the account details') . $conversation->name . ".";
                $notification['user_id'] = auth()->id();
                $notification['link'] = route('chat.show', $conversation->uuid);
            $usersIn = $conversation->users()->get();
            foreach ($usersIn as $user) {
                if ($user->id != $notification['user_id'])
                    $user->notify(new SendMessageNotificationToUser($notification));
            }
                return redirect()->back()->with(['success' => __('data.Updated successfully')]);


        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later ') . $ex]);

        }
    }

    public function rejectAccountData($id)
    {

        try {
            $conversation = Conversation::find($id);
            $product = Product::find($conversation->product->id);
            if (!$product || !$conversation)
                return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
            $conversation->isAccountConfirmed = false;
            $conversation->update();

            //Send a notification
            $notification['message'] = __('data.The Middleman has rejected the account details') . $conversation->name . " , " . __('data.Try to confirm the account again');
            $notification['user_id'] = auth()->id();
            $notification['link'] = route('chat.show', $conversation->uuid);
            $usersIn = $conversation->users()->get();
            foreach ($usersIn as $user) {
                if ($user->id != $notification['user_id'])
                    $user->notify(new SendMessageNotificationToUser($notification));
            }
            return redirect()->back()->with(['success' => __('data.Updated successfully')]);


        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later ') . $ex]);

        }
    }

    //Without a middleman
    public function updateAccountData($id, Request $request)
    {

        try {
            if ( $request->validate([
                'account_email' => 'required|email',
                'account_password' => 'required',
                'account_confirm_password' => 'required|same:account_password',
                'account_username' => 'required',
                'account_email_website' => 'required',
            ]) ) {
                $conversation = Conversation::find($id);
                $product = Product::find($conversation->product->id);
                if (!$product || !$conversation)
                    return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

                $product->account_email = $request->account_email;

                $EncryptionClass = new PasswordEncryption();
                if (!empty($request->account_password))
                    $product->account_password = $EncryptionClass->encryptAES($request->account_password, env('AES_ENCRYPTION_KEY'));

                $product->account_username = $request->account_username;
                $product->account_email_website = $request->account_email_website;
                $product->update(['slug' => 'test2']);

                //Notification
                $usersIn = $conversation->users()->get();
                $notification['message'] = __('data.The seller has confirmed the account details') . $conversation->name . ".";
                $notification['user_id'] = auth()->id();
                $notification['link'] = route('chat.show', $conversation->uuid);
                foreach ($usersIn as $user) {
                    if ($user->id != $notification['user_id'])
                        $user->notify(new SendMessageNotificationToUser($notification));
                }
                return redirect()->back()->with(['success' => __('data.Updated successfully')]);

            }
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

        }
    }
    //With a middleman
    public function updateAccountData2($id, Request $request)
    {

        try {
            if ( $request->validate([
                'account_email' => 'required|email',
                'account_password' => 'required',
                'account_username' => 'required',
                'account_email_website' => 'required',
            ]) ) {
                $conversation = Conversation::find($id);
                $product = Product::find($conversation->product->id);
                if (!$product || !$conversation)
                    return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

                $product->account_email = $request->account_email;

                $EncryptionClass = new PasswordEncryption();
                if (!empty($request->account_password))
                    $product->account_password = $EncryptionClass->encryptAES($request->account_password, env('AES_ENCRYPTION_KEY'));

                $product->account_username = $request->account_username;
                $product->account_email_website = $request->account_email_website;
                $product->update(['slug' => 'test2']);

                //Notification
                $usersIn = $conversation->users()->get();
                $notification['message'] = __('data.The seller has confirmed the account details') . $conversation->name . ".";
                $notification['user_id'] = auth()->id();
                $notification['link'] = route('chat.show', $conversation->uuid);
                foreach ($usersIn as $user) {
                    if ($user->id != auth()->id())
                        $user->notify(new SendMessageNotificationToUser($notification));
                }
                return redirect()->back()->with(['success' => __('data.Updated successfully')]);

            }
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);

        }
    }

    public function join($conversation_uuid)
    {
        $conv = Conversation::where('uuid', '=', $conversation_uuid)->first();
        $num = $conv->users->count();

        if ($num <= 2) {
            $user = auth()->user();
            if ($user->can('middleman-list')) {
                $conv->users()->syncWithoutDetaching($user->id);

                $conv->users->push(User::find(auth()->id()));

                broadcast(new UserAdded($conv, User::find(auth()->id())))->toOthers();
                broadcast(new ConversationUpdated($conv));

                //Notify other users , that the middleman has joined successfully
                $conv_users = $conv->users()->get();
                $notification['message'] = __('data.The Middleman has successfully joined') . $conv->name . " !";
                $notification['user_id'] = auth()->id();
                $notification['link'] = '';
                foreach ($conv_users as $user ) {
                    if ($user->id != auth()->id())
                    $user->notify(new SendMessageNotificationToUser($notification));
                }

                return redirect()->route('chat.show', $conv->uuid);
            }
        }
            return redirect()->back()->with(['error', __('data.A Middleman has already entered')]);

    }

    public function middleman($conversation_uuid)
    {
        $conv = Conversation::where('uuid', '=', $conversation_uuid)->first();
        $num = $conv->users->count();
      if ($num <= 2) {
          //$users= User::whereHas("roles", function($q){ $q->where("name", "Middleman"); })->get();
          // User::role(['admin' , 'writer'])->get();
         $users = User::permission('middleman-list')->get();
          $notification['message'] = __('data.You have received an invitation from') . $conv->name . " , " . __('data.Please check it');
          $notification['user_id'] = auth()->id();
          $notification['link'] = route('chat.join', $conv->uuid);
          foreach ($users as $user ) {
              $user->notify(new SendMessageNotificationToUser($notification));
          }
          $conv->middleman_invited = true;
          $conv->update();
          return redirect()->back()->with(['success', __('data.Send successfully')]);

      }
        return redirect()->back()->with(['error', __('data.An error occurred, please try again later')]);

    }
}
