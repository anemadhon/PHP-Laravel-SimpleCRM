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

        if ($roleId === User::IS_ADMIN) {
            $statistic['roles'] = Role::select(['id', 'name'])->withCount('users')->orderBy('users_count', 'desc')->get();
        }
        
        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_SALES) {
            $statistic['user_idle'] = User::developmentTeam()->withCount('projects')->having('projects_count', 0)->count();
            $statistic['user_in_project'] = User::developmentTeam()->withCount('projects')->having('projects_count', '<>', 0)->count();
            /* $statistic['user_idle'] = 1;
            $statistic['user_in_project'] = 1; */
            $statistic['types'] = ClientType::select(['id', 'name'])->withCount('clients')->orderBy('clients_count', 'desc')->get();
        }
        
        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_SALES || $roleId === User::IS_PM) {
            $statistic['states'] = ProjectState::select(['id', 'name'])->withCount('projects')->orderBy('projects_count', 'desc')->get();
        }

        if ($roleId === User::IS_ADMIN || $roleId === User::IS_MGR || $roleId === User::IS_PM) {
            $statistic['level_projects'] = Level::select(['id', 'name'])->withCount('projects')->orderBy('projects_count', 'desc')->get();
            $statistic['level_tasks'] = Level::select(['id', 'name'])->withCount('tasks')->orderBy('tasks_count', 'desc')->get();
        }

        $statistic['skills'] = Skill::select(['id', 'name'])->withCount('users')->orderBy('users_count', 'desc')->take(4)->get();

        return $statistic;
    }
}
