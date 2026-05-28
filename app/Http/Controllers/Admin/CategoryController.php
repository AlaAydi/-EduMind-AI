<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['courses', 'users'])->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->where('is_approved', true)->orderBy('name')->get();
        $students = User::where('role', 'student')->where('is_approved', true)->orderBy('name')->get();
        return view('admin.categories.create', compact('teachers', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:users,id'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['exists:users,id'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Sync assigned teachers and students
        $userIds = array_merge(
            $request->input('teacher_ids', []),
            $request->input('student_ids', [])
        );
        $category->users()->sync($userIds);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée et utilisateurs affectés avec succès.');
    }

    public function edit(Category $category)
    {
        $teachers = User::where('role', 'teacher')->where('is_approved', true)->orderBy('name')->get();
        $students = User::where('role', 'student')->where('is_approved', true)->orderBy('name')->get();
        $assignedUserIds = $category->users()->pluck('users.id')->toArray();
        return view('admin.categories.edit', compact('category', 'teachers', 'students', 'assignedUserIds'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:users,id'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['exists:users,id'],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $userIds = array_merge(
            $request->input('teacher_ids', []),
            $request->input('student_ids', [])
        );
        $category->users()->sync($userIds);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée.');
    }
}
