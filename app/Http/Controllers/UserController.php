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
}
