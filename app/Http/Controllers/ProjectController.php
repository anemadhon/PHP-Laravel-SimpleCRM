<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\ProjectState;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::with(['state', 'level', 'client'])->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.form', [
            'state' => 'New',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'clients' => Client::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::orderBy('id')->get(['id', 'name']),
            'levels' => Level::orderBy('id')->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());

        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project);
        }

        return redirect()->route('projects.index')->with('success', 'Data Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.form', [
            'state' => 'Update',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'clients' => Client::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::orderBy('id')->get(['id', 'name']),
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        
        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project, $request->flag);
        }

        return redirect()->route('projects.index')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
