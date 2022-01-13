<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStateRequest;
use App\Models\ProjectState;
use Illuminate\Http\Request;

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
        ProjectState::create($request->validated());

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

        return redirect()->route('admin.states.index')->with('success', 'Data Updated');
    }
}
