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
                    $q->where('round_number', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");

                    // Search by ID only if search value is numeric
                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
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
        //
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
        return redirect()->route('rounds.index')->with('success', 'Round created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round)
    {
        //

        return view('rounds.show', compact('round'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Round $round)
    {
        //
        return view('rounds.edit', compact('round'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Round $round)
    {
        //
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
        return redirect()->route('rounds.index')->with('success', 'Round updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Round $round)
    {
        $round->delete();
        return redirect()
            ->route('rounds.index')
            ->with('success', 'Round deleted successfully.');
    }

    public function deletedRounds(Request $request)
    {
        $search = $request->input('search');

        $rounds = Round::query()
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {
                    // Search by ID only if search value is numeric
                    if (is_numeric($search)) {
                        $q->where('id', "=", $search)
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
}
