<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectState;
use App\Services\LogService;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = (new TaskService())->lists(auth()->user());

        return view('tasks.index', [
            'tasks' => $tasks['own_tasks'],
            'team_tasks' => $tasks['team_tasks']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::any(['manage-apps', 'manage-department'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\TaskController@create',
                'action' => 'Task',
                'detail' => auth()->user()->name.' Tries to access Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('tasks.form', [
            'state' => 'New',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
                        {
                            return $query->forDevelopmentTeam();
                        })->orderBy('id')->get(['id', 'name']),
            'projects' => Project::orderBy('id')->get(['id', 'name']),
            'users' => User::notAdmin()->notMgr()->with('role:id,name')->whereIn('role_id', [3,4])->orderBy('id')->get(['id', 'name', 'role_id'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        if (!Gate::any(['manage-apps', 'manage-department'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\TaskController@store',
                'action' => 'Task',
                'detail' => auth()->user()->name.' Tries to access Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        Task::create($request->validated() + ['created_by' => auth()->id()]);

        $log = [
            'method' => 'App\Http\Controllers\TaskController@store',
            'action' => 'Task',
            'detail' => 'User Add Task Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated() + ['created_by' => auth()->id()])
        ]));
        
        (new LogService())->file('activity', ($log + [
            'data' => ($request->validated() + ['created_by' => auth()->id()])
        ]));

        return redirect()->route('tasks.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $task = $task->load(['project:id,name', 'user:id,name,role_id', 'user.role:id,name', 'project.users']);

        if (!Gate::allows('edit-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\TaskController@edit',
                'action' => 'Task',
                'detail' => auth()->user()->name.' Tries to access Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
                        {
                            return $query->forDevelopmentTeam();
                        })->orderBy('id')->get(['id', 'name']),
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        if (!Gate::allows('edit-tasks', $task->load(['project', 'project.users']))) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\TaskController@update',
                'action' => 'Task',
                'detail' => auth()->user()->name.' Tries to access Task Module',
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

        $log = [
            'method' => 'App\Http\Controllers\TaskController@update',
            'action' => 'Task',
            'detail' => 'User Update Task Data',
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
