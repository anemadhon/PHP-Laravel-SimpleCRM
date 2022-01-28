<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectState;
use App\Models\User;
use App\Services\TaskService;

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
            'tasks' => $tasks
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
            'users' => User::notAdmin()->notMgr()->with('role')->whereIn('role_id', [3,4])->orderBy('id')->get(['id', 'name', 'role_id'])
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
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        Task::create($request->validated() + ['created_by' => auth()->id()]);

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
        if (!Gate::allows('manage-apps') || !in_array(auth()->id(), [$task->created_by, $task->assigned_to])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
                        {
                            return $query->forDevelopmentTeam();
                        })->orderBy('id')->get(['id', 'name']),
            'projects' => Project::orderBy('id')->get(['id', 'name']),
            'users' => User::notAdmin()->notMgr()->with('role')->whereIn('role_id', [3,4])->orderBy('id')->get(['id', 'name', 'role_id']),
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
        if (!Gate::allows('manage-apps') || !in_array(auth()->id(), [$task->created_by, $task->assigned_to])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Data Updated');
    }
}
