<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;

class Notifications extends Component
{
    public $unReadNotificationsCount = '';
    public $unReadNotifications;

    public function getListeners()
    {
        $userId = auth()->id();
        return [
            "echo-notification:App.Models.User.{$userId},notification" => 'mount',
            'refreshComponent' => 'mount'
        ];
    }

    public function mount()
    {
        $user = auth()->user();
        $this->unReadNotificationsCount = $user->unreadNotifications->count();
        $this->unReadNotifications = $user->unreadNotifications;
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications->where('id', $id);
        $notification->markAsRead();
        $this->emit('refreshComponent');

    }
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->emit('refreshComponent');
    }
    public function render()
    {
        return view('livewire.notifications.notifications');
    }
}
