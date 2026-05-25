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

        if ($user->isTeacher()) {
            return $this->teacherDashboard($user);
        }

        return $this->studentDashboard($user);
    }

    /**
     * Render the student dashboard.
     */
    private function studentDashboard($user)
    {
        // 1. Get student enrollments
        $enrollments = Enrollment::with('course.teacher')
            ->where('user_id', $user->id)
            ->get();

        $activeCount = $enrollments->where('status', 'active')->count();
        $completedCount = $enrollments->where('status', 'completed')->count();

        // 2. Compute XP points dynamically
        // Completed course: 500 XP
        // Ongoing progress: 5 XP per 1% progress
        // Passed quiz: 200 XP
        $quizAttempts = QuizAttempt::where('user_id', $user->id)->get();
        $passedQuizzesCount = $quizAttempts->where('passed', true)->count();
        
        $completedXP = $completedCount * 500;
        $progressXP = $enrollments->where('status', 'active')->sum('progress') * 5;
        $quizXP = $passedQuizzesCount * 200;
        
        $totalXP = $completedXP + $progressXP + $quizXP;
        
        // XP Leveling formula: Level = floor(sqrt(XP / 100)) + 1
        $currentLevel = floor(sqrt($totalXP / 150)) + 1;
        $xpForNextLevel = pow($currentLevel, 2) * 150;
        $xpForCurrentLevel = pow($currentLevel - 1, 2) * 150;
        $levelProgressPercentage = 0;
        if ($xpForNextLevel > $xpForCurrentLevel) {
            $levelProgressPercentage = (($totalXP - $xpForCurrentLevel) / ($xpForNextLevel - $xpForCurrentLevel)) * 100;
        }

        // 3. AI Course Recommendations (courses student is not enrolled in)
        $enrolledIds = $enrollments->pluck('course_id')->toArray();
        $recommendations = Course::with('teacher')
            ->whereNotIn('id', $enrolledIds)
            ->take(2)
            ->get();

        // 4. Activity Logs
        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 5. Study hours mock logic
        $totalStudyMinutes = ($enrollments->where('status', 'completed')->count() * 320) + ($enrollments->where('status', 'active')->sum('progress') * 4.5);
        $totalStudyHours = round($totalStudyMinutes / 60, 1);

        // Chart Data: simulated last 7 days study hours
        $studyVelocity = [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'hours' => [1.2, 0.8, 2.4, 1.5, 3.0, 4.2, 2.1]
        ];

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

    /**
     * Render the teacher dashboard.
     */
    private function teacherDashboard($user)
    {
        // 1. Get courses created by this teacher
        $courses = Course::with('enrollments')
            ->where('teacher_id', $user->id)
            ->get();

        $activeCoursesCount = $courses->count();

        // 2. Aggregate statistics
        $courseIds = $courses->pluck('id')->toArray();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->count();
        $completedStudents = Enrollment::whereIn('course_id', $courseIds)->where('status', 'completed')->count();

        $quizIds = Quiz::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        $totalAttempts = QuizAttempt::whereIn('quiz_id', $quizIds)->count();
        $passedAttempts = QuizAttempt::whereIn('quiz_id', $quizIds)->where('passed', true)->count();

        $quizPassRate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100) : 0;

        // SaaS Revenue simulation: $29/mo plan, teacher gets 70% share of enrolled students
        $revenue = $totalStudents * 29 * 0.70;

        // 3. Analytics data (monthly student signups)
        $enrollmentTrend = [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'signups' => [12, 19, 32, 45, $totalStudents]
        ];

        // 4. Recent enrollments list
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

    /**
     * Helper action to toggle user role for demo purposes.
     */
    public function switchRole(Request $request)
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
