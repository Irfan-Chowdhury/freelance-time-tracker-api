<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Services\SearchService;
use App\Services\UserService;

class SearchController extends Controller
{
    public function searchProcess(SearchRequest $request, UserService $userService, SearchService $searchService)
    {
        $userData = $userService->show($request->nid);

        $isExitstsData = isset($userData) ? true : false;

        $scheduledDate = isset($userData) ? $userData->scheduled_date : null;

        $vaccineStatus = $searchService->getVaccineStatus($isExitstsData, $scheduledDate);

        return response()->json([
                            'user' => $userData,
                            'vaccine_status'=> $vaccineStatus
                        ]);
    }
}
