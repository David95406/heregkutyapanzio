<?php

namespace App\Http\Controllers;

use App\Mail\BookingAdminMail;
use App\Mail\VerifyBooking;
use App\Models\BlockedDate;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index() {
        $blockedDates = BlockedDate::pluck('date');

        return inertia("Booking/Index", [
            "blockedDates" => $blockedDates
        ]);
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'description' => 'nullable|string',
                'start_date' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                    'before_or_equal:'.now()->addMonths(2)->format('Y-m-d')
                ],
                'end_date' => [
                    'required',
                    'date',
                    'after_or_equal:start_date',
                    'before_or_equal:'.now()->addMonths(2)->format('Y-m-d')
                ],
            ]);

            $isBlocked = BlockedDate::whereDate('date', '>=', $validatedData['start_date'])
                                    ->whereDate('date', '<=', $validatedData['end_date'])
                                    ->exists();

            if ($isBlocked) {
                return redirect()->back()->withErrors(['error' => 'A kiválasztott időszakban van olyan nap, ami nem foglalható.'])->withInput();
            }

            $bookingData = $validatedData + [
                'accepted' => null,
                'verification_token' => Str::uuid()->toString(),
            ];

            $booking = Booking::create($bookingData);
        
            // email kuldes
            try {
                // Mail::to($validatedData['email'])->send(new TestEmail($validatedData['name']));
                Mail::to($booking->email)->send(new VerifyBooking($booking));
            } catch (Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Foglalás sikeresen elküldve!');
        }  catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hiba történt a foglalás során. Kérjük, próbálja újra.');
        }
        
    }

    public function verify(Request $request, $token)
    {
        if (! $request->hasValidSignature()) {
            return redirect('/')->with('error', 'Érvénytelen vagy lejárt megerősítő link.');
        }

        $booking = Booking::where('verification_token', $token)->firstOrFail();

        $booking->forceFill([
            'verified_at' => now(),
            'verification_token' => null,
        ])->save();

        // Admin értesítése az új megerősített foglalásról
        try {
            Mail::to("adrianjozsa@gmail.com") //config('app.admin_email', 'admin@heregkutyapanzio.hu')
                ->send(new BookingAdminMail($booking));
        } catch (\Exception $e) {
            // Csak naplózza a hibát, de ne szakítsa meg a foglalást
            Log::error('Admin értesítés küldése sikertelen: ' . $e->getMessage());
        }

        //return redirect('/')->with('success', 'Foglalását sikeresen megerősítette! Hamarosan felvesszük Önnel a kapcsolatot.');
        return inertia('Booking/Verified/Index', [
            'booking' => $booking
        ]);
    }

    /*
    public function update(Request $request) {
        dd($request);
    }

    public function destroy(Request $request) {
        dd($request);
    }
        */
}
