<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::all();

        // Ensure about1 and about2 settings exist with default values if not present
        if (!$settings->contains('key', 'about1')) {
            Setting::create([
                'key' => 'about1',
                'value' => 'Üdvözöljük a Héreg Kutyapanzió oldalán!'
            ]);
        }
        
        if (!$settings->contains('key', 'about2')) {
            Setting::create([
                'key' => 'about2',
                'value' => 'Kutyapanziónk szeretettel várja kedvencét.'
            ]);
        }

        // Refresh settings after ensuring they exist
        $settings = Setting::all();

        return inertia("Admin/Settings/Index", [
            "settings" => $settings
        ]);
    }

    public function updateAbout1(Request $request) {
        $validatedRequest = $request->validate([
            "about1" => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'about1'],
            ['value' => $validatedRequest['about1']]
        );

        return back()->with('message', 'Rólunk oldal 1. része sikeresen frissítve!');
    }

    public function updateAbout2(Request $request) {
        $validatedRequest = $request->validate([
            "about2" => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'about2'],
            ['value' => $validatedRequest['about2']]
        );

        return back()->with('message', 'Rólunk oldal 2. része sikeresen frissítve!');
    }

    public function changePassword(Request $request) {
        $validatedRequest = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $admin = Auth::guard('admin')->user();
        
        if (!$admin) {
            return back()->withErrors(['password' => 'Nem sikerült azonosítani a felhasználót.']);
        }
        
        $admin->password = Hash::make($validatedRequest['password']);
        $admin->save();

        return back()->with('message', 'Jelszó sikeresen módosítva!');
    }
}