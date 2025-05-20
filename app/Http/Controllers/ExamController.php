<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function start()
    {
        // Prevent retake
        if (ExamResult::where('user_id', Auth::id())->exists()) {
            return redirect()->route('dashboard')->with('alert_message', 'You already took the exam.');
        }

        // Track exam start
        if (!session()->has('exam_start')) {
            session(['exam_start' => now()]);
        }

        // Check if time expired
        $start = session('exam_start');
        if (now()->diffInMinutes($start) >= 60) {
            return redirect()->route('dashboard')->with('alert_message', 'Your 1-hour exam time is up.');
        }
        
        // You can limit the number of questions if needed: ->inRandomOrder()->take(10)
        $questions = Question::inRandomOrder()->get();
        return view('exam.start', compact('questions'));
    }

    public function submit(Request $request)
    {
        $score = 0;
        $total = count($request->questions ?? []);

        foreach ($request->questions ?? [] as $questionId => $answer) {
            $question = Question::find($questionId);
            if ($question && strtolower($question->correct_answer) == strtolower($answer)) {
                $score++;
            }
        }

        $user_exam = ExamResult::where('user_id', Auth::user()->id)->firstOrFail();
        $user_exam->update(['exam' => $score]);

        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();

        return view('exam.result', [
            'score' => $score,
            'total' => $total,
            'notificationCount' => $notificationCount,
        ]);
    }
}
