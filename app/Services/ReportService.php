<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TimeLog;
use Carbon\Carbon;

class ReportService
{
    public function getTimeLogs(object $request, string $from, string $to): ?object
    {
        $user = $request->user();

        return TimeLog::whereHas('project.client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->whereBetween('start_time', [$from, Carbon::parse($to)->endOfDay()])
            ->when($request->client_id, function ($q) use ($request) {
                $q->whereHas('project.client', function ($q2) use ($request) {
                    $q2->where('id', $request->client_id);
                });
            })
            ->when($request->project_id, function ($q) use ($request) {
                $q->where('project_id', $request->project_id);
            })
            ->get();
    }

    public function getByDate(object $timeLogs): ?object
    {
        return $timeLogs->groupBy(function ($timeLog) {
            return Carbon::parse($timeLog->start_time)->toDateString();
        })->map(function ($group) {
            return round($group->sum('hours'), 2);
        });
    }

    public function getByProject(object $timeLogs): ?object
    {
        return $timeLogs->groupBy('project_id')->map(function ($group, $projectId) {
            return [
                'project_id' => $projectId,
                'project_title' => optional($group->first()->project)->title,
                'total_hours' => round($group->sum('hours'), 2),
            ];
        })->values();
    }

    public function getByClient(object $timeLogs): ?object
    {
        return $timeLogs->groupBy(function ($log) {
            return optional($log->project->client)->id;
        })->map(function ($group, $clientId) {
            return [
                'client_id' => $clientId,
                'client_name' => optional($group->first()->project->client)->name,
                'total_hours' => round($group->sum('hours'), 2),
            ];
        })->values();
    }
}
