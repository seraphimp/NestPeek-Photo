<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmedNotification extends Notification implements ShouldQueue, ShouldBroadcast
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
        return [
            'type' => 'booking_confirmed',
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'message' => "Your booking #{$this->booking->booking_number} has been confirmed!",
            'action_url' => route('bookings.show', $this->booking),
            'icon' => '✅',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Confirmed - #' . $this->booking->booking_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your booking has been confirmed.')
            ->line('Booking #: ' . $this->booking->booking_number)
            ->line('Event Date: ' . $this->booking->event_date->format('F j, Y'))
            ->action('View Booking', route('bookings.show', $this->booking))
            ->line('Thank you for using NestPeek Photo!');
    }
}
