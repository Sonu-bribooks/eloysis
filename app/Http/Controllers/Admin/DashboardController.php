<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => $this->dashboardService->stats(),
        ]);
    }
   
}
