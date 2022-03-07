<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProjectState;
use App\Services\LogService;
use App\Http\Controllers\Controller;
use App\Events\UserActivityProcessed;
use App\Http\Requests\ProjectStateRequest;

class ProjectStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.states.index', [
            'states' => ProjectState::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.states.form', [
            'state' => 'New'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectStateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStateRequest $request)
    {
        $state = ProjectState::create($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Project State - Admin', 'Add New Data', $state);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\ProjectStateController@store',
            'action' => 'Project State',
            'detail' => 'Admin Add Project State Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.states.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectState  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectState $state)
    {
        return view('admin.states.form', [
            'state' => 'Update',
            'project_state' => $state
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectStateRequest  $request
     * @param  \App\Models\ProjectState  $state
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStateRequest $request, ProjectState $state)
    {
        $state->update($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Project State - Admin', 'Modify Existing Data', $state);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\ProjectStateController@update',
            'action' => 'Project State',
            'detail' => 'Admin Update Project State Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.states.index')->with('success', 'Data Updated');
    }
}
