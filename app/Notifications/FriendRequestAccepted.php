<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestAccepted extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // You can add 'database' or 'mail' depending on your preference
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your friend request has been accepted!')
            ->action('View Friends', url('/friends'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your friend request has been accepted!',
            'action_url' => url('/friends'),
        ];
    }
}
