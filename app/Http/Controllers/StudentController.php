<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentRegistrations;

class StudentController extends Controller
{
    // LOGIN of Student
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|in:bsit,bscs,blis',
        ]);

        $student = StudentRegistrations::where('fullname', $request->name)->first();

        if (!$student) {
            return back()->withErrors([
                'name' => 'Name not found in passed student records.',
            ])->withInput();
        }

        // ✅ Check if exam_result is already set
        if (!is_null($student->exam_result)) {
            return redirect()->route('student.dashboard')
                ->with('status', 'Error, ' . $student->fullname . ' (' . strtoupper($student->course) . ')!');
        }

        // Update student course
        $student->course = $request->course;
        $student->save();

        // Store student in session
        session([
            'student_name'   => $student->fullname,
            'student_course' => $student->course,
        ]);

        return redirect()->route('student.dashboard')
            ->with('status', 'Welcome, ' . $student->fullname . ' (' . strtoupper($student->course) . ')!');
    }




    //Dashboard of student
    public function dashboard()
    {
        if (!session()->has('student_name')) {
            return redirect()->route('student.login.form')
                ->withErrors(['name' => 'Please login first.']);
        }

        $name = session('student_name');
        return view("student.dashboard", compact('name'));
    }

    //Exit
    public function logout()
    {
        session()->forget('student_name'); // remove student session
        session()->flush(); // optional, clears everything

        return redirect()->route('student.login.form')
            ->with('status', 'You have been logged out.');
    }
}
