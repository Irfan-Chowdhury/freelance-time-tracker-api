<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Cache::remember('user_'.$request->user()->id.'_project', now()->addMinutes(30), function () use ($request) {
            return $request->user()->projects;
        });

        return response()->json($projects);
    }

    public function store(ProjectStoreRequest $request)
    {
        $user = $request->user();

        if (! $user->clients()->where('id', $request->client_id)->exists()) {
            return response()->json(['errors' => 'Unauthorized client ID.'], 403);
        }

        $project = Project::create($request->validated());

        return response()->json(['message' => 'Project created successfully.', 'data' => $project], 201);

    }

    public function show(Request $request, Project $project)
    {
        if (! $request->user()->clients()->where('id', $project->client_id)->exists()) {
            return response()->json(['errors' => 'Unauthorized project access.'], 403);
        }

        return response()->json($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        if (! $request->user()->clients()->where('id', $project->client_id)->exists()) {
            return response()->json(['errors' => 'Unauthorized project access.'], 403);
        }

        $project->update($request->validated());

        return response()->json(['message' => 'Project updated successfully.', 'data' => $project], 201);
    }

    public function destroy(Request $request, Project $project)
    {
        if (! $request->user()->clients()->where('id', $project->client_id)->exists()) {
            return response()->json(['errors' => 'Unauthorized project access.'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
