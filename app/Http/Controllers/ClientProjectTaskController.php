<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectState;
use App\Services\LogService;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Gate;
use App\Events\UserActivityProcessed;

class ClientProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client, Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectTaskController@index',
                'action' => 'Client - Project - Task',
                'detail' => auth()->user()->name.' Tries to access Client - Project - Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.tasks.index', [
            'client' => $client,
            'project' => $project,
            'tasks' => $project->tasks()->select(['id', 'name', 'level_id', 'state_id', 'assigned_to', 'slug'])->with(['level:id,name', 'state:id,name', 'user:id,name'])->orderBy('assigned_to')->paginate(4)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Project $project, Task $task)
    {
        if (!Gate::allows('edit-user-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectTaskController@edit',
                'action' => 'Client - Project - Task',
                'detail' => auth()->user()->name.' Tries to access Client - Project - Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'client' => $client,
            'project' => $project,
            'task' => $task->load(['user:id,name,role_id', 'user.role:id,name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Client $client, Project $project, Task $task)
    {
        if (!Gate::allows('edit-user-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectTaskController@update',
                'action' => 'Client - Project - Task',
                'detail' => auth()->user()->name.' Tries to access Client - Project - Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $task->update($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Client - Task', 'Modify Existing Data', $task);

        $log = [
            'method' => 'App\Http\Controllers\ClientProjectTaskController@update',
            'action' => 'Client - Project - Task',
            'detail' => 'User Add Client - Project - Task Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated())
        ]));
        
        (new LogService())->file('activity', ($log + [
            'data' => $request->validated()
        ]));

        return redirect()->route('tasks.index')->with('success', 'Data Updated');
    }
}
