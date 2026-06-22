<?php

use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\SportTypeController as AdminSportTypeController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FieldController::class, 'index'])->name('home');
Route::get('/canchas', [FieldController::class, 'index'])->name('fields.index');
Route::get('/canchas/{field}', [FieldController::class, 'show'])->name('fields.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mis-reservas', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/canchas/{field}/reservar', [ReservationController::class, 'store'])->name('reservations.store');
    Route::patch('/reservas/{reservation}/cancelar', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sport-types', AdminSportTypeController::class)->except('show');
    Route::resource('venues', AdminVenueController::class)->except('show');
    Route::resource('fields', AdminFieldController::class)->except('show');

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::patch('reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::patch('reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('ocupacion', [AdminReservationController::class, 'occupancy'])->name('occupancy');
});

require __DIR__.'/auth.php';