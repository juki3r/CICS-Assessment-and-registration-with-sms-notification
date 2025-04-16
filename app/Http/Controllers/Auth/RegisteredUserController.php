<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EntranceExam;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
            'phone_number' => ['required', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
                return back()->with('message', 'Better luck next time');
            }else{
                $user = User::create([
                    'fullname' => $request->fullname,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                event(new Registered($user));

                Auth::login($user);

                return redirect(route('dashboard'));
            }

        } else {
            // Student does not exist
            return back()->with('message', 'Your name not found.');
        }



        
    }
}
