<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");

                    // Search by ID only if search value is numeric
                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);
        $request->validate([
            "name"              => ["required", "string", "max:150"],
            "code"              => ["required", "string", "max:50", "unique:courses,code"],
            "description"       => ["nullable", "string"],
            "is_active"         => ["nullable", "boolean"]
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->code = $request->code;
        $course->description = $request->description;
        $course->is_active = $request->boolean('is_active');
        $course->save();
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
        $request->validate([
            "name"              => ["required", "string", "max:150"],
            "code"              => ["required", "string", "max:50", "unique:courses,code," . $course->id],
            "description"       => ["nullable", "string"],
            "is_active"         => ["nullable", "boolean"]
        ]);

        $course->name = $request->name;
        $course->code = $request->code;
        $course->description = $request->description;
        $course->is_active = $request->boolean('is_active');
        $course->update();
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
        $course->delete();
        return redirect()->route('courses.index')->with("success", "Course deleted successfully.");
    }

    // all deleted course 
    public function deletedCourses(Request $request)
    {
        $search = $request->input('search');
        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();
        return view('courses.deleted', compact('courses'));
    }

    // restore deletd course 
    public function restoreCourses(int $id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return redirect()->route('courses.deleted')->with("success", "Course restored successfully.");
    }

    // permanent delete 
    public function forceDelete(int $id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->forceDelete();
        return redirect()->route('courses.deleted')->with("success", "Course permanently deleted.");
    }
}
