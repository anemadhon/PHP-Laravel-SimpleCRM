<?php

namespace Database\Seeders;

use App\Models\ProjectState;
use Illuminate\Database\Seeder;

class ProjectStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectState::create([
            'name' => 'Bid',
            'description' => 'proses tender',
            'for' => 'non',
            'slug' => 'bid'
        ]);
        ProjectState::create([
            'name' => 'Open',
            'description' => 'setelah bidding, project baru mulai pengembangan',
            'for' => 'dev',
            'slug' => 'open'
        ]);
        ProjectState::create([
            'name' => 'Development',
            'description' => 'proses development',
            'for' => 'dev',
            'slug' => 'development'
        ]);
        ProjectState::create([
            'name' => 'Test',
            'description' => 'setelah development, proses testing',
            'for' => 'dev',
            'slug' => 'test'
        ]);
        ProjectState::create([
            'name' => 'Live',
            'description' => 'project sudah di deliver ke client dan sudah live',
            'for' => 'non',
            'slug' => 'live'
        ]);
        ProjectState::create([
            'name' => 'Guarantee',
            'description' => 'project dalam masa garansi',
            'for' => 'non',
            'slug' => 'guarantee'
        ]);
        ProjectState::create([
            'name' => 'Close',
            'description' => 'proses sudah selesai, sudah paid, sudah semua',
            'for' => 'non',
            'slug' => 'close'
        ]);
    }
}
