<?php 

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Skill;
use App\Models\ClientType;
use App\Models\ProjectState;

class DashboardService
{
    public function statistic(int $roleId)
    {
        $statistic = [];
        $user = User::developmentTeam()->withCount('projects')->pluck('projects_count');
        $state = ProjectState::select(['id', 'name'])->withCount(['projects', 'tasks'])
                    ->orderBy('projects_count', 'desc')->orderBy('tasks_count', 'desc')->get();
        $level = Level::select(['id', 'name'])->withCount(['projects', 'tasks'])
                    ->orderBy('projects_count', 'desc')->orderBy('tasks_count', 'desc')->get();

        if ($roleId === User::IS_ADMIN) {
            $statistic['roles'] = Role::select(['id', 'name'])->withCount('users')->orderBy('id')->get();
        }
        
        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_SALES) {
            $statistic['user_idle'] = $user->filter(function($value)
                                        {
                                            return $value === 0;
                                        })->count();
            $statistic['user_in_project'] = $user->filter(function($value)
                                            {
                                                return $value > 0;
                                            })->count();
            $statistic['types'] = ClientType::select(['id', 'name'])->withCount('clients')->orderBy('clients_count', 'desc')->get();
            $statistic['skills'] = Skill::select(['id', 'name'])->withCount('users')->orderBy('users_count', 'desc')->take(4)->get();
        }
        
        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_SALES || $roleId === User::IS_PM) {
            $statistic['state_projects_tasks'] = $state;
        }

        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_PM) {
            $statistic['level_projects_tasks'] = $level;
        }

        return $statistic;
    }
}
