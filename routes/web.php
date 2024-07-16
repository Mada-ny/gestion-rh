<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\DemandeAbsenceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employes', EmployeController::class);
    Route::resource('conges', CongeController::class);
    Route::resource('demandes', DemandeAbsenceController::class);
});

Auth::routes();