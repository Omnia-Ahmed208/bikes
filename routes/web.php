<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin', function () {
    return redirect('/admin/login');
});


Route::get('/', function () {
    return redirect('/client/login');
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/login', 'Client\AuthController@index')->name('login');
    Route::post('/login', 'Client\AuthController@login')->name('login.post');

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout','Client\AuthController@logout')->name('logout');

        Route::get('dashboard', 'Client\DashboardController@index')->name('dashboard');

        Route::get('/ajax/get/regions', 'Client\CampaignController@getRegions');
        Route::get('campaigns/live', 'Client\CampaignController@campaigns_live')->name('campaigns.live');
        Route::resource('campaigns', 'Client\CampaignController');
    });
});
