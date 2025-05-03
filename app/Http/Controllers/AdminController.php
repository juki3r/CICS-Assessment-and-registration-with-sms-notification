<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admins;
use App\Models\ExamResult;
use App\Models\EntranceExam;
use Illuminate\Http\Request;
use App\Mail\GeneralNotification;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function admin_notification(Request $request)
    {
        $notificationCount = AdminNotification::where('read', false)->count();
        // Check if there is a search query and apply it
        $notifications = AdminNotification::where('read', false)
            ->when($request->search, function ($query, $search) {
                // Filter by 'message' or 'category' fields
                $query->where('message', 'like', "%$search%")
                    ->orWhere('category', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')  // Sort by latest notification
            ->paginate(10);  // Paginate the results (5 per page)
        
        // If it's an AJAX request, return just the table part
        if ($request->ajax()) {
            return view('admin.notification_table', compact('notifications'))->render();
        }

        // Return the full page if it's not an AJAX request
        return view('admin.notification', compact('notifications', 'notificationCount'));
    }

    

    //show and read notification
    public function showNotification($id, $category, $user_id)
    {
        // Find the notification by ID
        // $notification = AdminNotification::findOrFail($id);
        // // Mark as read
        // $notification->update(['read' => true]);
        // $notificationCount = AdminNotification::where('read', false)->count();
        

        //PUT extra functions to write
        if($category == 'registration')
        {
            $user = User::findOrFail($user_id);
            $notificationCount = AdminNotification::where('read', false)->count();

            // Find the notification by ID
            $notification = AdminNotification::findOrFail($id);
            // Mark as read
            $notification->update(['read' => true]);
            return view('admin.notification_detail_student', compact(['notificationCount','user'])); 
        }
        else if(in_array($category, ['exam', 'gwa', 'interview', 'skill_test']))
        {
            $notificationCount = AdminNotification::where('read', false)->count();

            // Find the notification by ID
            $notification = AdminNotification::findOrFail($id);
            $user_modified = Admins::findOrFail($notification->user_id)->fullname;
            // Mark as read
            $notification->update(['read' => true]);

            // Example: get student from notification message
            preg_match("/student ID #(\d+)/", $notification->message, $matches);

            $student = null;
            if (!empty($matches[1])) {
                $studentId = $matches[1];
                $student = User::find($studentId);
            }
            return view('admin.notification_detail_non_student', compact(['notificationCount','notification', 'user_modified', 'student'])); 
        }
       


        // $user->update(['is_new_register' => false]);
        // $user_email = $user->email;
        // $user_phoneNumber = $user->phone_number;

        // //Send Email to admin
        // Mail::to($user_email)->send(
        //     new GeneralNotification('Registration approved', 'Hello, You can now proceed to the next task. have a good day.')
        // );
        // //Add here for sms
        
    }

    //Admin approval for new students
    public function admin_approval()
    {   
        $notificationCount = AdminNotification::where('read', false)->count();
        // Fetch only unread notifications and sort them by created_at (latest first)
        $newstudents = User::where('is_new_register', true)
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        return view('admin.new_students_approval', compact(['newstudents', 'notificationCount']));
    }

    public function admin_student_details($id)
    {
        $notificationCount = AdminNotification::where('read', false)->count();
        // Mark as read
        $user = User::findOrFail($id);
        return view('admin.notification_detail_student', compact(['notificationCount','user'])); 
    }

    public function admin_approved_student($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_new_register' => false]);
        return redirect('admin/dashboard')->with('message', 'New student approved.');
    }
    // Deny student - user will be deleted
    public function admin_denied_student($id)   
    {
        $user = User::findOrFail($id);
        $user->delete(); // This deletes the user

        return redirect('admin.dashboard')->with('alert_message', 'Student has been denied and deleted.');
    }

    // Show students
    public function show_students($course)   
    {
        $notificationCount = AdminNotification::where('read', false)->count();
        $students = User::where('course', $course)->where('is_new_register', false)->get();
        return view('admin.show_students', compact(['notificationCount', 'students']));
    }

    // Show students
    public function show_exam_results($course)   
    {
        $notificationCount = AdminNotification::where('read', false)->count();
        $students = User::where('course', $course)->get();
        $students_exam_results = ExamResult::where('course', $course)->get();


        return view('admin.show_students_exam_results', compact(['notificationCount', 'students_exam_results', 'students']));
    }

    //ADMINS register
    public function register()
    {
        return view('admin.register');
    }

    public function login()
    {
        return view('admin.login');
    }


    public function register_save(Request $request)
    {
        $request->validate([
            'fullname' => 'required|unique:admins,fullname',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8',
        ]);

        Admins::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password), // bcrypt version
        ]);

        return redirect()->route('admin.login')->with('message', 'Admin registered successfully, Login to continue!');
    }


    public function login_proceed(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');

        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }

    public function dashboard()
    { 
         // Count the number of each remark
         $passed = ExamResult::where('remarks', 'passed')->count();
         $failed = ExamResult::where('remarks', 'failed')->count();
         $pending = ExamResult::where('remarks', 'pending')->count();



        $notificationCount = AdminNotification::where('read', false)->count();
        return view('admin.dashboard', compact('notificationCount', 'passed', 'failed', 'pending'));
    }

    public function updateExamField(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:exam_results,id',
            'field' => 'required|string|in:exam,interview,gwa',
            'value' => 'required'
        ]);

        $result = ExamResult::findOrFail($request->id);
        $old = $result->{$request->field};

        $result->{$request->field} = $request->value;
        $result->save();

        // Log the update in admin_notifications with dynamic category
        $admin = auth('admin')->user(); // Get the currently authenticated admin user

        if ($admin) {
            AdminNotification::create([
                'message' => "Updated '{$request->field}' from '{$old}' to '{$request->value}' for student ID #{$result->user_id}",
                'category' => $request->field,
                'user_id' => Auth::guard('admin')->user()->id,
            ]);
        } else {
            return response()->json(['error' => 'Admin not logged in'], 401);
        }

        return response()->json(['success' => true]);
    }


    //Entrance Exam
    public function entrance_exam()
    {

        // Fetch all data from the EntranceExam model
        $entranceExams = EntranceExam::all();

        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();

        // Return the view with data
        return view('admin.entranceexam', compact('notificationCount', 'entranceExams'));
    }

    public function save_passed_student(Request $request)
    {
        // Validate input
        $request->validate([
            'fullname' => 'required|string|max:255|unique:entrance_exams,fullname',
            // 'status' => 'required|in:Pending,Failed,Passed',
        ]);

        // Create record in EntranceExam table
        EntranceExam::create([
            'fullname' => $request->fullname,
            // 'status' => $request->status,
        ]);

        $notificationCount = AdminNotification::where('read', false)->count();

        return redirect()->route('entrance_exam')->with([
            'success' => 'Student added successfully!',
            'notificationCount' => $notificationCount
        ]);
    }

    public function delete_entrance($id)
    {
        // Find the entrance exam record by its ID
        $entranceExam = EntranceExam::find($id);
    
        // Check if the record exists
        if ($entranceExam) {
            // Delete the record
            $entranceExam->delete();
    
            // Redirect back to the entrance exam page with a success message
            return redirect()->route('entrance_exam')->with('success', 'Student deleted successfully!');
        }
    
        // If the record was not found, redirect with an error message
        return redirect()->route('entrance_exam')->with('alert_message', 'Student not found.');
    }






}
