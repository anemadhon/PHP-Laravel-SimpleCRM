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
        
        Gate::define('create-clients', function(User $user)
        {
            return $user->role_id === User::IS_SALES;
        });
        
        Gate::define('create-teams', function(User $user)
        {
            return $user->role_id === User::IS_PM;
        });
        
        Gate::define('create-tasks', function(User $user)
        {
            return in_array($user->role_id, User::IS_DEV_TEAM);
        });
        
        Gate::define('create-project-teams', function(User $user, Project $project)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;

            return (($isAdmin || $isManager) && $project->load('users')->users->count() === 0);
        });
        
        Gate::define('manage-project-tasks', function(User $user, Project $project)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $isManager = $user->role_id === User::IS_MGR;
            $isPM = $user->role_id === User::IS_PM;
            $pmProject = $project->users()->first()->pivot->pm_id;

            return (($isAdmin || $isManager || $isPM) && ($pmProject && $project->users->count() > 0));
        });

        Gate::define('manage-sub-tasks', function(User $user, Task $task)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $picTask = $user->id === $task->assigned_to;

            return $isAdmin || $picTask;
        });
    }
}
