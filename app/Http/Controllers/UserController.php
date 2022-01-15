<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::notAdmin()->with(['role', 'skills', 'projects'])->paginate(6)
        ]);
    }

    public function projects(string $username)
    {
        $projects = User::with('projects')->where('username', $username)->firstOrFail();

        return view('users.project', [
            'user' => $projects->name,
            'projects' => $projects->projects()->with(['state', 'level'])->paginate(4)
        ]);
    }
}
