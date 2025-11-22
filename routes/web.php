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

Route::prefix('client')->group(function () {
    Route::get('/login', 'Client\AuthController@index')->name('client.login');
    Route::post('/login', 'Client\AuthController@login')->name('client.login.post');

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout','Client\AuthController@logout')->name('client.logout');

        Route::get('dashboard', 'Client\DashboardController@index')->name('client.dashboard');
    });
});
