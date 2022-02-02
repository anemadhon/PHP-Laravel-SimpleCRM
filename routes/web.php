<?php

use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::permanentRedirect('/', 'login');
Route::permanentRedirect('/register', 'login');

Route::group(['middleware' => 'auth'], function()
{
    Route::view('about', 'about')->name('about');

    Route::get('dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => \App\Http\Middleware\IsAdminMiddleware::class
    ], function()
    {
        Route::resource('client/types', \App\Http\Controllers\Admin\ClientTypeController::class)
                ->scoped([
                    'type' => 'slug'
                ])->except(['show', 'destroy']);

        Route::resource('project/states', \App\Http\Controllers\Admin\ProjectStateController::class)
                ->scoped([
                    'state' => 'slug'
                ])->except(['show', 'destroy']);

        Route::resource('levels', \App\Http\Controllers\Admin\LevelController::class)
                ->scoped([
                    'level' => 'slug'
                ])->except(['show', 'destroy']);

        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)
                ->scoped([
                    'role' => 'slug'
                ])->except(['show', 'destroy']);

        Route::resource('skills', \App\Http\Controllers\Admin\SkillController::class)
                ->scoped([
                    'skill' => 'slug'
                ])->except(['show', 'destroy']);
    });

    Route::resource('clients', \App\Http\Controllers\ClientController::class)
            ->scoped([
                'client' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('clients.projects', \App\Http\Controllers\ClientProjectController::class)
            ->scoped([
                'client' => 'slug',
                'project' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('clients.projects.tasks', \App\Http\Controllers\ClientProjectTaskController::class)
            ->scoped([
                'client' => 'slug', 
                'project' => 'slug',
                'task' => 'slug'
            ])->only(['index', 'edit', 'update']);

    Route::get('projects/attachments/review/{file:slug}', [\App\Http\Controllers\ProjectController::class, 'attachment'])
            ->name('projects.files');
            
    Route::resource('projects', \App\Http\Controllers\ProjectController::class)
            ->scoped([
                'project' => 'slug'
            ])->except('destroy');

    Route::resource('projects.teams', \App\Http\Controllers\ProjectTeamController::class)
            ->scoped([
                'project' => 'slug',
            ])->only(['index', 'create', 'store']);

    Route::resource('projects.tasks', \App\Http\Controllers\ProjectTaskController::class)
            ->scoped([
                'project' => 'slug',
                'task' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('tasks', \App\Http\Controllers\TaskController::class)
            ->scoped([
                'task' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('tasks.subs', \App\Http\Controllers\SubTaskController::class)
            ->scoped([
                'task' => 'slug',
                'sub' => 'slug'
            ])->except(['show', 'destroy']);

    Route::group([
        'prefix' => 'users',
        'as' => 'users.'
    ], function()
    {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('{user:username}/projects', [\App\Http\Controllers\UserController::class, 'projects'])->name('projects');
    });

    Route::resource('users.tasks', \App\Http\Controllers\UserTaskController::class)
            ->scoped([
                'user' => 'username',
                'task' => 'slug'
            ])->only(['index', 'edit', 'update']);
    
    Route::get('teams', [\App\Http\Controllers\ProjectTeamController::class, 'index'])->name('teams.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
