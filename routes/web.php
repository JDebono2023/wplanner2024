<?php

use Filament\Pages\Auth\Login;
use Filament\Pages\Dashboard;

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
        return redirect()->route('filament.wplanner.pages.dashboard');
    }

    // Show the login page for guests
    return app(Login::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/wplanner', Dashboard::class)->name('filament.wplanner.pages.dashboard');
});
