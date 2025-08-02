<?php

namespace App\Http\Controllers;

use App\BookingUpdateTypeEnum;
use App\Mail\BookingAcceptedMail;
use App\Mail\BookingDeniedMail;
use App\Mail\BookingUpdatedMail;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminBookingController extends Controller
{
    private function changeStatus(Request $request, Booking $booking, bool $accepted) {
        if ($request->user() && Auth::guard('admin')->check()) {
            $booking->update(['accepted' => $accepted]);
        } else {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }

    private function sendSuccessBookingMail(Booking $booking) {
        try {
            Mail::to($booking->email)->send(new BookingAcceptedMail($booking));
            return redirect()->back()->with('success', 'Foglalás elfogadva és email értesítés elküldve.');
        } catch (\Exception $e) {
            Log::error('Hiba a foglalás elfogadó email küldésekor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'A foglalás elfogadva, de az email küldése sikertelen.');
        }
    }

    private function sendDeniedBookingMail(Booking $booking) {
        try {
            Mail::to($booking->email)->send(new BookingDeniedMail($booking));
            return redirect()->back()->with('success', 'Foglalás elutasítva és értesítő email elküldve.');
        } catch (\Exception $e) {
            Log::error('Hiba a foglalás elutasító email küldésekor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'A foglalás elutasítva, de az értesítő email küldése sikertelen.');
        }
    }

    public function accept(Request $request, Booking $booking) {
        $this->changeStatus($request, $booking, true);
        $this->sendSuccessBookingMail($booking);
    }

    public function deny(Request $request, Booking $booking) {
        $this->changeStatus($request, $booking, false);
        $this->sendDeniedBookingMail($booking);
    }

    public function update(Request $request, Booking $booking) {
        $validatedRequest = $request->validate([
            "field" => 'required|string',
            "value" => 'required'
        ]);

        try {
            $field = BookingUpdateTypeEnum::from($validatedRequest['field']);
        } catch (\ValueError $e) {
            return redirect()->back()->with('error', 'Érvénytelen mező');
        }

        $isEmail = false;

        switch ($field) {
            case BookingUpdateTypeEnum::START_DATE:
            case BookingUpdateTypeEnum::END_DATE:
                if (!strtotime($validatedRequest['value'])) {
                    return redirect()->back()->with('error', 'Érvénytelen dátum formátum');
                }
                $isEmail = true; // egyenlore csak datum valtozas utan kuldunk ujra emailt, mas esetben nem
                break;
        }

        $booking->update([$field->value => $validatedRequest['value']]);

        if ($isEmail) {
            try {
                Mail::to($booking->email)->send(new BookingUpdatedMail($booking, $field->value));
            } catch (\Exception $e) {
                Log::error('Hiba a foglalás frissítéséről szóló email küldésekor: ' . $e->getMessage());
                return redirect()->back()->with('warning', 'A foglalás frissítve, de az értesítő email küldése sikertelen.');
            }
        }

        return redirect()->back()->with('success', 'A foglalás sikeresen frissítve!');
    }

    public function destroy(Request $request) {
        dd("pass");
    }
}
