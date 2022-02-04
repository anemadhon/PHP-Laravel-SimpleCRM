<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.index', [
            'clients' => Client::withCount('projects')->with('type')->paginate(4)
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

        return view('clients.form', [
            'state' => 'New',
            'types' => ClientType::orderBy('id')->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        Client::create($request->validated());

        return redirect()->route('clients.index')->with('success', 'Data Saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.form', [
            'state' => 'Update',
            'types' => ClientType::orderBy('id')->get(['id', 'name']),
            'client' => $client 
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Data Updated');
    }
}
