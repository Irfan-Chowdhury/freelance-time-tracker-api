<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyHoursExceededNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    protected $date;
    protected $hours;

    public function __construct($date, $hours)
    {
        $this->date = $date;
        $this->hours = $hours;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⏱️ Daily Hours Limit Exceeded')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("You have logged {$this->hours} hours on {$this->date}.")
            ->line("This exceeds your 8-hour daily work limit.")
            ->line('Consider taking a break or adjusting your workload.')
            ->salutation('– Freelance Time Tracker');
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
