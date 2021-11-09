<?php

namespace App\Http\Livewire\Conversations;

use App\Events\Conversations\ConversationUpdated;
use App\Events\Conversations\MessageAdded;
use App\Events\Notifications\NotificationEvent;
use App\Http\Livewire\Notifications\Notifications;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\SendMessageNotificationToUser;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConversationReply extends Component
{

    use WithFileUploads;

    public $body = '';
    public $attachment = '';
    public $attachment_name = '';
    public $conversation_id;
    public $conversation;

    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
        $this->conversation_id = $conversation->id;
    }

    protected $rules = [
        'body' => 'required',
        'attachment' => 'nullable|file|mimes:png,jpg,jpeg,gif,wav,mp3,mp4|max:102400',
    ];

    public function reply()
    {

        $this->validate();

        if ($this->attachment != '') {
            $this->attachment_name = md5($this->attachment . microtime()) . '.' . $this->attachment->extension();
            $this->attachment->storeAs('/', $this->attachment_name, 'media');
            $data['attachment'] = $this->attachment_name;
        }
        $data['body'] = $this->body;
        $data['conversation_id'] = $this->conversation_id;
        $data['user_id'] = auth()->id();
        $message = Message::create($data);
        $this->conversation->update([
            'last_message_at' => now(),
        ]);

        foreach ($this->conversation->others as $user) {
            $user->conversations()->updateExistingPivot($this->conversation, [
                'read_at' => null
            ]);
        }

        broadcast(new MessageAdded($message))->toOthers();
        broadcast(new ConversationUpdated($message->conversation));
        //Notification
        $usersIn = $this->conversation->users()->get();
        $notification['message'] = __('data.You have received a new message from') . $this->conversation->name . " , " . __('data.Please check it');
        $notification['user_id'] = $data['user_id'];
        $notification['link'] = route('chat.show', $this->conversation->uuid);
        foreach ($usersIn as $user) {
            if ($user->id != $message->user_id)
            $user->notify(new SendMessageNotificationToUser($notification));
        }

        $this->emit('message.created', $message->id);

        $this->body = '';
        $this->attachment = '';
        $this->attachment_name = '';


    }

    public function render()
    {
        return view('livewire.conversations.conversation-reply');
    }
}
