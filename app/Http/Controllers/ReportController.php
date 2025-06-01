<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;
use App\Models\TimeLog;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(ReportRequest $request)
    {

        $user = $request->user();

        // Dates
        $from = $request->input('from') ?? Carbon::now()->subMonth()->toDateString();
        $to = $request->input('to') ?? Carbon::now()->toDateString();

        // Get logs filtered by ownership
        $timeLogs = self::getTimeLogs($request, $user, $from, $to);

        // Grouping
        $byDay = self::getByDate($timeLogs);

        $byProject = self::getByProject($timeLogs);

        $byClient = self::getByClient($timeLogs);


        return response()->json([
            'filters' => [
                'from' => $from,
                'to' => $to,
                'client_id' => $request->client_id,
                'project_id' => $request->project_id,
            ],
            'summary' => [
                'by_day' => $byDay,
                'by_project' => $byProject,
                'by_client' => $byClient,
            ],
        ]);
    }

    private function getTimeLogs(object $request,object $user, string $from, string $to) : object|null
    {
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

    private function getByDate(object $timeLogs)
    {
        return $timeLogs->groupBy(function ($timeLog) {
            return Carbon::parse($timeLog->start_time)->toDateString();
        })->map(function ($group) {
            return round($group->sum('hours'), 2);
        });
    }

    private function getByProject(object $timeLogs)
    {
        return $timeLogs->groupBy('project_id')->map(function ($group, $projectId) {
            return [
                'project_id' => $projectId,
                'project_title' => optional($group->first()->project)->title,
                'total_hours' => round($group->sum('hours'), 2),
            ];
        })->values();
    }

    private function getByClient(object $timeLogs)
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
