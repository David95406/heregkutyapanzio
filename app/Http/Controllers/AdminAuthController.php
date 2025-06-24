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
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Sikeres bejelentkezés, átirányítás az admin dashboard-ra
            return redirect()->intended(route('admin.dashboard'));
        }

        // Sikertelen bejelentkezés
        return back()->withErrors([
            'email' => 'A megadott adatok érvénytelenek.',
        ]);
    }

    /**
     * Kijelentkezés kezelése (ha szükséges)
     */
    public function logout(Request $request)
    {
        $request->auth()::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
