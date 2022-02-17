<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LogService
{
    public function store(array $data)
    {
        DB::table('logs')->insert($data);
    }
}
