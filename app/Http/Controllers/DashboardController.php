<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Station;
use App\Models\SensorData;
use App\Models\Sensor;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic metrics
        $stations = Station::with('city')->orderBy('name')->get();
        $sensorsOnline = Sensor::where('status', true)->count();
        $lastSync = SensorData::max('created_at');
        $dbDriver = strtoupper(config('database.default'));

        return view('dashboard', compact('stations','sensorsOnline','lastSync','dbDriver'));
    }
}