<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandeAbsenceController;
use App\Http\Controllers\CongeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/demande-absences', [DemandeAbsenceController::class, 'index'])->name('demande-absences.index');
    Route::post('/demande-absences', [DemandeAbsenceController::class, 'store'])->name('demande-absences.store');
    Route::get('/demande-absences/create', [DemandeAbsenceController::class, 'create'])->name('demande-absences.create');

    Route::resource('conges', CongeController::class);

    Route::middleware(['role:directeur'])->group(function () {
        Route::put('/demande-absences/{demandeAbsence}/approve', [DemandeAbsenceController::class, 'approve'])->name('demande-absences.approve');
        Route::put('/demande-absences/{demandeAbsence}/reject', [DemandeAbsenceController::class, 'reject'])->name('demande-absences.reject');
    });
});

require __DIR__.'/auth.php';