<?php

namespace App\Http\Controllers\TestTaker;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseLesson;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Browse all published courses.
     */
    public function index()
    {
        $userId = Auth::id();
        $enrolledCourseIds = CourseEnrollment::where('user_id', $userId)->pluck('course_id')->toArray();

        $courses = Course::where('is_published', true)
            ->withCount(['modules', 'enrollments'])
            ->latest()
            ->get();

        return view('test_taker.courses.index', compact('courses', 'enrolledCourseIds'));
    }

    /**
     * My enrolled courses.
     */
    public function myCourses()
    {
        $userId = Auth::id();

        $enrollments = CourseEnrollment::where('user_id', $userId)
            ->with(['course' => function ($q) {
                $q->withCount('modules');
            }])
            ->latest('enrolled_at')
            ->get();

        return view('test_taker.courses.my_courses', compact('enrollments'));
    }

    /**
     * Course detail page (modules overview).
     */
    public function show(Course $course)
    {
        $course->load(['modules.lessons']);
        $course->loadCount(['modules', 'enrollments']);

        $userId = Auth::id();
        $isEnrolled = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        $totalLessons = $course->modules->sum(fn ($m) => $m->lessons->count());
        $totalDuration = $course->modules->sum(fn ($m) => $m->lessons->sum('duration_minutes'));

        $certificate = null;

        if ($isEnrolled && $totalLessons > 0) {
            $completedLessonsCount = \App\Models\LessonProgress::where('user_id', $userId)
                ->whereIn('course_lesson_id', $course->modules->flatMap->lessons->pluck('id'))
                ->where('is_completed', true)
                ->count();
                
            if ($completedLessonsCount >= $totalLessons) {
                $certificate = \App\Models\Certificate::firstOrCreate(
                    ['user_id' => $userId, 'course_id' => $course->id],
                    [
                        'certificate_code' => 'CERT-' . strtoupper(uniqid()) . '-' . $userId,
                        'issued_at' => now(),
                    ]
                );
            }
        }

        return view('test_taker.courses.show', compact('course', 'isEnrolled', 'totalLessons', 'totalDuration', 'certificate'));
    }

    /**
     * Enroll in a course.
     */
    public function enroll(Course $course)
    {
        $userId = Auth::id();

        $existing = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (!$existing) {
            CourseEnrollment::create([
                'user_id'     => $userId,
                'course_id'   => $course->id,
                'status'      => 'active',
                'enrolled_at' => now(),
            ]);
        }

        return redirect()->route('test_taker.course.my_courses')
            ->with('success', 'Berhasil mendaftar kursus! Selamat belajar.');
    }

    /**
     * View a single lesson.
     */
    public function lesson(Course $course, CourseLesson $lesson)
    {
        $userId = Auth::id();

        $isEnrolled = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if (!$isEnrolled && !$lesson->is_previewable) {
            return redirect()->route('test_taker.course.show', $course->id)
                ->with('error', 'You must enroll in this course to access this lesson.');
        }

        $course->load(['modules.lessons']);
        $lesson->load('module');

        $allLessons = $course->modules->flatMap->lessons;
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $lesson->id);
        
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        // --- ENFORCED PROGRESSION ---
        if ($isEnrolled && $prevLesson) {
            $prevProgress = \App\Models\LessonProgress::where('user_id', $userId)
                ->where('course_lesson_id', $prevLesson->id)
                ->first();

            if (!$prevProgress || !$prevProgress->is_completed) {
                return redirect()->route('test_taker.course.lesson', [$course->id, $prevLesson->id])
                    ->with('error', 'Please mark this lesson as complete to unlock the next one.');
            }
        }

        // --- GET CURRENT PROGRESS ---
        $currentProgress = \App\Models\LessonProgress::where('user_id', $userId)
            ->where('course_lesson_id', $lesson->id)
            ->first();
        $isCompleted = $currentProgress ? $currentProgress->is_completed : false;

        // Auto-complete check for quizzes
        if ($isEnrolled && $lesson->type === 'quiz' && $lesson->exam_id && !$isCompleted) {
            $attempt = \App\Models\ExamAttempt::where('user_id', $userId)
                ->where('exam_id', $lesson->exam_id)
                ->latest()
                ->first();

            if ($attempt && $attempt->status === \App\Enums\ExamAttemptStatus::GRADED->value) {
                $passingGrade = $lesson->passing_score ?? 0;
                if ($attempt->converted_score >= $passingGrade) {
                    \App\Models\LessonProgress::updateOrCreate(
                        ['user_id' => $userId, 'course_lesson_id' => $lesson->id],
                        ['is_completed' => true, 'last_accessed_at' => now()]
                    );
                    $isCompleted = true;
                }
            }
        }

        // --- GET PROGRESS STATS FOR SIDEBAR ---
        $completedLessonIds = [];
        $completedCount = 0;
        $totalLessons = $allLessons->count();
        
        if ($isEnrolled) {
            $completedLessonIds = \App\Models\LessonProgress::where('user_id', $userId)
                ->whereIn('course_lesson_id', $allLessons->pluck('id'))
                ->where('is_completed', true)
                ->pluck('course_lesson_id')
                ->toArray();
            $completedCount = count($completedLessonIds);
            
            // Add currently completing lesson to array if not already there
            if ($isCompleted && !in_array($lesson->id, $completedLessonIds)) {
                $completedLessonIds[] = $lesson->id;
                $completedCount++;
            }
        }

        return view('test_taker.courses.lesson', compact(
            'course', 'lesson', 'allLessons', 'prevLesson', 'nextLesson', 'isEnrolled', 'isCompleted',
            'completedLessonIds', 'completedCount', 'totalLessons'
        ));
    }

    /**
     * Mark a non-quiz lesson as completed.
     */
    public function markComplete(Course $course, CourseLesson $lesson)
    {
        $userId = Auth::id();

        if ($lesson->type === 'quiz') {
            return redirect()->back()->with('error', 'Quizzes are graded automatically.');
        }

        \App\Models\LessonProgress::updateOrCreate(
            ['user_id' => $userId, 'course_lesson_id' => $lesson->id],
            ['is_completed' => true, 'last_accessed_at' => now()]
        );

        $course->load(['modules.lessons']);
        $allLessons = $course->modules->flatMap->lessons;
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $lesson->id);
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        if ($nextLesson) {
            return redirect()->route('test_taker.course.lesson', [$course->id, $nextLesson->id])
                ->with('success', 'Lesson completed! Proceeding to the next lesson.');
        }

        // If it was the last lesson, redirect to course overview and show certificate (to be implemented)
        return redirect()->route('test_taker.course.show', $course->id)
            ->with('success', 'Congratulations! You have completed all lessons in this course.');
    }

    /**
     * Start a native LMS quiz.
     */
    public function startQuiz(Course $course, CourseLesson $lesson)
    {
        $userId = Auth::id();

        $isEnrolled = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('test_taker.course.show', $course->id)
                ->with('error', 'You must enroll in this course to take the quiz.');
        }

        if ($lesson->type !== 'quiz' || !$lesson->exam_id) {
            return redirect()->back()->with('error', 'This lesson is not a quiz or has no exam linked.');
        }

        // Resume ongoing attempt if any
        $existingAttempt = \App\Models\ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $lesson->exam_id)
            ->where('status', \App\Enums\ExamAttemptStatus::ONGOING->value)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('test_taker.exam.attempt', ['attempt' => $existingAttempt->id, 'course_id' => $course->id, 'lesson_id' => $lesson->id]);
        }

        // Create new attempt
        $newAttempt = \App\Models\ExamAttempt::create([
            'user_id'  => $userId,
            'exam_id'  => $lesson->exam_id,
            'started_at' => now(),
            'status'   => \App\Enums\ExamAttemptStatus::ONGOING->value,
        ]);

        return redirect()->route('test_taker.exam.attempt', ['attempt' => $newAttempt->id, 'course_id' => $course->id, 'lesson_id' => $lesson->id]);
    }
    public function certificatePreview(Course $course)
    {
        $certificate = \App\Models\Certificate::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        return view('test_taker.courses.certificate_preview', compact('course', 'certificate'));
    }

    public function downloadCertificate(Course $course)
    {
        $certificate = \App\Models\Certificate::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('test_taker.courses.certificate_pdf', compact('course', 'certificate'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Certificate_' . str_replace(' ', '_', $course->title) . '.pdf');
    }
}
