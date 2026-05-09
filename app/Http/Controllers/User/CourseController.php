<?php

namespace App\Http\Controllers\User;

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
        $courses = Course::where('is_published', true)
            ->withCount(['modules', 'enrollments'])
            ->latest()
            ->get();

        return view('test_taker.courses.index', compact('courses'));
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

        return view('test_taker.courses.show', compact('course', 'isEnrolled', 'totalLessons', 'totalDuration'));
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

        return redirect()->route('test_taker.course.show', $course->id)
            ->with('success', 'Berhasil mendaftar kursus! Selamat belajar.');
    }

    /**
     * View a single lesson.
     */
    public function lesson(Course $course, CourseLesson $lesson)
    {
        $userId = Auth::id();

        // Must be enrolled (unless lesson is previewable)
        $isEnrolled = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if (!$isEnrolled && !$lesson->is_previewable) {
            return redirect()->route('test_taker.course.show', $course->id)
                ->with('error', 'Anda harus mendaftar kursus untuk mengakses materi ini.');
        }

        $course->load(['modules.lessons']);
        $lesson->load('module');

        // Find prev/next lessons for navigation
        $allLessons = $course->modules->flatMap->lessons;
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        return view('test_taker.courses.lesson', compact(
            'course', 'lesson', 'allLessons', 'prevLesson', 'nextLesson', 'isEnrolled'
        ));
    }
}
