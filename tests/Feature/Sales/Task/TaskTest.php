<?php

namespace Tests\Feature\Sales\Task;

use Tests\TestCase;
use App\Models\Role;
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

    public function test_sales_cannot_add_new_task()
    {
        Role::factory(6)->create();
        
        $sales = User::factory()->sales()->create();

        $qa = User::factory()->qa()->create();

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

        $response = $this->actingAs($sales)->get('tasks/create');

        $response->assertStatus(403);

        $response = $this->actingAs($sales)->post('tasks', [
            'name' => 'Task',
            'slug' => 'task',
            'level_id' => $level->id,
            'project_id' => $project->id,
            'created_by' => $sales->id,
            'state_id' => $state->id,
            'assigned_to' => $qa->id
        ]);

        $response->assertStatus(403);
    }
}
