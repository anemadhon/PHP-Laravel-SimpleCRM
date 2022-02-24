<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\UserController@index',
                'action' => 'User',
                'detail' => auth()->user()->name.' Tries to access User Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('users.index', [
            'users' => User::select(['id', 'name', 'username', 'email', 'role_id'])->notAdmin()
                        ->with(['role:id,name', 'skills:id,name'])->withCount(['projects', 'tasks'])->paginate(4),
            'is_mgr' => User::IS_MGR,
            'is_sales' => User::IS_SALES
        ]);
    }

    public function projects(User $user)
    {
        if (!Gate::any(['manage-apps', 'manage-department', 'sale-products'])) {
            (new LogService())->file('gate', [
                'method' => 'App\Http\Controllers\UserController@projects',
                'action' => 'User - Projects',
                'detail' => auth()->user()->name.' Tries to access User - Projects Module',
                'status' => '403',
                'session_id' => request()->session()->getId(),
                'from_ip' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        
        return view('users.projects.index', [
            'user' => $user,
            'projects' => $user->projects()->select(['id', 'name', 'state_id', 'level_id'])->with(['state:id,name', 'level:id,name'])->withCount(['tasks' => function($query) use ($user)
            {
                return $query->where('assigned_to', $user->id);
            }])->paginate(4)
        ]);
    }
}
