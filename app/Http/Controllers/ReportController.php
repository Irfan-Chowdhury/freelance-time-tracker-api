<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index(ReportRequest $request, ReportService $reportService)
    {
        try {
            $from = $request->input('from') ?? Carbon::now()->subMonth()->toDateString();
            $to = $request->input('to') ?? Carbon::now()->toDateString();

            $timeLogs = $reportService->getTimeLogs($request, $from, $to);

            return response()->json([
                'filters' => [
                    'from' => $from,
                    'to' => $to,
                    'client_id' => $request->client_id,
                    'project_id' => $request->project_id,
                ],
                'summary' => [ // Grouping
                    'by_day' => $reportService->getByDate($timeLogs),
                    'by_project' => $reportService->getByProject($timeLogs),
                    'by_client' => $reportService->getByClient($timeLogs),
                ],
            ]);

        } catch (Exception $e) {

            Log::error('Failed to create time log: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating time log.',
                // 'error' => $e->getMessage(),
            ], 500);
        }
    }
}
