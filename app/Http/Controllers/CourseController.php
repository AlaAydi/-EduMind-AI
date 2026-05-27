<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseDocument;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index(Request $request)
    {
        $query = Course::with('teacher');
        $user = Auth::user();

        // If the user is a teacher, only show their own courses
        if ($user->isTeacher()) {
            $query->where('teacher_id', $user->id);
        }

        // Apply filters
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $courses = $query->latest()->get();

        // Get user's enrollment ids to highlight enrolled states
        $userEnrollments = Auth::user()->enrollments->pluck('progress', 'course_id')->toArray();

        return view('courses.index', compact('courses', 'userEnrollments'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        if (!Auth::user()->isTeacher()) {
            return redirect()->route('dashboard')->with('error', 'Only teachers can create courses.');
        }

        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    /**
     * Store a newly created course in database.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isTeacher()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'required|string|max:100',
            'thumbnail' => 'nullable|url',
        ]);

        $slug = Str::slug($request->title) . '-' . rand(100, 999);
        
        $thumbnail = $request->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80';

        Course::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'duration' => $request->duration,
            'thumbnail' => $thumbnail,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Course successfully designed and deployed!');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        // Load course quizzes
        $quizzes = $course->quizzes;

        if ($enrollment || $user->isTeacher()) {
            // Classroom view: load documents
            $lessons = $course->documents;

            return view('courses.show', compact('course', 'enrollment', 'lessons', 'quizzes'));
        }

        // Preview view
        return view('courses.preview', compact('course', 'quizzes'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        if (Auth::id() !== $course->teacher_id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized.');
        }

        $categories = Category::all();
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        if (Auth::id() !== $course->teacher_id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'required|string|max:100',
            'thumbnail' => 'nullable|url',
        ]);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'duration' => $request->duration,
            'thumbnail' => $request->thumbnail ?: $course->thumbnail,
        ]);

        return redirect()->route('courses.show', $course->id)->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        if (Auth::id() !== $course->teacher_id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized.');
        }

        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Course deleted successfully.');
    }

    /**
     * Enroll the student in a course.
     */
    public function enroll(Course $course)
    {
        $user = Auth::user();

        if ($user->isTeacher()) {
            return redirect()->back()->with('error', 'Instructors cannot enroll in modules.');
        }

        // Check if already enrolled
        $exists = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($exists) {
            return redirect()->route('courses.show', $course->id);
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
            'status' => 'active',
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'course_started',
            'description' => "Enrolled in course: " . $course->title,
        ]);

        return redirect()->route('courses.show', $course->id)->with('success', 'Successfully enrolled! Welcome to the classroom.');
    }

    /**
     * Update student progress percentage in a course.
     */
    public function updateProgress(Request $request, Course $course)
    {
        $user = Auth::user();
        
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $newProgress = $request->progress;
        
        $status = $newProgress >= 100 ? 'completed' : 'active';

        $wasCompleted = $enrollment->status === 'completed';

        $enrollment->update([
            'progress' => $newProgress,
            'status' => $status
        ]);

        if ($status === 'completed' && !$wasCompleted) {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => 'certificate',
                'description' => "Successfully finished " . $course->title . " and earned a Certificate of Achievement!",
            ]);

            return redirect()->back()->with('success', 'Congratulations! Course finished. Your completion certificate has been unlocked.');
        }

        return redirect()->back()->with('success', 'Progress updated successfully.');
    }
}
