<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AIChatbotController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// 2. Role-Based Dashboard & Demo Role Swapper
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/demo/switch-role', [DashboardController::class, 'switchRole'])
    ->middleware(['auth'])
    ->name('demo.switch-role');

// 3. Authenticated E-Learning System Routes
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Course Management & Portal
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/progress', [CourseController::class, 'updateProgress'])->name('courses.progress');

    // Quiz & Attempt engine
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/result/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');

    // AI Chatbot Page
    Route::get('/ai-chatbot', [AIChatbotController::class, 'index'])->name('ai-chatbot');
    Route::post('/ai-chatbot', [AIChatbotController::class, 'sendMessage'])->name('ai-chatbot.message');

    // Analytics Dashboard
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Progression & Milestone Achievements
    Route::get('/progression', [ProgressionController::class, 'index'])->name('progression');
});

require __DIR__.'/auth.php';
