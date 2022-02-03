<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectState;
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProjectRequest;

class ClientProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Client
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.index', [
            'client' => $client,
            'projects' => $client->projects()->with(['state', 'level'])->withCount('tasks')->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Client
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.form', [
            'state' => 'New',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'states' => ProjectState::orderBy('id')->get(['id', 'name']),
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'client' => $client
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Client
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request, Client $client)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $client->projects()->create($request->validated());

        return redirect()->route('projects.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.form', [
            'state' => 'Update',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'states' => ProjectState::orderBy('id')->get(['id', 'name']),
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'client' => $client,
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Client $client, Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $project->update($request->validated());

        return redirect()->route('projects.index')->with('success', 'Data Updated');
    }
}
