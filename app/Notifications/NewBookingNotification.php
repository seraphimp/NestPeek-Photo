<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class NewBookingNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function toDatabase($notifiable)
    {
        $studioName = $this->booking->studio ? $this->booking->studio->name : 'Your Service';

        return [
            'type' => 'new_booking',
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'client_name' => $this->booking->client->name ?? 'Client',
            'studio_name' => $studioName,
            'message' => "New booking request #{$this->booking->booking_number} from {$this->booking->client->name}",
            'action_url' => route('bookings.show', $this->booking),
            'icon' => '📅',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Booking Request - #' . $this->booking->booking_number)
            ->greeting('Hello!')
            ->line('You have a new booking request.')
            ->line('Client: ' . $this->booking->client->name)
            ->line('Event Date: ' . $this->booking->event_date->format('F j, Y'))
            ->line('Booking #: ' . $this->booking->booking_number)
            ->action('View Booking', route('bookings.show', $this->booking))
            ->line('Thank you for using NestPeek Photo!');
    }
}
