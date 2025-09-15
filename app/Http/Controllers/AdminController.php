<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admins;
use App\Models\SubAdmin;
use App\Models\AdminNotif;
use App\Models\ExamResult;
use App\Models\EntranceExam;
use Illuminate\Http\Request;
use App\Mail\GeneralNotification;
use App\Models\AdminNotification;
use App\Models\StudentRegistrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
        if ($category == 'registration') {
            $user = User::findOrFail($user_id);
            $notificationCount = AdminNotification::where('read', false)->count();

            // Find the notification by ID
            $notification = AdminNotification::findOrFail($id);
            // Mark as read
            $notification->update(['read' => true]);
            return view('admin.notification_detail_student', compact(['notificationCount', 'user']));
        } else if (in_array($category, ['exam', 'gwa', 'interview', 'skill_test'])) {
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
            return view('admin.notification_detail_non_student', compact(['notificationCount', 'notification', 'user_modified', 'student']));
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
        return view('admin.notification_detail_student', compact(['notificationCount', 'user']));
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
        $students = User::where('course', $course)->where('is_new_register', true)->get();
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
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin') {
            $notificationCount = AdminNotification::where('read', false)->count();
            return view('admin.dashboard', compact('notificationCount'));
        }

        // if not admin, redirect somewhere else
        return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
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
        $entranceExams = StudentRegistrations::all();

        // Count notifications
        $notificationCount = AdminNotification::where('read', false)->count();

        // Return the view with data
        return view('admin.entranceexam', compact('notificationCount', 'entranceExams'));
    }

    public function save_passed_student(Request $request)
    {
        // Validate input
        $request->validate([
            'fullname' => 'required|string|max:255|unique:student_registrations,fullname',
            // 'status' => 'required|in:Pending,Failed,Passed',
        ]);

        // Create record in EntranceExam table
        StudentRegistrations::create([
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
    //==================================================DOWNSIDE OKAY

    // Show list of student registrations
    public function admin_registrations(Request $request)
    {

        $query = StudentRegistrations::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('fullname', 'like', "%{$search}%");
        }

        $registrations = $query->paginate(6)->withQueryString();

        if ($request->ajax()) {
            return view('admin.partials.registrations_table', compact('registrations'))->render();
        }

        return view('admin.registrations', compact('registrations'));
    }





    // Add new student registration
    public function admin_registrations_add(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255|unique:student_registrations,fullname',
        ]);

        try {
            // Create SubAdmin
            StudentRegistrations::create([
                'fullname' => $request->fullname,
            ]);

            // Redirect back with success message
            return back()->with('message', 'Student added successfully');
        } catch (\Exception $e) {
            // Redirect back with error message
            return back()->with('alert', 'Something went wrong: ' . $e->getMessage());
        }
    }

    //Delete sub admin
    public function delete_student($id)
    {
        StudentRegistrations::findOrFail($id)->delete();
        return back()->with('message', 'Student deleted successfully');
    }

    // Accounts
    public function admin_users(Request $request)
    {
        $passed = ExamResult::where('remarks', 'passed')->count();
        $failed = ExamResult::where('remarks', 'failed')->count();
        $pending = ExamResult::where('remarks', 'pending')->count();

        $query = SubAdmin::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $subAdmins = $query->paginate(6)->withQueryString();

        // 👉 If AJAX, return partial only
        if ($request->ajax()) {
            return view('admin.partials.subadmins-table', compact('subAdmins'))->render();
        }

        $notificationCount = AdminNotification::where('read', false)->count();

        return view('admin.users', compact('notificationCount', 'passed', 'failed', 'pending', 'subAdmins'));
    }


    public function search(Request $request)
    {
        $subAdmins = SubAdmin::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(6);

        return view('admin.partials.subadmins-table', compact('subAdmins'))->render();
    }



    //Add Sub admin account
    public function admin_users_add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sub_admins,name',
        ]);
        try {
            // Create SubAdmin
            SubAdmin::create([
                'name' => $request->name,
            ]);

            // Redirect back with success message
            return back()->with('message', 'Sub Admin added successfully');
        } catch (\Exception $e) {
            // Redirect back with error message
            return back()->with('alert', 'Something went wrong: ' . $e->getMessage());
        }
    }
    //Delete sub admin
    public function delete($id)
    {
        SubAdmin::findOrFail($id)->delete();
        return back()->with('message', 'Sub Admin deleted successfully');
    }




    // INTERVIEW
    public function interview(Request $request)
    {
        $query = StudentRegistrations::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('fullname', 'like', "%{$search}%");
        }

        $registrations = $query->paginate(6)->withQueryString();

        if ($request->ajax()) {
            return view('admin.partials.interview_table', compact('registrations'))->render();
        }
        return view('interview.index', compact('registrations'));
    }


    // Update the interview
    public function updateInterviewResult(Request $request, $id)
    {
        $registration = StudentRegistrations::findOrFail($id);

        // Compute overall rating (average of non-null ratings)
        $ratings = collect([
            $request->rating_communication,
            $request->rating_confidence,
            $request->rating_thinking,
        ])->filter()->map(fn($val) => (int) $val);

        $overall = $ratings->count() > 0 ? $ratings->avg() : null;
        $final_interview_result = (($overall * 100) / 5) * 0.2;

        $gwa_final = (($request->gwa * 100) / 100) * .3;
        $registration->update([
            'address'              => $request->address,
            'contact_details'      => $request->contact_details,
            'gwa'                  => $gwa_final,
            'school'               => $request->school,
            'strand'               => $request->strand,
            'rating_communication' => $request->rating_communication,
            'rating_confidence'    => $request->rating_confidence,
            'rating_thinking'      => $request->rating_thinking,
            'interview_result'       => $final_interview_result,
        ]);

        // Identify actor
        $actor = Auth::guard('admin')->check()
            ? Auth::guard('admin')->user()->fullname
            : (session('subadmin_name') ?? 'Unknown');

        // Log notification
        AdminNotif::create([
            'action' => "Saved interview result for {$registration->fullname}",
            'actor' => $actor,
        ]);

        return redirect()->back()->with('success', 'Interview details updated successfully.');
    }

    // Skill test
    public function skilltest(Request $request)
    {
        $query = StudentRegistrations::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('fullname', 'like', "%{$search}%");
        }

        $registrations = $query->paginate(6)->withQueryString();

        if ($request->ajax()) {
            return view('admin.partials.interview_table', compact('registrations'))->render();
        }
        return view('skilltest.index', compact('registrations'));
    }
    public function updateSkilltest(Request $request, $id)
    {
        $registration = StudentRegistrations::findOrFail($id);
        $final_skilltest = (($request->skilltest * 100) / 100) * .25;
        $registration->update([
            'skilltest' => round($final_skilltest, 2),
        ]);

        // Identify actor
        $actor = Auth::guard('admin')->check()
            ? Auth::guard('admin')->user()->fullname
            : (session('subadmin_name') ?? 'Unknown');

        // Log notification
        AdminNotif::create([
            'action' => "Saved skill test  for {$registration->fullname}",
            'actor' => $actor,
        ]);

        return redirect()->back()->with('success', 'Skilltest details updated successfully.');
    }



    public function notifications()
    {
        $notifications = AdminNotif::where('marked', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications', compact('notifications'));
    }

    public function markNotificationRead($id)
    {
        $notif = AdminNotif::findOrFail($id);
        $notif->marked = true;
        $notif->save();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }


    public function reports(Request $request)
    {
        $course = $request->query('course'); // BSIT, BSCS, BLIS
        $status = $request->query('status'); // passed, failed
        $rank = $request->query('rank'); // if set, sort by total desc

        $registrations = StudentRegistrations::query();

        if ($course) {
            $registrations->where('course', $course);
        }

        if ($status) {
            if ($status === 'passed') {
                $registrations->where('remarks', 'Passed');
            } elseif ($status === 'failed') {
                $registrations->where('remarks', 'Failed');
            }
        }

        if ($rank) {
            $registrations->orderByDesc('total');
        }

        $registrations = $registrations->get();

        return view('reports.index', compact('registrations', 'course', 'status', 'rank'));
    }


    public function smslogs()
    {
        return view('smslogs.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // logs out the admin

        $request->session()->invalidate(); // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('navigator')->with('status', 'Logged out successfully.');
    }
}
