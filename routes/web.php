<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employes', EmployeController::class);
    Route::resource('absences', AbsenceController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('conges', CongeController::class);
    
    Route::post('/absences/{absence}/approve', [AbsenceController::class, 'approve'])->name('absences.approve');
    Route::post('/absences/{absence}/reject', [AbsenceController::class, 'reject'])->name('absences.reject');

    Route::get('/calendrier', [CongeController::class, 'calendar'])->name('conges.calendar');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';