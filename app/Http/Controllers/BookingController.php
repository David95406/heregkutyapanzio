<?php

namespace App\Http\Controllers;

use App\Models\BlockedDate;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;

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
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $isBlocked = BlockedDate::whereDate('date', '>=', $validatedData['start_date'])
                                     ->whereDate('date', '<=', $validatedData['end_date'])
                                     ->exists();

            if ($isBlocked) {
                return redirect()->back()->withErrors(['date' => 'A kiválasztott időszakban van olyan nap, ami nem foglalható.'])->withInput();
            }

            Booking::create($validatedData + ['accepted' => false]);
        
            return redirect()->back()->with('success', 'Foglalás sikeresen elküldve!');
        }  catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hiba történt a foglalás során. Kérjük, próbálja újra.');
        }
        
    }
}
