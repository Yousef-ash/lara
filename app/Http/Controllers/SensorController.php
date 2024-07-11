<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensor = Device::findOrFail(2)->sensors()->latest()->take(1)->first();
        return view('welcome')->with('sensor', $sensor);
    }

    /**
     * Show the form for creating a new resource.
     */
      public function show(string $id)
    {
        $sensors = Device::findOrFail($id)
        ->sensors()
        ->latest()
        ->take(50)
        ->get();
        return view('sensors')->with('sensors', $sensors)->with('device', Device::find($id));
    }


}
