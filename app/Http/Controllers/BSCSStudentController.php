<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class BSCSStudentController extends Controller
{
    // BSIT DASHBOARD
    public function bscs()
    {
        $students = Students::where('student_course', 'BSCS')->get();
        return view('bscs', compact('students'));
    }

    // Show the create form
    public function students_add_bscs()
    {
        return view('create_bscs');
    }

    // Store a new student
    public function store_bscs(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255|unique:students,fullname',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|min:11|max:15|unique:students,contact_number',
            'school' => 'required|string|max:255',
            'strand' => 'required|string|max:255',
            'age' => 'required|numeric|max:255',
            'exam' => 'required|numeric',
            'interview' => 'required|numeric',
            'skill_test' => 'required|numeric',
            'gwa' => 'required|numeric',
        ]);


        $total = $request->exam + $request->interview + $request->skill_test + $request->gwa;
        
        $data =Students::create([
                'fullname' => $request->fullname,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'school' => $request->school,
                'strand' => $request->strand,
                'age' => $request->age,
                'exam' => $request->exam,
                'interview' => $request->interview,
                'skill_test' => $request->skill_test,
                'gwa' => $request->gwa,
                'total' => $total,
                'student_course' => 'BSCS',
            ]);
        if($data){
            return redirect()->route('bscs')->with('success', 'Student added successfully.');
        }else{
            return redirect()->route('bscs')->with('error', 'Student added failed.');
        }
        
    }
}
