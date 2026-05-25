<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $courses = Course::with('teacher')->latest()->take(3)->get();
        return view('welcome', compact('courses'));
    }
}
