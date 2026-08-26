<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $trainingCenters = TrainingCenter::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('code', 'like', "%{$search}%");
                    } else {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%");
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('training_centers.index', compact('trainingCenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('training_centers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TrainingCenter $trainingCenter)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:50', 'unique:training_centers,code'],
            'location' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $trainingCenter->name = $request->name;
        $trainingCenter->code = $request->code;
        $trainingCenter->location = $request->location;
        $trainingCenter->is_active = $request->boolean('is_active');
        $trainingCenter->save();

        return redirect()
            ->route('training-centers.index')
            ->with('success', 'Training center created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingCenter $trainingCenter)
    {
        return view('training_centers.show', compact('trainingCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingCenter $trainingCenter)
    {
        return view('training_centers.edit', compact('trainingCenter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCenter $trainingCenter)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:50', 'unique:training_centers,code,' . $trainingCenter->id],
            'location' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $trainingCenter->name = $request->name;
        $trainingCenter->code = $request->code;
        $trainingCenter->location = $request->location;
        $trainingCenter->is_active = $request->boolean('is_active');
        $trainingCenter->update();

        return redirect()
            ->route('training-centers.index')
            ->with('success', 'Training center updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingCenter $trainingCenter)
    {
        $trainingCenter->delete();
        return redirect()
            ->route('training-centers.index')
            ->with('success', 'Training center deleted successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function deletedTrainingCenters(Request $request)
    {
        $search = $request->input('search');

        $trainingCenters = TrainingCenter::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('code', 'like', "%{$search}%");
                    } else {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%");
                    }
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('training_centers.deleted', compact('trainingCenters', 'search'));
    }

    /**
     * Restore the specified soft-deleted resource.
     */
    public function restore($id)
    {
        $trainingCenter = TrainingCenter::withTrashed()->find($id);
        $trainingCenter->restore();

        return redirect("/training-centers/deleted")
            ->with("success", "Training center restored successfully");
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $trainingCenter = TrainingCenter::withTrashed()->find($id);
        $trainingCenter->forceDelete();

        return redirect()->back()
            ->with("success", "Training center deleted permanently");
    }
}