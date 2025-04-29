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
            'address' => ['required'],
            'age' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'phone_number' => ['required', 'max:11', 'unique:users,phone_number'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'course' => ['required', Rule::in(['bsit', 'bscs', 'blis'])],
            'password' => [
                        'required',
                        'confirmed',
                        Rules\Password::min(8)
                            ->letters()
                            ->mixedCase() // Requires uppercase and lowercase letters
                            ->numbers() // Requires at least one number
                            ->symbols(), // Requires at least one special character (optional)
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
                // Store image in "students/{id}" folder
                $folderName = 'students/' . $student->id;
                $imagePath = $request->file('image')->store($folderName, 'public');
                $randomCode = rand(100000, 999999);
                $user = User::create([
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'age' => $request->age,
                    'course' => $request->course,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'image' => $imagePath,
                    'otp' => $randomCode,
                ]);

                
                //Send Email to admin
                Mail::to('deepong25@gmail.com')->send(
                    new GeneralNotification('New student registered', 'New student register named  and need your approval. Please login and verify new student
                    at http://127.0.0.1:8000/login')
                );
                //Add here for sms
                 

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
