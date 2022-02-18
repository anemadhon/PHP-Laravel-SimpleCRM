<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogService
{
    public function store(array $data)
    {
        DB::table('logs')->insert($data);
    }

    public function file(string $channel, array $data)
    {
        switch ($channel) {
            case 'gate':
                Log::channel($channel)->critical(json_encode($data));
                break;
            
            case 'error':
                Log::channel($channel)->error(json_encode($data));
                break;
            
            default:
                Log::channel($channel)->info(json_encode($data));
                break;
        }
    }
}
