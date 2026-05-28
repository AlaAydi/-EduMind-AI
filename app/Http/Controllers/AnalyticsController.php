<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
  

        $totalStudents = User::where('role', 'student')->count();
        $totalCourses = Course::count();

        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100) : 0;

        $activeLearners = User::whereHas('enrollments', function($q) {
            $q->where('status', 'active');
        })->count();

        return view('analytics.index', compact(
            'totalStudents', 'totalCourses', 'completionRate', 'activeLearners'
        ));
    }
}
