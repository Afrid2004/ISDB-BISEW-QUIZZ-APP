<?php

namespace App\Http\Controllers;

use App\Models\CompetencyUnit;
use App\Models\Element;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $elements = Element::query()
            ->with('competencyUnit.module.course')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('elements.name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('elements.id', $search);
                    }

                    $q->orWhereHas('competencyUnit', function ($cq) use ($search) {
                        $cq->where('competency_units.code', 'like', "%{$search}%");

                        $cq->orWhereHas('module', function ($mq) use ($search) {
                            $mq->where('modules.name', 'like', "%{$search}%");

                            $mq->orWhereHas('course', function ($courseQuery) use ($search) {
                                $courseQuery->where('courses.name', 'like', "%{$search}%");
                                $courseQuery->orWhere('courses.code', 'like', "%{$search}%");
                            });
                        });
                    });
                });
            })
            ->join('competency_units', 'elements.competency_unit_id', '=', 'competency_units.id')
            ->orderBy('competency_units.code', 'asc')
            ->select('elements.*')
            ->paginate(10)
            ->withQueryString();

        return view('elements.index', compact('elements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $currentCourse = null;
        $currentModule = null;
        $currentCompetencyUnit = null;

        return view('elements.create', compact('courses', 'currentCourse', 'currentModule', 'currentCompetencyUnit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);

        $request->validate([
            'competency_unit_id' => [
                'required',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],
            'name' => [
                'required',
                'string',
                'max:150'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'is_active' => [
                'nullable',
                'boolean'
            ]
        ]);

        $element = new Element();
        $element->competency_unit_id = $request->competency_unit_id;
        $element->name = $request->name;
        $element->description = $request->description;
        $element->is_active = $request->boolean('is_active');
        $element->save();

        return redirect()
            ->route('elements.index')
            ->with('success', 'Element created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Element $element)
    {
        $element->load('competencyUnit.module.course');

        return view('elements.show', compact('element'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Element $element)
    {
        $element->load('competencyUnit.module.course');

        $courses = Course::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $currentCompetencyUnit = $element->competencyUnit;
        $currentModule = $currentCompetencyUnit?->module;
        $currentCourse = $currentModule?->course;

        return view('elements.edit', compact('element', 'courses', 'currentCourse', 'currentModule', 'currentCompetencyUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Element $element)
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);

        $request->validate([
            'competency_unit_id' => [
                'required',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],
            'name' => [
                'required',
                'string',
                'max:150'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'is_active' => [
                'nullable',
                'boolean'
            ]
        ]);

        $element->competency_unit_id = $request->competency_unit_id;
        $element->name = $request->name;
        $element->description = $request->description;
        $element->is_active = $request->boolean('is_active');
        $element->update();

        return redirect()
            ->route('elements.index')
            ->with('success', 'Element updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Element $element)
    {
        $element->delete();

        return redirect()
            ->route('elements.index')
            ->with('success', 'Element deleted successfully.');
    }

    /**
     * Get modules by course.
     */
    public function modulesByCourse($courseId)
    {
        $modules = Module::where('course_id', $courseId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('module_number')
            ->get(['id', 'name', 'module_number']);

        return response()->json($modules);
    }

    /**
     * Get competency units by module.
     */
    public function competencyUnitsByModule($moduleId)
    {
        $competencyUnits = CompetencyUnit::where('module_id', $moduleId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get(['id', 'code', 'module_id']);

        return response()->json($competencyUnits);
    }

    /**
     * All deleted elements.
     */
    public function deletedElements(Request $request)
    {
        $search = trim($request->input('search', ''));

        $elements = Element::onlyTrashed()
            ->with('competencyUnit.module.course')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('elements.name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('elements.id', $search);
                    }

                    $q->orWhereHas('competencyUnit', function ($cq) use ($search) {
                        $cq->where('competency_units.code', 'like', "%{$search}%");

                        $cq->orWhereHas('module', function ($mq) use ($search) {
                            $mq->where('modules.name', 'like', "%{$search}%");

                            $mq->orWhereHas('course', function ($courseQuery) use ($search) {
                                $courseQuery->where('courses.name', 'like', "%{$search}%");
                                $courseQuery->orWhere('courses.code', 'like', "%{$search}%");
                            });
                        });
                    });
                });
            })
            ->join('competency_units', 'elements.competency_unit_id', '=', 'competency_units.id')
            ->orderBy('competency_units.code', 'asc')
            ->select('elements.*')
            ->paginate(10)
            ->withQueryString();

        return view('elements.deleted', compact('elements'));
    }

    /**
     * Restore deleted element.
     */
    public function restoreElement(int $id)
    {
        $element = Element::withTrashed()->findOrFail($id);
        $element->restore();

        return redirect()
            ->route('elements.deleted')
            ->with('success', 'Element restored successfully.');
    }

    /**
     * Permanently delete element.
     */
    public function forceDelete(int $id)
    {
        $element = Element::withTrashed()->findOrFail($id);
        $element->forceDelete();

        return redirect()
            ->route('elements.deleted')
            ->with('success', 'Element permanently deleted.');
    }
}
