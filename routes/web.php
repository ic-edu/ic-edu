<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExamController;
use App\Livewire\ExamSimulator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page Route
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isExaminer()) {
            return redirect()->route('examiner.dashboard');
        } else {
            return redirect()->route('test_taker.dashboard');
        }
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Examiner
Route::middleware(['auth', 'role:examiner'])
    ->prefix('examiner')
    ->name('examiner.')
    ->group(function () {

        // Dashboard Examiner
        Route::get('/dashboard', function () {
            return view('examiner.dashboard');
        })->name('dashboard');

    });

// Route Test-Examiner
Route::middleware(['auth', 'role:test_taker'])
    ->prefix('user') 
    ->name('test_taker.')
    ->group(function () {

        // Dashboard Test-Examiner
        Route::get('/dashboard', function () {
            return view('test_taker.dashboard');
        })->name('dashboard');

        // Simulator Routes
        Route::get('/simulator', [ExamController::class, 'index'])->name('simulator.index');
        Route::post('/simulation/{exam}/start', [ExamController::class, 'start'])->name('exams.start');
        Route::get('/simulation/{attemptId}', ExamSimulator::class)->name('exams.simulation');
        Route::get('/exam-result/{attempt}', [ExamController::class, 'result'])->name('exams.result');
    });

require __DIR__ . '/auth.php';
