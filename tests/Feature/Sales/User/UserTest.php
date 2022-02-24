<?php

namespace Tests\Feature\Sales\User;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ClientType;
use App\Models\ProjectState;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_cannot_edit_the_task_that_is_not_assigned_to_him()
    {
        $role = Role::factory(4)->create();

        $manager = User::factory()->create([
            'role_id' => $role->skip(1)->first()->id
        ]);

        $pm = User::factory()->pm()->create();

        $sales = User::factory()->sales()->create();

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
        
        $task = Task::create([
            'name' => 'Task',
            'slug' => 'task',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $manager->id,
            'state_id' => $state->id,
            'assigned_to' => $pm->id
        ]);

        $response = $this->actingAs($sales)->get("users/{$pm->username}/tasks/{$task->slug}/edit");
        
        $response->assertStatus(403);
        
        $response = $this->actingAs($sales)->put("users/{$pm->username}/tasks/{$task->slug}", [
            'id' => $task->id,
            'name' => 'Task Update', 
            'slug' => 'task-update',
            'level_id' => $level->id,
            'state_id' => $state->id,
            'project_id' => $project->id,
            'assigned_to' => $pm->id,
            'created_by' => $manager->id
        ]);

        $response->assertStatus(403);
    }

    public function test_sales_can_edit_the_task_assigned_to_him()
    {
        $role = Role::factory(4)->create();

        $manager = User::factory()->create([
            'role_id' => $role->skip(1)->first()->id
        ]);

        $sales = User::factory()->sales()->create();

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
        
        $task = Task::create([
            'name' => 'Task',
            'slug' => 'task',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $manager->id,
            'state_id' => $state->id,
            'assigned_to' => $sales->id
        ]);

        $response = $this->actingAs($sales)->get("users/{$sales->username}/tasks/{$task->slug}/edit");
        
        $response->assertStatus(200);
        
        $response = $this->actingAs($sales)->put("users/{$sales->username}/tasks/{$task->slug}", [
            'id' => $task->id,
            'name' => 'Task Update', 
            'slug' => 'task-update',
            'level_id' => $level->id,
            'state_id' => $state->id,
            'project_id' => $project->id,
            'assigned_to' => $sales->id,
            'created_by' => $manager->id
        ]);

        $response->assertRedirect('tasks');
    }
}
