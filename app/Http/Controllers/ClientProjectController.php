<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\ProjectState;
use App\Services\LogService;
use App\Services\ProjectService;
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
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectController@index',
                'action' => 'Client - Project',
                'detail' => auth()->user()->name.' Tries to access Client - Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.index', [
            'client' => $client,
            'projects' => $client->projects()->with(['state:id,name', 'level:id,name'])->withCount('tasks')->paginate(4)
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
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectController@create',
                'action' => 'Client - Project',
                'detail' => auth()->user()->name.' Tries to access Client - Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.projects.form', [
            'state' => 'New',
            'mimes' => implode(',', ProjectAttachment::MIME_TYPES),
            'states' => ProjectState::orderBy('id')->take(3)->get(['id', 'name']),
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
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectController@store',
                'action' => 'Client - Project',
                'detail' => auth()->user()->name.' Tries to access Client - Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $project = $client->projects()->create($request->validated());

        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project);

            $attachments = (new ProjectService())->formatAttachmentsToLogs($request->file('attachment'), $project);
        }

        $log = [
            'method' => 'App\Http\Controllers\ClientProjectController@store',
            'action' => 'Client - Project',
            'detail' => 'User Add Client - Project Data',
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client
     * @param  \App\Models\Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Project $project)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectController@edit',
                'action' => 'Client - Project',
                'detail' => auth()->user()->name.' Tries to access Client - Project Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

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
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientProjectController@update',
                'action' => 'Client - Project',
                'detail' => auth()->user()->name.' Tries to access Client - Project Module',
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

        if ($request->hasFile('attachment')) {
            (new ProjectService())->attachment($request->file('attachment'), $project, $request->flag);
            
            $attachments = (new ProjectService())->formatAttachmentsToLogs($request->file('attachment'), $project);
        }
        
        if ($request->validated()['state_id'] == ProjectState::CLOSE) {
            foreach ($project->users()->get() as $user) {
                $user->pivot->status = ProjectUser::DONE;
                $user->pivot->save();
            }
        }

        $log = [
            'method' => 'App\Http\Controllers\ClientProjectController@update',
            'action' => 'Client - Project',
            'detail' => 'User Update Client - Project Data',
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
}
