<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Project;
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
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('users.tasks.index', [
            'user' => $user,
            'tasks' => $user->tasks()->with(['state', 'level', 'project', 'project.client'])->paginate(4)
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
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('users.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'projects' => Project::orderBy('id')->get(['id', 'name']),
            'user' => $user->load('role'),
            'task' => $task
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
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Data Updated');
    }
}
