<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;

class TaskService
{
    public function lists(Authenticatable $user)
    {
        if ($user->can('create-teams') || $user->can('create-clients') || $user->can('create-tasks')) {
            return $user->tasks()->with(['project', 'level', 'state', 'user'])->withCount('subs')->orderBy('assigned_to')->paginate(4);
        }

        return Task::with(['project', 'level', 'state', 'user'])->withCount('subs')->orderBy('assigned_to')->paginate(4);
    }
}
