<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('settings', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('settings/save-hero', [SettingsController::class, 'saveHero'])->name('settings.save-hero');
    });
