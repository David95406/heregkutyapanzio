<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        return inertia("Admin/Settings/Index");
    }

    public function updateGraphApiKey(Request $request) {
        $validatedRequest = $request->validate([
            "graphApiKey" => 'required|string'
        ]);

        Setting::where('key', 'graphApiKey')
            ->update(['value' => $validatedRequest['graphApiKey']]);

        return back()->with('message', 'Graph API kulcs sikeresen frissítve!');
    }
}
