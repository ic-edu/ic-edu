<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Simulator Route
    Route::get('/simulator', [ExamController::class, 'index'])->name('simulator.index');
    Route::post('/simulation/{exam}/start', [ExamController::class, 'start'])->name('exams.start');
    Route::livewire('/simulation/{attemptId}', 'exam-simulator')->name('exams.simulation');
    Route::get('/exam-result/{attempt}', [ExamController::class, 'result'])->name('exams.result');
});

require __DIR__ . '/auth.php';
