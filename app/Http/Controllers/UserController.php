<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::notAdmin()->with('role')->paginate(6);

        return view('users.index', compact('users'));
    }
}
