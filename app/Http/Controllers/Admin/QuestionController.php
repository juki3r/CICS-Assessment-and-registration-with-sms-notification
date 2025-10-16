<?php

namespace App\Http\Controllers\Admin;

use App\Models\Timer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Models\ScoringPercentage;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();
        $questions = Question::orderBy('id', 'asc')->paginate(6);
        // fetch timer from table (adjust to your schema)
        $timerRecord = Timer::first();                 // fetch first row
        $timers = $timerRecord ? $timerRecord->timer / 60 : 60;

        $scoring = ScoringPercentage::first();

        return view('admin.questions.index', compact('questions', 'notificationCount', 'timers', 'scoring'));
    }

    public function create()
    {
        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();
        return view('admin.questions.create', compact('notificationCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|in:a,b,c,d,e',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('questions', 'public');
            $validated['image'] = $path;
        }

        Question::create($validated);

        return redirect()->route('questions.index')->with('success', 'Question added!');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|in:a,b,c,d,e',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image && \Storage::disk('public')->exists($question->image)) {
                \Storage::disk('public')->delete($question->image);
            }

            $path = $request->file('image')->store('questions', 'public');
            $validated['image'] = $path;
        }

        $question->update($validated);

        return redirect()->route('questions.index')->with('success', 'Question updated.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }
}
