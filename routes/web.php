<?php

use App\Exports\TemplateSoalExport;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExamController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\TestTaker\DashboardController as TestTakerDashboardController;
use App\Http\Controllers\TestTaker\CourseController as TestTakerCourseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Volt\Volt;

// Landing Page Route
Route::get('/', function () {
    return view('landing');
})->name('landing');

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
    ->group(function () {

        // Dashboard Examiner
        Route::get('/dashboard', function () {
            return view('examiner.dashboard');
        })->name('examiner.dashboard');

        Volt::route('/exam-manage', 'examiner.exam-manage')->name('examiner.exam-manage');
        Volt::route('/grading/{attempt}', 'examiner.grading')->name('examiner.grading');
    });

// Route Test-Taker
Route::middleware(['auth', 'role:test_taker'])
    ->prefix('user')
    ->name('test_taker.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TestTakerDashboardController::class, 'index'])->name('dashboard');

        // Course Route
        Route::get('/courses', [TestTakerCourseController::class, 'index'])->name('course.index');

        // Exam Routes
        Route::get('/exams', [ExamController::class, 'index'])->name('exam.index');
        Route::get('/my-exams', [ExamController::class, 'myExams'])->name('exam.my_exams');
        Route::post('/exams/{exam}/start', [ExamController::class, 'startExam'])->name('exam.start');
        Volt::route('/exams/{exam}/detail', 'user.exam-detail')->name('exam.detail');
        Volt::route('/exams/{attempt}', 'user.exam')->name('exam.attempt');
        Route::get('/exams/{attempt}/result', [ExamController::class, 'showResult'])->name('exam.result');

        // Course / LMS Routes
        Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
        Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('course.my_courses');
        Route::get('/courses/{course}', [CourseController::class, 'show'])->name('course.show');
        Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
        Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'lesson'])->name('course.lesson');
    });

Route::get('/download-template-soal', function () {
    return Excel::download(new TemplateSoalExport, 'Template_Bank_Soal.xlsx');
});

require __DIR__ . '/auth.php';
