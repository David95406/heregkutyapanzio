<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $bookings = Booking::all()->makeHidden(['id', 'updated_at']);

        return inertia("Admin/Index", [
            "bookings" => $bookings
        ]);
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
