<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrator',
            'description' => 'Can manage all features',
            'slug' => 'administrator'
        ]);
        Role::create([
            'name' => 'Manager',
            'description' => 'Can manage clients, projects, teams and tasks',
            'slug' => 'manager'
        ]);
        Role::create([
            'name' => 'Project Manager',
            'description' => 'Can manage the project, teams, tasks and sub tasks he leads',
            'slug' => 'project-manager'
        ]);
        Role::create([
            'name' => 'Pre Sales',
            'description' => 'Can manage clients and projects',
            'slug' => 'pre-sales'
        ]);
        Role::create([
            'name' => 'Developer',
            'description' => 'Can manage his tasks and manage sub tasks',
            'slug' => 'developer'
        ]);
        Role::create([
            'name' => 'Quality Assurance',
            'description' => 'Can manage his tasks and manage sub tasks',
            'slug' => 'quality-assurance'
        ]);
    }
}
