<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Services\LogService;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Events\UserActivityProcessed;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.form', [
            'state' => 'New'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Role - Admin', 'Add New Data', $role);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\RoleController@store',
            'action' => 'Role',
            'detail' => 'Admin Add Role Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.form', [
            'state' => 'Update',
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->create($request->validated());

        UserActivityProcessed::dispatch(auth()->user(), 'Role - Admin', 'Modify Existing Data', $role);

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Admin\RoleController@update',
            'action' => 'Role',
            'detail' => 'Admin Update Role Data',
            'status' => 'success@200',
            'data' => json_encode($request->validated()),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Data Updated');
    }
}
