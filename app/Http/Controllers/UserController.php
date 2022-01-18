<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::notAdmin()->with(['role', 'skills', 'projects', 'tasks'])->paginate(6),
            'is_mgr' => User::IS_MGR,
            'is_sales' => User::IS_SALES
        ]);
    }

    public function projects(User $user)
    {
        return view('users.project', [
            'user' => $user->name,
            'projects' => $user->projects()->with(['state', 'level'])->paginate(4)
        ]);
    }
    
    public function tasks(User $user)
    {
        return view('users.task', [
            'user' => $user->name,
            'tasks' => $user->tasks()->with(['state', 'level', 'project', 'project.client'])->paginate(4)
        ]);
    }
}
