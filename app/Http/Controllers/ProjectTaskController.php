<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectState;
use App\Services\LogService;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Gate;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('projects.tasks.index', [
            'project' => $project,
            'tasks' => $project->tasks()->select(['id', 'name', 'slug', 'state_id', 'level_id', 'assigned_to'])
                        ->with(['level:id,name', 'state:id,name', 'user:id,name'])->orderBy('assigned_to')->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        if (!Gate::allows('manage-project-tasks', $project->load('users')->loadCount('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('projects.tasks.form', [
            'state' => 'New',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'users' => $project->users()->with('role:id,name')->get(['id', 'name', 'role_id']),
            'project' => $project
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request, Project $project)
    {
        if (!Gate::allows('manage-project-tasks', $project->load('users')->loadCount('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $project->tasks()->create($request->validated() + ['created_by' => auth()->id()]);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\ProjectTaskController@store',
            'action' => 'Project - Task',
            'detail' => 'User Add Project - Task Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated() + ['created_by' => auth()->id()]),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('projects.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Task $task)
    {
        if (!Gate::allows('manage-project-tasks', $project->load('users')->loadCount('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('projects.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'users' => User::notAdmin()->notMgr()->with('role:id,name')->orderBy('id')->get(['id', 'name', 'role_id']),
            'project' => $project,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Project $project, Task $task)
    {
        if (!Gate::allows('manage-project-tasks', $project->load('users')->loadCount('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $task->update($request->validated());

        (new LogService())->store([
            'method' => 'App\Http\Controllers\ProjectTaskController@update',
            'action' => 'Project - Task',
            'detail' => 'User Update Project - Task Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('projects.index')->with('success', 'Data Updated');
    }
}
