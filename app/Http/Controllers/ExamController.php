<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Models\StudentRegistrations;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function start(Request $request, $name)
    {
        $fullname = $name;

        // You can limit the number of questions if needed: ->inRandomOrder()->take(10)
        $questions = Question::inRandomOrder()->get();
        return view('exam.start', [
            'questions' => $questions,
            'fullname' => $fullname,
        ]);
    }

    public function submit(Request $request, $name)
    {
        $score = 0;
        $total = count($request->questions ?? []);

        foreach ($request->questions ?? [] as $questionId => $answer) {
            $question = Question::find($questionId);
            if ($question && strtolower($question->correct_answer) == strtolower($answer)) {
                $score++;
            }
        }

        // Find the student record by fullname
        $user_exam = StudentRegistrations::where('fullname', $name)->first();

        if ($user_exam) {
            $user_exam->update([
                'exam_result' => (($score * 100) / 65) * 0.25,
            ]);
        }

        session()->forget('student_name'); // remove student session


        return redirect()->route('navigator')->with('status', 'Exam submitted successfully!');
    }
}
