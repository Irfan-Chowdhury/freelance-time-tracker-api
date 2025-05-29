<?php

namespace App\Http\Controllers;

use App\Services\VaccineService;
use Illuminate\Support\Facades\Cache;

class VaccineCenterController extends Controller
{
    public function index(VaccineService $vaccineService)
    {
        $vaccineCenters = $vaccineService->getAllVaccineCenterData();

        return view('pages.vaccine_centers', compact('vaccineCenters'));
    }
}
