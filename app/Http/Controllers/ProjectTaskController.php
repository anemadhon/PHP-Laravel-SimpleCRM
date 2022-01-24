<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\User;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectState;
use App\Models\Task;
use Illuminate\Http\Request;

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
            'tasks' => $project->tasks()->with(['level', 'state', 'user'])->orderBy('assigned_to')->paginate(4)
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
        return view('projects.tasks.form', [
            'state' => 'New',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'users' => User::notAdmin()->notMgr()->with('role')->orderBy('id')->get(['id', 'name', 'role_id']),
            'project' => $project
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \Illuminate\Http\Request\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->validated() + ['created_by' => auth()->id()]);

        return redirect()->route('projects.index')->with('success', 'Data Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('projects.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'users' => User::notAdmin()->notMgr()->with('role')->orderBy('id')->get(['id', 'name', 'role_id']),
            'project' => $project,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\TaskRequest  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('projects.index')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
