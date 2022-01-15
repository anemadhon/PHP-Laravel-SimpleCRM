<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientProjectController extends Controller
{
    public function __invoke(string $slug)
    {
        $client = Client::with(['projects'])->where('slug', $slug)->firstOrFail();
        
        return view('clients.project', [
            'owner' => $client->name,
            'projects' => $client->projects()->with(['state', 'level'])->paginate(4)
        ]);
    }
}
