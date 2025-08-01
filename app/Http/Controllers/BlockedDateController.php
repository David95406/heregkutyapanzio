<?php

namespace App\Http\Controllers;

use App\Models\BlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlockedDateController extends Controller
{
    public function index(Request $request) {
        $blockedDates = BlockedDate::all();

        return inertia("Admin/BlockedDates/Index", [
            "blockedDates" => $blockedDates
        ]);
    }

    public function store(Request $request) {
        try {
            // Validate the request
            $validated = $request->validate([
                'dates' => 'required|array',
                'dates.*' => 'required|date_format:Y-m-d',
            ]);

            // Create BlockedDate for each date in the array
            foreach ($validated['dates'] as $dateString) {
                BlockedDate::firstOrCreate(['date' => $dateString]);
            }

            return redirect()->back()->with('success', 'Dates blocked successfully');
        } catch (\Exception $e) {
            Log::error('Error blocking dates: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to block dates');
        }
    }
    
    public function destroy(Request $request, $blocked_date = null) {
        try {
            if ($blocked_date === "all") {
                // Delete all dates
                BlockedDate::truncate();
                return redirect()->back()->with('success', 'All blocked dates have been reset');
            } else if (is_numeric($blocked_date)) {
                // Delete by ID
                $found = BlockedDate::find($blocked_date);
                if ($found) {
                    $found->delete();
                    return redirect()->back()->with('success', 'Date has been unblocked');
                }
                return redirect()->back()->with('error', 'Date not found');
            } else if ($blocked_date) {
                // Delete by date string
                $count = BlockedDate::where('date', $blocked_date)->delete();
                if ($count > 0) {
                    return redirect()->back()->with('success', 'Date has been unblocked');
                }
                return redirect()->back()->with('error', 'Date not found');
            }
            
            return redirect()->back()->with('error', 'Invalid date provided');
        } catch (\Exception $e) {
            Log::error('Error deleting blocked date: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while unblocking date');
        }
    }
}