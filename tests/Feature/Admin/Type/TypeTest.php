<?php

namespace Tests\Feature\Admin\Type;

use App\Models\ClientType;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_client_type_lists()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);
        
        $response = $this->actingAs($admin)->get('admin/client/types');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_new_client_type()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($admin)->get('admin/client/types/create');

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('admin/client/types', [
            'name' => 'Solo',
            'slug' => 'solo',
            'description' => 'Solo',
            'criteria' => 'Solo, Alone'
        ]);

        $response->assertRedirect('admin/client/types');
    }
    
    public function test_admin_can_edit_client_type()
    {
        $role = Role::factory()->create();

        $admin = User::factory()->create([
            'role_id' => $role->id
        ]);

        $type = ClientType::create([
            'name' => 'Solo',
            'slug' => 'solo',
            'description' => 'Solo',
            'criteria' => 'Solo, Alone'
        ]);

        $response = $this->actingAs($admin)->get("admin/client/types/{$type->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put("admin/client/types/{$type->slug}", [
            'name' => 'Solo Leveling',
            'slug' => 'solo-leveling',
            'description' => 'Solo Leveling',
            'criteria' => 'Solo, Alone, Level'
        ]);

        $response->assertRedirect('admin/client/types');
    }
}
