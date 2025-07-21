<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    //request auth es try catch
    private function changeStatus(Request $request, Booking $booking, bool $accepted) {
        if ($request->user() && Auth::guard('admin')->check()) {
            $booking->update(['accepted' => $accepted]);
        } else {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }

    public function accept(Request $request, Booking $booking) {
        $this->changeStatus($request, $booking, true);
    }

    public function deny(Request $request, Booking $booking) {
        $this->changeStatus($request, $booking, false);
    }

    public function verify() {
        dd("ok");
    }

    public function update(Request $request) {
        dd("pass");
    }

    public function destroy(Request $request) {
        dd("pass");
    }
}
