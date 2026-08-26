<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Round;
use App\Models\TrainingCenter;
use App\Models\Shift;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $batches = Batch::with(['round', 'trainingCenter', 'shift'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('batch_number', 'like', "%{$search}%")
                            ->orWhere('max_students', '=', (int)$search);
                    } else {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rounds = Round::where('is_active', true)->orderBy('round_number')->get();
        $trainingCenters = TrainingCenter::where('is_active', true)->orderBy('name')->get();
        $shifts = Shift::where('is_active', true)->orderBy('name')->get();

        return view('batches.create', compact('rounds', 'trainingCenters', 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Batch $batch)
    {
        $request->validate([
            'round_id' => ['required', 'exists:rounds,id'],
            'training_center_id' => ['required', 'exists:training_centers,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'batch_number' => ['required', 'string', 'max:50', 'unique:batches,batch_number'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $batch->round_id = $request->round_id;
        $batch->training_center_id = $request->training_center_id;
        $batch->shift_id = $request->shift_id;
        $batch->batch_number = $request->batch_number;
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->max_students = $request->max_students ?? 50;
        $batch->is_active = $request->boolean('is_active');
        $batch->save();

        return redirect()
            ->route('batches.index')
            ->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        $batch->load(['round', 'trainingCenter', 'shift']);
        return view('batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        $rounds = Round::where('is_active', true)->orderBy('round_number')->get();
        $trainingCenters = TrainingCenter::where('is_active', true)->orderBy('name')->get();
        $shifts = Shift::where('is_active', true)->orderBy('name')->get();

        return view('batches.edit', compact('batch', 'rounds', 'trainingCenters', 'shifts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'round_id' => ['required', 'exists:rounds,id'],
            'training_center_id' => ['required', 'exists:training_centers,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'batch_number' => ['required', 'string', 'max:50', 'unique:batches,batch_number,' . $batch->id],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $batch->round_id = $request->round_id;
        $batch->training_center_id = $request->training_center_id;
        $batch->shift_id = $request->shift_id;
        $batch->batch_number = $request->batch_number;
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->max_students = $request->max_students ?? 50;
        $batch->is_active = $request->boolean('is_active');
        $batch->update();

        return redirect()
            ->route('batches.index')
            ->with('success', 'Batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()
            ->route('batches.index')
            ->with('success', 'Batch deleted successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function deletedBatches(Request $request)
    {
        $search = $request->input('search');

        $batches = Batch::onlyTrashed()
            ->with(['round', 'trainingCenter', 'shift'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('batch_number', 'like', "%{$search}%");
                    } else {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('batches.deleted', compact('batches', 'search'));
    }

    /**
     * Restore the specified soft-deleted resource.
     */
    public function restore($id)
    {
        $batch = Batch::withTrashed()->find($id);
        $batch->restore();

        return redirect("/batches/deleted")
            ->with("success", "Batch restored successfully");
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $batch = Batch::withTrashed()->find($id);
        $batch->forceDelete();

        return redirect()->back()
            ->with("success", "Batch deleted permanently");
    }
}