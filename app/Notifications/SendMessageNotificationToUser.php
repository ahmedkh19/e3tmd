<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessageNotificationToUser extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;
    public $notification;

    /**
     * Create a new notification instance.
     * @param $notification
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database' , 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->notification['message'],
            'link'    => $this->notification['link']
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'message' => $this->notification['message'],
                'link'    => $this->notification['link']
            ]
        ]);
    }
}
