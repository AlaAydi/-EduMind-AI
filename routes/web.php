<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AIChatbotController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CourseDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/demo/switch-role', [DashboardController::class, 'switchRole'])
    ->middleware(['auth'])
    ->name('demo.switch-role');

Route::middleware('auth')->group(function () {



    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    Route::prefix('courses')->controller(CourseController::class)->group(function () {

        Route::get('/', 'index')->name('courses.index');

        Route::get('/create', 'create')->name('courses.create');

        Route::post('/', 'store')->name('courses.store');

        Route::get('/{course}', 'show')->name('courses.show');

        Route::get('/{course}/edit', 'edit')->name('courses.edit');

        Route::put('/{course}', 'update')->name('courses.update');

        Route::delete('/{course}', 'destroy')->name('courses.destroy');

        Route::post('/{course}/enroll', 'enroll')->name('courses.enroll');

        Route::post('/{course}/progress', 'updateProgress')->name('courses.progress');
    });



    Route::prefix('courses')->group(function () {

        Route::post('/{course}/documents', [CourseDocumentController::class, 'store'])
            ->name('courses.documents.store');
    });

    Route::delete('/documents/{document}', [CourseDocumentController::class, 'destroy'])
        ->name('courses.documents.destroy');


    Route::prefix('quizzes')->controller(QuizController::class)->group(function () {

        Route::get('/', 'index')->name('quizzes.index');

        Route::get('/create', 'create')->name('quizzes.create');

        Route::post('/', 'store')->name('quizzes.store');

        Route::get('/{quiz}', 'show')->name('quizzes.show');

        Route::get('/{quiz}/edit', 'edit')->name('quizzes.edit');

        Route::put('/{quiz}', 'update')->name('quizzes.update');

        Route::delete('/{quiz}', 'destroy')->name('quizzes.destroy');

        Route::get('/{quiz}/take', 'take')->name('quizzes.take');

        Route::post('/{quiz}/submit', 'submit')->name('quizzes.submit');

        Route::get('/{quiz}/result/{attempt}', 'result')->name('quizzes.result');
    });



    Route::prefix('ai-chatbot')->controller(AIChatbotController::class)->group(function () {

        Route::get('/', 'index')->name('ai-chatbot');

        Route::post('/', 'sendMessage')->name('ai-chatbot.message');
    });



    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics');

    Route::get('/progression', [ProgressionController::class, 'index'])
        ->name('progression');
});



Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');



        Route::prefix('users')
            ->controller(AdminUserController::class)
            ->group(function () {

                Route::get('/', 'index')->name('users.index');

                Route::get('/{user}/edit', 'edit')->name('users.edit');

                Route::put('/{user}', 'update')->name('users.update');

                Route::delete('/{user}', 'destroy')->name('users.destroy');

                Route::post('/{user}/approve', 'approve')->name('users.approve');
            });


        Route::prefix('categories')
            ->controller(AdminCategoryController::class)
            ->group(function () {

                Route::get('/', 'index')->name('categories.index');

                Route::get('/create', 'create')->name('categories.create');

                Route::post('/', 'store')->name('categories.store');

                Route::get('/{category}/edit', 'edit')->name('categories.edit');

                Route::put('/{category}', 'update')->name('categories.update');

                Route::delete('/{category}', 'destroy')->name('categories.destroy');
            });
    });

require __DIR__ . '/auth.php';
