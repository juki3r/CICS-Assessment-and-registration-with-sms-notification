<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class BLISStudentsController extends Controller
{
    // BLIS DASHBOARD
    public function blis()
    {
        $students = Students::where('student_course', 'BLIS')->get();
        return view('blis', compact('students'));
    }

    // Show the create form
    public function students_add_blis()
    {
        return view('create_blis');
    }

    // Store a new student
    public function store_blis(Request $request)
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
                'student_course' => 'BLIS',
            ]);
        if($data){
            return redirect()->route('blis')->with('success', 'Student added successfully.');
        }else{
            return redirect()->route('blis')->with('error', 'Student added failed.');
        }
        
    }

}
