<?php

namespace App\Http\Controllers;

use App\Models\BlockedDate;
use Illuminate\Http\Request;

class BlockedDateController extends Controller
{
    public function index(Request $request) {
        $blockedDates = BlockedDate::pluck('date');

        return inertia("Admin/BlockedDates/Index", [
            "blockedDates" => $blockedDates
        ]);
    }

    public function store(Request $request) {
        // Validate the request
        $validated = $request->validate([
            'dates' => 'required|array',
            'dates.*' => 'required|date_format:Y-m-d',
        ]);

        // Create BlockedDate for each date in the array
        $timezone = new \DateTimeZone(config('app.timezone'));
        
        foreach ($validated['dates'] as $dateString) {
            $date = \DateTime::createFromFormat('Y-m-d', $dateString, $timezone);
            $date->setTime(0, 0, 0);
            
            BlockedDate::firstOrCreate(['date' => $date->format('Y-m-d')]);
        }

        return redirect()->back()->with('success', 'Dates blocked successfully');
    }
    
    public function destroy(Request $request) {
        // Delete all blocked dates
        BlockedDate::truncate();
        
        return redirect()->back()->with('success', 'All blocked dates have been reset');
    }
}
