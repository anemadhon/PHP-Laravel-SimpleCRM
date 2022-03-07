<?php

namespace App\Http\Controllers\Admin;

use App\Models\Level;
use App\Services\LogService;
use App\Http\Requests\LevelRequest;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.levels.index', [
            'levels' => Level::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.levels.form', [
            'state' => 'New'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LevelRequest $request)
    {
        $level = Level::create($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Level - Admin', 'Add New Data', $level);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\LevelController@store',
            'action' => 'Level',
            'detail' => 'Admin Add Level Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.levels.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return view('admin.levels.form', [
            'state' => 'Update',
            'level' => $level
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LevelRequest  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(LevelRequest $request, Level $level)
    {
        $level->update($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Level - Admin', 'Modify Existing Data', $level);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\LevelController@update',
            'action' => 'Level',
            'detail' => 'Admin Update Level Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.levels.index')->with('success', 'Data Updated');
    }
}
