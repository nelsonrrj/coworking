<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'isAdmin'])->prefix('offices')->group(function () {
    Route::get('/', [OfficeController::class, 'index'])
        ->withoutMiddleware('isAdmin')
        ->name('office.index');

    Route::post('/', [OfficeController::class, 'store'])->name('office.store');

    Route::put('/{officeId}', [OfficeController::class, 'update'])
        ->name('office.update');

    Route::delete('/{officeId}', [OfficeController::class, 'destroy'])
        ->name('office.update');
});

Route::middleware(['auth'])->prefix('reservations')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservation.index');
    Route::post('/', [ReservationController::class, 'store'])->name('reservation.store');
    Route::put('/{reservationId}', [ReservationController::class, 'update'])
        ->middleware('isAdmin')
        ->name('reservation.update');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'listByAdmin'])
        ->name('admin.reservation.list');
});

require __DIR__ . '/auth.php';
