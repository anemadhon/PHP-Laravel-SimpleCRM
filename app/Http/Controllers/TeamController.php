<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function __invoke()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('teams.index', [
            'teams' => Project::select(['id', 'name'])->with(['users:id,name,role_id', 'users.role:id,name', 'users.tasks:id,assigned_to'])->paginate(4)
        ]);
    }
}
