<?php

namespace Tests\Feature\Manager\Task;

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

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_view_tasks_lists()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);
        
        $response = $this->actingAs($manager)->get('tasks');

        $response->assertStatus(200);
    }

    public function test_manager_can_add_new_task()
    {
        $role = Role::factory(3)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->skip(1)->first()->id
        ]);

        $pm = User::factory()->pm()->create();

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

        $response = $this->actingAs($manager)->get('tasks/create');

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->post('tasks', [
            'name' => 'Task',
            'slug' => 'task',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $manager->id,
            'state_id' => $state->id,
            'assigned_to' => $pm->id
        ]);

        $response->assertRedirect('tasks');
    }
    
    public function test_manager_can_edit_task()
    {
        $role = Role::factory(3)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->skip(1)->first()->id
        ]);

        $pm = User::factory()->pm()->create();

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

        $response = $this->actingAs($manager)->get("tasks/{$task->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->put("tasks/{$task->slug}", [
            'name' => 'Task Update',
            'slug' => 'task-update',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $manager->id,
            'state_id' => $state->id,
            'assigned_to' => $pm->id
        ]);

        $response->assertRedirect('tasks');
    }
}
