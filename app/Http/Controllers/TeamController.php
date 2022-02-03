<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function __invoke()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'create-clients'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('teams.index', [
            'teams' => Project::with(['users', 'users.role', 'users.tasks'])->paginate(4)
        ]);
    }
}
