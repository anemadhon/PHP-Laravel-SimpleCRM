<?php

namespace Tests\Feature\Admin\Level;

use App\Models\Level;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LevelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_level_lists()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);
        
        $response = $this->actingAs($admin)->get('admin/levels');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_new_level()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get('admin/levels/create');

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('admin/levels', [
            'name' => 'High',
            'slug' => 'high'
        ]);

        $response->assertRedirect('admin/levels');
    }
    
    public function test_admin_can_edit_level()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $level = Level::create([
            'name' => 'High',
            'slug' => 'high'
        ]);

        $response = $this->actingAs($admin)->get("admin/levels/{$level->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put("admin/levels/{$level->slug}", [
            'name' => 'High Update',
            'slug' => 'high-update'
        ]);

        $response->assertRedirect('admin/levels');
    }
}
