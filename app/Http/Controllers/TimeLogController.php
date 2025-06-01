<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeLog\TimeLogStoreRequest;
use App\Http\Requests\TimeLog\TimeLogUpdateRequest;
use App\Http\Resources\TimeLogResource;
use App\Models\TimeLog;
use App\Services\TimeLogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimeLogController extends Controller
{
    public function index(Request $request, TimeLogService $timeLogService)
    {
        $timeLogs = $timeLogService->getAll($request);

        return TimeLogResource::collection($timeLogs);
    }

    public function store(TimeLogStoreRequest $request, TimeLogService $timeLogService)
    {
        try {
            $timeLog = $timeLogService->saveData($request);

            return (new TimeLogResource($timeLog))->additional([
                'message' => 'Time log created successfully.',
            ]);

        } catch (Exception $e) {

            Log::error('Failed to create time log: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating time log.',
                // 'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(TimeLogUpdateRequest $request, TimeLog $timeLog, TimeLogService $timeLogService)
    {
        try {
            $timeLog = $timeLogService->updateData($request, $timeLog);

            return (new TimeLogResource($timeLog))->additional([
                'message' => 'Time log updated successfully.',
            ]);

        } catch (Exception $e) {

            Log::error('Failed to create time log: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating time log.',
                // 'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function stopTimer(TimeLog $timeLog, TimeLogService $timeLogService)
    {
        try {
            $timeLog = $timeLogService->makeTimeStop($timeLog);

            return (new TimeLogResource($timeLog))->additional([
                'message' => 'Time log stopped successfully.',
            ]);

        } catch (Exception $e) {

            Log::error('Failed to create time log: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating time log.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function pdfExport(Request $request, TimeLogService $timeLogService)
    {
        try {
            $timeLogs = $timeLogService->pdfGenerate($request);

            $pdf = Pdf::loadView('pdf.time_logs', ['timeLogs' => $timeLogs]);

            return $pdf->download('time_logs.pdf');

        } catch (Exception $e) {

            Log::error('Failed to create time log: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating time log.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
