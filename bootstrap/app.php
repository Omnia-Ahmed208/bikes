<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Route::prefix('admin')->middleware('web')
            // ->name('admin.')
            // ->namespace('App\Http\Controllers\Admin')
            // ->group(base_path('routes/admin.php'));

            Route::prefix('api')->middleware('api')
            ->name('api.')
            ->namespace('App\Http\Controllers\Api')
            ->group(base_path('routes/api.php'));

            Route::middleware(['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
                ->namespace('App\Http\Controllers')
                ->prefix(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale())
                ->group(base_path('routes/web.php'));

            Route::middleware(['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
                ->namespace('App\Http\Controllers\Admin')
                // ->prefix(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale()) // ==> after only this make prefix in admin route
                ->prefix(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale() . '/admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localizationRedirect'  => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeViewPath'        => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,

            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guard' => \App\Http\Middleware\GuardMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
