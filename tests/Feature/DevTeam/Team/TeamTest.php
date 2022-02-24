<?php

namespace Tests\Feature\DevTeam\Team;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_pm_developer_qa_cannot_view_client_lists()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory()->developer()->create();
        $qa = User::factory()->qa()->create();
        
        $response = $this->actingAs($pm)->get('teams');

        $response->assertStatus(403);
        
        $response = $this->actingAs($dev)->get('teams');

        $response->assertStatus(403);
        
        $response = $this->actingAs($qa)->get('teams');

        $response->assertStatus(403);
    }
}
