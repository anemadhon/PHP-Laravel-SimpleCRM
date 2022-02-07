<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectState;
use App\Services\ProjectService;
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = (new ProjectService())->lists(auth()->user());
        
        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

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
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

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
        $details = $project->load(['attachments', 'users', 'users.role', 'tasks', 'tasks.level', 'tasks.state']);
        
        return view('projects.show', [
            'owner' => $project,
            'attachments' => $details->attachments,
            'teams' => $details->users,
            'tasks' => $details->tasks,
            'manager' => User::where('role_id', 2)->first('name'),
            'sales' => User::where('role_id', 4)->whereHas('tasks', function($query) use ($project)
                        {
                            return $query->where('project_id', $project->id);
                        })->get('name')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // dd($project);
        if (!Gate::allows('edit-projects', $project->load('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

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
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        if (!Gate::allows('edit-projects', $project->load('users'))) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $project->update($request->validated());
        
        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project, $request->flag);
        }

        return redirect()->route('projects.index')->with('success', 'Data Updated');
    }

    public function attachment(ProjectAttachment $file)
    {
        $extension = (new ProjectService())->extensionFile($file->filename);
        $path = (new ProjectService())->formatPath($file->path);

        if ($extension === 'pdf') {
            return response()->file(storage_path($path));
        }

        return response()->download(storage_path($path));
    }
}
