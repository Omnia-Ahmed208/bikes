<?php

use Illuminate\Support\Facades\Route;


Route::prefix('devices')->group(function () {
    Route::get('/check-all', 'DeviceController@checkAllDevices');
    Route::get('/{hostname}/status', 'DeviceController@getDeviceStatus');
    Route::get('/{hostname}/health', 'DeviceController@getDeviceHealth');
    Route::get('/{hostname}/gps', 'DeviceController@getDeviceGPS');
    Route::get('/{hostname}/battery', 'DeviceController@getDeviceBattery');
    Route::post('/{hostname}/relay', 'DeviceController@controlRelay');



    Route::post('register', 'DeviceController@register');
    Route::post('heartbeat', 'DeviceController@heartbeat');
    Route::get('commands/{device}', 'DeviceController@getCommands');
});
