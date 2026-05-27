<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Course $course)
    {
        if (Auth::id() !== $course->teacher_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|string',
            'type' => 'required|string|in:video,pdf,document,link',
        ]);

        CourseDocument::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'file_path' => $request->file_path,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Document ajouté avec succès au cours.');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(CourseDocument $document)
    {
        $course = $document->course;
        
        if (Auth::id() !== $course->teacher_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document supprimé du cours.');
    }
}
