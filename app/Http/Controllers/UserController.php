<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return view('users.index', [
            'users' => User::notAdmin()->with(['role', 'skills', 'tasks'])->withCount('projects')->paginate(4),
            'is_mgr' => User::IS_MGR,
            'is_sales' => User::IS_SALES
        ]);
    }

    public function projects(User $user)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('users.projects.index', [
            'user' => $user,
            'projects' => $user->projects()->with(['state', 'level'])->withCount(['tasks' => function($query) use ($user)
            {
                return $query->where('assigned_to', $user->id);
            }])->paginate(4)
        ]);
    }
}
