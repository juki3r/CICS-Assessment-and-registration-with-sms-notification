<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\EntranceExam;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Mail\GeneralNotification;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'course' => ['required', Rule::in(['bsit', 'bscs', 'blis'])],
            'password' => [
                        'required',
                        'confirmed',
                        Rules\Password::min(8)
                    ],
        ]);

        // Let's verify first if this student already pass the entrance exam
        // Lets create a dashboard later for entrance exam admin
        // for now, lets override it first.

        $exists = EntranceExam::where('fullname', $request->fullname)->exists();

        if ($exists) {
            $student = EntranceExam::where('fullname', $request->fullname)->first();
            if ($student->status == 'pending') {
                return back()->with('message', 'Your exam status is still pending. Please wait for the result.');
            }else if ($student->status == 'failed') {
                return back()->with('message', 'You failed exam. Better luck next time');
            }else{

                $user = User::create([
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'course' => $request->course,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                

                //ADD to admin notify
                $user = User::where('fullname', $request->fullname)->first();
                if($user){
                    AdminNotification::create([
                        'user_id' => $user->id,
                        'category' => 'registration',
                        'message' => 'New student registered. Name: ' . $request->fullname . ' | Course: ' . $request->course,
                    ]);
                }

                event(new Registered($user));

                Auth::login($user);

                return redirect(route('dashboard'));
            }

        } else {
            // Student does not exist
            return back()->with('message', 'Upon checking, your name is not found!');
        }



        
    }
}
