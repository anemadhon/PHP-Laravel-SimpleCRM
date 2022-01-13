<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class levelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'name' => 'Low',
            'slug' => 'low'
        ]);
        Level::create([
            'name' => 'Medium',
            'slug' => 'medium'
        ]);
        Level::create([
            'name' => 'High',
            'slug' => 'high'
        ]);
        Level::create([
            'name' => 'Priority',
            'slug' => 'priority'
        ]);
    }
}
