<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TimeLog;
use App\Notifications\DailyHoursExceededNotification;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class TimeLogService
{
    public function getAll(Request $request)
    {
        $user = $request->user();

        return TimeLog::whereHas('project.client', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->latest()
            ->paginate(10);
    }

    public function saveData($request): object
    {
        $data = $request->validated();

        if (! empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);
            $data['hours'] = round($start->floatDiffInHours($end), 2);
        } else {
            $data['hours'] = 0;
        }

        $timeLog = TimeLog::create($data);

        self::emailSendIfDailyHourExceed($timeLog);

        return $timeLog;
    }

    public function updateData($request, object $timeLog): object
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

        self::emailSendIfDailyHourExceed($timeLog);

        return $timeLog;
    }

    public function makeTimeStop(object $timeLog): object
    {
        if ($timeLog->end_time) {
            throw new Exception('Timer already stopped', 1);
        }

        $timeLog->end_time = now();
        $timeLog->hours = round($timeLog->start_time->floatDiffInHours(now()), 2);
        $timeLog->save();

        self::emailSendIfDailyHourExceed($timeLog);

        return $timeLog;
    }

    public function pdfGenerate($request)
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

        return $query->orderBy('start_time', 'desc')->get();
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
}

// DB::enableQueryLog();
// dd(DB::getQueryLog());
