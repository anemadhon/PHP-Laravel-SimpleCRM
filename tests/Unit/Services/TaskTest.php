<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ClientType;
use App\Models\ProjectState;
use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_task_lists_for_pm()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();

        $qa = User::factory()->sales()->create();

        $state = ProjectState::create([
            'name' => 'Development',
            'description' => 'On Development',
            'for' => 'dev',
            'slug' => 'development',
        ]);

        $level = Level::create([
            'name' => 'Low',
            'slug' => 'low'
        ]);

        $type = ClientType::create([
            'name' => 'Company',
            'description' => 'For Company',
            'criteria' => 'PT, Custom',
            'slug' => 'company',
        ]);

        $client = Client::create([
            'name' => 'BTN',
            'description' => 'Bank Tabungan Indonesia',
            'slug' => 'low',
            'type_id' => $type->id
        ]);

        $project = Project::create([
            'name' => 'Apps',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        Task::create([
            'name' => 'Task',
            'slug' => 'task',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $pm->id,
            'state_id' => $state->id,
            'assigned_to' => $qa->id
        ]);

        DB::table('project_user')->insert([
            'project_id' => $project->id,
            'user_id' => $pm->id,
            'pm_id' => $pm->id,
            'status' => 1 
        ]);
        
        DB::table('project_user')->insert([
            'project_id' => $project->id,
            'user_id' => $qa->id,
            'pm_id' => $pm->id,
            'status' => 1 
        ]);

        $tasks = (new TaskService())->lists($pm);

        $this->assertIsObject($tasks['team_tasks']);
    }
    
    public function test_get_task_lists_for_other_except_pm()
    {
        Role::factory(6)->create();

        $sales = User::factory()->create([
            'role_id' => 2
        ]);

        $tasks = (new TaskService())->lists($sales);

        $this->assertEquals(null, $tasks['team_tasks']);
    }
}
