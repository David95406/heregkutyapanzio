<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {

        $graphApiData = array();

        return inertia("Index/Index", [
            "graphApiData" => $graphApiData
        ]);
    }
}
