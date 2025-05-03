<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();
        $questions = Question::latest()->paginate(10);
        return view('admin.questions.index', compact('questions','notificationCount'));
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
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Question::create($validated); // Only validated fields are passed (no _token)
        
        return redirect()->route('questions.index')->with('success', 'Question added!');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Question updated.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }
}
