<?php

namespace Tests\Feature\Manager\Project;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ClientType;
use App\Models\ProjectState;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_view_project_lists()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);
        
        $response = $this->actingAs($manager)->get('projects');

        $response->assertStatus(200);
    }

    public function test_manager_can_add_new_project()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);

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

        $response = $this->actingAs($manager)->get('projects/create');

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->post('projects', [
            'name' => 'Apps',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        $response->assertRedirect('projects');
    }
    
    public function test_manager_can_edit_project()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);

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

        $response = $this->actingAs($manager)->get("projects/{$project->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->put("projects/{$project->slug}", [
            'name' => 'Apps Update',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps-update',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        $response->assertRedirect('projects');
    }
}
