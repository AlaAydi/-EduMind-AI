<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return $this->teacherDashboard($user);
        }

        return $this->studentDashboard($user);
    }


    private function studentDashboard($user)
    {
        $enrollments = Enrollment::with('course.teacher')
            ->where('user_id', $user->id)
            ->get();

        $activeCount = $enrollments->where('status', 'active')->count();
        $completedCount = $enrollments->where('status', 'completed')->count();


        $quizAttempts = QuizAttempt::where('user_id', $user->id)->get();
        $passedQuizzesCount = $quizAttempts->where('passed', true)->count();

        $completedXP = $completedCount * 500;
        $progressXP = $enrollments->where('status', 'active')->sum('progress') * 5;
        $quizXP = $passedQuizzesCount * 200;

        $totalXP = $completedXP + $progressXP + $quizXP;

        $currentLevel = floor(sqrt($totalXP / 150)) + 1;
        $xpForNextLevel = pow($currentLevel, 2) * 150;
        $xpForCurrentLevel = pow($currentLevel - 1, 2) * 150;
        $levelProgressPercentage = 0;
        if ($xpForNextLevel > $xpForCurrentLevel) {
            $levelProgressPercentage = (($totalXP - $xpForCurrentLevel) / ($xpForNextLevel - $xpForCurrentLevel)) * 100;
        }

        $enrolledIds = $enrollments->pluck('course_id')->toArray();
        $recommendations = Course::with('teacher')
            ->whereNotIn('id', $enrolledIds)
            ->take(2)
            ->get();

        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $totalStudyMinutes = ($enrollments->where('status', 'completed')->count() * 320) + ($enrollments->where('status', 'active')->sum('progress') * 4.5);
        $totalStudyHours = round($totalStudyMinutes / 60, 1);

        $days = [];
        $hours = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D');
            $actCount = ActivityLog::where('user_id', $user->id)->whereDate('created_at', $date)->count();
            $hours[] = round($actCount * 0.5, 1);
        }
        $studyVelocity = ['days' => $days, 'hours' => $hours];

        return view('dashboard.student', compact(
            'enrollments',
            'activeCount',
            'completedCount',
            'totalXP',
            'currentLevel',
            'levelProgressPercentage',
            'xpForNextLevel',
            'recommendations',
            'activities',
            'totalStudyHours',
            'studyVelocity',
            'passedQuizzesCount'
        ));
    }


    private function teacherDashboard($user)
    {
        $courses = Course::with('enrollments')
            ->where('teacher_id', $user->id)
            ->get();

        $activeCoursesCount = $courses->count();

        $courseIds = $courses->pluck('id')->toArray();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->count();
        $completedStudents = Enrollment::whereIn('course_id', $courseIds)->where('status', 'completed')->count();

        $quizIds = Quiz::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        $totalAttempts = QuizAttempt::whereIn('quiz_id', $quizIds)->count();
        $passedAttempts = QuizAttempt::whereIn('quiz_id', $quizIds)->where('passed', true)->count();

        $quizPassRate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100) : 0;

        $revenue = $totalStudents * 29 * 0.70;

        $months = [];
        $signups = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $count = Enrollment::whereIn('course_id', $courseIds)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $signups[] = $count;
        }
        $enrollmentTrend = ['months' => $months, 'signups' => $signups];

        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.teacher', compact(
            'courses',
            'activeCoursesCount',
            'totalStudents',
            'completedStudents',
            'quizPassRate',
            'revenue',
            'enrollmentTrend',
            'recentEnrollments'
        ));
    }


    public function switchRole()
    {
        $user = Auth::user();
        $newRole = $user->role === 'student' ? 'teacher' : 'student';

        $user->update([
            'role' => $newRole,
            'avatar' => $newRole === 'teacher'
                ? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80'
                : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80'
        ]);

        return redirect()->route('dashboard')->with('success', "Role switched to: " . ucfirst($newRole));
    }
}
