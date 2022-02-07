<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-apps', function(User $user)
        {
            return $user->role_id === User::IS_ADMIN;
        });

        Gate::define('manage-department', function(User $user)
        {
            return $user->role_id === User::IS_MGR;
        });
        
        Gate::define('sale-products', function(User $user)
        {
            return $user->role_id === User::IS_SALES;
        });
        
        Gate::define('manage-products', function(User $user)
        {
            return $user->role_id === User::IS_PM;
        });
        
        Gate::define('develop-products', function(User $user)
        {
            return in_array($user->role_id, User::IS_DEV_TEAM);
        });

        Gate::define('edit-projects', function(User $user, Project $project)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $isSales = $user->role_id === User::IS_SALES;
            $pmProject = $user->id === $project->users->first()?->pivot->pm_id;

            return ($isAdmin || $isManager || $isSales || $pmProject);
        });

        Gate::define('edit-tasks', function(User $user, Task $task)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $pmProject = $user->id === $task->project->users->first()->pivot->pm_id;
            $ownerTask = $user->id === $task->created_by;
            $picTask = $user->id === $task->assigned_to;
            $hasTeam = $task->project->users->count() > 0;

            return ($hasTeam && ($isAdmin || $isManager || $pmProject || $ownerTask || $picTask));
        });
        
        Gate::define('edit-user-tasks', function(User $user, Task $task)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $isSales = $user->role_id === User::IS_SALES;
            $ownerTask = $user->id === $task->created_by;
            $picTask = $user->id === $task->assigned_to;

            return ($isAdmin || $isManager || $ownerTask || ($isSales && $picTask));
        });
        
        Gate::define('create-project-teams', function(User $user, Project $project)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $hasNoTeam = $project->users_count === 0;

            return ($hasNoTeam && ($isAdmin || $isManager));
        });

        Gate::define('manage-project-tasks', function(User $user, Project $project)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $pmProject = $user->id === $project->users->first()?->pivot->pm_id;
            $hasTeam = $project->users_count > 0;

            return ($hasTeam && ($isAdmin || $isManager) || ($pmProject && $hasTeam));
        });

        Gate::define('manage-sub-tasks', function(User $user, Task $task)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $picTask = $user->id === $task->assigned_to;

            return $isAdmin || $isManager || $picTask;
        });
    }
}
