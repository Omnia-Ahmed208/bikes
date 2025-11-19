<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    private $serverIP = 'pi-api.isky.ae';
    private $apiToken = '9b674a368c7b3aae3aaf6fdb4ff23f11a6c6cdabd8861d0b9eff0a146f832c0d';
    private $timeout = 10; // seconds

    /**
     * Display device management dashboard
     */
    public function index()
    {
        $devices = $this->getDeviceRegistry();
        return view('backend.device', compact('devices'));
    }

    /**
     * Get all registered devices from server
     */
    public function getDeviceRegistry()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get("http://{$this->serverIP}:8080/dm-isky-backend/api/device-registry.php");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'Failed to connect to server', 'devices' => []];
        } catch (\Exception $e) {
            Log::error('Device registry error: ' . $e->getMessage());
            return ['error' => $e->getMessage(), 'devices' => []];
        }
    }

    /**
     * Get specific device by hostname
     */
    public function getDevice($hostname)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get("http://{$this->serverIP}:8080/dm-isky-backend/api/get-device.php", [
                    'hostname' => $hostname
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Device not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error("Get device error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get device status from device directly
     */
    public function getDeviceStatus($hostname)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Token' => $this->apiToken])
                ->get("http://{$hostname}.local:8080/dm-isky/status");

            if ($response->successful()) {
                $statusData = $response->json();
                return response()->json([
                    'success' => true,
                    'hostname' => $hostname,
                    'device_name' => $statusData['device_name'] ?? $hostname,
                    'location' => $statusData['location'] ?? 'Unknown',
                    'current_ip' => $statusData['ip_address'] ?? 'Unknown',
                    'ssh_tunnel' => $statusData['ssh_tunnel_status'] ?? 'Unknown',
                    'uptime' => $statusData['uptime'] ?? 'Unknown',
                    'memory_usage' => $statusData['memory_usage'] ?? null,
                    'cpu_usage' => $statusData['cpu_usage'] ?? null,
                    'disk_usage' => $statusData['disk_usage'] ?? null,
                    'modules' => $statusData['modules'] ?? [],
                    'gps' => $statusData['gps'] ?? null,
                    'battery' => $statusData['battery'] ?? null
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Device not responding'
            ], 503);
        } catch (\Exception $e) {
            Log::error("Device status error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Device offline or unreachable'
            ], 503);
        }
    }

    /**
     * Get device health check (no auth required)
     */
    public function getDeviceHealth($hostname)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get("http://{$hostname}.local:8080/dm-isky/health");

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Health check failed'
            ], 503);
        } catch (\Exception $e) {
            Log::error("Device health error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Device unreachable'
            ], 503);
        }
    }

    /**
     * Get GPS location from device
     */
    public function getDeviceGPS($hostname)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Token' => $this->apiToken])
                ->get("http://{$hostname}.local:8080/dm-isky/gps");

            if ($response->successful()) {
                $gpsData = $response->json();
                return response()->json([
                    'success' => true,
                    'hostname' => $hostname,
                    'lat' => $gpsData['latitude'] ?? 'N/A',
                    'lon' => $gpsData['longitude'] ?? 'N/A',
                    'altitude' => $gpsData['altitude'] ?? 'N/A',
                    'speed' => $gpsData['speed'] ?? 'N/A',
                    'satellites' => $gpsData['satellites'] ?? 'N/A',
                    'timestamp' => $gpsData['timestamp'] ?? now()->toISOString()
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'GPS not available'
            ], 503);
        } catch (\Exception $e) {
            Log::error("GPS error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'GPS service unreachable'
            ], 503);
        }
    }

    /**
     * Control device relay
     */
    public function controlRelay(Request $request, $hostname)
    {
        $request->validate([
            'action' => 'required|in:on,off'
        ]);

        try {
            $action = $request->input('action');
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Token' => $this->apiToken])
                ->post("http://{$hostname}.local:8080/dm-isky/relay/{$action}");

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => "Relay turned {$action} successfully",
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Relay control failed'
            ], 503);
        } catch (\Exception $e) {
            Log::error("Relay control error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Device unreachable'
            ], 503);
        }
    }

    /**
     * Check multiple devices status
     */
    public function checkAllDevices()
    {
        $registry = $this->getDeviceRegistry();
        $results = [];

        if (isset($registry['devices']) && is_array($registry['devices'])) {
            foreach ($registry['devices'] as $deviceId => $deviceInfo) {
                $hostname = $deviceInfo['hostname'] ?? $deviceId;

                // Try health check first (faster, no auth)
                try {
                    $response = Http::timeout(5)
                        ->get("http://{$hostname}.local:8080/dm-isky/health");

                    $results[$hostname] = [
                        'hostname' => $hostname,
                        'status' => $response->successful() ? 'online' : 'offline',
                        'current_ip' => $deviceInfo['current_ip'] ?? 'unknown',
                        'last_seen' => $deviceInfo['last_seen'] ?? null,
                        'ssh_tunnel' => $deviceInfo['ssh_tunnel_status'] ?? 'unknown',
                        'response_time' => $response->transferStats?->getTransferTime() ?? null
                    ];
                } catch (\Exception $e) {
                    $results[$hostname] = [
                        'hostname' => $hostname,
                        'status' => 'offline',
                        'current_ip' => $deviceInfo['current_ip'] ?? 'unknown',
                        'last_seen' => $deviceInfo['last_seen'] ?? null,
                        'ssh_tunnel' => $deviceInfo['ssh_tunnel_status'] ?? 'unknown',
                        'error' => $e->getMessage()
                    ];
                }
            }
        }

        $onlineCount = count(array_filter($results, fn($d) => $d['status'] === 'online'));
        $serverStatus = empty($registry['error']) ? 'online' : 'offline';

        return response()->json([
            'success' => true,
            'server_status' => $serverStatus,
            'total_devices' => count($results),
            'online_devices' => $onlineCount,
            'offline_devices' => count($results) - $onlineCount,
            'devices' => $results,
            'registry_error' => $registry['error'] ?? null
        ]);
    }

    /**
     * Get device battery status
     */
    public function getDeviceBattery($hostname)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-Token' => $this->apiToken])
                ->get("http://{$hostname}.local:8080/dm-isky/battery");

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Battery status not available'
            ], 503);
        } catch (\Exception $e) {
            Log::error("Battery status error for {$hostname}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Device unreachable'
            ], 503);
        }
    }
}
