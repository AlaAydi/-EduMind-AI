<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\ActivityLog;

class ProgressionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = Enrollment::where('user_id', $user->id)->get();
        $completedCount = $enrollments->where('status', 'completed')->count();
        $quizAttempts = QuizAttempt::where('user_id', $user->id)->get();
        $passedQuizzesCount = $quizAttempts->where('passed', true)->count();

        $completedXP = $completedCount * 500;
        $progressXP = $enrollments->where('status', 'active')->sum('progress') * 5;
        $quizXP = $passedQuizzesCount * 200;

        $xpPoints = $completedXP + $progressXP + $quizXP;
        $currentLevel = floor(sqrt($xpPoints / 150)) + 1;
        $xpToNextLevel = pow($currentLevel, 2) * 150;
        
        $activityLogs = ActivityLog::where('user_id', $user->id)
            ->whereIn('activity_type', ['certificate', 'quiz_completion'])
            ->latest()
            ->get();

        $achievements = [];
        foreach($activityLogs as $log) {
            $icon = $log->activity_type == 'certificate' ? '🏆' : '⭐';
            $title = $log->activity_type == 'certificate' ? 'Course Completed' : 'Quiz Passed';
            $achievements[] = [
                'title' => $title,
                'description' => $log->description,
                'icon' => $icon,
                'earned_at' => $log->created_at->diffForHumans()
            ];
        }

        return view('progression.index', compact(
            'currentLevel', 'xpPoints', 'xpToNextLevel', 'achievements'
        ));
    }
}
