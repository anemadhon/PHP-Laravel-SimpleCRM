<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Services\LogService;
use App\Services\ProjectService;
use App\Http\Requests\TeamRequest;
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
            'teams' => $project->users()->with(['role:id,name'])->paginate(4)
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
        if (!Gate::allows('create-project-teams', $project->loadCount('users'))) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectTeamController@create',
                'action' => 'Project - Team',
                'detail' => auth()->user()->name.' Tries to access Project - Team Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

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
        if (!Gate::allows('create-project-teams', $project->loadCount('users'))) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectTeamController@store',
                'action' => 'Project - Team',
                'detail' => auth()->user()->name.' Tries to access Project - Team Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $devTeamAvailability = (new ProjectService())->availabilityStatusCheck($request->safe()->only(['dev', 'qa']));
        
        if ($devTeamAvailability['status'] !== 'available') {
            $errors = (new ProjectService())->formatErrors($devTeamAvailability['ids']);

            return back()->withErrors($errors)->withInput();
        }

        $teams = (new ProjectService())->team($request->safe()->only(['pm', 'dev', 'qa']));
        $pm = ['pm_id' => $request->safe()->only('pm')['pm']];

        $project->users()->syncWithPivotValues($teams, $pm);

        $log = [
            'method' => 'App\Http\Controllers\ProjectTeamController@store',
            'action' => 'Project - Team',
            'detail' => 'User Add Project - Team Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->safe()->only(['pm', 'dev', 'qa']) + $pm)
        ]));
        
        (new LogService())->file('activity', ($log + [
            'data' => ($request->safe()->only(['pm', 'dev', 'qa']) + $pm)
        ]));

        return redirect()->route('teams.index')->with('success', 'Data Saved');
    }
}
