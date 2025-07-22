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
        dd("store");
    }
    
    public function destroy(Request $request) {
        dd("destroy");
    }
}
