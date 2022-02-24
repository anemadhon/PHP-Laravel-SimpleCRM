<?php

namespace Tests\Feature\Admin\State;

use App\Models\ProjectState;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_project_state_lists()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);
        
        $response = $this->actingAs($admin)->get('admin/project/states');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_new_project_state()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get('admin/project/states/create');

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('admin/project/states', [
            'name' => 'Urgent',
            'slug' => 'urgent',
            'description' => 'Urgently',
            'for' => 'dev'
        ]);

        $response->assertRedirect('admin/project/states');
    }
    
    public function test_admin_can_edit_project_state()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $state = ProjectState::create([
            'name' => 'Urgent',
            'slug' => 'urgent',
            'description' => 'Urgently',
            'for' => 'dev'
        ]);

        $response = $this->actingAs($admin)->get("admin/project/states/{$state->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put("admin/project/states/{$state->slug}", [
            'name' => 'Urgent Update',
            'slug' => 'urgent-update',
            'description' => 'Urgent',
            'for' => 'dev'
        ]);

        $response->assertRedirect('admin/project/states');
    }
}
