<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@min.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);
        
        User::factory()->create([
            'name' => 'Manager',
            'username' => 'mgr_',
            'email' => 'mgr@mgr.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);
        
        User::factory(6)->pm()->create();
        
        User::factory(3)->sales()->create();
        
        User::factory(15)->developer()->create();
        
        User::factory(5)->qa()->create();
    }
}
