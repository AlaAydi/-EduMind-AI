<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isTeacher()) {
            // Quizzes for teacher's courses
            $courseIds = Course::where('teacher_id', $user->id)->pluck('id')->toArray();
            $quizzes = Quiz::with('course')->whereIn('course_id', $courseIds)->get();
            return view('quizzes.index', compact('quizzes'));
        }

        // Quizzes for courses the student is enrolled in
        $enrolledCourseIds = Enrollment::where('user_id', $user->id)->pluck('course_id')->toArray();
        $quizzes = Quiz::with('course')->whereIn('course_id', $enrolledCourseIds)->get();
        
        // Fetch student attempts
        $attempts = QuizAttempt::where('user_id', $user->id)->get()->groupBy('quiz_id');

        return view('quizzes.index', compact('quizzes', 'attempts'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->isTeacher() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $courses = Course::where('teacher_id', $user->id)->get();
        return view('quizzes.create', compact('courses'));
    }

    /**
     * Store a newly created quiz in database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isTeacher() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        // Verify the course belongs to the teacher
        $course = Course::findOrFail($request->course_id);
        if ($course->teacher_id !== $user->id && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $quiz = Quiz::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'passing_score' => $request->passing_score,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully!');
    }

    /**
     * Show quiz instructions.
     */
    public function show(Quiz $quiz)
    {
        // Verify enrollment for students
        $user = Auth::user();
        if ($user->isStudent()) {
            $isEnrolled = Enrollment::where('user_id', $user->id)->where('course_id', $quiz->course_id)->exists();
            if (!$isEnrolled) {
                return redirect()->route('courses.index')->with('error', 'You must enroll in this course to take the quiz.');
            }
        }

        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        $user = Auth::user();
        if ($quiz->course->teacher_id !== $user->id && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $courses = Course::where('teacher_id', $user->id)->get();
        return view('quizzes.edit', compact('quiz', 'courses'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        if ($quiz->course->teacher_id !== $user->id && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'passing_score' => $request->passing_score,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully!');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $user = Auth::user();
        if ($quiz->course->teacher_id !== $user->id && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Take active quiz session.
     */
    public function take(Quiz $quiz)
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            $isEnrolled = Enrollment::where('user_id', $user->id)->where('course_id', $quiz->course_id)->exists();
            if (!$isEnrolled) {
                return redirect()->route('courses.index')->with('error', 'Access denied.');
            }
        }

        // Load quiz questions
        $questions = $quiz->questions;

        if ($questions->count() == 0) {
            return redirect()->back()->with('error', 'This quiz does not have any questions configured yet.');
        }

        return view('quizzes.take', compact('quiz', 'questions'));
    }

    /**
     * Submit and auto-grade the quiz.
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $questions = $quiz->questions;

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string|in:A,B,C,D'
        ]);

        $submittedAnswers = $request->answers;
        $correctCount = 0;

        foreach ($questions as $q) {
            $subAnswer = $submittedAnswers[$q->id] ?? null;
            if ($subAnswer === $q->correct_option) {
                $correctCount++;
            }
        }

        $totalQuestions = $questions->count();
        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $passed = $score >= $quiz->passing_score;

        // Save Attempt
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'passed' => $passed
        ]);

        // Log Activity
        $statusStr = $passed ? 'Passed' : 'Failed';
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'quiz_completion',
            'description' => "{$statusStr} quiz '{$quiz->title}' with a score of {$score}%.",
        ]);

        return redirect()->route('quizzes.result', [$quiz->id, $attempt->id])
                         ->with('success', 'Evaluation submitted and graded successfully!');
    }

    /**
     * Show scorecard results.
     */
    public function result(Quiz $quiz, QuizAttempt $attempt)
    {
        // Double check ownership
        if ($attempt->user_id !== Auth::id() && !Auth::user()->isTeacher()) {
            abort(403);
        }

        return view('quizzes.result', compact('quiz', 'attempt'));
    }
}
