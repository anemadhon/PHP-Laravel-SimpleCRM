<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\SubTask;
use App\Models\ProjectState;
use App\Services\LogService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SubTaskRequest;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        return view('tasks.subs.index', [
            'task' => $task,
            'subs' => $task->subs()->select(['id', 'name', 'level_id', 'state_id', 'slug'])->with(['level:id,name', 'state:id,name'])->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function create(Task $task)
    {
        if (!Gate::allows('manage-sub-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\SubTaskController@create',
                'action' => 'Sub Task',
                'detail' => auth()->user()->name.' Tries to access Sub Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('tasks.subs.form', [
            'state' => 'New',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'task' => $task
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Http\Requests\SubTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubTaskRequest $request, Task $task)
    {
        if (!Gate::allows('manage-sub-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\SubTaskController@store',
                'action' => 'Sub Task',
                'detail' => auth()->user()->name.' Tries to access Sub Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $task->subs()->create($request->validated());

        $log = [
            'method' => 'App\Http\Controllers\SubTaskController@store',
            'action' => 'Sub Task',
            'detail' => 'User Add Sub Task Data',
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

        return redirect()->route('tasks.subs.index', ['task' => $task])->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task, SubTask $sub)
    {
        if (!Gate::allows('manage-sub-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\SubTaskController@edit',
                'action' => 'Sub Task',
                'detail' => auth()->user()->name.' Tries to access Sub Task Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('tasks.subs.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'task' => $task,
            'sub' => $sub
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function update(SubTaskRequest $request, Task $task, SubTask $sub)
    {
        if (!Gate::allows('manage-sub-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\SubTaskController@update',
                'action' => 'Sub Task',
                'detail' => auth()->user()->name.' Tries to access Sub Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $sub->update($request->validated());

        $log = [
            'method' => 'App\Http\Controllers\SubTaskController@update',
            'action' => 'Sub Task',
            'detail' => 'User Update Sub Task Data',
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

        return redirect()->route('tasks.subs.index', ['task' => $task])->with('success', 'Data Updated');
    }
}
