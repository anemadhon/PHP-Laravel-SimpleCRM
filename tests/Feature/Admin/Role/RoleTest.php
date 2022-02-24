<?php

namespace Tests\Feature\Admin\Role;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_role_lists()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);
        
        $response = $this->actingAs($admin)->get('admin/roles');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_new_role()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get('admin/roles/create');

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('admin/roles', [
            'name' => 'Business Analyst',
            'description' => 'Analize the business of the project',
            'slug' => 'business-analyst'
        ]);

        $response->assertRedirect('admin/roles');
    }
    
    public function test_admin_can_edit_role()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get("admin/roles/{$role->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put("admin/roles/{$role->slug}", [
            'name' => 'Administrator Update',
            'description' => 'Admin',
            'slug' => 'administrator-update'
        ]);

        $response->assertRedirect('admin/roles');
    }
}
