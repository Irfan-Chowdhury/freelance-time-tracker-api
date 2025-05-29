<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Http\Resources\VaccineCenterResource;
use App\Models\User;
use App\Models\VaccinationSchedule;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VaccineService
{
    public function getAllVaccineCenterData()
    {
        $vaccineCenters = Cache::remember('vaccineCenters', 3600, function () {
            return VaccineCenter::select('id', 'name', 'address', 'daily_limit')->paginate(20);
        });

        return VaccineCenterResource::collection($vaccineCenters); //Option-1 to get all data
    }

    public function getAllUsers()
    {
        $users = Cache::remember('getAllUsers', 3600, function () {
            return User::select('id', 'nid', 'name', 'email', 'gender', 'scheduled_date', 'vaccine_status')->get();
        });

        return new UserCollection($users); //Option-2 to get all data
    }

    public function getNextAvailableDate(string $lastScheduleDate)
    {
        $date = Carbon::parse($lastScheduleDate);
        $nextDate = $date->addDay()->toDateString();

        if ($date->isFriday() || $date->isSaturday()) {
            // Move to the next Sunday
            $nextDate = $date->next(Carbon::SUNDAY)->toDateString();
        }

        return $nextDate;
    }

    public function getScheduleDate(int $vaccineCenterId): string|null
    {
        $vaccinationSchedules = VaccinationSchedule::select('scheduled_date', 'users_count')->where('vaccine_center_id', $vaccineCenterId);

        $singleVaccineCenter = VaccineCenter::find($vaccineCenterId);

        $scheduledDate = null;
        foreach ($vaccinationSchedules->get() as $item) {
            if ($item->users_count < $singleVaccineCenter->daily_limit) {
                $scheduledDate = $item->scheduled_date;
                break;
            }
        }

        if (!$scheduledDate) {
            $lastVaccinationSchedule = $vaccinationSchedules->latest()->first();
            if(!$lastVaccinationSchedule) {
                return null;
            }
            $lastScheduledDate = $lastVaccinationSchedule->scheduled_date;
            $scheduledDate = self::getNextAvailableDate($lastScheduledDate);
        }

        return $scheduledDate;
    }

    public function registrationProcess(object $request)
    {
        $data = $request->validated();

        $data['scheduled_date'] = $this->getScheduleDate($request->vaccine_center_id);
        $data['vaccine_status'] = 'Scheduled';

        User::create($data);

        VaccinationSchedule::updateOrCreate(
            [
                'vaccine_center_id' => $data['vaccine_center_id'],
                'scheduled_date' => $data['scheduled_date'],
            ],
            [
                'users_count' => DB::raw('users_count + 1'),
            ]
        );
    }

    public function vaccineStoreProcess(object $request): void
    {
        VaccineCenter::create($request->validated());
    }

    public function vaccineCenterShow($id)
    {
        $vaccineCenter =  VaccineCenter::findOrFail($id);

        return new VaccineCenterResource($vaccineCenter); //Option-1 to get all data
    }

    public function vaccineCenterUpdate($request, $id)
    {
        $vaccineCenter =  VaccineCenter::findOrFail($id);

        $vaccineCenter->name = $request->name;
        $vaccineCenter->address = $request->address;
        $vaccineCenter->daily_limit = $request->daily_limit;

        return $vaccineCenter;
    }

    public function vaccineCenterDestroy($id): void
    {
        $vaccineCenter =  VaccineCenter::findOrFail($id);

        $vaccineCenter->delete();
    }
}
