<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClientType;
use App\Services\LogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientTypeRequest;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.types.index', [
            'types' => ClientType::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.form', [
            'state' => 'New'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClientTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientTypeRequest $request)
    {
        ClientType::create($request->validated());

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\ClientTypeController@store',
            'action' => 'Client Type',
            'detail' => 'Admin Add Client Type Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientType  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientType $type)
    {
        return view('admin.types.form', [
            'state' => 'Update',
            'type' => $type
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClientTypeRequest  $request
     * @param  \App\Models\ClientType  $type
     * @return \Illuminate\Http\Response
     */
    public function update(ClientTypeRequest $request, ClientType $type)
    {
        $type->update($request->validated());

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\ClientTypeController@update',
            'action' => 'Client Type',
            'detail' => 'Admin Update Client Type Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Data Updated');
    }
}
