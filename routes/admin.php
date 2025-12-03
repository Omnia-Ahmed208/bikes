<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login')->name('login.post');

Route::middleware(['guard:admin'])->group(function ()
{
    Route::post('/logout','AuthController@logout')->name('logout');

    // routes/web.php
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('users', 'UserController');

    // ads or campaigns
    Route::post('campaigns/{id}/accept', 'CampaignController@campaigns_accept')->name('campaigns.accept');
    Route::post('campaigns/{id}/reject', 'CampaignController@campaigns_reject')->name('campaigns.reject');
    Route::get('campaigns/review', 'CampaignController@campaigns_review')->name('campaigns.review');
    Route::get('campaigns/export', 'CampaignController@campaigns_export')->name('campaigns.export');
    Route::resource('campaigns', 'CampaignController');
});
