<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $validatedRequest = $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            ]);

            $admin = Auth::guard('admin')->user();

            if (!$admin) {
                return back()->withErrors(['password' => 'Nem sikerült azonosítani a felhasználót.']);
            }
            
            $admin->password = Hash::make($validatedRequest['password']);
            $admin->save();

            $AdminAuthController = new AdminAuthController();
            $AdminAuthController->logout($request);
            return back()->with('message', 'Jelszó sikeresen módosítva!');
        } catch (Exception $e) {
            Log::error('Error changing password: ' . $e->getMessage());
            return back()->withErrors(['password' => 'Hiba történt a jelszó módosítása során.']);
        }
    }

    function destroy(Request $request) {
        auth()->logout(); // csak vscode szerint error!
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
