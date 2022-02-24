<?php

namespace Tests\Feature\Manager\Client;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_view_client_lists()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);
        
        $response = $this->actingAs($manager)->get('clients');

        $response->assertStatus(200);
    }

    public function test_manager_can_add_new_client()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);

        $type = ClientType::create([
            'name' => 'Solo',
            'slug' => 'solo',
            'description' => 'Solo',
            'criteria' => 'Solo, Alone'
        ]);

        $response = $this->actingAs($manager)->get('clients/create');

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->post('clients', [
            'name' => 'Urgent',
            'slug' => 'urgent',
            'description' => 'Urgently',
            'type_id' => $type->id
        ]);

        $response->assertRedirect('clients');
    }
    
    public function test_manager_can_edit_client()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);

        $type = ClientType::create([
            'name' => 'Solo',
            'slug' => 'solo',
            'description' => 'Solo',
            'criteria' => 'Solo, Alone'
        ]);

        $client = Client::create([
            'name' => 'Urgent',
            'slug' => 'urgent',
            'description' => 'Urgently',
            'type_id' => $type->id
        ]);

        $response = $this->actingAs($manager)->get("clients/{$client->slug}/edit");

        $response->assertStatus(200);

        $response = $this->actingAs($manager)->put("clients/{$client->slug}", [
            'name' => 'Urgent Update',
            'slug' => 'urgent-update',
            'description' => 'Urgently',
            'type_id' => $type->id
        ]);

        $response->assertRedirect('clients');
    }
}
