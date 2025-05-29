<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VaccineRegistrationRequest;
use App\Services\VaccineService;
use App\Services\VaccinationScheduleService;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VaccineRegistrationController extends Controller
{
    use MessageTrait;

    // public function create(VaccineService $vaccineService, VaccinationScheduleService $vaccinationScheduleService)
    // {
    //     $vaccinationScheduleService->schedules();

    //     $vaccineCenters = Cache::remember('vaccineCenters', 3600, function () use ($vaccineService) {
    //         return $vaccineService->getAllVaccineCenterData();
    //     });

    //     return view('pages.registration.create', compact('vaccineCenters'));
    // }


    // public function store(Request $request, VaccineService $vaccineService)
    public function store(VaccineRegistrationRequest $request, VaccineService $vaccineService)
    {
        DB::beginTransaction();
        try {

            $vaccineService->registrationProcess($request);

            DB::commit();

            return response()->json('Successfully Data Saved');

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
