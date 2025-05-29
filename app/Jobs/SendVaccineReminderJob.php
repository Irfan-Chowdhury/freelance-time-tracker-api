<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\VaccineReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVaccineReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $scheduleDate;
    protected $centerName;
    protected $centerAddress;

    public function __construct(User $user, $scheduleDate, $centerName, $centerAddress)
    {
        $this->user = $user;
        $this->scheduleDate = $scheduleDate;
        $this->centerName = $centerName;
        $this->centerAddress = $centerAddress;
    }


    public function handle()
    {
        $this->user->notify(new VaccineReminderNotification($this->user->name, $this->scheduleDate, $this->centerName, $this->centerAddress));
    }
}
