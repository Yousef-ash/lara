<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class ApiController extends Controller
{
    public function devices(Request $request)
    {
        $user = $request->user();
        $devices = $user->devices;
        return response()->json($devices);
    }

    public function chooseDevice(Request $request)
    {
        $mqtt = MQTT::connection();
        $device = Device::find($request->device_id);
        if (!empty($device)) {
            $mqtt->publish('Esp32/device', $request->device_id);
            return $device->device_name . ' Selected';
        } else {
            return 'There is No Such Device';
        }
    }

    public function sensors(Request $request)
    {
        $device = Device::findOrFail($request->device_id);
        if ($request->user()->id !== $device->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $sensors = $device->sensors()->latest()->take(100)->get();
        $location = $device->location;

        return response()->json(
            $sensors
        );
    }
    public function latestsensor(Request $request)
    {
        $device = Device::findOrFail($request->device_id);
        if ($request->user()->id !== $device->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $sensors = $device->sensors()->latest()->take(1)->get();
        $location = $device->location;
        return response()->json([
            'sensors' => $sensors,
            'location' => $location,
        ]);
    }

    public function status(Request $request)
    {
        $mqtt = MQTT::connection();
        $mqtt->publish('Esp32/status', $request->status);
        if ($request->status == 0) {
            return 'Device Turn Off';
        }
        if ($request->status == 1) {
            return 'Device Turn On';
        }
    }

}
