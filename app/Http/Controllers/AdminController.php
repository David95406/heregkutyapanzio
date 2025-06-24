<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return inertia("Admin/Index");
    }

    public function settings(Request $request) {
        return inertia("Admin/Settings/Index");
    }

    function destroy(Request $request) {
        $request->auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
