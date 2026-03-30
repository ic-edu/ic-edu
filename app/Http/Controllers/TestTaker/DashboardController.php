<?php

namespace App\Http\Controllers\TestTaker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamAttempt;
use App\Models\ExamType;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $finishedExams = ExamAttempt::where('user_id', $user->id)
                            ->where('status', 'finished')->count();
        
        $inProgressExams = ExamAttempt::where('user_id', $user->id)
                            ->where('status', 'in_progress')->count();
        
        $avgScore = ExamAttempt::where('user_id', $user->id)
                            ->where('status', 'finished')->avg('total_score') ?? 0;
        
        // Recent pending attempts to continue
        $recentPendingExams = ExamAttempt::with('exam.examType')
                                ->where('user_id', $user->id)
                                ->where('status', 'in_progress')
                                ->orderBy('updated_at', 'desc')
                                ->take(3)
                                ->get();

        // Exam Categories
        $examCategories = ExamType::withCount('exams')->get();

        return view('test_taker.dashboard', compact(
            'finishedExams', 'inProgressExams', 'avgScore', 'recentPendingExams', 'examCategories'
        ));
    }
}
