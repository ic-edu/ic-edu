<?php

namespace App\Http\Controllers\TestTaker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamAttempt;
use App\Models\ExamType;
use App\Enums\ExamAttemptStatus;
use App\Models\CourseEnrollment;
use App\Models\LessonProgress;
use App\Models\Certificate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $finishedExams = ExamAttempt::where('user_id', $user->id)
                            ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])->count();
        
        $inProgressExams = ExamAttempt::where('user_id', $user->id)
                            ->where('status', ExamAttemptStatus::ONGOING->value)->count();
        
        $avgScore = ExamAttempt::where('user_id', $user->id)
                            ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])->avg('converted_score') ?? 0;
        
        // Active Courses count
        $activeCourses = CourseEnrollment::where('user_id', $user->id)->count();

        // Recent Exam Results (ambil lebih banyak untuk Learning Stats)
        $recentResults = ExamAttempt::with(['exam.examType'])
                                ->where('user_id', $user->id)
                                ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])
                                ->orderBy('updated_at', 'desc')
                                ->take(20) // ambil lebih banyak untuk akurasi Learning Stats
                                ->get();

        // Certificates
        $certificates = Certificate::with('course')
                                ->where('user_id', $user->id)
                                ->orderBy('issued_at', 'desc')
                                ->get();

        // Active Enrollments (Course in Progress)
        $activeEnrollments = CourseEnrollment::with(['course.modules.lessons'])
                                ->where('user_id', $user->id)
                                ->orderBy('updated_at', 'desc')
                                ->take(3)
                                ->get();

        foreach($activeEnrollments as $enrollment) {
            $allLessonIds = $enrollment->course->modules->flatMap->lessons->pluck('id');
            $totalLessons = $allLessonIds->count();
            $completedLessons = LessonProgress::where('user_id', $user->id)
                                ->whereIn('course_lesson_id', $allLessonIds)
                                ->where('is_completed', true)->count();
            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
            
            // Find the last accessed lesson for "Resume" button
            $lastProgress = LessonProgress::where('user_id', $user->id)
                                ->whereIn('course_lesson_id', $allLessonIds)
                                ->orderBy('last_accessed_at', 'desc')
                                ->first();
            
            $enrollment->progress_pct = $progress;
            $enrollment->completed_lessons = $completedLessons;
            $enrollment->total_lessons = $totalLessons;
            $enrollment->last_lesson_id = $lastProgress->course_lesson_id ?? ($allLessonIds->first() ?? null);
        }

        // Exam Categories
        $examCategories = ExamType::withCount('exams')->get();

        // Chart Data (Score Progression Grouped by ExamType)
        $chartAttempts = ExamAttempt::with(['exam.examType'])
                                ->where('user_id', $user->id)
                                ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])
                                ->orderBy('updated_at', 'asc') // chronological
                                ->take(50) // load a good chunk of history
                                ->get();
        
        $chartDataGrouped = [];
        foreach($chartAttempts as $attempt) {
            $typeName = $attempt->exam->examType->name ?? 'General';
            if(!isset($chartDataGrouped[$typeName])) {
                $chartDataGrouped[$typeName] = [
                    'labels' => [],
                    'data' => []
                ];
            }
            // keep the latest 10 per type max
            if(count($chartDataGrouped[$typeName]['labels']) >= 10) {
                array_shift($chartDataGrouped[$typeName]['labels']);
                array_shift($chartDataGrouped[$typeName]['data']);
            }
            $chartDataGrouped[$typeName]['labels'][] = $attempt->updated_at->format('d M');
            $chartDataGrouped[$typeName]['data'][] = round($attempt->converted_score, 1);
        }

        // Weekly Activity / Streak
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $weeklyLessonProgress = LessonProgress::where('user_id', $user->id)
                                ->where('is_completed', true)
                                ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
                                ->get();
                                
        $weeklyExamAttempts = ExamAttempt::where('user_id', $user->id)
                                ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])
                                ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
                                ->get();
        
        $streakDays = [];
        $activeDaysCount = 0;
        
        for ($i = 0; $i < 7; $i++) {
            $currentDay = clone $startOfWeek;
            $currentDay->addDays($i);
            
            $hasLesson = $weeklyLessonProgress->contains(function ($val) use ($currentDay) {
                return $val->updated_at->isSameDay($currentDay);
            });
            $hasExam = $weeklyExamAttempts->contains(function ($val) use ($currentDay) {
                return $val->updated_at->isSameDay($currentDay);
            });
            
            $isActive = $hasLesson || $hasExam;
            if ($isActive) $activeDaysCount++;
            
            $streakDays[] = [
                'day' => $currentDay->format('D'),
                'short' => substr($currentDay->format('D'), 0, 1),
                'active' => $isActive,
                'is_today' => $currentDay->isToday(),
            ];
        }

        return view('test_taker.dashboard', compact(
            'finishedExams', 'inProgressExams', 'avgScore', 'activeCourses', 'recentResults', 'activeEnrollments', 'examCategories',
            'chartDataGrouped', 'streakDays', 'activeDaysCount', 'certificates'
        ));
    }
}
