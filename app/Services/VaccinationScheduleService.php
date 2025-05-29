<?php

namespace App\Services;

use App\Models\VaccineCenter;
use Carbon\Carbon;

class VaccinationScheduleService
{
    public function schedules(): array
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays(30);
        $vaccineCenter = VaccineCenter::get()->pluck('id')->toArray();
        $data = [];

        if ($vaccineCenter) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Skip Fridays and Saturdays
                if (! $date->isFriday() && ! $date->isSaturday()) {
                    // Insert schedule for each vaccine center with an initial users_count of 0
                    for ($centerId = $vaccineCenter[0]; $centerId <= end($vaccineCenter); $centerId++) {
                        $data[] = [
                            'vaccine_center_id' => $centerId,
                            'scheduled_date' => $date->toDateString(),
                            'users_count' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                }
            }
        }

        return $data;
    }
}
