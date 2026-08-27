<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Round;
use App\Models\TrainingCenter;
use App\Models\Shift;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $batches = Batch::with(['round', 'course', 'trainingCenter', 'shift'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)->orWhere('batch_number', 'like', "%{$search}%")->orWhere('max_students', (int) $search);
                    } else {
                        $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")->orWhereHas('course', function ($courseQuery) use ($search) {
                            $courseQuery->where('name', 'like', "%{$search}%");
                        });
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('batches.index', compact('batches'));
    }

    public function create()
    {
        $rounds = Round::where('is_active', true)->orderBy('round_number')->get();
        $courses = Course::where('is_active', true)->orderBy('name')->get();
        $trainingCenters = TrainingCenter::where('is_active', true)->orderBy('name')->get();
        $shifts = Shift::where('is_active', true)->orderBy('name')->get();

        return view('batches.create', compact('rounds', 'courses', 'trainingCenters', 'shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'round_id' => ['required', 'exists:rounds,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'training_center_id' => ['required', 'exists:training_centers,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'batch_number' => ['required', 'string', 'max:50', 'unique:batches,batch_number'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $batch = new Batch();
        $batch->round_id = $request->round_id;
        $batch->course_id = $request->course_id;
        $batch->training_center_id = $request->training_center_id;
        $batch->shift_id = $request->shift_id;
        $batch->batch_number = $request->batch_number;
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->max_students = $request->max_students ?? 50;
        $batch->is_active = $request->boolean('is_active');
        $batch->save();

        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function show(Batch $batch)
    {
        $batch->load(['round', 'course', 'trainingCenter', 'shift']);

        return view('batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        $rounds = Round::where('is_active', true)->orderBy('round_number')->get();
        $courses = Course::where('is_active', true)->orderBy('name')->get();
        $trainingCenters = TrainingCenter::where('is_active', true)->orderBy('name')->get();
        $shifts = Shift::where('is_active', true)->orderBy('name')->get();

        return view('batches.edit', compact('batch', 'rounds', 'courses', 'trainingCenters', 'shifts'));
    }

    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'round_id' => ['required', 'exists:rounds,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'training_center_id' => ['required', 'exists:training_centers,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'batch_number' => ['required', 'string', 'max:50', 'unique:batches,batch_number,' . $batch->id],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $batch->round_id = $request->round_id;
        $batch->course_id = $request->course_id;
        $batch->training_center_id = $request->training_center_id;
        $batch->shift_id = $request->shift_id;
        $batch->batch_number = $request->batch_number;
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->max_students = $request->max_students ?? 50;
        $batch->is_active = $request->boolean('is_active');
        $batch->save();

        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }

    public function deletedBatches(Request $request)
    {
        $search = $request->input('search');

        $batches = Batch::onlyTrashed()
            ->with(['round', 'course', 'trainingCenter', 'shift'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)->orWhere('batch_number', 'like', "%{$search}%");
                    } else {
                        $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")->orWhereHas('course', function ($courseQuery) use ($search) {
                            $courseQuery->where('name', 'like', "%{$search}%");
                        });
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('batches.deleted', compact('batches', 'search'));
    }

    public function restore($id)
    {
        $batch = Batch::withTrashed()->findOrFail($id);
        $batch->restore();

        return redirect('/batches/deleted')->with('success', 'Batch restored successfully.');
    }

    public function forceDelete($id)
    {
        $batch = Batch::withTrashed()->findOrFail($id);
        $batch->forceDelete();

        return redirect()->back()->with('success', 'Batch deleted permanently.');
    }
}
