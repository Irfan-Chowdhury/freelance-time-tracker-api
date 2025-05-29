<?php

namespace App\Console\Commands;

use App\Jobs\SendVaccineReminderJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReminderEmails extends Command
{
    protected $signature = 'reminder:send';

    protected $description = 'Send reminder emails to vaccine registered users before the night of their upcoming schedule date.';

    public function handle()
    {
        date_default_timezone_set(env('APP_TIMEZONE'));

        $users = User::select('id','name','email','scheduled_date','vaccine_center_id')
                    ->with('vaccineCenter:id,name,address')
                    ->whereDate('scheduled_date', '=', Carbon::tomorrow()->toDateString())
                    ->get();

        foreach ($users as $user) {
            $scheduleDate = $user->scheduled_date;
            $centerName = $user->vaccineCenter->name;
            $centerAddress = $user->vaccineCenter->address;

            dispatch(new SendVaccineReminderJob($user, $scheduleDate, $centerName, $centerAddress));
        }

        $this->info('Successfully sent.');
    }
}
