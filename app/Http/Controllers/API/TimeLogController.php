<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeLog\TimeLogStoreRequest;
use App\Http\Requests\TimeLog\TimeLogUpdateRequest;
use App\Models\TimeLog;
use App\Notifications\DailyHoursExceededNotification;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class TimeLogController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // DB::enableQueryLog();
        $logs = TimeLog::whereHas('project.client', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->latest()
        ->paginate(10);

        // dd(DB::getQueryLog());

        return response()->json($logs);
    }


    public function store(TimeLogStoreRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);
            $data['hours'] = round($start->floatDiffInHours($end), 2);
        } else {
            $data['hours'] = 0;
        }

        $timeLog = TimeLog::create($data);

        self::emailSendIfDailyHourExceed($timeLog);

        return response()->json(['message' => 'Time log created successfully.', 'data' => $timeLog], 201);
    }

    private function emailSendIfDailyHourExceed($timeLog)
    {
        $date = Carbon::parse($timeLog->start_time)->toDateString();

        // Get all logs by the same user for that date
        $client = $timeLog->project->client ?? null;
        $user = $client?->user ?? null;


        if ($user) {
            $logsForDay = TimeLog::whereHas('project.client', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->whereDate('start_time', $date)->get();

            $totalHours = round($logsForDay->sum('hours'), 2);

            if ($totalHours > 8) {
                $user->notify(new DailyHoursExceededNotification($date, $totalHours));
            }
        }
    }





    public function update(TimeLogUpdateRequest $request, TimeLog $timeLog)
    {
        $data = $request->validated();

        $timeLog->fill($data);

        // Recalculate hours if both provided
        if ($timeLog->start_time && $timeLog->end_time) {
            $timeLog->hours = round(
                Carbon::parse($timeLog->start_time)->floatDiffInHours($timeLog->end_time),
                2
            );
        }

        $timeLog->save();

        return response()->json(['message' => 'Time log updated successfully.', 'data' => $timeLog], 201);

    }

    public function stopTimer(TimeLog $timeLog)
    {
        if ($timeLog->end_time) {
            return response()->json(['message' => 'Timer already stopped'], 400);
        }

        $timeLog->end_time = now();
        $timeLog->hours = round($timeLog->start_time->floatDiffInHours(now()),2);
        $timeLog->save();

        return response()->json(['message' => 'Time log stopped successfully.', 'data' => $timeLog], 201);

    }


    public function pdfExport(Request $request)
    {
        $user = $request->user();

        $query = TimeLog::with('project.client')
            ->whereHas('project.client', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        if ($request->filled('from')) {
            $query->where('start_time', '>=', Carbon::parse($request->from));
        }

        if ($request->filled('to')) {
            $query->where('end_time', '<=', Carbon::parse($request->to));
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $timeLogs = $query->orderBy('start_time', 'desc')->get();

        $pdf = Pdf::loadView('pdf.time_logs', ['timeLogs' => $timeLogs]);

        return $pdf->download('time_logs.pdf');
    }


}
