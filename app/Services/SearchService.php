<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class SearchService
{
    public function getVaccineStatus(bool $isExitstsData, string|null $scheduledDate): string
    {
        if (! $isExitstsData) {
            return 'Not registered';
        }

        $scheduledDate = $scheduledDate ? Carbon::parse($scheduledDate) : null;
        $currentDate = Carbon::now();

        if ($isExitstsData && ! $scheduledDate) {
            return 'Not scheduled';
        } elseif ($scheduledDate && $scheduledDate->lt($currentDate)) {
            return 'Vaccinated';
        }

        return 'Scheduled';
    }
}
