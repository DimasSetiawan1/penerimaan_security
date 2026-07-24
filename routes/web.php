<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\ReportController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Application Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Criteria Routes
    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria.index');
    Route::put('/criteria/{id}/weight', [CriteriaController::class, 'updateWeight'])->name('criteria.updateWeight');
    Route::put('/criteria/sub/{id}', [CriteriaController::class, 'updateSubCriteria'])->name('criteria.updateSubCriteria');

    // Candidate Routes
    Route::resource('candidates', CandidateController::class);

    // Step-by-step Calculation Route
    Route::get('/calculation', [CalculationController::class, 'index'])->name('calculation.index');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
});
