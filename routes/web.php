<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\DemandeAbsenceController;
use App\Http\Controllers\CongeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes Employés
    Route::middleware(['role:employe,drh,directeur'])->group(function () {
        Route::get('/profile', [EmployeController::class, 'profile'])->name('profile');
        Route::put('/profile', [EmployeController::class, 'updateProfile'])->name('profile.update');
        Route::resource('demande-absences', DemandeAbsenceController::class)->only(['index', 'create', 'store']);
    });

    // Routes DRH
    Route::middleware(['role:drh'])->group(function () {
        Route::resource('employes', EmployeController::class);
        Route::get('/employes/export', [EmployeController::class, 'export'])->name('employes.export');
    });

    // Routes directeur
    Route::middleware(['role:directeur'])->group(function () {
        Route::put('/demande-absences/{demandeAbsence}/approve', [DemandeAbsenceController::class, 'approve'])->name('demande-absences.approve');
        Route::put('/demande-absences/{demandeAbsence}/reject', [DemandeAbsenceController::class, 'reject'])->name('demande-absences.reject');
    });
});