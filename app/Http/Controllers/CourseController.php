<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            "name"              => ["required", "string", "max:150"],
            "code"              => ["nullable", "string", "max:50", "unique:courses,code"],
            "description"       => ["nullable", "string"],
            "is_active"         => ["nullable", "boolean"]
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->code = $request->code;
        $course->description = $request->description;
        $course->is_active = $request->boolean('is_active');
        $course->save();
        return redirect()->route('courses.create')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
