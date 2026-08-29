<?php

namespace App\Http\Controllers;

use App\Models\CompetencyUnit;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompetencyUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $competencyUnits = CompetencyUnit::with('module.course')
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    $q->orWhereHas('module', function ($moduleQuery) use ($search) {

                        $moduleQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('module_number', $search);

                        $moduleQuery->orWhereHas('course', function ($courseQuery) use ($search) {

                            $courseQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        });
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('competency-units.index', compact('competencyUnits'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)
            ->get();

        return view('competency-units.create', compact('courses'));
    }


    /**
     * Get modules by course.
     */
    public function modulesByCourse($courseId)
    {
        $modules = Module::where('course_id', $courseId)
            ->where('is_active', true)
            ->orderBy('module_number')
            ->get();

        return response()->json($modules);
    }

    /**
     * Get next serial.
     */
    public function nextSerial($moduleId)
    {
        $last = CompetencyUnit::where('module_id', $moduleId)
            ->orderByDesc('id')
            ->first();

        if ($last) {
            $serial = $last->serial + 1;
        } else {
            $serial = 1;
        }

        return response()->json([
            'serial' => $serial
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'prefix' => [
                'required',
                'string',
                'max:10',
                'alpha'
            ],

            'course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
            ],

            'module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        $module = Module::with('course')
            ->where('id', $request->module_id)
            ->where('course_id', $request->course_id)
            ->firstOrFail();
        $courseCode = strtoupper($module->course->code);
        $moduleNumber = $module->module_number;

        // Find last serial of this module
        $lastCompetencyUnit = CompetencyUnit::where('module_id', $module->id)
            ->orderByDesc('serial')
            ->first();

        if ($lastCompetencyUnit) {
            $serial = $lastCompetencyUnit->serial + 1;
        } else {
            $serial = 1;
        }

        // Generate code
        $code = strtoupper($request->prefix)
            . $courseCode
            . $moduleNumber
            . str_pad($serial, 2, '0', STR_PAD_LEFT);
        // Save
        $competencyUnit = new CompetencyUnit();

        $competencyUnit->module_id = $module->id;
        $competencyUnit->prefix = strtoupper($request->prefix);
        $competencyUnit->serial = $serial;
        $competencyUnit->code = $code;
        $competencyUnit->is_active = $request->boolean('is_active');

        $competencyUnit->save();
        return redirect()
            ->route('competency-units.index')
            ->with(
                'success',
                'Competency Unit created successfully.'
            );
    }


    /**
     * Display the specified resource.
     */
    public function show(CompetencyUnit $competencyUnit)
    {
        return view(
            'competency-units.show',
            compact('competencyUnit')
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompetencyUnit $competencyUnit)
    {
        $courses = Course::where('is_active', true)
            ->get();

        return view(
            'competency-units.edit',
            compact('competencyUnit', 'courses')
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        CompetencyUnit $competencyUnit
    ) {

        $request->validate([

            'prefix' => [
                'required',
                'string',
                'max:10',
                'alpha'
            ],

            'course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
            ],

            'module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        $module = Module::where('id', $request->module_id)
            ->where('course_id', $request->course_id)
            ->firstOrFail();


        $course = Course::findOrFail($request->course_id);


        /*
        |--------------------------------------------------------------------------
        | Generate code only if module changed
        |--------------------------------------------------------------------------
        */

        if ($module->id != $competencyUnit->module_id) {

            $lastCompetencyUnit = CompetencyUnit::where(
                'module_id',
                $module->id
            )
                ->orderByDesc('id')
                ->first();

            if ($lastCompetencyUnit) {

                $serial = (int) substr(
                    $lastCompetencyUnit->code,
                    -2
                ) + 1;
            } else {

                $serial = 1;
            }

            $serial = str_pad(
                $serial,
                2,
                '0',
                STR_PAD_LEFT
            );


            $competencyUnit->code =
                strtoupper($request->prefix)
                . strtoupper($course->code)
                . $module->module_number
                . $serial;
        }


        $competencyUnit->module_id = $module->id;
        $competencyUnit->prefix = strtoupper($request->prefix);
        $competencyUnit->is_active = $request->boolean('is_active');

        $competencyUnit->update();


        return redirect()
            ->route('competency-units.index')
            ->with(
                'success',
                'Competency Unit updated successfully.'
            );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompetencyUnit $competencyUnit)
    {
        $competencyUnit->delete();

        return redirect()
            ->route('competency-units.index')
            ->with(
                'success',
                'Competency Unit deleted successfully.'
            );
    }


    /**
     * All deleted competency units.
     */
    public function deletedCompetencyUnits(Request $request)
    {
        $search = $request->input('search');

        $competencyUnits = CompetencyUnit::with('module.course')
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'competency-units.deleted',
            compact('competencyUnits')
        );
    }


    /**
     * Restore competency unit.
     */
    public function restoreCompetencyUnit(int $id)
    {
        $competencyUnit = CompetencyUnit::withTrashed()
            ->findOrFail($id);

        $competencyUnit->restore();

        return redirect()
            ->route('competency-units.deleted')
            ->with(
                'success',
                'Competency Unit restored successfully.'
            );
    }


    /**
     * Permanently delete competency unit.
     */
    public function forceDelete(int $id)
    {
        $competencyUnit = CompetencyUnit::withTrashed()
            ->findOrFail($id);

        $competencyUnit->forceDelete();

        return redirect()
            ->route('competency-units.deleted')
            ->with(
                'success',
                'Competency Unit permanently deleted.'
            );
    }
}
