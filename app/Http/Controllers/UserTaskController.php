<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\ProjectState;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Gate;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\UserTaskController@index',
                'action' => 'User - Task',
                'detail' => auth()->user()->name.' Tries to access User - Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('users.tasks.index', [
            'user' => $user,
            'tasks' => $user->tasks()->select(['id', 'name', 'slug', 'state_id', 'level_id', 'project_id'])
                        ->with(['state:id,name', 'level:id,name', 'project:id,name,client_id', 'project.client:id,name'])
                        ->paginate(4)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Task $task)
    {
        if (!Gate::allows('edit-user-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\UserTaskController@edit',
                'action' => 'User - Task',
                'detail' => auth()->user()->name.' Tries to access User - Task Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('users.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'user' => $user->load('role:id,name'),
            'task' => $task->load('project:id,name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\User
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, User $user, Task $task)
    {
        if (!Gate::allows('edit-user-tasks', $task)) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\UserTaskController@update',
                'action' => 'User - Task',
                'detail' => auth()->user()->name.' Tries to access User - Task Module',
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
            'method' => 'App\Http\Controllers\UserTaskController@update',
            'action' => 'User - Task',
            'detail' => 'User Update User - Task Data',
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
