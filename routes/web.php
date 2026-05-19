<?php

use App\Exports\TemplateSoalExport;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExamController;
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

Route::view('/courses', 'courses')->name('courses');
Route::view('/pricing', 'pricing')->name('pricing');
Route::view('/toefl', 'toefl')->name('toefl');
Route::view('/toeic', 'toeic')->name('toeic');
Route::view('/ielts', 'ielts')->name('ielts');

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

        // Exam manage per type
        Volt::route('/exam-manage/{type}', 'examiner.exam-manage')
            ->name('examiner.exam-manage.type');
    });

// Route Test-Taker
Route::middleware(['auth', 'role:test_taker'])
    ->prefix('user')
    ->name('test_taker.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TestTakerDashboardController::class, 'index'])->name('dashboard');

        // Course / LMS Routes
        Route::get('/courses', [TestTakerCourseController::class, 'index'])->name('course.index');
        Route::get('/my-courses', [TestTakerCourseController::class, 'myCourses'])->name('course.my_courses');
        Route::get('/courses/{course}', [TestTakerCourseController::class, 'show'])->name('course.show');
        Route::post('/courses/{course}/enroll', [TestTakerCourseController::class, 'enroll'])->name('course.enroll');
        Route::get('/courses/{course}/lessons/{lesson}', [TestTakerCourseController::class, 'lesson'])->name('course.lesson');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [TestTakerCourseController::class, 'markComplete'])->name('course.lesson.complete');
        Route::post('/courses/{course}/lessons/{lesson}/quiz', [TestTakerCourseController::class, 'startQuiz'])->name('course.quiz.start');

        // Exam Routes
        Route::get('/exams', [ExamController::class, 'index'])->name('exam.index');
        Route::get('/my-exams', [ExamController::class, 'myExams'])->name('exam.my_exams');
        Route::post('/exams/{exam}/start', [ExamController::class, 'startExam'])->name('exam.start');
        Volt::route('/exams/{exam}/detail', 'user.exam-detail')->name('exam.detail');
        Volt::route('/exams/{attempt}', 'user.exam')->name('exam.attempt');
        Route::get('/exams/{attempt}/result', [ExamController::class, 'showResult'])->name('exam.result');
        Route::get('/exams/{attempt}/score-report', [ExamController::class, 'scoreReport'])->name('exam.score_report');
    });

Route::get('/download-template-soal', function () {
    return Excel::download(new TemplateSoalExport, 'Template_Bank_Soal.xlsx');
});

require __DIR__ . '/auth.php';
