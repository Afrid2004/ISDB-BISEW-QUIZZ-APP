<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $shifts = Shift::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('code', 'like', "%{$search}%");
                    } else {
                        $q->where('name', 'like', "%{$search}%");
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('shifts.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:shifts,code',
            ],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $shift->name = $request->name;
        $shift->code = $request->code;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->is_active = $request->boolean('is_active');
        $shift->save();

        return redirect()
            ->route('shifts.index')
            ->with('success', 'Shift created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        return view('shifts.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:shifts,code,' . $shift->id,
            ],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $shift->name = $request->name;
        $shift->code = $request->code;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->is_active = $request->boolean('is_active');
        $shift->update();

        return redirect()
            ->route('shifts.index')
            ->with('success', 'Shift updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()
            ->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources (Disabled since no soft deletes).
     */
    public function deletedShifts(Request $request)
    {
        return redirect()
            ->route('shifts.index')
            ->with('info', 'Soft deletes are not enabled for the shifts module.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id)
    {
        return redirect()->route('shifts.index');
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        return redirect()->route('shifts.index');
    }
}