<?php

namespace Tests\Feature\Admin\Skill;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkillTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_skill_lists()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);
        
        $response = $this->actingAs($admin)->get('admin/skills');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_new_skill()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get('admin/skills/create');

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('admin/skills', [
            'name' => 'ABAP',
            'slug' => 'abap'
        ]);

        $response->assertRedirect('admin/skills');
    }
    
    public function test_admin_can_edit_skill()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $skill = Skill::create([
            'name' => 'ABAP',
            'slug' => 'abap'
        ]);

        $response = $this->actingAs($admin)->get("admin/skills/{$skill->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put("admin/skills/{$skill->slug}", [
            'name' => 'ABAP Update',
            'slug' => 'abap-update'
        ]);

        $response->assertRedirect('admin/skills');
    }
}
