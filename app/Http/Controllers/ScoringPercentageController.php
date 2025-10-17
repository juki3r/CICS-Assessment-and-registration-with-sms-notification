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
            'interview' => 'required|numeric|min:0|max:100',
            'gwa'       => 'required|numeric|min:0|max:100',
            'skilltest' => 'required|numeric|min:0|max:100',
            'exam'      => 'required|numeric|min:0|max:100',
        ]);

        // Convert percentages to decimal form
        $data = [
            'interview' => $request->interview / 100,
            'gwa'       => $request->gwa / 100,
            'skilltest' => $request->skilltest,
            'exam'      => $request->exam / 100,
        ];

        $scoring = ScoringPercentage::first();

        if (!$scoring) {
            $scoring = ScoringPercentage::create($data);
        } else {
            $scoring->update($data);
        }

        return redirect()
            ->route('show.questions')
            ->with('success', 'Scoring percentages updated successfully!');
    }
}
