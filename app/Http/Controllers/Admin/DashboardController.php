<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        return view('admin.dashboard.index', [

            'stats' => [

                'students'  => 0,
                'teachers'  => 0,
                'classes'   => 0,
                'subjects'  => 0,
                'exams'     => 0,
                'results'   => 0,
                'contacts'  => 0,
                'admins'    => 1,

            ]

        ]);
    }
}
