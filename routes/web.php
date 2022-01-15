<?php

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

    Route::get('clients/{client:slug}/projects', \App\Http\Controllers\ClientProjectController::class)
            ->name('client.projects');

    Route::resource('clients', \App\Http\Controllers\ClientController::class)
            ->scoped([
                'client' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('projects', \App\Http\Controllers\ProjectController::class)
            ->scoped([
                'project' => 'slug'
            ])->except(['show', 'destroy']);

    Route::resource('tasks', \App\Http\Controllers\TaskController::class)
            ->scoped([
                'task' => 'slug'
            ])->except(['show', 'destroy']);
    
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user:username}/projects', [\App\Http\Controllers\UserController::class, 'projects'])->name('users.projects');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
