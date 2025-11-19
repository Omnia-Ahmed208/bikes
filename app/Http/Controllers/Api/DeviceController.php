<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string|unique:devices,device_id',
            'hostname' => 'required|string',
            'ip_address' => 'required|ip',
            'ssh_tunnel_active' => 'required|boolean',
        ]);

        // $device = Device::updateOrCreate(
        //     ['device_id' => $data['device_id']],
        //     $data + ['status' => 'online']
        // );

        return response()->json([
            'status' => 'success',
            'message' => 'Device registered successfully',
            'device' => $data
            // 'device' => $device
        ]);
    }

    public function status()
    {
        $total = Device::count();
        $online = Device::where('status', 'online')->count();
        $offline = $total - $online;

        return response()->json([
            'total' => $total,
            'online' => $online,
            'offline' => $offline,
            'devices' => Device::all()
        ]);
    }
}
