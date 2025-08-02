<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::all();
        
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

        $settings = Setting::all();

        return inertia("Admin/Settings/Index", [
            "settings" => $settings
        ]);
    }

    public function updateAbout1(Request $request) {
        try {
            $validatedRequest = $request->validate([
                "about1" => 'required|string|max:1400|min:1'
            ]);

            Setting::updateOrCreate(
                ['key' => 'about1'],
                ['value' => $validatedRequest['about1']]
            );

            return back()->with('message', 'Rólunk oldal 1. része sikeresen frissítve!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Hiba történt a frissítés során: ' . $e->getMessage()]);
        }
    }

    public function updateAbout2(Request $request) {
        try {
            $validatedRequest = $request->validate([
                "about2" => 'required|string|max:1400|min:1'
            ]);

            Setting::updateOrCreate(
                ['key' => 'about2'],
                ['value' => $validatedRequest['about2']]
            );

            return back()->with('message', 'Rólunk oldal 2. része sikeresen frissítve!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Hiba történt a frissítés során: ' . $e->getMessage()]);
        }
    }
}