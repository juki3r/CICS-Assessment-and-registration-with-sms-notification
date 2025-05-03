<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Mail\GeneralNotification;
use App\Models\AdminNotification;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;



class MainController extends Controller
{
    public function dashboard()
    {  
        $user_exam = ExamResult::where('user_id', Auth::user()->id)->firstOrFail();
        

        $notificationCount = AdminNotification::where('read', false)->count();
        return view('dashboard', compact('notificationCount', 'user_exam'));
    }



   

     // BSIT DASHBOARD
     public function show(Request $request)
     {
         $student_course = $request->student_course;
         $students = Students::where('student_course', $student_course)->get();
         return view('show', compact('students', 'student_course'));
     }
 
     // Show the create form
     public function students_add($task, $student_course)
     {
         // return view('create');
         
         $task = $task;
         $student_course = $student_course;
         return view('students.create', compact('task', 'student_course'));
 
     }
 
     // Store a new student
     public function store(Request $request, $student_course, $task)
     {
         // Validate form inputs
         $request->validate([
             'fullname' => 'required|string|max:255|unique:students,fullname',
             'address' => 'required|string|max:255',
             'contact_number' => 'required|string|min:11|max:15|unique:students,contact_number',
             'school' => 'required|string|max:255',
             'strand' => 'required|string|max:255',
             'age' => 'required|numeric|max:255',
             'exam' => 'nullable|numeric',
             'interview' => 'nullable|numeric',
             'skill_test' => 'nullable|numeric',
             'gwa' => 'nullable|numeric',
         ]);
 
         // Safely handle potential null values
         $exam = $request->exam ?? 0;
         $interview = $request->interview ?? 0;
         $skill_test = $request->skill_test ?? 0;
         $gwa = $request->gwa ?? 0;
 
         $total = $exam + $interview + $skill_test + $gwa;
 
         // Create student
         $student = Students::create([
             'fullname' => $request->fullname,
             'address' => $request->address,
             'contact_number' => $request->contact_number,
             'school' => $request->school,
             'strand' => $request->strand,
             'age' => $request->age,
             'exam' => $exam,
             'interview' => $interview,
             'skill_test' => $skill_test,
             'gwa' => $gwa,
             'total' => $total,
             'student_course' => $student_course,
         ]);

         

         //STORE LOGS
         Report::create([
            'user_id' => auth()->id(),
            'firstname' => Auth::user()->firstname,
            'lastname' => Auth::user()->lastname,
            'name_of_student' => $request->fullname,
            'activity' => 'Adding student',
            'task' => $task,
            'course' => $student_course,
        ]);
 
         // Redirect with message
         if ($student) {
             return redirect()->route('main', ['student_course' => $student_course])
                             ->with('success', 'Student added successfully.');
         } else {
             return redirect()->route('main', ['student_course' => $student_course])
                             ->with('error', 'Student add failed.');
         }
     }
 
 
     
 
 
 
 
 
     // Show edit form
     public function edit($id)
     {
         $student = Students::findOrFail($id);
         return view('edit', compact('student'));
     }
 
     // Update student
     public function update(Request $request, $id)
     {
         
         $request->validate([
             'fullname' => 'required|string|max:255',
             'exam' => 'required|numeric',
             'interview' => 'required|numeric',
             'skill_test' => 'required|numeric',
             'gwa' => 'required|numeric',
         ]);
 
         $student_course = Students::findOrFail($id)->student_course;
       
 
 
         $student = Students::findOrFail($id);
         $student->update([
             'fullname' => $request->fullname,
             'exam' => $request->exam,
             'interview' => $request->interview,
             'skill_test' => $request->skill_test,
             'gwa' => $request->gwa,
             'total' => $request->exam + $request->interview + $request->skill_test + $request->gwa,
         ]);
         if($student_course == "BSIT")
         {
             return redirect()->route('bsit')->with('success', 'Student updated successfully.');
         }
         else if($student_course == "BSCS")
         {
             return redirect()->route('bscs')->with('success', 'Student updated successfully.');
         }
     }
 
     // Delete student
     public function destroy($id)
     {
         $student = Students::findOrFail($id);
         $student->delete();
 
         return redirect()->route('bsit')->with('success', 'Student deleted successfully.');
     }


     //REPORTS
     public function show_reports()
     {
        $reports = Report::get();
         return view('reports', compact('reports'));
     }







}
