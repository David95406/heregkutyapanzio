<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;

class AdminAuthController extends Controller
{
    public function index() {
        return inertia("Admin/Auth/Index");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => "required|min:4|max:200|string",
            'password' => "required|min:4|max:200|string",
            'remember_me' => "boolean" // piotr!
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.index'));
        }

        return back()->withErrors([
            'username' => 'A megadott adatok érvénytelenek.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
