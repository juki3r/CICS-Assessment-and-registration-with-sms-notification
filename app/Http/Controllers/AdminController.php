<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Timer;
use App\Models\Admins;
use App\Models\SmsLogs;
use App\Models\SubAdmin;
use App\Models\AdminNotif;
use App\Models\ExamResult;
use App\Models\EntranceExam;
use Illuminate\Http\Request;
use App\Mail\GeneralNotification;
use App\Models\AdminNotification;
use App\Models\ScoringPercentage;
use App\Models\StudentRegistrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AdminController extends Controller
{




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

    // public function dashboard()
    // {
    //     if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin') {
    //         $notificationCount = AdminNotification::where('read', false)->count();
    //         return view('admin.dashboard', compact('notificationCount'));
    //     }

    //     // if not admin, redirect somewhere else
    //     return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
    // }


    // public function dashboard()
    // {
    //     if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
    //         return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
    //     }

    //     // Count students by course and remarks
    //     $courses = ['BSIT', 'BSCS', 'BLIS'];
    //     $chartData = [];
    //     $currentYear = Carbon::now()->year;

    //     foreach ($courses as $course) {
    //         $chartData[$course] = [
    //             'passed' => StudentRegistrations::where('course', $course)->where('remarks', 'Passed')->count(),
    //             'failed' => StudentRegistrations::where('course', $course)->where('remarks', 'Failed')->count(),
    //             'pending' => StudentRegistrations::where('course', $course)->whereNull('remarks')->count(),
    //         ];
    //     }

    //     return view('admin.dashboard', compact('chartData'));
    // }


    public function dashboard()
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        // Count students by course and remarks
        $courses = ['BSIT', 'BSCS', 'BLIS'];
        $chartData = [];
        $currentYear = Carbon::now()->year; // 🔥 current year filter

        foreach ($courses as $course) {
            $chartData[$course] = [
                'passed' => StudentRegistrations::where('course', $course)
                    ->whereYear('created_at', $currentYear)
                    ->where('remarks', 'Passed')
                    ->count(),

                'failed' => StudentRegistrations::where('course', $course)
                    ->whereYear('created_at', $currentYear)
                    ->where('remarks', 'Failed')
                    ->count(),

                'pending' => StudentRegistrations::where('course', $course)
                    ->whereYear('created_at', $currentYear)
                    ->whereNull('remarks')
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact('chartData', 'currentYear'));
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

        // Filter for the current year
        $query->whereYear('created_at', Carbon::now()->year);


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

        // Filter for the current year
        $query->whereYear('created_at', Carbon::now()->year);


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

        // Get scoring percentage (assume only one record)
        $scoring = ScoringPercentage::first();

        // Fallback if table empty
        $examWeight_interview = $scoring->interview ?? 0.20;

        $overall = $ratings->count() > 0 ? $ratings->avg() : null;
        $final_interview_result = (($overall * 100) / 5) * $examWeight_interview;

        $examWeight_gwa = $scoring->gwa ?? 0.30;
        $gwa_final = (($request->gwa * 100) / 100) * $examWeight_gwa;
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

        // Filter for the current year
        $query->whereYear('created_at', Carbon::now()->year);


        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('fullname', 'like', "%{$search}%");
        }

        $registrations = $query->paginate(6)->withQueryString();

        if ($request->ajax()) {
            return view('admin.partials.skilltest_table', compact('registrations'))->render();
        }
        return view('skilltest.index', compact('registrations'));
    }
    public function updateSkilltest(Request $request, $id)
    {
        $registration = StudentRegistrations::findOrFail($id);

        // Get scoring percentage (assume only one record)
        $scoring = ScoringPercentage::first();

        // Fallback if table empty
        $examWeight_skilltest = $scoring->skilltest ?? 0.25;

        $final_skilltest = ($request->skilltest / 10) * $examWeight_skilltest;
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
        // Unread notifications
        $unreadNotifications = AdminNotif::where('marked', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Read notifications
        $readNotifications = AdminNotif::where('marked', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications', compact('unreadNotifications', 'readNotifications'));
    }


    public function markNotificationRead($id)
    {
        $notif = AdminNotif::findOrFail($id);
        $notif->marked = true;
        $notif->save();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }


    // public function reports(Request $request)
    // {
    //     $course = $request->query('course'); // BSIT, BSCS, BLIS
    //     $status = $request->query('status'); // passed, failed
    //     $rank = $request->query('rank'); // if set, sort by total desc

    //     $registrations = StudentRegistrations::query();

    //     if ($course) {
    //         $registrations->where('course', $course);
    //     }

    //     if ($status) {
    //         if ($status === 'passed') {
    //             $registrations->where('remarks', 'Passed');
    //         } elseif ($status === 'failed') {
    //             $registrations->where('remarks', 'Failed');
    //         }
    //     }

    //     if ($rank) {
    //         $registrations->orderByDesc('total');
    //     }

    //     $registrations = $registrations->get();

    //     return view('reports.index', compact('registrations', 'course', 'status', 'rank'));
    // }

    public function reports(Request $request)
    {
        $course = $request->query('course'); // BSIT, BSCS, BLIS
        $status = $request->query('status'); // passed, failed
        $rank = $request->query('rank');     // if set, sort by total desc
        $print = $request->query('print');   // if set, print-friendly

        $registrations = StudentRegistrations::query();

        $registrations->whereYear('created_at', Carbon::now()->year);


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
        } else {
            // Default alphabetical sort when no ranking is applied
            $registrations->orderBy('fullname', 'asc');
        }

        if ($print) {
            $registrations->where('remarks', 'Passed')->orderBy('fullname', 'asc'); // alphabetical
        }

        $registrations = $registrations->get();

        return view('reports.index', compact('registrations', 'course', 'status', 'rank', 'print'));
    }





    public function smslogs(Request $request)
    {
        $course = $request->query('course', 'BSIT'); // BSIT, BSCS, BLIS
        $status = $request->query('status', 'passed'); // passed, failed
        $print = $request->query('print');   // if set, print-friendly

        $registrations = SmsLogs::query();

        $registrations->whereYear('created_at', Carbon::now()->year);

        if ($course) {
            $registrations->where('course', $course);
        }

        // if ($status) {
        //     if ($status === 'passed') {
        //         $registrations->where('remarks', 'Passed');
        //     } elseif ($status === 'failed') {
        //         $registrations->where('remarks', 'Failed');
        //     }
        // }


        // if ($print) {
        //     $registrations->where('remarks', 'Passed')->orderBy('fullname', 'asc'); // alphabetical
        // }

        $registrations = $registrations->get();

        return view('smslogs.index', compact('registrations', 'course'));
    }

    public function sent(Request $request)
    {
        $course = $request->query('course', 'BSIT'); // BSIT, BSCS, BLIS
        $status = $request->query('status', 'passed'); // passed, failed
        $rank = $request->query('rank');     // if set, sort by total desc
        $print = $request->query('print');   // if set, print-friendly

        $registrations = StudentRegistrations::query();
        $registrations->whereYear('created_at', Carbon::now()->year);

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
        } else {
            // Default alphabetical sort when no ranking is applied
            $registrations->orderBy('fullname', 'asc')->where('remarks', 'Passed');;
        }


        if ($print) {
            $registrations->where('remarks', 'Passed')->orderBy('fullname', 'asc'); // alphabetical
        }

        $registrations = $registrations->get();

        return view('smslogs.sent', compact('registrations', 'course', 'status', 'print', 'rank'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // logs out the admin

        $request->session()->invalidate(); // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('navigator')->with('status', 'Logged out successfully.');
    }


    public function sendSmsFromClient(Request $request)
    {
        $request->validate([
            'selected' => 'required|array|min:1'
        ]);

        $apiKey   = 'TqAQpf9H7OO3ooYk0Vp48FbWFf2SXCzZW9nP750R';
        $endpoint = 'https://sms.pong-mta.tech/api/send-sms-api';

        $selectedIds    = $request->input('selected');
        $registrations  = StudentRegistrations::whereIn('id', $selectedIds)->get();

        $results = [];

        foreach ($registrations as $student) {
            $name  = $student->fullname;
            $phone = $student->contact_details;
            $course = $student->contact_details;

            $message = "Hi Good Day! Congratulations {$name}, you are qualified incoming
                        First year student in {$student->course} A.Y 2025-2026. Dont reply because this is system generated";

            $response = Http::withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept'    => 'application/json',
            ])->post('https://sms.pong-mta.tech/api/send-sms-api', [
                'phone_number' => $phone,
                'message'      => $message,
            ]);

            SmsLogs::Create(
                [
                    'name' => $name,
                    'mobile_number' => $phone,
                    'message' => $message,
                    'status'  => 'sent',
                    'course'       => $student->course,
                ]
            );

            $results[] = [
                'student' => $name,
                'phone'   => $phone,
                'status'  => $response->successful() ? 'queued' : 'failed',
                'details' => $response->json(),
            ];
        }

        return redirect()->back()
            ->with('message', 'SMS sent to selected students.')
            ->with('results', $results);
    }

    //Edit timer

    public function editTimer(Request $request)
    {
        $request->validate([
            'timer' => 'required',
        ]);

        $dataTimer = $request->timer * 60;

        Timer::updateOrCreate(
            ['id' => 1],            // first row
            ['timer' => $dataTimer]
        );

        return redirect()->route('questions.index')->with('success', 'Timer edit successful!');
    }


    //Archives
    public function archives(Request $request)
    {
        $course = $request->query('course');
        $rank   = $request->query('rank');
        $print  = $request->query('print');

        // Default year is the current year
        $year   = $request->query('year', date('Y'));

        $registrations = StudentRegistrations::query();

        // Always show only "Passed"
        $registrations->where('remarks', 'Passed');

        if ($course) {
            $registrations->where('course', $course);
        }

        // Filter by selected year
        if ($year) {
            $registrations->whereYear('created_at', $year);
        }

        if ($rank) {
            $registrations->orderByDesc('total');
        } else {
            $registrations->orderBy('fullname', 'asc');
        }

        if ($print) {
            $registrations->orderBy('fullname', 'asc');
        }

        $registrations = $registrations->get();

        // Generate a simple list of 5 years: current year + previous 4 years
        $currentYear = date('Y');
        $years = collect(range($currentYear, $currentYear - 4));

        return view('archives.index', compact('registrations', 'course', 'rank', 'print', 'year', 'years'))
            ->with('status', 'passed');
    }
}
