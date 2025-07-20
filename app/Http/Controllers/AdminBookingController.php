<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    //request auth es try catch
    private function changeStatus(Booking $booking, bool $accepted) {
        $booking->update(['accepted' => $accepted]);
    }

    public function accept(Request $request, Booking $booking) {
        $this->changeStatus($booking, true);
    }

    public function deny(Request $request, Booking $booking) {
        $this->changeStatus($booking, false);
    }

    public function update(Request $request) {
        dd("pass");
    }

    public function destroy(Request $request) {
        dd("pass");
    }
}
