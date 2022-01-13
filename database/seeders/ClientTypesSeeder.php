<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Seeder;

class ClientTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientType::create([
            'name' => 'Individu',
            'description' => 'utk kebutuhan individu',
            'criteria' => 'bukan PT,utk kebutuhan bisnis atau UKMM,fitur terbatas,tidak ada maintenance',
            'slug' => 'individu'
        ]);
        ClientType::create([
            'name' => 'Company',
            'description' => 'utk kebuthan company non grup',
            'criteria' => 'PT,utk kebutuhan operasional,fitur terbatas (custom API),maintenance 1 bulan free,2 bulan berbayar',
            'slug' => 'company'
        ]);
        ClientType::create([
            'name' => 'Big Company',
            'description' => 'utk kebutuhan company ber anak',
            'criteria' => 'PT,utk kebutuhan operasional,fitur tak terbatas,maintenance 3 bulan free',
            'slug' => 'big-company'
        ]);
    }
}
