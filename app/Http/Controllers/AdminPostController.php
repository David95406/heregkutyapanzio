<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index(Request $request) {
        return inertia("Admin/Posts/index");
    }

    public function store(Request $request) {
        return;
    }

    public function update(Request $request) {
        return;
    }

    public function destroy(Request $request) {
        return;
    }
}
