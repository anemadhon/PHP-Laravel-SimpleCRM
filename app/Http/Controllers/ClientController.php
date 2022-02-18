<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Services\LogService;
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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientController@index',
                'action' => 'Client',
                'detail' => auth()->user()->name.' Tries to access Client Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('clients.index', [
            'clients' => Client::select(['id', 'name', 'description', 'slug', 'type_id'])->withCount('projects')->with('type:id,name')->paginate(4)
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
                'method' => 'App\Http\Controllers\ClientController@create',
                'action' => 'Client',
                'detail' => auth()->user()->name.' Tries to access Client Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientController@store',
                'action' => 'Client',
                'detail' => auth()->user()->name.' Tries to access Client Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        Client::create($request->validated());

        $log = [
            'method' => 'App\Http\Controllers\ClientController@store',
            'action' => 'Client',
            'detail' => 'User Add Client Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated())
        ]));

        (new LogService())->file('activity', ($log + [
            'data' => $request->validated()
        ]));

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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientController@edit',
                'action' => 'Client',
                'detail' => auth()->user()->name.' Tries to access Client Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

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
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\ClientController@update',
                'action' => 'Client',
                'detail' => auth()->user()->name.' Tries to access Client Module',
                'status' => '403',
                'session_id' => $request->session()->getId(),
                'from_ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        $client->update($request->validated());

        $log = [
            'method' => 'App\Http\Controllers\ClientController@update',
            'action' => 'Client',
            'detail' => 'User Update Client Data',
            'status' => 'success@200',
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        (new LogService())->store(($log + [
            'data' => json_encode($request->validated())
        ]));

        (new LogService())->file('activity', ($log + [
            'data' => $request->validated()
        ]));

        return redirect()->route('clients.index')->with('success', 'Data Updated');
    }
}
