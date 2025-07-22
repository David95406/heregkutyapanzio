<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index() {
        $bookings = Booking::all()->makeHidden(['updated_at', 'verification_token']);

        return inertia("Admin/Index", [
            "bookings" => $bookings
        ]);
    }

    public function changePassword(Request $request) {
        try {
            $validatedData = $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            ]);

            $user = $request->user();
            $user->password = Hash::make($validatedData['password']);
            $user->save();


            //return back()->with('message', 'Password updated successfully');
            $this->destroy($request);
        } catch (Exception $e) {
            Log::error('Error changing password: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['error' => 'Failed to update password. Please try again.']);
        }
        
    }

    function destroy(Request $request) {
        auth()->logout(); // csak vscode szerint error!
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
