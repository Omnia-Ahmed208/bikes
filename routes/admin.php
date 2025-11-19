<?php

use App\Http\Controllers\Admin\DeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['web'])->group(function ()
{
    Route::get('/login', function () {
        return view('backend.auth.login');
    })->name('login');

    Route::post('/login','AuthController@login')->name('login.post');
    Route::post('/logout','AuthController@logout')->name('logout');

    // routes/web.php
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('users', 'UserController');
});


// Device Management Routes
Route::prefix('devices')->name('devices.')->group(function () {
    // Web dashboard
    Route::get('/', [DeviceController::class, 'index'])->name('index');

    // API routes for AJAX calls
    Route::get('/registry', [DeviceController::class, 'getDeviceRegistry'])->name('registry');
    Route::get('/check-all', [DeviceController::class, 'checkAllDevices'])->name('check.all');
    Route::get('/{hostname}', [DeviceController::class, 'getDevice'])->name('get');
    Route::get('/{hostname}/status', [DeviceController::class, 'getDeviceStatus'])->name('status');
    Route::get('/{hostname}/health', [DeviceController::class, 'getDeviceHealth'])->name('health');
    Route::get('/{hostname}/gps', [DeviceController::class, 'getDeviceGPS'])->name('gps');
    Route::get('/{hostname}/battery', [DeviceController::class, 'getDeviceBattery'])->name('battery');
    Route::post('/{hostname}/relay', [DeviceController::class, 'controlRelay'])->name('relay');
});

// 
