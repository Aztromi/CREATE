<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    //

    public function clearRoute()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('route:clear');
    }
}
