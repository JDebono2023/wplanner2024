<?php

use Filament\Pages\Dashboard;
use Filament\Facades\Filament;

use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/', Login::class)
//     ->middleware('guest');

Route::get('/', function () {
    // Check if the user is authenticated
    if (auth()->check()) {
        // Redirect authenticated users to the Filament dashboard
        return redirect(Filament::getHomeUrl());
    }

    // Redirect guests to the Filament login page
    return redirect(Filament::getLoginUrl());
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Route::get('/wplanner', Dashboard::class)->name('filament.wplanner.pages.dashboard');
});
