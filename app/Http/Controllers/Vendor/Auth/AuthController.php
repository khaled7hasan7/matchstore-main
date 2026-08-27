<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $vendorService;

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('vendor')->attempt($request->only('email', 'password'))) {
            if (Auth::guard('vendor')->user()->status !== 'active') {
                Auth::guard('vendor')->logout();

                return back()->with('error', 'Your account is not active. Please contact support.');
            }

            $request->session()->regenerate();

            return redirect()->route('vendor.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }

    public function dashboard()
    {
        return view('vendor.dashboard');
    }
}
