<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $staff = Staff::where('username', $credentials['username'])->first();
        if ($staff && $staff->status === 'inactive') {
            return back()->withErrors([
                'username' => 'Your account has been deactivated. Please contact the administrator.',
            ])->onlyInput('username');
        }

        if (Auth::guard('staff')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('staff.dashboard');
        }

        $admin = Admin::where('username', $credentials['username'])->first();
        if ($admin && $admin->status === 'inactive') {
            return back()->withErrors([
                'username' => 'Your account has been deactivated. Please contact the administrator.',
            ])->onlyInput('username');
        }

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
