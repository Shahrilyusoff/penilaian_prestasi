<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluationPeriodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SktController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReportController;

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Evaluation Periods
    Route::resource('evaluation-periods', EvaluationPeriodController::class);
    
    // Users
    Route::resource('users', UserController::class);
    Route::post('users/{user}/assign-evaluators', [UserController::class, 'assignEvaluators'])
        ->name('users.assign-evaluators');
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/evaluation/{period}', [ReportController::class, 'generateEvaluationReport'])
        ->name('reports.evaluation');
    Route::get('reports/skt/{period}', [ReportController::class, 'generateSktReport'])
        ->name('reports.skt');
    Route::get('reports/individual/{evaluation}', [ReportController::class, 'generateIndividualReport'])
        ->name('reports.individual');
});

// SKT Routes
Route::middleware('auth')->group(function () {
    Route::resource('skt', SktController::class);
    Route::get('skt', [SktController::class, 'index'])->name('skt.index');
    Route::get('skt/{skt}/edit-evaluator', [SktController::class, 'editEvaluator'])
        ->name('skt.edit-evaluator');
    Route::put('skt/{skt}/update-evaluator', [SktController::class, 'updateEvaluator'])
        ->name('skt.update-evaluator');
    Route::post('skt/{skt}/submit', [SktController::class, 'submit'])->name('skt.submit');
    Route::post('skt/{skt}/approve', [SktController::class, 'approve'])->name('skt.approve');
    Route::post('skt/{skt}/mid-year-review', [SktController::class, 'midYearReview'])->name('skt.mid-year-review');
    Route::post('skt/{skt}/final-review', [SktController::class, 'finalReview'])->name('skt.final-review');
});

// Evaluation Routes
Route::middleware('auth')->group(function () {
    Route::resource('evaluations', EvaluationController::class);
    Route::get('evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('evaluations/{evaluation}/submit-pyd', [EvaluationController::class, 'submitPYD'])->name('evaluations.submit-pyd');
    Route::post('evaluations/{evaluation}/submit-ppp', [EvaluationController::class, 'submitPPP'])->name('evaluations.submit-ppp');
    Route::post('evaluations/{evaluation}/submit-ppk', [EvaluationController::class, 'submitPPK'])->name('evaluations.submit-ppk');
});

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/skt', [ReportController::class, 'generateSktReport'])->name('reports.skt');
    Route::get('/evaluation', [ReportController::class, 'generateEvaluationReport'])->name('reports.evaluation');
    Route::get('/individual', [ReportController::class, 'generateIndividualReport'])->name('reports.individual');
});