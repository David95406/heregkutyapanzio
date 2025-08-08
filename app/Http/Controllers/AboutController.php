<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        $aboutTexts = Setting::whereIn('key', ['about1', 'about2'])->pluck('value', 'key');

        if ($aboutTexts->isEmpty()) {
            return inertia("About/Index");
        }

        return inertia("About/Index", [
            "about1" => $aboutTexts['about1'],
            "about2" => $aboutTexts['about2']
        ]);
    }
}
