<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\User;
use App\Models\Project;

class ProjectTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'manage-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('teams.index', [
            'teams' => Project::with(['users', 'users.role', 'users.tasks'])->paginate(4)
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

        $project->users()->attach($request->safe()->only('pm')['pm']);
        $project->users()->attach($request->safe()->only('dev')['dev']);
        $project->users()->attach($request->safe()->only('qa')['qa']);

        return redirect()->route('teams.index')->with('success', 'Data Saved');
    }
}
