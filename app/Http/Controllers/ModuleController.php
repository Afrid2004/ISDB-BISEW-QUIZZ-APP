<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        // $modules = Module::with('course')->get();
        // return response()->json($modules);
        $modules = Module::query()
            ->with('course')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('module_number', (int) $search);
                    } else {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhereHas('course', function ($courseQuery) use ($search) {
                                $courseQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('code', 'like', "%{$search}%");
                            });
                    }
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $courses = Course::where('is_active', "=", true)->whereNull('deleted_at')->get();
        return view('modules.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // removing extra spaces
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name)),
            'module_number' => (int) $request->module_number,
        ]);
        $request->validate([
            "course_id"       => ["required", Rule::exists('courses', 'id')->where('is_active', true)->whereNull('deleted_at')],
            'module_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('modules', 'module_number')
                    ->where(function ($query) use ($request) {
                        return $query->where('course_id', $request->course_id);
                    }),
            ],
            "name"            => ["nullable", "string", "max:150"],
            "description"     => ["nullable", "string"],
            "is_active"       => ["nullable", "boolean"]
        ]);
        $module = new Module();
        $module->course_id          = $request->course_id;
        $module->module_number      = $request->module_number;
        $module->name               = $request->name;
        $module->description        = $request->description;
        $module->is_active          = $request->boolean('is_active');
        $module->save();
        return redirect()->route('modules.index')->with("success", "Module created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        //
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
        $courses = Course::where('is_active', "=", true)->whereNull('deleted_at')->get();
        return view('modules.edit', compact('module', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        // removing extra spaces
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);
        $request->validate([
            "course_id"       => ["required", Rule::exists('courses', 'id')->where('is_active', true)->whereNull('deleted_at')],
            Rule::unique('modules', 'module_number')
                ->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id);
                })
                ->ignore($module->id),
            "name"            => ["nullable", "string", "max:150"],
            "description"     => ["nullable", "string"],
            "is_active"       => ["nullable", "boolean"]
        ]);
        $module->course_id          = $request->course_id;
        $module->module_number      = $request->module_number;
        $module->name               = $request->name;
        $module->description        = $request->description;
        $module->is_active          = $request->boolean('is_active');
        $module->update();
        return redirect()->route('modules.index')->with("success", "Module updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        //
        $module->delete();
        return redirect()->route('modules.index')->with("success", "Module deleted successfully.");
    }

    // All deleted modules
    public function deletedModules(Request $request)
    {
        $search = $request->input('search');
        $modules = Module::query()
            ->with('course')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                        $q->orWhere('module_number', $search);
                    }

                    $q->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
        return view('modules.deleted', compact('modules'));
    }

    // restore deleted course 
    public function restoreModules(int $id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $module->restore();
        return redirect()->route('modules.deleted')->with("success", "Module restored successfully.");
    }

    // permanent delete 
    public function forceDelete(int $id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $module->forceDelete();
        return redirect()->route('modules.deleted')->with("success", "Module permanently deleted.");
    }
}
