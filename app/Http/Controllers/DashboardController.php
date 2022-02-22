<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $isPM = auth()->user()->can('manage-products');
        $isSales = auth()->user()->can('sale-products');
        $isDevTeam = auth()->user()->can('develop-products');

        return view('dashboard', [
            'dashboard' => !$isDevTeam ? (new DashboardService())->statistic(auth()->user()->role_id) : null,
            'your_projects' => ($isPM || $isDevTeam) ? auth()->user()->projects : (auth()->user()->can('manage-department') ? Project::all(['name'])->take(7) : null),
            'your_tasks' => ($isPM || $isDevTeam || $isSales) ? auth()->user()->tasks : null,
            'your_skills' => auth()->user()->cannot('manage-apps') ? auth()->user()->skills : null
        ]);
    }
}
