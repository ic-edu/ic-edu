<?php

use App\Exports\TemplateSoalExport;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExamController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\TestTaker\DashboardController as TestTakerDashboardController;
use App\Http\Controllers\TestTaker\CourseController as TestTakerCourseController;
use App\Livewire\Onboarding\OnboardingWizard;
use App\Livewire\TestTaker\ProfilePage;
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

    // Profile Routes (Breeze — kept for examiner/admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // New Profile Page for test_taker
    Route::get('/settings', ProfilePage::class)->name('profile.show');
    Route::redirect('/settings-old', '/settings');
});

// Route Examiner
Route::middleware(['auth', 'verified', 'role:examiner'])
    ->prefix('examiner')
    ->group(function () {

        // Dashboard Examiner
        Route::get('/dashboard', function () {
            return view('examiner.dashboard');
        })->name('examiner.dashboard');

        Volt::route('/exam-manage', 'examiner.exam-manage')->name('examiner.exam-manage');
        Volt::route('/exam-reviews', 'examiner.exam-reviews')->name('examiner.exam-reviews');
        Volt::route('/grading/{attempt}', 'examiner.grading')->name('examiner.grading');
        Volt::route('/course-reviews', 'examiner.course-reviews')->name('examiner.course-reviews');
        Route::get('/settings', function () {
            return view('profile.examiner-edit', [
                'user' => Auth::user(),
            ]);
        })->name('examiner.settings');
    });

// Onboarding Route
Route::middleware(['auth'])
     ->get('/onboarding', OnboardingWizard::class)
     ->name('onboarding.index');

// Route Test-Taker
Route::middleware(['auth', 'verified', 'role:test_taker', 'onboarding'])
    ->prefix('user')
    ->name('test_taker.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TestTakerDashboardController::class, 'index'])->name('dashboard');

        // Course / LMS Routes
        Route::get('/courses', [TestTakerCourseController::class, 'index'])->name('course.index');
        Route::get('/my-courses', [TestTakerCourseController::class, 'myCourses'])->name('course.my_courses');
        Route::get('/courses/{course}', [TestTakerCourseController::class, 'show'])->name('course.show');
        Route::post('/courses/{course}/enroll', [TestTakerCourseController::class, 'enroll'])->middleware('throttle:5,1')->name('course.enroll');
        Route::get('/courses/{course}/lessons/{lesson}', [TestTakerCourseController::class, 'lesson'])->name('course.lesson');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [TestTakerCourseController::class, 'markComplete'])->name('course.lesson.complete');
        Route::post('/courses/{course}/lessons/{lesson}/quiz', [TestTakerCourseController::class, 'startQuiz'])->middleware('throttle:5,1')->name('course.quiz.start');

        // Course Certificate
        Route::get('/courses/{course}/certificate', [TestTakerCourseController::class, 'certificatePreview'])->name('course.certificate.preview');
        Route::get('/courses/{course}/certificate/download', [TestTakerCourseController::class, 'downloadCertificate'])->name('course.certificate.download');

        // Exam Routes
        Route::get('/exams', [ExamController::class, 'index'])->name('exam.index');
        Route::get('/my-exams', [ExamController::class, 'myExams'])->name('exam.my_exams');
        Route::post('/exams/{exam}/start', [ExamController::class, 'startExam'])->middleware('throttle:5,1')->name('exam.start');
        Volt::route('/exams/{exam}/detail', 'user.exam-detail')->name('exam.detail');
        Volt::route('/exams/{attempt}', 'user.exam')->name('exam.attempt');
        Route::get('/exams/{attempt}/result', [ExamController::class, 'showResult'])->name('exam.result');
        Route::get('/exams/{attempt}/score-report', [ExamController::class, 'scoreReport'])->name('exam.score_report');
        Route::get('/exams/{attempt}/sections/{section}/review', [ExamController::class, 'sectionReview'])->name('exam.section.review');

        // Notification Routes
        Route::post('/notifications/mark-all-read', function() {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        })->name('notifications.mark_all_read');

        Route::post('/notifications/{id}/mark-as-read', function($id) {
            $notif = auth()->user()->notifications()->find($id);
            if ($notif) {
                $notif->markAsRead();
            }
            return response()->json(['success' => true]);
        })->name('notifications.mark_as_read');
    });

Route::get('/download-template-soal', function () {
    return Excel::download(new TemplateSoalExport, 'Template_Bank_Soal.xlsx');
})->middleware(['auth', 'role:admin']);

Route::get('/admin/geo-map', [MapController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.geo.map');

require __DIR__ . '/auth.php';
