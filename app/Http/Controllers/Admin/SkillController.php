<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use App\Services\LogService;
use App\Http\Requests\SkillRequest;
use App\Http\Controllers\Controller;
use App\Events\UserActivityProcessed;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.skills.index', [
            'skills' => Skill::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.skills.form', [
            'state' => 'New'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SkillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillRequest $request)
    {
        $skill = Skill::create($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Skill - Admin', 'Add New Data', $skill);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\SkillController@store',
            'action' => 'Skill',
            'detail' => 'Admin Add Skill Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.skills.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.form', [
            'state' => 'Update',
            'skill' => $skill
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SkillRequest  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(SkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Skill - Admin', 'Modify Existing Data', $skill);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\SkillController@update',
            'action' => 'Skill',
            'detail' => 'Admin Update Skill Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.skills.index')->with('success', 'Data Saved');
    }
}
