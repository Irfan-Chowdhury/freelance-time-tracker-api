<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VaccineCenter\UpdateRequest;
use App\Http\Requests\VaccineCenter\StoreRequest;
use App\Models\VaccineCenter;
use App\Services\VaccineService;
use Exception;
use Illuminate\Support\Facades\DB;

class VaccineCenterController extends Controller
{
    public function index(VaccineService $vaccineService)
    {
        return $this->sendResponse($vaccineService->getAllVaccineCenterData());
    }


    public function store(StoreRequest $request, VaccineService $vaccineService)
    {
        DB::beginTransaction();
        try {

            $vaccineService->vaccineStoreProcess($request);

            DB::commit();

            return $this->sendResponse(null, 'Successfully Data Saved');

        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    public function show(VaccineService $vaccineService, $id)
    {

        DB::beginTransaction();
        try {

            $vaccineCenter =  $vaccineService->vaccineCenterShow($id);

            DB::commit();

            return $this->sendResponse($vaccineCenter);

        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, VaccineService $vaccineService, $id)
    {

        DB::beginTransaction();
        try {

            $vaccineCenter =  $vaccineService->vaccineCenterUpdate($request, $id);

            DB::commit();

            return $this->sendResponse($vaccineCenter);

        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(VaccineService $vaccineService, $id)
    {

        DB::beginTransaction();
        try {

            $vaccineService->vaccineCenterDestroy($id);

            DB::commit();

            return $this->sendResponse(null, 'Successfully Data Deleted');


        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }
}
