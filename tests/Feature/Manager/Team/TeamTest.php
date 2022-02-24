<?php

namespace Tests\Feature\Manager\Team;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_view_team_lists()
    {
        $role = Role::factory(2)->create();
        
        $manager = User::factory()->create([
            'role_id' => $role->last()->id
        ]);
        
        $response = $this->actingAs($manager)->get('teams');

        $response->assertStatus(200);
    }
}
