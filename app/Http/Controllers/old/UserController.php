<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\VaccineService;
use App\Services\SearchService;

class UserController extends Controller
{
    public function index(VaccineService $vaccineService, SearchService $searchService)
    {
        $users = $vaccineService->getAllUsers();
        foreach ($users as $user) {
            $user->vaccine_status = $searchService->getVaccineStatus(true, $user->scheduled_date);
        }

        return view('pages.users.index', compact('users'));
    }
}
