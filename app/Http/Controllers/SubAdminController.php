<?php

namespace App\Http\Controllers;

use App\Models\SubAdmin;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    public function index()
    {
        return view('subadmin.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subadmin = SubAdmin::where('name', $request->name)->first();

        if (!$subadmin) {
            return back()->withErrors([
                'name' => 'Name not found !.',
            ])->withInput();
        }

        // Store subadmin in session
        session([
            'subadmin_name'   => $subadmin->name,
        ]);

        return redirect()->route('admin.interview');
    }

    // Dashboard
    public function dashboard()
    {
        return view('subadmin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('subadmin_name');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('navigator')->with('status', 'Logged out successfully.');
    }
}
