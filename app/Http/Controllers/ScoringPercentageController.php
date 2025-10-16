<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ScoringPercentage;

class ScoringPercentageController extends Controller
{
    public function index()
    {
        $scoring = ScoringPercentage::first();
        return view('scoring.index', compact('scoring'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'interview' => 'required|numeric|min:0|max:1',
            'gwa'       => 'required|numeric|min:0|max:1',
            'skilltest' => 'required|numeric|min:0|max:1',
            'exam'      => 'required|numeric|min:0|max:1',
        ]);

        $scoring = ScoringPercentage::first();

        if (!$scoring) {
            $scoring = ScoringPercentage::create($request->only(['interview', 'gwa', 'skilltest', 'exam']));
        } else {
            $scoring->update($request->only(['interview', 'gwa', 'skilltest', 'exam']));
        }

        return redirect()
            ->route('show.questions')
            ->with('success', 'Scoring percentages updated successfully!');
    }
}
