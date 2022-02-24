<?php

namespace Tests\Feature\DevTeam\User;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_pm_developer_qa_cannot_view_user_lists()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory()->developer()->create();
        $qa = User::factory()->qa()->create();
        
        $response = $this->actingAs($pm)->get('users');

        $response->assertStatus(403);
        
        $response = $this->actingAs($dev)->get('users');

        $response->assertStatus(403);
        
        $response = $this->actingAs($qa)->get('users');

        $response->assertStatus(403);
    }
}
