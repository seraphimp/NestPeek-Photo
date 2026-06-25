<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use Illuminate\Notifications\Notification;

class StudioNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $type;
    protected $data;
    protected $studio;

    public function __construct($type, $data, $studio)
    {
        $this->type = $type;
        $this->data = $data;
        $this->studio = $studio;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'studio_id' => $this->studio->id,
            'studio_name' => $this->studio->name,
            'data' => $this->data,
            'message' => $this->getMessage(),
            'action_url' => $this->getActionUrl(),
            'icon' => $this->getIcon(),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->getMessage())
            ->action('View Studio', $this->getActionUrl())
            ->line('Thank you for using NestPeek Photo!');
    }

    protected function getMessage()
    {
        return match($this->type) {
            'member_added' => "You've been added to the studio '{$this->studio->name}' as a {$this->data['role']}.",
            'member_invited' => "You've been invited to join '{$this->studio->name}'.",
            'studio_created' => "Your studio '{$this->studio->name}' has been created successfully!",
            'booking_created' => "New booking received for '{$this->studio->name}' from {$this->data['client_name'] ?? 'a client'}.",
            'booking_confirmed' => "Booking confirmed for '{$this->studio->name}'.",
            'booking_cancelled' => "Booking cancelled for '{$this->studio->name}'.",
            'member_removed' => "You've been removed from '{$this->studio->name}'.",
            'role_changed' => "Your role in '{$this->studio->name}' has been changed to {$this->data['role']}.",
            default => "Update from '{$this->studio->name}'",
        };
    }

    protected function getSubject()
    {
        return 'Studio Update: ' . $this->studio->name;
    }

    protected function getActionUrl()
    {
        return route('studios.show', $this->studio);
    }

    protected function getIcon()
    {
        return match($this->type) {
            'member_added', 'member_invited' => '👤',
            'studio_created' => '🏢',
            'booking_created' => '📅',
            'booking_confirmed' => '✅',
            'booking_cancelled' => '❌',
            'member_removed' => '🚫',
            'role_changed' => '🔄',
            default => '🔔',
        };
    }
}