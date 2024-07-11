<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Device::create([
            'device_name' => $request->name,
            'location' => $request->location,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = Device::findOrFail($id);
        return view('edit')->with('device', $device);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Device::findOrFail($id)->update([
            'device_name' => $request->name,
            'location' => $request->location,
        ]);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device =Device::findOrFail($id);
        if (!empty($device->sensors)) {
            $device->sensors()->delete();
        }
        $device->delete();

        return redirect()->route('dashboard');
    }
}
