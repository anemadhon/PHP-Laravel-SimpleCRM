<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientProjectController extends Controller
{
    public function __invoke(Client $client)
    {
        return view('clients.project', [
            'owner' => $client->name,
            'projects' => $client->projects()->with(['state', 'level'])->paginate(4)
        ]);
    }
}
