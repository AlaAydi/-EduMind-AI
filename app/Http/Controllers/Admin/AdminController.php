<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $completionRate = $totalEnrollments > 0
            ? round(($completedEnrollments / $totalEnrollments) * 100)
            : 0;

        $pendingApprovals = User::whereIn('role', ['teacher', 'student'])
            ->where('is_approved', false)->count();

        $totalCategories = Category::count();

        // Enrollment trends last 7 months
        $months = [];
        $enrollmentCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M');
            $enrollmentCounts[] = Enrollment::whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->count();
        }

        // Top categories by course count
        $topCategories = Category::withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->take(5)
            ->get();

        $popularityLabels = $topCategories->pluck('name')->toArray();
        $popularityValues = $topCategories->pluck('courses_count')->toArray();

        // Recent users needing approval
        $recentPending = User::whereIn('role', ['teacher', 'student'])
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalCourses',
            'totalEnrollments', 'completionRate', 'pendingApprovals',
            'totalCategories', 'months', 'enrollmentCounts',
            'popularityLabels', 'popularityValues', 'recentPending'
        ));
    }
}
