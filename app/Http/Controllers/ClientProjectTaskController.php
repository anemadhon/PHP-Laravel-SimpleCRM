<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectState;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

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
        return view('clients.projects.tasks.index', [
            'client' => $client,
            'project' => $project,
            'tasks' => $project->tasks()->with(['level', 'state', 'user'])->orderBy('assigned_to')->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Project $project, Task $task)
    {
        return view('clients.projects.tasks.form', [
            'state' => 'Update',
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::when(in_array(auth()->user()->role_id, User::IS_DEV_TEAM), function($query)
            {
                return $query->forDevelopmentTeam();
            })->orderBy('id')->get(['id', 'name']),
            'users' => User::with('role')->orderBy('id')->get(['id', 'name', 'role_id']),
            'client' => $client,
            'project' => $project,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\TaskRequest  $request
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @param  \App\Models\Task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Client $client, Project $project, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Data Updated');
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
