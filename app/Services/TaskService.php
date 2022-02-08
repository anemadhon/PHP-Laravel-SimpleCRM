<?php

namespace App\Services;

use App\Models\ProjectUser;
use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;

class TaskService
{
    public function lists(Authenticatable $user)
    {
        if ($user->can('manage-products') || $user->can('sale-products') || $user->can('develop-products')) {
            $ownTasks = $user->tasks()->with(['project', 'project.users', 'level', 'state', 'user'])->withCount('subs')
                            ->orderBy('assigned_to')->paginate(4);

            if ($user->can('manage-products')) {
                $pm = ProjectUser::where('status', ProjectUser::ON_START)->where('pm_id', $user->id)
                        ->distinct()->get(['project_id']);
                        
                if ($user->id === $user->projects->first()?->pivot->pm_id) {
                    $teamTasks = Task::with(['project', 'project.users', 'level', 'state', 'user'])->withCount('subs')
                                    ->whereIn('project_id', $pm->pluck('project_id'))
                                    ->orderBy('assigned_to')->get();
    
                    return [
                        'own_tasks' => $ownTasks,
                        'team_tasks' => $teamTasks
                    ];
                }
            }
            
            return [
                'own_tasks' => $ownTasks,
                'team_tasks' => null
            ];
        }

        $ownTasks = Task::with(['project', 'project.users', 'level', 'state', 'user'])->withCount('subs')
                        ->orderBy('assigned_to')->paginate(4);
        return [
            'own_tasks' => $ownTasks,
            'team_tasks' => null
        ];
    }
}
