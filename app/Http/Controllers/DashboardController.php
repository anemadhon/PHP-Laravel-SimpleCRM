<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $isPM = auth()->user()->role_id === User::IS_PM;
        $isDevTeam = in_array(auth()->user()->role_id, User::IS_DEV_TEAM);

        return view('dashboard', [
            'dashboard' => (new DashboardService())->statistic(auth()->user()->role_id),
            'your_projects' => ($isPM || $isDevTeam) ? auth()->user()->projects : null,
            'your_tasks' => ($isPM || $isDevTeam) ? auth()->user()->tasks : null
        ]);
    }
}
