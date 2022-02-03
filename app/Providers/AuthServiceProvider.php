<?php

namespace App\Providers;

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
        
        Gate::define('manage-clients', function(User $user)
        {
            return $user->role_id === User::IS_SALES;
        });
        
        Gate::define('manage-teams', function(User $user)
        {
            return $user->role_id === User::IS_PM;
        });
        
        Gate::define('manage-tasks', function(User $user)
        {
            return in_array($user->role_id, User::IS_DEV_TEAM);
        });

        Gate::define('manage-sub-tasks', function(User $user, Task $task)
        {
            $isAdmin = $user->role_id === User::IS_ADMIN;
            $picTask = $user->id === $task->assigned_to;

            return $isAdmin || $picTask;
        });
    }
}
