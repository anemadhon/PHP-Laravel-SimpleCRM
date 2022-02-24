<?php

namespace Tests\Feature\DevTeam\Client;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_pm_developer_qa_cannot_view_client_lists()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory()->developer()->create();
        $qa = User::factory()->qa()->create();
        
        $response = $this->actingAs($pm)->get('clients');

        $response->assertStatus(403);
        
        $response = $this->actingAs($dev)->get('clients');

        $response->assertStatus(403);
        
        $response = $this->actingAs($qa)->get('clients');

        $response->assertStatus(403);
    }
}
