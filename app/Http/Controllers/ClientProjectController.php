<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectState;
use Illuminate\Http\Request;
use App\Models\ProjectAttachment;
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
     * @param  \Illuminate\Http\Request\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request, Client $client)
    {
        $client->projects()->create($request->validated());

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
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Project $project)
    {
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
     * @param  \Illuminate\Http\Request\ProjectRequest  $request
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Client $client, Project $project)
    {
        $project->update($request->validated());

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
