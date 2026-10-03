<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('resident.dashboard');
    }
}