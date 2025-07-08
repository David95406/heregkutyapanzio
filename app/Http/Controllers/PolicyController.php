<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function aszf() {
        return inertia("Aszf/Index");
    }

    public function privacy() {
        return inertia("PrivacyPolicy/Index");
    }
}
