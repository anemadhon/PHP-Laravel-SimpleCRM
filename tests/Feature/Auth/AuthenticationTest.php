<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_screen_redirect_permanently_to_login_screen()
    {
        $response = $this->get('/');

        $response->assertRedirect('login');
    }
    
    public function test_registration_screen_redirect_permanently_to_login_screen()
    {
        $response = $this->get('/register');

        $response->assertRedirect('login');
    }

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen_by_username()
    {
        $role = Role::factory()->create();

        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'userlogin' => $user->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
    
    public function test_users_can_authenticate_using_the_login_screen_by_email()
    {
        $role = Role::factory()->create();

        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'userlogin' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_username_or_email()
    {
        $this->post('/login', [
            'userlogin' => 'wrong-username-or-email',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $role = Role::factory()->create();

        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $this->post('/login', [
            'userlogin' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
