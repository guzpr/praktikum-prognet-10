<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserNotification extends Notification
{
    use Queueable;

    protected $table = 'user_notification';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transactionBefore,$transactionAfter)
    {
        $this->transactionId = $transactionAfter->id;
        $this->statusBefore = $transactionBefore;
        $this->statusAfter = $transactionAfter->status;
        $this->date = $transactionAfter->created_at;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->transactionId,
            'date' => $this->date,
            'status_before' => $this->statusBefore,
            'status_after' => $this->statusAfter
        ];
    }
}
