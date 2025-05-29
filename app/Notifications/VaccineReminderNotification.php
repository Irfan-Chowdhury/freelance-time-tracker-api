<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccineReminderNotification extends Notification
{
    use Queueable;

    protected $patientName;
    protected $scheduleDate;
    protected $centerName;
    protected $centerAddress;

    public function __construct($patientName, $scheduleDate, $centerName, $centerAddress)
    {

        $this->patientName = $patientName;
        $this->scheduleDate = Carbon::parse($scheduleDate);
        $this->centerName = $centerName;
        $this->centerAddress = $centerAddress;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Vaccine Reminder Notification')
                    ->greeting('Dear ' . $this->patientName)
                    ->line("This is a reminder for your COVID-19 vaccine scheduled on ". $this->scheduleDate->format('l, F j, Y') ." at $this->centerName in $this->centerAddress.")
                    ->line('Please visit your assigned vaccine center on time.')
                    ->line('Thank you for registering for the COVID-19 vaccination.')
                    ->salutation('Regards,')
                    ->salutation('COVID-19 Vaccination Program Team');
    }
}
