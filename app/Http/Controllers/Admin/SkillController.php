<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Models\Skill;

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
        Skill::create($request->validated());

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

        return redirect()->route('admin.skills.index')->with('success', 'Data Saved');
    }
}
