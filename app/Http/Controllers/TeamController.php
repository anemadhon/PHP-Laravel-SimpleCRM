<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\LogService;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function __invoke()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\TeamController',
                'action' => 'Task',
                'detail' => auth()->user()->name.' Tries to access Team List',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('teams.index', [
            'teams' => Project::select(['id', 'name'])->with(['users:id,name,role_id', 'users.role:id,name', 'users.tasks:id,assigned_to'])->paginate(4)
        ]);
    }
}
