<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Mock data for analytics
        $totalStudents = 1250;
        $totalCourses = 45;
        $completionRate = 78;
        $activeLearners = 420;

        return view('analytics.index', compact(
            'totalStudents', 'totalCourses', 'completionRate', 'activeLearners'
        ));
    }
}
