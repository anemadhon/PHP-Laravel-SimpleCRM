<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\ProjectState;
use App\Services\LogService;
use App\Services\ProjectService;
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Gate;
use App\Events\UserActivityProcessed;
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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectController@create',
                'action' => 'Project',
                'detail' => auth()->user()->name.' Tries to access Project Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('projects.form', [
            'state' => 'New',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'clients' => Client::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::orderBy('id')->take(3)->get(['id', 'name']),
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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectController@store',
                'action' => 'Project',
                'detail' => auth()->user()->name.' Tries to access Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $project = Project::create($request->validated());

        $attachments = [];

        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project);
            
            $attachments = (new ProjectService())->formatAttachmentsToLogs($request->file('attachment'), $project->slug);
        }

        UserActivityProcessed::dispatch(auth()->user(), 'Project', 'Add New Data', $project);

        $log = [
            'method' => 'App\Http\Controllers\ProjectController@store',
            'action' => 'Project',
            'detail' => 'User Add Project Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated() + $attachments)
        ]));
        
        (new LogService())->file('activity', ($log + [
            'data' => ($request->validated() + $attachments)
        ]));

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
        $details = $project->load([
            'level:id,name', 'state:id,name', 'client:id,name', 'attachments', 'users:id,name,role_id', 
            'users.role:id,name', 'tasks:id,name,level_id,state_id', 'tasks.level:id,name', 'tasks.state:id,name'
        ]);
        
        return view('projects.show', [
            'owner' => $details,
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
        if (!Gate::allows('edit-projects', $project->load('users'))) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectController@edit',
                'action' => 'Project',
                'detail' => auth()->user()->name.' Tries to access Project Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('projects.form', [
            'state' => 'Update',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'clients' => Client::orderBy('id')->get(['id', 'name']),
            'states' => ProjectState::orderBy('id')->get(['id', 'name']),
            'levels' => Level::orderBy('id')->get(['id', 'name']),
            'project' => $project->load('client:id,name')
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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ProjectController@update',
                'action' => 'Project',
                'detail' => auth()->user()->name.' Tries to access Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $project->update($request->validated());

        $attachments = [];
        
        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project, $request->flag);
            
            $attachments = (new ProjectService())->formatAttachmentsToLogs($request->file('attachment'), $project->slug);
        }

        if ($request->validated()['state_id'] == ProjectState::CLOSE) {
            foreach ($project->users()->get() as $user) {
                $user->pivot->status = ProjectUser::DONE;
                $user->pivot->save();
            }
        }

        UserActivityProcessed::dispatch(auth()->user(), 'Project', 'Modify Existing Data', $project);

        $log = [
            'method' => 'App\Http\Controllers\ProjectController@update',
            'action' => 'Project',
            'detail' => 'User Update Project Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated() + $attachments)
        ]));
        
        (new LogService())->file('activity', ($log + [
            'data' => ($request->validated() + $attachments)
        ]));

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
