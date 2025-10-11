<?php

namespace App\Http\Controllers;

use App\Models\{Station, SensorData, Sensor};

class DashboardController extends Controller {
    public function index(){
        $stations = Station::with('city')->orderBy('name')->get();
        $sensorsOnline = Sensor::where('status', true)->count();
        $lastSync = SensorData::max('created_at');
        $dbDriver = strtoupper(config('database.default'));
        return view('dashboard', compact('stations','sensorsOnline','lastSync','dbDriver'));
    }
}