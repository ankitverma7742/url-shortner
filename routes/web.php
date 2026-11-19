<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// Public short URL
Route::get('/s/{code}', [RedirectController::class, 'show'])->name('short.redirect');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/invite/{token}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::post('/invite/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:superadmin')->group(function () {
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
        Route::post('/team', [TeamController::class, 'store'])->name('team.store');
    });

    Route::middleware('role:admin,member')->group(function () {
        Route::get('/urls/create', [ShortUrlController::class, 'create'])->name('urls.create');
        Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');
    });
});