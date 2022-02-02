<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Http\Requests\TeamRequest;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Gate;

class ProjectTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('projects.teams.index', [
            'project' => $project,
            'teams' => $project->users()->with(['role'])->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department']) && $project->users->count() !== 0) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $users = User::developmentTeam()->with('role')->orderBy('id')->get(['id', 'name', 'role_id']);

        return view('teams.form', [
            'project' => $project,
            'users_pm' => $users->where('role_id', User::IS_PM),
            'users_dev' => $users->where('role_id', User::IS_DEV_TEAM[0]),
            'users_qa' => $users->where('role_id', User::IS_DEV_TEAM[1])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Http\Requests\TeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request, Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department']) && $project->users->count() !== 0) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        //check apakah developer available
        //check apakah qa available

        $teams = (new ProjectService())->team($request->safe()->only(['pm', 'dev', 'qa']));
        $pm = ['pm_id' => $request->safe()->only('pm')['pm']];

        $project->users()->syncWithPivotValues($teams, $pm);

        return redirect()->route('teams.index')->with('success', 'Data Saved');
    }
}
