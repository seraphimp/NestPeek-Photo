<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public $notifications;
    public $unreadCount;

    protected $listeners = ['refreshNotifications' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->notifications = Auth::user()
                ->notifications()
                ->limit(10)
                ->get();

            $this->unreadCount = Auth::user()
                ->unreadNotifications()
                ->count();
        }
    }

    public function markAsRead($notificationId)
    {
        if (Auth::check()) {
            $notification = Auth::user()
                ->notifications()
                ->find($notificationId);

            if ($notification) {
                $notification->markAsRead();
            }
        }

        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()
                ->unreadNotifications()
                ->update(['read_at' => now()]);
        }

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-dropdown');
    }
}
