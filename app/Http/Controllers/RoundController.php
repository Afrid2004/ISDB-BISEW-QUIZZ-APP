<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rounds = Round::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by ID or Round Number if numeric
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('round_number', 'like', "%{$search}%");
                    } else {
                        // Otherwise search by description
                        $q->where('description', 'like', "%{$search}%");
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('rounds.index', compact('rounds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rounds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Round $round)
    {
        $request->validate([
            'round_number' => [
                'required',
                'integer',
                'min:1',
                'unique:rounds,round_number',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $round->round_number = $request->round_number;
        $round->description = $request->description;
        $round->is_active = $request->boolean('is_active');
        $round->save();

        return redirect()
            ->route('rounds.index')
            ->with('success', 'Round created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round)
    {
        return view('rounds.show', compact('round'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Round $round)
    {
        return view('rounds.edit', compact('round'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Round $round)
    {
        $request->validate([
            'round_number' => [
                'required',
                'integer',
                'min:1',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $round->round_number = $request->round_number;
        $round->description = $request->description;
        $round->is_active = $request->boolean('is_active');
        $round->update();

        return redirect()
            ->route('rounds.index')
            ->with('success', 'Round updated successfully.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(Round $round)
    {
        $round->delete();

        return redirect()
            ->route('rounds.index')
            ->with('success', 'Round deleted successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function deletedRounds(Request $request)
    {
        $search = $request->input('search');

        $rounds = Round::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', '=', $search)
                            ->orWhere('round_number', 'like', "%{$search}%");
                    } else {
                        $q->where('description', 'like', "%{$search}%");
                    }
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('rounds.deleted', compact('rounds', 'search'));
    }

    /**
     * Restore the specified soft-deleted resource.
     */
    public function restore($id)
    {
        $round = Round::withTrashed()->find($id);
        $round->restore();

        return redirect("/rounds/deleted")
            ->with("success", "Round restored successfully");
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $round = Round::withTrashed()->find($id);
        $round->forceDelete();

        return redirect()->back()
            ->with("success", "Round deleted permanently");
    }
}