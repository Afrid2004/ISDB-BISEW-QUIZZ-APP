<?php

namespace App\Http\Controllers;

use App\Models\CompetencyUnit;
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

        $competencyUnits = CompetencyUnit::query()
            ->with('module.course')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    $q->orWhereHas('module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('name', 'like', "%{$search}%")
                            ->orWhereHas('course', function ($courseQuery) use ($search) {
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
        $modules = Module::where('is_active', true)->whereNull('deleted_at')->get();
        return view('competency-units.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Removing extra spaces
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);

        $request->validate([
            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'competency_unit_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean']
        ]);

        $competencyUnit = new CompetencyUnit();
        $competencyUnit->module_id = $request->module_id;
        $competencyUnit->name = $request->name;
        $competencyUnit->description = $request->description;
        $competencyUnit->competency_unit_order = $request->competency_unit_order;
        $competencyUnit->is_active = $request->boolean('is_active');
        $competencyUnit->save();

        return redirect()->route('competency-units.index')->with('success', 'Competency Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompetencyUnit $competencyUnit)
    {
        return view('competency-units.show', compact('competencyUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompetencyUnit $competencyUnit)
    {
        $modules = Module::where('is_active', true)->whereNull('deleted_at')->get();
        return view('competency-units.edit', compact('competencyUnit', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompetencyUnit $competencyUnit)
    {
        // Removing extra spaces
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name))
        ]);
        $request->validate([
            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'competency_unit_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean']
        ]);
        $competencyUnit->module_id = $request->module_id;
        $competencyUnit->name = $request->name;
        $competencyUnit->description = $request->description;
        $competencyUnit->competency_unit_order = $request->competency_unit_order;
        $competencyUnit->is_active = $request->boolean('is_active');
        $competencyUnit->update();
        return redirect()->route('competency-units.index')->with('success', 'Competency Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompetencyUnit $competencyUnit)
    {
        $competencyUnit->delete();
        return redirect()->route('competency-units.index')->with('success', 'Competency Unit deleted successfully.');
    }

    /**
     * All deleted competency units.
     */
    public function deletedCompetencyUnits(Request $request)
    {
        $search = $request->input('search');
        $competencyUnits = CompetencyUnit::query()
            ->with('module.course')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    $q->orWhereHas('module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('name', 'like', "%{$search}%")
                            ->orWhereHas('course', function ($courseQuery) use ($search) {
                                $courseQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('code', 'like', "%{$search}%");
                            });
                    });
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('competency-units.deleted', compact('competencyUnits'));
    }

    /**
     * Restore deleted competency unit.
     */
    public function restoreCompetencyUnit(int $id)
    {
        $competencyUnit = CompetencyUnit::withTrashed()->findOrFail($id);
        $competencyUnit->restore();
        return redirect()->route('competency-units.deleted')->with('success', 'Competency Unit restored successfully.');
    }

    /**
     * Permanently delete competency unit.
     */
    public function forceDelete(int $id)
    {
        $competencyUnit = CompetencyUnit::withTrashed()->findOrFail($id);
        $competencyUnit->forceDelete();
        return redirect()->route('competency-units.deleted')->with('success', 'Competency Unit permanently deleted.');
    }
}
