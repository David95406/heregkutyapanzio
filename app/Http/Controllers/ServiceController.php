<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::all();

        return inertia("Admin/Services/Index", [
            "services" => $services
        ]);
    }

    public function update(Request $request, $service) {
        try {
            $validated = $request->validate([
                'price' => 'required|integer|min:0',
            ]);
        } catch (Exception $e) {
            dd($e);
        }
        

        $updatedService = Service::find($service);
        $updatedService->price = $validated['price'];
        $updatedService->save();

        return redirect()->back()->with('success', 'Szolgáltatás sikeresen frissítve!');
    }
}
